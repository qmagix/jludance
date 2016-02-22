<?
function prt_html_header($text){
  print("<html> <head>\n");
  print('<meta http-equiv="Content-Type" content="text/html;  charset=utf-8">'."\n");
  print('<link REL="stylesheet" TYPE="text/css" href="style/main.css">'."\n");
  print("</head><title> $text  </title><body>\n");
}
function prt_h1($text){
	print("<H1> ".$text."  </H1>\n");
}
function br(){
   print "</BR>";	
}
function print_html_header($text){
  print("<html> <head>\n");
  print('<meta http-equiv="Content-Type" content="text/html;  charset=utf-8">'."\n");
  print('<link REL="stylesheet" TYPE="text/css" href="style/main.css">'."\n");
  print("</head><title> $text  </title><body>\n");
  print("<H1> "._SITE_TITLE."  </H1>\n");
}
function print_html_header_with_css($text, $css){
  print("<!DOCTYPE html><html> <head>\n");
  print('<meta http-equiv="Content-Type" content="text/html;  charset=utf-8">'."\n");
  print('<link REL="stylesheet" TYPE="text/css" href="'.$css.'">'."\n");
  print("</head><title> $text  </title><body>\n");
  print("<H1> ".SITE_TITLE."  </H1>\n");
}
function print_entryline($name,$value){
  print("<tr><td><b>".ucfirst($name).": </b></td><td><input size=77 maxlength=280
  type=\"text\" name=\"".$name."\" value=\"$value\"></td></tr>\n");
}
/*improved from previous*/
function print_entry_line($label, $dbfieldname,$value){
  print("<tr><td><b>".ucfirst($label).": </b></td><td><input size=77 maxlength=280
  type=\"text\" name=\"".$dbfieldname."\" value=\"$value\"></td></tr>\n");
}
function print_entry_line_w_error($label, $dbfieldname,$value, $error){
  print("<tr><td><b>".ucfirst($label).": </b></td><td><input maxlength=50
  type=\"text\" name=\"".$dbfieldname."\" value=\"$value\"></td><td>$error</td></tr>\n");
}
function print_password_entry_w_error($label, $dbfieldname,$value, $error){
  print("<tr><td><b>".ucfirst($label).": </b></td><td><input maxlength=30
  type=\"password\" name=\"".$dbfieldname."\" value=\"$value\"></td><td>$error</td></tr>\n");
}

function print_hidden_input($name,$value){
  print("<input type=\"hidden\" name=\"$name\" value=\"$value\">\n");
}
function print_textarea($label, $dbfieldname){
  print('<tr><td valign="top"><b>'.$label.": </b></td><td><textarea name=\"".$dbfieldname."\" cols=76 rows=10></textarea></td></tr>\n");
}
function print_textarea_w_content($label, $dbfieldname,$content){
  print('<tr><td valign="top"><b>'.$label.": </b></td><td><textarea name=\"".$dbfieldname."\" cols=76 rows=10>$content</textarea></td></tr>\n");
}

