<style>
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
  .product-title{
    font-size: 18px;
    font-weight: bold;
  }
</style>
<!-- begin row -->
<div class="row">
  <!-- begin col-12 -->
  <div class="col-md-12">
    <!-- begin panel -->
    <div class="panel panel-inverse">
      <div class="panel-heading">
        <div class="panel-heading-btn">
          <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a> -->
          <!-- <a href="javascript:;" id="panel-reload" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a> -->
          <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->
          <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
        </div>
        <h4 class="panel-title">Add New Product</h4>
      </div>
      <div class="panel-body">
          <div class="row">
            <?php if (Session::hasFlash()): ?>
                <div class="alert alert-success alert-dismissable fade-msg">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <b><i class="fa fa-check"></i></b>
                    <?php echo ucwords(Session::flash()) ?>
                </div>
            <?php endif ?>
            <form class="form-horizontal" action="<?php echo Url::route('product/add_product') ?>" method="POST" data-parsley-validate="true" name="form-wizard" id="form-prooduct" enctype="multipart/form-data" >
              <div class="col-md-2">
                  <label><b>Product Image</b></label>
                    <div class="profile-image">
                      <center>
                          <?php echo App::$image->get('images/users/',['width'=>'auto'],null); ?>
                      </center>
                    </div>
                    <span class="btn btn-primary btn-file" style="">
                      <span style="">Select Image</span>
                      <input type="file" name="image-file" id="imgInp" >
                  </span>
              </div>
              <div class="col-md-6" style=" ">
                  <div id="wizard well">
                    <div class="form-group">
                        <label class="col-md-4 control-label"> &nbsp;</label>
                        <div class="col-md-8">
                          <label class="product-title">Product General Information</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Barcode</b> <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="barcode" class="form-control" id="barcode" placeholder="Required" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Product Name</b> <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="prodName" class="form-control" placeholder="Required" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Product Sub-Name</b> <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="prodSubName" class="form-control" placeholder="Required" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Category</b> <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="p-category" id="p-category" data-parsley-group="wizard-step-1" required >
                                <option value="">Choose Category</option>
                                <?php if (!empty($data['type'])): ?>
                                    <?php foreach ($data['type'] as $type): ?>
                                      <option value="<?php echo $type->type_id ?>"><?php echo $type->type_name ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Brand</b> <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                          <select class="form-control"   name="p-brand" id="p-brand" disabled=""></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"> &nbsp;</label>
                        <div class="col-md-8">
                          <label class="product-title">Product General Price</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Buying Price</b> <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                          <div class="input-group">
                            <span class="input-group-addon">&#8369;</span>
                            <input type="text"  class="form-control" placeholder="0.00" name="p-buying-price" data-parsley-group="wizard-step-2" required >
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label"><b>Selling Price</b> <span class="text-danger">*</span></label>
                      <div class="col-md-4">
                        <div class="input-group">
                          <span class="input-group-addon">&#8369;</span>
                          <input type="text"  class="form-control" placeholder="0.00" name="p-selling-price" data-parsley-group="wizard-step-2" required >
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-list"></i></span>
                          <select name="selling-type" class="form-control" id="sel-type" required>
                            <option value="pcs">Pcs</option>
                            <option value="box">Box</option>
                            <option value="kls">Kl's</option>
                            <option value="meter">Meter</option>
                            <option value="sacks">Sacks</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"> &nbsp;</label>
                        <div class="col-md-8">
                          <label class="product-title">Product Inventory</label>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label"><b>Quantity</b> <span class="text-danger">*</span></label>
                      <div class="col-md-4">
                           <div class="input-group">
                               <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
                               <input type="text"  name="p-quantity" class="form-control" placeholder="Required" data-parsley-group="wizard-step-3" required>
                           </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-list"></i></span>
                          <select name="p-quan-type" class="form-control" required id="pQtyType" style="text-transform:capitalize">
                            <option value="">Qty Type</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div id="typeHolder">
                        
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label"><b>Description</b> <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <textarea name="p-desc" rows="5" class="form-control"   placeholder="Text Here"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">&nbsp;</label>
                      <div class="col-md-8">
                        <input type="hidden"  name="token" value="<?php echo Token::generate() ?>">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                      </div>
                    </div>
                  </div>
              </div>
            </form>
          </div>
      </div>
    </div>
    <!-- end panel -->
  </div>
  <!-- end col-12 -->
</div>
<!-- end row -->

<!-- <pre>
  <span class="display"></span>
</pre> -->

<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>
 
