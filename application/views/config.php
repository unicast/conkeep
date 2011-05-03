<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php if (isset($title)): $var['title']=$title; echo View::factory('blocks/header', $var)->render(); endif; ?>
<?php if (isset($error)): $var['error']=$error; echo View::factory('blocks/error', $var)->render(); endif; ?>

<div id="configs">
<?php if (!empty($configs)): ?>
<?php foreach($configs as $config):?>
<div class="config" id="config<?php echo $config['config_id'];?>">
<div class="config-box">
<div class="config-name">
<a href="/config/show/<?php echo $config['config_id'];?>"><?php echo $config['name']; ?>
<!--
<?php //if (($config['commented'])!=0): ?>
&nbsp;<img src="images/asterisk.png" alt="Config contains unacknowledged changes!" title="Config contains unacknowledged changes!" />
<?php //endif; ?>
-->
</a>
</div><div class="config-settings">
<a href="/config/edit/<?php echo $config['config_id'];?>"><img src="images/wrench.png" alt="settings" title="settings" /></a></div>
</div><div class="config-description">
<?php //echo Html::chars(Helper_ConkeepHelper::text_to_anchor($config['description'])); ?>
<?php //echo Text::auto_p(Text::auto_link($config['description'])); ?>
<?php echo Text::auto_p(Helper_ConkeepHelper::text_to_anchor($config['description']), true); ?>
</div>
</div>
<?php endforeach;?>
<?php endif; ?>
<div class="ajax-link"><a href="/config/new">add config</a></div>
</div>

<?php echo View::factory('blocks/footer')->render();?>
