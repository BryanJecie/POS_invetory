<style type="text/css">
    .btn-cat-action a{
        margin-left: 2px !important;
    }
    .custom-label{
        font-size: 14px;
    }
    .custom-label span{
        color:red;
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
        <h4 class="panel-title">Manage Employee Logs</h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?php if (Session::hasFlash()): ?>
                    <div class="alert alert-danger alert-dismissable fade-msg">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <b><i class="fa fa-check"></i></b>
                        <?php echo ucwords(Session::flash()) ?>
                    </div>
                <?php endif ?>
               <!--   <pre>
                     <?php print_r($data['usersLogs']); ?>
                 </pre> -->
                <table id="employee-logs" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Username</th>
                            <th>Login Date</th>
                            <th>Duration</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php if (!empty($data['usersLogs'])): ?>
                            <?php foreach ( $data['usersLogs'] as $log ): ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $count++; ?></td>
                                    <td><b><?php echo ucwords($log->username) ?></b></td>
                                    <td><?php echo $log->login_date ?></td>
                                    <td>
                                        <?php

                                              $dStart = new DateTime($log->login_date);
                                              $dEnd   = new DateTime($log->logout_date);
                                              $dDiff  = $dStart->diff($dEnd);
                                           
                                              if ( $dDiff->days <  1 ) {
                                                  $sec = 0;
                                                  if ( $dDiff->i < 1 ) {
                                                    $sec = $dDiff->s.' Sec';
                                                  }
                                                  else{
                                                    $sec = $dDiff->h.' Hrs, '. $dDiff->i.' Min & '.$dDiff->s.' Sec';
                                                  }
                                                echo $sec;
                                              }
                                              else{
                                                  $day = 0;
                                                  if ( $dDiff->days > 1 ) {
                                                    $day = $dDiff->days. ' Days, '.$dDiff->i.' Min & '.$dDiff->s.' Sec';
                                                  }
                                                  else{
                                                    $day = $dDiff->days. ' Day, '.$dDiff->h.' Hrs, '.$dDiff->i.' Min & '.$dDiff->s.' Sec';
                                                  }
                                                echo $day;
                                              }

                                            // echo "Hours = $dd->h, Minutes = $dd->i, Seconds = $dd->s";
                                        ?>
                                    </td>
                                    <td><?php echo ucwords($log->user_role) ?></td>
                                    <td>
                                        <label class="label label-<?php echo ( $log->log_status == 'logout' ) ? 'danger' : 'success' ; ?>">
                                            <?php 
                                                if ($log->log_status == 'logout') {
                                                   echo strtoupper('last online');
                                                }
                                                else{
                                                   echo "<i class='fa fa-circle' style='color:#65dd02'></i> ";
                                                   echo strtoupper('online');
                                                }
                                            ?>
                                        </label>
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
    <script src="<?php echo Url::link('public/assets/js/table-manage-select.demo.min.js') ?>"></script>

<!-- manage-product-list-table -->
<script>
        $(document).ready(function() {
            var handleDataTableSelect = function(){
                    "use strict";0!==$("#employee-logs").length&&$("#employee-logs").DataTable({
                        select:!0,responsive:!0}
                    )},
                TableManageTableSelect = function(){
                    "use strict";

            return{ 
                init:function(){
                    handleDataTableSelect()}
                }
                }();


            TableManageTableSelect.init();
        });
    </script>