<?





function ajax_SaveAnswer($data){

	if( !$data['id'] || !is_numeric($data['id']) )

		return false;

		

	import("class.clientAPI");

	$api =	new ISSAPI();

	$l =  $api->querydb('Client',array('query_type'=>'levels','level_id'=>$data[id]),"array");

	

	if($l)foreach($l as $k=>$v)

		$cat[$k] = $v;

	if( $cat ){

		echo '<option value="0">Choose</option>';

		echo select_list_gen($cat);

		

	}

	else

		echo '<option value="0">Choose</option>';

}







?>