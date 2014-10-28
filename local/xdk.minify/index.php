<?php
require 'relpath.php';
$path=$relpath.'app';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Minify</title>
	<meta http-equiv="Content-Type" events="text/html; charset=UTF-8"/>
	<script src="jquery.min.js"></script>
	<script src="jquery.qajax.js"></script>
</head>
<style>
	.news{
		margin:5px;
		padding:5px 0;
	}
	.news h2{
		font-size:16px;
	}
	.files-selector ul{
		list-style:none;
		padding:0;
	}
	.files-selector ul li{
		float:left;
		width:200px;
		border-top:1px solid #ccc;
	}
	.files-selector ul li:first-child,.files-selector ul li:last-child{
		float:none;
		width:auto;
		clear:both;
	}
	.last{
		border:#333;
		background:#ccc;
	}
	.events{
		background:#999;
	}
</style>
<body>
	<div>Al final de la ventana aparece el desglose completo del proceso.</div>
	<input class="start" type="button" value="Iniciar"/>
	<input class="end" type="button" value="Detener"/>
	<div class="news" style="display:none;">
		<div>Ultimo evento:</div>
		<div class="last"></div>
		<span class="loader" style="display:none;"><img src="loader.gif"/></span>
	</div>
	<hr/>
	<form action="#" method="POST">
	<div class="files-selector">
		<div>ELIJA LOS ARCHIVOS A MINIMIZAR</div>
		<ul>
			<li>
				<span>Seleccion multiple:</span>
				<input id="selectAll" type="button" value="Todos"/>
				<input id="selectNone" type="button" value="Ninguno"/>
			</li>
			<li class="js"><input type="checkbox" name="files[]" value="js" checked="checked">min.js</li>
<?php
if(($dir=opendir($path))){
	while(($file=readdir($dir))!==false){
		if(strpos($file,'.php')){
?>
			<li class="file"><input type="checkbox" name="files[]" value="<?=$file?>" checked="checked"><?=$file?></li>
<?php
		}
	}
	closedir($dir);
}
?>
			<li></li>
		</ul>
	</div>
	</form>
	<div class="events"></div>
	<script>
		$(function(){
			var //devices=['android','ios'],
				$body=$('.events'),
				$last=$('.last'),
				$both=$body.add($last),
				$loader=$('.loader');
			$('.start').click(start);
			$('.end').click(function(){
				msg('Cancelados los procesos.');
				$.qajax('abort');
			});
			$('#selectAll').click(function(event){
				$(':checkbox').prop('checked',true);
			});

			$('#selectNone').click(function(event){
				$(':checkbox').prop('checked',false);
			});
			function msg(txt,clear){
				if(clear!==true) $last.empty();
				$both.append(txt);
			}
			function start(){
				$('.news').show();
				$body.html('<h2>Lista completa de eventos</h2>');
				msg('Iniciando<hr/>');
				if($(':checkbox:checked').length>0){
					if($('.js :checkbox:checked').length>0){
//						devices.forEach(function(opc){
							$.qajax('high',{
//								url:'js.php?type='+opc,
								url:'js.php',
								success:function(data){
									msg(data);
								}
							}).before(function(){
								msg('<h2>Generando js</h2><hr/>');
//								msg('<b>Minifying '+opc+' js.</b><hr/>');
								$loader.show();
							}).always(function(){
								$loader.hide();
							});
//						});
					}
					var last,first='<h2>Generando vistas</h2><hr/>';
					$('.file :checkbox:checked').each(function() {
						var file = this.value;
						last=$.qajax('low',{
							url:'view.php?file='+file,
							success:function(data){
								msg(data);
							}
						}).before(function(){
							if(first){
								msg(first);
								first=false;
							}
							$loader.show();
						}).always(function(){
							$loader.hide();
						});
					});
					last.always(function(){
						$both.append('Terminado.');
					});
				}else{
					msg('No hay elementos seleccionados.<hr/>Terminado.');
				}
			}
		});
	</script>
</body>
</html>
