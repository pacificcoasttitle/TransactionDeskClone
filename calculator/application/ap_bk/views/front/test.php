
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
              <?php include "ext-menu.php";?>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>">Home</a>
                        </li>
                        <li class="active">Create  Portfolio</li>
                    </ol>
                    <div class="clearfix">
                        
                    </div>
                    <div class="row">
                        <div class="col-md-8 pro-content  ">
                      <div class="panel panel-default flat" id="same-height">
                        <div class="panel-body" id="" >
                          <h3 class="text-uppercase panel-title">Create  Portfolio</h3>
                          <hr>
                          <form class="" action="" method="POST" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Salutation</label>
                              <select name="salutation" id="inputSalutation" class="form-control" required data-placement="right" title="Status of Publication">
                                <option value="">-- Select One --</option>
                                <option <?=($user_info->salutation == "Dr.")?"selected='true'":NULL?>>Dr.</option> 
                                <option <?=($user_info->salutation == "Prof.")?"selected='true'":NULL?>>Prof.</option>
                                <option <?=($user_info->salutation == "Mr.")?"selected='true'":NULL?>>Mr.</option>
                                <option <?=($user_info->salutation == "Ms.")?"selected='true'":NULL?>>Ms.</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">First Name</label>
                              <input type="text" class="form-control" id="inputPassword3" required pattern="^[ a-zA-Z]+$" placeholder="First Name" value="<?=$user_info->fname?>" name="fname" data-placement="right" title="First Name">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Last Name</label>
                              <input type="text" class="form-control" id="inputPassword3" required pattern="^[ a-zA-Z]+$" placeholder="Last Name" data-placement="right" title="Last Name"value="<?=$user_info->lname?>" name="lname">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Designation</label>
                              <input type="text" class="form-control" id="inputPassword3" required  placeholder="Designation" data-placement="right" title="Designation"value="<?=$user_info->designation?>" name="designation">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Department</label>
                              <input type="text" class="form-control" id="inputPassword3" required placeholder="Hospital/University associated" data-placement="right" title="Hospital/University associated"value="<?=$user_info->current_position?>" name="current_position">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Short Resume/CV</label>
                              <textarea  id="input" class="form-control" rows="3" required data-placement="right" title="Curriculum vitae" name="profile_desc"><?=$user_info->profile_desc?></textarea>
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Phone</label>
                              <input type="text" class="form-control" id="inputPassword3" required pattern="^[ 0-9]+$" maxlength="10" placeholder="Phone" data-placement="right" title="Phone" value="<?=$user_info->phone?>" name="phone">
                            </div>
                             <div class="form-group">
                              <label for="inputEmail3" class="control-label">Research Interest</label>
                              <input required type="text" maxlength="10" class="form-control" id="inputPassword3" placeholder="Research Interest"  data-placement="right" title="Research Interest" value="<?=$user_info->research_interest?>" name="research_interest">
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="control-label">Email ID</label>
                              <input type="email" class="form-control" id="inputPassword3" placeholder="Email ID" data-placement="right" title="Email ID" value="<?=$user_info->email?>" name="email" readonly>
                            </div>
                             <div class="form-group">
                        <label class="control-label" for="inputEmail3"><swap></swap>Upload Full Resume/CV</label>
                        <input id="file" type="file" name="userfile1" >
                      </div>
                           
                             <div class="form-group">
                             <div class="row">
                                   <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                    <label for="inputEmail3" class="control-label">Upload Photo</label>
                                  <input id="file" type="file" name="userfile2" >
                                   
                               </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                 <img class="img-responsive pull-right" style = "border:1px solid #ccc" src="<?=base_url()?>upload/user/<?=$user_info->userid?>/<?=$user_info->profilepic?>" onerror=" this.src = '<?=base_url()?>assets/front/images/doctor1.png'" class="imgResponsive pull-right">
                                  
                                 
                                    <div class="clr"></div>
                                 
                               </div>
                             </div>
                            
                             </div>
                            <div class="form-group">
                              <div class="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>



                          
                       
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"  >
                            <div class="panel panel-default flat bg-gray" id="main-height">
                                <div class="panel-body">
            <h4 style="margin-top:0px"><b> Activities Portfolio – A Showcase of your Research & Practice</b></h4>
                                    <hr>
                                    <!-- <p>
                                    Your  Activities Portfolio is a record of your professional activities and relating to integration and application of clinical knowledge as well as dissemination of best clinical practice. Your portfolio provides systematic information enabling viewers in making a knowledgeable assessment of your clinical contributions.</p>
                                     --><p>Your  Activities Portfolio can be used to showcase your clinical performance and scholarly contributions such as:</p>
                                    <ul>
                                    <li>Development of special programs that attract referrals and boosts the reputation of the Hospital/Clinic based on best practice methods</li><br>
<!-- <li> Reflections on your strategic role in developing clinical practice/ development of clinical practice guidelines</li><br>
 --><li>Development of textual, audio-video or computer‐based teaching materials for use by medical professional or the general with the scope of advancing patient care</li><br>
<li> Oral presentations disseminating findings of best practices through the medium of oral presentations invited talks, Grand Rounds or CME events</li><br>
<li>Your role in dissemination of scholarly findings through published case reports, clinical investigation reports; reviews, commentaries, analytic studies in peer‐reviewed journals or content that helps organize, synthesize and convey clinical knowledge</li><br>
<li>Your role as a member or leader on major committees, licensing or accrediting bodies and/or professional societies, quality assurance committees, etc.</li><br>
<li> As an exceptional role model in imparting optimal patient care</li><br>
<li> Other contributions to your discipline or special area of interest such as design of methods to estimate outcomes of care; contributions towards improving training program within the clinical unit.</li><br>
<li>Reflections on your receipt of formal awards/recognition for excellence in clinical service</li><br>
<li>Your efforts in self‐evaluating and upgrading in relation to clinical skills</li>
</ul>
<!-- <p><b>Let your Profile Measure Your Research Impact. Create one now!</b></p> -->
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