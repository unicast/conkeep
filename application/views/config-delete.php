<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php if (isset($title)): $var['title']=$title; echo View::factory('blocks/header', $var)->render(); endif; ?>
<?php if (isset($error)): $var['error']=$error; echo View::factory('blocks/error', $var)->render(); endif; ?>

<div id="delete-config">

Do You realy wont to delete config <?php echo $config_content['name'];?>?<br />
<a href="/config/delete_confirm/<?php echo $config_content['config_id'];?>">delete config</a>
<a href="/config/edit/<?php echo $config_content['config_id'];?>">cancel</a>
</div>

<?php echo View::factory('blocks/footer')->render();?>
