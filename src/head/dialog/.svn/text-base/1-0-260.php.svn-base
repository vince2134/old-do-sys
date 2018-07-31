<?php
/**
 *
 * 直送先一覧（別ウィンドウ）
 *
 *
 * @author
 * @version
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2009/10/08      rev.1.3     kajioka-h   発注入力等で直送先がセレクトボックス→コード入力へ変更のため、新規作成
 *
 */

$page_title = "直送先一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DBに接続
$conn = Db_Connect();

//--------------------------//
//外部変数取得
//--------------------------//
$shop_id   = $_SESSION["client_id"];
$display   = $_GET["display"];
$select_id = $_GET['select_id'];


//--------------------------//
//デフォルト値設定
//--------------------------//

//hiddenにより保持する
if($_GET['display'] != NULL){
	$set_id_data["hdn_display"] = $display;
	$form->setConstants($set_id_data);
}else{
	$display = $_POST["hdn_display"];
}

if($_GET['select_id'] != NULL){
	$set_id_data["hdn_select_id"] = $select_id;
	$form->setConstants($set_id_data);
}else{
	$select_id = $_POST["hdn_select_id"];
}

$def_fdata = array(
    "form_output_type"     => "1",
    "form_turn"     => "1",
    "form_state"     => "1"
);
$form->setDefaults($def_fdata);


//--------------------------//
//HTMLイメージ作成用部品
//--------------------------//
// 直送先コード
$form->addElement("text","form_direct_cd","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");

// 直送先名
$form->addElement("text","form_direct_name","テキストフォーム","size=\"34\" maxLength=\"15\"".$g_form_option."\"");

// 略称
$form->addElement("text","form_direct_cname","テキストフォーム","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

// 表示順
$radio[] =& $form->createElement("radio", null, null, "コード順", "1");
$radio[] =& $form->createElement("radio", null, null, "アイウエオ順", "2");
$form->addGroup($radio, "form_turn", "表示順");

// ボタン
$button[] = $form->createElement("submit", "show_button", "表　示");
$button[] = $form->createElement("button", "close_button", "閉じる", "onClick=\"window.close()\"");
$form->addGroup($button, "form_button", "ボタン");

//GETの値を保持する
$form->addElement("hidden","hdn_display","","");
$form->addElement("hidden","hdn_select_id","","");


//--------------------------//
//表示ボタン押下処理
//--------------------------//
$sql  = "SELECT \n";
//$sql .= "    direct_id, \n";			//直送先ID
$sql .= "    direct_cd, \n";			//直送先コード
$sql .= "    direct_name, \n";			//直送先名
$sql .= "    direct_cname, \n";			//略称
$sql .= "    t_client.client_cname \n";	//請求先
$sql .= "FROM \n";
$sql .= "    t_direct \n";
$sql .= "    LEFT JOIN t_client ON t_direct.client_id = t_client.client_id \n";
$sql .= "WHERE \n";
$sql .= "    t_direct.shop_id = $shop_id \n";


//表示ボタン押下
if($_POST["form_button"]["show_button"]=="表　示"){

	$direct_cd		= trim($_POST["form_direct_cd"]);		//直送先コード
	$direct_name	= trim($_POST["form_direct_name"]);		//直送先名
	$direct_cname	= trim($_POST["form_direct_cname"]);	//略称
	$turn			= $_POST["form_turn"];					//表示順

	$direct_cd		= stripslashes($direct_cd);
	$direct_name	= stripslashes($direct_name);
	$direct_cname	= stripslashes($direct_cname);

	//直送先コード
	if($direct_cd != null){
		$direct_cd_sql = "    AND t_direct.direct_cd LIKE '$direct_cd%' \n";
	}

    //直送先名
	if($direct_name != null){
		$direct_name_sql  = "    AND \n";
		$direct_name_sql .= "    ( \n";
		$direct_name_sql .= "        t_direct.direct_name LIKE '%$direct_name%' \n";
		$direct_name_sql .= "        OR \n";
		$direct_name_sql .= "        t_direct.direct_name2 LIKE '%$direct_name%' \n";
		$direct_name_sql .= "    ) \n";
	}

	//略称
	if($direct_cname != null){
		$direct_cname_sql = "    AND t_direct.direct_cname LIKE '%$direct_cname%' \n";
	}

	$sql .= $direct_cd_sql;
	$sql .= $direct_name_sql;
	$sql .= $direct_cname_sql;

}

//表示順
if($turn != '2'){
	$turn_sql = "ORDER BY direct_cd ASC \n";
}else{
	$turn_sql = "ORDER BY direct_name ASC \n";
}
$sql .= $turn_sql;


$sql .= ";";
//print_array($sql);


//--------------------------//
//全件数取得
//--------------------------//

//該当件数
$count_res = Db_Query($conn, $sql);
$match_count = pg_num_rows($count_res);

//戻り値作成
for($i = 0; $i < $match_count; $i++){
    $page_data[] = @pg_fetch_array ($count_res, $i, PGSQL_NUM);
}
for($i = 0; $i < $match_count; $i++){
    for($j = 0; $j < count($page_data[$i]); $j++){
		//直送先コード
		if($j==0){
			$return = "'".$page_data[$i][$j]."'";
		//直送先名、請求先は'が入力される可能性がある為
		}else if($j==2 || $j==3){
			$single = addslashes($page_data[$i][$j]);
			$single = htmlspecialchars($single);
			$return = $return.",'".$single."'";
		}

        $page_data[$i][$j] = htmlspecialchars($page_data[$i][$j],ENT_QUOTES);
    }

	$return = $return.",'true'";	//元画面の直送先検索フラグにtrueを入れる
	$return_data[] = $return;

}



//--------------------------//
//HTMLヘッダ
//--------------------------//
$html_header = Html_Header($page_title);


//--------------------------//
//HTMLフッタ
//--------------------------//
$html_footer = Html_Footer();


//--------------------------//
//メニュー作成
//--------------------------//
$page_menu = Create_Menu_h('system','1');


//--------------------------//
//画面ヘッダー作成
//--------------------------//
$page_title .= "　（全".$total_count."件）";
$page_header = Create_Header($page_title);


//print_array($_POST);


//--------------------------//
//ページ作成
//--------------------------//

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
	'match_count'   => "$match_count",
    "display"       => "$display",
	
));
//テンプレートへ値を渡す
$smarty->assign("page_data",$page_data);
$smarty->assign('return_data', $return_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
