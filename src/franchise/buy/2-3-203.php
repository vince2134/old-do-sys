<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2010/02/03                  aoyama-n    ������פξ����ǳ۽����Զ�罤��
 *  
 */

/********************
 * ��������ɽ
 ********************/

// �Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);


/************************************************/
// �����ѿ����ϲս�
/************************************************/
// SESSION
$shop_id = $_SESSION["client_id"];


/************************************************/
// ���顼�����å�
/************************************************/
// ������ô����
if ($_POST["form_c_staff"]["cd"] != null && !ereg("^[0-9]+$", $_POST["form_c_staff"]["cd"])){
    $message0 = "<li>����ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���<br>";
}

// ��������
// ���ͥ����å�
if (
    ($_POST["form_buy_day"]["sy"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["sy"])) ||
    ($_POST["form_buy_day"]["sm"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["sm"])) ||
    ($_POST["form_buy_day"]["sd"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["sd"])) ||
    ($_POST["form_buy_day"]["ey"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["ey"])) ||
    ($_POST["form_buy_day"]["em"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["em"])) ||
    ($_POST["form_buy_day"]["ed"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["ed"]))
){
    $message1 = "<li>������ �������ǤϤ���ޤ���<br>";
    $buy_day_err_flg = true;
}
// �ʳ��ϡ������������å�
if (
    $buy_day_err_flg != true &&
    ($_POST["form_buy_day"]["sy"] != null || $_POST["form_buy_day"]["sm"] != null || $_POST["form_buy_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_buy_day"]["sm"], (int)$_POST["form_buy_day"]["sd"], (int)$_POST["form_buy_day"]["sy"])){
        $message1 = "<li>������ �������ǤϤ���ޤ���<br>";
        $buy_day_err_flg = true;
    }
}
// �ʽ�λ�������������å�
if (
    $buy_day_err_flg != true &&
    ($_POST["form_buy_day"]["ey"] != null || $_POST["form_buy_day"]["em"] != null || $_POST["form_buy_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_buy_day"]["em"], (int)$_POST["form_buy_day"]["ed"], (int)$_POST["form_buy_day"]["ey"])){
        $message1 = "<li>������ �������ǤϤ���ޤ���<br>";
        $buy_day_err_flg = true;
    }
}

// ������ô���ԡ�ʣ�������
// ����޶��ڤ��Ⱦ�ѿ��������å�
if($_POST["form_multi_staff"] != null){
    $ary_multi_staff = explode(",", $_POST["form_multi_staff"]);
    foreach ($ary_multi_staff as $key => $value){
        if (!ereg("^[0-9]+$", trim($value))){
            $message2 = "<li>����ô���ԡ�ʣ������� �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���<br>";
        }
    }
}

// ��ȯ����
// ���ͥ����å�
if (
    ($_POST["form_ord_day"]["sy"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["sy"])) ||
    ($_POST["form_ord_day"]["sm"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["sm"])) ||
    ($_POST["form_ord_day"]["sd"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["sd"])) ||
    ($_POST["form_ord_day"]["ey"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["ey"])) ||
    ($_POST["form_ord_day"]["em"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["em"])) ||
    ($_POST["form_ord_day"]["ed"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["ed"]))
){
    $message3 = "<li>ȯ���� �������ǤϤ���ޤ���<br>";
    $ord_day_err_flg = true;
}
// �ʳ��ϡ������������å�
if (
    $ord_day_err_flg != true &&
    ($_POST["form_ord_day"]["sy"] != null || $_POST["form_ord_day"]["sm"] != null || $_POST["form_ord_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_ord_day"]["sm"], (int)$_POST["form_ord_day"]["sd"], (int)$_POST["form_ord_day"]["sy"])){
        $message3 = "<li>ȯ���� �������ǤϤ���ޤ���<br>";
        $ord_day_err_flg = true;
    }
}
// �ʽ�λ�������������å�
if (
    $ord_day_err_flg != true &&
    ($_POST["form_ord_day"]["ey"] != null || $_POST["form_ord_day"]["em"] != null || $_POST["form_ord_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_ord_day"]["em"], (int)$_POST["form_ord_day"]["ed"], (int)$_POST["form_ord_day"]["ey"])){
        $message3 = "<li>ȯ���� �������ǤϤ���ޤ���<br>";
        $ord_day_err_flg = true;
    }
}

