

<div class="pct-home-modern">
<section style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Your Order Info</h1>
                <p class="pct-page-sub">We will be sending you an email confirmation shortly. Below you can find your order number, the full legal description, and the vesting information for your recently submitted order.</p>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Order Details -->
            <div class="col-lg-6">
                <div class="order-card">
                    <div class="order-card-header">Order Details</div>
                    
                    <?php if (isset($tp_data['file_number']) && !empty($tp_data['file_number'])) { ?>
                        <div class="order-label">Order Number</div>
                        <div class="order-value highlight" id="orderNumber"><?php echo $tp_data['file_number']; ?></div>
                        <input type="hidden" name="id" id="CustomerId" value="<?php echo $customer_id; ?>">
                        <input type="hidden" name="property-full-address" id="property-full-address" value="<?php echo $property; ?>">
                    <?php } ?>

                    <div class="order-label">Brief Legal Description</div>
                    <div class="order-value" id="legalDescription">
                        <?php
                        if (isset($tp_data['legal_description']) && !empty($tp_data['legal_description'])) {
                            echo $tp_data['legal_description'];
                        } else {
                            echo 'Refer to grant deed below.';
                        }
                        ?>
                    </div>

                    <div class="order-label">Vesting Information</div>
                    <div class="order-value" id="vestingInformation">
                        <?php
                        if (isset($tp_data['vesting_information']) && !empty($tp_data['vesting_information'])) {
                            echo $tp_data['vesting_information'];
                        } else {
                            echo 'Refer to grant deed below.';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Tax Information -->
            <div class="col-lg-6">
                <div class="order-card">
                    <div class="order-card-header">Tax Information</div>
                    <div class="row" id="taxInformation">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="installment-card">
                                <h4>1st Installment</h4>
                                <div id="firstInstallment">
                                    <?php
                                    if (isset($tp_data['first_installment']) && !empty($tp_data['first_installment'])) {
                                        $firstInstallment = json_decode($tp_data['first_installment'], true);
                                        ?>
                                        <p><strong>Balance:</strong> <?php echo isset($firstInstallment['Balance']) && !empty($firstInstallment['Balance']) ? $firstInstallment['Balance'] : '-'; ?></p>
                                        <p><strong>Amount:</strong> <?php echo isset($firstInstallment['Amount']) && !empty($firstInstallment['Amount']) ? $firstInstallment['Amount'] : '-'; ?></p>
                                        <p><strong>Due Date:</strong> <?php echo isset($firstInstallment['DueDate']) && !empty($firstInstallment['DueDate']) ? $firstInstallment['DueDate'] : '-'; ?></p>
                                        <p><strong>Number:</strong> <?php echo isset($firstInstallment['Number']) && !empty($firstInstallment['Number']) ? $firstInstallment['Number'] : '-'; ?></p>
                                        <p><strong>Payment Date:</strong> <?php echo isset($firstInstallment['PaymentDate']) && !empty($firstInstallment['PaymentDate']) ? $firstInstallment['PaymentDate'] : '-'; ?></p>
                                        <p><strong>Penalty:</strong> <?php echo isset($firstInstallment['Penalty']) && !empty($firstInstallment['Penalty']) ? $firstInstallment['Penalty'] : '-'; ?></p>
                                        <p><strong>Status:</strong> <?php echo isset($firstInstallment['Status']) && !empty($firstInstallment['Status']) ? $firstInstallment['Status'] : '-'; ?></p>
                                        <p><strong>Amount Paid:</strong> <?php echo isset($firstInstallment['AmountPaid']) && !empty($firstInstallment['AmountPaid']) ? $firstInstallment['AmountPaid'] : '-'; ?></p>
                                        <p><strong>Tax Year:</strong> <?php echo isset($firstInstallment['TaxYear']) && !empty($firstInstallment['TaxYear']) ? $firstInstallment['TaxYear'] : '-'; ?></p>
                                    <?php } else { ?>
                                        <span class="no-data-message">No data found.</span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="installment-card">
                                <h4>2nd Installment</h4>
                                <div id="secondInstallment">
                                    <?php
                                    if (isset($tp_data['second_installment']) && !empty($tp_data['second_installment'])) {
                                        $secondInstallment = json_decode($tp_data['second_installment'], true);
                                        ?>
                                        <p><strong>Balance:</strong> <?php echo isset($secondInstallment['Balance']) && !empty($secondInstallment['Balance']) ? $secondInstallment['Balance'] : '-'; ?></p>
                                        <p><strong>Amount:</strong> <?php echo isset($secondInstallment['Amount']) && !empty($secondInstallment['Amount']) ? $secondInstallment['Amount'] : '-'; ?></p>
                                        <p><strong>Due Date:</strong> <?php echo isset($secondInstallment['DueDate']) && !empty($secondInstallment['DueDate']) ? $secondInstallment['DueDate'] : '-'; ?></p>
                                        <p><strong>Number:</strong> <?php echo isset($secondInstallment['Number']) && !empty($secondInstallment['Number']) ? $secondInstallment['Number'] : '-'; ?></p>
                                        <p><strong>Payment Date:</strong> <?php echo isset($secondInstallment['PaymentDate']) && !empty($secondInstallment['PaymentDate']) ? $secondInstallment['PaymentDate'] : '-'; ?></p>
                                        <p><strong>Penalty:</strong> <?php echo isset($secondInstallment['Penalty']) && !empty($secondInstallment['Penalty']) ? $secondInstallment['Penalty'] : '-'; ?></p>
                                        <p><strong>Status:</strong> <?php echo isset($secondInstallment['Status']) && !empty($secondInstallment['Status']) ? $secondInstallment['Status'] : '-'; ?></p>
                                        <p><strong>Amount Paid:</strong> <?php echo isset($secondInstallment['AmountPaid']) && !empty($secondInstallment['AmountPaid']) ? $secondInstallment['AmountPaid'] : '-'; ?></p>
                                        <p><strong>Tax Year:</strong> <?php echo isset($secondInstallment['TaxYear']) && !empty($secondInstallment['TaxYear']) ? $secondInstallment['TaxYear'] : '-'; ?></p>
                                    <?php } else { ?>
                                        <span class="no-data-message">No data found.</span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grant Deed Information -->
        <div class="row mt-4" id="grantDeedInfo">
            <div class="col-12">
                <div class="order-card">
                    <div class="order-card-header d-flex">Grant Deed Information</div>
                    <?php
                    $cs4_result_id_status = isset($tp_data['cs4_message']) && !empty($tp_data['cs4_message']) ? $tp_data['cs4_message'] : '';
                    ?>
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div id="grantDeedInfoFile" class="d-flex">
                                <?php
                                $L_V_serviceId = isset($tp_data['cs4_service_id']) && !empty($tp_data['cs4_service_id']) ? $tp_data['cs4_service_id'] : '';
                                $instrumentNumber = isset($tp_data['cs4_instrument_no']) && !empty($tp_data['cs4_instrument_no']) ? $tp_data['cs4_instrument_no'] : '';
                                $state = isset($state) && !empty($state) ? $state : '';
                                $county = isset($county) && !empty($county) ? $county : '';
                                $recordedDate = isset($tp_data['cs4_recorded_date']) && !empty($tp_data['cs4_recorded_date']) ? $tp_data['cs4_recorded_date'] : '';

                                if (isset($instrumentNumber) && !empty($instrumentNumber)) {
                                    if (isset($recordedDate) && !empty($recordedDate)) {
                                        $time = strtotime($recordedDate);
                                        $year = date('Y', $time);
                                    }
                                    $count = substr_count($instrumentNumber, '-');
                                    if (isset($count) && !empty($count)) {
                                        $detailDocInfo = explode('-', $instrumentNumber);
                                        $docId = isset($detailDocInfo['1']) && !empty($detailDocInfo['1']) ? $detailDocInfo['1'] : '';
                                    } else {
                                        $docId = str_replace($year, '', $instrumentNumber);
                                    }
                                    $docId = (string) ((int) ($docId));
                                }

                                $file_number = isset($tp_data['file_number']) && !empty($tp_data['file_number']) ? $tp_data['file_number'] : '';
                                $fips = isset($tp_data['fips']) && !empty($tp_data['fips']) ? $tp_data['fips'] : '';
                                ?>
                                <?php if (isset($lv_file_url) && !empty($lv_file_url)) {
                                    if (env('AWS_ENABLE_FLAG') == 1) { ?>
                                        <a href="javascript:void(0);" class="btn btn-success btn-icon-split" onclick="downloadDocumentFromAws('<?php echo $lv_file_url; ?>', 'legal_vesting');">
                                            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                            <span class="text">Download L&V</span>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $lv_file_url; ?>" class="btn btn-success btn-icon-split" download="L&V.pdf">
                                            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                            <span class="text">Download L&V</span>
                                        </a>
                                    <?php } ?>
                                <?php } else if ($lpFileStatus == 'processing') { ?>
                                    <div class="processing-wrapper">
                                        <p>Document generation is under processing. Please refresh the page after some time or check your email.</p>
                                        <a href="javascript:void(0);" class="btn btn-info btn-icon-split" onclick="fetchLvDoc(this, '<?php echo $file_number; ?>', 'lv');">
                                            <span class="icon text-white-50"><i class="fas fa-sync-alt"></i></span>
                                            <span class="text">Click to fetch</span>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="no-data-message">
                                        <p>No legal vesting available. Our customer service will look for it and contact you shortly.</p>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="loader" style="display: none;"></div>
                        </div>

                        <div class="col-md-4 mb-3 mb-md-0">
                            <div id="instrumentInfoFile"  class="d-flex">
                                <?php if (isset($deed_file_url) && !empty($deed_file_url)) {
                                    if (env('AWS_ENABLE_FLAG') == 1) { ?>
                                        <a href="javascript:void(0)" class="btn btn-success btn-icon-split" onclick="downloadDocumentFromAws('<?php echo $deed_file_url; ?>', 'grant_deed');">
                                            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                            <span class="text">Download Grant Deed</span>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $deed_file_url; ?>" class="btn btn-success btn-icon-split" download="GrantDeed.pdf">
                                            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                            <span class="text">Download Grant Deed</span>
                                        </a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="no-data-message">
                                        <p>No grant deed available. Our customer service will look for it and contact you shortly.</p>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="loader" style="display: none;"></div>
                        </div>

                        <?php $apn = str_replace('0000', '0-000', $apn); ?>
                        <div class="col-md-4">
                            <div id="taxDocumentInfo"  class="d-flex">
                                <?php if (isset($tax_file_url) && !empty($tax_file_url)) {
                                    if (env('AWS_ENABLE_FLAG') == 1) { ?>
                                        <a href="javascript:void(0)" class="btn btn-success btn-icon-split" onclick="downloadDocumentFromAws('<?php echo $tax_file_url; ?>', 'tax');">
                                            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                            <span class="text">Download Tax Document</span>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $tax_file_url; ?>" class="btn btn-success btn-icon-split" download="Tax.pdf">
                                            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                                            <span class="text">Download Tax Document</span>
                                        </a>
                                    <?php } ?>
                                <?php } else if ($taxFileStatus == 'processing') {
                                    $tax_serviceId = isset($tp_data['cs3_service_id']) && !empty($tp_data['cs3_service_id']) ? $tp_data['cs3_service_id'] : '';
                                    ?>
                                    <div class="processing-wrapper">
                                        <p>Document generation is under processing. Please refresh the page after some time or check your email.</p>
                                        <button class="btn btn-info btn-icon-split" onClick="fetchLvDoc(this, '<?php echo $file_number; ?>', 'tax')">
                                            <span class="icon text-white-50"><i class="fas fa-sync-alt"></i></span>
                                            <span class="text">Click to fetch</span>
                                        </button>
                                    </div>
                                <?php } else { ?>
                                    <div class="no-data-message">
                                        <p>No tax document available. Our customer service will look for it and contact you shortly.</p>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="loader" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="action-card">
                    <div class="action-card-icon"><i class="fas fa-file-alt"></i></div>
                    <h3 class="action-card-title"><a href="<?php echo base_url() . 'cpl-dashboard'; ?>">Generate CPL</a></h3>
                    <p class="action-card-desc">Our customer service team is ready to help create a farm package to help you alert the neighbors about your new listing.</p>
                    <a class="btn btn-success btn-icon-split" href="<?php echo base_url() . 'cpl-dashboard'; ?>">
                        <span class="icon text-white-50"><i class="fas fa-seedling"></i></span>
                        <span class="text">Generate CPL</span>
                    </a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="action-card">
                    <div class="action-card-icon"><i class="fas fa-user-check"></i></div>
                    <h3 class="action-card-title"><a href="<?php echo base_url() . 'proposed-insured'; ?>">Proposed Insured</a></h3>
                    <p class="action-card-desc">Login to our PCT Title Toolbox program and create your own farm package consisting of the various types of owners.</p>
                    <a class="btn btn-success btn-icon-split" href="<?php echo base_url() . 'proposed-insured'; ?>">
                        <span class="icon text-white-50"><i class="fas fa-seedling"></i></span>
                        <span class="text">Generate Proposed</span>
                    </a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="action-card">
                    <div class="action-card-icon"><i class="fas fa-plus-circle"></i></div>
                    <h3 class="action-card-title"><a href="<?php echo base_url() . 'order'; ?>">Open New Order</a></h3>
                    <p class="action-card-desc">Need to open another order? That's fantastic. The link below will redirect you back to our Open Order form.</p>
                    <a class="btn btn-success btn-icon-split" href="<?php echo base_url() . 'order'; ?>">
                        <span class="icon text-white-50"><i class="fas fa-seedling"></i></span>
                        <span class="text">Create Order</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- CTA Banner -->
        <div class="cta-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3>We provide higher quality services</h3>
                    <p>And you'll get solutions for everything</p>
                </div>
                <div class="col-md-4 text-md-right">
                    <a class="btn mr-2 mb-2" href="https://clients.pacificcoasttitle.com/login.aspx?ReturnUrl=/&amp;officeid=1">Open Orders</a>
                    <a class="btn mb-2" href="rate-book.html">Get Rates</a>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
</script>

<?php // $this->load->view('layout/footer'); ?>
<script src="<?php echo base_url(); ?>assets/libs/jquery-1.12.4.min.js"></script>
<script>
    $(document).ready(function($){
        let data = {};
        data.state = "<?php echo $state ?>";
        data.county = "<?php echo $county ?>";
        data.property = "<?php echo $address ?>";
        data.order_id = "<?php echo $order_id ?>";
        data.file_number = "<?php echo $lpFileNumber ?>";
        data.escrow_id = "<?php echo $escrow_id ?>";
        console.log('data ==', data);
        if (data.file_number != '') {
            $.ajax({
                url: base_url + "pre-listing-doc",
                type: "post",
                data: data,
                async: false,
                success: function (response) {
                    if (response) {
                        console.log('response ==', response);
                    }
                }
            });
        }
    });

    function fetchLvDoc(obj, fileNumber, docType) {
        $(obj).html('<span class="text">Fetching...</span>');

        $.ajax({
            url: base_url + "check-document",
            type: "post",
            data: {
                file_number: fileNumber,
                doc_type: docType
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response && response.url) {
                    var buttonText = '';
                    var downloadButton = '';
                    var doc_type = '';
                    if (docType == 'tax') {
                        buttonText = 'Download Tax Document';
                        doc_type = 'tax';
                    } else {
                        buttonText = 'Download L & V';
                        doc_type = 'legal_vesting';
                    }
                    <?php if (env('AWS_ENABLE_FLAG') == 1) { ?>
                        let url = response.url;
                        downloadButton = "<a href='#' class='btn btn-success btn-icon-split' onclick='downloadDocumentFromAws(" + '"' + url + '"' + ", " + '"' + doc_type + '"' + ");'><span class='icon text-white-50'><i class='fas fa-download'></i></span><span class='text'>" + buttonText + "</span></a>";
                    <?php } else { ?>
                        downloadButton = '<a href="' + response.url + '" target="_blank" class="btn btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-download"></i></span><span class="text">' + buttonText + '</span></a>';
                    <?php } ?>
                    $(obj).closest('.processing-wrapper').replaceWith(downloadButton);
                } else {
                    $(obj).html('<span class="text">Click to Fetch</span>');
                    alert('Document generation still in process. Please try after sometime.');
                    return;
                }
            },
            complete: function (data) {
                if (data.status != 200) {
                    $(obj).html('<span class="text">Click to Fetch</span>');
                    alert('Document generation still in process. Please try after sometime.');
                    return;
                }
            }
        });
    }

    function downloadDocumentFromAws(url, documentType) {
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');
        var fileNameIndex = url.lastIndexOf("/") + 1;
        var filename = url.substr(fileNameIndex);
        $.ajax({
            url: base_url + "download-aws-document",
            type: "post",
            data: { url: url },
            async: false,
            success: function (response) {
                if (response) {
                    if (navigator.msSaveBlob) {
                        var csvData = base64toBlob(response, 'application/octet-stream');
                        var csvURL = navigator.msSaveBlob(csvData, filename);
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', documentType + "_" + filename);
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        document.body.removeChild(element);
                    } else {
                        console.log(response);
                        var csvURL = 'data:application/octet-stream;base64,' + response;
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', documentType + "_" + filename);
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        element.click();
                        document.body.removeChild(element);
                    }
                }
                $('#page-preloader').css('display', 'none');
            }
        });
    }
</script>