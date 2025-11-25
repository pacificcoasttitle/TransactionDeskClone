<style>


.fs-2 {
    font-size: 20px;
	margin-bottom: 3rem;
    color: #3c6997;
    font-weight: 600;
}
.fs-1-half {
	font-size: 15px;
}
.text-center {
	text-align: center;
}
.anchor-hover {
	position: absolute;
    z-index: 1;
    height: 100%;
    top: 0;
    width: 100%;
}
.padding-0 {
	padding: 0;
}
.dashboard-menu-icon {
	height: 5rem;
}
.main-wrapper {
	scale: 95%;
}
.card_title {
	font-size: 25px;
	padding-top: 20px;
}
.main-title {
	margin-bottom: 3rem;
    color: #3c6997;
    font-weight: 600;
}
.dashboard-wrap {
	background-image: url(/../../assets/frontend/images/NewBG.jpg);
    background-repeat: no-repeat;
    background-size: contain;
    width: 100%;
    height: auto;
}
#aiPrelimSummary .card-body {
    padding: 0.5px 1.25rem;
}

.prelim-summary-btn {
    background: #FF8A65;
    color: #fff;
}

.prelim-summary-btn:hover {
    background: #FF7043;
    color: #fff;
}
.btn-icon-split .text {
    font-size: 11px;
    padding: .575rem 3px;
}

.update-prelim-btn {
    background-color: #B0BEC5 !important;
    border-color: #B0BEC5 !important;
    color: #fff !important;
}

.updated-prelim-btn {
    background-color: #f26b2b  !important;
    border-color: #f26b2b  !important;
    color: #fff !important;
}

.info-prelim-btn {
    background-color: #03374f !important;
    border-color: #03374f !important;
    color: #fff !important;
}

.action-prelim-btn {
    background-color: #ECEFF1 !important;
    border-color: #ECEFF1 !important;
    color: #000 !important;
    display: flex;
    align-items: center;
}

.dropdown .click-action-type {
    color: #222222;
    text-decoration: none;
    padding: 0px;
}

.caret {
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 3px;
    vertical-align: middle;
    border-top: 3px dashed;
    border-top: 3px solid;
    border-right: 3px solid transparent;
    border-left: 3px solid transparent;
}

.dropdown-menu {
    margin-top: 0px !important
}
.dropdown-menu > li > a {
    padding: 5px 0px 5px 0px;
    display: block;
    /* padding: 10px 20px; */
    clear: both;
    font-weight: normal;
    line-height: 1;
    color: #333333;
    white-space: nowrap;
}
.dropdown-toggle::after {
    border-top: none;
}
</style>

