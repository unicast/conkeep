<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php if (isset($title)): $var['title']=$title; echo View::factory('blocks/header', $var)->render(); endif; ?>
<?php if (isset($error)): $var['error']=$error; echo View::factory('blocks/error', $var)->render(); endif; ?>

<div id="configs">
<?php $var['config_id'] = $config_id; echo View::factory('blocks/toolbar', $var)->render(); ?>
<?php if (!empty($diff)): ?>
<div class="config-diff">
<?php #echo Kohana::debug($diff); ?>
<?php
foreach ($diff as $k) {
	if (is_array($k)) {
		if (!empty($k['d'])) {
			foreach ( $k['d'] as $k_element ) {
				echo '<p><span class="deleted">' . $k_element['line'] . "</span></p>\n";
			}
		}
		elseif (!empty($k['i'])) {
			foreach ( $k['i'] as $k_element ) {
				echo '<p><span class="inserted">' . $k_element['line'] . "</span></p>\n";
			}
		}
		else {
			echo "<p>" . $k['line'] . "</p>\n";
		}
	}
	else {
		echo $k;
	}
}
?>
</div>
<?php endif; ?>
</div>

<?php echo View::factory('blocks/footer')->render();?>
