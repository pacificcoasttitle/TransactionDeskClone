<style>
/* CPL page – same design tokens as dashboard */
.pct-cpl-modern {
    --pct-primary: #1e5f8a;
    --pct-primary-light: #2d7ab5;
    --pct-primary-soft: #e8f2f8;
    --pct-surface: #ffffff;
    --pct-surface-2: #f8fafc;
    --pct-text: #1e293b;
    --pct-text-muted: #64748b;
    --pct-border: #e2e8f0;
    --pct-radius: 12px;
    --pct-radius-sm: 8px;
    --pct-shadow: 0 1px 3px rgba(0,0,0,.06);
    font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
    background: var(--pct-surface-2);
    padding-bottom: 2rem;
}
.pct-cpl-modern .ui-autocomplete { position: absolute; cursor: default; z-index: 10000 !important; max-height: 300px !important; overflow: hidden !important; }
.pct-cpl-modern .radio { top: 2px !important; margin: 0 0.5rem 0 0 !important; }
.pct-cpl-modern .radio:before { background: none !important; }
.pct-cpl-modern .fs-2 { font-size: 0.9375rem; }
.pct-cpl-modern .mt-0 { margin-top: 0; }

/* Section headings (taglines) */
.pct-cpl-modern .form-grp-title { margin-top: 1.5rem; margin-bottom: 1rem; }
.pct-cpl-modern .form-grp-title .tagline {
    height: 0;
    border-top: 1px solid var(--pct-border);
    text-align: left;
    margin: 0;
}
.pct-cpl-modern .form-grp-title .tagline span {
    display: inline-block;
    position: relative;
    padding: 0 0.75rem 0 0;
    background: var(--pct-surface);
    color: var(--pct-primary);
    top: -0.65em;
    font-size: 0.8125rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

/* Card */
.pct-cpl-modern .card.shadow.mb-4 {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
}
.pct-cpl-modern .card-header.datatable-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-cpl-modern .card-header.datatable-header h6 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
    margin: 0;
}
.pct-cpl-modern .card-header .pl-10 { padding-left: 0.5rem; }
.pct-cpl-modern .card-body { padding: 1.25rem; }

/* Table – same as dashboard */
.pct-cpl-modern #cpl_listing thead th {
    background: var(--pct-surface-2);
    color: var(--pct-text);
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    border-bottom: 1px solid var(--pct-border);
    padding: 0.875rem 1rem;
}
.pct-cpl-modern #cpl_listing tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
}
.pct-cpl-modern #cpl_listing tbody tr:hover td { background: var(--pct-surface-2); }

/* Pagination – same as dashboard */
.pct-cpl-modern .dataTables_wrapper { padding-top: 0.75rem; }
.pct-cpl-modern .dataTables_wrapper .row:last-child {
    align-items: center;
    padding: 0.75rem 0;
    border-top: 1px solid var(--pct-border);
    margin-top: 0.5rem;
}
.pct-cpl-modern .dataTables_info { font-size: 0.8125rem; color: var(--pct-text-muted); font-weight: 500; }
.pct-cpl-modern .dataTables_paginate ul.pagination {
    margin: 0 !important;
    gap: 0.25rem;
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: flex-end;
}
.pct-cpl-modern .dataTables_paginate .page-item .page-link {
    min-width: 2rem; height: 2rem;
    padding: 0 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--pct-text);
    background: var(--pct-surface);
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.pct-cpl-modern .dataTables_paginate .page-item .page-link:hover {
    background: var(--pct-surface-2);
    border-color: var(--pct-primary-soft);
    color: var(--pct-primary);
}
.pct-cpl-modern .dataTables_paginate .page-item.active .page-link {
    background: var(--pct-primary);
    border-color: var(--pct-primary);
    color: #fff;
}
.pct-cpl-modern .dataTables_paginate .page-item.disabled .page-link {
    background: var(--pct-surface-2);
    color: var(--pct-text-muted);
    border-color: var(--pct-border);
    opacity: 0.8;
}

