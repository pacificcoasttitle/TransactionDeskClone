<style>
/* Modernized styles */
.pct-page-modern {
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
    min-height: 100vh;
    padding-bottom: 2rem;
}

/* Card */
.pct-page-modern .card.shadow {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    background: var(--pct-surface);
}
.pct-page-modern .card-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-page-modern .card-body { padding: 2rem; }

/* Forms */
.pct-page-modern .form-group { margin-bottom: 1.5rem; }
.pct-page-modern .form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--pct-text);
    margin-bottom: 0.5rem;
    display: block;
}
.pct-page-modern .form-control {
    display: block;
    width: 100%;
    padding: 0.625rem 0.875rem;
    font-size: 0.9375rem;
    color: var(--pct-text);
    background-color: #fff;
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    transition: all 0.2s;
}
.pct-page-modern .form-control:focus {
    border-color: var(--pct-primary-light);
    box-shadow: 0 0 0 3px var(--pct-primary-soft);
    outline: 0;
}

/* Avatar Upload */
.avatar-upload-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 2rem;
}
.avatar-preview {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid var(--pct-surface-2);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    background: var(--pct-surface-2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--pct-primary);
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
}
.avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* File Input Custom Style */
.pct-page-modern .file-input-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
}
.pct-page-modern .file-input-wrapper input[type=file] {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    opacity: 0; cursor: pointer;
}

/* Buttons */
.pct-page-modern .btn-icon-split {
    display: inline-flex;
    align-items: stretch;
    justify-content: center;
    border-radius: var(--pct-radius-sm);
    overflow: hidden;
    padding: 0;
    border: none;
    font-weight: 500;
    transition: all 0.2s;
}
.pct-page-modern .btn-icon-split .icon {
    background: rgba(0,0,0,0.15);
    padding: 0.5rem 0.75rem;
    display: flex;
    align-items: center;
}
.pct-page-modern .btn-icon-split .text {
    padding: 0.5rem 1rem;
    display: flex;
    align-items: center;
}
.pct-page-modern .btn-primary { background: var(--pct-primary); color: #fff; }
.pct-page-modern .btn-primary:hover { background: #164e73; color: #fff; }
.pct-page-modern .btn-secondary { background: #64748b; color: #fff; }
.pct-page-modern .btn-secondary:hover { background: #475569; color: #fff; }
.pct-page-modern .btn-success { background: #1cc88a; color: #fff; }
.pct-page-modern .btn-success:hover { background: #17a673; color: #fff; }
.pct-page-modern .btn-danger { background: #e74a3b; color: #fff; }
.pct-page-modern .btn-danger:hover { background: #be2617; color: #fff; }

</style>

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
                                <div class="file-input-wrapper">
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
