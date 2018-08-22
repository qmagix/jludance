<?php
/*
 * Created on Nov 15, 2006
 * Project tools
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@ieee.org
 */

 class Database{
 	var $connection;
 	function Database($dbserver,$dbname,$username,$passwd){
 		//echo $dbserver."--".$username."--".$passwd;
 		$this->connection = mysqli_connect($dbserver,$username,$passwd) or die(mysqli_error());
 		//echo "---".$dbname;
 		//mysqli_select_db($dbname, $this->connection) or die(mysqli_error());
    mysqli_select_db($this->connection,$dbname) or die(mysqli_error());
 		//echo "-dfd--".$dbname;
 	}
 	function getTableColumn($table,$uniquekey,$colname,$condition=NULL){
 		$r=array();
 		if ($condition){
 		   $q="SELECT $uniquekey, $colname FROM $table WHERE ".$condition;
 		}else{
 		   $q="SELECT $uniquekey, $colname FROM $table";
 		}
 		//$q="SELECT * From photos";
 		//$q="SELECT id,title From photos";
 		//echo $q;
 		//$result=mysqli_query($q, $this->connection) or die(mysqli_error());
    $result=mysqli_query($this->connection,$q) or die(mysqli_error());
        //var_dump($result);
 		if($result==null) echo "Result is null<br>";
 		$row=mysqli_fetch_array($result);
 		while($row){
 			$r[$row[$uniquekey]]=$row[$colname];
 			$row=mysqli_fetch_array($result);
 		}
 		return $r;
 	}
 	function getItem($table,$id){
 		$q="SELECT * FROM $table WHERE id='$id'";
 		$result=mysqli_query($this->connection,$q) or die(mysqli_error());
        //var_dump($result);
 		//if($result==null) echo "Result is null<br>";
 		$row=mysqli_fetch_array($result);
 		return $row;
 	}
 	/* arr is an array */
 	function saveItem($table,$arr){
 		$f=implode(",",array_keys($arr));
 		$vs=array_values($arr);
 		$v='';
 		foreach ($vs as $value){
 			$v.="'$value',";
 		}
 		$v=substr($v,0,strlen($v)-1);
 		//$v=implode(",",array_values($arr));
 		$q="INSERT INTO $table ($f) VALUES ($v)";
 		mysqli_query($this->connection,$q);
 		//echo $q;
 	}
 	function query($q){
 		$result=mysqli_query($this->connection,$q)  or die(mysqli_error());
 		return $result;
 	}
 	function lastInsterId(){
 		return mysqli_insert_id();
 	}
 	function getValue($tbname, $fieldname, $rowid){
 		$q="SELECT * FROM $tbname WHERE id='$rowid'";
 		//echo $q;
 		$result=mysqli_query($this->connection,$q) or die(mysqli_error());
 		$row=mysqli_fetch_assoc($result);
 		return $row[$fieldname];
 	}
 	function getNumRows($tbname,$condition){
 		$q="SELECT * FROM $tbname WHERE $condition";
 		$result=mysqli_query($this->connection,$q)  or die(mysqli_error());
 		return mysqli_num_rows($result);
 	}
 	/* arr is an array */
 	function updateItem($table,$id,$arr){
 		foreach ($arr as $key=>$value){
 			$v.="$key='$value',";
 		}
 		$v=substr($v,0,strlen($v)-1);
 		$q="UPDATE $table SET $v WHERE id='".$id."'";
 		mysqli_query($this->connection,$q) ;
 		//echo $q;
 	}
 	function getItemId($table,$arr){
    	$x=array();
    	foreach ($arr as $k=>$v){
    		$x[]="$k = '$v'";
    	}
 		$f=implode(" and ",array_values($x));

 		$q="SELECT id FROM $table WHERE $f";
 		$result=mysqli_query($this->connection,$q)  or die (mysqli_error());
 		//echo $q;
 		if($result!=null and mysqli_num_rows($result)>0){
   	 		$row=mysqli_fetch_assoc($result);
   	 		return $row['id'];
   		}else{
   			return null;
   		}
 	}
 	function getItemIdStrong($tb,$pattern){
   		$pid=$this->getItemId($tb,$pattern);
   		if($pid==null){
   			$this->saveItem($tb,$pattern);
   			$pid=mysqli_insert_id();
   		    return $pid;
   		}else{
   			return $pid;
   		}
	}

	function deleteItem($tb,$id){
		$q = "DELETE FROM ".$tb." WHERE id = '$id'";
        mysqli_query($this->connection,$q);
	}
	function replaceItem($tb, $oldrow,$newrow){
		$this->deleteItem($tb,$oldrow['id']);
		$this->saveItem($tb,$newrow);
	}

 	 function getTableColumns($table,$colnames,$condition=NULL){
	 	$qfields='';
	 	foreach ($colnames as $val) {
	 		$qfields.=$val.",";
	 	}
	 	$qf=rtrim($qfields,",");
 		$r=array();
 		if ($condition){
 		   $q="SELECT $qf FROM $table ".$condition;
 		}else{
 		   $q="SELECT $qf FROM $table";
 		}
 		//$q="SELECT * From photos";
 		//$q="SELECT id,title From photos";
 		//echo $q;
 		$result=mysqli_query($this->connection,$q) or die(mysqli_error());
        //var_dump($result);
 		//if($result==null) echo "Result is null<br>";
 		$row=mysqli_fetch_array($result);
 		while($row){
 			$r[]=$row;
 			$row=mysqli_fetch_array($result);
 		}
 		return $r;
 	}
 	function showTableColumns($table,$colnames,$condition=NULL){
	 	$r='<table border=1><tr>';
	 	foreach ($colnames as $val){
	 		$r.="<th>".$val."</th>";
	 	}
	 	$r.='</tr>';
	 	$a= $this->getTableColumns($table,$colnames, $condition);
	 	foreach ($a as $row){
	 		$r.='<tr>';
	 		foreach ($colnames as $val){
	 		  $r.="<td>".$row[$val]."</th>";
	 	    }
	 		$r.='</tr>';
	 	}
	 	$r.='</table>';
 		return $r;
 	}

	//Rasmus suggested this:
	protected function fatal_error($msg) {
	    echo "<pre>Error!: $msg\n";
	    $bt = debug_backtrace();
	    foreach($bt as $line) {
	      $args = var_export($line['args'], true);
	      echo "{$line['function']}($args) at {$line['file']}:{$line['line']}\n";
	    }
	    echo "</pre>";
	    die();
  }
 }
?>
