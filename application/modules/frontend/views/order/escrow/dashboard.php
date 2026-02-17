<style>
/* Escrow Dashboard – same design tokens as dashboard */
.pct-home-modern {
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
    padding-bottom: 2rem;
}

/* Page header */
.pct-home-modern .pct-page-title { font-size: 1.5rem; font-weight: 600; color: var(--pct-text); margin-bottom: 0.25rem; }
.pct-home-modern .pct-page-sub { font-size: 0.9375rem; color: var(--pct-text-muted); margin: 0; }

/* Card styling */
.pct-home-modern .card {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
}
.pct-home-modern .card-header.py-3 {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-home-modern .card-header .font-weight-bold {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
}
.pct-home-modern .card-body { padding: 1.25rem; background: var(--pct-surface); }

/* Alerts */
.pct-home-modern .alert { border-radius: var(--pct-radius-sm); font-size: 0.875rem; margin-bottom: 1rem; }
.pct-home-modern .alert-success { background: #d1fae5; border-color: #a7f3d0; color: #065f46; }
.pct-home-modern .alert-danger { background: #fee2e2; border-color: #fecaca; color: #991b1b; }

/* Table styling */
.pct-home-modern .table { margin-bottom: 0; }
.pct-home-modern .table thead th {
    background: var(--pct-surface-2);
    border-bottom: 2px solid var(--pct-border);
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--pct-text);
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 0.75rem 1rem;
    text-align: center;
    white-space: nowrap;
}
.pct-home-modern .table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.9375rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
    text-align: center;
}
.pct-home-modern .table tbody tr:hover { background: var(--pct-primary-soft); }
.pct-home-modern .table tbody tr:last-child td { border-bottom: none; }

/* DataTables empty */
.pct-home-modern td.dataTables_empty { display: table-cell !important; }

/* Percentage styling */
.pct-home-modern .percentage {
    font-weight: 600;
    color: var(--pct-primary);
}

/* Buttons */
.pct-home-modern .btn {
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: var(--pct-radius-sm);
}
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Welcome Back <?php echo trim($name); ?>,</h1>
                <p class="pct-page-sub">Below is order list of pay off.</p>
            </div>
        </div>

        <!-- Alerts -->
        <?php if(!empty($success)) {?>
        <div id="agent_success_msg" class="alert alert-success alert-dismissible">
            <?php foreach($success as $sucess) {
                    echo $sucess."<br \>";	
                }?>
        </div>
        <?php } 
            if(!empty($errors)) {?>
        <div id="agent_error_msg" class="alert alert-danger alert-dismissible">
            <?php foreach($errors as $error) {
                    echo $error."<br \>";	
                }?>
        </div>
        <?php } ?>

        <!-- Orders Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Escrow Orders</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0" id="escrow_orders_listing">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File Number</th>
                                <th>Property Address</th>
                                <th>Product Type</th>
                                <th>Created At</th>
                                <th>Completed %</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
