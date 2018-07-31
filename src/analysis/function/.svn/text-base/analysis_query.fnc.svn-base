<?php

/**
 * 売上先か仕入先の、得意先毎の金額を抽出  
 *
 * 変更履歴  
 * 1.0.0 (2007/10/04) 新規作成 <br>
 * 1.1.0 (2007/10/14) クエリのカラムを共通化する <br>
 * 1.2.0 (2007/10/15) 引数の検索条件配列を$_POST に変更 <br>
 * 1.2.1 (2007/10/15) グループの検索条件を追加 <br>
 * 1.2.2 (2007/10/20) 抽出対象の検索条件を追加 <br>
 * 
 * @author      aizawa-m <aizawa-m@bhsk.co.jp> 
 * 
 * @param      conection    $db_con             DBコネクション
 * @param      string       $div                売上の場合="sale",仕入の場合="buy"
 * @param      array        $form_data              画面で入力された検索条件を保持した$_POST
 *  
 * @return     resource     $result             クエリ検索結果
 *
 */ 
function Select_Each_Customer_Amount ( $db_con, $div, $form_data ) {
    
    /***********************/
    // SESSION変数の取得
    /***********************/
    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /**************************/
    // 引数から検索条件を取得
    /**************************/
    $start_y        = $form_data["form_trade_ym_s"]["y"];   //開始年
    $start_m        = $form_data["form_trade_ym_s"]["m"];   //開始月
    $client_cd1     = $form_data["form_client"]["cd1"];     //得意先（仕入先)コード1
    $client_cd2     = $form_data["form_client"]["cd2"];     //得意先（仕入先)コード2  
    $client_name    = $form_data["form_client"]["name"];    //得意先（仕入先)名
    $period         = $form_data["form_trade_ym_e"];        //集計期間
    $rank_cd        = $form_data["form_rank"];              //FC・取引先区分コード
    $client_gr_id   = $form_data["form_client_gr"]["cd"];       //グループコード
    $client_gr_name = $form_data["form_client_gr"]["name"];     //グループ名
    $out_abstract   = $form_data["form_out_abstract"];      //抽出対象


    if ( $div == "sale" ) {
        //売上の場合
        $tbl_name   = "t_sale_h";
        //取引区分ID
        $trade_id   = "11, 15, 61";
        //売上日
        $term_day   = "sale_day";
        //取引先区分(得意先)
        $client_div = '1';
    } 
    else {
        //仕入の場合
        $tbl_name   = "t_buy_h";
        //取引先区分ID
        $trade_id   = "21, 25, 71";
        //仕入日
        $term_day   = "buy_day";
        //取引先区分(仕入先)
        $client_div = '2';
    }

    //本部の場合
    if ( $group_kind == "1" ) {
        //取引先区分（FC）
        $client_div = '3';
    }

    /**********************/
    // クエリ作成
    /**********************/
    $sql =  "SELECT \n";
    //仕入のFCの場合は、仕入先コード1のみ取得
    if ( $div == "buy" AND $group_kind != "1" ) { 
        $sql.=  "   t_client.client_cd1 AS cd, \n";
    } else {
        $sql.=  "   t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";
    }
    $sql.=  "   t_client.client_cname AS name, \n";
    $sql.=  "   t_client.rank_cd  AS rank_cd, \n";
    $sql.=  "   t_rank.rank_name AS rank_name, \n";
    for ( $i=0 ; $i<$period ; $i++ ) {
        $sql.=  "   COALESCE( ".$tbl_name.(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).", \n";
        $sql.=  "   COALESCE( ".$tbl_name.(string)($i+1).".arari_gaku, 0) AS arari_gaku".(string)($i+1).", \n";
        $sql.=  "   COALESCE( NULL , 0) AS num".(string)($i+1).", \n";
    }
    $sql.=  "   t_client.shop_id \n";
    $sql.=  "FROM \n";
    
    $sql.=  " ( \n";
    $sql.=  "   t_client \n";       
    for ( $i=0 ; $i<$period ; $i++ ) {
        //日付の書式を変える
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));
        
        $sql.=  "   LEFT JOIN ( \n";
        $sql.=  "       SELECT \n";
        $sql.=  "           client_id, \n";
        $sql.=  "           (net_amount -  cost_amount) AS arari_gaku, \n";
        $sql.=  "           net_amount \n";
        $sql.=  "       FROM \n";
        $sql.=  "           ( \n";
        $sql.=  "               SELECT \n";
        $sql.=  "                   SUM( \n";
        $sql.=  "                       CASE \n";
        $sql.=  "                           WHEN trade_id IN ($trade_id) THEN net_amount \n";
        $sql.=  "                           ELSE -1 * net_amount \n";
        $sql.=  "                       END \n";
        $sql.=  "                   ) AS net_amount, \n";
        //売上の場合のみ
        if ( $div == "sale") {
            $sql.=  "               SUM ( \n";
            $sql.=  "                   CASE \n";          
            $sql.=  "                       WHEN trade_id IN ($trade_id) THEN cost_amount \n";
            $sql.=  "                       ELSE -1 * cost_amount \n";
            $sql.=  "                   END \n";
            $sql.=  "               ) AS cost_amount, \n";
        }
        else {
            //仕入にcost_amountは存在しないため0を指定
            $sql.=  "               0 AS cost_amount, \n";
        }
        $sql.=  "                   client_id \n";
        $sql.=  "               FROM \n";
        $sql.=  "                   $tbl_name \n";
        $sql.=  "               WHERE \n";
        $sql.=  "                       shop_id = $shop_id \n";
        $sql.=  "                   AND \n";
        $sql.=  "                       $term_day >= '$this_date' \n";
        $sql.=  "                   AND \n";
        $sql.=  "                       $term_day < '$next_date' \n";
        $sql.=  "               GROUP BY \n";
        $sql.=  "                   client_id \n";
        $sql.=  "           ) $tbl_name \n";
        $sql.=  "   ) AS $tbl_name".(string)($i+1)." ON t_client.client_id = $tbl_name".(string)($i+1).".client_id \n";
    }
    $sql.=  " ) \n";
    //FC・取引先区分コードと結合
    $sql.=  "   LEFT JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";

    $sql.=  "WHERE \n";
    $sql.=  "       t_client.shop_id = $shop_id \n";
    $sql.=  "   AND \n";
    $sql.=  "       t_client.client_div = $client_div \n";

    /****************************/
    // 検索条件の追加
    /****************************/
    if ( $client_cd1 != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       t_client.client_cd1 LIKE '$client_cd1%' \n";
    }
    //FCの仕入の場合は、処理をしない
    if ( $client_cd2 != NULL ) { 
        $sql.=  "   AND \n";
        $sql.=  "       t_client.client_cd2 LIKE '$client_cd2%' \n";
    }
    if ( $client_name != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       (   t_client.client_name LIKE '$client_name%' \n";
        $sql.=  "       OR \n";
        $sql.=  "           t_client.client_name2 LIKE '$client_name%' \n";
        $sql.=  "       OR \n";
        $sql.=  "           t_client.client_cname LIKE '%$client_name%' \n";
        $sql.=  "       ) \n";
    }
    if ( $rank_cd != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       t_client.rank_cd = '$rank_cd' \n";
    }
    if ( $client_gr_id != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       (   SELECT \n";
        $sql.=  "               t_client_gr.client_gr_id \n";
        $sql.=  "           FROM \n";
        $sql.=  "               t_client_gr \n";
        $sql.=  "           WHERE \n";
        $sql.=  "               t_client_gr.client_gr_id = t_client.client_gr_id ) \n";
        $sql.=  "       = $client_gr_id \n";
    }
    if ( $client_gr_name != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       (   SELECT \n";
        $sql.=  "               t_client_gr.client_gr_name \n";
        $sql.=  "           FROM \n";
        $sql.=  "               t_client_gr \n";
        $sql.=  "           WHERE \n";
        $sql.=  "               t_client_gr.client_gr_id = t_client.client_gr_id ) \n";
        $sql.=  "       LIKE '%$client_gr_name%' \n";
    }
    //抽出対象が東陽以外の場合
    if ( $out_abstract == "1" ) {
        $sql.=  "   AND \n";
        $sql.=  "       t_client.client_id <> 93 \n";
    }
    $sql.=  "ORDER BY \n";
    $sql.=  "   t_client.client_cd1, \n";
    $sql.=  "   t_client.client_cd2 \n";
    $sql.=  "; \n";

//echo nl2br( $sql);

    //クエリの実行
    $result =   Db_Query( $db_con , $sql );

    return $result;
}



/**
 * サービス別、商品別売上推移データ抽出用クエリ作成関数 
 *
 * 
 *
 * 変更履歴
 * 1.0.0 (2007/10/06) 新規作成(watanabe-k)
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version     1.0.0 (2006/10/06)
 *
 * @param                   $db_con     DBコネクション
 * @param       array       $div        サービス：serv　　商品：goods
 * @param       string      $form_data  POST情報
 *
 * @return                  $resut      クエリ実行結果
 *
 * 履歴
 *---------------------------------------------------------------------
 * 2007-12-07    watanabe-k    �‐ι癖�類の初期値を設定
 *                             �◆�INNER」を「LEFT」に修正
 *                             �Ｋ槁�商品の絞りこみ条件はshop_id=1に変更
 */
function Select_Each_SG_Amount($db_con, $div, $form_data){

    $shop_id = $_SESSION["client_id"];      //ショップID
    $trade_id   = "11, 15, 61";             //取引区分

    /****************************/
    //クエリ作成
    /****************************/
    $sql =  "SELECT \n";

    //月毎のデータ
    for($i=1; $i <= $form_data["form_trade_ym_e"]; $i++){
    $sql .= "   COALESCE(t_sale_data".$i.".num, 0) AS num".$i.", \n"                 //売上数
           ."   COALESCE(t_sale_data".$i.".cost_amount, 0) AS cost_amount".$i.", \n" //原価金額
           ."   COALESCE(t_sale_data".$i.".sale_amount, 0) AS net_amount".$i.", \n" //売上金額
           ."   COALESCE(t_sale_data".$i.".sale_amount, 0) - COALESCE(t_sale_data".$i.".cost_amount, 0) AS arari_gaku".$i.", \n";    //粗利額
    }

    $sql .= "   t_".$div.".".$div."_id, \n"          //id
           ."   t_".$div.".".$div."_cd AS cd, \n";    //コード

    //商品名
    if($div == "goods"){
    //$sql .= "   t_g_product.g_product_name || ' ' || t_goods.goods_name AS name, \n";
    $sql .= "   COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name  AS name, \n";

    //サービス命
    }else{
    $sql .= "   t_serv.serv_name AS name, \n";
    }

    $sql .= "   null AS rank_cd,\n"             //FC・取引先区分コード（NULL）
           ."   null As rank_name\n"            //FC・取引先区分名（NULL）
           ."FROM \n"
           ."   t_".$div." \n";


    //月毎のデータ抽出用テーブル
    for($i=1; $i <= $form_data["form_trade_ym_e"]; $i++){
        $start_day = date('Ymd',
                mktime(0,0,0,$form_data["form_trade_ym_s"]["m"]+$i-1, 1, $form_data["form_trade_ym_s"]["y"])
            );

        $end_day = date('Ymd',
                mktime(0,0,0,$form_data["form_trade_ym_s"]["m"]+$i, 0, $form_data["form_trade_ym_s"]["y"])
            );

    $sql .= "       LEFT JOIN \n"
           ."   ( \n"
           ."   SELECT \n"
           ."       t_sale_d.".$div."_id, \n";

        //商品別の場合
        if($div == "goods"){
    $sql .= "       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.num \n"
           ."               WHEN t_sale_h.trade_id IN ('14','64') THEN 0 \n"
           ."               ELSE -1 * t_sale_d.num \n"
           ."           END \n"
           ."       ) AS num, \n";

        //サービス別の場合
        }else{
    $sql .= "       SUM( \n"
           ."       CASE \n"
           ."           WHEN t_sale_h.trade_id IN ($trade_id) THEN 1 \n"
           ."           WHEN t_sale_h.trade_id IN ('14','64') THEN 0 \n"
           ."           ELSE -1 \n"
           ."       END \n"
           ."       ) AS num, \n";

        }

    $sql .= "       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.sale_amount \n"
           ."               ELSE -1 * t_sale_d.sale_amount \n"
           ."           END \n"
           ."       ) AS sale_amount, \n"
           ."       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.cost_amount \n"
           ."               ELSE -1 * t_sale_d.cost_amount \n"
           ."           END \n"
           ."       ) AS cost_amount \n"
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
           ."       t_sale_d.".$div."_id IS NOT NULL \n";
                    //抽出対象が選択された場合
                    if($form_data["form_out_abstract"] == "1"){
    $sql .= "   AND \n"
           ."   t_sale_h.client_id != 93 \n";
                    }

    $sql .= "   GROUP BY t_sale_d.".$div."_id \n"
           ."   ) AS t_sale_data".$i." \n"
           ."   ON t_".$div.".".$div."_id = t_sale_data".$i.".".$div."_id \n";

    }

    //商品別売上推移の場合
    if($div == "goods"){

    $sql .= "       LEFT JOIN \n"
           ."   t_g_product \n"
           ."   ON t_goods.g_product_id = t_g_product.g_product_id \n"
           ."WHERE \n"
           //."   t_goods.public_flg = true \n";
           ."   t_goods.shop_id = 1 \n";
    }

    //商品コードが指定された場合
    if($form_data["form_goods"]["cd"] != null){
    $sql .= "   AND \n"
           ."   t_goods.goods_cd LIKE '".$form_data["form_goods"]["cd"]."%' \n";
    }

    //商品名が指定された場合
    if($form_data["form_goods"]["name"] != null){
    $sql .= "   AND \n"
           ."   t_goods.goods_name LIKE '%".$form_data["form_goods"]["name"]."%' \n";
    }

    //Ｍ区分が指定された場合
    if($form_data["form_g_goods"] != null){
    $sql .= "   AND \n"
           ."   t_goods.g_goods_id = ".$form_data["form_g_goods"]." \n";
    }

    //管理区分が指定された場合
    if($form_data["form_product"] != null){
    $sql .= "   AND \n"
           ."   t_goods.product_id = ".$form_data["form_product"]." \n";
    }

    //商品分類が指定された場合
    if($form_data["form_g_product"] != null){
    $sql .= "   AND \n"
           ."   t_goods.g_product_id = ".$form_data["form_g_product"]." \n";
    }


    //サービスが選択されていた場合
    if($form_data["form_serv"] != null){
    $sql .= "WHERE \n"
           ."   t_serv.serv_id = ".$form_data["form_serv"]." \n";
    }

    $sql .= "ORDER BY \n"
           ."   t_".$div.".".$div."_cd \n"
           .";";
#print_array($sql);
    $result = Db_Query($db_con, $sql);

    return $result;
}


/**
 * 担当者別、商品別売上推移データ抽出用クエリ作成関数
 *
 * @author      fuku
 * @version     1.0.0 (2007/11/03)
 *
 * @param       resource    $db_con         DBコネクション
 * @param       string      $form_data      POST情報
 * @param       integer     $shop_id        セッションのショップID
 * @param       array       $ary_ym         抽出期間の配列（YYYYMM形式）
 *
 * @return                  $res            クエリ実行結果
 *
 * 履歴
 * ------------------------------------------------------
 * 2007-11-04   aizawa-m        rank_cd・rank_nameをNullで抽出を追加
 *
 */
function Select_Each_Staff_Goods_Amount_h($db_con, $post, $shop_id, $ary_ym){

    //-----------------------------------------------
    // データ抽出条件作成
    //-----------------------------------------------
    // 一般的な検索条件
    $sql = null;

    // 担当者
    if ($post["form_staff"] != null) {
        $sql .= "AND \n";
        $sql .= "   t_staff.staff_id = ".$post["form_staff"]." \n";
    }

    // 商品コード（前方一致）
    if ($post["form_goods"]["cd"] != null) {
        $sql .= "AND \n";
        $sql .= "   t_goods.goods_cd LIKE '".$post["form_goods"]["cd"]."%' \n";
    }

    // 商品名（部分一致）
    if ($post["form_goods"]["name"] != null) {
        $sql .= "AND \n";
        $sql .= " t_goods.goods_name LIKE '%".$post["form_goods"]["name"]."%' \n";
    }

    // Ｍ区分（ID）
    if ($post["form_g_goods"] != null) {
        $sql .= "AND \n";
        $sql .= " t_goods.g_goods_id = ".$post["form_g_goods"]." \n";
    }

    // 管理区分（ID）
    if ($post["form_product"] != null) {
        $sql .= "AND \n";
        $sql .= " t_goods.product_id = ".$post["form_product"]." \n";
    }

    // 商品分類（ID）
    if ($post["form_g_product"] != null) {
        $sql .= "AND \n";
        $sql .= " t_goods.g_product_id = ".$post["form_g_product"]." \n";
    }

    // 変数に格納
    $where_sql = $sql;

    // 特殊な検索条件
    $sql = null;

    // 抽出対象（bool）
    if ($post["form_out_abstract"] == "1") {
        $sql .= "               WHERE \n";
        $sql .= "                   t_sale_h.client_id != 93 \n";
    }

    $where_touyou_sql = $sql;

    // 特殊な検索条件
    $sql = null;

    // 抽出対象（bool）
    if ($post["form_out_abstract"] == "1") {
        $sql .= "AND \n";
    }

    $where_touyou_sql2 = $sql;

    //-----------------------------------------------
    // データ抽出クエリ作成
    //-----------------------------------------------
    $sql  = null;

    $sql .= "SELECT \n";
    $sql .= "   to_char(t_staff.charge_cd, '0000')                                      AS cd,                  \n";
    $sql .= "   t_staff.staff_name                                                      AS name,                \n";
    $sql .= "   t_goods.goods_cd                                                        AS cd2,                 \n";
    $sql .= "   COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name   AS name2,               \n";
    $sql .= "   NULL                                                                    AS rank_cd,             \n";
    $sql .= "   NULL                                                                    AS rank_name,           \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "   COALESCE(analysis_".$cnt.".sale_amount, 0)                              AS net_amount".$cnt.",  \n";
    $sql .= "   COALESCE(analysis_".$cnt.".sale_amount, 0) - \n";
    $sql .= "   COALESCE(analysis_".$cnt.".cost_amount, 0)                              AS arari_gaku".$cnt.",  \n";
    $sql .= "   NULL                                                                    AS num".$cnt.",         \n";
    }
    $sql .= "   t_attach.shop_id \n";

    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_staff          ON  t_attach.staff_id       = t_staff.staff_id          \n";
    $sql .= "   INNER JOIN t_goods_info     ON  t_attach.shop_id        = t_goods_info.shop_id      \n";
    $sql .= "   INNER JOIN t_goods          ON  t_goods_info.goods_id   = t_goods.goods_id          \n";
    $sql .= "   LEFT  JOIN t_g_product      ON  t_goods.g_product_id    = t_g_product.g_product_id  \n";

    // 指定された期間分ループ
    foreach ($ary_ym as $key => $this_ym) {

        $cnt  = (string)($key + 1);

        // １ヶ月分のデータを結合
        $sql .= "   LEFT JOIN ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_staff.staff_id, \n";
        $sql .= "           t_sale_d.goods_id, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.cost_amount, 0) *  1 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS cost_amount, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.sale_amount, 0) *  1 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
        $sql .= "                   END \n";
        $sql .= "               ) \n";
        $sql .= "               AS sale_amount \n";
        $sql .= "           FROM \n";
        $sql .= "               t_staff \n";
        $sql .= "               INNER JOIN t_sale_h ON  t_staff.staff_id  = t_sale_h.c_staff_id \n";
        $sql .= "                                   AND t_sale_h.sale_day LIKE '".$this_ym."%'  \n";
        $sql .= "                                   AND t_sale_h.shop_id  = 1                   \n";
        $sql .= "               INNER JOIN t_sale_d ON  t_sale_h.sale_id  = t_sale_d.sale_id    \n";
        $sql .= "                                   AND t_sale_d.goods_id IS NOT NULL           \n";
        $sql .=             $where_touyou_sql;
        $sql .= "           GROUP BY \n";
        $sql .= "               t_staff.staff_id, \n";
        $sql .= "               t_sale_d.goods_id \n";
        $sql .= "           ORDER BY \n";
        $sql .= "               t_staff.staff_id, \n";
        $sql .= "               t_sale_d.goods_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS  analysis_".$cnt." \n";
        $sql .= "   ON  t_staff.staff_id = analysis_".$cnt.".staff_id \n";
        $sql .= "   AND t_goods.goods_id = analysis_".$cnt.".goods_id \n";

    }

    // WHERE句
    $sql .= "WHERE \n";
    $sql .= "   t_attach.h_staff_flg = 't' \n";
    $sql .= "AND \n";
    $sql .= "   t_staff.staff_id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   ( \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "       analysis_".$cnt.".goods_id IS NOT NULL \n";
    $sql .= (count($ary_ym) != $cnt) ? "        OR \n" : "\n";
    }
    $sql .= "   ) \n";
    $sql .= $where_sql;


    // ソート順
    $sql .= "ORDER BY \n";
    $sql .= "   t_staff.charge_cd, \n";
    $sql .= "   t_goods.goods_cd \n";
    $sql .= "; \n";


    //-----------------------------------------------
    // データ抽出実行・結果を返す
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}


