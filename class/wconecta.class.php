<?php
function safe_sql($query,$params=false){#crea una cadena sql segura
	return CON::escape_string($query,$params);
}
class CON{
	private static $dbcon,$lastQuery='',$sql,$error,$errorMsg,
		$echo=true,
		$dbdata=array();
	public function __construct(){}
	public function __destruct(){
		self::close();
	}
	public static function close(){
		if(self::$dbcon) @mysqli_close(self::$dbcon);
		self::$dbcon=false;
	}
	public static function con($host=false,$user=false,$pass=false,$data=false){
		if(!$data&&self::$dbcon) return self::$dbcon;
		if($data&&self::$dbcon) self::close();
		if(!$data&&!self::$dbcon){
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
		return self::$dbcon=$con;
	}
	public static function escape_string($sql,$params=false){
		#crea una cadena sql segura
		if($params){
			$params=self::cleanStrings($params);
			# str_replace - cambiando ?? -> %s y ? -> "%s". %s is ugly in raw sql sql
			# ?? for expressions manually scaped like that: LIKE "%??%"
			$sql=preg_replace('/%{1,2}/','%%',$sql);
			$sql=str_replace('??','%s',$sql);
			$sql=str_replace('?','"%s"',$sql);
			# vsprintf - replacing all %s to parameters
			$sql=vsprintf($sql,$params);
			// $sql=str_replace('"%s"','?',$sql);
			// $sql=str_replace('%s','??',$sql);
		}
		return ($sql);
	}
	public static function showErrors($val=true){
		self::$echo=$val;
	}
	public static function query($sql=false,$a=false){
		if(!$sql) return self::$lastQuery;
		$sql=self::escape_string($sql,$a);
		self::$sql=$sql;
		if($query=mysqli_query(self::$dbcon,$sql)){
			self::$error=false;
			self::$errorMsg='';
		}else{
			self::$error=true;
			self::$errorMsg='Error en query ('.$_SERVER['PHP_SELF'].'): '.mysqli_error(self::$dbcon).'<br>'.$sql;
			if(self::$echo) echo self::$errorMsg;
		}
		self::$lastQuery=$query;
		return $query;
	}
	public static function error(){
		return self::$error;
	}
	public static function errorMsg(){
		return self::$errorMsg;
	}
	public static function lastSql(){
		return preg_replace('/\s+/',' ',self::$sql);;
	}
	public static function numRows($query){#cantidad de columnas en la consulta
		return @mysqli_num_rows($query);
	}
	public static function normalizeString($data){#combierte caracteres especiales utf8 en html
		return $data;
		$tmp=json_encode($data);
		$tmp=preg_replace('/\\\\u([\d\w]{4})/','&#x$1;',$tmp);
		return json_decode($tmp,is_array($data));
	}
	public static function fetchAssoc($query=false,$normalize=true){#devuelve la siguiente columna de la consulta
		if(!$query) $query=self::$lastQuery;
		$data=@mysqli_fetch_assoc($query);
		if($normalize) $data=self::normalizeString($data);
		return $data;
	}
	public static function fetchArray($query=false,$normalize=true){#devuelve la siguiente columna como un arreglo simple
		if(!$query) $query=self::$lastQuery;
		$data=@mysqli_fetch_array($query);
		if($normalize) $data=self::normalizeString($data);
		return $data;
	}
	public static function fetchObject($query=false,$normalize=true){#devuelve la siguiente columna como un arreglo simple
		if(!$query) $query=self::$lastQuery;
		$data=@mysqli_fetch_object($query);
		if($normalize) $data=self::normalizeString($data);
		return $data;
	}
	public static function getArray($sql,$a=false,$normalize=true){#devuelve arreglo con todas las columnas (arreglo simple)
		$array=array();
		$query=self::query($sql,$a);
		if(self::numRows($query)>0)
			while($row=self::fetchArray($query,$normalize)) $array[]=$row;
		return $array;
	}
	public static function getAssoc($sql,$a=false,$normalize=true){#devuelve arreglo con todas las columnas (arreglo asociativo)
		$array=array();
		$query=self::query($sql,$a);
		if(self::numRows($query)>0)
			while($row=self::fetchAssoc($query,$normalize)) $array[]=$row;
		return $array;
	}
	public static function getObject($sql,$a=false,$normalize=true){#devuelve arreglo con todas las columnas (objetos)
		$array=array();
		$query=self::query($sql,$a);
		if(self::numRows($query)>0)
			while($row=self::fetchObject($query,$normalize)) $array[]=$row;
		return $array;
	}
	public static function getRow($sql,$a=false,$normalize=true){#devuelve la primera columna de una consulta
		$row=array();
		if(!preg_match('/\blimit\s+\d+\s*;?\s*$/i',$sql)){
			$echo=self::$echo;
			self::$echo=false;
			$query=self::query($sql.' LIMIT 1',$a);
			self::$echo=$echo;
		}
		if(!$query) $query=self::query($sql,$a);
		if(self::numRows($query)>0) $row=self::fetchAssoc($query,$normalize);
		return $row;
	}
	public static function getRowObject($sql,$a=false,$normalize=true){#devuelve la primera columna de una consulta
		$row=array();
		if(!preg_match('/\blimit\s+\d+\s*;?\s*$/i',$sql)){
			$echo=self::$echo;
			self::$echo=false;
			$query=self::query($sql.' LIMIT 1',$a);
			self::$echo=$echo;
		}
		if(!$query) $query=self::query($sql,$a);
		if(self::numRows($query)>0) $row=self::fetchObject($query,$normalize);
		return $row;
	}
	public static function getVal($sql,$a=false,$normalize=true){#devuelve el valor del primer elemento de una consulta
		$el=NULL;
		$query=self::query($sql,$a);
		if(self::numRows($query)>0) $el=array_shift(self::fetchArray($query,$normalize));
		return $el;
	}
	public static function count($tabla,$where='1',$a=false){#cuenta elementos de una consulta
		$query=self::query("SELECT id FROM $tabla WHERE $where",$a);
		return self::numRows($query);
	}
	public static function sum($campo,$tabla,$where='1',$a=false){
		return self::getVal("SELECT SUM($campo) FROM $tabla WHERE $where",$a);
	}
	public static function exist($tabla,$where,$a=false){
		$row=self::getRow("SELECT * FROM $tabla WHERE $where",$a);
		return count($row)>0;
	}
	public static function insert($tabla,$set,$a=false){
		$query=self::query("INSERT INTO $tabla SET $set",$a);
		return $query?mysqli_insert_id(self::$dbcon):false;
	}
	public static function insert_or_update($tabla,$set,$set_if_insert,$where_if_update,$a=false){
		list($tabla,$set,$set_if_insert,$where_if_update)=explode(' [[,]] ',
			self::escape_string(implode(' [[,]] ',
				array($tabla,$set,$set_if_insert,$where_if_update)
			),$a)
		);
		if(self::exist($tabla,$where_if_update))
			return self::update($tabla,$set,$where_if_update);
		else
			return self::insert($tabla,"$set,$set_if_insert");
	}
	public static function update($tabla,$set,$where,$a=false){
		return !!self::query("UPDATE $tabla SET $set WHERE $where",$a);
	}
	public static function delete($tabla,$where,$a=false){
		return !!self::query("DELETE FROM $tabla WHERE $where",$a);
	}
	public static function cleanStrings($a){#formatea cadenas para uso en sql.
		$con=self::con();
		if(get_magic_quotes_gpc()) return $a;
		elseif(is_string($a)) return mysqli_real_escape_string($con,$a);
		elseif(!is_array($a)) return $a;
		foreach($a as $key => &$value){
			if(is_array($value))
				$value=self::cleanStrings($value);
			elseif(is_string($value))
				$value=mysqli_real_escape_string($con,$value);
		}
		return $a;
	}
}
CON::con();

#ACTIVIDAD: si el usuario esta logeado, actualizamos
if($_SESSION['ws-tags']['ws-user']['id'])
CON::insert_or_update('activity_users',
	'id_user=?,code=?,time=now()',
	'REMOTE_ADDR=?,HTTP_USER_AGENT=?,session_id=?',
	'REMOTE_ADDR=? AND HTTP_USER_AGENT=? AND session_id=?',
	array(
		$_SESSION['ws-tags']['ws-user']['id'],$_SESSION['ws-tags']['ws-user']['code'],
		$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],session_id(),
		$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],session_id(),
	)
);
#ACTIVIDAD_END

