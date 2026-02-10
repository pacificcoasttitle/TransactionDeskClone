<div class="pct-admin-listing">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-database"></i> Tax Data</h1>
    </div>

    <!-- Tax Data Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h2><i class="fas fa-list-alt"></i> Tax Data Listing</h2>
        </div>
        <div class="modern-card-body">
            <div id="customer_success_msg" class="alert-modern alert-success-modern" style="display:none;"></div>
            <div id="customer_error_msg" class="alert-modern alert-danger-modern" style="display:none;"></div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-tax-data-listing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Order No</th>
                            <th>Property Address</th>
                            <th>APN</th>
                            <th>Message</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>                
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function downloadDocumentFromAws(url, documentType)
    {
        $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
        $('#page-preloader').css('display', 'block');
        var fileNameIndex = url.lastIndexOf("/") + 1;
        var filename = url.substr(fileNameIndex);
        $.ajax({
            url: base_url + "download-aws-document-admin",
            type: "post",
            data: {
                url : url
            },
            async: false,
            success: function (response) {
                if (response) {
                    if (navigator.msSaveBlob) {
                        var csvData = base64toBlob(response, 'application/octet-stream');
                        var csvURL = navigator.msSaveBlob(csvData, filename);
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', documentType+"_"+filename);
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        document.body.removeChild(element);
                    } else {
                        var csvURL = 'data:application/octet-stream;base64,' + response;
                        var element = document.createElement('a');
                        element.setAttribute('href', csvURL);
                        element.setAttribute('download', documentType+"_"+filename);
                        element.style.display = 'none';
                        document.body.appendChild(element);
                        element.click();
                        document.body.removeChild(element);
                    }
                }
                $('#page-preloader').css('display', 'none');
            }
        });
    }
</script>
