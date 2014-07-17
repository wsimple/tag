<?php
function safe_sql($query,$params=false){#crea una cadena sql segura
	if($params){
		$params=CON::cleanStrings($params);
		# str_replace - replacing ? -> %s. %s is ugly in raw sql query
		# vsprintf - replacing all %s to parameters
		$query=vsprintf( str_replace('?','"%s"',$query), $params );
		$query=str_replace('"%s"','?',$query);
	}
	return ($query);
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
		if(!self::$dbcon){
			include(RELPATH.'.security/security.php');
			$db=array();
			$host=$host?$host:$config->db->host;
			$user=$user?$user:$config->db->user;
			$pass=$pass?$pass:$config->db->pass;
			$data=$data?$data:$config->db->data;
			self::$dbcon=mysqli_connect($host,$user,$pass,$data);
			self::$dbdata=array('host'=>$host,'user'=>$user,'pass'=>$pass,'data'=>$data);
			if(mysqli_connect_errno()&&$_SESSION['ws-tags']['developer'])
				echo 'Error en conexion ('.$_SERVER['PHP_SELF'].'): '.mysqli_connect_error();
		}
		return self::$dbcon;
	}
	public static function escape_string($query,$params=false){
		#crea una cadena sql segura
		if($params){
			$params=self::cleanStrings($params);
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
	public static function fetchAssoc($query=false){#devuelve la siguiente columna de la consulta
		if(!$query) $query=self::$lastQuery;
		return @mysqli_fetch_assoc($query);
	}
	public static function fetchArray($query=false){#devuelve la siguiente columna como un arreglo simple
		if(!$query) $query=self::$lastQuery;
		return @mysqli_fetch_array($query);
	}
	public static function fetchObject($query=false){#devuelve la siguiente columna como un arreglo simple
		if(!$query) $query=self::$lastQuery;
		return @mysqli_fetch_object($query);
	}
	public static function getArray($sql,$a=false){#devuelve arreglo con todas las columnas de la consulta (arreglo simple)
		$array=array();
		$query=self::query($sql,$a);
		if(self::numRows($query)>0)
			while($row=@mysqli_fetch_array($query)) $array[]=$row;
		return $array;
	}
	public static function getAssoc($sql,$a=false){#devuelve arreglo con todas las columnas de la consulta (arreglo asociativo)
		$array=array();
		$query=self::query($sql,$a);
		if(self::numRows($query)>0)
			while($row=@mysqli_fetch_assoc($query)) $array[]=$row;
		return $array;
	}
	public static function getObject($sql,$a=false){#devuelve arreglo con todas las columnas de la consulta (objetos)
		$array=array();
		$query=self::query($sql,$a);
		if(self::numRows($query)>0)
			while($row=@mysqli_fetch_object($query)) $array[]=$row;
		return $array;
	}
	public static function getRow($sql,$a=false){#devuelve la primera columna de una consulta
		$row=array();
		if(!preg_match('/\blimit\s+\d+\s*;?\s*$/i',$sql)){
			$echo=self::$echo;
			self::$echo=false;
			$query=self::query($sql.' LIMIT 1',$a);
			self::$echo=$echo;
		}
		if(!$query) $query=self::query($sql,$a);
		if(self::numRows($query)>0) $row=@mysqli_fetch_assoc($query);
		return $row;
	}
	public static function getRowObject($sql,$a=false){#devuelve la primera columna de una consulta
		$row=array();
		if(!preg_match('/\blimit\s+\d+\s*;?\s*$/i',$sql)){
			$echo=self::$echo;
			self::$echo=false;
			$query=self::query($sql.' LIMIT 1',$a);
			self::$echo=$echo;
		}
		if(!$query) $query=self::query($sql,$a);
		if(self::numRows($query)>0) $row=@mysqli_fetch_object($query);
		return $row;
	}
	public static function getVal($sql,$a=false){#devuelve el valor del primer elemento de una consulta
		$el=NULL;
		$query=self::query($sql,$a);
		if(self::numRows($query)>0) $el=array_shift(@mysqli_fetch_array($query));
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
			echo 'Error en conexion ('.$_SERVER['PHP_SELF'].'): '.mysql_error();
		if(!mysql_select_db($this->dbase)&&$_SESSION['ws-tags']['developer'])
			echo 'Error en seleccion db ('.$_SERVER['PHP_SELF'].'): '.mysql_error();
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