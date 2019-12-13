 <style>
     .titleName{
        font-size: 20px;
     }
     .logo-title{
          color: #e6e6e6;
          font-size: 80px;
          font-weight: 800;
          letter-spacing: 1px;
          margin-bottom: 0;
     }
 </style>
 <div>
    <div><h3 class="logo-title"> <?php echo strtoupper(company()->comp_abbr) ?></h3></div>
    <h3>LOCK SCREEN</h3>
    <!-- <p>Login Here</p> -->
    <!-- <label for="">sss</label> -->
    <br> 
    <form class="m-t" role="form" method="POST" action="<?php echo Url::route('index/userLock/lock?userId='.App::$auth->data()->user_id.'') ?>">
        <div class="input-group">
            <!-- <label class="lbl-login-title"><i class="fa fa-lock"></i>LOCK</label> -->
        </div>
        
        <div class="input-group">
            <span class="titleName"><?php echo strtoupper(App::$auth->data()->username) ?> LOCK ?</span>
            <!-- <input type="text" value="<?php echo Input::get('username') ?>" name="username" class="form-control" placeholder="Username">
            <div class="input-group-btn">
                <button class="btn btn-white dropdown-toggle" type="button"><i class="fa fa-user"></i> </button>
            </div> -->
        </div>
        <br>
        <div class="input-group">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-btn">
                <button class="btn btn-white dropdown-toggle" type="button"><i class="fa fa-lock"></i> </button>
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate() ?>" placeholder="Password">
        </div>
        <br>
        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
    </form>
    <?php if (Session::hasFlash()): ?>
        <div class="alert alert-danger alert-dismissable fade-msg">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <b><i class="fa fa-warning"></i> Opps Error !</b>
            <?php echo ucwords(Session::flash()) ?>
        </div>
    <?php endif ?>
    <!-- <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p> -->
</div>