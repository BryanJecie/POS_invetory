<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
?>


<script src="<?php echo Url::link('public/js/plugins/jquery.auto-complete.js') ?>" type="text/javascript"></script>

<script type="text/javascript">

	
 	function search_c() {
 		$.ajax({
 			url: "<?php echo Url::route('ajax/searchCustomer') ?>",
 			type: 'POST',
 			dataType: 'JSON'
 		})
 		.done(function(data) {
 			 $("#search-product").autocomplete({
 	 		 	source: data.table 
 	 		 });
 		});
 	}

 	// $('#search-product').trigger('click');
 	$('.search-div').hide();
 	function searchFunction(value) {
 		if (value.length > 0) {
 			$('.search-div').slideDown(300, function(){});
 			$.ajax({
 				url: "<?php echo Url::route('ajax/searchProduct') ?>",
 				type: 'POST',
 				dataType: 'JSON',
 				data: { value : value}
 			})
 			.done(function(data) {
 				$('#search-product-body').html("");
 				if (data.key === true) {
 					$.each(data.tr, function(index, val) {
 						$('#search-product-body').append(val);
 					});
 				} else {
 					$('#search-product-body').show().html('<tr><td colspan="5"> <center><h3>No Product Found !</h3></center> </td></tr>');
 				}
 			});	
 		} else {
 			$('.search-div').slideUp(300, function() {
 				
 			});
 		}
 	}

  	function SearchCustomers() {
  		$.ajax({
			url: "<?php echo Url::route('ajax/getCustomerList') ?>",
			type: 'POST',
			dataType: 'JSON',
			// data: { prod_id : prod_id }
		})
		.done(function(data) {
			// console.log(data)
			$("#search-customers").autocomplete({
			 	source:data.names
			});
		});
  	}

	$(document).ready(function(){
		var e   = ["ActionScriptbryan","AppleScript"] ;
		var doc = $(document);
 		
 		SearchCustomers();

 		// $("#search-customers").autocomplete({source:e});

 		doc.on('click', '#cmdCustomer', function(){
 			var customer    = $('#search-customers').val();
 			var stringArr   = customer.split("["); 
 			var customArray = stringArr[1].split("]"); 
 			var totalValue  = $('#totalValue').val();
 			$.post("<?php echo Url::route('ajax/setDiscount') ?>", { customNo : customArray[0] }, function(data) {
 			  
 			 	if (data.key === true) {
 			 		var text      = "";
 			 		var gTotal    = 0;
 			 		var totalDisc = 0;

 			 		$(data.obj).each(function(ind, ele){
 			 			if (ind === data.obj.length - 1) {
 			 				totalDisc  = Math.round((parseFloat(ele) * totalValue));
 			 				gTotal     = (totalValue - totalDisc); 
 			 			}
 			 			else{
 			 				text += ele + ' ';
 			 			}
 			 		});
 			 		 
 			 		$('#customNo').val(customArray[0]);
 			 		$('#customDisc').val(totalDisc);
 			 		$('.pos-customer').text(text);
 			 		getTotalValue();

 			 	}
 			 }, "JSON"); 
 		});

		function getCurrentTotal() { return $('#total-value').val();}
		
		/* ==== Table Purchased process ==== */
	    getPurchaseTable();

		/* ==== Load table List Purchase ==== */
	    function getPurchaseTable() {
	    	$.ajax({
	    		url: "<?php echo Url::route('ajax/getPurchaseList') ?>",
	    		type: 'POST',
	    		dataType: 'JSON',
	    		data: { param1: 'value1' },
	    	})
	    	.done(function(json) {
	    	   if ( json.key === true ) {
		    	   $('.btn-pay').attr('data-toggle','modal');
				   $('.btn-pay').removeAttr('disabled');
				   $('.btnCancel').removeAttr('disabled');
				   $('#input-amount').removeAttr('disabled');
				    $('#total-item').text(json.list.length);
	    	   } 
	    	   else{
	    	   	   $('.btn-pay').attr('disabled',true);
	    	   	   $('.btnCancel').attr('disabled',true);
	    	   	   $('#input-amount').attr('disabled',true);
    	   	   	   $('#btnPayCmd').attr('disabled',true);
    	   	   	   $('#total-item').text(0);
	    	   }
	    	   
		       $('#table-purchased').DataTable().clear().draw();
			   $('#table-purchased').DataTable().rows.add(json.list);
			   $('#table-purchased').DataTable().columns.adjust().draw();
		   	   getTotalValue();
		   	   getInventory();
	    	   
	    	});
	    }

	    getProductLIst();
	    function getProductLIst() {
	    	$.ajax({
	    		url: "<?php echo Url::route('ajax/loadProductLIst') ?>",
	    		type: 'POST',
	    		dataType: 'JSON',
	    		data: { action :  'get'},
	    	})
	    	.done(function(data) {
	    		// console.log(data);
	    		// $('#search-product-input').append(data)
	    		// $(data).each(function(ind, el){
	    		// 	$('#search-product-input').show().html(el)
	    		// 	console.log(el);
	    		// });
	    		// $('#search-product-input').append(data.items)
	    		// console.log(data);
	    	});
	    }

	    $("#purchaseCancel").click(function(){
	    	$.ajax({
	    		url: "<?php echo Url::route('ajax/postCancelPurchase') ?>",
	    		type: 'POST',
	    		dataType: 'JSON',
	    		data: { param : "cancel" },
	    	})
	    	.done(function(data) {
	    		if (data.key === true) {
	    			getPurchaseTable();
	    		}
	    	});
	    });

	    doc.on('click','.btnPurchaseDelete', function(){
	    	var $this   = $(this);
	    	var salesId =  $this.attr('cval');

		   	$.post("<?php echo Url::route('ajax/postDeletePurchase') ?>", { salesId : salesId }, function(data) {
				 	if ( data.key === true ) {
				 		getPurchaseTable();
				 		$('#input-amount').val(null);
				 		$("#changeTotal").show().html("<?php echo number_format(0,2) ?>");
					 	$('#btnPayCmd').attr('disabled',true);

				 	}
				},"JSON");
	    });

		function getTotalValue() {
			var customNo = $('#customNo').val();

			$.ajax({
				url: "<?php echo Url::route('ajax/getTotalValue') ?>",
				type: 'POST',
				dataType: 'JSON',
				data: { action : 'getVal' , customNo : customNo },
			})
			.done(function(data) {
				// console.log(data)
				if (data.key === true) {
					$("#sum-total").show().html(data.total.toFixed(2));
					$("#pay-total").show().html(data.gTotal.toFixed(2));
					$("#display-total-disc").show().html(data.pTotal.toFixed(2));
					$("#totalValue").val(data.gTotal);
					$("#customDisc").val(data.pTotal);
					$("#totalQty").text(data.qty);
				} 
				else {
					$("#sum-total").show().html(data.total);
					$("#pay-total").show().html(data.total);
					$('#input-amount').attr("placeholder","0.00");
					$("#display-total-disc").show().html('0.00');
					$('#totalValue').val(null);
					$("#input-amount").val(null);
					$("#totalQty").text(0);
				}
			});
		}

		$(document).on('focusout', '.discount', function(){
			var $this    = $(this);
			var discVal  = $this.val();
			var salesId = $this.attr('dval');

			if (isNaN(discVal)) {
				$this.val(null);
			}
			$.post("<?php echo Url::route('ajax/postPurchasedDiscount') ?>", { discVal : discVal, salesId : salesId }, function(data) {
				if (data.key === true) {
				 	getPurchaseTable();
				 	$('#input-amount').val(null);
				 	// $('#input-amount').removeAttr('disabled');
				 	$('#btnPayCmd').attr('disabled',true);
				 	$("#changeTotal").show().html("<?php echo number_format(0,2) ?>");
				}
			},"JSON");
		});

		$('#table-purchased').on('keyup','.inputQuantity', function(){
			var $this    = $(this);
		    var salesId  = $this.closest("tr").find(".btnPurchaseDelete").attr('cval');
			var inputVal = $this.val();
           
            if (inputVal  === '0' || inputVal  === "") {
            
            	inputVal = 1;
            }

			$.post("<?php echo Url::route('ajax/postUpdateQuantity') ?>", { inputVal : inputVal, salesId : salesId }, function(data) {
				if (data.key === true) {
				 	getPurchaseTable();
				 	$('#input-amount').val(null);
				 	// $('#input-amount').removeAttr('disabled');
				 	$('#btnPayCmd').attr('disabled',true);
				 	$("#changeTotal").show().html("<?php echo number_format(0,2) ?>");
				}
			},"JSON");
		});

		doc.on('change','#search-product-input', function(){
			var $this    = $(this);
			var prodId   = $this.val();
			var quantity = $this.find('option:selected').data('quantity');

			$('#unavailable').html("");
			$('.combobox').val(null);
			
			if (quantity < 1) {
				$('#unavailable').text('Selected Item is Currently Unavailable. !');
				removeMsg('unavailable');
				return;
			}

			if (prodId !== null && prodId !== "" && typeof(prodId) !== "undefined") {
				$.ajax({
					url: "<?php echo Url::route('ajax/getSelectSearch') ?>",
					type: 'POST',
					// dataType: 'JSON',
					data: { prod_id : prodId},
				})
				.done(function(data) {
					// console.log(data)
					getPurchaseTable();
					$('.display-purchased').append(data.tr);
					$('#input-amount').val(null);
					$('#input-amount').removeAttr('disabled');
					$('#btnPayCmd').attr('disabled',true);
					$("#changeTotal").show().html("<?php echo number_format(0,2) ?>");
					/* == total value ==*/
					$('.icon-remove').trigger('click');
				});
		 	}	 
		 
		});

		/* ==== Submit Pay ====*/
		doc.on('submit', '#formPayment', function(e){
			e.preventDefault();
			var formPay     = $(this).serializeArray();
			var customDisc  = ($("#customDisc").val() !== "") ? $("#customDisc").val() : 0;
			var totalAmount = $("#totalValue").val();
			var reciept     = $("#reciept");

			$.post("<?php echo Url::route('ajax/postPayment') ?>", { formPay : formPay, customDisc : customDisc, totalAmount : totalAmount }, function(data) {
				if ( data.key === true ) {
					getPurchaseTable();
					getNotifacations();
					salesToday();
					$('#change-modal').trigger('click');

					if (reciept.is(':checked')) {
						window.open("<?php echo Url::route('print_/cashier_reciept') ?>/" + data.invId , "_SELF");
					}
				}

			},"JSON");

		});

		/* ==== Submit Return ====*/

		// form-return

		var formReturn = {
	 		beforeSubmit : function(formdata){
		 		if ($('#form-return').serializeArray().length < 1 ) {
 				 	$('#error-return').removeClass('hide');
 				 	setTimeout(function(){
 					 	$('#error-return').addClass('hide');

 				 	},3000);
 				 	return;
		 		}
	 		},
	 		success : function(data){
	 			if (data.key === true) {
	 				getPurchaseTable();
	 				salesToday();
	 				$('#item-return-x').trigger('click');
	 			}
	 		}, dataType: 'JSON',
	 	};
 		$('#form-return').ajaxForm(formReturn);


		 // getNotifacations()
		function getNotifacations() {
			 $.gritter.add({
			 	title:"<span class='text-success'>Payment Transaction Success.</span>",
			 	text:"Thank you for Purchasing our products. Come Again",
			 	image:"<?php echo Url::link('public/images/image/Yes_check.png') ?>",
			 	sticky:false,
			 	// time:"",
			 	class_name:"gritter-light"
			 });
			 return false;
		}

		salesToday();	
		function salesToday() {
			$.ajax({
				url : "<?php echo Url::route('ajax/getSalesToday') ?>",
				type: 'POST',
				dataType : 'JSON',
				data: { action : 'get'},
			})
			.done(function(data) {
				if (data.key === true) {
			       $('#table-sales').DataTable().clear().draw();
				   $('#table-sales').DataTable().rows.add(data.list);
				   $('#table-sales').DataTable().columns.adjust().draw();
				   $('.gTotalQuantity').show().html(data.gSales);
				   $('.gSalesTotal').show().html(data.gTotal);
				   $('.gTotalDiscount').show().html(data.dSales);
				}
			});
		}

 	});
	

	$(function(){
	    $('#search-product-input').autoComplete({
		    minChars: 1,
		    source: function(term, suggest ){
		       $.ajax({
	                url: "<?php echo Url::route('ajax/getProductList') ?>",
	                dataType: "JSON",
	                // data: {
	                //     q: request.term
	                // },
	                success: function( data ) {
	                	var arrayN      = new Array();
	                	var suggestions = [];
	                	
	                	for (var i = 0; i < data.length; i++) {
	                		arrayN.push(data[i].join(data[i]));
	                	}
	                 
	                	for ( i = 0; i < arrayN.length; i++)
	                	    if (~arrayN[i].toLowerCase().indexOf(term)) suggestions.push(arrayN[i]);
	                		suggest(suggestions);
	                }
	           });
		    }
		});
	});

 	
 	function removeMsg(attr) {
 		setTimeout(function(){
 			$('#'+attr).html("");
 		},6000);
 	}


	function getProductList() {
		$.ajax({
			url: "<?php echo Url::route('ajax/getProductList') ?>",
			type: 'POST',
			// dataType: 'JSON',
			data: { action : 'get'},
		})
		.done(function(data) {
			var choices;
			if (data.key === true) {

				$('#search-product-input').autoComplete({
				     minChars: 1,
				     source: function(term, suggest){
				         term = term.toLowerCase();
				         choices = data;

				         var suggestions = [];
				         for (i=0;i<choices.length;i++)
				             if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
				         suggest(suggestions);
				     }
				});
				// console.log(choices)
			}
		});
	}
	function _data(e) {
		return e;
	}
</script>