<?php

/******************************
 *  �ѹ�����
 *      ��2006-10-26 ���Ψ������ν��ô���Ԥ�ɽ��<suzuki>
 *      ��2007-02-22 ���׵�ǽ�κ��<watanabe��k>
 *      ��2007-03-29 �ѹ������ɽ������褦�˽���<morita-d>
 *      ��2007-04-13 ���ܥ�������������<fukuda>
 *      ��2007-04-23 �������ɽ�����ѹ�<morita-d>
 *      ��2007-05-26 ����ۤ��������0��ɽ������Ƥ��ޤ��Զ�����<morita-d>
 *      ��2007-06-06 �ѹ�����Υ����å�̾�����˥������󥰤���Ƥ��ʤ��Զ�����<morita-d>
 *      ��2007-06-19 ������˴ؤ���������ɲ�<morita-d>
 *      ��2009-09-24 �Ͱ����ʤ��ֻ���ɽ��<aoyama-n>
 *      ��2011-02-11 ������������ID���ϤäƤ��������������ʤ������褬ɽ�������Х��ν���<watanabe-k>
 *
******************************/

$page_title = "����ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$client_id    = $_GET["client_id"];      //������
$get_flg      = $_GET["get_flg"];        //���ܸ�Ƚ��ե饰
$back_display = $_GET["back_display"];   //ͽ�����٤����ܸ�
$array_id     = $_GET["aord_id_array"];  //�����������Ƥμ���ID
$aord_id      = $_GET["aord_id"];        //����ID
$shop_id      = $_SESSION["client_id"];  //������ID


//����Ƚ��
Get_ID_Check3($client_id);
Get_ID_Check3($aord_id);


/****************************/
//�ե��������
/****************************/
//������
$form_client[] =& $form->createElement(
	        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
	        );

$form_client[] =& $form->createElement(
	        "static","","","-"
	        );
$form_client[] =& $form->createElement(
	        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onChange=\"javascript:Button_Submit('client_search_flg','#','true')\"".$g_form_option."\""
	        );
$form_client[] =& $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly"
);
$form->addGroup( $form_client, "form_client", "");

//��������
$form->addElement("link","form_client_link","","./2-1-115.php","������̾","
    onClick=\"return Open_Contract('../dialog/2-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]', 'client_search_flg'),500,450,5,1);\""
);

//�ѹ�������
$form->addElement("button","change_button","�ѹ�������",$g_button_color."onClick=\"location.href='2-1-111.php'\"");
//�������(�إå���)
//$form->addElement("button","all_button","�������","onClick=\"location.href='2-1-114.php'\"");
//��Ͽ(�إå���)
$form->addElement("button","new_button","�С�Ͽ","onClick=\"location.href='2-1-104.php?flg=add'\"");

//���ܥ���������Ƚ��
/*
switch($get_flg){
	case 'cal':
		//ͽ������
		$form->addElement("button","form_back","�ᡡ��","onClick=\"location.href='".FC_DIR."sale/2-2-106.php&search=1?aord_id[0]=$aord_id&aord_id_array=$array_id&back_display=$back_display'\"");
		break;
	case 'reason':
		//ͽ��ǡ�������
		$form->addElement("button","form_back","�ᡡ��","onClick=\"location.href='".FC_DIR."sale/2-2-107.php?aord_id=$aord_id&back_display=$back_display&aord_id_array=$array_id'\"");
		break;
	case 'con':
		//�������
		$form->addElement("button","form_back","�ᡡ��","onClick=\"location.href='".FC_DIR."system/2-1-111.php'\"");
		break;
	Default:
		//���������
		$form->addElement("button","form_back","�ᡡ��","onClick=\"location.href='".FC_DIR."system/2-1-101.php?search=1'\"");
}
*/
/*
// ���ܥ���ʸ�����Ԥä��ڡ��������ܤ����
$referer = $_SESSION["referer"]["f"]["sale"];

if ($referer == "2-1-237" || $referer == "2-1-238"){
    $form->addElement("button", "form_back", "�ᡡ��", "onClick=\"Submit_Page('./".$_SESSION["referer"]["f"]["sale"].".php')\"");

}elseif ($referer == "2-1-111"){
    $form->addElement("button", "form_back", "�ᡡ��", "onClick=\"location.href='2-1-111.php'\"");

}elseif ($referer == "2-1-104"){
    $form->addElement("button", "form_back", "�ᡡ��", "onClick=\"location.href='2-1-104.php?flg=add'\"");

}else{
    $form->addElement("button", "form_back", "�ᡡ��", 
//        "onClick=\"Submit_Page('".Make_Rtn_Page("contract")."')\"");
        "onClick=\"location.href='".Make_Rtn_Page("contract")."'\"");
}
*/


/****************************/
// ���ܥ����󥯡�4/13������
/****************************/
// ����������ѿ���
$referer = $_SESSION["f"]["contract"]["return_page"]["page"];

// �������褬����ޥ�������Ͽ���̡ˡܤξ��
if ($referer == "../system/2-1-104.php"){
    $get_flg = "add";
}

