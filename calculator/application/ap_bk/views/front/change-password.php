
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include "ext-menu.php";?>
                
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Change Password</li>
              </ol>
              <div class="clearfix"></div>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-3 pro-nav">
                  <div class="panel panel-default flat">
                    <div class="my-account-sidebar">
                      <div class="affix-sidebar">
                        <!-- start main side bar tab -->
                        <div class="sidebar-nav">
                          <div class="navbar" role="navigation">
                            <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".sidebar-navbar-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                              <span class="visible-xs navbar-brand">Sidebar menu</span></div>
                              <?php include 'dashboard-menu.php';?>
                              <!--/.nav-collapse -->
                            </div>
                          </div>
                        </div>
                        <!-- end main side bar tab -->
                        <div class="clr"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9 pro-content">
                    <div class="panel panel-default flat">
                      <div class="panel-body" id="" >
                        <h3 class="text-uppercase panel-title">CHANGE PASSWORD</h3>
                        <hr>
                        <form class="" method="POST" role="form" onsubmit = "return validate();" id="change_form">
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label"><swap>* </swap>Old Password</label>
                            <input type="password" class="form-control" id="old_password"  required="required" name = "password_old" placeholder="Old Password" data-toggle="tooltip" data-placement="right" title="Old Passsword">
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label"><swap>* </swap>New Password</label>
                            <input type="password" class="form-control"  placeholder="" data-toggle="tooltip" id="password"  required="required" name = "password" data-placement="right" title="New Password" >
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="control-label"><swap>* </swap>Confirm Password</label>
                            <input type="password" class="form-control"  placeholder="" id="password_confirm"  required="required" name = "password_cnew"  data-toggle="tooltip" data-placement="right" title="Confirm New Password" >
                          <span id="error" class="text-danger"></span>
                          </div>
                          
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
  <script src="<?=base_url()?>assets/front/js/jquery.min.js"></script>
            

            <script>
    function validate()
    {
      $("#error").html("");  
      $("#error").hide();  
      var new1 = $("#password").val();
      var new2 = $("#password_confirm").val();
      if(new1 != new2)
      {
         $("#error").html("Confirm password  is not same.!!");
          $("#error").show();  
          return false;
      }
        var old = $("#old_password").val();
        $.ajax({
            url     : "<?=base_url()?>index.php/user/get_password?pass="+old,
            type    : "post",
            success : function( data ) {
                            if(data == '0')
                            {
                               
                                 $("#error").html("Old password is not correct.!!");
                                 $("#error").show();
                                 return false;
                            }
                            else{
                               form_submit();
                               return true;
                            }   
                      },
            error   : function( xhr, err ) {
                        alert('Connection Problem');

                        $("#loading").hide();
     
                      }

        });
   return false;
  }


    function form_submit () 
    {
        var postData = $("#change_form").serialize();
   

      $.ajax({
          type: 'POST',
          url: '<?=base_url()?>index.php/user/update_password/',
          data: postData,
          success: function(response){
             location.reload();
          },
          error: function(){
              alert('connection problem');
          }
      });
    }

</script>