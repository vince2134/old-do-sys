<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=300;$x++){
	if($x==1 || $x==30 || $x==60 || $x==90 || $x==120 || $x==150 || $x==180 || $x==210 || $x==240 || $x==270){
		$count = $x;
		//データ挿入SQL
		$sql = "insert into t_payin values(".$x.",'取引区分".$x."','東京三菱','00010001','得意先".$x."','2005-04-11',10000,1000,'2005-04-13',1000,'');";
	}else{
		$sql = "insert into t_payin values(".$x.",'取引区分".$count."','東京三菱','00010001','得意先".$x."','2005-04-01',10000,1000,'2005-04-13',1000,'');";
	}
	$result = pg_query($connect,$sql);
}

?>
