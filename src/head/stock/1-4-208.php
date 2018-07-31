<?php
/**
 *
 * 棚卸一覧
 *
 *
 *
 *
 *
 *
 *
 *   !! 本部・FC画面ともに同じソース内容です !!
 *   !! 変更する場合は片方をいじって他方にコピってください !!
 *
 *
 *
 *
 *
 *
 *
 *
 * 1.0.0 (2006/05/11) 新規作成
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 * @version     1.0.0 (2006/05/11)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      02-015      kajioka-h   倉庫計を修正
 *                  02-016      kajioka-h   サイニタイジング追加
 *                  02-017      kajioka-h   全倉庫テーブルに表示するSQLから倉庫指定の条件を取った
 *                  02-019      kajioka-h   GETの数値チェック
 *  2006/12/08      02-023      kajioka-h   棚卸データが存在しない倉庫で検索した場合にトップに飛ぶのを修正
 *  2007/03/06      作業項目73  ふ          棚卸一覧と差異明細一覧を１モジュールに集約
 *  2007/05/04      B0702-047   kajioka-h   戻るボタンの遷移先が間違っているのを修正
 *                  B0702-048   kajioka-h   対象倉庫のセレクトに「0：0」を表示しないように修正
 *  2007/05/15      B0702-052   kajioka-h   変数名ミスによるサニタイジング漏れを修正
 *  2007/06/23      xx-xxx      kajioka-h   前回対比金額をなくす、棚卸入力者を追加、前回在庫数・在庫金額・対比数の合計を表示
 *  2007/08/27                  kajioka-h   棚卸差異数を実棚数−帳簿数に変更、棚卸入力者を表示しない（画面、CSV）
 */

$page_title = "棚卸一覧";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("$_SERVER[PHP_SELF]", "POST");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$invent_no  = $_GET["invent_no"];
$ware_id    = ($_POST["form_ware"] == null) ? $_GET["ware_id"] : $_POST["form_ware"];
$get_id     = $_GET["ware_id"];
$group_kind = $_SESSION["group_kind"];

Get_Id_Check3($invent_no);
Get_Id_Check3($ware_id);


/****************************/
// 初期値設定
/****************************/
$def_data["form_output_type"]   = "1";
$form->setDefaults($def_data);

// 前回調査番号（０埋め）
$last_no    = str_pad($invent_no - 1, 10, "0", STR_PAD_LEFT);
// 今回調査番号（０埋め）
$invent_no  = str_pad($invent_no, 10, 0, STR_POS_LEFT);


/****************************/
// フォーム作成
/****************************/
// 表示形式
$radio = "";
$radio[] =& $form->createElement("radio", null, null, "画面", "1");
$radio[] =& $form->createElement("radio", null, null, "CSV",  "2");
$form->addGroup($radio, "form_output_type", "");

// 対象倉庫
$ware_where  = " WHERE ";
if($group_kind == "2"){
    //直営の場合
    $ware_where .= " shop_id IN (".Rank_Sql().") ";
}else{
    //本部、直営以外のFCの場合
    $ware_where .= " shop_id = $shop_id ";
}
$ware_where .= " AND staff_ware_flg = false ";
$ware_where .= " AND ware_id != 0 ";
$ware_where .= " AND nondisp_flg = false ";
$select_value = Select_Get($db_con, "ware", $ware_where);
$form->addElement("select", "form_ware", "", $select_value);

// 表示ボタン
$form->addElement("submit", "show_button", "表　示");

if($group_kind == "1"){
    // クリアボタン
    $form->addElement("button", "clear_button", "クリア", "onClick=\"location.href='./1-4-208.php?invent_no=$invent_no'\"");

    // 戻るボタン
    if ($get_id == null){
        $form->addElement("button", "form_back_button", "戻　る", "onClick=\"location.href='./1-4-205.php'\"");
    }else{
        $form->addElement("button", "form_back_button", "戻　る", "onClick=\"location.href='./1-4-201.php'\"");
    }
}else{
    // クリアボタン
    $form->addElement("button", "clear_button", "クリア", "onClick=\"location.href='./2-4-208.php?invent_no=$invent_no'\"");

    // 戻るボタン
    if ($get_id == null){
        $form->addElement("button", "form_back_button", "戻　る", "onClick=\"location.href='./2-4-205.php'\"");
    }else{
        $form->addElement("button", "form_back_button", "戻　る", "onClick=\"location.href='./2-4-201.php'\"");
    }
}


