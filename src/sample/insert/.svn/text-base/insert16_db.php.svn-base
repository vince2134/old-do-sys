<?php

//DB実行
$connect = pg_connect("dbname=amenity_test user=postgres");
$y = 10;
for($x=1;$x<=99;$x++){
	if($x<=9){
		//データ挿入SQL
		$sql = "insert into t_article values(".$x.",'担当者1','1000100".$x."','商品".$x."',10);";
	}else if($x<=30){
		//データ挿入SQL
		$sql = "insert into t_article values(".$x.",'担当者2','100010".$x."','商品".$x."',10);";
	}else if($x<=60){
		//データ挿入SQL
		$sql = "insert into t_article values(".$x.",'担当者3','100010".$y."','商品".$y."',10);";
		$y++;
	}else if($x<=99){
		//データ挿入SQL
		$sql = "insert into t_article values(".$x.",'担当者4','100010".$y."','商品".$y."',10);";
		$y++;
	}
	if($x == 60){
		$y = 10;
	}
	$result = pg_query($connect,$sql);
}

?>
