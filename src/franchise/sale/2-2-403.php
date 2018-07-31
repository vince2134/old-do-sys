<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/06      05-006      ��          ������ľ�������������������Ԥ�줿�����н�
 *  2006/10/10      05-012      ��          ����塢����ɥܥ��󲡲�����Ʊ��ID����ɼ������к������Ƥ��ޤ��Х�����
 *  2007/01/25                  watanabe-k  �ܥ���ο��ѹ� 
 *  2007-04-06                  fukuda      ����������������ɲ�
 *  2007-04-12                  fukuda      �����Ρֶ�ۡפϡֿ�������ۡ�ʬ��ޤޤʤ��褦����
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
    "form_client_branch"    => "",  
    "form_attach_branch"    => "",  
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""), 
    "form_collect_staff"    => array("cd" => "", "select" => ""), 
    "form_part"             => "",  
    "form_trade"            => "", 
    "form_multi_staff"      => "",  
    "form_payin_day"        => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))),
    "form_act_client"       => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_input_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_payin_no"         => "",  
    "form_sum_amount"       => array("s" => "", "e" => ""),
    "form_bank"             => array("cd" => "", "name" => ""),
    "form_b_bank"           => array("cd" => "", "name" => ""),
    "form_account_no"       => "",
    "form_payable_no"       => "",
    "form_deposit_kind"     => "1",
    "form_renew"            => "1",
    "form_client_gr"        => array("name" => "", "select" => ""),
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
$shop_id        = $_SESSION["client_id"];           // ����å�ID
$group_kind     = $_SESSION["group_kind"];          // ���롼�׼���


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form_Payin($db_con, $form, $ary_form_list);

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

// ���롼��
$item   =   null; 
$item   =   Select_Get($db_con, "client_gr");
$obj    =   null;
$obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"25\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =   $form->createElement("select", "select", "",$item, $g_form_option_select);
$form->addGroup($obj, "form_client_gr", "", "");

