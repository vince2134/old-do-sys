<?php
/*
//マイクロタイムを利用して主キーを生成します。
function Get_Pkey(){
	$microtime   = explode(" ",microtime());
	$pkey = $microtime[1].substr("$microtime[0]", 2, 6);

	return $pkey;

}
*/

//本支店マスタを登録します。
function Regist_Branch($db_con, $mode=NULL, $def_values=NULL){

	Db_Query($db_con, "BEGIN;");

	//extract($_POST);
	$branch_id     = Get_Pkey();
	$branch_cd     = $_POST[branch_cd];
	$branch_name   = $_POST[branch_name];
	$bases_ware_id = $_POST[bases_ware_id];
	$note          = $_POST[note];

	//FC登録時のデフォルト倉庫
	if($mode == "default"){

		// レコードをINSERT
		$sql  = "INSERT INTO t_branch(";
		$sql .= "branch_id,";
		$sql .= "branch_cd,";
		$sql .= "branch_name,";
		$sql .= "bases_ware_id,";
		$sql .= "note,";
		$sql .= "shop_id";
		$sql .= ") ";
		$sql .= "VALUES(";
		$sql .= "'$branch_id', ";
		$sql .= "'$def_values[branch_cd]', ";
		$sql .= "'$def_values[branch_name]', ";
		$sql .= "'$def_values[bases_ware_id]', ";
		$sql .= "'$def_values[note]', ";
		$sql .= "'$def_values[shop_id]' ";
		$sql .= ") ";
		$sql .= ";";

	}else{
		// レコードをINSERT
		$sql  = "INSERT INTO t_branch(";
		$sql .= "branch_id,";
		$sql .= "branch_cd,";
		$sql .= "branch_name,";
		$sql .= "bases_ware_id,";
		$sql .= "note,";
		$sql .= "shop_id";
		$sql .= ") ";
		$sql .= "VALUES(";
		$sql .= "'$branch_id', ";
		$sql .= "'$branch_cd', ";
		$sql .= "'$branch_name', ";
		$sql .= "'$bases_ware_id', ";
		$sql .= "'$note', ";
		$sql .= $_SESSION[client_id];
		$sql .= ") ";
		$sql .= ";";
	}

	$flg = $branch_id;

	$result  = Db_Query($db_con, $sql);
	if($result == false){
		Db_Query($db_con,"ROLLBACK;");
		$flg = false;
	}

	if($mode != "default"){
		//マスタログへ書き込み（区分は登録である1）
		$result = Log_Save($db_con,'branch',1,$branch_cd,$branch_name);
		//ログ登録時にエラーになった場合
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			$flg = false;
		}
	}
	Db_Query($db_con, "COMMIT;");

	return $flg;
}


//本支店マスタを変更します。
function Update_Branch($db_con){

	Db_Query($db_con, "BEGIN;");
	
	//本支店コードの重複チェック
	$result = Check_Branch_Cd($db_con);

	//本支店コードの重複が無い場合は変更
	if ($result){

		$branch_id     = $_POST[branch_id];
		$branch_cd     = $_POST[branch_cd];
		$branch_name   = $_POST[branch_name];
		$bases_ware_id = $_POST[bases_ware_id];
		$note          = $_POST[note];
		
		// 変更SQL
		$sql  = "UPDATE t_branch SET ";
		$sql .= "branch_cd     = '$branch_cd',";
		$sql .= "branch_name   = '$branch_name',";
		$sql .= "bases_ware_id = '$bases_ware_id',";
		$sql .= "note          = '$note'";
		$sql .= "WHERE branch_id = $branch_id ";
		$sql .= " AND shop_id = ".$_SESSION[client_id];
		$sql .= ";";
		
		$result  = Db_Query($db_con, $sql);
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			exit;
		}
	
		//マスタログへ書き込み（区分は登録である1）
		$result = Log_Save($db_con,'branch',1,$branch_cd,$branch_name);
		//ログ登録時にエラーになった場合
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			exit;
		}
	
	//本支店コードが重複した場合
	}else{
		$flg = false;
	}
	
	Db_Query($db_con, "COMMIT;");

	return $flg;

}

