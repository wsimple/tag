
<div>
	<button id="boton1">boton1</button>
	<button ajax>first</button>
</div>
<script type="text/javascript">
	$('#boton1').click(function(){
		$.c('ajax').log('click ajax button');
		$.ajax({
			url:'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js?'+Math.random(),
			type:'get',
			disablebuttons:true
		});
		$(this).parent().append(' <button ajax>next</button>');
	});
</script>