<style type="text/css">
  .text-success{
    color: green;
  }
  .text-dander{
    color: red;
  }
</style>

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
                                     
                                   

                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Plan Name</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" class="form-control" id="" placeholder="" name="plan_name" required value="<?=$mlm_info->plan_name?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Maximum Allowed Levels</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" placeholder="" name="maximum_allowed_levels" required value="<?=$mlm_info->maximum_allowed_levels?>">
                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Allowed Members Per Level(Legs)</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="allowed_members_per_level" value="<?=$mlm_info->allowed_members_per_level?>">
                                        </div>
                                    </div>

                                 
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Discount overall</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="discount_overall" value="<?=$mlm_info->discount_overall?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Deduction per Month</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="deduction_per_month" value="<?=$mlm_info->deduction_per_month?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Corner Charges</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="corner_charges" value="<?=$mlm_info->corner_charges?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Commercial Charges</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="commercial_charges" value="<?=$mlm_info->commercial_charges?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">PLC Charges</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="plc_charges" value="<?=$mlm_info->plc_charges?>">
                                        </div>
                                    </div>

                                   <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Premium Project Share</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="premium_project_share" value="<?=$mlm_info->premium_project_share?>">
                                        </div>
                                    </div>
                                   <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Prime Project Share </label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="prime_project_share" value="<?=$mlm_info->prime_project_share?>">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Rural Project Share</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="rural_project_share" value="<?=$mlm_info->rural_project_share?>">
                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Sales Commisson monthly target</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="sales_commission_monthly_target" value="<?=$mlm_info->sales_commission_monthly_target?>">
                                        </div>
                                    </div>


                                  <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Business (In Rs.)</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="business_in_rs" value="<?=$mlm_info->business_in_rs?>">
                                        </div>
                                    </div>

                                   <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Max Sale Area</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="max_sale_area" value="<?=$mlm_info->max_sale_area?>">
                                        </div>
                                    </div>
                                          
                                 <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Security Amount</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="security_amount" value="<?=$mlm_info->security_amount?>">
                                        </div>
                                    </div>

                                <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Min Rs.</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="min_rs" value="<?=$mlm_info->min_rs?>">
                                        </div>
                                    </div>
<div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Max Rs.</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="max_rs" value="<?=$mlm_info->max_rs?>">
                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Franchise Commission</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="franchise_commission" value="<?=$mlm_info->franchise_commission?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">No. of Months for Plan</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="no_month" value="<?=$mlm_info->no_month?>">
                                        </div>
                                    </div>


                                      <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Late Installment Charges</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="late_instalment_charges" value="<?=$mlm_info->late_instalment_charges?>">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">Limit of Registration per month</label>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" pattern="^[0-9]*\.?[0-9]+$" class="form-control" id="" maxlength="10" placeholder="" required name="limit_for_registration_month" value="<?=$mlm_info->limit_for_registration_month?>">
                                        </div>
                                    </div>

                                   

                                
                                    <button id="button_user" type="submit" class="btn btn-primary pull-right"><?php  if(!empty($mlm_info)){echo 'Update';}else{echo 'Add';} ?></button>
                                </form>
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">

                </script>