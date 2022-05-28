<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/wp-config.php');
require_once('helper.php');
$helper = new Helper;
$jsondata = file_get_contents(dirname(__FILE__).'/types.json');
$jsondata = json_decode($jsondata, true);

$originalLocales = explode(";", setlocale(LC_ALL, 0));
$results = setlocale(LC_ALL, 'he_IL.UTF8', 'he.UTF8', 'he_IL.UTF-8', 'he.UTF-8');

if (!$results) {
    exit('setlocale failed: locale function is not available on this platform, or the given local does not exist in this environment');
}

 bindtextdomain("painting-he_IL", "/var/www/wordpress/wp-content/plugins/painting/locale");
 textdomain("painting-he_IL");
 echo gettext("Add");
