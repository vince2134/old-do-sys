<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect("amenity_test");

//倉庫１
for($x=1;$x<=150;$x++){

	if(1 <= $x && 10 > $x){
		//データ挿入SQL
		$sql = "insert into t_s_details values(".$x.",'仕入先1','00000001','2005-04-01','商品".$x."',10,1000,10000,'');";
	}

	if(10 <= $x && 30 >= $x){
		//データ挿入SQL
		$sql = "insert into t_s_details values(".$x.",'仕入先1','00000002','2005-04-01','商品".$x."',10,1000,10000,'');";
	}

	if(31 <= $x && 47 >= $x){
		//データ挿入SQL
		$sql = "insert into t_s_details values(".$x.",'仕入先2','00000003','2005-04-01','商品".$x."',10,1000,10000,'');";
	}

	if(48 <= $x && 70 >= $x){
		//データ挿入SQL
		$sql = "insert into t_s_details values(".$x.",'仕入先2','00000004','2005-04-01','商品".$x."',10,1000,10000,'');";
	}

	if(71 <= $x && 90 >= $x){
		//データ挿入SQL
		$sql = "insert into t_s_details values(".$x.",'仕入先3','00000005','2005-04-01','商品".$x."',10,1000,10000,'');";
	}

	if(91 <= $x && 100 >= $x){
		//データ挿入SQL
		$sql = "insert into t_s_details values(".$x.",'仕入先3','00000006','2005-04-01','商品".$x."',10,1000,10000,'');";
	}

	if(101 <= $x && 150 >= $x){
		//データ挿入SQL
		$sql = "insert into t_s_details values(".$x.",'仕入先3','00000007','2005-04-01','商品".$x."',10,1000,10000,'');";
	}

	$result = Db_Query($db_con,$sql);
}

?>
