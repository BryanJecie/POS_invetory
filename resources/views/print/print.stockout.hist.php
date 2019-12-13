

<?php if (!is_null($data['stocks'])): ?>
	

	<table width="100%" class="table-border">
		<thead>
			<tr>
				<th style="text-align: left">#SO</th>
				<th style="text-align: left">Product Name</th>
				<th style="text-align: left">Barcode</th>
				<th style="text-align: center">Stockout Date</th>
				<th style="text-align: center">Price</th>
				<th style="text-align: center">Inventory</th>
				<th style="text-align: center">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php $count = 1; $totalItem = 0; ?>
			<?php foreach ($data['stocks'] as $stock): ?>
				<tr>
					<td><?php echo $count++ ?></td>
					<td><?php echo ucwords($stock->product_name.' '.$stock->product_subname) ?></td>
					<td><?php echo $stock->barcode ?></td>
					<td><?php echo $stock->stockcout_date ?></td>
					<td align="center"><?php echo number_format($stock->stockout_selling_price,2) ?></td>
					<td align="center"><?php echo $stock->stockout_quantity.' '.ucwords($stock->stockout_quantity_type) ?></td>
					<td align="center"><?php echo ucwords($stock->stockout_status) ?></td>
				</tr>
				<?php $totalItem += $stock->stockout_quantity ?>
			<?php endforeach ?>
			<tr>
			 	<td colspan="4"></td>
			    <td align="center">TOTAL OUT</td>
				<td align="center"><?php echo $totalItem; ?></td>
			 	<td></td>
			</tr>
		</tbody>
	</table>


<?php else : ?>
	<table width="100%">
		<thead>
			<tr>
				<th>
					<center><h2>No Stocks Available !</h2></center>
				</th>
			</tr>
		</thead>
	</table>
<?php endif ?>