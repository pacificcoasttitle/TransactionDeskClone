<div class="container">
    <div class="content-wrapper">
        <section id="content">
            <?php include 'ext-menu.php';?>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active">Multimedia </li>
            </ol>
            <div class="clearfix">
            </div>
            <div class="panel panel-default flat article-container-inner">
                <div class="panel-body article-post">
                    <h3 class="panel-title">Multimedia</h3>
                    <hr>
                    <article class="blog-news">
             <!--   <ul class="nav-heading">
                 <li><a href="#">New Realese</a></li>
                 <li><a href="#">Most Viewed</a></li>
                 <li><a href="#">Most Rated</a></li>
                </ul> -->
                <div class="clearfix">
                
                </div>
<article class="blog-row" style="display:none;">
    <div class="row">
        <div class="col-xs-12  col-lg-4">
            <a href="#" class="block-row">
                
<img class="block-img"  src="<?=base_url()?>assets/front/images/block-image.jpg">
<span class="block-content"><h4>Sound of nature</h4>
<p>Weired and wild soundscapes you've never heard</p></span>
<i class="block-arrow icon-angle-right"></i>
            </a>
        </div>
        <div class="col-xs-12  col-lg-4">
            <a href="#" class="block-row">
                
<img class="block-img"  src="<?=base_url()?>assets/front/images/block-image.jpg">
<span class="block-content"><h4>Sound of nature</h4>
<p>Weired and wild soundscapes you've never heard</p></span>
<i class="block-arrow icon-angle-right"></i>
            </a>
        </div>
        <div class="col-xs-12  col-lg-4">
            <a href="#" class="block-row">
                
<img class="block-img"  src="<?=base_url()?>assets/front/images/block-image.jpg">
<span class="block-content"><h4>Sound of nature</h4>
<p>Weired and wild soundscapes you've never heard</p></span>
<i class="block-arrow icon-angle-right"></i>
            </a>
        </div>
    </div>
</article>
<div class="clearfix">

</div>
<article class="blog-section">
    
    <div class="row">
    <?php foreach ($multimedia_article as $art_info): ?>
        
    
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <div class="panel panel-primary pane-block">
                  <div class="panel-heading">
                        <?=date("j F", strtotime($art_info->date_added))?>
                        <a href="#" class="pull-right"><i class="icon-eye-open"></i> Views (2)</a> 
                        <a href="#" class="pull-right"><i class="icon-hand-right"></i> Votes (2)&nbsp;</a>

                       
                  </div>
                  <div class="panel-block-img">
                  <img style="height: 156px; width: 235px;" src="<?=base_url()?>upload/user/<?=$art_info->userid?>/media/<?=$art_info->thumb?>" class="img-responsive">
                  <div class="caption">
                      <small><?=$art_info->fname?></small>
                      <h4><?=$art_info->title?></h4>
                  </div>
                  </div>
                  <div class="panel-body caps">
          <h4><?=ucfirst($art_info->salutation." ".ucfirst($art_info->fname)." ".ucfirst($art_info->lname));?></h4>
          <p class="lead"><?=$art_info->designation?></p>
          <p><?=substr($art_info->description, 0, 200)?> </p>
                  </div>
            </div>
        </div>
    <?php endforeach ?>
       
      
     
      
    </div>
</article>

               </article>
            </div>
        </section>
