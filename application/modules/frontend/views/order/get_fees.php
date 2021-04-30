<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script> 
    <link rel="stylesheet" href="<?php echo base_url()?>assets/front/css/style.css" media="screen" type="text/css" />
    <?php
        $this->load->view('layout/header_dashboard');
    ?>
    <section class="content-wrapper">
  <div class="row"></div>
  <div class="row">
    <div class="recipt-body" id="artcle_main">
        <div id="editor"></div>
      <div class="article" id="artcle_div">
        <?php
          if(empty($fees))
          {
        ?>
            <span style='font-size: 20px;color: red;'>Fees estimation does not exist.</span>
        <?php
          }
          else
          {
        ?>
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
                    <?php echo isset($productType) && !empty($productType) ? $productType : '-'; ?>                      
                  </td>
                </tr>
                <tr>
                  <td><b>Property Location</b></td>
                  <td>
                    <?php echo isset($full_address) && !empty($full_address) ?$full_address : '-'; ?> 
                  </td>                  
                  <?php
                    if(isset($loan_amount) && !empty($loan_amount))
                    {
                        $loan_amount = str_replace(",", "", $loan_amount);
                  ?>
                      <td><b>Loan Amount </b></td>
                      <td>$<?php echo number_format($loan_amount); ?></td>
                  <?php
                    }
                    else
                    {
                ?>
                        <td></td>
                        <td></td>
                <?php
                    }
                  ?>
                </tr>
                <tr>
                  <?php 
                    if(isset($sales_amount) && !empty($sales_amount))
                    {
                  ?>
                      <td><b>Sales Amount </b></td>
                      <td>$<?php echo number_format($sales_amount); ?> </td>
                      <td></td>
                      <td></td>
                  <?php
                    }
                  ?>
                  
                </tr>
              </tbody>
            </table>
            <div class="clearfix"><p></p></div>
            <table class="table-null" cellspacing="5" cellpadding="5">
              <tbody>
                <tr>
                  <td>
                    <table class="table-data">
                      <tbody>
                        <?php
                            if(isset($fees) && !empty($fees))
                            {
                                foreach ($fees as $key => $value) 
                                {
                        ?>
                                    <tr class="bg-gray">
                                        <td class="bg-gray" colspan="2" style="width:60%"><b><?php echo $key; ?></b></td>
                                    </tr>

                                    <?php
                                        if(isset($value) && !empty($value))
                                        {
                                            foreach ($value as $k => $v) 
                                            {
                                                $description = $v['description']; 
                                                $amount = str_replace(",", "", $v['amount']);
                                    ?>
                                                <tr>
                                                  <td><?php echo $description; ?></td>
                                                  <td class="aright">
                                                    $<?php echo number_format($amount, 2); ?>
                                                  </td>
                                                </tr>
                                    <?php
                                            }
                                        } 
                                    ?>
                        <?php
                                }
                            }
                        ?>
                        
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>              
            </table>
            </div>
            <div class="clearfix" id="act_btns" style="display: none;">  
                <br/>
                <a class="button small orange" id="download_estimate" data-closing-fee-id= "<?php echo $closing_fee_estimate_id; ?>" href="javascript:void(0);">Download Fee Estimate</a>
            </div>
        <?php
          }
        ?>
                
      
    </div>
<!--   </div> -->
</section>
    <?php
       $this->load->view('layout/footer');
    ?>
</body>
</html>
<script>
    $(document).ready(function () {
        var doc = new jsPDF();
        $('#download_estimate').click(function() {
            var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

doc.fromHTML($('#artcle_main').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('sample-file.pdf');
           /* $('#page-preloader').css('background-color', 'rgba(0,0,0,.5)');
            $('#page-preloader').css('display', 'block');
            var closing_fee_id = $(this).data('closing-fee-id');*/
             
            /*$.ajax({
                url: base_url + "get-fee-estimate-pdf",
                type: "post",
                data:{
                    closing_fee_id: closing_fee_id,
                }, 
                success: function(response) {
                    
                    if(response)
                    {
                        if (navigator.msSaveBlob)
                        {                       
                            var csvData = base64toBlob(response,'application/octet-stream');
                            var csvURL = navigator.msSaveBlob(csvData, 'FeeEstimation.pdf');
                            var element = document.createElement('a');
                            element.setAttribute('href', csvURL);
                            element.setAttribute('download', 'FeeEstimation.pdf');
                            element.style.display = 'none';
                            document.body.appendChild(element);
                            document.body.removeChild(element);
                        }
                        else
                        {

                            var csvURL = 'data:application/octet-stream;base64,'+response;
                            var element = document.createElement('a');
                            element.setAttribute('href', csvURL);
                            element.setAttribute('download', 'FeeEstimation.pdf');
                            element.style.display = 'none';
                            document.body.appendChild(element);
                            element.click();
                            document.body.removeChild(element);
                        }
                        $('#page-preloader').css('display', 'none');
                    }
                }
            });*/
        });
    });
    
function base64toBlob(base64Data, contentType) 
{
    contentType = contentType || '';
    var sliceSize = 1024;
    var byteCharacters = atob(base64Data);
    var bytesLength = byteCharacters.length;
    var slicesCount = Math.ceil(bytesLength / sliceSize);
    var byteArrays = new Array(slicesCount);

    for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
        var begin = sliceIndex * sliceSize;
        var end = Math.min(begin + sliceSize, bytesLength);

        var bytes = new Array(end - begin);
        for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
            bytes[i] = byteCharacters[offset].charCodeAt(0);
        }
        byteArrays[sliceIndex] = new Uint8Array(bytes);
    }
    return new Blob(byteArrays, { type: contentType });
}
</script>