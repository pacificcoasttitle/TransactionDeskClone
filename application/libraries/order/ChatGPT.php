<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Chatgpt
{
    public $CI;
    private $apiKey;
    private $model;
    
    public function __construct($params = array())
    {
        $this->CI =& get_instance();
        // self::$CI = $this->CI;
        $this->apiKey = getenv('CHAT_GPT_API_KEY');
        $this->model  = getenv('CHAT_GPT_MODAL') ?: 'o4-mini';

    }

    public function make_request($prompt, $data = array())
    {
        $postData = [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            "temperature" => 0.7
        ];
        $apiKey = env('CHAT_GPT_API_KEY');
        $chatGPTUrl = env('CHAT_GPT_URL');
        $ch = curl_init($chatGPTUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function classify($firstPageText)
    {
        if (trim($firstPageText) === '') {
            return ['chunks' => [], 'confidence' => 0.0];
        }
        // return;
        $payload = $this->buildPrompt($firstPageText);
        $response = $this->callOpenAI($payload);

        if ($response && isset($response['chunks'])) {
            return $response;
        }
        return $response;

        // return $this->fallbackRegex($firstPageText);
    }

    public function getLenderDetails($lenderPages)
    {
        if (trim($lenderPages) === '') {
            return 'unknown';
        }

        $payload = $this->buildPromptForLenderSchema($lenderPages);
        // print_r($payload);die;
        // $payload = $this->buildPromptForTitleAndRanges($pageText);
        // print_r($payload);die;
        return $response = $this->callOpenAI($payload);

        if ($response && isset($response['doc_type'])) {
            return $response['doc_type'];
        }

        // return $this->regexFallback($pageText);
    }

    // public function classifyPage($pageText)
    // {
    //     if (trim($pageText) === '') {
    //         return 'unknown';
    //     }

    //     $payload = $this->prompt($pageText);
    //     $response = $this->callOpenAI($payload);

    //     if ($response && isset($response['doc_type'])) {
    //         return $response['doc_type'];
    //     }

    //     return $this->regexFallback($pageText);
    // }

    public function classifyAllPage($pageText)
    {
        if (trim($pageText) === '') {
            return 'unknown';
        }

        $payload = $this->buildPromptForTitleAndRanges($pageText);
        
        // $payload = $this->buildPromptForTitleAndRanges($pageText);
        // print_r($payload);die;
        return $response = $this->callOpenAI($payload);

        if ($response && isset($response['doc_type'])) {
            return $response['doc_type'];
        }

        // return $this->regexFallback($pageText);
    }

//     private function prompt($text)
//     {
//         return [
//             'model' => $this->model,
//             'messages' => [
//                 [
//                     'role' => 'system',
//                     'content' => 'You classify individual escrow document pages.'
//                 ],
//                 [
//                     'role' => 'user',
//                     'content' => <<<PROMPT
// Identify the document type of the page below.

// VALID doc_type:
// cover_letter
// lender_instructions
// deed_of_trust
// payoff_statement
// wire_instructions
// closing_worksheet
// title_policy
// endorsements
// unknown

// Return JSON only.

// SCHEMA:
// {
//   "doc_type": "",
//   "confidence": 0.0
// }

// TEXT:
// <<<{$text}>>>
// PROMPT
//                 ]
//             ],
//             'temperature' => 0
//         ];
//     }


    private function buildPrompt($text)
    {
        return [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a document classifier for real estate closing packages.'
                ],
                [
                    'role' => 'user',
                    'content' => <<<PROMPT
Read the first-page table of contents and return normalized doc types with page ranges.

VALID doc_type:
lender_instructions, closing_worksheet, payoff_statement, prelim_title_report,
deed, deed_of_trust, right_to_cancel, compliance_eo, occupancy, wire_instructions,
title_policy, endorsements.

SCHEMA:
{
  "chunks":[{"doc_type":"","pages":[]}],
  "confidence":0.0
}

TEXT:
<<<{$text}>>>
PROMPT
]
    ]
        ];
    }

    public function buildPromptForLenderSchema($array)
{
    return [
        'model' => $this->model,
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a title & escrow lender-instruction parser. Return only JSON per schema'
            ],
            [
                'role' => 'user',
                'content' => <<<PROMPT
Extract lender_name,borrowers[], coverage_amount, loan_amount, endorsements[], loan_number.

SCHEMA: {"lender_package":{"lender_name":null,"borrowers":[],"coverage_amount":null,"loan_amount":null,"endorsements":[{"
code":"","name":"","notes":""}],"loan_number":null,"flags":[]}}
TEXT: <<<{$array} >>> ```
PROMPT
            ]
        ]
    ];
}

// public function buildPromptForTitleAndRange($array)
// {
//     return [
//         'model' => $this->model,
//         'reasoning' => [
//             'effort' => 'medium'
//         ],

//         'temperature' => 1,

//         'max_output_tokens' => 600,

//         'response_format' => [
//             'type' => 'json_object'
//         ],
//         'messages' => [
//             [
//                 'role' => 'system',
//                 'content' => 'You are a strict document classification and pagination extraction engine. You must follow instructions exactly and output JSON only.'
//             ],
//             [
//                 'role' => 'user',
//                 'content' => <<<PROMPT
// You are given an ARRAY of PDF page objects extracted from a real estate closing package.

// Each array item represents ONE page and has:
// - pdf_page_number (actual page number in the PDF)
// - text (OCR or extracted text of that page)

// Your task:
// Identify document START pages only and extract:
// 1. page_title — must be selected ONLY from the allowed enum list.
// 2. page_range — mapped to ACTUAL PDF page numbers.

// IMPORTANT FILTERING RULES (MANDATORY):
// - Return ONLY the FIRST page of each document.
// - A page is considered a document START page ONLY IF:
//   - page_range is NOT null
//   - page_range.current == page_range.start
// - Ignore:
//   - continuation pages
//   - pages where page_range is null
//   - pages where current != start

// Allowed page_title values (enum ONLY):
// - lender_instructions
// - closing_worksheet
// - payoff_statement
// - prelim_title_report
// - deed
// - deed_of_trust
// - right_to_cancel
// - compliance_eo
// - occupancy
// - wire_instructions
// - title_policy
// - endorsements

// Rules:
// - Do NOT invent titles.
// - Do NOT return raw document headings.
// - Choose the closest enum using semantic meaning.
// - Preserve original PDF order.
// - One output object per document (not per page).

// Page range calculation:
// - If footer contains "Page X of Y":
//   - current = pdf_page_number
//   - start = pdf_page_number - (X - 1)
//   - end = start + (Y - 1)

// Output format (STRICT JSON ONLY):
// [
//   {
//     "pdf_page_number": number,
//     "page_title": enum,
//     "page_range": {
//       "start": number,
//       "current": number,
//       "end": number
//     }
//   }
// ]

// Input pages:
// {$array}
// PROMPT
//             ]
    
//         ]
//     ];
// }

public function buildPromptForTitleAndRanges($array)
{
    return [
        'model' => $this->model,

        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a strict legal document boundary detection engine based on document type from provieded context for real estate recording packages.

Important:
- Document titles may appear at the TOP, MIDDLE, or BOTTOM of the page.
- Do NOT assume titles only appear in headers.
- Do NOT guess continuation pages.
- If no clear document title is present, start=false.'
            ],
            [
                'role' => 'user',
                'content' => <<<PROMPT
Analyze the FULL PAGE text (entire content).

Valid document types:
===> Please don't try to find extact word from document text it might be different.
- lender_instructions
- endorsements
- deed_of_trust
- deed
- title_policy
- payoff_statement
- closing_worksheet
- other

# You need to flow this step
1. Check document page by page 
2. Identify document type using above valid document types 
3. Identify start page and end page for particular document type
4. You need to return actual pdf page number not page number information provided in document text
   You can find this actual pdf number by "actual pdf page number" key in provided array. 
   Must return this actual pdf number as start_page and end_page in response.

# Important rule for end page indentification:
=> Each original document has its own internal page numbering
 - Lender Instructions: Page 1–4
 - Endorsements: Page 1–3
 - Deed of Trust: Page 1–7

=> After merge:
 - Book pages ≠ document pages

=> End of document occurs when:
 - Page number resets to 1 OR page number disappears OR a new document title appears

SCHEMA:
[
    {
        "doc_type": null,
        "start_page": 1, # Actual pdf page number where particular document is started,
        "end_page": 1 # Acutal pdf page number where particular document is ended.
    }, 
    {
        "doc_type": null,
        "start_page: 1,
        "end_page": 1
    }           
]

You must need to provide response in this format:
SAMPLE RESPONSE: 
[
    {
        "doc_type": "lender_instructions",
        "start_page: 2,
        "end_page": 4
    }, 
    {
        "doc_type": "deed_of_trust",
        "start_page: 5,
        "end_page": 8
    }           
]

You must need to understand: 
Particular document have multiple types, So you need to provide each types in response with that types information with
start page and end page related information. 

PAGE TEXT:
{$array}
PROMPT
            ]
    
        ]
    ];
}


    private function callOpenAI($payload)
    {
        if (!getenv('USE_OPENAI')) return null;

        $ch = curl_init(getenv('CHAT_GPT_URL'));

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 60
        ]);

        $result = curl_exec($ch);
        // print_r('<br>------------------ChatGPT Response------------------<br>', curl_error($ch));
        // curl_close($ch);
        // print_r('ChatGPT Result: ' . $result);die;
        if (!$result) return null;

        return $json = json_decode($result, true);
        $content = $json['choices'][0]['message']['content'] ?? null;

        return json_decode($content, true);
    }

    /**
     * Regex fallback (safe & deterministic)
     */

    // private function fallbackRegex($text)
    // {
    //     $t = strtolower($text);
    //     $found = [];

    //     $rules = [
    //         'lender_instructions' => ['lender instructions', 'instructions to escrow'],
    //         'deed_of_trust'       => ['deed of trust'],
    //         'payoff_statement'   => ['payoff', 'demand'],
    //         'wire_instructions'  => ['wire instructions', 'routing', 'account no'],
    //         'title_policy'       => ['policy of title insurance']
    //     ];

    //     foreach ($rules as $type => $keywords) {
    //         foreach ($keywords as $k) {
    //             if (strpos($t, $k) !== false) {
    //                 $found[] = ['doc_type' => $type, 'pages' => []];
    //                 break;
    //             }
    //         }
    //     }

    //     return [
    //         'chunks' => $found,
    //         'confidence' => count($found) ? 0.6 : 0.0
    //     ];
    // }

    /**
     * Regex fallback (OCR-safe)
     */
    // private function regexFallback($text)
    // {
    //     $t = strtolower($text);

    //     $rules = [
    //         'lender_instructions' => [
    //             'instructions to escrow',
    //             'closing instructions',
    //             'loan #',
    //             'do not close the loan',
    //             'right to cancel'
    //         ],
    //         'deed_of_trust' => [
    //             'deed of trust',
    //             'trustor',
    //             'trustee',
    //             'beneficiary'
    //         ],
    //         'payoff_statement' => [
    //             'payoff statement',
    //             'total amount due',
    //             'good through'
    //         ],
    //         'wire_instructions' => [
    //             'wire instructions',
    //             'routing number',
    //             'account number'
    //         ],
    //         'cover_letter' => [
    //             'we enclose the following',
    //             'title order'
    //         ]
    //     ];

    //     foreach ($rules as $type => $keys) {
    //         foreach ($keys as $k) {
    //             if (strpos($t, $k) !== false) {
    //                 return $type;
    //             }
    //         }
    //     }

    //     return 'unknown';
    // }

    // public function detect(array $pageTexts)
    // {
    //     $ranges = [];

    //     $currentStart = null;
    //     $expectedEndX = null;

    //     foreach ($pageTexts as $pdfPageNo => $text) {
            
    //         $pageInfo = $this->extractPageInfo($text);
    //         if (!$pageInfo) {
    //             continue;
    //         }

    //         [$x, $y] = $pageInfo;

    //         // New document starts
    //         if ($x === 1) {
    //             $currentStart = $pdfPageNo;
    //             $expectedEndX = $y;
    //         }

    //         // Document ends
    //         if ($currentStart !== null && $x === $expectedEndX) {
    //             $ranges[] = [
    //                 'start' => $currentStart,
    //                 'end'   => $pdfPageNo
    //             ];
    //             $currentStart = null;
    //             $expectedEndX = null;
    //         }
    //     }

    //     return $ranges;
    // }

    // private function extractPageInfo($text)
    // {
    //     $text = strtolower($text);

    //     /**
    //      * Match:
    //      *  - Page i of 8
    //      *  - page I of 8
    //      *  - page 1 of 8
    //      *  - i of 8
    //      */
    //     if (preg_match('/(?:page\s*)?([0-9ilbs|]+)\s+of\s+([0-9]+)/i', $text, $m)) {

    //         $xRaw = strtolower($m[1]);
    //         $y    = (int)$m[2];

    //         // Normalize OCR mistakes ONLY for page number X
    //         $map = [
    //             'i' => '1',
    //             'l' => '1',
    //             '|' => '1',
    //             's' => '5',
    //             'b' => '8',
    //             'o' => '0'
    //         ];

    //         $xNorm = strtr($xRaw, $map);

    //         if (ctype_digit($xNorm)) {
    //             return [(int)$xNorm, $y];
    //         }
    //     }

    //     return null;
    // }
    
}