// �����ȥ��
$ary_sort_item = array(
    "sl_slip"           => "�����ֹ�",
    "sl_payin_day"      => "������",
    "sl_input_day"      => "������",
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_collect_staff"  => "����ô����",
    "sl_act_client_cd"  => "���Ź������",
    "sl_act_client_name"=> "���Ź̾",
    "sl_bank_cd"        => "��ԥ�����",
    "sl_bank_name"      => "���̾",
    "sl_b_bank_cd"      => "��Ź������",
    "sl_b_bank_name"    => "��Ź̾",
    "sl_deposit_kind"   => "�¶����",
    "sl_account_no"     => "�����ֹ�",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_payin_day");

// ɽ���ܥ���
$form->addElement("submit", "form_show_btn", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_btn", "���ꥢ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => $_SERVER["PHP_SELF"], "������" => "./2-2-402.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

// �����ե饰
$form->addElement("hidden", "hdn_del_id");              // �����ɼID
$form->addElement("hidden", "hdn_del_enter_date");      // �����ɼ������

// ���顼���å���
$form->addElement("text", "err_daily_update");


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
    $clear_del_data["hdn_del_id"]           = "";
    $clear_del_data["hdn_del_enter_date"]   = "";
    $form->setConstants($clear_del_data);

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
    // ������ô����
    $err_msg = "����ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_collect_staff", $err_msg);

    // ��ʣ������
    $err_msg = "����ô��ʣ������ �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // ��������
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_payin_day", $err_msg);

    // ��������
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_input_day", $err_msg);

    // �������ֹ�
    $err_msg = "�����ֹ� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_payin_no", $err_msg);

    // ����׶��
    $err_msg = "��׶�� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Int($form, "form_sum_amount", $err_msg);

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
    $client_branch          = $_POST["form_client_branch"];
    $attach_branch          = $_POST["form_attach_branch"];
    $client_cd1             = $_POST["form_client"]["cd1"];
    $client_cd2             = $_POST["form_client"]["cd2"];
    $client_name            = $_POST["form_client"]["name"];
    $collect_staff_cd       = $_POST["form_collect_staff"]["cd"];
    $collect_staff_select   = $_POST["form_collect_staff"]["select"];
    $part                   = $_POST["form_part"];
    $trade                  = $_POST["form_trade"];
    $multi_staff            = $_POST["form_multi_staff"];
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
    $act_client_cd1         = $_POST["form_act_client"]["cd1"];
    $act_client_cd2         = $_POST["form_act_client"]["cd2"];
    $act_client_name        = $_POST["form_act_client"]["name"];
    $act_client_rank        = $_POST["form_act_client"]["select"]["0"];
    $act_client_select      = $_POST["form_act_client"]["select"]["1"];
    $payin_no_s             = $_POST["form_payin_no"]["s"];
    $payin_no_e             = $_POST["form_payin_no"]["e"];
    $sum_amount_s           = $_POST["form_sum_amount"]["s"];
    $sum_amount_e           = $_POST["form_sum_amount"]["e"];
    $bank_cd                = $_POST["form_bank"]["cd"];
    $bank_name              = $_POST["form_bank"]["name"];
    $b_bank_cd              = $_POST["form_b_bank"]["cd"];
    $b_bank_name            = $_POST["form_b_bank"]["name"];
    $account_no             = $_POST["form_account_no"];
    $payable_no             = $_POST["form_payable_no"];
    $deposit_kind           = $_POST["form_deposit_kind"];
    $renew                  = $_POST["form_renew"];
    $client_gr_name         = $_POST["form_client_gr"]["name"];
    $client_gr_select       = $_POST["form_client_gr"]["select"];

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

    // �ܵ�ô����Ź
    $sql .= ($client_branch != null) ? "AND t_client.charge_branch_id = $client_branch \n" : null;
    // ��°�ܻ�Ź
    if ($attach_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_payin_h.collect_staff_id IN \n";
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
    $sql .= ($client_cd1 != null) ? "AND t_payin_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �����襳����2
    $sql .= ($client_cd2 != null) ? "AND t_payin_h.client_cd2 LIKE '$client_cd2%' \n"           : null;
    // ������̾��ά�Ρ�
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
    // ����ô���ԥ�����
    $sql .= ($collect_staff_cd != null) ? "AND t_staff.charge_cd = '$collect_staff_cd' \n" : null;
    // ����ô���ԥ��쥯��
    $sql .= ($collect_staff_select != null) ? "AND t_payin_h.collect_staff_id = $collect_staff_select \n" : null;
    // ����
    $sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
    // �����ʬ
    if ($trade != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "(SELECT pay_id FROM t_payin_d WHERE trade_id = $trade) \n";
    }
    // ����ô��ʣ������
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
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
    // ���Ź������1
    $sql .= ($act_client_cd1 != null) ? "AND t_payin_h.act_client_cd1 LIKE '$act_client_cd1%' \n" : null;
    // ���Ź������2
    $sql .= ($act_client_cd2 != null) ? "AND t_payin_h.act_client_cd2 LIKE '$act_client_cd2%' \n" : null;
    // ���Ź̾��ά�Ρ�
    if ($act_client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_act_client.client_name  LIKE '%$act_client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_act_client.client_name2 LIKE '%$act_client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_act_client.client_cname LIKE '%$act_client_name%' \n";
        $sql .= "   ) \n";
    }
    // ���Ź���쥯��
    $sql .= ($act_client_select != null) ? "AND t_payin_h.act_client_id = $act_client_select \n" : null;
    // �����ֹ�ʳ��ϡ�
    $sql .= ($payin_no_s != null) ? "AND t_payin_h.pay_no >= '".str_pad($payin_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // �����ֹ�ʽ�λ��
    $sql .= ($payin_no_e != null) ? "AND t_payin_h.pay_no <= '".str_pad($payin_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��׶�ۡʳ��ϡ�
    $sql .= ($sum_amount_s != null) ? "AND pay_data.pay_amount >= '$sum_amount_s' \n" : null;
    // ��׶�ۡʽ�λ��
    $sql .= ($sum_amount_e != null) ? "AND pay_data.pay_amount <= '$sum_amount_e' \n" : null;
    // ��ԥ�����
    if ($bank_cd != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE bank_cd LIKE '$bank_cd%') \n";
    }
    // ���̾
    if ($bank_name != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE bank_name LIKE '%$bank_name%') \n";
    }
    // ��Ź������
    if ($b_bank_cd != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE b_bank_cd LIKE '$b_bank_cd%') \n";
    }
    // ��Ź̾
    if ($b_bank_name != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE b_bank_name LIKE '%$b_bank_name%') \n";
    }
    // �����ֹ�
    if ($account_no != null){
        $sql .= "AND t_payin_h.pay_id IN \n";
        $sql .= "   (SELECT pay_id FROM t_payin_d WHERE account_no LIKE '$account_no%') \n";
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
    // ���롼��̾
    $sql .= ($client_gr_name != null) ? "AND t_client_gr.client_gr_name LIKE '%$client_gr_name%' \n" : null;
    // ���롼�ץ��쥯��
    $sql .= ($client_gr_select != null) ? "AND t_client.client_gr_id = $client_gr_select \n" : null;

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
        // ����ô����
        case "sl_collect_staff":
            $sql .= "   t_staff.charge_cd, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // ���Ź������
        case "sl_act_client_cd":
            $sql .= "   t_payin_h.act_client_cd1, \n";
            $sql .= "   t_payin_h.act_client_cd2, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2 \n";
            break;
        // ���Ź̾
        case "sl_act_client_name":
            $sql .= "   t_payin_h.act_client_cname, \n";
            $sql .= "   t_payin_h.client_cd1, \n";
            $sql .= "   t_payin_h.client_cd2, \n";
            $sql .= "   t_payin_h.pay_day, \n";
            $sql .= "   t_payin_h.pay_no, \n";
            $sql .= "   t_payin_d.pay_d_id \n";
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
// �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_payin_h.pay_id, \n";
    $sql .= "   t_payin_h.pay_no, \n";
    $sql .= "   t_payin_h.pay_day, \n";
    $sql .= "   t_payin_h.input_day, \n";
    $sql .= "   t_payin_h.client_cd1, \n";
    $sql .= "   t_payin_h.client_cd2, \n";
    $sql .= "   t_payin_h.client_cname, \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           trade_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_trade \n";
    $sql .= "       WHERE \n";
    $sql .= "           trade_id = t_payin_d.trade_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS trade_name, \n";
    $sql .= "   CASE t_payin_d.trade_id \n";
    $sql .= "       WHEN 32 THEN 0 \n";
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
    $sql .= "   account_no_35, \n";
    $sql .= "   t_act_client.client_cd1 AS act_client_cd1, \n";
    $sql .= "   t_act_client.client_cd2 AS act_client_cd2, \n";
    $sql .= "   t_act_client.client_cname AS act_client_cname, \n";
    $sql .= "   t_payin_h.payin_div \n";
    $sql .= "FROM \n";
    // ����إå�
    $sql .= "   t_payin_h \n";
    // ����ǡ����ʼ����ʬ35�ּ�����װʳ���
    $sql .= "   LEFT  JOIN t_payin_d  ON  t_payin_h.pay_id = t_payin_d.pay_id AND t_payin_d.trade_id != 35 \n";
    // ������ޥ���
    $sql .= "   LEFT  JOIN t_client   ON  t_payin_h.client_id = t_client.client_id \n";
    // ������ޥ��������Ź��
    $sql .= "   LEFT  JOIN t_client AS t_act_client ON t_payin_h.act_client_id = t_act_client.client_id \n";
    // �����åեޥ���
    $sql .= "   LEFT  JOIN t_staff    ON  t_payin_h.collect_staff_id = t_staff.staff_id \n";
    // ��°�ޥ���
    $sql .= "   LEFT  JOIN t_attach   ON  t_payin_h.collect_staff_id = t_attach.staff_id \n";
    $sql .= "                         AND t_attach.shop_id IN ".Rank_Sql2()." \n";
    // ���롼��
    $sql .= "   LEFT JOIN t_client_gr ON t_client.client_gr_id = t_client_gr.client_gr_id \n";
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
    if ($group_kind == "2"){
    $sql .= "   t_payin_h.shop_id IN (".Rank_Sql().") \n";
    }else{  
    $sql .= "   t_payin_h.shop_id = $shop_id \n";
    }
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $all_num = pg_num_rows($res);
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
if ($post_flg == true && $form_err_flg != true){

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
    // �����襳���ɡ�������̾
    $all_list_data[$i][5]   = $ary_list_data[$i]["client_cd1"]."-".
                              $ary_list_data[$i]["client_cd2"]."<br>".
                              $ary_list_data[$i]["client_cname"];
    // ���Ź�����ɡ����Ź̾
    $all_list_data[$i][19]  = $ary_list_data[$i]["act_client_cd1"]."-".
                              $ary_list_data[$i]["act_client_cd2"]."<br>".
                              $ary_list_data[$i]["act_client_cname"];
    // �����ʬ
    $all_list_data[$i][6]   = $ary_list_data[$i]["trade_name"];
    // ����ô����
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
                              $ary_list_data[$i]["payable_no"]."<br>";
    // ����
    $all_list_data[$i][14]  = $ary_list_data[$i]["note"];
    // ��������
    $all_list_data[$i][15]  = $ary_list_data[$i]["renew_day"];
    // ���
    $all_list_data[$i][16]  = ($ary_list_data[$i]["sale_id"] != null) ? "���Link" : null;

    // ��ɼ��������
    $enter_date[$i]         = $ary_list_data[$i]["enter_day"];
    // �����ʬ
    $all_list_data[$i][20]  = $ary_list_data[$i]["payin_div"];

}


// �쥳���ɷ���ʹ��ֹ������-1��
$total_count = $row_num-1;

}


