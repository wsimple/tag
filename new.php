<?php if(!is_dir('.security')||!is_file('.security/security.php')) include('base/install.php');
else {
	// include('index.php');
	echo 'instalado<br/>';
	include('.security/security.php');
	echo '<pre>';
	// print_r($config);
	echo '</pre>';
}