<?php

//DB¼Â¹Ô
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=130;$x++){
	if($x<=30){
		//¥Ç¡¼¥¿ÁÞÆþSQL
		$sql = "insert into t_restock values(".$x.",'ÁÒ¸Ë1','2005-04-01','¾¦ÉÊ".$x."',10,10000);";
	}else if($x<=60){
		//¥Ç¡¼¥¿ÁÞÆþSQL
		$sql = "insert into t_restock values(".$x.",'ÁÒ¸Ë1','2005-04-02','¾¦ÉÊ".$x."',10,10000);";
	}else if($x<=90){
		//¥Ç¡¼¥¿ÁÞÆþSQL
		$sql = "insert into t_restock values(".$x.",'ÁÒ¸Ë2','2005-04-03','¾¦ÉÊ".$x."',10,10000);";
	}else if($x<=130){
		$sql = "insert into t_restock values(".$x.",'ÁÒ¸Ë3','2005-04-04','¾¦ÉÊ".$x."',10,10000);";
	}
	$result = pg_query($connect,$sql);
}

?>
