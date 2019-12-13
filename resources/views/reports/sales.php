<style>
	.today{
		color: #00acac !important;
		font-weight: bold;
	}
</style>

<div class="row">
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="form-plugins-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Sales Reports</h4>
            </div>
            <div class="panel-body panel-form">
            	<div class="row">
            		<div class="col-md-2"></div>
            		<div class="col-md-6">
            			<br>

            			<?php if (Session::hasFlash()): ?>
            			    <div class="alert alert-danger alert-dismissable fade-msg">
            			        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            			        <b><i class="fa fa-times"></i></b>
            			        <?php echo ucwords(Session::flash()) ?>
            			    </div>
            			<?php endif ?>
		                <form class="form-horizontal form-condensed" action="<?php echo Url::route('reports/sales_report') ?>" method="POST" data-parsley-validate="true" name="form-wizard">
							<div class="form-group">
								<label class="control-label col-md-4">START DATE <span class="text-danger">*</span></label>
								<div class="col-md-8">
                                    <div class="input-group date">
                                    	<input type="text" name="start" value="<?php echo escape(Input::get('start')) ?>" class="form-control" id="start-date" placeholder="Select Start Date" required="" />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">END DATE <span class="text-danger">*</span></label>
								<div class="col-md-8">
							        <div class="input-group date">
                                    	<input type="text" name="end" value="<?php echo Input::get('end') ?>" class="form-control" id="end-date" placeholder="Select End Date" required="" />
		                                <span class="input-group-addon">
		                                    <span class="fa fa-calendar"></span>
		                                </span>
		                            </div>
		                        </div>
		                    </div>
							<div class="form-group">
								<label class="control-label col-md-4">&nbsp;</label>
								<div class="col-md-8">
								    <div class="row row-space-10">
		                                <div class="col-md-6">
		                                	<button class="btn btn-primary btn-block" id="generateBtn">Generate Reports</button>
		                                    <input type="hidden" name="token" value="<?php echo Token::generate() ?>" />
		                                </div>
		                                <div class="col-md-6">
		                                    <!-- <input type="text" class="form-control" id="datetimepicker4" placeholder="Max Date" /> -->
		                                </div>
		                            </div>
		                        </div>
		                    </div>
						</form>
            		</div>
            		<div class="col-md-3"></div>
            	</div>
                
            </div>
        </div>
        <!-- END panel -->
    </div>
</div>


