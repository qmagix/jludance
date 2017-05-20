<?php
/*
 * Created on Dec 3, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
function endsWith($str, $text){   
	$rest = substr($text, -strlen($str));     
	if($rest == $str){   
	    return true;   
	}else{   
	    return false;   
	}   
}   
 
function hasSuffix($suf,$text){
	return endWith($suf,$text);
}

function getMatch($arr,$pattern){
	$res=array();
	foreach ($arr as $x){
	 if(strpos($x,$pattern)!==FALSE){
	 	$res[]=$x;
	 }
	}
	return $res;
}
function getMatchCounts($arr,$patterns){
	$res=array();	
	foreach ($patterns as $pattern){	 
	 	$res[$pattern]=count(getMatch($arr,$pattern));	 
	}
	return $res;
}

if ( ! function_exists('random_string'))
{
	function random_string($type = 'alnum', $len = 8)
	{
		switch($type)
		{
			case 'alnum'	:
			case 'numeric'	:
			case 'nozero'	:

				switch ($type)
				{
					case 'alnum'	:	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
					case 'numeric'	:	$pool = '0123456789';
					break;
					case 'nozero'	:	$pool = '123456789';
					break;
				}

				$str = '';
				for ($i=0; $i < $len; $i++)
				{
				$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
				}
				return $str;
				break;
				case 'unique' : return md5(uniqid(mt_rand()));
				break;
		}
		}
	}

?>
