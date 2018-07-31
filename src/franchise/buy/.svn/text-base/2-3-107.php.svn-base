<?php
/********************
 * 発注書
 *
 *
 * 変更履歴
 *   2006/07/06 (kaji)
 *     ・shop_gidをなくす
 *
 ********************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/11　06-065　　　　watanabe-k　GETの値チェックを追加
 * 　2006/11/11　06-066　　　　watanabe-k　GETの値チェックを追加
 * 　2006/11/11　06-068　　　　watanabe-k　GETの値チェックを追加
 * 　2007/01/31　      　　　　watanabe-k　電話番号を表示するように修正
 *
 */


//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

// ページタイトル
$page_title = "発　注　書";

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);


/****************************/
//外部変数取得
/****************************/
$ord_id     = $_GET["ord_id"];
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
Get_Id_Check3($ord_id);

$format_flg = ($ord_id == null) ? true : false;


/****************************/
// 発注書発行済にする
/****************************/
if($format_flg != true){
    Db_Query($db_con, "BEGIN;");
    $sql    = "UPDATE t_order_h SET ord_sheet_flg = 't' WHERE ord_id = $ord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, $sql);
        exit;
    }
    Db_Query($db_con, "COMMIT;");
}

    /****************************/
    // 発注書コメントデータ取得
    /****************************/
    $sql    = "SELECT ";
    $sql   .= "   o_memo1_1, ";                     // 発注書コメント（郵便１）
    $sql   .= "   o_memo1_2, ";                     // 発注書コメント（郵便２）
    $sql   .= "   o_memo2, ";                       // 発注書コメント2
    $sql   .= "   o_memo3, ";                       // 発注書コメント3
    $sql   .= "   o_memo4, ";                       // 発注書コメント4
    $sql   .= "   o_memo5, ";                       // 発注書コメント5
    $sql   .= "   o_memo6, ";                       // 発注書コメント6
    $sql   .= "   o_memo7, ";                       // 発注書コメント7
    $sql   .= "   o_memo8, ";                       // 発注書コメント8
    $sql   .= "   o_memo9, ";                       // 発注書コメント9
    $sql   .= "   o_memo10, ";                      // 発注書コメント10
    $sql   .= "   o_memo11, ";                      // 発注書コメント11
    $sql   .= "   o_memo12 ";                       // 発注書コメント12
    $sql   .= "FROM ";
    $sql   .= "   t_order_sheet ";
    $sql   .= "WHERE ";
//    $sql   .= "   shop_id = $shop_id ";
    $sql   .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql   .= ";";
    $res    = Db_Query($db_con, $sql);
    $o_memo = Get_Data($res, 2);

