<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class ReviewPrelim extends MX_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('order/apiLogs');
        $this->load->model('order/reviewPrelimData');
        $this->load->library('order/order');
        // $this->load->library("phpmailer_library");
        $this->load->model('order/document');
        $this->load->library('order/resware');
        $this->load->model('order/home_model');
        $this->load->helper('sendemail');
    }

    
    public function fetchData()
    {
    	ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
		
		//$json = file_get_contents('php://input');
		$json = '{
			"AssessedImprovementValue": null,
			"AssessedLandValue": null,
			"ChainOfTitle": null,
			"CommitmentEffectiveDate": "2020-08-04T07:30:40.547",
			"CommitmentInterestID": 1,
			"Easements": [
			{
			"EasementBookPages": [],
			"EasementID": 632768,
			"EasementTypeID": 614,
			"EasementTypeName": "A9M",
			"Book": null,
			"BookPages": [],
			"Date": null,
			"DocumentName": null,
			"Grantee": null,
			"Grantor": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "Covenants, conditions, restrictions and agreements, if any, appearing in the Public Records, deleting therefrom any restrictions indicating any preference, limitation or discrimination based on race, color religion, sex, handicap, familial status or national origin. Easements or servitudes appearing in the Public Records. Leases, grants, exceptions or reservations of minerals or mineral rights appearing in the Public Records.",
			"Liber": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"Volume": null
			}
			],
			"FileNumber": "10182462",
			"Leasehold": null,
			"Legal": "Lot 219 of Tract No. 43536, in the City of Palmdale, in the County of Los Angeles, State of California, as per Map recorded in Book 1090, Page(s) 5 to 15 inclusive of Maps, in the Office of the County Recorder of said County.\n\nExcept therefrom all geothermal resources, minerals, ores, precious and useful metals, substances and hydrocarbons of every kind of character, including petroleum, oil, gas, asphaltum and tar, that may now or hereafter be found, located, contained, developed or taken on, in, under or from said land, or any part thereof, without, however, any right of surface entry or any right of entry to the subsurface thereof to a depth of 500 feet beneath the surface of said property for the development, removal or other exploitation of said resources and substances.",
			"Liens": [
			{
			"LienBookPages": [],
			"LienID": 2114630,
			"LienTypeID": 1466,
			"LienTypeName": "T1",
			"Against": null,
			"Amount": null,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": null,
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": true,
			"Grantee": null,
			"Grantor": null,
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "Property taxes, which are a lien not yet due and payable, including any assessments collected with taxes to be levied for the fiscal year 2020-2021.",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": null,
			"Volume": null
			},
			{
			"LienBookPages": [],
			"LienID": 2114631,
			"LienTypeID": 1813,
			"LienTypeName": "T4",
			"Against": null,
			"Amount": null,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": null,
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": true,
			"Grantee": null,
			"Grantor": null,
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "Note: Property taxes for the fiscal year shown below are PAID. For proration purposes the amounts were: Tax Identification No.: <a id=\"TAX.pdf\" href=\"http://clients.pacificcoasttitle.com/DownloadDocument.aspx?DocumentID=7249072\">_PARCELID1_</a> Fiscal Year: 2019-2020 1st Installment: $1,349.31 2nd Installment: $1,349.30 Exemption: $0.00 Land: $27,874.00 Improvements: $105,114.00 Personal Property: $0.00 Code Area: 06919",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": null,
			"Volume": null
			},
			{
			"LienBookPages": [],
			"LienID": 2114632,
			"LienTypeID": 1470,
			"LienTypeName": "T103",
			"Against": null,
			"Amount": null,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": null,
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": true,
			"Grantee": null,
			"Grantor": null,
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "Any liens or other assessments, bonds, or special district liens including without limitation, Community Facility Districts, that arise by reason of any local, City, Municipal or County Project or Special District.",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": null,
			"Volume": null
			},
			{
			"LienBookPages": [],
			"LienID": 2114633,
			"LienTypeID": 1475,
			"LienTypeName": "T108",
			"Against": null,
			"Amount": null,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": null,
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": true,
			"Grantee": null,
			"Grantor": null,
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "The lien of supplemental or escaped assessments of property taxes, if any, pursuant to the provisions of Chapter 3.5 or Part 2, Chapter 3, Articles 3 and 4 respectively (commencing with Section 75) of the Revenue and Taxation Code of the State of California as a result of the transfer of title to the vestee named in Schedule A; or as a result of changes in ownership or new construction occurring prior to date of policy.",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": null,
			"Volume": null
			},
			{
			"LienBookPages": [],
			"LienID": 2114635,
			"LienTypeID": 1089,
			"LienTypeName": "D1M",
			"Against": null,
			"Amount": 170000.00,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": "2017-11-24T00:00:00",
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": false,
			"Grantee": "Equity Smart Home Loans Inc.",
			"Grantor": "Shawn R Viveros and Nanci Viveros, husband and wife as joint tenants",
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": "20171365787",
			"IsAllCaps": false,
			"Language": "A deed of trust to secure an indebtedness in the amount shown below, and any other obligations secured thereby: Amount: $_AMOUNT Dated: DATE Trustor: GRANTOR Trustee: TRUSTEE Beneficiary: MORTGAGE ELECTRONIC REGISTRATION SYSTEMS, INC. (MERS) SOLELY AS NOMINEE FOR LENDER Lender: GRANTEE Loan No.: 1517020786 Recording Date: RECORDEDDATE_ Recording No.: <a id=\"Property_2017-1365787 TDR 11-28-2017.pdf\" href=\"http://clients.pacificcoasttitle.com/DownloadDocument.aspx?DocumentID=7249078\">_INSTRUMENTONLY_</a>, Official Records",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": "2017-11-28T00:00:00",
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": "John D. Duncan, Esq.",
			"Volume": null
			},
			{
			"LienBookPages": [],
			"LienID": 2114636,
			"LienTypeID": 1730,
			"LienTypeName": "R4M",
			"Against": null,
			"Amount": null,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": null,
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": false,
			"Grantee": null,
			"Grantor": null,
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "In order to complete this report, the Company requires a Statement of Information to be completed by the following party(s), Party(s): All Parties The Company reserves the right to add additional items or make further requirements after review of the requested Statement of Information. NOTE: The Statement of Information is necessary to complete the search and examination of title under this order. Any title search includes matters that are indexed by name only, and having a completed Statement of Information assists the Company in the elimination of certain matters which appear to involve the parties but in fact affect another party with the same or similar name. Be assured that the Statement of Information is essential and will be kept strictly confidential to this file.",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": null,
			"Volume": null
			}
			],
			"ParcelID": "3023-018-073",
			"ProposedInsured": null,
			"Requirements": [
			{
			"LienBookPages": [],
			"RequirementID": 2114637,
			"RequirementTypeID": 1633,
			"RequirementTypeName": "N103",
			"Against": null,
			"Amount": null,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": null,
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": false,
			"Grantee": null,
			"Grantor": null,
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "Note: None of the items shown in this report will cause the Company to decline to attach CLTA Endorsement Form 100 to an Extended Coverage Loan Policy, when issued.",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": null,
			"Volume": null
			},
			{
			"LienBookPages": [],
			"RequirementID": 2114638,
			"RequirementTypeID": 1635,
			"RequirementTypeName": "N105",
			"Against": null,
			"Amount": null,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": null,
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": false,
			"Grantee": null,
			"Grantor": null,
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "Note: The Company is not aware of any matters which would cause it to decline to attach CLTA Endorsement Form 116 indicating that there is located on said Land Single Family Residence, known as 5146 Karling Place, Palmdale, CA 93552 to an Extended Coverage Loan Policy.",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": null,
			"Volume": null
			},
			{
			"LienBookPages": [],
			"RequirementID": 2114639,
			"RequirementTypeID": 1656,
			"RequirementTypeName": "N5",
			"Against": null,
			"Amount": null,
			"Assignee": null,
			"AssigneeBook": null,
			"AssigneeInstrument": null,
			"AssigneeLiber": null,
			"AssigneePage": null,
			"AssigneeVolume": null,
			"Assignor": null,
			"Book": null,
			"BookPages": [],
			"CaseNumber": null,
			"County": null,
			"CourtDistrict": null,
			"CourtType": null,
			"Date": null,
			"DocumentName": null,
			"Endorsements": null,
			"Flagged": false,
			"Grantee": null,
			"Grantor": null,
			"Holder": null,
			"InFavorOf": null,
			"InstallmentAmount": null,
			"InstallmentNumber": null,
			"Instrument": null,
			"IsAllCaps": false,
			"Language": "Note: There are NO conveyances affecting said Land recorded within 24 months of the date of this report.",
			"Liber": null,
			"MaturityDate": null,
			"Page": null,
			"Purpose": null,
			"RecordedDate": null,
			"State": null,
			"StateDistrict": null,
			"TaxYears": null,
			"Trustee": null,
			"Volume": null
			}
			],
			"Restrictions": null,
			"ServiceVersion": 2,
			"Taxes": null,
			"Vesting": "Shawn R. Viveros and Nanci Viveros, husband and wife as joint tenants",
			"YearAcquired": null
			}';
    	
    	if($json)
    	{
    		$logId = $this->apiLogs->syncLogs(0,'resware WCF', 'get_prelim','https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', array('ReceiveSearchDataService'=>true), array());

    		$this->apiLogs->syncLogs(0, 'resware WCF', 'get_prelim', 'https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', array(), $json, 0, $logId);
    		//Name of our directory
			$dir_name = APPPATH.'logs/prelim';

			//Check if the directory with the name already exists
			if (!is_dir($dir_name)) 
			{
				mkdir($dir_name);
			}

			$file = APPPATH.'logs/prelim/response.log';
			if (file_exists($file)) 
			{
			  $fh = fopen($file, 'a');
			} 
			else 
			{
			  $fh = fopen($file, 'w');
			}

			fwrite($fh, $json."\n");
			fclose($fh);

			$data = json_decode($json,TRUE);

	    	if(isset($data) && !empty($data))
	    	{
	    		$file_number = isset($data['FileNumber']) && !empty($data['FileNumber']) ? $data['FileNumber'] : '';

				$parcelID = isset($data['ParcelID']) && !empty($data['ParcelID']) ? $data['ParcelID'] : '';

	    		$vesting = isset($data['Vesting']) && !empty($data['Vesting']) ? $data['Vesting'] : '';
	    		$generated_date = isset($data['CommitmentEffectiveDate']) && !empty($data['CommitmentEffectiveDate']) ? date('Y-m-d H:i:s', strtotime($data['CommitmentEffectiveDate'])) : '';
	    		$liens = $email_data = array();

	    		if(isset($data['Liens']) && !empty($data['Liens']))
				{
					$liensCount = 1;
					foreach ($data['Liens'] as $key => $lien) 
					{
						$language = isset($lien['Language']) && !empty($lien['Language']) ? $lien['Language'] : '';

						if(strpos($language, 'Tax Identification No') !== false)
						{
							if(strpos($language, '_PARCELID1_') !== false) 
							{																		
								preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $language, $result);
								if (!empty($result)) {
									$link = $result['href'][0];
									$documentId = str_replace('http://clients.pacificcoasttitle.com/DownloadDocument.aspx?DocumentID=', '', $link);
									$documentIds[$documentId] = $liensCount;
								}
								$language = str_replace("_PARCELID1_", $parcelID , $language);
							}
							$pos = strpos($language, 'Tax Identification No');
							$sub_str = substr($language,0,$pos);							
							$language = substr($language,$pos);

							preg_match_all('/[a-zA-Z0-9. ]+: (\S+)/', $language, $matches);
							
							$language = $sub_str."\n";
							
							if(isset($matches[0]) && !empty($matches[0]))
							{
								foreach ($matches[0] as $key => $value) 
								{
									$a = explode(":", $value);
									if (strtolower($a[0]) == 'tax identification no.') {
										$str= '<strong>'.$a[0].': </strong>'.$parcelID;
									} else {
										$str= '<strong>'.$a[0].': </strong>'.$a[1];
									}
									$language .= $str."\n";
								}
							}

							$email_data['tax'][] = $language;
						}
						else
						{
							$amount = isset($lien['Amount']) && !empty($lien['Amount']) ? $lien['Amount'] : '';
							$date = isset($lien['Date']) && !empty($lien['Date']) ? $lien['Date'] : '';
							$grantor = isset($lien['Grantor']) && !empty($lien['Grantor']) ? $lien['Grantor'] : '';
							$trustee = isset($lien['Trustee']) && !empty($lien['Trustee']) ? $lien['Trustee'] : '';
							$grantee = isset($lien['Grantee']) && !empty($lien['Grantee']) ? $lien['Grantee'] : '';
							$recordedDate = isset($lien['RecordedDate']) && !empty($lien['RecordedDate']) ? $lien['RecordedDate'] : '';
							$instrument = isset($lien['Instrument']) && !empty($lien['Instrument']) ? $lien['Instrument'] : '';
							if(!empty($language))
							{	

								if(strpos($language, 'Amount:') !== false)
								{
									$pos = strpos($language, 'Amount:');
									$sub_str_main = substr($language,0,$pos);
															
									$language = substr($language,$pos);
									$exploded_str = $this->multiexplode(array("_ "),$language);
									$formatted_data = array();
									if(isset($exploded_str) && !empty($exploded_str))
									{
										foreach ($exploded_str as $key => $value) 
										{
											$str_count = substr_count($value, ':');

											if($str_count == 2)
											{
												if(strpos($value, 'Lender:') !== false)
												{

													$pos = strpos($value, 'Lender:');
													$sub_str = substr($value,0,$pos);
													$formatted_data[] = $sub_str;
													$truncate_str = substr($value,$pos);
													$formatted_data[] = $truncate_str."_";
												}
												if(strpos($value, 'Recording Date:') !== false)
												{

													$pos = strpos($value, 'Recording Date:');
													$sub_str = substr($value,0,$pos);
													$formatted_data[] = $sub_str;
													$truncate_str = substr($value,$pos);
													$formatted_data[] = $truncate_str."_";
												}
												if(strpos($value, '<a id=') !== false)
												{

													$pos = strpos($value, '<a id=');
													$sub_str = substr($value,0,$pos);
													
													
													$truncate_str = substr($value,$pos);
													
													$formatted_data[] = $sub_str.$truncate_str;
												}
											}
											else
											{
												$formatted_data[] = $value."_"; 
											}
										} 
									}
									
									

									$language = $sub_str_main."\n";
									
									if(isset($formatted_data) && !empty($formatted_data))
									{
										foreach ($formatted_data as $k => $v) 
										{
											$str = explode(": ", $v);
											
											$format_str= '<strong>'.$str[0].': </strong>'.$str[1];
											$language .= $format_str."\n";
										}
									}
								}
								if(strpos($language, 'A homestead declaration Executed by:') !== false)
								{
									$l_exploded = $this->multiexplode(array("_ "),$language);
									$l_formatted_data = array();
									if(isset($l_exploded) && !empty($l_exploded))
									{
										foreach ($l_exploded as $l_key => $l_value) 
										{						
											if(strpos($l_value, 'Official Records') !== false)
											{
												$l_formatted_data[] = $l_value;
											}
											else
											{
												$l_formatted_data[] = $l_value."_";
											}
										} 
									}

									$language = "";
									if(isset($l_formatted_data) && !empty($l_formatted_data))
									{
										foreach ($l_formatted_data as $l_k => $l_v) 
										{
											$l_str = explode(": ", $l_v);
											
											$l_format_str= '<strong>'.$l_str[0].': </strong>'.$l_str[1];
											$language .= $l_format_str."\n";
										}
									}
								}


								if(strpos($language, '_AMOUNT_') !== false) {
									$language = str_replace("_AMOUNT_", " ".$amount , $language);
								}
								if(strpos($language, '_DATE_') !== false) {
									$language = str_replace("_DATE_", " ".$date , $language);
								}
								if(strpos($language, '_GRANTOR_') !== false) {
									$language = str_replace("_GRANTOR_", " ".$grantor , $language);
								}
								if(strpos($language, '_TRUSTEE_') !== false) {
									$language = str_replace("_TRUSTEE_", " ".$trustee , $language);
								}
								if(strpos($language, '_GRANTEE_') !== false) {
									$language = str_replace("_GRANTEE_", " ".$grantee , $language);
								}
								if(strpos($language, '_RECORDEDDATE_') !== false) {
									$language = str_replace("_RECORDEDDATE_", " ".$recordedDate , $language);
								}
								if(strpos($language, '_INSTRUMENTONLY_') !== false) {
									$language = str_replace("_INSTRUMENTONLY_", " ".$instrument , $language);
								}
								if(strpos($language, '_PARCELID1_') !== false) {
									$language = str_replace("_PARCELID1_", " ".$parcelID , $language);
								}
								
								if(strpos(strtolower($language), 'any liens or other assessments') !== false || strpos(strtolower($language), 'the lien of supplemental') !== false || strpos(strtolower($language), 'property taxes') !== false  )
									{
										// $tax[] = $language;
										$email_data['tax'][] = $language;
									}
									else
									{
										// $liens[] = $language;
										$email_data['liens'][] = $language;
									}

								$liens[] = $language;
								// $email_data['liens'][] = $language;
							}
						}
						$liensCount++;	    				
					}
				}

				$easements = array();
				if(isset($data['Easements']) && !empty($data['Easements']))
				{
					foreach ($data['Easements'] as $key => $easement) 
					{
						$language = isset($easement['Language']) && !empty($easement['Language']) ? $easement['Language'] : '';
						$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
						$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
						if(!empty($language))
						{
							$easements[] = $language;
						}
					}
				}

				$requirements = array();
				if(isset($data['Requirements']) && !empty($data['Requirements']))
				{
					foreach ($data['Requirements'] as $key => $requirement) 
					{
						$language = isset($requirement['Language']) && !empty($requirement['Language']) ? $requirement['Language'] : '';
						$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
						$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
						$amount = isset($requirement['Amount']) && !empty($requirement['Amount']) ? $requirement['Amount'] : '';
						$date = isset($requirement['Date']) && !empty($requirement['Date']) ? $requirement['Date'] : '';
						$grantor = isset($requirement['Grantor']) && !empty($requirement['Grantor']) ? $requirement['Grantor'] : '';
						$trustee = isset($requirement['Trustee']) && !empty($requirement['Trustee']) ? $requirement['Trustee'] : '';
						$grantee = isset($requirement['Grantee']) && !empty($requirement['Grantee']) ? $requirement['Grantee'] : '';
						$recordedDate = isset($requirement['RecordedDate']) && !empty($requirement['RecordedDate']) ? $requirement['RecordedDate'] : '';
						$instrument = isset($requirement['Instrument']) && !empty($requirement['Instrument']) ? $requirement['Instrument'] : '';
						
						if(strpos($language, '_AMOUNT_') !== false) {
							$language = str_replace("_AMOUNT_", " ".$amount , $language);
						}
						if(strpos($language, '_DATE_') !== false) {
							$language = str_replace("_DATE_", " ".$date , $language);
						}
						if(strpos($language, '_GRANTOR_') !== false) {
							$language = str_replace("_GRANTOR_", " ".$grantor , $language);
						}
						if(strpos($language, '_TRUSTEE_') !== false) {
							$language = str_replace("_TRUSTEE_", " ".$trustee , $language);
						}
						if(strpos($language, '_GRANTEE_') !== false) {
							$language = str_replace("_GRANTEE_", " ".$grantee , $language);
						}
						if(strpos($language, '_RECORDEDDATE_') !== false) {
							$language = str_replace("_RECORDEDDATE_", " ".$recordedDate , $language);
						}
						if(strpos($language, '_INSTRUMENTONLY_') !== false) {
							$language = str_replace("_INSTRUMENTONLY_", " ".$instrument , $language);
						}
						if(strpos($language, '_PARCELID1_') !== false) {
							$language = str_replace("_PARCELID1_", " ".$parcelID , $language);
						}
						
						if(!empty($language))
						{
							$requirements[] = $language;
						}
					}
				}
				
				$restrictions = array();
				
				if(isset($data['Restrictions']) && !empty($data['Restrictions']))
				{
					foreach ($data['Restrictions'] as $key => $restriction) 
					{
						$language = isset($restriction['Language']) && !empty($restriction['Language']) ? $restriction['Language'] : '';
						$language = preg_replace('/(.*):/', '<b>$1:</b>', $language);
						$language = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $language);
						if(!empty($language))
						{
							$restrictions[] = $language;
						}
					}
					
				}
	    		
	    		$summaryData = array(
	    			'file_number'=> $file_number,
	    			'vesting'=> $vesting,
	    			'generated_date'=> $generated_date,
	    			'lien'=> json_encode($liens),
	    			'easement'=> json_encode($easements),
	    			'requirements'=> json_encode($requirements),
					'restrictions'=> json_encode($restrictions),
					'resware_json' => $json,
					'parcel_id' => $parcelID
	    		);

	    		$con = array(
	                'where' => array(
	                    'file_number' => $file_number,
	                ),
	                'returnType' => 'count'
	            );
	            $prevCount = $this->reviewPrelimData->get_rows($con);
	            
	            if($prevCount > 0)
	            {
		            $condition = array('file_number' => $file_number);
		            $update = $this->reviewPrelimData->update($summaryData, $condition);
	            }
	            else
	            {
	            	$id = $this->reviewPrelimData->insert($summaryData);

	            	$condition = array(
			                'file_number' => $file_number
			        );
		    		$data = array(
						'prelim_summary_id'	=> $id
					);

		        	$this->order->update($data,$condition);
	            }
	    	}

	    	/* Send email to customer */


	        $condition = array(
	            'where' => array(
	                'file_number' => $file_number,
	            )
	        );

			$order_details = $this->order->get_rows($condition);

			$order_id = isset($order_details['id']) && !empty($order_details['id']) ? $order_details['id'] : '';
			$file_id = isset($order_details['file_id']) && !empty($order_details['file_id']) ? $order_details['file_id'] : '';

			/* Generate Docs */
			$orderDetails = $this->order->get_order_details($file_id,1);
			$documents = $this->order->get_order_documents($file_id,1);

			$customer_id = isset($order_details['customer_id']) && !empty($order_details['customer_id']) ? $order_details['customer_id'] : '';

			$orderUser =  $this->home_model->get_user(array('id' => $customer_id));
			$user_data = array();
			$user_data['email'] = $orderUser['email_address'];
			$user_data['password'] = $orderUser['random_password'];
			$user_data['from_mail'] = 1;

			$endPoint = 'files/'. $file_id .'/documents';
			$logid = $this->apiLogs->syncLogs($customer_id, 'resware', 'get_documents', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
			$resultDocuments = $this->resware->make_request('GET', $endPoint, '', $user_data);
			$this->apiLogs->syncLogs($customer_id, 'resware', 'get_documents', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocuments, $orderDetails['order_id'], $logid);
			$resDocuments = json_decode($resultDocuments, true);
			$documentCount  = count($documents);

			if (!empty($documents)) {
			$apiDocumentIds = array_column($documents, 'api_document_id');
			if (!empty($resDocuments['Documents'])) {
				foreach($resDocuments['Documents'] as $resDocument) {
					$ext = end(explode('.', $resDocument['DocumentName']));
					if (!in_array($resDocument['DocumentID'], $apiDocumentIds)) {
						$time = round((int)(str_replace("-0000)/", "", str_replace("/Date(", "", $resDocument['CreateDate'])))/1000);
						$created_date = date('Y-m-d H:i:s', $time);
						$document_name = date('YmdHis')."_".$resDocument['DocumentName'];
						if (($resDocument['DocumentType']['DocumentTypeID'] == 1032 || $resDocument['DocumentType']['DocumentTypeID'] == '1032' || strpos($resDocument['DocumentName'], 'Prelim') !== false) && (strtolower($ext) == 'doc' || strtolower($ext) == 'docx')) {
							$is_prelim_document = 1;
							$document_name = str_replace($ext, 'pdf', $document_name);
						} else {
							$is_prelim_document = 0;
							if(strtolower($ext) == 'doc' || strtolower($ext) == 'docx') {
								$document_name = str_replace($ext, 'pdf', $document_name);
							}
						}
						$documentData = array(
							'document_name' => $document_name,
							'original_document_name' => $resDocument['DocumentName'],
							'document_type_id' => $resDocument['DocumentType']['DocumentTypeID'],
							'api_document_id' => $resDocument['DocumentID'],
							'document_size' => $resDocument['Size'],
							'user_id' => $customer_id,
							'order_id' => $orderDetails['order_id'],
							'description' => $resDocument['DocumentName'],
							'created' => $created_date,
							'is_sync' => 0,
							'is_prelim_document' => $is_prelim_document
						);
						$documentId = $this->document->insert($documentData);

						if($is_prelim_document == 1) {
							$prelimDocument['original_document_name'] = $resDocument['DocumentName'];
							$prelimDocument['document_name'] = $document_name;
							$prelimDocument['api_document_id'] = $resDocument['DocumentID'];
							$prelimDocument['is_sync'] = 0;
							$prelimDocument['order_id'] = $orderDetails['order_id'];
							$prelimDocument['is_prelim_document'] =  $is_prelim_document;

							$endPoint = 'documents/'.$resDocument['DocumentID'].'?format=json';
							$logid = $this->apiLogs->syncLogs($customer_id, 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
							$resultDocument = $this->resware->make_request('GET', $endPoint, '', $user_data);
							$this->apiLogs->syncLogs($customer_id, 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocument, $orderDetails['order_id'], $logid);
							$resDocument = json_decode($resultDocument, true);

							if (isset($resDocument['Document']) && !empty($resDocument['Document'])) { 
								$documentContent = base64_decode($resDocument['Document']['DocumentBody'], true);
								if (!is_dir('uploads/documents')) {
									mkdir(FCPATH.'/uploads/documents', 0777, TRUE);
								}
								file_put_contents(FCPATH.'/uploads/documents/'.$document_name, $documentContent);
								$this->document->update(array('is_sync' => 1), array('api_document_id' => $resDocument['DocumentID']));

								$source_pdf = FCPATH.'/uploads/documents/'.$document_name;
								\Gufy\PdfToHtml\Config::set('pdftohtml.bin', getenv('PDFTOHTML_PATH'));
								\Gufy\PdfToHtml\Config::set('pdfinfo.bin', getenv('PDFTOINFO_PATH'));
								$pdf = new \Gufy\PdfToHtml\Pdf($source_pdf);
								$pages = array(4, 5, 6, 7, 8, 9);
								$linkedDocCount = 0;
								foreach ($pages as $page) {
									$html = $pdf->html($page);
									$total_pages = $pdf->getPages();
									$htmlDom = new DOMDocument;
									@$htmlDom->loadHTML($html);
									$links = $htmlDom->getElementsByTagName('a');
									$extractedLinks = array();
									
									foreach($links as $link) {
										$linkText = $link->nodeValue;
										$linkHref = $link->getAttribute('href');
										if(strlen(trim($linkHref)) == 0){
											continue;
										}

										if($linkHref[0] == '#'){
											continue;
										}
									
										if(strpos($linkHref, 'clients.pacificcoasttitle.com') !== false){
											$linkText = str_replace(' ', '-', $linkText); 
											$linkText = preg_replace('/[^A-Za-z0-9\-]/', '', $linkText).'.pdf';
											if($linkText == '.pdf' || strtolower($linkText) == 'no-.pdf'){
												continue;
											}
											$document_name = date('YmdHis')."_".$linkText;
											$documentId = explode('=', $linkHref);
											if (!in_array($documentId[1], $apiDocumentIds))  {
												file_put_contents(FCPATH.'/uploads/documents/'.$document_name, file_get_contents($linkHref));
												$fileSize = filesize(FCPATH.'/uploads/documents/'.$document_name);
												$documentData = array(
													'document_name' => $document_name,
													'original_document_name' => $linkText,
													'document_type_id' => 0,
													'api_document_id' => $documentId[1],
													'document_size' => $fileSize,
													'user_id' => $customer_id,
													'order_id' => $orderDetails['order_id'],
													'description' => "",
													'created' => date('Y-m-d H:i:s'),
													'is_sync' => 1,
													'is_prelim_document' => 0,
													'is_linked_doc' => 1
												);
												$document_id = $this->document->insert($documentData);
												$linked_doc[$linkedDocCount]['original_document_name'] = $linkText;
												$linked_doc[$linkedDocCount]['document_name'] = $document_name;
												$linked_doc[$linkedDocCount]['api_document_id'] = $documentId[1];
												$linked_doc[$linkedDocCount]['is_sync'] = 1;
												$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
												$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
												$apiDocumentIds[] = $documentId[1];
											} 
											$linkedDocCount++;
										} else{
											continue;
										}
									}
								}
							}	
						} else {
							$documents[$documentCount]['original_document_name'] = $resDocument['DocumentName'];
							$documents[$documentCount]['document_name'] = $document_name;
							$documents[$documentCount]['api_document_id'] = $resDocument['DocumentID'];
							$documents[$documentCount]['is_sync'] = 0;
							$documents[$documentCount]['is_prelim_document'] = $is_prelim_document;
							$documents[$documentCount]['order_id'] = $orderDetails['order_id'];
							$documentCount++;
						}
					} else if (($resDocument['DocumentType']['DocumentTypeID'] == 1032 || $resDocument['DocumentType']['DocumentTypeID'] == '1032' || strpos($resDocument['DocumentName'], 'Prelim') !== false) && (strtolower($ext) == 'doc' || strtolower($ext) == 'docx')) {
						$key = array_search(1, array_column($documents, 'is_prelim_document'));
						$prelimDocument['original_document_name'] = $documents[$key]['original_document_name'];
						$prelimDocument['document_name'] = $documents[$key]['document_name'];
						$prelimDocument['api_document_id'] = $documents[$key]['api_document_id'];
						$prelimDocument['is_sync'] = $documents[$key]['is_sync'];
						$prelimDocument['order_id'] = $orderDetails['order_id'];
						array_splice($documents, $key, 1);
						$keys = array_keys(array_column($documents, 'is_linked_doc'), 1);
						$linkedDocCount = 0;
						foreach($keys as $key) {
							$linked_doc[$linkedDocCount]['original_document_name'] = $documents[$key]['original_document_name'];
							$linked_doc[$linkedDocCount]['document_name'] = $documents[$key]['document_name'];
							$linked_doc[$linkedDocCount]['api_document_id'] = $documents[$key]['api_document_id'];
							$linked_doc[$linkedDocCount]['is_sync'] = $documents[$key]['is_sync'];
							$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
							$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
							$linkedDocCount++;
						}
					}
				}	
			}
		} else {
			if (!empty($resDocuments['Documents'])) {
				foreach($resDocuments['Documents'] as $resDocument) {
					if (!in_array($resDocument['DocumentID'], $apiDocumentIds)) {
						$time = round((str_replace("-0000)/", "", str_replace("/Date(", "", $resDocument['CreateDate'])))/1000);
						$created_date = date('Y-m-d H:i:s', $time);
						$document_name = date('YmdHis')."_".$resDocument['DocumentName'];
						$ext = end(explode('.', $resDocument['DocumentName']));
						if (($resDocument['DocumentType']['DocumentTypeID'] == 1032 || $resDocument['DocumentType']['DocumentTypeID'] == '1032' || strpos($resDocument['DocumentName'], 'Prelim') !== false) && (strtolower($ext) == 'doc' || strtolower($ext) == 'docx')) {
							$is_prelim_document = 1;
							$document_name = str_replace($ext, 'pdf', $document_name);
						} else {
							$is_prelim_document = 0;
							if(strtolower($ext) == 'doc' || strtolower($ext) == 'docx') {
								$document_name = str_replace($ext, 'pdf', $document_name);
							}
						}
						$documentData = array(
							'document_name' => $document_name,
							'original_document_name' => $resDocument['DocumentName'],
							'document_type_id' => $resDocument['DocumentType']['DocumentTypeID'],
							'api_document_id' => $resDocument['DocumentID'],
							'document_size' => $resDocument['Size'],
							'user_id' => $customer_id,
							'order_id' => $orderDetails['order_id'],
							'description' => $resDocument['DocumentName'],
							'created' => $created_date,
							'is_sync' => 0,
							'is_prelim_document' => $is_prelim_document
						);   
						$documentId = $this->document->insert($documentData);
						if($is_prelim_document == 1) {
							$prelimDocument['original_document_name'] = $resDocument['DocumentName'];
							$prelimDocument['document_name'] = $document_name;
							$prelimDocument['api_document_id'] = $resDocument['DocumentID'];
							$prelimDocument['is_sync'] = 0;
							$prelimDocument['is_prelim_document'] =  $is_prelim_document;
							$prelimDocument['order_id'] = $orderDetails['order_id'];

							$endPoint = 'documents/'.$resDocument['DocumentID'].'?format=json';
							$logid = $this->apiLogs->syncLogs($customer_id, 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), array(), $orderDetails['order_id'], 0);
							$resultDocument = $this->resware->make_request('GET', $endPoint, '', $user_data);
							$this->apiLogs->syncLogs($customer_id, 'resware', 'get_document', env('RESWARE_ORDER_API').$endPoint, array(), $resultDocument, $orderDetails['order_id'], $logid);
							$resDocument = json_decode($resultDocument, true);

							if (isset($resDocument['Document']) && !empty($resDocument['Document'])) { 
								$documentContent = base64_decode($resDocument['Document']['DocumentBody'], true);
								if (!is_dir('uploads/documents')) {
									mkdir(FCPATH.'/uploads/documents', 0777, TRUE);
								}
								file_put_contents(FCPATH.'/uploads/documents/'.$document_name, $documentContent);
								$this->document->update(array('is_sync' => 1), array('api_document_id' => $resDocument['DocumentID']));

								$source_pdf = FCPATH.'/uploads/documents/'.$document_name;
								chmod($source_pdf, 0755);
								\Gufy\PdfToHtml\Config::set('pdftohtml.bin', getenv('PDFTOHTML_PATH'));
								\Gufy\PdfToHtml\Config::set('pdfinfo.bin', getenv('PDFTOINFO_PATH'));
								$pdf = new \Gufy\PdfToHtml\Pdf($source_pdf);
								$pages = array(4, 5, 6, 7, 8, 9);
								$linkedDocCount = 0;
								foreach ($pages as $page) {
									$html = $pdf->html($page);
									$total_pages = $pdf->getPages();
									$htmlDom = new DOMDocument();
									@$htmlDom->loadHTML($html);
									if(!$htmlDom) {
										echo 'failed to load DOM';
										exit;
									} else {
										$links = $htmlDom->getElementsByTagName('a');
										$extractedLinks = array();

										foreach($links as $link) {
											$linkText = $link->nodeValue;
											$linkHref = $link->getAttribute('href');
											if(strlen(trim($linkHref)) == 0){
												continue;
											}

											if($linkHref[0] == '#'){
												continue;
											}
										
											if(strpos($linkHref, 'clients.pacificcoasttitle.com') !== false){
												$linkText = str_replace(' ', '-', $linkText); 
												$linkText = preg_replace('/[^A-Za-z0-9\-]/', '', $linkText).'.pdf';
												if($linkText == '.pdf' || strtolower($linkText) == 'no-.pdf'){
													continue;
												}
												$document_name = date('YmdHis')."_".$linkText;
												$documentId = explode('=', $linkHref);
												if (!in_array($documentId[1], $apiDocumentIds))  {
													file_put_contents(FCPATH.'/uploads/documents/'.$document_name, file_get_contents($linkHref));
													$fileSize = filesize(FCPATH.'/uploads/documents/'.$document_name);
													$documentData = array(
														'document_name' => $document_name,
														'original_document_name' => $linkText,
														'document_type_id' => 0,
														'api_document_id' => $documentId[1],
														'document_size' => $fileSize,
														'user_id' => $customer_id,
														'order_id' => $orderDetails['order_id'],
														'description' => "",
														'created' => date('Y-m-d H:i:s'),
														'is_sync' => 1,
														'is_prelim_document' => 0,
														'is_linked_doc' => 1
													);
													$document_id = $this->document->insert($documentData);
													$linked_doc[$linkedDocCount]['original_document_name'] = $linkText;
													$linked_doc[$linkedDocCount]['document_name'] = $document_name;
													$linked_doc[$linkedDocCount]['api_document_id'] = $documentId[1];
													$linked_doc[$linkedDocCount]['is_sync'] = 1;
													$linked_doc[$linkedDocCount]['is_prelim_document'] = 0;
													$linked_doc[$linkedDocCount]['order_id'] = $orderDetails['order_id'];
													$apiDocumentIds[] = $documentId[1];
												} 
												$linkedDocCount++;
											} else{
												continue;
											}
										}
									}
									
								}
							}
						} else {
							$documents[$documentCount]['original_document_name'] = $resDocument['DocumentName'];
							$documents[$documentCount]['document_name'] = $document_name;
							$documents[$documentCount]['api_document_id'] = $resDocument['DocumentID'];
							$documents[$documentCount]['is_sync'] = 0;
							$documents[$documentCount]['is_prelim_document'] = $is_prelim_document;
							$documents[$documentCount]['order_id'] = $orderDetails['order_id'];
							$documentCount++;
						}
					}
				}	
			}
		}
			
			/* Generate Docs */			

	    	/*if(isset($email_data) && !empty($email_data))
	    	{
	    		foreach ($email_data as $key => $value) 
	    		{
	    			foreach ($value as $k => $v)
	    			{
	    				$dom = new DomDocument();
						$dom->loadHTML($v);
						foreach ($dom->getElementsByTagName('a') as $item) 
						{
						    $output = array (
						      'str' => $dom->saveHTML($item),
						      'href' => $item->getAttribute('href'),
						      'anchorText' => $item->nodeValue
						   	);

						   	if(isset($output) && !empty($output))
							{
								$linkHref = $output['href'];
								$doc_link = explode('=', $linkHref);
								$document_id = isset($doc_link[1]) && !empty($doc_link[1]) ? $doc_link[1] : '';

								$documentDetail = $this->order->get_document_detail($document_id, $order_id);

								if(empty($documentDetail))
								{
									$document_name = date('YmdHis')."_".trim($output['anchorText']).'.pdf';
									$original_doc_name = trim($output['anchorText']).'.pdf';
									
									$doc_url = 'http://clients.pacificcoasttitle.com/DownloadDocument.aspx?'.$linkHref;		

									file_put_contents('./uploads/documents/'.$document_name, file_get_contents($doc_url));

									$fileSize = filesize('./uploads/documents/'.$document_name);
									$new_href = base_url().'uploads/documents/'.$document_name;
									$documentData = array(
										'document_name' => $document_name,
										'original_document_name' => $original_doc_name,
										'document_type_id' => 0,
										'api_document_id' => $document_id,
										'document_size' => $fileSize,
										'user_id' => $customer_id,
										'order_id' => $order_id,
										'description' => "",
										'created' => date('Y-m-d H:i:s'),
										'is_sync' => 1,
										'is_prelim_document' => 0,
										'is_linked_doc' => 1
									);
									$documentId = $this->document->insert($documentData);

									$item->setAttribute('href', $new_href);
									$item->setAttribute('download',$document_name);

									$email_data[$key][$k] = $dom->saveHTML();
									
								}
								else
								{
									$document_name = isset($documentDetail['document_name']) && !empty($documentDetail['document_name']) ? $documentDetail['document_name'] : '';

									$new_href = base_url().'uploads/documents/'.$document_name;
									$item->setAttribute('href', $new_href);
									$item->setAttribute('download',$document_name);

									$email_data[$key][$k] = $dom->saveHTML();
								}
							}
						}
						
	    			}
	    		}
	    	}*/
	    	

			$file = array();
			$prelimfilename = $prelimDocument['document_name'];
			
			if (file_exists(FCPATH.'uploads/documents/'.$prelimfilename))
			{
				$file[] = base_url().'uploads/documents/'.$prelimfilename;
			}

	    	$emailContent['file_number'] = $file_number;
	    	$emailContent['tax'] = isset($email_data['tax']) && !empty($email_data['tax']) ? json_encode($email_data['tax']) : '';
	    	$emailContent['liens'] = isset($email_data['liens']) && !empty($email_data['liens']) ? json_encode($email_data['liens']) : '';

			$from_name = 'Pacific Coast Title Company';
			$from_mail = env('FROM_EMAIL');
			$prelim_message_body = $this->load->view('emails/prelim.php',$emailContent,TRUE);
			$message = $prelim_message_body; 
			$subject = 'The Prelim Hot Sheet';
			$to = $customer_email;
			/*$to = 'hitesh.p@crestinfosystems.com';*/
			
			$this->load->helper('sendemail');
			
			$mail_result = send_email($from_mail,$from_name, $to, $subject, $message,$file);

			$result = array();
			if($mail_result)
			{
				$result['mail_status'] = 'success';
			}
			else
			{
				$result['mail_status'] = 'error';		
			}
	    	/* Send email to customer */
	    	$result['message'] = "Data stored successfully.";
    	}
    	else
    	{
    		$result['message'] = "Empty response received.";
    	}
    	echo json_encode($result);
    }

	function multiexplode($delimiters,$string) 
	{

	    $ready = str_replace($delimiters, $delimiters[0], $string);
	    $launch = explode($delimiters[0], $ready);
	    return  $launch;
	}
}

