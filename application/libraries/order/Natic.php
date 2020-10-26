<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Natic
{
    public static $CI;
    
	public function __construct($params = array())
	{
		$this->CI =& get_instance();                        
		$this->CI->load->database();
        $this->CI->load->library('email');
        $this->CI->load->library('session');
		self::$CI = $this->CI;
    }

    public function make_request($xml, $endpoint)
    {
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($xml),
            "Connection: close",
        );

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,getenv('NATIC_URL').$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,500); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch); 
        if(curl_errno($ch)) {
            return curl_error($ch);
        } else {
            curl_close($ch);
            return $data;	
        }
    }

    public function getDocumentContentForCpl($fileId, $orderDetails)
    {
        $this->CI->load->library('order/order');
        $userdata = $this->CI->session->userdata('user');
        if (!isset($userdata)) {
            $userdata = array();
            $userdata['id'] = 0;
        }
        $propertyDetail = explode(",", $orderDetails['full_address']);
        $xmlData = '';
        $address = $orderDetails['address'] ? $orderDetails['address'] : trim($propertyDetail[0])." ".trim($propertyDetail[1]);
        $city = $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]);
        $city = $orderDetails['property_city'] ? $orderDetails['property_city'] : trim($propertyDetail[2]);
        $state = $orderDetails['property_state'] ? $orderDetails['property_state'] : trim($propertyDetail[3]);
        $zipcode = $orderDetails['property_zip'] ? $orderDetails['property_zip'] : trim($propertyDetail[4]);

        $this->CI->load->model('order/home_model');
        $orderUser =  $this->CI->home_model->get_user(array('id' => $orderDetails['customer_id']));

        if ($orderUser['is_escrow'] == 0) {
            if (!empty($orderDetails['cpl_lender_id'])) {
                $lenderDetails = $this->CI->home_model->get_user(array('id' => $orderDetails['cpl_lender_id']));
                $orderDetails['lender_assignment_clause'] =  $lenderDetails['assignment_clause'] ? $lenderDetails['assignment_clause'] : '';
                $orderDetails['lender_address'] = $lenderDetails['street_address'];
                $orderDetails['lender_city'] = $lenderDetails['city'];
                $orderDetails['lender_state'] = $lenderDetails['state'];
                $orderDetails['lender_zipcode'] = $lenderDetails['zip_code'];
                $orderDetails['lender_company_name'] = $lenderDetails['company_name'];
                $orderDetails['lender_first_name'] = $lenderDetails['first_name'];
                $orderDetails['lender_last_name'] = $lenderDetails['last_name'];
            }
        } 
        
        $borrower = '';
        if ($orderDetails['sales_amount'] > 0) {
            $borrower = $orderDetails['borrower'];
            if (!empty($orderDetails['secondary_borrower'])) { 
                $borrower = $orderDetails['borrower']." And ".$orderDetails['secondary_borrower'];
            }
            if (!empty($orderDetails['vesting'])) { 
                $borrower .= ' '.$orderDetails['vesting'];
            }
		} else {
            $borrower = $orderDetails['primary_owner'];
            if (!empty($orderDetails['secondary_owner'])) { 
                $borrower = $orderDetails['primary_owner']." And ".$orderDetails['secondary_owner'];
            }
            if (!empty($orderDetails['vesting'])) { 
                $borrower .= ' '.$orderDetails['vesting'];
            }
        }

        $xmlData = "<Field>
                    <FieldId>FileNumber</FieldId>
                    <Name>Agent's File Number</Name>
                    <Value>".$orderDetails['file_number']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>PropertyAddress1</FieldId>
                    <Name>Property Address 1</Name>
                    <Value>".$address."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>

                <Field>
                    <FieldId>PropertyCity</FieldId>
                    <Name>Property City</Name>
                    <Value>".$city ."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>PropertyState</FieldId>
                    <Name>Property State</Name>
                    <Value>".$state."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>PropertyPostalCode</FieldId>
                    <Name>Property Postal Code</Name>
                    <Value>".$zipcode."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>PropertyDescription</FieldId>
                    <Name>Brief Legal Description</Name>
                    <Value>".$orderDetails['legal_description']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>LoanNumber</FieldId>
                    <Name>Loan Number</Name>
                    <Value>Loan No: ".$orderDetails['loan_number']."</Value>
                    <Type>String</Type>
                    <Required>false</Required>
                </Field>
                <Field>
                    <FieldId>LoanAmount</FieldId>
                    <Name>Loan Amount</Name>
                    <Value>".$orderDetails['loan_amount']."</Value>
                    <Type>Decimal</Type>
                    <Required>false</Required>
                </Field>
                <Field>
                    <FieldId>LenderName</FieldId>
                    <Name>Lender Name</Name>
                    <Value>".$orderDetails['lender_company_name']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>LenderNote</FieldId>
                    <Name>Lender Note</Name>
                    <Value>".$orderDetails['lender_assignment_clause']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>LenderContactName</FieldId>
                    <Name>Lender Contact Name</Name>
                    <Value>".$orderDetails['lender_first_name']." ".$orderDetails['lender_last_name']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>LenderAddress1</FieldId>
                    <Name>Lender Address 1</Name>
                    <Value>".$orderDetails['lender_address']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>LenderAddress2</FieldId>
                    <Name>Lender Address 2</Name>
                    <Value></Value>
                    <Type>String</Type>
                    <Required>false</Required>
                </Field>
                <Field>
                    <FieldId>LenderCity</FieldId>
                    <Name>Lender City</Name>
                    <Value>".$orderDetails['lender_city']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>LenderState</FieldId>
                    <Name>Lender State</Name>
                    <Value>".$orderDetails['lender_state']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>LenderPostalCode</FieldId>
                    <Name>Lender Postal Code</Name>
                    <Value>".$orderDetails['lender_zipcode']."</Value>
                    <Type>String</Type>
                    <Required>true</Required>
                </Field>
                <Field>
                    <FieldId>Buyer</FieldId>
                    <Name>Buyer/Borrower Name</Name>
                    <Value>".$borrower."</Value>
                    <Type>String</Type>
                    <Required>false</Required>
                </Field>";

        $xmlData = "<?xml version='1.0' encoding='utf-8'?>
                        <RequestWrapper>
                            <UserName>".getenv('NATIC_USERNAME')."</UserName>
                            <Password>".getenv('NATIC_PASSWORD')."#</Password>
                            <TransactionId>".rand(10000,99999)."</TransactionId>
                            <CompanyName>".getenv('NATIC_COMPANY')."</CompanyName>
                            <DocumentCollection>
                                <PropertyState>CA</PropertyState>
                                <DocumentList>
                                    <Document>
                                        <DocumentId>".getenv('NATIC_DOCUMENT_ID')."</DocumentId>
                                        <ReferenceId>".rand(100000,999999)."</ReferenceId>
                                        <Name>CAStateLetter</Name>
                                        <RequestType>ClosingProtectionLetter</RequestType>
                                        <FieldList>
                                        ".$xmlData."
                                        </FieldList>
                                    </Document>
                                </DocumentList>
                                <ApprovedAttorneyList />
                                <ApprovedSettlementOfficeList />
                            </DocumentCollection>
                        </RequestWrapper>";

        $endPoint = 'GetDocuments';
        $this->CI->load->model('order/apiLogs');
        $logid = $this->CI->apiLogs->syncLogs($userdata['id'], 'natic', 'get_document', getenv('NATIC_URL').$endPoint, $xmlData, array(), $orderDetails['order_id'], 0);                
        $resultDocument = $this->make_request($xmlData, $endPoint);
        $this->CI->apiLogs->syncLogs($userdata['id'], 'natic', 'get_document', getenv('NATIC_URL').$endPoint, $xmlData, $resultDocument, $orderDetails['order_id'], $logid);
        $responseData = $this->xml2array($resultDocument, 0);
        if(!empty($responseData['ResponseWrapper']['DocumentCollection']['DocumentList']['Document']['Content'])) {
			return array('success'=> true, 'content' => $responseData['ResponseWrapper']['DocumentCollection']['DocumentList']['Document']['Content']);
		} else {
			return array('success'=> false, 'error' => $responseData['ResponseWrapper']['Error']['ErrorMessage']);
		}
    }

    public function xml2array($contents, $get_attributes=1, $priority = 'tag') 
    {
	    if(!$contents) return array();

	    if(!function_exists('xml_parser_create')) {
	        return array();
	    }

	    $parser = xml_parser_create('');
	    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); 
	    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	    xml_parse_into_struct($parser, trim($contents), $xml_values);
	    xml_parser_free($parser);

	    if(!$xml_values) return;

	    $xml_array = array();
	    $parents = array();
	    $opened_tags = array();
	    $arr = array();
	    $current = &$xml_array;
	    $repeated_tag_index = array();

	    foreach($xml_values as $data) {

	        unset($attributes,$value);
	        extract($data);

	        $result = array();
	        $attributes_data = array();

	        if(isset($value)) {         
	            if($priority == 'tag')  $result = $value;  else  $result['value'] = $value;
	        }   
	        if(isset($attributes) and $get_attributes) {            
	            foreach($attributes as $attr => $val) {             
	                if($priority == 'tag') 
	                    $attributes_data[$attr] = $val;
	                else 
	                    $result['attr'][$attr] = $val;
	            }
	        }       
	        if($type == "open") {       
	            $parent[$level-1] = &$current;          
	            if(!is_array($current) or (!in_array($tag, array_keys($current)))) {            
	                $current[$tag] = $result;               
	                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;                
	                $repeated_tag_index[$tag.'_'.$level] = 1;
	                $current = &$current[$tag];             
	            } else {            
	                if(isset($current[$tag][0])) {              
	                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
	                    $repeated_tag_index[$tag.'_'.$level]++;                 
	                } else {                
	                    $current[$tag] = array($current[$tag],$result);
	                    $repeated_tag_index[$tag.'_'.$level] = 2;                   
	                    if(isset($current[$tag.'_attr'])) {                 
	                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
	                        unset($current[$tag.'_attr']);
	                    }
	                }               
	                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
	                $current = &$current[$tag][$last_item_index];
	            }

	        } elseif($type == "complete") { 
	            if(!isset($current[$tag])) {            
	                $current[$tag] = $result;
	                $repeated_tag_index[$tag.'_'.$level] = 1;
	                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;             
	            } else {            
	                if(isset($current[$tag][0]) and is_array($current[$tag])) {                 
	                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
	                    if($priority == 'tag' and $get_attributes and $attributes_data) {
	                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
	                    }
	                    $repeated_tag_index[$tag.'_'.$level]++;                 
	                } else {                
	                    $current[$tag] = array($current[$tag],$result); 
	                    $repeated_tag_index[$tag.'_'.$level] = 1;
	                    if($priority == 'tag' and $get_attributes) {
	                        if(isset($current[$tag.'_attr'])) { 
	                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
	                            unset($current[$tag.'_attr']);
	                        }
	                        if($attributes_data) {
	                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
	                        }
	                    }
	                    $repeated_tag_index[$tag.'_'.$level]++; 
	                }
	            }           
	        } elseif($type == 'close') { 
	            $current = &$parent[$level-1];
	        }
	    }
	    return($xml_array);
	}
    
}
