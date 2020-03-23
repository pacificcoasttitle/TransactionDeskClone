<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include("ext-menu.php");?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Upload</li>
              </ol>
              <div class="clearfix"></div>
              <div class="panel panel-default flat">
                <div class="panel-body">
                  <h3 class="panel-title">Assess the Impact of your Intellectual Work. Build your Publication List</h3><hr>
                  <p></p>
                  <div class="clearfix"></div>
                  <p>This section allows you to showcase your Published, Accepted and Working papers to the World and find potential collaborators. Simply complete the metadata associated with the type of publication and upload your file. Your work will be associated with your profile and become visible to both registered and non-registered users. You can open or restrict access to your work and even sell scholarly items (articles, manuals, ebooks etc.). MyReposit pays you directly into your own PayPal account.  </p>
                  <span style="color:red"><h4>Use your Myreposit code number to upload your work for Free!</h4></span>
                  <p>Fields marked with an asterisk (*) are mandatory. For more information on a field, hold your mouse over the icon (?). </p>
                  <h4><b>Start Uploading</b></h4>
                  <div class="row ">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                      <label>Type of Work<b><!-- <a href="javascript:;"  data-toggle="" data-placement="right" title="Status of Publication"><i class="icon-info"></i></a> --></b></label>
                      <select name="selectArticle" id="selectArticle" class="form-control" >
                        <option value="" class="s"class="s">-- Select --</option>
                        <option value="one" >Published</option>
                        <option value="two" >Accepted for Publication</option>
                        <option value="three" >Unpublished</option>
                        
                      </select>
                    </div>
                  </div>

                  <!-- start published form -->
                  <div id="one" class="article_tmp" style="display:none;">
                    <p>&nbsp;</p>
                    <div class="row">
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="">
                          <h3 class="text-uppercase panel-title">Enter Publication Metadata</h3>
                          <hr>
                          <div class="clearfix">
                          </div>
                          <form id="form_published" method="POST" role="form" onsubmit="return save_article('published')">
                           <!--  <div class="form-group">
                              <label for="inputEmail3" class="control-label">Publication Status
                               <swap>*</swap></label>
                              <select name="" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Publication Status">
                                <option value="">Published</option>
                                <option value="">Accepted For Publication</option>
                                <option value="">Not Published</option>
                              </select>
                            </div> -->
                            <input type="hidden" name="worktype" id="inputWork_type" class="form-control" value="Published">

                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">DOI <swap>*</swap></label>
                              <input required="required" name="doi"  type="text" class="form-control" id="inputPassword3" placeholder="" data-toggle="" data-placement="right" title="DOI"  onblur="check_doi(this.value,'published');">
                              <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive" alt="Image" id="loading_doipublished" style="display:none;">
                            </div>
                             <div class="form-group" style="display:none;">
                              <label for="inputPassword3" class="control-label">Discipline <swap>*</swap></label>
                              <select name="discipline" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Discipline">
                                <option value=""class="s">-- Select --</option>
                                <option value="Medicine" selected="true">Medicine</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Speciality <swap>*</swap></label>
                              <select name="subject" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Speciality" onchange="check_other_subject('published',this)">
                               <option value=""class="s">-- Select --</option>
                               <?php foreach ($departments as $key): ?>
                                <option><?=$key->departmentname?></option>
                                <?php endforeach ?>
                                <option value="other">Other</option>
                              </select>
                              <input  id="other_subject_published" type="text" class="form-control" style="display:none;">
                            </div>
                           
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Category <swap>*</swap></label>
                              <select name="category" id="input" class="form-control" required="Category" data-toggle="" data-placement="right" title="Category">
                               <option value=""class="s">-- Select --</option>
                               <option >Articles</option>
                                <option >Multimedia</option>
                                <option >Media Stories</option>
                                <option >Books</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Article Type <swap>*</swap></label>
                              <select name="type" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Article type" onchange="check_other_type('published',this)">
                               <option value= "" class="s">-- Select --</option>
                              <option>Method Development </option>
                              <option>Analytical measurement procedure </option>
                              <option>Imaging procedure </option>
                              <option>Biometric procedure </option>
                              <option>Test development assessment procedure </option>
                              <option>Animal study</option>
                              <option>Cell Study</option>
                              <option>Genetic engineering/Gene sequencing </option>
                              <option>Biochemistry</option>
                              <option>Material development </option>
                              <option>Genetic studies </option>
                              <option> study </option>
                              <option>Therapy study</option>
                              <option>Prognostic study</option>
                              <option>Diagnostic study </option>
                              <option>Observational study </option>
                              <option>Secondary data analysis </option>
                              <option>Case Study </option>
                              <option>Single case reports </option>
                              <option>Intervention study</option>
                              <option>Cohort study </option>
                              <option>Case control study </option>
                              <option>Cross-sectional study</option>
                              <option>Ecological study </option>
                              <option>Monitoring surveillance </option>
                              <option>Description with registry data </option>
                              <option>Meta-analysis </option>
                              <option>Review</option>
                              <option value="other">Other</option>
                              </select>
                    <input  id="other_type_published" type="text" class="form-control" style="display:none;">

                            </div>
                            <div class="form-group">
                              <div class="clearfix">
                                <label for="inputPassword3" class="control-label">Publication date<swap>*</swap></label>
                                <div class="row">
                                  <div class="col-sm-6 col-xs-6">
                                    <select required="Category" class="form-control" id="input" name="rdate_month" data-toggle="" data-placement="right" title="Month">
                                      <option value="" class="s" >Month</option>
                                      <?php 
                                            $i = 1;
                                            $month = strtotime('2011-01-01');
                                            while($i <= 12)
                                            {
                                                $month_name = date('F', $month);
                                                echo '<option value="'. $i. '">'.$month_name.'</option>';
                                                $month = strtotime('+1 month', $month);
                                                $i++;
                                            }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="col-sm-4 co l-xs-4" style="display:none;">
                                    <select required="Category" class="form-control" id="input" name="rdate_day" data-toggle="" data-placement="right" title="Day">
                                      <option value="" class="s">Day</option>
                                      <?php foreach (range(1,31) as $key): ?>
                                        <option <?=($key==1)?'selected="true" ':NULL?>><?=$key?></option>
                                      <?php endforeach ?>
                                    </select>
                                  </div>
                                  <div class="col-sm-6 col-xs-6">
                                    <select required="Category" class="form-control" id="input" name="rdate_year" data-toggle="" data-placement="right" title="Year">
                                      <option value="" class="s">Year</option>

                                       <?php foreach (range(1950,2015) as $key): ?>
                                        <option><?=$key?></option>
                                      <?php endforeach ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Title <swap>*</swap></label>
                              <textarea name="title" id="input" class="form-control" rows="3" required="required" data-toggle="" data-placement="right" title="Title"></textarea>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Abstract <swap>*</swap></label>
                              <textarea name="description" id="input" class="form-control" rows="3" required="required" data-toggle="" data-placement="right" title="Abstract"></textarea>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Peer reviewed
                               <swap>*</swap></label>
                              <select required="Category" class="form-control" id="input" name="" data-toggle="" data-placement="right" title="Peer reviewed">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                              </select>
                            </div>
                            <div class="form-group">
                            <label for="inputPassword3" class="control-label">First Author<swap>*</swap>
                              </label>
                              <div class="clearfix">
                                <div class="row">
                                  <div class="col-lg-12 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Name" id="input" name="author" required="required" data-toggle="" data-placement="right" title="First Author">
                                    <p class="visible-xs"></p>
                                  </div>
                                  
                                  
                                </div>
                              </div>
                            </div>
                            <div class="">
                              
                             
                              <div class="form-group">
                                
                                <input type="text" class="form-control" placeholder="Author Email" id="input" name="authoremail"  data-toggle="" data-placement="right" title="Email (optional)">
                              </div>
                               <div class="form-group">
                                <input type="text" class="form-control" placeholder="Organization (optional)" id="input" name="orgnization"  data-toggle="" data-placement="right" title="Organization (optional)">
                                
                              </div>
                               <div class="form-group">
                                <label for="inputPassword3" class="control-label">Contributers<swap>*</swap> 
                              </label>
                              <div id="box_contripublished">
                       
                              <div class="clone"><input type="text" name = "contri_name[]" placeholder="Enter Name"  required="required"  class="form-control"><div class="input-group"><input type="email" name = "contri_email[]"  placeholder="Enter Email ID"  required="required"  class="form-control"> <div style="cursor:pointer;" onclick="remove_contri(this)" class="input-group-addon"><i class="fa fa-times"></i></div></div><small>&nbsp;</small></div>
                            

                       
                        </div>
                              <button onclick="add_contributers('published')" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus" ></i> Add Contributers</button>
                              </div>
                            <!--   <div class="form-group">
                                <input type="text" class="form-control" placeholder="Co-Authors'" id="input" name="othercontributors"  data-toggle="" data-placement="right" title="Institution (optional)">
                                
                              </div> -->
                             
                            </div>
                            <div class="form-group">
                              <label class="control-label" text>Journal
                               <swap>*</swap></label>
                              <input type="text" class="form-control" id="input" required="required" name="journal" data-toggle="" data-placement="right" title="Journal">
                            </div>
                            <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label">Volume &amp; Issue
                                </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                      <input class="form-control" type="text" id="input" required="required" name="volume" placeholder="Volume" data-toggle="" data-placement="right" title="Volume">
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                      <input class="form-control" type="text" id="input" required="required" name="issue" placeholder="Issue" data-toggle="" data-placement="right" title="Issue">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label">Pages(s)
                                </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                      <input class="form-control" type="text" id="input" required="required" name="spageno" placeholder="First" data-toggle="" data-placement="right" title="First">
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                      <input class="form-control" type="text" id="input" required="required" name="epageno" placeholder="Last" data-toggle="" data-placement="right" title="Last">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="\control-label">Publisher
                               <swap>*</swap></label>
                              <input type="text" class="form-control" id="input" required="required" name="publisher" data-toggle="" data-placement="right" title="Publisher">
                            </div>
                            <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label">Select file *
                                </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                      <input name="userfile[]" id="file" type="file" data-toggle="" data-placement="right" title="There are two ways to provide your primary content to MyReposit. You can either upload a file or provide a URL where your content is already openly available">
                                    </div>
                                    <div class="col-xs-12 col-sm-9 text-right">
                                      * Upload Author Final version
                                       </div>
                                  </div>
                                  
                                </div>
                              
                                <div class="clearfix">
                                            <span><hr><div class="or">Or</div></span>
                                        </div>  <small>&nbsp;</small>
                                <div class="clearfix">
                                  <input  name="upload_link" class="form-control" id="input" placeholder="Paste URL of article location."data-toggle="" data-placement="right" title="Article URL">
                                </div>
                              </div>
                              <input type="hidden" name="userid" value="<?=$this->session->userdata('mpuserid');?>">
                            </div>
                            <div class="form-group">
                              <label class="control-label">Keywords <swap>*</swap> </label> 
                                <span class="pull-right">
                                  Seperate keywords with commas
                                </span>
                             
                              <input class="form-control" required="required" id="input" name="keyword" placeholder="Enter Keywords" data-toggle="" data-placement="right" title="Keywords">
                             
                            </div>
                            <div class="" id="embargo_yes1" style="display:none;">
                            <div class="form-group">
                              
                              <label>Embargo Date</label>
                              
                              <input  name=""  id="datepickerembargo_pub1" type="text" class="form-control" placeholder="Input Embargo date till">
                            </div>
                          </div>
                            <div class="form-group">
                              <div class="">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" value="" onchange="change_embargo(this.checked,1)">Delay public acces to (embargo) this work.
                                  </label> 
                                  <label>
                                    <input type="checkbox" value="">By clicking this checkbox, I agree to MyReposit <a class="colorBlue" data-toggle="modal" href='#modal-id'>Terms of Service</a>.
                                  </label>
                                </div>
                              </div>
                            </div>
                           
                           <!--  <div class="form-group">
                              <div class="">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" value="">By clicking this checkbox, I agree to MyReposit Submitter's Declaration.
                                  </label>
                                </div>
                              </div>
                            </div> -->
                            <div class="form-group">
                              <div class="">
                                <div class="btn-group btn-group-justified">
                                  <div class="btn-group">
                                    <button type="submit" id="published_submit" class="btn btn-success">Submit
                                    </button>
                                  </div>
                                  <div class="btn-group">
                                    <button type="reset" class="btn btn-primary">Reset
                                    </button>
                                  </div>
                                  <div class="btn-group">
                                    <button type="button" onclick="history.go(-1);" class="btn btn-primary">Cancel
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive" alt="Image" id="loading_published" style="display:none;">

                            </div>
                          </form>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="panel panel-default flat bg-gray">
                         <div class="panel-body">
                           <h4><b>Benefits of uploading your creative and intellectual output</b></h4>
                                    <hr>
                                    <ul>
                                    <li>Wider exposure </li>
