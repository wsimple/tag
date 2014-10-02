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

if(in_array(strtoupper($_SERVER['REQUEST_METHOD']),array('GET','POST'))&&!count($_REQUEST)) include 'show_video.php';
require('UploadHandler.php');
require('VideoCaptures.php');
require('VideoConvertion.php');
$video_convertion = new VideoConvertion();
$upload_handler = new UploadHandler();