/* Alerts */
.pct-cpl-modern .alert { border-radius: var(--pct-radius-sm); font-size: 0.875rem; }
.pct-cpl-modern .alert-success { border-color: #a7f3d0; }
.pct-cpl-modern .alert-danger { border-color: #fecaca; }

/* Form in modal – same as home/dashboard */
.pct-cpl-modern .form-control {
    padding: 0.5rem 0.75rem;
    font-size: 0.9375rem;
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    color: var(--pct-text);
    background: var(--pct-surface);
}
.pct-cpl-modern .form-control:focus {
    border-color: var(--pct-primary-soft);
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}
.pct-cpl-modern .col-form-label { font-size: 0.875rem; font-weight: 500; color: var(--pct-text); margin-bottom: 0.25rem; }
.pct-cpl-modern .form-group { margin-bottom: 1rem; }
.pct-cpl-modern .btn { font-weight: 500; font-size: 0.875rem; border-radius: var(--pct-radius-sm); }
.pct-cpl-modern .btn-success { background: #059669; border-color: #059669; color: #fff; }
.pct-cpl-modern .btn-success:hover { background: #047857; border-color: #047857; color: #fff; }
.pct-cpl-modern .btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
.pct-cpl-modern .btn-danger:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }
.pct-cpl-modern .btn-icon-split .text { font-size: 0.75rem; padding: 0.4rem 4px; }

/* Modal – scoped so it works outside .pct-cpl-modern */
#lender_information .modal-content { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
#lender_information .card { border: none; box-shadow: none; }
#lender_information .card-body { padding: 1rem 1.25rem; }
#lender_information .form-control {
    padding: 0.5rem 0.75rem;
    font-size: 0.9375rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #1e293b;
    background: #fff;
}
#lender_information .form-control:focus {
    border-color: #e8f2f8;
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}
#lender_information .col-form-label { font-size: 0.875rem; font-weight: 500; color: #1e293b; margin-bottom: 0.25rem; }
#lender_information .form-grp-title .tagline span { color: #1e5f8a; font-size: 0.8125rem; font-weight: 600; background: #fff; }
#lender_information .form-grp-title .tagline { border-top-color: #e2e8f0; }
#lender_information .btn-success { background: #059669; border-color: #059669; color: #fff; }
#lender_information .btn-danger { background: #dc2626; border-color: #dc2626; color: #fff; }
</style>

<div class="pct-cpl-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
	<div class="container-fluid px-4 py-4">
		<div class="row mb-4">
			<div class="col-12">
				<h1 class="pct-page-title" style="font-size:1.5rem;font-weight:600;color:#1e293b;margin-bottom:0;">Closing Protection Letters</h1>
			</div>
		</div>
		<div class="card shadow mb-4">
			<div class="card-header datatable-header">
				<div class="datatable-header-titles">
					<span><i class="fas fa-file"></i></span>
					<h6 class="m-0 font-weight-bold text-primary pl-10">Generate your CPL</h6>
				</div>
			</div>
			<div class="card-body">
				<?php if (!empty($success)) { ?>
				<div id="agent_success_msg" class="w-100 alert alert-success alert-dismissible">
					<?php foreach ($success as $sucess) {
        echo $sucess . "<br \>";
    }?>
				</div>
				<?php

}
if (!empty($errors)) {
    ?>
				<div id="agent_error_msg" class="w-100 alert alert-danger alert-dismissible">
					<?php foreach ($errors as $error) {
        echo $error . "<br \>";
    }?>
				</div>
				<?php

}?>
				<div class="table-responsive">
					<table class="table table-bordered" id="cpl_listing" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>#</th>
								<th>File Number</th>
								<th>Property Address</th>
								<th>Created</th>
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
</div>

<div class="modal fade" width="500px" id="lender_information" tabindex="-1" role="dialog" aria-labelledby="Lender Infromation" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="width:40%;">
		<div class="modal-content">
			<form method="POST" action="<?php echo base_url(); ?>add-lender-order" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-12">
						<div class="card shadow">
							<!-- <div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary" >Lender Details</h6>
							</div> -->
							<div class="card-body">
								<div class="smart-forms smart-container">
									<div class="modal-body search-result">
										<div class="row form-grp-title mt-0">
											<div class="col-sm-12">
												<div class="tagline"><span> LENDER DETAILS </span></div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-8 d-flex fs-2">
													<!-- <label for="email_id" class="col-form-label">Email</label> -->
													<input class="radio" type="radio" name="new_existing_lender" id="add_lender" value="add_lender">New Lender
													<input class="radio" type="radio" name="new_existing_lender" id="existing_lender" value="existing_lender">Existing Lender
													<!-- <input name="email_id" required="" type="email" class="form-control" id="email_id"> -->
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<label for="LenderCompany" class="col-form-label">Lender Company</label>
													<input type="text" name="LenderCompany" id="LenderCompany" class="form-control gui-input ui-autocomplete-input" placeholder="Lender Company Name" required="required">
													<input type="hidden" name="LenderId" id="LenderId" value="">
													<input type="hidden" name="LenderCompanyLookupCode" id="LenderCompanyLookupCode" value="">
													<input type="hidden" name="LenderCompanyId" id="LenderCompanyId" value="">
													<input type="hidden" name="file_id" id="file_id" value="">
													<input type="hidden" name="order_id" id="order_id" value="">
													<input type="hidden" name="partner_id" id="partner_id" value="">
													<!-- <input required="" name="first_name" type="text" id="first-name" class="form-control"> -->
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
													<label for="assignment_clause" class="col-form-label">Assignment Clause</label>
													<input type="text" name="assignment_clause" id="assignment_clause" class="form-control gui-input ui-autocomplete-input" placeholder="Assignment Clause">
													<!-- <input required="" name="last_name" type="text" id="last-name" class="form-control"> -->
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<label for="LenderName" class="col-form-label">Lender Name</label>
													<input type="text" name="LenderName" id="LenderName" class="gui-input form-control" placeholder="Attention" autocomplete="off">
												</div>

											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label for="LenderAddress" class="col-form-label">Lender Address</label>
													<input type="text" name="LenderAddress" id="LenderAddress" class="gui-input form-control" placeholder="Lender Address" required="required">
												</div>
												<div class="col-sm-6">
													<label for="LenderCity" class="col-form-label">Lender City</label>
													<input type="text" name="LenderCity" id="LenderCity" class="gui-input form-control" placeholder="Lender City" required="required">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label for="LenderState" class="col-form-label">Lender State</label>
													<input type="text" name="LenderState" id="LenderState" class="gui-input form-control" placeholder="Lender State">
												</div>
												<div class="col-sm-6">
													<label for="LenderZipcode" class="col-form-label">Lender Zipcode</label>
													<input type="text" name="LenderZipcode" id="LenderZipcode" class="gui-input form-control" placeholder="Lender Zipcode" required="required">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row form-grp-title">
												<div class="col-sm-12">
													<div class="tagline"><span> PROPERTY ADDRESS </span></div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<label for="property_address" class="col-form-label">Property Address</label>
													<input required="required" type="text" class="gui-input form-control" name="property_address" id="property_address" placeholder="Property Address">
												</div>
												<div class="col-sm-6">
													<label for="property_city" class="col-form-label">Property City</label>
													<input type="text" name="property_city" id="property_city" class="gui-input form-control" placeholder="Property City" required="required">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<label for="property_state" class="col-form-label">Property State</label>
													<input type="text" name="property_state" id="property_state" class="gui-input form-control" placeholder="Property State" required="required">
												</div>
												<div class="col-sm-6">
													<label for="property_zipcode" class="col-form-label">Property Zipcode</label>
													<input type="text" name="property_zipcode" id="property_zipcode" class="gui-input form-control" placeholder="Property Zipcode" required="required">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row form-grp-title">
												<div class="col-sm-12">
													<div class="tagline"><span> LOAN DETAILS </span></div>
												</div>
											</div>
											<div class="row loan_number_in">
												<div class="col-sm-12">
													<label for="loan_number" class="col-form-label">Loan Number</label>
													<input required="required" type="text" class="gui-input form-control" name="loan_number" id="loan_number" placeholder="Loan Number">
												</div>
											</div>

											<!-- <div class="row sales_amount_in">
												<div class="col-sm-12">
													<label for="sales_amount" class="col-form-label">Sale Amount</label>
													<input type="number" class="gui-input form-control" min="1" name="sales_amount" id="sales_amount" placeholder="Sale Amount">
												</div>
											</div>

											<div class="row loan_amount_in">
												<div class="col-sm-12">
													<label for="loan_amount" class="col-form-label">Loan Amount</label>
													<input type="number" class="gui-input form-control" min="1" name="loan_amount" id="loan_amount" placeholder="Loan Amount">
												</div>
											</div> -->
										</div>

										<div class="form-group">
											<div class="row form-grp-title">
												<div class="col-sm-12">
													<div class="tagline"><span> BORROWERS & VESTING </span></div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
													<label for="borrowers_vesting" class="col-form-label">Primary Borrower Name</label>
													<input type="text" name="borrowers_vesting" id="borrowers_vesting" class="gui-input form-control" placeholder="Primary Borrower Name"  required="required">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row form-grp-title">
												<div class="col-sm-12">
													<div class="tagline"><span> SELECT BRANCH </span></div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
													<label for="branch" class="col-form-label">Select Branch</label>
													<select id="branch" name="branch" class="form-control">
														<option value="">Select Branch</option>
													</select>
												</div>
											</div>
										</div>

									</div>
									<input type="hidden" id="cpl_api" name="cpl_api" value="">
									<div class="form-footer" style="padding: 0px 1rem !important;">

										<button type="submit" data-btntext-sending="Sending..." class="btn btn-success btn-icon-split btn-sm">
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