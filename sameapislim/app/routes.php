<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;

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
use App\Application\Actions\v1\Record;
use App\Application\Actions\v1\Screenshot;
use App\Application\Actions\v1\Shortcut;
use App\Application\Actions\v1\Converter;

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

    // log delle azioni
    $app->post('/public/v1/action', function (Request $request, Response $response, $args) {
        $action = new Action();
        return setResponse($response, $action->insert($request, $response, $args) );
    });

    // log delle note
    $app->post('/public/v1/note', function (Request $request, Response $response, $args) {
        $note = new Note();
        return setResponse($response, $note->insert($request, $response, $args) );
    });
    // get ultima nota inserita
    $app->get('/public/v1/note/{idmeeting}', function (Request $request, Response $response, $args) {
        $note = new Note();
        return setResponse($response, $note->getLast($request, $response, $args) );
    });
    // get tutte le note inserite per il meeting
    $app->get('/public/v1/note/all/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $note = new Note();
        return setResponse($response, $note->getAll($request, $response, $args) );
    });
    // get  nota inserita per ID
    $app->get('/public/v1/note/id/{idnote}', function (Request $request, Response $response, $args) {
        $note = new Note();
        return setResponse($response, $note->getById($request, $response, $args) );
    });

    // Get dati generici del meeting
    $app->get('/public/v1/meeting/init/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $meeting = new Meeting();
        return setResponse($response, $meeting->init($request, $response, $args) );
    });
    $app->get('/public/v1/meeting/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $meeting = new Meeting();
        return setResponse($response, $meeting->get($request, $response, $args) );
    });
    $app->post('/public/v1/meeting/', function (Request $request, Response $response, $args) {
        $meeting = new Meeting();
        return setResponse($response, $meeting->insert($request, $response, $args) );
    });
    $app->post('/public/v1/meeting/url', function (Request $request, Response $response, $args) {
        $meeting = new Meeting();
        return setResponse($response, $meeting->getByURL($request, $response, $args) );
    });

    // Get dati dell'agenda del meeting
    $app->get('/public/v1/agenda/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $agenda = new Agenda();
        return setResponse($response, $agenda->get($request, $response, $args) );
    });
    // update cambio valore dei checkbox
    $app->post('/public/v1/agenda/check', function (Request $request, Response $response, $args) {
        $agenda = new Agenda();
        return setResponse($response, $agenda->check($request, $response, $args) );
    });
    // update cambio valore dei checkbox
    $app->post('/public/v1/agenda/insert', function (Request $request, Response $response, $args) {
        $agenda = new Agenda();
        return setResponse($response, $agenda->insert($request, $response, $args) );
    });
    $app->post('/public/v1/agenda/delete', function (Request $request, Response $response, $args) {
        $agenda = new Agenda();
        return setResponse($response, $agenda->delete($request, $response, $args) );
    });


    // Get attachment presenti nel meeting
    $app->get('/public/v1/attachements/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $attachements = new Attachements();
        return setResponse($response, $attachements->get($request, $response, $args) );
    });

    // Get Shortcut
    $app->get('/public/v1/shortcut/{idtype}/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $shortcut = new Shortcut();
        return setResponse($response, $shortcut->getAll($request, $response, $args) );
    });
    $app->post('/public/v1/shortcut/{idmeeting}', function (Request $request, Response $response, $args) {
        $shortcut = new Shortcut();
        return setResponse($response, $shortcut->insert($request, $response, $args) );
    });


    // Get lista dei partecipanti del meeting
    $app->get('/public/v1/partecipants/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $partecipants = new Partecipants();
        return setResponse($response, $partecipants->get($request, $response, $args) );
    });
    // update cambio valore dei checkbox
    $app->post('/public/v1/partecipants/check', function (Request $request, Response $response, $args) {
        $partecipants = new Partecipants();
        return setResponse($response, $partecipants->check($request, $response, $args) );
    });
    // update cambio valore dei checkbox
    $app->post('/public/v1/partecipants/insert', function (Request $request, Response $response, $args) {
        $partecipants = new Partecipants();
        return setResponse($response, $partecipants->insert($request, $response, $args) );
    });
    $app->post('/public/v1/partecipants/delete', function (Request $request, Response $response, $args) {
        $partecipants = new Partecipants();
        return setResponse($response, $partecipants->delete($request, $response, $args) );
    });

    // record
    $app->get('/public/v1/record/all/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $partecipants = new Record();
        return setResponse($response, $partecipants->getAll($request, $response, $args) );
    });
    $app->post('/public/v1/record/save', function (Request $request, Response $response, $args) {
        $record = new Record();
        return setResponse($response, $record->insert($request, $response, $args) );
    });

    // screenshot
    $app->post('/public/v1/screenshot/save', function (Request $request, Response $response, $args) {
      $screenshot = new Screenshot();
      return setResponse($response, $screenshot->insert($request, $response, $args) );
    });
    $app->get('/public/v1/screenshot/all/{idmeeting}/{lang}/{user}', function (Request $request, Response $response, $args) {
        $screenshot = new Screenshot();
        return setResponse($response, $screenshot->getAll($request, $response, $args) );
    });



    // Login
    $app->post('/public/v1/converter', function (Request $request, Response $response, $args) {
      $converter = new Converter();
      return $converter->get($request, $response, $args);
      // return setResponse($response, $converter->get($request, $response, $args) );
    });


    $app->get('/public/v1/test/', function (Request $request, Response $response, $args) {

      echo "<hr>Generate Files:<br>";
      echo '<form id="inviofile" action="https://api.sameapp.net/public/v1/converter" method="post">';
      echo '  <input type="text" name="idmeeting" id="idmeeting" value="74b8c6d27160432ab225">';
      echo '  <input type="text" name="user" id="user" value="2">';
      echo '  <input type="text" name="type" id="type" value="doc">';
      echo '  <input type="text" name="name" id="name" value="provafile">';
      echo '  <input type="submit" value="Generate" name="submit">';
      echo '</form>';

      echo "<hr>New shortcut:<br>";
      echo '<form id="inviofile" action="https://api.sameapp.net/public/v1/shortcut/qqqqq" method="post">';
      echo '  <input type="text" name="shortcut" id="shortcut">';
      echo '  <input type="text" name="type" id="type">';
      echo '  <input type="text" name="value" id="value">';
      echo '  <input type="text" name="language" id="lang">';
      echo '  <input type="text" name="user" id="user">';
      echo '  <input type="submit" value="Insert" name="submit">';
      echo '</form>';


      echo "<hr>New meeting:<br>";
      echo '<form id="inviofile" action="https://api.sameapp.net/public/v1/meeting/" method="post" enctype="multipart/form-data">';
      echo '  <input type="text" name="name" id="name">';
      echo '  <input type="text" name="type" id="type">';
      echo '  <input type="text" name="url" id="url">';
      echo '  <input type="text" name="lang" id="lang">';
      echo '  <input type="text" name="user" id="user">';
      echo '  <input type="submit" value="Upload Image" name="submit">';
      echo '</form>';


      echo "<hr>Select image to upload:<br>";
      echo '<form id="inviofile" action="https://api.sameapp.net/public/v1/screenshot/save" method="post" enctype="multipart/form-data">';
      echo '  <input type="text" name="fileToUpload" id="fileToUpload">';
      echo '  <input type="submit" value="Upload Image" name="submit">';
      echo '</form>';



      echo "<hr>Get list screenshot<br>";
      echo '<a href="https://api.sameapp.net/public/v1/screenshot/all/7EQPmfmJD5eahPCLNxwV/en/1">call</a>';


        echo "<hr>Select audio to upload:<br>";
      echo '<form id="inviofile" action="https://api.sameapp.net/public/v1/record/save" method="post" enctype="multipart/form-data">';
      echo '  <input type="file" name="fileToUpload" id="fileToUpload">';
      echo '  <input type="text" name="idmeeting" id="idmeeting" value="123123123">';
      echo '  <input type="text" name="type" id="type" value="prova">';
      echo '  <input type="text" name="user" id="user" value="1">';
      echo '  <input type="text" name="extension" id="extension" value="mp3">';
      echo '  <input type="submit" value="Upload Image" name="submit">';
      echo '</form>';

      echo "<hr>Get list record<br>";
      echo '<a href="https://api.sameapp.net/public/v1/record/all/7EQPmfmJD5eahPCLNxwV/en/1">call</a>';


          echo "<hr>Get list note<br>";
          echo '<a href="https://api.sameapp.net/public/v1/note/all/7EQPmfmJD5eahPCLNxwV/en/1">call</a>';

          echo "<hr>Is meeting iniziato almeni una volta<br>";
          echo '<a href="https://api.sameapp.net/public/v1/meeting/init/7EQPmfmJD5eahPCLNxwV/en/1">call</a>';

          echo "<hr>Dati meeting<br>";
          echo '<a href="https://api.sameapp.net/public/v1/meeting/7EQPmfmJD5eahPCLNxwV/en/1">call</a>';


          echo "<hr>Dati agenda<br>";
          echo '<a href="https://api.sameapp.net/public/v1/agenda/7EQPmfmJD5eahPCLNxwV/en/1">call</a>';

        echo "<hr>ADD agenda<br>";
        echo '<form action="https://api.sameapp.net/public/v1/agenda/insert" method="post">';
          echo '<input name="idmeeting" id="idmeeting" value="1">';
          echo '<input name="value" id="value" value="1">';
          echo '<input type="submit">';
        echo '</form>';

        echo "<hr>Delete agenda<br>";
        echo '<form action="https://api.sameapp.net/public/v1/agenda/delete" method="post">';
          echo '<input name="idmeeting" id="idmeeting" value="1">';
          echo '<input name="id" id="id" value="1">';
          echo '<input type="submit">';
        echo '</form>';

        echo "<hr>CHECK AGENDA<br>";
        echo '<form action="https://api.sameapp.net/public/v1/agenda/check" method="post">';
          echo 'idmeeting: <input name="idmeeting" id="idmeeting" value="YbrhZ97glIkLAruzG7xk">';
          echo ' - id task: <input name="id" id="id" value="1">';
          echo ' - checked: <input name="checked" id="checked" value="0">';
          echo '<input type="submit">';
        echo '</form>';


          echo "<hr>Get last NOTE<br>";
          echo '<a href="https://api.sameapp.net/public/v1/note/7EQPmfmJD5eahPCLNxwV">call</a>';

          echo "<hr>Get list participants<br>";
          echo '<a href="https://api.sameapp.net/public/v1/partecipants/7EQPmfmJD5eahPCLNxwV/en/1">call</a>';

          echo "<hr>ADD partecipants<br>";
          echo '<form action="https://api.sameapp.net/public/v1/partecipants/insert" method="post">';
            echo '<input name="idmeeting" id="idmeeting" value="1">';
            echo '<input name="value" id="value" value="1">';
            echo '<input name="email" id="email" value="corrado@salesmeet.ai">';
            echo '<input type="submit">';
          echo '</form>';

          echo "<hr>Delete partecipants<br>";
          echo '<form action="https://api.sameapp.net/public/v1/partecipants/delete" method="post">';
            echo '<input name="idmeeting" id="idmeeting" value="1">';
            echo '<input name="id" id="id" value="1">';
            echo '<input type="submit">';
          echo '</form>';

          echo "<hr>CHECK PARTECIPANTS<br>";
          echo '<form action="https://api.sameapp.net/public/v1/partecipants/check" method="post">';
            echo 'idmeeting: <input name="idmeeting" id="idmeeting" value="YbrhZ97glIkLAruzG7xk">';
            echo ' - id task: <input name="id" id="id" value="1">';
            echo ' - checked: <input name="checked" id="checked" value="0">';
            echo '<input type="submit">';
          echo '</form>';

        echo "<hr>ACTION<br>";
        echo '<form action="https://api.sameapp.net/public/v1/action" method="post">';
          echo '<input name="idmeeting" id="idmeeting" value="1">';
          echo '<input name="second" id="second" value="1">';
          echo '<input name="secondmanual" id="secondmanual" value="1">';
          echo '<input name="action" id="action" value="1">';
          echo '<input name="value" id="value" value="1">';
          echo '<input type="submit">';
        echo '</form>';

        echo "<hr>NOTE<br>";
        echo '<form action="https://api.sameapp.net/public/v1/note" method="post">';
          echo '<input name="idmeeting" id="idmeeting" value="1">';
          echo '<input name="value" id="second" value="Che bella giornta">';
          echo '<input type="submit">';
        echo '</form>';

        echo "<hr>LOGIN<br>";
        echo '<form action="https://api.sameapp.net/public/v1/login" method="post">';
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
