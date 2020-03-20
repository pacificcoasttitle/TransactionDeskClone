
<div class="container">
  <div class="content-wrapper">
    <section id="content">
      <?php include "ext-menu.php";?>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="active">Contact us</li>
      </ol>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
          <div class="panel panel-default flat" id="main-height">
            <div class="panel-body">
              <h3 class="text-uppercase panel-title">Contact US</h3>
              <hr>
              <div class="clearfix"></div>
              <p class="pull-right">*All fields are required.</p>
              <form action="" method="POST" class=" contact-form" role="form">
                
                <div class="form-group">
                  <label class="control-label" for="inputEmail3"><swap>*</swap>First Name</label>
                  <input type="text"  pattern="^[ a-zA-Z]+$" name = "name" required="required" class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label" for="inputEmail3"><swap>*</swap>Last Name</label>
                  <input type="text"  pattern="^[ a-zA-Z]+$" name = "lname" required="required" class="form-control">
                </div>                      <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Email</label>
                <input type="email" name = "email" required="required"  class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Phone</label>
                <input type="text"  pattern="^[ 0-9]+$" maxlength="10" name = "phone" required="required"  class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label" for="inputEmail3"><swap>*</swap>Comments/Query</label>
                <textarea id="comments" name="comments" class="form-control" rows="3" required></textarea>
              </div>
              
              <div class="form-group ">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="panel panel-default flat bg-gray" id="same-height">
          <div class="panel-body">
            <h4><b>We look forward to hearing from you</b></h4>
            <hr>
            <p>MyReposit Customer Support is available during regular business hours, Monday through Friday. Should you require assistance, our support team will navigate you through our website. You can also contact us via phone or using live chat feature. Our support will be ready to assist you with your queries.</p>
          </div>
        </div>
      </div>
    </div>
    
  </section>