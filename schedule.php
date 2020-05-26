<?php
function print_classes_list($title, $list){
  echo "<h2>$title</h2>";
  echo "<ul>";
  foreach($list as $a){
    echo "<li>".$a."</li>";
  }
  echo "</ul>";
}
function print_classes($title, $list){
  echo "<h2>$title</h2>";
  //echo "<ul>";
  foreach($list as $a){
    echo $a."<br/>";
  }
  //echo "</ul>";
}

$DB_HOST="localhost";
$DB_PORT='3306';
$DB_DATABASE='l5studio';
$DB_USERNAME='l5studio';
$DB_PASSWORD='qingfeng';
// $DB_DATABASE='teststudio';
// $DB_USERNAME='root';
// $DB_PASSWORD='';
$conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD,$DB_DATABASE);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";
// $today=date('Y-m-d');
// $sql="SELECT * FROM l5_study_groups WHERE ending_date> date '$today' AND status='public' AND deleted_at IS NULL ORDER BY title ASC";
//$today=date('Y-m-d');
$sql="SELECT * FROM l5_study_groups WHERE semester_id=4 AND status='public' AND deleted_at IS NULL ORDER BY title ASC";

//echo $sql;

$link=$conn;

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

      // print_classes('Kid Classes', $kids);
      // print_classes('Adult Classes', $adults);
      //print_classes('Other Classes', $others);

        // echo "<table>";
        //     echo "<tr>";
        //         echo "<th>id</th>";
        //         echo "<th>title</th>";
        //         echo "<th>ending_date</th>";
        //     echo "</tr>";
        //
        //     echo "<tr>";
        //         echo "<td>" . $row['id'] . "</td>";
        //         echo "<td>" . $row['title'] . "</td>";
        //         echo "<td>" . $row['ending_date'] . "</td>";
        //     echo "</tr>";
        // }
        // echo "</table>";
        // Close result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
// Close connection
mysqli_close($link);

?>

<div class="row">
  <div class="col-sm-12">
    <div class="well">
     <p>
      <table width="100%">
        <tr>
        <td valign=top>
 <?php
 print_classes('Kid Classes', $kids);
 ?>
</td>
<td valign=top>
 <?php print_classes('Adult Classes', $adults); ?>
  </td>
  </tr>
  </table>
     </p>
    </div>
  </div>
</div>
