<div id="edit-device">

<div class="page-name"><h2>Device settings</h2></div>
<?php $attributes['class'] = "device-form";?>
<?php if (isset($edit_devices)): ?>
<?php //foreach($edit_devices as $device):?>
<?php
$device=$edit_devices[0];
echo Form::open(null, $attributes);
echo "<div>".Form::hidden('id', $device['id'])."</div>";
echo "<div>".Form::hidden('target', 'settings')."</div>";
echo "<div>".Form::input('name', $device['name'], $attributes)."</div>";
echo "<div>".Form::textarea('description', $device['description'], $attributes)."</div>";
echo "<div>".Form::input('link', $device['link'], $attributes)."</div>";
echo "<div>".Form::submit('submit','Save', $attributes)."</div>";
?>
<?php //endforeach;?>
<?php echo "<div>".Form::close()."</div>";?>
<?php endif; ?>

<div class="page-name"><h2>Mail list</h2></div>
<?php if (isset($mail_list)): ?>
<?php $attributes['class'] = "device-form";?>
<?php
echo Form::open(null, $attributes);
echo "<div>".Form::hidden('device-id', $device['id'])."</div>";
echo "<div>".Form::hidden('target', 'mail-list')."</div>";
?>
<?php foreach($mail_list as $key=>$mail):?>
<?php echo "<div>".Form::input("email".$key, $mail['email'], $attributes)."</div>";?>
<?php endforeach;?>
<?php 
$next_mail = max($mail_list->as_array());
$key = $next_mail['id']+1;
//echo Kohana::debug($mail_list->_total_rows);

//echo Kohana::debug("<div>".Form::input("email".$key, null, $attributes)."</div>");
?>
<?php endif; ?>
<?php
if (!(isset($key)))
{
	$key=0;
}
echo "<div>".Form::input("email".$key, null, $attributes)."</div>";
echo "<div>".Form::submit('submit','Save', $attributes)."</div>";
echo "<div>".Form::close()."</div>";
?>
</div>
