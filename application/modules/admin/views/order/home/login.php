<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PCT Order - Admin Login</title>
    <link href="<?php echo base_url(); ?>assets/backend/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/backend/css/sb-admin.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/backend/css/custom.css" rel="stylesheet" type="text/css">
    <style>
        label {
            padding: 0.20rem 0.75rem !important;
            font-size: 12px;
            color: #777;
        }
        .input-fields {
            padding-top: 1.25rem !important;
            padding-bottom: .25rem !important;
        }
        .card-header2{
            text-align: center;
            font-size: 20px;
        }
        .bg-dark {
            background: url(http://www.pct.com/assets/media/content/bg/adminBG3.jpg) no-repeat 0 0;
            background-size: cover;
            background-attachment: fixed;
        }

        .card-login {
            max-width: 25rem;
            max-height: 27rem;
            background: rgba(255, 255, 255, 0.15);
            border: none;
            border-radius: 12px;
        }
        
        .card-header2 {
            padding: 1.50rem 1.50rem;
            margin-bottom: 0;
            background-color: none;
            color: #ffffff;
            text-align: center;
            font-size: 22px;
        }

        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 10px 25px 40px 25px;
            color: #a8a8a8;
            font-size: 20px;
        }
    </style>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
    <script src="<?php echo base_url(); ?>assets/backend/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/additional-methods.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/custom.js"></script>
</head>

<body class="bg-dark">
    <div class="container">
        <div class="adlogo"><img class="normal-logo" src="http://pct.com/assets/media/general/logo2.png" alt="logo"></div>
        <div class="card card-login mx-auto mt-5">
            <div class="card-header2">PCT Transaction Desk</div>
            <div class="card-body">
                <div id="login-result">
                    <?php if(!empty($msg)){ ?>
                        <div class="col-xs-12">
                            <div class="alert alert-danger"><?php echo $msg; ?></div>
                        </div>
                    <?php } ?>
                </div>
                
                <form id="login-form" name="login-form" method="POST" action="<?php echo base_url()?>order/admin/login/do_login">
                    <div class="form-group">
                        <div class="form-label-group">
                        <input type="email" id="email_address" name="email_address" class="form-control input-fields" autofocus="autofocus">
                        <label for="inputEmail">Email address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                        <input type="password" id="password" name="password" class="form-control input-fields">
                        <label for="inputPassword">Password</label>
                        </div>
                    </div>
                
                    <input type="submit" class="btn btn-primary btn-block" value="Login">
                </form>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function(){
        if($("#login-form").length) {
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
                }
            }); 
        }
    });
</script>
</html>