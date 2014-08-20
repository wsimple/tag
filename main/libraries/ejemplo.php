<?php
/*
 * Libreria de ejemplo
 * -- Todas las clases:
 * el nombre del archivo debe estar en minusculas.
 * el nombre de la clase el mismo nombre con la primera letra en mayuscula.
 * -- Todas las librerias:
 * al nombre (solo la clase) se le debe agregar "_lib"
 * debe extender a TAG_librarie o a otro modelo que la extienda previamente.
 * si utiliza constructor debe llamar al constructor del padre. Su parametro (opcional) hace referencia al control.
 */
class Ejemplo_lib extends TAG_librarie{
	function __construct($control=false){
		parent::__construct($control);
		echo 'Lib example.<br>';
	}
	function __destruct(){
	}
}
