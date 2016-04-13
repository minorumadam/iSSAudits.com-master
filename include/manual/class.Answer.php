<?
class Answer{
	
	function show($question, $answer, $filename, $edit=true,  $no_photos=false){
		// users can be admin, shopper, merchant, pdf
		global $db;
	
		if($question->question_client)
			$question_text = $question->question_client;
		else
			$question_text = $question->question;	
		$answer->points = str_replace('points','',str_replace(' of ','/',$answer->points));
		$answer->points = str_replace('Not Scored',_("Not Scored"),$answer->points);
		
		$html = "<table style='width: 100%; text-align: left'><tbody><tr><td style='width: 3%; text-align: left; vertical-align:top'>";
		
		if ($question->answer_type != 'info')
		{
		  $html .=  '<strong>#' . $question->QuestionNumber.'</strong>';
		  $html .="</td><td style='width: 67%; text-align: left; vertical-align:top'><strong>Q: </strong>".Sanitize::sanitize_html_string($question_text)."</td>";
		 
			  
			  if( MiscFunctions::type_is_multiple_choice($question->answer_type) && ($question->answer_type != "check_all") && property_exists($answer, 'answer_id'))
			  {
				
				  $html.="<td style='width: 18%; text-align: right; vertical-align:top'>".$question->answers->{$answer->answer_id}."</td><td style='width: 12%; text-align: right; vertical-align:top;'>";
				  if ($question->answer_type=="price")
					  if ($answer->price>0)
						  $html.=MiscFunctions::format_answer($answer->price,"price").'</td></tr>';
					  else
						  $html.="N/A</td></tr>";	
				  else 	  
				  	 $html.="<span class=points>".$answer->points."</span></td></tr>";
			  }else if  ($question->answer_type == "check_all" && property_exists($answer, 'free_answer'))
			  {
				 $html.= "<td style='width: 18%; text-align : right'></td><td style='width: 12%; text-align: right; vertical-align:top'><span class=points>".$answer->points."</span></td></tr><tr><td></td><td colspan=2 style='width: 67%; text-align: left; vertical-align:top; color:#000000;'>";
				 
					$answers=MiscFunctions::parse_options($answer->free_answer);
					if ($question->show_all)
					{
						foreach ($question->answers as $k=>$v)
						{
						if ($answers[$k]) $html .= "<b>["._("Chosen")."]</b> ";
						$html .=  $v;
						$html .="<BR>";
						}
					}else
					{
					foreach ($answers as $a)
						$html .=  $question->answers->{$a}."<BR>";
					}
				$html .= "</td><td></td></tr>";			
			  } else 
			  { 
				   $free_answer = str_replace("<","&lt;", $answer->free_answer);
				  $free_answer = str_replace(">","&gt;", $free_answer);
				  $html.= "<td style='width: 18%; text-align : right'></td><td style='width: 12%; text-align: right; vertical-align:top'>".$answer->points."</td></tr><tr><td></td><td colspan=2 style='width: 67%; text-align: left; vertical-align:top; background-color:#edeaea; color:#000000; font-style:italic'>".MiscFunctions::format_answer($free_answer, $question->answer_type)."</td><td></td></tr>";
			  }
		 
		  if( $answer->comment)
		  {
			   $comment = str_replace("<","&lt;", $answer->comment);
				  $comment = str_replace(">","&gt;", $comment);
			  $html.="<tr><td></td><td colspan=2 style='width: 85%; text-align: left; vertical-align:top; background-color:#edeaea;  color:#000000; font-style:italic'>".MiscFunctions::format_answer($comment, 'text')."</td><td></td></tr>";
		  }
		  $html .='<tr><td colspan=4  style="width: 100%; text-align: right; padding-right:10px;">';									
		 // $filename = "http://isecretshop.com".$dir.$question[id] . ".jpg"; 
		  //if (@GetImageSize($filename)) 
		if ($filename && !$no_photos) 
			  $html.='<a class="sb" href='.$filename.'>'._("View Photo").'</a>';
		   
		  $html .='</td></tr>';
		
		  if ($edit)
			  $html .="<tr><td colspan=4 align=right><input onClick=\"window.location='".$question[id]."/'; return false;\" type='submit' value='Edit' /></td></tr>";
			  
		}
		else
		{
			$html .="</td><td style='width: 85%; text-align: left; vertical-align:top'><strong>".$question_text."</strong></td><td style='width: 12%'></td></tr>";
		}
		  $html .="</tbody></table>
		  ";
	
        return $html;        		
	}	
	
