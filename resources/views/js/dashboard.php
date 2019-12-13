<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
?>



<script>
	jQuery(document).ready(function($) {
		var doc = $(document);
		
		setInterval(function(){
			loadStockOutItems();
			loadStockInItems();
			loadTotalSales();
			loadSalesNow();
		},120000);

		loadStockInItems();
		loadStockOutItems();
		loadTotalSales();
		loadSalesNow();
	});

	function loadStockInItems() {
		$('.stockinP').text("");
		$.ajax({
			url: "<?php echo Url::route('ajaxdashboard/setStockintItems') ?>",
			type: 'POST',
			dataType: 'JSON',
			data: { action : 'get' },
		})
		.done(function(data) {
			$('.stockinP').append(data.in);
		});
	}
	function loadStockOutItems() {
		$('.stockOutP').text("");
		$.ajax({
			url: "<?php echo Url::route('ajaxdashboard/setStockOutItems') ?>",
			type: 'POST',
			dataType: 'JSON',
			data: { action : 'get' },
		})
		.done(function(data) {
			$('.stockOutP').append(data.out);
		});
	}
	function loadTotalSales() {
		$('.totaSales').text("");
		$.ajax({
			url: "<?php echo Url::route('ajaxdashboard/setTotalSales') ?>",
			type: 'POST',
			dataType: 'JSON',
			data: { action : 'get' },
		})
		.done(function(data) {
			$('.totaSales').append(data.sales);
		});
	}
	function loadSalesNow() {
		$('.salesNow').text("");
		$.ajax({
			url: "<?php echo Url::route('ajaxdashboard/setSalesNow') ?>",
			type: 'POST',
			dataType: 'JSON',
			data: { action : 'get' },
		})
		.done(function(data) {
			$('.salesNow').append(data.now);
		});
	}
	function loadUnpaidOrder() {
		 // $('.salesNow').text("");
		 $.ajax({
		 	url: "<?php echo Url::route('ajaxdashboard/setUnpaidOrder') ?>",
		 	type: 'POST',
		 	dataType: 'JSON',
		 	data: { action : 'get' },
		 })
		 .done(function(data) {
		 	
		 	// $('.salesNow').append(data.now);
		 });
	}
</script>