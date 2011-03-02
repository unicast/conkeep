<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php if (isset($title)): $var['title']=$title; echo View::factory('blocks/header', $var)->render(); endif; ?>
<?php if (isset($error)): $var['error']=$error; echo View::factory('blocks/error', $var)->render(); endif; ?>

<div id="configs">
<?php $var['config_id'] = $config_id; echo View::factory('blocks/toolbar', $var)->render(); ?>
<?php if (isset($changelog)): ?>
<form action="/config/diff/<?php echo $config_id; ?>" method="get">
<table>
<thead>
<tr><th>#</th><th></th><th></th><th>Updated on</th><th>Is commented</th><th>&nbsp;</th></tr>
</thead>
<?php foreach ($changelog as $id => $item): ?>
<tr>
<td><?php echo '<a href="/config/show/' . $config_id . '/' . $item['revision'] . '">' . $item['revision'] . '</a>'; ?></td>
<?php if ( $id==0 ): ?>
<td class="checkbox"><input checked=true id="cb-<?=$id?>" name="revision" onclick="$('#cbto-<?=$id+1?>').attr('checked',true);" type="radio" value="<?=$item['revision']?>" /></td> 
<td class="checkbox"></td>
<?php elseif ( $id == 1 ): ?>
<td class="checkbox"><input id="cb-<?=$id?>" name="revision" onclick="$('#cbto-<?=$id+1?>').attr('checked',true);" type="radio" value="<?=$item['revision']?>" /></td> 
<td class="checkbox"><input checked=true id="cbto-<?=$id?>" name="revision_from" type="radio" value="<?=$item['revision']?>" /></td>
<?php elseif ( $id == (count($changelog)-1) ): ?>
<td class="checkbox"></td> 
<td class="checkbox"><input id="cbto-<?=$id?>" name="revision_from" type="radio" value="<?=$item['revision']?>" /></td>
<?php else: ?>
<td class="checkbox"><input id="cb-<?=$id?>" name="revision" onclick="$('#cbto-<?=$id+1?>').attr('checked',true);" type="radio" value="<?=$item['revision']?>" /></td> 
<td class="checkbox"><input id="cbto-<?=$id?>" name="revision_from" type="radio" value="<?=$item['revision']?>" /></td>
<?php endif; ?>

<td><?php echo $item['updated_on']; ?></td>
<td><?php echo $item['commented']; ?></td>
</tr>
<?php endforeach; ?>
</table>
<input class="small" name="commit" type="submit" value="Просмотреть отличия" /> 
</form>
<?php endif; ?>
</div>

<?php echo View::factory('blocks/footer')->render();?>
