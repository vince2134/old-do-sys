<?php
/*
//�ޥ���������������Ѥ��Ƽ祭�����������ޤ���
function Get_Pkey(){
	$microtime   = explode(" ",microtime());
	$pkey = $microtime[1].substr("$microtime[0]", 2, 6);

	return $pkey;

}
*/

//�ܻ�Ź�ޥ�������Ͽ���ޤ���
function Regist_Branch($db_con, $mode=NULL, $def_values=NULL){

	Db_Query($db_con, "BEGIN;");

	//extract($_POST);
	$branch_id     = Get_Pkey();
	$branch_cd     = $_POST[branch_cd];
	$branch_name   = $_POST[branch_name];
	$bases_ware_id = $_POST[bases_ware_id];
	$note          = $_POST[note];

	//FC��Ͽ���Υǥե�����Ҹ�
	if($mode == "default"){

		// �쥳���ɤ�INSERT
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
		// �쥳���ɤ�INSERT
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
		//�ޥ��������ؽ񤭹��ߡʶ�ʬ����Ͽ�Ǥ���1��
		$result = Log_Save($db_con,'branch',1,$branch_cd,$branch_name);
		//������Ͽ���˥��顼�ˤʤä����
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			$flg = false;
		}
	}
	Db_Query($db_con, "COMMIT;");

	return $flg;
}


//�ܻ�Ź�ޥ������ѹ����ޤ���
function Update_Branch($db_con){

	Db_Query($db_con, "BEGIN;");
	
	//�ܻ�Ź�����ɤν�ʣ�����å�
	$result = Check_Branch_Cd($db_con);

	//�ܻ�Ź�����ɤν�ʣ��̵�������ѹ�
	if ($result){

		$branch_id     = $_POST[branch_id];
		$branch_cd     = $_POST[branch_cd];
		$branch_name   = $_POST[branch_name];
		$bases_ware_id = $_POST[bases_ware_id];
		$note          = $_POST[note];
		
		// �ѹ�SQL
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
	
		//�ޥ��������ؽ񤭹��ߡʶ�ʬ����Ͽ�Ǥ���1��
		$result = Log_Save($db_con,'branch',1,$branch_cd,$branch_name);
		//������Ͽ���˥��顼�ˤʤä����
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			exit;
		}
	
	//�ܻ�Ź�����ɤ���ʣ�������
	}else{
		$flg = false;
	}
	
	Db_Query($db_con, "COMMIT;");

	return $flg;

}

//�ܻ�Ź�����ɤν�ʣ������å����ޤ���
function Check_Branch_Cd($db_con){
	
	// �ܻ�Ź�����ɤ����ܻ�ŹID�����
	$sql  = "SELECT branch_id ";
	$sql .= "FROM t_branch ";
	$sql .= "WHERE branch_cd=".$_POST[branch_cd];
	$sql .= " AND shop_id=".$_SESSION[client_id];
	$sql .= ";";

	$result       = Db_Query($db_con, $sql);
	$branch_id_af = @pg_fetch_result($result,0,0); //�ѹ�����ܻ�ŹID
	
	//�ѹ������ѹ����ID��Ʊ���ʤ饳�����ѹ��ʤ��ʤĤޤ��ʣ�ʤ���
	if ($_POST[branch_id] == $branch_id_af){
		$flg = true;	

	//�ѹ����ID��̵�����
	} elseif ($branch_id_af == ""){
		$flg = true;	

	//�ѹ������ѹ����ID���ۤʤ���
	} else {
				$flg = false;
	}

	return $flg;
}

//�ǡ�����̵������false���֤��ޤ���
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
	
	// �ѹ�SQL
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

	//�ǡ�����������Ϸ�̤��������Ͽ
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

//�ܻ�Ź�ޥ�����CSV����Ϥ��ޤ�
function Csv_Branch($db_con){

	// �쥳���ɥǡ�������
	$db_data = Get_Branch_Data($db_con);

	$total_count = count($db_data);
	for ($i = 0; $i < $total_count; $i++){
		unset($db_data[$i][branch_id]);
		$ary_csv_data[] = array_values ($db_data[$i]);
	}
	
	// csv�ե��������
	$csv_file_name = "�ܻ�Ź�ޥ���".date("Ymd").".csv";
	$csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
	$csv_header    = array("�ܻ�Ź������", "�ܻ�Ź̾", "�����Ҹ�", "����");
	$csv_data      = Make_Csv($ary_csv_data, $csv_header);
	Header("Content-disposition: inline; filename=$csv_file_name");
	Header("Content-type: application/octet-stream; name=$csv_file_name");
	print $csv_data;
	exit;

}

?>