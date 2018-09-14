<?php
/****************************
 * �ѹ�����
 *      ����20060811�����ϥ����å���������Ϥ�ɬ�ܥޡ����Ϻ��<watanabe-k>
 *      ��(20060811)������Ϥ���ϡ����ѤΥǡ������-�פǤʤ��ֺѡפ�ɽ������褦�ѹ�<watanabe-k>
 *
 *
 *
 *
 *
*****************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/30      08-002      ��          ���ιԤäƤ��ʤ�ʬǼ������ɼ�����������ϡ��Ĥ��ʬǼ������ɼ��������褦����
 *  2006/10/30      08-019      ��          ����ɤˤ����ɼ����ɻߤΤ��ᡢ��ɼ���������ɼ���������ȾȤ餷��碌��
 *  2006/10/31      08-059      ��          ���ιԤ��Ƥ�����ɼ��ʬǼ������ɼ��̤���ˤϺ���Ǥ��ʤ��褦����
 *  2006/10/31      08-034      ��          ���ե饤����������ϥ����å�̤�»ܤ���������󤬡ֺѡפˤʤäƤ���Х�����
 *  2006/10/31      08-032      ��          ���������Ǹ����������η�̤����������Х�����
 *  2006/11/01      08-011      ��          ���ιԤ��Ƥ��������ɼ��ʬǼ�Ǥʤ��ˤϺ���Ǥ��ʤ��褦����
 *  2006/11/06      08-033      watanabe-k  ��������2006-10-2a�����Ϥ��������������˥��顼��å�������ɽ������ʤ��Х��ν���
 *  2006/11/06      08-065      watanabe-k  �в�ͽ����������Ⱦ�ѿ��������å��ɲ�
 *  2006/11/08      08-128      suzuki      �������ά��ɽ��
 *  2006/12/07      ban_0045    suzuki      ���դ򥼥����
 *  2007/01/25                  watanabe-k  �ܥ���ο��ѹ�
 *  2007/02/07                  watanabe-k  �����ֹ桢ȯ���ֹ��ɽ�����ѹ�
 *  2007/03/26                  watanabe-k������������ˡ�ȯ����ä��ޤǤϹԤʤ�ʤ��褦�˽��� 
 *  2007-04-05                  fukuda      ����������������ɲ�
 *  2007-05-07                  fukuda      �����Ƚ�����դξ�����ѹ�
 *
 *
 */

$page_title = "����Ȳ�";

// �Ķ�����ե����� Environment set up file
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm����� create HTML_QuickForm
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// �ƥ�ץ졼�ȴؿ���쥸���� Register the template function
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB��³ Connect to Database
$db_con = Db_Connect();

// ���¥����å� Authority check
$auth       = Auth_Check($db_con);
// �ܥ���Disabled Button disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled Delete button disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
// �������������Ϣ search condition restoration related
/****************************/
// �����ե������������� array of search form initial value
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_c_staff"      => array("cd" => "", "select" => ""),
    "form_ware"         => "",
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_multi_staff"  => "",
    "form_aord_day"     => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_arrival_day"  => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_aord_no"      => array("s" => "", "e" => ""),
    "form_aord_type"    => "1",
    "form_ord_no"       => array("s" => "", "e" => ""),
    "form_hope_day"     => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_direct"       => "",
);

// ����������� restore search condition
Restore_Filter2($form, array("aord", "sale"), "form_show_button", $ary_form_list);


/****************************/
// �����ѿ����� acquire external variables
/****************************/
$shop_id  = $_SESSION["client_id"];


/****************************/
// ��������� set up the initial value
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // ����� all items
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ����� display page numbers


