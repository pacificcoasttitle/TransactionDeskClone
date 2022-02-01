<div class="container-fluid">	
	<div class="row mb-3">
		<div class="col-sm-6">
			<h1 class="h3 text-gray-800">Incident Reports</h1>
		</div>
		<!-- <div class="col-sm-6">
            <a href="#" class="btn btn-success btn-icon-split float-right">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">Add Incident Report</span>
            </a>
		</div> -->
	</div>

    <?php if(!empty($success)) {?>
        <a href="#" class="btn btn-success btn-block mt-1 mb-3"><?php echo $success;?></a>
    <?php }   
    if(!empty($errors)) {?>
        <a href="#" class="btn btn-danger btn-block mt-1 mb-3"><?php echo $errors;?></a>
    <?php } ?>

	<div id="incident_reports_success_msg" class="btn btn-success btn-block mt-1 mb-3" style="display:none;"></div>
	<div id="incident_reports_error_msg" class="btn btn-danger btn-block mt-1 mb-3" style="display:none;"></div>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Incident Reports Listing</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="incident_reports" width="100%" cellspacing="0">
					<thead>
						<tr>
                            <th>No</th>
                            <th>Employee #</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Reason</th>
                            <th>Num Of Incident</th>
                            <th>Incident Actions</th>
							<th>Status</th>
                            <th>Actions</th>
						</tr>
					</thead>

					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>


<div class="modal fade" width="500px" id="approve_deny_popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:40%;">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url();?>hr/approve-deny-request" enctype="multipart/form-data">
                <div class="smart-forms smart-container wrap-2" style="margin:30px">
                    <div class="modal-body search-result">
                        <div id="lender-details-fields">
                            <div class="spacer-b20">
                                <div class="tagline"><span id="approve_deny_title"></span></div>
                            </div>
                            <div class="frm-row">
                                <div class="section colm colm12">
                                    <label class="field prepend-icon" id="approve_deny_msg">
                                       
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="request_type" name="request_type" value="incident_report">
                    <input type="hidden" id="request_id" name="request_id" value="">
                    <input type="hidden" id="status" name="status" value="">
                    <div class="" style="padding: 0px 25px 20px;">
                        <button type="submit" data-btntext-sending="Sending..."
                            class="button btn-primary">Yes </button>
                        <button type="reset" data-dismiss="modal" aria-label="Close" class="button">No</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




