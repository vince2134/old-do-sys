<?php
$page_title = "���ͽ�ꥫ������(��)";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

/****************************/
//�����ѿ�
/****************************/
$client_id = $_SESSION["client_id"];

/****************************/
//������������
/****************************/
$sql  = "SELECT ";
$sql .= "    cal_peri ";    //��������ɽ������
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_id = $client_id;";
$result = Db_Query($db_con, $sql);
$num = pg_num_rows($result);
//�����ǡ���������
if($num == 1){
	$cal_peri      = pg_fetch_result($result, 0,0);
}

//�������
$sql  = "SELECT stand_day FROM t_stand;";
$result = Db_Query($db_con, $sql); 
$stand_day = pg_fetch_result($result,0,0);   
$day_by = substr($stand_day,0,4);
$day_bm = substr($stand_day,5,2);
$day_bd = substr($stand_day,8,2);

//����������ɽ�����֥ǡ���
$cal_peri = 3;

/****************************/
//�����ǡ�������
/****************************/
$sql  = "SELECT ";
$sql .= "    holiday ";     //����
$sql .= "FROM ";
$sql .= "    t_holiday ";
$sql .= "WHERE ";
$sql .= "    shop_id = $client_id;";
$result = Db_Query($db_con, $sql);
$h_data = Get_Data($result);
for($h=0;$h<count($h_data);$h++){
	//�����ǡ�����Ϣ������ˤ�ä����
	$holiday[$h_data[$h][0]] = "1";
}

/****************************/
//���եǡ�������
/****************************/
//���������ռ���
$year  = date("Y");
$month = date("m");
$day   = date("d");

//��������ɽ������
$cal_range = $year."ǯ ".str_pad($month-1, 2, 0, STR_POS_LEFT)."�� �� ".$year."ǯ ".str_pad($month+$cal_peri, 2, 0, STR_POS_LEFT)."��";

//�콵�ָ�����ռ���
$next = mktime(0, 0, 0, $month,$day+6,$year);
$nyear  = date("Y",$next);
$nmonth = date("m",$next);
$nday   = date("d",$next);

/****************************/
//POST�������
/****************************/
$post_part_id = $_POST["form_part_1"];        //����

//ͽ���������ꤵ��Ƥ��뤫
if($_POST["form_sale_day"]["y"] != NULL && $_POST["form_sale_day"]["m"] != NULL && $_POST["form_sale_day"]["d"] != NULL){
	$year = $_POST["form_sale_day"]["y"];    
	$month = $_POST["form_sale_day"]["m"];
	$day = $_POST["form_sale_day"]["d"];

	//ͽ��������콵�ָ������
	$next = mktime(0, 0, 0, $month,$day+6,$year);
	$nyear  = date("Y",$next);
	$nmonth = date("m",$next);
	$nday   = date("d",$next);

	//ͽ�������ह��ե饰
	$sale_day_flg = true;
}

