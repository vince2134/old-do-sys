<?php

/**
 * 商品別ABC分析用のクエリ作成（本部用）
 *
 * 変更履歴
 * 1.0.0 (2007/11/17) 新規作成 <br>
 * 1.0.1 (2007/12/01) ショップ別商品情報テーブルと結合するように修正<br>
 *
 * @author     watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @param      conection    $db_con             DBコネクション
 * @param      array        $form_data          画面で入力された検索条件を保持した$_POST
 *
 * @return     resource     $result             クエリ検索結果
 *
 */
function Select_Goods_Abc_Amount ( $db_con, $form_data) {
    $shop_id = $_SESSION["client_id"];      //ショップID
    $trade_id   = "11, 15, 61";             //取引区分

    /***************************/
    //条件作成
    /***************************/
    //表示対象が指定された場合
    if($form_data["form_out_range"] == "1"){
        $where  = ($where === null) ? "WHERE \n" : "AND \n";
        $where .= "   t_sale_data.sale_amount != 0 \n";
    }

    //Ｍ区分が指定された場合
    if($form_data["form_g_goods"] != null){
        $where .= ($where === null) ? "WHERE \n" : "AND \n";
        $where .= "   t_goods.g_goods_id = ".$form_data["form_g_goods"]." \n";
    }

    //管理区分が指定された場合
    if($form_data["form_product"] != null){
        $where .= ($where === null) ? "WHERE \n" : "AND \n";
        $where .= "   t_goods.product_id = ".$form_data["form_product"]." \n";
    }

    //商品分類が指定された場合
    if($form_data["form_g_product"] != null){
        $where .= ($where === null) ? "WHERE \n" : "AND \n";
        $where .= "   t_goods.g_product_id = ".$form_data["form_g_product"]." \n";
    }
    /****************************/
    //クエリ作成
    /****************************/
    $sql =  "SELECT \n"
           ."   t_goods.goods_id AS id, \n"                                             //id
           ."   t_goods.goods_cd AS cd, \n"                                             //コード
           ."   COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name AS name, \n"
           ."   SUM(COALESCE(t_sale_data.sale_amount, 0)) AS net_amount, \n"            //売上金額
           ."   null AS rank_cd,\n"                                                     //FC・取引先区分コード（NULL）
           ."   null As rank_name\n"                                                    //FC・取引先区分名（NULL）
           ."FROM \n"
           ."   t_goods \n"
           ."       INNER JOIN \n"
           ."   t_goods_info \n"
           ."   ON t_goods.goods_id = t_goods_info.goods_id \n"
           ."   AND t_goods_info.shop_id = " . $_SESSION['client_id'] . "\n";

        //データ抽出用テーブル
        $start_day = date('Ymd',
                mktime(0,0,0,$form_data["form_trade_ym_s"]["m"], 1, $form_data["form_trade_ym_s"]["y"])
            );

        $end_day = date('Ymd',
                mktime(0,0,0,$form_data["form_trade_ym_s"]["m"]+$form_data["form_trade_ym_e_abc"], 0, $form_data["form_trade_ym_s"]["y"])
            );

    $sql .= "       LEFT JOIN \n"
           ."   ( \n"
           ."   SELECT \n"
           ."       t_sale_d.goods_id, \n"
           ."       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.sale_amount \n"
           ."               ELSE -1 * t_sale_d.sale_amount \n"
           ."           END \n"
           ."       ) AS sale_amount \n"
           ."   FROM \n"
           ."       t_sale_h \n"
           ."           INNER JOIN \n"
           ."       t_sale_d \n"
           ."       ON t_sale_h.sale_id = t_sale_d.sale_id \n"
           ."   WHERE \n"
           ."       t_sale_h.shop_id   = ".$shop_id." \n"
           ."       AND \n"
           ."       t_sale_h.sale_day >= '".$start_day."' \n"
           ."       AND \n"
           ."       t_sale_h.sale_day <= '".$end_day."' \n"
           ."       AND \n"
           ."       t_sale_d.goods_id IS NOT NULL \n";

                    //抽出対象が選択された場合
                    if($form_data["form_out_abstract"] == "1"){
    $sql .= "   AND \n"
           ."   t_sale_h.client_id != 93 \n";
                    }

    $sql .= "   GROUP BY t_sale_d.goods_id \n"
           ."   ) AS t_sale_data \n"
           ."   ON t_goods_info.goods_id = t_sale_data.goods_id \n"
           ."       LEFT JOIN \n"
           ."   t_g_product \n"
           ."   ON t_goods.g_product_id = t_g_product.g_product_id \n"
           .$where;

    $sql .= "GROUP BY \n"
           ."   id,\n"
           ."   cd, \n"
           ."   name \n"
           ."ORDER BY \n"
           ."   net_amount DESC\n"
           .";";

    $result = Db_Query($db_con, $sql);

//    print_array($sql);

    return $result; 
}

