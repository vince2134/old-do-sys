<?php

/****************************/
//契約情報ID取得処理
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    client_id ";
$sql .= "FROM ";
$sql .= "    t_contract ";
$sql .= "ORDER BY ";
$sql .= "    client_id ";
//$sql .= "LIMIT 100 OFFSET 0;"; 
//$sql .= "LIMIT 100 OFFSET 100;"; 
//$sql .= "LIMIT 100 OFFSET 200;"; 
//$sql .= "LIMIT 100 OFFSET 300;";
//$sql .= "LIMIT 100 OFFSET 400;";  
//$sql .= "LIMIT 100 OFFSET 500;"; 
//$sql .= "LIMIT 100 OFFSET 600;";
//$sql .= "LIMIT 100 OFFSET 700;"; 
//$sql .= "LIMIT 50 OFFSET 800;"; 
$sql .= "LIMIT 20 OFFSET 850;"; 
//$sql .= "LIMIT 30 OFFSET 870;"; 
//$sql .= "LIMIT 100 OFFSET 900;"; 
//$sql .= "LIMIT 100 OFFSET 1000;"; 
echo $sql;

exit; 
$result = Db_Query($db_con, $sql); 

Db_Query($db_con, "BEGIN;");
Db_Query($db_con, "LOCK TABLE t_aorder_h IN EXCLUSIVE MODE;");
$i = 0;
while($client_list = pg_fetch_array($result)){
	/****************************/
	//受注データ登録関数＆受払テーブルに登録関数     
	/****************************/
	Aorder_Query($db_con,$client_list[0]);
	$i++;
}
Db_Query($db_con, "COMMIT;");
print $i;
?>
