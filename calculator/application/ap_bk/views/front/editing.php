
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?=base_url()?>assets/front/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?=base_url()?>assets/front/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?=base_url()?>assets/front/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?=base_url()?>assets/front/css/jquery.fileupload-ui-noscript.css"></noscript>
        <!--/header-->
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
              <?php include 'ext-menu.php';?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li><a href="<?php echo base_url(); ?>manuscript-development">Manuscript Development</a></li>
                <li class="active">Editing</li>
              </ol>
              <div class="clearfix">
                
              </div>
           
             <div class="panel panel-default flat">
              <div class="panel-body">
                <h3 class="panel-title"><b>Publication Ready Manuscript Editing Services</b></h3>
                <hr>
                <div class="row">
                  <div class="col-xs-12 col-sm-2 text-center">
                    <a href="<?=base_url()?>editing">
                      <img src="<?=base_url()?>assets/front/images/edit1.png">
                    </a>
                  </div>
                  <div class="col-xs-12 col-sm-10">
                    <H3 class="no-margin margin-bottom-10">Editing </H3>
                  
                    <p>Our service concentrates on improve the flow of your manuscript to make it more effective. Our editors will polishes the written style and check for errors in spelling, grammar, punctuation, sentence construction, syntax, paragraph transitions and flow of your manuscript. We are committed to helping researchers increase their chances of publication by submitting manuscripts that are free of language errors. </p>
                  </div>
                </div>
                <div class="clearfix">
                  <p></p>
                </div>
                <?php if (isset($_GET['type'])): ?>
                   <?php if ($_GET['type']=='std' || $_GET['type']=='pro' || $_GET['type']=='pro_plus'): 
                        $type=$_GET['type'];

                       else: 
                         $type='std';
                    endif; ?>
                <?php else: 
                   $type='std';
                 endif ?>
               
                <div class="row  table-function" id="third1">
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-info">
                      <div class="panel-heading text-center">
                        <h3 style="background:none;"> Standard </h3>
                      </div>
                      <div class="panel-body">
                        <ul>
                          <li>Editing by one subject-expert editor in your field</li>
                          <li>Fastest turnaround times </li>
                          <li>One round of editing </li>
                        </ul>
                      </div>
                      <div class="panel-footer">
                        <?php if ($type=='std'): ?>
                        <a onclick="selected(this,'std')" class="btn-round btn-success btn-alt btn-block std selected1"> Standard Editing</a>
                          
                        <?php else: ?>
                        <a  onclick="selected(this,'std')" class="btn btn-round std btn-success btn-alt btn-block">Select Standard Editing</a>
                          
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-pup">
                      <div class="panel-heading text-center">
                        <h3 style="background:none;"> Pro </h3>
                      </div>
                      <div class="panel-body">
                        <ul>
                          <li> Editing by one subject-expert editor in your field </li>
                          <li> Suggestions regarding the finer details of language and style </li>
                          <li>Three rounds of re-editing at no charge</li>
                        </ul>
                      </div>
                      <div class="panel-footer">
                       <?php if ($type=='pro'): ?>
                        <a  onclick="selected(this,'pro')" class="btn-round btn-success btn-alt btn-block selected2"> Pro Editing</a>
                          <?php else: ?>
                        <a  onclick="selected(this,'pro')"  class="btn btn-round btn-success btn-alt btn-block">Select Pro Editing</a>
                        
                          <?php endif ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-danger">
                      <div class="panel-heading text-center">
                        <h3 style="background:none;"> Pro+ </h3>
                      </div>
                      <div class="panel-body">
                        <ul>
                          <li>Editing by two subject-expert editor in your field</li>
                          <li>Quality assessment by an experienced senior editor </li>
                          <li>Unlimited rounds of re-editing at no charge</li>
                        </ul>
                      </div>
                      <div class="panel-footer">
                      <?php if ($type=='pro_plus'): ?>
                        <a  onclick="selected(this,'pro_plus')" class=" btn-round btn-success btn-alt btn-block selected3"> Pro+ Editing</a>
                        
                      <?php else: ?>
                        <a  onclick="selected(this,'pro_plus')" class="btn btn-round btn-success btn-alt btn-block">Select Pro+ Editing</a>
                        
                      <?php endif ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix">
                </div>
                <div class="table-responsive">
                  <table class="table-colored std_table" id="std_table" <?=($type=='std')?'NULL':'style="display:none;"'?>>
                    <thead>
                      <tr>
                        <th bgcolor="#848787">Word Count</th>
                        <th bgcolor="#006b9e">2-days</th>
                        <th bgcolor="#006b9e">4-days</th>
                        <th bgcolor="#006b9e">6-days</th>
                        <th bgcolor="#006b9e">12-days</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="Short">
                        <td bgcolor="#d1d3d6">Short (
                        < 1,500 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#9ed6ef">$346</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#9ed6ef">$268</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#9ed6ef">$240</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#9ed6ef">$200</td>
                      </tr>
                      <tr class="Regular">
                        <td bgcolor="#e5e8e8">Regular (
                        < 1,501-6,000 words)</td>
                        <td onclick = "select_plan(this,2)" bgcolor="#c9edfc">$520</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#c9edfc">$407</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#c9edfc">$335</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#c9edfc ">$295</td>
                      </tr>
                      <tr class="Long">
                        <td bgcolor="#d1d3d6">Long (
                        < 6,001-12,000 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#9ed6ef">N/A</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#9ed6ef">$530</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#9ed6ef">$452</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#9ed6ef">$382</td>
                      </tr>
                      <tr class="Custom">
                        <td bgcolor="#e5e8e8">Custom* (>12,000 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#c9edfc">N/A</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#c9edfc">N/A</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#c9edfc">$50</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#c9edfc">$41</td>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table-colored pro_table" id="pro_table" <?=($type=='pro')?'NULL':'style="display:none;"'?>>
                    <thead>
                      <tr>
                        <th bgcolor="#848787">Word Count</th>
                        <th onclick = "select_plan(this,2)" bgcolor="#705ec6">2-days</th>
                        <th onclick = "select_plan(this,4)" bgcolor="#705ec6">4-days</th>
                        <th onclick = "select_plan(this,6)" bgcolor="#705ec6">6-days</th>
                        <th onclick = "select_plan(this,12)" bgcolor="#705ec6">12-days</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  class="Short">
                        <td bgcolor="#d1d3d6">Short (
                        < 1,500 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#d3cee8">$346</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#d3cee8">$268</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#d3cee8">$240</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#d3cee8">$200</td>
                      </tr>
                      <tr  class="Regular">
                        <td bgcolor="#e5e8e8">Regular (
                        < 1,501-6,000 words)</td>
                        <td onclick = "select_plan(this,2)" bgcolor="#e8e5f4">$520</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#e8e5f4">$407</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#e8e5f4">$335</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#e8e5f4 ">$295</td>
                      </tr>
                      <tr  class="Long">
                        <td bgcolor="#d1d3d6">Long (
                        < 6,001-12,000 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#d3cee8">N/A</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#d3cee8">$530</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#d3cee8">$452</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#d3cee8">$382</td>
                      </tr>
                      <tr  class="Custom">
                        <td bgcolor="#e5e8e8">Custom* (>12,000 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#e8e5f4">N/A</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#e8e5f4">N/A</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#e8e5f4">$50</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#e8e5f4">$41</td>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table-colored pro_plus_table" id="pro_plus_table" <?=($type=='pro_plus')?'NULL':'style="display:none;"'?>>
                    <thead>
                      <tr>
                        <th bgcolor="#848787">Word Count</th>
                        <th bgcolor="#9e5130">2-days</th>
                        <th bgcolor="#9e5130">4-days</th>
                        <th bgcolor="#9e5130">6-days</th>
                        <th bgcolor="#9e5130">12-days</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  class="Short">
                        <td bgcolor="#d1d3d6">Short (
                        < 1,500 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#e0c6ba">$346</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#e0c6ba">$268</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#e0c6ba">$240</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#e0c6ba">$200</td>
                      </tr>
                      <tr  class="Regular">
                        <td bgcolor="#e5e8e8">Regular (
                        < 1,501-6,000 words)</td>
                        <td onclick = "select_plan(this,2)" bgcolor="#f2e2d8">$520</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#f2e2d8">$407</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#f2e2d8">$335</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#f2e2d8 ">$295</td>
                      </tr>
                      <tr  class="Long">
                        <td bgcolor="#d1d3d6">Long (
                        < 6,001-12,000 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#e0c6ba">N/A</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#e0c6ba">$530</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#e0c6ba">$452</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#e0c6ba">$382</td>
                      </tr>
                      <tr  class="Custom">
                        <td bgcolor="#e5e8e8">Custom* (>12,000 words) </td>
                        <td onclick = "select_plan(this,2)" bgcolor="#f2e2d8">N/A</td>
                        <td onclick = "select_plan(this,4)" bgcolor="#f2e2d8">N/A</td>
                        <td onclick = "select_plan(this,6)" bgcolor="#f2e2d8">$50</td>
                        <td onclick = "select_plan(this,12)" bgcolor="#f2e2d8">$41</td>
                      </tr>
                    </tbody>
                  </table>
                  






                </div>
                <div class="clearfix" id="plan_detail">
                 
                  
                </div>
               <form id="fileupload" action="" method="POST" onsubmit="return save_order('editing')">
       <div class="panel-group pscript" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                      <a role="button"  data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        SERVICE FORM
                      </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <p>To enable us to provide you the best possible service and track the status of your work, please answer all the questions listed below. </p>
               
                          <div class="row ">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              
                              
                              <div class="form-group">
                                <label for="">Speciality</label>
                                <select name="speciality" id="input" class="form-control" required="required">
                                   <option value=""class="s">-- Select --</option>
                               <?php foreach ($departments as $key): ?>
                                <option><?=$key->departmentname?></option>
                                <?php endforeach ?>
                                </select>
                              </div>
                              
                              
                             
                              <div class="form-group">
                                <label for="">Add figures or tables to be formatted?</label>
                                <select name="farmat_figures" id="input" class="form-control" required="required">
                                  <option value=""class="s">-- Select --</option>
                                  <option>Yes</option>
                                  <option>No</option>
                                </select>
                              </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              
                              
                              <div class="form-group">
                                <label for="">Journal to Submit</label>
                                <input type="text" name="journal" id="input" class="form-control" value="" required="required" title="">
                              </div>
                              
                              
                              <div class="form-group">
                                <label for="">Title of your Document </label>
                                <input type="text" name="document_title" id="input" class="form-control" value="" required="required" title="">
                              </div>
                              
                              
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              
                              
                              <div class="form-group">
                                <label for="">Link to Journal </label>
                                <input type="url" name="journal_link" id="input" class="form-control" value="" required="required"  title="">
                              
                              </div>
                             
                              <div class="form-group">
                                <label for="">Add Formatting to Document </label>
                                <select name="format_document" id="input" class="form-control" required="required">
                                  <option value=""class="s">-- Select --</option>
                                  <option>Yes</option>
                                  <option>No</option>
                                </select>
                              </div>
                              
                              
                            </div>
                          </div>
                      
                        <div class="clearfix">
                          
                        </div>
                        <p><b>NOTE:</b> Please <a href="<?=base_url()?>request-quote"> request a quote</a> if you are submitting over 20 figures or if you have specific figure customization requirements. </p>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                      <a class="collapsed" role="button"  data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        UPLOAD  DOCUMENTS
                      </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
                        <h5>
                        UPLOAD MAIN DOCUMENT OR/AND  FIGURES, GRAPHS &amp; TABLES FOR FORMATTING
                          
                        </h5>
                        <p><img src="<?=base_url()?>assets/front/images/file-icon.jpg"></p>
                        <p>Format acceptable: DOC or .DOCX (Microsoft Word), PPT or PPTX (Microsoft PowerPoint), .XLS or .XLSX (Microsoft Excel), .CDR (CorelDRAW), AI or AIT (Adobe Illustrator), .PSD or .PDD
(Adobe Photoshop), and .EPS (Various Programs). Figures with file types not listed should be converted to .EPS. </p>
                       
   <!-- The file upload form used as target for the file upload widget -->
       <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-8">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-sm btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
              <!--   <button type="submit" class="btn btn-sm btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Upload All</span>
                </button>
                <button type="reset" class="btn btn-sm btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button> 
                <button type="button" class="btn btn-sm btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>-->
               
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-4 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table">
          <thead>
                            <tr>
                              <th class=" col-sm-3">Thumbnail</th>
                              <th class=" col-sm-3">File Name</th>
                              <th class=" col-sm-2">File Size</th>
                              <th class="col-sm-2">Remove</th>
                            </tr>
                          </thead>
        <tbody class="files"></tbody></table>
    </form>
<!--  -->

<hr>
                        <p><b>NOTE:</b> Upload the latest version of your manuscript. (Click "Add files" again to upload multiple files.)</p>
                       
                        <p>&nbsp;</p>
                        <div class="row">
                          
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            
                            
                            <div class="form-group">
                              <label>Enter Special Requests if any</label>
                             <textarea name="special_req" id="input" class="form-control" rows="3" ></textarea>
                            </div>

                            <div class="clearfix">

</div>
<h2>Sum Total: 200 USD</h2>
  <p>
    <input type="checkbox" value="" required>
   I agree to MyReposit<a href="<?=base_url()?>terms"> Terms of Service</a> & <a href="<?=base_url()?>privacy-policy"> Privacy and Data Protection Policy.</a> 
  </p>
<div class="clearfix">
<p>&nbsp;</p>
</div>
<button type="submit" class="btn btn-warning">Proceed to Payment  </button>
<img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive" alt="Image" id="loading1" style="display:none;">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                    </form>
                </div>
                
              </div>
            </div>
            <div class="panel panel-default panel-gray">
                    <div class="panel-heading">
                      <h4 class="panel-title">Disclaimer</h4>
                    </div>
                     <div class="panel-body">
                       Although we are confident that our Manuscript Editing Services will enhance the quality of your manuscript and help you publish faster, we cannot guarantee that your work will be published. However, we stand behind the quality of our work and will continue to address the requirement of authors subscribing to our services until such time the product is developed to satisfaction. This entails free reediting, formatting, figure preparation or translation on your manuscript till it complies with journal-specific conventions.

                      </div>
                    </div>
                    <p>If you have any suggestions or feedback about our service, please <a  href="<?=base_url()?>contact"> contact us.</a>
</p>
              </section>
<form method="post" name="customerData" action="<?=base_url()?>ccpay/CUSTOM_CHECKOUT_FORM_KIT/ccavRequestHandler.php" id="paypal1">
    
      
        
        <input type="hidden" name="tid" id="tid" readonly />
        <input type="hidden" name="merchant_id" value="59422"/>
        <input type="hidden" name="order_id" id="order_id" value="123654789"/>
        <input type="hidden" id="paypal_amount"name="amount" value="1.00"/>
        <input type="hidden" name="currency" value="INR"/>
        <input type="hidden" name="redirect_url" id="redirect_url" value="http://myreposit.com/index.php/user/activate_article"/>
        <input type="hidden" name="cancel_url" id="cancel_url" value="http://myreposit.com/index.php/user/activate_article"/>
        
        <input type="hidden" name="language" value="EN"/>
        
           
        
        </form>



              <script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button  class="btn btn-sm btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Upload</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button style="display:none" class="btn btn-sm btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-sm btn-default delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}<?php echo'&mpuserid='.$this->session->userdata('mpuserid');?>"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span></span>
                </button>
               
            {% } else { %}
                <button class="btn btn-sm btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span></span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}


 
</script>
<script type="text/javascript">
  
  function selected (btn,type) 
 {
   
    if (type=='std') 
      {
        $(btn).addClass('selected1');
        $(btn).removeClass('btn');
        $(".pro_table").hide();
        $(".pro_plus_table").hide();
        $(".std_table").fadeIn();
        $(".selected2").addClass("btn");
        $(".selected2").removeClass("selected2");
        $(".selected3").addClass("btn");
        $(".selected3").removeClass("selected3");

      }
    else if(type=='pro')
      {
          $(btn).addClass('selected2');
        $(btn).removeClass('btn');
        $(".pro_table").fadeIn();
        $(".pro_plus_table").hide();
        $(".std_table").hide();
        $(".selected1").addClass("btn");
        $(".selected1").removeClass("selected1");
        $(".selected3").addClass("btn");
        $(".selected3").removeClass("selected3");
      }
    else if(type=='pro_plus')
      {
          $(btn).addClass('selected3');
        $(btn).removeClass('btn');
        $(".pro_table").hide();
        $(".pro_plus_table").fadeIn();
        $(".std_table").hide();
        $(".selected2").addClass("btn");
        $(".selected2").removeClass("selected2");
        $(".selected1").addClass("btn");
        $(".selected1").removeClass("selected1");
      }

 }


function select_plan (td,days) 
{
  var table = $(td).closest('table');
  var tr = $(td).closest('tr');
  $('td',table).removeClass('price_selected');
  var sib = $(table).siblings("table");
  $.each(sib, function(index, value) 
  {
    $(value).find('td').removeClass('price_selected');
  });
  $('td .price_selected',sib).removeClass('price_selected');
  $(td).attr('class','price_selected');

  var price = $(td).html();
  var count = $(tr).attr('class');
  var plan = "";
  var plan_t = $(table).attr('id');
  if(plan_t == 'std_table')
  {
    plan = "Standard";
  }
  else if(plan_t == 'pro_table')
  {
    plan = "Pro";
  }
  else if(plan_t == 'pro_plus_table')
  {
    plan = "Pro +";
  }


  var plan_detail = ' <h3><u> Selected Plan</u></h3><h3 class="no-margin"><b>Editing type : </b> '+plan+' | <b>Word Count : </b> '+count+' | <b>Day Count : </b> '+days+'  | <b>Plan Price : </b> '+price+'</h3>';
  $("#plan_detail").html(plan_detail);
}


</script>

<script type="text/javascript">
function save_order(type)
{
$("#loading1").show();
var form = document.getElementById('fileupload');
var formData = new FormData(form);
url="<?=base_url()?>index.php/welcome/manuscript_editing_order";



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
    $("#order_id").val(data);
    $("#redirect_url").val('<?php print base_url()?>index.php/user/activate_order/'+data);
    $("#cancel_url").val('<?php print base_url()?>index.php/user/activate_order/'+data); 
    $("#paypal1").submit();
  
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});
return false;
}
</script>