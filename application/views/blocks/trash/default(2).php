<?php $variables['title']=$title; echo View::factory('blocks/header', $variables)->render();?>
    <div id="container">
    <h3><?php if (isset($revision)): echo "Rules revision: ".$revision; endif;?></h3>
    <table>
     <?php if (isset($rules)): ?>
     <?php foreach($rules as $rule):?>
 	  <tr><td><?php echo $rule['linenum']+1;?></td><td><?php echo $rule['rule'];?></td><td><?php echo $rule['comment'];?></td></tr>
 	 <?php endforeach;?>
 	 <?php endif; ?>
	</table>

	<?php if (isset($dump)): ?>
	<?php foreach($dump as $dump1):?>
	<p><?php echo $dump1['rule'];?></p>
 	<?php endforeach;?>
 	<?php endif; ?>

	<?php
 	$attributes['enctype'] = 'multipart/form-data';
	echo Form::open('/update/', $attributes)."\n";
	echo Form::checkbox(1,2);
	//$attributes = array('name' => 'file_1', 'class' => 'your-class');
	echo Form::file('file',$attributes);
	//echo Form::file('test');
	echo Form::submit('submit','Send');
	echo Form::close();

	?>
    </div>
    <?php echo View::factory('blocks/footer')->render();?>
  </body>
</html>
