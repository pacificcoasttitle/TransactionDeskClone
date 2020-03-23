<?php 
include 'recaptchalib.php';
$publickey = "6LfjhggTAAAAAJmOuFzVcux_LT2HPbhsmpGQliUo";
$privatekey = "6LfjhggTAAAAAPi_Fo4w_X4NZGrVH_AqaFXM_Roq";
# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;
 ?>

<div class="container">
    <div class="content-wrapper">
        <section id="content">
            <?php include 'ext-menu.php';?>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active">Sign up</li>
            </ol>
            <div class="clearfix">
            </div>
                 <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="panel panel-default flat">
                            <div class="panel-body">
                                <h3 class="text-uppercase panel-title">Sign up</h3>
                                <p>&nbsp;</p>
                                <div class="clearfix">
                                    
                                </div>
                                <form action ='' class="form-horizontal login-form" method="post" onsubmit="return validate()" enctype="multipart/form-data">
  <div class="form-group">
    <label for="inputEmail3" class="control-label">* Salutation:
</label>
    <div class="">
    <select name="salutation" id="input" class="form-control" required="required">
         <option value="">-- Select One --</option>
          <option>Dr.</option>
          <option>Prof.</option>
          <option>Mr.</option>
          <option>Ms.</option>
    </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="control-label">* First name:</label>
    <div class="">
      <input type="text" class="form-control" name = "fname" pattern="^[ a-zA-Z]+$"  id="inputPassword3" placeholder="" required>
    </div>
  </div>

    <div class="form-group">
    <label for="inputPassword3" class="control-label">* Last name:</label>
    <div class="">
      <input type="text" class="form-control" name = "lname" pattern="^[ a-zA-Z]+$" id="inputPassword3" placeholder=""required >
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="control-label">* Designation:</label>
    <div class="">
      <input type="text" class="form-control" id="inputPassword3" pattern="^[ a-zA-Z]+$" name = "designation"  placeholder="" required>
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="control-label"> * Department:</label>
    <div class="">
      <select name="department" id="input" class="form-control" required="required" onchange="check_other_subject('published',this)">
       <option value="">Select</option>
                    <?php foreach ($departments as $department): ?>
                    <option value="<?=$department->departmentid?>"><?=$department->departmentname?></option>
                    <?php endforeach ?>
                    <option value="other">Other</option>
    </select>
     <input  id="other_subject_published" type="text" class="form-control" style="display:none;">
    </div>
  </div>
  
  <div class="form-group">
    <label for="inputPassword3" class="control-label"> * Country:</label>
    <div class="">
      <select  name="country" id="country" class="form-control" required="required">
                    <option value="">Select</option>
                    <?php foreach ($countries as $department): ?>
                    <option value="<?=$department->country_name?>"><?=$department->country_name?></option>
                    <?php endforeach ?>
                  </select>
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="control-label">*  Email:</label>
    <div class="">
      <input type="email" name = "email" class="form-control" id="email" onblur="check_email()" placeholder="" required>
      <div id="output" style="display:none;">
                    <div id="output_div" >
                      <span class = "text-danger" id="output_body"></span>
                    </div>
                  </div>
    </div>

  </div>

  <div class="form-group">
    <label for="inputPassword3" class="control-label">* Password:</label>
    <div class="">
      <input type="password" name = "password" class="form-control" id="password" placeholder="" required>
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="control-label">* Confirm Password:</label>
    <div class="">
      <input type="password" class="form-control" id="password_confirm" placeholder="" required>
       <span class = "text-danger" id="error"></span>
    </div>
  </div>


  
    <div class="form-group">
      <label class="control-label"><swap>* </swap> Your highest level of education ?</label>
      <select name="high_education" id="input" class="form-control" required="required">
        <option value="" class="s">--No answer--</option>
        
        <option >High School</option>
        <option >College-Bachelor of Arts</option>
        <option >College-Bachelor of Fine Arts</option>
        <option >College-Bachelor of Science</option>
        <option >College-Master of Arts</option>
        <option >College-Master of Fine Arts</option>
        <option >College-Master of Science</option>
        <option >College-Master of Business Administration</option>
        <option >College-Doctrate</option>
        <option >Medical Doctor</option>
        <option >Other</option>
      </select>
    </div>
    <div class="form-group">
      <label class="control-label"><swap>* </swap> College or University</label>
      <input type="text" name="college" pattern="^[ a-zA-Z]+$" id="input" class="form-control" required="required">
    </div>
    <div class="form-group">
      <label class="control-label"> Website, Blog or Portfolio</label>
      <input type="url" name="blog_url" id="input" class="form-control" >
    </div>
   <!--  <div class="form-group">
      <label class="control-label"><swap>* </swap>Upload CV/Resume</label><br>
      <input type="file" name="userfile1" id="input"  required="required">                
    </div> -->
   
    
   
  <div class="form-group">
 
    <div class=" col-md-offset-1">
      <?php echo recaptcha_get_html($publickey, $error);?>
       <span class = "text-danger" id="error2"></span>
      </div>

    </div>

