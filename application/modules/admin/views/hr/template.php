<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo $title; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link href="<?php echo base_url(); ?>assets/backend/hr/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/backend/hr/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/backend/css/jquery-ui.css" rel="stylesheet" type="text/css">

    <?php echo $css_files; ?>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php echo $sidebar; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php echo $header; ?>
                <?php echo $content; ?>
            </div>
            <?php echo $footer; ?>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url(); ?>assets/backend/hr/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/hr/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/backend/hr/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url(); ?>assets/backend/hr/js/sb-admin-2.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.0/socket.io.min.js'></script>
    <?php echo $js_files; ?>

    <?php $userdata = $this->session->userdata('hr_admin');
        if(!empty($userdata)) { ?>
            <script>
                var notificationsWrapper   = $('.admin-notifications');
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
                        if (data.is_sent_admin == 1) {
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
                                                    <i class="fas `+iconClass+` text-white"></i>
                                                </div>
                                            </div>
                                            <div>
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

                $('#adminNotificationDropdown').click(function(e) {
                    if(notificationClickFlag == 0 || newNotificationFlag == 1) {
                        if( notificationsCount > 0 ) {                            
                            $.ajax({
                                type: "POST",
                                url: base_url+"hr/admin/mark-as-read",  
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
                                <div>
                                    <span class="font-weight-bold">No new notification found</span>
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
