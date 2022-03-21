<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\FireStore;

class Shortcut
{

    private $collection_name = "shortcuts";

    public function __construct() {
    }

    public function getAll( Request $request, Response $response, $args )  {

       $fireStore = new FireStore();
       $data = $fireStore->getDocumentsByQuery( $this->collection_name, "type", "==" , "0");
       $records = array();
       foreach ($data as $document) {
           $temp = [
               "id" => $document->id(),
               "shortcut" => $document->data()["shortcut"],
               "value" => $document->data()["value"],
               "type" => $document->data()["type"],
               "call" => $document->data()["call"],
               "img" => $document->data()["img"],
               "language" => $document->data()["language"]
           ];
           array_push($records,$temp);
       }
       return [
           "title" => "List shortcuts",
           "edit" => "",
           "apiupdate" => "",
           "viewdescription" => "0",
           "items" => $records
       ];
    }

    /*
    public function get()  {
        return json_decode( $this->getMockup() , true);
    }
    */

    public function getMockup()  {

        $jsondata = '{
           "title":"List shortcut",
           "edit":"",
           "apiupdate":"",
           "items":[
              {
                 "id":"1",
                 "shortcut":"//t",
                 "value":"Task",
                 "type":"0",
                 "call":"sameRapidTask",
                 "img":"https://plugin.sameapp.net/v1/img/exclamation.png",
                 "language":"en"
              },
              {
                 "id":"2",
                 "shortcut":"//m",
                 "value":"Make an appointment",
                 "type":"0",
                 "call":"sameRapidMake",
                 "img":"https://plugin.sameapp.net/v1/img/calendar.png",
                 "language":"en"
              },
              {
                 "id":"3",
                 "shortcut":"//q",
                 "value":"Question?",
                 "type":"0",
                 "call":"sameRapidQuestion",
                 "img":"https://plugin.sameapp.net/v1/img/question.png",
                 "language":"en"
              },
              {
                 "id":"4",
                 "shortcut":"//r",
                 "value":"Remember to call",
                 "type":"0",
                 "call":"sameRapidRMC",
                 "img":"https://plugin.sameapp.net/v1/img/phone.png",
                 "language":"en"
              },
              {
                 "id":"5",
                 "shortcut":"//l",
                 "value":"Links",
                 "type":"0",
                 "call":"sameRapidLinks",
                 "img":"https://plugin.sameapp.net/v1/img/exclamation.png",
                 "language":"en"
              }
           ]
        }';
        return $jsondata;
    }

}