function print_submit_button($label){
  print("<input type=\"submit\" value=\"$label\">\n");
}
function print_choice_line($choices){
  print("<tr><td><b>"._TYPE.": </b></td><td>");
  for ($x=0; $x<sizeof($choices); $x++){
      print("<input type='radio' value=$x name='choice'> $choices[$x] &nbsp;&nbsp;
  ");
  }
  print("</td></tr>\n");
}
function print_choice_line_checked($choices, $checkfield){
  print("<tr><td><b>Type: </b></td><td>");
  for ($x=0; $x<sizeof($choices); $x++){
	  if($choices[$x]==$checkfield){
        print("<input type='radio' value=$x name='choice' checked> $choices[$x] &nbsp;&nbsp;");
      }else{
        print("<input type='radio' value=$x name='choice'> $choices[$x] &nbsp;&nbsp;");
}
  }
  print("</td></tr>\n");
}

function print_nav_bracket($link, $text){
    print("[<a href=\"".$link."\">$text</a>]
	  &nbsp;&nbsp;");
}
function print_label_content_pair($label,$content){
    print("<tr><td valign=\"top\"><b>$label<br></b></td><td>$content</td></tr>");
}
//function print_registration_form($action){

//}

function print_add_title_form($action,$choices){
  print("<table><form action=\"".$action."\" method=\"POST\">\n");
  print_entry_line(_ITEM_TITLE,"title","");
  print_choice_line($choices);	
  print_textarea(_ITEM_NOTES,"notes");
  print('<tr><td colspan=2><input type="Submit" name="submit"
  value="'._ADD_NEW_ITEM.'"></td></tr>'."\n");
  print('</form></table>');
}
function print_edit_title_form($action,$choices,$values,$id){
  print("<table><form action=\"".$action."\" method=\"POST\">\n");
  print_entry_line(_ITEM_TITLE,"title", $values['title']);
  print_choice_line_checked($choices,$values['type']);	
  print_textarea_w_content(_ITEM_NOTES,"notes",$values['content']);
  print_hidden_input("id",$id);
  print('<tr><td colspan=2><input type="Submit" name="submit"
  value="'._UPDATE.'"></td></tr>'."\n");
  print('</form></table>');
}
function display_title_type_note($title,$type,$note){
  print("<table width=500>");
  print_label_content_pair("Title:",$title);
  print_label_content_pair("Notes: ", $note);
  print("</table>");
}
function print_action_confirmation_form($actionfunction,$actionname,$itemid){
    print("<form action=\"".$actionfunction."\" method=\"POST\">\n");
	print_hidden_input("id",$itemid);
	print('<input type="Submit" name="submit" value="'.$actionname.'">'."\n");
	print('</form>');
}
function list_titles($result){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=content2>\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li>";
	  echo $row->title." [--]";
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}
function list_titles_editable($result,$editfunction){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=\"vcd\">\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li class=".$row->type.">";
	  echo $row->title." [<a href=\"$editfunction?id=".$row->id."\">edit</a>]";
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}
function list_titles_editable_removable($result,$editfunction,$removefunction){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=\"vcd\">\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li class=".$row->type.">";
	  echo $row->title." [<a href=\"$editfunction?id=".$row->id."\">edit</a>] [<a href=\"$removefunction?id=".$row->id."\">remove</a>]";
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}
function list_title_and_type($result){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=\"vcd\">\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li class=".$row->type.">";
	  echo $row->title." [".$row->type."]";
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}
function list_title_type_name($result){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=\"vcd\">\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li class=".$row->type.">";
	  echo $row->title." [".$row->type." ] by [<font class=contact>".$row->sourceid."</font>]";
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}
function list_title_type_name_view($result){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=\"vcd\">\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li class=".$row->type.">";
	  echo $row->title." [".$row->type." ] by [<a href=\"userinfo_r.php?user=".$row->sourceid."&action=spammercheck\"><font class=contact>".$row->sourceid."</font></a>]";
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}

function list_title_reservable($result){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=\"vcd\">\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li class=".$row->type.">";
	  echo $row->title." [".$row->type."] by [".$row->sourceid."] ";
	  echo "[<a href=\"main.php?action=reserve&id=".$row->id."\">reserve</a>]";
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}

function print_user_navagation($username){
 /*  echo "<div class=nav>"
       ."[<a href=\"main.php?action=viewself\">My Collection</a>] &nbsp;&nbsp;"
       ."[<a href=\"addnewtitle.php\">Add New Title</a>] &nbsp;&nbsp;"
       ."[<a href=\"userinfo.php?user=$username\">My Account</a>] &nbsp;&nbsp;"
       ."[<a href=\"useredit.php\">Edit Account</a>] &nbsp;&nbsp;"
       ."[<a href=\"main.php\">Home</a>] &nbsp;&nbsp;"
       ."[<a href=\"suggestion.php\">Suggestion</a>] &nbsp;&nbsp;"
	   ."[<a href=\"process.php\">Logout</a>]</div><hr>";
 */
   echo "<div class=nav>";
   print_nav_bracket("main.php?action=viewself", _MY_CONTRIBUTION);
   print_nav_bracket("main.php?action=viewfriends",_FRIENDS_COLLECTION);
   print_nav_bracket("addnewtitle.php","<b>"._ADD_TITLE."</b>");
   print_nav_bracket("search.php",_SEARCH);   
   print_nav_bracket("addfriend.php",_SHARE);   
   print_nav_bracket("invitation.php","<b>"._INVITE."</b>");
   print_nav_bracket("userinfo520.php?user=$username",_MY_ACCOUNT);
   print_nav_bracket("main.php",_HOME);
   print_nav_bracket("suggestion.php",_SUGGESTIONS);
   print_nav_bracket("process.php",_LOGOUT); 
   echo "</div><hr>";
}

function print_guest_navagation(){
  print("[<a href=\"main.php\">Login</a>]");
}
function print_main_navagation(){
  //print("[<a href=\"loginsystem/main.php\">Login</a>] &nbsp;&nbsp;");
  //print("[<a href=\"suggestion.php\">Suggestion</a>] &nbsp;&nbsp;");
  //print("[<a href=\"index.php\">Home</a>]");
  //print_nav_bracket("main.php","Login");
  //print_nav_bracket("suggestion.php","Suggestion");
  print_nav_bracket("index.php","Home");
  //print_nav_bracket("about.php","About Us");
  print_nav_bracket("contact.php","Contact");
  if (OPEN_REGISTRATION){
  	print_nav_bracket("faq_open.php","FAQ");
  }else{
    print_nav_bracket("faq.php","FAQ");
  }

}
function print_footer(){
  print("<hr><center> <font size='-1' color=darkgray>&copy;
  "._COPYRIGHT." ".SITE_TITLE." "._YEAR."</font></center><br>");
}
function print_note_submission_form($action){
  print("<table><form action=\"".$action."\" method=\"POST\">\n");
  print("<tr><td colspan=2><font size='+1'><i> Notes </i></font></td></tr>");
  print_entry_line("Title","title", "");
  print_textarea("Details","notes");
  print_entry_line("Name/Email","contact","");
  print('<tr><td colspan=2><input type="Submit" name="submit"
  value="Submit"></td></tr>'."\n");
  print('</form></table>');
}
function print_suggestions(){
  global $database;
  print("<h3>"._CURRENT_SUGGESTIONS."</h3>");
  $query = "SELECT * FROM ".TBL_SUGGESTION;
  $results=$database->query($query);
  list_suggestions($results);
}
function list_suggestions($result){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=suggestions>\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li><b>";
	  echo $row->title."</b> [".$row->contact."] <br>";
	  echo $row->content;
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}

function print_suggestion_titles(){
  global $database;
  print("<h3>"._CURRENT_SUGGESTIONS.":</h3>");
  $query = "SELECT * FROM ".TBL_SUGGESTION;
  $results=$database->query($query);
  list_suggestion_titles($results);
}
function list_suggestion_titles($result){
  if (mysql_num_rows($result) > 0)
  {
   	echo "<ul class=suggestions>\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li><b>";
	  echo $row->title." <i>[Vote to be implemented]</i> </b>";
	  //echo $row->content;
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";		
  }
}

function print_friend_list($id){
  global $database;
  print("<h3>"._INVITED_FRIEND_LIST."</h3>");
  $query = "SELECT fids FROM ".TBL_FRIENDS_L." WHERE id='$id'";
  $results=$database->query($query);
  if (mysql_num_rows($results) > 0)
  {
    $row = mysql_fetch_object($results);
	$fids=$row->fids;
	list_friends2($fids);
  }else{
    print ("You have not started sharing yet.<br>");
  }
}

/* print the list of friends I choose to share my collection */
function print_friend_list2($id){
  global $database;
  print("<h3>Folks who are sharing with you:</h3>");
  $query = "SELECT fids FROM ".TBL_FRIENDS_L2." WHERE id='$id'";
  $results=$database->query($query);
  if (mysql_num_rows($results) > 0)
  {
    $row = mysql_fetch_object($results);
	$fids=$row->fids;
	list_friends2($fids);
  }else{
    //print ("You have not started sharing yet.<br>");
  }
}

function print_friend_list_floating($username){
  global $database;
  $id=$database->getIDviaUsername($username);
  print("<div class=\"floatright_border_simple\">");
  print("<h3>"._INVITED_FRIEND_LIST."</h3>");
  $query = "SELECT fids FROM ".TBL_FRIENDS_L." WHERE id='$id'";
  $results=$database->query($query);
  if (mysql_num_rows($results) > 0)
  {
    $row = mysql_fetch_object($results);
	$fids=$row->fids;
	list_friends2($fids);
    
  }else{
    print ("You have not started sharing yet.<br>");
  }
  print("</div>");
}


function list_friends($fids){
   $ids=explode(":",$fids);
   $num= count ($ids)-1;
   $k=1;
   	echo "<ul class=suggestions>\n";
	while($k<$num){
	  //echo "<li>".$ids[$k]." []"."</li>\n";
	  list_username($ids[$k]);
	  $k++;	   	
	  }
	echo "</ul>\n";		   
  
}

function list_username($id){
   global $database;
   $query="SELECT username FROM ".TBL_USERS." WHERE id='$id'";
   $results=$database->query($query);
   $row = mysql_fetch_object($results);
   print("<li>".$row->username."</li>"); 
}
/* A maybe more efficient way to query the database */
function list_friends2($fids){
   global $database;
   $ids=explode(":",$fids);
   $num= count ($ids)-1;
   $str= "id= '$ids[1]'";
   $k=2;
	while($k<$num){
	 $str.=" OR id='$ids[$k]'";
	  $k++;	   	
	}
   $query="SELECT username FROM ".TBL_USERS." WHERE ".$str;
   $result=$database->query($query);	
   	echo "<ul class=\"friends_list\">\n";
	while($row = mysql_fetch_object($result)){
	  echo "<li><b>";
	  echo $row->username."</b>";
	  echo "</li>\n";	   	
	  }
	echo "</ul>\n";	   
}

function print_friends_collection($username){
  global $database;
  $id=$database->getIDviaUsername($username);
  $query = "SELECT fids FROM ".TBL_FRIENDS_L2." WHERE id='$id'";
  $results=$database->query($query);
  if (mysql_num_rows($results) > 0)
  {
    $row = mysql_fetch_object($results);
	$fids=$row->fids;
	$ids=explode(":",$fids);
    $num= count ($ids)-1;
    $str= "uid= '$ids[1]'";
    $k=2;
	while($k<$num){
	 $str.=" OR uid='$ids[$k]'";
	  $k++;	   	
	}
      print("<h3>"._FRIENDS_COLLECTION." </h3>");
     $query = "SELECT * FROM ".TBL_INVENTORY." WHERE ".$str;
     $results=$database->query($query);
     list_title_type_name($results);
  }else{
    print ("Your friends have not started sharing with you yet. Either
    they are not in the network yet (Take the opportunity to INVITE
    THEM!) or they are not aware that you are a member now (let them know!).<br>");
  }

  print("<h3>"._MY_CONTRIBUTION."</h3>");
  $query = "SELECT * FROM ".TBL_INVENTORY." WHERE sourceid='$username'";
  $results=$database->query($query);
  list_title_and_type($results);
}
function print_friends_collection_like($username,$keywords){
  global $database;
  $id=$database->getIDviaUsername($username);
  $query = "SELECT fids FROM ".TBL_FRIENDS_L2." WHERE id='$id'";
  $results=$database->query($query);
  if (mysql_num_rows($results) > 0)
  {
    $row = mysql_fetch_object($results);
	$fids=$row->fids;
	$ids=explode(":",$fids);
    $num= count ($ids)-1;
    $str= "(uid= '$ids[1]'";
    $k=2;
	while($k<$num){
	 $str.=" OR uid='$ids[$k]'";
	  $k++;	   	
	}
	$str.=") AND title LIKE '%$keywords%'";
      print("<h3>"._FRIENDS_RELATED_COLLECTION." ($keywords)</h3>");
     $query = "SELECT * FROM ".TBL_INVENTORY." WHERE ".$str;
	 //echo $query;
     $results=$database->query($query);
     list_title_type_name($results);
  }else{
    print ("Your friends have not started sharing with you yet. Either
    they are not in the network yet (Take the opportunity to INVITE
    THEM!) or they are not aware that you are a member now (let them know!).<br>");
  }
}
function print_friends_collection2($username){
  global $database;
  $id=$database->getIDviaUsername($username);
  $query = "SELECT fids FROM ".TBL_FRIENDS_L2." WHERE id='$id'";
  $results=$database->query($query);
  if (mysql_num_rows($results) > 0)
  {
    $row = mysql_fetch_object($results);
	$fids=$row->fids;
	$ids=explode(":",$fids);
    $num= count ($ids)-1;
    $str= "uid= '$ids[1]'";
    $k=2;
	while($k<$num){
	 $str.=" OR uid='$ids[$k]'";
	  $k++;	   	
	}
      //print("<h3>Friends' collection: </h3>");
     print("<h3>"._FRIENDS_COLLECTION." </h3>");
     $query = "SELECT * FROM ".TBL_INVENTORY." WHERE ".$str;
     $results=$database->query($query);
     list_title_type_name_view($results);
  }else{
    print ("Your friends have not started sharing with you yet. Either
    they are not in the network yet (Take the opportunity to INVITE
    THEM!) or they are not aware that you are a member now (let them know!).<br>");
  }
  print("<h3>"._MY_CONTRIBUTION."</h3>");
  //print("<h3>My collection: </h3>");
  $query = "SELECT * FROM ".TBL_INVENTORY." WHERE sourceid='$username'";
  $results=$database->query($query);
  list_title_and_type($results);
}

function print_error($string){
    print("<p class=error>".$string."</p>");
}
function print_error_report_line(){
   print("<br>If you think there is an error. Please contact admin@".SITE_ADDRESS);
}
?>