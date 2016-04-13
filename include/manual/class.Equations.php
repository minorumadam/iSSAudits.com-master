<?

class Equations{
	
	
	function resolve($equation, $answers, $questions = false){
		$equation_type = substr ( $equation , 0, 4);
		$equation = str_replace($equation_type,"",$equation);
		$equation = str_replace("(","",$equation);
		$equation = str_replace(")","",$equation);
		$equation = str_replace("Q","",$equation);
		$equation = str_replace("'","",$equation);
		$equation = explode(",", trim($equation));
		$type = $questions->{$equation[0]}->answer_type;
		
		if ($equation_type=='avEq')
		{
			
			if ($type=="check_all")
			{
				$choices = MiscFunctions::parse_options($answers->{$equation[0]}->free_answer);
				//mail("jennifer@isecretshop.com","resolve check all",$type." ".print_r($answers,1)." ".print_r($choices,1));
				if ($choices[$equation[1]])
					return $equation[2];
				else
					return $equation[3];	
			}
			else 
			{
				//mail("jennifer@isecretshop.com","resolve check all",$type." ".print_r($equation,1)." ".print_r($answers,1));
				if ($answers->{$equation[0]}->answer_id==$equation[1])
					return $equation[2];
				else
					return $equation[3];	
			}
		}
		
	}
	
	function get_question_number($equation, $answers){
		$equation_type = substr ( $equation , 0, 4);
		$equation = str_replace($equation_type,"",$equation);
		$equation = str_replace("(","",$equation);
		$equation = str_replace(")","",$equation);
		$equation = str_replace("Q","",$equation);
		$equation = str_replace("'","",$equation);
		$equation = explode(",", trim($equation));
		
		if ($equation_type=='avEq')
		{
			
			return $equation[0];	
			
		}
		
	}
	
}

?>