switch ($get_flg){
	case "con" :
		// �������
		$form->addElement("button", "form_back", "�ᡡ��", "onClick=\"location.href='".FC_DIR."system/2-1-111.php?search=1'\"");
		break;
    case "add" :
		// ����ޥ�������Ͽ���̡�
		$form->addElement("button", "form_back", "�ᡡ��", "onClick=\"location.href='".FC_DIR."system/2-1-104.php?flg=add'\"");
		break;
    default :
        // ����¾
        $form->addElement("button", "form_back", "�ᡡ��", "onClick=\"location.href='".Make_Rtn_Page("contract")."'\"");
}




$form->addElement("hidden", "client_search_flg");   //�����踡���ե饰

$form->addElement("hidden", "check_value_flg");     //������Ͽ�����å��ܥå�������Ƚ��ե饰
$client_data["check_value_flg"]   = "t";

/****************************/
//�����襳�������Ͻ���
/****************************/
$client_d_flg = false;   //�ǡ���¸��Ƚ��ե饰
$client_cd1         = $_POST["form_client"]["cd1"];       //�����襳����1
$client_cd2         = $_POST["form_client"]["cd2"];       //�����襳����2

//������������orPOST�˥����ɤ�������
if($_POST["client_search_flg"] == true || ($client_cd1 != NULL && $client_cd2 != NULL)){

    //������ξ�������
    $sql  = "SELECT";
    $sql .= "   client_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
	$sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '1' ";

	//�����������Ϥϡ�������������Τ�ɽ��
	if($_POST["client_search_flg"] == true){
		$sql .= "AND ";
		$sql .= "    state = '1' ";
	}

	$sql .= "   AND";
	if($_SESSION["group_kind"] == '2'){
	    $sql .= "    t_client.shop_id IN (".Rank_Sql().")";
	}else{
	    $sql .= "     t_client.shop_id = $shop_id";
	}
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
	//�����ǡ���������
	if($num == 1){
		//�ǡ�������
		$client_id      = pg_fetch_result($result, 0,0);        //������ID

	}else{
		//�ǡ����ʤ�
		$client_d_flg = true;
		//������Ͽ�ΰ١��ɲåܥ����GET����ʤ�
		$client_id = "";
	}
}

/****************************/
//�ե����������GET����������褬�����ˤ�ä��ѹ���
/****************************/
//�ɲåܥ���
$form->addElement("button","form_insert","�ɡ���","onClick=\"javascript:return Submit_Page2('".FC_DIR."system/2-1-104.php?flg=add&client_id=$client_id&return_flg=true&get_flg=$get_flg');\""
);

//�ǡ�����¸�ߤ���or�ѹ����˼¹�
if($client_id != NULL && $_POST["client_search_flg"] != "get"){
	/****************************/
	//����������������
	/****************************/
	//������ξ�������
	$sql  = "SELECT";
	$sql .= "   t_client.client_cname,";
	$sql .= "   t_trade.trade_name,";
	//$sql .= "   t_client.intro_ac_price,";
	//$sql .= "   t_client.intro_ac_rate, ";
	$sql .= "   t_client.state, ";
	$sql .= "   t_client.client_cd1, ";
	$sql .= "   t_client.client_cd2 ";
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= "   INNER JOIN t_trade ON t_client.trade_id = t_trade.trade_id ";
	$sql .= " WHERE";
	$sql .= "   t_client.client_id = $client_id";
	$sql .= " AND";
	$sql .= "    t_client.shop_id = $shop_id";
	$sql .= ";";

	$result = Db_Query($db_con, $sql); 
	//Get_Id_Check($result);

	//�ǡ����������
	$result_count = pg_numrows($result);
	for($i = 0; $i < $result_count; $i++){
        $row[] = @pg_fetch_array ($result, $i,PGSQL_NUM);
    }
    for($i = 0; $i < $result_count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){
			//���˥�������Ƚ��
			if($j == 0){
				//������̾�Ϥ��ʤ�
				$data_list[$i][$j] = nl2br($row[$i][$j]);
			}else{
				//�ʳ�
				$data_list[$i][$j] = nl2br(htmlspecialchars($row[$i][$j]));
			}
        }
    }

	$cname          = $data_list[0][0];        //������̾
	$trade_name     = $data_list[0][1];        //�����ʬ
	//$ac_price       = $data_list[0][2];        //�Ҳ����ʸ����ۡ�
	//$ac_rate        = $data_list[0][3];        //�Ҳ����ʡ�����
	$state          = $data_list[0][2];        //�������
	$client_cd1     = $data_list[0][3];        //������CD1
	$client_cd2     = $data_list[0][4];        //������CD2

	//�Ҳ����̾����
	$sql  = "SELECT";
	$sql .= " CASE  ";
	$sql .= " WHEN t_client.client_cd2 IS NOT NULL";
	$sql .= "  THEN t_client.client_cd1 || '-' ||t_client.client_cd2 || ' ' ||t_client.client_cname";
	$sql .= " ELSE";
	$sql .= "  t_client.client_cd1 || ' ' ||t_client.client_cname";
	$sql .= " END  ";

	//$sql .= " t_client.client_cname ";
	$sql .= " FROM";
	$sql .= "   t_client_info ";
	$sql .= "   INNER JOIN t_client ON t_client.client_id = t_client_info.intro_account_id ";
	$sql .= " WHERE";
	$sql .= "   t_client_info.client_id = $client_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql); 
	$info_list = Get_Data($result);

	$ac_name        = $info_list[0][0];        //�Ҳ����
	if($ac_name == ""){
		$ac_name = "̵��";
	}

	//�������Ƚ��
	if($state == 1){
		//�����
		$state = "�����";
	}else if($state == 2){
		//�ٻ���
		$state = "�ٻ���";
	}else if($state == 3){
		//����
		$state = "����";
	}

	/*	
	//�Ҳ���Ƚ��
	$client_flg = false;                       //�Ҳ���ɽ���ե饰
	if($ac_price != NULL){
		//������ξҲ����ʸ����ۡ�
		$intro_ac_money = number_format($ac_price);
	}else if($ac_rate != NULL){
		//������ξҲ����ʡ�����
		$intro_ac_money = $ac_rate."%";
	}else{
		//������˾Ҳ��������ꤵ��Ƥ��ʤ����ˡ�����ξҲ�����ɽ��
		$client_flg = true;
	}
	*/


	//POST�����ѹ�
	$client_data["form_client"]["cd1"] = $client_cd1;
	$client_data["form_client"]["cd2"] = $client_cd2;
	$client_data["form_client"]["name"] = $cname;
	$client_data["client_search_flg"]   = "";
	
}else{
	//POST�����ѹ�
	$client_data["form_client"]["cd1"] = "";
	$client_data["form_client"]["cd2"] = "";
	$client_data["form_client"]["name"] = "";
	$client_data["client_search_flg"]   = "";
}
$form->setConstants($client_data);

