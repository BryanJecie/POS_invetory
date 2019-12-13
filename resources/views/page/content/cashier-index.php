<style type="text/css">
	#datepicker-inline .today{
		background-color:#00acac !important;
		color: #fff; 
		font-size: 16px;
	}
	.search-product-input{
		font-size: 16px;
	}
	.search-product-input{
		height: 40px !important;
		font-size: 16px !important;
	}
	#data-table_filter label input{
		/*position: absolute;*/
		margin-left: -157px !important;
	}
	.tableTempPurchase .tempPurName{
		width: 400px !important;
	}
</style>

<div class="vertical-box" >
    <div class="vertical-box-column bg-white" style="">
        <div class="wrapper bg-silver-lighter clearfix" style="" >
    		<div class="row">
    			<div class="col-md-10">
                    <select class="combobox input-lg search-product-input bg-white " id="search-product-input">
	                    <option value="">Select Product</option>
	                    <?php if (!is_null($data['products'])): ?>
	                    	<?php foreach ($data['products'] as $prod): ?>
	                    		<?php $prodInfo = ''; ?>
	                    		<?php if ($prod->barcode !== "" AND !is_null(($prod->barcode))): ?>
		                    		<?php 
		                    			$prodInfo  = '['.$prod->barcode.']'.'&nbsp;&nbsp;&nbsp;&nbsp;';
		                    			$prodInfo .= ucwords($prod->product_name).'&nbsp;&nbsp;&nbsp;&nbsp;';
		                    			$prodInfo .= $prod->stockin_sum_selling_quantity.$prod->stockin_sum_selling_type.'&nbsp;&nbsp;&nbsp;&nbsp;';
		                    			$prodInfo .= 'Php : <b>'.$prod->stockin_sum_selling_price.'</b>&nbsp;&nbsp;&nbsp;&nbsp;'; 
		                    		?>
		                    		<option value="<?php echo $prod->product_id ?>" data-quantity="<?php echo $prod->stockin_sum_selling_quantity ?>">
		                    			<?php echo $prodInfo ?>
		                    		</option>
	                    		<?php endif ?>
	                    		
	                    	<?php endforeach ?>
	                    <?php endif ?> 
	                </select> 
    			</div>
    		</div>
        </div>
        <div class="wrapper">
           <div class="row">
           	   <div class="col-md-5">
           	    	<div class="row">
           	    		<div class="col-md-12">
           	    			<div class="input-group" style="margin-top: -5px;">
           	    			<!-- <form action="cashier-index_submit" method="get" accept-charset="utf-8"> -->
	                        	<input type="text" id="search-customers" class="form-control" placeholder="Search Customers">
	                            <span  class="input-group-addon" id="cmdCustomer" style="background-color: #348fe2; cursor: pointer;">
									<i class="fa fa-user-plus" style="color:#fff"></i>
	                        	</span>
           	    			<!-- </form> -->
	                     </div>
           	    		</div>
           	    	</div>
           	    	<div class="height2"></div>
           	    	<div class="row">
           	    		<div class="col-md-12">
           	    			<h3>
           	    				<i class="fa fa-user"></i> CUST : 
           	    				<span class="pos-customer text-info" style="text-transform: uppercase;">Customer</span>
					            <input type="hidden" name="" id="customNo">
					            <input type="hidden" name="" id="customDisc">
           	    			</h3>
           	    		</div>
           	    	</div>
           	   </div>
           	   <div class="col-md-5"> <!-- data-table -->
	           	   <table id="data-table" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th>Barcode</th>
                           <th>Stock In</th>
                           <th>Stock Out</th>
                           <th>Stock Price</th>
                        </tr>
                     </thead>
                     <tbody>
                        
                     </tbody>
                  </table>
           	   </div>
           	   <div class="col-md-2">
					<div class="height1"></div>
					<p class="">
						<a href="<?php echo Url::route('index/userLock/lock?userId='.App::$auth->data()->user_id.' ') ?>" id="btn-lock" class="btn btn-primary btn-lg btn-block">
		         		  <i class="fa fa-lock"></i>
		         		</a>
		         		<!-- <a href="<?php echo Url::route('index/userLock/lock?userId='.App::$auth->data()->user_id.' ') ?>" id="btn-lock" class="btn btn-primary btn-lg pull-right">
		         		  <i class="fa fa-lock"></i>
		         		</a> -->
					</p>
					<div class="height1"></div>
					<p>
						<a href="#return-modal" class="btn btn-warning btn-lg btn-block btn-return" id="btn-return" data-toggle="modal">RETURN</a>
					</p>
					<!-- <p>
						<a href="#modal-without-animation" id="btn-113" class="btn btn-success btn-lg btn-block btn-pay"  disabled="disabled">
							PAY<small> (F2)</small>
						</a>
					</p> -->
					<div class="height1"></div>
           	    </div>
       	    	<div class="col-md-10">
           	        <h4 style="position: absolute; margin-top: -10px;" class="text-danger" id="unavailable"> </h4>
	       	    	<table id="table-purchased" class="tableTempPurchase table table-striped">
	       	    	    <thead>
	       	    	    	<tr class="bg-info" >
	       	    	    		<th class="tempPurName">NAME</th>
	       	    	    		<th class="tempPurBarcode pull-right" style="text-align: right">BARCODE</th>
	       	    	    		<th class="tempPurQuantity" style="">QUANTITY</th>
	       	    	    		<th class="tempPurPrice">DISC%</th>
	       	    	    		<th class="tempPurPrice"><span class="pull-right">PRICE</span></th>
	       	    	    		<th style="text-align:right"><small>ACTION</small></th>
	       	    	    	</tr>
	       	    	    </thead>
	       	    	    <tbody class="tempPurchased"></tbody>
	       	    	</table>
	           	</div>
	           	<div class="col-md-2">
						<div class="height1"></div>
						<p>
							<!-- <a href="javascript:;" class="btn btn-primary btn-lg btn-block">
							 	<i class="fa fa-refresh"></i> <small>RELOAD <small style="font-size: 10px;">(F5)</small></small>
							</a> -->
							<!-- <a href="#cash-in-modal" class="btn btn-success btn-lg btn-block" data-toggle="modal">
								<small>Cash In / Out</small>
							</a> -->
							<a href="#sales-modal" class="btn btn-success btn-lg btn-block" id="btnSales" data-toggle="modal">
								 <small> Sales</small>
							</a>
							<a href="#customer" class="btn btn-success btn-lg btn-block" data-toggle="modal">
								<i class="fa fa-user-plus"></i><small class=""> Customer</small>
							</a>
							<!-- <a href="javascript:;" class="btn btn-success btn-lg btn-block">
								<small>Function</small>
							</a> -->
							<a href="#modalCancel" class="btn btn-danger btn-lg btn-block btnCancel" id="btn-120" data-toggle="modal" disabled="">
								<small>CANCEL <small>(F9)</small></small>
							</a>
						</p>
						<div class="height1"></div>
           	    </div>
	           	<div class="col-md-5"></div>
	           	<div class="col-md-5" style="height: 170px;">
	           		<table class="table tbl-total">
	           	    		<thead >
	           	    			<tr>
	           	    				<th class="text-total" style="font-size: 16px; font-weight: 700; ">SUB TOTAL</th>
	           	    				<th class="text-total" style="text-align: right;font-size: 18px; font-weight: 700; ">
	           	    					<span id="sum-total">0.00</span>
	           	    					<small style="font-size: 14px;  ">&#8369;</small> 
	           	    				</th>
	           	    			</tr>
	           	    		</thead>
	           	    		<tbody>
	           	    			<tr>
	           	    				<td class="sub-text-total" >Total Qty Sold</td>
	           	    				<td class="sub-text-total"  style="text-align: right; font-size: 14px">
	           	    					<span id="totalQty" class="text-danger"></span>
	           	    				</td>
	           	    			</tr>
	           	    			<tr>
	           	    				<td class="sub-text-total" >Total Disc %</td>
	           	    				<td class="sub-text-total"  style="text-align: right;font-size: 14px">
										<span id="display-total-disc">0.00</span>
	           	    				</td>
	           	    			</tr>
	           	    			<tr>
	           	    				<td class="sub-text-total" >NET</td>
	           	    				<td class="sub-text-total"  style="text-align: right;font-size: 14px">0.00</td>
	           	    			</tr>
	           	    			<tr>
	           	    				<td class="sub-text-total" >TAX</td>
	           	    				<td class="sub-text-total" style="text-align: right;font-size: 14px">0.00</td>
	           	    			</tr>
	           	    		</tbody>
           	    	</table>
	           	</div>
           </div>
           <!-- <div class="col-md-2"></div> -->
        </div>
    </div>
