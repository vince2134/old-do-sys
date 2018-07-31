<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/11      ban_0126    suzuki      サニタイジング処理追加
*/

$page_title = "総在庫数";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);

$button[] = $form->createElement("button","close","閉じる","onClick=\"javascript:window.close();\"");
$form->addGroup($button, "button", "");
/****************************/
//GET取得
/****************************/
$goods_id  = $_GET["select_id"];

Get_Id_Check2($goods_id);

$client_id = $_GET["select_id2"];
/****************************/
//外部変数取得
/****************************/
$shop_id     = $_SESSION["client_id"];

//商品名取得
$sql  = "SELECT";
$sql .= "   goods_cname";
$sql .= " FROM";
$sql .= "   t_goods";
$sql .= " WHERE";
$sql .= "   goods_id = $goods_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$goods_name = pg_fetch_result($result ,0,0);
$goods_name = htmlspecialchars($goods_name);

$sql  = "SELECT";
$sql .= "   t_ware.ware_name,";
$sql .= "   t_stock.stock_num,";
$sql .= "   t_stock.rstock_num";
$sql .= " FROM";
$sql .= "   t_ware ";
$sql .= "   INNER JOIN t_stock ON t_stock.ware_id = t_ware.ware_id ";
$sql .= " WHERE";
$sql .= "   t_stock.shop_id = $shop_id";
$sql .= " AND";
$sql .= "   t_stock.goods_id = $goods_id";
$sql .= " AND ";
$sql .= "   t_ware.count_flg = 't';";

$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);
for($i = 0; $i < $data_num; $i++){
    $data[] = pg_fetch_array($result, $i, PGSQL_NUM);
}
foreach ($data as $key1 => $value1){
    foreach ($value1 as $key2 => $value2){
        $data[$key1][$key2] = htmlspecialchars($value2);
    }
}

//現在個数、引当数の合計
for($i = 0; $i < $data_num; $i++){
    $stock_total  = $stock_total + $data[$i][1];
    $rstock_total = $rstock_total + $data[$i][2];
}
if($stock_total == NULL){
	$stock_total = 0;
}
if($rstock_total == NULL){
	$rstock_total = 0;
}
$sum = array("<b>合計</b>",$stock_total,$rstock_total);
/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
    "goods_name"    => "$goods_name",
));
$smarty ->assign("sum",$sum);
$smarty ->assign("data",$data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
