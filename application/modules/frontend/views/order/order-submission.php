<body>
    <?php
        $this->load->view('layout/header');
    ?>
<div class="section-title-page7q area-bg area-bg_blue area-bg_op_60 parallax">
  <div class="area-bg__inner">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="b-title-page"></h1>
          <div class="b-title-page__info"></div>
          <!-- end breadcrumb-->
        </div>
      </div>
    </div>
  </div>
</div>
        <!-- end .b-title-page-->
        <article class="b-about section-default">
          <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ui-subtitle-block">Important Details Below</div>
                    <h2 class="ui-title-block ui-title-block_light">Your Order Info...</h2>
                    <div class="ui-decor-1 bg-primary"></div>
                    <p>We will be sending you an email confirmation shortly. Below you can find your order number, the full legal description, and the vesting information for your recently submitted order.</p>
                </div>
              <div class="col-md-6">
                <footer class="b-about__footer">
				<ul class="list list-mark-2">
                    <?php 
                        if(isset($orderNumber) && !empty($orderNumber))
                        {
                    ?>
                            <li>
                                <h3>Order Number:</h3><br>
                                <span class="orderinfo1" id="orderNumber"><?php echo $orderNumber; ?></span>
                            </li><br>
                    <?php
                        }
                    ?>
                    
                    <li>
                        <h3>Full Legal Description:</h3><br>
                        <span class="orderinfo1">
                            <?php
                                if(empty($L_V_CreateService) || empty($L_V_GetRequestSummary) || empty($L_V_GetResultById))
                                {
                            ?>
                                    <div class="loader"></div>
                                    <span id="legalDescription"></span>
                            <?php
                                }
                                else
                                {
                            ?>
                                
                                    <span id="legalDescription">
                                        <?php 
                                            if(isset($briefLegal) && !empty($briefLegal))
                                            {
                                                echo $briefLegal;
                                            }
                                            else
                                            {
                                                echo 'No data found.';
                                            }
                                        ?>
                                    </span>
                            <?php
                                }
                            ?>
                        </span>
                    </li><br>
                    <li>
                        <h3>Vesting Information:</h3><br>
                        <span class="orderinfo1">
                            <?php
                                if(empty($L_V_CreateService)|| empty($L_V_GetRequestSummary) || empty($L_V_GetResultById))
                                {
                            ?>
                                    <div class="loader"></div>
                                    <span id="vestingInformation"></span>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <span id="vestingInformation">
                                        <?php 
                                            if(isset($vesting) && !empty($vesting))
                                            {
                                                echo $vesting;
                                            }
                                            else
                                            {
                                                echo 'No data found.';
                                            }
                                        ?>
                                    </span>
                            <?php
                                }
                            ?>                            
                        </span>
                    </li><br>                                         
                </ul>
				</footer>
              </div>
              <div class="col-md-6">
                <div class="b-sm-about-group">
                  <div class="row" id="taxInformation">
                    <div class="col-md-6">
                        <h3>1st Installment</h3>
                        <?php
                            if(empty($Tax_CreateService)|| empty($Tax_GetRequestSummary) || empty($Tax_GetResultById))
                            {
                        ?>
                                <div class="loader"></div>
                                <div id="firstInstallment"></div>
                        <?php
                            }
                            else
                            {
                        ?>
                                <div id="firstInstallment" style="border:1px solid #000000;padding:15px;">
                                <?php
                                    if(isset($firstInstallment) && !empty($firstInstallment))
                                    {
                                ?>
                                        <p>Balance: <?php echo isset($firstInstallment['Balance']) && !empty($firstInstallment['Balance']) ? $firstInstallment['Balance'] : '-'?></p>
                                        <p>Amount: <?php echo isset($firstInstallment['Amount']) && !empty($firstInstallment['Amount']) ? $firstInstallment['Amount'] : '-'?></p>
                                        <p>DueDate: <?php echo isset($firstInstallment['DueDate']) && !empty($firstInstallment['DueDate']) ? $firstInstallment['DueDate'] : '-'?></p>
                                        <p>Number: <?php echo isset($firstInstallment['Number']) && !empty($firstInstallment['Number']) ? $firstInstallment['Number'] : '-'?></p>
                                        <p>PaymentDate: <?php echo isset($firstInstallment['PaymentDate']) && !empty($firstInstallment['PaymentDate']) ? $firstInstallment['PaymentDate'] : '-'?></p>
                                        <p>Penalty: <?php echo isset($firstInstallment['Penalty']) && !empty($firstInstallment['Penalty']) ? $firstInstallment['Penalty'] : '-'?></p>
                                        <p>Status: <?php echo isset($firstInstallment['Status']) && !empty($firstInstallment['Status']) ? $firstInstallment['Status'] : '-'?></p>
                                        <p>AmountPaid: <?php echo isset($firstInstallment['AmountPaid']) && !empty($firstInstallment['AmountPaid']) ? $firstInstallment['AmountPaid'] : '-'?></p>
                                        <p>TaxYear: <?php echo isset($firstInstallment['TaxYear']) && !empty($firstInstallment['TaxYear']) ? $firstInstallment['TaxYear'] : '-'?></p>
                                <?php
                                    }
                                ?>
                            </div>
                        <?php 
                            }
                        ?>
                        
                    </div>
                    <div class="col-md-6">                      
                        <h3>2nd Installment</h3>
                        <?php
                            if(empty($Tax_CreateService)|| empty($Tax_GetRequestSummary) || empty($Tax_GetResultById))
                            {
                        ?>
                                <div class="loader"></div>
                                <div id="secondInstallment"></div>
                        <?php
                            }
                            else
                            {
                        ?>
                                <div id="secondInstallment" style="border:1px solid #000000;padding:15px;">
                                <?php
                                    if(isset($secondInstallment) && !empty($secondInstallment))
                                    {
                                ?>
                                        <p>Balance: <?php echo isset($secondInstallment['Balance']) && !empty($secondInstallment['Balance']) ? $secondInstallment['Balance'] : '-'?></p>
                                        <p>Amount: <?php echo isset($secondInstallment['Amount']) && !empty($secondInstallment['Amount']) ? $secondInstallment['Amount'] : '-'?></p>
                                        <p>DueDate: <?php echo isset($secondInstallment['DueDate']) && !empty($secondInstallment['DueDate']) ? $secondInstallment['DueDate'] : '-'?></p>
                                        <p>Number: <?php echo isset($secondInstallment['Number']) && !empty($secondInstallment['Number']) ? $secondInstallment['Number'] : '-'?></p>
                                        <p>PaymentDate: <?php echo isset($secondInstallment['PaymentDate']) && !empty($secondInstallment['PaymentDate']) ? $secondInstallment['PaymentDate'] : '-'?></p>
                                        <p>Penalty: <?php echo isset($secondInstallment['Penalty']) && !empty($secondInstallment['Penalty']) ? $secondInstallment['Penalty'] : '-'?></p>
                                        <p>Status: <?php echo isset($secondInstallment['Status']) && !empty($secondInstallment['Status']) ? $secondInstallment['Status'] : '-'?></p>
                                        <p>AmountPaid: <?php echo isset($secondInstallment['AmountPaid']) && !empty($secondInstallment['AmountPaid']) ? $secondInstallment['AmountPaid'] : '-'?></p>
                                        <p>TaxYear: <?php echo isset($secondInstallment['TaxYear']) && !empty($secondInstallment['TaxYear']) ? $secondInstallment['TaxYear'] : '-'?></p>
                                <?php
                                    }
                                ?>
                            </div>
                        <?php 
                            }
                        ?>                                        
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="grantDeedInfo">
                <div class="col-md-12">
                    <h3>Grant Deed Information:</h3>
                </div>
                <div class="col-md-3">
                    
                    <?php 
                        if(empty($L_V_CreateService)|| empty($L_V_GetRequestSummary) || empty($L_V_GetResultById))
                        {
                    ?>
                            <div id="grantDeedInfoFile"></div>
                            <div class="loader" style="display: none;"></div>
                    <?php
                        }
                        else
                        {
                    ?>
                            <div id="grantDeedInfoFile">
                                <?php 
                                    $L_V_serviceId = isset($L_V_serviceId) && !empty($L_V_serviceId) ? $L_V_serviceId : '';
                                    $instrumentNumber = isset($instrumentNumber) && !empty($instrumentNumber) ? $instrumentNumber : '';
                                    $state = isset($state) && !empty($state) ? $state : '';
                                    $county = isset($county) && !empty($county) ? $county : '';
                                    $recordedDate = isset($recordedDate) && !empty($recordedDate) ? $recordedDate : '';
                                    $time = strtotime($recordedDate);
                                    $year = date('Y',$time);
                                    
                                    $docId = str_replace($year, '', $instrumentNumber);
                                   
                                ?>
                                <a href="javascript:void(0);" class="btn btn-default btn-sm btn_mrg-top_30" id="btn-download-L-V" onclick='imageCreateRequest("<?php echo $L_V_serviceId; ?>",4);'>Download L&V</a>
                            </div>
                            <div class="loader" style="display: none;"></div>
                    <?php
                        }
                    ?>
                    
                </div>
                <div class="col-md-3">
                    <?php
                        if(empty($L_V_CreateService)|| empty($L_V_GetRequestSummary) || empty($L_V_GetResultById))
                        {
                    ?>
                            <div id="instrumentInfoFile"></div>
                            <div class="loader" style="display: none;"></div>
                    <?php
                        }
                        else
                        {
                    ?>
                            <div id="instrumentInfoFile">
                            <a href="javascript:void(0);" onclick='instrumentSearch("<?php echo $docId; ?>","<?php echo $recordedDate; ?>","<?php echo $state; ?>","<?php echo $county; ?>");' class="btn btn-default btn-sm btn_mrg-top_30" id="btn-download-grant-deed">Download Grant Deed</a>
                        </div>
                        <div class="loader" style="display: none;"></div>
                    <?php
                        }
                    ?>
                    
                </div>
            </div>
          </div>
        </article>
        <!-- end .b-about-->
      <div class="section-area">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <div class="b-advantages-group">
                  <section class="b-advantages b-advantages-2 b-advantages-2_mod-a b-advantages_3-col"><i class="b-advantages__icon stroke flaticon-screen"></i>
                    <div class="b-advantages__inner">
                      <h3 class="b-advantages__title ui-title-inner"><a href="home.html">Order a Farm</a></h3>
                      <div class="b-advantages__info">Our customer service team is ready to help create a farm package to help you alert the neighbors about your new listing.</div>
					  <a class="btn btn-default btn-sm btn_mrg-top_30" href="#">Order</a>
                    </div>
                  </section>
                  <!-- end .b-advantages-->
                  <section class="b-advantages b-advantages-2 b-advantages-2_mod-a b-advantages_3-col"><i class="b-advantages__icon stroke flaticon-worldwide"></i>
                    <div class="b-advantages__inner">
                      <h3 class="b-advantages__title ui-title-inner"><a href="https://www.pcttitletoolbox.com/#!/">Create a Farm</a></h3>
                      <div class="b-advantages__info">Login in to our PCT Title Toolbox program and create your own farm package consisting of the various types of owners.</div>
					  <a class="btn btn-default btn-sm btn_mrg-top_30" href="https://www.pcttitletoolbox.com/#!/">Login</a>
                    </div>
                  </section>
                  <!-- end .b-advantages-->
                  <section class="b-advantages b-advantages-2 b-advantages-2_mod-a b-advantages_3-col"><i class="b-advantages__icon stroke flaticon-analytics"></i>
                    <div class="b-advantages__inner">
                      <h3 class="b-advantages__title ui-title-inner"><a href="home.html">Open New Order</a></h3>
                      <div class="b-advantages__info">Need to open another order? That's fantastic. The link below will redirect you back to our Open Order form.</div>
					  <a class="btn btn-default btn-sm btn_mrg-top_30" href="#">Create</a>
                    </div>
                  </section>
                  <!-- end .b-advantages-->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end .section-area-->
      
      <!-- end .section-type-12-->
     
     
       

      <!-- end .section-default-->
     <section class="section-type-1 section-sm parallax area-bg area-bg_grad-2 area-bg_op_70">
            <div class="area-bg__inner">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <h2 class="ui-title-block-3">we provide higher quality services</h2>
                            <div class="ui-subtitle-block-2">and you’ll get solutions for everything</div>
                        </div>
                        <div class="col-md-5"><a class="btn btn-default btn-round pull-right" href="https://clients.pacificcoasttitle.com/login.aspx?ReturnUrl=/&amp;officeid=1">open orders</a><a class="btn btn-default btn-round pull-right" href="rate-book.html">get rates</a></div>
                    </div>
                </div>
            </div>
        </section>
