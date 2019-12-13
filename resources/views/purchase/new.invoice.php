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
        <h4 class="panel-title">Supplier Invoice</h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-5">
               
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-success" style="border:1px solid #ccc">
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Search Products</a></li>
                    <li class=""><a data-toggle="tab" href="#menu1">Add Product</a></li>
                    <!-- <li><a data-toggle="tab" href="#menu2">Menu 2</a></li> -->
                  </ul>

                  <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active">
                      <table id="category-list-table" class="table table-striped table-order" width="100%"> 
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
                                        <td><?php echo ucwords($product->product_name) ?></td>
                                        <td>  
                                            <label class="label label-<?php echo $class_label ;?>">
                                              <?php echo $product->stockin_sum_selling_quantity.' '.strtoupper($product->stockin_sum_selling_type) ?>
                                            </label>
                                        </td>
                                        <td align="center">
                                            <button class="btn btn-success btn-xs btn-add-purchased" cval="<?php echo $product->product_id ?>">
                                              <i class="fa fa-shopping-cart"></i> <small>ORDER</small>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                            
                          </tbody>
                      </table>
                    </div>
                    <div id="menu1" class="tab-pane fade ">
                   
                      <form class="form-horizontal" action="<?php echo Url::route('supplier/new_invoice') ?>" method="POST" data-parsley-validate="true" name="form-wizard">
                         <div class="form-group">
                             <label class="col-md-2 control-label">&nbsp;</label>
                             <div class="col-md-9">
                                <legend ><small>Product Form</small></legend>
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-3 control-label">Product Name</label>
                             <div class="col-md-8">
                                 <input type="text" name="p-name" class="form-control" placeholder="Product Name" required="">
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-3 control-label">Product Quantity</label>
                             <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" name="p-quantity" class="form-control" placeholder="Input Quantity" required="">
                                    <input type="hidden" name="p-type" id="type">
                                    <div class="input-group-btn select-quan-type">
                                        <ul class="dropdown-menu pull-right btn-quan-type" id="">
                                            <li><a href="javascript:;">Box</a></li>
                                            <li><a href="javascript:;">Sack</a></li>
                                        </ul>
                                        <button type="button" class="btn btn-primary dropdown-toggle"  data-toggle="dropdown" aria-expanded="false" >
                                            <small><span class="quantity-type">Pcs</span></small>
                                             <span class="caret"></span>
                                        </button>
                                    </div>
                                </div>
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-3 control-label">Product Price</label>
                             <div class="col-md-8">
                                 <div class="input-group">
                                     <span class="input-group-addon"> &#8369;</span>
                                     <input type="text" name="p-price" class="form-control" placeholder="0.00" required="">
                                 </div> 
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-3 control-label">&nbsp;</label>
                             <div class="col-md-8">
                                  <input type="hidden" value="1" name="add-product">
                                 <button type="submit" class="btn btn-primary pull-right">Add Product</button>
                             </div>
                         </div>
                      </form>
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
              <form action="<?php echo Url::route('supplier/new_invoice'); ?>" method="POST" accept-charset="utf-8" data-parsley-validate="true">
                <div class="panel panel-success" style="border:1px solid #ccc">
                  <div class="panel-heading">Purchased List</div>
                  <div class="panel-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Suppllier's Name</label>
                              <select class="form-control" name="supplier" required="">
                                <option value="">Choose Suppllier</option>
                                <?php if (!is_null($data['supplier']) AND is_array($data['supplier'])): ?>
                                    <?php foreach ($data['supplier'] as $custom): ?>
                                      <option value="<?php echo $custom->supplier_id ?>"><?php echo ucwords($custom->supplier_company_name) ?></option>
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
                                <th >Quantity</th>
                                <th >Type</th>
                                <th >Price</th>
                                <th >Total</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                               <?php if (!is_null($data['temps']) AND is_array($data['temps'])): ?>
                                   <?php 
                                     $sum = 0; $total = 0;
                                     $count =1;
                                   ?>
                                   <?php foreach ($data['temps'] as $temp): ?>
                                        <?php  $orderPrice = $temp->temp_order_quantity * $temp->temp_order_price; ?>
                                        <tr class="odd gradeX">
                                            <td><span><?php echo $count++; ?></span></td>
                                            <td>
                                              <span>
                                                <?php 
                                                  // echo $temp->temp_order_name 
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
                                              <input type="text" style="height: 25px; width: 60px;" class="form-control input-sm order-input" name="quantity[]" value="<?php echo $temp->temp_order_quantity ?>">
                                            </td>
                                            <td>
                                              <select class="form-control input-inline input-sm order-type" style="height: 25px;" name="type[]">
                                                <option value="<?php echo $temp->temp_order_quan_type; ?>"><?php echo $temp->temp_order_quan_type; ?></option> 
                                                <option value="pcs">Pcs</option>
                                                <option value="box">Box</option>
                                                <option value="inchs">Inchs</option>
                                                <option value="met">Meter</option>
                                                <option value="sacks">Sacks</option>
                                              </select>
                                            </td>
                                            <td><input type="text" class="form-control input-sm order-price" name="price[]" style="width: 60px;" value="<?php echo $temp->temp_order_price ?>"/></td>
                                            <td><span><?php echo number_format($orderPrice,2) ?></span></td>
                                            <td >
                                              <button class="btn btn-danger btn-xs btn-order-delete" title="" data-toggle="tooltip" data-placement="top" data-original-title="Delete" cval="<?php echo $temp->temp_order_id ?>">
                                                <i class="fa fa-trash"></i>
                                              </button>
                                            </td>
                                        </tr>
                                        <?php 
                                          $total = ($temp->temp_order_quantity * $temp->temp_order_price);
                                          $sum   = $sum+=$total;
                                        ?>
                                   <?php endforeach ?>
                                       <tr class="odd gradeX">
                                            <td colspan="5">
                                              <span class="pull-right"><b>Grand Total</b></span> 
                                              <input type="hidden" name="grandTotal" value="<?php echo $sum ?>">
                                            </td>
                                           <td colspan="2"><label class="label-total"><?php echo number_format($sum,2) ?></label></td>
                                       </tr>
                                       
                                      <!--  <tr class="odd gradeX">
                                           <td colspan="5"><span class="pull-right"><b>Discount</b></span></td>
                                           <td colspan="2">
                                             <input type="text" name="reference" value="" class="form-control input-sm" required="">
                                           </td>
                                       </tr> -->

                                       <tr class="odd gradeX">
                                           <td colspan="5"><span class="pull-right"><b>Invoice Reference</b></span></td>
                                           <td colspan="2"><input type="text" name="reference" value="" class="form-control input-sm" required=""></td>
                                       </tr>
                                       <tr class="odd gradeX">
                                           <td colspan="5"><span class="pull-right">Payment Method</span></td>
                                           <td colspan="2">
                                             <select name="payment" class="form-control input-sm">
                                               <option value="cash">Cash </option>
                                               <option value="cheque">Cheque </option>
                                               <option value="credit">Credit Card</option>
                                             </select>
                                           </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                           <td colspan="4"><span class="pull-right">&nbsp;</span></td>
                                           <td colspan="3">
                                              <!-- <input type="hidden" name="form-purchased" value="purchase"> -->
                                              <input type="hidden" value="<?php echo Token::generate() ?>" name="token">
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