/**
 * 商品別ABC分析用のクエリ作成（FC用）
 *
 * 変更履歴
 * 1.0.0 (2007/12/01) 新規作成 <br>
 *
 * @author     watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @param      conection    $db_con             DBコネクション
 * @param      array        $form_data          画面で入力された検索条件を保持した$_POST
 *
 * @return     resource     $result             クエリ検索結果
 *
 */
function Select_Goods_Abc_Amount_Fc ( $db_con, $form_data) {
    $shop_id = $_SESSION["client_id"];      //ショップID
    $trade_id   = "11, 15, 61";             //取引区分

    //条件作成(商品用)
    //表示対象が指定された場合
    if($form_data["form_out_range"] == "1"){
        $goods_where  = ($goods_where === null) ? "WHERE \n" : "AND \n";
        $goods_where .= "   t_sale_data.sale_amount != 0 \n";
    }

    //Ｍ区分が指定された場合
    if($form_data["form_g_goods"] != null){
        $goods_where .= ($goods_where === null) ? "WHERE \n" : "AND \n";
        $goods_where .= "   t_goods.g_goods_id = ".$form_data["form_g_goods"]." \n";
    }

    //管理区分が指定された場合
    if($form_data["form_product"] != null){
        $goods_where .= ($goods_where === null) ? "WHERE \n" : "AND \n";
        $goods_where .= "   t_goods.product_id = ".$form_data["form_product"]." \n";
    }

    //商品分類が指定された場合
    if($form_data["form_g_product"] != null){
        $goods_where .= ($goods_where === null) ? "WHERE \n" : "AND \n";
        $goods_where .= "   t_goods.g_product_id = ".$form_data["form_g_product"]." \n";
    }

    //条件作成(サービス用)
    //表示対象が指定された場合
    if($form_data["form_out_range"] == "1"){
        $serv_where .= ($serv_where === null) ? "WHERE \n" : "AND \n";
        $serv_where .= "   t_sale_data.sale_amount != 0 \n";
    }

    /****************************/
    //クエリ作成
    /****************************/
    $sql =  "SELECT \n"
           ."   t_goods.goods_id AS id, \n"                                         //id
           ."   t_goods.goods_cd AS cd, \n"                                         //コード
           ."   CASE \n"
           ."        WHEN t_goods.compose_flg = true THEN t_goods.goods_name \n"
           ."        ELSE COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name \n"
           ."   END AS name, \n"                                                    //商品名
           ."   COALESCE(t_sale_data.sale_amount, 0) AS net_amount, \n"             //売上金額
           ."   null AS rank_cd,\n"                                                 //FC・取引先区分コード（NULL）
           ."   null As rank_name\n"                                                //FC・取引先区分名（NULL）
           ."FROM \n"
           ."   t_goods \n"
           ."       INNER JOIN \n"
           ."   t_goods_info \n"
           ."   ON t_goods.goods_id = t_goods_info.goods_id \n"
           ."   AND t_goods_info.shop_id = " . $_SESSION['client_id'] . "\n"; 

        //データ抽出用テーブル
        $start_day = date('Ymd',
                mktime(0,0,0,$form_data["form_trade_ym_s"]["m"], 1, $form_data["form_trade_ym_s"]["y"])
            );

        $end_day = date('Ymd',
                mktime(0,0,0,$form_data["form_trade_ym_s"]["m"]+$form_data["form_trade_ym_e_abc"], 0, $form_data["form_trade_ym_s"]["y"])
            );

    $sql .= "       LEFT JOIN \n"
           ."   ( \n"
           ."   SELECT \n"
           ."       t_sale_d.goods_id, \n"
           ."       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.sale_amount \n"
           ."               ELSE -1 * t_sale_d.sale_amount \n"
           ."           END \n"
           ."       ) AS sale_amount \n"
           ."   FROM \n"
           ."       t_sale_h \n"
           ."           INNER JOIN \n"
           ."       t_sale_d \n"
           ."       ON t_sale_h.sale_id = t_sale_d.sale_id \n"
           ."   WHERE \n"
           ."       t_sale_h.shop_id   = ".$shop_id." \n"
           ."       AND \n"
           ."       t_sale_h.sale_day >= '".$start_day."' \n"
           ."       AND \n"
           ."       t_sale_h.sale_day <= '".$end_day."' \n"
           ."       AND \n"
           ."       t_sale_d.goods_id IS NOT NULL \n";

    $sql .= "   GROUP BY t_sale_d.goods_id \n"
           ."   ) AS t_sale_data \n"
           ."   ON t_goods_info.goods_id = t_sale_data.goods_id \n"
           ."       LEFT JOIN \n"
           ."   t_g_product \n"
           ."   ON t_goods.g_product_id = t_g_product.g_product_id \n"
           . $goods_where;




    //検索条件によってはサービスを抽出しない。
    switch ($form_data) {
        case $form_data["form_g_goods"]       != null : //Ｍ区分が指定された場合
        case $form_data["form_product"]       != null : //管理区分が指定された場合
        case $form_data["form_g_product"]     != null : //商品分類が指定された場合
            break;
        default:

    //サービスを抽出
    $sql .= "UNION \n"
           ."SELECT \n"
           ."   t_serv.serv_id AS id, \n"                               //サービスid
           ."   t_serv.serv_cd AS cd, \n"                               //サービスコード
           ."   t_serv.serv_name AS name, \n"                           //サービス名
           ."   COALESCE(t_sale_data.sale_amount, 0) AS net_amount, \n" //売上金額
           ."   null AS rank_cd,\n"                                     //FC・取引先区分コード（NULL）
           ."   null As rank_name\n"                                    //FC・取引先区分名（NULL）
           ."FROM \n"
           ."   t_serv \n"
           ."       LEFT JOIN \n"
           ."   ( \n"
           ."   SELECT \n"
           ."       t_sale_d.serv_id, \n"
           ."       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.sale_amount \n"
           ."               ELSE -1 * t_sale_d.sale_amount \n"
           ."           END \n"
           ."       ) AS sale_amount \n"
           ."   FROM \n"
           ."       t_sale_h \n"
           ."           INNER JOIN \n"
           ."       t_sale_d \n"
           ."       ON t_sale_h.sale_id = t_sale_d.sale_id \n"
           ."   WHERE \n"
           ."       t_sale_h.shop_id   = ".$shop_id." \n"
           ."       AND \n"
           ."       t_sale_h.sale_day >= '".$start_day."' \n"
           ."       AND \n"
           ."       t_sale_h.sale_day <= '".$end_day."' \n"
           ."       AND \n"
           ."       t_sale_d.goods_id IS NULL \n"  //商品IDがないものだけを抽出
           ."   GROUP BY t_sale_d.serv_id \n"
           ."   ) AS t_sale_data \n"
           ."   ON t_serv.serv_id = t_sale_data.serv_id \n"
           .    $serv_where;


    }//switch終了

    $sql .= "ORDER BY \n"
           ."   net_amount DESC\n"
           .";";


    $result = Db_Query($db_con, $sql);

 //   print_array($sql);

    return $result;
}

