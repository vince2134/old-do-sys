<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<10;$x++){
	$sql = "insert into t_calendar values('20051201','担当者BB','得意先".$x."','000".$x."');";
	$result = pg_query($connect,$sql);
}

?>