/****************************/
// 表示ボタンが押下された場合
/****************************/
if ($_POST["show_button"] == "表　示"){

    // POST情報取得
    $output_type    = $_POST["form_output_type"];        // 出力形式

}
 

/****************************/
// SQL作成
/****************************/
// 棚卸調査票作成日取得
$sql  = "SELECT \n";
$sql .= "   expected_day \n";
$sql .= "FROM \n";
$sql .= "   t_invent \n";
$sql .= "WHERE \n";
$sql .= "   shop_id = $shop_id \n";
$sql .= "AND \n";
$sql .= "   invent_no = '$invent_no' \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
Get_Id_Check($res);
$invent_day = pg_fetch_result($res, 0, 0);


// 棚卸番号をもとに、棚卸実施倉庫リストを抽出
$sql  = "SELECT \n";
$sql .= "   t_invent.ware_id, \n";
$sql .= "   t_ware.ware_name, \n";
$sql .= "   t_invent.exec_day \n";
$sql .= "FROM \n";
$sql .= "   t_invent \n";
$sql .= "   INNER JOIN t_ware ON t_invent.ware_id = t_ware.ware_id \n";
$sql .= "WHERE \n";
$sql .= "   t_invent.shop_id = $shop_id \n";
$sql .= "AND \n";
$sql .= "   t_invent.invent_no = '$invent_no' \n";
if ($ware_id != null){
$sql .= "AND \n";
$sql .= "   t_invent.ware_id = $ware_id \n";
}
$sql .= "ORDER BY \n";
$sql .= "   t_ware.ware_cd \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$ware_list_num = pg_num_rows($res);                                 // 実施倉庫数
if ($ware_list_num != 0){
    for ($i = 0; $i < $ware_list_num; $i++){
        $ary_ware_list_id[]     = pg_fetch_result($res, $i ,0);     // 実施倉庫ID
        $ary_ware_list_name[]   = pg_fetch_result($res, $i ,1);     // 実施倉庫名
    }
}


// 倉庫ごとに、棚卸データ・差異データを抽出
for ($i = 0; $i < $ware_list_num; $i++){
    $sql  = "SELECT \n";
    $sql .= "   a_invent.g_product_name, \n";                                                   // 0    商品分類名
    $sql .= "   a_invent.goods_name, \n";                                                       // 1    商品名
    $sql .= "   a_invent.stock_num, \n";                                                        // 2    帳簿数
    $sql .= "   a_invent.tstock_num, \n";                                                       // 3    実棚数
    $sql .= "   a_invent.invent_diff, \n";                                                      // 4    棚卸差異数
    $sql .= "   a_invent.price, \n";                                                            // 5    棚卸単価
    $sql .= "   a_invent.money, \n";                                                            // 6    棚卸金額
    $sql .= "   b_invent.tstock_num AS last_tstock_num, \n";                                    // 7    前回在庫数
    $sql .= "   b_invent.money                                          AS last_money, \n";     // 8    前回在庫金額
    $sql .= "   a_invent.tstock_num - COALESCE(b_invent.tstock_num, 0)  AS comp_num, \n";       // 9    前回対比数
    //$sql .= "   a_invent.money - COALESCE(b_invent.money, 0)            AS comp_money, \n";     // 10   前回対比金額
    $sql .= "   a_invent.staff_name, \n";                                                       // 10   棚卸実施者
    $sql .= "   a_invent.input_staff_name, \n";                                                 // 11   棚卸入力者
    $sql .= "   a_invent.cause \n";                                                             // 12   差異原因
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_invent.ware_id, \n";
    $sql .= "           t_invent.ware_cd, \n";
    $sql .= "           t_invent.staff_name AS input_staff_name, \n";
    $sql .= "           t_contents.g_product_cd, \n";
    $sql .= "           t_contents.g_product_name, \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           t_contents.goods_cd, \n";
    $sql .= "           t_contents.goods_name, \n";
    $sql .= "           t_contents.stock_num, \n";
    $sql .= "           t_contents.tstock_num, \n";
    $sql .= "           t_contents.price, \n";
    $sql .= "           t_contents.tstock_num * t_contents.price AS money, \n";
    //$sql .= "           t_contents.stock_num - t_contents.tstock_num AS invent_diff, \n";
    $sql .= "           t_contents.tstock_num - t_contents.stock_num AS invent_diff, \n";
    $sql .= "           t_contents.staff_name, \n";
    $sql .= "           t_contents.cause \n";
    $sql .= "       FROM \n";
    $sql .= "           t_invent \n";
    $sql .= "           INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_invent.ware_id = ".$ary_ware_list_id[$i]." \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.invent_no = '$invent_no' \n";
    $sql .= "   ) \n";
    $sql .= "   AS a_invent \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_invent.ware_id, \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           t_contents.tstock_num, \n";
    $sql .= "           t_contents.tstock_num * t_contents.price AS money \n";
    $sql .= "       FROM \n";
    $sql .= "           t_invent \n";
    $sql .= "           INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_invent.ware_id = ".$ary_ware_list_id[$i]." \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.invent_no = '$last_no' \n";
    $sql .= "   ) \n";
    $sql .= "   AS b_invent \n";
    $sql .= "   ON a_invent.ware_id = b_invent.ware_id \n";
    $sql .= "   AND a_invent.goods_id = b_invent.goods_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   a_invent.ware_cd, \n";
    $sql .= "   a_invent.g_product_cd, \n";
    $sql .= "   a_invent.goods_cd \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $ary_ware_num[] = pg_num_rows($res);
    for ($j = 0; $j < $ary_ware_num[$i]; $j++){
        $ary_ware_data[$i][] = pg_fetch_array($res, $j);
    }
}