/**
 *
 * 概要 FC/得意先別と業種別 ABC分析用クエリ
 *
 * 変更履歴 <br>
 * 2007-11-23   aizawa-m    新規作成<br>
 * 2007-11-24   aizawa-m    金額0以外の場合の判定を追加<br>
 *
 * @param       $db_con     DBコネクション
 * @param       $form_data  POSTされた値
 * @param       $div        業種の場合="type"を指定する
 *
 * @return      $result     クエリ結果のリソース
 *
 */
function Select_Customer_Type_Abc_Amount($db_con, $form_data, $div="") {

    // セッションから取得
    $client_id  = $_SESSION["client_id"];   //ショップID
    $group_kind = $_SESSION["group_kind"];  //グループ種別

    // 検索用に値を取得
    $start_y    = $form_data["form_trade_ym_s"]["y"];       // 開始年
    $start_m    = $form_data["form_trade_ym_s"]["m"];       // 開始月
    $period     = $form_data["form_trade_ym_e_abc"];        // 集計期間
    $rank_cd    = $form_data["form_rank"];                  // FC・取引先区分
    $out_abstract   = $form_data["form_out_abstract"];      // 抽出対象
    $client_gr_id   = $form_data["form_client_gr"]["cd"];   // グループコード
    $client_gr_name = $form_data["form_client_gr"]["name"]; // グループ名
    $out_range      = $form_data["form_out_range"];         // 表示対象

    //-- 本部の場合
    if ( $group_kind == "1") {
        $client_div = "3";  //取引先区分（FC）
    } else {
        $client_div = "1";  //取引先区分（得意先)
    }

    //-- 業種別の場合
    if ($div == "type") {
        $from_tbl       = "t_lbtype";   // 大分類業種マスタ
        $group_by_item  = "id,cd,name \n"; // GROUP BY する項目
    } else {
        $from_tbl       = "t_client";   // 取引先マスタ
        $group_by_item  = "id,cd,name,t_rank.rank_cd,rank_name \n";
    }

    /**************************/
    // クエリ作成
    /**************************/
    $sql = "SELECT \n";
    //-- 業種別の場合
    if ( $div == "type" ) {
        $sql.= "    t_lbtype.lbtype_id AS id, \n";      //大分類業種ID
        $sql.= "    t_lbtype.lbtype_cd AS cd, \n";      //大分類業種コード
        $sql.= "    t_lbtype.lbtype_name AS name, \n";  //大分類業種名
    } else {
        $sql.= "    t_client.client_id AS id, \n";      // 得意先ID
        $sql.= "    t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";// 得意先コード
        $sql.= "    t_client.client_cname AS name, \n"; // 得意先名（略称）
        $sql.= "    t_rank.rank_cd AS rank_cd, \n";     // FC・取引先区分
        $sql.= "    t_rank.rank_name AS rank_name, \n";  // FC・取引先区分名
    }
    $sql.= "    SUM( COALESCE(t_sale_h.net_amount,0)) AS net_amount \n";      //売上金額

    $sql.= "FROM \n";
    $sql.= "    $from_tbl \n";

    //-- 業種別の場合
    if ( $div == "type"){
        $sql.= "INNER JOIN t_sbtype \n";    // 小分類マスタ
        $sql.= "    ON t_lbtype.lbtype_id = t_sbtype.lbtype_id \n";
        $sql.= "INNER JOIN t_client \n";    // 取引先マスタ
        $sql.="     ON t_sbtype.sbtype_id = t_client.sbtype_id \n";
    }

    // 集計期間の開始日を取得
    $start_date  = date("Ymd", mktime(0, 0, 0, $start_m, 1, $start_y));
    $end_date    = date("Ymd", mktime(0, 0, 0, $start_m + $period , 0, $start_y));

    // 売上ヘッダテーブルと結合
    $sql.= "    LEFT JOIN ( \n";
    $sql.= "        SELECT \n";
    $sql.= "            t_sale_h.client_id, \n";
    $sql.= "            SUM ( \n";
    $sql.= "                CASE \n";
    $sql.= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN net_amount \n";
    $sql.= "                    ELSE -1 * net_amount \n";
    $sql.= "                END \n";
    $sql.= "            ) AS net_amount \n";
    $sql.= "        FROM \n";
    $sql.= "            t_sale_h\n";
    $sql.= "        WHERE \n";
    $sql.= "            t_sale_h.shop_id = $client_id \n";
    $sql.= "        AND \n";
    $sql.= "            t_sale_h.sale_day >= '$start_date' \n"; // 集計期間開始
    $sql.= "        AND \n";
    $sql.= "            t_sale_h.sale_day <= '$end_date' \n";    // 集計期間終了
    //-- 抽出対象が東陽以外の場合
    if ( $out_abstract == "1" ) {
        $sql.= "    AND \n";
        $sql.= "        t_sale_h.client_id != 93 \n";
    }
    $sql.= "        GROUP BY \n";
    $sql.= "            t_sale_h.client_id";    //得意先ごとに集計
    $sql.= "    ) t_sale_h \n";
    $sql.= "    ON t_client.client_id = t_sale_h.client_id \n";

    // 取引先区分マスタと結合
    $sql.= "    LEFT JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";


    //---------------------//
    // 検索条件を設定
    //---------------------//
    $sql.= "WHERE \n";
    $sql.= "        t_client.shop_id = $client_id \n";
    $sql.= "    AND \n";
    $sql.= "        t_client.client_div = $client_div \n";
    //-- FC・取引先区分に入力がある場合
    if ( $rank_cd != "" ) {
        $sql.= "AND \n";
        $sql.= "    t_rank.rank_cd = '$rank_cd' \n";
    }
    //-- グループコードに入力がある場合
    if ( $client_gr_id != "" ) {
        $sql.= "AND \n";
        $sql.= "     (  SELECT \n";
        $sql.= "            t_client_gr.client_gr_id \n";
        $sql.= "        FROM \n";
        $sql.= "            t_client_gr \n";
        $sql.= "        WHERE \n";
        $sql.= "            t_client_gr.client_gr_id = t_client.client_gr_id ) \n";
        $sql.= "    = $client_gr_id \n";
    }
    //-- グループ名に入力がある場合
    if ( $client_gr_name != "" ) {
        $sql.= "AND \n";
        $sql.= "    (   SELECT \n";
        $sql.= "            t_client_gr.client_gr_name \n";
        $sql.= "        FROM \n";
        $sql.= "            t_client_gr \n";
        $sql.= "        WHERE \n";
        $sql.= "            t_client_gr.client_gr_id = t_client.client_gr_id ) \n";
        $sql.= "    LIKE '%$client_gr_name%' \n";
    }
    //-- 表示対象が「金額0以外」の場合
    if ($out_range == "1") {
        $sql.= "AND \n";
        $sql.= "t_sale_h.net_amount <> 0 \n";
    }
    $sql.= "GROUP BY \n";
    $sql.= "    $group_by_item \n";
    $sql.= "ORDER BY \n";
    $sql.= "  net_amount DESC \n";
    $sql.= "; \n";

//   Print_Array($sql);

    /*********************/
    // クエリ実行
    /*********************/
    $result = Db_Query($db_con, $sql);

    return $result;
}


