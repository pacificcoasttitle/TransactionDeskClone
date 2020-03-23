
        <!--/header-->
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include 'ext-menu.php';?>
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li><a href="<?php echo base_url(); ?>manuscript-development">Manuscript Development</a></li>
                <li class="active">Figure Preperation</li>
              </ol>
              <div class="clearfix"></div>
             <div class="panel panel-default flat">
              <div class="panel-body">
                <h3 class="panel-title"><b>Publication Ready Manuscript Editing Services</b></h3>
                <hr>
                <div class="row">
                  <div class="col-xs-12 col-sm-2 text-center">
                    <a href="<?php echo base_url(); ?>editing">
                      <img src="<?=base_url()?>assets/front/images/edit3.png">
                    </a>
                  </div>
                  <div class="col-xs-12 col-sm-10">
                    <H3 class="no-margin margin-bottom-10">Figure Preperation</H3>
                    <p>Your figures and tables will be prepared to the exact specifications of the journal you select. We guarantee that
                      the figures and tables formatted will meet the specifications of the journal you select and that if the journal
                      suggest errors or changes, such will be undertaken free of cost. We are committed to helping researchers
                      increase their chances of publication by submitting manuscripts that are free of language errors.
                    </p>
                    <p>&nbsp;</p>
                  </div>
                </div>

 <?php if (isset($_GET['type'])): ?>
                   <?php if ($_GET['type']=='std' || $_GET['type']=='pro' || $_GET['type']=='pro_plus'): 
                        $type=$_GET['type'];

                       else: 
                         $type='std';
                    endif; ?>
                <?php else: 
                   $type='std';
                 endif ?>
               
                <div class="row  table-function" id="third1">
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-info">
                      <div class="panel-heading text-center">
                        <h3 style="background:none;"> Standard </h3>
                      </div>
                      <div class="panel-body">
                        <ul>
                          <li>Creation of scientific and academic figures by highly skilled Illustrator </li>
                          <li>One round of modifications  (figure size, text, layout, resolution, and file type based on target journal’s specifications)</li>
                          <li>Quality guarantee. 100% on-time delivery</li>
                        </ul>
                      </div>
                     
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-pup">
                      <div class="panel-heading text-center">
                        <h3 style="background:none;"> Pro </h3>
                      </div>
                      <div class="panel-body">
                        <ul>
                          <li> Creation of scientific and academic figures by highly skilled Illustrator </li>
                          <li> Three rounds of modifications  (figure size, text, layout, resolution, and file type based on target journal’s specifications)</li>
                          <li> layout and colors adjustment to improve figure legibility and appearance </li>
                          <li> Quality guarantee. 100% on-time delivery </li>
                        </ul>
                      </div>
                     
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-danger">
                      <div class="panel-heading text-center">
                        <h3 style="background:none;"> Pro+ </h3>
                      </div>
                      <div class="panel-body">
                        <ul>
                          <li>Unlimited modifications (figure size, text, layout, resolution, and file type based on target journal’s specifications)</li>
                          <li>Typographic, spelling and phrase correction.</li>
                          <li>layout and colors adjustment to improve figure legibility and appearance </li>
                          <li>Quality guarantee. 100% on-time delivery</li>
                          
                        </ul>
                      </div>
                     
                    </div>
                  </div>
                </div>



                <div class="clearfix">
                
               
                <h4 ><b> Figure Preparation Services (Figure formatting, Illustration & Graphing) include</b>
</h4>
<ul>
  <li> Enhancing professional look by making changes to layout, fonts, color, file type, scale, resolution, and line weights</li>
<li> Develop original illustrations based on sketches, re-scale diagrams to print-ready high-resolution output, redraw
flowcharts and figures, creating graphs from data tables</li>

</ul>
<p>&nbsp;</p>
 </div>
 <div class="row">
   <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
     <img src="<?=base_url()?>assets/front/images/image-trans.jpg" class="img-responsive"><br>

   <!--  <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="well well-sm text-center"><h4 class="panel-title">Before</h4></div>
      </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="well well-sm text-center"><h4 class="panel-title">After</h4></div>
      </div>
    </div> -->
   </div>
   <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
   <h4 class="no-margin margin-bottom-10"><b> Fill your requirements </b></h4> 
    <form action="<?=base_url()?>index.php/welcome/manuscript_figure_order" method="POST" role="form" enctype="multipart/form-data">
    
    
      <div class="form-group">
        <label for="" class="sr-only">Number of figures and tables</label>
        <select name="figure_count" id="input" class="form-control" required="required">
          <option value="" class="s">Number of figures and tables </option>
          <?php foreach (range(1,20) as $key): ?>
            <option><?=$key?></option>
          <?php endforeach ?>
        </select>
      </div>
<div class="form-group">
        <label for="" class="sr-only">Number of illustrations</label>
        <select name="ilu_count" id="input" class="form-control" required="required">
          <option value="" class="s">Number of illustrations </option>
          <?php foreach (range(1,20) as $key): ?>
            <option><?=$key?></option>
          <?php endforeach ?>
        </select>
      </div>

        <div class="form-group">
        <label for="" class="sr-only">Specialities</label>
        <select name="speciality" id="input" class="form-control" required="required">
          <option value=""class="s">Specialities</option>
             <?php foreach ($departments as $key): ?>
              <option><?=$key->departmentname?></option>
              <?php endforeach ?>
        </select>
      </div>
        <div class="form-group">
        <label for="" class="sr-only">Select Plan</label>
        <select name="plan" id="input" class="form-control" required="required">
          <option value=""class="s">Select Plan</option>
             <?php $plan = array('Standard','Pro','Pro+'); foreach ($plan as $key): ?>
              <option><?=$key?></option>
              <?php endforeach ?>
        </select>
      </div>
        <div class="form-group">
        <label for="" class="sr-only">Link to Journal</label>
                                <input type="text" name="journal_link" placeholder="Link to Journal" id="input" class="form-control" value="" required="required"  title="">
       
      </div>
        <div class="form-group">
        <label for="">Upload Figures</label>
        <input type="file" name="userfile1[]" multiple>
      </div>
    
      
    
      <button type="submit" class="btn btn-warning btn-block">Request Quote </button>
<!--       <small>Request a <a  data-toggle="modal" href='#'> custom quote</a> for Illustration & Graphing services </small>
 -->    </form>
   </div>
 </div>
                
                
   
                           
                
                
                
              </div>
            </div>
            <div class="panel panel-default panel-gray">
              <div class="panel-heading">
                <h4 class="panel-title">Disclaimer</h4>
              </div>
              <div class="panel-body">
                Although we are confident that our Manuscript Editing Services will enhance the quality of your manuscript and increase your chances of publication, we cannot that
                your work will be published. However, we stand behind the quality of our work and will continue to work with authors subscribing to these services until the product is
                developed to their satisfaction. In situations were your journal alerts of problems with respect to editing, formatting, figure preparation or translation (including errors
                with journal-specific conventions) we will rework on your paper for free.
              </div>
            </div>
            <p>If you have any suggestions or feedback about our service, please <a  href="<?=base_url()?>contact"> contact us.</a>
          </p>
        </section>