<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <div id="login-result">
            <?php if(!empty($msg)){ ?>
              <div class="col-xs-12">
                  <div class="alert alert-danger"><?php echo $msg; ?></div>
              </div>
            <?php } ?>
        </div>
        
          <?php // echo form_open('home/do_login', array('class'=>'jsform','name'=>'login-form','id'=>'login-form')); ?>
        <form id="login-form" name="login-form" method="POST" action="<?php echo base_url()?>?admin/home/do_login">
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="email_address" name="email_address" class="form-control" autofocus="autofocus">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="password" name="password" class="form-control">
              <label for="inputPassword">Password</label>
            </div>
          </div>
          
          <input type="submit" class="btn btn-primary btn-block" value="Login">
        <?php echo form_close(); ?>
        <!-- <div class="text-center">
          <a class="d-block small" href="#">Forgot Password?</a>
        </div> -->
      </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){

    if($("#login-form").length)
    {
        $("#login-form").validate({
                
            /* @validation states + elements 
            ------------------------------------------- */
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            onkeyup: false,
            onclick: false,                     
            
            /* @validation rules 
            ------------------------------------------ */
            rules: {                 
                email_address: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true
                }
            },
            
            /* @validation error messages 
            ---------------------------------------------- */
            messages:{              
                email_address: {
                    required: 'Enter your email address',
                    email: 'Enter a valid email address'
                },
                password: {
                    required: 'Enter your password'
                }
            },

            /* @validation highlighting + error placement  
            ---------------------------------------------------- */ 
            highlight: function(element, errorClass, validClass) {
                    $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
               if (element.is(":radio") || element.is(":checkbox")) {
                        element.closest('.option-group').after(error);
               } else {
                        error.insertAfter(element.parent());
               }
            },
            
            /* @ajax form submition 
            ---------------------------------------------------- */
            submitHandler:function(form) {
                form.submit();
                /*$(form).ajaxSubmit({
                    // target:'#showCustomerNumber',       
                    error:function(){
                        // $('.form-footer').removeClass('progress');
                    },
                    success:function(data){
                        var res = jQuery.parseJSON(data);
                        if(res.status == 'success')
                        {      
                            window.location.href = "<?php // echo base_url();?>?dashboard";
                        }
                        else
                        {
                            var content = '<div class="alert alert-danger">'+res.msg+'</div>';
                            $('#login-result').html(content);
                        }
                        $('#login-result').delay(5000).fadeOut();
                    }
                });*/
            }
        }); 
    }
});
</script>