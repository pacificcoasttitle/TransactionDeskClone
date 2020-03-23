
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
              <?php include "ext-menu.php"; ?>
                <?php if ($uri==''): ?>
                  <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a href="javascript:;">All Books</a></li>
                </ol>
                <?php else: ?>
                  <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a href="javascript:;">Speciality Books</a></li>
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
                   <h3 class="panel-title"><?=$uri?> Books</h3><hr>
                    
                  <?php else: ?>
                   <h3 class="panel-title"><?=$uri?> Books</h3><hr>
                    

                  <?php endif ?>
                                
                  <?php foreach ($books as $key): ?>
                    
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
                     
                      <div class="row ">
                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 ">
                          <div class="row">
                            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 pull-down"><img class="img-responsive" src="<?=base_url()?>assets/front/images/book.jpg"></div>
                            <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 pull-down">
                              <a href="<?=base_url()?>view-book/<?=$key->bookid?>" class="article-title-main"><?=$key->book_title?></a>
                              <p class="no-margin"><b>Author : <?=$key->author?></b></p>
                              <p class="no-margin"><?=$key->designation?></p>
                              <p class=""><b>Price:</b> $<?=$key->price?></p>
                               
                         <a class="btn btn-default btn-xs" href="<?=base_url()?>view-book/<?=$key->bookid?>">Book Detail</a>
                           <a class="btn btn-default btn-xs" href="<?=base_url()?>get-access-book/<?=$key->bookid?>">Get Access</a>
                           <a class="btn btn-default btn-xs" href="<?=base_url()?>buy-book/<?=$key->bookid?>">Buy this book</a>
                       
                            </div>
                          </div>
                        </div>
                      
                      </div>
                     <hr>
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
</script>