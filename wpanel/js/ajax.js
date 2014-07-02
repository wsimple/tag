/*
<!-- 
		+ --------------------------------------------------------- +
		|                                                           |
		| 	Desarrollado por: Gustavo A. Ocanto C.                  |
		| 	Email: gustavoocanto@gmail.com / info@websarrollo.com   |
		| 	Tel�fono: 0414-428.42.30 / 0245-511.38.40               |
		| 	Web: http://www.gustavoocanto.com                       |
		|        http://www.websarrollo.com                         |
		| 	Valencia, Edo. Carabobo - Venezuela                     |
		|                                                           |
        + --------------------------------------------------------- +
-->
*/
function nuevo_ajax(){ 
	     var xmlhttp=false; 
		 try{ 
		     xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	     }
	     catch(e){ 
		 try{ 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		 }  
		 catch(E) { xmlhttp=false; }
	     }
	     if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 
 	     return xmlhttp; 
}

function ir_url (url,idCapa){
	     var capa =	document.getElementById(idCapa);
	     var ajax = nuevo_ajax();
	     capa.innerHTML='<img src="img/cargando.gif" width="16" height="11" border="0"  />';
	     ajax.open("POST",url, true);
	     ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	     ajax.send("");
	
	     ajax.onreadystatechange=function(){
             if (ajax.readyState==1){
				 capa.innerHTML='<img src="img/cargando.gif" width="16" height="11" border="0"  />';  
			 }
             
			 if (ajax.readyState==2){
				 capa.innerHTML='<img src="img/cargando.gif" width="16" height="11" border="0"  />';
			 }
             
			 if (ajax.readyState==3){
				 capa.innerHTML='<img src="img/cargando.gif" width="16" height="11" border="0"  />';
			 }
			 
			 if (ajax.readyState==4){
				 capa.innerHTML=ajax.responseText;
			 }
		 }	
}

function process(url,redir){
	    
	     var ajax = nuevo_ajax();
	     
	     ajax.open("POST",url, true);
	     ajax.send("");
		 if(redir)
		 ajax.onreadystatechange=function(){
			 redirect(redir);
			 
		 }
		
}

function login (url,idCapa){
	     var capa =	document.getElementById(idCapa);
	     var ajax = nuevo_ajax();
		 
	     capa.innerHTML='<img src="img/cargando.gif" width="16" height="11" border="0"  />';
	     ajax.open("POST",url, true);
	     ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	     ajax.send("login="+document.getElementById('txtNombre').value+"&clave="+document.getElementById('txtClave').value);
	
	     ajax.onreadystatechange=function(){
             if (ajax.readyState==1){
				 capa.innerHTML='<img src="img/cargando.gif" width="16" height="11" border="0"  />';  
			 }
             
			 if (ajax.readyState==2){
				 capa.innerHTML='<img src="img/cargando.gif" width="16" height="11" border="0"  />';
			 }
             
			 if (ajax.readyState==3){
				 capa.innerHTML='<img src="img/cargando.gif" width="16" height="11" border="0"  />';
			 }
			 
			 if (ajax.readyState==4){
				 //capa.innerHTML=ajax.responseText;
				 //alert(ajax.responseText);
				 if (ajax.responseText=='NotOk'){
					 Alert.error('Los datos suministrados son incorrectos.<br><br><p style="font-size:11px; color:#999999; margin-top:20px">Si el <strong>error</strong> perciste, comuniquese con el departamento de <a href="mailto:gustavo.ocanto@encava.com" onfocus="this.blur();">Inform&aacute;tica</a>.</p>');
					 document.getElementById('txtNombre').value = document.getElementById('txtClave').value = "";
				     capa.innerHTML='<img src="img/users1.png" width="16" height="16" border="0"  />';
					 foco('txtNombre',1);
				 }else{
				     inicio('index.php');  	 
					 
				 }
			 }
		 }	
}
	
	


/*
<!-- 
		+ --------------------------------------------------------- +
		|                                                           |
		| 	Desarrollado por: Gustavo A. Ocanto C.                  |
		| 	Email: gustavoocanto@gmail.com / info@websarrollo.com   |
		| 	Tel�fono: 0414-428.42.30 / 0245-511.38.40               |
		| 	Web: http://www.gustavoocanto.com                       |
		|        http://www.websarrollo.com                         |
		| 	Valencia, Edo. Carabobo - Venezuela                     |
		|                                                           |
        + --------------------------------------------------------- +
-->
*/