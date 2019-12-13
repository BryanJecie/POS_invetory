<!-- begin row -->
<style>
    .tab-ul li a{
        font-size: 14px;
        text-transform: uppercase;
    }
</style>
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-12">
        <ul class="nav nav-tabs tab-ul">
            <li class="active"><a href="#default-tab-1" data-toggle="tab">Remaining</a></li>
            <li class=""><a href="#default-tab-2" data-toggle="tab">Stockin</a></li>
            <li class=""><a href="#default-tab-3" data-toggle="tab">Stocks</a></li>
            <!-- <li class=""><a href="#default-tab-4" data-toggle="tab">Reports</a></li> -->
            <!-- <li class=""><a href="#default-tab-5" data-toggle="tab">Secuirty</a></li> -->
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="default-tab-1">
              <?php include RES_PATH.'/views/content/reports/reports_profile.php'; ?>
            </div>
            <div class="tab-pane fade" id="default-tab-2">
              <?php include RES_PATH.'/views/content/reports/reports_stockin.php'; ?>
            </div>
            <div class="tab-pane fade" id="default-tab-3">
              <?php include RES_PATH.'/views/content/reports/reports_stocks.php'; ?>
            </div>
            <div class="tab-pane fade " id="default-tab-4">
              <?php include RES_PATH.'/views/content/reports/reports_reports.php'; ?>
            </div>
            <div class="tab-pane fade " id="default-tab-5">
              <?php //include RES_PATH.'/views/content/reports/reports_security.php'; ?>
            </div>
        </div>
    </div>
    <!-- end col-6 -->
</div>
<!-- end row -->




<script>
    $(document).ready(function() {
        App.init();
        TableManageCombine.init();
        // TableManageButtons.init();
        // TableManageCombine.init();
    });
</script>