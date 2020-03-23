 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                   
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:600px;">
                                <div class="x_title">
                                    <h2>Payout Detail</h2>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                 <div class="x_content"> 
                                   <table class="table table-bordered table-hover">
                                       <tbody>
                                           <tr>
                                               <th>Total Revenue</th><td><?=$payout->total_revenue?></td>
                                               <th>Direct Income</th><td><?=$payout->direct_income?></td>
                                           </tr>
                                           <tr>
                                               <th>Credit Limit</th><td><?=$credit_limit->credit_limit?></td>
                                               <th>Remaining Limit</th><td><?=($credit_limit->credit_limit - $payout->total_revenue)?></td>
                                           </tr>
                                       </tbody>
                                   </table>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>