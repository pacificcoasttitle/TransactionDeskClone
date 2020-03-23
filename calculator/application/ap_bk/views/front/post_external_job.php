
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include "ext-menu.php";?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Post a job</li>
              </ol>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                  <div class="panel panel-default flat" id="main-height">
                <div class="panel-body">
                  <h3 class="text-uppercase panel-title">Post a job</h3>
                  <hr>
                   <div class="clearfix"></div>
                  <p class="pull-right">*All fields are required.</p>
                  <form action="" method="POST" class=" contact-form col-lg-8" role="form" >
                   
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Copmany Name</label>
                        <input type="text"  pattern="^[ a-zA-Z]+$" name = "company_name" required="required" class="form-control">
                      </div>

<div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Job Title</label>
                        <input type="text"  pattern="^[ a-zA-Z]+$" name = "job_title" required="required" class="form-control">
                      </div>                      <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Location</label>
                        <input type="text" pattern="^[ a-zA-Z]+$" name = "location" required="required"  class="form-control">
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Job Function</label>
                      <select name="job_function" id="inputJob_function" class="form-control" required="required">
                        <option value="" class="s">Select</option>
                        <option>Manager/Director Technical Affairs</option>
                        <option>R&D Project Managers/Directors</option>
                        <option>Product Development</option>
                        <option>Research Scientists & Chemists</option>
                        <option>Microbiologists</option>
                        <option>Analytical Development Managers/Directors</option>
                        <option>Formulations Development</option>
                        <option>Process Development</option>
                        <option>Account Managers</option>
                        <option>Business Development Managers</option>
                        <option>Territory Sales Manager/Directors</option>
                        <option>Managers</option>
                        <option>Quality Assurance Manager/Directors</option>
                        <option>Regulatory Affairs Manager/Directors</option>
                        <option>Sr. Quality Engineers</option>
                        <option>Validation Engineers & Managers</option>
                        <option>Supplier Quality Managers & Engineers</option>
                        <option>Design Control & Risk Management</option>
                        <option>Design manager</option>
                        <option>Print coordinator</option>
                        <option>Production supervisor</option>
                        <option>Web manager</option>

                      </select>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Experience</label>
                         <select name="experience" id="inputJob_function" class="form-control" required="required">
                        <option value="" class="s">Select</option>
                       <option>Executive </option>
                       <option>Director </option>
                       <option>Mid-senior </option>
                       <option>Associate </option>
                       <option>Entry level </option>
                       <option>Internship</option>
                       <option>Not applicable</option>

                      </select>
                       </div>
                       <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Job type</label>
                         <select name="job_type" id="inputJob_function" class="form-control" required="required">
                        <option value="" class="s">Select</option>
                       <option>Full time  </option>
                       <option>Part time  </option>
                       <option>Regular </option>
                       <option>Temporary </option>
                       <option>Volunteer  </option>
                      </select>
                      </div>
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Job Description</label>
                        <textarea id="comments" name="job_description" class="form-control" rows="3" required></textarea>
                      </div>

                       <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Desired Qualification</label>
                        <textarea id="comments" name="desired_qualification" class="form-control" rows="3" required></textarea>
                      </div>

                       <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Compensation Package</label>
                        <input type="text"  name = "compensation_package" required="required" class="form-control">
                      </div>

                       <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap>*</swap>Where to apply</label>
                        <input type="url"  name = "apply_from" required="required" class="form-control">
                      </div>
<input type="hidden" name="user_id" id="inputUser_id" class="form-control" value="<?=$this->session->userdata('mpuserid');?>">
                      <div class="form-group ">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                   
                  </form>
                </div>
              </div>
                </div>
                
              </div>
              
            </section>
