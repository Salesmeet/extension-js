<?php
namespace App\Application\Actions;

error_reporting(0);
ini_set("display_errors", 0);

use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Firestore\FirestoreClient;

class FireStore {

  // https://googleapis.github.io/google-cloud-php/#/docs/google-cloud/v0.175.0/firestore/firestoreclient

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

  public function updateDocument( $collection_name, $id, $document) {
      $firestore = new FirestoreClient([
          'projectId' => $this->project,
          'keyFilePath' =>  $this->fileKey,
      ]);
      /*
      $document = [
          ['path' => 'action', 'value' => "funziona......."],
          ['path' => 'value', 'value' => "value ........."]
      ];
      */
      $collection = $firestore->collection($collection_name)->document($id);
      $collection->update(
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
          $data = $snapshot->data();
          return $data;
      } else {
          return null;
      }

  }

  public function getDocumentsByQuery( $collection_name , $field, $option , $value ) {

        $firestore = new FirestoreClient([
          'projectId' => $this->project,
          'keyFilePath' =>  $this->fileKey,
        ]);

        // https://cloud.google.com/firestore/docs/samples/firestore-query-filter-not-eq
        // https://cloud.google.com/firestore/docs/query-data/queries

        /*
        $citiesRef = $firestore->collection('action');
        $query = $citiesRef->where('value', '==', 'Make an appointment');
        */

        $ref = $firestore->collection( $collection_name );
        // $query = $ref->where($field, $option, $value)->orderBy('date', 'DESC')->limit(2);
        $query = $ref->where($field, $option, $value);

        $snapshot = $query->documents();
        return $snapshot;
        /*
        foreach ($snapshot as $document) {
            $data = $document->data();
            return $data;
            // echo "value: " . $document->id();
            echo "<hr>";
            print_r($document->data());
            echo "<hr>";
            echo $data["color"];
        }
        return null;
        */

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
