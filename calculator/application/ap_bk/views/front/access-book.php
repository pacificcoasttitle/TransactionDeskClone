
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
                  <div class="panel panel-default flat" id="main-height">
                <div class="panel-body">
                  <h3 class="text-uppercase panel-title"><?=$book_detail->speciality?></h3>
                  <hr>
                  <article class="book-details">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 text-center">
                                    <img style="width: 100%;" src="<?=base_url()?>assets/front/images/book.jpg" class="img-responsive">
                                    <br>
                                    <button class="btn btn-primary btn-block " type="button"> Get Access</button>
                                    
                                </div>
                                <div class="col-lg-9">
                                    <h3 class="panel-title"><?=$book_detail->book_title?></h3>
                                    <p>
                                        
                                        
                                        </p><h4><b><?=$book_detail->subtitle?></b></h4>
                                        <p><b>
                                        Authors: <?=$book_detail->author?> </b></p>
                                        <p><b>About this book</b></p>
                                        <p><?=$book_detail->about?></p>
                                        <div class="clearfix  mar-top-20 mar-bottom-40">
                                           
                                            <div class="clearfix">
                                                <img style="vertical-align: middle; width: 40px; margin-right: 10px;" src="<?=base_url()?>assets/front/images/key.png" class="pull-left">&nbsp; &nbsp; &nbsp;  <h4 class="pull-left">Possible way to access this content</h4>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <img src="<?=base_url()?>assets/front/images/book.jpg" class="img-responsive">
                                                </div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                                    <p>
                                                    Buy this ebook</p>
                                                    <h3 class="panel-title"><b>$<?=$book_detail->price?></b></h3>
                                                    <p>*Final gross prices may vary according to local VAT</p>
                                                    <a class="btn btn-info " href="<?=base_url()?>buy-book/<?=$book_detail->bookid?>">Buy this eBook</a>
                                                    <p class="mar-top-10">Or Enter the Voucher number to get instant access to book </p>
                                                    <div class="row">
                                                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                    <input type="text" name="" id="input" class="form-control" value="" required="required" title="">
                                                            
                                                        </div>
                                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </article>
                </div>
              </div>
              
                
              
            </section>
