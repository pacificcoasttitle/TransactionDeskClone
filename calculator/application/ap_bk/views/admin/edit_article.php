            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Article
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_url()?>admin/article">Article List</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                     <h3 class="box-title">View Article Details</h3> 
                                </div>
                               
                                     
                                    
                                </div>
                                   
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                             
                                    <div class="row">
                                     <form action="" class="form col-lg-6 col-md-offset-3" method="POST" role="form" enctype="multipart/form-data">
                                       <legend>Edit Article <span class="text-info pull-right">* (Required Fields)</span></legend>
                                        <ul class="nav nav-tabs">
                                          <li id="tab1default_li" class="active"><a href="#tab1default" data-toggle="tab">Article Details</a></li>
                                          <li id="tab3default_li" ><a href="#tab3default" data-toggle="tab">Other Contributers</a></li>
                                          <li id="tab2default_li" ><a href="#tab2default" data-toggle="tab">Uploaded Documents</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane fade in active" id="tab1default">
                                           <div class="form-group">
                                           <label for="">User :<span class="text-danger">*</span></label>
                                           <select name="userid" id="inputSubject" class="form-control" required="">
                                              <option value="">-- Select One --</option>
                                              <?php foreach ($users as $key): ?>
                                                <?php if ($key->status == 1): ?>
                                                <option <?=($article_detail->userid == $key->userid )?'selected="true"':NULL?> value="<?=$key->userid;?>"><?=$key->fname;?> <?=$key->lname;?></option>
                                                  
                                                <?php endif ?>
                                              <?php endforeach ?>
                                            </select>
                                       </div>
                                          <div class="form-group">
                                           <label for="">Status :<span class="text-danger">*</span></label>
                                           <input type="text"  class="form-control" id="" value = "<?=$article_detail->worktype?>" name="worktype"  >
                                       </div>
                                       <div class="form-group">
                                           <label for="">Title :<span class="text-danger">*</span></label>
                                           <input type="text"  class="form-control" id="" value = "<?=$article_detail->title?>" name="title"  >
                                       </div>
                                        <div class="form-group">
                                           <label for="">First Author :<span class="text-danger">*</span> </label>
                                             <input type="text"  class="form-control" id="" value = "<?=$article_detail->author?>" name="author"  >
                                       </div>
                                        
                                      <div class="form-group">
                                           <label for="">Other Authors'  :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->othercontributors;?>" name="othercontributors"  >
                                           
                                       </div>
                                        <div class="form-group">
                                           <label for="">Speciality :<span class="text-danger">*</span></label>
                                           <select name="subject" id="inputSubject" class="form-control" required="">
                                              <option value="">-- Select One --</option>
                                              <?php foreach ($departments as $key): ?>
                                                <option <?=($article_detail->subject == $key->departmentname )?'selected="true"':NULL?> ><?=$key->departmentname?></option>
                                              <?php endforeach ?>
                                            </select>
                                       </div>

                                       <div class="form-group">
                                           <label for="">Description :<span class="text-danger">*</span></label>
                                          <textarea  class="form-control"> <?=$article_detail->description;?></textarea>
                                           
                                       </div>
                                        <div class="form-group">
                                           <label for="">Author email    :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->authoremail;?>" name="authoremail"  >
                                           
                                       </div>
                                       <?php if ($article_detail->worktype == "Published" || $article_detail->worktype == "Accepted" || $article_detail->worktype == "In Review"): ?>
                                       <div class="form-group">
                                           <label for="">Type  :<span class="text-danger">*</span></label>
                                         <select name="type" class="form-control" required="">
                                          <option value= ""> -- Select -- </option>
                                         <option <?=($article_detail->type == 'Method Development')?'selected="true"':NULL?>>Method Development </option>
                                        <option <?=($article_detail->type == 'Analytical measurement procedure')?'selected="true"':NULL?>>Analytical measurement procedure </option>
                                        <option <?=($article_detail->type == 'Imaging procedure')?'selected="true"':NULL?>>Imaging procedure </option>
                                        <option <?=($article_detail->type == 'Biometric procedure')?'selected="true"':NULL?>>Biometric procedure </option>
                                        <option <?=($article_detail->type == 'Test development assessment procedure')?'selected="true"':NULL?>>Test development assessment procedure </option>
                                        <option <?=($article_detail->type == 'Animal study' )?'selected="true"':NULL?>>Animal study</option>
                                        <option <?=($article_detail->type == 'Cell Study' )?'selected="true"':NULL?>>Cell Study</option>
                                        <option <?=($article_detail->type == 'Genetic engineering/Gene sequencing')?'selected="true"':NULL?>>Genetic engineering/Gene sequencing </option>
                                        <option <?=($article_detail->type == 'Biochemistry' )?'selected="true"':NULL?>>Biochemistry</option>
                                        <option <?=($article_detail->type == 'Material development')?'selected="true"':NULL?>>Material development </option>
                                        <option <?=($article_detail->type == 'Genetic studies')?'selected="true"':NULL?>>Genetic studies </option>
                                        <option <?=($article_detail->type == 'Clinical study')?'selected="true"':NULL?>>Clinical study </option>
                                        <option <?=($article_detail->type == 'Therapy study' )?'selected="true"':NULL?>>Therapy study</option>
                                        <option <?=($article_detail->type == 'Prognostic study' )?'selected="true"':NULL?>>Prognostic study</option>
                                        <option <?=($article_detail->type == 'Diagnostic study')?'selected="true"':NULL?>>Diagnostic study </option>
                                        <option <?=($article_detail->type == 'Observational study')?'selected="true"':NULL?>>Observational study </option>
                                        <option <?=($article_detail->type == 'Secondary data analysis')?'selected="true"':NULL?>>Secondary data analysis </option>
                                        <option <?=($article_detail->type == 'Case series')?'selected="true"':NULL?>>Case series </option>
                                        <option <?=($article_detail->type == 'Single case reports')?'selected="true"':NULL?>>Single case reports </option>
                                        <option <?=($article_detail->type == 'Intervention study' )?'selected="true"':NULL?>>Intervention study</option>
                                        <option <?=($article_detail->type == 'Cohort study')?'selected="true"':NULL?>>Cohort study </option>
                                        <option <?=($article_detail->type == 'Case control study')?'selected="true"':NULL?>>Case control study </option>
                                        <option <?=($article_detail->type == 'Cross-sectional study' )?'selected="true"':NULL?>>Cross-sectional study</option>
                                        <option <?=($article_detail->type == 'Ecological study')?'selected="true"':NULL?>>Ecological study </option>
                                        <option <?=($article_detail->type == 'Monitoring surveillance')?'selected="true"':NULL?>>Monitoring surveillance </option>
                                        <option <?=($article_detail->type == 'Description with registry data')?'selected="true"':NULL?>>Description with registry data </option>
                                        <option <?=($article_detail->type == 'Meta-analysis')?'selected="true"':NULL?>>Meta-analysis </option>
                                        <option <?=($article_detail->type == 'Review' )?'selected="true"':NULL?>>Review</option>
                        </select>
                                           
                                       </div> 
                                       <div class="form-group">
                                           <label for="">How to Cite  :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->cite;?>" name="cite"  >
                                           
                                       </div>
                                       <?php endif ?>
                                        <div class="form-group">
                                           <label for="">Keywords :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->keyword;?>" name="keyword"  >
                                          
                                       </div> 

                                       <?php if ($article_detail->worktype == "Published"): ?>
                                       <div class="form-group">
                                           <label for="">Date Published :<span class="text-danger">*</span></label>
                                           <input type="text"  class="form-control" id="datepicker" value = "<?=$article_detail->rdate?>" name="rdate"  >
                                           
                                       </div>
                                        <?php else: ?>
                                          <div class="form-group">
                                           <label for="">Date Submitted :<span class="text-danger">*</span></label>
                                           <input type="text"  class="form-control" id="datepicker" value = "<?=$article_detail->rdate?>" name="rdate"  >
                                           
                                       </div>
                                        <?php endif ?>
                                         <div class="form-group">
                                           <label for="">Identifier DOI  :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->doi;?>" name="doi"  >
                                           
                                       </div>
                                        
                                         <?php if ($article_detail->worktype == "Published" || $article_detail->worktype == "Accepted" || $article_detail->worktype == "In Review"): ?>
                                    <div class="form-group">
                                           <label for="">Identifier PMID/PMCID  :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->pmid;?>" name="pmid"  >
                                           
                                       </div>  <div class="form-group">
                                           <label for="">Upload Link  :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->upload_link;?>" name="upload_link"  >
                                           
                                       </div>
                                        <div class="form-group">
                                           <label for="">Publisher  :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->publisher;?>" name="publisher"  >
                                           
                                       </div>
                                        <?php endif ?>
                                       <div class="form-group">
                                           <label for="">Copyrights :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->rights;?>" name="rights"  >
                                           
                                       </div>

                                     <div class="form-group">
                                           <label for="">Community :<span class="text-danger">*</span></label>
                                           <select name="community" required="" id="de" class="form-control">  
                            <option  <?=($article_detail->community == 'Articles' )?'selected="true"':NULL?>>Articles</option>
                            <option <?=($article_detail->community == 'Clinical Cases' )?'selected="true"':NULL?>>Clinical Cases</option>
