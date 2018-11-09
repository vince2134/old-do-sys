<?php

/*
 * 変更履歴
 *  (2006/11/06) 06-042 伝票番号で検索できるように修正(suzuki-t)
 *  (2006/11/07) 06-044 仕入日で検索できるように修正(suzuki-t)
 *  (2006/11/07) 06-045 マイナス値でも検索可能に修正(suzuki-t)
*/


/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/11　06-072　　　　watanabe-k　商品名、備考がナンバーフォーマットされているバグの修正
 * 　2006/11/11　06-073　　　　watanabe-k　サニタイズされすぎているバグの修正
 * 　2006/11/11　06-073　　　　watanabe-k　サニタイズされすぎているバグの修正
 * 　2006/12/09　ban_0120　　　suzuki　    線の描画処理修正
 * 　2006/12/09　ban_0121　　　suzuki　    データ描画処理修正
 *   2010/02/03                aoyama-n    仕入先計の消費税額集計不具合修正
 *
 */


//環境設定ファイル env setting file
require_once("ENV_local.php");
require(FPDF_DIR);

$conn = Db_Connect();

// 権限チェック auth check
$auth = Auth_Check($conn);


/************************************************/
// 外部変数入力箇所 input field external variable
/************************************************/
// SESSION 
$shop_id = $_SESSION["client_id"];


/************************************************/
// エラーチェック error check
/************************************************/
// ■仕入担当者 purchase assigned staff
if ($_POST["form_c_staff"]["cd"] != null && !ereg("^[0-9]+$", $_POST["form_c_staff"]["cd"])){
    $message0 = "<li>仕入担当者 は数値のみ入力可能です。<br>";
}

// ■仕入日 purhcase date
// 数値チェック 
if (
    ($_POST["form_buy_day"]["sy"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["sy"])) ||
    ($_POST["form_buy_day"]["sm"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["sm"])) ||
    ($_POST["form_buy_day"]["sd"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["sd"])) ||
    ($_POST["form_buy_day"]["ey"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["ey"])) ||
    ($_POST["form_buy_day"]["em"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["em"])) ||
    ($_POST["form_buy_day"]["ed"] != null && !ereg("^[0-9]+$", $_POST["form_buy_day"]["ed"]))
){
    $message1 = "<li>仕入日 が妥当ではありません。<br>";
    $buy_day_err_flg = true; 
}
// （開始）妥当性チェック check validity (start)
if (
    $buy_day_err_flg != true && 
    ($_POST["form_buy_day"]["sy"] != null || $_POST["form_buy_day"]["sm"] != null || $_POST["form_buy_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_buy_day"]["sm"], (int)$_POST["form_buy_day"]["sd"], (int)$_POST["form_buy_day"]["sy"])){
        $message1 = "<li>仕入日 が妥当ではありません。<br>";
        $buy_day_err_flg = true; 
    }
}
// （終了）妥当性チェック validty check (end)
if (
    $buy_day_err_flg != true && 
    ($_POST["form_buy_day"]["ey"] != null || $_POST["form_buy_day"]["em"] != null || $_POST["form_buy_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_buy_day"]["em"], (int)$_POST["form_buy_day"]["ed"], (int)$_POST["form_buy_day"]["ey"])){
        $message1 = "<li>仕入日 が妥当ではありません。<br>";
        $buy_day_err_flg = true; 
    }
}

// ■仕入担当者（複数選択） purchase assigned staff (select multiple)
// カンマ区切りの半角数字チェック check the half width number that are comma seprated
if($_POST["form_multi_staff"] != null){
    $ary_multi_staff = explode(",", $_POST["form_multi_staff"]);
    foreach ($ary_multi_staff as $key => $value){
        if (!ereg("^[0-9]+$", trim($value))){
            $message2 = "<li>仕入担当者（複数選択） は数値と「,」のみ入力可能です。<br>";
        }       
    }
}

