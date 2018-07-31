<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=300;$x++){
	if($x==1 || $x==30 || $x==60 || $x==90 || $x==120 || $x==150 || $x==180 || $x==210 || $x==240 || $x==270){
		$count = $x;
		//データ挿入SQL
		$sql = "insert into t_reser values(".$x.",'担当者".$x."','得意先','00010001','2005-04-11','商品1','区分1',10,1000,10000,'備考1','○','理由1');";
	}else{
		$sql = "insert into t_reser values(".$x.",'担当者".$count."','得意先','00010001','2005-04-11','商品1','区分1',10,1000,10000,'備考1','○','理由1');";
	}
	$result = pg_query($connect,$sql);
}

?>
