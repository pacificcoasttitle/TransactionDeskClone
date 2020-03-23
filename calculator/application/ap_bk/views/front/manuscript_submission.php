
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include "ext-menu.php";?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Manuscript Submission</li>
              </ol>
              <div class="clearfix"></div>
              <div class="panel panel-default flat">
                <div class="panel-body">
                  <h3 class="text-uppercase panel-title">SUBMIT YOUR MANUSCRIPT  </h3>
                  <hr>
                  <div class="clearfix"></div>
                  <p class="pull-right">*All fields are required.</p>
                  <form action="<?=base_url()?>index.php/welcome/submit_manuscript" method="POST" class=" contact-form" role="form" enctype="multipart/form-data">
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3">Type of Study<swap>*</swap>  
</label>
<select name="study_type" id="input" class="form-control" required="required">
  <option value="Original Basic research">Original Basic research</option>
  <option value="Original Clinical research ">Original Clinical research </option>
  <option value="Systematic review">Systematic review</option>
  <option value="Brief report ">Brief report </option>
  <option value="Meta-analysis">Meta-analysis</option>
</select>

                      </div>
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3">Title of Study<swap>*</swap>
</label>
                        <input type="text" name = "study_title" required="required"  class="form-control">
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3">Keywords<swap>*</swap>   </label>
                        <input type="text" name = "keyword" required="required"  class="form-control">
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3">Abstract<swap>*</swap></label>
                        <textarea id="comments" name="abstract" class="form-control" rows="3" required></textarea>
                      </div>
                        <div class="form-group">
                        <label class="control-label" for="inputEmail3">First Author<swap>*</swap>
                        </label>
                        <input type="text" name = "author_name1" placeholder="Enter Name"  required="required"  class="form-control">
                       
                    <small>&nbsp;</small>
                        <input type="email" name = "email1"  placeholder="Enter Email ID"  required="required"  class="form-control">
                        </div> 
                         <div class="form-group">
                        <label class="control-label" for="inputEmail3">Contributers
                        </label><br>
                        <div id="box_contri1">
                       
                      
                            

                       
                        </div>

                        <button onclick="add_contributers(1)" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus" ></i> Add Contributers</button>
                        </div>
                         <div class="form-group">
                        <label class="control-label" for="inputEmail3">Upload Document<swap>*</swap>
                        </label>

                        <input type="file" name = "userfile1" required="required"  >
                       
                        </div>

                     
<?php 
 //$date = strtotime($date);
   $date = strtotime("+10 day");
?>
<h4>
Cost per manuscript: 200 USD </h4>

                     
                      <div class="form-group ">
                        <button type="submit" class="btn btn-primary">Submit & Proceed to Payment</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </section>
