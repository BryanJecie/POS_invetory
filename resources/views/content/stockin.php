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
		        <h4 class="panel-title">Stock in</h4>
		    </div>
		    <div class="panel-body">
            <legend><small>Stockin Form</small></legend>
		        <form action="<?php Url::route('home/sotckin') ?>" method="POST">
                  <fieldset>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Product Name</label>
                          <select name="prof-id" class="form-control" id="exampleInputEmail1" required="">
                            <option value="">-- select product --</option>
                            <?php if (!empty($data['profile'])): ?>
                              <?php foreach ($data['profile'] as $name ) : ?>
                                <option value="<?php echo $name->prof_id ?>"><?php echo $name->prof_name ?></option>
                              <?php endforeach ?>
                            <?php endif ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Barcode</label>
                          <input type="text" name="barcode" class="form-control" id="exampleInputEmail1" placeholder="Enter Barcode" required="">
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Quanity</label>
                          <input type="number" name="quanity" class="form-control" id="exampleInputEmail1" placeholder="<?php echo number_format(0) ?>" required="">
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Date Input</label>
                          <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d') ?>" id="exampleInputEmail1" placeholder="Enter Weight" >
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Selleng Price</label>
                          <input type="text" name="price" class="form-control numbers" id="exampleInputEmail1" placeholder="<?php echo number_format(0,2) ?>" step="0.1" required="">
                      </div>
                       <div class="form-group">
                          <label for="exampleInputEmail1">Description</label>
                          <textarea name="desc" class="form-control" rows="3" placeholder="Description "></textarea>
                          <input type="hidden" value="<?php echo Token::generate() ?>" name="token">
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
		        <h4 class="panel-title">Stockin History</h4>
		    </div>
		    <div class="panel-body">
            <?php if (Session::hasFlash()): ?>
              <div class="alert alert-success fade in m-b-15 noti-fade">
                <strong>Success!</strong>
                 <?php echo Session::flash() ?>
                <span class="close" data-dismiss="alert">×</span>
              </div>
            <?php endif ?>
            <legend><small>List Stockin Product</small></legend>
		        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Quanity</th>
                        <th>Date Stockin</th>
                        <th>Price</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php if (!empty($data['stockin'])): ?>
                    <?php foreach ($data['stockin'] as $stockin): ?>
                        <tr class="odd gradeX">
                            <td><?php echo $stockin->prof_name ?></td>
                            <td><?php echo $stockin->barcode ?></td>
                            <td><?php echo $stockin->stock_quantity ?> <?php echo ($stockin->stock_quantity > 1) ? 'Pcs.' : 'Pc.' ; ?></td>
                            <td><?php echo $stockin->stock_input ?></td>
                            <td><b>Php <?php echo $stockin->stock_price ?></b></td>
                            <td>
                              <button type="" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></button>
                              <button type="" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button>
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