</div>
 
<?php include RES_PATH.'asset/include_files_cashier_js.php'; ?>

<?php include RES_PATH.'views/page/modal/cashierModal.php'; ?>

<?php include RES_PATH.'views/js/cashierJS.php'; ?>



<script>
	var jbase_url = "<?php echo Url::route() ?>";
	$(document).ready(function(){
		var doc = $(document);

		App.init();
		TableManageFixedColumns.init();
		FormPlugins.init();
		// TableManageKeyTable.init();

		var tablePurchasesd = function(){
			"use strict";
			0!==$("#table-purchased").length&&$("#table-purchased").DataTable({
					searching:false,
					sort:false,
					scrollY:300,
					paging:!1,
					autoWidth:!0,
					// keys:!0,
					responsive:!0,

				})},
			talbleManage = function(){
				"use strict";
				return {
					init:function()
					{
						tablePurchasesd()
					}
				}
		}();

		talbleManage.init();
		/*==================================*/

		var handleDataTableColReorder = function(){
			"use strict";0!==$("#table-customer").length&&$("#table-customer").DataTable({
				colReorder:!0,responsive:!0
			});
		},
		TableManageColReorder = function(){ 
			"use strict";
			return{
				init:function(){
					handleDataTableColReorder();
				}
			};
		}();

		TableManageColReorder.init();
		


		// setTimeout(function(){$('#btnSales').trigger('click')},100);

		doc.on('click', '.search-product-input',function(){$(this).siblings('span').trigger('click'); });
		
		$('.dropdown-menu').addClass('col-md-11');
	});

	$(document).ready(function(){
		$('#remain-tbl tr td').click(function(){
			$(this).removeClass('focus');
		});

		$('#remain-tbl td').trigger('click');

		$('#remain-tbl').removeClass('focus');

		$('#remain-tbl td').click(function(){
		 	$(this).removeClass('focus');
		});
	});


	getInventory();
	function getInventory() {
		$.ajax({
			url: "<?php echo Url::route('ajax/loadInventory') ?>",
			type: 'POST',
			dataType: 'JSON',
			data: { action : 'get' },
		})
		.done(function(data) {
		   if (data.key) {
		       $('#data-table').DataTable().clear().draw();
			   $('#data-table').DataTable().rows.add(data.item);
			   $('#data-table').DataTable().columns.adjust().draw();
		   }
		});
	}

	$(document).on('click','#search-customer, #search-product',function(){
	});

	$('#btn-add').click(function(){
		var url = "<?php echo Url::route('page/') ?>";
		window.open(url, "_blank", "toolbar=1, scrollbars=1, resizable=1, width=" + 1015 + ", height=" + 800);
	});
	// $('#data-table_wrapper label input').addAttr('placeholder','ss')
</script>





