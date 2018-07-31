<?php

//DB実行
$connect = pg_connect("dbname=amenity_test user=postgres");
for($i=1;$i<1000;$i++){
	$sql .= "insert into t_payable values('20050401','仕入先".$i."','3675','3675','0','0','3500','175','3675','3675');";
}
	$result = pg_query($connect,$sql);

?>