// ��������ۡ��ǹ���
// ���ͥ����å�
if (
    ($_POST["form_buy_amount"]["s"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_buy_amount"]["s"])) ||
    ($_POST["form_buy_amount"]["e"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_buy_amount"]["e"]))
){
    $message4 = "<li>������ۡ��ǹ��� �Ͽ��ͤΤߤǤ���<br>";
}



/************************************************/
// ���顼���ϥ��顼��å���������Ϥ��ƽ�λ
/************************************************/
if ($message0 != null || $message1 != null || $message2 != null || $message3 != null || $message4 != null){
    print "<font color=\"red\"><b>";
    print $message0.$message1.$message2.$message3.$message4;
    print "</b></font>";
    exit;
}


/************************************************/
// POST�ǡ������ѿ��˥��å�
/************************************************/
// ����POST�ǡ�����0���
$_POST["form_buy_day"] = Str_Pad_Date($_POST["form_buy_day"]);
$_POST["form_ord_day"] = Str_Pad_Date($_POST["form_ord_day"]);

// �ե�������ͤ��ѿ��˥��å�
$display_num    = $_POST["form_display_num"];
$output_type    = $_POST["form_output_type"];
$client_branch  = $_POST["form_client_branch"];
$attach_branch  = $_POST["form_attach_branch"];
$client_cd1     = $_POST["form_client"]["cd1"];
$client_cd2     = $_POST["form_client"]["cd2"];
$client_name    = $_POST["form_client"]["name"];
$c_staff_cd     = $_POST["form_c_staff"]["cd"];
$c_staff_select = $_POST["form_c_staff"]["select"];
$part           = $_POST["form_part"];
$buy_day_sy     = $_POST["form_buy_day"]["sy"];
$buy_day_sm     = $_POST["form_buy_day"]["sm"];
$buy_day_sd     = $_POST["form_buy_day"]["sd"];
$buy_day_ey     = $_POST["form_buy_day"]["ey"];
$buy_day_em     = $_POST["form_buy_day"]["em"];
$buy_day_ed     = $_POST["form_buy_day"]["ed"];
$trade          = $_POST["form_trade"];
$multi_staff    = $_POST["form_multi_staff"];
$ware           = $_POST["form_ware"];
$slip_no_s      = $_POST["form_slip_no"]["s"];
$slip_no_e      = $_POST["form_slip_no"]["e"];
$renew          = $_POST["form_renew"];
$ord_no_s       = $_POST["form_ord_no"]["s"];
$ord_no_e       = $_POST["form_ord_no"]["e"];
$ord_day_sy     = $_POST["form_ord_day"]["sy"];
$ord_day_sm     = $_POST["form_ord_day"]["sm"];
$ord_day_sd     = $_POST["form_ord_day"]["sd"];
$ord_day_ey     = $_POST["form_ord_day"]["ey"];
$ord_day_em     = $_POST["form_ord_day"]["em"];
$ord_day_ed     = $_POST["form_ord_day"]["ed"];
$buy_amount_s   = $_POST["form_buy_amount"]["s"];
$buy_amount_e   = $_POST["form_buy_amount"]["e"];


/************************************************/
// Ģɼ����
/************************************************/

//*********************************//
// Ģɼ�ι������ϲս�
//*********************************//
// ;��
$left_margin    = 40;
$top_margin     = 40;

// �إå����Υե���ȥ�����
$font_size      = 9;
// �ڡ���������
$page_size      = 1110;

// A3
$pdf            = new MBFPDF("L", "pt", "A3");

// �ڡ�������ɽ����
$page_max       = 50;


//*********************************//
// �إå��������ϲս�
//*********************************//
// �����ȥ�
$title = "��������ɽ";
$page_count = 1; 

if ($renew == "2"){
    $renew_flg = false;
}else
if ($renew == "3"){
    $renew_flg = true;
}

// �إå���ɽ������������
if ($_POST["form_buy_day"]["sy"] == null && $_POST["form_buy_day"]["sm"] == null && $_POST["form_buy_day"]["sd"] == null){
    $sql  = "SELECT \n";
    $sql .= "   MIN(buy_day) \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "WHERE \n";
    $sql .= "   client_id = $shop_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);    
    $buy_day_s  = pg_fetch_result($res, 0, 0);
    $buy_day_s  = explode("-",$buy_day_s);
    $buy_day_sy = $buy_day_s[0];
    $buy_day_sm = $buy_day_s[1];
    $buy_day_sd = $buy_day_s[2];
}
if ($_POST["form_buy_day"]["ey"] == null && $_POST["form_buy_day"]["em"] == null && $_POST["form_buy_day"]["ed"] == null){
    $sql  = "SELECT \n";
    $sql .= "   MAX(buy_day) \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "WHERE \n";
    $sql .= "   client_id = $shop_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $buy_day_e  = pg_fetch_result($res, 0, 0);
    $buy_day_e  = explode("-",$buy_day_e);
    $buy_day_ey = $buy_day_e[0];
    $buy_day_em = $buy_day_e[1];
    $buy_day_ed = $buy_day_e[2];
}
$time = "��������".$buy_day_sy."ǯ".$buy_day_sm."��".$buy_day_sd."����".$buy_day_ey."ǯ".$buy_day_em."��".$buy_day_ed."��";

// ����̾������align
$list[0]        = array("30",  "No.",      "C");
$list[1]        = array("130", "������",   "C");
$list[2]        = array("40",  "��ɼ�ֹ�", "C");
$list[3]        = array("55",  "�����ʬ", "C");
$list[4]        = array("50",  "������",   "C");
$list[5]        = array("245", "����̾",   "C");
$list[6]        = array("70",  "������",   "C");
$list[7]        = array("70",  "����ñ��", "C");
$list[8]        = array("70",  "�������", "C");
$list[9]        = array("100", "�����Ҹ�", "C");
$list[10]       = array("40",  "ȯ���ֹ�", "C");
$list[11]       = array("210", "����",     "C");


//*********************************//
// �ǡ����������ϲս�
//*********************************//
// ������ס����סʾ�����/�ǹ��ס�
$list_sub[0]    = array("30",  "",             "R");
$list_sub[1]    = array("200", "������ס�",   "L");
$list_sub[2]    = array("200", "���ס�",     "L");
$list_sub[3]    = array("70",  "",             "R");
$list_sub[4]    = array("70",  "���������ǡ�", "L");
$list_sub[5]    = array("70",  "",             "R");
$list_sub[6]    = array("70",  "�����ǹ��ס�", "L");
$list_sub[7]    = array("70",  "",             "R");
$list_sub[8]    = array("530", "",             "C");

// ��ɼ�סʾ�����/�ǹ��ס�
$list_sub2[0]   = array("30",  "",             "R");
$list_sub2[1]   = array("130", "",             "C");
$list_sub2[2]   = array("70",  "��ɼ�ס�",     "L");
$list_sub2[3]   = array("70",  "",             "R");
$list_sub2[4]   = array("70",  "���������ǡ�", "L");
$list_sub2[5]   = array("70",  "",             "R");
$list_sub2[6]   = array("70",  "�����ǹ��ס�", "L");
$list_sub2[7]   = array("70",  "",             "R");
$list_sub2[8]   = array("530", "",             "C");

$list_width[0]  = "30";
$list_width[1]  = "130";
$list_width[2]  = "40";
$list_width[3]  = "55";
$list_width[4]  = "50";
$list_width[5]  = "245";
$list_width[6]  = "70";
$list_width[7]  = "70";
$list_width[8]  = "70";
$list_width[9]  = "100";
$list_width[10] = "40";
$list_width[11] = "210";

// align(�ǡ���)
$data_align[0]  = "R";
$data_align[1]  = "L";
$data_align[2]  = "L";
$data_align[3]  = "C";
$data_align[4]  = "C";
$data_align[5]  = "L";
$data_align[6]  = "R";
$data_align[7]  = "R";
$data_align[8]  = "R";
$data_align[9]  = "R";
$data_align[10] = "L";
$data_align[11] = "L";


//***********************
// ���ϥǡ����������
//***********************
$sql = null;
// �ܵ�ô����Ź
if ($client_branch != null){
    $sql .= "AND \n";
    $sql .= "   t_buy_h.client_id IN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_client \n";
    $sql .= "       WHERE \n";
    $sql .= "           charge_branch_id = $client_branch \n";
    $sql .= "   ) \n";
}
// ��°�ܻ�Ź
if ($attach_branch != null){
    $sql .= "AND \n";
    $sql .= "   t_buy_h.c_staff_id IN \n";
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
$sql .= ($client_cd1 != null) ? "AND t_buy_h.client_cd1 LIKE '$client_cd1%' \n" : null;
// �����襳����2
$sql .= ($client_cd2 != null) ? "AND t_buy_h.client_cd2 LIKE '$client_cd2%' \n" : null;
// ������̾
if ($client_name != null){
    $sql .= "AND \n";
    $sql .= "   ( \n";
    $sql .= "       t_buy_h.client_name  LIKE '%$client_name%' \n";
    $sql .= "       OR \n";
    $sql .= "       t_buy_h.client_name2 LIKE '%$client_name%' \n";
    $sql .= "       OR \n";
    $sql .= "       t_buy_h.client_cname LIKE '%$client_name%' \n";
    $sql .= "   ) \n";
}
// ����ô���ԥ�����
$sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
// ����ô���ԥ��쥯��
$sql .= ($c_staff_select != null) ? "AND t_staff.staff_id = $c_staff_select \n" : null;
// ����
$sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
// �������ʳ��ϡ�
$buy_day_s = $buy_day_sy."-".$buy_day_sm."-".$buy_day_sd;
$sql .= ($buy_day_s != "--") ? "AND '$buy_day_s' <= t_buy_h.buy_day \n" : null;
// �������ʽ�λ��
$buy_day_e = $buy_day_ey."-".$buy_day_em."-".$buy_day_ed;
$sql .= ($buy_day_e != "--") ? "AND t_buy_h.buy_day <= '$buy_day_e' \n" : null;
// �����ʬ
$sql .= ($trade != null) ? "AND t_buy_h.trade_id = $trade \n" : null;
// ����ô���ԡ�ʣ�������
if ($multi_staff != null){
    $ary_multi_staff = explode(",", $multi_staff);
    $sql .= "AND \n";
    $sql .= "   t_staff.charge_cd IN (";
    foreach ($ary_multi_staff as $key => $value){
        $sql .= "'".trim($value)."'";
        $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
    }
}
// �Ҹ�
$sql .= ($ware != null) ? "AND t_buy_h.ware_id = $ware \n" : null;
// ��ɼ�ֹ�ʳ��ϡ�
$sql .= ($slip_no_s != null) ? "AND t_buy_h.buy_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
// ��ɼ�ֹ�ʽ�λ��
$sql .= ($slip_no_e != null) ? "AND t_buy_h.buy_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
// ��������
if ($renew == "2"){
    $sql .= "AND t_buy_h.renew_flg = 'f' \n";
}elseif ($renew == "3"){
    $sql .= "AND t_buy_h.renew_flg = 't' \n";
}
// ȯ���ֹ�ʳ��ϡ�
$sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
// ȯ���ֹ�ʽ�λ��
$sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
// ȯ�����ʳ��ϡ�
$ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
$sql .= ($ord_day_s != "--") ? "AND '$ord_day_s 00:00:00' <= t_order_h.ord_time \n" : null;
// ȯ�����ʽ�λ��
$ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
$sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
// ������ۡ��ǹ��ˡʳ��ϡ�
if ($buy_amount_s != null){
    $sql .= "AND \n";
    $sql .= "   $buy_amount_s <= \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
    $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) \n";
    $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
    $sql .= "   END \n";
}
// ������ۡ��ǹ��ˡʽ�λ��
if ($buy_amount_e != null){
    $sql .= "AND \n";
    $sql .= "   $buy_amount_e >= \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
    $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) \n";
    $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
    $sql .= "   END \n";
}
$where_sql = $sql;


//***********************
// ���ϥǡ�������SQL���ϲս�
//***********************
$sql  = "SELECT \n";
$sql .= "   t_buy_h.client_name, \n";
$sql .= "   t_buy_h.buy_no, \n";
$sql .= "   CASE t_buy_h.trade_id \n";
$sql .= "       WHEN '21' THEN '�ݻ���' \n";
$sql .= "       WHEN '22' THEN '�ݻ���(-)' \n";
$sql .= "       WHEN '23' THEN '������' \n";
$sql .= "       WHEN '24' THEN '���Ͱ�' \n";
$sql .= "       WHEN '25' THEN '�������' \n";
$sql .= "       WHEN '71' THEN '�������' \n";
$sql .= "       WHEN '72' THEN '�������(-)' \n";
$sql .= "       WHEN '73' THEN '��������' \n";
$sql .= "       WHEN '74' THEN '�����Ͱ�' \n";
$sql .= "   END, \n";
$sql .= "   t_buy_h.buy_day, \n";
$sql .= "   t_buy_d.goods_name, \n";
$sql .= "   t_buy_d.num, \n";
$sql .= "   CASE t_buy_d.tax_div \n";
$sql .= "       WHEN '1' THEN '����' \n";
$sql .= "       WHEN '2' THEN '����' \n";
$sql .= "       WHEN '3' THEN '�����' \n";
$sql .= "   END, \n";
$sql .= "   t_buy_d.buy_price, \n";
$sql .= "   t_buy_d.buy_amount, \n";
$sql .= "   t_buy_h.ware_name, \n";
$sql .= "   t_order_h.ord_no, \n";
$sql .= "   t_buy_h.note, \n";
$sql .= "   t_buy_h.client_id, \n";
$sql .= "   t_buy_h.tax_amount \n";
$sql .= "FROM \n";
$sql .= "   t_buy_h \n";
$sql .= "   LEFT JOIN t_order_h ON t_buy_h.ord_id = t_order_h.ord_id \n";
$sql .= "   LEFT JOIN \n"; 
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           buy_id, \n";
$sql .= "           goods_name, \n";
$sql .= "           SUM(num) AS num, \n";
$sql .= "           tax_div, \n";
$sql .= "           buy_price, \n";
$sql .= "           SUM(buy_amount) AS buy_amount \n";
$sql .= "       FROM \n";
$sql .= "           t_buy_d \n";
$sql .= "       GROUP BY \n";
$sql .= "           buy_id, \n";
$sql .= "           goods_name, \n";
$sql .= "           tax_div, \n";
$sql .= "           buy_price \n";
$sql .= "   ) \n";
$sql .= "   AS t_buy_d \n";
$sql .= "   ON t_buy_h.buy_id = t_buy_d.buy_id \n";
$sql .= "   LEFT JOIN t_attach  ON  t_buy_h.c_staff_id = t_attach.staff_id \n";
$sql .= "                       AND t_attach.shop_id = $shop_id \n";
$sql .= "   LEFT JOIN t_staff   ON  t_buy_h.c_staff_id = t_staff.staff_id \n";
$sql .= "WHERE \n";
$sql .= "   t_buy_h.shop_id = $shop_id \n";
$sql .= $where_sql;
$sql .= "ORDER BY \n";
$sql .= "   client_id, \n";
$sql .= "   buy_no DESC \n";
$sql .= ";\n";
$res  = Db_Query($db_con, $sql);
$data_num  = pg_num_rows($res);
$data_list = Get_Data($res, 2);


//***********************
//���Ͻ���
//***********************
$pdf->AddMBFont(GOTHIC,"SJIS");
$pdf->SetFont(GOTHIC, "", 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("�������Yǯm��d����H:i");
//�إå���ɽ��
Header_disp($pdf, $left_margin, $top_margin, $title, "", $date, "", $time, $page_count, $list, $font_size, $page_size);

$count = 0;                 //�Կ�
$page_next = $page_max;     //���Υڡ���ɽ����
$page_back = 0;             //���Υڡ���ɽ����
$data_sub = array();        //�������
$data_sub2 = array();       //��ɼ��
$data_total = array();      //����
$person = "";               //������ν�ʣ��
$slip = "";                 //��ɼ�ֹ�ν�ʣ��
$money_tax = 0;             //������פξ����ǹ��
$money = 0;                 //������פλ�����۹��
$money_tax2 = 0;            //��ɼ�פξ����ǹ��
$money2 = 0;                //��ɼ�פλ�����۹��

for($c=0;$c<$data_num;$c++){
    $count++;

    if (!($data_list[$c][2] == '�ݻ���' || $data_list[$c][2] == '�������')){
        $data_list[$c][7] = $data_list[$c][7]*(-1);
        $data_list[$c][8] = $data_list[$c][8]*(-1);
        $data_list[$c][13] = $data_list[$c][13]*(-1);
    }
    //***********************
    //���ڡ�������
    //***********************
    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 8);

    //***********************
    //��ɼ�׽���
    //***********************
    //�ͤ��Ѥ�ä���硢��ɼ��ɽ��
    if($slip != $data_list[$c][1]){
        //����ܤϡ��ͤ򥻥åȤ������
        if($count != 1){
            $pdf->SetFillColor(220,220,220);
            //�ͤξ�άȽ��ե饰
            $space_flg2 = true;
            for($x=0;$x<count($list_sub2)-1;$x++){
                //��ɼ�׹��ֹ�
                if($x==0){
                    $pdf->SetFont(GOTHIC, '', 8);
                    $pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
                    $pdf->SetFont(GOTHIC, 'B', 8);
                //���ڡ�������ʬ����ɽ��
                }else if($x==1){
                    //���ڡ���������ΰ���ܤ�����ɼ�פξ�硢������̾ɽ��
                    if($page_back == $count){
                        $pdf->SetFont(GOTHIC, '', 8);
                        $pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 8);
                        //�������ɽ�����������ϡ��ǡ����λ�������ά
                        $slip_flg = true;
                    }else if($page_next == $count){
                        $pdf->SetFont(GOTHIC, '', 8);
                        $pdf->Cell($list_sub2[$x][0], 14,'', 'LBR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 8);
                    }else{
                        $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
                    }
                //��ɼ��̾
                }else if($x==2){
                    $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TLB', '0',$list_sub2[$x][2],'1');
                //��ɼ����
                }else if($x==3){
                    $money2 = $data_sub2[9];
                    $data_sub2[9] = number_format($data_sub2[9]);
                    $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[9], 'TB', '0',$list_sub2[$x][2],'1');
                //������̾or�ǹ���̾
                }else if($x==4 || $x==6){
                    $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
                //��������
                }else if($x==5){
                    $money_tax2 = $tax_sub2[14];
                    #2010-02-03 aoyama-n
                    $tax_sub[14] = bcadd($tax_sub[14],$tax_sub2[14]);

                    $tax_sub2[14] = number_format($tax_sub2[14]);
                    $pdf->Cell($list_sub2[$x][0], 14, $tax_sub2[14], 'TB', '0',$list_sub2[$x][2],'1');
                //�ǹ�����
                }else if($x==7){
                    $money_sum = bcadd($money_tax2,$money2);
                    $money_sum = number_format($money_sum);
                    $pdf->Cell($list_sub2[$x][0], 14, $money_sum, 'TB', '0',$list_sub2[$x][2],'1');
                }
            }
            //���ڡ�������ʬ����ɽ��
            $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TBR', '2',$list_sub2[$x][2],'1');

            $tax_sub2 = array();
            $data_sub2 = array();
            $money_tax2 = 0;
            $money2 = 0;
            $money_sum = 0;
            $count++;
        }
        $slip = $data_list[$c][1];
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);

    //***********************
    //���ڡ�������
    //***********************
    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 8);

    //***********************
    //������׽���
    //***********************
    //�ͤ��Ѥ�ä���硢�������ɽ��
    if($person != $data_list[$c][12]){
        //����ܤϡ��ͤ򥻥åȤ������
        if($count != 1){
            $pdf->SetFillColor(180,180,180);
            //�ͤξ�άȽ��ե饰
            $space_flg = true;
            $slip_flg = false;
            for($x=0;$x<count($list_sub)-1;$x++){
                //������׹��ֹ�
                if($x==0){
                    $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
                //�������̾
                }else if($x==1){
                    $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBL', '0',$list_sub[$x][2],'1');
                //���������
                }else if($x==3){
                    //������פ����ͤ�­���Ƥ���
                    $data_total[2] = bcadd($data_total[2],$data_sub[9]);
                    $money = $data_sub[9];
                    $data_sub[9] = number_format($data_sub[9]);
                    $pdf->Cell($list_sub[$x][0], 14, $data_sub[9], 'TB', '0',$list_sub[$x][2],'1');
                //������̾or�ǹ���̾
                }else if($x==4 || $x==6){
                    $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
                //��������
                }else if($x==5){
                    //�������ͤ����ͤ�­���Ƥ���
                    $tax_total[4] = bcadd($tax_total[4],$tax_sub[14]);
                    $money_tax = $tax_sub[14];
                    $tax_sub[14] = number_format($tax_sub[14]);
                    $pdf->Cell($list_sub[$x][0], 14, $tax_sub[14], 'TB', '0',$list_sub[$x][2],'1');
                //�ǹ�����
                }else if($x==7){
                    $money_sum = bcadd($money_tax,$money);
                    $money_sum = number_format($money_sum);
                    $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
                }
            }
            //���ڡ�������ʬ����ɽ��
            $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBR', '2',$list_sub[$x][2],'1');
        
            $tax_sub = array();
            $data_sub = array();
            $money_tax = 0;
            $money = 0;
            $money_sum = 0;
            $count++;
        }
        $person = $data_list[$c][12];
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, '', 8);

    //***********************
    //���ڡ�������
    //***********************
    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, '', 8);

    //***********************
    //�ǡ���ɽ������
    //***********************
    //���ֹ�
    $pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
    //�ǽ�Ϲ��ֹ��ɽ������١��ݥ��󥿤ϰ줫��Ϥ��
    for($x=1;$x<count($data_list[$c])+1;$x++){
        //ɽ����
        $contents = "";
        //ɽ��line
        $line = "";

        //������̾�ξ�άȽ��
        //��ɼ�פ˻������ɽ�������Ƥ��ʤ������ġ�����ܤ����פθ�ξ��ϡ���ά���ʤ���
        if($x==1 && $slip_flg == false && ($count == 1 || $space_flg == true)){
            //������Ƚ��
            //�ڡ����κ���ɽ������
            $contents = $data_list[$c][$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LR';
            }
            //��ɼ�פ�ɽ�������������̾������
            $customer = $data_list[$c][$x-1];
            //������̾���ά����
            $space_flg = false;
            $slip_flg = false;
        //��ɼ�פ˻������ɽ�����ޤ��ϡ����˻������ɽ����������
        }else if($x==1){
            //�ڡ����κ���ɽ������
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
            $customer = $data_list[$c][$x-1];
        //����ܤ���ɼ�פθ�ʳ����ͤξ�ά
        }else if($x==2 && ($count == 1 || $space_flg2 == true)){
            //������Ƚ��
            //�ڡ����κ���ɽ������
            $contents = $data_list[$c][$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LRT';
            }
            //��ά����
            $space_flg2 = false;
        //������ɼ�ֹ��ɽ�����Ƥ��롣
        }else if($x==2){
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
        //������۷׻�
        }else if($x==9){
            //�ͤ���ɼ�פ�­���Ƥ���
            $data_sub2[$x] = bcadd($data_sub2[$x],$data_list[$c][$x-1]);
            //�ͤ������פ�­���Ƥ���
            $data_sub[$x] = bcadd($data_sub[$x],$data_list[$c][$x-1]);
            $data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
            $contents = $data_list[$c][$x-1];
            $line = '1';
        //�����Ƿ׻�
        }else if($x==14){
            //�ͤ���ɼ�פ�­���Ƥ���
            $tax_sub2[$x] = $data_list[$c][$x-1];
            //�ͤ������פ�­���Ƥ���
            #2010-02-03 aoyama-n
            #$tax_sub[$x] = bcadd($tax_sub[$x],$data_list[$c][$x-1]);
            $data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
        }else{
/*
            //ȯ���ֹ桦�������Ͽ��ͤ��ѹ����ʤ�
            if(is_numeric($data_list[$c][$x-1]) && $x!=11 && $x != 6){
                $data_list[$c][$x-1] = ($data_list[$c][$x-1]);
            }
*/
            //��ۡ����̤ʤ���ͷ������ѹ�
            if(is_numeric($data_list[$c][$x-1]) && ($x==6 || $x == 8)){
                if($x == 8){
                    //ñ��
                    $data_list[$c][$x-1] = number_format($data_list[$c][$x-1],2);
                }else{
                    //����
                    $data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
                }
            }

            $contents = $data_list[$c][$x-1];
            $line = '1';
        }
        //������ID�Ⱦ����ǰʳ�ɽ��
        if($x != 7 && $x != 13 && $x != 14){
            //���ͤ�ɽ��������ϡ�����
            if($x==12){
                $pdf->Cell($list[$x-1][0], 14, $contents, $line, '2', $data_align[$x]);
            }else{
                if($x<7){
                    $pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
                }else{
                    $pdf->Cell($list[$x-1][0], 14, $contents, $line, '0', $data_align[$x]);
                }
            }
        }
    }
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(220,220,220);
$count++;

//***********************
//���ڡ�������
//***********************
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //�إå���ɽ��
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
    $page_back = $page_next+1;
    //���κ���ɽ����
    $page_next = $page_max * $page_count;
    $space_flg = true;
    $space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//�ǽ���ɼ�׽���
//***********************   
for($x=0;$x<count($list_sub2)-1;$x++){
    //��ɼ�׹��ֹ�
    if($x==0){
        $pdf->SetFont(GOTHIC, '', 8);
        $pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
        $pdf->SetFont(GOTHIC, 'B', 8);
    //���ڡ�������ʬ����ɽ��
    }else if($x==1){
        //���ڡ���������ΰ���ܤ�����ɼ�פξ�硢������̾ɽ��
        if($page_back == $count){
            $pdf->SetFont(GOTHIC, '', 8);
            $pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
            $pdf->SetFont(GOTHIC, 'B', 8);
            //�������ɽ�����������ϡ��ǡ����λ�������ά
            $slip_flg = true;
        }else if($page_next == $count){
            $pdf->SetFont(GOTHIC, '', 8);
            $pdf->Cell($list_sub2[$x][0], 14,'', 'LBR', '0','L','');
            $pdf->SetFont(GOTHIC, 'B', 8);
        }else{
            $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
            $slip_flg = false;
        }
    //��ɼ��̾
    }else if($x==2){
        $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TLB', '0',$list_sub2[$x][2],'1');
    //��ɼ����
    }else if($x==3){
        $money2 = $data_sub2[9];
        $data_sub2[9] = number_format($data_sub2[9]);
        $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[9], 'TB', '0',$list_sub2[$x][2],'1');
    //������̾or�ǹ���̾
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
    //��������
    }else if($x==5){
        $money_tax2 = $tax_sub2[14];
        #2010-02-03 aoyama-n
        $tax_sub[14] = bcadd($tax_sub[14],$tax_sub2[14]);

        $tax_sub2[14] = number_format($tax_sub2[14]);
        $pdf->Cell($list_sub2[$x][0], 14, $tax_sub2[14], 'TB', '0',$list_sub2[$x][2],'1');
    //�ǹ�����
    }else if($x==7){
        $money_sum = bcadd($money_tax2,$money2);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub2[$x][0], 14, $money_sum, 'TB', '0',$list_sub2[$x][2],'1');
    }
}
//���ڡ�������ʬ����ɽ��
$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TBR', '2',$list_sub2[$x][2],'1');

