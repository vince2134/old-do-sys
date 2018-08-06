<?php
/**
 *
 * ��������
 *
 * 1.0.0 (2006/xx/xx) ��������
 * 1.0.1 (2006/09/20) (kaji)
 *   ����������������������������դ������å���ؿ����ѹ�
 *
 * @author      �դ��� <�դ���@bhsk.co.jp>
 * @version     1.0.1 (2006/09/20)
 *
 */

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/06      05-004      ��          �����ѹ�ľ�������������������Ԥ�줿�����н�
 *  2006/10/06      05-005      ��          �����ѹ�ľ�������������������Ԥ�줿�����н�
 *  2006/10/07      05-007      ��          �����ѹ�ľ��������ǡ�����������줿�����н�
 *  2006/10/07      05-011      ��          �����ѹ�ľ��������ǡ�����������졢����˿������⤬�Ԥ�줿�����н�
 *  2006/10/10      05-002      ��          �֥饦�������ޤ������ܥ��󲡲�����hierselect���ͤ���������ʤ��Х����б�
 *  2007/01/25                  watanabe-k  �ܥ���ο��ѹ�
 *  2007-04-12                  fukuda      �������������ٻ����������ɬ���Ƥ����Ϥ���Ƥ��ޤ��Զ�����
 *  2007-04-12                  fukuda      �����衦������������ˡ������ֹ桦����ۤ����
 *  2009-07-27                  aoyama-n    ��������ѹ�����������������������դ�����Ǥ��Ƥ��ޤ��Զ�罤��
 *  2009-10-16                  hashimoto-y �ƻҴط������򤷤��Ȥ��ηٹ�ɽ�����ѻ�
 *   2016/01/20                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */


$page_title = "��������";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

// �⥸�塼��̾
$mod_me = "1-2-402";


/*****************************/
// ���´�Ϣ����
/*****************************/
// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("payin");
}


/****************************/
// �������
/****************************/
// OK�ܥ��󲡲�����value�򥯥ꥢ
if ($_POST["form_ok_btn"] != null){
    $clear_hdn["form_ok_btn"] = "";
    $form->setConstants($clear_hdn);
}


/*****************************/
// �����ѿ�����
/*****************************/
// SESSION
$shop_id            = $_SESSION["client_id"];           // ����å�ID
$group_kind         = $_SESSION["group_kind"];          // ���롼�׼���
$staff_id           = $_SESSION["staff_id"];            // �����å�ID
$staff_name         = $_SESSION["staff_name"];          // �����å�̾
// POST
$post               = $_POST["post"];                   // �ڡ���POST����
$client_id          = $_POST["client_id"];              // ������ID
// POST(hidden)
$client_search_flg  = $_POST["client_search_flg"];      // �����踡���ե饰
$calc_flg           = $_POST["calc_flg"];               // ��׻��Хե饰
$state              = $_POST["hdn_state"];              // ���ơ�����
$enter_date         = $_POST["hdn_enter_date"];         // ��ɼ��������
// GET
$payin_id           = $_GET["payin_id"];                // ����ID


/*****************************/
// ���ѽ���ͥ��å�
/*****************************/
// ����ID��hidden���ݻ�����
if ($_GET["payin_id"] != null){
    // ����ID��hidden�˥��å�
    $payin_id_set["payin_id"] = $_GET["payin_id"];
    $form->setConstants($payin_id_set);
}else{
    // hidden��������ID����
    $payin_id = $_POST["payin_id"];
}

// ������ID��hidden���ݻ�����
if ($_POST["client_id"] != null){
    // ������ID��hidden�˥��å�
    $client_id_set["client_id"] = $_POST["client_id"];
    $form->setConstants($client_id_set);
}

// POST��Ƚ���Ѥ˼��⥸�塼��̾��hidden�˥��å�
$post_set["post"] = $mod_me;
$form->setConstants($post_set);


/*****************************/
// ��������å�
/*****************************/
/*** ������Ͽ���ѹ�Ƚ�� ***/
// �ޤ����ơ�������̵������������ID��������
if ($state == null && $payin_id != null){
    // ���Ѵ�
    $payin_id = (float)$payin_id;
    // ������������ID��������������å�
    $sql  = "SELECT ";
    $sql .= "   pay_id ";
    $sql .= "FROM ";
    $sql .= "   t_payin_h ";
    $sql .= "WHERE ";
    $sql .= "   pay_id = $payin_id ";
    $sql .= "AND ";
    $sql .= "   shop_id = $shop_id ";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    if (pg_num_rows($res) == 0){
        // TOP������
        header("Location: ../top.php");
    }else{  
        $state = "chg";
    }
}elseif ($state == null && $payin_id == null){
    $state = "new";
}
// ���ơ�������hidden�˥��åȥǥե����
$hdn_state_set["hdn_state"] = $state;
$form->setDefaults($hdn_state_set);

/*** �����ѹ����ˡ��оݤȤʤ�ǡ�������������Ĵ�٤뤿��������� ***/
// �����ѹ���������hidden����ɼ����������null�ξ��
if ($state == "chg" && $enter_date == null){
    // �����������������hidden�˥��åȥǥե����
    $sql  = "SELECT ";
    $sql .= "   enter_day ";
    $sql .= "FROM ";
    $sql .= "   t_payin_h ";
    $sql .= "WHERE ";
    $sql .= "   pay_id = $payin_id ";
    $sql .= "AND ";
    $sql .= "   shop_id = $shop_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    if (pg_num_rows($res) > 0){
        $enter_date = pg_fetch_result($res, 0);
        $hdn_enter_date_set["hdn_enter_date"] = $enter_date;
        $form->setDefaults($hdn_enter_date_set);
    }
}

/*** ��ǧ�ΤߡʾȲ񤫤����ܻ��ˤ�Ƚ�� ***/
// ���������»ܺѤޤ������ID��������
if ($payin_id != null){
    $sql  = "SELECT ";
    $sql .= "   pay_id ";
    $sql .= "FROM ";
    $sql .= "   t_payin_h ";
    $sql .= "WHERE ";
    $sql .= "   pay_id = $payin_id ";
    $sql .= "AND ";
    $sql .= "   (renew_flg = 't' OR sale_id IS NOT NULL) ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    // �����쥳���ɤ�������ϳ�ǧ���̥ե饰��true�ˤ���
    $verify_only_flg = (pg_num_rows($res) == 1) ? true : false;
}

// �����ѹ����������������Ƥ��Ƥ�ե�������������Ǥ���褦�ˡ��ѹ�����Ͽ���뤳�ȤϤǤ��ޤ��󡣺Ǹ���Ƥ��ޤ�����
$verify_only_flg = ($post == $mod_me && $_POST["form_ok_btn"] == null && $verify_only_flg == true) ? false : $verify_only_flg;


/****************************/
// form��default�ǡ������å�
/****************************/
// �ѹ������ļ��ڡ�����������ܤ�̵����硢�ޤ�������OK�ܥ��󲡲��������ٲ��̥ե饰��true�������������Ԥ��Ƥ����ˤξ��
if (($state == "chg" && $post != $mod_me) || ($_POST["form_ok_btn"] != null && $verify_only_flg == true)){

    /*** �ե����ॻ�å��ѥǡ������� ***/
    // ����إå�����
    $sql  = "SELECT ";
    $sql .= "   t_payin_h.pay_no, ";
    $sql .= "   t_payin_h.client_id, ";
    $sql .= "   t_client.client_cd1, ";
    $sql .= "   t_client.client_cd2, ";
    $sql .= "   t_client.client_cname, ";
    $sql .= "   t_payin_h.client_cd1 AS verify_client_cd1, ";
    $sql .= "   t_payin_h.client_cd2 AS verify_client_cd2, ";
    $sql .= "   t_payin_h.client_cname AS verify_client_cname, ";
    $sql .= "   t_payin_h.pay_day, ";
    $sql .= "   t_payin_h.collect_staff_id, ";
    $sql .= "   t_bill.bill_id, ";
    $sql .= "   t_bill.bill_no, ";
    $sql .= "   t_payin_h.claim_div, ";
//    $sql .= "   t_claim_client.client_cd1 AS verify_claim_cd1, ";
//    $sql .= "   t_claim_client.client_cd2 AS verify_claim_cd2, ";
//    $sql .= "   t_claim_client.client_cname AS verify_claim_cname, ";
    $sql .= "   t_payin_h.claim_cd1 AS verify_claim_cd1, ";
    $sql .= "   t_payin_h.claim_cd2 AS verify_claim_cd2, ";
    $sql .= "   t_payin_h.claim_cname AS verify_claim_cname, ";
    $sql .= "   t_payin_h.renew_flg, ";
    $sql .= "   t_payin_h.sale_id ";
    $sql .= "FROM ";
    $sql .= "   t_payin_h ";
    $sql .= "   LEFT JOIN t_client ON t_payin_h.client_id = t_client.client_id ";
    $sql .= "   LEFT JOIN t_claim ON t_client.client_id = t_claim.client_id ";
    $sql .= "   LEFT JOIN t_client AS t_claim_client ";
    $sql .= "       ON t_claim.client_id = t_claim_client.client_id ";
    $sql .= "       AND t_payin_h.claim_div = t_claim.claim_div ";
    $sql .= "   LEFT JOIN t_bill ON t_payin_h.bill_id = t_bill.bill_id ";
    $sql .= "WHERE ";
    $sql .= "   pay_id = $payin_id ";
    $sql .= "AND ";
    $sql .= "   t_payin_h.shop_id = $shop_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $payin_h_def_data = pg_fetch_array($res, 0);

    // ����ǡ�������
    $sql  = "SELECT ";
    $sql .= "   t_payin_d.trade_id, ";
    $sql .= "   t_payin_d.amount,  ";
    $sql .= "   t_bank.bank_id, ";
    $sql .= "   t_payin_d.bank_cd AS verify_bank_cd, ";
    $sql .= "   t_payin_d.bank_name AS verify_bank_name, ";
    $sql .= "   t_b_bank.b_bank_id, ";
    $sql .= "   t_payin_d.b_bank_cd AS verify_b_bank_cd, ";
    $sql .= "   t_payin_d.b_bank_name AS verify_b_bank_name, ";
    $sql .= "   t_payin_d.account_id, ";
    $sql .= "   CASE t_payin_d.deposit_kind ";
    $sql .= "       WHEN '1' THEN '����' ";
    $sql .= "       WHEN '2' THEN '����' ";
    $sql .= "   END ";
    $sql .= "   AS verify_deposit, ";
    $sql .= "   t_payin_d.account_no AS verify_account_no, ";
    $sql .= "   t_payin_d.payable_day, ";
    $sql .= "   t_payin_d.payable_no, ";
    $sql .= "   t_payin_d.note ";
    $sql .= "FROM ";
    $sql .= "   t_payin_d ";
    $sql .= "   LEFT JOIN t_payin_h ON t_payin_d.pay_id = t_payin_h.pay_id ";
    $sql .= "   LEFT JOIN t_account ON t_payin_d.account_id = t_account.account_id ";
    $sql .= "   LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
    $sql .= "WHERE ";
    $sql .= "   t_payin_h.pay_id = $payin_id ";
    $sql .= "AND ";
    $sql .= "   t_payin_h.shop_id = $shop_id ";
    $sql .= "ORDER BY ";
    $sql .= "   t_payin_d.pay_d_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $payin_d_def_rows = pg_num_rows($res);
    while ($data_list = pg_fetch_array($res)){
        $payin_d_def_data[] = $data_list;
    }

    /*** �ե�����˥ǡ����򥻥å� ***/
    // ����إå��μ����ǡ�����ե�����˥��å�
    $payin_h_def_fdata["form_payin_no"]         = $payin_h_def_data["pay_no"];
    $payin_h_def_fdata["form_client"]["cd1"]    = ($verify_only_flg != true) ? $payin_h_def_data["client_cd1"]
                                                                             : $payin_h_def_data["verify_client_cd1"];
    $payin_h_def_fdata["form_client"]["cd2"]    = ($verify_only_flg != true) ? $payin_h_def_data["client_cd2"]
                                                                             : $payin_h_def_data["verify_client_cd2"];
    $payin_h_def_fdata["form_client"]["name"]   = ($verify_only_flg != true) ? $payin_h_def_data["client_cname"]
                                                                             : $payin_h_def_data["verify_client_cname"];
    $payin_h_def_fdata["form_payin_date"]["y"]  = substr($payin_h_def_data["pay_day"], 0, 4);
    $payin_h_def_fdata["form_payin_date"]["m"]  = substr($payin_h_def_data["pay_day"], 5, 2);
    $payin_h_def_fdata["form_payin_date"]["d"]  = substr($payin_h_def_data["pay_day"], 8, 2);
    $payin_h_def_fdata["form_bill_no"]          = $payin_h_def_data["bill_no"];
    $payin_h_def_fdata["form_claim_select"]     = ($verify_only_flg != true) ? $payin_h_def_data["claim_div"]
                                                                             : htmlspecialchars($payin_h_def_data["verify_claim_cd1"])." - ".
                                                                               htmlspecialchars($payin_h_def_data["verify_claim_cd2"])." ".
                                                                               htmlspecialchars($payin_h_def_data["verify_claim_cname"]);
    $payin_h_def_fdata["client_id"]             = $payin_h_def_data["client_id"];
    $form->setConstants($payin_h_def_fdata);

    // ����ǡ����μ����ǡ�����ե�����˥��å�
    foreach ($payin_d_def_data as $key => $value){
        $payin_d_def_fdata["form_trade_$key"]               = $value["trade_id"];
        $payin_d_def_fdata["form_amount_$key"]              = $value["amount"];
        $payin_d_def_fdata["form_bank_$key"][0]             = ($verify_only_flg != true) ? $value["bank_id"]
                                                                                         : htmlspecialchars($value["verify_bank_cd"])." �� ".htmlspecialchars($value["verify_bank_name"]);
        $payin_d_def_fdata["form_bank_$key"][1]             = ($verify_only_flg != true) ? $value["b_bank_id"]
                                                                                         : htmlspecialchars($value["verify_b_bank_cd"])." �� ".htmlspecialchars($value["verify_b_bank_name"]);
        $payin_d_def_fdata["form_bank_$key"][2]             = ($verify_only_flg != true) ? $value["account_id"]
                                                                                         : htmlspecialchars($value["verify_deposit"])." �� ".htmlspecialchars($value["verify_account_no"]);
        $payin_d_def_fdata["form_limit_date_".$key."[y]"]   = substr($value["payable_day"], 0, 4);
        $payin_d_def_fdata["form_limit_date_".$key."[m]"]   = substr($value["payable_day"], 5, 2);
        $payin_d_def_fdata["form_limit_date_".$key."[d]"]   = substr($value["payable_day"], 8, 2);
        $payin_d_def_fdata["form_bill_paper_no_$key"]       = $value["payable_no"];
        $payin_d_def_fdata["form_note_$key"]                = $value["note"];
    }
    $form->setConstants($payin_d_def_fdata);

    // ������ID���ѿ�������
    $client_id = $payin_h_def_data["client_id"];
    // ����ID���ѿ�������
    $form_bill_id = $payin_h_def_data["bill_id"];

}

