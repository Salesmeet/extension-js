<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
use MrShan0\PHPFirestore\FirestoreDocument;

class Partecipants
{

  private $collection_name = "meetings";
  private $collection_name_action = "meetings_action";
  private $action_attendees_check = "attendeesChecked";

  public function __construct() {
  }

  public function get( Request $request, Response $response, $args )  {

    if (isset($args["idmeeting"])) {
        $fireStore = new FireStore();
        $data = $fireStore->getDocument( $this->collection_name , $args["idmeeting"] ) ;
        $i = 0;
        $attendees = $this->getAttendees($data);
        foreach ($data["attendees"] as $attendee) {
            $attendee = [
                "id" => $i,
                "type" => "checkbox",
                "value" => $attendee["name"],
                "description" => "name",
            ];
            array_push($attendees,$attendee);
            $i++;
            // print_r($attendee["name"]);
            // echo "<hr>";
        }
        return [
            "title" => "Partecipant list",
            "edit" => "qqqq",
            "apiupdate" => "https://api.sameapp.net/public/v1/partecipants/check",
            "items" => $attendees
        ];

    } else {
        return array();
    }

  }

  public function check( Request $request, Response $response, $args )  {

      $document = $this->setDocumentAttendees( $request );
      if ($document["idmeeting"]!="") {

          // Aggiungo log
          $fireStore = new FireStore();
          $fireStore->addDocument( $this->collection_name_action, $document );

          // Prendo tutto l'elenco dei attendees
          $data = $fireStore->getDocument( $this->collection_name, $document["idmeeting"] ) ;
          // Creo l'elenco dei attendees con il checked aggioranto
          $attendees = $this->getAttendeesUpdate($data,$document["id"],$document["value"]);

          // Update per idmeeting gli attendees aggiornati
          $temp = [
              ['path' => 'attendees', 'value' => $attendees]
          ];
          $fireStore->updateDocument( $this->collection_name, $document["idmeeting"], $temp);

      }
      return json_decode( '{"state":"200"}', true);

  }

  public function setDocumentAttendees( Request $request )  {
      $requestArrayParam = $request->getParsedBody();
      $idmeeting = "";
      $id = "";
      $checked = "";
      if (isset($requestArrayParam["idmeeting"])) {
          $idmeeting = $requestArrayParam["idmeeting"];
      }
      if (isset($requestArrayParam["id"])) {
          $id = $requestArrayParam["id"];
      }
      if (isset($requestArrayParam["checked"])) {
          $checked = $requestArrayParam["checked"];
      }
      return array(
          "idmeeting" => $idmeeting,
          "id" => $id,
          "action" => $this->action_attendees_check,
          "value" => $checked,
          "date" => date("Y-m-d H:i:s"),
      );
  }

  public function getAttendees($data)  {
      $checked_master = $checked;
      $attendees = array();
      $i = 0;
      foreach ($data["attendees"] as $attendee) {

          // Se non ho il campo checked lo creo
          if ($attendee["checked"]=="") {
              $checked = 0;
          } else {
              $checked = $attendee["checked"];
          }
          $attendee = [
              "id" => $i,
              "type" => "checkbox",
              "value" => $attendee["name"],
              "description" => "",
              "checked" => $checked,
          ];
          array_push($attendees,$attendee);
          $i++;
      }
      return $attendees;
  }

  public function getAttendeesUpdate($data, $id, $checked)  {
      $checked_master = $checked;
      $attendees = array();
      $i = 0;
      foreach ($data["attendees"] as $attendee) {
          // Controllo di modiifcare solo il attendees corretto
          if ($i != $id) {
              // Se non ho il campo checked lo creo
              if ($attendee["checked"]=="") {
                  $checked = 0;
              } else {
                  $checked = $attendee["checked"];
              }
          } else {
              // assegno il valore di checked dal frontend
              $checked = $checked_master;
          }
          $attendee = [
              "image" => $attendee["image"],
              "name" => $attendee["name"],
              "checked" => $checked,
          ];
          array_push($attendees,$attendee);
          $i++;
      }
      return $attendees;
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
