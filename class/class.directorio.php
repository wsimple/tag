<?php

/**

 * Directorio

 *

 * @package Abstraccion++

 * @author  Rolando Santamaria Maso

 * @link  http://mapucl.blogspot.com/2009/01/hola.html

 *

 * @package Abstraccion++

 * @subpackage Clases

 * @version 0.1

 */

 //pagina de ejemplo http://www.phpclasses.org/browse/file/25930.html

class Directorio{

	/**

	 * Almacena el gestor de directorio

	 *

	 * @var resource

	 */

	private $conexion;



	/**

	 * Almacena el contenido del diretorio

	 *

	 * @var array

	 */

	private $contenido;



	/**

	 * Url del directorio

	 *

	 * @var string

	 */

	private $ruta_directorio;





					/*******************************

					 *  METODOS PRIVADOS

					 *******************************/

					/**

					 * Actualizar el contenido del directorio

					 *

					 * @exception Exception

					 * @return void

					 */

					private function actualizar(){

						//COMPROBAR OTRA VEZ POR SI SE HA BORRADO EL DIRECTORIO

						if (!is_dir($this->ruta_directorio))

							throw new Exception('El directorio no existe o se ha eliminado');



						$temp_contenido = scandir($this->ruta_directorio);

						if (count($temp_contenido) > 2){

							unset($temp_contenido[0]);

							unset($temp_contenido[1]);

							$temp_contenido 	= array_merge(array(), $temp_contenido);

							$this->contenido 	= $temp_contenido;

						}

					}



					/**

					 * Contar la cantidad de elementos dentro del directorio

					 *

					 * @param string $ruta_directorio

					 * @return mixed

					 */

					private function contar_e($ruta_directorio){

						$cant_dir = 0;

						$cant_arc = 0;

						$tamanno  = 0;



						@$temp_contenido = scandir($ruta_directorio);

						if (count($temp_contenido) > 2){

							unset($temp_contenido[0]);

							unset($temp_contenido[1]);



							$temp_contenido 	= array_merge(array(), $temp_contenido);



							foreach ($temp_contenido as $elemento)

								if (is_dir($this->ruta_directorio.$elemento))

									$cant_dir++;

								else {

									$cant_arc++;

									$tamanno += filesize($this->ruta_directorio.$elemento);

								}

							return array('subdirectorios'=>$cant_dir, 'archivos'=>$cant_arc, 'tamanno'=>$tamanno);

						}

						return false;

					}



					/**

					 * Realizar un conteo recursivo de elementos dentro del directorio

					 *

					 * @param string $ruta_directorio

					 * @param array $resultado

					 * @return array

					 */

					private function contar_er($ruta_directorio, &$resultado = null){

						$cant_dir = 0;

						$cant_arc = 0;

						$tamanno  = 0;



						@$temp_contenido = scandir($ruta_directorio);

						if ($temp_contenido){

							unset($temp_contenido[0]);

							unset($temp_contenido[1]);



							foreach ($temp_contenido as $elemento)

								if (is_dir($ruta_directorio.'/'.$elemento)){

									$this->contar_er($ruta_directorio.'/'.$elemento, $resultado);

									$cant_dir++;

								}else {

									$cant_arc++;

									$tamanno += filesize($ruta_directorio.'/'.$elemento);

								}



							$resultado['subdirectorios'	] += $cant_dir;

							$resultado['archivos'		] += $cant_arc;

							$resultado['tamanno'		] += $tamanno;



						}

						return $resultado;

					}



					/**

					 * Realizar un conteo recursivo de elementos dentro del directorio

					 *

					 * @param string $ruta_directorio

					 * @param array $resultado

					 * @return array

					 */

					private function contenido_r($ruta_directorio, &$resultado = null){

						@$temp_contenido = scandir($ruta_directorio);

						if ($temp_contenido){

							unset($temp_contenido[0]);

							unset($temp_contenido[1]);



							foreach ($temp_contenido as $elemento){

								$str = str_replace($this->ruta_directorio, '', $ruta_directorio);

								$resultado[] = (($str)?substr($str, 1).'/':'').$elemento;



								if (is_dir($ruta_directorio.'/'.$elemento))

									$this->contenido_r($ruta_directorio.'/'.$elemento, $resultado);

							}

						}

						return $resultado;

					}



					/**

					 * Elimina un archivo o directorio

					 *

					 * @param string $url

					 * @return boolean

					 */

