<body>
    <?php
        $this->load->view('layout/header_dashboard');
    ?>
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="l-main-content">
               
                <!-- end .post-->
             
                <!-- end .about-author-->
               
                <section class="section-comment">
                  <h2 class="ui-title-block-4">Notes   (2)</h2>
                  <div class="ui-decor-3"></div>
                  <ul class="comments-list list-unstyled">
                    	<?php
                    		if(isset($notes) && !empty($notes))
                    		{
                    	?>
                    			<li>
                    				<article class="comment clearfix">
				                        <div class="comment-inner">
				                          <header class="comment-header">
				                            <cite class="comment-author">William Smith</cite>
				                            <time class="comment-datetime" datetime="2012-10-27">2 hours ago</time>
				                          </header>
				                          <div class="comment-body">
				                            <p>Dolore magna aliqua uat enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ea commodo consequat auis aute irure dolor in reprehenderit in voluptate velit cillum.</p>
				                          </div>
				                          <footer class="comment-footer"><a class="comment-btn" href="blog-post.html">reply</a></footer>
				                        </div>
				                      </article>
				                     </li>
                    	<?php
                    		}
                    		else
                    		{
                    	?>
                    			<li>
                    				<cite class="comment-author">Notes not found</cite>
                    			</li>
                    	<?php
                    		}
                    	?>
                  </ul>
                </section>
                <!-- end .section-comment-->
                <section class="section-reply-form" id="section-reply-form">
                  <h2 class="ui-title-block-4">Create a note</h2>
                  <div class="ui-decor-3"></div>
                  <form class="form-reply ui-form-1" id="create-note" name="create-note" method="POST">
                  	<div class="row">
                      <div class="col-xs-12">
                        <input class="form-control" type="text" name="subject" id="subject" placeholder="Subject">
                        <input type="hidden" name="fileId" id="fileId" value="<?php echo isset($fileId) && !empty($fileId) ? $fileId: ''; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <textarea class="form-control" rows="4" name="body" id="body" placeholder="Body"></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <button type="submit" class="btn btn-default btn-round btn-block">create</button>
                      </div>
                    </div>
                  </form>
                  <div id="result"></div>
                </section>
                <!-- end .section-reply-form-->
            </div>
          </div>
          
        </div>
      </div>
	<?php
       $this->load->view('layout/footer');
    ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js"></script>
</body>
</html>
<script type="text/javascript">
$(document).ready(function () {
	if(jQuery('#create-note').length)
    {
       jQuery('#create-note').validate({ 
            rules: {
                subject:"required",
                body:"required"
            },
            messages: {
                subject:"Please enter subject",
                body:"Please enter body",
            },
            submitHandler: function(form) {
            	var subject = $('#subject').val();
            	var body = $('#body').val();
            	var fileId = $('#fileId').val();
                $.ajax({
                url: base_url + "create-note",
                type: "post",
                data:{
                    subject: subject,
                    body: body,
                    fileId: fileId,
                }, 
                success: function(response) {
                	var res = jQuery.parseJSON(response);
                	console.log(res);
					if(res.status == 'error')
					{
						$('#result').html('<div class="alert notification alert-danger">'+res.message+'</div>');
					}
					else if(res.status == 'success')
					{
						$('#result').html('<div class="alert alert-success">'+res.message+'</div>');
					}
					$('#result').show().delay(7000).fadeOut("normal", function(){
        					$('#result').html('');
        					$('#subject').val('');
            				$('#body').val('');
    				});
                }
            });
            }
        }); 
    }
});
</script>
<style type="text/css">
	.error {
		color: #FF2F0F;
	}
</style>