<?php
	/*
	 * Archivo de idioma. El idioma por defecto
	 */
	unset($_lang);
	function lang($txt,$lan=''){
		global $_lang;
		$lan=$lan!=''?$lan:$_SESSION['ws-tags']['language'];
		if(isset($_lang[$lan][$txt]))
			$txt=$_lang[$lan][$txt];
		elseif(isset($_lang['en'][$txt]))
			$txt=$_lang['en'][$txt];
		return $txt;
	}
	$_lang['en']=array(
		'' => ''
	);
	$_lang['es']=array(
		'' => ''
	);
?>
