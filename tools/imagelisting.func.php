<?php
//functions helping image listings
//Qingfeng Huang

function setImageLink($image, $link){
    print("<a href=\"".$link."\"><img src=\"".$image."\"></a>");
}
function setImageLinkWithWidth($image, $link,$width){
    print("<a href=\"".$link."\"><img src=\"".$image."\" width=\"$width\"></a>");
}
function setImageLinkWithCaption($image, $link,$caption){
    print("<a href=\"".$link."\"><img src=\"".$image."\" border=0></a><br>$caption");
}
function setImageLinkWithCaptionCheckbox($image, $link,$caption,$id){
    print("<a href=\"".$link."\"><img src=\"".$image."\"
    border=0></a><br>$caption<input type=\"checkbox\" name=\"$id\" value=\"$id\">");
}
function setImageLinkWithHCaption($image, $link,$caption){
    print("<table class=\"thumbnail_fhc\"><tr valign=top><td width=10><a href=\"".$link."\"><img src=\"".$image."\" border=0></a></td><td>$caption</td></tr></table>");
}
function getImageLinkWithHCaption($image, $link,$caption){
    return "<table class=\"thumbnail_fhc\"><tr valign=top><td width=10><a href=\"".$link."\"><img src=\"".$image."\" border=0></a></td><td>$caption</td></tr></table>";
}
function listInTable($imagenamearray,$filedir,$thumbdir,$perrow){
   $n=count($imagenamearray);
   $m=floor($n/$perrow);
   //echo "$n--$m--$perrow";
   print("<table class=thumbnailtable>");
   for ($i=0;$i<$m;$i++){
      print("<tr>\n");
      for($j=0;$j<$perrow;$j++){
	     $index=$i*$perrow+$j;
	     $row=$imagenamearray[$index];
		 $filename=$row['link'];
		 $author=$row['author'];
		 $title=$row['title'];
		 print("<td align=center>");
		 //setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title." (".$author.")");	
		 setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title);	

         print("</td>");
	  }
      print("</tr>\n");
   }
   $residual=$n % $perrow;
   //echo "res $residual";
   if($residual>0){
   print("<tr>\n");
     for($k=0;$k<$residual;$k++){
         $index=$index+1;
	     $row=$imagenamearray[$index];
		 $filename=$row['link'];
		 $author=$row['author'];
		 $title=$row['title'];
		 print("<td align=center>");
		 //setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title." (".$author.")");
		 setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title);
		
         print("</td>");
     }
	 print("</tr>\n");
   }
   print("</table>");
}

//this requires DB_fun.php
function listInTableFromDb($table,$filedir,$thumbdir){
    global $config;
    DB_Open($config["db_name"],$config["db_host"],$config["db_user"],$config["db_pass"],&$conn);
	$searchval['link']="";
	$searchval['author']="";
	$searchval['title']="";
    DB_Get($conn,$table,$searchval,&$results,"timestamp");
    DB_Close($conn);
    listInTable($results,$filedir,$thumbdir,3);
}
/** List iamges in db with checkboxes for selection**/
function listInTableFromDbCheckbox($table,$filedir,$thumbdir){
    global $config;
    DB_Open($config["db_name"],$config["db_host"],$config["db_user"],$config["db_pass"],&$conn);
	$searchval['id']="";
	$searchval['link']="";
	$searchval['author']="";
	$searchval['title']="";
    DB_Get($conn,$table,$searchval,&$results,"timestamp");
    DB_Close($conn);
    listInTableWithCheckbox($results,$filedir,$thumbdir,6);
}

//this does not require DB_fun.. not done
function listInTableFromDb2($table,$start, $numentries, $filedir,$thumbdir){
   $query="SELECT * FROM $table order by id DESC LIMIT " . $start . ", $numentries"; 
   $row=mysql_query($query);
   
}

