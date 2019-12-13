<style>
    #form-edit-product div label span{
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
        <h4 class="panel-title">Edit Damage Product Information</h4>
    </div>
    <div class="panel-body" style="background-color:#fff">
        <form class="form-horizontal" id="form-edit-product" method="POST" action="<?php echo Url::route('product/edit_damage_product/'.$data['damageId'].'') ?>" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="row"> 
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <?php if (Session::hasFlash()): ?>
                    <div class="alert alert-success fade in m-b-15 fade-msg">
                        <strong><i class="fa fa-check"></i></strong>
                         <?php echo Session::flash() ?>  
                        <span class="close" data-dismiss="alert">×</span>
                    </div>
                <?php endif ?>
                <center><h4>DAMAGE FORM</h4></center>
              </div>
              <div class="col-md-4"></div>
            </div>  
            <br>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Product Barcode <span>*</span></label>
                        <div class="col-md-5">
                            <input type="hidden" name="barcode_id" class="form-control" value="<?php echo $data['product']->barcode_id ?>" />
                            <input type="text" name="barcode" class="form-control" value="<?php echo $data['product']->barcode ?>" readonly="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Damage Quantity <span>*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="quantity" class="form-control" value="<?php echo $data['product']->damage_quantity ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Quantity Type <span>*</span></label>
                        <div class="col-md-5">
                            <select name="quantity-type" class="form-control">
                                <option value="<?php echo $data['product']->damage_quantity_type ?>"><?php echo strtoupper($data['product']->damage_quantity_type) ?></option>
                            <?php 

                                $opts = array('pcs', 'box' , 'sacks');

                                for($x = 0; $x < count($opts); $x++){
                                    if ($opts[$x] !== $data['product']->damage_quantity_type) { ?>
                                      <option value="<?php echo $opts[$x] ?>"> <?php echo strtoupper($opts[$x]) ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Note <span>*</span></label>
                        <div class="col-md-5">
                            <textarea name="note" class="form-control" rows="3"><?php echo $data['product']->damage_note ?></textarea>
                        </div>
                    </div>
                     
                    <div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <div class="col-md-5">
                            <input type="hidden" name="token"  value="<?php echo Token::generate() ?>" />
                            <button type="submit" class="btn btn-sm btn-success pull-right">Update Damage</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



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