<?php if (!empty($data['invoice']['tbl-sales'])): ?>
	<table width="100%" border="1" id="table-sales" class="hide">
		<thead>
			<tr>
				<th colspan=""> </th>
				

				<th colspan=" ">
					<b>
						Sales Report from: 
					  <?php echo date('M. j, Y', strtotime( $data['start'])); ?> to
					  <?php echo date('M. j, Y', strtotime( $data['end'])); ?>
					</b>
				</th>
				<th colspan=""> </th>
				<th colspan=""> </th>
				<th colspan=""> </th>
				<th colspan=""> </th>
				<th colspan=""> </th>
				<th colspan=""> </th>
				<th colspan="2" style="text-align: right"> <b>DATE <?php echo date('M. j, Y', strtotime( date('Y-m-d'))); ?></b> </th>
			</tr>
			<tr>
				<th colspan=""> </th>
				<th colspan=""> </th>
				<th colspan=""> </th>
				<th colspan=""> </th>
				<th> <b>TOTAL REVENUE  :<?php echo number_format($data['invoice']['tbl-sales']['total']['tAmount'],2) ?></b></th>
				<th> <b>TOTAL DISCOUNT :<?php echo number_format($data['invoice']['tbl-sales']['total']['tDiscount'],2) ?></b></th>
				<th> <b>TOTAL PROFIT   :<?php echo number_format($data['invoice']['tbl-sales']['total']['tProfit'],2) ?></b></th>
				<th> <b>TOTAL SALES    :<?php echo number_format($data['invoice']['tbl-sales']['total']['tSales'],2) ?></b></th>
				<th> <b>TOTAL COST     :<?php echo number_format($data['invoice']['tbl-sales']['total']['tRevenue'],2) ?></b></th>
			</tr>
			<tr class="bg-info">
				<th>#</th>
				<th><b>Product name</b></th>
				<th><b>Barcode</b></th>
				<th><b>Quantity</b></th>
				<th><b>Buying Price</b></th>
				<th><b>Selling Price</b></th>
				<th><b>Total Discount</b></th>
				<th><b>Total Sales</b></th>
				<th><b>Total Profit</b></th>
			</tr>
		</thead>
		<tbody>
		<?php $count = 1; ?>
		<?php foreach ($data['invoice']['tbl-sales'] as $key => $tblSales): ?>
			<?php if (!is_numeric($key)): ?>
				<tr>
					<th colspan=""> </th>
					<th colspan=""> </th>
					<th colspan=""> </th>
					<th colspan=""> </th>
					<th> <b>TOTAL REVENUE  : <?php echo number_format($tblSales['tAmount'],2) ?></b></th>
					<th> <b>TOTAL DISCOUNT : <?php echo number_format($tblSales['tDiscount'],2) ?></b></th>
					<th> <b>TOTAL PROFIT   : <?php echo number_format($tblSales['tProfit'],2) ?></b></th>
					<th> <b>TOTAL SALES    : <?php echo number_format($tblSales['tSales'],2) ?></b></th>
					<th> <b>TOTAL COST     : <?php echo number_format($tblSales['tRevenue'],2) ?></b></th>
				</tr>
			<?php else : ?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td><?php echo ucwords($tblSales['pName']) ?></td>
					<td><?php echo $tblSales['barcode']   ?></td>
					<td><?php echo $tblSales['quanity'] ?></td>
					<td><?php echo number_format($tblSales['buyPrice'],2)   ?></td>
					<td><?php echo number_format($tblSales['salePrice'],2)   ?></td>
					<td><?php echo number_format($tblSales['totalDiscount'],2)   ?></td>
					<td><?php echo number_format($tblSales['salePrice'] - $tblSales['totalDiscount'],2)   ?></td>
					<td><?php echo number_format($tblSales['totalProfit'],2)   ?></td>
				</tr>
			<?php endif ?>
		<?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>

