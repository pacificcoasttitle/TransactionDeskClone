<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
.FilterOrderListing {
    width: 100%;
    display: flex;
}
</style>
<div class="container-fluid">
    <?php if(!empty($this->session->userdata('success'))){ ?>
        <div class="col-xs-12">
            <div class="alert alert-success"><?php echo $this->session->userdata('success'); ?></div>
        </div>
    <?php } ?>

    <?php if(!empty($error_msg)){ ?>
        <div class="col-xs-12">
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        </div>
    <?php } ?>
    <div id="lp_order_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
    <div id="lp_order_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            LP Document Types
            <div class="float-right">
                <a href="<?php echo base_url()?>order/admin/import-lp-document-types" class="btn btn-secondary"> Import </a>
                <a href="<?php echo base_url()?>order/admin/add-lp-document-types" class="btn btn-secondary"> Add LP Document Type </a>
            </div>
        </div>
                
        <div class="card-body">
            <div id="lp_document_types_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="lp_document_types_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-lp-document-types-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Code</th>
                            <th>Instrument Type</th>
                            <th>Is Subtype</th>
                            <th>Selected Subtype Code</th>
                            <th>Select Section</th>
                            <th>Is Display</th>
                            <th>Is Ves</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function isDisplayDocumentType()
{    
    $('input[type="checkbox"]').on('change', function() {
        $('body').animate({ opacity: 0.5 }, "slow");
        var lp_document_type_id = $(this).attr('id');
        if ($(this).is(":checked")) {
            var displayFlag = 1;
        } else {
            var displayFlag = 0;
        }
        $.ajax({
            url: base_url+"update-lp-document-type-flag",
            method: "POST",
            data : {
                lp_document_type_id: lp_document_type_id,
                displayFlag: displayFlag
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('body').animate({ opacity: 1.0 }, "slow");
                    $('#lp_document_types_success_msg').html(result.msg).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#lp_document_types_success_msg").offset().top
                    }, 1000);
                    lp_document_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#lp_document_types_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#lp_document_types_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#lp_document_types_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#lp_document_types_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#lp_document_types_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_document_types_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#lp_document_types_error_msg').html('').hide();
                }, 4000);
            }
        });
    });
}

function isVesDocumentType()
{    
    $('input[type="checkbox"]').on('change', function() {
        $('body').animate({ opacity: 0.5 }, "slow");
        var lp_document_type_id = $(this).attr('id');
        if ($(this).is(":checked")) {
            var isVesFlag = 1;
        } else {
            var isVesFlag = 0;
        }
        $.ajax({
            url: base_url+"update-lp-document-is-ves-type-flag",
            method: "POST",
            data : {
                lp_document_type_id: lp_document_type_id,
                isVesFlag: isVesFlag
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                if (result.status == 'success') {
                    $('body').animate({ opacity: 1.0 }, "slow");
                    $('#lp_document_types_success_msg').html(result.msg).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#lp_document_types_success_msg").offset().top
                    }, 1000);
                    lp_document_list.ajax.reload( null, false );
                    setTimeout(function () {
                        $('#lp_document_types_success_msg').html('').hide();
                    }, 4000);
                } else {
                    $('#lp_document_types_error_msg').html(result.message).show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#lp_document_types_error_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#lp_document_types_error_msg').html('').hide();
                    }, 4000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#lp_document_types_error_msg').html('Something went wrong. Please try it again.').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#lp_document_types_success_msg").offset().top
                }, 1000);

                setTimeout(function () {
                    $('#lp_document_types_error_msg').html('').hide();
                }, 4000);
            }
        });
    });
}

function updateDocumentSection(id, section) {
		$('body').animate({
			opacity: 0.5
		}, "slow");
		$.ajax({
			url: base_url + "order/admin/update-doc-section",
			method: "POST",
			data: {
				id: id,
				section: section
			},
			success: function (data) {
				var result = jQuery.parseJSON(data);
				if (result.status == 'success') {
					$('body').animate({
						opacity: 1.0
					}, "slow");
					$('#lp_order_success_msg').html(result.msg).show();
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#lp_order_success_msg").offset().top
					}, 1000);
					companies_list.ajax.reload(null, false);
					setTimeout(function () {
						$('#lp_order_success_msg').html('').hide();
					}, 4000);
				} else {
					$('#lp_order_error_msg').html(result.message).show();
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#lp_order_error_msg").offset().top
					}, 1000);

					setTimeout(function () {
						$('#lp_order_error_msg').html('').hide();
					}, 4000);
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				$('#lp_order_error_msg').html('Something went wrong. Please try it again.').show();
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#lp_order_error_msg").offset().top
				}, 1000);

				setTimeout(function () {
					$('#lp_order_error_msg').html('').hide();
				}, 4000);
			}
		});
	}
</script>