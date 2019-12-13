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
                <h4 class="panel-title">Sales Summary Reports</h4>
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
		                <form class="form-horizontal form-condensed" action="<?php echo Url::route('reports/sales_summary_report') ?>" method="POST" data-parsley-validate="true" name="form-wizard">
							<div class="form-group">
								<label class="control-label col-md-4">START DATE <span class="text-danger">*</span></label>
								<div class="col-md-8">
                                    <div class="input-group date">
                                    	<input type="text" name="start" class="form-control" value="<?php echo Input::get('start') ?>" id="start-date" placeholder="Select Start Date" required="" />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">END DATE <span class="text-danger">*</span></label>
								<div class="col-md-8">
							        <div class="input-group date">
                                    	<input type="text" name="end" class="form-control" value="<?php echo Input::get('end') ?>" id="end-date" placeholder="Select End Date" required="" />
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
		                                	<button class="btn btn-primary btn-block" id="generateReprts">Generate Reports</button>
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
<?php if ($data['key']): ?>
	<?php if (!is_null($data['sumSales'])): ?>
		<div class="profile-container">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<div class="profile-container">
								<table id="stock-reports" class="table table-striped table-bordered">
								    <thead>
								        <tr class="active">
								            <th><b>#SS</b></th>
								            <th><b>INVOICE NO</b></th>
								            <th><b>INVOICE DATE</b></th>
								            <th><b>STATUS</b></th>
								            <th><b>TOTAL DISCOUNT</b></th>
								            <th><b>TOTAL SALES</b></th>
								            <th><b>TOTAL PROFIT</b></th>
								        </tr>
								    </thead>
								    <tbody>
								        <?php $count = 1;  
					       					foreach ($data['sumSales'] as $sale) { ?>
												<tr>
													<td><?php echo $count++; ?></td>
													<td><?php echo $sale->invoice_no ?></td>
													<td><?php echo date('M. j, Y', strtotime(  $sale->invoice_date)) ?></td>
													<td>
														<label class="label label-<?php echo ($sale->invoice_status === 'orders') ? 'primary' : 'success' ?>">
															<?php echo strtoupper($sale->invoice_status) ?>
														</label>
													</td>
													<td><b><?php echo number_format($sale->invoice_discount,2) ?></b></td>
													<td>
														<b>
															<?php 
																if (!is_null($sale->invoice_total_amount)) {
																	echo number_format($sale->invoice_total_amount,2);
																}
																else{
																	echo number_format(_get_partial_payme_with_invoice($sale->invoice_id),2);
																}
															?>
														</b>
													</td>
													<td>
														<?php 
															$profits = Query::getSql()->query("
																	SELECT
																	SUM(IFNULL(stockin_summary.stockin_sum_selling_price * sales.sales_quantity - stockin_summary.stockin_sum_buying_price * sales.sales_quantity,0))  as total_profit
																	FROM
																	sales
																	INNER JOIN stockin_summary ON sales.stock_sum_id = stockin_summary.stock_sum_id
																	WHERE
																	sales.invoice_id = {$sale->invoice_id}
																")->get();
															if ($profits->total_profit > 0) {
																echo '<b>'.number_format($profits->total_profit,2).'</b>';
															}
															else{
																echo "-";
															}
														?>
													</td>
												</tr>
						       			<?php } ?>
								    </tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php else : ?>
		<div class="profile-container">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<div class="profile-container">
									 <center>
									 	<h3>No Data Available !</h3>
									 </center>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php endif ?>
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

		var handleDataTableButtons=function(){
				"use strict";0!==$("#stock-reports").length&&$("#stock-reports").DataTable({
					sort : false,
					dom:"Bfrtip",
						buttons:[
							{
								extend:"copy",className:"btn-sm"},
							{
								extend:"csv",className:"btn-sm"},
							// {
							// 	extend:"excel",className:"btn-sm"},
							{
								extend:"pdf",className:"btn-sm"},
							{
								extend:"print",className:"btn-sm"}
						],
						responsive:!0
					}
				)},
			TableManageButtons=function(){
				"use strict";
				return{
					init:function(){
						handleDataTableButtons();
					}
				};
			}();
		TableManageButtons.init();

		$("#start-date").datepicker({todayHighlight:!0,autoclose:!0,format: 'yyyy-mm-dd'}),
		$("#end-date").datepicker({todayHighlight:!0,autoclose:!0,format: 'yyyy-mm-dd'});
		// $('#generateReprts').trigger('click');
	});
</script>