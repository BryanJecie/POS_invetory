<style type="text/css">
    .btn-cat-action a{
        margin-left: 2px !important;
    }
    .profile-image{
      height: auto;
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
        <h4 class="panel-title">Manage Product List</h4>
    </div>
    <div class="panel-body">
        
        <div class="row">
            <div class="col-md-12">
               <?php if (Session::hasFlash()) : ?>
                 <?php echo Session::flash() ?>
               <?php endif ?>
                <table id="manage-product-list-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Stockin Quantity</th>
                            <th>Date In</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['stockin'])) : ?>
                            <?php foreach ($data['stockin'] as $tock) : ?>
                                <tr class="odd gradeX">
                                    <td><?php echo App::Image()->get('images/products/', ['width' => '30'], $tock->product_id); ?></td>
                                    <td><?php echo ucwords($tock->type_name) ?></td>
                                    <td><?php echo ucwords($tock->brand_name) ?></td>
                                    <td><b class="text-info"><?php echo $tock->barcode ?></b></td>
                                    <td><?php echo ucwords($tock->product_name) ?></td>
                                    <td>
                                      <label class="label label-primary" style="font-size: 11px">
                                        <?php echo strtoupper($tock->stockin_quantity . ' ' . '<b>' . $tock->stockin_quantity_type . '</b>') ?>
                                      </label>
                                    </td>
                                    <td>
                                       <?php echo date('M. j, Y', strtotime($tock->product_insert_date)) ?>
                                    </td>
                                    <td>
                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-white dropdown-toggle btn-sm" data-toggle="dropdown">
                                              More  <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                              <li>
                                                  <a href="#manage-product-<?php echo $tock->stockin_id ?>" data-toggle="modal" id="view-product">
                                                    <i class="glyphicon glyphicon-search text-info"></i> 
                                                    <span class="text-info">VIEW PRODUCT</span>
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="<?php echo Url::route('product/edit_product/edit?id=' . $tock->stockin_id . ' ') ?>">
                                                    <i class="fa fa-pencil text-success"></i>
                                                    <span class="text-success">EDIT  PRODUCT</span>
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#manage-delete-<?php echo $tock->stockin_id ?>" data-toggle="modal" id="">
                                                    <i class="fa fa-trash-o text-danger"></i>
                                                    <span class="text-danger">DELETE PRODUCT</span>
                                                  </a>
                                              </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
    </div>
</div>

<!-- view modal -->
<?php if (!empty($data['stockin'])) : ?>
    <?php foreach ($data['stockin'] as $tock) : ?>
       
      <div class="modal fade" id="manage-product-<?php echo $tock->stockin_id ?>">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
                      <h4 class="modal-title">
                        Product Information
                        <b class="pull-right text-info" style="font-size: 14px">Date Created : <?php echo date('M j, Y  ', strtotime($tock->product_insert_date)) ?> </b>
                      </h4>

                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="profile-image">
                              <center>
                                <?php echo App::$image->get('images/products/', ['width' => 'auto'], $tock->product_id); ?>
                              </center>
                            </div>
                        </div>
                        <div class="col-md-9">
                          <table class="table table-striped table-bordered ">
                               <tr>
                                  <td colspan="2" class="bg-info"><b class="text-info" style="font-size: 16px;">Product General Information</b></td>
                               </tr>
                               <tr>
                                   <td colspan="2"><b><h6><?php echo ucwords($tock->product_name . ' ' . $tock->product_subname) ?></h6></b></td>
                               </tr>
                               <tr>
                                   <td><b>Product Code</b></td>
                                   <td><b><?php echo $tock->barcode ?></b></td>
                               </tr>
                               <tr>
                                   <td><b>Product Name</b></td>
                                   <td><?php echo ucwords($tock->product_name) ?></td>
                               </tr>
                               <tr>
                                   <td><b>Product Subname</b></td>
                                   <td><?php echo ucwords($tock->product_subname) ?></td>
                               </tr>
                               <tr>
                                   <td><b>Categoty</b></td>
                                   <td><?php echo ucwords($tock->type_name) ?></td>
                               </tr>
                               <tr>
                                   <td><b>Brand</b></td>
                                   <td><?php echo ucwords($tock->brand_name) ?></td>
                               </tr>
                               <tr>
                                   <td colspan="2" class="bg-info"><b class="text-info" style="font-size: 16px;">Product General Price</b></td>
                               </tr>
                               <tr>
                                   <td><b>Buying Price</b></td>
                                   <td><b><?php echo number_format($tock->stockin_buying_price, 2) ?></b></td>
                               </tr>
                               <tr>
                                   <td><b>Selling Price</b></td>
                                   <td><b><?php echo number_format($tock->stockin_selling_price, 2) . ' / ' . strtoupper($tock->stockin_selling_type) ?></b></td>
                               </tr>
                               <tr>
                                   <td><b>In Stocks</b></td>
                                   <td>
                                     <b>
                                       <?php 
                                        $per = null;
                                        if (!is_null($tock->stockin_quantity_per) and $tock->stockin_quantity_per !== "") {
                                            $per = '<small class="text-danger"> X </small>' . $tock->stockin_quantity_per;
                                        }
                                        echo $tock->stockin_quantity . ' ' . ucwords($tock->stockin_quantity_type) . $per;
                                        ?>
                                     </b>
                                   </td>
                               </tr>
                               <?php if (!is_null($tock->stockin_quantity_per) and $tock->stockin_quantity_per !== "") : ?>
                                  <tr>
                                     <td><b>Selling Stocks</b></td>
                                     <td><b><?php echo $tock->stockin_selling_quantity . ' ' . ucwords($tock->stockin_selling_type); ?></b></td>
                                 </tr>
                               <?php endif ?>
                                <tr>
                                   <td colspan="2"><b>Description :</b></td>
                               </tr>
                               <tr>
                                   <td colspan="2"><p><?php echo ucwords($tock->product_desc) ?></p></td>
                               </tr>
                          </table>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <a href="javascript:;" class="btn btn-sm btn-white pull-left" data-dismiss="modal">
                        Close
                      </a>
                      <a href="<?php echo Url::route('product/edit_product/edit?id=' . $tock->product_id . ' ') ?>" class="btn btn-sm btn-primary">Edit Product</a>

                  </div>
              </div>
          </div>
      </div>
    <?php endforeach ?>
