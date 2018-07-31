<?php

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

//部署マスタの値取得
Log_Save($db_con,'direct','1','0001','直送先コード');



?>