/****************************/
//�������轵�ܥ��󲡲�����
/****************************/
if($_POST["back_d_button_flg"] == true || $_POST["back_w_button_flg"] == true){
	//POSTȽ��
	if($_POST["back_d_count"] == NULL){
		//�轵Ƚ��
		if($_POST["back_w_button_flg"] == true){
			//̵��
			$back_d_count = 7;
		}else{
			//̵��
			$back_d_count = 1;
		}
	}else{
		//�轵Ƚ��
		if($_POST["back_w_button_flg"] == true){
			//ͭ��
			//�������顢����ʬ����
	    	$back_d_count = $_POST["back_d_count"]+7;
		}else{
			//ͭ��
			//�������顢����ʬ����
	    	$back_d_count = $_POST["back_d_count"]+1;
		}
	}

	//POSTȽ��
	if($_POST["next_d_count"] == NULL){
		//̵����
		$next_d_count = 0;
	}else{
		//ͭ��
		//�����ˡ�����ʬ­��
    	$next_d_count = $_POST["next_d_count"];
	}

	//ͽ�������Ƚ��
	if($sale_day_flg == true){
		//ͽ���������ռ���
		$str = mktime(0, 0, 0, $month,$day-$back_d_count,$year);
	}else{
		//���������ռ���
		$str = mktime(0, 0, 0, date("n"),date("j")-$back_d_count,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("n",$str);
	$day   = date("j",$str);

	//­����ʬ�������θ����
	$str = mktime(0, 0, 0, $month,$day+$next_d_count,$year);
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day   = date("d",$str);

	//�콵�ָ�����ռ���
	$next = mktime(0, 0, 0, $month,$day+6,$year);
	$nyear  = date("Y",$next);
	$nmonth = date("m",$next);
	$nday   = date("d",$next);

	//�����ϡ�����鸫�ư���������������ʤ��褦��Ƚ�ꤹ��
	$last_day = date("Y-m-d", mktime(0, 0, 0, date("n")-1,1,date("Y")));
	
	//����κǽ�ν���
	$check_day = date("Y-m-d", mktime(0, 0, 0, $month,$day-7,$year));
	if($check_day <= $last_day){
		//�轵�ܥ������ɽ���ˤ���
		$bw_disabled_flg = true;
	}

	//����Σ�����
	if($year."-".$month."-".$day == $last_day){
		//�����ܥ������ɽ���ˤ���
		$bd_disabled_flg = true;
	}

	//�����ܥ���ե饰�򥯥ꥢ
    $back_data["back_d_button_flg"] = "";
	//�轵�ܥ���ե饰���ꥢ
	$back_data["back_w_button_flg"] = "";
	$back_data["back_d_count"]      = $back_d_count;
    $form->setConstants($back_data);
}

/****************************/
//�������⽵�ܥ��󲡲�����
/****************************/
if($_POST["next_d_button_flg"] == true || $_POST["next_w_button_flg"] == true){

	//POSTȽ��
	if($_POST["next_d_count"] == NULL){
		//�⽵Ƚ��
		if($_POST["next_w_button_flg"] == true){
			//̵��
			$next_d_count = 7;
		}else{
			//̵����
			$next_d_count = 1;
		}
	}else{
		//�⽵Ƚ��
		if($_POST["next_w_button_flg"] == true){
			//ͭ��
			//����ˡ����ʬ­��
	    	$next_d_count = $_POST["next_d_count"]+7;
		}else{
			//ͭ��
			//����ˡ����ʬ­��
	    	$next_d_count = $_POST["next_d_count"]+1;
		}
	}

	//POSTȽ��
	if($_POST["back_d_count"] == NULL){
		//̵��
		$back_d_count = 0;
	}else{
		//ͭ��
		//����ˡ����ʬ����
    	$back_d_count = $_POST["back_d_count"];
	}

	//ͽ�������Ƚ��
	if($sale_day_flg == true){
		//ͽ���������ռ���
		$str = mktime(0, 0, 0, $month,$day+$next_d_count,$year);
	}else{
		//���������ռ���
		$str = mktime(0, 0, 0, date("n"),date("j")+$next_d_count,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("n",$str);
	$day   = date("j",$str);

	//������ʬ�������θ����
	$str = mktime(0, 0, 0, $month,$day-$back_d_count,$year);
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day   = date("d",$str);

	//��������ɽ������ʬ����ɽ�������ʤ���Ƚ��
	$max_day = date("t",mktime(0, 0, 0, date("n")+$cal_peri,1,date("Y")));
	$fast_day = date("Y-m-d", mktime(0, 0, 0, date("n")+$cal_peri,$max_day,date("Y")));

	//���κǽ�ν���
	$check_day = date("Y-m-d", mktime(0, 0, 0, $month,$day+7,$year));
	if($check_day >= $fast_day){
		//�⽵�ܥ������ɽ���ˤ���
		$nw_disabled_flg = true;

		//�����ޤǤ����ռ���
		$nyear = substr($fast_day,0,4);
		$nmonth = substr($fast_day,5,2);
		$nday = substr($fast_day,8,2);
	}else{
		//�콵�ָ�����ռ���
		$next = mktime(0, 0, 0, $month,$day+6,$year);
		$nyear  = date("Y",$next);
		$nmonth = date("m",$next);
		$nday   = date("d",$next);
	}

	//���Σ�����
	if($year."-".$month."-".$day == $fast_day){
		//�����ܥ������ɽ���ˤ���
		$nd_disabled_flg = true;
	}

	//�����ܥ���ե饰�򥯥ꥢ
    $next_data["next_d_button_flg"] = "";
	//�⽵�ܥ���ե饰�򥯥ꥢ
	$next_data["next_w_button_flg"] = "";
	$next_data["next_d_count"]      = $next_d_count;
    $form->setConstants($next_data);
}

/****************************/
//���ɽ��
/****************************/
$def_fdata = array(
    "form_output"     => "1",

);
$form->setDefaults($def_fdata);

/****************************/
//�ե��������
/****************************/
//���Ϸ���
$radio1[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "Ģɼ","2");
$form->addGroup($radio1, "form_output", "���Ϸ���");

//����
$select_value = Select_Get($db_con,'part');
$form->addElement('select', 'form_part_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ɽ���ܥ���
$button[] = $form->createElement("submit","indicate_button","ɽ����","onClick=\"javascript:Which_Type('form_output','".FC_DIR."sale/2-2-115-2.php','#')\"");

//���ꥢ�ܥ���
$button[] = $form->createElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addGroup($button, "form_button", "�ܥ���");

//���ͽ��ɽ
//$form->addElement("button","form_patrol_button","���ͽ��ɽ","onClick=\"javascript:Referer('2-2-102.php')\"");
//ñ���ѹ�
$form->addElement("button","form_single_month_change_button","�ȡ���","onClick=\"javascript:Referer('2-2-102-2.php')\"");
//�ޥ����ѹ�
$form->addElement("button","form_master_change_button","�ѡ���","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//��ɼ����
$form->addElement("button","form_slip_button","��ɼ����","onClick=\"javascript:Referer('2-2-201.php')\"");
//������ɽ���ܥ���
$form->addElement("button","form_course","������ɽ��");

$form->addElement("hidden", "back_w_button_flg");     //�轵�ܥ��󲡲�Ƚ��
$form->addElement("hidden", "back_d_button_flg");     //�����ܥ��󲡲�Ƚ��
$form->addElement("hidden", "next_w_button_flg");     //�⽵�ܥ��󲡲�Ƚ��
$form->addElement("hidden", "next_d_button_flg");     //�����ܥ��󲡲�Ƚ��
$form->addElement("hidden", "next_d_count");          //�������鲿����
$form->addElement("hidden", "back_d_count");          //�������鲿����

//ͽ����
$text = NULL;
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_sale_day[y]','form_sale_day[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_sale_day[m]','form_sale_day[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup( $text,"form_sale_day","form_sale_day");

/****************************/
//����ѹ��ǡ�������
/****************************/
//���ô���Լ�������
$aorder_staff = array(1=>"0",2=>"1",3=>"2",4=>"3");

for($i=1;$i<=4;$i++){

	//ô���ԡʥᥤ���Ƚ��
	if($i!=1){
		//�ᥤ��ʳ���UNION�Ƿ��
		$sql .= "UNION  \n";
		$sql .= "SELECT  \n";
	}else{
		//�ᥤ��
		$sql  = "SELECT  \n";
	}

	//������
	$sql .= "    t_part.part_name,";              //����̾0
	$sql .= "    t_staff$i.staff_name,";          //�����å�̾1
	$sql .= "    t_aorder_h.net_amount,";         //�����2
	$sql .= "    t_aorder_h.ord_time,";           //������3
	$sql .= "    t_aorder_h.route,";              //��ϩ4
	$sql .= "    t_client.client_cname,";         //������̾5
	$sql .= "    t_aorder_h.aord_id,";            //����ID6
	$sql .= "    t_aorder_h.hand_slip_flg,";      //�����ɼ�ե饰7
	$sql .= "    t_aorder_h.reserve_del_flg,";    //��α��ɼ����ե饰8
	$sql .= "    t_aorder_h.confirm_flg, ";       //�����ե饰9
	$sql .= "    t_staff$i.staff_cd1,";           //�����åե�����1 10
	$sql .= "    t_staff$i.staff_cd2, ";          //�����åե�����2 11
	$sql .= "    CASE ";                          //����ID12
	$sql .= "    WHEN t_part.part_id IS NULL THEN 0 ";
	$sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id ";
	$sql .= "    END,";
	$sql .= "    t_aorder_h.reason,";             //��α��ͳ13
	$sql .= "    t_aorder_h.confirm_flg,";        //������ɼ14
	$sql .= "    t_client.client_id,";            //������ID15
	$sql .= "    t_staff$i.charge_cd, ";          //ô���ԥ�����16
	$sql .= "    t_client.client_cd1,";           //�����襳����1 17
	$sql .= "    t_client.client_cd2, ";          //�����襳����2 18
	$sql .= "    t_staff$i.staff_id, ";           //�����å�ID19
	$sql .= "    t_aorder_h.tax_amount,";         //�����ǳ� 20
	$sql .= "    t_staff$i.sale_rate,";           //���Ψ 21
	$sql .= "    t_part.part_cd, ";               //����̾CD 22
	$sql .= "    t_aorder_h.shop_id, \n";         //�����ID 23
	$sql .= "    t_staff_count.num,\n";           //��ɼ�Ϳ� 24
	$sql .= "    t_aorder_h.act_id \n";           //�����ID 25
	$sql .= "FROM ";

	$sql .= "    t_aorder_h ";

	$sql .= "    INNER JOIN ( \n";
	$sql .= "        SELECT \n";
	$sql .= "            aord_id,\n";
	$sql .= "            count(aord_id)AS num \n";
	$sql .= "        FROM \n";
	$sql .= "            t_aorder_staff \n";
	$sql .= "        WHERE ";
	$sql .= "            sale_rate IS NOT NULL \n";
	$sql .= "        GROUP BY \n";
	$sql .= "            aord_id \n";
	$sql .= "    )AS t_staff_count ON t_staff_count.aord_id = t_aorder_h.aord_id  \n";

	$sql .= "    LEFT JOIN ";
	$sql .= "        (SELECT ";
	$sql .= "             t_aorder_staff.aord_id,";
	$sql .= "             t_staff.staff_id,";
	$sql .= "             t_staff.staff_name,";
	$sql .= "             t_staff.staff_cd1,";
	$sql .= "             t_staff.staff_cd2,";
	$sql .= "             t_staff.charge_cd,";
	$sql .= "             t_aorder_staff.sale_rate ";
	$sql .= "         FROM ";
	$sql .= "             t_aorder_staff ";
	$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
	$sql .= "         WHERE ";
	$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."'";
	$sql .= "         AND ";
	$sql .= "             t_aorder_staff.sale_rate != '0' ";
	$sql .= "         AND ";
	$sql .= "             t_aorder_staff.sale_rate IS NOT NULL ";
	$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id ";

	$sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id ";

	$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
	$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

	$sql .= "    LEFT JOIN ";
	$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id ";

	$sql .= "WHERE ";

	if($_SESSION["group_kind"] == '2'){
	    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
	}else{
	    $sql .= "    t_aorder_h.shop_id = $client_id  \n";
	}
	$sql .= "    AND ";
	$sql .= "    t_client.state = '1' ";
	$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ps_stat != '4'  \n";
	$sql .= "    AND ";
	$sql .= "    t_attach.h_staff_flg = 'false' ";
	$sql .= "    AND  \n";
	$sql .= "    t_aorder_h.contract_div = '1' \n";
	$sql .= "    AND ";
	$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' ";
	$sql .= "    AND ";
	$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' ";

	//�������Ƚ��
	if($post_part_id != NULL){
		$sql .= "    AND ";
		$sql .= "    t_part.part_id = $post_part_id ";
	}

	$sql .= "UNION ";

	//������
	$sql .= "SELECT ";
	$sql .= "    t_part.part_name,";              //����̾0
	$sql .= "    t_staff$i.staff_name,";          //�����å�̾1
	$sql .= "    sale_h.net_amount,";             //�����2
	$sql .= "    t_aorder_h.ord_time,";           //������3
	$sql .= "    t_aorder_h.route,";              //��ϩ4
	$sql .= "    t_aorder_h.client_cname,";       //������̾5
	$sql .= "    sale_h.sale_id,";                //���ID6
	$sql .= "    t_aorder_h.hand_slip_flg,";      //�����ɼ�ե饰7
	$sql .= "    t_aorder_h.reserve_del_flg,";    //��α��ɼ����ե饰8
	$sql .= "    t_aorder_h.confirm_flg,";        //�����ե饰9
	$sql .= "    t_staff$i.staff_cd1,";           //�����åե�����1 10
	$sql .= "    t_staff$i.staff_cd2,";           //�����åե�����2 11
	$sql .= "    CASE ";           //����ID12
	$sql .= "    WHEN t_part.part_id IS NULL THEN 0 ";
	$sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id ";
	$sql .= "    END,";
	$sql .= "    t_aorder_h.reason, ";            //��α��ͳ13
	$sql .= "    t_aorder_h.confirm_flg,";        //������ɼ14
	$sql .= "    t_client.client_id, ";           //������ID15
	$sql .= "    t_staff$i.charge_cd, ";          //ô���ԥ�����16
	$sql .= "    t_client.client_cd1,";           //�����襳����1 17
	$sql .= "    t_client.client_cd2, ";          //�����襳����2 18
	$sql .= "    t_staff$i.staff_id, ";           //�����å�ID19
	$sql .= "    sale_h.tax_amount,";             //�����ǳ� 20
	$sql .= "    t_staff$i.sale_rate,";           //���Ψ 21
	$sql .= "    t_part.part_cd, ";               //����̾CD 22
	$sql .= "    t_aorder_h.shop_id, \n";         //�����ID 23
	$sql .= "    t_staff_count.num, \n";          //��ɼ�Ϳ� 24
	$sql .= "    t_aorder_h.act_id \n";           //�����ID 25
	   
	$sql .= "FROM ";

	$sql .= "    t_aorder_h ";

	$sql .= "    INNER JOIN ( \n";
	$sql .= "        SELECT \n";
	$sql .= "            aord_id,\n";
	$sql .= "            count(aord_id)AS num \n";
	$sql .= "        FROM \n";
	$sql .= "            t_aorder_staff \n";
	$sql .= "        WHERE ";
	$sql .= "            sale_rate IS NOT NULL \n";
	$sql .= "        GROUP BY \n";
	$sql .= "            aord_id \n";
	$sql .= "    )AS t_staff_count ON t_staff_count.aord_id = t_aorder_h.aord_id  \n";

	$sql .= "    LEFT JOIN ";
	$sql .= "        (SELECT ";
	$sql .= "             t_aorder_staff.aord_id,";
	$sql .= "             t_staff.staff_id,";
	$sql .= "             t_aorder_staff.staff_name,";
	$sql .= "             t_staff.staff_cd1,";
	$sql .= "             t_staff.staff_cd2,";
	$sql .= "             t_staff.charge_cd,";
	$sql .= "             t_aorder_staff.sale_rate ";
	$sql .= "         FROM ";
	$sql .= "             t_aorder_staff ";
	$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
	$sql .= "         WHERE ";
	$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."'";
	$sql .= "         AND ";
	$sql .= "             t_aorder_staff.sale_rate != '0' ";
	$sql .= "         AND ";
	$sql .= "             t_aorder_staff.sale_rate IS NOT NULL ";
	$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id ";

	$sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id ";
	$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
	$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

	$sql .= "    INNER JOIN ";
	$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id ";

	$sql .= "WHERE ";
	if($_SESSION["group_kind"] == '2'){
	    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
	}else{
	    $sql .= "    t_aorder_h.shop_id = $client_id  \n";
	}
	$sql .= "    AND ";
	$sql .= "    t_client.state = '1' ";
	$sql .= "    AND ";
	$sql .= "    t_attach.h_staff_flg = 'false' ";
	$sql .= "    AND  \n";
	$sql .= "    t_aorder_h.contract_div = '1' \n";
	$sql .= "    AND ";
	$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' ";
	$sql .= "    AND ";
	$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' ";
	//�������Ƚ��
	if($post_part_id != NULL){
		$sql .= "    AND ";
		$sql .= "    t_part.part_id = $post_part_id ";
	}

	//FC�ξ��ϡ���ԤΥ��������Ϸ�礷��ɽ��
	if($_SESSION["group_kind"] == '3'){
		$sql .= "UNION  \n";

		//������
		$sql .= "SELECT ";
		$sql .= "    t_part.part_name,";              //����̾0
		$sql .= "    t_staff$i.staff_name,";          //�����å�̾1
		$sql .= "    t_aorder_h.net_amount,";         //�����2
		$sql .= "    t_aorder_h.ord_time,";           //������3
		$sql .= "    t_aorder_h.route,";              //��ϩ4
		$sql .= "    t_client.client_cname,";         //������̾5
		$sql .= "    t_aorder_h.aord_id,";            //����ID6
		$sql .= "    t_aorder_h.hand_slip_flg,";      //�����ɼ�ե饰7
		$sql .= "    t_aorder_h.reserve_del_flg,";    //��α��ɼ����ե饰8
		$sql .= "    t_aorder_h.confirm_flg, ";       //�����ե饰9
		$sql .= "    t_staff$i.staff_cd1,";           //�����åե�����1 10
		$sql .= "    t_staff$i.staff_cd2, ";          //�����åե�����2 11
		$sql .= "    CASE ";                          //����ID12
		$sql .= "    WHEN t_part.part_id IS NULL THEN 0 ";
		$sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id ";
		$sql .= "    END,";
		$sql .= "    t_aorder_h.reason,";             //��α��ͳ13
		$sql .= "    t_aorder_h.confirm_flg,";        //������ɼ14
		$sql .= "    t_client.client_id,";            //������ID15
		$sql .= "    t_staff$i.charge_cd, ";          //ô���ԥ�����16
		$sql .= "    t_client.client_cd1,";           //�����襳����1 17
		$sql .= "    t_client.client_cd2, ";          //�����襳����2 18
		$sql .= "    t_staff$i.staff_id, ";           //�����å�ID19
		$sql .= "    t_aorder_h.tax_amount,";         //�����ǳ� 20
		$sql .= "    t_staff$i.sale_rate,";           //���Ψ 21
		$sql .= "    t_part.part_cd, ";               //����̾CD 22
		$sql .= "    t_aorder_h.shop_id, \n";         //�����ID 23
		$sql .= "    NULL,\n";                        //��ɼ�Ϳ� 24
		$sql .= "    t_aorder_h.act_id \n";           //�����ID 25

		$sql .= "FROM ";

		$sql .= "    t_aorder_h ";

		$sql .= "    LEFT JOIN ";
		$sql .= "        (SELECT ";
		$sql .= "             t_aorder_staff.aord_id,";
		$sql .= "             t_staff.staff_id,";
		$sql .= "             t_staff.staff_name,";
		$sql .= "             t_staff.staff_cd1,";
		$sql .= "             t_staff.staff_cd2,";
		$sql .= "             t_staff.charge_cd,";
		$sql .= "             t_aorder_staff.sale_rate ";
		$sql .= "         FROM ";
		$sql .= "             t_aorder_staff ";
		$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
		$sql .= "         WHERE ";
		$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."'";
		$sql .= "         AND ";
		$sql .= "             t_aorder_staff.sale_rate != '0' ";
		$sql .= "         AND ";
		$sql .= "             t_aorder_staff.sale_rate IS NOT NULL ";
		$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id ";

		$sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

		$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

		$sql .= "    LEFT JOIN ";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id ";

		$sql .= "WHERE ";

	    $sql .= "    t_aorder_h.act_id = $client_id  \n";
		
		$sql .= "    AND ";
		$sql .= "    t_client.state = '1' ";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ps_stat != '4'  \n";
		$sql .= "    AND  \n";
		$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' ";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' ";

		//�������Ƚ��
		if($post_part_id != NULL){
			$sql .= "    AND ";
			$sql .= "    t_part.part_id = $post_part_id ";
		}

		$sql .= "UNION ";

		//������
		$sql .= "SELECT ";
		$sql .= "    t_part.part_name,";              //����̾0
		$sql .= "    t_staff$i.staff_name,";          //�����å�̾1
		$sql .= "    sale_h.net_amount,";             //�����2
		$sql .= "    t_aorder_h.ord_time,";           //������3
		$sql .= "    t_aorder_h.route,";              //��ϩ4
		$sql .= "    t_aorder_h.client_cname,";       //������̾5
		$sql .= "    sale_h.sale_id,";                //���ID6
		$sql .= "    t_aorder_h.hand_slip_flg,";      //�����ɼ�ե饰7
		$sql .= "    t_aorder_h.reserve_del_flg,";    //��α��ɼ����ե饰8
		$sql .= "    t_aorder_h.confirm_flg,";        //�����ե饰9
		$sql .= "    t_staff$i.staff_cd1,";           //�����åե�����1 10
		$sql .= "    t_staff$i.staff_cd2,";           //�����åե�����2 11
		$sql .= "    CASE ";           //����ID12
		$sql .= "    WHEN t_part.part_id IS NULL THEN 0 ";
		$sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id ";
		$sql .= "    END,";
		$sql .= "    t_aorder_h.reason, ";            //��α��ͳ13
		$sql .= "    t_aorder_h.confirm_flg,";        //������ɼ14
		$sql .= "    t_client.client_id, ";           //������ID15
		$sql .= "    t_staff$i.charge_cd, ";          //ô���ԥ�����16
		$sql .= "    t_client.client_cd1,";           //�����襳����1 17
		$sql .= "    t_client.client_cd2, ";          //�����襳����2 18
		$sql .= "    t_staff$i.staff_id, ";           //�����å�ID19
		$sql .= "    sale_h.tax_amount,";             //�����ǳ� 20
		$sql .= "    t_staff$i.sale_rate,";           //���Ψ 21
		$sql .= "    t_part.part_cd, ";               //����̾CD 22
		$sql .= "    t_aorder_h.shop_id, \n";         //�����ID 23
		$sql .= "    NULL, \n";                       //��ɼ�Ϳ� 24
		$sql .= "    t_aorder_h.act_id \n";           //�����ID 25
		   
		$sql .= "FROM ";

		$sql .= "    t_aorder_h ";

		$sql .= "    LEFT JOIN ";
		$sql .= "        (SELECT ";
		$sql .= "             t_aorder_staff.aord_id,";
		$sql .= "             t_staff.staff_id,";
		$sql .= "             t_aorder_staff.staff_name,";
		$sql .= "             t_staff.staff_cd1,";
		$sql .= "             t_staff.staff_cd2,";
		$sql .= "             t_staff.charge_cd,";
		$sql .= "             t_aorder_staff.sale_rate ";
		$sql .= "         FROM ";
		$sql .= "             t_aorder_staff ";
		$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
		$sql .= "         WHERE ";
		$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."'";
		$sql .= "         AND ";
		$sql .= "             t_aorder_staff.sale_rate != '0' ";
		$sql .= "         AND ";
		$sql .= "             t_aorder_staff.sale_rate IS NOT NULL ";
		$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id ";

		$sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

		$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

		$sql .= "    INNER JOIN ";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id ";

		$sql .= "WHERE ";

		$sql .= "    t_aorder_h.act_id = $client_id  \n";

		$sql .= "    AND ";
		$sql .= "    t_client.state = '1' ";
		$sql .= "    AND  \n";
		$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' ";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' ";
		//�������Ƚ��
		if($post_part_id != NULL){
			$sql .= "    AND ";
			$sql .= "    t_part.part_id = $post_part_id ";
		}
	}
}
$sql .= "ORDER BY ";
$sql .= "    part_cd, ";
$sql .= "    charge_cd,";
$sql .= "    ord_time, ";
$sql .= "    route,";
$sql .= "    client_cd1,";
$sql .= "    client_cd2;";

$result = Db_Query($db_con, $sql);
$data_list = Get_Data($result);

/****************************/
//����إå����ˤ�����ô���ԤΥǡ�����ô��������˾�񤭤���
/****************************/
$n_data_list = NULL;
$staff_data_flg = false;  //����ǡ���¸�ߥե饰Ƚ��
for($x=0;$x<count($data_list);$x++){
	$ymd = $data_list[$x][3];          //�����
	$part_id = $data_list[$x][12];     //����ID
	$staff_id = $data_list[$x][19];    //�����å�ID

	//Ϣ���������Ͽ���롣
	$n_data_list[$part_id][$staff_id][$ymd][] = $data_list[$x];

	$data_list2[$part_id][0][0] = $data_list[$x][0];    //����̾
	$data_list2[$part_id][0][1]++;                          //ͽ����

	//ͽ���� (�����+�����ǳ�)�����Ψ
	$money1 = $data_list[$x][2] + $data_list[$x][20];
	$money2 = $data_list[$x][21] / 100;
	//���ΨȽ��
	if($money2 != 0){
		//���Ψ����׻�
		$total1 = bcmul($money1,$money2,2);
	}else{
		//���ե饤����Ԥξ��ϡ����Ψ��̵���پ軻���ʤ�
		$total1 = $money1;
	}
	$data_list2[$part_id][0][2] = bcadd($total1,$data_list2[$part_id][0][2]);

	//����ǡ�����¸�ߤ���
	$staff_data_flg = true;
}

//����ǡ�����¸�ߤ������ˤ���ô���ԥǡ����򥫥���������˾��
if($staff_data_flg == true){

	//���ͷ����ѹ�
	while($money_num = each($data_list2)){
		$money = $money_num[0];
		//ͽ�����ڼΤ�
		$data_list2[$money][0][2] = floor($data_list2[$money][0][2]);
		$data_list2[$money][0][2] = number_format($data_list2[$money][0][2]);
	}
	//��ɸ��ꥻ�åȤ���
	reset($data_list2);

	/****************************/
	//���������ơ��֥��������
	/****************************/

	//��������HTML
	$calendar   = NULL;
	$date_num_y = NULL;
	$date_num_m = NULL;
	$date_num_d = NULL;

	//ABCD����ɽ���ǡ�������
	for($ab=0;$ab<7;$ab++){
		//����������������������
		$next = mktime(0, 0, 0, $month,$day+$ab,$year);
		$nyear     = date("Y",$next); //ǯ
		$nmonth    = date("m",$next); //��
		$nday      = date("d",$next); //��
		$week[$ab] = date("w",$next); //����

		$date_num_y[] = $nyear;       //�콵�֤�ǯ����
		$date_num_m[] = $nmonth;      //�콵�֤η�����
		$date_num_d[] = $nday;        //�콵�֤�������

		//ABCDȽ�̴ؿ�
		//��κǽ��������������������
		$base_date = Basic_date($day_by,$day_bm,$day_bd,$nyear,$nmonth,$nday);
		$row = $base_date[0];
		//��������������դξ��ϡ���������
		if($row == NULL){
			$row = 0;
		}
		$abcd[$ab] = $row;
	}

	//ABCD����ɽ������
	$abcd_w[1] = "A";
	$abcd_w[2] = "B";
	$abcd_w[3] = "C";
	$abcd_w[4] = "D";

	//ABCD���η�������
	$rowspan = array_count_values($abcd);

	/****************************/
	//���������ơ��֥��񤭽���
	/****************************/
	//���𤴤Ȥ˽��ǡ�������
	while($part_num = each($n_data_list)){
		//�����ź������
		$part = $part_num[0];

		//�轵�ܥ���
		//��ɽ��Ƚ��
		if($bw_disabled_flg == true){
			//��ɽ��
			$form->addElement("button","back_w_button[$part]","<<���轵","disabled");
		}else{
			//ɽ��
			$form->addElement("button","back_w_button[$part]","<<���轵","onClick=\"javascript:Button_Submit('back_w_button_flg','#$part','true')\"");
		}

		//�����ܥ���
		//��ɽ��Ƚ��
		if($bd_disabled_flg == true){
			//��ɽ��
			$form->addElement("button","back_d_button[$part]","<<������","disabled");
		}else{
			//ɽ��
			$form->addElement("button","back_d_button[$part]","<<������","onClick=\"javascript:Button_Submit('back_d_button_flg','#$part','true')\"");
		}

		//�⽵�ܥ���
		//��ɽ��Ƚ��
		if($nw_disabled_flg == true){
			//��ɽ��
			$form->addElement("button","next_w_button[$part]","�⽵��>>","disabled");
		}else{
			//ɽ��
			$form->addElement("button","next_w_button[$part]","�⽵��>>","onClick=\"javascript:Button_Submit('next_w_button_flg','#$part','true')\"");
		}

		//�����ܥ���
		//��ɽ��Ƚ��
		if($nd_disabled_flg == true){
			//��ɽ��
			$form->addElement("button","next_d_button[$part]","������>>","disabled");
		}else{
			//ɽ��
			$form->addElement("button","next_d_button[$part]","������>>","onClick=\"javascript:Button_Submit('next_d_button_flg','#$part','true')\"");
		}

		/****************************/
		//���ô����
		/****************************/
		//�����°���륹���åդ���������ɽ��
		if($n_data_list[$part] != NULL){
			//ô���Ԥ��Ȥ˽��ǡ�������
			while($staff_num = each($n_data_list[$part])){
				//ô����ID
				$staff_id = $staff_num[0];

				/****************************/
				//ABCD��HTML
				/****************************/
				$calendar[$part]  = "<tr height=\"40\">";
				$calendar[$part] .=	"  <td align=\"center\" bgcolor=\"#cccccc\" width=\"60\"><b>�����</b></td>";
				//ABCD������
				while($abcd_num = each($rowspan)){
					//ABCD��ź������
					$ab_num = $abcd_num[0];
					$calendar[$part] .= "  <td align=\"center\" bgcolor=\"#e5e5e5\" colspan=\"".$rowspan[$ab_num]."\" style=\"font-size: 130%; font-weight: bold; padding: 0px;\">".$abcd_w[$ab_num]."</td>";
				}
				$calendar[$part] .= "</tr>";
				//��ɸ��ꥻ�åȤ���
				reset($rowspan);

				/****************************/
				//����HTML
				/****************************/
				//��������
				$week_w[0] = "��";
				$week_w[1] = "��";
				$week_w[2] = "��";
				$week_w[3] = "��";
				$week_w[4] = "��";
				$week_w[5] = "��";
				$week_w[6] = "��";

				$calendar[$part]  .= "<tr height=\"20\">";
				$calendar[$part]  .= "	<td align=\"center\" bgcolor=\"#cccccc\" rowspan=\"2\" width=\"80\"><b>���ô����</b></td>";
				//�콵��ʬɽ��
				for($w=0;$w<7;$w++){
					//����Ƚ��
					if($week[$w] == 6 && $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] != 1){
						//���ˤ��ĵ����ǤϤʤ�
						$calendar[$part] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
					}else if($week[$w] == 0 || $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] == 1){
						//����or����
						$calendar[$part] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
					}else{
						//�����
						$calendar[$part] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
					}
					$calendar[$part] .= $week_w[$week[$w]]."</b></td>";
				}
				$calendar[$part] .= "</tr>";

				//ô����̾
				$num1 = each($n_data_list[$part][$staff_id]);
				$num2 = each($n_data_list[$part][$staff_id][$num1[0]]);
				$staff_name = $n_data_list[$part][$staff_id][$num1[0]][$num2[0]][1];
				$calendar2[$part][$staff_id]  = "<tr>";
				$calendar2[$part][$staff_id]  .= "<td width=\"80px\" align=\"center\" valign=\"center\" bgcolor=\"#E5E5E5\" >";
				$calendar2[$part][$staff_id]  .= "<font size=\"2\">$staff_name</font></td>";

				//�콵��ʬɽ��
				for($d=0;$d<7;$d++){
					//����Ƚ��
					if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
						//���ˤ��ĵ����ǤϤʤ�
						$calendar2[$part][$staff_id] .= "	    <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" class=\"cal3\" width=\"13%\">";
					}else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
						//����or����
						$calendar2[$part][$staff_id] .= "	    <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" class=\"cal3\" width=\"13%\">";
					}else{
						//�����
						$calendar2[$part][$staff_id] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" class=\"cal3\" width=\"13%\">";
					}
					//�ǡ���¸��Ƚ��
					$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
					//�������˽��ǡ�����ʣ��¸�ߤ�����硢���η��ʬɽ��
					for($y=0;$y<count($n_data_list[$part][$staff_id][$date]);$y++){
						//�������˽��ǡ�����¸�ߤ��뤫Ƚ��
						if($n_data_list[$part][$staff_id][$date][$y][6] != NULL){

							//�ǡ�����¸�ߤ����١����������󥯤ˤ���
							$link_data[$part][$d] = true;

							//ͽ�����٤��Ϥ�����ID�������
							for($p=0;$p<count($n_data_list[$part][$staff_id][$date]);$p++){
								$aord_id_array[$staff_id][$date][$p] = $n_data_list[$part][$staff_id][$date][$p][6];
							}

							//��ϩ����Ƚ��
							if($n_data_list[$part][$staff_id][$date][$y][4] != NULL){
								//��ϩ�����ѹ�
								$route = str_pad($n_data_list[$part][$staff_id][$date][$y][4], 4, 0, STR_POS_LEFT);
								$route1 = substr($route,0,2);
								$route2 = substr($route,2,2);
								$route = $route1."-".$route2;
							}else{
								//���ե饤����Ԥξ��϶���ɽ��
								$route = "�� ��";
							}

							//��󥯿�Ƚ��
							if($n_data_list[$part][$staff_id][$date][$y][14] == "t"){
								//������ɼ
								//�����衧ͽ��������������
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: gray;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}elseif($n_data_list[$part][$staff_id][$date][$y][25] != NULL){
								//�����ɼ
								//�����衧ͽ��������������
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: green;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}elseif($n_data_list[$part][$staff_id][$date][$y][24] == 1){
								//ͽ����ɼ(���)
								//�����衧ͽ��������������
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: blue;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}elseif($n_data_list[$part][$staff_id][$date][$y][24] == 2){
								//ͽ����ɼ(���)
								//�����衧ͽ��������������
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: Fuchsia;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}elseif($n_data_list[$part][$staff_id][$date][$y][24] == 3 || $n_data_list[$part][$staff_id][$date][$y][23] == 4){
								//ͽ����ɼ(���Ͱʾ�)
								//�����衧ͽ��������������
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: #FF6600;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}
						}
					}
					$calendar2[$part][$staff_id] .= "</font></td>";
				}
				$calendar2[$part][$staff_id] .= "</tr>";
			}

			/****************************/
			//����HTML��񤭽���
			/****************************/
			$calendar3[$part]  = "<tr height=\"20\" style=\"font-size: 130%; font-weight: bold; \">";
			//�콵��ʬɽ��
			for($d=0;$d<7;$d++){
				//����Ƚ��
				if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
					//���ˤ��ĵ����ǤϤʤ�
					$calendar3[$part] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
				}else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
					//����or����
					$calendar3[$part] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
				}else{
					//�����
					$calendar3[$part] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
				}
				//������Ƚ��
				if($week[$d] == 6 || $week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
					//���ե��Ƚ��
					if($link_data[$part][$d] == true){
						
						//�������μ���ID���Ƥ�ͽ�����٤��Ϥ�
						$aord_id_array2 = NULL;
						//��������
						$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
						while($aord_num = each($aord_id_array)){
							//�����å�ID
							$aord_staff_id = $aord_num[0];
							//�ƥ����åդν������դ˥ǡ��������ä����ˡ�����ID������ɲ�
							for($p=0;$p<count($aord_id_array[$aord_staff_id][$date]);$p++){
								$aord_id_array2[] = $aord_id_array[$aord_staff_id][$date][$p];
							}
						}
						//��ɸ��ꥻ�åȤ���
						reset($aord_id_array);

						//���ꥢ�饤����
						$array_id = serialize($aord_id_array2);
						$array_id = urlencode($array_id);

						//�����ʥ�󥯡�
						$calendar3[$part] .= "<a href=\"#\" style=\"color: #555555;\" onClick=\"return Link_Switch('2-2-101i.php?aord_id_array=".$array_id."',450,200)\">".$date_num_d[$d]."</b></td>";
					}else{
						//�����١ʥ�󥯤ʤ���
						$calendar3[$part] .= $date_num_d[$d]."</b></td>";
					}
				}else{
					//���ե��Ƚ��
					if($link_data[$part][$d] == true){
						
						//�������μ���ID���Ƥ�ͽ�����٤��Ϥ�
						$aord_id_array2 = NULL;
						//��������
						$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
						while($aord_num = each($aord_id_array)){
							//�����å�ID
							$aord_staff_id = $aord_num[0];
							//�ƥ����åդν������դ˥ǡ��������ä����ˡ�����ID������ɲ�
							for($p=0;$p<count($aord_id_array[$aord_staff_id][$date]);$p++){
								$aord_id_array2[] = $aord_id_array[$aord_staff_id][$date][$p];
							}
						}
						//��ɸ��ꥻ�åȤ���
						reset($aord_id_array);

						//���ꥢ�饤����
						$array_id = serialize($aord_id_array2);
						$array_id = urlencode($array_id);

						//�����ʥ�󥯡�
						$calendar3[$part] .= "<a href=\"#\" style=\"color: #555555;\" onClick=\"return Link_Switch('2-2-101i.php?aord_id_array=".$array_id."',450,200)\">".$date_num_d[$d]."</b></td>";
					}else{
						//�����ʥ�󥯤ʤ���
						$calendar3[$part] .= $date_num_d[$d]."</b></td>";
					}
				}
			}
			$calendar3[$part] .= "</tr>";
		}
	}
}

//�������ˤ���ԥ���������ɽ��
if($post_part_id == NULL && $_SESSION["group_kind"] != 3){
	/****************************/
	//�Ȳ�ǡ��������ʷ����ʬ����ԡ�
	/****************************/
	for($i=1;$i<=4;$i++){

		//ô���ԡʥᥤ���Ƚ��
		if($i!=1){
			//�ᥤ��ʳ���UNION�Ƿ��
			$sql .= "UNION  \n";
			$sql .= "SELECT  \n";
		}else{
			//�ᥤ��
			$sql  = "SELECT  \n";
		}

		//������
		$sql .= "    t_act.shop_name, \n";               //������̾0
		$sql .= "    t_aorder_h.act_id, \n";             //������ID1
		$sql .= "    t_act.client_cd1, \n";              //�����襳����1 2
		$sql .= "    t_act.client_cd2, \n";              //�����襳����2 3
		$sql .= "    t_aorder_h.net_amount, \n";         //�����4
		$sql .= "    t_aorder_h.ord_time, \n";           //������5
		$sql .= "    t_aorder_h.route, \n";              //��ϩ6
		$sql .= "    t_client.client_cname, \n";         //������̾7
		$sql .= "    t_aorder_h.aord_id, \n";            //����ID8
		$sql .= "    t_client.client_id, \n";            //������ID9
		$sql .= "    t_staff$i.charge_cd,  \n";          //ô���ԥ�����10
		$sql .= "    t_client.client_cd1, \n";           //�����襳����1 11
		$sql .= "    t_client.client_cd2, \n";           //�����襳����2 12
		$sql .= "    t_aorder_h.tax_amount, \n";         //�����ǳ� 13
		$sql .= "    t_staff$i.sale_rate,  \n";          //���Ψ 14
		$sql .= "    t_aorder_h.confirm_flg \n";         //����ե饰 15

		$sql .= "FROM  \n";

		$sql .= "    t_aorder_h  \n";

		$sql .= "    LEFT JOIN  \n";
		$sql .= "        (SELECT  \n";
		$sql .= "             t_aorder_staff.aord_id, \n";
		$sql .= "             t_staff.staff_id, \n";
		$sql .= "             t_staff.staff_name, \n";
		$sql .= "             t_staff.staff_cd1, \n";
		$sql .= "             t_staff.staff_cd2, \n";
		$sql .= "             t_staff.charge_cd, \n";
		$sql .= "             t_aorder_staff.sale_rate  \n";
		$sql .= "         FROM  \n";
		$sql .= "             t_aorder_staff  \n";
		$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id  \n";
		$sql .= "         WHERE  \n";
		$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."' \n";
		$sql .= "         AND  \n";
		$sql .= "             t_aorder_staff.sale_rate != '0'  \n";
		$sql .= "         AND  \n";
		$sql .= "             t_aorder_staff.sale_rate IS NOT NULL  \n";
		$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id  \n";

		$sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";
		$sql .= "    INNER JOIN t_client AS t_act ON t_act.client_id = t_aorder_h.act_id  \n";

		$sql .= "    LEFT JOIN  \n";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

		$sql .= "WHERE  \n";

		if($_SESSION["group_kind"] == '2'){
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
		    $sql .= "    t_aorder_h.act_id = $client_id  \n";
		}
		$sql .= "    AND  \n";
		$sql .= "    t_client.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_act.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ps_stat != '4'  \n";
		$sql .= "    AND  \n";
		$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
		$sql .= "    AND \n";
		$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";

		$sql .= "UNION  \n";

		//������
		$sql .= "SELECT  \n";
		$sql .= "    t_act.shop_name, \n";               //������̾0
		$sql .= "    t_aorder_h.act_id, \n";             //������ID1
		$sql .= "    t_act.client_cd1, \n";              //�����襳����1 2
		$sql .= "    t_act.client_cd2, \n";              //�����襳����2 3
		$sql .= "    sale_h.net_amount, \n";             //�����4
		$sql .= "    t_aorder_h.ord_time, \n";           //������5
		$sql .= "    t_aorder_h.route, \n";              //��ϩ6
		$sql .= "    t_aorder_h.client_cname, \n";       //������̾7
		$sql .= "    sale_h.sale_id, \n";                //���ID8
		$sql .= "    t_client.client_id,  \n";           //������ID9
		$sql .= "    t_staff$i.charge_cd,  \n";          //ô���ԥ�����10
		$sql .= "    t_client.client_cd1, \n";           //�����襳����1 11
		$sql .= "    t_client.client_cd2, \n";           //�����襳����2 12
		$sql .= "    sale_h.tax_amount, \n";             //�����ǳ� 13
		$sql .= "    t_staff$i.sale_rate, \n";           //���Ψ 14
		$sql .= "    t_aorder_h.confirm_flg \n";         //����ե饰 15

		$sql .= "FROM  \n";

		$sql .= "    t_aorder_h  \n";

		$sql .= "    LEFT JOIN  \n";
		$sql .= "        (SELECT  \n";
		$sql .= "             t_aorder_staff.aord_id, \n";
		$sql .= "             t_staff.staff_id, \n";
		$sql .= "             t_aorder_staff.staff_name, \n";
		$sql .= "             t_staff.staff_cd1, \n";
		$sql .= "             t_staff.staff_cd2, \n";
		$sql .= "             t_staff.charge_cd, \n";
		$sql .= "             t_aorder_staff.sale_rate  \n";
		$sql .= "         FROM  \n";
		$sql .= "             t_aorder_staff  \n";
		$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id  \n";
		$sql .= "         WHERE  \n";
		$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."' \n";
		$sql .= "         AND  \n";
		$sql .= "             t_aorder_staff.sale_rate != '0'  \n";
		$sql .= "         AND  \n";
		$sql .= "             t_aorder_staff.sale_rate IS NOT NULL  \n";
		$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id  \n";

		$sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";
		$sql .= "    INNER JOIN t_client AS t_act ON t_act.client_id = t_aorder_h.act_id  \n";

		$sql .= "    INNER JOIN  \n";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

		$sql .= "WHERE  \n";
		if($_SESSION["group_kind"] == '2'){
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
		    $sql .= "    t_aorder_h.act_id = $client_id  \n";
		}
		$sql .= "    AND  \n";
		$sql .= "    t_client.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_act.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
		$sql .= "    AND \n";
		$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";
	}
	$sql .= "ORDER BY  \n";
	$sql .= "    2, \n";
	$sql .= "    3, \n";
	$sql .= "    10, \n";
	$sql .= "    5, \n";
	$sql .= "    6, \n";
	$sql .= "    11, \n";
	$sql .= "    12; \n";

	$result = Db_Query($db_con, $sql);
	$act_data_list = Get_Data($result);

	/****************************/
	//������HTML����
	/****************************/
	$n_data_list = NULL;
	$act_data_flg = false;  //����ǡ���¸�ߥե饰Ƚ��
	for($x=0;$x<count($act_data_list);$x++){
		$ymd = $act_data_list[$x][5];          //�����
		$act_id = "daiko".$act_data_list[$x][1];       //������ID

		//Ϣ���������Ͽ���롣
		$n_data_list[$act_id][$ymd][] = $act_data_list[$x];
		
		$act_data_list2[$act_id][0][0]++;                          //ͽ����

		//ͽ���� (�����+�����ǳ�)�����Ψ
		$money1 = $act_data_list[$x][4] + $act_data_list[$x][13];
		$money2 = $act_data_list[$x][14] / 100;
		//���ΨȽ��
		if($money2 != 0){
			//���Ψ����׻�
			$total1 = bcmul($money1,$money2,2);
		}else{
			//���ե饤����Ԥξ��ϡ����Ψ��̵���پ軻���ʤ�
			$total1 = $money1;
		}
		$act_data_list2[$act_id][0][1] = bcadd($total1,$act_data_list2[$act_id][0][1]);

		//����ǡ�����¸�ߤ���
		$act_data_flg = true;
	}
	//print_array($n_data_list);
	//����ǡ�����¸�ߤ������ˤ���ô���ԥǡ����򥫥���������˾��
	if($act_data_flg == true){

		//���ͷ����ѹ�
		$money_num = NULL;
		$link_data = NULL;

		while($money_num = each($act_data_list2)){
			$money = $money_num[0];
			//ͽ�����ڼΤ�
			$act_data_list2[$money][0][1] = floor($act_data_list2[$money][0][1]);
			$act_data_list2[$money][0][1] = number_format($act_data_list2[$money][0][1]);
		}
		//��ɸ��ꥻ�åȤ���
		reset($act_data_list2);

		/****************************/
		//���������ơ��֥��������
		/****************************/

		//��������HTML
		$date_num_y = NULL;
		$date_num_m = NULL;
		$date_num_d = NULL;

		//ABCD����ɽ���ǡ�������
		for($ab=0;$ab<7;$ab++){
			//����������������������
			$next = mktime(0, 0, 0, $month,$day+$ab,$year);
			$nyear     = date("Y",$next); //ǯ
			$nmonth    = date("m",$next); //��
			$nday      = date("d",$next); //��
			$week[$ab] = date("w",$next); //����

			$date_num_y[] = $nyear;       //�콵�֤�ǯ����
			$date_num_m[] = $nmonth;      //�콵�֤η�����
			$date_num_d[] = $nday;        //�콵�֤�������

			//ABCDȽ�̴ؿ�
			//��κǽ��������������������
			$base_date = Basic_date($day_by,$day_bm,$day_bd,$nyear,$nmonth,$nday);
			$row = $base_date[0];
			//��������������դξ��ϡ���������
			if($row == NULL){
				$row = 0;
			}
			$abcd[$ab] = $row;
		}

		//ABCD����ɽ������
		$abcd_w[1] = "A";
		$abcd_w[2] = "B";
		$abcd_w[3] = "C";
		$abcd_w[4] = "D";

		//ABCD���η�������
		$rowspan = array_count_values($abcd);

		/****************************/
		//���������ơ��֥��񤭽���
		/****************************/
		//�����褴�Ȥ˽��ǡ�������
		while($act_num = each($n_data_list)){
			//�������ź������
			$act = $act_num[0];

			//�轵�ܥ���
			//��ɽ��Ƚ��
			if($bw_disabled_flg == true){
				//��ɽ��
				$form->addElement("button","back_w_button[$act]","<<���轵","disabled");
			}else{
				//ɽ��
				$form->addElement("button","back_w_button[$act]","<<���轵","onClick=\"javascript:Button_Submit('back_w_button_flg','#$act','true')\"");
			}

			//�����ܥ���
			//��ɽ��Ƚ��
			if($bd_disabled_flg == true){
				//��ɽ��
				$form->addElement("button","back_d_button[$act]","<<������","disabled");
			}else{
				//ɽ��
				$form->addElement("button","back_d_button[$act]","<<������","onClick=\"javascript:Button_Submit('back_d_button_flg','#$act','true')\"");
			}

			//�⽵�ܥ���
			//��ɽ��Ƚ��
			if($nw_disabled_flg == true){
				//��ɽ��
				$form->addElement("button","next_w_button[$act]","�⽵��>>","disabled");
			}else{
				//ɽ��
				$form->addElement("button","next_w_button[$act]","�⽵��>>","onClick=\"javascript:Button_Submit('next_w_button_flg','#$act','true')\"");
			}

			//�����ܥ���
			//��ɽ��Ƚ��
			if($nd_disabled_flg == true){
				//��ɽ��
				$form->addElement("button","next_d_button[$act]","������>>","disabled");
			}else{
				//ɽ��
				$form->addElement("button","next_d_button[$act]","������>>","onClick=\"javascript:Button_Submit('next_d_button_flg','#$act','true')\"");
			}

			/****************************/
			//ABCD��HTML
			/****************************/
			$act_calendar[$act]  = "<tr height=\"40\">";
			$act_calendar[$act] .=	"  <td align=\"center\" bgcolor=\"#cccccc\" width=\"60\"><b>�����</b></td>";
			//ABCD������
			while($abcd_num = each($rowspan)){
				//ABCD��ź������
				$ab_num = $abcd_num[0];
				$act_calendar[$act] .= "  <td align=\"center\" bgcolor=\"#e5e5e5\" colspan=\"".$rowspan[$ab_num]."\" style=\"font-size: 130%; font-weight: bold; padding: 0px;\">".$abcd_w[$ab_num]."</td>";
			}
			$act_calendar[$act] .= "</tr>";
			//��ɸ��ꥻ�åȤ���
			reset($rowspan);

			/****************************/
			//����HTML
			/****************************/
			$act_calendar[$act]  .= "<tr height=\"20\">";
			$act_calendar[$act]  .= "	<td align=\"center\" bgcolor=\"#cccccc\" rowspan=\"2\" width=\"80\"><b>���ô����</b></td>";
			//�콵��ʬɽ��
			for($w=0;$w<7;$w++){
				//����Ƚ��
				if($week[$w] == 6 && $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] != 1){
					//���ˤ��ĵ����ǤϤʤ�
					$act_calendar[$act] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
				}else if($week[$w] == 0 || $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] == 1){
					//����or����
					$act_calendar[$act] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
				}else{
					//�����
					$act_calendar[$act] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
				}
				$act_calendar[$act] .= $week_w[$week[$w]]."</b></td>";
			}
			$act_calendar[$act] .= "</tr>";

			//������̾
			$num1 = each($n_data_list[$act]);
			$num2 = each($n_data_list[$act][$num1[0]]);
			$act_name = $n_data_list[$act][$num1[0]][$num2[0]][0];
			$act_calendar2[$act]  = "<tr>";
			$act_calendar2[$act]  .= "<td width=\"80px\" align=\"center\" valign=\"center\" bgcolor=\"#E5E5E5\" >";
			$act_calendar2[$act]  .= "<font size=\"2\">$act_name</font></td>";

			//�콵��ʬɽ��
			for($d=0;$d<7;$d++){
				//����Ƚ��
				if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
					//���ˤ��ĵ����ǤϤʤ�
					$act_calendar2[$act] .= "	    <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" class=\"cal3\" width=\"13%\">";
				}else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
					//����or����
					$act_calendar2[$act] .= "	    <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" class=\"cal3\" width=\"13%\">";
				}else{
					//�����
					$act_calendar2[$act] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" class=\"cal3\" width=\"13%\">";
				}
				//�ǡ���¸��Ƚ��
				$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];

				//�������˽��ǡ�����ʣ��¸�ߤ�����硢���η��ʬɽ��
				for($y=0;$y<count($n_data_list[$act][$date]);$y++){

					//�������˽��ǡ�����¸�ߤ��뤫Ƚ��
					if($n_data_list[$act][$date][$y][8] != NULL){

						//�ǡ�����¸�ߤ����١����������󥯤ˤ���
						$link_data[$act][$d] = true;

						//ͽ�����٤��Ϥ�����ID�������
						for($p=0;$p<count($n_data_list[$act][$date]);$p++){
							$aord_id_array[$act][$date][$p] = $n_data_list[$act][$date][$p][6];
						}

						//��ϩ����Ƚ��
						if($n_data_list[$act][$date][$y][6] != NULL){
							//��ϩ�����ѹ�
							$route = str_pad($n_data_list[$act][$date][$y][6], 4, 0, STR_POS_LEFT);
							$route1 = substr($route,0,2);
							$route2 = substr($route,2,2);
							$route = $route1."-".$route2;
						}else{
							//���ե饤����Ԥξ��϶���ɽ��
							$route = "�� ��";
						}

						//��󥯿�Ƚ��
						if($n_data_list[$act][$date][$y][15] == "t"){
							//������ɼ
							//�����衧ͽ��������������
							$act_calendar2[$act] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
							$act_calendar2[$act] .= "450,200,".$n_data_list[$act][$date][$y][9].",".$n_data_list[$act][$date][$y][8].")\" style=\"color: gray;\">";
							$act_calendar2[$act] .= $n_data_list[$act][$date][$y][7]."</a><br>";
						}elseif($n_data_list[$act][$date][$y][1] != NULL){
							//�����ɼ
							//�����衧ͽ��������������
							$act_calendar2[$act] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
							$act_calendar2[$act] .= "450,200,".$n_data_list[$act][$date][$y][9].",".$n_data_list[$act][$date][$y][8].")\" style=\"color: green;\">";
							$act_calendar2[$act] .= $n_data_list[$act][$date][$y][7]."</a><br>";
						}
					}
				}
				$act_calendar2[$act] .= "</font></td>";
			}
			$act_calendar2[$act] .= "</tr>";
		}

		/****************************/
		//����HTML��񤭽���
		/****************************/
		$act_calendar3[$act]  = "<tr height=\"20\" style=\"font-size: 130%; font-weight: bold; \">";
		//�콵��ʬɽ��
		for($d=0;$d<7;$d++){
			//����Ƚ��
			if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
				//���ˤ��ĵ����ǤϤʤ�
				$act_calendar3[$act] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
			}else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
				//����or����
				$act_calendar3[$act] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
			}else{
				//�����
				$act_calendar3[$act] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
			}
			//������Ƚ��
			if($week[$d] == 6 || $week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
				//���ե��Ƚ��
				if($link_data[$act][$d] == true){
					
					//�������μ���ID���Ƥ�ͽ�����٤��Ϥ�
					$aord_id_array2 = NULL;
					//��������
					$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
					while($aord_num = each($aord_id_array)){
						//������ID
						$aord_act_id = $aord_num[0];
						//������ν������դ˥ǡ��������ä����ˡ�����ID������ɲ�
						for($p=0;$p<count($aord_id_array[$aord_act_id][$date]);$p++){
							$aord_id_array2[] = $aord_id_array[$aord_act_id][$date][$p];
						}
					}
					//��ɸ��ꥻ�åȤ���
					reset($aord_id_array);

					//���ꥢ�饤����
					$array_id = serialize($aord_id_array2);
					$array_id = urlencode($array_id);

					//�����١ʥ�󥯡�
					$act_calendar3[$act] .= "<a href=\"2-2-106.php?aord_id_array=".$array_id."\" style=\"color: #555555;\">";
					$act_calendar3[$act] .= $date_num_d[$d]."</b></td>";
				}else{
					//�����١ʥ�󥯤ʤ���
					$act_calendar3[$act] .= $date_num_d[$d]."</b></td>";
				}
			}else{
				//���ե��Ƚ��
				if($link_data[$act][$d] == true){
					
					//�������μ���ID���Ƥ�ͽ�����٤��Ϥ�
					$aord_id_array2 = NULL;
					//��������
					$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
					while($aord_num = each($aord_id_array)){
						//������ID
						$aord_act_id = $aord_num[0];
						//������ν������դ˥ǡ��������ä����ˡ�����ID������ɲ�
						for($p=0;$p<count($aord_id_array[$aord_act_id][$date]);$p++){
							$aord_id_array2[] = $aord_id_array[$aord_act_id][$date][$p];
						}
					}
					//��ɸ��ꥻ�åȤ���
					reset($aord_id_array);

					//���ꥢ�饤����
					$array_id = serialize($aord_id_array2);
					$array_id = urlencode($array_id);

					//�����ʥ�󥯡�
					$act_calendar3[$act] .= "<a href=\"2-2-106.php?aord_id_array=".$array_id."\" style=\"color: #555555;\">".$date_num_d[$d]."</b></td>";
				}else{
					//�����ʥ�󥯤ʤ���
					$act_calendar3[$act] .= $date_num_d[$d]."</b></td>";
				}
			}
		}
		$act_calendar3[$act] .= "</tr>";
	}
}

