<?php

/******************************
 *  �ѹ�����
 *      ����2006-11-17��ROLLBACK������ˡ����顼���Ƥ���˽��� <suzuki>
 *      ����2009-01-24�˹�����ξ����Ǥ��������׻�����Ƥ��ʤ��Х�����<watanabe-k>
 *
*******************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2010/01/10                  aoyama-n    ������Ψ���������Τߤ�Ԥ��褦���ѹ�
 */

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

//���Ͻ���
$today = date("Y-m-d H:i:s");
error_log("$today �����ǲ��곫�� \n",3,LOG_FILE);

//���顼�ѿ������
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/****************************/
//�������ѹ�����
/****************************/

//����������
$today = date("Y-m-d");

//�������ѹ��μ�������
#2010-01-10 aoyama-n
/*******************
$sql  = "SELECT ";
$sql .= "    client_id, ";     //�����ID
$sql .= "    tax_rate_c, ";    //�����������
$sql .= "    tax_rate_n, ";    //������
$sql .= "    coax, ";          //��۴ݤ��ʬ
$sql .= "    tax_franct ";     //������ü����ʬ
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_div = 3 ";
$sql .= "AND ";
$sql .= "    tax_rate_cday = '$today' ";
$sql .= "AND ";
$sql .= "    tax_rate_c IS NOT NULL;";
*******************/

$sql  = "SELECT ";
$sql .= "    client_id, ";
$sql .= "    tax_rate_now, ";
$sql .= "    tax_rate_new, ";
$sql .= "    tax_change_day_new ";
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    ( client_div = 3 OR client_div = 0 ) ";
$sql .= "AND ";
$sql .= "    tax_change_day_new = '$today' ";
$sql .= "AND ";
$sql .= "    tax_rate_new IS NOT NULL ";
$sql .= "AND ";
$sql .= "    tax_change_day_new IS NOT NULL;";

$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);

#echo "start\n";

