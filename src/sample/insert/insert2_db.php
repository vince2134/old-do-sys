<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");
//ショップ１
for($x=1;$x<=300;$x++){

	if($x==1 || $x==30 || $x==60 || $x==90 || $x==120 || $x==150 || $x==180 || $x==210 || $x==240 || $x==270){
		$count = $x;
		//データ挿入SQL
		$sql = "insert into t_test2 values(".$x.",'ショップ1','2005-11-6 16:03','得意先".$x."','商品".$x."','100',1,'100','');";
	}else{
		$sql = "insert into t_test2 values(".$x.",'ショップ1','2005-11-6 16:03','得意先".$count."','商品".$x."','100',1,'100','');";
	}

	$result = pg_query($connect,$sql);
}
//ショップ２
for($x=1;$x<=120;$x++){
$y = $x + 300;
	if($x==1 || $x==30 || $x==60 || $x==90){
		$count = $x;
		//データ挿入SQL
		$sql = "insert into t_test2 values(".$y.",'ショップ2','2005-11-6 12:03','得意先".$x."','商品".$x."','100',1,'100','');";
	}else{
		$sql = "insert into t_test2 values(".$y.",'ショップ2','2005-11-6 12:03','得意先".$count."','商品".$x."','100',1,'100','');";
	}

	$result = pg_query($connect,$sql);
}

?>
