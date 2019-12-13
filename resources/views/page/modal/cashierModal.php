<style type="text/css">
	.inp-q-ret{
		width: 70px !important;
	}
	.sales-status{
		font-size: 14px !important;
		position: absolute;
		font-weight: lighter;
		margin-top: 3px !important;
		padding: 10px;
		margin-left: -10px;
		/*line-height: 10px;*/
	}
	.modal-opacity{
		background-color: rgba(000,000,000,0.5);
	}

	.checkbox label:after, 
	.radio label:after {
	    content: '';
	    display: table;
	    clear: both;
	}

	.checkbox .cr,
	.radio .cr {
	    position: relative;
	    display: inline-block;
	    border: 1px solid #a9a9a9;
	    border-radius: .25em;
	    width: 1.3em;
	    height: 1.3em;
	    float: left;
	    margin-right: .5em;
	}

	.radio .cr {
	    border-radius: 50%;
	}

	.checkbox .cr .cr-icon,
	.radio .cr .cr-icon {
	    position: absolute;
	    font-size: .8em;
	    line-height: 0;
	    top: 50%;
	    left: 20%;
	}

	.radio .cr .cr-icon {
	    margin-left: 0.04em;
	}

	.checkbox label input[type="checkbox"],
	.radio label input[type="radio"] {
	    display: none;
	}

	.checkbox label input[type="checkbox"] + .cr > .cr-icon,
	.radio label input[type="radio"] + .cr > .cr-icon {
	    transform: scale(3) rotateZ(-20deg);
	    opacity: 0;
	    transition: all .3s ease-in;
	}

	.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
	.radio label input[type="radio"]:checked + .cr > .cr-icon {
	    transform: scale(1) rotateZ(0deg);
	    opacity: 1;
	}

	.checkbox label input[type="checkbox"]:disabled + .cr,
	.radio label input[type="radio"]:disabled + .cr {
	    opacity: .5;
	}
</style>


<div class="modal modal-opacity" id="modalCancel" data-backdrop="">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #ff5b57">
				<!-- <button type="button" class="pull-right btn-xs btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button> -->
				<h4 class="modal-title" style="color:#000"><i class="fa fa-warning"></i> warning</h4>
			</div>
			<div class="modal-body">
				<p>
					<h4>Are you sure you want to cancel order ?</h4>
				</p>
			</div>
			<div class="modal-footer">
				<div>
					<a href="javascript:;" class="btn  btn-md  btn-white pull-left" data-dismiss="modal">Cancel</a>
					<a href="javascript:;" class="btn btn-md  btn-success pull-right" id="purchaseCancel" data-dismiss="modal">Ok</a>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.returnQuantity{
		width: 35%!important;
	}
	#form-return tr td{
		cursor: pointer;
	}
</style>
<!-- #modal-without-animation -->
<div class="modal" id="return-modal" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<form action="<?php echo Url::route('ajax/postReturn') ?>" id="form-return" method="POST" accept-charset="utf-8">
			<div class="modal-content">
				<div class="modal-header bg-warning">
					<button type="button" class="pull-right btn-xs btn btn-danger" id="item-return-x" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
					<button type="submit" class="btn btn-info pull-right btn-sm" id="btn-return-save" style="margin-right: 20px;"  disabled="">Return Save</button>
					<h5 class="modal-title">RETURN <b class="text-primary" id="sin-no" style="font-size: 16px"></b></h5>
				</div>
				<div class="modal-body">
					<h5>Search here</h5>
					<div class="input-group">
                        <input autofocus="on" autocomplete="off" type="text" class="form-control" id="item-return" onkeyup="getReturnProduct(this.value)" placeholder="Enter Item Invoice No.">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success btn-return-search" id="return-search"  disabled> 
								<i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
					<br>
					<div class="return-details">
					 	<table class="table table-basic">
					 		<thead>
					 			<tr>
					 				<th>VOID</th>
					 				<th>NAME</th>
					 				<th>BARCODE</th>
					 				<th class="text-center">QTY</th>
					 			</tr>
					 		</thead>
					 		<tbody class="tbl-search-return"></tbody>
					 	</table>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		var doc = $(document);

		doc.on('click','#btn-return-cancel, #item-return-x',function(){
	 		$('.return-desc').html(null);
	 		$('.tbl-search-return').html(null);
		    $('.btn-return-search').attr('disabled','disabled');
		    $('#btn-return-save').attr('disabled','disabled');
	 		$('#item-return').val(null);
	 		$('#sin-no').text("");
	 	});

	 	doc.on('click','#return-search',function(){
			var value = $('#item-return').val();
	 		$.ajax({
	 				url: "<?php echo Url::route('ajax/searchReturnProduct') ?>",
	 				type: 'POST',
	 				dataType: 'JSON',
	 				data: { value : value}
	 			})
	 			.done(function(data) {
	 				if (data.key === true) {
	 					$('#sin-no').text(data.invno);
	 					$('.tbl-search-return').show().html(data.list);
	 					$('#btn-return-save').removeAttr('disabled');
	 				}
	 				else{
	 					$('#sin-no').text("");
	 					$('.tbl-search-return').show().html(data.list);
	 					$('#btn-return-save').removeAttr('disabled');
	 					$('#btn-return-save').attr('disabled','disabled');
	 				}
	 			});	
	 	});

		doc.on('click','.checkbox-return', function(event){
			var $this    = $(this);
			var $parent  = $this.parent().parent().parent();
			
			if ($this.is(':checked')) {
				$parent.siblings('td').find('.ret-qty').removeAttr('disabled');
				$parent.siblings('td').find('.salesQty').removeAttr('disabled');
				$parent.siblings('td').find('.sumId').removeAttr('disabled');
				$parent.siblings('td').find('.invoiceId').removeAttr('disabled');
				$parent.siblings('td').find('.product').removeAttr('disabled');
				$parent.siblings('td').find('.barcode').removeAttr('disabled');
				$parent.siblings('td').find('.qtyType').removeAttr('disabled');
			}
			else{
				$parent.siblings('td').find('.ret-qty').attr('disabled', true);
				$parent.siblings('td').find('.qtyType').attr('disabled', true);
				$parent.siblings('td').find('.invoiceId').attr('disabled', true);
				$parent.siblings('td').find('.product').attr('disabled', true);
				$parent.siblings('td').find('.barcode').attr('disabled', true);
				$parent.siblings('td').find('.salesQty').attr('disabled', true);
				$parent.siblings('td').find('.sumId').attr('disabled', true);
				$parent.siblings('td').find('.ret-qty').val($parent.siblings('td').find('.ret-qty').attr('cqty'));
			}
		});
		 

		doc.on('focusout','.returnQuantity', function(){
			var $this =  $(this);
		});
	});

	function getReturnProduct(value) {
		if (value.length > 1){
		   $('.btn-return-search').removeAttr("disabled");
		}
		else{
			$('.tbl-search-return').html(null);
	    	$('.btn-return-search').attr('disabled','disabled');
			$('#btn-return-save').attr('disabled','disabled');
				$('.return-desc').html(null);
			   $('#sin-no').text("");
		}
	}
