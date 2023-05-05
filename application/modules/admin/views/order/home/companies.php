<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
</style>
<div class="container-fluid">
    <div class="row mb-3">
		<div class="col-sm-4">
			<h1 class="h3 text-gray-800"> Companies </h1>
		</div>
		<div class="col-sm-8">
            <a href="<?php echo base_url()?>order/admin/add-company"  class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text"> Add Company </span> 
            </a>
            <a href="<?php echo base_url()?>order/admin/import-underwriters"  class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text"> Import Underwriter </span> 
            </a>
            <a href="javascript:void(0);" id="refresh-company-data"  class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-refresh"></i>
                </span>
                <span class="text"> Refresh </span> 
            </a>
            <a href="javascript:void(0);" data-export-type="csv" id="export_companies" class="btn btn-success btn-icon-split float-right mr-2"> 
                <span class="icon text-white-50">
                    <i class="fas fa-file-export"></i>
                </span>
                <span class="text"> Export </span> 
            </a>
		</div>
	</div>
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header datatable-header py-3">
            <div class="datatable-header-titles" > 
                <span>
                    <i class="fas fa-building"></i>
                </span>
                <h6 class="m-0 font-weight-bold text-primary pl-10">Companies</h6> 
            </div>
        </div>
     
        <div class="card-body">
            <?php if(!empty($success)) {?>
                <div class="w-100 alert alert-success alert-dismissible">
                    <?php echo $success;?>
                </div>
            <?php } 
                if(!empty($errors)) {?>
                    <div class="w-100 alert alert-success alert-dismissible">
                        <?php echo $errors;?>
                    </div>
            <?php } ?>
            <div id="companies_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="companies_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-companies-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Partner Company Id</th>
                            <th>Partner Company Name</th>
                            <th>Address</th>
                            <th>Loan Underwriter</th>
                            <th>Sales Underwriter</th>
                            <th>Deliverables</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
        
        <div class="modal fade" width="500px" id="deliverables_information" tabindex="-1" role="dialog" aria-labelledby="Lender Infromation" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="width:40%;">
                <div class="modal-content">
                    <form method="POST" action="<?php echo base_url();?>store-deliverables">
                        <div class="smart-forms smart-container wrap-2" style="margin:30px">
                            <div class="modal-body search-result">
                                <div id="deliverables-details-fields">
                                    <div class="spacer-b20">
                                        <div class="tagline"><span>Deliverables</span></div>
                                    </div>
                                    <div class="frm-row" id="clone_container">
										<div class="section colm colm12" id="clone-email-address" style="margin-bottom: 0px !important;">
                                            <div class="toclone clone-widget">
                                                <div class="spacer-b10">
                                                    <label class="field">
                                                        <input type="email" class="gui-input" name="AdditionalEmail[]"
                                                            id="AdditionalEmail" placeholder="Email Address">
                                                    </label>
                                                </div>
                                                <a id="clonea" href="#" class="clone button btn-primary"><i class="fa fa-plus"></i></a>
                                                <a href="#" class="delete button"><i class="fa fa-minus"></i></a>
                                            </div>
										</div>
									</div>
                                    <input type="hidden" id="partner_id" name="partner_id" value="">
                                </div>
                            </div>
                            <div class="form-footer" style="padding: 0px 1rem !important;">
                                <button type="submit" data-btntext-sending="Sending..."
                                    class="button btn-primary">Submit</button>
                                <button type="reset" data-dismiss="modal" aria-label="Close" class="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/smart-forms.css">
<script src="<?php echo base_url(); ?>assets/backend/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-cloneya.min.js"></script>

<script>
    jQuery(document).ready(function ($) {

        $('#clone-email-address').cloneya({
            maximum: 5
        }).on('after_append.cloneya', function (event, toclone, newclone) {
            var name = $(newclone).find("input[type='email']").attr('id');
        }).off('remove.cloneya').on('remove.cloneya', function (event, clone) {
            $(clone).slideToggle('slow', function () {
                $(clone).remove();
            })
        });
    });

    function addOrUpdateDeliverables(partner_id)
	{
		$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
		$('#page-preloader').css('display', 'block');
		$('#deliverables_information').modal('show');
        $('#partner_id').val(partner_id);
        $.ajax({
            url:base_url+"admin/order/home/getDeliverables",
            type: "POST",
            data: {
                partner_id: partner_id,
            },
            async: false,
            success: function(result) {
                $('#page-preloader').css('display', 'none');
                $('#borrower_page').css('opacity', '1');
                var res = jQuery.parseJSON(result);
                if (res.deliverables.length > 0) {
                    for (i = 0; i < res.deliverables.length; i++) {
                        if(i == 0) {
                            $('#AdditionalEmail').val(res.deliverables[i]);
                        } else {
                            $("#clonea")[0].click();
                        } 
                    }
                    for (i = 0; i < res.deliverables.length; i++) {
                        if(i != 0) {
                            var emailVal = res.deliverables[i];
                            $('#AdditionalEmail'+i).val(emailVal);
                        } 
                    }
                } 
            },
            error:function(){
                  
            },
        });
	}
</script>