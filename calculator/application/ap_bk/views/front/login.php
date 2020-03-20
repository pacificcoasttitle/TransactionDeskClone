
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
              <?php include "ext-menu.php";?>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>">Home</a>
                        </li>
                        
                        <li class="active">Login</li>
                    </ol>
                    <div class="clearfix">
                        
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <div class="panel panel-default flat" id="main-height">
                                <div class="panel-body"id="form-olvidado">
                                    <h3 class="text-uppercase panel-title">Login</h3><hr>
                                    <p>&nbsp;</p>
                                    <div class="clearfix">
                                        
                                    </div>
                                    <form  class="login-form" id = "login_form" method="post" onsubmit ="return do_login()">
                                    <div id="output" style="display:none;">
                                    <div id="output_div" class="alert alert-danger">
                                        <span id="output_body"></span>
                                    </div>
                                </div>
                                        <div class="form-group">
                                            <label class=" control-label sr-only" for="inputEmail3">Email</label>
                                            <input type="email" placeholder="Username"name="email"  id="email_id" class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class=" control-label sr-only" for="inputPassword3">Enter Password?</label>
                                            <input type="password" placeholder="Password"name="password"  id="password" class="form-control">
                                        </div>
<?php if(isset($_GET['return'])){?>
                                         <input type="hidden" name="return" id="inputReturn" class="form-control" value="<?php echo $_GET['return']?>">
           
            <?php } else{?>
                                         <input type="hidden" name="return" id="inputReturn" class="form-control" value="">
            
        <?php }?>

                                        <div class="form-group ">
                                            <button class="btn btn-primary btn-sm" type="submit">Sign in</button>
                                            <a href="<?=base_url()?>signup" class="btn btn-success btn-sm">Create Account</a>
                                             <a  class="pull-right pull-down" onclick="forget_req()" id="olvidado">Forgot Your Password?</a>
                                        </div>
                                        <div class="form-group l-btn">
                                           
                                            <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive" alt="Image" id="loading1" style="display:none;">
                                        </div>
                                        <div class="clearfix">
                                            <span><hr><div class="or">Or</div></span>
<br>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                                <a href="javascript:;" class="btn btn-defaut btn-lg btn-white btn-social "><i class="s-icon"><img src="<?=base_url()?>assets/front/images/fb.png"></i> Sign in With Facebook</a>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                                <a href="javascript:;" class="btn btn-defaut btn-lg btn-white btn-social "><i class="s-icon"><img src="<?=base_url()?>assets/front/images/google.png"></i> Sign in With Google Plus</a>
                                            </div>
                                        </div>
                                        <br>

                                    </form>
                                </div>

                                <div  style="display:none;" class="panel-body" id="form-olvidado_req">
                                 <h3 class="text-uppercase panel-title">
                                  Forgot password?
                                </h3>
                               <p> &nbsp;</p>
                                    <div class="clearfix">
                                        
                                    </div>
                                <form accept-charset="UTF-8" role="form" id="forget_login" method="post">
                                  <fieldset>
                                    <span class="help-block">
                                      Email address you use to log in to your account
                                      <br>
                                      We'll send you an email with instructions to choose a new password.
                                    </span> 
                                     <div class="form-group">
                                            <label class=" control-label" for="inputEmail3">Enter Email id</label>
                                            <input type="email" name="email" placeholder="Email" id="for_email_id" class="form-control" required="">
                                        </div>
                                    <span id="msg_txt"></span>
                                    <img src="<?=base_url()?>assets/front/images/loading.gif" class="img-responsive" alt="Image" id="loading2" style="display:none;">
                                    <div class="clearfix">
                                    
                                    </div>
                                    <button type="button" class="btn btn-primary " id="forget_btn">
                                      Continue
                                    </button> &nbsp;
                                    
                                    <a  href="#" onclick="login_req()" id="acceso">Account Access</a>
                                   
                                   
                                    <p class="help-block">
                                     
                                    </p>
                                  </fieldset>
                                </form>
                              </div>



                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"  >
                            <div class="panel panel-default flat bg-gray" id="same-height">
                                <div class="panel-body">
                                    
                                     <h4 class="no-margin mar-bottom-5" style="font-size:18px"><b>MyReposit.com</b></h4>
                                     <h5 class="no-margin">Clinical Data Repository with Publishing Support Services</h5> 
                                    <hr>
                                    <p>MyReposit is a repository of scholarly experience knowledge, and data preservation. It seamlessly provides researchers, clinicians, scientists, and institutes a rich ecosystem of communication, long-term data sharing and preservation and a complete range of publication support service</p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
  

  <script src="<?=base_url()?>assets/front/js/jquery.min.js"></script>
