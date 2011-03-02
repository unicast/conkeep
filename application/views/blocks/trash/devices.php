<div id="devices">

<div class="page-name"><h2>My devices:</h2></div>
 <?php if (isset($devices)): ?>
 <?php foreach($devices as $device):?>
 <div class="device" id="device<?php echo $device['id'];?>">
  <div class="device-name"><a href="/rules/show/<?php echo $device['id'];?>"><?php echo $device['name'];?></a> <a href="/device/edit/<?php echo $device['id'];?>">edit</a></div>
  <div class="device-description"><?php echo $device['description'];?></div>
  <div class="device-link"><a href="<?php echo $device['link'];?>" target="_blank"><?php echo $device['link'];?></a></div>
 </div>
 <?php endforeach;?>
 <?php $device_next_id = max($devices->as_array());?>
 <?php endif; ?>
 <div class="ajax-link"><a href="/device/edit/<?php echo $device_next_id['id']+1;?>">add device</a></div>
 
</div>
