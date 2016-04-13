<?
import('class.ImageProcessor'); 
import('class.ImageThumb');
import('class.Geocode');
$template = "main";
if (!is_numeric($request[2]))
{
	$feedback = new Feedback;
	$feedback->label('Invalid Audit');
	$feedback->type("fail");
	$_SESSION['feedback_'] = $feedback;
	header('Location: /active/');	
}
$audit_id=$request[2];
//unset($_SESSION['audit'][$audit_id]);
if($request[3]=="home")
{
	if($post)
	{
		$data=array();
		$data['query_type'] = 'finalize';
		$data['id'] = $audit_id;
		
		$errors=$api->querydb('Audit',$data,"array");
		$feedback = new Feedback;
		$feedback->label('Results');
		if (!$errors)
		{
			$feedback->add("Audit successfully finalized");
			$_SESSION['feedback_'] = $feedback;
			header("Location: /active/");
			exit;
		}else
		{
			$feedback->add($errors);
			$feedback->type("fail");
			$_SESSION['feedback_'] = $feedback;
		}
	}
	$data['query_type'] = 'sections';
	$data['id'] = $audit_id;
	$sections=$api->querydb('Audit',$data,"array");
	if(!$sections) 
	{
		$feedback = new Feedback;
		$feedback->label('Invalid Audit');
		$feedback->type("fail");
		$_SESSION['feedback_'] = $feedback;
		header('Location: /active/');	
	}
	
	if(!$_SESSION['audit'][$audit_id])
	{
		$questions=$api->querydb('Questions',$data,"array");
		$_SESSION['audit'][$audit_id] = $questions;
	}
	//error_log('questions'.print_r($_SESSION['audit'][$audit_id],1));
	//print_r($_SESSION['audit'][$audit_id]);
	$icons = array(1=>"/images/site/viewdetails-icon.png",2=>"/images/site/cashier.png",3=>"/images/site/checkout-icon.png",4=>"/images/site/general-icon.png",);
?>
<div data-role="page" id="auditsectionquestions" class="auditsectionquestions page-background">
<form id="audit" method="post" enctype="multipart/form-data"  data-ajax="false" action="">
<input type=hidden id="finalize" name="finalize" value="1">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="/active/#audit-<?=$audit_id?>" rel="external" class="pageback-icon"></a> </div>
      <div class="ui-block-b"> Audit Sections </div>
    </div>
    <!-- /grid-b -->
  </div>
  <div role="main" class="content-bgshadow">
  <?=gen_feedback()?>
    <div class="ui-body auditsectionquestions-content">
      <p> Complete the questions in each section.  The number of unanswered questions is called out in the red bubbles. Once your audit is free from errors you may <span>submit</span>. </p>
      <div class="auditsectionquestionsholder">
      <? $count=1;
	  	if($sections) foreach ($sections as $k=>$section)
		{
			$first_col = altSwitch($first_col);
		?>
       <?=$first_col?'<ul>':''?>
          <li> <a href="/audit/<?=$audit_id?>/q/<?=$k?>/" rel="external" ><img src="<?=$icons[$count]?>" alt="">
            <p><?=$section['unanswered']?></p>
            </a> <span><?=$section['name']?></span> </li>
       <?=$first_col?'':'</ul>'?>      
         <? $count++;
		 	if($count>4) $count=1;
		} ?>
		<?=$first_col?'</ul>':''?> 
		
       
      </div>
    </div>
  </div>
  <a href="#" onClick="document.getElementById('audit').submit();" class="greenbtn">Submit</a> 
    </form>
    </div>
<?	
}else if($request[3]=="q" && is_numeric($request[4]))
{
	$section_id=$request[4];
	//$q_num=$request[5];
	//$q_total = count($_SESSION['audit'][$audit_id][$section_id]['questions']);
	//if(!$q_num) $q_num=1;
	
	//$question = $_SESSION['audit'][$audit_id][$section_id]['questions'][$q_num-1];
	//error_log(print_r($question,1));
	
	if($post)
	{
	  //error_log('in audit post'.print_r($post,1));
	  $feedback = new Feedback;
	  $errors='';
	  $data = array();
	  foreach($_SESSION['audit'][$audit_id][$section_id]['questions'] as $k=>$question){
		 // error_log(print_r($question,1));
		if( $_FILES['photo']['tmp_name'][$k] ){
		  $f = $_FILES['photo'];
		  $exif = @exif_read_data($f[tmp_name][$k], 0, true);
		  list( $width, $height, $type ) = getimagesize($f['tmp_name'][$k]);
		  if( $type != 2 ){
			  $f_err[$k+1] =  _("File must be a jpeg");
		  }
		  else{
			$f['name'][$k] =  $question['questionID'] . ".jpg";
			$dir = 'uploads/tmp/';
			$tempname = time()."-".$f['name'][$k];
			$t = new ImageThumb;
			$t->set_source($f['tmp_name'][$k]);
			$t->set_destination($dir);
			$t->set_name($tempname);
			$t->set_max_dimensions(700, 900);
			
			if( !$t->execute() )
				  $errors = _("Unable to upload photo");	
			else
			{
				  //embed metadata
				  $lon = Geocode::getGps($exif[GPS]["GPSLongitude"], $exif[GPS]['GPSLongitudeRef']);
				  $lat = Geocode::getGps($exif[GPS]["GPSLatitude"], $exif[GPS]['GPSLatitudeRef']);

				  $imgProcessor = new ImageProcessor;
				  $result = $imgProcessor->processShopImage( $audit_id, $f['name'][$k], $dir . $tempname, $exif[EXIF][DateTimeOriginal], $lat, $lon, 0, $question['questionID'], $exif[IFD0][Model].' via iSS Audits', $exif );
				 
				  unlink('./'.$dir.$tempname);
				  $post['photo_taken'][$k] = 1;
				  $feedback->add("Photo Uploaded");
			  }
			  unset($post['photo'][$k]);

		  }//end else
	  	} //end if files
		
		$data['answers'][$k]['price']=$post['price'][$k];
		$data['answers'][$k]['free_answer']=$post['free_answer'][$k];
		if($post['new_date'][$k])
			$data['answers'][$k]['free_answer']=$post['new_date'][$k];
		if($post['new_time'][$k])
			$data['answers'][$k]['free_answer']=$post['new_date'][$k].' '.$post['new_time'][$k];	
		
		$data['answers'][$k]['answer_id']=$post['answer_id'][$k];
		$data['answers'][$k]['comment']=$post['comment'][$k];
		$data['answers'][$k]['answers']=$post['answers'][$k];	 	
		$data['answers'][$k]['shop_question_id'] = $question['questionID'];
		
		
	  }	 //end foreach
	 	$data['query_type'] = 'save_answer';
		$data['id'] = $audit_id;
		//error_log('save secion'.print_r($data,1));
		$error=array();
	  	$result = $api->querydb('SectionSave',$data,"array");
		//error_log('save secion result '.print_r($result,1));
		if ($result['errors']) 
		{
			foreach($result['errors'] as $k=>$error)
			{
				$num = $_SESSION['audit'][$audit_id][$section_id]['questions'][$k]['num'];
				$feedback->add('#'.$num.' '.$error);
			}
			$feedback->label("Section Incomplete ".$result['message']);
			$feedback->type("fail");
			$_SESSION['feedback_'] = $feedback;
		}
		else
		{
			$feedback->label("Section Complete");
			$_SESSION['feedback_'] = $feedback;
		}
		
		header("Location: /audit/$audit_id/home/");
		exit;
	}
	$section = $_SESSION['audit'][$audit_id][$section_id];
?>
	<div data-role="page" id="auditq2" class="page-background auditsectionbg">
    
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="/audit/<?=$audit_id?>/home/" rel="external" class="pageback-icon"></a> </div>
      <div class="ui-block-b"> Audit </div>
      <div class="ui-block-c"> </div>
    </div>
    <!-- /grid-b -->
  </div>
  <!-- /header -->
  <div role="main" class="content-bgshadow">
 
    <div class="ui-body banner-text">
      <div class="ui-grid-b banner-grid">
        <div class="ui-block-a"> <? if ($q_num>1) {?><a href="#" onClick="document.getElementById('step').value = 'previous';
    document.getElementById('question').submit();" class="qback"></a> <? } ?></div>
        <div class="ui-block-b">
           <h3><?=$section['title']?></h3>
            <?if(count($f_err)>0)foreach($f_err as $k=>$v){?> 
				<p style='color:red;'>#<?=$k?> <?=$v?></p>
			<?}?>
			<?=gen_feedback()?>
        </div>
    </div>
    <? $data['query_type']="section_answers";
			$data['id']=$audit_id;
			$data['section_id']=$section_id;
			$answers= $api->querydb('Audit',$data,"array");
			error_log(print_r($answers,1));
	?>		
    <form id="question" method="post" enctype="multipart/form-data"  data-ajax="false" action="">
		<?
		$i=1;
		if ($section['questions']) foreach($section['questions'] as $q=>$question){
			$answer=$answers[$q];
		 ?>
			<div class="ui-body content-bgshadow">
			  <div class="auditsection-description">
				<!--- note -->
				<? if ($question['answer_type'] !='info')
				{if ($answer['status']) { 
				
				?><a href="#popupnote<?=$i?>" data-rel="popup" data-role="none" data-position-to="window" data-transition="fade" class="note"></a>
				<div data-role="popup" id="popupnote<?=$i?>" data-overlay-theme="b" data-theme="a" data-corners="false" class="campopwidth">     <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
				  <p><?=$answer['status']?></p>
				</div>
				<? }else{ ?>
				<a href="#popupnote<?=$i?>" data-rel="popup" data-role="none" data-position-to="window" data-transition="fade" class="check"></a>
				 <div data-role="popup" id="popupnote<?=$i?>" data-overlay-theme="b" data-theme="a" data-corners="false" class="campopwidth">     <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
				  <p>Question has been answered</p>
				</div>
				<? }
				}
				$_SESSION['audit'][$audit_id][$section_id]['questions'][$q]['num']=$i;
				?>
				<!--- note -->
				<p><?=($question['answer_type'] !='info')? '<b># '.$i.'</b>':''?> <?=$question['text']?><?=$question['min_char']?"  A text answer of at least ".$question['min_char']." characters is required.":""?></p>
			  </div>
			   <? if ($question['answer_type'] !='info'  && $question['answer_type'] !='photo') include( MODULE . $question['answer_type'].'.php' ); ?>
     
			 <?if($question['allow_comment'] !='N' && $question['answer_type'] != 'text'){?>
			  <textarea cols="40" rows="4" name="comment[<?=$q?>]" id="c" placeholder="Please Comment..."><?=$answer['comment']?></textarea>
			 <? } ?>
			 <? if($question['allow_photo'] !='No' || $question['photo_required'] =='Yes')
			 {?>
			<!--- camera popup -->
			  <span class="greenbtn"><span class="galphotoicon"></span>Photo <?=$question['photo_required']=='Yes'?"Required":"Optional"?> Choose...<input type="file" name="photo[<?=$q?>]" id="photo" accept="image/*">
			  </span>
		    <br>
			<? } ?>
			<? if($answer['photo_taken']) {?>
				<a href="#popupPhoto<?=$i?>" class="greenbtn" data-role="none"  data-rel="popup" data-position-to="window" data-transition="fade"><span class="camphoticon"></span>View Current Photo</a>
				<div data-role="popup" id="popupPhoto<?=$i?>" data-overlay-theme="a" data-theme="d" data-corners="false">
					<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
					<img class="popphoto" src="https://s3.amazonaws.com/isecretshop_visit_files/clients/<?=$_SESSION['_User']->c_id?>/shops/<?=$audit_id?>/<?=$question['questionID']?>.jpg" alt="">
				</div>
			<? } ?>
			</div>
	 <?
	 if($question['answer_type'] !='info')$i++;
     }?>
	
	<div class="ui-body banner-text">
		 <div class="ui-grid-b banner-grid">
		 <a class="Submit ui-link" onclick="document.getElementById('question').submit();" href="#"><span class="greenbtn">Save Section</span></a>
		 </div>
    </div>
   </div>
  </form>
  </div> <!-- /main-->
</div> <!-- /page-->
<?
	
	
}else
{
	header('Location: /audit/$audit_id/home/');	
	exit;
	
}

?>
<!--<script id="panel-init">
	$(function() {
		$( "body>[data-role='panel']" ).panel();

	});
	function ajaxCall(){
			$.ajax({
			   type:'post',
			   data: $('#question').serialize()
			});
		}
	$('input').change(function(){
			ajaxCall();  
		});
		
	$('textarea').blur(function() {
	  if($.trim($(this).val()).length){
			ajaxCall(); 
	  } 
	});
</script> -->


