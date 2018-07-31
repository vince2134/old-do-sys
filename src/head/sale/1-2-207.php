<?php
/**
 * ������ٰ���ɽ
 *
 *
 * �ѹ�����
 *   2006/09/16 (kaji)
 *     ��301���ܡ���UNION ALL�פΤ��Ȥ˥��ڡ������줿
 *     ��306���ܡ�$sql�Τ��Ȥ�.�����줿
 *   2006/11/06      08-114      suzuki      �������������˽���
 *   2006/11/06      08-056      suzuki      ɽ�����������ˤ���Ģɼ���ϤǤ���褦�˽���
 *   2006/11/09      08-134      suzuki      �ǹ���۸�����̤�Ģɼ���Ϥ�ȿ�Ǥ���Ƥ��ʤ�
 *   2006/11/09      08-136      suzuki      ���ʥ����ɡ�����̾������̤�Ģɼ���Ϥ�ȿ�Ǥ���Ƥ��ʤ�
 *   2006/12/09      ban_0118    suzuki      �����ʬ��ɽ��
 *   2006/12/09      ban_0119    suzuki      �����ʬ�ˤ�äƶ�ۤ�ޥ��ʥ��ˤ���褦�˽���
 *   2007/03/01                  morita-d    ����̾������̾�Τ�ɽ������褦���ѹ� 
 *   2007/09/11                  watanabe-k  ��ɼ�ֹ�ǥ����Ȥ���褦�˽���
 *   2007/09/11                  watanabe-k  ���ʤξ��Ͽ��̤˥ޥ��ʥ���Ĥ���褦�˽���
 */

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");
require(FPDF_DIR);

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);


/*****************************/
// �������ܥ����å�
/*****************************/
if ($_POST == null){
    header("Location: ../top.php");
}


/************************************************/
// �����ѿ����ϲս�
/************************************************/
// SESSION
$shop_id = $_SESSION["client_id"];


/************************************************/
// ���顼�����å�
/************************************************/
// �����ô����
if ($_POST["form_sale_staff"]["cd"] != null && !ereg("^[0-9]+$", $_POST["form_sale_staff"]["cd"])){
    $message0 = "<li>���ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���<br>";
}

// �����ô��ʣ������
// ����޶��ڤ��Ⱦ�ѿ��������å�
if($_POST["form_multi_staff"] != null){
    $ary_multi_staff = explode(",", $_POST["form_multi_staff"]);
    foreach ($ary_multi_staff as $key => $value){
        if (!ereg("^[0-9]+$", trim($value))){
            $message1 = "<li>���ô��ʣ������ �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���<br>";
        }       
    }
}

// �����׾���
// ���ͥ����å�
if (
    ($_POST["form_sale_day"]["sy"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["sy"])) ||
    ($_POST["form_sale_day"]["sm"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["sm"])) ||
    ($_POST["form_sale_day"]["sd"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["sd"])) ||
    ($_POST["form_sale_day"]["ey"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["ey"])) ||
    ($_POST["form_sale_day"]["em"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["em"])) ||
    ($_POST["form_sale_day"]["ed"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["ed"]))
){
    $message2 = "<li>���׾��� �������ǤϤ���ޤ���<br>";
    $sale_day_err_flg = true;
}
// �ʳ��ϡ������������å�
if (
    $sale_day_err_flg != true &&
    ($_POST["form_sale_day"]["sy"] != null || $_POST["form_sale_day"]["sm"] != null || $_POST["form_sale_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_sale_day"]["sm"], (int)$_POST["form_sale_day"]["sd"], (int)$_POST["form_sale_day"]["sy"])){
        $message2 = "<li>���׾��� �������ǤϤ���ޤ���<br>";
        $sale_day_err_flg = true;
    }
}
// �ʽ�λ�������������å�
if (
    $sale_day_err_flg != true &&
    ($_POST["form_sale_day"]["ey"] != null || $_POST["form_sale_day"]["em"] != null || $_POST["form_sale_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_sale_day"]["em"], (int)$_POST["form_sale_day"]["ed"], (int)$_POST["form_sale_day"]["ey"])){
        $message2 = "<li>���׾��� �������ǤϤ���ޤ���<br>";
        $sale_day_err_flg = true; 
    }
}

// ��������
// ���ͥ����å�
if (
    ($_POST["form_claim_day"]["sy"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["sy"])) ||
    ($_POST["form_claim_day"]["sm"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["sm"])) ||
    ($_POST["form_claim_day"]["sd"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["sd"])) ||
    ($_POST["form_claim_day"]["ey"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["ey"])) ||
    ($_POST["form_claim_day"]["em"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["em"])) ||
    ($_POST["form_claim_day"]["ed"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["ed"]))
){
    $message3 = "<li>������ �������ǤϤ���ޤ���<br>";
    $claim_day_err_flg = true;
}
// �ʳ��ϡ������������å�
if (
    $claim_day_err_flg != true &&
    ($_POST["form_claim_day"]["sy"] != null || $_POST["form_claim_day"]["sm"] != null || $_POST["form_claim_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_claim_day"]["sm"], (int)$_POST["form_claim_day"]["sd"], (int)$_POST["form_claim_day"]["sy"])){
        $message3 = "<li>������ �������ǤϤ���ޤ���<br>";
        $claim_day_err_flg = true;
    }
}
// �ʽ�λ�������������å�
if (
    $claim_day_err_flg != true &&
    ($_POST["form_claim_day"]["ey"] != null || $_POST["form_claim_day"]["em"] != null || $_POST["form_claim_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_claim_day"]["em"], (int)$_POST["form_claim_day"]["ed"], (int)$_POST["form_claim_day"]["ey"])){
        $message3 = "<li>������ �������ǤϤ���ޤ���<br>";
        $claim_day_err_flg = true; 
    }
}

