<?php

function xp($v, $v2 = '', $v3 = '')
{
	if(defined('DEBUG') && DEBUG)
	{
		print("<pre> Var:\n");

		$data = var_export($v, true);
		if($v2) $data .= var_export($v2, true);
		if($v3) $data .= var_export($v3, true);
		print htmlspecialchars($data);
		exit;
	}	
}

function xd($v, $v2 = '', $v3 = '')
{
	if(defined('DEBUG') && DEBUG)
	{
		var_dump($v);
		exit;
	}	
}