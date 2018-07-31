<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-04-09                  fukuda      ���̥ե�����Υ��顼�����å��ϴؿ��ҤȤĤǼ¹ԤǤ���褦����
 *
 *
 *
 *
 */

$page_title = "�����ɼ����";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

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
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_charge_fc"    => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_claim_day"    => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
);

// �����������
Restore_Filter2($form, "contract", "form_display", $ary_form_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];


/****************************/
// ���������
/****************************/
$limit          = null;
$offset         = "0";
$total_count    = "0";
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// �����ȥ��
$ary_sort_item = array(
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_slip"           => "��ɼ�ֹ�",
    "sl_arrival_day"    => "ͽ������",
    "sl_round_staff"    => "���ô����<br>�ʥᥤ�󣱡�",
    "sl_act_client_cd"  => "����襳����",
    "sl_act_client_name"=> "�����̾",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_round_staff");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button","form_clear","���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");


/****************************/
// ɽ���ܥ��󲡲���
/****************************/
if ($_POST["form_display"] != null){

    /****************************/
    // ���顼�����å�
    /****************************/
    // �����̥ե���������å�
    Search_Err_Chk($form);

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
if (($_POST["form_display"] != null && $err_flg != true) || ($_POST != null && $_POST["form_display"] == null)){

    // ����POST�ǡ�����0���
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);
    $_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

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
    $charge_fc_cd1      = $_POST["form_charge_fc"]["cd1"];
    $charge_fc_cd2      = $_POST["form_charge_fc"]["cd2"];
    $charge_fc_name     = $_POST["form_charge_fc"]["name"];
    $charge_fc_select   = $_POST["form_charge_fc"]["select"]["1"];

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
        $sql .= "   t_round_staff.staff_id IN \n";
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
    $sql .= ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �����襳���ɣ�
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
    $sql .= ($round_staff_cd != null) ? "AND t_round_staff.charge_cd = '$round_staff_cd' \n" : null;
    // ���ô���ԥ��쥯��
    $sql .= ($round_staff_select != null) ? "AND t_round_staff.staff_id = $round_staff_select \n" : null;
    // ����
    $sql .= ($part != null) ? "AND t_round_staff.part_id = $part \n" : null;
    // �����襳���ɣ�   
    $sql .= ($claim_cd1 != null) ? "AND t_client_claim.client_cd1 LIKE '$claim_cd1%' \n" : null;
    // �����襳���ɣ�
    $sql .= ($claim_cd2 != null) ? "AND t_client_claim.client_cd2 LIKE '$claim_cd2%' \n" : null;
    // ������̾
    if ($client_name != null){
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
        $sql .= "   t_round_staff.charge_cd IN (";
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

    // �ѿ��ͤ�ľ��
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // �����襳����
        case "sl_client_cd":
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // ������̾
        case "sl_client_name":
            $sql .= "   t_aorder_h.client_cname, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // ��ɼ�ֹ�
        case "sl_slip":
            $sql .= "   t_aorder_h.ord_no \n";
            break;
        // ͽ������
        case "sl_arrival_day":
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // ���ô���ԡʥᥤ�󣱡�
        case "sl_round_staff":
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // ����襳����
        case "sl_act_client_cd":
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
            break;
        // �����̾
        case "sl_act_client_name":
            $sql .= "   t_act_client.client_cname, \n";
            $sql .= "   t_act_client.client_cd1, \n";
            $sql .= "   t_act_client.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_round_staff.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2 \n";
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
    $sql .= "   t_aorder_h.aord_id, \n";                                        // ����ID
    $sql .= "   t_aorder_h.ord_no, \n";                                         // �����ֹ�
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 \n";
    $sql .= "   AS client_cd, \n";                                              // �����襳����
    $sql .= "   t_aorder_h.client_cname, \n";                                   // ������ά��
    $sql .= "   t_aorder_h.ord_time, \n";                                       // ��������ͽ��������
    $sql .= "   t_round_staff.charge_cd, \n";                                   // ô���ԥ�����
    $sql .= "   t_round_staff.staff_name, \n";                                  // ô����̾
    $sql .= "   t_act_client.client_cd1 || '-' || t_act_client.client_cd2 \n";
    $sql .= "   AS act_cd, \n";                                                 // ����襳����
    $sql .= "   t_act_client.client_cname AS act_name, \n";                     // �����FCά��
    $sql .= "   t_trade.trade_name, \n";
    $sql .= "   t_aorder_h.net_amount, \n";                                     // ����ۡ���ȴ��
    $sql .= "   t_aorder_h.tax_amount, \n";                                     // �����ǳ�
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount \n";
    $sql .= "   AS price_amount, \n";                                           // ����ۡ��ǹ���
    $sql .= "   t_aorder_h.reason_cor \n";                                      // ������ͳ
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   INNER JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_act_client   ON t_aorder_h.act_id = t_act_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_aorder_staff.staff_id, \n";
    $sql .= "           CAST(LPAD(t_staff.charge_cd, 4, '0') AS TEXT) AS charge_cd, \n";
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
    $sql .= "   AS t_round_staff \n";
    $sql .= "   ON t_aorder_h.aord_id = t_round_staff.aord_id \n";
    // ��ɼ�ֹ����ֺ�
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    // �����ɼ
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.del_flg = 't' \n";
    // �����о�
    // ľ�ĤϷ����ʬ�˴ط��ʤ����Ƽ���
    // FC�ϼ��ҽ����ɼ�ȡ����ID�����ҤΥ���饤�������ɼ�����
    $sql .= "AND \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    }else{
    $sql .= "   ( \n";
    $sql .= "       t_aorder_h.shop_id = $shop_id \n";
    $sql .= "       OR \n";
    $sql .= "       (t_aorder_h.contract_div = '2' AND t_aorder_h.act_id = $shop_id) \n";
    $sql .= "   ) \n";
    }
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
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset \n" : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_aord_data  = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ɽ���ѥǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    if ($ary_aord_data != null){
    foreach ($ary_aord_data as $key => $value){

        // �����Ѳ�������
        $ary_aord_data[$key]["return"] = (bcmod($key, 30) == 0 && $key != "0") ? " style=\"page-break-before: always;\"" : null;

        // ��ɼ�ֹ��󥯺���
        $ary_aord_data[$key]["slip_no_link"]  = "<a href=\"./2-2-106.php?aord_id[0]=".$value["aord_id"]."&back_display=reserve\">";
        $ary_aord_data[$key]["slip_no_link"] .= $value["ord_no"];
        $ary_aord_data[$key]["slip_no_link"] .= "</a>";

        // ��ô���ԥ����ɡ�ô����̾�פ����
        if ($value["charge_cd"] != null){
            $ary_aord_data[$key]["staff"] = str_pad($value["charge_cd"], 4, "0", STR_PAD_LEFT)."��".htmlspecialchars($value["staff_name"]);
        }

        // �ݡ��������ȴ�������ǳۤ򻻽�
        // ������
        if ($value["trade_name"] == "�����"){
            // ����������ȴ�˻���
            $kake_notax     += $value["net_amount"];
            // �ݾ����ǻ���
            $kake_tax       += $value["tax_amount"];
        // ��������
        }elseif ($value["trade_name"] == "�������"){
            // ����������ȴ�˻���
            $genkin_notax   += $value["net_amount"];
            // ��������ǻ���
            $genkin_tax     += $value["tax_amount"];
        }

        // ����襳���ɤ��ϥ��ե�����ξ���NULL�ˤ���
        $ary_aord_data[$key]["act_cd"] = ($value["act_cd"] != "-") ? $value["act_cd"] : "";

    }
    }

    // �����
    $kake_ontax     = $kake_notax + $kake_tax;
    // ������
    $genkin_ontax   = $genkin_notax + $genkin_tax;
    // ��ȴ���
    $notax_amount   = $kake_notax + $genkin_notax;
    // �����ǹ��
    $tax_amount     = $kake_tax + $genkin_tax;
    // �ǹ����
    $ontax_amount   = $kake_ontax + $genkin_ontax;

}