<div class="container-fluid p-5 main-wrapper">
	<div class="row">
		<div class="col-md-12">
			<div class="typography-section__innera">
				<h2 class="ui-title-block ui-title-block_light mb-3 main-title">Welcome Back <?php echo $name; ?>,</h2>
				<div class="ui-decor-1a bg-accent"></div>
				<p class="ui-title-block_light fs-2">How can we help you today?</p>
			</div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-md-4 col-sm-12">
			<div class="card shadow h-100 py-2" style="border-left: 0.25rem solid #3c6997!important;border-radius: 5px;">
				<div class="card-body">
					<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
						<div class="col-auto">
							<img class="dashboard-menu-icon" src="<?php echo base_url(); ?>assets/frontend/images/New@2x.png">
						</div>
						<div class="col mr-2 mt-3">
							<div class="text-xl font-weight-bold text-uppercase mb-1 card_title" style="color: #3c6997;">New Title Order</div>
						</div>
					</div>
				</div>
				<a href="<?php echo base_url() . 'order'; ?>" class="anchor-hover"></a>
			</div>
		</div>

		<div class="col-md-4 col-sm-12">
			<div class="card shadow h-100 py-2" style="border-left:.25rem solid #3c6997!important;border-radius: 5px;">
				<div class="card-body">
					<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
						<div class="col-auto">
							<img class="dashboard-menu-icon" src="<?php echo base_url(); ?>assets/frontend/images/CPL@2x.png">
						</div>
						<div class="col mr-2 mt-3">
							<div class="text-xl font-weight-bold  text-uppercase mb-1 card_title" style="color:#3c6997;">Generate CPL</div>
						</div>
					</div>
				</div>
				<a href="<?php echo base_url() . 'cpl-dashboard'; ?>" class="anchor-hover"></a>
			</div>
		</div>

		<div class="col-md-4 col-sm-12">
			<div class="card shadow h-100 py-2" style="border-left:.25rem solid #3c6997!important;border-radius: 5px;">
				<div class="card-body">
					<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
						<div class="col-auto">
							<img class="dashboard-menu-icon" src="<?php echo base_url(); ?>assets/frontend/images/Proposed@2x.png">
						</div>
						<div class="col mr-2 mt-3">
							<div class="text-xl font-weight-bold  text-uppercase mb-1 card_title" style="color:#3c6997;">Proposed</div>
						</div>
					</div>
				</div>
				<a href="<?php echo base_url() . 'proposed-insured'; ?>" class="anchor-hover"></a>
			</div>
		</div>
	</div>

	<div class="row mt-3 mb-4">
		<div class="col-md-4 col-sm-12">
			<div class="card shadow h-100 py-2" style="border-left:.25rem solid #3c6997!important;border-radius: 5px;">
				<div class="card-body">
					<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
						<div class="col-auto">
							<img class="dashboard-menu-icon" src="<?php echo base_url(); ?>assets/frontend/images/Fees@2x.png">
						</div>
						<div class="col mr-2 mt-3">
							<div class="text-xl font-weight-bold  text-uppercase mb-1 card_title" style="color:#3c6997;">Fee Estimate</div>
						</div>
					</div>
				</div>
				<a href="<?php echo base_url() . 'fees'; ?>" class="anchor-hover"></a>
			</div>
		</div>

		<div class="col-md-4 col-sm-12">
			<div class="card shadow h-100 py-2" style="border-left:.25rem solid #3c6997!important;border-radius: 5px;">
				<div class="card-body">
					<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
						<div class="col-auto">
							<img class="dashboard-menu-icon" src="<?php echo base_url(); ?>assets/frontend/images/Prelim@2x.png">
						</div>
						<div class="col mr-2 mt-3">
							<div class="text-xl font-weight-bold  text-uppercase mb-1 card_title" style="color:#3c6997;">Review Prelim</div>
						</div>
					</div>
				</div>
				<a href="<?php echo base_url() . 'prelim-files'; ?>" class="anchor-hover"></a>
			</div>
		</div>

		<div class="col-md-4 col-sm-12">
			<div class="card shadow h-100 py-2"  style="border-left:.25rem solid #3c6997!important;border-radius: 5px;">
				<div class="card-body">
					<div class="row no-gutters align-items-center" style="flex-direction: column; text-align: center;" >
						<div class="col-auto">
							<img class="dashboard-menu-icon" src="<?php echo base_url(); ?>assets/frontend/images/Upload@2x.png">
						</div>
						<div class="col mr-2 mt-3">
							<div class="text-xl font-weight-bold  text-uppercase mb-1 card_title" style="color:#3c6997;">Get Policy</div>
						</div>
					</div>
				</div>
				<a href="<?php echo base_url() . 'policy-orders'; ?>" class="anchor-hover"></a>
			</div>
		</div>
	</div>