	function show_benchmark($question, $answer, $dir, $answered, $QuestionNumber, $category_id, $no_photos=false){
		// users can be admin, shopper, merchant, pdf
		global $db;
		
		if( !$db )
			$db = new MySQLDB;
		if ($question[base_id])
		{	
			import('class.Benchmark');
			$bm_percent = Benchmark::question_score($question[base_id], $category_id);
			$bm_points = $bm_percent*$question[score];
			$bm = number_format($bm_points, 2, '.', '')."/".$question[score];
		}else
		{
			//mail("jennifer@isecretshop.com","base",print_r($question,1));	
			$bm = "N/A";
		}
		$answer->points = str_replace('points','',str_replace(' of ','/',$answer->points));
		$answer->points = str_replace('Not Scored',_("Not Scored"),$answer->points);
			
		if (strlen($question['question_client'])>0)
			  $question_text = $question['question_client'];
		else 
			  $question_text = $question['question'];	
			  
		$html = "<table style='width: 100%; text-align: left'><tr><td style='width: 3%; text-align: left; vertical-align:top'>";
		
		if ($question->answer_type != 'info')
		{
		  $html .= ($question['hide']) ? '<font color=red>*'.("Hidden").'*</font>' : '#' . $QuestionNumber;
		  $html .="</td><td style='width: 59%; text-align: left; vertical-align:top'><strong>Q: </strong>".Sanitize::sanitize_html_string($question_text)."</td>";
		  if ($answered)
		  {
			  if( MiscFunctions::type_is_multiple_choice($question->answer_type) && ($question->answer_type != "check_all"))
			  {
				  
				  $html.="<td style='width: 18%; text-align: right; vertical-align:top'>".$question->answers[$answer->answer_id]."</td><td style='width: 12%; text-align: right; vertical-align:top'>";
				  if ($question->answer_type=="price")
					  if ($answer->price>0)
						  $html.=MiscFunctions::format_answer($answer->price,"price")."</td><td style='width: 8%; text-align: right; vertical-align:top'>N/A</td></tr>";
					  else
						  $html.="N/A</td></tr>";	
				  else 	  
				  	 $html.="<span class=points>".$answer->points."</span></td><td style='width: 8%; text-align: right; vertical-align:top'>".$bm."</td></tr>";
			  }else if  ($question->answer_type == "check_all")
			  {
				 $html.= "<td style='width: 18%; text-align : right'></td><td style='width: 12%; text-align: right; vertical-align:top'><span class=points>".str_replace('points','',str_replace(' of ','/',$answer->points))."</span></td><td style='width: 8%; text-align: right; vertical-align:top'>".$bm."</td></tr><tr><td></td><td colspan=2 style='width: 59%; text-align: left; vertical-align:top; color:#000000;'>";
				 
					$answers=MiscFunctions::parse_options($answer->free_answer);
					if ($question->show_all)
					{
						foreach ($question->answers as $k=>$v)
						{
						if ($answers[$k]) $html .= "<b>["._("Chosen")."]</b> ";
						$html .=  $v;
						$html .="<BR>";
						}
					}else
					{
					foreach ($answers as $a)
						$html .=  $question->answers[$a]."<BR>";
					}
				$html .= "</td><td></td><td></td></tr>";			
			  } else
			  { 
				  $free_answer = str_replace("<","&lt;", $answer->free_answer);
				  $free_answer = str_replace(">","&gt;", $free_answer);
				if ($user=="pdf"  && strlen($answer->free_answer)>2000)
				  {
					
					$html.= "<td></td><td style='text-align: right; vertical-align:top'>".$answer->points."</td><td style='width: 12%; text-align: right; vertical-align:top'></td></tr></table><div style='width: 100%; text-align:left;vertical-align:top; color:#000000;font-style:italic'>".MiscFunctions::format_answer($free_answer, $question->answer_type)."</div><table style='width: 95%; text-align: left'><tr><td style='width: 3%'></td><td style='width: 59%'></td><td style='width: 18%'></td><td style='width: 12%'></td><td style='width: 12%; text-align: right; vertical-align:top'></td></tr>";
				  }
				  else
				  	$html.= "<td style='width: 18%; text-align : right'></td><td style='width: 12%; text-align: right; vertical-align:top'>".$answer->points."</td><td style='width: 12%; text-align: right; vertical-align:top'></td></tr><tr><td></td><td colspan=2 style='width: 59%; text-align: left; vertical-align:top; background-color:#edeaea; color:#000000; font-style:italic'>".MiscFunctions::format_answer($free_answer, $question->answer_type)."</td><td></td></tr>";
			  }
		  }else
		  {	///the question wasn't answered - either not required or because of forumula or NA
			  if( MiscFunctions::type_is_multiple_choice($question->answer_type) )
			 	 $html .="<td style='width: 18%; text-align:right'>"._("Not Applicable")."</td><td style='width: 12%; text-align: right; vertical-align:top'>
			 	 "._("Not Scored")."</td><td style='width: 12%; text-align: right; vertical-align:top'>N/A</td></tr>";
			  else
			  	$html .="<td style='width: 18%; text-align:right'></td><td style='width: 12%; text-align: right; vertical-align:top'>"._("Not Scored")."</td><td style='width: 12%; text-align: right; vertical-align:top'>N/A</td></tr>";
		  }		
		  
		  if( $answer['comment'])
		  {
			  $comment = str_replace("<","&lt;", $answer['comment']);
				  $comment = str_replace(">","&gt;", $comment);
			  $html.="<tr><td></td><td colspan=2 style='width: 77%; text-align: left; vertical-align:top; background-color:#edeaea;  color:#000000; font-style:italic'>".MiscFunctions::format_answer($comment, 'text')."</td><td></td><td></td></tr>";
		  }
		  $html .='<tr><td colspan=5  style="width: 100%; text-align: right">';									
		
		  if ($filename && $user=="pdf" && !$no_photos) {
				 $html.='<a class="sb" href='.$filename.'>'._("View Photo").'</a>';
		  }
		  $html .='</td></tr>';
		 
		  	  
		
		}
		else
		{
			$html .="</td><td style='width: 85%; text-align: left; vertical-align:top'><strong>".$question_text."</strong></td><td style='width: 12%'></td></tr>";
		}
		  $html .="</table>
		  ";
	
        return $html;        		
	}	
}