					private function eliminar_elemento($url){

						if (is_dir($url)){

							if ($url == $this->ruta_directorio){

								closedir($this->conexion);

								@rmdir($url);

								$this->__destruct();

							}

							if (@rmdir($url))

								return true;

						}elseif (is_file($url)){

							if (@unlink($url))

								return true;

						}

						return false;

					}



					/**

					 * Eliminar un elemento de un directorio con todos sus subelementos

					 *

					 * @param string $url

					 */

					private function eliminar_r($url){

						@$temp_contenido = scandir($url);

							unset($temp_contenido[0]);

							unset($temp_contenido[1]);

						if ($temp_contenido){

							foreach ($temp_contenido as $elemento){

								if (is_dir($url.'/'.$elemento))

									$this->eliminar_r($url.'/'.$elemento);

								else

									@unlink($url.'/'.$elemento);

							}

						}

						return $this->eliminar_elemento($url);

					}



					/**

					 * Copiar archivos o directorios a una ruta especificada

					 *

					 * @param string $url

					 */

					private function copiar_r($url, $directorio_destino, &$matriz_errores){

						@$temp_contenido = scandir($url);

							unset($temp_contenido[0]);

							unset($temp_contenido[1]);



							if ($temp_contenido)

							foreach ($temp_contenido as $elemento)

								if (is_dir($url.'/'.$elemento)){

									if (@!mkdir($directorio_destino.'/'.$elemento)){

										$matriz_errores[] = $url.'/'.$elemento;

									}else

									$this->copiar_r($url.'/'.$elemento, $directorio_destino.'/'.$elemento, $matriz_errores);

								}else {

									if (!copy($url.'/'.$elemento, $directorio_destino.'/'.$elemento))

										$matriz_errores[] = $url.'/'.$elemento;

								}



						return;

					}





	/**

	 * Abrir un gestor de directorio

	 *

	 * @exception Exception

	 * @param string $ruta_directorio

	 * @return void

	 */

	public function __construct($ruta_directorio){

		if (!is_string($ruta_directorio))

			throw new Exception('El parametro $ruta_directorio debe ser de tipo string');

		else {

			if (!($ruta_directorio[strlen($ruta_directorio)-1] === '/') || !($ruta_directorio[strlen($ruta_directorio)-1] === '\\'))

				$ruta_directorio .= '/';

		}

		if (!is_dir($ruta_directorio))

			throw new Exception('El directorio no existe');



		if (@$temp_con = opendir($ruta_directorio)){

			$this->conexion 		= $temp_con;

			$this->ruta_directorio 	= $ruta_directorio;

			$this->contenido		= array();

			$this->actualizar();

		}

		else

			throw new Exception('No se pudo realizar la operacion');

	}



	/**

	 * Destructor de la Clase

	 *

	 * Cierra el gestor de directorio si este se encontraba abierto.

	 */

	public function __destruct(){

		if (is_resource($this->conexion))

			closedir($this->conexion);

	}



	/**

	 * Devuelve la cantidad de elementos contenidos dentro del directorio

	 *

	 * Claves de la matriz:

	 * subdirectorios 	- Cantidad de Directorios dentro del directorio

	 * archivos		- Cantidad de Archivos dentro del directorio

	 *

	 * @exception Exception

	 * @return array

	 */

	public function contarElementos($recursivo = true){

		if (!is_dir($this->ruta_directorio))

			throw new Exception('El directorio no existe o ha sido eliminado');



		if (!$recursivo)

			return $this->contar_e($this->ruta_directorio);

		else

			return $this->contar_er($this->ruta_directorio);

	}



	/**

	 * Devuelve un array con el contenido del directorio

	 *

	 * Si el parametro $recursivo es TRUE entonces se devuelve todo el contenido del directorio incluyendo los subdirectorios y sus archivos.

	 *

	 * @param boolean $recursivo

	 * @return array

	 */

	public function Contenido($recursivo = false){

		if (!$recursivo){

			$this->actualizar();

			return $this->contenido;

		}

		return $this->contenido_r($this->ruta_directorio);

	}



	/**

	 * Copiar elementos del directorio a una ruta especificada

	 *

	 * Se puede copiar todo el directorio dejando el parametro $elemento en valor NULL; si el parametro $elemento es de tipo integer,

	 * entonces se toma el elemento que corresponde con esa posicion en la matriz [Contenido] y por ultimo si el parametro

	 * es de tipo string, entonces el valor es concatenado a la url del directorio.

	 *

	 * Nota: La funcion devuelve TRUE si todo se ha realizado correctamente, en caso contrario

	 * devuelve una matriz escalar con el nombre de los elementos que no pudieron copiarse.

	 *

	 * @exception Exception

	 * @param mixed $elemento

	 * @param stirng $directorio_destino

	 * @return mixed

	 */