<li> Better visibility</li>
<li> Universal access </li>
<li> Long-term preservation</li>
<li> Broad range of content</li>
<li> Synergy with other Publication Tracking Systems</li>
<li> Share Information. Keep Learning</li>
</ul>
                         </div>
                         </div>
                      </div>
                    </div>
                    
                  </div>
                  <!-- end published form -->
                  <!-- start accepted form -->
                  <div id="two"  class="article_tmp" style="display:none;">
                    <p>&nbsp;</p>
                    <div class="row">
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="">
                          <h3 class="text-uppercase panel-title">Enter Publication Metadata</h3>
                          <hr>
                          <div class="clearfix">
                          </div>
                          <form id="form_accepted" method="POST" role="form" onsubmit="return save_article('accepted')">
                          <!--  <div class="form-group">
                              <label for="inputEmail3" class="control-label">Publication Status
                               <swap>*</swap></label>
                              <select name="" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Publication Status">
                                <option value="">Published</option>
                                <option value="">Accepted For Publication</option>
                                <option value="">Not Published</option>
                              </select>
                            </div> -->
                            <input type="hidden" name="worktype" id="inputWork_type" class="form-control" value="Accepted">

                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">DOI <swap>*</swap></label>
                              <input required="required" name="doi"  type="text" class="form-control" id="inputPassword3" placeholder="" data-toggle="" data-placement="right" title="DOI"  onblur="check_doi(this.value,'accepted');">
                              <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive" alt="Image" id="loading_doiaccepted" style="display:none;">
                            </div>
                             <div class="form-group">
                              <label for="inputPassword3" class="control-label">Discipline <swap>*</swap></label>
                              <select name="discipline" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Discipline">
                                <option value=""class="s">-- Select --</option>
                                <option value="Medicine">Medicine</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Speciality <swap>*</swap></label>
                              <select name="subject" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Speciality" onchange="check_other_subject('accepted',this)">
                               <option value=""class="s">-- Select --</option>
                               <?php foreach ($departments as $key): ?>
                                <option><?=$key->departmentname?></option>
                                <?php endforeach ?>
                                <option value="other">Other</option>
                              </select>
                              <input  id="other_subject_accepted" type="text" class="form-control" style="display:none;">
                            </div>
                           
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Category <swap>*</swap></label>
                              <select name="category" id="input" class="form-control" required="Category" data-toggle="" data-placement="right" title="Category">
                               <option value=""class="s">-- Select --</option>
                               <option >Articles</option>
                                <option >Multimedia</option>
                                <option >Media Stories</option>
                                <option >Books</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Article Type <swap>*</swap></label>
                              <select name="type" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Article type" onchange="check_other_type('accepted',this)">
                               <option value= "" class="s">-- Select --</option>
                              <option>Method Development </option>
                              <option>Analytical measurement procedure </option>
                              <option>Imaging procedure </option>
                              <option>Biometric procedure </option>
                              <option>Test development assessment procedure </option>
                              <option>Animal study</option>
                              <option>Cell Study</option>
                              <option>Genetic engineering/Gene sequencing </option>
                              <option>Biochemistry</option>
                              <option>Material development </option>
                              <option>Genetic studies </option>
                              <option> study </option>
                              <option>Therapy study</option>
                              <option>Prognostic study</option>
                              <option>Diagnostic study </option>
                              <option>Observational study </option>
                              <option>Secondary data analysis </option>
                              <option>Case Study </option>
                              <option>Single case reports </option>
                              <option>Intervention study</option>
                              <option>Cohort study </option>
                              <option>Case control study </option>
                              <option>Cross-sectional study</option>
                              <option>Ecological study </option>
                              <option>Monitoring surveillance </option>
                              <option>Description with registry data </option>
                              <option>Meta-analysis </option>
                              <option>Review</option>
                              <option value="other">Other</option>
                              </select>
                    <input  id="other_type_accepted" type="text" class="form-control" style="display:none;">

                            </div>
                            <div class="form-group">
                              <div class="clearfix">
                                <label for="inputPassword3" class="control-label">Publication date<swap>*</swap></label>
                                <div class="row">
                                  <div class="col-sm-6 col-xs-6">
                                    <select required="Category" class="form-control" id="input" name="rdate_month" data-toggle="" data-placement="right" title="Month">
                                      <option value="" class="s" >Month</option>
                                      <?php 
                                            $i = 1;
                                            $month = strtotime('2011-01-01');
                                            while($i <= 12)
                                            {
                                                $month_name = date('F', $month);
                                                echo '<option value="'. $i. '">'.$month_name.'</option>';
                                                $month = strtotime('+1 month', $month);
                                                $i++;
                                            }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="col-sm-4 co l-xs-4" style="display:none;">
                                    <select required="Category" class="form-control" id="input" name="rdate_day" data-toggle="" data-placement="right" title="Day">
                                      <option value="" class="s">Day</option>
                                      <?php foreach (range(1,31) as $key): ?>
                                        <option <?=($key==1)?'selected="true" ':NULL?>><?=$key?></option>
                                      <?php endforeach ?>
                                    </select>
                                  </div>
                                  <div class="col-sm-6 col-xs-6">
                                    <select required="Category" class="form-control" id="input" name="rdate_year" data-toggle="" data-placement="right" title="Year">
                                      <option value="" class="s">Year</option>

                                       <?php foreach (range(1950,2015) as $key): ?>
                                        <option><?=$key?></option>
                                      <?php endforeach ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Title <swap>*</swap></label>
                              <textarea name="title" id="input" class="form-control" rows="3" required="required" data-toggle="" data-placement="right" title="Title"></textarea>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Abstract <swap>*</swap></label>
                              <textarea name="description" id="input" class="form-control" rows="3" required="required" data-toggle="" data-placement="right" title="Abstract"></textarea>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Peer reviewed
                               <swap>*</swap></label>
                              <select required="Category" class="form-control" id="input" name="" data-toggle="" data-placement="right" title="Peer reviewed">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                              </select>
                            </div>
                            <div class="form-group">
                            <label for="inputPassword3" class="control-label">First Author<swap>*</swap>
                              </label>
                              <div class="clearfix">
                                <div class="row">
                                  <div class="col-lg-12 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Name" id="input" name="author" required="required" data-toggle="" data-placement="right" title="First Author">
                                    <p class="visible-xs"></p>
                                  </div>
                                  
                                  
                                </div>
                              </div>
                            </div>
                            <div class="">
                              
                             
                              <div class="form-group">
                                
                                <input type="text" class="form-control" placeholder="Author Email" id="input" name="authoremail"  data-toggle="" data-placement="right" title="Email (optional)">
                              </div>
                               <div class="form-group">
                                <input type="text" class="form-control" placeholder="Organization (optional)" id="input" name="orgnization"  data-toggle="" data-placement="right" title="Organization (optional)">
                                
                              </div>
                               <div class="form-group">
                                <label for="inputPassword3" class="control-label">Contributers<swap>*</swap> 
                              </label>
                              <div id="box_contriaccepted">
                       
                              <div class="clone"><input type="text" name = "contri_name[]" placeholder="Enter Name"  required="required"  class="form-control"><div class="input-group"><input type="email" name = "contri_email[]"  placeholder="Enter Email ID"  required="required"  class="form-control"> <div style="cursor:pointer;" onclick="remove_contri(this)" class="input-group-addon"><i class="fa fa-times"></i></div></div><small>&nbsp;</small></div>
                            

                       
                        </div>
                              <button onclick="add_contributers('accepted')" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus" ></i> Add Contributers</button>
                              </div>
                            <!--   <div class="form-group">
                                <input type="text" class="form-control" placeholder="Co-Authors'" id="input" name="othercontributors"  data-toggle="" data-placement="right" title="Institution (optional)">
                                
                              </div> -->
                             
                            </div>
                            <div class="form-group">
                              <label class="control-label" text>Journal
                               <swap>*</swap></label>
                              <input type="text" class="form-control" id="input" required="required" name="journal" data-toggle="" data-placement="right" title="Journal">
                            </div>
                            <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label">Volume &amp; Issue
                                </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                      <input class="form-control" type="text" id="input" required="required" name="volume" placeholder="Volume" data-toggle="" data-placement="right" title="Volume">
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                      <input class="form-control" type="text" id="input" required="required" name="issue" placeholder="Issue" data-toggle="" data-placement="right" title="Issue">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label">Pages(s)
                                </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                      <input class="form-control" type="text" id="input" required="required" name="spageno" placeholder="First" data-toggle="" data-placement="right" title="First">
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                      <input class="form-control" type="text" id="input" required="required" name="epageno" placeholder="Last" data-toggle="" data-placement="right" title="Last">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="\control-label">Publisher
                               <swap>*</swap></label>
                              <input type="text" class="form-control" id="input" required="required" name="publisher" data-toggle="" data-placement="right" title="Publisher">
                            </div>
                            <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label">Select file *
                                </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                      <input name="userfile[]" id="file" type="file" data-toggle="" data-placement="right" title="There are two ways to provide your primary content to MyReposit. You can either upload a file or provide a URL where your content is already openly available">
                                    </div>
                                    <div class="col-xs-12 col-sm-9 text-right">
                                     
                                       </div>
                                  </div>
                                  
                                </div>
                                <small>&nbsp;</small>
                                <div class="clearfix">
                                  <input  name="upload_link" class="form-control" id="input" placeholder="If article is open access, Paste URL."data-toggle="" data-placement="right" title="Article URL">
                                </div>
                              </div>
                              <input type="hidden" name="userid" value="<?=$this->session->userdata('mpuserid');?>">
                            </div>
                            <div class="form-group">
                              <label class="control-label">Keywords <swap>*</swap> </label> 
                                <span class="pull-right">
                                  Seperate keywords with commas
                                </span>
                             
                              <input class="form-control" required="required" id="input" name="keyword" placeholder="Enter Keywords" data-toggle="" data-placement="right" title="Keywords">
                             
                            </div>
                            <div class="" id="embargo_yes1" style="display:none;">
                            <div class="form-group">
                              
                              <label>Embargo Date</label>
                              
                              <input  name=""  id="datepickerembargo_pub2" type="text" class="form-control" placeholder="Input Embargo date till">
                            </div>
                          </div>
                            <div class="form-group">
                              <div class="">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" value="" onchange="change_embargo(this.checked,1)">Delay public acces to (embargo) this work.
                                  </label> 
                                  <label>
                                    <input type="checkbox" value="">By clicking this checkbox, I agree to MyReposit <a class="colorBlue" data-toggle="modal" href='#modal-id'>Terms of Service</a>.
                                  </label>
                                </div>
                              </div>
                            </div>
                           
                           <!--  <div class="form-group">
                              <div class="">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" value="">By clicking this checkbox, I agree to MyReposit Submitter's Declaration.
                                  </label>
                                </div>
                              </div>
                            </div> -->
                            <div class="form-group">
                              <div class="">
                                <div class="btn-group btn-group-justified">
                                  <div class="btn-group">
                                    <button type="submit" id="accepted_submit" class="btn btn-success">Submit
                                    </button>
                                  </div>
                                  <div class="btn-group">
                                    <button type="reset" class="btn btn-primary">Reset
                                    </button>
                                  </div>
                                  <div class="btn-group">
                                    <button type="button" onclick="history.go(-1);" class="btn btn-primary">Cancel
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive" alt="Image" id="loading_accepted" style="display:none;">

                            </div>
                          </form>
                        </div>
                      </div>
                       <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="panel panel-default flat bg-gray">
                         <div class="panel-body">
                           <h4><b>Benefits of uploading your creative and intellectual output</b></h4>
                                    <hr>
                                    <ul>
                                    <li>Wider exposure </li>