/****************************/
//�ե�������� create forms
/****************************/
/* ���̥ե����� common forms */
Search_Form_Aord($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� per module form*/
// ���������ֹ� HQ order number
Addelement_Slip_Range($form, "form_aord_no", "�����ֹ�");

// ����ˡ�� order method
$item   =   null;
$item[] =   $form->createElement("radio", null, null, "����ʤ�",   "1");
$item[] =   $form->createElement("radio", null, null, "����饤��", "2");
$item[] =   $form->createElement("radio", null, null, "���ե饤��", "3");
$form->addGroup($item, "form_aord_type", "");

// FCȯ���ֹ� FC ordering number
Addelement_Slip_Range($form, "form_ord_no", "ȯ���ֹ�");

// ��˾Ǽ�� desired delivery date
Addelement_Date_Range($form, "form_hope_day", "��˾Ǽ��", "-");

// �����ȥ�� sort link
$ary_sort_item = array(
    "sl_aord_no"        => "���������ֹ�",
    "sl_ord_no"         => "FCȯ���ֹ�",
    "sl_direct"         => "ľ����",
    "sl_aord_day"       => "������",
    "sl_client_cd"      => "FC������襳����",
    "sl_client_name"    => "FC�������̾",
    "sl_hope_day"       => "��˾Ǽ��",
    "sl_arrival_day"    => "�в�ͽ����",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_aord_day");

// ɽ���ܥ��� display button
$form->addElement("submit", "form_show_button", "ɽ����");

// ���ꥢ clear
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// �إå�����󥯥ܥ��� header link button
$ary_h_btn_list = array("�Ȳ��ѹ�" => $_SERVER["PHP_SELF"], "������" => "./1-2-101.php", "����İ���" => "./1-2-106.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

// �����ե饰 process flag
$form->addElement("hidden","data_delete_flg");
$form->addElement("hidden","aord_id_flg");
$form->addElement("hidden","hdn_del_enter_date");

// ���顼���å���hidden for error set hidden
$form->addElement("text", "err_saled_slip", null, null);


/****************************/
// �����󥯲������� process when delete link is pressed 
/****************************/
if($_POST["data_delete_flg"] == "true"){

    /*** �����Ĵ�� examine before deletion ***/
    // Acquire the order ID of the selected data���򤵤줿�ǡ����μ���ID�����
    $aord_id    = $_POST["aord_id_flg"];
    // Acquire the created date of the selected order slip ���򤵤줿������ɼ�κ������������
    $enter_date = $_POST["hdn_del_enter_date"];

    // search if the deleted order ID that was POST valid (using the creation date of the order slip) POST���줿�������ID������������ɼ���������򸵤ˡ�Ĵ�٤�
    $valid_flg = Update_check($db_con, "t_aorder_h", "aord_id", $aord_id, $enter_date);

    /* check if the order slip is an online order or an offline order ������ɼ������饤��������ե饤�������Ĵ�٤� */
    // if the valid slip flag is true ������ɼ�ե饰��true�ξ��
    if ($valid_flg == true){
        $sql  = "SELECT fc_ord_id FROM t_aorder_h WHERE aord_id = $aord_id;";
        $res  = Db_Query($db_con, $sql);
        // If it's an online order substitute the ordering ID to the variable, if it is an offline order then substitute null in the variable. ����饤�����ξ���ȯ��ID�򡢥��ե饤�����ξ���null���ѿ�������
        $fc_ord_id = (pg_fetch_result($res, 0, 0) != null) ? pg_fetch_result($res, 0, 0) : false;
    }

    /* ���ե饤�����ξ���ʬǼ�ǡ�����̵ͭ���ǧIf If it's an offline order then check if there is a by batch delivery data */
    // If the valid slip flag is true and the online order flag is true ������ɼ�ե饰��true���ĥ���饤�����ե饰��true�ξ��
    if ($valid_flg == true && $fc_ord_id != null){
        $sql  = "SELECT \n";
        $sql .= "   aord_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_aorder_h \n";
        $sql .= "WHERE \n";
        $sql .= "   fc_ord_id = (SELECT fc_ord_id FROM t_aorder_h WHERE aord_id = $aord_id) \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        if (pg_num_rows($res) > 1){
            $bunnou_flg = true;
            // substitute the order ID (by batch delivery slip ID) that has the same ordering ID with the order ID of the deleted slip �������ID����ɼ��Ʊ��ȯ��ID����ļ���ID��ʬǼ��ɼID�ˤ����������
            for ($i=0; $i<pg_num_rows($res); $i++){
                $ary_del_aord_id[$i] = pg_fetch_result($res, $i, 0);
            }
        }else{
            $bunnou_flg = false;
        }
    }

    /* Check if the corresponding slip does not have sales ������ɼ������夬��������Ƥ��ʤ���Ĵ�٤� */
    // If the validation slip flag is true ������ɼ�ե饰��true�ξ��
    if ($valid_flg == true){
        $sql  = "SELECT \n";
        $sql .= "   sale_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_sale_h \n";
        $sql .= "WHERE \n";
        $sql .= "   aord_id IN \n";
        $sql .= "   ( \n";
        // if the batch delivery flag is true ʬǼ�ե饰��true�ξ��
        if ($bunnou_flg == true){
            foreach ($ary_del_aord_id as $key => $value){
                $sql .= "       $value";
                $sql .= ($key+1 < count($ary_del_aord_id)) ? ", \n" : " \n";
            }
        // if the batch delivery flag is not true ʬǼ�ե饰��true��̵�����
        }else{
                $sql .= "       $aord_id \n";
        }
        $sql .= "   ) \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $saled_flg = (pg_num_rows($res) > 0) ? true : false;
    }
        
    /*** set of error messages when you cannot delete (sales are being recorded with batch delivery slip) ����Ǥ��ʤ�����ʬǼ��ɼ����夬�Ԥ��Ƥ���ˤΥ��顼��å��������å� ***/
    // if the sales flag is true ���ե饰��true�ξ��
    if ($saled_flg == true){
        // set the error ���顼�򥻥å�
        $slip = ($bunnou_flg == true) ? "ʬǼ��ɼ" : "��ɼ";
        $form->setElementError("err_saled_slip", "���Ѥ�".$slip."�����뤿�ᡢ����Ǥ��ޤ���");
    }

    /*** delete process ������� ***/
    // if the validation slip flag is true but the sales flag not true (there is no sales being recorded yet for the corresponding order slip) ������ɼ�ե饰��true���ġ����ե饰��true�Ǥʤ����ʳ���������ɼ������夬��������Ƥ��ʤ�����
    if ($valid_flg == true && $saled_flg != true){

        Db_Query($db_con, "BEGIN;");

        // SQL for delete order slip ������ɼ���SQL
        $sql  = "DELETE FROM \n";
        $sql .= "   t_aorder_h \n";
        $sql .= "WHERE \n";
        if ($bunnou_flg == true){
            $sql .= "   aord_id IN (";
            foreach ($ary_del_aord_id as $key => $value){
                $sql .= $value;
                $sql .= ($key+1 < count($ary_del_aord_id)) ? ", " : null;
            }
            $sql .= ") \n";
        }else{
            $sql .= "   aord_id = $aord_id \n";
        }
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        // commit if delete error occurs ������顼�ξ��ϥ��ߥå�
        if($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        // when in case of online order ����饤�����ξ��
        if ($fc_ord_id != null){

            // count the remaining order slips using the acquired ordering ID �嵭�Ǽ�������ȯ��ID�򸵤ˡ��Ĥ����ɼ���򥫥����
            $sql  = "SELECT ";
            $sql .= "   COUNT(ord_no) ";
            $sql .= "FROM ";
            $sql .= "   t_aorder_h ";
            $sql .= "WHERE ";
            $sql .= "   fc_ord_id = $fc_ord_id ";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $num = pg_fetch_result($res, 0, 0);

            //when the number of order slip is 0 ��ɼ�������ξ��
            if($num == 0){
                $sql  = "UPDATE t_order_h SET ";
                $sql .= "   ord_stat = '1' ";
                $sql .= "WHERE ";
                $sql .= "   ord_id = $fc_ord_id ";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }
        }

        //06-03-29 kaji when COMMIT was omitted at the end of the program ���ｪλ����COMMIT˺��
        Db_Query($db_con, "COMMIT;");

    }

    // clear the hidden hidden�򥯥ꥢ
    $clear_hdn["data_delete_flg"]       = "";   
    $clear_hdn["hdn_del_enter_date"]    = "";   
    $form->setConstants($clear_hdn);

}


/****************************/
// process when display button is pressed ɽ���ܥ��󲡲�����
/****************************/
if ($_POST["form_show_button"] == "ɽ����"){

    // filling of 0s in the date POST data����POST�ǡ�����0���
    $_POST["form_aord_day"]     = Str_Pad_Date($_POST["form_aord_day"]);
    $_POST["form_hope_day"]     = Str_Pad_Date($_POST["form_hope_day"]);
    $_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);

    /****************************/
    // error check ���顼�����å�
    /****************************/
    // ��assigned staff for order ����ô����
    $err_msg = "����ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_c_staff", $err_msg);

    // ��select multiple assigned staff for the order ����ô��ʣ������
    $err_msg = "����ô��ʣ������ �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // ��order data ������
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_aord_day", $err_msg);

    // ��delivery date �в�ͽ����
    $err_msg = "�в�ͽ���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Date($form, "form_arrival_day", $err_msg);

    // ��desired delivery date ��˾Ǽ��
    $err_msg = "��˾Ǽ�� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_hope_day", $err_msg);

    /****************************/
    // tally of error check result���顼�����å���̽���
    /****************************/
    // apply checking �����å�Ŭ��
    $form->validate();
    // flag the result ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}

/****************************/
// 1. when there is no error after display button is pressed ɽ���ܥ��󲡲��ܥ��顼�ʤ���
// 2. at the moment of page transition �ڡ����ڤ��ؤ���
/****************************/
if (($_POST["form_show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["form_show_button"] == null)){

    // filling of 0s in date POST data����POST�ǡ�����0���
    $_POST["form_aord_day"]     = Str_Pad_Date($_POST["form_aord_day"]);
    $_POST["form_hope_day"]     = Str_Pad_Date($_POST["form_hope_day"]);
    $_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);

    // 1. set the value of the form to the variable �ե�������ͤ��ѿ��˥��å�
    // 2. set the value (set within the restored search condition function) of SESSION (for hidden) to the variable SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // use for the query condition of acquiring the list ����������������˻���
    $display_num    = $_POST["form_display_num"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $c_staff_cd     = $_POST["form_c_staff"]["cd"];
    $c_staff_select = $_POST["form_c_staff"]["select"];
    $ware           = $_POST["form_ware"];
    $claim_cd1      = $_POST["form_claim"]["cd1"];
    $claim_cd2      = $_POST["form_claim"]["cd2"];
    $claim_name     = $_POST["form_claim"]["name"];
    $multi_staff    = $_POST["form_multi_staff"];
    $aord_day_sy    = $_POST["form_aord_day"]["sy"];
    $aord_day_sm    = $_POST["form_aord_day"]["sm"];
    $aord_day_sd    = $_POST["form_aord_day"]["sd"];
    $aord_day_ey    = $_POST["form_aord_day"]["ey"];
    $aord_day_em    = $_POST["form_aord_day"]["em"];
    $aord_day_ed    = $_POST["form_aord_day"]["ed"];
    $arrival_day_sy = $_POST["form_arrival_day"]["sy"];
    $arrival_day_sm = $_POST["form_arrival_day"]["sm"];
    $arrival_day_sd = $_POST["form_arrival_day"]["sd"];
    $arrival_day_ey = $_POST["form_arrival_day"]["ey"];
    $arrival_day_em = $_POST["form_arrival_day"]["em"];
    $arrival_day_ed = $_POST["form_arrival_day"]["ed"];
    $aord_no_s      = $_POST["form_aord_no"]["s"];
    $aord_no_e      = $_POST["form_aord_no"]["e"];
    $aord_type      = $_POST["form_aord_type"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
    $hope_day_sy    = $_POST["form_hope_day"]["sy"];
    $hope_day_sm    = $_POST["form_hope_day"]["sm"];
    $hope_day_sd    = $_POST["form_hope_day"]["sd"];
    $hope_day_ey    = $_POST["form_hope_day"]["ey"];
    $hope_day_em    = $_POST["form_hope_day"]["em"];
    $hope_day_ed    = $_POST["form_hope_day"]["ed"];
    $direct_name    = $_POST["form_direct"];

    $post_flg = true;

}


/****************************/
// create the condition for acquiring listed data �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // FC��Business Partner code 1 FC������襳���ɣ�
    $sql .= ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // FC��Business Partner code 2 FC������襳���ɣ�
    $sql .= ($client_cd2 != null) ? "AND t_aorder_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // FC��Business Partner FC�������̾
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
    // assigned staff code for an order ����ô���ԥ�����
    $sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
    // select assigned staff for an order ����ô���ԥ��쥯��
    $sql .= ($c_staff_select != null) ? "AND t_staff.staff_id = $c_staff_select \n" : null;
    // warehouse �Ҹ�
    $sql .= ($ware != null) ? "AND t_aorder_h.ware_id = $ware \n" : null;
    // billing destination code 1 �����襳���ɣ�
    $sql .= ($claim_cd1 != null) ? "AND t_client.client_cd1 LIKE '$claim_cd1%' \n" : null;
    // billing destination code 2 �����襳���ɣ�
    $sql .= ($claim_cd2 != null) ? "AND t_client.client_cd2 LIKE '$claim_cd2%' \n" : null;
    // billing name ������̾
    if ($claim_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_client.client_name  LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name2 LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_cname LIKE '%$claim_name%' \n";
        $sql .= "   ) \n";
    }
    // select multiple assigned staff for an order ����ô��ʣ������
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // oder date (start) �������ʳ��ϡ�
    $aord_day_s = $aord_day_sy."-".$aord_day_sm."-".$aord_day_sd;
    $sql .= ($aord_day_s != "--") ? "AND '$aord_day_s' <= t_aorder_h.ord_time \n" : null;
    // order date (end) �������ʽ�λ��
    $aord_day_e = $aord_day_ey."-".$aord_day_em."-".$aord_day_ed;
    $sql .= ($aord_day_e != "--") ? "AND t_aorder_h.ord_time <= '$aord_day_e' \n" : null;
    // delvery date (start) �в�ͽ�����ʳ��ϡ�
    $arrival_day_s = $arrival_day_sy."-".$arrival_day_sm."-".$arrival_day_sd;
    $sql .= ($arrival_day_s != "--") ? "AND '$arrival_day_s' <= t_aorder_h.arrival_day \n" : null;
    // delivery date (end) �в�ͽ�����ʽ�λ��
    $arrival_day_e = $arrival_day_ey."-".$arrival_day_em."-".$arrival_day_ed;
    $sql .= ($arrival_day_e != "--") ? "AND t_aorder_h.arrival_day <= '$arrival_day_e' \n" : null;
    // HQ order number (start) ���������ֹ�ʳ��ϡ�
    $sql .= ($aord_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($aord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // HQ order number ) (end) ���������ֹ�ʽ�λ��
    $sql .= ($aord_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($aord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // order method ��������
    if ($aord_type == "2"){
        $sql .= "AND t_aorder_h.fc_ord_id IS NOT NULL \n";
    }else
    if ($aord_type == "3"){
        $sql .= "AND t_aorder_h.fc_ord_id IS NULL \n";
    }
    // FC ordering number (start) FCȯ���ֹ�ʳ��ϡ�
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // FC ordering number (end) FCȯ���ֹ�ʽ�λ��
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // desired delivery date (start) ��˾Ǽ���ʳ��ϡ�
    $hope_day_s = $hope_day_sy."-".$hope_day_sm."-".$hope_day_sd;
    $sql .= ($hope_day_s != "--") ? "AND '$hope_day_s' <= t_aorder_h.hope_day \n" : null;
    // desired delivery date (end) ��˾Ǽ���ʽ�λ��
    $hope_day_e = $hope_day_ey."-".$hope_day_em."-".$hope_day_ed;
    $sql .= ($hope_day_e != "--") ? "AND t_aorder_h.hope_day <= '$hope_day_e' \n" : null;
    // direct destination ľ����
    if ($direct_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_aorder_h.direct_name  LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.direct_name2 LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.direct_cname LIKE '%$direct_name%' \n";
        $sql .= "   ) \n";
    }

    // refill vairable �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // sort order �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // HQ order number ���������ֹ�
        case "sl_aord_no":
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // FC ordering number FCȯ���ֹ�
        case "sl_ord_no":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time \n";
            break;
        // direct destination ľ����
        case "sl_direct":
            $sql .= "   t_aorder_h.direct_cname, \n" ;
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // order day ������
        case "sl_aord_day":
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // FC��business partner code FC������襳����
        case "sl_client_cd":
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // FC��business partner name FC�������̾
        case "sl_client_name":
            $sql .= "   t_aorder_h.client_cname, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // desired delivery date ��˾Ǽ��
        case "sl_hope_day":
            $sql .= "   t_aorder_h.hope_day, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // planned delivery date �в�ͽ����
        case "sl_arrival_day":
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
    }

    // refill the variable �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// acquuire list of data �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";
    $sql .= "   t_aorder_h.ord_time, \n";
    $sql .= "   t_aorder_h.ord_no as aord_no, \n";
    $sql .= "   t_aorder_h.client_cname, \n";
    $sql .= "   t_aorder_h.net_amount+t_aorder_h.tax_amount, \n";
    $sql .= "   t_aorder_h.hope_day, \n";
    $sql .= "   t_aorder_h.arrival_day, \n";
    $sql .= "   t_aorder_h.check_flg, \n";
    $sql .= "   t_aorder_h.check_user_name, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   t_aorder_h.finish_flg, \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_aorder_h.fc_ord_id IS NULL \n";
    $sql .= "       THEN 'f' \n";
    $sql .= "       ELSE 't' \n";
    $sql .= "   END \n";
    $sql .= "   AS online_flg, \n";
    $sql .= "   t_aorder_h.ps_stat, \n";
    $sql .= "   t_aorder_h.client_cd1, \n";
    $sql .= "   t_aorder_h.client_cd2, \n";
    $sql .= "   to_char(t_aorder_h.renew_day, 'yyyy-mm-dd') AS date, \n";
    $sql .= "   t_aorder_h.enter_day, \n";
    $sql .= "   t_saled_ord.fc_ord_id AS saled_ord_id, \n";
    $sql .= "   t_aorder_h.direct_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN t_order_h ON t_order_h.ord_id = t_aorder_h.fc_ord_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_h.fc_ord_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_sale_h \n";
    $sql .= "           INNER JOIN t_aorder_h ON t_sale_h.aord_id = t_aorder_h.aord_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_h.fc_ord_id IS NOT NULL \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_aorder_h.fc_ord_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_saled_ord \n";
    $sql .= "   ON t_aorder_h.fc_ord_id = t_saled_ord.fc_ord_id \n";
    $sql .= "   LEFT JOIN t_staff  ON t_aorder_h.c_staff_id = t_staff.staff_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.claim_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // acquire all items ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // displayed items ɽ�����
    switch ($display_num){
        case "1":
            $limit = $total_count;
            break;
        case "2":
            $limit = "100";
            break;
    }

    // starting acquiring location �������ϰ���
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // how to approach a situation where the record to be displayed is gone because of row deletion �Ժ���ǥڡ�����ɽ������쥳���ɤ�̵���ʤ�����н�
    if($page_count != null){
        // case when the relationship between total_count and offset has collapsed because of row deletion �Ժ����total_count��offset�δط������줿���
        if ($total_count <= $offset){
            // offset before the selected item ���ե��åȤ����������
            $offset     = $offset - $limit;
            // display the previous page (this does not correspond to situation when 2 pages are deleted) ɽ������ڡ�����1�ڡ������ˡʰ쵤��2�ڡ���ʬ�������Ƥ������ʤɤˤ��б����Ƥʤ��Ǥ���
            $page_count = $page_count - 1;
            // don't output the page transition when it's lower than the selcted item (null it). tbh the japanese is also weird �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���)
            $page_count = ($total_count <= $display_num) ? null : $page_count;
        }
    }else{
        $offset = 0;
    }

    // acquire the data within the page �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $num            = pg_num_rows($res);
    $page_data      = Get_Data($res);

}

//compute the total amount ��׶�۷׻�
for($i = 0; $i < $num; $i++){
    $total_price = bcadd($total_price,$page_data[$i][4]);
}
$total_price = number_format($total_price);

// formatting ����
for($i = 0; $i < $num; $i++){
    $page_data[$i][4]  = number_format($page_data[$i][4]);          // order amount ������
}


/****************************/
// JavaScript
/****************************/
$order_delete  = " function Order_Delete(hidden1,hidden2,ord_id,hidden3,enter_date){\n";
$order_delete .= "    res = window.confirm(\"������ޤ���������Ǥ�����\");\n";
$order_delete .= "    if (res == true){\n";
$order_delete .= "        var id = ord_id;\n";
$order_delete .= "        var edate = enter_date;\n";
$order_delete .= "        var hdn1 = hidden1;\n";
$order_delete .= "        var hdn2 = hidden2;\n";
$order_delete .= "        var hdn3 = hidden3;\n";
$order_delete .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$order_delete .= "        document.dateForm.elements[hdn2].value = id;\n";
$order_delete .= "        document.dateForm.elements[hdn3].value = edate;\n";
$order_delete .= "        //Ʊ��������ɥ������ܤ���\n";
$order_delete .= "        document.dateForm.target=\"_self\";\n";
$order_delete .= "        //�����̤����ܤ���\n";
$order_delete .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$order_delete .= "        //POST�������������\n";
$order_delete .= "        document.dateForm.submit();\n";
$order_delete .= "        return true;\n";
$order_delete .= "    }else{\n";
$order_delete .= "        return false;\n";
$order_delete .= "    }\n";
$order_delete .= "}\n";


/****************************/
// Create HTML (search) HTML�����ʸ�������
/****************************/
// common search table ���̸����ơ��֥�
$html_s .= Search_Table_Aord($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// search table per module 1 �⥸�塼����̸����ơ��֥룱
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">���������ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_aord_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">��������</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_aord_type"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// search table per module 2 �⥸�塼����̸����ơ��֥룲
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">FCȯ���ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_ord_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">��˾Ǽ��</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_hope_day"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// button �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_show_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


/****************************/
// HTML header HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML footer HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// create Menu ��˥塼����
/****************************/
$page_menu = Create_Menu_h("sale", "1");

/****************************/
// create screen header ���̥إå�������
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

/****************************/
//create page �ڡ�������
/****************************/
$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

// Render related setting Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// assign form related variables form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());
$smarty->assign("row", $page_data);

// assign other variables ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "html_page"     => "$html_page",
    "html_page2"    => "$html_page2",
    "total_price"   => "$total_price",
    "order_delete"  => "$order_delete",
    "disabled"      => "$disabled",
    "no"            => ($page_count * $limit - $limit) + 1,
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));

$smarty->assign("html", array(
    "html_s"        => $html_s,
));

// pass the value to the template �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
