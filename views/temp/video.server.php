<?php
	error_reporting(E_ALL);
	echo "<p>id</p>";
	echo shell_exec("id 2>&1");
	echo "<p>ls</p>";
	echo shell_exec("ls /root  2>&1");
	// echo shell_exec("ls /root/Videos 2>&1");
	echo "<p>Starting ffmpeg...</p>";
	echo shell_exec("ffmpeg 2>&1");// -i gorilon.flv gorilon.mp4 2>&1");
	echo "<p>Done.</p>";
