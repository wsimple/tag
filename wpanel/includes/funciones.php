<?php

function filtraInyeccionSql($mensaje)

{

	$mensaje = str_replace(array("-","#","%","'","\\","\"","'",">","<"),"",$mensaje);

	$mensaje=strtolower($mensaje);

	return $mensaje;

}

function quitar_inyect(){

	//$vect=array($_SESSION,$_POST,$_GET,$_FILES,$_COOKIE);

	$filtro = array("\"","\\","'","|","{","}","[","]","*",">", "<", "INSERT " , "insert ", "UPDATE", "update", "DELETE", "delete"," x00 ","\\", "\\\\", " x1a ");

	foreach($_POST as $k=>$v){

	    foreach ($filtro as $index){

	    	$v=str_replace(trim($index), '',$v);

		}

		$_POST["$k"]=addslashes(htmlspecialchars($v,ENT_NOQUOTES));

	}

	foreach($_GET as $k=>$v){

	    foreach ($filtro as $index){

	    	$v=str_replace(trim($index), '',$v);

		}

		$_GET["$k"]=addslashes(htmlspecialchars($v,ENT_NOQUOTES));

	}



	return true;

}



function corta_cadena($cadena,$tamananio){

	$band=true;$i=0;

	$salida='';

	while(true){

		if(($i>=$tamananio&&$cadena[$i]==' ')||($i==strlen($cadena))){

			return $salida;

			}

		$salida.=$cadena[$i++];

	}

}



function formatoFecha($fecha){

	if(strpos($fecha,'-')){

		$fecha=explode('-',$fecha);

		$fecha[2]=explode(' ',$fecha[2]);

	    $fecha[2]=$fecha[2][0];

		return $fecha[1]."/".$fecha[2]."/".$fecha[0];

	}elseif(strpos($fecha,'/')){

		$fecha=explode('/',$fecha);

		return $fecha[2]."-".$fecha[0]."-".$fecha[1];

	}

	return false;

}





function montosInsert($monto,$dec=2){

	$pos1 = strpos($monto,",");

	if ($pos1 === false){

		return number_format($monto,$dec,'.','');

	}else{

		return number_format(str_replace(',','.',str_replace('.','',$monto)),2,'.','');

	}

}



function _imprimir($array){

		 echo "<pre>"; print_r($array); echo "</pre>";
}





function decimal_romano($numero)

{

	$numero=floor($numero);

	if($numero<0){

		$var="-";

		$numero=abs($numero);

	}

	# Definici&oacute;n de arrays

	$numerosromanos=array(1000,500,100,50,10,5,1);

	$numeroletrasromanas=array("M"=>1000,"D"=>500,"C"=>100,"L"=>

	50,"X"=>10,"V"=>5,"I"=>1);

	$letrasromanas=array_keys($numeroletrasromanas);



	while($numero)

	{

		for($pos=0;$pos<=6;$pos++)

		{

		$dividendo=$numero/$numerosromanos[$pos];

			if($dividendo>=1)

			{

			$var.=str_repeat($letrasromanas[$pos],floor($dividendo));

			$numero-=floor($dividendo)*$numerosromanos[$pos];

			}

		}

	}

	$numcambios=1;

	while($numcambios)

	{

	$numcambios=0;

		for($inicio=0;$inicio<strlen($var);$inicio++)

		{

		$parcial=substr($var,$inicio,1);

		if($parcial==$parcialfinal&&$parcial!="M")

		{

		$apariencia++;

		}else{

		$parcialfinal=$parcial;

		$apariencia=1;

	}

	# Caso en que encuentre cuatro car�cteres seguidos iguales.

	if($apariencia==4)

	{

		$primeraletra=substr($var,$inicio-4,1);

		$letra=$parcial;

		$sum=$primernumero+$letternumero*4;

		$pos=busqueda($letra,$letrasromanas);

	if($letrasromanas[$pos-1]==$primeraletra)

	{

		$cadenaant=$primeraletra.str_repeat($letra,4);

		$cadenanueva=$letra.$letrasromanas[$pos-2];

	}else{

		$cadenaant=str_repeat($letra,4);

		$cadenanueva=$letra.$letrasromanas[$pos-1];

	}

		$numcambios++;

		$var=str_replace($cadenaant,$cadenanueva,$var);

	}

	}

	}

	return $var;

	}

















