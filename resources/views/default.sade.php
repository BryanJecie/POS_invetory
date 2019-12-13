<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo Config::get('site_name') ?></title>
	<?php echo _link_icon('public/images/icon/logo'); ?>
	<?php if (App::$auth->isLoggedIn() and App::$auth->data()->user_role !== 'cashier') : ?>

		<?php include RES_PATH . 'asset/include_fies_css.php' ?>

		<script>
			function display_c() {
				var refresh = 1000; // Refresh rate in milli seconds
				mytime = setTimeout('display_ct()', refresh);
			}

			function display_ct() {
				var strcount;
				var x = new Date();
				document.getElementById('ct').innerHTML = x.getSeconds();
				tt = display_c();
			}
		</script>

</head>

<body onload="display_ct();">
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- end #header -->
		<?php include_once('includes/header.sade.php') ?>
		<!-- begin #sidebar -->


		<!-- begin #sidebar -->
		<?php include_once('includes/sidebar.sade.php') ?>
		<!-- end #sidebar -->


		<?php include RES_PATH . 'asset/include_files_js.php'; ?>


		<!-- begin #content -->
		<div id="content" class="content <?php echo bodyClass(App::method()); ?>">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;"><?php echo strtoupper(App::controller()) ?></a></li>
				<li>
					<a href="javascript:;">
						<?php
							$method = explode('_', App::method());
							if (!empty($method)) {
								foreach ($method as $meth) {
									echo strtoupper($meth) . ' ';
								}
							} else {
								echo strtoupper(App::method());
							}
							?>
					</a>
				</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h3 class="page-header"><?php echo strtoupper($data['title']) ?></h3>
			<!-- end page-header -->
			<?php (file_exists($content = RES_PATH . 'views/' . $content . '.php')) ? include $content : ''; ?>
			<!-- end row -->

			<?php include_once('includes/footer.sade.php') ?>
			
		</div>
		<!-- end #content -->

		<!-- begin theme-panel -->
		<div class="theme-panel"></div>
		<!-- end theme-panel -->

		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();


			/*Logout if the user not touch the mouse in 1 min.*/
			var timeout;
			document.onmousemove = function() {
				clearTimeout(timeout);
				timeout = setTimeout(function() {
					// 60000 six seconds
					var user_id = "<?php echo App::$auth->data()->user_id ?>";
					$.ajax({
							url: "<?php echo Url::route('index/checkUser') ?>",
							type: 'POST',
							dataType: 'JSON',
							data: {
								user_id: user_id
							},
						})
						.done(function(data) {
							if (data.key === true) {
								window.location = "<?php echo Url::route('index/postLogout') ?>";
							}
						});
				}, 1440000);
				// 1440000 30 mins
			};
		});

		deleteTemp_Order("<?php echo App::Method() ?>");

		function deleteTemp_Order(method) {

			if (method !== 'new_order' && method !== 'new_invoice') {
				$.ajax({
					url: "<?php echo Url::route('ajax/deleteTempOrder') ?>",
					type: "POST",
					// dataType : "JSON" 
				}).done(function(data) {});
			} else {

				return;
			}
		}

		$('.noti-fade').delay(6000).slideUp(1500);
		$('.fade-msg').delay(6000).slideUp(1500);

		/*======= notifacation for pending order =========== */
		jQuery(document).ready(function($) {


			var doc = $(document);
			getPendingOrder();
			getPerdingInvoice();


			setTimeout(function() {
				getPendingOrder();
				getPerdingInvoice();
			}, 60000);

			function getPendingOrder() {
				$('.ulPending').find('.media').html(null);
				$.ajax({
						url: "<?php echo Url::route('ajax/postPerdingOrder') ?>",
						type: 'POST',
						dataType: "JSON",
						data: {
							status: 'pending'
						},
					})
					.done(function(data) {
						if (data.key === true) {
							$(".ulPending li:first-child").after(data.list);
							$("#countPending").show().html('(' + data.count + ')');
							$(".label-count").show().html(data.count);
						} else {
							$("#countPending").show().html('0');
							$(".label-count").show().html('0');
						}
					});
			}

			function getPerdingInvoice() {
				$('.ulPending').find('.media').html(null);
				$.ajax({
						url: "<?php echo Url::route('ajax/postSupplierInvoice') ?>",
						type: 'POST',
						dataType: "JSON",
						data: {
							status: 'pending'
						},
					})
					.done(function(data) {
						if (data.key === true) {
							$(".ulUnpaid li:first-child").after(data.list);
							$("#countUnpaidInvoice").show().html('(' + data.count + ')');
							$(".label-count-invoice").show().html(data.count);
						} else {
							$("#countUnpaidInvoice").show().html('0');
							$(".label-count-invoice").show().html('0');
						}
					});
			}

			doc.on('click', '.notiListSupplier', function() {
				var $this = $(this);
				var purId = $this.find('a').attr('cval');
				$.ajax({
						url: "<?php echo Url::route('ajaxdashboard/setNotification') ?>",
						type: 'POST',
						dataType: 'JSON',
						data: {
							purId: purId,
							purStatus: 'supplier'
						},
					})
					.done(function(data) {
						console.log(data)
						if (data.key === true) {
							location.href = "<?php echo Url::route('supplier/view_manage_invoice/') ?>" + purId;
						}
					});
			});

			doc.on('click', '.notiList', function() {
				var $this = $(this);
				var orderId = $this.find('a').attr('cval');
				$.ajax({
						url: "<?php echo Url::route('ajaxdashboard/setNotification') ?>",
						type: 'POST',
						dataType: 'JSON',
						data: {
							orderId: orderId,
							purStatus: 'orders'
						},
					})
					.done(function(data) {
						if (data.key === true) {
							location.href = "<?php echo Url::route('orders/view_invoice_order/?ordId=') ?>" + orderId;
						}
					});
			});
		});
	</script>

</body>

<?php else : ?>

	<link href="<?php echo Url::route('public/vendor/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo Url::route('public/vendor/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet" />
	<link href="<?php echo Url::route('public/vendor/css/animate.css'); ?>" rel="stylesheet" />
	<link href="<?php echo Url::route('public/vendor/css/style.css'); ?>" rel="stylesheet" />

	<style>
		.lbl-login-title {
			font-weight: 500 !important;
		}
	</style>
	</head>

	<body class="gray-bg">
		<div class="middle-box text-center loginscreen animated fadeInDown">
			<?php (file_exists($content = RES_PATH . 'views/' . $content . '.php')) ? include $content : ''; ?>
		</div>
		<script src="<?php echo Url::route('public/vendor/js/jquery-2.1.1.js'); ?>"></script>
		<script src="<?php echo Url::route('public/vendor/js/bootstrap.min.js'); ?>"></script>
		<script>
			jQuery(document).ready(function($) {

				$('#btn-cashier').click(function() {
					var url = "<?php echo Url::route('pos/index/cashier_login?cashier=' . Hash::make('cashier') . ' ') ?>";
					var popup = window.open(url, "popup", "fullscreen");
					if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight) {
						popup.moveTo(0, 0);
						popup.resizeTo(screen.availWidth, screen.availHeight);
						window.close();
					}

				});
			});

			$('.fade-msg').delay(6000).slideUp(1000);
		</script>
	</body>

<?php endif ?>

</html>

