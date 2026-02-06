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

/* Header */
.pct-page-modern .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}
.pct-page-modern .page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--pct-primary);
    margin: 0;
}

/* User Card */
.pct-page-modern .user-card {
    background: var(--pct-surface);
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    padding: 1.5rem;
    text-align: center;
    transition: all 0.2s ease;
    height: 100%;
    box-shadow: var(--pct-shadow);
    display: flex;
    flex-direction: column;
    align-items: center;
}
.pct-page-modern .user-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border-color: var(--pct-primary-light);
}

/* Avatar */
.pct-page-modern .avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-bottom: 1rem;
    object-fit: cover;
    border: 3px solid var(--pct-surface-2);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    background: var(--pct-surface-2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--pct-primary);
    font-size: 2rem;
    font-weight: 700;
}

/* User Info */
.pct-page-modern .user-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--pct-text);
    margin-bottom: 0.25rem;
}
.pct-page-modern .user-email {
    font-size: 0.85rem;
    color: var(--pct-text-muted);
    margin-bottom: 0.5rem;
    word-break: break-all;
}
.pct-page-modern .user-phone {
    font-size: 0.85rem;
    color: var(--pct-text);
    font-weight: 600;
    margin-bottom: 1rem;
    background: var(--pct-surface-2);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    display: inline-block;
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
    text-decoration: none;
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

.btn-card-action {
    width: 100%;
    margin-top: auto;
}

</style>

<div class="pct-page-modern">
    <div class="container-fluid px-4 py-4">
        
        <!-- Header -->
        <div class="page-header">
            <h1 class="page-title">Sales Representatives</h1>
            <a href="<?php echo base_url('reports') ?>" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>

        <!-- User Grid -->
        <div class="row">
            <?php foreach($salesReps as $key=>$salesRep): ?>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="user-card">
                    <!-- Avatar -->
                    <?php 
                    $image_url = trim(env('AWS_PATH').$salesRep['sales_rep_report_image']);
                    if (!empty($salesRep['sales_rep_report_image'])): 
                    ?>
                        <img src="<?php echo $image_url;?>" alt="<?php echo $salesRep['first_name']; ?>" class="avatar">
                    <?php else: ?>
                        <div class="avatar">
                            <span><?php echo strtoupper(substr(trim($salesRep['first_name']) , 0,1).substr(trim($salesRep['last_name']) , 0,1)) ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Info -->
                    <div class="user-name"><?php echo $salesRep['first_name'].' '.$salesRep['last_name'] ?></div>
                    <div class="user-email"><?php echo $salesRep['email_address'];?></div>
                    <div class="user-phone"><i class="fas fa-phone-alt fa-xs mr-1"></i> <?php echo $salesRep['telephone_no'];?></div>

                    <!-- Action -->
                    <a href="<?php echo base_url('reports/sales_rep').'/'.$salesRep['id'] ?>" class="btn btn-primary btn-icon-split btn-card-action">
                        <span class="icon text-white-50">
                            <i class="fas fa-edit"></i>
                        </span>
                        <span class="text">Edit Profile</span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if(empty($salesReps)): ?>
            <div class="col-12 text-center py-5 text-muted">
                <h4>No Sales Representatives Found</h4>
            </div>
            <?php endif; ?>
        </div>
        
    </div>
</div>
