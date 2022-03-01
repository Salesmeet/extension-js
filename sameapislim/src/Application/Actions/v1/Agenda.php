<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
use MrShan0\PHPFirestore\FirestoreDocument;

class Agenda
{

  public function __construct() {
  }

  public function get( Request $request, Response $response, $args )  {

    if (isset($args["idmeeting"])) {
        $fireStore = new FireStore();
        $data = $fireStore->getDocument( "meetings", $args["idmeeting"] ) ;
        /*
        print_r($data);
        echo "<hr>";
        print_r($data["tasks"]);
        echo "<hr>";
        */
        $attendees = array();
        $i = 0;
        foreach ($data["tasks"] as $attendee) {
            $attendee = [
                "id" => $i,
                "type" => "text",
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
            "edit" => "",
            "apiupdate" => "",
            "items" => $attendees
        ];

    } else {
        return array();
    }

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
            },
            {
               "id":"2",
               "type":"checkbox",
               "value":"1",
               "description":"Participants presentation"
            },
            {
               "id":"3",
               "type":"checkbox",
               "value":"1",
               "description":"Reading the agenda of the day"
            },
            {
               "id":"4",
               "type":"checkbox",
               "value":"0",
               "description":"Project introduction"
            },
            {
               "id":"5",
               "type":"checkbox",
               "value":"0",
               "description":"Slide presentation"
            },
            {
               "id":"6",
               "type":"checkbox",
               "value":"0",
               "description":"..."
            },
            {
               "id":"7",
               "type":"checkbox",
               "value":"0",
               "description":"..."
            },
            {
               "id":"8",
               "type":"checkbox",
               "value":"0",
               "description":"..."
            },
            {
               "id":"9",
               "value":"0",
               "type":"checkbox",
               "description":"..."
            }
         ]
      }';
      return json_decode($jsondata, true);
      /*
      $result[] = array(
          "comune" => "aaaaa"
      );
      return $result;
      */
  }


}
