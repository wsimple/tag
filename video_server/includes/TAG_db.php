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
		if($data&&$this->dbcon) $this->close();
		if(!$data){
			global $config;
			if($config) $data=$config->db;
		}
		if(!$data){
			echo 'No se han suministrado datos para realizar la coneccion. ';
			return false;
		}
		$this->dbcon=mysqli_connect($data->host,$data->user,$data->pass,$data->data);
		if(mysqli_connect_errno())
			echo 'Error en conexion ('.$_SERVER['PHP_SELF'].'): '.mysqli_connect_error();
		return $this->dbcon;
	}
	public function escape_string($query,$params=false){
		#crea una cadena sql segura
		if($params){
			$params=$this->cleanStrings($params);
			# str_replace - cambiando ?? -> %s y ? -> "%s". %s is ugly in raw sql query
			# ?? for expressions manually scaped like that: LIKE '%??%'
			$query=preg_replace('/%([\s\?\'"])/','%%$1',$query);
			$query=str_replace('??','%s',$query);
			$query=str_replace('?','"%s"',$query);
			# vsprintf - replacing all %s to parameters
			$query=vsprintf($query,$params);
			$query=str_replace('"%s"','?',$query);
			$query=str_replace('%s','??',$query);
		}
		return ($query);
	}
	public function showErrors($val=true){
		$this->echo=$val;
	}
	public function query($sql=false,$a=false){
		if(!$sql) return $this->lastQuery;
		$sql=$this->escape_string($sql,$a);
		$this->sql=$sql;
		if($query=mysqli_query($this->dbcon,$sql)){
			$this->error=false;
			$this->errorMsg='';
		}else{
			$this->error=true;
			$this->errorMsg='Error en query ('.$_SERVER['PHP_SELF'].'): '.mysqli_error($this->dbcon).'<br>'.$sql;
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
		return preg_replace('/\s+/',' ',$this->sql);;
	}
	public function numRows($query){#cantidad de columnas en la consulta
		return @mysqli_num_rows($query);
	}
	public function normalizeString($data){#combierte caracteres especiales utf8 en html
		return $data;
		$tmp=json_encode($data);
		$tmp=preg_replace('/\\\\u([\d\w]{4})/','&#x$1;',$tmp);
		return json_decode($tmp,is_array($data));
	}
	public function fetchAssoc($query=false,$normalize=true){#devuelve la siguiente columna de la consulta
		if(!$query) $query=$this->lastQuery;
		$data=@mysqli_fetch_assoc($query);
		if($normalize) $data=$this->normalizeString($data);
		return $data;
	}
	public function fetchArray($query=false,$normalize=true){#devuelve la siguiente columna como un arreglo simple
		if(!$query) $query=$this->lastQuery;
		$data=@mysqli_fetch_array($query);
		if($normalize) $data=$this->normalizeString($data);
		return $data;
	}
	public function fetchObject($query=false,$normalize=true){#devuelve la siguiente columna como un arreglo simple
		if(!$query) $query=$this->lastQuery;
		$data=@mysqli_fetch_object($query);
		if($normalize) $data=$this->normalizeString($data);
		return $data;
	}
	public function getArray($sql,$a=false,$normalize=true){#devuelve arreglo con todas las columnas (arreglo simple)
		$array=array();
		$query=$this->query($sql,$a);
		if($this->numRows($query)>0)
			while($row=$this->fetchArray($query,$normalize)) $array[]=$row;
		return $array;
	}
	public function getAssoc($sql,$a=false,$normalize=true){#devuelve arreglo con todas las columnas (arreglo asociativo)
		$array=array();
		$query=$this->query($sql,$a);
		if($this->numRows($query)>0)
			while($row=$this->fetchAssoc($query,$normalize)) $array[]=$row;
		return $array;
	}
	public function getObject($sql,$a=false,$normalize=true){#devuelve arreglo con todas las columnas (objetos)
		$array=array();
		$query=$this->query($sql,$a);
		if($this->numRows($query)>0)
			while($row=$this->fetchObject($query,$normalize)) $array[]=$row;
		return $array;
	}
	public function getRow($sql,$a=false,$normalize=true){#devuelve la primera columna de una consulta
		$row=array();
		if(!preg_match('/\blimit\s+\d+\s*;?\s*$/i',$sql)){
			$echo=$this->echo;
			$this->echo=false;
			$query=$this->query($sql.' LIMIT 1',$a);
			$this->echo=$echo;
		}
		if(!$query) $query=$this->query($sql,$a);
		if($this->numRows($query)>0) $row=$this->fetchAssoc($query,$normalize);
		return $row;
	}
	public function getRowObject($sql,$a=false,$normalize=true){#devuelve la primera columna de una consulta
		if(!preg_match('/\blimit\s+\d+\s*;?\s*$/i',$sql)){
			$echo=$this->echo;
			$this->echo=false;
			$query=$this->query($sql.' LIMIT 1',$a);
			$this->echo=$echo;
		}
		if(!$query) $query=$this->query($sql,$a);
		return $this->numRows($query)>0?$this->fetchObject($query,$normalize):new stdClass();
	}
	public function getVal($sql,$a=false,$normalize=true){#devuelve el valor del primer elemento de una consulta
		$el=NULL;
		$query=$this->query($sql,$a);
		if($this->numRows($query)>0) $el=array_shift($this->fetchArray($query,$normalize));
		return $el;
	}
	public function count($tabla,$where='1',$a=false){#cuenta elementos de una consulta
		$query=$this->query("SELECT id FROM $tabla WHERE $where",$a);
		return $this->numRows($query);
	}
	public function sum($campo,$tabla,$where='1',$a=false){
		return $this->getVal("SELECT SUM($campo) FROM $tabla WHERE $where",$a);
	}
	public function exist($tabla,$where,$a=false){
		$row=$this->getRow("SELECT * FROM $tabla WHERE $where",$a);
		return count($row)>0;
	}
	public function insert($tabla,$set,$a=false){
		$query=$this->query("INSERT INTO $tabla SET $set",$a);
		return $query?mysqli_insert_id($this->dbcon):false;
	}
	public function insert_or_update($tabla,$set,$set_if_insert,$where_if_update,$a=false){
		list($tabla,$set,$set_if_insert,$where_if_update)=explode(' [[,]] ',
			$this->escape_string(implode(' [[,]] ',
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
		elseif(is_string($a)) return mysqli_real_escape_string($con,$a);
		elseif(!is_array($a)) return $a;
		foreach($a as $key => &$value){
			if(is_array($value))
				$value=$this->cleanStrings($value);
			elseif(is_string($value))
				$value=mysqli_real_escape_string($con,$value);
		}
		return $a;
	}
}
