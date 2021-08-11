<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo $title; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <?php echo $html_head; ?>
    <?php echo $foot_script; ?>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
</head>
<body>
    <div class="wrapper">
        <?php echo $sidebar; ?>
        <div class="main-panel">
            <?php echo $header; ?>
            <?php echo $content; ?>
            <?php echo $footer; ?>
        </div>
    </div>
</body>

</html>
