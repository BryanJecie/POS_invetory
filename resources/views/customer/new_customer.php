<style type="text/css">
    .btn-cat-action button{
        margin-left: 2px !important;
    }
    .custom-label{

    }
    .custom-label span{
        color: red;
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
        <h4 class="panel-title">New Customer</h4>
    </div>
    <div class="panel-body">
        
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-5">
                <?php if (Session::hasFlash()): ?>
                    <div class="alert alert-success alert-dismissable fade-msg">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <b><i class="fa fa-check"></i></b>
                        <?php echo ucwords(Session::flash()) ?>
                    </div>
                <?php endif ?>
                <form action="<?php echo Url::route('customer/new_customer') ?>" method="POST" data-parsley-validate="true" name="form-wizard">
                    <fieldset>
                        <?php $idNum =  str_pad($data['id'], 4, '0', STR_PAD_LEFT); ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Customer ID <span>*</span></label>
                            <input type="text"  name="cus_no" value="CTN-<?php echo date('m-y').'-'.$idNum ?>" class="form-control" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Customer First Name <span>*</span></label>
                            <input type="text"  name="first" class="form-control" id="exampleInputPassword1" placeholder="First Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Customer Last Name <span>*</span></label>
                            <input type="text" name="last"  class="form-control" id="exampleInputPassword1" placeholder="Last Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Customer Email <span>*</span></label>
                            <input type="email" name="email"  class="form-control" id="exampleInputPassword1" placeholder="Email" required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Customer Phone <span>*</span></label>
                            <input type="text" name="phone"  class="form-control" id="exampleInputPassword1" placeholder="Phone no" required/>
                        </div>
                       
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Customer Discount% <span>*</span></label>
                            <input type="text" name="discount"  class="form-control" id="exampleInputPassword1" placeholder="Optional" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Customer Birthdate <span>*</span></label>
                            <input type="date" name="birthdate" class="form-control" id="exampleInputPassword1" value="<?php echo date('Y-m-d') ?>" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Customer Address <span>*</span></label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Address" required></textarea>
                            <!-- <input type="text" name="address" class="form-control" id="exampleInputPassword1" placeholder="Address" required/> -->
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>" >
                        <button type="submit" class="btn btn-sm btn-primary m-r-5 pull-right">Save Customer</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>

<!-- manage-product-list-table -->
<script>
    $(document).ready(function(){
            FormWizardValidation.init();
    });  
</script>