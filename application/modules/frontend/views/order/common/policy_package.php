

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