function quitarAcentos($text)

	{

		$text = htmlentities($text);

		$text = strtolower($text);

		$patron = array (

			// Espacios, puntos y comas por guion

			'/[\., ]+/' => '-',



			// Vocales

			'/&agrave;/' => 'a',

			'/&egrave;/' => 'e',

			'/&igrave;/' => 'i',

			'/&ograve;/' => 'o',

			'/&ugrave;/' => 'u',



			'/&aacute;/' => 'a',

			'/&eacute;/' => 'e',

			'/&iacute;/' => 'i',

			'/&oacute;/' => 'o',

			'/&uacute;/' => 'u',



			'/&acirc;/' => 'a',

			'/&ecirc;/' => 'e',

			'/&icirc;/' => 'i',

			'/&ocirc;/' => 'o',

			'/&ucirc;/' => 'u',



			'/&atilde;/' => 'a',

			'/&etilde;/' => 'e',

			'/&itilde;/' => 'i',

			'/&otilde;/' => 'o',

			'/&utilde;/' => 'u',



			'/&auml;/' => 'a',

			'/&euml;/' => 'e',

			'/&iuml;/' => 'i',

			'/&ouml;/' => 'o',

			'/&uuml;/' => 'u',



			'/&auml;/' => 'a',

			'/&euml;/' => 'e',

			'/&iuml;/' => 'i',

			'/&ouml;/' => 'o',

			'/&uuml;/' => 'u',



			// Otras letras y caracteres especiales

			'/&aring;/' => 'a',

			'/&ntilde;/' => 'n',



			// Agregar aqui mas caracteres si es necesario



		);



		$text = preg_replace(array_keys($patron),array_values($patron),$text);

		return $text;

	}

function mensajes($mensaje,$redirect='',$tipo='info'){

echo "<script language='javascript' type='text/javascript' >
        window.addEvent('domready', function(){
            Alert.".$tipo."('$mensaje',
                {
                    onComplete: function(returnvalue){
                    ".($redirect!=''?'':'//')."redirect('$redirect');
                    }
                });
        });
    </script>";
}





	  function cls_string($cad){

		  	   $filtro = array("\"",",","!","?","�","�", "$", "%", "&","\\","'","|","{","}","[","]","+", "*",">", "<", "INSERT" , "insert", "UPDATE", "update", "DELETE", "delete",

			                   "x00","\n","\r","\\", "\\\\", "x1a", "OR", "or");

			   foreach ($filtro as $index){

			            $cad=str_replace($index, '',$cad);

			   }

	           return $cad;

	   }



	   function formato($numero){

	            return number_format($numero,2,'.',',');

	   }



	   function sinFormato($number){

                return str_replace(',','.',str_replace('.','',$number));

       }



	   function generaHidden(){

			reset($_REQUEST);

			$REQUEST=$_REQUEST;
			$hidden='';
			for($i=0;$i<count($REQUEST);$i++){

					$value = current($REQUEST);

					$nombre=key($REQUEST);

					$hidden.= "\n<input name='$nombre' type='hidden' id='$nombre' value='$value'>";

					next($REQUEST);

			}

			reset($_REQUEST);

			return $hidden;

		}

	   function generaGet(){

			reset($_REQUEST);

			$REQUEST=$_REQUEST;

			$get= '?';

			for($i=0;$i<count($REQUEST);$i++){

					$value = current($REQUEST);

					$nombre=key($REQUEST);

					$get.=$nombre."=".$value."&";

					next($REQUEST);

			}

			reset($_REQUEST);



			return substr($get,0,-1);



		}



       function visitas(){

	   			$valorInicial=2355;

				$query   = mysql_query("SELECT * FROM visitas") or die (mysql_error());

				$num     = mysql_num_rows($query);

				$visitas = mysql_query("SELECT * FROM visitas WHERE ip = '".$_SERVER['REMOTE_ADDR']."' AND (fecha  between '".(time()-600)."' and '".time()."' )") or die (mysql_error());

				if (mysql_num_rows($visitas) == 0){

				    $insert = mysql_query("INSERT INTO visitas SET ip = '".$_SERVER['REMOTE_ADDR']."', fecha = '".time()."'") or die (mysql_error());

					return ($num+$valorInicial + 1);

				}else{

				    return ($num+$valorInicial);

				}

	   }





	   /////////////////////////ymca



	   	 function descargas(){



			 $carpeta='archivos/';



		$dir=opendir($carpeta);





		while ($file = readdir($dir))

		{

		   if ($file != "."&&$file != ".."&& strpos($file,'.'))

		   {





			 $salida.= "<a href='includes/descargar.php?f=$file' >".$file."&nbsp;&nbsp;<img src='img/down.png'  /></a><br/>";

		   }

		}



		closedir($dir);





		return $salida;



	 }

	 function proximosEventos(){



	 	$eventos=mysql_query("SELECT * FROM `eventos`  WHERE fecha_ini >= CURDATE() ORDER BY fecha_ini LIMIT 4")or die(mysql_error());

		while ($evento=mysql_fetch_assoc($eventos)){

			$salida.= "<a href='?id=eventos&e=$evento[id]' > - $evento[titulo]</a><br/>";

		}

	 	return $salida;

	 }

	 function fijo($identificador){

	 	$contenido=mysql_query("SELECT * FROM `contenidos` WHERE fijo='$identificador'")or die(mysql_error());

		$contenido=mysql_fetch_assoc($contenido);

		return "<a href='?id=$contenido[id]' >$contenido[contenido]</a><br/>";

	 }



function campo($tabla, $campo, $criterio, $pos){

         $query = mysql_query("SELECT * FROM $tabla WHERE $campo = '$criterio'") or die (mysql_error());

		 $array = mysql_fetch_array($query);

		 return $array[$pos];

}



function existe($tabla, $campo, $where) {
	$query = $GLOBALS['cn']->query('SELECT '.$campo.' FROM '.$tabla.' '.$where);
	return (mysql_num_rows($query) > 0) ? true : false;
}