// ���ǹ����
// ���ͥ����å�
if (
    ($_POST["form_sale_amount"]["s"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_sale_amount"]["s"])) ||
    ($_POST["form_sale_amount"]["e"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_sale_amount"]["e"]))
){
    $message4 = "<li>�ǹ���� �Ͽ��ͤΤߤǤ���<br>";
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
$_POST["form_sale_day"]  = Str_Pad_Date($_POST["form_sale_day"]);
$_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

// �ե�������ͤ��ѿ��˥��å�
$display_num        = $_POST["form_display_num"];
$output_type        = $_POST["form_output_type"];
$client_cd1         = $_POST["form_client"]["cd1"];
$client_cd2         = $_POST["form_client"]["cd2"];
$client_name        = $_POST["form_client"]["name"];
$sale_staff_cd      = $_POST["form_sale_staff"]["cd"];
$sale_staff_select  = $_POST["form_sale_staff"]["select"];
$ware               = $_POST["form_ware"];
$claim_cd1          = $_POST["form_claim"]["cd1"];
$claim_cd2          = $_POST["form_claim"]["cd2"];
$claim_name         = $_POST["form_claim"]["name"];
$multi_staff        = $_POST["form_multi_staff"];
$sale_day_sy        = $_POST["form_sale_day"]["sy"];
$sale_day_sm        = $_POST["form_sale_day"]["sm"];
$sale_day_sd        = $_POST["form_sale_day"]["sd"];
$sale_day_ey        = $_POST["form_sale_day"]["ey"];
$sale_day_em        = $_POST["form_sale_day"]["em"];
$sale_day_ed        = $_POST["form_sale_day"]["ed"];
$claim_day_sy       = $_POST["form_claim_day"]["sy"];
$claim_day_sm       = $_POST["form_claim_day"]["sm"];
$claim_day_sd       = $_POST["form_claim_day"]["sd"];
$claim_day_ey       = $_POST["form_claim_day"]["ey"];
$claim_day_em       = $_POST["form_claim_day"]["em"];
$claim_day_ed       = $_POST["form_claim_day"]["ed"];
$renew              = $_POST["form_renew"];
$sale_amount_s      = $_POST["form_sale_amount"]["s"];
$sale_amount_e      = $_POST["form_sale_amount"]["e"];
$slip_no_s          = $_POST["form_slip_no"]["s"];
$slip_no_e          = $_POST["form_slip_no"]["e"];
$aord_no_s          = $_POST["form_aord_no"]["s"];
$aord_no_e          = $_POST["form_aord_no"]["e"];
$goods_cd           = $_POST["form_goods"]["cd"];
$goods_name         = $_POST["form_goods"]["name"];
$g_goods            = $_POST["form_g_goods"];
$product            = $_POST["form_product"];
$g_product          = $_POST["form_g_product"];
$slip_type          = $_POST["form_slip_type"];
$slip_out           = $_POST["form_slip_out"];
$trade              = $_POST["form_trade"];


/*****************************/
//�إå��������ؿ�
/*****************************/
function Header_disp2($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$list,$font_size,$page_size){

    $pdf->SetFont(GOTHIC, '', $font_size);
    $pdf->SetXY($left_margin,$top_margin);
    $pdf->Cell($page_size, 14, $title, '0', '1', 'C');
    $pdf->SetXY($left_margin,$top_margin);
    $pdf->Cell($page_size, 14, $page_count."�ڡ���", '0', '2', 'R');
    $pdf->SetX($left_margin);
    $pdf->Cell($page_size, 14, $left_top, '0', '1', 'L');
    $pdf->SetXY($left_margin,$top_margin+14);
    $pdf->Cell($page_size, 14, $right_top, '0', '1', 'R');
    $pdf->SetXY($left_margin,$top_margin+28);
    $pdf->Cell($page_size, 14, $right_bottom, '0', '1', 'R');
    $pdf->SetXY($left_margin,$top_margin+28);
    $pdf->Cell($page_size, 14, $left_bottom, '0', '2', 'L');

    //����ɽ��
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    for($i=0;$i<count($list)-1;$i++)
    {
        //�����ʬ�ʳ�ɽ��
        if($i != 5){
            $pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
        }
    }
    $pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

}


/*****************************/
// �����ѿ�����
/*****************************/
//;��
$left_margin = 40;
$top_margin = 40;

//�إå����Υե���ȥ�����
$font_size = 9;
//�ڡ���������
$page_size = 1110;

//A3
$pdf=new MBFPDF('L','pt','A3');

//�����ȥ�
$title = "������ٰ���ɽ";
$page_count = 1; 


/*****************************/
// ��о�����
/*****************************/
// ���׾�����ޤȤ���ѿ���
$sale_day_s = $sale_day_sy."-".$sale_day_sm."-".$sale_day_sd;
$sale_day_e = $sale_day_ey."-".$sale_day_em."-".$sale_day_ed;

// ���׾���������Ѥ�
$sale_date_s = $sale_day_sy."ǯ".$sale_day_sm."��".$sale_day_sd."��";
$sale_date_e = $sale_day_ey."ǯ".$sale_day_em."��".$sale_day_ed."��";

if ($sale_day_sy == null && $sale_day_sm == null && $sale_day_sd == null &&
    $sale_day_ey == null && $sale_day_em == null && $sale_day_ed == null){
    $time = "���׾���������ʤ�";
}else
if ($sale_day_sy != null && $sale_day_sm != null && $sale_day_sd != null &&
    $sale_day_ey == null && $sale_day_em == null && $sale_day_ed == null){
    $time = "���׾�����".$sale_date_s."��";
}else
if ($sale_day_sy == null && $sale_day_sm == null && $sale_day_sd == null &&
    $sale_day_ey != null && $sale_day_em != null && $sale_day_ed != null){
    $time = "���׾�������".$sale_date_e;
}else{
    $time = "���׾�����".$sale_date_s."��".$sale_date_e;
}


/*****************************/
// ��о�����
/*****************************/
/* WHERE */

$sql = null;

// FC������襳����1
$sql .= ($client_cd1 != null) ? "AND t_sale_h.client_cd1 LIKE '$client_cd1%' " : null;
// FC������襳����2
$sql .= ($client_cd2 != null) ? "AND t_sale_h.client_cd2 LIKE '$client_cd2%' " : null;
// FC�������̾
if ($client_name != null){
    $sql .= "AND \n";
    $sql .= "   ( \n";
    $sql .= "       t_sale_h.client_name  LIKE '%$client_name%' \n";
    $sql .= "       OR \n";
    $sql .= "       t_sale_h.client_name2 LIKE '%$client_name%' \n";
    $sql .= "       OR \n";
    $sql .= "       t_sale_h.client_cname LIKE '%$client_name%' \n";
    $sql .= "   ) \n";
}
// ���ô���ԥ�����
$sql .= ($sale_staff_cd != null) ? "AND t_staff.charge_cd = '$sale_staff_cd' \n" : null;
// ���ô���ԥ��쥯��
$sql .= ($sale_staff_select != null) ? "AND t_staff.staff_id = $sale_staff_select \n" : null;
// �Ҹ�
$sql .= ($ware != null) ? "AND t_sale_h.ware_id = $ware \n" : null;
// �����襳���ɣ�   
$sql .= ($claim_cd1 != null) ? "AND t_client_claim.client_cd1 LIKE '$claim_cd1%' \n" : null;
// �����襳���ɣ�
$sql .= ($claim_cd2 != null) ? "AND t_client_claim.client_cd2 LIKE '$claim_cd2%' \n" : null;
// ������̾
if ($claim_name != null){
    $sql .= "AND \n";
    $sql .= "   ( \n";
    $sql .= "       t_client_claim.client_name  LIKE '%$claim_name%' \n";
    $sql .= "       OR \n";
    $sql .= "       t_client_claim.client_name2 LIKE '%$claim_name%' \n";
    $sql .= "       OR \n";
    $sql .= "       t_client_claim.client_cname LIKE '%$claim_name%' \n";
    $sql .= "   ) \n";
}
// ���ô��ʣ������
if ($multi_staff != null){
    $ary_multi_staff = explode(",", $multi_staff);
    $sql .= "AND \n";
    $sql .= "   t_staff.charge_cd IN (";
    foreach ($ary_multi_staff as $key => $value){
        $sql .= "'".trim($value)."'";
        $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
    }
}
// ���׾����ʳ��ϡ�
$sale_day_s  = $sale_day_sy."-".$sale_day_sm."-".$sale_day_sd;
$sql .= ($sale_day_s != "--") ? "AND '$sale_day_s' <= t_sale_h.sale_day \n" : null;
// ���׾����ʽ�λ��
$sale_day_e  = $sale_day_ey."-".$sale_day_em."-".$sale_day_ed;
$sql .= ($sale_day_e != "--") ? "AND t_sale_h.sale_day <= '$sale_day_e' \n" : null;
// �������ʳ��ϡ�
$claim_day_s  = $claim_day_sy."-".$claim_day_sm."-".$claim_day_sd;
$sql .= ($claim_day_s != "--") ? "AND t_sale_h.claim_day >= '$claim_day_s' \n" : null;
// �������ʽ�λ��
$claim_day_e  = $claim_day_ey."-".$claim_day_em."-".$claim_day_ed;
$sql .= ($claim_day_e != "--") ? "AND t_sale_h.claim_day <= '$claim_day_e' \n" : null;
// ��������
if ($renew == "2"){
    $sql .= "AND t_sale_h.renew_flg = 'f' \n";
}else
if ($renew == "3"){
    $sql .= "AND t_sale_h.renew_flg = 't' \n";
}
// ��ɼ�ֹ�ʳ��ϡ�
$sql .= ($slip_no_s != null) ? "AND t_sale_h.sale_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
// ��ɼ�ֹ�ʽ�λ��
$sql .= ($slip_no_e != null) ? "AND t_sale_h.sale_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
// �����ֹ�ʳ��ϡ�
$sql .= ($aord_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($aord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
// �����ֹ�ʽ�λ��
$sql .= ($aord_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($aord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
// ���ʥ�����
$sql .= ($goods_cd != null) ? "AND t_sale_d.goods_cd LIKE '$goods_cd%' " : null;
// ����̾
$sql .= ($goods_name != null) ? "AND t_sale_d.official_goods_name LIKE '%$goods_name%' \n" : null;
// �Ͷ�ʬ
$sql .= ($g_goods != null) ? "AND t_g_goods.g_goods_id = $g_goods \n" : null;
// ������ʬ
$sql .= ($product != null) ? "AND t_product.product_id = $product \n" : null;
// ����ʬ��
$sql .= ($g_product != null) ? "AND t_g_product.g_product_id = $g_product \n" : null;
// ��ɼȯ��
if ($slip_type == "2"){
    $sql .= "AND t_sale_h.slip_out = '1' \n";
}else
if ($slip_type == "3"){
    $sql .= "AND t_sale_h.slip_out = '2' \n";
}else
if ($slip_type == "4"){
    $sql .= "AND t_sale_h.slip_out = '3' \n";
}
// ȯ�Ծ���
if ($slip_out == "2"){
    $sql .= "AND t_sale_h.slip_flg = 'f' \n";
}else
if ($slip_out == "3"){
    $sql .= "AND t_sale_h.slip_flg = 't' \n";
}
// �����ʬ
$sql .= ($trade != null) ? "AND t_sale_h.trade_id = $trade \n" : null;

// �ѿ��ͤ��ؤ�
$where_sql = $sql;


/* HAVING */

$sql = null;

// �ǹ���ۡʳ��ϡ�
if ($sale_amount_s != null){
    $sql .= "HAVING \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
    $sql .= "                   THEN (t_sale_h.net_amount + t_sale_h.tax_amount) *  1 \n";
    $sql .= "                   ELSE (t_sale_h.net_amount + t_sale_h.tax_amount) * -1 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "   ) \n";
    $sql .= "   >= $sale_amount_s \n";
}
// �ǹ���ۡʽ�λ��
if ($sale_amount_e != null){
    $sql .= ($sale_amount_s == null) ? "HAVING \n" : "AND \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
    $sql .= "                   THEN (t_sale_h.net_amount + t_sale_h.tax_amount) *  1 \n";
    $sql .= "                   ELSE (t_sale_h.net_amount + t_sale_h.tax_amount) * -1 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "   ) \n";
    $sql .= "   <= $sale_amount_e \n";
}

// �ѿ��ͤ��ؤ�
$having_sql = $sql; 


/* ORDER BY */

$sql = null;


/*
// ���׾���
if($sort == "1"){
    $sql .= "ORDER BY \n";
    $sql .= "   3 DESC, \n";
    $sql .= "   2 DESC \n";
// ������
}elseif($sort == '2'){
    $sql .= "ORDER BY \n";
    $sql .= "   13, \n";
    $sql .= "   14, \n";
    $sql .= "   3 DESC, \n";
    $sql .= "   2 DESC \n";
}
*/

$sql .= "ORDER BY \n";
$sql .= "   t_sale_h.client_cd1, \n";
$sql .= "   t_sale_h.client_cd2, \n";
$sql .= "   t_sale_h.sale_no \n";


// �ѿ��ͤ��ؤ�
$order_by_sql = $sql; 


/****************************/
// �������
/****************************/
$sql  = "SELECT \n";
$sql .= "   t_sale_h.client_cname, \n";
$sql .= "   t_sale_h.sale_no, \n";
$sql .= "   t_sale_h.sale_day, \n";
$sql .= "   t_sale_d.official_goods_name, \n";
$sql .= "   t_sale_d.sale_div_cd, \n";
$sql .= "   CASE t_sale_h.trade_id \n";
$sql .= "       WHEN '13' THEN  t_sale_d.num * -1 \n";
$sql .= "       WHEN '63' THEN  t_sale_d.num * -1 \n";
$sql .= "       ELSE t_sale_d.num \n";
$sql .= "   END AS num, \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           CASE \n";
//$sql .= "               WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
$sql .= "               WHEN t_sale_h.trade_id IN (14,64) \n";
$sql .= "               THEN t_sale_d.sale_price * -1 \n";
$sql .= "               ELSE t_sale_d.sale_price  \n";
$sql .= "           END \n";
$sql .= "   ), \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           CASE \n";
$sql .= "               WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
$sql .= "               THEN t_sale_d.sale_amount *  1 \n";
$sql .= "               ELSE t_sale_d.sale_amount * -1 \n";
$sql .= "           END \n";
$sql .= "   ), \n";
$sql .= "   t_sale_h.note, \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           CASE \n";
$sql .= "               WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
$sql .= "               THEN t_sale_h.net_amount *  1 \n";
$sql .= "               ELSE t_sale_h.net_amount * -1 \n";
$sql .= "           END \n";
$sql .= "   ), \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           CASE \n";
$sql .= "               WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
$sql .= "               THEN t_sale_h.tax_amount *  1 \n";
$sql .= "               ELSE t_sale_h.tax_amount * -1 \n";
$sql .= "           END \n";
$sql .= "   ), \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           CASE \n";
$sql .= "               WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
$sql .= "               THEN t_sale_h.total_amount *  1 \n";
$sql .= "               ELSE t_sale_h.total_amount * -1 \n";
$sql .= "           END \n";
$sql .= "   ), \n";
$sql .= "   t_sale_h.client_cd1, \n";
$sql .= "   t_sale_h.client_cd2  \n";
$sql .= "FROM \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           t_sale_h.sale_id, \n";
$sql .= "           t_sale_h.sale_day, \n";
$sql .= "           t_sale_h.sale_no, \n";
$sql .= "           t_sale_h.client_cname, \n";
$sql .= "           t_sale_h.client_cd1, \n";
$sql .= "           t_sale_h.client_cd2, \n";
$sql .= "           t_sale_h.net_amount, \n";
$sql .= "           t_sale_h.tax_amount, \n";
$sql .= "           t_sale_h.note, \n";
$sql .= "           sum(t_sale_h.net_amount + t_sale_h.tax_amount) AS total_amount, \n";
$sql .= "           t_sale_h.trade_id \n";
$sql .= "       FROM \n";
$sql .= "           t_sale_h \n";
$sql .= "           LEFT  JOIN t_aorder_h                 ON t_sale_h.aord_id = t_aorder_h.aord_id \n";
$sql .= "           LEFT  JOIN t_client AS t_client_claim ON t_sale_h.claim_id = t_client_claim.client_id \n";
$sql .= "           LEFT  JOIN t_staff                    ON t_sale_h.c_staff_id = t_staff.staff_id \n";
if ($goods_cd != null || $goods_name != null || $g_goods != null || $product != null || $g_product != null){
$sql .= "   INNER JOIN t_sale_d     ON t_sale_h.sale_id = t_sale_d.sale_id \n";
$sql .= "   INNER JOIN t_goods      ON t_sale_d.goods_id = t_goods.goods_id \n";
}
if ($g_goods != null){
$sql .= "   INNER JOIN t_g_goods    ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
}
if ($product != null){
$sql .= "   INNER JOIN t_product    ON t_goods.product_id = t_product.product_id \n";
}
if ($g_product != null){
$sql .= "   INNER JOIN t_g_product  ON t_goods.g_product_id = t_g_product.g_product_id \n";
}
$sql .= "       WHERE \n";
$sql .= "           t_sale_h.shop_id = 1 \n";
$sql .= $where_sql;
$sql .= "       GROUP BY \n";
$sql .= "           t_sale_h.sale_id, \n";
$sql .= "           t_sale_h.sale_day, \n";
$sql .= "           t_sale_h.sale_no, \n";
$sql .= "           t_sale_h.net_amount, \n";
$sql .= "           t_sale_h.note, \n";
$sql .= "           t_sale_h.tax_amount, \n";
$sql .= "           t_sale_h.client_cname, \n";
$sql .= "           t_sale_h.client_cd1, \n";
$sql .= "           t_sale_h.client_cd2, \n";
$sql .= "           t_aorder_h.ord_no, \n";
$sql .= "           t_aorder_h.aord_id, \n";
$sql .= "           t_sale_h.renew_flg, \n";
$sql .= "           t_sale_h.trade_id  \n";
$sql .= $having_sql;
$sql .= "   ) \n";
$sql .= "   AS t_sale_h \n";
$sql .= "   INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
$sql .= $order_by_sql;

//�������SQL
$count_sql = $sql.";";

// ɽ����
//LIMITSQL
$limit_sql = " LIMIT 100 OFFSET $offset";
if($output_type == '1'){
    $sql .= $limit_sql;
}

$sql .= ";";
//����̾������align
$list[0] = array("30","NO","C");
$list[1] = array("160","������̾","C");
$list[2] = array("50","��ɼ�ֹ�","C");
$list[3] = array("90","�����","C");
$list[4] = array("340","����̾","C");
$list[5] = array("60","�����ʬ","C");
$list[6] = array("60","����","C");
$list[7] = array("90","���ñ��","C");
$list[8] = array("90","�����","C");
$list[9] = array("200","����","C");

//������ס����סʾ�����/�ǹ��ס�
$list_sub[0] = array("160","�������","L");
$list_sub[1] = array("160","����","L");
$list_sub[2] = array("60","�����ǡ�","L");
$list_sub[3] = array("60","�ǹ��ס�","L");
//��ɼ�סʾ�����/�ǹ��ס�
$list_sub[4] = array("50","��ɼ��","L");
$list_sub[5] = array("280","�����ǡ�","L");
$list_sub[6] = array("60","�ǹ��ס�","L");

//align(�ǡ���)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "C";
$data_align[4] = "L";
$data_align[5] = "C";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "L";


//�ڡ�������ɽ����
$page_max = 50;

//***********************************************
//DB��³
$db_con = Db_Connect();
$result = Db_Query($db_con,$sql);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("�������Yǯm��d����H:i");

//�إå���ɽ��
Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

//�ģ¤��ͤ�ɽ��
//�Կ������Υڡ���ɽ���������Υڡ���ɽ��������ɼ�ס�������ס���ס�����͡������ǡ��ǹ���ۡ������
$count = 0;
$page_next = $page_max;
$page_back = 0;
$data_sub = array();
$data_sub2 = array();
$data_total = array();
$person = "";
$slip = "";
$money_tax = 0;
$money = 0;
$client_tax = 0;
$client_money = 0;

//�ǡ�����¸�ߤ���֥롼�פ���
while($data_list = @pg_fetch_array($result)){
    $count++;
//*******************���ڡ�������*****************************

    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);

//******************��ɼ�׽���***********************************

    //�ͤ��Ѥ�ä���硢��ɼ��ɽ��
    if($slip != $data_list[1]){
        //����ܤϡ��ͤ򥻥åȤ������
        if($count != 1){
            $pdf->SetFillColor(220,220,220);
            //�ͤξ�άȽ��ե饰
            $space_flg2 = true;
            for($x=0;$x<9;$x++){
                //��ɼ�׹��ֹ�
                if($x==0){
                    $pdf->SetFont(GOTHIC, '', 9);
                    $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
                    $pdf->SetFont(GOTHIC, 'B', 9);
                //������̾
                }else if($x==1){
                    //���ڡ���������ΰ���ܤ�����ɼ�פξ�硢������̾ɽ��
                    if($page_back == $count){
                        $pdf->SetFont(GOTHIC, '', 9);
                        $pdf->Cell($list[$x][0], 14, $customer, 'LR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 9);
                        //�������ɽ�����������ϡ��ǡ�������������ά
                        $slip_flg = true;
                    }else if($page_next == $count){
                        $pdf->SetFont(GOTHIC, '', 9);
                        $pdf->Cell($list[$x][0], 14, '', 'LBR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 9);
                    }else{
                        $pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
                        $slip_flg = false;
                    }
                //��ɼ��̾
                }else if($x==2){
                    $pdf->Cell(50, 14, $list_sub[4][1]."��", 'TBL', '0',$list_sub[0][2],'1');
                //��ɼ����
                }else if($x==3){
                    //�����ѹ�
                    $data_sub2[8] = number_format($data_sub2[8]);
                    //�ǹ���ۤ�­��(���������)
                    $client_money = $client_money + ($data_sub2[10] + $data_sub2[11]);
                    //�ǹ����
                    $data_sub2[10] = number_format($data_sub2[10] + $data_sub2[11]);

                    //�����ǳۤ�­��(���������)
                    $client_tax = $client_tax + $data_sub2[11];
                    //�����ǳ�
                    $data_sub2[11] = number_format($data_sub2[11]);

                    $pdf->Cell(90, 14, $data_sub2[8], 'TB', '0','R','1');
                //������̾
                }else if($x==4){
                    $pdf->Cell(50, 14, $list_sub[5][1], 'TB', '0','R','1');
                //��������
                }else if($x==5){
                    $pdf->Cell(90, 14, $data_sub2[11], 'TB', '0','R','1');
                //�ǹ���̾
                }else if($x==6){
                    $pdf->Cell(50, 14, $list_sub[6][1], 'TB', '0','R','1');
                //�ǹ�����
                }else if($x==7){
                    $pdf->Cell(90, 14, $data_sub2[10], 'TB', '0','R','1');
                //������ͤ�ɽ��
                }else if($x==8){
                    $pdf->Cell(300, 14, $data_sub2[2], 'TB', '0','R','1');
                }else{
                    $pdf->Cell(300, 14, $data_sub2[$x], 'TB', '0','R','1');
                }
            }
            $pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'TBR', '2','R','1');
            //��ɼ�ס������ǡ��ǹ��ס������
            $data_sub2 = array();
            $count++;
        }
        for($x=10;$x<12;$x++){
            //�ǹ���۷׻�
            if($x==10){
                //�ͤ���ɼ�פ�­���Ƥ���
                $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            //�����ǳ۷׻�
            }else if($x==11){
                //�ͤ���ɼ�פ�­���Ƥ���
                $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            }
        }
        $slip = $data_list[1];
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);

    //*******************���ڡ�������*****************************

    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);

//******************������׽���***********************************

    //�ͤ��Ѥ�ä���硢�������ɽ��
    if($person != $data_list[0]){
        //����ܤϡ��ͤ򥻥åȤ������
        if($count != 1){
            $pdf->SetFillColor(180,180,180);
            //�ͤξ�άȽ��ե饰
            $space_flg = true;
            for($x=0;$x<9;$x++){
                //���׹��ֹ�
                if($x==0){
                    $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
                }else if($x==1){
                    $pdf->Cell($list_sub[0][0], 14, $list_sub[0][1]."��", 'TBL', '0',$list_sub[0][2],'1');
                //�������̾
                }else if($x==2){
                    $pdf->Cell(50, 14, "", 'TB', '0',$list_sub[0][2],'1');
                //���������
                }else if($x==3){
                    //�����ͤ����ͤ�­���Ƥ���
                    $data_total[2] = $data_total[2] + $data_sub[8];
                    //������
                    $money_tax = $money_tax + $client_tax;
                    $data_total[3] = $data_total[3] + $money_tax;
                    //�ǹ����
                    $money = $money + $client_money;
                    //�ǹ���ۤ�­��(������)
                    $data_total[4] = $data_total[4] + $money;
                    //�����ǳ�
                    $money_tax = number_format($money_tax);
                    //�����ǳۤ�­��(������)
                    $money = number_format($money);
                    $data_sub[8] = number_format($data_sub[8]);
                    
                    $pdf->Cell(90, 14, $data_sub[8], 'TB', '0','R','1');
                //������̾
                }else if($x==4){
                    $pdf->Cell(50, 14, $list_sub[2][1], 'TB', '0','R','1');
                //��������
                }else if($x==5){
                    $pdf->Cell(90, 14, $money_tax, 'TB', '0','R','1');
                //�ǹ���̾
                }else if($x==6){
                    $pdf->Cell(50, 14, $list_sub[3][1], 'TB', '0','R','1');
                //�ǹ�����
                }else if($x==7){
                    $pdf->Cell(90, 14, $money, 'TB', '0','R','1');
                //������ͤ�ɽ��
                }else if($x==8){
                    $pdf->Cell(300, 14, $data_sub[2], 'TB', '0','R','1');
                }else{
                    $pdf->Cell(300, 14, $data_sub[$x], 'TB', '0','R','1');
                }
            }
            $pdf->Cell($list[$x][0], 14, $data_sub[$x], 'TBR', '2','R','1');
            //������ס������ǡ��ǹ��ס������
            $data_sub = array();
            $money_tax = 0;
            $money = 0;
            $count++;
        }
        $person = $data_list[0];
        for($x=10;$x<12;$x++){
            //�ǹ���۷׻�
            if($x==10){
                //�ͤ�������פ�­���Ƥ���
                $data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
            //�����ǳ۷׻�
            }else if($x==11){
                //�ͤ�������פ�­���Ƥ���
                $data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
            }
        }
        $client_tax = "";
        $client_money = "";
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, '', 9);

    //*******************���ڡ�������*****************************

    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, '', 9);

//************************�ǡ���ɽ��***************************
    //���ֹ�
    $pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
    for($x=1;$x<9;$x++){
        //ɽ����
        $contents = "";
        //ɽ��line
        $line = "";

        //������̾�ξ�άȽ��
        //��ɼ�פ��������ɽ�������Ƥ��ʤ������ġ�����ܤ����פθ�ξ��ϡ���ά���ʤ���
        if($x==1 && $slip_flg == false && ($count == 1 || $space_flg == true)){
            //������Ƚ��
            //�ڡ����κ���ɽ������
            $contents = $data_list[$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LR';
            }
            //��ɼ�פ�ɽ��������������̾������
            $customer = $data_list[$x-1];
            //������̾���ά����
            $space_flg = false;
        //��ɼ�פ��������ɽ�����ޤ��ϡ������������ɽ����������
        }else if($x==1){
            //�ڡ����κ���ɽ������
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
            $customer = $data_list[$x-1];
        //����ܤ���ɼ�פθ�ʳ����ͤξ�ά
        }else if($x==2 && ($count == 1 || $space_flg2 == true)){
            //������Ƚ��
            //�ڡ����κ���ɽ������
            $contents = $data_list[$x-1];
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
        //����۷׻�
        }else if($x==8){
            //�ͤ���ɼ�פ�­���Ƥ���
            $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            //�ͤ�������פ�­���Ƥ���
            $data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
            $data_list[$x-1] = number_format($data_list[$x-1]);

            $contents = $data_list[$x-1];
            $line = '1';
        }else{
            //�������ä��饫��޶��ڤꤹ��
            if(is_numeric($data_list[$x-1])){
                //ñ��Ƚ��
                if($x == 7){
                    //ñ��
                    $data_list[$x-1] = number_format($data_list[$x-1],2);
                }else{
                    //¾�ο���
                    $data_list[$x-1] = number_format($data_list[$x-1]);
                }
            }
            $contents = $data_list[$x-1];
            $line = '1';
        }
        //�����ʬ�ʳ�ɽ��
        if($x!=5){
            $pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
        }
    }
    $pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '2', $data_align[$x]);

}
//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFillColor(220,220,220);
    $count++;

//*******************���ڡ�������*****************************

    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);

//******************�ǽ���ɼ�׽���***********************************

    //�ͤ��Ѥ�ä���硢��ɼ��ɽ��
    if($slip != $data_list[1]){
        //����ܤϡ��ͤ򥻥åȤ������
        if($count != 1){
            $pdf->SetFillColor(220,220,220);
            //�ͤξ�άȽ��ե饰
            $space_flg2 = true;
            for($x=0;$x<9;$x++){
                //��ɼ�׹��ֹ�
                if($x==0){
                    $pdf->SetFont(GOTHIC, '', 9);
                    $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
                    $pdf->SetFont(GOTHIC, 'B', 9);
                //������̾
                }else if($x==1){
                    //���ڡ���������ΰ���ܤ�����ɼ�פξ�硢������̾ɽ��
                    if($page_back == $count){
                        $pdf->SetFont(GOTHIC, '', 9);
                        $pdf->Cell($list[$x][0], 14, $customer, 'LR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 9);
                        //�������ɽ�����������ϡ��ǡ�������������ά
                        $slip_flg = true;
                    }else if($page_next == $count){
                        $pdf->SetFont(GOTHIC, '', 9);
                        $pdf->Cell($list[$x][0], 14, '', 'LBR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 9);
                    }else{
                        $pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
                        $slip_flg = false;
                    }
                //��ɼ��̾
                }else if($x==2){
                    $pdf->Cell(50, 14, $list_sub[4][1]."��", 'TBL', '0',$list_sub[0][2],'1');
                //��ɼ����
                }else if($x==3){
                    //�����ѹ�
                    $data_sub2[8] = number_format($data_sub2[8]);
                    //�ǹ���ۤ�­��(���������)
                    $client_money = $client_money + ($data_sub2[10] + $data_sub2[11]);
                    //�ǹ����
                    $data_sub2[10] = number_format($data_sub2[10] + $data_sub2[11]);

                    //�����ǳۤ�­��(���������)
                    $client_tax = $client_tax + $data_sub2[11];
                    //�����ǳ�
                    $data_sub2[11] = number_format($data_sub2[11]);

                    $pdf->Cell(90, 14, $data_sub2[8], 'TB', '0','R','1');
                //������̾
                }else if($x==4){
                    $pdf->Cell(50, 14, $list_sub[5][1], 'TB', '0','R','1');
                //��������
                }else if($x==5){
                    $pdf->Cell(90, 14, $data_sub2[11], 'TB', '0','R','1');
                //�ǹ���̾
                }else if($x==6){
                    $pdf->Cell(50, 14, $list_sub[6][1], 'TB', '0','R','1');
                //�ǹ�����
                }else if($x==7){
                    $pdf->Cell(90, 14, $data_sub2[10], 'TB', '0','R','1');
                //������ͤ�ɽ��
                }else if($x==8){
                    $pdf->Cell(300, 14, $data_sub2[2], 'TB', '0','R','1');
                }else{
                    $pdf->Cell(300, 14, $data_sub2[$x], 'TB', '0','R','1');
                }
            }
            $pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'TBR', '2','R','1');
            //��ɼ�ס������ǡ��ǹ��ס������
            $data_sub2 = array();
            $count++;
        }
        for($x=10;$x<12;$x++){
            //�ǹ���۷׻�
            if($x==10){
                //�ͤ���ɼ�פ�­���Ƥ���
                $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            //�����ǳ۷׻�
            }else if($x==11){
                //�ͤ���ɼ�פ�­���Ƥ���
                $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            }
        }
        $slip = $data_list[1];
    }

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//*******************���ڡ�������*****************************

    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);


//******************�ǽ�������׽���***********************************

    //�ͤ��Ѥ�ä���硢�������ɽ��
    if($person != $data_list[0]){
        //����ܤϡ��ͤ򥻥åȤ������
        if($count != 1){
            $pdf->SetFillColor(180,180,180);
            //�ͤξ�άȽ��ե饰
            $space_flg = true;
            for($x=0;$x<9;$x++){
                //���׹��ֹ�
                if($x==0){
                    $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
                }else if($x==1){
                    $pdf->Cell($list_sub[0][0], 14, $list_sub[0][1]."��", 'TBL', '0',$list_sub[0][2],'1');
                //�������̾
                }else if($x==2){
                    $pdf->Cell(50, 14, "", 'TB', '0',$list_sub[0][2],'1');
                //���������
                }else if($x==3){
                    //�����ͤ����ͤ�­���Ƥ���
                    $data_total[2] = $data_total[2] + $data_sub[8];
                    //������
                    $money_tax = $money_tax + $client_tax;
                    $data_total[3] = $data_total[3] + $money_tax;
                    //�ǹ����
                    $money = $money + $client_money;
                    //�ǹ���ۤ�­��(������)
                    $data_total[4] = $data_total[4] + $money;
                    //�����ǳ�
                    $money_tax = number_format($money_tax);
                    //�����ǳۤ�­��(������)
                    $money = number_format($money);
                    $data_sub[8] = number_format($data_sub[8]);
                    
                    $pdf->Cell(90, 14, $data_sub[8], 'TB', '0','R','1');
                //������̾
                }else if($x==4){
                    $pdf->Cell(50, 14, $list_sub[2][1], 'TB', '0','R','1');
                //��������
                }else if($x==5){
                    $pdf->Cell(90, 14, $money_tax, 'TB', '0','R','1');
                //�ǹ���̾
                }else if($x==6){
                    $pdf->Cell(50, 14, $list_sub[3][1], 'TB', '0','R','1');
                //�ǹ�����
                }else if($x==7){
                    $pdf->Cell(90, 14, $money, 'TB', '0','R','1');
                //������ͤ�ɽ��
                }else if($x==8){
                    $pdf->Cell(300, 14, $data_sub[2], 'TB', '0','R','1');
                }else{
                    $pdf->Cell(300, 14, $data_sub[$x], 'TB', '0','R','1');
                }
            }
            $pdf->Cell($list[$x][0], 14, $data_sub[$x], 'TBR', '2','R','1');
            //������ס������ǡ��ǹ��ס������
            $data_sub = array();
            $money_tax = 0;
            $money = 0;
            $count++;
        }
        $person = $data_list[0];
        for($x=10;$x<12;$x++){
            //�ǹ���۷׻�
            if($x==10){
                //�ͤ�������פ�­���Ƥ���
                $data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
            //�����ǳ۷׻�
            }else if($x==11){
                //�ͤ�������פ�­���Ƥ���
                $data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
            }
        }
        $client_tax = "";
        $client_money = "";
    }

//*************************************************************


$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//*******************���ڡ�������*****************************

    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //�إå���ɽ��
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
        $page_back = $page_next+1;
        //���κ���ɽ����
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);

//*************************���׽���*******************************

for($x=0;$x<9;$x++){
    //��׹��ֹ�
    if($x==0){
        $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
    }else if($x==1){
        $pdf->Cell($list_sub[1][0], 14, $list_sub[1][1]."��", 'TBL', '0',$list_sub[1][2],'1');
    //����̾
    }else if($x==2){
        $pdf->Cell(50, 14, "", 'TB', '0',$list_sub[1][2],'1');
    //ô���Է���
    }else if($x==3){
        //�����Ƿ׻�
        $money_tax = $data_total[3];
        //�ǹ���۷׻�
        $money = $data_total[4];
        //�����ѹ�
        $money_tax = number_format($money_tax);
        $money = number_format($money);
        $data_total[2] = number_format($data_total[2]);

        $pdf->Cell(90, 14, $data_total[2], 'TB', '0','R','1');
    //������̾
    }else if($x==4){
        $pdf->Cell(50, 14, $list_sub[2][1], 'TB', '0','R','1');
    //��������
    }else if($x==5){
        $pdf->Cell(90, 14, $money_tax, 'TB', '0','R','1');
    //�ǹ���̾
    }else if($x==6){
        $pdf->Cell(50, 14, $list_sub[3][1], 'TB', '0','R','1');
    //�ǹ�����
    }else if($x==7){
        $pdf->Cell(90, 14, $money, 'TB', '0','R','1');
    }else{
        $pdf->Cell(90, 14, $data_total[$x], 'TB', '0','R','1');
    }
}
$pdf->Cell(410, 14, $data_total[$x], 'TBR', '2','R','1');
//****************************************************************

$pdf->Output();

?>
