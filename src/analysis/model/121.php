<?php

/*
 * 履歴：
 *  日付        担当者      内容
 *-----------------------------------------------
 *  2007-10-17  aizawa-m    新規作成
 *
 * @file       121.php
 *  
 * 適用範囲：   仕入先別商品別仕入推移( 1-6-121.php, 2-6-121.php ) 
 *              
 */

//メモリを増やす
//var_dump(ini_set('memory_limit', '32M'));

// デバックフラグ
 $proc_flg   = true;
//$proc_flg   = false;
$start  = microtime();

/***********************/
// 基本設定
/***********************/
$page_title = "仕入先別商品別仕入推移";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();


/***********************/
// SESSIONから取得
/***********************/
$group_kind = $_SESSION["group_kind"];


/****************************/
// フォームパーツ定義
/****************************/
// フォーム作成関数 
Mk_Form($db_con, $form);

//本部の場合
if ($group_kind == "1") {
    //csvタイトル
    $csv_head[] = "FC・取引先コード";
    $csv_head[] = "FC・取引先名";
    $csv_head[] = "FC・取引先区分コード";
    $csv_head[] = "FC・取引先区分名";
    $csv_head[] = "商品コード";
    $csv_head[] = "商品名";

} else {
    $obj    = null;
    $obj[]  = $form->createElement("text", "cd1", "", "size=\"7\" maxlength=\"6\" onKeyDown=\"chgKeycode();\" onFocus=\"onForm(this);\" onBlur=\"blurForm(this);\" class=\"ime_disabled\"");
    $obj[]  = $form->createElement("text", "name", "", "size=\"34\" maxLength=\"25\" onKeyDown=\"chgkeycode();\" onFocus=\"onForm(this);\" onBlur=\"blurForm(this);\"");
    $form->addGroup($obj, "form_client");

    //csvタイトル
    $csv_head[] = "仕入先コード";
    $csv_head[] = "仕入先名";
    $csv_head[] = "商品コード";
    $csv_head[] = "商品名";
}



/***************************/
// 表示ボタン押下
/***************************/
if ( $_POST["form_display"] == "表　示" ) {

    //日付のエラーチェック関数
    Err_Chk_Date_YM($form, "form_trade_ym_s");


    /*******************/
    // エラーなし
    /*******************/
    if ( $form->validate()) {
        //出力フラグ
        $out_flg    = true;

        $sql_s = microtime();
        //クエリ実行関数
        $result     = Select_Each_Goods_Supplier ($db_con, $_POST);
        $sql_e = microtime();

        //表のタイトル
        $disp_head  = Get_Header_YM($_POST["form_trade_ym_s"]["y"],
                                    $_POST["form_trade_ym_s"]["m"],
                                    $_POST["form_trade_ym_e"] );

        $edit_s = microtime();
        //ほげぴよ集計関数
        $disp_data  = Edit_Query_Data_Hogepiyo($result, $_POST);

//        $disp_data  = Edit_Query_Data_Hogepiyo2($result, $_POST);

        //↓ 小計を出さない集計関数 aizawa-m
##        $disp_data      = Edit_Query_Data2($result, $_POST);
#print_array($disp_data);
        $edit_e = microtime();

        /***********************/
        // 出力対象がCSVの場合
        /***********************/
        if ($_POST["form_output_type"] == "2") {

            $csvobj = new Analysis_Csv_Class(false, true, false);
            $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

            // CSV項目名作成
            $csvobj->Make_Csv_Head($disp_head, $csv_head);
            $csvobj->Make_Csv_Data($disp_data, true);

            // CSV出力
            Header("Content-disposition: attachment; filename=".$csvobj->filename);
            Header("Content-type; application/octet-stream; name=".$csvobj->filename);
            print $csvobj->res_csv;
            exit;
        }
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
//$page_menu = Create_Menu_h('analysis','1');

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
	'group_kind'    => "$group_kind",
));

//assign
$smarty->assign("disp_head", $disp_head);
$smarty->assign("disp_data", $disp_data);
$smarty->assign("out_flg",   $out_flg);


//テンプレートへ値を渡す
$smarty->display(basename("121.php.tpl"));
//$smarty->display(basename("121_test.php.tpl"));
//$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

$end = microtime();

// デバック用　処理速度出力判定
if ($proc_flg === false) {

    $sql_s = Cnt_Microtime($sql_s);
    $sql_e = Cnt_Microtime($sql_e);
    $edit_e = Cnt_Microtime($edit_e);
    $edit_s = Cnt_Microtime($edit_s);
    $end    = Cnt_Microtime($end);
    $start  = Cnt_Microtime($start);

    echo "<br>";
    echo "クエリ　:".($sql_e-$sql_s);
    echo "<br>";
    echo "集計時間:".($edit_e-$edit_s);
    echo "<br>";
    echo "全体の処理時間:".($end-$start);
}


/*
 * DEBUG用
 * microtime() 編集関数
 */
