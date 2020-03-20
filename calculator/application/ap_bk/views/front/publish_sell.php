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
          <h3 class=" panel-title text-uppercase text-primary">MyReposit Self-publishing Services</h3>
          <hr>
         
          <h4><b>Create. Publish. Sell</b></h4>
         <p class="">It is quick and easy to independently publish your print or eBook. With MyReposit self-publishing services, you can now reach millions of readers worldwide and keep retain control over your work. MyReposit handles all your printing, shipping, and customer service requirements.</p>
<ul>
<li>Get your own dedicated sales pages to promote and sell your book. </li>
<li>Make your book available to the public or access by invitation-only</li>
<li>Write a persuasive book description</li>
<li>Customize preview of your book in print and eBook formats </li>
<li>Manage cover design, edit and track distribution from your dashboard</li>
<li>Share your book on social media</li>
<li>MyReposit manages content, and revisions </li>
<li>Get month-to-month sales and revenue report </li>
</ul>
    <small>&nbsp;</small>
         
          <div class="row">
            
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class=" panel-primary">
                  <div class="panel-heading">
                    <img class="pull-left" height="20" src="https://myreposit.com/assets/front/images/PUBLISH YOUR EBOOK.png"><h4 class="panel-title">&nbsp;Publish to eBook</h4>
                  </div>
                  <ul>
                  <small>&nbsp;</small>
                  <li>Publish quickly & distribute globally</li>
<li>Get one-on-one support on cover, interior design, and layout</li>
<li>Publish in a variety of readable formats</li>
<li>Earn 70% of royalties </li>

                  </ul>
            </div>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class=" panel-primary">
                  <div class="panel-heading">
                    <img class="pull-left" height="20" src="https://myreposit.com/assets/front/images/PUBLISH YOUR PRINT BOOK.png"><h4 class="panel-title">&nbsp;Publish to Print</h4>
                  </div>
                  <ul>
                  <small>&nbsp;</small>
                  <li>Affordable Publishing and Global Distribution</li>
<li>Access full color, black & white, specialty publishing & complete editorial services<li></li>
<li>Fast turnaround time, affordable, option to distribute widely</li>
<li>List your price. Earn up to 80% royalties </li>

                  </ul>
            </div>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class=" panel-primary">
                  <div class="panel-heading">
                    <img class="pull-left" height="20" src="https://myreposit.com/assets/front/images/PUBLISH YOUR PRINT BOOK.png"><h4 class="panel-title">&nbsp;Publish to Audio Book</h4>
                  </div>
                  <ul>
                  <small>&nbsp;</small>
                  <li>Convert your book into audio book</li>
<li>Provides maximum exposure for you and your printed book</li>
<li>Book published in most popular format: CD and downloadable MP3</li>
<li>Book read aloud by a golden-voiced narrator</li>

                  </ul>
            </div> 
            </div>
          
          </div>

          <div class="clearfix hr">
          <p>&nbsp;</p>
          </div>

        

          <div class="clearfix ">
          <small>&nbsp;</small>
          </div>

          
          
         <?php if ($this->session->userdata('mpuserid')): ?>
            

            <div class="row" >
            <form id="submit_form" action="" method="post" enctype="multipart/form-data" onsubmit="return manu_submit()">
              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <div class=" panel-primary">
                   <h3 class=" panel-title text-primary mar-bottom-5"><b>Choose a popular format from the options below</b></h3>
                    <div class="form-group">
                   <select required="required" class="form-control" id="input" name="book_type">
                      <option class="s" value="">Select</option>
                      <option>Publish eBook </option>
                      <option>Publish Professional Hardcover </option>
                      <option>Publish Standard Paperback </option>
                      <option>Publish Premium Paperback </option>
                      <option>Audio book </option>

                    </select>
                    </div>
                     <h3 class=" panel-title text-primary mar-bottom-5"><b> Verify Your Personal Details</b></h3>
                   
                   <div class="form-group">

                    <label><b>First Name</label></b>
                    <input type="text" id="input" class="form-control" readonly value="<?=$user_info->fname?>" required="required"  title=""  placeholder=" ">

                    <label style="margin-top:11px";><b>Last Name</label></b>
                    <input type="text" id="input" class="form-control" readonly value="<?=$user_info->lname?>" required="required"  title=""  placeholder="  ">

                    <label style="margin-top:11px";><b>Email ID </label></b>
                    <input type="text" id="input" class="form-control" readonly value="<?=$user_info->email?>" required="required"  title=""  placeholder="">

                    <label style="margin-top:11px";><b>Phone No. </label></b>
                    <input type="text" id="input" class="form-control" readonly value="<?=$user_info->phone?>" required="required"  title=""  placeholder=" ">

                   </div>
                  
                  <a class="pull-right" href="<?=base_url()?>edit-profile" role="button">Edit Information</a>
                  
                </div>
              </div>
              <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <div class=" panel-primary">
                 
                 <h3 class=" panel-title text-primary mar-bottom-5"><b> Is Your Manuscript Ready?</b></h3>

                   <div class="form-group">
                    <select name="manuscript_ready" id="input" class="form-control" required="required">
                      <option value="" class="s">Select</option>
                      <option>Manuscript ready</option>
                      <option>Ready in 1-3 months  </option>
                      <option>Ready in 6 months </option>
                      <option>No manuscript </option>
                    </select>
                  </div>
               
                  
               

                </div>
              </div>
             
            </div>
         
            <hr>
            
            <div class="checkbox">
              <label>
                <input type="checkbox" value="" required>
              I agree to receive emails on promotional offers, discounts and other notifications. I may unsubscribe from these emails at any time
              </label>
              
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="" required>
                I agree to MyReposit Terms of Service and Conditions
              </label>
            </div>
            <div class="clearfix">
              
            </div>
            <center><button type="submit" class="btn btn-primary submit-flat btn-lg text-uppercase ">Submit</button></center>
         
            <center>  <h4 class="text-success" id="resp_form_out"></h4> </center> 
           
          </form>
          
          
        </div>
          <?php else: ?>
              
            <h4  ><b>Short on Time? Get personal assistance with your publishing needs</b></h4>
         
             <a href="<?=base_url()?>login?return=publish-sell" class="btn btn-warning text-uppercase"><b>Get Started</b></a>
     <!--      <h3> <a href="<?=base_url()?>login?return=publish-sell"> Sign in</a> to Upload and Sell Now!</h3> -->
            <p class="margin-top-5">Do not have an Account? <a href="<?=base_url()?>signup">Create one</a></p>

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

function manu_submit () 
{
   var formdata = $("#submit_form").serialize();
    $.ajax({
            url     : "<?=base_url()?>index.php/welcome/publish_sell_submit_request",
            type    : "post",
            data    : formdata,
            success : function( data ) 
                     {
                    
                          if(data > 0)
                          { 
                              $("#resp_form_out").html("<b>Thank you for your interest in MyReposit self-publishing services!</b> We have received your information. Our services consultants will contact you in 1-2 business days to discuss your needs.");
                               $("#resp_form_out").show();
                             return false;
                               }   
                          else {
                             
                               $("#resp_form_out").html("Connection Problem , Please try after some time.");
                               $("#resp_form_out").show();
                               return false;
                          }
                      },
            error   : function( xhr, err ) {
                        alert('Connection Problem');

                        $("#loading").hide();
     
                      }

        });
   return false;
}

    </script>