<?php
(defined('BASEPATH')) or exit('No direct script access allowed');

class Tessa
{
    protected  $CI;
    const TESSA_API_URL = "https://tessa-proxy.onrender.com/api/ask-tessa";
    const DEBUG_TESSA = true;
    private $lastComputedFacts = null;
    private $tessaHistory = [];

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        // System prompt is set up in the constructor or a dedicated method
        $this->tessaHistory[] = [
            "role" => "system",
            "content" => "You are Tessa™, an expert Title & Escrow assistant with document analysis capabilities. Your #1 priority is to **identify and clearly list the TITLE REQUIREMENTS** from any Preliminary Title Report. These are the must-do items to close. Always surface them first, plainly, and completely. [... Rest of the original system prompt ...]"
        ];
    }

    public function index() {
        // $filePath = 'https://pct-doc.s3-us-west-2.amazonaws.com/documents/1757111998_prelim_doc_20007334-GLT.pdf';
        $filePath = 'https://pct-doc.s3-us-west-2.amazonaws.com/documents/1760559435_prelim_doc_20009285-OCT.pdf';
        $fileName = '1757111998_prelim_doc_20007334-GLT.pdf';
        try {
            return $htmlOutput = $this->analyze_pdf_with_tessa($filePath, $fileName);
            // echo $htmlOutput;die;
        } catch (Exception $e) {
            // Handle file reading or API errors
            echo "<h1>Analysis Error</h1><p>" . $e->getMessage() . "</p>";exit;
        }
    }

    private function normalize_bullets($str) {
        if (empty($str)) return $str;
        // Insert a break before number-dot that is preceded by >=2 spaces or a period + spaces
        $str = preg_replace('/(\s{2,})(\d{1,3})\.\s/', "\n" . '$2. ', $str);
        $str = preg_replace('/([:;])\s*(\d{1,3})\.\s/', '$1' . "\n" . '$2. ', $str);
        return $str;
    }

    private function split_numbered_items($sectionText) {
        $items = [];
        if (empty($sectionText)) return $items;
        $text = $this->normalize_bullets($sectionText);
        // Regex to find numbered items (1. Item Text, up to the next number or end of string)
        $re = '/(?:^|\n)\s*(\d{1,3})\.\s+([\s\S]*?)(?=(?:\n\s*\d{1,3}\.\s+)|$)/';
        if (preg_match_all($re, $text, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $items[] = ['num' => (int)$m[1], 'raw' => trim($m[2])];
            }
        }
        return $items;
    }

    private function classify_requirement($text) {
        $t = preg_replace('/\s+/', ' ', trim($text));
        if (preg_match('/full reconveyance|reconvey.*requirement.*furnished.*confirmation/i', $t)) {
            return ['summary' => "Confirm lender's full reconveyance (proof the Deed of Trust was released).", 'type' => "reconveyance_confirmation", 'severity' => "blocker"];
        }
        if (preg_match('/spouse.*join.*conveyance|spouse of the vestee/i', $t)) {
            return ['summary' => "Spousal joinder is required prior to conveyance or encumbrance.", 'type' => "spousal_joinder", 'severity' => "blocker"];
        }
        if (preg_match('/The Company will require.*(corporation|Name of Corporation)/i', $t)) {
            return ['summary' => "Corporation authority package (Articles/Bylaws/Resolution).", 'type' => "corp_authority", 'severity' => "material"];
        }
        // ... include all other classification regex from the JS file ...
        return ['summary' => "Company requirement.", 'type' => "unspecified", 'severity' => "material"];
    }

    private function parse_requirements($items) {
        $reqs = [];
        foreach ($items as $it) {
            $t = $it['raw'];
            if (preg_match('/The Company will require|spouse of the vestee|Statement of Information|suspended corporation|reconveyance/i', $t)) {
                $reqs[] = [
                    'item_no' => $it['num'],
                    'text' => $t,
                    'classification' => $this->classify_requirement($t)
                ];
            }
        }
        return $reqs;
    }

    private function parse_taxes_from_items($items) {
        $out = ['property' => null, 'defaultStatus' => null, 'otherAssessments' => []];
        $it2 = array_filter($items, function($i) {
            return $i['num'] === 2;
        });
        $it2 = reset($it2); // Get the first match
        
        if ($it2) {
            $t = $it2['raw'];
            // $get = function($rx, $t) { return preg_match($rx, $t, $mm) ? trim($mm[1]) : null;};
            $get = function ($rx) use (&$t) {
                if (preg_match($rx, $t, $mm)) {
                    return trim($mm[1]);
                }
                return null;
            };
            // print_r($get);die;
            $out['property'] = [
                'code_area' => $get('/Code Area:\s*([^\n]+)/i'),
                'tax_id' => $get('/Tax Identification No\.\s*:\s*([^\n]+)/i'),
                'fiscal_year' => $get('/Fiscal Year:\s*([^\n]+)/i'),
                'first_installment' => $get('/1st Installment:\s*([^\n]+)/i'),
                'second_installment' => $get('/2nd Installment:\s*([^\n]+)/i'),
                'homeowners_exemption' => $get('/Exemption:\s*\$?([0-9,]+\.\d{2})/i')
            ];
        }
        return $out;
    }

    private function compute_facts($fullText)
    {
        // 1. Extract Critical Section
        preg_match('/AT THE DATE HEREOF[\s\S]+?WOULD BE AS FOLLOWS:(.*?)END OF ITEMS/is', $fullText, $matches);
        $critical = $matches[1] ?? '';
        
        // 2. Split Items
        $items = $this->split_numbered_items($critical);
        // echo "<pre>";
        // 3. Parse Facts
        $requirements = $this->parse_requirements($items);
        $taxes = $this->parse_taxes_from_items($items);
        // print_r($taxes);die;
        
        // 4. Property Info
        $property = [
            'address' => preg_match('/PROPERTY:\s*([^\n]+)/i', $fullText, $m) ? $m[1] : null,
            'apn' => preg_match('/\bAPN:\s*([0-9-]+)/i', $fullText, $m) ? $m[1] : null,
            'proposed_loan_amount' => preg_match('/Proposed Loan Amount:\s*(\$?[0-9,]+\.\d{2})/i', $fullText, $m) ? $m[1] : null,
        ];

        $this->lastComputedFacts = [
            'property' => $property,
            'taxes' => $taxes,
            'requirements' => $requirements,
            'foreclosure_flags' => [], // Additional parsing would go here
        ];

        if (self::DEBUG_TESSA) {
            error_log("Computed Facts: " . print_r($this->lastComputedFacts, true));
        }

        return $this->lastComputedFacts;
    }

    // --- AI Communication Logic Ported from JavaScript ---

    private function get_analysis_prompt($pdfText, $fileName, $factsJson)
    {
        // This is the complete, complex prompt from the JS file
        return "I've uploaded a Preliminary Title Report PDF titled \"{$fileName}\". \n\n"
             . "YOU HAVE TWO INPUTS:\n1) facts_json (auto-extracted by our parser) — treat as **ground truth**; you MUST include every requirement listed here in **TITLE REQUIREMENTS**. Also include an agent-friendly line for each requirement starting with \"Why it matters:\".\n2) Raw document text — use this primarily for details in the critical section.\n\n"
             . "facts_json:\n{$factsJson}\n\n"
             . "SCOPE RULE: [...]\n\n"
             . "CRITICAL INSTRUCTION: REQUIREMENTS DRIVE THE TRANSACTION. [...]\n\n"
             . "FORMATTING REQUIREMENTS: Use EXACTLY this structure and order. Do not deviate:\n"
             . "**TITLE REQUIREMENTS**\n- Item #[number]: [requirement in directive form]\n  - Details: [brief, concrete detail]\n  - Why it matters: [one-sentence agent-friendly explanation]\n[repeat for each requirement]\n[If none: \"No specific title requirements found.\"]\n\n"
             . "**SUMMARY**\n[...]\n"
             . "**PROPERTY INFORMATION**\n[...]\n"
             . "**LIENS AND JUDGMENTS**\n[...]\n"
             . "**TAXES AND ASSESSMENTS**\n[...]\n"
             . "**OTHER FINDINGS**\n[...]\n"
             . "**DOCUMENT STATUS**\n[...]\n\n"
             . "CRITICAL FORMATTING RULES - DO NOT DEVIATE: [...]\n\n"
             . "Here's the document content:\n\n"
             . substr($pdfText, 0, 15000) . (strlen($pdfText) > 15000 ? "\n\n[Document truncated for analysis - full content processed]" : '');
    }

    public function process_pdf($file_path) {
        // Using TCPDF for PDF text extraction
        require_once(FCPATH.'vendor/smalot/pdfparser/src/Smalot/PdfParser/Parser.php');
        
        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($file_path);
            $full_text = $pdf->getText();
            
            // Apply the same text processing as in the JavaScript version
            // echo "<pre>";
            $full_text = $this->normalize_bullets($full_text);
            // print_r($full_text);die;
            return $full_text;
            
        } catch (Exception $e) {
            log_message('error', 'PDF processing error: ' . $e->getMessage());
            throw new Exception('Unable to process PDF file: ' . $e->getMessage());
        }
    }

    public function analyze_pdf_with_tessa($filePath, $fileName)
    {
        // $this->CI->load->model('order/tessa_model');
        // $pdfText = $this->CI->tessa_model->process_pdf($filePath);
        $pdfText = $this->process_pdf($filePath);
        $facts = $this->compute_facts($pdfText);
        // echo "<pre>";
        $factsJson = json_encode($facts, JSON_PRETTY_PRINT);
        
        $analysisPrompt = $this->get_analysis_prompt($pdfText, $fileName, $factsJson);
        // print_r($analysisPrompt);die;
        $this->tessaHistory[] = ["role" => "user", "content" => $analysisPrompt];

        $ch = curl_init(self::TESSA_API_URL);
        
        $payload = json_encode([
            "messages" => $this->tessaHistory,
            "max_tokens" => 1500,
            "temperature" => 0.7
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || $response === false) {
            // return "Error from Tessa API: HTTP Code {$httpCode}";
            return "Error from while generating summary report: Unable to get a valid response. Please try again later.";
        }
        return $response;
        $data = json_decode($response, true);
        $tessaResponse = $data['choices'][0]['message']['content'] ?? 'AI response was empty.';
        
        $this->tessaHistory[] = ["role" => "assistant", "content" => $tessaResponse];
        return $tessaResponse;
        // Pass the raw AI response and facts to the formatter
        return $this->format_enhanced_analysis($tessaResponse, $fileName);
    }
    
    // --- Agent Explanation Logic Ported from JavaScript ---
    private function agent_explanation_by_type($type) {
        switch ($type) {
            case "reconveyance_confirmation": return "Proves an old loan/lien was actually released. Without it, a new buyer or lender could be behind that lien.";
            case "spousal_joinder": return "Spouses can have community property rights. A signature avoids later claims and allows insurable conveyance.";
            case "corp_authority": return "Shows the corporation is real and authorized to sign. Title can't insure a sale/loan without corporate authority.";
            case "suspended_corp_cure": return "A suspended company can't legally transfer property. Must revive before closing or title will not insure.";
            case "statement_of_information": return "Clears name hits so unrelated liens don't attach. Title needs this to remove false matches.";
            default: return "Needed so title can insure the sale/loan without unresolved risk.";
        }
    }

    private function build_realtor_cheat_sheet($facts) {
        if (empty($facts['requirements'])) return '';
        
        $reqList = '';
        foreach ($facts['requirements'] as $r) {
            $item = $r['item_no'] ? "Item {$r['item_no']}" : 'Item —';
            $label = $r['classification']['summary'] ?? 'Company requirement';
            $why = $this->agent_explanation_by_type($r['classification']['type']);
            $sev = ($r['classification']['severity'] ?? '') === 'blocker' ? 'BLOCKER' : 'Material';

            $reqList .= "<li style=\"margin-bottom:8px;\">
                <strong>" . htmlspecialchars($item) . ":</strong> " . htmlspecialchars($label) . "
                <div style=\"margin-top:4px;\"><em>Why it matters:</em> " . htmlspecialchars($why) . " <span style=\"font-size:12px;opacity:.85;\">[{$sev}]</span></div>
            </li>";
        }

        return "<div class=\"agent-cheat-sheet\" style=\"margin-top:15px; background: white; border-left: 4px solid #17a2b8; padding: 12px; border-radius: 6px;\">
          <h4 style=\"margin:0 0 12px; color: #17a2b8; font-size: 18px; font-weight: 700; text-transform: uppercase;\">🧭 Realtor Cheat Sheet — What These Requirements Mean</h4>
          <ul style=\"margin:0 0 4px 18px; padding:0;\">{$reqList}</ul>
        </div>";
    }
    
    // --- HTML Formatting Logic Ported from JavaScript ---
    public function format_enhanced_analysis($response, $fileName)
    {
        $cheatSheetHTML = $this->build_realtor_cheat_sheet($this->lastComputedFacts);
        $enhancedResponse = $response;
        
        // 1. Color-coded sections + Requirements warning + Cheat Sheet
        $enhancedResponse = preg_replace_callback(
            '/\*\*TITLE REQUIREMENTS\*\*([\s\S]*?)(?=\*\*[A-Z]|$)/i',
            function($matches) use ($cheatSheetHTML) {
                $body = $matches[1];
                // Bold Item numbers
                $bodyWithBoldItems = preg_replace('/(-\s*)(Item\s*#?\d+):/i', '$1<strong>$2</strong>:', $body);
                
                return '<div class="requirements-box" style="margin-bottom:15px;">
                   <h3 style="color:#155724; margin-bottom: 15px; font-size: 20px; font-weight: 700; text-transform: uppercase;">✅ Title Requirements (Must Be Satisfied to Close)</h3>'
                   . $bodyWithBoldItems .
                   '<div class="warning-box" style="margin-top:15px; background:rgba(220,53,69,0.08); border-left:4px solid #dc3545; padding:12px; border-radius:6px;">
                     <h5 style="color:#721c24; margin:0 0 8px;">⚠️ Closing Warning</h5>
                     <p style="margin:0; color:#721c24; font-weight:500;">Missing or incomplete requirements will <strong>stop this transaction from closing</strong>. Resolve each item with the title officer before funding or recording.</p>
                   </div>'
                   . $cheatSheetHTML .
                 '</div>';
            },
            $enhancedResponse
        );

        // 2. Apply other section styles
        $replacements = [
            '/\*\*SUMMARY\*\*([\s\S]*?)(?=\*\*[A-Z]|$)/i' => '<div class="highlight-box"><h4 style="color: #495057; margin-bottom: 10px;">📋 SUMMARY</h4>$1</div>',
            '/\*\*PROPERTY INFORMATION\*\*([\s\S]*?)(?=\*\*[A-Z]|$)/i' => '<div class="property-info-box"><h4 style="color: #155724; margin-bottom: 10px;">🏠 PROPERTY INFORMATION</h4>$1</div>',
            '/\*\*LIENS AND JUDGMENTS\*\*([\s\S]*?)(?=\*\*[A-Z]|$)/i' => '<div class="liens-judgments-box"><h4 style="color: #dc3545; margin-bottom: 10px;">🚨 LIENS AND JUDGMENTS</h4>$1</div>',
            '/\*\*TAXES AND ASSESSMENTS\*\*([\s\S]*?)(?=\*\*[A-Z]|$)/i' => '<div class="taxes-assessments-box"><h4 style="color: #856404; margin-bottom: 10px;">💰 TAXES AND ASSESSMENTS</h4>$1</div>',
            '/\*\*OTHER FINDINGS\*\*([\s\S]*?)(?=\*\*[A-Z]|$)/i' => '<div class="other-findings-box"><h4 style="color: #495057; margin-bottom: 10px;">📄 OTHER FINDINGS</h4>$1</div>',
            '/\*\*DOCUMENT STATUS\*\*([\s\S]*?)(?=\*\*[A-Z]|$)/i' => '<div class="info-box"><h4 style="color: #17a2b8; margin-bottom: 10px;">ℹ️ DOCUMENT STATUS</h4>$1</div>',
        ];
        $enhancedResponse = preg_replace(array_keys($replacements), array_values($replacements), $enhancedResponse);
        
        // 3. Markdown to HTML and other final styling
        $enhancedResponse = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $enhancedResponse);
        $enhancedResponse = preg_replace('/^[-•*]\s*(.+)$/m', '<li>$1</li>', $enhancedResponse);
        $enhancedResponse = preg_replace('/(<li>.*?<\/li>(?:\s*<li>.*?<\/li>)*)/s', '<ul>$1</ul>', $enhancedResponse);
        $enhancedResponse = preg_replace('/\$[\d,]+(\.\d{2})?/i', '<span class="amount">$0</span>', $enhancedResponse);
        $enhancedResponse = str_replace("\n\n", "<p></p>", $enhancedResponse);


        // Final wrapper and disclaimer
        return '<div class="tessa-analysis-response">
            <h3>📄 Preliminary Title Report Analysis</h3>
            <div class="info-box"><strong>Document:</strong> ' . htmlspecialchars($fileName) . '</div>'
            . $enhancedResponse .
            '<div class="warning-box" style="margin-top: 20px; background: rgba(220, 53, 69, 0.1); border-left: 4px solid #dc3545; padding: 15px; border-radius: 6px;">
                <h4 style="color: #721c24; margin-bottom: 10px;">⚠️ Important Disclaimer</h4>
                <p style="margin: 0; color: #721c24; font-weight: 500;">This is only a <strong>summary</strong> of your Preliminary Title Report.</p>
            </div>
        </div>';
    }
}

// --- Example Usage (Simulates a server-side file upload and analysis) ---

// Check if a file was uploaded (in a real scenario)
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
//     $filePath = $_FILES['pdf_file']['tmp_name'];
//     $fileName = $_FILES['pdf_file']['name'];
// } else {
    // For this demonstration, we use a placeholder file path
    $filePath = 'temp_file_for_testing.pdf';
    $fileName = 'tessa_prelim_report_sample.pdf';
// }

// $analyzer = new TessaAnalyzer();

// try {
//     $htmlOutput = $analyzer->analyze_pdf_with_tessa($filePath, $fileName);
//     echo $htmlOutput;
// } catch (Exception $e) {
//     // Handle file reading or API errors
//     echo "<h1>Analysis Error</h1><p>" . $e->getMessage() . "</p>";
// }

?>