<?php endif ?>

<!-- delete modal -->
<?php if (!empty($data['stockin'])) : ?>
  <?php foreach ($data['stockin'] as $tock) : ?>
        <div class="modal fade" data-backdrop="static" id="manage-delete-<?php echo $tock->stockin_id; ?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-red">
                <button type="button" class="close modal-delete" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-warning"></i> Warning</h4>
              </div>
              <div class="modal-body">
                <h4>Are you sure you want to delete this product.?</h4>
                <table class="table table-striped table-bordered ">
                      <tr>
                          <td><b>BARCODE</b></td>
                          <td><?php echo ucwords($tock->barcode) ?></td>
                      </tr>
                      <tr>
                          <td><b>PRODUCT NAME</b></td>
                          <td><?php echo ucwords($tock->product_name . ' ' . $tock->product_subname) ?></td>
                      </tr>
                      <tr>
                          <td><b>CATEGORY</b></td>
                          <td><?php echo ucwords($tock->type_name) ?></td>
                      </tr>
                      <tr>
                          <td><b>BRAND</b></td>
                          <td><?php echo ucwords($tock->brand_name) ?></td>
                      </tr>
                 </table>
                 <center>
                   <button type="button" class="btn btn-warning btn-sm delete-product-ok" style="width: 100px;">OK</button><br><br><br>
                   <span class="hide">
                     <i class="fa fa-spinner fa-spin" style="font-size:34px"></i>
                   </span>
                   <br> 
                   <div class="row hide">
                     <div class="col-md-12">
                         <form action="<?php echo Url::route('product/manage_product') ?>" method="POST">
                         <hr style="width: 45%">
                         <br> 
                         <fieldset >
                            <div class="form-group">
                              <label for="enter-password">PLEASE ENTER ADMIN PASSWORD</label>
                              <input type="password" name="password" required="" class="form-control" style="width: 45%; text-align: center" id="enter-password" placeholder="Required" />
                              <input type="hidden" name="prodId" value="<?php echo $tock->product_id ?>">
                            </div>
                            <button type="button" data-dismiss="modal" class="btn btn-sm btn-white m-r-5 modal-cancel">CANCEL</button>
                            <button type="submit" class="btn btn-sm btn-danger m-r-5">DELETE ITEM</button>
                         </fieldset>
                       </form>
                       <br>
                     </div>
                   </div> 
                 </center>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
  <?php endforeach ?>
<?php endif ?>

<script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>

<!-- manage-product-list-table -->
<script>
    $(document).ready(function() {
        var handleDataTableSelect = function(){
                "use strict";0!==$("#manage-product-list-table").length&&$("#manage-product-list-table").DataTable({
                    select:!0,responsive:!0}
                )},
            TableManageTableSelect = function(){
                "use strict";

        return{ 
            init:function(){
                handleDataTableSelect()}
            }
            }();

        TableManageTableSelect.init();
        

        $(document).on('click', '.modal-delete', function(){
          var $this  = $(this);
          var parent = $this.parent();
          parent.siblings('div').find('span').addClass('hide');
          parent.siblings('div').find('.row').addClass('hide');
          parent.siblings('div').find('.delete-product-ok').removeAttr('disabled');
          parent.siblings('div').find('.form-control').val(null);
        });

        $(document).on('click', '.modal-cancel', function(){
          var $this  = $(this);
          var parent = $this.parent().parent().parent().parent().parent();
          parent.find('.row').addClass('hide');
          parent.find('span').addClass('hide');
          parent.find('.form-control').val(null);
          parent.find('.delete-product-ok').removeAttr('disabled');
        });

        $(document).on('click', '.delete-product-ok', function(){
          var $this = $(this);
          $this.attr('disabled', true);  
          $this.siblings('span').removeClass('hide');
          setTimeout(function(){
            $this.siblings('div').removeClass('hide');
            $this.siblings('span').addClass('hide');
          },3000);
        });
    });
</script>