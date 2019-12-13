 
<style type="text/css">
  .purchase-no{
    font-size: 25px;
    font-weight: lighter;
  }
  .supplier{
    font-size: 20px;
  }
  .invoiceTable tr td{
    /*height: 30px;*/
    /*font-weight: bold;*/
  }
  .invoiceTable tr td span{
    font-size: 14px;
    /*color: #00acac*/
  }
  .status-text span{
    /*font-size: 13px;*/
    /*font-weight: bold;*/
  }
  .status-text label{
    font-size: 12px !important;
  }
  .ui-autocomplete { z-index:2147483647; }
</style>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" data-original-title="" title=""><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse" data-original-title="" title=""><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Order Details1</h4>
    </div>
    <div class="panel-body">

      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php if (Session::hasFlash()): ?>
                <div class="alert alert-success alert-dismissable fade-msg">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <b><i class="fa fa-check"></i></b>
                    <?php echo ucwords(Session::flash()) ?>
                </div>
            <?php endif ?>
            <div class="btn-group pull-left">
              <?php if (!empty($data['ord_details'])): ?>
                <?php foreach ($data['ord_details'] as $ordD): ?>
                    <?php if ($ordD->order_payment_status === 'unpaid' AND $ordD->order_status === 'confirm'): ?>
                      <a href="#add-payment-modal" id="addPayment" class="btn btn-sm btn-success" data-toggle="modal">
                        <i class="fa fa-money"></i> <small>ADD PAYMENT</small>
                      </a>
                    <?php endif ?>
                <?php endforeach ?>
              <?php endif ?>
            </div>
            <div class="btn-group pull-right">
              <button class="btn btn-info btn-sm " id="printOrder"><i class="fa fa-print "></i> <small>PRINT</small></button>
              <!-- <button class="btn btn-white text-danger"><i class="fa fa-envelope-o"></i> <small>EMAIL</small></button> -->
            </div>
        </div>
      </div>
      <?php $count = 1; $oTotal = 0; $gTotal = 0; $ordDetails =array() ?>

      <?php $orderId = 0;  $status =""; $percent = 0; $payStatus; $gtotal = 0; $paidAmnt = 0; $paidDate = null; $bTotal = 0; $discount = 0; ?>
      <?php if (!is_null($data['ord_details']) AND is_array($data['ord_details'])): ?>
          <?php foreach ($data['ord_details'] as $order): ?>
              <?php  
                $orderId   = $order->order_id; 
                $status    = $order->order_status; 
                $payStatus = $order->order_payment_status; 
                $gtotal    = $order->order_bill; 
                $paidAmnt  = $order->order_pay_amount;
                $paidDate  = $order->order_pay_date;
                $discount  = $order->order_discount;
              ?>
              <?php $percent = $order->custom_discount; ?>
              <div class="row" style="margin-top: 6px;">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <div class="note note-info">
                    <div class="row">
                      <div class="col-md-6">
                          <dl>
                            <dt>Customer's</dt>
                            <dd class="supplier"><?php echo ucwords($order->custom_firstname.' '. $order->custom_lastname); ?></dd>
                            <dd> <i class="fa fa-phone "></i> <?php echo $order->custom_phone; ?></dd>
                            <dd> <i class="fa fa-envelope-o"></i> <?php echo $order->custom_email; ?></dd>
                            <dd> <i class="fa fa-home"></i> <?php echo $order->custom_address; ?></dd>
                          </dl>
                      </div>
                      <div class="col-md-6 ">
                          <dl class="pull-right">
                            <dt class="purchase-no"><?php echo $order->order_no; ?></dt>
                            <dd>Date of invoice: <b><?php echo $order->order_date; ?></b></dd>
                            <dd>Purchased by: <b><?php echo ucwords($order->person_first.' '.$order->person_last); ?></b></dd>
                            <dd>Status: <b class="label label-<?php echo ($order->order_status == 'confirm') ? 'success' : 'danger' ?>">
                                <?php echo strtoupper($order->order_status); ?> ORDER</b>
                            </dd>
                          </dl>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          
              <br>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <?php if (!empty($data['ord_details'])): ?>
                    <?php foreach ($data['ord_details'] as $ordD): ?>
                        <?php if ($ordD->order_status !== 'confirm'): ?>
                          <button type="button" data-toggle="modal" data-target="#modal-add-order" class="btn btn-primary btn-sm pull-right" id="btn-add-order">
                            <i class="fa fa-plus"></i> ORDER
                          </button>
                          <hr>
                        <?php endif ?>
                    <?php endforeach ?>
                  <?php endif ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <table class="table table-striped ">
                      <thead class="bg-silver-lighter">
                          <tr class="bg-info">
                              <th>#SL</th>
                              <th>DESCRIPTION</th>
                              <th>UNIT PRICE</th>
                              <th>QUANTITY</th>
                              <th><span class="pull-right">TOTAL</span></th>
                              <?php if ($order->order_status !== 'confirm'): ?>
                               <th><small class="pull-right">ACTION</small></th>
                              <?php endif ?>

                          </tr>
                      </thead>
                      <tbody class="bg-silver-lighter">
                        <?php 
                          $colspan = 3;
                          $ordDetails = Query::getSql()->query("
                                SELECT
                                product.product_name,
                                product.product_subname,
                                order_details.details_order_quantity,
                                IFNULL((details_order_quantity * details_order_price ),0) as totalOrd,
                                order_details.details_order_price,
                                order_details.details_order_type,
                                order_details.details_id
                                FROM
                                order_details
                                INNER JOIN product ON order_details.product_id = product.product_id
                                WHERE
                                order_details.details_order_id = {$order->order_id}
                            ");
                        ?>

                        <?php if ($ordDetails->_count > 0): ?>
                          <?php foreach ($ordDetails->_result as $ordDet): ?>
                            <tr>
                              <td><?php echo $count++; ?></td>
                              <td class="text-info"><?php echo ucwords($ordDet->product_name.' '.$ordDet->product_subname); ?></td>
                              <td><?php echo number_format($ordDet->details_order_price,2); ?></td>
                              <td align="center">
                                <?php if ($order->order_status === 'confirm'): ?>
                                  <?php echo $ordDet->details_order_quantity; ?>
                                <?php else : ?>
                                  <input type="text" class="form-control pending-order-qty" qval="<?php echo $ordDet->details_id ?>" name="order-qty" style="width:60px;text-align: right; height: 25px;" value="<?php echo $ordDet->details_order_quantity; ?>">
                                <?php endif ?>
                              </td>
                              <td align="right"><b><?php echo number_format($ordDet->totalOrd,2) ?></b></td>
                              <?php if ($order->order_status !== 'confirm'): ?>
                                <td align="right">
                                  <button type="button" data-toggle="modal" data-target="#modal-delete-<?php echo $ordDet->details_id ?>" class="btn btn-danger btn-xs" id="btn-delete-order" >
                                    <i class="fa fa-trash" data-toggle="tooltip" title="Delete Order?" data-placement="right" ></i>
                                  </button>
                                </td>
                                <?php $colspan = 4 ?>
                              <?php endif ?>
                            </tr>
                            <?php $oTotal += $ordDet->totalOrd ?>
                          <?php endforeach ?>
                        <?php endif ?>
                        <?php 
                          $gTotal = ($oTotal - $discount);
                        ?>
                      </tbody>
                      <tfoot class="invoiceTable">
                        <tr>
                          <td colspan="<?php echo $colspan ?>"> </td>
                          <td colspan="1"><span class="text-inverse">TOTAL ORDER</span></td>
                          <td align="right"><span><b><?php echo number_format($oTotal,2) ?></b></span></td>
                        </tr>
                        <tr>
                          <td colspan="<?php echo $colspan ?>"> </td>
                          <td colspan="1"><span class="text-inverse">TOTAL DISCOUNT</span></td>
                          <td align="right"><span><b><?php echo number_format($discount,2) ?></b></span></td>
                        </tr>
                        <tr>
                          <td colspan="<?php echo $colspan ?>"> </td>
                          <td colspan="1"><span class="text-info"><b>GRAND TOTAL ORDER</b></span></td>
                          <td align="right"><span class="text-info"><b><?php echo number_format($gTotal,2) ?></b></span></td>
                        </tr>
                        <tr>
                          <td colspan="7">&nbsp;</td>
                        </tr>
                        <?php $displayTotal = $gTotal; ?>
                        <?php if (!empty($data['partialPay'])): ?>
                          <?php $paySum = 0; ?>
                          <tr >
                            <td colspan="3"> </td>
                            <td colspan="2" class="active"><h4><b class="text-info">PAYMENT HISTORY</b></h4></td>
                          </tr>
                          <?php foreach ($data['partialPay'] as $pay): ?>
                            <tr>
                              <td colspan="3"></td>
                              <td colspan="1" class="active text-success" style="font-size: 14px;" >PAID AMOUNT : </td>
                              <td align="right" class="active text-success"><b style="font-size: 14px;" ><?php echo number_format($pay->partial_amount,2); ?></b></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                              <td colspan="1" class="active text-success" style="font-size: 14px;" >PAID DATE : </td>
                              <td align="right" class="active text-success"><b style="font-size: 14px;" ><?php echo date('F j, Y', strtotime($pay->partial_date)); ?></b></td>
                            </tr>
                            <?php $paySum += $pay->partial_amount ?>
                          <?php endforeach ?>
                            <?php $displayTotal = ($gTotal - $paySum); ?>
                            <tr>
                              <td colspan="3"> </td>
                              <td colspan="1" class="active text-danger" style="font-size: 14px;" >BALANCES : </td>
                              <td align="right" class="active"><b style="font-size: 18px;" class="text-danger"><?php echo number_format($displayTotal, 2); ?></b></td>
                            </tr>
                        <?php else : ?>
                          <?php $bTotal = $gtotal; ?>
                        <?php endif ?>
                      </tfoot>
                  </table>

                  <?php 
                    if ($status == 'pending') {?>
                      <p class="pull-right">
                        <a href="<?php echo Url::route('orders/view_invoice_order/?ordId='.$orderId.'=action=cancel') ?>" class="btn btn-danger btn-sm">
                          <i class="fa fa-times-circle-o"></i> Cancel
                        </a>
                        <a href="<?php echo Url::route('orders/view_invoice_order/?ordId='.$orderId.'=action=confirm') ?>" class="btn btn-success btn-sm">
                          <i class="fa fa-check"></i>  Confirm
                        </a>
                      </p>
                  <?php }
                    else {?>
                      <p class="status-text pull-right">
                        <span>Invoice Status</span> : 
                        <label class="label label-<?php echo($payStatus == 'unpaid') ? 'danger' : 'success' ; ?>">
                          <?php echo ucwords($payStatus) ?>
                        </label>
                        <label>&nbsp;</label>
                      </p>
                  <?php } ?>
                </div>
                <div class="col-md-1"></div>
              </div>

          <?php endforeach ?>
      <?php endif ?>

    </div>
</div>



                          



<?php if ($ordDetails->_count > 0): ?>
  <?php foreach ($ordDetails->_result as $ordDet): ?>
     <div class="modal fade" id="modal-delete-<?php echo $ordDet->details_id ?>">
       <div class="modal-dialog modal-sm" role="document">
         <div class="modal-content">
           <div class="modal-header bg-red">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               <span class="sr-only">Close</span>
             </button>
             <h5 class="modal-title"><i class="fa fa-trash"></i> Delete</h5>
           </div>
           <div class="modal-body">
             <form action="javascript:;" method="POST" class="form-delete-order">
               <center>
                 <input type="hidden" value="<?php echo $ordDet->details_id ?>" id="detId">
                 <h5><?php echo strtoupper('Are you sure to delete this item?') ?></h5>
                 <h4 class="text-info"><?php echo ucwords($ordDet->product_name.' '.$ordDet->product_subname); ?></h4>
                 <br>
                 <br>
                 <button type="submit" class="btn btn-warning btn-sm" style="width: 150px;">YES</button>
               </center>
             </form>
           </div>
         <!--   <div class="modal-footer">
             <button type="button" class="btn btn-warning btn-sm">YES</button>
           </div> -->
         </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
     </div><!-- /.modal -->
    <?php // $oTotal += $ordDet->totalOrd ?>
  <?php endforeach ?>
<?php endif ?>




<div class="modal fade" data-backdrop="static" id="modal-add-order">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content ">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-danger"><i class="fa fa-times-circle-o"></i></span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title text-info"><i class="fa fa-plus"></i>ADDITIONAL ORDER</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo Url::route('orders/post_add_order/?ordId='.$orderId.'') ?>" method="POST" data-parsley-validate="true">
          <fieldset class="form-group">
            <label for="barcode">BARCODE/PRODUCT NAME <span class="text-danger">*</span></label>
            <input type="text" name="barcode" class="form-control" id="barcode" placeholder="Required" required>
          </fieldset>
          <fieldset class="form-group">
            <label for="quantity">QUANTITY <span class="text-danger">*</span></label>
            <input type="text" name="quantity" class="form-control" id="quantity" autocomplete="off" placeholder="Required" required>
          </fieldset>
          <fieldset class="form-group">
            <label for="formGroupExampleInput2">&nbsp;</label>
            <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
            <button type="submit" class="btn btn-success pull-right btn-sm" style="width: 30%">ADD</button>
          </fieldset>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


   


 <div class="modal" data-backdrop="static" id="add-payment-modal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="panel panel-info" data-sortable-id="form-stuff-3">
          <div class="panel-heading">
            <div class="panel-heading-btn">
              <button type="button" class="close text-danger" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times-circle-o" style="z-index: 99999;"></i>
              </button>
            </div>
            <h4 class="panel-title">
              <i class="fa fa-calculator"></i>
              PAYMENT FORM
            </h4>
          </div>
            <div class="panel-body">
              <form action="<?php echo Url::route('orders/view_invoice_order/?ordId=').$data['orderId'].'=stat=paid' ?>" method="POST" data-parsley-validate="true">
                 <fieldset>
                     <input type="hidden" name="pTotal" id="pTotal" value="<?php echo $displayTotal ?>">
                     <input type="hidden" name="dTotal" id="dTotal" value="<?php echo $discount ?>">
                     <legend>TOTAL : <span><b class="text-info"><?php echo  number_format($displayTotal,2); ?></b></span><small> Php</small></legend>
                     <div class="form-group">
                         <label for="pType">Payment Type <span class="text-danger">*</span></label>
                         <select class="form-control" id="pType" name="pType" data-parsley-required="true">
                           <option value="">Choose Payment</option>
                           <option value="cash">Cash</option>
                           <option value="cheque">Cheque</option>
                         </select>
                     </div>
                     <div class="form-group div-cheque">
                         
                     </div>
                     <div class="form-group">
                         <label for="pAmount">Input Amount <span class="text-danger">*</span></label>
                         <input type="text" class="form-control" id="pAmount" name="pAmount" placeholder="0.00" data-parsley-required="true" autocomplete="off">
                     </div>
                     <br>
                     <div class="form-group">
                        <h4>CHANGE : <span id="pChange" class="text-danger" style="font-weight: bold; font-size: 20px">0.00</span></h4>
                     </div>
                     <br>
                       <button type="submit" class="btn btn-sm btn-success m-r-5 pull-right" style="width: 100px;">PAY</button>
                 </fieldset>
              </form>
            </div>
        </div>
      </div>
    </div>
 </div>


 <script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
 <script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
 <script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>

 <script>
   jQuery(document).ready(function($) {
      var domainName = window.location.href;
      var doc        = $(document);


      doc.on('click' , '#printOrder', function(){
        var $this = $(this);
        var currentUrl = domainName.split("=");
        var orderId = currentUrl[1];
        
        window.open("<?php echo Url::route('print_/order/') ?>" + "?orderId=" + orderId );
      });

      doc.on('keyup', '#pAmount', function(){
        var $this   = $(this);
        var pTotal  = $('#pTotal').val();
        var pAmount = $this.val();
        $('#pChange').html("");
        var total   =  (pAmount - pTotal);
        if (total > 0 ) {
          $('#pChange').append(total.toFixed(2));
        }
        else{
          $('#pChange').text("0.00");
        }
      });
      
      doc.on('focusout', '.pending-order-qty', function(){
        var $this  = $(this);
        var qVal   = $(this).val();
        var detId  = $(this).attr('qval');

        $.ajax({
          url: "<?php echo Url::route('ajax/get_qty_details') ?>",
          type: 'POST',
          dataType: 'JSON',
          data: { qVal : qVal , detId : detId },
        })
        .done(function(data) {
          if (data.key === true) {
            location.reload()
          }
        });
      });

      doc.on('submit', '.form-delete-order', function(e){
        e.preventDefault();
        var detId  = $('#detId').val();
        
        $.post("<?php echo Url::route('ajax/set_delete_order') ?>", { detId : detId }, function(data) {
             if (data.key === true) {
               location.reload();
             }
        },'JSON'); 

        $('[data-toggle="tooltip"]').tooltip();        
      });

      doc.on('change', '#pType', function(){
        var $this  = $(this);
        var parent = $this.parent();

          if ($this.val() === 'cheque') 
          {
            parent.siblings('.div-cheque').append(chequeNoHolder());
          }
          else
          {
            parent.siblings('.div-cheque').html("");
          }
      });


       doc.on('click' , '#btn-add-order', function(){
         setTimeout(function(){
          setBarcodes();
        },100);
      });
      
      setBarcodes();
      function setBarcodes() {
        $.ajax({
          url: "<?php echo Url::route('product/loadBarcodes') ?>",
          type: 'POST',
          dataType: 'JSON',
          data: { key : true , pName : 'get'},
        })
        .done(function(data) {
          console.log(data)
          $("#barcode").autocomplete({
            source : data.list,
            // select : function (event, ui) {
            //    }
          });
        });
      }



      // $('#btn-add-order').trigger('click');
   });

   function chequeNoHolder() {
     return '<label for="pAmount">Enter Cheque No. <span class="text-danger">*</span></label>'+
            '<input type="text" class="form-control" id="pChequeNo" name="pChequeNo" placeholder="Required" data-parsley-required="true">';
   }
 </script>