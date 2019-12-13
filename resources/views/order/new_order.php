<style type="text/css">
    .btn-cat-action button{
        margin-left: 2px !important;
    }
    .table-order tr th{
      font-size: 12px;
      font-weight: bold;
    } 
    .table-order tr td{

      font-size: 12px;
    }
    .table-order tr td span{
      font-size: 12px;
      line-height: 25px !important;
      font-weight: bold;
    }
    .table-order tr td .order-input{
      width: 60px;
      margin-top: -2px
    }
    .table-order tr td .order-input-price{
      width: 100px;
    }
    .table-purchased tr th{
      font-size: 10px;
    }
    .table-purchased tr td{
      font-size: 12px;
    }
    .table-purchased tr td input{
      height: 25px;
    }
    .label-total{
      font-size: 14px;
      font-weight: bold;
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
        <h4 class="panel-title">Purchase Order</h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-success" style="border:1px solid #ccc">
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" menu1="#tab1">Product List</a></li>
                  </ul>
                  <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active" >
                        <table id="category-list-table" class="table table-striped table-order"> 
                            <thead style="background-color:#ececec">
                                <tr>
                                    <th>SL#</th>
                                    <th>Barcode</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th align="right">Purchase</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if (!is_null($data['products']) AND is_array($data['products'])): ?>
                                  <?php $count = 1 ?>
                                  <?php foreach ($data['products'] as $product): ?>
                                      <?php 
                                        $class_label = '';
                                        if ($product->stockin_sum_selling_quantity < 10 AND $product->stockin_sum_selling_quantity >! 10) {
                                          $class_label = 'warning';
                                        } elseif($product->stockin_sum_selling_quantity < 1){
                                          $class_label = 'danger';
                                        } else {
                                          $class_label = 'primary';
                                        }
                                      ?>
                                      <tr class="odd gradeX">
                                          <td><?php echo $count++; ?></td>
                                          <td class="text-primary"><?php echo $product->barcode ?></td>
                                          <td style="width: 300px !important;"><?php echo ucwords($product->product_name) ?></td>
                                          <td>  
                                              <label class="label label-<?php echo $class_label ;?>">
                                                <?php echo $product->stockin_sum_selling_quantity.' '.strtoupper($product->stockin_sum_selling_type) ?>
                                              </label>
                                          </td>
                                          <td align="center">
                                              <button class="btn btn-info btn-xs btn-add-purchased" <?php echo ($product->stockin_sum_selling_quantity < 1) ? 'disabled' : '' ?> cval="<?php echo $product->product_id ?>">
                                                <i class="fa fa-shopping-cart"></i> <small>PO</small>
                                              </button>
                                          </td>
                                      </tr>
                                  <?php endforeach ?>
                              <?php endif ?>
                              
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <?php if (Session::hasFlash()): ?>
                  <div class="alert alert-success alert-dismissable fade-msg">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <b><i class="fa fa-check"></i></b>
                      <?php echo ucwords(Session::flash()) ?>
                  </div>
              <?php endif ?>
              <form action="<?php echo Url::route('orders/new_order'); ?>" method="POST" accept-charset="utf-8" data-parsley-validate="true">
                <div class="panel panel-success" style="border:1px solid #ccc">
                  <div class="panel-heading">Order List</div>
                  <div class="panel-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Customer's Name</label>
                              <!-- <input type="text" class="form-control" name="" value="" placeholder=""> -->
                              <select class="form-control" name="supplier" required="">
                                <option value="">Choose Customer</option>
                                <?php if (!is_null($data['customer']) AND is_array($data['customer'])): ?>
                                    <?php foreach ($data['customer'] as $custom): ?>
                                      <option value="<?php echo $custom->custom_id ?>"><?php echo ucwords($custom->custom_firstname.' '.$custom->custom_lastname) ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Date</label>
                              <input readonly="" type="date" name="date" class="form-control" id="exampleInputEmail1" value="<?php echo date('Y-m-d') ?>">
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="row-fluid">
                    <table class="table table-striped table-purchased bg-silver-lighter" id="table-purchased"> 
                        <thead style="background-color:#ececec">
                            <tr>
                                <th>SL#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Type</th>
                                <th>Disc%</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                               <?php if (!is_null($data['temps']) AND is_array($data['temps'])): ?>
                                   <?php 
                                     $sum = 0; $total = 0; $totalDisc = 0;
                                     $count =1;
                                   ?>
                                   <?php foreach ($data['temps'] as $temp): ?>
                                        <?php  $orderPrice = ($temp->temp_order_quantity * $temp->temp_order_price) - $temp->temp_order_discount; ?>
                                        <tr class="odd gradeX">
                                            <td><span><?php echo $count++; ?></span></td>
                                            <td>
                                              <span>
                                                <?php 
                                                  Query::select('product',['product_id' , '=' , $temp->product_id]);
                                                  if (Query::count()) {
                                                      echo Query::first()->product_name;
                                                  }
                                                  else{
                                                      echo $temp->temp_order_name;
                                                  }
                                                ?>
                                              </span>
                                            </td>
                                            <td>
                                              <input type="hidden"  id="temp-id"        value="<?php echo $temp->temp_order_id ?>">
                                              <input type="hidden"  name="product_id[]" value="<?php echo $temp->product_id ?>">
                                              <input type="hidden"  name="OrderName[]"  value="<?php echo $temp->temp_order_name ?>">
                                              <input type="text" class="form-control input-sm order-input" name="quantity[]" value="<?php echo $temp->temp_order_quantity ?>">
                                            </td>
                                            <td>
                                              <select class="form-control input-inline input-xs order-type" name="type[]" style="height: 25px">
                                                 <option value="pcs" selected><?php echo $temp->temp_order_quan_type; ?></option> 
                                              <!--   <option value="pcs">Pcs</option>
                                                <option value="box">Box</option>
                                                <option value="met">Meter</option>
                                                <option value="inchs">Inchs</option> -->
                                              </select>
                                            </td>
                                            <td><input type="text" name="disc[]" value="<?php echo $temp->temp_order_discount ?>" class="form-control input-sm order-disc" style="width: 50px;" placeholder="0"></td>
                                            <td><input type="text" class="form-control input-sm" name="price[]" value="<?php echo $temp->temp_order_price ?>" style="width: 50px;" readonly=""/></td>
                                            <td><span><?php echo number_format($orderPrice,2) ?></span></td>
                                            <td>
                                              <button class="btn btn-danger btn-xs btn-order-delete" title="" data-toggle="tooltip" data-placement="top" data-original-title="Delete" cval="<?php echo $temp->temp_order_id ?>">
                                                <i class="fa fa-trash"></i>
                                              </button>
                                            </td>
                                        </tr>
                                        <?php 
                                          $totalDisc += $temp->temp_order_discount;
                                          $sum        = $sum += $orderPrice;
                                        ?>
                                   <?php endforeach ?>
                                       
                                       <tr class="odd gradeX">
                                           <td colspan="6">
                                              <span class="pull-right"><b>Total Discount</b></span>
                                              <input type="hidden" name="grandTotalDisc" value="<?php echo $totalDisc ?>">
                                           </td>
                                           <td colspan="2"><label class="label-total"><?php echo number_format($totalDisc,2) ?></label></td>
                                       </tr>
                                       <tr class="odd gradeX">
                                            <td colspan="6">
                                              <span class="pull-right"><b>Grand Total</b></span> 
                                              <input type="hidden" name="grandTotal" value="<?php echo $sum ?>">
                                            </td>
                                           <td colspan="2"><label class="label-total"><?php echo number_format($sum,2) ?></label></td>
                                       </tr>
                                       <tr class="odd gradeX">
                                           <td colspan="6"><span class="pull-right"><b>Invoice Reference</b></span></td>
                                           <td colspan="2"><input type="text" name="reference" value="" class="form-control input-sm" required=""></td>
                                       </tr>
                                       <!-- <tr class="odd gradeX"> -->
                                           <!-- <td colspan="5"><span class="pull-right">Payment Method</span></td> -->
                                           <!-- <td colspan="2"> -->
                                            <!--  <select name="payment" class="form-control input-sm">
                                               <option value="cash">Cash </option> -->
                                           <!--     <option value="cheque">Cheque </option>
                                               <option value="credit">Credit Card</option> -->
                                             <!-- </select> -->
                                           <!-- </td> -->
                                       <!-- </tr> -->
                                       <tr class="odd gradeX">
                                           <td colspan="5"><span class="pull-right">&nbsp;</span></td>
                                           <td colspan="3">
                                              <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                                              <button type="submit" class="btn btn-primary btn-block">Purcahse</button>
                                           </td>
                                       </tr>
                               <?php endif ?>
                            </form>
                        </tbody>
                    </table>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
 

<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>


<!-- <script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script> -->



 
 <script type="text/javascript">
    $(document).ready(function(){

        var doc = $(document);

        $("#category-list-table").DataTable({

        });

        $('.btn-quan-type li').click(function(event) {
          var sel_val = $(this).find('a').html();
          $('#type').val(sel_val);

          $('.quantity-type').html(sel_val);
        });

        doc.on('click', '.btn-order-delete', function(event) {
            var temp_order_id = $(this).attr('cval');
            $.post("<?php echo Url::route('orders/delete_temp_order') ?>", { tmp_id : temp_order_id }, function(data) {
                if (data.key === true) {
                  location.reload();
                }
            },"JSON");
        });

        doc.on('click', '.btn-add-purchased', function(event) {
          var purchase_id = $(this).attr('cval');
          $.post("<?php echo Url::route('orders/add_temp_order') ?>", { purchase_id : purchase_id}, function(data) {
              if (data.key === true) {
                  location.reload();
              }
          },"JSON");
        });
        
        $('#table-purchased').on('focusout' ,'.order-input' ,function(){
            var $this    =  $(this);
            var tempId   =  $this.closest('tr').find("#temp-id").val();
            var inputVal =  $this.val();
            $.ajax({
                url : "<?php echo Url::route('ajax/orderQuantityUdate') ?>",
                type : 'POST',
                dataType : 'JSON',
                data : { tempId : tempId , inputVal : inputVal }
            })
              .done(function(data) {
                if (data.key === true) {
                  location.reload();
                }
                // console.log(data)
              });
        });

         $('#table-purchased').on('focusout' ,'.order-disc' ,function(){
            var $this    =  $(this);
            var tempId   =  $this.closest('tr').find("#temp-id").val();
            var inputVal =  $this.val();
            // alert(inputVal)
            $.ajax({
                url : "<?php echo Url::route('ajax/orderDiscountUpdate') ?>",
                type : 'POST',
                dataType : 'JSON',
                data : { tempId : tempId , inputVal : inputVal }
            })
              .done(function(data) {
                if (data.key === true) {
                  location.reload();
                }
                // console.log(data)
              });
        });

        setTimeout(function(){
          $('#mini-menu-bar').trigger('click');
        },100);
    });
 </script>