// ■発注日 purchase order date
// 数値チェック value check
if (
    ($_POST["form_ord_day"]["sy"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["sy"])) ||
    ($_POST["form_ord_day"]["sm"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["sm"])) ||
    ($_POST["form_ord_day"]["sd"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["sd"])) ||
    ($_POST["form_ord_day"]["ey"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["ey"])) ||
    ($_POST["form_ord_day"]["em"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["em"])) ||
    ($_POST["form_ord_day"]["ed"] != null && !ereg("^[0-9]+$", $_POST["form_ord_day"]["ed"]))
){
    $message3 = "<li>発注日 が妥当ではありません。<br>";
    $ord_day_err_flg = true;
}
// （開始）妥当性チェック validity check (start)
if (
    $ord_day_err_flg != true &&
    ($_POST["form_ord_day"]["sy"] != null || $_POST["form_ord_day"]["sm"] != null || $_POST["form_ord_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_ord_day"]["sm"], (int)$_POST["form_ord_day"]["sd"], (int)$_POST["form_ord_day"]["sy"])){
        $message3 = "<li>発注日 が妥当ではありません。<br>";
        $ord_day_err_flg = true;
    }
}
// （終了）妥当性チェック validity check (end)
if (
    $ord_day_err_flg != true &&
    ($_POST["form_ord_day"]["ey"] != null || $_POST["form_ord_day"]["em"] != null || $_POST["form_ord_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_ord_day"]["em"], (int)$_POST["form_ord_day"]["ed"], (int)$_POST["form_ord_day"]["ey"])){
        $message3 = "<li>発注日 が妥当ではありません。<br>";
        $ord_day_err_flg = true;
    }
}

