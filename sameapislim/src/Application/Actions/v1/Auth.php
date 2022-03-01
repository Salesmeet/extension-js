<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;
// use MrShan0\PHPFirestore\FirestoreDocument;

class Auth
{

    public function __construct() {
    }

    public function auth( Request $request, Response $response, $args )  {

      echo "auth<hr>";
      $fireStore = new FireStore();
      $result = $fireStore->login() ;

    }

}
