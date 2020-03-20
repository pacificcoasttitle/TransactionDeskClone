 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Dashboard</h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row top_tiles">
                        
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="<?=base_url()?>index.php/admin/associates">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-user"></i>
                                </div>
                                <div class="count"><?=$asso_count?></div>

                                <h3>Associates</h3>
                               
                            </div>
                            </a>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                             <a href="<?=base_url()?>index.php/admin/users">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-users"></i>
                                </div>
                                <div class="count"><?=$users_count?></div>
                                <h3>Users</h3>
                               
                            </div>
                            </a>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                             <a href="<?=base_url()?>index.php/admin/manage_product">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="count"><?=$prod_count?></div>

                                <h3>Products</h3>
                               
                            </div>
                            </a>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-check-square-o"></i>
                                </div>
                                <div class="count">179</div>

                                <h3>New Sign ups</h3>
                               
                            </div>
                        </div>
                    </div>
                </div>