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

//�������
$sql  = "SELECT stand_day FROM t_stand;";
$result = Db_Query($db_con, $sql); 
$stand_day = pg_fetch_result($result,0,0);   
$day_by = substr($stand_day,0,4);
$day_bm = substr($stand_day,5,2);
$day_bd = substr($stand_day,8,2);

//��������η����������
$stand_num = date("t",mktime(0, 0, 0,$day_bm,1,$day_by));
$monday_array = NULL;   //����������
//��������η�Ρ������������դ����
for($s=1;$s<=$stand_num;$s++){
	$monday = date('w', mktime(0, 0, 0,$day_bm,$s,$day_by));
	//���ˤ�Ƚ��
	if($monday == 1){
		$monday_array[] = date('d', mktime(0, 0, 0,$day_bm,$s,$day_by));
	}
}
//��������ν������
for($s=0;$s<count($monday_array);$s++){
	if($day_bd == $monday_array[$s]){
		$stand_day_week = $s+1;
	}
}

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
//���ɽ��
/****************************/
$def_fdata = array(
    "form_output"     => "1",

);
$form->setDefaults($def_fdata);

/****************************/
//POST�������
/****************************/
$post_part_id = $_POST["form_part_1"];    //����
$post_staff_id = $_POST["form_staff_1"];  //ô����

/****************************/
//�ե��������
/****************************/
//���Ϸ���
$radio1[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "Ģɼ","2");
$form->addGroup($radio1, "form_output", "���Ϸ���");

