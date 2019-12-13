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
    .product-title{
      font-size: 18px;
      font-weight: bold;
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
        <h4 class="panel-title">Edit Product Information</h4>
    </div>
    <div class="panel-body" style="background-color:#fff">
        <form class="form-horizontal" id="form-edit-product" method="POST" action="<?php echo Url::route('product/edit_product/edit?id=').$data['product']['info']->stockin_id ?>" accept-charset="utf-8" data-parsley-validate="true" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-2">
                  <div class="profile-image">
                    <center>
                      <?php echo App::$image->get('images/products/',['width'=>'auto'],$data['product']['info']->product_id); ?>
                    </center>
                  </div>
                  <span class="btn btn-primary btn-file " style="">
                    <span style="">browse image</span>
                    <input type="file" name="image-file" id="imgInp" >
                </span>
                </div>
                <div class="col-md-9">
                   <?php if (Session::hasFlash()): ?>
                       <div class="alert alert-success alert-dismissable fade-msg">
                           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                           <b><i class="fa fa-check"></i></b>
                           <?php echo ucwords(Session::flash()) ?>
                       </div>
                   <?php endif ?>      
                    <div id="wizard well">
                      <div class="form-group">
                          <label class="col-md-3 control-label"> &nbsp;</label>
                          <div class="col-md-5">
                            <label class="product-title">Product General Information</label>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><b>Barcode</b> <span class="text-danger">*</span></label>
                          <div class="col-md-5">
                            <input type="hidden" name="barcode_id" class="form-control" value="<?php echo $data['product']['info']->barcode_id ?>" placeholder="Disabled input" />
                            <input type="text" name="barcode" class="form-control" value="<?php echo $data['product']['info']->barcode ?>" placeholder="Disabled input" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><b>Product Name</b> <span class="text-danger">*</span></label>
                          <div class="col-md-5">
                            <input type="hidden" name="product_id" class="form-control" value="<?php echo $data['product']['info']->product_id ?>" />
                            <input type="hidden" name="stockin_id" class="form-control" value="<?php echo $data['product']['info']->stockin_id ?>" />
                            <input type="text" name="product-name" class="form-control" value="<?php echo $data['product']['info']->product_name ?>" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><b>Product Sub-Name</b> <span class="text-danger">*</span></label>
                          <div class="col-md-5">
                            <input type="text" name="product-subname" class="form-control" value="<?php echo $data['product']['info']->product_subname ?>" />

                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><b>Category</b> <span class="text-danger">*</span></label>
                          <div class="col-md-5">
                              <select class="form-control" name="cat-type" id="p-category" data-parsley-group="wizard-step-1" required >
                                  <option value="<?php echo $data['product']['type']->type_id ?>"><?php echo ucwords($data['product']['type']->type_name) ?></option>
                                  <?php 
                                        $types = Query::getSql()->query("SELECT * FROM product_type");
                                        if ($types->_count > 0) {
                                            foreach ($types->_result as $type) {
                                               if ($type->type_name !== $data['product']['type']->type_name) { ?>
                                                    <option value="<?php echo $type->type_id ?>"><?php echo ucwords($type->type_name); ?></option>
                                  <?php } } } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><b>Brand</b> <span class="text-danger">*</span></label>
                          <div class="col-md-5">
                            <select class="form-control" name="brand" id="e-brand">
                             <option value="<?php echo $data['product']['brand']->brand_id ?>"><?php echo ucwords($data['product']['brand']->brand_name) ?></option>
                                <?php $typeId = $data['product']['type']->type_id;
                                      $brands = Query::getSql()->query("SELECT * FROM product_brand WHERE type_id = {$typeId} ");
                                      if ($brands->_count > 0) {
                                          foreach ($brands->_result as $brand) {
                                             if ($brand->brand_name !== $data['product']['brand']->brand_name) { ?>
                                                  <option value="<?php echo $brand->brand_id ?>"><?php echo ucwords($brand->brand_name); ?></option>
                                <?php } } } ?>
                            </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"> &nbsp;</label>
                          <div class="col-md-5">
                            <label class="product-title">Product General Price</label>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><b>Buying Price</b> <span class="text-danger">*</span></label>
                          <div class="col-md-5">
                            <div class="input-group">
                              <span class="input-group-addon">&#8369;</span>
                              <input type="text" name="buying-price" class="form-control" value="<?php echo $data['product']['info']->stockin_buying_price ?>" />
                            </div>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label"><b>Selling Price</b> <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                          <div class="input-group">
                            <span class="input-group-addon">&#8369;</span>
                            <input type="text" name="selling-price" class="form-control" value="<?php echo $data['product']['info']->stockin_selling_price ?>" />
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-list"></i></span>
                            <select name="selling-qty-type" class="form-control" id="selling-qty-type">
                                <option value="<?php echo $data['product']['info']->stockin_selling_type ?>"><?php echo ucwords($data['product']['info']->stockin_selling_type) ?></option>
                                <?php $types = array('pcs', 'kls', 'meter', 'box', 'sacks');
                                    foreach ($types as $type) {
                                        if ($type !== $data['product']['info']->stockin_selling_type) { ?>
                                            <option value="<?php echo $type ?>"> <?php echo ucwords($type); ?></option> 
                                <?php } } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"> &nbsp;</label>
                          <div class="col-md-5">
                            <label class="product-title">Product Inventory</label>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label"><b>Quantity</b> <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                             <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
                                 <input type="text" name="product-quantity" class="form-control" value="<?php echo $data['product']['info']->stockin_quantity ?>" />
                             </div>
                        </div>
                        <div class="col-md-3">
                          <div class="input-group"> <!-- stockin_quantity_per -->
                            <span class="input-group-addon"><i class="fa fa-list"></i></span>
                              <select name="product-quantity-type" class="form-control" id="product-quantity-type" style="text-transform: capitalize;">
                                  <option value="<?php echo $data['product']['info']->stockin_quantity_type ?>"><?php echo ucwords($data['product']['info']->stockin_quantity_type) ?></option>
                                  <?php $types = array('pcs','box', 'sacks');
                                      foreach ($types as $type) {
                                          if ($type !== $data['product']['info']->stockin_quantity_type) { ?>
                                            <option value="<?php echo $type ?>"> <?php echo ucwords($type); ?></option> 
                                  <?php } } ?>
                              </select>
                          </div>
                        </div>
                      </div>
                      <span class="div-per-qty <?php echo (is_null($data['product']['info']->stockin_quantity_per)) ? 'hide' : null ?>">
                          <div class="form-group">
                              <label class="col-md-3 control-label">
                                <b>
                                    <?php echo ucwords($data['product']['info']->stockin_selling_type) ?>/
                                    <?php echo ucwords($data['product']['info']->stockin_quantity_type) ?>
                                </b> <span class="text-danger">*</span>
                              </label>
                              <div class="col-md-5">
                                <div class="input-group">
                                  <span class="input-group-addon">&#8369;</span>
                                  <input type="text" name="quantity-type-per" class="form-control" value="<?php echo $data['product']['info']->stockin_quantity_per ?>" />
                                </div>
                              </div>
                          </div>
                      </span>
                      <br>
                      <!-- <div id="typeHolder"></div> -->
                      <div class="form-group">
                        <label class="col-md-3 control-label"><b>Description</b> <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <textarea name="desc" class="form-control" rows="3"><?php echo $data['product']['info']->product_desc ?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">&nbsp;</label>
                        <div class="col-md-5">
                          <input type="hidden"  name="token" value="<?php echo Token::generate() ?>">
                          <button type="submit" class="btn btn-success pull-right">Update Product</button>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    $(function() {
        var doc = $(document);
        $('#p-category').change(function(){
            var cat_id = $(this).val();
            $.post("<?php echo Url::route('ajax/getBrandName') ?>", { cat_id: cat_id}, function(data) {
              if (data.key === true) {
                $('#e-brand').html("");
                $.each(data.type, function(index, val) {
                    console.log(val)
                    $('#e-brand').append(val);
                });  
              }
            },"JSON");
        });

        doc.on('change', '#selling-qty-type', function(){
          var $this = $(this);
          var sel_type_val = $this.val();
          var prod_qty_val = $('#product-quantity-type').val();
          var typeArray    = new Array('pcs', 'box', 'sacks');
       
          $('#product-quantity-type').html("");
          $('.div-per-qty').html("");

          switch(sel_type_val){
            case 'pcs':
              var opt ='';
              $(typeArray).each(function(i, e){
                opt += '<option value="'+e+'" >'+e+'</option>';
              });

              $('#product-quantity-type').append(opt);
            break;
            case 'box':
             $(typeArray).each(function(i, e){
               if (e === 'box') {
                opt += '<option value="'+e+'" >'+e+'</option>';
               }
             });
             $('#product-quantity-type').append(opt);
            break;
            case 'kls':
             $(typeArray).each(function(i, e){
               if (e !== 'pcs') {
                opt += '<option value="'+e+'" >'+e+'</option>';
               }
             });
             $('#product-quantity-type').append(opt);
             $('#product-quantity-type').trigger('change');
            break;
            case 'meter':
              $(typeArray).each(function(i, e){
                if (e !== 'pcs') {
                  opt += '<option value="'+e+'" >'+e+'</option>';
                }
              });
              $('#product-quantity-type').append(opt);
              $('#product-quantity-type').trigger('change');
            break;
            case 'sacks':
              $(typeArray).each(function(i, e){
                if (e !== 'pcs' && e !== 'box') {
                 opt += '<option value="'+e+'" >'+e+'</option>';
                }
              });
              $('#product-quantity-type').append(opt);
            break;
          } 


            
        });
        doc.on('change', '#product-quantity-type', function(){
          var $this        = $(this);
          var prod_qty_val = $this.val();
          var sel_qty_type = $('#selling-qty-type').val();
        
         $('.div-per-qty').html("");
         
          if (prod_qty_val === 'pcs' && sel_qty_type === 'pcs') {
            $('.div-per-qty').html("");
          }
          else{
            $('.div-per-qty').append(divHolder(sel_qty_type , prod_qty_val));
          }

        });
        // $('#selling-qty-type').trigger('change');

    });






    function divHolder(name, type) {
      return '<div class="form-group" id="typeHolder">'+
             ' <label class="col-md-3 control-label"><b style="text-transform:capitalize">'+name+'/'+type+'</b> <span class="text-danger">*</span></label>'+
             ' <div class="col-md-5">'+
             '   <div class="input-group">'+
             '     <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>'+
             '     <input type="text"  class="form-control" placeholder="0.00" name="quantity-type-per" data-parsley-group="wizard-step-2" required >'+
             '   </div>'+
             ' </div>'+
             '</div><br>';
    }


    /*==== image area here =========*/
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