/****************************/
// 表示用データ取得
/****************************/
if ($format_flg != true){
    /****************************/
    // 日次更新情報取得
    /****************************/
    $sql    = "SELECT ps_stat FROM t_order_h WHERE t_order_h.ord_id = $ord_id AND shop_id = $shop_id AND ord_stat IS NULL;";
    $res    = Db_Query($db_con, $sql);
    Get_Id_Check($res);
    $stat   = pg_fetch_result($res, 0, 0);

    /****************************/
    // 発注元（自社）情報取得
    /****************************/
    // 日次更新後の場合
//    if ($stat == "4"){
        $sql  = "SELECT ";
        $sql .= "   my_client_name, ";              // 発注元（自社）名
        $sql .= "   my_client_name2 ";              // 発注元（自社）名２
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "WHERE ";
        $sql .= "   ord_id = $ord_id ";
        $sql .= ";";
/*
    // 日次更新前の場合
    }else{
        $sql  = "SELECT ";
        $sql .= "   shop_name, ";                   // 発注元（自社）名
        $sql .= "   shop_name2 ";                   // 発注元（自社）名２
        $sql .= "FROM ";
        $sql .= "   t_client ";
        $sql .= "WHERE ";
        $sql .= "   t_client.client_id = $_SESSION[client_id] ";
        $sql .= ";";
    }
*/
    $res    = Db_Query($db_con, $sql);
    $my_data = pg_fetch_array($res, 0);

    /****************************/
    // 発注先情報取得
    /****************************/
    // 日次更新後の場合
//    if ($stat == "4"){
        $sql  = "SELECT ";
        $sql .= "   client_name, ";                 // 得意先名
        $sql .= "   client_name2, ";                // 得意先名２
        $sql .= "   client_post_no1, ";             // 得意先郵便番号
        $sql .= "   client_post_no2, ";             // 得意先郵便番号２
        $sql .= "   client_address1, ";             // 得意先住所１
        $sql .= "   client_address2, ";             // 得意先住所２
        $sql .= "   client_address3, ";             // 得意先住所３
        $sql .= "   client_charger1, ";             // 得意先ご担当者
        $sql .= "   client_tel ";
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "WHERE ";
        $sql .= "   ord_id = $ord_id ";
        $sql .= ";";
/*
    // 日次更新前の場合
    }else{
        $sql  = "SELECT ";
        $sql .= "   t_client.client_name, ";        // 得意先名
        $sql .= "   t_client.client_name2, ";       // 得意先名２
        $sql .= "   t_client.post_no1, ";           // 得意先郵便番号１
        $sql .= "   t_client.post_no2, ";           // 得意先郵便番号２
        $sql .= "   t_client.address1, ";           // 得意先住所１
        $sql .= "   t_client.address2, ";           // 得意先住所２
        $sql .= "   t_client.address3, ";           // 得意先住所３
        $sql .= "   t_client.charger1 ";            // 得意先ご担当者
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "   INNER JOIN t_client ";
        $sql .= "   ON t_order_h.client_id = t_client.client_id ";
        $sql .= "WHERE ";
        $sql .= "   t_order_h.ord_id = $ord_id ";
        $sql .= ";";
    }
*/
    $res    = Db_Query($db_con, $sql);
    $client_data = pg_fetch_array($res, 0);

    /****************************/
    // 直送先情報取得
    /****************************/
    // 日次更新後の場合
//    if ($stat == "4"){
        $sql  = "SELECT ";
        $sql .= "   direct_name, ";                 // 直送先名
        $sql .= "   direct_name2, ";                // 直送先名２
        $sql .= "   direct_post_no1, ";             // 直送先郵便番号１
        $sql .= "   direct_post_no2, ";             // 直送先郵便番号２
        $sql .= "   direct_address1, ";             // 直送先住所１
        $sql .= "   direct_address2, ";             // 直送先住所２
        $sql .= "   direct_address3, ";             // 直送先住所３
        $sql .= "   direct_tel ";
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "WHERE ";
        $sql .= "   ord_id = $ord_id ";
        $sql .= ";";
/*
    // 日次更新前の場合
    }else{
        $sql  = "SELECT ";
        $sql .= "   t_direct.direct_name, ";        // 直送先名
        $sql .= "   t_direct.direct_name2, ";       // 直送先名２
        $sql .= "   t_direct.post_no1, ";           // 直送先郵便番号１
        $sql .= "   t_direct.post_no2, ";           // 直送先郵便番号２
        $sql .= "   t_direct.address1, ";           // 直送先住所１
        $sql .= "   t_direct.address2, ";           // 直送先住所２
        $sql .= "   t_direct.address3 ";            // 直送先住所３
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "   INNER JOIN t_direct ";
        $sql .= "   ON t_order_h.direct_id = t_direct.direct_id ";
        $sql .= "WHERE ";
        $sql .= "   t_order_h.ord_id = $ord_id ";
        $sql .= ";";
    }
*/
    $res    = Db_Query($db_con, $sql);
    $direct_data = @pg_fetch_array($res, 0);

    /****************************/
    // 発注情報取得
    /****************************/
    // 日次更新後の場合
//    if ($stat == "4"){
        $sql  = "SELECT ";
        $sql .= "   ord_no, ";                          // 発注No.
        $sql .= "   to_char(ord_time, 'yyyy-mm-dd'), "; // 発注日
        $sql .= "   arrival_day, ";                     // 入荷予定日
        $sql .= "   hope_day, ";                        // 希望納期
        $sql .= "   note_your, ";                       // 通信欄（発注先宛）
        $sql .= "   c_staff_name ";                     // 発注元（自社）担当者
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "WHERE ";
        $sql .= "   ord_id = $ord_id ";
        $sql .= ";";
/*
    // 日次更新前の場合
    }else{
        $sql  = "SELECT ";
        $sql .= "   t_order_h.ord_no, ";
        $sql .= "   to_char(t_order_h.ord_time, 'yyyy-mm-dd'), ";
        $sql .= "   t_order_h.arrival_day, ";
        $sql .= "   t_order_h.hope_day, ";
        $sql .= "   t_order_h.note_your, ";
        $sql .= "   t_staff.staff_name ";
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "   INNER JOIN t_staff ";
        $sql .= "   ON t_order_h.c_staff_id = t_staff.staff_id ";
        $sql .= "WHERE ";
        $sql .= "   t_order_h.ord_id = $ord_id ";
        $sql .= ";";
    }
*/
    $res  = Db_Query($db_con, $sql);
    $ord_h_data = pg_fetch_array($res, 0);

    // 日付を区切る
    $order_day["y"]   = substr($ord_h_data[1], 0, 4);
    $order_day["m"]   = substr($ord_h_data[1], 5, 2);
    $order_day["d"]   = substr($ord_h_data[1], 8, 2);
    $arrival_day["y"] = substr($ord_h_data[2], 0, 4);
    $arrival_day["m"] = substr($ord_h_data[2], 5, 2);
    $arrival_day["d"] = substr($ord_h_data[2], 8, 2);
    $hope_day["y"]    = substr($ord_h_data[3], 0, 4);
    $hope_day["m"]    = substr($ord_h_data[3], 5, 2);
    $hope_day["d"]    = substr($ord_h_data[3], 8, 2);

    /****************************/
    // 発注商品情報取得
    /****************************/
    $sql  = "SELECT ";
//    $sql .= "    t_goods.goods_cd, ";     // 商品コード
    $sql .= "    t_order_d.goods_cd, ";     // 商品コード
    $sql .= "    t_order_d.goods_name, ";   // 商品名
//    $sql .= ($stat == "4") ? " t_order_d.goods_cname, " : "t_goods.goods_cname, ";  // 商品名略称
    $sql .= "    t_order_d.goods_cname, ";  // 商品名略称
//    $sql .= "    t_goods.in_num, ";       // 入数
    $sql .= "    t_order_d.in_num, ";       // 入数
    $sql .= "    t_order_d.num ";           // 発注数
    $sql .= "FROM ";
    $sql .= "    t_order_d ";
    $sql .= "       INNER JOIN\n";
    $sql .= "    t_order_h\n";
    $sql .= "    ON t_order_d.ord_id = t_order_h.ord_id ";
    $sql .= "       INNER JOIN\n";
    $sql .= "    t_goods\n";
    $sql .= "    ON t_order_d.goods_id = t_goods.goods_id ";
    $sql .= "       INNER JOIN\n";
    $sql .= "    t_goods_info\n";
    $sql .= "    ON t_goods_info.goods_id = t_goods.goods_id ";
    $sql .= "WHERE ";
    $sql .= "    t_order_d.ord_id = $ord_id ";
    $sql .= "AND ";
    $sql .= "    t_order_h.shop_id = $shop_id ";
    $sql .= "AND ";
//    $sql .= "   t_goods_info.shop_id = $_SESSION[client_id] ";
    $sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
    $sql .= "ORDER BY ";
    $sql .= "    t_order_d.line ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $ord_data = Get_Data($res,2);

    $order_count    = count($ord_data);
    $page_num       = ceil($order_count / 15);

}else{
    $order_data_num = 1;
//    $order_count = "";
    $order_count = 1;
    $page_num = ceil($order_count / 15);
}


