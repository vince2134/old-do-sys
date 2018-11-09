<?php

/*
 * �ѹ�����
 *  (2006/11/06) 06-042 ��ɼ�ֹ�Ǹ����Ǥ���褦�˽���(suzuki-t)
 *  (2006/11/07) 06-044 �������Ǹ����Ǥ���褦�˽���(suzuki-t)
 *  (2006/11/07) 06-045 �ޥ��ʥ��ͤǤ⸡����ǽ�˽���(suzuki-t)
*/


/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/11��06-072��������watanabe-k������̾�����ͤ��ʥ�С��ե����ޥåȤ���Ƥ���Х��ν���
 * ��2006/11/11��06-073��������watanabe-k�����˥��������줹���Ƥ���Х��ν���
 * ��2006/11/11��06-073��������watanabe-k�����˥��������줹���Ƥ���Х��ν���
 * ��2006/12/09��ban_0120������suzuki��    ���������������
 * ��2006/12/09��ban_0121������suzuki��    �ǡ��������������
 *   2010/02/03                aoyama-n    ������פξ����ǳ۽����Զ�罤��
 *
 */


//�Ķ�����ե����� env setting file
require_once("ENV_local.php");
require(FPDF_DIR);

$conn = Db_Connect();

// ���¥����å� auth check
$auth = Auth_Check($conn);


/************************************************/
// �����ѿ����ϲս� input field external variable
/************************************************/
// SESSION 
$shop_id = $_SESSION["client_id"];


/************************************************/
// ���顼�����å� error check
/************************************************/
// ������ô���� purchase assigned staff
if ($_POST["form_c_staff"]["cd"] != null && !ereg("^[0-9]+$", $_POST["form_c_staff"]["cd"])){
    $message0 = "<li>����ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���<br>";
}

// �������� purhcase date
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
// �ʳ��ϡ������������å� check validity (start)
if (
    $buy_day_err_flg != true && 
    ($_POST["form_buy_day"]["sy"] != null || $_POST["form_buy_day"]["sm"] != null || $_POST["form_buy_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_buy_day"]["sm"], (int)$_POST["form_buy_day"]["sd"], (int)$_POST["form_buy_day"]["sy"])){
        $message1 = "<li>������ �������ǤϤ���ޤ���<br>";
        $buy_day_err_flg = true; 
    }
}
// �ʽ�λ�������������å� validty check (end)
if (
    $buy_day_err_flg != true && 
    ($_POST["form_buy_day"]["ey"] != null || $_POST["form_buy_day"]["em"] != null || $_POST["form_buy_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_buy_day"]["em"], (int)$_POST["form_buy_day"]["ed"], (int)$_POST["form_buy_day"]["ey"])){
        $message1 = "<li>������ �������ǤϤ���ޤ���<br>";
        $buy_day_err_flg = true; 
    }
}

// ������ô���ԡ�ʣ������� purchase assigned staff (select multiple)
// ����޶��ڤ��Ⱦ�ѿ��������å� check the half width number that are comma seprated
if($_POST["form_multi_staff"] != null){
    $ary_multi_staff = explode(",", $_POST["form_multi_staff"]);
    foreach ($ary_multi_staff as $key => $value){
        if (!ereg("^[0-9]+$", trim($value))){
            $message2 = "<li>����ô���ԡ�ʣ������� �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���<br>";
        }       
    }
}

// ��ȯ���� purchase order date
// ���ͥ����å� value check
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
// �ʳ��ϡ������������å� validity check (start)
if (
    $ord_day_err_flg != true &&
    ($_POST["form_ord_day"]["sy"] != null || $_POST["form_ord_day"]["sm"] != null || $_POST["form_ord_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_ord_day"]["sm"], (int)$_POST["form_ord_day"]["sd"], (int)$_POST["form_ord_day"]["sy"])){
        $message3 = "<li>ȯ���� �������ǤϤ���ޤ���<br>";
        $ord_day_err_flg = true;
    }
}
// �ʽ�λ�������������å� validity check (end)
if (
    $ord_day_err_flg != true &&
    ($_POST["form_ord_day"]["ey"] != null || $_POST["form_ord_day"]["em"] != null || $_POST["form_ord_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_ord_day"]["em"], (int)$_POST["form_ord_day"]["ed"], (int)$_POST["form_ord_day"]["ey"])){
        $message3 = "<li>ȯ���� �������ǤϤ���ޤ���<br>";
        $ord_day_err_flg = true;
    }
}

