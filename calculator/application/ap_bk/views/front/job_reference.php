<div class="container">
  <div class="content-wrapper">
    <section id="content">
      <?php include "ext-menu.php";?>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="active">Job Reference</li>
      </ol>
      <div class="clearfix"></div>
      <div class="panel panel-default flat">
        <div class="panel-body">
          <h3 class="text-uppercase panel-title">Employee referral </h3>
          <hr>
          <div class="clearfix"></div>
          <p >Thank you for referring. Please complete the form below to help us get in touch with you and/or your referral. <br>Fields marked with * are required. </p>
          <form action="" method="POST" class=" contact-form" role="form" enctype="multipart/form-data">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
              <h4>Your Information</h4>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>First Name
                </label>
                <input type="text" pattern="^[ a-zA-Z]+$" name = "fname" required="required"  class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Last Name
                </label>
                <input type="text" pattern="^[ a-zA-Z]+$" name = "lname" required="required"  class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Email
                </label>
                <input type="email"  name = "study_title" required="required"  class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Phone   </label>
                <input type="text" pattern="^[ 0-9]+$" maxlength="10" name = "keyword" required="required"  class="form-control">
              </div>
              <h4>Referral Information</h4>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>First Name</label>
                <input id="comments"  pattern="^[ a-zA-Z]+$"  name="referal_first_name" class="form-control"  required>
              </div>
               <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Last Name</label>
                <input id="comments" pattern="^[ a-zA-Z]+$"  name="referal_last_name" class="form-control"  required>
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Phone
                </label>
                <input type="text" pattern="^[ 0-9]+$" maxlength="10" name = "referal_phone" placeholder=""  required="required"  class="form-control">
                
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Email ID
                </label>
                
                <input type="email" name = "referal_email"  placeholder=""  required="required"  class="form-control">
              </div>
              <div class="form-group ">
                <button type="submit" class="btn btn-primary">Submit </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>