
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
               <?php include 'ext-menu.php';?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active"><?=$title?></li>
              </ol>
              <div class="clearfix"></div>
              <div class="panel panel-default flat">
                <div class="panel-body" style="max-height: 930px; overflow-y: scroll;">
                  
                  <h3 class="panel-title"><?=$title?> <?=($count > 0 )?' <span style="font-size:13px;color:#000;text-transform: none;">('.$count.' Article(s) Found )</span>':NULL?></h3>
                  <hr>
                  <?php
            $max_page = ceil($count/$per_page);
           
        ?>
                  <div class="row table-top">
                    
                
                  <form action="<?=base_url()?>search" method="POST" role="form">
            <div class=" margin-top20">
            <?php if (sizeof($specialty_article)): ?>
            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
              <p class="main-article-text1 title-line">Order:</p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
              <select class="form-control" name="order" onchange="this.form.submit()">
                <option <?=($find_array['order'] == 'asc')?'selected="true"':NULL?> value="asc">Ascending</option>
                <option <?=($find_array['order'] == 'desc')?'selected="true"':NULL?> value="desc">Descending</option>
              </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
              <p class="main-article-text1 margin-bottom0 title-line">Display:</p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
              <select class="form-control" name = "page_no" onchange="this.form.submit()">
              <?php for ($i=1; $i <= $max_page ; $i++) {  ?>
                 <option <?=($find_array['page_no'] == $i)?'selected="true"':NULL?>  value="<?=($i-1)*$per_page?>"><?=$i?></option>
            <?php }?>
                
               
              </select>
            </div>
            <?php endif ?>  
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
               <select  name="cat" id="Area1234" class="form-control" >
                            <option ="">Select Category</option>
                            <option <?=($find_array['cat'] == 'subject')?'selected="true"':NULL?>value="subject">Speciality</option>
                            <option <?=($find_array['cat'] == 'author')?'selected="true"':NULL?>value="author">Authors</option>
                            <option <?=($find_array['cat'] == 'title')?'selected="true"':NULL?>value="title">Title</option>
                            <option <?=($find_array['cat'] == 'community')?'selected="true"':NULL?> value="community">Community</option>
                            <option <?=($find_array['cat'] == 'keyword')?'selected="true"':NULL?>value="keyword">Keyword</option>
                            <option <?=($find_array['cat'] == 'year')?'selected="true"':NULL?>value="year">Year</option>
                            <option <?=($find_array['cat'] == 'doi')?'selected="true"':NULL?>value="doi">DOI</option>
                        </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
              <div id="author4" <?=($find_array['cat'] == 'author')?NULL:'style="display:none;"'?> >
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <input type="text" id="name" class="form-control" name="author_name" value = "<?=$find_array['author_name']?>" placeholder="Search by Author Name">
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-green">Go</button>
                  </div>
                </div>
              </div>
              <div id="title4" <?=($find_array['cat'] == 'title')?NULL:'style="display:none;"'?>>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10"> 
                    <input type="text" id="name" class="form-control" value = "<?=$find_array['title_name']?>" name="title_name" placeholder="Search by title">                   
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-green">Go</button>
                  </div>
                </div>
              </div>
              <div id="type4" <?=($find_array['cat'] == 'community')?NULL:'style="display:none;"'?>>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <select class="form-control" name="community_name" onchange="this.form.submit()">
                                 <option <?=($find_array['community_name'] == '')?'selected="true"':NULL?> value="">Search by community</option>
                                <option <?=($find_array['community_name'] == 'Articles')?'selected="true"':NULL?>>Articles</option>
                                <option <?=($find_array['community_name'] == 'Clinical Cases')?'selected="true"':NULL?>>Clinical Cases</option>
                                <option <?=($find_array['community_name'] == 'Multimedia')?'selected="true"':NULL?>>Multimedia</option>
                                <option <?=($find_array['community_name'] == 'Media Stories')?'selected="true"':NULL?>>Media Stories</option>
                                <option <?=($find_array['community_name'] == 'Patient Education')?'selected="true"':NULL?>>Patient Education</option>
                              </select>                   
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-green">Go</button>
                  </div>
                </div>
              </div>
              <div id="keyword4" <?=($find_array['cat'] == 'keyword')?NULL:'style="display:none;"'?>>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <input type="text" id="name" class="form-control" value = "<?=$find_array['keyword_name']?>" name="keyword_name" placeholder="Search by keyword">                   
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-green">Go</button>
                  </div>
                </div>
              </div>
              <div id="year4" <?=($find_array['cat'] == 'year')?NULL:'style="display:none;"'?>>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <input type="text" id="name" class="form-control" value = "<?=$find_array['year_name']?>" name="year_name" placeholder="Search by year">                   
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-green">Go</button>
                  </div>
                </div>
              </div>
              <div id="doi4" <?=($find_array['cat'] == 'doi')?NULL:'style="display:none;"'?>>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <input type="text" id="name" class="form-control" value = "<?=$find_array['doi_name']?>" name="doi_name" placeholder="Search by DOI">                   
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-green">Go</button>
                  </div>
                </div>
              </div>
              <div id="subject4" <?=($find_array['cat'] == 'subject')?NULL:'style="display:none;"'?>>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <select class="form-control" name="subject_name" onchange="this.form.submit()">
                                 <option <?=($find_array['subject_name'] == '')?'selected="true"':NULL?> value="">Search by community</option>
                               <?php foreach ($departments as $key): ?>
                    <option <?=($find_array['subject_name'] == $key->departmentname)?'selected="true"':NULL?>><?=$key->departmentname?></option>
                  <?php endforeach ?>

                              </select>                   
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-green">Go</button>
                  </div>
                </div>
              </div>

            </div>
            </div>
          </form>
            </div>
            <br>
          <?php if (sizeof($specialty_article)): ?>
                  <div class=" table-responsive">
                    <table class="table table-striped table-mix ">
                      <thead>
                        <td class="col-sm-1">Date</td>
                        <td class="col-sm-5">Title</td>
                        <td class="col-sm-2">Author</td>
                        <td class="col-sm-4">Keywords</td>
                      </thead>
                      <tbody>
                       <?php foreach ($specialty_article as $key): ?>
                        <tr>
                          <td>
                            <?=date("F Y",strtotime($key->rdate))?>
                          </td>
                          <td>
                            <a  href="<?=base_url()?>index.php/user/view_article/<?=$key->articleid?>"> <b><?=$key->title?></b></a>
                          </td>
                          <td>
                            <a  href="javascript:;"> <b><?=$key->author?></b></a>
                          </td>
                          <td>
                            <?=$key->keyword?>
                          </td>
                        </tr>
                         <?php endforeach ?>
                      </tbody>
                     </table>
          <!-- end article list -->
          <!-- start pegination -->
            <div class="">
                            <ul class="pagination">
                                <?=$page_links;?>
                            </ul>
                        </div>
                        </div>
          <!-- end pegination -->
          <?php else: ?>
            <br>
            <div class="alert alert-warning">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <span> Article not found. Search again with new criteria.</span>
            </div>
            
          <?php endif ?>
                  
                </div>
              </div>
            </section>