// ���������ļ��ڡ�����������ܤ�̵�����
if ($state == "new" && $post != $mod_me){

    // �����ֹ��ư����
    $sql  = "SELECT ";
    $sql .= "   MAX(pay_no) ";
    $sql .= "FROM ";
    $sql .= ($group_kind == "2") ? " t_payin_no_serial " : " t_payin_h ";   // ľ�Ĥλ��������ֹ�ơ��֥뤫�����
    $sql .= ($group_kind != "2") ? " WHERE shop_id = $shop_id " : null;
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $payin_no = str_pad(pg_fetch_result($res, 0 ,0)+1, 8, "0", STR_PAD_LEFT);
    $def_data["form_payin_no"] = $payin_no;
    $form->setDefaults($def_data);

}


/****************************/
// ������ե���������ϡ��䴰����
/****************************/
// �����踡���ե饰��true�ξ��
if ($_POST["client_search_flg"] == true){

    // POST���줿�����襳���ɤ��ѿ�������
    $client_cd1 = $_POST["form_client"]["cd1"];
    $client_cd2 = $_POST["form_client"]["cd2"];

    // ������ξ�������
    $sql  = "SELECT ";
    $sql .= "   client_id,";
    $sql .= "   client_cname ";
    $sql .= "FROM ";
    $sql .= "   t_client ";
    $sql .= "WHERE ";
    $sql .= "   client_cd1 = '$client_cd1' ";
    $sql .= "AND ";
    $sql .= "   client_cd2 = '$client_cd2' ";
    $sql .= "AND ";
    $sql .= "   client_div = '3' ";
//    $sql .= "AND ";
//    $sql .= "   state = '1' ";
    $sql .= "AND ";
    $sql .= "   shop_id = $shop_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // �����ǡ�����������
    if ($num > 0){
        $client_id      = pg_fetch_result($res, 0, 0);      // ������ID
        $client_name    = pg_fetch_result($res, 0, 1);      // ������̾��ά�Ρ�
        $claim_div      = 1;                                // �������ʬ����ǥե���Ȥǥ��å�
    }else{
        $client_id      = "";
        $client_name    = "";
        $claim_div      = "";
    }
    // �����襳�������ϥե饰�򥯥ꥢ
    // ������ID��������̾��ά�Ρˡ��������ʬ��ե�����˥��å�
    $client_data["client_search_flg"]   = "";
    $client_data["client_id"]           = $client_id;
    $client_data["form_client"]["name"] = $client_name;
    $client_data["form_claim_select"]   = $claim_div;
    $form->setConstants($client_data);

}


/****************************/
// �Կ���Ϣ����
/****************************/
/*** ������� ***/
// ����Կ���POST����Ƥ�����
if ($_POST["max_row"] != null){

    // POST���줿����Կ����ѿ�������
    $max_row = $_POST["max_row"];

// ����Կ���POST����Ƥ��ʤ����
}else{

    // �ѹ��ξ�������ǡ������
    // �����ξ��ϥǥե����
    $max_row = ($state == "chg") ? $payin_d_def_rows : 5;

}

/*** ���ɲ����� ***/
// ���ɲåե饰��true�ξ��
if ($_POST["add_row_flg"] == true){

    // �����+5
    $max_row = $max_row+5;

    // ���ɲåե饰�򥯥ꥢ
    $clear_hdn_flg["add_row_flg"] = "";
    $form->setConstants($clear_hdn_flg);

}

/*** �Կ���hidden�� ***/
// �Կ���hidden�˳�Ǽ
$row_num_data["max_row"] = $max_row;
$form->setConstants($row_num_data);


// hidden�ιԺ������POST���줿���
if ($_POST["ary_del_rows"] != null){

    // ����ޤǤ˺�����줿�����Ƥ������������������
    foreach ($_POST["ary_del_rows"] as $key => $value){
        $ary_del_row_history[] = $value;
    }

}

/*** �Ժ������ ***/
// ������ֹ椬POST���줿���
if ($_POST["del_row_no"] != null){

    // ������ֹ����
    $del_row_no = $_POST["del_row_no"];

    // ������ֹ����������������ɲ�
    $ary_del_row_history[] = $_POST["del_row_no"];

    // ��������������hidden�˥��å�
    $del_rows_data["ary_del_rows"] = $ary_del_row_history;
    $form->setConstants($del_rows_data);

    // hidden�κ�����ֹ�򥯥ꥢ
    $clear_hdn_data["del_row_no"] = "";
    $form->setConstants($clear_hdn_data);

}

// �Ժ�������٤�Ԥ��Ƥ��ʤ����
if ($_POST["ary_del_rows"] == null && $_POST["del_row_no"] == null){

    // ���κ���Գ�Ǽ����������
    $ary_del_row_history = array();

}


/****************************/
// ��۹�׻��н���
/****************************/
// ��۹�׻��Хե饰��true���ޤ�������ܥ��󤬲������줿���
if ($calc_flg == true || $_POST["form_verify_btn"] != null){

    $total_amount = 0;
    $rebate_amount = 0;

    // �Կ�ʬ�ʺ���ѹԴޤ�˥롼��
    for ($i=0; $i<$max_row; $i++){

        // ���������ˤ���Ԥϥ��롼
        if (!in_array($i, $ary_del_row_history)){

            // ���Ƥζ�ۤ�û����Ƥ���
            $total_amount += $_POST["form_amount_$i"];

            // �����Ԥμ����ʬ��������ξ��
            $rebate_amount += ($_POST["form_trade_$i"] == 35) ? $_POST["form_amount_$i"] : null;

        }

    }

    // hidden�ζ�۹�ץե饰����
    // ��ۤι�פ�ե�����˥��å�
    $amount_sum_data["calc_flg"]            = "";
    $amount_sum_data["form_amount_total"]   = number_format($total_amount - $rebate_amount);
    $amount_sum_data["form_rebate_total"]   = number_format($rebate_amount);
    $amount_sum_data["form_payin_total"]    = number_format($total_amount);
    $form->setConstants($amount_sum_data);

}

// �ѹ������ļ��ڡ�����������ܤ�̵�����
if ($state == "chg" && $post != $mod_me){

    $total_amount = 0;
    $rebate_amount = 0;

    foreach ($payin_d_def_data as $key => $value){

        // ���Ƥζ�ۤ�û����Ƥ���
        $total_amount += $value["amount"];

        // �����쥳���ɤμ����ʬ��������ξ��
        $rebate_amount += ($value["trade_id"] == 35) ? $value["amount"] : 0;

    }

    // ��ۤι�פ�ե�����˥��å�
    $amount_sum_data["form_amount_total"]   = number_format($total_amount - $rebate_amount);
    $amount_sum_data["form_rebate_total"]   = number_format($rebate_amount);
    $amount_sum_data["form_payin_total"]    = number_format($total_amount);
    $form->setConstants($amount_sum_data);

}


/****************************/
// �ե�����ѡ������
/****************************/
// �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => "./1-2-403.php", "������" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list);

// �����ֹ�
$form->addElement(
    "text", "form_payin_no", "",
    "size=\"11\" maxLength=\"8\" style=\"color: #525552; border: #ffffff 1px solid; background-color: #ffffff; text-align: left\" readonly'"
);

// ������
$text = null;
$verify_freeze_header[] = $text[] =& $form->createElement("text", "cd1", "", 
    "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
     onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\"
     onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\" ".$g_form_option."\""
);
$verify_freeze_header[] = $text[] =& $form->createElement("static", "", "", "-");
$verify_freeze_header[] = $text[] =& $form->createElement("text", "cd2", "",
    "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
     onChange=\"javascript:Button_Submit('client_search_flg','#','true', this)\" ".$g_form_option."\""
);
$verify_freeze_header[] = $text[] =& $form->createElement("text", "name", "", "size=\"34\" $g_text_readonly");
$form->addGroup($text, "form_client", "");

// ���
$form->addElement("static", "form_c_bank", "", "");
// ��Ź
$form->addElement("static", "form_c_b_bank", "", "");
// ����
$form->addElement("static", "form_c_account", "", "");

// ������
$text = null;
$verify_freeze_header[] = $text[] =& $form->createElement("text", "y", "", 
    "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_payin_date[y]','form_payin_date[m]',4)\"
     onFocus=\"onForm_today(this,this.form,'form_payin_date[y]','form_payin_date[m]','form_payin_date[d]')\"
     onBlur=\"blurForm(this)\""
);
$verify_freeze_header[] = $text[] =& $form->createElement("static", "", "", "-");
$verify_freeze_header[] = $text[] =& $form->createElement("text", "m", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_payin_date[m]','form_payin_date[d]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_payin_date[y]','form_payin_date[m]','form_payin_date[d]')\"
     onBlur=\"blurForm(this)\""
);
$verify_freeze_header[] = $text[] =& $form->createElement("static", "", "", "-");
$verify_freeze_header[] = $text[] =& $form->createElement("text", "d", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onFocus=\"onForm_today(this,this.form,'form_payin_date[y]','form_payin_date[m]','form_payin_date[d]')\"
     onBlur=\"blurForm(this)\""
);
$form->addGroup($text, "form_payin_date", "");

// �����ֹ�
/*
$verify_freeze_header[] = $form->addElement("text", "form_bill_no", "",
    "size=\"9\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option"
);
*/
$form->addElement("hidden", "form_bill_no");

// ������
// ��ǧ���̤ξ�����Ͽľ��ϴޤޤʤ���
if ($verify_only_flg == true){
    $form->addElement("static", "form_claim_select", "", "");
// �ѹ����̤ξ�����Ͽľ��γ�ǧ���̤�ޤ��
}else{
    $select_value = "";
    $select_value = ($client_id != null) ? Select_Get($db_con, "claim_payin", "t_claim.client_id = $client_id ") : null;
    unset($select_value[null]);
//    $verify_freeze_header[] = $form->addElement("select", "form_claim_select", "", $select_value, $g_form_option_select);
    $verify_freeze_header[] = $form->addElement("select", "form_claim_select", "", $select_value, "onChange=\"Pay_Account_Name(); Bill_No_Amount();\"");
}

// ����۹��
$form->addElement(
    "text", "form_amount_total", "",
    "size=\"16\" maxLength=\"18\"
     style=\"$g_form_style; color: #585858; border: #FFFFFF 1px solid; background-color: #FFFFFF; text-align: right\"
     readonly'"
);

// ��������
$form->addElement(
    "text", "form_rebate_total", "",
    "size=\"16\" maxLength=\"18\" 
     style=\"color: #585858; border: #FFFFFF 1px solid; background-color: #FFFFFF; text-align: right\" 
     readonly"
);

// ���
$form->addElement(
    "text", "form_payin_total", "",
    "size=\"16\" maxLength=\"18\"
     style=\"$g_form_style; color: #585858; border: #FFFFFF 1px solid; background-color: #FFFFFF; text-align: right\"
     readonly'"
);

