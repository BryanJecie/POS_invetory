<style type="text/css">
    .btn-cat-action button{
        margin-left: 2px !important;
    }
    .custom-label{

    }
    .custom-label span{
        color: red;
    }
    .btn-file {
            position: relative;
            overflow: hidden;
            width: 100% !important;
            margin-top: -8px;
            /*margin-left: -4px !important;*/
            font-size: 12px ;
            border-radius: 0px;
            height: 30px;
    }
    .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px ;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: red;
            cursor: inherit;
            display: block;
    }
    .profile-image{
        height: auto !important;

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
        <h4 class="panel-title">New Employee</h4>
    </div>
    <div class="panel-body"> 
        <form action="<?php echo Url::route('employee/add_employee') ?>" method="POST" enctype="multipart/form-data" data-parsley-validate="true" name="form-wizard">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <?php if (Session::hasFlash()) : ?>
                      <!--   <div class="alert alert-success alert-dismissable fade-msg">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <b><i class="fa fa-check"></i></b> -->
                            <?php echo ucwords(Session::flash()) ?>
                        <!-- </div> -->
                    <?php endif ?>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row" >
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <fieldset>
                        <?php $empNo = str_pad($data['id'], 4, '0', STR_PAD_LEFT); ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Employee ID <span>*</span></label>
                            <input type="text"  name="emp-no" value="EMP-<?php echo $empNo ?>" class="form-control" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Username <span>*</span></label>
                            <input type="text"  name="username" class="form-control" id="exampleInputPassword1" placeholder="Enter Username" required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Password <span>*</span></label>
                            <input type="password"  name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Role <span>*</span></label>
                            <select class="form-control" name="role">
                                <option value="">Choose User Role</option>
                                <?php if (!is_null($data['role'])) : ?>
                                    <?php foreach ($data['role'] as $role) : ?>
                                        <?php if ($role->user_role !== 'admin') : ?>
                                            <option value="<?php echo $role->role_id ?>"><?php echo ucwords($role->user_role) ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">First Name <span>*</span></label>
                            <input type="text"  name="first" class="form-control" id="exampleInputPassword1" placeholder="First Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Middle Name <span>*</span></label>
                            <input type="text" name="middle"  class="form-control" id="exampleInputPassword1" placeholder="Last Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Last Name <span>*</span></label>
                            <input type="text" name="last"  class="form-control" id="exampleInputPassword1" placeholder="Last Name" required/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Birthdate <span>*</span></label>
                            <input type="date" name="birthdate" class="form-control" id="exampleInputPassword1" value="<?php echo date('Y-m-d') ?>" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Address <span>*</span></label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Address" required></textarea>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="custom-label">Position<span>*</span></label>
                            <input type="text" name="position" class="form-control" id="exampleInputPassword1"/>
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>" >
                        <button type="submit" class="btn btn-sm btn-primary m-r-5 pull-right">Save Customer</button>
                    </fieldset>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-3" >
                    <fieldset>
                        <legend><small>User Accessibility</small></legend>
                        <?php if (!is_null($data['access']) and is_array($data['access'])) : ?>
                            <?php foreach ($data['access'] as $access) : ?>
                                <?php if ($access->access_list_portal !== "employees") : ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="access[]" value="<?php echo $access->access_list_id ?>" checked>
                                            <?php echo ucwords($access->access_list_portal) ?>
                                        </label>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </fieldset>
                </div>
                <div class="col-md-2"></div>

                <div class="col-md-2">
                    <br>
                    <label><b>Employee Image</b></label>
                      <div class="profile-image">
                        <center>
                            <?php echo App::$image->get('images/users/', ['width' => 'auto'], null); ?>
                        </center>
                      </div>
                      <span class="btn btn-primary btn-file " style="">
                        <span style="">Select Image</span>
                        <input type="file" name="image-file" id="imgInp" >
                    </span>
                </div>
            </div>
        </form>
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


<script>
    function get_image(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
               $('.profile-image').show().html('<center><img src="#" id="chosse-image" class="image-profile" /></center>');
               $('#chosse-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    // put image on the UI
    $("#imgInp").change(function(){
        get_image(this);
    }); 
</script>