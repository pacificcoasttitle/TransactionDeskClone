<div class="container">
  <div class="content-wrapper">
    <section id="content">
      <?php include "ext-menu.php";?>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="active">Submit Resume</li>
      </ol>
      <div class="clearfix"></div>
      <div class="panel panel-default flat">
        <div class="panel-body">
          <h3 class="text-uppercase panel-title">Submit your Resume  </h3>
          <hr>
          <div class="clearfix"></div>
          <p >Thank you for choosing MyReposit as a prospective employer. Please complete the fields and upload your resume (CV, curriculum vitae).    Acknowledge the receipt of a resume via email. </p>
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
                <input type="email" name = "email" required="required"  class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Phone   </label>
                <input type="text" pattern="^[ 0-9]+$" maxlength="10" name = "phone" required="required"  class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Attach Resume   </label>
                      <input type="file" name="userfile1" id="input" required >
                
              </div>
              <div class="form-group ">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>