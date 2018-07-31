<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();


/****************************/
//巡回日情報取得処理
/****************************/
$sql  = "SELECT ";
$sql .= "    goods_cd, ";
$sql .= "    goods_name,";
$sql .= "    goods_cname ";
$sql .= "FROM ";
$sql .= "    t_goods;";
$result = Db_Query($db_con, $sql); 

while($con_list = pg_fetch_array($result)){

	$goods_cd    = $con_list[0];  
	$goods_name  = $con_list[2];  
	$goods_cname = $con_list[3];  

	if(mb_strlen($goods_cname, "EUC-JP") >= 8){
		print "cd: ".$goods_cd."<br>";
		print "name: ".$goods_name."<br>";
		print "cname: ".$goods_cname."<br>";
	}
}
?>
