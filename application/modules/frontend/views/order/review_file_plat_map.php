<?php
	$file_url = isset($file_url) && !empty($file_url) ? $file_url : '';
?>
<div class="l-main-content">
	<article class="b-post b-post-full clearfix">
		<div class="">
			<iframe id="plat-map-doc" src="<?php echo $file_url; ?>" width="825px" height="800px">
				This browser does not support PDFs. Please download the PDF to view it: Download PDF
			</iframe>
		</div>
	</article>
</div>

<script type="text/javascript">
$(document).ready(function() {
	reportData = {};
	var request = '';

	var file_url = "<?php echo isset($file_url) && !empty($file_url) ? $file_url : ''; ?>";
	if(file_url == '')
	{
		var address = "<?php echo isset($address) && !empty($address) ? $address : ''; ?>";
		var locale = "<?php echo isset($locale) && !empty($locale) ? $locale : ''; ?>";
		var zip = "<?php echo isset($zip) && !empty($zip) ? $zip : ''; ?>";
		
		getPlat(address,zip,locale);	
	}
});
// run query for plat map report 
function getPlat(address,zip,locale) {
	$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
	$('#page-preloader').css('display', 'block');
    var request = 'http://api.sitexdata.com/sitexapi/sitexapi.asmx/AddressSearch?';
    dataObj = {};
    dataObj.Address = address;
    dataObj.LastLine = locale.toString();
    dataObj.ClientReference = '<CustCompFilter><CompNum>8</CompNum><MonthsBack>12</MonthsBack></CustCompFilter>';
    dataObj.OwnerName = '';

    request += $.param(dataObj);
    $.ajax({
        url: base_url+'home/getSearchResults?',
        // url: 'http://cardbanana.net/demo/jerry/lp/lp/lp/proxy.php',
        data: {
            requrl: request + '?&reportType=111'
        },
        dataType: 'xml'
    })
        .done(function(response, textStatus, jqXHR) {
            console.log(response);
            reportUrl = $(response).find('ReportURL').text();
            reportData.report111 = reportUrl;
            get111();
        });
}

function get111() {
    $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
	$('#page-preloader').css('display', 'block');
    $.ajax({
        url: base_url+'home/getSearchResults?',
        data: {
            requrl: reportData.report111,
        },
        dataType: "xml",
        success: function(xml) {
            reportXML = xml;
            console.log(reportXML);
           parse111();
        },
        error: function() {
            console.log("An error occurred while processing XML file.");
        }
    });
}

function parse111() 
{
	$('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
	$('#page-preloader').css('display', 'block');
    var imagedata = $(reportXML).find("Content").text();
    var file_number = <?php echo isset($file_number) && !empty($file_number) ? $file_number : ''; ?>;

    $.ajax({
        url: base_url+'/generate-plat-map',
        data: {
            imagedata: imagedata,
            file_number: file_number,
        },
        type: "POST",
        success: function(response) {
            var result = jQuery.parseJSON(response);
            if(result.status == 'error')
			{

			}
			else if(result.status == 'success')
			{
				$('#plat-map-doc').attr('src',url);
            	$('#page-preloader').css('display', 'none');
			}
        },
        error: function() {
           // console.log("An error occurred while processing XML file.");
        }
    });
}
</script>