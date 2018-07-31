<?php

$data[0] = array('11','掛売上','1');
$data[1] = array('12','掛売上(-)','1');
$data[2] = array('13','掛返品','1');
$data[3] = array('14','掛値引','1');
$data[4] = array('18','預け貸出','1');
$data[5] = array('19','預け戻り','1');
$data[6] = array('61','現金売上','1');
$data[7] = array('62','現金売上(-)','1');
$data[8] = array('63','現金返品','1');
$data[9] = array('64','現金値引','1');

$data[10] = array('31','現金入金','2');
$data[11] = array('35','現金入金(-)','2');
$data[12] = array('32','振込入金','2');
$data[13] = array('33','手形入金','2');
$data[14] = array('34','相殺','2');
$data[15] = array('38','スイット相殺','2');
$data[16] = array('39','入金調整','2');
$data[17] = array('37','その他入金','2');

$data[18] = array('21','掛仕入','3');
$data[19] = array('22','掛仕入(-)','3');
$data[20] = array('23','掛返品','3');
$data[21] = array('24','掛値引','3');
$data[22] = array('71','現金仕入','3');
$data[23] = array('72','現金仕入(-)','3');
$data[24] = array('73','現金返品','3');
$data[25] = array('74','現金値引','3');

$data[26] = array('41','現金支払','4');
$data[27] = array('42','現金支払(-)','4');
$data[28] = array('43','振込支払','4');
$data[29] = array('44','手形支払','4');
$data[30] = array('45','相殺','4');
$data[31] = array('46','支払調整','4');
$data[32] = array('47','その他支払','4');

//DB接続
$connect = pg_connect("dbname=amenity user=postgres");
for($x=0;$x<count($data);$x++){
	$sql = "insert into t_trade values('".$data[$x][0]."','".$data[$x][1]."','".$data[$x][2]."');";
	$result = pg_query($connect,$sql);
}

?>
