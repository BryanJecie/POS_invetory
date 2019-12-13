<!DOCTYPE html>
<html>
<head>
	<title>Print <?php echo $data['title-head'] ?></title>

	
	<script type="text/javascript">
		function print_r() {
			window.print();

			setTimeout(function(){
				window.close();
			},100);
		}
	</script>
	<style type="text/css">
		.table-border th, .table-border td{
			border:1px solid #000;
		}
	</style>
</head>

<body onload="print_r();">
	<?php if (isset($data['invoice'])): ?>
		<table class="cheade-info" width="100%" >
			<tr>
				<?php foreach ($data['invoice']['comps'] as $comp): ?>
					<th style="text-align: left; width: 10%; border:none;">
						<?php echo App::$image->get('images/company/',['width'=>'60'],$comp->comp_id); ?>
					</th>
					<th style="text-align: left;border:none;">
						<?php echo strtoupper($comp->comp_name) ?></br>
						<?php echo $comp->comp_email ?></br>
						<?php echo ucwords($comp->comp_address) ?></br>
						<?php echo $comp->comp_phone ?></br>
					</th>
					<th style="border:none;">Date : <?php echo date('M d, Y') ?></th>	
				<?php endforeach ?>
			</tr>
		</table>		
	<?php endif ?>
	
	<?php if (isset($data['title-content'])): ?>
		<br>
		<br>
		<center><h3 style="color:#00acac"><?php echo strtoupper($data['title-content']) ?></h3></center>
		<br>
	<?php endif ?>

	<?php  (file_exists($content = RES_PATH.'views/'.$content.'.php')) ? include $content : '' ; ?>


	<br><br><br>
	<table width="100%">
	  <thead>
	    <tr>
	      <th style="text-align: left">Prepared By:</th>
	    </tr>
	    <tr>
	      <th style="text-align: left">&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <td><?php echo ucwords(App::$auth->data()->person_first.' '.App::$auth->data()->person_middle[0].'. '.App::$auth->data()->person_last) ?></td>
	    </tr>
	    <tr>
	      <td><?php echo ucwords(App::$auth->data()->person_position) ?></td>
	    </tr>
	  </tbody>
	</table>


</body>
</html>