// ■仕入金額（税込）purchase amount (with tax)
// 数値チェック check value
if (
    ($_POST["form_buy_amount"]["s"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_buy_amount"]["s"])) ||
    ($_POST["form_buy_amount"]["e"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_buy_amount"]["e"]))
){
    $message4 = "<li>仕入金額（税込） は数値のみです。<br>";
}



/************************************************/
// エラー時はエラーメッセージを出力して終了　if its an error end with outputting the error message
/************************************************/
if ($message0 != null || $message1 != null || $message2 != null || $message3 != null || $message4 != null){
    print "<font color=\"red\"><b>";
    print $message0.$message1.$message2.$message3.$message4;
    print "</b></font>";
    exit;
}


/************************************************/
// POSTデータを変数にセットset the POST data in variable
/************************************************/
// 日付POSTデータの0埋め fill the date POST data with 0s
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
//帳票の構成入力箇所 input field of the form layout
//*********************************//
//余白 margin
$left_margin = 40;
$top_margin = 40;

//ヘッダーのフォントサイズ font size of header
$font_size = 9;
//ページサイズ page size
$page_size = 1110;

//A3 A3
$pdf=new MBFPDF('L','pt','A3');

//ページ最大表示数 maximum number of pages to be displayed
$page_max = 50;

//*********************************//
//ヘッダ項目入力箇所 header items input field
//*********************************//
//タイトル title
$title = "仕入一覧表";
$page_count = 1; 

if($_POST["form_renew"] == "2"){
    $renew_flg = true;
}elseif($_POST["form_renew"] == "3"){
    $renew_flg = false;
}

//ヘッダに表示する時刻作成 create the time to be displayed in header
$time = "仕入日：";

#2010-02-03 aoyama-n
#if($buy_sday["y"] != null){
#    $time .= $buy_sday["y"]."年".$buy_sday["m"]."月".$buy_sday["d"]."日";
if($buy_day_sy != null){
    $time .= $buy_day_sy."年".$buy_day_sm."月".$buy_day_sd."日";
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

    $time .= $buy_day[0]."年".$buy_day[1]."月".$buy_day[2]."日";
}

$time .= "〜";

#2010-02-03 aoyama-n
#if($buy_eday["y"] != null){
#    $time .= $buy_eday["y"]."年".$buy_eday["m"]."月".$buy_eday["d"]."日";
if($buy_day_ey != null){
    $time .= $buy_day_ey."年".$buy_day_em."月".$buy_day_ed."日";
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

    $time .= $buy_day[0]."年".$buy_day[1]."月".$buy_day[2]."日";
}

//項目名・幅・align item name, width, align
$list[0] = array("30","NO","C");
$list[1] = array("130","仕入先","C");
$list[2] = array("40","伝票番号","C");
$list[3] = array("55","取引区分","C");
$list[4] = array("50","仕入日","C");
$list[5] = array("245","商品名","C");
$list[6] = array("70","仕入数","C");
$list[7] = array("70","仕入単価","C");
$list[8] = array("70","仕入金額","C");
$list[9] = array("100","仕入倉庫","C");
$list[10] = array("40","発注番号","C");
$list[11] = array("210","備考","C");

//*********************************//
//データ項目入力箇所 data item input field
//*********************************//
//仕入先計・総合計（消費税/税込計）total number of purchase clients・total amount (with tax)
$list_sub[0] = array("30","","R");
$list_sub[1] = array("200","仕入先計：","L");
$list_sub[2] = array("200","総合計：","L");
$list_sub[3] = array("70","","R");
$list_sub[4] = array("70","　　消費税：","L");
$list_sub[5] = array("70","","R");
$list_sub[6] = array("70","　　税込計：","L");
$list_sub[7] = array("70","","R");
$list_sub[8] = array("530","","C");

//伝票計（消費税/税込計）total number of slips (with tax)
$list_sub2[0] = array("30","","R");
$list_sub2[1] = array("130","","C");
$list_sub2[2] = array("70","伝票計：","L");
$list_sub2[3] = array("70","","R");
$list_sub2[4] = array("70","　　消費税：","L");
$list_sub2[5] = array("70","","R");
$list_sub2[6] = array("70","　　税込計：","L");
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

//align(データ) align (data)
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
// 一覧データ取得条件作成  create condition to acquire list data
/****************************/

$sql = null;

// 仕入先コード１ purchase client code 1
$sql .= ($client_cd1 != null) ? "AND t_buy_h.client_cd1 LIKE '$client_cd1%' \n" : null;
// 仕入先コード２ purchase client code 2
$sql .= ($client_cd2 != null) ? "AND t_buy_h.client_cd2 LIKE '$client_cd2%' \n" : null;
// 仕入先名 purchase client name 
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
// 仕入担当者コード purchase assigned staff code
$sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
// 仕入担当者セレクト select purchase assigned staff
$sql .= ($c_staff_select != null) ? "AND t_buy_h.c_staff_id = $c_staff_select \n" : null; 
// 倉庫 warehouse
$sql .= ($ware != null) ? "AND t_buy_h.ware_id = $ware \n" : null; 
// 仕入日（開始）purchase date (start)
$buy_day_s = $buy_day_sy."-".$buy_day_sm."-".$buy_day_sd;
$sql .= ($buy_day_s != "--") ? "AND '$buy_day_s' <= t_buy_h.buy_day \n" : null; 
// 仕入日（終了）purchase date (end)
$buy_day_e = $buy_day_ey."-".$buy_day_em."-".$buy_day_ed;
$sql .= ($buy_day_e != "--") ? "AND t_buy_h.buy_day <= '$buy_day_e' \n" : null;
// 仕入担当複数選択 select multiple purchase assigned staff 
if ($multi_staff != null){
    $ary_multi_staff = explode(",", $multi_staff);
    $sql .= "AND \n";
    $sql .= "   t_staff.charge_cd IN (";
    foreach ($ary_multi_staff as $key => $value){
        $sql .= "'".trim($value)."'";
        $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
    }
}
// 伝票番号（開始）slip number (start)
$sql .= ($slip_no_s != null) ? "AND t_buy_h.buy_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."'\n" : null;
// 伝票番号（終了）slip number (end)
$sql .= ($slip_no_e != null) ? "AND t_buy_h.buy_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."'\n" : null;
// 日次更新 daily update
if ($renew == "2"){
    $sql .= "AND t_buy_h.renew_flg = 'f' \n";
}elseif ($renew == "3"){
    $sql .= "AND t_buy_h.renew_flg = 't' \n";
}
// 発注番号（開始）purchase order number (start)
$sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."'\n" : null;
// 発注番号（終了）purchase order number (end)
$sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."'\n" : null;
// 発注日（開始）purchase order date (start)
$ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
$sql .= ($ord_day_s != "--") ? "AND '$ord_day_s 00:00:00' <= t_order_h.ord_time \n" : null;
// 発注日（終了）purchae order date (end)
$ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
$sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
// 仕入金額（税込）（開始）purchase amount (with tax) (start)
if ($buy_amount_s != null){
    $sql .= "AND \n";
    $sql .= "   $buy_amount_s <= \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
    $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) *  1 \n";
    $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
    $sql .= "   END \n";
}
// 仕入金額（税込）（終了）purchase amount (with tax) (end)
if ($buy_amount_e != null){
    $sql .= "AND \n";
    $sql .= "   $buy_amount_e >= \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
    $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) *  1 \n";
    $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
    $sql .= "   END \n";
}
// 取引区分 trade classification
$sql .= ($trade != null) ? "AND t_buy_h.trade_id = '$trade' \n" : null;

// 変数詰め替え refill variable 
$where_sql = $sql;


//***********************
// 出力データ取得SQL入力箇所 input field in SQL that acquires output data 
//***********************
$sql  = "SELECT \n";
$sql .= "   t_buy_h.client_name, \n";
$sql .= "   t_buy_h.buy_no, \n";
$sql .= "   CASE t_buy_h.trade_id \n";
$sql .= "       WHEN '21' THEN '掛仕入' \n";
$sql .= "       WHEN '22' THEN '掛仕入(-)' \n";
$sql .= "       WHEN '23' THEN '掛返品' \n";
$sql .= "       WHEN '24' THEN '掛値引' \n";
$sql .= "       WHEN '25' THEN '割賦仕入' \n";
$sql .= "       WHEN '71' THEN '現金仕入' \n";
$sql .= "       WHEN '72' THEN '現金仕入(-)' \n";
$sql .= "       WHEN '73' THEN '現金返品' \n";
$sql .= "       WHEN '74' THEN '現金値引' \n";
$sql .= "   END, \n";
$sql .= "   t_buy_h.buy_day, \n";
$sql .= "   t_buy_d.goods_name, \n";
$sql .= "   t_buy_d.num, \n";
$sql .= "   CASE t_buy_d.tax_div \n";
$sql .= "       WHEN '1' THEN '外税' \n";
$sql .= "       WHEN '2' THEN '内税' \n";
$sql .= "       WHEN '3' THEN '非課税' \n";
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
//出力処理 output process
//***********************
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("印刷時刻　Y年m月d日　H:i");
//ヘッダー表示 display header
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

$count = 0;                 //行数 row number
$page_next = $page_max;     //次のページ表示数 number of next pages
$page_back = 0;             //前のページ表示数 number of previous pages 
$data_sub = array();        //仕入先計 total of purchase client
$data_sub2 = array();       //伝票計 total of slip
$data_total = array();      //総合計 total number
$person = "";               //仕入先の重複値 overlapped value of puchase client
$slip = "";                 //伝票番号の重複値 overlapped value of slip numbers
$money_tax = 0;             //仕入先計の消費税合計 total vat of all purchase clients
$money = 0;                 //仕入先計の仕入金額合計 total purhcase amount of all puchase clients
$money_tax2 = 0;            //伝票計の消費税合計 total amount of tax of all slips
$money2 = 0;                //伝票計の仕入金額合計 total puchase amount of all slips

for($c=0;$c<$data_num;$c++){
    $count++;

    if (!($data_list[$c][2] == '掛仕入' || $data_list[$c][2] == '現金仕入' || $data_list[$c][2] == '割賦仕入')){
        $data_list[$c][7] = $data_list[$c][7]*(-1);
        $data_list[$c][8] = $data_list[$c][8]*(-1);
        $data_list[$c][13] = $data_list[$c][13]*(-1);
    }
    //***********************
    //改ページ処理 new page process
    //***********************
    //行番号がページ最大表示数になった場合、改ページする if the row number becomes the max number of items that can be displayed in a page, make it a new page
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示 display header
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、仕入先名を表示させる為に、前のページの表示数を代入 if the first row of the new page is the total of slip row, substitute the number of items displayed in the previous to display the purchase client name
        $page_back = $page_next+1;
        //次の最大表示数 the next max items to be displayed
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 8);

    //***********************
    //伝票計処理 slip totalling process
    //***********************
    //値が変わった場合、伝票計表示 if the value changes, display the totalling of slip
    if($slip != $data_list[$c][1]){
        //一行目は、値をセットするだけ just set the value for the first row
        if($count != 1){
            $pdf->SetFillColor(220,220,220);
            //値の省略判定フラグ decision flag for omitting value
            $space_flg2 = true;
            for($x=0;$x<count($list_sub2)-1;$x++){
                //伝票計行番号 totalling slip row number
                if($x==0){
                    $pdf->SetFont(GOTHIC, '', 8);
                    $pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
                    $pdf->SetFont(GOTHIC, 'B', 8);
                //スペースの幅分セル表示 display cells according to how much space there is
                }else if($x==1){
                    //改ページした後の一行目が、伝票計の場合、仕入先名表示 if the first page in the new page is the totalling slip, then display the purchase client name
                    if($page_back == $count){
                        $pdf->SetFont(GOTHIC, '', 8);
                        $pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 8);
                        //仕入先を表示させた場合は、データの仕入先を省略 ommit the purchase client of the data when the purchase client is displayed
                        $slip_flg = true;
					}else if($page_next == $count){
						$pdf->SetFont(GOTHIC, '', 8);
                        $pdf->Cell($list_sub2[$x][0], 14,'', 'LBR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 8);
                    }else{
                        $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
                    }
                //伝票計名 name of the totalling slip
                }else if($x==2){
                    $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TLB', '0',$list_sub2[$x][2],'1');
                //伝票計値 value of the totalling slip
                }else if($x==3){
                    $money2 = $data_sub2[9];
                    $data_sub2[9] = number_format($data_sub2[9]);
                    $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[9], 'TB', '0',$list_sub2[$x][2],'1');
                //消費税名or税込計名 tax name or with tax total name
                }else if($x==4 || $x==6){
                    $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
                //消費税値 value of tax
                }else if($x==5){
                    $money_tax2 = $tax_sub2[14];
                    #2010-02-03 aoyama-n
                    $tax_sub[14] = bcadd($tax_sub[14],$tax_sub2[14]);

                    $tax_sub2[14] = number_format($tax_sub2[14]);
                    $pdf->Cell($list_sub2[$x][0], 14, $tax_sub2[14], 'TB', '0',$list_sub2[$x][2],'1');
                //税込計値 total of amount with tax
                }else if($x==7){
                    $money_sum = bcadd($money_tax2,$money2);
                    $money_sum = number_format($money_sum);
                    $pdf->Cell($list_sub2[$x][0], 14, $money_sum, 'TB', '0',$list_sub2[$x][2],'1');
                }
            }
            //スペースの幅分セル表示 display cell just as many spaces ther are
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
    //改ページ処理 nwe page process
    //***********************
    //行番号がページ最大表示数になった場合、改ページする if the row number becomes the max number of items that can be displayed in a page, make it a new page
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示 display header
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、仕入先名を表示させる為に、前のページの表示数を代入 if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
        $page_back = $page_next+1;
        //次の最大表示数 the next max items to be displayed
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 8);

    //***********************
    //仕入先計処理 purchase client (PC) totalling process
    //***********************
    //値が変わった場合、仕入先計表示 if the value changes, display the total of purchase client 
    if($person != $data_list[$c][12]){
        //一行目は、値をセットするだけ just set the value for the first row
        if($count != 1){
            $pdf->SetFillColor(180,180,180);
            //値の省略判定フラグ decision flag for omitting value
            $space_flg = true;
            $slip_flg = false;
            for($x=0;$x<count($list_sub)-1;$x++){
                //仕入先計行番号 total purchase cleint row number
                if($x==0){
                    $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
                //仕入先計名 name of the total PC
                }else if($x==1){
                    $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBL', '0',$list_sub[$x][2],'1');
                //仕入先計値 value of total PC
                }else if($x==3){
                    //仕入先計を合計値に足していく add the total PC in the total value
                    $data_total[2] = bcadd($data_total[2],$data_sub[9]);
                    $money = $data_sub[9];
                    $data_sub[9] = number_format($data_sub[9]);
                    $pdf->Cell($list_sub[$x][0], 14, $data_sub[9], 'TB', '0',$list_sub[$x][2],'1');
                //消費税名or税込計名 tax name or with tax total name
                }else if($x==4 || $x==6){
                    $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
                //消費税値 value of tax
                }else if($x==5){
                    //消費税値を合計値に足していく add the tax value to the total value
                    $tax_total[4] = bcadd($tax_total[4],$tax_sub[14]);
                    $money_tax = $tax_sub[14];
                    $tax_sub[14] = number_format($tax_sub[14]);
                    $pdf->Cell($list_sub[$x][0], 14, $money_tax, 'TB', '0',$list_sub[$x][2],'1');
                //税込計値 total of amount with tax
                }else if($x==7){
                    $money_sum = bcadd($money_tax,$money);
                    $money_sum = number_format($money_sum);
                    $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
                }
            }
            //スペースの幅分セル表示 display cell just as many spaces ther are
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
    //改ページ処理 nwe page process
    //***********************
    //行番号がページ最大表示数になった場合、改ページする if the row number becomes the max number of items that can be displayed in a page, make it a new page
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示 display header 
        Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、仕入先名を表示させる為に、前のページの表示数を代入 if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
        $page_back = $page_next+1;
        //次の最大表示数 the next max items to be displayed
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, '', 8);

    //***********************
    //データ表示処理 data display process
    //***********************
    //行番号 row number
    $pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
    //最初は行番号を表示する為、ポインタは一から始める start from the pointer because row number will be displayed first
    for($x=1;$x<count($data_list[$c])+1;$x++){
        //表示値 display value
        $contents = "";
        //表示line display line
        $line = "";

        //仕入先名の省略判定 purchase client name decide on ommision
        //伝票計に仕入先を表示させていない。かつ、一行目か小計の後の場合は、省略しない。do not ommit when when the purchase client is not displayed and when it is after the first row or the sub total
        if($x==1 && $slip_flg == false && ($count == 1 || $space_flg == true)){
            //セル結合判定 decide if cell will be combined
            //ページの最大表示数か if it is the max display number of the page
            $contents = $data_list[$c][$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LR';
            }
            //伝票計に表示させる仕入先名を代入substitute the purchase cleint name that will be displayed in the slip total
            $customer = $data_list[$c][$x-1];
            //仕入先名を省略する ommit the purchase client name
            $space_flg = false;
            $slip_flg = false;
        //伝票計に仕入先を表示、または、既に仕入先を表示させたか was the purchase client displayed in the total of slip or was the purchase client displayed already
        }else if($x==1){
            //ページの最大表示数か is it the max number of items to be displayed in the page
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
            $customer = $data_list[$c][$x-1];
        //一行目か伝票計の後以外は値の省略 ommit the value if it is the first row or if it is after the total of slip
        }else if($x==2 && ($count == 1 || $space_flg2 == true)){
            //セル結合判定 decide if cells will be combined
            //ページの最大表示数か is it the max numbers of item to be displayed
            $contents = $data_list[$c][$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LRT';
            }
            //省略する ommit
            $space_flg2 = false;
        //既に伝票番号を表示している。 slip number is being dispayed already
        }else if($x==2){
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
        //仕入金額計算 compute the purchase amount
        }else if($x==9){
            //値を伝票計に足していく add the value to the slip total
            $data_sub2[$x] = bcadd($data_sub2[$x],$data_list[$c][$x-1]);
            //値を仕入先計に足していく add the value to the total of purchase client
            $data_sub[$x] = bcadd($data_sub[$x],$data_list[$c][$x-1]);
            $data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
            $contents = $data_list[$c][$x-1];
            $line = '1';
        //消費税計算 compute for tax
        }else if($x==14){
            //値を伝票計に足していく add the value to total of slip
            $tax_sub2[$x] = $data_list[$c][$x-1];
            //値を仕入先計に足していく add the value to total purchas client
            #2010-02-03 aoyama-n
            #$tax_sub[$x] = bcadd($tax_sub[$x],$data_list[$c][$x-1]);
            $data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
        }else{
            //金額・数量なら数値形式に変更 if it's amount or quantity then change it to the value format
            if(is_numeric($data_list[$c][$x-1]) && ($x==6 || $x == 8)){
				if($x == 8){
					//単価 price per product
					$data_list[$c][$x-1] = number_format($data_list[$c][$x-1],2);
				}else{
					//数量 quantity
					$data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
				}
            }
            $contents = $data_list[$c][$x-1];
            $line = '1';
        }
        //仕入先IDと消費税以外表示 display other than purchase client ID and tax
        if($x != 7 && $x != 13 && $x != 14){
            //備考を表示した後は、改行 new line if remarks were displayed
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
//改ページ処理 new page process
//***********************
//行番号がページ最大表示数になった場合、改ページする if the row number becomes the max number of items that can be displayed in a page, make it a new page
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //ヘッダー表示 display header
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //改ページした最初の行が伝票計の場合、仕入先名表示させる為に、前のページの表示数を代入 if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
    $page_back = $page_next+1;
    //次の最大表示数 the next max items to be displayed
    $page_next = $page_max * $page_count;
    $space_flg = true;
    $space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//最終伝票計処理 final slip totalling process
//***********************   
for($x=0;$x<count($list_sub2)-1;$x++){
    //伝票計行番号 row number of the total of slip
    if($x==0){
        $pdf->SetFont(GOTHIC, '', 8);
        $pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
        $pdf->SetFont(GOTHIC, 'B', 8);
    //スペースの幅分セル表示 display cells according to how much space there is
    }else if($x==1){
        //改ページした後の一行目が、伝票計の場合、仕入先名表示 if the first page in the new page is the total of slip, then display the purchase client name
        if($page_back == $count){
            $pdf->SetFont(GOTHIC, '', 8);
            $pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
            $pdf->SetFont(GOTHIC, 'B', 8);
            //仕入先を表示させた場合は、データの仕入先を省略 if the purchase client has been displayed, ommit the data of the purchase client
            $slip_flg = true;
		}else if($page_next == $count){
			$pdf->SetFont(GOTHIC, '', 8);
            $pdf->Cell($list_sub2[$x][0], 14,'', 'LBR', '0','L','');
            $pdf->SetFont(GOTHIC, 'B', 8);
        }else{
            $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
            $slip_flg = false;
        }
    //伝票計名 total of slip name
    }else if($x==2){
        $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TLB', '0',$list_sub2[$x][2],'1');
    //伝票計値 value of the total of slip
    }else if($x==3){
        $money2 = $data_sub2[9];
        $data_sub2[9] = number_format($data_sub2[9]);
        $pdf->Cell($list_sub2[$x][0], 14, $data_sub2[9], 'TB', '0',$list_sub2[$x][2],'1');
    //消費税名or税込計名 tax name or with tax total name
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
    //消費税値 value of tax
    }else if($x==5){
        $money_tax2 = $tax_sub2[14];
        #2010-02-03 aoyama-n
        $tax_sub[14] = bcadd($tax_sub[14],$tax_sub2[14]);

        $tax_sub2[14] = number_format($tax_sub2[14]);
        $pdf->Cell($list_sub2[$x][0], 14, $tax_sub2[14], 'TB', '0',$list_sub2[$x][2],'1');
    //税込計値 total of amount with tax
    }else if($x==7){
        $money_sum = bcadd($money_tax2,$money2);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub2[$x][0], 14, $money_sum, 'TB', '0',$list_sub2[$x][2],'1');
    }
}
//スペースの幅分セル表示 display cells according to how much space there is
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
//改ページ処理 new page process
//***********************   
//行番号がページ最大表示数になった場合、改ページする if the row number becomes the max number of items that can be displayed in a page, make it a new page
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //ヘッダー表示 display header
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //改ページした最初の行が伝票計の場合、仕入先名表示させる為に、前のページの表示数を代入 if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
    $page_back = $page_next+1;
    //次の最大表示数
    $page_next = $page_max * $page_count;
    $space_flg = true;
    $space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//最終仕入先計処理 final total of purchase client process
//***********************   
for($x=0;$x<count($list_sub)-1;$x++){
    //仕入先計行番号 row number of the total of purchase client
    if($x==0){
        $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
    //仕入先計名 name of the purchase client
    }else if($x==1){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBL', '0',$list_sub[$x][2],'1');
    //仕入先計値 value of the total of purchase client
    }else if($x==3){
        //仕入先計を合計値に足していく add the total of purchase client to the total value
        $data_total[2] = bcadd($data_total[2],$data_sub[9]);
        $money = $data_sub[9];
        $data_sub[9] = number_format($data_sub[9]);
        $pdf->Cell($list_sub[$x][0], 14, $data_sub[9], 'TB', '0',$list_sub[$x][2],'1');
    //消費税名or税込計名 tax name or with tax total name
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
    //消費税値 v
    }else if($x==5){
        //消費税値を合計値に足していく add the tax value to the total value
        $tax_total[4] = bcadd($tax_total[4],$tax_sub[14]);
        $money_tax = $tax_sub[14];
        $tax_sub[14] = number_format($tax_sub[14]);
        #2010-02-03 aoyama-n
        #$pdf->Cell($list_sub[$x][0], 14, $money_tax, 'TB', '0',$list_sub[$x][2],'1');
        $pdf->Cell($list_sub[$x][0], 14, $tax_sub[14], 'TB', '0',$list_sub[$x][2],'1');
    //税込計値 total of amount with tax
    }else if($x==7){
        $money_sum = bcadd($money_tax,$money);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
    }
}
//スペースの幅分セル表示 display cell just as many spaces ther are
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
//改ページ処理 new page process
//***********************   
//行番号がページ最大表示数になった場合、改ページする if the row number becomes the max number of items that can be displayed in a page, make it a new page
if($page_next+1 == $count){
    $pdf->AddPage();
    $page_count++;
    //ヘッダー表示 v
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //改ページした最初の行が伝票計の場合、仕入先名表示させる為に、前のページの表示数を代入 if the first row of the new page is the total of slip number row, substitute the number of items displayed in the previous to display the purchase client name
    $page_back = $page_next+1;
    //次の最大表示数 the next max items to be displayed
    $page_next = $page_max * $page_count;
    $space_flg = true;
    $space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//総合計処理 total total computation process
//***********************   
for($x=0;$x<count($list_sub)-1;$x++){
    //合計行番号 "total" row number
    if($x==0){
        $pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
    //総合計名name of the total row
    }else if($x==2){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'LTB', '0',$list_sub[$x][2],'1');
    //総合計値 value of total computed
    }else if($x==3){
        $money = $data_total[2];
        $data_total[2] = number_format($data_total[2]);
        $pdf->Cell($list_sub[$x][0], 14, $data_total[2], 'TB', '0',$list_sub[$x][2],'1');
    //消費税名or税込計名 tax name or with tax total name
    }else if($x==4 || $x==6){
        $pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
    //消費税値 value of tax
    }else if($x==5){
        $money_tax = $tax_total[4];
        $tax_total[4] = number_format($tax_total[4]);
        $pdf->Cell($list_sub[$x][0], 14, $tax_total[4], 'TB', '0',$list_sub[$x][2],'1');
    //税込計値 total of amount with tax
    }else if($x==7){
        $money_sum = bcadd($money_tax,$money);
        $money_sum = number_format($money_sum);
        $pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
    }
}

//スペースの幅分セル表示 display cell just as many spaces ther are
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBR', '2',$list_sub[$x][2],'1');

//出力 output
$pdf->Output();

?>
