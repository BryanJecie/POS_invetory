<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" data-original-title="" title=""><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse" data-original-title="" title=""><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Add New Supplier</h4>
    </div>
    <div class="panel-body">
        <h4><center>Registration Form</center></h4>
        <br>
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
        <form class="form-horizontal" method="POST" action="<?php echo Url::route('supplier/add_supplier'); ?>" data-parsley-validate="true" name="form-wizard">
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Company Name</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <input type="text" name="company-name" class="form-control" placeholder="Company Name" data-parsley-group="wizard-step-1" required>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Supplier Name</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <input type="text" name="supplier" class="form-control" placeholder="Supplier Name" data-parsley-group="wizard-step-1" required>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Supplier Email</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <input type="email" name="email" class="form-control" placeholder="Supplier Email" data-parsley-group="wizard-step-1" required>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Supplier Phone no.</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                    <input type="text" name="phone" class="form-control" placeholder="Supplier Phone no" data-parsley-group="wizard-step-1" required>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Supplier Address</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <textarea name="addess" rows="5" class="form-control" placeholder="Supplier Address" data-parsley-group="wizard-step-1" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">&nbsp;</label>
                <div class="col-md-5">
                    <button type="submit" class="btn btn-sm btn-success pull-right">Save Supplier</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>

<script>

    $(document).ready(function() {

        FormWizardValidation.init();

    });
    
</script>