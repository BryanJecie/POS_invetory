<!-- <ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li><a href="javascript:;">UI Elements</a></li>
	<li class="active">Tabs & Accordions</li>
</ol>

<h1 class="page-header">Profile <small>header small text goes here...</small></h1>
 -->
<script src="<?php echo Url::route('public/assets/js/table-manage-rowreorder.demo.min.js'); ?>"></script>
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
		        <h4 class="panel-title">User Account </h4>
		    </div>
		    <div class="panel-body">
		        <form action="<?php echo Url::route('home/security') ?>" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <legend><small>Registration Form</small></legend>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter Username" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password"  name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter Password" required="">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="text" name="first" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Middle Name</label>
                            <input type="text" name="middle" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="text" name="last" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Role</label>
                            <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                            <select class="form-control" name="role" required="">
                                <option value="">-- select role --</option>
                                <option value="staff">Staff</option>
                                <option value="cashier">Cashier</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Add Photo</label>
                            <input name="image-file" type="file" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary m-r-5">Save</button>
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
		        <h4 class="panel-title">User List</h4>
		    </div>
		    <div class="panel-body">
                  <?php if (Session::hasFlash()): ?>
                      <?php echo Session::flash() ?>
                  <?php endif ?>
                  <table id="data-table" class="table table-striped table-bordered " width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['users'])): ?>
                                <?php foreach ($data['users'] as $user): ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo ucwords($user->first.' '.$user->middle[0].'. '.$user->last) ?></td>
                                        <td><?php echo $user->username ?></td>
                                        <td><?php echo $user->user_role ?></td>
                                        <td><label class="label label-<?php echo ($user->user_status === 'online') ? 'primary' : 'danger' ; ?>"><?php echo $user->user_status ?></label></td>
                                        <td>
                                            <button type="" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></button>
                                            <button type="" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                            <button type="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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



<script>
    $(document).ready(function(){
        // $('#form-prod-type').submit(function(e){
        //     e.preventDefault();
        //     $.ajax({
        //         url: "<?php echo Url::route('ajax/postProductType') ?>",
        //         type: 'POST',
        //         dataType: 'JSON',
        //         data: { form : $('#form-prod-type').serializeArray()  },
        //     }).done(function(data) {
        //         if (data.trg === true) {
        //             $('.tbl-prod-type tr').show('<td>Name</td>'+'<td>'+data.val+'</td>');
        //         };
        //     });
        // });

            TableManageRowReorder.init();
        // TableManageButtons.init();
    });
</script>