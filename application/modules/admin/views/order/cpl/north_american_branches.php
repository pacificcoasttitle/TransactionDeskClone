<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            North American Branches
            <div class="float-right">
                <a href="javascript:void(0);" id="refresh_north_american_branches" class="btn btn-secondary">Refresh</a>
            </div>
        </div>
        <div class="card-body">
            <div id="north_american_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="north_american_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl-north-american" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Unique Id</th>
                            <th>Address</th>
                            <th>Address1</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zipcode</th>
                        </tr>
                    </thead>
                    <?php if(!empty($branchesData)) {?>
                        <tbody>
                            <?php foreach($branchesData as $$branchData) { $i = 1;?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $$branchData['unique_id'];?></td>
                                    <td><?php echo $$branchData['address'];?></td>
                                    <td><?php echo $$branchData['address1'];?></td>
                                    <td><?php echo $$branchData['city'];?></td>
                                    <td><?php echo $$branchData['state'];?></td>
                                    <td><?php echo $$branchData['zip'];?></td>
                                </tr> 
                            <?php $i++; }?> 
                        </tbody>
                    <?php } else {?>
                        <tr>
                            <td align="center" colspan="7"> No Records Found.</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#refresh_north_american_branches').click(function(e){
            $('body').animate({ opacity: 0.5 }, "slow");
            $.ajax({
                url: base_url+"/get-north-american-branches",
                method: "POST",
                success: function(data){
                    var result = jQuery.parseJSON(data);
                    if (result.status == 'success') {
                        location.reload();
                    } else {
                        $('#north_american_erro_msg').html(result.message).show();
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#north_american_erro_msg").offset().top
                        }, 1000);

                        setTimeout(function () {
                            $('#north_american_erro_msg').html('').hide();
                        }, 4000);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#north_american_erro_msg').html('Something went wrong. Please try it again.').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#north_american_erro_msg").offset().top
                    }, 1000);

                    setTimeout(function () {
                        $('#north_american_erro_msg').html('').hide();
                    }, 4000);
                }
            })
        });
    });
</script>

