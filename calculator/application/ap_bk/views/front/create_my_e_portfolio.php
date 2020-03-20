
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include "ext-menu.php";?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Create My Profile</li>
              </ol>
              <div class="clearfix"></div>
              <div class="panel panel-default flat">
                <div class="panel-body">
                  <h3 class="text-uppercase panel-title"> Create My Profile</h3>
                  <hr>
                  <?=$page_content->content?>
                  <div class="clearfix"></div>
                 
                  <form action="" method="POST" class=" contact-form" role="form"enctype="multipart/form-data">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>* </swap>Upload CV/Biodata</label>
                        <input id="file" type="file" name="userfile1"  required="">
                      </div>
                      </div>
                       <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>* </swap>Upload Photo</label>
                        <input id="file" type="file" name="userfile2"  required="">
                      </div>
                      </div>
                      
                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <p class="pull-right">*All fields are required.</p>
                        <button type="submit" class="btn btn-primary">Submit</button>
                     
                      </div>
                   
                  </form>
                </div>
              </div>
            </section>
