<?php

namespace App\Application\Actions;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\ObjectUploader;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class Aws
{

    private $bucketMaster = "sameapp";
    private $key = "AKIA4GROFNDSSJDI46GB";
    private $secret = "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";
    private $region = "eu-west-1";

    public function __construct() {
    }

    public function getBucketMaster( $bucket )  {
        return $this->bucketMaster . "/" . $bucket;
    }

    public function uploadAWS( $directory,  $file, $bucket )  {

        // https://docs.aws.amazon.com/code-samples/latest/catalog/php-s3-TransferManager.php.html

        try {

            $s3Client = new S3Client([
              'version' => 'latest',
              'region'  => $this->region,
              'credentials' => [
              'key'    => $this->key,
              'secret' => $this->secret
              ]
            ]);

            // Use multipart upload
            $source = $directory . $file;
            $uploader = new MultipartUploader($s3Client, $source, [
                'bucket' => $this->bucketMaster ,
                'key' => $bucket . "/" . $file,
            ]);

            try {
                $result = $uploader->upload();
                /*
                echo $result;
                echo "<hr>";
                echo $result['metadata'];
                echo "<hr>";
                */
                return $result['ObjectURL'];
            } catch (MultipartUploadException $e) {
                // echo $e->getMessage() . "\n";
            }


        } catch (S3Exception $e) {
            // echo $e->getMessage() . "\n";
        }
        return "";


    }

    function createBucket($s3Client, $bucketName)
    {
        try {
            $result = $s3Client->createBucket([
                'Bucket' => $bucketName,
            ]);
            return 'The bucket\'s location is: ' .
                $result['Location'] . '. ' .
                'The bucket\'s effective URI is: ' .
                $result['@metadata']['effectiveUri'];
        } catch (AwsException $e) {
            return 'Error: ' . $e->getAwsErrorMessage();
        }
    }

    function allFile($s3Client, $bucketName)
    {

      //Uploading a Local Director to S3
      echo "Uploading Files to S3";
      // Where the files will be source from
      $source = $directory;
      // Where the files will be transferred to
      $dest = 's3://sameapp/screenshot';
      // Create a default transfer object
      $manager = new \Aws\S3\Transfer($s3Client, $source, $dest);
      // Perform the transfer synchronously
      $manager->transfer();

    }


}
