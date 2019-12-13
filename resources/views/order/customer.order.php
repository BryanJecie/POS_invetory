 
<style type="text/css">
  .purchase-no{
    font-size: 25px;
    font-weight: lighter;
  }
  .supplier{
    font-size: 20px;
  }
  .invoiceTable tr td span{
    font-size: 16px;
    color: #00acac
  }
  .status-text label{
    font-size: 12px !important;
  }
  #pay-order-change{
    font-size: 23px;
  }
  #total-amount{
    font-size: 18px;
    font-weight: bold;
  }
</style>

<div class="invoice">
    <div class="invoice-company"></div>
    <div class="note note-info">
      <div class="row">
        <div class="col-md-6">
            <dl>
              <dt>Customer's</dt>
              <dd class="supplier"><?php echo ucwords($data['customers']->custom_firstname.' '.$data['customers']->custom_lastname) ?></strong></dd>
              <dd> <i class="fa fa-phone "></i> <?php echo $data['customers']->custom_phone; ?></dd>
              <dd> <i class="fa fa-envelope-o"></i> <?php echo $data['customers']->custom_email; ?></dd>
              <dd> <i class="fa fa-home"></i> <?php echo $data['customers']->custom_address; ?></dd>
            </dl>
        </div>
         <div class="col-md-6 ">
           <!--  <dl class="pull-right">
              <dt class="purchase-no"><?php ?></dt>
              <dd><h5><?php echo date('M d, Y') ?></h5></dd>
            </dl> -->
            <div class="invoice-date">
                <small>Invoice / <?php echo date('M,') ?> Period</small>
                <div class="date m-t-5"><?php echo date('M d, Y') ?></div>
                <div class="invoice-detail">
                    <!-- #0000123DSS<br> -->
                    Services Product
                </div>
            </div>
        </div> 
      </div>
    </div>
    <div class="invoice-content">
        <div class="row">
            <div class="col-md-10">
                <form class="form-inline" action="<?php echo Url::route('orders/view_invoice_customer_order/'.$data['custId'].'/') ?>" method="get">
                    <label class="text-success">PAYMENT STATUS <span class="text-danger">*</span></label>
                    <br>
                    <div class="form-group">
                        <select name="payment_status" id="payment_status"  class="form-control input-sm" required="" style="width: 180px;">
                          <?php if ($data['stat_opt'] !== ""): ?>
                            <option value="<?php echo $data['stat_opt'] ?>"><?php echo strtoupper($data['stat_opt']) ?></option>
                          <?php else : ?>
                            <option value=""><?php echo ucwords('Choose Payment Status') ?></option>
                          <?php endif ?>
                          <?php $optns = array('paid', 'unpaid', 'all'); ?>
                          <?php foreach ($optns as $opt): ?>
                            <?php if ($opt !== $data['stat_opt']): ?>
                                <option value="<?php echo $opt ?>"><?php echo strtoupper($opt) ?></option>
                            <?php endif ?>
                          <?php endforeach ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                      <i class="fa fa-search"></i> VIEW 
                    </button>
                </form>
            </div>
          
            <div class="col-md-2">
                <span class="pull-right hidden-print">
                     <a href="javascript:;" class="btn btn-sm btn-success" id="print-soa" cval="<?php echo $data['custId'] ?>"><i class="fa fa-print m-r-2"></i> STATEMENT OF ACCOUNT</a>
                </span>
            </div>
        </div>
        
        <hr>
        <div class="table-responsive">
          
            <h4><i class="fa fa-list"></i> LIST OF ORDERS</h4>
            <?php $totalBill = 0; $grandTotal = 0; $gDiscount = 0; $totalPayable = 0; $totalPaid = 0; ?>
            <?php if (!empty($data['customOrders'])): ?>
                <?php foreach ($data['customOrders'] as $orders): ?>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th class="no text-right">ORDER NO :  <b class="text-info"><?php echo $orders->order_no ?></b></th>
                                <th class="desc">INVOICE DATE : <b><?php echo date('M. j, Y  ', strtotime( $orders->order_date )) ?> </b></th>
                                <th class="desc">ORDER STATUS : 
                                    <label class="label label-<?php echo  ($orders->order_status === 'confirm') ? 'success' : 'danger'?>">
                                        <?php echo  strtoupper($orders->order_status) ?> 
                                    </label>
                                </th>
                                <th class="desc">PAYMENT STATUS  :
                                    <label class="label label-<?php echo  ($orders->order_payment_status === 'paid') ? 'success' : 'danger'?>">
                                        <?php echo  strtoupper($orders->order_payment_status) ?> 
                                    </label>
                                </th>
                            </tr>
                        </thead>
                    </table>  
                    
                    <table class="table table-condensed">
                        <thead>
                            <tr style="background-color: #ECECEC">
                                <th>IO#</th>
                                <th align="center">Description</th>
                                <th align="center">Buying Price</th>
                                <th align="center">Qty</th>
                                <th class="pull-right">TOTAL</th>
                            </tr>
                        </thead>
                        <?php 
                            $products = Query::getSql()->query("
                                    SELECT
                                    product.product_name,
                                    product.product_subname,
                                    order_details.details_order_price,
                                    order_details.details_order_quantity,
                                    order_details.details_order_name,
                                    order_details.details_order_type,
                                    IFNULL(order_details.details_order_quantity * order_details.details_order_price, 0) as total
                                    FROM
                                    order_details
                                    INNER JOIN product ON order_details.product_id = product.product_id
                                    WHERE
                                    order_details.details_order_id =  {$orders->order_id}
                                ");

                            if ($products->_count > 0) {
                                
                                $totalOrder        = 0;
                                $totalOrderDisplay = 0;
                                $count = 1;
                                foreach ($products->_result as $orderD) { ?>
                                  <tbody>
                                     <tr>
                                         <td><b><?php echo $count++; ?></b></td>
                                         <td class="text-info"><?php echo ucwords($orderD->product_name .' '. $orderD->product_subname) ?></td>
                                         <td><b><?php echo number_format($orderD->details_order_price,2) ?></b></td>
                                         <td><?php echo $orderD->details_order_quantity ?></td>
                                         <td class="pull-right"><?php echo number_format(($orderD->total) ,2) ?></td>
                                     </tr>
                                  </tbody>                                                
                        <?php } } ?>

                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td><b>TOTAL ORDER</b></td>
                                <td align="right"><b><?php echo number_format( $orders->order_bill,2); ?></b></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><b>TOTAL DISCOUNT</b></td>
                                <td align="right"><b><?php echo number_format( $orders->order_discount,2); ?></b></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td class="bg-info"><b class="text-info">GRAND TOTAL</b></td>
                                <td align="right" class="text-info bg-info">
                                  <b>
                                    <?php
                                      $partialPay = _get_partial_payment($orders->order_id);
                                      if (!is_null($partialPay)) {
                                        $totalPayable = ($orders->totalPayable - $partialPay);
                                      }
                                      else{
                                        $totalPayable = $orders->totalPayable;
                                      }
                                      echo number_format( $orders->totalPayable,2); 
                                    ?>
                                  </b>
                                </td>
                            </tr>
                            <?php if (!is_null($partialPay)): ?>
                              <tr>
                                  <td colspan="3"></td>
                                  <td class="bg-info"><b class="text-success">TOTAL PAID</b></td>
                                  <td align="right" class="text-success bg-info">
                                    <b><?php echo number_format($partialPay,2); ?></b>
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="3"></td>
                                  <td class="bg-info"><b class="text-danger">TOTAL BALANCE</b></td>
                                  <td align="right" class="text-danger bg-info">
                                    <b><?php echo ($totalPayable > 0) ? number_format($totalPayable,2) : number_format(0,2); ?></b>
                                  </td>
                              </tr>
                              <?php $totalPaid += $partialPay; ?>
                            <?php else : ?>
                             <?php $payments = _get_sales_invoice_by_customer( $orders->custom_id );
                                 if (!is_null($payments)) {
                                   foreach ($payments as $payment) { ?>
                                      <tr>
                                          <td colspan="3"></td>
                                          <td class="bg-info"><b class="text-success">TOTAL PAID</b></td>
                                          <td align="right" class="text-success bg-info">
                                            <b><?php echo number_format($payment->invoice_total_amount,2); ?></b>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3"></td>
                                          <td class="bg-info"><b class="text-danger">TOTAL BALANCE</b></td>
                                          <td align="right" class="text-danger bg-info">
                                            <b><?php echo number_format(0,2); ?></b>
                                          </td>
                                      </tr>
                             <?php $totalPaid += $payment->invoice_total_amount; } }  ?>
                            <?php endif ?>
                            <tr>
                                <td colspan="4"></td>
                                <td align="">
                                    <button type="button" data-target="#modal-pay-hist-<?php echo $orders->order_id ?>" data-toggle="modal" class="btn btn-white btn-sm pull-right" style="margin-right: -14px;">
                                        <small><i class="fa fa-search"></i> PAYMENT HISTORY</small>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                   <?php 

                       $grandTotal += $totalPayable;
                       $gDiscount  += $orders->order_discount;
                       $totalBill  += $orders->order_bill;
                   ?>
                <?php endforeach ?>
            <?php else : ?>
                <table class="table table-condensed">
                    <tr class="active">
                        <th ><h5 class="text-info">NO ORDER AVAILABLE !</h5></th>
                    </tr>
                </table>
            <?php endif ?>
        </div>
        
        <?php if (count($data['customOrders']) > 0 AND $data['status'] === 'unpaid'): ?>
            <div class="row">
                <hr>
                <div class="col-md-12">
                   <span class="pull-right hidden-print">
                       <a href="#modal-add-payment" data-toggle="modal" id="test" class="btn btn-sm btn-success">
                         <i class="fa fa-calculator m-r-2"></i> Add Payment
                       </a>
                   </span>
                </div>
            </div>
        <?php else : ?>
        <br>
        <?php endif ?>
        <div class="invoice-price" style="margin-top: 10px;">
          <div class="invoice-price-left">
            <div class="invoice-price-row">
              <div class="sub-price">
                  <small class="text-info">TOTAL ORDER</small>
                  <?php echo number_format($totalBill,2) ?>
              </div>
              <div class="sub-price">
                  <i class="fa fa-minus"></i>
              </div>
              <div class="sub-price">
                  <small class="text-info">TOTAL DISCOUNT (%)</small>
                  <?php echo number_format($gDiscount,2) ?> <span>
                  <?php 
                      if (!empty($discArr)) {
                        echo '('.$discArr[1].'%)';
                      }
                  ?> 
                  </span>
              </div>

              <div class="sub-price">
                  <small class="text-info">TOTAL PAID</small>
                  <?php echo number_format($totalPaid,2) ?> 
              </div>
            </div>
          </div>

          <div class="invoice-price-right">
              <small>
                  <b>GRAND TOTAL
                      <?php if ($data['status'] !== 'all'): ?>
                          <span class="label label-<?php echo ($data['status'] !=='unpaid') ? 'success' : 'danger' ?>">
                              <?php echo strtoupper($data['status']) ?>
                          </span>
                      <?php endif ?>
                  </b>
              </small> 

              <?php
                  if ( $grandTotal  < 1 )
                     $grandTotal = 0;
                     echo number_format(($grandTotal),2) 
              ?> Php

          </div>
        </div>
    </div>
    <div class="invoice-footer text-muted">
        <p class="text-center m-b-5">THANK YOU FOR YOUR BUSINESS</p>
        <p class="text-center">
            <span class="m-r-10"><i class="fa fa-globe"></i> <?php echo company()->comp_name; ?></span>
            <span class="m-r-10"><i class="fa fa-phone"></i>  <?php echo company()->comp_phone; ?></span>
            <span class="m-r-10"><i class="fa fa-envelope"></i> <?php echo company()->comp_email; ?></span>
        </p>
    </div>
</div>


<!-- start modal for view payment history -->
<?php if (!empty($data['customOrders'])): ?>
    <?php foreach ($data['customOrders'] as $orders): ?>
        <div class="modal fade" id="modal-pay-hist-<?php echo $orders->order_id ?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">Payment History</h4>
                    </div>
                    <div class="modal-body">
                        <?php $partials = _sales_partials($orders->order_id); ?>
                        <table class="table table-condensed">
                          <thead>
                            <tr style="background-color: #ECECEC">
                              <th>#PH:</th>
                              <th style="text-align: center;">PAY DATE</th>
                              <th><span class="pull-right">PAY AMOUNT</span></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $payments = _get_sales_invoice_by_customer( $orders->custom_id ); ?>
                            <?php $count = 1; $sumPartial = 0 ?>
                            <?php if (!is_null($partials)): ?>
                              <?php foreach ($partials as $part): ?>
                                <tr>
                                  <td><?php echo $count++; ?></td>
                                  <td align="center"><?php echo date('M. j, Y  ', strtotime( $part->partial_date )) ?></td>
                                  <td><b class="pull-right"><?php echo number_format( $part->partial_amount,2 ) ?></b></td>
                                </tr>
                                <?php $sumPartial += $part->partial_amount ?>
                              <?php endforeach ?>
                              <tr class="">
                                <td>&nbsp;</td>
                                <td align="right" class="text-info"><b>TOTAL PAID</b></td>
                                <td> <b class="pull-right text-info"><?php echo number_format($sumPartial, 2) ?></b></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="right"><b>STATUS</b></td>
                                <td>
                                  <label class="pull-right label label-<?php echo ( $orders->order_payment_status == 'paid') ? 'success' : 'danger' ?>">
                                    <?php echo strtoupper($orders->order_payment_status)?>
                                  </label>
                                </td>
                              </tr>
                            <?php elseif (!is_null($payments)): ?>
                              <?php $sumPayment = 0; ?>
                              <?php foreach ($payments as $payment): ?>
                                <tr>
                                  <td><?php echo $count++; ?></td>
                                  <td align="center"><?php echo date('M. j, Y  ', strtotime( $payment->invoice_date )) ?></td>
                                  <td><b class="pull-right"><?php echo number_format( $payment->invoice_total_amount,2 ) ?></b></td>
                                </tr>
                                <?php $sumPayment += $payment->invoice_total_amount ?>
                              <?php endforeach ?>
                                <tr class="">
                                  <td>&nbsp;</td>
                                  <td align="right" class="text-info"><b>TOTAL PAID</b></td>
                                  <td> <b class="pull-right text-info"><?php echo number_format($sumPayment, 2) ?></b></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="right"><b>STATUS</b></td>
                                  <td>
                                    <label class="pull-right label label-<?php echo ( $orders->order_payment_status == 'paid') ? 'success' : 'danger' ?>">
                                      <?php echo strtoupper($orders->order_payment_status)?>
                                    </label>
                                  </td>
                                </tr>
                            <?php else : ?>
                              <tr class="active">
                                <td colspan="3">NO PAYMENT AVAILABLE</td>
                              </tr>
                            <?php endif ?>
                          </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white btn-sm" data-dismiss="modal"><i class="fa fa-like"></i> OK</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <?php endforeach ?>
<?php endif ?>
<!-- end modal for view payment history -->

<!-- modal for payment -->
<div class="modal" id="modal-add-payment" data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close text-danger" data-dismiss="modal" aria-hidden="false">
                  <i class="fa fa-times-circle-o" style="z-index: 99999;"></i>
                </button>
                <h4 class="modal-title" style="font-size: 14px; color: #fff">
                    <i class="fa fa-calculator"></i> 
                    PAYMENT FORM
                </h4>

            </div>
            <div class="modal-body">
               <form action="<?php echo Url::route('orders/view_invoice_customer_order/'.$data['custId']).'/?payment_status=unpaid' ?>" method="POST" data-parsley-validate="true">
                   <fieldset class="form-group">
                      <label for="formGroupExampleInput">
                         <input type="hidden" name="gTotalOrder" id="gTotalOrder" value="<?php echo ($grandTotal) ?>">
                          TOTAL :
                          <span id="total-amount" class="text-info"><?php echo number_format(($grandTotal),2)  ?> </span> <small>PHP</small>
                      </label>
                   </fieldset>
                   <fieldset class="form-group">
                       <label for="formGroupExampleInput">Payment Type :</label>
                       <select name="pay-type" id="pay-type" class="form-control" required="">
                           <option value="">Choose Payment Type</option>
                           <option value="cash">Cash</option>
                           <option value="cheque">Cheque</option>
                       </select>
                   </fieldset>
                   <span class="div-cheque-no"></span>
                   <fieldset class="form-group">
                       <label for="pay-amount">Input Amount :</label>
                       <input type="text" autocomplete="off" name="pay-amount" class="form-control" id="pay-amount" style="font-size: 14px;" placeholder="0.00" required="">
                   </fieldset>
                   <fieldset class="form-group">
                        <h4>CHANGE : <span id="pay-order-change" class="text-danger" style="font-weight: bold; font-size: 20px">0.00</span></h4>
                   </fieldset>
                   <fieldset class="form-group">
                       <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                       <button type="submit" class="btn btn-success pull-right" style="width: 100px;"><small>PAY</small></button>
                   </fieldset>
               </form>
            </div>
          
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 

<script>

  $(function() {
    var doc = $(document);

    doc.on('change', '#pay-type', function(){
        var $this  = $(this);
        var parent = $this.parent();

        if ($this.val() === 'cheque') 
        {
            parent.siblings('.div-cheque-no').append(chequeNoHolder());
        }
        else
        {
           parent.siblings('.div-cheque-no').html("");
        }
    });

    doc.on('keyup', '#pay-amount', function(){
      var $this   = $(this);
      var pTotal  = $('#gTotalOrder').val();
      var pAmount = $this.val();
      $('#pay-order-change').html("");
      var total   =  (pAmount - pTotal);
      if (total > 0 ) {
        $('#pay-order-change').append(total.toFixed(2));
      }
      else{
        $('#pay-order-change').text("0.00");
      }
    });

    doc.on('click', '#print-soa' ,function(){
      var status = $('#payment_status').val();
      window.open("<?php echo  Url::route('print_/soe/'.$data['custId'].'/')  ?>" + status , "_blank");
    });

    // setTimeout(function(){$('#test').trigger('click');}, 100);
  });

  function chequeNoHolder() {
    return '<fieldset class="form-group">'+
           ' <label for="formGroupExampleInput">Input Cheque No. :</label>'+
           ' <input type="text" name="cheque-no" class="form-control" id="formGroupExampleInput" style="font-size: 14px;" placeholder="0.00">'+
           '</fieldset>';
  }

</script>