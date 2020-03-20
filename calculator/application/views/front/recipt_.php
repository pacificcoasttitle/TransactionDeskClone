
    <!-- pagetitle start here -->
    <section id="pagetitle-container">
        <div class="row">
            <div class="twelve column">
                <h1>Title & Escrow Rate Calculator</h1>
                <h3>Helping to Calculate Your Fees</h3>
            </div>
            <div class="twelve column breadcrumb">
                <ul>
                    <li><a href="">Home</a></li>
                    <li class="current-page"><a href="javascript:;">Rate Calculator</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- page title end here -->
    <!-- content section start here -->
    <section class="content-wrapper">
        <div class="row">
            <div class="twelve column">
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
        </div>
   
   <div class="row">
   	<div class="recipt-body">
   		<header>
   			<div class="logo"><img src="<?=base_url()?>assets/front/images/logo.png"></div>
   			<div class="text-logo"><img src="<?=base_url()?>assets/front/images/logo-text.png"></div>
   		</header>
   		<div class="title">CFPB Loan Estimate</div>
   		<div class="article">
   			
   			<table class="table">
   				
   				<tbody>
   				<tr>
   					<td colspan="2"><h3>Transition Details</h3></td>
   				</tr>
   					<tr>
   						<td><b>Quote ID</b> </td><td><?=$quote_detail->quote_id_pk?></td>
   					</tr>
   					<tr>
   						<td><b>Quote Date</b>  </td><td><?=date("m/d/Y h:i A",strtotime($quote_detail->quote_date))?></td>
   					</tr>
   					<tr>
   						<td><b>Property Location</b></td><td><?=$quote_detail->region?>/<?=$quote_detail->zone_name?>/<?=$quote_detail->county_name?></td>
   					</tr>
            <?php if ($quote_detail->is_same_county == 1): ?>
              <tr>
              <td><b>Closing Location</b> </td><td>CA/Los Angeles/Bell</td>
            </tr>
            <?php else: ?>
              <tr>
              <td><b>Closing Location</b> </td><td><?=$closing_detail->region?>/<?=$closing_detail->zone_name?>/<?=$closing_detail->county_name?></td>
            </tr>
            <?php endif ?>
   					
   					<tr>
   						<td><b>Transaction Type</b> </td><td><?=$quote_detail->txn_type?></td>
   					</tr>
   					<tr>
   						<td><b>Loan Amount </b></td><td>$ <?=number_format($quote_detail->loan_amount)?></td>
   					</tr>
   				</tbody>
   			</table>
   			<div class="clearfix">
   			<p></p>
   			</div>
   			<table class="table-null" cellspacing="5" cellpadding="5">
   					
   				<tbody>
   					<tr>
   						<td>
   						<table class="table-data">
   				
   				<tbody>
   					<thead >
   						<th width="70%" class="bg-blue"  >Loan cost</th><th class="bg-blue" width="30%" align="right"></th>
   					</thead>
            <?php 
                $row =   $this->welcome_model->get_title_rate($quote_detail->quote_id_pk);
                //print_r($row); print_r($quote_detail);
                $residential_owner_rate = $row->owner_rate;
                $home_owner_rate = $row->home_owner_rate;
                $alta_lenders_rate = $row->con_loan_rate;
                $residential_loan = $row->resi_loan_rate;
              $purchase_rate =0;
              $lender =0;
              $title_tot =0;
              if($quote_detail->txn_type == 'Resale')
              {

                  if($quote_detail->policy_type == 'Regular')
                  {
                      $purchase_rate = $residential_owner_rate;
                  }
                  else if($quote_detail->policy_type == 'Extended')
                  {
                    $purchase_rate = $home_owner_rate;
                  }
                
                  if($quote_detail->is_lender_policy == '1')
                  {
                      $purchase_rate += $alta_lenders_rate;
                  }

              }
              else if($quote_detail->txn_type == 'Re-Finance')
              {
                  $purchase_rate = $residential_loan;
              }

              $title_tot += $purchase_rate;
             
             ?>

            <?php  if($quote_detail->is_endorsement == '1'): 


            $end_fee =  $this->welcome_model->get_endorsement_fee($quote_detail->quote_id_pk);
            $end_tot = 0.00;
            ?>

             <?php foreach ($end_fee as $endf): ?>
              <?php $end_tot += number_format($endf->endorse_fee,2);?>
            <?php endforeach ?>
              
             <?php $title_tot += $end_tot; 


             endif ?>

             <?php  $pay_up =0;  

                if($quote_detail->txn_type == 'Resale')
                {//print_r($quote_detail);
                   $rate = $this->welcome_model->calculate_escrow_fee_resale($quote_detail->quote_id_pk);
                  //print_r($rate);
                   $pay = $rate->base_rate + $quote_detail->sale_amount*$rate->rate_per_1k;

                if($rate->multi_factor == 1)
                {
                  if($pay < $rate->min_rate)
                  {
                      $pay_up = $rate->min_rate;
                  }
                  else
                  {
                    $pay_up = $pay;
                  }
                }
                else
                {
                   $pay =  str_replace('loan_amount', $quote_detail->sale_amount, $rate->formula);
                    $Cal = new Field_calculate();
                   $pay_up = $Cal->calculate($pay); 

                }

                }
                else if($quote_detail->txn_type == 'Re-Finance')
                 {
                    $rate = $this->welcome_model->calculate_escrow_fee_refinance($quote_detail->quote_id_pk);
                    $pay_up = $rate->escrow_rate;

                 }

                 $escro_tot=0;
                   if($quote_detail->is_escrow_rate == '1')
                   {

                     if ($quote_detail->is_resi_escrow_service == '1'): 
                        $escro_tot += $pay_up;
                      endif;

                     if ($quote_detail->is_notary_fee == '1'): 
                       $escro_tot += 175.00;
                      endif ;

                    if ($quote_detail->is_recording_service_fee == '1'): 
                       $escro_tot += 13.00;
                      endif ;

                    if ($quote_detail->is_mobile_signin == '1'): 

                     $mobile_signin_fee = 100.00*$quote_detail->no_of_mobile_signin;
              
                      $escro_tot += number_format($mobile_signin_fee,2);
                    endif;
                    if ($quote_detail->is_new_loan == '1'): 
                      $escro_tot += 280.00;
                    endif;


                    $title_tot += $escro_tot;
                   }
               ?>
      <tbody>
            <tr>
              <td><b> A organization Charge</b></td><td class="aright"><b>$0.00</b></td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr class="bg-gray">
              <td class="bg-gray"><b> Title Service</b></td><td class="aright"><b>$ <?=number_format($title_tot,2)?></b></td>
            </tr>
              <tr><td>Title - rate</td><td class="aright">$ <?=number_format($purchase_rate,2)?></td></tr>
            <?php if($quote_detail->is_lender_policy == '1'): ?>
               <tr><td>Alta Lenders Concurrent  Loan Rate</td><td class="aright">$ <?=number_format($alta_lenders_rate,2)?></td></tr>
            <?php endif ?>
            <?php  if($quote_detail->is_endorsement == '1'):  ?>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr class="bg-gray">
              <td ><b> Title Endorsement Charge</b></td><td class="aright"><b>$ <?=number_format($end_tot,2)?></b></td>
            </tr>
            <?php foreach ($end_fee as $endf): ?>
                <tr><td><?=$endf->endorse_name?></td><td class="aright">$ <?=number_format($endf->endorse_fee,2)?></td></tr>
            <?php endforeach ?>
   				
   				 <?php endif ?>

   					<tr><td colspan="2">&nbsp;</td></tr>
              <?php
              if($quote_detail->is_escrow_rate == '1'): 
               ?>
   					<tr class="bg-gray">
   						<td ><b> Title - Escrow Fees</b></td><td class="aright"><b>$ <?=number_format($escro_tot,2)?></b></td>
   					</tr>
            
            <?php if ($quote_detail->is_resi_escrow_service == '1'): ?>
                <tr><td>Residential Escrow Loan Service</td><td class="aright">$ <?=number_format($pay_up,2)?></td></tr>
            <?php endif ?>
   				  <?php if ($quote_detail->is_notary_fee == '1'): ?>
   					<tr><td>Notary Fees</td><td class="aright">$ 175.00</td></tr>
              <?php endif ?>

               <?php if ($quote_detail->is_mobile_signin == '1'): 

                $mobile_signin_fee = 100.00*$quote_detail->no_of_mobile_signin;
               ?>
            <tr><td>Mobile Sign in Fees</td><td class="aright">$ <?=number_format($mobile_signin_fee,2)?></td></tr>
              <?php endif ?>
            <?php if ($quote_detail->is_new_loan == '1'): ?>
            <tr><td>New Loan Fees</td><td class="aright">$ 280.00</td></tr>
              <?php endif ?>

              <?php if ($quote_detail->is_recording_service_fee == '1'): ?>
            <tr><td>New Loan Fees</td><td class="aright">$ 13.00</td></tr>
              <?php endif ?>

               <?php endif ?>
   				</tbody>
   			</table>

   			</td>
				<td>
							<table class="table-data">
   				
   				<tbody>
   					<thead >
   						<th width="70%" class="bg-blue"  >Other cost</th><th class="bg-blue" width="30%" align="right"></th>
   					</thead>
   					<tbody>
   					<tr>
   						<td><b>Taxes & Other Government Fees</b></td><td class="aright"><b>$150</b></td>
   					</tr>

           <?php if ($quote_detail->is_recording == '1'): ?>
   					<tr>
   						<td>Recording Charge</td><td class="aright">$ 92</td>
   					</tr>
             <?php endif ?>
   					<tr><td colspan="2">&nbsp;</td></tr>
   					<tr class="bg-gray">
   						<td class="bg-gray"><b> Prepaids</b></td><td class="aright"></td>
   					</tr>
   					<tr><td colspan="2">&nbsp;</td></tr>
   					<tr class="bg-gray">
   						<td class="bg-gray"><b> Initial Escrow Payment at Closing</b></td><td class="aright"></td>
   					</tr>
   					<tr><td colspan="2">&nbsp;</td></tr>
   					<tr class="bg-gray">
   						<td class="bg-gray"><b>Other</b></td><td class="aright"></td>
   					</tr>
   				
   					
   				</tbody>
   			</table></td>
   					</tr>
   				</tbody>
   			</table>
   				<div class="clearfix">
   			<p class=" p-text"><b>Products and Services Notes</b><br>
