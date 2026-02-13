

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