/****************************/
//�ǡ���ɽ�����ʺ�������
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    t_contract.line, ";                    //��No0
$sql .= "    t_contract.contract_day,";             //������1
$sql .= "    t_contract.route,";                    //��ϩ2
$sql .= "    CASE t_con_info.divide ";              //�����ʬ3
$sql .= "         WHEN '01' THEN '��ԡ���'";
$sql .= "         WHEN '02' THEN '����'";
$sql .= "         WHEN '03' THEN '��󥿥�'";
$sql .= "         WHEN '04' THEN '�꡼��'";
$sql .= "         WHEN '05' THEN '����'";
$sql .= "         WHEN '06' THEN '����¾'";
$sql .= "    END,";
$sql .= "    CASE t_con_info.serv_pflg ";           //�����ӥ�����4
$sql .= "         WHEN 't' THEN '��'";
$sql .= "         WHEN 'f' THEN '��'";
$sql .= "    END,";
$sql .= "    t_serv.serv_name,";                    //�����ӥ�̾5

$sql .= "    CASE t_con_info.goods_pflg ";          //�����ƥ����6
$sql .= "         WHEN 't' THEN '��'";
$sql .= "         WHEN 'f' THEN '��'";
$sql .= "    END,";
$sql .= "    t_con_info.goods_name,";               //�����ƥ�̾7
$sql .= "    t_con_info.set_flg,";                  //�켰�ե饰8
$sql .= "    t_con_info.num,";                      //����9

$sql .= "    t_con_info.trade_price,";              //�Ķȸ���10
$sql .= "    t_con_info.sale_price,";               //���ñ��11
$sql .= "    t_con_info.trade_amount,";             //�Ķȶ��12
$sql .= "    t_con_info.sale_amount,";              //�����13

$sql .= "    t_con_info.egoods_name,";              //������̾14
$sql .= "    t_con_info.egoods_num, ";              //�����ʿ���15

$sql .= "    t_con_info.rgoods_name,";              //����̾16
$sql .= "    t_con_info.rgoods_num,";               //���ο���17

$sql .= "    t_con_info.account_price,";            //���¶��18
$sql .= "    t_con_info.account_rate,";             //����Ψ19

$sql .= "    t_contract.round_div,";                //����ʬ20
$sql .= "    t_contract.cycle,";                    //����21
$sql .= "    t_contract.cycle_unit,";               //����ñ��22
$sql .= "    CASE t_contract.cale_week ";           //��̾(1-4)23
$sql .= "        WHEN '1' THEN ' ��1'";
$sql .= "        WHEN '2' THEN ' ��2'";
$sql .= "        WHEN '3' THEN ' ��3'";
$sql .= "        WHEN '4' THEN ' ��4'";
$sql .= "    END,";
$sql .= "    CASE t_contract.abcd_week ";           //��̾(ABCD)24
$sql .= "        WHEN '1' THEN 'A(4���ֳ�)��'";
$sql .= "        WHEN '2' THEN 'B(4���ֳ�)��'";
$sql .= "        WHEN '3' THEN 'C(4���ֳ�)��'";
$sql .= "        WHEN '4' THEN 'D(4���ֳ�)��'";
$sql .= "        WHEN '5' THEN 'A,C(2���ֳ�)��'";
$sql .= "        WHEN '6' THEN 'B,D(2���ֳ�)��'";
$sql .= "        WHEN '21' THEN 'A(8���ֳ�)��'";
$sql .= "        WHEN '22' THEN 'B(8���ֳ�)��'";
$sql .= "        WHEN '23' THEN 'C(8���ֳ�)��'";
$sql .= "        WHEN '24' THEN 'D(8���ֳ�)��'";
$sql .= "    END,";
$sql .= "    t_contract.rday, ";                    //������25
$sql .= "    CASE t_contract.week_rday ";           //��������26
$sql .= "        WHEN '1' THEN ' ����'";
$sql .= "        WHEN '2' THEN ' ����'";
$sql .= "        WHEN '3' THEN ' ����'";
$sql .= "        WHEN '4' THEN ' ����'";
$sql .= "        WHEN '5' THEN ' ����'";
$sql .= "        WHEN '6' THEN ' ����'";
$sql .= "        WHEN '7' THEN ' ����'";
$sql .= "    END,";
//$sql .= "    t_contract.stand_day,";                //��ȴ����27

