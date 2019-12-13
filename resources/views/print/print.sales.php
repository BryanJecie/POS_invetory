<style type="text/css" media="screen">
      .page-break { 
        page-break-before: always;
      }
</style>


<h4>Sales Report from: <strong><?php echo date('M. j, Y', strtotime( $data['start'])); ?></strong> to <strong><?php echo date('M. j, Y', strtotime( $data['end'])); ?></strong></h4>

<?php if (!empty($data['invoice']['sales'])): ?>
	<?php $grandT = 0;  ?>
	<?php foreach ($data['invoice']['sales'] as $invSale): ?>
		<table  width="100%">
                <thead>
                <tr>
                    <th>INVOICE <?php echo $invSale->invoice_no ?></th>
                    <th>Invoice Date: <?php echo date('M. d, Y ', strtotime($invSale->invoice_date.' '.$invSale->invoice_time)) ?></th>
                </tr>
                </thead>
            </table>
            <?php
            	$count  = 1;
            	$total  = 0;
            	$display_sum = 0;
            	$display_total = 0;
             	$daySales =  Query::getSql()->query("SELECT * FROM product
            										INNER JOIN barcode ON barcode.product_id = product.product_id
            										INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
            										INNER JOIN sales ON sales.stock_sum_id = stockin_summary.stock_sum_id
            										WHERE invoice_id = {$invSale->invoice_id} ");
            ?>
			<?php if (!empty($daySales)): ?>
				<table width="100%">
                    <thead>
	                    <tr style="background-color: #ECECEC">
	                        <th>#</th>
	                        <th>Description</th>
	                        <th align="center">Buying Price</th>
	                        <th align="center">Selling Price</th>
	                        <th align="center">Qty</th>
	                        <th class="pull-right">TOTAL</th>
	                    </tr>
                    </thead>
					
                    <?php foreach ($daySales->_result as $sale): ?>
		                    <tbody>
	                    		<tr>
	                    		    <td><?php echo $count++; ?></td>
	                    		    <td><b><?php echo $sale->product_name.' '. $sale->product_subname ?></b></td>
	                    		    <td align="center"><?php echo $sale->stockin_sum_buying_price ?></td>
	                    		    <td align="center"><?php echo $sale->stockin_sum_selling_price ?></td>
	                    		    <td align="left"><?php echo $sale->sales_quantity.' '.$sale->sales_quantity_type ?></td>
	                    		    <td align="right">
	                    		     	<?php 
	                    		     		$sum         = $sale->stockin_sum_selling_price * $sale->sales_quantity;
	                    		     		$display_sum = $sum;
	                    		     		$total       = $sum += $total;
	                    		     		echo number_format($display_sum,2); 

	                    		     	?>
	                    		    </td>
	                    		</tr>
		                    </tbody> 
                    <?php endforeach ?>
                    <tfoot>
                    	<tr>
                    		<td colspan=""> </td>
                    		<td colspan=""> </td>
                    		<td colspan=""> </td>
                    		<td colspan=""> </td>
                    		<td colspan=""><b>Total</b></td>
                    		<td align="right">
                    			<b>
                    				<?php 

                    					$display_total = $total;
	                    		     	$grandT        = $total += $grandT;

                    					echo  number_format($display_total,2); 
                    				?>
                    			</b>
                    		</td>
                    	</tr>
                    </tfoot>
				</table>
				<br>
			<?php endif ?>
	<?php endforeach ?>
    
        <div class="page-break" style="page-break-before: always; "></div>
     
    <table width="100%">
        <thead>
            <tr style="background-color: #ccc">
                <th colspan="3" class="text-right">Total Cost</th>
                <th class="text-center">Total Revenue</th>
                <th class="">Total Profit</th>
            </tr>
        </thead>
        <tbody style="background-color: #c5c5c5">
            <tr>
                <td colspan="3" align="center" >$ 44,000.00</td>
                <td  align="center" >$ 54,337.50</td>
                <td align="center"><b><?php echo number_format($grandT,2) ?></b></td>
            </tr>
        </tbody>
    </table>
<?php endif ?>