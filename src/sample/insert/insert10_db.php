<?php

//DB¼Â¹Ô
$connect = pg_connect("dbname=amenity_test user=postgres");

for($x=1;$x<=210;$x++){
	if($x==1 || $x==30 || $x==60 || $x==90 || $x==120 || $x==150 || $x==180){
		$count = $x;
		//¥Ç¡¼¥¿ÁÞÆþSQL
		$sql = "insert into t_stock values(".$x.",'2005-04-01','£Í¶èÊ¬".$x."','¾¦ÉÊ".$x."','ÁÒ¸Ë1',10,1000,10000);";
	}else{
		$sql = "insert into t_stock values(".$x.",'2005-04-01','£Í¶èÊ¬".$count."','¾¦ÉÊ".$x."','ÁÒ¸Ë1',10,1000,10000);";
	}
	$result = pg_query($connect,$sql);
}

?>
