<style type="text/css">
    .btn-cat-action button{
        margin-left: 2px !important;
    }
    .custom-label{

    }
    .custom-label span{
        color: red;
    }
    .input-width{
        width: 40%;
    }
    /*.emp-img{
        height: auto !important;
    }*/
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
        <h4 class="panel-title">View Employee Information</h4>
    </div>
    <div class="panel-body">
        <?php if ($data['employee']): ?>
            <?php foreach ($data['employee'] as $emp): ?>
                <div class="profile-container">
                    <!-- begin profile-section -->
                    <form action="<?php echo Url::route('employee/edit_employee/view?empId='.$emp->user_id.' ') ?>" method="POST" accept-charset="utf-8" enctype="multipart/form-data" data-parsley-validate="true" name="form-wizard">
                        <div class="profile-section">
                            <!-- begin profile-left -->

                            <div class="profile-left">
                                <!-- begin profile-image -->
                               
                                <div class="profile-image">
                                    <center>
                                        <?php echo App::$image->get('images/users/',['width'=>'auto'],$emp->user_id); ?>
                                    </center>
                                </div>
                                <span class="btn btn-primary btn-file m-b-10" style="">
                                    <span style="">Select Image</span>
                                    <input type="file" name="image-file" id="imgInp" >
                                </span>
                                <!-- end profile-image -->
                                <!-- <div class="m-b-10">
                                    <a href="javascript:;" class="btn btn-warning btn-block btn-sm">Employee Photo</a>
                                </div> -->
                                <!-- begin profile-highlight -->
                                <div class="profile-highlight">
                                    <h4><i class="fa fa-cog"></i> Employee Accessibility</h4>
                                    <?php 
                                        $menu = array();

                                        $acsL = Query::getSql()->query("SELECT * FROM users
                                                                        INNER JOIN accessibility ON accessibility.user_id = users.user_id
                                                                        INNER JOIN accessibility_list ON accessibility.access_list_id = accessibility_list.access_list_id
                                                                        WHERE users.user_id = {$emp->user_id} ");
                                        if ($acsL->_count > 0) {
                                            foreach ($acsL->_result as $acsC) {
                                                $menu[]  = $acsC->access_list_portal;
                                            }
                                        }
                                         
                                    ?>
                                    <ul class="todolist">
                                        <?php if (!empty($data['access'])): ?>
                                            <?php foreach ($data['access'] as $acs): ?>
                                                <?php 
                                                    $check = '';

                                                    for ($i=0; $i < count($menu) ; $i++) { 
                                                        if ($menu[$i] === $acs->access_list_portal) {
                                                           $check = 'checked="" ';
                                                        }   
                                                    }
                                                ?>
                                                <div class="checkbox m-b-5 m-t-0">
                                                    <label>
                                                        <input type="checkbox" value="<?php echo $acs->access_list_id ?>" name="empAccess[]"  <?php echo $check; ?>  /> 
                                                            <?php echo ucwords($acs->access_list_portal); ?>
                                                        <a href="javascript:;"></a>
                                                    </label>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </ul>
                                </div>
                                <!-- end profile-highlight -->
                            </div>
                            <!-- end profile-left -->
                            <!-- begin profile-right -->
                            <div class="profile-right">
                                <!-- begin profile-info -->
                                <div class="profile-info">
                                    <!-- begin table -->
                                    <?php if (Session::hasFlash()): ?>
                                        <div class="alert alert-success alert-dismissable fade-msg">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            <b><i class="fa fa-check"></i></b>
                                            <?php echo ucwords(Session::flash()) ?>
                                        </div>
                                    <?php endif ?>
                                    <div class="table-responsive">
                                        <table class="table table-profile">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                        <h4>
                                                            <?php
                                                                $middle = (!is_null($emp->person_middle[0])) ? $emp->person_middle[0].'.' : null ;
                                                                echo ucwords($emp->person_first.' '.$middle.' '.$emp->person_last);
                                                            ?>
                                                        </h4>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="highlight">
                                                    <td class="">Username</td>
                                                    <td>
                                                        <input type="text" name="username" class="form-control input-width" value="<?php echo $emp->username; ?>">
                                                    </td>
                                                </tr>
                                                <tr class="divider">
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="">Password</td>
                                                    <td>
                                                        <input type="password" class="form-control input-width input-sm" value="password" readonly="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">Employee Role</td>
                                                    <td>
                                                        <select name="role" class="form-control input-width">
                                                            <?php if (!empty($data['role'])): ?>
                                                                <option value="<?php echo $emp->role_id ?>"><?php echo ucwords($emp->user_role) ?></option>
                                                                <?php foreach ($data['role'] as $role): ?>
                                                                    <?php if ($role->user_role !== $emp->user_role): ?>
                                                                        <option value="<?php echo $role->role_id ?>"><?php echo ucwords($role->user_role) ?></option>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr class="divider">
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr class="highlight">
                                                    <td colspan="2"><b>Employee Information</b></td>
                                                    <!-- <td><a href="#">Add Description</a></td> -->
                                                </tr>
                                                <tr class="divider">
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="">First Name</td>
                                                    <td>
                                                        <input type="text" name="fname" class="form-control input-width" value="<?php echo $emp->person_first ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">Middle Name</td>
                                                    <td>
                                                        <input type="text" name="mname" class="form-control input-width" value="<?php echo $emp->person_middle ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">Last Name</td>
                                                    <td>
                                                        <input type="text" name="lname" class="form-control input-width" value="<?php echo $emp->person_last ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">Birthdate</td>
                                                    <td>
                                                        <input type="date" name="bdate" class="form-control input-width" value="<?php echo $emp->person_birthdate ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">Addess</td>
                                                    <td>
                                                        <textarea name="address" class="form-control input-width" rows="3"><?php echo $emp->person_address ?></textarea>        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">&nbsp;</td>
                                                    <td class="">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="">&nbsp;</td>
                                                    <td>
                                                        <input type="hidden" name="userId" value="<?php echo $emp->user_id ?>">
                                                        <input type="hidden" name="personId" value="<?php echo $emp->person_id ?>">
                                                        <input type="hidden" name="accessId" value="<?php //echo $emp->access_list_id ?>">
                                                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                                                        <button type="submit" class="btn btn-primary input-width">Update Information</button>
                                                        <!-- <textarea name="address" class="form-control input-width" rows="3"><?php echo $emp->person_address ?></textarea>         -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table -->
                                </div>
                                <!-- end profile-info -->
                            </div>
                            <!-- end profile-right -->
                        </div>
                    </form>
                    <!-- end profile-section -->
                </div>
            <?php endforeach ?>
        <?php endif ?>

    </div>
</div>
<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>

<!-- manage-product-list-table -->
<script>
    // $(document).ready(function(){
    //         FormWizardValidation.init();
    // });  
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