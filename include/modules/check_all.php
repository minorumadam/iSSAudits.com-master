   <? $answers=MiscFunctions::parse_answers($answer['free_answer']);
	  $selected = array();
	  foreach ($answers as $answer_id)
		  $selected[$answer_id] = "checked";
	?>					
  <fieldset data-role="none" data-mini="true" class="content-radioicon">
 <? if ($question['answers']) foreach ($question['answers'] as $k=>$answer_option)
							{ ?>
        <input type="checkbox" id="answers[<?=$q?><?=$answer_option['answerid']?>]" name="answers[<?=$q?>][<?=$answer_option['answerid']?>]" value="<?=$answer_option['answerid']?>"  <?=$selected[$answer_option['answerid']]?>>
        <label for="answers[<?=$q?><?=$answer_option['answerid']?>]"><?=$answer_option['answerlabel']?></label>
         <? } ?>
      </fieldset>
                      
                        
                  
