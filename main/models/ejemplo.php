<?php
/*
 * Modelo de ejemplo
 * -- Todas las clases:
 * el nombre del archivo debe estar en minusculas.
 * el nombre de la clase el mismo nombre con la primera letra en mayuscula.
 * -- Todos los modelos:
 * al nombre (solo la clase) se le debe agregar "_model"
 * debe extender a TAG_model o a otro modelo que la extienda previamente.
 * si utiliza constructor debe llamar al constructor del padre. Su parametro (opcional) hace referencia al control.
 */
class Ejemplo_model extends TAG_model{
	function __construct($control=false){
		parent::__construct($control);
		echo 'Model Example.<br>';
	}
	function __destruct(){
	}
}
