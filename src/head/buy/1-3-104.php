<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/11      06-059      ��          ����ɤˤ����ɼ����ɻߤΤ��ᡢ��ɼ���������ɼ���������ȾȤ餷��碌��
 *  2006/11/11      06-088      ��          �������ϺѤ���ɼ�����Ǥ��ʤ��褦����
 *  2006/12/06      ban_0029    suzuki      ���դΥ�������ɲ�
 *  2006/12/06      ban_0030    suzuki      �����������˥��顼����
 *  2007/01/24      �����ѹ�    watanabe-k  �ܥ���ο��ѹ�
 *  2007/02/07                  watanabe-k  ȯ������ɽ�����ʤ��褦�˽���
 *  2007/02/07                  watanabe-k  ȯ���ȯ�Ԥ�ȯ���������ѹ�
 *  2007-04-04                  fukuda      ����������������ɲ�
 *  2007-05-07                  fukuda      �����Ƚ�����դξ�����ѹ�
 *  2007/08/22                  kajioka-h   �����ơ��֥�Υإå���ȯ��������ȯ�����������袪ȯ������ѹ�
 *
 */

$page_title = "ȯ��Ȳ�";

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
    "form_display_num"  => "1",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_c_staff"      => array("cd" => "", "select" => ""),
    "form_ware"         => "",
    "form_ord_day"      => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_multi_staff"  => "",
    "form_ord_no"       => array("s" => "", "e" => ""),
    //"form_arrival_day"  => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_hope_day"     => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_direct"       => "",
);