	public function copiar($elemento = null, $directorio_destino){

		$this->actualizar();

		$url = $this->ruta_directorio;



		//PARSEANDO

		if (is_integer($elemento)){

			if (isset($this->contenido[$elemento])){

				$url .= $this->contenido[$elemento];

				$directorio_principal = $this->contenido[$elemento];

			}else

				throw new Exception('El valor $elemento se encuentra fuera de rango');

		}elseif (is_string($elemento)){

			$url .= $elemento;

			$directorio_principal = $elemento;

			if (!file_exists($url))

				throw new Exception('El archivo no existe o ha sido eliminado');

		}elseif (!is_null($elemento))

			throw new Exception('El valor del parametro $elemento esta en formato incorrecto');

		elseif (!is_dir($directorio_destino))

		 	throw new Exception('El parametro $directorio_destino no es correcto');



		//VERIFICANDO SI ES ESCRIBIBLE EL DIRECTORIO

		if (!is_writable($directorio_destino))

			throw new Exception('El directorio destino no es escribible');



		//CREANDO EL DIRECTORIO CON EL NOMBRE DEL ELEMENTO

		if (is_dir($url))

		if (!file_exists($directorio_destino.'/'.$directorio_principal))

			@mkdir($directorio_destino.'/'.$directorio_principal);



		$matriz_errores = array();	//CONTIENE LOS ELEMENTOS QUE NO SE PUDIERON COPIAR

		$this->copiar_r($url, $directorio_destino.'/'.$directorio_principal, $matriz_errores);



		if (empty($matriz_errores))

			return true;

		return $matriz_errores;

	}



	/**

	 * Crear un directorio

	 *

	 * El nuevo directorio dentro del directorio al que apunta el objeto.

	 *

	 * @exception Exception

	 * @param string $nombre_directorio

	 * @param integer $modo

	 * @return void

	 */

	public function crearDir($nombre_directorio, $modo = null){

		if (!is_string($nombre_directorio))

			throw new Exception('Formato incorrecto');

		if (!is_integer($modo) && !is_null($modo))

			throw new Exception('Formato incorrecto');

		if (!is_writable($this->ruta_directorio))

			throw new Exception('El directorio no es escribible');

		if (!@mkdir($this->ruta_directorio.$nombre_directorio, $modo))

			throw new Exception('No se pudo crear el directorio');

	}



	/**

	 * Eliminar uno o varios elementos dentro del directorio

	 *

	 * Si el elemento es un directorio entonces se eliminan todos los elementos que este contenga

	 * Se puede eliminar todo el directorio dejando el parametro $elemento en valor NULL, de este modo

	 * se destruye incluso el objeto; si el parametro $elemento es de tipo integer, entonces se toma

	 * el elemento que corresponde con esa posicion en la matriz [Contenido] y por ultimo si el parametro

	 * es de tipo string, entonces el valor es concatenado a la url del directorio.

	 *

	 * Nota: Se debe comprobar el resultado de la function con el operador de igualdad === , ya que

	 * de lo contrario puede cometerse un error.

	 *

	 * @exception Exception

	 *

	 * @param mixed $elemento

	 * @return mixed

	 */

	public function eliminar($elemento = null){

		$this->actualizar();

		$url = $this->ruta_directorio;

		if (is_integer($elemento)){

			if (isset($this->contenido[$elemento]))

				$url .= $this->contenido[$elemento];

			else

				throw new Exception('El valor $elemento se encuentra fuera de rango');

		}elseif (is_string($elemento)){

			$url .= $elemento;

			if (!file_exists($url))

				throw new Exception("No existe el archivo o directorio");

		}elseif (!is_null($elemento))

			throw new Exception('Formato Incorrecto');



		//ELIMINANDO LOS ELEMENTOS

		$this->eliminar_r($url);



		//COMPROBANDO EL RESULTADO

		if ($this->contar_er($url)){

			return $resultado;

		}

		return true;

	}



	/**

	 * Obtener informacion sobre un elemento del directorio

	 *

	 * Si $elemento es NULL entonces se devuelve la informacion del directorio al que apunta el objeto.

	 * Si el parametro $elemento es de tipo integer, entonces se toma el elemento que corresponde con

	 * esa posicion en la matriz [Contenido] y por ultimo si el parametro es de tipo string,

	 * entonces el valor es concatenado a la url del directorio.

	 *

	 * @exception Exception

	 * @param mixed $elemento

	 * @return array

	 */