function limpiaClassForm(){



	reset($_REQUEST);

			$REQUEST=$_REQUEST;

			$get= '?';

			for($i=0;$i<count($REQUEST);$i++){

					$value = current($REQUEST);

					$nombre=key($REQUEST);

					if(strpos(' '.$nombre,$_REQUEST[_FORM_])){

						$_REQUEST[str_replace($_REQUEST[_FORM_].'_','',$nombre)]=$value;

					}

					next($REQUEST);

			}

			reset($_REQUEST);



			return substr($get,0,-1);







}

function redimensionar($img_original, $img_nueva,$img_nueva_anchura,$img_nueva_altura='') {

	$type=Array(1 => 'gif', 2 => 'jpg', 3 => 'png');

	list($imgWidth,$imgHeight,$tipo,$imgAttr)=getimagesize($img_original);
	$type=$type[$tipo];

	switch($type){
		case "jpg" :
		case "jpeg": $img = imagecreatefromjpeg($img_original); break;
		case "gif" :  $img = imagecreatefromgif($img_original); break;
		case "png" :  $img = imagecreatefrompng($img_original); break;
	}

	//Obtengo el tama�o del original
	$img_original_anchura 	= $imgWidth;
	$img_original_altura 	= $imgHeight;
	// Obtengo la relacion de escala

	if($img_original_anchura > $img_nueva_anchura && $img_nueva_anchura > 0)
				$percent = (double)(($img_nueva_anchura * 100) / $img_original_anchura);

	if($img_original_anchura <= $img_nueva_anchura)
				$percent = 100;


	if(floor(($img_original_altura * $percent )/100)>$img_nueva_altura && $img_nueva_altura > 0)
				$percent = (double)(($img_nueva_altura * 100) / $img_original_altura);



	 $img_nueva_anchura=($img_original_anchura*$percent)/100;

	 $img_nueva_altura=($img_original_altura*$percent)/100;

	// crea imagen nueva redimencionada
	$thumb = imagecreatetruecolor ($img_nueva_anchura,$img_nueva_altura);

	if($type=='gif' || $type=='png')
			{
				/** Code to keep transparency of image **/
				/*$colorcount = imagecolorstotal($this->_img);
				if ($colorcount == 0) $colorcount = 256;
				imagetruecolortopalette($newimg,true,$colorcount);*/
				imagepalettecopy($thumb,$img);
				$transparentcolor = imagecolortransparent($img);

				imagefill($thumb,0,0,$transparentcolor);

				imagecolortransparent($thumb,$transparentcolor);
			}

	// redimensionar imagen original copiandola en la imagen nueva
	imagecopyresampled ($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura, $imgWidth,$imgHeight);
	// guardar la imagen redimensionada donde indica $img_nueva
	switch($type){
		case "jpg":
		case "jpeg": imagejpeg($thumb,$img_nueva); break;
		case "gif":  imagegif($thumb,$img_nueva); break;
		case "png":  imagepng($thumb,$img_nueva); break;
	}

	imagedestroy($img);
	imagedestroy($thumb);


	//return $img_nueva;
}

function usersPreferences($usr=''){

	$usr   = ($usr!='') ? $usr : $_SESSION['ws-tags']['ws-user']['id'];
	$cad   = '';
	$query = $GLOBALS['cn']->query("SELECT preference FROM users_preferences WHERE id_user = '".$usr."'"); //todas las preferencias del usuario

	while ($array = mysql_fetch_assoc($query)){
			$ids = explode(',', $array[preference]); //vector de preferencias
			foreach ($ids as $index){
					if ($index!=''){
						$validar = $GLOBALS['cn']->query("SELECT id_preference, detail FROM preference_details WHERE id = '".replaceCharacters($index)."' ");
						if (mysql_num_rows($validar) == 0){
							$cad .= $index.'|';
						}else{
							$valida = mysql_fetch_assoc($validar);
							$cad .= $valida[detail].'|';
						}
					}// si el dato no esta vacio
			}//foreach
	}//while
	return rtrim($cad,'|');
}

function replaceCharacters($cad){
	return mysql_real_escape_string($cad);
}