// 全倉庫
// GETに倉庫IDがあった場合は、全倉庫は表示しない
if ($get_id == null){
    $sql  = "SELECT \n";
    $sql .= "   a_invent.g_product_name, \n";                                                               // 0    商品分類名
    $sql .= "   a_invent.goods_name, \n";                                                                   // 1    商品名
    $sql .= "   SUM(a_invent.stock_num)                                             AS stock_num, \n";      // 2    帳簿数
    $sql .= "   SUM(a_invent.tstock_num)                                            AS tstock_num, \n";     // 3    実棚数
    $sql .= "   SUM(a_invent.invent_diff)                                           AS invent_diff, \n";    // 4    棚卸差異数
    $sql .= "   SUM(a_invent.price)                                                 AS price, \n";          // 5    棚卸単価
    $sql .= "   SUM(a_invent.money)                                                 AS money, \n";          // 6    棚卸金額
    $sql .= "   SUM(b_invent.tstock_num)                                            AS last_tstock_num, \n";// 7    前回在庫数
    $sql .= "   SUM(b_invent.money)                                                 AS last_money, \n";     // 8    前回在庫金額
    $sql .= "   SUM(a_invent.tstock_num) - SUM(COALESCE(b_invent.tstock_num, 0))    AS comp_num \n";        // 9    前回対比数
    //$sql .= "   SUM(a_invent.money)      - SUM(COALESCE(b_invent.money, 0))         AS comp_money \n";      // 10   前回対比金額
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_contents.g_product_cd, \n";
    $sql .= "           t_contents.g_product_name, \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           t_contents.goods_cd, \n";
    $sql .= "           t_contents.goods_name, \n";
    $sql .= "           SUM(t_contents.stock_num)                               AS stock_num, \n";
    $sql .= "           SUM(t_contents.tstock_num)                              AS tstock_num, \n";
    //$sql .= "           SUM(t_contents.stock_num) - SUM(t_contents.tstock_num)  AS invent_diff, \n";
    $sql .= "           SUM(t_contents.tstock_num) - SUM(t_contents.stock_num)  AS invent_diff, \n";
    $sql .= "           CASE \n";
    $sql .= "               WHEN SUM(t_contents.tstock_num) != 0 \n";
    $sql .= "               THEN ROUND(SUM(t_contents.tstock_num * t_contents.price) / SUM(t_contents.tstock_num), 2) \n";
    $sql .= "               ELSE NULL \n";
    $sql .= "           END                                                     AS price, \n";
    $sql .= "           SUM(t_contents.tstock_num * t_contents.price)           AS money \n";
    $sql .= "       FROM \n";
    $sql .= "           t_invent \n";
    $sql .= "           INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_invent.invent_no = '$invent_no' \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           t_contents.g_product_name, \n";
    $sql .= "           t_contents.g_product_cd, \n";
    $sql .= "           t_contents.goods_name, \n";
    $sql .= "           t_contents.goods_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS a_invent \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           SUM(t_contents.tstock_num) AS tstock_num, \n";
    $sql .= "           SUM(t_contents.tstock_num * t_contents.price) AS money \n";
    $sql .= "       FROM \n";
    $sql .= "           t_invent \n";
    $sql .= "           INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_invent.invent_no = '$last_no' \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_contents.goods_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS b_invent \n";
    $sql .= "   ON a_invent.goods_id = b_invent.goods_id \n";
    $sql .= "GROUP BY \n";
    $sql .= "a_invent.g_product_cd, \n";
    $sql .= "   a_invent.g_product_name, \n";
    $sql .= "   a_invent.goods_cd, \n";
    $sql .= "   a_invent.goods_name, \n";
    $sql .= "   a_invent.price \n";
    $sql .= "ORDER BY \n";
    $sql .= "   a_invent.g_product_cd, \n";
    $sql .= "   a_invent.goods_cd \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $total_num = pg_num_rows($res);
    $ary_ware_num[$ware_list_num] = $total_num;
    for ($i = 0; $i < $ary_ware_num[$ware_list_num]; $i++){
        $ary_ware_data[$ware_list_num][] = pg_fetch_array($res, $i);
    }
}


