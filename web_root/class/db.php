<?php 
	/**
	* Clase de conexion
	*/
	class db extends mysqli
	{

		private static $status = false;

		private $selectQuery ='';
		private $whereQuery  ='';
		private $joinQuery   ='';

		//CONstructores y destructores
		function __construct()
		{
			parent::__construct(DBHOST,DBUSER,DBPASS,DBNAME);

			if (!$this->connect_errno) {
				$this->status = true;
			}
		}

		//Metodos propios
		
		/**
		 * [formatea arreglo de condiciones mysql para consultas]	
		 * @param  [array or string] $fields [description]
		 * @return [string]        [ej: id=1 AND name='jonh doe']
		 */
		private function formatFieldsToWhere($fields, $condition = ''){
			$result = ' WHERE ';
			$condition = ($condition=='OR') ? $condition : 'AND';
			if( is_array($fields) ){
				for ($i=0; $i < count($fields); $i++) { 
					$result .= $key.'='."'$value' ";
					if ($i < count($fields)) $result .= $condition.' ';
				}
			}elseif( gettype($fields) == 'string' ){
				$result = $fields;
			}
			return $result;
		}

		/**
		 * [formatea arreglo de campos a seleccionar en una consulta]
		 * @param  [array or string] $fields [description]
		 * @return [string]         [ej: id, name, phone]
		 */
		private function formatFieldsToSelect($fields){
			$result = '';
			if( is_array($where) ){
				foreach ($fields as $value) {
					$result .= $value.',';  
				}

				$result = trim($result, ',');
			}elseif( gettype($where) == 'string' ){
				$result = $fields;
			}
			return $result;
		}


		//Metodos publicos
		public static function get($table, $limit = 0, $offset = 0){
			$result = false;
			if ($this->status) {
				$queryLimit = ($limit > 0) ? ' LIMIT '.$limit : '' ;
				$queryLimit = ($offset > 0 && $limit > 0) ? $queryLimit.','+$offset : '';
				$fields = ($this->selectQuery != '') ? $this->selectQuery  : '*' ;
				$where = ($this->whereQuery != '') ? $this->whereQuery  : ' ' ;
				$join = ($this->joinQuery != '') ? $this->joinQuery  : ' ' ;

				$query = 'SELECT '.$fields.' FROM '.$table.' '.$join.' '.$where.' '.$queryLimit;
				$result = $this->query($query);
			}
			return $result;	
		}

		public static function get_where($table, $where, $limit = 0, $offset = 0){
			$result = false;
			if ($this->status) {
				$queryLimit = ($limit > 0) ? ' LIMIT '.$limit : '' ;
				$queryAdd = ($offset > 0 && $limit > 0) ? $queryLimit.','+$offset : '';

				$where = $this->formatFieldsToWhere($where);

				$query = 'SELECT * FROM '.$table.$where.$queryAdd;
			}
			return $result;	
		}

		public static function select($fields){
			$this->selectQuery = $this->formatFieldsToSelect($fields);
		}

		public static function where($where){
			$this->whereQuery = $this->formatFieldsToSelect($where);
		}

		public static function or_where($where){
			$this->whereQuery = $this->formatFieldsToSelect($where, 'OR');
		}

		public static function like($field){
			if (is_array($field)) {
				foreach ($field as $key => $value) {
					$this->whereQuery = ' WHERE '.$key." '%".$value."%' ";
				}	
			}
		}

		public static function join($table){
			$this->joinQuery = 'JOIN '+$table;
		}

		public static function insert(){

		}
	}
?>