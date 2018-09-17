<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//処理内容・処理時間定義
/****************************/
$data["在庫テーブル更新"]["00"] = 1;
$data["商品単価改定"]["00"] = 1;
$data["消費税改定"]["00"] = 1;
$data["本部予定データ作成"]["02"] = 1;
$data["FC予定データ作成"]["02"] = 1;
$data["レンタルTOレンタル"]["02"] = 1;
$data["DBバックアップ"]["05"] = 1;
$data["ファイルバックアップ"]["05"] = 1;

/****************************/
//現在の時刻取得
/****************************/
$time = date("H", time()); 

/****************************/
//処理判定
/****************************/
if($data["在庫テーブル更新"]["$time"] == 1){
	//在庫テーブル更新処理実行
	require_once("./t_stock_renew.php");
}
if($data["商品単価改定"]["$time"] == 1){
	//単価設定処理実行
	require_once("./change_goods_price.php");
}
if($data["消費税改定"]["$time"] == 1){
	//消費税改定処理実行
	require_once("./change_tax.php");
}
if($data["本部予定データ作成"]["$time"] == 1){
	
}
if($data["FC予定データ作成"]["$time"] == 1){
	//受注データ作成処理実行
	require_once("./create_plan_data.php");
}
if($data["レンタルTOレンタル"]["$time"] == 1){
	//レンタルデータ作成処理実行
	require_once("./create_rental.php");
}
if($data["DBバックアップ"]["$time"] == 1){
	
}
if($data["ファイルバックアップ"]["$time"] == 1){
	
}

?>