<!-- <section class="section-type-4a section-default typography-section-border" style="padding-bottom:0px;">
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__innera">
						<h2 class="ui-title-block ui-title-block_light">Welcome Back <?php echo $name; ?>,</h2>
						<div class="ui-decor-1a bg-accent"></div>
						<h3 class="ui-title-block_light">How can we help you today?</h3>
					</div>
					<div class="typography-sectiona">
						<div class="col-md-12">
							<a href="<?php echo base_url() . 'order'; ?>">
								<button class="btn1 btn-type-1a btn-lg" type="button">New Title Order</button>
							</a>
							<a href="<?php echo base_url() . 'cpl-dashboard'; ?>">
								<button class="btn1 btn-type-1b btn-lg" type="button">Generate CPL</button>
							</a>
							<a href="<?php echo base_url() . 'proposed-insured'; ?>">
								<button class="btn1 btn-type-1e btn-lg" type="button">Proposed</button>
							</a>
						</div>
					</div>

					<div class="typography-sectionc">
						<div class="col-md-12">
							<?php if (isset($is_master) && empty($is_master)) {?>
								<a href="<?php echo base_url() . 'fees'; ?>">
									<button class="btn1 btn-type-1g btn-lg" type="button">Fee Estimate</button>
								</a>
							<?php }?>
							<a href="<?php echo base_url() . 'prelim-files'; ?>">
								<button class="btn1 btn-type-1c btn-lg" type="button">Review Prelim</button>
							</a>
							<a href="<?php echo base_url() . 'upload-doc-orders'; ?>">
								<button class="btn1 btn-type-1d btn-lg" type="button">Upload Doc</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->

<section class="section-type-4a section-defaulta mt-5" style="padding-bottom:0px;">
	<div class="container-fluid padding-0">
		<div class="row mb-3">
			<div class="col-sm-12">
				<h1 class="h3 text-gray-800 text-center">Recent Orders </h1>
			</div>
		</div>
		<div class="card shadow mb-4">
			<div class="card-header datatable-header py-3">
				<div class="datatable-header-titles" >

					<h6 class="m-0 font-weight-bold text-primary pl-10">Below are all your orders</h6>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<div id="order_listing_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
					<div id="order_listing_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
					<table class="table table-bordered" id="order_listing" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>No</th>
								<th>Order No</th>
								<th>Status</th>
								<th>Opened</th>
								<th>Property Address</th>
								<!-- <th>Buyer/Seller</th> -->
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>

<!-- <section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-xs-12">
					<div class="typography-section__inner">
						<h2 class="ui-title-block ui-title-block_light text-center">Recent Orders,</h2>
						<div class="ui-decor-1a bg-accent"></div>
						<h3 class="ui-title-block_light fs-1-half text-center">Below are all your orders.</h3>
					</div>
					<div class="typography-sectiona">
						<div class="col-md-12">
							<div class="table-container">
								<table class="table table-type-3 typography-last-elem" id="order_listing">
									<thead>
										<tr>
											<th>No</th>
											<th>#</th>
											<th>Status</th>
											<th>Opened</th>
											<th>Property Address</th>
											<th>Buyer/Seller</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->
</div>

<div class="modal fade" id="sendInviteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<form id="inviteForm">
				<div class="row">
					<div class="col-lg-12">
						<div class="card shadow">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary" >Send Invite to Borrower</h6>
							</div>
							<div class="card-body">
								<div class="smart-forms smart-container">
									<div class="modal-body search-result">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label for="borrower_email" class="col-form-label">Email</label>
													<input type="email" name="borrower_email" id="borrower_email" class="form-control gui-input ui-autocomplete-input" placeholder="Email">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label for="borrower_name" class="col-form-label">Name</label>
													<input type="text" name="borrower_name" id="borrower_name" class="gui-input form-control" placeholder="Attention" autocomplete="off">
												</div>
											</div>
										</div>
									</div>
									<div class="form-footer" style="padding: 0px 1rem !important;">

										<button type="button" id="sendInviteBtn" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-check"></i>
											</span>
											<span class="text">Send</span>
										</button>

										<button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-ban"></i>
											</span>
											<span class="text">Cancel</span>
										</button>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="modal-header">
					<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Send Invite to Borrower</h4>
				</div>
				<div class="modal-body search-result">
					<div class="error-cotent"></div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="borrower_email">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="borrower_email" name="borrower_email"
										placeholder="Email" required="" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="borrower_name">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="borrower_name" name="borrower_name"
										placeholder="Email" />
								</div>
								<input type="hidden" id="invite_order_id" name="invite_order_id">
								<input type="hidden" id="property_address" name="property_address">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger" id="sendInviteBtn">Send</button>
				</div> -->
			</form>
		</div>
	</div>
