<div class="section-title-page3 area-bg area-bg_blue area-bg_op_90 parallax">
          <div class="area-bg__inner">
            <div class="container">
              <div class="row">
                <div class="col-xs-12">
                  <h1 class="b-title-page">Order Submitted Successfully</h1>
                  <div class="b-title-page__info">Congratulations</div>
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
              <div class="col-md-6">
                <div class="ui-subtitle-block">Important Details Below</div>
                <h2 class="ui-title-block ui-title-block_light">Your Order Info...</h2>
                <div class="ui-decor-1 bg-primary"></div>
                <p>We will be sending you an email confirmation shortly. Below you can find your order number, the full legal description, and the vesting information for your recently submitted order.</p>
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
                            <div class="loader"></div>
                            <span id="legalDescription"></span>
                        </span>
                    </li><br>
                    <li>
                        <h3>Vesting Information:</h3><br>
                        <span class="orderinfo1">
                            <div class="loader"></div>
                            <span id="vestingInformation"></span>
                        </span>
                    </li><br>                                         
                </ul>
				</footer>
              </div>
              <div class="col-md-6">
                <div class="b-sm-about-group">
                  <div class="row">
                    <div class="col-md-6">
                      <section class="b-sm-about"><img class="img-responsive" src="<?php echo BASE_URL_MAIN; ?>assets/media/components/b-about/p1.jpg" alt="foto">
                        <h3 class="b-sm-about__title">How to Read a Prelim</h3>
                        <p>Want to understand your preliminary title report? Our guide can help you understand what your report is stating.</p>
						
						<a class="btn btn-default btn-sm btn_mrg-top_30" href="/industry-documents/pctReadPrelim.pdf">Download PDF</a>
                      </section>
                    </div>
                    <div class="col-md-6">
                      <section class="b-sm-about"><img class="img-responsive" src="<?php echo BASE_URL_MAIN; ?>assets/media/components/b-about/p2.jpg" alt="foto">
                        <h3 class="b-sm-about__title">Buyer & Seller Guide</h3>
                        <p>The perfect way to educate your prospective buyers and sellers about the process of purchasing or selling a home.</p>
						<a class="btn btn-default btn-sm btn_mrg-top_30" href="/industry-documents/TitleCompany-Buy-Sell-Web.pdf">Download PDF</a>
						
                      </section>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="taxInformation">
                <div class="col-md-12">
                    <h3>Taxes:</h3>
                </div>
                <div class="col-md-6">
                    <h3>1st Installment</h3>
                    <div class="loader"></div>
                    <div id="firstInstallment"></div>
                </div>
                <div class="col-md-6">
                    <h3>2nd Installment</h3>
                    <div class="loader"></div>
                    <div id="secondInstallment"></div>
                </div>
            </div><br/>
            <div class="row" id="grantDeedInfo">
                <div class="col-md-12">
                    <h3>Grant Deed Information:</h3>
                </div>
                <div class="col-md-6">                    
                    <div class="loader"></div>
                    <div id="grantDeedInfoFile"></div>
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
<script type="text/javascript">
  var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript">
    var address = "<?php echo isset($address) && !empty($address) ? $address : ''; ?>";
    var city = "<?php echo isset($city) && !empty($city) ? $city : ''; ?>";
    var apn = "<?php echo isset($apn) && !empty($apn) ? $apn : '' ; ?>";
    var state = "<?php echo isset($state) && !empty($state) ? $state : ''; ?>";
    var county = "<?php echo isset($county) && !empty($county) ? $county : ''; ?>";
    var fipCode = "<?php echo isset($fipCode) && !empty($fipCode) ? $fipCode : ''; ?>";
    var customer_number = "<?php echo isset($customer_number) && !empty($customer_number) ? $customer_number : '' ; ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/order.js"></script>
<?php
    $this->load->view('layout/footer');
?>