// 棚卸データが存在しない場合エラー
if ($ware_list_num <= 0 && $total_num <= 0){
    $err_mess = "該当する棚卸が存在しません。";
}


/****************************/
// 商品分類の重複を削除 && 商品分類計・倉庫計を算出
/****************************/
$page_data = $ary_ware_data;

// 倉庫でループ
for ($i = 0; $i <= $ware_list_num; $i++){

    // 倉庫内データでループ
    for ($j = 0; $j < $ary_ware_num[$i]; $j++){

        // 今と前の行の商品分類名が同じ場合
        if ($ary_ware_data[$i][$j]["g_product_name"] == $ary_ware_data[$i][$j-1]["g_product_name"]){

            // 数値を加算
            $stock_num_total        += $ary_ware_data[$i][$j]["stock_num"];         // 帳簿数
            $tstock_num_total       += $ary_ware_data[$i][$j]["tstock_num"];        // 実棚数
            $invent_diff_total      += $ary_ware_data[$i][$j]["invent_diff"];       // 棚卸差異数
            $price_total            += $ary_ware_data[$i][$j]["price"];             // 棚卸単価
            $money_total            += $ary_ware_data[$i][$j]["money"];             // 棚卸金額
            $last_tstock_num_total  += $ary_ware_data[$i][$j]["last_tstock_num"];   // 前回在庫数
            $last_money_total       += $ary_ware_data[$i][$j]["last_money"];        // 前回在庫金額
            $comp_num_total         += $ary_ware_data[$i][$j]["comp_num"];          // 前回対比数
            //$comp_money_total       += $ary_ware_data[$i][$j]["comp_money"];        // 前回対比金額
            $page_data[$i][$j][0] = null;

            // 今と次の行の商品分類名が違う場合
            if ($ary_ware_data[$i][$j]["g_product_name"] != $ary_ware_data[$i][$j+1]["g_product_name"]){
                // 商品分類計
                $g_product_total[$i][$j]  = array(
                    number_format($stock_num_total),                        // 帳簿数
                    number_format($tstock_num_total),                       // 実棚数
                    number_format($invent_diff_total),                      // 棚卸差異数
                    number_format($price_total, 2),                         // 棚卸単価
                    number_format($money_total, 2),                         // 棚卸金額
                    number_format($last_tstock_num_total),                  // 前回在庫数
                    number_format($last_money_total, 2),                    // 前回在庫金額
                    number_format($comp_num_total),                         // 前回対比数
                    //number_format($comp_money_total, 2),                    // 前回対比金額
                );
                // 商品分類計出力フラグtrue
                $page_data[$i][$j][90] = true;
                
            }

        // 今と次の行の商品分類名が違う場合
        }elseif ($ary_ware_data[$i][$j]["g_product_name"] != $ary_ware_data[$i][$j+1]["g_product_name"]){

            // 数値を代入
            $stock_num_total        = $ary_ware_data[$i][$j]["stock_num"];          // 帳簿数
            $tstock_num_total       = $ary_ware_data[$i][$j]["tstock_num"];         // 実棚数
            $invent_diff_total      = $ary_ware_data[$i][$j]["invent_diff"];        // 棚卸差異数
            $price_total            = $ary_ware_data[$i][$j]["price"];              // 棚卸単価
            $money_total            = $ary_ware_data[$i][$j]["money"];              // 棚卸金額
            $last_tstock_num_total  = $ary_ware_data[$i][$j]["last_tstock_num"];    // 前回在庫数
            $last_money_total       = $ary_ware_data[$i][$j]["last_money"];         // 前回在庫金額
            $comp_num_total         = $ary_ware_data[$i][$j]["comp_num"];           // 前回対比数
            //$comp_money_total       = $ary_ware_data[$i][$j]["comp_money"];         // 前回対比金額

            // 商品分類計
            $g_product_total[$i][$j] = array(
                number_format($ary_ware_data[$i][$j]["stock_num"]),         // 帳簿数
                number_format($ary_ware_data[$i][$j]["tstock_num"]),        // 実棚数
                number_format($ary_ware_data[$i][$j]["invent_diff"]),       // 棚卸差異数
                number_format($ary_ware_data[$i][$j]["price"], 2),          // 棚卸単価
                number_format($ary_ware_data[$i][$j]["money"], 2),          // 棚卸金額
                number_format($ary_ware_data[$i][$j]["last_tstock_num"]),   // 前回在庫数
                number_format($ary_ware_data[$i][$j]["last_money"], 2),     // 前回在庫金額
                number_format($ary_ware_data[$i][$j]["comp_num"]),          // 前回対比数
                //number_format($ary_ware_data[$i][$j]["comp_money"], 2),     // 前回対比金額
            );
            // 商品分類計出力フラグtrue
            $page_data[$i][$j][90] = true;

        // それ以外
        }else{

            // 数値を代入
            $stock_num_total        = $ary_ware_data[$i][$j]["stock_num"];          // 帳簿数
            $tstock_num_total       = $ary_ware_data[$i][$j]["tstock_num"];         // 実棚数
            $invent_diff_total      = $ary_ware_data[$i][$j]["invent_diff"];        // 棚卸差異数
            $price_total            = $ary_ware_data[$i][$j]["price"];              // 棚卸単価
            $money_total            = $ary_ware_data[$i][$j]["money"];              // 棚卸金額
            $last_tstock_num_total  = $ary_ware_data[$i][$j]["last_tstock_num"];    // 前回在庫数
            $last_money_total       = $ary_ware_data[$i][$j]["last_money"];         // 前回在庫金額
            $comp_num_total         = $ary_ware_data[$i][$j]["comp_num"];           // 前回対比数
            //$comp_money_total       = $ary_ware_data[$i][$j]["comp_money"];         // 前回対比金額
        }

        // 倉庫計
        $ware_total[$i][0] += $ary_ware_data[$i][$j]["stock_num"];          // 帳簿数
        $ware_total[$i][1] += $ary_ware_data[$i][$j]["tstock_num"];         // 実棚数
        $ware_total[$i][2] += $ary_ware_data[$i][$j]["invent_diff"];        // 棚卸差異数
        $ware_total[$i][3] += $ary_ware_data[$i][$j]["price"];              // 棚卸単価
        $ware_total[$i][4] += $ary_ware_data[$i][$j]["money"];              // 棚卸金額
        $ware_total[$i][5] += $ary_ware_data[$i][$j]["last_tstock_num"];    // 前回在庫数
        $ware_total[$i][6] += $ary_ware_data[$i][$j]["last_money"];         // 前回在庫金額
        $ware_total[$i][7] += $ary_ware_data[$i][$j]["comp_num"];           // 前回対比数
        //$ware_total[$i][8] += $ary_ware_data[$i][$j]["comp_money"];         // 前回対比金額

    }
}