/****************************/
// PDF作成
/****************************/
//if ($format_flg != true){

    $left_margin = 16;
    $top_margin = 14;

    $pdf=new MBFPDF();

    $pdf->AddMBFont(GOTHIC ,'SJIS');
    $pdf->AddMBFont(PGOTHIC,'SJIS');
    $pdf->AddMBFont(MINCHO ,'SJIS');
    $pdf->AddMBFont(PMINCHO,'SJIS');
    $pdf->AddMBFont(KOZMIN ,'SJIS');

    $pdf->SetFont(GOTHIC, 'B', 11);
    $pdf->SetAutoPageBreak(false);

    $pdf->SetLeftMargin(16);

    for($page = 1; $page <= $page_num; $page++){

        $pdf->AddPage();

        $pdf->SetFont(GOTHIC, '','10');
        $pdf->SetXY(150, 0);
//        $pdf->Cell(71.5, 10, $page.'/'.$page_num.'ページ', '0', '1', 'C');
        $pdf->Cell(71.5, 20, $page.'/'.$page_num.'ページ', '0', '1', 'C');
        $pdf->SetFont(GOTHIC, 'B', 11);

        $address[8] = $staff_name;                  // 発注元担当者名目

        $order_list[0] = "商品ｺｰﾄﾞ";                // 列項目名1
        $order_list[1] = "商　品　名";              // 列項目名2
        $order_list[2] = "ﾛｯﾄ入数";                 // 列項目名3
        $order_list[3] = "発注数量";                // 列項目名4
        $order_list[4] = "備　考　欄";              // 列項目名5

        // タイトル
        $pdf->SetFont(GOTHIC, 'B', 15);
        $pdf->SetXY(90, $top_margin);
        $pdf->Cell(40, 5, $page_title, '0', '1', 'C');

        $pdf->SetFont(GOTHIC, 'B', 11);

        // 発注��
        $pdf->Cell(90, 5, "発注�癲�".$ord_h_data[0], '0', '0', 'L');

        // 発注日
        $pdf->Cell(96, 5, "発注日　".$order_day["y"]." 年　".$order_day["m"]." 月　".$order_day["d"]." 日", '0', '1', 'R');

        // 発注先
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY+6);
        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(110, 5, "　発注先", '', '2', 'L');
