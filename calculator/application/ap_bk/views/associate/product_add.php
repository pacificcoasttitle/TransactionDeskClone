 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                   
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:800px;">
                                <div class="x_title">
                                    <h2>Add Product</h2>
                                    
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                        <div class="row">
                
                <div class="position-center">                    
                   
                 
                       
                      <form name="form" id="" class="form-horizontal" action="<?=base_url()?>index.php/associate/product_add/" method="post" enctype="multipart/form-data">
                        <div class="form-group clearfix">
                            <label class="col-lg-3">Product Name:</label>
                            <div class="col-lg-6"><input class="form-control" type="text" name = "product_name" value="" required></div>
                        </div>
                        <!-- <div class="form-group clearfix">
                            <label class="col-lg-3">Product Code:</label>
                            <div class="col-lg-6"><input class="form-control" type="text" name = "bnb_product_code" value="" required></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-lg-3">Product Style:</label>
                            <div class="col-lg-6"><input class="form-control" type="text" name = "style" value="" required></div>
                        </div>-->
                        <div class="form-group clearfix">
                            <label class="col-lg-3">Product Description:</label>
                            <div class="col-lg-6">
                              <div class="block-fluid" id="wysiwyg_container">
                             <textarea  name="description" class="form-control ckeditor" rows="5" ></textarea>
                             </div>
                             </div>
                        </div> 
                        <div class="form-group clearfix">
                            <label class="col-lg-3">Product Category:</label>
                            <div class="col-lg-5">
                             
                            <select class="form-control" name = "cat_id" id = "cat_id" onchange="get_sub(1,this.value)">
                            <option value=""> -- Select one -- </option>
                                <?php foreach ($category as $key): ?>
                                    <?php if ($key->parent_category_id == 0): ?>
                                        <option value="<?=$key->category_id?>"><?=$key->category_name?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            
                             </div>
                             <!--  <div class="col-lg-4">
                             <button type="button" onclick = "show_fields(1)" class="btn btn-primary">Add product for this category</button>
                             </div> -->
                        </div>
                        <div class="form-group clearfix"  id="sub_1" style="display:none;">
                            <label class="col-lg-3">Product sub Category(1):</label>
                            <div class="col-lg-5">
                             
                            <select class="form-control" name = "sub_catid1" id="sub_sel_1" onchange="get_sub(2,this.value)">
                            <option value=""> -- Select one -- </option>
                                <?php foreach ($category as $key): ?>
                                    <?php if ($key->parent_category_id != 0): ?>
                                        <option style="display:none;" class = "sub1_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            
                             </div>
                             <!--  <div class="col-lg-4">
                             <button type="button" onclick = "show_fields(2)" class="btn btn-primary">Add product for this sub-category</button>
                             </div> -->
                        </div>
                         <div class="form-group clearfix" id="sub_2" style="display:none;">
                            <label class="col-lg-3">Product sub Category(2):</label>
                            <div class="col-lg-5">
                             
                            <select class="form-control" name = "sub_catid2" id="sub_sel_2" onchange="get_sub(3,this.value)">
                            <option value=""> -- Select one -- </option>
                                <?php foreach ($category as $key): ?>
                                    <?php if ($key->parent_category_id != 0): ?>
                                        <option style="display:none;" class = "sub2_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            
                             </div>
                             <!--  <div class="col-lg-4">
                             <button type="button" onclick = "show_fields(3)" class="btn btn-primary">Add product for this sub-category</button>
                             </div> -->
                        </div>
                         <div class="form-group clearfix"   id="sub_3" style="display:none;">
                            <label class="col-lg-3">Product sub Category(3):</label>
                            <div class="col-lg-5">
                             
                            <select class="form-control" name = "sub_catid3" id="sub_sel_3" onchange="get_sub(4,this.value)">
                            <option value=""> -- Select one -- </option>
                                <?php foreach ($category as $key): ?>
                                    <?php if ($key->parent_category_id != 0): ?>
                                        <option style="display:none;" class = "sub3_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            
                             </div>
                             <!--  <div class="col-lg-4">
                             <button type="button" onclick = "show_fields(4)" class="btn btn-primary">Add product for this sub-category</button>
                             </div> -->
                        </div>

                        <div id="form_fields"></div>
                        
                      
                        <div class="form-group clearfix">
                            <label class="col-lg-3"> Product Shipping Cost:</label>
                            <div class="col-lg-6"><input class="form-control" type="number" name = "shipping_cost" value="" required></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-lg-3"> Product Selling Cost:</label>
                            <div class="col-lg-6"><input class="form-control" type="number" name = "selling_price" value="" required></div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-lg-3"> Product Quantity:</label>
                            <div class="col-lg-6"><input class="form-control" type="number" name = "quantity" value="" required></div>
                        </div> 
                        <div class="form-group clearfix">
                            <label class="col-lg-3">Product Image:</label>
                            <div class="col-lg-6">
                               <?php for($i=0;$i<3;$i++){ ?>                                                              
                                <input class="btn btn-white" type="file" name="userfile[<?php echo $i; ?>]" accept="image/*"/><p></p>
                               <?php } ?>
                            </div>
                        </div>
                        <input class="form-control" type="hidden" value="<?=$this->session->userdata('asso_id');?>" name="store_id">
                        <input  type="submit"  class="btn btn-success" value="save" >
                            </form>

                      
                </div>                                
                
            </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <script type="text/javascript">
        function get_sub(id,p_id) 
        {
            $("#sub_"+id+" option").hide();
            var count = $(".sub"+id+"_"+p_id);
            for(var i = id+1;i<=4;i++)
                 {
                    $("#sub_"+i).hide();
                 }
            if(count.length)
            {
                 $(".sub"+id+"_"+p_id).show();
                 $("#sub_"+id).slideDown('500');
                 $("#sub_sel_"+id).val("");
                 
                 
            }
            
           
        }


       
        </script>



