<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Application\Actions\FireStore;

class Note
{


    private $collection_name = "note";
    private $collection_name_meetings = "meetings";


    public function __construct() {
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
          echo $args["idmeeting"];
          $fireStore = new FireStore();
          $data = $fireStore->getDocumentsByQuery( $this->collection_name, "idmeeting", "==" , $args["idmeeting"]);
          // print_r($data);
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
            "date" => date("Y-m-d H:i:s"),
        );
    }

}
