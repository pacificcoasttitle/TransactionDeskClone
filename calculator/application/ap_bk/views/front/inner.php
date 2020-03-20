
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
              <?php include "ext-menu.php"; ?>
                <?php if ($uri==''): ?>
                  <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a href="javascript:;">All Articles</a></li>
                </ol>
                <?php else: ?>
                  <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a href="javascript:;">Speciality</a></li>
                    <li class="active"><?=$uri?></li>
                </ol>
                <?php endif ?>
              

              <div class="clearfix"></div>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-3 pro-nav">
                  
                     <?php if ($uri==''): ?>
                  <div class="panel panel-default flat">
                    <div class="my-account-sidebar">
                      
                      <!-- start main side bar tab -->
                      <div class="sidebar-nav">
                         <ul class="cat-nav1">
                           <?php $name = "" ; foreach ($departments as $key):    $name = str_replace(" ", "-", $key->departmentname); ?>
                          <li>
                            <a <?=($name==$uri)?'class="active"':NULL?> href="<?=base_url()?>speciality-articles/<?=$name?>"><i><img src="<?=base_url()?>assets/front/images/icon/<?=$key->departmentname?>.jpg"></i> <?=$key->departmentname?></a>

                          </li>
 
                        <?php endforeach ?>         
                                    
                                    
                        </ul>
                        </div>
                  
                      
                        
                        <!-- end main side bar tab -->
                        
                      </div>
                    </div>
                      <?php else: ?>
                         <div class="panel panel-default flat sidebar-flat inner-sidebar">
                    <div class="panel-body"><a href="javascript:;" class="btn btn-primary btn-block"><?=$uri?></a>
                    <div class="clearfix">
                      <p></p>
                    </div>

                      <?php 
                      $branch = $this->welcome_model->get_sub_departments($uri);
                      
                      foreach ($branch as $brc): ?>
                         <div class="sidebar-cont">
                      <div class="col-head">
                        <h5 class="sidebar-category">
                         <?php  $sb_branch = $this->welcome_model->get_sub_departments($brc->departmentname); ?>
                          <?php if (sizeof($sb_branch)): ?>
                            <a  data-toggle="collapse" href="#brach<?=$brc->departmentid?>" aria-expanded="false" aria-controls="brach<?=$brc->departmentname?>">
                                  <i class="icon-plus icon-minus"></i>
                               <?=$brc->departmentname?></a>
                          <?php else: ?>

                            <a  aria-controls="brach<?=$brc->departmentid?>">
                                <i class="icon-circle" ></i> <?=$brc->departmentname?></a>
                          <?php endif ?>
                            
                        </h5>
                      </div>
                     <?php if (sizeof($sb_branch)):?>
                      <div class="sidebar-body  collapse in" id="brach<?=$brc->departmentid?>">
                        <ul class="nav sidebar-nav">
                        <?php foreach ($sb_branch as $ssb_br): //print_r($ssb_br);?>
                           <li><a href="javascript:;"> <?=$ssb_br->departmentname?>  </a></li>
                        <?php endforeach ?>
                        </ul>
                      </div>
                      <?php endif ?>
                    </div>
                      <?php endforeach ?>
                   
                    
                   
                  </div>
                </div>
                      <?php endif ?>
                         
                     
               
              </div>
              <div class="col-md-9 pro-content">
                <div class="panel panel-default flat">
                  <div class="panel-body article-container" id="article-sction" >
                  <?php if ($uri): ?>
                   <h3 class="panel-title"><?=$uri?> Articles</h3><hr>
                    
                  <?php else: ?>
                   <h3 class="panel-title"><?=$uri?> Articles</h3><hr>
                    

                  <?php endif ?>
                                
                  <?php foreach ($articles as $key): ?>
                    
                 <?php $other_contributors = $this->welcome_model->get_other_contributers($key->articleid);

                  $others = "";
                  foreach ($other_contributors as $oth) 
                  {
                      if($oth->userid)
                      {
                         $others .= ', <a href="'.base_url().'view-user/'.$oth->slug.'">'.$oth->salutation.' '.$oth->author_name.'</a>';
                      }
                      else
                      {
                         $others .= ', '.$oth->author_name;

                      }
                  }

                   // print_r($key);
                 ?>
                  <!-- article start -->
                    <article class="article-list">
                      <section class="clearfix hr">
                          <a href="<?=base_url()?>view-user/<?=$key->slug?>" class="thumbnail pull-left" style="display:none;"><img src="<?=base_url()?>upload/user/<?=$key->userid?>/<?=$key->profilepic?>"   onerror="this.src ='<?=base_url()?>assets/front/images/user-img.png'"></a>
                          <a href="<?=base_url()?>get-article-info/<?=$key->articleid?>" class="article-title-main"><?=$key->title?></a>
                            
                          </section>
                      <div class="row ">
                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 article-line">
                          <p><a href="<?=base_url()?>view-user/<?=$key->slug?>"><?=$key->salutation?> <?=$key->author?></a> <?=$others?>.</p>
                          <p><b>Published:</b> <?=$key->journal?></p>
                          <p><b>Category:</b> <?=$key->type?> <b>Posted:</b> <?=$key->rdate?></p>
                          <p><b>DOI: </b><a href="http://dx.doi.org/<?=$key->doi?>"><?=$key->doi?></a></p>
                          <p><b>PERMALINK:</b><i><a href="<?=base_url()?>get-article-info/<?=$key->articleid?>"><?=base_url()?>get-article-info/<?=$key->articleid?></a></i></p>
                          <div class="clearfix article-down-links" >
                           <?php $divid = uniqid(); ?>
                          <?php $views_count = $this->user_model->get_views_count($key->articleid);?>
                          <?php $likes_count = $this->user_model->get_article_likes($key->articleid);?>
                          <?php $downloads_count = $this->user_model->get_downlods_count($key->articleid);?>
                          <?php $comment_count = $this->user_model->get_article_comments($key->articleid);?>

                          
                                <a href="javascript:;">View (<?=$views_count?>)</a>|
                                <a href="javascript:;">Likes (<?=$likes_count?>)</a>|
                                <a href="javascript:;">Downloads(<?=$downloads_count?>)</a>|
                                <a onclick = "get_comments('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Comments (<?=$comment_count?>)</a>
                                
                               
                            <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive pull-right" alt="Image" id="loading<?=$divid?>" style="display:none;">
                           </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 article-line-links">
                         <a   class="btn btn-default btn-xs  btn-block mar-bottom-5" href="#" target="_blank" >Watch video</a>
                          <ul class="article-nav">
                        
                            <li><a onclick = "get_document_info('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Document Info</a></li>
                            <li><a onclick = "get_metrics_info('<?=$key->doi?>','<?=$divid?>')" href="javascript:;">Metrics</a></li>
                            <li><a onclick = "get_similar_articles('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Similar Articles</a></li>
