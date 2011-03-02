<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php if (isset($title)): $var['title']=$title; echo View::factory('blocks/header', $var)->render(); endif; ?>
<?php if (isset($error)): $var['error']=$error; echo View::factory('blocks/error', $var)->render(); endif; ?>

<div id="rules">
<?php $attributes['enctype'] = 'multipart/form-data'; ?>
<?php if (!empty($config_content)): ?>
<?php $var['config_id'] = $config_id; echo View::factory('blocks/toolbar', $var)->render(); ?>
<?php echo Form::open('/config/update/'.$config_id, $attributes)."\n"; ?>
<div class="rules-table">
<table>
<tr><td>line #</td><td>rule</td><td>comment</td><td>&nbsp;</td></tr>
<?php foreach($config_content as $n=>$config_record):?>
<tr>
<td><?php echo $n+1; #echo $rule['linenum']+1;?></td>
<td><?php if (isset($config_record['line'])): echo $config_record['line']; endif; ?></td>
<td><input type="text" name="rule_id_<?php echo $n+1; #echo $rule['linenum']+1;?>" value="<?php if (isset($config_record['comment'])): echo $config_record['comment']; endif;?>" class="js" /></td>
<td>&nbsp;</td>
</tr>
<?php endforeach;?>
</table>
</div>
</div>
	<?php
 	#$attributes['enctype'] = 'multipart/form-data';
	#echo Form::open('/rules/update/'.$device_id, $attributes)."\n";
	//echo Form::checkbox(1,2);
	//$attributes = array('name' => 'file_1', 'class' => 'your-class');
	#$uri = str_replace(array('?'.$_SERVER['QUERY_STRING'], URL::base()), '',$_SERVER['REQUEST_URI']);
	#$uri = Route::get('default')->uri(array('controller' => 'rules', 'action' => 'show', 'id' => $device_id));
	echo Form::hidden('return', "/config/show/".$config_id)."\n";
	#echo "<div>".Form::file('file',$attributes)."</div>\n";
	//echo Form::file('test');
	echo "<div>".Form::submit('submit','save')."</div>\n";
	echo Form::close();
	?>
<?php endif; ?>
<?php echo View::factory('blocks/footer')->render();?>
