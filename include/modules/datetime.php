						<? if($answer['free_answer'] != '0000-00-00 00:00:00' && $answer['free_answer'] != '')
						{
							$new_date = $answer['free_answer'];
						}
						//else
							
							//$new_date = date('Y-m-d h:m:00', time()-(4*60*60));
						
						?>
              
        
                       <div class="ui-field-contain">
                        <label for="new_date">Date</label>
                        <input name="new_date[<?=$q?>]" id="new_date" type="text" data-role="datebox" data-options='{"mode":"calbox", "defaultValue":"<?=$new_date?date('Y-m-d', strtotime($new_date)):date('Y-m-d')?>"}' value = "<?=$new_date?date('m/d/Y', strtotime($new_date)):""?>"/>
                      </div>
                      <div class="ui-field-contain">
                        <label for="new_time">Time</label>
                        <input name="new_time[<?=$q?>]" id="new_time" type="text" data-role="datebox" data-options='{"mode":"timebox" ,"defaultValue":"<?=$new_date?date('h:i A', strtotime($new_date)):""?>"}' value="<?=$new_date?date('h:i A', strtotime($new_date)):""?>"/>
                      </div>
       
                  
                                               
                        
