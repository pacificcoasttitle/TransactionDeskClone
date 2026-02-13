

<div class="pct-page-modern">
    <div class="container-fluid px-4 py-4">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800" style="font-weight: 700; color: var(--pct-primary);">Edit Sales Representative</h1>
            <a href="<?php echo base_url('reports/sales_rep'); ?>" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Record</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="smart-form" enctype="multipart/form-data" novalidate="novalidate" action="<?php echo base_url('reports/sales_rep').'/'.$salesRep['id'] ?>">
                            
                            <?php if($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error');?></div>
                            <?php elseif($this->session->flashdata('success')): ?>
                                <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success');?></div>
                            <?php endif; ?>

                            <!-- Avatar Section -->
                            <div class="avatar-upload-container">
                                <div class="avatar-preview">
                                    <?php 
                                    $image_url = trim(env('AWS_PATH').$salesRep['sales_rep_report_image']);
                                    if (!empty($salesRep['sales_rep_report_image']) && checkRemoteFile($image_url)): 
                                    ?>
                                        <img src="<?php echo $image_url;?>" alt="Avatar" id="avatar-img-preview">
                                    <?php else: ?>
                                        <span id="avatar-text-preview"><?php echo strtoupper(substr(trim($salesRep['first_name']) , 0,1).substr(trim($salesRep['last_name']) , 0,1)) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="avatar-file-input">
                                    <button type="button" class="btn btn-sm btn-primary">
                                        <i class="fas fa-camera mr-1"></i> <?php echo (!empty($salesRep['sales_rep_report_image'])) ? 'Change Photo' : 'Upload Photo'; ?>
                                    </button>
                                    <input type="file" name="sales_rep_report_image" id="report_image" 
                                           onchange="document.getElementById('uploader-text').innerText = this.files[0] ? this.files[0].name : '';">
                                </div>
                                <small class="text-muted mt-2" id="uploader-text"></small>
                            </div>

                            <!-- Input Grid -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="<?=$salesRep['first_name'];?>" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="<?=$salesRep['last_name'];?>" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" value="<?=$salesRep['title'];?>" placeholder="Title"> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Telephone</label>
                                        <input type="tel" class="form-control" name="telephone_no" value="<?=$salesRep['telephone_no'];?>" placeholder="Telephone">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email_address" value="<?=$salesRep['email_address'];?>" placeholder="Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success btn-icon-split mr-2">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Submit Changes</span>
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-refresh"></i>
                                        </span>
                                        <span class="text">Reset</span>
                                    </button>
                                </div>
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
