<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

/****************************/
//�������ѹ�����
/****************************/

//�������ѹ��μ�������
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
$sql .= "    tax_rate_cday IS NOT NULL ";
$sql .= "AND ";
$sql .= "    tax_rate_c IS NOT NULL;";

$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);

//�����ǹ�������
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
//����إå��ξ����ǳ��ѹ�����
/****************************/
for($j=0;$j<count($data_list);$j++){

	/****************************/
	//������������
	/****************************/
	$tax_num    = $data_list[$j][2];
	$coax       = $data_list[$j][3];
	$tax_franct = $data_list[$j][4];

	/****************************/
	//����إå�ID����
	/****************************/
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
	$sql .= "AND ";
	$sql .= "    t_aorder_h.confirm_flg = 'f' ";
	$sql .= "AND ";
	$sql .= "    t_aorder_d.contract_id IS NOT NULL ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.shop_id = ".$data_list[$j][0].";";

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

	/****************************/
	//�إå����Ȥ˾����Ƕ���ѹ�
	/****************************/
	while($aord_num = each($m_data)){
		//����إå�ID��ź������
		$aord_id = $aord_num[0];
		$c=0;
		while($aord_d_num = each($m_data[$aord_id])){
			//����ǡ���ID��ź������
			$aord_d_id = $aord_d_num[0];
			//�إå����˳ݤ���ǡ����ζ�ۤ����
			$tax_div[$c]   = $m_data[$aord_id][$aord_d_id][0];
			$sale_data[$c] = $m_data[$aord_id][$aord_d_id][1];
			$c++;
		}

		//����ۡ������ǳۤι�׽���
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
