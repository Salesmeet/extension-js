<?php

namespace App\Application\Actions\v1;

class Users
{

  public function __construct() {
  }

  public function get()  {

      $jsondata = '{
         "title":"Agenda",
         "edit":"https://api.sameapp.net/api/v1/getagenda.php?edit=0",
         "apiupdate":"",
         "items":[
            {
               "id":"1",
               "type":"checkbox",
               "value":"0",
               "description":"Check participants"
            },
            {
               "id":"2",
               "type":"checkbox",
               "value":"1",
               "description":"Participants presentation"
            },
            {
               "id":"3",
               "type":"checkbox",
               "value":"1",
               "description":"Reading the agenda of the day"
            },
            {
               "id":"4",
               "type":"checkbox",
               "value":"0",
               "description":"Project introduction"
            },
            {
               "id":"5",
               "type":"checkbox",
               "value":"0",
               "description":"Slide presentation"
            },
            {
               "id":"6",
               "type":"checkbox",
               "value":"0",
               "description":"..."
            },
            {
               "id":"7",
               "type":"checkbox",
               "value":"0",
               "description":"..."
            },
            {
               "id":"8",
               "type":"checkbox",
               "value":"0",
               "description":"..."
            },
            {
               "id":"9",
               "value":"0",
               "type":"checkbox",
               "description":"..."
            }
         ]
      }';
      return json_decode($jsondata, true);
      /*
      $result[] = array(
          "comune" => "aaaaa"
      );
      return $result;
      */
  }


}
