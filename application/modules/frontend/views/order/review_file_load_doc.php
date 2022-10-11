<style>
.l-main-content {
    padding-top: 50px !important;
}
</style>
<div class="typography-section__inner">
	<a onclick="(<?php echo $api_document_id;?>, <?php echo $order_id;?>, '<?php echo $document_name;?>');" href="javascript:void(0);"><button class='btn btn-grad-2a' style='background: #d35411;' type='button'>Download</button></a>
	<a style="display:<?php echo $prelim_flag == 1 ?  "contents" : "none";?>" onclick="download_document(<?php echo $api_document_id;?>, <?php echo $order_id;?>, '<?php echo $doc_document_name;?>');" href="javascript:void(0);"><button class='btn btn-grad-2a' style='width:auto;background: #d35411;' type='button'>Download Doc File</button></a>
	<a style="display:<?php echo $prelim_flag == 1 ?  "contents" : "none";?>" onclick="upload_document(<?php echo $api_document_id;?>, <?php echo $order_id;?>, '<?php echo $doc_document_name;?>');" href="javascript:void(0);"><button class='btn btn-grad-2a' style='width:auto;background: #d35411;' type='button'>Upload Doc File</button></a>
</div>

<div class="l-main-content">
	<article class="b-post b-post-full clearfix">
		<div class="">
			<iframe src="<?php echo $url;?>" width="825px" height="800px">
				This browser does not support PDFs. Please download the PDF to view it: Download PDF
			</iframe>
		</div>
	</article>
</div>