<li> Better visibility</li>
<li> Universal access </li>
<li> Long-term preservation</li>
<li> Broad range of content</li>
<li> Synergy with other Publication Tracking Systems</li>
<li> Share Information. Keep Learning</li>
</ul>
                         </div>
                         </div>
                      </div>
                    </div>
                  </div>

                   <!-- end accepted form -->
                  <div id="three"  class="article_tmp" style="display:none;">
                    <p>&nbsp;</p>
                    <div class="row">
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="">
                          <h3 class="text-uppercase panel-title">Enter Metadata</h3>
                          <hr>
                          <div class="clearfix">
                          </div>
                          <form id="form_other-upload" method="POST" role="form" onsubmit="return save_article('other-upload')">
                           <!--  <div class="form-group">
                              <label for="inputPassword3" class="control-label">Publication Status <swap>*</swap></label>
                              <select name="" id="input" class="form-control" required="Category" data-toggle="" data-placement="right" title="Status of Publication">
                                <option value="">Not Published</option>
                                <option value="">Published</option>
                                <option value="">Accepted for Publication</option>
                              </select>
                            </div> -->
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Category <swap>*</swap></label>
                              <select name="" id="input" class="form-control" required="Category" data-toggle="" data-placement="right" title="Category">
                                <option value=""class="s">-- Select --</option>
                                <option>Announcements</option>
                                <option>Annuals</option>
                                <option>Bibliographies</option>
                                <option>Blogs</option>
                                <option>Booklets</option>
                                <option>Brochures</option>
                                <option>Bulletins </option>
                                <option>Call for Papers</option>
                                <option>Case Studies</option>
                                <option>Catalogues</option>
                                <option>Chronicles</option>
                                <option>Conference Papers</option>
                                <option>Conference Posters</option>
                                <option>Conference Proceedings</option>
                                <option>Course Material</option>
                                <option>Databases</option>
                                <option>Datasets</option>
                                <option>Datasheets</option>
                                <option>Deposited Papers</option>
                                <option>Directories</option>
                                <option>Dissertations</option>
                                <option>Doctoral Theses </option>
                                <option>E-Prints</option>
                                <option>E-texts</option>
                                <option>Essays</option>
                                <option>Fact Sheets</option>
                                <option>Feasibility Studies</option>
                                <option>Flyers</option>
                                <option>Folders </option>
                                <option>Glossaries</option>
                                <option>Government Documents</option>
                                <option>Guidebooks </option>
                                <option>Handbooks</option>
                                <option>House Journals </option>
                                <option>Image Directories</option>
                                <option>Inaugural Lectures</option>
                                <option>Internet Reviews</option>
                                <option>Interviews </option>
                                <option>Grey Journals</option>
                                <option>In-house Journals</option>
                                <option>Journal Articles</option>
                                <option>Non-commercial Journals</option>
                                <option>Synopsis Journals </option>
                                <option>Leaflets</option>
                                <option>Lectures</option>
                                <option>Manuals</option>
                                <option>Memoranda </option>
                                <option>Orations</option>
                                <option>Off-prints</option>
                                <option>Pamphlets</option>
                                <option>Papers</option>
                                <option>Patents</option>
                                <option>Policy Documents</option>
                                <option>Policy Statements</option>
                                <option>Posters</option>
                                <option>Preprints</option>
                                <option>Press Releases</option>
                                <option>Proceedings</option>
                                <option>Programs </option>
                                <option>Questionnaires </option>
                                <option>Reprints</option>
                                <option>Research Notes</option>
                                <option>Research Proposals</option>
                                <option>Research Registers</option>
                                <option>Research Reports</option>
                                <option>Reviews</option>
                                <option>Risk Analyses </option>
                                <option>Website Reviews</option>
                                <option>WebPages</option>
                                <option>Websites</option>
                                <option>White Books</option>
                                <option>White Papers</option>
                                <option>Working Documents</option>
                                <option>Working Papers </option>
                                <option>Yearbooks</option>
                                <option>OTHERS</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Title <swap>*</swap></label>
                              <input name="title"  id="" type="text" data-toggle="" data-placement="right" title="Title" required="" class="form-control">
                <input name="worktype"  id="" type="hidden"  class="form-control" value="Others">
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">First Author <swap>*</swap></label>
                              <input type="text" required name="author" class="form-control" id="inputPassword3" placeholder="" data-toggle="" data-placement="right" title="First Author"></input>
                            </div> 
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Author Email <swap>*</swap></label>
                              <input type="text" required name="authoremail" class="form-control" id="inputPassword3" placeholder="" data-toggle="" data-placement="right" title="Author Email">
                            </div>

                             <div class="form-group">
                             <div id="box_contri3">
                       
                      
                            

                       
                            </div>
                              <button onclick="add_contributers(3)" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus" ></i> Add Contributers</button>
                           <!--  <div class="form-group">
                              <label for="inputPassword3" class="control-label">Other Authors</label>
                              <input type="text" name="othercontributors" class="form-control" id="inputPassword3" placeholder="" data-toggle="" data-placement="right" title="Other Authors"></input>
                            </div> -->
                          </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Speciality <swap>*</swap></label>
                              <select name="subject" id="input" class="form-control" required="required" data-toggle="" data-placement="right" title="Speciality"onchange="check_other_subject('other',this)">
                                <option value=""class="s">-- Select --</option>
                                <?php foreach ($departments as $key): ?>
                                <option><?=$key->departmentname?></option>
                                <?php endforeach ?>
                              </select>
                              <input  id="other_subject_other" type="text" class="form-control" style="display:none;">
                            </div>
                           
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Description <swap>*</swap></label>
                              <textarea name="description" id="input" class="form-control" rows="3" required="required" data-toggle="" data-placement="right" title="Discipline"></textarea>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Keywords
                               <swap>*</swap></label>
                              <textarea name="keyword" id="input" class="form-control" rows="3" required="required" data-toggle="" data-placement="right" title="Keywords"></textarea>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Date Submitted <swap>*</swap></label>
                              <input type="text" class="form-control" name="rdate" required=""  id="datepicker_4" placeholder="" data-toggle="" data-placement="right" title="Date Submitted">
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Community
                               <swap>*</swap></label>
                                <select name="community" id = "other_community" onchange="set_price(this.value,'other-upload')" class="form-control" required  data-toggle="" data-placement="right" title="Communities">
                                  <option value= "" class="s">-- Select --</option>
                                  <!-- <option>Research Articles</option> -->
                                  <option> Cases</option>
                                  <option>Multimedia</option>
                                  <option>Media Stories</option>
                                  <option>Patient Education</option>
                                </select>
                            </div>
                            <div class="form-group">
                              <label for="inputPassword3" class="control-label">Do you wish to sell your work?
                              </label>
                              <select  onchange="pricing_toggle(this.value)" class="form-control" id="input" name="" data-toggle="" data-placement="right" title="Pricing">
                                <option val="" class="s">-- Select --</option>
                                <option value="Set Download price">Yes</option>
                                <option value="Keep my All other research open access">No</option>
                              </select>
                            </div>
                           
                            <div class="row" id="other-upload_slider-min" style="display:none;">
                              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                
                                <label for="amount">Set Price of your work (USD 10 - USD 20):</label>
                                <input type="text" id="other-upload_min_amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                <div class="other-upload-slider-range-min"></div>
                                <small>Slide to select price</small>
                                </div><input id="other-upload_payment" name="downloadpayment" value = "" type="hidden" class="form-control">
                              </div>
                              <div class="row" id="other-upload_slider-max" style="display:none;">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                  
                                  <label for="amount">Set Price of your work (USD 50 - USD 100):</label>
                                  <input type="text" id="other-upload_max_amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                  <div class="other-upload-slider-range-max"></div>
                                  <small>Slide to select price</small>
                                </div>
                              </div>
                              <small>&nbsp;</small>
                               <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label"><span style="color:red">Enter Myreposit code number (for free upload)</span>
                               </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-9">
                                      <input class="form-control"  id="promo_code_other-upload" placeholder="Enter Voucher Code" data-toggle="" data-placement="right" title="Enter voucher code to avail free upload and other offers">
                                      <span id="promo_code_other-upload_span"></span>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                      <button type="button" class="btn btn-default btn-sm" onclick="check_promo('other-upload',this)">Apply
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                              <input name="payment"  id="payment" value = "" type="hidden" class="form-control">
                              <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                   <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label">Upload your work <swap>*</swap>
                                </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                     <input name="userfile[]" id="file" type="file" required >
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                              <div class="clearfix">
                                <label class="control-label">Upload data file (XML file) <small>optional</small>
                                </label>
                                <div class="">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                     <input name="userfile[]" id="file" type="file" accept=".doc" >
                                    </div>
                                   
                                  </div>
                                </div>
                              </div>
                            </div>
                                </div>
                              </div>
                           
                          
                            <div class="form-group">
                              <div class="col-xs-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" value="">By clicking this checkbox, I agree to MyReposit <a href="<?=base_url()?>terms">Terms of Service</a>.
                                  </label>
                                   <label>
                                    <input type="checkbox" value="">By clicking this checkbox, I agree to MyReposit <a href="javascript:;">Submitter's Declaration</a>.
                                  </label>
                                </div>
                              </div>
                            </div>
                           
                            <div class="form-group">
                              <swap>* </swap>MyReposit does not review or endorse the contents of individuals' webpages or the contents of external links from these pages. Responsibility for the contents and opinions expressed on this page rests solely with the author. Opinions expressed on this webpage do not necessarily represent the views and opinions of MyReposit. MyReposit assumes no liability for any content or opinion expressed on this site, nor does it warrant that the contents and links are error or virus free.
                            </div>
                            <div class="form-group">
                              <button type="SUBMIT" class="btn btn-block btn-success">Save and Upload
                              <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive" alt="Image" id="loading_other-upload" style="display:none;">
                              </button>
                            </div>
                            <input type="hidden" name="userid" value="<?=$this->session->userdata('mpuserid');?>">
                          </form>

                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="panel panel-default flat bg-gray">
                        <div class="panel-body">
                           <h4><b>Make your unpublished material for you. Upload them now!</b></h4>
                                    <hr>
                                    <p>We believe that a researcher’s overall contribution to academia is far greater than their peer-reviewed publications recognizing that the growing accumulation of unpublished data represents an impediment to scientific progress. </p>
                                     </div>
                      </div>
                      </div>
                    </div>
                  </div>
                  <!-- end in review form -->
                  
                </div>
              </section>