<?php if (!empty($data['invoice']['sales'])): ?>
	<div class="profile-container">
	
		<div class="row">
			<div class="col-md-12">
				<div class="profile-container">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-1">
	                         <?php echo App::$image->get('images/company/',['width'=>'90'],1); ?>
						</div>
						<div class="col-md-4">
							<?php if (!empty($data['invoice']['comps']) AND !is_null($data['invoice']['comps'])): ?>
								<?php foreach ($data['invoice']['comps'] as $comp): ?>
									<address class="" style="position: absolute; margin-top: 10px; margin-left: 10px;">
										<strong><?php echo ucwords($comp->comp_name) ?></strong><br>
										<p>
											<b><?php echo $comp->comp_email ?></b><br>
											<abbr title="Phone">Phone : </abbr>
											<b><a href="javascript:;"><?php echo $comp->comp_phone ?></a></b>
											<br> <?php echo $comp->comp_address; ?> 
										</p> 
									</address>
								<?php endforeach ?>
							<?php else : ?>
								<div class="">
									<b>No Company Name</b>
								</div>
							<?php endif ?>
						</div>
						<div class="col-md-5">
							<div class="btn-group pull-right btnPrint">
								<button class="btn btn-white btn-sm m-r-5" id="printSales">
									<i class="fa fa-print" style="font-size: 14px;"></i>  Print Sales<br>
								</button>
								<button class="btn btn-white btn-sm" id="btn-excel-sales">
									<i class="fa fa-download" style="font-size: 14px;"></i> Export to Excel <br>
								</button>
							</div>
							<br>
							<label class="text-inverse text-title" style="font-size: 14px">TOTAL REPORTS  </label>	 
							<div class="widget widget-stats bg-blue">
						  	   <div class="col-md-4" style="">
						  			<div class="stats-info">
						  				<div class="stats-title">TOTAL SALES</div>
						  				<b class="text-inverse" style="font-size:20px;"><?php echo number_format($data['invoice']['tbl-sales']['total']['tSales'],2) ?></b>
						  			</div>
						  	   </div>
						  	   <div class="col-md-4" style="">
						  			<div class="stats-info">
						  				<div class="stats-title">TOTAL COST</div>
						  				<b class="text-inverse" style="font-size:20px;"><?php echo number_format($data['invoice']['tbl-sales']['total']['tRevenue'],2) ?></b>
						  			</div>
						  	   </div>
						  	   <div class="col-md-4" style="">
						  			<div class="stats-info">
						  				<div class="stats-title">TOTAL PROFIT</div>
						  				<b class="text-inverse" style="font-size:20px;"><?php echo number_format($data['invoice']['tbl-sales']['total']['tProfit'],2) ?></b>
						  			</div>
						  	   </div>
						  	   <div class="col-md-4" style="margin-top: 10px;">
						  			<div class="stats-info">
						  				<div class="stats-title">TOTAL REVENUE</div>
						  				<b class="text-inverse" style="font-size:20px;"><?php echo number_format($data['invoice']['tbl-sales']['total']['tAmount'],2) ?></b>
						  			</div>
						  	   </div>
						  	   <div class="col-md-5" style="margin-top: 10px;">
						  			<div class="stats-info">
						  				<div class="stats-title">TOTAL DISCOUNT</div>
						  				<b class="text-inverse" style="font-size:20px;"><?php echo number_format($data['invoice']['tbl-sales']['total']['tDiscount'],2) ?></b>
						  			</div>
						  	   </div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10"><hr style="border: .1px solid lightgray"></div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10" >
							<ul class="nav nav-pills">
								<li class="active"><a href="#nav-pills-tab-1" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> CASHIER SALES REPORTS</a></li>
								<li class=""><a href="#nav-pills-tab-2" data-toggle="tab" aria-expanded="false"><i class="fa fa-users"></i>  PURCHASE ORDER (PO) SALES REPORT</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="nav-pills-tab-1">
									<h4>Sales Report from: <strong><?php echo date('M. j, Y', strtotime( $data['start'])); ?></strong> to <strong><?php echo date('M. j, Y', strtotime( $data['end'])); ?></strong></h4>
									<hr>
									<?php $grandS = 0; $grandP = 0; $grandC = 0; $grandR = 0; $grandD = 0;?>
									<?php foreach ($data['invoice']['sales'] as $invSale): ?>
									 	<?php Query::select('sales_partial' , ['invoice_id' , '=' , $invSale->invoice_id ]);
									 		if (!Query::count()) { ?>
												<table class="table table-condensed">
									                    <thead>
									                    <tr>
									                        <th class="no text-right">INVOICE NO : <?php echo $invSale->invoice_no ?></th>
									                        <th class="desc">Invoice Date: <?php echo date('M. d, Y ', strtotime($invSale->invoice_date.' '.$invSale->invoice_time)) ?></th>
									                    </tr>
									                    </thead>
									                </table>
												<?php 
													$partialPayment = _get_partial_payme_with_invoice($invSale->invoice_id);

												    if (!is_null($invSale->invoice_total_amount)) {
														$grandR += $invSale->invoice_total_amount; 
												    }
												    else{
												    	$grandR += $partialPayment; 
												    }
													$grandD += $invSale->invoice_discount; 
												?>
												<?php
													$count = 1;$total = 0;$tProfit = 0;$tCost = 0; $tSales = 0; 
												 	$daySales   = Query::getSql()->query("
												 						SELECT
												 						sales.sales_quantity,
												 						stockin_summary.stockin_sum_buying_price,
												 						stockin_summary.stockin_sum_selling_price,
												 						barcode.barcode,
												 						product.product_name,
												 						sales.sales_quantity_type,
												 						product.product_subname,
												 						IFNULL(stockin_sum_selling_price * sales_quantity ,0 ) totalSales,
												 						IFNULL((stockin_sum_selling_price * sales_quantity) - (stockin_sum_buying_price * sales_quantity) ,0 ) AS totalProfit,
												 						IFNULL(stockin_sum_buying_price * sales_quantity ,0 ) AS totalCost
												 						FROM
												 						sales
												 						INNER JOIN stockin_summary ON sales.stock_sum_id = stockin_summary.stock_sum_id
												 						INNER JOIN barcode ON stockin_summary.barcode_id = barcode.barcode_id
												 						INNER JOIN product ON barcode.product_id = product.product_id 
												 						WHERE sales.invoice_id  = {$invSale->invoice_id}
												 		          ");
												?>
												<?php if (!empty($daySales)): ?>
													<table class="table table-condensed">
									                    <thead>
										                    <tr style="background-color: #ECECEC">
										                        <th>#SL</th>
										                        <th>Description</th>
										                        <th align="">Buying Price</th>
										                        <th align="">Selling Price</th>
										                        <th align="">Qty</th>
										                        <th class="">Sales</th>
										                        <th class="">Profit</th>
										                    </tr>
									                    </thead>
									                    <?php foreach ($daySales->_result as $sale): ?>
					 					                    <tbody>
										                    		<tr>
										                    		    <td><?php echo $count++; ?></td>
										                    		    <td><b><?php echo ucwords($sale->product_name.' '. $sale->product_subname) ?></b></td>
										                    		    <td align=""><?php echo number_format($sale->stockin_sum_buying_price,2) ?></td>
										                    		    <td align=""><?php echo number_format($sale->stockin_sum_selling_price,2) ?></td>
										                    		    <td align=""><?php echo $sale->sales_quantity.' '.$sale->sales_quantity_type ?></td>
										                    		    <td align="">
										                    		     	<?php echo number_format($sale->totalSales,2); ?>
										                    		    </td>
										                    		    <td align="">
										                    		     	<?php echo number_format($sale->totalProfit,2); ?>
										                    		    </td>
										                    		</tr>

					 					                    </tbody> 


					 					                    <?php 
										                    		$tCost   += $sale->totalCost;
										                    		$tSales  += $sale->totalSales;
										                    		$tProfit += $sale->totalProfit;

					 					                    ?>
									                    <?php endforeach ?>
									                    <tfoot>
									                    	<tr>
									                    		<td colspan="5"> </td>
									                    		<td colspan="">  <label class="total"> Total Sales </label> </td>
									                    		<td colspan="">
									                    			<b class="totals">
																		<?php 

																			 
																			if (!is_null($partialPayment)) {
																				echo number_format($partialPayment,2);
																			}
																			else{
																				echo number_format( $invSale->invoice_total_amount,2); 
																			}
																			 
																		?>
																	</b>
									                    		</td>
									                    	</tr>
									                    	<tr>
									                    		<td colspan="5"> </td>
									                    		<td colspan=""><label class="total"> Total Disc% </label> </td>
									                    		<td colspan=""><b class="totals"><?php echo number_format( $invSale->invoice_discount,2); ?></b></td>
									                    	</tr>
									                    	<tr>	
									                    		<td colspan="5"></td> 
									                    		<td colspan=""><label class="total">Total Profit</label></td>
									                    		<td align=""><b class="totals"><?php echo number_format( $tProfit,2); ?></b>
									                    		</td>
									                    	</tr>
									                    </tfoot>
													</table>
													<?php  
														$grandC += $tCost;
														$grandS += $tSales;
														$grandP += $tProfit;
													?>
												<?php endif ?>
									 	<?php } ?>
									<?php endforeach ?>
					                <table class="table table-condensed">
						                <tbody style="background-color: #c5c5c5">
							                <tr>
								                <td colspan="" >
													<h6>Grand Total Cost</h6>
													<h5><b><?php echo '&#8369; '. number_format($grandC,2); ?></b></h5>
								                </td>
								                <td colspan="" >
													<h6>Grand Total Profit</h6>
													<h5><b><?php echo '&#8369; '. number_format($grandP,2) ?></b></h5>
								                </td>
								                <td  class=""> 
													<h6>Grand Total Revenue</h6>
													<h5><b><?php echo '&#8369; '. number_format($grandR,2) ?></b></h5>
								                </td>
								                <td class="" >
								                	<h6>Grand Total Discount</h6>
								                	<h5><b><?php echo '&#8369; '. number_format($grandD,2) ?></b></h5>
								                </td>
								                <td class="" >
								                	<h6>Grand Total Sales</h6>
								                	<h5><b><?php echo '&#8369; '. number_format($grandS,2) ?></b></h5>
								                </td>
							                </tr>
						                </tbody>
						            </table>
								</div>
								<div class="tab-pane fade" id="nav-pills-tab-2">
									<h4>PO Sales Report from: <strong><?php echo date('M. j, Y', strtotime( $data['start'])); ?></strong> to <strong><?php echo date('M. j, Y', strtotime( $data['end'])); ?></strong></h4>
									<hr>
									<?php $grandS = 0; $grandP = 0; $grandC = 0; $grandR = 0; $grandD = 0;?>
									<?php foreach ($data['invoice']['sales'] as $invSale): ?>
									 	<?php Query::select('sales_partial' , ['invoice_id' , '=' , $invSale->invoice_id ]);
									 		if (Query::count()) { ?>
												<table class="table table-condensed">
									                    <thead>
									                    <tr>
									                        <th class="no text-right">INVOICE NO : <?php echo $invSale->invoice_no ?></th>
									                        <th class="desc">Invoice Date: <?php echo date('M. d, Y ', strtotime($invSale->invoice_date.' '.$invSale->invoice_time)) ?></th>
									                    </tr>
									                    </thead>
									            </table>
												<?php 
													$partialPayment = _get_partial_payme_with_invoice($invSale->invoice_id);

												    if (!is_null($invSale->invoice_total_amount)) {
														$grandR += $invSale->invoice_total_amount; 
												    }
												    else{
												    	$grandR += $partialPayment; 
												    }
													$grandD += $invSale->invoice_discount; 
												?>
												<?php
													$count = 1;$total = 0;$tProfit = 0;$tCost = 0; $tSales = 0; 
												 	$daySales   = Query::getSql()->query("
												 						SELECT
												 						sales.sales_quantity,
												 						stockin_summary.stockin_sum_buying_price,
												 						stockin_summary.stockin_sum_selling_price,
												 						barcode.barcode,
												 						product.product_name,
												 						sales.sales_quantity_type,
												 						product.product_subname,
												 						IFNULL(stockin_sum_selling_price * sales_quantity ,0 ) totalSales,
												 						IFNULL((stockin_sum_selling_price * sales_quantity) - (stockin_sum_buying_price * sales_quantity) ,0 ) AS totalProfit,
												 						IFNULL(stockin_sum_buying_price * sales_quantity ,0 ) AS totalCost
												 						FROM
												 						sales
												 						INNER JOIN stockin_summary ON sales.stock_sum_id = stockin_summary.stock_sum_id
												 						INNER JOIN barcode ON stockin_summary.barcode_id = barcode.barcode_id
												 						INNER JOIN product ON barcode.product_id = product.product_id 
												 						WHERE sales.invoice_id  = {$invSale->invoice_id}
												 		          ");
												?>
												<?php if (!empty($daySales)): ?>
													<table class="table table-condensed">
									                    <thead>
										                    <tr style="background-color: #ECECEC">
										                        <th>#SL</th>
										                        <th>Description</th>
										                        <th align="">Buying Price</th>
										                        <th align="">Selling Price</th>
										                        <th align="">Qty</th>
										                        <th class="">Sales</th>
										                        <th class="">Profit</th>
										                    </tr>
									                    </thead>
									                    <?php foreach ($daySales->_result as $sale): ?>
					 					                    <tbody>
										                    		<tr>
										                    		    <td><?php echo $count++; ?></td>
										                    		    <td><b><?php echo ucwords($sale->product_name.' '. $sale->product_subname) ?></b></td>
										                    		    <td align=""><?php echo number_format($sale->stockin_sum_buying_price,2) ?></td>
										                    		    <td align=""><?php echo number_format($sale->stockin_sum_selling_price,2) ?></td>
										                    		    <td align=""><?php echo $sale->sales_quantity.' '.$sale->sales_quantity_type ?></td>
										                    		    <td align="">
										                    		     	<?php echo number_format($sale->totalSales,2); ?>
										                    		    </td>
										                    		    <td align="">
										                    		     	<?php echo number_format($sale->totalProfit,2); ?>
										                    		    </td>
										                    		</tr>

					 					                    </tbody> 


					 					                    <?php 
										                    		$tCost   += $sale->totalCost;
										                    		$tSales  += $sale->totalSales;
										                    		$tProfit += $sale->totalProfit;

					 					                    ?>
									                    <?php endforeach ?>
									                    <tfoot>
									                    	<tr>
									                    		<td colspan="5"> </td>
									                    		<td colspan="">  <label class="total"> Total Sales </label> </td>
									                    		<td colspan="">
									                    			<b class="totals">
																		<?php 

																			 
																			if (!is_null($partialPayment)) {
																				echo number_format($partialPayment,2);
																			}
																			else{
																				echo number_format( $invSale->invoice_total_amount,2); 
																			}
																			 
																		?>
																	</b>
									                    		</td>
									                    	</tr>
									                    	<tr>
									                    		<td colspan="5"> </td>
									                    		<td colspan=""><label class="total"> Total Disc% </label> </td>
									                    		<td colspan=""><b class="totals"><?php echo number_format( $invSale->invoice_discount,2); ?></b></td>
									                    	</tr>
									                    	<tr>	
									                    		<td colspan="5"></td> 
									                    		<td colspan=""><label class="total">Total Profit</label></td>
									                    		<td align=""><b class="totals"><?php echo number_format( $tProfit,2); ?></b>
									                    		</td>
									                    	</tr>
									                    </tfoot>
													</table>
													<?php  
														$grandC += $tCost;
														$grandS += $tSales;
														$grandP += $tProfit;
													?>
												<?php endif ?>
									 	<?php } ?>
									<?php endforeach ?>
					                <table class="table table-condensed">
						                <tbody style="background-color: #c5c5c5">
							                <tr>
								                <td colspan="" >
													<h6>Grand Total Cost</h6>
													<h5><b><?php echo '&#8369; '. number_format($grandC,2); ?></b></h5>
								                </td>
								                <td colspan="" >
													<h6>Grand Total Profit</h6>
													<h5><b><?php echo '&#8369; '. number_format($grandP,2) ?></b></h5>
								                </td>
								                <td  class=""> 
													<h6>Grand Total Revenue</h6>
													<h5><b><?php echo '&#8369; '. number_format($grandR,2) ?></b></h5>
								                </td>
								                <td class="" >
								                	<h6>Grand Total Discount</h6>
								                	<h5><b><?php echo '&#8369; '. number_format($grandD,2) ?></b></h5>
								                </td>
								                <td class="" >
								                	<h6>Grand Total Sales</h6>
								                	<h5><b><?php echo '&#8369; '. number_format($grandS,2) ?></b></h5>
								                </td>
							                </tr>
						                </tbody>
						            </table>
								</div>
							</div>
						</div>
						<div class="col-md-1"></div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
<?php elseif (is_null($data['invoice']['sales'])): ?>
	<div class="profile-container">
		<div class="row">
			<div class="col-md-12">
				<center>
					<h3>No Report Available on Selected Date</h3>
				</center>				
			</div>
		</div>
	</div>
<?php endif ?>

<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>
<script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>

<script>
	$(document).ready(function() {
		// App.init();
		FormPlugins.init();
		FormWizardValidation.init();

		$("#start-date").datepicker({todayHighlight:!0,autoclose:!0 ,format: 'yyyy-mm-dd'}),
		$("#end-date").datepicker({todayHighlight:!0,autoclose:!0,format: 'yyyy-mm-dd'});

		
		$(document).on('click', '#btn-excel-sales', function(){ //table-sales
			$("#table-sales").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: 'sales report' 
            });
        });

		 $(document).on('click', '#excelSales, #printSales', function(){
		 	var $this = $(this);
		 	var start = $('#start-date').val();
		 	var end   = $('#end-date').val();
		 	var url   = "<?php echo Url::route('print_/sales/print?start=') ?>" + start + '=end=' + end;

		 	window.open(url);
		 	// switch($this.attr('id')){
		 	// 	case 'excelSales':
		 				 
		 	// 	break;

		 	// 	case 'printSales':
	   // 			    var popup = window.open(url, "popup", "fullscreen");
	   // 			    if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight)
	   // 			    {
	   // 			      popup.moveTo(0,0);
	   // 			      popup.resizeTo(screen.availWidth, screen.availHeight);
	   // 			    }
		 	// 		// window.open(ur, "_blank");
		 	// 		// location.href = "<?php echo Url::route('reports/sales/print?start=') ?>" + start + '=end=' + end;
		 	// 	break;
		 	// }
		 })
	});
		// $('#generateBtn').trigger('click');
</script>