<!--                             <li><a href="<?=base_url()?>view-user/<?=$key->slug?>">Author Profile</a></li>
 -->                            <li><a onclick = "save_article('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Add to Favourites</a></li>
                          </ul> 
                           <?php if ($key->worktype == "Published" || $key->worktype == "published" ): ?>
                            <?php $file= 'upload/user/'.$key->userid.'/articles/'.$key->document;
                                    $down = base_url().$file;
                                    if($key->document != ""){
                                    ?>
                           <a   class="btn btn-default btn-xs  btn-block" href="<?=$down?>" target="_blank" >Download</a>
                            <?php } elseif($key->upload_link != ""){?>
                              <a class="btn btn-default btn-xs  btn-block" href="<?=$key->upload_link?>" target="_blank">Download</a>
                            <?php }else{?>
                                 <a class="btn btn-default btn-xs  btn-block" disabled href="javascript:;">Download</a>  
                            <?php } ?>
                        <?php endif ?>
<!--                             <li><a onclick = "save_article('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Add to wish list</a></li>
 -->                            <?php $file= 'upload/user/'.$key->userid.'/articles/'.$key->xml_doc;
                                    $down = base_url().$file;
                                    if($key->xml_doc != ""){
                                    ?>
                           <!--  <li><a href="<?=$down?>">Data File</a></li> -->
                            <?php }else{?>
                               <!--   <li><a disabled href="javascript:;">Data File</a></li>   -->
                            <?php } ?>
                          
                        </div>
                      </div>
       <!--  <button id = "btn_<?=$divid?>" onclick="hide_div('<?=$divid?>')" type="button" class="btn btn-default btn-sm " style="display:none;"><i class="fa fa-angle-up fa-2x"></i></button>
      -->
        
            <div id = "<?=$divid?>" class="well well-sm informative" style="display:none;margin-bottom: 5px; overflow: hidden;margin-top: 5px;"></div>
           
        
          <div class="clearfix hr"></div>



                    </article>
                   
                     <!-- article end -->
                   <?php endforeach ?>
                   <ul class="pagination ">
                    <?=$page_links;?>
                  </ul>
                  </div>
                </div>
              </div>
            </div>
          </section>
        
        <div class="modal fade" id="add_comment">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add New Comment</h4>
              </div>
              <div class="modal-body">
                <form action="<?=base_url()?>index.php/user/add_new_comment" method="POST" role="form">
                  <div class="form-group">
                    <label for="">Comment</label>
                    <textarea name="message" id="inputComment" class="form-control" rows="3" required="required"></textarea>
                    <input type="hidden" name="articleid" id="comment_Article_id" class="form-control" value="">
                    <input type="hidden" name="user_email" id="" class="form-control" value="<?=$this->session->userdata('mpuseremail');?>">
                    <input type="hidden" name="user_name" id="1" class="form-control" value="<?=$this->session->userdata('mpusername');?>">
                  </div>
                
                  
                
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
             
            </div>
          </div>
        </div>

        <script>
