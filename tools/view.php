<?
include("html.form.func.php");

$arr=array(
"Class 1"=> array("key1"=>"value1","key2"=>"value2"),
"Class 2"=> array("key3"=>"value3","key4"=>"value4")
);

prt_dropdownbox_tiered("Test",$arr);

print "<hr>";

$arr2=array(
	"v1"=>"Item 1",
	"v2"=>"Item 2",
	"v3"=>"Item 3"
);

prt_checkbox_list($arr2);


?>