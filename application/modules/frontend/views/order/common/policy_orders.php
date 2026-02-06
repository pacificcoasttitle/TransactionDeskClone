<style>
/* Policy Orders – same design tokens as dashboard */
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
.pct-home-modern .card.shadow.mb-4 {
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
.pct-home-modern .card-body { padding: 1.5rem 1.25rem; }

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
    white-space: nowrap;
}
.pct-home-modern .table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.9375rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
}
.pct-home-modern .table tbody tr:hover { background: var(--pct-primary-soft); }
.pct-home-modern .table tbody tr:last-child td { border-bottom: none; }

/* Buttons */
.pct-home-modern .btn {
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: var(--pct-radius-sm);
    transition: opacity .15s ease, background .15s ease, border-color .15s ease;
}
.pct-home-modern .btn-primary { background: var(--pct-primary); border-color: var(--pct-primary); color: #fff; }
.pct-home-modern .btn-primary:hover { background: var(--pct-primary-light); border-color: var(--pct-primary-light); color: #fff; }
.pct-home-modern .btn-success { background: #059669; border-color: #059669; color: #fff; }
.pct-home-modern .btn-success:hover { background: #047857; border-color: #047857; color: #fff; }

/* DataTables overrides */
.pct-home-modern .dataTables_wrapper .dataTables_length select,
.pct-home-modern .dataTables_wrapper .dataTables_filter input {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}
.pct-home-modern .dataTables_wrapper .dataTables_filter input:focus {
    border-color: var(--pct-primary);
    outline: 0;
    box-shadow: 0 0 0 3px rgba(30, 95, 138, 0.1);
}
.pct-home-modern .dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: var(--pct-radius-sm);
    margin: 0 2px;
}
.pct-home-modern .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: var(--pct-primary) !important;
    border-color: var(--pct-primary) !important;
    color: #fff !important;
}
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Get Policy</h1>
                <p class="pct-page-sub">View and manage your policy orders below.</p>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Below are all your orders</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="policy_orders" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Number</th>
                                <th>Property Address</th>
                                <th>Upload Document</th>
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
