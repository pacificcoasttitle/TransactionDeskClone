<div class="container">
    <div class="content-wrapper">
        <section id="content">
            <?php include 'ext-menu.php';?>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active">About </li>
            </ol>
            <div class="clearfix">
            </div>
            <div class="panel panel-default flat article-container-inner seperate">
                <div class="panel-body article-post">
                    <h3 class="panel-title">MyReposit.com – fully hosted Repository with Support Services</h3>
                    <hr>
                     <?=$page_content->content;?>
            </div>
        </section>