/*
        $pdf->Cell(90, 5, "発注先", 'TLR', '2', 'L');
        $pdf->Cell(90, 2, "", 'LR', '2', 'L');
        $pdf->Cell(90, 5, "　".$client_data[0], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "　".$client_data[1], 'LR', '2', 'L');
        $pdf->Cell(90, 2, "", 'LR', '2', 'L');
        $pdf->Cell(90, 5, "〒 ".$client_data[2]." - ".$client_data[3], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "　".$client_data[4], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "　".$client_data[5], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "　".$client_data[6], 'LR', '2', 'L');
        $pdf->Cell(90, 2, "", 'LR', '2', 'L');
        $pdf->Cell(90, 5, "　　".$client_data[7], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "御中", 'LRB', '2', 'R');
*/
        $pdf->SetFont(GOTHIC, 'B','11');
        //得意先名
        if($client_data[1] == null){
            $pdf->Cell(110, 5, "　　".$client_data[0]."　　御中", '', '2', 'L');
            $pdf->Cell(110, 5, "", '', '2', 'L');
        }else{
            $pdf->Cell(110, 5, "　　".$client_data[0], '', '2', 'L');
            $pdf->Cell(110, 5, "　　".$client_data[1]."　　御中", '', '2', 'L');
        }

        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(110, 2, "", '', '2', 'L');
        $pdf->Cell(110, 5, "　〒 ".$client_data[2]." - ".$client_data[3], '', '2', 'L');
        $pdf->Cell(110, 5, "　　".$client_data[4], '', '2', 'L');
        $pdf->Cell(110, 5, "　　".$client_data[5], '', '2', 'L');
        $pdf->Cell(110, 5, "　　".$client_data[6], '', '2', 'L');
        $pdf->Cell(110, 5, "　　".$client_data[client_tel], '', '2', 'L');
        $pdf->Cell(110, 2, "", '', '2', 'L');

        // 発注元（自社）情報、発注書コメント
        $pdf->SetXY($left_margin+116, $top_margin+15);
        $pdf->SetFont(GOTHIC, 'B','11');
        $pdf->Cell(70, 5, $my_data[0], '0', '2', 'L');
        $pdf->Cell(70, 5, $my_data[1], '0', '2', 'L');
        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(70, 2, "", '0', '2', 'L');
        $pdf->Cell(70, 5, "〒 ".$o_memo[0][0]." - ".$o_memo[0][1], '0', '2', 'L');
        $pdf->Cell(70, 5, "　".$o_memo[0][2], '0', '2', 'L');
        $pdf->Cell(70, 5, "　".$o_memo[0][3], '0', '2', 'L');
        $pdf->Cell(70, 5, "　".$o_memo[0][4], '0', '2', 'L');
        $pdf->Cell(70, 5, "　".$o_memo[0][5], '0', '2', 'L');
        $pdf->Cell(70, 5, "　".$o_memo[0][6], '0', '2', 'L');
        $pdf->Cell(70, 2, "", '0', '2', 'L');
        $pdf->Cell(70, 5, "　発注担当　".$ord_h_data[5], '0', '2', 'L');

        //コメント（上段）
        $posY = $pdf->GetY();
