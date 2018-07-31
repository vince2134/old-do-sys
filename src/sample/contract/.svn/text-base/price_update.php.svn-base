<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//契約関数定義
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

Db_Query($db_con, "BEGIN;");

//仕入単価がNULLの受注データ取得
$sql  = "SELECT ";
$sql .= "    t_aorder_d.aord_d_id, ";
$sql .= "    t_aorder_d.goods_id, ";
$sql .= "    t_aorder_h.shop_id, ";
$sql .= "    t_aorder_d.num, ";
$sql .= "    t_aorder_h.client_id ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
$sql .= "WHERE ";
$sql .= "    t_aorder_d.buy_price IS NULL;";
$aord_result = Db_Query($db_con,$sql);

while($aord_list = pg_fetch_array($aord_result)){
	$aord_d_id  = $aord_list[0];
	$goods_id   = $aord_list[1];
	$shop_id    = $aord_list[2];
	$num        = $aord_list[3];  
	$client_id  = $aord_list[4];    

	/****************************/
	//得意先コード入力処理
	/****************************/
	$sql  = "SELECT";
	$sql .= "   t_client.coax ";
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   t_client.client_id = $client_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql); 
	$data_list = Get_Data($result,3);
	$coax            = $data_list[0][0];        //丸め区分（商品）


	$sql  = "SELECT ";
	$sql .= "    t_goods.goods_cd, ";
	$sql .= "    t_goods.compose_flg, ";
	$sql .= "    t_goods.public_flg  ";
	$sql .= "FROM ";
	$sql .= "    t_goods ";
	$sql .= "WHERE ";
	$sql .= "    t_goods.goods_id = $goods_id;";
	$result = Db_Query($db_con, $sql);
	$item_data = Get_Data($result,3);

	//構成品判定
	if($item_data[0][1] == 't'){
		//構成品親の在庫単価取得
		$price_array = NULL;
		$price_array = Compose_price($db_con,$shop_id,$goods_id);
		$buy_price = $price_array[2];
	}else{
		//顧客区分CD取得
		$sql  = "SELECT ";
		$sql .= "    t_rank.group_kind, ";  //グループ種別
		$sql .= "    t_rank.rank_cd ";      //顧客区分CD
		$sql .= "FROM ";
		$sql .= "    t_client ";
		$sql .= "    INNER JOIN t_rank ON t_client.rank_cd = t_rank.rank_cd ";
		$sql .= "WHERE ";
		$sql .= "    t_client.client_id = $shop_id;";
		$r_result = Db_Query($db_con,$sql);
		$group_kind = pg_fetch_result($r_result,0,0);
		$rank_code  = pg_fetch_result($r_result,0,1);

		//アイテムの在庫単価取得
		$sql  = "SELECT ";
		$sql .= "   t_price.r_price ";
		$sql .= " FROM";
    	$sql .= "   t_goods INNER JOIN t_price ON t_goods.goods_id = t_price.goods_id ";
		$sql .= " WHERE ";
		$sql .= "    t_goods.goods_id = $goods_id";
		$sql .= " AND";
    	$sql .= "    t_goods.accept_flg = '1' ";
		$sql .= " AND";
	    //直営判定
		if($group_kind == '2'){
			//直営
		    $sql .= "    t_price.shop_id IN (SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_code') \n";
		}else{
			//FC
			$sql .= "    t_price.shop_id = $shop_id  \n";
		}
		$sql .= " AND ";
		//本部判定
		if($item_data[0][2] == 't'){
			//本部商品
			$sql .= "    t_goods.public_flg = 't' ";
		}else{
			//自社商品
			$sql .= "    t_goods.public_flg = 'f' ";
		}
		$sql .= " AND";
	    $sql .= "    t_price.rank_cd = '3';";
		$result = Db_Query($db_con, $sql);
		$buy_data = Get_Data($result,3);
		$buy_price = $buy_data[0][0];
	}

	$buy_amount = bcmul($buy_price,$num,2);
	$buy_amount = Coax_Col($coax, $buy_amount);    

	$sql  = "UPDATE t_aorder_d SET ";
	$sql .= "    buy_price = $buy_price,";
	$sql .= "    buy_amount = $buy_amount ";
	$sql .= " WHERE ";
	$sql .= "    aord_d_id = $aord_d_id;";
	$up_result = Db_Query($db_con, $sql);
	if($up_result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}

Db_Query($db_con, "COMMIT;");
print "更新完了";

?>
