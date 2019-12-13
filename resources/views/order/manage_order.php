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
    #manage-order-table tr td span{
      font-weight: bolder !important;
      color: #00acac;
    }
    .ul-navs .active a{
      background-color: #00acac !important;
    }
</style>


<!-- <div class="profile-container"> -->
  <div class="row ">
    <div class="col-md-12 ">
      <ul class="nav nav-pills ul-navs ">
        <li class="active text-center" style="width: 12%"><a href="#nav-pills-tab-1" data-toggle="tab" aria-expanded="false" class=""> <i class="fa fa-shopping-cart" style="font-size: 14px;"></i> <b>ORDERS</b></a></li>
        <li class="text-center" style="width: 12%"><a href="#nav-pills-tab-2" data-toggle="tab" aria-expanded="false" class=""><i class="fa fa-group" style="font-size: 14px;"></i> <b>CUSTOMERS</b></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade active in" id="nav-pills-tab-1">
          <br>
          <h4 class="m-t-10 label label-info" style="font-size: 14px;">LIST OF ORDERS</h4>
          <br><br>
          <table id="manage-order-table" class="table table-striped table-bordered table-order"> 
           <thead style="background-color:#ececec">
               <tr>
                   <th>OL#</th>
                   <th>Purchase No.</th>
                   <th>Customer</th>
                   <th>Invoice Date</th>
                   <th>Total</th>
                   <th>Purchase By</th>
                   <th>Order Status</th>
                   <th>Payment Status</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>
             <?php if (!empty($data['orders']) AND is_array($data['orders'])): ?>
               <?php $count = 1 ;  ?>
               <?php foreach ($data['orders'] as $order): ?>
                  <tr class="odd gradeX">
                       <td><?php echo $count++; ?></td>
                       <td><span><?php echo $order->order_no ?></span></td>
                       <td><?php echo ucwords($order->custom_lastname.' '.$order->custom_firstname) ?></td>
                       <td><?php echo $order->order_date ?></td>
                       <td><b><?php echo  number_format(_get_sum_order_details($order->order_id),2) ?></b></td>
                       <td><?php echo ucwords($order->person_first.' '.$order->person_last) ?></td>
                       <td>
                         <label class="label label-<?php echo ($order->order_status == 'confirm') ? 'primary' : 'danger' ;?>">
                           <?php echo strtoupper($order->order_status) ?>
                         </label>
                       </td>
                       <td>
                         <label class="label label-<?php echo ($order->order_payment_status == 'paid') ? 'success' : 'danger' ;?>">
                           <?php echo strtoupper($order->order_payment_status) ?>
                         </label>
                       </td>
                       <td>
                         <a href="<?php echo Url::route('orders/view_invoice_order/?ordId='.$order->order_id.' ') ?>" class="btn btn-white btn-sm">
                           <i class="fa fa-search"></i> view
                         </a>
                       </td>
                   </tr>
               <?php endforeach ?>
             <?php endif ?>
           </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="nav-pills-tab-2">
          <br>
          <h4 class="m-t-10 label label-info" style="font-size: 14px;">LIST OF CUSTOMERS ORDERS</h4>
          <br><br>
          <table id="customer-order-table" class="table table-striped table-order table-bordered"> 
           <thead style="background-color:#ececec">
             <tr>
                 <th>SL#</th>
                 <th>Customer's No.</th>
                 <th>Customer's Name</th>
                 <th>Email</th>
                 <th>Phone</th>
                 <th>Discount</th>
                 <th>Action</th>
             </tr>
           </thead>
           <tbody>
             <?php if (!empty($data['customers']) AND is_array($data['customers'])): ?>
               <?php $count = 1 ;  ?>
               <?php foreach ($data['customers'] as $custom): ?>
                  <tr class="odd gradeX">
                     <td><?php echo $count++; ?></td>
                     <td><span class="text-primary"><?php echo $custom->custom_no  ?></span></td>
                     <td><?php echo ucwords($custom->custom_firstname.' '.$custom->custom_lastname) ?></td>
                     <td><?php echo ucwords($custom->custom_email) ?></td>
                     <td><b><?php echo  $custom->custom_phone ?></b></td>
                     <td>
                         <?php 
                           if (!is_null($custom->custom_discount)) {
                             $discArr = explode('.', $custom->custom_discount);
                             if ( count($discArr) > 1) {
                                echo $discArr[1].'%';
                             }
                             else{
                                echo $discArr[0];
                             }
                           }
                           else{
                              echo number_format(0,2);
                           }
                          
                         ?>
                     </td>
                     <td>
                       <a href="<?php echo Url::route('orders/view_invoice_customer_order/'.$custom->custom_id.' ') ?>" class="btn btn-white btn-sm">
                         <i class="fa fa-search"></i> view
                       </a>
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
<!-- </div> -->

 
 
 
 
 
<script type="text/javascript">
  $(document).ready(function(){

    $("#manage-order-table").DataTable({
      bSort : false
    });
    $("#customer-order-table").DataTable({});
         
  });
</script>