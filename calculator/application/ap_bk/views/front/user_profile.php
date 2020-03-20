
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include "ext-menu.php"; ?>
                
              <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li><a href="<?=base_url()?>all-profiles">All Profiles</a></li>
                <li class="active"><?=ucfirst($user_info->salutation." ".ucfirst($user_info->fname)." ".ucfirst($user_info->lname));?></li>
              </ol>
              <div class="clearfix"></div>
              <div class="panel panel-default flat">
                <div class="panel-body" style="max-height: 930px; overflow-y: scroll;">
                  <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-2">
                      <img src="<?=base_url()?>upload/user/<?=$user_info->userid?>/<?=$user_info->profilepic?>" class="img-responsive" onerror=" this.src = '<?=base_url()?>assets/front/images/doctor.png'" style="margin-left: -7px; width: 100px; height: 108px;">
                    </div>
                    <div class="col-xs-12 col-sm-9 pull-down" style="margin-left:-15px;">
                   
                      <h5 style="margin:0px;"><a href="javascript:;"  class="disabled"><b class="text-uppercase"><?=ucfirst($user_info->salutation." ".ucfirst($user_info->fname)." ".ucfirst($user_info->lname));?></b></a></h5>
                      <p><?=$user_info->designation?><br>
                     <?=$user_info->current_position?></p>
                     <div class="clearfix hr">
                     
                     </div>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                       <a href="<?=base_url()?>index.php/welcome/follow_user/<?=$user_info->userid?>/<?=$user_info->slug?>" type="button" class="btn btn-primary btn-xs pull-right">follow <?=ucfirst(ucfirst($user_info->fname)." ".ucfirst($user_info->lname));?></a>
                    
                    </div>
                    </div>
                    
                    <div class="col-sm-12">
                    <div class="panel-group pscript no-margin" id="accordion" role="tablist" aria-multiselectable="true" >
                     <p class="no-margin mar-top-10"><b>Research Interest:</b> <?=$user_info->research_interest?></p>
                  <div class="panel panel-default">
                     <?php if ($user_info->cv !=''): ?>
                    <div class="panel-heading padding-5" role="tab" id="headingOne">
                      <h4 class="panel-title col-title2">
                      <a role="button" target="_blank" href="<?=base_url()?>upload/user/<?=$user_info->userid?>/<?=$user_info->cv?>" aria-expanded="true" aria-controls="collapseOne">
                      Curriculum Vitae, Awards and Honours  
                      </a>
                      </h4>
                    </div>
                  <?php else: ?>
                    <div class="panel-heading padding-5" role="tab" id="headingOne">
                      <h4 class="panel-title col-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <i class=" icon-plus"></i> <i style="display:none;" class="icon-minus"></i> Curriculum Vitae, Awards and Honours  
                      </a>
                      </h4>
                    </div>

                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                       <?=($user_info->profile_desc)?>
                             </div>
                    </div>
                  <?php endif ?>
                  
                  </div>
                  </div>
                   
                  </div>
                  
                  <div class="clearfix">
                    &nbsp;
                  </div>
                  <div class="col-sm-12 table-responsive">
                    <table class="table table-striped table-mix ">
                      <thead>
                        <td class="col-sm-1">Date</td>
                        <td class="col-sm-7">Title</td>
                        <td class="col-sm-2">Category</td>
                        <td class="col-sm-2">Status</td>
                      </thead>
                      <tbody>
                     <?php foreach ($userarticles as $key): ?>
                        <tr>
                          <td>
                            <?=date("F Y",strtotime($key->rdate))?>
                          </td>
                          <td>
                            <a  href="<?=base_url()?>get-article-info/<?=$key->articleid?>"> <b><?=$key->title?></b></a>
                           <!--  <p>Keyword : <?=$key->keyword?></p> -->
                          </td>
                          <td>
                            <?=$key->category?>
                          </td>
                          <td>
                            <?=$key->worktype?>
                          </td>
                        </tr>
                      <?php endforeach ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </section>
          