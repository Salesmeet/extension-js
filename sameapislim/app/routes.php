<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

/*
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Firestore;
use Google\Cloud\Firestore\FirestoreClient;
*/

use App\Application\Actions\v1\Common;
use App\Application\Actions\v1\Users;
use App\Application\Actions\v1\Meeting;
use App\Application\Actions\v1\Agenda;
use App\Application\Actions\v1\Partecipants;
use App\Application\Actions\v1\Attachements;
use App\Application\Actions\v1\Action;
use App\Application\Actions\v1\Note;
use App\Application\Actions\v1\Auth;


return function (App $app) {

    $app->options('/{routes:.*}', function ($request, $response, $args) {
        return $response;
    });


    $app->get('/public/', function (Request $request, Response $response) {
        $response->getBody()->write('Same APP!');
        return $response;
    });

    /*
    $app->post('/public/v1/login', function (Request $request, Response $response, $args) {
        $action = new Action();
        return setResponse($response, $action->insert($request, $response, $args) );
    });
    */

    $app->post('/public/v1/action', function (Request $request, Response $response, $args) {
        $action = new Action();
        return setResponse($response, $action->insert($request, $response, $args) );
    });
    $app->post('/public/v1/note', function (Request $request, Response $response, $args) {
        $note = new Note();
        return setResponse($response, $note->insert($request, $response, $args) );
    });



    $app->get('/public/v1/meeting/{idmeeting}/{lang}', function (Request $request, Response $response, $args) {
        $meeting = new Meeting();
        return setResponse($response, $meeting->get($request, $response, $args) );
    });
    $app->get('/public/v1/agenda/{idmeeting}/{lang}', function (Request $request, Response $response, $args) {
        $agenda = new Agenda();
        return setResponse($response, $agenda->get($request, $response, $args) );
    });
    $app->get('/public/v1/attachements/{idmeeting}/{lang}', function (Request $request, Response $response, $args) {
        $attachements = new Attachements();
        return setResponse($response, $attachements->get($request, $response, $args) );
    });
    $app->get('/public/v1/partecipants/{idmeeting}/{lang}', function (Request $request, Response $response, $args) {
        $partecipants = new Partecipants();
        return setResponse($response, $partecipants->get($request, $response, $args) );
    });

    $app->get('/public/v1/test/', function (Request $request, Response $response, $args) {

          if (isset($args["idmeeting"])) {
              echo $args["idmeeting"] . "<br>";
          }
          echo '<hr>';
          $requestArrayParam = $request->getParsedBody();
          if (isset($requestArrayParam["idmeeting"])) {
              echo $requestArrayParam["idmeeting"] . "<br>";
          }
          echo '<hr>';
          $meeting = new Meeting();
          $meeting->get($request, $response, $args);

          echo '<hr>';

          /*

          $action = new Action();
          $action->get($request, $response, $args);

          echo '<hr>';

          $auth = new Auth();
          $auth->auth($request, $response, $args);

            */

        echo '<form action="https://api.sameapp.net/public/v1/action" method="post">';
          echo '<input name="idmeeting" id="idmeeting" value="1">';
          echo '<input name="second" id="second" value="1">';
          echo '<input name="secondmanual" id="secondmanual" value="1">';
          echo '<input name="action" id="action" value="1">';
          echo '<input name="value" id="value" value="1">';
          echo '<input type="submit">';
        echo '</form>';


        echo '<form action="https://api.sameapp.net/public/v1/action" method="post">';
          echo '<input name="user" id="user" value="corrado@salesmeet.ai">';
          echo '<input name="password" id="password" value="password">';
          echo '<input type="submit">';
        echo '</form>';

        $response->getBody()->write( "" );
        return $response;

    });

    /*
    $app->post('/public/v1/test/{id}', function (Request $request, Response $response, $args) {


    // $id = $args['id'];
    // echo $id . " <br>";

        $requestArrayParam = $request->getParsedBody();
        if (isset($requestArrayParam["be"])) {
            echo $requestArrayParam["be"] . "<br>";
        }
        echo '<a href="https://api.sameapp.net/public/v1/test/12">';
          echo 'get';
        echo '</a>';
        $response->getBody()->write('<hr>Test!');
        return $response;
    });
    */

    function setResponse(Response $response, $message) {
      $common = new Common();
      $result = $common->getOutputMessage($message);
      // $response->setStatus(200);
      $response->withStatus(200)->withHeader('Content-type', 'application/json');
      $response->getBody()->write($result);
      // print_r($response);
      return $response;
    }


};
