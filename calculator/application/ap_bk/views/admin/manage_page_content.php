
 <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <h1>
              Manage
              <small>Manage Page Contents</small>
          </h1>
          <ol class="breadcrumb">
              <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="<?=base_url()?>index.php/admin/manage_contents">Manage Page Contents</a></li>
          </ol>
      </section>

      <!-- Main content -->
      <section class="content">

          <!-- Small boxes (Stat box) -->
          <div class="row">
             <div class="panel panel-default">
                 <div class="panel-heading">
                   <ul class="nav nav-tabs">
                     <li class="active"><a href="#content" data-toggle="tab" >Content</a></li>
                    <!--  <li><a href="#content" data-toggle="tab" >Upload Document</a></li> -->
                   </ul>
                 </div>
                 <div class="panel-body">
                 <form action="<?=base_url()?>index.php/admin/update_page_content" method="POST" role="form" enctype="multipart/form-data">
                   <div class="tab-content">
                     <div id="content" class="tab-pane fade in active">
                       
                         
                         <div class="form-group">
                           <label for="">Content</label>
                           <textarea  class="form-control ckeditor" name="content">
                             
                             <?=$page_content->content?>
                           </textarea>
                         </div>
                       
                         
                      
                       <input type="hidden" name="id" id="inputId" class="form-control" value="<?=$page_content->id?>">
                       <input type="hidden" name="keyword" id="inputkeyword" class="form-control" value="<?=$page_content->keyword?>">
                         
                     </div>
                    
                      
                     
                   </div>
                   <button type="submit" class="btn btn-primary">Submit</button>
                       </form>
                 </div>
             </div>
            
           
              
          </div>
        </section>
  </aside>
                
         
                    
             
             
          