// hidden
$form->addElement("hidden", "hdn_state", null, null);               // ���ơ�����
$form->addElement("hidden", "client_search_flg", null, null);       // �����襳�������ϥե饰
$form->addElement("hidden", "max_row", null, null);                 // ����Կ�
$form->addElement("hidden", "add_row_flg", null, null);             // ���ɲåե饰
$form->addElement("hidden", "del_row_no", null, null);              // ������ֹ�
$form->addElement("hidden", "calc_flg", null, null);                // ��۹�׻��Хե饰
for ($i=0; $i<count($ary_del_row_history); $i++){
    $form->addElement("hidden", "ary_del_rows[$i]", null, null);    // ������ֹ�����   # ���������ʬ��������
}
$form->addElement("hidden", "payin_id", null, null);                // ����ID
$form->addElement("hidden", "client_id", null, null);               // ������ID
$form->addElement("hidden", "post", null, null);                    // �ڡ���POST
$form->addElement("hidden", "hdn_enter_date", null, null);          // ��ɼ��������
$form->addElement("hidden", "hdn_enter_date", null, null);          // ��ɼ��������
$form->addElement("hidden", "hdn_c_bank_cd", null, null);           // ��ԥ�����
$form->addElement("hidden", "hdn_c_bank_name", null, null);         // ���̾
$form->addElement("hidden", "hdn_c_b_bank_cd", null, null);         // ��Ź������
$form->addElement("hidden", "hdn_c_b_bank_name", null, null);       // ��Ź̾
$form->addElement("hidden", "hdn_c_deposit_kind", null, null);      // �¶����
$form->addElement("hidden", "hdn_c_account_no", null, null);        // �����ֹ�

// ���顼���å����ѥե�����
$form->addElement("text", "err_illegal_verify", null, null);        // ����POST
$form->addElement("text", "err_noway_forms", null, null);           // ����ǡ���̤����
$form->addElement("text", "err_plural_rebate", null, null);         // �����ʣ����
// ����Կ�ʬ�ʺ���ѹԴޤ�˥롼��
for ($i=0, $j=1; $i<$max_row; $i++){
    // ���������ˤ���Ԥϥ��롼
    if (!in_array($i, $ary_del_row_history)){
        $form->addElement("text", "err_trade1[$j]", null, null);        // �����ʬ1
        $form->addElement("text", "err_amount1[$j]", null, null);       // ���1
        $form->addElement("text", "err_amount2[$j]", null, null);       // ���2
        $form->addElement("text", "err_bank1[$j]", null, null);         // ���1
        $form->addElement("text", "err_bank2[$j]", null, null);         // ���2
        $form->addElement("text", "err_limit_date1[$j]", null, null);   // �������1
        $form->addElement("text", "err_limit_date2[$j]", null, null);   // �������2
        $form->addElement("text", "err_limit_date3[$j]", null, null);   // �������3
    }
    $j++;
}


/****************************/
// �����襳���ɤ��Խ���������ǧ���̤إܥ��󤬲������줿�����н����
/****************************/
// �����ǧ���̤إܥ��󤬲����줿�����������踡���ե饰true�ξ��
if ($_POST["form_verify_btn"] != null && $_POST["client_search_flg"] == true){

    // hidden��������ID����Ǽ����Ƥ�����
    if ($_POST["client_id"] != null){
        // hidden�˳�Ǽ����Ƥ���������ID��POST���줿�����襳���ɤ�������������å�
        $sql  = "SELECT ";
        $sql .= "   client_id ";
        $sql .= "FROM ";
        $sql .= "   t_client ";
        $sql .= "WHERE ";
        $sql .= "   client_id = ".$_POST["client_id"]." ";
        $sql .= "AND ";
        $sql .= "   client_cd1 = '".$_POST["form_client"]["cd1"]."' ";
        $sql .= "AND ";
        $sql .= "   client_cd2 = '".$_POST["form_client"]["cd2"]."' ";
        $sql .= "AND ";
        $sql .= "   client_div = '3' ";
//        $sql .= "AND ";
//        $sql .= "   state = '1' ";
        $sql .= "AND ";
        $sql .= "   shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        // ��̤�����POST�ե饰��
        $illegal_verify_flg = ($num > 0) ? false : true;
    // hidden��������ID����Ǽ����Ƥ��ʤ����
    }else{
        // ����POST�ե饰��true��
        $illegal_verify_flg = true;
    }

    // ����POST�ե饰true�ξ��ϥ��顼�򥻥å�
    if ($illegal_verify_flg == true){
        $form->setElementError("err_illegal_verify", "���������������� �����ǧ���̤إܥ��� ��������ޤ�����<br>������ľ���Ƥ���������");
    }

}


/****************************/
// ���顼�����å� - addRule
/****************************/
// �����ǧ���̤إܥ��󤬲������줿���
if ($_POST["form_verify_btn"] != null){

    /*** �����å��������פ��͡�POST�ǡ������ѿ��� ***/
    // �إå����ե�����ǡ������ѿ���
    $post_payin_no      = $_POST["form_payin_no"];
    $post_payin_date_y  = $_POST["form_payin_date"]["y"];
    $post_payin_date_m  = $_POST["form_payin_date"]["m"];
    $post_payin_date_d  = $_POST["form_payin_date"]["d"];
    $post_bill_no       = $_POST["form_bill_no"];
    $post_claim_div     = $_POST["form_claim_select"];

    // �ǡ������ե�����ǡ������ѿ���
    // ����Կ�ʬ�ʺ���ѹԴޤ�˥롼��
    for ($i=0; $i<$max_row; $i++){
        // ���������ˤ���Ԥ�ɽ�������ʤ�
        if (!in_array($i, $ary_del_row_history)){
            $post_trade[$i]         = $_POST["form_trade_$i"];
            $post_amount[$i]        = $_POST["form_amount_$i"];
            $post_bank[$i]          = $_POST["form_bank_$i"][0];
            $post_b_bank[$i]        = $_POST["form_bank_$i"][1];
            $post_account[$i]       = $_POST["form_bank_$i"][2];
            $post_limit_date_y[$i]  = $_POST["form_limit_date_$i"]["y"];
            $post_limit_date_m[$i]  = $_POST["form_limit_date_$i"]["m"];
            $post_limit_date_d[$i]  = $_POST["form_limit_date_$i"]["d"];
            $post_bill_paper_no[$i] = $_POST["form_bill_paper_no_$i"];
            $post_note[$i]          = $_POST["form_note_$i"];
        }
    }

    /****************************/
    // �إå��������å�
    /****************************/
    // ����POST�ե饰��true�Ǥʤ����
    if ($illegal_verify_flg != true){
        /*** ������ ***/
        // ��ɬ�ܥ����å�
        $err_msg = "������ �����襳���� �����Ϥ��Ʋ�������";
        $form->addGroupRule("form_client", array(
            "cd1" => array(
                array($err_msg, "required"),
                array($err_msg, "regex", "/^[0-9]+$/")
            ),
            "cd2" => array(
                array($err_msg, "required"),
                array($err_msg, "regex", "/^[0-9]+$/")
            ),
            "name" => array(
                array($err_msg, "required")
            )
        ));
    }

    /*** ������ ***/
    // ��ɬ�ܥ����å�
    // ��Ⱦ�ѿ��������å�
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    $form->addGroupRule("form_payin_date", array(
        "y" => array(
            array($err_msg, "required"),
            array($err_msg, "regex", "/^[0-9]+$/")
        ),      
        "m" => array(
            array($err_msg, "required"),
            array($err_msg, "regex", "/^[0-9]+$/")
        ),       
        "d" => array(
            array($err_msg, "required"),
            array($err_msg, "regex", "/^[0-9]+$/")
        )
    ));

    /*** ������ ***/
    // ��ɬ�ܥ����å�
    $form->addRule("form_claim_select", "������ �����򤵤�Ƥ��ޤ���", "required");

    /****************************/
    // addRuleŬ�ѷ�̼���
    /****************************/
    /*** �����å�Ŭ�� ***/
    $form->validate();

    /*** ��̽��� ***/
    // ���顼�Τ���ե�����Υե�����̾���Ǽ���뤿�����������
    $ary_addrule_err_forms = array();
    // ���顼�Τ���ե�����Υե�����̾������˳�Ǽ
    foreach ($form as $key1 => $value1){
        if ($key1 == "_errors"){
            foreach ($value1 as $key2 => $value2){
                $ary_addrule_err_forms[] = $key2;
            }
        }
    }

}


