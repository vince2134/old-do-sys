<?php
/*
 * ����
 *  ����            BɼNo.          ô����      ����
 *  -----------------------------------------------------------
 *  2007-04-02      ����¾���116~7 fukuda      �ַ�����סּ�������ֹ�פθ������ܤ��ɲ�
 *  2007-04-02                      fukuda      ����������������ɲ�
 *  2007-05-07                      fukuda      �����Ƚ�����դξ�����ѹ�
 *
 *
 *
 *
 */

// �ڡ��������ȥ�
$page_title = "��ʧ�Ȳ�";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_client_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_pay_no"           => array("s" => "", "e" => ""),
    "form_pay_day"          => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_sum_amount"       => array("s" => "", "e" => ""),
    "form_input_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_account_day"      => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_bank"             => array("cd" => "", "name" => ""),
    "form_b_bank"           => array("cd" => "", "name" => ""),
    "form_account_no"       => "",
    "form_payable_no"       => "",
    "form_deposit_kind"     => "1",
    "form_renew"            => "1",
    "form_trade"            => "",
);

// �����������
Restore_Filter2($form, "payout", "form_display", $ary_form_list);


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];

// ���򤵤줿�ǡ�����ʧID�����
$pay_id = $_POST["pay_h_id"];


//***************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form_Payout($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// ���
$obj    =   null;
$obj[]  =   $form->createElement("text", "cd", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\" $g_form_option");
$form->addGroup($obj, "form_bank", "", "");

// ��Ź
$obj    =   null;
$obj[]  =   $form->createElement("text", "cd", "", "size=\"3\" maxLength=\"3\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\" $g_form_option");
$form->addGroup($obj, "form_b_bank", "", "");

// �����ֹ�
$form->addElement("text", "form_account_no", "", "size=\"8\" maxLength=\"7\" class=\"ime_disabled\" $g_form_option");

// ��������ֹ�
$form->addElement("text", "form_payable_no", "", "size=\"13\" maxLength=\"10\" class=\"ime_disabled\" $g_form_option\"");

// �¶����
$radio = "";
$radio[] =& $form->createElement("radio", null, null, "����", "1");
$radio[] =& $form->createElement("radio", null, null, "����", "2");
$radio[] =& $form->createElement("radio", null, null, "����", "3");
$form->addGroup($radio, "form_deposit_kind", "");

// ��������
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "����",   "1");
$radio[] =& $form->createElement("radio", null, null, "̤�»�", "2");
$radio[] =& $form->createElement("radio", null, null, "�»ܺ�", "3");
$form->addGroup($radio, "form_renew", "");

// �����ʬ
$item   =   Select_Get($db_con, "trade_payout");
unset($item[48]);
$form->addElement("select", "form_trade", "", $item, $g_form_option_select);

