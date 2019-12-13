 <style>
     .logo-title {
         color: #e6e6e6;
         font-size: 80px;
         font-weight: 800;
         letter-spacing: 1px;
         margin-bottom: 0;
     }
 </style>
 <div>
     <div>
         <!-- <center> -->
         <h3 class="logo-title text-center">
             <?php echo strtoupper($data['comps'][0]->comp_abbr) ?>
         </h3>
         <!-- </center> -->
     </div>
     <br>
     <h3>Welcome to <?php echo  ucwords($data['comps'][0]->comp_name) ?></h3>
     <!-- <p>Login Here</p> -->
     <!-- <label for="">sss</label> -->
     <form class="m-t" role="form" method="POST" action="<?php echo Url::route('index/userAuth') ?>">

         <button id="btn-cashier" type="button" class="btn btn-warning btn-sm pull-right" style="border-radius: 1px">
             <i class="fa fa-user"></i> POS
         </button>
         <br><br>
         <div class="input-group">
             <label class="lbl-login-title"><i class="fa fa-lock"></i> Login Here</label>
         </div>
         <div class="input-group">
             <input type="text" value="<?php echo Input::get('username') ?>" name="username" class="form-control" placeholder="Username" autocomplete="off">
             <div class="input-group-btn">
                 <button class="btn btn-white dropdown-toggle" type="button"><i class="fa fa-user"></i> </button>
             </div>
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

     
     <?php if (Session::hasFlash()) : ?>
         <div class="alert alert-danger alert-dismissable fade-msg">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             <b><i class="fa fa-warning"></i> Opps Error !</b>
             <?php echo ucwords(Session::flash()) ?>
         </div>
     <?php endif ?>
     <!-- <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p> -->
 </div>

 <ul class="list-inline">
    <li>username : <em>admin</em></li><br>
    <li>password : <em>admin</em></li>
</ul>