$sql .= "    CASE  ";          //��ȴ����27
$sql .= "         WHEN t_contract.update_day IS NULL THEN t_contract.stand_day";
$sql .= "         WHEN t_contract.update_day IS NOT NULL THEN t_contract.update_day";
$sql .= "    END,";


$sql .= "    t_contract.last_day,";                 //�ǽ������28

$sql .= "    '1:' || t_staff1.staff_name || ";              //ô���ԣ������Ψ��29
$sql .= "    '(' || t_staff1.sale_rate || '%)',"; 
$sql .= "    '2:' || t_staff2.staff_name || ";              //ô���ԣ������Ψ��30
$sql .= "    '(' || t_staff2.sale_rate || '%)',"; 
$sql .= "    '3:' || t_staff3.staff_name || ";              //ô���ԣ������Ψ��31
$sql .= "    '(' || t_staff3.sale_rate || '%)',"; 
$sql .= "    '4:' || t_staff4.staff_name || ";              //ô���ԣ������Ψ��32
$sql .= "    '(' || t_staff4.sale_rate || '%)',"; 
$sql .= "    t_contract.note,";                     //����33
$sql .= "    t_contract.contract_id,";              //�������ID34
$sql .= "    t_contract.client_id, ";               //������ID35
$sql .= "    t_con_info.con_info_id, ";             //��������ID36
$sql .= "    t_con_info.line, ";                    //�������ƹ�37

$sql .= "    t_trust.client_cname,";                //���̾ 38
$sql .= "    t_contract.act_request_day,";          //������ 39
$sql .= "    t_contract.act_request_rate || '%',";  //����� 40
$sql .= "    t_contract.request_state, ";           //��Ծ��� 41
$sql .= "    t_trust.client_cd1, ";                 //���CD1 42
$sql .= "    t_trust.client_cd2, ";                  //���CD2 43   
$sql .= "    t_con_info.official_goods_name, ";                  //���CD2 44   
$sql .= "    CASE t_contract.state ";           //������� 45   
$sql .= "     WHEN '1' THEN '������'";                  
$sql .= "     WHEN '2' THEN '�ٻߡ�������'";                  
$sql .= "    END,  ";                  

$sql .= "    CASE  ";           //�Ҳ���¶�ʬ 46
$sql .= "     WHEN t_contract.intro_ac_div = '1' THEN '̵��'";                  
$sql .= "     WHEN t_contract.intro_ac_div = '2' THEN intro_ac_price || '��'";                  
$sql .= "     WHEN t_contract.intro_ac_div = '3' THEN intro_ac_rate  || '��'";                  
$sql .= "     WHEN t_contract.intro_ac_div = '4' THEN '������' ";                  
$sql .= "    END,  ";                  

$sql .= "    CASE  ";           //�Ҳ�������ʾ����̡� 47
$sql .= "     WHEN t_contract.intro_ac_div = '4' AND t_con_info.account_price >0 THEN t_con_info.account_price || '��'";                  
$sql .= "     WHEN t_contract.intro_ac_div = '4' AND t_con_info.account_rate  >0 THEN t_con_info.account_rate  || '��'";           
$sql .= "     ELSE '' ";                       
$sql .= "    END,  ";                  
$sql .= "    t_contract.act_div,";                       //�������ʬ 48
$sql .= "    t_contract.trust_sale_amount,";         //�����49
$sql .= "    t_contract.act_request_rate, ";          //������ʡ��50
$sql .= "    t_contract.act_request_price, ";          //������ʸ���ۡ�51
$sql .= "    t_con_info.advance_flg, ";                //�����껦�ե饰52
//aoyama-n 2009-09-24
#$sql .= "    t_con_info.advance_offset_amount ";      //�����껦��53
$sql .= "    t_con_info.advance_offset_amount, ";      //�����껦��53
$sql .= "    t_goods.discount_flg ";                   //�Ͱ��ե饰54
/*
$sql .= "    CASE t_contract.act_div ";           //������� 48   
$sql .= "     WHEN '1' THEN '̵��'";                  
$sql .= "     WHEN '2' THEN t_contract.trust_sale_amount || '(�����)'";                  
$sql .= "     WHEN '3' THEN t_contract.trust_sale_amount || '(' || t_contract.act_request_rate ||'%)'";                  
$sql .= "    END  ";                  
*/
$sql .= "FROM "; 
$sql .= "    t_con_info ";

