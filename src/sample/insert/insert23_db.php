<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=3;$x++){
	//データ挿入SQL
	$sql = "insert into t_op_maney values('入力者1','2005-04-0".$x."',55791,183250,0,0,2100);";
	$result = pg_query($connect,$sql);
}

for($x=1;$x<=3;$x++){
	//データ挿入SQL
	$sql = "insert into t_op_maney values('入力者2','2005-04-0".$x."',55791,183250,0,0,2100);";
	$result = pg_query($connect,$sql);
}

for($x=1;$x<=3;$x++){
	//データ挿入SQL
	$sql = "insert into t_op_maney values('入力者3','2005-04-0".$x."',55791,183250,0,0,2100);";
	$result = pg_query($connect,$sql);
}

?>
