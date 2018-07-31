<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=50;$x++){
	if($x<=9){
		//データ挿入SQL
		$sql = "insert into t_goods_group values(".$x.",'0000000".$x."','商品".$x."');";
	}else{
		//データ挿入SQL
		$sql = "insert into t_goods_group values(".$x.",'000000".$x."','商品".$x."');";
	}
	$result = pg_query($connect,$sql);
}

?>
