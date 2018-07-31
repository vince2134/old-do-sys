<?php
/*
 *
 *
 *
 *
 */

$page_title = "������Ȳ�";

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
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_client_branch"    => "",
    "form_attach_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_staff"            => array("cd" => "", "select" => ""),
    "form_part"             => "",
    "form_pay_day"          => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_advance_no"       => array("s" => "", "e" => ""),
    "form_input_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_amount"           => array("s" => "", "e" => ""),
    "form_bank"             => array("cd" => "", "name" => ""),
    "form_b_bank"           => array("cd" => "", "name" => ""),
    "form_account_no"       => "",
    "form_deposit_kind"     => "1",
    "form_fix"              => "1",
);

// �����������
Restore_Filter2($form, "advance", "form_display", $ary_form_list);


/****************************/
//�����ѿ�����
/****************************/
// SESSION
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$staff_name = $_SESSION["staff_name"];


/****************************/
// ���������
/****************************/
$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// POST���˥����å���hdn������
/****************************/
if ($_POST != null){

    // ���������ALL�����å��򥯥ꥢ
    $clear_form["form_fix_all"] = "";
    // ��ɼ��������å��򥯥ꥢ
    if ($_POST["form_fix_chk"] != null){
        foreach ($_POST["form_fix_chk"] as $key => $value){
            $clear_form["form_fix_chk"][$key] = "";
        }
    }
    $form->setConstants($clear_form);

}


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form_Advance($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// �����ȥ��
$ary_sort_item = array(
    "sl_slip"           => "��ɼ�ֹ�",
    "sl_payin_day"      => "������",
    "sl_input_day"      => "������",
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_staff"          => "ô����",
    "sl_bank_cd"        => "��ԥ�����",
    "sl_bank_name"      => "���̾",
    "sl_b_bank_cd"      => "��Ź������",
    "sl_b_bank_name"    => "��Ź̾",
    "sl_deposit_kind"   => "�¶����",
    "sl_account_no"     => "�����ֹ�",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_payin_day");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button","form_clear","���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => $_SERVER["PHP_SELF"], "������" => "./2-2-411.php");
Make_H_Link_Btn($form, $ary_h_btn_list, 1);

// ���顼���å���
$form->addElement("text", "err_del");               // ������顼��

// �����ե饰
$form->addElement("hidden", "hdn_fix_flg");         // ���������ե饰
$form->addElement("hidden", "hdn_del_id");          // �����ɼID
$form->addElement("hidden", "hdn_del_enter_day");   // �����ɼ����Ͽ����


/***************************/
// ���������ܥ��󲡲���
/***************************/
if ($_POST["hdn_fix_flg"] == "true"){

    // �����ե饰true
    $post_flg = true;

    // ��ɼ��������å�
    if (count($_POST["form_fix_chk"]) == 0){
        $form->setElementError("form_fix_chk", "����������Ԥ���ɼ�����򤷤Ƥ���������");
    }else{
        $ary_cnt_vals = array_count_values($_POST["form_fix_chk"]);
        if (count($_POST["form_fix_chk"]) == $ary_cnt_vals["f"]){
            $form->setElementError("form_fix_chk", "����������Ԥ���ɼ�����򤷤Ƥ���������");
        }
    }

    // �嵭���顼�Τʤ����
    if ($form->getElementError("form_fix_chk") == null){

        // �ȥ�󥶥�����󳫻�
        Db_Query($db_con, "BEGIN;");

        // ���򤵤줿��ɼID�ǥ롼��
        foreach ($_POST["form_fix_chk"] as $key => $value){

            // ������ID��������
            if ($value != "f"){

                $sql  = "SELECT \n";
                $sql .= "   advance_no \n";
                $sql .= "FROM \n";
                $sql .= "   t_advance \n";
                $sql .= "WHERE \n";
                $sql .= "   advance_id = $value \n";

                // �������Ƥ�����ɼ��ID�����
                $sql .= "AND \n";
                $sql .= "   enter_day = '".$_POST["hdn_enter_day"][$value]."' \n";
                $res  = Db_Query($db_con, $sql.";");
                $num  = pg_num_rows($res);
                if ($num == 0){
                    $ary_deleted_id[] = $value;
                    continue;
                }

                // ���ꤵ��Ƥ�����ɼ�ֹ�����
                $sql .= "AND \n";
                $sql .= "   fix_day IS NOT NULL \n";
                $res  = Db_Query($db_con, $sql);
                $num  = pg_num_rows($res);
                if ($num > 0){
                    $ary_fixed_id[] = pg_fetch_result($res, 0, 0);
                    continue;
                }

                // �������������¹�
                $sql  = "UPDATE \n";
                $sql .= "   t_advance \n";
                $sql .= "SET \n";
                $sql .= "   fix_day = NOW(), \n";
                $sql .= "   fix_staff_id = $staff_id, \n";
                $sql .= "   fix_staff_name = '".addslashes($staff_name)."' \n";
                $sql .= "WHERE \n";
                $sql .= "   advance_id = $value \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

            }

        }

        // �ȥ�󥶥�����󴰷�
        Db_Query($db_con, "COMMIT;");

    }

    // hidden����ɼ���������򥯥ꥢ
    foreach ($_POST["hdn_enter_day"] as $key => $value){
        $clear_hdn["hdn_enter_day"][$key] = "";
    }

    // ���������ե饰�򥯥ꥢ
    $clear_hdn["hdn_fix_flg"] = "";
    $form->setConstants($clear_hdn);

}


/***************************/
// �����󥯲�����
/***************************/
if ($_POST["hdn_del_id"] != null){

    // �����ե饰true
    $post_flg = true;

    // ���ID����ɼ��Ͽ�������ѿ���
    $del_id         = $_POST["hdn_del_id"];
    $del_enter_day  = $_POST["hdn_del_enter_day"];

    // ���ꤵ��Ƥ��ʤ��������å�
    $sql  = "SELECT \n";
    $sql .= "   advance_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   advance_id = $del_id \n";
    $sql .= "AND \n";
    $sql .= "   enter_day = '$del_enter_day' \n";
    $sql .= "AND \n";
    $sql .= "   fix_day IS NOT NULL \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $form->setElementError("err_del", "��������ꤵ��Ƥ��뤿�ᡢ����Ǥ��ޤ���");
    }

    // �嵭���顼�Τʤ����
    if ($form->getElementError("err_del") == null){

        // �ȥ�󥶥�����󳫻�
        Db_Query($db_con, "BEGIN;");

        // ��������¹�
        $sql  = "DELETE FROM \n";
        $sql .= "   t_advance \n";
        $sql .= "WHERE \n";
        $sql .= "   advance_id = $del_id \n";
        $sql .= "AND \n";
        $sql .= "   enter_day = '$del_enter_day' \n";
        $sql .= "AND \n";
        $sql .= "   fix_day IS NULL \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        if ($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        // �ȥ�󥶥�����󴰷�
        Db_Query($db_con, "COMMIT;");

    }

    // hdn�κ��ID����ɼ��Ͽ�����򥯥ꥢ
    $clear_hdn["hdn_del_id"]        = "";
    $clear_hdn["hdn_del_enter_day"] = "";
    $form->setConstants($clear_hdn);

}


/****************************/
// ɽ���ܥ��󲡲���
/****************************/
if ($_POST["form_display"] != null){

    // ����POST�ǡ�����0���
    $_POST["form_pay_day"]      = Str_Pad_Date($_POST["form_pay_day"]);
    $_POST["form_input_day"]    = Str_Pad_Date($_POST["form_input_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ��ô���ԥ�����
    Err_Chk_Num($form, "form_staff", "ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");

    // ��������
    Err_Chk_Date($form, "form_pay_day", "������ �����դ������ǤϤ���ޤ���");

    // ��������
    Err_Chk_Date($form, "form_input_day", "������ �����դ������ǤϤ���ޤ���");

    // �����
    Err_Chk_Int($form, "form_amount", "��� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $test = $form->validate();

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
    $_POST["form_pay_day"]      = Str_Pad_Date($_POST["form_pay_day"]);
    $_POST["form_input_day"]    = Str_Pad_Date($_POST["form_input_day"]);

    // POST�ǡ������ѿ��˥��å�
    $display_num        = $_POST["form_display_num"];
    $client_branch      = $_POST["form_client_branch"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $staff_cd           = $_POST["form_staff"]["cd"];
    $staff_select       = $_POST["form_staff"]["select"];
    $part               = $_POST["form_part"];
    $pay_day_sy         = $_POST["form_pay_day"]["sy"];
    $pay_day_sm         = $_POST["form_pay_day"]["sm"];
    $pay_day_sd         = $_POST["form_pay_day"]["sd"];
    $pay_day_ey         = $_POST["form_pay_day"]["ey"];
    $pay_day_em         = $_POST["form_pay_day"]["em"];
    $pay_day_ed         = $_POST["form_pay_day"]["ed"];
    $advance_no_s       = $_POST["form_advance_no"]["s"];
    $advance_no_e       = $_POST["form_advance_no"]["e"];
    $input_day_sy       = $_POST["form_input_day"]["sy"];
    $input_day_sm       = $_POST["form_input_day"]["sm"];
    $input_day_sd       = $_POST["form_input_day"]["sd"];
    $input_day_ey       = $_POST["form_input_day"]["ey"];
    $input_day_em       = $_POST["form_input_day"]["em"];
    $input_day_ed       = $_POST["form_input_day"]["ed"];
    $amount_s           = $_POST["form_amount"]["s"];
    $amount_e           = $_POST["form_amount"]["e"];
    $bank_cd            = $_POST["form_bank"]["cd"];
    $bank_name          = $_POST["form_bank"]["name"];
    $b_bank_cd          = $_POST["form_b_bank"]["cd"];
    $b_bank_name        = $_POST["form_b_bank"]["name"];
    $account_no         = $_POST["form_account_no"];
    $deposit_kind       = $_POST["form_deposit_kind"];
    $fix                = $_POST["form_fix"];

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
        $sql .= "   t_staff.staff_id IN \n";
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
    // �����襳���ɣ�
    $sql .= ($client_cd1 != null) ? "AND t_advance.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �����襳���ɣ�
    $sql .= ($client_cd2 != null) ? "AND t_advance.client_cd2 LIKE '$client_cd2%' \n" : null;
    // ������̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_advance.client_name1 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_advance.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_advance.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ô���ԥ�����
    $sql .= ($staff_cd != null) ? "AND t_staff.charge_cd = '$staff_cd' \n" : null;
    // ô���ԥ��쥯��
    $sql .= ($staff_select != null) ? "AND t_advance.staff_id = $staff_select \n" : null;
    // ����
    $sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
    // �������ʳ��ϡ�
    $pay_day_s  = $pay_day_sy."-".$pay_day_sm."-".$pay_day_sd;
    $sql .= ($pay_day_s != "--") ? "AND t_advance.pay_day >= '$pay_day_s' \n" : null;
    // �������ʽ�λ��
    $pay_day_e  = $pay_day_ey."-".$pay_day_em."-".$pay_day_ed;
    $sql .= ($pay_day_e != "--") ? "AND t_advance.pay_day <= '$pay_day_e' \n" : null;
    // ��ɼ�ֹ�ʳ��ϡ�
    $sql .= ($advance_no_s != null) ? "AND t_advance.advance_no >= '".str_pad($advance_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��ɼ�ֹ�ʽ�λ��
    $sql .= ($advance_no_e != null) ? "AND t_advance.advance_no <= '".str_pad($advance_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // �������ʳ��ϡ�
    $input_day_s  = $input_day_sy."-".$input_day_sm."-".$input_day_sd;
    $sql .= ($input_day_s != "--") ? "AND t_advance.input_day >= '$input_day_s' \n" : null;
    // �������ʽ�λ��
    $input_day_e  = $input_day_ey."-".$input_day_em."-".$input_day_ed;
    $sql .= ($input_day_e != "--") ? "AND t_advance.input_day <= '$input_day_e' \n" : null;
    // ��ۡʳ��ϡ�
    $sql .= ($amount_s != null) ? "AND t_advance.amount >= $amount_s \n" : null;
    // ��ۡʽ�λ��
    $sql .= ($amount_e != null) ? "AND t_advance.amount <= $amount_e \n" : null;
    // ��ԥ�����
    $sql .= ($bank_cd != null) ? "AND t_advance.bank_cd LIKE '$bank_cd%' \n" : null;
    // ���̾
    $sql .= ($bank_name != null) ? "AND t_advance.bank_name LIKE '%$bank_name%' \n" : null;
    // ��Ź������
    $sql .= ($b_bank_cd != null) ? "AND t_advance.b_bank_cd LIKE '$b_bank_cd%' \n" : null;
    // ��Ź̾
    $sql .= ($b_bank_name != null) ? "AND t_advance.b_bank_name LIKE '%$b_bank_name%' \n" : null;
    // �����ֹ�
    $sql .= ($account_no != null) ? "AND t_advance.account_no LIKE '$account_no%' \n" : null;
    // �¶����
    if ($deposit_kind == "2"){
        $sql .= "AND t_advance.deposit_kind = '1' \n";
    }else
    if ($deposit_kind == "3"){
        $sql .= "AND t_advance.deposit_kind = '2' \n";
    }
    // ���������
    if ($fix == "2"){
        $sql .= "AND t_advance.fix_day IS NULL \n";
    }else
    if ($fix == "3"){
        $sql .= "AND t_advance.fix_day IS NOT NULL \n";
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // ��ɼ�ֹ�
        case "sl_slip":
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // ������
        case "sl_payin_day":
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // ������
        case "sl_input_day":
            $sql .= "   t_advance.input_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // �����襳����
        case "sl_client_cd":
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day \n";
            break;
        // ������̾
        case "sl_client_name":
            $sql .= "   t_advance.client_cname, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // ô����
        case "sl_staff":
            $sql .= "   t_staff.charge_cd, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // ��ԥ�����
        case "sl_bank_cd":
            $sql .= "   t_advance.bank_cd, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // ���̾
        case "sl_bank_name":
            $sql .= "   t_advance.bank_name, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // ��Ź������
        case "sl_b_bank_cd":
            $sql .= "   t_advance.b_bank_cd, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // ��Ź̾
        case "sl_b_bank_name":
            $sql .= "   t_advance.b_bank_name, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // �¶����
        case "sl_deposit_kind":
            $sql .= "   t_advance.deposit_kind, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // �����ֹ�
        case "sl_account_no":
            $sql .= "   t_advance.account_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
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
    $sql .= "   t_advance.advance_id, \n";                  // ������ID
    $sql .= "   t_advance.advance_no, \n";                  // ������No.
    $sql .= "   t_advance.pay_day, \n";                     // ������
    $sql .= "   t_advance.input_day, \n";                   // ������
    $sql .= "   t_advance.client_cd1 || '-' || t_advance.client_cd2 \n";
    $sql .= "   AS client_cd, \n";                          // �����襳����
    $sql .= "   t_advance.client_cname, \n";                // ������̾ά��
    $sql .= "   CAST(LPAD(t_staff.charge_cd, 4, '0') AS TEXT) \n";
    $sql .= "   AS charge_cd, \n";                          // ô���ԥ�����
    $sql .= "   t_advance.staff_name, \n";                  // ô����̾
    $sql .= "   t_advance.amount, \n";                      // ���
    $sql .= "   t_advance.bank_cd, \n";                     // ��ԥ�����
    $sql .= "   t_advance.bank_name, \n";                   // ���̾
    $sql .= "   t_advance.b_bank_cd, \n";                   // ��Ź������
    $sql .= "   t_advance.b_bank_name, \n";                 // ��Ź̾
    $sql .= "   CASE t_advance.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '2' THEN '����' \n";
    $sql .= "   END \n";
    $sql .= "   AS deposit_kind, \n";                       // �¶����
    $sql .= "   t_advance.account_no, \n";                  // �����ֹ�
    $sql .= "   TO_DATE(t_advance.fix_day, 'YYYY-MM-DD') \n";
    $sql .= "   AS fix_day, \n";                            // �����������
    $sql .= "   t_advance.enter_day \n";                    // ��ɼ��Ͽ����
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "   LEFT JOIN t_client ON  t_advance.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_staff  ON  t_advance.staff_id = t_staff.staff_id \n";
    $sql .= "   LEFT JOIN t_attach ON  t_staff.staff_id = t_attach.staff_id \n";
    $sql .= "                      AND t_attach.shop_id IN ".Rank_Sql2()." \n";
    $sql .= "WHERE \n";
    $sql .= "   t_advance.shop_id IN ".Rank_Sql2()." \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

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

    // �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_data       = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ɽ���ѥǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // �����
    $html_l     = null;
    $sum_amount = 0;

    // �����ǡ����������硢�ǡ�����ʬ�롼��
    if (count($ary_data) > 0){
    foreach ($ary_data as $key => $value){

        /****************************/
        // ������
        /****************************/
        // �Կ�
        $ary_disp_data[$key]["css"] = (bcmod($key, 2) == 0) ? "Result1" : "Result2";

        // No.
        $ary_disp_data[$key]["no"] = (($page_count - 1) * $limit) + $key + 1;

        // ��ɼ�ֹ���
        $form->addElement("link", "link_advance_no[$key]", "", "./2-2-411.php?advance_id=".$value["advance_id"], $value["advance_no"], "");

        // ��������������
        $ary_disp_data[$key]["day"] = $value["pay_day"]."<br>".$value["input_day"]."<br>";

        // ������
        $ary_disp_data[$key]["client"] = $value["client_cd"]."<br>".htmlspecialchars($value["client_cname"])."<br>";

        // ô����
        if ($value["charge_cd"] != null){
            $ary_disp_data[$key]["staff"] = $value["charge_cd"]." �� ".htmlspecialchars($value["staff_name"]);
        }else{
            $ary_disp_data[$key]["staff"] = null;
        }

        // ���
        $ary_disp_data[$key]["amount"] = $value["amount"];

        // ���
        $ary_disp_data[$key]["bank"] = $value["bank_cd"]."<br>".htmlspecialchars($value["bank_name"])."<br>";

        // ��Ź
        $ary_disp_data[$key]["b_bank"] = $value["b_bank_cd"]."<br>".htmlspecialchars($value["b_bank_name"])."<br>";

        // �¶���ܡ������ֹ�
        $ary_disp_data[$key]["account"] = $value["deposit_kind"]."<br>".$value["account_no"]."<br>";

        // ������
        if ($value["fix_day"] == null && $disabled == null){
            $form->addElement("link", "link_del[$key]", "", "#", "���", "
                onClick=\"javascript: Dialogue_5(
                    '������ޤ���', ".$value["advance_id"].", 'hdn_del_id', '".$value["enter_day"]."', 'hdn_del_enter_day', '".$_SERVER["PHP_SELF"]."'
                );\""
            );
        }

        // �������������å�
        if ($value["fix_day"] == null){
            $form->addElement("advcheckbox", "form_fix_chk[$key]", null, null, null, array("f", $value["advance_id"]));
        }else{
            $ary_disp_data[$key]["fix_day"] = $value["fix_day"];
        }

        // ��׶�۲û�
        $sum_amount += $value["amount"];

        // ������ALL�����å��ѥǡ�������
        if ($value["fix_day"] == null){
            $ary_chk_data[$key] = $value["advance_id"];
        }

        // ��ɼ����������hidden�˥��å�
        $form->addElement("hidden", "hdn_enter_day[".$value["advance_id"]."]");
        $hdn_set["hdn_enter_day"][$value["advance_id"]] = $value["enter_day"];

        /****************************/
        // html����
        /****************************/
        $html_l .= "    <tr class=\"".$ary_disp_data[$key]["css"]."\">\n";
        $html_l .= "        <td align=\"right\">".$ary_disp_data[$key]["no"]."</td>\n";
        $html_l .= "        <td align=\"center\">".($form->_elements[$form->_elementIndex["link_advance_no[$key]"]]->toHtml())."</td>\n";
        $html_l .= "        <td align=\"center\">".$ary_disp_data[$key]["day"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["client"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["staff"]."</td>\n";
        $html_l .= "        <td align=\"right\">".Number_Format_Color($ary_disp_data[$key]["amount"])."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["bank"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["b_bank"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["account"]."</td>\n";
        if ($value["fix_day"] == null && $disabled == null){
        $html_l .= "        <td align=\"center\">".($form->_elements[$form->_elementIndex["link_del[$key]"]]->toHtml())."</td>\n";
        }else{
        $html_l .= "        <td align=\"center\"></td>\n";
        }
        if ($value["fix_day"] == null){
        $html_l .= "        <td align=\"center\">".($form->_elements[$form->_elementIndex["form_fix_chk[$key]"]]->toHtml())."</td>\n";
        }else{
        $html_l .= "        <td align=\"center\">".$ary_disp_data[$key]["fix_day"]."</td>\n";
        }
        $html_l .= "    </tr>\n";

    }
    }

    // ��ɼ����������hidden�˥��å�
    $form->setConstants($hdn_set);

    // �ڡ���ʬ��html����
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

    // ������ALL�����å���js����
    $js = Create_Allcheck_Js("All_Check_Fix", "form_fix_chk", $ary_chk_data);

    // ������ALL�����å�����
    $form->addElement("checkbox", "form_fix_all", "", "���������", "onClick=\"javascript: All_Check_Fix('form_fix_all');\"");

    // ���������ܥ������
    $form->addElement("button", "form_fix_button", "���������", "
        onClick=\"javascript:
            return Dialogue_2('��������ꤷ�ޤ���', '".$_SERVER["PHP_SELF"]."', 'true', 'hdn_fix_flg'
        );\"
        $disabled
    ");


}


/****************************/
// HTML�����ʸ�������
/****************************/
// ���̸����ơ��֥�
$html_s .= Search_Table_Advance($form);
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_display"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


/****************************/
// �ؿ�
/****************************/
function Number_Format_Color($num){
    return ($num < 0) ? "<span style=\"color: #ff0000;\">".number_format($num)."</span>" : number_format($num);
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
// ���̥إå�������
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
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
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
    "sum_amount"    => "$sum_amount",
));

// html��assign
$smarty->assign("html", array(
    "html_page"     =>  $html_page,
    "html_page2"    =>  $html_page2,
    "html_s"        =>  $html_s,
    "html_l"        =>  $html_l,
    "js"            =>  $js,
));

// ���顼��assign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
