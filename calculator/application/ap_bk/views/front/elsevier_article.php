
					
<div class="container">
    <div class="content-wrapper">
        <section id="content">
            <?php include 'ext-menu.php';?>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active">Elsevier Articles </li>
            </ol>
            <div class="clearfix">
            </div>
            <div class="panel panel-default flat article-container-inner">
                <div class="panel-body article-post">
                    <h3 class=" panel-title">Elsevier Articles</h3>
                    <hr>

                    <?php 
                       $dash = '-';
                       $colon = ":";
                       $param = "search".$dash."results";
                       $search_results = $curl_info->$param;

                       $param = "opensearch".$colon."totalResults";
                       $totalResults = $search_results->$param;

                       $articles = $search_results->entry;

                     //  echo "<pre>"; print_r($curl_info);

                    ?>

                    <h4><b>Keywords:</b> <?=$keywords?></h4>
<div class="clearfix hr">
                        
                        </div>
                    <?php foreach ($articles as $key):

                    $param = "dc".$colon."title";
                    $title = $key->$param;

                   $param = "prism".$colon."publicationName";
                   $publicationName = $key->$param;

                    $param = "prism".$colon."issn";
                    $issn = $key->$param;

                    $param = "prism".$colon."doi";
                    $doi = $key->$param;

                    $param = "prism".$colon."teaser";
                    $teaser = $key->$param;


                    $param = "@href";
                    $view = $key->link[1]->$param;
                     ?>
                    
                    <div class="row mar-bottom-5  margin-top-5 ">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 article-line ">
                            <img src="http://api.elsevier.com/content/serial/title/issn/<?=$issn?>?view=coverimage&httpAccept=image/gif&apiKey=63c5daeafc3e2a25af10b7315cdcce4b" class="img-responsive" alt="Image">
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

                          <p class="no-margin"><b>Publication Name:</b> <?=$publicationName?></p>
                          <p class="no-margin"><b>Article Title:</b> <?=$title?></p>
                         
                          <p class="no-margin"><b>View Online:</b> <a class="btn-link" target="_blank"  href="<?=$view?>" role="button"><?=$view?></a></p>
                          <p class="no-margin"><b>View PDF:</b> <a class="btn-link" target="_blank"  href="http://api.elsevier.com/content/article/doi/<?=$doi?>?httpAccept=application/pdf&apiKey=63c5daeafc3e2a25af10b7315cdcce4b" role="button"><i class="fa fa-file-pdf-o" ></i></a></p>
                          <p class="no-margin"><b>Abstract snippet:</b> <?=$teaser?></p> 
                        </div>
                        <div class="clearfix hr">
                        
                        </div>
                    </div>
                        
                    <?php endforeach ?>



                </div>
            </div>
        </section>
