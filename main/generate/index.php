<?php
if(!is_dir('.security')||!is_file('.security/security.php')||isset($_GET['generate'])){
	if(!is_dir('.security')||!is_file('.security/security.php')||isset($_GET['security'])){
		include('main/generate/security.php');
		if(is_dir('.security')&&is_file('.security/security.php')){
			echo 'instalado<br/>';
			include('.security/security.php');
			if(isset($_GET['show'])){
				echo '<pre>';
				var_dump($config);
				echo '</pre>';
			}
			if(isset($_GET['wpanel']) header('Location:wpanel/?successlang');
		}
	}elseif(isset($_GET['language'])){
		include('main/generate/lang.php');
	}
	die('<p>End Generator.</p>');
}
