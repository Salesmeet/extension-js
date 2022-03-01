<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
use MrShan0\PHPFirestore\FirestoreDocument;

class Partecipants
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
        print_r($data["attendees"]);
        echo "<hr>";
        */
        $i = 0;
        $attendees = array();
        foreach ($data["attendees"] as $attendee) {
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
         "title":"Partecipant list",
         "edit":"https://api.sameapp.net/api/v1/getlistuser.php?edit=0",
         "apiupdate":"https://api.sameapp.net/api/v1/updatetlistuser.php",
         "items":[
            {
               "id":"1",
               "type":"checkbox",
               "value":"0",
               "description":"Corrado Facchini"
            },
            {
               "id":"2",
               "type":"checkbox",
               "value":"0",
               "description":"Federico Remiti"
            },
            {
               "id":"3",
               "type":"checkbox",
               "value":"0",
               "description":"Regina Elisabetta"
            },
            {
               "id":"4",
               "type":"checkbox",
               "value":"0",
               "description":"Maurizio ..."
            }
         ]
      }';
      return json_decode($jsondata, true);
  }


}
