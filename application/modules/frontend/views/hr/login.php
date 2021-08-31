<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Center - Pacific Coast Title Company</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/hr/css/iofrm-style.css">
    <style>
        ul {
            list-style: none;
            color: red;
            padding: 0px;
        }
    </style>
</head>

<body>
    <div class="form-body without-side">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="<?php echo base_url(); ?>assets/media/hr/logo2.png" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="images/graphic3.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>PCT HUB</h3>
                        <p>Access to the most helpful resources that we have to offer.</p>
                        <form data-parsley-validate="" name="login_form" id="login_form" method="post"> 
                            <input class="form-control" type="email" name="email" id="email" placeholder="E-mail Address" data-parsley-trigger="change" data-parsley-required-message="Please enter email address" required>
                            <?php if(!empty($email_error_msg)){ ?>         
                                <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                    <li class="parsley-required"><?php echo $email_error_msg;?></li>
                                </ul>
                            <?php } ?>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password" data-parsley-required-message="Please enter password" required>
                            <?php if(!empty($password_error_msg)){ ?>     
                                <ul class="parsley-errors-list filled" id="parsley-id-7" aria-hidden="false">
                                    <li class="parsley-required"><?php echo $password_error_msg;?></li>
                                </ul>
                            <?php } ?>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button> 
                                <a href="">&nbsp | &nbsp Forget password?</a>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/parsley.min.js"></script>
    
</body>

</html>