/****************************/
// ���顼�����å� - PHP
/****************************/
// �����ǧ���̤إܥ��󤬲������줿���
if ($_POST["form_verify_btn"] != null){

    // ���������򥨥顼��̵������������POST�ե饰��true�Ǥʤ����
    if (!in_array("form_claim_select", $ary_addrule_err_forms) && $illegal_verify_flg != true){
        // ���򤵤줿�������������ID�����
        $sql  = "SELECT ";
        $sql .= "   t_client.client_id ";
        $sql .= "FROM ";
        $sql .= "   t_claim ";
        $sql .= "   INNER JOIN t_client ON t_claim.claim_id = t_client.client_id ";
        $sql .= "WHERE ";
        $sql .= "   t_claim.client_id = $client_id ";
        $sql .= "AND ";
        $sql .= "   t_claim.claim_div = $post_claim_div ";
        $sql .= "AND ";
        $sql .= "   shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $claim_id = @pg_fetch_result($res, 0);
    }

    /****************************/
    // �إå��������å�
    /****************************/
    /*** ������ ***/
    // �����դȤ��Ƥ������������å�
    if (!in_array("form_payin_date", $ary_addrule_err_forms)){
        // ���դȤ��ƥ��顼�ξ��
        if(!checkdate((int)$post_payin_date_m, (int)$post_payin_date_d, (int)$post_payin_date_y)){
            // ���顼�򥻥å�
            $form->setElementError("form_payin_date", "������ �����դ������ǤϤ���ޤ���");
            $payin_date_err_flg = true;
        }
    }

    // �������ƥ೫�������������å�
    if (!in_array("form_payin_date", $ary_addrule_err_forms) && $payin_date_err_flg != true){
        $chk_res = Sys_Start_Date_Chk($post_payin_date_y, $post_payin_date_m, $post_payin_date_d, "������");
        if ($chk_res != null){
            $form->setElementError("form_payin_date", $chk_res);
            $payin_date_err_flg = true;
        }
    }

    // ��̤�����դ����Ϥ���Ƥ��ʤ��������å�
    if (!in_array("form_payin_date", $ary_addrule_err_forms) && $payin_date_err_flg != true){
        $post_payin_date_y2 = str_pad($post_payin_date_y, 4, "0", STR_PAD_LEFT);
        $post_payin_date_m2 = str_pad($post_payin_date_m, 2, "0", STR_PAD_LEFT);
        $post_payin_date_d2 = str_pad($post_payin_date_d, 2, "0", STR_PAD_LEFT);
        // ̤�����դξ��
        if (date("Y-m-d") < $post_payin_date_y2."-".$post_payin_date_m2."-".$post_payin_date_d2){
            // ���顼�򥻥å�
            $form->setElementError("form_payin_date", "������ ��̤������դˤʤäƤ��ޤ���");
            $payin_date_err_flg = true;
        }
    }

    // ���ǿ��η�������������դ����Ϥ���Ƥ��ʤ��������å�
    if (!in_array("form_payin_date", $ary_addrule_err_forms) && $payin_date_err_flg != true){
        // �ǿ��η�����������
        $sql  = "SELECT ";
        $sql .= "   to_date(MAX(close_day), 'YYYY-MM-DD') AS close_day ";
        $sql .= "FROM ";
        $sql .= "   t_sys_renew ";
        $sql .= "WHERE ";
        $sql .= "   renew_div = '2' ";
        $sql .= "AND ";
        $sql .= "   shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        $last_monthly_renew_date = ($num == 1) ? pg_fetch_result($res, 0) : null;
        // ���������������
        if ($last_monthly_renew_date != null){
            // �ǽ��η���������������դξ��
            $post_payin_date_y2 = str_pad($post_payin_date_y, 4, "0", STR_PAD_LEFT);
            $post_payin_date_m2 = str_pad($post_payin_date_m, 2, "0", STR_PAD_LEFT);
            $post_payin_date_d2 = str_pad($post_payin_date_d, 2, "0", STR_PAD_LEFT);
            if ($post_payin_date_y2."-".$post_payin_date_m2."-".$post_payin_date_d2 <= $last_monthly_renew_date){
                // ���顼�򥻥å�
                $form->setElementError("form_payin_date", "������ ������η�������������դ����Ϥ���Ƥ��ޤ���");
                $payin_date_err_flg = true;
            }
        }
    }

    // ������������������������դ����Ϥ���Ƥ��ʤ��������å�
    if ($payin_date_err_flg != true && !in_array("form_claim_select", $ary_addrule_err_forms) && $illegal_verify_flg != true){
        // �ǿ�����������������
        $sql  = "SELECT ";
        $sql .= "   MAX(t_bill_d.bill_close_day_this) ";
        $sql .= "FROM ";
        $sql .= "   t_bill ";
        $sql .= "   LEFT JOIN t_bill_d ON t_bill.bill_id = t_bill_d.bill_id ";
        $sql .= "WHERE ";
        //aoyama-n 2009-07-27
        #$sql .= "   t_bill.claim_id = $claim_id ";
        $sql .= "   t_bill_d.claim_div = '1' ";
        $sql .= "AND ";
        $sql .= "   t_bill_d.client_id = $client_id ";
        $sql .= "AND ";
        $sql .= "   t_bill.shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        $last_close_date = ($num > 0) ? pg_fetch_result($res, 0) : null;
        // ������������
        if ($last_close_date != null){
            // ���Ϥ��줿����������������������������ξ��
            $post_payin_date_y = str_pad($post_payin_date_y, 4, "0", STR_PAD_LEFT);
            $post_payin_date_m = str_pad($post_payin_date_m, 2, "0", STR_PAD_LEFT);
            $post_payin_date_d = str_pad($post_payin_date_d, 2, "0", STR_PAD_LEFT);
            if ($post_payin_date_y."-".$post_payin_date_m."-".$post_payin_date_d <= $last_close_date){
                // ���顼�򥻥å�
                $form->setElementError("form_payin_date", "������ ������������������������դ����Ϥ���Ƥ��ޤ���");
//                $form->setElementError("form_payin_date","������ �����������Ѥ����դ����Ϥ���Ƥ��ޤ���<br>���������ѹ����뤫�������������Ʋ�������");
                $payin_date_err_flg = true;
            }
        }
    }

/*
    //�����������������դ������å�
    if ($payin_date_err_flg != true && !in_array("form_client", $ary_addrule_err_forms) &&
        !in_array("form_payin_date", $ary_addrule_err_forms)){
        if(Check_Monthly_Renew($db_con, $client_id, "1", $post_payin_date_y, $post_payin_date_m, $post_payin_date_d) == false){
            $form->setElementError("form_payin_date","������ ������η�������������դ����Ϥ���Ƥ��ޤ���");
            $payin_date_err_flg = true;
        }
    }

    //���������������������դ������å�
    if ($payin_date_err_flg != true && !in_array("form_claim_select", $ary_addrule_err_forms) &&
        !in_array("form_payin_date", $ary_addrule_err_forms)){
        if(Check_Bill_Close_Day($db_con, $claim_id, $post_payin_date_y, $post_payin_date_m, $post_payin_date_d) == false){
            $form->setElementError("form_payin_date","������ �����������Ѥ����դ����Ϥ���Ƥ��ޤ���<br>���������ѹ����뤫�������������Ʋ�������");
            $payin_date_err_flg = true;
        }
    }
*/

    /*** �����ֹ� ***/
    // �������ֹ�������������å�
/*
    if ($post_bill_no != null && !in_array("form_client", $ary_addrule_err_forms) &&
        !in_array("form_claim_select", $ary_addrule_err_forms) &&
        $illegal_verify_flg != true
    ){
        // �ե��������Ϥ��줿���Ƥ������ֹ椬������Ĵ�٤�
        $sql  = "SELECT \n";
        $sql .= "   t_bill.bill_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_bill \n";
        $sql .= "   LEFT JOIN t_bill_d ON t_bill.bill_id = t_bill_d.bill_id \n";
        $sql .= "WHERE \n";
        $sql .= "   t_bill.bill_no = '$post_bill_no' \n";
        $sql .= "AND \n";
        $sql .= "   t_bill.claim_id IN (SELECT claim_id FROM t_claim WHERE client_id = $client_id AND claim_div = '$post_claim_div') \n";
        $sql .= "AND \n";
        $sql .= "   t_bill.shop_id = ".$_SESSION["client_id"]." \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        // ̵�����
        if ($num == 0){
            // ���顼�򥻥å�
            $form->setElementError("form_bill_no", "�����ֹ� �˸��꤬����ޤ���");
            $bill_no_flg = true;
        }
    }
*/

    /****************************/
    // �ǡ����������å�
    /****************************/
    // ����Կ�ʬ�ʺ���ѹԴޤ�˥롼��
    for ($i=0, $j=1; $i<$max_row; $i++){

        // ���������ˤ���Ԥϥ��롼
        if (!in_array($i, $ary_del_row_history)){

            // �����ԤΥե������1�ĤǤ����Ϥ�����Х��顼�����å���Ԥ�
            if ($post_trade[$i]         != null ||
                $post_amount[$i]        != null ||
                $post_bank[$i]          != null ||
                $post_limit_date_y[$i]  != null ||
                $post_limit_date_m[$i]  != null ||
                $post_limit_date_d[$i]  != null ||
                $post_bill_paper_no[$i] != null ||
                $post_note[$i]          != null)
            {

                /*** �����ʬ ***/
                // ��ɬ�ܥ����å�
                if ($post_trade[$i] == null){
                    $form->setElementError("err_trade1[$j]", $j."���ܡ������ʬ ��ɬ�ܤǤ���");
                    $trade_err_flg[$i] = true;
                }

                /*** ��� ***/
                // ��ɬ�ܥ����å�
                if ($post_amount[$i] == null){
                    $form->setElementError("err_amount1[$j]", $j."���ܡ���� ��ɬ�ܤǤ���");
                    $amount_err_flg[$i] = true;
                }
                // �����ͥ����å�
                if ($amount_err_flg[$i] != true && $post_amount[$i] != null && !ereg("^[-]?[0-9]+$", $post_amount[$i])){
                    $form->setElementError("err_amount2[$j]", $j."���ܡ���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");
                    $amount_err_flg[$i] = true;
                }

                /*** ��� ***/
                // �������ɬ�ܥ����å�
                if (($post_trade[$i] == 32 || $post_trade[$i] == 33 || $post_trade[$i] == 35) && $post_bank[$i] == null){
                    $form->setElementError("err_bank1[$j]", $j."���ܡ������ʬ32, 33, 35�ξ��� ��ԡ���Ź�������ֹ� ��ɬ�ܤǤ���");
                    $bank_err_flg[$i] = true;
                }
                // ��Ⱦü���ϥ����å�
                if ($bank_err_flg != true &&
                    !(($post_bank[$i] != null && $post_b_bank[$i] != null && $post_account[$i] != null) ||
                      ($post_bank[$i] == null && $post_b_bank[$i] == null && $post_account[$i] == null))){
                    $form->setElementError("err_bank2[$j]", $j."���ܡ���� ���ϻ��� �����ֹ� �ޤ����Ϥ��Ƥ���������");
                    $bank_err_flg[$i] = true;
                }

                /*** ������� ***/
                // �������ɬ�ܥ����å�
                if ($post_trade[$i] == 33 &&
                    ($post_limit_date_y[$i] == null && $post_limit_date_m[$i] == null && $post_limit_date_d[$i] == null)){ 
                    $form->setElementError("err_limit_date2[$j]", $j."���ܡ������ʬ�� 33 �ξ��ϡ����������ɬ�ܤǤ���");
                    $limit_date_err_flg[$i] = true;
                }  
                // �����ͥ����å�
                if ($limit_date_err_flg[$i] != true &&
                    ($post_limit_date_y[$i] != null || $post_limit_date_m[$i] != null || $post_limit_date_d[$i] != null) &&
                    (!ereg("^[0-9]+$", $post_limit_date_y[$i]) ||
                     !ereg("^[0-9]+$", $post_limit_date_m[$i]) ||
                     !ereg("^[0-9]+$", $post_limit_date_d[$i]))
                ){
                    $form->setElementError("err_limit_date1[$j]", $j."���ܡ�������� �����դ������ǤϤ���ޤ���");
                    $limit_date_err_flg[$i] = true; 
                }

                // �������ƥ೫�������������å�
                if ($limit_date_err_flg[$i] != true &&
                    ($post_limit_date_y[$i] != null || $post_limit_date_m[$i] != null || $post_limit_date_d[$i] != null)){
                    $chk_res = Sys_Start_Date_Chk($post_limit_date_y[$i], $post_limit_date_m[$i], $post_limit_date_d[$i], "�������");
                    if ($chk_res != null){
                        // ���顼�򥻥å�
                        $form->setElementError("err_limit_date3[$j]", $j."���ܡ�".$chk_res);
                        $limit_date_err_flg[$i] = true; 
                    }
                }
                // �����դȤ��������������å�
                if ($limit_date_err_flg[$i] != true && 
                    ($post_limit_date_y[$i] != null || $post_limit_date_m[$i] != null || $post_limit_date_m[$i] != null)){ 
                    $post_limit_date_y[$i] = (int)$post_limit_date_y[$i];
                    $post_limit_date_m[$i] = (int)$post_limit_date_m[$i];
                    $post_limit_date_d[$i] = (int)$post_limit_date_d[$i];
                    if (!checkdate($post_limit_date_m[$i], $post_limit_date_d[$i], $post_limit_date_y[$i])){
                        $form->setElementError("err_limit_date1[$j]", $j."���ܡ�������� �����դ������ǤϤ���ޤ���");
                        $limit_date_err_flg[$i] = true; 
                    }
                }

                // �����ʬ�ּ�����פιԤ򥫥����
                ($post_trade[$i] == "35") ? $rebate_rows[] = $i : null; 

            // ���Ϥ�̵���Ԥξ��
            }else{

                // ���Ϥ�̵���Ԥι��ֹ��������������Ƥ���
                $ary_noway_forms[] = $i;

            }

            // �ºݤ�ɽ������Ƥ���ʺ������Ƥ��ʤ��˹Կ���������뤿����ֹ��������������Ƥ���
            $ary_all_forms[] = $i;

            // ���ֹ楫���󥿡ʥ��顼��å������ιԿ�ɽ���ѡ�
            $j++;

        }

    }

    /*** ����ǡ��� ***/
    // ������0������å�
    // �ºݤ�ɽ������Ƥ���Կ��ȡ����Ϥ�̵���Կ���Ʊ�����
    if (count($ary_noway_forms) == count($ary_all_forms)){
        $form->setElementError("err_noway_forms", "����ǡ��� �����Ϥ��Ʋ�������");
    }

    // �����ʬ�ּ������ʣ���ԥ����å�
    if (count($rebate_rows) > 1){
        $form->setElementError("err_plural_rebate", "����� ��1�ԤΤ����ϲ�ǽ�Ǥ���");
    }

}


/****************************
// �����顼�����å���̽���
/****************************/
// �����ǧ���̤إܥ��󤬲������줿����������POST�ե饰��true�Ǥʤ����
if ($_POST["form_verify_btn"] != null && $illegal_verify_flg != true){

    /*** ��̽��� ***/
    // ���顼�Τ���ե�����Υե�����̾���Ǽ���뤿�����������
    $ary_all_err_forms = array();
    // ���顼�Τ���ե�����Υե�����̾������˳�Ǽ
    foreach ($form as $key1 => $value1){
        if ($key1 == "_errors"){
            foreach ($value1 as $key2 => $value2){
                $ary_all_err_forms[] = $key2;
            }
        }
    }
    // ���顼�����0��ξ��ϳ�ǧ�ե饰��true�ˤ���
    $verify_flg = (count($ary_all_err_forms) == 0) ? true : false;

}


/****************************/
// �إå��ե�����ե꡼��
/****************************/
// ��ǧ�ե饰��true���ޤ��ϳ�ǧ�Τߥե饰��true�ξ��
if ($verify_flg == true || $verify_only_flg == true){

    // �إå��ե������ե꡼��
    $verify_freeze_header_form = $form->addGroup($verify_freeze_header, "verify_freeze_header", "");
    $verify_freeze_header_form->freeze();

}


/****************************/
// �������ѹ�����
// ����ǧ���̤�
// ������OK�ܥ���򲡤�����
// ������������������Ƥ����
/****************************/
// ����OK�ܥ��󲡲��������٥ե饰��true�ξ��
if ($_POST["form_ok_btn"] != null && $verify_only_flg == true){

    // ���礦�ɺ���������������Ƥ��ޤ��ޤ����ե饰��true��
    $just_daily_update_flg = true;

    // �ե�����˸�������ǡ�������������������Ͼ�Τۤ��ˤ���ޤ���

}


/****************************/
// �������ѹ�����
// ����ǧ���̤�
// ������OK�ܥ���򲡤�����
// �����˺������Ƥ����
/****************************/
// ����OK�ܥ��󲡲����ĥ��ơ�������chg�ξ��
if ($_POST["form_ok_btn"] != null && $state == "chg"){

    // ����ID����ɼ�������֤�����ǡ������͹礻
    $same_data_flg = Update_Check($db_con, "t_payin_h", "pay_id", $payin_id, $enter_date);

    // �͹礻���顼�ξ��
    if ($same_data_flg == false){
        // ���顼�ե饰��GET�˻���������λ���̤�����
        header("Location: ./1-2-408.php?ref=view&err=1");
        exit;
    }

}


