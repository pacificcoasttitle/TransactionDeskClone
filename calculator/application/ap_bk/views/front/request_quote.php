<?php session_start();?>
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
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
             <?php include "ext-menu.php";?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Request Quote</li>
              </ol>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default flat" id="main-height">
                <div class="panel-body">
                  <h3 class=" panel-title">Request Quote</h3>
                  <hr>
                   <div class="clearfix"></div>
                  
                        <p>This Request Quote form allows you to specify your requirement.
Please fill Your requirement section in detail. We will receive more
informationfromusviaemail</p>

 <form id="fileupload" action="<?=base_url()?>index.php/welcome/manuscript_custom_order" method="POST" >
     
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
       <div class="form-group">
        <label for="">Fist Name</label>
       <input type="text" name="fname" id="input" class="form-control" value="" required="required" title="">
      </div>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
       <div class="form-group">
        <label for="">Last Name</label>
       <input type="text" name="lname" id="input" class="form-control" value="" required="required" title="">
       
      </div>
  </div>
</div>

 <div class="form-group">
        <label for="">Your Email</label>
       <input type="text" name="email" id="input" class="form-control" value="" required="required" title="">
       
      </div>
 <div class="form-group">
        <label for="">Write your requirement in detail </label>
    <textarea name="requirement" id="input" class="form-control" rows="3" required="required"></textarea>
       
      </div>
      <div class="clearfix">
      
      </div>
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
      <p></p>
     
                    
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

<hr>
         <p><b>NOTE:</b> Upload the latest version of your manuscript. (Click "Add files" again to upload multiple files.)</p>
                       
                        <p>&nbsp;</p>
                        <div class="row">
                          
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            
                            <div class="clearfix">

</div>
  <p>
    <input type="checkbox" value="" required>
   I agree to MyReposit<a href="<?=base_url()?>terms"> Terms of Service</a> & <a href="<?=base_url()?>privacy-policy"> Privacy and Data Protection Policy.</a> 
  </p>
<div class="clearfix">
<p>&nbsp;</p>
</div>
<button type="submit" class="btn btn-warning">Request  Quote</button>
                          </div>
    </form>
                     
                </div>
              </div>
                </div>
              </div>
              
            </section>
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
                <button class="btn btn-sm btn-default delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
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