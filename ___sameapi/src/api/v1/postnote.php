<?
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');

$value = htmlspecialchars($_POST["value"]);

$myfile = fopen("../../api/temp/note.txt", "w") or die("Unable to open file!");
$txt = $value;
fwrite($myfile, $txt);
fclose($myfile);

?>