</script>

<!-- #modal-without-animation -->
<div class="modal " id="customer">
	<div class="modal-dialog">
		<div class="modal-content " >
			<div class="panel panel-default" data-sortable-id="ui-general-2" data-init="true">
                <div class="panel-heading">
                    <div class="panel-heading-btn ">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></a>
                    </div>
                    <ul class="nav nav-pills">
						<li class="active"><a href="#nav-pills-tab-1" data-toggle="tab"> 
							<i class="fa fa-user-plus "></i> Add Customer's </a>
						</li>
						<li class="">
							<a href="#nav-pills-tab-2" data-toggle="tab">
								<i class="fa fa-list"></i>  Customer's List 
							</a>
						</li>
					</ul>
                </div>
                <div class="panel-body">
  					<div class="tab-content">
  						<div class="tab-pane fade active in" id="nav-pills-tab-1">
  							<div class="form-group" style="margin-top: -50px;">
                                 <label class="col-md-3 control-label"></label>
                                 <div class="col-md-9">
                               		<h4>Customer's Form</h4> 
                                 </div>
                             </div>
  						    <form class="form-horizontal" action="<?php echo Url::route('page/postCostumer') ?>" method="POST">
  						    	 <div class="form-group">
                                     <label class="col-md-3 control-label">Customer ID  :</label>
                                     <div class="col-md-9">
                                         <input type="text" class="form-control" name="cus_no" value="CTN-<?php echo date('m-y').'-'.$data['id'] ?>" readonly>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label class="col-md-3 control-label">First Name :</label>
                                     <div class="col-md-9">
                                         <input type="text" name="first" class="form-control" placeholder="Enter First Name" required="">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label class="col-md-3 control-label">Last Name : </label>
                                     <div class="col-md-9">
                                         <input type="text" name="last" class="form-control" placeholder="Enter Last Name" required="">
                                     </div>
                                 </div>
                                  <div class="form-group">
                                     <label class="col-md-3 control-label">Email Add : </label>
                                     <div class="col-md-9">
                                         <input type="email" name="email" class="form-control" placeholder="Enter Last Name" required="">
                                     </div>
                                 </div>
                                  <div class="form-group">
                                     <label class="col-md-3 control-label">Phone No : </label>
                                     <div class="col-md-9">
                                         <input type="text" name="phone" class="form-control" placeholder="Enter Last Name" required="">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label class="col-md-3 control-label">Birthdate : </label>
                                     <div class="col-md-9">
                                         <input type="hidden" name="token" value="<?php echo Token::generate() ?>" required="">
                                         <input type="date" name="birthdate" class="form-control">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label class="col-md-3 control-label">Address : </label>
                                     <div class="col-md-9">
 										<textarea name="address" rows="4" class="form-control" placeholder="Enter Address Here"></textarea>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label class="col-md-3 control-label">Discount% :</label>
                                     <div class="col-md-9">
                                         <input type="number" name="discount" class="form-control">
 										<!-- <textarea name="discount" rows="4" class="form-control" placeholder="Enter Address Here"></textarea> -->
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label class="col-md-3 control-label">&nbsp;</label>
                                     <div class="col-md-9">
                                         <!-- <input type="text" name="discount" class="form-control"> -->
 										<button type="submit" class="btn btn-success btn-md"> Save Customer</button>
                                     </div>
                                 </div>
                             </form> 
  						</div> 
  						<div class="tab-pane fade " id="nav-pills-tab-2">
 		 	           	    <table id="table-customer" class="table table-striped table-bordered">
 		 	           	        <thead>
 		 	           	            <tr>
 		 	           	                <th>Fullname</th>
 		 	           	                <th>Birthdate</th>
 		 	           	                <th>Address</th>
 		 	           	            </tr>
 		 	           	        </thead>
 		 	           	        <tbody>
 		 	           	            <?php if (!is_null($data['customers'])): ?>
 		 	           	            	<?php foreach ($data['customers'] as $customer): ?>
 		 	           	            		<tr class="even gradeC">
 		 	           	            		    <td><?php echo ucwords($customer->custom_firstname.' '. $customer->custom_lastname) ?></td>
 		 	           	            		    <td><?php echo ucwords($customer->custom_birthdate) ?></td>
 		 	           	            		    <td><?php echo ucwords($customer->custom_address) ?></td>
 		 	           	            		</tr>
 		 	           	            	<?php endforeach ?>
 		 	           	            <?php endif ?>
 		 	           	            
 		 	           	        </tbody>
 		 	           	    </table>
  						</div>
  					</div>
                </div>
            </div>
		</div>
	</div>