<small>Note 1- “Residential Loan Rate” requires: (1) The property involved is one to four fam ily residential; and (2) the new policy coverage is ALTA in form (including ALTA Loan P olicy or ALTA Short Form Residential Loan Policy) with stream lined searching allowing for generic exceptions for CC&R’s, Easem ents, Minerals, Mineral Rights or Survey Matters. Included Endorsem ents: Coverages provided under the following endorsem ents will be included, as applicable, at no additional charge upon request of the lender at the tim e of policy issuance: 100, 100.2, 103.1A, 103.1A Modified, 111.5, 111.6, 111.7, 111.8, 115.1, 115.2, 116 and 116.2. All other percentage based endorsem ents shall be priced based on the Residential Owner’s Rate.</small>
   			</p>
   			<p>&nbsp;</p>
   					<div class="clearfix">
   		
<small>The inform ation used or statem ent of fees (the “Q uote”) produced from or through this site is provided “as is” “as available” and all warranties, express or im plied, are expressly disclaim ed (including but not lim ited to the disclaim er of any im plied warranties of m erchantability and fitness for a particular purpose). The Q uote m ay contain errors, inaccuracies or other lim itations.</small>
<br><br>
<small>Notwithstanding the foregoing lim itation of liability, the Com pany agrees to indem nify against actual m onetary loss incurred resulting from the inaccuracy of the fees or charges quoted for services actually perform ed and products provided by the Com pany as incorporated into the Q uote for which com pensation has been received. The Company is not responsible for the accuracy of any fees for any products or services provided by third parties, including agents of the Company.</small><br><br>
<small>The Com pany’s entire m axim um liability under the indem nity above shall be lim ited to the am ount by which the aggregate of the Com pany’s actual fees and charges received for the products and services provided in this Q uote exceed one hundred ten percent (110%) of the aggregate am ounts quoted in this quote for such products and services. In no event shall the Company be liable for indirect, special, incidental or consequential dam ages incurred by any party.</small>
   			</p>
          <p class=" p-text"><b>CFPB Disclosure</b><br>
            <small>Note: Amounts shown for Items noted with an asterisk (*) below are disclosed as required by CFPB Rule. Actual charges for such services are shown in the box above</small>
          </p>
   			</div>
   			</div>
   			
   		
   		</div>
   		<footer align="center">
   			<a href="#">www.pct.com</a>

   		</footer>
   		<div class="clearfix">
   
   		<br>
   		<a class="button small orange" href="javascript:window.print()" target="_blank">Print Friendly Version</a> 	<a class="button small gray"  href="javascript:;" onclick="send_email()">Email Quote</a> 	<a class="button small blue" href="<?=base_url()?>" target="_blank">Start New Quote</a>
   		</div>
