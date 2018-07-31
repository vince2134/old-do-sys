<?php
#
# 各FCにデフォルトの支店を登録します。
#

require_once("ENV_local.php"); //環境ファイル
require_once(INCLUDE_DIR.(basename("2-1-200.php.inc"))); //現モジュール内のみで使用する関数ファイル

// HTML_QuickFormオブジェクト作成
$form =& new HTML_QuickForm("dateForm", "POST");

// DB接続
$db_con = Db_Connect();

//登録ボタン
$form->addElement("submit", "regist_button", "登　録");


if ($_POST[regist_button] == "登　録"){

	$fc_data = Get_Fc_Data($db_con);
	$count = count($fc_data);
	
	for($i=0; $i<$count; $i++){
	
		$values = array(
			branch_cd     => "001",
			branch_name   => addslashes("本店"),
			bases_ware_id => $fc_data[$i][ware_id],
			note          => "",
			shop_id       => $fc_data[$i][client_id],
		);

		//初期支店登録（成功時は登録したIDを返す）
		$branch_id = Regist_Branch($db_con,"default",$values);

		//初期部署登録
		if(!($values[shop_id] == "93" || $values[shop_id] == "189")){
			Regist_Init_Part($db_con,$values[shop_id]);
		}
		
		//部署に支店を登録
		if($branch_id != false){
			Update_Part_Branch($db_con,$values[shop_id],$branch_id);
		}
	}
	
	echo "実行しました。<hr>";

}

echo "■以下の処理を実施します。<br>";
echo "・各FCの初期支店を登録<br>";
echo "・各FCの初期部署を登録<br>";
//echo "・各FCの部署に支店を登録<br>";

$form->display();
//print_array($fc_data);

function Get_Fc_Data($db_con){

	// 変更SQL
	$sql  = "SELECT ";
	$sql .= " client_id, ";
	$sql .= " client_name, ";
	$sql .= " client_name2, ";
	$sql .= " ware_id ";
	$sql .= "FROM t_client ";
	$sql .= "WHERE client_div = '3'";
	$sql .= "ORDER BY client_id;";
	
	$result      = Db_Query($db_con, $sql);
	$branch_data = pg_fetch_all($result);

	return $branch_data;

}

function Regist_Init_Part($db_con,$shop_id){

	$sql  = "INSERT INTO ";
	$sql .= "t_part(";
	$sql .= "part_id, part_cd, part_name, branch_id,note, ";
	$sql .= "shop_id";
	$sql .= ") ";
	$sql .= "VALUES(";
	$sql .= "(SELECT COALESCE(MAX(part_id), 0)+1 FROM t_part), ";
	$sql .= "'001', ";
	$sql .= "'初期部署', ";
	$sql .= "NULL, ";
	$sql .= "'', ";
	$sql .= "$shop_id ";
	$sql .= ") ";
	$sql .= ";";

	$result  = Db_Query($db_con, $sql);

}

function Update_Part_Branch($db_con,$shop_id,$branch_id){

	// 変更SQL
	$sql  = "UPDATE t_part SET ";
	$sql .= "branch_id     = '$branch_id' ";
	$sql .= "WHERE shop_id = $shop_id ";
	$sql .= ";";
	
	$result  = Db_Query($db_con, $sql);

}

?>