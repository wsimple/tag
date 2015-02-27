<?php
class DB_query{
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
