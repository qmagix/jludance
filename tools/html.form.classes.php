<?php
/*
 * Created on Nov 14, 2006
 * Project tools
 * 
 * Author: Qingfeng Huang
 * Email: qingfeng@ieee.org
 */
 
 class Checkboxes{
 
 	var $selected=array();
 	var $selection=array();
/* 	
 	  function __construct($s){
 		$this->setSelection(s);
 	}
*/
      function checkboxes($s=NULL){
 		$this->setSelection($s);
 	}
 	  function clear(){
 		//$selected=array();
 		//if(!empty($selection)){
 			foreach ($this->selection as $key=>$value){
 			   $this->selected[$key]=false;
 			}
 		//}
 	}
 	  function setSelection($arr){
 		$this->selection=$arr;
 		//clear();
 		foreach ($this->selection as $key=>$value){
 			   $this->selected[$key]=false;
 		}
 	}
 	
 	  function check($key){
 		$this->selected[$key]=true;
 	}
 	
 	  function prtOne($name,$label){
       print "<input type=\"checkbox\" name=\"$name\">$label";
    }
    
      function prtOneChecked($name,$label){
       print "<input type=\"checkbox\" name=\"$name\" CHECKED>$label";
    }
    
 	  function prt(){
			foreach($this->selection as $key =>$label){
				if($this->selected[$key])
				   $this->prtOneChecked($key,$label);
				else
				   $this->prtOne($key,$label);				
				print "<br>";
			}
		
 	}
 	  function uncheck($key){
 		$this->selected[$key]=false;
 	}
 	  function getCheckedIdsInStr(){
 		$str='';
 		foreach ($this->selected as $k=>$v){
 			if($v){
 				$str.=":".$k;
 			}
 		}
 		return $str;
 	}
 }
 
 class Form{
 	var  $blocks=array();
 	var $action;
 	var $aname;
 	var $sname;
 	
 	function Form($action,$aname,$sname='Submit'){
 		$this->action=$action;
 		$this->aname=$aname;
 		$this->sname=$sname;
 	}
 	function addBlock($prtable){
 		$this->blocks[]=$prtable;
 	}
 	function prt(){
 		print "<form action=\"$this->action\" method=\"POST\" name=\"$this->aname\">\n";
 		foreach ($this->blocks as $value){
 			$value->prt();
 		}
 		print "<input type=\"submit\" value=\"$this->sname\">";
 		print "</form>";
 	}
 	
 }
 
 class Entryline{
 	 var $label,$name,$value;
 	function Entryline($label, $name,$value=''){
 		$this->label=$label;
 		$this->name=$name;
 		$this->value=$value;
 	}
    function prt(){
        print "<label FOR=\"$this->name\">$this->label"."<input type=\"text\" name=\"$this->name\">$this->value"."</label><br>";
	}
	function getName(){return $this->name;}
	function getValue(){return $this->value;}
	function setValue($value){$this->value=$value;}
 }
 
 class RadioBoxes{
    var $selected;
 	var $selection=array();
 	var $name;
/* 	
 	  function __construct($s){
 		$this->setSelection(s);
 	}
*/
      function radioboxes($name,$s=NULL){
      	$this->setName($name);
 		$this->setSelection($s);
 	  }
 	  function clear(){
 		$selected=null;
 	  }
 	  function setName($name){
 	  	$this->name=$name;
 	  }
 	  function setSelection($arr){
 		$this->selection=$arr;
 		$this->clear();
 	  }
 	
 	  function check($key){
 		$this->selected=$key;
 	  }
 	
	 	function prtOne($value,$label){
	       print "<input type=\"radio\" name=\"$this->name\" value=\"$value\">$value,$label";
	    }
	    
	    function prtOneChecked($value,$label){
	       print "<input type=\"radio\" name=\"$this->name\"  value=\"$value\" checked=\"yes\">$label";
	    }
    
 	  function prt(){
			foreach($this->selection as $key =>$label){
				if($this->selected==$key)
				   $this->prtOneChecked($key,$label);
				else
				   $this->prtOne($key,$label);				
				print "<br>";
			}
		
 	}
 	function uncheck($key){
 		$this->clear();
 	}
 	function getCheckedValue(){
 		return $this->selected;
 	}
 }
?>
