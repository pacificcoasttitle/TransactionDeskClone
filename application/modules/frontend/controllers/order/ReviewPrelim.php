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
		
		$json = file_get_contents('php://input');
		
		if ($json) 
		{
			$logId = $this->apiLogs->syncLogs(0,'resware WCF', 'get_prelim','https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', array('ReceiveSearchDataService'=>true), array());
			$this->apiLogs->syncLogs(0, 'resware WCF', 'get_prelim', 'https://mypctrep.com/ReceiveSearchDataService.svc?wsdl', array(), $json, 0, $logId);
			$dir_name = APPPATH.'logs/prelim';

			if (!is_dir($dir_name)) {
				mkdir($dir_name);
			}

			$file = APPPATH.'logs/prelim/response.log';

			if (file_exists($file)) {
				$fh = fopen($file, 'a');
			} else {
				$fh = fopen($file, 'w');
			}

			fwrite($fh, $json."\n");
			fclose($fh);
			$data = json_decode($json,TRUE);
			$this->db->select('*');
			$this->db->from('pct_order_code_book');
			$query = $this->db->get();
			$codeBooks = $query->result_array();
			
			if (isset($data) && !empty($data)) 
			{
				$file_number = isset($data['FileNumber']) && !empty($data['FileNumber']) ? $data['FileNumber'] : '';
				$condition = array(
					'where' => array(
						'file_number' => $file_number,
					)
				);
	
				$order_details = $this->order->get_rows($condition);
				if(isset($order_details) && !empty($order_details))
				{

					$parcelID = isset($data['ParcelID']) && !empty($data['ParcelID']) ? $data['ParcelID'] : '';
					$vesting = isset($data['Vesting']) && !empty($data['Vesting']) ? $data['Vesting'] : '';
					$generated_date = isset($data['CommitmentEffectiveDate']) && !empty($data['CommitmentEffectiveDate']) ? date('Y-m-d H:i:s', strtotime($data['CommitmentEffectiveDate'])) : '';
					$tax = $liens = $email_data = array();
					$documentIds = array();
					$arr_find = array("_BOOKONLY_", "_DATE_", "_DOCUMENTNAME_", "_GRANTEE_", "_GRANTOR_", "_INSTRUMENTONLY_", "_RECORDEDDATE_", "_RECORDDATE_", "_PURPOSE_", "_PAGEONLY_", "_LIBERONLY_", "_VOLUMEONLY_", "_AMOUNT_", "_TRUSTEE_", "_AGAINST_", "_ASSIGNOR_", "_ASSIGNEE_", "_ASSIGNEEBOOK_", "_ASSIGNEEBOOKONLY_", "_ASSIGNEEPAGE_", "_ASSIGNEEPAGEONLY_", "_ASSIGNEELIBER_", "_ASSIGNEELIBERONLY_", "_ASSIGNEEVOLUME_", "_ASSIGNEEVOLUMEONLY_", "_ASSIGNEEINSTRUMENT_", "_ASSIGNEEINSTRUMENTONLY_", "_BOOK_", "_CASENUMBER_", "_COUNTY_", "_COURTDISTRICT_", "_COURTTYPE_", "_ENDORSEMENTS_", "_HOLDER_", "_INFAVOROF_", "_INSTALLMENTNUMBER_", "_INSTRUMENT_", "_INSTALLMENTAMOUNT_", "_LIBER_", "_MATURITYDATE_", "_PAGE_", "_STATE_", "_STATEDISTRICT_", "_TAXYEARS_", "_VOLUME_", "_PARCELID1_");

						if (isset($data['Liens']) && !empty($data['Liens'])) {
							$liensCount = 1;
							$easementCheck = 0;
							$lienFlag =  1;
							foreach ($data['Liens'] as $key => $lien) {

								$language = '';
								$lienKey = array_search($lien['LienTypeID'], array_column($codeBooks, 'type_id'));
								$language = isset($lien['Language']) && !empty($lien['Language']) ? $lien['Language'] : '';

								if (isset($lienKey) && !empty($lienKey) && strpos($codeBooks[$lienKey]['language'], '___') === false) {
									$language = $codeBooks[$lienKey]['language'];
								} else {
									if (strpos($language, 'Amount:') !== false) {
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
								}

								$Book = isset($lien['Book']) && !empty($lien['Book']) ? $lien['Book'] : '';
								$Date = isset($lien['Date']) && !empty($lien['Date']) ? $lien['Date'] : '';
								$DocumentName = isset($lien['DocumentName']) && !empty($lien['DocumentName']) ? $lien['DocumentName'] : '';
								$Grantor = isset($lien['Grantor']) && !empty($lien['Grantor']) ? $lien['Grantor'] : '';
								$Grantee = isset($lien['Grantee']) && !empty($lien['Grantee']) ? $lien['Grantee'] : '';
								$Instrument = isset($lien['Instrument']) && !empty($lien['Instrument']) ? $lien['Instrument'] : '';
								$RecordedDate = isset($lien['RecordedDate']) && !empty($lien['RecordedDate']) ? $lien['RecordedDate'] : '';
								$Purpose = isset($lien['Purpose']) && !empty($lien['Purpose']) ? $lien['Purpose'] : '';
								$Page = isset($lien['Page']) && !empty($lien['Page']) ? $lien['Page'] : '';
								$Liber = isset($lien['Liber']) && !empty($lien['Liber']) ? $lien['Liber'] : '';
								$Volume = isset($lien['Volume']) && !empty($lien['Volume']) ? $lien['Volume'] : '';
								$Amount = isset($lien['Amount']) && !empty($lien['Amount']) ? $lien['Amount'] : '';
								$Trustee = isset($lien['Trustee']) && !empty($lien['Trustee']) ? $lien['Trustee'] : '';
								$Against = isset($lien['Against']) && !empty($lien['Against']) ? $lien['Against'] : '';
								$Assignor = isset($lien['Assignor']) && !empty($lien['Assignor']) ? $lien['Assignor'] : '';
								$Assignee = isset($lien['Assignee']) && !empty($lien['Assignee']) ? $lien['Assignee'] : '';
								$AssigneeBook = isset($lien['AssigneeBook']) && !empty($lien['AssigneeBook']) ? $lien['AssigneeBook'] : '';
								$AssigneePage = isset($lien['AssigneePage']) && !empty($lien['AssigneePage']) ? $lien['AssigneePage'] : '';
								$AssigneeLiber = isset($lien['AssigneeLiber']) && !empty($lien['AssigneeLiber']) ? $lien['AssigneeLiber'] : '';
								$AssigneeVolume = isset($lien['AssigneeVolume']) && !empty($lien['AssigneeVolume']) ? $lien['AssigneeVolume'] : '';
								$AssigneeInstrument = isset($lien['AssigneeInstrument']) && !empty($lien['AssigneeInstrument']) ? $lien['AssigneeInstrument'] : '';
								$CaseNumber = isset($lien['CaseNumber']) && !empty($lien['CaseNumber']) ? $lien['CaseNumber'] : '';
								$County = isset($lien['County']) && !empty($lien['County']) ? $lien['County'] : '';
								$CourtDistrict = isset($lien['CourtDistrict']) && !empty($lien['CourtDistrict']) ? $lien['CourtDistrict'] : '';
								$CourtType = isset($lien['CourtType']) && !empty($lien['CourtType']) ? $lien['CourtType'] : '';
								$Endorsements = isset($lien['Endorsements']) && !empty($lien['Endorsements']) ? $lien['Endorsements'] : '';
								$Holder = isset($lien['Holder']) && !empty($lien['Holder']) ? $lien['Holder'] : '';
								$InFavorOf = isset($lien['InFavorOf']) && !empty($lien['InFavorOf']) ? $lien['InFavorOf'] : '';
								$InstallmentNumber = isset($lien['InstallmentNumber']) && !empty($lien['InstallmentNumber']) ? $lien['InstallmentNumber'] : '';
								$InstallmentAmount = isset($lien['InstallmentAmount']) && !empty($lien['InstallmentAmount']) ? $lien['InstallmentAmount'] : '';
								$MaturityDate = isset($lien['MaturityDate']) && !empty($lien['MaturityDate']) ? $lien['MaturityDate'] : '';
								$State = isset($lien['State']) && !empty($lien['State']) ? $lien['State'] : '';
								$StateDistrict = isset($lien['StateDistrict']) && !empty($lien['StateDistrict']) ? $lien['StateDistrict'] : '';
								$TaxYears = isset($lien['TaxYears']) && !empty($lien['TaxYears']) ? $lien['TaxYears'] : '';

								
								$result = array();
								$language1 = '';
								$language1 = isset($lien['Language']) && !empty($lien['Language']) ? $lien['Language'] : '';
								preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $language1, $result);

								if (!empty($result) && !empty($result['href'][0])) {
									$link = $result['href'][0];
									$documentId = str_replace('http://clients.pacificcoasttitle.com/DownloadDocument.aspx?DocumentID=', '', $link);
									$documentIds[$documentId] = $liensCount;
									$sync = 1;
									$order_id = $order_details['id'];
									$onclick = "href='javascript:void(0)' style='cusror:pointer !important;' onclick='load_doc($sync, $documentId, $order_id)'";
									if(!empty($Instrument)) {
										$Instrument = "<a $onclick>".$Instrument."</a>";
									}
								}	

								$arr_rep = array($Book, $Date, $DocumentName, $Grantee, $Grantor, $Instrument, $RecordedDate, $RecordedDate, $Purpose, $Page, $Liber, $Volume, $Amount, $Trustee, $Against, $Assignor, $Assignee, $AssigneeBook, $AssigneeBook, $AssigneePage, $AssigneePage, $AssigneeLiber, $AssigneeLiber, $AssigneeVolume, $AssigneeVolume, $AssigneeInstrument, $AssigneeInstrument, $Book, $CaseNumber, $County, $CourtDistrict, $CourtType, $Endorsements, $Holder, $InFavorOf, $InstallmentNumber, $Instrument, $InstallmentAmount, $Liber, $MaturityDate, $Page, $State, $StateDistrict, $TaxYears, $Volume, $parcelID);
								$language = str_replace($arr_find, $arr_rep, $language);

								if(strpos($language, 'Tax Identification No') !== false) 
								{
									$pos = strpos($language, 'Tax Identification No');
									$sub_str = substr($language,0,$pos);							
									$language = substr($language,$pos);
									preg_match_all('/[a-zA-Z0-9. ]+: (\S+)/', $language, $matches);
									$language = $sub_str."\n";

									if(isset($matches[0]) && !empty($matches[0])) {
										foreach ($matches[0] as $key => $value)  {
											$a = explode(":", $value);
											if (strtolower($a[0]) == 'tax identification no.') {
												$str= "\n<strong>".$a[0].": </strong><a $onclick>".$parcelID."</a>";
											} else {
												$str= '<strong>'.$a[0].': </strong>'.$a[1];
											}
											$language .= $str."\n";
										}
									}
								}
								
								if(strpos(strtolower($language), 'any liens or other assessments') !== false || strpos(strtolower($language), 'the lien of supplemental') !== false || strpos(strtolower($language), 'property taxes') !== false ) {
									$tax[] = $language;
									$email_data['tax'][] = $language;
								} else {
									
									if($easementCheck == 0) {
										$easements = array();
										if (isset($data['Easements']) && !empty($data['Easements']))  {

											foreach ($data['Easements'] as $key => $easement) {

												$easementLanguage = '';
												$easementKey = array_search($easement['EasementTypeID'], array_column($codeBooks, 'type_id'));
												$easementLanguage = isset($easement['Language']) && !empty($easement['Language']) ? $easement['Language'] : '';
								
												if (isset($easementKey) && !empty($easementKey) && strpos($codeBooks[$easementKey]['language'], '___') === false) {
													$easementLanguage = $codeBooks[$easementKey]['language']; 
												} else {
													if (strpos($language, 'Purpose:') !== false) {
														$e_pos = strpos($language, 'Purpose:');
														$e_sub_str_main = substr($language,0,$e_pos);						
														$language = substr($language,$e_pos);
														$e_exploded_str = $this->multiexplode(array("_ "),$language);
														$e_formatted_data = array();

														if (isset($e_exploded_str) && !empty($e_exploded_str)) {
															foreach ($e_exploded_str as $e_key => $e_value)  {							
																$e_formatted_data[] = $e_value."_";
															} 
														}

														$language = $e_sub_str_main."\n";
														if (isset($e_formatted_data) && !empty($e_formatted_data)) {
															foreach ($e_formatted_data as $e_k => $e_v) {
																$e_str = explode(": ", $e_v);
																$e_format_str= '<strong>'.$e_str[0].': </strong>'.$e_str[1];
																$language .= $e_format_str."\n";
															}
														}
													}

													if (strpos($language, 'Executed by:') !== false) {
														$exe_exploded_str = $this->multiexplode(array("_ "),$language);
														$exe_formatted_data = array();
														if (isset($exe_exploded_str) && !empty($exe_exploded_str)) {
															foreach ($exe_exploded_str as $exe_key => $exe_value) {
																if (strpos($exe_value, 'Official Records') !== false) {
																	$exe_value = str_replace('Official Records', "Official Records \n", $exe_value);
																	
																	$exe_formatted_data[] = $exe_value;
																} else if(strpos($exe_value, 'Recording Date:') !== false) {
																	$rec_pos = strpos($exe_value, 'Recording Date:');
																	$rec_sub_str = substr($exe_value,0,$rec_pos);
																	$exe_formatted_data[] = $rec_sub_str;
																	$rec_truncate_str = substr($exe_value,$rec_pos);
																	$exe_formatted_data[] = $rec_truncate_str."_";
																	
																} else {
																	$exe_formatted_data[] = $exe_value."_";
																}

															} 
														}

														$language = "";
														if (isset($exe_formatted_data) && !empty($exe_formatted_data)) {
															foreach ($exe_formatted_data as $exe_k => $exe_v) {
																$exe_str = explode(": ", $exe_v);
																$count = count($exe_str);
																if ($count <= 2) {
																	$exe_format_str= '<strong>'.$exe_str[0].': </strong>'.$exe_str[1];
																} else {
																	$exe_format_str= '<strong>'.$exe_str[0].': </strong>'.$exe_str[1].": ".$exe_str[2];
																} 
																$language .= $exe_format_str."\n";
															}
														}	
													}
												}

												$Book = isset($easement['Book']) && !empty($easement['Book']) ? $easement['Book'] : '';
												$Date = isset($easement['Date']) && !empty($easement['Date']) ? $easement['Date'] : '';
												$DocumentName = isset($easement['DocumentName']) && !empty($easement['DocumentName']) ? $easement['DocumentName'] : '';
												$Grantor = isset($easement['Grantor']) && !empty($easement['Grantor']) ? $easement['Grantor'] : '';
												$Grantee = isset($easement['Grantee']) && !empty($easement['Grantee']) ? $easement['Grantee'] : '';
												$Instrument = isset($easement['Instrument']) && !empty($easement['Instrument']) ? $easement['Instrument'] : '';
												$RecordedDate = isset($easement['RecordedDate']) && !empty($easement['RecordedDate']) ? $easement['RecordedDate'] : '';
												$Purpose = isset($easement['Purpose']) && !empty($easement['Purpose']) ? $easement['Purpose'] : '';
												$Page = isset($easement['Page']) && !empty($easement['Page']) ? $easement['Page'] : '';
												$Liber = isset($easement['Liber']) && !empty($easement['Liber']) ? $easement['Liber'] : '';
												$Volume = isset($easement['Volume']) && !empty($easement['Volume']) ? $easement['Volume'] : '';
												$Amount = isset($easement['Amount']) && !empty($easement['Amount']) ? $easement['Amount'] : '';
												$Trustee = isset($easement['Trustee']) && !empty($easement['Trustee']) ? $easement['Trustee'] : '';
												$Against = isset($easement['Against']) && !empty($easement['Against']) ? $easement['Against'] : '';
												$Assignor = isset($easement['Assignor']) && !empty($easement['Assignor']) ? $easement['Assignor'] : '';
												$Assignee = isset($easement['Assignee']) && !empty($easement['Assignee']) ? $easement['Assignee'] : '';
												$AssigneeBook = isset($easement['AssigneeBook']) && !empty($easement['AssigneeBook']) ? $easement['AssigneeBook'] : '';
												$AssigneePage = isset($easement['AssigneePage']) && !empty($easement['AssigneePage']) ? $easement['AssigneePage'] : '';
												$AssigneeLiber = isset($easement['AssigneeLiber']) && !empty($easement['AssigneeLiber']) ? $easement['AssigneeLiber'] : '';
												$AssigneeVolume = isset($easement['AssigneeVolume']) && !empty($easement['AssigneeVolume']) ? $easement['AssigneeVolume'] : '';
												$AssigneeInstrument = isset($easement['AssigneeInstrument']) && !empty($easement['AssigneeInstrument']) ? $easement['AssigneeInstrument'] : '';
												$CaseNumber = isset($easement['CaseNumber']) && !empty($easement['CaseNumber']) ? $easement['CaseNumber'] : '';
												$County = isset($easement['County']) && !empty($easement['County']) ? $easement['County'] : '';
												$CourtDistrict = isset($easement['CourtDistrict']) && !empty($easement['CourtDistrict']) ? $easement['CourtDistrict'] : '';
												$CourtType = isset($easement['CourtType']) && !empty($easement['CourtType']) ? $easement['CourtType'] : '';
												$Endorsements = isset($easement['Endorsements']) && !empty($easement['Endorsements']) ? $easement['Endorsements'] : '';
												$Holder = isset($easement['Holder']) && !empty($easement['Holder']) ? $easement['Holder'] : '';
												$InFavorOf = isset($easement['InFavorOf']) && !empty($easement['InFavorOf']) ? $easement['InFavorOf'] : '';
												$InstallmentNumber = isset($easement['InstallmentNumber']) && !empty($easement['InstallmentNumber']) ? $easement['InstallmentNumber'] : '';
												$InstallmentAmount = isset($easement['InstallmentAmount']) && !empty($easement['InstallmentAmount']) ? $easement['InstallmentAmount'] : '';
												$MaturityDate = isset($easement['MaturityDate']) && !empty($easement['MaturityDate']) ? $easement['MaturityDate'] : '';
												$State = isset($easement['State']) && !empty($easement['State']) ? $easement['State'] : '';
												$StateDistrict = isset($easement['StateDistrict']) && !empty($easement['StateDistrict']) ? $easement['StateDistrict'] : '';
												$TaxYears = isset($easement['TaxYears']) && !empty($easement['TaxYears']) ? $easement['TaxYears'] : '';

												
												$easementResult = array();
												$easementLanguage1 = '';
												$easementLanguage1 = isset($easement['Language']) && !empty($easement['Language']) ? $easement['Language'] : '';
												preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $easementLanguage1, $easementResult);

												if (!empty($easementResult) && !empty($easementResult['href'][0])) {
													$link = $easementResult['href'][0];
													$documentId = str_replace('http://clients.pacificcoasttitle.com/DownloadDocument.aspx?DocumentID=', '', $link);
													$documentIds[$documentId] = $liensCount;
													if(!empty($Instrument)) {
														$sync = 1;
														$order_id = $order_details['id'];
														$onclick = "href='javascript:void(0)' style='cusror:pointer !important;' onclick='load_doc($sync, $documentId, $order_id)'";
														$Instrument = "<a $onclick>".$Instrument."</a>";
													}
												}
								
												$arr_rep = array($Book, $Date, $DocumentName, $Grantee, $Grantor, $Instrument, $RecordedDate, $RecordedDate, $Purpose, $Page, $Liber, $Volume, $Amount, $Trustee, $Against, $Assignor, $Assignee, $AssigneeBook, $AssigneeBook, $AssigneePage, $AssigneePage, $AssigneeLiber, $AssigneeLiber, $AssigneeVolume, $AssigneeVolume, $AssigneeInstrument, $AssigneeInstrument, $Book, $CaseNumber, $County, $CourtDistrict, $CourtType, $Endorsements, $Holder, $InFavorOf, $InstallmentNumber, $Instrument, $InstallmentAmount, $Liber, $MaturityDate, $Page, $State, $StateDistrict, $TaxYears, $Volume, $parcelID);
												$easementLanguage = str_replace($arr_find, $arr_rep, $easementLanguage); 
												if(!empty($easementLanguage)) {
													$easements[] = $easementLanguage;
												}
												$liensCount++;
											}
											$easementCheck++;
										}
									}
									if ($lienFlag == 1) {
										
										if (!empty($result) && !empty($result['href'][0])) {
											$link = $result['href'][0];
											$documentId = str_replace('http://clients.pacificcoasttitle.com/DownloadDocument.aspx?DocumentID=', '', $link);
											$documentIds[$documentId] = $liensCount;
										}
									}
									$lienFlag++;
									$liens[] = $language;
									$email_data['liens'][] = $language;
								}
								$liensCount++;	
							}
						}

									$requirements = array();
									$requirementCount = 1;
									if(isset($data['Requirements']) && !empty($data['Requirements'])) {
										foreach ($data['Requirements'] as $key => $requirement) {
											$language = '';
											$requirementKey = array_search($requirement['RequirementTypeID'], array_column($codeBooks, 'type_id'));
											$language = isset($requirement['Language']) && !empty($requirement['Language']) ? $requirement['Language'] : '';

											if (isset($requirementKey) && !empty($requirementKey) && strpos($codeBooks[$requirementKey]['language'], '___') === false) {
												$language = $codeBooks[$requirementKey]['language'];
											}

											$Book = isset($requirement['Book']) && !empty($requirement['Book']) ? $requirement['Book'] : '';
											$Date = isset($requirement['Date']) && !empty($requirement['Date']) ? $requirement['Date'] : '';
											$DocumentName = isset($requirement['DocumentName']) && !empty($requirement['DocumentName']) ? $requirement['DocumentName'] : '';
											$Grantee = isset($requirement['Grantee']) && !empty($requirement['Grantee']) ? $requirement['Grantee'] : '';
											$Grantor = isset($requirement['Grantor']) && !empty($requirement['Grantor']) ? $requirement['Grantor'] : '';
											$Instrument = isset($requirement['Instrument']) && !empty($requirement['Instrument']) ? $requirement['Instrument'] : '';
											$RecordedDate = isset($requirement['RecordedDate']) && !empty($requirement['RecordedDate']) ? $requirement['RecordedDate'] : '';
											$Purpose = isset($requirement['Purpose']) && !empty($requirement['Purpose']) ? $requirement['Purpose'] : '';
											$Page = isset($requirement['Page']) && !empty($requirement['Page']) ? $requirement['Page'] : '';
											$Liber = isset($requirement['Liber']) && !empty($requirement['Liber']) ? $requirement['Liber'] : '';
											$Volume = isset($requirement['Volume']) && !empty($requirement['Volume']) ? $requirement['Volume'] : '';
											$Amount = isset($requirement['Amount']) && !empty($requirement['Amount']) ? $requirement['Amount'] : '';
											$Trustee = isset($requirement['Trustee']) && !empty($requirement['Trustee']) ? $requirement['Trustee'] : '';
											$Against = isset($requirement['Against']) && !empty($requirement['Against']) ? $requirement['Against'] : '';
											$Assignor = isset($requirement['Assignor']) && !empty($requirement['Assignor']) ? $requirement['Assignor'] : '';
											$Assignee = isset($requirement['Assignee']) && !empty($requirement['Assignee']) ? $requirement['Assignee'] : '';
											$AssigneeBook = isset($requirement['AssigneeBook']) && !empty($requirement['AssigneeBook']) ? $requirement['AssigneeBook'] : '';
											$AssigneePage = isset($requirement['AssigneePage']) && !empty($requirement['AssigneePage']) ? $requirement['AssigneePage'] : '';
											$AssigneeLiber = isset($requirement['AssigneeLiber']) && !empty($requirement['AssigneeLiber']) ? $requirement['AssigneeLiber'] : '';
											$AssigneeVolume = isset($requirement['AssigneeVolume']) && !empty($requirement['AssigneeVolume']) ? $requirement['AssigneeVolume'] : '';
											$AssigneeInstrument = isset($requirement['AssigneeInstrument']) && !empty($requirement['AssigneeInstrument']) ? $requirement['AssigneeInstrument'] : '';
											$CaseNumber = isset($requirement['CaseNumber']) && !empty($requirement['CaseNumber']) ? $requirement['CaseNumber'] : '';
											$County = isset($requirement['County']) && !empty($requirement['County']) ? $requirement['County'] : '';
											$CourtDistrict = isset($requirement['CourtDistrict']) && !empty($requirement['CourtDistrict']) ? $requirement['CourtDistrict'] : '';
											$CourtType = isset($requirement['CourtType']) && !empty($requirement['CourtType']) ? $requirement['CourtType'] : '';
											$Endorsements = isset($requirement['Endorsements']) && !empty($requirement['Endorsements']) ? $requirement['Endorsements'] : '';
											$Holder = isset($requirement['Holder']) && !empty($requirement['Holder']) ? $requirement['Holder'] : '';
											$InFavorOf = isset($requirement['InFavorOf']) && !empty($requirement['InFavorOf']) ? $requirement['InFavorOf'] : '';
											$InstallmentNumber = isset($requirement['InstallmentNumber']) && !empty($requirement['InstallmentNumber']) ? $requirement['InstallmentNumber'] : '';
											$InstallmentAmount = isset($requirement['InstallmentAmount']) && !empty($requirement['InstallmentAmount']) ? $requirement['InstallmentAmount'] : '';
											$MaturityDate = isset($requirement['MaturityDate']) && !empty($requirement['MaturityDate']) ? $requirement['MaturityDate'] : '';
											$State = isset($requirement['State']) && !empty($requirement['State']) ? $requirement['State'] : '';
											$StateDistrict = isset($requirement['StateDistrict']) && !empty($requirement['StateDistrict']) ? $requirement['StateDistrict'] : '';
											$TaxYears = isset($requirement['TaxYears']) && !empty($requirement['TaxYears']) ? $requirement['TaxYears'] : '';

											
											$result = array();

											$requirementLanguage = '';
											$requirementLanguage = isset($requirement['Language']) && !empty($requirement['Language']) ? $requirement['Language'] : '';
											preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $requirementLanguage, $result);

											if (!empty($result) && !empty($result['href'][0])) {
												$link = $result['href'][0];
												$documentId = str_replace('http://clients.pacificcoasttitle.com/DownloadDocument.aspx?DocumentID=', '', $link);
												$documentIds[$documentId] = $liensCount;
												if(!empty($Instrument)) {
													$sync = 1;
													$order_id = $order_details['id'];
													$onclick = "href='javascript:void(0)' style='cusror:pointer !important;' onclick='load_doc($sync, $documentId, $order_id)'";
													$Instrument = "<a $onclick>".$Instrument."</a>";
												}
											}	
											$arr_rep = array($Book, $Date, $DocumentName, $Grantee, $Grantor, $Instrument, $RecordedDate, $RecordedDate, $Purpose, $Page, $Liber, $Volume, $Amount, $Trustee, $Against, $Assignor, $Assignee, $AssigneeBook, $AssigneeBook, $AssigneePage, $AssigneePage, $AssigneeLiber, $AssigneeLiber, $AssigneeVolume, $AssigneeVolume, $AssigneeInstrument, $AssigneeInstrument, $Book, $CaseNumber, $County, $CourtDistrict, $CourtType, $Endorsements, $Holder, $InFavorOf, $InstallmentNumber, $Instrument, $InstallmentAmount, $Liber, $MaturityDate, $Page, $State, $StateDistrict, $TaxYears, $Volume, $parcelID);
											
											$language = str_replace($arr_find, $arr_rep, $language); 
											
											if (!empty($language)) {
												$requirements[] = $language;
											}
											$liensCount++;
										}
									}
									
									$restrictions = array();
									$restrictionsCount = 0;
									if (isset($data['Restrictions']) && !empty($data['Restrictions'])) {
										foreach ($data['Restrictions'] as $key => $restriction) {
											$language = isset($restriction['Language']) && !empty($restriction['Language']) ? $restriction['Language'] : '';
											$Book = isset($restriction['Book']) && !empty($restriction['Book']) ? $restriction['Book'] : '';
											$Date = isset($restriction['Date']) && !empty($restriction['Date']) ? $restriction['Date'] : '';
											$DocumentName = isset($restriction['DocumentName']) && !empty($restriction['DocumentName']) ? $restriction['DocumentName'] : '';
											$Grantee = isset($restriction['Grantee']) && !empty($restriction['Grantee']) ? $restriction['Grantee'] : '';
											$Instrument = isset($restriction['Instrument']) && !empty($restriction['Instrument']) ? $restriction['Instrument'] : '';
											$RecordedDate = isset($restriction['RecordedDate']) && !empty($restriction['RecordedDate']) ? $restriction['RecordedDate'] : '';
											$Purpose = isset($restriction['Purpose']) && !empty($restriction['Purpose']) ? $restriction['Purpose'] : '';
											$Page = isset($restriction['Page']) && !empty($restriction['Page']) ? $restriction['Page'] : '';
											$Liber = isset($restriction['Liber']) && !empty($restriction['Liber']) ? $restriction['Liber'] : '';
											$Volume = isset($restriction['Volume']) && !empty($restriction['Volume']) ? $restriction['Volume'] : '';
											$Amount = isset($restriction['Amount']) && !empty($restriction['Amount']) ? $restriction['Amount'] : '';
											$Trustee = isset($restriction['Trustee']) && !empty($restriction['Trustee']) ? $restriction['Trustee'] : '';
											$Against = isset($restriction['Against']) && !empty($restriction['Against']) ? $restriction['Against'] : '';
											$Assignor = isset($restriction['Assignor']) && !empty($restriction['Assignor']) ? $restriction['Assignor'] : '';
											$Assignee = isset($restriction['Assignee']) && !empty($restriction['Assignee']) ? $restriction['Assignee'] : '';
											$AssigneeBook = isset($restriction['AssigneeBook']) && !empty($restriction['AssigneeBook']) ? $restriction['AssigneeBook'] : '';
											$AssigneePage = isset($restriction['AssigneePage']) && !empty($restriction['AssigneePage']) ? $restriction['AssigneePage'] : '';
											$AssigneeLiber = isset($restriction['AssigneeLiber']) && !empty($restriction['AssigneeLiber']) ? $restriction['AssigneeLiber'] : '';
											$AssigneeVolume = isset($restriction['AssigneeVolume']) && !empty($restriction['AssigneeVolume']) ? $restriction['AssigneeVolume'] : '';
											$AssigneeInstrument = isset($restriction['AssigneeInstrument']) && !empty($restriction['AssigneeInstrument']) ? $restriction['AssigneeInstrument'] : '';
											$CaseNumber = isset($restriction['CaseNumber']) && !empty($restriction['CaseNumber']) ? $restriction['CaseNumber'] : '';
											$County = isset($restriction['County']) && !empty($restriction['County']) ? $restriction['County'] : '';
											$CourtDistrict = isset($restriction['CourtDistrict']) && !empty($restriction['CourtDistrict']) ? $restriction['CourtDistrict'] : '';
											$CourtType = isset($restriction['CourtType']) && !empty($restriction['CourtType']) ? $restriction['CourtType'] : '';
											$Endorsements = isset($restriction['Endorsements']) && !empty($restriction['Endorsements']) ? $restriction['Endorsements'] : '';
											$Holder = isset($restriction['Holder']) && !empty($restriction['Holder']) ? $restriction['Holder'] : '';
											$InFavorOf = isset($restriction['InFavorOf']) && !empty($restriction['InFavorOf']) ? $restriction['InFavorOf'] : '';
											$InstallmentNumber = isset($restriction['InstallmentNumber']) && !empty($restriction['InstallmentNumber']) ? $restriction['InstallmentNumber'] : '';
											$InstallmentAmount = isset($restriction['InstallmentAmount']) && !empty($restriction['InstallmentAmount']) ? $restriction['InstallmentAmount'] : '';
											$MaturityDate = isset($restriction['MaturityDate']) && !empty($restriction['MaturityDate']) ? $restriction['MaturityDate'] : '';
											$State = isset($restriction['State']) && !empty($restriction['State']) ? $restriction['State'] : '';
											$StateDistrict = isset($restriction['StateDistrict']) && !empty($restriction['StateDistrict']) ? $restriction['StateDistrict'] : '';
											$TaxYears = isset($restriction['TaxYears']) && !empty($restriction['TaxYears']) ? $restriction['TaxYears'] : '';

											$arr_rep = array($Book, $Date, $DocumentName, $Grantee, $Grantor, $Instrument, $RecordedDate, $RecordedDate, $Purpose, $Page, $Liber, $Volume, $Amount, $Trustee, $Against, $Assignor, $Assignee, $AssigneeBook, $AssigneeBook, $AssigneePage, $AssigneePage, $AssigneeLiber, $AssigneeLiber, $AssigneeVolume, $AssigneeVolume, $AssigneeInstrument, $AssigneeInstrument, $Book, $CaseNumber, $County, $CourtDistrict, $CourtType, $Endorsements, $Holder, $InFavorOf, $InstallmentNumber, $Instrument, $InstallmentAmount, $Liber, $MaturityDate, $Page, $State, $StateDistrict, $TaxYears, $Volume, $parcelID);
											$language = str_replace($arr_find, $arr_rep, $language); 
											$result = array();
											preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $language, $result);

											if (!empty($result)) {
												$link = $result['href'][0];
												$documentId = str_replace('http://clients.pacificcoasttitle.com/DownloadDocument.aspx?DocumentID=', '', $link);
												$documentIds[$documentId] = $restrictionsCount;
											}	

											if(!empty($language)) {
												$restrictions[] = $language;
											}
											$restrictionsCount++;
										}
									}
									
									$summaryData = array(
										'file_number'=> $file_number,
										'vesting'=> $vesting,
										'generated_date'=> $generated_date,
										'tax'=> json_encode($tax),
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
								

								/* Send email to customer */

								$order_id = isset($order_details['id']) && !empty($order_details['id']) ? $order_details['id'] : '';
								$file_id = isset($order_details['file_id']) && !empty($order_details['file_id']) ? $order_details['file_id'] : '';

								$this->db->delete('pct_order_documents', array('order_id' => $order_id, 'is_prelim_document' => 1));
								$this->db->delete('pct_order_documents', array('order_id' => $order_id, 'is_linked_doc' => 1));

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
																			'is_linked_doc' => 1,
																			'index_number' => $documentIds[$documentId[1]]
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
																				'is_linked_doc' => 1,
																				'index_number' => $documentIds[$documentId[1]]
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
										$result['message'] = "Order not found.";
									}			
			}
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

