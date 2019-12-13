 <!-- <ul class="list-inline">
   <li class="list-inline-item">
     <label>Start Date</label>
     <input type="date" class="form-control input-sm" name="" value="<?php echo date('Y-m-d')  ?>">
   </li>
   <li class="list-inline-item">
     <label>End Date</label>
     <input type="date" class="form-control input-sm" name="" value="<?php echo date('Y-m-d')  ?>">
   </li>
   <li class="list-inline-item">
       <button type="" class="btn btn-primary btn-sm btn-sales"><small>show</small></button>
   </li>
 </ul> -->
<!-- <legend><small></small></legend> -->
<!-- <h3 class="m-r-5 m-b-5">Stokin History</h3> -->
<h3 class="m-t-10">Stokin History</h3>
<hr>
<div class="row">
    <div class="col-md-6">
       <!-- <div class="form-group"> -->
        <div class="form-group">
            <ul class="list-inline">
              <li class="list-inline-item">
                <label>Start Date</label>
                <input type="date" class="form-control input-sm" name="" value="<?php echo date('Y-m-d')  ?>">
              </li>
              <li class="list-inline-item">
                <label>End Date</label>
                <input type="date" class="form-control input-sm" name="" value="<?php echo date('Y-m-d')  ?>">
              </li>
              <li class="list-inline-item">
                  <button type="" class="btn btn-primary btn-sm btn-sales"><small>show</small></button>
              </li>
            </ul>
        </div>
           <!--  <label class="control-label col-md-4" style=""><h5 style=" " class="pull-right">Search Date Range</h5></label>
            <div class="col-md-8">
                <div class="input-group" id="default-daterange">
                    <input type="text" name="default-daterange" class="form-control" value="" placeholder="click to select the date range" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>
            </div> -->
           <!--  <div class="col-md-8">
                <div id="advance-daterange" class="btn btn-white">
                    <span></span>
                    <i class="fa fa-angle-down fa-fw"></i>
                </div>
            </div> -->
        <!-- </div> -->
    </div>
    <div class="col-md-6">
        <div class="form-group pull-right">
            <button type="button" class="btn btn-success btn-sm m-r-5 m-b-5"><i class="fa fa-download"></i> Export to PDF</button>
            <button type="button" class="btn btn-success btn-sm m-r-5 m-b-5"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>

     
    <div class="col-md-12">
        <table id="data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Barcode</th>
                    <th>SKU ID</th>
                    <th>Quanity</th>
                    <th>Price</th>
                    <th>Stokin Date</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd gradeX">
                    <td>Trident</td>
                    <td>Internet Explorer 4.0</td>
                    <td>Win 95+</td>
                    <td>4</td>
                    <td>X</td>
                    <td>X</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script>
        $(document).ready(function() {
            // App.init();
            FormPlugins.init();
        });
    </script>