<div class="clearfix">
<form  method="POST" class="form-inline" role="form" id="send_email_form" style="display:none;" onsubmit="return false;">

  <div class="form-group">
    <label class="sr-only" for="">Email</label>
    <input type="email" class="form-control" id="email" placeholder="Input field">
    <div id="output" style="display:none;">
                    <div id="output_div" >
                      <span class = "text-danger" id="output_body"></span>
                    </div>
                  </div>
  </div>

  <button class="button small" onclick="send_email_id()">Send</button>
</form>
</div>
   	</div>
   </div>
    </section>
    <!-- content section end here -->
    <!-- bottom content start here -->
    <section id="bottom-content">
        <div class="row">
            <div class="five column  first">
               <img src="<?=base_url()?>assets/front/images/sample_images/img-sample6.png">
            </div>
             <div class="seven column  ">
                <h2 class="bold-title"><b>Property information at your Fingertips</b></h2>
                <p class="lead">Got a PCT247.com Account? The you are already setup to being using our instant profile app. it's easy</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. </p>
                   <a class="button orange create-repo-btn small"><img src="<?=base_url()?>assets/front/images/file-icon.png"> Learn More</a>
            </div> 
          
        </div>
    </section>
    <!-- bottom content end here -->
   

   <script type="text/javascript">
   function send_email () 
   {
       $("#send_email_form").slideDown();
   }


   function send_email_id () 
   {
     
var email_id = $("#email").val();
//alert(email_id);
if(email_id == "")
{
$("#output_body").attr("class","text-danger");
$("#output_body").html("please fill email first.!!");
$("#output").show();
$("#email").focus();
}
else
{
$("#output_body").html("");
$("#output").hide();
$("#output_div").attr("class","text-danger");
$("#output_body").attr("class","text-danger");
var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if(!regex.test(email_id))
{
$("#output_body").html("INCORRECT EMAIL ID! ");
$("#output").show();
$("#email").focus();
return false;
}

var quote_data = $(".article").html();
$.ajax({
url     : "<?=base_url()?>index.php/welcome/email_quote?email="+email_id,
type    : "post",
data    : {quote : quote_data},
success : function( data )
{

$("#output_body").html("");
$("#output_body").html("Quote mailed on given email id.");
$("#output").show();
return false;

},
});
}


   }



   </script>