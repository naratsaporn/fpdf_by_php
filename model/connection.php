<?php
$mysqli = new mysqli();
@$mysqli->connect(
        'localhost', // host
        'root', //username
        '', // password // 123456
        'cs_durable_articles' //database name 
);
      if(@$mysqli->connect_error){
      	echo @$mysqli->connect_error ;
		  exit(0);
      }
$mysqli->set_charset('utf8');
 	 //      'localhost', // host
   //      'id12939316_root', //username
   //      '123456', // password // 123456
   //      'id12939316_cs_durable_articles' //database name 
?>