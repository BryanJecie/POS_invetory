  <!-- <h3 class="m-t-10"><i class="fa fa-file"></i> Product Profile</h3> -->
  <h5>Menu</h5>
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <ul class="nav nav-pills">
                <li class="active"><a href="#nav-pills-tab-1" data-toggle="tab">Sales History</a></li>
                <li><a href="#nav-pills-tab-2" data-toggle="tab">Sold-out History</a></li>
                <!-- <li><a href="#nav-pills-tab-3" data-toggle="tab">Stocks Remaining</a></li> -->
                <!-- <li><a href="#nav-pills-tab-4" data-toggle="tab">Pills Tab 4</a></li> -->
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="nav-pills-tab-1">
                     <div class="col-md-6">
                       <div class="form-group" style="margin-left:-16px;">
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
                     </div>
                     <div class="col-md-6">
                         <div class="form-group pull-right">
                             <button type="button" class="btn btn-success btn-sm m-r-5 m-b-5"><i class="fa fa-download"></i> Export to PDF</button>
                             <button type="button" class="btn btn-success btn-sm m-r-5 m-b-5"><i class="fa fa-print"></i> Print</button>
                         </div>
                     </div>
                     <table id="data-table" class="table table-striped table-bordered">
                        <!-- <caption class="" style="font-size:16px; font-weight: bold">List Sales</caption> -->
                        <thead>
                            <tr>
                                <th width="100px" nowrap>ID</th>
                                <th width="200px" nowrap>First name</th>
                                <th width="200px" nowrap>Last name</th>
                                <th width="200px" nowrap>ZIP / Post code</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd gradeX">
                                <td>Trident</td>
                                <td>Internet Explorer 4.0</td>
                                <td>Win 95+</td>
                                <td>4</td>
                                <td>X</td>
                            </tr>
                            <tr class="even gradeC">
                                <td>Trident</td>
                                <td>Internet Explorer 5.0</td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                        </tbody>
                     </table>
                </div>
                <div class="tab-pane fade" id="nav-pills-tab-2">
                    <!-- <div class="form-group pull-right" style="margin-bottom: -35px;">
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
                    </div> -->
                    <div class="col-md-6">
                      <div class="form-group" style="margin-left:-16px;">
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group pull-right">
                            <button type="button" class="btn btn-success btn-sm m-r-5 m-b-5"><i class="fa fa-download"></i> Export to PDF</button>
                            <button type="button" class="btn btn-success btn-sm m-r-5 m-b-5"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                    <table id="data-table" class="table table-striped table-bordered">
                       <!-- <caption class="" style="font-size:16px; font-weight: bold">List Sold-out</caption> -->
                       <thead>
                           <tr>
                               <th width="100px" nowrap>ID</th>
                               <th width="200px" nowrap>First name</th>
                               <th width="200px" nowrap>Last name</th>
                               <th width="200px" nowrap>ZIP / Post code</th>
                               <th>Country</th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr class="odd gradeX">
                               <td>Trident</td>
                               <td>Internet Explorer 4.0</td>
                               <td>Win 95+</td>
                               <td>4</td>
                               <td>X</td>
                           </tr>
                           <tr class="even gradeC">
                               <td>Trident</td>
                               <td>Internet Explorer 5.0</td>
                               <td>Win 95+</td>
                               <td>5</td>
                               <td>C</td>
                           </tr>
                       </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="nav-pills-tab-3">
                    <h3 class="m-t-10">Nav Pills Tab 3</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing porttitor, 
                        est diam sagittis orci, a ornare nisi quam elementum tortor. 
                        Proin interdum ante porta est convallis dapibus dictum in nibh. 
                        Aenean quis massa congue metus mollis fermentum eget et tellus. 
                        Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien, 
                        nec eleifend orci eros id lectus.
                    </p>
                </div>
                <div class="tab-pane fade" id="nav-pills-tab-4">
                    <h3 class="m-t-10">Nav Pills Tab 4</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing porttitor, 
                        est diam sagittis orci, a ornare nisi quam elementum tortor. 
                        Proin interdum ante porta est convallis dapibus dictum in nibh. 
                        Aenean quis massa congue metus mollis fermentum eget et tellus. 
                        Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien, 
                        nec eleifend orci eros id lectus.
                    </p>
                </div>
            </div>
        </div>
    </div>

