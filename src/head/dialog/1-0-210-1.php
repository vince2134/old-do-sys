<?php
$page_title = "商品マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//サンプル関数
//require_once(PATH."function/sample_func_watanabe.inc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DBに接続
$conn = Db_Connect();

/****************************/
//外部変数取得
/****************************/
session_start();
$shop_id = $_SESSION["client_id"];

/****************************/
//フォーム作成
/***************************/
$form->addElement(
    "submit","form_show_button","表　示"
);
$form->addElement(
    "button","form_clear_button","閉じる",
    "onClick=\"window.close()\"
");

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/******************************/
//ヘッダーに表示させる全件数
/*****************************/
if($_POST["form_show_button"] == "表　示") {
$goods_sql  = " SELECT";
$goods_sql .= "     t_goods.goods_cd,";
$goods_sql .= "     t_goods.goods_name,";
$goods_sql .= "     t_goods.goods_cname,";
$goods_sql .= "     t_product.product_name,";
$goods_sql .= "     t_g_goods.g_goods_name,";
$goods_sql .= "     CASE t_goods.attri_div";
$goods_sql .= "         WHEN '1' THEN '製品'";
$goods_sql .= "         WHEN '2' THEN '部品'";
$goods_sql .= "         WHEN '3' THEN '部材'";
$goods_sql .= "         WHEN '4' THEN 'その他'";
$goods_sql .= "     END";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods,";
$goods_sql .= "     t_g_goods,";
$goods_sql .= "     t_product";
$goods_sql .= " WHERE";
$goods_sql .= "     t_goods.product_id = t_product.product_id";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.g_goods_id = t_g_goods.g_goods_id";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.public_flg = 't'";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.shop_id = $shop_id ";
$goods_sql .= "ORDER BY goods_cd";
$goods_sql .= ";";

$goods_res = Db_Query($conn, $goods_sql);
//$match_count = pg_num_rows($goods_res);
$goods_data = Get_Data($goods_res);
}

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
    'match_count'   => "$match_count",
));

$smarty->assign('page_data', $goods_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