$sql .= "    INNER JOIN t_contract ON t_contract.contract_id = t_con_info.contract_id ";

$sql .= "    LEFT JOIN t_serv ON t_serv.serv_id = t_con_info.serv_id ";

$sql .= "    LEFT JOIN t_client AS t_trust ON t_trust.client_id = t_contract.trust_id ";

//aoyama-n 2009-09-24
$sql .= "    LEFT JOIN t_goods ON t_con_info.goods_id = t_goods.goods_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_name,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '0'";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/25��01-008��������suzuki-t�������Ψ�������ô����ɽ��
 *
$sql .= "         AND ";
$sql .= "             t_con_staff.sale_rate != '0'";
*/
$sql .= "         AND \n";
$sql .= "             t_con_staff.sale_rate IS NOT NULL\n";
$sql .= "        )AS t_staff1 ON t_staff1.contract_id = t_contract.contract_id ";
 
$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_name,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '1'";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/25��01-008��������suzuki-t�������Ψ�������ô����ɽ��
 *
$sql .= "         AND ";
$sql .= "             t_con_staff.sale_rate != '0'";
*/
$sql .= "         AND \n";
$sql .= "             t_con_staff.sale_rate IS NOT NULL\n";
$sql .= "        )AS t_staff2 ON t_staff2.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_name,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '2'";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/25��01-008��������suzuki-t�������Ψ�������ô����ɽ��
 *
$sql .= "         AND ";
$sql .= "             t_con_staff.sale_rate != '0'";
*/
$sql .= "         AND \n";
$sql .= "             t_con_staff.sale_rate IS NOT NULL\n";
$sql .= "        )AS t_staff3 ON t_staff3.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_name,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '3'";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/25��01-008��������suzuki-t�������Ψ�������ô����ɽ��
 *
$sql .= "         AND ";
$sql .= "             t_con_staff.sale_rate != '0'";
*/
$sql .= "         AND \n";
$sql .= "             t_con_staff.sale_rate IS NOT NULL\n";
$sql .= "        )AS t_staff4 ON t_staff4.contract_id = t_contract.contract_id ";

$sql .= "WHERE "; 
$sql .= "    t_contract.client_id = $client_id "; 
$sql .= "AND ";
if($_SESSION["group_kind"] == '2'){
    $sql .= "    t_contract.shop_id IN (".Rank_Sql().") ";
}else{
    $sql .= "    t_contract.shop_id = $shop_id ";
}

$sql .= "ORDER BY ";
$sql .= "    t_contract.line,";
$sql .= "    t_con_info.line;";
print $sql;

//�ǡ�����¸�ߤ���or�ѹ����˼¹�
if($client_d_flg == false && $client_id != NULL){
	$result = Db_Query($db_con, $sql); 
	//Get_Id_Check($result);
	//$disp_data = pg_fetch_all($result);
	$disp_data = Get_Data($result);
}



//�ǡ���¸��Ƚ��
if($disp_data == NULL){
	//�ǡ�����¸�ߤ��ʤ����ˡ�ɽ���������١��ե饰�ˤ�ä�ɽ�������ѹ�
	$early_flg = true;
}

