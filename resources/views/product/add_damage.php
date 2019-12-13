<style type="text/css" media="screen">
  .damage-qty li{
    float: left;
    list-style-type: none;
    margin-right:40px;
  }
   .damage-qty{
    margin-left: -40px;

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
        <h4 class="panel-title">Add Damage Product </h4>
    </div>
    <div class="panel-body">
        <h4><center>Damage Form</center></h4>
        <br>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php if (Session::hasFlash()): ?>
                 <div class="alert alert-danger alert-dismissable fade-msg">
                     <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                     <b><i class="fa fa-times-circle"></i></b>
                     <?php echo ucwords(Session::flash()) ?>
                 </div>
                <?php endif ?>
            </div>
            <div class="col-md-3"></div>
        </div>
        <form class="form-horizontal" action="<?php echo Url::route('product/add_damage_product') ?>" method="POST" data-parsley-validate="true">
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Product Code</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <input type="text" id="barcode" name="barcode" class="form-control" placeholder="Enter Code" required>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Product Quantity</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <ul class="damage-qty">
                       <li> 
                          <input type="text" class="form-control" name="quantity" placeholder="0" required="" autocomplete="off">
                        </li>
                       <li>
                         <select name="quanity-type" class="form-control" required=""  style=" width: 47%; position: absolute;">
                           <option value="">Choose Quantity Type</option>
                           <option value="pcs">Pcs</option>
                           <option value="sacks">Sacks</option>
                           <option value="box">Box</option>
                         </select>
                       </li>
                    </ul> 
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Note</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <textarea name="note" rows="4" class="form-control" placeholder="Note Here" required></textarea>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-md-4 control-label"><b>Stocks</b><span style="color:red"> *</span></label>
                <div class="col-md-5">
                    <select name="decrease" class="form-control" required>
                      <option value="">Decrease From Stocks?</option>
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">&nbsp;</label>
                <div class="col-md-5">
                    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                    <button type="submit" class="btn btn-sm btn-success pull-right">Save Damage</button>
                </div>
            </div>
        </form>
        
    </div>
</div>


<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>

<script type="text/javascript">
  $(document).ready(function(){
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
  });
</script>