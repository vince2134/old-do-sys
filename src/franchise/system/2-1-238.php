<?php
/*
 * �ѹ�����
 * 2006-10-12 suzuki �߸˴������ʤ����ʤϼ�ʧ����Ͽ���ʤ��褦�˽���
 * 2006-10-12 kaji   ��ʧ��ά�Τ���Ͽ����褦�˽���
 *                   ������������̾��������̾2��������̾��ά�Ρˤ򸡺�����褦�˽���
 *                   �߸˴������ʤ����ʤϼ�ʧ����Ͽ����褦���᤹
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/11      03-030      kajioka-h   �������η�����������å������ɲ�
 *                  03-031      kajioka-h   �������Υ����ƥ೫���������å������ɲ�
 *                  03-035      kajioka-h   ������𤵤�Ƥ��ʤ��������å������ɲ�
 *                  03-045      kajioka-h   ��α������줿��ɼ��ɽ�����ʤ������ɲ�
 *                  03-048      kajioka-h   ������ϳƥ���åפ�������ޥ�������Ͽ����Ƥ������ۤ�Ȥ��褦��
 *  2006/11/14      03-053      kajioka-h   �������ΰ�����η�����������å���������
 *  2006/12/10      03-076      suzuki      ��ʧ���ơ��֥���Ͽ�ѿ����������褦�˽���
 *  2006/12/15      0082        suzuki      ��ʧ�ơ��֥����Ͽ����в��Ҹ�ID�ϼ���νв��Ҹ�ID����Ѥ���褦�˽���
 *  2007/02/19      �׷�5-1     kajioka-h   ���ʽв�ͽ��Ǻ߸˰�ư̤�»ܤ������ɼ�����򤵤�Ƥ������˷ٹ��å�������ɽ����������ɲ�
 *  2007/02/28      ��ȹ���67  fukuda-s    ������ܺٽ���
 *  2007/03/05      ��ȹ���67  fukuda-s    ��۹�׽���
 *  2007/03/05      ��ȹ���12  �դ���      �ݡ�����ι�פ����
 *  2007/03/22                  �դ���      ��α����ե饰�����ե饰���ѹ�
 *  2007/03/26      �׷�12      kajioka-h   ��������ʬ�� include/fc_sale_report.inc �˽Ф���
 *  2007-04-12                  fukuda      ����������������ɲ�
 *  2007/04/27      ¾79,152    kajioka-h   ������λ����ѹ�
 *  2007/05/31      xx-xxx      kajioka-h   �����ɼ�����˽����������2�פˤ��ʤ��褦�ˤ������ᡢ��о����Ѥ���
 *  2007/06/14      xx-xxx      kajioka-h   �����ʬ��05������  06��������¾  ���ѹ�
 *
 */

$page_title = "���������������������";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// ��������ؿ����
require_once(PATH ."function/trade_fc.fnc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_display_num"  => "1", 
    "form_client_branch"=> "",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""), 
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""), 
    "form_round_day"    => array(
        "sy" => date("Y"), "sm" => date("m"), "sd" => date("d"), "ey" => date("Y"), "em" => date("m"), "ed" => date("d")
    ), 
    "form_claim_day"    => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_charge_fc"    => array("cd1" => "", "cd2" => "", "name" => "", "select" => ""), 
    "form_slip_no"      => array("s" => "", "e" => ""), 
    "form_contract_div" => "1", 
);

// �����������
Restore_Filter2($form, "sale", "form_display", $ary_form_list);


/****************************/
//�����ѿ�����
/****************************/
$shop_id   = $_SESSION["client_id"];  //������ID
$staff_id  = $_SESSION["staff_id"];   //�������ID


/****************************/
// ���������
/****************************/
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����

// ɽ���ܥ��󲡲�����POST���줿�ե�������
if ($_POST["form_display"] != null){
    $range = $_POST["form_range_select"];
// ɽ���ܥ���ʳ���POST����hidden����
}elseif ($_POST != null && $_POST["form_display"] == null){
    $range = $_POST["hdn_range_select"];
// POST���ʤ����ϥǥե���Ȥ�100��
}else{
    $range = 100;
}


/****************************/
// �ե�����ǥե����������
/****************************/
$form->setDefaults($ary_form_list);