<div class="form-group">
 
    <div class=" col-md-offset-1">
     <div class="checkbox">
         <label>
             <input type="checkbox" value="" required>
             This is to confirm that I have read, understood, agree to all the <a data-toggle="modal" href='#modal-id'> Terms of Service</a> mentioned in myreposit.com. I also confirm that I am entering into this agreement voluntarily, with full knowledge of its effect.
         </label>
     </div>

      </div>
      
    </div>




  <div class="form-group l-btn">
    <div class="col-sm-offset-3 ">
      <button type="submit" class="btn btn-primary">Create Account</button>
   
    </div>
  </div>

</form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="panel panel-default flat bg-gray">
                            <div class="panel-body">
                                <h4><b>How is this information used?</b></h4>
                                <hr>
                                <p>Fields in this section are mandatory every time you submit new content. We use your information to populate a pre-fill submission form, which saves the need to fills these fields repeatedly. Your information is also used to inform you on your account and publication status. Usage of your information is governed by our . <a href="<?=base_url()?>privacy-policy"> Privacy and Data Protection Policy.</a>
                            </div>
                        </div>
                    </div>
                </div>

               
        </section>

  <script src="<?=base_url()?>assets/front/js/jquery.min.js"></script>

<script>
  function check_email()
{
var email_id = $("#email").val();
//alert(email_id);
if(email_id == "")
{
$("#output_body").attr("class","text-danger");
$("#output_body").html("please fill email first.!!");
$("#output").show();
$("#email_id").focus();
}
else
{
$("#output_body").html("");
$("#output").hide();
$("#output_div").attr("class","text-danger");
$("#output_body").attr("class","text-danger");
var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if(!regex.test(email_id))
{
$("#output_body").html("INCORRECT EMAIL ID! ");
$("#output").show();
$("#email_id").focus();
return false;
}
$.ajax({
url     : "<?=base_url()?>index.php/welcome/check_availability_email?email="+email_id,
type    : "post",
success : function( data )
{
if(data == 0){
$("#output_body").html("");
$("#output_body").html("This email-id is not available. !!");
$("#output").show();
//$("#button_user").prop("type",'button');
$("#button_user").attr("disabled","disabled");

return false;
}
else
{
$("#output").hide();
$("#output_div").attr("class","text-success");
$("#output_body").attr("class","text-success");
$("#output_body").html("This email-id is available. !!");
$("#output").show();
$("#submit_btn").prop("type",'submit');
$("#button_user").removeAttr("disabled");
return true;
}

},
});
}
}
function validate()
{
$("#error").html("");
$("#error").hide();
$("#error2").hide();

var new1 = $("#password").val();
var new2 = $("#password_confirm").val();
var new3 = $("#recaptcha_response_field").val();
if(new3 == '')
{
 $("#error2").html("Please fill the captcha field.");
 $("#error2").show();
 return false;
}
if(new1 === new2)
{
$("#error").html("");
$("#error").hide();
return true;
}
else{
$("#error").html("Confirm password  is not same.!!");
$("#error").show();
return false;
}

return false;
}

function check_other_subject (type,spc) 
{
  var value = $(spc).val();
  if(value=='other')
  {
    $("#other_subject_"+type).show();
    $("#other_subject_"+type).attr('required','required');
    $("#other_subject_"+type).attr('name','department');
    $("#other_subject_"+type).attr('placeholder','Enter Type of Department.');
    $(spc).removeAttr('name');
  }
  else
  {
    $("#other_subject_"+type).hide();
    $("#other_subject_"+type).removeAttr('required');
    $("#other_subject_"+type).removeAttr('name');
    $(spc).attr('name','department');
  }
}

function check_other_subject (type,spc) 
{
  var value = $(spc).val();
  if(value=='other')
  {
    $("#other_subject_"+type).show();
    $("#other_subject_"+type).attr('required','required');
    $("#other_subject_"+type).attr('name','subject');
    $("#other_subject_"+type).attr('placeholder','Enter Department Name.');
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