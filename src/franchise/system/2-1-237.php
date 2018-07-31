<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/09      03-040      kajioka-h   ��å�󥯤�ɽ����､��
 *  2006/11/11      03-042      kajioka-h   ��α���������Τ�ɽ�����ʤ��褦�˽���
 *  2006/11/13      03-036      kajioka-h   ��ǧ�������˾�ǧ����Ƥ��ʤ��������å������ɲ�
 *                  03-037      kajioka-h   ��û������˼�ä���Ƥ��ʤ��������å������ɲ�
 *                  03-038      kajioka-h   ��ǧ�������˼�ä���Ƥ��ʤ��������å������ɲ�
 *                  03-039      kajioka-h   ��û�������������������Ƥ��ʤ��������å������ɲ�
 *  2007/01/06      xx-xxx      kajioka-h   �����ɼ�������谸�ˤ������ξ����Ĥ������ɲ�
 *  2007/02/21      xx-xxx      watanabe-k  ���ܽв��Ҹˤ�����Ҹˤ��ѹ�
 *  2007/02/27      ��ȹ���67  fukuda-s    ������ܺٽ���
 *  2007/03/05      ��ȹ���67  fukuda-s    ��۹�׽���
 *  2007/03/05      ��ȹ���12  �դ���      �ݡ�����ι�פ����
 *  2007/03/22                  �դ���      ��α����ե饰�����ե饰���ѹ�
 *  2007/03/26      �׷�12      kajioka-h   ��ǧ������ʬ�� include/fc_sale_accept.inc �˽Ф���
 *  2007/04/05      ����¾25    kajioka-h   ��������Ҳ����������λ���������Υ����å������ɲ�
 *  2007-04-12                  fukuda      ����������������ɲ�
 *  2007/05/23      xx-xxx      kajioka-h   �����ɼ�θ�������ǽ�ˤ�ꡢ���顼��å������ɲ�
 *  2007/06/14      ����¾14    kajioka-h   ���������ͽ������ != �������ξ�票�顼��å������ɲ�
 *                  xx-xxx      kajioka-h   �����ʬ��05������  06��������¾  ���ѹ�
 *  2007-06-22                  fukuda      �����ơ��֥�ˡּ����ʬ�פ�����ɲ�
 *  2007/06/25                  fukuda      ��ǧ����ͽ��������̤��ξ��ϥ��顼
 *  2007/07/27                  kajioka-h   ����饤����Ԥμ�û��ˡ�����������������������褦���ѹ�
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
    "form_display_num"      => "1", 
    "form_attach_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""), 
    "form_claim"            => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_round_day"        => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_claim_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "",  "ed" => ""),
    "form_charge_fc"        => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_slip_no"          => array("s" => "", "e" => ""), 
    "form_contract_div"     => "1",
    "form_confirm_flg"      => "1",
);

$ary_pass_list = array(
    "hdn_cancel_id"     => "",
);

// �����������
Restore_Filter2($form, "sale", "form_display", $ary_form_list, $ary_pass_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];    //������ID
$staff_id   = $_SESSION["staff_id"];     //�������ID
$staff_name = addslashes($_SESSION["staff_name"]);   //�������̾
$group_kind = $_SESSION["group_kind"];   //�ܵҶ�ʬ


/****************************/
// ���������
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
// �����������å�
/****************************/
//FCȽ��
if ($group_kind != "2"){
    //FC�ʳ��ϡ�TOP������
    header("Location: ".FC_DIR."top.php");
    exit;
}


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
$form->removeElement("form_attach_branch");
$form->removeElement("form_round_staff");
$form->removeElement("form_multi_staff");
$form->removeElement("form_part");
$form->removeElement("form_ware");

/* �⥸�塼����̥ե����� */
// ��ɼ�ֹ�ʳ��ϡ���λ��
$obj    =   null;
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "��");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_slip_no", "", "");

// �����ʬ
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",           "1");
$obj[]  =&  $form->createElement("radio", null, null, "����饤�����", "3");
$obj[]  =&  $form->createElement("radio", null, null, "���ե饤�����", "4");
$form->addGroup($obj, "form_contract_div", "", "");

// ��ǧ����
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤��ǧ", "2");
$obj[]  =&  $form->createElement("radio", null, null, "��ǧ��", "3");
$form->addGroup($obj, "form_confirm_flg", "", "");

