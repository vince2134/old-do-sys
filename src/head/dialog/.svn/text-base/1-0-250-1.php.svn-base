<?php
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
$client_sql .= "     t_client.shop_id = $shop_id";
$client_sql .= "     AND";
$client_sql .= "     (t_client.client_div = '1'";
$client_sql .= "     OR";
$client_sql .= "     t_client.client_div = '3')";
$client_sql .= " ORDER BY t_client.client_cd1,t_client.client_cd2";


//該当件数
$total_count_sql = $client_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
	    
$page_data = Get_Data($count_res, $output_type);
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
$page_menu = Create_Menu_h('system','1');

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
$smarty->assign('row',$page_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