/**
 * 業種別、商品別売上推移データ抽出用クエリ作成関数
 *
 * @author      fuku
 * @version     1.0.0 (2007/11/03)
 *
 * @param       resource    $db_con         DBコネクション
 * @param       string      $form_data      POST情報
 * @param       integer     $shop_id        セッションのショップID
 * @param       array       $ary_ym         抽出期間の配列（YYYYMM形式）
 *
 * @return                  $res            クエリ実行結果
 *
 * 変更
 * ------------------------------------------------------
 * 2007-11-04   aizawa-m            rank_cd・rank_nameをNULLで抽出を追加
 *
 */
function Select_Each_Btype_Goods_Amount_h($db_con, $post, $shop_id, $ary_ym){

    //-----------------------------------------------
    // データ抽出条件作成
    //-----------------------------------------------
    // 一般的な検索条件
    $sql = null;

    // 業種（ID）
    if ($post["form_lbtype"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.id = ".$post["form_lbtype"]." \n";
    }

    // 商品コード（前方一致）
    if ($post["form_goods"]["cd"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.cd2 LIKE '".$post["form_goods"]["cd"]."%' \n";
    }

    // 商品名（部分一致）
    if ($post["form_goods"]["name"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.name2 LIKE '%".$post["form_goods"]["name"]."%' \n";
    }

    // Ｍ区分（ID）
    if ($post["form_g_goods"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.g_goods_id = ".$post["form_g_goods"]." \n";
    }

    // 管理区分（ID）
    if ($post["form_product"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.product_id = ".$post["form_product"]." \n";
    }

    // 商品分類（ID）
    if ($post["form_g_product"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.g_product_id = ".$post["form_g_product"]." \n";
    }

    // 変数に格納
    $where_sql = $sql;

    // 特殊な検索条件
    $sql = null;

    // 抽出対象（bool）
    if ($post["form_out_abstract"] == "1") {
        $sql .= "               WHERE \n";
        $sql .= "                   t_sale_h.client_id != 93 \n";
    }

    $where_touyou_sql = $sql;

    //-----------------------------------------------
    // データ抽出クエリ作成
    //-----------------------------------------------
    $sql  = null;

    $sql .= "SELECT \n";

    $sql .= "   analysis_base.cd                                    AS cd,                  \n";
    $sql .= "   analysis_base.name                                  AS name,                \n";
    $sql .= "   analysis_base.id2                                   AS id2,                 \n";
    $sql .= "   analysis_base.cd2                                   AS cd2,                 \n";
    $sql .= "   analysis_base.name2                                 AS name2,               \n";
    $sql .= "   NULL                                                AS rank_cd,             \n";
    $sql .= "   NULL                                                AS rank_name,           \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "   COALESCE(analysis_".$cnt.".sale_amount, 0)          AS net_amount".$cnt.",  \n";
    $sql .= "   COALESCE(analysis_".$cnt.".sale_amount, 0) - \n";
    $sql .= "   COALESCE(analysis_".$cnt.".cost_amount, 0)          AS arari_gaku".$cnt.",  \n";
    $sql .= "   COALESCE(analysis_".$cnt.".num, 0)                  AS NUM".$cnt.((count($ary_ym) != $cnt) ? ", \n" : "\n");
    }

    $sql .= "FROM \n";

    // 基本テーブル
    $sql .= "   ( \n";
    $sql .= "        SELECT \n";
    $sql .= "            t_lbtype.lbtype_id                                                     AS id, \n";
    $sql .= "            t_lbtype.lbtype_cd                                                     AS cd, \n";
    $sql .= "            t_lbtype.lbtype_name                                                   AS name, \n";
    $sql .= "            t_goods.goods_id                                                       AS id2, \n";
    $sql .= "            t_goods.goods_cd                                                       AS cd2, \n";
    $sql .= "            COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name  AS name2, \n";
    $sql .= "            t_goods.g_goods_id, \n";
    $sql .= "            t_goods.product_id, \n";
    $sql .= "            t_goods.g_product_id \n";
    $sql .= "        FROM \n";
    $sql .= "            t_lbtype \n";
    $sql .= "            INNER JOIN t_sbtype     ON  t_lbtype.lbtype_id      = t_sbtype.lbtype_id \n";
    $sql .= "            INNER JOIN t_client     ON  t_sbtype.sbtype_id      = t_client.sbtype_id \n";
    $sql .= "                                    AND client_div              = '3' \n";
    $sql .= "            INNER JOIN t_goods_info ON  t_client.shop_id        = t_goods_info.shop_id \n";
    $sql .= "                                    AND t_goods_info.shop_id    = 1 \n";
    $sql .= "            INNER JOIN t_goods      ON  t_goods_info.goods_id   = t_goods.goods_id \n";
    $sql .= "            LEFT  JOIN t_g_product  ON  t_goods.g_product_id    = t_g_product.g_product_id \n";
    $sql .= "                                    AND t_g_product.shop_id     = 1 \n";
    $sql .= "        GROUP BY \n";
    $sql .= "            t_lbtype.lbtype_id, \n";
    $sql .= "            t_lbtype.lbtype_cd, \n";
    $sql .= "            t_lbtype.lbtype_name, \n";
    $sql .= "            t_goods.goods_id, \n";
    $sql .= "            t_goods.goods_cd, \n";
    $sql .= "            t_g_product.g_product_name, \n";
    $sql .= "            t_goods.goods_name, \n";
    $sql .= "            t_goods.g_goods_id, \n";
    $sql .= "            t_goods.product_id, \n";
    $sql .= "            t_goods.g_product_id \n";
    $sql .= "        ORDER BY \n";
    $sql .= "            t_lbtype.lbtype_cd, \n";
    $sql .= "            t_goods.goods_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS analysis_base \n";

    // 指定された期間分ループ
    foreach ($ary_ym as $key => $this_ym) {

        $cnt  = (string)($key + 1);

        // 一ヶ月分のデータテーブル
        $sql .= "   LEFT JOIN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_sbtype.lbtype_id  AS lbtype_id, \n";
        $sql .= "           t_sale_d.goods_id   AS goods_id, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.num, 0) *  1 \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (14, 64) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.num, 0) *  0 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.num, 0) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS num, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.cost_amount, 0) *  1 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS cost_amount, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.sale_amount, 0) *  1 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS sale_amount \n";
        $sql .= "       FROM \n";
        $sql .= "           t_sbtype \n";
        $sql .= "           INNER JOIN t_client ON  t_sbtype.sbtype_id  = t_client.sbtype_id \n";
        $sql .= "           INNER JOIN t_sale_h ON  t_client.client_id  = t_sale_h.client_id \n";
        $sql .= "                               AND t_sale_h.sale_day  LIKE '".$this_ym."%' \n";
        $sql .= "                               AND t_sale_h.shop_id    = 1 \n";
        $sql .= "           INNER JOIN t_sale_d ON  t_sale_h.sale_id    = t_sale_d.sale_id \n";
        $sql .= "                               AND t_sale_d.goods_id   IS NOT NULL \n";
        $sql .=         $where_touyou_sql;
        $sql .= "       GROUP BY \n";
        $sql .= "           t_sbtype.lbtype_id, \n";
        $sql .= "           t_sale_d.goods_id \n";
        $sql .= "       ORDER BY \n";
        $sql .= "           t_sbtype.lbtype_id, \n";
        $sql .= "           t_sale_d.goods_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS  analysis_".$cnt." \n";
        $sql .= "   ON  analysis_base.id    = analysis_".$cnt.".lbtype_id \n";
        $sql .= "   AND analysis_base.id2   = analysis_".$cnt.".goods_id \n";

    }

    // WHERE句
    $sql .= "WHERE \n";
    $sql .= "   analysis_base.id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   ( \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "       analysis_".$cnt.".goods_id IS NOT NULL \n";
    $sql .= (count($ary_ym) != $cnt) ? "        OR \n" : "\n"; 
    }
    $sql .= "   ) \n";
    $sql .= $where_sql;

    // ソート順
    $sql .= "ORDER BY \n";
    $sql .= "   analysis_base.cd, \n";
    $sql .= "   analysis_base.cd2 \n";
    $sql .= "; \n";
//print_array($sql);

    //-----------------------------------------------
    // データ抽出実行・結果を返す
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}


/**
 * 業種別(FC／得意先)別 売上推移の金額を抽出  
 *
 * 変更履歴  
 * 1.0.0 (2007/10/19) 新規作成 <br>
 * 
 * @author      aizawa-m <aizawa-m@bhsk.co.jp> 
 * 
 * @param       conection    $db_con    DBコネクション
 * @param       array        $post      画面で入力された検索条件を保持した$_POST
 *  
 * @return      resource     $result    クエリ検索結果
 *
 */ 
function Select_Each_Type_Customer_Amount ( $db_con, $post ) {

    /*****************************/
    // SESSION変数の取得
    /*****************************/
    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /****************************/
    // 引数から検索条件を取得
    /****************************/
    $start_y        = $post["form_trade_ym_s"]["y"];    //集計期間(年)
    $start_m        = $post["form_trade_ym_s"]["m"];    //集計期間(月)
    $period         = $post["form_trade_ym_e"];         //集計期間
    $lbtype_id      = $post["form_lbtype"];             //業種ID
    $client_cd1     = $post["form_client"]["cd1"];      //得意先コード1
    $client_cd2     = $post["form_client"]["cd2"];      //得意先コード2
    $client_name    = $post["form_client"]["name"];     //得意先名
    $rank_cd        = $post["form_rank"];               //FC・取引先区分コード
    $client_gr_cd   = $post["form_client_gr"]["cd"];    //グループID
    $client_gr_name = $post["form_client_gr"]["name"];  //グループ名
    $margin         = $post["form_margin"];             //粗利率
    $out_range      = $post["form_out_range"];          //表示対象
    $out_abstract   = $post["form_out_abstract"];       //抽出対象

    //本部の場合
    if ( $group_kind == "1" ) {
        $client_div = "3";  //FC
    } else {
        $client_div = "1";  //得意先
    }


    /***************************/
    // クエリ作成
    /***************************/

    // ------ 業種ごとでまとめる ------ //
    $sql.=  "SELECT \n";
    $sql.=  "   t_lbtype.lbtype_cd AS cd, \n";        //大分類業種コード
    $sql.=  "   t_lbtype.lbtype_name AS name, \n";      //大分類業種名
    $sql.=  "   t_client.client_cd1 || '-' || t_client.client_cd2 AS cd2, \n";//得意先コード
    $sql.=  "   t_client.client_cname AS name2, \n";     //得意先名


    //集計期間分の売上金額を取得
    #for ( $i=0 ; $i<$period ; $i++ ) {
    #    $sql.=  "t_client_new.net_amount".(string)($i+1).", \n";    //毎月の売上金額
    #    $sql.=  "t_client_new.arari_gaku".(string)($i+1).", \n";    //毎月の粗利益額
    #}

    //集計期間分の売上金額を取得
    for ( $i=0 ; $i<$period ; $i++ ) {
        $sql.=  "   COALESCE( \n";  //売上金額
        $sql.=  "      t_sale_h".(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).", \n";
        $sql.=  "   COALESCE( \n";  //粗利益額
        $sql.=  "      t_sale_h".(string)($i+1).".arari_gaku, 0) AS arari_gaku".(string)($i+1).", \n";

        $sql.=  "   NULL AS num".(string)($i+1).", \n";     //得意先名
    }
    $sql.=  "   t_client.rank_cd AS rank_cd, \n";       //FC・取引先区分コード
    $sql.=  "   t_rank.rank_name AS rank_name \n";     //FC・取引先区分名


    $sql.=  "FROM \n";
    $sql.=  "   t_lbtype \n";//大分類マスタ

    #hashimoto-y
    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_sbtype \n";//
    $sql.=  "ON t_lbtype.lbtype_id = t_sbtype.lbtype_id \n";//

    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_client \n";//
    $sql.=  "ON t_sbtype.sbtype_id = t_client.sbtype_id \n";//

    $sql.=  "LEFT JOIN  \n";
    $sql.=  "   t_client_gr \n";
    $sql.=  "ON t_client.client_gr_id = t_client_gr.client_gr_id \n";

    $sql.=  "LEFT JOIN  \n";
    $sql.=  "   t_rank \n";
    $sql.=  "ON t_client.rank_cd = t_rank.rank_cd \n";



    //------ 得意先ごとの毎月の合計を取得 START ------ //
    for ( $i=0 ; $i<$period ; $i++ ) {
        //日付の書式を変える
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));   
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));

        $sql.=  "       LEFT JOIN \n";  //t_sale_h($i)
        $sql.=  "           (  SELECT \n";
        $sql.=  "                   client_id, \n";
        $sql.=  "                   net_amount, \n";
        $sql.=  "                   (net_amount - cost_amount) AS arari_gaku \n";
        $sql.=  "               FROM \n";


        $sql.=  "                   (   SELECT \n";
        $sql.=  "                           SUM ( \n";  //売上金額の合計  
        $sql.=  "                               CASE \n";
        $sql.=  "                                   WHEN trade_id IN (11, 15, 61) \n";
        $sql.=  "                                   THEN t_sale_h.net_amount \n";
        $sql.=  "                                   ELSE -1 * t_sale_h.net_amount \n";
        $sql.=  "                               END \n";
        $sql.=  "                           ) AS net_amount, \n";
        $sql.=  "                           SUM ( \n";  //粗利額の合計
        $sql.=  "                               CASE \n";
        $sql.=  "                                   WHEN trade_id IN (11, 15, 61) \n";
        $sql.=  "                                   THEN t_sale_h.cost_amount \n";
        $sql.=  "                                   ELSE -1 * t_sale_h.cost_amount \n";
        $sql.=  "                               END \n";
        $sql.=  "                           ) AS cost_amount, \n";
        $sql.=  "                           client_id \n";
        $sql.=  "                       FROM \n";
        $sql.=  "                           t_sale_h \n";
        $sql.=  "                       WHERE \n";
        $sql.=  "                               shop_id = $shop_id \n";
        $sql.=  "                           AND \n";
        $sql.=  "                               sale_day >= '$this_date' \n";
        $sql.=  "                           AND \n";
        $sql.=  "                               sale_day < '$next_date' \n";
        $sql.=  "                       GROUP BY \n";
        $sql.=  "                           client_id \n";
        $sql.=  "                   ) t_sale_h \n";


        $sql.=  "               ORDER BY \n";
        $sql.=  "                   client_id \n";
        $sql.=  "           ) AS t_sale_h".(string)($i+1)." \n";
        $sql.=  "                ON t_client.client_id = t_sale_h".(string)($i+1).".client_id \n";



        // 抽出対象が東陽以外
        if ( $out_abstract ==  "1" ) {
            $sql.=  "           AND \n";
            $sql.=  "               t_sale_h".(string)($i+1).".client_id <> 93 \n";
        }
    }

    $sql.=  "       WHERE \n";
    $sql.=  "               t_client.shop_id = $shop_id \n";
    $sql.=  "           AND \n";
    $sql.=  "               t_client.client_div = $client_div \n";

    /*******************************/
    // 検索条件の追加
    /*******************************/
    if ( $client_cd1 != NULL ) { 
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_cd1 LIKE '$client_cd1%' \n";
    }
    if ( $client_cd2 != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_cd2 LIKE '$client_cd2%' \n";    
    }
    if ( $client_name != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           ( \n";
        $sql.=  "               t_client.client_name LIKE '%$client_name%' \n";
        $sql.=  "           OR \n";
        $sql.=  "               t_client.client_name2 LIKE '%$client_name%' \n";
        $sql.=  "           OR \n";
        $sql.=  "               t_client.client_cname LIKE '%$client_name%' \n";
        $sql.=  "           ) \n";
    }
    if ( $rank_cd != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.rank_cd = '$rank_cd' \n";
    }
    if ( $client_gr_cd != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_gr_id = $client_gr_cd \n";
    }
    if ( $client_gr_name != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client_gr.client_gr_name LIKE '%$client_gr_name%' \n";
    }

    // 「業種」の検索条件    
    if ( $lbtype_id != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "   t_lbtype.lbtype_id = $lbtype_id \n";
    }

    $sql.=  "ORDER BY \n";
    $sql.=  "   t_lbtype.lbtype_cd \n";
    $sql.=  ";";
   
    //echo nl2br($sql);

    /***********************/
    // クエリの実行
    /***********************/
    $result = Db_Query($db_con, $sql);

    #hashimoto-y
    $debug_flg = false;
    if($debug_flg == "true"){
        $count = pg_num_rows($result );

        for ( $i=0 ; $i < $count ; $i++ ) {
            $column_cd = pg_fetch_result($result, $i, "cd");
            $column_name = pg_fetch_result($result, $i, "name");
            $column_cd2 = pg_fetch_result($result, $i, "cd2");
            $column_name2 = pg_fetch_result($result, $i, "name2");

            $column = "net_amount" .(int)$start_m;
            $column_net_amount = pg_fetch_result($result, $i,  $column);
            echo "cd : " .$column_cd ."<br>";
            echo "name : " .$column_name ."<br>";
            echo "cd2 : " .$column_cd2 ."<br>";
            echo "name2 : " .$column_name2 ."<br>";
            echo "net_amount : " .$column_net_amount ."<br><br>";

        }

    }

    return $result;

}

/**
 * 仕入先別商品別仕入推移用のクエリ実行関数 
 *
 * 変更履歴 
 * 1.0.0 (2007/10/17)   aizawa-m    新規作成 <br>
 *
 * 
 * @param   conection   $db_con     DBコネクション
 * @param   array       $post       $_POST          
 *
 * @return  resource    $result     クエリ実行リソース
 *
 */
function Select_Each_Goods_Supplier ($db_con, $_POST) {

    /***********************/
    // SESSION変数の取得
    /***********************/
    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /***********************/
    // 検索条件を取得
    /***********************/
    $period         = $_POST["form_trade_ym_e"];   
    $start_y        = $_POST["form_trade_ym_s"]["y"];   
    $start_m        = $_POST["form_trade_ym_s"]["m"];   

    $client_cd1     = $_POST["form_client"]["cd1"];      //得意先コード1
    $client_cd2     = $_POST["form_client"]["cd2"];      //得意先コード2
    $client_name    = $_POST["form_client"]["name"];     //得意先名
    $rank_cd        = $_POST["form_rank"];               //FC・取引先区分コード

    $goods_cd       = $_POST["form_goods"]["cd"];        //商品コード
    $goods_name     = $_POST["form_goods"]["name"];      //商品名

    $g_goods        = $_POST["form_g_goods"];            //Ｍ区分
    $product        = $_POST["form_product"];            //管理区分
    $g_product      = $_POST["form_g_product"];          //商品分類

    $out_range      = $_POST["form_out_range"];          //表示対象
    $out_abstract   = $_POST["form_out_abstract"];       //抽出対象


//    echo "period:" .$period ."<br>";


    // 本部の場合
    if ( $group_kind == "1" ) {
        $client_div = "3";  //FC
    } else {
        $client_div = "2";  //仕入先
    }


    /***********************/
    // クエリ作成
    /***********************/

    $sql =  "SELECT \n";

    //本部の場合は、得意先コード１と得意先コード２を抽出
    if ( $group_kind == "1" ) { 
        $sql.=  "   t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";
    //FCの場合は、得意先コード１のみ抽出
    } else {
        $sql.=  "   t_client.client_cd1 AS cd, \n";
    }

    $sql.=  "   t_client.client_cname AS name, \n"; 

    $sql.=  "   t_client.goods_cd AS cd2, \n";
    $sql.=  "   t_client.g_product_name || ' ' || t_client.goods_name AS name2, \n";

    for ($i = 0; $i < $period; $i++ ) {
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).", \n";
        $sql.=  "   0 AS arari_gaku".(string)($i+1).", \n";
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".num , 0) AS num".(string)($i+1).", \n";
        $sql.=  "   t_buy_d".(string)($i+1).".goods_id AS goods_id".(string)($i+1).", \n";
    }

    $sql.=  "   t_client.rank_cd AS rank_cd, \n";       //FC・取引先区分コード
    $sql.=  "   t_client.rank_name AS rank_name \n";     //FC・取引先区分名

//  2007-11-11 コメント
////    $sql.=  "   t_client.shop_id \n";

    $sql.=  "FROM \n";

    //仕入先別商品情報テーブル
    $sql .= "   (\n";
    $sql .= "   SELECT\n";
    $sql .= "       t_client.client_id,  \n";
    $sql .= "       t_client.client_cd1, \n";
    $sql .= "       t_client.client_cd2, \n";
    $sql .= "       t_client.client_cname, \n";
    $sql .= "       t_client.shop_id, \n";
    $sql .= "       t_goods.goods_id,    \n";
    $sql .= "       t_goods.goods_cd,    \n";
    $sql .= "       t_goods.goods_name,  \n";
    $sql .= "       t_g_product.g_product_name, \n";
    $sql .= "       t_rank.rank_cd,      \n";
    $sql .= "       t_rank.rank_name     \n";
    $sql .= "   FROM \n";
    $sql .= "       t_client \n";
    $sql .= "           INNER JOIN  \n";
    $sql .= "       t_goods_info \n";
    $sql .= "       ON t_client.shop_id = t_goods_info.shop_id \n";
    $sql .= "       AND t_client.shop_id = $shop_id \n";
    $sql .= "           INNER JOIN  \n";
    $sql .= "       t_goods \n";
    $sql .= "       ON t_goods_info.goods_id = t_goods.goods_id \n";
    $sql .= "           LEFT JOIN  \n";
    $sql .= "       t_g_product \n";
    $sql .= "       ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "           LEFT JOIN  \n";
    $sql .= "       t_rank \n";
    $sql .= "       ON t_client.rank_cd = t_rank.rank_cd \n";

    $sql .= "   WHERE \n";
    $sql .= "       t_client.client_div = '$client_div' \n";

    // 検索条件の追加
    if ( $client_cd1 != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_cd1 LIKE '$client_cd1%' \n";
    }
    if ( $client_cd2 != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_cd2 LIKE '$client_cd2%' \n";    }
    if ( $client_name != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           ( \n";
        $sql.=  "               t_client.client_name LIKE '%$client_name%' \n";
        $sql.=  "           OR \n";
        $sql.=  "               t_client.client_name2 LIKE '%$client_name%' \n";
        $sql.=  "           OR \n";
        $sql.=  "               t_client.client_cname LIKE '%$client_name%' \n";
        $sql.=  "           ) \n";    }
    if ( $rank_cd != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.rank_cd = '$rank_cd' \n";
    }
    //商品コードが指定された場合
    if($goods_cd != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.goods_cd LIKE '".$goods_cd."%' \n";
    }
    //商品名が指定された場合
    if($goods_name != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.goods_name LIKE '%".$goods_name."%' \n";
    }
    //Ｍ区分が指定された場合
    if($g_goods != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.g_goods_id = ".$g_goods." \n";
    }
    //管理区分が指定された場合
    if($product != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.product_id = ".$product." \n";
    }
    //商品分類が指定された場合
    if($g_product != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.g_product_id = ".$g_product." \n";
    }

    $sql .= "   ) AS t_client \n";

    //月毎の仕入集計テーブル
    for ( $i = 0; $i < $period; $i++ ) {
        // 日付の書式を変える

/*
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));
*/

        $like_day =  date("Y-m-", mktime(0,0,0, $start_m + $i, 1, $start_y));

        $sql .= "       LEFT JOIN \n";
        $sql .= "   (\n";
        $sql .= "   SELECT \n";
        $sql .= "       t_buy_h.client_id, \n"; 
        $sql .= "       t_buy_d.goods_id, \n"; 
        $sql .= "       SUM ( \n";
        $sql .= "           CASE \n";
        $sql .= "               WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
        $sql .= "               THEN t_buy_d.buy_amount \n";
        $sql .= "               ELSE -1 * t_buy_d.buy_amount \n";   
        $sql .= "           END \n";
        $sql .= "       ) AS net_amount, \n";
        $sql .= "       SUM ( \n";
        $sql .= "           CASE \n";
        $sql .= "               WHEN t_buy_h.trade_id IN (21, 25, 71) THEN t_buy_d.num\n";
        $sql .= "               WHEN t_buy_h.trade_id IN (24, 74) THEN 0 \n";
        $sql .= "               ELSE -1 * t_buy_d.num \n";
        $sql .= "           END \n";
        $sql .= "       ) AS num \n";
        $sql .= "   FROM \n";
        $sql .= "       t_buy_h \n";
        $sql .= "           INNER JOIN \n";
        $sql .= "       t_buy_d \n";
        $sql .= "       ON t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "   WHERE \n";
        $sql .= "       t_buy_h.shop_id = $shop_id \n";
/*
        $sql .= "       AND \n";
        $sql .= "       t_buy_h.buy_day >= '$this_date' \n";
        $sql .= "       AND \n";
        $sql .= "       t_buy_h.buy_day < '$next_date' \n";
*/
        $sql .= "       AND \n";
        $sql .= "       t_buy_h.buy_day LIKE '$like_day%' \n";

        $sql .= "   GROUP BY \n";
        $sql .= "       t_buy_h.client_id, \n";
        $sql .= "       t_buy_d.goods_id \n";
        $sql .= "   ) AS t_buy_d".(string)($i+1). " \n";
        $sql .= "   ON t_client.client_id = t_buy_d".(string)($i+1).".client_id \n";
        $sql .= "   AND t_client.goods_id = t_buy_d".(string)($i+1).".goods_id \n";

// 2007-11-11 コメント
//        $sql .= "   AND t_buy_d".(string)($i+1).".goods_id IS NOT NULL \n";


        // 抽出対象が東陽以外
        if ( $out_abstract ==  "1" ) {
            $sql.=  "   AND \n";
            $sql.=  "   t_buy_d".(string)($i+1).".client_id <> 93 \n";
        } 
    }


    //仕入のない商品は抽出しない（kaji）
    //他画面と仕様が違ってくるけど、419874件→733件まで減らせます
    $sql .= "WHERE \n";
    $sql .= "    ( \n";
    for ( $i = 0; $i < $period; $i++ ) {
        $sql .= "        t_buy_d".(string)($i+1).".goods_id IS NOT NULL \n";
        $sql .= ($i < $period - 1) ? "        OR \n" : "";
    }
    $sql .= "    ) \n";


    $sql.=  "ORDER BY \n";
    $sql.=  "   t_client.client_cd1, \n";
    $sql.=  "   t_client.client_cd2, \n";
    $sql.=  "   t_client.goods_cd \n";
    $sql.=  ";";
    
#    print_array($sql);

    /********************/
    // クエリ実行
    /********************/
    $result = Db_Query($db_con, $sql);

    return $result;
}


/**
 * 本部 売上営業成績    データ抽出用クエリ作成関数
 * FC   担当者別売上推移データ抽出用クエリ作成関数
 * 
 * @author      fukuda
 * @version     1.0.0 (2007/11/03)
 *
 * @param       resource    $db_con         DBコネクション
 * @param       string      $form_data      POST情報
 * @param       integer     $shop_id        セッションのショップID
 * @param       array       $ary_ym         抽出期間の配列（YYYYMM形式）
 *
 * @return                  $res            クエリ実行結果
 *
 */
function Select_Each_Part_Staff_Amount($db_con, $post, $shop_id, $ary_ym){

    //-----------------------------------------------
    // 本部機能用処理
    //-----------------------------------------------
    // 本部機能の場合
    if ($shop_id === "1" ) {

        // ↓の処理で$shop_idを上書きしてしまうので元の値を別の変数に入れておく
        $session_shop_id = $shop_id;

        // 本部はショップの選択必須なので、選択されたショップの売上成績を出力する用の変数設定
        // ショップが選択されている場合は、選択された値を格納
        $shop_id = ($post["form_shop_part"][1] != null) ? $post["form_shop_part"][1] : $shop_id;

    }

    //-----------------------------------------------
    // データ抽出条件作成
    //-----------------------------------------------
    // 一般的な検索条件
    $sql = null;

    // 本部機能の場合
    if ($session_shop_id === "1") {

        // 部署（ID）
        if ($post["form_shop_part"][2] != null) {
            $sql .= "AND \n";
            $sql .= "   t_part.part_id = ".$post["form_shop_part"][2]." \n";
        }

    // FC機能の場合
    } else {

        // 部署（ID）
        if ($post["form_part"] != null) {
            $sql .= "AND \n";
            $sql .= "   t_part.part_id = ".$post["form_part"]." \n";
        }

        // 担当者（ID）
        if ($post["form_staff"] != null) {
            $sql .= "AND \n";
            $sql .= "   t_staff.staff_id = ".$post["form_staff"]." \n";
        }

    }

    // 変数に格納
    $where_sql = $sql;

    //-----------------------------------------------
    // データ抽出クエリ作成
    //-----------------------------------------------
    $sql  = null;

    $sql .= "SELECT \n";

    $sql .= "   t_part.part_cd                                  AS cd,                  \n";
    $sql .= "   t_part.part_name                                AS name,                \n";
    $sql .= "   to_char(t_staff.charge_cd, '0000')              AS cd2,                 \n";
    $sql .= "   t_staff.staff_name                              AS name2,               \n";
    $sql .= "   NULL                                            AS rank_cd,             \n";
    $sql .= "   NULL                                            AS rank_name,           \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "   COALESCE(analysis_".$cnt.".net_amount,  0)      AS net_amount".$cnt.",  \n";
    $sql .= "   COALESCE(analysis_".$cnt.".net_amount,  0) -                            \n";
    $sql .= "   COALESCE(analysis_".$cnt.".cost_amount, 0)      AS arari_gaku".$cnt.",  \n";
    $sql .= "   NULL                                            AS num".$cnt.",         \n";
    }
    $sql .= "   t_attach.shop_id                                                        \n";

    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_part   ON  t_attach.part_id        = t_part.part_id        \n";
    $sql .= "   INNER JOIN t_staff  ON  t_attach.staff_id       = t_staff.staff_id      \n";

    // 指定された期間分ループ
    foreach ($ary_ym as $key => $this_ym) {

        $cnt  = (string)($key + 1);

        // １ヶ月分のデータを結合
        $sql .= "   LEFT JOIN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_attach.part_id, \n";
        $sql .= "           t_attach.staff_id, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN \n";
        $sql .= "                       CASE t_sale_staff.staff_div \n";
        $sql .= "                           WHEN '0' \n";
        $sql .= "                           THEN t_sale_h.cost_amount - COALESCE(t_sale_h_sub.cost_amount, 0) \n";
        $sql .= "                           ELSE trunc(t_sale_h.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                       END \n";
        $sql .= "                   ELSE (t_sale_h.cost_amount - COALESCE(t_sale_h_sub.cost_amount, 0)) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS cost_amount, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN \n";
        $sql .= "                       CASE t_sale_staff.staff_div \n";
        $sql .= "                           WHEN '0' \n";
        $sql .= "                           THEN t_sale_h.net_amount - COALESCE(t_sale_h_sub.net_amount, 0) \n";
        $sql .= "                           ELSE trunc(t_sale_h.net_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                       END \n";
        $sql .= "                   ELSE (t_sale_h.net_amount - COALESCE(t_sale_h_sub.net_amount, 0)) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS net_amount \n";
        $sql .= "       FROM \n";
        $sql .= "           t_sale_h \n";
        $sql .= "           INNER JOIN t_sale_staff ON  t_sale_h.sale_id        = t_sale_staff.sale_id  \n";
        $sql .= "           INNER JOIN t_attach     ON  t_sale_staff.staff_id   = t_attach.staff_id     \n";
        // サブのみの合計金額を集計するサブクエリ
        $sql .= "           LEFT JOIN \n";
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   t_sale_h.sale_id, \n";
        $sql .= "                   SUM(\n";
        $sql .= "                       CASE \n";
        $sql .= "                           WHEN t_sale_staff.staff_div != '0' \n";
        $sql .= "                           THEN trunc(t_sale_h.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                       END \n";
        $sql .= "                   ) AS cost_amount, \n";
        $sql .= "                   SUM(\n";
        $sql .= "                       CASE \n";
        $sql .= "                           WHEN t_sale_staff.staff_div != '0' \n";
        $sql .= "                           THEN trunc(t_sale_h.net_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                       END \n";
        $sql .= "                   ) AS net_amount \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_sale_h \n";
        $sql .= "                   INNER JOIN t_sale_staff ON  t_sale_h.sale_id = t_sale_staff.sale_id \n";
        $sql .= "               WHERE \n";
        $sql .= "                   t_sale_h.shop_id = $shop_id \n";
        $sql .= "               AND \n";
        $sql .= "                   t_sale_h.sale_day LIKE '$this_ym%' \n";
        $sql .= "               AND \n";
        $sql .= "                   t_sale_staff.sale_rate IS NOT NULL \n";
        $sql .= "               AND \n";
        $sql .= "                   t_sale_staff.staff_div != '0' \n";
        $sql .= "               GROUP BY t_sale_h.sale_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS t_sale_h_sub ON  t_sale_h.sale_id = t_sale_h_sub.sale_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_sale_h.shop_id = $shop_id \n";
        $sql .= "       AND \n";
        $sql .= "           t_sale_h.sale_day LIKE '$this_ym%' \n";
        $sql .= "       AND \n";
        $sql .= "           t_sale_staff.sale_rate IS NOT NULL \n";
        $sql .= "       GROUP BY \n";
        $sql .= "           t_attach.part_id, \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "       ORDER BY \n";
        $sql .= "           t_attach.part_id, \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS  analysis_".$cnt." \n";
        $sql .= "   ON  t_part.part_id      = analysis_".$cnt.".part_id \n";
        $sql .= "   AND t_staff.staff_id    = analysis_".$cnt.".staff_id \n";

    }

    // WHERE句
    $sql .= "WHERE \n";
    $sql .= "   t_attach.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_part.part_id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   ( \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "       analysis_".$cnt.".staff_id IS NOT NULL \n";
    $sql .= (count($ary_ym) != $cnt) ? "        OR \n" : "";
    }
    $sql .= "   ) \n";
    $sql .= $where_sql;

    // ソート順
    $sql .= "ORDER BY \n";
    $sql .= "   t_part.part_cd, \n";
    $sql .= "   t_staff.charge_cd \n";
    $sql .= "; \n";

    // デバッグ用
    #print_array($sql, "クエリ");

    //-----------------------------------------------
    // データ抽出実行・結果を返す
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}



