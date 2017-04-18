<?php

class Dbase{
	
	private $user = "root";
	private $pass = "";
	private $host = "localhost";
	private $db = "cars";
	
	private $_insert_keys = array();
	private $_insert_values = array();
	private $_insert_valuesw= array();
	private $_insert_keysw= array();
	
	private $dbCon;
	
	function __construct() {
       
	   $this->dbCon = mysqli_connect($this->host, $this->user, $this->pass) or die("Couldn't connect to database!");
	   mysqli_select_db($this->dbCon, $this->db) or die("Couldn't select a database!");
	}
	
	public function run_query($sql){
		if(empty($sql)) return null;
		
		return mysqli_query($this->dbCon, $sql);
	}
   
    public function fetchAll($query = null){
	   
	   if(empty($query)){
		   die("No query given!");
	   }
	   
	   $result = mysqli_query($this->dbCon,$query);
	   
	   return $result;
   }
   
   public function prepareInsert($set = null){
	   if(empty($set)) return false;
	   
	   $this->emptyArray($this->_insert_keys);
	   $this->emptyArray($this->_insert_values);
	   
	   foreach($set as $key=>$value){
		   $this->_insert_keys[] = $key;
		   $this->_insert_values[] = $value;
	    }
	   
	   return true;
   }
   
	public function Update_where($set=null){
	   if(empty($set)) return false;
	   
	   $this->emptyArray($this->_insert_keysw);
	   $this->emptyArray($this->_insert_valuesw);
	   
	   
	   foreach($set as $keyw=>$valuew){
		   $this->_insert_keys[] = $keyw;
		   $this->_insert_values[] = $valuew;
		   
	    }
		
	   
	   return true;
	   
   }
   
   public function prepareUpdate ($values = null, $where = null){
	   if(empty($values) || empty($where)) {
		   return false;
	   }
	   
	   $this->emptyArray($this->_insert_keys);
	   $this->emptyArray($this->_insert_values);
	   $this->emptyArray($this->_insert_keysw);
	   $this->emptyArray($this->_insert_valuesw);
	   
	   foreach($values as $key => $val){
		   $this->_insert_keys[] = $key;
		   $this->_insert_values[] = $val;
	   }
	   
	   foreach($where as $key => $val){
		   $this->_insert_keysw[] = $key;
		   $this->_insert_valuesw[] = $val;
	   }
	   
	   //echo var_dump($this->_insert_keys);
	   //die();
   }
   
   public function update($table = null){
	   if(empty($table)) return false;
	   
	   $sql = "update `{$table}` set ";
	   
	   for($i = 0; $i < sizeof($this->_insert_keys); $i++){
		   $sql .= "`{$this->_insert_keys[$i]}` = '{$this->_insert_values[$i]}'";
		   
		   if($i < sizeof($this->_insert_keys) -1){
			   $sql .= ", ";
		   }
	   }
	   
	   $sql .= " where ";
	   
	   for($i = 0; $i < sizeof($this->_insert_keysw); $i++){
		   $sql .= "`{$this->_insert_keysw[$i]}` = '{$this->_insert_valuesw[$i]}'";
		   
		   if($i < sizeof($this->_insert_keysw) -1){
			   $sql .= " AND ";
		   }
	   }
	   
	   //($sql);
	   
	   return $this->run_query($sql);
   }
   
   public function Update_set($set=null){
	   if(empty($set)) return false;
	   
	   $this->emptyArray($this->_insert_keys);
	   $this->emptyArray($this->_insert_values);
	   
	   
	   foreach($set as $key=>$value){
		   $this->_insert_keys[] = $key;
		   $this->_insert_values[] = $value;
		   
	    }
		
	   
	   return true;
	   
   }
   
   public function insert($table = null){
	   if(empty($table)) return false;
	   
	   $query = "insert into `{$table}` (`";
	   $query .= implode("`, `", $this->_insert_keys);
	   $query .= "`) values ('";
	   $query .= implode("', '", $this->_insert_values);
	   $query .= "')";
	   
	   //die($query);
	   
	   if($this->run_query($query)){
		   return true;
	   }
   }
   
   /*public function Update($table=null){
	   if(empty($table)) return false;
	   $query="UPDATE `{$table}` SET `{$this->_insert_keys[0]}`='{$this->_insert_values[0]}', `{$this->_insert_keys[1]}`='{$this->_insert_values[1]}' WHERE `{$this->_insert_keysw[0]}`='{$this->_insert_valuesw[0]}' AND `{$this->_insert_keysw[1]}`='{$this->_insert_valuesw[1]}' ";
	   
	   
		if($this->run_query($query)){
		   return true;
	   }
	   
   }*/
   
   private function emptyArray($arr){
	   unset($arr);
	   $arr = array();
   }
   
}

?>