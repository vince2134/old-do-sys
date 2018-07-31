<?php
/********************
 * 在庫照会
 *
 *
 * 変更履歴
 *    2006/07/10 (kaji)
 *      ・shop_gidをなくす
 *    2006/07/28 (watanabe-k)
 *      ・照会日の月、日を一桁の場合0埋めするように変更
 *    2006/08/07 (watanabe-k)
 *      ・商品分類追加
 *    2006/08/21 (watanabe-k)
 *      ・在庫金額をカンマ区切りで表示
 *      ・数量と金額の合計を表示
 *      ・略称の列は表示しない。
 *
 ********************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 *   2006/10/16  06-004        watanabe-k  在庫照会→発注入力へ画面遷移した場合、ランタイムエラーが発生する
 *   2006/11/06  06-041        watanabe-k  一度検索し、発注入力へ遷移した場合に選択した商品とは違うものが発注入力で表示されるバグの修正
 *   2006/12/06  ban_0010      suzuki      ・日付エラーメッセージ変更
                 ban_0012                  ・日付エラーチェック修正
 *   2007/02/22                watanabe-k  不要機能の削除
 *  2007-03-30                  fukuda      検索条件復元処理追加
 *  2007-04-09  その他No131     fukuda      ヘッダ部にリンクボタン設置
 *  2007/04/17   B0702-042     kajioka-h   ウィンドウタイトルに画面切替ボタンのHTMLが出力されていたのを修正
 *  2007/07/13                 watanabe-k  テーブル幅を縮める修正、サニタイジングできていないバグの修正
 *  2009/10/12                 hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *  2016/01/22                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応  
 */

$page_title = "在庫照会";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/ 
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_inquiry_day"  => "",  
    "form_g_goods"      => "",  
    "form_product"      => "",  
    "form_g_product"    => "",  
    "form_goods_cd"     => "",  
    "form_goods_name"   => "",  
    "form_goods_cname"  => "",  
    "form_attri_div"    => "",  
    "form_ware"         => "",  
    "form_stock_div"    => "",  
);

// 再遷移時に復元を除外するフォーム配列
$ary_pass_list = array(
    "order_button_flg"  => "",  
);

// 検索条件復元
Restore_Filter2($form, array("stock", "ord"), "form_show_button", $ary_form_list, $ary_pass_list);


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];


/****************************/
// 初期値設定
/****************************/


/****************************/
// フォームパーツ定義
/****************************/
// 照会日
Addelement_Date($form, "form_inquiry_day", "照会日", "-");

// Ｍ区分
$select_value = Select_Get($db_con,"g_goods");
$form->addElement("select", "form_g_goods", "", $select_value, $g_form_option_select);

// 管理区分
$select_value = Select_Get($db_con, "product");
$form->addElement("select", "form_product", "", $select_value, $g_form_option_select);

// 商品分類
$select_value = Select_Get($db_con, "g_product");
$form->addElement("select", "form_g_product", "", $select_value, $g_form_option_select);

// 商品コード
$form->addElement("text", "form_goods_cd", "", "size=\"10\" maxLength=\"8\" $g_form_option style=\"$g_form_style\"");

