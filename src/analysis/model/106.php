<?php

/**
 * 業種別得意先(FC)別 売上推移
 *
 * @file    106.php
 * 
 */

/****************************/
// 基本設定
/****************************/

//グループ種別の取得
$group_kind = $_SESSION["group_kind"];
//本部の場合
if ( $group_kind == '1' ) {
    //ページタイトル
    $page_title = "業種別FC別売上推移"; //ページタイトル

    //csvタイトル
    $csv_head[] = "業種コード";
    $csv_head[] = "業種名";
    $csv_head[] = "FC・取引先コード";
    $csv_head[] = "FC・取引先名";         //取引先
    $csv_head[] = "FC・取引先区分コード";  //FC・取引先区分
    $csv_head[] = "FC・取引先区分名";      //FC・取引先区分

} else {
    //ページタイトル
    $page_title = "業種別得意先別売上推移";

    //csvタイトル
    $csv_head[] = "業種コード";
    $csv_head[] = "業種名";
    $csv_head[] = "得意先コード";
    $csv_head[] = "得意先名";             
}

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();


/****************************/
// フォームパーツ定義
/****************************/
//フォーム作成関数
Mk_Form($db_con, $form);


/****************************/
// 表示ボタン押下
/****************************/
$out_flg    = false;
$rate_flg   = false;
if ( $_POST["form_display"] == "表　示" ) {
    //日付のエラーチェック関数
    Err_Chk_Date_YM($form, "form_trade_ym_s");

    /*******************/
    // エラーなし
    /*******************/
    if ( $form->validate()) {
        //クエリ実行関数
        $result     = Select_Each_Type_Customer_Amount($db_con, $_POST);
        //表のタイトルを取得
        $disp_head  = Get_Header_YM($_POST["form_trade_ym_s"]["y"], 
                                    $_POST["form_trade_ym_s"]["m"], 
                                    $_POST["form_trade_ym_e"] );
        //集計関数
        $disp_data  = Edit_Query_Data_Hogepiyo($result, $_POST);

        //出力フラグ
        $out_flg    = true;
        //粗利率表示の判定フラグ
        if ( $_POST["form_margin"] == "1" ) {
            $margin_flg = true;
        }

        /**********************/
        // CSV出力
        /**********************/
        if ( $_POST["form_output_type"] == "2") {
           
            $csvobj = new Analysis_Csv_Class($margin_flg,false);
            $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

            //CSV項目名作成
            $csvobj->Make_Csv_Head($disp_head, $csv_head);
            $csvobj->Make_Csv_Data($disp_data);

            //CSV出力
            Header("Content-disposition: attachment; filename=".$csvobj->filename);
            Header("Content-type: application/octet-stream; name=".$csvobj->filename);
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
//本部の場合
if ( $group_kind == "1" ) {
    $page_menu = Create_Menu_f('analysis','1');
}


/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);


/****************************/
//Smartyの設定
/****************************/
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
	'group_kind'    => "$group_kind",
));

//assign
$smarty->assign("disp_head", $disp_head);   //テーブルタイトル
$smarty->assign("disp_data", $disp_data);   //一覧データ
$smarty->assign("out_flg", $out_flg);       //出力フラグ
$smarty->assign("margin_flg", $margin_flg);       //粗利率出力フラグ

//テンプレートへ値を渡す
$smarty->display(basename("106.php.tpl"));



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
/*function Select_Each_Type_Customer_Amount ( $db_con, $post ) {

    /*****************************/
    // SESSION変数の取得
    /*****************************/
/*    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /****************************/
    // 引数から検索条件を取得
    /****************************/
