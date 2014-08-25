<?php
# Libreria de vistas de errores
class Error_views_lib extends TAG_librarie{
	function msg($code=false){
		$html="Error $code";
		switch($code){
			case 404: $html.=': Page not found.';
		}
		return $html;
	}
}
