  <link rel="stylesheet" href="<?=base_url()?>assets/admin/css/jquery.jOrgChart.css"/>
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/css/custom_tree.css"/>

    <link href="<?=base_url()?>assets/admin/css/prettify.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="<?=base_url()?>assets/admin/js/prettify.js"></script>
     <script src="<?=base_url()?>assets/admin/js/jquery.min.js"></script>
    <!-- jQuery includes -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    
    <script src="<?=base_url()?>assets/admin/js/jquery.jOrgChart.js"></script>

    <script>
    jQuery(document).ready(function() {
        $("#org").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : true
        });
    });
    </script>
<body onload="prettyPrint();">
    

<ul id="org" style="display:none">
    <?php foreach ($user_references as $key): ?>
        <?php if ($key->ref_id === $user_info->ref_id):  ?>
            <li><?=$key->ref_id?><ul>
                <?php  print get_child_nodes($user_references,$key->ref_id);?>
          </ul></li>
        <?php endif ?>
    <?php endforeach ?>
</ul>            
    


    <?php 

function get_child_nodes($user_references, $parent)
{
    $chid  = "";
   foreach ($user_references as $ref) 
   {
      if($ref->parent_ref_id == $parent)
      {
         
            $chid .= '<li>'.$ref->ref_id.'<ul>';
            $sub = get_child_nodes($user_references,$ref->ref_id);
            $chid .= $sub.'</ul></li>';
      }
   }
return $chid;

}

    ?>
    <div id="chart" class="orgChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <script>
        jQuery(document).ready(function() {
            
            /* Custom jQuery for the example */
            $("#show-list").click(function(e){
                e.preventDefault();
                
                $('#list-html').toggle('fast', function(){
                    if($(this).is(':visible')){
                        $('#show-list').text('Hide underlying list.');
                        $(".topbar").fadeTo('fast',0.9);
                    }else{
                        $('#show-list').text('Show underlying list.');
                        $(".topbar").fadeTo('fast',1);                  
                    }
                });
            });
            
            $('#list-html').text($('#org').html());
            
            $("#org").bind("DOMSubtreeModified", function() {
                $('#list-html').text('');
                
                $('#list-html').text($('#org').html());
                
                prettyPrint();                
            });
        });
    </script>