<script type="text/javascript">
    $(document).ready(function(){

      var doc = $(document);
      $('#p-category').change(function(){
          var cat_id = $(this).val();
          $.post("<?php echo Url::route('ajax/getBrandName') ?>", { cat_id: cat_id}, function(data) {
            $('#p-brand').attr('disabled');  
            if (data.key === true) {
              if ($('#p-brand').val() !== null) {
                  $($('#p-brand option')).each(function() {
                     $(this).remove();
                  });
              }
              $('#p-brand').removeAttr('disabled');
              $.each(data.type, function(index, val) {
                  $('#p-brand').append(val);
              });   
            }
          },"JSON");
      });
      FormPlugins.init();
      
      FormWizardValidation.init();

      setBarcodes();
      function setBarcodes() {
        $.ajax({
          url: "<?php echo Url::route('product/loadBarcodes') ?>",
          type: 'POST',
          dataType: 'JSON',
          data: { key : true},
        })
        .done(function(data) {
          $("#barcode").autocomplete({
            source : data.list,
            // select : function (event, ui) {
            //    }
          });
        });
      }

      doc.on('focusout' , '#barcode', function(){
          var $this = $(this);
          var barcode = $this.val();
          var form =  $('#form-prooduct');
          $.ajax({
            url: "<?php echo Url::route('product/loadProductInfo') ?>",
            type: 'POST',
            dataType: 'JSON',
            data: { barcode : barcode },
          })
          .done(function(data) {
              console.log(data)
            if (data.key === true) {
              $('#p-brand').removeAttr('disabled');
               
               $(data.product).each(function(ind, ele){
                  $('#form-prooduct [name=prodName]').val(ele.product_name);
                  $('#form-prooduct [name=prodSubName]').val(ele.product_subname);
                  $('#form-prooduct [name=p-category]').html("<option value="+ele.type_id+"> "+ele.type_name+" </option>");
                  $('#form-prooduct [name=p-brand]').html("<option value="+ele.brand_id+"> "+ele.brand_name+" </option>");
               });
            }
            else{
              $('#form-prooduct [name=prodName]').val(null);
              $('#form-prooduct [name=prodSubName]').val(null);
              $('#form-prooduct [name=p-category]').html(data.opt);
              $('#form-prooduct [name=p-brand]').attr('disabled', true).html("");
            }
          });
      });

      doc.on('change', '#pQtyType, #sel-type', function(){
        var $this      = $(this);
        var parent     = $this.parent().parent().parent();
        var typeVal    = $this.val();
        var selTypeVal = $('#sel-type').val();

        if ($this.attr('id') === 'sel-type') {
          parent.siblings('#typeHolder').html(null); 
          parent.siblings('div').find('#pQtyType').html(null); 

          var typeArray = new Array('pcs', 'box', 'sacks');

          switch($this.val()){
            case 'pcs':
              var opt ='';
              $(typeArray).each(function(i, e){
                opt += '<option value="'+e+'" >'+e+'</option>';
              });
              parent.siblings('div').find('#pQtyType').append(opt);
            break;
            case 'box':
             $(typeArray).each(function(i, e){
               if (e === 'box') {
                opt += '<option value="'+e+'" >'+e+'</option>';
               }
             });
             parent.siblings('div').find('#pQtyType').append(opt);
            break;
            case 'kls':
             $(typeArray).each(function(i, e){
               if (e !== 'pcs') {
                opt += '<option value="'+e+'" >'+e+'</option>';
               }
             });
             parent.siblings('div').find('#pQtyType').append(opt);
            break;
            case 'meter':
              $(typeArray).each(function(i, e){
                if (e !== 'pcs') {
                  opt += '<option value="'+e+'" >'+e+'</option>';
                }
              });
              parent.siblings('div').find('#pQtyType').append(opt);
            break;
            case 'sacks':
              $(typeArray).each(function(i, e){
                if (e !== 'pcs' && e !== 'box') {
                 opt += '<option value="'+e+'" >'+e+'</option>';
                }
              });
              parent.siblings('div').find('#pQtyType').append(opt);
            break;
          }
          $('#pQtyType').trigger('change');
        }
        else{
          if (selTypeVal !== typeVal){
            parent.siblings('#typeHolder').html(null); 

            switch(typeVal){
              case 'box':
                parent.siblings('#typeHolder').append(divHolder(selTypeVal, typeVal));
              break;
              case 'sacks':
                parent.siblings('#typeHolder').append(divHolder(selTypeVal, typeVal));
              break;

            }
          }
        }
      });
      $('#sel-type').trigger('change');
    });

    function divHolder(name, type) {
      return '<div class="form-group" id="typeHolder">'+
             ' <label class="col-md-4 control-label"><b style="text-transform:capitalize">'+name+'/'+type+'</b> <span class="text-danger">*</span></label>'+
             ' <div class="col-md-8">'+
             '   <div class="input-group">'+
             '     <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>'+
             '     <input type="text"  class="form-control" placeholder="0.00" name="pTypeQty" data-parsley-group="wizard-step-2" required >'+
             '   </div>'+
             ' </div>'+
             '</div><br>';
    }
    /* Get Barcode */
    // loadBarcode();
    // function loadBarcode(){
    //   $.ajax({
    //     url: "<?php echo Url::route('product/loadBarcode') ?>",
    //     type: 'POST',
    //     dataType: 'JSON',
    //     data: { true : true },
    //   })
    //   .done(function(data) {
    //     // console.log(data)
    //     $("#barcode").autocomplete({
    //       source : data.stdInfo,
    //       select : function (event, ui) {
    //               // studentName = ui.item.value;
    //         // console.log(studentName);
                  
    //               // var input = $('.search-student-dev a').attr('href'); 
                    
    //               // console.log(input);
    //           }
    //     });
    //   });
    // }

       







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