if ($_POST["form_display_num"] == "1"){
    $range = null;
}else{
    $range = "100";
}
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �ե�����ǥե����������
/****************************/
$form->setDefaults($ary_form_list);


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form($db_con, $form, $ary_form_list);

// ���ץե��������
$form->removeElement("form_client_branch");
$form->removeElement("form_claim");
$form->removeElement("form_claim_day");
$form->removeElement("form_charge_fc");

/* �⥸�塼����̥ե����� */
// ��ɼ�ֹ�ʳ��ϡ���λ��
$obj    =   null;
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "��");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_slip_no", "", "");

// �����ȥ��
$ary_sort_item = array(
    "sl_slip"           => "��ɼ�ֹ�",
    "sl_arrival_day"    => "ͽ������",
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_round_staff"    => "���ô����<br>�ʥᥤ�󣱡�",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_arrival_day");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

//���ꥢ
$form->addElement("button", "form_clear", "���ꥢ", "onClick=\"javascript:location.href='".$_SERVER["PHP_SELF"]."';\"");

// ��ץܥ���
$form->addElement("button", "form_sum", "�硡��",
    "onClick=\"javascript: Button_Submit('sum_flg', '".$_SERVER["PHP_SELF"]."#sum', true)\""
);

// ����ܥ���
$form->addElement("button", "form_confirm", "�󡡹�",
    "onClick=\"javascript: Button_Submit('report_flg','".$_SERVER["PHP_SELF"]."', true)\" $disabled"
);

// �إå����ѥܥ��� ͽ����ɼ������
$form->addElement("button", "kakutei_button", "ͽ����ɼ������", "onClick=\"location.href='../sale/2-2-206.php'\"");

// �إå����ѥܥ��� �������
$form->addElement("button", "act_button", "�������", "$g_button_color onClick=\"location.href='2-1-238.php'\"");

// �����ե饰
$form->addElement("hidden","report_flg");   // ���ե饰
$form->addElement("hidden","sum_flg");      // ��ץե饰


/****************************/
// ��ץܥ��󲡲���
/****************************/
if ($_POST["sum_flg"] == "true"){

    $con_data["sum_flg"] = false;   //��ץܥ�������

    $output_id_array = $_POST["output_id_array"];  //����ID����
    $check_num_array = $_POST["form_slip_check"];  //��ɼ�����å�

    //��ɼ�˥����å���������˹Ԥ�
    if($check_num_array != NULL){
        $aord_array = NULL;    //��ɼ���ϼ���ID����
        foreach ($check_num_array as $key => $value){
            if ($value == "1"){
                $aord_array[] = $output_id_array[$key];
            }
        }
    }

    for($s=0;$s<count($aord_array);$s++){

        $sql  = "SELECT \n";
        $sql .= "    t_trade.trade_name,\n";            //�����ʬ 
        $sql .= "    t_aorder_h.net_amount,\n";         //����� 
        $sql .= "    t_aorder_h.tax_amount \n";         //������ 
        $sql .= "FROM \n";
        $sql .= "    t_aorder_h \n";
        $sql .= "    INNER JOIN t_trade ON t_aorder_h.trade_id = t_trade.trade_id \n";
        $sql .= "WHERE \n";
        $sql .= "    t_aorder_h.aord_id = ".$aord_array[$s].";";
        $result = Db_Query($db_con, $sql);
        $money_data = Get_Data($result);

        /****************************/
        //����塦��������۷׻�
        /****************************/
        //�����ʬȽ��
        if($money_data[0][0] == '�����' || $money_data[0][0] == '������' || $money_data[0][0] == '���Ͱ�' || $money_data[0][0] == '�������'){
            //������۷׻�
            $money1 = $money1 + $money_data[0][1];
            //����������
            $total_tax1 = $total_tax1 + $money_data[0][2];
            //������
            $sum_money1 = $money_data[0][1] + $money_data[0][2];
            $total_money1 = $total_money1 + $sum_money1;
        }else{
            //��������۷׻�
            $money2 = $money2 + $money_data[0][1];
            //������������
            $total_tax2 = $total_tax2 + $money_data[0][2];
            //���������
            $sum_money2 = $money_data[0][1] + $money_data[0][2];
            $total_money2 = $total_money2 + $sum_money2;
        }
        // �ݡ�����ι�פ򻻽�
        $money3         += $money_data[0][1];
        $total_tax3     += $money_data[0][2];
    }

}

