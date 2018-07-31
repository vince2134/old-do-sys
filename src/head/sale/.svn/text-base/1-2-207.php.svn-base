<?php
/**
 * 売上明細一覧表
 *
 *
 * 変更履歴
 *   2006/09/16 (kaji)
 *     ・301行目、「UNION ALL」のあとにスペース入れた
 *     ・306行目、$sqlのあとに.を入れた
 *   2006/11/06      08-114      suzuki      正しい検索条件に修正
 *   2006/11/06      08-056      suzuki      表示順を得意先にして帳票出力できるように修正
 *   2006/11/09      08-134      suzuki      税込金額検索結果が帳票出力に反映されていない
 *   2006/11/09      08-136      suzuki      商品コード・商品名検索結果が帳票出力に反映されていない
 *   2006/12/09      ban_0118    suzuki      販売区分非表示
 *   2006/12/09      ban_0119    suzuki      取引区分によって金額をマイナスにするように修正
 *   2007/03/01                  morita-d    商品名は正式名称を表示するように変更 
 *   2007/09/11                  watanabe-k  伝票番号でソートするように修正
 *   2007/09/11                  watanabe-k  返品の場合は数量にマイナスをつけるように修正
 */

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");
require(FPDF_DIR);

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);


/*****************************/
// 不正遷移チェック
/*****************************/
if ($_POST == null){
    header("Location: ../top.php");
}


/************************************************/
// 外部変数入力箇所
/************************************************/
// SESSION
$shop_id = $_SESSION["client_id"];


/************************************************/
// エラーチェック
/************************************************/
// ■売上担当者
if ($_POST["form_sale_staff"]["cd"] != null && !ereg("^[0-9]+$", $_POST["form_sale_staff"]["cd"])){
    $message0 = "<li>売上担当者 は数値のみ入力可能です。<br>";
}

// ■売上担当複数選択
// カンマ区切りの半角数字チェック
if($_POST["form_multi_staff"] != null){
    $ary_multi_staff = explode(",", $_POST["form_multi_staff"]);
    foreach ($ary_multi_staff as $key => $value){
        if (!ereg("^[0-9]+$", trim($value))){
            $message1 = "<li>売上担当複数選択 は数値と「,」のみ入力可能です。<br>";
        }       
    }
}

// ■売上計上日
// 数値チェック
if (
    ($_POST["form_sale_day"]["sy"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["sy"])) ||
    ($_POST["form_sale_day"]["sm"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["sm"])) ||
    ($_POST["form_sale_day"]["sd"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["sd"])) ||
    ($_POST["form_sale_day"]["ey"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["ey"])) ||
    ($_POST["form_sale_day"]["em"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["em"])) ||
    ($_POST["form_sale_day"]["ed"] != null && !ereg("^[0-9]+$", $_POST["form_sale_day"]["ed"]))
){
    $message2 = "<li>売上計上日 が妥当ではありません。<br>";
    $sale_day_err_flg = true;
}
// （開始）妥当性チェック
if (
    $sale_day_err_flg != true &&
    ($_POST["form_sale_day"]["sy"] != null || $_POST["form_sale_day"]["sm"] != null || $_POST["form_sale_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_sale_day"]["sm"], (int)$_POST["form_sale_day"]["sd"], (int)$_POST["form_sale_day"]["sy"])){
        $message2 = "<li>売上計上日 が妥当ではありません。<br>";
        $sale_day_err_flg = true;
    }
}
// （終了）妥当性チェック
if (
    $sale_day_err_flg != true &&
    ($_POST["form_sale_day"]["ey"] != null || $_POST["form_sale_day"]["em"] != null || $_POST["form_sale_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_sale_day"]["em"], (int)$_POST["form_sale_day"]["ed"], (int)$_POST["form_sale_day"]["ey"])){
        $message2 = "<li>売上計上日 が妥当ではありません。<br>";
        $sale_day_err_flg = true; 
    }
}