</div>

<!-- #modal-without-animation  CASH IN-->
<div class="modal" id="cash-in-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<button type="button" class="pull-right btn-xs btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
				<h4 class="modal-title"><i class="fa fa-money"></i> CASH TYPE</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="<?php echo Url::route('page/pos') ?>" method="POST">
					<center> <h3>Cash Form</h3> </center>
					<br>
					<div class="form-group">
                        <label class="col-md-3 control-label"><b>Cash Type:</b></label>
                        <div class="col-md-6">
                        	<select name="cash-type" class="form-control">
                        		<option value="in">In</option>
                        		<option value="out">Out</option>
                        	</select>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-3 control-label"><b>Amount:</b></label>
                        <div class="col-md-6">
                            <input type="text" name="amount" class="form-control" placeholder="<?php echo number_format(0,2) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><b>Note:</b></label>
                        <div class="col-md-6">
                        	<input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                            <textarea class="form-control" name="note" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><b>&nbsp;</b></label>
                        <div class="col-md-6">
                            <!-- <textarea class="form-control" rows="4"></textarea> -->
                            <button type="submit" class="btn btn-primary pull-right"> Save</button>
                            <button type="button" data-dismiss="close" class="btn btn-danger pull-right" style="margin-right: 10px !important;"> Cancel</button>
                        </div>
                    </div>
				</form>
			</div>
			<!-- <div class="modal-footer">
				<a href="javascript:;" class="btn btn-md btn-modal-pay btn-success pull-left" data-dismiss="modal">PAY</a>
			</div> -->
		</div>
	</div>
</div>

<!-- #modal-without-animation  CASH IN-->
<div class="modal" id="sales-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<button type="button" class="pull-right btn-xs btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
				<h4 class="modal-title">
					<i class="fa fa-money"></i> 
					SALES TODAY
				    <span class="pull-right text-info" style="margin-right: 10px !important"><?php echo date('M. d, Y') ?></span>
				</h4>
			</div>
			<div class="modal-body">
				<div class="invoice" >
				     <div class="invoice-content" style="margin-top: -25px;">
			            <table id="table-sales" class="table table-bordered table-striped ">
			                 <thead>
			                     <tr class="bg-info">
			                         <th>INVOICE NO</th>
			                         <th>QUANTITY</th>
			                         <th>TIME SALES</th>
			                         <th>STATUS</th>
			                         <th>DISCOUNT</th>
			                         <th style="text-align: center">TOTAL AMOUNT</th>
			                     </tr>
			                 </thead>
			                 <tbody> 
			                 </tbody>
			            </table>
				         <br>
				         <div class="invoice-price">
				             <div class="invoice-price-left">
				                 <div class="invoice-price-row">
				                     <div class="sub-price">
				                         <small>TOTAL QUANTITY OUT:</small>
				                         <span class="gTotalQuantity"></span>
				                     </div>
				                     <div class="sub-price">
				                         <small>TOTAL DISCOUNT(%)</small>
				                         <span class="gTotalDiscount"></span>
				                     </div>
				                 </div>
				             </div>
				             <div class="invoice-price-right">
				                 <small>GRAND TOTAL :</small> 
				                 <span class="gSalesTotal pull-left"></span>
				             </div>
				         </div>
				     </div>
				</div>
			</div>
		</div>
	</div>
</div>

 
<script>
	$(document).ready(function(){
		$('#table-sales').DataTable({
			"lengthChange": false,
			bSort : false,
		});
		setTimeout(function(){

			// $('#btn-return').trigger('click')
		},100)
	});
</script>