function createTag($tag,$force=false,$msg=false){
	//Informacion basica para crear la imagen de tag
	$path='img/tags';
	$idTag=is_numeric($tag)?md5($tag):$tag;
	$idTag=substr($idTag, -16);
	$photo=$idTag.'.jpg';
	$photom=$idTag.'.m.jpg';
	$photopath=$path.'/'.$photo;
	$photompath=$path.'/'.$photom;
	if(isset($_GET['debug'])) echo 'Debuger.';
	$_path=LOCAL?RELPATH:FILESERVER;
	//Se busca la imagen de la tag
	$im=imagecreatefromany($_path.$photopath);
	//Si la imagen de la tag no existe, se crea
	if(!$im || isset($_GET['debug']) || $force){
		$tag = getTagData($idTag);

		//Debugger
		if(isset($_GET['debug'])){
			_imprimir($tag);
			echo 'generatethumb='.generateThumbPath($_path.$tag['photoOwner']);
			echo '<br/>fondo='.(strpos(' '.$tag['fondoTag'],'default')?RELPATH:$_path).'img/templates/'.$tag['fondoTag'];
		}

		if($tag) {
			$font= array(
				RELPATH.'fonts/trebuc.ttf',
				RELPATH.'fonts/trebucbd.ttf',
				RELPATH.'fonts/verdana.ttf',
				RELPATH.'fonts/verdanab.ttf'
			);

			//Se crea la imagen con el tamaño normal - 650 x 300.
			$im		= imagecreatetruecolor(TAGWIDTH, TAGHEIGHT);

			//Crear algunos colores
			$blanco	= imagecolorallocate($im, 255, 255, 255);
			$negro	= imagecolorallocate($im, 0, 0, 0);

			//Fondo
			$imagen = (strpos(' '.$tag['fondoTag'],'default')?RELPATH:$_path).'img/templates/'.$tag['fondoTag'];
			$img = imagecreatefromany($imagen);
			if($img){
				$is = getimagesize($imagen);
				$dy=intval((TAGHEIGHT-$is[1])/2);
				while($dy>0) $dy-=$is[1];
				do{
					$dx=$is[0]>TAGWIDTH?intval((TAGWIDTH-$is[0])/2):0;
					do{
						imagecopy($im,$img,$dx,$dy,0,0,$is[0],$is[1]);
						$dx+=$is[0];
					}while($dx<TAGWIDTH);
					$dy+=$is[1];
				}while($dy<TAGHEIGHT);
				imagedestroy($img);
			}

			//Bordes redondeados
			$cr = 25; //radio de la curva
			$ce = array(1,1,1,1);//esquinas a redondear. (si,sd,ii,id). (tl,tr,bl,br).
			$mask = imagecreatetruecolor($cr*2+1, $cr*2+1);
			imagealphablending($mask,false);
			//$maskcolor = imagecolorallocate($im, 255, 0, 255);//color para remplazar por transparencia
			$maskcolor = imagecolorallocate($im, 255, 255, 255);
			$transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
			imagefilledrectangle($mask, 0, 0, $cr*2+1, $cr*2+1, $maskcolor);
			imagefilledellipse($mask, $cr, $cr, $cr*2, $cr*2, $transparent);
			// Top-left corner - esquina superior izquierda
			if ($ce[0]) {
				$cx = 0;
				$cy = 0;
				$dx = 0;
				$dy = 0;
				imagecopy($im, $mask, $dx, $dy, $cx, $cy, $cr, $cr);
			}
			// Top-right corner - esquina superior derecha
			if ($ce[1]) {
				$cx = $cr+1;
				$cy = 0;
				$dx = TAGWIDTH - $cr;
				$dy = 0;
				imagecopy($im, $mask, $dx, $dy, $cx, $cy, $cr, $cr);
			}
			// Bottom-left corner - esquina inferior izquierda
			if ($ce[2]) {
				$cx = 0;
				$cy = $cr+1;
				$dx = 0;
				$dy = TAGHEIGHT - $cr;
				imagecopy($im, $mask, $dx, $dy, $cx, $cy, $cr, $cr);
			}
			// Bottom-right corner - esquina inferior derecha
			if ($ce[3]) {
				$cx = $cr+1;
				$cy = $cr+1;
				$dx = TAGWIDTH - $cr;
				$dy = TAGHEIGHT - $cr;
				imagecopy($im, $mask, $dx, $dy, $cx, $cy, $cr, $cr);
			}
			imagedestroy($mask);
			/*
			//Transparencia en las esquinas (solo para png)
			imagealphablending($im,false);
			imagesavealpha($im, true);
			$transparent = imagecolorallocatealpha($im, 255, 0, 255, 127);
			for($i=0;$i<TAGWIDTH;$i++)for($j=0;$j<TAGHEIGHT;$j++){
				$rgb = imagecolorat($im, $i, $j);
				if($rgb==16711935) imagesetpixel($im,$i,$j,$transparent);
			}
			imagealphablending($im,true);
			/**/

			//Imagen de placa
			$imagen = RELPATH.'img/placaFondo.png';
				$img = imagecreatefromany($imagen);
				if($img){
				$is = getimagesize($imagen);
				imagecopy($im,$img,0,0,0,0,$is[0],$is[1]);
				imagedestroy($img);
			}

			//Imagen de usuario

			$imagen = relativePath(generateThumbPath($_path.$tag['photoOwner']));
			$img = imagecreatefromany($imagen);
			if($img){
				$is = getimagesize($imagen);
				$x=40;
				$y=215;
				imagefilledrectangle($im, $x-1, $y-1, $x+60, $y+60, $blanco);//marco
				imagecopyresampled($im,$img,$x,$y,0,0,60,60,$is[0],$is[1]);
				imagedestroy($img);
			}

			/*
			 * Textos de la tag.
			 * texto1 y texto2 por su tamaño se les define un ancho maximo y pueden tener multiples lineas
			 */
			$luz	= imagecolorhexallocatealpha($im, '#FFFFFF');
			$sombra	= imagecolorhexallocatealpha($im, '#000000');
			//Tipos de fuentes. 0=normal, 1=negrita

			//Informacion de redistribucion
			$imagen = RELPATH.'img/redistribuida.png';
			$img = imagecreatefromany($imagen);
			if($img && $tag['idOwner'] != $tag['idUser']){
				$fuente = $font[1];
				$texto = TIMELINE_REDISTRIBUTED.' '.$tag['nameUsr'];
				$is = getimagesize($imagen);
				$color = $blanco;
				$size = 11;
				$txt=imagettfbbox($size, 0, $fuente, $texto);
				$x = intval((TAGWIDTH - $txt[2])/2);
				$y = 42;
				$dx = 12; //distancia entre la imagen y el texto
				imagettftext($im, $size, 0, $x+1+($dx+$is[0]/2), $y+1, $negro, $fuente, $texto);
				imagettftext($im, $size, 0, $x-1+($dx+$is[0]/2), $y-1, $color, $fuente, $texto);
				imagecopy($im,$img,$x-($dx+$is[0]/2),$y-$is[1],0,0,$is[0],$is[1]);
				imagedestroy($img);
			}

			//texto1 - Parte superior
			$fuente= $font[1];
			$texto = strclean($tag['texto']);
			$color = imagecolorhexallocate($im, $tag['color_code']);
			$size = 15;
			$txt=imagettfbbox($size, 0, $fuente, $texto);
			$y = 73;
			$mw = 600;//max width - ancho maximo
			$tmp = explode(' ', $texto);
			$i = 0;
			do{
				$texto=$tmp[$i++];
				$txt=imagettfbbox($size, 0, $fuente, $texto);
				while(count($tmp)>$i&&$txt[2]<$mw){
					$txt=imagettfbbox($size, 0, $fuente, $texto.' '.$tmp[$i]);
					if($txt[2]<$mw) $texto.=' '.$tmp[$i++];
				}
				$txt=imagettfbbox($size, 0, $fuente, $texto);
				$x = intval((TAGWIDTH - $txt[2])/2);
				imagettftext($im, $size, 0, $x+1, $y+1, $sombra, $fuente, $texto);
				imagettftext($im, $size, 0, $x-1, $y-1, $luz, $fuente, $texto);
				imagettftext($im, $size, 0, $x  , $y  , $color, $fuente, $texto);
				$y+=23;
			}while(count($tmp)>$i);

			//texto principal - Centro
			$fuente = $font[0];
			$texto = strtoupper(strclean($tag['code_number']));
			$color = imagecolorhexallocate($im, $tag['color_code2']);
			$size = 75;
			$s = -2;//separacion entre letras
			$len = strlen($texto);
			$txt=imagettfbbox($size, 0, $fuente, $texto);
			$x = intval((TAGWIDTH - $txt[2])/2);
			$y = 182;
			for($i=0,$j=0,$xx=$x-($s*$len/2); $i<$len; $i++,$j=$i-1,$txt=imagettfbbox($size,0,$fuente,substr($texto,$j,1)),$xx+=$txt[2]+$s) imagettftext($im, $size, 0, $xx+1, $y+1, $sombra, $fuente, substr($texto,$i,1));
			for($i=0,$j=0,$xx=$x-($s*$len/2); $i<$len; $i++,$j=$i-1,$txt=imagettfbbox($size,0,$fuente,substr($texto,$j,1)),$xx+=$txt[2]+$s) imagettftext($im, $size, 0, $xx-1, $y-1, $luz   , $fuente, substr($texto,$i,1));
			for($i=0,$j=0,$xx=$x-($s*$len/2); $i<$len; $i++,$j=$i-1,$txt=imagettfbbox($size,0,$fuente,substr($texto,$j,1)),$xx+=$txt[2]+$s) imagettftext($im, $size, 0, $xx  , $y  , $color , $fuente, substr($texto,$i,1));

			//nombre usuario
			$fuente = $font[1];
			$texto = strclean($tag['nameOwner']);
			$color = $blanco;
			$sombra= $negro;
			$size = 15;
			$x = 115;
			$y = 223;
			imagettftext($im, $size, 0, $x+1, $y+1, $sombra, $fuente, $texto);
			imagettftext($im, $size, 0, $x  , $y  , $color, $fuente, $texto);
			//fecha
			$txt=imagettfbbox($size, 0, $fuente, $texto);
			$fuente = $font[0];
			$texto = date('d-M-Y H:i',$tag['date']);
			$size = 8;
			$x+= $txt[2]+10;
			imagettftext($im, $size, 0, $x+1, $y+1, $sombra, $fuente, $texto);
			imagettftext($im, $size, 0, $x  , $y  , $color, $fuente, $texto);

			//texto2 - parte baja
			$fuente = $font[1];
			$texto = strclean($tag['texto2']);
			$color = imagecolorhexallocate($im, $tag['color_code3']);
			$size = 10;
			$x = 115;
			$y = 241;
			$mw = 430;//max width - ancho maximo
			$tmp = explode(' ', $texto);
			$i = 0;
			do{
				$texto=$tmp[$i++];
				$txt=imagettfbbox($size, 0, $fuente, $texto);
				while(count($tmp)>$i&&$txt[2]<$mw){
					$txt=imagettfbbox($size, 0, $fuente, $texto.' '.$tmp[$i]);
					if($txt[2]<$mw) $texto.=' '.$tmp[$i++];
				}
				imagettftext($im, $size, 0, $x+1, $y+1, $sombra, $fuente, $texto);
				imagettftext($im, $size, 0, $x-1, $y-1, $luz, $fuente, $texto);
				imagettftext($im, $size, 0, $x  , $y  , $color, $fuente, $texto);
				$y+=15;
			}while(count($tmp)>$i);
		}

		//subir el archivo al servidor
		if(!isset($_GET['debug'])){//si estamos en debug no se guarda
			$phototmp=RELPATH.$path.'/'.md5(rand()).'.png';
			imagepng($im,$phototmp);
			if (redimensionar($phototmp, RELPATH.$photopath, 650)){
				@unlink($phototmp);
				uploadFTP($photo,'tags',RELPATH,1);
				if($msg) echo '<br/>guardada imagen '.$photo;
			}
		}
	}elseif($msg) echo '<br/>ya existe la imagen '.$photo;
	// FIN - creacion de la imagen de la tag
	//subimos la miniatura si no existe
	if(!fileExistsRemote($_path.$photompath)){
		if(!isset($_GET['debug'])){//si estamos en debug no se guarda
			$phototmp=RELPATH.$path.'/'.md5(rand()).'.png';
			imagepng($im,$phototmp);
			if (redimensionar($phototmp, RELPATH.$photompath, 200)){
				@unlink($phototmp);
				uploadFTP($photom,'tags',RELPATH,1);
				if($msg) echo '<br/>guardada miniatura '.$photom;
			}
		}
	}
	return $idTag;
}

