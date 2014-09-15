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
require_once('includes/client.php');
if(!count($_REQUEST)) include 'show_video.php';
error_reporting(E_ALL | E_STRICT);
require('VideoConvertion.php');
$video_convertion = new VideoConvertion();
require('UploadHandler.php');
$upload_handler = new UploadHandler();