/*function Cnt_Microtime($micro_time){

    $arr    = explode(" ", $micro_time);

    $second = (float)$arr[0]+(float)$arr[1];

    return $second;

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
/*function Select_Each_Goods_Supplier ($db_con, $_POST) {

    /***********************/
    // SESSION変数の取得
    /***********************/
/*    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /***********************/
    // 検索条件を取得
    /***********************/
/*    $period         = $_POST["form_trade_ym_e"];   
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
/*
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
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".goods_id , NULL) AS goods_id".(string)($i+1).", \n";
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
    $sql .= "           INNER JOIN  \n";
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
/*
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
  /*      $sql .= "       AND \n";
        $sql .= "       t_buy_h.buy_day LIKE '$like_day%' \n";

        $sql .= "   GROUP BY \n";
        $sql .= "       t_buy_h.client_id, \n";
        $sql .= "       t_buy_d.goods_id \n";
        $sql .= "   ) AS t_buy_d".(string)($i+1). " \n";
        $sql .= "   ON t_client.client_id = t_buy_d".(string)($i+1).".client_id \n";
        $sql .= "   AND t_client.goods_id = t_buy_d".(string)($i+1).".goods_id \n";

// 2007-11-11 コメント
///        $sql .= "   AND t_buy_d".(string)($i+1).".goods_id IS NOT NULL \n";


        // 抽出対象が東陽以外
        if ( $out_abstract ==  "1" ) {
            $sql.=  "   AND \n";
            $sql.=  "   t_buy_d".(string)($i+1).".client_id <> 93 \n";
        } 
    }



    $sql.=  "ORDER BY \n";
    $sql.=  "   t_client.client_cd1, \n";
    $sql.=  "   t_client.client_cd2 \n";
    $sql.=  ";";
    
#    print_array($sql);

    /********************/
    // クエリ実行
    /********************/
/*    $result = Db_Query($db_con, $sql);

    return $result;


//----------------------------------------------------------------------------------------------------------------------------
//以下は先週までのクエリです。

    //------- 得意先情報 --------------------------//
/*    
    $sql =  "SELECT \n";
    if ( $group_kind == "1" ) { 
        //本部の場合は、得意先コード１と得意先コード２を抽出
        $sql.=  "   t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";
    } else {
        //FCの場合は、得意先コード１のみ抽出
        $sql.=  "   t_client.client_cd1 AS cd, \n";
    }
    $sql.=  "   t_client.client_cname AS name, \n"; 

    $sql.=  "   t_goods.goods_cd AS cd2, \n";
    $sql.=  "    t_g_product.g_product_name || ' ' || t_goods.goods_name AS name2, \n";

    for ($i = 0; $i < $period; $i++ ) {
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).",";
        $sql.=  "   0 AS arari_gaku".(string)($i+1).",";
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".num , 0) AS num".(string)($i+1).",";
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".goods_id , NULL) AS goods_id".(string)($i+1).",";
    }

    $sql.=  "   t_client.rank_cd AS rank_cd, \n";       //FC・取引先区分コード
    $sql.=  "   t_rank.rank_name AS rank_name, \n";     //FC・取引先区分名

    $sql.=  "   t_client.shop_id \n";

    $sql.=  "FROM \n";
    $sql.=  "   t_client \n";

    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_goods_info \n";//
    $sql.=  "ON t_client.shop_id = t_goods_info.shop_id \n";//
    $sql.= "AND t_goods_info.shop_id = $shop_id \n";

    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_goods \n";//
    $sql.=  "ON t_goods_info.goods_id = t_goods.goods_id \n";//

    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_g_product \n";//
    $sql.=  "ON t_goods.g_product_id = t_g_product.g_product_id \n";//


    $sql.=  "LEFT JOIN  \n";
    $sql.=  "   t_rank \n";
    $sql.=  "ON t_client.rank_cd = t_rank.rank_cd \n";



    for ( $i = 0; $i < $period; $i++ ) {
        // 日付の書式を変える
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));

        $sql.=  "       LEFT JOIN \n";
        $sql.=  "               (   SELECT \n";
        $sql.=  "                       t_buy_h.client_id, \n"; 
        $sql.=  "                       t_buy_d.goods_id, \n"; 
        $sql.=  "                       SUM ( \n";
        $sql.=  "                           CASE \n";
        $sql.=  "                               WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
        $sql.=  "                               THEN t_buy_d.buy_amount \n";
        $sql.=  "                               ELSE -1 * t_buy_d.buy_amount \n";   
        $sql.=  "                           END \n";
        $sql.=  "                       ) AS net_amount, \n";
        $sql.=  "                       SUM ( t_buy_d.num ) AS num \n";
        $sql.=  "                   FROM \n";
        $sql.=  "                       t_buy_h INNER JOIN t_buy_d \n"; 
        $sql.=  "                           ON t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql.=  "                   WHERE \n";
        $sql.=  "                           t_buy_h.buy_day >= '$this_date' \n";
        $sql.=  "                       AND \n";
        $sql.=  "                           t_buy_h.buy_day < '$next_date' \n";
        $sql.=  "                       AND \n";
        $sql.=  "                           t_buy_h.shop_id = $shop_id \n";
        $sql.=  "                   GROUP BY \n";
        $sql.=  "                       t_buy_d.goods_id, \n";
        $sql.=  "                       t_buy_h.client_id \n";
        $sql.=  "                   ORDER BY \n";
        $sql.=  "                       t_buy_h.client_id, \n";
        $sql.=  "                       t_buy_d.goods_id \n";
        $sql.=  "       ) AS t_buy_d".(string)($i+1). " \n";
        $sql.=  "               ON t_client.client_id = t_buy_d".(string)($i+1).".client_id \n";

        // 抽出対象が東陽以外
        if ( $out_abstract ==  "1" ) {
            $sql.=  "           AND \n";
            $sql.=  "               t_buy_d".(string)($i+1).".client_id <> 93 \n";
        }
 

    }

    $sql.=  "WHERE \n";
    $sql.=  "       t_client.shop_id = $shop_id \n";
    $sql.=  "   AND \n";
    $sql.=  "       t_client.client_div = $client_div \n";

    // 検索条件の追加
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



    $sql.=  "ORDER BY \n";
    $sql.=  "   client_cd1, \n";
    $sql.=  "   client_cd2 \n";

    $sql.=  ";";
   */ 