/*    $start_y        = $post["form_trade_ym_s"]["y"];    //集計期間(年)
    $start_m        = $post["form_trade_ym_s"]["m"];    //集計期間(月)
    $period         = $post["form_trade_ym_e"];         //集計期間
    $lbtype_id      = $post["form_lbtype"];             //業種ID
    $client_cd1     = $post["form_client"]["cd1"];      //得意先コード1
    $client_cd2     = $post["form_client"]["cd2"];      //得意先コード2
    $client_name    = $post["form_client"]["name"];     //得意先名
    $rank_cd        = $post["form_rank"];               //FC・取引先区分コード
    $client_gr_id   = $post["form_client_gr"]["cd"];    //グループID
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
/*
    // ------ 業種ごとでまとめる ------ //
    $sql.=  "SELECT \n";
    $sql.=  "   t_lbtype.lbtype_cd, \n";        //大分類業種コード
    $sql.=  "   t_lbtype.lbtype_name, \n";      //大分類業種名
    $sql.=  "   t_client_new.cd, \n";           //得意先コード
    $sql.=  "   t_client_new.name, \n";         //得意先名
    //集計期間分の売上金額を取得
    for ( $i=0 ; $i<$period ; $i++ ) {
        $sql.=  "t_client_new.net_amount".(string)($i+1).", \n";    //毎月の売上金額
        $sql.=  "t_client_new.arari_gaku".(string)($i+1).", \n";    //毎月の粗利益額
    }
    $sql.=  "   t_client_new.rank_cd, \n";      //FC・取引先区分コード
    $sql.=  "   t_client_new.rank_name \n";     //FC・取引先区分名
    $sql.=  "FROM \n";
    $sql.=  "   t_lbtype \n";//大分類マスタ


    //------ 得意先ごとの毎月の合計を取得 START ------ //
    $sql.=  "       INNER JOIN  \n";//t_client_new
    $sql.=  "          ( SELECT \n";
    $sql.=  "               t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";//得意先ｺｰﾄﾞ
    $sql.=  "               t_client.client_cname AS name, \n";     //得意先名
    $sql.=  "               t_client.rank_cd AS rank_cd, \n";       //FC・取引先区分コード
    $sql.=  "               t_rank.rank_name AS rank_name, \n";     //FC・取引先区分名
    for ( $i=0 ; $i<$period ; $i++ ) {
        $sql.=  "   COALESCE( \n";  //売上金額
        $sql.=  "      t_sale_h".(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).", \n";
        $sql.=  "   COALESCE( \n";  //粗利益額
        $sql.=  "      t_sale_h".(string)($i+1).".arari_gaku, 0) AS arari_gaku".(string)($i+1).", \n";
    }
    $sql.=  "               t_client.shop_id, \n";          //ショップID
    $sql.=  "               t_sbtype.lbtype_id  \n";        //業種ID
    
    $sql.=  "           FROM \n";
    $sql.=  "           ( \n";// t_rank
    $sql.=  "               t_client \n";
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
    $sql.=  "           ) \n";
    $sql.=  "           LEFT  JOIN t_rank   ON t_rank.rank_cd       = t_client.rank_cd \n";
    $sql.=  "           INNER JOIN t_sbtype ON t_sbtype.sbtype_id   = t_client.sbtype_id \n"; 

    $sql.=  "       WHERE \n";
    $sql.=  "               t_client.shop_id = $shop_id \n";
    $sql.=  "           AND \n";
    $sql.=  "               t_client.client_div = $client_div \n";

    /*******************************/
    // 検索条件の追加
    /*******************************/
/*    if ( $client_cd1 != NULL ) { 
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
        $sql.=  "           (   SELECT \n";
        $sql.=  "                   t_client_gr.client_gr_id \n";
        $sql.=  "               FROM \n";
        $sql.=  "                   t_client_gr \n";
        $sql.=  "               WHERE \n";
        $sql.=  "                   t_client_gr.client_gr_id = t_client.client_gr_id ) \n";
        $sql.=  "           = $client_gr_id \n";
    }
    if ( $client_gr_name != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           (   SELECT \n";
        $sql.=  "                   t_client_gr.client_gr_name \n";
        $sql.=  "               FROM \n";
        $sql.=  "                   t_client_gr \n";
        $sql.=  "               WHERE \n";
        $sql.=  "                   t_client_gr.client_gr_id = t_client.client_gr_id ) \n";
        $sql.=  "           LIKE '%$client_gr_name%' \n";
    }
    $sql.=  "   ) t_client_new ON t_client_new.lbtype_id = t_lbtype.lbtype_id \n";
    // ------- 得意先ごとの毎月の合計を取得 END -------- //

    // 「業種」の検索条件    
    if ( $lbtype_id != NULL ) {
        $sql.=  "WHERE \n";
        $sql.=  "   t_lbtype.lbtype_id = $lbtype_id \n";
    }

    $sql.=  "ORDER BY \n";
    $sql.=  "   t_lbtype.lbtype_cd \n";
    $sql.=  ";";
   
    echo nl2br($sql);

    /***********************/
    // クエリの実行
    /***********************/
/*    $result = Db_Query($db_con, $sql);
    
    return $result;

}
*/

?>
