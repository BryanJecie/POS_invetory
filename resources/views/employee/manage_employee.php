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
        <h4 class="panel-title">Manage Employee</h4>
    </div>
    <div class="panel-body">
        
        <div class="row">
            <div class="col-md-12">
                <?php if (Session::hasFlash()) : ?>
                    <div class="alert alert-danger alert-dismissable fade-msg">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <b><i class="fa fa-check"></i></b>
                        <?php echo ucwords(Session::flash()) ?>
                    </div>
                <?php endif ?>
                <table id="manage-customer-list-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>Employee No</th>
                            <th>Username</th>
                            <th>Full-Name</th>
                            <th>Birthdate</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['employee']) and is_array($data['employee'])) : ?>
                            <?php foreach ($data['employee'] as $value) : ?>
                                <?php if ($value->user_role !== "admin") : ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $value->person_no ?></td>
                                        <td><b><?php echo $value->username ?></b></td>
                                        <td><?php echo ucwords($value->person_first . ' ' . $value->person_middle[0] . ' ' . $value->person_last) ?></td>
                                        <td><?php echo $value->person_birthdate ?></td>
                                        <td><label class="label label-<?php echo ($value->user_status == "online") ? 'primary' : 'danger'; ?>"><?php echo $value->user_status ?></label></td>
                                        <td>
                                            <div class="btn-group btn-cat-action">
                                                <a href="<?php echo Url::route('employee/edit_employee/view?empId=' . $value->user_id . ' ') ?>" class="btn btn-inverse btn-sm">
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </a>
                                                <a href="#modal-edit-<?php echo $value->user_id ?>" class="btn btn-success btn-sm"  data-toggle="modal">
                                                    <i class="glyphicon glyphicon-search"></i>
                                                </a>
                                                <!-- <div class="btn-group m-r-5 m-b-5 pull-right">
                                                    <a href="javascript:;" data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-xs" title="" data-toggle="tooltip" data-placement="top" data-original-title="delete" aria-expanded="false">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </a>
                                                    <ul class="dropdown-menu bg-red">
                                                        <li><a href="<?php echo Url::route('employee/manage_employee/delete/userId?=' . $value->user_id . ' ') ?>">YES</a></li>
                                                        <li><a href="javascript:;">NO</a></li>
                                                    </ul>
                                                </div> -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>

                <?php if (!empty($data['employee']) and is_array($data['employee'])) : ?>
                    <?php foreach ($data['employee'] as $value) : ?>
                        <div class="modal fade" id="modal-edit-<?php echo $value->user_id ?>">
                            <div class="modal-dialog modal-lg">
                                 <div class="modal-content">
                                    <div class="modal-header" style="background-color: #ccc">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">
                                            <i class="fa fa-user"></i>
                                            Employee
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo Url::route('employee/add_employee') ?>" method="POST" data-parsley-validate="true" name="form-wizard">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    <legend><small>Employee Information</small></legend>
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">Employee ID <span>*</span></label>
                                                            <input type="text"  name="emp-no" value="<?php echo $value->person_no ?>" class="form-control" readonly/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">Username <span>*</span></label>
                                                            <input type="text"  name="username" value="<?php echo $value->username ?>" class="form-control" id="exampleInputPassword1" placeholder="Enter Username" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">Password <span>*</span></label>
                                                            <input type="password" value="password"  name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">Role <span>*</span></label>
                                                            <input type="text" name="" class="form-control" value="<?php echo ucwords($value->user_role) ?>">
                                                        </div>
                                                        <hr>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">First Name <span>*</span></label>
                                                            <input type="text" value="<?php echo $value->person_first ?>" name="first" class="form-control" id="exampleInputPassword1" placeholder="First Name" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">Middle Name <span>*</span></label>
                                                            <input type="text" name="middle" value="<?php echo $value->person_middle ?>"  class="form-control" id="exampleInputPassword1" placeholder="Last Name" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">Last Name <span>*</span></label>
                                                            <input type="text" name="last" value="<?php echo $value->person_last ?>"  class="form-control" id="exampleInputPassword1" placeholder="Last Name" required/>
                                                        </div>
                                                       
                                                         
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">Birthdate <span>*</span></label>
                                                            <input type="date" name="birthdate" class="form-control" id="exampleInputPassword1" value="<?php echo date('Y-m-d') ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="custom-label">Address <span>*</span></label>
                                                            <textarea name="address" class="form-control" rows="3" placeholder="Address" value=""><?php echo $value->person_address ?></textarea>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-3">
                                                    <!-- <fieldset> -->
                                                        <legend><small>User Accessibility</small></legend>
                                                        <?php 
                                                        $userAcs = DB::table('accessibility INNER JOIN accessibility_list ON accessibility.access_list_id = accessibility_list.access_list_id')
                                                            ->where(['user_id', '=', $value->user_id])
                                                            ->all();
                                                        ?>
                                                        <?php if (!empty($userAcs)) : ?>
                                                            <?php foreach ($userAcs as $acs) : ?>
                                                               <div class="checkbox">
                                                                   <label>
                                                                       <input type="checkbox" name="access[]" value="" checked>
                                                                       <?php echo ucwords($acs->access_list_portal) ?>
                                                                   </label>
                                                               </div>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                    <!-- </fieldset> -->
                                                </div>

                                                <div class="col-md-2"></div>
                                                <div class="col-md-3">
                                                <br>
                                                    <legend><small>Employee Image</small></legend>
                                                    <div class="profile-image">
                                                        <center>
                                                            <?php echo App::$image->get('images/users/', ['width' => 'auto'], $value->user_id); ?>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo Url::route('employee/edit_employee/edit?empId=' . $value->person_id . ' ') ?>" class="btn btn-sm btn-primary pull-left" >Edit Employee</a>
                                        <a href="javascript:;" class="btn btn-sm btn-success" data-dismiss="modal">Ok</a>
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