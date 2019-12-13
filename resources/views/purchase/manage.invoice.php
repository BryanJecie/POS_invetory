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
        <h4 class="panel-title">Manage Invoice List</h4>
    </div>
    <div class="panel-body">
        
        <div class="row">
            <div class="col-md-12">
                <table id="manage-invoice-list-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Purcahsed No.</th>
                            <th>References</th>
                            <th>Supplier</th>
                            <th>Payment Type</th>
                            <th>Payment Status</th>
                            <th>Purchased By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!is_null($data['purchase'])): ?>
                            <?php $count = 1; ?>
                            <?php foreach ($data['purchase'] as $pur): ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $count++; ?></td>
                                    <td><b class="text-info"><?php echo $pur->purchase_no; ?></b></td>
                                    <td><?php echo $pur->purchase_reference; ?></td>
                                    <td><?php echo $pur->supplier_company_name; ?></td>
                                    <td><?php echo strtoupper($pur->purchase_payment_type); ?></td>
                                    <td>
                                        <label class="label label-<?php echo ($pur->purchase_payment_status === 'unpaid') ? 'danger' : 'success' ?>">
                                            <?php 
                                                echo strtoupper($pur->purchase_payment_status); 
                                            ?>
                                        </label>
                                    </td>
                                    <td><?php echo ucwords($pur->person_first.' '.$pur->person_last) ?></td>
                                    <td>
                                        <div class="btn-group btn-cat-action">
                                            <a href="<?php echo Url::route('supplier/view_manage_invoice/'.$pur->pur_id) ?>" class="btn btn-white btn-sm">
                                                <i class="fa fa-search"></i> view
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




 <!-- <?php 

        $pDetails = DB::table("
                    purchased_details
                    LEFT JOIN product 
                    ON purchased_details.product_id = product.product_id
                    ")
                ->where(['purchased_details.pur_id', '=', $pur->pur_id])
                ->all();
        if (!empty($pDetails)) {
            foreach ($pDetails as $pdet) {
                $pName = '';
                if (!is_null($pdet->product_id)) {
                   $pName =  $pdet->pur_det_name;
                }
                else{
                   $pName =  $pdet->product_name;
                } ?>          



    <?php } } ?> -->
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