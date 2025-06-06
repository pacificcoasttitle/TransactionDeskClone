<div class="row mb-3">
    <div class="col-sm-12">
        <a style="float:right" class="btn-success btn-icon-split btn-sm " href="<?php echo base_url();?>fees">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Back</span>
        </a>
    </div>
</div>
<section class="content-wrapper" style="margin-bottom:50px;">
    <div class="row">

    </div>
    <div class="row">
        <div class="recipt-body" id="artcle_main">
            <div id="editor"></div>
            <div class="article" id="artcle_div">
                <?php if(empty($calcResult)) { ?>
                    <span style='font-size: 20px;color: red;'>Fees estimation does not exist.</span>
                <?php } else { ?>
                    <table class="table" style="max-width:100%">
                        <tbody>
                            <tr>
                                <td style="border-top:none;" colspan="4">
                                    <h3><strong>Pacific Coast Title</strong> - Fee Estimate</h3>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Order Number</b></td>
                                <td><?php echo isset($order_number) && !empty($order_number) ? $order_number : '-'; ?></td>
                                <td><b>Transaction Type</b></td>
                                <td>
                                    <?php echo isset($transactionType) && !empty($transactionType) ? $transactionType : '-'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Property Location</b></td>
                                <td>
                                    <?php echo isset($full_address) && !empty($full_address) ?$full_address : '-'; ?>
                                </td>
                                <?php if(isset($loan_amount) && !empty($loan_amount)) {
                                        $loan_amount = str_replace(",", "", $loan_amount); ?>
                                        <td><b>Loan Amount </b></td>
                                        <td>$<?php echo number_format($loan_amount); ?></td>
                                <?php } else { ?>
                                        <td></td>
                                        <td></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php if(isset($sales_amount) && !empty($sales_amount)) { ?>
                                    <td><b>Sales Amount </b></td>
                                    <td>$<?php echo number_format($sales_amount); ?> </td>
                                    <td></td>
                                    <td></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <p></p>
                    </div>
                    <table class="table-null" cellspacing="5" cellpadding="5">
                        <tbody>
                            <tr>
                                <td>
                                    <table class="table-data">
                                        <tbody>
                                            

                                            <tr class="bg-gray">
                                                <td class="bg-gray" colspan="2" style="width:60%"><b>Fees changes</b></td>
                                            </tr>

                                            <?php if (!empty($calcResult)) { 
                                                foreach($calcResult as $fee)  { ?>
                                                    <tr>
                                                        <td><?php echo $fee['Description'];?></td>
                                                        <td class="aright">
                                                            <?php echo $fee['Amount']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td class="aright">
                                                        <b><?php echo "$".number_format($totalAmount , 2); ?></b>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
            
        </div>
        <div class="clearfix" id="act_btns">
            <br />
            <a class="button small orange" id="download_estimate" data-closing-fee-id="<?php echo $closing_fee_estimate_id; ?>" href="javascript:void(0);">Download Fee Estimate</a>
        </div>
    </div>	
</section>



