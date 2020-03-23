<?php 

$page_no = 1;

if(isset($_GET['page']))
{
    if($_GET['page'])
    {
        $page_no = $_GET['page'];
    }
}


?>

    <div class="container">
        <div class="content-wrapper">
            <section id="content">
                <?php include 'ext-menu.php';?>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>">Home</a>
                    </li>
                    <li class="active">FAQs </li>
                </ol>
                <div class="clearfix">
                </div>
                <div class="panel panel-default flat">
                    <div class="panel-body">
                        <h3 class="text-uppercase panel-title">Frequently Asked Questions (FAQ<span style="text-transform:none;">s</span>)<span class="pull-right"><a href="javascript:;" class="btn btn-default btn-xs" id="expandall">Expand All</a> <a href="javascript:;" class="btn btn-default btn-xs" id="collapseall">Collapse All</a></span></h3><hr>
                     <?php if ($page_no == 1): ?>

                       <h4><b>Account settings</b></h4>
                      
<!-- Question Start -->
                            <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid2342" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Manage account settings
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid2342">
                                 <p>You can manage your own account settings very easily. Here is what you have to do.
Click on the arrow located on the top right-hand side corner of any page.Select <b>SETTINGS</b> from the menu.
From this menu, you can now manage your password, email notifications, dashboard settings, author name, etc. You can also adjust your public profile through this same tab.

</p>
                                </div>
                            </div>
                            <!-- question end -->



                            <!-- Question Start -->
                            <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Changing Password
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid">
                                 <p> Here is how you change your password</p>
                                 <ul>
<li>Log in to MyReposit.</li>
<li>Go to your Account Settings page.</li>
<li>Click on the page and scroll down until you reach the Password section.</li> 
<li>Type your current password into the box.</li>
<li>Type your new password into the second and third boxes.</li>
<li>Click on Save.</li>
<li>Log into the account again to verify your new password.</li>
</ul>
                                </div>
                            </div>
                            <!-- question end -->
                             <!-- Question Start -->
                            <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid2" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Changing account name
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid2">
                                 <p> Here is how you change your account name</p>
                                 <ul>
<li>Go to Account Settings.</li>
<li>Click on Name Information.</li>
<li>Scroll down to the Edit button.</li> 
<li>Update your name in the box.</li>
<li>Click on Save and the changes are done.</li>
</ul>
<p>Please note that you can only change your name and password three times in a 30-day period. You can also add pen names under the same heading. For example, if you’ve published your papers under an alternative name or a pen name, you can list these names under your account and will add these publications after your name has been verified. If you want to bypass this manual verification process, you can open another account with your penname or you can add an alternative author name.</p>
                                </div>
                            </div>
                        <!-- question end -->
                         <!-- Question Start -->
                            <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid3" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Changing login email address
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid3">
                                 <p> Here is how you change your email address </p>
                                 <ul>
<li>Click on your Account Settings page.</li>
<li>Click on Email Address.</li>
<li>Click on Add Additional Email.</li> 
<li>Put in the extra email address.</li>
<li>Click on Save and the extra email address is saved.</li>
<li>A confirmation email is sent to your email box.</li>
<li>Click on the link in the email and this completes the verification process.</li>
<li>Go to the Accounts Settings page.</li>
<li>Click on the Set As Login button next to the email you have just put in. This will make it the primary email address for your account at MyReposit.</li>
<li>Make sure you use this email address when you log in to your MyReposit account.</li>
</ul>
                                </div>
                            </div>
                        <!-- question end -->
                   
                        <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid4" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>I haven't received the account activation email
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid4">
                                 <p> Sometimes it takes a few minutes for the mail to reach your email box. Ni case you haven’t received the email, please make sure you check the SPAM or JUNK folders of your email box. If you still haven’t received the email, please do get in touch with us and request a new account activation email. There is a chance that the new account activation email will take some time to arrive. In case this happens, you are welcome to send an email to support@MyReposit.net. When you do this, we can verify your email address manually and activate your account immediately.  </p>
                                </div>
                            </div>
                        <!-- question end -->
                        <h4><b>Passwords</b></h4>
                        <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid5" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Changing your password
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid5">
<p>Here is how you change your password</p>
<ul>
<li>Log in to MyReposit.</li>
<li>Go to your Account Settings page.</li>
<li>Click on the page and scroll down until you reach the Password section. </li>
<li>Type your current password into the box.</li>
<li>Type your new password into the second and third boxes.</li>
<li>Click on Save.</li>
<li>Log into the account again to verify your new password.</li>
</ul>
                                </div>
                            </div>
                        <!-- question end -->

                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid6" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Forgot your password?
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid6">
<p>You can reset your password in the following way</p>
<ul>
<li>Click on the Forgot Password link available on the login page.</li>
<li>You are redirected to a new page.</li>
<li>Put your email address in the requisite box. </li>
<li>We will send you a password reset link in 24 hours via email.</li>
<li>Follow the instructions in the email to reset your password.</li>
</ul>
        <p>Please note, it does take some time for the email to reach you. Please wait for 24 hours before you send another request for resetting your password. In case you haven’t received, your password reset mail even after 24 hours. Here is what you can do. </p>
                                </div>
                            </div>
                        <!-- question end -->
                          <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid7" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Haven’t received the password reset email?
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid7">
<ul>
<li>Start by checking your Junk or Spam folders.</li>
<li>Add the customer support email address from MyReposit to your address book. You can find out more at this link.</li>
<li>Reset your password by clicking on the Forget Your Password link on the login page. </li>
<li>Contact the customer support section at MyReposit for more help or email us directly @MyReposit for more help.</li>
</ul>
                                </div>
                            </div>
                        <!-- question end -->
                        <h4><b>Updating your account name</b></h4>
                        <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid8" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Changing account name
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid8">
<p>Here is how you change your account name</p>
<ul>
<li>Go to Account Settings.</li>
<li>Click on Name Information.</li>
<li>Scroll down to the Edit button. </li>
<li>Update your name in the box.</li>
<li>Click on Save and the changes are done.</li>
</ul>
<p>Please note that you can only change your name and password three times in a 30-day period. You can also add pen names under the same heading. For example, if you’ve published your papers under an alternative name or a pen name, you can list these names under your account and will add these publications after your name has been verified. If you want to bypass this manual verification process, you can open another account with your penname or you can add an alternative author name.</p>

                                </div>
                            </div>
                        <!-- question end -->
                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid9" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> Why can't I change my account name? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid9">
<p>Due to security reasons, you are only allowed to change your account name three times in a 30-day period. Once the 30-day period has passed, you can change your account name again.</p>

                                </div>
                            </div>
                        <!-- question end -->
                        <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid10" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> What's the difference between my account name and my author name?
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid10">
<p>Your account name is the name you use in your profession. It will help your friends, family, and colleagues to identify you and your work. Your author name covers nearly every other name that you might have used during your publication. When adding publications to your profile, you may have trouble confirming authorship of your work if the name you published under doesn't match your account name. You may have problems while adding another name to your account. In this case, you can use the ‘adding an alternative author name’help process to hasten the process. </p>                    
        </div>
                            </div>
                        <!-- question end -->
                        <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid11" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> How do I add an alternative author name? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid11">
<ul>
<li>Go to Account Settings.</li>
<li>Click on Name Information.</li>
<li>Click on Edit.</li>
<li>Select the Add An Alternative Name in the box.</li>
<li>Update your profile.</li>
<li>Click on Save.</li>
</ul>                            </div>
</div>
                        <!-- question end -->
                        <h4><b>Managing your email settings</b></h4>
                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid12" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Changing login email address 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid12">
<ul>
<li>Click on your Account Settings page.</li>
<li>Click on Email Address.</li>
<li>Click on Add Additional Email.</li>
<li>Put in the extra email address.</li>
<li>Click on Save and the extra email address is saved.</li>
<li>A confirmation email is sent to your email box.</li>
<li>Click on the link in the email and this completes the verification process.</li>
<li>Go to the Accounts Settings page.</li>
<li>Click on the Set As Login button next to the email you have just put in. This will make it the primary email address for your account at MyReposit.</li>
<li>A confirmation email is sent to your email box.</li>
<li>Make sure you use this email address when you log in to your MyReposit account.</li>
</ul>                            
</div>
</div>
                        <!-- question end -->
                        <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid13" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Not receiving the email confirmation? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid13">