function tagURL($tag,$mini=false){
	$idTag=intToMd5($tag);
	$idTag=substr($idTag,-16);
	return FILESERVER.'img/tags/'.$idTag.($mini?'.m':'').'.jpg';
}
function intToMd5($id){
	if(is_string($id)) $id=trim($id);
	if($id!=''&&!preg_match('/\D/',$id)) $id=md5($id);
	return $id;
}
//funciones para manejo de imagenes
function HexToRGB($hex) {
	$hex = str_replace('#', '', $hex);
	$color = array();
	if(strlen($hex) == 3) {
		$color['r'] = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
		$color['g'] = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
		$color['b'] = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
	}elseif(strlen($hex) == 6) {
		$color['r'] = hexdec(substr($hex, 0, 2));
		$color['g'] = hexdec(substr($hex, 2, 2));
		$color['b'] = hexdec(substr($hex, 4, 2));
	}
	return $color;
}
function imagecolorhexallocate(&$im,$hex){
	if($hex=='') $hex='#fff';
	$color = HexToRGB($hex);
	return imagecolorallocate($im, $color['r'], $color['g'], $color['b']);
}
function imagecolorhexallocatealpha(&$im,$hex,$alpha=50){
	$color = HexToRGB($hex);
	return imagecolorallocatealpha($im, $color['r'], $color['g'], $color['b'], $alpha);
}
function imagecreatefromany($imagen){
	if(!fileExistsRemote($imagen)){
		if(isset($_GET['debug'])) echo '<br/>No existe '.$imagen;
		return false;
	}
	$type = getimagesize($imagen);
	$type = $type[2];
	//$type: 1=gif, 2=jpg, 3=png
	if($type==1) return imagecreatefromgif ($imagen);
	if($type==2) return imagecreatefromjpeg($imagen);
	if($type==3) return imagecreatefrompng ($imagen);
	//Retorna falso si no es ninguno de los tipos identificados
	return false;
}

