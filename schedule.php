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
$DB_DATABASE='l5studio';
$DB_USERNAME='l5studio';
$DB_PASSWORD='qingfeng';
// $DB_DATABASE='teststudio';
// $DB_USERNAME='root';
// $DB_PASSWORD='';

$conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD,$DB_DATABASE);

mysqli_set_charset($conn, "utf8");
$semester1=get_classes($conn,7);
$semester2=get_classes($conn,8);
$semester3=get_classes($conn,9);

mysqli_close($conn);
?>


<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link btn btn-primary" id="spring-tab" data-toggle="tab" href="#spring" role="tab" aria-controls="spring" aria-selected="false">Spring</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-primary" id="summer-tab" data-toggle="tab" href="#summer" role="tab" aria-controls="summer" aria-selected="false">Summer</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn active btn-primary" id="fall-tab" data-toggle="tab" href="#fall" role="tab" aria-controls="fall-tab" aria-selected="true">Fall</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade" id="spring" role="tabpanel" aria-labelledby="spring-tab">
    <div class="row">
      <div class="col-sm-12">
        <div class="well">
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
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="summer" role="tabpanel" aria-labelledby="summer-tab">
    <div class="row">
      <div class="col-sm-12">
        <div class="well">
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
      </div>
    </div>
  </div>
  <div class="tab-pane show active" id="fall" role="tabpanel" aria-labelledby="fall-tab">
    <div class="row">
      <div class="col-sm-12">
        <div class="well">
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
    </div>
  </div>
</div>