<ul>
<li>Start by checking your email account and verify that your Junk or Spam folders do not contain the email. </li>
<li>Add the customer support email address from MyReposit to your address book. You can find out more at this link.</li>
<li>Log in to your MyReposit account.</li>
<li>Go to Account Settings and verify that you’ve added your new login email address</li>
<li>Reset your password by clicking on the Forget Your Password link on the login page</li>
<li>Contact the customer support section at MyReposit for more help or email us directly @MyReposit for more help.</li>
</ul>                            
</div>
</div>
                        <!-- question end -->
                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid14" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> Can I use multiple email addresses on MyReposit? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid14">
<p>Yes, you can and you can add your institutional email address and a private email address to your MyReposit account. Go to the Accounts Setting Age and follow the steps mentioned in the Add Email Section.</p>                            
</div>
</div>
                        <!-- question end -->
                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid15" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Managing your email notifications  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid15">
<p>If you sign up for the email notifications system, you will receive regular updates about what is happening at MyReposit. Here is what you can do:</p>                            
<ul>
<li>Go to Notification Settings.</li>
<li>Click on the box stating you want to receive regular notifications.</li>
</ul>
<p>Even if you have not signed up for the notifications process, you will still be notified when your RG score is activated. However, this will happen just once. You may also get Password Reset Emails if you decide to reset your password. </p>

</div>
</div>
                        <!-- question end -->
                          <h4><b>Security and privacy</b></h4>
                          <!-- Question Start 
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid16" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I log out of MyReposit?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid16">
<ul>
<li>Go to the top right-hand side of any MyReposit page.</li>
<li>Click on the arrow.</li>
<li>Click on Log Out on the drop down menu.</li>
<li>To log back into MyReposit, go to MyReposit.net.</li>
</ul>
</div>
</div>
                       question end -->
                          <!-- Question Start 
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid17" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How much information is visible on my profile?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid17">
<p>
You can control how much information you display on your account or your profile page. Here is how you can change your public profile.</p>
<ul>
<li>Go to Privacy Settings.</li>
<li>Click on Research Data.</li>
<li>Select the drop down menu and browse through it.</li>
<li>Choose the people you want to see your profile on the tab by clicking on Mutual followers, MyReposit members, or Everyone.</li>
<li>Click Save .</li>
</ul>
</div>
</div>
                        question end -->

 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid18" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Is my MyReposit profile visible to search engines?   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid18">
<p>Yes, your MyReposit profile is activated as soon as you open your account. Here is how you can manage the people who see your profile.</p>
<ul>
<li>Go to Privacy Settings.</li>
<li>You will be offered two settings ‘Enable’ or ‘ Disable’.</li>
<li>This will control your public page display.</li>
<li>You can also set up whether you want your public profile to display your profile photo, questions, and answers..</li>
<li>Click on Save.</li>
</ul>
</div>
</div>
                        <!-- question end -->
                        <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid19" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>My profile isn’t appearing in search engines    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid19">
<p>Usually, search engines automatically indexed MyReposit pages and they become visible online immediately. However, it may take a little time for some of these pages to appear online. </p>
</div>
</div>
                        <!-- question end -->
                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid20" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>My profile is still appearing in search engines    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid20">
<p>Search engines index pages very fast. As a result, you may still see your profile online even if you have selected the limited visibility option on your dashboard. </p>
</div>
</div>
                        <!-- question end -->
                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid21" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Who can see my contact details?   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid21">
<p>Only the people you have selected can see your profile. For example, mutual followers, researchers and selected contacts can see your personal details.</p>
</div>
</div>
                        <!-- question end -->
                        <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid22" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How can I block someone on MyReposit?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid22">
<p>You can block followers on MyReposit by taking these few steps:</p>
<ul>
<li>Click  on the profile of the person you want to block.</li>
<li>Click no the Info tab.</li>
<li>Move down to the bottom right hand side of the screen.</li>
<li>Click on the Block Researcher tab.</li>
</ul>
<p>Please note that once you have blocked a person, you will not be able to send them messages or find updates about them. This blocking works both ways and they will not be able to see updates about your or get messages about you.</p>
</div>
</div>
                        <!-- question end -->
                         <h4><b>Account deletion</b></h4>
                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid23" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Deleting your account  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid23">
<p>You should know that deleting your account is a permanent step and we cannot undo this move. Before you delete your account, you should know that you could change your account name, your affiliation and your email address without having to close your email account. You can also manage your profile, manage your email settings and block people through the Account Setting tab on your dashboard. In case you want to limit your profile, you can change your Privacy Settings and Notification Settings to protect your identify. For more information, get in touch with the otherwise RG Community Support. </p>
</div>
</div>
                        <!-- question end -->
                         <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid24" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> Still want to delete your account?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid24">
<p>Here is what you can do :</p>
<ul>
<li>Access Account Settings.</li>
<li>Scroll down to bottom of page.</li>
<li>Click the red Delete My Account tab.</li>
<li>If you change your mind, you will have to open an account again. You can do this by going to MyReposit and click on the Join For Free button. .</li>
</ul>
</div>
</div>

                        <!-- question end -->
<?php endif ?> 

<?php if ($page_no == 2): ?>
    

                         <h4><b>Profile basics</b></h4>
 <p>You can get in touch with other researchers in this section. You can share your knowledge, connect with researchers and identify experts in your field. Here is how you navigate this section.</p>
                         
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid25" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I view my profile?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid25">
<p>All you have to do is log into your MyReposit account and click on the right hand corner of the webpage and click on Select Your Profile.</p>
</div>
</div>
 <!-- question end -->

 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid26" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How much information is visible on my profile? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid26">
<p>You can choose just how much information to share online. Here is what you can do:</p>
<ul>
<li>Open your account.</li>
<li>Click on your Privacy Settings.</li>
<li>Select the menu underneath Research Data.</li>
<li>Click on the person you want to share your information with. You can choose fromMutual followers, MyReposit members, or Everyone.</li>
<li>Click Save.</li>
</ul>
</div>
</div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid27" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Is my MyReposit profile visible to search engines? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid27">
<ul>
<li>Click on Privacy Settings.</li>
<li>Select whether to Enable or Disable your public page.</li>
<li>Choose your exposure level.</li>
<li>Click Save .</li>
</ul>
</div>
</div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid28" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How much information is visible on my profile? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid28">
<ul>
<li>Access your Account Settings page.</li>
<li>Click on the Edit button located underneath the Name information.</li>
<li>Change your name in the indicated box.</li>
<li>Click Save. You can change your name only three times a month. .</li>
</ul>
</div>
</div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid29" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I ask a question in Q&A? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid29">
<ul>
<li>Access the Q&A overview page.</li>
<li>There will be a box called Ask A Question located at the top right-hand corner.</li>
<li>Phrase your question and paste it in the box.</li>
<li>Explain the question as much as possible and provide details. .</li>
<li>Attach supportive data that will explain the question like publications, images, graphs, or links This is optional..</li>
<li>Click Ask.</li>
</ul>
</div>
</div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid30" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I edit a question I asked? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid30">
<ul>
<li>Navigate to the Question’s page.</li>
<li>There will be aPencil icon next to the word Question.</li>
<li>Hover your mouse and click Edit.</li>
<li>Edit your question.</li>
<li>Click Save.</li>
</ul>
</div>
</div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid31" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Editing and deletion policy
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid31">
                                <p>Q&A is a general forum for queries. However, questions may be deleted if they are:</p>
<ul>
<li>General questions that can be covered by a quick online search.</li>
<li>Advertisements.</li>
<li>Broad questions that do not have a clear answer.</li>
<li>Career applications (search for jobs on MyReposit).</li>
<li>Repeated questions.</li>
<li>Publication requests.</li>
<li>Private messages.</li>
</ul>
</div>
</div>
 <!-- question end -->
<!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid32" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>What is upvoting and downvoting? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid32">
                                <p>MyReposit has an upvoting and downvoting section in which questions are voted for their relevance and popularity. This promotes high-quality questions and provides valuable feedback for the author. Questions that are upvoted frequently are marked as Popular Answers. We do have a request. In case you want to downvote questions, get in touch with us first by Flagging the question. We will review the question and do the needful.</p>
</div>
</div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid33" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                         <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I find relevant questions in Q&A?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid33">
                                <p>The MyReposit dashboard matches your qualifications to the questions and answers on the site. These related questions will appear on the Questions We Think You Can Answer sidebar of your Q&A overview page dashboard. Make sure you update your skills and qualifications regularly to be sent related questions and answers. You can use these filters too ‘Recent Questions In Your Field, Questions You Follow, And Questions You Asked’ to find questions and answers on the website. In case you want to search yourself, you can use the Search MyReposit option to find more questions. </p>
      </div>
    </div>
 <!-- question end -->
