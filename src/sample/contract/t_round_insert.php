<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku_0701.inc");

$client_h_id = $_SESSION["client_id"];  //������桼��ID

/****************************/
//������׻�����
/****************************/
$cal_array = Cal_range($db_con,$client_h_id);

$start_day = $cal_array[0];   //�оݳ��ϴ���
$end_day = $cal_array[1];     //�оݽ�λ����
$cal_peri = $cal_array[2];    //��������ɽ������

Db_Query($db_con, "BEGIN;");

//������ơ��֥���
$sql  = "DELETE FROM t_round;";
$result = Db_Query($db_con, $sql);
if($result === false){
    Db_Query($db_con, "ROLLBACK");
    exit;
}

/****************************/
//����������������
/****************************/
$sql  = "SELECT ";
$sql .= "    contract_id, ";
$sql .= "    round_div,";
$sql .= "    cycle,";
$sql .= "    cale_week,";
$sql .= "    abcd_week,";
$sql .= "    rday,";
$sql .= "    week_rday,";
$sql .= "    stand_day ";
$sql .= "FROM ";
$sql .= "    t_contract;";
$result = Db_Query($db_con, $sql); 

while($con_list = pg_fetch_array($result)){

	$contract_id = $con_list[0];  //�������ID
	$cycle       = $con_list[2];  //����
	$cale_week   = $con_list[3];  //��̾�ʣ�������
	$abcd_week   = $con_list[4];  //��̾�ʣ��£ãġ�
	$rday        = $con_list[5];  //������
	$week_rday   = $con_list[6];  //��������
	$stand_day   = $con_list[7];  //��ȴ����
	$round_div   = $con_list[1];  //����ʬ

	/****************************/
	//������׻�����
	/****************************/
	$date_array = NULL;
	$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);
	/****************************/
	//������ơ��֥���Ͽ
	/****************************/
	for($s=0;$s<count($date_array);$s++){
		//��Ͽ

		$sql  = "INSERT INTO t_round( ";
		$sql .= "    contract_id,";
		$sql .= "    round_day ";
		$sql .= "    )VALUES(";
		$sql .= "    $contract_id,";
		$sql .= "    '".$date_array[$s]."' ";
		$sql .= "    );";

		$in_result = Db_Query($db_con, $sql);
		if($in_result === false){
	        Db_Query($db_con, "ROLLBACK");
	        exit;
	    }

		//�ե�����˥�������(������ID)
		$fp = fopen("insert_log.txt","a");
		fputs($fp,$contract_id."��".$date_array[$s]."\n");
		fclose($fp);
	}
}
Db_Query($db_con, "COMMIT;");
print "������ơ��֥������λ"
?>
