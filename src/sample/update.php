<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect("amenity");

//契約ID・販売区分取得SQL
$sql  = "SELECT ";
$sql .= "    contract_id ";
$sql .= "FROM ";
$sql .= "    t_contract;";
$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);

//契約アイテム更新処理
Db_Query($db_con, "BEGIN");   
for($i=0;$i<count($data_list);$i++){
	$sql  = "UPDATE t_con_item SET ";
	$sql .= "    divide = (SELECT divide FROM t_contract WHERE contract_id = ".$data_list[$i][0].") ";
	$sql .= "WHERE ";
	$sql .= "    contract_id = ".$data_list[$i][0].";";
	print $sql."<p>";

	$result = Db_Query($db_con, $sql);                                                   
	if($result === false){                                                               
	    Db_Query($db_con, "ROLLBACK");                                                   
	    exit;
	}
}
Db_Query($db_con, "COMMIT");
print "更新完了";

?>
