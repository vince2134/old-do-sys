<?php

/*
�ѹ�����
 �� 2006-11-02 ��������ɽ�������ѹ����˼�����ɼ�ʺ���������˽���<suzuki>
 �� 2006-11-17 ROLLBACK������ˡ����顼���Ƥ���˽��� <suzuki>
 �� 2006-11-28 ������η���ν�������������褦�˽���<suzuki>
    ��ͳ��������Ͽ���ˤϽ������������Ƥ���١�������Τޤޤ���CRON��¹Ԥ��Ƥ������ν�����Ϻ�������ʤ�
          �����ʤ�����������˺�������Ф����Τ������ѹ����ƥå׿����礭���١�CRON¦����
 �� 2007-04-05 ��ɼ�κ����ϡ���������μ�������פǤʤ��ַ���μ�������פ�Ƚ�Ǥ���褦�˽���<morita-d>
 �� 2007-06-05 ��ɼ�κ����ϡ���������ñ�̡פǤʤ��ַ���ñ�̡פǼ»ܤ���褦�˽���<morita-d>

*/


/*
 * ���Զ����б���ˡ���㡧3��23������CRON���»ܤ���Ƥ��ʤ��ä���
 * �����ʲ����ѿ������
 * $update_flg = "t";
 * $day_y = "2007";
 * $day_m = "03";
 * $day_d = "23";
 *
 * ����postgres�桼���ǡ�php create_plan_data.php�פ�¹�
 *
 */
//�Զ��ˤ���3��23���װʹߤ˺������줿��ɼ����ľ�����ϰʲ���ͭ���ˤ��ޤ�
/*
$update_flg = "t";
$day_y = "2007";
$day_m = "04";
$day_d = "12";
*/

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //����ؿ����

//DB��³
$db_con = Db_Connect();

//���������դ����
$today_y = date("Y");            
$today_m = date("m");
$today_d = date("d");
$to_date = "$today_y-$today_m-$today_d";
$today   = date("Y-m-d H:i:s");

//���Ͻ���
error_log("$today ������ɼ�������� \n",3,LOG_FILE);

//���顼�ѿ�������ʥ롼�׽����������ѿ����������Ƥ��̣�ʤ���
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/****************************/
//����å׾��������ʥ���å�ñ�̤���ɼ����������
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    t_contract.shop_id,";     //����å�ID
$sql .= "    t_client.cal_peri_num ";  //���������ѹ�����
$sql .= "FROM ";
$sql .= "    t_contract ";
$sql .= "    INNER JOIN t_client ON t_contract.shop_id = t_client.client_id ";
//$sql .= "WHERE ";
//$sql .= "    t_contract.shop_id != '93' ";
//$sql .= "    t_client.state = '1' ";
$sql .= "ORDER BY ";
$sql .= "    t_contract.shop_id;";
$shop_result = Db_Query($db_con, $sql); 


