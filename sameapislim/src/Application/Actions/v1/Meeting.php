<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;

class Meeting
{

  private $collection_name = "meetings";

  public function __construct() {
  }

  public function init( Request $request, Response $response, $args )  {

      if (isset($args["idmeeting"])) {

          $idmeeting = $args["idmeeting"];
          $user = $args["user"];
          $fireStore = new FireStore();
          $data = $fireStore->getDocument( $this->collection_name, $idmeeting ) ;
          if ($data["init"]=="") {
              $temp = [
                  ['path' => 'init', 'value' => date("Y-m-d H:i:s")]
              ];
              $fireStore->updateDocument( $this->collection_name, $idmeeting, $temp);
              return json_decode( '{"state":"200","init":""}', true);
          } else {
              return json_decode( '{"state":"200","init":"' . $data["init"] . '"}', true);
          }
      }
      return json_decode( '{"state":"200","init":""}', true);

  }

  public function get( Request $request, Response $response, $args )  {

    if (isset($args["idmeeting"])) {
        $fireStore = new FireStore();
        $data = $fireStore->getDocument( $this->collection_name, $args["idmeeting"] ) ;
        return [
            "title" => "Summary of meeting data",
            "edit" => "",
            "apiupdate" => "",
            "viewdescription" => "1",
            "items" => [
              [
                "id" => "1",
                "type" => "text",
                "value" => $data["name"],
                "description" => "Title",
              ],
              [
                "id" => "1",
                "type" => "text",
                "value" => $data["type"],
                "description" => "Type",
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
                "value" => $args["idmeeting"],
                "description" => "Id",
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