function get_document_info (article_id,divid) 
{
  $("#loading"+divid).show();
  $.ajax({
    url     : "<?php echo base_url()?>index.php/user/get_document_info/"+article_id,
    type    : "POST",
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    success : function( data )
    {
      $("#loading"+divid).hide();
      $("#"+divid).html(data);
      $("#"+divid).slideDown();
      $("#btn_"+divid).slideDown();

    },
    error   : function( xhr, err )
    {
      $("#loading"+divid).hide();
    alert('Error');
    return false;
    }
    });
}

function get_metrics_info (doi,divid) 
{
   $("#loading"+divid).show();
  $.ajax({
    url     : "<?php echo base_url()?>index.php/welcome/demo?doi="+doi,
    type    : "POST",
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    success : function( data )
    {
      
      var html = "";
      if(data =="Not Found")
      {
        html += "<div class='' style='border:none;'><button type='button' onclick='hide_div(this)' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button><span>No Information  available. </span></div>";
      }
      else{
        var obj = $.parseJSON(data);
        html += "<div class='modal-header'><button type='button' onclick='hide_div(this)' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button><h4 class='modal-title'>Document metrics</h4></div><div class='modal-body'><table class='table table-bordered text-center'><tr><th class='col-lg-6 text-center'>Source From</th><th class='col-lg-6 text-center'>Counts</th></tr>";
        $.each(obj,function(key,val){
             if(key == "cited_by_fbwalls_count")
             {
              html += "<tr><th><i class = 'fa fa-facebook-square'></i> Public Facebook wall posts Count</th> <td>"+val+"</td></tr>"
             }
             if(key == "cited_by_feeds_count")
             {
              html += "<tr><th><i class = 'fa fa-rss-square'></i> Blog posts Count</th> <td> "+val+" </td></tr>"
             }
      if(key == "cited_by_msm_count")
             {
              html += "<tr><th><i class = 'fa fa-newspaper-o'></i> Articles in science news outlets Count</th> <td> "+val+" </td></tr>"
             }
      if(key == "cited_by_posts_count")
             {
              //html += "<tr><th>Any type of post Count</th> <td> "+val+" </td></tr>"
             }
      if(key == "cited_by_tweeters_count")
             {
              html += " <tr><th> <i class = 'fa fa-twitter-square'></i> Messages on Twitter Count</th> <td> "+val+" </td></tr>"
             }
            

          }); 
        html +="</table></div>"
      }
      $("#loading"+divid).hide();
      $("#"+divid).html(html);
      $("#"+divid).slideDown();
      $("#btn_"+divid).slideDown();

    },
    error   : function( xhr, err )
    {
    alert('Error');
    return false;
    }
    });
}