<h4><b>Asking questions</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid34" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I ask a question in Q&A?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid34">
                                <ul>
                                <li>Access the Q&A overview page.</li>
<li>There will be a box called Ask A Question located at the top right-hand corner.</li>
<li>Phrase your question and paste it in the box.</li>
<li>Explain the question as much as possible and provide details. .</li>
<li>Attach supportive data that will explain the question like publications, images, graphs, or links This is optional..</li>
<li>Click Ask.</li>

                                </ul>
      </div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid35" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Who sees my question? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid35">
                                <p>All followers and researchers will see the question and they will answer it to the best of their abilities. </p>
                                <ul>
                                <li>Go to the Q&A overview page</li>
<li>Select Questions from the list on the right-hand side.</li>
<li>You can also scroll down to see a list of all the questions that are related to your profile’s on your profile’s Contributions tab</li>
<li>Select Questions button located on the right-hand side</li>

                                </ul>
      </div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid36" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I make sure my question gets the best answers? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid36">
                                <ul>
                                <li>Keep your questions simple and straightforward</li>
<li>Provide as many details as possible so that answering the question is easy</li>
<li>Attach supportive documents or data as required</li>
<li>Use clear simple English to ask the question</li>
<li>Profiles with a photo are viewed more and you are more likely to get a faster reply.</li>
                                </ul>
      </div>
    </div>
 <!-- question end -->
 <h4><b>Adding answers</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid37" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I answer a question?
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid37">
                                <ul>
                                <li>Access the field below the question.</li>
<li>Fill it in with your answer or copy paste the answer.</li>
<li>Attach supportive documentation as required.</li>
<li>When you are done, click on the Add Answer tab.</li>
<li>You can also follow all the questions you have answered by going to the Q&A overview page.</li>
<li>Click on the Questions You Follow tab and you will see your answers..</li>

                                </ul>
      </div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid38" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Where can I see the answers I added?
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid38">
                                <ul>
                              <li>Go to your profile on your MyReposit account.</li>
<li>  Click on the Contributions tab.</li>
<li>  Click on Answers on the right-hand side and</li>
<li>  See the answers you’ve added to other researchers’ questions.</li>
                                </ul>
      </div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid39" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>What makes a good answer?
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid39">
                                <p>A good answer is complete with detailed information and a complete solution to the asked question. Attaching proof like publications, images, graphs, or links can add weight to your answer. </p>
      </div>
    </div>
 <!-- question end -->
 <h4><b>Following questions</b></h4>
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid40" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>What does it mean to follow a question? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid40">
                                <p>You can follow a question if you find it interesting or if you find it relevant to your body of research. You will automatically follow questions you ask, answer or upvote. Go to the Q&A overview page and click on the Questions You Followtab on the right-hand side of the page. </p>
                                </div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid41" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I follow a question? 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid41">
                                <p>You will automatically follow questions you ask, answer or upvote. To manually follow a question, click on the Follow button located on the right hand side of the page.</p>
                                </div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid42" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I find questions I’m following?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid42">
<ul>
<li>Go to the Q&A overview page.</li>
<li>Click on the Questions You Follow tab on the right-hand side.</li>
</ul>                                </div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid43" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I unfollow a question?   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid43">
<ul>
<li>Search out the question’s page.</li>
<li>Find the Following button.</li>
<li>Hover your mouse over the button.</li>
<li>Click to Unfollow.</li>

</ul>
   </div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid44" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>What is upvoting and downvoting?   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid44">
<p>MyReposit has an upvoting and downvoting section in which questions are voted for their relevance and popularity. This promotes high-quality questions and provides valuable feedback for the author. Questions that are upvoted frequently are marked as Popular Answers. We do have a request. In case you want to downvote questions, get in touch with us first by Flagging the question. We will review the question and do the needful.</p>
   </div>
    </div>
 <!-- question end -->
 <?php endif ?>
 <?php if ($page_no == 3): ?>
     

 <h4><b>Finding questions and answers</b></h4>
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid45" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I find relevant questions on Q&A?   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid45">
<p>The MyReposit dashboard matches your qualifications to the questions and answers on the site. These related questions will appear on the Questions We Think You Can Answer sidebar of your Q&A overview page dashboard. Make sure you update your skills and qualifications regularly to be sent related questions and answers. You can use these filters too ‘Recent Questions In Your Field, Questions You Follow, And Questions You Asked’ to find questions and answers on the website. In case you want to search yourself, you can use the Search MyReposit option to find more questions. </p>
   </div>
    </div>
 <!-- question end -->
   <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid46" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Now that I've asked a question, where can I see it?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid46">
<ul>
<li>Go to the Q&A overview page </li>
<li>Select Questions from the list on the right-hand side. </li>
<li>You can also scroll down to see a list of all the questions that are related to your profile’s on your profile’s Contributions tab </li>
<li>Select Questions button located on the right-hand side.</li>

</ul>   </div>
    </div>
 <!-- question end -->
    <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid47" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Where can I see the answers I added?  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid47">
<ul>
<li>Go to your profile on your MyReposit account.</li>
<li>Click on the Contributions tab.</li>
<li>Click on Answers on the right-hand side and.</li>
<li>See the answers you’ve added to other researchers’ questions.</li>

</ul>  
 </div>
    </div>
 <!-- question end -->
  <h4><b>Sharing questions</b></h4>
     <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid48" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I share my question on MyReposit?   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid48">
<ul>
<li>Log in to your account and open your Question Page.</li>
<li>Find the relevant question.</li>
<li>Click the Sharebutton located under the question.</li>
<li>Select one of the options located under‘Share With Other Researchers’ or ‘Share On Live Feed’.</li>
<li>Choose sharing options and click Share.</li>
</ul>  
 </div>
    </div>
 <!-- question end -->
   <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid49" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I share my question on other sites?    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid49">
<ul>
<li>Log in to your MyReposit account.</li>
<li>Access your question page and click on the Share button.</li>
<li>When you click on the option, the website will automatically share the question on Facebook, Twitter, LinkedIn, or Google+.</li>
<li>Log in to the external website when prompted.</li>
<li>Click on Share and Save.</li>
</ul>  
 </div>
    </div>
 <!-- question end -->
<h4><b>Editing and deleting</b></h4>
<!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid50" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I edit a question I asked?    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid50">
<ul>
<li>Access your website dashboard.</li>
<li>Go to the question’s page on your dashboard.</li>
<li>Access the Question.</li>
<li>Locate the Pencil icon next to the question.</li>
<li>Hover your mouse over the pencil icon .</li>
<li>Click Edit and make your changes to the question.</li>
<li>Click Save to confirm your changes.</li>
</ul>
 </div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid51" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Why was my question edited?    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid51">
<p>Minor changes may be done to a question to make it read better or more relevant. You will be notified in the case of small edits but for larger edits, you will receive an email. To prevent this from happening, make sure you check your question before you submit it to the website.</p>
</ul>
 </div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid52" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I delete a question I asked?     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid52">
<ul>
<li>Access the website.</li>
<li>Open your questions page.</li>
<li>Click on the arrow on the right-hand corner of the page.</li>
<li>Select the question.</li>
<li>Click on Delete.</li>
</ul>
 </div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid53" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Editing and deletion policy    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid53">
<p>Q&A is a general forum for queries. However, questions may be deleted if they are:</p>
<ul>
<li>General questions that can be covered by a quick online search.</li>
<li>Advertisements.</li>
<li>Broad questions that do not have a clear answer.</li>
<li>Career applications (search for jobs on MyReposit).</li>
<li>Repeated questions.</li>
<li>Publication requests.</li>
<li>Private messages.</li>
</ul>
 </div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid54" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Editing and deletion policy    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid54">
<p>If your question came into the categories listed above, it was automatically deleted. Make sure that your questions are specific to remain on the website. </p>
 </div>
    </div>
 <!-- question end -->
