<?php
/**
 * �����ɼ�������
 *
 *
 * �ѹ�����
 *    1.0.0 (2006//) (suzuki takaaki)
 *      ����������
 *    1.0.1 (2006/07/26) (kaji)
 *      ��1�ڡ�����ɽ�������100����ѹ�
 *    (2006/07/27) (watanabe-k)
 *      ��ά��ɽ������褦���ѹ�
 *    1.0.3 (2006/09/06) (kaji)
 *      �������ɼ�ϰ�����ɽ�����ʤ��褦���ѹ�
 *      ����α��ɼ�ѹ��ؤ����ܤ��ѹ�
 *    1.0.4 (2006/09/20) (kaji)
 *      ����������������������������դ������å������ɲ�
 *    1.0.5 (2006/09/30) (kaji)
 *      �����������������������Υǡ��������ä����Υ��顼��å������ѹ�
 *    2006/10/10 (suzuki)
 *      �������ɽ���������ٸ�������ȥ��顼�ˤʤ�Τ���
 *    2006/10/26 (suzuki)
 *      �����Ψ��0%��ô���Ԥ�ɽ������褦���ѹ�
 *      �����ô���ԡʥᥤ��ˤΤ�ɽ��
 *    2006-11-02 ����������ɽ������ʬɽ��<suzuki>
 *    2006-12-04 ������ʬ��̾������̾�Τ����SQL���ѹ�<suzuki>
 *               �������å����դ�����ɼ�ζ�ۤ�ɽ��<suzuki>
 *    2006-12-05 �����ꤵ�줿��ɼ�Ϲ�׶�ۤ�׻����ʤ��褦�˽���<suzuki>
 *    2006/12/14  �ڡ����������� suzuki
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/11      03-017      kajioka-h   �������˥����ƥ೫�������������դ��ʤ��������å��ɲ�
 *                  03-018      kajioka-h   �������˥����ƥ೫�������������դ��ʤ��������å��ɲ�
 *                  03-020      kajioka-h   ����ľ���˳��ꤵ��Ƥ��ʤ��������å������ɲ�
 *                  03-021      kajioka-h   ����ľ������α�������Ƥ��ʤ��������å������ɲ�
 *  2006-12-08      03-0102     suzuki      ���դ򥼥����
 *  2006-12-27                  watanabe-k  ����Ǥθ�����ǽ���ɲ�
 *                  0006        kajioka-h   ����Ǹ�������ȡ�¾�θ�����郎ȿ�Ǥ���ʤ��Х�����
 *                              kajioka-h   �����Ƚ����������ô����CD��������CD����ɼ�ֹ���ѹ�
 *  2007-01-05                  kajioka-h   ����Ǥθ��������������hidden���ʤ��ä��Τ��ɲ�
 *  2007/02/19      �׷�5-1     kajioka-h   ���ʽв�ͽ��Ǻ߸˰�ư̤�»ܤ�ͽ��ǡ��������򤵤�Ƥ������˷ٹ��å�������ɽ����������ɲ�
 *  2007/02/21                  watanage-k  ���ܽв��ҸˤǤϤʤ������Ҹˤ���Ѥ���褦�˽���
 *  2007/02/23      B0702-008   kajioka-h   ����ͽ��в٤Ǻ߸˰�ư�������ɤ�����Ƚ��ߥ�����
 *  2007/03/02                  watanabe-k  �ܥ���̾�Ȳ���̾���ѹ�
 *  2007/03/05      ��ȹ���12  �դ���      �ݡ�����ι�פ����
 *  2007/03/05      B0702-013   kajioka-h   ����ͽ��в٤��Ƥ��ʤ���ɼ����ɼ�ֹ椬��ʣ����ɽ�������Х�����
 *  2007/03/22      �׷�21      kajioka-h   ��α��ʬ�θ�����������ɽ������
 *  2007/03/23                  kajioka-h   ���������ʬ�� include/fc_sale_confirm.inc �˽Ф���
 *  2007/03/27                  watanabe-k  ���ô���ԤΥꥹ�Ȥ򥹥��åեޥ����򸵤˺�������褦�˽���
 *  2007/04/05      ����¾25    kajioka-h   �Ҳ����������λ���������Υ����å������ɲ�
 *  2007-04-09                  fukuda      ����������������ɲ�
 *  2007-04-09                  fukuda      �������ܶ��̲�
 *  2007-04-13                  fukuda      ���ѹ��ץ�󥯤��󥿥��ȥ����ѹ�������פ˽���
 *  2007-04-23      ����¾167   fukuda      ȯ�Ծ����θ������ܤ���������������θ������ܤ��ɲ�
 *  2007-04-23      ����¾167   fukuda      ���˹�碌�ơ��������ɼ����Ф���褦����
 *  2007-06-07                  fukuda      �����ơ��֥�������껦�ۤ��ɲ�
 *  2007-06-20                  fukuda      �����ơ��֥����ǥ����ȵ�ǽ�ɲ�
 *  2007/06/25                  fukuda      �������ͽ��������̤��ξ��ϥ��顼
 *
 */