</div>

<div class="modal" id="contactsModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary" >Contacts</h6>
				</div>
				
				<div class="card-body"> 
					<div class="table-responsive">
						<table class="table table-bordered" id="tbl-contacts-data" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Type</th>
									<th>Company Name</th>
									<th>Name</th>
									<th>Email Address</th>
								</tr>
							</thead>            
							<tbody></tbody>
						</table>
					</div>
					<div class="form-footer">
						<button type="reset" data-dismiss="modal" aria-label="Close" class="btn-danger btn-icon-split btn-sm">
							<span class="icon text-white-50">
								<i class="fas fa-ban"></i>
							</span>
							<span class="text">Close</span>
						</button>
						<!-- <button type="button" class="btn btn-success" data-dismiss="modal" >Close</button> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" width="1200px" id="revenue_model" tabindex="-1" role="dialog"
    aria-labelledby="Revenue Information" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:100%;height:auto;">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Revenue Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="smart-forms smart-container">
                                    <div class="search-result">
                                        <div id="deliverables-details-fields">
                                            <div class="frm-row" id="clone_container">
                                                <div class="section colm colm12" id="clone-email-address"
                                                    style="margin-bottom: 0px !important;">
                                                    <div class="toclone">
                                                        <div class="spacer-b10">
                                                            <label class="field" id="revenue_container">
															
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" width="500px" id="note_information" tabindex="-1" role="dialog" aria-labelledby="Create a Note" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="width:40%;">
		<div class="modal-content">
			<form method="POST" action="" enctype="multipart/form-data" id="prelim_add_note_form" >
				<div class="row">
					<div class="col-lg-12">
						<div class="card shadow">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary" >Add a Note</h6>
							</div>
							<div class="card-body"> 
								<div class="smart-forms smart-container">
									<div class="search-result">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<label for="note_subject" class="col-form-label">Subject</label>
													<input type="text" name="note_subject" id="note_subject" class="form-control gui-input ui-autocomplete-input" placeholder="Subject" required="">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<label for="note" class="col-form-label">Note</label>
													<textarea name="note" id="note" class="gui-input form-control" rows="4" placeholder="Note" autocomplete="off" required=""></textarea>
												</div>
											</div>
										</div>

										<div class="form-group">
                                            <label for="recorded_date" class="col-form-label">Upload File</label>
                                            <input required="" name="file_upload" type="file" id="file_upload" class="form-control" accept="application/pdf">
                                        </div>
                                        <input type="hidden" name="upload_file_id" id="upload_file_id" value="">
                                        <input type="hidden" name="document_name" id="document_name" value="">
                                        <input type="hidden" name="order_id" id="order_id" value="">
									</div>

									<div class="form-footer" style="padding: 0px 1rem !important;">
										<button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm prelim_add_note_form_submit">
											<span class="icon text-white-50">
												<i class="fas fa-check"></i>
											</span>
											<span class="text">Submit</span>
										</button>

										<button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-ban"></i>
											</span>
											<span class="text">Cancel</span>
										</button>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" width="800px" id="aiPrelimSummary" tabindex="-1" role="dialog"
	aria-labelledby="Ai Prelim Summary" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="width:65%; max-width: 1200px">
		<div class="modal-content">
			<div class="row">
				<div class="col-lg-12">
					<div class="card shadow">
						<div class="modal-header">
							<h4 class="modal-title"><strong>Prelim Summary</strong></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="card-body"> 
							<div class="row mb-1">
								<div class="col-md-8">
									<span><strong>Property Address:</strong> <span id="prelim_property" ></span></span>
								</div>
								<div class="col-md-4">
									<span><strong>File Name:</strong> <span id="prelim_file_number" ></span></span>
								</div>
							</div>
							<div class="typography-section__inner">
								<div style="border-bottom: 4px solid #D35411;"></div>
							</div>
							<div class="smart-forms smart-container prelim_summary">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