//----------------------------------------------------------------------------------------------------------------------------







/*    $sql.=  "SELECT \n";
    if ( $group_kind == "1" ) {
       $sql.=   "t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";
    } else {
        $sql.=  "t_client.client_cd1, \n";
    }
    $sql.=  "   t_client.client_cname AS name, \n";
    $sql.=  "   t_client.rank_cd AS rank_cd, \n";
    $sql.=  "   t_rank.rank_name AS rank_name, \n";
    for ( $i=0 ; $i<$period ; $i++ ) {
        $sql.=  "   COALESCE( t_buy_d".(string)($i+1).".buy_amount, 0) AS buy_amount".(string)($i+1).", \n";   
        $sql.=  "   COALESCE( t_buy_d".(string)($i+1).".num, 0) AS num".(string)($i+1).", \n";   
    }


    $sql.=  "   t_client.shop_id \n";
    $sql.=  "FROM \n";

    $sql.=  " ( \n";
    $sql.=  "   t_client \n";
    $sql.=  "       LEFT JOIN t_buy_h ON \n";
    $sql.=  "               t_client.client_id = t_buy_h.client_id \n"; 
    $sql.=  "           AND \n";
    $sql.=  "               t_buy_h.shop_id = $shop_id \n";
    $sql.=  "           AND \n";
    $sql.=  "               t_buy_h.buy_day >= '".$start_y.$start_m."01' \n";
    $sql.=  " ) \n";
    $sql.=  "   LEFT JOIN t_rank ON t_client.rank_cd = t_rank.rank_cd \n";
    $sql.=  ";";    


    $sql.=  "SELECT \n";

    for ( $i=0 ; $i<$period ; $i++ ) {
        //日付の書式をかえる
        $this_date  = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date  = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));

        $sql.=  "   LEFT JOIN ( \n";
        $sql.=  "       SELECT \n";
        $sql.=  "           client_id \n";
        $sql.=  "       FROM \n";
        $sql.=  "           t_buy_h \n";
        $sql.=  "               LEFT JOIN ( \n";
        $sql.=  "                   SELECT \n";
        $sql.=  "                       buy_id, \n";
        $sql.=  "                       goods_id, \n";
        $sql.=  "                       buy_amount, \n";
        $sql.=  "                       num \n";
        $sql.=  "                   FROM \n";
        $sql.=  "                     ( \n";
        $sql.=  "                       SELECT \m";
        $sql.=  "                           SUM( \n";
        $sql.=  "                               CASE \n";
        $sql.=  "                                   WHEN trade_id IN (11, 15, 61) THEN buy_amount \n";
        $sql.=  "                                   ELSE -1 * buy_amount \n";
        $sql.=  "                           ) AS buy_amount, \n";
        $sql.=  "                           SUM ( num ) AS num, \n";
        $sql.=  "                           goods_id \n";
        $sql.=  "                       FROM \n";
        $sql.=  "                           t_buy_d \n";
        $sql.=  "                       GROUP BY \n";    
        $sql.=  "                           goods_id \n";
        $sql.=  "                   ) t_buy_d \n";
        $sql.=  "               ) AS t_buy_d".(string)($i+1)." ON t_buy_h.buy_id = t_buy_d".(string)($i+1).".buy_id \n";
        $sql.=  "   ) AS t_buy_h".(string)($i+1)." ON t_client.client_id = t_buy_h".(string)($i+1)."client_id  \n"; 

    }



}
*/

?>
