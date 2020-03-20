
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>MyReposit - Connect. Communicate. Collaborate. </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <link href="<?=base_url()?>assets/front/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/front/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/front/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <link rel="icon" type="image/png"  href="<?=base_url()?>assets/front/images/fevicon.png">
  </head>
  <body>
    <header id="header" class="clearfix">
      <nav class="navbar" role="banner">
   
        <div class="container">   
        <div class="row">
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
             <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="icon icon-reorder"></i></button>
            <a class="navbar-brand" href="<?=base_url()?>"><img src="<?=base_url()?>assets/front/images/logo.png" alt="MyReposit"></a>
            </div>
          </div>
        
         
            
             <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 ">
              <form role="form" action="<?=base_url()?>search" method="POST" >
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-md-offset-1 top-bar">
                  <select style="padding: 4px 3px;background-position: 98% 4px;" name="cat" id="Area123" class="form-control">
                      <option value="" class="s" style="color:#999999">-- Select Category -- </option>
                      <!-- <option value="subject">Speciality</option> -->
                      <option value="author">Authors</option>
                      <option value="title">Title</option>
                      <option value="community">Community</option>
                      <option value="keyword">Keyword</option>
                      <option value="year">Year</option>
                      <option value="doi">DOI</option>
                    </select>
               </div>
             
               
                  
                  
               
                  <div class="input-group top-bar" style="width:207px;" id="null-value">

                  <input type="text" class="form-control" name="title_name" autocomplete="off" placeholder="&nbsp;&nbsp;Search Articles">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-mr">GO</button>
                  </span></div>
                  <div id="author"  class="input-group top-bar" style="width:170px;display:none;">
                      
                          <input type="text" id="name"  class="form-control" name="author_name" placeholder="Enter Author Name">
                       
                          <button type="submit" class="btn btn-mr">Go</button>
                       
                      </div>
                   
                    <div id="title" class="input-group top-bar" style="width:170px;display:none;">
                          <input type="text" id="name" class="form-control" name="title_name" placeholder="Enter Title">
                        <button type="submit" class="btn btn-mr">Go</button>
                        </div>
                      
                    
                    <div id="type" class="input-group top-bar" style="width:170px;display:none;">
                          <select  class="form-control" name="community_name" >
                            <option value="">Select Community</option>
                            <option>Articles</option>
                            <option> Cases</option>
                            <option>Multimedia</option>
                            <option>Media Stories</option>
                            <option>Patient Education</option>
                          </select>
                        <button type="submit" class="btn btn-mr">Go</button>
                        </div>
                     
                    <div id="keyword" class="input-group top-bar" style="width:170px;display:none;">
                          <input type="text" id="name" class="form-control" name="keyword_name" placeholder="Enter Keyword">
                        <button type="submit" class="btn btn-mr">Go</button>
                        </div>
                     
                    <div id="year" class="input-group top-bar" style="width:170px;display:none;">
                          <input type="text" id="name" class="form-control" name="year_name" placeholder="Enter Year">
                         <button type="submit" class="btn btn-mr">Go</button>
                        </div>
                     
                    <div id="doi" class="input-group top-bar" style="width:170px;display:none;">
                          <input type="text" id="name" class="form-control" name="doi_name" placeholder="Enter DOI">
                        <button type="submit" class="btn btn-mr">Go</button>
                        </div>
                     
                  
                      
               
             
                </div>
                
                </form>
              
              </div>
  <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 pull-right">
                 <?php if ($this->session->userdata('mpuserid')): ?>
                <div class="site-user  top-bar ">
                  <div class="btn-group">
                    
                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Welcome <?=$this->session->userdata('mpusername');?> <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="<?=base_url()?>dashboard">Dashboard</a></li>
                      <li><a href="<?=base_url()?>change-password">Change Password</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="<?=base_url()?>logout">Logout</a></li>
                    </ul>
                  </div>
                </div>
               <?php else: ?>
                <div class="site-links top-bar  pull-right"><a href="<?=base_url()?>signup" class="btn btn-default"><i class="icon-edit"></i> Sign Up</a><a href="login" class="btn btn-default"><i class="icon-user"></i> Login</a></div>
                  
                <?php endif ?>
              </div>
              </div>
              <!--/.top-bar-->
              <div class="collapse navbar-collapse navbar-right" style="margin-top:-44px;">
                <ul class="nav navbar-nav">
                  <li><a href="<?=base_url()?>">Home</a></li>
                  <li><a href="<?=base_url()?>about">About Us</a></li>
                  <li><a href="<?=base_url()?>terms">Terms of Service</a></li>
                  <li><a href="<?=base_url()?>privacy-policy">Privacy &amp; Data Protection</a></li>
                  <li><a href="<?=base_url()?>faqs">FAQs</a></li>
                  <li><a href="<?=base_url()?>contact">Contact Us</a></li>
                  <li><a target="_blank" href="http://www.phrindia.com/"><img src="<?=base_url()?>assets/front/images/PHR_smallsize.png" class="img-responsive" alt="Image"></a></li>
                </ul>
              </div>
            </div>
         </div>
           
            <!--/.container-->
          </nav>
          <!--/nav-->
        </header>
        <!--/header-->