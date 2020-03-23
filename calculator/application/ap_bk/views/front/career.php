<div class="container">
  <div class="content-wrapper">
    <section id="content">
      <?php include "ext-menu.php";?>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="active">Work with Us</li>
      </ol>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="panel panel-default flat" id="main-height">
            <div class="panel-body">
              
              <h3 class="text-uppercase panel-title ">Employment Opportunities at MyReposit</h3><hr>


<p>Thank you for choosing MyReposit as a prospective employer. We believe that you will find working in our collaborative environment a dynamic and rewarding experience. We aims to attract and retain talented and motivated teammates who are passionate about our mission and help us achieve our aspirations. Our unique culture is one of entrepreneurial spirit and open dialogue where our colleagues are motivated to set and achieve high standards of excellence. We are proud of our dynamic group of talented, collegial, and intelligent colleagues.<br><br>
</p>
<h4><b>Join Us!</b></h4><p>
Below, you can find our current job openings.<br> You can apply for positions online or alternatively <a class=" btn-link" href="<?=base_url()?>submit-resume" role="button">SUBMIT YOUR RESUME</a> for consideration. <br>You can also refer a colleague might be interested and suitable for the openings available. Please <a class=" btn-link" href="<?=base_url()?>job-reference" role="button">REFER</a> him/her to us in confidence. </p>

              <hr>
              <?php if ($jobs): ?>
                 <ul class="listing jobsheet">
                <?php foreach ($jobs as $key): ?>
                <li><h4><a href="<?=base_url()?>view-job/<?=$key->job_id?>/<?=urlencode($key->job_title)?>"><?=$key->job_title?></a></h4>
                <strong>Location: </strong><?=$key->location?>
              <strong>Department: </strong><?=$key->department?></li>
              <?php endforeach ?>
              
              
            </ul>
              <?php else: ?>
                <div class="alert alert-danger">
                  <strong>No job posting available.</strong> 
                </div>
              <?php endif ?>
             
            
          </div>
        </div>
        </div>
       
      </div>
      
    </section>