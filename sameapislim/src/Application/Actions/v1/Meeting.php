<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
use MrShan0\PHPFirestore\FirestoreDocument;

class Meeting
{

  public function __construct() {
  }

  public function get( Request $request, Response $response, $args )  {

    if (isset($args["idmeeting"])) {
        $fireStore = new FireStore();
        $data = $fireStore->getDocument( "meetings", $args["idmeeting"] ) ;
        // print_r($data);
        // echo "<hr>";
        return [
            "title" => "Summary of meeting data",
            "edit" => "",
            "apiupdate" => "",
            "items" => [
              [
                "id" => "1",
                "type" => "text",
                "value" => $data["name"],
                "description" => "name",
              ],
              [
                "id" => "1",
                "type" => "text",
                "value" => $data["type"],
                "description" => "type",
              ],
              [
                "id" => "1",
                "type" => "text",
                "value" => $data["start"]->formatAsString(),
                "description" => "Data",
              ],
              [
                "id" => "1",
                "type" => "text",
                "value" => $data["color"],
                "description" => "color",
              ],
            ]
        ];

    } else {
        return array();
    }

  }

  /*** UTILIZZO quello in note.php per essere più veloce
  public function updateNote( $idmeeting , $value )  {
        $fireStore = new FireStore();
        $temp = [
            ['path' => 'note', 'value' => $value ]
        ];
        $fireStore->updateDocument( "meetings", $idmeeting, $temp);
  }
   */

  public function getMockup()  {

      $jsondata = '{
         "title":"Summary of meeting data",
         "edit":"https://api.sameapp.net/api/v1/getagenda.php?edit=0",
         "apiupdate":"",
         "items":[
            {
               "id":"1",
               "type":"text",
               "value":"",
               "description":"Data: 2022-10-20 22:00:01"
            }
         ]
      }';
      return json_decode($jsondata, true);
  }


}
