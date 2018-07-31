<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");

/****************************/
//行NO割り当て処理
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    contract_id "; //契約情報ID
$sql .= "FROM ";
$sql .= "    t_aorder_d ";
$sql .= "WHERE ";
$sql .= "    contract_id IS NOT NULL;";
$con_result = Db_Query($db_con, $sql);

while($con_list = pg_fetch_array($con_result)){
	$contract_id  = $con_list[0];      

	//契約情報にヒモづいている受注データ取得
	$sql  = "SELECT ";
	$sql .= "    t_aorder_h.ord_time, ";
	$sql .= "    t_aorder_d.aord_d_id,";
	$sql .= "    t_aorder_d.line ";
	$sql .= "FROM ";
	$sql .= "    t_aorder_d ";
	$sql .= "    INNER JOIN t_aorder_h ON t_aorder_h.aord_id = t_aorder_d.aord_id ";   
	$sql .= "WHERE ";
	$sql .= "    t_aorder_d.contract_id = $contract_id ";
	$sql .= "ORDER BY ";
	$sql .= "    t_aorder_h.ord_time,";
	$sql .= "    t_aorder_d.line;";
	$result = Db_Query($db_con,$sql);
	$aord_list = Get_Data($result);

	//受注更新配列作成 aord_data[日付][更新後の行番号] = aord_d_id
	$count = 0;
	$change = NULL;
	$aord_data = NULL;

	for($d=0;$d<count($aord_list);$d++){
		if($change == $aord_list[$d][0] && $d != 0){
			$count = $count + 1;
		}else{
			$change = $aord_list[$d][0];
			$count = 1;
		}
		$aord_data[$aord_list[$d][0]][$count] = $aord_list[$d][1];
	}

	while($aord_num = each($aord_data)){
		//日付添字取得
		$day = $aord_num[0];

		while($day_num = each($aord_data[$day])){
			//行添字取得
			$num = $day_num[0];

			//現在の行を添字の番号で更新
			$sql  = "UPDATE t_aorder_d SET ";
			$sql .= "    line = $num ";
			$sql .= " WHERE ";
			$sql .= "    aord_d_id = ".$aord_data[$day][$num].";";
			$up_result = Db_Query($db_con, $sql);
			if($up_result === false){
			    Db_Query($db_con, "ROLLBACK");
			    exit;
			}
		}
	}
}

Db_Query($db_con, "COMMIT;");
print "行番号更新完了";

?>
