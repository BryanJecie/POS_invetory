<style type="text/css" media="screen">
    .lbl{
        font-size: 11px !important;
    }
    .ul-tab .active a{
        /*background-color: #00acac!important*/
    }
    .ul-navs .active a{
      background-color: #00acac !important;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <ul class="nav nav-pills ul-navs ">
          <li class="active text-center" style="width: 18%"><a href="#nav-pills-tab-1" data-toggle="tab" aria-expanded="false" class=""> <i class="fa fa-dropbox" style="font-size: 14px;"></i> <b>STOCK AVAILABLE</b></a></li>
          <li class="text-center" style="width: 18%"><a href="#nav-pills-tab-2" data-toggle="tab" aria-expanded="false" class=""><i class="fa fa-list-alt" style="font-size: 14px;"></i> <b>STOCKOUT SUMMARY</b></a></li>
          <li class="text-center" style="width: 18%"><a href="#nav-pills-tab-3" data-toggle="tab" aria-expanded="false" class=""><i class="fa fa-history" style="font-size: 14px;"></i> <b>STOCKOUT HISTORY</b></a></li>
        </ul>
        <div class="tab-content">
        <div class="tab-pane fade active in" id="nav-pills-tab-1">
           <br>
           <label class="label label-info" style="  font-size: 15px;">LIST OF PRODUCT AVAILABLE</label>  
           <hr>
           <table id="stock-reports" class="table table-striped table-bordered">
                <thead>
                    <tr class="active">
                        <th><b>#LPA</b></th>
                        <th ><b >PRODUCT NAME</b></th>
                        <th ><b>BARCODE</b></th>
                        <th><b>BUYING PRICE</b></th>
                        <th><b>SELLING PRICE</b></th>
                        <th><b>INVENTORY</b></th>
                        <th><b>STATUS</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php if (!empty($data['stocks'])): ?>
                        <?php foreach ( $data['stocks'] as $stock ): ?>
                            <tr class="gradeC">
                                <td><?php echo $count++; ?></td>
                                <td style="width: 300px!important;"><?php echo ucwords($stock->product_name.' '.$stock->product_subname) ?></td>
                                <td><b class="text-info"><?php echo $stock->barcode ?></b></td>
                                <td><?php echo ($stock->stockin_sum_buying_price !== "") ? number_format($stock->stockin_sum_buying_price,2) : "-"; ?></td>
                                <td><?php echo ($stock->stockin_sum_selling_price !== "") ? number_format($stock->stockin_sum_selling_price,2) : "-"; ?></td>
                                <td>
                                    <label class="label label-info"><?php echo $stock->stockin_sum_selling_quantity.' '.strtoupper($stock->stockin_sum_selling_type) ?></label>
                                </td>
                                <td>
                                   <?php 
                                       if ((int)$stock->stockin_sum_selling_quantity >= 10) { ?>
                                          <label class="label label-primary lbl">In Stocks</label>
                                   <?php } 
                                       elseif((int)$stock->stockin_sum_selling_quantity < 10 AND (int)$stock->stockin_sum_selling_quantity !== 0){ ?>
                                          <label class="label label-warning lbl">In Stock<?php echo ((int)$stock->stockin_sum_selling_quantity > 2)? 's' : "" ?></label>
                                   <?php } 
                                       elseif((int)$stock->stockin_sum_selling_quantity < 1){ ?>   
                                          <label class="label label-danger lbl">Out of Stock</label>
                                   <?php }  ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                   
                </tbody>
           </table>
        </div>
        <div class="tab-pane fade" id="nav-pills-tab-2">
          <div class="row">
            <br>
            <div class="col-md-6">
                <label class="label label-info" style="  font-size: 15px;">SUMMARY OF PRODUCT OUT</label>  
            </div>
            <div class="col-md-6">
                  <p style="" class="pull-right">
                    <button type="button" class="btn btn-white  btn-sm" style="" id="btn-sum-print">
                       <b>
                           <i class="glyphicon glyphicon-print"></i> 
                           <small class="text-primary">PRINT</small>
                       </b>
                    </button>
                    <button type="button" class="btn btn-white  btn-sm" style="" id="btn-sum-excel">
                        <b>
                            <i class="fa fa-file-excel-o text-success"></i> 
                            <small class="text-success">EXCEL</small>
                        </b>
                    </button>  
                  </p>
            </div>
          </div>
          <hr style="margin-top: 10px;">
          <div class="row">
             <div class="col-md-7">
                  <form action="javascript:;" class="form-inline " id="form-stock-out" data-parsley-validate="true" name="form-wizard">
                      <div class="form-group">
                          <label class="text-success">SEARCH FOR DATE RANGE</label><br>
                          <input type="text" class="form-control" id="start" placeholder="Start Date" required="">
                      </div>
                      <div class="form-group">
                          <label for="formGroupExampleInput">&nbsp;</label><br>
                          <input type="text" class="form-control" id="end" placeholder="End Date" required="">
                      </div>
                       <div class="form-group">
                          <label for="formGroupExampleInput">&nbsp;</label><br>
                          <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i><small> VIEW</small></button>
                      </div>
                  </form>
             </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <h4 id="loading-data" class="hide" style="margin:10px"><hr> <i class="fa fa-spinner fa-spin" style="font-size:20px"></i> Loading data please wait...</h4>
                  <div class="div-table-stockout" >
                      <table class="table table-bordered table-striped" id="table-stockout" data-tableName="Test Table 1" style="margin-top: 100px;">
                          <thead>
                              <tr class="active">
                                  <th><b>#SPO</b></th>
                                  <th><b>PRODUCT NAME</b></th>
                                  <th><b>BARCODE</b></th>
                                  <th><b>PRICE</b></th>
                                  <th><b>INVENTORY</b></th>
                                  <th><b>STATUS</b></th>
                              </tr>
                          </thead>
                          <tbody></tbody>
                      </table>
                  </div>
                  <br>
              </div>
          </div>
        </div>
        <div class="tab-pane fade" id="nav-pills-tab-3">
          <br>
          <div class="row">
              <div class="col-md-6">
                  <label class="label label-info" style="  font-size: 15px;">HISTORY OF PRODUCT OUT</label>  
              </div>
              <div class="col-md-6">
                  <p style="" class="pull-right">
                    <button type="button" class="btn btn-white  btn-sm" style="" id="btn-history-print">
                       <b>
                           <i class="glyphicon glyphicon-print"></i> 
                           <small class="text-primary">PRINT</small>
                       </b>
                    </button>
                    <button type="button" class="btn btn-white  btn-sm" style="" id="btn-history-excel">
                        <b>
                            <i class="fa fa-file-excel-o text-success"></i> 
                            <small class="text-success">EXCEL</small>
                        </b>
                    </button>  
                  </p>
              </div>
          </div>
          <hr style="margin-top: 10px;">
          <div class="row">
               <div class="col-md-7">
                   <form action="javascript:;" class="form-inline" id="form-stock-out-history" data-parsley-validate="true" name="form-wizard">
                       <div class="form-group">
                           <label class="text-success">SEARCH FOR DATE RANGE</label><br>
                           <input type="text" class="form-control" id="start-hist" placeholder="Start Date" required="">
                       </div>
                       <div class="form-group">
                           <label for="formGroupExampleInput">&nbsp;</label><br>
                           <input type="text" class="form-control" id="end-hist" placeholder="End Date" required="">
                       </div>
                        <div class="form-group">
                           <label for="formGroupExampleInput">&nbsp;</label><br>
                           <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i><small> VIEW</small></button>
                       </div>
                   </form>
               </div>
          </div>
          <div class="row">
               <div class="col-md-12">
                  <h4 id="loading-data-hist" class="hide" style="margin:10px">
                    <hr> <p><i class="fa fa-spinner fa-spin" style="font-size:20px"></i> Loading data please wait...</p></h4>
                  <div class="div-table-stockout-history" >
                      <table class="table table-bordered table-striped" id="table-stockout-history" >
                          <thead>
                              <tr class="active">
                                  <th><b>#HPO</b></th>
                                  <th><b>PRODUCT NAME</b></th>
                                  <th><b>BARCODE</b></th>
                                  <th><b>STOCKOUT DATE</b></th>
                                  <th><b>PRICE</b></th>
                                  <th><b>INVENTORY</b></th>
                                  <th><b>STATUS</b></th>
                              </tr>
                          </thead>
                          <tbody></tbody>
                      </table>
                  </div>
                  <br>
               </div>
          </div>
        </div>
      </div>
    </div>
</div>


<script src="<?php echo Url::route('public/assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo Url::route('public/assets/js/form-wizards-validation.demo.min.js'); ?>"></script>
<script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>

<script>
	$(document).ready(function() {
        $("#start").datepicker({todayHighlight:!0,autoclose:!0 ,format: 'yyyy-mm-dd'}),
        $("#end").datepicker({todayHighlight:!0,autoclose:!0,format: 'yyyy-mm-dd'});

        $("#start-hist").datepicker({todayHighlight:!0,autoclose:!0,format: 'yyyy-mm-dd'});
        $("#end-hist").datepicker({todayHighlight:!0,autoclose:!0,format: 'yyyy-mm-dd'});


        $('#stock-reports').DataTable({
            dom:"Bfrtip",
              buttons:[
                // {extend:"copy",className:"btn-sm"},
                {extend:"csv",className:"btn-sm"},
                {extend:"pdf",className:"btn-sm"},
                {extend:"print",className:"btn-sm"}
             ],
             bSort : false,
         });

        $(function() {

            get_stock_out("", "");
            get_stock_out_history("", "", true);

            var doc = $(document);

            doc.on('click', '#btn-sum-print, #btn-history-print', function(){
                var method = '';
                var start  = '';
                var end    = '';
                
                switch($(this).attr('id')){
                    case 'btn-sum-print':
                        start  = $('#start').val();
                        end    = $('#end').val(); 
                        method = "stockout_sum" ;
                    break;
                    case 'btn-history-print':
                        start  = $('#start-hist').val();
                        end    = $('#end-hist').val();
                        method = "stockout_hist";
                    break;
                }

                window.open("<?php echo Url::route('print_/') ?>"+method+'/'+start+'/'+end);
            });

            doc.on('click', '#btn-sum-excel, #btn-history-excel', function(){
                var table = '';
                var fileName = '';
                switch($(this).attr('id')){
                    case 'btn-sum-excel':
                        table    = 'table-stockout';
                        fileName = "Stockout-Summary" ;
                    break;
                    case 'btn-history-excel':
                        table    = 'table-stockout-history';
                        fileName = "Stockout-History" ;
                    break;
                }
                $("#"+table).table2excel({
                    exclude: ".noExl",
                    name: "Worksheet Name",
                    filename: fileName 
                });
            });
         
            $('#form-stock-out').submit(function(event) {
                event.preventDefault();
                var start = $('#start').val();
                var end   = $('#end').val();
                get_stock_out(start , end);
            });
            $('#form-stock-out-history').submit(function(event) {
                event.preventDefault();
                var start = $('#start-hist').val();
                var end   = $('#end-hist').val();
                get_stock_out_history(start , end);
            });
            $('#table-stockout-history').DataTable({
               "lengthChange": false,
               bSort : false,
               dom:"f",
               searching: false,
               paging: false
            });
            $('#table-stockout').DataTable({
               "lengthChange": false,
               bSort : false,
               dom:"f",
               searching: false,
               paging: false
            });
        });

        function get_stock_out(start , end) {
            $('#loading-data').removeClass('hide');
            $('.div-table-stockout').addClass('hide');
            $.ajax({
                url: "<?php echo Url::route('ajax/load_stockout') ?>",
                type: 'POST',
                dataType: 'JSON',
                data: { action : 'get', start : start , end : end},
            })
            .done(function(data) {
            
                setTimeout(function(){
                    $('#loading-data').addClass('hide');
                    $('.div-table-stockout').removeClass('hide');
                },3000);

                $('#table-stockout').DataTable().clear().draw();
                $('#table-stockout').DataTable().rows.add(data.list);
                $('#table-stockout').DataTable().columns.adjust().draw();
                
            });
        }

        function get_stock_out_history(start , end, key) {

            $('#loading-data-hist').removeClass('hide');
            $('.div-table-stockout-history').addClass('hide');

            $.ajax({
                url: "<?php echo Url::route('ajax/load_stockout_history') ?>",
                type: 'POST',
                dataType: 'JSON',
                data: { action : 'get', start : start , end : end, key : key },
            })
            .done(function(data) {
                setTimeout(function(){
                    $('#loading-data-hist').addClass('hide');
                    $('.div-table-stockout-history').removeClass('hide');
                },3000);

                $('#table-stockout-history').DataTable().clear().draw();
                $('#table-stockout-history').DataTable().rows.add(data.list);
                $('#table-stockout-history').DataTable().columns.adjust().draw();
                
            });
        }
	});
</script>