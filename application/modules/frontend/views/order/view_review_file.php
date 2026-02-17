<style> 
    .pct-page-modern .section-type-4a .btn {
        margin-top: unset;
        margin-right: unset;
        margin-left: unset; 
        width: unset; 
        font-weight: unset;
    }
    .pct-page-modern .btn-icon-split .icon {
        width: auto;
        height: auto;
        margin-right: unset;
        margin-left: unset;
        vertical-align: unset;
    }
</style>

<div class="pct-page-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container-fluid px-4 py-4">
		
        <!-- Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-sm-6">
                <!-- <h1 class="pct-page-title" style="font-size:1.5rem;font-weight:600;color:#1e293b;margin-bottom:0;">Preliminary Report Review</h1> -->
                <a class="btn btn-secondary btn-icon-split" href="<?php echo base_url();?>prelim-files">
					<span class="icon text-white-50">
						<i class="fa fa-arrow-left"></i>
					</span>
					<span class="text">Back</span>
				</a>
            </div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-success btn-icon-split" onClick="window.location.reload();">
                    <span class="icon text-white-50">
                        <i class="fa fa-refresh"></i>
                    </span>
                    <span class="text">Refresh Page</span>
                </button>
            </div>
        </div>

        <!-- Info Header -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div>
                        <h2 style="font-size:1.5rem; color: #1e5f8a; font-weight: 700; margin: 0;">Preliminary Report Review</h2>
                        <h3 style="font-size: 1rem; color: #64748b; margin-top: 0.5rem; font-weight: 500;">
                            File Number: <span style="color: #1e293b; font-weight: 700;"><?php echo $orderDetails['file_number']; ?></span>
                        </h3>
                    </div>
                     <div class="mt-2 mt-md-0 text-right">
                        <h3 style="font-size: 1.1rem; color: #1e293b; font-weight: 600;"><?php echo $orderDetails['full_address'];?></h3>
                     </div>
                </div>

                <div class="mt-3">
                    <?php if(!empty($success)) { ?>
                        <div id="prelim_action_success_msg" class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success;?>
                        </div>
                    <?php } if(!empty($error)) { ?>
                        <div id="prelim_action_success_msg" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error."<br \>";	?>
                        </div>
                    <?php } ?>
                </div>

                <input type="hidden" id="fileNumber" name="fileNumber" value="<?php echo $orderDetails['file_number'];?>">
                <input type="hidden" id="orderId" name="orderId" value="<?php echo $orderDetails['order_id'];?>">
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            
            <!-- Sidebar -->
            <div class="sidebar-area">
                
                <!-- Navigation -->
                <div class="nav-card">
                    <div class="nav-header">Doc Links</div>
                    <ul class="nav-list">
                        <li><a href="javascript:void(0);" onclick="summary();">Summary</a></li>
                        
                        <?php  if(!empty($prelimDocument)) { ?>
                            <li>
                                <a onclick="load_doc(<?php echo $prelimDocument['is_sync'];?>, <?php echo $prelimDocument['api_document_id'];?>, <?php echo $prelimDocument['order_id'];?>, <?php echo $prelimDocument['id'];?>);" href="javascript:void(0);">
                                    Prelim
                                </a>
                            </li>
                        <?php } else { ?>
                            <li><a href="javascript:void(0);" class="text-muted">Prelim (Not Available)</a></li>
                        <?php } ?>

                        <li>
                            <button onclick="toggleDropdown('linked_docs_dropdown')">
                                Linked Docs <i class="fa fa-caret-down"></i>
                            </button>
                            <div id="linked_docs_dropdown" class="dropdown-container">
                                <ol> 
                                <?php 
                                    if(!empty($linked_doc)) {
                                        $count = count($linked_doc);
                                        $i = 1;
                                        foreach($linked_doc as $document) { 
                                            if (!empty($document['original_document_name'])) {
                                            ?>
                                            <li ><a id="<?php echo $document['api_document_id'];?>" onclick="load_doc(<?php echo $document['is_sync'];?>, <?php echo $document['api_document_id'];?>, <?php echo $document['order_id'];?>, <?php echo $document['id'];?>);" class="linked_doc" href="javascript:void(0);" style="padding-left: 2rem; font-size: 0.85rem;"><?php echo $document['index_number'].". ".$document['original_document_name'];?></a></li>
                                        <?php  } $i++; } 
                                        } else { ?>
                                        <a class="linked_doc" href="#" style="padding-left: 2rem; font-style: italic; color: #94a3b8;">No Documents Found</a>
                                    <?php } 
                                ?>
                                </ol>
                            </div>
                        </li>

                        <li><a href="javascript:void(0);" onclick="legal_vesting();">Legal Vesting</a></li>
                        <li><a href="javascript:void(0);" onclick="plat_map();">Plat Map</a></li>

                        <li>
                            <button onclick="toggleDropdown('uploaded_docs_dropdown')">
                                Uploaded Docs <i class="fa fa-caret-down"></i>
                            </button>
                            <div id="uploaded_docs_dropdown" class="dropdown-container">
                                <ol> 
                                <?php 
                                    if(!empty($uploaded_docs)) {
                                        $count = count($uploaded_docs);
                                        $i = 1;
                                        foreach($uploaded_docs as $document) { 
                                            ?>
                                            <li><a id="<?php echo $document['api_document_id'];?>" onclick="load_doc(<?php echo $document['is_sync'];?>, <?php echo $document['api_document_id'];?>, <?php echo $document['order_id'];?>, <?php echo $document['id'];?>);" class="linked_doc" href="javascript:void(0);" style="padding-left: 2rem; font-size: 0.85rem;"><?php echo $i.". ".$document['original_document_name'];?></a></li>
                                        <?php  $i++; } 
                                        } else { ?>
                                        <a class="linked_doc" href="#" style="padding-left: 2rem; font-style: italic; color: #94a3b8;">No Documents Found</a>
                                    <?php } 
                                ?>
                                </ol>
                            </div>
                        </li>

                    </ul>
                </div>

                <!-- Order Details -->
                <div class="nav-card">
                    <div class="nav-header">Order Details</div>
                    <div class="detail-item">
                        <span class="detail-label">Borrower Name</span>
                        <div class="detail-value"><?php echo $orderDetails['primary_owner'];?></div>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Transaction Type</span>
                        <div class="detail-value"><?php echo $orderDetails['prod_type']; ?></div>
                    </div>
                    <?php if(strpos($orderDetails['prod_type'], 'refinance') !== false) {
                        if(isset($orderDetails['sales_amount']) && !empty($orderDetails['sales_amount'])) {
                            $sales_amount = str_replace(",", "", $orderDetails['sales_amount']);
                        }
                    ?>
                    <div class="detail-item">
                        <span class="detail-label">Sales Amount</span>
                        <div class="detail-value"><?php echo isset($sales_amount) && !empty($sales_amount) ? "$".number_format($sales_amount) : '-' ;?></div>
                    </div>
                    <?php } ?>
                    
                    <?php
                        if(isset($orderDetails['loan_amount']) && !empty($orderDetails['loan_amount'])) {
                            $loan_amount = str_replace(",", "", $orderDetails['loan_amount']);
                        }
                    ?>
                    <div class="detail-item">
                        <span class="detail-label">Loan Amount</span>
                        <div class="detail-value"><?php echo isset($loan_amount) && !empty($loan_amount) ? "$".number_format($loan_amount) : '-' ;?></div>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Open Date</span>
                        <div class="detail-value"><?php echo date("m/d/Y", strtotime($orderDetails['opened_date'])); ?></div>
                    </div>
                </div>

            </div>

            <!-- Docs Content Area -->
            <div class="main-card">
                 <div id="links_details">
                     <!-- Content loaded via AJAX will appear here -->
                     <div class="text-center text-muted py-5">
                         <i class="fas fa-file-alt fa-3x mb-3" style="color: #cbd5e1;"></i>
                         <p>Select a document from the menu to view details.</p>
                     </div>
                 </div>
            </div>

        </div>

	</div>
