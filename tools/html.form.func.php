<?
function prt_form_header($action,$actionname){
  print "<form action=\"$action\" method=\"POST\" name=\"$actionname\">\n";
}
function prt_form_closure(){
  print "</form>";
}
function prt_textfield($name){
  print "<input type=\"text\" name=\"$name\">";
}
function prt_entry_line($label, $name){
  print "<label FOR=\"$name\">$label"."<input type=\"text\" name=\"$name\">"."</label>";
}

function prt_radiobutton($name,$value,$label){
  print "<input type=\"radio\" name=\"$name\" value=\"$value\">$label";
}
function prt_checkbox($name,$label){
  print "<input type=\"checkbox\" name=\"$name\">$label";
}

function prt_textarea($name,$value,$rows,$cols){
  print "<textarea name=\"$name\" rows=$rows cols=$cols>$value</textarea>";
}

function prt_button($name){
  print "<input type=\"button\" value=\"$name\">";
}
function prt_submit_button($name){
  print "<input type=\"submit\" value=\"$name\">";
}

function prt_fieldset($legend,$content,$styleclass){
  $str="<fieldset class=\"$styleclass\">";
  $str.="<legend>$legend</legend>$conetent</fieldset>";
  print $str;
}
function prt_dropdownbox($name,$arr){
  $str="<select name=\"$name\">\n";
  foreach ($arr as $key => $value){
     $str.="<option value=\"$key\">$value\n";
  }
  $str.="</select>";
  print $str;
}

function prt_dropdownbox_preselected($name,$arr,$preselectkey){
  $str="<select name=\"$name\">\n";
  foreach ($arr as $key => $value){
     if($key==$preselectkey){
		 $str.="<option value=\"$key\" selected=\"selected\">$value\n";
	 }else{
        $str.="<option value=\"$key\">$value\n";
	 }
  }
  $str.="</select>"; 
  print $str;
}
function prt_dropdownbox_tiered($name,$arr){
  $str="<select name=\"$name\">\n";
  foreach ($arr as $key => $valuearr){
     $str.="<optgroup label=\"$key\">";
	 foreach ($valuearr as $key2 => $value){
       $str.="<option value=\"$key2\">$value\n";
     }
	 $str.="</optgroup>";
  }
  $str.="</select>";
  print $str;
}
/* input is an array*/
function prt_checkbox_list($arr, $mode="v"){
	if($mode=="h"){
	foreach ($arr as $key=>$value){
		prt_checkbox($key,$value);
	}
	}else{
		foreach ($arr as $key=>$value){
		prt_checkbox($key,$value); print "<br>";
	}
	}
}

function prt_form($action,$actionname,$prtable){
	prt_form_header($action,$actionname);
	$prtable->prt();
	prt_submit_button("Submit");
	prt_form_closure();
}

?>