/****************************/
//�ǡ���ɽ�������ѹ�
/****************************/
$row = 0;          //�Կ��������
for($i=0;$i<count($disp_data);$i++){

	//�ѹ���������
	$contract_id = $disp_data[$i][34];
	$disp_data[$i][history] = Log_Get($db_con,"����ޥ���",$contract_id);

    //����ʬ�롼��
    $count = count($disp_data[$i][history]);
    for($j=0;$j<$count;$j++){
        $disp_data[$i][history][$j][staff_name] = htmlspecialchars($disp_data[$i][history][$j][staff_name]);
    }

	//��ϩ�����ѹ�
	if($disp_data[$i][2] != NULL){
		$disp_data[$i][2] = str_pad($disp_data[$i][2], 4, 0, STR_POS_LEFT);
		$route1 = substr($disp_data[$i][2],0,2);
		$route2 = substr($disp_data[$i][2],2,2);
		$disp_data[$i][2] = $route1."-".$route2;
	}

	//�Ҳ���ɽ��Ƚ��
	if($disp_data[$i][18] != NULL){
		//��
		$disp_data[$i][18] = number_format($disp_data[$i][18]);
	}else if($disp_data[$i][19] != NULL){
		//Ψ(����ۡ����Ψ)
		$disp_data[$i][19] = $disp_data[$i][19]."%(".number_format(bcmul($disp_data[$i][13],bcdiv($disp_data[$i][19],100,2),2)).")";
	}

	//���̷����ѹ�
	$disp_data[$i][9]  = my_number_format($disp_data[$i][9]);
	$disp_data[$i][15] = my_number_format($disp_data[$i][15]);
	$disp_data[$i][17] = my_number_format($disp_data[$i][17]);
	$disp_data[$i][53] = my_number_format($disp_data[$i][53]);
	
	//ñ�������ѹ�
	for($c=10;$c<=11;$c++){
		$disp_data[$i][$c] = number_format($disp_data[$i][$c],2);
	}
	//��۷����ѹ�
	for($c=12;$c<=13;$c++){
		$disp_data[$i][$c] = number_format($disp_data[$i][$c]);
	}

	//$stand_day  = substr($disp_data[$i][27],0,7); //����ȯ����
	$stand_day  = $disp_data[$i][27]; //����ȯ����

	//����������ѹ�
	if($disp_data[$i][20] == "1"){
		//���
		$round_data[$i] = $disp_data[$i][24].$disp_data[$i][26];
	}else if($disp_data[$i][20] == "2"){
		//���

		if($disp_data[$i][25] == "30"){
			$round_data[$i] = "��� ���� <br>(".$stand_day.")";
		}else{
			$round_data[$i] = "��� ".$disp_data[$i][25]."�� <br>(".$stand_day.")";
		}
	}else if($disp_data[$i][20] == "3"){
		//���
		$round_data[$i] = "���".$disp_data[$i][23].$disp_data[$i][26]."<br>(".$stand_day.")";

	}else if($disp_data[$i][20] == "4"){
		//���
		$round_data[$i] = $disp_data[$i][21]."���ּ�����".$disp_data[$i][26]."<br>(".$disp_data[$i][27].")";

	}else if($disp_data[$i][20] == "5"){
		//���
		if($disp_data[$i][25] == "30"){
			$round_data[$i] = $disp_data[$i][21]."��������� ���� <br>(".$stand_day.")";
		}else{
			$round_data[$i] = $disp_data[$i][21]."��������� ".$disp_data[$i][25]."�� <br>(".$stand_day.")";
		}

	}else if($disp_data[$i][20] == "6"){
		//���
		$round_data[$i] = $disp_data[$i][21]."��������� ".$disp_data[$i][23].$disp_data[$i][26]."<br>(".$stand_day.")";

	}else if($disp_data[$i][20] == "7"){
		//���
		$round_data[$i] = "��§��<br>(�ǽ���:".$disp_data[$i][28].")";
	}

	//���ô���������Ψɽ��Ƚ��
	for($c=29;$c<=32;$c++){
		//����Ƚ��
		if(!ereg("[0-9]",$disp_data[$i][$c])){
			//�ͤ����Ϥ���Ƥ��ʤ����ϡ�NULL
			$disp_data[$i][$c] = NULL;
		}else{
			//�ͤ����Ϥ���Ƥ�����ϡ��ᥤ��ʳ��ϲ��Ԥ��ɲ�
			if($c!=29){
				$disp_data[$i][$c] = "<br>".$disp_data[$i][$c];
			}
		}
	}

	//������˾Ҳ��������ꤵ��Ƥ����硢���󤴤ȤξҲ�����ˤϡ�NULLɽ��
	if($client_flg != true){
		$disp_data[$i][18] = "��";
		$disp_data[$i][19] = "��";
	}
	
	//��No.�ѹ�Ƚ��
	if($disp_data[$i][0] != $line_num){
		//�����Ƚ��
		if($i != 0){
			//������Υǡ������Կ���������ɲ�
			$disp_data[$i-$row][101] = $row;

			//�Ԥ��طʿ�����
			if($color_flg == true){
				//�����Фˤ���
				$disp_data[$i-$row][100] = true;
				$color_flg = false;
			}else{
				//������ˤ���
				$disp_data[$i-$row][100] = false;
				$color_flg = true;
			}

			//���ι�No.�򥻥å�
			$line_num = $disp_data[$i][0];
			$row = 0;
		}else{
			//����ܤξ��ϡ���No.�򥻥å�
			$line_num = $disp_data[$i][0];
		}
	}

	//�������
	//�����
	if($disp_data[$i][48] == "2"){
		$disp_data[$i][48] = Minus_Numformat($disp_data[$i][51])."��<br>(�����)";

	//��
	}elseif($disp_data[$i][48] == "3"){
		$disp_data[$i][48] = Minus_Numformat($disp_data[$i][49])."��<br>(".$disp_data[$i][50]."%)";

	//ȯ�����ʤ�
	}else{
		$disp_data[$i][48] = "̵��";
	}

	//�Ԥ��طʿ�����
	if($color_flg == true){
		//�����Фˤ���
		$disp_data[$i][100] = true;
	}else{
		//������ˤ���
		$disp_data[$i][100] = false;
	}

	$row++;

	/*
	//��������Ƚ��
	$sql  = "SELECT con_info_id FROM t_con_detail WHERE con_info_id = ".$disp_data[$i][36].";";
	$result = Db_Query($db_con, $sql);
	$row_num = pg_num_rows($result);
	if(1 <= $row_num){
		//�������ɽ��
		$disp_data[$i][101] = true;
	}else{
		//���������ɽ��
		$disp_data[$i][101] = false;
	}
	*/


}

//�Ǹ�ιԿ��򥻥å�
$disp_data[$i-$row][101] = $row;

