<style type="text/css">
    .btn-cat-action button{
        margin-left: 2px !important;
    }
    .profile-image{
      height: auto;
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
        <h4 class="panel-title">Damage Product List</h4>
    </div>
    <div class="panel-body">
        <a href="<?php echo Url::route('product/add_damage_product') ?>" class="btn btn-primary">Add Damage Product</a>
       <br>
       <br>
        <div class="row">
            <!-- <div class="col-md-12">
                <button type="text" class="btn btn-primary">Add Damage Product</button>
                <br>
            </div> -->
            <div class="col-md-12">
                <table id="damage-product-list-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Barcode</th>
                            <th>Date</th>
                            <th>Damage Quantity</th>
                            <th style="text-align: center"><small>ACTION</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['damages'])): ?>
                            <?php $count = 1; ?>
                            <?php foreach ($data['damages'] as $damage): ?>
                               
                                <tr class="odd gradeX">
                                    <td><?php echo $count++; ?></td>
                                    <td class="text-info"><?php echo ucwords($damage->product_name) ?></td>
                                    <td><b><?php echo $damage->barcode ?></b></td>
                                    <td><b><?php echo $damage->damage_date ?></b></td>
                                    <td><b><?php echo $damage->damage_quantity.' '.strtoupper($damage->damage_quantity_type)  ?></b></td>
                                    <td align="center">
                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-white dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="true">
                                                More  <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="#modal-damage-<?php echo $damage->damage_id ?>" data-toggle="modal">
                                                        <i class="glyphicon glyphicon-search text-primary"></i> 
                                                        <span class="text-success">VIEW PRODUCT</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo Url::route('product/edit_damage_product/'.$damage->damage_id.'') ?>">
                                                        <i class="fa fa-pencil text-success"></i>
                                                        <span class="text-primary">EDIT DAMAGE</span>
                                                    </a>
                                                </li>
                                            </ul>
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




<?php if (!empty($data['damages'])): ?>
    <?php foreach ($data['damages'] as $tock): ?>
       <div class="modal fade" id="modal-damage-<?php echo $tock->damage_id ?>" style="display: none;">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                       <h4 class="modal-title">Product Information</h4>
                   </div>
                   <div class="modal-body">
                     <div class="row">
                         <div class="col-md-3">
                             <div class="profile-image">
                               <center>
                                 <?php echo App::$image->get('images/products/',['width'=>'auto'],$tock->product_id); ?>
                               </center>
                             </div>
                         </div>
                         <div class="col-md-9">
                             <table class="table table-striped table-bordered ">
                                  <tr>
                                      <td colspan=""><b><h6><?php echo ucwords($tock->product_name) ?></h6></b></td>
                                      <td colspan=""><h6 class="pull-right"><b>Date Created</b> : <b> <?php echo date('M. j, Y  ', strtotime($tock->product_insert_date))  ?> </b></h6></td>
                                  </tr>
                                  <tr>
                                      <td><b>Product Code</b></td>
                                      <td><?php echo ucwords($tock->barcode) ?></td>
                                  </tr>
                                  <tr>
                                      <td><b>Product Name</b></td>
                                      <td><?php echo ucwords($tock->product_name) ?></td>
                                  </tr>
                                  <tr>
                                      <td><b>Categoty</b></td>
                                      <td><?php echo ucwords($tock->type_name) ?></td>
                                  </tr>
                                  <tr>
                                      <td><b>Brand</b></td>
                                      <td><?php echo ucwords($tock->brand_name) ?></td>
                                  </tr>
                                  <tr class="bg-info">
                                      <td colspan="2"><b><h6>DAMAGE INFORMATION</h6></b></td>
                                  </tr>
                                  <tr>
                                      <td><b>Damage Date</b></td>
                                      <td>
                                          <?php echo date('M. j, Y  ', strtotime($tock->product_insert_date))  ?>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td><b>Damage Quantity</b></td>
                                      <td><b><?php echo  $tock->damage_quantity.' '.strtoupper($tock->damage_quantity_type)  ?></b></td>
                                  </tr>
                                  <tr class=" ">
                                      <td colspan="2"><b> Note </b></td>
                                  </tr>
                                  <tr>
                                      <td colspan="2"><p><?php echo ucwords($tock->damage_note) ?></p></td>
                                  </tr> 
                             </table>
                         </div>
                     </div>
                   </div>
                   <div class="modal-footer">
                       <a href="javascript:;" class="btn btn-sm btn-white pull-left" data-dismiss="modal">
                         Close
                       </a>
                       <a href="<?php echo Url::route('product/edit_damage_product/'.$tock->damage_id.'') ?>" class="btn btn-sm btn-primary">Edit Damage Product</a>

                   </div>
               </div>
           </div>
       </div>
    <?php endforeach ?>
<?php endif ?>









<!-- manage-product-list-table -->
<script>
        $(document).ready(function() {
            var handleDataTableSelect = function(){
                    "use strict";0!==$("#damage-product-list-table").length&&$("#damage-product-list-table").DataTable({
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