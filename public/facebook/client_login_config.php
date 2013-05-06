<?php

   require 'facebook.php';
	
	$facebook = new Facebook(array(
	  //'appId'  => '502908609754176',//test
	  //'secret' => '038456bba7356ad8cb63d2ab7015781a',//test
	  
	  'appId'  => '535298463189468',//localhost
	  'secret' => 'ed0403f08fc31c46d61b03d7f8ea808f',//localhost
	  
//	  'appId'  => '258412920957682',//thật
//	  'secret' => '2b47c7777bcbcd14d9bb432cf13c0bf5',//thật
	  'cookie' => true,
	));

?>
