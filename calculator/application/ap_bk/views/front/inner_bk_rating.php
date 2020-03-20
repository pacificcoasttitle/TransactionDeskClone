
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
              <?php include "ext-menu.php"; ?>
                
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li><a href="javascript:;">Speciality</a></li>
                <li><a href="javascript:;">Medical</a></li>
                <li class="active">Nephrology</li>
              </ol>
              <div class="clearfix"></div>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-3 pro-nav">
                  <div class="panel panel-default flat sidebar-flat inner-sidebar">
                    <div class="panel-body"><a href="javascript:;" class="btn btn-success btn-block">NEPHROLOGY</a>
                    <div class="clearfix">
                      <p></p>
                    </div>
                    <div class="sidebar-cont">
                      <div class="col-head">
                        <h5 class="sidebar-category"><a  data-toggle="collapse" href="#one" aria-expanded="false" aria-controls="one"><i class="icon-plus icon-minus"></i> Investigation of Renal Disease</a></h3>
                      </div>
                      <div class="sidebar-body  collapse in" id="one">
                        <ul class="nav sidebar-nav">
                          <li><a href="javascript:;">Assessment of Renal Function (24)</a></li>
                          <li><a href="javascript:;">Urinalysis</a></li>
                          <li><a href="javascript:;">Imaging</a></li>
                          <li><a href="javascript:;">Renal Biopsy</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="sidebar-cont">
                      <div class="col-head">
                        <h5 class="sidebar-category"><a  data-toggle="collapse" href="#two" aria-expanded="false" aria-controls="two"><i class="icon-plus icon-minus"></i> Fluid and Electrolyte Disorders</a></h3>
                      </div>
                      <div class="sidebar-body  collapse in" id="two">
                        <ul class="nav sidebar-nav">
                          <li><a href="javascript:;">Disorders of Extracellular Volume</a></li>
                          <li><a href="javascript:;">Disorders of Water Metabolism</a></li>
                          <li><a href="javascript:;">Disorders of Potassium Metabolism</a></li>
                          <li><a href="javascript:;">Disorders of Calcium, Phosphate, and Magnesium  Metabolism</a></li>
                          <li><a href="javascript:;">Metabolic Acidosis</a></li>
                          <li><a href="javascript:;">Metabolic Alkalosis</a></li>
                          <li><a href="javascript:;">Respiratory Acidosis, Respiratory Alkalosis, and Mixed  Disorders</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="sidebar-cont">
                      <div class="col-head">
                        <h5 class="sidebar-category"><a  data-toggle="collapse" href="#three" aria-expanded="false" aria-controls="three"><i class="icon-plus icon-minus"></i> Acute Renal Failure</a></h3>
                      </div>
                      <div class="sidebar-body  collapse in" id="three">
                        <ul class="nav sidebar-nav">
                          <li><a href="javascript:;">Acute Kidney Injury</a></li>
                          <li><a href="javascript:;">Hepatorenal Syndrome</a></li>
                          <li><a href="javascript:;">Rhabdomyolysis</a></li>
                          <li><a href="javascript:;">Contrast-inducced nephropathy</a></li>
                          <li><a href="javascript:;">Tumor Lysis Syndrome</a></li>
                          <li><a href="javascript:;">Acute renal failure from Thereupeutic agents</a></li>
                          <li><a href="javascript:;">NSAIDs and the Kidney: Acute renal failure</a></li>
                          <li><a href="javascript:;">Obstructive uropathy</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9 pro-content">
                <div class="panel panel-default flat">
                  <div class="panel-body article-container" id="article-sction" >
                  <?php foreach ($articles as $key): ?>
                    
                  <?php 
                            $art_det = $this->welcome_model->get_article_rating($key->articleid);
                            if($art_det)
                            {
                              $a = $art_det->rating/$art_det->total_review;
                                                                     $f = round($a);
                                                                     // echo $f;
                            }
                            else
                            {
                                $f =0;
                            }

                                                                      $star = "";
          for($i=1;$i<=5;$i++)
                            {
                              if($i <= $f)
                              {
                                $star .="<li><a ><i class='icon icon-star '></i></a></li>";
                              }
                              else
                              {
                                $star .="<li><a ><i class='icon icon-star-empty '></i></a></li>";
                              }
                            }
                          ?> 
                  <!-- article start -->
                    <article class="article-list">
                      <section class="clearfix hr">
                       <ul class="pull-down nav navbar-nav nav-star pull-right"> <?php echo $star;?></ul>
                          <a href="<?=base_url()?>view-user/<?=$key->slug?>" class="thumbnail pull-left" style="display:none;"><img src="<?=base_url()?>upload/user/<?=$key->userid?>/<?=$key->profilepic?>"   onerror="this.src ='<?=base_url()?>assets/front/images/user-img.png'"></a>
                          <a href="javascript:;" class="article-title-main"><?=$key->title?></a>
                            
                          </section>
                      <div class="row ">
                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 article-line">
                          <p><a href="<?=base_url()?>view-user/<?=$key->slug?>"><?=$key->salutation?> <?=$key->author?>,</a> <?=$key->othercontributors?>.</p>
                          <p><b>Published:</b> <?=$key->journal?></p>
                          <p><b>Category:</b> <?=$key->type?> <b>Posted:</b> <?=$key->rdate?></p>
                          <p><b>DOI: </b><a href="http://dx.doi.org/<?=$key->doi?>"><?=$key->doi?></a></p>
                          <!-- <p><b>PERMALINK:</b><i><a href="javascript:;">http://myreposit.com/index.php/get-article-info/<?=$key->articleid?></a></i></p> -->
                          <div class="clearfix article-down-links" >
                           <?php $divid = uniqid(); ?>
                          <?php $views_count = $this->user_model->get_views_count($key->articleid);?>
                          <?php $likes_count = $this->user_model->get_article_likes($key->articleid);?>
                          <?php $downloads_count = $this->user_model->get_downlods_count($key->articleid);?>
                          <?php $comment_count = $this->user_model->get_article_comments($key->articleid);?>

                          
                                <a href="javascript:;">View (<?=$views_count?>)</a>|
                                <a href="javascript:;">Likes (<?=$likes_count?>)</a>|
                                <a href="javascript:;">Downloads(<?=$downloads_count?>)</a>|
                                <a onclick = "get_comments('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Comments (<?=$comment_count?>)</a>|
                                <a onclick = "save_article('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Add to wish list</a>
                               
                            <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive pull-right" alt="Image" id="loading<?=$divid?>" style="display:none;">
                           </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 article-line-links">
                          <ul class="article-nav">
                         
                            <li><a onclick = "get_document_info('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Document Info</a></li>
                            <li><a onclick = "get_metrics_info('<?=$key->doi?>','<?=$divid?>')" href="javascript:;">Metrics</a></li>
                            <li><a onclick = "get_similar_articles('<?=$key->articleid?>','<?=$divid?>')" href="javascript:;">Similar Articles</a></li>