/****************************/
// �Ժ������ɽ������쥳���ɤ�̵���ʤ�����н�
/****************************/
// �Ժ����total_count��offset�δط������줿���
if ($post_flg == true && $total_count == $offset){
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
if ($form_err_flg == true){

    $total_count    = 0;
    $page_count     = 0;

}


/****************************/
// �����ѥǡ�������ɽ���ѥǡ�����ȴ���Ф�
/****************************/
// ���顼�Τʤ����
if ($post_flg == true && $form_err_flg != true){

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
        // ɽ�����¤Τ߻���ɽ�����ʤ�
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
$html_s  = Search_Table_Payin($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룱
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">�����ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_payin_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">��׶��</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_sum_amount"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룲
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
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
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
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
// �⥸�塼����̸����ơ��֥룴
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
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
// �⥸�塼����̸����ơ��֥룵
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"736px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">���롼��</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_client_gr"]]->toHtml()."</td>\n";
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
$page_menu = Create_Menu_f("sale", "4");

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
    "group_kind"        => "$group_kind",
    "post_flg"          => $post_flg,
    "err_flg"           => $err_flg,
));

// html��assign
$smarty->assign("html", array(
    "html_s"        =>  $html_s,
));

$smarty->assign("disp_list_data", $disp_list_data);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
