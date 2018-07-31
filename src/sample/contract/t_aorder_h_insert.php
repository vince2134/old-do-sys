<?php
$page_title = "受注登録";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

/****************************/
//契約関数定義
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

//登録ボタン
$form->addElement("submit","form_insert","登　録");

/****************************/
//巡回日計算処理
/****************************/
$client_h_id = $_SESSION["client_id"];  //ログインユーザID
$cal_array = Cal_range($db_con,$client_h_id);

$start_day = $cal_array[0];   //対象開始期間
$end_day = $cal_array[1];     //対象終了期間
$cal_peri = $cal_array[2];    //カレンダー表示期間
print $end_day."<br>";
/****************************/
//契約情報ID取得処理
/****************************/
if($_POST["form_insert"] == "登　録"){
	$sql  = "SELECT DISTINCT ";
	$sql .= "    client_id ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "ORDER BY ";
	$sql .= "    client_id ";
	$sql .= "LIMIT 300 OFFSET 0;";  
	//$sql .= "LIMIT 300 OFFSET 300;"; 
	//$sql .= "LIMIT 300 OFFSET 600;";   
	//$sql .= "LIMIT 300 OFFSET 900;"; 
	//$sql .= "LIMIT 300 OFFSET 1200;";  
	//$sql .= "LIMIT 300 OFFSET 1500;";  
	//$sql .= "LIMIT 300 OFFSET 1800;";
	//$sql .= "LIMIT 300 OFFSET 2100;";  
	 
	$result = Db_Query($db_con, $sql); 

	Db_Query($db_con, "BEGIN;");
	Db_Query($db_con, "LOCK TABLE t_aorder_h IN EXCLUSIVE MODE;");
	$i = 0;
	while($client_list = pg_fetch_array($result)){
		/****************************/
		//受注データ登録関数＆受払テーブルに登録関数     
		/****************************/
		Aorder_Query($db_con,$client_h_id,$client_list[0],$start_day,$end_day);

		//ファイルにログを書込み(得意先ID)
		$fp = fopen("update_log.txt","a");
		fputs($fp,$client_list[0]."\n");
		fclose($fp);
		
		$i++;
	}
	Db_Query($db_con, "COMMIT;");

	print $sql;
}

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
	'html_header'     => "$html_header",
	'html_footer'     => "$html_footer",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
