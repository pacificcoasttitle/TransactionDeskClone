    <link href="<?=base_url()?>assets/front/css/bootstrap3-wysihtml5.min.css" rel="stylesheet">

      <div class="container">
        <div class="content-wrapper">
          <section id="content">
           <?php include 'ext-menu.php';?>
            <ol class="breadcrumb">
              <li><a href="index.html">Home</a></li>
              <li><a href="<?=base_url()?>index.php/user/view_user/<?=$article_info->slug?>"><?=$article_info->fname?> <?=$article_info->lname?> </a></li>
              <li class="active"><?=$article_info->title?></li>
            </ol>

            <h3 class="panel-title-article text-primary"><b><?=$article_info->title?></b></h3>
            <hr>
            <div class="clearfix">
              <div class="row">
                <div class=" col-md-9 col-lg-9">
                <div class="panel-body pad-0">
                  
               
                <?php $divid = uniqid(); ?>
                   <?php $other_contributors = $this->welcome_model->get_other_contributers($article_info->articleid);

                  $others = "";
                  foreach ($other_contributors as $oth) 
                  {
                      if($oth->userid)
                      {
                         $others .= ', <a href="'.base_url().'view-user/'.$oth->slug.'">'.$oth->author_name.'</a>';
                      }
                      else
                      {
                         $others .= ', '.$oth->author_name;

                      }
                  }

                   // print_r($key);
                 ?>
                  <p><b>Authors: </b><?=$article_info->author?><?=$others;?></p>
                  <p><b>Discipline:</b> <?=$article_info->subject?></p>
                  <p><b>Description:</b> <?=$article_info->description?></p>
                  <p></p>
                  <p><b>Keywords:</b> <?=$article_info->keyword?></p>
                  <p><b>Author Email:</b><a href="mailto:<?=$article_info->authoremail?>" > <?=$article_info->authoremail?></a></p>
                 
                  <div id = "<?=$divid?>" style="display:none;">
<p><b>Keywords:</b> <?=$article_info->keyword?></p>

<p><b class="des-text-bold">Category: </b><?=$article_info->type?></p>

<?php if ($article_info->worktype == "Published" ): ?>
  <p><b class="des-text-bold">Date Published:</b> <?=date("F Y",strtotime($article_info->rdate))?></p>
<?php else: ?>
  <p><b class="des-text-bold">Date Submitted:</b> <?=date("F Y",strtotime($article_info->rdate))?></p>
<?php endif ?>

<?php if ($article_info->doi == "" ): ?>
<?php else: ?>
<p><b class="des-text-bold">DOI: </b>
  <a  target="_blank"class = "btn-link" href="http://dx.doi.org/<?=$article_info->doi?>"><?=$article_info->doi?></a></p>
<?php endif ?>
<?php if ($article_info->pmid == "" ): ?>
<?php else: ?>
  <p><b class="des-text-bold">PMID/PMCID: </b> <?=$article_info->pmid?></p>
<?php endif ?>

<p><b class="des-text-bold">Publisher: </b>
  <?=$article_info->publisher?></p>

<p><b class="des-text-bold">Embargo: </b>
  <?=($article_info->embargodate == "0000-00-00" || $article_info->embargodate == "")?'No':date('j F Y',strtotime($article_info->embargodate))?></p>

<p><b>No of Downloads:</b><?php $downlods = $this->user_model->get_downlods_count($article_info->articleid);?>
  <?=$downlods?></p>
  <p><label><b>Views:</b> </label> <span id="article_views_count" style="color: #000;background: #fff;border-radius:0px;" class="badge"></span></p>
