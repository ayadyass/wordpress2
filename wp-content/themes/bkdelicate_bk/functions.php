<?php

$themename = 'delicate';
$current = '3.4.3';

$url = get_template_directory_uri();
$link = home_url();
$manualurl = 'http://support.nattywp.com/index.php?act=kb';

$functions_path = TEMPLATEPATH . '/functions/';
$include_path = TEMPLATEPATH . '/include/';
$license_path = TEMPLATEPATH . '/license/';

require_once ($include_path . 'settings-color.php');
require_once ($include_path . 'settings-theme.php');
require_once ($include_path . 'settings-comments.php');

require_once ($functions_path . 'core-init.php');

require_once ($include_path . 'hooks.php');
require_once ($include_path . 'sidebar-init.php');
require_once ($include_path . 'widgets/flickr.php');
require_once ($include_path . 'widgets/feedburner.php');
require_once ($include_path . 'widgets/twitter.php');

require_once ($license_path . 'license.php');

?>