function fileExistsRemote($path){
    return (@fopen($path,'r')==true);
}

function getTagData($idTag=''){
	$idTag=is_numeric($idTag)?md5($idTag):$idTag;
	$where = $idTag==''?'':' WHERE substring(md5(t.id),17)="'.substr($idTag, -16).'"';
	if(strlen($idTag)==15) $where=' WHERE substring(md5(t.id),-15)="'.substr($idTag, -15).'"';
	$sql=getTagQuery().$where;
	$tag = $GLOBALS['cn']->query($sql);
	if( $idTag=='')
		return $tag;
	if( @mysql_num_rows($tag)>0 )
		return mysql_fetch_assoc($tag);
	return array('idTag'=>$idTag,'code_number'=>'notag','color_code2'=>'#333','photoOwner'=>'img/users/default.jpg','fondoTag'=>$tag[fondoTag]);
}


function getTagQuery($extra=''){ // t=tag, p=product, u=user(owner)
	return '
		SELECT
			t.id			as idTag,
			t.background	as fondoTag,
			t.id_creator	as idOwner,
			t.id_user		as idUser,
			if(p.id is null, u.screen_name, p.name) as nameOwner,
			(SELECT screen_name FROM users WHERE id=t.id_user) as nameUsr,
			if(p.id is null, if(u.profile_image_url="", "img/users/default.jpg", concat("img/users/",md5(CONCAT(u.id, "_", u.email, "_", u.id)),"/",u.profile_image_url)), concat("img/products/",p.picture)) as photoOwner,
			p.id			as idProduct,
			p.url			as urlProduct,
			t.text			as texto,
			t.text2			as texto2,
			t.date			as fechaTag,
			t.video_url		as video,
			t.color_code, t.color_code2, t.color_code3,
			t.points, t.code_number, t.profile_img_url, t.status,
			md5(CONCAT(u.id, "_", u.email, "_", u.id)) as code,
			unix_timestamp(t.date) AS date
			'.($extra==''||$extra==' '?'':','.$extra).'
		FROM tags t
		JOIN users u ON u.id=t.id_creator
		LEFT JOIN products_user p ON p.id=t.id_product
	';
}

