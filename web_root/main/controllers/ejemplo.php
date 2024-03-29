<?php
/*
 * Control de ejemplo
 * -- Todas las clases:
 * El nombre del archivo debe estar en minusculas.
 * El nombre de la clase el mismo nombre con la primera letra en mayuscula.
 * -- Todos los controles:
 * Debe extender a TAG_controler o a otro control que la extienda previamente.
 * El control cargara automaticamente el modelo que posea el mismo nombre.
 * Si utiliza constructor recuerde llamar al constructor del padre.
 * Para evitar errores, puede usar opcionalmente la funcion __onload().
 *
 * El constructor y onload recibiran todos los parametros de la url.
 *
 * Si la url no contiene valores adicionales, se llama index().
 * Si contiene valores extras, el primero indica el metodo y los demas son parametros.
 * Alternativamente, si decea desactivar los metodos y llamar siempre al index,
 * utilice la funcion disable_methods() en el constructor o en el __onload().
 */
class Ejemplo extends TAG_controller{
	function __construct(){
		#validacion: si no esta en modo debug, se retorna error 404
		if(!$this->is_debug()) $this->error_view(404);
		parent::__construct();
	}
	function __onload($params){
		$this->set_echo('Example control.<br>');
		#si el primer parametro es numerico, desactivamos los metodos para que vaya a index
		if(is_numeric($params[0])) $this->disable_methods();
		$this->load->library('ejemplo');
		$this->set_echo('<br>Location data:');
		$this->dump($this->location);
	}
	function index($first=false){
		$this->load->view('partial/header');
		$this->flush_echo();
		echo('Control Index<br>');
		if($first) echo("First=$first<br>");
		$this->load->view('partial/footer');
	}
	function metodo($a=''){
		$this->load->view('partial/header');
		$this->flush_echo();
		echo 'Control Method.<br>Param 1='.$a;
		$this->load->view('partial/footer');
	}
}