for($i=0;$i<count($data_list);$i++){
	Db_Query($db_con, "BEGIN;");

	$error_msg = NULL;  //���顼��å���������

	/****************************/
	//������ޥ����ξ������ѹ�
	/****************************/
    #2010-01-10 aoyama-n
    /*******************
	$sql  = "UPDATE t_client SET ";
	$sql .= "    tax_rate_n = ".$data_list[$i][1].",";
	$sql .= "    tax_rate_c = NULL ";
#�������ϼ¹ԥ��Ȥ��ƻĤ��褦�ˤ���
#	$sql .= "    tax_rate_c = NULL,";
#	$sql .= "    tax_rate_cday = NULL ";
	$sql .= "WHERE ";
	$sql .= "    client_id = ".$data_list[$i][0].";";
    *******************/

    $sql  = "UPDATE t_client SET ";
    $sql .= "    tax_rate_old = '".$data_list[$i][1]."',";
    $sql .= "    tax_rate_now = '".$data_list[$i][2]."',";
    $sql .= "    tax_change_day_now = '".$data_list[$i][3]."',";
    $sql .= "    tax_rate_new = NULL, ";
    $sql .= "    tax_change_day_new = NULL ";
    $sql .= "WHERE ";
    $sql .= "    client_id = ".$data_list[$i][0].";";
	$result = Db_Query($db_con, $sql);
	if($result === false){
/*
	    Db_Query($db_con, "ROLLBACK");
	    exit;
*/
		$error_con = pg_last_error();
		$error_time = date("Y-m-d H:i");
		$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ������ޥ����ξ����ǲ��꼺�� \n������ID: ".$data_list[$i][0]." \n";
		$error_msg[1] = "$error_con \n\n";
	}


	/****************************/
	//������������
	/****************************/
    #2010-01-10 aoyama-n
    /*******************
	$sql  = "SELECT ";
	$sql .= "    tax_rate_n ";    //������ξ�����
	$sql .= "FROM ";
	$sql .= "    t_client ";
	$sql .= "WHERE ";
	$sql .= "    client_id = ".$data_list[$i][0].";";
	$result = Db_Query($db_con, $sql); 
	$tax_list = Get_Data($result);

	$tax_num    = $tax_list[0][0];
	$coax       = $data_list[$i][3];
	$tax_franct = $data_list[$i][4];
    *******************/

	/****************************/
	//����إå�ID����
	/****************************/
    #2010-01-10 aoyama-n
    /*******************
    $sql  = "SELECT ";
	$sql .= "    t_aorder_h.aord_id,";        //����ID
	$sql .= "    t_aorder_d.aord_d_id,";      //����ǡ���ID
	$sql .= "    t_aorder_d.tax_div,";        //���Ƕ�ʬ
	$sql .= "    t_aorder_d.sale_amount ";    //�����
	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "    INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.ord_time > NOW() ";
	#��񤭤�ͽ��ǡ�������Ф�Ԥ����ᡢ�������ϥ����ȥ�����
	#$sql .= "AND ";
	#$sql .= "    t_aorder_h.confirm_flg = 'f' ";
	$sql .= "AND ";
	$sql .= "    t_aorder_d.contract_id IS NOT NULL ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.shop_id = ".$data_list[$i][0].";";

	$result = Db_Query($db_con, $sql);
	$aord_array = Get_Data($result);

	//�إå������Ȥ�Ϣ����������
	for($x=0;$x<count($aord_array);$x++){
		//$m_data[����ID][����ǡ���ID][0] = ���Ƕ�ʬ
		//$m_data[����ID][����ǡ���ID][1] = �����
		$aord_id = $aord_array[$x][0];    //����ID
		$aord_d_id = $aord_array[$x][1];  //����ǡ���ID

		$m_data[$aord_id][$aord_d_id][0] = $aord_array[$x][2];
		$m_data[$aord_id][$aord_d_id][1] = $aord_array[$x][3];
	}
    *******************/

	/****************************/
	//����إå��ξ����ǳ��ѹ�����
	/****************************/
    #2010-01-10 aoyama-n
    /*******************
	while($aord_num = each($m_data)){
		//����إå�ID��ź������
		$aord_id = $aord_num[0];
		$c=0;

		#����ν������Ԥ��褦�˽���
		$tax_div = null;
		$sale_data = null;
		while($aord_d_num = each($m_data[$aord_id])){
			//����ǡ���ID��ź������
			$aord_d_id = $aord_d_num[0];
			//�إå����˳ݤ���ǡ����ζ�ۤ����
			$tax_div[$c]   = $m_data[$aord_id][$aord_d_id][0];
			$sale_data[$c] = $m_data[$aord_id][$aord_d_id][1];
			$c++;
		}

		#echo "aord_id\n";
		#echo $aord_id;
		#echo "\n";

		#echo "tax_div\n";
		#Print_Array($tax_div);

		#echo "sale_amount\n";
		#Print_Array($sale_data);

		//����ۡ������ǳۤι�׽���
		$total_money = Total_Amount($sale_data, $tax_div,$coax,$tax_franct,$tax_num,$data_list[$i][0],$db_con);
		$sale_tax    = $total_money[1];

		#echo "sale_tax\n";
		#echo $sale_tax;
		#echo "\n";


		$sql  = "UPDATE t_aorder_h SET ";
		$sql .= "    tax_amount = $sale_tax ";
		$sql .= "WHERE ";
		$sql .= "    aord_id = $aord_id;";
		
		$result = Db_Query($db_con, $sql);
	    if($result == false){
    *******************/
		/*
	        Db_Query($db_con, "ROLLBACK");
	        exit;
		*/
    #2010-01-10 aoyama-n
    /*******************
			//�����蹹������Ƚ��
			if($error_msg == NULL){
				//���Ԥ��Ƥ��ʤ��ä������Υ��顼����
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ����إå��ơ��֥�ξ����ǳ۲��꼺�� \n����ID: $aord_id \n����å�ID: ".$data_list[$i][0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
	    }
	}
    *******************/

	//���顼Ƚ��
	if($error_msg == NULL){
		//����

		Db_Query($db_con, "COMMIT;");
	}else{
		//�۾�

		Db_Query($db_con, "ROLLBACK");
		//FILE�˥��顼����
		$estr = NULL;
		for($e=0;$e<count($error_msg);$e++){
			error_log($error_msg[$e],3,LOG_FILE);
			$e_contents .= $error_msg[$e];
		}

		$error_flg = true;  //�۾�ȯ���ե饰
	}
}

#echo "end\n";

//����Ƚ��
if($error_flg == false){
	//����

	$today = date("Y-m-d H:i:s");
	//FILE�˽���
	error_log("$today �����ǲ��괰λ \n\n",3,LOG_FILE);
}else{
	//�۾�

	//�᡼��ǥ��顼����
	Error_send_mail($g_error_mail,$g_error_add,"�����ǲ�������ǰ۾�ȯ��",$e_contents);
}

?>
