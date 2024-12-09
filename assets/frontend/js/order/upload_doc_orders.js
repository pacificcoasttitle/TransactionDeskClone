var upload_doc_orders = '';
$(document).ready(function () {
    if ($('#upload_doc_orders').length) {
        upload_doc_orders = $('#upload_doc_orders').DataTable({
            // "pageLength": 2,
            "paging": true,
            "lengthChange": false,
            "language": {
                paginate: {
                    next: '<span class="fa fa-angle-right"></span>',
                    previous: '<span class="fa fa-angle-left"></span>',
                },
                "emptyTable": "Record(s) not found.",
                "search": "",
            },
            /*"searching": false,*/
            initComplete: function () {


            },
            dom: 'Bfrtip',
            buttons: [],
            "drawCallback": function () {

            },
            "ordering": false,
            "serverSide": true,
            "ajax": {
                url: base_url + "get-orders-upload-doc",
                type: "post",
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        alert("You are logged out. Please login.");
                    }
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    $("#upload_doc_orders tbody").append(
                        '<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#upload_doc_orders_processing").css("display", "none");

                }
            }
        });
    }

    if ($('#uploaded_document_list').length) {
        uploaded_document_list = $('#uploaded_document_list').DataTable({
            // "pageLength": 2,
            "paging": true,
            "lengthChange": false,
            "language": {
                paginate: {
                    next: '<span class="fa fa-angle-right"></span>',
                    previous: '<span class="fa fa-angle-left"></span>',
                },
                "emptyTable": "Record(s) not found.",
                "search": "",
            },
            /*"searching": false,*/
            initComplete: function () {


            },
            dom: 'Bfrtip',
            buttons: [],
            "drawCallback": function () {

            },
            "ordering": false,
            "serverSide": true,
            "ajax": {
                url: base_url + "get-uploaded-desk-doc",
                type: "post",
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        alert("You are logged out. Please login.");
                    }
                    if (parseInt(XMLHttpRequest.status) == 419) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    $("#uploaded_document_list tbody").append(
                        '<tr><td colspan="4" class="text-center">No records found</td></tr>');
                    $("#uploaded_document_list_processing").css("display", "none");

                }
            }
        });
    }

    // Select elements
    const uploadContainer = document.getElementById('upload-container');
    const fileInput = document.getElementById('file-input');
    const browseButton = document.getElementById('browse-button');
    // const submitButton = document.getElementById('submit-button');
    const fileList = document.getElementById('file-list');

    // Files array to store uploaded files
    let files = [];

    // Function to update the file list display
    function updateFileList() {
        fileList.innerHTML = ''; // Clear current list

        files.forEach((file) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';

            const fileIcon = document.createElement('div');
            fileIcon.className = 'file-icon';
            fileIcon.textContent = '📄'; // Simple file icon emoji

            const fileName = document.createElement('div');
            fileName.className = 'file-name';
            fileName.textContent = file.name;

            fileItem.appendChild(fileIcon);
            fileItem.appendChild(fileName);
            fileList.appendChild(fileItem);
        });
    }

    // Handle drag and drop events
    uploadContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadContainer.classList.add('dragover');
    });

    uploadContainer.addEventListener('dragleave', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadContainer.classList.remove('dragover');
    });

    uploadContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadContainer.classList.remove('dragover');

        const droppedFiles = Array.from(e.dataTransfer.files);
        files = [...files, ...droppedFiles];
        updateFileList();
    });

    // Handle file input click
    browseButton.addEventListener('click', () => {
        console.log('browse bottun event detected');
        fileInput.click();
    });

    fileInput.addEventListener('change', (e) => {
        // console.log('change event detected');
        // const selectedFiles = Array.from(e.target.files);
        // console.log('selectedFiles ===', selectedFiles);
        // files = [...files, ...selectedFiles];
        updateFileList();
    });

    // Handle submit button
    // submitButton.addEventListener('click', (e) => {
    //     e.preventDefault();
    //     e.stopPropagation();
    //     if (files.length === 0) {
    //         alert('No files uploaded.');
    //         return;
    //     }

    //     const formData = new FormData();
    //     files.forEach((file, index) => {
    //         formData.append(`file${index + 1}`, file);
    //     });
    //     // $('#smart-form').submit();

    //     // // Example: POST to a server
    //     fetch('/upload-file', {
    //         method: 'POST',
    //         body: formData,
    //     })
    //         .then((response) => response.json())
    //         .then((data) => {
    //             console.log('Upload success:', data);
    //         })
    //         .catch((error) => {
    //             console.error('Upload failed:', error);
    //         });
    // });


});