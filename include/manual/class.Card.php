<?
// This is primarily used for to handle shops.  It does not account for answers
class Card{
	
	public $id;
	public $commendcard = array();
	public $questions = array();
	public $sections = array();
	
	function __construct($id, $user=false){
		if( !$id or !is_numeric($id) )
			return false;
		$this->retrieve($id, $user);
	}
	
	function retrieve($id, $user=false){
		if( !$id or !is_numeric($id) )
			return false;
		if( $user and !is_numeric($user) ) 
			return false;
		$db = getDB();
		$d = $db->query("
			SELECT commentcards.*,
			clients.company AS client,
			clients.msp_id
			FROM commentcards 
			JOIN clients ON clients.id = commentcards.client_id
			WHERE commentcards.id = '$id'
		");
		echo $db->error();
			
		if( $d ){
			$d = $d[0];
			$this->id = $d['id'];
			$this->commentcard = $d;
		}
		
		return $d;
	}
	
	function retrieveQuestions(){
		if( !$this->isReady() )
			return false;
		$db = getDB();
		$questions = $db->query("
			SELECT commentcard_questions.*,
			questions.question,
			questions.question_client,
			questions.tip,
			questions.answers,
			questions.answer_values,
			questions.answer_order,
			questions.answer_type,
			questions.allow_comment,
			questions.min_char,
			questions.hide,
			questions.photo_required,
			questions.allow_photo,
			questions.min_price,
			questions.max_price,
			shop_sections.name AS section_name
			FROM commentcard_questions
			LEFT JOIN shop_sections ON shop_sections.id = commentcard_questions.section_id
			LEFT JOIN questions ON questions.id = commentcard_questions.question_id
			WHERE commentcard_questions.commentcard_id = '$this->id'
			AND commentcard_questions.deleted_at = 0
			ORDER BY commentcard_questions.order ASC
		");
		echo $db->error();
		$l = array();
		if($questions)foreach($questions as $v)
			$l[$v['id']] = $v;
		
		$counter = 0;
		if($l)foreach($l as $k=>$v){
			if( !$v['hide'] && ($v[answer_type] !="info") ){
				$counter++;
				$l[$k]['QuestionNumber'] = $counter;
			}
			if( MiscFunctions::type_is_multiple_choice($v['answer_type']) )
				$l[$k]['answers'] = MiscFunctions::parse_answers($v['answers']);
		}
		
		$this->questions = $l;
		
		return $l;
	}
	
	function retrieveSections(){
		if( !$this->isReady() )
			return false;
		$db = getDB();
		$l = array();
		$t = $db->query("SELECT DISTINCT shop_sections.*
						FROM commentcard_questions
						JOIN shop_sections ON commentcard_questions.section_id_report = shop_sections.id
						WHERE commentcard_questions.commentcard_id = '$this->id'
						AND commentcard_questions.deleted_at = 0
						ORDER BY commentcard_questions.order ASC");
		
		if($t)foreach($t as $v)
		{
			//print "count sections".$v['id'];
			$l[$v['id']] = $v;
		}
		$this->sections = $l;
		return $l;
	}
	
	function checkSection($name){
		if( !$this->isReady() )
			return false;
		if( !$this->sections )
			$this->retrieveSections();
		if($this->sections)foreach($this->sections as $v)
			if( $v['name'] == $name )
				return $v['id'];
	}
	

	
	function retrieveSectionQuestions($id,$report=false){
		if( !$this->isReady() )
			return false;
		if( !$id or !is_numeric($id) )
			return false;
		
		if( !$this->questions )
			$this->retrieveQuestions();
		
		$l = array();
		
		if($this->questions)foreach($this->questions as $k=>$v){
			if ($report)
			{
				if( $v['section_id_report'] == $id )
					$l[$k] = $v;
			}
			else
			{
				if( $v['section_id'] == $id )
					$l[$k] = $v;

			}
		}
		///  This sets the question # if numbering by section
		$counter = 0;
		if($l)foreach($l as $k=>$v){
			if( (!$v['hide']||!$report) && ($v[answer_type] !="info") ){
				$counter++;
				$l[$k]['QuestionNumber'] = $counter;
			}	
		}
		return $l;
	}
	
	
	
	function isReady(){
		if( !$this->id )
			return false;
		return true;
	}
	
	function check_app_compatible(){
		if( !$this->isReady() )
			return false;
		
		$msg="";
		///first count sections
		$this->retrieveQuestions();	
		$sections = $this->retrieveSections(false);
	//	if (count($sections)<2)  $msg .="Shopper Facing form must have at least two sections. ";
	//	if (count($sections)>6)  $msg .="Shopper Facing form must have six or less sections. ";
		
		$check_all=false;
		$price=false;
		// Check # questions in each section
		if ($sections) foreach ($sections AS $k=>$v)
		{
			$questions=	$this->retrieveSectionQuestions($k,$false);
	//		if (count($questions)<2)  $msg .="$v[name] must have at least two questions. ";
			if( $questions) foreach ($questions AS $k=>$v)
			{
			//	if ($v[answer_type]=="check_all") $check_all=true;
				if ($v[answer_type]=="price") $price=true;
			}
		}
		
		//
	//	if ($check_all)
	//		$msg .="Check All that Apply Questions are not compatible";
		if ($price)
			$msg .="Price Audit Questions are not compatible w/ comment cards";	

		return $msg;		
	}
	
	function get_list($client_id, $survey=false)
	{
		$db = getDB();
		$q = "
			SELECT commentcards.*,
			clients.company,
			clients.msp_id
			FROM commentcards
			JOIN clients ON commentcards.client_id = clients.id
			WHERE 1 
			AND commentcards.deleted_at = 0
			" . ($survey ? "AND survey = 1" : "AND survey = 0") . "
		";
		$q .= " AND commentcards.client_id = '$client_id'";
					
		$q .=" ORDER BY id DESC";
		
		$l = $db->query($q);
		echo $db->error();
		return $l;
	}
	
	
	function get_select_list($client_id, $survey=false){
		$db = getDB();
		$t = Card::get_list($client_id, $survey);
		if($t)foreach($t as $v)
			$l[$v['id']] = $v['name'];
		unset($t);
		return $l;
	}
	
	
	function show_answer_preview($question_id, $QuestionNumber,$client=false){
		// users can be admin, shopper, merchant, pdf
		import ("class.Answer");
		global $db;
		
		if( !$db )
			$db = new MySQLDB;
		if( !$question_id or !is_numeric($question_id) )
			return false;
		if( !$this->questions )
			$this->retrieveQuestions();	
				
		$question = $this->questions[$question_id];
		
		$html=Answer::show_preview($question, $QuestionNumber,$client);
		
        return $html;        		
	}	
	
	
	function copy_card($id)
	{
		
		if( !$id or !is_numeric($id) )
			return false;
		
		$db = getDB();
		$d = $db->query("
			SELECT commentcards.*
			FROM commentcards 
			WHERE commentcards.id = '$id'
		");
		
			
		if( $d ){
			$d = $d[0];
			$q = array();
			$q[client_id]=$d[client_id];
			$q[name]=$d[name]." #2";
			$q[points]=$d[points];
			$q[required_version]=$d[required_version];
			$q[summary]=$d[summary];
			$q[default_summary]=$d[default_summary];
			$q[highlight]=$d[highlight];
			$q[description]=$d[description];
			$q[confirmation_text]=$d[confirmation_text];
			$q[updated_at] = date("Y-m-d H:i:s", time()+TIME_OFFSET);
			$q[created_at] = date("Y-m-d H:i:s", time()+TIME_OFFSET);
			
			$db->buildInsert($q, 'commentcards');
			if ($db->error())
			{
				echo $db->error();
				//exit;
			}
			$new_id= $db->insert_id();
		}
		
		$d = $db->query("
			SELECT commentcard_questions.*
			FROM commentcard_questions 
			WHERE commentcard_questions.commentcard_id = '$id'
			AND commentcard_questions.deleted_at = 0
		");
		
		if ($d && $new_id) foreach ($d as $card_question)
		{
			$q = array();
			$q[question_id]=$card_question[question_id];
			$q[commentcard_id] = $new_id;
			$q[required]=$card_question[required];
			$q[required_formula]=$card_question[required_formula];
			$q[created_at]=time();
			$q[section_id]=$card_question[section_id];
			$q[section_id_report]=$card_question[section_id_report];
			$q[score]=$card_question[score];
			$q[rated]=$card_question[rated];
			$q[order]=$card_question[order];
			
			
			$db->buildInsert($q, 'commentcard_questions');
			if ($db->error())
			{
				echo $db->error();
				//exit;
			}
		}
		
	}

}

?>