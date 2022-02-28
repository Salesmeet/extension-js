<?php
namespace App\Application\Actions;

error_reporting(0);
ini_set("display_errors", 0);

use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Firestore\FirestoreClient;

class FireStore {

  /*  https://googleapis.github.io/google-cloud-php/#/docs/google-cloud/v0.175.0/firestore/collectionreference  */

  private $project = "sales-66641";
  private $apiKey = 'AIzaSyB_bq-VMYBF7xow-C6GKi4cB3SPKbInm_w';
  private $fileKey = 'firebase_credentials.json';

  public function addDocument( $collection_name, $document) {
      $firestore = new FirestoreClient([
          'projectId' => $this->project,
          'keyFilePath' =>  $this->fileKey,
      ]);
      $collection = $firestore->collection($collection_name);
      $newDocument = $collection->add(
          $document
      );

  }

  public function getDocument( $collection_name, $id) {

      $firestore = new FirestoreClient([
        'projectId' => $this->project,
        'keyFilePath' =>  $this->fileKey,
      ]);

      $docRef = $firestore->collection($collection_name)->document($id);
      $snapshot = $docRef->snapshot();
      if ($snapshot->exists()) {
          // printf('Document data:' . PHP_EOL);
          // return $snapshot->data();
          print_r($snapshot->data());
          echo "<hr>";
      } else {
          // return null;
      }

    $this->getDocumentsByQuery( $collection_name );
    // $this->getListDocument( $collection_name );


  }

  public function getDocumentsByQuery( $collection_name ) {

    echo "<hr>";
    echo "getDocumentsByQuery";
    echo "<hr>";
    echo $collection_name;
    echo "<hr>";

    $firestore = new FirestoreClient([
      'projectId' => $this->project,
      'keyFilePath' =>  $this->fileKey,
    ]);

    // https://cloud.google.com/firestore/docs/samples/firestore-query-filter-not-eq
    // https://cloud.google.com/firestore/docs/query-data/queries

    $citiesRef = $firestore->collection('action');
    $query = $citiesRef->where('value', '!=', 'Make an appointment');
    $snapshot = $query->documents();
    foreach ($snapshot as $document) {
        echo "value: " . $document->id();
        echo "<hr>";
        print_r($document->data());
    }

  }

  public function getListDocument( $collection_name ) {

    $firestore = new FirestoreClient([
      'projectId' => $this->project,
      'keyFilePath' =>  $this->fileKey,
    ]);
    $collection = $firestore->collection( $collection_name );
    $documents = $collection->listDocuments();
    foreach ($documents as $document) {
        echo $document->id() . PHP_EOL . "<hr>";
        echo $document->name() . PHP_EOL . "<hr>";
    }

  }

}