<?php $file= 'upload/user/'.$article_info->userid.'/articles/'.$article_info->document;
$down = base_url().$file;
if($article_info->document != ""){
?>
<p><b>Download Link:</b>
  <a class = "btn-link" href="<?=$down?>">  <?=$article_info->title?></a></p>
<?php } elseif($article_info->upload_link != ""){?>
<p><b>Download Link:</b>
  <a target = "_blank" class = "btn-link" href="<?=$article_info->upload_link?>">  <?=$article_info->title?></a></p>
<?php }?>
<div class="clearfix">
<p>&nbsp;</p>
</div>
</div>
           <a href="javascript:;" class="btn btn-success btn-sm" onclick = "get_document_info('<?=$divid?>',this)" >View More</a> &nbsp; <?php $divid2 = uniqid(); ?> <a href="javascript:;" onclick = "get_comment('<?=$divid2?>',this)" class="btn btn-success btn-sm">Post Comment</a>
              <div id = "<?=$divid2?>" style="display:none;"  class="well well-sm ps-script informative">
                  <?php $comments = $this->user_model->get_comments($article_info->articleid); 

                  $re = " ";
    if(sizeof($comments))
    {
      foreach ($comments as $key) 
    {
      $re .= '<li class="list-group-item">
      <div class="row">
        <div class="col-xs-4 col-md-2">
        <img style="width:45px;height:45px;" src="'.base_url().'upload/user/'.$key->userid.'/'.$key->profilepic.'"  onerror=" this.src = \''.base_url().'assets/front/images/doctor.png\'" class=" img-responsive" alt="" /></div>
        <div class="col-xs-8 col-md-10">
          <div>
            <div class="comment-text">
              '.$key->message.'
            </div>
            <div class="mic-info">
              <i class="fa fa-user"></i> '.$key->user_name.' <i class="fa fa-clock-o"></i> '.date("F j, Y, g:i A", strtotime($key->date)).'
            </div>
          </div>
          
          
        </div>
      </div>
    </li>';
    }
    if($this->session->userdata('mpuserid'))
    {
      $add_btn = "<a type='button' onclick = 'add_comment(".$articleid.")' data-toggle='modal' href='#add_comment' class='btn btn-xs btn-default pull-right'>Add Comment</a>";
    }
    else
    {
      $add_btn = "<a  class='btn btn-sm btn-default pull-right' href=".base_url()."login>Add</a>";
    }

    $resp = "<div class='row'><h4 class = 'main-title col-lg-6'>Recent Comments </h4> ".$add_btn."</div><ul class='nav list-group'>".$re."</ul>";
    }
    else
    {
         if($this->session->userdata('mpuserid'))
          {
            $add_btn = "<a type='button' onclick = 'add_comment(".$articleid.")' data-toggle='modal' href='#add_comment' class='btn btn-xs btn-default pull-right'>Add Comment</a>";
          }
          else
          {
            $add_btn = "<a  class='btn btn-sm btn-default pull-right' href=".base_url()."login>Add</a>";
          }
    $resp = "<div class='' style='border:none;'><span>No comments. </span>".$add_btn."</div>";

    }
  
    print $resp;
                  ?>
                </div>
                <form action="<?=base_url()?>index.php/user/post_query/<?=$article_info->articleid?>" method="POST" role="form">

                  <textarea name = "query" class="textarea" placeholder="Enter text ..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px;"></textarea>
                  <!-- editor ends -->
                  <div class="clearfix">
                    <p>&nbsp;</p>
                    <div class="btn-group">
                      <button type="submit" class="btn btn-warning btn-sm">Post Your Query</button>
                      
                    </div>
                  </div>
                  </form>
                </div>
 </div>
                <div class=" col-md-3 col-lg-3 ">
                  
                  <p><img src="<?=base_url()?>upload/user/<?=$article_info->userid?>/articles/<?=$article_info->screenshot?>" class="img-responsive " onerror=" this.src = '<?=base_url()?>assets/front/images/Preview Article.jpg'"></p>
                  <div class="modal fade" id="modal-id">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body ">
            <img src="<?=base_url()?>upload/user/<?=$article_info->userid?>/articles/<?=$article_info->screenshot?>" class=" img-responsive"  onerror=" this.src = '<?=base_url()?>assets/front/images/Preview Article.jpg'">
          </div>
          
          </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
                  <a data-toggle="modal" href='#modal-id' class="btn btn-default btn-block">Preview PDF <img src="<?=base_url()?>assets/front/images/pdf-icon.jpg"></a>
                  <p></p>
                  <?php if ($article_info->xml_doc !=""): ?>
                    <?php $file= 'upload/user/'.$article_info->userid.'/articles/'.$article_info->xml_doc;
                $down = base_url().$file;
                  $ext = pathinfo($file, PATHINFO_EXTENSION);
                  function FileSizeConvert($bytes)
                {
                $bytes = floatval($bytes);
                $arBytes = array(
                0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
                ),
                1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
                ),
                2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
                ),
                3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
                ),
                4 => array(
                "UNIT" => "B",
                "VALUE" => 1
                ),
                );
                foreach($arBytes as $arItem)
                {
                if($bytes >= $arItem["VALUE"])
                {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
                }
                }
                return $result;
                }
                ?>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title">Data File</h3>
                    </div>
                    <div class="panel-body">
                      <p><a href="#"><img src="<?=base_url()?>assets/front/images/file-icon.jpg"></a>  </p>
                      <p><b>File Name :</b><?=substr($article_info->xml_doc,0,30)?><br>
                        <b>Size :</b> <?=FileSizeConvert(filesize($file))?><br>
                        <b>Format :</b> <?=$ext?><br>
                        <br>
                        <a href="<?=$down?>">View Details</a>
                      </p>
                    </div>
                  </div>
                  <?php endif ?>
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <h4 style="font-size:14px" class="panel-title">Other Titles by Authors </h3>
                    </div>
                    <table class="table table-striped table-hover">
                      
                      <tbody>
                        <tr>
                          <td><a  style="cursor:pointer;" onclick="get_other_titles(0)"><?=$article_info->author?></a></td>
                        </tr>
                          <?php foreach ($other_contributors as $other_cont): ?>
                        <tr><td><a  style="cursor:pointer;" onclick="get_other_titles(<?=$other_cont->id;?>)"><?=$other_cont->author_name;?></a></td></tr>
                          <?php endforeach ?>
                      </tr>
                    </tbody>
                  </table>
                  <form id="other_title_form0" action="<?=base_url()?>index.php/welcome/search" method="post">
                  <input type="hidden" name="cat" id="inputCat" class="form-control" value="author">
                  <input type="hidden" name="author_name" id="inputCat" class="form-control" value="<?=$article_info->author;?>">
                </form>

                <?php foreach ($other_contributors as $other_con): ?>
                   <form id="other_title_form<?=$other_con->id?>" action="<?=base_url()?>index.php/welcome/search" method="post">
                  <input type="hidden" name="cat" id="inputCat" class="form-control" value="author">
                  <input type="hidden" name="author_name" id="inputCat" class="form-control" value="<?=$other_con->author_name;?>">
                </form>
                <?php endforeach ?>
                </div>
              </div>
            </div>
            
          </div>
          <div class="clearfix">
          
          </div>
          <div class=" ps-script">
        
             
             
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Similar Articles</h3>
                  </div>
                  <div class="panel-body">
                   <ol class="main-text" style="margin:0px; padding:0px 0 0 25px;word-wrap: break-word;">
                  <?php echo ($similar_articles);?>
                  
                </ol>

                    <p>&nbsp;</p>
                   
                  </div>
                  
                  
                  
                  
                </article>
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
          <script src="<?=base_url()?>assets/front/js/wysihtml5x-toolbar.min.js"></script>
          <script src="<?=base_url()?>assets/front/js/jquery.min.js"></script>
          <script src="<?=base_url()?>assets/front/js/handlebars.runtime.min.js"></script>
          <script src="<?=base_url()?>assets/front/js/bootstrap3-wysihtml5.min.js"></script>
          <script type="text/javascript">
