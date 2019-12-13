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
        <h4 class="panel-title">Manage Customer invoice List</h4>
    </div>
    <div class="panel-body">
        
        <div class="row">
            <div class="col-md-12">
                <table id="manage-invoice-list-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice No.</th>
                            <th>Order No.</th>
                            <th>Invoice Date</th>
                            <th>Customer</th>
                            <th>Payment Method</th>
                            <th>Order Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX">
                            <td>Trident</td>
                            <td>Internet Explorer 4.0</td>
                            <td>Internet Explorer 4.0</td>
                            <td>Internet Explorer 4.0</td>
                            <td>Internet Explorer 4.0</td>
                            <td>1pcs</td>
                            <td><label class="label label-primary">active</label></td>
                            <td>
                                <div class="btn-group btn-cat-action">
                                    <button type="button" class="btn btn-success btn-xs"><i class="fa fa-search"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>

<!-- manage-product-list-table -->
<script>
        $(document).ready(function() {
            var handleDataTableSelect = function(){
                    "use strict";0!==$("#manage-invoice-list-table").length&&$("#manage-invoice-list-table").DataTable({
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