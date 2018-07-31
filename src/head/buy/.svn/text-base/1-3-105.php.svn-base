<?php
/********************
 * 発注書
 *
 *
 * 変更履歴
 *   2006/07/06 (kaji)
 *     ・shop_gidをなくす
 *   2006/09/07 商品の略称を表示しない
 *   2006/09/12
 *      ・発注書コメント設定から発注書が出ないバグの修正
 ********************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/02/01　      　　　　watanabe-k　発注先と直送先にTELを表示するように修正
 * 　2007/02/06　B0702-004　　 kajioka-h 　発注が削除されていなかチェック追加
*/


//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

// ページタイトル
$page_title = "発　注　書";

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);


/****************************/
// 外部変数取得
/****************************/
$ord_id     = $_GET["ord_id"];
$shop_id    = $_SESSION["client_id"];
$format_flg = ($ord_id == null) ? true : false;


/****************************/
// 発注書発行済にする
/****************************/
// GETした発注IDがある場合
if ($format_flg != true){

    // 削除されてないかチェック
    $sql  = "SELECT \n";
    $sql .= "   ord_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    if (pg_num_rows($res) == 0){
        print "<font color=\"red\"><b>";
        print "指定した発注書は削除された可能性があります。<br>";
        print "再度発注書を指定してください。";
        print "</b></font>";
        exit;
    }

    Db_Query($db_con, "BEGIN;");
    $sql  = "UPDATE \n";
    $sql .= "   t_order_h \n";
    $sql .= "SET \n";
    $sql .= "   ord_sheet_flg = 't' \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }
    Db_Query($db_con, "COMMIT;");

}


/****************************/
// 発注書コメントデータ取得
/****************************/
$sql  = "SELECT \n";
$sql .= "   o_memo1_1, \n";                     // 発注書コメント（郵便１）
$sql .= "   o_memo1_2, \n";                     // 発注書コメント（郵便２）
$sql .= "   o_memo2, \n";                       // 発注書コメント2
$sql .= "   o_memo3, \n";                       // 発注書コメント3
$sql .= "   o_memo4, \n";                       // 発注書コメント4
$sql .= "   o_memo5, \n";                       // 発注書コメント5
$sql .= "   o_memo6, \n";                       // 発注書コメント6
$sql .= "   o_memo7, \n";                       // 発注書コメント7
$sql .= "   o_memo8, \n";                       // 発注書コメント8
$sql .= "   o_memo9, \n";                       // 発注書コメント9
$sql .= "   o_memo10, \n";                      // 発注書コメント10
$sql .= "   o_memo11, \n";                      // 発注書コメント11
$sql .= "   o_memo12 \n";                       // 発注書コメント12
$sql .= "FROM \n";
$sql .= "   t_order_sheet \n";
$sql .= "WHERE \n";
$sql .= "   shop_id = $shop_id \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$o_memo = Get_Data($res, 2);