/**
 * 担当者別、商品別売上推移データ抽出用クエリ作成関数
 *
 *
 * 仕様
 *
 * �’箴絅如璽燭離機璽咼后▲▲ぅ謄爐陵�無により <br>
 *   以下の表の「表示」の金額として表示する <br>
 *
 *    サービス  |  アイテム  |    表示      <br>
 *  --------------------------------------  <br>
 *       ○     |     ○     |    商品      <br>
 *       ○     |     ×     |  サービス    <br>
 *       ×     |     ○     |    商品      <br>
 *
 * �⊆�社の担当者のみ抽出対象としているので、 <br>
 *   直営では自社巡回の売上のみの集計になる <br>
 *   代行先では代行伝票は「業務代行料」という商品にあがる <br>
 *
 * �８〆�時、 <br>
 *     商品コード、商品名、Ｍ区分、管理区分、商品分類 <br>
 *   が指定された場合はサービスのみの売上データは抽出しない <br>
 *
 * �ぅ�エリの結果を減らすため、 <br>
 *   売上のなかった商品・サービスは取ってきてません <br>
 *   （他画面と仕様が違うみたいですが、全部取得すると動きません）
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     1.1.0 (2007/12/01)
 *
 * @param       resource    $db_con         DBコネクション
 * @param       string      $form_data      POST情報
 *
 * @return      resource    $resut          クエリ実行結果
 *
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/11/03                  kajioka-h   新規作成
 *  2007/11/04                  aizawa-m    rank_cd・rank_nameをNULLで抽出
 *  2007/11/23                  kajioka-h   構成品を抽出するように修正
 *  2007/11/24                  hashimoto-y 「商品+サービス」と「サービス」の売上をUNION
 *  2007/12/01                  kajioka-h   コメント追加、ソースをキレイに（梶岡的に）
 *
 */