<h4><b>Your Contact Information</b></h4>
<!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid55" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Changing your login email address     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid55">
<ul>
<li>Click on your Account Settings page.</li>
<li>Click on Email Address.</li>
<li>Click on Add Additional Email.</li>
<li>Put in the extra email address.</li>
<li>Click on Save and the extra email address is saved.</li>
<li>A confirmation email is sent to your email box. .</li>
<li>Click on the link in the email and this completes the verification process..</li>
<li>Go to the Accounts Settings page.</li>
<li>Click on the Set As Login button next to the email you have just put in. This will make it the primary email address for your account at MyReposit..</li>
<li>Make sure you use this email address when you log in to your MyReposit account..</li>
</ul> 
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid56" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Updating your contact details      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid56">
<ul>
<li>Open your account.</li>
<li>Access your profile.</li>
<li>Click on the Info tab in your profile.</li>
<li>Scroll down to the Contact section.</li>
<li>Click on each section to edit.</li>
<li>Update your contact details.</li>
<li>Click on Save.</li>
</ul> 
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid57" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Adding a professional or institutional website to your profile     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid57">
<ul>
<li>Open your account.</li>
<li>Access your profile.</li>
<li>Click on the Info tab in your profile.</li>
<li>Scroll down to Contact section.</li>
<li>There will be a button asking whether you want to add your website.</li>
<li>Type in your website’s URl.</li>
<li>Click Save.</li>
</ul> 
</div>
    </div>
 <!-- question end -->
<!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid58" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I include Twitter, Skype, and IM accounts on my MyReposit profile?     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid58">
<ul>
<li>Open your account.</li>
<li>Access your profile.</li>
<li>Click on the Info tab in your profile.</li>
<li>Scroll down to Contact section.</li>
<li>Click on the section you want to update.</li>
<li>Add your contact details.</li>
<li>Click Save.</li>
</ul> 
</div>
    </div>
 <!-- question end -->
 <h4><b>Profile photos</b></h4>
<!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid59" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Adding your profile photo      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid59">
<ul>
<li>Open your account.</li>
<li>Access your profile.</li>
<li>Click on default profile image located on the left-hand side of the page.</li>
<li>Choose a photo.</li>
<li>Upload the photo to the site. Please note images should be 180x180 pixels. They should not be larger than 4MB and only *.jpg, *.jpeg, *.gif, or *.png formats are supported. Please use a professional photo to encourage recognition and to ensure visibility of your profile. .</li>
<li>Resize the photo to the required size.</li>
<li>Click Save.</li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid60" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How can I crop my profile photo?       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid60">
<ul>
<li>Open your account.</li>
<li>Access your profile.</li>
<li>Click on your uploaded photos.</li>
<li>Crop the photo or move the photo.</li>
<li>Click Save.</li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid61" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Deleting your profile photo        
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid61">
<ul>
<li>Open your account.</li>
<li> Access your profile.</li>
<li> Click on Delete photo.</li>
<li> Click Save.</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <h4><b>Managing your skills and expertise</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid62" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>What are skills?        
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid62">
<p>Listing your skills and expertise on the website will help researchers and authors to match you to the right papers for evaluation. We also use these same skills to match you to research papers. Make sure that you keep your skills updated and relevant as much as possible to guarantee good matches. </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid63" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Adding skills to your profile       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid63">
<ul>
<li>Open your account.</li>
<li>Access your profile.</li>
<li>Go to profile’s Info tab.</li>
<li>Click on Skills and Expertise.</li>
<li>Click on the drop down menu and choose Add Your Skills.</li>
<li>Type in your skill. You can add up to thirty skills.</li>
<li>Click Save.</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid64" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Removing skills from your profile        
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid64">
<ul>
<li>Open your account.</li>
<li>Access your profile.</li>
<li>Go to profile’s Info tab.</li>
<li>Click on Edits next to the Skills and Expertise tab.</li>
<li>Click on the ‘x’ next to the skill you want to remove.</li>
<li>Click Save.</li>
</ul>
</div>
    </div>
 <!-- question end -->
   <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid65" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Endorsing someone for a skill        
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid65">
<ul>
<li>Open your account</li>
<li>Access the profile of the researcher you want to endorse. Follow them. </li>
<li>Go to profile’s Info tab</li>
<li>Click on Skills and Expertise</li>
<li>Click on the ‘+’ sign to endorse the requisite skills.</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid66" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> Removing an endorsement you've given         
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid66">
<ul>
<li>Open your account</li>
<li>Access the profile of the researcher you want to endorse. Follow them. </li>
<li>Go to profile’s Info tab</li>
<li>Click on Skills and Expertise</li>
<li>Hover your mouse over the ‘+’ sign next to the requisite skills. The ‘+’ sign will turn to ‘-‘</li>
<li>Clicking will remove the endorsement</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid67" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> How can I skip endorsement suggestions?         
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid67">
<ul>
<li>Endorsement suggestions appear above your life feed.</li>
<li>Hover your cursor to the right of the Endorse button that appears there.</li>
<li>Click the word Skip that appears.</li>
<li>This message will not appear again.</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid68" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Removing endorsements from your profile         
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid68">
<ul>
<li>Open your account.</li>
<li>Access your profile.</li>
<li>Go to your Info tab.</li>
<li>Find the relevant skill.</li>
<li>Click on it or the number next to it.</li>
<li>Hover your cursor over the endorsement you want to remove.</li>
<li>Click on Remove Endorsement button.</li>

</ul>
</div>
    </div>
 <!-- question end -->
<?php endif ?>
 <?php if ($page_no == 4): ?>
     
 
 <h4><b>Your institution and department</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid69" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Adding your institution and department to your profile          
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid69">
<ul>
<li>Click on Profile’s Info tab.</li>
<li>Click on the Add Your Institution tab located under the account name.</li>
<li>Paste or type the name of your institution in the box. Sometimes the drop down menu will add suggestions. Click on the correct institution. .</li>
<li>Click Save.</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid70" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Changing your institution and department           
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid70">
<ul>
<li>Click on Profile’s Info tab</li>
<li>Click Edit on the institution tab located under the account name</li>
<li>Paste or type the name of your institution in the box. Sometimes the drop down menu will add suggestions. Click on the correct institution. </li>
<li>Click Save</li>
</ul>
</div>
    </div>
 <!-- question end -->
   <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid71" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Can I have multiple affiliations?           
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid71">
<ul>
<li>Click on Profile’s Info tab.</li>
<li>Go to the Add Your Research Experience tab and click on it.</li>
<li>Enter the details into the requisite space.</li>
<li>Click Save.</li>
</ul>
</div>
    </div>
 <!-- question end -->
   <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid72" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Updating my institution or department page         
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid72">
<p>Email support at support@MyReposit.net for the quickest reply. If you have an extra logo or design, make sure you upload or attach it to the email and we will do the needful.</p>
</div>
    </div>
 <!-- question end -->
 <h4><b>Duplicate profiles</b></h4>
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid73" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>I have two profiles - why did this happen and how can I fix it?          
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid73">
<p>Two profiles cannot be merged. You will have to delete the second profile. Here is what you have to do.</p>
<ul>
<li>Log in to your secondary profile.</li>
<li>Use the second email address you have used to log in.</li>
<li>Go to the Account Settings page.</li>
<li>Scroll down to the bottom.</li>
<li>Click on the red Delete My Account button.</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid74" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>I've discovered a profile in my name. What can I do?           
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid74">
<p>Author profiles are available on the site as they list your qualifications and expertise. If you come across a profile with your name, you can claim your profile by clicking the ‘Are you this author?’button on the top right-hand side of the page. This will merge the profile with your current account. If you don’t have a MyReposit account, you will have to open an account to merge your profile and your account. </p>
</div>
    </div>
 <!-- question end -->
 <h4><b>Your experience and education</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid75" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Adding or updating your experience, education, and achievements            
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid75">
<ul>
<li>Click on your account</li>
<li>Access the Profile’s info tab</li>
<li>Edit the necessary information</li>

</ul>
</div>
    </div>
 <!-- question end --> 
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid76" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Can I export my profile information as a CV?             
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid76">
<ul>
<li>Click on your account</li>
<li>Access the Profile’s Overview tab</li>
<li>Scroll down to the bottom of the page</li>
<li>Access the Export your Profile button and click on it. An automatic Word copy of your CV is downloaded to your computer. To get a complete copy, make sure your MyReposit profile is filled in as much detail as possible. </li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid77" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Importing your CV to your profile              
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid77">
<ul>
<li>Click on your account.</li>
<li>Access the Profile’s Info tab.</li>
<li>Manually input the required data into the requisite boxes in your profile page. You cannot import your CV at present to the site. Manual entry is the only option offered. .</li>
<li>You can upload other publications as well using the Reference Manager tool but they should be BibTeX, XML, EndNote, or RIS files.</li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <h4><b>Signing up for MyReposit</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid78" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>My email address isn’t recognized. Can I still sign up?              
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid78">
<p>Use your institutional email id to sign up with us. If you have another email id, you can always change it later on. If your institutional email is not recognized, complete the registration and we will manually approve the email. If you don’thave an email but you are a published author, we will manually verify the email. Just email us with your CV and your publication information. Even if you aren’t a researcher, you can still browse the MyReposit website and find content such as publications, jobs, and questions without being registered. </p>
</div>
    </div>
 <!-- question end -->  
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid79" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> I haven't received the account activation email               
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid79">
<p>Sometimes it takes a few minutes for the mail to reach your email box. Ni case you haven’t received the email, please make sure you check the SPAM or JUNK folders of your email box. If you still haven’t received the email, please do get in touch with us and request a new account activation email. There is a chance that the new account activation email will take some time to arrive. In case this happens, you are welcome to send an email to support@MyReposit.net. When you do this, we can verify your email address manually and activate your account immediately. </p>
</div>
    </div>
 <!-- question end -->  