// ��������ۡ��ǹ���purchase amount (with tax)
// ���ͥ����å� check value
if (
    ($_POST["form_buy_amount"]["s"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_buy_amount"]["s"])) ||
    ($_POST["form_buy_amount"]["e"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_buy_amount"]["e"]))
){
    $message4 = "<li>������ۡ��ǹ��� �Ͽ��ͤΤߤǤ���<br>";
}



/************************************************/
// ���顼���ϥ��顼��å���������Ϥ��ƽ�λ��if its an error end with outputting the error message
/************************************************/
if ($message0 != null || $message1 != null || $message2 != null || $message3 != null || $message4 != null){
    print "<font color=\"red\"><b>";
    print $message0.$message1.$message2.$message3.$message4;
    print "</b></font>";
    exit;
}


/************************************************/
// POST�ǡ������ѿ��˥��å�set the POST data in variable
/************************************************/
// ����POST�ǡ�����0��� fill the date POST data with 0s
$_POST["form_buy_day"] = Str_Pad_Date($_POST["form_buy_day"]);
$_POST["form_ord_day"] = Str_Pad_Date($_POST["form_ord_day"]);

$display_num    = $_POST["form_display_num"];
$output_type    = $_POST["form_output_type"];
$client_cd1     = $_POST["form_client"]["cd1"];
$client_cd2     = $_POST["form_client"]["cd2"];
$client_name    = $_POST["form_client"]["name"];
$c_staff_cd     = $_POST["form_c_staff"]["cd"];
$c_staff_select = $_POST["form_c_staff"]["select"];
$ware           = $_POST["form_ware"];
$buy_day_sy     = $_POST["form_buy_day"]["sy"];
$buy_day_sm     = $_POST["form_buy_day"]["sm"];
$buy_day_sd     = $_POST["form_buy_day"]["sd"];
$buy_day_ey     = $_POST["form_buy_day"]["ey"];
$buy_day_em     = $_POST["form_buy_day"]["em"];
$buy_day_ed     = $_POST["form_buy_day"]["ed"];
$multi_staff    = $_POST["form_multi_staff"];
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
$trade          = $_POST["form_trade"];


//*********************************//
//Ģɼ�ι������ϲս� input field of the form layout
//*********************************//
//;�� margin
$left_margin = 40;
$top_margin = 40;

//�إå����Υե���ȥ����� font size of header
$font_size = 9;
//�ڡ��������� page size
$page_size = 1110;

//A3 A3
$pdf=new MBFPDF('L','pt','A3');

//�ڡ�������ɽ���� maximum number of pages to be displayed
$page_max = 50;

//*********************************//
//�إå��������ϲս� header items input field
//*********************************//
//�����ȥ� title
$title = "��������ɽ";
$page_count = 1; 

if($_POST["form_renew"] == "2"){
    $renew_flg = true;
}elseif($_POST["form_renew"] == "3"){
    $renew_flg = false;
}

//�إå���ɽ������������ create the time to be displayed in header
$time = "��������";

#2010-02-03 aoyama-n
#if($buy_sday["y"] != null){
#    $time .= $buy_sday["y"]."ǯ".$buy_sday["m"]."��".$buy_sday["d"]."��";
if($buy_day_sy != null){
    $time .= $buy_day_sy."ǯ".$buy_day_sm."��".$buy_day_sd."��";
}else{
    $sql  = "SELECT";
    $sql .= "   MIN(buy_day)";
    $sql .= " FROM";
    $sql .= "   t_buy_h";
    $sql .= " WHERE";
    $sql .= "   client_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);    
    $buy_day = pg_fetch_result($result,0,0);

    $buy_day = explode("-",$buy_day);

    $time .= $buy_day[0]."ǯ".$buy_day[1]."��".$buy_day[2]."��";
}

$time .= "��";

#2010-02-03 aoyama-n
#if($buy_eday["y"] != null){
#    $time .= $buy_eday["y"]."ǯ".$buy_eday["m"]."��".$buy_eday["d"]."��";
if($buy_day_ey != null){
    $time .= $buy_day_ey."ǯ".$buy_day_em."��".$buy_day_ed."��";
}else{
    $sql  = "SELECT";
    $sql .= "   MAX(buy_day)";
    $sql .= " FROM";
    $sql .= "   t_buy_h";
    $sql .= " WHERE";
    $sql .= "   client_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $buy_day = pg_fetch_result($result,0,0);

    $buy_day = explode("-",$buy_day);

    $time .= $buy_day[0]."ǯ".$buy_day[1]."��".$buy_day[2]."��";
}

//����̾������align item name, width, align
$list[0] = array("30","NO","C");
$list[1] = array("130","������","C");
$list[2] = array("40","��ɼ�ֹ�","C");
$list[3] = array("55","�����ʬ","C");
$list[4] = array("50","������","C");
$list[5] = array("245","����̾","C");
$list[6] = array("70","������","C");
$list[7] = array("70","����ñ��","C");
$list[8] = array("70","�������","C");
$list[9] = array("100","�����Ҹ�","C");
$list[10] = array("40","ȯ���ֹ�","C");
$list[11] = array("210","����","C");

//*********************************//
//�ǡ����������ϲս� data item input field
//*********************************//
//������ס����סʾ�����/�ǹ��ס�total number of purchase clients��total amount (with tax)
$list_sub[0] = array("30","","R");
$list_sub[1] = array("200","������ס�","L");
$list_sub[2] = array("200","���ס�","L");
$list_sub[3] = array("70","","R");
$list_sub[4] = array("70","���������ǡ�","L");
$list_sub[5] = array("70","","R");
$list_sub[6] = array("70","�����ǹ��ס�","L");
$list_sub[7] = array("70","","R");
$list_sub[8] = array("530","","C");

//��ɼ�סʾ�����/�ǹ��ס�total number of slips (with tax)
$list_sub2[0] = array("30","","R");
$list_sub2[1] = array("130","","C");
$list_sub2[2] = array("70","��ɼ�ס�","L");
$list_sub2[3] = array("70","","R");
$list_sub2[4] = array("70","���������ǡ�","L");
$list_sub2[5] = array("70","","R");
$list_sub2[6] = array("70","�����ǹ��ס�","L");
$list_sub2[7] = array("70","","R");
$list_sub2[8] = array("530","","C");

$list_width[0] = "30";
$list_width[1] = "130";
$list_width[2] = "40";
$list_width[3] = "55";
$list_width[4] = "50";
$list_width[5] = "245";
$list_width[6] = "70";
$list_width[7] = "70";
$list_width[8] = "70";
$list_width[9] = "100";
$list_width[10] = "40";
$list_width[11] = "210";

//align(�ǡ���) align (data)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "C";
$data_align[4] = "C";
$data_align[5] = "L";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "L";
$data_align[11] = "L";


/****************************/
// �����ǡ�������������  create condition to acquire list data
/****************************/

$sql = null;

// �����襳���ɣ� purchase client code 1
$sql .= ($client_cd1 != null) ? "AND t_buy_h.client_cd1 LIKE '$client_cd1%' \n" : null;
// �����襳���ɣ� purchase client code 2
$sql .= ($client_cd2 != null) ? "AND t_buy_h.client_cd2 LIKE '$client_cd2%' \n" : null;
// ������̾ purchase client name 
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
// ����ô���ԥ����� purchase assigned staff code
$sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
// ����ô���ԥ��쥯�� select purchase assigned staff
$sql .= ($c_staff_select != null) ? "AND t_buy_h.c_staff_id = $c_staff_select \n" : null; 
// �Ҹ� warehouse
$sql .= ($ware != null) ? "AND t_buy_h.ware_id = $ware \n" : null; 
// �������ʳ��ϡ�purchase date (start)
$buy_day_s = $buy_day_sy."-".$buy_day_sm."-".$buy_day_sd;
$sql .= ($buy_day_s != "--") ? "AND '$buy_day_s' <= t_buy_h.buy_day \n" : null; 
// �������ʽ�λ��purchase date (end)
$buy_day_e = $buy_day_ey."-".$buy_day_em."-".$buy_day_ed;
$sql .= ($buy_day_e != "--") ? "AND t_buy_h.buy_day <= '$buy_day_e' \n" : null;
// ����ô��ʣ������ select multiple purchase assigned staff 
if ($multi_staff != null){
    $ary_multi_staff = explode(",", $multi_staff);
    $sql .= "AND \n";
    $sql .= "   t_staff.charge_cd IN (";
    foreach ($ary_multi_staff as $key => $value){
        $sql .= "'".trim($value)."'";
        $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
    }
}
// ��ɼ�ֹ�ʳ��ϡ�slip number (start)
$sql .= ($slip_no_s != null) ? "AND t_buy_h.buy_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."'\n" : null;
// ��ɼ�ֹ�ʽ�λ��slip number (end)
$sql .= ($slip_no_e != null) ? "AND t_buy_h.buy_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."'\n" : null;
// �������� daily update
if ($renew == "2"){
    $sql .= "AND t_buy_h.renew_flg = 'f' \n";
}elseif ($renew == "3"){
    $sql .= "AND t_buy_h.renew_flg = 't' \n";
}
// ȯ���ֹ�ʳ��ϡ�purchase order number (start)
$sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."'\n" : null;
// ȯ���ֹ�ʽ�λ��purchase order number (end)
$sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."'\n" : null;
// ȯ�����ʳ��ϡ�purchase order date (start)
$ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
$sql .= ($ord_day_s != "--") ? "AND '$ord_day_s 00:00:00' <= t_order_h.ord_time \n" : null;
// ȯ�����ʽ�λ��purchae order date (end)
$ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
$sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
// ������ۡ��ǹ��ˡʳ��ϡ�purchase amount (with tax) (start)
if ($buy_amount_s != null){
    $sql .= "AND \n";
    $sql .= "   $buy_amount_s <= \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
    $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) *  1 \n";
    $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
    $sql .= "   END \n";
}
// ������ۡ��ǹ��ˡʽ�λ��purchase amount (with tax) (end)
if ($buy_amount_e != null){
    $sql .= "AND \n";
    $sql .= "   $buy_amount_e >= \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
    $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) *  1 \n";
    $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
    $sql .= "   END \n";
}
// �����ʬ trade classification
$sql .= ($trade != null) ? "AND t_buy_h.trade_id = '$trade' \n" : null;

// �ѿ��ͤ��ؤ� refill variable 
$where_sql = $sql;


//***********************
// ���ϥǡ�������SQL���ϲս� input field in SQL that acquires output data 
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
$sql .= "   t_buy_h LEFT JOIN t_order_h ON t_buy_h.ord_id = t_order_h.ord_id \n";
$sql .= "   LEFT JOIN \n"; 
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           buy_id, \n";
$sql .= "           goods_name, \n";
$sql .= "           SUM(num) AS num, \n";
$sql .= "           tax_div, \n";
$sql .= "           buy_price, \n";
$sql .= "           SUM(buy_amount) AS buy_amount \n";
$sql .= "       FROM\n ";
$sql .= "           t_buy_d \n";
$sql .= "       GROUP BY \n";
$sql .= "           buy_id, \n";
$sql .= "           goods_name, \n";
$sql .= "           tax_div, \n";
$sql .= "           buy_price, \n";
$sql .= "           line \n";
$sql .= "       ORDER BY \n";
$sql .= "           line \n";
$sql .= "   ) \n";
$sql .= "   AS t_buy_d \n";
$sql .= "   ON t_buy_h.buy_id = t_buy_d.buy_id \n";
$sql .= "   LEFT JOIN t_staff   ON t_buy_h.c_staff_id = t_staff.staff_id \n";
$sql .= "WHERE \n";
$sql .= "   t_buy_h.shop_id = $shop_id \n";
$sql .= $where_sql;
$sql .= "ORDER BY \n";
$sql .= "   buy_day DESC, \n";
$sql .= "   buy_no DESC \n";
$sql .= ";\n";


$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);
$data_list = Get_Data($result,2);

//***********************
//���Ͻ��� output process
//***********************
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("�������Yǯm��d����H:i");
//�إå���ɽ�� display header
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

$count = 0;                 //�Կ� row number
$page_next = $page_max;     //���Υڡ���ɽ���� number of next pages
$page_back = 0;             //���Υڡ���ɽ���� number of previous pages 
$data_sub = array();        //������� total of purchase client
$data_sub2 = array();       //��ɼ�� total of slip
$data_total = array();      //���� total number
$person = "";               //������ν�ʣ�� overlapped value of puchase client
$slip = "";                 //��ɼ�ֹ�ν�ʣ�� overlapped value of slip numbers
$money_tax = 0;             //������פξ����ǹ�� total vat of all purchase clients
$money = 0;                 //������פλ�����۹�� total purhcase amount of all puchase clients
$money_tax2 = 0;            //��ɼ�פξ����ǹ�� total amount of tax of all slips
$money2 = 0;                //��ɼ�פλ�����۹�� total puchase amount of all slips

for($c=0;$c<$data_num;$c++){
    $count++;

    if (!($data_list[$c][2] == '�ݻ���' || $data_list[$c][2] == '�������' || $data_list[$c][2] == '�������')){
        $data_list[$c][7] = $data_list[$c][7]*(-1);
        $data_list[$c][8] = $data_list[$c][8]*(-1);
        $data_list[$c][13] = $data_list[$c][13]*(-1);
    }
    //***********************
    //���ڡ������� new page process
    //***********************
    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ������� if the row number becomes the max number of items that can be displayed in a page, make it a new page
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ�� display header
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ���������� if the first row of the new page is the total of slip row, substitute the number of items displayed in the previous to display the purchase client name
        $page_back = $page_next+1;
        //���κ���ɽ���� the next max items to be displayed
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 8);

    //***********************
    //��ɼ�׽��� slip totalling process
    //***********************
    //�ͤ��Ѥ�ä���硢��ɼ��ɽ�� if the value changes, display the totalling of slip
    if($slip != $data_list[$c][1]){
        //����ܤϡ��ͤ򥻥åȤ������ just set the value for the first row
        if($count != 1){
            $pdf->SetFillColor(220,220,220);
            //�ͤξ�άȽ��ե饰 decision flag for omitting value
            $space_flg2 = true;
            for($x=0;$x<count($list_sub2)-1;$x++){
                //��ɼ�׹��ֹ� totalling slip row number
                if($x==0){
                    $pdf->SetFont(GOTHIC, '', 8);
                    $pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
                    $pdf->SetFont(GOTHIC, 'B', 8);
                //���ڡ�������ʬ����ɽ�� display cells according to how much space there is
                }else if($x==1){
                    //���ڡ���������ΰ���ܤ�����ɼ�פξ�硢������̾ɽ�� if the first page in the new page is the totalling slip, then display the purchase client name
                    if($page_back == $count){
                        $pdf->SetFont(GOTHIC, '', 8);
                        $pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 8);
                        //�������ɽ�����������ϡ��ǡ����λ�������ά ommit the purchase client of the data when the purchase client is displayed
                        $slip_flg = true;
					}else if($page_next == $count){
						$pdf->SetFont(GOTHIC, '', 8);
                        $pdf->Cell($list_sub2[$x][0], 14,'', 'LBR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 8);
                    }else{
                        $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
                    }
                //��ɼ��̾ name of the totalling slip
                }else if($x==2){
                    $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TLB', '0',$list_sub2[$x][2],'1');
                //��ɼ���� value of the totalling slip
                }else if($x==3){
                    $money2 = $data_sub2[9];
                    $data_sub2[9] = number_format($data_sub2[9]);
                    $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[9], 'TB', '0',$list_sub2[$x][2],'1');
                //������̾or�ǹ���̾ tax name or with tax total name
                }else if($x==4 || $x==6){
                    $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
                //�������� value of tax
                }else if($x==5){
                    $money_tax2 = $tax_sub2[14];
                    #2010-02-03 aoyama-n
                    $tax_sub[14] = bcadd($tax_sub[14],$tax_sub2[14]);

                    $tax_sub2[14] = number_format($tax_sub2[14]);
                    $pdf->Cell($list_sub2[$x][0], 14, $tax_sub2[14], 'TB', '0',$list_sub2[$x][2],'1');
                //�ǹ����� total of amount with tax
                }else if($x==7){
                    $money_sum = bcadd($money_tax2,$money2);
                    $money_sum = number_format($money_sum);
                    $pdf->Cell($list_sub2[$x][0], 14, $money_sum, 'TB', '0',$list_sub2[$x][2],'1');
                }
            }
            //���ڡ�������ʬ����ɽ�� display cell just as many spaces ther are
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
    //���ڡ������� nwe page process
    //***********************
    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ������� if the row number becomes the max number of items that can be displayed in a page, make it a new page
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ�� display header
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ���������� if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
        $page_back = $page_next+1;
        //���κ���ɽ���� the next max items to be displayed
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 8);

    //***********************
    //������׽��� purchase client (PC) totalling process
    //***********************
    //�ͤ��Ѥ�ä���硢�������ɽ�� if the value changes, display the total of purchase client 
    if($person != $data_list[$c][12]){
        //����ܤϡ��ͤ򥻥åȤ������ just set the value for the first row
        if($count != 1){
            $pdf->SetFillColor(180,180,180);
            //�ͤξ�άȽ��ե饰 decision flag for omitting value
            $space_flg = true;
            $slip_flg = false;
            for($x=0;$x<count($list_sub)-1;$x++){
                //������׹��ֹ� total purchase cleint row number
                if($x==0){
                    $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
                //�������̾ name of the total PC
                }else if($x==1){
                    $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBL', '0',$list_sub[$x][2],'1');
                //��������� value of total PC
                }else if($x==3){
                    //������פ����ͤ�­���Ƥ��� add the total PC in the total value
                    $data_total[2] = bcadd($data_total[2],$data_sub[9]);
                    $money = $data_sub[9];
                    $data_sub[9] = number_format($data_sub[9]);
                    $pdf->Cell($list_sub[$x][0], 14, $data_sub[9], 'TB', '0',$list_sub[$x][2],'1');
                //������̾or�ǹ���̾ tax name or with tax total name
                }else if($x==4 || $x==6){
                    $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
                //�������� value of tax
                }else if($x==5){
                    //�������ͤ����ͤ�­���Ƥ��� add the tax value to the total value
                    $tax_total[4] = bcadd($tax_total[4],$tax_sub[14]);
                    $money_tax = $tax_sub[14];
                    $tax_sub[14] = number_format($tax_sub[14]);
                    $pdf->Cell($list_sub[$x][0], 14, $money_tax, 'TB', '0',$list_sub[$x][2],'1');
                //�ǹ����� total of amount with tax
                }else if($x==7){
                    $money_sum = bcadd($money_tax,$money);
                    $money_sum = number_format($money_sum);
                    $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
                }
            }
            //���ڡ�������ʬ����ɽ�� display cell just as many spaces ther are
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
    //���ڡ������� nwe page process
    //***********************
    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ������� if the row number becomes the max number of items that can be displayed in a page, make it a new page
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ�� display header 
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ���������� if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
        $page_back = $page_next+1;
        //���κ���ɽ���� the next max items to be displayed
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, '', 8);

    //***********************
    //�ǡ���ɽ������ data display process
    //***********************
    //���ֹ� row number
    $pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
    //�ǽ�Ϲ��ֹ��ɽ������١��ݥ��󥿤ϰ줫��Ϥ�� start from the pointer because row number will be displayed first
    for($x=1;$x<count($data_list[$c])+1;$x++){
        //ɽ���� display value
        $contents = "";
        //ɽ��line display line
        $line = "";

        //������̾�ξ�άȽ�� purchase client name decide on ommision
        //��ɼ�פ˻������ɽ�������Ƥ��ʤ������ġ�����ܤ����פθ�ξ��ϡ���ά���ʤ���do not ommit when when the purchase client is not displayed and when it is after the first row or the sub total
        if($x==1 && $slip_flg == false && ($count == 1 || $space_flg == true)){
            //������Ƚ�� decide if cell will be combined
            //�ڡ����κ���ɽ������ if it is the max display number of the page
            $contents = $data_list[$c][$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LR';
            }
            //��ɼ�פ�ɽ�������������̾������substitute the purchase cleint name that will be displayed in the slip total
            $customer = $data_list[$c][$x-1];
            //������̾���ά���� ommit the purchase client name
            $space_flg = false;
            $slip_flg = false;
        //��ɼ�פ˻������ɽ�����ޤ��ϡ����˻������ɽ���������� was the purchase client displayed in the total of slip or was the purchase client displayed already
        }else if($x==1){
            //�ڡ����κ���ɽ������ is it the max number of items to be displayed in the page
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
            $customer = $data_list[$c][$x-1];
        //����ܤ���ɼ�פθ�ʳ����ͤξ�ά ommit the value if it is the first row or if it is after the total of slip
        }else if($x==2 && ($count == 1 || $space_flg2 == true)){
            //������Ƚ�� decide if cells will be combined
            //�ڡ����κ���ɽ������ is it the max numbers of item to be displayed
            $contents = $data_list[$c][$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LRT';
            }
            //��ά���� ommit
            $space_flg2 = false;
        //������ɼ�ֹ��ɽ�����Ƥ��롣 slip number is being dispayed already
        }else if($x==2){
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
        //������۷׻� compute the purchase amount
        }else if($x==9){
            //�ͤ���ɼ�פ�­���Ƥ��� add the value to the slip total
            $data_sub2[$x] = bcadd($data_sub2[$x],$data_list[$c][$x-1]);
            //�ͤ������פ�­���Ƥ��� add the value to the total of purchase client
            $data_sub[$x] = bcadd($data_sub[$x],$data_list[$c][$x-1]);
            $data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
            $contents = $data_list[$c][$x-1];
            $line = '1';
        //�����Ƿ׻� compute for tax
        }else if($x==14){
            //�ͤ���ɼ�פ�­���Ƥ��� add the value to total of slip
            $tax_sub2[$x] = $data_list[$c][$x-1];
            //�ͤ������פ�­���Ƥ��� add the value to total purchas client
            #2010-02-03 aoyama-n
            #$tax_sub[$x] = bcadd($tax_sub[$x],$data_list[$c][$x-1]);
            $data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
        }else{
            //��ۡ����̤ʤ���ͷ������ѹ� if it's amount or quantity then change it to the value format
            if(is_numeric($data_list[$c][$x-1]) && ($x==6 || $x == 8)){
				if($x == 8){
					//ñ�� price per product
					$data_list[$c][$x-1] = number_format($data_list[$c][$x-1],2);
				}else{
					//���� quantity
					$data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
				}
            }
            $contents = $data_list[$c][$x-1];
            $line = '1';
        }
        //������ID�Ⱦ����ǰʳ�ɽ�� display other than purchase client ID and tax
        if($x != 7 && $x != 13 && $x != 14){
            //���ͤ�ɽ��������ϡ����� new line if remarks were displayed
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
//���ڡ������� new page process
//***********************
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ������� if the row number becomes the max number of items that can be displayed in a page, make it a new page
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //�إå���ɽ�� display header
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ���������� if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
    $page_back = $page_next+1;
    //���κ���ɽ���� the next max items to be displayed
    $page_next = $page_max * $page_count;
    $space_flg = true;
    $space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//�ǽ���ɼ�׽��� final slip totalling process
//***********************   
for($x=0;$x<count($list_sub2)-1;$x++){
    //��ɼ�׹��ֹ� row number of the total of slip
    if($x==0){
        $pdf->SetFont(GOTHIC, '', 8);
        $pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
        $pdf->SetFont(GOTHIC, 'B', 8);
    //���ڡ�������ʬ����ɽ�� display cells according to how much space there is
    }else if($x==1){
        //���ڡ���������ΰ���ܤ�����ɼ�פξ�硢������̾ɽ�� if the first page in the new page is the total of slip, then display the purchase client name
        if($page_back == $count){
            $pdf->SetFont(GOTHIC, '', 8);
            $pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
            $pdf->SetFont(GOTHIC, 'B', 8);
            //�������ɽ�����������ϡ��ǡ����λ�������ά if the purchase client has been displayed, ommit the data of the purchase client
            $slip_flg = true;
		}else if($page_next == $count){
			$pdf->SetFont(GOTHIC, '', 8);
            $pdf->Cell($list_sub2[$x][0], 14,'', 'LBR', '0','L','');
            $pdf->SetFont(GOTHIC, 'B', 8);
        }else{
            $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
            $slip_flg = false;
        }
    //��ɼ��̾ total of slip name
    }else if($x==2){
        $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TLB', '0',$list_sub2[$x][2],'1');
    //��ɼ���� value of the total of slip
    }else if($x==3){
        $money2 = $data_sub2[9];
        $data_sub2[9] = number_format($data_sub2[9]);
        $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[9], 'TB', '0',$list_sub2[$x][2],'1');
    //������̾or�ǹ���̾ tax name or with tax total name
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
    //�������� value of tax
    }else if($x==5){
        $money_tax2 = $tax_sub2[14];
        #2010-02-03 aoyama-n
        $tax_sub[14] = bcadd($tax_sub[14],$tax_sub2[14]);

        $tax_sub2[14] = number_format($tax_sub2[14]);
        $pdf->Cell($list_sub2[$x][0], 14, $tax_sub2[14], 'TB', '0',$list_sub2[$x][2],'1');
    //�ǹ����� total of amount with tax
    }else if($x==7){
        $money_sum = bcadd($money_tax2,$money2);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub2[$x][0], 14, $money_sum, 'TB', '0',$list_sub2[$x][2],'1');
    }
}
//���ڡ�������ʬ����ɽ�� display cells according to how much space there is
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
//���ڡ������� new page process
//***********************   
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ������� if the row number becomes the max number of items that can be displayed in a page, make it a new page
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //�إå���ɽ�� display header
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ���������� if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
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
//�ǽ�������׽��� final total of purchase client process
//***********************   
for($x=0;$x<count($list_sub)-1;$x++){
    //������׹��ֹ� row number of the total of purchase client
    if($x==0){
        $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
    //�������̾ name of the purchase client
    }else if($x==1){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBL', '0',$list_sub[$x][2],'1');
    //��������� value of the total of purchase client
    }else if($x==3){
        //������פ����ͤ�­���Ƥ��� add the total of purchase client to the total value
        $data_total[2] = bcadd($data_total[2],$data_sub[9]);
        $money = $data_sub[9];
        $data_sub[9] = number_format($data_sub[9]);
        $pdf->Cell($list_sub[$x][0], 14, $data_sub[9], 'TB', '0',$list_sub[$x][2],'1');
    //������̾or�ǹ���̾ tax name or with tax total name
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
    //�������� v
    }else if($x==5){
        //�������ͤ����ͤ�­���Ƥ��� add the tax value to the total value
        $tax_total[4] = bcadd($tax_total[4],$tax_sub[14]);
        $money_tax = $tax_sub[14];
        $tax_sub[14] = number_format($tax_sub[14]);
        #2010-02-03 aoyama-n
        #$pdf->Cell($list_sub[$x][0], 14, $money_tax, 'TB', '0',$list_sub[$x][2],'1');
        $pdf->Cell($list_sub[$x][0], 14, $tax_sub[14], 'TB', '0',$list_sub[$x][2],'1');
    //�ǹ����� total of amount with tax
    }else if($x==7){
        $money_sum = bcadd($money_tax,$money);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
    }
}
//���ڡ�������ʬ����ɽ�� display cell just as many spaces ther are
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
//���ڡ������� new page process
//***********************   
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ������� if the row number becomes the max number of items that can be displayed in a page, make it a new page
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //�إå���ɽ�� v
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ���������� if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
    $page_back = $page_next+1;
    //���κ���ɽ���� the next max items to be displayed
    $page_next = $page_max * $page_count;
    $space_flg = true;
    $space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//���׽��� total total computation process
//***********************   
for($x=0;$x<count($list_sub)-1;$x++){
    //��׹��ֹ� "total" row number
    if($x==0){
        $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
    //����̾name of the total row
    }else if($x==2){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'LTB', '0',$list_sub[$x][2],'1');
    //������ value of total computed
    }else if($x==3){
        $money = $data_total[2];
        $data_total[2] = number_format($data_total[2]);
        $pdf->Cell($list_sub[$x][0], 14, $data_total[2], 'TB', '0',$list_sub[$x][2],'1');
    //������̾or�ǹ���̾ tax name or with tax total name
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
    //�������� value of tax
    }else if($x==5){
        $money_tax = $tax_total[4];
        $tax_total[4] = number_format($tax_total[4]);
        $pdf->Cell($list_sub[$x][0], 14, $tax_total[4], 'TB', '0',$list_sub[$x][2],'1');
    //�ǹ����� total of amount with tax
    }else if($x==7){
        $money_sum = bcadd($money_tax,$money);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
    }
}

//���ڡ�������ʬ����ɽ�� display cell just as many spaces ther are
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBR', '2',$list_sub[$x][2],'1');

//���� output
$pdf->Output();

?>
