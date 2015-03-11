<?php include 'inc/header.php'; ?>
<style>
	.msg{
		margin:20px;
		text-align:center;
	}
</style>
<div id="page-setting" data-role="page" data-cache="false" class="no-footer">
	<div  data-role="header" data-theme="f" data-position="fixed">
		<h1><span class="loader"></span></h1>
	</div>
	<div data-role="content">
		<div class="msg"></div>
	</div>
	<script>
		pageShow({
			id:'page-setting',
			title:lan('setting','ucf'),
			before:function(){
				$('.msg').html(lan('MODULE_NOT_AVAILABLE'));
			},
			after:function(){
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