$tax_sub2 = array();
$data_sub2 = array();
$money_tax2 = 0;
$money2 = 0;
$money_sum = 0;

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//***********************
//���ڡ�������
//***********************   
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //�إå���ɽ��
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
    $page_back = $page_next+1;
    //���κ���ɽ����
    $page_next = $page_max * $page_count;
    $space_flg = true;
    $space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//�ǽ�������׽���
//***********************   
for($x=0;$x<count($list_sub)-1;$x++){
    //������׹��ֹ�
    if($x==0){
        $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
    //�������̾
    }else if($x==1){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBL', '0',$list_sub[$x][2],'1');
    //���������
    }else if($x==3){
        //������פ����ͤ�­���Ƥ���
        $data_total[2] = bcadd($data_total[2],$data_sub[9]);
        $money = $data_sub[9];
        $data_sub[9] = number_format($data_sub[9]);
        $pdf->Cell($list_sub[$x][0], 14, $data_sub[9], 'TB', '0',$list_sub[$x][2],'1');
    //������̾or�ǹ���̾
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
    //��������
    }else if($x==5){
        //�������ͤ����ͤ�­���Ƥ���
        $tax_total[4] = bcadd($tax_total[4],$tax_sub[14]);
        $money_tax = $tax_sub[14];
        $tax_sub[14] = number_format($tax_sub[14]);
        #2010-02-03 aoyama-n
        #$pdf->Cell($list_sub[$x][0], 14, $money_tax, 'TB', '0',$list_sub[$x][2],'1');
        $pdf->Cell($list_sub[$x][0], 14, $tax_sub[14], 'TB', '0',$list_sub[$x][2],'1');
    //�ǹ�����
    }else if($x==7){
        $money_sum = bcadd($money_tax,$money);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
    }
}
//���ڡ�������ʬ����ɽ��
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBR', '2',$list_sub[$x][2],'1');

