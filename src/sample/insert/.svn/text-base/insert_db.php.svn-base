<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=300;$x++){
	if($x==1 || $x==30 || $x==60 || $x==90 || $x==120 || $x==150 || $x==180 || $x==210 || $x==240 || $x==270){
		$count = $x;
		//データ挿入SQL
		$sql = "insert into t_test values(".$x.",'商品".$x."','担当者".$x."','部門".$x."',10000,20000,30000,40000,50000);";
	}else{
		$sql = "insert into t_test values(".$x.",'商品".$count."','担当者".$x."','部門".$x."',10000,20000,30000,40000,50000);";
	}
	$result = pg_query($connect,$sql);
}

?>
