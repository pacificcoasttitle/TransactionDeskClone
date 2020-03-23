<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MLM Associate Panel</title>

    <!-- Bootstrap core CSS -->

    <link href="<?=base_url()?>assets/admin/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?=base_url()?>assets/admin/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/admin/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="<?=base_url()?>assets/admin/css/custom.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/admin/css/icheck/flat/green.css" rel="stylesheet">


    <script src="<?=base_url()?>assets/admin/js/jquery.min.js"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?=base_url()?>index.php/admin" class="site_title"><i class="fa fa-cog"></i> <span>Associate Panel</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="<?=base_url()?>assets/admin/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Associate</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="<?=base_url()?>index.php/associate/dashboard"><i class="fa fa-home"></i> Dashboard </a>                                
                                </li>
                                <li><a href="<?=base_url()?>index.php/associate/edit_profile"><i class="fa fa-user"></i>Edit Profile </a></li>
                                <li><a href="<?=base_url()?>index.php/associate/users"><i class="fa fa-users"></i> Users </a>
                                   
                                </li>

                                    
                                 <li><a href="<?=base_url()?>index.php/associate/tree"><i class="fa fa-tree"></i> Tree View </a>
                                   
                                </li>
                                

                                 <li><a href="<?=base_url()?>index.php/associate/manage_product"><i class="fa fa-gift"></i> Manage Products</a>
                                   
                                </li>
                                 <li><a href="<?=base_url()?>index.php/associate/payout_detail"><i class="fa fa-inr"></i> Payout Detail</a>
                                   
                                </li>

                            </ul>
                        </div>
                      
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?=base_url()?>assets/admin/images/img.jpg" alt="">Associate
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    
                                    <li><a href="<?=base_url()?>index.php/associate/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>

                          

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->
            <?php if ($this->session->flashdata('msg')): ?>
               <div class="col-md-6 col-md-offset-3">
                   <div role="alert" class="alert alert-success alert-dismissible fade in ">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong><?=$this->session->flashdata('msg');?></strong>
                                </div>
               </div>
                
            <?php endif ?>