<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/06      05-006      ��          ������ľ�������������������Ԥ�줿�����н�
 *  2006/10/10      05-012      ��          ����塢����ɥܥ��󲡲�����Ʊ��ID����ɼ������к������Ƥ��ޤ��Х�����
 *  2007/01/25                  watanabe-k  �ܥ���ο��ѹ�
 *  2007-04-12                  fukuda      �����Ρֶ�ۡפϡֿ�������ۡ�ʬ��ޤޤʤ��褦����
 *
 *
 */

$page_title = "����Ȳ�";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB��³
$db_con = Db_Connect();


/*****************************/
// ���´�Ϣ����
/*****************************/
// ���¥����å�
$auth   = Auth_Check($db_con);


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_trade"            => "",  
    "form_payin_day"        => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_input_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_bank"             => array("cd" => "", "name" => ""), 
    "form_b_bank"           => array("cd" => "", "name" => ""), 
    "form_account_no"       => "",  
    "form_payable_no"       => "",  
    "form_deposit_kind"     => "1", 
    "form_renew"            => "1", 
);

// �����������
Restore_Filter2($form, "payin", "form_show_btn", $ary_form_list);


/****************************/
// �ե�����ǥե����������
/****************************/
$form->setDefaults($ary_form_list);

$range          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �����ѿ�����
/****************************/
// SESSION
$shop_id    = $_SESSION["client_id"];           // ����å�ID
$group_kind = $_SESSION["group_kind"];          // ���롼�׼���


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form_Payin_H($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// �����ֹ�
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "��");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" class=\"ime_disabled\" $g_form_option");
$form->addGroup($obj, "form_payin_no", "", "");

// ��׶��
Addelement_Money_Range($form, "form_sum_amount");

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

