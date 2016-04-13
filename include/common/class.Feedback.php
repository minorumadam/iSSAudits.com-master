<?

class Feedback{
    private $type = 1;
    public $items = array();
    private $style = 1;
    private $label;
    
    function add($str){
        array_push($this->items, $str);
    }
    
    function type($str){
        if( $str == 'success' || $str == 1 )
            $this->type = 1;
        else if ($str == 'failure' || $str == 'fail' || $str == 'error' || $str == 'err' || $str == 2)
            $this->type = 2;
    }
    
    function style($str){
        if( $str == 'list' || $str == 1 )
            $this->style = 1;
        else if( $str == 'block' || $str == 2 )
            $this->style = 2;
    }
    
    function label($str){
        $this->label = $str;
    }
    
    function isEmpty(){
        if( count($this->items) > 0 )
            return false;
        else
            return true;
    }
    
    function execute(){
        $html = "";
        if( !$this->label )
            return false;
     /*   $html .= "<div class='feedback'>\n";
        if( $this->type == 1 )
            $html .= "<div class='success'>\n";
        else if( $this->type == 2 )
            $html .= "<div class='failure'>\n";
        */
		 $html .='<div class="feedback-'.($this->type==1?"success":"fail").'">
    <ul>
    <li><h3>'. $this->label . '</h3></li>';
	 if( count($this->items) > 0 ){
            if( $this->style == 1 ){
               
                foreach( $this->items as $k=>$v ){
                    $html .= "<li>" . $v . "</li>\n";
                }
            }
            else if( $this->style == 2 ){
                foreach( $this->items as $k=>$v ){
                    $html .= "<p>" . $v . "</p>\n";
                }
            }
        }
		
    
    $html .='</ul></div>';
   

       
        return $html;
    }
    
}

function gen_feedback(){
	global $feedback;
	if(is_object($feedback))
    {
		$data = $feedback->execute();
		unset($feedback);
        return $data;
	}

    return null;
}

?>