/****************************/
// ��Ͽ������
/****************************/
// ����OK�ܥ��󲡲��������٥ե饰��true�Ǥʤ����
if ($_POST["form_ok_btn"] != null && $verify_only_flg != true){

    /*** POST�ǡ������ѿ��� ***/
    // �إå����ե�����ǡ������ѿ���
    $post_payin_no          = $_POST["form_payin_no"];
    $post_client_cd1        = $_POST["form_client"]["cd1"];
    $post_client_cd2        = $_POST["form_client"]["cd2"];
    $post_client_name       = $_POST["form_client"]["name"];
    $post_c_bank_cd         = html_entity_decode($_POST["hdn_c_bank_cd"]);
    $post_c_bank_name       = html_entity_decode($_POST["hdn_c_bank_name"]);
    $post_c_b_bank_cd       = html_entity_decode($_POST["hdn_c_b_bank_cd"]);
    $post_c_b_bank_name     = html_entity_decode($_POST["hdn_c_b_bank_name"]);
    $post_c_deposit_kind    = html_entity_decode($_POST["hdn_c_deposit_kind"]);
    $post_c_account_no      = html_entity_decode($_POST["hdn_c_account_no"]);
    $post_payin_date_y      = str_pad($_POST["form_payin_date"]["y"], 4, "0", STR_PAD_LEFT);
    $post_payin_date_m      = str_pad($_POST["form_payin_date"]["m"], 2, "0", STR_PAD_LEFT);
    $post_payin_date_d      = str_pad($_POST["form_payin_date"]["d"], 2, "0", STR_PAD_LEFT);
    $post_payin_date        = $post_payin_date_y."-".$post_payin_date_m."-".$post_payin_date_d;
    $post_bill_no           = $_POST["form_bill_no"];
    $post_claim_div         = $_POST["form_claim_select"];

    // �ǡ������ե�����ǡ������ѿ���
    // ����Կ�ʬ�ʺ���ѹԴޤ�˥롼��
    for ($i=0; $i<$max_row; $i++){

        // ���������ˤ���Ԥϥ��롼
        if (!in_array($i, $ary_del_row_history)){

            // �����ԤΥե������1�ĤǤ����Ϥ�������
            if ($_POST["form_trade_$i"]             != null ||
                $_POST["form_amount_$i"]            != null ||
                $_POST["form_bank_$i"][0]           != null ||
                $_POST["form_bank_$i"][1]           != null ||
                $_POST["form_bank_$i"][2]           != null ||
                $_POST["form_limit_date_$i"]["y"]   != null ||
                $_POST["form_limit_date_$i"]["m"]   != null ||
                $_POST["form_limit_date_$i"]["d"]   != null ||
                $_POST["form_bill_paper_no_$i"]     != null ||
                $_POST["form_note_$i"]              != null)
            {

                $post_trade[$i]         = $_POST["form_trade_$i"];
                $post_amount[$i]        = $_POST["form_amount_$i"];
                $post_bank[$i]          = $_POST["form_bank_$i"][0];
                $post_b_bank[$i]        = $_POST["form_bank_$i"][1];
                $post_account[$i]       = $_POST["form_bank_$i"][2];
                if ($_POST["form_limit_date_$i"]["y"] != null ||
                    $_POST["form_limit_date_$i"]["m"] != null ||
                    $_POST["form_limit_date_$i"]["d"] != null)
                {
                    $post_limit_date_y[$i]  = str_pad($_POST["form_limit_date_$i"]["y"], 4, "0", STR_PAD_LEFT);
                    $post_limit_date_m[$i]  = str_pad($_POST["form_limit_date_$i"]["m"], 2, "0", STR_PAD_LEFT);
                    $post_limit_date_d[$i]  = str_pad($_POST["form_limit_date_$i"]["d"], 2, "0", STR_PAD_LEFT);
                    $post_limit_date[$i]    = $post_limit_date_y[$i]."-".$post_limit_date_m[$i]."-".$post_limit_date_d[$i];
                }else{
                    $post_limit_date[$i]    = null;
                }
                $post_bill_paper_no[$i] = $_POST["form_bill_paper_no_$i"];
                $post_note[$i]          = $_POST["form_note_$i"];

                // �ºݤ����Ϥ�����Ԥι��ֹ�Τߤ�������������Ƥ���
                $ary_insert_forms[] = $i;

            }

        }

    }

    /*** ������������� ***/
    // �����ֹ椬���Ϥ���Ƥ�����
    if ($post_bill_no != null){

        // �����ֹ椬������������ID�����
        $sql  = "SELECT ";
        $sql .= "   t_bill.bill_id, ";
        $sql .= "   t_bill.claim_cd1, ";
        $sql .= "   t_bill.claim_cd2, ";
        $sql .= "   t_bill.claim_cname ";
        $sql .= "FROM ";
        $sql .= "   t_bill ";
        $sql .= "   INNER JOIN t_bill_d ON t_bill.bill_id = t_bill_d.bill_id ";
        $sql .= "WHERE ";
        $sql .= "   t_bill.bill_no = '$post_bill_no' ";
        $sql .= "AND ";
        $sql .= "   t_bill_d.client_id = $client_id ";
        $sql .= "AND ";
        $sql .= "   t_bill_d.claim_div = $post_claim_div ";
//        $sql .= "AND ";
//        $sql .= "   t_bill.last_update_flg = 'f' ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        while ($data_list = @pg_fetch_array($res)){
            $bill_id        = $data_list["bill_id"];
            $claim_cd1      = $data_list["claim_cd1"];
            $claim_cd2      = $data_list["claim_cd2"];
            $claim_cname    = $data_list["claim_cname"];
        }

    // �����ֹ椬̤���Ϥξ��
    }else{

        $sql  = "SELECT ";
        $sql .= "   t_client.client_cd1, ";
        $sql .= "   t_client.client_cd2, ";
        $sql .= "   t_client.client_cname ";
        $sql .= "FROM ";
        $sql .= "   t_claim ";
        $sql .= "   INNER JOIN t_client ON t_claim.claim_id = t_client.client_id ";
        $sql .= "WHERE ";
        $sql .= "   t_claim.client_id = $client_id ";
        $sql .= "AND ";
        $sql .= "   t_claim.claim_div = $post_claim_div ";
        $sql .= "AND ";
        $sql .= "   shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        while ($data_list = @pg_fetch_array($res)){
            $claim_cd1      = $data_list["client_cd1"];
            $claim_cd2      = $data_list["client_cd2"];
            $claim_cname    = $data_list["client_cname"];
        }

    }

    /****************************/
    // ���顼�����å�
    /****************************/
    /*** �����ֹ� ***/
    // ����ʣ�����å�
    if ($state == "new"){
        $sql  = "SELECT ";
        $sql .= "   pay_no ";
        $sql .= "FROM ";
        $sql .= "   t_payin_h ";
        $sql .= "WHERE ";
        $sql .= "   pay_no = '$post_payin_no' ";
        $sql .= "AND ";
        $sql .= "   shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        $duplicate_err_flg = ($num != 0) ? true : false;
        $duplicate_err_msg = ($num != 0) ? "Ʊ���������Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦���������ԤäƤ���������" : null;
    }

    /****************************/
    // DB����
    /****************************/
    /*** �ȥ�󥶥�����󳫻� ***/
    Db_Query($db_con, "BEGIN;");

    /*** ������ ***/
    if ($state == "new" && $duplicate_err_flg != true){

        /* ����إå�INSERT */
        $sql  = "INSERT INTO ";
        $sql .= "   t_payin_h ";
        $sql .= "( ";
        $sql .= "   pay_id, ";
        $sql .= "   pay_no, ";
        $sql .= "   pay_day, ";
        $sql .= "   collect_staff_id, ";
        $sql .= "   collect_staff_name, ";
        $sql .= "   client_id, ";
        $sql .= "   client_cd1, ";
        $sql .= "   client_cd2, ";
        $sql .= "   client_name, ";
        $sql .= "   client_name2, ";
        $sql .= "   client_cname, ";
        $sql .= "   c_bank_cd, ";
        $sql .= "   c_bank_name, ";
        $sql .= "   c_b_bank_cd, ";
        $sql .= "   c_b_bank_name, ";
        $sql .= "   c_deposit_kind, ";
        $sql .= "   c_account_no, ";
        $sql .= "   claim_div, ";
        $sql .= "   pay_name, ";
        $sql .= "   account_name, ";
        $sql .= "   bill_id, ";
        $sql .= "   claim_cd1, ";
        $sql .= "   claim_cd2, ";
        $sql .= "   claim_cname, ";
        $sql .= "   input_day, ";
        $sql .= "   e_staff_id, ";
        $sql .= "   e_staff_name, ";
        $sql .= "   ac_staff_id, ";
        $sql .= "   ac_staff_name, ";
        $sql .= "   sale_id, ";
        $sql .= "   renew_flg, ";
        $sql .= "   renew_day, ";
        $sql .= "   shop_id ";
        $sql .= ") ";
        $sql .= "VALUES ";
        $sql .= "( ";
        $sql .= "   (SELECT COALESCE(MAX(pay_id), 0)+1 FROM t_payin_h), ";
        $sql .= "   '$post_payin_no', ";
        $sql .= "   '$post_payin_date', ";
        $sql .= "   $staff_id, ";
        $sql .= "   '".addslashes($staff_name)."', ";
        $sql .= "   $client_id, ";
        $sql .= "   '$post_client_cd1', ";
        $sql .= "   '$post_client_cd2', ";
        $sql .= "   (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
        $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
        $sql .= "   '$post_client_name', ";
        $sql .= "   '$post_c_bank_cd', ";
        $sql .= "   '$post_c_bank_name', ";
        $sql .= "   '$post_c_b_bank_cd', ";
        $sql .= "   '$post_c_b_bank_name', ";
        $sql .= "   '$post_c_deposit_kind', ";
        $sql .= "   '$post_c_account_no', ";
        $sql .= "   '$post_claim_div', ";
        $sql .= "   (SELECT t_client.pay_name FROM t_claim LEFT JOIN t_client ON t_claim.claim_id = t_client.client_id 
                        WHERE t_claim.client_id = $client_id AND t_claim.claim_div = $post_claim_div), ";
        $sql .= "   (SELECT t_client.account_name FROM t_claim LEFT JOIN t_client ON t_claim.claim_id = t_client.client_id 
                        WHERE t_claim.client_id = $client_id AND t_claim.claim_div = $post_claim_div), ";
        $sql .= ($bill_id != null) ? " $bill_id, " : " NULL, ";
        $sql .= "   '".addslashes($claim_cd1)."', ";
        $sql .= "   '".addslashes($claim_cd2)."', ";
        $sql .= "   '".addslashes($claim_cname)."', ";
        $sql .= "   NOW(), ";
        $sql .= "   $staff_id, ";
        $sql .= "   '".addslashes($staff_name)."', ";
        $sql .= "   $staff_id, ";
        $sql .= "   '".addslashes($staff_name)."', ";
        $sql .= "   NULL, ";
        $sql .= "   'f', ";
        $sql .= "   NULL, ";
        $sql .= "   $shop_id ";
        $sql .= ") ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        // ���顼���ϥ�����Хå�
        if($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /*** ����ǡ���INSERT ***/
        // ����إå�����Ͽ��������ID�����
        $sql  = "SELECT ";
        $sql .= "   pay_id ";
        $sql .= "FROM ";
        $sql .= "   t_payin_h ";
        $sql .= "WHERE ";
        $sql .= "   pay_no = '$post_payin_no' ";
        $sql .= "AND ";
        $sql .= "   shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $payin_id = pg_fetch_result($res, 0);

        // ���ϤΤ���Կ�ʬ�롼��
        foreach ($ary_insert_forms as $key => $i){

            $sql  = "INSERT INTO ";
            $sql .= "   t_payin_d ";
            $sql .= "( ";
            $sql .= "   pay_d_id, ";
            $sql .= "   pay_id, ";
            $sql .= "   trade_id, ";
            $sql .= "   amount, ";
            $sql .= "   bank_cd, ";
            $sql .= "   bank_name, ";
            $sql .= "   b_bank_cd, ";
            $sql .= "   b_bank_name, ";
            $sql .= "   account_id, ";
            $sql .= "   deposit_kind, ";
            $sql .= "   account_no, ";
            $sql .= "   payable_day, ";
            $sql .= "   payable_no, ";
            $sql .= "   note ";
            $sql .= ") ";
            $sql .= "VALUES ";
            $sql .= "( ";
            $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payin_d), ";
            $sql .= "   $payin_id, ";
            $sql .= "   $post_trade[$i], ";
            $sql .= "   '$post_amount[$i]', ";
            $sql .= ($post_bank[$i] != null) ? " (SELECT bank_cd FROM t_bank WHERE bank_id = $post_bank[$i]), " : " NULL, ";
            $sql .= ($post_bank[$i] != null) ? " (SELECT bank_name FROM t_bank WHERE bank_id = $post_bank[$i]), " : " NULL, ";
            $sql .= ($post_b_bank[$i] != null) ? " (SELECT b_bank_cd FROM t_b_bank WHERE b_bank_id = $post_b_bank[$i]), " : " NULL, ";
            $sql .= ($post_b_bank[$i] != null) ? " (SELECT b_bank_name FROM t_b_bank WHERE b_bank_id = $post_b_bank[$i]), " : " NULL, ";
            $sql .= ($post_account[$i] != null) ? " $post_account[$i], " : " NULL, ";
            $sql .= ($post_account[$i] != null) ? " (SELECT deposit_kind FROM t_account WHERE account_id = $post_account[$i]), " : " NULL, ";
            $sql .= ($post_account[$i] != null) ? " (SELECT account_no FROM t_account WHERE account_id = $post_account[$i]), " : " NULL, ";
            $sql .= ($post_limit_date[$i] != null) ? " '$post_limit_date[$i]', " : " NULL, ";
            $sql .= ($post_bill_paper_no[$i] != null) ? " '$post_bill_paper_no[$i]', " : " NULL, ";
            $sql .= "   '$post_note[$i]' ";
            $sql .= ") ";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            // ���顼���ϥ�����Хå�
            if($res == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

        }

        /* �����ֹ�ơ��֥빹�� **/
        // ľ�Ĥξ��
        if ($group_kind == 2){
            $sql  = "INSERT INTO ";
            $sql .= "   t_payin_no_serial ";
            $sql .= "( ";
            $sql .= "   pay_no ";
            $sql .= ") ";
            $sql .= "VALUES ";
            $sql .= "( ";
            $sql .= "   '$post_payin_no' ";
            $sql .= ") ";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            // ���顼���ϥ�����Хå�
            if($res == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }

    }

    /*** �ѹ��� ***/
    if ($state == "chg"){

        /* ����إå�UPDATE */
        $sql  = "UPDATE ";
        $sql .= "   t_payin_h ";
        $sql .= "SET ";
        $sql .= "   pay_no = '$post_payin_no', ";
        $sql .= "   pay_day = '$post_payin_date', ";
        $sql .= "   collect_staff_id = $staff_id, ";
        $sql .= "   collect_staff_name = '".addslashes($staff_name)."', ";
        $sql .= "   client_id = $client_id, ";
        $sql .= "   client_cd1 = '$post_client_cd1', ";
        $sql .= "   client_cd2 = '$post_client_cd2', ";
        $sql .= "   client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
        $sql .= "   client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
        $sql .= "   client_cname = '$post_client_name', ";
        $sql .= "   c_bank_cd = '$post_c_bank_cd', ";
        $sql .= "   c_bank_name = '$post_c_bank_name', ";
        $sql .= "   c_b_bank_cd = '$post_c_b_bank_cd', ";
        $sql .= "   c_b_bank_name = '$post_c_b_bank_name', ";
        $sql .= "   c_deposit_kind = '$post_c_deposit_kind', ";
        $sql .= "   c_account_no = '$post_c_account_no', ";
        $sql .= "   claim_div = '$post_claim_div', ";
        $sql .= "   pay_name = (SELECT t_client.pay_name FROM t_claim LEFT JOIN t_client ON t_claim.claim_id = t_client.client_id 
                        WHERE t_claim.client_id = $client_id AND t_claim.claim_div = $post_claim_div), ";
        $sql .= "   account_name = (SELECT t_client.account_name FROM t_claim LEFT JOIN t_client ON t_claim.claim_id = t_client.client_id 
                        WHERE t_claim.client_id = $client_id AND t_claim.claim_div = $post_claim_div), ";
        $sql .= ($bill_id != null) ? " bill_id = $bill_id, " : null;
        $sql .= "   claim_cd1 = '".addslashes($claim_cd1)."', ";
        $sql .= "   claim_cd2 = '".addslashes($claim_cd2)."', ";
        $sql .= "   claim_cname = '".addslashes($claim_cname)."', ";
        $sql .= "   input_day = NOW(), ";
        $sql .= "   e_staff_id = $staff_id, ";
        $sql .= "   e_staff_name = '".addslashes($staff_name)."', ";
        $sql .= "   ac_staff_id = $staff_id, ";
        $sql .= "   ac_staff_name = '".addslashes($staff_name)."', ";
        $sql .= "   sale_id = NULL, ";
        $sql .= "   renew_flg = 'f', ";
        $sql .= "   renew_day = NULL, ";
        $sql .= "   shop_id = $shop_id ";
        $sql .= "WHERE ";
        $sql .= "   pay_id = $payin_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        // ���顼���ϥ�����Хå�
        if($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /* ����ǡ���DELETE */
        $sql  = "DELETE FROM ";
        $sql .= "   t_payin_d ";
        $sql .= "WHERE ";
        $sql .= "   pay_id = $payin_id ";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        // ���顼���ϥ�����Хå�
        if($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /* ����ǡ���INSERT */
        // ���ϤΤ���Կ�ʬ�롼��
        foreach ($ary_insert_forms as $key => $i){

            $sql  = "INSERT INTO ";
            $sql .= "   t_payin_d ";
            $sql .= "( ";
            $sql .= "   pay_d_id, ";
            $sql .= "   pay_id, ";
            $sql .= "   trade_id, ";
            $sql .= "   amount, ";
            $sql .= "   bank_cd, ";
            $sql .= "   bank_name, ";
            $sql .= "   b_bank_cd, ";
            $sql .= "   b_bank_name, ";
            $sql .= "   account_id, ";
            $sql .= "   deposit_kind, ";
            $sql .= "   account_no, ";
            $sql .= "   payable_day, ";
            $sql .= "   payable_no, ";
            $sql .= "   note ";
            $sql .= ") ";
            $sql .= "VALUES ";
            $sql .= "( ";
            $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payin_d), ";
            $sql .= "   $payin_id, ";
            $sql .= "   $post_trade[$i], ";
            $sql .= "   '$post_amount[$i]', ";
            $sql .= ($post_bank[$i] != null) ? " (SELECT bank_cd FROM t_bank WHERE bank_id = $post_bank[$i]), " : " NULL, ";
            $sql .= ($post_bank[$i] != null) ? " (SELECT bank_name FROM t_bank WHERE bank_id = $post_bank[$i]), " : " NULL, ";
            $sql .= ($post_b_bank[$i] != null) ? " (SELECT b_bank_cd FROM t_b_bank WHERE b_bank_id = $post_b_bank[$i]), " : " NULL, ";
            $sql .= ($post_b_bank[$i] != null) ? " (SELECT b_bank_name FROM t_b_bank WHERE b_bank_id = $post_b_bank[$i]), " : " NULL, ";
            $sql .= ($post_account[$i] != null) ? " $post_account[$i], " : " NULL, ";
            $sql .= ($post_account[$i] != null) ? " (SELECT deposit_kind FROM t_account WHERE account_id = $post_account[$i]), " : " NULL, ";
            $sql .= ($post_account[$i] != null) ? " (SELECT account_no FROM t_account WHERE account_id = $post_account[$i]), " : " NULL, ";
            $sql .= ($post_limit_date[$i] != null) ? " '$post_limit_date[$i]', " : " NULL, ";
            $sql .= ($post_bill_paper_no[$i] != null) ? " '$post_bill_paper_no[$i]', " : " NULL, ";
            $sql .= "   '$post_note[$i]' ";
            $sql .= ") ";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            // ���顼���ϥ�����Хå�
            if($res == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

        }

    }

    /*** �ȥ�󥶥�����󴰷� ***/
    Db_Query($db_con, "COMMIT;");

    /****************************/
    // �ڡ�������
    /****************************/
    // ��ʣ���顼�ξ��
    if ($duplicate_err_flg == true){

        // �����ֹ��ư����
        $sql  = "SELECT ";
        $sql .= "   MAX(pay_no) ";
        $sql .= "FROM ";
        $sql .= "   t_payin_h ";
        $sql .= "WHERE ";
        $sql .= "   shop_id = $shop_id ";
        $sql .= ";"; 
        $res  = Db_Query($db_con, $sql);
        $payin_no = str_pad(pg_fetch_result($res, 0 ,0)+1, 8, "0", STR_PAD_LEFT);
        $def_data["form_payin_no"] = $payin_no;
        $form->setConstants($def_data);

        // ������ե�����˥ǡ����򥻥å�
        $client_data["form_client"]["cd1"]  = $_POST["form_client"]["cd1"];
        $client_data["form_client"]["cd2"]  = $_POST["form_client"]["cd2"];
        $client_data["form_client"]["name"] = $_POST["form_client"]["name"];
        $form->setConstants($client_data);

    // ��ʣ���顼�Ǥʤ����
    }else{

        header("Location: ./1-2-408.php");

    }

}


