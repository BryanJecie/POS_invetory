 
<style>
    #form-edit-product div label span{
        color: red;
    }
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
    .title-name{
    	font-size: 20px;
    	font-weight: bold;
    }
    .profile-image{
        height: auto !important;

    }
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
		    <div class="panel-heading">
		        <div class="panel-heading-btn">
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" data-original-title="" title=""><i class="fa fa-repeat"></i></a>
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse" data-original-title="" title=""><i class="fa fa-minus"></i></a>
		            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
		        </div>
		        <h4 class="panel-title">General Settings</h4>
		    </div>
		    <div class="panel-body" style="background-color:#fff">
		    	<div class="row">
		            <div class="col-md-6">
		                    <?php if (Session::hasFlash()): ?>
                    	        <div class="alert alert-success fade in m-b-15 noti-fade">
                    				<strong>Success!</strong>
                    				<?php echo Session::flash(); ?>
                    				<span class="close" data-dismiss="alert">×</span>
                    			</div>
		                    <?php endif ?>
		            	<legend><label class="title-name">Company Information</label></legend>
		            </div>
		        </div>
		        
		        <form class="form-horizontal" id="form-edit-product" method="POST" action="<?php echo Url::route('settings/business_profile') ?>" enctype="multipart/form-data" class="form-horizontal" data-parsley-validate="true" name="demo-form">
		            <div class="row">
				        <?php if (!is_null($data['comp'])): ?>
				        	<?php foreach ($data['comp'] as $comp): ?>
		        		        <div class="col-md-2">
			        		        <label><b>Company Logo</b></label>
			        		          <div class="profile-image">
			        		            <center>
		                                <?php echo App::$image->get('images/company/',['width'=>'auto'],$comp->comp_id); ?>
			        		            </center>
			        		          </div>
			        		          <span class="btn btn-primary btn-file " style="">
			        		            <span style="">browse image</span>
			        		            <input type="file" name="image-file" id="imgInp" >
			        		        </span>
		        		        </div>
		        		        <div class="col-md-9">
		    		                <div class="form-group">
		    		                    <label class="control-label"></label>
		    		                    <div class="col-md-5">
		    		                    	<label><b>Company Name</b> <span>*</span></label>
		    		                        <input type="hidden" name="comp-id" value="<?php echo $comp->comp_id ?>" />
		    		                        <input type="text" name="comp-name" class="form-control" value="<?php echo $comp->comp_name ?>" />
		    		                    </div>
		    		                </div>
		    		                <div class="form-group">
		    		                    <label class="control-label"></label>
		    		                    <div class="col-md-5">
		    		                    	<label><b>Company Abbrevation</b> <span>*</span></label>
		    		                        <input type="text" name="comp-abbr" class="form-control" value="<?php echo $comp->comp_abbr ?>" />
		    		                    </div>
		    		                </div>
		    		                <div class="form-group">
		    		                    <label class="control-label"></label>
		    		                    <div class="col-md-5">
		    		                    	<label><b>Company Email</b> <span>*</span></label>
		    		                        <input type="text" name="comp-email" class="form-control" value="<?php echo $comp->comp_email ?>" />
		    		                    </div>
		    		                </div>
		    		                <div class="form-group">
		    		                    <label class="control-label"></label>
		    		                    <div class="col-md-5">
		    		                    	<label><b>Date Start</b> <span>*</span></label>
		    		                        <input type="date" name="comp-date" class="form-control" value="<?php echo $comp->comp_start_date ?>" />
		    		                    </div>
		    		                </div>
		    		                <div class="form-group">
		    		                    <label class="control-label"></label>
		    		                    <div class="col-md-5">
		    		                    	<label><b>Phone</b> <span>*</span></label>
		    		                        <input type="text" name="phone" class="form-control" value="<?php echo $comp->comp_phone ?>" />
		    		                    </div>
		    		                </div>
		    		                <div class="form-group">
		    		                    <label class="control-label"></label>
		    		                    <div class="col-md-5">
		    		                    	<label><b>Company Address</b> <span>*</span></label>
		    		                    	<textarea name="comp-address" rows="3" class="form-control"><?php echo $comp->comp_address ?></textarea>
		    		                    </div>
		    		                </div>
		        		        </div>
				        	<?php endforeach ?>
				        <?php else : ?>
		        	        <div class="col-md-2">

			        	        <label><b>Company Logo</b></label>
			        	          <div class="profile-image">
			        	            <center>
			        	              <img src="<?php echo Url::route('public/images/no_image/no_image.png') ?>" style="" width="160" style="margin-top:50px;">
			        	            </center>
			        	          </div>
			        	          <span class="btn btn-primary btn-file " style="">
			        	            <span style="">browse image</span>
			        	            <input type="file" name="image-file" id="imgInp" >
			        	        </span>
		        	        </div>
		        	        <div class="col-md-9">
		        	                <div class="form-group">
		        	                    <label class="control-label"></label>
		        	                    <div class="col-md-5">
		        	                    	<label><b>Company Name</b> <span>*</span></label>
        		                        	<input type="hidden" name="comp-id" value="" />
		        	                        <input type="text" name="barcode" class="form-control" value="" />
		        	                    </div>
		        	                </div>
		        	                <div class="form-group">
		        	                    <label class="control-label"></label>
		        	                    <div class="col-md-5">
		        	                    	<label><b>Company Abbrevation</b> <span>*</span></label>
		        	                        <input type="text" name="comp-abbr" class="form-control"/>
		        	                    </div>
		        	                </div>
		        	                <div class="form-group">
		        	                    <label class="control-label"></label>
		        	                    <div class="col-md-5">
		        	                    	<label><b>Company Email</b> <span>*</span></label>
		        	                        <input type="text" name="product-name" class="form-control" value="" />
		        	                    </div>
		        	                </div>
		        	                <div class="form-group">
		        	                    <label class="control-label"></label>
		        	                    <div class="col-md-5">
		        	                    	<label><b>Company Address</b> <span>*</span></label>
		        	                    	<textarea name="comp-address" rows="3" class="form-control"></textarea>
		        	                    </div>
		        	                </div>
		        	                <div class="form-group">
		        	                    <label class="control-label"></label>
		        	                    <div class="col-md-5">
		        	                    	<label><b>Phone</b> <span>*</span></label>
		        	                        <input type="text" name="selling-name" class="form-control" value="" />
		        	                    </div>
		        	                </div>
		        	        </div>
				        <?php endif ?>
				        <div class="col-md-2"></div>
				        <div class="col-md-10">
				                <input type="hidden" name="token"  value="<?php echo Token::generate() ?>" />
				                <button type="submit" class="btn btn-sm btn-success ">Save Business Profile</button>
				        </div>
		            </div>
		        </form>
		    </div>
		</div>
	</div>
</div>


<script>
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