 
<?php $orderId = 0;  $status =""; ?>
<?php if (!is_null($data['orders']) AND is_array($data['orders'])): ?>
    <?php foreach ($data['orders'] as $order): ?>
        <?php  $orderId  = $order->order_id; $status = $order->order_status; ?>
        <?php  $discount = $order->order_discount; ?>
        <table width="100%">
        	<thead>
        		<tr style="">
        			<th style="text-align: left; border: none;" width="50%">Customer</th>
        			<th style="text-align: left; border: none;"><b><?php echo  $order->order_no; ?></b></th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr>
        			<td style="border: none;"><b><?php echo ucwords($order->custom_firstname.' '.$order->custom_lastname); //echo $order->supplier_company_name; ?></b></td>
        			<td style="border: none;">Date or Order : <b><?php echo $order->order_date; ?></b></td>
        		</tr>
        		<tr>
        			<td style="border: none;"><?php echo $order->custom_email;  ?></td>
        			<td style="border: none;">Prepared By : <b><?php echo ucwords($order->person_first.' '.$order->person_last); ?></b></td>
        		</tr>
        		<tr>
        			<td style="border: none;"><?php  echo $order->custom_address;  ?></td>
        			<td style="border: none;">Order Status : <b><?php echo strtoupper($order->order_status) ?></b> </td>
        		</tr>
            <tr>
              <td style="border: none;"><?php  echo $order->custom_phone;  ?></td>
              <td style="border: none;">Payment Status : <?php echo strtoupper($order->order_payment_status); ?></td>
            </tr>
        	</tbody>
        </table>
        <br>
        <br><br>
        <table width="100%">
            <thead>
                <tr>
                    <th style="border: none; text-align: left">#</th>
                    <th style="border: none; text-align: left">DESCRIPTION</th>
                    <th style="border: none; text-align: left">UNIT PRICE</th>
                    <th style="border: none; text-align: left">QUANTITY</th>
                    <th style="border: none; text-align: left"><span>TOTAL</span></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; $sumTotal = 0; ?>
                <?php if (!empty($data['orDs']) AND is_array($data['orDs'])): ?>
                    <?php foreach ($data['orDs'] as $details): ?>
                      <?php $total = $details->details_order_quantity * $details->details_order_price; ?>
                      <tr >
                          <td style="border: none;"><?php echo $count++; ?></td>
                          <td style="border: none;">
                            <?php 
                                if (is_null($details->details_order_name) AND $details->details_order_name == "") {
                                  Query::select('product',['product_id', '=', $details->product_id]);
                                  if (Query::count()) {
                                      echo Query::first()->product_name.' '.Query::first()->product_subname;
                                  }
                                }
                                else{
                                   echo $details->details_order_name;
                                }
                            ?>
                          </td>
                          <td style="border: none;"><?php echo number_format($details->details_order_price,2) ?></td>
                          <td style="border: none;"><?php echo $details->details_order_quantity ?></td>
                          <td style="border: none;" align="left"><b><?php echo number_format($total,2) ?></b></td>
                      </tr>
                    <?php $sumTotal = $total+= $sumTotal;?>
                    <?php endforeach ?>
                <?php endif ?>

            </tbody>
            <tfoot class="invoiceTable">
              <!-- <tr>
                <td colspan="3" style="border: none;"> </td>
                <td colspan="1" style="border: none;">SUBTOTAL</td>
                <td align="left" style="border: none;"><?php echo number_format($sumTotal,2) ?></td>
              </tr>
              <tr>
                <td colspan="3" style="border: none;"> </td>
                <td colspan="1" style="border: none;">TAX</td>
                <td align="left" style="border: none;"><?php echo number_format($sumTotal,2) ?></td>
              </tr>
              <tr>
                <td colspan="3" style="border: none;"> </td>
                <td colspan="1" style="border: none;">DISCOUNT AMOUNT</td>
                <td align="left" style="border: none;"><?php echo number_format($sumTotal,2) ?></td>
              </tr> -->
              <!-- $discount -->
              <?php $gTotal = ($sumTotal - $discount); ?>

              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>

              <tr>
                <td colspan="3"> </td>
                <td colspan="1"><span>TOTAL ORDER</span></td>
                <td align="left"><span><b><?php echo number_format($sumTotal,2) ?></b></span></td>
              </tr>
              <tr>
                <td colspan="3"> </td>
                <td colspan="1"><span>TOTAL DISCOUNT</span></td>
                <td align="left"><span><b><?php echo number_format($discount,2) ?></b></span></td>
              </tr>
              <tr>
                <td colspan="3"> </td>
                <td colspan="1"><span>GRAND TOTAL</span></td>
                <td align="left"><span><b><?php echo number_format($gTotal,2) ?></b></span></td>
              </tr>

              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <?php $payment = _get_partial_payment($orderId); ?>
              <?php if (!is_null($payment)): ?>
                <tr>
                  <td colspan="3"> </td>
                  <td colspan="1"><span>TOTAL PAYMENT</span></td>
                  <td align="left"><span><b><?php echo number_format($payment,2) ?></b></span></td>
                </tr>
                <tr>
                  <td colspan="3"> </td>
                  <td colspan="1"><span style="color:red">TOTAL BALANCES</span></td>
                  <td align="left"><span><b style="color:red"><?php echo number_format($gTotal-$payment,2) ?></b></span></td>
                </tr>
              <?php endif ?>
            </tfoot>
        </table>
    <?php endforeach ?>
<?php endif ?>