/****************************/
// ���ѥե�����ѡ��������ɽ��
/****************************/
// ���쥯�ȥܥå��������ƥ���������
$select_value_trade = ($verify_only_flg == true) ? Select_Get($db_con, "trade_payin")
                                                 : Select_Get($db_con, "trade_payin", " WHERE trade_id NOT IN (39, 40) AND kind = '2' ");
$select_value_bank  = Make_Ary_Bank($db_con);
// ���hierselect��Ϣ��html
$attach_html        = "<br>";

// ����Կ�ʬ�ʺ���ѹԴޤ�˥롼��
for ($i=0, $row_num=0; $i<$max_row; $i++){

    // ���������ˤ���Ԥ�ɽ�������ʤ�
    if (!in_array($i, $ary_del_row_history)){

        $row_num++;

        // ��ǧ���̤ξ��
        if ($verify_flg == true || $verify_only_flg == true){

            // �ե�����θ����ܤ�static�äݤ����뤿���Stylesheet���ѿ�������Ƥ�����Ĺ���Τ��ѿ��ˡ�
            $style = "color: #585858; border: #ffffff 1px solid; background-color: #ffffff;";

            // �����ʬ
            $verify_freeze_data_trade = $form->addElement("select", "form_trade_$i", "", $select_value_trade, $g_form_option_select);
            $verify_freeze_data_trade->freeze();

            // ���
            $form->addElement("text", "form_amount_$i", "",
                "class=\"money\" size=\"11\" maxLength=\"9\" style=\"text-align: right; $style\" readonly"
            );

            // ��ԡ���Ź�������ֹ�
            // ����������ޤ������ID�Τ���ǡ����γ�ǧ���̤ξ��
            if ($verify_only_flg == true){
                $verify_only_bank_form = null;
                $verify_only_bank_form[] = $form->addElement("static", "0", "", "");
                $verify_only_bank_form[] = $form->addElement("static", "1", "", "");
                $verify_only_bank_form[] = $form->addElement("static", "2", "", "");
                $form->addGroup($verify_only_bank_form, "form_bank_".$i, "", $attach_html);
            // ��Ͽ�ܥ��󲡲���γ�ǧ���̤ξ��
            }else{
                $verify_freeze_data_bank = $obj_bank_select =& $form->addElement("hierselect", "form_bank_$i", "", "", $attach_html);
                $obj_bank_select->setOptions($select_value_bank);
                $verify_freeze_data_bank->freeze();
            }

            // ������
            $text = null;
            $text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$style\" readonly");
            $text[] =& $form->createElement("static", "", "", "-");
            $text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$style\" readonly");
            $text[] =& $form->createElement("static", "", "", "-");
            $text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$style\" readonly");
            $form->addGroup($text, "form_limit_date_$i", "");

            // ��������ֹ�
            $form->addElement("text", "form_bill_paper_no_$i", "", "size=\"13\" maxLength=\"10\" style=\"$style\" readonly");

            // ����
            $form->addElement("text", "form_note_$i", "", "size=\"34\" maxLength=\"20\" style=\"$style\" readonly"); 

        // �ѹ���ǽ���̤ξ��
        }else{

            // �����ʬ
            $form->addElement("select", "form_trade_$i", "", $select_value_trade, $g_form_option_select);

            // ���
            $form->addElement("text", "form_amount_$i", "",
                "class=\"money\" size=\"11\" maxLength=\"9\" style=\"text-align: right; $g_form_style\" $g_form_option"
            );

            // ���
            $obj_bank_select =& $form->addElement("hierselect", "form_bank_$i", "", "", $attach_html);
            $obj_bank_select->setOptions($select_value_bank);

            // ������
            $text = null;
            $text[] =& $form->createElement("text", "y", "", 
                "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
                 onkeyup=\"changeText(this.form,'form_limit_date_".$i."[y]','form_limit_date_".$i."[m]',4)\"
                 onFocus=\"onForm_today(this,this.form,'form_limit_date_".$i."[y]','form_limit_date_".$i."[m]','form_limit_date_".$i."[d]')\"
                 onBlur=\"blurForm(this)\""
            );
            $text[] =& $form->createElement("static", "", "", "-");
            $text[] =& $form->createElement("text", "m", "",
                "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
                 onkeyup=\"changeText(this.form,'form_limit_date_".$i."[m]','form_limit_date_".$i."[d]',2)\"
                 onFocus=\"onForm_today(this,this.form,'form_limit_date_".$i."[y]','form_limit_date_".$i."[m]','form_limit_date_".$i."[d]')\"
                 onBlur=\"blurForm(this)\""
            );
            $text[] =& $form->createElement("static", "", "", "-");
            $text[] =& $form->createElement("text", "d", "",
                "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
                 onFocus=\"onForm_today(this,this.form,'form_limit_date_".$i."[y]','form_limit_date_".$i."[m]','form_limit_date_".$i."[d]')\"
                 onBlur=\"blurForm(this)\""
            );
            $form->addGroup($text, "form_limit_date_$i", "");

            // ��������ֹ�
            $form->addElement("text", "form_bill_paper_no_$i", "", "size=\"13\" maxLength=\"10\" style=\"$g_form_style\" $g_form_option\"");

            // ����
            $form->addElement("text", "form_note_$i", "", "size=\"34\" maxLength=\"20\" $g_form_option\""); 

            // ������
            $link_no = ($i+1 == $del_row_no) ? $row_num - 1 : $row_num;
            $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">���</font>",
                "tabindex=-1 onClick=\"javascript:Dialogue_3('������ޤ���', $i, 'del_row_no', $row_num); return false;\""
            );

        }

    }

}


