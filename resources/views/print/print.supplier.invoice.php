<?php $count = 1; $sumTotal = 0; ?>
<?php if (!is_null($data['gPurchased']) AND is_array($data['gPurchased'])): ?>
    <?php foreach ($data['gPurchased'] as $pur): ?>
      <table width="100%">
        <thead>
          <tr>
            <th style="text-align: left" width="50%"><small>SUPPLIER</small></th>
            <th style="text-align: center">DATE :<small><?php echo date('Y-m-d') ?></th>
          </tr>
          <tr>
            <th style="text-align: left"><?php echo $pur->supplier_company_name; ?></th>
            <th style="text-align: left"><?php echo  $pur->purchase_no ?></th>
          </tr>
          <tr>
            <th style="text-align: left"><?php echo $pur->supplier_email; ?></th>
            <th style="text-align: left"><small>Date of invoice </small> : <?php echo $pur->purchase_date ?> </th>
          </tr>
          <tr>
            <th style="text-align: left"><?php echo $pur->supplier_phone_no; ?></th>
            <th style="text-align: left"><small>Purchased by</small> : <?php echo ucwords($pur->person_first.' '.$pur->person_last) ?></th>
          </tr>
          <tr>
            <th style="text-align: left"><?php echo $pur->supplier_address; ?></th>
            <th style="text-align: left"><small>Purchased Reference</small> : <?php echo $pur->purchase_reference ?></th>
          </tr>
            <tr>
            <th style="text-align: left">&nbsp;</th>
            <th style="text-align: left"><small>Payment Method</small> : <?php echo $pur->purchase_payment_type ?></th>
          </tr>
            <tr>
            <th style="text-align: left">&nbsp;</th>
            <th style="text-align: left"><small>Payment Status </small> : <?php echo $pur->purchase_payment_status ?></th>
          </tr>
        </thead>
      </table>
      <br><br>
      <table class="" width="100%">
          <thead class="bg-silver-lighter">
              <tr>
                  <th style="text-align: left">#</th>
                  <th style="text-align: left">DESCRIPTION</th>
                  <th style="text-align: left">UNIT PRICE</th>
                  <th style="text-align: left">QUANTITY</th>
                  <th style="text-align: left"><span class="pull-right">TOTAL</span></th>
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
                                ->where(['purchased_details.pur_id', '=', $purc->pur_id])
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
                              <td align=""><b><?php echo number_format($total,2) ?></b></td>
                          </tr>  
                  <?php } } ?>
                    
                  <?php //$sumTotal = $total+= $sumTotal;?>
                  <?php endforeach ?>
              <?php endif ?>

          </tbody>
          <tfoot class="">
            <tr>
              <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"> </td>
              <td colspan="1"><span>Grand Total</span></td>
              <td align=""><span><?php echo number_format($purc->purchase_total_amount,2) ?></span></td>
            </tr>
            <tr>
              <td colspan="5">&nbsp;</td>
            </tr>
            <?php $pay_purchase = DB::table('payment_purchased')->where(['pur_id', '=', $purc->pur_id])->all();

              if (!empty($pay_purchase)) {
                 foreach ($pay_purchase as $pPur) { ?>
                   <tr>
                     <td colspan="3"> </td>
                     <td colspan="1"><span class="">Amount Paid</span></td>
                     <td align=""><span class=""><?php echo number_format($pPur->pay_amount,2) ?></span></td>
                   </tr>
                   <tr>
                     <td colspan="3"> </td>
                     <td colspan="1"><span class="">Date Paid</span></td>
                     <td align=""><span class=""><?php echo date('F j, Y', strtotime($pPur->pay_pur_date)); ?> </span></td>
                   </tr>
                   <tr>
                     <td colspan="5">&nbsp;</td>
                   </tr> 
            <?php } } ?>
          </tfoot>
      </table>
    <?php endforeach ?>
<?php endif ?>
