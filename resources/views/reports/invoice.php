<style>
	.btnPrint button{
		width: 76px !important;
		margin-left: 2px !important;
	}
	.today{
		color: #00acac !important;
		font-weight: bold;
		/*background-color: red;*/
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
                <h4 class="panel-title">Invoice Reports</h4>
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
		                <form class="form-horizontal form-condensed" action="<?php echo Url::route('reports/invoice_order') ?>" method="POST" data-parsley-validate="true" name="form-wizard">
							<div class="form-group">
								<label class="control-label col-md-4">START DATE <span class="text-danger">*</span></label>
								<div class="col-md-8">
                                    <div class="input-group date">
                                    	<input type="text" value="<?php echo Input::get('start') ?>"    name="start" class="form-control" id="start-date" placeholder="Select Start Date" required="" />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">END DATE <span class="text-danger">*</span></label>
								<div class="col-md-8">
							        <div class="input-group date">
                                    	<input type="text" name="end" value="<?php echo Input::get('end') ?>"    class="form-control" id="end-date" placeholder="Select End Date" required="" />
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
		                                	<button class="btn btn-primary btn-block" id="gene">Generate Reports</button>
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
<?php if (!empty($data['invoice']['invoice'])): ?>
	<div class="profile-container">
		<div class="row">
			<div class="col-md-12">
				<div class="profile-container">
					<!-- <div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-9">
						 	<div class="btn-group pull-right btnPrint">
								<button class="btn btn-success btn-sm "><i class="fa fa-file-excel-o"></i> Excel</button>
								<button class="btn btn-primary btn-sm m-l-1"><i class="fa fa-print"></i> Print</button>
							</div>
						</div>
						<div class="col-md-1"></div>
					</div>
					<br> -->
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-1">
	                         <?php echo App::$image->get('images/company/',['width'=>'90'],1); ?>
						</div>
						<div class="col-md-9">
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
								<div class="pull-right">
									<b>No Company Name</b>
								</div>
							<?php endif ?>
						</div>
						<div class="col-md-1"></div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10"><hr style="border: .1px solid lightgray"></div>
					</div>
					
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<h4>Invoice Report from: <strong><?php echo date('M. j, Y', strtotime( $data['start'])); ?></strong> to <strong><?php echo date('M. j, Y', strtotime( $data['end']));; ?></strong></h4>
							<hr>
							<?php foreach ($data['invoice']['invoice'] as $purchase): ?>
								<table class="table table-condensed">
 				                    <thead>
	 				                    <tr>
	 				                        <th class="no text-right">Invoice No :  <b class="text-info"><?php echo $purchase->purchase_no ?></b></th>
	 				                        <th class="no">Supplier :  <b><?php echo ucwords($purchase->supplier_company_name) ?></b></th>
	 				                        <th class="desc">Invoice Date : <b><?php echo date('M. d, Y ', strtotime($purchase->purchase_date)) ?></b></th>
	 				                        <th class="desc">Payment Type :
	 				                        	<b class="label label-<?php echo  ($purchase->purchase_payment_type == 'confirm' ) ? 'success' : 'danger' ; ?>">
	 				                        		<?php echo strtoupper($purchase->purchase_payment_type) ?>
	 				                        	</b>
	 				                        </th>
	 				                    </tr>
 				                    </thead>
 				                </table>

 				                <?php 

 				                	$orderDetails = Query::getSql()->query("
											SELECT
											barcode.barcode,
											product.product_name,
											product.product_subname,
											purchased_details.pur_det_quantity,
											(pur_det_quantity * pur_der_price) AS total_price,
											purchased_details.pur_der_price,
											purchased_details.pur_det_name,
											purchased_details.product_id
											FROM
											purchased_details
											INNER JOIN product ON purchased_details.product_id = product.product_id
											INNER JOIN barcode ON barcode.product_id = product.product_id
											WHERE
											purchased_details.pur_id =  {$purchase->pur_id}
 				                	");

 				                	if ($orderDetails->_count > 0) { ?>
				                			<table class="table table-condensed">
						                    <thead>
							                    <tr style="background-color: #ECECEC">
							                        <th>IO#</th>
							                        <th>Barcode</th>
							                        <th align="center">Description</th>
							                        <th align="center">Buying Price</th>
							                        <th align="center">Qty</th>
							                        <th class="pull-right">TOTAL</th>
							                    </tr>
						                    </thead>
		 					                    <tbody>
		 					                    	<?php $count = 1; $total = 0; ?>
			 				                		<?php foreach ($orderDetails->_result as $ordDetails): ?>
			 				                			<tr>
			 				                				<td><b><?php echo $count++; ?></b></td>
			 				                				<td><b><?php echo $ordDetails->barcode; ?></b></td>
			 				                				<td>
			 				                					<?php 
			 				                						if (!is_null($ordDetails->product_id)) {
				 				                						echo ucwords($ordDetails->product_name.' '.$ordDetails->product_subname); 
			 				                						}
			 				                						else{
			 				                							echo ucwords($ordDetails->pur_det_name);
			 				                						}
			 				                					?>
			 				                				</td>
			 				                				<td><?php echo $ordDetails->pur_der_price; ?></td>
			 				                				<td><?php echo $ordDetails->pur_det_quantity; ?></td>
			 				                				<td><?php echo number_format($ordDetails->total_price,2); ?></td>
			 				                			</tr>
			 				                			<?php $total +=  $ordDetails->total_price?>
			 				                		<?php endforeach ?>
		 					                    </tbody> 
						                    <tfoot>
						                    	<tr>
						                    		<td colspan=""> </td>
						                    		<td colspan=""> </td>
						                    		<td colspan=""> </td>
						                    		<td colspan=""> </td>
						                    		<td ><b>Grand Total</b></td>
						                    		<td align="right">
						                    			<b>
						                    				 <?php 
						                    					echo  number_format($total,2); 
						                    				?> 
						                    			</b>
						                    		</td>
						                    	</tr>
						                    </tfoot>
										</table>
 				                <?php } ?>						 	
							<?php endforeach ?>								 
			                
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php elseif (is_null($data['invoice']['invoice'])) : ?>
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

<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>
<script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>

<script>
	$(document).ready(function() {
		// App.init();
		FormPlugins.init();
		FormWizardValidation.init();

		$("#start-date").datepicker({todayHighlight:!0,autoclose:!0,format: 'yyyy-mm-dd'}),
		$("#end-date").datepicker({todayHighlight:!0,autoclose:!0,format: 'yyyy-mm-dd'});


	});
	// $('#gene').trigger('click')
</script>