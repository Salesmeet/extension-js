<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;

use App\Application\Actions\FireStore;
use App\Application\Actions\Aws;
use Google\Cloud\Core\Timestamp;
use \Datetime;

class Record
{

    private $collection_name = "record";
    private $directory = "../public/audio";
    private $collection_name_meetings = "meetings";

    public function __construct() {
    }

    /*
    public function getById( Request $request, Response $response, $args )  {

        if (isset($args["idnote"])) {
            $fireStore = new FireStore();
            $data = $fireStore->getDocument( $this->collection_name, $args["idnote"] ) ;
            return [
                "note" => $data["value"]
            ];
        }
        return json_decode( '{"state":"400","value":"not record"}', true);
    }

    public function getLast( Request $request, Response $response, $args )  {
        if (isset($args["idmeeting"])) {
            $fireStore = new FireStore();
            $data = $fireStore->getDocument( $this->collection_name_meetings, $args["idmeeting"] ) ;
            return [
                "note" => $data["note"]
            ];
        }
        return json_decode( '{"state":"400","value":"not record"}', true);
    }
    */

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

      $data = $this->setDocument( $request );
      if ($data["idmeeting"]!="") {

        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['fileToUpload'];

        $filename = sprintf('%s.%0.8s', $data["basename"], $data["extension"]);
        $filename_e_folder = $data["directory"] . DIRECTORY_SEPARATOR . $filename;

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

          $uploadedFile->moveTo( $filename_e_folder );

        }

        // trasferisci file su AWS
        $bucket = "audio";
        $aws = new Aws();
        $pathAws = $aws->uploadAWS( $data["directory"] . "/" , $filename , $bucket );
        $data["directory"] = $pathAws;
        $data["bucket"] = $aws->getBucketMaster( $bucket );

        // remove file
        unlink( $filename_e_folder );

        $fireStore = new FireStore();
        // inserisco registrazione legata al meeting
        $fireStore->addDocument( $this->collection_name, $data );

        // insertTimelines
        $fireStore->addDocument( "timelines", $data );

      }
      return json_decode( '{"state":"200","value":"ok"}', true);
    }

    public function setDocument( Request $request )  {
        $requestArrayParam = $request->getParsedBody();
        $idmeeting = "";
        $type = "";
        $user = "";
        $extension = "wav"; // "mp3";
        $name = "";
        $idunivoco = "";
        if (isset($requestArrayParam["idmeeting"])) {
            $idmeeting = $requestArrayParam["idmeeting"];
        }
        if (isset($requestArrayParam["type"])) {
            $type  = $requestArrayParam["type"];
        }
        if (isset($requestArrayParam["user"])) {
            $user  = $requestArrayParam["user"];
        }
        if (isset($requestArrayParam["extension"])) {
            $extension  = $requestArrayParam["extension"];
        }
        if (isset($requestArrayParam["name"])) {
            $name  = $requestArrayParam["name"];
        }
        if (isset($requestArrayParam["idunivoco"])) {
            $idunivoco  = $requestArrayParam["idunivoco"];
        }

        return array(
            "idmeeting" => $idmeeting,
            "type" => $type,
            "user" => $user,
            "name" => $name,
            "bucket" => "",
            "idunivoco" => $idunivoco,
            "extension" => $extension,
            "type" => "record",
            "directory" => $this->directory,
            "basename" => date("YmdHis") . "_" . $idmeeting . "_" . $user . "_" . $type,
            "date" =>  new Timestamp(new DateTime()), //time(), // date("Y-m-d H:i:s"),
        );
    }

}