<h4><b>Connecting with other researchers</b></h4>
<!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid80" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I follow another researcher?               
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid80">
<ul>
<li>Go to the researcher’s profile</li>
<li>Find the blue Follow button on the top right-hand side. </li>
<li>There may also be another white Follow button located next to their name anywhere their name is located on the website. You can click on this as well. </li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid81" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> How do I see who I’m following and who’s following me?               
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid81">
<ul>
<li>Click on your account</li>
<li>Access the Profile’s Overview tab. See who you are following and who’s following you by checking the right-hand side of your profile’s Overview tab. </li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid82" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I unfollow a researcher?                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid82">
<ul>
<li>Go to the researcher’sprofile.</li>
<li>Find the Info tab on their profile.</li>
<li>Click on the Unfollow Researcher tab located on the bottom left-hand side corner of the webpage.</li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid83" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Why am I automatically following researchers?               
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid83">
<p>In some sections, we’ve linked an automatic follow for fellow researchers. For example, if you were invited to join MyReposit by a fellow researcher, you are automatically linked to him. However, you can easily unfollow them. </p>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid84" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> Are there limits to the number of researchers I can follow?                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid84">
<p>You can follow up to 150 researchers. Once you reach this limit, you can only follow twice the number of researchers following you. To bypass this limit, you may have to unfollow some researchers. </p>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid85" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I block someone on MyReposit?                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid85">
<ul>
<li>Go to the researcher’s profile.</li>
<li>Find the Info tab on their profile.</li>
<li>Scroll down to the bottom of the page.</li>
<li>Click on the Block Researcher tab.</li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <h4><b>Contacting other researchers</b></h4>
<!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid86" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I Contact other researchers on MyReposit?                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid86">
<ul>
<li>Open an account.</li>
<li>Go to your inbox.</li>
<li>Click on the message icon located at the top right-hand corner of the MyReposit page.</li>
<li>Click on View All tag.</li>
<li>Click on New Message.</li>
<li>Put in the name of the researcher you want to message. For multiple messages, add their names with a comma in-between to separate their names. .</li>
<li>Enter your message.</li>
<li>Click on Send.</li>
</ul>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid87" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Another alternative                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid87">
<ul>
<li>Go to the profile of the researcher you are interested in.</li>
<li>Locate the Send Message button on the page.</li>
<li>Click on the button.</li>
<li>Frame your message and paste it into the box.</li>
<li>Click Send.</li>

</ul>
</div>
    </div>
 <!-- question end --> 
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid88" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Sending messages to researchers, you have not followed:                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid88">
<ul>
<li>Go to the profile of the researcher you are interested in.</li>
<li>Locate theirInfo tab.</li>
<li>Click on it.</li>
<li>Locate the Send Message button in the bottom right-hand corner.</li>
<li>Click the Send Message.</li>
</ul>
</div>
    </div>
 <!-- question end --> 
<?php endif ?>
<?php if ($page_no == 5): ?>
     

 <h4><b>Inviting colleagues to MyReposit</b></h4>
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid89" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I invite my colleagues to MyReposit?                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid89">
<ul>
<li>Access your website.</li>
<li>Click on the MyReposit Live Feed.</li>
<li>Browse through the related researchers listed on the website.</li>
<li>Click  on theInvite your colleagues button located below this list.</li>
<li>A box will appear. Enter your colleagues email ids into the box. You can add as many colleagues as you want.</li>
<li>An optional message is also possible.</li>
<li>Click on the Invite button .</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid90" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Can I invite contacts from my email address book?                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid90">
<ul>
<li>Access your website.</li>
<li>Click on the MyReposit account.</li>
<li>Navigate to the Related Researchers page.</li>
<li>Click on the Import Contacts button located at the top of the right-hand side of the page.</li>
<li>You will be taken to the Find Your Colleagues page.</li>
<li>Click on your email provider .</li>
<li>Follow the instructions.</li>
<li>Your contacts are automatically invited.</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid91" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> Inviting my co-authors to join MyReposit                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid91">
<p>Inviting your co-authors to join the MyReposit website is a great way to increase awareness among your peers. The first time you publish you can Invite my co-authors to MyReposit by clicking on the box. A preview option is offered as well and you can check the invites being sent to the respective researchers. You can also customize your Invitation Settings by clicking on the button labeled Invitation Settings. Disable invites by clicking on Turn Off All or turn them back on by clicking on Turn On All. </p>
</div>
    </div>
 <!-- question end -->
 <h4><b>About Publications </b></h4>
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid92" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> I have found a duplicate publication                 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid92">
<p>All duplicate publications are automatically merged. You can also do this manually by the following steps:</p>
<ul>
<li>Access your website.</li>
<li>Open your account.</li>
<li>Visit the MyReposit page that contains the duplicate content.</li>
<li>Locate the toolbar listed below the publication’s title and abstract.</li>
<li>Click on the Edit button located on the toolbar .</li>
<li>Make the changes.</li>
<li>Click Save.</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid93" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> Adding publications to my profile                  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid93">
<p>You can add all your publications to your profile. Here is what you have to do:</p>
<ul>
<li>Go to your MyReposit account.</li>
<li>Click on the Add Your Publications button.</li>
<li>You will be offered three options of Journal articles, Conference papers, and All other research.</li>
<li>Once you’ve listed your publications, they appear in chronological order on the dashboard. </li>

</ul>
</div>
    </div>
 <!-- question end -->
<!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid94" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> How do I remove publications from my profile?                   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid94">
<p>You can add all your publications to your profile. Here is what you have to do:</p>
<ul>
<li>Go to your MyReposit account.</li>
<li>Click on your Profile’s Contributions button.</li>
<li>Locate the publication you want to remove.</li>
<li>Click on the Remove button located next to the publication.</li>
<li>Click Remove again on the next pop-up box. You can also delete it from the database..</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid95" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> How do I delete my publication’s full-text?                   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid95">
<ul>
<li>Go to your MyReposit account</li>
<li>Go to the page of the publication</li>
<li>Float your cursor over the publication you are interested in</li>
<li>Double click the tiny red cross located on the right-hand corner of the image</li>
<li>Confirm the selection and your research paper will be deleted. </li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid96" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I edit my publication’s details?                   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid96">
<ul>
<li>Go to your MyReposit account.</li>
<li>Go to the page of the publication.</li>
<li>A toolbar will appear below the publication.</li>
<li>Click Edit on the toolbar.</li>
<li>Verify the change.</li>
<li>Save the change.</li>
<li>If you make a major change, like a change in the author name, we will verify the change manually.</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <h4><b>Adding publications</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid97" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Adding my research to my profile                   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid97">
<p>You can add all your publications to your profile. Here is what you have to do:</p>
<ul>
<li>Go to your MyReposit account.</li>
<li>Click on the Add Your Publications button.</li>
<li>You will be offered three options of Journal articles, Conference papers, and All other research.</li>
<li>Once you’ve listed your publications, they appear in chronological order on the dashboard under the My Profile tab.</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid98" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I add my journal articles to my profile?                   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid98">
<p>Your popular papers will be listed on the website and we use a name-matching algorithm to match the papers to your name. You can also add your publications to the profile with this method. </p>
<ul>
<li>Open your account on your website</li>
<li>Navigate to the top right-hand corner of the webpage</li>
<li>Click on the Add your publications button </li>
<li>Select the Journal articles that you are interested in and select Author match so that you can match the author profiles to your name.</li>
<li>A dialog box will pop up and you have to click on Yes confirming your authorship of the papers</li>
<li>Click Save </li>
</ul>
<p>Note: If you’re having trouble finding your published research you can also use the search tab.</p>
<ul>
<li> Manual entry is also possible by opening your account on your website.</li>
<li> Navigate to the top right-hand corner of the webpage.</li>
<li> Move to the Manual entry tab.</li>
<li> Type in the title of the journal article you have.</li>
<li> Add a full-text version of the article to the website and click on Continue.</li>
<li> Enter the requisite details of authors, journal name, and publication date.</li>
<li> Click Finish and you are done.</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid99" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I add my conference papers, presentations, or posters to my profile?                    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid99">

