<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
   	include('includes/session.php');
	include('includes/config.php');
?><html>
<head>
	<!-- ola -->
	<script src="js/jquery-1.8.3.js"></script>
	<script src="js/jquery.local.js" ></script>
	<script>
		var count=('<?=$_SESSION['ws-tags']['ws-user']['logins_count']?>'*1)||0,
			url='<?=DOMINIO?>'+($.session('login_url')||(count>1?'':'<?=base_url('welcome')?>'));
		$.session('login_url',null);
		document.location=url;
	</script>
</head>
<body>
</body>
</html>
