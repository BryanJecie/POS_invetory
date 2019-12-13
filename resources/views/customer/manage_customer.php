<style type="text/css">
    .btn-cat-action a{
        margin-left: 2px !important;
    }
    .custom-label{
        font-size: 14px;
    }
    .custom-label span{
        color:red;
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
                <?php if (Session::hasFlash()): ?>
                    <div class="alert alert-danger alert-dismissable fade-msg">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <b><i class="fa fa-check"></i></b>
                        <?php echo ucwords(Session::flash()) ?>
                    </div>
                <?php endif ?>
                <table id="manage-customer-list-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>Customer No</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['customs']) AND is_array($data['customs'])): ?>
                            <?php foreach ($data['customs'] as $value): ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $value->custom_no ?></td>
                                    <td><?php echo $value->custom_firstname.' '.$value->custom_lastname ?></td>
                                    <td><?php echo $value->custom_email ?></td>
                                    <td><?php echo $value->custom_phone ?></td>
                                    <td> 
                                        <?php 
                                           if (!is_null($value->custom_discount) AND $value->custom_discount !=="") {
                                              $discArr = explode('.', $value->custom_discount);
                                              if (count($discArr) > 1) {
                                                  echo $discArr[1].'%';
                                              }
                                              else{
                                                  echo $value->custom_discount;
                                              }
                                           }
                                           else{
                                             echo "0";
                                           }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-cat-action">
                                            <a href="#modal-edit-<?php echo $value->custom_id ?>" class="btn btn-white btn-sm"  data-toggle="modal">
                                                <i class="glyphicon glyphicon-edit"></i> EDIT
                                            </a>
                                            <!-- <div class="btn-group m-r-5 m-b-5 pull-right">
                                                <a href="javascript:;" data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-sm" title="" data-toggle="tooltip" data-placement="top" data-original-title="delete" aria-expanded="false">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo Url::route('customer/manage_customer/'.$value->custom_id.' ') ?>">YES</a></li>
                                                    <li><a href="javascript:;">NO</a></li>
                                                </ul>
                                            </div> -->
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>

                <?php if (!empty($data['customs']) AND is_array($data['customs'])): ?>
                    <?php foreach ($data['customs'] as $value): ?>
                        <div class="modal fade" id="modal-edit-<?php echo $value->custom_id ?>">
                            <div class="modal-dialog">
                                 <div class="modal-content">
                                    <form action="<?php echo Url::route('customer/manage_customer') ?>" method="POST" accept-charset="utf-8">
                                        <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                             <h4 class="modal-title">Edit Customer</h4>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table  table-bordered">
                                                <thead style="background-color: #f0f3f5">
                                                    <tr>
                                                        <th colspan="2"><label class="custom-label"><b>Customer Information</b></label></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><label class="custom-label">Customer ID <span>*</span></label></td>
                                                        <th><input type="text" class="form-control input-sm" name="idNum" value="<?php echo $value->custom_no ?>" readonly></th>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="custom-label">Customer Firstname <span>*</span></label></td>
                                                        <th><input type="text" class="form-control input-sm" name="first" value="<?php echo $value->custom_firstname ?>"></th>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="custom-label">Customer Lastname <span>*</span></label></td>
                                                        <th><input type="text" class="form-control input-sm" name="last" value="<?php echo $value->custom_lastname ?>"></th>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="custom-label">Customer Phone <span>*</span></label></td>
                                                        <th><input type="text" class="form-control input-sm" name="phone" value="<?php echo $value->custom_phone ?>"></th>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="custom-label">Customer Email <span>*</span></label></td>
                                                        <th><input type="text" class="form-control input-sm" name="email" value="<?php echo $value->custom_email ?>"></th>
                                                    </tr>
                                                   
                                                    <tr>
                                                        <td><label class="custom-label">Customer Discount% <span>*</span></label></td>
                                                        <th><input type="text" class="form-control input-sm" name="discount" value="<?php echo $value->custom_discount ?>"></th>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="custom-label">Customer Birthdate <span>*</span></label></td>
                                                        <th><input type="date" class="form-control input-sm" name="birthdate" value="<?php echo $value->custom_birthdate ?>"></th>
                                                    </tr>
                                                     <tr>
                                                        <td><label class="custom-label">Customer Address <span>*</span></label></td>
                                                        <td>
                                                            <textarea name="address" class="form-control"  rows="3"><?php echo $value->custom_address  ?></textarea>
                                                            <input type="hidden" name="custom-id" value="<?php echo $value->custom_id ?>">
                                                            <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                             <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                             <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Ok</a>
                                        </div>
                                    </form>
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
            var handleDataTableSelect = function(){
                    "use strict";0!==$("#manage-customer-list-table").length&&$("#manage-customer-list-table").DataTable({
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
        });
    </script>