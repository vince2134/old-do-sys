<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=50;$x++){
	if($x<=10){
		//データ挿入SQL
		$sql = "insert into t_goods_gr values(1,'グループ1','コメント1',".$x.");";
	}else if($x>=11 && $x<=20){
		$sql = "insert into t_goods_gr values(2,'グループ2','コメント1',".$x.");";
	}else if($x>=21 && $x<=30){
		$sql = "insert into t_goods_gr values(3,'グループ3','コメント1',".$x.");";
	}else if($x>=31 && $x<=40){
		$sql = "insert into t_goods_gr values(4,'グループ4','コメント1',".$x.");";
	}else if($x>=41 && $x<=50){
		$sql = "insert into t_goods_gr values(5,'グループ5','コメント1',".$x.");";
	}
	$result = pg_query($connect,$sql);
}

?>
