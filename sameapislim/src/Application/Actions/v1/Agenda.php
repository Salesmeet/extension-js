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
  private $action_task_delete = "tasksDelete";
  private $action_task_insert = "tasksInsert";

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


  public function insert( Request $request, Response $response, $args )  {

      $fireStore = new FireStore();
      $document = $this->setDocumentTask( $request, $this->action_task_insert );
      // loggo azione
      $fireStore->addDocument( $this->collection_name_action, $document );
      // Prendo tutto l'elenco dei attendees
      $data = $fireStore->getDocument( $this->collection_name, $document["idmeeting"] ) ;
      // Creo nuovo utente
      $taskNew = [
          "image" => "",
          "name" => $document["value"],
          "checked" => "1",
      ];
      // Creo l'elenco dei attendees con il checked aggioranto
      $tasks = $this->getTasksUpdate($data,99999,1,$taskNew,null);
      // update tuttu l'elenco
      $temp = [
          ['path' => 'tasks', 'value' => $tasks]
      ];
      $fireStore->updateDocument( $this->collection_name, $document["idmeeting"], $temp);
      return json_decode( '{"state":"200"}', true);
  }

  public function delete( Request $request, Response $response, $args )  {
      $fireStore = new FireStore();
      $document = $this->setDocumentTask( $request , $this->action_task_delete );
      // loggo azione
      $fireStore->addDocument( $this->collection_name_action, $document );
      // Prendo tutto l'elenco dei attendees
      $data = $fireStore->getDocument( $this->collection_name, $document["idmeeting"] ) ;
      // Creo l'elenco dei attendees con il checked aggioranto
      $tasks = $this->getTasksUpdate($data,99999,1,null, $document["id"] );
      // update tuttu l'elenco
      $temp = [
          ['path' => 'tasks', 'value' => $tasks]
      ];
      $fireStore->updateDocument( $this->collection_name, $document["idmeeting"], $temp);
      return json_decode( '{"state":"200"}', true);
  }

  public function check( Request $request, Response $response, $args )  {

      $document = $this->setDocumentTask( $request, $this->action_task_check );
      if ($document["idmeeting"]!="") {

          // Aggiungo log
          $fireStore = new FireStore();
          $fireStore->addDocument( $this->collection_name_action, $document );

          // Prendo tutto l'elenco dei tasks
          $data = $fireStore->getDocument( $this->collection_name, $document["idmeeting"] ) ;
          // Creo l'elenco dei tasks con il checked aggioranto
          $tasks = $this->getTasksUpdate($data,$document["id"],$document["value"],null,null);
          // Update per idmeeting i tasks aggiornati
          $temp = [
              ['path' => 'tasks', 'value' => $tasks]
          ];
          $fireStore->updateDocument( $this->collection_name, $document["idmeeting"], $temp);

      }
      return json_decode( '{"state":"200"}', true);

  }


  public function setDocumentTask( Request $request, $action )  {
      $common = new Common();
      return $common->setDocument( $request, $action );
  }

  public function getTasks($data)  {
    $common = new Common();
    return $common->getMeetingSubset( $data, "tasks" );
  }

  public function getTasksUpdate($data, $id, $checked, $attendeeNew, $attendeeDelete )  {
      $common = new Common();
      return $common->getMeetingSubsetUpdate($data, $id, $checked, $attendeeNew, $attendeeDelete, "tasks"  ) ;
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