<script type="text/javascript">
    /* attach a submit handler to the form */
    function check_email()
    {
        var email_id = document.getElementById("email_id").value;
        //alert(email_id);
        if(email_id == "")
        {

            $("#output_body").html("Enter Username and Password or Create Account");
            $("#output").show();
            $("#loading1").hide();
            $("#btn").attr("disabled","disabled");
            return false;
        }
        else
        {
            $("#output_body").html("");
            $("#output").hide();
            $("#output_div").attr("class","alert alert-danger");
            
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email_id))
            {
                $("#output_body").html("INCORRECT EMAIL ID! ");
                $("#output").show();
                $("#btn").attr("disabled","disabled");
                 $("#loading1").hide();
                return false;
            }
            else
            {
                $("#btn").removeAttr("disabled");
                return true;
            }
        }
    }

    function do_login()
    {
        $("#loading1").show();
        $("#output").hide();
        if(!check_email())
        {
            return false;
        }
        var password = $("#password").val();
        if(password == "")
        {
            $("#output_body").html("Please fill password.!!");
            $("#output").show();
            return false;
        }
        <?php if(isset($_GET['return'])){?>
            var reurl = "<?php echo $_GET['return']?>";
            <?php } else{?>
            var reurl = "";
        <?php }?>
        var form_data = $("#login_form").serialize();
        $.ajax({
            url     : "<?=base_url()?>index.php/welcome/login_user",
            type    : "POST",
            data    : form_data,
            success : function( data )
            {
                var ex = data.split(",");
                data = ex[0];
                type1 = ex[1];
                if(data == "1")
                {
                    $("#loading1").hide();
                    if(reurl != "")
                    {
                        window.location.assign('<?=base_url()?>'+reurl);
                    }
                    else{
                        window.location.assign('<?=base_url()?>all-profiles/');
                    }
                    
                }
                else if(data == "0")
                {
                    $("#output_body").html("Email ID or Password is Incorrect!");
                    $("#output").show();
                    $("#loading1").hide();
                }
                else if(data == "#")
                {
                    $("#output_body").html("Please check your email and verify your account.");
                    $("#output").show();
                    $("#loading1").hide();
                }
                else if(data == "##")
                {
                    $("#output_body").html("Your Email id is verified. But Your Profile is not accepted By Admin panel.");
                    $("#output").show();
                    $("#loading1").hide();
                }
            },
            error   : function( xhr, err )
            {
                alert('Connection Problem !!');
                return false;
            }
        });
return false;
    }

function forget_req () 
{
    $("#form-olvidado").hide();
    $("#form-olvidado_req").show();

}
function login_req () 
{
    $("#form-olvidado").show();
    $("#form-olvidado_req").hide();

}

$("#forget_btn").click(function(){
     var email_id = document.getElementById("for_email_id").value;
        $("#loading2").show();
        if(email_id == "")
        {
            $("#msg_txt").html("Please provide your email id.");
            return false;
        }
        else
        {
            $("#msg_txt").html("");
            $("#output_div").attr("class","alert alert-danger");
            
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email_id))
            {
                $("#msg_txt").html("Email id is not correct.!!");
                $("#loading2").hide();
                return false;
            }
        }
        $.post( 
             "<?=base_url()?>index.php/welcome/forget_password",
             $("#forget_login").serialize(),
               function(data)
              {
                
                if(data =='0')
                {
                  $("#msg_txt").html("A new password has been sent to this email id !!"); 
                   $("#msg").show();
                   $("#loading2").hide();
                }
                if(data =='1')
                {
                   $("#msg_txt").html("This email id is not registered !!"); 
                   $("#msg").show();
                    $("#loading2").hide();
                }
             }
          );  
  });


</script>