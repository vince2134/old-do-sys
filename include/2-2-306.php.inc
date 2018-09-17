<?php
/**
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/07      ban_0052    suzuki      ô����CD�θ�����､��
 *
 * ���� ����˴ؤ���ǡ������������
 *
 * ���� ��5������count�����ꤵ�줿���ϡ����פ��������֤��ޤ���
 *
 * @param string   $db_con     DB��³�꥽����
 * @param array    $where      SQL���ʸ
 * @param string   $page_snum  ɽ�����Ϸ��
 * @param string   $page_enum  ɽ����λ���
 * @param string   $kind       ����ͤμ���
 *
 * @return array               ����ǡ���
 */
function Get_Claim_Data($db_con, $where, $page_snum="", $page_enum="", $kind=""){

	$offset = $page_snum-1; //ɽ�����ʤ����
	$limit  = ($page_enum - $page_snum) +1;    //��ڡ���������η��

	//**************************//
	//HTML��value�ͤ�SQL�Ѥ˲ù�
	//**************************//
	// ���������ʳ��ϡ�
	if ($where[close_day_s][y] != NULL) {
		$yy_1 = str_pad($where[close_day_s][y], 4, 0, STR_POS_LEFT);
	}
	if ($where[close_day_s][m] != NULL) {
		$mm_1 = str_pad($where[close_day_s][m], 2, 0, STR_POS_LEFT);
	}
	if ($where[close_day_s][d] != NULL) {
		$dd_1 = str_pad($where[close_day_s][d], 2, 0, STR_POS_LEFT);
	}
	$close_day_s = "$yy_1"."$mm_1"."$dd_1";
	
	// ���������ʽ�λ��
	if ($where[close_day_e][y] != NULL) {
		$yy_2 = str_pad($where[close_day_e][y], 4, 0, STR_POS_LEFT);
	}
	if ($where[close_day_e][m] != NULL) {
		$mm_2 = str_pad($where[close_day_e][m], 2, 0, STR_POS_LEFT);
	}
	if ($where[close_day_e][d] != NULL) {
		$dd_2 = str_pad($where[close_day_e][d], 2, 0, STR_POS_LEFT);
	}
	$close_day_e = "$yy_2"."$mm_2"."$dd_2";

	// ���ṹ��
	if ($where[claim_update] == "1") {
		$where[claim_update] = "";
	}elseif ($where[claim_update] == "2") {
		$where[claim_update] = "t";
	}elseif ($where[claim_update] == "3") {
		$where[claim_update] = "f";
	}

	/****************************/
	//�����ǡ��������SQL
	/****************************/
	$sql_column = "
	SELECT	
		t_bill.bill_id,   
		t_bill.bill_no,   
		t_bill_d.bill_close_day_this,   
		t_bill_d.client_id,
		t_bill_d.client_cd1,
		t_bill_d.client_cd2,
		t_bill_d.client_cname,
		t_bill.claim_cd1,
		t_bill.claim_cd2,
		t_bill.claim_cname,
		t_bill.staff_cd,
		t_bill.staff_name,
		t_bill_d.bill_amount_last, 
		t_bill_d.pay_amount,
		t_bill_d.rest_amount,
		t_bill_d.sale_amount,
		t_bill_d.tax_amount,
		t_bill_d.intax_amount,
		t_bill_d.bill_amount_this, 
		t_bill.last_update_flg,
		t_bill.last_update_day
	";
	$sql = "
	FROM	
		t_bill INNER JOIN t_bill_d
		ON t_bill.bill_id = t_bill_d.bill_id	

	WHERE	
		t_bill.shop_id = $_SESSION[client_id]
	AND	
		t_bill.bill_no IS NOT NULL
	AND	
		t_bill_d.close_day IS NOT NULL
	AND	
		t_bill.first_set_flg = 'f'
	";

	// �����ֹ�
	if ($where[bill_no] != "") {
		$sql .= "AND t_bill.bill_no LIKE '$where[bill_no]%'";
	}
	// ���������ʳ��ϡ�
	if ($close_day_s != "") {
		$sql .= "AND t_bill_d.bill_close_day_this >= '$close_day_s' ";
	}
	// ���������ʽ�λ��
	if ($close_day_e != "") {
		$sql .= "AND t_bill_d.bill_close_day_this <= '$close_day_e' ";
	}
	// �����襳����
	if ($where[client_cd][1] != "") {
		$sql .= "AND t_bill_d.client_cd1 LIKE '".$where[client_cd][1]."%'";
	}
	if ($where[client_cd][2] != "") {
		$sql .= "AND t_bill_d.client_cd2 LIKE '".$where[client_cd][2]."%'";
	}
	// ������̾
	if ($where[client_cname] != "") {
		$sql .= " AND (t_bill_d.client_name1 LIKE '%$where[client_cname]%'";
		$sql .= " OR t_bill_d.client_name2 LIKE '%$where[client_cname]%'";
		$sql .= " OR t_bill_d.client_cname LIKE '%$where[client_cname]%'";
		$sql .= ")";
	}

	// �����襳����
	if ($where[claim_cd][1] != "") {
		$sql .= "AND t_bill.claim_cd1 LIKE '".$where[claim_cd][1]."%'";
	}
	if ($where[claim_cd][2] != "") {
		$sql .= "AND t_bill.claim_cd2 LIKE '".$where[claim_cd][2]."%'";
	}
	// ������̾
	if ($where[claim_cname] != "") {
		$sql .= " AND (t_bill.claim_name1 LIKE '%$where[claim_cname]%'";
		$sql .= " OR t_bill.claim_name2 LIKE '%$where[claim_cname]%'";
		$sql .= " OR t_bill.claim_cname LIKE '%$where[claim_cname]%'";
		$sql .= ")";
	}

	// ô���ԥ�����
	if ($where[staff_cd] != "") {
		//$sql .= "AND t_bill.staff_cd LIKE '".$where[staff_cd]."%'";
		$sql .= "AND t_bill.staff_cd = ".(int)$where[staff_cd];
	}
	// ô����̾
	if ($where[staff_name] != "") {
		$sql .= "AND t_bill.staff_name LIKE '%".$where[staff_name]."%'";
	}

	// ����������
	if ($where[bill_amount_last][min] != "") {
		$sql .= "AND t_bill_d.bill_amount_last >= '".$where[bill_amount_last][min]."'";
	}
	if ($where[bill_amount_last][max] != "") {
		$sql .= "AND t_bill_d.bill_amount_last <= '".$where[bill_amount_last][max]."'";
	}
	
	// ���������
	if ($where[pay_amount][min] != "") {
		$sql .= "AND t_bill_d.pay_amount >= '".$where[pay_amount][min]."'";
	}
	if ($where[pay_amount][max] != "") {
		$sql .= "AND t_bill_d.pay_amount <= '".$where[pay_amount][max]."'";
	}

	// ���ۻĹ��
	if ($where[rest_amount][min] != "") {
		$sql .= "AND t_bill_d.rest_amount >= '".$where[rest_amount][min]."'";
	}
	if ($where[rest_amount][max] != "") {
		$sql .= "AND t_bill_d.rest_amount <= '".$where[rest_amount][max]."'";
	}

	// ����������
	if ($where[bill_amount_this][min] != "") {
		$sql .= "AND t_bill_d.bill_amount_this >= '".$where[bill_amount_this][min]."'";
	}
	if ($where[bill_amount_this][max] != "") {
		$sql .= "AND t_bill_d.bill_amount_this <= '".$where[bill_amount_this][max]."'";
	}
	
	// ���ṹ��
	if ($where[claim_update] != "") {
		$sql .= "AND t_bill.last_update_flg = '$where[claim_update]' ";
	}

	$sql_another = "ORDER BY t_bill_d.bill_close_day_this, t_bill_d.client_cd1, t_bill_d.client_cd2 ";
	
	if ($where[hyoujikensuu] != "all") {
		$sql_another .= "LIMIT $limit OFFSET $offset ";
	}
	
	//�����˳��������ַ���פ��֤��ƽ�λ
	if ($kind == "count") {
		$sql_column = "SELECT COUNT(t_bill.bill_id) ";
		$exec_sql   = "$sql_column"."$sql";
		$result     = Db_Query($db_con, $exec_sql);
		$data       = pg_fetch_result($result, 0 ,0);
		return $data;

	//������ �����ǡ��������
	} else {
		$exec_sql   = "$sql_column"."$sql"."$sql_another";
		$result = Db_Query($db_con, $exec_sql);
	}
	
	
	/****************************/
	//�����ǡ�����ƥ�ץ졼���Ѥ˲ù�����
	/****************************/
	$i="0";
	while ($data[$i] = pg_fetch_array ($result)) {

		$bill_id = $data[$i][bill_id];
		$client_id = $data[$i][client_id];

		//���
		$data[0][sum][bill_amount_last] += $data[$i][bill_amount_last];
		$data[0][sum][pay_amount]       += $data[$i][pay_amount];
		$data[0][sum][rest_amount]      += $data[$i][rest_amount];
		$data[0][sum][sale_amount]      += $data[$i][sale_amount];
		$data[0][sum][tax_amount]       += $data[$i][tax_amount];
		$data[0][sum][intax_amount]     += $data[$i][intax_amount];
		$data[0][sum][bill_amount_this] += $data[$i][bill_amount_this];
		
		//��No.
		$data[$i][no] = $page_snum;
		$data[0][sum][no] ++; //���

		//�����ֹ���
		//�����ξ��
		if ($_SESSION[group_kind] == "1") {
			$data[$i][bill_no]    = "<a href=\"1-2-304.php?claim_id=$bill_id&client_id=$client_id\">".$data[$i][bill_no]."</a>";
		//FC�ξ��
		} else {
			$data[$i][bill_no]    = "<a href=\"2-2-304.php?claim_id=$bill_id&client_id=$client_id\">".$data[$i][bill_no]."</a>";
		}

		$data[$i][client_name]      = htmlspecialchars($data[$i][client_name]);
		$data[$i][client_cname]      = htmlspecialchars($data[$i][client_cname]);
		$data[$i][claim_name]       = htmlspecialchars($data[$i][claim_name]);
		$data[$i][claim_cname]       = htmlspecialchars($data[$i][claim_cname]);
		$data[$i][staff_name]       = htmlspecialchars($data[$i][staff_name]);

		//ô���ԥ����ɤ�0���
		if ($data[$i][staff_cd] != NULL){
			$data[$i][staff_cd]         = str_pad($data[$i][staff_cd], 4, 0, STR_POS_LEFT);
			$data[0][sum][staff_cd]++;
		}

		//��������ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
			$data[$i][bill_amount_last] = Minus_Numformat($data[$i][bill_amount_last]);
		
		//��������ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
			$data[$i][pay_amount]       = Minus_Numformat($data[$i][pay_amount]);
	
		//�����ۻĹ�ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
			$data[$i][rest_amount]      = Minus_Numformat($data[$i][rest_amount]);
	
		//�������ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
			$data[$i][sale_amount]      = Minus_Numformat($data[$i][sale_amount]);
	
		//��������ǳۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
			$data[$i][tax_amount]       = Minus_Numformat($data[$i][tax_amount]);
	
		//�ǹ����ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
			$data[$i][intax_amount]     = Minus_Numformat($data[$i][intax_amount]);
	
		//���������ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
			$data[$i][bill_amount_this] = Minus_Numformat($data[$i][bill_amount_this]);

		
		$i++;
		$page_snum++;

	}

	/****************************/
	//��׳ۤˤĤ��Ƥν���
	/****************************/
	//��������ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
	if ($data[0][sum][bill_amount_last] < 0){
		$data[0][sum][bill_amount_last] = number_format($data[0][sum][bill_amount_last]);
		$data[0][sum][bill_amount_last] = "<font color=\"red\">".$data[0][sum][bill_amount_last]."</font>";
	}	else {
		$data[0][sum][bill_amount_last] = number_format($data[0][sum][bill_amount_last]);
	}
	
	//��������ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
	if ($data[0][sum][pay_amount] < 0){
		$data[0][sum][pay_amount]       = number_format($data[0][sum][pay_amount]);
		$data[0][sum][pay_amount] = "<font color=\"red\">".$data[0][sum][pay_amount]."</font>";
	}	else {
		$data[0][sum][pay_amount]       = number_format($data[0][sum][pay_amount]);
	}

	//�����ۻĹ�ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
	if ($data[0][sum][rest_amount] < 0){
		$data[0][sum][rest_amount]      = number_format($data[0][sum][rest_amount]);
		$data[0][sum][rest_amount] = "<font color=\"red\">".$data[0][sum][rest_amount]."</font>";
	}	else {
		$data[0][sum][rest_amount]      = number_format($data[0][sum][rest_amount]);
	}

	//�������ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
	if ($data[0][sum][sale_amount] < 0){
		$data[0][sum][sale_amount]      = number_format($data[0][sum][sale_amount]);
		$data[0][sum][sale_amount] = "<font color=\"red\">".$data[0][sum][sale_amount]."</font>";
	}	else {
		$data[0][sum][sale_amount]      = number_format($data[0][sum][sale_amount]);
	}

	//��������ǳۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
	if ($data[0][sum][tax_amount] < 0){
		$data[0][sum][tax_amount]       = number_format($data[0][sum][tax_amount]);
		$data[0][sum][tax_amount] = "<font color=\"red\">".$data[0][sum][tax_amount]."</font>";
	}	else {
		$data[0][sum][tax_amount]       = number_format($data[0][sum][tax_amount]);
	}

	//�ǹ����ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
	if ($data[0][sum][intax_amount] < 0){
		$data[0][sum][intax_amount]     = number_format($data[0][sum][intax_amount]);
		$data[0][sum][intax_amount] = "<font color=\"red\">".$data[0][sum][intax_amount]."</font>";
	}	else {
		$data[0][sum][intax_amount]     = number_format($data[0][sum][intax_amount]);
	}

	//���������ۤ��ޥ��ʥ��ξ�����ʸ����ɽ��
	if ($data[0][sum][bill_amount_this] < 0){
		$data[0][sum][bill_amount_this] = number_format($data[0][sum][bill_amount_this]);
		$data[0][sum][bill_amount_this] = "<font color=\"red\">".$data[0][sum][bill_amount_this]."</font>";
	}	else {
		$data[0][sum][bill_amount_this] = number_format($data[0][sum][bill_amount_this]);
	}

	//while�����Ǻǽ������"NULL"�����뤿�������
	array_pop($data);

	return $data;
}

?>