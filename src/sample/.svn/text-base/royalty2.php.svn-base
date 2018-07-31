<?php

//ロイヤリティの一覧を作成


//環境設定ファイル
require_once("ENV_local.php");

$db_con = Db_Connect("amenity_demo_new");

$tax_rate = '5';

//本部の売上伝票を抽出
$sql  = "SELECT\n";
$sql .= "    t_sale_h.sale_no, \n";
$sql .= "    t_sale_h.claim_day, \n"; 
$sql .= "    t_sale_h.client_cd1 || '-' || t_sale_h.client_cd2 AS client_cd, \n"; 
$sql .= "    t_client.close_day, \n"; 
$sql .= "    t_sale_h.client_name, \n";
$sql .= "    t_sale_h.net_amount, \n";
$sql .= "    t_sale_h.tax_amount, \n";
$sql .= "    t_sale_h.royalty_amount, \n";
$sql .= "    t_sale_d.goods_cd, \n";
$sql .= "    t_sale_d.goods_name, \n";
$sql .= "    t_sale_d.royalty \n";
$sql .= "FROM \n";
$sql .= "    t_sale_h \n";
$sql .= "        INNER JOIN \n";
$sql .= "    t_sale_d \n";
$sql .= "    ON t_sale_h.sale_id = t_sale_d.sale_id \n";
$sql .= "        INNER JOIN \n";
$sql .= "    t_client \n";
$sql .= "    ON t_sale_h.client_id = t_client.client_id \n";
$sql .= "WHERE \n";
$sql .= "    t_sale_h.shop_id = 1 \n";
$sql .= "ORDER BY \n";
$sql .= "    TO_CHAR(t_sale_h.claim_day, 'YYYY-MM'), \n";
$sql .= "    t_sale_h.client_cd1, \n";
$sql .= "    t_sale_h.client_cd2, \n";
$sql .= "    t_sale_h.sale_no, \n";
$sql .= "    t_sale_d.goods_cd \n";
$sql .= "; \n";

$sql  = "SELECT\n";
$sql .= "    t_sale_h.sale_no,\n";
$sql .= "    t_sale_h.client_id,\n";
$sql .= "    t_sale_h.client_cd1 || '-' || t_sale_h.client_cd2 AS client_cd,\n";
$sql .= "    t_sale_h.client_name,\n";
$sql .= "    CASE t_sale_h.trade_id \n";
$sql .= "       WHEN '11' THEN t_sale_h.net_amount\n";
$sql .= "       WHEN '15' THEN t_sale_h.net_amount\n";
$sql .= "       WHEN '61' THEN t_sale_h.net_amount\n";
$sql .= "       ELSE t_sale_h.net_amount * -1\n";
$sql .= "    END AS net_amount, \n";
$sql .= "    t_sale_d.royalty_sale_intax_amount, \n";
$sql .= "    coax,\n";
$sql .= "    tax_franct,\n";
$sql .= "    c_tax_div, \n";
$sql .= "    royalty_rate, \n";
$sql .= "    royalty_amount \n";
$sql .= "FROM\n";
$sql .= "    t_sale_h\n";
$sql .= "        INNER JOIN\n";
$sql .= "    (SELECT\n";
$sql .= "       t_sale_d.sale_id,\n";
$sql .= "       CASE t_sale_d.royalty\n";
$sql .= "           WHEN '1' THEN";
$sql .= "               COALESCE(\n";
$sql .= "                   SUM(\n";
$sql .= "                       CASE\n";
$sql .= "                           WHEN t_sale_d.tax_div = '1' THEN t_sale_d.sale_amount *\n";
$sql .= "                               CASE\n";
$sql .= "                                   WHEN t_sale_h.trade_id = 11 OR t_sale_h.trade_id = 15 OR t_sale_h.trade_id = 61 THEN 1\n";
$sql .= "                                   ELSE -1\n";
$sql .= "                               END\n";
$sql .= "                       END\n";
$sql .= "                   )\n";
$sql .= "               )\n";
$sql .= "           ELSE '0'\n";
$sql .= "       END AS royalty_sale_intax_amount \n";
$sql .= "    FROM \n";
$sql .= "       t_sale_h\n";
$sql .= "           INNER JOIN\n";
$sql .= "       t_sale_d\n";
$sql .= "       ON t_sale_h.sale_id = t_sale_d.sale_id\n";
$sql .= "    WHERE\n";
$sql .= "       shop_id = 1\n";
$sql .= "    GROUP BY \n";
$sql .= "       t_sale_d.sale_id,\n";
$sql .= "       t_sale_d.royalty \n";
$sql .= "    ) AS t_sale_d\n";       
$sql .= "    ON t_sale_h.sale_id = t_sale_d.sale_id\n";
$sql .= "        INNER JOIN \n";
$sql .= "    t_client\n";
$sql .= "    ON t_sale_h.client_id = t_client.client_id\n";
$sql .= "WHERE\n";
$sql .= "    t_sale_h.claim_div = '1'\n";
$sql .= "    AND\n";
$sql .= "    t_sale_h.trade_id IN (11,13,14,15,61,63,64)\n";
$sql .= "ORDER BY t_sale_h.sale_no\n";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);

$slip_data = pg_fetch_all($result);

//伝票枚数分ループ
foreach($slip_data AS $key => $var){

    //ロイヤリティを求める
    $royalty_amount     = Coax_Col($var["coax"], bcmul($var["royalty_sale_intax_amount"],bcdiv($var["royalty_rate"],100,2),2));

    $royalty_net_amount = $var["net_amount"] + $royalty_amount;     //税抜き金額 ＋ ロイヤリティ

    $total_amount = Total_Amount($royalty_net_amount, $var["c_tax_div"], $var["coax"], $var["tax_franct"], 5, $var["client_id"], $db_con);

    //CSV出力用データ
    $csv_data[$key][] = $var["sale_no"];           //税込金額
    $csv_data[$key][] = $royalty_amount;            //ロイヤリティ
    $csv_data[$key][] = $var["royalty_amount"];           //税込金額
}
print_array($csv_data);
?>
