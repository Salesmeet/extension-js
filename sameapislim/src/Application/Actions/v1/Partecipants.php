<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
use App\Application\Actions\v1\Common;
use MrShan0\PHPFirestore\FirestoreDocument;

class Partecipants
{

  private $collection_name = "meetings";
  private $collection_name_action = "meetings_action";
  private $action_attendees_check = "attendeesChecked";
  private $action_attendees_delete = "attendeesDelete";
  private $action_attendees_insert = "attendeesInsert";

  public function __construct() {
  }

  public function get( Request $request, Response $response, $args )  {

    if (isset($args["idmeeting"])) {
        $fireStore = new FireStore();
        $data = $fireStore->getDocument( $this->collection_name , $args["idmeeting"] ) ;
        return [
            "title" => "Partecipant list",
            "edit" => "partecipant",
            "apiupdate" => "https://api.sameapp.net/public/v1/partecipants/check",
            "viewdescription" => "0",
            "items" => $this->getAttendees($data)
        ];

    } else {
        return array();
    }

  }


  public function insert( Request $request, Response $response, $args )  {
      $fireStore = new FireStore();
      $document = $this->setDocumentAttendees( $request, $this->action_attendees_insert);
      // loggo azione
      $fireStore->addDocument( $this->collection_name_action, $document );
      // Prendo tutto l'elenco dei attendees
      $data = $fireStore->getDocument( $this->collection_name, $document["idmeeting"] ) ;
      // Creo nuovo utente
      $attendeeNew = [
          "image" => "",
          "name" => $document["value"],
          "email" => $document["email"],
          "checked" => "1",
      ];
      // Creo l'elenco dei attendees con il checked aggioranto
      $attendees = $this->getAttendeesUpdate($data,99999,1,$attendeeNew,null);
      // update tuttu l'elenco
      $temp = [
          ['path' => 'attendees', 'value' => $attendees]
      ];
      $fireStore->updateDocument( $this->collection_name, $document["idmeeting"], $temp);
      return json_decode( '{"state":"200"}', true);
  }


  public function delete( Request $request, Response $response, $args )  {
      $fireStore = new FireStore();
      $document = $this->setDocumentAttendees( $request, $this->action_attendees_delete);
      // loggo azione
      $fireStore->addDocument( $this->collection_name_action, $document );
      // Prendo tutto l'elenco dei attendees
      $data = $fireStore->getDocument( $this->collection_name, $document["idmeeting"] ) ;
      // Creo l'elenco dei attendees con il checked aggioranto
      $attendees = $this->getAttendeesUpdate($data,99999,1,null, $document["id"] );
      // update tuttu l'elenco
      $temp = [
          ['path' => 'attendees', 'value' => $attendees]
      ];
      $fireStore->updateDocument( $this->collection_name, $document["idmeeting"], $temp);
      return json_decode( '{"state":"200"}', true);
  }


  public function check( Request $request, Response $response, $args )  {

      $document = $this->setDocumentAttendees( $request, $this->action_attendees_check );
      if ($document["idmeeting"]!="") {

          // Aggiungo log
          $fireStore = new FireStore();
          $fireStore->addDocument( $this->collection_name_action, $document );

          // Prendo tutto l'elenco dei attendees
          $data = $fireStore->getDocument( $this->collection_name, $document["idmeeting"] ) ;
          // Creo l'elenco dei attendees con il checked aggioranto
          $attendees = $this->getAttendeesUpdate($data,$document["id"],$document["value"],null,null);

          // Update per idmeeting gli attendees aggiornati
          $temp = [
              ['path' => 'attendees', 'value' => $attendees]
          ];
          $fireStore->updateDocument( $this->collection_name, $document["idmeeting"], $temp);

      }
      return json_decode( '{"state":"200"}', true);

  }


  public function getAttendees($data)  {
    $common = new Common();
    return $common->getMeetingSubset( $data, "attendees" );
  }

  public function setDocumentAttendees( Request $request, $action )  {
      $common = new Common();
      return $common->setDocument( $request, $action );
  }

  public function getAttendeesUpdate($data, $id, $checked, $attendeeNew, $attendeeDelete )  {
      $common = new Common();
      return $common->getMeetingSubsetUpdate($data, $id, $checked, $attendeeNew, $attendeeDelete, "attendees"  ) ;
  }

  public function getMockup()  {

      $jsondata = '{
         "title":"Partecipant list",
         "edit":"https://api.sameapp.net/api/v1/getlistuser.php?edit=0",
         "apiupdate":"https://api.sameapp.net/api/v1/updatetlistuser.php",
         "items":[
            {
               "id":"1",
               "type":"checkbox",
               "value":"0",
               "description":"Corrado Facchini"
            }
         ]
      }';
      return json_decode($jsondata, true);
  }


}