<!--                             <li><a href="<?=base_url()?>view-user/<?=$key->slug?>">Author Profile</a></li>
 -->                            <li><a onclick = "rate_article('<?=$divid?>')" href="javascript:;">Rate this Article</a></li>
                          </ul> 
                           <?php if ($key->worktype == "Published"): ?>
                            <?php $file= 'upload/user/'.$key->userid.'/articles/'.$key->document;
                                    $down = base_url().$file;
                                    if($key->document != ""){
                                    ?>
                            <button class="btn btn-default btn-sm  btn-block"><a  href="<?=$down?>">Download</a></button>
                            <?php } elseif($key->upload_link != ""){?>
                               <button class="btn btn-default btn-sm  btn-block"><a href="<?=$key->upload_link?>">Download</a></button>
                            <?php }else{?>
                                 <button class="btn btn-default btn-sm  btn-block"><a disabled href="javascript:;">Download</a></button>  
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
                     

                      
                      <div class="clearfix hr"></div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:5px;">
        <button id = "btn_<?=$divid?>" onclick="hide_div('<?=$divid?>')" type="button" class="btn btn-default btn-sm " style="display:none;"><i class="fa fa-angle-up fa-2x"></i></button>
     
        
            <div id = "<?=$divid?>" class="well well-sm" style="display:none;margin-bottom: 0px; overflow: hidden;margin-top: 5px;"></div>
            <div id = "rating<?=$divid?>" class="well well-sm" style="display:none;margin-bottom: 0px; overflow: hidden;margin-top: 5px;">
                
               
                <div class="row">
                  <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                    <input type="number" name="your_awesome_parameter" id="rating_<?=$divid?>" class="rating" value="0"/>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                     <input type="button"  value="change"  onclick="change_rating('<?=$divid?>','<?=$key->articleid?>')" class="btn btn-primary btn-sm"/>
                  </div>
                </div>
            </div>
          </div>



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
        html += "No Information is available. ";
      }
      else{
        var obj = $.parseJSON(data);
        html += "<h3 class='main-title'>Document metrics</h3><table class='table table-bordered text-center'><tr><th class='col-lg-6 text-center'>Source From</th><th class='col-lg-6 text-center'>Counts</th></tr>";
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
        html +="</table>"
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
        $("#"+divid).html("Article has been saved in your wishlist.");
        $("#"+divid).slideDown();
        $("#btn_"+divid).slideDown();
      }
      if(data=='added')
      {
        $("#loading"+divid).hide();
        $("#"+divid).html("Article has already saved in your wishlist.");
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


function hide_div (divid) 
{
  $("#"+divid).slideUp();
  $("#rating"+divid).slideUp();
  $("#btn_"+divid).slideUp();
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
</script>