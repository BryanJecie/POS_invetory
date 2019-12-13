 
<style type="text/css">
  .purchase-no{
    font-size: 25px;
    font-weight: lighter;
  }
  .supplier{
    font-size: 20px;
  }
  .invoiceTable tr td{
    height: 30px;
    font-weight: bold;
  }
  .invoiceTable tr td span{
    font-size: 16px;
    color: #00acac
  }
  .status-text span{
    font-size: 13px;
    font-weight: bold;
  }
  .status-text label{
    font-size: 12px !important;
  }
</style>

<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" data-original-title="" title=""><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse" data-original-title="" title=""><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Inovice Details</h4>
    </div>

    <div class="panel-body">
      <?php $purId = 0;  $status =""; $percent = 0; $payStatus; $gtotal = 0; $paidAmnt = 0; $paidDate = null; $bTotal = 0; ?>
      <?php if (!is_null($data['gPurchased']) AND is_array($data['gPurchased'])): ?>
          <?php foreach ($data['gPurchased'] as $order): ?>
              <?php  
                $purId     = $order->pur_id; 
                $status    = $order->purchase_payment_status; 
                $payStatus = $order->purchase_payment_type; 
                $pReferece = $order->purchase_reference; 
                $TotalAmnt = $order->purchase_total_amount;
                $purDate   = $order->purchase_date;
              ?>
              <div class="row" style="margin-top: 6px;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <?php if (Session::hasFlash()): ?>
                    <div class="alert alert-success fade in m-b-15 fade-msg">
                      <strong>Success!</strong>
                        <?php echo Session::flash() ?>
                      <span class="close" data-dismiss="alert">×</span>
                    </div>
                  <?php endif ?>
                  <div class="btn-group pull-right">
                    <button class="btn btn-info btn-sm " id="printPurchased"><i class="fa fa-print "></i> <small>PRINT</small></button>
                    <!-- <button class="btn btn-white text-danger"><i class="fa fa-envelope-o"></i> <small>EMAIL</small></button> -->
                  </div>
                  <br>
                  <br>
                  <div class="note note-info">
                    <div class="row">
                      <div class="col-md-6">
                          <dl>
                            <dt style="font-size: 16px;"> Supplier's </dt>
                            <dd class="supplier"><?php echo ucwords($order->supplier_company_name); ?></dd>
                            <dd> <i class="fa fa-phone "></i> <?php echo $order->supplier_phone_no; ?></dd>
                            <dd> <i class="fa fa-envelope-o"></i> <?php echo $order->supplier_email; ?></dd>
                            <dd> <i class="fa fa-home"></i> <?php echo $order->supplier_address; ?></dd>
                          </dl>
                      </div>
                      <div class="col-md-6 ">
                          <dl class="pull-right">
                            <dt class="purchase-no"><?php echo $order->purchase_no; ?></dt>
                            <dd>Date of invoice: <b><?php echo $purDate; ?></b></dd>
                            <dd>Purchased by: <b><?php echo ucwords($order->person_first.' '.$order->person_last); ?></b></dd>
                            <dd>Purchased Reference: <b><?php echo ucwords($order->purchase_reference); ?></b></dd>
                            <dd>Payment Method: <b><?php echo ucwords($order->purchase_payment_type); ?></b></dd>
                            <dd>Status:
                               <b class="label label-<?php echo ($order->purchase_payment_status === 'unpaid') ? 'danger' : 'success' ?>">
                                <?php echo strtoupper($order->purchase_payment_status); ?>  
                               </b>
                            </dd>
                          </dl>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <table class="table table-striped ">
                      <thead class="bg-silver-lighter">
                          <tr>
                              <th>#</th>
                              <th>DESCRIPTION</th>
                              <th>UNIT PRICE</th>
                              <th style="text-align: ">QUANTITY</th>
                              <th><span class="pull-right">TOTAL</span></th>
                          </tr>
                      </thead>
                      <tbody class="bg-silver-lighter">
                          <?php $count = 1; $sumTotal = 0; ?>
                          <?php if (!empty($data['gPurchased']) AND is_array($data['gPurchased'])): ?>
                              <?php foreach ($data['gPurchased'] as $purc): ?>



                                <?php 
                                  $pDetails = DB::table("
                                              purchased_details
                                              LEFT JOIN product 
                                              ON purchased_details.product_id = product.product_id
                                              ")
                                            ->where(['purchased_details.pur_id', '=', $purId])
                                            ->all();
                                  $total = 0;
                                  if (!empty($pDetails)) {
                                    foreach ($pDetails as $details) {
                                      $total = $details->pur_det_quantity * $details->pur_der_price; 
                                      $pName = '';
                                      if (!is_null($details->product_id) AND  $details->product_id !== "")  
                                         $pName = $details->product_name;
                                      else 
                                         $pName = $details->pur_det_name;
                                ?>
                                      <tr class="odd gradeX">
                                          <td><?php echo $count++; ?></td>
                                          <td class="text-info"><?php echo ucwords($pName); ?></td>
                                          <td><?php echo number_format($details->pur_der_price, 2) ?></td>
                                          <td align=""><?php echo $details->pur_det_quantity .' '.$details->pur_det_type ?></td>
                                          <td align="right"><b><?php echo number_format($total,2) ?></b></td>
                                      </tr>  
                              <?php } } ?>
                                
                              <?php //$sumTotal = $total+= $sumTotal;?>
                              <?php endforeach ?>
                          <?php endif ?>

                      </tbody>
                      <tfoot class="invoiceTable">
                        <tr>
                          <td colspan="3"> </td>
                          <td colspan="1"><span>GRAND TOTAL</span></td>
                          <td align="right"><span><?php echo number_format($purc->purchase_total_amount,2) ?></span></td>
                        </tr>
                        <tr>
                          <td colspan="5">&nbsp;</td>
                        </tr>
                        <?php $pay_purchase = DB::table('payment_purchased')->where(['pur_id', '=', $purId])->all();

                          if (!empty($pay_purchase)) {
                             foreach ($pay_purchase as $pPur) { ?>
                               <tr>
                                 <td colspan="3"> </td>
                                 <td colspan="1"><span class="text-inverse">AMOUNT PAID</span></td>
                                 <td align="right"><span class="text-inverse"><?php echo number_format($pPur->pay_amount,2) ?></span></td>
                               </tr>
                               <tr>
                                 <td colspan="3"> </td>
                                 <td colspan="1"><span class="text-inverse">DATE PAID</span></td>
                                 <td align="right"><span class="text-inverse"><?php echo date('F j, Y', strtotime($pPur->pay_pur_date)); ?> </span></td>
                               </tr>
                               <tr>
                                 <td colspan="5">&nbsp;</td>
                               </tr> 
                        <?php } } ?>

                      </tfoot>
                  </table>
                  <?php if ($status === "unpaid"): ?>
                    <p class="status-text pull-right">
                      <a href="#add-payment-modal" data-toggle="modal" class="btn btn-primary btn-sm" style="width: 100px;">PAY INVOICE</a> 
                      <label>&nbsp;</label>
                    </p>
                  <?php else : ?>
                    <p class="status-text pull-right">
                      <span>Invoice Status</span> : 
                      <label class="label label-success">
                        <?php echo ucwords($status) ?>
                      </label>
                      <label>&nbsp;</label>
                    </p>
                  <?php endif ?>
                </div>
                <div class="col-md-2"></div>
              </div>
          <?php endforeach ?>
      <?php endif ?>
    </div>
</div>
 



 <div class="modal fade" id="add-payment-modal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="panel panel-info" data-sortable-id="form-stuff-3">
          <div class="panel-heading">
            <div class="panel-heading-btn">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <small class="text-danger" style="z-index: 99; color:red">x</small>
              </button>
            </div>
            <h4 class="panel-title">
              <i class="fa fa-money"></i>
              Invoice Status
            </h4>
          </div>
            <div class="panel-body">
              <form action="<?php echo Url::route('supplier/view_manage_invoice/').$purId ?>" method="POST" data-parsley-validate="true">
                   <center>
                       <h3>
                        Invoice Paid
                        <p>
                          <small>
                           Are You Sure?
                          </small>
                        </p>
                       </h3>
                       <br>
                       <!-- <p class="pull-right"> -->
                         <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button> -->
                         <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                         <button type="submit" class="btn btn-success btn-lg" style="width: 150px;">
                          Paid
                         </button>
                       <!-- </p> -->
                   </center>
              </form>
            </div>
        </div>
      </div>
    </div>
 </div>

 <script>
   jQuery(document).ready(function($) {
      var domainName = window.location.href;
      var doc = $(document);

      // $('#addPayment').trigger('click');
      doc.on('click' , '#printPurchased', function(){
        var $this = $(this);
        var currentUrl = domainName.split("/");
        var orderId    = currentUrl[6];
          // alert(orderId);
        window.open("<?php echo Url::route('print_/supplier_purchased/') ?>" + "?purId=" + orderId );
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
          $('#pChange').html("");
        }

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


   });

   function chequeNoHolder() {
     return '<label for="pAmount">Enter Cheque No. <span class="text-danger">*</span></label>'+
            '<input type="text" class="form-control" id="pChequeNo" name="pChequeNo" placeholder="Required" data-parsley-required="true">';
   }
 </script>