class wconecta{
	private $dbhost,$dbuser,$dbpass,$dbase;

	public function __construct($host,$user,$pass,$data){
		$this->dbhost=$host;
		$this->dbuser=$user;
		$this->dbpass=$pass;
		$this->dbase=$data;
		$this->con();
	}
	public function __destruct(){
		@mysql_close();
	}
	public function con(){
		if(!mysql_connect($this->dbhost,$this->dbuser,$this->dbpass)&&$_SESSION['ws-tags']['developer'])
			printf('Error en conexion (%s): %s<br>',$_SERVER['PHP_SELF'],mysql_error());
		if(!mysql_set_charset("utf8"))
			printf('Error cargando el conjunto de caracteres utf8: %s<br>',mysql_error());
		if(!mysql_select_db($this->dbase)&&$_SESSION['ws-tags']['developer'])
			printf('Error en seleccion db (%s): %s',$_SERVER['PHP_SELF'],mysql_error());
	}
	public function query($sql,$a=false){
		$sql=safe_sql($sql,$a);
		if(!($query=mysql_query($sql))&&$_SESSION['ws-tags']['developer'])
			echo 'Error en query ('.$_SERVER['PHP_SELF'].'): '.mysql_error().'<br>'.$sql;
		return $query;
	}
	public function queryArray($sql,$a=false){
		$sql=safe_sql($sql,$a);
		$array=array();
		$query=$this->query($sql);
		if(@mysql_num_rows($query)>0)
			while($row=@mysql_fetch_assoc($query)) $array[]=$row;
		return $array;
	}
	public function queryRow($sql,$a=false){//devuelve la primera columna de una consulta
		$sql=safe_sql($sql,$a);
		$row=array();
		$query=$this->query($sql);
		if(@mysql_num_rows($query)>0) $row=@mysql_fetch_assoc($query);
		return $row;
	}
}
global $cn;
$cn=new wconecta(HOST,USER,PASS,DATA);
?>