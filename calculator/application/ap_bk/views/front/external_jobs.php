<div class="container">
  <div class="content-wrapper">
    <section id="content">
      <?php include "ext-menu.php";?>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="active">External Jobs Application</li>
      </ol>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="panel panel-default flat" id="main-height">
            <div class="panel-body">
              
              <h3 class="text-uppercase panel-title ">Job Search for External Applicants</h3><hr>


<p>All job openings are listed below.  You may apply to any job openings listed below. You can narrow your job search by entering keywords that match your job requirement. 
</p>

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Basic Job search</h3>
        </div>
        <div class="panel-body">
          <form action="" method="get" role="form">
           
            <div class="form-group">
              <label for="" class="sr-only">Job Function</label>
              <select name="job_function" id="inputJob_function" class="form-control" required="required" onchange="form_click();" >
                        <option value="" class="s">Job Function</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Manager/Director Technical Affairs')?'selected="true"':NULL?>>Manager/Director Technical Affairs</option>
                        <option <?=(urldecode($_GET['job_function']) == 'R&D Project Managers/Directors')?'selected="true"':NULL?>>R&D Project Managers/Directors</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Product Development')?'selected="true"':NULL?>>Product Development</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Research Scientists & Chemists')?'selected="true"':NULL?>>Research Scientists & Chemists</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Microbiologists')?'selected="true"':NULL?>>Microbiologists</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Analytical Development Managers/Directors')?'selected="true"':NULL?>>Analytical Development Managers/Directors</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Formulations Development')?'selected="true"':NULL?>>Formulations Development</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Process Development')?'selected="true"':NULL?>>Process Development</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Account Managers')?'selected="true"':NULL?>>Account Managers</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Business Development Managers')?'selected="true"':NULL?>>Business Development Managers</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Territory Sales Manager/Directors')?'selected="true"':NULL?>>Territory Sales Manager/Directors</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Managers')?'selected="true"':NULL?>>Managers</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Quality Assurance Manager/Directors')?'selected="true"':NULL?>>Quality Assurance Manager/Directors</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Regulatory Affairs Manager/Directors')?'selected="true"':NULL?>>Regulatory Affairs Manager/Directors</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Sr. Quality Engineers')?'selected="true"':NULL?>>Sr. Quality Engineers</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Validation Engineers & Managers')?'selected="true"':NULL?>>Validation Engineers & Managers</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Supplier Quality Managers & Engineers')?'selected="true"':NULL?>>Supplier Quality Managers & Engineers</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Design Control & Risk Management')?'selected="true"':NULL?>>Design Control & Risk Management</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Design manager')?'selected="true"':NULL?>>Design manager</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Print coordinator')?'selected="true"':NULL?>>Print coordinator</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Production supervisor')?'selected="true"':NULL?>>Production supervisor</option>
                        <option <?=(urldecode($_GET['job_function']) == 'Web manager')?'selected="true"':NULL?>>Web manager</option>

                      </select>
            </div>
             <div class="form-group">
              <label for=""  class="sr-only">Keywords</label>
             <select name="experience" id="inputJob_function" class="form-control" required="required" onchange="form_click();">
                <option value="" class="s">Experience</option>
               <option <?=(urldecode($_GET['experience']) == 'Executive')?'selected="true"':NULL?>>Executive</option>
               <option <?=(urldecode($_GET['experience']) == 'Director')?'selected="true"':NULL?>>Director</option>
               <option <?=(urldecode($_GET['experience']) == 'Mid-senior')?'selected="true"':NULL?>>Mid-senior</option>
               <option <?=(urldecode($_GET['experience']) == 'Associate')?'selected="true"':NULL?>>Associate</option>
               <option <?=(urldecode($_GET['experience']) == 'Entry level')?'selected="true"':NULL?>>Entry level</option>
               <option <?=(urldecode($_GET['experience']) == 'Internship')?'selected="true"':NULL?>>Internship</option>

              </select>
            </div>
          <button type="submit" style="display:none;" id="job_search_sub" class="btn btn-primary">Submit</button>
            
          
            </form>
        </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default panel-collapse">
        <div class="panel-heading">
          <h3 class="panel-title">Post A Job</h3>
        </div>
        <div class="panel-body collapsed">
          <ul>
            <li>Fill in the job details and candidate profile required</li>
            <li>Register your contact details to receive applications</li>
            <li>That’s it. You are all set to go!</li>
          </ul>
          <a type="button" href="<?=base_url()?>post-external-job" class="btn btn-primary btn-sm">Post A Job</a>
        </div>
    </div>


  </div>
</div>

              <hr>
                <?php if ($external_jobs): ?>
                  <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Latest Job Posting</h3>
                      </div>
                      <div class="panel-body">
                       <table class="table table-bordered table-hover">
                         <thead>
                           <tr>
                             <th>Date</th>
                             <th>Job Title</th>
                             <th>Job Location</th>
                             <th>Job Type</th>
                           </tr>
                         </thead>
                         <tbody>

                          <?php foreach ($external_jobs as $key): ?>
                           <tr>
                             <td><?=date("j F Y",strtotime($key->job_posted))?></td>
                             <td><a href="<?=base_url()?>view-external-job/<?=$key->id?>/<?=urlencode($key->job_title)?>"><?=$key->job_title?></a></td>
                             <td><?=$key->location?></td>
                             <td><?=$key->job_type?></td>
                            </tr>
                     
                        <?php endforeach ?>
                              </tbody>
                       </table>
                      </div>
                  </div>
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

    <script type="text/javascript">
function form_click (argument) 
{
    $("#job_search_sub").click();
}
    </script>