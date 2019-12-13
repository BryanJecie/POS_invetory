<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<link href="<?php echo Url::route('public/vendor/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo Url::route('public/vendor/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet" />
	<link href="<?php echo Url::route('public/vendor/css/animate.css'); ?>" rel="stylesheet" />
	<link href="<?php echo Url::route('public/vendor/css/style.css'); ?>" rel="stylesheet" />

	<?php $class = 'gray-bg'; ?>

</head>
<body class="<?php echo $class; ?>">
	



	<div class="middle-box text-center loginscreen animated fadeInDown">
	   <?php (file_exists($content = RES_PATH.'views/'.$content.'.php')) ? include $content : '' ; ?>
	</div>


	<script src="<?php echo Url::route('public/vendor/js/jquery-2.1.1.js'); ?>"></script>
	<script src="<?php echo Url::route('public/vendor/js/bootstrap.min.js'); ?>"></script>
</body>
</html>