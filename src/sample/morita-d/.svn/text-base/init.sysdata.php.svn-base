<?php
/**
 * 概要 Do.sys2006のシステムデータを初期化します。
 *
 * 説明 
 *
 */

//対象DB
$l_db_name="watanabe-k_demo2";

//処理時間
$s_time = microtime();

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect($l_db_name);

$db_tables=array(
't_payin_d',
't_payin_h',
't_payin_no_serial',
't_bill',
't_bill_d',
't_bill_make_history',
't_bill_no_m_serial',
't_bill_no_serial',
't_bill_no_y_serial',
't_bill_renew',
't_sale_h',
't_sale_d',
't_sale_detail',
't_sale_ship',
't_sale_staff',
't_installment_sales',
't_aorder_h',
't_aorder_d',
't_aorder_detail',
't_aorder_no_serial',
't_aorder_no_serial_fc',
't_aorder_ship',
't_aorder_staff',

't_payout_h',
't_payout_d',
't_payout_no_serial',
't_schedule_payment',
't_buy_h',
't_buy_d',
't_amortization',
't_order_d',
't_order_h',

't_rental',
't_rental_d',
't_rental_h',
't_stock_hand',
't_first_ap_balance',
't_first_ar_balance',
't_ap_balance',
't_ar_balance',
't_invent',
't_contents',
't_mst_log',
't_sys_renew',
/*
*/
);

Db_Query($db_con, "BEGIN;");
foreach($db_tables  as $table_name ){

    //削除処理
    $sql = "DELETE FROM  $table_name;";
    $result = Db_Query($db_con, $sql);
    //echo "$table_name"."を削除しました。<br>";

    //削除後の件数（0件なら成功）
    $sql     = "SELECT COUNT(*) FROM $table_name;";
    $result2 = Db_Query($db_con, $sql);
    $row     = pg_fetch_result($result2,0,0);
    $t_data .= "<tr><td>$table_name</td><td>$row</td></tr>";
    

    //テーブルの制約などによりデータ削除に失敗した場合
    if ( $row != "0" ) {
       $error = "<font color=#ff0000>データの削除に失敗したテーブルがあります。</font>";
    }


}
Db_Query($db_con, "COMMIT;");


//処理時間
$e_time = microtime();

//削除結果表示
echo <<<PRINT_HTML
$error

【データ削除テーブル一覧】
<table border=\"1\">
<th>テーブル名</th>
<th>件数</th>
$t_data
</table>
$s_time
$e_time
PRINT_HTML;



?>
