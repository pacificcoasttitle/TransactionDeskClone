<!-- footer content -->
               <!--  <footer>
                    <div class="">
                        <p class="pull-right">Gentelella Alela! a Bootstrap 3 template by <a>Kimlabs</a>. |
                            <span class="lead"> <i class="fa fa-paw"></i> Gentelella Alela!</span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer> -->
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
 <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/admin/js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="<?=base_url()?>assets/admin/js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="<?=base_url()?>assets/admin/js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="<?=base_url()?>assets/admin/js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="<?=base_url()?>assets/admin/js/icheck/icheck.min.js"></script>

    <script src="<?=base_url()?>assets/admin/js/custom.js"></script>

     <!-- Datatables -->
        <script src="<?=base_url()?>assets/admin/js/datatables/js/jquery.dataTables.js"></script>
        <script>

            var base_url ='<?php echo base_url(); ?>';
            $(document).ready(function () {
                $('input.tableflat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            });

            var asInitVals = new Array();
            $(document).ready(function () {
                var oTable = $('#example').dataTable({
                    "oLanguage": {
                        "sSearch": "Search all columns:"
                    },
                    "aoColumnDefs": [
                        {
                            'bSortable': false,
                            'aTargets': [0]
                        } //disables sorting for column one
                    ],
                    'iDisplayLength': 12,
                    "sPaginationType": "full_numbers",
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php echo base_url('assets2/js/Datatables/tools/swf/copy_csv_xls_pdf.swf'); ?>"
                    }
                });
                $("tfoot input").keyup(function () {
                    /* Filter on the column based on the index of this element's parent <th> */
                    oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
                });
                $("tfoot input").each(function (i) {
                    asInitVals[i] = this.value;
                });
                $("tfoot input").focus(function () {
                    if (this.className == "search_init") {
                        this.className = "";
                        this.value = "";
                    }
                });
                $("tfoot input").blur(function (i) {
                    if (this.value == "") {
                        this.className = "search_init";
                        this.value = asInitVals[$("tfoot input").index(this)];
                    }
                });
            });


$(document).ready(function() {

    /*var file_input_index = 0;
    $('input[type=file]').each(function() {
        file_input_index++;
        $(this).wrap('<div id="file_input_container_'+file_input_index+'"></div>');
        $(this).after('<input type="button" class = "btn-link" value="Remove" onclick="reset_html(\'file_input_container_'+file_input_index+'\')" />');
    });
*/

    $('#change-user-pic').click(function(){
        $('#change-user-pic-file').click();        
    });

    $('#change-user-pic-file').change(function(){
        // alert("File Chaneg");
        var file_data = $(this).prop('files')[0];
        var form_data = new FormData();
        form_data.append('fileToUpload', file_data)
        // alert(form_data);                             
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/admin/upload_file', // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response) {
                
                console.log(JSON.parse(php_script_response));
                var object = JSON.parse(php_script_response);
                $('[name=user_pic]').val(object.fileuri);
                $('#change-user-pic img').attr('src',base_url+ object.fileuri);
        }
        });
    });


    $('input[type=checkbox][name=plot_type]').change(function() {
         
            var site_id =$('#project_sites').val();
            var plot_type = ''; 
            $('input[type="checkbox"][name=plot_type]:checked').each(function(index, elem) {
                plot_type+=$(elem).val()+'-';
            });
            console.log(plot_type);
            // return;
            $.ajax({
                url:base_url+'index.php/admin/get_site/'+site_id+'/'+plot_type,
                method:'GET',
                dataType:'json',
                success:function(resp){
                    console.log(resp);
                    var plotsHtml = '';
                    if(resp.site_plots.length>0){
                        for(var k in resp.site_plots){
                            plotsHtml+='<option  value="'+resp.site_plots[k].plot_id+'">'+resp.site_plots[k].plot_number+'</option>'
                        }

                        $('[name=plot_number]').html(plotsHtml);
                        $('[name=plot_area]').val(resp.plot_area);
                        $('[name=rate]').val(resp.rate);
                        $('[name=total_plot_amount]').val(resp.total_plot_amount);
                        $('[name=total_amount]').val(resp.total_plot_amount);
                        $('[name=installments_count]').val(resp.installment);
                    }else{
                        $('[name=plot_number]').html('');
                        $('[name=plot_area]').val('');
                        $('[name=rate]').val('');
                        $('[name=total_plot_amount]').val('');
                        $('[name=total_amount]').val('');
                        $('[name=installments_count]').val('');
                    }
                    console.log(resp.installment);
                }
            });
    });


    $('#project_plots').on('change', function() {
        var plot_id = this.value;
        var plot_type = ''; 
            $('input[type="checkbox"][name=plot_type]:checked').each(function(index, elem) {
                plot_type+=$(elem).val()+'-';
            });
        $.ajax({
            url:base_url+'index.php/admin/get_site/'+$('#project_sites').val()+'/'+plot_type+'/'+plot_id,
            method:'GET',
            dataType:'json',
            success:function(resp){
                $('[name=plot_area]').val(resp.plot_area);
                $('[name=rate]').val(resp.rate);
                $('[name=total_plot_amount]').val(resp.total_plot_amount);
                $('[name=total_amount]').val(resp.total_plot_amount);                
                $('[name=installments_count]').val(resp.installment);
                console.log(resp.installment);
                //installment
            }
          });
    });

    $('#project_sites').on('change', function() {
      // alert( this.value ); // or $(this).val()
      var site_id = this.value;
      var plot_type = ''; 
            $('input[type="checkbox"][name=plot_type]:checked').each(function(index, elem) {
                plot_type+=$(elem).val()+'-';
            });
      $.ajax({
        url:base_url+'index.php/admin/get_site/'+site_id+'/'+plot_type,
        method:'GET',
        dataType:'json',
        success:function(resp){
            if(resp.site_plots.length>0){
                    var plotsHtml = '';
                    for(var k in resp.site_plots){
                        plotsHtml+='<option  value="'+resp.site_plots[k].plot_id+'">'+resp.site_plots[k].plot_number+'</option>'
                    }

                    $('[name=plot_number]').html(plotsHtml);
                    $('[name=plot_area]').val(resp.plot_area);
                    $('[name=rate]').val(resp.rate);
                    $('[name=total_plot_amount]').val(resp.total_plot_amount);
                    $('[name=total_amount]').val(resp.total_plot_amount);
                    $('[name=installments_count]').val(resp.installment);
                }else{
                    $('[name=plot_number]').html('');
                    $('[name=plot_area]').val('');
                    $('[name=rate]').val('');
                    $('[name=total_plot_amount]').val('');
                    $('[name=total_amount]').val('');
                    $('[name=installments_count]').val('');
                }
        }
      });
    });
});

function reset_html(id) {
    $('#'+id).html($('#'+id).html());
}

              


                function isNumber(evt)
                      {

                                evt = (evt) ? evt : window.event;
                                var charCode = (evt.which) ? evt.which : evt.keyCode;
                                 if (charCode == 46) {

                                    return true;
                                }
                                if (charCode > 31 && (charCode < 48 || charCode > 57)) {

                                    return false;
                                }
                                return true;
                      }

function form_validation () 
{
    var aa =  $("[required=required]");
    $.each(aa, function(index, val) 
    {
       if($(val).val()=='')
       {
          var parentRow = $(val).closest('.form-group');
          $(parentRow).addClass('has-error');
       }
       else
       {
          var parentRow = $(val).closest('.form-group');
          $(parentRow).removeClass('has-error');
       }
       

    });
}

$(document).ready(function() {

    



    $(".datepicker" ).datepicker($.extend( {



                dateFormat: 'yy-mm-dd',



            }));

  });


        </script>



</body>

</html>