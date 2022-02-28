<?php

namespace App\Application\Actions\v1;

class Attachements
{

  public function __construct() {
  }

  public function get()  {

      $jsondata = '{
         "title":"Attachements",
         "edit":"",
         "apiupdate":"",
         "items":[
            {
               "id":"1",
               "type":"link",
               "value":"https://www.salesmeet.ai/",
               "description":"Pre architectural analysis"
            },
            {
               "id":"2",
               "type":"link",
               "value":"https://www.salesmeet.ai/",
               "description":"PDF architecture"
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