/**
 * 本部 担当者別ABC分析データ抽出用クエリ作成関数
 *
 * @author      fukuda
 * @version     1.0.0 (2007/11/23)
 *
 * @param       resource    $db_con         DBコネクション
 * @param       string      $post           POST情報
 * @param       integer     $shop_id        セッションのショップID
 *
 * @return                  $res            クエリ実行結果
 *
 */
function Select_Staff_Abc_Amount_h($db_con, $post, $shop_id){

    //-----------------------------------------------
    // 前準備
    //-----------------------------------------------
    // 減算しない取引区分を設定
    $trade_id   = "11, 15, 61";

    // Ymd 形式の集計期間（開始日）を作成
    $start_day  = date(
        "Ymd",
        mktime(0, 0, 0, $post["form_trade_ym_s"]["m"],                                1, $post["form_trade_ym_s"]["y"])
    );
    // Ymd 形式の集計期間（終了日）を作成
    $end_day    = date(
        "Ymd",
        mktime(0, 0, 0, $post["form_trade_ym_s"]["m"] + $post["form_trade_ym_e_abc"], 0, $post["form_trade_ym_s"]["y"])
    );

    //-----------------------------------------------
    // データ抽出クエリ作成
    //-----------------------------------------------
    // 変数初期化
    $sql  = null;

    $sql .= "SELECT \n";
    $sql .= "   t_attach.staff_id                       AS id,          \n";
    $sql .= "   to_char(t_staff.charge_cd, '0000')      AS cd,          \n";
    $sql .= "   t_staff.staff_name                      AS name,        \n";
    $sql .= "   COALESCE(analysis_data.sale_amount, 0)  AS net_amount,  \n";
    $sql .= "   null                                    AS rank_cd,     \n";
    $sql .= "   null                                    AS rank_name    \n";
    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_staff ON  t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "                      AND t_attach.shop_id = ".$shop_id."      \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_sale_h.c_staff_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN t_sale_h.trade_id IN (".$trade_id.")   \n";
    $sql .= "                   THEN t_sale_d.sale_amount                   \n";
    $sql .= "                   ELSE t_sale_d.sale_amount * -1              \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_sale_h \n";
    $sql .= "           INNER JOIN t_sale_d ON  t_sale_h.sale_id   = t_sale_d.sale_id   \n";
    $sql .= "                               AND t_sale_h.shop_id   = ".$shop_id."       \n";
    $sql .= "                               AND t_sale_h.sale_day >= '".$start_day."'   \n";
    $sql .= "                               AND t_sale_h.sale_day <= '".$end_day."'     \n";
    // 抽出対象が選択された場合
    if($post["form_out_abstract"] == "1"){;
    $sql .= "                               AND t_sale_h.client_id != 93                \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_sale_h.c_staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS analysis_data ON  t_staff.staff_id = analysis_data.c_staff_id \n";
    // 表示対象が指定された場合
    if($post["form_out_range"] == "1"){
    $sql .= "WHERE \n";
    $sql .= "   analysis_data.sale_amount != 0 \n";
    }
    $sql .= "ORDER BY \n";
    $sql .= "   net_amount DESC \n";
    $sql .= ";";

    // デバッグ用
    //print_array($sql, "クエリ（本部）");

    //-----------------------------------------------
    // データ抽出実行・結果を返す
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}


/**
 * FC   担当者別ABC分析データ抽出用クエリ作成関数
 *
 * @author      fukuda
 * @version     1.0.0 (2007/11/23)
 *
 * @param       resource    $db_con         DBコネクション
 * @param       string      $post           POST情報
 * @param       integer     $shop_id        セッションのショップID
 *
 * @return                  $res            クエリ実行結果
 *
 */
function Select_Staff_Abc_Amount_f($db_con, $post, $shop_id){

    //-----------------------------------------------
    // 前準備
    //-----------------------------------------------
    // 減算しない取引区分を設定
    $trade_id   = "11, 15, 61";

    // Ymd 形式の集計期間（開始日）を作成
    $start_day  = date(
        "Ymd",
        mktime(0, 0, 0, $post["form_trade_ym_s"]["m"],                                1, $post["form_trade_ym_s"]["y"])
    );
    // Ymd 形式の集計期間（終了日）を作成
    $end_day    = date(
        "Ymd",
        mktime(0, 0, 0, $post["form_trade_ym_s"]["m"] + $post["form_trade_ym_e_abc"], 0, $post["form_trade_ym_s"]["y"])
    );

    //echo $end_day;

    //-----------------------------------------------
    // データ抽出クエリ作成
    //-----------------------------------------------
    // 変数初期化
    $sql  = null;

    $sql .= "SELECT \n";
    $sql .= "   t_attach.staff_id                       AS id,          \n";
    $sql .= "   to_char(t_staff.charge_cd, '0000')      AS cd,          \n";
    $sql .= "   t_staff.staff_name                      AS name,        \n";
    $sql .= "   COALESCE(analysis_data.net_amount, 0)   AS net_amount,  \n";
    $sql .= "   null                                    AS rank_cd,     \n";
    $sql .= "   null                                    AS rank_name    \n";
    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_staff  ON  t_attach.staff_id   = t_staff.staff_id  \n";
    $sql .= "                       AND t_attach.shop_id    = ".$shop_id."      \n";
    $sql .= "   INNER JOIN t_part   ON  t_attach.part_id    = t_part.part_id    \n";
    $sql .= ""; // 自ショップの、期間内の担当者毎売上額データを集計するサブクエリ
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_sale_staff.staff_id, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN t_sale_h.trade_id IN (".$trade_id.") \n";
    $sql .= "                   THEN \n";
    $sql .= "                       CASE t_sale_staff.staff_div \n";
    $sql .= "                           WHEN '0' \n";
    $sql .= "                           THEN t_sale_h.net_amount - COALESCE(t_sale_h_sub.net_amount, 0) \n";
    $sql .= "                           ELSE trunc(t_sale_h.net_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
    $sql .= "                       END \n";
    $sql .= "                   ELSE (t_sale_h.net_amount - COALESCE(t_sale_h_sub.net_amount, 0)) * -1 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS net_amount,      \n";
    $sql .= "           t_part.branch_id,   \n";
    $sql .= "           t_attach.part_id    \n";
    $sql .= "       FROM \n";
    $sql .= "           t_sale_h \n";
    $sql .= "           INNER JOIN t_sale_staff ON  t_sale_h.sale_id        = t_sale_staff.sale_id  \n";
    $sql .= "           INNER JOIN t_attach     ON  t_sale_staff.staff_id   = t_attach.staff_id     \n";
    if ($post["form_part"] != null) {           // 部署が指定された場合
    $sql .= "                                   AND t_attach.part_id = ".$post["form_part"]."       \n";
    }
    $sql .= "           INNER JOIN t_part       ON  t_attach.part_id        = t_part.part_id        \n";
    if ($post["form_branch"] != null) {         // 所属本支店が指定された場合
    $sql .= "                                   AND t_part.branch_id = ".$post["form_branch"]."     \n";
    }
    $sql .= "";         // サブのみの合計金額を集計するサブクエリ
    $sql .= "           LEFT JOIN \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   t_sale_h.sale_id, \n";
    $sql .= "                   SUM( \n";
    $sql .= "                       CASE \n";
    $sql .= "                           WHEN t_sale_staff.staff_div != '0' \n";
    $sql .= "                           THEN trunc(t_sale_h.net_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
    $sql .= "                       END \n";
    $sql .= "                   ) AS net_amount \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_sale_h \n";
    $sql .= "                   INNER JOIN t_sale_staff ON  t_sale_h.sale_id         = t_sale_staff.sale_id \n";
    $sql .= "                                           AND t_sale_staff.sale_rate  IS NOT NULL             \n";
    $sql .= "                                           AND t_sale_staff.staff_div  != '0'                  \n";
    $sql .= "               WHERE t_sale_h.shop_id         = $shop_id             \n";
    $sql .= "                 AND t_sale_h.sale_day       >= '".$start_day."'     \n ";
    $sql .= "                 AND t_sale_h.sale_day       <= '".$end_day."'       \n ";
    $sql .= "               GROUP BY \n";
    $sql .= "                   t_sale_h.sale_id \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_h_sub ON  t_sale_h.sale_id = t_sale_h_sub.sale_id \n";

    $sql .= "       WHERE t_sale_h.shop_id         = $shop_id             \n";
    $sql .= "         AND t_sale_h.sale_day       >= '".$start_day."'     \n ";
    $sql .= "         AND t_sale_h.sale_day       <= '".$end_day."'       \n ";

    $sql .= "       GROUP BY \n";
    $sql .= "           t_sale_staff.staff_id,  \n";
    $sql .= "           t_part.branch_id,       \n";
    $sql .= "           t_attach.part_id        \n";
    $sql .= "   ) \n";
    $sql .= "   AS analysis_data ON  t_staff.staff_id   = analysis_data.staff_id    \n";
    $sql .= "                    AND t_part.branch_id   = analysis_data.branch_id   \n";
    $sql .= "                    AND t_part.part_id     = analysis_data.part_id     \n";
    $sql .= "WHERE \n";
    $sql .= "   t_staff.staff_id IS NOT NULL \n";
    // 表示対象が指定された場合
    if ($post["form_out_range"] === "1") {
    $sql .= "AND \n";
    $sql .= "   analysis_data.net_amount != 0 \n";
    }
    // 所属本支店が指定された場合
    if ($post["form_branch"] != null) {
    $sql .= "AND \n";
    $sql .= "   t_part.branch_id = ".$post["form_branch"]." \n";
    }
    // 部署が指定された場合
    if ($post["form_part"] != null) {
    $sql .= "AND \n";
    $sql .= "   t_attach.part_id = ".$post["form_part"]." \n";
    }
    $sql .= "ORDER BY \n";
    $sql .= "   net_amount DESC \n";
    $sql .= ";";

    // デバッグ用
    //print_array($sql, "クエリ（FC）");

    //-----------------------------------------------
    // データ抽出実行・結果を返す
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}


/**
 * FC別商品別ABC分析データ抽出用クエリ作成関数
 *
 * @author      fukuda
 * @version     1.0.0 (2007/12/01)
 *
 * @param       resource    $db_con         DBコネクション
 * @param       string      $post           POST情報
 *
 * @return                  $res            クエリ実行結果
 *
 */
function Select_Shop_Goods_Amount($db_con, $post){ 

    //-----------------------------------------------
    // 前準備
    //-----------------------------------------------
    // 減算しない取引区分を設定
    $trade_id   = "11, 15, 61";

    // Ymd 形式の集計期間（開始日）を作成
    $s_day  = date(
        "Ymd",
        mktime(0, 0, 0, $post["form_trade_ym_s"]["m"],                                1, $post["form_trade_ym_s"]["y"])
    );
    // Ymd 形式の集計期間（終了日）を作成
    $e_day  = date(
        "Ymd",
        mktime(0, 0, 0, $post["form_trade_ym_s"]["m"] + $post["form_trade_ym_e_abc"], 0, $post["form_trade_ym_s"]["y"])
    );

    //-----------------------------------------------
    // データ抽出クエリ作成
    //-----------------------------------------------
    // 変数初期化
    $sql  = null;

    // クエリ作成
    $sql .= "SELECT \n";
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2                       AS cd,              \n";
    $sql .= "   t_client.client_cname                                                   AS name,            \n";
    $sql .= "   t_goods.goods_cd                                                        AS cd2,             \n";
    $sql .= "   COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name   AS name2,           \n";
    $sql .= "   t_rank.rank_cd                                                          AS rank_cd,         \n";
    $sql .= "   t_rank.rank_name                                                        AS rank_name,       \n";
    $sql .= "   analysis_data.sale_amount                                               AS net_amount       \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   INNER JOIN t_rank       ON  t_client.rank_cd        = t_rank.rank_cd            \n";
    $sql .= "                           AND t_rank.disp_flg         = 't'                       \n";    // 表示フラグtrue
    $sql .= "                           AND t_rank.group_kind      != 1                         \n";    // 本部以外
                                        if ($post["form_rank"] != null) {
    $sql .= "                           AND t_rank.rank_cd          = '".$post["form_rank"]."'  \n";    // FC・取引先区分選択時
                                        }
                                        if ($post["form_out_abstract"] == "1") {
    $sql .= "                           AND t_client.client_id     != 93                        \n";    // 東陽以外を選択時
                                        }
    $sql .= "                           AND t_client.client_div     = '3'                       \n";    // FC
    $sql .= "   CROSS JOIN t_goods                                                              \n";
    $sql .= "   INNER JOIN t_goods_info ON  t_goods_info.goods_id   = t_goods.goods_id          \n";
    $sql .= "   AND t_goods_info.shop_id = 1                                                    \n";
                                        if ($post["form_g_goods"] != null) {
    $sql .= "                           AND t_goods.g_goods_id      = ".$post["form_g_goods"]." \n";    // Ｍ区分選択時
                                        }
                                        if ($post["form_product"] != null) {
    $sql .= "                           AND t_goods.product_id      = ".$post["form_product"]." \n";    // 管理区分選択時
                                        }
                                        if ($post["form_g_product"] != null) {
    $sql .= "                           AND t_goods.g_product_id    = ".$post["form_g_product"]." \n";  // 商品分類選択時
                                        }
    $sql .= "   LEFT  JOIN t_g_product  ON  t_goods.g_product_id    = t_g_product.g_product_id  \n";


                // 金額抽出テーブル
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_sale_h.client_id, \n";
    $sql .= "           t_sale_d.goods_id,  \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN t_sale_h.trade_id IN (".$trade_id.") \n";
    $sql .= "                   THEN t_sale_d.sale_amount *  1 \n";
    $sql .= "                   ELSE t_sale_d.sale_amount * -1 \n";
    $sql .= "               END \n";
    $sql .= "           ) \n";
    $sql .= "           AS sale_amount      \n";
    $sql .= "       FROM \n";
    $sql .= "           t_sale_h \n";
    $sql .= "           INNER JOIN t_sale_d     ON  t_sale_h.sale_id        = t_sale_d.sale_id      \n";
    $sql .= "                                   AND t_sale_h.shop_id        = 1                     \n";    // FC
    $sql .= "                                   AND t_sale_h.sale_day      >= '$s_day'              \n";    // 集計期間（開始）
    $sql .= "                                   AND t_sale_h.sale_day      <= '$e_day'              \n";    // 集計期間（終了）
                                                if ($post["form_out_abstract"] == "1") {
    $sql .= "                                   AND t_sale_h.client_id     != 93                    \n";    // 東陽以外を選択時
                                                }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_sale_h.client_id, \n";
    $sql .= "           t_sale_d.goods_id   \n";
    $sql .= "   ) \n";
    $sql .= "   AS analysis_data \n";
    $sql .= "   ON  t_client.client_id = analysis_data.client_id   \n";
    $sql .= "   AND t_goods.goods_id  = analysis_data.goods_id    \n";

    $sql .= "WHERE \n";
    $sql .= "   t_client.client_cd1    IS NOT NULL  \n";
    $sql .= "AND \n";
    $sql .= "   t_client.client_cd2    IS NOT NULL  \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.goods_cd     IS NOT NULL  \n";
    // 表示対象が指定された場合
    if ($post["form_out_range"] === "1") {
    $sql .= "AND \n";
    $sql .= "   analysis_data.sale_amount  != 0         \n";
    }

    // 2007-12-02 aizawa-m 追加
    //  得意先毎で売上金額の降順
    $sql.=  "ORDER BY \n";
    $sql .= "           t_client.client_cd1,            \n";
    $sql .= "           t_client.client_cd2,            \n";
    $sql .= "           t_rank.rank_cd,                 \n";
    $sql .= "           t_rank.rank_name,               \n";
    $sql .= "           analysis_data.sale_amount       \n";
    $sql.=  "DESC,                                      \n";
    $sql .= "           t_goods.goods_cd                \n";

    $sql .= ";";


    // デバッグ用
#    print_array($sql);

    //-----------------------------------------------
    // データ抽出実行・結果を返す
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}

?>
