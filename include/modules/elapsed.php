<?
if($answer['free_answer'])
{
$e_hours = floor($answer['free_answer']/3600);
						$e_minutes = floor(($answer['free_answer']-($e_hours*3600))/60);			
						$e_seconds = $answer['free_answer']-($e_hours*3600)-($e_minutes*60);
$default_value = ($e_hours?$e_hours:"00").':'.($e_minutes?$e_minutes:"00").':'.($e_seconds?$e_seconds:"00");
}else
$default_value = "";
						?>
                         <BR>
						 <input type="text" name="free_answer[<?=$q?>]" value="<?=$default_value?>">
                       
                    