$tax_sub = array();
$data_sub = array();
$money_tax = 0;
$money = 0;
$money_sum = 0;

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//***********************
//���ڡ�������
//***********************   
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //�إå���ɽ��
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
    $page_back = $page_next+1;
    //���κ���ɽ����
    $page_next = $page_max * $page_count;
    $space_flg = true;
    $space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//���׽���
//***********************   
for($x=0;$x<count($list_sub)-1;$x++){
    //��׹��ֹ�
    if($x==0){
        $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
    //����̾
    }else if($x==2){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'LTB', '0',$list_sub[$x][2],'1');
    //������
    }else if($x==3){
        $money = $data_total[2];
        $data_total[2] = number_format($data_total[2]);
        $pdf->Cell($list_sub[$x][0], 14, $data_total[2], 'TB', '0',$list_sub[$x][2],'1');
    //������̾or�ǹ���̾
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
    //��������
    }else if($x==5){
        $money_tax = $tax_total[4];
        $tax_total[4] = number_format($tax_total[4]);
        $pdf->Cell($list_sub[$x][0], 14, $tax_total[4], 'TB', '0',$list_sub[$x][2],'1');
    //�ǹ�����
    }else if($x==7){
        $money_sum = bcadd($money_tax,$money);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
    }
}
//���ڡ�������ʬ����ɽ��
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBR', '2',$list_sub[$x][2],'1');

//����
$pdf->Output();

?>
