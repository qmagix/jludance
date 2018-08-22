<?php
/*
 * Created on May 25, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
require_once("header.php");


$yearid=$config['yearid'];
if(isset($_GET['yearid'])){
	$yearid=$_GET['yearid'];
}

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
 

 	
 	  $str="";
 	  prt_h2("All year ".$yearid." classes");
	 //$var=$db->getTableColumn($_SESSION['class_tb'],'id','title',"visible=1 and yearid='$yearid'");
	 $q="SELECT id,title FROM classes WHERE visible=1 and yearid='$yearid'";
	 echo $q."<hr>";
	 $result=$db->query($q);
        //var_dump($result);
 		//if($result==null) echo "Result is null<br>";
 		$r=array();
 		$row=mysql_fetch_array($result);
 		while($row){
 			$r[$row['id']]=$row['title'];
 			$row=mysql_fetch_array($result);
 		}
	  foreach ($r as $key=>$value){
			$str.=$value."\n";
		}		
 
?>
<form method="POST" action="batchclassaddition.php">
<textarea name="classlist" cols=50 rows=20><?php echo $str;?></textarea><br/>
to term: <input type="text" name="yearid"/>

  <input type="submit" name="submit" value="Submit"/>
  </form>
  
  
  

  