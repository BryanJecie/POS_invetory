<style type="text/css">
    .btn-cat-action button{
        margin-left: 2px !important;
    }
    /*.table-order tr td{
      font-size: 11px;
      line-height: 10px !important;
    }
    .table-order tr td span{
      font-size: 12px;
      line-height: 20px !important;
      font-weight: bold;
    }
    .table-order tr td input{
      font-size: 11px;
      width: 50px;
      height: 25px;
    }
    .table-order tr td div span{
      height: px !important;
    }
    .table-order tr th{
      font-size: 11px;
      line-height: 5px !important;
    }*/
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
      /*height: 27px;*/
      margin-top: -2px
    }
    .table-order tr td .order-input-price{
      width: 100px;
      /*margin-top: -10px*/
       /*height: 27px;*/
    }
    .table-purchased tr th{
      font-size: 10px;
    }
    .table-purchased tr td{
      font-size: 12px;
    }
    .table-purchased tr td input{
      /*font-size: 12px;*/
      height: 25px;
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
        <h4 class="panel-title">Manage Order Invoice</h4>
    </div>
    <div class="panel-body">

        <table id="manage-order-table" class="table table-striped table-order"> 
            <thead style="background-color:#ececec">
                <tr>
                    <th>SL#</th>
                    <th>Purchase No.</th>
                    <th>Supplier Name</th>
                    <th>Invoice Date</th>
                    <th>Order Status</th>
                    <th>Purchase By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!is_null($data['orders']) AND is_array($data['orders'])): ?>
                    <?php $count = 1 ;  ?>
                    <?php foreach ($data['orders'] as $product): ?>
                    
                        <tr class="odd gradeX">
                            <td><?php echo $count++; ?></td>
                            <td><b class="text-info"><?php echo $product->order_no ?></b></td>
                            <td><?php echo ucwords($product->custom_lastname.' '.$product->custom_firstname) ?></td>
                            <td><?php echo $product->order_date ?></td>
                            <td><label class="label label-danger"><?php echo strtoupper($product->order_status) ?></label></td>
                            <td><?php echo ucwords($product->person_first.' '.$product->person_last) ?></td>
                            <td>
                                <div class="btn-group dropdown ">
                                    <button type="button" class="btn btn-white dropdown-toggle btn-sm" data-toggle="dropdown">
                                        More  <span class="caret"></span>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo Url::route('orders/view_invoice_order/?ordId='.$product->order_id.' ') ?>">
                                              <i class="glyphicon glyphicon-search text-primary"></i> 
                                              <span class="text-primary">View Invoice</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Url::route('orders/view_invoice_order/?ordId='.$product->order_id.'=action=confirm') ?>" class="orderConfirm">
                                              <i class="fa fa-check text-success"></i>
                                              <span class="text-success">Confirm Order</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="orderCancel" cval="<?php echo $product->order_id ?>">
                                              <i class="fa fa-times-circle-o text-danger"></i>
                                              <span class="text-danger">Cancel Order</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?> 
                
            </tbody>
        </table>
         
    </div>
</div>
 
 <script type="text/javascript">
    $(document).ready(function(){
       
        // FormPlugins.init();
        
        var handleDataTableSelect = function(){
              "use strict";0!==$("#manage-order-table").length&&$("#manage-order-table").DataTable({
                select:!0,responsive:!0
              });
            },
          TableManageTableSelect = function(){
            "use strict";

          return{ 
              init:function(){
                handleDataTableSelect();
                }
              };
            }();

           TableManageTableSelect.init();


          /* ==== order invoice event  ====*/
          var doc = $(document);

          // doc.on('click','.orderConfirm', function(){
          //   var $this    = $(this);
          //   var $orderNo = $this.attr('cval');
          //   $.post("<?php echo Url::route('orders/postOrderStatus') ?>", { ordNo : $orderNo , action : 'confirm' }, function(data) {
          //      if (data.key === true) {
          //         location.reload();
          //      }
          //   },"JSON");
          // });
          
          doc.on('click','.orderCancel', function(){
            var $this    = $(this);
            var $orderNo = $this.attr('cval');
            $.post("<?php echo Url::route('orders/postOrderStatus') ?>", { ordNo : $orderNo , action : 'cancel' }, function(data) {
               // console.log(data)
               if (data.key === true) {
                  location.reload();
               }
            },"JSON");
          });
       
    });
   
 </script>