    <link href="<?=base_url()?>assets/front/css/styles.css" rel="stylesheet">
<div class="container">
  <div class="content-wrapper">
    <section id="content">
      <?php include "ext-menu.php";?>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li><a href="<?php echo base_url(); ?>books">Books</a></li>
        <li class="active"><?=$book_detail->book_title?></li>
      </ol>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="panel panel-default flat" id="main-height">
            <div class="panel-body">
              <h3 class="panel-title"><?=$book_detail->speciality?></h3><hr>
              <div class="row">
                
             
              <div class="bookandrate col-lg-4">
              <img style="width:100%" src="<?=base_url()?>assets/front/images/book.jpg" title="book" alt="book" />
                <a href="#" class="btn" style="visibility:hidden;">Free Review</a>
                <div class="clearfix"></div>
                
                <div class="buybook">
                 <ul class="buybooklist">
                      <li><b>ISBN:</b> <?=$book_detail->isbn?></li>
                        <li><b>Included Format:</b> <?=$book_detail->book_format?></li>
                        <li>Download immediately after purchase.</li>
                    </ul> 
                    <div class="clearfix"></div>
                    <a  class="btn btn-primary btn-sm" data-toggle="modal" href='#modal-id'>Table of Content</a>
                    <p></p>
                    <a href="#" class="btn btn-primary btn-sm">Buy this eBook</a>
                    <h3>$<?=$book_detail->price?></h3>
<p></p>
                    <a href="<?=base_url()?>get-access-book/<?=$book_detail->bookid?>" class="btn btn-primary btn-sm" type="button"> Get Access</a >
                </div>
               
                <div class="clearfix"></div>
                
            </div>
            <div class="bookdetail col-lg-8">
                <h3 class="no-margin"><?=$book_detail->book_title?></h3><h4><?=$book_detail->sub_title?></h4>
                <p><span>Authors:</span> <?=$book_detail->author?></p>
                <p><b>About this book</b></p>
                <p class="para"><?=$book_detail->about?></p>
                
                <div class="graphicinfo">
                <h5 class="no-margin"><b>Bibliographic Information</b></h5><hr>
                  <ul class="list-unstyled">
                      <li><span></span></li>
                        <li><span>Book Titles: </span><?=$book_detail->book_title?></li>
                        <li><span>Authors: </span><?=$book_detail->author?></li>
                        <li><span>Copyright: </span><?=$book_detail->copyright?></li>
                        <li><span>Publisher: </span><?=$book_detail->publisher?></li>
                        <li><span>Copyright Holder: </span><?=$book_detail->copyright_holder?></li>
                        <li><span>eBook ISBN: </span><?=$book_detail->isbn_ebook?></li>
                        <li><span>DOI: </span><?=$book_detail->doi?></li>
                        <li><span>Hardcover ISBN: </span><?=$book_detail->isbn?></li>
                        <li><span>Softcover ISBN: </span><?=$book_detail->isbn_soft?></li>
                        <li><span>Edition Number: </span><?=$book_detail->edition?></li>
                        <li><span>Number of Pages: </span><?=$book_detail->pages?></li>
                    </ul>
                </div>

            </div>
            
           <!--  <div class="booktable col-lg-4">
              <h3 class="no-margin">Table of Content</h3><hr>
                <ul class="nav margin-bottom-10">
                <?php foreach ($book_toc as $toc): ?>
                   <li>
                      <a href="#"><?=$toc->content_title?></a>
                        <p><?=$toc->subtitle?>    (Pages <?=$toc->pages?>)</p>
                    </li>
                <?php endforeach ?>
                 
                    
                </ul>
                <p ><a href="#" class="btn btn-primary btn-sm">See More..</a></p>
            </div> -->

             </div>
             <div class="row">
                 <div class="slide_div">
              <h3>Recommended  Titles </h3><hr>
              <div id="myCarousel" class="carousel slide" data-ride="carousel"                     
                    
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner" role="listbox">
                        <div class="item active">
                          <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bks.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bks.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                        </div>
                    
                        <div class="item">
                          <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bks.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bks.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                        </div>
                    
                        <div class="item">
                          <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bks.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bks.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                        </div>
                    
                        <div class="item">
                          <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bks.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bks.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                            <div class="bk_item">
                              <img src="<?=base_url()?>assets/front/images/slide_bk.jpg" />
                                <a href="#">Process Mining</a>
                                <p>Van der Aalst, W. (2011)</p>
                            </div>
                        </div>
                      </div>
                    
                      
        </div>                  
            </div>
              </div> 
            
          </div>
        </div>
        </div>
       
      </div>
      
    </section>


    <div class="modal fade" id="modal-id">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Table of Content</h4>
          </div>
          <div class="modal-body">
          
          <div class="bookt">
                <ol class="margin-bottom-10">
                <?php foreach ($book_toc as $toc): ?>
                   <li>
                      <a href="#"><?=$toc->content_title?></a>
                        <p><?=$toc->subtitle?>    (Pages <?=$toc->pages?>)</p>
                    </li>
                <?php endforeach ?>
                </ul>
               <!--  <p ><a href="#" class="btn btn-primary btn-sm">See More..</a></p> -->
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">See More..</button>
          </div>
        </div>
      </div>
    </div>