 <div id="header" class="header navbar navbar-default navbar-fixed-top">
     <!-- begin container-fluid -->
     <div class="container-fluid" style="background-color: #00acac">
         <!-- begin mobile sidebar expand / collapse button -->
         <div class="navbar-header" style="width: 205px;">
             <a href="" style="" class="header-time">
                 <span class="time"><?php echo date('h:i:'); ?>
                     <span id="ct"></span>
                     <small class="head-am"><?php echo date('a'); ?></small>
                 </span>
             </a>

             <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
             </button>
         </div>

         <!-- begin header navigation right -->
         <!-- <div class="nav navbar-nav navbar-left" style="border-left:1px solid #37757d; ">
	 		 					<label class="header-abbr text-white"><?php echo strtoupper(company()->comp_abbr) ?></label>
	 		 					<span class="header-name text-default"><?php echo strtoupper(company()->comp_name) ?></span>
	 		 				</div> -->
         <ul class="nav navbar-nav navbar-left">
             <li class="dropdown navbar-user">
                 <a href="" id="btn-cashier">
                     <i class="fa fa-cart"></i>
                     POS
                 </a>
             </li>
         </ul>
         <ul class="nav navbar-nav navbar-right">
             <li class="dropdown">
                 <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                     <li class="dropdown-header">0 Product Are running out of stock</li>
                     <li class="media">
                         <a href="javascript:;">
                             <div class="media-left"><i class="fa fa-bug media-object bg-red"></i></div>
                             <div class="media-body">
                                 <h6 class="media-heading">Server Error Reports</h6>
                                 <div class="text-muted f-s-11">3 minutes ago</div>
                             </div>
                         </a>
                     </li>
                     <li class="dropdown-footer text-center">
                         <a href="javascript:;">View more</a>
                     </li>
                 </ul>
             </li>
             <li class="dropdown">
                 <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                     <i class="fa fa-flag-o"></i>
                     <span class="label label-count-invoice">0</span>
                 </a>
                 <ul class="dropdown-menu media-list pull-right animated fadeInDown ulUnpaid">
                     <li class="dropdown-header"><span id="countUnpaidInvoice"></span> Unpaid Invoice </li>
                     <li class="dropdown-footer text-center">
                         <a href="<?php echo Url::route('supplier/manage_invoice') ?>">View All Unpaid Invoice</a>
                     </li>
                 </ul>
             </li>
             <li class="dropdown">
                 <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                     <i class="fa fa-bell-o"></i>
                     <span class="label label-count"></span>
                 </a>
                 <ul class="dropdown-menu media-list pull-right animated fadeInDown ulPending">
                     <li class="dropdown-header"><span id="countPending"></span> Pending Order </li>
                     <li class="dropdown-footer text-center">
                         <a href="<?php echo Url::route('orders/manage_invoice') ?>">View All Pending Order</a>
                     </li>
                 </ul>
             </li>
             <li class="dropdown navbar-user">
                 <a href="<?php echo Url::route('Index/postLogout') ?>">
                     <i class="glyphicon glyphicon-off"></i>
                     Logout
                 </a>
             </li>
         </ul>
         <!-- end header navigation right -->
     </div>
     <!-- end container-fluid -->
 </div>