// ■請求日
// 数値チェック
if (
    ($_POST["form_claim_day"]["sy"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["sy"])) ||
    ($_POST["form_claim_day"]["sm"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["sm"])) ||
    ($_POST["form_claim_day"]["sd"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["sd"])) ||
    ($_POST["form_claim_day"]["ey"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["ey"])) ||
    ($_POST["form_claim_day"]["em"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["em"])) ||
    ($_POST["form_claim_day"]["ed"] != null && !ereg("^[0-9]+$", $_POST["form_claim_day"]["ed"]))
){
    $message3 = "<li>請求日 が妥当ではありません。<br>";
    $claim_day_err_flg = true;
}
// （開始）妥当性チェック
if (
    $claim_day_err_flg != true &&
    ($_POST["form_claim_day"]["sy"] != null || $_POST["form_claim_day"]["sm"] != null || $_POST["form_claim_day"]["sd"] != null)
){
    if (!checkdate((int)$_POST["form_claim_day"]["sm"], (int)$_POST["form_claim_day"]["sd"], (int)$_POST["form_claim_day"]["sy"])){
        $message3 = "<li>請求日 が妥当ではありません。<br>";
        $claim_day_err_flg = true;
    }
}
// （終了）妥当性チェック
if (
    $claim_day_err_flg != true &&
    ($_POST["form_claim_day"]["ey"] != null || $_POST["form_claim_day"]["em"] != null || $_POST["form_claim_day"]["ed"] != null)
){
    if (!checkdate((int)$_POST["form_claim_day"]["em"], (int)$_POST["form_claim_day"]["ed"], (int)$_POST["form_claim_day"]["ey"])){
        $message3 = "<li>請求日 が妥当ではありません。<br>";
        $claim_day_err_flg = true; 
    }
}