<script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>



 
 <script type="text/javascript">
    $(document).ready(function(){
        // TableManageTableSelect.init();
        // FormPlugins.init();
        var doc = $(document);


        $("#category-list-table").DataTable({

        });

        doc.on('click', '.btn-quan-type li').click(function(event) {
          var sel_val = $(this).find('a').html();
          $('#type').val(sel_val);

          $('.quantity-type').html(sel_val);
        });

        // FormWizardValidation.init();

        doc.on('click', '.btn-order-delete', function(){
            var temp_order_id = $(this).attr('cval');
            $.post("<?php echo Url::route('orders/delete_temp_order') ?>", { tmp_id : temp_order_id }, function(data) {
                if (data.key === true) {
                  location.reload();
                }
            },"JSON");
        });
        doc.on('click', '.btn-add-purchased', function(event) {
          event.preventDefault();
           var purchase_id = $(this).attr('cval');
          $.post("<?php echo Url::route('supplier/add_temp_purchase') ?>", { purchase_id : purchase_id}, function(data) {
              if (data.key === true) {
                  location.reload();
              }
          },"JSON" );
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
        doc.on('focusout' , '.order-price', function(){
          var $this  = $(this);
          var parent = $this.parent();
          var inVal =   $this.val();
          var tempId = parent.siblings('td').find('#temp-id').val();
              
              $.post("<?php echo Url::route('ajax/update_temp_purchased') ?>", { tempId : tempId , inVal : inVal}, function(data) {
                if (data.key === true) {
                  location.reload();
                }
              },"JSON");

        });

        setTimeout(function(){
          $('#mini-menu-bar').trigger('click');
        },100);
    });
 </script>