//����
$select_value = NULL;
$select_value = Select_Get($db_con,'part');
$form->addElement('select', 'form_part_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ô����
$select_value = NULL;
$select_value = Select_Get($db_con,'cstaff');
$form->addElement('select', 'form_staff_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ɽ���ܥ���
$button[] = $form->createElement("submit","indicate_button","ɽ����","onClick=\"javascript:Which_Type('form_output','".FC_DIR."sale/2-2-103.php','#')\"");

//���ꥢ�ܥ���
$button[] = $form->createElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addGroup($button, "form_button", "�ܥ���");

//ñ���ѹ�
$form->addElement("button","form_single_month_change_button","�ȡ���","onClick=\"javascript:Referer('2-2-101-2.php')\"");
//�ޥ����ѹ�
$form->addElement("button","form_master_change_button","�ѡ���","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//��ɼ����
$form->addElement("button","form_slip_button","��ɼ����","onClick=\"javascript:Referer('2-2-201.php')\"");
//������ɽ���ܥ���
$form->addElement("button","form_course","������ɽ��");

$form->addElement("hidden", "back_button_flg");     //����ܥ��󲡲�Ƚ��
$form->addElement("hidden", "next_button_flg");     //���ܥ��󲡲�Ƚ��
$form->addElement("hidden", "next_count");          //����鲿�����
$form->addElement("hidden", "back_count");          //����鲿������

/****************************/
//������������
/****************************/
//��������ɽ�����ּ���
$sql  = "SELECT ";
$sql .= "    cal_peri ";    //��������ɽ������
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_id = $client_id;";
$result = Db_Query($db_con, $sql);
$num = pg_num_rows($result);
//�ܥ���δ֤�ɽ������٤����Υ�������ɽ�����֤��ϰ�
if($num == 1){
	//����ܥ�������ɽ������ʬɽ��
	$num_range = pg_fetch_result($result, 0,0);
	//��ɽ������
	$num_range++;
}else{
	//����ܰ����
	$num_range = 1;
}

//ô���Ի���Ƚ��
if($post_staff_id != NULL){
	//ô���Ԥ���ꤷ����硢�ǡ����򥫥�����ɽ������ʬɽ��

	//¸��Ƚ��
	if($num == 1){
		//����ܥ�������ɽ������ʬɽ��
		$cal_peri = $num_range;
	}else{
		//����ܰ����
		$cal_peri = 1;
	}
}else{
	//����ʤ��ξ��ϡ������ʬ�ǡ���ɽ��
	//�����ʬɽ��
	$cal_peri = 1;
}

/****************************/
//���եǡ�������
/****************************/
//����η����
$str = mktime(0, 0, 0, date("n")-1,1,date("Y"));
$b_year  = date("Y",$str);
$b_month = date("m",$str);

//��������ɽ�����֤κǸ�η����
$str = mktime(0, 0, 0, date("n")+$num_range,1,date("Y"));
$c_year  = date("Y",$str);
$c_month = date("m",$str);

//ô���Ԥ����ꤵ��Ƥ�����ϡ��롼�פο������䤹
if($post_staff_id != NULL){
	$cal_peri++;
}

//��������ɽ������
$cal_range = $b_year."ǯ ".$b_month."�� �� ".$c_year."ǯ ".$c_month."��";

//��������HTML
$calendar = NULL;
$cal_data_flg = false;  //���Ƥ�ô���Ԥμ���ǡ���¸�ߥե饰Ƚ��

//��������ɽ������ʬ����������ɽ��HTML����
for($y=0;$y<$cal_peri;$y++){

	/****************************/
	//ɽ���������եǡ�������
	/****************************/

	//ɽ����������
	$str = mktime(0, 0, 0, date("n")+$y,1,date("Y"));
	$year[$y]  = date("Y",$str);
	$month[$y] = date("m",$str);

	//�����������
	$day = date("t",mktime(0, 0, 0, $month[$y],1,$year[$y]));
	//��κǽ����������
	$first_day = date('w', mktime(0, 0, 0, date("n")+$y, 1, date("Y")));
	//��κǸ����������
	$last_day = date('w', mktime(0, 0, 0, date("n")+$y, $day, date("Y")));

	/****************************/
	//����ܥ��󲡲�����
	/****************************/
	if($_POST["back_button_flg"] == true){
		//POSTȽ��
		if($_POST["back_count"] == NULL){
			//̵��
			$back_count = 1;
		}else{
			//ͭ��
			//����ˡ����ʬ����
	    	$back_count = $_POST["back_count"]+1;
		}

		//POSTȽ��
		if($_POST["next_count"] == NULL){
			//̵����
			$next_count = 0;
		}else{
			//ͭ��
			//����ˡ����ʬ­��
	    	$next_count = $_POST["next_count"];
		}

	    //���ܥ���ե饰�򥯥ꥢ
	    $next_data["back_button_flg"] = "";
		$back_data["back_count"]      = $back_count;
	    $form->setConstants($back_data);

		//����η����
		$str = mktime(0, 0, 0, $month[$y]-$back_count,1,$year[$y]);
		$year[$y]  = date("Y",$str);
		$month[$y] = date("n",$str);

		//­����ʬ�η���θ����
		$str = mktime(0, 0, 0, $month[$y]+$next_count,1,$year[$y]);
		$year[$y]  = date("Y",$str);
		$month[$y] = date("m",$str);

		//����ϡ�����鸫�ư���������������ʤ��褦��Ƚ�ꤹ��
		$l_day = date("Y-m-d", mktime(0, 0, 0, date("n")-1,1,date("Y")));
		if($year[$y]."-".$month[$y]."-01" == $l_day){
			//����ܥ������ɽ���ˤ���
			$b_disabled_flg = true;
		}

		//����ܥ���ե饰�򥯥ꥢ
	    $back_data["back_button_flg"] = "";
	    $form->setConstants($back_data);

		//�����������
		$day = date("t",mktime(0, 0, 0, $month[$y],1,$year[$y]));
		//��κǽ����������
		$first_day = date('w', mktime(0, 0, 0, date("n")-$back_count+$next_count, 1, date("Y")));
		//��κǸ����������
		$last_day = date('w', mktime(0, 0, 0, date("n")-$back_count+$next_count, $day, date("Y")));
	}

	/****************************/
	//���ܥ��󲡲�����
	/****************************/
	if($_POST["next_button_flg"] == true){

		//POSTȽ��
		if($_POST["next_count"] == NULL){
			//̵����
			$next_count = 1;
		}else{
			//ͭ��
			//����ˡ����ʬ­��
	    	$next_count = $_POST["next_count"]+1;
		}

		//POSTȽ��
		if($_POST["back_count"] == NULL){
			//̵��
			$back_count = 0;
		}else{
			//ͭ��
			//����ˡ����ʬ����
	    	$back_count = $_POST["back_count"];
		}

	    //���ܥ���ե饰�򥯥ꥢ
	    $next_data["next_button_flg"] = "";
		$next_data["next_count"]      = $next_count;
	    $form->setConstants($next_data);

		//����η����
		$str = mktime(0, 0, 0, $month[$y]+$next_count,1,$year[$y]);
		$year[$y]  = date("Y",$str);
		$month[$y] = date("n",$str);
		//������ʬ�η���θ����
		$str = mktime(0, 0, 0, $month[$y]-$back_count,1,$year[$y]);
		$year[$y]  = date("Y",$str);
		$month[$y] = date("m",$str);

		//��������ɽ������ʬ����ɽ�������ʤ���Ƚ��
		$f_day = date("Y-m-d", mktime(0, 0, 0, date("n")+$num_range,1,date("Y")));
		if($year[$y]."-".$month[$y]."-01" == $f_day){
			//���ܥ������ɽ���ˤ���
			$n_disabled_flg = true;
		}

		//�����������
		$day = date("t",mktime(0, 0, 0, $month[$y],1,$year[$y]));
		//��κǽ����������
		$first_day = date('w', mktime(0, 0, 0, date("n")+$next_count-$back_count, 1, date("Y")));
		//��κǸ����������
		$last_day = date('w', mktime(0, 0, 0, date("n")+$next_count-$back_count, $day, date("Y")));
	}

	//����Ƚ��
	if($first_day == 0){
		//����
		$first_day = 6;
	}else{
		//�ʳ�
		$first_day = $first_day-1;
	}
	//����Ƚ��
	if($last_day == 0){
		//����
		$last_day = 6;
	}else{
		//�ʳ�
		$last_day = $last_day-1;
	}

	//��ν��ο�������
	$last_week_days = ($day + $first_day) % 7;
	if ($last_week_days == 0){
		$weeks = ($day + $first_day) / 7;
	}else{
		$weeks = ceil(($day + $first_day) / 7);
	}

	/****************************/
	//�Ȳ�ǡ��������ʷ����ʬ���̾��
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
		$sql .= "    t_part.part_name, \n";              //����̾0
		$sql .= "    t_staff$i.staff_name, \n";          //�����å�̾1
		$sql .= "    t_aorder_h.net_amount, \n";         //�����2
		$sql .= "    t_aorder_h.ord_time, \n";           //������3
		$sql .= "    t_aorder_h.route, \n";              //��ϩ4
		$sql .= "    t_client.client_cname, \n";         //������̾5
		$sql .= "    t_aorder_h.aord_id, \n";            //����ID6
		$sql .= "    t_aorder_h.hand_slip_flg, \n";      //�����ɼ�ե饰7
		$sql .= "    t_aorder_h.reserve_del_flg, \n";    //��α��ɼ����ե饰8
		$sql .= "    t_aorder_h.confirm_flg,  \n";       //�����ե饰9
		$sql .= "    t_staff$i.staff_cd1, \n";           //�����åե�����1 10
		$sql .= "    t_staff$i.staff_cd2,  \n";          //�����åե�����2 11
		$sql .= "    t_staff$i.staff_id,  \n";           //�����å�ID12
		$sql .= "    t_aorder_h.reason, \n";             //��α��ͳ13
		$sql .= "    t_aorder_h.confirm_flg, \n";        //������ɼ14
		$sql .= "    t_client.client_id, \n";            //������ID15
		$sql .= "    t_staff$i.charge_cd,  \n";          //ô���ԥ�����16
		$sql .= "    t_client.client_cd1, \n";           //�����襳����1 17
		$sql .= "    t_client.client_cd2, \n";           //�����襳����2 18
		$sql .= "    t_aorder_h.tax_amount, \n";         //�����ǳ� 19
		$sql .= "    t_staff$i.sale_rate,  \n";          //���Ψ 20
		$sql .= "    t_part.part_cd, \n";                //����̾CD 21
		$sql .= "    t_aorder_h.shop_id, \n";            //�����ID 22
		$sql .= "    t_staff_count.num,\n";              //��ɼ�Ϳ� 23
		$sql .= "    t_aorder_h.act_id, \n";             //�����ID 24
		$sql .= "    t_aorder_h.trust_confirm_flg \n";   //������ɼ(������) 25

		$sql .= "FROM  \n";

		$sql .= "    t_aorder_h  \n";

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

		$sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id  \n";

		$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id  \n";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";

		$sql .= "    LEFT JOIN  \n";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

		$sql .= "WHERE  \n";

		if($_SESSION["group_kind"] == '2'){
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
		    $sql .= "    t_aorder_h.shop_id = $client_id  \n";
		}
		$sql .= "    AND  \n";
		$sql .= "    t_client.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ps_stat != '4'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.contract_div = '1' \n";
		$sql .= "    AND  \n";
		$sql .= "    t_attach.h_staff_flg = 'false'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";

		//�������Ƚ��
		if($post_part_id != NULL){
			$sql .= "    AND  \n";
			$sql .= "    t_part.part_id = $post_part_id  \n";
		}
		//ô���Ի���Ƚ��
		if($post_staff_id != NULL){
			$sql .= "    AND  \n";
			$sql .= "    t_staff$i.staff_id = $post_staff_id  \n";
		}

		$sql .= "UNION  \n";

		//������
		$sql .= "SELECT  \n";
		$sql .= "    t_part.part_name, \n";              //����̾0
		$sql .= "    t_staff$i.staff_name, \n";          //�����å�̾1
		$sql .= "    sale_h.net_amount, \n";             //�����2
		$sql .= "    t_aorder_h.ord_time, \n";           //������3
		$sql .= "    t_aorder_h.route, \n";              //��ϩ4
		$sql .= "    t_aorder_h.client_cname, \n";       //������̾5
		$sql .= "    sale_h.sale_id, \n";                //���ID6
		$sql .= "    t_aorder_h.hand_slip_flg, \n";      //�����ɼ�ե饰7
		$sql .= "    t_aorder_h.reserve_del_flg, \n";    //��α��ɼ����ե饰8
		$sql .= "    t_aorder_h.confirm_flg, \n";        //�����ե饰9
		$sql .= "    t_staff$i.staff_cd1, \n";           //�����åե�����1 10
		$sql .= "    t_staff$i.staff_cd2, \n";           //�����åե�����2 11
		$sql .= "    t_staff$i.staff_id,  \n";           //�����å�ID12
		$sql .= "    t_aorder_h.reason,  \n";            //��α��ͳ13
		$sql .= "    t_aorder_h.confirm_flg, \n";        //������ɼ14
		$sql .= "    t_client.client_id,  \n";           //������ID15
		$sql .= "    t_staff$i.charge_cd,  \n";          //ô���ԥ�����16
		$sql .= "    t_client.client_cd1, \n";           //�����襳����1 17
		$sql .= "    t_client.client_cd2, \n";           //�����襳����2 18
		$sql .= "    sale_h.tax_amount, \n";             //�����ǳ� 19
		$sql .= "    t_staff$i.sale_rate, \n";           //���Ψ 20
		$sql .= "    t_part.part_cd, \n";                //����̾CD 21
		$sql .= "    t_aorder_h.shop_id, \n";            //�����ID 22
		$sql .= "    t_staff_count.num, \n";             //��ɼ�Ϳ� 23
		$sql .= "    t_aorder_h.act_id, \n";             //�����ID 24
		$sql .= "    t_aorder_h.trust_confirm_flg \n";   //������ɼ(������) 25
		   
		$sql .= "FROM  \n";

		$sql .= "    t_aorder_h  \n";

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

		$sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id  \n";

		$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id  \n";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";

		$sql .= "    INNER JOIN  \n";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

		$sql .= "WHERE  \n";
		if($_SESSION["group_kind"] == '2'){
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
		    $sql .= "    t_aorder_h.shop_id = $client_id  \n";
		}
		$sql .= "    AND  \n";
		$sql .= "    t_client.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_attach.h_staff_flg = 'false'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.contract_div = '1' \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";
		//�������Ƚ��
		if($post_part_id != NULL){
			$sql .= "    AND  \n";
			$sql .= "    t_part.part_id = $post_part_id  \n";
		}
		//ô���Ի���Ƚ��
		if($post_staff_id != NULL){
			$sql .= "    AND  \n";
			$sql .= "    t_staff$i.staff_id = $post_staff_id  \n";
		}

		//FC�ξ��ϡ���ԤΥ��������Ϸ�礷��ɽ��
		if($_SESSION["group_kind"] == '3'){
			$sql .= "UNION  \n";

			//������
			$sql .= "SELECT  \n";
			$sql .= "    t_part.part_name, \n";              //����̾0
			$sql .= "    t_staff$i.staff_name, \n";          //�����å�̾1
			$sql .= "    t_aorder_h.net_amount, \n";         //�����2
			$sql .= "    t_aorder_h.ord_time, \n";           //������3
			$sql .= "    t_aorder_h.route, \n";              //��ϩ4
			$sql .= "    t_client.client_cname, \n";         //������̾5
			$sql .= "    t_aorder_h.aord_id, \n";            //����ID6
			$sql .= "    t_aorder_h.hand_slip_flg, \n";      //�����ɼ�ե饰7
			$sql .= "    t_aorder_h.reserve_del_flg, \n";    //��α��ɼ����ե饰8
			$sql .= "    t_aorder_h.confirm_flg,  \n";       //�����ե饰9
			$sql .= "    t_staff$i.staff_cd1, \n";           //�����åե�����1 10
			$sql .= "    t_staff$i.staff_cd2,  \n";          //�����åե�����2 11
			$sql .= "    t_staff$i.staff_id,  \n";           //�����å�ID12
			$sql .= "    t_aorder_h.reason, \n";             //��α��ͳ13
			$sql .= "    t_aorder_h.confirm_flg, \n";        //������ɼ14
			$sql .= "    t_client.client_id, \n";            //������ID15
			$sql .= "    t_staff$i.charge_cd,  \n";          //ô���ԥ�����16
			$sql .= "    t_client.client_cd1, \n";           //�����襳����1 17
			$sql .= "    t_client.client_cd2, \n";           //�����襳����2 18
			$sql .= "    t_aorder_h.tax_amount, \n";         //�����ǳ� 19
			$sql .= "    t_staff$i.sale_rate,  \n";          //���Ψ 20
			$sql .= "    t_part.part_cd, \n";                //����̾CD 21
			$sql .= "    t_aorder_h.shop_id, \n";            //�����ID 22
			$sql .= "    NULL,\n";                           //��ɼ�Ϳ� 23
			$sql .= "    t_aorder_h.act_id, \n";             //�����ID 24
			$sql .= "    t_aorder_h.trust_confirm_flg \n";   //������ɼ(������) 25

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

			$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id  \n";
			$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";

			$sql .= "    LEFT JOIN  \n";
			$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

			$sql .= "WHERE  \n";

			$sql .= "    t_aorder_h.act_id = $client_id  \n";
			
			$sql .= "    AND  \n";
			$sql .= "    t_client.state = '1'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ps_stat != '4'  \n";
			$sql .= "    AND  \n";
			$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";

			//�������Ƚ��
			if($post_part_id != NULL){
				$sql .= "    AND  \n";
				$sql .= "    t_part.part_id = $post_part_id  \n";
			}
			//ô���Ի���Ƚ��
			if($post_staff_id != NULL){
				$sql .= "    AND  \n";
				$sql .= "    t_staff$i.staff_id = $post_staff_id  \n";
			}

			$sql .= "UNION  \n";

			//������
			$sql .= "SELECT  \n";
			$sql .= "    t_part.part_name, \n";              //����̾0
			$sql .= "    t_staff$i.staff_name, \n";          //�����å�̾1
			$sql .= "    sale_h.net_amount, \n";             //�����2
			$sql .= "    t_aorder_h.ord_time, \n";           //������3
			$sql .= "    t_aorder_h.route, \n";              //��ϩ4
			$sql .= "    t_aorder_h.client_cname, \n";       //������̾5
			$sql .= "    sale_h.sale_id, \n";                //���ID6
			$sql .= "    t_aorder_h.hand_slip_flg, \n";      //�����ɼ�ե饰7
			$sql .= "    t_aorder_h.reserve_del_flg, \n";    //��α��ɼ����ե饰8
			$sql .= "    t_aorder_h.confirm_flg, \n";        //�����ե饰9
			$sql .= "    t_staff$i.staff_cd1, \n";           //�����åե�����1 10
			$sql .= "    t_staff$i.staff_cd2, \n";           //�����åե�����2 11
			$sql .= "    t_staff$i.staff_id,  \n";           //�����å�ID12
			$sql .= "    t_aorder_h.reason,  \n";            //��α��ͳ13
			$sql .= "    t_aorder_h.confirm_flg, \n";        //������ɼ14
			$sql .= "    t_client.client_id,  \n";           //������ID15
			$sql .= "    t_staff$i.charge_cd,  \n";          //ô���ԥ�����16
			$sql .= "    t_client.client_cd1, \n";           //�����襳����1 17
			$sql .= "    t_client.client_cd2, \n";           //�����襳����2 18
			$sql .= "    sale_h.tax_amount, \n";             //�����ǳ� 19
			$sql .= "    t_staff$i.sale_rate, \n";           //���Ψ 20
			$sql .= "    t_part.part_cd, \n";                //����̾CD 21
			$sql .= "    t_aorder_h.shop_id, \n";            //�����ID 22
			$sql .= "    NULL, \n";                          //��ɼ�Ϳ� 23
			$sql .= "    t_aorder_h.act_id, \n";             //�����ID 24
			$sql .= "    t_aorder_h.trust_confirm_flg \n";   //������ɼ(������) 25
	  
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

			$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id  \n";
			$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";

			$sql .= "    INNER JOIN  \n";
			$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

			$sql .= "WHERE  \n";
	
		    $sql .= "    t_aorder_h.act_id = $client_id  \n";

			$sql .= "    AND  \n";
			$sql .= "    t_client.state = '1'  \n";
			$sql .= "    AND  \n";
			$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";
			//�������Ƚ��
			if($post_part_id != NULL){
				$sql .= "    AND  \n";
				$sql .= "    t_part.part_id = $post_part_id  \n";
			}
			//ô���Ի���Ƚ��
			if($post_staff_id != NULL){
				$sql .= "    AND  \n";
				$sql .= "    t_staff$i.staff_id = $post_staff_id  \n";
			}
		}
	}
	$sql .= "ORDER BY  \n";
	$sql .= "    part_cd, \n";
	$sql .= "    charge_cd, \n";
	$sql .= "    ord_time, \n";
	$sql .= "    route, \n";
	$sql .= "    client_cd1, \n";
	$sql .= "    client_cd2; \n";

	$result = Db_Query($db_con, $sql);
	$data_list = Get_Data($result);

	/****************************/
	//���ô����HTML����
	/****************************/
	$n_data_list = NULL;
	$staff_data_flg = false;  //����ǡ���¸�ߥե饰Ƚ��

	for($x=0;$x<count($data_list);$x++){
		$ymd = $data_list[$x][3];          //�����
		$staff_id = $data_list[$x][12];    //�����å�ID

		//Ϣ���������Ͽ���롣
		$n_data_list[$staff_id][$ymd][] = $data_list[$x];
	
		$data_list2[$staff_id][$y][0][0] = $data_list[$x][0];    //����̾
		$data_list2[$staff_id][$y][0][1] = $data_list[$x][1];    //�����å�̾
		$data_list2[$staff_id][$y][0][2]++;                          //ͽ����

		//ͽ���� (�����+�����ǳ�)�����Ψ
		$money1 = $data_list[$x][2] + $data_list[$x][19];
		$money2 = $data_list[$x][20] / 100;
		//���ΨȽ��
		if($money2 != 0){
			//���Ψ����׻�
			$total1 = bcmul($money1,$money2,2);
		}else{
			//���ե饤����Ԥξ��ϡ����Ψ��̵���پ軻���ʤ�
			$total1 = $money1;
		}
		$data_list2[$staff_id][$y][0][3] = bcadd($total1,$data_list2[$staff_id][$y][0][3]);

		//����ǡ�����¸�ߤ���
		$staff_data_flg = true;
		//���ʾ����ǡ�����¸�ߤ���
		$cal_data_flg = true;
	}

	//����ǡ�����¸�ߤ������ˤ���ô���ԥǡ����򥫥������������
	if($staff_data_flg == true){
		/****************************/
		//���������ơ��֥����
		/****************************/

		//���ͷ����ѹ�
		while($money_num = each($data_list2)){
			$money = $money_num[0];
			//ͽ�����ڼΤ�
			$data_list2[$money][$y][0][3] = floor($data_list2[$money][$y][0][3]);
			$data_list2[$money][$y][0][3] = number_format($data_list2[$money][$y][0][3]);
		}
		//��ɸ��ꥻ�åȤ���
		reset($data_list2);

		//ABCD����ɽ������
		$abcd[1] = "A";
		$abcd[2] = "B";
		$abcd[3] = "C";
		$abcd[4] = "D";

		//ABCD�����ź��
		//������ηȽ��
		if("$day_by-$day_bm-$day_bd 00:00" > "$year[$y]-$month[$y]-01 00:00"){
			//���������Ϥޤ��A���ˤ���
			$base_date[0] = 1;
		}else{
			//��κǽ��������������������
			$base_date = Basic_date($day_by,$day_bm,$day_bd,$year[$y],$month[$y],1);
		}
		$row = $base_date[0];

		$day_num = 0;   //����������ɽ����������
		$day_num2 = 0;  //�ǡ�����ɽ��������٤˻��Ѥ�����

		//ô���Ԥ��Ȥ˽��ǡ�������
		while($staff_num = each($n_data_list)){
			//ô���Ԥ�ź������
			$staff = $staff_num[0];

			//����ܥ���
			//��ɽ��Ƚ��
			if($b_disabled_flg == true){
				//��ɽ��
				$form->addElement("button","back_button[$staff]","<<������","disabled");
			}else{
				//ɽ��
				$form->addElement("button","back_button[$staff]","<<������","onClick=\"javascript:Button_Submit('back_button_flg','#$staff','true')\"");
			}

			//���ܥ���
			//��ɽ��Ƚ��
			if($n_disabled_flg == true){
				//��ɽ��
				$form->addElement("button","next_button[$staff]","��>>","disabled");
			}else{
				//ɽ��
				$form->addElement("button","next_button[$staff]","��>>","onClick=\"javascript:Button_Submit('next_button_flg','#$staff','true')\"");
			}

			//��Υ�����������
			for($c=1;$c<=$weeks;$c++){
				//���˥����������󤬺�������Ƥ��뤫Ƚ��
				if($c==1 && $calendar[$staff][$y] != NULL){
					//���ˤ��ä�����������񤭤���
					$calendar[$staff][$y] = "<tr class=\"cal_flame\">";
				}else{
					//����ܤ���ϡ�����ˤ�����礹��
					$calendar[$staff][$y] .= "<tr class=\"cal_flame\">";
				}

				$calendar[$staff][$y] .= "	    <td align=\"center\" valign=\"center\" bgcolor=\"#e5e5e5\" rowspan=\"2\">";
				//��������η�ξ��ϡ�������ν�����ABCD����ɽ����������η�ʳ��ϡ��̾��̤�ɽ��
				if($stand_day_week <= $c || $stand_day < "$year[$y]-$month[$y]-01"){
					$calendar[$staff][$y] .= $abcd[$row];
				}
				$calendar[$staff][$y] .= "      </td>";
				$j=0;
				//����ξ��������
				while($j<7){
					//����Ƚ���Ԥʤ���Ƚ��
					if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
						//��ޤ��ϤޤäƤ��ʤ��١�����Ƚ���Ԥ�ʤ�
						$cal_flg = true;
					}else{
						//����Ϥ��줿�١�����Ƚ���Ԥʤ�
						$cal_flg = false;

						//����Ƚ��˻��Ѥ��륻������ռ���
						$cal_num = $day_num + 1;
						$cal_today = str_pad($cal_num, 2, 0, STR_POS_LEFT);
						$cal_date = "$year[$y]-$month[$y]-$cal_today"; 
					}

					//����Ƚ��
					if($j == 5 && ($holiday[$cal_date] != 1)){
						//���ˤ��ĵ����ǤϤʤ�
						$calendar[$staff][$y] .= "	    <td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\" bgcolor=\"#99FFFF\">";
					}else if($j == 6 || ($holiday[$cal_date] == 1 && $cal_flg != true)){
						//����or����
						$calendar[$staff][$y] .= "	    <td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\" bgcolor=\"#FFDDE7\">";
					}else{
						//�����
						$calendar[$staff][$y] .= "<td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\">";
					}

					if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
						$calendar[$staff][$y] .= "</td>";
					}else{
						$day_num++;
						//�ǡ�����¸�ߤ�����ϡ����ˤ����󥯤ˤ���
						if($n_data_list[$staff][$cal_date][0][6] != NULL){
							//�ǡ�����¸�ߤ���
							
							$aord_id_array = NULL;     //����ID����
							//�������μ���ID���Ƥ����������Ϥ�
							for($p=0;$p<count($n_data_list[$staff][$cal_date]);$p++){
								$aord_id_array[$p] = $n_data_list[$staff][$cal_date][$p][6];
							}

							//���ꥢ�饤����
							$array_id = serialize($aord_id_array);
							$array_id = urlencode($array_id);
							
							//����ID������Ϥ�������̤
							$calendar[$staff][$y] .= "<a href=\"#\" style=\"color: #555555;\" onClick=\"return Link_Switch('2-2-101i.php',";
							$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$cal_date][0][22].",1)\">$day_num</a></td>";
						}else{
							//�ǡ�����¸�ߤ��ʤ�
							$calendar[$staff][$y] .= "$day_num</td>";
						}
					}
					$j++;
				}
				$calendar[$staff][$y] .= "</tr>";

				//���������˳�ô���ԤΥǡ�����ɽ��
				$calendar[$staff][$y] .= "<tr>";
				$j=0;
				//����β���������
				while($j<7){

					//����Ƚ���Ԥʤ���Ƚ��
					if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
						//��ޤ��ϤޤäƤ��ʤ��١�����Ƚ���Ԥ�ʤ�
						$cal_flg2 = true;
					}else{
						//����Ϥ��줿�١�����Ƚ���Ԥʤ�
						$cal_flg2 = false;

						//����Ƚ��˻��Ѥ��륻������ռ���
						$cal_num = $day_num2 + 1;
						$cal_today = str_pad($cal_num, 2, 0, STR_POS_LEFT);
						$cal_date = "$year[$y]-$month[$y]-$cal_today"; 
					}

					//����Ƚ��
					if($j == 5 && ($holiday[$cal_date] != 1)){
						//���ˤ��ĵ����ǤϤʤ�
						$calendar[$staff][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" height=\"33\" >";
					}else if($j == 6 || ($holiday[$cal_date] == 1 && $cal_flg2 != true)){
						//����or����
						$calendar[$staff][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" height=\"33\" >";
					}else{
						//�����
						$calendar[$staff][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" height=\"33\">";
					}
						
					//��κǽ����������������Ϥޤ뤫Ƚ��
					if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
						//�Ϥޤ���������
						$calendar[$staff][$y] .= "</td>";
					}else{
						//�Ϥޤ������������
			
						$day_num2++;
						$today = str_pad($day_num2, 2, 0, STR_POS_LEFT);
						$date = "$year[$y]-$month[$y]-$today";  //�ƥ����ɽ����������
						//�������˽��ǡ�����ʣ��¸�ߤ�����硢���η��ʬɽ��
						for($p=0;$p<count($n_data_list[$staff][$date]);$p++){
							//�������˽��ǡ�����¸�ߤ��뤫Ƚ��
							if($n_data_list[$staff][$date][$p][6] != NULL){

								//��ϩ����Ƚ��
								if($n_data_list[$staff][$date][$p][4] != NULL){
									//��ϩ�����ѹ�
									$route = str_pad($n_data_list[$staff][$date][$p][4], 4, 0, STR_POS_LEFT);
									$route1 = substr($route,0,2);
									$route2 = substr($route,2,2);
									$route = $route1."-".$route2;
								}else{
									//���ե饤����Ԥξ��϶���ɽ��
									$route = "�� ��";
								}

								//��󥯿�Ƚ��
								if($n_data_list[$staff][$date][$p][14] == "t" || $n_data_list[$staff][$date][$p][25] == "t"){
									//������ɼ
									//�����衧ͽ��������������
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: gray;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}elseif($n_data_list[$staff][$date][$p][24] != NULL){
									//�����ɼ
									//�����衧ͽ��������������
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: green;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}elseif($n_data_list[$staff][$date][$p][23] == 1){
									//ͽ����ɼ(���)
									//�����衧ͽ��������������
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: blue;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}elseif($n_data_list[$staff][$date][$p][23] == 2){
									//ͽ����ɼ(���)
									//�����衧ͽ��������������
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: Fuchsia;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}elseif($n_data_list[$staff][$date][$p][23] == 3 || $n_data_list[$staff][$date][$p][23] == 4){
									//ͽ����ɼ(���Ͱʾ�)
									//�����衧ͽ��������������
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: #FF6600;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}
							}
						}
						$calendar[$staff][$y] .= "</td>";
					}
					$j++;
				}
				$calendar[$staff][$y] .= "</tr>";
				//��������η�ξ��ϡ�������ν�����ABCD����ɽ����������η�ʳ��ϡ��̾��̤�ɽ��
				if($stand_day_week <= $c || $stand_day < "$year[$y]-$month[$y]-01"){
					$row++;
					//D���ˤʤä��顢�ޤ�A�����ͤ��ɤ�
					if($row == 5){
						$row = 1;
					}
				}
			}
			//ABCD�����ź��
			//������ηȽ��
			if("$day_by-$day_bm-$day_bd 00:00" > "$year[$y]-$month[$y]-01 00:00"){
				//���������Ϥޤ��A���ˤ���
				$base_date[0] = 1;
			}else{
				//��κǽ��������������������
				$base_date = Basic_date($day_by,$day_bm,$day_bd,$year[$y],$month[$y],1);
			}
			$row = $base_date[0];

			$day_num = 0;
			$day_num2 = 0;
		}
		//��ɸ��ꥻ�åȤ���
		reset($n_data_list);
		//��Υ��������ǡ���������
		$cal_msg[$staff][$y] = NULL;
	}else{
		//�ǡ����ʤ���Ϸٹ�ɽ��
		$calendar[$staff][$y] .= "<br>";
		$cal_msg[$staff][$y] = "���ǡ���������ޤ���";
	}

	//�������ˤ���ԥ���������ɽ��
	if($post_part_id == NULL && $post_staff_id == NULL && $_SESSION["group_kind"] != 3){
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
			$sql .= "    t_aorder_h.confirm_flg, \n";        //����ե饰 15
			$sql .= "    t_aorder_h.trust_confirm_flg \n";   //����ե饰(������) 16

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
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";

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
			$sql .= "    t_staff$i.sale_rate,  \n";          //���Ψ 14
			$sql .= "    t_aorder_h.confirm_flg, \n";        //����ե饰 15
			$sql .= "    t_aorder_h.trust_confirm_flg \n";   //����ե饰(������) 16
			   
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
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";
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
		
			$act_data_list2[$act_id][$y][0][0] = $act_data_list[$x][0];    //������̾
			$act_data_list2[$act_id][$y][0][1]++;                          //ͽ����

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
			$act_data_list2[$act_id][$y][0][2] = bcadd($total1,$act_data_list2[$act_id][$y][0][2]);

			//����ǡ�����¸�ߤ���
			$act_data_flg = true;
			//���ʾ����ǡ�����¸�ߤ���
			$cal_data_flg = true;
		}

		//����ǡ�����¸�ߤ������ˤ��μ����ǡ����򥫥������������
		if($act_data_flg == true){
			/****************************/
			//���������ơ��֥����
			/****************************/

			//���ͷ����ѹ�
			$money_num = NULL;
			while($money_num = each($act_data_list2)){
				$money = $money_num[0];
				//ͽ�����ڼΤ�
				$act_data_list2[$money][$y][0][2] = floor($act_data_list2[$money][$y][0][2]);
				$act_data_list2[$money][$y][0][2] = number_format($act_data_list2[$money][$y][0][2]);
			}
			//��ɸ��ꥻ�åȤ���
			reset($act_data_list2);

			//ABCD�����ź��
			//������ηȽ��
			$base_date = NULL;
			$row = NULL;
			if("$day_by-$day_bm-$day_bd 00:00" > "$year[$y]-$month[$y]-01 00:00"){
				//���������Ϥޤ��A���ˤ���
				$base_date[0] = 1;
			}else{
				//��κǽ��������������������
				$base_date = Basic_date($day_by,$day_bm,$day_bd,$year[$y],$month[$y],1);
			}
			$row = $base_date[0];

			$day_num = 0;   //����������ɽ����������
			$day_num2 = 0;  //�ǡ�����ɽ��������٤˻��Ѥ�����

			//�����褴�Ȥ˽��ǡ�������
			$act_num = NULL;
			while($act_num = each($n_data_list)){
				//�������ź������
				$act = $act_num[0];

				//����ܥ���
				//��ɽ��Ƚ��
				if($b_disabled_flg == true){
					//��ɽ��
					$form->addElement("button","back_button[$act]","<<������","disabled");
				}else{
					//ɽ��
					$form->addElement("button","back_button[$act]","<<������","onClick=\"javascript:Button_Submit('back_button_flg','#$act','true')\"");
				}

				//���ܥ���
				//��ɽ��Ƚ��
				if($n_disabled_flg == true){
					//��ɽ��
					$form->addElement("button","next_button[$act]","��>>","disabled");
				}else{
					//ɽ��
					$form->addElement("button","next_button[$act]","��>>","onClick=\"javascript:Button_Submit('next_button_flg','#$act','true')\"");
				}

				//��Υ�����������
				for($c=1;$c<=$weeks;$c++){
					//���˥����������󤬺�������Ƥ��뤫Ƚ��
					if($c==1 && $act_calendar[$act][$y] != NULL){
						//���ˤ��ä�����������񤭤���
						$act_calendar[$act][$y] = "<tr class=\"cal_flame\">";
					}else{
						//����ܤ���ϡ�����ˤ�����礹��
						$act_calendar[$act][$y] .= "<tr class=\"cal_flame\">";
					}

					$act_calendar[$act][$y] .= "	    <td align=\"center\" valign=\"center\" bgcolor=\"#e5e5e5\" rowspan=\"2\">";
					//��������η�ξ��ϡ�������ν�����ABCD����ɽ����������η�ʳ��ϡ��̾��̤�ɽ��
					if($stand_day_week <= $c || $stand_day < "$year[$y]-$month[$y]-01"){
						$act_calendar[$act][$y] .= $abcd[$row];
					}
					$act_calendar[$act][$y] .= "      </td>";
					$j=0;
					//����ξ��������
					while($j<7){
						//����Ƚ���Ԥʤ���Ƚ��
						if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
							//��ޤ��ϤޤäƤ��ʤ��١�����Ƚ���Ԥ�ʤ�
							$cal_flg = true;
						}else{
							//����Ϥ��줿�١�����Ƚ���Ԥʤ�
							$cal_flg = false;

							//����Ƚ��˻��Ѥ��륻������ռ���
							$cal_num = $day_num + 1;
							$cal_today = str_pad($cal_num, 2, 0, STR_POS_LEFT);
							$cal_date = "$year[$y]-$month[$y]-$cal_today"; 
						}

						//����Ƚ��
						if($j == 5 && ($holiday[$cal_date] != 1)){
							//���ˤ��ĵ����ǤϤʤ�
							$act_calendar[$act][$y] .= "	    <td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\" bgcolor=\"#99FFFF\">";
						}else if($j == 6 || ($holiday[$cal_date] == 1 && $cal_flg != true)){
							//����or����
							$act_calendar[$act][$y] .= "	    <td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\" bgcolor=\"#FFDDE7\">";
						}else{
							//�����
							$act_calendar[$act][$y] .= "<td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\">";
						}

						if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
							$act_calendar[$act][$y] .= "</td>";
						}else{
							$day_num++;
							//�ǡ�����¸�ߤ�����ϡ����ˤ����󥯤ˤ���
							if($n_data_list[$act][$cal_date][0][8] != NULL){
								//�ǡ�����¸�ߤ���
								
								$aord_id_array = NULL;     //����ID����
								//�������μ���ID���Ƥ����������Ϥ�
								for($p=0;$p<count($n_data_list[$act][$cal_date]);$p++){
									$aord_id_array[$p] = $n_data_list[$act][$cal_date][$p][8];
								}

								//���ꥢ�饤����
								$array_id = serialize($aord_id_array);
								$array_id = urlencode($array_id);
								
								//����ID������Ϥ�������̤
								$act_calendar[$act][$y] .= "<a href=\"#\" style=\"color: #555555;\" onClick=\"return Link_Switch('2-2-101i.php',";
								$act_calendar[$act][$y] .= "450,200,".$n_data_list[$act][$cal_date][0][1].",1)\">$day_num</a></td>";
							}else{
								//�ǡ�����¸�ߤ��ʤ�
								$act_calendar[$act][$y] .= "$day_num</td>";
							}
						}
						$j++;
					}
					$act_calendar[$act][$y] .= "</tr>";

					//���������˳�ô���ԤΥǡ�����ɽ��
					$act_calendar[$act][$y] .= "<tr>";
					$j=0;
					//����β���������
					while($j<7){

						//����Ƚ���Ԥʤ���Ƚ��
						if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
							//��ޤ��ϤޤäƤ��ʤ��١�����Ƚ���Ԥ�ʤ�
							$cal_flg2 = true;
						}else{
							//����Ϥ��줿�١�����Ƚ���Ԥʤ�
							$cal_flg2 = false;

							//����Ƚ��˻��Ѥ��륻������ռ���
							$cal_num = $day_num2 + 1;
							$cal_today = str_pad($cal_num, 2, 0, STR_POS_LEFT);
							$cal_date = "$year[$y]-$month[$y]-$cal_today"; 
						}

						//����Ƚ��
						if($j == 5 && ($holiday[$cal_date] != 1)){
							//���ˤ��ĵ����ǤϤʤ�
							$act_calendar[$act][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" height=\"33\" >";
						}else if($j == 6 || ($holiday[$cal_date] == 1 && $cal_flg2 != true)){
							//����or����
							$act_calendar[$act][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" height=\"33\" >";
						}else{
							//�����
							$act_calendar[$act][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" height=\"33\">";
						}
							
						//��κǽ����������������Ϥޤ뤫Ƚ��
						if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
							//�Ϥޤ���������
							$act_calendar[$act][$y] .= "</td>";
						}else{
							//�Ϥޤ������������
				
							$day_num2++;
							$today = str_pad($day_num2, 2, 0, STR_POS_LEFT);
							$date = "$year[$y]-$month[$y]-$today";  //�ƥ����ɽ����������
							//�������˽��ǡ�����ʣ��¸�ߤ�����硢���η��ʬɽ��
							for($p=0;$p<count($n_data_list[$act][$date]);$p++){
								//�������˽��ǡ�����¸�ߤ��뤫Ƚ��
								if($n_data_list[$act][$date][$p][8] != NULL){

									//��ϩ����Ƚ��
									if($n_data_list[$act][$date][$p][6] != NULL){
										//��ϩ�����ѹ�
										$route = str_pad($n_data_list[$act][$date][$p][6], 4, 0, STR_POS_LEFT);
										$route1 = substr($route,0,2);
										$route2 = substr($route,2,2);
										$route = $route1."-".$route2;
									}else{
										//���ե饤����Ԥξ��϶���ɽ��
										$route = "�� ��";
									}

									//��󥯿�Ƚ��
									if($n_data_list[$act][$date][$p][15] == "t" || $n_data_list[$act][$date][$p][25] == "t"){
										//������ɼ
										//�����衧ͽ��������������
										$act_calendar[$act][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
										$act_calendar[$act][$y] .= "450,200,".$n_data_list[$act][$date][$p][9].",".$n_data_list[$act][$date][$p][8].")\"";
										$act_calendar[$act][$y] .= "style=\"color: gray;\">";
										$act_calendar[$act][$y] .= $n_data_list[$act][$date][$p][7]."</a><br>";
									}elseif($n_data_list[$act][$date][$p][1] != NULL){
										//�����ɼ
										//�����衧ͽ��������������
										$act_calendar[$act][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
										$act_calendar[$act][$y] .= "450,200,".$n_data_list[$act][$date][$p][9].",".$n_data_list[$act][$date][$p][8].")\"";
										$act_calendar[$act][$y] .= "style=\"color: green;\">";
										$act_calendar[$act][$y] .= $n_data_list[$act][$date][$p][7]."</a><br>";
									}
								}
							}
							$act_calendar[$act][$y] .= "</td>";
						}
						$j++;
					}
					$act_calendar[$act][$y] .= "</tr>";
					//��������η�ξ��ϡ�������ν�����ABCD����ɽ����������η�ʳ��ϡ��̾��̤�ɽ��
					if($stand_day_week <= $c || $stand_day < "$year[$y]-$month[$y]-01"){
						$row++;
						//D���ˤʤä��顢�ޤ�A�����ͤ��ɤ�
						if($row == 5){
							$row = 1;
						}
					}
				}
				//ABCD�����ź��
				//������ηȽ��
				if("$day_by-$day_bm-$day_bd 00:00" > "$year[$y]-$month[$y]-01 00:00"){
					//���������Ϥޤ��A���ˤ���
					$base_date[0] = 1;
				}else{
					//��κǽ��������������������
					$base_date = Basic_date($day_by,$day_bm,$day_bd,$year[$y],$month[$y],1);
				}
				$row = $base_date[0];

				$day_num = 0;
				$day_num2 = 0;
			}
			//��ɸ��ꥻ�åȤ���
			reset($n_data_list);
			//��Υ��������ǡ���������
			$act_cal_msg[$act][$y] = NULL;
		}else{
			//�ǡ����ʤ���Ϸٹ�ɽ��
			$act_calendar[$act][$y] .= "<br>";
			$act_cal_msg[$act][$y] = "���ǡ���������ޤ���";
		}
	}
}

//�ǡ�����̵�����ϡ���������ʤ��Υܥ������
if($cal_data_flg == false){

	//����ܥ���
	//��ɽ��Ƚ��
	if($b_disabled_flg == true){
		//��ɽ��
		$form->addElement("button","back_button","<<������","disabled");
	}else{
		//ɽ��
		$form->addElement("button","back_button","<<������","onClick=\"javascript:Button_Submit('back_button_flg','#','true')\"");
	}

	//���ܥ���
	//��ɽ��Ƚ��
	if($n_disabled_flg == true){
		//��ɽ��
		$form->addElement("button","next_button","��>>","disabled");
	}else{
		//ɽ��
		$form->addElement("button","next_button","��>>","onClick=\"javascript:Button_Submit('next_button_flg','#','true')\"");
	}
	
	$data_msg = "���ǡ���������ޤ���";
}

/*
print "<pre>";
print_r ($data_list2);
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
	'cal_data_flg'    => "$cal_data_flg",
	'cal_range'       => "$cal_range",
	'data_msg'        => "$data_msg",
));

//ɽ���ǡ���
$smarty->assign("disp_data", $data_list2);
$smarty->assign("calendar", $calendar);
$smarty->assign("act_disp_data", $act_data_list2);
$smarty->assign("act_calendar", $act_calendar);
$smarty->assign("cal_msg", $cal_msg);
$smarty->assign("act_cal_msg", $act_cal_msg);
$smarty->assign("year", $year);
$smarty->assign("month", $month);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
