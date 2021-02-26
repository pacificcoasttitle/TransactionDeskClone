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
            Safewire Orders
            <div class="float-right">
                <a href="javascript:void(0);" data-export-type="csv" id="export_safewire_orders" class="btn btn-secondary">Export </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-safewire-orders-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Order#</th>
                            <th>Property Address</th>
                            <th>Escrow Officer</th>
                            <th>Safewire Status</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>