// ■税込金額
// 数値チェック
if (
    ($_POST["form_sale_amount"]["s"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_sale_amount"]["s"])) ||
    ($_POST["form_sale_amount"]["e"] != null && !ereg("^[-]?[0-9]+$", $_POST["form_sale_amount"]["e"]))
){
    $message4 = "<li>税込金額 は数値のみです。<br>";
}


/************************************************/
// エラー時はエラーメッセージを出力して終了
/************************************************/
if ($message0 != null || $message1 != null || $message2 != null || $message3 != null || $message4 != null){
    print "<font color=\"red\"><b>";
    print $message0.$message1.$message2.$message3.$message4;
    print "</b></font>";
    exit;
}


/************************************************/
// POSTデータを変数にセット
/************************************************/
// 日付POSTデータの0埋め
$_POST["form_sale_day"]  = Str_Pad_Date($_POST["form_sale_day"]);
$_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

// フォームの値を変数にセット
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
//ヘッダー作成関数
/*****************************/
function Header_disp2($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$list,$font_size,$page_size){

    $pdf->SetFont(GOTHIC, '', $font_size);
    $pdf->SetXY($left_margin,$top_margin);
    $pdf->Cell($page_size, 14, $title, '0', '1', 'C');
    $pdf->SetXY($left_margin,$top_margin);
    $pdf->Cell($page_size, 14, $page_count."ページ", '0', '2', 'R');
    $pdf->SetX($left_margin);
    $pdf->Cell($page_size, 14, $left_top, '0', '1', 'L');
    $pdf->SetXY($left_margin,$top_margin+14);
    $pdf->Cell($page_size, 14, $right_top, '0', '1', 'R');
    $pdf->SetXY($left_margin,$top_margin+28);
    $pdf->Cell($page_size, 14, $right_bottom, '0', '1', 'R');
    $pdf->SetXY($left_margin,$top_margin+28);
    $pdf->Cell($page_size, 14, $left_bottom, '0', '2', 'L');

    //項目表示
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    for($i=0;$i<count($list)-1;$i++)
    {
        //販売区分以外表示
        if($i != 5){
            $pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
        }
    }
    $pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

}


/*****************************/
// 外部変数取得
/*****************************/
//余白
$left_margin = 40;
$top_margin = 40;

//ヘッダーのフォントサイズ
$font_size = 9;
//ページサイズ
$page_size = 1110;

//A3
$pdf=new MBFPDF('L','pt','A3');

//タイトル
$title = "売上明細一覧表";
$page_count = 1; 


/*****************************/
// 抽出条件作成
/*****************************/
// 売上計上日をまとめて変数へ
$sale_day_s = $sale_day_sy."-".$sale_day_sm."-".$sale_day_sd;
$sale_day_e = $sale_day_ey."-".$sale_day_em."-".$sale_day_ed;

// 売上計上日を出力用に
$sale_date_s = $sale_day_sy."年".$sale_day_sm."月".$sale_day_sd."日";
$sale_date_e = $sale_day_ey."年".$sale_day_em."月".$sale_day_ed."日";

if ($sale_day_sy == null && $sale_day_sm == null && $sale_day_sd == null &&
    $sale_day_ey == null && $sale_day_em == null && $sale_day_ed == null){
    $time = "売上計上日：指定なし";
}else
if ($sale_day_sy != null && $sale_day_sm != null && $sale_day_sd != null &&
    $sale_day_ey == null && $sale_day_em == null && $sale_day_ed == null){
    $time = "売上計上日：".$sale_date_s."〜";
}else
if ($sale_day_sy == null && $sale_day_sm == null && $sale_day_sd == null &&
    $sale_day_ey != null && $sale_day_em != null && $sale_day_ed != null){
    $time = "売上計上日：〜".$sale_date_e;
}else{
    $time = "売上計上日：".$sale_date_s."〜".$sale_date_e;
}


/*****************************/
// 抽出条件作成
/*****************************/
/* WHERE */

$sql = null;

// FC・取引先コード1
$sql .= ($client_cd1 != null) ? "AND t_sale_h.client_cd1 LIKE '$client_cd1%' " : null;
// FC・取引先コード2
$sql .= ($client_cd2 != null) ? "AND t_sale_h.client_cd2 LIKE '$client_cd2%' " : null;
// FC・取引先名
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
// 売上担当者コード
$sql .= ($sale_staff_cd != null) ? "AND t_staff.charge_cd = '$sale_staff_cd' \n" : null;
// 売上担当者セレクト
$sql .= ($sale_staff_select != null) ? "AND t_staff.staff_id = $sale_staff_select \n" : null;
// 倉庫
$sql .= ($ware != null) ? "AND t_sale_h.ware_id = $ware \n" : null;
// 請求先コード１   
$sql .= ($claim_cd1 != null) ? "AND t_client_claim.client_cd1 LIKE '$claim_cd1%' \n" : null;
// 請求先コード２
$sql .= ($claim_cd2 != null) ? "AND t_client_claim.client_cd2 LIKE '$claim_cd2%' \n" : null;
// 請求先名
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
// 売上担当複数選択
if ($multi_staff != null){
    $ary_multi_staff = explode(",", $multi_staff);
    $sql .= "AND \n";
    $sql .= "   t_staff.charge_cd IN (";
    foreach ($ary_multi_staff as $key => $value){
        $sql .= "'".trim($value)."'";
        $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
    }
}
// 売上計上日（開始）
$sale_day_s  = $sale_day_sy."-".$sale_day_sm."-".$sale_day_sd;
$sql .= ($sale_day_s != "--") ? "AND '$sale_day_s' <= t_sale_h.sale_day \n" : null;
// 売上計上日（終了）
$sale_day_e  = $sale_day_ey."-".$sale_day_em."-".$sale_day_ed;
$sql .= ($sale_day_e != "--") ? "AND t_sale_h.sale_day <= '$sale_day_e' \n" : null;
// 請求日（開始）
$claim_day_s  = $claim_day_sy."-".$claim_day_sm."-".$claim_day_sd;
$sql .= ($claim_day_s != "--") ? "AND t_sale_h.claim_day >= '$claim_day_s' \n" : null;
// 請求日（終了）
$claim_day_e  = $claim_day_ey."-".$claim_day_em."-".$claim_day_ed;
$sql .= ($claim_day_e != "--") ? "AND t_sale_h.claim_day <= '$claim_day_e' \n" : null;
// 日次更新
if ($renew == "2"){
    $sql .= "AND t_sale_h.renew_flg = 'f' \n";
}else
if ($renew == "3"){
    $sql .= "AND t_sale_h.renew_flg = 't' \n";
}
// 伝票番号（開始）
$sql .= ($slip_no_s != null) ? "AND t_sale_h.sale_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
// 伝票番号（終了）
$sql .= ($slip_no_e != null) ? "AND t_sale_h.sale_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
// 受注番号（開始）
$sql .= ($aord_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($aord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
// 受注番号（終了）
$sql .= ($aord_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($aord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
// 商品コード
$sql .= ($goods_cd != null) ? "AND t_sale_d.goods_cd LIKE '$goods_cd%' " : null;
// 商品名
$sql .= ($goods_name != null) ? "AND t_sale_d.official_goods_name LIKE '%$goods_name%' \n" : null;
// Ｍ区分
$sql .= ($g_goods != null) ? "AND t_g_goods.g_goods_id = $g_goods \n" : null;
// 管理区分
$sql .= ($product != null) ? "AND t_product.product_id = $product \n" : null;
// 商品分類
$sql .= ($g_product != null) ? "AND t_g_product.g_product_id = $g_product \n" : null;
// 伝票発行
if ($slip_type == "2"){
    $sql .= "AND t_sale_h.slip_out = '1' \n";
}else
if ($slip_type == "3"){
    $sql .= "AND t_sale_h.slip_out = '2' \n";
}else
if ($slip_type == "4"){
    $sql .= "AND t_sale_h.slip_out = '3' \n";
}
// 発行状況
if ($slip_out == "2"){
    $sql .= "AND t_sale_h.slip_flg = 'f' \n";
}else
if ($slip_out == "3"){
    $sql .= "AND t_sale_h.slip_flg = 't' \n";
}
// 取引区分
$sql .= ($trade != null) ? "AND t_sale_h.trade_id = $trade \n" : null;

// 変数詰め替え
$where_sql = $sql;


/* HAVING */

$sql = null;

// 税込金額（開始）
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
// 税込金額（終了）
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

// 変数詰め替え
$having_sql = $sql; 


/* ORDER BY */

$sql = null;


/*
// 売上計上日
if($sort == "1"){
    $sql .= "ORDER BY \n";
    $sql .= "   3 DESC, \n";
    $sql .= "   2 DESC \n";
// 得意先
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


// 変数詰め替え
$order_by_sql = $sql; 


/****************************/
// 一覧抽出
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

//件数取得SQL
$count_sql = $sql.";";

// 表示順
//LIMITSQL
$limit_sql = " LIMIT 100 OFFSET $offset";
if($output_type == '1'){
    $sql .= $limit_sql;
}

$sql .= ";";
//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("160","得意先名","C");
$list[2] = array("50","伝票番号","C");
$list[3] = array("90","売上日","C");
$list[4] = array("340","商品名","C");
$list[5] = array("60","販売区分","C");
$list[6] = array("60","売上数","C");
$list[7] = array("90","売上単価","C");
$list[8] = array("90","売上金額","C");
$list[9] = array("200","備考","C");

//得意先計・総合計（消費税/税込計）
$list_sub[0] = array("160","得意先計","L");
$list_sub[1] = array("160","総合計","L");
$list_sub[2] = array("60","消費税：","L");
$list_sub[3] = array("60","税込計：","L");
//伝票計（消費税/税込計）
$list_sub[4] = array("50","伝票計","L");
$list_sub[5] = array("280","消費税：","L");
$list_sub[6] = array("60","税込計：","L");

//align(データ)
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


//ページ最大表示数
$page_max = 50;

//***********************************************
//DB接続
$db_con = Db_Connect();
$result = Db_Query($db_con,$sql);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("印刷時刻　Y年m月d日　H:i");

//ヘッダー表示
Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

//ＤＢの値を表示
//行数・次のページ表示数・前のページ表示数・伝票計・得意先計・合計・比較値・消費税・税込金額、初期化
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

//データが存在する間ループする
while($data_list = @pg_fetch_array($result)){
    $count++;
//*******************改ページ処理*****************************

    //行番号がページ最大表示数になった場合、改ページする
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、得意先名を表示させる為に、前のページの表示数を代入
        $page_back = $page_next+1;
        //次の最大表示数
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);

//******************伝票計処理***********************************

    //値が変わった場合、伝票計表示
    if($slip != $data_list[1]){
        //一行目は、値をセットするだけ
        if($count != 1){
            $pdf->SetFillColor(220,220,220);
            //値の省略判定フラグ
            $space_flg2 = true;
            for($x=0;$x<9;$x++){
                //伝票計行番号
                if($x==0){
                    $pdf->SetFont(GOTHIC, '', 9);
                    $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
                    $pdf->SetFont(GOTHIC, 'B', 9);
                //得意先名
                }else if($x==1){
                    //改ページした後の一行目が、伝票計の場合、得意先名表示
                    if($page_back == $count){
                        $pdf->SetFont(GOTHIC, '', 9);
                        $pdf->Cell($list[$x][0], 14, $customer, 'LR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 9);
                        //得意先を表示させた場合は、データの得意先を省略
                        $slip_flg = true;
                    }else if($page_next == $count){
                        $pdf->SetFont(GOTHIC, '', 9);
                        $pdf->Cell($list[$x][0], 14, '', 'LBR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 9);
                    }else{
                        $pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
                        $slip_flg = false;
                    }
                //伝票計名
                }else if($x==2){
                    $pdf->Cell(50, 14, $list_sub[4][1]."：", 'TBL', '0',$list_sub[0][2],'1');
                //伝票計値
                }else if($x==3){
                    //形式変更
                    $data_sub2[8] = number_format($data_sub2[8]);
                    //税込金額を足す(得意先計用)
                    $client_money = $client_money + ($data_sub2[10] + $data_sub2[11]);
                    //税込金額
                    $data_sub2[10] = number_format($data_sub2[10] + $data_sub2[11]);

                    //消費税額を足す(得意先計用)
                    $client_tax = $client_tax + $data_sub2[11];
                    //消費税額
                    $data_sub2[11] = number_format($data_sub2[11]);

                    $pdf->Cell(90, 14, $data_sub2[8], 'TB', '0','R','1');
                //消費税名
                }else if($x==4){
                    $pdf->Cell(50, 14, $list_sub[5][1], 'TB', '0','R','1');
                //消費税値
                }else if($x==5){
                    $pdf->Cell(90, 14, $data_sub2[11], 'TB', '0','R','1');
                //税込計名
                }else if($x==6){
                    $pdf->Cell(50, 14, $list_sub[6][1], 'TB', '0','R','1');
                //税込計値
                }else if($x==7){
                    $pdf->Cell(90, 14, $data_sub2[10], 'TB', '0','R','1');
                //２列の値を表示
                }else if($x==8){
                    $pdf->Cell(300, 14, $data_sub2[2], 'TB', '0','R','1');
                }else{
                    $pdf->Cell(300, 14, $data_sub2[$x], 'TB', '0','R','1');
                }
            }
            $pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'TBR', '2','R','1');
            //伝票計・消費税・税込計、初期化
            $data_sub2 = array();
            $count++;
        }
        for($x=10;$x<12;$x++){
            //税込金額計算
            if($x==10){
                //値を伝票計に足していく
                $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            //消費税額計算
            }else if($x==11){
                //値を伝票計に足していく
                $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            }
        }
        $slip = $data_list[1];
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);

    //*******************改ページ処理*****************************

    //行番号がページ最大表示数になった場合、改ページする
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、得意先名を表示させる為に、前のページの表示数を代入
        $page_back = $page_next+1;
        //次の最大表示数
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);

//******************得意先計処理***********************************

    //値が変わった場合、得意先計表示
    if($person != $data_list[0]){
        //一行目は、値をセットするだけ
        if($count != 1){
            $pdf->SetFillColor(180,180,180);
            //値の省略判定フラグ
            $space_flg = true;
            for($x=0;$x<9;$x++){
                //小計行番号
                if($x==0){
                    $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
                }else if($x==1){
                    $pdf->Cell($list_sub[0][0], 14, $list_sub[0][1]."：", 'TBL', '0',$list_sub[0][2],'1');
                //得意先計名
                }else if($x==2){
                    $pdf->Cell(50, 14, "", 'TB', '0',$list_sub[0][2],'1');
                //得意先計値
                }else if($x==3){
                    //小計値を合計値に足していく
                    $data_total[2] = $data_total[2] + $data_sub[8];
                    //消費税
                    $money_tax = $money_tax + $client_tax;
                    $data_total[3] = $data_total[3] + $money_tax;
                    //税込金額
                    $money = $money + $client_money;
                    //税込金額を足す(総合計用)
                    $data_total[4] = $data_total[4] + $money;
                    //消費税額
                    $money_tax = number_format($money_tax);
                    //消費税額を足す(総合計用)
                    $money = number_format($money);
                    $data_sub[8] = number_format($data_sub[8]);
                    
                    $pdf->Cell(90, 14, $data_sub[8], 'TB', '0','R','1');
                //消費税名
                }else if($x==4){
                    $pdf->Cell(50, 14, $list_sub[2][1], 'TB', '0','R','1');
                //消費税値
                }else if($x==5){
                    $pdf->Cell(90, 14, $money_tax, 'TB', '0','R','1');
                //税込計名
                }else if($x==6){
                    $pdf->Cell(50, 14, $list_sub[3][1], 'TB', '0','R','1');
                //税込計値
                }else if($x==7){
                    $pdf->Cell(90, 14, $money, 'TB', '0','R','1');
                //２列の値を表示
                }else if($x==8){
                    $pdf->Cell(300, 14, $data_sub[2], 'TB', '0','R','1');
                }else{
                    $pdf->Cell(300, 14, $data_sub[$x], 'TB', '0','R','1');
                }
            }
            $pdf->Cell($list[$x][0], 14, $data_sub[$x], 'TBR', '2','R','1');
            //得意先計・消費税・税込計、初期化
            $data_sub = array();
            $money_tax = 0;
            $money = 0;
            $count++;
        }
        $person = $data_list[0];
        for($x=10;$x<12;$x++){
            //税込金額計算
            if($x==10){
                //値を得意先計に足していく
                $data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
            //消費税額計算
            }else if($x==11){
                //値を得意先計に足していく
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

    //*******************改ページ処理*****************************

    //行番号がページ最大表示数になった場合、改ページする
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、得意先名を表示させる為に、前のページの表示数を代入
        $page_back = $page_next+1;
        //次の最大表示数
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, '', 9);

//************************データ表示***************************
    //行番号
    $pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
    for($x=1;$x<9;$x++){
        //表示値
        $contents = "";
        //表示line
        $line = "";

        //得意先名の省略判定
        //伝票計に得意先を表示させていない。かつ、一行目か小計の後の場合は、省略しない。
        if($x==1 && $slip_flg == false && ($count == 1 || $space_flg == true)){
            //セル結合判定
            //ページの最大表示数か
            $contents = $data_list[$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LR';
            }
            //伝票計に表示させる得意先名を代入
            $customer = $data_list[$x-1];
            //得意先名を省略する
            $space_flg = false;
        //伝票計に得意先を表示、または、既に得意先を表示させたか
        }else if($x==1){
            //ページの最大表示数か
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
            $customer = $data_list[$x-1];
        //一行目か伝票計の後以外は値の省略
        }else if($x==2 && ($count == 1 || $space_flg2 == true)){
            //セル結合判定
            //ページの最大表示数か
            $contents = $data_list[$x-1];
            if($page_next == $count){
                $line = 'LRBT';
            }else{
                $line = 'LRT';
            }
            //省略する
            $space_flg2 = false;
        //既に伝票番号を表示している。
        }else if($x==2){
            $contents = '';
            if($page_next == $count){
                $line = 'LBR';
            }else{
                $line = 'LR';
            }
        //売上金額計算
        }else if($x==8){
            //値を伝票計に足していく
            $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            //値を得意先計に足していく
            $data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
            $data_list[$x-1] = number_format($data_list[$x-1]);

            $contents = $data_list[$x-1];
            $line = '1';
        }else{
            //数字だったらカンマ区切りする
            if(is_numeric($data_list[$x-1])){
                //単価判定
                if($x == 7){
                    //単価
                    $data_list[$x-1] = number_format($data_list[$x-1],2);
                }else{
                    //他の数値
                    $data_list[$x-1] = number_format($data_list[$x-1]);
                }
            }
            $contents = $data_list[$x-1];
            $line = '1';
        }
        //販売区分以外表示
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

//*******************改ページ処理*****************************

    //行番号がページ最大表示数になった場合、改ページする
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、得意先名表示させる為に、前のページの表示数を代入
        $page_back = $page_next+1;
        //次の最大表示数
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);

//******************最終伝票計処理***********************************

    //値が変わった場合、伝票計表示
    if($slip != $data_list[1]){
        //一行目は、値をセットするだけ
        if($count != 1){
            $pdf->SetFillColor(220,220,220);
            //値の省略判定フラグ
            $space_flg2 = true;
            for($x=0;$x<9;$x++){
                //伝票計行番号
                if($x==0){
                    $pdf->SetFont(GOTHIC, '', 9);
                    $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
                    $pdf->SetFont(GOTHIC, 'B', 9);
                //得意先名
                }else if($x==1){
                    //改ページした後の一行目が、伝票計の場合、得意先名表示
                    if($page_back == $count){
                        $pdf->SetFont(GOTHIC, '', 9);
                        $pdf->Cell($list[$x][0], 14, $customer, 'LR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 9);
                        //得意先を表示させた場合は、データの得意先を省略
                        $slip_flg = true;
                    }else if($page_next == $count){
                        $pdf->SetFont(GOTHIC, '', 9);
                        $pdf->Cell($list[$x][0], 14, '', 'LBR', '0','L','');
                        $pdf->SetFont(GOTHIC, 'B', 9);
                    }else{
                        $pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
                        $slip_flg = false;
                    }
                //伝票計名
                }else if($x==2){
                    $pdf->Cell(50, 14, $list_sub[4][1]."：", 'TBL', '0',$list_sub[0][2],'1');
                //伝票計値
                }else if($x==3){
                    //形式変更
                    $data_sub2[8] = number_format($data_sub2[8]);
                    //税込金額を足す(得意先計用)
                    $client_money = $client_money + ($data_sub2[10] + $data_sub2[11]);
                    //税込金額
                    $data_sub2[10] = number_format($data_sub2[10] + $data_sub2[11]);

                    //消費税額を足す(得意先計用)
                    $client_tax = $client_tax + $data_sub2[11];
                    //消費税額
                    $data_sub2[11] = number_format($data_sub2[11]);

                    $pdf->Cell(90, 14, $data_sub2[8], 'TB', '0','R','1');
                //消費税名
                }else if($x==4){
                    $pdf->Cell(50, 14, $list_sub[5][1], 'TB', '0','R','1');
                //消費税値
                }else if($x==5){
                    $pdf->Cell(90, 14, $data_sub2[11], 'TB', '0','R','1');
                //税込計名
                }else if($x==6){
                    $pdf->Cell(50, 14, $list_sub[6][1], 'TB', '0','R','1');
                //税込計値
                }else if($x==7){
                    $pdf->Cell(90, 14, $data_sub2[10], 'TB', '0','R','1');
                //２列の値を表示
                }else if($x==8){
                    $pdf->Cell(300, 14, $data_sub2[2], 'TB', '0','R','1');
                }else{
                    $pdf->Cell(300, 14, $data_sub2[$x], 'TB', '0','R','1');
                }
            }
            $pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'TBR', '2','R','1');
            //伝票計・消費税・税込計、初期化
            $data_sub2 = array();
            $count++;
        }
        for($x=10;$x<12;$x++){
            //税込金額計算
            if($x==10){
                //値を伝票計に足していく
                $data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
            //消費税額計算
            }else if($x==11){
                //値を伝票計に足していく
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

//*******************改ページ処理*****************************

    //行番号がページ最大表示数になった場合、改ページする
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、得意先名表示させる為に、前のページの表示数を代入
        $page_back = $page_next+1;
        //次の最大表示数
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);


//******************最終得意先計処理***********************************

    //値が変わった場合、得意先計表示
    if($person != $data_list[0]){
        //一行目は、値をセットするだけ
        if($count != 1){
            $pdf->SetFillColor(180,180,180);
            //値の省略判定フラグ
            $space_flg = true;
            for($x=0;$x<9;$x++){
                //小計行番号
                if($x==0){
                    $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
                }else if($x==1){
                    $pdf->Cell($list_sub[0][0], 14, $list_sub[0][1]."：", 'TBL', '0',$list_sub[0][2],'1');
                //得意先計名
                }else if($x==2){
                    $pdf->Cell(50, 14, "", 'TB', '0',$list_sub[0][2],'1');
                //得意先計値
                }else if($x==3){
                    //小計値を合計値に足していく
                    $data_total[2] = $data_total[2] + $data_sub[8];
                    //消費税
                    $money_tax = $money_tax + $client_tax;
                    $data_total[3] = $data_total[3] + $money_tax;
                    //税込金額
                    $money = $money + $client_money;
                    //税込金額を足す(総合計用)
                    $data_total[4] = $data_total[4] + $money;
                    //消費税額
                    $money_tax = number_format($money_tax);
                    //消費税額を足す(総合計用)
                    $money = number_format($money);
                    $data_sub[8] = number_format($data_sub[8]);
                    
                    $pdf->Cell(90, 14, $data_sub[8], 'TB', '0','R','1');
                //消費税名
                }else if($x==4){
                    $pdf->Cell(50, 14, $list_sub[2][1], 'TB', '0','R','1');
                //消費税値
                }else if($x==5){
                    $pdf->Cell(90, 14, $money_tax, 'TB', '0','R','1');
                //税込計名
                }else if($x==6){
                    $pdf->Cell(50, 14, $list_sub[3][1], 'TB', '0','R','1');
                //税込計値
                }else if($x==7){
                    $pdf->Cell(90, 14, $money, 'TB', '0','R','1');
                //２列の値を表示
                }else if($x==8){
                    $pdf->Cell(300, 14, $data_sub[2], 'TB', '0','R','1');
                }else{
                    $pdf->Cell(300, 14, $data_sub[$x], 'TB', '0','R','1');
                }
            }
            $pdf->Cell($list[$x][0], 14, $data_sub[$x], 'TBR', '2','R','1');
            //得意先計・消費税・税込計、初期化
            $data_sub = array();
            $money_tax = 0;
            $money = 0;
            $count++;
        }
        $person = $data_list[0];
        for($x=10;$x<12;$x++){
            //税込金額計算
            if($x==10){
                //値を得意先計に足していく
                $data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
            //消費税額計算
            }else if($x==11){
                //値を得意先計に足していく
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

//*******************改ページ処理*****************************

    //行番号がページ最大表示数になった場合、改ページする
    if($page_next+1 == $count){
        $pdf->AddPage();
        $page_count++;
        //ヘッダー表示
        Header_disp2($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

        //改ページした最初の行が伝票計の場合、得意先名表示させる為に、前のページの表示数を代入
        $page_back = $page_next+1;
        //次の最大表示数
        $page_next = $page_max * $page_count;
        $space_flg = true;
        $space_flg2 = true;
    }

//*************************************************************

    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    $pdf->SetFont(GOTHIC, 'B', 9);

//*************************総合計処理*******************************

for($x=0;$x<9;$x++){
    //合計行番号
    if($x==0){
        $pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
    }else if($x==1){
        $pdf->Cell($list_sub[1][0], 14, $list_sub[1][1]."：", 'TBL', '0',$list_sub[1][2],'1');
    //総合計名
    }else if($x==2){
        $pdf->Cell(50, 14, "", 'TB', '0',$list_sub[1][2],'1');
    //担当者計値
    }else if($x==3){
        //消費税計算
        $money_tax = $data_total[3];
        //税込金額計算
        $money = $data_total[4];
        //形式変更
        $money_tax = number_format($money_tax);
        $money = number_format($money);
        $data_total[2] = number_format($data_total[2]);

        $pdf->Cell(90, 14, $data_total[2], 'TB', '0','R','1');
    //消費税名
    }else if($x==4){
        $pdf->Cell(50, 14, $list_sub[2][1], 'TB', '0','R','1');
    //消費税値
    }else if($x==5){
        $pdf->Cell(90, 14, $money_tax, 'TB', '0','R','1');
    //税込計名
    }else if($x==6){
        $pdf->Cell(50, 14, $list_sub[3][1], 'TB', '0','R','1');
    //税込計値
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
