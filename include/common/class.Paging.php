<?

///////////////////////////////////////////////////////
//////  THIS CODE DEVELOPED BY BENJAMIN PITTMAN ///////
//////              www.bpittman.com            ///////
///////////////////////////////////////////////////////

class Paging{
    private $page;
    private $per_page;
    private $data;
    
    function is_ready(){
        if(!$this->page || $this->page < 0)
            $this->page = 1;
        if(
            ($this->data && is_array($this->data)) &&
            ($this->per_page && is_numeric($this->per_page)) &&
            (is_numeric($this->page))
          )
            return true;
        else
            return false;
    }
    
    function set_page($page){
        if(is_numeric($page))
            $this->page = $page;
    }
   
    function set_limit($per_page){
        if(is_numeric($per_page))
            $this->per_page = $per_page;
    }
    
    // Add the data to be separated into pages.
    function set_data($data){
        if(is_array($data)){
            $this -> data = $data;
        }
    }
    
    function num_pages(){
        if($this->is_ready()){
            $count = count($this->data);
            $count = ceil($count / $this->per_page);
            return $count;
        }
    }
    
    function next_page(){
        if($this->is_ready()){
            if($this->page < $this->num_pages()){
                return $this->page + 1;
            }
            else return false;
        }
    }
    
    function prev_page(){
        if($this->is_ready()){
            if($this->page > $this->num_pages())
                $this->page = $this->num_pages();
            if($this->page > 1){
                return $this->page - 1;
            }
            else return false;
        }
    }
    
    function return_paged(){
        if($this->is_ready()){
            $counter = 0;
            $data = $this->data;
            $page = $this->page;
            if(!$page)
                $page = 1;
            if($page > $this->num_pages())
                $page = $this->num_pages();
            $stop = $page * $this->per_page;
            $start = $stop - $this->per_page;
            $result = array();
            foreach($data as $k=>$v){
                $counter++;
                if($counter > $start && $counter <= $stop){
                    $result[$k] = $v;
                }
            }
            return $result;
        }
    }

    // Rebuilds and echoes out your current $_GET array.
    // Pass a key name to exclude it from the function (especially useful when you want to update one of the variables)
    function rebuildGET($target){
        foreach($_GET as $k=>$v){
            if($k != $target){
                $result.=$sep.($k.'='.$v);
                $sep = '&';
            }
        }
        return $result;
    }
    
    // Returns HTML with page links, with current page active.
    // Set $limit to limit how many page links appear.
    function pages_html($limit = false){
        if($this->is_ready()){
            $pages = $this->num_pages();
            if($pages > 1){
                $page = $this->page;
                if(!$page)
                    $page = 1;
                if($page > $pages)
                    $page = $pages;
                $prev_page = $this->prev_page();
                $next_page = $this->next_page();
                $result = array();
                if($limit && is_numeric($limit)){
                    if($pages > $limit){
                        $left = round($limit / 2);
                        $startPoint = $page - ($left - 1);
                        if($startPoint < 1)
                            $startPoint = 1;
                        $endPoint = $startPoint + ($limit - 1);
                        if($endPoint > $pages){
                            $endPoint = $pages;
                            $startPoint = $endPoint - ($limit - 1);
                        }
                    }
                }
                // Set an array with the pages.
                for($x = 1; $x <= $pages; $x++){
                    if(
                        (!$startPoint || !$endPoint) ||
                        ($x >= $startPoint && $x <= $endPoint)
                    ){
                        $result[] = $x;
                    }
                }
                $html = "\n";
                $html .= '<div class="Paging">' . "\n";
                if($prev_page)
                    $html .= ' <a href="?' . $this->rebuildGET('p') . '&p=' . $prev_page . '" class="prev">Prev</a> ' . "\n";
                foreach($result as $k=>$v){
                    if($page != $v)
                        $html .= ' <a href="?' . $this->rebuildGET('p') . '&p=' . $v . '">' . $v . '</a> ' . "\n";
                    else
                        $html .= ' <span class="active">' . $v . '</span> ' . "\n";
                }
                if($next_page)
                    $html .= ' <a href="?' . $this->rebuildGET('p') . '&p=' . $next_page . '" class="next">Next</a> ' . "\n";
                $html .= "</div>";
                return $html;
            }
        }
    }
}

?>