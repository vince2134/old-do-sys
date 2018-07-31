<?php

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

//���顼�ѿ������
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku_0701.inc");

//����������
$today_y = date("Y");            
$today_m = date("m");
$today_d = date("d");
$to_date = "$today_y-$today_m-$today_d";

/****************************/
//����åפ��Ȥˡ������������������
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    t_contract.shop_id,";     //����å�ID
$sql .= "    t_client.cal_peri_num ";  //���������ѹ�����
$sql .= "FROM ";
$sql .= "    t_contract ";
$sql .= "    INNER JOIN t_client ON t_contract.shop_id = t_client.client_id ";
$sql .= "WHERE ";
$sql .= "    t_client.state = '1' ";
$sql .= "ORDER BY ";
$sql .= "    t_contract.shop_id;";
$shop_result = Db_Query($db_con, $sql); 
while($shop_list = pg_fetch_array($shop_result)){
	Db_Query($db_con, "BEGIN;");
	$error_msg = NULL;   //���顼����

	//��������ɽ�����ּ���
	$cal_array = Cal_range($db_con,$shop_list[0]);
	$start_day = $cal_array[0];   //�оݳ��ϴ���(���Ϥˤ⽪λ�����դ�����)
	$end_day = $cal_array[1];     //�оݽ�λ����
	$cal_peri = $cal_array[2];    //��������ɽ������

	/****************************/
	//�����褴�Ȥ˼���ǡ�������
	/****************************/
	$sql  = "SELECT DISTINCT ";
	$sql .= "    t_contract.client_id ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "    INNER JOIN t_client ON t_contract.client_id = t_client.client_id ";
	$sql .= "WHERE ";
	$sql .= "    t_client.state = '1' ";
	$sql .= "AND ";
	$sql .= "    t_contract.shop_id = ".$shop_list[0];
	$sql .= " ORDER BY ";
	$sql .= "    t_contract.client_id;";
	$client_result = Db_Query($db_con, $sql); 
	while($client_list = pg_fetch_array($client_result)){

		/****************************/
		//��������ɽ�����֤ν�����ǡ����ɲ�(�̾���ɼ�����ե饤����ɼ����§���ǡ����ʳ�)
		/****************************/
		//����������������
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
		$sql .= "    t_contract ";
		$sql .= "WHERE ";
		$sql .= "    round_div != '7' ";
		$sql .= "AND ";
		$sql .= "    contract_div IN('1','3') ";
		$sql .= "AND ";
		$sql .= "    request_state = '2' ";
		$sql .= "AND ";
		$sql .= "    shop_id = ".$shop_list[0];
		$sql .= " AND ";
		$sql .= "    client_id = ".$client_list[0].";";
		$con_result = Db_Query($db_con, $sql); 

		while($con_list = pg_fetch_array($con_result)){

			$contract_id  = $con_list[0];  //�������ID
			$round_div    = $con_list[1];  //����ʬ
			$cycle        = $con_list[2];  //����
			$cale_week    = $con_list[3];  //��̾�ʣ�������
			$abcd_week    = $con_list[4];  //��̾�ʣ��£ãġ�
			$rday         = $con_list[5];  //������
			$week_rday    = $con_list[6];  //��������
			$stand_day    = $con_list[7];  //��ȴ����

			/****************************/
			//������׻�����
			/****************************/
			$date_array = NULL;
			$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);

		}
		/****************************/
		//����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥����Ͽ�ؿ�     
		/****************************/
		//�̾���ե饤����ɼ����
		$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,NULL,true);
		if($ao_result === false){
			//���顼Ƚ��
			if($error_msg == NULL){
				//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥���Ͽ�ؿ��������� \n����å�ID: ".$shop_list[0]." \n������ID: ".$client_list[0]." \n��Զ�ʬ: �̾���ե饤����ɼ \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}

		//ľ�Ĥξ��ϡ�����饤����ɼ����
		$sql  = "SELECT ";
		$sql .= "    t_rank.group_kind ";
		$sql .= "FROM ";
		$sql .= "    t_client ";
		$sql .= "    INNER JOIN t_rank ON t_client.rank_cd = t_rank.rank_cd ";
		$sql .= "WHERE ";
		$sql .= "    t_client.client_id = ".$shop_list[0].";";
		$r_result = Db_Query($db_con,$sql);
		$group_kind = pg_fetch_result($r_result,0,0);
		//ľ��Ƚ��
		if($group_kind == "2"){
			/****************************/
			//��������ɽ�����֤ν�����ǡ����ɲ�(����饤����ɼ����§���ǡ����ʳ�)
			/****************************/
			//����������������
			$sql  = "SELECT ";
			$sql .= "    contract_id, ";
			$sql .= "    round_div,";
			$sql .= "    cycle,";
			$sql .= "    cale_week,";
			$sql .= "    abcd_week,";
			$sql .= "    rday,";
			$sql .= "    week_rday,";
			$sql .= "    stand_day,";
			$sql .= "    contract_div, ";
			$sql .= "    trust_id, ";
			$sql .= "    round_div ";
			$sql .= "FROM ";
			$sql .= "    t_contract ";
			$sql .= "WHERE ";
			$sql .= "    contract_div = '2' ";
			$sql .= "AND ";
			$sql .= "    request_state = '2' ";
			$sql .= "AND ";
			$sql .= "    shop_id = ".$shop_list[0];
			$sql .= " AND ";
			$sql .= "    client_id = ".$client_list[0].";";
			$con_result2 = Db_Query($db_con, $sql); 

			while($con_list2 = pg_fetch_array($con_result2)){

				$contract_id  = $con_list2[0];  //�������ID
				$round_div    = $con_list2[1];  //����ʬ
				$cycle        = $con_list2[2];  //����
				$cale_week    = $con_list2[3];  //��̾�ʣ�������
				$abcd_week    = $con_list2[4];  //��̾�ʣ��£ãġ�
				$rday         = $con_list2[5];  //������
				$week_rday    = $con_list2[6];  //��������
				$stand_day    = $con_list2[7];  //��ȴ����
				$contract_div = $con_list2[8];  //�����ʬ
				$trust_id     = $con_list2[9];  //������ID
				$round_div    = $con_list2[10]; //����ʬ

				//��§���ʳ��ʤ���ơ��֥���ɲ�
				if($round_div != 7){
					/****************************/
					//������׻�����
					/****************************/
					$date_array = NULL;
					$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);
				}
		
				/****************************/
				//����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥����Ͽ�ؿ�     
				/****************************/
				//����饤����ɼ����
				$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,$trust_id,true);
				if($ao_result === false){
					//���顼Ƚ��
					if($error_msg == NULL){
						//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
						$error_con = pg_last_error();
						$error_time = date("Y-m-d H:i");
						$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥���Ͽ�ؿ��������� \n����å�ID: ".$shop_list[0]." \n������ID: ".$client_list[0]." \n������ID: $trust_id \n";
						$error_msg[1] = "$error_con \n\n";
					}
				}
			}
		}
	}

	//���顼Ƚ��
	if($error_msg == NULL){
		//����

		Db_Query($db_con, "COMMIT;");
	}else{
		//�۾�

		Db_Query($db_con, "ROLLBACK");
		//FILE�˥��顼����
		for($i=0;$i<count($error_msg);$i++){
			error_log($error_msg[$i],3,LOG_FILE);
			$e_contents .= $error_msg[$i];
		}

		$error_flg = true;  //�۾�ȯ���ե饰
	}
}

//����Ƚ��
if($error_flg == false){
	//����

	$today = date("Y-m-d H:i");
	//FILE�˽���
	error_log("$today ������ɼ������λ \n\n",3,LOG_FILE);
}else{
	//�۾�

	//�᡼��ǥ��顼����
	Error_send_mail($g_error_mail,$g_error_add,"������ɼ���������ǰ۾�ȯ��",$e_contents);
}

?>