<script src="<?=base_url()?>assets/front/js/jquery.min.js"></script>

           <script type="text/javascript">
$(document).ready(function() {
  $('#author4').hide();
  $('#title4').hide();
  $('#type4').hide();
  $('#keyword4').hide();
  $('#year4').hide();
  $('#doi4').hide();
  $('#subject4').hide();
  $('#depart_select').hide();

var dum = '';
  dum=$('#Area1234 option:selected').text();
  //alert(dum);
  if(dum == 'Authors'){
    $('#author4').show();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'Title'){
    $('#author4').hide();
    $('#title4').show();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'Community'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').show();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'Keyword'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').show();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'Year'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').show();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'DOI'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').show();
    $('#subject4').hide();
  } 

  else if(dum == 'Speciality'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#subject4').show();
  } 
  else if(dum == 'Select Category'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  }



});


$("#Area1234").change(function()
{
  var dum = '';
  dum=$('#Area1234 option:selected').text();
  if(dum == 'Authors'){
    $('#author4').show();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'Title'){
    $('#author4').hide();
    $('#title4').show();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'Community'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').show();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'Keyword'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').show();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } else if(dum == 'Year'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').show();
    $('#doi4').hide();
    $('#subject4').hide();

  } else if(dum == 'DOI'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').show();
    $('#subject4').hide();
  } 
  else if(dum == 'Speciality'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#subject4').show();
  } 
  else if(dum == 'Select Category'){
    $('#author4').hide();
    $('#title4').hide();
    $('#type4').hide();
    $('#keyword4').hide();
    $('#year4').hide();
    $('#doi4').hide();
    $('#subject4').hide();
  } 
  //alert(dum);
  });


           </script>