while($shop_list = pg_fetch_array($shop_result)){
	Db_Query($db_con, "BEGIN;");
	$error_msg = NULL;   //���顼����

	//��������ɽ�����ּ���
	$cal_array = Cal_range($db_con,$shop_list[0]);
	$start_day = $cal_array[1];   //�оݳ��ϴ���(���Ϥˤ⽪λ�����դ�����)
	$end_day   = $cal_array[1];   //�оݽ�λ����
	$cal_peri  = $cal_array[2];   //��������ɽ������


	/****************************/
	//�Զ���б��ν���(�̾��ɬ�פʤ������Ǥ����ä��ʤ��ǲ�������)
	/****************************/
	if($update_flg == "t"){
		//�оݴ��֡ʽ�λ�˼���
		$start     = mktime(0, 0, 0, $day_m,$day_d+$cal_array[3],$day_y);
		$start_day = date("Y-m-d",$start);
		echo "��ɼ��ƺ������ޤ��� shop_id:".$shop_list[0]. " s_day:".$start_day." e_day:".$end_day."\n";

	}


	/* 2006-11-02 ��������ɽ�������ѹ����˼�����ɼ�ʺ���������˽���<suzuki> */

	//****************************
	//��������ɽ�����֤����ä����
	//****************************
	if($shop_list[1] < 0 && $shop_list[1] != NULL){

		//��������֤ν��������(��§���ǡ����ʳ�)
		$sql  = "DELETE FROM ";
		$sql .= "    t_round ";
		$sql .= "WHERE ";
		$sql .= "    contract_id IN(";
		$sql .= "        SELECT ";
		$sql .= "            contract_id ";
		$sql .= "        FROM ";
		$sql .= "            t_contract ";
		$sql .= "        WHERE ";
		$sql .= "            round_div != '7' ";
		$sql .= "        AND ";
		$sql .= "            shop_id = ".$shop_list[0].") ";
		$sql .= "AND ";
		$sql .= "    round_day >= '$end_day';";
		$del_result = Db_Query($db_con, $sql);
		if($del_result === false){
			$error_con = pg_last_error();
			$error_time = date("Y-m-d H:i");
			$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ������֤ν��������������� \n����å�ID: ".$shop_list[0]." \n";
			$error_msg[1] = "$error_con \n\n";
		}

		//�������ֹ椬�����Ƥ��ʤ���ɼ�Τߺ��
		$delsql  = "DELETE FROM t_aorder_h WHERE aord_id IN (";
		$delsql .= "SELECT "; 
		$delsql .= "   t_aorder_h.aord_id ";
		$delsql .= "FROM ";
		$delsql .= "    t_aorder_h ";
		$delsql .= "   INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
		$delsql .= "   INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  ";
		$delsql .= "WHERE ";
		$delsql .= "   t_aorder_h.shop_id = ".$shop_list[0];
		$delsql .= " AND ";
		$delsql .= "   t_aorder_d.contract_id IS NOT NULL ";
		$delsql .= "AND ";
		$delsql .= "   t_aorder_h.ord_no IS NULL ";
		$delsql .= "AND ";
		$delsql .= "   t_aorder_h.ord_time >= '$end_day' ";
		$delsql .= ");";

		$result = Db_Query($db_con,$delsql);
		if($result === false){
			//���顼Ƚ��
			if($error_msg == NULL){
				//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ������֤μ���إå������������ \n����å�ID: ".$shop_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}
	}


	//****************************
	//��������ɽ�����֤����������
	//****************************
	if($shop_list[1] > 0){

		//��������ɽ�����֤����
		$sql  = "SELECT ";
		$sql .= "    cal_peri ";           //��������ɽ������
		$sql .= "FROM ";
		$sql .= "    t_client ";
		$sql .= "WHERE ";
		$sql .= "    client_id = ".$shop_list[0].";";
		$result       = Db_Query($db_con, $sql);
		$cal_peri_num = pg_fetch_result($result,0,0);

		//��������ɽ������
		$cal_day = 31 * (($cal_peri_num - $shop_list[1])+1);

		//�оݴ��֡ʽ�λ�˼���
		$start = mktime(0, 0, 0, $today_m,$today_d+$cal_day,$today_y);
		$c_start_day = date("Y-m-d",$start);

		//���������֤ν��������(��§���ǡ����ʳ�)
		$sql  = "DELETE FROM ";
		$sql .= "    t_round ";
		$sql .= "WHERE ";
		$sql .= "    contract_id IN(";
		$sql .= "        SELECT ";
		$sql .= "            contract_id ";
		$sql .= "        FROM ";
		$sql .= "            t_contract ";
		$sql .= "        WHERE ";
		$sql .= "            round_div != '7' ";
		$sql .= "        AND ";
		$sql .= "            shop_id = ".$shop_list[0].") ";
		$sql .= "AND ";
		$sql .= "    round_day >= '$c_start_day';";
		$del_result = Db_Query($db_con, $sql);
		if($del_result === false){

			//���顼Ƚ��
			if($error_msg == NULL){
				//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ������֤ν��������������� \n����å�ID: ".$shop_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}


		$sql  = "SELECT DISTINCT ";
		$sql .= "    t_contract.client_id ";
		$sql .= "FROM ";
		$sql .= "    t_contract ";
		$sql .= "    INNER JOIN t_client ON t_contract.client_id = t_client.client_id ";
		$sql .= "WHERE ";
		//$sql .= "    t_client.state = '1' ";
		//$sql .= "AND ";
		$sql .= "    t_contract.shop_id = ".$shop_list[0];
		$sql .= " ORDER BY ";
		$sql .= "    t_contract.client_id;";
		$client_result2 = Db_Query($db_con, $sql);


		/****************************/
		//���������֤μ���ǡ���������������ñ�̡�
		/****************************/
		while($client_list = pg_fetch_array($client_result2)){
			
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
			$sql .= "    state = '1' "; //�����η���
/*
			$sql .= "AND ";
			$sql .= "    request_state = '2' ";
*/
			$sql .= "AND ";
			$sql .= "    shop_id = ".$shop_list[0];
			$sql .= " AND ";
			$sql .= "    client_id = ".$client_list[0].";";
			$c_con_result = Db_Query($db_con, $sql); 

			/****************************/
			//��������ɽ�����֤ν�����ǡ����ɲ�(�̾���ɼ�����ե饤����ɼ����§���ǡ����ʳ�)
			/****************************/
			while($con_list = pg_fetch_array($c_con_result)){

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
				//$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$c_start_day,$end_day,$cal_peri);


				$date_array = Get_Round_Day($db_con,$contract_id,$c_start_day,$end_day);
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
						//���顼Ƚ��
						if($error_msg == NULL){
							//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
							$error_con = pg_last_error();
							$error_time = date("Y-m-d H:i");
							$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ��������ɽ�����֤ν�����ǡ����ɲý������� \n����ID: $contract_id \n��Զ�ʬ: �̾���ե饤����ɼ \n";
							$error_msg[1] = "$error_con \n\n";
						}
					}
				}
			}

			/****************************/
			//����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥����Ͽ�ؿ�     
			/****************************/
			//�̾���ե饤����ɼ����
			//$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$c_start_day,$end_day,NULL,true);
			$ao_result = Regist_Aord_Client($db_con,$shop_list[0],$client_list[0],$c_start_day,$end_day,NULL,true);

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
			//ľ�Ĥξ��ϡ�����饤����ɼ����
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
				$sql .= "    state = '1' "; //�����η���
				$sql .= "AND ";
				$sql .= "    shop_id = ".$shop_list[0];
				$sql .= " AND ";
				$sql .= "    client_id = ".$client_list[0].";";
				$trust_result = Db_Query($db_con, $sql); 
				//������ʬ����
				while($trust_list = pg_fetch_array($trust_result)){
					$contract_id  = $trust_list[0];  //�������ID
					$round_div    = $trust_list[1];  //����ʬ
					$cycle        = $trust_list[2];  //����
					$cale_week    = $trust_list[3];  //��̾�ʣ�������
					$abcd_week    = $trust_list[4];  //��̾�ʣ��£ãġ�
					$rday         = $trust_list[5];  //������
					$week_rday    = $trust_list[6];  //��������
					$stand_day    = $trust_list[7];  //��ȴ����
					$contract_div = $trust_list[8];  //�����ʬ
					$trust_id     = $trust_list[9];  //������ID
					$round_div    = $trust_list[10]; //����ʬ

					//��§���ʳ��ʤ���ơ��֥���ɲ�
					if($round_div != 7){
						/****************************/
						//������׻�����
						/****************************/
						$date_array = NULL;
						//$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$c_start_day,$end_day,$cal_peri);
						$date_array = Get_Round_Day($db_con,$contract_id,$c_start_day,$end_day);

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
								//���顼Ƚ��
								if($error_msg == NULL){
									//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
									$error_con = pg_last_error();
									$error_time = date("Y-m-d H:i");
									$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ��������ɽ�����֤ν�����ǡ����ɲý������� \n����ID: $contract_id \n��Զ�ʬ: ����饤����ɼ \n";
									$error_msg[1] = "$error_con \n\n";
								}
							}
						}
					}

					/****************************/
					//����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥����Ͽ�ؿ�     
					/****************************/
					//����饤����ɼ����
					//$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$c_start_day,$end_day,$trust_id,true);
					$ao_result = Regist_Aord_Client($db_con,$shop_list[0],$client_list[0],$c_start_day,$end_day,$trust_id,true);
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
	}

	//��������ɽ�������ѹ�Ƚ��
	if($shop_list[1] != NULL){
		$sql = "UPDATE t_client SET cal_peri_num = NULL WHERE client_id = ".$shop_list[0].";";
		$result = Db_Query($db_con,$sql);
		if($result === false){
			//���顼Ƚ��
			if($error_msg == NULL){
				//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ��������ɽ�������ѹ���������������� \n����å�ID: ".$shop_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}
	}

	/****************************/
	//�����褴�Ȥ˼���ǡ�������
	/****************************/
	$sql  = "SELECT DISTINCT ";
	$sql .= "    t_contract.client_id ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "    INNER JOIN t_client ON t_contract.client_id = t_client.client_id ";
	$sql .= "WHERE ";
	//$sql .= "    t_client.state = '1' ";
	//$sql .= "AND ";
	$sql .= "    t_contract.shop_id = ".$shop_list[0];
	$sql .= " ORDER BY ";
	$sql .= "    t_contract.client_id;";
	$client_result = Db_Query($db_con, $sql); 
	while($client_list = pg_fetch_array($client_result)){
		
		/****************************/
		//��������������դν�����ǡ������(��§���ǡ����ʳ�)
		/****************************/
		$sql  = "DELETE FROM ";
		$sql .= "    t_round ";
		$sql .= "WHERE ";
		$sql .= "    contract_id IN(";
		$sql .= "        SELECT ";
		$sql .= "            contract_id ";
		$sql .= "        FROM ";
		$sql .= "            t_contract ";
		$sql .= "        WHERE ";
		$sql .= "            round_div != '7' ";
		$sql .= "        AND ";
		$sql .= "            client_id = ".$client_list[0].") ";
		$sql .= "AND ";
		$sql .= "    round_day < '$to_date';";
		$del_result = Db_Query($db_con, $sql);
		if($del_result === false){
			//���顼Ƚ��
			if($error_msg == NULL){
				//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ��������������դν��������������� \n������ID: ".$client_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}

		/****************************/
		//�оݴ���(��λ)�ν�����ǡ������(��§���ǡ����ʳ�)
		/****************************/
		$sql  = "DELETE FROM ";
		$sql .= "    t_round ";
		$sql .= "WHERE ";
		$sql .= "    contract_id IN(";
		$sql .= "        SELECT ";
		$sql .= "            contract_id ";
		$sql .= "        FROM ";
		$sql .= "            t_contract ";
		$sql .= "        WHERE ";
		$sql .= "            round_div != '7' ";
		$sql .= "        AND ";
		$sql .= "            client_id = ".$client_list[0].") ";
		$sql .= "AND ";
		if($update_flg == "t"){
			$sql .= "    round_day >= '$start_day';";
		}else{
			$sql .= "    round_day = '$end_day';";
		}
		$del_result = Db_Query($db_con, $sql);
		if($del_result === false){
			//���顼Ƚ��
			if($error_msg == NULL){
				//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� �оݴ���(��λ)�ν��������������� \n������ID: ".$client_list[0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}

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
		$sql .= "    state = '1' "; //�����η���

/*
		$sql .= "AND ";
		$sql .= "    request_state = '2' ";
*/
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
			//$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);
			$date_array = Get_Round_Day($db_con,$contract_id,$start_day,$end_day);

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
					//���顼Ƚ��
					if($error_msg == NULL){
						//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
						$error_con = pg_last_error();
						$error_time = date("Y-m-d H:i");
						$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ������ơ��֥���Ͽ�������� \n����ID: $contract_id \n��Զ�ʬ: �̾���ե饤����ɼ \n";
						$error_msg[1] = "$error_con \n\n";
					}
				}
			}
		}
		/****************************/
		//����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥����Ͽ�ؿ�     
		/****************************/
		//�̾���ե饤����ɼ����
		//$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,NULL,true);
		$ao_result = Regist_Aord_Client($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,NULL,true);
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
			$sql .= "    state = '1' "; //�����η���
/*
			$sql .= "AND ";
			$sql .= "    request_state = '2' ";
*/
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
					//$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day,$cal_peri);
					$date_array = Get_Round_Day($db_con,$contract_id,$start_day,$end_day);

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
							//���顼Ƚ��
							if($error_msg == NULL){
								//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
								$error_con = pg_last_error();
								$error_time = date("Y-m-d H:i");
								$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ������ơ��֥���Ͽ�������� \n����ID: $contract_id \n��Զ�ʬ: ����饤����ɼ \n";
								$error_msg[1] = "$error_con \n\n";
							}
						}
					}
				}
		
				/****************************/
				//����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥����Ͽ�ؿ�     
				/****************************/
				//����饤����ɼ����
				//$ao_result = Aorder_Query($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,$trust_id,true);
				$ao_result = Regist_Aord_Client($db_con,$shop_list[0],$client_list[0],$start_day,$end_day,$trust_id,true);
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

	//����������ξ��
	if($error_msg == NULL){
		Db_Query($db_con, "COMMIT;");

	//�������۾�ξ��
	}else{
		Db_Query($db_con, "ROLLBACK");
		$error_flg = true;  //�۾�ȯ���ե饰

		//FILE�˥��顼����
		for($i=0;$i<count($error_msg);$i++){
			error_log($error_msg[$i],3,LOG_FILE);
			$e_contents .= $error_msg[$i];
		}

	}
}

//����������˽�λ�������
if($error_flg == false){
	$today = date("Y-m-d H:i:s");
	//FILE�˽���
	error_log("$today ������ɼ������λ \n\n",3,LOG_FILE);

//�����˰۾郎���ä����
}else{
	//�᡼��ǥ��顼����
	Error_send_mail($g_error_mail,$g_error_add,"������ɼ���������ǰ۾�ȯ��",$e_contents);
}

//���ޥ�ɥ饤�����ɼ��ƺ����������
if($update_flg == "t"){
	echo "����ɼ��ƺ����������ϡ�ɬ��update_flg�򸵤��ᤷ�Ʋ�����";
}

?>