/****************************/
// ナンバーフォーマット
/****************************/
// 倉庫でループ
for ($i = 0; $i <= $ware_list_num; $i++){

    // 倉庫内データでループ
    for ($j = 0; $j < $ary_ware_num[$i]; $j++){
        $page_data[$i][$j][2]   = number_format($page_data[$i][$j][2]);         // 帳簿数
        $page_data[$i][$j][3]   = number_format($page_data[$i][$j][3]);         // 実棚数
        $page_data[$i][$j][4]   = number_format($page_data[$i][$j][4]);         // 棚卸差異数
        $page_data[$i][$j][5]   = number_format($page_data[$i][$j][5], 2);      // 棚卸単価
        $page_data[$i][$j][6]   = number_format($page_data[$i][$j][6], 2);      // 棚卸金額
        $page_data[$i][$j][7]   = number_format($page_data[$i][$j][7]);         // 前回在庫数
        $page_data[$i][$j][8]   = number_format($page_data[$i][$j][8], 2);      // 前回在庫金額
        $page_data[$i][$j][9]   = number_format($page_data[$i][$j][9]);         // 前回対比数
        //$page_data[$i][$j][10]  = number_format($page_data[$i][$j][10], 2);     // 前回対比金額
    }

    $ware_total[$i][0]          = number_format($ware_total[$i][0]);            // 帳簿数
    $ware_total[$i][1]          = number_format($ware_total[$i][1]);            // 実棚数
    $ware_total[$i][2]          = number_format($ware_total[$i][2]);            // 棚卸差異数
    $ware_total[$i][3]          = number_format($ware_total[$i][3], 2);         // 棚卸単価
    $ware_total[$i][4]          = number_format($ware_total[$i][4], 2);         // 棚卸金額
    $ware_total[$i][5]          = number_format($ware_total[$i][5]);            // 前回在庫数
    $ware_total[$i][6]          = number_format($ware_total[$i][6], 2);         // 前回在庫金額
    $ware_total[$i][7]          = number_format($ware_total[$i][7]);            // 前回対比数
    //$ware_total[$i][8]          = number_format($ware_total[$i][8], 2);         // 前回対比金額

}