/****************************/
// ���ѥե�����ѡ�������ʥܥ����
/****************************/
/* ��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ� */
if($verify_flg != true && $verify_only_flg != true){

    // ������ñ�̥ܥ���
    $form->addElement("button", "form_trans_client_btn", "������ñ��", $g_button_color." onClick=\"location.href('1-2-402.php')\"");

    // ���ñ�̥ܥ���
    $form->addElement("button", "form_trans_bank_btn", "���ñ��", "onClick=\"location.href('1-2-409.php')\"");

    // ���ɲåܥ���
    $form->addElement("button", "form_add_row_btn", "���ɲ�", "onClick=\"javascript:Button_Submit_1('add_row_flg', '#foot', 'true', this)\"");

    // ��ץܥ���
    $form->addElement("button", "form_calc_btn", "�硡��", "onClick=\"javascript:Button_Submit('calc_flg','#foot','true', this)\"");

    // �����ǧ���̤إܥ���
    $form->addElement("submit", "form_verify_btn", "�����ǧ���̤�", "$disabled");

}

/* ��Ͽľ��γ�ǧ���̤Τ�ɽ�� */
if ($verify_flg == true && $verify_only_flg != true && $just_daily_update_flg != true){

    // ����OK�ܥ���
    $form->addElement("button", "hdn_form_ok_btn", "����ϣ�", "onClick=\"Double_Post_Prevent2(this);\" $disabled");

    // ����OKhidden
    $form->addElement("hidden", "form_ok_btn");

    // ���ܥ���
    $form->addElement("button", "form_return_btn", "�ᡡ��", "onClick=\"javascript:SubMenu2('#')\"");
}

/* ���������Ѥޤ������ID�Τ���ǡ����γ�ǧ���Τ�ɽ�� */
if ($verify_flg != true && $verify_only_flg == true && $just_daily_update_flg != true){

    // ���ܥ���
    $form->addElement("button", "form_return_btn", "�ᡡ��", "onClick=\"javascript:history.back()\"");

}

/* �����ѹ�������OK�򲡤����������������줤���ѹ��Ǥ��ʤ��ä���� */
if ($just_daily_update_flg == true){

    // ���ܥ���
    $form->addElement("button", "form_return_btn", "�ᡡ��", "onClick=\"location.href('1-2-403.php')\"");

}


/****************************/
// ɽ����html����
/****************************/
// html���ѿ����
$html = null;

// ����Կ�ʬ�ʺ���ѹԴޤ�˥롼��
for ($i=0, $j=1; $i<$max_row; $i++){

    // ���������ˤ���Ԥ�ɽ�������ʤ�
    if (!in_array($i, $ary_del_row_history)){

        // html����
        $html .= "<tr class=\"Result1\">\n";
        $html .= "<A NAME=\"$j\"></A>";
        $html .= "  <td align=\"right\">$j</td>\n";                                                 // ���ֹ�
        $html .= "  <td>\n";
        $html .=        $form->_elements[$form->_elementIndex["form_trade_$i"]]->toHtml();          // �����ʬ
        $html .= "  </td>\n";
        $html .= "  <td>\n";
        $html .=        $form->_elements[$form->_elementIndex["form_amount_$i"]]->toHtml();         // ���
        $html .= "  </td>\n";
        $html .= "  <td>\n";
        $html .=        $form->_elements[$form->_elementIndex["form_bank_$i"]]->toHtml();           // ��ԡ���Ź������
        $html .= "  </td>\n";
        $html .= "  <td>\n";
        $html .=        $form->_elements[$form->_elementIndex["form_limit_date_$i"]]->toHtml();     // �������
        $html .= "  </td>\n";
        $html .= "  <td>\n";
        $html .=        $form->_elements[$form->_elementIndex["form_bill_paper_no_$i"]]->toHtml();  // ��������ֹ�
        $html .= "  </td>\n";
        $html .= "  <td>\n";
        $html .=        $form->_elements[$form->_elementIndex["form_note_$i"]]->toHtml();           // ����
        $html .= "  </td>\n";
        // ��ǧ���̤Ǥʤ����
        if ($verify_flg != true && $verify_only_flg != true){
        $html .= "  <td class=\"Title_Add\" align=\"center\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_del_row_$i"]]->toHtml();        // ������
        $html .= "  </td>\n";
        }
        $html .= "</tr>\n";

        // ���ֹ楫����+1
        $j++;

    }

}


/****************************/
// ����̾������/���Ͻ���
/****************************/
// ������ID��NULL�Ǥʤ����
if ($client_id != null){

    // ������ƥ�ץ�
    $sql  = "SELECT \n";
    $sql .= "   t_claim.claim_div, \n";
    $sql .= "   t_client.pay_name, \n";
    $sql .= "   t_client.account_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "   LEFT JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_claim.client_id = $client_id \n";

    $sql_tpl = $sql;

    // �����踡����
    if ($client_search_flg == true){

        // �������ʬ���ο���̾����ޥ����������
        $sql .= "AND \n";
        $sql .= "   t_claim.claim_div = '1' \n";

    // �����ǧ���̻�
    }elseif ($verify_flg == true){

        // POST���줿������ο���̾������
        $sql .= "AND \n";
        $sql .= "   t_claim.claim_div = ".$_POST["form_claim_select"]." \n";

    // ���ٲ��̻�
    }elseif ($verify_only_flg == true){

        // ��ɼ�ο���̾�������ʥƥ�ץ�Ȥ�ʤ���
        $sql  = "SELECT \n";
        $sql .= "   claim_div, \n";
        $sql .= "   pay_name, \n";
        $sql .= "   account_name \n";
        $sql .= "FROM \n";
        $sql .= "   t_payin_h \n";
        $sql .= "WHERE \n";
        $sql .= "   pay_id = $payin_id \n";

    // �����踡���ʳ��������ǧ���̰ʳ������ٲ��̻��ʳ�
    }else{

        // POST��������ʹ��ɲá�����ʤɡ�
        if ($_POST != null){

            // �����褬���򤵤�Ƥ�����
            if ($_POST["form_claim_select"] != null){
                // ����������ǳ���������ο���̾����ޥ����������
                $sql .= "AND \n";
                $sql .= "   t_claim.claim_div = ".$_POST["form_claim_select"]." \n";
            // �����褬NULL�ξ��
            }else{
                // NULL�����������
                $sql  = "SELECT NULL AS claim_div, NULL AS pay_name, NULL AS account_name;";
            }

        // �ѹ����̤�POST��̵�������ѹ�������̡�
        }else{

            // ��ɼ���������ʬ�ο���̾����ޥ����������
            $sql .= "AND \n";
            $sql .= "   t_claim.claim_div = (SELECT claim_div FROM t_payin_h WHERE pay_id = $payin_id) \n";

        }

    }

    // ���ɽ����POST��ɽ����
    $res = Db_Query($db_con, $sql.";");
    $num = pg_num_rows($res);
    if ($num > 0){
        $ary_pay_account    = Get_Data($res, 1);
        $pay_account_name   = $ary_pay_account[0][1]."<br>".$ary_pay_account[0][2]."<br>";
    }

    // �������ڤ��ؤ�js��
    $res = Db_Query($db_con, $sql_tpl.";");
    $num = pg_num_rows($res);
    if ($num > 0){
        $ary_pay_account_def = Get_Data($res, 4);
        // ����̾���ڤ��ؤ�js����
        $js_sheet  = "function Pay_Account_Name(){\n";
        $js_sheet .= "  // ����̾���ꥹ�Ⱥ���\n";
        $js_sheet .= "  data = new Array(".count($ary_pay_account_def).");\n";
        foreach ($ary_pay_account_def as $key => $value){
        $js_sheet .= "  data['".$value[0]."'] = '".$value[1]."<br>".$value[2]."<br>'\n";
        }
        $js_sheet .= "  // �����ץ�����󤬶��Ǥʤ����\n";
        $js_sheet .= "  if (document.dateForm.form_claim_select.value != ''){\n";
        $js_sheet .= "      // �ץ��������������Ƥˤ�ꡢ�ꥹ�Ȥ��ͤ�����\n";
        $js_sheet .= "      var num = document.dateForm.form_claim_select.value;\n";
        $js_sheet .= "      document.getElementById('pay_account_name').innerHTML = data[num];\n";
        $js_sheet .= "  }else{\n";
        $js_sheet .= "      document.getElementById('pay_account_name').innerHTML = '<br><br>';\n";
        $js_sheet .= "  }\n";
        $js_sheet .= "}\n";
    }

}else{

    // �����
    $pay_account_name       = "<br><br>";

}


/****************************/
// �����ֹ桦����۽��Ͻ����ʿ������ѹ�����
/****************************/
// ������ID��NULL�Ǥʤ����
if ($client_id != null && $verify_only_flg == null){

    $sql  = "SELECT \n";
    $sql .= "   t_claim.claim_div, \n";
    $sql .= "   t_client.pay_name, \n";
    $sql .= "   t_client.account_name, \n";
    $sql .= "   t_client.client_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "   LEFT JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_claim.client_id = $client_id \n";

    $sql_tpl = $sql;

    // �����踡����
    if ($client_search_flg == true){

        // �������ʬ���ο���̾����ޥ����������
        $sql .= "AND \n";
        $sql .= "   t_claim.claim_div = '1' \n";

    // �����ǧ���̻�
    }elseif ($verify_flg == true){

        // POST���줿������ο���̾������
        $sql .= "AND \n";
        $sql .= "   t_claim.claim_div = ".$_POST["form_claim_select"]." \n";

    // ���ٲ��̻�
    }elseif ($verify_only_flg == true){

        // ��ɼ�ο���̾�������ʥƥ�ץ�Ȥ�ʤ���
        $sql  = "SELECT \n";
        $sql .= "   t_payin_h.claim_div, \n";
        $sql .= "   t_payin_h.pay_name, \n";
        $sql .= "   t_payin_h.account_name, \n";
        $sql .= "   t_bill.claim_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_payin_h \n";
        $sql .= "   INNER JOIN t_bill ON t_payin_h.bill_id = t_payin_h.bill_id \n";
        $sql .= "WHERE \n";
        $sql .= "   pay_id = $payin_id \n";

    // �����踡���ʳ��������ǧ���̰ʳ������ٲ��̻��ʳ�
    }else{

        // POST��������ʹ��ɲá�����ʤɡ�
        if ($_POST != null){

            // �����褬���򤵤�Ƥ�����
            if ($_POST["form_claim_select"] != null){
                // ����������ǳ���������ο���̾����ޥ����������
                $sql .= "AND \n";
                $sql .= "   t_claim.claim_div = ".$_POST["form_claim_select"]." \n";
            // �����褬NULL�ξ��
            }else{
                // NULL�����������
                $sql  = "SELECT NULL AS claim_div, NULL AS pay_name, NULL AS account_name;";
            }

        // �ѹ����̤�POST��̵�������ѹ�������̡�
        }else{

            // ��ɼ���������ʬ�ο���̾����ޥ����������
            $sql .= "AND \n";
            $sql .= "   t_claim.claim_div = (SELECT claim_div FROM t_payin_h WHERE pay_id = $payin_id) \n";

        }

    }

    // ���ɽ����POST��ɽ����
    $res = Db_Query($db_con, $sql.";");
    $num = pg_num_rows($res);
    // ������ǡ�����������
    if ($num > 0){
        // ������ǡ�������
        $ary_pay_account    = Get_Data($res, 1);
        // ����ǡ�������
        $ary_bill_data      = Get_Bill_Data($db_con, $client_id, $ary_pay_account[0][3]);
        $bill_no_amount     = $ary_bill_data[1]."<br>".$ary_bill_data[2]."<br>";
        $bill_amount        = $ary_bill_data[2];
        $set_bill_no["form_bill_no"] = $ary_bill_data[1];
        $form->setConstants($set_bill_no);
    }

    // �������ڤ��ؤ�js��
    $res = Db_Query($db_con, $sql_tpl.";");
    $num = pg_num_rows($res);
    // ����ǡ����������� 
    if ($num > 0){
        // ������ǡ�������
        $ary_pay_account_def    = Get_Data($res, 1);
        // ��������������ǡ����ǥ롼��
        foreach ($ary_pay_account_def as $key_claim => $value_claim){
            // ����ǡ�������
            $ary_bill_data_def[$key_claim] = Get_Bill_Data($db_con, $client_id, $value_claim[3]);
        }
        // �����ǡ�����������
        if (count($ary_bill_data_def) > 0){
            // ����̾���ڤ��ؤ�js����
            $js_sheet .= "function Bill_No_Amount(){\n";
            $js_sheet .= "  form_bill_no = document.dateForm.elements[\"form_bill_no\"]\n";
            $js_sheet .= "  // ����̾���ꥹ�Ⱥ���\n";
            $js_sheet .= "  data1 = new Array(".count($ary_bill_data_def).");\n";
            $js_sheet .= "  data2 = new Array(".count($ary_bill_data_def).");\n";
            $js_sheet .= "  data3 = new Array(".count($ary_bill_data_def).");\n";
            foreach ($ary_bill_data_def as $key_bill => $value_bill){
            $js_sheet .= "  data1['".($key_bill+1)."'] = '".$value_bill[1]."<br>".$value_bill[2]."<br>'\n";
            $js_sheet .= "  data2['".($key_bill+1)."'] = '".$value_bill[1]."'\n";
            }
            $js_sheet .= "  // �����ץ�����󤬶��Ǥʤ����\n";
            $js_sheet .= "  if (document.dateForm.form_claim_select.value != ''){\n";
            $js_sheet .= "      // �ץ��������������Ƥˤ�ꡢ�ꥹ�Ȥ��ͤ�����\n";
            $js_sheet .= "      var num = document.dateForm.form_claim_select.value;\n";
            $js_sheet .= "      document.getElementById('bill_no_amount').innerHTML = data1[num];\n";
            $js_sheet .= "      form_bill_no.value = data2[num];\n";
            $js_sheet .= "      document.getElementById('bill_amount').innerHTML = data3[num];\n";
            $js_sheet .= "  }else{\n";
            $js_sheet .= "      document.getElementById('bill_no_amount').innerHTML = '<br><br>';\n";
            $js_sheet .= "      form_bill_no.value = ''\n";
            $js_sheet .= "      document.getElementById('bill_amount').innerHTML = '';\n";
            $js_sheet .= "  }\n";
            $js_sheet .= "}\n";
        }else{
            $js_sheet .= "function Bill_No_Amount(){\n";
            $js_sheet .= "  form_bill_no = document.dateForm.elements[\"form_bill_no\"]\n";
            $js_sheet .= "  form_bill_no.value = ''\n";
            $js_sheet .= "}\n";
        }
    }else{
        $js_sheet .= "function Bill_No_Amount(){\n";
        $js_sheet .= "  form_bill_no = document.dateForm.elements[\"form_bill_no\"]\n";
        $js_sheet .= "  form_bill_no.value = ''\n";
        $js_sheet .= "}\n";
    }

}else{

    $js_sheet .= "function Bill_No_Amount(){\n";
    $js_sheet .= "  form_bill_no = document.dateForm.elements[\"form_bill_no\"]\n";
    $js_sheet .= "  form_bill_no.value = ''\n";
    $js_sheet .= "}\n";
    $bill_no_amount = "<br><br>";
    $bill_amount = "";

}


