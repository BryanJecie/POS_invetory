<!DOCTYPE html>
<html>
<head>
	<title></title>

	<script>
		function print_reciept(){
			window.print();
			setTimeout(function(){
				window.close();
			},1);
		}
	</script>
</head>
<body style="font-family: arial; font-size: 14px;" onload="print_reciept()">
	<div style="width: 100%;" >
		<table width="100%">
			<thead>
				<tr>
					<th colspan="2"><b style="font-size: 18px"><?php echo strtoupper(company()->comp_abbr); ?></b></th>
				</tr>
				<tr>
					<th colspan="2"><small><?php echo strtoupper(company()->comp_name); ?></small></th>
				</tr>
				<tr>
					<th colspan="2"><small><?php echo strtoupper(company()->comp_address); ?></small></th>
				</tr>
			</thead>
		</table>
		<br>
		--------------------------------------
		<table width="100%">
			<tr>
				<td style="text-align: left"><small>CUST. NAME</small></td>
				<td>  <small><?php echo ($data['invoice']->custom_firstname !== "") ? strtoupper($data['invoice']->custom_firstname) : null ?></small></td>
			</tr>
			<tr>
				<td style="text-align: left"><small>CUST. ADDRESS</small></td>
				<td><small>  <?php echo ($data['invoice']->person_address !== "") ? strtoupper($data['invoice']->custom_firstname) : null ?></small></td>
			</tr>
		</table>
		--------------------------------------
		<br>
		<table width="100%">
			<tr>
				<td style="text-align: left"><small>RECEIPT NO. </small></td>
				<td style="text-align: right"> <b><?php echo $data['invoice']->invoice_no ?></b></td>
			</tr>
			<tr>
				<td style="text-align: left" colspan="2"><small>CASHIER : <?php echo strtoupper($data['invoice']->person_last.' '.$data['invoice']->person_first) ?></small></td>
			</tr>
		</table>
		--------------------------------------
		<br>
		<table width="100%">
		   <?php if (!empty($data['invSales'])): ?>
		   		<?php foreach ($data['invSales'] as $sale): ?>
		   			<tr>
		   				<td>
	   						<small>
	   							<?php 
	   								$pName = $sale->product_name;
	   								if (strlen($sale->product_name) > 10) {
	   									 $pName = substr($sale->product_name, 0, 10).'..';
	   								}
	   								echo strtoupper($pName);
	   							?>
	   						</small>
		   					<br>
		   					<?php 
		   						$barcode = $sale->barcode;
		   						if (strlen($sale->barcode) > 10) {
		   							 $barcode = substr($sale->barcode, 0, 10).'..';
		   						}
		   						echo strtoupper($barcode);
		   					?>
		   				</td>
		   				<td style="text-align: center"><small><?php echo strtoupper($sale->sales_quantity) ?></small></td>
		   				<td style="text-align: right"><small><?php echo number_format($sale->totalSales,2) ?></small></td>
		   			</tr>
		   		<?php endforeach ?>
		   <?php endif ?>
			
		</table>
		--------------------------------------
		<br>
		<table width="100%">
			<tr>
				<td><b style="font-size: 16px;">TOTAL DUE</b></td>
				<td style="text-align: right"><b style="font-size: 18px;"><?php echo number_format($data['invoice']->invoice_total_amount,2) ?></b></td>
			</tr>
			<tr>
				<td><small>CASH</small></td>
				<td style="text-align: right"><small><?php echo number_format($data['invoice']->invoice_input_amount,2) ?></small></td>
			</tr>
		</table>
		--------------------------------------
		<br>
		<table width="100%">
			<tr>
				<td><b style="font-size: 16px;">CHANGE</b></td>
				<td style="text-align: right">
					<b style="font-size: 18px;">
						<?php 
							$change = $data['invoice']->invoice_input_amount - $data['invoice']->invoice_total_amount;
							echo number_format($change,2);
						?>
					</b>
			</td>
			</tr>
		</table>
		--------------------------------------
		<br>
		<table width="100%">
			<tr>
				<td> LESS DISCOUNT </td>
				<td style="text-align: right"><b><?php echo number_format($data['invoice']->invoice_discount,2) ?></b></td>
			</tr>
		</table>
		--------------------------------------
		<br>
		<table width="100%">
			<tr>
				<td colspan="2"> <small>NO. OF ITEMS : <?php echo $data['itemsCount'] ?></small> </td>
			</tr>
		</table>
		--------------------------------------
		<br>
		<table width="100%">
			<tr>
				<td><small>RECEIPT NO.</small></td>
				<td style="text-align: right"> <b> <?php echo $data['invoice']->invoice_no ?> </b> </td>
			</tr>
		</table>
		--------------------------------------
		<br>
		<table width="100%">
			<tr>
				<td colspan="2"> <small>CASHIER : <?php echo strtoupper($data['invoice']->person_last.' '.$data['invoice']->person_first) ?></small> </td>
			</tr>
			<tr>
				<td colspan="2"><small>DATE/TIME :  <?php echo Date('Y-m-d g:i A') ?></small></td>
			</tr>
		</table>
		--------------------------------------
		<br>
		<br>
		<center>
			<small>THIS SERVE AS YOUR OFFICIAL RECIEPT</small><br>
		</center>
		<br>
		<small>This invoice/reciept shall be valid for five (5) years from the date of the perm it to use</small>
		<br>
		<br>
	</div>
	
</body>
</html>