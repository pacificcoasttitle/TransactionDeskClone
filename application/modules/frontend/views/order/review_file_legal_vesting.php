<?php
	$file_number = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
	
	$file_path = FCPATH.'uploads/legal-vesting/'.$file_number.'.pdf';

	if (file_exists($file_path)) {
	    $file_url = base_url().'uploads/legal-vesting/'.$file_number.'.pdf';
	} else {
	    $file_id = isset($orderDetails['file_number']) && !empty($orderDetails['file_number']) ? $orderDetails['file_number'] : '';
	}
?>
<div class="l-main-content">
	<article class="b-post b-post-full clearfix">
		<div class="">
			<iframe src="<?php echo $file_url; ?>" width="825px" height="800px">
				This browser does not support PDFs. Please download the PDF to view it: Download PDF
			</iframe>
		</div>
	</article>
</div>