</section>
</div>

<!-- Note Modal -->
<div class="modal fade" id="note_information" tabindex="-1" role="dialog" aria-labelledby="Create a Note" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="POST" action="<?php echo base_url();?>update-prelim-action/<?php echo $orderDetails['order_id'];?>" enctype="multipart/form-data">
				<div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add a Note</h6>
                    </div>
					<div class="card-body"> 
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="note_subject" class="col-form-label">Subject</label>
                                <input type="text" name="note_subject" id="note_subject" class="form-control" placeholder="Subject" required="">
                            </div>

                            <div class="form-group mb-3">
                                <label for="note" class="col-form-label">Note</label>
                                <textarea name="note" id="note" class="form-control" rows="4" placeholder="Note" autocomplete="off" required=""></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="file_upload" class="col-form-label">Upload File</label>
                                <input required="" name="file_upload" type="file" id="file_upload" class="form-control" accept="application/pdf" style="padding: 0.375rem 0.75rem; height: auto;">
                            </div>
                            
                            <input type="hidden" name="upload_file_id" id="upload_file_id" value="">
                            <input type="hidden" name="document_name" id="document_name" value="">
                        </div>

                        <div class="form-footer text-right" style="padding: 0 1rem 1rem;">
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
			</form>
		</div>
	</div>
</div>

<script>
function toggleDropdown(id) {
    var el = document.getElementById(id);
    if (el.classList.contains('show')) {
        el.classList.remove('show');
    } else {
        el.classList.add('show');
    }
}
</script>
