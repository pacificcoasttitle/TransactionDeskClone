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
</body>

</html>
