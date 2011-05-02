<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php if (isset($title)): $var['title']=$title; echo View::factory('blocks/header', $var)->render(); endif; ?>
<?php if (isset($error)): $var['error']=$error; echo View::factory('blocks/error', $var)->render(); endif; ?>

<?php $var['config_id'] = $config['config_id']; echo View::factory('blocks/toolbar', $var)->render(); ?>
<div id="config-edit-settings-advice">
<p>You can update config sending POST-request to this link: <a href="/config/update/<?php echo $config['config_id'];?>">/config/update/<?php echo $config['config_id'];?></a></p>
</div>
<div id="edit-config">
<?php $attributes['class'] = "config-form";?>
<?php
echo Form::open('/config/edit/'.$config['config_id'], $attributes);
echo "<div>".Form::hidden('config_id', $config['config_id'])."</div>";
#echo "<div>".Form::hidden('target', 'settings')."</div>";
echo '<div class="form-field-description">Config name (*):</div><div>'.Form::input('name', $config['name'], $attributes)."</div>";
echo '<div class="form-field-description">Config description (*):</div><div>'.Form::textarea('description', $config['description'], $attributes)."</div>";
?>
<div class="form-field-description">Mail list:</div>
<?php
#echo "<div>".Form::hidden('config_id', $config['id'])."</div>";
#echo "<div>".Form::hidden('target', 'mail-list')."</div>";
?>
<?php foreach($mail_list as $key=>$mail):?>
<?php echo "<div>".Form::input("email".$key, $mail['email'], $attributes)."</div>";?>
<?php endforeach;?>
<?php
if (!(isset($key)))
{
	$key=0;
}
else
{
	$key++;
}
echo "<div>".Form::input("email".$key, null, $attributes)."</div>";
echo "<div>".Form::submit('submit','Save', $attributes)."</div>";
echo "<div>".Form::close()."</div>";
?>
</div>
<a href="/config/delete/<?php echo $config['config_id'];?>">delete config</a>

<?php echo View::factory('blocks/footer')->render();?>