// �����������
Restore_Filter2($form, "ord", "show_button", $ary_form_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
// ���򤵤줿�ǡ�����ȯ��ID�����
$ord_id     = $_POST["ord_id_flg"];


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form_Ord_H($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// �����ȥ��
$ary_sort_item = array(
    //"sl_ord_day"        => "ȯ������",
    "sl_ord_day"        => "ȯ����",
    "sl_slip"           => "ȯ���ֹ�",
    //"sl_client_cd"      => "�����襳����",
    "sl_client_cd"      => "ȯ���襳����",
    //"sl_client_name"    => "������̾",
    "sl_client_name"    => "ȯ����̾",
    "sl_hope_day"       => "��˾Ǽ��",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_ord_day");

// ɽ���ܥ���
$form->addElement("submit", "show_button", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// �إå�����󥯥ܥ���
$form->addElement("button", "104_button", "�Ȳ��ѹ�", "$g_button_color onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");
$form->addElement("button", "102_button", "������",     "onClick=\"javascript:location.href('1-3-102.php');\"");
$form->addElement("button", "106_button", "ȯ��İ���", "onClick=\"javascript:location.href('1-3-106.php');\"");

// �����ե饰
$form->addElement("hidden", "data_delete_flg");
$form->addElement("hidden", "order_sheet_flg");
$form->addElement("hidden", "ord_id_flg");
$form->addElement("hidden", "hdn_del_enter_date");

// ���顼���å���hidden
$form->addElement("text", "err_bought_slip");


/****************************/
// ȯ��������󥯲�������
/****************************/
if ($_POST["order_sheet_flg"] == "true"){

    $sql  = "UPDATE \n";
    $sql .= "   t_order_h \n";
    $sql .= "SET \n";
    $sql .= "   ord_sheet_flg = 't' \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    //�����ǡ������
    $res  = @Db_Query($db_con, $sql);

    $clear_hdn["order_sheet_flg"] = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// �����󥯲�������
/****************************/
if ($_POST["data_delete_flg"] == "true"){

    // ���򤵤줿ȯ����ɼ�κ������������
    $enter_date = $_POST["hdn_del_enter_date"];

    /* ������褦�Ȥ��Ƥ���ȯ����ɼ��������������äƤ��ʤ���Ĵ�٤� */
    $sql  = "SELECT \n";
    $sql .= "   * \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $bought_flg = (pg_num_rows($res) == 0) ? false : true;
    // �����������äƤ�����硢���顼��å������򥻥å�
    if ($bought_flg == true){
        $form->setElementError("err_bought_slip", "�����ѤΤ��ᡢȯ����ɼ�����Ǥ��ޤ���");
    }

    /* ������褦�Ȥ��Ƥ���ȯ����ɼ����������Ĵ�٤� */
    // POST���줿�������ID������������ɼ���������򸵤ˡ�Ĵ�٤�
    $valid_flg = Update_check($db_con, "t_order_h", "ord_id", $ord_id, $enter_date);

    /* �����������äƤ��ʤ��������ʾ��Τߺ��������Ԥ� */
    if ($bought_flg == false && $valid_flg == true){
        $data_delete  = "DELETE FROM t_order_h WHERE ord_id = $ord_id;";
        //�����ǡ������
        $result = @Db_Query($db_con, $data_delete);
    }

    // hidden�򥯥ꥢ
    $clear_hdn["data_delete_flg"]       = "";
    $clear_hdn["hdn_del_enter_date"]    = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// ɽ���ܥ��󲡲�����
/****************************/
if($_POST["show_button"] == "ɽ����"){

    // ����POST�ǡ�����0���
    $_POST["form_ord_day"]  = Str_Pad_Date($_POST["form_ord_day"]);
    //$_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);
    $_POST["form_hope_day"] = Str_Pad_Date($_POST["form_hope_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ��ȯ��ô����
    $err_msg = "ȯ��ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_c_staff", $err_msg);

    // ��ȯ����
    $err_msg = "ȯ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_ord_day", $err_msg);

    // ��ȯ��ô��ʣ������
    $err_msg = "ȯ��ô��ʣ������ �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

/*
    // ������ͽ����
    $err_msg = "����ͽ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_arrival_day", $err_msg);
*/

    // ����˾Ǽ��
    $err_msg = "��˾Ǽ�� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_hope_day", $err_msg);

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
if (($_POST["show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["show_button"] == null)){

    // ����POST�ǡ�����0���
    $_POST["form_ord_day"]  = Str_Pad_Date($_POST["form_ord_day"]);
    //$_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);
    $_POST["form_hope_day"] = Str_Pad_Date($_POST["form_hope_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num    = $_POST["form_display_num"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $c_staff_cd     = $_POST["form_c_staff"]["cd"];
    $c_staff_select = $_POST["form_c_staff"]["select"];
    $ware           = $_POST["form_ware"];
    $ord_day_sy     = $_POST["form_ord_day"]["sy"];
    $ord_day_sm     = $_POST["form_ord_day"]["sm"];
    $ord_day_sd     = $_POST["form_ord_day"]["sd"];
    $ord_day_ey     = $_POST["form_ord_day"]["ey"];
    $ord_day_em     = $_POST["form_ord_day"]["em"];
    $ord_day_ed     = $_POST["form_ord_day"]["ed"];
    $multi_staff    = $_POST["form_multi_staff"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
/*
    $arr_day_sy     = $_POST["form_arrival_day"]["sy"];
    $arr_day_sm     = $_POST["form_arrival_day"]["sm"];
    $arr_day_sd     = $_POST["form_arrival_day"]["sd"];
    $arr_day_ey     = $_POST["form_arrival_day"]["ey"];
    $arr_day_em     = $_POST["form_arrival_day"]["em"];
    $arr_day_ed     = $_POST["form_arrival_day"]["ed"];
*/
    $hope_day_sy    = $_POST["form_hope_day"]["sy"];
    $hope_day_sm    = $_POST["form_hope_day"]["sm"];
    $hope_day_sd    = $_POST["form_hope_day"]["sd"];
    $hope_day_ey    = $_POST["form_hope_day"]["ey"];
    $hope_day_em    = $_POST["form_hope_day"]["em"];
    $hope_day_ed    = $_POST["form_hope_day"]["ed"];
    $direct_name    = $_POST["form_direct"];

    $post_flg   = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // ȯ���襳���ɣ�
    $sql .= ($client_cd1 != null) ? "AND t_order_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // ȯ���襳���ɣ�
    $sql .= ($client_cd2 != null) ? "AND t_order_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // ȯ����̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_order_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ȯ��ô���ԥ�����
    $sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
    // ȯ��ô���ԥ��쥯��
    $sql .= ($c_staff_select != null) ? "AND t_order_h.c_staff_id = $c_staff_select \n" : null;
    // �Ҹ�
    $sql .= ($ware != null) ? "AND t_order_h.ware_id = $ware \n" : null;
    // ȯ�����ʳ��ϡ�
    $ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
    $sql .= ($ord_day_s != "--") ? "AND t_order_h.ord_time >= '$ord_day_s 00:00:00' \n" : null;
    // ȯ�����ʽ�λ��
    $ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
    $sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
    // ȯ��ô��ʣ������
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // ȯ���ֹ�ʳ��ϡ�
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ȯ���ֹ�ʽ�λ��
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
/*
    // ����ͽ�����ʳ��ϡ�
    $arr_day_s = $arr_day_sy."-".$arr_day_sm."-".$arr_day_sd;
    $sql .= ($arr_day_s != "--") ? "AND t_order_h.arrival_day >= '$arr_day_s' \n" : null;
    // ����ͽ�����ʽ�λ��
    $arr_day_e = $arr_day_ey."-".$arr_day_em."-".$arr_day_ed;
    $sql .= ($arr_day_e != "--") ? "AND t_order_h.arrival_day <= '$arr_day_e' \n" : null;
*/
    // ��˾Ǽ���ʳ��ϡ�
    $hope_day_s = $hope_day_sy."-".$hope_day_sm."-".$hope_day_sd;
    $sql .= ($hope_day_s != "--") ? "AND t_order_h.hope_day >= '$hope_day_s' \n" : null;
    // ��˾Ǽ���ʽ�λ��
    $hope_day_e = $hope_day_ey."-".$hope_day_em."-".$hope_day_ed;
    $sql .= ($hope_day_e != "--") ? "AND t_order_h.hope_day <= '$hope_day_e' \n" : null;
    // ľ����̾
    if ($direct_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_order_h.direct_name  LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.direct_name2 LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.direct_cname LIKE '%$direct_name%' \n";
        $sql .= "   ) \n";
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // ȯ����
        case "sl_ord_day":
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.client_cd1 \n";
            break;
        // ȯ���ֹ�
        case "sl_slip":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.client_cd1 \n";
            break;
        // �����襳����
        case "sl_client_cd":
            $sql .= "   t_order_h.client_cd1, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.ord_no \n";
            break;
        // ȯ����̾
        case "sl_client_name":
            $sql .= "   t_order_h.client_cname, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.client_cd1 \n";
            break;
        // ��˾Ǽ��
        case "sl_hope_day":
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.client_cd1 \n";
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
    $sql .= "   t_order_h.ord_id, \n";
    $sql .= "   to_char(t_order_h.ord_time, 'yyyy-mm-dd') AS date, \n";
    $sql .= "   to_char(t_order_h.ord_time, 'hh24:mi') AS time, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   t_order_h.client_cname, \n";
    $sql .= "   t_order.buy_money, \n";
    $sql .= "   t_order_h.ord_sheet_flg, \n";
    //$sql .= "   t_order_h.arrival_day, \n";
    $sql .= "   t_order_h.hope_day, \n";
    $sql .= "   t_order_h.ps_stat, \n";
    $sql .= "   t_order_h.finish_flg, \n";
    $sql .= "   t_client.head_flg, \n";
    $sql .= "   CASE t_client.client_div \n";
    $sql .= "       WHEN '3' THEN t_order_h.client_cd1 || '-' || t_order_h.client_cd2 \n";
    $sql .= "       ELSE          t_order_h.client_cd1 \n";
    $sql .= "   END \n";
    $sql .= "   AS client_cd, \n";
    $sql .= "   to_char(t_order_h.send_date, 'yyyy-mm-dd'), \n";
    $sql .= "   to_char(t_order_h.send_date, 'hh24:mi'), \n";
    $sql .= "   to_char(t_order_h.renew_day, 'yyyy-mm-dd'), \n";
    $sql .= "   t_order_h.enter_day \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "   INNER JOIN t_client ON t_order_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_staff  ON t_order_h.c_staff_id = t_staff.staff_id \n";
    $sql .= "   INNER JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           ord_id, \n";
    $sql .= "           net_amount + tax_amount AS buy_money \n";
    $sql .= "       FROM \n";
    $sql .= "           t_order_h \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           ord_id DESC \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_order \n";
    $sql .= "   ON t_order_h.ord_id = t_order.ord_id \n";
    $sql .= "WHERE \n"; 
    $sql .= "   t_order_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);
    $limit          = $total_count;

    // OFFSET������
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
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset \n" : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_ord_data   = Get_Data($res);

}


/****************************/
// JavaScript
/****************************/
$js  = "function Order_Delete(hidden1,hidden2,ord_id,hidden3,enter_date){\n";
$js .= "    res = window.confirm(\"������ޤ���������Ǥ�����\");\n";
$js .= "    if (res == true){\n";
$js .= "        var id = ord_id;\n";
$js .= "        var edate = enter_date;\n";
$js .= "        var hdn1 = hidden1;\n";
$js .= "        var hdn2 = hidden2;\n";
$js .= "        var hdn3 = hidden3;\n";
$js .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$js .= "        document.dateForm.elements[hdn2].value = id;\n";
$js .= "        document.dateForm.elements[hdn3].value = edate;\n";
$js .= "        //Ʊ��������ɥ������ܤ���\n";
$js .= "        document.dateForm.target=\"_self\";\n";
$js .= "        //�����̤����ܤ���\n";
$js .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$js .= "        //POST�������������\n";
$js .= "        document.dateForm.submit();\n";
$js .= "        return true;\n";
$js .= "    }else{\n";
$js .= "        return false;\n";
$js .= "    }\n";
$js .= "}\n";

$js .= " function Order_Sheet(hidden1,hidden2,which,ord_id,renew){\n";
//$js .= "    res = window.confirm(\"ȯ����ȯ�Ԥ��ޤ���������Ǥ�����\");\n";
//$js .= "    if (res == true){\n";
$js .= "        var id = ord_id;\n";
$js .= "        if (which == '1'){\n";
$js .= "            window.open('../../head/buy/1-3-107.php?ord_id='+id,'_blank','');\n";
$js .= "        }else if (which == '2'){\n";
$js .= "            window.open('../../head/buy/1-3-105.php?ord_id='+id,'_blank','');\n";
$js .= "        }\n";
$js .= "        var hdn1 = hidden1;\n";
$js .= "        var hdn2 = hidden2;\n";
$js .= "        if (renew != '4'){\n";
$js .= "            document.dateForm.elements[hdn1].value = 'true';\n";
$js .= "        }\n";
$js .= "        document.dateForm.elements[hdn2].value = id;\n";
$js .= "        //Ʊ��������ɥ������ܤ���\n";
$js .= "        document.dateForm.target=\"_self\";\n";
$js .= "        //�����̤����ܤ���\n";
$js .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$js .= "        //POST�������������\n";
$js .= "        document.dateForm.submit();\n";
$js .= "        return true;\n";
//$js .= "   }else{\n";
//$js .= "        return false;\n";
//$js .= "    }\n";
$js .= "}\n";


/****************************/
// HTML�����ʸ�������
/****************************/
// ���̸����ơ��֥�
$html_s  = Search_Table_Ord_H($form);
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["show_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


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
$page_menu = Create_Menu_h("buy", "1");

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["104_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["102_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["106_button"]]->toHtml();
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

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "auth"          => $auth[0],
    "no"            => ($page_count - 1) * $limit,
    "post_flg"      => $post_flg,
    "err_flg"       => $err_flg,
));

$smarty->assign("html", array(
    "html_s"        => "$html_s",
    "html_page"     => "$html_page",
    "html_page2"    => "$html_page2",
    "js"            => "$js",
));

$smarty->assign("row", $ary_ord_data);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
