<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=210;$x++){
	//データ挿入SQL
	$sql = "insert into t_sale values(".$x.",'2005-04-01','得意先".$x."',3675,3675,0,0,3500,175,3675,3675,'部門".$x."','担当者".$x."');";
	$result = pg_query($connect,$sql);
}

?>