	public function obtenerInformacion($elemento = null){

		$this->actualizar();

		$url = $this->ruta_directorio;

		if (is_integer($elemento)){

			if (isset($this->contenido[$elemento]))

				$url .= $this->contenido[$elemento];

			else

			throw new Exception('El valor $elemento se encuentra fuera de rango');

		}elseif (is_string($elemento)){

			$url .= $elemento;

			if (!file_exists($url))

				throw new Exception('No existe el archivo o directorio');

		}elseif (!is_null($elemento))

			throw new Exception('Formato Incorrecto');



		//REUNIENDO INFORMACION

		if (is_dir($url)){

			$datos 		= stat($url);

			$elementos 	= $this->contar_er($url);



			$informe['tipo'				] = 'directorio';

			$informe['ubicacion'		] = $url;

			$informe['tamanno'			] = $elementos['tamanno'];

			$informe['elementos'		] = $elementos;

			$informe['modificado'		] = $datos['mtime'];

			$informe['permisos'			] = fileperms($url);

			$informe['id_propietario'	] = fileowner($url);



		}elseif(is_file($url)){



			$informe['tipo'				] = 'archivo';

			$informe['ubicacion'		] = $url;

			$informe['tamanno'			] = filesize($url);

			$informe['acceso'			] = fileatime($url);

			$informe['modificado'		] = filemtime($url);

			$informe['permisos'			] = fileperms($url);

			$informe['id_propietario'	] = fileowner($url);



		}elseif (is_link($url)){

			$datos 	= lstat($url);



			$informe['tipo'				] = 'enlace';

			$informe['ubicacion'		] = $url;

			$informe['tamanno'			] = $datos['size'];

			$informe['acceso'			] = $datos['atime'];

			$informe['modificado'		] = $datos['mtime'];

			$informe['permisos'			] = fileperms($url);

			$informe['id_propietario'	] = $datos['uid'];

		}else

			throw new Exception('Parametro incorrecto');



		return $informe;

	}



	/**

	 * Eliminar todos los elementos contenidos dentro del directorio

	 *

	 * La function devuelve TRUE si todo ha resultado correctamente, de lo contrario devuelve una

	 * matriz informando la cantidad de elementos que no pudieron eliminarse.

	 *

	 * @return mixed

	 */

	public function vaciar(){

		$contenido = $this->Contenido();

		foreach ($contenido as $elemento)

			$this->eliminar_r($this->ruta_directorio.$elemento);



		//COMPROBANDO EL RESULTADO

		if ($this->contar_er($url)){

			return $resultado;

		}

		return true;

	}



	/**

	 * Renombrar un archivo o directorio

	 *

	 * Si $elemento es NULL entonces se renombra el directorio al que apunta el objeto.

	 * Si el parametro $elemento es de tipo integer, entonces se toma el elemento que corresponde con

	 * esa posicion en la matriz [Contenido] y por ultimo si el parametro es de tipo string,

	 * entonces el valor es concatenado a la url del directorio.

	 *

	 * @exception Exception

	 * @param mixed $elemento

	 * @param string $nuevo_nombre

	 * @return void

	 */

	public function renombrar($elemento = null, $nuevo_nombre){

		$this->actualizar();

		$url = $this->ruta_directorio;

		if (is_integer($elemento)){

			if (isset($this->contenido[$elemento]))

				$url .= $this->contenido[$elemento];

			else

				throw new Exception('El valor del parametro $lemento se encuentra fuera de rango');

		}elseif (is_string($elemento)){

			$url .= $elemento;

			if (!file_exists($url))

				throw new Exception('No existe el archivo o directorio');

		}elseif (!is_null($elemento) || !is_string($nuevo_nombre))

			throw new Exception('Parametros en formato incorrecto');

		if (!is_writable($url))

			throw new Exception('Acceso denegado al archivo o directorio');



		if (is_null($elemento)){

			closedir($this->conexion);

			if(!rename($url, $nuevo_nombre))

				throw new Exception("No se pudo realizar la operacion");

			$this->conexion 		= opendir($nuevo_nombre);

			$this->ruta_directorio 	= $nuevo_nombre;

		}

		elseif(!rename($url, $this->ruta_directorio.$nuevo_nombre))

			throw new Exception("No se pudo realizar la operacion");

	}





		/******************************************************

		 * METODOS MAGICOS

		 *

		 * ****************************************************

		 */



		/**

		 * Devuelve la ruta del directorio apuntado cuando el objeto es imprimido en pantalla

		 *

		 * @return string

		 */

		public function __toString(){

			return $this->ruta_directorio;

		}

}



?>