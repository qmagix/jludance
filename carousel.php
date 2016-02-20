<?php
//get the image folder information
$directory = 'images/sliders';
//get a list of all jpgs in the folder
//$files = array_diff(scandir($directory), array('..', '.'));
$files = array();
foreach (glob("images/sliders/*.JPG") as $file) {
  $files[] = $file;
}
$num_images=count($files);

$text_array = parse_ini_file("sliders.ini", true);
$num_slogans=count($text_array);
?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
<?php
for ($i=1; $i<$num_images; $i++){
?>
      <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
<?php
}
?>
    </ol>
<!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
<?php
$i=0;
foreach ($files as $image){
    $n=$i%$num_slogans;
    $i++;
?>
      <div class="item<?php if($i==1){echo " active";}?>">
        <img src="<?php echo $image;?>" alt="Image">
        <div class="carousel-caption">
          <h3><?php echo $text_array["slider".$n]["title"];?></h3>
          <p><?php echo $text_array["slider".$n]["content"];?></p>
          <a href="<?php echo $text_array["slider".$n]["action_url"];?>" class="btn btn-info btn-lg active" role="button"><?php echo $text_array["slider".$n]["action_text"];?></a>
        </div>
      </div>
<?php
}
?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>
