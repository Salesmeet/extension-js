<?php
namespace App\Application\Actions;

error_reporting(0);
ini_set("display_errors", 0);

use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Firestore\FirestoreClient;

class FirebaseStorage {

  // https://googleapis.github.io/google-cloud-php/#/docs/google-cloud/v0.175.0/firestore/firestoreclient

  private $project = "sales-66641";
  private $fileKey = 'firebase_credentials.json';

  public function addFile( $path, $file ) {

      echo $path . $file . "<hr>";
      $storage = new StorageClient([
          'projectId' => $this->project,
          'keyFilePath' =>  $this->fileKey,
      ]);

      $bucket = $storage->bucket('screenshot');
      // Upload a file to the bucket.
      $bucket->upload(
          // fopen('/data/file.txt', 'r')
          fopen($path . $file, 'r')
      );

  }

}
