<?
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');

$value = htmlspecialchars($_POST["value"]);
$action = htmlspecialchars($_POST["action"]);
$seconddefault = htmlspecialchars($_POST["seconddefault"]);
$secondmanual = htmlspecialchars($_POST["secondmanual"]);
$idmeeting = htmlspecialchars($_POST["idmeeting"]);

if ($action!="") {
  $array = [
      "idmeeting" => $idmeeting,
      "second" => $seconddefault,
      "secondmanual" => $secondmanual,
      "action" => $action,
      "value" => $value,
  ];
  $myfile = fopen("../../api/temp/action.txt", "a") or die("Unable to open file!");
  fwrite($myfile, json_encode($array) . "\n");
  fclose($myfile);
}

?>