$page_title = "ͽ����ɼ������";

// �Ķ�����ե�����
require_once("ENV_local.php");

// ��������ؿ����
require_once(PATH ."function/trade_fc.fnc");
require_once(INCLUDE_DIR."common_quickform.inc");

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
    "form_attach_branch"=> "",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_round_staff"  => array("cd" => "", "select" => ""),
    "form_part"         => "",
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_multi_staff"  => "",
    "form_ware"         => "",
    "form_round_day"    => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))),
    "form_claim_day"    => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_slip_type"    => "1",
//    "form_out_state"    => "1",
    "form_slip_state"   => "2",
    "form_slip_no"      => array("s" => "", "e" => ""),
);

// ��ס�����ܥ��󲡲���
if ($_POST["sum_flg"] == "true" || $_POST["confirm_flg"] == "true"){
    // �����å����֤�SESSION���ݻ����Ƥ���
    $_SESSION[Get_Mod_No()]["all"]["form_slip_check"] = $_POST["form_slip_check"];
}

// �����ܻ�
if ($_GET["search"] == "1"){
    // �ݻ����Ƥ�����SESSION��POST�˥��åȤ����Ѥ���������
    $ary_pass_list = array(
        "form_slip_check"   => $_SESSION[Get_Mod_No()]["all"]["form_slip_check"],
    );
}

// �����������
Restore_Filter2($form, "contract", "form_display", $ary_form_list, $ary_pass_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id     = $_SESSION["client_id"];    //������ID
$staff_id    = $_SESSION["staff_id"];     //�������ID
$staff_name  = $_SESSION["staff_name"];   //�������̾


/****************************/
// ���ɽ��
/****************************/
$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form($db_con, $form, $ary_form_list);

// ���ץ⥸�塼��κ��
$form->removeElement("form_charge_fc");

/* �⥸�塼���̥ե����� */
// ��ɼ����
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",      "1");
$obj[]  =&  $form->createElement("radio", null, null, "������ɼ",  "2");
$obj[]  =&  $form->createElement("radio", null, null, "������ɼ",  "3");
$form->addGroup($obj, "form_slip_type", "", "");

/*
// ȯ�Ծ���
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",    "1");
$obj[]  =&  $form->createElement("radio", null, null, "ȯ�Ժ�",  "2");
$obj[]  =&  $form->createElement("radio", null, null, "̤ȯ��",  "3");
$form->addGroup($obj, "form_out_state", "", "");
*/

// �������
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",    "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤����",  "2");
$obj[]  =&  $form->createElement("radio", null, null, "�����",  "3");
$form->addGroup($obj, "form_slip_state", "", "");

// ��ɼ�ֹ�ʳ��ϡ���λ��
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "��");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_slip_no", "", "");