// �����ȥ��
$ary_sort_item = array(
    "sl_slip"           => "��ɼ�ֹ�",
    "sl_arrival_day"    => "ͽ������",
    "sl_claim_day"      => "������",
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_act_client_cd"  => "����襳����",
    "sl_act_client_name"=> "�����̾",
    "sl_round_staff"    => "���ô����<br>�ʥᥤ�󣱡�",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_client_cd");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

// ���ꥢ
$form->addElement("button", "form_clear", "���ꥢ", "onClick=\"javascript: location.href='".$_SERVER["PHP_SELF"]."'\"");

// ��ץܥ���
$form->addElement("button", "form_sum", "�硡��",
    "onClick=\"javascript: Button_Submit('sum_flg', '".$_SERVER["PHP_SELF"]."#sum', true);\""
);

// ��ǧ�ܥ���
$form->addElement("button", "form_confirm", "����ǧ", 
    "onClick=\"javascript: Button_Submit('confirm_flg', '".$_SERVER["PHP_SELF"]."', true)\" $disabled"
);

// �إå����ѥܥ��� ͽ����ɼ������
$form->addElement("button", "kakutei_button", "ͽ����ɼ������", "onClick=\"location.href='../sale/2-2-206.php'\"");

// �إå����ѥܥ��� �������
$form->addElement("button", "act_button", "�������", "$g_button_color onClick=\"location.href='2-1-237.php'\"");

// �����ե饰
$form->addElement("hidden","confirm_flg");                  //��ǧ�ե饰
$form->addElement("hidden","hdn_cancel_id");                //������ID
$form->addElement("hidden","sum_flg");                      //��ץե饰


/***************************/
// ��å�󥯤������줿���
/***************************/
if($_POST["hdn_cancel_id"] != null){

    $cancel_id = $_POST["hdn_cancel_id"];  //����ID

    Db_Query($db_con, "BEGIN");

    $sql = "SELECT contract_div, trust_confirm_flg FROM t_aorder_h WHERE aord_id = $cancel_id;";
    $result = Db_Query($db_con, $sql);
    $contract_div       = pg_fetch_result($result, 0, "contract_div");
    $trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg");

    //����饤����ԤǤ��Ǥ˼�ä���Ƥ���ʥ��ե饤��ξ��ϸ御���Τ���Ƚ�ꤷ�ʤ���
    if($contract_div == "2" && $trust_confirm_flg == "f"){
        $cancel_err = "��ä���Ƥ��뤿�ᡢ��äǤ��ޤ���";
        Db_Query($db_con, "ROLLBACK;");

    //
    }else{

        //���쥳���ɤ����뤫�����å�
        $sql = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $cancel_id;";
        $result = Db_Query($db_con, $sql);
        if(pg_num_rows($result) != 0){
            $renew_flg = pg_fetch_result($result, 0, "renew_flg");
            //������������Ƥ���
            if($renew_flg == "t"){
                $renew_err = "������������Ƥ��뤿�ᡢ��äǤ��ޤ���";
                Db_Query($db_con, "ROLLBACK;");
            }
        }

        //������������Ƥ��ʤ� or ���쥳���ɤ��ʤ��ʥ���饤���̤��ǧ��
        if($renew_err == null){

            //���ǡ������ƺ��SQL
            $sql  = "DELETE FROM t_sale_h ";
            $sql .= "WHERE";
            $sql .= "   sale_id = $cancel_id;";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            //������������������
            $sql  = "DELETE FROM t_sale_h \n";
            $sql .= "WHERE \n";
            $sql .= "    aord_id = $cancel_id \n";
            $sql .= "    AND act_request_flg = true \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            //����إå��γ���ե饰��false
            $sql  = "UPDATE t_aorder_h SET";
            $sql .= "   confirm_flg = 'f',";         //����ե饰
            $sql .= "   trust_confirm_flg = 'f',";   //����ե饰(����)
            $sql .= "   cancel_flg = 't',";          //��åե饰
            $sql .= "   ps_stat = '1' ";             //��������
            $sql .= "WHERE";
            $sql .= "   aord_id = $cancel_id;";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            Db_Query($db_con, "COMMIT");

            $post_flg       = true;                  //POST�ե饰

            $con_data["hdn_cancel_id"] = "";         //�����
            $form->setConstants($con_data);
        }
    }
}


/****************************/
// ��ץܥ��󲡲���
/****************************/
if ($_POST["sum_flg"] == "true"){

    $con_data["sum_flg"] = "";   //��ץܥ�������

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
// ��ǧ�ܥ��󲡲�����
/****************************/
if($_POST["confirm_flg"] == "true"){

    $con_data["confirm_flg"] = "";   // ��ǧ�ܥ�������

    $output_id_array = $_POST["output_id_array"];  //����ID����
    $check_num_array = $_POST["form_slip_check"];  //��ɼ�����å�

    //��ɼ�˥����å���������˹Ԥ�
    if($check_num_array != NULL){
        $aord_array = NULL;    //��ɼ���ϼ���ID����
        while($check_num = each($check_num_array)){
            //����ź���μ���ID����Ѥ���
            $check = $check_num[0];

            //̤��ǧ�ԤΤ�������ɲ�
            if($check_num[1] != NULL){
                $aord_array[] = $output_id_array[$check];
            }
        }
    }

    require(INCLUDE_DIR."fc_sale_accept.inc");

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
    $_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num        = $_POST["form_display_num"];
    $client_branch      = $_POST["form_client_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $round_day_sy       = $_POST["form_round_day"]["sy"];
    $round_day_sm       = $_POST["form_round_day"]["sm"];
    $round_day_sd       = $_POST["form_round_day"]["sd"];
    $round_day_ey       = $_POST["form_round_day"]["ey"];
    $round_day_em       = $_POST["form_round_day"]["em"];
    $round_day_ed       = $_POST["form_round_day"]["ed"];
    $claim_day_sy       = $_POST["form_claim_day"]["sy"];
    $claim_day_sm       = $_POST["form_claim_day"]["sm"];
    $claim_day_sd       = $_POST["form_claim_day"]["sd"];
    $claim_day_ey       = $_POST["form_claim_day"]["ey"];
    $claim_day_em       = $_POST["form_claim_day"]["em"];
    $claim_day_ed       = $_POST["form_claim_day"]["ed"];
    $charge_fc_cd1      = $_POST["form_charge_fc"]["cd1"];
    $charge_fc_cd2      = $_POST["form_charge_fc"]["cd2"];
    $charge_fc_name     = $_POST["form_charge_fc"]["name"];
    $charge_fc_select   = $_POST["form_charge_fc"]["select"]["1"];
    $slip_no_s          = $_POST["form_slip_no"]["s"];
    $slip_no_e          = $_POST["form_slip_no"]["e"];
    $contract_div       = $_POST["form_contract_div"];
    $confirm_flg        = $_POST["form_confirm_flg"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // �ܵ�ô����Ź
    $sql .= ($client_branch != null) ? "AND t_client.charge_branch_id = $client_branch \n" : null;
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
    // �����襳���ɣ�
    $sql .= ($claim_cd1 != null) ? "AND t_client_claim.client_cd1 LIKE '$claim_cd1%' \n" : null; 
    // �����襳���ɣ�
    $sql .= ($claim_cd2 != null) ? "AND t_client_claim.client_cd2 LIKE '$claim_cd2%' \n" : null; 
    // ������̾
    if ($claim_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_client_claim.client_name  LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client_claim.client_name2 LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client_claim.client_cname LIKE '%$claim_name%' \n";
        $sql .= "   ) \n";
    }
    // ͽ�������ʳ��ϡ�
    $round_day_s = $round_day_sy."-".$round_day_sm."-".$round_day_sd;
    $sql .= ($round_day_s != "--") ? "AND t_aorder_h.ord_time >= '$round_day_s' \n" : null;
    // ͽ�������ʽ�λ��
    $round_day_e = $round_day_ey."-".$round_day_em."-".$round_day_ed;
    $sql .= ($round_day_e != "--") ? "AND t_aorder_h.ord_time <= '$round_day_e' \n" : null;
    // �������ʳ��ϡ�
    $claim_day_s  = $claim_day_sy."-".$claim_day_sm."-".$claim_day_sd;
    $sql .= ($claim_day_s != "--") ? "AND t_aorder_h.arrival_day >= '$claim_day_s' \n" : null;
    // �������ʽ�λ��
    $claim_day_e  = $claim_day_ey."-".$claim_day_em."-".$claim_day_ed;
    $sql .= ($claim_day_e != "--") ? "AND t_aorder_h.arrival_day <= '$claim_day_e' \n" : null;
    // ������FC�����ɣ�
    $sql .= ($charge_fc_cd1 != null) ? "AND t_aorder_h.act_cd1 LIKE '$charge_fc_cd1%' \n" : null;
    // ������FC�����ɣ�
    $sql .= ($charge_fc_cd2 != null) ? "AND t_aorder_h.act_cd2 LIKE '$charge_fc_cd2%' \n" : null;
    // ������FC̾
    if ($charge_fc_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_act_client.client_name  LIKE '%$charge_fc_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_act_client.client_name2 LIKE '%$charge_fc_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_act_client.client_cname LIKE '%$charge_fc_name%' \n";
        $sql .= "   ) \n";
    }
    // ������FC���쥯��
    $sql .= ($charge_fc_select != null) ? "AND t_aorder_h.act_id = $charge_fc_select \n" : null;
    // ��ɼ�ֹ�ʳ��ϡ�
    $sql .= ($slip_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null; 
    // ��ɼ�ֹ�ʽ�λ��
    $sql .= ($slip_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null; 
    // �����ʬ
    if ($contract_div == "2"){
        $sql .= "AND t_aorder_h.contract_div = '1' \n";
    }elseif ($contract_div == "3"){
        $sql .= "AND t_aorder_h.contract_div = '2' \n";
    }elseif ($contract_div == "4"){
        $sql .= "AND t_aorder_h.contract_div = '3' \n";
    }
    // ��ǧ����
    if ($confirm_flg == "2"){
        $sql .= "AND t_aorder_h.confirm_flg = 'f' \n";
    }elseif ($confirm_flg == "3"){
        $sql .= "AND t_aorder_h.confirm_flg = 't' \n";
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql; 


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // ��ɼ�ֹ�
        case "sl_slip":
            $sql .= "   ord_no, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time \n";
            break;
        // ͽ������
        case "sl_arrival_day":
            $sql .= "   ord_time, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_no \n";
            break;
        // ������
        case "sl_claim_day":
            $sql .= "   arrival_day, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // �����襳����
        case "sl_client_cd":
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // ������̾
        case "sl_client_name":
            $sql .= "   client_cname, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // ����襳����
        case "sl_act_client_cd":
            $sql .= "   act_cd, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // �����̾
        case "sl_act_client_name":
            $sql .= "   act_name, \n";
            $sql .= "   act_cd, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   charge_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
            break;
        // ���ô���ԡʥᥤ�󣱡�
        case "sl_round_staff":
            $sql .= "   charge_cd, \n";
            $sql .= "   client_cd, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   ord_no \n";
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

    // ����饤�����
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                // ����ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                 // �����ֹ�
    $sql .= "   t_staff_main.charge_cd, \n";                                            // ô����CD1
    $sql .= "   t_staff_main.staff_name, \n";                                           // ô����̾1
    $sql .= "   t_aorder_h.ord_time, \n";                                               // ͽ������
    $sql .= "   t_aorder_h.client_cname, \n";                                           // ά��
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";// ������CD
    $sql .= "   t_act_client.client_cd1 || '-' || t_act_client.client_cd2 AS act_cd, \n";   // �����CD
    $sql .= "   t_act_client.client_cname AS act_name, \n";                                 // �����̾
    $sql .= "   CASE t_aorder_h.confirm_flg \n";
    $sql .= "       WHEN 't' THEN '��ǧ' \n";
    $sql .= "       WHEN 'f' THEN '̤��ǧ' \n";
    $sql .= "   END \n";
    $sql .= "   AS confirm_flg, \n";                                                    // ����ե饰
    $sql .= "   '����' AS contract_div, \n";                                            // �����ʬ
    $sql .= "   t_trade.trade_cd, \n";                                                  // �����ʬ������
    $sql .= "   t_trade.trade_name, \n";                                                // �����ʬ
    $sql .= "   t_sale_h.renew_flg, \n";                                                // ���������ե饰
    $sql .= "   t_aorder_h.arrival_day, \n";                                            // ������
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS claim_cd, \n";     // �����襳����
    $sql .= "   t_client.client_cname AS claim_cname, \n";                              // ������̾
    $sql .= "   t_aorder_h.net_amount, \n";                                             // ��ȴ���
    $sql .= "   t_aorder_h.tax_amount, \n";                                             // ������
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount, \n";   // ��۹��
    $sql .= "   t_trade.trade_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff_main \n";
    $sql .= "   ON t_staff_main.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_sale_h ON t_sale_h.sale_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade  ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "   LEFT JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_act_client   ON t_aorder_h.act_id = t_act_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.trust_confirm_flg = 't' \n";
//    $sql .= "AND \n";
//    $sql .= "   t_aorder_h.ps_stat = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 'f' \n";
    $sql .= $where_sql;

    $sql .= "UNION \n";

    // ���ե饤�����
    $sql .= "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                // ����ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                 // �����ֹ�
    $sql .= "   t_staff_main.charge_cd, \n";                                            // ô����CD1
    $sql .= "   t_staff_main.staff_name, \n";                                           // ô����̾1
    $sql .= "   t_aorder_h.ord_time, \n";                                               // ͽ������
    $sql .= "   t_aorder_h.client_cname, \n";                                           // ά��
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";// ������CD
    $sql .= "   t_act_client.client_cd1 || '-' || t_act_client.client_cd2 AS act_cd, \n";   // �����CD
    $sql .= "   t_act_client.client_cname AS act_name, \n";                                 // �����̾
    $sql .= "   CASE t_aorder_h.confirm_flg \n";
    $sql .= "       WHEN 't' THEN '��ǧ' \n";
    $sql .= "       WHEN 'f' THEN '̤��ǧ' \n";
    $sql .= "   END \n";
    $sql .= "   AS confirm_flg, \n";                                                    // ����ե饰
    $sql .= "   '����' AS contract_div, \n";                                            // �����ʬ
    $sql .= "   t_trade.trade_cd, \n";                                                  // �����ʬ������
    $sql .= "   t_trade.trade_name, \n";                                                // �����ʬ
    $sql .= "   t_sale_h.renew_flg, ";                                                  // ���������ե饰
    $sql .= "   t_aorder_h.arrival_day, \n";                                            // ������
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS claim_cd, \n";     // �����襳����
    $sql .= "   t_client.client_cname AS claim_cname, \n";                              // ������̾
    $sql .= "   t_aorder_h.net_amount, \n";                                             // ��ȴ���
    $sql .= "   t_aorder_h.tax_amount, \n";                                             // ������
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount, \n";   // ������
    $sql .= "   t_trade.trade_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff_main \n";
    $sql .= "   ON t_staff_main.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_sale_h ON t_sale_h.sale_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade  ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "   LEFT JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_act_client   ON t_aorder_h.act_id = t_act_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 'f' \n";
    $sql .= $where_sql;

    // �����Ƚ�
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
        $sql .= "   t_aorder_d.cost_price, \n";             // �Ķȸ���
        $sql .= "   t_aorder_d.sale_price, \n";             // ���ñ��
        $sql .= "   t_aorder_d.cost_amount, \n";            // ������׳�
        $sql .= "   t_aorder_d.sale_amount, \n";            // ����׳�
        $sql .= "   t_aorder_d.egoods_cd, \n";              // �����ʥ�����
        $sql .= "   t_aorder_d.egoods_name, \n";            // ������̾
        $sql .= "   t_aorder_d.egoods_num, \n";             // �����ʿ���
        $sql .= "   t_aorder_d.rgoods_cd, \n";              // ���ξ��ʥ�����
        $sql .= "   t_aorder_d.rgoods_name, \n";            // ���ξ���̾
        $sql .= "   t_aorder_d.rgoods_num, \n";             // ���ξ��ʿ���
        $sql .= "   t_aorder_d.advance_offset_amount \n";   // �����껦��
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
// html
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
$html_s .= "        <td class=\"Td_Search_3\">�����ʬ</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_contract_div"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "        <td class=\"Td_Search_3\">��ǧ����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_confirm_flg"]]->toHtml()."</td>\n";
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

// ɽ���ե饰true�����ĥ��顼�Τʤ����
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
    // ��ǧ�����å��ܥå��������ѽ���
    /****************************/
    //�����å��ܥå�����ɽ�����ֹ�����
    $hidden_check = array();

    // �إå����ǥ롼��
    if ($num_h > 0){

        foreach ($page_data_h as $key_h => $value_h){
            // ����ID��hidden���ɲ�
            $form->addElement("hidden","output_id_array[$key_h]");                      // ��ǧ����ID����
            $con_data["output_id_array[$key_h]"] = $page_data_h[$key_h]["aord_id"];     // ����ID
            // ����Ƚ��
            if ($page_data_h[$key_h]["confirm_flg"] != "̤��ǧ"){
                // �����å��ܥå�����ɽ�����ֹ����
                $hidden_check[] = $key_h;
            }
        }

    }

    /****************************/
    // �ե�����ưŪ���ʺ���
    /****************************/
    // ��ǧALL�����å�
    $form->addElement("checkbox", "form_slip_all_check", "", "��ǧ",
        "onClick=\"javascript:All_check('form_slip_all_check','form_slip_check',$num_h)\""
    );

    if ($num_h > 0){
        // ��ǧ�����å�
        foreach ($page_data_h as $key_h => $value_h){
            // ɽ����Ƚ��
            if (!in_array($key_h, $hidden_check)){
                // ̤��ǧ�Ԥϥ����å��ܥå������
                $form->addElement("checkbox", "form_slip_check[$key_h]","","","","");
            }else{
                // ��ǧ�Ԥ���ɽ���ˤ���٤�hidden�����
                $form->addElement("hidden","form_slip_check[$key_h]","");
            }
        }
    }

    /****************************/
    // POST���˥����å���������
    /****************************/
    if(count($_POST) > 0 && $_POST["sum_flg"] != true){
        foreach ($page_data_h as $key_h => $value_h){
            $con_data["form_slip_check"][$key_h]  = "";   
        }
        $con_data["form_slip_all_check"] = "";   
    }
    $form->setConstants($con_data); 

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
    $html_l  = "<table class=\"List_Table\" border=\"1\">\n";
    $html_l .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_l .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\" style=\"width: 60px\" nowrap>";
    $html_l .=              $form->_elements[$form->_elementIndex["form_slip_all_check"]]->toHtml();
    $html_l .= "        </td>\n";
    $html_l .= "        <td class=\"Title_Pink\">���</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_arrival_day")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_claim_day")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_client_name")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_act_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_act_client_name")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">���<br>��ʬ</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_round_staff")."</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����ʬ</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����ʬ</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����ӥ�������<br>�����ӥ�̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">���ʥ�����<br>����̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�Ķȸ���<br>���ñ��</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">������׳�<br>����׳�</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">����<br>�껦��</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">��ȴ���</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">��ɼ���</td>\n";
    $html_l .= "    </tr>\n";

    // �إå����ǥ롼��
    if ($num_h > 0){
    foreach ($page_data_h as $key_h => $value_h){

        $row_col = ($row_col == "Result2") ? "Result1" : "Result2";  // 1->2, 2->1
        $href    = FC_DIR."sale/2-2-106.php?aord_id[0]=".$value_h["aord_id"]."&back_display=round"; // ��������

        // ���٥ǡ��� �ǡ�������1���ܤΤ߽��Ϥ���إå����ǡ��� ����1
        $html_l .= "    <tr class=\"$row_col\">\n";
        $html_l .= "        <td align=\"right\">".++$row_num."</td>\n";                                                 // No.
        $html_l .= "        <td align=\"center\"><a href=\"$href\">".$value_h["ord_no"]."</a></td>\n";                  // ��ɼ�ֹ�
        // ���¤���ܥ���饤���̤��ǧ�ξ��
        if ($disabled == null && $value_h["contract_div"] == "����" && $value_h["confirm_flg"] == "̤��ǧ"){
            $del_link   = "<a href=\"#\" onClick=\"return Dialogue_2('��ä��ޤ���', '".$_SERVER["PHP_SELF"]."', ".$value_h["aord_id"].", 'hdn_cancel_id');\">���</a>";
        }else{
            $del_link   = "";
        }
        $html_l .= "        <td align=\"center\">";                                                                     // ��ǧ�����å��ܥå���
        if ($value_h["confirm_flg"] == "��ǧ"){
            $html_l .=              "��";
        }else{
            $html_l .=              $form->_elements[$form->_elementIndex["form_slip_check[$key_h]"]]->toHtml();
        }
        $html_l .= "        </td>\n";
        $html_l .= "        <td align=\"center\">$del_link</td>\n";                                                     // ��å��
        $html_l .= "        <td align=\"center\">".$value_h["ord_time"]."</td>\n";                                      // ͽ������
        $html_l .= "        <td align=\"center\">".$value_h["arrival_day"]."</td>\n";                                   // ������
        $html_l .= "        <td>".$value_h["client_cd"]."<br>".htmlspecialchars($value_h["client_cname"])."<br></td>\n";// ������
        $html_l .= "        <td>".$value_h["act_cd"]."<br>".htmlspecialchars($value_h["act_name"])."<br></td>\n";       // �����
        $html_l .= "        <td align=\"center\">".$value_h["contract_div"]."</td>\n";                                  // ��Զ�ʬ
        if ($value_h["charge_cd"] != null){
        $html_l .= "        <td>".str_pad($value_h["charge_cd"], 4, "0", STR_PAD_LEFT)." : ".htmlspecialchars($value_h["staff_name"])."</td>\n";       // ���ô����
        }else{
        $html_l .= "        <td></td>\n";
        }
        $html_l .= "        <td>".htmlspecialchars($value_h["trade_name"])."</td>\n";

        $line_cnt = 0;
        // �ǡ������ǥ롼��
        foreach ($page_data_d as $key_d => $value_d){
            // �إå����롼�פμ���ID�ȥǡ������롼�פμ���ID��Ʊ�����ʳ�����ɼ�Υǡ������Ǥ������
            if ($value_h["aord_id"] == $value_d["aord_id"]){
                // �ǡ������롼�פ�1���ܤǤʤ����
                //if ($value_d["line"] != "1"){
                if ($line_cnt != 0){
                    // ��td������
                    $html_l .= "    <tr class=\"$row_col\">\n";
                    for ($i=0; $i<11; $i++){
                        // ���٥ǡ��� �إå�������Ϥ��ʤ��ǡ������ǡ��� ����1��2���ܰʹߤΥǡ������ǡ�����
                        $html_l .= "        <td></td>\n";
                    }
                }
                // ���٥ǡ��� �ǡ������ǡ���
                $html_l .= "        <td align=\"center\">".$value_d["sale_div_cd"]."</td>\n";                           // �����ʬ
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["serv_print_flg"]."��".$value_d["serv_cd"]."<br>\n";                 // ����/�����ӥ�������
                $html_l .= "            ".htmlspecialchars($value_d["serv_name"])."<br>\n";                             // �����ӥ�̾
                $html_l .= "        </td>\n";
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["goods_print_flg"]."��".$value_d["goods_cd"]."<br>\n";               // ����/���ʥ�����
                $html_l .= "            ".htmlspecialchars($value_d["official_goods_name"])."<br>\n";                   // ����̾
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">".$value_d["set_flg"].$value_d["num"]."</td>\n";                // �켰/����
                $html_l .= "        <td align=\"right\">\n";
                $html_l .= "            ".Font_Color($value_d["cost_price"], 2)."<br>\n";                               // �Ķȸ���
                $html_l .= "            ".Font_Color($value_d["sale_price"], 2)."<br>\n";                               // ���ñ��
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">\n";                                                            
                $html_l .= "            ".Font_Color($value_d["cost_amount"])."<br>\n";                                 // ������׳�
                $html_l .= "            ".Font_Color($value_d["sale_amount"])."<br>\n";                                 // ����׳�
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">\n";
                $html_l .= "            ".Numformat_Ortho($value_d["advance_offset_amount"], null, true)."\n";          // �����껦��
                $html_l .= "        </td>\n";
                // �ǡ������롼�פ�1���ܤξ��
                //if ($value_d["line"] == "1"){
                if ($line_cnt == 0){
                    // ���٥ǡ��� �ǡ�������1���ܤΤ߽��Ϥ���إå����ǡ��� ����2
                    $html_l .= "        <td align=\"right\">".Font_Color($value_h["net_amount"])."</td>\n";             // ��ȴ���
                    $html_l .= "        <td align=\"right\">".Font_Color($value_h["tax_amount"])."</td>\n";             // ������
                    $html_l .= "        <td align=\"right\">".Font_Color($value_h["net_tax_amount"])."</td>\n";         // ��ɼ���
                // �ǡ������롼�פ�2���ܰʹߤξ��
                }else{
                    // ��td������
                    for ($i=0; $i<3; $i++){
                        // ���٥ǡ��� �إå�������Ϥ��ʤ��ǡ������ǡ��� ����2��2���ܰʹߤΥǡ������ǡ�����
                        $html_l .= "        <td></td>\n";
                    }
                }
                $html_l .= "    </tr>\n";
                $line_cnt++;
            }
        }

    }
    }

    // �ǽ���
    $html_l .= "    <tr class=\"Result3\">\n";
    $html_l .= "        <td colspan=\"21\" align=\"left\" style=\"padding-left: 82px; color: #0000ff; font-weight: bold;\">\n";
    $html_l .=          $form->_elements[$form->_elementIndex["form_sum"]]->toHtml();
    $html_l .= "        �����å����դ�����ɼ�ζ�ۤ�׻����ޤ�</td>\n";
    $html_l .= "    </tr>\n";

    $html_l .= "</table>\n";

    // ���
    $html_c .= "<table>\n";
    $html_c .= "<table class=\"List_Table\" border=\"1\" width=\"500\" align=\"left\">\n";
    $html_c .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_c .= "<col width=\"100\" align=\"right\">\n";
    $html_c .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_c .= "<col width=\"100\" align=\"right\">\n";
    $html_c .= "<col width=\"100\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_c .= "<col width=\"100\" align=\"right\">\n";
    $html_c .= "    <tr class=\"Result1\">\n";
    $html_c .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($money1)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_tax1)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_money1)."</td>\n";
    $html_c .= "    </tr>\n";
    $html_c .= "    <tr class=\"Result1\">\n";
    $html_c .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($money2)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_tax2)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">������</td> \n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_money2)."</td>\n";
    $html_c .= "    </tr>\n";
    $html_c .= "    <tr class=\"Result1\">\n";
    $html_c .= "        <td class=\"Title_Pink\">��ȴ���</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($money3)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">�����ǹ��</td>\n";
    $html_c .= "        <td align=\"right\">".Font_Color($total_tax3)."</td>\n";
    $html_c .= "        <td class=\"Title_Pink\">�ǹ����</td> \n";
    $html_c .= "        <td align=\"right\">".Font_Color($money3 + $total_tax3)."</td>\n";
    $html_c .= "    </tr>\n";
    $html_c .= "</table>\n";

}

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
//$page_menu = Create_Menu_f('sale','2');

