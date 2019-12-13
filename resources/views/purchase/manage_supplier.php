<style type="text/css">
    .btn-cat-action a{
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
        <h4 class="panel-title">Manage Supplier List</h4>
    </div>
    <div class="panel-body">
         <?php if (Session::hasFlash()): ?>
            <div class="alert alert-success alert-dismissable fade-msg">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <b><i class="fa fa-check"></i></b>
                <?php echo ucwords(Session::flash()) ?>
            </div>
        <?php endif ?>
        <div class="row">
            <div class="col-md-12">
                <table id="manage-supplier-list-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>SL#</th>
                            <th>Company Name</th>
                            <th>Supplier Name</th>
                            <th>Supplier Email</th>
                            <th>Supplier Phone</th>
                            <th>Supplier Adderess</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php if (!is_null($data['suppliers']) AND is_array($data['suppliers'])): ?>
                            <?php foreach ($data['suppliers'] as $supplier): ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $supplier->supplier_company_name ?></td>
                                    <td><?php echo $supplier->supplier_name ?></td>
                                    <td><?php echo $supplier->supplier_email ?></td>
                                    <td><?php echo $supplier->supplier_phone_no ?></td>
                                    <td><?php echo $supplier->supplier_address ?> </td>
                                    <td>
                                        <div class="btn-group btn-cat-action">
                                            <a href="#manage-supplier-<?php echo $supplier->supplier_id ?>" value="<?php echo $supplier->supplier_id ?>" data-toggle="modal" class="btn btn-inverse btn-xs">
                                              <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#manage-delete-<?php echo $supplier->supplier_id ?>"   data-toggle="modal" class="btn btn-danger btn-xs ">
                                              <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>

                        
                    </tbody>
                </table>
                

                <?php $mCount = 1; ?>
                <?php if (!empty($data['suppliers'])): ?>
                    <?php foreach ($data['suppliers'] as $supplier): ?>
                        <div class="modal fade" id="manage-supplier-<?php echo $supplier->supplier_id ?>">
                            <form  action="<?php echo Url::route('supplier/manage_supplier') ?>" method="POST">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Supplier Information</h4>
                                        </div>
                                        <div class="modal-body">
                                           <table class="table table-striped table-bordered">
                                               <thead>
                                                   <tr>
                                                       <th><label class="control-label"><b>SN#</b></label></th>
                                                       <th>
                                                            <label class=""><b><?php echo $mCount++; ?></b></label>
                                                            <input type="hidden" name="sup-id"   value="<?php echo $supplier->supplier_id ?>">
                                                            <input type="hidden" name="token"   value="<?php echo Token::generate() ?>">
                                                       </th>
                                                   </tr>
                                                   <tr>
                                                       <th><label class="control-label"><b>Company Name</b></label></th>
                                                       <th><input type="text" name="sup-comp" class="form-control" value="<?php echo $supplier->supplier_company_name ?>"></th>
                                                   </tr>
                                                   <tr>
                                                       <th><label class="control-label"><b>Supplier Name</b></label></th>
                                                       <th><input type="text" name="sup-name" class="form-control" value="<?php echo $supplier->supplier_name ?>"></th>
                                                   </tr>
                                                   <tr>
                                                       <th><label class="control-label"><b>Supplier Email</b></label></th>
                                                       <th><input type="email" name="sup-email" class="form-control" value="<?php echo $supplier->supplier_email ?>"></th>
                                                   </tr>
                                                   <tr>
                                                       <th><label class="control-label"><b>Company Phone no.</b></label></th>
                                                       <th><input type="text" name="sup-phone" class="form-control" value="<?php echo $supplier->supplier_phone_no ?>"></th>
                                                   </tr>
                                                   <tr>
                                                       <th><label class="control-label"><b>Company Address</b></label></th>
                                                       <th><textarea class="form-control" name="sup-add" rows="3" value="<?php echo $supplier->supplier_address ?>"><?php echo $supplier->supplier_address ?></textarea></th>
                                                   </tr>
                                               </thead>
                                           </table>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                            <button type="submit"  class="btn btn-sm btn-success">Update Supplier info</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal fade" id="manage-delete-<?php echo $supplier->supplier_id ?>">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="alert alert-danger m-b-0">
                                          <h4><i class="fa fa-warning"></i> Warning</h4>
                                          <p class=""><h4 class="msgDelete">Are you sure you want to delete this supplier?</h4></p>
                                        </div>
                                        <br>
                                        <p class="pull-right" style="margin-top:-10px">
                                          <a href="javascript:;" class="btn btn-sm btn-white btnSupplierCancel"   cval="btnSupplierCancel" data-dismiss="modal">Cancel</a>
                                          <a href="javascript:;" class="btn btn-sm btn-success btnSupplierDelete" cval="<?php echo $supplier->supplier_id ?>"  >Ok</a>
                                        </p>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>

<!-- manage-product-list-table -->
<script>
        $(document).ready(function() {

          var doc = $(document);


            var handleDataTableSelect = function(){
                    "use strict";0!==$("#manage-supplier-list-table").length&&$("#manage-supplier-list-table").DataTable({
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


           doc.on('click','.btnSupplierDelete , .btnSupplierCancel' ,function(){
              var $this    = $(this);
                  switch($this.attr('cval')){
                    case 'btnSupplierCancel' :
                      $('.msgDelete').show().html('Are you sure you want to delete this supplier?');
                    break;
                    default : 
                       var btnValue = $this.attr('cval');
                       $.post("<?php echo Url::route('purchase/deleteSupplier') ?>" , { suppplierId : btnValue }, function(data){
                          if (data.key === true) {
                              location.reload();
                          } else if(data.key === false ) {
                            $('.msgDelete').show().html('Oops ! Unable to delete this Supplier.');
                          }
                       },"JSON");
                    break;
                  }
           });

        });
    </script>