//本支店コードの重複をチェックします。
function Check_Branch_Cd($db_con){
	
	// 本支店コードを基に本支店IDを取得
	$sql  = "SELECT branch_id ";
	$sql .= "FROM t_branch ";
	$sql .= "WHERE branch_cd=".$_POST[branch_cd];
	$sql .= " AND shop_id=".$_SESSION[client_id];
	$sql .= ";";

	$result       = Db_Query($db_con, $sql);
	$branch_id_af = @pg_fetch_result($result,0,0); //変更先の本支店ID
	
	//変更前と変更後でIDが同じならコード変更なし（つまり重複なし）
	if ($_POST[branch_id] == $branch_id_af){
		$flg = true;	

	//変更先のIDが無い場合
	} elseif ($branch_id_af == ""){
		$flg = true;	

	//変更前と変更後でIDが異なる場合
	} else {
				$flg = false;
	}

	return $flg;
}

//データが無い場合はfalseを返します。
function Get_Branch($db_con){
	
	$sql  = "SELECT ";
	$sql .= " branch_id,";
	$sql .= " branch_cd,";
	$sql .= " branch_name,";
	$sql .= " bases_ware_id,";
	$sql .= " note ";
	$sql .= "FROM t_branch ";
	$sql .= "WHERE branch_id=".$_POST[branch_id];
	$sql .= " AND t_branch.shop_id=".$_SESSION[client_id];
	$sql .= ";";

	$result      = Db_Query($db_con, $sql);
	$branch_data = pg_fetch_array($result);

	if( count($branch_data) == "0"){
		$branch_data = false;
	}

	return $branch_data;
}


function Get_Branch_Data($db_con){
	
	// 変更SQL
	$sql  = "SELECT ";
	$sql .= " t_branch.branch_id, ";
	$sql .= " t_branch.branch_cd, ";
	$sql .= " t_branch.branch_name, ";
	$sql .= " t_ware.ware_name, ";
	$sql .= " t_branch.note ";
	$sql .= "FROM t_branch ";
	$sql .= "INNER JOIN t_ware ON  t_branch.bases_ware_id = t_ware.ware_id ";
	$sql .= "WHERE t_branch.shop_id=".$_SESSION[client_id];
	$sql .= "ORDER BY t_branch.branch_cd;";

	$result      = Db_Query($db_con, $sql);

	//データがある場合は結果を配列に登録
	if(pg_num_rows($result) != "0"){
		$branch_data = pg_fetch_all($result);
	}
	return $branch_data;
}


function Html_Branch_Data($branch_data){

	$count = count($branch_data);

	for ($i=0;$i<$count;$i++){
	
		$branch_data[$i][no]          = $i+1;
		$branch_data[$i][branch_name] = htmlspecialchars($branch_data[$i][branch_name]);
		$branch_data[$i][note]        = htmlspecialchars($branch_data[$i][note]);
		$branch_data[$i][ware_name]   = htmlspecialchars($branch_data[$i][ware_name]);

	}

	return $branch_data;
}

//本支店マスタのCSVを出力します
function Csv_Branch($db_con){

	// レコードデータ取得
	$db_data = Get_Branch_Data($db_con);

	$total_count = count($db_data);
	for ($i = 0; $i < $total_count; $i++){
		unset($db_data[$i][branch_id]);
		$ary_csv_data[] = array_values ($db_data[$i]);
	}
	
	// csvファイル作成
	$csv_file_name = "本支店マスタ".date("Ymd").".csv";
	$csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
	$csv_header    = array("本支店コード", "本支店名", "拠点倉庫", "備考");
	$csv_data      = Make_Csv($ary_csv_data, $csv_header);
	Header("Content-disposition: inline; filename=$csv_file_name");
	Header("Content-type: application/octet-stream; name=$csv_file_name");
	print $csv_data;
	exit;

}

?>