function get_similar_articles (article_id,divid) 
{
   $("#loading"+divid).show();
  $.ajax({
    url     : "<?php echo base_url()?>index.php/user/get_similar_articles/"+article_id,
    type    : "POST",
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    success : function( data )
    {
      $("#loading"+divid).hide();
      $("#"+divid).html(data);
      $("#"+divid).slideDown();
      $("#btn_"+divid).slideDown();

    },
    error   : function( xhr, err )
    {
      $("#loading"+divid).hide();
    alert('Error');
    return false;
    }
    });
}

function get_comments (article_id,divid) 
{
   $("#loading"+divid).show();
  $.ajax({
    url     : "<?php echo base_url()?>index.php/user/get_comments/"+article_id+"/"+divid,
    type    : "POST",
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    success : function( data )
    {
      $("#loading"+divid).hide();
      $("#"+divid).html(data);
      $("#"+divid).slideDown();
      $("#btn_"+divid).slideDown();

    },
    error   : function( xhr, err )
    {
      $("#loading"+divid).hide();
    alert('Error');
    return false;
    }
    });
}

function get_other_titles (argument)
{
  $("#other_title_form").submit();
}
function save_article (article_id,divid) 
{
   $("#loading"+divid).show();
  $.ajax({
    url     : "<?php echo base_url()?>index.php/user/save_article_wishlist/"+article_id,
    type    : "POST",
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    success : function( data )
    {
      if(data=='login')
      {
        window.location.href="<?=base_url()?>index.php/welcome/login"
      }
      if(data=='success')
      {
        $("#loading"+divid).hide();
        $("#"+divid).html("Your Article has been saved. You can access it from your <a class='btn-link' href='<?=base_url()?>dashboard'>Dashboard</a> by clicking on Saved Articles.");
        $("#"+divid).slideDown();
        $("#btn_"+divid).slideDown();
      }
      if(data=='added')
      {
        $("#loading"+divid).hide();
        $("#"+divid).html("Article already saved in your wish list.");
        $("#"+divid).slideDown();
        $("#btn_"+divid).slideDown();
      }
      

    },
    error   : function( xhr, err )
    {
    alert('Error');
    return false;
    }
    });
}


function hide_div (cross) 
{
  // $("#"+divid).slideUp();
  // $("#rating"+divid).slideUp();
  // $("#btn_"+divid).slideUp();

  var parentRow = $(cross).closest('div .informative');
  $(parentRow).slideUp();
}


function rate_article (divid) 
{ 
  $("#rating"+divid).slideDown();
  $("#btn_"+divid).slideDown();
}


function change_rating(divid,articleid){
          var rate = 0;
           rate = $('#rating_'+divid).val(); 
            $.ajax({
                             url     : "<?=base_url()?>index.php/welcome/change_rating/"+rate+"/"+articleid,
                             type    : "POST",
                 success : function( data )
                        { 
                       location.reload();
                                          
                      },
                    error   : function( xhr, err )
                      {
                        alert('Error');
                       
                        return false;    
                      }
        });
            
        }


function add_comment (articleid) 
{
    $("#comment_Article_id").val(articleid);
}


$(document).ready(function($) {
   $('.textarea').wysihtml5({
    toolbar: {
      fa: true
    }
  });
});
</script>