//�Ԥ��طʿ�����
if($color_flg == true){
	//�����Фˤ���
	$disp_data[$i-$row][100] = true;
}else{
	//������ˤ���
	$disp_data[$i-$row][100] = false;
}

/****************************/
//���������
/****************************/
$client_sql  = " SELECT ";
$client_sql .= "     DISTINCT(t_client.client_id) ";
$client_sql .= " FROM";
$client_sql .= "     t_client ";
$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
$client_sql .= " WHERE";
$client_sql .= "     t_client.shop_id = $shop_id";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = '1'";

//�إå�����ɽ�������������
$count_res = Db_Query($db_con, $client_sql.";");
$total_count = pg_num_rows($count_res);


/****************************/
// �����껦�ۡ�������Ĺ���Ͻ���
/****************************/
// ������ID��������
if ($client_id != null){

    // ̤��������껦�ۼ�����̤����, ̤��ǧ��
    // �оݡ�����Τ�

    // ���˹礦�����������
    //  �������껦�ۤ���
    //  ��������åפη���
    //  �����ꤵ�줿������ؤη���
    //  ������λ����̤��ʤ���NULL�Ǥʤ���
    $sql  = "SELECT \n";
    $sql .= "   t_contract.contract_id, \n";                                // ����ID
    $sql .= "   t_contract.claim_div, \n";                                  // �������ʬ
    $sql .= "   t_contract.contract_eday, \n";                              // ����λ��
    $sql .= "   SUM(COALESCE(t_con_info.advance_offset_amount, 0)) \n";
    $sql .= "   AS advance_offset \n";                                      // �����껦�ۡ���ɼ���ס�
    $sql .= "FROM \n";
    $sql .= "   t_contract \n";
    $sql .= "   INNER JOIN t_con_info \n";
    $sql .= "       ON  t_contract.contract_id = t_con_info.contract_id \n";
    $sql .= "       AND t_con_info.advance_offset_amount IS NOT NULL \n";   // �����껦�ۤ���
    $sql .= "WHERE \n";
    $sql .= "   t_contract.contract_eday > ".date("Y-m-d")." \n";           // ����λ����̤��ʤ���NULL�Ǥʤ���
    $sql .= "AND \n";
    $sql .= "   t_contract.shop_id = $shop_id \n";                          // ������åפη���
    $sql .= "AND \n";
    $sql .= "   t_contract.client_id = $client_id \n";                      // ���ꤵ�줿������ؤη���
    $sql .= "GROUP BY \n";
    $sql .= "   t_contract.contract_id, \n";
    $sql .= "   t_contract.claim_div, \n";
    $sql .= "   t_contract.contract_eday \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    $ary_contract_data = Get_Data($res, 2, "ASSOC");

    // ���˹礦������󤬤�����
    if ($num > 0){

        // �����Ϣ�ؿ��򥤥󥯥롼��
        require_once(INCLUDE_DIR."function_keiyaku.inc");

        // ���������պ���
        $tomorrow = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));

        // ��������������ǥ롼��
        foreach ($ary_contract_data as $key => $value){

            // ��������Ρ�̤��ν�����򥫥����
            $cnt_round_day = count(Get_Round_Day($db_con, $value["contract_id"], $tomorrow, $value["contract_eday"], true));

            // �ֺ���������껦�۹�ס��������ʬ��ˡפˡ������껦�� x ̤��ν�����פ�û�
            $adv_total[$value["claim_div"]] += $value["advance_offset"] * $cnt_round_day;

        }

    }

    // �������ʬ��������껦�۹�פ��֤��ؿ�
    // �ʲ�3������ǻ���
    function Adv_Amount($db_con, $sql, $adv_total){
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        $ary_adv_data = Get_Data($res, 2, "ASSOC");
        if ($num > 0){
            foreach ($ary_adv_data as $key => $value){
                $adv_total[$value["claim_div"]] += $value["amount"];
            }
        }
        return $adv_total;
    }

    // ̤��������껦�ۼ�����̤����, ̤��ǧ��
    // �оݡ�ͽ����Τ�
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.claim_div, \n";
    $sql .= "   SUM(t_aorder_h.advance_offset_totalamount) AS amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_time > '".date("Y-m-d")."' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_id IS NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.confirm_flg = 'f' \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_aorder_h.claim_div \n";
    $sql .= ";";
    $adv_total = Adv_Amount($db_con, $sql, $adv_total);

    // ���������껦�ۼ�����̤����, ̤��ǧ��
    // �оݡ�����
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.claim_div, \n";
    $sql .= "   SUM(t_aorder_h.advance_offset_totalamount) AS amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   INNER JOIN t_contract \n";
    $sql .= "       ON  t_aorder_h.contract_id = t_contract.contract_id \n";
    $sql .= "       AND t_contract.contract_eday IS NOT NULL \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_time <= '".date("Y-m-d")."' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.confirm_flg = 'f' \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_aorder_h.claim_div \n";
    $sql .= ";";
    $adv_total = Adv_Amount($db_con, $sql, $adv_total);

    // ���������껦�ۼ�����̤����, ̤��ǧ��
    // �оݡ�ͽ���񡦼��
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.claim_div, \n";
    $sql .= "   SUM(t_aorder_h.advance_offset_totalamount) AS amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_time <= '".date("Y-m-d")."' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_id IS NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.confirm_flg = 'f' \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_aorder_h.claim_div \n";
    $sql .= ";";
    $adv_total = Adv_Amount($db_con, $sql, $adv_total);

    // ���������껦�ۼ����ʳ����, ��ǧ�ѡ�
    // �оݡ������껦����ɼ����
    $sql  = "SELECT \n";
    $sql .= "   t_payin_h.claim_div, \n";
    $sql .= "   SUM(t_payin_d.amount) AS amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_payin_h \n";
    $sql .= "   INNER JOIN t_payin_d \n";
    $sql .= "       ON  t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       AND t_payin_d.trade_id = 40 \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payin_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payin_h.shop_id = $shop_id \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_payin_h.claim_div \n";
    $sql .= ";";
    $adv_total = Adv_Amount($db_con, $sql, $adv_total);

    // ������������
    // ��������ۼ���
    $sql  = "SELECT \n";
    $sql .= "   claim_data.claim_div, \n";          // �������ʬ
    $sql .= "   claim_data.client_cd1, \n";         // �����襳���ɣ�
    $sql .= "   claim_data.client_cd2, \n";         // �����襳���ɣ�
    $sql .= "   claim_data.client_cname, \n";       // ������̾ά��
    $sql .= "   advance_data.advance_amount \n";    // ��������۹��
    $sql .= "FROM \n";
    // ���������
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_claim.claim_div, \n";
    $sql .= "           t_client.client_cd1, \n";
    $sql .= "           t_client.client_cd2, \n";
    $sql .= "           t_client.client_cname \n";
    $sql .= "       FROM \n";
    $sql .= "           t_claim \n";
    $sql .= "           INNER JOIN t_client \n";
    $sql .= "               ON  t_claim.claim_id = t_client.client_id \n";
    $sql .= "               AND t_claim.client_id = $client_id \n";
    $sql .= "               AND t_client.shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS claim_data \n";
    // ���������
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_advance.claim_div, \n";
    $sql .= "           SUM(t_advance.amount) AS advance_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_advance.client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_advance.shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_advance.claim_div \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data \n";
    $sql .= "   ON claim_data.claim_div = advance_data.claim_div \n";
    $sql .= "ORDER BY \n";
    $sql .= "   claim_data.claim_div \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    Get_Id_Check($res);

    $num  = pg_num_rows($res);
    $advance_data = Get_Data($res, "2", "ASSOC");

    // ���ϥơ��֥����
    $html_g  = "<table class=\"Data_Table\" border=\"1\">\n";
    $html_g .= "<col width=\" 70px\" style=\"font-weight: bold;\">\n";
    $html_g .= "<col>\n";
    $html_g .= "<col width=\"120px\" style=\"font-weight: bold;\">\n";
    $html_g .= "<col width=\"100px\" align=\"right\">\n";
    // // �����ǡ����ǥ롼�ס��������ʬ��
    foreach ($advance_data as $key => $value){
        $html_g .= "    <tr>\n";
        $html_g .= "        <td class=\"Title_Purple\" rowspan=\"2\">������".$value["claim_div"]."</td>\n";
        $html_g .= "        <td class=\"Value\" rowspan=\"2\">\n";
        $html_g .= "            ".$value["client_cd1"]."-".$value["client_cd2"]."<br>".htmlspecialchars($value["client_cname"])."\n";
        $html_g .= "        </td>\n";
        $html_g .= "        <td class=\"Title_Purple\">�����껦�۹��</td>\n";
        $html_g .= "        <td class=\"Value\">".Numformat_Ortho($adv_total[$value["claim_div"]])."</td>\n";
        $html_g .= "    </tr>\n";
        $html_g .= "    <tr>\n";
        $html_g .= "        <td class=\"Title_Purple\">������Ĺ�</td>\n";
        $html_g .= "        <td class=\"Value\">".Numformat_Ortho($value["advance_amount"] - $adv_total[$value["claim_div"]])."</td>\n";
        $html_g .= "    </tr>\n";
    }
    $html_g .= "</table>\n";

}


/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//�ǥ��쥯�ȥ�
/****************************/
$fc_page = FC_DIR."system/2-1-104.php";

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//$page_title .= "��".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'    => "$html_header",
	'page_menu'      => "$page_menu",
	'page_header'    => "$page_header",
	'html_footer'    => "$html_footer",
	'fc_page'        => "$fc_page",
	//'client_flg'     => "$client_flg",
	'early_flg'      => "$early_flg",
	'cname'          => "$cname",
	'intro_ac_money' => "$intro_ac_money",
	'trade_name'     => "$trade_name",
	'state'          => "$state",
	'ac_name'        => "$ac_name",
	'get_flg'        => "$get_flg",
    "html_g"        => $html_g,
));

//ɽ���ǡ���
$smarty->assign("disp_data", $disp_data);
$smarty->assign("round_data", $round_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
