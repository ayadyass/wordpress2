<?php
$zone_id = $_GET['zone_id'];

echo '<table width="100%" cellpadding="5" cellspacing=1" style="border:1px solid #dfdfdf">';
echo '<tr><td bgcolor="#f5f5f5">Theme Function</td></tr>';
echo '<tr><td>&lt;?php mban_sidebar_banners('.$zone_id.');?&gt;</td></tr>';
echo '<tr><td>&nbsp;</td></tr>';
echo '<tr><td bgcolor="#f5f5f5">Template Tag</td></tr>';
echo '<tr><td>&lt;!-- MaxBanners:Zone-'.$zone_id.' --&gt;</td></tr>';
echo '</table>';
?>