/****************************/
// CSVデータ作成
/****************************/
if($output_type == "2"){

    $csv_file_name = "棚卸一覧".date("Ymd").".csv";

    $csv_header = array(
        "棚卸日",
        "棚卸調査番号",
        "前回棚卸調査番号",
        "倉庫名",
        "商品分類名",
        "商品名",
        "帳簿数",
        "実棚数",
        "棚卸差異数",
        "棚卸単価",
        "棚卸金額",
        "前回在庫数",
        "前回在庫金額",
        "前回対比数",
        //"前回対比金額",
        "棚卸実施者",
        //"棚卸入力者",
        "差異原因",
    );

    $ary_ware_list_name[$ware_list_num] = "全倉庫";

    $s = 0;
    for($i = 0; $i <= $ware_list_num; $i++){
        for($j = 0; $j < count($ary_ware_data[$i]); $j++){
            $csv_data[$s] = array(
                (($s == 0) ? $invent_day : null),           // 棚卸日（）
                (($s == 0) ? $invent_no  : null),           // 棚卸調査番号
                (($s == 0) ? $last_no    : null),           // 前回棚卸調査番号
                $ary_ware_list_name[$i],                    // 倉庫名
                $ary_ware_data[$i][$j]["g_product_name"],   // 商品分類名
                $ary_ware_data[$i][$j]["goods_name"],       // 商品名
                $ary_ware_data[$i][$j]["stock_num"],        // 帳簿数
                $ary_ware_data[$i][$j]["tstock_num"],       // 実棚数
                $ary_ware_data[$i][$j]["invent_diff"],      // 棚卸差異数
                (($ary_ware_list_name[$i] == "全倉庫" && $ary_ware_data[$i][$j]["tstock_num"] == 0) ? 
                "-" : $ary_ware_data[$i][$j]["price"]),     // 棚卸単価（全倉庫で実棚数が0の場合はハイフン）
                $ary_ware_data[$i][$j]["money"],            // 棚卸金額
                $ary_ware_data[$i][$j]["last_tstock_num"],  // 前回在庫数
                $ary_ware_data[$i][$j]["last_money"],       // 前回在庫金額
                $ary_ware_data[$i][$j]["comp_num"],         // 前回対比数
                //$ary_ware_data[$i][$j]["comp_money"],       // 前回対比金額
                $ary_ware_data[$i][$j]["staff_name"],       // 棚卸実施者
                //$ary_ware_data[$i][$j]["input_staff_name"], // 棚卸入力者
                $ary_ware_data[$i][$j]["cause"],            // 差異原因
            );
            $s = $s+1;
        }
    }

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;   
}


/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
//$page_menu = Create_Menu_h('stock','2');

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'invent_day'    => "$invent_day",
    'ware_list_num' => $ware_list_num,
    'err_mess'      => "$err_mess",
    'invent_no'     => "$invent_no",
    'last_no'       => "$last_no",
));

if($ware_list_num != 0){
    foreach($ary_ware_list_name as $key => $value){
        $ary_ware_list_name[$key] = htmlspecialchars($value);
    }
    foreach($page_data as $key1 => $value1){
        foreach($value1 as $key2 => $value2){
            foreach($value2 as $key3 => $value3){
                $page_data[$key1][$key2][$key3] = htmlspecialchars($value3);
            }
        }
    }
}

$smarty->assign('ary_ware_list_name',$ary_ware_list_name);
$smarty->assign('page_data',$page_data);
$smarty->assign('g_product_total',$g_product_total);
$smarty->assign('ware_total',$ware_total);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