<div class="modal fade" id="modal-id" >
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Terms of Service</h4>
</div>
<div class="modal-body" style="height:500px;overflow-y: scroll;">
<p><strong><em>Introduction </em></strong></p>
<p>MyReposit is a is a centralized multidisciplinary repository service that captures, stores, retrieves, organizes, disseminates, and preserves scholarly titles. It is also a personal repository of e-portfolio items, permitting individual reflections and peer-to peer presentations. The mission of MyReposit is to provide a permanent, safe, accessible, citable and user-friendly access to scholarly data. MyReposit has been developed to manage, store, share, and preserve stored versions of peer-reviewed published articles, clinical case studies, working papers, conference proceedings, media articles, continuing medical education formats, teaching materials, professional audio/video recordings, doctoral theses, project reports, dissertations, and research datasets, image collections, and course-related materials. MyReposit seeks to collaborate with publishers, universities, libraries, societies, funders, and other stakeholder in an attempt to leverage the advantages of a dynamic repository service.</p>
<p><strong><em>Benefits of MyReposit digital e-infrastructure </em></strong></p>
<ol>
<li>Collates scholarly work on a single podium instead of diffusing it in diverse publications;</li>
<li>Enhances impact of scholarly data by making it accessible, reusable and searchable for research and education,</li>
<li>Makes repository data discoverable thorough indexing and allocating Digital Object Identifiers (DOIs)</li>
<li>Increases citation rate - 30% more chances of work being cited when posted in a repository,</li>
<li>MyReposit Portfolio enhances learning and reflective practice by hosting personal writings, multimedia presentations, education kits and much more. MyReposit Portfolio facilitates individual representation, and increases discoverability and linking of grey literature,</li>
<li>Protects user privacy and address all demands of stake holders as expected and required of a dependable repository,</li>
<li>Eases user-access and eliminates the need to search multiple websites by merging stored data. Enhances the visibility of research via coalesced and Google search engines,</li>
<li>Customized dashboard to check stats on views, downloads, and purchases,</li>
<li>Manages publication embargos as specified by publication policy,</li>
<li>No copyright transfers. Distribution rights as permitted by Submitters and publishers,</li>
<li>Monitors content usage, facilitate data reuse and accessibility,</li>
<li>Provides ideal place to display and coordinate research submitted by students,</li>
<li>Powers the advantage and promotes open access publishing;</li>
<li>Permits collaboration, interaction and discussion with colleagues – Notifies the world of your work with Tweets and LinkedIn portals.</li>
</ol>
<p><strong>MyReposit aims to: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>
<ol>
<li>Enhance scholarly record by making data freely available and reusable for research and education,</li>
<li>Assign persistent digital Identifiers (DOIs) to repository content,</li>
<li>track the usage of content, and promote data reuse as a metric of scholarly credit,</li>
<li>manage data in accordance to publication embargos specified by publishers;</li>
<li>Provide a central index of grey literature that makes grey literature easily discoverable via dedicated access through submitter’s E-portfolio.</li>
<li>To meet and satisfy all parameters of a safe and dependable repository for all users.</li>
<li>Manage, share and preserve Theses/dissertations, Preprints/e-prints, proceeding of conferences and Presentations such as PPT slides, Data sets, Tech reports/Working Papers, E-books, Journals, Newspapers, Digitized institutional assets from library special collections, University publications and electronic records, Departmental materials or records, images, audio-video formats, musical scores, Exhibitions, Performances, Interview Transcripts, Plans, Maps, blueprints, Software, Course content, e.g. syllabi, lectures, Learning objects, Student papers other than theses or dissertations, E-portfolios, Blogs, Newsletters, Lab protocols, Guide to Exhibitions, Book Manuscript.</li>
</ol>
<p><strong>MyReposit Key Features </strong></p>
<ol>
<li>Upload, manage, share and preserve scholarly work; easy submission of data akin to processes<br>
adapted by Journals.</li>
<li>Flexible data input formats. Data linked to source publications and to respective repositories.</li>
<li>Data allocated Digital Object Identifiers (DOIs) enabling appropriate citations and gain in professional growth.</li>
<li>Metadata to help identify resources based on relevant criteria; merge identical resources; identify dissimilar resources and give location information.</li>
<li>Central indexing of grey literature makes grey literature easily discoverable via direct access through submitter’s E-portfolio. Enhances <em>searchability </em>by linking grey literature to metadata.</li>
<li>Enhances data visibility through better indexing, improved search capacity and quick data retrieval technical interface.&nbsp;</li>
<li>Dedicated user dashboard permits direct access to details on uploads. Access work of other research directly from their E-portfolio.</li>
<li>Real-time Data analytics measures visitor behavior and identifies data being viewed and downloaded.</li>
<li>Responsive design helps easier upload, access, search, and sharing of files from phone and tablet.</li>
<li>Contents free to download without legal barriers to reuse.</li>
<li>Update data files without altering original version linked to article.</li>
</ol>
<p><strong>Binding Agreement </strong></p>
<p>Terms of Services mentioned herewith apply to (a) submitter(s) who upload content on MyReposit with the intent of publishing on MyReposit Digital Repository (b) to those wish to pay on the behalf of submitters to upload and publish content on MyReposit Digital Repository and (c) to those who intent to reuse content from MyReposit Digital Repository. These Terms of Service apply equally to those who use MyReposit as a Web interface or use MyReposit in any other electronic format that is or might become available.</p>
<p>For queries or comments regarding these Terms of Service to <a href="mailto:help@myreposit.com">help@myreposit.com</a></p>
<p><strong>Definitions </strong></p>
<p>The following definitions shall apply to terms used herein:</p>
<ul>
<li><strong>Repository:</strong> MyReposit</li>
<li><strong>Content:</strong> data, file and other material uploaded.</li>
<li><strong>Data file:</strong> Content and metadata associated with a document</li>
<li><strong>Data Submitting Charge:</strong> one-time fee applicable for uploading data file in MyReposit.</li>
<li><strong>Document:</strong> a research article, or other scholarly publication (not limited to, a book, chapter, conference proceedings, monograph or dissertation).</li>
<li><strong>E-reposit:</strong> the repository myreposit.com operated by <a href="http://www.promedicahealth.co.in">www.promedicahealth.co.in</a>, including the software, interfaces, and contents.</li>
<li><strong>Embargo:</strong> delay in publishing Content for a specified duration.</li>
<li><strong>Publish</strong>: deposit Content in the Repository.</li>
<li><strong>Submit</strong>: data uploaded in MyReposit.</li>
<li><strong>Submitter:</strong> individual submitting MyReposit.</li>
<li><strong>Website:</strong> the webpages located under the myreposit.com domain.</li>
</ul>
<p><strong>Publication Policies</strong></p>
<p>MyReposit is an easy to use repository service that enables researcher to share their scholarly work with a worldwide audience. MyReposit has been developed by Promedica Health Communication Pvt. Ltd., knowledge management organization dedicated to offering knowledge support services around digital stewardship. MyReposit allows researcher to collect their work in one location and create a durable and citable record of their research, scholarly presentations, data sets of publications, or other scholarly creations. MyReposit captures scholarly content, teaching materials and creative works produced in the process of education, training, and research purposes. Such content may include journal pre and post prints, working, technical and conference papers, research work (e.g., master's theses), audio and visual content, annual reports, newsletters and data sets. MyReposit makes no restrictions on the state of submitted research, as long the author deposits the item in a state suitable to share and distribute. Sensitive data may not be included in MyReposit. Examples of sensitive data include: personally identifiable information, specific locations of endangered species (plants and animals), and conserved archeological sites. Research using humans as subjects must be approved by auhtorizing commitees and proper consent must be obtained from participants in order to share their information.&nbsp; In the event that such violations are found, MyReposit reserves the right to withdraw the submitted content.</p>
<p><strong>Content Criteria</strong></p>
<p><strong>e-Reposit</strong><strong> only Accepts Content that meet the following criteria:</strong></p>
<ol>
<li>Content must be a published scientific, medical or other scholarly research Document.</li>
<li>Content may only be submitted by an individual who represents and warrants that s/he is the creator and owner of the Content or otherwise has sufficient rights to be able to make the Content available under a CC0 Waiver. At MyReposit’s sole discretion, legacy Content may be permitted to be made available under other licensing terms. Such must be requested in writing until mentioned specifically on the website.</li>
<li>Content besides data set may be submitted to the Repository provided such Content is permissible by the Document publisher’s policy.</li>
<li>The Submitter admits that the Content is in compliance with the formatting and reporting guidelines of the Document’s publisher.</li>
<li>Most Data Packages in the MyReposit Repository are associated with peer-reviewed Documents, although data associated with non-peer reviewed Documents from scholarly sources are also accepted.</li>
<li>A single Data package will contain no more than 5 GB (Gigabytes). Alternatively, Data packages containing more than 5 GB might be accepted with additional storage costs.</li>
<li>Primary language of the Content should be English although storage of data in foreign languages is acceptable as long as copyright, and privacy provisions, as mentioned in MyReposit terms and services, are strictly adhered to and submitted in written prior upload data/content in myreposit.com.</li>
</ol>
<p><strong>Embargo Implication </strong></p>
<ol>
<li>Content/dataset is verified and uploaded by MyReposit curators at the shortest possible time.&nbsp; If instructed by a Submitter, the MyReposit might Embargo publication of Content for a period of one year following the earliest publication of the associated Document.</li>
<li>If instructed by a Submitter, and if permitted by their publisher, an Embargo period of greater than one year, but not greater than ten years, could be permissible. An Embargo specified with explicit termination date at the time of content Publication is imperative.</li>
</ol>
<p><strong>Concern, Retraction and Removal of Metadata Files</strong></p>
<p>In situations where validity of content becomes a concern, or where publishers post retraction or expression of concern with respect to content, MyReposit, will continue to make the content public albeit with appropriate warnings. Similarly, updated/corrected data files are linked to Publisher’s original data sets. For content that needs to be retracted from MyReposit, authors or publishers responsible with the document must contact MyReposit at <a href="mailto:help@myreposit.com">help@myreposit.com</a> with the following:</p>
<ul>
<li>Signature either in print or electronic that clearly authorizes the person to retract the content; statement of proof that the complaining entity has sufficient authority to undertake the retraction</li>
<li>Identification of infringed content or a list of multiple infringed contents.</li>
<li>Identification of subject or specific content that has been infringed; and by providing sufficient proof that infringement is in violation of law. &nbsp;</li>
<li>Contact details (email, telephone, address, fax etc.) of complaining entity.</li>
</ul>
<p><em>Notwithstanding the foregoing, MyReposit &nbsp;reserves the right to temporarily or permanently remove any Content at any time if MyReposit &nbsp;determines in its sole discretion that the Content is inappropriate (containing personally identifiable, sensitive, infringing or otherwise illegal material, or MyReposit &nbsp;is advised by legal counsel that inclusion of such Content presents a potential risk to MyReposit ); provided, however, MyReposit &nbsp;shall not be responsible for screening Content prior to or after its Publication for such issues. </em></p>
<p><strong>Large files </strong></p>
<ol>
<li>For unusually large files deposited, MyReposit reserves the right to transfer, with the consent of the owner, such files to a secondary repository; and is not obliged to retain a copy of transferred file.&nbsp;</li>
</ol>
<p><strong>MyReposit Warranties to Submitters </strong></p>
<p><strong><em>MyReposit curation personnel will provide Submitter support and will review and curate Content prior to and following Publication as follows: </em></strong></p>
<ol>
<li>Files will be examined for their compatibility and for virus threats.</li>
<li>Examine content to files to certify their scholarly source.</li>
<li>Examine and certify compatibility of data file submitted.</li>
<li>Examine and apply embargo details as specified by publishers; and to check of data files submitted are prior to or post publication.</li>
<li>Upload photograph of the submitter associated with the account and simultaneously create an e-portfolio with submitter’s photograph and abridged curriculum vitae details.</li>
<li>Create MyReposit URL (handle) associated with submitter e-portfolio page.</li>
<li>Create content Digital Object Identifiers (DOIs) with CrossRef and update the same.</li>
<li>Address and resolve all requests and concerns with respect to submission and retraction of content.&nbsp;</li>
</ol>
<p><strong>MyReposit reserved the right but is not obliged to: m </strong></p>
<ol>
<li>Check content for plagiarism and alert submitters when same are located.</li>
<li>Review submitted content for information that could be sensitive, inappropriate or unlawful.</li>
<li>Alert submitter for non-compliance if uploaded files are incompatible or if fields, other than mandatory, are not completed prior to submitting content.&nbsp;&nbsp;</li>
</ol>
<p><strong>MyReposit will not: </strong></p>
<ul>
<li>Make decision on the type of content that either the Publisher or Submitter wishes to deposit.</li>
<li>Undertake validity check on content of published literature.</li>
<li>Guarantee that all its actions are in compliance with those of Submitter, Publishers or Funders if instructions for MyReposit curators for not been provided prior to content being made public on eRepost.com&nbsp;</li>
</ul>
<p><strong>4.2 Content Distribution </strong></p>
<ol>
<li>MyReposit will make Accepted Content available to the public and communicate scholarly norms for data reuse to Submitters and Users including, but not limited to, guidelines for data citation. However, MyReposit shall NOT be responsible for enforcing scholarly norms.</li>
<li>MyReposit shall make commercially reasonable efforts to maintain the continual availability of the Repository at data MyReposit .org (subject to reasonable downtime for maintenance), and provide advance notice, of any material changes or discontinuities. However, MyReposit shall NOT be responsible for the consequences of any downtime, disruptions or discontinuity of the Repository, it applications or programming interfaces.</li>
<li>MyReposit is NOT responsible for the uses of Published Data Packages made by third parties, including those who view and download Data Packages through the Repository.</li>
</ol>
<p><strong>Preservation </strong></p>
<p style="margin-left:18.0pt;">The following steps will be taken by MyReposit to preserve the submitted content:</p>
<ol>
<li>MyReposit will maintain backup copies of uploaded Content. Content will be backed up to an independent remote server frequently throughout the day and to a long-term storage system daily. If MyReposit servers experience a failure, Content may be lost if it has not yet been migrated to a backup system.</li>
<li>If the need be, MyReposit may make submitted Content available for replication and indexing by third-party partners.</li>
<li>MyReposit may, at its discretion, may replace an older version of a data file with a newer version, if the same is tested to improve the archiving potential of the document or its public accessibility.</li>
<li>Although MyReposit strive to minimize information loss, in the event of file migration, MyReposit cannot guarantee that the same will be executed without flaws and that it may be possible that the file may be corrupted of its information lost during the process of migration.</li>
<li>In the event that MyReposit can no longer maintain its repository service, all MyReposit -registered DOIs will be transferred to a secondary repository, which will continue to provide access to the Content. At its sole discretion, MyReposit may choose to switch between secondary serves to optimize services.</li>
</ol>
<p><strong>Representations &amp; Warranties </strong></p>
<ul>
<li>MyReposit &nbsp;represents and warrants that it has the authority to enter into the Purchase Agreement (in the case of Purchasers) and these Terms of Service (in the case of Purchasers, Submitters and other Users), and to bind itself to the Terms of Service herein.</li>
<li>In the case of a Purchase Agreement, MyReposit further represents and warrants to the Purchaser that it has caused the Purchase Agreement to be executed by a duly authorized representative.</li>
</ul>
<p><strong>Purchaser Warranties to MyReposit &nbsp;</strong></p>
<p style="margin-left:36.0pt;">Purchases on MyReposit can be made directly through secure cash gateways or through the purchase of vouchers for single-use. Distribution and security of vouchers is the sole responsibility of the purchaser. MyReposit will not be responsible for lost, theft or misuse of vouchers in any form whatsoever. Usually, the cost of submitting content in MyReposit is calculated on the server space allocated to submitter. However, at the launch of MyReposit, and till such time the developers of MyReposit propose to modify, all submissions on MyReposit remain free of server space (GB Gigabyte) purchases. Currently, all submission (with no limit) are uploaded after paying the amount associated with each file. Once server space scheme come to effect, new costings will not be applicable on content already uploaded.</p>
<p><strong>Submitter Warranties to MyReposit &nbsp;</strong></p>
<p><strong>Permission </strong></p>
<ol>
<li>Uploading data on MyReposit implies that Submitter permits MyReposit to make the data open and accessible to public.&nbsp;</li>
</ol>
<ol>
<li>Submitter permits MyReposit to (i) market and promote the Data ;(ii) convert data into format(s) that enhances accessibility; (iii) change and add metadata to the Content; and (iv) execute appropriate technical changes that can help enhance the and preservability of data; and that MyReposit reserves the right to delete, at its sole discretion, content not deemed appropriate.</li>
<li>Submitters may update metadata for uploaded files and may submit updated files without additional charges. However, updated may entails extra server space for which excess storage charges may apply as such becomes applicable. MyReposit allocates unique URL to files as well as updates order of the version submitted.</li>
</ol>
<p><strong>Representations &amp; Warranties </strong></p>
<ul>
<li>By uploading on MyReposit, a Submitter warrants authorship and confirm that s/he is authorized to submit the content; and that s/he has the authority to submit data on the behalf of their co-authors.</li>
<li>Submitter warrants that data uploaded does not violate copyright or privacy rights of co-authors/co-creators or any other entity associated with the data.</li>
<li>Submitter warrants that data uploaded cannot be used alone or in conjunction with other information to identify any individual</li>
<li>Submitter warrants that single-use voucher will be used for the purpose they have been assigned and the same shall not be misused, forged or replicated with the intent of accessing services at MyReposit.</li>
</ul>
<p><strong>Payment</strong></p>
<p>MyReposit does not charge for submission that are not accepted. MyReposit accepts Submissions that meets content criteria i.e either published as scholarly literature or as content developed by MyReposit curators and endorsed by author(s) (for grey literatures).</p>
<p><strong>Hierarchy of Payments</strong></p>
<p>In the process of charging for Submissions, the following criteria applies:</p>
<ol>
<li>If Submission comes under Charge waiver, no charges will be applied for file upload.</li>
<li>If Submission comes under a Subscription plan, Subscription Plan charges will be applicable.</li>
<li>If Submission comes under Voucher Account, Voucher payments will be applicable.</li>
<li>If Submitter comes under single Use Voucher, the same will be redeemed.</li>
<li>If none of the above are applicable, Submitter will be charged per download.</li>
</ol>
<p><strong>Additional charges</strong></p>
<p>For content submission exceeding the limit of 10 GB, charges will be applied. For exceptionally large content, Submitter are obliged to pay charges connected with external storage of content or all third party charges associated with storage and preservability of content (external to MyReposit).</p>
<p><strong>Refunds</strong></p>
<p>MyReposit does not refund Submission charges or charges associated with excess storage.</p>
<p><strong>Ethical Use and </strong><strong>Ownership</strong></p>
<p>Submitters, Purchasers and Users are advised not to use services of MyReposit in any manner deemed unlawful or in a way that might disable or compromise the security of MyReposit. Developers of myreposit.com, own the website, its logo and proprietary services, and intend to develop eReposti as a global service supporting research and practice. Screenshots of the website, it logo, and associated trademarks may not be used by Submitters, Purchasers and Users for any purposes only after prior written permission from MyReposit has been obtained.</p>
<p><strong>Privacy</strong></p>
<ol>
<li>MyReposit respects the privacy of our Users and Submitters and is dedicated to protecting all information that is deemed private and confidential. Security is a vital issue for users of MyReposit. Enlistment on MyReposit is discretionary and voluntary. Searching and reviewing articles on our site does not require any individual data to be submitted from clients. Nor do these capacities oblige the client's program to be set to acknowledge cookies. Some different parts of our administrations distributed on our site do oblige the utilization of cookies, and the supply of data, for example, name, email, etc. This is important for security reasons for us to have the capacity to guarantee models of investigative trustworthiness.</li>
<li>Clients may submit further individual data like their points of interest so as to exploit present and future personalization offices on our site. Registrants may refuse to provide the information that has been requested. However, clients are exhorted to provide the data required since MyReposit may not be able to provide services unless the data fundamental for security and ID objects is given. So as to offer the best possible administration to clients, MyReposit tracks the examples of utilization of pages on the site. This helps us distinguish between the popularity of articles and services. When medical practitioners and scientists provide us with their topics of interest, the data that is assimilated helps MyReposit provide clients with the most relevant information.&nbsp;</li>
<li>Client data might be imparted to outsiders with the express assent of the client. Distribution of scientific manuscripts is characteristically an open instead of an anonymous methodology. The name and email location of all creators of MyReposit composition will be accessible to clients of MyReposit. This information is made accessible to encourage correspondence. Gathering of email addresses for business utilization is not permitted, nor will MyReposit itself send spontaneous email to creators, unless it concerns the paper they have distributed. MyReposit maintains whatever authority is needed to disclose the identities of clients if it required by the law, or in the greater confidence and conviction that such activity is important to consent to lawful methodology, react to cases, or ensure the rights, property or security of MyReposit, representatives or members.</li>
</ol>
<p><strong>Copyright</strong></p>
<p>The copyright of scholarly titles and other contents distributed on MyReposit by and large is owned by the Submitters (collectively Authors). The copyright on altering the format and configuration of academic titles belongs to MyReposit. The scholarly titles might be utilized according to authorizations identified by Submitters' license for utilization, dissemination, and reproduction in accordance with the extent allowed by the Copyright Law, (for example, for private utilization or reference). Prior permission should be obtained from the copyright owner for reproducing, duplication, open transmission, interpretation, business utilization or making of subsidiary data (counting compiling into databases), etc.</p>
<p><strong>Visibility and Sharing Options: Level Access </strong></p>
<p>During the process of upload, MyReposit allows permissions to be set, which implies the authority of the submitter to control who, and the way content are being viewed and downloaded. Submitters have the option of choosing the “VISIBIITY” option (implies those who can see the content or document) and the “SHARE” option (implies those who can edit the content or document). &nbsp;Visibility defines as setting selected by the submitter that will define who will and who will not view the content or document and its associated metadata in MyReposit. By default the setting in MyReposit is OPEN ACCESS. Open access permits the content to searched and retrieved by Google and can be accessed by anyone seeking the information in general or the topic in particular. Default Open Access visibility on MyReposit makes the document visible across the World Wide Web. “PRIVATE” settings allows visibility to only those people/groups with whom the content or document has been shared with. Submitter(s) cannot set a file as Open Access and at the same time restrict the file to a single user. In such case files can be marked as private and shared with a particular user or a group. Submitter can also grant View/Download or Edit access functionalities to user or group of users. Management of all the setting mentioned herewith are managed centrally by MyReposit.</p>
<p><strong>Collection and storage of Information from MyReposit </strong></p>
<ol>
<li>MyReposit will maintain and update usage records which will be used solely for scientific assessment purposes.&nbsp; &nbsp;</li>
<li>Information on the usage of data/content will be made public for information purposes.</li>
<li>Information on data usage will be exclusively used to improve monitoring services or to monitor the &nbsp;</li>
<li>Logs of usage may also be maintained for the purposes of monitoring and improving services, or determining the effect of a particular function on MyReposit. Third parties may have access to usage logs.</li>
</ol>
<p>Following information might be collected and analyzed by MyReposit.</p>
<ol>
<li>Computer operating system and IP address being used to access MyReposit.</li>
<li>Web browser type and version &nbsp;</li>
<li>URL of source, Date, time and IP address of the computer used to access MyReposit</li>
<li>Items searched, pages visited and downloaded and link accessed.</li>
<li>Above sources will be the minimal data accessed by MyReposit which will be utilized to improve services. Users will be informed in case additional user data is accessed.&nbsp;</li>
</ol>
<p><strong>Personally Provided Information</strong></p>
<ol>
<li>Users are not obliged to reveal personal identities if they chose not to submit data to MyReposit.</li>
<li>As policy, MyReposit does not record or store credit/debit card/bank account information pertaining or other sensitive information on its servers.</li>
</ol>
<p>Payments are made via PayPal will be subjected to PayPal terms of services and Privacy policy as mentioned on its websites.</p>
<ol>
<li value="3">Submitting data/content in MyReposit requires creating a User account utilizing basic fields such as Name, telephone numbers and email identification. Login will usually be required but exempted in case entering secure third party services. Information from essential personal are utilized exclusively to improve services such as billing, customer care and other authentication services. As policy, such information is not shared with third party vendors under any circumstances. As mandatory procedure, creators of account will be contacted to verify their account vide email and or via telephone in special circumstances. MyReposit will inform users of revelant updates on the website, and of new features and services/policies being upgraded.</li>
<li value="4">If users of MyReposit services choose to share additional personal information, such will be considered sensitive and will be protected to the extent permissible by local laws. MyReposit might use feedback and opinions on its services from customers for promotional purposes as such information is considered non-confidential unless stated otherwise by users.</li>
</ol>
<p>&nbsp;&nbsp;</p>
<p><strong>Security and Intrusion Detection </strong></p>
<p style="margin-left:18.0pt;">MyReposit operates via servers secured with continuous security monitoring services. To ensure appropriate accessibility at all times, MyReposit utilizes software programs to assess risk, intrusions and unauthorized attempt to access or alter data within the repository. Information from security monitoring software is utilized for investigative purposes in an event of a security breach.</p>
<p><strong>Disclosure of Personally Identifiable information </strong></p>
<p>MyReposit shares only aggregate information that does not qualify as private or sensitive. Sharing such aggregate information is, for example, done on Google Analytics, which help with statistics on how myreposit.com is being utilized. If MyReposit uses personal information for analytic purposes, it is only if (a) such information is included in the file made public and (b) if such information is required by law to protect individual identification. If disclosure of personal information is made to trusted third party, it is primarily to help MyReposit develop its services. Third party access to limited data is made available vide strict written confidential policies.&nbsp;</p>
<p><strong>Privacy Protection Limits</strong></p>
<p>It is the responsibility of Submitter not to share or disclose username, passwords or voucher details. If such has been compromised, Submitters should immediately reset the password or contact MyReposit at <a href="mailto:help@myreposit.com">help@myreposit.com</a> immediately for assistance. Although, MyReposit links to only trusted external third party services for payment and monitoring purposes, it cannot be held responsible for breach as consequence of third –party negligence. Submitters are advised to read and privacy statements of third party services operational on MyReposit.&nbsp;</p>
<p><strong>Privacy Concerns</strong></p>
<p>In case a Submitter is concerned about the accuracy of personal information on MyReposit, and wishes to modify the same, or in case the Submitter wishes to delete her or his personal information, or delete their account, such changes must be made in writing at <a href="mailto:help@myreposit.com">help@myreposit.com</a>&nbsp;</p>
<p><strong>Termination</strong></p>
<p>MyReposit reserves the right to suspend Submitter, Purchaser or User if such parties are suspected or found to engage in unlawful and prohibitive activities or are found to breach warranties as specified in the Terms of Service. In case of breach of obligations, responsibilities (including timely payment of dues) the breaching party will be duly informed in written and will have a period of 10 days to rectify the breach. &nbsp;MyReposit reserves the right to terminate account of Submitters if outstanding dues are not made within a period of 60 days from the due date. In such cases, MyReposit will not be held responsible for destruction of data associated with termination of account.</p>
<p><strong>Disclaimer</strong></p>
<p>MyReposit does not warranty of accuracy of its contents. For all content associate with medicine, surgery and allied healthcare disciplines, Submitters’, Users and Purchasers must be aware that Medicine is an ever-changing field. Although curators at myreposit.com have made every effort to post accurate and complete information. Rapidly changing research, and therapeutic protocols in medical science, and disease prevention may make human errors a real possibility. myreposit.com may contain technical inaccuracies, and typographic errors. It is mandatory that readers regularly check medical product information catalogues from reliable source or from manufacturers of drugs to verify accuracies in the dose recommendations, extent and method of administration, as well as for adverse effects. &nbsp;Only registered medical practitioners can best determine drug dosages, the best treatment, and the outcome of that treatment for their patients. Registered medical practitioners may use the content on myreposit.com at their own discretion. The information contained herein is provided "as is" and without warranty of any kind. myreposit.com, the contributors to this site, disclaim responsibility for any errors or omissions or for results obtained from the use of information contained herein.&nbsp; In case of a breach of prohibited use, Submitters shall indemnify MyReposit against any Claims (including attorneys’ fees) or liability from claims arising from misuse, theft, loss or damage of content uploaded by Submitter.</p>
<p><strong>Limitation and Release of Liability</strong></p>
<p>As permitted by law, under no circumstances shall MyReposit and its functionaries (director(s), employees, contractors, consultations, agents and other parties associated with MyReposit) be held accountable for damages (direct, indirect, special, and/or consequential) incurred by Submitter or purchasers or users in connection with the Content or Data (metadata) pack available in or downloaded from MyReposit or connected with the MyReposit website or any services or related services associated with MyReposit. This is applicable even under circumstances where damages are foreseeable. It is also hereby agreed, that maximum liability to Submitters/Users by MyReposit with respect to the content or metadata shall not exceed the amount paid by the Submitters/Users. In cases where no such amount is paid by the Submitters/Users, maximum liability incurred by MyReposit shall not exceed the sum of USD 10.</p>
<p><strong>Changes to Terms of Service </strong></p>
<p>MyReposit reserves the right to modify services and/or it’s Terms of Service at any time in order to ensure their appropriateness to MyReposit’s mission. Such changes will reflect on the website and communicated to Submitters via email. It remains the discretion of Submitters to check the Terms of Service catalogue on myreposit.com for changes if such have not been communicated to them or if they have not been able to access such updates on email. MyReposit will provide all Submitters tentative notification 30 days prior to incorporating the same on the website myreposit.com. If such are monetary in nature, Submitters are obliged to inform MyReposit of outstanding vouchers or subscription with pro-rata refund if these are in conflict with the proposed changes.&nbsp;</p>
<p><strong>General Miscellaneous Provisions </strong></p>
<p>It is to bring to notice that the Terms of Service herein is the entire agreement between MyReposit and the Submitter. Submitters can supersede oral commitments or other announcements if the same are not mentioned in the Terms of Service document. In case a term cannot be enforced, it will effect the standing of other Terms of Services. Waiver of a term of service does not imply indemnification from other Terms of Services. None of the Terms of Service apply to the third parties and Submitters cannot transfer such rights to third parties without prior consent from MyReposit.</p>
<p><strong>No Guarantee</strong></p>
<p>In no event will MyReposit be liable to the users for any loss or damage caused by or in connection to the right to gain access to MyReposit and related services. MyReposit will also not be held accountable for any change, suspension or discontinuance of the services.</p>
<p><strong>Trademark</strong></p>
<p>MyReposit is a registered trademark of Promedica Health Communication Pvt. Ltd.&nbsp;</p>
<p><strong>Contact</strong></p>
<p>Email: <a href="mailto:info@myreposit.com">info@myreposit.com</a></p>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modal-id2" >
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">Submitter’s Declaration</h4>
</div>
<div class="modal-body" style="height:500px;overflow-y: scroll;">
  <p>I hereby agree to deposit my dataset/content in MyReposit digital repository maintained by myreposit.com. I as a submitter also agrees to the following terms and conditions:</p>
  <p>By agreeing to the terms mentioned herewith, I, the submitter confirm that I am either the sole holder of rights of the dataset/content being submitted or have been authorized by all rights-holder(s) concerned or connected with the dataset/content to submit to myreposit.com repository. I also commit that notwithstanding the circumstances where scholarly content might be subjected to specified embargo, items/content deposited in MyReposit, must be made available to all online users who might wish to access the dataset/content. I confirm that I understand that my dataset/content deposited in myreposit.com repository will become accessible to a vast variety of people, institutions, automated agents and various search engines via the medium of World Wide Web.</p>
  <p>I also recognize and accept, that depositing dataset/content to myreposit.com repository does not oblige me to transfer ownership or rights to my work to myreposit.com or its functionaries. I also confirm that I am the author/owner of my proprietary work in its present and future version(s)), and that I retain the right to deposit my items/content electronically to other locations as well. I also acknowledge that whatever right accessed by myreposit.com repository with respect to items already deposited are non-exclusive and that I as the author/owner of my proprietary work retain all moral rights to my work, which includes the right to be acknowledged.&nbsp;</p>
  <p>By agreeing to terms and conditions enlisted here, I affirm that I am either the single rights-holder or have been permitted by all associated rights-holder(s) to deposit this dataset/content in myreposit.com repository. Thus subjected to restrictions as specified in the embargo timelines, the dataset/content deposited in myreposit.com must be made available to all user wishing to download the same.&nbsp;</p>
  <p>I also warrant that the dataset/content deposited in myreposit.com repository is my original work and in cases where it contains content that is copyrighted by a third-party, the same has been secured with appropriate permissions from right-holders or their representatives and that it does not breach the law with respect to defamation, libel and copyright. In cases where content has not procured appropriate permissions, the same has been deleted from my dataset/content prior to uploading on myreposit.com repository. I also agree that my dataset/content deposited does not infringe any particular patent, trademark, trade secret, copyright, publicity and privacy rights as well as other right of any other person or entity.</p>
  <p>I also affirm that in conditions where my dataset/content has been sponsored/supported/subsidized by any institution or an organization, I have completed all necessary obligations with respect to the institution or organization of publication(s).&nbsp; I also affirm that the dataset/content deposited in myreposit.com repository might not be accurate and that I indemnify myreposit.com, its functionaries, stakeholders and employees against any legal action with respect to my dataset/content deposited and that I continue to keep myreposit.com indemnified against loss, liability, claim and damage, which includes without limitation legal fees and court costs (on a full indemnity bases), of any term(s) included in this agreement that I might have breached.</p>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<form method="post" name="customerData" action="<?=base_url()?>ccpay/CUSTOM_CHECKOUT_FORM_KIT/ccavRequestHandler.php" id="paypal1">
    
      
        
        <input type="hidden" name="tid" id="tid" readonly />
        <input type="hidden" name="merchant_id" value="59422"/>
        <input type="hidden" name="order_id" value="123654789"/>
        <input type="hidden" id="paypal_amount"name="amount" value="1.00"/>
        <input type="hidden" name="currency" value="INR"/>
        <input type="hidden" name="redirect_url" id="redirect_url" value="http://myreposit.com/index.php/user/activate_article"/>
        <input type="hidden" name="cancel_url" id="cancel_url" value="http://myreposit.com/index.php/user/activate_article"/>
        
        <input type="hidden" name="language" value="EN"/>
        
           
        
        </form>
            
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
            <script>