// 商品名
$form->addElement("text", "form_goods_name", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// 商品名略称
$form->addElement("text", "form_goods_cname", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// 属性区分
$attri_value = array(null => null, 1 => "製品", 2 => "部品", 3 => "管理", 4 => "道具・他", 5 => "保険");
$form->addElement("select", "form_attri_div", "", $attri_value, $g_form_option_select);

// 在庫区分
$stock_value = array(null => "", "在庫有り", "在庫０", "マイナス在庫");
$form->addElement("select", "form_stock_div", "", $stock_value, $g_form_option_select);

// 倉庫
$select_value = Select_Get($db_con, "ware");
$form->addElement("select", "form_ware",  "", $select_value, $g_form_option_select);

// 商品グループ
$select_value = Select_Get($db_con, "goods_gr");
$form->addElement("select", "form_goods_gr", "", $select_value, $g_form_option_select);

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示", "");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// 発注入力へボタン
$form->addElement("button", "form_order_button", "発注入力へ",
    "onClick=\"javascript:Button_Submit('order_button_flg', '".$_SERVER["PHP_SELF"]."', 'true', this); \" $disabled"
);

// 在庫照会リンクボタン
$form->addElement("button", "4_101_button", "在庫照会", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

// 在庫受払リンクボタン
$form->addElement("button", "4_105_button", "在庫受払", "onClick=\"location.href('./1-4-105.php');\"");

// 滞留在庫一覧リンクボタン
$form->addElement("button", "4_110_button", "滞留在庫一覧", "onClick=\"javascript:location.href('./1-4-110.php')\"");

// 処理フラグ
$form->addElement("hidden", "order_button_flg");

// エラーセット用
$form->addElement("text", "order_err1");


/*****************************/
// 表示ボタン押下処理
/*****************************/
if ($_POST["form_show_button"] != null){

    // 日付POSTデータの0埋め
    $_POST["form_inquiry_day"] = Str_Pad_Date($_POST["form_inquiry_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■照会日
    // エラーメッセージ
    $err_msg = "照会日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_inquiry_day", $err_msg);

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $form->validate();
    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// 1. 表示ボタン押下＋エラーなし時
// 2. ページ切り替え時
/****************************/
if (($_POST["form_show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["form_show_button"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_inquiry_day"] = Str_Pad_Date($_POST["form_inquiry_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $inquiry_day_y  = $_POST["form_inquiry_day"]["y"];
    $inquiry_day_m  = $_POST["form_inquiry_day"]["m"];
    $inquiry_day_d  = $_POST["form_inquiry_day"]["d"];
    $inquiry_day    = $inquiry_day_y."-".$inquiry_day_m."-".$inquiry_day_d;
    $g_goods        = $_POST["form_g_goods"];
    $product        = $_POST["form_product"];
    $g_product      = $_POST["form_g_product"];
    $goods_cd       = $_POST["form_goods_cd"];
    $goods_name     = $_POST["form_goods_name"];
    $goods_cname    = $_POST["form_goods_cname"];
    $attri_div      = $_POST["form_attri_div"];
    $stock_div      = $_POST["form_stock_div"];
    $ware           = $_POST["form_ware"];
    $goods_gr       = $_POST["form_goods_gr"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    /* FROM */
    $sql = null;

    // 照会日に未来の日付が指定された場合
    if ($inquiry_day != "--" && $inquiry_day > date("Y-m-d")){

        $sql .= "( \n";
        $sql .= "   SELECT \n";
        $sql .= "       t_stock.ware_id, \n";
        $sql .= "       t_stock.goods_id, \n";
        $sql .= "       t_stock.stock_num + COALESCE(t_stock1_io.stock1_io_data, 0) \n";
        $sql .= "                         - COALESCE(t_stock2_io.stock2_io_data, 0) \n";
        $sql .= "       AS stock_total \n";
        $sql .= "   FROM \n";
        // 在庫数
        $sql .= "       t_stock \n";
        // 発注残数
        $sql .= "       LEFT JOIN \n";
        $sql .= "       ( \n";
        $sql .= "           SELECT \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id, \n";
        $sql .= "               SUM( \n";
        $sql .= "                   CASE io_div \n";
        $sql .= "                       WHEN 1 THEN num *  1 \n";
        $sql .= "                       WHEN 2 THEN num * -1 \n";
        $sql .= "                   END \n";
        $sql .= "               ) \n";
        $sql .= "               AS stock1_io_data \n";
        $sql .= "           FROM \n";
        $sql .= "               t_stock_hand \n";
        $sql .= "           WHERE \n";
        $sql .= "               work_div = '3' \n";
        $sql .= "           AND \n";
        $sql .= "               shop_id = $shop_id \n";
        $sql .= "           AND \n";
        $sql .= "               work_day <= '$inquiry_day' \n";
        $sql .= "           GROUP BY \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id \n";
        $sql .= "       ) \n";
        $sql .= "       AS t_stock1_io \n";
        $sql .= "       ON t_stock.goods_id = t_stock1_io.goods_id \n";
        $sql .= "       AND t_stock.ware_id = t_stock1_io.ware_id \n";
        // 引当数
        $sql .= "       LEFT JOIN \n";
        $sql .= "       ( \n";
        $sql .= "           SELECT \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id, \n";
        $sql .= "               SUM( \n";
        $sql .= "                   CASE io_div \n";
        $sql .= "                       WHEN 1 THEN num * -1 \n";
        $sql .= "                       WHEN 2 THEN num *  1 \n";
        $sql .= "                   END \n";
        $sql .= "               ) \n";
        $sql .= "               AS stock2_io_data \n";
        $sql .= "           FROM \n";
        $sql .= "               t_stock_hand \n";
        $sql .= "           WHERE \n";
        $sql .= "               work_div = '1' \n";
        $sql .= "           AND \n";
        $sql .= "               shop_id = $shop_id \n";
        $sql .= "           AND \n";
        $sql .= "               work_day <= '$inquiry_day' \n";
        $sql .= "           GROUP BY \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id \n";
        $sql .= "       ) \n";
        $sql .= "       AS t_stock2_io \n";
        $sql .= "       ON t_stock.goods_id = t_stock2_io.goods_id \n";
        $sql .= "       AND t_stock.ware_id = t_stock2_io.ware_id \n";
        $sql .= "   WHERE \n";
        $sql .= "       t_stock.shop_id = $shop_id \n"; 
        $sql .= ") \n";
        $sql .= "AS t_stock_total \n";

    // 照会日に過去の日付が指定された場合
    }elseif ($inquiry_day != "--" && date("Y-m-d") > $inquiry_day){

        $sql  = "( \n";
        $sql .= "   SELECT \n";
        $sql .= "       t_stock.ware_id, \n";
        $sql .= "       t_stock.goods_id, \n";
        $sql .= "       t_stock.stock_num - COALESCE(t_stock1_io.stock1_io_data,0) \n";
        $sql .= "       AS stock_total \n";
        $sql .= "   FROM \n";
        $sql .= "       t_stock \n";
        $sql .= "       LEFT JOIN \n";
        $sql .= "       ( \n";
        $sql .= "           SELECT \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id, \n";
        $sql .= "               SUM( \n";
        $sql .= "                   CASE io_div \n";
        $sql .= "                       WHEN 1 THEN num *  1 \n";
        $sql .= "                       WHEN 2 THEN num * -1 \n";
        $sql .= "                   END \n";
        $sql .= "               ) \n";
        $sql .= "               AS stock1_io_data \n";
        $sql .= "           FROM \n";
        $sql .= "               t_stock_hand \n";
        $sql .= "           WHERE \n";
        $sql .= "               work_div <> '1' \n";
        $sql .= "           AND \n";
        $sql .= "               work_div <> '3' \n";
        $sql .= "           AND \n";
        $sql .= "               shop_id = $shop_id \n";
        $sql .= "           AND \n";
        $sql .= "               '$inquiry_day' < work_day \n";
        $sql .= "           AND \n";
        $sql .= "               work_day <= '".date("Y-m-d")."' \n";
        $sql .= "           GROUP BY \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id \n";
        $sql .= "       ) \n";
        $sql .= "       AS t_stock1_io \n";
        $sql .= "       ON t_stock.goods_id = t_stock1_io.goods_id \n";
        $sql .= "       AND t_stock.ware_id = t_stock1_io.ware_id \n";
        $sql .= "   WHERE \n";
        $sql .= "       t_stock.shop_id = $shop_id \n";
        $sql .= ") \n";
        $sql .= "AS t_stock_total \n";

    // 照会日に本日の日付が指定されたまたは指定がない場合
    }elseif ($inquiry_day == "--" || $inquiry_day == date("Y-m-d")){

        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_stock.ware_id, \n";
        $sql .= "           t_stock.goods_id, \n";
        $sql .= "           t_stock.stock_num AS stock_total \n";
        $sql .= "       FROM \n";
        $sql .= "           t_stock \n";
        $sql .= "       WHERE \n";
        $sql .= "           shop_id = $shop_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS t_stock_total \n";

    }

    $from_sql = $sql;

    /* WHERE */
    $sql = null;

    // Ｍ区分
    $sql .= ($g_goods != null) ? "AND t_goods.g_goods_id = $g_goods \n" : null;
    // 管理区分
    $sql .= ($product != null) ? "AND t_goods.product_id = $product \n" : null;
    // 商品分類
    $sql .= ($g_product != null) ? "AND t_goods.g_product_id = $g_product \n" : null;
    // 商品コード
    $sql .= ($goods_cd != null) ? "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
    // 商品名
    $sql .= ($goods_name != null) ? "AND t_goods.goods_name LIKE '%$goods_name%' \n" : null;
    // 商品名略称
    $sql .= ($goods_cname != null) ? "AND t_goods.goods_cname LIKE '%$goods_cname%' \n" : null;
    // 属性区分
    $sql .= ($attri_div != null) ? "AND attri_div = '$attri_div' \n" : null;
    // 在庫区分「マイナス在庫」
    if ($stock_div == "2"){
        $sql .= "AND stock_total < 0 \n";
    // 在庫区分「在庫あり」
    }elseif ($stock_div == "0"){
        $sql .= "AND stock_total > 0 \n";
    // 在庫区分「在庫０」
    }elseif ($stock_div == "1"){
        $sql .= "AND stock_total = 0 \n";
    }
    // 倉庫
    $sql .= ($ware != null) ? "AND t_stock_total.ware_id = $ware \n" : null;
    // 商品グループ
    if ($goods_gr != null){
        $sql .= "AND t_goods_gr.goods_id = t_goods.goods_id \n";
        $sql .= "AND t_goods_gr.goods_gid = $goods_gr \n";
    }

    // 変数詰め替え
    $where_sql = $sql;

}


/****************************/
// 一覧データ取得
/****************************/
if($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_g_goods.g_goods_name, \n";
    $sql .= "   t_product.product_name, \n";
    $sql .= "   t_g_product.g_product_name, \n";
    $sql .= "   t_goods.goods_name, \n";
    $sql .= "   t_ware.ware_name, \n";
    $sql .= "   stock_total, \n";
    $sql .= "   t_price.r_price, \n";
    $sql .= "   stock_total * t_price.r_price AS stock_price, \n";
    $sql .= "   t_work_day.last_work_day, \n";
    $sql .= "   t_stock_total.ware_id, \n";
    $sql .= "   t_stock_total.goods_id \n";
    $sql .= " FROM \n";
    $sql .= $from_sql;
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           ware_id, \n";
    $sql .= "           goods_id, \n";
    $sql .= "           MAX(work_day) AS last_work_day \n";
    $sql .= "       FROM \n";
    $sql .= "           t_stock_hand \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           work_day <= '".date("Y-m-d")."' \n";
    $sql .= "       AND \n";
    $sql .= "           work_div IN ('2', '4') \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           ware_id, \n";
    $sql .= "           goods_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_work_day \n";
    $sql .= "   ON t_stock_total.ware_id = t_work_day.ware_id \n";
    $sql .= "   AND t_stock_total.goods_id = t_work_day.goods_id \n";
    $sql .= "   INNER JOIN t_goods ON t_goods.goods_id = t_stock_total.goods_id \n";
    $sql .= "   INNER JOIN t_g_goods ON t_g_goods.g_goods_id = t_goods.g_goods_id \n";
    $sql .= "   INNER JOIN t_product ON t_product.product_id = t_goods.product_id \n";
    $sql .= "   INNER JOIN t_g_product ON t_g_product.g_product_id = t_goods.g_product_id \n";
    $sql .= "   INNER JOIN t_ware ON t_stock_total.ware_id = t_ware.ware_id \n";
    $sql .= "   INNER JOIN t_price ON t_price.goods_id = t_stock_total.goods_id \n";
    #2009-10-12 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

    //商品グループが指定された場合
    if($goods_gr != null){
    $sql .= "   INNER JOIN t_goods_gr ON t_goods.goods_id = t_goods_gr.goods_id \n";
    }
    $sql .= "WHERE \n";
    #2009-10-12 hashimoto-y
    #$sql .= "   t_goods.stock_manage = '1' \n";
    $sql .= "    t_goods_info.stock_manage = '1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_goods_info.shop_id = $shop_id ";

    $sql .= "AND \n";
    $sql .= "   t_goods.public_flg = 't' \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.compose_flg = 'f' \n";
    $sql .= "AND \n";
    $sql .= "   t_price.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_price.rank_cd = '1' \n";
    $sql .= $where_sql;
    $sql .= " ORDER BY \n";
    $sql .= "   t_g_goods.g_goods_cd, \n";
    $sql .= "   t_product.product_cd, \n";
    $sql .= "   t_g_product.g_product_id, \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_goods.attri_div, \n";
    $sql .= "   t_ware.ware_cd \n";

    //ヒット件数
    $total_sql = $sql.";";
    $result = Db_Query($db_con,$total_sql);
    $total_count = pg_num_rows($result);

    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $match_count = pg_num_rows($result);

    for($i = 0; $i < $match_count; $i++){
        $page_data[] = pg_fetch_array($result, $i, PGSQL_NUM);

        //金額と終了の合計を表示
        $num_total = bcadd($num_total, $page_data[$i][6]);
        $money_total = bcadd($money_total, $page_data[$i][8]);


        //サニタイジング
        $page_data[$i][1] = htmlspecialchars($page_data[$i][1]);
        $page_data[$i][2] = htmlspecialchars($page_data[$i][2]);
        $page_data[$i][3] = htmlspecialchars($page_data[$i][3]);
        $page_data[$i][4] = htmlspecialchars($page_data[$i][4]);
        $page_data[$i][5] = htmlspecialchars($page_data[$i][5]);



        //-の場合は表示色を赤に設定
        if($page_data[$i][6] < 0){
            $page_data[$i][6] = number_format($page_data[$i][6]);
            $page_data[$i][6] = "<font color=\"red\">".$page_data[$i][6]."</font>";
        }else{
            $page_data[$i][6] = number_format($page_data[$i][6]);
        }

        $page_data[$i][7] = number_format($page_data[$i][7],2);
        if($page_data[$i][8] < 0){
            $page_data[$i][8] = number_format($page_data[$i][8]);
            $page_data[$i][8] = "<font color=\"red\">".$page_data[$i][8]."</font>";
        }else{
            $page_data[$i][8] = number_format($page_data[$i][8]);
        }
    }

    if($num_total < 0){
        $num_total = number_format($num_total);
        $num_total = "<font color=\"red\">".$num_total."</font>";
    }else{
          $num_total = number_format($num_total);
    }
    if($money_total < 0){
        $money_total = number_format($money_total);
        $money_total = "<font color=\"red\">".$money_total."</font>";
    }else{
        $money_total = number_format($money_total);
    }

}

/****************************/
// ヘッダに表示する商品グループ名を抽出
/****************************/
if($goods_gr != null){
    $sql  = "SELECT";
    $sql .= "   goods_gname";
    $sql .= " FROM";
    $sql .= "   t_goods_gr";
    $sql .= " WHERE";
    $sql .= "   goods_gid = $goods_gr";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);    
    $goods_gr_name = pg_fetch_result($result,0,0);
}

/****************************/
//チェックボックス作成
/****************************/
//発注入力チェック
$form->addElement(
    "checkbox", "form_order_all_check", '', '発注入力',"
    onClick=\"javascript:All_check('form_order_all_check','form_order_check',$match_count)\""
);

for($i = 0; $i < $match_count; $i++){
    $form->addElement("checkbox", "form_order_check[$i]","","","");
}


/****************************/
// 発注ボタン押下処理
/****************************/
if ($_POST["order_button_flg"] == "true" && $_POST["form_show_button"] == null){

    // 未チェック時
    if (count($_POST["form_order_check"]) == 0){
        $form->setElementError("order_err1", "発注する商品を選択してください。");
        $ord_err_flg = true;
    }

    // エラーがない場合
    if ($ord_err_flg != true){

        /****************************/
        // 発注商品IDを取得
        /****************************/
        for ($i = 0; $i < $match_count; $i++){
            if ($_POST["form_order_check"][$i] == 1){
                $order_goods_id[] = $page_data[$i][11];
            }
        }
        //重複を纏める
        asort($order_goods_id);
        $order_goods_id = array_values(array_unique($order_goods_id));

        /****************************/
        // GETする値を生成
        /****************************/
        $j = 0;
        for ($i = 0; $i < count($order_goods_id); $i++){
            $get_goods_id .= "order_goods_id[$j]=".$order_goods_id[$i];
            if ($i != count($order_goods_id)-1){
                $get_goods_id .= "&";
                $j = $j+1;
            }else{
                break;
            }
        }

        // 発注入力へボタン押下フラグをクリア
        $clear_hdn["order_button_flg"] = "";
        $form->setConstants($clear_hdn);

        header("Location: ".HEAD_DIR."buy/1-3-102.php?$get_goods_id");

    }

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
//$page_menu = Create_Menu_h('stock','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex["4_101_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["4_105_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["4_110_button"]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
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
    'goods_gr_name' => "$goods_gr_name",
	'day'           => "$inquiry_day",
    'match_count'   => "$match_count",
    'num_total'     => "$num_total",
    'money_total'   => "$money_total",
    "err_flg"       => "$err_flg",
));
$smarty->assign('page_data',$page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
