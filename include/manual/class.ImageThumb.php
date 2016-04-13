<?php

class ImageThumb{
	
	public $width = 0;
	public $height = 0;
	public $source;
	public $destination;
	public $name;
	public $expandWhenSmaller = true;
	
	function set_max_dimensions($width, $height){
		if( $width and $height and is_numeric($width) and is_numeric($height) ){
			$this->width = $width;
			$this->height = $height;
			return true;
		}
	}
	
	function set_source($file){
		if( $file and file_exists($file) ){
			$this->source = $file;
			return true;
		}
	}
	
	function set_destination($dest){
		if( substr($dest, -1) != '/' )
			$dest = $dest . '/';
		if( !is_dir($dest) )
			mkdirfull($dest);
		if( is_dir($dest) ){
			$this->destination = $dest;
			return true;
		}
	}
	
	function set_name($name){
		$this->name = $name;
	}
	
	function isReady(){
		if( $this->width
			and $this->height
			and $this->source
			and $this->destination
			and $this->name
			)
			return true;
		else
			return false;
	}
	
	function execute(){
		
		if( !$this->isReady() )
			return false;
		
		ini_set('memory_limit', '100M');   //  handle large images
		
		list($w_src, $h_src, $type) = getimagesize($this->source);
		if (!$w_src)
			return false;
		if(	$this->width<$w_src)
			$w_dst = $this->width;
		else
			$w_dst =$w_src;
		
		if(	$this->height<$h_src)
			$h_dst = $this->height;
		else
			$h_dst =$h_src;	
		
		$file_src = $this->source;
		
		$ratio = $w_src/$h_src;
		if ($w_dst/$h_dst > $ratio)
			$w_dst = floor($h_dst*$ratio);
		else
			$h_dst = floor($w_dst/$ratio);
	
		switch ($type){
			case 1:   //   gif -> jpg
				$img_src = imagecreatefromgif($file_src);
				break;
			case 2:   //   jpeg -> jpg
				$img_src = imagecreatefromjpeg($file_src);
				break;
			case 3:  //   png -> jpg
				$img_src = imagecreatefrompng($file_src);
				break;
		}
		$img_dst = imagecreatetruecolor($w_dst, $h_dst);
	  
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $w_dst, $h_dst, $w_src, $h_src);
		
		@unlink($this->destination . $this->name);
		
		imagejpeg($img_dst, $this->destination . $this->name);
	
		imagedestroy($img_src);
		imagedestroy($img_dst);
		return true;
	}
	
	function iptc_make_tag($rec, $data, $value)
	{
		$length = strlen($value);
		$retval = chr(0x1C) . chr($rec) . chr($data);
	
		if($length < 0x8000)
		{
			$retval .= chr($length >> 8) .  chr($length & 0xFF);
		}
		else
		{
			$retval .= chr(0x80) . 
					   chr(0x04) . 
					   chr(($length >> 24) & 0xFF) . 
					   chr(($length >> 16) & 0xFF) . 
					   chr(($length >> 8) & 0xFF) . 
					   chr($length & 0xFF);
		}
	
		return $retval . $value;
	}
	
	function embed_iptc_data($path, $caption, $original_date, $phone, $latlon)
	{
		
		if (!$path ||!file_exists($path))
			return false;
		//mail("jennifer@isecretshop.com","here", print_r($iptc,1)."$path");
		if(!function_exists('iptcembed')) return false;
		$iptc = array(
			'2#120' => $caption,
			'2#116' => 'Copyright 2013, iSecretShop',
			'2#055' => $original_date,  //creation date, 
			'2#022' => $phone,   //device type, 
			'2#103' => $latlon   //original transmission
		);
		
		// Convert the IPTC tags into binary code
		$data = '';
		//mail("jennifer@isecretshop.com","file properties", print_r($iptc,1));
		foreach($iptc as $tag => $string)
		{
			$tag = substr($tag, 2);
			$data .= ImageThumb::iptc_make_tag(2, $tag, $string);
		}
		
		// Embed the IPTC data
		$content = iptcembed($data, $path);
		
		// Write the new image data out to the file.
		$fp = fopen($path, "wb");
		fwrite($fp, $content);
		fclose($fp);	
	}
	
	function get_iptc_data($filename)
	{
		//mail("jennifer@isecretshop.com","in get data",$filename);
		if (!$filename ||!file_exists($_SERVER['DOCUMENT_ROOT'].$filename))
			return false;
		$size = getimagesize( $_SERVER['DOCUMENT_ROOT'].$filename, &$info); 
		
		if (isset($info["APP13"])) {
			if($iptc = iptcparse( $info["APP13"] ) ) {
						$IPTC_Caption = str_replace( "\000", "", $iptc["2#120"][0] );
						if(isset($iptc["1#090"]) && $iptc["1#090"][0] == "\x1B%G")
							$IPTC_Caption = utf8_decode($IPTC_Caption);					
			}
			
			if ($iptc)
			{
				$newiptc = array();
				foreach ($iptc AS $k=>$v)
					$newiptc[$k]=$v[0];
				//mail("jennifer@isecretshop.com","newiptc",print_r($newiptc,1));	
				return $newiptc;
			}
			
		}
		return false;
		
	}	
}
?>