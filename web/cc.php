<?php

if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || (!in_array(@$_SERVER['REMOTE_ADDR'], array(
		'127.0.0.1', 
		'fe80::1', 
		'::1',
		'95.97.83.74', //Bosqom (net)
	)) && (strpos($_SERVER['REMOTE_ADDR'], '192.168.') !== 0))
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}
 
// --- cache location
$cache_dir = dirname(__FILE__) . '/../app/cache';
echo "<b>cache_dir : $cache_dir</b>";
// ---
 
 
function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				$o = $dir . "/" . $object;
				if (filetype($o) == "dir") {
					rrmdir($dir."/".$object);
				}
				else {
					echo "<br/>" . $o;
					unlink($o);
				}
			}
		}
 
		reset($objects);
		rmdir($dir);
	}
}
 
 
function cc($cache_dir, $name) {
	$d = $cache_dir . '/' . $name;
	if (is_dir($d)) {
		echo "<br/><br/><b>clearing " . $name . ' :</b>';
		rrmdir($d);
	}
}
 
 
if (is_dir($cache_dir)) {
	if (basename($cache_dir) == "cache") {
		echo "<br/><br/><b>clearing cache :</b>";
		cc($cache_dir, "dev");
		cc($cache_dir, "dev_old");
		cc($cache_dir, "prod");
		cc($cache_dir, "test");
		echo "<br/><br/><b>done !</b>";
	}
	else {
		die("<br/> Error : cache_dir not named cache ?");
	}
}
else {
	die("<br/> Error : cache_dir is not a dir");
}
 
?>