$(function() {
$( "#slider-range" ).slider({
range: true,
min: 10,
max: 20,
values: [20],
slide: function( event, ui ) {
$( "#amount" ).val( "USD " + ui.values[ 0 ] );
$( "#payment" ).val(ui.values[ 0 ] );
}
});
$( "#amount" ).val( "USD " + $( "#slider-range" ).slider( "values", 0 ) );
//$( "#payment" ).val($( "#slider-range" ).slider( "values", 0 ) );
$( ".accepted-slider-range-min" ).slider({
range: true,
min: 10,
max: 20,
values: [20],
slide: function( event, ui ) {
$( "#accepted_min_amount" ).val( "USD " + ui.values[ 0 ] );
$( "#accepted_payment" ).val(ui.values[ 0 ] );
}
});
$( "#accepted_min_amount" ).val( "USD 20");
$( ".accepted-slider-range-max" ).slider({
range: true,
min: 50,
max: 100,
values: [100],
slide: function( event, ui ) {
$( "#accepted_max_amount" ).val( "USD " + ui.values[ 0 ] );
$( "#accepted_payment" ).val(ui.values[ 0 ] );
}
});
$( "#accepted_max_amount" ).val( "USD 100" );
$( "#accepted_payment" ).val(100);
$( ".inReview-slider-range-min" ).slider({
range: true,
min: 10,
max: 20,
values: [20],
slide: function( event, ui ) {
$( "#inReview_min_amount" ).val( "USD " + ui.values[ 0 ] );
$( "#inReview_payment" ).val(ui.values[ 0 ] );
}
});
$( "#inReview_min_amount" ).val( "USD 20");
$( ".inReview-slider-range-max" ).slider({
range: true,
min: 50,
max: 100,
values: [100],
slide: function( event, ui ) {
$( "#inReview_max_amount" ).val( "USD " + ui.values[ 0 ] );
$( "#inReview_payment" ).val(ui.values[ 0 ] );
}
});
$( "#inReview_max_amount" ).val( "USD 100" );
$( "#inReview_payment" ).val(100);
$( ".other-upload-slider-range-min" ).slider({
range: true,
min: 10,
max: 20,
values: [20],
slide: function( event, ui ) {
$( "#other-upload_min_amount" ).val( "USD " + ui.values[ 0 ] );
$( "#other-upload_payment" ).val(ui.values[ 0 ] );
}
});
$( "#other-upload_min_amount" ).val( "USD 20");
$( ".other-upload-slider-range-max" ).slider({
range: true,
min: 50,
max: 100,
values: [100],
slide: function( event, ui ) {
$( "#other-upload_max_amount" ).val( "USD " + ui.values[ 0 ] );
$( "#other-upload_payment" ).val(ui.values[ 0 ] );
}
});
$( "#other-upload_max_amount" ).val( "USD 100" );
$( "#other-upload_payment" ).val(100);
});
function set_price (value,id)
{
  $("#"+id+"_patient_optional").hide();
    $("#"+id+"_multimedia_optional").hide();
  if(value == "Research Articles")
  {
    $( "#paypal_amount" ).val(150);
    $("#"+id+"_slider-min").show();
    $("#"+id+"_slider-max").hide();
  }
if(value == " Cases")
  {
    $( "#paypal_amount" ).val(150);
    $("#"+id+"_slider-min").show();
    $("#"+id+"_slider-max").hide();
  }
if(value == "Multimedia")
  {
    $( "#paypal_amount" ).val(150);
    $("#"+id+"_patient_optional").hide();
    $("#"+id+"_multimedia_optional").show();
    $("#"+id+"_slider-min").hide();
    $("#"+id+"_slider-max").show();
  }
if(value == "Media Stories")
  {
    $( "#paypal_amount" ).val(200);
    $("#"+id+"_slider-min").hide();
    $("#"+id+"_slider-max").show();
  }
if(value == "Patient Education")
  {
    $( "#paypal_amount" ).val(150);
    $("#"+id+"_patient_optional").show();
    $("#"+id+"_multimedia_optional").hide();
    $("#"+id+"_slider-min").hide();
    $("#"+id+"_slider-max").show();
  }
}
function add_optional (dis,value)
{
  if(dis.checked)
  {
    $( "#paypal_amount" ).val(parseInt($( "#paypal_amount" ).val()) + value);
  }
  else
  {
    $( "#paypal_amount" ).val(parseInt($( "#paypal_amount" ).val()) - value);
  }
}
</script>
<script type="text/javascript">
function save_article(type)
{
$("#loading"+type).show();
var form = document.getElementById('form_'+type);
var formData = new FormData(form);
url="";
 if(type == 'published' || type== 'accepted')
  {
    var url = "<?php echo base_url()?>index.php/user/save_article/";
     }
     else
     {
      var url = "<?php echo base_url()?>index.php/user/save_other_article/";
     }



$.ajax({
url     : url,
type    : "POST",
data    : formData,
mimeType: "multipart/form-data",
contentType: false,
cache: false,
processData: false,
success : function( data )
{
  if(type == 'published' || type== 'accepted')
  {
     window.location.assign('<?php print base_url()?>index.php/user/activate_published_article?tx=erp123&st=success&amt=0&cm='+data);
  }
  else
  {
    $("#redirect_url").val('<?php print base_url()?>index.php/user/activate_article/'+data);
    $("#cancel_url").val('<?php print base_url()?>index.php/user/activate_article/'+data); 
    $("#paypal1").submit();
  }
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});
return false;
}
$(document).ready(function() {
  $("#datepickerembargo_pub" ).datepicker($.extend( {
dateFormat: 'yy-mm-dd',
}));
$("#datepicker23" ).datepicker($.extend( {
changeMonth: true,
changeYear: true,
maxDate: '0',
dateFormat: 'MM yy',
showButtonPanel: true,
onClose: function(dateText, inst) {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
$(this).datepicker('setDate', new Date(year, month, 1));
}
}));
$("#datepicker3" ).datepicker($.extend( {
changeMonth: true,
changeYear: true,
maxDate: '0',
dateFormat: 'MM yy',
showButtonPanel: true,
onClose: function(dateText, inst) {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
$(this).datepicker('setDate', new Date(year, month, 1));
}
}));
$("#datepicker4" ).datepicker($.extend( {
changeMonth: true,
changeYear: true,
maxDate: '0',
dateFormat: 'MM yy',
showButtonPanel: true,
onClose: function(dateText, inst) {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
$(this).datepicker('setDate', new Date(year, month, 1));
}
}));
$("#datepicker" ).datepicker($.extend( {
changeMonth: true,
changeYear: true,
maxDate: '0',
dateFormat: 'MM yy',
showButtonPanel: true,
onClose: function(dateText, inst) {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
$(this).datepicker('setDate', new Date(year, month, 1));
}
}));
$("#datepicker_2" ).datepicker($.extend( {
changeMonth: true,
changeYear: true,
maxDate: '0',
dateFormat: 'MM yy',
showButtonPanel: true,
onClose: function(dateText, inst) {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
$(this).datepicker('setDate', new Date(year, month, 1));
}
}));
$("#datepicker_3" ).datepicker($.extend( {
changeMonth: true,
changeYear: true,
maxDate: '0',
dateFormat: 'MM yy',
showButtonPanel: true,
onClose: function(dateText, inst) {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
$(this).datepicker('setDate', new Date(year, month, 1));
}
}));
$("#datepicker_4" ).datepicker($.extend( {
changeMonth: true,
changeYear: true,
maxDate: '0',
dateFormat: 'MM yy',
showButtonPanel: true,
onClose: function(dateText, inst) {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
$(this).datepicker('setDate', new Date(year, month, 1));
}
}));
$("#datepicker2" ).datepicker($.extend( {
changeMonth: true,
changeYear: true,
minDate: '0',
dateFormat: 'MM yy',
showButtonPanel: true,
onClose: function(dateText, inst) {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
$(this).datepicker('setDate', new Date(year, month, 1));
}
}));


$("#datepickerembargo_pub" ).datepicker($.extend( {
dateFormat: 'yy-mm-dd',
}));



});




function pricing_toggle (value)
{
var temp= $("#other_community").val();
if(value == "Set Download price")
{
set_price(temp,'other-upload')
}
if(value == "Keep my All other research open access")
{
$("#other-upload_slider-min").hide();
$("#other-upload_slider-max").hide();
$("#other-upload_payment").val(0);
}
}
function change_embargo (value,id)
{
if(value==true)
{
$("#embargo_yes"+id).show();
$(".ui-datepicker-calendar").css("display","block");
$("#datepickerembargo_pub"+id).attr("name",'embargodate');
}
if(value==false)
{
$(".ui-datepicker-calendar").hide();
$("#embargo_yes"+id).hide();
$("#datepickerembargo_pub"+id).attr("name",'');
}
}
function check_promo (worktype,btn)
{
var promo_code = $("#promo_code_"+worktype).val();
$("#loading1").show();
$.ajax({
url     : "<?php echo base_url()?>index.php/user/check_promo?code="+promo_code,
type    : "GET",
//data    : {promo_code:promo_code},
mimeType: "multipart/form-data",
contentType: false,
cache: false,
processData: false,
success : function( data )
{
if(data == 1)
{
$("#promo_code_"+worktype+"_span").removeClass("text-danger").addClass("text-success");
$("#promo_code_"+worktype+"_span").html("Voucher Code  correct");
$("#promo_code_"+worktype+"_submit").show();
$("#"+worktype+"_submit").hide();
$("#loading1").hide();
$(btn).attr("disabled","");
}
else if(data == 2)
{
$("#promo_code_"+worktype+"_span").removeClass("text-success").addClass("text-danger");
$("#promo_code_"+worktype+"_span").html("Voucher Code incorrect.For questions contact <a class='btn-link' href='mailto:admin@myreposit.com'>admin@myreposit.com</a>");
$("#loading1").hide();
}
else
{
$("#promo_code_"+worktype+"_span").removeClass("text-success").addClass("text-danger");
$("#promo_code_"+worktype+"_span").html("Voucher Code is already used by You.");
$("#loading1").hide();
}
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});
return false;
}
function check_doi (doi,type)
{
//$("#form_"+type+" input[name=title]").val("test");

$("#loading_doi"+type).show();
$.ajax({
url     : "<?php echo base_url()?>index.php/welcome/doi_info?doi="+doi,
type    : "GET",
//data    : {promo_code:promo_code},
mimeType: "multipart/form-data",
contentType: false,
cache: false,
processData: false,
success : function( data )
{
  $("#loading_doi"+type).hide();
var obj = $.parseJSON(data);
obj = obj.message;

$.each(obj,function(key,val){
  //alert(key);
if(key == "title")
{
  //alert(val);
$("#form_"+type+" textarea[name=title]").html(val[0]);
}
if(key == "publisher")
{
  //alert(val);
$("#form_"+type+" input[name=publisher]").val(val);
}

if(key == "volume")
{
  //alert(val);
$("#form_"+type+" input[name=volume]").val(val);
}



if(key == "subject")
{
  //alert(val);
  
$("#form_"+type+" select[name=discipline]").val('Medicine');
$("#form_"+type+" select[name=subject]").val(val[0]);
}



if(key == "page")
{
  //alert(val);
 var res = val.split("-"); 
$("#form_"+type+" input[name=spageno]").val(res[0]);
$("#form_"+type+" input[name=epageno]").val(res[1]);
}


if(key == "indexed")
{
  $.each(val,function(dprt,dd)
  {
      if(dprt == "date-parts")
      {
        var dpart = dd[0];
        //alert(dpart);
        $("#form_"+type+" select[name=rdate_year]").val(dpart[0]);
        $("#form_"+type+" select[name=rdate_month]").val(dpart[1]);
        $("#form_"+type+" select[name=rdate_day]").val(dpart[2]);
      }
  });
}



if(key == "assertion")
{
  $.each(val,function(dprt,ast)
  {
    //alert(ast.name);
      if(ast.name == "journaltitle")
      {
        $("#form_"+type+" input[name=journal]").val(ast.value);
      }
  });
}




if(key== 'author')
{ 
  var contributors = '';
   $.each(val,function(ind,auth_info)
  {
   
      if(ind == "0")
      {
        //var dpart = dd[0];
        var name = auth_info.given+' '+auth_info.family;
        $("#form_"+type+" input[name=author]").val(name);
      }
      else
      {
        var name = auth_info.given+' '+auth_info.family;
         contributors += '<div class="clone"><input type="text" name = "contri_name[]" placeholder="Enter Name"  required="required" value="'+name+'" class="form-control"><div class="input-group"><input type="email" name = "contri_email[]"  placeholder="Enter Email ID"  class="form-control"> <div style="cursor:pointer;" onclick="remove_contri(this)" class="input-group-addon"><i class="fa fa-times"></i></div></div><small>&nbsp;</small></div>';
                            
      }

  });
   $("#box_contri"+type).html(contributors);

}

});
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});

}



function check_other_subject (type,spc) 
{
  var value = $(spc).val();
  if(value=='other')
  {
    $("#other_subject_"+type).show();
    $("#other_subject_"+type).attr('required','required');
    $("#other_subject_"+type).attr('name','subject');
    $("#other_subject_"+type).attr('placeholder','Enter Type of Speciality.');
    $(spc).removeAttr('name');
  }
  else
  {
    $("#other_subject_"+type).hide();
    $("#other_subject_"+type).removeAttr('required');
    $("#other_subject_"+type).removeAttr('name');
    $(spc).attr('name','subject');
  }
}

function check_other_type (type,spc) 
{
  var value = $(spc).val();
  if(value=='other')
  {
    $("#other_type_"+type).show();
    $("#other_type_"+type).attr('required','required');
    $("#other_type_"+type).attr('name','type');
    $("#other_type_"+type).attr('placeholder','Enter Type of Article.');
    $(spc).removeAttr('name');
  }
  else
  {
    $("#other_type_"+type).hide();
    $("#other_type_"+type).removeAttr('required');
    $("#other_type_"+type).removeAttr('name');
    $(spc).attr('name','type');
  }
}




</script>