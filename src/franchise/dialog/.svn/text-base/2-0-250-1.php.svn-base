<?php

/*************************
 * 変更履歴
 *  ・（2006-11-28）サニタイジング処理追加<suzuki>
 *
 *
**************************/

$page_title = "得意先一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DBに接続
$conn = Db_Connect();

/****************************/
//外部変数取得
/****************************/
$shop_id  = $_SESSION["client_id"];

/****************************/
//HTMLイメージ作成用部品
/****************************/
//ボタン
$button[] = $form->addElement(
    "button","close_button","閉じる",
    "onClick=\"window.close()\"
");
$form->addGroup($button, "form_button", "ボタン");

/****************************/
//全件数取得
/****************************/
$client_sql  = " SELECT";
$client_sql .= "     t_client.client_cd1,";
$client_sql .= "     t_client.client_cd2,";
$client_sql .= "     t_client.client_name,";
$client_sql .= "     t_area.area_name,";
$client_sql .= "     t_client.state";
$client_sql .= " FROM";
$client_sql .= "     t_client,";
$client_sql .= "     t_area";
$client_sql .= " WHERE";
$client_sql .= "     t_client.area_id = t_area.area_id";
$client_sql .= "     AND";
$client_sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = 1";
$client_sql .= " ORDER BY t_client.client_cd1,t_client.client_cd2";


//該当件数
$total_count_sql = $client_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
	    
//$page_data = Get_Data($count_res, $output_type);

//件数取得
$total_count = pg_num_rows($count_res);
for($i = 0; $i < $total_count; $i++){
    $row[$i] = @pg_fetch_array ($count_res, $i, PGSQL_NUM);
    $row[$i][0] = htmlspecialchars($row[$i][0]);
    $row[$i][1] = htmlspecialchars($row[$i][1]);
    $row[$i][2] = htmlspecialchars($row[$i][2]);
    $row[$i][3] = htmlspecialchars($row[$i][3]);
	$row[$i][4] = htmlspecialchars($row[$i][4]);
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
$page_menu = Create_Menu_f('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
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
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	
));
$smarty->assign('row',$row);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
