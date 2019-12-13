 
<div class="invoice">
    <div class="invoice-company">
        <span class="pull-right hidden-print">
            <!-- <a href="javascript:;" class="btn btn-sm btn-success m-b-10"><i class="fa fa-download m-r-5"></i> Export as PDF</a> -->
            <!-- <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</a> -->
        </span>
        CONTROL PANEL
    </div>
    <div class="invoice-header">
        <ul class="nav nav-pills">
            <li class="active"><a href="#nav-pills-tab-1" data-toggle="tab" aria-expanded="true">SYSTEM BACK-UP</a></li>
            <li class=""><a href="#nav-pills-tab-2" data-toggle="tab" aria-expanded="false">DATABASE BACK-UP</a></li>
            <!-- <li class=""><a href="#nav-pills-tab-3" data-toggle="tab" aria-expanded="false">Pills Tab 3</a></li> -->
            <!-- <li class=""><a href="#nav-pills-tab-4" data-toggle="tab" aria-expanded="false">Pills Tab 4</a></li> -->
        </ul>
    </div>
    <div class="invoice-content">
          
        <div class="tab-content">
            <div class="tab-pane fade active in" id="nav-pills-tab-1">
                <div class="row">
                    <div class="col-md-6"><label class="label label-info" style="font-size: 16px">SYSTEM BACK-UP INFORMATION</label></div>
                    <div class="col-md-6">
                        <form class="form-inline pull-right" method="POST" action="<?php echo Url::route('settings/control_panel') ?>">
                            <div class="form-group">
                                <label for="file-name">FILES NAME <span class="text-danger">*</span></label><br>
                                <input type="text" class="form-control input-sm" id="file-name" value="<?php echo Company()->comp_abbr ?>_system">
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <input type="hidden" name="token" value="<?php echo Token::generate() ?>" placeholder="">
                                <button type="submit" class="btn btn-info btn-sm">SAVE FILE</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="table-file-back-up" class="table table-striped table-bordered">
                            <thead>
                                <tr class="bg-info">
                                    <th>SYSTEM NAME</th>
                                    <th>DATE BACK-UP</th>
                                    <th>FILE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>data</td>
                                    <td>data</td>
                                    <td><button type="button" class="btn btn-white btn-sm"><i class="fa fa-download"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-pills-tab-2">
                <div class="row">
                    <div class="col-md-6"><label class="label label-info" style="font-size: 16px">SYSTEM BACK-UP INFORMATION</label></div>
                    <div class="col-md-6">
                        <form class="form-inline pull-right" method="POST" action="<?php echo Url::route('settings/control_panel') ?>">
                            <div class="form-group">
                                <label for="file-name">DATABASE NAME <span class="text-danger">*</span></label><br>
                                <input type="text" class="form-control input-sm" id="file-name" value="bhbe_db">
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <input type="hidden" name="token" value="<?php echo Token::generate() ?>" placeholder="">
                                <button type="submit" class="btn btn-info btn-sm">SAVE FILE</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="table-database-back-up" class="table table-striped table-bordered">
                            <thead>
                                <tr class="bg-info">
                                    <th>DATABASE NAME</th>
                                    <th>DATE BACK-UP</th>
                                    <th>FILE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>data</td>
                                    <td>data</td>
                                    <td><button type="button" class="btn btn-white btn-sm"><i class="fa fa-download"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="invoice-note">
        * Make all cheques payable to [Your Company Name]<br />
        * Payment is due within 30 days<br />
        * If you have any questions concerning this invoice, contact  [Name, Phone Number, Email]
    </div>
    <div class="invoice-footer text-muted">
        <p class="text-center m-b-5">
            THANK YOU FOR YOUR BUSINESS
        </p>
        <p class="text-center">
            <span class="m-r-10"><i class="fa fa-globe"></i> matiasgallipoli.com</span>
            <span class="m-r-10"><i class="fa fa-phone"></i> T:016-18192302</span>
            <span class="m-r-10"><i class="fa fa-envelope"></i> rtiemps@gmail.com</span>
        </p>
    </div>
</div>
        

<script>
    jQuery(document).ready(function($) { 
        $('#table-file-back-up').DataTable({});
        $('#table-database-back-up').DataTable({});
    });
</script>