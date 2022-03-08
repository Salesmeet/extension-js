<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;

use App\Application\Actions\FireStore;

class Screenshot
{

    private $collection_name = "screenshot";
    private $directory = "screenshot/";
    private $collection_name_meetings = "meetings";

    public function __construct() {
    }

    public function getAll( Request $request, Response $response, $args )  {
      $data = $this->setDocument( $request );
      if (isset($args["idmeeting"])) {
          $fireStore = new FireStore();
          $data = $fireStore->getDocumentsByQuery( $this->collection_name, "idmeeting", "==" , $args["idmeeting"]);
          $records = array();
          foreach ($data as $document) {
              $temp = [
                  "id" => $document->id(),
                  "type" => "record",
                  "date" => $document->data()["date"],
                  "name" => $document->data()["name"],
                  "basename" => $document->data()["basename"],
                  "extension" => $document->data()["extension"],
                  "directory" => $document->data()["directory"],
                  "value" => $document->data()["basename"] . "." . $document->data()["extension"],
              ];
              array_push($records,$temp);
          }
          return [
              "title" => "Records list",
              "edit" => "",
              "apiupdate" => "",
              "viewdescription" => "0",
              "items" => $records
          ];

      }
      return json_decode( '{"state":"200","value":"not add"}', true);
    }


    public function insert( Request $request, Response $response, $args )  {

      $dataDocument = $this->setDocument( $request );

      $screenshot = $_POST['fileToUpload'];
      $screenshot = str_replace('data:image/jpeg;base64,', '', $screenshot);
      $screenshot = str_replace(' ', '+', $screenshot);
      $data = base64_decode($screenshot);
      $file = uniqid() . "_" . $dataDocument["idmeeting"] . "_" . $dataDocument["user"] . '.jpeg';
      $dataDocument["name"] = $file;
      $success = file_put_contents($this->directory . $file, $data);

      $fireStore = new FireStore();
      // inserisco registrazione legata al meeting
      $fireStore->addDocument( $this->collection_name, $dataDocument );

      return json_decode( '{"state":"200","value":"ok"}', true);
    }

    public function setDocument( Request $request )  {
        $requestArrayParam = $request->getParsedBody();
        $idmeeting = "";
        $user = "";
        $name = "";
        if (isset($requestArrayParam["idmeeting"])) {
            $idmeeting = $requestArrayParam["idmeeting"];
        }
        if (isset($requestArrayParam["user"])) {
            $user  = $requestArrayParam["user"];
        }
        if (isset($requestArrayParam["name"])) {
            $name  = $requestArrayParam["name"];
        }
        return array(
            "idmeeting" => $idmeeting,
            "user" => $user,
            "name" => $name,
            "directory" => $this->directory,
            "date" => date("Y-m-d H:i:s"),
        );
    }

}
