<div class="typography-section__inner">
	<h3 class="ui-title-block_light">Documents Info</h3>
	<div class="ui-decor-1a bg-primary"></div>
</div>
<div class="l-main-contenta">
    <div class="table-container">
        <table class="table table_primary" id="prelim_files">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Created Date</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($documents)) { 
                        foreach($documents as $document) { ?>
                            <tr>
                                <td><?php echo $document['document_name']?></td>
                                <td><?php echo date("m/d/Y h:i A", strtotime($document['created']));?></td>
                                <td><a onclick="download_document(<?php echo $document['api_document_id'];?>, <?php echo $document['order_id'];?>, '<?php echo $document['document_name'];?>');" href="javascript:void(0);"><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a></td>
                            </tr>
                        <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td style="text-align:center;" colspan="4">No Documents Found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

