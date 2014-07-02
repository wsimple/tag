<?php
	//if(isset($_REQUEST['debug'])) die('<br/>entro a facebook.php<br/>');
	include('includes/config.php');
	include('includes/session.php');
	include('class/Mobile_Detect.php');
	include('includes/functions.php');
	include('class/wconecta.class.php');
	include('includes/languages.config.php');
	include('class/forms.class.php');
	$path='img/tags';
	$idTag=substr(intToMd5($_GET['tag']), 16);
	$photo=$idTag.'.jpg';
	$photom=$idTag.'.m.jpg';
	$photopath=$path.'/'.$photo;
	$photompath=$path.'/'.$photom;
	$tag = getTagData($idTag);
	$txt=array(
		strtoupper($tag['code_number']),
		$tag['texto'],
		$tag['texto2']
	);


	if(!isset($_GET['tag'])){
		$titleFace = TITLE;
		$opc = 0;
	}elseif($txt[0]!=''){
			$titleFace = $txt[0];
			$opc = 1;
		}elseif($txt[1]!=''){
				$titleFace = $txt[1];
				$opc = 2;
			}elseif($txt[2]!=''){
					$titleFace = $txt[2];
					$opc = 3;
				}else{
					$titleFace = TITLE;
					$opc = 0;
				}

	if($opc == 0){
		$descriptionFace = DESCRIPTION;
		$des = 0;
	}elseif($opc == 1){
			$des = 1;
			$descriptionFace = (($txt[2]!='')? $txt[2] : (($txt[1]!='')? $txt[1] : DESCRIPTION));
		}elseif($opc == 2){
				$des = 2;
				$descriptionFace = (($txt[2]!='')? $txt[2] : DESCRIPTION);
			}elseif($opc == 3){
					$des = 3;
					$descriptionFace = DESCRIPTION;
			}

?>
<!DOCTYPE>
<html>
<head>

	<meta property="og:title" content="<?=$titleFace?>" />
	<meta property="og:description" content="<?=$descriptionFace?>" />
	<?php if(!isset($_GET['tag'])){?>
	<meta property="og:image" content="<?=DOMINIO?>img/logo100.png" />
	<?php } elseif(($idTag!='')&&($tag['id']!='')) {?>
	<meta property="og:image" content="<?=FILESERVER.$photompath?>" />
	<?php } else{?>
	<meta property="og:image" content="<?=DOMINIO?>img/logo100.png" />
	<?php } ?>
	<meta property="og:updated_time" content="60" />
	<title><?=TITLE?></title>
	<link rel="shortcut icon" href="<?=DOMINIO?>img/favicon.ico" />
</head>
<body>
	Tagbum&trade; on Facebook
	<br/>
	Tag: <?=$_GET['tag']?>;
	<?php
//		_imprimir($_SERVER);
//		_imprimir($_REQUEST);
		echo '<br> title: '.$opc.'-'.$titleFace.'<br>';
		echo '<br> descripcion: '.$des.'-'.$descriptionFace;
	?>
</body>
</html>
<?php
	die();
?>
