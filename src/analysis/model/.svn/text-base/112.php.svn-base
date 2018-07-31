<?php
/*
 * 履歴：
 *  日付        担当者          内容
 *-----------------------------------------------
 *  2007-11-23  aizawa-m      新規作成
 *
 *  @model  112.php ( FC別ABC分析、得意先別ABC分析）
 *
 */

/**************************/
// 基本設定
/*************************/

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

// DB接続
$db_con = Db_Connect();

// セッションから取得
$group_kind = $_SESSION["group_kind"];
// ページタイトル
if ( $group_kind == "1" ) {
    // 本部の場合
    $page_title = "FC別ABC分析";

    // CSV項目名作成
    $csv_head = array(  "FC・取引先コード",
                        "FC・取引先名",
                        "FC・取引先区分コード",
                        "FC・取引先区分名"
                    );
} else {
    $page_title = "得意先別ABC分析";

    // CSV項目名作成
    $csv_head = array(  "得意先コード",
                        "得意先名"
                    );
}


/*******************************/
// フォームオブジェクト作成
/*******************************/
// フォームの作成
Mk_Form($db_con, $form);

// エラーメッセージ作成
Err_Chk_Date_YM($form, "form_trade_ym_s");


/**************************/
// POST情報取得
/**************************/
$form_data = $form->exportValues();


/**************************/
// 表示ボタン押下
/**************************/
if ( $form_data["form_display"] == "表　示" AND $form->validate()) {

    // 表示ボタン押下フラグ
    $disp_flg   = true;

    // クエリ作成
    $result     = Select_Customer_Type_Abc_Amount($db_con, $form_data);
    // ABCクラスのインスタンス生成
    $abcObj     = new Analysis_ABC();
    // クエリデータ抽出
    $abcObj->Result_Change_Array($result);
    // ABC表示用データ作成
    $abcObj->Set_Abc_Data();

    /*************************/
    // CSV出力処理
    /*************************/
    if ($form_data["form_output_type"] == "2") {
        $csvobj = new ABC_Csv_Class();
        $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

        // CSV項目名作成
        $csvobj->Make_Csv_Head($csv_head);
        $csvobj->Make_Csv_Data($abcObj->disp_data, $csv_head);

        // CSV出力
        Header("Content-disposition: attachment; filename=".$csvobj->filename);
        Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
        print $csvobj->res_csv;
        exit;
    }
}

/*************************/
// HTMLヘッダ
/*************************/
$html_header = Html_Header($page_title);


/*************************/
// HTMLフッダ
/*************************/
$html_footer = Html_Footer();


/*************************/
// メニュー作成
/*************************/
$page_menu = Create_Menu_h("analysis","1");


/*************************/
// 画面ヘッダー作成
/*************************/
$page_header = Create_Header($page_title);


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
            'disp_flg'      => "$disp_flg",
            'group_kind'    => "$group_kind",
));
//オブジェクトをassign
$smarty->assign("disp_data", $abcObj->disp_data);


//テンプレートへ値を渡す
$smarty->display("112.php.tpl");


/*****************************************************************/

/**
 * 概要 FC/得意先別と業種別 ABC分析用クエリ
 *
 * 変更履歴 <br>
 * 2007-11-23   aizawa-m    新規作成<br>
 *
 * @param       $db_con     DBコネクション
 * @param       $form_data  POSTされた値
 * @param       $div        業種の場合="type"を指定する
 *
 * @return      $result     クエリ結果のリソース
 */
/*
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

    //-- 本部の場合
    if ( $group_kind == "1") {
        $client_div = "3";  //取引先区分（FC）
    } else {
        $client_div = "1";  //取引先区分（得意先)
    }

    //-- 業種別の場合
    if ($div == "type") {
        $from_tbl   = "t_lbtype";   // 大分類業種マスタ
    } else {
        $from_tbl   = "t_client";   // 取引先マスタ
    }

    /**************************/
    // クエリ作成
    /**************************/
  /*  $sql = "SELECT \n";
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
    $sql.= "    INNER JOIN ( \n";
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
    $sql.= "            t_sale_h.sale_day < '$end_date' \n";    // 集計期間終了
    //-- 抽出対象が東陽以外の場合
    if ( $out_abstract == "1" ) {
        $sql.= "    AND \n";
        $sql.= "        t_sale_h.client_id <> 93 \n";
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
        $sql.= "    LIKE '%$client_gr_name$' \n";
    }
    $sql.= "GROUP BY \n";
    $sql.= "    id, \n";
    $sql.= "    cd, \n";
    $sql.= "    name, \n";
    $sql.= "    t_rank.rank_cd, \n";
    $sql.= "    t_rank.rank_name \n";
    $sql.= "ORDER BY \n";
    $sql.= "  net_amount DESC \n";
    $sql.= "; \n";

//   echo nl2br($sql);

    /*********************/
    // クエリ実行
    /*********************/
/*    $result = Db_Query($db_con, $sql);

    return $result;
}
*/
?>
