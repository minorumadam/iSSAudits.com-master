<?

class ImageProcessor {

 

  function processShopImage( $instance_id, $filename, $localfile, $created, $latitude, $longitude, $userId, $questionId, $deviceType, $exif=false ) {

    /** Note: 11/30/2013 16:25 PST,  Still under construction (but getting close) **/

    $imageInfo = getimagesize ( $localfile );
    $filesize = filesize( $localfile );

    list( $width, $height ) =  getimagesize ( $localfile );

 	$image = imagecreatefromstring(file_get_contents( $localfile ) );
	
	
    switch($exif['IFD0']['Orientation']) {

    case 8:
    $image = imagerotate($image,90,0);
    error_log( "Rotating +90", 0 );
    imagejpeg( $image, $localfile );
    imagedestroy($image);
    break;
    case 3:
    error_log( "Rotating 180", 0 );
    $image = imagerotate($image,180,0);
    imagejpeg( $image, $localfile );
    imagedestroy($image);
    break;
    case 6:
    error_log( "Rotating -90", 0 );
    $image = imagerotate($image,-90,0);
    imagejpeg( $image, $localfile );
    imagedestroy($image);
    break;
    }
	
    import('class.S3Manager');
    $S3Mgr = new S3Manager;
    $S3Mgr->uploadShopImageToS3( $_SESSION['_User']->c_id, $instance_id, $filename, $localfile );

    
	import("class.clientAPI");
	$api =	new ISSAPI();

   
    $data= array();

    $data['id']   = $instance_id;
    $data['shop_question_id'] = $questionId;
    $data['filename']    = $filename;
    $data['device_type'] = $deviceType;
    $data['latitude']    = $latitude;
    $data['longitude']   = $longitude;
    $data['width']       = $width;
    $data['height']      = $height;
    $data['file_size']   = $filesize;
    $data['created']     = strtotime( $created );
    
	$data['query_type'] = 'save_photo';
	error_log(print_r($data,1));
    $result = $api->querydb('Audit',$data,"array");	  
//	mail("jennifer@isecretshop.com","card file",$db->error().$db->last());
    return $result;

    return 1;
  }

  /*  Not converted yet
   function deleteCardFile( $submittedID, $clientId, $filename ) {

    import('class.S3Manager');

    $S3Mgr = new S3Manager;

    $S3Mgr->deleteFile( "isecretshop_visit_files/" . "clients/" . $clientId . "/cards/" . $submittedID,  $filename  );

    $db = getDB();
   // $db->connect();

    // STATUS = 2 indicates deletion
    $updateQuery = "UPDATE visit_files SET STATUS = 2 WHERE submitted_id = " . $submittedID . " AND client_id = " . $clientId . " AND filename = '" . $filename . "'"; 

    $rowsUpdated = $db->execute( $updateQuery );  

    return $rowsUpdated;
  }
  
  function rotateCardFile( $submittedID, $filename ) {
	import('class.CommentCardSubmitted');
	import('class.S3Manager');
	$cc = new CommentCardSubmitted($submittedID); 
    // rotate 90 deg clockwise

    // 1. Get the file from S3
	
    $S3Mgr = new S3Manager;
    $bucket =  "isecretshop_visit_files/"."clients/" . $cc->commentcard[client_id] . "/cards/" . $submittedID; 
   
	$localfile = $S3Mgr->fetchFile( $bucket, $filename );
	
	
    // 2. Perform the rotation 

    $image = imagecreatefromstring( $localfile  );
    $image = imagerotate($image,270,0);
	$uniqueid=time();
	$path = "./uploads/tmp/".$uniqueid."-".$filename;
	imagejpeg($image, $path);
	
    $S3Mgr->uploadCommentCardImageToS3( $cc, $filename, $path ); 
	unlink($path);
	return true;

  }
  
  function checkCardImage($submitted_id, $commentcard_question_id)
  {
  	if( !$submitted_id OR !is_numeric($submitted_id) OR !$commentcard_question_id OR !is_numeric($commentcard_question_id))
			return false;
	$db = getDB();
	
	$d = $db->query("
			SELECT *
			FROM visit_files 
			WHERE 1
			AND submitted_id = " . $submitted_id . " 
			AND commentcard_question_id = " . $commentcard_question_id . " 
			AND status = '0'
		");
	
	if ($d)
	{
		$d=$d[0];
		return "https://".$d[s3_host].'/'.$d[s3_bucket].'/'.$d[s3_path];
		//return "https://".$d[s3_host].'/'.$d[s3_bucket].'/clients/'.$d['client_id'] . "/shops/" . $shopInstanceId . "/" . $shop_question_id.".jpg";
	}else
		return false;
  }
  
   function getCardFileInfo($submittedID, $clientId, $filename )
  {
  	if( !$submittedID OR !is_numeric($submittedID) OR !$clientId OR !is_numeric($clientId) OR !$filename)
			return false;
	$db = getDB();
	$d = $db->query("
			SELECT *
			FROM visit_files 
			WHERE 1
			AND submitted_id = " . $submittedID . " 
			AND client_id = " . $clientId . " 
			AND filename = '" . $filename . "'
		");
	echo $db->error();
	
	return $d[0];
  }
  */
 
}


?>