//「商品+サービス」と「サービス」をUNIONしたクエリ
//恐らく「商品」と「サービス+商品」をUNIONしたクエリのほうが良い
//12ヶ月実行してもＯＫ

function Select_Each_Staff_Goods_Amount_f($db_con, $form_data)
{

    //セッション
    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    $sql  = "";
    //$sql  = "EXPLAIN \n";


    //商品を抽出するクエリ
    $sql .= "SELECT \n";
    $sql .= "    to_char(t_staff.charge_cd, '0000') AS cd, \n";
    $sql .= "    t_staff.staff_name AS name, \n";

    $sql .= "    t_goods.goods_cd AS cd2, \n";
    $sql .= "    CASE \n";
    $sql .= "        WHEN t_goods.compose_flg = true THEN t_goods.goods_name \n";
    $sql .= "        ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
    $sql .= "    END AS name2, \n";

    $sql .= "    NULL AS rank_cd, \n";  //aizawa-m
    $sql .= "    NULL AS rank_name, \n";// 追加
    $sql .= "    1, \n";    //商品・サービス区分：商品は「1」（一覧で商品、サービスの順に表示するため）
    //指定期間分ループ（取得カラム）
    for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
        //売上金額
        $sql .= "    COALESCE(t_sale_".(string)($i+1).".sale_amount, 0) AS net_amount".(string)($i+1).", \n";
        //粗利益額
        $sql .= "    COALESCE((t_sale_".(string)($i+1).".sale_amount - t_sale_".(string)($i+1).".cost_amount), 0) AS arari_gaku".(string)($i+1).", \n";
        //売上数
        $sql .= "    NULL AS num".(string)($i+1).", \n";
    }
    $sql .= "    t_attach.shop_id \n";  //特に必要ないけど、上のループ終端で「,」を付けない判定をしないため
    $sql .= "FROM \n";
    $sql .= "    t_attach \n";
    $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "        AND t_attach.shop_id = $shop_id \n";
    $sql .= "    INNER JOIN t_goods_info ON t_attach.shop_id = t_goods_info.shop_id \n";
    $sql .= "        AND t_goods_info.shop_id = $shop_id \n";
    $sql .= "    INNER JOIN t_goods ON t_goods_info.goods_id = t_goods.goods_id \n";
    $sql .= "    LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    //所属本支店・部署が指定された場合、部署マスタテーブルを結合
    if($form_data["form_branch"] != null || $form_data["form_part"] != null){
        $sql .= "    INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
    }

    //指定期間分ループ（1ヶ月ごとの集計サブクエリ）
    for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){

        //日付の書式を変える
        $this_date = date("Y-m-", mktime(0, 0, 0, $form_data["form_trade_ym_s"]["m"] + $i, 1, $form_data["form_trade_ym_s"]["y"]));

        //1ヵ月分集計サブクエリ
        $sql .= "    LEFT JOIN ( \n";
        $sql .= "        SELECT \n";
        $sql .= "            t_sale_staff.staff_id, \n";
        $sql .= "            t_sale_d.goods_id, \n";

        //$sql .= "            t_sale_d.serv_id, \n";  //hashimoto追加

        //1ヶ月の原価金額合計
        $sql .= "            SUM( \n";
        $sql .= "                CASE \n";
        $sql .= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN \n";
        $sql .= "                        CASE t_sale_staff.staff_div \n";
        $sql .= "                            WHEN '0' THEN t_sale_d.cost_amount - COALESCE(t_sale_d_sub.cost_amount, 0) \n";
        $sql .= "                            ELSE trunc(t_sale_d.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                        END \n";
        $sql .= "                    ELSE \n";

                                        //値引、返品の場合はメインしかいない
        $sql .= "                            -1 * (t_sale_d.cost_amount - COALESCE(t_sale_d_sub.cost_amount, 0)) \n";
        $sql .= "                END \n";
        $sql .= "            ) AS cost_amount, \n";
        //1ヶ月の売上金額合計
        $sql .= "            SUM( \n";
        $sql .= "                CASE \n";
        $sql .= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN \n";
        $sql .= "                        CASE t_sale_staff.staff_div \n";
        $sql .= "                            WHEN '0' THEN t_sale_d.sale_amount - COALESCE(t_sale_d_sub.sale_amount, 0) \n";
        $sql .= "                            ELSE trunc(t_sale_d.sale_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                        END \n";
        $sql .= "                    ELSE \n";

                                        //値引、返品の場合はメインしかいない
        $sql .= "                            -1 * (t_sale_d.sale_amount - COALESCE(t_sale_d_sub.sale_amount, 0)) \n";
        $sql .= "                END \n";
        $sql .= "            ) AS sale_amount \n";

        $sql .= "        FROM \n";
        $sql .= "            t_sale_h \n";
        $sql .= "            INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "            INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
        //サブのみの合計金額を集計するサブクエリ\n";
        $sql .= "            LEFT JOIN ( \n";
        $sql .= "                SELECT \n";
        $sql .= "                    t_sale_d.sale_d_id, \n";
        $sql .= "                    SUM( \n";
        $sql .= "                        CASE \n";
        $sql .= "                            WHEN t_sale_staff.staff_div != '0' \n";
        $sql .= "                                THEN trunc(t_sale_d.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                        END \n";
        $sql .= "                    ) AS cost_amount, \n";
        $sql .= "                    SUM( \n";
        $sql .= "                        CASE \n";
        $sql .= "                            WHEN t_sale_staff.staff_div != '0' \n";
        $sql .= "                                THEN trunc(t_sale_d.sale_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                        END \n";
        $sql .= "                    ) AS sale_amount \n";
        $sql .= "                FROM \n";
        $sql .= "                    t_sale_h \n";
        $sql .= "                    INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "                    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
        $sql .= "                WHERE \n";
        $sql .= "                    t_sale_h.shop_id = $shop_id \n";
        $sql .= "                    AND \n";
        $sql .= "                    t_sale_h.sale_day LIKE '$this_date%' \n";
        $sql .= "                    AND \n";
        $sql .= "                    t_sale_d.goods_id IS NOT NULL \n";
        $sql .= "                    AND \n";
        $sql .= "                    t_sale_staff.sale_rate IS NOT NULL \n";
        $sql .= "                    AND \n";
        $sql .= "                    t_sale_staff.staff_div != '0' \n";
        $sql .= "                GROUP BY \n";
        $sql .= "                    t_sale_d.sale_d_id \n";
        $sql .= "            ) AS t_sale_d_sub ON t_sale_d.sale_d_id = t_sale_d_sub.sale_d_id \n";
        $sql .= "        WHERE \n";
        $sql .= "            t_sale_h.shop_id = $shop_id \n";
        $sql .= "            AND \n";
        $sql .= "            t_sale_h.sale_day LIKE '$this_date%' \n";
        $sql .= "            AND \n";
        $sql .= "            t_sale_d.goods_id IS NOT NULL \n";
        $sql .= "            AND \n";
        $sql .= "            t_sale_staff.sale_rate IS NOT NULL \n";


        //サービスが選択された場合
        if($form_data["form_serv"] != null){
            $sql .= "            AND \n";
            $sql .= "            t_sale_d.serv_id = ".$form_data["form_serv"]." \n";
        }


        $sql .= "\n";
        $sql .= "        GROUP BY \n";
        $sql .= "            t_sale_staff.staff_id, \n";
        $sql .= "            t_sale_d.goods_id \n";

        //$sql .= "            t_sale_d.serv_id \n"; //hashimoto追加

        $sql .= "    ) AS t_sale_".(string)($i+1)." ON t_staff.staff_id = t_sale_".(string)($i+1).".staff_id \n";
        $sql .= "        AND t_goods.goods_id = t_sale_".(string)($i+1).".goods_id \n";

    }

    //WHERE句生成
    $sql .= "WHERE \n";

    //担当者が指定された場合
    if($form_data["form_staff"] != null){
        $sql .= "    t_staff.staff_id = ".$form_data["form_staff"]." \n";
        $sql .= "    AND \n";
    //未指定は在職中の担当者
    }else{
        //$sql .= "    t_staff.state = '在職中' \n";
        //$sql .= "    AND \n";
    }

    //所属本支店が指定された場合
    if($form_data["form_branch"] != null){
        $sql .= "    t_part.branch_id = ".$form_data["form_branch"]." \n";
        $sql .= "    AND \n";
    }

    //部署が指定された場合
    if($form_data["form_part"] != null){
        $sql .= "    t_part.part_id = ".$form_data["form_part"]." \n";
        $sql .= "    AND \n";
    }

    //商品コードが指定された場合
    if($form_data["form_goods"]["cd"] != null){
        $sql .= "    t_goods.goods_cd LIKE '".$form_data["form_goods"]["cd"]."%' \n";
        $sql .= "    AND \n";
    }

    //商品名が指定された場合
    if($form_data["form_goods"]["name"] != null){
        $sql .= "    t_goods.goods_name LIKE '%".$form_data["form_goods"]["name"]."%' \n";
        $sql .= "    AND \n";
    }

    //Ｍ区分が指定された場合
    if($form_data["form_g_goods"] != null){
        $sql .= "    t_goods.g_goods_id = ".$form_data["form_g_goods"]." \n";
        $sql .= "    AND \n";
    }

    //管理区分が指定された場合
    if($form_data["form_product"] != null){
        $sql .= "    t_goods.product_id = ".$form_data["form_product"]." \n";
        $sql .= "    AND \n";
    }

    //商品分類が指定された場合
    if($form_data["form_g_product"] != null){
        $sql .= "    t_goods.g_product_id = ".$form_data["form_g_product"]." \n";
        $sql .= "    AND \n";
    }


    //サービスが指定された場合
    #if($form_data["form_serv"] != null){

    #    for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
    #        $sql .= "        t_sale_".(string)($i+1).".serv_id = ".$form_data["form_serv"]." \n";
    #        $sql .= "    AND \n";
    #    }

    #}




    $sql .= "    ( \n";
    //指定期間分ループ
    for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
        $sql .= "        t_sale_".(string)($i+1).".goods_id IS NOT NULL \n";
        $sql .= ($i < $form_data["form_trade_ym_e"] - 1) ? "        OR \n" : "";
    }
    $sql .= "    ) \n";



    switch ($form_data) {

        //以下の条件では、サービスを抽出するクエリはUNIONしない
        case $form_data["form_goods"]["cd"] != null :   //商品コードが指定された場合
        case $form_data["form_goods"]["name"] != null : //商品名が指定された場合
        case $form_data["form_g_goods"] != null :       //Ｍ区分が指定された場合
        case $form_data["form_product"] != null :       //管理区分が指定された場合
        case $form_data["form_g_product"] != null :     //商品分類が指定された場合
            break;
        default:


        $sql .= "\n";
        $sql .= "UNION \n";
        $sql .= "\n";


        //サービスのみを抽出するクエリ
        $sql .= "SELECT \n";
        $sql .= "    to_char(t_staff.charge_cd, '0000') AS cd, \n";
        $sql .= "    t_staff.staff_name AS name, \n";

        $sql .= "    t_serv.serv_cd AS cd2, \n";
        $sql .= "    t_serv.serv_name AS name2, \n";

        $sql .= "    NULL AS rank_cd, \n";  //aizawa-m
        $sql .= "    NULL AS rank_name, \n";// 追加
        $sql .= "    2, \n";    //商品・サービス区分：サービスは「2」（一覧で商品、サービスの順に表示するため）
        //指定期間分ループ（取得カラム）
        for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
            //売上金額
            $sql .= "    COALESCE(t_sale_".(string)($i+1).".sale_amount, 0) AS net_amount".(string)($i+1).", \n";
            //粗利益額
            $sql .= "    COALESCE((t_sale_".(string)($i+1).".sale_amount - t_sale_".(string)($i+1).".cost_amount), 0) AS arari_gaku".(string)($i+1).", \n";
            //売上数
            $sql .= "    NULL AS num".(string)($i+1).", \n";
        }
        $sql .= "    t_attach.shop_id \n";  //特に必要ないけど、上のループ終端で「,」を付けない判定をしないため
        $sql .= "FROM \n";
        $sql .= "    t_attach \n";
        $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
        $sql .= "        AND t_attach.shop_id = $shop_id \n";
        $sql .= "    CROSS JOIN t_serv \n";
        //所属本支店・部署が指定された場合、部署マスタテーブルを結合
        if($form_data["form_branch"] != null || $form_data["form_part"] != null){
            $sql .= "    INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        }

        //指定期間分ループ（1ヶ月ごとの集計サブクエリ）
        for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){

            //日付の書式を変える
            $this_date = date("Y-m-", mktime(0, 0, 0, $form_data["form_trade_ym_s"]["m"] + $i, 1, $form_data["form_trade_ym_s"]["y"]));

            //1ヵ月分集計サブクエリ
            $sql .= "    LEFT JOIN ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            t_sale_staff.staff_id, \n";
            $sql .= "            t_sale_d.serv_id, \n";
            //1ヶ月の原価金額合計
            $sql .= "            SUM( \n";
            $sql .= "                CASE \n";
            $sql .= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN \n";
            $sql .= "                        CASE t_sale_staff.staff_div \n";
            $sql .= "                            WHEN '0' THEN t_sale_d.cost_amount - COALESCE(t_sale_d_sub.cost_amount, 0) \n";
            $sql .= "                            ELSE trunc(t_sale_d.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
            $sql .= "                        END \n";
            $sql .= "                    ELSE \n";

                                        //値引、返品の場合はメインしかいない
            $sql .= "                            -1 * (t_sale_d.cost_amount - COALESCE(t_sale_d_sub.cost_amount, 0)) \n";
            $sql .= "                END \n";
            $sql .= "            ) AS cost_amount, \n";
            //1ヶ月の売上金額合計
            $sql .= "            SUM( \n";
            $sql .= "                CASE \n";
            $sql .= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN \n";
            $sql .= "                        CASE t_sale_staff.staff_div \n";
            $sql .= "                            WHEN '0' THEN t_sale_d.sale_amount - COALESCE(t_sale_d_sub.sale_amount, 0) \n";
            $sql .= "                            ELSE trunc(t_sale_d.sale_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
            $sql .= "                        END \n";
            $sql .= "                    ELSE \n";

                                        //値引、返品の場合はメインしかいない
            $sql .= "                            -1 * (t_sale_d.sale_amount - COALESCE(t_sale_d_sub.sale_amount, 0)) \n";
            $sql .= "                END \n";
            $sql .= "            ) AS sale_amount \n";

            $sql .= "        FROM \n";
            $sql .= "            t_sale_h \n";
            $sql .= "            INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
            $sql .= "            INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            //サブのみの合計金額を集計するサブクエリ
            $sql .= "            LEFT JOIN ( \n";
            $sql .= "                SELECT \n";
            $sql .= "                    t_sale_d.sale_d_id, \n";
            $sql .= "                    SUM( \n";
            $sql .= "                        CASE \n";
            $sql .= "                            WHEN t_sale_staff.staff_div != '0' \n";
            $sql .= "                                THEN trunc(t_sale_d.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
            $sql .= "                        END \n";
            $sql .= "                    ) AS cost_amount, \n";
            $sql .= "                    SUM( \n";
            $sql .= "                        CASE \n";
            $sql .= "                            WHEN t_sale_staff.staff_div != '0' \n";
            $sql .= "                                THEN trunc(t_sale_d.sale_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
            $sql .= "                        END \n";
            $sql .= "                    ) AS sale_amount \n";
            $sql .= "                FROM \n";
            $sql .= "                    t_sale_h \n";
            $sql .= "                    INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
            $sql .= "                    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            $sql .= "                WHERE \n";
            $sql .= "                    t_sale_h.shop_id = $shop_id \n";
            $sql .= "                    AND \n";
            $sql .= "                    t_sale_h.sale_day LIKE '$this_date%' \n";
            $sql .= "                    AND \n";
            $sql .= "                    t_sale_d.goods_id IS NULL \n";
            $sql .= "                    AND \n";
            $sql .= "                    t_sale_staff.sale_rate IS NOT NULL \n";
            $sql .= "                    AND \n";
            $sql .= "                    t_sale_staff.staff_div != '0' \n";
            $sql .= "                GROUP BY \n";
            $sql .= "                    t_sale_d.sale_d_id \n";
            $sql .= "            ) AS t_sale_d_sub ON t_sale_d.sale_d_id = t_sale_d_sub.sale_d_id \n";
            $sql .= "        WHERE \n";
            $sql .= "            t_sale_h.shop_id = $shop_id \n";
            $sql .= "            AND \n";
            $sql .= "            t_sale_h.sale_day LIKE '$this_date%' \n";
            $sql .= "            AND \n";
            $sql .= "            t_sale_d.goods_id IS NULL \n";
            $sql .= "            AND \n";
            $sql .= "            t_sale_staff.sale_rate IS NOT NULL \n";
            $sql .= "\n";
            $sql .= "        GROUP BY \n";
            $sql .= "            t_sale_staff.staff_id, \n";
            $sql .= "            t_sale_d.serv_id \n";
            $sql .= "    ) AS t_sale_".(string)($i+1)." ON t_staff.staff_id = t_sale_".(string)($i+1).".staff_id \n";
            $sql .= "        AND t_serv.serv_id = t_sale_".(string)($i+1).".serv_id \n";

            if($form_data["form_serv"] != null){
                $sql .= "    AND t_serv.serv_id = ".$form_data["form_serv"]." \n";
            }

        }

        //WHERE句生成
        $sql .= "WHERE \n";

        //担当者が指定された場合
        if($form_data["form_staff"] != null){
            $sql .= "    t_staff.staff_id = ".$form_data["form_staff"]." \n";
            $sql .= "    AND \n";
        //未指定は在職中の担当者
        }else{
            //$sql .= "    t_staff.state = '在職中' \n";
            //$sql .= "    AND \n";
        }

        //所属本支店が指定された場合
        if($form_data["form_branch"] != null){
            $sql .= "    t_part.branch_id = ".$form_data["form_branch"]." \n";
            $sql .= "    AND \n";
        }

        //部署が指定された場合
        if($form_data["form_part"] != null){
            $sql .= "    t_part.part_id = ".$form_data["form_part"]." \n";
            $sql .= "    AND \n";
        }

        #//商品コードが指定された場合
        #if($form_data["form_goods"]["cd"] != null){
        #    $sql .= "    t_goods.goods_cd LIKE '".$form_data["form_goods"]["cd"]."%' \n";
        #    $sql .= "    AND \n";
        #}

        #//商品名が指定された場合
        #if($form_data["form_goods"]["name"] != null){
        #    $sql .= "    t_goods.goods_name LIKE '%".$form_data["form_goods"]["name"]."%' \n";
        #    $sql .= "    AND \n";
        #}

        #//Ｍ区分が指定された場合
        #if($form_data["form_g_goods"] != null){
        #    $sql .= "    t_goods.g_goods_id = ".$form_data["form_g_goods"]." \n";
        #    $sql .= "    AND \n";
        #}

        #//管理区分が指定された場合
        #if($form_data["form_product"] != null){
        #    $sql .= "    t_goods.product_id = ".$form_data["form_product"]." \n";
        #    $sql .= "    AND \n";
        #}

        #//商品分類が指定された場合
        #if($form_data["form_g_product"] != null){
        #    $sql .= "    t_goods.g_product_id = ".$form_data["form_g_product"]." \n";
        #    $sql .= "    AND \n";
        #}

        $sql .= "    ( \n";
        //指定期間分ループ
        for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
            $sql .= "        t_sale_".(string)($i+1).".serv_id IS NOT NULL \n";
            $sql .= ($i < $form_data["form_trade_ym_e"] - 1) ? "        OR \n" : "";
        }
        $sql .= "    ) \n";


    } //switch終了


    $sql .= "ORDER BY \n";
    $sql .= "    1, \n";    //スタッフマスタ.担当者コード
    $sql .= "    7, \n";    //商品・サービス区分
    $sql .= "    3 \n";     //商品マスタ.商品コード or サービスマスタ.サービスコード
    $sql .= ";\n";


//print_array($sql);


    $result = Db_Query($db_con, $sql);
/*
$count = pg_num_rows($result);
print_array($count);
*/
#print_array($form_data);

/*
$result_array = pg_fetch_all($result);
print_array($result_array);
$result = false;
*/

    return $result;

}

?>
