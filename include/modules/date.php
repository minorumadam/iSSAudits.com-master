		<? echo 'here'.$answer['free_answer'];
		if($answer['free_answer'] != '0000-00-00 00:00:00' && $answer['free_answer'] != '' && $answer['free_answer'] != '1969-12-31' && $answer['free_answer'] != 0)
						{
							$new_date = $answer['free_answer'];
						}
						else
							$new_date = date('Y-m-d h:m:00', time()-(4*60*60));
						
						?>
              
        
                       <div class="ui-field-contain">
                        <label for="new_date">Date</label>
                        <input name="new_date[<?=$q?>]" id="new_date" type="text" data-role="datebox" data-options='{"mode":"calbox", "defaultValue":"<?=date('Y-m-d', strtotime($new_date))?>"}' value = "<?=date('m/d/Y', strtotime($new_date))?>"/>
                      </div>
                     
