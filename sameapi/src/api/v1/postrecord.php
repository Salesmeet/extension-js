<?
header("Access-Control-Allow-Origin: *");

$value = $_FILES["file"];
$info = pathinfo($value['name']);

// $ext = $info['extension']; // get the extension of the file
$newname = "newname.mp3";

$target = '../../api/temp/'.$newname;
move_uploaded_file( $_FILES['file'], $target);

?>