/****************************/
// HTML�Ѵؿ�
/****************************/
function Number_Format_Color($num){
    return ($num < 0) ? "<span style=\"color: #ff0000;\">".number_format($num)."</span>" : number_format($num);
}


/****************************/
// HTML�����ʸ�������
/****************************/
// ���̸����ơ��֥�
$html_s .= Search_Table($form);
// �⥸�塼����̸����ơ��֥�
# ̵��
// �ܥ���
$html_s .= "\n";
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_display"]]->toHtml()."��\n";;
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear"]]->toHtml()."\n";
$html_s .= "</td></tr></table>\n";
$html_s .= "\n";


/****************************/
// HTML�����ʰ�������
/****************************/
if ($post_flg == true){

    // �ڡ���ʬ��
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

    // �����ơ��֥�
    $html_1  = "\n";
//    $html_1 .= "<table class=\"List_Table\" width=\"100%\" border=\"1\">\n";
    $html_1 .= "<table class=\"List_Table\" border=\"1\">\n";
    $html_1 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_1 .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_client_name")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_arrival_day")."</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_round_staff")."</td>\n";
    if ($_SESSION["group_kind"] == "2"){
        $html_1 .= "        <td class=\"Title_Act\">".Make_Sort_Link($form, "sl_act_client_cd")."<br><br style=\"font-size: 4px;\">".Make_Sort_Link($form, "sl_act_client_name")."</td>\n";
    }
    $html_1 .= "        <td class=\"Title_Pink\">�����ʬ</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">�����</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">��ɼ���</td>\n";
    $html_1 .= "        <td class=\"Title_Pink\">������ͳ</td>\n";
    $html_1 .= "    </tr>\n";
    if ($ary_aord_data != null){
    foreach ($ary_aord_data as $key => $value){
        if (bcmod($key, 2) == 0){
        $html_1 .= "    <tr class=\"Result1\"".$value["return"].">\n";
        }else{
        $html_1 .= "    <tr class=\"Result2\"".$value["return"].">\n";
        }
        $html_1 .= "        <td align=\"right\">".((($page_count - 1) * $limit) + $key + 1)."</td>\n";
        $html_1 .= "        <td>".$value["client_cd"]."<br>".htmlspecialchars($value["client_cname"])."<br></td>\n";
        $html_1 .= "        <td align=\"center\">".$value["slip_no_link"]."</td>\n";
        $html_1 .= "        <td align=\"center\">".$value["ord_time"]."</td>\n";
        $html_1 .= "        <td>".$value["staff"]."</td>\n";
        if ($_SESSION["group_kind"] == "2"){
            $html_1 .= "        <td>".$value["act_cd"]."<br>".htmlspecialchars($value["act_name"])."<br></td>\n";
        }
        $html_1 .= "        <td align=\"center\">".$value["trade_name"]."</td>";
        $html_1 .= "        <td align=\"right\">".Number_Format_Color($value["net_amount"])."</td>\n";
        $html_1 .= "        <td align=\"right\">".Number_Format_Color($value["tax_amount"])."</td>\n";
        $html_1 .= "        <td align=\"right\">".Number_format_Color($value["price_amount"])."</td>\n";
        $html_1 .= "        <td>".htmlspecialchars($value["reason_cor"])."</td>\n";
        $html_1 .= "    </tr>\n";
    }
    }
    $html_1 .= "</table>\n";
    $html_1 .= "\n";

    // ��ץơ��֥�
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
    $html_2 .= "        <td>".Number_format_Color($kake_notax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_2 .= "        <td>".Number_format_Color($kake_tax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td>".Number_format_Color($kake_ontax)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td>".Number_format_Color($genkin_notax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_2 .= "        <td>".Number_format_Color($genkin_tax)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_2 .= "        <td>".Number_format_Color($genkin_ontax)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr class=\"Result1\">\n";
    $html_2 .= "        <td class=\"Title_Pink\">��ȴ���</td>\n";
    $html_2 .= "        <td>".Number_format_Color($notax_amount)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">�����ǹ��</td>\n";
    $html_2 .= "        <td>".Number_format_Color($tax_amount)."</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">�ǹ����</td>\n";
    $html_2 .= "        <td>".Number_format_Color($ontax_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";
    $html_2 .= "\n";

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
//���̥إå�������
/****************************/
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
    "html_page"     =>  $html_page,
    "html_page2"    =>  $html_page2,
    "html_s"        =>  $html_s,
    "html_1"        =>  $html_1,
    "html_2"        =>  $html_2,
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
