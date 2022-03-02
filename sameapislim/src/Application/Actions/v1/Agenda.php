<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
use MrShan0\PHPFirestore\FirestoreDocument;

class Agenda
{

  private $collection_name = "meetings";
  private $collection_name_action = "meetings_action";
  private $action_task_check = "tasksChecked";

  public function __construct() {
  }

  public function get( Request $request, Response $response, $args )  {

    if (isset($args["idmeeting"])) {
        $fireStore = new FireStore();
        $data = $fireStore->getDocument( $this->collection_name, $args["idmeeting"] ) ;
        return [
            "title" => "Agenda list",
            "edit" => "agenda",
            "apiupdate" => "https://api.sameapp.net/public/v1/agenda/check",
            "viewdescription" => "0",
            "items" => $this->getTasks($data)
        ];
    } else {
        return array();
    }

  }

  public function check( Request $request, Response $response, $args )  {

      $document = $this->setDocumentTask( $request );
      if ($document["idmeeting"]!="") {

          // Aggiungo log
          $fireStore = new FireStore();
          $fireStore->addDocument( $this->collection_name_action, $document );

          // Prendo tutto l'elenco dei tasks
          $data = $fireStore->getDocument( $this->collection_name, $document["idmeeting"] ) ;
          // Creo l'elenco dei tasks con il checked aggioranto
          $tasks = $this->getTasksUpdate($data,$document["id"],$document["value"]);

          // Update per idmeeting i tasks aggiornati
          $temp = [
              ['path' => 'tasks', 'value' => $tasks]
          ];
          $fireStore->updateDocument( $this->collection_name, $document["idmeeting"], $temp);

      }
      return json_decode( '{"state":"200"}', true);

  }

  public function setDocumentTask( Request $request )  {
      $requestArrayParam = $request->getParsedBody();
      $idmeeting = "";
      $id = "";
      $checked = "";
      $user = "";
      if (isset($requestArrayParam["idmeeting"])) {
          $idmeeting = $requestArrayParam["idmeeting"];
      }
      if (isset($requestArrayParam["id"])) {
          $id = $requestArrayParam["id"];
      }
      if (isset($requestArrayParam["checked"])) {
          $checked = $requestArrayParam["checked"];
      }
      if (isset($requestArrayParam["second"])) {
          $second = $requestArrayParam["second"];
      }
      if (isset($requestArrayParam["secondmanual"])) {
          $secondmanual = $requestArrayParam["secondmanual"];
      }
      if (isset($requestArrayParam["user"])) {
          $user  = $requestArrayParam["user"];
      }
      return array(
          "idmeeting" => $idmeeting,
          "id" => $id,
          "action" => $this->action_task_check,
          "value" => $checked,
          "second" => $second,
          "secondmanual" => $secondmanual,
          "user" => $user, 
          "date" => date("Y-m-d H:i:s"),
      );
  }

  public function getTasks($data)  {
      $checked_master = $checked;
      $tasks = array();
      $i = 0;
      foreach ($data["tasks"] as $task) {

          // Se non ho il campo checked lo creo
          if ($task["checked"]=="") {
              $checked = 0;
          } else {
              $checked = $task["checked"];
          }
          $task = [
              "id" => $i,
              "type" => "checkbox",
              "value" => $task["name"],
              "description" => "",
              "checked" => $checked,
          ];
          array_push($tasks,$task);
          $i++;
      }
      return $tasks;
  }

  public function getTasksUpdate($data, $id, $checked)  {
      $checked_master = $checked;
      $tasks = array();
      $i = 0;
      foreach ($data["tasks"] as $task) {
          // Controllo di modiifcare solo il task corretto
          if ($i != $id) {
              // Se non ho il campo checked lo creo
              if ($task["checked"]=="") {
                  $checked = 0;
              } else {
                  $checked = $task["checked"];
              }
          } else {
              // assegno il valore di checked dal frontend
              $checked = $checked_master;
          }
          $task = [
              "icon" => $task["icon"],
              "name" => $task["name"],
              "checked" => $checked,
          ];
          array_push($tasks,$task);
          $i++;
      }
      return $tasks;
  }


  public function getMockup()  {

      $jsondata = '{
         "title":"Agenda",
         "edit":"https://api.sameapp.net/api/v1/getagenda.php?edit=0",
         "apiupdate":"",
         "items":[
            {
               "id":"1",
               "type":"checkbox",
               "value":"0",
               "description":"Check participants"
            }
         ]
      }';
      return json_decode($jsondata, true);
  }


}
