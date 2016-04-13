<?

require '/home/'.SITE_ACCOUNT.'/aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\S3\S3;

class S3Manager {

  function fileExists( $bucket, $filename ){

    $client = S3Client::factory(array(
				      'key'    => AWS_S3_KEY,
				      'secret' => AWS_S3_SECRET
				      ));

    // Register the stream wrapper from an S3Client object
    $client->registerStreamWrapper();

    //    $testFile = "s3://isecretshop_visit_files/clients/431/shops/49528/67432zz.jpg";
    //    $result = file_exists( $testFile );

    error_log(   "s3://" . $bucket . "/" . $filename ); 
    $result = file_exists( "s3://" . $bucket . "/" . $filename );

    return $result;
  }

 


  function uploadCommentCardImageToS3( $client_id, $submitted_id, $filename, $fullpath ){

    $AWS_S3_BUCKET = "isecretshop_visit_files";

    $client = S3Client::factory(array(
				      'key'    => AWS_S3_KEY,
				      'secret' => AWS_S3_SECRET
				      ));
       
    $bucket = $AWS_S3_BUCKET . "/clients/" . $client_id . "/cards/" . $submitted_id;

    error_log("Sending object to S3 ...", 0);

    $result = $client->putObject(array(
				       'Bucket'     => $bucket,
				       'Key'        => $filename,
				       'SourceFile' => $fullpath,
				       'Metadata'   => array(
							     'SomeKey' => 'some_value',
							     'SomeOtherKey' => 'some_other_value'
							     )
				       ));

    $client->waitUntilObjectExists(array(
					 'Bucket' => $bucket,
					 'Key'    => $filename
					 ));

    error_log("S3 upload done.  ObjectURL: " . $result['ObjectURL'] , 0);

    return true;	
  }
  
  function uploadShopImageToS3( $client_id, $instance_id, $filename, $fullpath ){

    $AWS_S3_BUCKET = "isecretshop_visit_files";

    $client = S3Client::factory(array(
				      'key'    => AWS_S3_KEY,
				      'secret' => AWS_S3_SECRET
				      ));
       
    $bucket = $AWS_S3_BUCKET . "/clients/" . $client_id . "/shops/" . $instance_id;

    error_log("Sending object to S3 ...", 0);

    $result = $client->putObject(array(
				       'Bucket'     => $bucket,
				       'Key'        => $filename,
				       'SourceFile' => $fullpath,
				       'Metadata'   => array(
							     'SomeKey' => 'some_value',
							     'SomeOtherKey' => 'some_other_value'
							     )
				       ));

    $client->waitUntilObjectExists(array(
					 'Bucket' => $bucket,
					 'Key'    => $filename
					 ));

    error_log("S3 upload done.  ObjectURL: " . $result['ObjectURL'] , 0);

    return true;	
  }

  

  function deleteFile( $path, $filename ) {

    $client = S3Client::factory(array(
				      'key'    => AWS_S3_KEY,
				      'secret' => AWS_S3_SECRET
				      ));

    error_log("Deleting object from S3:" . $path . "/" . $filename, 0);

    $result = $client->deleteObject(array(
					  'Bucket' => $path,
					  'Key' => $filename
					  ));

    return true;	
  }
  
  function fetchFile( $path, $filename ) {

    $client = S3Client::factory(array(
				      'key'    => AWS_S3_KEY,
				      'secret' => AWS_S3_SECRET
				      ));
	//open path		
	  
	$uniqueid=time();
	$FileHandle = fopen("/home/issdash/public_html/uploads/tmp/".$uniqueid."-".$filename, 'w+');
	
	$result = $client->getObject(array(
					  'Bucket' => $path,
					  'Key' => $filename,
					  'SaveAs' => $FileHandle
					));

	$image = file_get_contents("/home/issdash/public_html/uploads/tmp/".$uniqueid."-".$filename);
	unlink("/home/issdash/public_html/uploads/tmp/".$uniqueid."-".$filename);
	return $image;
	
	}
}
?>