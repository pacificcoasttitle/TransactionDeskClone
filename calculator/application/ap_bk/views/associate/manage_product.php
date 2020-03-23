 <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                  
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:1200px;">
                                 <div class="x_title">
          <h2> Manage Products</h2>
          <a href="<?=base_url()?>index.php/associate/product_add"  class="btn btn-success pull-right" > Add New</a>
    
           <div class="clearfix"></div>
            </div>
           

      <div class="x_content">
                
             

                
                        <table id="example" class="table table-striped responsive-utilities jambo_table"><thead>
                                <tr>
                                    
                                    <th class="col-md-1">Sr. no.</th>
                                        <th  class="col-md-2" >Product Name</th>
                                        <th  class="col-md-2" >Associate Name</th>
                                        <th  class="col-md-2" >Product Price</th>
                                        <th  class="col-md-5" width="50%">Actions</th>
                                        
                                        
                                </tr>
                            </thead>
                            <tbody>


                               
                                <?php $i = 1;foreach($products as $info)   { ?> 
                               
                                  
                               
                                    <tr>
                                        <td> <?php print_r($i);?>   </td>
                                        <td>  <?php print_r($info->product_name);?> </td>
                                        <td> <?php print_r($info->store_name);?>   </td>
                                       
                                        <td> <?php print_r(number_format($info->selling_price,2));?><?php if(strlen($info->bnb_product_code) > 20){echo"...";}?></td>
                                        <td>
                        <div class="btn-group">
                                          <a class="btn btn-danger" href="<?=base_url()?>index.php/associate/deleteproduct/<?php print_r($info->product_id);?>"><i class="fa fa-times"></i></a>
                                        <?php if($info->status==0){?>
                                        <a class="btn btn-success"  href="<?=base_url()?>index.php/associate/verifyproduct/<?php print_r($info->product_id);?>">Activate</a>
                                        <?php }else{?>
                                        <a class="btn btn-warning" href="<?=base_url()?>index.php/associate/unverifyproduct/<?php print_r($info->product_id);?>">Deactivate</a>
                                        <?php }?>
                
                   
                    <a class="btn  btn-info" data-toggle="modal" data-target="#myModal" role = "button"  title="view" onclick="product_view(<?php print_r($info->product_id);?>,<?php print_r($info->store_id);?>,<?php print_r($info->store_id);?>)"><i class="fa fa-eye"></i>
                                        </a> <a class="btn btn-warning " data-toggle="modal" data-target="#myModal2" role = "button"  title="view" onclick="product_edit(<?php print_r($info->product_id);?>,<?php print_r($info->store_id);?>)"><i class="fa fa-edit"></i></a> 
                    </div> 
                                        </td>
                    
                                       
                                        
                                    </tr>
                                    <?php  $i++;}?>                                
                            </tbody>
                        </table>
                   
                                             
                
            </div>   
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
 <div class="modal-content">
 <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h4 class="modal-title">Edit Product Details</h4>
            </div>
             <div class="modal-body">
            <div class="row" style="height:400px;overflow-Y:scroll;" enctype="multipart/form-data">
            <form name="form" id="" class="form" action="<?=base_url()?>index.php/associate/product_update/" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="product_id" id="product_id" value="">
                            <div class="form-group clearfix">
                                <label class="col-lg-3">Product Name:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "product_name" id = "product_name" value="" required></div>
                            </div>
                            <!--<div class="form-group clearfix">
                                <label class="col-lg-3">Product Code:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "bnb_product_code" id = "bnb_product_code" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3">Product Style:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "style" id = "style" value="" required></div>
                            </div>-->
                            <div class="form-group clearfix">
                                <label class="col-lg-3">Product Description:</label>
                                <div class="col-lg-9" id="demo"> <textarea  name="description" id="description_0" rows="5"  class="form-control" ></textarea></div>
                            </div>
                            <div class="form-group clearfix">
                            <label class="col-lg-3">Product Category:</label>
                            <div class="col-lg-9">
                             
                            <select class="form-control" id = "cat_id" name = "cat_id" onchange="get_sub(1,this.value)">
                            <option value="" selected="true"> -- Select one -- </option>
                                <?php foreach ($category as $key): ?>
                                    <?php if ($key->parent_category_id == 0): ?>
                                        <option value="<?=$key->category_id?>"><?=$key->category_name?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            
                             </div>
                        </div>
                        <div class="form-group clearfix"  id="sub_1" style="display:none;">
                            <label class="col-lg-3">Product sub Category(1):</label>
                            <div class="col-lg-9">
                             
                            <select class="form-control" name = "sub_catid1" id="sub_sel_1" onchange="get_sub(2,this.value)">
                            <option value=""> -- Select one -- </option>
                                <?php foreach ($category as $key): ?>
                                    <?php if ($key->parent_category_id != 0): ?>
                                        <option style="display:none;" class = "sub1_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            
                             </div>
                        </div>
                         <div class="form-group clearfix" id="sub_2" style="display:none;">
                            <label class="col-lg-3">Product sub Category(2):</label>
                            <div class="col-lg-9">
                             
                            <select class="form-control" name = "sub_catid2" id="sub_sel_2" onchange="get_sub(3,this.value)">
                            <option value=""> -- Select one -- </option>
                                <?php foreach ($category as $key): ?>
                                    <?php if ($key->parent_category_id != 0): ?>
                                        <option style="display:none;" class = "sub2_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            
                             </div>
                        </div>
                         <div class="form-group clearfix"   id="sub_3" style="display:none;">
                            <label class="col-lg-3">Product sub Category(3):</label>
                            <div class="col-lg-9">
                             
                            <select class="form-control" name = "sub_catid3" id="sub_sel_3">
                            <option value=""> -- Select one -- </option>
                                <?php foreach ($category as $key): ?>
                                    <?php if ($key->parent_category_id != 0): ?>
                                        <option style="display:none;" class = "sub3_<?=$key->parent_category_id?>" value="<?=$key->category_id?>"><?=$key->category_name?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            
                             </div>
                        </div>
                           <!--  <div class="form-group clearfix">
                                <label class="col-lg-3">Product Tags:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "tags" id = "tags" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3">Product length:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "length" id = "length" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3">Product Breadth:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "breadth" id = "breadth" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3"> Product height:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "height" id = "height" value="" required></div>
                            </div>
                            
                            <div class="form-group clearfix">
                                <label class="col-lg-3"> Product Actual Weight:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "prd_act_weight" id = "prd_act_weight" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3">Product Volume Weight:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "prd_vol_weight" id = "prd_vol_weight" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3"> Product Tax rate:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "tax_rate" id = "tax_rate" value="" required.></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3"> Product Insurance Cost:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "insurance_cost" id = "insurance_cost" value="" required></div>
                            </div>-->
                             <div id="custom_fields"></div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3"> Product Shipping Cost:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "shipping_cost" id = "shipping_cost" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3"> Product Selling Cost:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "selling_price" id = "selling_price" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3"> Product Quantity:</label>
                                <div class="col-lg-9"><input class="form-control" type="text" name = "quantity" id = "quantity" value="" required></div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-3"> Images:</label>
                                <div class="col-lg-9" id="prod_images"></div>
                            </div>
                             <div class="form-group clearfix">
                            <label class="col-lg-3">Upload new Image:</label>
                            <div class="col-lg-9" id="browse_file">                                                                
                                
                            </div>
                        </div>
                            <input class="btn btn-success btn-lg" type="submit" class="btn" value="save" >
                          </form>
                      </div>
                 </div>
            <div class="modal-footer">
            <button aria-hidden="true" data-dismiss="modal" class="btn btn-danger">Close</button>            
            </div>
            </div>
            </div>
