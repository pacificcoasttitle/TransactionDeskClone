
<footer>
    <div class="footer-top text-center">
        <a href="<?=base_url()?>">Home</a> | <a href="<?=base_url()?>about">About</a> | <a href="<?=base_url()?>terms">Terms of Service</a> | <a href="<?=base_url()?>privacy-policy">Privacy &amp; Data Protection</a> | <a href="<?=base_url()?>faq">FAQs</a> | <a href="<?=base_url()?>contact">Contact Us</a> | <a href="<?=base_url()?>career">Work with Us</a> | <a href="#">Our Team</a>
    </div>
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-md-2 social">
                    <a href="javascript:;"><i class="icon-google-plus"></i></a>
                    <a href="javascript:;"><i class="icon-facebook"></i></a>
                    <a href="javascript:;"><i class="icon-twitter"></i></a>
                    <a href="javascript:;"><i class="icon-pinterest"></i></a>
                </div>
                <div class="col-md-6 text-center">&copy; 2015 <a style="" href="http://promedicahealth.co.in/" target="_blank">PROMEDICA HEALTH COMM. PVT. LTD INITIATIVE.</a> ALL RIGHTS RESERVED. </div>
                <div class="col-md-4 " >
                
                <span id="cdSiteSeal1" style="float:left"><script type="text/javascript" src="//tracedseals.starfieldtech.com/siteseal/get?scriptId=cdSiteSeal1&amp;cdSealType=Seal1&amp;sealId=55e4ye7y7mb73e0493967bf4f5941ueez755y7mb7355e4ye70954a5f108fc449"></script></span>
                <a target="_blank" href="https://sslanalyzer.comodoca.com/?url=www.myreposit.com">
<img src="https://ssl.comodo.com/images/comodo_secure_76x26_white.png" alt="SSL Certificate"  style="border: 0px;float:right;height: 30px;width: 76px;"></a>
<A HREF="http://www.copyscape.com/dmca-copyright-protection/"><IMG SRC="<?=base_url()?>assets/front/images/Copyscape.jpg" ALT="Protected by Copyscape DMCA Copyright Search" TITLE="Protected by Copyscape Plagiarism Checker - Do not copy content from this page." WIDTH="88" HEIGHT="31" BORDER="0"/></A>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
        
           <p>Disclaimer: 
            <b>MyReposit.com is not an online Journal. </b>Its objective is to develop novel methods in scholarly communication. Services on MyReposit have been developed to increase the visibility and impact of published and unpublished scholarly content. MyReposit strongly recommends adoption of a Creative Commons license. For depositing published research, please refer to your publishers' policies and original publication agreement and/or contact of the original publisher to determine your rights to disseminate previously published literature vide open access. MyReposit may contain content written, edited or sponsored by individual Authors, Institutions and Societies using its manuscript development and independent peer review services. Copyright for such or any work disseminated by MyReposit remains exclusively with their respective authors. MyReposit only preserves and distributes such work electronically.
        </p></div>
    </div>
</footer>

<!-- jQuery Core -->
<script src="<?=base_url()?>assets/front/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/front/js/bootstrap-rating-input.min.js"></script>
<!-- Bootstrap -->
<script src="<?=base_url()?>assets/front/js/app.js"></script>

<?php if ($active=='editing' || $active == 'formatting' || $active=='translation' || $active=='request_quote'): ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?=base_url()?>assets/front/js/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=base_url()?>assets/front/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=base_url()?>assets/front/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?=base_url()?>assets/front/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?=base_url()?>assets/front/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?=base_url()?>assets/front/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?=base_url()?>assets/front/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?=base_url()?>assets/front/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?=base_url()?>assets/front/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script >
    $(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'server/php/?mpuserid=<?=$this->session->userdata("mpuserid")?>'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    }

});

</script>



<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?=base_url()?>assets/front/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<?php endif ?>

</html>