/****************************/
// ����ܥ��󲡲�����
/****************************/
if($_POST["report_flg"] == "true" || $_POST["warn_report_flg"] == "true"){
    $output_id_array = $_POST["output_id_array"];  //����ID����
    $check_num_array = $_POST["form_slip_check"];  //��ɼ�����å�

    //��ɼ�˥����å���������˹Ԥ�
    if($check_num_array != NULL){
        $aord_array = NULL;    //��ɼ���ϼ���ID����
        while($check_num = each($check_num_array)){
            //����ź���μ���ID����Ѥ���
            $check = $check_num[0];
            $aord_array[] = $output_id_array[$check];
        }
    }

    require(INCLUDE_DIR."fc_sale_report.inc");

    // �����ѤΥ��顼�ե饰��̾�����Ѥ���
    if ($err_flg == true){
        $confirm_err_flg    = true;
        $err_flg            = null;
    }

}


/****************************/
// ɽ���ܥ��󲡲���
/****************************/
if ($_POST["form_display"] != null){

    /****************************/
    // ���顼�����å�
    /****************************/
    // �����̥ե���������å�
    Search_Err_Chk($form);

    // ����ɼ�ֹ�
    // ���顼��å�����
    $err_msg = "��ɼ�ֹ� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_slip_no", $err_msg);

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// 1. ɽ���ܥ��󲡲��ܥ��顼�ʤ���
// 2. �ڡ����ڤ��ؤ���������¾��POST��
/****************************/
if (($_POST["form_display"] != null && $err_flg != true) || ($_POST != null && $_POST["form_display"] == null)){

    // ����POST�ǡ�����0���
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num        = $_POST["form_display_num"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $round_staff_cd     = $_POST["form_round_staff"]["cd"];
    $round_staff_select = $_POST["form_round_staff"]["select"];
    $part               = $_POST["form_part"];
    $multi_staff        = $_POST["form_multi_staff"];
    $ware               = $_POST["form_ware"];
    $round_day_sy       = $_POST["form_round_day"]["sy"];
    $round_day_sm       = $_POST["form_round_day"]["sm"];
    $round_day_sd       = $_POST["form_round_day"]["sd"];
    $round_day_ey       = $_POST["form_round_day"]["ey"];
    $round_day_em       = $_POST["form_round_day"]["em"];
    $round_day_ed       = $_POST["form_round_day"]["ed"];
    $charge_fc_cd1      = $_POST["form_charge_fc"]["cd1"];
    $charge_fc_cd2      = $_POST["form_charge_fc"]["cd2"];
    $charge_fc_name     = $_POST["form_charge_fc"]["name"];
    $charge_fc_select   = $_POST["form_charge_fc"]["select"];
    $slip_no_s          = $_POST["form_slip_no"]["s"];
    $slip_no_e          = $_POST["form_slip_no"]["e"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null; 

    // ��°�ܻ�Ź
    if ($attach_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_staff_main.staff_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_attach \n";
        $sql .= "           INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_part.branch_id = $attach_branch \n";
        $sql .= "   ) \n";
    }
    // �����襳����1
    $sql .= ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �����襳����2
    $sql .= ($client_cd2 != null) ? "AND t_aorder_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // ������̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_aorder_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ���ô���ԥ�����
    $sql .= ($round_staff_cd != null) ? "AND t_staff_main.charge_cd = '$round_staff_cd' \n" : null;
    // ���ô���ԥ��쥯��
    $sql .= ($round_staff_select != null) ? "AND t_staff_main.staff_id = $round_staff_select \n" : null;
    // ����
    $sql .= ($part != null) ? "AND t_staff_main.part_id = $part \n" : null;
    // ���ô���ԡ�ʣ�������
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff_main.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // �Ҹ�
    $sql .= ($ware != null) ? "AND t_aorder_h.ware_id = $ware \n" : null;
    // ͽ�������ʳ��ϡ�
    $round_day_s = $round_day_sy."-".$round_day_sm."-".$round_day_sd;
    $sql .= ($round_day_s != "--") ? "AND t_aorder_h.ord_time >= '$round_day_s' \n" : null;
    // ͽ�������ʽ�λ��
    $round_day_e = $round_day_ey."-".$round_day_em."-".$round_day_ed;
    $sql .= ($round_day_e != "--") ? "AND t_aorder_h.ord_time <= '$round_day_e' \n" : null;
    // ��ɼ�ֹ�ʳ��ϡ�
    $sql .= ($slip_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��ɼ�ֹ�ʽ�λ��
    $sql .= ($slip_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // ��ɼ�ֹ�
        case "sl_slip":
            $sql .= "   ord_no, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   client_cd \n";
            break;
        // ͽ������
        case "sl_arrival_day":
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no, \n";
            $sql .= "   client_cd \n";
            break;
        // ������
        case "sl_claim_day":
            $sql .= "   arrival_day, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no, \n";
            $sql .= "   client_cd \n";
            break;
        // �����襳����
        case "sl_client_cd":
            $sql .= "   client_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no \n";
            break;
        // ������̾
        case "sl_client_name":
            $sql .= "   client_cname, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no \n";
            break;
        // ���ô���ԡʥᥤ�󣱡�
        case "sl_round_staff":
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no, \n";
            $sql .= "   client_cd \n";
            break;
    }

    // �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// �����ǡ�������
/****************************/
// ɽ���ե饰�����ꡢ���顼�Τʤ����
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                    // ����ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                     // �����ֹ�
    $sql .= "   t_staff_main.charge_cd, \n";                                                // ô����CD
    $sql .= "   t_staff_main.staff_name, \n";                                               // ô����̾
    $sql .= "   t_trade.trade_cd, \n";                                                      // �����ʬ������
    $sql .= "   t_trade.trade_name, \n";                                                    // �����ʬ
    $sql .= "   t_aorder_h.ord_time, \n";                                                   // ͽ������
    $sql .= "   t_aorder_h.client_cname, \n";                                               // ά��
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";    // ������CD
    $sql .= "   t_aorder_h.net_amount, \n";                                                 // ��ȴ�����
    $sql .= "   t_aorder_h.tax_amount, \n";                                                 // ������
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount \n";        // ������
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.staff_id, \n";
    $sql .= "           CAST(LPAD(t_staff.charge_cd, 4, '0') AS TEXT) AS charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name, \n";
    $sql .= "           t_attach.part_id \n";
    $sql .= "        FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN  t_staff  ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "           INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id \n";
    $sql .= "        WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "        AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "        AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff_main \n";
    $sql .= "   ON t_staff_main.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_trade ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "   LEFT JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.act_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.trust_confirm_flg = 'f' \n";
    $sql .= "AND \n";
    //$sql .= "   t_aorder_h.ps_stat IN ('1', '2') \n";
    $sql .= "   t_aorder_h.ps_stat = '1' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 'f' \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // ��������ʷ�������ѡ�
    $res         = Db_Query($db_con, $sql.";");
    $total_count = pg_num_rows($res);

    // OFFSET����
    if($page_count != null || $range != null){
        $offset = $page_count * $range - $range;
    }else{
        $offset = 0;
    }
    if ($range != null){
        $sql .= "LIMIT $range OFFSET $offset \n";
    }

    // �����ǡ��������ʥڡ���ʬ���ѡ�
    $res_h = Db_Query($db_con, $sql.";");
    $num_h = pg_num_rows($res_h);
    if ($num_h > 0){
        $page_data_h = Get_Data($res_h, 2, "ASSOC");
    }else{
        $page_data_h = array(null);
    }

    // �嵭�Ǽ�����������إå��˳����������ǡ����μ���
    if ($num_h > 0){
        $sql  = "SELECT \n";
        $sql .= "   t_aorder_d.aord_id, \n";                // ����ID
        $sql .= "   t_aorder_d.line, \n ";                  // ��
        $sql .= "   CASE t_aorder_d.sale_div_cd \n";
        $sql .= "       WHEN '01' THEN '��ԡ���' \n";
        $sql .= "       WHEN '02' THEN '����' \n";
        $sql .= "       WHEN '03' THEN '��󥿥�' \n";
        $sql .= "       WHEN '04' THEN '�꡼��' \n";
        //$sql .= "       WHEN '05' THEN '��' \n";
        $sql .= "       WHEN '05' THEN '����' \n";
        $sql .= "       WHEN '06' THEN '����¾' \n";
        $sql .= "   END \n";
        $sql .= "   AS sale_div_cd, \n";                    // �����ʬ
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.serv_print_flg = 't' \n";
        $sql .= "       THEN '��'\n";
        $sql .= "       ELSE '��' \n";
        $sql .= "   END \n";
        $sql .= "   AS serv_print_flg, \n";                 // �����ӥ������ե饰
        $sql .= "   t_aorder_d.serv_cd, \n";                // �����ӥ�������
        $sql .= "   t_aorder_d.serv_name, \n";              // �����ӥ�̾
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.goods_print_flg = 't' \n";
        $sql .= "       THEN '��'\n";
        $sql .= "       ELSE '��' \n";
        $sql .= "   END \n";
        $sql .= "   AS goods_print_flg, \n";                // ���ʰ����ե饰
        $sql .= "   t_aorder_d.goods_cd, \n";               // ���ʥ�����
        $sql .= "   t_aorder_d.official_goods_name, \n";    // ����̾
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.set_flg = 't' \n";
        $sql .= "       THEN '�켰<br>'\n";
        $sql .= "       ELSE NULL \n";
        $sql .= "   END \n";
        $sql .= "   AS set_flg, \n";                        // �����ӥ��켰�ե饰
        $sql .= "   t_aorder_d.num, \n";                    // ����
        $sql .= "   t_aorder_d.trust_cost_price, \n";       // �Ķȸ����ʼ������
        $sql .= "   t_aorder_d.sale_price, \n";             // ���ñ��
        $sql .= "   t_aorder_d.trust_cost_amount, \n";      // ������׳ۡʼ������
        $sql .= "   t_aorder_d.sale_amount, \n";            // ����׳�
        $sql .= "   t_aorder_d.egoods_cd, \n";              // �����ʥ�����
        $sql .= "   t_aorder_d.egoods_name, \n";            // ������̾
        $sql .= "   t_aorder_d.egoods_num, \n";             // �����ʿ���
        $sql .= "   t_aorder_d.rgoods_cd, \n";              // ���ξ��ʥ�����
        $sql .= "   t_aorder_d.rgoods_name, \n";            // ���ξ���̾
        $sql .= "   t_aorder_d.rgoods_num \n";              // ���ξ��ʿ���
        $sql .= "FROM \n";
        $sql .= "   t_aorder_d \n";
        $sql .= "WHERE \n";
        $sql .= "   t_aorder_d.aord_id IN (";
        foreach ($page_data_h as $key_h => $value_h){
        $sql .= $value_h["aord_id"];  // ����إå��������Ƥμ���ID
        $sql .= ($key_h+1 < $num_h) ? ", " : null;
        }
        $sql .= ") \n";
        $sql .= "ORDER BY \n";
        $sql .= "   t_aorder_d.aord_id, \n";
        $sql .= "   t_aorder_d.line \n";
        $sql .= ";";
        $res_d = Db_Query($db_con, $sql);
        $num_d = pg_num_rows($res_d);
        if ($num_d > 0){
            $page_data_d = Get_Data($res_d, 2, "ASSOC");
        }else{
            $page_data_d = array(null);
        }
    }

}


/****************************/
// POST���˥����å���������
/****************************/
if(count($_POST)>0 && $move_warning == null && $_POST["sum_flg"] != true){
    for($i = 0; $i < $num_h; $i++){
        $con_data["form_slip_check"][$i] = "";
    }
    $con_data["form_slip_all_check"] = "";   
    $form->setConstants($con_data);
}


/****************************/
// html����
/****************************/
/* �����ơ��֥� */
$html_s .= "\n";
$html_s .= "<table>\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td>\n";
// ���̸����ơ��֥�
$html_s .= Search_Table($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥�
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">��ɼ�ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_no"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_display"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear"]]->toHtml()."\n";
$html_s .= "</td></tr></table>\n";
$html_s .= "        </td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";


/****************************/
// ɽ���ǡ�������
/****************************/
// ��ۤ�����ξ��˥������ʸ�������֤ˤ���ؿ�
function Font_Color($num, $dot = 0){
    return ((int)$num < 0) ? "<font style=\"color: #ff0000;\">".number_format($num, $dot)."</font>" : number_format($num, $dot);
}

// ���顼�Τʤ����
if ($post_flg == true && $err_flg != true){

    /****************************/
    // �����ι�פ򻻽�
    /****************************/
    if ($num_h > 0){
        foreach ($page_data_h as $key_h => $value_h){
            $sum_net_amount     += $value_h["net_amount"];
            $sum_tax_amount     += $value_h["tax_amount"];
            $sum_net_tax_amount += $value_h["net_tax_amount"];
        }
    }

    /****************************/
    // �ե�����ưŪ���ʺ���
    /****************************/
    // ���ALL�����å�
    $form->addElement("checkbox", "form_slip_all_check", "", "���",
        "onClick=\"javascript:All_check('form_slip_all_check','form_slip_check',$num_h)\""
    );
    // �إå����ǡ�����1��ʾ夢����
    if ($num_h > 0){
        // �������å�
        foreach ($page_data_h as $key_h => $value_h){
            $con_data = "";
            // ����ID��hidden���ɲ�
            $form->addElement("hidden","output_id_array[$key_h]");                      // ������ID����
            $con_data["output_id_array[$key_h]"] = $page_data_h[$key_h]["aord_id"];     // ����ID
            // �������å��ܥå���
            $form->addElement("checkbox", "form_slip_check[$key_h]","","","","");
            $form->setConstants($con_data);
        }
    }

    /****************************/
    // html�����������
    /****************************/
    // �Կ��������
    $row_col = "Result2";

    // ��No.�������
    $row_num = ($_POST["f_page1"] != null && $_POST["form_display"] == null) ? ($_POST["f_page1"]-1) * $range : 0;

    /****************************/
    // html����
    /****************************/
    // ���ɽ��/�ڡ���ʬ��
    $range = ($range == null) ? $num_h : $range;
    $html_page  = Html_Page2($total_count, $page_count, 1, $range);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $range);

    // ���٥ǡ��� �󥿥��ȥ�
    $html_1  = "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
    $html_1 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_1 .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_arrival_day")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_client_name")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_round_staff")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">��ȴ���</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">��ɼ���</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�����ʬ</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�����ӥ�������<br>�����ӥ�̾</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">���ʥ�����<br>����̾</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�Ķȸ���<br>���ñ��</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">������׳�<br>����׳�</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�����ʥ�����<br>������̾</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">���ξ��ʥ�����<br>���ξ���̾</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�ѹ�</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\" width=\"150\">";
    $html_1 .=              $form->_elements[$form->_elementIndex["form_slip_all_check"]]->toHtml();
    $html_1 .= "        </td>\n";
    $html_1 .= "    </tr>\n";

    // �إå����ǥ롼��
    if ($num_h > 0){
    foreach ($page_data_h as $key_h => $value_h){

        $row_col = ($row_col == "Result2") ? "Result1" : "Result2";  // 1->2, 2->1
        $href    = FC_DIR."sale/2-2-106.php?aord_id[0]=".$value_h["aord_id"]."&back_display=round_act"; // ��������

        // ���٥ǡ��� �ǡ�������1���ܤΤ߽��Ϥ���إå����ǡ��� ����1
        $html_1 .= "    <tr class=\"$row_col\">\n";
        $html_1 .= "        <td align=\"right\">".++$row_num."</td>\n";                                                 // No.
        $html_1 .= "        <td align=\"center\">".$value_h["ord_no"]."</td>\n";                                        // ��ɼ�ֹ�
        $html_1 .= "        <td align=\"center\">".$value_h["ord_time"]."</td>\n";                                      // ͽ������
        $html_1 .= "        <td>".$value_h["client_cd"]."<br>".htmlspecialchars($value_h["client_cname"])."<br></td>\n";// ������
        if ($value_h["charge_cd"] != null){
        $html_1 .= "        <td>".$value_h["charge_cd"]." : ".htmlspecialchars($value_h["staff_name"])."</td>\n";       // ���ô����
        }else{
        $html_1 .= "        <td></td>\n";
        }
        $html_1 .= "        <td align=\"right\">".Font_Color($value_h["net_amount"])."</td>\n";                         // ��ȴ���
        $html_1 .= "        <td align=\"right\">".Font_Color($value_h["tax_amount"])."</td>\n";                         // ������
        $html_1 .= "        <td align=\"right\">".Font_Color($value_h["net_tax_amount"])."</td>\n";                     // ��ɼ���

        $line_cnt = 0;
        // �ǡ������ǥ롼��
        foreach ($page_data_d as $key_d => $value_d){
            // �إå����롼�פμ���ID�ȥǡ������롼�פμ���ID��Ʊ�����ʳ�����ɼ�Υǡ������Ǥ������
            if ($value_h["aord_id"] == $value_d["aord_id"]){
                // �ǡ������롼�פ�1���ܤǤʤ����
                //if ($value_d["line"] != "1"){
                if ($line_cnt != 0){
                    // ��td�����֡�8�ġ�
                    $html_1 .= "    <tr class=\"$row_col\">\n";
                    for ($i=0; $i<8; $i++){
                        // ���٥ǡ��� �إå�������Ϥ��ʤ��ǡ������ǡ��� ����1��2���ܰʹߤΥǡ������ǡ�����
                        $html_1 .= "        <td></td>\n";
                    }
                }
                // ���٥ǡ��� �ǡ������ǡ���
                $html_1 .= "        <td align=\"center\">".$value_d["sale_div_cd"]."</td>\n";                           // �����ʬ
                $html_1 .= "        <td>\n";
                $html_1 .= "            ".$value_d["serv_print_flg"]."��".$value_d["serv_cd"]."<br>\n";                 // ����/�����ӥ�������
                $html_1 .= "            ".htmlspecialchars($value_d["serv_name"])."<br>\n";                             // �����ӥ�̾
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td>\n";
                $html_1 .= "            ".$value_d["goods_print_flg"]."��".$value_d["goods_cd"]."<br>\n";               // ���ʥ�����
                $html_1 .= "            ".htmlspecialchars($value_d["official_goods_name"])."<br>\n";                   // ����̾
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td align=\"right\">".$value_d["set_flg"].$value_d["num"]."</td>\n";                // �켰/����
                $html_1 .= "        <td align=\"right\">\n";
                $html_1 .= "            ".Font_Color($value_d["trust_cost_price"], 2)."<br>\n";                         // �Ķȸ����ʼ������
                $html_1 .= "            ".Font_Color($value_d["sale_price"], 2)."<br>\n";                               // ���ñ��
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td align=\"right\">\n";
                $html_1 .= "            ".Font_Color($value_d["trust_cost_amount"])."<br>\n";                           // ������׳ۡʼ������
                $html_1 .= "            ".Font_Color($value_d["sale_amount"])."<br>\n";                                 // ����׳�
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td>\n";
                $html_1 .= "            ".$value_d["egoods_cd"]."<br>\n";                                               // �����ʥ�����
                $html_1 .= "            ".htmlspecialchars($value_d["egoods_name"])."<br>\n";                           // ������̾
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td align=\"right\">".$value_d["egoods_num"]."</td>\n";                             // ����
                $html_1 .= "        <td>\n";
                $html_1 .= "            ".$value_d["rgoods_cd"]."<br>\n";                                               // ���ξ��ʥ�����
                $html_1 .= "            ".htmlspecialchars($value_d["rgoods_name"])."<br>\n";                           // ���ξ���̾
                $html_1 .= "        </td>\n";
                $html_1 .= "        <td align=\"right\">".$value_d["rgoods_num"]."</td>\n";                             // ����
                // �ǡ������롼�פ�1���ܤξ��
                //if ($value_d["line"] == "1"){
                if ($line_cnt == 0){
                    $html_1 .= "        <td align=\"center\"><a href=\"$href\">�ѹ�</a></td>\n";                        // �ѹ����
                    $html_1 .= "        <td align=\"center\">\n";                                                       // �������å��ܥå���
                    $html_1 .= "            ".$form->_elements[$form->_elementIndex["form_slip_check[$key_h]"]]->toHtml()."\n";
                    $html_1 .= "        </td>\n";
                // �ǡ������롼�פ�2���ܰʹߤξ��
                }else{
                    // ��td�����֡�2�ġ�
                    for ($i=0; $i<2; $i++){
                        // ���٥ǡ��� �إå�������Ϥ��ʤ��ǡ������ǡ��� ����2��2���ܰʹߤΥǡ������ǡ�����
                        $html_1 .= "        <td></td>\n";
                    }
                }
                $html_1 .= "    </tr>\n";
                $line_cnt++;
            }
        }

        // �ݡ�����ι�׻���
        switch ($value_h["trade_cd"]){
            case "11":
            case "15":
            case "13":
            case "14":
                $kake_nuki_amount   += $value_h["net_amount"];
                $kake_tax_amount    += $value_h["tax_amount"];
                $kake_komi_amount   += $value_h["net_tax_amount"];
                break;
            case "61":
            case "63":
            case "64":
                $genkin_nuki_amount += $value_h["net_amount"];
                $genkin_tax_amount  += $value_h["tax_amount"];
                $genkin_komi_amount += $value_h["net_tax_amount"];
                break;
        }

    }
    }

    // �ǽ���
    $html_1 .= "    <tr class=\"Result3\">\n";
    for ($i=0; $i<5; $i++){
        $html_1 .= "        <td></td>\n";
    }
    $html_1 .= "        <td align=\"right\">".Font_Color($sum_net_amount)."</td>";
    $html_1 .= "        <td align=\"right\">".Font_Color($sum_tax_amount)."</td>";
    $html_1 .= "        <td align=\"right\">".Font_Color($sum_net_tax_amount)."</td>";
    for ($i=0; $i<11; $i++){
        $html_1 .= "        <td></td>\n";
    }
    $html_1 .= "        <td align=\"center\">".$form->_elements[$form->_elementIndex["form_sum"]]->toHtml()."</td>\n";
    $html_1 .= "    </tr>\n";

    $html_1 .= "</table>\n";

    // ���
    $html_2 .= "<table>\n";
    $html_2 .= "<table class=\"List_Table\" border=\"1\" width=\"500\" align=\"right\">\n";
    $html_2 .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"100\" align=\"right\">\n";
    $html_2 .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"100\" align=\"right\">\n";
    $html_2 .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"100\" align=\"right\">\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($money1)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_tax1)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_money1)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($money2)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_tax2)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td> \n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_money2)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">��ȴ���</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($money3)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">�����ǹ��</td>\n";
    $html_2 .= "        <td align=\"right\">".Font_Color($total_tax3)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">�ǹ����</td> \n";
    $html_2 .= "        <td align=\"right\">".Font_Color($money3 + $total_tax3)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";

    // �ޤȤ�
    $html_l  = "<table width=\"100%\">\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .=              $html_page;
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .=              $html_1;
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .=              $html_2;
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .=              $html_page2;
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .= "<A NAME=\"sum\">\n";
    $html_l .= "<table align=\"right\">\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>\n";
    $html_l .= $form->_elements[$form->_elementIndex["form_confirm"]]->toHtml();
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "</table>\n";
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "</table>\n";

}


