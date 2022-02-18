<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <meta content="We specialize in Residential, Commercial Title & Escrow Services" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="telephone=no" name="format-detection">
    <meta name="HandheldFriendly" content="true">
    <meta charset="utf-8" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/frontend/images/favicon.ico" type="image/x-icon">
    <style>
        th {
            text-align: center;
        }
    </style>
    <?php echo $css_files; ?>
    <?php echo $js_files; ?>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
</head>
<body>
    <div id="page-preloader">
        <span class="spinner border-t_second_b border-t_prim_a"></span>
    </div>
    <div class="l-theme animated-css" style="height:auto;" data-header="sticky" data-header-top="200" data-canvas="container">
        <?php echo $header; ?>
    </div>
    <?php echo $content; ?>
    <?php echo $footer; ?>      
    <script src='https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.4/socket.io.min.js'></script>
    <?php $userdata = $this->session->userdata('hr_user');
        if (!empty($userdata)) { ?>
            <script>
                var notificationsWrapper   = $('.user-notifications');
                var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
                var notificationsCountElem = notificationsToggle.find('span[data-count]');
                var notificationsCount     = parseInt(notificationsCountElem.data('count'));
                var notifications          = notificationsWrapper.find('div.notification-item-list');
                var notificationClickFlag  = 0;
                var newNotificationFlag    = 0;

                var socket = io.connect('//'+'<?php echo $_SERVER['SERVER_ADDR'];?>'+':1337', {
                    transports: ['websocket', 'xhr-polling']
                });
                var user_id = <?php echo $userdata['id'];?>;

                socket.on('connect', function () {
                    console.log('connected');
                    socket.on('broadcast', function (data) {
                        if(data.sent_to_user == user_id) {
                            var notification = data;
                            var alertClass = '';
                            var iconClass = '';
                            if (notification.type == 'approved') {
                                alertClass = 'bg-success';
                                iconClass = 'fa-check';
                            } else if (notification.type == 'denied') {
                                alertClass = 'bg-danger';
                                iconClass = 'fa-ban';
                            } else if (notification.type == 'accepted' || notification.type == 'assigned' || notification.type == 'submitted') {
                                alertClass = 'bg-warning';
                                iconClass = 'fa-exclamation-triangle';
                            }
                            
                            var existingNotifications = notifications.html();
                            
                            var newNotificationHtml = `<a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle `+alertClass+`">
                                                    <i class="fa `+iconClass+` text-white"></i>
                                                </div>
                                            </div>
                                            <div style="width: max-content;color:#333 !important;">
                                                <div class="small text-gray-500">`+notification.date+`</div>
                                                `+notification.message+`
                                            </div>
                                        </a>`; 
        
                            if (notificationsCount > 0 ){
                                notifications.html(newNotificationHtml + existingNotifications);
                            } else {
                                notifications.html(newNotificationHtml);
                            }     
                            notificationsCount += 1;
                            notificationsCountElem.attr('data-count', notificationsCount);
                            notificationsWrapper.find('.badge-counter').removeClass('d-none').text(notificationsCount);
                            notificationsWrapper.show();
                            newNotificationFlag = 1;
                        }
                    });
                    socket.on('disconnect', function () {
                        console.log('disconnected');
                    });
                });

                $('#notificationDropdown').click(function(e) {
                    if(notificationClickFlag == 0 || newNotificationFlag == 1) {
                        if( notificationsCount > 0 ) {                            
                            $.ajax({
                                type: "POST",
                                url: base_url+"hr/mark-as-read",  
                                async: false,                                          
                                success: function(response){     
                                    notificationClickFlag = 1; 
                                    notificationsCountElem.attr('data-count', 0);
                                    notificationsCount = 0;
                                    notificationsWrapper.find('.badge-counter').addClass('d-none').text(0);
                                    newNotificationFlag = 0;
                                },
                                error: function(response){	
                                    notificationClickFlag = 0;  
                                }                                        
                            });
                        }
                    } else {
                        var newNotificationHtml = `
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div style="width: 44rem!important;">
                                        <span style="color:#333 !important;" class="font-weight-bold">No new notifications found</span>
                                    </div>
                                </a>`;
                        notifications.html(newNotificationHtml); 
                        notificationsCountElem.attr('data-count', 0);
                        notificationsCount = 0;
                        notificationsWrapper.find('.badge-counter').addClass('d-none').text(0); 
                    }  
                }); 
            </script>
        <?php }
    ?>
</body>

</html>
