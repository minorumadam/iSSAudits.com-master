		<? if($answer['free_answer'] != '0000-00-00 00:00:00' && $answer['free_answer'] != '')
						{
							$new_date = $answer['free_answer'];
						}
						else
							$new_date = date('Y-m-d h:m:00', time()-(4*60*60));
						
						?>
              
        
                      
                      <div class="ui-field-contain">
                        <label for="new_time">Time</label>
                        <input name="new_time[<?=$q?>]" id="new_time" type="text" data-role="datebox" data-options='{"mode":"timebox" ,"defaultValue":"<?=date('h:i A', strtotime($new_date))?>"}' value="<?=date('h:i A', strtotime($new_date))?>"/>
                      </div>
       
