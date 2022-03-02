<?
header("Access-Control-Allow-Origin: *");
if (!isset($_GET['edit'])) {
    header('Content-type: application/json');
} else { ?>
  <script>
      function closeWindow() {
        window.parent.postMessage({
            'func': 'sameTemplateCloseParent',
            'message': ""
        }, "*");
      }
  </script>
  <button onclick="closeWindow();" id="" class="same_icon_style" title="">Close</button>
  <hr>
<?php
}

//  https://engineering.flosports.tv/google-cloud-firestore-document-crud-with-php-1df1c084e45b
include("firestore.php");
use PHPFireStore\FireStoreApiClient;
use PHPFireStore\FireStoreDocument;
$firestore = new FireStoreApiClient(
 'sales-66641', 'AIzaSyB_bq-VMYBF7xow-C6GKi4cB3SPKbInm_w'
);

$document = new FireStoreDocument();
// $document->setString('people', '9cCuqyF50AhoEM2PMcbA');
// $firestore->getDocument('people', '9cCuqyF50AhoEM2PMcbA');
$document->setString('name', 'Michellleeee');
$firestore->addDocument('bella', $document);

exit;
// echo $firestore->getDocument('meetings', '29RNHE6NBtHhCkynoV4P');

?>
{
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
}
