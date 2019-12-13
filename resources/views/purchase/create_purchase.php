<style type="text/css">
    .btn-cat-action button{
        margin-left: 2px !important;
    }
</style>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" data-original-title="" title=""><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse" data-original-title="" title=""><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Purchased Order</h4>
    </div>
    <div class="panel-body">
        <!-- <h4><center>Category Form</center></h4> -->
        <!-- <br> -->
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-5">
                <?php if (Session::hasFlash()): ?>
                    <div class="alert alert-success alert-dismissable fade-msg">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <b><i class="fa fa-check"></i></b>
                        <?php echo ucwords(Session::flash()) ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-success" style="border:1px solid #ccc">
                  <ul class="nav nav-tabs">
                    <li class=""><a data-toggle="tab" href="#tab1">Shooping Cart</a></li>
                    <li class="active"><a data-toggle="tab" href="#menu1">Search Product</a></li>
                    <!-- <li><a data-toggle="tab" href="#menu2">Menu 2</a></li> -->
                  </ul>

                  <div class="tab-content">
                    <div id="tab1" class="tab-pane fade ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <table class="table table-striped"> 
                                    <thead style="background-color:#ececec">
                                        <tr>
                                            <th>SL#</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade in active">
                          <table id="category-list-table" class="table table-striped " width="100%">
                              <thead style="background-color:#ececec">
                                  <tr>
                                      <th>Barcode</th>
                                      <th>Product Name</th>
                                      <th>Inventory</th>
                                      <th><span class="pull-right">Purchase</span></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr class="odd gradeX">
                                      <td>Trident</td>
                                      <td>Internet Explorer 4.0</td>
                                      <td>Win 95+</td>
                                      <td><button class="btn btn-primary btn-xs pull-right"><i class="fa fa-shopping-cart"></i></button></td>
                                  </tr>
                              </tbody>
                          </table>
                    </div>
                    <!-- <div id="menu2" class="tab-pane fade">
                      <h3>Menu 2</h3>
                      <p>Some content in menu 2.</p>
                    </div> -->
                  </div>
                </div>



                

            </div>
            <div class="col-md-4">
                <div class="panel panel-success" style="border:1px solid #ccc">
                  <div class="panel-heading">Panel Heading</div>
                  <div class="panel-body">Panel Content</div>
                </div>
            </div>
        </div>
    </div>
</div>
 

 
<script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>



 
 <script type="text/javascript">
    $(document).ready(function(){
        TableManageTableSelect.init();
       

    })
 </script>