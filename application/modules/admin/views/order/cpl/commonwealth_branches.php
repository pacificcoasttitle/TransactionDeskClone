<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-map-marker-alt"></i> Commonwealth Branches</h1>
        <div class="action-buttons">
            <a href="javascript:void(0);" id="refresh_commonwealth_branches" class="btn-action btn-action-success">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>
    </div>

    <!-- Commonwealth Branches Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Commonwealth Branches</h2>
        </div>
        <div class="modern-card-body">
            <div id="commonwealth_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="commonwealth_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-north-american" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Unique Id</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zipcode</th>
                        </tr>
                    </thead>
                    <?php if(!empty($branchesData)) {?>
                        <tbody>
                            <?php $i = 1;
                                foreach($branchesData as $branchData) { ?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $branchData['agent_number'];?></td>
                                    <td><?php echo $branchData['address'];?></td>
                                    <td><?php echo $branchData['location_city'];?></td>
                                    <td><?php echo $branchData['state'];?></td>
                                    <td><?php echo $branchData['zip'];?></td>
                                </tr> 
                            <?php $i++; }?> 
                        </tbody>
                    <?php } else {?>
                        <tr>
                            <td align="center" colspan="7"> No Records Found.</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>