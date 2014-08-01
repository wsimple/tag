<?php
if(!is_file('includes/security/security.php')||isset($_GET['generate'])){
	if(!is_file('includes/security/security.php')||isset($_GET['security'])){
		include('main/generate/security.php');
		if(is_file('includes/security/security.php')){
			echo 'instalado<br/>';
			include('includes/security/security.php');
			if(isset($_GET['show'])){
				echo '<pre>';var_dump($config);echo '</pre>';
			}
		}
	}elseif(isset($_GET['language'])){
		include('main/generate/lang.php');
	}
	if(isset($_GET['wpanel'])) header('Location: wpanel/?successlang');
	//die('<p>End Generator.</p>');
}
