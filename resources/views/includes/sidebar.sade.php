<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<div class="image">
							<a href="javascript:;">
								<?php echo App::Image()->get('images/users/', ['class' => 'user-image'], App::$auth->data()->user_id); ?>
							</a>
						</div>
						<div class="info">
							<?php echo ucwords(App::$auth->data()->person_first . ' ' . App::$auth->data()->person_middle[0] . '. ' . App::$auth->data()->person_last) ?>

							<small>
								<i class="fa fa-circle" style="color:green"></i>
								<?php echo ucwords(App::$auth->data()->user_status) ?>

							</small>
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->

				<ul class="nav">
					<li class="nav-header">MENU</li>
					<li class="has-sub <?php echo liActive('index') ?>">
						<a href="<?php echo Url::route('home') ?>">
							<i class="fa fa-laptop"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<?php $access = DB::table('accessibility INNER JOIN accessibility_list ON accessibility.access_list_id = accessibility_list.access_list_id')
							->where(['user_id', '=', App::$auth->data()->user_id])
							->all();
						if (!empty($access)) {
							$iconCount = 0;
							$icon = ['truck', 'th-large', 'shopping-cart', 'group', 'signal', 'cogs', 'users', 'gift'];

							foreach ($access as $acC) { ?>

							<li class="has-sub <?php echo ulActive($acC->access_list_portal) ?>">
								<a href="javascript:;" style="">
									<i class="fa fa-<?php echo $icon[$iconCount] ?>"></i>
									<span>
										<b class="caret pull-right"></b>
										<?php
													$menuVar = '';
													if ($acC->access_list_portal === 'orders') {
														$menuVar = 'Purchase Order (PO)';
													} else {
														$menuVar = $acC->access_list_portal;
													}
													?>
										<?php echo ucwords($menuVar);
													$iconCount++; ?>
									</span>
								</a>
								<ul class="sub-menu">
									<?php
												$subCount = 0;
												$method = [
													'new_supplier', 'manage_supplier', 'manage_invoice_order',
													'add_product', 'manage_product', 'damage_product'
												];
												$accSubs = Query::getSql()->query("
 		 																SELECT * FROM
 		 																accessibility_list_sub
 		 																WHERE
 		 																accessibility_list_sub.access_list_id = {$acC->access_list_id}
 		 																ORDER BY
 		 																accessibility_list_sub.access_sub_portal ASC
 		 															");
												if ($accSubs->_count > 0) {
													foreach ($accSubs->_result as $subPortal) { ?>
											<li class="<?php echo liActive($subPortal->access_sub_portal) ?>">
												<?php if ($subPortal->access_sub_portal === 'category') : ?>
											<li class="has-sub <?php echo (App::method() == 'add_product_category' or App::method() == 'add_sub_category') ? 'active' : '' ?>">
												<a href="javascript:;"><b class="glyphicon glyphicon-indent-left"></b> <b class="caret pull-right"></b>
													<?php echo ucwords($subPortal->access_sub_portal) ?>
												</a>
												<ul class="sub-menu">
													<li class="<?php echo liActive('add_product_category') ?>">
														<a href="<?php echo Url::route('product/add_product_category') ?>">
															Product Category
														</a>
													</li>
													<li class="<?php echo liActive('add_sub_category') ?>">
														<a href="<?php echo Url::route('product/add_sub_category') ?>">
															Brand Category
														</a>
													</li>
												</ul>
											</li>
										<?php else : ?>
											<a href="<?php echo Url::route('' . $acC->access_list_portal . '/' . $subPortal->access_sub_portal . '') ?>">
												<?php
																		$subPortalArray = explode("_", $subPortal->access_sub_portal);
																		if (!empty($subPortalArray)) {
																			foreach ($subPortalArray as $sp) {

																				echo ucwords($sp) . ' ';
																			}
																		} else {
																			echo ucwords($subPortal->access_sub_portal);
																		}
																		?>
											</a>
										<?php endif ?>

							</li>

					<?php } } ?>
				</ul>
		<?php } } ?>
		<li>
			<a href="javascript:;" id="mini-menu-bar" class="sidebar-minify-btn" data-click="sidebar-minify">
				<i class="fa fa-angle-double-left"></i>
			</a>
		</li>
		<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>