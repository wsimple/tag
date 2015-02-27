// JavaScript Document
function requestFormulario(destino,consulta){
	
		type=$(destino).type;
		eventos=$(destino).clone();
		eventos.cloneEvents($(destino));
		//alert(type);
		var myRequest = new Request({method: 'post', url: '../includes/consulta.php',
									 onComplete: function(response) { 
									 	if(type=='text'||type=='textarea'||type=='hidden'){
											$(destino).set('text', response);
										}else{//  select-one
											$('box_'+destino).set('html', response);
											
											  $(destino).cloneEvents(eventos);

											
										}
										
									}});
									
		myRequest.send('tipo='+type+'&consulta='+consulta+'&destino='+destino);
}
function requestSimple(destino,url,get,imgPrecarga,cadena){
		if(imgPrecarga)
			$(destino).set('html', '<img src="'+imgPrecarga+'" border="0"  />&nbsp;'+cadena+' ...');
		
		var myRequest = new Request({method: 'post', url: url,
									 onComplete: function(response) { 
                                            //alert(response);
											$(destino).set('html', response);
										
									}});
		if(!get)get='';							
		myRequest.send(get);
}
/*
<!-- 
		+ --------------------------------------------------------- +
		|                                                           |
		| 	Desarrollado por: Gustavo A. Ocanto C.                  |
		| 	Email: gustavoocanto@gmail.com / info@websarrollo.com   |
		| 	Teléfono: 0414-428.42.30 / 0245-511.38.40               |
		| 	Web: http://www.gustavoocanto.com                       |
		|        http://www.websarrollo.com                         |
		| 	Valencia, Edo. Carabobo - Venezuela                     |
		|                                                           |
        + --------------------------------------------------------- +
-->
*/