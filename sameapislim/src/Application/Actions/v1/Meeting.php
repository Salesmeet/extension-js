<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
use App\Application\Actions\v1\Common;

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
          // print_r($data);
          if ($data["init"]=="") {
              $temp = [
                  ['path' => 'init', 'value' => date("Y-m-d H:i:s")]
              ];
              $fireStore->updateDocument( $this->collection_name, $idmeeting, $temp);
              return json_decode( '{"state":"200","init":"","type":"' . $data["type"] . '"}', true);
          } else {
              return json_decode( '{"state":"200","init":"' . $data["init"] . '","type":"' . $data["type"] . '"}', true);
          }
      }
      return json_decode( '{"state":"200","init":""}', true);

  }

  public function get( Request $request, Response $response, $args )  {

    if (isset($args["idmeeting"])) {
        $fireStore = new FireStore();
        $data = $fireStore->getDocument( $this->collection_name, $args["idmeeting"] ) ;
        $start = "";
        if ($data["start"]!="") {
            $start  = $data["start"]->formatAsString();
        }
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
                "value" => $start,
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


   public function insert( Request $request, Response $response, $args )  {

     $data = $this->setDocumentInsert( $request );
     $fireStore = new FireStore();
     $fireStore->addDocument( $this->collection_name,  $data );
     return json_decode( '{"state":"200","idmeeting":"' .  $this->getByUniqid( $data["uniqid"] ) . '"}', true);

   }

   public function getByUniqid( $uniqid )  {
         $fireStore = new FireStore();
         $data = $fireStore->getDocumentsByQuery( $this->collection_name, "uniqid", "==" ,  $uniqid );
         $records = array();
         foreach ($data as $document) {
           return  $document->id();
         }
         return "";
   }

   public function getByURL( Request $request, Response $response, $args )  {

       /*
       $common = new Common();
       $origin = $common->getOrigin($request);
       return $common->getOrigin($request);
       */
       // if ($origin != "") {page
       $requestArrayParam = $request->getParsedBody();
       if (isset( $requestArrayParam["page"] )) {
           $origin =  $requestArrayParam["page"];
           $fireStore = new FireStore();
           $data = $fireStore->getDocumentsByQuery( $this->collection_name, "url", "==" , $origin );
           $records = array();
           foreach ($data as $document) {
               return array("id" => $document->id());
           }
       }
       return array("id" => "");
   }


   public function setDocumentInsert( Request $request )  {
       $requestArrayParam = $request->getParsedBody();
       $name = "";
       $type = "";
       $lang = "";
       $user = "";
       $url = "";
       $uniqid = "";
       if (isset($requestArrayParam["name"])) {
           $name = $requestArrayParam["name"];
       }
       if (isset($requestArrayParam["type"])) {
           $type = $requestArrayParam["type"];
       }
       if (isset($requestArrayParam["lang"])) {
           $lang = $requestArrayParam["lang"];
       }
       if (isset($requestArrayParam["user"])) {
           $user = $requestArrayParam["user"];
       }
       if (isset($requestArrayParam["url"])) {
           $url  = $requestArrayParam["url"];
       }
       /*
       $common = new Common();
       $origin = $common->getOrigin($request);
       if ($origin!="") {
         $url = $origin;
       }
       */
       if (isset($requestArrayParam["uniqid"])) {
           $uniqid  = $requestArrayParam["uniqid"];
       }
       return array(
           "name" => $name,
           "type" => $type,
           "lang" => $lang,
           "user" => $user,
           "url" => $url,
           "date" => date("Y-m-d H:i:s"),
           "uniqid" => $uniqid,
       );
   }

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
