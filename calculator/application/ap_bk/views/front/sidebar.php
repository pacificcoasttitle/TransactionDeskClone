
        <aside class="bg-black aside-sm hidden-print hidden-xs"> 
         <div class="panel-group" id="aside-menu">
           <!--  <a href="javascript:;" class="guidelink"><i class="icon-youtube-play"></i> GUIDE TO MyReposit</a> -->
           
 <!-- /.panel panel-default -->
                <div class="panel panel-default guidelink">
                    <div class="panel-heading adv">
                        <h3 class="panel-title">
                                                        <a class="block-collapse" data-parent="#aside-menu"  href="#aside-menu-child-2">
                                                        Advisory Board</a>
                                                        </h3>
                    </div>
                    <div id="aside-menu-child-2" class="collapse">
                        <div class="panel-body">
                            <ul>
                                <li>
                                    <a href="javascript:;">Articles</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Multimedia</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Media & Medicine</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Books</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Events</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Societies</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Institutions</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Jobs</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.collapse in -->
                </div>
            <!-- Aside Menu -->
          <?php if ($active != 'homepage' OR !isset($active)): ?>
               <div class="sidebar-spacing"></div>
          <?php endif ?>
           
          
            <div class="panel panel-default">
                   
                    <div id="aside-menu-child-5" class="collapse in">
                        <div class="panel-body">
                            <ul class="cat-nav2">
                                <li>
                                    <a href="<?=base_url()?>articles">Articles</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>multimedia">Multimedia</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>media-stories">Media & Medicine</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>books">Books</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>events">Events</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>societies">Societies</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>institutions">Institutions</a>
                                </li>
                                <li>
                                    <a href="<?=base_url()?>external-jobs">Jobs</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                    <!-- /.collapse in -->
                </div>
                <div class="panel panel-default margin-top-5">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                                           
                                            <a class="block-collapse" data-toggle="modal" href='#modal-id22'>Speciality</a>
                                           
                                            </h3>
                    </div>
                    <div id="aside-menu-child-1" class="collapse ">
                        <div class="panel-body">
                            <ul class="cat-nav2">
                             <?php $name = "" ; foreach ($departments as $key):    $name = str_replace(" ", "-", $key->departmentname); ?>
                                                    <li>
                                                        <a href="<?=base_url()?>speciality/<?=$name?>"><?=$key->departmentname?></a>

                                                    </li>
                               <?php endforeach;?>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.collapse in -->
                </div>
               
                <!-- /.panel panel-default -->
               
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                                                                                <a class="block-collapse" data-parent="#aside-menu"  href="#">
                                                                                    Expert Forum
                                                                                    
                                                                                </a>
                                                                                </h3>
                    </div>
                    <div id="aside-menu-child-4" class="collapse">
                        <div class="panel-body">
                            <ul>
                                <li>
                                    <a href="javascript:;">Articles</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Multimedia</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Media Stories</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Books</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Events</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Societies</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Institutions</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Jobs</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.collapse in -->
                </div>
                <!-- /.panel panel-default -->
               
                 <!-- /.panel panel-default -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                                                        <a class="block-collapse" data-parent="#aside-menu"  href="#aside-menu-child-2">
                                                        Health Awareness</a>
                                                        </h3>
                    </div>
                    <div id="aside-menu-child-2" class="collapse">
                        <div class="panel-body">
                            <ul>
                                <li>
                                    <a href="javascript:;">Articles</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Multimedia</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Media Stories</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Books</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Events</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Societies</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Institutions</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Jobs</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.collapse in -->
                </div>
                 
              <!-- side bar add menu ends-->
          <?php if ($active != 'homepage' OR !isset($active)): ?>
                <!-- side bar add menu-->
              
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title"><a  href="<?=base_url()?>independent-peer-review">Independent<br>
                  Peer review</a></h3>
                </div>
              </div>
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title"><a  href="<?=base_url()?>become-reviewer">Become a <br>Reviewer</a></h3>
                </div>
              </div>
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title"><a  href="<?=base_url()?>manuscript-development">Manuscript
                  Development</a></h3>
                </div>
              </div>
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title"><a  href="<?=base_url()?>publish-sell">Publish and <br>Sell</a></h3>
                </div>
              </div>
               <?php endif ?>
                <!-- /.panel panel-default -->
            </div>
            <!-- Aside Menu End -->

            
            <div class="panel panel-white " id="get-noticed">
               <!--  <div class="panel-heading text-uppercase">
                    GET Noticed
                </div> -->
                <div class="panel-body" >
                    <div id="carousel-id" class="carousel slide" data-ride="carousel">
                       
                        <div class="carousel-inner">
                            <div class="item">
                               <a href="<?=base_url()?>become-reviewer"> <img  alt="First slide" src="<?=base_url()?>assets/front/images/new/Become a Reviewer.jpg"></a>
                                
                            </div>
                            <div class="item">
                               <a href="<?=base_url()?>create-my-profile"> <img  alt="Second slide" src="<?=base_url()?>assets/front/images/new/Create Profile 2.jpg"></a>
                               
                            </div>
                            <div class="item">
                               <a href="<?=base_url()?>independent-peer-review"> <img  alt="Second slide" src="<?=base_url()?>assets/front/images/new/Independent Peer Review.jpg"></a>
                               
                            </div>
                            <div class="item active">
                              <a href="<?=base_url()?>create-my-profile">  <img alt="Second slide" src="<?=base_url()?>assets/front/images/new/Create Profile.jpg"></a>
                               
                            </div>
                            <div class="item ">
                               <a href="<?=base_url()?>manuscript-development"> <img  alt="Third slide" src="<?=base_url()?>assets/front/images/new/Manuscript Development.jpg"></a>
                               
                            </div>
                              <div class="item ">
                               <a href="<?=base_url()?>publish-sell"> <img  alt="Third slide" src="<?=base_url()?>assets/front/images/new/Publish & Sell.jpg"></a>
                               
                            </div>
                        </div>
                   </div>
                </div>
            </div>
 <?php if ($active != 'homepage' OR !isset($active)){ ?>
               <div class="panel panel-white" id="widget_inn">
                <div class="panel-body">
                   <a class="twitter-timeline"  href="https://twitter.com/myrepositinfo" data-widget-id="584540225864507395">Tweets by @myrepositinfo</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>
            </div>
        <?php } else { ?>
             <div class="panel panel-white" id="widget">
                <div class="panel-body">
                   <a class="twitter-timeline"  href="https://twitter.com/myrepositinfo" data-widget-id="584540225864507395">Tweets by @myrepositinfo</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>
            </div>
          <?php } ?>

          <div class="box pad-10 mar-bottom-10">
              <h3 class="no-margin box-title text-uppercase"><b>Subscribe to our newsletter</b></h3>
              <div class="clearfix hr margin-top-5"></div>  
              <form action="<?=base_url()?>index.php/welcome/newsletter_submit" method="POST" role="form">
              <p class="boxp">Receive periodic newsletter complied by leading clinicians</p>
                   <div class="form-group no-margin mar-bottom-5">
                     <input type="email" name="email" class="form-control sidebar-form" placeholder="Your Email ID">
                   </div>
                   <button type="submit" class="btn btn-primary btn-block btn-xs no-margin">Subscribe</button>
               </form> 
          </div>



          <div class="box pad-10 ">
              <h3 class="no-margin box-title text-uppercase"><img class="img-responsive" src="<?=base_url()?>assets/front/images/Elsevier.png" alt=""></h3>
              <form action="<?=base_url()?>search-elsevier-article" method="get" role="form">
              <p class="boxp">Enter Search keywords seperated by space</p>
                   <div class="form-group no-margin mar-bottom-5">
                     <input type="text" class="form-control sidebar-form" name="keywords" placeholder="Enter Keywords">
                   </div>
                   <button type="submit" class="btn btn-primary btn-block btn-xs no-margin">Search</button>
               </form> 
          </div>

            
        </aside>
    </div>
</div>

 <div class="modal fade" id="modal-id22">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header speciality-title">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title ">Specialities</h4>
                </div>
                <div class="modal-body speciality-select">
                    <div class="row">
                     <?php $name = "" ; foreach ($departments as $key):    $name = str_replace(" ", "-", $key->departmentname); ?>
                                       <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin-bottom:5px;white-space: normal;">
                                            <a href="<?=base_url()?>speciality/<?=$name?>" class="btn btn-default btn-block"><?=$key->departmentname?></a>

                                         </div>
                   <?php endforeach;?>
                        
                            
                       
                    </div>
                </div>
                
            </div>
        </div>
    </div>