// �����ȥ��
$ary_sort_item = array(
    "sl_slip"           => "��ʧ�ֹ�",
    "sl_payout_day"     => "��ʧ��",
    "sl_input_day"      => "������",
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_bank_cd"        => "��ԥ�����",
    "sl_bank_name"      => "���̾",
    "sl_b_bank_cd"      => "��Ź������",
    "sl_b_bank_name"    => "��Ź̾",
    "sl_deposit_kind"   => "�¶����",
    "sl_account_no"     => "�����ֹ�",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_payout_day");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "kuria", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => $_SERVER["PHP_SELF"], "������" => "./2-3-302.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

// �����ե饰
$form->addElement("hidden","data_delete_flg");
$form->addElement("hidden","pay_h_id");


//***************************/
// �����󥯲�������
//***************************/
if ($_POST["data_delete_flg"] == "true"){

    // ��ʧID�ˤ�롢��ʧ�ǡ�����������ǡ���   
    $sql  = "DELETE \n";
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_id = ".$_POST["pay_h_id"]." \n";
    $sql .= ";";
    $res = @Db_Query($db_con, $sql);

    // hidden�򥯥ꥢ
    $clear_hdn["data_delete_flg"] = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// ɽ���ܥ��󲡲���
/****************************/
if ($_POST["form_display"] != null){

    // ����POST�ǡ�����0���
    $_POST["form_pay_day"]      = Str_Pad_Date($_POST["form_pay_day"]);
    $_POST["form_input_day"]    = Str_Pad_Date($_POST["form_input_day"]);
    $_POST["form_account_day"]  = Str_Pad_Date($_POST["form_account_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ����ʧ��
    // ���顼��å�����
    $err_msg = "��ʧ�� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_pay_day", $err_msg);

    // ����׶��
    // ���顼��å�����
    $err_msg = "��׶�� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Int($form, "form_sum_amount", $err_msg);

    // ��������
    // ���顼��å�����
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_input_day", $err_msg);

    // �������
    // ���顼��å�����
    $err_msg = "����� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_account_day", $err_msg);

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
// 2. �ڡ����ڤ��ؤ���
/****************************/
if (($_POST["form_display"] != null && $err_flg != true ) || ($_POST != null && $_POST["form_display"] == null)){ 

    // ����POST�ǡ�����0���
    $_POST["form_pay_day"]      = Str_Pad_Date($_POST["form_pay_day"]);
    $_POST["form_input_day"]    = Str_Pad_Date($_POST["form_input_day"]);
    $_POST["form_account_day"]  = Str_Pad_Date($_POST["form_account_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num        = $_POST["form_display_num"];
    $client_branch      = $_POST["form_client_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $pay_no_s           = $_POST["form_pay_no"]["s"];
    $pay_no_e           = $_POST["form_pay_no"]["e"];
    $pay_day_sy         = $_POST["form_pay_day"]["sy"];
    $pay_day_sm         = $_POST["form_pay_day"]["sm"];
    $pay_day_sd         = $_POST["form_pay_day"]["sd"];
    $pay_day_ey         = $_POST["form_pay_day"]["ey"];
    $pay_day_em         = $_POST["form_pay_day"]["em"];
    $pay_day_ed         = $_POST["form_pay_day"]["ed"];
    $sum_amount_s       = $_POST["form_sum_amount"]["s"];
    $sum_amount_e       = $_POST["form_sum_amount"]["e"];
    $input_day_sy       = $_POST["form_input_day"]["sy"];
    $input_day_sm       = $_POST["form_input_day"]["sm"];
    $input_day_sd       = $_POST["form_input_day"]["sd"];
    $input_day_ey       = $_POST["form_input_day"]["ey"];
    $input_day_em       = $_POST["form_input_day"]["em"];
    $input_day_ed       = $_POST["form_input_day"]["ed"];
    $account_day_sy     = $_POST["form_account_day"]["sy"];
    $account_day_sm     = $_POST["form_account_day"]["sm"];
    $account_day_sd     = $_POST["form_account_day"]["sd"];
    $account_day_ey     = $_POST["form_account_day"]["ey"];
    $account_day_em     = $_POST["form_account_day"]["em"];
    $account_day_ed     = $_POST["form_account_day"]["ed"];
    $bank_cd            = $_POST["form_bank"]["cd"];
    $bank_name          = $_POST["form_bank"]["name"];
    $b_bank_cd          = $_POST["form_b_bank"]["cd"];
    $b_bank_name        = $_POST["form_b_bank"]["name"];
    $account_no         = $_POST["form_account_no"];
    $payable_no         = $_POST["form_payable_no"];
    $deposit_kind       = $_POST["form_deposit_kind"];
    $renew              = $_POST["form_renew"];
    $trade              = $_POST["form_trade"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // �ܵ�ô����Ź
    if ($client_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_payout_h.client_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           client_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_client \n";
        $sql .= "       WHERE \n";
        $sql .= "           charge_branch_id = $client_branch \n"; 
        $sql .= "   ) \n";
    }
    // �����襳����1
    $sql .= ($client_cd1 != null) ? "AND t_payout_h.client_cd1 LIKE '$client_cd1%' \n" : null; 
    // �����襳����2
    $sql .= ($client_cd2 != null) ? "AND t_payout_h.client_cd2 LIKE '$client_cd2%' \n" : null; 
    // ������̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_payout_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_payout_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_payout_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ��ʧ�ֹ�ʳ��ϡ�
    $sql .= ($pay_no_s != null) ? "AND t_payout_h.pay_no >= '".str_pad($pay_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��ʧ�ֹ�ʽ�λ��
    $sql .= ($pay_no_e != null) ? "AND t_payout_h.pay_no <= '".str_pad($pay_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��ʧ���ʳ��ϡ�
    $pay_day_s = $pay_day_sy."-".$pay_day_sm."-".$pay_day_sd;
    $sql .= ($pay_day_s != "--") ? "AND '$pay_day_s' <= t_payout_h.pay_day \n" : null;
    // ��ʧ���ʽ�λ��
    $pay_day_e = $pay_day_ey."-".$pay_day_em."-".$pay_day_ed;
    $sql .= ($pay_day_e != "--") ? "AND t_payout_h.pay_day <= '$pay_day_e' \n" : null;
    // ��׶�ۡʳ��ϡ�
    $sql .= ($sum_amount_s != null) ? "AND t_payout_d.pay_amount + t_payout_d_48.pay_amount >= '$sum_amount_s' \n" : null;
    // ��׶�ۡʽ�λ��
    $sql .= ($sum_amount_e != null) ? "AND t_payout_d.pay_amount + t_payout_d_48.pay_amount <= '$sum_amount_e' \n" : null;
    // �������ʳ��ϡ�
    $input_day_s = $input_day_sy."-".$input_day_sm."-".$input_day_sd;
    $sql .= ($input_day_s != "--") ? "AND '$input_day_s' <= t_payout_h.input_day \n" : null;
    // �������ʽ�λ��
    $input_day_e = $input_day_ey."-".$input_day_em."-".$input_day_ed;
    $sql .= ($input_day_e != "--") ? "AND t_payout_h.input_day <= '$input_day_e' \n" : null;
    // ������ʳ��ϡ�
    $account_day_s = $account_day_sy."-".$account_day_sm."-".$account_day_sd;
    $sql .= ($account_day_s != "--") ? "AND '$account_day_s' <= t_payout_h.account_day \n" : null;
    // ������ʽ�λ��
    $account_day_e = $account_day_ey."-".$account_day_em."-".$account_day_ed;
    $sql .= ($account_day_e != "--") ? "AND t_payout_h.account_day <= '$account_day_e' \n" : null;
    // ��ԥ�����
    $sql .= ($bank_cd != null) ? "AND t_payout_d.bank_cd LIKE '$bank_cd%' \n" : null;
    // ���̾
    $sql .= ($bank_name != null) ? "AND t_payout_d.bank_name LIKE '%$bank_name%' \n" : null;
    // ��Ź������
    $sql .= ($b_bank_cd != null) ? "AND t_payout_d.b_bank_cd LIKE '$b_bank_cd%' \n" : null;
    // ��Ź̾
    $sql .= ($b_bank_name != null) ? "AND t_payout_d.b_bank_name LIKE '%$b_bank_name%' \n" : null;
    // �¶����
    if ($deposit_kind == "2"){
        $sql .= "AND t_payout_d.deposit_kind = '1' \n";
    }else
    if ($deposit_kind == "3"){
        $sql .= "AND t_payout_d.deposit_kind = '2' \n";
    }
    // �����ֹ�
    $sql .= ($account_no != null) ? "AND t_payout_d.account_no LIKE '$account_no%' \n" : null;
    // ��������ֹ�
    $sql .= ($payable_no != null) ? "AND t_payout_h.payable_no LIKE '$payable_no%' \n" : null;
    // ��������
    if ($renew == "2"){
        $sql .= "AND t_payout_h.renew_flg = 'f' \n";
    }elseif ($renew == "3"){
        $sql .= "AND t_payout_h.renew_flg = 't' \n";
    }
    // �����ʬ
    if ($trade != null){
        $sql .= "AND t_payout_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payout_d WHERE trade_id = $trade) \n";
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // ��ʧ�ֹ�
        case "sl_slip":
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // ��ʧ��
        case "sl_payout_day":
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // ������
        case "sl_input_day":
            $sql .= "   t_payout_h.input_day, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // �����襳����
        case "sl_client_cd":
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no \n";
            break;
        // ������̾
        case "sl_client_name":
            $sql .= "   t_payout_h.client_cname, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // ��ԥ�����
        case "sl_bank_cd":
            $sql .= "   t_payout_d.bank_cd, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // ���̾
        case "sl_bank_name":
            $sql .= "   t_payout_d.bank_name, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // ��Ź������
        case "sl_b_bank_cd":
            $sql .= "   t_payout_d.b_bank_cd, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // ��Ź̾
        case "sl_b_bank_name":
            $sql .= "   t_payout_d.b_bank_name, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // �¶����
        case "sl_deposit_kind":
            $sql .= "   t_payout_d.deposit_kind, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
        // �����ֹ�
        case "sl_account_no":
            $sql .= "   t_payout_d.account_no, \n";
            $sql .= "   t_payout_h.pay_day, \n";
            $sql .= "   t_payout_h.pay_no, \n";
            $sql .= "   t_payout_h.client_cd1, \n";
            $sql .= "   t_payout_h.client_cd2 \n";
            break;
    }

    // �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_payout_h.pay_id, \n";
    $sql .= "   t_payout_h.pay_no, \n";
    $sql .= "   t_payout_h.input_day, \n";
    $sql .= "   t_payout_h.pay_day, \n";
    $sql .= "   t_trade.trade_name, \n";
    $sql .= "   t_payout_d.bank_cd, \n";
    $sql .= "   t_payout_d.bank_name, \n";
    $sql .= "   t_payout_d.b_bank_cd, \n";
    $sql .= "   t_payout_d.b_bank_name, \n";
    $sql .= "   CASE t_payout_d.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '2' THEN '����' \n";
    $sql .= "   END \n";
    $sql .= "   AS deposit, \n";
    $sql .= "   t_payout_d.account_no, \n";
    $sql .= "   t_payout_h.client_cname, \n";
    $sql .= "   t_payout_h.client_cd1, \n";
    $sql .= "   t_payout_h.client_cd2, \n";
    $sql .= "   t_payout_d.pay_amount, \n";
    $sql .= "   t_payout_d_48.pay_amount AS tax_amount, \n";
    $sql .= "   t_payout_d.pay_amount + t_payout_d_48.pay_amount AS sum_amount, \n";
    $sql .= "   t_payout_d.note, \n";
    $sql .= "   t_payout_h.renew_flg, \n";
    $sql .= "   to_char(t_payout_h.renew_day,'yyyy-mm-dd') AS renew_day, \n";
    $sql .= "   t_payout_h.buy_id, \n";
    $sql .= "   t_payout_h.account_day, \n";
    $sql .= "   t_payout_h.payable_no \n";
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    // ��ʧ�ǡ����ʼ�����ʳ���
    $sql .= "   LEFT JOIN t_payout_d \n";
    $sql .= "       ON  t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "       AND t_payout_d.trade_id != 48 \n";
    // ��ʧ�ǡ����ʼ�����Τ�)
    $sql .= "   LEFT JOIN t_payout_d AS t_payout_d_48 \n";
    $sql .= "       ON  t_payout_h.pay_id = t_payout_d_48.pay_id \n";
    $sql .= "       AND t_payout_d_48.trade_id = 48 \n";
    // �����ʬ̾�ʼ�����ʳ��λ�ʧ�ǡ������Ф��ơ�
    $sql .= "   INNER JOIN t_trade \n";
    $sql .= "       ON t_payout_d.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payout_h.shop_id = $shop_id \n";
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
    $row_count      = pg_num_rows($res);
    $page_data      = Get_Data($res);

}

//echo $total_count_sql2;
//��׶�۷׻�
for($i = 0; $i < $row_count; $i++){
    $sum1 = bcadd($sum1,$page_data[$i][14]);    //��ʧ���
    $sum2 = bcadd($sum2,$page_data[$i][15]);    //�����
    $sum3 = bcadd($sum1,$sum2);                 //��׶��
} 

$order_delete  = " function Order_Delete(hidden1,hidden2,pay_id){\n";
$order_delete .= "    res = window.confirm(\"������ޤ���������Ǥ�����\");\n";
$order_delete .= "    if (res == true){\n";
$order_delete .= "        var id = pay_id;\n";
$order_delete .= "        var hdn1 = hidden1;\n";
$order_delete .= "        var hdn2 = hidden2;\n";
$order_delete .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$order_delete .= "        document.dateForm.elements[hdn2].value = id;\n";
$order_delete .= "        // Ʊ��������ɥ������ܤ���\n";
$order_delete .= "        document.dateForm.target=\"_self\";\n";
$order_delete .= "        // �����̤����ܤ���\n";
$order_delete .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$order_delete .= "        // POST�������������\n";
$order_delete .= "        document.dateForm.submit();\n";
$order_delete .= "        return true;\n";
$order_delete .= "    }else{\n";
$order_delete .= "        return false;\n";
$order_delete .= "    }\n";
$order_delete .= "}\n";

  
/****************************/
// HTML�����ʸ�������
/****************************/
// ���̸����ơ��֥�
$html_s  = Search_Table_Payout($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룱
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">���</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_bank"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">��Ź</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_b_bank"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룲
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">�����ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_account_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">��������ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_payable_no"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룳
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">�¶����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_deposit_kind"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">��������</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_renew"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룴
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">�����ʬ</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_trade"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_display"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["kuria"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";


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
$page_menu = Create_Menu_h('buy','3');

/****************************/
//���̥إå�������
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

/****************************/
// �ڡ�������
/****************************/
$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'      => "$html_header",
	'page_menu'        => "$page_menu",
	'page_header'      => "$page_header",
	'html_footer'      => "$html_footer",
	'html_page'        => "$html_page",
	'html_page2'       => "$html_page2",
    "pay_day_err"      => "$pay_day_err",
    "pay_all_day_err"  => "$pay_all_day_err",
    "input_day_err"    => "$input_day_err",
    "input_all_day_err"=> "$input_all_day_err",
    "total_count"      => "$total_count",
    "order_delete"     => "$order_delete",
    "sum1"             => "$sum1",
    "sum2"             => "$sum2",
    "sum3"             => "$sum3",
    "r"                => "$limit",
    "auth"             => $auth[0],
    "post_flg"          => "$post_flg",
    "err_flg"           => "$err_flg",
));
$smarty->assign('row',$page_data);

// html��assign
$smarty->assign("html", array(
    "html_s"    => $html_s,
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
