<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Icon Cards-->
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                        <i class="fas fa-fw"></i>
                        </div>
                        <div class="mr-5"><?php echo $totalCount.' Total Orders'; ?></div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url().'order/admin/orders' ?>">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw"></i>
                        </div>
                        <div class="mr-5"><?php echo $loanCount.' Refinance Orders'; ?></div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url().'order/admin/orders/loan' ?>">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                        <i class="fas fa-fw"></i>
                        </div>
                        <div class="mr-5"><?php echo $salesCount.' Sales Orders'; ?></div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url().'order/admin/orders/sale' ?>">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                        <i class="fas fa-fw"></i>
                        </div>
                        <div class="mr-5"><?php echo $totalFailCount.' Total Fails'; ?></div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url().'order/admin/orders' ?>">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw"></i>
                        </div>
                        <div class="mr-5"><?php echo $lvCount.' Legal & Vesting Fails'; ?></div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url().'order/admin/lv-log' ?>">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                        <i class="fas fa-fw"></i>
                        </div>
                        <div class="mr-5"><?php echo $grantDeedCount.' Grant Deed Fails'; ?></div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url().'order/admin/grant-deed-log' ?>">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                        <i class="fas fa-fw"></i>
                        </div>
                        <div class="mr-5"><?php echo $taxCount.' Tax Fails'; ?></div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url().'order/admin/tax-log' ?>">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-wrapper -->

<!-- <script type="text/javascript">
    $(document).ready(function() {
        alert();
    });
</script> -->