<div class="container">
  <div class="content-wrapper">
    <section id="content">
      <?php include 'ext-menu.php';?>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="active">Publish & sell</li>
      </ol>
      <div class="clearfix"></div>
      <div class="panel panel-default flat">
        <div class="panel-body">
          <h3 class=" panel-title text-uppercase text-primary">Publish & Sell </h3>
          <hr>
         
          <h4>ONLINE PRINT-ON-DEMAND, SELF-PUBLISHING AND DISTRIBUTION</h4>
         <p class="">  Get personal support on developing formatting, layout, cover and interior design on your Hardcover, Paperback or eBook</p>
         
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
               <form class="login-form pub-form" action="<?=base_url()?>index.php/welcome/publish_sell_submit_request/" method="post" enctype="multipart/form-data">
                <div class=" panel-primary">
                  <div class="panel-heading">
                    <img class="pull-left" height="20"  src="<?=base_url()?>assets/front/images/PUBLISH YOUR PRINT BOOK.png"><h4 class="panel-title">&nbsp; Publish your Print Book  </h4>
                  </div>
                 <div class="form-group">
                    
                    <input type="text" name="product_name" id="input" class="form-control" readonly value="<?=$user_info->fname?>" required="required"  title=""  placeholder="First Name">
                  </div>
                  <div class="form-group">
                    <input type="text" name="price" id="input" class="form-control" readonly value="<?=$user_info->lname?>" required="required"  title=""  placeholder="Last Name">
                    
                  </div>
                  <div class="form-group">
                    <input type="text" name="price" id="input" class="form-control" readonly value="<?=$user_info->email?>" required="required"  title=""  placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input type="text" name="currency" id="input" class="form-control" readonly value="<?=$user_info->phone?>" required="required"  title=""  placeholder="Phone Number">
                  </div>
                  <input type="hidden" name="book_type" id="inputBook_type" class="form-control" value="print_book">
                  <a class="btn-link  pull-right" href="<?=base_url()?>edit-profile" role="button">Edit this Information</a><br>
                  <div class="form-group">
                    <label>Is your manuscript ready?</label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="manuscript_ready" id="input" value="Yes" >
                        Yes
                      </label>
                      <div class="clearfix">
                        
                      </div>
                      <label>
                        <input type="radio" name="manuscript_ready" id="input" value="No" checked="checked">
                        No. I need support with my manuscript
                      </label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm ">Submit</button>
                  
                </div>
              </form>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <form class="login-form pub-form" action="<?=base_url()?>index.php/welcome/publish_sell_submit_request/" method="post" enctype="multipart/form-data">
                <div class=" panel-primary">
                  <div class="panel-heading">
                    <img class="pull-left" height="20"  src="<?=base_url()?>assets/front/images/PUBLISH YOUR EBOOK.png"><h4 class="panel-title">&nbsp; Publish your eBook  </h4>
                  </div>
                 <div class="form-group">
                    
                    <input type="text" name="product_name" id="input" class="form-control" readonly value="<?=$user_info->fname?>" required="required"  title=""  placeholder="First Name">
                  </div>
                  <div class="form-group">
                    <input type="text" name="price" id="input" class="form-control" readonly value="<?=$user_info->lname?>" required="required"  title=""  placeholder="Last Name">
                    
                  </div>
                  <div class="form-group">
                    <input type="text" name="price" id="input" class="form-control" readonly value="<?=$user_info->email?>" required="required"  title=""  placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input type="text" name="currency" id="input" class="form-control" readonly value="<?=$user_info->phone?>" required="required"  title=""  placeholder="Phone Number">
                  </div>
                  <input type="hidden" name="book_type" id="inputBook_type" class="form-control" value="ebook">
                  <a class="btn-link  pull-right" href="<?=base_url()?>edit-profile" role="button">Edit this Information</a><br>
                  <div class="form-group">
                    <label>Is your manuscript ready?</label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="manuscript_ready" id="input" value="Yes" >
                        Yes
                      </label>
                      <div class="clearfix">
                        
                      </div>
                      <label>
                        <input type="radio" name="manuscript_ready" id="input" value="No" checked="checked">
                        No. I need support with my manuscript
                      </label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm ">Submit</button>
                  
                </div>
              </form>
            </div>
          </div>
          <div class="clearfix">
          <p>&nbsp;</p>
          </div>

          <?php if ($this->session->userdata('mpuserid')): ?>
             <h3 class=" panel-title text-uppercase text-primary"><b>UPLOAD AND SELL</b></h3>
          
          <div class="clearfix">
            
          </div>
            <div class="row" >
            <form class="login-form pub-form" action="<?=base_url()?>index.php/welcome/publish_sell_submit/" method="post" enctype="multipart/form-data">
              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <div class=" panel-primary">
                  <div class="panel-heading">
                    <h4 class="panel-title">STEP 1: VERIFY YOUR PERSONAL DETAILS</h4>
                  </div>
                   <div class="form-group">

                    <label><b>First Name  </label></b>
                    <input type="text" id="input" class="form-control" readonly value="<?=$user_info->fname?>" required="required"  title=""  placeholder=" ">

                    <label><b>Last Name  </label></b>
                    <input type="text" id="input" class="form-control" readonly value="<?=$user_info->lname?>" required="required"  title=""  placeholder="  ">

                    <label><b>Email ID </label></b>
                    <input type="text" id="input" class="form-control" readonly value="<?=$user_info->email?>" required="required"  title=""  placeholder="">

                    <label><b>Phone No. </label></b>
                    <input type="text" id="input" class="form-control" readonly value="<?=$user_info->phone?>" required="required"  title=""  placeholder=" ">

                   </div>
                  
                  <a class="btn btn-link btn-sm pull-right" href="<?=base_url()?>edit-profile" role="button">Edit these Information</a>
                  
                </div>
              </div>
              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <div class=" panel-primary">
                  <div class="panel-heading">
                    <h4 class="panel-title">STEP 2: DESCRIBE YOUR ITEM </h4>
                  </div>
                  
                  
                  <div class="form-group">
                    <label>Your Product Information Here</label>
                    <input type="text" name="product_name" id="input" class="form-control" value="" required="required"  title=""  placeholder=" Title of Item ">
                  </div>
                  <div class="form-group">
                    <textarea name="desc" id="input" class="form-control" rows="3" placeholder="Short description of your Item" required="required"></textarea>
                    
                  </div>
                  <div class="form-group">
                    <input type="text" name="price" id="input" class="form-control" value="" required="required"  title=""  placeholder="Set Cost of Item  ">
                  </div>
                  
                  <div class="form-group">
                    <label>How would you like to be paid?</label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="paid_method" id="paid_method"  value="paypal" onclick="show_paid(this.checked,'paypal')">
                        Paypal
                      </label>
                      <div class="clearfix">
                        
                      </div>
                      <label>
                        <input type="radio" name="paid_method" id="paid_method" value="NEFT" onclick="show_paid(this.checked,'neft')" >
                        National Electronic Funds Transfer (NEFT)
                      </label>
                    </div>
                  </div>
                 <div class="row"  id="payment_paypal" style="display:none;">
                    <div class="form-group">
                    <label><b>Paypal ID  </b></label>
                    <input type="text" name="paypal_id" id="input" class="form-control" value="" required="required"  title=""  placeholder="Paypal ID">
                  </div>
                 </div>
                 <div class="row" id="payment_neft" style="display:none;">
                 <legend>Bank Details</legend>
                  <div class="form-group">
                            <label for="inputEmail3" class="control-label"><b>Name of Beneficiary</b></label>
                            <input type="text" class="form-control" id="inputPassword3" placeholder="Name of Beneficiary" readonly  data-placement="right" title="Name of Beneficiary" value="<?=$user_info->benificiary_name?>">
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label"><b>Account No.</b></label>
                            <input type="text" class="form-control" id="inputPassword3" pattern="^[ a-zA-Z0-9]+$" readonly placeholder="Account No."  data-placement="right" title="Account No." value="<?=$user_info->account_no?>">
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label"><b>Name &amp; Address of Bank</b></label>
                            <textarea  id="input" class="form-control" rows="3" required  readonly data-placement="right" title="Name &amp; Address of Bank" ><?=$user_info->bank_name_address?></textarea>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label"><b>IFSC Code</b></label>
                            <input type="text" class="form-control" id="inputPassword3" placeholder="IFSC Code" readonly  data-placement="right" title="IFSC Code" value="<?=$user_info->ifsc?>" >
                          </div>
                 </div>

                </div>
              </div>
              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <div class=" panel-primary">
                  <div class="panel-heading">
                    <h4 class="panel-title">STEP 3: UPLOAD YOUR ITEM  </h4>
                  </div>
                  
                  
                  <div class="form-group">
                    <input type="file" name="name" id="input"  value="" required="required" title=""  >
                  </div>
                 
                  
                </div>
              </div>
              
            </div>
            <div class="clearfix">
              
            </div>
            <hr>
            
            <div class="checkbox">
              <label>
                <input type="checkbox" value="" required>
                I have full rights to distribute and sell the files I have upload on Myreposit.
              </label>
              
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="" required>
                I agree the Terms of Service and Conditions of Myreposit.
              </label>
            </div>
            <div class="clearfix">
              
            </div>
            <center><button type="submit" class="btn btn-primary submit-flat btn-lg text-uppercase ">Sell Now!</button></center>
            
          </form>
          
          
        </div>
          <?php else: ?>
          <button type="button" class="btn btn-warning text-uppercase"><b>Already have your book ready?</b></button>
             
          <h3> <a href="<?=base_url()?>login"> Sign in</a> to Upload and Sell Now!</h3>
            <p>Do not have an Account? <a href="<?=base_url()?>signup">Create one</a></p>

          <div class="clearfix">&nbsp;</div>
          <?php endif ?>
         
         
          
      </div>
    </section>

    <Script>

function show_paid () 
{
  var sel = $("input[name=paid_method]:checked").val();
  if (sel =="paypal") 
    {
       $("#payment_paypal").slideDown();
       $("#payment_neft").hide();
    }
if (sel =="NEFT") 
    {
       $("#payment_paypal").hide();
       $("#payment_neft").slideDown();
    }




}

    </script>