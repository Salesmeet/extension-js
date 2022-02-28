<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Application\Actions\FireStore;

class Note
{

    public function __construct() {
    }

    public function insert( Request $request, Response $response, $args )  {

      $fireStore = new FireStore();
      $fireStore->addDocument( "note", $this->setDocument( $request ) );
      return json_decode( '{"state":"200"}', true);

    }

    public function setDocument( Request $request )  {
        $requestArrayParam = $request->getParsedBody();
        $idmeeting = "";
        $value = "";
        if (isset($requestArrayParam["idmeeting"])) {
            $idmeeting = $requestArrayParam["idmeeting"];
        }
        if (isset($requestArrayParam["value"])) {
            $value  = $requestArrayParam["value"];
        }
        return array(
            "idmeeting" => $idmeeting,
            "value" => $value,
            "date" => date("Y-m-d H:i:s"),
        );
    }

}
