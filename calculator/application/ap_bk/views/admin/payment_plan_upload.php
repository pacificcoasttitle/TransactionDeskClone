
 <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
      <!-- Manage Payment Plan Header (Page header) -->
      <section class="content-header">
          <h1>
              Manage
              <small>Manage Payment Plan</small>
          </h1>
          <ol class="breadcrumb">
              <li><a href="<?=base_url()?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="<?=base_url()?>index.php/admin/manage_contents">Manage Payment Plan</a></li>
          </ol>
      </section>

      <!-- Main content -->
      <section class="content">

          <!-- Small boxes (Stat box) -->
          <div class="row">
             <div class="panel panel-default">
                 <div class="panel-heading">
                   <ul class="nav nav-tabs">
                     <li class="active"><a href="#content" data-toggle="tab" > Payment Plan</a></li>
                    <!--  <li><a href="#content" data-toggle="tab" >Upload Document</a></li> -->
                   </ul>
                 </div>
                 <div class="panel-body">
                 <form action="" method="POST" role="form" enctype="multipart/form-data">
                   <div class="tab-content">
                     <div id="content" class="tab-pane fade in active">
                       
                         
                         <div class="form-group">
                           <label for=""> Payment Plan</label>
                           <img class="col-lg-9 img-responsive" src="<?=base_url()?>assets/front/images/payment_plan.jpg">
                            <input type="file" name="userfile" id="input" class="btn" >
                         </div>
                     </div>
                    
                      
                     
                   </div>
                   <button type="submit" class="btn btn-primary">Submit</button>
                       </form>
                 </div>
             </div>
            
           
              
          </div>
        </section>
  </aside>
                
         
                    
             
             
          