function relativePath($url){
	return str_replace(DOMINIO, '../',str_replace('http://tagbum.com', '..', $url));
}

function generateThumbPath( $photo, $name=false ) {

	$imagesAllowed = array('jpg', 'jpeg', 'png', 'gif');

	for($i=0; $i<count($imagesAllowed); $i++) {

		if( strpos($photo, '.'.$imagesAllowed[$i]) !== false ) {
			$imagen=str_replace('.'.$imagesAllowed[$i], '_thumb.'.$imagesAllowed[$i], $photo);

			if( $name || !strpos(' '.$imagen,'/') || fileExistsRemote($imagen) ) {
				return $imagen;
			} elseif( strpos(' '.$photo,'/') && fileExistsRemote($photo) ) {
				return $photo;
			}
		}
	}
	return DOMINIO.'img/users/default.jpg';
}

function strclean($txt){
	$array=array(
		'&nbsp' => '&nbsp;',
		'&nbsp;;' => ' ',
		'&nbsp;' => ' ',
		'&amp;' => '&'
	);
	$txt= str_replace(array_keys($array), array_values($array), $txt);
	return $txt;
}


//funcion redimensionar de producción
function getRedime($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura='') {
	$type=Array(1 => 'gif', 2 => 'jpg', 3 => 'png');
	//_imprimir(getimagesize($img_original));
	list($imgWidth, $imgHeight, $tipo, $imgAttr) = getimagesize($img_original);
	$type = $type[$tipo];

	switch($type){
		case 'jpg' :
		case 'jpeg':  $img = imagecreatefromjpeg($img_original); break;
		case 'gif' :  $img = imagecreatefromgif($img_original); break;
		case 'png' :  $img = imagecreatefrompng($img_original); break;
	}

	//Obtengo el tamano del original
	$img_original_anchura = $imgWidth;
	$img_original_altura  = $imgHeight;
	// Obtengo la relacion de escala

	if($img_original_anchura > $img_nueva_anchura && $img_nueva_anchura > 0)
		$percent = (double)(($img_nueva_anchura * 100) / $img_original_anchura);

	if($img_original_anchura <= $img_nueva_anchura)
		$percent = 100;

	if(floor(($img_original_altura * $percent )/100)>$img_nueva_altura && $img_nueva_altura > 0)
		$percent = (double)(($img_nueva_altura * 100) / $img_original_altura);

	$img_nueva_anchura=($img_original_anchura*$percent)/100;

	$img_nueva_altura=($img_original_altura*$percent)/100;

	// crea imagen nueva redimencionada
	$thumb = imagecreatetruecolor ($img_nueva_anchura,$img_nueva_altura);

	if($type=='gif' || $type=='png'){
		/** Code to keep transparency of image **/
		$colorTransparancia=imagecolortransparent($img);// devuelve el color usado como transparencia o -1 si no tiene transparencias
		if($colorTransparancia!=-1)$colorTransparente = imagecolorsforindex($img, $colorTransparancia); //devuelve un array con las componentes de lso colores RGB + alpha
		$idColorTransparente = imagecolorallocatealpha($thumb, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'], $colorTransparente['alpha']); // Asigna un color en una imagen retorna identificador de color o FALSO o -1 apartir de la version 5.1.3
		imagefill($thumb, 0, 0, $idColorTransparente);// rellena de color desde una cordenada, en este caso todo rellenado del color que se definira como transparente
		imagecolortransparent($thumb, $idColorTransparente); //Ahora definimos que en la nueva imagen el color transparente sera el que hemos pintado el fondo.
	}

	// redimensionar imagen original copiandola en la imagen nueva
	imagecopyresampled ($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura, $imgWidth,$imgHeight);
	// guardar la imagen redimensionada donde indica $img_nueva
	switch($type){
		case 'jpg':
		case 'jpeg':
		case 'gif':  //imagegif($thumb,$img_nueva); break;
		case 'png':  imagejpeg($thumb,$img_nueva,90); //break;imagepng($thumb,$img_nueva); break;
	}

	imagedestroy($img);
	imagedestroy($thumb);

	return true;
}
//////////

function uploadFTP($file,$path,$parent='', $borrar=1, $code=''){
	// nombre de archivo y carpeta solamente,  parent es para cuando se trabaje desde un include

	//echo $path;
	$code=$path=='tags'?'':($code?$code:$_SESSION['ws-tags']['ws-user']['code']);
	if(!NOFPT){

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv ($id_ftp, false);

		ftp_chdir ($id_ftp, $path.'/');

		if($path!='tags'){
			@ftp_mkdir($id_ftp, $code);
			$code.='/';
			ftp_chdir ($id_ftp, $code);
		}
		@ftp_put($id_ftp, 'index.html', $parent.'img/index.html', FTP_BINARY);


		ftp_put($id_ftp, $file, $parent.'img/'.$path.'/'.$code.$file, FTP_BINARY);
		ftp_quit($id_ftp);

		if($borrar){
			@unlink($parent.'img/'.$path.'/'.$code.$file);
			//die();

		}
		//die();
	}
}

function copyFTP( $file, $pathftp, $pathftpimg, $path='', $rename='', $code='' ) {

	if(!NOFPT){

		if( !$code ) {
			$code = $_SESSION['ws-tags']['ws-user']['code'];
		}

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv  ($id_ftp, false);

        echo $path.'img/temporal/'.$file, $pathftp.'/'.$code.'/'.$file.'<br>';

		if( ftp_get($id_ftp, $path.'img/temporal/'.$file, $pathftp.'/'.$code.'/'.$file ,FTP_BINARY) ) {

			ftp_chdir ($id_ftp, $pathftpimg.'/');
			if($path!='tags'){
				@ftp_mkdir($id_ftp, $code);
				ftp_chdir ($id_ftp, $code.'/');
			}
			@ftp_put ($id_ftp, 'index.html', $path.'img/index.html', FTP_BINARY);


			if( ftp_put($id_ftp, ($rename ? $rename : $file), $path.'img/temporal/'.$file, FTP_BINARY) ) {
				unlink($path.'img/temporal/'.$file);
			} else {
				return false;
			}
		} else {
			return false;
		}
		return true;
	}
}

function deleteFTP($file,$path,$parent='',$code=''){
	
	$code = $code!=''?$code:$_SESSION['ws-tags']['ws-user']['code'];

	//echo $path;
	if(!NOFPT){

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv ($id_ftp, false);

		ftp_chdir ($id_ftp, $path.'/'.($path=='tags'?'':$code.'/'));

		@ftp_delete($id_ftp,$file);
		ftp_quit($id_ftp);


		//die();
	}else{

		@unlink($parent.'img/'.$path.'/'.($path=='tags'?'':$code.'/').$file);

	}
}

function renameFTP($fileOld,$fileNew,$path,$parent=''){
	// RE-ESCRIBE UN ARCHIVO

	//echo $path;
	if(!NOFPT){

		//$old_file = 'img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$fileOld;
		//$new_file = 'img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$fileNew;

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv ($id_ftp, false);

		ftp_chdir ($id_ftp, $path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/'));
		@ftp_rename($id_ftp, $fileOld, $fileNew);

		// cerrar la conexión ftp
		ftp_quit($id_ftp);

		//die();
	}else{
		$old_file = 'img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$fileOld;
		$new_file = 'img/'.$path.'/'.($path=='tags'?'':$_SESSION['ws-tags']['ws-user']['code'].'/').$fileNew;

		@rename($parent.$old_file,$parent.$new_file);

	}
}

function opendirFTP($path,$parent=''){
	// nombre carpeta solamente,  lista los archivos contenidos en la carpeta
	if(!NOFPT){

		$id_ftp = ftp_connect(FTPSERVER,21);
		ftp_login ($id_ftp, FTPACCOUNT, FTPPASS);
		ftp_pasv ($id_ftp, false);

		$salida = ftp_rawlist($id_ftp,$path);
		///////////////////// date extract

		$_cont=0;
		$rawlist=array();
		foreach ($salida as $v) {
			$vinfo = preg_split('/[\s]+/', $v, 9);
			if ($vinfo[0] !== 'total'&&$vinfo[8]!='.'&&$vinfo[8]!='..') {
				if ($rawlist[strtotime($vinfo[5] . ' ' . $vinfo[6] . ' ' . $vinfo[7])]!=''){
					$rawlist[strtotime($vinfo[5] . ' ' . $vinfo[6] . ' ' . $vinfo[7])+(++$_cont)] = $vinfo[8];
				}else{
					$rawlist[strtotime($vinfo[5] . ' ' . $vinfo[6] . ' ' . $vinfo[7])] = $vinfo[8];
				}
			}
		}
		@krsort($rawlist);//
		////////////////////
		ftp_quit($id_ftp);
		//die ("sdfsdfsdfsdfsdfsdf");
		//print_r($salida);
		return $rawlist;
	}else{

		return @opendir($parent.'img/'.$path);

	}
}

function readdirFTP(&$_array){

	if(!NOFPT){

		$salida = @current($_array);
		@next($_array);
		return $salida;

	}else{

		return @readdir($_array);

	}

}

function positionTour($id){
   $where = ($id!='')?'WHERE 1=1 | and position like "'.$id.'"':'';
   return "SELECT position AS valor, position AS descripcion FROM tour_position $where";
}
limpiaClassForm();
