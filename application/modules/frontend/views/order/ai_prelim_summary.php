<style>
.l-main-contenta {
	padding-top: 0px !important;
}

.l-main-contenta p{
	font-size: 20px;
}

.prelim_title {
	padding-left: 7px;
    padding-top: 5px;
	font-size: 18px;
}
.b-post-full h3 {
	color: #2c3e50;
	margin-top: 30px;
	font-size: 18px;
}
.b-post-full ul {
	margin-left: 20px;
	list-style-type: disc;
	font-size: 18px;
}
.b-post-full strong {
	color: #000;
	font-size: 18px;
}
.prelim_summary {
	font-size: 1.75rem !important;
}
.disclaimer {
	font-size: 10px !important;
}
</style>
<!-- <div class="typography-section__inner">
	<h3 class="ui-title-block_light">Prelim Info</h3>
	<div class="ui-decor-1a bg-accent"></div>
</div> -->
<div class="l-main-contenta">
	<article class="b-post b-post-full clearfix ">
		<div class="typography-section__inner">
			<h3 class="ui-title-block_light prelim_summary">Prelim Summary</h3>
			<div style="border-bottom: 4px solid #D35411;"></div>
		</div>
		<?= $prelim_details['html'] ?>
		<hr>
	</article>
	<p class="disclaimer"><b>Disclaimer:</b> This summary is provided for informational purposes only and does not replace the official Preliminary Title Report ("Prelim"). All parties should carefully review the full Prelim for complete details, exceptions, and legal terms. This summary is not a substitute for legal advice or a comprehensive title examination. </p>
</div>