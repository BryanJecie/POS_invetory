<style>
	.ul-stock-status {
		margin-left: -40px;
	}

	.ul-stock-status li {
		list-style-type: none;
	}

	#datepicker-inline .today {
		background-color: #00acac !important;
		color: #fff;
		font-size: 20px;
	}
</style>
<?php

$startDate = date("Y-m-1");
$endDate   = date("Y-m-30");

?>
<div class="row">
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-green">
			<div class="stats-icon"><i class="fa fa-arrow-circle-o-left"></i></div>
			<div class="stats-info">
				<h4>TOTAL PRODUCT STOCKIN</h4>
				<p class="stockinP"></p>
			</div>
			<div class="stats-link">
				<a href="javascript:;">
					<center><?php echo date('F'); ?></center>
				</a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-blue">
			<div class="stats-icon"><i class="fa fa-arrow-circle-o-right"></i></div>
			<div class="stats-info">
				<h4>TOTAL PRODUCT STOCKOUT</h4>
				<p class="stockOutP"></p>
			</div>
			<div class="stats-link">

				<a href="javascript:;">
					<center><?php echo date('F'); ?></center>
				</a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-purple">
			<div class="stats-icon"><i class="fa fa-money"></i></div>
			<div class="stats-info">
				<h4>TOTAL PRODUCT SALES</h4>
				<p class="totaSales"></p>
			</div>
			<div class="stats-link">
				<a href="javascript:;">
					<center><?php echo date('F'); ?></center>
				</a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-red">
			<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
			<div class="stats-info">
				<h4>TOTAL SALES FOR TODAY</h4>
				<p class="salesNow"></p>
			</div>
			<div class="stats-link">
				<a href="javascript:;">
					<center><?php echo date('F d, Y, D'); ?></center>
				</a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
</div>
<!-- end row -->
<!-- begin row -->
<div class="row">
	<!-- begin col-8 -->
	<div class="col-md-8">
		<?php if (!empty($data['orders']) and is_array($data['orders'])) : ?>
			<div class="panel panel-inverse" data-sortable-id="index-1">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
					</div>
					<h4 class="panel-title">RECENT CUSTOMER'S PURCHASED ORDER (C.P.O)</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-order">
						<thead style="background-color:#ececec">
							<tr>
								<th>Order ID</th>
								<th>Customer's Name</th>
								<th>Date</th>
								<th>Status</th>
								<th style="text-align: left">Total</th>
								<th style="text-align: right">action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data['orders'] as $order) : ?>

								<?php
										Query::select('order_details', [
											'details_order_id', '=', $order->order_id
										]);
										$sumTotal = 0;
										if (Query::count()) {
											foreach (Query::result() as $total) {
												$sum = $total->details_order_quantity * $total->details_order_price;
												$sumTotal += $sum;
											}
										}
										?>
								<tr class="odd gradeX">
									<td><span class="text-success"><b><?php echo $order->order_no ?></b></span></td>
									<td><b><?php echo ucwords($order->custom_lastname . ' ' . $order->custom_firstname) ?></b></td>
									<td><?php echo date('M. j, Y', strtotime($order->order_date)); ?></td>
									<td>
										<label class="label label-<?php echo ($order->order_payment_status == 'unpaid') ? 'danger' : 'success'; ?>">
											<?php echo strtoupper($order->order_payment_status) ?>
										</label>
									</td>
									<td align="left"><b><?php echo  number_format($sumTotal, 2) ?></b></td>
									<td align="right"><a href="<?php echo Url::route('orders/view_invoice_order/?ordId=') . $order->order_id ?>" class="btn btn-white btn-sm"><i class="fa fa-search fa-xs"></i><small>VIEW</small></a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php endif ?>

		<?php if (!empty($data['purchase']) and is_array($data['purchase'])) : ?>
			<div class="panel panel-inverse" data-sortable-id="index-1">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
					</div>
					<h4 class="panel-title">RECENT SUPPLIER INVOICE</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-order">
						<thead style="background-color:#ececec">
							<tr>
								<th>Purchase No</th>
								<th>Suppllier</th>
								<th>Date</th>
								<th>Status</th>
								<th style="text-align: left">Total</th>
								<th style="text-align: right">action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data['purchase'] as $order) : ?>
								<tr class="odd gradeX">
									<td><span class="text-success"><b><?php echo $order->purchase_no ?></b></span></td>
									<td><b><?php echo ucwords($order->supplier_company_name) ?></b></td>
									<td><?php echo date('M. j, Y', strtotime($order->purchase_date)); ?></td>
									<td>
										<label class="label label-<?php echo ($order->purchase_payment_status == 'unpaid') ? 'danger' : 'success'; ?>">
											<?php echo strtoupper($order->purchase_payment_status) ?>
										</label>
									</td>
									<td align="left"><b><?php echo  number_format($order->purchase_total_amount, 2) ?></b></td>
									<td align="right"><a href="<?php echo Url::route('supplier/view_manage_invoice/') . $order->pur_id ?>" class="btn btn-white btn-sm"><i class="fa fa-search fa-xs"></i><small>VIEW</small></a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php endif ?>

		<div class="panel panel-inverse" data-sortable-id="index-6">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
				</div>
				<h4 class="panel-title">Top 5 Selling Product for <?php echo date('F'); ?></h4>
			</div>
			<div class="panel-body p-t-0">
				<table class="table table-valign-middle m-b-0">
					<thead>
						<tr>
							<th>#SL</th>
							<th>BARCODE</th>
							<th>Product Name</th>
							<th><b>Qty.</b></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1; ?>
						<?php if ($data['salesMonth']) : ?>
							<?php foreach ($data['salesMonth'] as $sale) : ?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><b><?php echo $sale->barcode; ?></b></td>
									<td><?php echo ucwords($sale->product_name); ?></td>
									<td><?php echo $sale->totalSales; ?></td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- end col-8 -->
	<!-- begin col-4 -->
	<div class="col-md-4">
		<div class="panel panel-inverse" data-sortable-id="index-10">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
				</div>
				<h4 class="panel-title">Calendar</h4>
			</div>
			<div class="panel-body">
				<div id="datepicker-inline" class="datepicker-full-width">
					<div></div>
				</div>
			</div>
		</div>
		<div class="panel panel-inverse" data-sortable-id="index-6">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
				</div>
				<h4 class="panel-title">Top 5 Selling Product <?php echo date('Y'); ?></h4>
			</div>
			<div class="panel-body p-t-0">
				<table class="table table-valign-middle m-b-0">
					<thead>
						<tr>
							<th>#SL</th>
							<th>Product Name</th>
							<th><b>Qty</b></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1; ?>
						<?php if (!is_null($data['salesYear'])) : ?>
							<?php foreach ($data['salesYear'] as $sYear) : ?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo ucwords($sYear->product_name) ?></td>
									<td><b><?php echo ucwords($sYear->TotalQuantity) ?></b></td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- end col-4 -->
</div>
<!-- end row -->


<?php include RES_PATH . 'views/js/dashboard.php'; ?>