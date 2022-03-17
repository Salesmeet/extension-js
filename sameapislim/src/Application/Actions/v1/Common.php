<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Common
{

    public function __construct()
    {
    }

    public function getOrigin( Request $request)  {
          $var = $this->getHeader( $request);
          if (array_key_exists("Origin", $var)) {
               return $var["Origin"];
          }
          return "";
    }
    public function getHeader( Request $request)  {
          $headers = $request->getHeaders();
          $var = [];
          foreach ($headers as $name => $values) {
              $var[$name] =  implode(", ", $values);
          }
          return $var;
    }


    public function getOutputMessage($message)
    {
        return json_encode($message);
        // array('message' => $message);
    }

    public function setDocument( Request $request, $action )  {
        $requestArrayParam = $request->getParsedBody();
        $idmeeting = "";
        $id = "";
        $value = "";
        $user = "";
        $second  = "";
        $secondmanual = "";
        $email = "";
        if (isset($requestArrayParam["idmeeting"])) {
            $idmeeting = $requestArrayParam["idmeeting"];
        }
        if (isset($requestArrayParam["id"])) {
            $id = $requestArrayParam["id"];
        }
        if (isset($requestArrayParam["value"])) {
            $value = $requestArrayParam["value"];
        }
        if (isset($requestArrayParam["checked"])) {
            if ($requestArrayParam["checked"]!="") {
              $value = $requestArrayParam["checked"];
            }
        }
        if (isset($requestArrayParam["value"])) {
          if ($requestArrayParam["value"]!="") {
            $value = $requestArrayParam["value"];
          }
        }
        if (isset($requestArrayParam["second"])) {
            $second = $requestArrayParam["second"];
        }
        if (isset($requestArrayParam["secondmanual"])) {
            $secondmanual = $requestArrayParam["secondmanual"];
        }
        if (isset($requestArrayParam["user"])) {
            $user  = $requestArrayParam["user"];
        }
        if (isset($requestArrayParam["email"])) {
            $email  = $requestArrayParam["email"];
        }
        return array(
            "idmeeting" => $idmeeting,
            "id" => $id,
            "action" => $action,
            "value" => $value,
            "second" => $second,
            "secondmanual" => $secondmanual,
            "user" => $user,
            "email" => $email,
            "date" => date("Y-m-d H:i:s"),
        );
    }

    /*
      $data = Array data del meeting
      $id = id sub array
      $checked = valore se è checked
      $itemNew = array / object da aggiungere al subset
      $itemDelete = id del template da eliminare
      $field = "attendees" o "tasks" ...
    */
    public function getMeetingSubsetUpdate($data, $id, $checked, $itemNew, $itemDelete, $field )  {
        $checked_master = $checked;
        $items = array();
        $i = 0;

        foreach ($data[ $field ] as $item) {
            // Controllo di modiifcare solo il attendees corretto
            if ( ($i!=$itemDelete) || ($itemDelete==null) ) {

                if ($i != $id) {
                    // Se non ho il campo checked lo creo
                    if ($item["checked"]=="") {
                        $checked = 0;
                    } else {
                        $checked = $item["checked"];
                    }
                } else {
                    // assegno il valore di checked dal frontend
                    $checked = $checked_master;
                }
                $temp = [
                    "image" => $item["image"],
                    "name" => $item["name"],
                    "checked" => $checked,
                ];
                array_push($items,$temp);
                $i++;

            } else {

                $itemDelete = null;

            }
        }
        if ($itemNew!=null) {
            array_push($items,$itemNew);
        }
        return $items;
    }

    public function getMeetingSubset($data, $field)  {
        $checked_master = $checked;
        $items = array();
        $i = 0;
        foreach ($data[ $field ] as $attendee) {

            // Se non ho il campo checked lo creo
            if ($attendee["checked"]=="") {
                $checked = 0;
            } else {
                $checked = $attendee["checked"];
            }
            $attendee = [
                "id" => $i,
                "type" => "checkbox",
                "value" => $attendee["name"],
                "description" => "",
                "checked" => $checked,
            ];
            array_push($items,$attendee);
            $i++;
        }
        return $items;
    }

}
