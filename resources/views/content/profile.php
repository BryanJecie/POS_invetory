<!-- <ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li><a href="javascript:;">UI Elements</a></li>
	<li class="active">Tabs & Accordions</li>
</ol>

<h1 class="page-header">Profile <small>header small text goes here...</small></h1>
 -->
<script src="<?php echo Url::route('public/assets/js/table-manage-rowreorder.demo.min.js'); ?>"></script>

<style>
    .div-tbl-prod_type{
        height: 200px;
        overflow: scroll;
    }
</style>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-inverse">
		    <div class="panel-heading">
		        <div class="panel-heading-btn">
		            <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a> -->
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
		        </div>
		        <h4 class="panel-title">Profile </h4>
		    </div>
		    <div class="panel-body">
		        <form action="<?php echo Url::route('home/profile') ?>" method="POST">
                    <fieldset>
                        <legend><small>Registration Form</small></legend>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" required="">
                        </div>
                        <label for="exampleInputPassword1">Product Type</label>
                        <div class="input-group">
                            <select name="type" class="form-control" required="">
                                <option value=""> -- Select Product type --</option>
                                <?php if (!is_null($data['prod_type'])): ?>
                                    <?php foreach ($data['prod_type'] as $prod_type): ?>
                                        <option value="<?php echo $prod_type->prod_id ?>">
                                            <?php echo $prod_type->prod_type ?>
                                        </option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                            <div class="input-group-btn">
                            <a href="#product-type-modal" class="btn btn-success" data-toggle="modal"> <i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Size</label>
                            <input type="text" name="size" class="form-control" id="exampleInputEmail1" placeholder="Enter Size" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Weight</label>
                            <input type="text" name="weight" class="form-control" id="exampleInputEmail1" placeholder="Enter Weight" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email"> -->
                            <textarea class="form-control" name="desc" rows="3" placeholder="Product Description "></textarea>
                        </div>
                       <!--  <div class="checkbox">
                            <label>
                                <input type="checkbox"> Check me out
                            </label>
                        </div> -->
                            <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

                        <button type="submit" class="btn btn-sm btn-primary m-r-5">Save</button>
                        <!-- <button type="submit" class="btn btn-sm btn-default">Cancel</button> -->
                    </fieldset>
                </form>
		    </div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-inverse">
		    <div class="panel-heading">
		        <div class="panel-heading-btn">
		            <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a> -->
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
		        </div>
		        <h4 class="panel-title">List of Product Profile</h4>
		    </div>
		    <div class="panel-body">
                <?php if (Session::hasFlash()): ?>
                    <div class="alert alert-success fade in m-b-15">
                        <strong>Success!</strong>
                        <?php echo Session::flash() ?> 
                        <span class="close" data-dismiss="alert">×</span>
                    </div>
                <?php endif ?>
		            <table id="data-table" class="table table-striped table-bordered " width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['profile'])): ?>
                                <?php foreach ($data['profile'] as $prof): ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $prof->prof_name ?></td>
                                        <td><?php echo $prof->prod_type ?></td>
                                        <td><?php echo $prof->prof_size ?></td>
                                        <td><?php echo $prof->prof_weight ?></td>
                                        <td>
                                            <button type="" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></button>
                                            <button type="" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
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



<!-- #modal-without-animation  CASH IN-->
<div class="modal" id="product-type-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="pull-right btn-xs btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                <h4 class="modal-title"><i class="fa fa-desktop"></i> Product Type</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form-prod-type" name="form-prod-type">
                    <center> <h3>Product Type Form</h3> </center>
                    <br>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><b>Name</b></label>
                        <div class="col-md-8">
                            <input type="text" name="name" class="form-control" placeholder="" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><b>&nbsp;</b></label>
                        <div class="col-md-8 div-tbl-prod_type">
                            <table class="table table-bordered tbl-prod-type">
                                <?php if (!is_null($data['prod_type'])): ?>
                                    <?php foreach ($data['prod_type'] as $prod_type): ?>
                                        <tr>
                                            <td>Name</td>
                                            <td><?php echo $prod_type->prod_type ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </table>
                        </div>
                       
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><b>&nbsp;</b></label>
                        <div class="col-md-6">
                            <!-- <textarea class="form-control" rows="4"></textarea> -->
                            <button type="submit" class="btn btn-primary pull-right"> Add</button>
                            <button type="text" data-dismiss="modal" class="btn btn-danger pull-right" style="margin-right: 10px !important;"> Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <a href="javascript:;" class="btn btn-md btn-modal-pay btn-success pull-left" data-dismiss="modal">PAY</a>
            </div> -->
        </div>
    </div>
</div>


 
<script>
    $(document).ready(function(){
        $('#form-prod-type').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: "<?php echo Url::route('ajax/postProductType') ?>",
                type: 'POST',
                dataType: 'JSON',
                data: { form : $('#form-prod-type').serializeArray()  },
            }).done(function(data) {
                if (data.trg === true) {
                    $('.tbl-prod-type tr').show('<td>Name</td>'+'<td>'+data.val+'</td>');
                };
            });
        });

            TableManageRowReorder.init();
        // TableManageButtons.init();
    });
</script>