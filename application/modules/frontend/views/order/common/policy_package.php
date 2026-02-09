<style>
/* Policy Package – same design tokens as dashboard */
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

/* Info bar */
.pct-home-modern .info-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    background: var(--pct-surface);
    border: 1px solid var(--pct-border);
    border-radius: var(--pct-radius);
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}
.pct-home-modern .info-bar-item { display: flex; align-items: center; gap: 0.5rem; }
.pct-home-modern .info-bar-label {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--pct-primary);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.pct-home-modern .info-bar-value { font-size: 0.9375rem; color: var(--pct-text); }

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
.pct-home-modern .card-body { padding: 1.5rem 1.25rem; background: var(--pct-surface); }

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
.pct-home-modern .btn-info { background: var(--pct-primary); border-color: var(--pct-primary); color: #fff; }
.pct-home-modern .btn-info:hover { background: var(--pct-primary-light); border-color: var(--pct-primary-light); color: #fff; }
.pct-home-modern .btn-icon-split { display: inline-flex; align-items: center; gap: 0.5rem; }

/* Status badge */
.pct-home-modern .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: var(--pct-radius-sm);
    font-size: 0.875rem;
    font-weight: 500;
}
.pct-home-modern .status-badge.pending { background: #fef3c7; color: #92400e; }
</style>

<div class="pct-home-modern">
<section class="section-type-4a section-defaulta" style="padding-bottom:0;">
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="pct-page-title">Get Policy</h1>
                <p class="pct-page-sub">Download your policy documents below.</p>
            </div>
        </div>

        <?php if (!empty($policyDocuments)) { ?>
            <!-- Info Bar with File Number and Address -->
            <div class="info-bar">
                <div class="info-bar-item">
                    <span class="info-bar-label">File Number:</span>
                    <span class="info-bar-value"><?php echo $file_number; ?></span>
                </div>
                <div class="info-bar-item">
                    <span class="info-bar-label">Property Address:</span>
                    <span class="info-bar-value"><?php echo $full_address; ?></span>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Policy Documents</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Document Name</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($policyDocuments as $policyDocument) {
                                    $documentName = $policyDocument['document_name']; ?>
                                    <tr>
                                        <td><?php echo $policyDocument['no']; ?></td>
                                        <td><?php echo $documentName; ?></td>
                                        <td><?php echo $policyDocument['created_at']; ?></td>
                                        <td>
                                            <a href='javascript:void(0);' onclick='download_policy_doc(<?php echo $policyDocument["api_document_id"]; ?>, <?php echo $order_id; ?>, "<?php echo $documentName; ?>");'>
                                                <button type='button' class='btn btn-success btn-icon-split'>
                                                    <span class='icon text-white-50'><i class='fas fa-download'></i></span>
                                                    <span class='text'>Download</span>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <!-- No Documents Available -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Policy Documents</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>File Number</th>
                                    <th>Property Address</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $file_number; ?></td>
                                    <td><?php echo $full_address; ?></td>
                                    <td><?php echo $created; ?></td>
                                    <td>
                                        <span class="status-badge pending">
                                            <i class="fas fa-clock"></i>
                                            Not Ready
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
</div>

<script>
    function download_policy_doc(documentId, order_id, documentName) {
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');
        $.ajax({
            url: base_url + "download-policy-doc",
            type: "post",
            data: {
                documentId: documentId,
                order_id: order_id
            },
            success: function (response) {
                $('#page-preloader').css('display', 'none');
                console.log(response);
                if (response) {
                    if (navigator.msSaveBlob) {
                        var csvData = base64toBlob(response, 'application/octet-stream');
                        var csvURL = navigator.msSaveBlob(csvData, 'policy.pdf');
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', documentName);
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        document.body.removeChild(element);
                    } else {
                        var csvURL = 'data:application/octet-stream;base64,' + response;
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', documentName);
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        element.click();
                        document.body.removeChild(element);
                    }
                }
            }
        });
    }

    function base64toBlob(base64Data, contentType) {
        contentType = contentType || '';
        var sliceSize = 1024;
        var byteCharacters = atob(base64Data);
        var bytesLength = byteCharacters.length;
        var slicesCount = Math.ceil(bytesLength / sliceSize);
        var byteArrays = new Array(slicesCount);

        for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
            var begin = sliceIndex * sliceSize;
            var end = Math.min(begin + sliceSize, bytesLength);

            var bytes = new Array(end - begin);
            for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
                bytes[i] = byteCharacters[offset].charCodeAt(0);
            }
            byteArrays[sliceIndex] = new Uint8Array(bytes);
        }
        return new Blob(byteArrays, { type: contentType });
    }
</script>
