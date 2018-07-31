<?php
$page_title = "マスタ操作ログ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();


/****************************/
//ダウンロード処理
/****************************/
if($_POST[form_btn_down] == "ダウンロード"){

	//CSVのファイル名
	$file_name = "マスタログ".$_POST[form_donw_month].".csv";
	$csv_file_name = mb_convert_encoding($file_name, "SJIS", "EUC");

	//CSVヘッダ
	$csv_header = array(作業日時,作業者,マスタ名,コード,名称,作業区分);

	//DBデータ取得SQL（マスタログ）
$sql =<<<SQL_
	SELECT 
	 m.work_time,s.staff_name,
	 m.mst_name,
	 m.data_cd,
	 m.data_name,
	 CASE m.work_div WHEN '1' THEN '登録' WHEN '2' THEN '変更' WHEN '3' THEN '削除' END 
	FROM t_staff s CROSS JOIN t_attach a CROSS JOIN t_mst_log m
	WHERE m.staff_id = s.staff_id 
	AND m.shop_id = a.shop_id 
	AND a.staff_id = s.staff_id 
	AND a.shop_id = '$_SESSION[client_id]'
	AND m.work_time LIKE '$_POST[form_donw_month]%'
	ORDER BY m.work_time;
SQL_;
	$result = Db_Query($db_con, $sql);

	//DBデータを配列に登録
	while($db_data[] = pg_fetch_row ($result)){}
	//CSV形式に変換
	$csv_data = Make_Csv($db_data, $csv_header);

	//HTTPヘッダ
	//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // 過去の日付
	Header("Content-disposition: attachment; filename=$csv_file_name");
	Header("Content-type: application/octet-stream; name=$csv_file_name");
	echo $csv_data;
	exit;
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
$page_menu = Create_Menu_f('analysis','3');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//フォーム定義
/****************************/
//日付セレクトボックス(過去12ヶ月分表示)
for($i=0;$i<12;$i++){
	$select_val  = date("Y-m", mktime(0, 0, 0, $g_mounth-$i, 1, $g_year));
	$select_html = date("Y年m月", mktime(0, 0, 0, $g_mounth-$i, 1, $g_year));
	$select_ary[$select_val] = "$select_html";
}

$form->addElement('select', 'form_donw_month', 'セレクトボックス', $select_ary,$g_form_option_select);

//ダウンロードボタン
$form->addElement("submit","form_btn_down","ダウンロード");



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

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
