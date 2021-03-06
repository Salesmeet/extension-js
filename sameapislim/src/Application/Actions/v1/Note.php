<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Application\Actions\FireStore;
use Google\Cloud\Core\Timestamp;
use \Datetime;

class Note
{


    private $collection_name = "note";
    private $collection_name_meetings = "meetings";


    public function __construct() {
    }

    public function getById( Request $request, Response $response, $args )  {

        if (isset($args["idnote"])) {
            $fireStore = new FireStore();
            $data = $fireStore->getDocument( $this->collection_name, $args["idnote"] ) ;
            return [
                "note" => $data["value"]
            ];
        }
        return json_decode( '{"state":"400","value":"not record"}', true);
    }

    public function getLast( Request $request, Response $response, $args )  {
        if (isset($args["idmeeting"])) {
            $fireStore = new FireStore();
            $data = $fireStore->getDocument( $this->collection_name_meetings, $args["idmeeting"] ) ;
            return [
                "note" => $data["note"]
            ];
        }
        return json_decode( '{"state":"400","value":"not record"}', true);
    }

    public function getAll( Request $request, Response $response, $args )  {
      $data = $this->setDocument( $request );
      if (isset($args["idmeeting"])) {
          $fireStore = new FireStore();
          $data = $fireStore->getDocumentsByQuery( $this->collection_name, "idmeeting", "==" , $args["idmeeting"]);

          $notes = array();
          foreach ($data as $document) {
              $temp = [
                  "id" => $document->id(),
                  "date" => $document->data()["date"],
              ];
              array_push($notes,$temp);
              /*
              $data = $document->data();
              echo $document->id();
              echo $data["date"];
              */
          }
          return $notes;
      }
      return json_decode( '{"state":"200","value":"not add"}', true);
    }


    public function insert( Request $request, Response $response, $args )  {

      $data = $this->setDocument( $request );
      if ($data["value"]!="") {

              $fireStore = new FireStore();
              // inserisco nota nei log
              $fireStore->addDocument( $this->collection_name, $data );

              // inserisco nota nel meeting
              $temp = [ ['path' => 'note', 'value' => $data["value"]] ];
              $fireStore->updateDocument( $this->collection_name_meetings, $data["idmeeting"], $temp);

      }
      return json_decode( '{"state":"200","value":"not add"}', true);
    }

    public function setDocument( Request $request )  {
        $requestArrayParam = $request->getParsedBody();
        $idmeeting = "";
        $value = "";
        $user = "";
        if (isset($requestArrayParam["idmeeting"])) {
            $idmeeting = $requestArrayParam["idmeeting"];
        }
        if (isset($requestArrayParam["value"])) {
            $value  = $requestArrayParam["value"];
        }
        if (isset($requestArrayParam["user"])) {
            $user  = $requestArrayParam["user"];
        }
        return array(
            "idmeeting" => $idmeeting,
            "value" => $value,
            "user" => $user,
            "date" =>  new Timestamp(new DateTime()), //time(), // date("Y-m-d H:i:s"),
        );
    }

}
