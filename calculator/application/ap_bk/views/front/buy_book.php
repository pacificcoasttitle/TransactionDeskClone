
        <div class="container">
          <div class="content-wrapper">
            <section id="content">
             <?php include "ext-menu.php";?>
              <ol class="breadcrumb">
                 <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li><a href="<?php echo base_url(); ?>books">Books</a></li>
        <li class="active"><?=$book_detail->book_title?></li>
              </ol>
              <div class="clearfix"></div>
                  <div class="panel panel-default flat" id="main-height">
                <div class="panel-body">
                  <h3 class="text-uppercase panel-title"><?=$book_detail->speciality?></h3>
                  <hr>
                 <article class="book-details">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                            <img src="<?=base_url()?>assets/front/images/book-img.jpg">
                        </div>
                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                            <table class="" width="100%">
                                <tbody>
                                    <tr>
                                        <td class="text-left" width="60%">
                                            <p><b>doi : </b> <?=$book_detail->doi?> </p>
                                            <h4><?=$book_detail->sub_title?></h4>
                                            <p><?=$book_detail->author?></p>
                                        </td>
                                        <td class="text-right" width="40%">
                                            <h3>$<?=number_format($book_detail->price,2)?></h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" width="40%">
                                        </td>
                                        <td class="text-right" width="60%">
                                            <table class="table table-list ">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h3>Subtotal:</h3></td>
                                                        <td>
                                                            <h3> $<?=number_format($book_detail->price,2)?></h3></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td class="text-right"><b>Taxes May Be Applicable</b>
                                            <br> You will be able to confirm the cost and purchase before you process your order
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix">
                        <p></p>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <form method="post" name="customerData" action="<?=base_url()?>ccpay/CUSTOM_CHECKOUT_FORM_KIT/ccavRequestHandler.php" id="paypal1">
    
      
        
        <input type="hidden" name="tid" id="tid" readonly />
        <input type="hidden" name="merchant_id" value="59422"/>
        <input type="hidden" name="order_id" value="123654789"/>
        <input type="hidden" id="paypal_amount"name="amount" value="<?=number_format($book_detail->price,2)?>"/>
        <input type="hidden" name="currency" value="INR"/>
        <input type="hidden" name="redirect_url" id="redirect_url" value="http://myreposit.com/index.php/user/activate_article"/>
        <input type="hidden" name="cancel_url" id="cancel_url" value="http://myreposit.com/index.php/user/activate_article"/>
        
        <input type="hidden" name="language" value="EN"/>
        
          
        </form> 
        <button type="button" class="btn btn-primary pull-right" onclick="get_order_number(<?=$book_detail->bookid?>)">Proceed to Payment</button>
        
                              
                        </div>
                    </div>
                    <div class="clearfix">
                        <p></p>
                    </div>
                    <div class="panel panel-default panel-gray">
                        <div class="panel-body">
                            <h5 class="modal-title"><b>Upon successful Completion of purchase you'll get a mail lettring you know that you can download your article.<br>
                            This link will be active for 24 hours following colpletation of purchase.
                        </b></h5>
                        </div>
                    </div>
                </article>
                </div>
              </div>
              
                
              
            </section>
            <script type="text/javascript">

function get_order_number (bookid) 
{

  var url = '<?php print base_url()?>index.php/welcome/order_book/'+bookid;
  $.ajax({
url     : url,
type    : "POST",
mimeType: "multipart/form-data",
contentType: false,
cache: false,
processData: false,
success : function( data )
{
 
    $("#redirect_url").val('<?php print base_url()?>index.php/user/download_book/'+data);
    $("#cancel_url").val('<?php print base_url()?>index.php/user/download_book/'+data); 
    $("#paypal1").submit();
 
},
error   : function( xhr, err )
{
alert('Error');
return false;
}
});
}

            </script>
