<style>
/* Modernized styles based on CPL/Review Files pages */
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
.pct-page-modern .card.shadow.mb-4 {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    box-shadow: var(--pct-shadow);
    overflow: hidden;
    background: var(--pct-surface);
}
.pct-page-modern .card-header.datatable-header {
    background: var(--pct-surface-2);
    border-bottom: 1px solid var(--pct-border);
    padding: 1rem 1.25rem;
}
.pct-page-modern .card-header.datatable-header h6 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--pct-text);
    margin: 0;
}
.pct-page-modern .card-header .pl-10 { padding-left: 0.5rem; }
.pct-page-modern .card-body { padding: 1.25rem; }

/* Table */
.pct-page-modern #fees thead th {
    background: var(--pct-surface-2);
    color: var(--pct-text);
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    border-bottom: 1px solid var(--pct-border);
    padding: 0.875rem 1rem;
}
.pct-page-modern #fees tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    color: var(--pct-text);
    border-bottom: 1px solid var(--pct-border);
    vertical-align: middle;
}
.pct-page-modern #fees tbody tr:hover td { background: var(--pct-surface-2); }
.pct-page-modern td.dataTables_empty { display: table-cell !important; }

/* Pagination */
.pct-page-modern .dataTables_wrapper { padding-top: 0.75rem; }
.pct-page-modern .dataTables_wrapper .row:last-child {
    align-items: center;
    padding: 0.75rem 0;
    border-top: 1px solid var(--pct-border);
    margin-top: 0.5rem;
}
.pct-page-modern .dataTables_info { font-size: 0.8125rem; color: var(--pct-text-muted); font-weight: 500; }
.pct-page-modern .dataTables_paginate ul.pagination {
    margin: 0 !important;
    gap: 0.25rem;
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: flex-end;
}
.pct-page-modern .dataTables_paginate .page-item .page-link {
    min-width: 2rem; height: 2rem;
    padding: 0 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--pct-text);
    background: var(--pct-surface);
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.pct-page-modern .dataTables_paginate .page-item .page-link:hover {
    background: var(--pct-surface-2);
    border-color: var(--pct-primary-soft);
    color: var(--pct-primary);
}
.pct-page-modern .dataTables_paginate .page-item.active .page-link {
    background: var(--pct-primary);
    border-color: var(--pct-primary);
    color: #fff;
}
.pct-page-modern .dataTables_paginate .page-item.disabled .page-link {
    background: var(--pct-surface-2);
    color: var(--pct-text-muted);
    border-color: var(--pct-border);
    opacity: 0.8;
}

/* Search */
.pct-page-modern .dataTables_filter label { font-size: 0.875rem; font-weight: 500; color: var(--pct-text); display: inline-flex; align-items: center; gap: 0.5rem; }
.pct-page-modern .dataTables_filter input {
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius-sm);
    padding: 0.375rem 0.625rem;
    font-size: 0.875rem;
    outline: none;
    transition: all 0.2s;
}
.pct-page-modern .dataTables_filter input:focus { border-color: var(--pct-primary-light); box-shadow: 0 0 0 3px var(--pct-primary-soft); }

/* Buttons inside table */
.pct-page-modern .btn-icon-split {
    padding: 0;
    display: inline-flex;
    align-items: stretch;
    justify-content: center;
    overflow: hidden;
    border-radius: 8px;
}
.pct-page-modern .btn-icon-split .icon {
    background: rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
}
.pct-page-modern .btn-icon-split .text {
    display: flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
}
.pct-page-modern .btn-info {
    background-color: #36b9cc;
    border-color: #36b9cc;
    color: #fff;
}
.pct-page-modern .btn-info:hover {
    background-color: #2c9faf;
    border-color: #2c9faf;
    color: #fff;
}
</style>

<div class="pct-page-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
	<div class="container-fluid px-4 py-4">
		<div class="row mb-4 align-items-center">
			<div class="col-sm-12">
				<h1 class="pct-page-title" style="font-size:1.5rem;font-weight:600;color:#1e293b;margin-bottom:0;">Generate Fee Estimate</h1>
			</div>
		</div>
		<div class="card shadow mb-4">
			<div class="card-header datatable-header py-3">
				<div class="datatable-header-titles" >
                    <span><i class="fas fa-file-invoice-dollar" style="color: var(--pct-primary);"></i></span>
					<h6 class="m-0 font-weight-bold text-primary pl-10">Below are all your orders</h6> 
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="fees" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th width="20%">File Number</th>
								<th>Property Address</th>
								<th width="15%">Action</th>
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
