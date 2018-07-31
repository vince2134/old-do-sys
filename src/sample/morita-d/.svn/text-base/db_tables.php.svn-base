<?php
/**
 * 概要 全テーブルの件数を表示します。
 *
 * 説明
 *
 */

//対象DB
$l_db_name="amenity_morita";

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect($l_db_name);

$sql = "SELECT tablename from pg_tables where schemaname='public' ORDER BY tablename;";
$result = Db_Query($db_con, $sql);


while ( $table_name = pg_fetch_array($result) ) {
    //各テーブルの件数取得
    $sql     = "SELECT COUNT(*) FROM $table_name[0];";
    $result2 = Db_Query($db_con, $sql);
    $row     = pg_fetch_result($result2,0,0); 

    $t_data .= "<tr><td>$table_name[0]</td><td>$row</td></tr>";
}


//表示
echo <<<PRINT_HTML
【全テーブル件数】
<table border=\"1\">
<th>テーブル名</th>
<th>件数</th>
$t_data
</table>
PRINT_HTML;

?>