//�ǡ�����̵�����ϡ���������ʤ��Υܥ������
if($staff_data_flg == false){

	//�轵�ܥ���
	//��ɽ��Ƚ��
	if($bw_disabled_flg == true){
		//��ɽ��
		$form->addElement("button","back_w_button","<<���轵","disabled");
	}else{
		//ɽ��
		$form->addElement("button","back_w_button","<<���轵","onClick=\"javascript:Button_Submit('back_w_button_flg','#','true')\"");
	}

	//�����ܥ���
	//��ɽ��Ƚ��
	if($bd_disabled_flg == true){
		//��ɽ��
		$form->addElement("button","back_d_button","<<������","disabled");
	}else{
		//ɽ��
		$form->addElement("button","back_d_button","<<������","onClick=\"javascript:Button_Submit('back_d_button_flg','#','true')\"");
	}

	//�⽵�ܥ���
	//��ɽ��Ƚ��
	if($nw_disabled_flg == true){
		//��ɽ��
		$form->addElement("button","next_w_button","�⽵��>>","disabled");
	}else{
		//ɽ��
		$form->addElement("button","next_w_button","�⽵��>>","onClick=\"javascript:Button_Submit('next_w_button_flg','#','true')\"");
	}

	//�����ܥ���
	//��ɽ��Ƚ��
	if($nd_disabled_flg == true){
		//��ɽ��
		$form->addElement("button","next_d_button","������>>","disabled");
	}else{
		//ɽ��
		$form->addElement("button","next_d_button","������>>","onClick=\"javascript:Button_Submit('next_d_button_flg','#','true')\"");
	}
	
	$data_msg = "���ǡ���������ޤ���";
}

/*
print "<pre>";
print_r ($keys_list);
print "</pre>";
*/

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_f('sale','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[form_single_month_change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[form_master_change_button]]->toHtml();
//$page_title .= "��".$form->_elements[$form->_elementIndex[form_patrol_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);


//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'     => "$html_header",
	'page_menu'       => "$page_menu",
	'page_header'     => "$page_header",
	'html_footer'     => "$html_footer",
	'year'            => "$year",
	'month'           => "$month",
	'staff_data_flg'  => "$staff_data_flg",
	'charge_data_flg' => "$charge_data_flg",
	'cal_range'       => "$cal_range",
	'data_msg'        => "$data_msg",
));

//ɽ���ǡ���
$smarty->assign("disp_data", $data_list2);
$smarty->assign("calendar", $calendar);
$smarty->assign("calendar2", $calendar2);
$smarty->assign("calendar3", $calendar3);

$smarty->assign("act_disp_data", $act_data_list2);
$smarty->assign("act_calendar", $act_calendar);
$smarty->assign("act_calendar2", $act_calendar2);
$smarty->assign("act_calendar3", $act_calendar3);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>