function save_article()
{
$("#paypal1").submit();
}
function get_other_titles (id)
{
  $("#other_title_form"+id).submit();
}
$(document).ready(function (){
get_article_likes(<?=$article_info->articleid?>);
get_article_views(<?=$article_info->articleid?>);
});
function get_article_likes (articleid)
{
$.ajax({
url     : "<?php echo base_url()?>index.php/user/get_article_likes/"+articleid,
type    : "POST",
mimeType: "multipart/form-data",
contentType: false,
cache: false,
processData: false,
success : function( data )
{
//window.location.assign('<?php print base_url()?>index.php/user/activate_article?tx=erp123&st=success&amt=0&cm='+data);
$("#article_likes_count").html(data);
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});
}
function get_article_views (articleid)
{
$.ajax({
url     : "<?php echo base_url()?>index.php/user/get_article_views/"+articleid,
type    : "POST",
mimeType: "multipart/form-data",
contentType: false,
cache: false,
processData: false,
success : function( data )
{
//window.location.assign('<?php print base_url()?>index.php/user/activate_article?tx=erp123&st=success&amt=0&cm='+data);
$("#article_views_count").html(data);
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});
}
function insert_like (articleid)
{
$.ajax({
url     : "<?php echo base_url()?>index.php/user/insert_like/"+articleid,
type    : "POST",
mimeType: "multipart/form-data",
contentType: false,
cache: false,
processData: false,
success : function( data )
{
//window.location.assign('<?php print base_url()?>index.php/user/activate_article?tx=erp123&st=success&amt=0&cm='+data);
$("#article_likes_count").html(data);
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});
}

function get_document_info (divid,btn) 
{
      $("#"+divid).slideToggle();
      $(btn).html("View Less");
      $(btn).attr("onclick","get_document_info1('"+divid+"',this)");
}

function get_document_info1 (divid,btn) 
{
      $("#"+divid).slideToggle();
      $(btn).html("View More");
      $(btn).attr("onclick","get_document_info('"+divid+"',this)");
}

function get_comment (divid,btn) 
{
      $("#"+divid).slideToggle();
      
} 


function hide_div (cross) 
{

  var parentRow = $(cross).closest('div .informative');
  $(parentRow).slideUp();
}

function add_comment (articleid) 
{
    $("#comment_Article_id").val(articleid);
}


$(document).ready(function() 
{
   $('.textarea').wysihtml5({
    toolbar: {
      fa: true
    }
  });
   
});
</script>
       