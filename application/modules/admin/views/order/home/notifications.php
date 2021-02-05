<style>
.dataTables_length {
    width: 250px !important;
    float: left;
}
</style>
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
             Notifications
        </div>

        <div class="card-body">
            <div id="notifications_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="notifications_success_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-notifications-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                        </tr>
                    </thead>                
                    <tbody>
                        <?php if (!empty($notifications)) {
                            $i = 1; 
                            foreach($notifications as $notification) { ?>
                                <tr> 
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $notification['name'];?></td>
                                </tr>
                            <?php $i++; }
                        } else { ?>
                            <tr>
                                <td colspan=2> No Records Found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>