// �����ȥ��
$ary_sort_item = array(
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_slip"           => "��ɼ�ֹ�",
    "sl_arrival_day"    => "���������",
    "sl_round_staff"    => "���ô����<br>�ʥᥤ�󣱡�",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_arrival_day");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// ����ܥ���
$form->addElement("button", "form_confirm", "�Ρ���",
    "onClick=\"javascript: Button_Submit('confirm_flg', '".$_SERVER["PHP_SELF"]."', true);\" $disabled"
);

// ��ץܥ���
$form->addElement("button", "form_sum", "�硡��",
    "onClick=\"javascript: Button_Submit('sum_flg','".$_SERVER["PHP_SELF"]."#sum', true);\""
);

// ͽ����ɼ�������󥯥ܥ���
$form->addElement("button", "comp_button", "ͽ����ɼ������", "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// �������/��������󥯥ܥ���
if ($_SESSION["group_kind"] == "2"){
    $form->addElement("button", "act_button", "�������", "onClick=\"location.href='../system/2-1-237.php'\"");
}else{
    $form->addElement("button", "act_button", "�������", "onClick=\"location.href='../system/2-1-238.php'\"");
}

// �����ե饰
$form->addElement("hidden", "confirm_flg");  // ����ե饰
$form->addElement("hidden", "sum_flg");      // ��ץե饰


/****************************/
// ��ץܥ��󲡲���
/****************************/
if ($_POST["sum_flg"] == "true"){

    $con_data["sum_flg"] = "";   // ��ץܥ�������

    $output_id_array = $_POST["output_id_array"];  // ����ID����
    $check_num_array = $_POST["form_slip_check"];  // ��ɼ�����å�

    // ��ɼ�˥����å���������˹Ԥ�
    if ($check_num_array != null){
        $aord_array = null;    // ��ɼ���ϼ���ID����
        while ($check_num = each($check_num_array)){
            // ����ź���μ���ID����Ѥ���
            $check = $check_num[0];
            if ($check_num[1] == "1"){  // 4/23 fukuda
                $aord_array[] = $output_id_array[$check];
            }
        }
    }

    if (count($aord_array) > 0){

        // �����å��ΤĤ�����ɼ�ǥ롼��
        for ($s = 0; $s < count($aord_array); $s++){
            $aord_text .= $aord_array[$s];
            $aord_text .= ($s+1 < count($aord_array)) ? ", " : null;
        }

        // ��ۥǡ�������
        $sql  = "SELECT \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 11 THEN t_aorder_h.net_amount ELSE 0 END) AS kake_notax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 61 THEN t_aorder_h.net_amount ELSE 0 END) AS genkin_notax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 11 THEN t_aorder_h.tax_amount ELSE 0 END) AS kake_tax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 61 THEN t_aorder_h.tax_amount ELSE 0 END) AS genkin_tax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 11 THEN t_aorder_h.net_amount + t_aorder_h.tax_amount ELSE 0 END) AS kake_ontax, \n";
        $sql .= "   SUM(CASE t_trade.trade_id WHEN 61 THEN t_aorder_h.net_amount + t_aorder_h.tax_amount ELSE 0 END) AS genkin_ontax \n";
        $sql .= "FROM \n";
        $sql .= "   t_aorder_h \n";
        $sql .= "   INNER JOIN t_trade ON t_aorder_h.trade_id = t_trade.trade_id \n";
        $sql .= "WHERE \n";
        $sql .= "   t_aorder_h.aord_id IN ($aord_text) \n";
        $sql .= ";";
        $res = Db_Query($db_con, $sql);
        $money_data = Get_Data($res, 2, "ASSOC");

        // ��۷����ѹ�
        $kake_notax     = $money_data[0]["kake_notax"];
        $genkin_notax   = $money_data[0]["genkin_notax"];
        $kake_tax       = $money_data[0]["kake_tax"];
        $genkin_tax     = $money_data[0]["genkin_tax"];
        $kake_ontax     = $money_data[0]["kake_ontax"];
        $genkin_ontax   = $money_data[0]["genkin_ontax"];
        $notax_amount   = $money_data[0]["kake_notax"] + $money_data[0]["genkin_notax"];
        $tax_amount     = $money_data[0]["kake_tax"]   + $money_data[0]["genkin_tax"];
        $ontax_amount   = $money_data[0]["kake_ontax"] + $money_data[0]["genkin_ontax"];

    }

}


/****************************/
// ����ܥ��󲡲�����
/****************************/
if ($_POST["confirm_flg"] == "true" || $_POST["warn_confirm_flg"] == "true"){

    $con_data["confirm_flg"] = "";                  // ����ܥ�������

    $output_id_array = $_POST["output_id_array"];   // ����ID����
    $check_num_array = $_POST["form_slip_check"];   // ��ɼ�����å�

    $alert_flg = false;

    //��ɼ�˥����å���������˹Ԥ�
    if ($check_num_array != null){
        $aord_array = null;    //��ɼ���ϼ���ID����
        while ($check_num = each($check_num_array)){
            //����ź���μ���ID����Ѥ���
            $check = $check_num[0];
            if ($check_num[1] == "1"){  // 4/23 fukuda
                $aord_array[] = $output_id_array[$check];
            }
        }
    }

    require(INCLUDE_DIR."fc_sale_confirm.inc");

    // ���ꥨ�顼�ե饰
    if (
        $move_warning           != null ||
        $error_pay              != null ||
        $error_buy              != null ||
        $deli_day_renew_err     != null ||
        $deli_day_start_err     != null ||
        $claim_day_renew_err    != null ||
        $claim_day_bill_err     != null ||
        $claim_day_start_err    != null ||
        $confirm_err            != null ||
        $del_err                != null ||
        $buy_err_mess1          != null ||
        $buy_err_mess2          != null ||
        $buy_err_mess3          != null ||
        $err_trade_advance_msg  != null ||
        $err_future_date_msg    != null ||
        $err_advance_fix        != null ||
        $err_paucity_advance_msg!= null
    ){
        $confirm_err_flg = true;
    }

}


/****************************/
// ɽ���ܥ��󲡲���
/****************************/
if ($_POST["form_display"] != null){

    // ����POST�ǡ�����0���
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);
    $_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // �����̥ե���������å�
    Search_Err_Chk($form);

    // �������ֹ�
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
    $_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num        = $_POST["form_display_num"];
    $client_branch      = $_POST["form_client_branch"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $round_staff_cd     = $_POST["form_round_staff"]["cd"];
    $round_staff_select = $_POST["form_round_staff"]["select"];
    $part               = $_POST["form_part"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $multi_staff        = $_POST["form_multi_staff"];
    $ware               = $_POST["form_ware"];
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
    $slip_type          = $_POST["form_slip_type"];
//    $out_state          = $_POST["form_out_state"];
    $slip_state         = $_POST["form_slip_state"];
    $slip_no_s          = $_POST["form_slip_no"]["s"];
    $slip_no_e          = $_POST["form_slip_no"]["e"];

    $post_flg = true; 

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // �ܵ�ô����Ź
    $sql .= ($client_branch != null) ? "AND t_client.charge_branch_id = $client_branch \n" : null;
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
    // ʣ������
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
    // �������ʳ��ϡ�
    $claim_day_s  = $claim_day_sy."-".$claim_day_sm."-".$claim_day_sd;
    $sql .= ($claim_day_s != "--") ? "AND t_aorder_h.arrival_day >= '$claim_day_s' \n" : null;
    // �������ʽ�λ��
    $claim_day_e  = $claim_day_ey."-".$claim_day_em."-".$claim_day_ed;
    $sql .= ($claim_day_e != "--") ? "AND t_aorder_h.arrival_day <= '$claim_day_e' \n" : null;
    // ��ɼ����
    if ($slip_type == "2"){
        $sql .= "AND t_aorder_h.slip_out = '1' \n";
    }else
    if ($slip_type == "3"){
        $sql .= "AND t_aorder_h.slip_out = '2' \n";
    }
/*
    // ȯ�Ծ���
    if ($out_state == "2"){
        $sql .= "AND t_aorder_h.slip_flg = 't' \n";
    }else
    if ($out_state == "3"){
        $sql .= "AND t_aorder_h.slip_flg = 'f' \n";
    }
*/
    // �������
    if ($slip_state == "2"){
        $sql .= "AND t_aorder_h.confirm_flg = 'f' \n";
    }else
    if ($slip_state == "3"){
        $sql .= "AND t_aorder_h.confirm_flg = 't' \n";
    }
    // ��ɼ�ֹ�ʳ��ϡ�
    $sql .= ($slip_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��ɼ�ֹ�ʽ�λ��
    $sql .= ($slip_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // �����襳����
        case "sl_client_cd":
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_staff_main.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // ������̾
        case "sl_client_name":
            $sql .= "   t_aorder_h.client_cname, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_staff_main.charge_cd, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // ��ɼ�ֹ�
        case "sl_slip":
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // ͽ������
        case "sl_arrival_day":
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_staff_main.charge_cd, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // ���ô���ԡʥᥤ�󣱡�
        case "sl_round_staff":
            $sql .= "   t_staff_main.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
    }

    // �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // ������ɽ�����ּ���
    require_once(INCLUDE_DIR."function_keiyaku.inc");
    $cal_array = Cal_range($db_con, $shop_id, true);
    $end_day   = $cal_array[1];     // �оݽ�λ����

    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";
    $sql .= "   t_aorder_h.ord_no, \n";
    $sql .= "   t_staff_main.charge_cd, \n";
    $sql .= "   CAST(LPAD(t_staff_main.charge_cd, 4, '0') AS TEXT) AS charge_cd, \n";
    $sql .= "   t_staff_main.staff_name, \n";
    $sql .= "   t_aorder_h.ord_time, \n";
    $sql .= "   t_aorder_h.client_name, \n";
    $sql .= "   t_trade.trade_name, \n";
    $sql .= "   t_aorder_h.net_amount, \n";
    $sql .= "   t_aorder_h.tax_amount, \n";
    $sql .= "   CASE t_aorder_h.change_flg \n";
    $sql .= "       WHEN 't' THEN 'ͭ��' \n";
    $sql .= "       WHEN 'f' THEN '' \n";
    $sql .= "   END \n";
    $sql .= "   AS change_flg, \n";
    $sql .= "   NULL, \n";
    $sql .= "   NULL, \n";
    $sql .= "   t_aorder_h.route, \n";
    $sql .= "   t_aorder_h.client_cname, \n";
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";
    $sql .= "   t_aorder_h.confirm_flg, \n";
    $sql .= "   t_aorder_h.advance_offset_totalamount \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   INNER JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   INNER JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_aorder_staff.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name, \n";
    $sql .= "           t_attach.part_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_aorder_staff.staff_id = t_staff.staff_id \n";
    $sql .= "           LEFT JOIN t_attach ON t_aorder_staff.staff_id = t_attach.staff_id \n";
    $sql .= "           AND t_attach.shop_id = $shop_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff_main \n";
    $sql .= "   ON t_aorder_h.aord_id = t_staff_main.aord_id \n";
    $sql .= "   LEFT  JOIN t_attach ON  t_staff_main.staff_id = t_attach.staff_id \n";
    $sql .= "                       AND t_attach.h_staff_flg = 'f' \n";
    $sql .= "   INNER JOIN t_trade  ON  t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    }else{
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    }
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '1' \n";
//    $sql .= "AND \n";
//    $sql .= "   t_aorder_h.confirm_flg = 'f' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
//    $sql .= "AND \n";
//    $sql .= "   (t_aorder_h.ps_stat = '1' OR t_aorder_h.ps_stat = '2') \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 'f' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // LIMIT, OFFSET������
    if ($post_flg == true && $err_flg != true){

        // ɽ�����
        switch ($display_num){
            case "1":
                $limit = $total_count;
                break;
            case "2":
                $limit = "100";
                break;
        }

        // �������ϰ���
        $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

        // �Ժ���ǥڡ�����ɽ������쥳���ɤ�̵���ʤ�����н�
        if($page_count != null){
            // �Ժ����total_count��offset�δط������줿���
            if ($total_count <= $offset){
                // ���ե��åȤ����������
                $offset     = $offset - $limit;
                // ɽ������ڡ�����1�ڡ������ˡʰ쵤��2�ڡ���ʬ�������Ƥ������ʤɤˤ��б����Ƥʤ��Ǥ���
                $page_count = $page_count - 1;
                // �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���)
                $page_count = ($total_count <= $display_num) ? null : $page_count;
            }
        }else{
            $offset = 0;
        }

    }

    // �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $page_data      = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ɽ���ѥǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    if (count($page_data) > 0){

        foreach ($page_data as $key => $value){

            // No.
            $page_data[$key]["no"]      = (($page_count - 1) * $limit) + $key + 1;

            // ������
            $page_data[$key]["client"]  = $value["client_cd"]."<br>".htmlspecialchars($value["client_cname"])."<br>";

            // ��ɼ�ֹ���
            $link_url  = "./2-2-106.php?aord_id[0]=".$value["aord_id"]."&back_display=confirm";
            $link_tag  = "<a href=\"#\" onClick=\"Submit_Page('$link_url');\">";
            $link_tag .= ($value["ord_no"] != null) ? $value["ord_no"] : "̤����";
            $link_tag .= "</a>";
            $page_data[$key]["slip_no_link"] = $link_tag;

            // ���ô���ԡʥᥤ�󣱡�
            if ($value["charge_cd"] != null){
                $page_data[$key]["staff_main"] = $value["charge_cd"]." : ".htmlspecialchars($value["staff_name"]);
            }

            // ��ɼ���
            $page_data[$key]["ontax_amount"] = $value["net_amount"] + $value["tax_amount"];

            // �ѹ���������
            if ($value["confirm_flg"] == "f"){
                $link_tag  = "<a href=\"#\" onClick=\"Submit_Page('$link_url');\">";
                $link_tag .= "�ѹ������";
                $link_tag .= "</a>";
            }else{
                $link_tag  = null;
            }
            $page_data[$key]["slip_chg_link"] = $link_tag;

            // ��������å�
            if ($value["confirm_flg"] == "f"){
                $form->addElement("checkbox", "form_slip_check[$key]", ""," ", "", "");
            }else{
                $form->addElement("hidden",   "form_slip_check[$key]");
            }

            // ����ID��hidden���ɲ�
            $form->addElement("hidden","output_id_array[$key]");             //�������ID����
            $con_data["output_id_array[$key]"] = $value["aord_id"];          //����ID

        }

    }

}


/****************************/
// �ե�����ưŪ���ʺ���
/****************************/
// ����ALL�����å�
$form->addElement("checkbox", "form_slip_all_check", "", "����",
    "onClick=\"javascript: All_check('form_slip_all_check', 'form_slip_check', $match_count);\""
);

/*
// ��������å�
for ($i = 0; $i < $match_count; $i++){
    $form->addElement("checkbox", "form_slip_check[$i]", ""," ", "", "");
}
*/


/****************************/
// POST���˥����å���������
// ��ɽ���ܥ��󲡲��ܺ����ܥե饰null��
// ���ڡ����ڤ��ؤ���
// �����겡���ܳ��ꥨ�顼��
// ���ե����२�顼��
/****************************/
if (
    ($_POST["form_display"] != null && $_GET["search"] == null) ||
    ($_POST["switch_page_flg"] == "t") ||
    ($_POST["confirm_flg"] == "true" && $confirm_err_flg != true) ||
    $err_flg == true
){
    for($i = 0; $i < $match_count; $i++){
        $con_data["form_slip_check"][$i]  = "";
    }
    $con_data["form_slip_all_check"] = "";
}


/****************************/
// setConstants
/****************************/
$form->setConstants($con_data); 


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
// �⥸�塼����̸����ơ��֥룱
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">��ɼ����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_type"]]->toHtml()."</td>\n";
//$html_s .= "        <td class=\"Td_Search_3\">ȯ�Ծ���</td>\n";
//$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_out_state"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">�������</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_state"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룲
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
if ($_SESSION["group_kind"] == "2"){
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
}
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">��ɼ�ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_no"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
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
// HTML�����ʰ�������
/****************************/
if ($post_flg == true){

    // �ڡ���ʬ��
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

    /* �����ơ��֥� */
    $html_1 .= "\n";
    $html_1 .= "<table class=\"List_Table\" width=\"100%\" border=\"1\">\n";
    $html_1 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_1 .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_client_name")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_arrival_day")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_round_staff")."<br></td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�����ʬ</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�����<br>������</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">��ɼ���</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">����<br>�껦��</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�������ѹ�</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�ѹ������</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">";
    $html_1 .=          $form->_elements[$form->_elementIndex["form_slip_all_check"]]->toHtml()."</td>\n";
    $html_1 .= "    </tr>\n";
    if ($page_data != null){
    foreach ($page_data as $key => $value){
        if (bcmod($key, 2) == 0){
        $html_1 .= "    <tr class=\"Result1\">\n";
        }else{
        $html_1 .= "    <tr class=\"Result2\">\n";
        }
        $html_1 .= "        <td align=\"right\">".$value["no"]."</td>\n";
        $html_1 .= "        <td>".$value["client"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["slip_no_link"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["ord_time"]."</td>\n";
        $html_1 .= "        <td>".$value["staff_main"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["trade_name"]."</td>";
        $html_1 .= "        <td align=\"right\">".number_format($value["net_amount"])."<br>".number_format($value["tax_amount"])."</td>\n";
        $html_1 .= "        <td align=\"right\">".number_format($value["ontax_amount"])."</td>\n";
        $html_1 .= "        <td align=\"right\">".Numformat_Ortho($value["advance_offset_totalamount"], null, true)."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["change_flg"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["slip_chg_link"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$form->_elements[$form->_elementIndex["form_slip_check[$key]"]]->toHtml()."</td>\n";
        $html_1 .= "    </tr>\n";
    }
    }
    $html_1 .= "    <tr class=\"Result3\">\n";
    $html_1 .= "        <td colspan=\"12\" align=\"right\" colspan=\"3\"><b><font color=\"#0000ff\">";
    $html_1 .= "            <li>�����å����դ�����ɼ�ζ�ۤ�׻����ޤ���</font></b>\n";
    $html_1 .=              $form->_elements[$form->_elementIndex["form_sum"]]->toHtml();
    $html_1 .= "        </td>\n";
    $html_1 .= "    </tr>\n";
    $html_1 .= "</table>\n";
    $html_1 .= "\n";

    /* ��ץơ��֥� */
    $html_2  = "\n"; 
    $html_2 .= "<table class=\"List_Table\" border=\"1\" width=\"500px\" align=\"right\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"right\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"right\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "    <col width=\"100px\" align=\"right\">\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($kake_notax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($kake_tax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($kake_ontax)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($genkin_notax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($genkin_tax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($genkin_ontax)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">��ȴ���</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($notax_amount)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">�����ǹ��</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($tax_amount)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">�ǹ����</td>\n";
    $html_2 .= "        <td align=\"right\">".number_format($ontax_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";
    $html_2 .= "\n";

    /* �ơ��֥�ޤȤ� */
    $html_l .= "\n";
    $html_l .= "    <table>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>$html_page</td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>$html_1</td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td><A NAME=\"sum\">$html_2</A></td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td align=\"right\">".$form->_elements[$form->_elementIndex["form_confirm"]]->toHtml()."</td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "    <tr>\n";
    $html_l .= "        <td>$html_page2</td>\n";
    $html_l .= "    </tr>\n";
    $html_l .= "</table>\n";
    $html_l .= "\n";

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

/****************************/
// ���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[comp_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[act_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
));

// html��assign
$smarty->assign("html", array(
    "html_page"     => $html_page,
    "html_page2"    => $html_page2,
    "html_s"        => $html_s,
    "html_l"        => $html_l,
));

// msg��assign
$smarty->assign("msg", array(
    "move_warning"              => "$move_warning",
    // ���顼��å�����
    "confirm_err"               => "$confirm_err",
    "del_err"                   => "$del_err",
    "deli_day_renew_err"        => "$deli_day_renew_err",
    "deli_day_start_err"        => "$deli_day_start_err",
    "claim_day_renew_err"       => "$claim_day_renew_err",
    "claim_day_start_err"       => "$claim_day_start_err",
    "claim_day_bill_err"        => "$claim_day_bill_err",
    "buy_err_mess1"             => "$buy_err_mess1",
    "buy_err_mess2"             => "$buy_err_mess2",
    "buy_err_mess3"             => "$buy_err_mess3",
    "err_trade_advance_msg"     => "$err_trade_advance_msg",
    "err_future_date_msg"       => "$err_future_date_msg",
    "err_advance_fix_msg"       => "$err_advance_fix_msg",
    "err_paucity_advance_msg"   => "$err_paucity_advance_msg",
    "error_pay_no"              => "$error_pay_no",
    "error_buy_no"              => "$error_buy_no",
    // ���顼�Τ��ä���ɼ�ֹ�����
    "ary_err_confirm"           => $ary_err_confirm,
    "ary_err_del"               => $ary_err_del,
    "ary_err_deli_day_renew"    => $ary_err_deli_day_renew,
    "ary_err_deli_day_start"    => $ary_err_deli_day_start,
    "ary_err_claim_day_renew"   => $ary_err_claim_day_renew,
    "ary_err_claim_day_start"   => $ary_err_claim_day_start,
    "ary_err_claim_day_bill"    => $ary_err_claim_day_bill,
    "ary_err_trade_advance"     => $ary_err_trade_advance,
    "ary_err_future_date"       => $ary_err_future_date,
    "ary_err_advance_fix"       => $ary_err_advance_fix,
    "ary_err_paucity_advance"   => $ary_err_paucity_advance,
    "ary_err_buy1"              => $ary_err_buy1,
    "ary_err_buy2"              => $ary_err_buy2,
    "ary_err_buy3"              => $ary_err_buy3,
    "ary_err_pay_no"            => $ary_err_pay_no,
    "ary_err_buy_no"            => $ary_err_buy_no,
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