<p>You can add almost every kind of paper to our website provided it is credited to you. Here is what you can do:  </p>
<ul>
<li> Open your account on your website and access your dashboard.</li>
<li> At the top right-hand corner of the page, you will find an Add Your Publicationsbutton.</li>
<li> Another box will open. Select the option Conference Papers .</li>
<li> Click on the Upload File or Select File option and the file is added to the website.</li>
<li> Manually type in the title of the paper.</li>
<li> Click on Continue.</li>
<li> You will also have to manually enter the names of authors and the conference name and date.</li>
<li> Click Finish and you are done. </li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid100" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I add other types of research to my profile?                    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid100">

<p>You can also add unpublished articles, posters, incomplete papers, theses, datasets, negative results, technical papers, patents, figures, patented images, and media files to your profile </p>
<ul>
<li> Open your account on your website and access your dashboard.</li>
<li> Go to the top right-hand corner.</li>
<li> Click on the Add Your Publications button.</li>
<li> Another dialog box will open.</li>
<li> Click on the All Other Research button that appears in the next box.</li>
<li> Read through the options on type of research and click on the right option.</li>
<li> Click on Select File .</li>
<li> Find your file and upload your research .</li>
<li> Manually enter the name of the research paper and then click on Continue.</li>
<li> Enter more details if required or prompted.</li>
<li> Click Finish.</li>

</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid101" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I add my unpublished work to my profile?                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid101">

<p>You can also add unpublished articles, posters, incomplete papers, theses, datasets, negative results, technical papers, patents, figures, patented images, and media files to your profile</p>
<ul>
<li>Open your account on your website and access your dashboard.</li>
<li>Go to the top right-hand corner.</li>
<li>Click on the Add Your Publications button.</li>
<li>Another dialog box will open.</li>
<li>Click on the All Other Research button that appears in the next box.</li>
<li>Read through the options on type of research and click on the right option.</li>
<li>Click on Select File .</li>
<li>Find your file and upload your research.</li>
<li>Choose whether you would like to add a timestamp and generate a DOI for your work.</li>
<li>Click Add to profile..</li>
<li>Manually enter the name of the research paper and then click on Continue.</li>
<li>Enter more details if required or prompted.</li>
<li>Click Finish.</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid102" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I add supplementary resources to my publications?                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid102">

<p>You can also add unpublished articles, posters, incomplete papers, theses, datasets, negative results, technical papers, patents, figures, patented images, and media files to your profile</p>
<ul>
<li> Open your account on your website and access your dashboard.</li>
<li> Go to the top right-hand corner.</li>
<li> You will find a button that says Add Publications .</li>
<li> Another box will appear. Select the tab Other Research .</li>
<li> Another box will appear. In this box select the tab Dataset.</li>
<li> Upload a file and write a title for your research.</li>
<li> Click on the tab Continue.</li>
<li> If required, add more details. Then click on theSelect The Publication tab to add the publication name.</li>
<li> Click on Finish.</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid103" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Can I add several publications to my profile at once?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid103">

<p>Yes, our reference manager tool allow you to add as many publications as you want to your profile. You can upload BibTeX, EndNote, or RIS files and here is how you do it.</p>
<ul>
<li> Open your account on your website and access your dashboard.</li>
<li> Check in the top right-hand corner and you will find an Add Your Publications button. Click on it. </li>
<li> A drop-down box appears. Check on the Select Journal button in the options menu. </li>
<li> Another box will appear and you have to click on the Reference Manager tab.</li>
<li> Hover your cursor, select and upload, or drag and add the files to the system. </li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid104" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Can I add publications in languages other than English?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid104">

<p>Yes, you can add any language research papers to the dashboard and your profile. </p>
</div>
    </div>
 <!-- question end -->
   <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid105" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Inviting my co-authors to join MyReposit                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid105">

<p>Inviting your co-authors to join the MyReposit website is a great way to increase awareness among your peers. The first time you publish you can Invite my co-authors to MyReposit by clicking on the box. A preview option is offered as well and you can check the invites being sent to the respective researchers. You can also customize your Invitation Settings by clicking on the button labeled Invitation Settings. Disable invites by clicking on Turn Off All or turn them back on by clicking on Turn On All.  </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid106" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Where can I find my publications once I’ve added them to my profile?                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid106">
<ul>
<li> Open your account on your website and access your dashboard.</li>
<li> Click on your profile’s Contribution tab.</li>
<li> Check the filters on the right-hand side of the page.</li>
<li> Click on the Publications tab.</li>
<li> All your contributions are listed on the Contributions tab. You can filter or list these chronologically or alphabetically.</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid107" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I feature publications on my profile?                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid107">
<ul>
<li> Open your account on your website and access your dashboard.</li>
<li> Click on your profile.</li>
<li> Check the right-hand side of the page.</li>
<li> Find the Featured Publications tab.</li>
<li> Find the ‘+’ sign next to the  publication and you can Save the selection. You can feature up to five publications on your MyReposit profile. .</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid108" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>To remove a publication from your profile                    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid108">
<ul>
<li> Go to your MyReposit account.</li>
<li> Click on your Profile’s Contributions button.</li>
<li> Locate the publication you want to remove.</li>
<li> Click on the Remove button located next to the publication.</li>
<li> Click Remove again on the next pop-up box. You can also delete it from the database.</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid109" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Why is my publication already listed on MyReposit?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid109">
<p>MyReposit uses public resources to list journals. Your co-authors may also have listed papers under their names. In this case, send us a mail and we will get you joint credit on these publications. </p>
</div>
    </div>
 <!-- question end -->
 <h4><b>Full-texts and self-archiving</b></h4>
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid110" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I add a full-text to my publication?                       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid110">
<p>You can use your profile’s publication tab on your MyReposit page or the Contributions tab to add a full-text publication
<br>To add a full-text from your publication’s page:
<ul>
<li> Go to your MyReposit account.</li>
<li> Access your publication’s MyReposit page.</li>
<li> Check the top right-hand corner. You will find a Publish button. Click Publish Full-text  .</li>
<li> You will then have to find and upload the file to the website. Click on Select File and you are done. </li>
<li> You can also add an URL or DOI linking the article to the original source.</li>
<li> Click Upload.</li>
</ul>
<p>Another way to add full-text to the publication</p>
<ul>
<li> Go to your MyReposit account.</li>
<li> Locate your profile’sContributions tab.</li>
<li> Find the Publish Full-Text button. It will be located under the relevant publication and all you have to do is click on it. </li>
<li> A new box will open and you can click on the requisite file. Click on Select and the file is uploaded to the website.</li>
<li> You can also add an URL or DOI.</li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid111" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> I’m having trouble uploading files                       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid111">
<p>In that case, you have to change to the browser’s default uploader to ensure a smooth upload. All you have to do is click on Problems Uploading and Select The File. </p>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid112" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> How do I delete my publication’s full-text?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid112">
<ul>
<li>  Go to your MyReposit account.</li>
<li>  Go to the page of the publication.</li>
<li>  Float your cursor over the publication you are interested in.</li>
<li>  Double click the tiny red cross located on the right-hand corner of the image.</li>
<li>  Confirm the selection and your research paper will be deleted.</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid113" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I replace my publication’s full-text?                       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid113">
<p>To replace a new version, you have to delete the current version. </p>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid114" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Can I share a full-text with another researcher without making it publicly available?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid114">
<ul>
<li> Go to your MyReposit account</li>
<li> Access the Send Privately tab and send private texts to another researcher</li>
<li> You can also request or send texts through Send Message sections </li>

