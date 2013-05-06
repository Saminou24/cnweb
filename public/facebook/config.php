<?php

require 'facebook.php';

$host = $_SERVER["HTTP_HOST"];

if(isset($clientlogin) && $clientlogin == 1){
	//login by funnyphoto App
	
	if(strpos($host, 'photo.qplay.vn') !== false){
		  $appId  = '258412920957682';//thật
		  $secret = '2b47c7777bcbcd14d9bb432cf13c0bf5';//thật
	}else if(strpos($host, 'photo.yome.vn') !== false){
		  $appId  = '427175337359024';//test
		  $secret = '3f76f52dde5c4b703b6bd50491627cf4';//test
	}else if(strpos($host, 'localhost') !== false){
		  $appId  = '409217722499983';//localhost
		  $secret = 'c347e2f8f25e2a97c91e3ae77ce4b743';//localhost
	}
}else{
	if(strpos($host, 'photo.qplay.vn') !== false){
		  $appId  = '130500477097689';//thật
		  $secret = 'a399d90306d5a0e5a0ddf10347c4825e';//thật
	}else if(strpos($host, 'photo.yome.vn') !== false){
		  $appId  = '502908609754176';//test
		  $secret = '038456bba7356ad8cb63d2ab7015781a';//test
	}else if(strpos($host, 'localhost') !== false){
		  $appId  = '435567153177334';//localhost
		  $secret = '640424b97bcd06b2daff78de89c5e6e5';//localhost
	}
}

$facebook = new Facebook(array(
	  'appId'  => $appId,//thật
	  'secret' => $secret,//thật
	  'cookie' => true,
));



?>
