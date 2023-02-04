<?php
function print_classes_list($title, $list){
  echo "<h2>$title</h2>";
  if($list){
    echo "<ul>";
    foreach($list as $a){
      echo "<li>".$a."</li>";
    }
    echo "</ul>";
  }else{
    echo "No schedule yet, stay stuned. ";
  }

}
function print_classes($title, $list){
  echo "<h2>$title</h2>";
  //echo "<ul>";
  if($list){
    foreach($list as $a){
      echo $a."<br/>";
    }
  }else{
    echo "No schedule yet, stay stuned. ";
  }
  //echo "</ul>";
}

function get_classes($link, $semester_id){
  $sql="SELECT * FROM l5_study_groups WHERE semester_id=".$semester_id." AND status='public' AND deleted_at IS NULL ORDER BY title ASC";
  //echo $sql;
  $kids=array();
  $adults=array();
  $others=array();

  if($result = mysqli_query($link, $sql)){
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          if(substr($row['title'] , 0, 11 ) === "Dance Level"){
            $kids[]=$row['title'];
          }else{
            if(substr($row['title'] , 0, 5 ) === "Adult"){
              $adults[]=$row['title'];
            }else{
              $others[]=$row['title'];
            }
          }
        }
        $kids=array_merge($kids,$others);
          mysqli_free_result($result);
      } else{
          //echo "No records matching your query were found.";
          return null;
      }
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
  $result=array(
    'kids'=>$kids,
    'adult'=>$adults,
    'other'=>$others
  );
  return $result;
}


$DB_HOST="localhost";
$DB_PORT='3306';
$DB_DATABASE='l8studio';
$DB_USERNAME='l8studio';
$DB_PASSWORD='qingfenghuang';
// $DB_DATABASE='l5studio';
// $DB_USERNAME='root';
// $DB_PASSWORD='';

$conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD,$DB_DATABASE);
//echo "connected";
//dump($conn);
mysqli_set_charset($conn, "utf8");
//echo "connected1";
$semester1=get_classes($conn,13);
//echo "connected2";
$semester2=get_classes($conn,14);
//echo "connected3";
$semester3=get_classes($conn,15);
//echo "connected4";
mysqli_close($conn);
?>



<ul class="nav nav-tabs">
  <li><a class="nav-link btn btn-primary active" data-toggle="tab" href="#home">Spring 2023</a></li>
  <li><a class="nav-link btn btn-primary" data-toggle="tab" href="#menu1">Summer 2023</a></li>
  <li><a class="nav-link btn btn-primary" data-toggle="tab" href="#menu2">Fall 2023</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane in active">
    <h3>Spring Session</h3>
         <p>
          <table width="100%">
            <tr>
            <td valign=top>
            <?php print_classes('Kid Classes', $semester1['kids']);?>
            </td>
            <td valign=top>
            <?php print_classes('Adult Classes',  $semester1['adult']); ?>
              </td>
              </tr>
          </table>
         </p>
  </div>
  <div id="menu1" class="tab-pane fade">
    <h3>Summer Session</h3>
        <p>
          <table width="100%">
            <tr>
            <td valign=top>
              <?php print_classes('Kid Classes', $semester2['kids']);?>
            </td>
            <td valign=top>
              <?php print_classes('Adult Classes',  $semester2['adult']); ?>
            </td>
            </tr>
          </table>
        </p>
  </div>
  <div id="menu2" class="tab-pane fade">
    <h3>Fall Session</h3>
    <p>
          <table width="100%">
            <tr>
            <td valign=top>
            <?php print_classes('Kid Classes', $semester3['kids']);?>
            </td>
            <td valign=top>
            <?php print_classes('Adult Classes',  $semester3['adult']); ?>
            </td>
            </tr>
          </table>
         </p>
  </div>
</div>