</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid115" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>What is self-archiving?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid115">
<p>When you self-archive, you are putting a complete document online to preserve it and ensure that anyone can access it. You can easily archive documents by publishing full text documents to the website. </p>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid116" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Am I breaching copyright by uploading my publication’s full-text?                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid116">
<p>Self-archiving permissions is usually discussed between authors and journals. We recommend you check with Sherpa/RoMEO for more details. Most of the time, if you have linked the article correctly to the journal on MyReposit, you do get permission to upload documents. </p><p>You can also check general publisher conditions for a specific document by checking the ‘Show Self-Archiving Restrictions’ link at the bottom of the MyReposit page. At the bottom of the page, you will also see a color coding system. According to the list, green allows you to upload a full-text, blue or yellow allows you verify individual article publishing conditions, and white indicates that you can self-archive the document. Nonetheless, we recommend you check publisher conditions before you decide to print. In case you cannot print the full-text publicly, you can always mail the document privately to the concerned person. </p>
</div>
    </div>
 <!-- question end -->
<?php endif ?>
<?php if ($page_no == 6): ?>
     

 <h4><b>Editing your Publication</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid117" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I edit my publication’s details?                   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid117">
                                <ul>
                                <li> Go to your MyReposit account</li>
<li> Go to the page of the publication</li>
<li> A toolbar will appear below the publication</li>
<li> Click Edit on the toolbar</li>
<li> Verify the change</li>
<li> Save the change</li>
<li> If you make a major change, like a change in the author name, we will verify the change manually.</li>

                                </ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid118" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I sort my publications?                    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid118">
                                <ul>
                               <li>  Submit the paper to our website</li>
<li> We will verify authorship</li>
<li> Your articles are listed under the Contributions tab on your profile. </li>
<li> To search for a specific journal, use thesub filterson our website to list articles according to Newest, Oldest, Recent, or Title using the options at the top of your list. </li>

                                </ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid119" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I remove publications from my profile?                    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid119">
                                <ul>
                               <li>  Go to your MyReposit account</li>
<li> Click on your Profile’s Contributions button</li>
<li> Locate the publication you want to remove</li>
<li> Click on the Remove button located next to the publication</li>
<li> Click Remove again on the next pop-up box. You can also delete it from the database.</li>

                                </ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid120" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>My publication is missing its impact factor                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid120">
                                <ul>
                               <li>  To gain maximum impact, you should attribute your paper to the journal it is published in. Make sure you verify this by click on your publication’s MyReposit page</li>
<li> Float your cursor on top of the journal name</li>
<li> A box will appear containing the journal and research details.</li>
<li> Verify these details. </li>
<li> If details do not appear, then you have to add details. Find the Edit button located on the toolbar underneath the publication’s title and abstract.</li>
<li> Type in the journal name into the field</li>
<li> Select the journal and click Save Changes</li>

                                </ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid121" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>I’ve found an outdated journal impact factor                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid121">
                                <p>We do our best to update journal impact factors but if the details are not correct, get in touch with us through the MyReposit Community Support section. Make sure you send your journal name and a website link so that we can verify and authenticate details. We update details regularly and by the time, you contact support, these details may already have been updated. </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid122" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>The journal I published in is missing                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid122">
                                <p>MyReposit’s is updated by its community and by theMyReposit team together. If a document is missing, make sure you contact MyReposit’s Community Support section with details like the journal’s webpage, ISSN, and impact factor.</p>
<p>After verification, we will update these details in our website. 
 </p>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid123" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i> I’ve found a duplicate publication                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid123">
                               <p> All duplicate publications are automatically merged. You can also do this manually by the following steps:</p>
<ul>
<li> Access your website</li>
<li> Open your account</li>
<li> Visit the MyReposit page that contains the duplicate content</li>
<li> Locate the toolbar listed below the publication’s title and abstract</li>
<li> Click on the Edit button located on the toolbar </li>
<li> Make the changes</li>
<li> Click Save</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <h4><b>Authorship</b></h4>
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid124" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>What is the difference between confirming authorship of a publication and adding it manually?                       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid124">
                               <p>When you confirm authorship, you are verifying that the document belongs to you. When you add the document manually, you are uploading a new document to the MyReposit website. </p>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid125" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>How do I confirm authorship of publications that I published under a different name?                       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid125">
<ul>
<li> Log into your website</li>
<li> Access your dashboard and go to your profile</li>
<li> Go to the top right-hand corner</li>
<li> Find the Add Your Publications button and click on it</li>
<li> A dialog box opens and you have to select the Journal Articles option offered on the box. </li>
<li> Ensure that the Author match tab is correct</li>
<li> Find and click on the Add Alternative Name</li>
<li> A dialog box opens and you can enter the alternative name </li>
<li> Click on the Save button</li>

</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid126" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>I’m having trouble confirming authorship of my publications                       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid126">
<p>Make sure your name matches the account name. If there is an error, then you will not be able to confirm authorship. To prevent this, you can add another name to your MyReposit account. Another alternative is to request authorship directly from the MyReposit page.</p>
<ul>
<li> Access your account and go to the publication’s page on the MyReposit website</li>
<li> On the top right-hand side, you will see a button saying Is This Your Publication? Once you find the button, click on it. </li>
<li> Send support information so that we can confirm that the publication or journal is yours</li>
<li> Click on the Request Authorship button.</li>
<li> We will verify the details and get in touch with you. </li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid127" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>Adding, editing, and removing co-author information                       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid127">
<ul>
<li> Access your account and go to the publication’s page on the MyReposit website</li>
<li> There is a toolbar below your publication’s title and abstract</li>
<li> Click the Edit button on the toolbar</li>
<li> Find the Edit Authors button and click on it</li>
<li> Add the author information in the new dialog box and click on the Request Changes button to get more details. Author changes are done manually and it takes a little time. </li>
</ul>

</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid128" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i></i>A researcher has wrongly claimed co-authorship of my publication                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid128">
<p>Contact help@myreposit.com right away and we will verify the issue.</p>
</div>
    </div>
 <!-- question end -->

 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid129" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>A researcher with a name similar to mine has claimed my publication                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid129">
<p>It may be a simple mistake. Verify the issue by carrying out the following steps.</p>
<ul>
<li> Access your account and go to the publication’s page on the MyReposit website</li>
<li> Find the Is this your publication? button located on the right-hand side of the page</li>
<li> Email the details that appear in the box to us</li>
<li> We will verify the details and get back to you. </li>

</ul>
</div>
    </div>
 <!-- question end -->
   <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid130" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>A publication in my profile doesn’t belong to me                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid130">
<p> Mistakes do happen. Verify the details by carrying out these steps</p>
<ul>
<li> Access your account and go to the publication’s page on the MyReposit website</li>
<li> Access the Contributions tab</li>
<li> Find the publication that is not yours</li>
<li> Click on the Remove button located next to the publication</li>
<li> Click on the Remove button again</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <h4><b>Discovering publications</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid131" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>How can I find relevant publications?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid131">
<ul>
<li>Access your account and go to the publication’s page on the MyReposit website.</li>
<li>Click on Publications tab.</li>
<li>You will be redirected to your Publications Feed where you can check all your publications and relevant publications as well.</li>
<li>You can also set up filters that deal with recently published, network, followed publications, publications following you, etc.</li>
<li>Click on the Your Network tab.</li>
<li>This will filter and list the publications again according to different criteria.</li>
<li>You can also see a list of your publications at your Contributions tab.</li>

</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid132" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>How do I search for publications on MyReposit?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid132">
<ul>
<li> Access your account and go to the publication’s page on the MyReposit website.</li>
<li> Add your publication’s title in the search bar at the top of the page.</li>
<li> Press Enter.</li>
<li> Results will appear. However, if results are not visible, choose the Publications filter on the right-hand side to further sort the results. .</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid133" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>How do I request a full-text of a publication?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid133">
<ul>
<li> Request it directly from the authors by accessing your website</li>
<li> Open the Publication page on the MyReposit website</li>
<li> Click on the Request Full Text button. You will be notified when the document is ready. </li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid134" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>How do I undo a full-text request?                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid134">
<p>You do have a few seconds after requesting a full text document to undo the request. The author will be notified by email. You can also email the authors to tell them that you do not need a full text document. </p>
</div>
    </div>
 <!-- question end -->
 <h4><b>Open Peer Review </b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid135" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>What is Open Peer Review?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid135">
