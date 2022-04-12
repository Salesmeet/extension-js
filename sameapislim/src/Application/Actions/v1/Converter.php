<?php

namespace App\Application\Actions\v1;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Psr7\LazyOpenStream;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamFactoryInterface;

use Convertio\Convertio;
use Convertio\Exceptions\APIException;
use Convertio\Exceptions\CURLException;

use App\Application\Actions\v1\Meeting;

class Converter
{

    // https://github.com/convertio/convertio-php#ocr-quickstart
    public function __construct() {
    }

    public function get( Request $request, Response $response, $args )  {

      $requestArrayParam = $request->getParsedBody();
      $idmeeting = "";
      $user = "";
      $type_export = "";
      $name_file = uniqid();
      $name_export = uniqid();
      if (isset($requestArrayParam["idmeeting"])) {
          $idmeeting = $requestArrayParam["idmeeting"];
      }
      if (isset($requestArrayParam["user"])) {
          $user  = $requestArrayParam["user"];
      }
      if (isset($requestArrayParam["type"])) {
          $type_export  = $requestArrayParam["type"];
      }
      if (isset($requestArrayParam["name"])) {
          if ($requestArrayParam["name"]!="") {
              $name_export = $requestArrayParam["name"];
          }
      }

      // $name_file = "prova";
      /*
      echo $idmeeting . "<hr>";
      echo $user . "<hr>";
      echo $type_export . "<hr>";
      echo $name_export . "<hr>";
      */

      $meeting = new Meeting();
      $note = $meeting->getNote( $idmeeting );
      if ( $note == "") {
        echo "Not found";
        exit;
      }

      $dir = sys_get_temp_dir();
      $myfile = fopen("files/" . $name_file . ".html", "w") or die("Unable to open file!");
      // $txt = '<html><body><b>Test</b> file body</body></html>';
      fwrite($myfile, $note);
      fclose($myfile);


      try {

          // curl -i -X POST -d '{"apikey": "04762187534c950d8479bdbafb3d2ead", "status": "all"}' http://api.convertio.co/convert/list
          $API = new Convertio("04762187534c950d8479bdbafb3d2ead");
          $API->start('files/' . $name_file . '.html', $type_export )->wait()->download('files/' . $name_file . '.' . $type_export )->delete();

          /*
          $name_file = "62558d7547cb0";
          $type_export = "doc";
          */
          $fh = fopen('files/' . $name_file . '.' . $type_export, 'rb');
          // $fh = fopen('files/62558d7547cb0.doc', 'rb');
          rewind($fh);

          $response->getBody()->write(fread($fh, (int)fstat($fh)['size']));
          $response = $response
              ->withHeader('Content-Type', 'application/' . $type_export )
              ->withHeader('Content-Disposition', 'attachment; filename="' . $name_export . '.' . $type_export . '"');


          unlink("files/" . $name_file . ".html");
          unlink('files/' . $name_file . '.' . $type_export);

          return $response;


      } catch (APIException $e) {
          echo "API Exception: " . $e->getMessage() . " [Code: ".$e->getCode()."]" . "\n";
      } catch (CURLException $e) {
          echo "HTTP Connection Exception: " . $e->getMessage() . " [CURL Code: ".$e->getCode()."]" . "\n";
      } catch (Exception $e) {
          echo "Miscellaneous Exception occurred: " . $e->getMessage() . "\n";
      }

    }


}
