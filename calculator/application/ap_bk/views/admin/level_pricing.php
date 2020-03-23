
<!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    
                    <div class="clearfix">
                      <ol class="breadcrumb">
                        <li>
                          <a href="<?=base_url()?>index.php/admin">Dashboard</a>
                        </li>
                        <li class="active"><?=$page_head?></li>
                      </ol>
                    </div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" >
                                <div class="x_title">
                                    <h2><?=$page_head?></h2>
                                   
                                    <div class="clearfix"></div>

                                     <form action="" method="POST" role="form" class="form-horizontal form-label-left">
                                     <div class="row">
                                       <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-md-offset-2">
                                         <h5>Level Pricing</h5>
                                       </div>
                                      <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                        <h5>Special Discount</h5>
                                      </div>
                                     </div>
                                  <?php for($i=1; $i <= $max_level;$i++) {?>
                                      <div class="form-group">
                                        <label for="" class="control-label col-md-2 col-sm-2 col-xs-12"> Level <?=$i?> (%)</label>
                                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                            <input type="text" pattern="^[0-9.]+$" class="form-control" id="" placeholder="" name="level[<?=$i?>]" required value="<?=$pricing['price_percent'][$i]?>">
                                        </div>
                                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                            <input type="text" pattern="^[0-9.]+$" class="form-control" id="" placeholder="" name="special[<?=$i?>]" required value="<?=$pricing['special_commission'][$i]?>">
                                        </div>


                                    </div>
                                   <?php } ?>

                                   

                                    

                                  
                                   
                                
                                    <button id="button_user" type="submit" class="btn btn-primary pull-right">Update</button>
                                </form>
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">

                </script>