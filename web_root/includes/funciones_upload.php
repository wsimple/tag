<?php

/* FUNTION uploadImage
 *
 * INPUT ->		$file		= the $_FILES[input] var
 *				$albumName	= the name of the album to which the photo belongs
 *				$folderName	= name of the folder containing the album
 *				$userCode	= the $_SESSION user code
 *				$userID		= the $_SESSION user id
 *
 * OUTPUT ->	if upload was ok then return the image name otherwise will return 'IMAGE_NOT_ALLOWED'
 */
function uploadImage($file,$albumName,$folderName,$userCode,$userID){
	$imagesAllowed=array('jpg','jpeg','png','gif');
	$fail='IMAGE_NOT_ALLOWED';
	$ext=strtolower(end(explode('.',$file['name'])));
	#se cancela si no es un formato permitido
	if(!in_array($ext,$imagesAllowed))
		return $fail;
	#creamos un md5 que identificara el nombre de archivos
	$tmp=md5(date('YmdHis').rand());
	$name="$tmp.$ext";
	$path="$folderName/$userCode/";
	$fullpath=RELPATH.'img/'.$path;
	$image=$path.$name;
	#crea la carpeta si no existe
	if(!is_dir($fullpath)){
		$old=umask(0);
		mkdir($fullpath,0777);
		umask($old);
		$fp=fopen($fullpath.'index.html','w');
		fclose($fp);
	}
	#se cancela si no se pudo guardar la imagen
	if(!redimensionar($file['tmp_name'],$fullpath.$name,600)||!file_exists($fullpath.$name))
		return $fail;
	FTPupload($image);
	$album=current($GLOBALS['cn']->queryRow("SELECT id FROM album WHERE id_user='$userID' AND name='$albumName'"));
	if($album==''){
		$GLOBALS['cn']->query("INSERT INTO album SET name='$albumName', id_user='$userID'");
		$album=mysql_insert_id();
	}
	$GLOBALS['cn']->query("
		INSERT INTO images SET
			id_user			='$userID',
			id_album		='$album',
			image_path		='$userCode/$name',
			id_images_type	=2
	");
	$GLOBALS['cn']->query('
		UPDATE album SET
			id_image_cover='.mysql_insert_id().'
		WHERE id_user='.$userID.' AND name="'.$albumName.'"');
	return $name;
}


/* FUNTION getTableRow
 *
 * INPUT ->		$selectFields	= 'field1, field2, field3...'
 *				$tableName		= 'table'
 *				$whereCondition	= 'condition1 AND condition2 OR condition3 ...'
 *
 * OUTPUT ->	if selecting one field, then return the field, otherwise it will return the entire row
 *				if query has no results will return 'No-results'
 */
function getTableRow($selectFields, $tableName, $whereCondition) {

	$query = $GLOBALS['cn']->query('SELECT '.$selectFields.' FROM '.$tableName.' WHERE '.$whereCondition);

	if( mysql_num_rows($query)>0 ) {

		$query = mysql_fetch_array($query);
		return (strpos(',',$selectFields)<0 ? $query : $query[$selectFields]);
	}

	return 'No-results';
}
?>