//        $pdf->SetXY($left_margin+5, $posY+15);
        $pdf->SetXY($left_margin+5, $posY+4);
        $pdf->Cell(170, 5, $o_memo[0][7], '0', '2', 'L');
        $pdf->Cell(170, 5, $o_memo[0][8], '0', '1', 'L');

        // 直送先
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY+3);
        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(90, 5, "　　直送先", 'TLR', '1', 'L');
        $pdf->SetFont(GOTHIC, 'B','9');
        $pdf->Cell(90, 2, "", 'LR', '2', 'L');
        $pdf->Cell(90, 4, "　　　".$direct_data[0], 'LR', '1', 'L');
        $pdf->Cell(90, 2, "　　　".$direct_data[1], 'LR', '1', 'L');
        $pdf->Cell(90, 4, "", 'LR', '2', 'L');
        if ($direct_data[2] == "" && $direct_data[3] == ""){
            $pdf->Cell(90, 4, "　　", 'LR', '1', 'L');
        }else{
            $pdf->Cell(90, 4, "　　〒 ".$direct_data[2]." - ".$direct_data[3], 'LR', '1', 'L');
        }
        $pdf->Cell(90, 4, "　　　".$direct_data[4], 'LR', '1', 'L');
        $pdf->Cell(90, 4, "　　　".$direct_data[5], 'LR', '1', 'L');
        $pdf->Cell(90, 4, "　　　".$direct_data[6], 'LR', '1', 'L');
        $pdf->Cell(90, 4, "　　　".$direct_data[7], 'LRB', '1', 'L');

        //通信欄
        $pdf->SetXY($left_margin+93, $posY+3);
        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(93, 5, "通信欄", 'TLR', '1', 'L');
        $pdf->SetXY($left_margin+93, $posY+7);
        $pdf->SetFont(GOTHIC, 'B','9');
        $pdf->Cell(93, 2, "", 'LR', '2', 'L');
        $pdf->MultiCell(95, 4, $ord_h_data[4], '0', '2', 'L');
        $pdf->SetXY($left_margin+93, $posY+3);
        $pdf->Cell(93, 37, '', '1', '2', 'L');

        //一覧（ヘッダ行）
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin+8, $posY+3);
        $pdf->Cell(16, 8, $order_list[0], '1', '0', 'C');
        $pdf->Cell(104, 8, $order_list[1], '1', '0', 'C');
        $pdf->Cell(16, 8, $order_list[2], '1', '0', 'C');
        $pdf->Cell(16, 8, $order_list[3], '1', '0', 'C');
        $pdf->Cell(26, 8, $order_list[4], '1', '2', 'C');

        // 一覧（データ行）
        $pdf->SetFont(GOTHIC, 'B', 9.5);
        for($i=0+(($page-1)*15); $i< 15*$page; $i++){
            $posY = $pdf->GetY();
            $pdf->SetXY($left_margin, $posY);
            $pdf->Cell(8, 5.3, str_pad($i+1, 2, "0", STR_PAD_LEFT), '1', '0', 'C');
            $pdf->Cell(16, 5.3, $ord_data[$i][0], '1', '0', 'L');
            $pdf->Cell(104, 5.3, $ord_data[$i][1]."　".$ord_data[$i][2], '1', '0', 'L');
            $pdf->Cell(16, 5.3, $ord_data[$i][3], '1', '0', 'R');
            $pdf->Cell(16, 5.3, $ord_data[$i][4], '1', '0', 'R');
            $pdf->Cell(26, 5.3, $ord_data[$i][5], '1', '2', 'L');
        }

        $pdf->SetFont(GOTHIC, 'B', 11);
        // 希望納期
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY+3);
        $pdf->Cell(2, 10, "", '1', '0', 'C');
        $pdf->Cell(21, 10, "希望納期", '1', '0', 'C');
        $pdf->Cell(2, 10, "", '1', '0', 'C');
        $pdf->Cell(68, 10,$hope_day["y"]." 年　".$hope_day["m"]." 月　".$hope_day["d"]." 日　", '1', '0', 'C');

        // 発注件数
        $pdf->Cell(2, 10, "", '1', '0', 'C');
        $pdf->Cell(21, 10, "発注件数", '1', '0', 'C');
        $pdf->Cell(2, 10, "", '1', '0', 'C');
        $pdf->Cell(68, 10, $order_count." 件", '1', '2', 'C');

        // コメント下段
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin+5, $posY+3);
        $pdf->Cell(170, 5, $o_memo[0][9], '0', '2', 'L');
        $pdf->Cell(170, 5, $o_memo[0][10], '0', '2', 'L');
        $pdf->Cell(170, 5, $o_memo[0][11], '0', '2', 'L');
        $pdf->Cell(170, 5, $o_memo[0][12], '0', '2', 'L');

        // 罫線
        $posY = $pdf->GetY();
        $pdf->SetLineWidth(0.4);
        $pdf->Line($left_margin, $posY+3, $left_margin+185, $posY+3);
        $pdf->SetDrawColor(255);
        for($i=2;$i<190;$i=$i+3){
            $pdf->Line($left_margin+$i, $posY+3, $left_margin+$i+1, $posY+3);
        }

        $pdf->SetLineWidth(0.2);
        $pdf->SetDrawColor(0);

        // 運送会社
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY+7);
        $pdf->Cell(20, 16, "運送会社", '1', '0', 'C');
        $pdf->MultiCell(75, 16, '', '1', '0', 'C');

        $pdf->SetXY($left_margin+95, $posY+7);
        // 出荷予定
        $pdf->Cell(20, 8, "出荷予定", '1', '0', 'C');
        $pdf->Cell(71, 8, "　　年　　　月　　　日", '1', '0', 'C');

        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin+95, $posY+8);

        // 出荷予定
        $pdf->Cell(20, 8, "着荷予定", '1', '0', 'C');
        $pdf->Cell(71, 8, "　　年　　　月　　　日", '1', '2', 'C');

    }

//}
$pdf->Output();


?>
