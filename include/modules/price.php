
  <select name="answer_id[<?=$q?>]" id="answer_id_<?=$q?>">
   <option value="Choose..."</option>
<? if ($question['answers']) foreach ($question['answers'] as $k=>$answer_option)
							{ ?>
                             <option value="<?=$answer_option['answerid']?>" <?=$answer['answer_id']==$answer_option['answerid']?"selected":""?>><?=$answer_option['answerlabel']?></option>
   <? } ?>
</select>

      <BR>
        <div class="customtextbox">
        <div class="auditsection-description">Price: </div>
        <input name="price[<?=$q?>]" id="price" type="text"  value="<?=$answer['price']?>"/>
      </div>
                      
					