</div>



<script type="text/javascript" src="<?php echo base_url();  ?>assets/associate/js/ckeditor/ckeditor.js"></script>
<script>
function product_view(id,store_id){
    
     $.ajax({
               url     : "<?=base_url()?>index.php/associate/product_detail/"+id+"/"+store_id,
               type    : "POST",
              success : function( data )
                        { 
                       
                          //alert(data);
                          
                          document.getElementById('myModal').innerHTML = data;
                           
                         
                              return false;                        
                      },
                    error   : function( xhr, err )
                      {
                        alert('Error');
                       
                        return false;    
                      }
        });
    
}
var desc_id1 = 0;
var desc_id2 = 1;

function product_edit(id){
    var onlimit=0;
    var couimg=0;

     $.ajax({
                             url     : "<?=base_url()?>index.php/associate/product_edit/"+id,
                             type    : "POST",
                 success : function( data )
                        { 
                       
                            //alert(data);
                          //document.getElementById('myModal2').innerHTML = data;
                           //$(".ckeditor").ckeditor();
                           $('#prod_images').html('');
                         var arr = $.parseJSON(data);
                         var p_id = 0;
                          $.each(arr, function( index, value ) 
                          { 
                             if(index == "product_id" )
                               {
                                  $("#product_id").val(value);
                               } 
                               if(index == "product_name" )
                               {
                                $("#product_name").val(value);
                               } 
                              // if(index == "bnb_product_code" )
                              //  {
                              //   $("#bnb_product_code").val(value);
                              //  } 
                              // if(index == "style" )
                              //  {
                              //   $("#style").val(value);
                              //  } 
                             if(index == "description" )
                               {
                                  $("#demo").html('<textarea  name="description" id="description_'+desc_id2+'" rows="5"  class="form-control" ></textarea>');

                            
                                  $("#description_"+desc_id2).html(value); 
                                  $("#description_"+desc_id2).show(); 
                                  desc_id1 = desc_id2;
                                  desc_id2 +=1;
                                  CKEDITOR.replace( 'description_'+desc_id1 );
                                 
                                
                               } 
                            
                            if(index == "cat_id" )
                             {
                              if(value != null)
                              {
                                $("#cat_id").val(value);
                                p_id = value;
                              }
                             } 
                             if(index == "sub_catid1" )
                             {
                              $("#sub_1").hide();
                              if(value != 0 && value != null)
                              {
                                
                                $(".sub1_"+p_id).show();
                                $("#sub_sel_1").val(value);
                                $("#sub_1").show();
                                p_id = value;
                              }
                             } 
                             if(index == "sub_catid2" )
                             {
                              
                              $("#sub_2").hide();
                              if(value != 0 && value != null)
                              {
                                $(".sub2_"+p_id).show();
                                $("#sub_sel_2").val(value);
                                $("#sub_2").show();
                                p_id = value;
                              }
                             } 
                             if(index == "sub_catid3" )
                             {
                              $("#sub_3").hide();
                              if(value != 0 && value != null)
                              {
                                
                                $(".sub3_"+p_id).show();
                                $("#sub_sel_3").val(value);
                                $("#sub_3").show();
                                p_id = value;
                              }
                             } 
                            // if(index == "tags" )
                            //  {
                            //   $("#tags").val(value);
                            //  } 
                            // if(index == "length" )
                            //  {
                            //   $("#length").val(value);
                            //  } 
                             
                            //  if(index == "breadth" )
                            //  {
                            //   $("#breadth").val(value);
                            //  } 
                            //  if(index == "height" )
                            //  {
                            //   $("#height").val(value);
                            //  } 
                             
                            // if(index == "prd_act_weight" )
                            //  {
                            //   $("#prd_act_weight").val(value);
                            //  } 
                            // if(index == "prd_vol_weight" )
                            //  {
                            //   $("#prd_vol_weight").val(value);
                            //  } 
                            // if(index == "tax_rate" )
                            //  {
                            //   $("#tax_rate").val(value);
                            //  } 
                            // if(index == "insurance_cost" )
                            //  {
                            //   $("#insurance_cost").val(value);
                            //  } 
                             if(index == "shipping_cost" )
                             {
                              $("#shipping_cost").val(value);
                             }  
                            if(index == "selling_price" )
                             {
                              $("#selling_price").val(value);
                             }  
                             if(index == "custom_fields" )
                             {
                              $("#custom_fields").html(value);
                              CKEDITOR.replace('texteditor');
                             }  

                            if(index == "quantity" )
                             {
                              $("#quantity").val(value);
                             } 
                             if(index == "images" )
                             {
                               $.each(value, function( i, val ) {
                                  var src=$('<img>');
                                  src.attr({id: 'img_'+val.id, style : 'margin:10px;',src: "<?php echo base_url(); ?>upload/store/"+val.store_id+"/"+val.product_id+"/"+val.image_name, width: "100px", height: "100px" });
                                  var delet=$('<input>');
                                  delet.attr({id:'btn_'+val.id,type: 'button', value: 'Delete', onclick: 'img_delete("'+val.id+'","'+val.store_id+'","'+val.product_id+'","'+val.image_name+'")', class:'btn btn-danger'});
                                  var img=$('#prod_images');
                                  src.appendTo(img);

                                  delet.appendTo(img);
                                  var br = $("<br>");
                                  br.appendTo(img);
                               });
                             } 
                             
                             
                             if(index=="imagecount")
                             {
                                couimg=parseInt(value);
                                
                                
                             }
                             if(index=="no_of_image_limit")
                             {
                                onlimit=parseInt(value);
                                
                                var browse=onlimit-couimg;
                                $("#browse_file").html("");
                                for(i=0;i<browse;i++)
                                {
                                  var file=$('<input>');
                                  file.attr({type:'file', name:'userfile['+i+']'});
                                  file.appendTo($('#browse_file'));
                                }
                             }
                             
                              
                             

 


                          });
                              return false;                        
                      },
                    error   : function( xhr, err )
                      {
                        alert('Error');
                       
                        return false;    
                      }
        });
    
}

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
            else{
              show_fields(id);
            }
           
        }


