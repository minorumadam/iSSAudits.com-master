
<fieldset data-role="none" data-mini="true" class="content-radioicon">
<? if ($question['answers']) foreach ($question['answers'] as $k=>$answer_option)
							{ ?>
        <input type="radio"  name="answer_id[<?=$q?>]" id="answer_id<?=$q?><?=$answer_option['answerid']?>" value="<?=$answer_option['answerid']?>" <?=$answer['answer_id']==$answer_option['answerid']?"checked":""?>>
        <label for="answer_id<?=$q?><?=$answer_option['answerid']?>"><?=$answer_option['answerlabel']?></label>
        <? } ?>
      
      
      </fieldset>