/****************************/
//���̥إå�������
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
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",

    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_buy'     => "$error_buy",
    'error_payin'   => "$error_payin",
    'cancel_err'    => "$cancel_err",
    'renew_err'     => "$renew_err",
    'disabled'      => "$disabled",
    'group_kind'    => "$group_kind",
    'link_next'    => "$link_next",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",

    "err_day_advance_msg"       => "$err_day_advance_msg",

    // ��ǧ�����顼��å�����
    "confirm_err"               => "$confirm_err",
    "del_err"                   => "$del_err",
    "cancel_err"                => "$cancel_err",
    "deli_day_renew_err"        => "$deli_day_renew_err",
    "deli_day_act_renew_err"    => "$deli_day_act_renew_err",
    "deli_day_intro_renew_err"  => "$deli_day_intro_renew_err",
    "claim_day_renew_err"       => "$claim_day_renew_err",
    "claim_day_bill_err"        => "$claim_day_bill_err",
    "pay_day_act_err"           => "$pay_day_act_err",
    "pay_day_intro_renew_err"   => "$pay_day_intro_renew_err",
    "error_buy"                 => "$error_buy",
    "err_trade_advance_msg"     => "$err_trade_advance_msg",
    "err_future_date_msg"       => "$err_future_date_msg",
    "err_advance_fix_msg"       => "$err_advance_fix_msg",
    "err_paucity_advance_msg"   => "$err_paucity_advance_msg",

    // ��ǧ�����顼��ɼ�ֹ�
    "confirm_err_no"            => $confirm_err_no,
    "del_err_no"                => $del_err_no,
    "cancel_err_no"             => $cancel_err_no,
    "deli_day_renew_err_no"     => $deli_day_renew_err_no,
    "deli_day_act_renew_err_no" => $deli_day_act_renew_err_no,
    "deli_day_intro_renew_err_no"=> $deli_day_intro_renew_err_no,
    "claim_day_renew_err_no"    => $claim_day_renew_err_no,
    "claim_day_bill_err_no"     => $claim_day_bill_err_no,
    "pay_day_act_err_no"        => $pay_day_act_err_no,
    "pay_day_intro_renew_err_no"=> $pay_day_intro_renew_err_no,
    "error_buy_no"              => $error_buy_no,
    "ary_trade_advance_no"      => $ary_trade_advance_no,
    "ary_future_date_no"        => $ary_future_date_no,
    "ary_advance_fix_no"        => $ary_advance_fix_no,
    "ary_paucity_advance_no"    => $ary_paucity_advance_no,

));

$smarty->assign("html_s", $html_s);
$smarty->assign("html_l", $html_l);
$smarty->assign("html_c", $html_c);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
