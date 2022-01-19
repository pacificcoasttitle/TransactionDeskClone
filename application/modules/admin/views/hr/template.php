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
    <?php echo $js_files; ?>
</body>

</html>
