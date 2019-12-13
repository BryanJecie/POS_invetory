<?php if (!empty($data['customer'])): ?>
	<table width="100%">
		<thead>
			<tr style="">
				<th style="text-align: left" width="15%;">Name</th>
				<th style="text-align: left"><b><?php echo strtoupper($data['customer']->custom_firstname.' '.$data['customer']->custom_lastname ) ?></b></th>
			</tr>
			<tr>
				<th style="text-align: left">Phone</th>
				<th style="text-align: left"><b><?php echo $data['customer']->custom_phone ?></b></th>
			</tr>
			<tr>
				<th style="text-align: left">Email</th>
				<th style="text-align: left"><b><?php echo $data['customer']->custom_email ?></b></th>
			</tr>
			<tr>
				<th style="text-align: left">Discount</th>
				<th style="text-align: left"><b><?php echo $data['customer']->custom_discount ?></b></th>
			</tr>
			<tr>
				<th style="text-align: left">Address</th>
				<th style="text-align: left"><span><?php echo $data['customer']->custom_address ?></span></th>
			</tr>
		</thead>
	</table>
<?php endif ?>
<br>
<br> 
<?php if (!is_null($data['orders'])): ?>
	<table width="100%" >
		<thead>
			<tr>
				<th style="">Order No.</th>
				<th style="">Date</th>
				<th style="">Order Bill</th>
				<th style="">Payment</th>
				<th style="">Discount</th>
				<th style="">Payable</th>
			</tr>
		</thead>
		<tbody>
			<?php $custInv = _get_sales_invoice_by_customer($data['custId']); ?>
			<?php $totalPayable = 0; $payable = 0; $totalPaid = 0; $grandTotal =0; $discountTotal =0; ?>
			<?php foreach ($data['orders'] as $order): ?>
				<?php 
					$payment = _get_partial_payment($order->order_id);
					$payable = $order->totalPayable - $payment;
				 ?>
				 <tr>
					<td align="center"><?php echo $order->order_no ?></td>
					<td align="center"><?php echo $order->order_date ?></td>
					<td align="center"><?php echo number_format($order->order_bill,2) ?></td>
					<td align="center"><?php echo (is_null($payment))? '0.00' :  number_format( $payment,2) ?></td>
					<td align="center"><?php echo $order->order_discount ?></td>
					<td align="center"><?php echo number_format($payable,2) ?></td>
				</tr> 
			<?php 
				$totalPayable  += $payable; 
				$totalPaid     += $payment;
				$grandTotal    += $order->totalPayable;
				$discountTotal += $order->order_discount;
			?>
			<?php endforeach ?>
			<tr>
			    <td colspan="6" >&nbsp;</td>
			</tr>
			<tr>
			    <td colspan="6" >&nbsp;</td>
			</tr>
			<tr>
			    <td colspan="4" ></td>
				<td colspan="" ><b>Grand Total</b></td>
				<td colspan="" ><b><?php echo number_format( $grandTotal, 2) ?></b></td>
			</tr>
			<tr>
			    <td colspan="4" ></td>
				<td colspan="" ><b>Total Discount</b></td>
				<td colspan="" ><b><?php echo number_format( $discountTotal, 2) ?></b></td>
			</tr>
			<tr>
			    <td colspan="4" ></td>
				<td colspan="" ><b>Total Paid</b></td>
				<td colspan="" ><b><?php echo number_format( $totalPaid, 2) ?></b></td>
			</tr>
			<tr>
			    <td colspan="4" ></td>
				<td colspan="" ><b style="color:red">Total Payable</b></td>
				<td colspan="" ><b style="color:red"><?php echo number_format( $totalPayable, 2) ?></b></td>
			</tr>
		</tbody>
	</table>
<?php endif ?>


 
