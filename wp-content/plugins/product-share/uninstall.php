<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$options_array = array(
	'product_share_option',
);

foreach ($options_array as $key => $option) {
	delete_option($option);
}
 