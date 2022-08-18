<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form - Buyer</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?=base_url('assets/buyer-seller-packets/fonts/material-icon/css/material-design-iconic-font.min.css');?>">
    <!-- <link rel="stylesheet" href="<?=base_url('assets/buyer-seller-packets/vendor/nouislider/nouislider.min.css');?>"> -->

    <!-- Main css -->
    <link rel="stylesheet" href="<?=base_url('assets/buyer-seller-packets/css/style.css?v=0.1');?>">
</head>

<body>

<style>
	span.desc_title {
    font-size: 18px;
    padding: 5px 10px;
    position: relative;
    z-index: 6;
    background: #f8f8f8;
}

p.buyer_desc {
    text-align: center;
}

span.desc_border {
    display: block;
    width: 100%;
    border-bottom: 1px solid #ababab;
    position: absolute;
    top: 15px;
    z-index: 5;
}
</style>

    <div class="main">
	
		<div >
		<div class="container2">
		
		<h1>Buyer Welcome Interview </h1>
		<h3><?php echo $orderDetails['full_address'];?></h3>
		<h4>APN:<?php echo $orderDetails['apn'];?> | File# <?php echo $orderDetails['file_number'];?> </h4>
		
		</div>
		</div>
       

	   <div class="container">
	   <?php if(!empty($success)) {?>
			<div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible">
				<?php foreach($success as $sucess) {
							echo $sucess."<br \>";	
						}?>

			</div>
			<?php  } 
			if(!empty($errors)) {?>
			<div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible">
				<?php foreach($errors as $error) {
						echo $error."<br \>";	
					}?>
			</div>
			<?php } ?>
		
            <form method="POST" id="signup-form" class="signup-form" >
                <div>
                    <h3>About You</h3>
					<input type="hidden" name="order_id" id="order_id" value="<?php echo $orderDetails['order_id'];?>">
                    <fieldset>
                        <h2>Personal information</h2>
                        <p class="desc">Please enter your infomation and proceed to next step so we can build your account</p>
						<div class="fieldset-content">
						<?php if(count($buyers)) :?>
						<?php foreach($buyers as $key_buyer=>$buyer) :?>
								<div class="form-group">
									<p class="buyer_desc">
										<span class="desc_title">Buyer <?=($key_buyer+1)?></span>
										<span class="desc_border"></span>
									</p>
								</div>
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
										<label class="form-label">First Name</label>
										<input type="text" name="first_name[<?=$buyer['id']?>]" required value="<?=$buyer['first_name']?>" />
										<span class="text-input">example: John </span>
										</div>
										<div class="form-group">
										<label class="form-label">Last Name</label>
										<input type="text" name="last_name[<?=$buyer['id']?>]" required value="<?=$buyer['last_name']?>"/>
										<span class="text-input">example: Smith </span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
											<label for="email" class="form-label">Email</label>
											<input type="email" name="email[<?=$buyer['id']?>]" required value="<?=$buyer['email']?>"/>
											<span class="text-input">example: johnsmith@gmail.com </span>
										</div>
										<div class="form-group">
											<label for="phone" class="form-label">Mobile Phone #</label>
											<input class="phone_mask" type="text" name="phone[<?=$buyer['id']?>]" required value="<?=$buyer['phone']?>"/>
											<span class="text-input">example: (000) 000-0000 </span>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-flex">
										<div class="form-group form-date dob_date_picker_div">
											<label for="birth_date" class="form-label">Birth Date</label>
											<div class="form-date-group">
												<div class="form-date-item">
													<select class="dob_birth_date" id="birth_date[<?=$buyer['id']?>]" name="birth_date[<?=$buyer['id']?>]" required></select>
													<span class="text-input">DD</span>
												</div>
												<div class="form-date-item">
													<select class="dob_birth_month"  id="birth_month[<?=$buyer['id']?>]" name="birth_month[<?=$buyer['id']?>]" required></select>
													<span class="text-input">MM</span>
												</div>
												<div class="form-date-item">
													<select class="dob_birth_year"  id="birth_year[<?=$buyer['id']?>]" name="birth_year[<?=$buyer['id']?>]" required></select>
													<span class="text-input">YYYY</span>
												</div>
											</div>
										</div>
									
										<div class="form-group">
											<label  class="form-label">Social Security No.</label>
											<input class="ssn" type="text" name="ssn[<?=$buyer['id']?>]" required />
											<span class="text-input">example: XXX-XX-XXXX </span>
										</div>
								
									</div>
								</div>
								<div class="form-group">
									<label  class="form-label">Current Mailing Address</label>
									<input type="text" name="current_mailing_address[<?=$buyer['id']?>]" required />
									<span class="text-input">456 Main St. Los Angeles, CA </span>
							
								</div>
								<div class="form-group">
										<label  class="form-label">Mailing Address Post Closing</label>
										<input type="text" name="mailing_address_port_closing[<?=$buyer['id']?>]" required />
										<span class="text-input">456 Main St. Los Angeles, CA </span>
								
								</div>
							
							
							
						<?php  endforeach; ?>
						<?php else : ?>
						
							<div class="form-row">
                                <div class="form-flex">
                                    <div class="form-group">
									 <label class="form-label">First Name</label>
                                     <input type="text" name="first_name" required  />
									  <span class="text-input">example: John </span>
                                    </div>
                                    <div class="form-group">
									 <label class="form-label">Last Name</label>
                                     <input type="text" name="last_name" required/>
									  <span class="text-input">example: Smith </span>
                                    </div>
                                </div>
                            </div>
							<div class="form-row">
								<div class="form-flex">
								<div class="form-group">
									<label for="email" class="form-label">Email</label>
									<input type="email" name="email" required />
									 <span class="text-input">example: johnsmith@gmail.com </span>
								</div>
								<div class="form-group">
									<label for="phone" class="form-label">Mobile Phone #</label>
									<input class="phone_mask" type="text" name="phone" required />
									<span class="text-input">example: (000) 000-0000 </span>
                            </div>
								</div>
							</div>

							<div class="form-row">
                                <div class="form-flex">
							<div class="form-group form-date">
                                <label for="birth_date" class="form-label">Birth Date</label>
                                <div class="form-date-group">
									<div class="form-date-item">
										<select id="birth_date" name="birth_date" required></select>
										<span class="text-input">DD</span>
									</div>
                                    <div class="form-date-item">
                                        <select id="birth_month" name="birth_month" required></select>
                                        <span class="text-input">MM</span>
                                    </div>
                                    <div class="form-date-item">
                                        <select id="birth_year" name="birth_year" required></select>
                                        <span class="text-input">YYYY</span>
                                    </div>
								</div>
                            </div>
								
							<div class="form-group">
								<label  class="form-label">Social Security No.</label>
								<input class="ssn" type="text" name="ssn" required />
								<span class="text-input">example: XXX-XX-XXXX </span>
							</div>
							
							    </div>
                            </div>
							<div class="form-group">
                                <label  class="form-label">Current Mailing Address</label>
                                <input type="text" name="current_mailing_address" required />
								 <span class="text-input">456 Main St. Los Angeles, CA </span>
                           
						   </div>
						   <div class="form-group">
                                <label  class="form-label">Mailing Address Post Closing</label>
                                <input type="text" name="mailing_address_port_closing" required />
								 <span class="text-input">456 Main St. Los Angeles, CA </span>
                           
						   </div>
						   
						<?php endif; ?>

						<div class="form-row">
								<div class="form-group">
										<label class="form-label">Would You like to add another buyer?</label>
										<select name="is_another_buyer" class="buyer__show_hide_action" data-action="another_buyer">
										<option value="">Select</option>
										<option value="1">Yes</option>
										<option value="0">No</option>
										</select>
										<span class="text-input">example: yes or no. </span>
								</div>
							</div>
							
						</div>
                       

						<div class="another_buyer buyer__show_hide_div" style="display: none;">
							<div class="fieldset-content">
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
										<label class="form-label">First Name</label>
										<input type="text" name="second_first_name" required/>
										<span class="text-input">example: John </span>
										</div>
										<div class="form-group">
										<label class="form-label">Last Name</label>
										<input type="text" name="second_last_name" required />
										<span class="text-input">example: Smith </span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-flex">
									<div class="form-group">
										<label for="email" class="form-label">Email</label>
										<input type="email" name="second_email" required/>
										<span class="text-input">example: johnsmith@gmail.com </span>
									</div>
									<div class="form-group">
										<label for="phone" class="form-label">Mobile Phone #</label>
										<input class="phone_mask" type="text" name="second_phone" required />
										<span class="text-input">example: (000) 000-0000 </span>
								</div>
									</div>
								</div>

								<div class="form-row">
									<div class="form-flex">
								<div class="form-group form-date">
									<label  class="form-label">Birth Date</label>
									<div class="form-date-group">
										<div class="form-date-item">
											<select id="birth_date1" name="second_birth_date" required></select>
											<span class="text-input">DD</span>
										</div>
										<div class="form-date-item">
											<select id="birth_month1" name="second_birth_month" required></select>
											<span class="text-input">MM</span>
										</div>
										<div class="form-date-item">
											<select id="birth_year1" name="second_birth_year" required></select>
											<span class="text-input">YYYY</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label  class="form-label">Social Security No.</label>
									<input class="ssn" type="text" name="second_ssn" required />
									<span class="text-input">example: XXX-XX-XXXX </span>
								</div>
								<!-- <div class="form-date">
									<label  class="form-label">Social Security No.</label>
									<div class="form-date-group">
										<div class="form-date-item">
											<input  class="ssn1"  name="ssn11" required></input>
											<span class="text-input">XXX</span>
										</div>
										<div class="form-date-item">
											<input  class="ssn2" name="ssn21" required></input>
											<span class="text-input">XX</span>
										</div>
										<div class="form-date-item">
											<input  class="ssn3" name="ssn31" required></input>
											<span class="text-input">XXXX</span>
										</div>
									</div>
								</div> -->
									</div>
								</div>
								<div class="form-group">
									<label  class="form-label">Current Mailing Address</label>
									<input type="text" name="second_current_mailing_address"  required/>
									<span class="text-input">456 Main St. Los Angeles, CA </span>
							
							</div>
							<div class="form-group">
									<label  class="form-label">Mailing Address Post Closing</label>
									<input type="text" name="second_mailing_address_port_closing" required />
									<span class="text-input">456 Main St. Los Angeles, CA </span>
							
							</div>
							
							</div>
						</div>
                    </fieldset>


                    <h3>Property & Loan</h3>
					
                    <fieldset>                   
                        
						 <h2>About Your Property</h2>
                            <p class="desc">Please enter your infomation and proceed to next step so we can build your account</p>
						  <div class="form-row">
							 <div class="form-group">
									 <label class="form-label">Is this the property that you are buying: <?php echo $orderDetails['full_address'];?> </label>
                                      <select  name="is_same_property">
									  <option value="">Select</option>
									  <option value="1">Yes</option>
									  <option value="0">No</option>
									 </select>
									  <span class="text-input">example: yes or no. </span>
							</div>
                            </div>
						 <div class="form-group">
                                <label  class="form-label">Enter the Loan Amount that you applied For:</label>
                                <input class="amount_mask" type="text" name="loan_amount" id="appliedloan" required />
								 <span class="text-input">example: $674,950  </span>
                           
						   </div>
						   <div class="form-group">
                                <label  class="form-label">What is the Name of Your Lender?</label>
                                <input type="text" name="lender_name" required />
								 <span class="text-input">Wells Fargo, Bank of America, etc. </span>
                           
						   </div>
						  <div class="form-group">
                                <label for="loanofficer" class="form-label">Enter You Loan Officers Name ( if applicable )</label>
                                <input type="text" name="loan_officer_name" id="loanofficer" />
								 <span class="text-input">John Smith </span>
                           
						   </div>
							
							<div class="form-row">
                                <div class="form-flex">
                                    <div class="form-group">
									 <label class="form-label">Enter Loan Officer Email ( if applicable )</label>
                                     <input type="email" name="loan_officer_email" id="loemail" />
									  <span class="text-input">example: Johnsmith@abcloancompany.com  </span>
                                    </div>
                                    <div class="form-group">
									 <label class="form-label">Enter Loan Officer Phone Number ( if applicable )</label>
                                     <input class="phone_mask" type="text" name="loan_officer_phone" id="lophone" />
									  <span class="text-input">example: (800) 000-0000  </span>
                                    </div>
                                </div>
                            </div>
							
                            
								  <div class="form-row">
									<div class="form-group">
											<label class="form-label">Are you working with a loan processor?</label>
											<select name="is_loan_processor" class="buyer__show_hide_action" data-action="loan_processor_div">
											<option value="">Select</option>
											<option value="1">Yes</option>
											<option value="0">No</option>
											</select>
											<span class="text-input">example: yes or no. </span>
									</div>
								</div>

								<div class="loan_processor_div" style="display: none;">
									<div class="form-group">
										<label for="lpanofficer" class="form-label">Enter You Loan Processor Name </label>
										<input type="text" name="loan_processor_name" id="lpanofficer"  required/>
										<span class="text-input">John Smith </span>
								
									</div>
									
									<div class="form-row">
										<div class="form-flex">
											<div class="form-group">
											<label class="form-label">Enter Loan Processor Email </label>
											<input type="email" name="loan_processor_email" id="lpemail" required/>
											<span class="text-input">example: Johnsmith@abcloancompany.com  </span>
											</div>
											<div class="form-group">
											<label class="form-label">Enter Loan Processor Phone Number</label>
											<input class="phone_mask" type="text" name="loan_processor_phone" id="lpphone" required/>
											<span class="text-input">example: (800) 000-0000  </span>
											</div>
										</div>
									</div>
							</div>
							
							
                        
                    </fieldset>

                    <h3>About Your Insurance</h3>
                    <fieldset>
                        <h2>Home Insurance</h2>
                        <p class="desc">Tell us a little bit about it. </p>
                        <div class="fieldset-content">
						
							
							<div class="form-row">
							 <div class="form-group">
									 <label class="form-label">Insurance</label>
                                      <select  name="is_home_ins"  class="buyer__show_hide_action" data-action="home_ins_div">
									  <option value="">Select</option>
									  <option value="1">Yes</option>
									  <option value="0">No</option>
									 </select>
									   <span class="text-input">example: yes or no.</span>
							</div>
                            </div>
							<div class="home_ins_div" style="display: none;">

								<div class="form-row">
										<div class="form-group">
										 <label class="form-label">Insuance Agency Name</label>
										 <input type="text" name="ins_agency_name"  />
										 <span class="text-input">example: Statefarm, Allstate,  etc. </span>
										</div>
								</div>
								
								<div class="form-row">
										<div class="form-group">
										 <label class="form-label">Insurance Agent Name</label>
										 <input type="text" name="ins_agent_name"  />
										 <span class="text-input">example: Statefarm, Allstate,  etc. </span>
										</div>
								</div>
	
								
								<div class="form-row">
									<div class="form-flex">
										<div class="form-group">
										 <label class="form-label">Insurance Agent's Email</label>
										 <input type="email" name="ins_agent_email"  />
										  <span class="text-input">example: johnsmith@abcinsurance.com </span>
										</div>
										<div class="form-group">
										 <label class="form-label">Insurance Agent's Phone Number</label>
										 <input class="phone_mask" type="text" name="ins_agent_phone"  />
										  <span class="text-input">example: (800) 000-0000 </span>
										</div>
									</div>
								</div>
								
								<div class="form-row">
										<div class="form-group">
										 <label class="form-label">What Annual Premium were you quoted?</label>
										 <input class="amount_mask" type="text" name="annual_premium"  />
										  <span class="text-input">example:$3600 annual premium </span>
										</div>
								</div>
							</div>
							
							

                        </div>
                    </fieldset>

					<h3>Vesting & Ownership</h3>
					<fieldset>
						<h2>Vesting & Ownership</h2>
						<p class="desc">Please review the relationship and martial status of each of the buyers </p>
						<div class="form-row">
							<div class="form-flex">
								<div class="form-group">
									<label for="email" class="form-label">Buyer 1</label>
									<input type="email" name="email" id="email" />
								</div>
								<div class="form-group">
									<label for="email" class="form-label">Marital Status</label>
									<select id="loan" name="loantype">
									<option value="Select">Select</option>
									<option value="">Husband and Wife </option>
										<option value=""> Wife and Husband </option>
										<option value=""> A Married Couple </option>
										<option value=""> A Single Man (never married) </option>
										<option value=""> A Single Woman (never married) </option>
										<option value=""> A Single Person (never married) </option>
										<option value=""> A Married Man (as his sole and separate property)* </option>
										<option value=""> A Married Woman (as her sole and separate property)*  A Married Person (as his/her sole and separate property)* </option>
										<option value="">An Unmarried Man (divorced)  An Unmarried Woman (divorced)  An Unmarried Person (divorced)  A Widow (spouse deceased) </option>
										<option value="">A Widower (spouse deceased)  Registered Domestic Partners</option>

									</select>
								</div>
								<div class="form-group">
									<label for="email" class="form-label">Married To:</label>
									<select id="loan" name="loantype">
									<option value="Select">Select</option>
									<option value="">Buyer 2</option>
									<option value="">Buyer 3</option>
									</select>
								</div>
							</div>
							<div class="form-flex">
								<div class="form-group">
									<label for="email" class="form-label">Buyer 2</label>
									<input type="email" name="email" id="email" />
								</div>
								<div class="form-group">
									<label for="email" class="form-label">Marital Status</label>
									<select id="loan" name="loantype">
									<option value="Select">Select</option>
									<option value="">Husband and Wife </option>
										<option value=""> Wife and Husband </option>
										<option value=""> A Married Couple </option>
										<option value=""> A Single Man (never married) </option>
										<option value=""> A Single Woman (never married) </option>
										<option value=""> A Single Person (never married) </option>
										<option value=""> A Married Man (as his sole and separate property)* </option>
										<option value=""> A Married Woman (as her sole and separate property)*  A Married Person (as his/her sole and separate property)* </option>
										<option value="">An Unmarried Man (divorced)  An Unmarried Woman (divorced)  An Unmarried Person (divorced)  A Widow (spouse deceased) </option>
										<option value="">A Widower (spouse deceased)  Registered Domestic Partners</option>

									</select>
								</div>
								<div class="form-group">
									<label for="email" class="form-label">Married To:</label>
									<select id="loan" name="loantype">
									<option value="Select">Select</option>
									<option value="">Buyer 2</option>
									<option value="">Buyer 3</option>
									</select>
								</div>
							</div>
							<div class="form-flex">
								<div class="form-group">
									<label for="email" class="form-label">Buyer 3</label>
									<input type="email" name="email" id="email" />
								</div>
								
								<div class="form-group">
									<label for="email" class="form-label">Marital Status:</label>
									<select id="loan" name="loantype">
									<option value="Select">Select</option>
										<option value="">Husband and Wife </option>
										<option value=""> Wife and Husband </option>
										<option value=""> A Married Couple </option>
										<option value=""> A Single Man (never married) </option>
										<option value=""> A Single Woman (never married) </option>
										<option value=""> A Single Person (never married) </option>
										<option value=""> A Married Man (as his sole and separate property)* </option>
										<option value=""> A Married Woman (as her sole and separate property)*  A Married Person (as his/her sole and separate property)* </option>
										<option value="">An Unmarried Man (divorced)  An Unmarried Woman (divorced)  An Unmarried Person (divorced)  A Widow (spouse deceased) </option>
										<option value="">A Widower (spouse deceased)  Registered Domestic Partners</option>

									</select>
								</div>
								<div class="form-group">
									<label for="email" class="form-label">Married To:</label>
									<select id="loan" name="loantype">
									<option value="Select">Select</option>
									<option value="">Buyer 2</option>
									<option value="">Buyer 3</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group">
									<label class="form-label">Please tell us how the property will be vested:</label>
									<select id="loan" name="loantype">
									<option value="Select">Select</option>
									<option value=""> Community Property</option>
									<option value=""> Community Property with Right of Survivorship</option>
									<option value=""> Joint Tenants </option>
									<option value=""> Tenants In Common (Please Give Interest Amounts) </option>
									<option value=""> Sole and Separate Property (If Married or Domestic Partnership, an Interspousal Grant Deed, A  Quitclaim Deed, Statement Of Information and Appropriate Instructions Will Need To Be Submitted.) </option>
									<option value=""> Partnership (Limited Or General) </option>
									<option value=""> Corporation (California Or Other State) </option>
									<option value=""> A Trust (attach copy of Trust Agreement) </option>
									<option value=""> Other</option>  
									</select>
									<span class="text-input">example: yes or no. </span>
							</div>
						</div>
					</fieldset>

					<h3>Confirmation</h3>
					<fieldset>
						<h2>Confirmation</h2>
						<p>&nbsp;</p>
						<p class="desc">Signing below indicates that the information included here is correct and complete to the best of my knowledge and ackowledges and accepts the information included in this document.</p>
						<p class="desc">You must click below Finish button to securely send your completed forms to Pacific Coast Title Company.</p>
						
						
					</fieldset>
                </div>
            </form>
        </div>

    </div>

    <!-- JS -->
    <script src="<?=base_url('assets/buyer-seller-packets/vendor/jquery/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/buyer-seller-packets/vendor/jquery-validation/dist/jquery.validate.min.js');?>"></script>
    <script src="<?=base_url('assets/buyer-seller-packets/vendor/jquery-validation/dist/additional-methods.min.js');?>"></script>
    <script src="<?=base_url('assets/buyer-seller-packets/vendor/jquery-steps/jquery.steps.min.js');?>"></script>
    <script src="<?=base_url('assets/buyer-seller-packets/vendor/minimalist-picker/dobpicker.js');?>"></script>
    <script src="<?=base_url('assets/buyer-seller-packets/vendor/nouislider/nouislider.min.js');?>"></script>
    <script src="<?=base_url('assets/buyer-seller-packets/vendor/wnumb/wNumb.js');?>"></script>
	<script src="<?=base_url('assets/buyer-seller-packets/vendor/input-mask/jquery.mask.min.js');?>"></script>
    <script src="<?=base_url('assets/buyer-seller-packets/js/buyer-main.js?v=0.1');?>"></script>

	<script>
		$(document).ready(function(){
			$('.buyer__show_hide_action').change(function(){
				var show_hide_div = $(this).data('action');
				if(show_hide_div) {
					if($(this).val()=='1') {
						$('.'+show_hide_div).show();
					}
					else {
						$('.'+show_hide_div).hide();
					}
				}
				
			});

			$(".phone_mask").mask('(000) 000-0000');
			$(".amount_mask").mask("#,##0", {reverse: true});
			$(".ssn").mask('000-00-0000');


		});
	</script>
</body>

</html>