// �����ȥ��
$ary_sort_item = array(
    "sl_slip"           => "�����ֹ�",
    "sl_payin_day"      => "������",
    "sl_input_day"      => "������",
    "sl_client_cd"      => "FC������襳����",
    "sl_client_name"    => "FC�������̾",
    "sl_bank_cd"        => "��ԥ�����",
    "sl_bank_name"      => "���̾",
    "sl_b_bank_cd"      => "��Ź������",
    "sl_b_bank_name"    => "��Ź̾",
    "sl_deposit_kind"   => "�¶����",
    "sl_account_no"     => "�����ֹ�",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_payin_day");

// �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => $_SERVER["PHP_SELF"], "������" => "./1-2-402.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

// ɽ���ܥ���
$form->addElement("submit", "form_show_btn", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_btn", "���ꥢ", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// ��׶��
$text = null;
$text[] =& $form->createElement("text", "s", "",
    "size=\"11\" maxLength=\"9\" style=\"text-align: right; $g_form_style\" $g_form_option class=\"money\""
);
$text[] =& $form->createElement("static", "", "", "������");
$text[] =& $form->createElement("text", "e", "",
    "size=\"11\" maxLength=\"9\" style=\"text-align: right; $g_form_style\" $g_form_option class=\"money\""
);
$form->addGroup($text, "form_calc_amount", "");

// �����ե饰
$form->addElement("hidden", "hdn_del_id", null, null);
$form->addElement("hidden", "hdn_del_enter_date", null, null);

// ���顼���å���
$form->addElement("text", "err_daily_update", null, null);


/****************************/
// �����󥯲�������
/****************************/
// ���hidden������ID��set����Ƥ�����
if ($_POST["hdn_del_id"] != null){

    // ����ե饰��true��
    $del_flg = true; 

    // �оݥ쥳���ɤ��ǧ
    $sql  = "SELECT ";
    $sql .= "   renew_flg ";
    $sql .= "FROM ";
    $sql .= "   t_payin_h ";
    $sql .= "WHERE ";
    $sql .= "   pay_id = ".$_POST["hdn_del_id"]." ";
    $sql .= "AND "; 
    $sql .= "   enter_day = '".$_POST["hdn_del_enter_date"]."' ";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $renew_flg = pg_fetch_result($res, 0);
    }

    // ���������ե饰��true�ξ��
    if ($renew_flg == "t"){
        // ���顼�򥻥å�
        $form->setElementError("err_daily_update", "���������������Ԥ��Ƥ��뤿�ᡢ����Ǥ��ޤ���");
    }

    // ���������ե饰��false�ξ��
    if ($renew_flg == "f"){
        // �оݥ쥳���ɤ���
        $sql  = "DELETE FROM ";
        $sql .= "   t_payin_h ";
        $sql .= "WHERE ";
        $sql .= "   pay_id = ".$_POST["hdn_del_id"]." ";
        $sql .= ";"; 
        $res  = Db_Query($db_con, $sql);
    }

    // hidden�κ��ID�ǡ����򥯥ꥢ
    $clear_del_id["hdn_del_id"]             = "";
    $clear_del_data["hdn_del_enter_date"]   = "";
    $form->setConstants($clear_del_id);

}


/****************************/
// ɽ���ܥ��󲡲���
/****************************/
if ($_POST["form_show_btn"] != null){

    // ����POST�ǡ�����0���
    $_POST["form_payin_day"] = Str_Pad_Date($_POST["form_payin_day"]);
    $_POST["form_input_day"] = Str_Pad_Date($_POST["form_input_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ��������
    // ���顼��å�����
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_payin_day", $err_msg);

    // ��������
    // ���顼��å�����
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_input_day", $err_msg);

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
if (($_POST["form_show_btn"] != null && $err_flg != true) || ($_POST != null && $_POST["form_show_btn"] == null)){

    // ����POST�ǡ�����0���
    $_POST["form_payin_day"] = Str_Pad_Date($_POST["form_payin_day"]);
    $_POST["form_input_day"] = Str_Pad_Date($_POST["form_input_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num            = $_POST["form_display_num"];
    $client_cd1             = $_POST["form_client"]["cd1"];
    $client_cd2             = $_POST["form_client"]["cd2"];
    $client_name            = $_POST["form_client"]["name"];
    $trade                  = $_POST["form_trade"];
    $payin_day_sy           = $_POST["form_payin_day"]["sy"];
    $payin_day_sm           = $_POST["form_payin_day"]["sm"];
    $payin_day_sd           = $_POST["form_payin_day"]["sd"];
    $payin_day_ey           = $_POST["form_payin_day"]["ey"];
    $payin_day_em           = $_POST["form_payin_day"]["em"];
    $payin_day_ed           = $_POST["form_payin_day"]["ed"];
    $input_day_sy           = $_POST["form_input_day"]["sy"];
    $input_day_sm           = $_POST["form_input_day"]["sm"];
    $input_day_sd           = $_POST["form_input_day"]["sd"];
    $input_day_ey           = $_POST["form_input_day"]["ey"];
    $input_day_em           = $_POST["form_input_day"]["em"];
    $input_day_ed           = $_POST["form_input_day"]["ed"];
    $bank_cd                = $_POST["form_bank"]["cd"];
    $bank_name              = $_POST["form_bank"]["name"];
    $b_bank_cd              = $_POST["form_b_bank"]["cd"];
    $b_bank_name            = $_POST["form_b_bank"]["name"];
    $account_no             = $_POST["form_account_no"];
    $payable_no             = $_POST["form_payable_no"];
    $deposit_kind           = $_POST["form_deposit_kind"];
    $renew                  = $_POST["form_renew"];

    // �������
    switch ($_POST["form_display_num"]){
        case "1":
            $range  = null;
            break;
        case "2":
            $range  = 100;
            break;
    }

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // FC������襳����1
    $sql .= ($client_cd1 != null) ? "AND t_payin_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // FC������襳����2
    $sql .= ($client_cd2 != null) ? "AND t_payin_h.client_cd2 LIKE '$client_cd2%' \n"           : null;
    // FC�������̾��ά�Ρ�
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_payin_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_payin_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_payin_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // �����ʬ
    if ($trade != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "(SELECT pay_id FROM t_payin_d WHERE trade_id = $trade) \n";
    }
    // �������ʳ��ϡ�
    $payin_day_s = $payin_day_sy."-".$payin_day_sm."-".$payin_day_sd;
    $sql .= ($payin_day_s != "--") ? "AND t_payin_h.pay_day >= '$payin_day_s' \n" : null;
    // �������ʽ�λ��
    $payin_day_e = $payin_day_ey."-".$payin_day_em."-".$payin_day_ed;
    $sql .= ($payin_day_e != "--") ? "AND t_payin_h.pay_day <= '$payin_day_e' \n" : null;
    // �������ʳ��ϡ�
    $input_day_s = $input_day_sy."-".$input_day_sm."-".$input_day_sd;
    $sql .= ($input_day_s != "--") ? "AND t_payin_h.input_day >= '$input_day_s' \n" : null;
    // �������ʽ�λ��
    $input_day_e = $input_day_ey."-".$input_day_em."-".$input_day_ed;
    $sql .= ($input_day_e != "--") ? "AND t_payin_h.input_day <= '$input_day_e' \n" : null;
    // ��ԥ�����
    if ($bank_cd != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "(SELECT pay_id FROM t_payin_d WHERE bank_cd LIKE '$bank_cd%') \n";
    }
    // ���̾
    if ($bank_name != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "(SELECT pay_id FROM t_payin_d WHERE bank_name LIKE '%$bank_name%') \n";
    }
    // ��Ź������
    if ($b_bank_cd != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "(SELECT pay_id FROM t_payin_d WHERE b_bank_cd LIKE '$b_bank_cd%') \n";
    }
    // ��Ź̾
    if ($b_bank_name != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "(SELECT pay_id FROM t_payin_d WHERE b_bank_name LIKE '%$b_bank_name%') \n";
    }
    // �����ֹ�
    if ($account_no != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "(SELECT pay_id FROM t_payin_d WHERE account_no LIKE '$account_no%') \n";
    }
    // ��������ֹ�
    if ($payable_no != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE payable_no = '$payable_no') \n";
    }
    // �¶����
    if ($deposit_kind == "2"){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE deposit_kind = '1') \n";
    }else
    if ($deposit_kind == "3"){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE deposit_kind = '2') \n";
    }
    // ��������
    if ($renew == "2"){
        $sql .= "AND t_payin_h.renew_flg = 'f' \n";
    }else
    if ($renew == "3"){
        $sql .= "AND t_payin_h.renew_flg = 't' \n";
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // �����ֹ�
        case "sl_slip":
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id \n";
            break;  
        // ������
        case "sl_payin_day":
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;  
        // ������
        case "sl_input_day":
            $sql .= "   t_payin_h.input_day, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;  
        // �����襳����
        case "sl_client_cd":
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id \n";
            break;  
        // ������̾
        case "sl_client_name":
            $sql .= "   t_payin_h.client_cname, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // ��ԥ�����
        case "sl_bank_cd":
            $sql .= "   t_payin_d.bank_cd, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // ���̾
        case "sl_bank_name":
            $sql .= "   t_payin_d.bank_name, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // ��Ź������
        case "sl_b_bank_cd":
            $sql .= "   t_payin_d.b_bank_cd, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // ��Ź̾
        case "sl_b_bank_name":
            $sql .= "   t_payin_d.b_bank_name, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // �¶����
        case "sl_deposit_kind":
            $sql .= "   t_payin_d.deposit_kind, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // ��Ź̾
        case "sl_account_no":
            $sql .= "   t_payin_d.account_no, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
    }

    // �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// ɽ���ѥǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // �ǡ�������SQL
    $sql  = "SELECT \n";
    $sql .= "   t_payin_h.pay_id, \n";
    $sql .= "   t_payin_h.pay_no, \n";
    $sql .= "   t_payin_h.pay_day, \n";
    $sql .= "   t_payin_h.input_day, \n";
    $sql .= "   t_payin_h.client_cd1, \n";
    $sql .= "   t_payin_h.client_cd2, \n";
    $sql .= "   t_payin_h.client_cname, \n";
    $sql .= "   (SELECT trade_name FROM t_trade WHERE trade_id = t_payin_d.trade_id) AS trade_name, \n";
    $sql .= "   CASE t_payin_d.trade_id \n";
    $sql .= "       WHEN 32 \n";
    $sql .= "       THEN 0 \n";
    $sql .= "       ELSE t_payin_d.amount \n";
    $sql .= "   END \n";
    $sql .= "   AS amount, \n";
    $sql .= "   CASE t_payin_d.trade_id \n";
    $sql .= "       WHEN 32 THEN t_payin_d.amount \n";
    $sql .= "       ELSE 0 \n";
    $sql .= "   END \n";
    $sql .= "   AS bank_amount, \n";
    $sql .= "   trade_data.rebate_amount, \n";      // �����
    $sql .= "   pay_data.pay_amount, \n";           // ��׶��
    $sql .= "   t_payin_d.bank_cd, \n";
    $sql .= "   t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, \n";
    $sql .= "   t_payin_d.b_bank_name, \n";
    $sql .= "   CASE t_payin_d.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '2' THEN '����' \n";
    $sql .= "   END \n";
    $sql .= "   AS deposit, \n";
    $sql .= "   t_payin_d.account_no, \n";
    $sql .= "   t_payin_d.payable_day, \n";
    $sql .= "   t_payin_d.payable_no, \n";
    $sql .= "   t_payin_d.note, \n";
    $sql .= "   to_char(t_payin_h.renew_day, 'yyyy-mm-dd') AS renew_day, \n";
    $sql .= "   t_payin_h.sale_id, \n";
    $sql .= "   t_payin_h.collect_staff_name, \n";
    $sql .= "   t_payin_h.enter_day, \n";
    $sql .= "   bank_cd_35, \n";
    $sql .= "   bank_name_35, \n";
    $sql .= "   b_bank_cd_35, \n";
    $sql .= "   b_bank_name_35, \n";
    $sql .= "   CASE deposit_kind_35 \n";
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '2' THEN '����' \n";
    $sql .= "   END \n";
    $sql .= "   AS deposit_35, \n";
    $sql .= "   account_no_35 \n";
    $sql .= "FROM \n";
    // ����إå�
    $sql .= "   t_payin_h \n";
    // ����ǡ���
    $sql .= "   LEFT JOIN (SELECT * FROM t_payin_d WHERE trade_id != 35) AS t_payin_d \n";
    $sql .= "   ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    // ����ǡ����ʹ�׶���ѡ�
    $sql .= "   INNER JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           pay_id, \n";
    $sql .= "           SUM(amount) AS pay_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_d \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           pay_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS pay_data \n";
    $sql .= "   ON t_payin_h.pay_id = pay_data.pay_id \n";
    // ����ǡ����ʼ����ʬ���ѡ�
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_32.pay_id, \n";
    $sql .= "           t_32.amount AS bank_amount, \n";
    $sql .= "           t_35.amount AS rebate_amount, \n";
    $sql .= "           t_35.bank_cd AS bank_cd_35, \n";
    $sql .= "           t_35.bank_name AS bank_name_35, \n";
    $sql .= "           t_35.bank_cd AS b_bank_cd_35, \n";
    $sql .= "           t_35.bank_name AS b_bank_name_35, \n";
    $sql .= "           t_35.deposit_kind AS deposit_kind_35, \n";
    $sql .= "           t_35.account_no AS account_no_35 \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   pay_id, \n";
    $sql .= "                   SUM (CASE WHEN trade_id = 32 THEN amount END) AS amount \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payin_d \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   pay_id \n";
    $sql .= "           ) AS t_32 \n";
    $sql .= "           LEFT JOIN \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   pay_id, \n";
    $sql .= "                   SUM(amount) AS amount, \n";
    $sql .= "                   bank_cd, \n";
    $sql .= "                   bank_name, \n";
    $sql .= "                   b_bank_cd, \n";
    $sql .= "                   b_bank_name, \n";
    $sql .= "                   deposit_kind, \n";
    $sql .= "                   account_no \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payin_d \n";
    $sql .= "               WHERE \n";
    $sql .= "                   trade_id = 35 \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   pay_id, \n";
    $sql .= "                   bank_cd, \n";
    $sql .= "                   bank_name, \n";
    $sql .= "                   b_bank_cd, \n";
    $sql .= "                   b_bank_name, \n";
    $sql .= "                   deposit_kind, \n";
    $sql .= "                   account_no \n";
    $sql .= "           ) AS t_35 \n";
    $sql .= "           ON t_32.pay_id = t_35.pay_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS trade_data \n";
    $sql .= "   ON t_payin_h.pay_id = trade_data.pay_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payin_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";
    $res        = Db_Query($db_con, $sql);

    $all_num    = pg_num_rows($res);
    if ($all_num > 0){
        for ($i=0; $i<$all_num; $i++){
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);
            foreach ($data_list[$i] as $key => $value){
                $ary_list_data[$i][$key] = htmlspecialchars($value);
            }
        }
    }

}


/****************************/
// �ڡ��������ܻ��ν���
/****************************/
// ɽ���ܥ���̤�������ĥڡ���POST��������
if ($_POST["form_show_btn"] == null && $_POST["f_page1"] != null && $_POST["f_page2"] != null){

    // hidden�˥��åȤ��Ƥ��븡���������
    $where_sql  = stripslashes($_POST["hdn_where_sql"]);

    // ���ե��å�������
    $offset = ($range != null) ? $page_count * $range - $range : 0;

}


/****************************/
// ��������̤�����
/****************************/
// ���顼�Τʤ����
if ($post_flg == true && $err_flg != true){

// rowspan���ѿ��������
$rowspan_num    = 1;
// ���ֹ����ѿ��������
$row_num        = 1;

// �����쥳���ɿ�ʬ�롼��
for ($i=0; $i<$all_num; $i++){

    // rowspan
    $all_list_data[$i][0] = ($ary_list_data[$i]["pay_id"] == $ary_list_data[$i-1]["pay_id"] || $i == 0) ? 0 : 1;
    if ($ary_list_data[$i]["pay_id"] != $ary_list_data[$i+1]["pay_id"]){
        $all_list_data[$i-$rowspan_num+1][0] = $rowspan_num;
        $rowspan_num = 1;
    }else{
        $rowspan_num++;
    }
    // ���ֹ�
    $all_list_data[$i][1] = $row_num;
    ($ary_list_data[$i]["pay_id"] != $ary_list_data[$i+1]["pay_id"]) ? $row_num++ : $row_num;
    // ����ID
    $all_list_data[$i][2]   = $ary_list_data[$i]["pay_id"];
    // �����ֹ�
    $all_list_data[$i][3]   = $ary_list_data[$i]["pay_no"];
    // ��������������
    $all_list_data[$i][4]   = $ary_list_data[$i]["pay_day"]."<br>".
                              $ary_list_data[$i]["input_day"];
    // FC������襳���ɡ�FC�������̾
    $all_list_data[$i][5]   = $ary_list_data[$i]["client_cd1"]."-".
                              $ary_list_data[$i]["client_cd2"]."<br>".
                              $ary_list_data[$i]["client_cname"];
    // �����ʬ
    $all_list_data[$i][6]   = $ary_list_data[$i]["trade_name"];
    // ���ô����
    $all_list_data[$i][17]  = $ary_list_data[$i]["collect_staff_name"];
    // ���
    $all_list_data[$i][7]   = $ary_list_data[$i]["amount"];
    // ���������
    $all_list_data[$i][9]   = $ary_list_data[$i]["bank_amount"];
    // �����
    $all_list_data[$i][18]  = $ary_list_data[$i]["rebate_amount"];
    // ��׶��
    $all_list_data[$i][8]   = $ary_list_data[$i]["pay_amount"];
    // ��ԥ����ɡ����̾
    $all_list_data[$i][10]  = ($ary_list_data[$i]["trade_name"] != null)
                            ? $ary_list_data[$i]["bank_cd"]."<br>".$ary_list_data[$i]["bank_name"]."<br>"
                            : $ary_list_data[$i]["bank_cd_35"]."<br>".$ary_list_data[$i]["bank_name_35"]."<br>";
    // ��Ź�����ɡ���Ź̾
    $all_list_data[$i][11]  = ($ary_list_data[$i]["trade_name"] != null)
                            ? $ary_list_data[$i]["b_bank_cd"]."<br>".$ary_list_data[$i]["b_bank_name"]."<br>"
                            : $ary_list_data[$i]["b_bank_cd_35"]."<br>".$ary_list_data[$i]["b_bank_name_35"]."<br>";
    // �����ֹ�
    $all_list_data[$i][12]  = ($ary_list_data[$i]["trade_name"] != null)
                            ? $ary_list_data[$i]["deposit"]."<br>".$ary_list_data[$i]["account_no"]."<br>"
                            : $ary_list_data[$i]["deposit_35"]."<br>".$ary_list_data[$i]["account_no_35"]."<br>";
    // �����������������ֹ�
    $all_list_data[$i][13]  = $ary_list_data[$i]["payable_day"]."<br>".
                              $ary_list_data[$i]["payable_no"];
    // ����
    $all_list_data[$i][14]  = $ary_list_data[$i]["note"];
    // ��������
    $all_list_data[$i][15]  = $ary_list_data[$i]["renew_day"];
    // ���
    $all_list_data[$i][16]  = ($ary_list_data[$i]["sale_id"] != null) ? "���Link" : null;

    // ��ɼ��������
    $enter_date[$i]         = $ary_list_data[$i]["enter_day"];

}

// �쥳���ɷ���ʹ��ֹ������-1��
$total_count = $row_num-1;

}


/****************************/
// �Ժ������ɽ������쥳���ɤ�̵���ʤ�����н�
/****************************/
// �Ժ����total_count��offset�δط������줿���
if ($total_count == $offset){
    // ���ե��åȤ����������
    $offset     = $offset-$range;
    // ɽ������ڡ�����1�ڡ�������
    $page_count = $page_count-1;
    // �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���)
    $page_count = ($total_count <= $range) ? null : $page_count;
}


/****************************/
// ���顼���η��
/****************************/
if ($err_flg == true){

    $total_count    = 0;
    $page_count     = 0;

}


/****************************/
// �����ѥǡ�������ɽ���ѥǡ�����ȴ���Ф�
/****************************/
if ($post_flg == true && $err_flg != true){

    // �롼�ץ����󥿥��å�
    $j = 0;
    // ��׶�����ѿ��������
    $sum_amount = 0;

    // �����쥳���ɿ�ʬ�롼��
    for ($i=0; $i<$all_num; $i++){

        // ��������Կ��ʹ��ֹ��
        $limit = ($range != null) ? $offset+$range : $all_num;

        // OFFSET < �������˺��֤������ֹ� <= OFFSET+LIMIT �ξ��
        if ($offset < $all_list_data[$i][1] && $all_list_data[$i][1] <= $limit){
            // �����쥳���ɤ�OFFSET, OFFSET+LIMIT���ϰ���ǥ롼��
            foreach ($all_list_data[$i] as $key => $value){
                // �ǡ��������ɽ�������������
                $disp_list_data[$j][$key] = $value;
                // ��ۤ򻻽�
                $calc_sum           += ($key == 7) ? $value : 0;
                // ��������۹�פ򻻽�
                $calc_sum_bank      += ($key == 9) ? $value : 0;
                // pay_id�����󻲾ȥ쥳���ɤȰۤʤ���
                if ($all_list_data[$i][2] != $all_list_data[$i-1][2]){
                    // �������פ򻻽�
                    $calc_sum_rebate    += ($key == 18) ? $value : 0;
                    // ��۹�פι�פ򻻽�
                    $calc_sum_amount    += ($key == 8) ? $value : 0;
                }
            }

            /****************************/
            // ���ѥե�����ѡ������
            /****************************/
            // ������
            // ɽ�����¤Τ߻��Ϻ����ʸ������Ϥ��ʤ�
            $del_str = ($auth[0] == "w") ? "���" : null;
            // rowspan�Ѥ��ͤ�0��̵��������������������̵�����������ID��̵�����
            if ($all_list_data[$i][0] != 0 && $all_list_data[$i][15] == null && $ary_list_data[$i]["sale_id"] == null){
                $form->addElement("link", "form_del_link[$j]", "", "#", "$del_str", 
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_5('������ޤ���', '".$all_list_data[$i][2]."', 'hdn_del_id', '".$enter_date[$i]."', 'hdn_del_enter_date', '".$_SERVER["PHP_SELF"]."'); return false;\""
                );
            }

            // �롼�ץ�����+1
            $j++;

        }

    }

}


/****************************/
// HTML�����ʸ�������
/****************************/
// ���̸����ơ��֥�
$html_s  = Search_Table_Payin_H($form);
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
// �⥸�塼����̸����ơ��֥룳
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
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_show_btn"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear_btn"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


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
$page_menu = Create_Menu_h("sale", "4");

/****************************/
// ���̥إå�������
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

/****************************/
// �ڡ�������
/****************************/
$range = ($range != null) ? $range : $all_num;
$html_page  = Html_Page2($total_count, $page_count, 1, $range);
$html_page2 = Html_Page2($total_count, $page_count, 2, $range);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
	"html_header"       => "$html_header",
	"page_menu"         => "$page_menu",
	"page_header"       => "$page_header",
	"html_footer"       => "$html_footer",
	"html_page"         => "$html_page",
	"html_page2"        => "$html_page2",
    "calc_sum"          => $calc_sum,
    "calc_sum_amount"   => $calc_sum_amount,
    "calc_sum_bank"     => $calc_sum_bank,
    "calc_sum_rebate"   => $calc_sum_rebate,
    "post_flg"          => "$post_flg",
    "err_flg"           => "$err_flg",
));

$smarty->assign("disp_list_data", $disp_list_data);

$smarty->assign("html", array(
    "html_s"    => $html_s,
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
