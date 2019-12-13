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
        <h4 class="panel-title">Add New Category</h4>
    </div>
    <div class="panel-body">
        <h4><center>Category Form</center></h4>
        <br>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-5">
                <?php if (Session::hasFlash()): ?>
                    <?php echo ucwords(Session::flash()) ?>
                <?php endif ?>
            </div>
        </div>
        <div class="row">
            <form class="form-horizontal" action="<?php echo Url::route('product/add_product_category') ?>" method="POST" data-parsley-validate="true" name="form-wizard">
                <div class="form-group">
                    <label class="col-md-4 control-label"><b>Category Name</b><span style="color:red"> *</span></label>
                    <div class="col-md-5">
                        <input type="hidden" name="insert"  value="insert">
                        <input type="text" class="form-control" name="type_name" placeholder="Category Name" autocomplete="off" data-parsley-group="wizard-step-1" required>
                        <input type="hidden" class="form-control" name="token" value="<?php echo Token::generate() ?>" placeholder="Category Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">&nbsp;</label>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-sm btn-success pull-right">Save Product Category</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table id="category-list-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>SN#</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php if (!empty($data['type']) AND is_array($data['type'])): ?>
                            <?php foreach ($data['type'] as $type): ?>
                                <tr class="odd gradeX">
                                    <td><b><?php echo $count++; ?></b></td>
                                    <td><b><?php echo ucwords($type->type_name) ?></b></td>
                                    <td>
                                        <div class="btn-group btn-cat-action">
                                            <a href="#type-modal-<?php echo $type->type_id ?>" class="btn btn-white" data-toggle="modal" ><i class="fa fa-pencil"></i> <small>EDIT</small></a>
                                            <!-- <button type="button" class="btn btn-danger btn-xs deleteCategory" cval="<?php echo $type->type_id ?>"><i class="fa fa-trash-o"></i></button> -->
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (!empty($data['type'])): ?>
            <?php foreach ($data['type'] as $type_id): ?>
                 <div class="modal fade" id="type-modal-<?php echo $type_id->type_id ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form class="form-horizontal" name="update" method="POST" action="<?php echo Url::route('product/add_product_category') ?>">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Category</h4>
                                </div>
                                <div class="modal-body">
                                   
                                       <div class="form-group">
                                           <label class="col-md-3 control-label">Category name</label>
                                           <div class="col-md-9">
                                               <input type="hidden" name="update"  value="update">
                                               <input type="hidden" class="form-control" name="type_id" value="<?php echo $type_id->type_id ?>">
                                               <input type="text" name="type_name" class="form-control" value="<?php echo $type_id->type_name ?>">
                                           </div>
                                       </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                                    <button type="submit" class="btn btn-sm btn-success">Update Product Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                 </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>
<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>
<script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>


<script>
        $(document).ready(function() {
            TableManageTableSelect.init();
            FormWizardValidation.init();
            
            var doc = $(document);
            
            doc.on('click', '.deleteCategory', function(){
                var $this = $(this);
                var catId = $this.attr('cval');

            });

        });
    </script>