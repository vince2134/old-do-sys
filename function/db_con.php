<?php
//DB接続
$connect = pg_connect("dbname=amenity user=postgres");
//接続エラー判定
if($connect == false)
{
	print "DBと接続できません";
	exit;
}
?>
