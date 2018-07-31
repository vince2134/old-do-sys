<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//処理内容・処理時間定義
/****************************/
$data["本部予定データ作成"]["02"] = 1;
$data["FC予定データ作成"]["02"] = 1;
$data["消費税改訂"]["58"] = 1;
$data["商品単価改訂"]["58"] = 1;
$data["DBバックアップ"]["58"] = 1;
$data["ファイルバックアップ"]["58"] = 1;

/****************************/
//バックアップ保存場所定義
/****************************/
define('Backup_DB', 1);
define('Backup_File', 1);
define('Log_File', 1);

/****************************/
//現在の時刻取得
/****************************/
$time = date("i", time()); 

/****************************/
//処理判定
/****************************/
if($data["商品単価改訂"]["$time"] == 1){
	shell_exec("echo test1 >> /home/postgres/cron.log");
}
if($data["消費税改訂"]["$time"] == 1){
	shell_exec("echo test2 >> /home/postgres/cron.log");
}
if($data["本部予定データ作成"]["$time"] == 1){
	shell_exec("echo test3 >> /home/postgres/cron.log");
}
if($data["FC予定データ作成"]["$time"] == 1){
	shell_exec("echo test4 >> /home/postgres/cron.log");
}
if($data["DBバックアップ"]["$time"] == 1){
	shell_exec("echo test5 >> /home/postgres/cron.log");
}
if($data["ファイルバックアップ"]["$time"] == 1){
	shell_exec("echo test6 >> /home/postgres/cron.log");
}

shell_exec("echo test6 >> /home/postgres/cron.log");

/****************************/
//処理結果のログ処理
/****************************/



?>
