<?php
     include ("includes/config.php");
	 include ("includes/functions.php");
	 include ("class/class.directorio.php");
	 
	 
	 
	 $dir = new Directorio("/Applications/MAMP/htdocs/seemytag/"); 
	 //$dir = new Directorio("/home/seemytag/public_html/beta04/"); 
     
	 $files = $dir->Contenido(true);
	 
	 $type_file = "tmp";
	 
	 $option = 1; // 0 = listado, 1 = borrado
	 
	 if ($option==0){
	 
	     _imprimir($files);
		 
	 }elseif($option==1){
	     
		 $cont = 0;
		 
		 foreach ($files as $file){
			 
				  if (file_exists($file) && !is_dir($file)){
					  
					  $type = explode(".", $file);
					  
					  $ext = strtolower(end($type));
					  
					  if ($ext == $type_file){
					      
						  unlink($file);
						  $cont++;
					  }
					  
				  }//if es archivo
		 
		 }//foreach
		 
		 $s = ($cont>1) ? 's' : '';
		 
		 echo "Proceso culminado con exito, (".$cont.") archivo".$s." borrado".$s.".";
	 
	 }//opcion
	 
     
	 

?>