</body>
</html>
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    var address = "<?php echo isset($address) && !empty($address) ? $address : ''; ?>";
    var city = "<?php echo isset($city) && !empty($city) ? $city : ''; ?>";
    var apn = "<?php echo isset($apn) && !empty($apn) ? $apn : '' ; ?>";
    var state = "<?php echo isset($state) && !empty($state) ? $state : ''; ?>";
    var county = "<?php echo isset($county) && !empty($county) ? $county : ''; ?>";
    var fipCode = "<?php echo isset($fipCode) && !empty($fipCode) ? $fipCode : ''; ?>";
    var L_V_RequestId = "<?php echo isset($L_V_RequestId) && !empty($L_V_RequestId) ? $L_V_RequestId : ''; ?>";
    var L_V_CreateService = "<?php echo isset($L_V_CreateService) && !empty($L_V_CreateService) ? $L_V_CreateService : ''; ?>";
    var Tax_RequestId = "<?php echo isset($Tax_RequestId) && !empty($Tax_RequestId) ? $Tax_RequestId : ''; ?>";
    var Tax_CreateService = "<?php echo isset($Tax_CreateService) && !empty($Tax_CreateService) ? $Tax_CreateService : ''; ?>";
    var L_V_GetRequestSummary = "<?php echo isset($L_V_GetRequestSummary) && !empty($L_V_GetRequestSummary) ? $L_V_GetRequestSummary : ''; ?>";
    var L_V_ResultId = "<?php echo isset($L_V_ResultId) && !empty($L_V_ResultId) ? $L_V_ResultId : ''; ?>";
    var Tax_ResultId = "<?php echo isset($Tax_ResultId) && !empty($Tax_ResultId) ? $Tax_ResultId : ''; ?>";
    var Tax_GetRequestSummary = "<?php echo isset($Tax_GetRequestSummary) && !empty($Tax_GetRequestSummary) ? $Tax_GetRequestSummary : ''; ?>";
    var L_V_GetResultById = "<?php echo isset($L_V_GetResultById) && !empty($L_V_GetResultById) ? $L_V_GetResultById : ''; ?>";
    var Tax_GetResultById = "<?php echo isset($Tax_GetResultById) && !empty($Tax_GetResultById) ? $Tax_GetResultById : ''; ?>";
</script>

<?php
    $this->load->view('layout/footer');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/order.js"></script>