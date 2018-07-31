<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//消費税変更処理
/****************************/

//消費税変更の取引先取得
$sql  = "SELECT ";
$sql .= "    client_id, ";     //取引先ID
$sql .= "    tax_rate_c, ";    //改訂後消費税
$sql .= "    tax_rate_n, ";    //消費税
$sql .= "    coax, ";          //金額丸め区分
$sql .= "    tax_franct ";     //消費税端数区分
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_div = 3 ";
$sql .= "AND ";
$sql .= "    tax_rate_cday IS NOT NULL ";
$sql .= "AND ";
$sql .= "    tax_rate_c IS NOT NULL;";

$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);

//消費税更新処理
for($i=0;$i<count($data_list);$i++){
	$sql  = "UPDATE t_client SET ";
	$sql .= "    tax_rate_n = ".$data_list[$i][1].",";
	$sql .= "    tax_rate_c = NULL,";
	$sql .= "    tax_rate_cday = NULL ";
	$sql .= "WHERE ";
	$sql .= "    client_id = ".$data_list[$i][0].";";
	$result = Db_Query($db_con, $sql);
	if($result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}

/****************************/
//受注ヘッダの消費税額変更処理
/****************************/
for($j=0;$j<count($data_list);$j++){

	/****************************/
	//得意先情報取得
	/****************************/
	$tax_num    = $data_list[$j][2];
	$coax       = $data_list[$j][3];
	$tax_franct = $data_list[$j][4];

	/****************************/
	//受注ヘッダID取得
	/****************************/
    $sql  = "SELECT ";
	$sql .= "    t_aorder_h.aord_id,";        //受注ID
	$sql .= "    t_aorder_d.aord_d_id,";      //受注データID
	$sql .= "    t_aorder_d.tax_div,";        //課税区分
	$sql .= "    t_aorder_d.sale_amount ";    //売上金額
	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "    INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.ord_time > NOW() ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.confirm_flg = 'f' ";
	$sql .= "AND ";
	$sql .= "    t_aorder_d.contract_id IS NOT NULL ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.shop_id = ".$data_list[$j][0].";";

	$result = Db_Query($db_con, $sql);
	$aord_array = Get_Data($result);

	//ヘッダーごとに連想配列を定義
	for($x=0;$x<count($aord_array);$x++){
		//$m_data[受注ID][受注データID][0] = 課税区分
		//$m_data[受注ID][受注データID][1] = 売上金額
		$aord_id = $aord_array[$x][0];    //受注ID
		$aord_d_id = $aord_array[$x][1];  //受注データID

		$m_data[$aord_id][$aord_d_id][0] = $aord_array[$x][2];
		$m_data[$aord_id][$aord_d_id][1] = $aord_array[$x][3];
	}

	/****************************/
	//ヘッダごとに消費税金額変更
	/****************************/
	while($aord_num = each($m_data)){
		//受注ヘッダIDの添字取得
		$aord_id = $aord_num[0];
		$c=0;
		while($aord_d_num = each($m_data[$aord_id])){
			//受注データIDの添字取得
			$aord_d_id = $aord_d_num[0];
			//ヘッダーに掛かるデータの金額を取得
			$tax_div[$c]   = $m_data[$aord_id][$aord_d_id][0];
			$sale_data[$c] = $m_data[$aord_id][$aord_d_id][1];
			$c++;
		}

		//売上金額・消費税額の合計処理
		$total_money = Total_Amount($sale_data, $tax_div,$coax,$tax_franct,$tax_num);
		$sale_tax    = $total_money[1];

		$sql  = "UPDATE t_aorder_h SET ";
		$sql .= "    tax_amount = $sale_tax ";
		$sql .= "WHERE ";
		$sql .= "    aord_id = $aord_id;";
		
		$result = Db_Query($db_con, $sql);
	    if($result == false){
	        Db_Query($db_con, "ROLLBACK");
	        exit;
	    }

	}
}

?>
