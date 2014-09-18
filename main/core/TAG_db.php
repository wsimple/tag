<?php
class TAG_db{
	private $dbcon,$lastQuery='',$sql,$error,$errorMsg,
		$echo=true,
		$dbdata;
	public function __construct($data=false){
		$this->con($data);
	}
	public function __destruct(){
		$this->close();
	}
	public function close(){
		if($this->dbcon) @$this->dbcon->close();
		$this->dbcon=false;
	}
	public function con($data=false){
		if(!$data&&$this->dbcon) return $this->dbcon;
		if($data&&$this->dbcon) $this->close();
		if(!$data&&!$this->dbcon){
			global $config;
			if($config) $data=$config->db;
		}
		if(!$data){
			echo 'No se han suministrado datos para realizar la coneccion. ';
			return false;
		}
		$con=new mysqli($data->host,$data->user,$data->pass,$data->data);
		if($con->connect_error)
			echo 'Error #'.$con->connect_errno.' en conexion ('.$_SERVER['PHP_SELF'].'): '.$con->connect_error;
		if(!$con->set_charset("utf8"))
			printf("Error cargando el conjunto de caracteres utf8: %s\n",$con->error);
		return $this->dbcon=$con;
	}
	public function escape_string($sql,$params=false){
		#crea una cadena sql segura
		if($params){
			$params=$this->cleanStrings($params);
			# str_replace - cambiando ?? -> %s y ? -> "%s". %s is ugly in raw sql sql
			# ?? for expressions manually scaped like that: LIKE '%??%'
			$sql=preg_replace('/([^%])%([^%])/','$1%%$2',$sql);
			$sql=str_replace('??','%s',$sql);
			$sql=str_replace('?','"%s"',$sql);

			# vsprintf - replacing all %s to parameters
			$sql=vsprintf($sql,$params);
			$sql=str_replace('"%s"','?',$sql);
			$sql=str_replace('%s','??',$sql);
		}
		return $sql;
	}
	public function showErrors($val=true){
		$this->echo=$val;
	}
	public function query($sql=false,$a=false){
		if(!$sql) return $this->lastQuery;
		$sql=$this->escape_string($sql,$a);
		$this->sql=$sql;
		if($query=new TAG_dbquery($this->dbcon,$sql)){
			$this->error=false;
			$this->errorMsg='';
		}else{
			$this->error=true;
			$this->errorMsg='Error en query ('.$_SERVER['PHP_SELF'].'): '.$this->dbcon->error.'<br>'.$sql;
			if($this->echo) echo $this->errorMsg;
		}
		$this->lastQuery=$query;
		return $query;
	}
	public function error(){
		return $this->error;
	}
	public function errorMsg(){
		return $this->errorMsg;
	}
	public function lastSql(){
		return preg_replace('/\s+/',' ',$this->sql);
	}
	public function numRows($query){#cantidad de columnas en la consulta
		return $query->num_rows;
	}
	public function fetchAssoc($query=false){#devuelve la siguiente columna de la consulta
		if(!$query) $query=$this->lastQuery;
		$data=@$query->fetch_assoc();
		return $data;
	}
	public function fetchArray($query=false){#devuelve la siguiente columna como un arreglo simple
		if(!$query) $query=$this->lastQuery;
		$data=@$query->fetch_array();
		return $data;
	}
	public function fetchObject($query=false){#devuelve la siguiente columna como un objeto
		if(!$query) $query=$this->lastQuery;
		$data=@$query->fetch_object();
		return $data;
	}
	public function getArray($sql,$a=false){#devuelve arreglo con todas las columnas (arreglo simple)
		$array=array();
		$query=$this->query($sql,$a);
		if($query->num_rows>0)
			while($row=$query->fetch_array($query)) $array[]=$row;
		return $array;
	}
	public function getAssoc($sql,$a=false){#devuelve arreglo con todas las columnas (arreglo asociativo)
		$array=array();
		$query=$this->query($sql,$a);
		if($this->numRows($query)>0)
			while($row=$this->fetchAssoc($query)) $array[]=$row;
		return $array;
	}
	public function getObject($sql,$a=false){#devuelve arreglo con todas las columnas (objetos)
		$array=array();
		$query=$this->query($sql,$a);
		if($this->numRows($query)>0)
			while($row=$this->fetchObject($query)) $array[]=$row;
		return $array;
	}
	public function getRow($sql,$a=false){#devuelve la primera columna de una consulta
		if(!preg_match('/\blimit\s+\d+\s*;?\s*$/i',$sql)){
			$echo=$this->echo;
			$this->echo=false;
			$query=$this->query($sql.' LIMIT 1',$a);
			$this->echo=$echo;
		}
		if(!$query) $query=$this->query($sql,$a);
		if($this->numRows($query)>0) $row=$this->fetchAssoc($query);
		else $row=array();
		return $row;
	}
	public function getRowObject($sql,$a=false){#devuelve la primera columna de una consulta
		if(!preg_match('/\blimit\s+\d+\s*;?\s*$/i',$sql)){
			$echo=$this->echo;
			$this->echo=false;
			$query=$this->query($sql.' LIMIT 1',$a);
			$this->echo=$echo;
		}
		if(!$query) $query=$this->query($sql,$a);
		if($query->num_rows) $row=$query->fetch_object();
		else $row=new stdClass();
		return $row;
	}
	public function getVal($sql,$a=false){#devuelve el valor del primer elemento de una consulta
		$el=NULL;
		$query=$this->query($sql,$a);
		if($query->num_rows){
			$el=$query->fetch_array();
			$el=array_shift($el);
		}
		return $el;
	}
	public function count($tabla,$where='1',$a=false){#cuenta elementos de una consulta
		$query=$this->query("SELECT * FROM $tabla WHERE $where",$a);
		return $query->num_rows;
	}
	public function sum($campo,$tabla,$where='1',$a=false){
		return $this->getVal("SELECT SUM($campo) FROM $tabla WHERE $where",$a);
	}
	public function exist($tabla,$where='1',$a=false){
		$query=$this->query("SELECT * FROM $tabla WHERE $where",$a);
		return $query->num_rows>0;
	}
	public function insert($tabla,$set,$a=false){
		$query=$this->query("INSERT INTO $tabla SET $set",$a);
		return $query?$query->insert_id:false;
	}
	public function insert_or_update($tabla,$set,$set_if_insert,$where_if_update,$a=false){
		list($tabla,$set,$set_if_insert,$where_if_update)=explode(' {[(,)]} ',
			$this->escape_string(implode(' {[(,)]} ',
				array($tabla,$set,$set_if_insert,$where_if_update)
			),$a)
		);
		if($this->exist($tabla,$where_if_update))
			return $this->update($tabla,$set,$where_if_update);
		else
			return $this->insert($tabla,"$set,$set_if_insert");
	}
	public function update($tabla,$set,$where,$a=false){
		return !!$this->query("UPDATE $tabla SET $set WHERE $where",$a);
	}
	public function delete($tabla,$where,$a=false){
		return !!$this->query("DELETE FROM $tabla WHERE $where",$a);
	}
	public function cleanStrings($a){#formatea cadenas para uso en sql.
		$con=$this->con();
		if(get_magic_quotes_gpc()) return $a;
		elseif(is_string($a)) return $con->real_escape_string($a);
		elseif(!is_array($a)) return $a;
		foreach($a as $key => &$value){
			if(is_array($value))
				$value=$this->cleanStrings($value);
			elseif(is_string($value))
				$value=$con->real_escape_string($value);
		}
		return $a;
	}
}

class TAG_dbquery{
	var $query,$num_rows=0,$insert_id=false;
	function __construct($con=false,$sql=''){
		if($con&&$sql){
			$query=$con->query($sql);
			$this->query=$query;
			$copy=array('num_rows');
			foreach($copy as $name) if(isset($query->$name)) $this->$name=$query->$name;
			if(preg_match('/^\s*insert\s/i',$sql)) $this->insert_id=$query->insert_id;
		}
	}
	function fetch_assoc(){#devuelve la siguiente columna de la consulta como un arreglo asociativo
		if(!$this->query) return false;
		return $this->query->fetch_assoc();
	}
	public function fetch_array($type=MYSQLI_NUM){#devuelve la siguiente columna como un arreglo simple
		if(!$this->query) return false;
		return $this->query->fetch_array($type);
	}
	public function fetch_object(){#devuelve la siguiente columna como un objeto
		if(!$this->query) return false;
		return $this->query->fetch_object();
	}
}
