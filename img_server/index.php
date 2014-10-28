<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors',1);
require_once('includes/client.php');

function __autoload($classname){
	#carga automatica de clases permitidas
	$file="$classname.php";
	if(is_file($file)) require_once $file;
	else die('Class not found.');
}

$upload_handler = new UploadHandler();
