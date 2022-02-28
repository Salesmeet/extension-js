<?php

namespace App\Application\Actions;

use MrShan0\PHPFirestore\FirestoreClient;
use MrShan0\PHPFirestore\FirestoreDocument;
use MrShan0\PHPFirestore\Fields\FirestoreObject;
use MrShan0\PHPFirestore\Fields\FirestoreBytes;
use MrShan0\PHPFirestore\Fields\FirestoreArray;
use MrShan0\PHPFirestore\Fields\FirestoreTimestamp;
use MrShan0\PHPFirestore\Fields\FirestoreGeoPoint;

class FireStore {

  /*  https://github.com/ahsankhatri/firestore-php  */

  private $project = "sales-66641";
  private $apiKey = 'AIzaSyB_bq-VMYBF7xow-C6GKi4cB3SPKbInm_w';

  public function addDocument( $collection_name, $document) {
    $firestoreClient = new FirestoreClient( $this->project , $this->apiKey  , [
        'database' => '(default)',
    ]);

    /*
    $document = new FirestoreDocument;
    // $document->setObject('sdf', new FirestoreObject(['nested1' => new FirestoreObject(['nested2' => new FirestoreObject(['nested3' => 'test'])])]));
    $document->setBoolean('booleanTrue', true);
    $document->setBoolean('booleanFalse', false);
    $document->setNull('null', null);
    $document->setString('string', 'abc123');
    $document->setInteger('integer', 123456);
    $document->setArray('arrayRaw', ['string'=>'abc123']);
    $document->setBytes('bytes', new FirestoreBytes('bytesdata'));
    $document->setArray('arrayObject', new FirestoreArray(['string' => 'abc123']));
    $document->setTimestamp('timestamp', new FirestoreTimestamp);
    $document->setGeoPoint('geopoint', new FirestoreGeoPoint(1.11,1.11));
    */
    // $firestoreClient->addDocument($collection, $document, 'customDocumentId');

    $firestoreClient->addDocument($collection_name, $document);

  }

  public function getDocument( $collection_name, $id) {
    $firestoreClient = new FirestoreClient( $this->project , $this->apiKey  , [
        'database' => '(default)',
    ]);
    /*
    $array = array(
        "_id" => $id
    );
    */
    return $firestoreClient->getDocument( $collection_name . "/" . $id );
  }

  public function getDocumentByValue( $collection_name, $id) {
    $firestoreClient = new FirestoreClient( $this->project , $this->apiKey  , [
        'database' => '(default)',
    ]);
    $array = array(
        "idmeeting" => 9
    );
    $array2 = array(
    );
    return $firestoreClient->getDocument( $collection_name . "/idmeeting/9" , $array, $array2);
    //
  }

}