/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼����
/****************************/
//$page_menu = Create_Menu_f('sale','2');

/****************************/
// ���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[kakutei_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[act_button]]->toHtml();
$page_header = Create_Header($page_title);


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_sale'    => "$error_sale",
    'auth_r_msg'    => "$auth_r_msg",
    'ord_time_err'  => "$ord_time_err",
    'ord_time_itaku_err'    => "$ord_time_itaku_err",
    'trust_confirm_err'     => "$trust_confirm_err",
    'del_err'       => "$del_err",
    'move_warning'  => "$move_warning",
    'group_kind'    => "$group_kind",

    // �������顼��å�����
    "trust_confirm_err"         => "$trust_confirm_err",    // ���˽����𤵤�Ƥ��ʤ��������å�
    "ord_time_itaku_err"        => "$ord_time_itaku_err",   // ����������å���ʰ����褬��������Ф��Ʒ��äƤ���������Ǥ��ʤ��Τǡ�
    "ord_time_start_err"        => "$ord_time_start_err",   // �����ƥ೫���������å�
    "del_err"                   => "$del_err",              // �������Ƥ��뤫�����å�
    "ord_time_err"              => "$ord_time_err",         // ����������å���ʼ�ʬ����������Ф��Ʒ��äƤ�������
    "claim_day_bill_err"        => "$claim_day_bill_err",   // ��������������ʹߤ������å�
    "error_sale"                => "$error_sale",           // �ֹ椬��ʣ�������
    "err_future_date_msg"       => "$err_future_date_msg",  // ͽ��������̤�����դξ��Υ��顼

    // �������顼����ɼ�ֹ�
    "trust_confirm_no"          => $trust_confirm_no,
    "ord_time_itaku_no"         => $ord_time_itaku_no,
    "ord_time_start_no"         => $ord_time_start_no,
    "del_no"                    => $del_no,
    "ord_time_no"               => $ord_time_no,
    "claim_day_bill_no"         => $claim_day_bill_no,
    "err_sale_no"               => $err_sale_no,
    "ary_future_date_no"        => $ary_future_date_no,
));

$smarty->assign("html_s",$html_s);
$smarty->assign("html_l",$html_l);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
