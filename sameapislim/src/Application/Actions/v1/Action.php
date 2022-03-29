<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
// use MrShan0\PHPFirestore\FirestoreDocument;

class Action
{

    public function __construct() {
    }

    // NON USATA ANCORA ...
    public function get( Request $request, Response $response, $args )  {
      $fireStore = new FireStore();
      $result = $fireStore->getDocument( "action", "303128bd5c51478fb24d" ) ;
    }


    public function insert( Request $request, Response $response, $args )  {
      $fireStore = new FireStore();
      $fireStore->addDocument( "timelines", $this->setDocument( $request ) );
      return json_decode( '{"state":"200"}', true);
    }

    public function setDocument( Request $request )  {
        $requestArrayParam = $request->getParsedBody();
        $idmeeting = "";
        $second = "";
        $secondmanual = "";
        $value = "";
        $action = "";
        $user = "";
        if (isset($requestArrayParam["idmeeting"])) {
            $idmeeting = $requestArrayParam["idmeeting"];
        }
        if (isset($requestArrayParam["second"])) {
            $second = $requestArrayParam["second"];
        }
        if (isset($requestArrayParam["secondmanual"])) {
            $secondmanual = $requestArrayParam["secondmanual"];
        }
        if (isset($requestArrayParam["action"])) {
            $action = $requestArrayParam["action"];
        }
        if (isset($requestArrayParam["value"])) {
            $value  = $requestArrayParam["value"];
        }
        if (isset($requestArrayParam["user"])) {
            $user  = $requestArrayParam["user"];
        }
        return array(
            "idmeeting" => $idmeeting,
            "second" => $second,
            "secondmanual" => $secondmanual,
            "value" => $value,
            "action" => $action,
            "user" => $user,
            "type" => "shortcut",
            "date" =>  time(), /*  date("Y-m-d H:i:s"), */
        );
    }

    public function getDocument( $result )  {
        return array(
            "idmeeting" => $result->get('idmeeting'),
            "second" => $result->get('second'),
            "secondmanual" => $result->get('secondmanual'),
            "value" => $result->get('value'),
            "date" => $result->get('date'),
        );
    }

}