/****************************/
// �����ֹ桦����۽��Ͻ��������ٻ���
/****************************/
if ($verify_only_flg == true && $form_bill_id != null){

    // ���������ID������ۤ����
    $sql  = "SELECT \n";
    $sql .= "   t_bill.bill_no, \n";
    $sql .= "   t_bill_d.payment_this \n";
    $sql .= "FROM \n";
    $sql .= "   t_bill \n";
    $sql .= "   INNER JOIN t_bill_d ON t_bill.bill_id = t_bill_d.bill_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill.bill_id = $form_bill_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    if (pg_num_rows($res)){
        $ary_bill_data = Get_Data($res, 1);
    }
    $bill_no_amount = $ary_bill_data[0][0]."<br>".number_format($ary_bill_data[0][1])."<br>";
    $bill_amount    = number_format($ary_bill_data[0][1])."<br>";

}


/****************************/
// ������ζ�ԡ���Ź�����¼���
/****************************/
// �����踡���ե饰��true�ξ��
if ($_POST["client_search_flg"] == true || $_POST == null){

    // ���������褬¸�ߤ�����
    if ($client_id != null){

        // ����������ζ�Ծ�������
        // ���ٲ��̤Ǥʤ����
        if ($verily_only_flg != true){
            $sql  = "SELECT \n";
            $sql .= "   t_bank.bank_cd, \n";
            $sql .= "   t_bank.bank_name, \n";
            $sql .= "   t_b_bank.b_bank_cd, \n";
            $sql .= "   t_b_bank.b_bank_name, \n";
            $sql .= "   t_account.deposit_kind, \n";
            $sql .= "   t_account.account_no \n";
            $sql .= "FROM \n";
            $sql .= "   t_client \n";
            $sql .= "   LEFT JOIN t_account ON t_client.account_id = t_account.account_id \n";
            $sql .= "   LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
            $sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id \n";
            $sql .= "WHERE \n";
            $sql .= "   t_client.client_id = $client_id \n";
            $sql .= ";"; 
        // ���ٲ��̤ξ��
        }else{  
            $sql  = "SELECT \n";
            $sql .= "   t_payin_h.c_bank_cd, \n";
            $sql .= "   t_payin_h.c_bank_name, \n";
            $sql .= "   t_payin_h.c_b_bank_cd, \n";
            $sql .= "   t_payin_h.c_b_bank_name, \n";
            $sql .= "   t_payin_h.c_deposit_kind, \n";
            $sql .= "   t_payin_h.c_account_no \n";
            $sql .= "FROM \n";
            $sql .= "   t_payin_h \n";
            $sql .= "   LEFT JOIN t_account ON t_payin_h.account_id = t_account.account_id \n";
            $sql .= "   LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
            $sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id \n";
            $sql .= "WHERE \n";
            $sql .= "   t_client.client_id = $client_id \n";
            $sql .= ";"; 
        }  
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);

        // �����ǡ�����������
        if ($num > 0){
            $get_c_bank_data = true;
            // �ޥ����������
            $c_bank_cd      = htmlspecialchars(pg_fetch_result($res, 0, 0));
            $c_bank_name    = htmlspecialchars(pg_fetch_result($res, 0, 1));
            $c_b_bank_cd    = htmlspecialchars(pg_fetch_result($res, 0, 2));
            $c_b_bank_name  = htmlspecialchars(pg_fetch_result($res, 0, 3));
            $c_deposit_kind = htmlspecialchars(pg_fetch_result($res, 0, 4));
            $c_account_no   = htmlspecialchars(pg_fetch_result($res, 0, 5));
        }else{
            $c_bank_cd      = null;
            $c_bank_name    = null;
            $c_b_bank_cd    = null;
            $c_b_bank_name  = null;
            $c_deposit_kind = null;
            $c_account_no   = null;
        }

        // ����������Ծ����hidden�˥��å�
        $hdn_c_bank_data["hdn_c_bank_cd"]       = $c_bank_cd;
        $hdn_c_bank_data["hdn_c_bank_name"]     = $c_bank_name;
        $hdn_c_bank_data["hdn_c_b_bank_cd"]     = $c_b_bank_cd;
        $hdn_c_bank_data["hdn_c_b_bank_name"]   = $c_b_bank_name;
        $hdn_c_bank_data["hdn_c_deposit_kind"]  = $c_deposit_kind;
        $hdn_c_bank_data["hdn_c_account_no"]    = $c_account_no;
        $form->setConstants($hdn_c_bank_data);

        // ��Ծ����static�˥��å�
        $stc_c_bank_data["form_c_bank"]         = ($c_bank_cd != null)      ? $c_bank_cd." : ".$c_bank_name     : "";
        $stc_c_bank_data["form_c_b_bank"]       = ($c_b_bank_cd != null)    ? "&nbsp;".$c_b_bank_cd." : ".$c_b_bank_name : "";
        if ($c_deposit_kind != null){
            $stc_c_bank_data["form_c_account"]  = ($c_deposit_kind == "1") ? "����" : "����";
            $stc_c_bank_data["form_c_account"] .= " : ".$c_account_no;
        }else{
            $stc_c_bank_data["form_c_account"]  = "";
        }
        $form->setConstants($stc_c_bank_data);

    // ���������褬¸�ߤ��ʤ����
    }else{

        // ���򥻥å�
        $hdn_c_bank_data["hdn_c_bank_cd"]       = "";
        $hdn_c_bank_data["hdn_c_bank_name"]     = "";
        $hdn_c_bank_data["hdn_c_b_bank_cd"]     = "";
        $hdn_c_bank_data["hdn_c_b_bank_name"]   = "";
        $hdn_c_bank_data["hdn_c_deposit_kind"]  = "";
        $hdn_c_bank_data["hdn_c_account_no"]    = "";
        $form->setConstants($hdn_c_bank_data);

        // ���򥻥å�
        $stc_c_bank_data["form_c_bank"]         = "";
        $stc_c_bank_data["form_c_b_bank"]       = "";
        $stc_c_bank_data["form_c_account"]      = "";
        $form->setConstants($stc_c_bank_data);

    }

}

/****************************/
// ��ԡ���Ź�����¾���ν��ϡ����å�
/****************************/
// �����褬���롢��Ծ�������ե饰��true�Ǥʤ���hidden�ζ�Ծ��󤬤�����
if ($client_id != null && $get_c_bank_data != true && $_POST["hdn_c_bank_cd"] != null){

    // POST���줿hidden�ζ�Ծ���򥻥å�
    if ($_POST["hdn_c_bank_cd"] != null){
        $stc_c_bank_data["form_c_bank"]     = $_POST["hdn_c_bank_cd"]." : ".stripslashes($_POST["hdn_c_bank_name"]);
    }else{
        $stc_c_bank_data["form_c_bank"]     = "";
    }
    if ($_POST["hdn_c_b_bank_cd"] != null){
        $stc_c_bank_data["form_c_b_bank"]   = "&nbsp;".$_POST["hdn_c_b_bank_cd"]." : ".stripslashes($_POST["hdn_c_b_bank_name"]);
    }else{
        $stc_c_bank_data["form_c_b_bank"]   = "";
    }
    if ($_POST["hdn_c_deposit_kind"] != null){
        $stc_c_bank_data["form_c_account"]  = ($_POST["hdn_c_deposit_kind"] == "1") ? "����" : "����";
        $stc_c_bank_data["form_c_account"] .= " : ".$_POST["hdn_c_account_no"];
    }else{
        $stc_c_bank_data["form_c_account"]  = "";
    }
    $form->setConstants($stc_c_bank_data);

}


/****************************/
// ������ξ��ּ���
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


/****************************/
// �ƻҴط��Τ��������褫Ĵ�٤�
/****************************/
// ��ǧ���̡��ե꡼�����̰ʳ�
#2009-10-16 hashimoto-y
/*
if ($verify_flg != true && $verify_only_flg != true){
    // ������ID��������
    if ($client_id != null){
        $filiation_flg = Client_Filiation_Chk($db_con, $client_id);
    }
}
*/


/****************************/
// �ؿ�
/****************************/
function Get_Bill_Data($db_con, $client_id, $claim_id){

    // ���������谸�Ǻǿ��������ǡ��������
    $sql  = "SELECT \n";
    $sql .= "   t_bill.bill_id, \n";
    $sql .= "   t_bill.bill_no, \n";
    $sql .= "   t_bill_d.payment_this \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           MAX(bill_id) AS bill_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_bill \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_bill.claim_id = $claim_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_bill.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_bill_max \n";
    $sql .= "   INNER JOIN t_bill_d ON t_bill_max.bill_id = t_bill_d.bill_id \n";
    $sql .= "   INNER JOIN t_bill   ON t_bill_d.bill_id = t_bill.bill_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill_d.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_bill_d.bill_data_div = '0' \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $ary_bill_data = Get_Data($res, 1);
        $ary_bill_data = $ary_bill_data[0];
        $ary_bill_data[2] = ($ary_bill_data[2] != null) ? number_format($ary_bill_data[2]) : null;
    }

    return $ary_bill_data;

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
$page_menu = Create_Menu_f('sale','4');

/****************************/
// ���̥إå�������
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title);


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
    "verify_flg"        => "$verify_flg",
    "verify_only_flg"   => "$verify_only_flg",
    "duplicate_err_msg" => "$duplicate_err_msg",
    "html"              => "$html",
    "just_daily_update_flg" => "$just_daily_update_flg",
    "pay_account_name"  => "$pay_account_name",
    "bill_no_amount"    => "$bill_no_amount",
    "bill_amount"       => "$bill_amount",
    "client_state_print"=> "$client_state_print",
    "filiation_flg"     => "$filiation_flg",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>