/****************************/
// 表示用データ取得
/****************************/
// GETした発注IDがある場合
if ($format_flg != true){

    /****************************/
    // 日次更新情報取得
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "   ps_stat \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "WHERE \n";
    $sql .= "   t_order_h.ord_id = $ord_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $stat = pg_fetch_result($res, 0, 0);

    /****************************/
    // 発注元（自社）情報取得
    /****************************/
    // 日次更新後の場合
    $sql  = "SELECT \n";
    $sql .= "   my_client_name, \n";            // 発注元（自社）名
    $sql .= "   my_client_name2 \n";            // 発注元（自社）名２
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res    = Db_Query($db_con, $sql);
    $my_data = pg_fetch_array($res, 0);

    /****************************/
    // 発注先情報取得
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "   c_shop_name1, \n";              // 社名１
    $sql .= "   c_shop_name2, \n";              // 社名２
    $sql .= "   client_post_no1, \n";           // 得意先郵便番号
    $sql .= "   client_post_no2, \n";           // 得意先郵便番号２
    $sql .= "   client_address1, \n";           // 得意先住所１
    $sql .= "   client_address2, \n";           // 得意先住所２
    $sql .= "   client_address3, \n";           // 得意先住所３
    $sql .= "   client_charger1, \n";           // 得意先ご担当者
    $sql .= "   client_tel \n";                 // 得意先TEL
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $client_data = pg_fetch_array($res, 0);

    /****************************/
    // 直送先情報取得
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "   direct_name, \n";               // 直送先名
    $sql .= "   direct_name2, \n";              // 直送先名２
    $sql .= "   direct_post_no1, \n";           // 直送先郵便番号１
    $sql .= "   direct_post_no2, \n";           // 直送先郵便番号２
    $sql .= "   direct_address1, \n";           // 直送先住所１
    $sql .= "   direct_address2, \n";           // 直送先住所２
    $sql .= "   direct_address3, \n";           // 直送先住所３
    $sql .= "   direct_tel \n";                 // 直送先TEL
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $direct_data = @pg_fetch_array($res, 0);

    /****************************/
    // 発注情報取得
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "   ord_no, \n";                            // 発注No.
    $sql .= "   to_char(ord_time, 'yyyy-mm-dd'), \n";   // 発注日
    $sql .= "   arrival_day, \n";                       // 入荷予定日
    $sql .= "   hope_day, \n";                          // 希望納期
    $sql .= "   note_your, \n";                         // 通信欄（発注先宛）
    $sql .= "   note_your2, \n";                        // 第二通信欄
    $sql .= "   c_staff_name \n";                       // 発注元（自社）担当者
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $ord_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $ord_h_data = pg_fetch_array($res, 0);

    // 日付を年・月・日に分ける
    $order_day["y"]     = substr($ord_h_data[1], 0, 4);
    $order_day["m"]     = substr($ord_h_data[1], 5, 2);
    $order_day["d"]     = substr($ord_h_data[1], 8, 2);
    $arrival_day["y"]   = substr($ord_h_data[2], 0, 4);
    $arrival_day["m"]   = substr($ord_h_data[2], 5, 2);
    $arrival_day["d"]   = substr($ord_h_data[2], 8, 2);
    $hope_day["y"]      = substr($ord_h_data[3], 0, 4);
    $hope_day["m"]      = substr($ord_h_data[3], 5, 2);
    $hope_day["d"]      = substr($ord_h_data[3], 8, 2);

    /****************************/
    // 発注商品情報取得
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "   t_order_d.goods_cd, \n";        // 商品コード
    $sql .= "   t_order_d.goods_name, \n";      // 商品名
    $sql .= "   t_order_d.goods_cname, \n";     // 商品名略称
    $sql .= "   t_order_d.in_num, \n";          // 入数
    $sql .= "   t_order_d.num \n";              // 発注数
    $sql .= "FROM \n";
    $sql .= "   t_order_d \n";
    $sql .= "   INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id \n";
    $sql .= "   INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id \n";
    $sql .= "   INNER JOIN t_goods_info ON t_goods_info.goods_id = t_goods.goods_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_order_d.ord_id = $ord_id \n";
    $sql .= "AND \n";
    $sql .= "   t_order_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "  t_goods_info.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_order_d.line \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $ord_data = Get_Data($res, 2);

    $order_count    = count($ord_data);
    $page_num       = ceil($order_count / 15);

// GETした発注IDがない場合
}else{

    $order_data_num = 1;
    $order_count    = 1;
    $page_num       = ceil($order_count / 15);

}


/****************************/
// PDF作成
/****************************/
$left_margin    = 16;
$top_margin     = 14;

$pdf=new MBFPDF();

$pdf->AddMBFont(GOTHIC , "SJIS");
$pdf->AddMBFont(PGOTHIC, "SJIS");
$pdf->AddMBFont(MINCHO , "SJIS");
$pdf->AddMBFont(PMINCHO, "SJIS");
$pdf->AddMBFont(KOZMIN , "SJIS");