//
function listInTableWithCheckbox($imagenamearray,$filedir,$thumbdir,$perrow){
   $n=count($imagenamearray);
   $m=floor($n/$perrow);
   //echo "$n--$m--$perrow";
   print("<FORM ACTION=\"".$PHP_SELF."\" METHOD=\"post\"><table class=thumbnailtable>");
   for ($i=0;$i<$m;$i++){
      print("<tr>\n");
      for($j=0;$j<$perrow;$j++){
	     $index=$i*$perrow+$j;
	     $row=$imagenamearray[$index];
		 $filename=$row['link'];
		 $author=$row['author'];
		 $title=$row['title'];
		 $id=$row['id'];
		 print("<td align=center>");
		 //setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title." (".$author.")");	
		 setImageLinkWithCaptionCheckbox($thumbdir."/".$filename,$filedir."/".$filename,$title,$id);	

         print("$id</td>");
	  }
      print("</tr>\n");
   }
   $residual=$n % $perrow;
   //echo "res $residual";
   if($residual>0){
   print("<tr>\n");
     for($k=0;$k<$residual;$k++){
         $index=$index+1;
	     $row=$imagenamearray[$index];
		 $filename=$row['link'];
		 $author=$row['author'];
		 $title=$row['title'];
         $id=$row['id'];
		 print("<td align=center>");
		 //setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title." (".$author.")");
		 setImageLinkWithCaptionCheckbox($thumbdir."/".$filename,$filedir."/".$filename,$title,$id);
		
         print("</td>");
     }
	 print("</tr>\n");
   }
   print("</table>");
   print("Slection title: <input type=text name=title><br>");
   print("Output file: <input type=text name=outfile><br>");
   print("<input type=submit name=submit value=submit></form>");
}

function listInTable2($results,$filedir,$thumbdir,$perrow){
   print("<table class=thumbnailtable>");
   $c=0;
   while($row=mysql_fetch_assoc($results)){
      if($c==0){
         print("<tr>\n");
      }
		 $filename=$row['link'];
		 $author=$row['author'];
		 $title=$row['title'];
		 print("<td align=center>");
		 //setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title." (".$author.")");	
		 setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title);	

         print("</td>");
	  
	  $c=$c+1;
	  if($c==$perrow){
         $c=0;
      
         print("</tr>\n");
      }
   }
   if($c!=0){
		print("</tr>\n");
   }
   print("</table>");
}
function listInTable3($results,$filedir,$thumbdir,$perrow){
   print("<table class=thumbnailtable>");
   $c=0;
   while($row=mysql_fetch_assoc($results)){
      if($c==0){
         print("<tr valign=top>\n");
      }
		 $filename=$row['link'];
		 $author=$row['author'];
		 $title=$row['title'];
		 print("<td>");
		 //setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title." (".$author.")");	
		 setImageLinkWithHCaption($thumbdir."/".$filename,$filedir."/".$filename,$title);	

         print("</td>");
	  
	  $c=$c+1;
	  if($c==$perrow){
         $c=0;
      
         print("</tr>\n");
      }
   }
   if($c!=0){
		print("</tr>\n");
   }
   print("</table>");
}
function listInTable4($results,$filedir,$thumbdir,$perrow){
   $str="<table class=thumbnailtable>";;
   $c=0;
   while($row=mysql_fetch_assoc($results)){
      if($c==0){
         $str.="<tr valign=top>\n";
      }
		 $filename=$row['link'];
		 $author=$row['author'];
		 $title=$row['title'];
		 $str.="<td>";
		 //setImageLinkWithCaption($thumbdir."/".$filename,$filedir."/".$filename,$title." (".$author.")");	
		 $str.=getImageLinkWithHCaption($thumbdir."/".$filename,$filedir."/".$filename,$title);	

         $str.="</td>";
	  
	  $c=$c+1;
	  if($c==$perrow){
         $c=0;
      
         $str.="</tr>\n";
      }
   }
   if($c!=0){
		$str.="</tr>\n";
   }
   $str.="</table>";
   return $str;
}

function setDivImageLinkWithHCaption($image, $link,$caption){
    print("<div class=\"thumbnail_fhc\"><table><tr valign=top><td><a href=\"".$link."\"><img src=\"".$image."\" border=0></a></td><td>$caption</td></tr></table></div>");
}
/*the following div based one does not really work well when the image
      sizes vary*/
function listImageTableless($results,$filedir,$thumbdir){
   print("<hr>");
   while($row=mysql_fetch_assoc($results)){
		 $filename=$row['link'];
		 $author=$row['author'];
		 $title=$row['title'];
		 setDivImageLinkWithHCaption($thumbdir."/".$filename,$filedir."/".$filename,$title);	
   }
   print("<hr>");
}

require_once("string.func.php");
function listJPGsInDir($dname,$width=null){
	$dir=dir($dname);
	while($item = $dir->read()){
        if(endsWith(".JPG",$item)||endsWith(".jpg",$item)){
        	if($width){
        		setImageLinkWithWidth($item, $item,$width);
        	}else{
        	setImageLink($item, $item);
        	}
        }
    }
	
}
function listJPGsHere($width=null){
	$dir=dir('.');
	while($item = $dir->read()){
        if(endsWith(".JPG",$item)||endsWith(".jpg",$item)){
        	if($width){
        		setImageLinkWithWidth($item, $item,$width);
        	}else{
        	setImageLink($item, $item);
        	}
        }
    }
	
}

//listJPGsInDir(".");
?>