<option <?=($article_detail->community == 'Multimedia' )?'selected="true"':NULL?>>Multimedia</option>
<option <?=($article_detail->community == 'Media Stories' )?'selected="true"':NULL?>>Media Stories</option>
<option <?=($article_detail->community == 'Patient Education' )?'selected="true"':NULL?>>Patient Education</option>

                        </select>
                                       </div>

                                     <?php if ($article_detail->worktype == "Others"): ?>
                                       <div class="form-group">
                                           <label for="">Category :<span class="text-danger">*</span></label>
                                         <select name="other_category" id="inputOther-Category" class="form-control" required="">
                                          <option value="">-- Select One --</option>
                                          <option <?=($article_detail->other_category == 'Announcements' )?'selected="true"':NULL?>>Announcements</option>
                                          <option <?=($article_detail->other_category == 'Annuals' )?'selected="true"':NULL?>>Annuals</option>
                                          <option <?=($article_detail->other_category == 'Bibliographies' )?'selected="true"':NULL?>>Bibliographies</option>
                                          <option <?=($article_detail->other_category == 'Blogs' )?'selected="true"':NULL?>>Blogs</option>
                                          <option <?=($article_detail->other_category == 'Booklets' )?'selected="true"':NULL?>>Booklets</option>
                                          <option <?=($article_detail->other_category == 'Brochures' )?'selected="true"':NULL?>>Brochures</option>
                                          <option <?=($article_detail->other_category == 'Bulletins')?'selected="true"':NULL?>>Bulletins </option>
                                          <option <?=($article_detail->other_category == 'Call for Papers' )?'selected="true"':NULL?>>Call for Papers</option>
                                          <option <?=($article_detail->other_category == 'Case Studies' )?'selected="true"':NULL?>>Case Studies</option>
                                          <option <?=($article_detail->other_category == 'Catalogues' )?'selected="true"':NULL?>>Catalogues</option>
                                          <option <?=($article_detail->other_category == 'Chronicles' )?'selected="true"':NULL?>>Chronicles</option>
                                          <option <?=($article_detail->other_category == 'Conference Papers' )?'selected="true"':NULL?>>Conference Papers</option>
                                          <option <?=($article_detail->other_category == 'Conference Posters' )?'selected="true"':NULL?>>Conference Posters</option>
                                          <option <?=($article_detail->other_category == 'Conference Proceedings' )?'selected="true"':NULL?>>Conference Proceedings</option>
                                          <option <?=($article_detail->other_category == 'Course Material' )?'selected="true"':NULL?>>Course Material</option>
                                          <option <?=($article_detail->other_category == 'Databases' )?'selected="true"':NULL?>>Databases</option>
                                          <option <?=($article_detail->other_category == 'Datasets' )?'selected="true"':NULL?>>Datasets</option>
                                          <option <?=($article_detail->other_category == 'Datasheets' )?'selected="true"':NULL?>>Datasheets</option>
                                          <option <?=($article_detail->other_category == 'Deposited Papers' )?'selected="true"':NULL?>>Deposited Papers</option>
                                          <option <?=($article_detail->other_category == 'Directories' )?'selected="true"':NULL?>>Directories</option>
                                          <option <?=($article_detail->other_category == 'Dissertations' )?'selected="true"':NULL?>>Dissertations</option>
                                          <option <?=($article_detail->other_category == 'Doctoral Theses')?'selected="true"':NULL?>>Doctoral Theses </option>
                                          <option <?=($article_detail->other_category == 'E-Prints' )?'selected="true"':NULL?>>E-Prints</option>
                                          <option <?=($article_detail->other_category == 'E-texts' )?'selected="true"':NULL?>>E-texts</option>
                                          <option <?=($article_detail->other_category == 'Essays' )?'selected="true"':NULL?>>Essays</option>
                                          <option <?=($article_detail->other_category == 'Fact Sheets' )?'selected="true"':NULL?>>Fact Sheets</option>
                                          <option <?=($article_detail->other_category == 'Feasibility Studies' )?'selected="true"':NULL?>>Feasibility Studies</option>
                                          <option <?=($article_detail->other_category == 'Flyers' )?'selected="true"':NULL?>>Flyers</option>
                                          <option <?=($article_detail->other_category == 'Folders')?'selected="true"':NULL?>>Folders </option>
                                          <option <?=($article_detail->other_category == 'Glossaries' )?'selected="true"':NULL?>>Glossaries</option>
                                          <option <?=($article_detail->other_category == 'Government Documents' )?'selected="true"':NULL?>>Government Documents</option>
                                          <option <?=($article_detail->other_category == 'Guidebooks')?'selected="true"':NULL?>>Guidebooks </option>
                                          <option <?=($article_detail->other_category == 'Handbooks' )?'selected="true"':NULL?>>Handbooks</option>
                                          <option <?=($article_detail->other_category == 'House Journals')?'selected="true"':NULL?>>House Journals </option>
                                          <option <?=($article_detail->other_category == 'Image Directories' )?'selected="true"':NULL?>>Image Directories</option>
                                          <option <?=($article_detail->other_category == 'Inaugural Lectures' )?'selected="true"':NULL?>>Inaugural Lectures</option>
                                          <option <?=($article_detail->other_category == 'Internet Reviews' )?'selected="true"':NULL?>>Internet Reviews</option>
                                          <option <?=($article_detail->other_category == 'Interviews')?'selected="true"':NULL?>>Interviews </option>
                                          <option <?=($article_detail->other_category == 'Grey Journals' )?'selected="true"':NULL?>>Grey Journals</option>
                                          <option <?=($article_detail->other_category == 'In-house Journals' )?'selected="true"':NULL?>>In-house Journals</option>
                                          <option <?=($article_detail->other_category == 'Journal Articles' )?'selected="true"':NULL?>>Journal Articles</option>
                                          <option <?=($article_detail->other_category == 'Non-commercial Journals' )?'selected="true"':NULL?>>Non-commercial Journals</option>
                                          <option <?=($article_detail->other_category == 'Synopsis Journals')?'selected="true"':NULL?>>Synopsis Journals </option>
                                          <option <?=($article_detail->other_category == 'Leaflets' )?'selected="true"':NULL?>>Leaflets</option>
                                          <option <?=($article_detail->other_category == 'Lectures' )?'selected="true"':NULL?>>Lectures</option>
                                          <option <?=($article_detail->other_category == 'Manuals' )?'selected="true"':NULL?>>Manuals</option>
                                          <option <?=($article_detail->other_category == 'Memoranda')?'selected="true"':NULL?>>Memoranda </option>
                                          <option <?=($article_detail->other_category == 'Orations' )?'selected="true"':NULL?>>Orations</option>
                                          <option <?=($article_detail->other_category == 'Off-prints' )?'selected="true"':NULL?>>Off-prints</option>
                                          <option <?=($article_detail->other_category == 'Pamphlets' )?'selected="true"':NULL?>>Pamphlets</option>
                                          <option <?=($article_detail->other_category == 'Papers' )?'selected="true"':NULL?>>Papers</option>
                                          <option <?=($article_detail->other_category == 'Patents' )?'selected="true"':NULL?>>Patents</option>
                                          <option <?=($article_detail->other_category == 'Policy Documents' )?'selected="true"':NULL?>>Policy Documents</option>
                                          <option <?=($article_detail->other_category == 'Policy Statements' )?'selected="true"':NULL?>>Policy Statements</option>
                                          <option <?=($article_detail->other_category == 'Posters' )?'selected="true"':NULL?>>Posters</option>
                                          <option <?=($article_detail->other_category == 'Preprints' )?'selected="true"':NULL?>>Preprints</option>
                                          <option <?=($article_detail->other_category == 'Press Releases' )?'selected="true"':NULL?>>Press Releases</option>
                                          <option <?=($article_detail->other_category == 'Proceedings' )?'selected="true"':NULL?>>Proceedings</option>
                                          <option <?=($article_detail->other_category == 'Programs')?'selected="true"':NULL?>>Programs </option>
                                          <option <?=($article_detail->other_category == 'Questionnaires')?'selected="true"':NULL?>>Questionnaires </option>
                                          <option <?=($article_detail->other_category == 'Reprints' )?'selected="true"':NULL?>>Reprints</option>
                                          <option <?=($article_detail->other_category == 'Research Notes' )?'selected="true"':NULL?>>Research Notes</option>
                                          <option <?=($article_detail->other_category == 'Research Proposals' )?'selected="true"':NULL?>>Research Proposals</option>
                                          <option <?=($article_detail->other_category == 'Research Registers' )?'selected="true"':NULL?>>Research Registers</option>
                                          <option <?=($article_detail->other_category == 'Research Reports' )?'selected="true"':NULL?>>Research Reports</option>
                                          <option <?=($article_detail->other_category == 'Reviews' )?'selected="true"':NULL?>>Reviews</option>
                                          <option <?=($article_detail->other_category == 'Risk Analyses')?'selected="true"':NULL?>>Risk Analyses </option>
                                          <option <?=($article_detail->other_category == 'Website Reviews' )?'selected="true"':NULL?>>Website Reviews</option>
                                          <option <?=($article_detail->other_category == 'WebPages' )?'selected="true"':NULL?>>WebPages</option>
                                          <option <?=($article_detail->other_category == 'Websites' )?'selected="true"':NULL?>>Websites</option>
                                          <option <?=($article_detail->other_category == 'White Books' )?'selected="true"':NULL?>>White Books</option>
                                          <option <?=($article_detail->other_category == 'White Papers' )?'selected="true"':NULL?>>White Papers</option>
                                          <option <?=($article_detail->other_category == 'Working Documents' )?'selected="true"':NULL?>>Working Documents</option>
                                          <option <?=($article_detail->other_category == 'Working Papers')?'selected="true"':NULL?>>Working Papers </option>
                                          <option <?=($article_detail->other_category == 'Yearbooks' )?'selected="true"':NULL?>>Yearbooks</option>
                                          <option <?=($article_detail->other_category == 'OTHERS' )?'selected="true"':NULL?>>OTHERS</option>
                </select>
                                           
                                       </div>
                                       
                                        <?php endif ?>
                                      
                                     

                                      

                                       
                                         <div class="form-group">
                                           <label for="">Journal/Volume/Issue/Date  :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->journal;?>" name="journal"  >
                                           
                                       </div>
                                     
                                          <?php if ($article_detail->worktype == "Published" || $article_detail->worktype == "Accepted" || $article_detail->worktype == "In Review"): ?>
                                       <div class="form-group">
                                           <label for="">Embargo date (Under Embargo until)    :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->embargodate;?>" name="embargodate"  >
                                           
                                       </div>
                                          <?php endif ?>
                                      <div class="form-group">
                                           <label for="">Article Price    :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id="" value = "<?=$article_detail->payment;?>" name="payment"  >
                                           
                                       </div>

                                      <div class="form-group">
                                           <label for="">Article Download Price    :<span class="text-danger">*</span></label>
                                         <input type="text"  class="form-control" id=""  value = "<?=$article_detail->downloadpayment;?>" name="downloadpayment"  >
                                           
                                       </div>
                                        <?php if ($article_detail->worktype == "Published" || $article_detail->worktype == "Accepted" || $article_detail->worktype == "In Review"): ?>
                                      <div class="form-group">
                                           <label for="">Article Link :</label>
                                         <input type="text"  class="form-control" id=""  value = "<?=$article_detail->upload_link;?>" name="upload_link"  >
                                           
                                       </div>
                                          <?php endif ?>
                                      </div>
                                   <!--  Tab 1 end -->
                                      <div class="tab-pane fade " id="tab2default">
                                      <div class="row">
                                          <?php foreach ($article_doc as $key): ?>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                             <label><?=$key->filename?></label> <a type="button" class="btn btn-default" target="_blank" href="<?=base_url()?>index.php/admin/download_article/<?=$key->uploadid?>" ><i class="fa fa-file-pdf-o"></i> Download</a>
                                            </div>
                                        
                                      <?php endforeach ?>
                                      <?php if ($article_detail->xml_doc != ""): ?>
                                           <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                             <label><?=$article_detail->xml_doc?></label> <a type="button" class="btn btn-default" target="_blank" href="<?=base_url()?>index.php/admin/download_xml/<?=$article_detail->articleid?>" ><i class="fa fa-file-pdf-o"></i> Download</a>
                                            </div>
                                      <?php endif ?>
                                      </div>
                                     
                                      <legend>Upload Document</legend>
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          <div class="form-group">
                                           <label for="">Upload One file for download : </label>
                                              <input class="btn btn-default" type="file" name="userfile"  > 
                                      
                                  
                                     </div>
                                        </div>
                                         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                              <div class="form-group">
                                           <label for="">Upload Screenshot of uploaded file : </label>
                                              <input class="btn btn-default" type="file" name="userfile2"  > 
                                      
                                  
                                     </div>
                                          </div>
                                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                              <div class="form-group">
                                           <label for="">Upload XML of uploaded file : </label>
                                              <input class="btn btn-default" type="file" name="userfile3"  > 
                                      
                                  
                                     </div>
                                          </div>
                                      </div>
                                     
                                   
                                    <!--  Tab 2 end -->
                                  
                                    </div>
                                    <div class="tab-pane fade" id="tab3default">
                                       <legend>Other Contributers</legend>

                                        <?php 
                                         $othercontributors = $this->admin_model->get_contributers($article_detail->articleid);

                                        ?>
                                <div id="box_contri1">
                                        <?php foreach ($othercontributors as $key):  ?>
                                          <div class="clone"><input type="text" value="<?=$key->author_name?>" name = "contri_name[]" placeholder="Enter Name"  required="required"  class="form-control"><div class="input-group"><input type="email" name = "contri_email[]" value="<?=$key->author_email?>" placeholder="Enter Email ID"  required="required"  class="form-control"> <div style="cursor:pointer;" onclick="remove_contri(this)" class="input-group-addon"><i class="fa fa-times"></i></div></div><small>&nbsp;</small></div>
                            
                                        <?php endforeach ?>
                                </div>
                              <button onclick="add_contributers(1)" type="button"  class="btn pull-right btn-primary btn-sm"><i class="fa fa-plus" ></i> Add Contributers</button>
                            
                                    </div>
                                     <!--  Tab 3 end -->
                                       <button type="submit" class="btn btn-primary">Submit</button>
                                   </form>
                                </div>
                              
                                
                                  
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content"> <form action="<?=base_url()?>admin/add_news" method="POST" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">News</h4>
            </div>
            <div class="modal-body">
               
                    <legend>Add News</legend>
                
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="text" name = "date_news" class="form-control" id="datepicker" placeholder="Input Date">
                    </div>

                    <div class="form-group">
                        <label for="">News Heading</label>
                        <input type="text" name = "news_heading" class="form-control" placeholder="Insert News Title">
                    </div>

                    <div class="form-group">
                        <label for="">Heading Link</label>
                        <input type="text" name = "news_link" class="form-control" placeholder="Insert News Title">
                    </div>

                    <div class="form-group">
                        <label for="">Image</label>
                        <input type="file" name = "user_file" >
                    </div>

                     <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control ckeditor"></textarea>
                    </div>
                    
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div> 
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
  
  function add_contributers (id) 
{
  $("#box_contri"+id).append('<div class="clone"><input type="text" name = "contri_name[]" placeholder="Enter Name"  required="required"  class="form-control"><div class="input-group"><input type="email" name = "contri_email[]"  placeholder="Enter Email ID"  required="required"  class="form-control"> <div style="cursor:pointer;" onclick="remove_contri(this)" class="input-group-addon"><i class="fa fa-times"></i></div></div><small>&nbsp;</small></div>');
}

function remove_contri (cross) 
{
  var parentRow = $(cross).closest('div .clone');
  $(parentRow).remove();
}
</script>


    </body>
</html>
   </body>
</html>
