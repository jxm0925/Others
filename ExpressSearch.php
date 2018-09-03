<?php
function getcontent($url){
	$oCurl = curl_init();
	if(stripos($url,"https://")!==FALSE){
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
	}
	curl_setopt($oCurl, CURLOPT_URL, $url);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	curl_close($oCurl);
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		return false;
	}
}


function expressname($order)
{
	$name = json_decode(getcontent("http://www.kuaidi100.com/autonumber/auto?num={$order}"), true);
	$result = $name[0]['comCode'];
	if (empty($result)) {
			return false;
	} else {
			return $result;
	}
}

function json_array($arr){
	if($arr){
		foreach ((array)$arr as $key => $value) {
			$data[$key] = !is_string($value)?json_array($value):$value;
		}
		return $data;
	}
}


function getorder($order)
{
	$keywords = expressname($order);
	if (!$keywords) {
			return false;
	} else {
		$result = getcontent("http://www.kuaidi100.com/query?type={$keywords}&postid={$order}");
		$data = json_decode($result,true);

		//$result = json_array($data);
		return $data;
	}
}
$data = getorder('3369808736266');
$json = json_encode($data['data'], JSON_UNESCAPED_UNICODE);
var_dump($data);