$pdf->SetFont(GOTHIC, "B", 11);
$pdf->SetAutoPageBreak(false);

$pdf->SetLeftMargin(16);

for ($page = 1; $page <= $page_num; $page++){

    /****************************/
    // 初期設定
    /****************************/
    $order_list[0] = "商品ｺｰﾄﾞ";        // 列項目名1
    $order_list[1] = "商　品　名";      // 列項目名2
    $order_list[2] = "ﾛｯﾄ入数";         // 列項目名3
    $order_list[3] = "発注数量";        // 列項目名4
    $order_list[4] = "備　考　欄";      // 列項目名5


    $pdf->AddPage();


    /****************************/
    // ページ数
    /****************************/
    $pdf->SetFont(GOTHIC, "", "10");
    $pdf->SetXY(150, 0);
    $pdf->Cell(71.5, 20, $page."/".$page_num."ページ", "0", "1", "C");
    $pdf->SetFont(GOTHIC, "B", 11);


    /****************************/
    // タイトル
    /****************************/
    $pdf->SetFont(GOTHIC, "B", 15);
    $pdf->SetXY(90, $top_margin);
    $pdf->Cell(40, 5, $page_title, "0", "1", "C");


    /****************************/
    // 発注No.
    /****************************/
    $pdf->SetFont(GOTHIC, "B", 11);
    $pdf->Cell(90, 5, "発注�癲�".$ord_h_data[0], "0", "0", "L");


    /****************************/
    // 発注日
    /****************************/
    $pdf->Cell(96, 5, "発注日　".$order_day["y"]." 年　".$order_day["m"]." 月　".$order_day["d"]." 日", "0", "1", "R");


    /****************************/
    // 発注先
    /****************************/
    $posY = $pdf->GetY();

    //$pdf->SetXY($left_margin, $posY+6);
    $pdf->SetXY($left_margin, $posY+3);

    // タイトル
    $pdf->SetFont(GOTHIC, "B", "10");
    $pdf->Cell(110, 5, "　発注先", "", "2", "L");

    // 発注先名称
    $pdf->SetFont(GOTHIC, "B", "11");
    // 得意先名２がnullの場合
    if ($client_data[1] == null){
        $pdf->Cell(110, 5, "　　".$client_data[0]."　　御中", "", "2", "L");
        $pdf->Cell(110, 5, "", "", "2", "L");
    }else{
        $pdf->Cell(110, 5, "　　".$client_data[0], "", "2", "L");
        $pdf->Cell(110, 5, "　　".$client_data[1]."　　御中", "", "1", "L");
    }

    // 発注先住所
    $pdf->SetFont(GOTHIC, "B","10");
    $pdf->Cell(110, 2, "", "", "2", "L");
    $pdf->Cell(110, 5, "　〒".$client_data[2]." - ".$client_data[3], "", "2", "L");
    $pdf->Cell(110, 5, "　　".$client_data[4], "", "2", "L");
    $pdf->Cell(110, 5, "　　".$client_data[5], "", "2", "L");
    $pdf->Cell(110, 5, "　　".$client_data[6], "", "2", "L");
    $pdf->Cell(110, 5, "　　".$client_data[client_tel], "", "2", "L");
    $pdf->Cell(110, 2, "", "", "2", "L");

    /****************************/
    // 発注元（自社）
    /****************************/
    $pdf->SetXY($left_margin+116, $top_margin+10);

    // 自社名
    $pdf->SetFont(GOTHIC, "B","11");
    $pdf->Cell(70, 5, $my_data[0], "0", "2", "L");
    $pdf->Cell(70, 4, $my_data[1], "0", "2", "L");

    // 自社住所
    $pdf->SetFont(GOTHIC, "B","10");
    //$pdf->Cell(70, 2, "", "0", "2", "L");
    $pdf->Cell(70, 5, "〒 ".$o_memo[0][0]." - ".$o_memo[0][1], "0", "2", "L");
    $pdf->Cell(70, 5, "　".$o_memo[0][2], "0", "2", "L");
    $pdf->Cell(70, 5, "　".$o_memo[0][3], "0", "2", "L");
    $pdf->Cell(70, 5, "　".$o_memo[0][4], "0", "2", "L");
    $pdf->Cell(70, 5, "　".$o_memo[0][5], "0", "2", "L");
    $pdf->Cell(70, 5, "　".$o_memo[0][6], "0", "2", "L");
    $pdf->Cell(70, 1, "", "0", "2", "L");

    // 発注担当者
    $pdf->Cell(70, 5, "　発注担当　".$ord_h_data[6], "0", "2", "L");


    /****************************/
    // コメント（上段）
    /****************************/
    $posY = $pdf->GetY();
    //$pdf->SetXY($left_margin+5, $posY+15);
    $pdf->SetXY($left_margin+5, $posY+1);
    $pdf->Cell(170, 5, $o_memo[0][7], "0", "2", "L");
    $pdf->Cell(170, 5, $o_memo[0][8], "0", "1", "L");


    /****************************/
    // 直送先
    /****************************/
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY+2);

    // タイトル
    $pdf->SetFont(GOTHIC, "B", "10");
    $pdf->Cell(90, 5, "　　直送先", "TLR", "1", "L");

    // 直送先名
    $pdf->SetFont(GOTHIC, "B", "9");
    //$pdf->Cell(90, 2, "", "LR", "2", "L");
    $pdf->Cell(90, 4, "　　　".$direct_data[0], "LR", "1", "L");
    $pdf->Cell(90, 4, "　　　".$direct_data[1], "LR", "1", "L");
    $pdf->Cell(90, 1, "", "LR", "2", "L");

    // 直送先住所
    if ($direct_data[2] == "" && $direct_data[3] == ""){
        $pdf->Cell(90, 4, "　　", "LR", "1", "L");
    }else{
        $pdf->Cell(90, 4, "　　〒 ".$direct_data[2]." - ".$direct_data[3], "LR", "1", "L");
    }
    $pdf->Cell(90, 4, "　　　".$direct_data[4], "LR", "1", "L");
    $pdf->Cell(90, 4, "　　　".$direct_data[5], "LR", "1", "L");
    $pdf->Cell(90, 4, "　　　".$direct_data[6], "LR", "1", "L");
    $pdf->Cell(90, 4, "　　　".$direct_data["direct_tel"], "LR", "1", "L");
    $pdf->Cell(90, 0, "", "LBR", "2", "L");


    /****************************/
    // 通信欄
    /****************************/
    $pdf->SetXY($left_margin+92, $posY+2);

    // タイトル
    $pdf->SetFont(GOTHIC, "B", "10");
    $pdf->Cell(94, 5, "通信欄", "TLR", "1", "L");

    $pdf->SetXY($left_margin+92, $posY+5);

    // 通信
    $pdf->SetFont(GOTHIC, "B", "9");
    $pdf->Cell(94, 2, "", "LR", "2", "L");
    $pdf->MultiCell(94, 4, $ord_h_data[4], "0", "2", "L");
    $pdf->SetXY($left_margin+92, $posY+2);
    $pdf->Cell(94, 34, "", "1", "2", "L");


    /****************************/
    // 第二通信欄
    /****************************/
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY+2);

    // タイトル
    $pdf->SetFont(GOTHIC, "B", "10");
    $pdf->Cell(186, 5, "第二通信欄", "TLR", "1", "L");

    $pdf->SetXY($left_margin, $posY+5);

    // 第二通信
    $pdf->SetFont(GOTHIC, "B", "9");
    $pdf->Cell(186, 2, "", "LR", "2", "L");
    $pdf->MultiCell(186, 4, $ord_h_data[5], "0", "2", "L");
    $pdf->SetXY($left_margin, $posY+2);
    $pdf->Cell(186, 22, "", "1", "2", "L");


    /****************************/
    // 一覧（ヘッダ行）
    /****************************/
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin+8, $posY+2);

    $pdf->Cell( 16, 7, $order_list[0], "1", "0", "C");
    $pdf->Cell(104, 7, $order_list[1], "1", "0", "C");
    $pdf->Cell( 16, 7, $order_list[2], "1", "0", "C");
    $pdf->Cell( 16, 7, $order_list[3], "1", "0", "C");
    $pdf->Cell( 26, 7, $order_list[4], "1", "2", "C");


    /****************************/
    // 一覧（データ行）
    /****************************/
    $pdf->SetFont(GOTHIC, "B", 9.5);
    for ($i = 0+(($page-1)*15); $i < 15*$page; $i++){
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY);
        $pdf->Cell(  8, 5.3, str_pad($i+1, 2, "0", STR_PAD_LEFT), "1", "0", "C");
        $pdf->Cell( 16, 5.3, $ord_data[$i][0], "1", "0", "L");
        $pdf->Cell(104, 5.3, $ord_data[$i][1], "1", "0", "L");
        $pdf->Cell( 16, 5.3, $ord_data[$i][3], "1", "0", "R");
        $pdf->Cell( 16, 5.3, $ord_data[$i][4], "1", "0", "R");
        $pdf->Cell( 26, 5.3, $ord_data[$i][5], "1", "2", "L");
    }


    /****************************/
    // 希望納期
    /****************************/
    $pdf->SetFont(GOTHIC, "B", 11);
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY+2);

    $pdf->Cell( 2, 8, "", "1", "0", "C");
    $pdf->Cell(21, 8, "希望納期", "1", "0", "C");
    $pdf->Cell( 2, 8, "", "1", "0", "C");
    $pdf->Cell(68, 8,$hope_day["y"]." 年　".$hope_day["m"]." 月　".$hope_day["d"]." 日　", "1", "0", "C");


    /****************************/
    // 発注件数
    /****************************/
    $pdf->Cell( 2, 8, "", "1", "0", "C");
    $pdf->Cell(21, 8, "発注件数", "1", "0", "C");
    $pdf->Cell( 2, 8, "", "1", "0", "C");
    $pdf->Cell(68, 8, $order_count." 件", "1", "2", "C");


    /****************************/
    // コメント下段
    /****************************/
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin+5, $posY+2);

    $pdf->Cell(170, 4.5, $o_memo[0][9],  "0", "2", "L");
    $pdf->Cell(170, 4.5, $o_memo[0][10], "0", "2", "L");
    $pdf->Cell(170, 4.5, $o_memo[0][11], "0", "2", "L");
    $pdf->Cell(170, 4.5, $o_memo[0][12], "0", "2", "L");


    /****************************/
    // 罫線
    /****************************/
    $posY = $pdf->GetY();
    $pdf->SetLineWidth(0.4);

    $pdf->Line($left_margin, $posY+2, $left_margin+185, $posY+2);
    $pdf->SetDrawColor(255);
    for($i=2;$i<190;$i=$i+3){
        $pdf->Line($left_margin+$i, $posY+2, $left_margin+$i+1, $posY+2);
    }

    $pdf->SetLineWidth(0.2);
    $pdf->SetDrawColor(0);


    /****************************/
    // 運送会社
    /****************************/
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY+4);

    $pdf->Cell(20, 16, "運送会社", "1", "0", "C");
    $pdf->MultiCell(75, 16, "", "1", "0", "C");


    /****************************/
    // 出荷予定
    /****************************/
    $pdf->SetXY($left_margin+95, $posY+4);

    $pdf->Cell(20, 8, "出荷予定", "1", "0", "C");
    $pdf->Cell(71, 8, "　　年　　　月　　　日", "1", "0", "C");


    /****************************/
    // 着荷予定
    /****************************/
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin+95, $posY+8);

    $pdf->Cell(20, 8, "着荷予定", "1", "0", "C");
    $pdf->Cell(71, 8, "　　年　　　月　　　日", "1", "2", "C");

}

$pdf->Output();

?>
