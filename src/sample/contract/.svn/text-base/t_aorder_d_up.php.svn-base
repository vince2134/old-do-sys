<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");

/****************************/
//受注データの分類名・正式名を更新
/****************************/
$sql  = "SELECT ";
$sql .= "    aord_d_id, "; //受注ID
$sql .= "    goods_id ";   //商品ID
$sql .= "FROM ";
$sql .= "    t_aorder_d ";
$sql .= "WHERE ";
$sql .= "    g_product_name IS NULL "; 
$sql .= "AND ";
$sql .= "    official_goods_name IS NULL ";
$sql .= "AND ";
$sql .= "    goods_id IS NOT NULL;";
$con_result = Db_Query($db_con, $sql);

while($con_list = pg_fetch_array($con_result)){
	$aord_d_id  = $con_list[0];      
	$goods_id   = $con_list[1];  

	$sql  = "SELECT ";
	$sql .= "    t_g_product.g_product_name,";
	$sql .= "    t_goods.goods_name ";
	$sql .= "FROM ";
	$sql .= "    t_g_product ";
	$sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
	$sql .= "WHERE ";
	$sql .= "    t_goods.goods_id = $goods_id;";
	$result = Db_Query($db_con, $sql);
	$item_data = Get_Data($result,3);

	$sql  = "UPDATE t_aorder_d SET ";
	$sql .= "    g_product_name = '".$item_data[0][0]."',";
	$sql .= "    official_goods_name = '".$item_data[0][1]."' ";
	$sql .= " WHERE ";
	$sql .= "    aord_d_id = $aord_d_id;";
	$up_result = Db_Query($db_con, $sql);
	if($up_result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}

/****************************/
//受注ヘッダの取引区分更新
/****************************/
$aord_up  = <<<AORD
UPDATE t_aorder_h SET 
    trade_id = '11' 
WHERE 
    t_aorder_h.aord_id IN( 
     SELECT DISTINCT 
         t_aorder_h.aord_id 
     FROM 
         t_aorder_h 
         INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id 
     WHERE 
         t_aorder_h.trade_id = '61' 
     AND 
         t_aorder_d.contract_id IS NOT NULL 
     AND 
         t_aorder_h.contract_div = '3');
AORD;
$up_result = Db_Query($db_con,$aord_up);
if($up_result === false){
    Db_Query($db_con, "ROLLBACK");
    exit;
}

/****************************/
//売上ヘッダの取引区分更新
/****************************/
$sale_up  = <<<SALE
UPDATE t_sale_h SET 
    trade_id = '11' 
WHERE 
    t_sale_h.sale_id IN( 
     SELECT DISTINCT 
         t_sale_h.sale_id 
     FROM 
         t_sale_h 
         INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id 
     WHERE 
         t_sale_h.trade_id = '61' 
     AND 
         t_sale_d.contract_id IS NOT NULL 
     AND 
         t_sale_h.contract_div = '3');
SALE;
$up_result = Db_Query($db_con,$sale_up);
if($up_result === false){
    Db_Query($db_con, "ROLLBACK");
    exit;
}

Db_Query($db_con, "COMMIT;");
print "更新完了";

?>
