 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                   
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:600px;">
                               <div class="x_title">
                                    <h2 >Manage product categories</h2>
  <a href="#add_new_form" onclick="add_new(0)" class="btn btn-success pull-right"  data-toggle="modal"> Add New</a>
                                   
                                    <div class="clearfix"></div>
                                </div>

          <div class="x_content">
                        
                               
                      <?php $i = 1;foreach($category as $info)   { ?>
                      <?php if ($info->parent_category_id == 0): ?>
                        
                      <div class="row">
                              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                 <div ><h4 id="name<?=$info->category_id?>"><?php print_r($info->category_name);?> </h4>
                                </div>
                                </div>
                                 <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                  <div class="btn-group">
                                 
                                    <a href="#add_new_form" onclick="add_new(<?=$info->category_id?>)" class="btn btn-xs btn-success"  data-toggle="modal" title="Add new Sub category"><i class="fa fa-plus"></i></a>
                                    <a class="btn btn-xs btn-info"   onclick = "show_sub(<?=$info->category_id?>)" title="View Sub category" ><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-xs btn-warning" href="#edit_form"   onclick = "type_edit(<?=$info->category_id?>)" title="Edit category" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-xs btn-danger" href = "delete_product_type/<?=$info->category_id?>" title="Delete category" onclick="return confirm('Really want to delete ??')"><i class="fa fa-times"></i> </a>
                                  </div>
                                   <?php $count1 =0;    
                                        foreach ($category as $key_sub1) 
                                        {
                                          if($key_sub1->parent_category_id !=0 && $key_sub1->parent_category_id == $info->category_id)
                                          {
                                            $count1 += 1;
                                          }
                                        }

                                    ?>
                                 <?php if ($count1){ ?>
                                   <div id="sub_div_<?=$info->category_id?>" style="display:none;background:#cfcfcf;padding:5px;margin-left:20px;">
                                
                                  <?php $i = 1;foreach($category as $sub_1)   { ?>
                                  <?php if ($sub_1->parent_category_id == $info->category_id): ?>
                                <div class="row">  
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                 <div ><h4 id="name<?=$sub_1->category_id?>"><?php print_r($sub_1->category_name);?> </h4>
                                </div>
                                </div>
                                 <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                  <div class="btn-group">
                                  <a href="#add_new_form" onclick="add_new(<?=$sub_1->category_id?>)" class="btn btn-xs btn-success"  data-toggle="modal" title="Add new Sub category"><i class="fa fa-plus"></i></a>
                                    <a class="btn btn-xs btn-info" onclick = "show_sub(<?=$sub_1->category_id?>)"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-xs btn-warning" href="#edit_form"   onclick = "type_edit(<?=$sub_1->category_id?>)" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-xs btn-danger" href = "delete_product_type/<?=$sub_1->category_id?>" onclick="return confirm('Really want to delete ??')"><i class="fa fa-times"></i> </a>
                                  </div>
                                      <?php $count2 =0;    
                                        foreach ($category as $key_sub2) 
                                        {
                                          if($key_sub2->parent_category_id !=0 && $key_sub2->parent_category_id == $sub_1->category_id)
                                          {
                                            $count2 += 1;
                                          }
                                        }

                                    ?>
                                 <?php if ($count2){ ?>
                                   <div id="sub_div_<?=$sub_1->category_id?>" style="display:none;background:#fafafa;padding:5px;margin-left:20px;">
                                
                                  <?php $i = 1;foreach($category as $sub_2)   { ?>
                                  <?php if ($sub_2->parent_category_id == $sub_1->category_id): ?>
                                <div class="row">  
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                 <div ><h4 id="name<?=$sub_2->category_id?>"><?php print_r($sub_2->category_name);?> </h4>
                                </div>
                                </div>
                                 <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                  <div class="btn-group">
                                  <a href="#add_new_form" onclick="add_new(<?=$sub_2->category_id?>)" class="btn btn-xs btn-success"  data-toggle="modal" title="Add new Sub category"><i class="fa fa-plus"></i></a>
                                    <a class="btn btn-xs btn-info" onclick = "show_sub(<?=$sub_2->category_id?>)" ><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-xs btn-warning" href="#edit_form"   onclick = "type_edit(<?=$sub_2->category_id?>)" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-xs btn-danger" href = "delete_product_type/<?=$sub_2->category_id?>" onclick="return confirm('Really want to delete ??')"><i class="fa fa-times"></i> </a>
                                  </div>
                                    <?php $count3 =0;    
                                        foreach ($category as $key_sub3) 
                                        {
                                          if($key_sub3->parent_category_id !=0 && $key_sub3->parent_category_id == $sub_2->category_id)
                                          {
                                            $count3 += 1;
                                          }
                                        }

                                    ?>
                                 <?php if ($count3){ ?>
                                   <div id="sub_div_<?=$sub_2->category_id?>" style="display:none;background:#cfcfcf;padding:5px;margin-left:20px;">
                                
                                  <?php $i = 1;foreach($category as $sub_3)   { ?>
                                  <?php if ($sub_3->parent_category_id == $sub_2->category_id): ?>
                                <div class="row">  
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                 <div ><h4 id="name<?=$sub_3->category_id?>"><?php print_r($sub_3->category_name);?> </h4>
                                </div>
                                </div>
                                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                  <div class="btn-group">
                                    <a class="btn btn-xs btn-warning" href="#edit_form"   onclick = "type_edit(<?=$sub_3->category_id?>)" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-xs btn-danger" href = "delete_product_type/<?=$sub_3->category_id?>" onclick="return confirm('Really want to delete ??')"><i class="fa fa-times"></i> </a>
                                  </div>

                                  </div>
                                  </div>
                                  
                                     <?php endif ?>
                                    <?php  $i++;}?> 
                                    </div>
                                   <?php }else{?>
                                    <div class="row" id="sub_div_<?=$sub_2->category_id?>" style="display:none">
                                    <h4>No Sub category</h4>
                                    </div>
                                   <?php }?>
                                  </div>
                                  </div>
                                  
                                     <?php endif ?>
                                    <?php  $i++;}?> 
                                    </div>
                                   <?php }else{?>
                                    <div class="row" id="sub_div_<?=$sub_1->category_id?>" style="display:none">
                                    <h4>No Sub category</h4>
                                    </div>
                                   <?php }?>
                                  </div>
                                  </div>
                                  
                                     <?php endif ?>
                                    <?php  $i++;}?> 
                                    </div>
                                   <?php }else{?>
                                    <div class="row" id="sub_div_<?=$info->category_id?>" style="display:none">
                                    <h4>No Sub category</h4>
                                    </div>
                                   <?php }?>


                                
                                
                              </div>
                               
                            </div>
                         <?php endif ?>
                      <?php  $i++;}?>
               
                       
                    </div> 




                            </div>
                        </div>
                    </div>
                </div>

                <div id="edit_form" class="modal  fade" tabindex="-1" role="dialog" >
       <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Edit Type</h3>
              </div>        
            <div class="modal-body">
                                            
                     <form action="" method="post">
                        <div class="form-group clearfix">
                                        <label>Type Name</label>
                            
                              <input class="form-control" type="text" id = "type_val" name = "type_name_edit" value="" required>
                              <input type="hidden" id = "type_id" name = "id" value="" >
                         
                        </div>
                
                        <input type="submit"  class="btn btn-success" value="Edit">
                      </form>
                                                   
            </div> 
        </div>
    </div>
    </div>
<div id="add_new_form" class="modal  fade" tabindex="-1" role="dialog" >
       <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Add New Type</h3>
              </div>        
            <div class="modal-body">
                                     
                       <form action="" method="post">
                            <div class="form-group clearfix">
                                            <label>Type Name</label>
                                          <input class="form-control" type="text" name = "type_name" value="" required></div>
                 <input type="hidden" name="parent_category_id"  id="parent_category_id" value="0"/>
                
                            <input type="submit"  class="btn btn-success" value="Add">
                        </form>
                                                     
            </div> 
        </div>
         </div>
    </div>
    
 
   
<script>
function type_edit(id) 
{
  var a = $("#name"+id).html();

  $("#type_val").val(a);
  $("#type_id").val(id);
}

function show_sub (id) 
{
  $("#sub_div_"+id).slideToggle();
}

function add_new (p_id) 
{
  $("#parent_category_id").val(p_id);
}
</script>