function img_delete(id,store_id,product_id,image_name)
{
    $.ajax({
              url     : "<?=base_url()?>index.php/associate/img_delete/"+id+"/"+store_id+"/"+product_id+"/"+image_name,
              type    : "POST",
              success : function( data )
              {
                   if(data==1)
                   {
                    alert('image deleted');
                    $('#img_'+id).hide();
                    $('#btn_'+id).hide();
                   }
              }
          });
}

function show_fields (case_id)
        {

          var get_url="";
          var cat_id = "";
          var sub_catid1 = "";
          var sub_catid2 = "";
          var sub_catid3 = "";
           switch(case_id)
           {
              case 1:
                cat_id = $("#cat_id").val();
                get_url = "<?=base_url()?>index.php/store/show_fields/"+cat_id;
              break;
              case 2:
                cat_id = $("#cat_id").val();
                sub_catid1 = $("#sub_sel_1").val();
                get_url = "<?=base_url()?>index.php/store/show_fields/"+cat_id+"/"+sub_catid1;
              
              break;
              case 3:
                cat_id = $("#cat_id").val();
                sub_catid1 = $("#sub_sel_1").val();
                sub_catid2 = $("#sub_sel_2").val();
                get_url = "<?=base_url()?>index.php/store/show_fields/"+cat_id+"/"+sub_catid1+"/"+sub_catid2;
              
              break;
              case 4:
                cat_id = $("#cat_id").val();
                sub_catid1 = $("#sub_sel_1").val();
                sub_catid2 = $("#sub_sel_2").val();
                sub_catid3 = $("#sub_sel_3").val();
                get_url = "<?=base_url()?>index.php/store/show_fields/"+cat_id+"/"+sub_catid1+"/"+sub_catid2+"/"+sub_catid3;
              
              break;
              default:
              alert("de");
           }

            $.ajax({
                             url     : get_url,
                             type    : "POST",
                 success : function( data )
                        { 
                       
                          //alert(data);
                          document.getElementById('custom_fields').innerHTML = data;
                          CKEDITOR.replace( 'texteditor' );
                         
                              return false;                        
                      },
                    error   : function( xhr, err )
                      {
                        alert('Error');
                       
                        return false;    
                      }
        });
        }



function add_to_deals(id) 
{
  $.ajax({
                             url     : "<?=base_url()?>index.php/associate/add_to_deals/"+id,
                             type    : "POST",
                 success : function( data )
                        { 
                       
                         // alert(data);
                          document.getElementById('myModal').innerHTML = data;
                           
                         
                              return false;                        
                      },
                    error   : function( xhr, err )
                      {
                        alert('Error');
                       
                        return false;    
                      }
        });
}

 function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        } 

        function check_price (actual)
        {
          var offer  = $("#offer").val();
          if(offer < actual)
          {
            return true;
             }
          else{
            $("#error").html("offer price should be less than actual price !!");
            $("#error").show();
            return false;
          }
        }

</script>