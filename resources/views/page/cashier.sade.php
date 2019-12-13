<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo Config::get('site_name') ?></title>
	<link rel="stylesheet" href="">
	<?php echo _link_icon('public/images/icon/logo');  ?>
	
	<?php if (App::$auth->isLoggedIn() AND App::$auth->data()->user_role === 'cashier'): ?>
		<?php  include RES_PATH.'asset/include_files_css_cashier.php' ?>
		<script>
			function display_c(){
			    var refresh =1000; // Refresh rate in milli seconds
			    var mytime = setTimeout('display_ct()',refresh);
			}
			function display_ct() {
			    var strcount;
			    var x = new Date();
			    document.getElementById('ct').innerHTML = x.getSeconds();
			    tt = display_c();
			}
		</script>

		</head>
			<body onload="display_ct();" class="hidden-print">
				<?php  include RES_PATH.'asset/include_files_alert.php' ?>
 		 		<div id="page-container" class="fade page-without-sidebar page-header-fixed">
 		 			<!-- begin #header -->
 		 			<div id="header" class="header navbar navbar-inverse navbar-fixed-top">
 		 				<!-- begin container-fluid -->
 		 				<div class="container-fluid" style="">
 		 					<div class="navbar-header" style="width: 150px; margin-left: -15px;">
 		 						<a href="" style="" class="header-time" >
 		 							<span class="time text-info" style="margin-left: 10px !important;">
 		 								<?php echo strtoupper(Company()->comp_abbr) ?><small>&nbsp;POS</small>
 		 							</span>
 		 						</a>
 		 					</div>
 		 					<div class="navbar-header" style="margin-left: 150px; position: absolute; margin-top: 5px;">
 		 						<a href="" style="" class="header-time" >
 		 							<span class="time" style="font-size: 30px !important; ">
 		 								<?php echo date('h:i:'); ?>
 		 								<span id="ct"></span>
 		 								<small class="head-am">&nbsp;<?php echo date('a'); ?></small>
 		 							</span>
 		 						</a>
 		 					</div>
 		 					<a href="<?php echo Url::route('pos/postLogout') ?>" class="btn btn-white btn-md pull-right" style="margin-top: 8px; margin-left: 2px !important;" >
 		 					 	<i class="glyphicon glyphicon-off"></i> <small>LOGOUT </small>
 		 					</a>	
 		 					<a href="#modal-btn-close-pos" class="btn btn-danger btn-md pull-right" id="btn-121" style="margin-top: 8px; margin-left: 2px !important;" data-toggle="modal">
 		 					 	<i class="fa fa-times"></i> <small>CLOSE <small style="font-size: 10px;">(F10)</small></small>
 		 					</a>
 		 					
 		 				 	<a href="<?php echo Url::route('page/pos/user?cashier='.Hash::make(App::$auth->data()->user_id)) ?>" class="btn btn-primary btn-md pull-right" style="margin-top: 8px;" >
 		 					 	<i class="fa fa-refresh"></i> <small>RELOAD <small style="font-size: 10px;">(F5)</small></small>
 		 					</a>
 		 					<ul class="nav navbar-nav navbar-right" style="margin-right: 100px;">
 		 						<li class="dropdown navbar-user" >
 		 							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
 		 								<b class="header-name"><?php echo strtoupper(App::$auth->data()->person_last) ?></b>
 		 							</a>
 		 						</li>
 		 					</ul>
 		 				</div>
 		 				<!-- end container-fluid -->
 		 			</div>
 		 			<!-- end #header -->
	
 		 			<!-- ================== BEGIN PAGE LEVEL JS ================== -->
					<?php  include RES_PATH.'asset/include_files_js_cashier.php' ?>
 		 			<!-- ================== END PAGE LEVEL JS ================== -->
 		 			 
 		 			<!-- end #content -->
 		 			<style>
 		 				.table-condensed tr .today{
 		 					background-color: red !important;
 		 				}
 		 			</style>
 		 			<div id="content" class="content content-full-width" >
 		 				<div class="row">
 		 				    <div class="col-md-1" ></div>

 		 				    <div class="col-md-8" >
 		 				     	<?php (file_exists($content = RES_PATH.'views/'.$content.'.php')) ? include $content : '' ; ?>
 		 				    </div>
 		 				    <div class="col-md-3">
 		 				    	<div class="panel panel-info">
 		 		               <div class="panel-heading">
 		 		                  <div class="panel-heading-btn">
 		 		                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
 		 		                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
 		 		               </div>
 		 		               <h4 class="panel-title"><i class="fa fa-calculator"></i> PAYMENT</h4>
 		 		               </div>
 		 		               <div class="panel-body">
 		 		                  <form action="javascript:;" method="POST" class="formPayment" id="formPayment">
 		 	                        <fieldset>
 		 	                           <legend class="total-label">TOTAL : &nbsp;
 		 	                           	<span class="total-amount text-info" id="pay-total">0.00</span>
 		 	                           	<small style="font-size: 20px; margin-left: 3px;">&#8369;</small>
 		 	                           	<input type="hidden" name="" value="" id='totalValue'>
 		 	                           </legend>
 		 	                           <div class="form-group">
	 	                           		<div class="checkbox pull-right" style=" margin-top: -5px;">
	 	                                    <label>
	 	                                      <input type="checkbox" class="checkbox-return" name="reciept" id="reciept" checked="">
	 	                                      <span class="cr"><i class="cr-icon glyphicon glyphicon-ok text-success"></i></span>
	 	                                      PRINT RECIEPT
	 	                                    </label>
	                                    </div>
 		 	                           </div>
 		 	                           <div class="form-group">
 		 	                            <label for="input-amount">ENTER AMOUNT : </label>
 		 	                           	<input type="text" name="inputPay" class="form-control input-lg pay-input" id="input-amount" placeholder="0.00" disabled autocomplete="off">
 		 	                           </div>
 		 	                           <div class="form-group">
 		 	                              <label for="exampleInputPassword1"> </label>
 		 	                          	  <h3>CHANGE : <span class="text-danger" id="changeTotal">0.00</span><small style="font-size: 18px; margin-left: 3px;">&#8369;</small> </h3>
 		 	                           </div>
	 	                           		<br>
	 	                           		<br>
 		 	                           <button type="submit" class="btn btn-lg btn-success pull-right btn-block btnPayCmd" id="btnPayCmd" disabled>PAY 
 		 	                           	  <small style="font-size: 10px;">(ENTER)</small>
 		 	                           </button>
 		 	                        </fieldset>
 		 	                     </form>
 		 		               </div>
 		 		            </div>
 		 					<!-- <a href="javascript:;" id="add-sticky" class="btn btn-sm btn-primary">Demo</a> -->
 		 			    	<div class="panel panel-info" style="height: 300px;">
 		 		               <div class="panel-heading">
 		 		                   <div class="panel-heading-btn">
 		 		                       <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
 		 		                       <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
 		 		                   </div>
 		 		                   <h4 class="panel-title">
 		 		                   	<i class="fa fa-calendar"></i>
 		 		                   	Calendar
 		 		                   </h4>
 		 		               </div>
 		 		               <div class="panel-body" >
 		 							<div id="datepicker-inline" class="datepicker-full-width" style="margin-top: -15px;">
 		 								<!-- <div style="border:1px solid red;"></div> -->
 		 							</div>
 		 		               </div>
 		 	          		</div>
 		 				</div>
 		 				</div>
 		 			</div>
 		 	        
 		 			<!-- begin scroll to top btn -->
 		 			<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
 		 			<!-- end scroll to top btn -->
 		 		</div>
 		 		<!-- end page container -->
			    <button type="button" class="hide" id="change-modal" data-toggle="modal" data-target="#modal-change">&nbsp;</button>
				<div class="modal" id="modal-change" data-backdrop="false" style="background-color: rgba(0,0,0,.9);">
					<div class="modal-dialog modal-sm" role="document" style="margin-top: 150px;">
						<div class="modal-content">
							<form action="javascript:;" id="form-change">
								<div class="modal-header">
									<h4 class="modal-title">CHANGE <span class="text-danger">*</span></h4>
								</div>
								<div class="modal-body">
									<center>
										 <h2> <span class="text-danger" id="modal-change-display" style="font-size: 50px;">&nbsp;0.00</span> &#x20B1; </h2>
									</center>
								</div>
								<div class="modal-footer">
									<center><button type="submit" class="btn btn-primary" id="modal-change-btn" style="width: 50%">OK <small>(F5)</small></button></center>
								</div>
							</form>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
 		 		<!-- #modal-dialog -->
 		 		<div class="modal modal-close" id="modal-btn-close-pos">
 		 			<div class="modal-dialog">
 		 				<div class="modal-content">
 		 					<div class="modal-header">
 		 						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
 		 						<h4 class="modal-title">Close POS</h4>
 		 					</div>
 		 					<div class="modal-body">
 		 						<div class="alert alert-danger m-b-0 div-msg-alert">
 		 							<h4><i class="fa fa-warning"></i> Warning</h4>
 		 							<p style="font-size: 18px;"> Are you sure you want to close ?</p>
 		 						</div>
 		 						<br>
 		 						<button class="btn btn-danger" id="" data-dismiss="modal">Cancel</button>
 		 						<button class="btn btn-success" id="btn-close">Ok</button>
 		 					</div>
 		 				</div>
 		 			</div>
 		 		</div>
 		 		<script src="<?php echo Url::route('public/assets/plugins/gritter/js/jquery.gritter.js'); ?>"></script>
 		 		<script src="<?php echo Url::route('public/assets/js/ui-modal-notification.demo.min.js'); ?>"></script>
 		 		<script src="<?php echo Url::route('public/assets/js/apps.min.js'); ?>"></script>
 		 		<script src="<?php echo Url::route('public/js/custom/custom.js'); ?>"></script>
 		 		<script>
 		 			$(document).ready(function() {
 		 				App.init();
 		 				// Notification.init();
 		 				
 		 				var doc = $(document);

 		 				/* ==== POST PAYMENTs ==== */
 		 				$('#btn-close').click(function(){
 		 					$.ajax({
 		 						url: "<?php echo Url::route('index/postCashierLogout') ?>",
 		 						type: 'POST',
 		 						dataType: 'JSON',
 		 						data: { user_id : "<?php echo App::$auth->data()->user_id ?>"},
 		 					})
 		 					.done(function(data) {
 		 						if (data.key === true) {
 		 							window.close();
 		 						}
 		 					});
 		 				});

 		 				doc.on('keyup','#input-amount',function(){
 		 					var $this      = $(this);
 		 					var inputValue = $this.val();
 		 					var total      = 0;

 		 					if ( inputValue.length > 0 && !isNaN(inputValue)) {
 		 						var totalValue = $('#totalValue').val();
 		 						total          = (parseFloat(inputValue) - parseFloat(totalValue));
 		 						if (total < 0) {
 		 							$('#changeTotal').show().html("<?php echo number_format(0,2) ?>");
 		 							$('#modal-change-display').show().html("<?php echo number_format(0,2) ?>");
 		 							$('#btnPayCmd').attr('disabled',true);
 		 						} 
 		 						else{
 		 							$('#changeTotal').show().html(total.toFixed(2));
 		 							$('#modal-change-display').show().html(total.toFixed(2));
 		 							$("#btnSubmitPay").removeAttr('disabled');
 		 							$('#btnPayCmd').removeAttr('disabled');
 		 						}
 		 					}
 		 					else{
 		 						$('#changeTotal').show().html("<?php echo number_format(0,2) ?>");
 		 						$('#modal-change-display').show().html("<?php echo number_format(0,2) ?>");
	 		 					$('#btnPayCmd').attr('disabled',true);
 		 					}
 		 				});

 		 				doc.on('click', '#cancelPay', function(){
 		 					$('#input-amount').val(null);
 		 					$('#changeTotal').show().html("<?php echo number_format(0,2) ?>");
 		 				});
 		 			});
 		 			
 		 			$(function() {
 		 				$('#form-change').submit(function(event) {
 		 					event.preventDefault();
 		 					location.reload();
 		 				});
 		 			});
 		 		</script>
			</body>
	<?php else: ?>

		<link href="<?php echo Url::route('public/vendor/css/bootstrap.min.css'); ?>" rel="stylesheet" />
		<link href="<?php echo Url::route('public/vendor/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet" />
		<link href="<?php echo Url::route('public/vendor/css/animate.css'); ?>" rel="stylesheet" />
		<link href="<?php echo Url::route('public/vendor/css/style.css'); ?>" rel="stylesheet" />

		<style>
			.lbl-login-title{
				font-weight: 500 !important;
			}
		</style>
	 	</head>
	 		<body class="gray-bg">
    	     	<div class="middle-box text-center loginscreen animated fadeInDown">
    	 			<style>
    	 			     .logo-title{
    	 			          color: #e6e6e6;
    	 			          font-size: 80px;
    	 			          font-weight: 800;
    	 			          letter-spacing: 1px;
    	 			          margin-bottom: 0;
    	 			     }
    	 			 </style> 
    	 			 <div>
    	 			    <div>
    	 			    <h3 class="logo-title">
    	 			          <?php echo (!empty($data['comps'][0]->comp_abbr)) ? strtoupper($data['comps'][0]->comp_abbr) : null ?>
    	 			        </h3>
    	 			    </div>
    	 			    <br>
    	 			    <h3>Welcome to <?php echo  (!empty($data['comps'][0]->comp_name)) ? ucwords($data['comps'][0]->comp_name) : null ;  ?></h3>
    	 			    <br>

    	 			    <form class="m-t" role="form" method="POST" action="<?php echo Url::route('pos/user_auth/cashier_login?cashier='.Hash::make('cashier').'') ?>">
    	 			       	<button id="btn-cashier-login-close" type="button" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="right" title="Close This Window">
    	 			       	  <i class="fa fa-times"></i> 
    	 			       	</button>
							<br>
    	 			        <div class="input-group">
    	 			             <label class="lbl-login-title"><i class="fa fa-lock"></i> POS Login</label>

    	 			        </div>

    	 			        <div class="input-group">
    	 			            <input type="text" value="<?php echo Input::get('username') ?>" name="username" class="form-control" placeholder="Username" autocomplete="off">
    	 			            <div class="input-group-btn">
    	 			                <button class="btn btn-white dropdown-toggle" type="button"><i class="fa fa-user"></i> </button>
    	 			            </div>
    	 			        </div>
    	 			        <br>
    	 			        <div class="input-group">
    	 			            <input type="password" name="password" class="form-control" placeholder="Password">
    	 			            <div class="input-group-btn">
    	 			                <button class="btn btn-white dropdown-toggle" type="button"><i class="fa fa-lock"></i> </button>
    	 			            </div>
    	 			            <input type="hidden" name="token" value="<?php echo Token::generate() ?>" placeholder="Password">
    	 			        </div>
    	 			        <br>
    	 			        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
						 </form>
						 

    	 			    <?php if (Session::hasFlash()): ?>
    	 			        <div class="alert alert-danger alert-dismissable fade-msg">
    	 			            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    	 			            <b><i class="fa fa-warning"></i> Opps Error !</b>
    	 			            <?php echo ucwords(Session::flash()) ?>
    	 			        </div>
						 <?php endif ?>
						 
						<ul class="list-inline">
							<li>username : <em>cashier</em></li><br>
							<li>password : <em>cashier</em></li>
						</ul>
    	 			</div>
    	     	</div>
    	 		<script src="<?php echo Url::route('public/vendor/js/jquery-2.1.1.js'); ?>"></script>
    	 		<script src="<?php echo Url::route('public/vendor/js/bootstrap.min.js'); ?>"></script>

    	 		<script>
    	 			$(function() {
    	 				$(document).on('click', '#btn-cashier-login-close', function(){
                           window.close();
    	 				});
    	 			});
    	 		</script>
	 		</body>
	<?php endif ?>
	
</html>





























 