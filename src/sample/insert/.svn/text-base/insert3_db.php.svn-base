<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=35;$x++){

	if($x == 15){
		$sql = "insert into t_test3 values(".$x.",'253-0082','横浜市磯子区磯子1丁目2番','10号システムプラザ磯子2号館','バブ日立ソフト株式会社','');";
	}else{
		$sql = "insert into t_test3 values(".$x.",'253-0082','横浜市磯子区磯子1丁目2番','10号システムプラザ磯子2号館','バブ日立ソフト株式会社','日立太郎');";
	}
	$result = pg_query($connect,$sql);
}

?>