<p>Instead of restricting your research paper to peer reviews done by journals, you can always submit your paper to an open peer review. We offer such a process as it will work in collaboration with the journal review process as well. With our review process, you can publish your document; it is reviewed, criticized and cited through the open peer review process. The process works in the following way: </p>
<ul>
<li> Author lists the paper with a website or at open archive websites like libraries, pre-print servers, etc. </li>
<li> Reviewers are invited to assess the work</li>
<li> The reviewers submit a detailed qualitative and quantitative assessment of the paper</li>
<li> Any conflicts of interest are mentioned</li>
<li> Reviews are published under a Creative Commons license.</li>
<li> The reviews are evaluated and commented on by everyone</li>
<p>This kind of open author-guided review process can be done anytime during the process. </p>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid136" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>Why is Open Peer Review important?                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid136">
<p>The current blind peer review model is not fast. In fact, it is slow and sometimes even prone to fraud. Some journals even monopolize the entire publication process to encourage academic competition.An open review system is advisable as it offers multiple benefits</p>
<ul>
<li> Reviewers provide neutral, bias-free reviews</li>
<li> Reduces publication times for journals</li>
<li> Ensures that journals can triage papers easily and publish them quickly </li>
<li> Opens up the publication process for authors from multiple locations all over the world</li>
<li> Allows an easy exchange of ideas and information</li>
<li> Encourages teamworkamong authors and reviewers</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid137" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>What kind of publications can I review?                    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid137">
<p>You can review any publication on MyReposit. </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid138" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>What kind of publications can I review?                    
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid138">
<ul>
<li> Open your account on the website</li>
<li> Go to the Publications page</li>
<li> Navigate to the Open Review page</li>
<li> On the right-hand side, you will find several links. Click on the Review This Publication button </li>
<li> The first question is reproducibility. Answer the first question and start your review</li>
<li> Go through at least a few of these factors like publication’s methodology, analyses, references, findings, or conclusions and answer them</li>
<li> You may have to add comments</li>
<li> Click Save </li>
<li> Move on to the next field</li>
<li>  Add supportive documents</li>
<li> Click on the Publish Review tab</li>
</ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid139" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>Where can I find my Open Reviews?                     
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid139">
<ul>
<li> Open your account on the website</li>
<li> Navigate to the profile’s Contributions tab</li>
<li> On the right-hand side, you will find an Open Reviews tab. Click on the Open Reviews filter </li>
<li> Your will see your reviews appearing on the publication’s MyReposit page. It will be present along with other reviews. </li>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid140" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>All the questions are grayed out/inactive. How can I review the publication?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid140">
<p>There are multiple questions asked before you can review the document. You have to answer these questions. Once you have answered these questions, the review will become active.</p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid141" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i> I’d like to review a publication where reproducibility is not a factor. Can I still review it?                      
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid141">
<p>Answer the questions correctly and you can review the document. </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid142" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i> Can I review a publication anonymously?                       
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid142">
<p>Reviewers are accountable for their reviews and we do not offer anonymous reviews at this stage. </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid143" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>How will I be notified when my publication is reviewed?                        
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid143">
<p>On-site notifications are sent to you via e-mail when your publication is reviewed. </p>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid144" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>Can I review my own publication?                         
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid144">
<p>No, you cannot review your own publication but you can comment on the reviews made by other authors. </p>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid145" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>Where are requests for reviews sent?                        
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid145">
<p>If you have expertise in a related field, you may receive requests for reviews. We are working on implementing an alternative matching system for our reviewers and authors.  </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid146" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>Is Open Review optional?                         
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid146">
<p>Yes, it is optional but it is a good way to meet authors and hear what they are thinking about your work. You should know that criticism is a normal part of research and you will get criticism on your work with an open review or without it. Within our supervised forum, you are more likely to catch errors faster and proofread work better. </p>
</div>
    </div>
 <!-- question end -->
 <h4><b>Generating Permanent Online Identifiers – DOIs</b></h4>
                    <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid147" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>What is a DOI?                        
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid147">
<p>A DOI makes your work unique, identifiable, and accurate. They don’t change and it ensures that your work is citable and dated. Use the search bar located at the top of every MyReposit page to find and identify DOIs for publication. </p>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid148" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>What type of research can I generate a DOI for?                   
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid148">
<p>DOIs are generated for almost all research. You can also connect existing DOIs to your pages. </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid149" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>How do I generate a DOI for my research?                  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid149">
                                <ul>
                                <li>Go to your profile </li>
<li>Find the Contributions tab and click on it</li>
<li>Select the publication you want a DOI for</li>
<li>Click on it and hover your mouse on top of the publication</li>
<li>Click on the Generate a DOI tab for this publication</li>
<li>Check the details</li>
<li>Click on the Generate a DOI tab. </li>
<p>The above process is only possible if you have already added the publication to MyReposit. If the publication is not the website you have to add the publication to the website and then get the DOI. Once you have uploaded the document, click on the Generate DOI tab and click on Finish </p>

                                </ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid150" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>What if my research already has a DOI?                  
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid150">
                                <p>You can add your existing DOI to the website by this method: </p>
                                <ul>
<li> Go to your profile </li>
<li> Open the dashboard</li>
<li> Find theContributions tab and click on it</li>
<li> Float your cursor on the publication. </li>
<li> On the right-hand side, you will find anAdd a URL or DOI tab</li>
<li> Put your DOI number in the field</li>
<li> Click Save</li>
   </ul>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid151" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>How do I find a publication using its DOI?                 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid151">
                                <p>Simply type the DOI number in the search engine bar at the top of the MyReposit page and relevant publications will appear in the search engine results. </p>
</div>
    </div>
 <!-- question end -->
 <h4><b>Open Archives Initiative</b></h4>
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid152" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>What is the Open Archives Initiative?                 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid152">
                                <p>The Open Archives Initiative (OAI) is a group that has listed standards and protocols for the operation, dissemination, and verification of content. A website that follows the OAI standard metadata protocols ensures that data is stored on an easily accessible forum for every reader. It also ensures that content reaches a larger audience. You have to verify whether your server uses OAI Protocol for Metadata Harvesting (OAI-PMH) functionality. If this OAI-PMH functionality is enabled, get in touch with us and we will decide whether it is right for MyReposit. </p>
</div>
    </div>
 <!-- question end -->
 <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid153" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>My online repository has scientific content, how can I add it to MyReposit?                 
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid153">
                                <p>Use theOpen Archives Initiative Protocol for Metadata Harvesting (OAI-PMH) to transfer content from your repository to us.If you already have OAI-PMH, copy paste the URL of your OAI-PMH API and email it to us. Please ensure that these details are listed in the email as well:</p>
<ul>
<li> Does your document contain full-texts or is it comprised of metadata?</li>
<li> What traits are present in the content XML metadata of your repository?</li>
<li> Do you have the URL of your digital repository and its OAI-PMH API?</li>
<li> Do you have a clear list of the content in your repository and how it will relate to MyReposit?</li>
<p>Get in touch with us via a detailed email with the requested information. 
For more information on OAI-PMH functionality, use this link here:<link href="https://www.openarchives.org/pmh/tools/tools.php">. If you are not sure about server compatibility and OAI-compatible details use this link here: <link href="http://www.openarchives.org/pmh/">
</p>
</ul>
</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid154" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>How do I make my repository compatible with the Open Archives Initiative Protocol?                
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid154">
                                <p>Use the OAI website located at <link href="https://www.openarchives.org/pmh/tools/tools.php"> and <link href="http://www.openarchives.org/pmh/"> to learn more</p>

</div>
    </div>
 <!-- question end -->
  <!-- Question Start -->
                        <div class="col-cont">
                                <div class="col-head">
                                    <h5 class="col-title"><a  data-toggle="collapse" href="#collapsefaqid155" aria-expanded="false" aria-controls="collapse<?=$key->faqid?>">
                                        <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i>My repository already has an OAI API, how can I add the content to MyReposit?               
                                    </a></h5>
                                </div>
                                <div class="col-body collapse" id="collapsefaqid155">
                                <p>If you already have OAI-PMH, copy paste the URL of your OAI-PMH API and email it to us. Please ensure that these details are listed in the email as well:</p>
<ul>
<li> Does your document contain full-texts or is it comprised of metadata?</li>
<li> What traits are present in the content XML metadata of your repository?</li>
<li> Do you have the URL of your digital repository and its OAI-PMH API?</li>
<li> Do you have a clear list of the content in your repository and how it will relate to MyReposit?</li>
<p>Get in touch with us via a detailed email with the requested information and we will do the rest. </p>
</ul>
</div>
    </div>
 <!-- question end -->

    
<?php endif ?>
<ul class="pagination">
   <?php foreach (range(1, 6) as $key): ?>
       <li><a <?=($page_no == $key)?'href="#" class="active"':'href="?page='.$key.'"'?>><?=$key?></a></li>
   <?php endforeach ?>
</ul>

                    </div>
                    
                </div>
            </section>
           