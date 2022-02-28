<?php

namespace App\Application\Actions\v1;

class Partecipants
{

  public function __construct() {
  }

  public function get()  {

      $jsondata = '{
         "title":"Partecipant list",
         "edit":"https://api.sameapp.net/api/v1/getlistuser.php?edit=0",
         "apiupdate":"https://api.sameapp.net/api/v1/updatetlistuser.php",
         "items":[
            {
               "id":"1",
               "type":"checkbox",
               "value":"0",
               "description":"Corrado Facchini"
            },
            {
               "id":"2",
               "type":"checkbox",
               "value":"0",
               "description":"Federico Remiti"
            },
            {
               "id":"3",
               "type":"checkbox",
               "value":"0",
               "description":"Regina Elisabetta"
            },
            {
               "id":"4",
               "type":"checkbox",
               "value":"0",
               "description":"Maurizio ..."
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
