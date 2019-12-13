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
        <h4 class="panel-title">Remaining Products</h4>
    </div>
    <div class="panel-body">
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
        <div class="row">
            <div class="col-md-12">
                <table id="category-sub-list-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Product Name</th>
                            <th>Barcode</th>
                            <th>Inventory</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php if (!empty($data['sales'])): ?>
                            <?php foreach ($data['sales'] as $sale): ?>
                                 <tr class="odd gradeX">
                                     <td><?php echo $count++; ?></td>
                                     <td><?php echo  $sale->type_name ?></td>
                                     <td><?php echo  $sale->brand_name ?></td>
                                     <td><?php echo  $sale->product_name ?></td>
                                     <td><?php echo  $sale->barcode ?></td>
                                     <td><?php echo  $sale->sales_quantity ?></td>
                                     <td>
                                        <div class="btn-group btn-cat-action">
                                            <a href="#modal-dialog-<?php echo $sale->sales_id ?>" data-toggle="modal" class="btn btn-primary btn-xs">
                                                <i class="fa fa-search"></i>
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
        
        <?php if (!empty($data['sales'])): ?>
            <?php foreach ($data['sales'] as $sale): ?>
                 <div class="modal fade" id="modal-dialog-<?php echo $sale->sales_id ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="profile-container">
                                <div class="profile-section">
                                    <!-- begin profile-left -->
                                    <div class="profile-left">
                                        <!-- begin profile-image -->
                                        <div class="profile-image">
                                            <img src="assets/img/profile-cover.jpg" />
                                            <i class="fa fa-user hide"></i>
                                        </div>
                                        <!-- end profile-image -->
                                       <!--  <div class="m-b-10">
                                            <a href="#" class="btn btn-warning btn-block btn-sm">Change Picture</a>
                                        </div> -->
                                    </div>
                                    <!-- end profile-left -->
                                    <!-- begin profile-right -->
                                    <div class="profile-right">
                                        <!-- begin profile-info -->
                                        <div class="profile-info">
                                            <!-- begin table -->
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                                <h4><?php echo $sale->product_name; ?> </h4>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="highlight">
                                                            <td class="">Category</td>
                                                            <td><a href="#">Add Mood Message</a></td>
                                                        </tr>
                                                        <tr class="divider">
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Brand</td>
                                                            <td><i class="fa fa-mobile fa-lg m-r-5"></i> +1-(847)- 367-8924 <a href="#" class="m-l-5">Edit</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Product Name</td>
                                                            <td><a href="#">Add Number</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Office</td>
                                                            <td><a href="#">Add Number</a></td>
                                                        </tr>
                                                        <tr class="divider">
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr class="highlight">
                                                            <td class="">About Me</td>
                                                            <td><a href="#">Add Description</a></td>
                                                        </tr>
                                                        <tr class="divider">
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Country/Region</td>
                                                            <td>
                                                                <select class="form-control input-inline input-xs" name="region">
                                                                    <option value="US" selected>United State</option>
                                                                    <option value="AF">Afghanistan</option>
                                                                    <option value="AL">Albania</option>
                                                                    <option value="DZ">Algeria</option>
                                                                    <option value="AS">American Samoa</option>
                                                                    <option value="AD">Andorra</option>
                                                                    <option value="AO">Angola</option>
                                                                    <option value="AI">Anguilla</option>
                                                                    <option value="AQ">Antarctica</option>
                                                                    <option value="AG">Antigua and Barbuda</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">City</td>
                                                            <td>Los Angeles</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">State</td>
                                                            <td><a href="#">Add State</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Website</td>
                                                            <td><a href="#">Add Webpage</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Gender</td>
                                                            <td>
                                                                <select class="form-control input-inline input-xs" name="gender">
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Birthdate</td>
                                                            <td>
                                                                <select class="form-control input-inline input-xs" name="day">
                                                                    <option value="04" selected>04</option>
                                                                </select>
                                                                -
                                                                <select class="form-control input-inline input-xs" name="month">
                                                                    <option value="11" selected>11</option>
                                                                </select>
                                                                -
                                                                <select class="form-control input-inline input-xs" name="year">
                                                                    <option value="1989" selected>1989</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="">Language</td>
                                                            <td>
                                                                <select class="form-control input-inline input-xs" name="language">
                                                                    <option value="" selected>English</option>
                                                                </select>
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
                            </div>
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


<script>

        $(document).ready(function() {

            var handleDataTableSelect = function(){
                    "use strict";0!==$("#category-sub-list-table").length&&$("#category-sub-list-table").DataTable({
                        select:!0,responsive:!0}
                    )},

                TableManageTableSelect = function(){
                    "use strict";
                return{ init:function(){
                    handleDataTableSelect()}
                }}();

            TableManageTableSelect.init();
            FormWizardValidation.init();

        });
        
    </script>