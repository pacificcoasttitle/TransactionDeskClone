<?php 
    $salesRep = isset($salesRep['data']) && !empty($salesRep['data']) ? $salesRep['data'] : array();
    $product_type = isset($product_type) && !empty($product_type) ? $product_type : '';
    $master_users = json_encode($master_users);
    $userdata = $this->session->userdata('admin');
    $roleList = $this->common_lib->getRoleList();
    $role_id = isset($userdata['role_id']) ? $userdata['role_id'] : 0;
    $roleName = $roleList[$role_id];
?>
<script type="text/javascript">
    var sales_rep = <?php echo json_encode($sales_rep, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    var master_users = '<?php echo $master_users; ?>';
    var product_type = '<?php echo $product_type; ?>';
</script>

<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-list-alt"></i> Orders Listing</h1>
        
        <?php if (!in_array($roleName, ['CS Admin'])) : ?>
        <div class="action-buttons">
            <a href="javascript:void(0);" onclick="fetchContactsForSalesOrder();" class="btn-action btn-action-info">
                <i class="fas fa-sync"></i> Fetch Contacts Order
            </a>
            <a href="javascript:void(0);" onclick="openSoftproOrderPopup();" class="btn-action btn-action-info">
                <i class="fas fa-sync"></i> Sync Order
            </a>
            <a href="javascript:void(0);" onclick="fetchRevenueReport();" class="btn-action btn-action-info">
                <i class="fas fa-dollar-sign"></i> Sync Revenue
            </a>
            <a href="javascript:void(0);" onclick="syncSoftProOrdersStatus();" class="btn-action btn-action-info">
                <i class="fas fa-sync-alt"></i> Sync Status
            </a>
            <a href="javascript:void(0);" onclick="syncSoftProOrders();" class="btn-action btn-action-primary">
                <i class="fas fa-sync"></i> Sync All Orders
            </a>
            <a href="javascript:void(0);" data-export-type="csv" onclick="exportOrders();" class="btn-action btn-action-success">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Orders Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-table"></i> All Orders</h2>
        </div>
        <div class="modern-card-body">
            <div id="order_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="order_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-orders-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Order#</th>
                            <th>Property Address</th>
                            <th>Product Type</th>
                            <th>Sales Rep</th> 
                            <th>Created By</th>   
                            <th>Email Status</th>          
                            <th>Avoid Duplication</th>           
                            <th>Created At</th>           
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Sync Order Number Modal -->
<div class="modal fade pct-admin-listing" id="fetchOrderNumber" tabindex="-1" role="dialog" aria-labelledby="syncOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" id="sync-order-number-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="syncOrderLabel">
                        <i class="fas fa-sync-alt mr-2"></i>Sync Order Number
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="order_number" class="font-weight-bold">Enter Order Number</label>
                        <input name="order_number" required="" type="text" class="form-control" id="order_number" placeholder="e.g. 200001234-OCT">
                        <div id="sync_order_number_error_msg" class="text-danger mt-2" style="display:none;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" onclick="syncOrderNumberFromSoftpro(event);" class="btn btn-primary">
                        <i class="fas fa-sync-alt mr-1"></i> Sync Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sync Contacts Order Number Modal -->
<div class="modal fade pct-admin-listing" id="fetchContactsOrder" tabindex="-1" role="dialog" aria-labelledby="fetchContactsOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" id="fetch-contacts-order-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="fetchContactsOrderLabel">
                        <i class="fas fa-sync-alt mr-2"></i>Fetch Order Contacts 
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sale_reps" class="font-weight-bold">Select Sales Rep</label>
                        <select name="sale_reps" required="" class="form-control" id="sale_reps">
                            <option value="">Select Sales Rep</option>
                            <?php foreach ($salesRep as $key => $value) : ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['first_name'] . ' ' . $value['last_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div id="sync_contacts_sale_reps_error_msg" class="text-danger mt-2" style="display:none;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" onclick="syncContactsOrder(event);" class="btn btn-primary">
                        <i class="fas fa-sync-alt mr-1"></i> Fetch Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
