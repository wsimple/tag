<?php
if(!is_dir('.security')||!is_file('.security/security.php')||isset($_GET['security'])) include('main/core/install.php');
if(is_dir('.security')&&is_file('.security/security.php')) {
	echo 'instalado<br/>';
	include('.security/security.php');
	if(isset($_GET['show'])){
		echo '<pre>';
		var_dump($config);
		echo '</pre>';
	}
}