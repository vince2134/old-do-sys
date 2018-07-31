<?php
/*******************************************
 *  変更履歴
 *      （20060811）日次更新の対象テーブルに更新日を残す処理を追加（watanabe-k）
 *  2007-04-13              fukuda      履歴表示を30件から60件に変更
 *
 *
 *
********************************************/

/*******************************************/
// ページ内定義
/*******************************************/

// ページタイトル
$page_title = "日次更新履歴";

// 環境設定ファイル
require_once("ENV_local.php");

// DB接続設定
$conn = Db_Connect();

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// 権限チェック
$auth       = Auth_Check($conn);

/****************************/
// HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成
/****************************/
$page_menu = Create_Menu_h('renew','1');

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// フォームパーツ定義
/****************************/

/*******************************************/
// ページ読込時処理
/*******************************************/

/****************************/
// 描画処理
/****************************/
// DBデータ取得
$sql  = "SELECT     to_date(renew_time, 'YYYY-MM-DD') || ' ' || to_char(renew_time, 'hh24:mi:ss'), \n";
$sql .= "           close_day, \n";
$sql .= "           operation_staff_name \n";
$sql .= "FROM       t_sys_renew \n";
$sql .= "WHERE      renew_div = '1' \n";      // renew_div = '1' : 日次
$sql .= "AND        shop_id = ".$_SESSION["client_id"]." \n";
$sql .= "ORDER BY   renew_time DESC \n";
$sql .= "LIMIT      60 \n";
$sql .= "OFFSET     0 \n";
$sql .= ";";
$res  = Db_Query($conn, $sql);

// 一覧用データ作成
$rec_data = Get_Data($res, "2");

// サニタイジング
if (count($rec_data) > 0){
    foreach ($rec_data as $key => $value){
        $rec_data[$key][2] = htmlspecialchars($value[2]);
    }
}

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_menu'         => "$page_menu",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
));

// 一覧用レコードデータをテンプレートへ渡す
$smarty->assign("rec_data", $rec_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
