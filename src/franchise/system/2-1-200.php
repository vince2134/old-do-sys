<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/03/29      xx-xxx      kajioka-h   本支店コード入力欄にIME無効のオプションを追加
 *                  xx-xxx      kajioka-h   No.を右寄せに
 */

/************************************************/
//外部参照ファイル
/************************************************/
require_once("ENV_local.php"); //環境ファイル
require_once(INCLUDE_DIR.(basename($_SERVER[PHP_SELF].".inc"))); //現モジュール内のみで使用する関数ファイル

/*------------------------------------------------
    変数定義
------------------------------------------------*/
$page_title        = "本支店マスタ"; //ページ名

// HTML_QuickFormオブジェクト作成
$form =& new HTML_QuickForm("dateForm", "POST");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


// SESSIONデータ取得
session_start();

/************************************************/
//QuickForm - フォームオブジェクト定義
/************************************************/
//本支店ID	branch_id
$form->addElement("hidden", "branch_id");

//本支店コード	branch_cd
$form->addElement("text", "branch_cd", "本支店コード", "size=\"2\" maxlength=\"3\" $g_form_option style=\"$g_form_style\"");

//本支店名	branch_name
$form->addElement("text", "branch_name", "本支店名", "size=\"22\" maxlength=\"10\" $g_form_option");

//拠点倉庫ID	bases_ware_id
//$select_value = Select_Get($db_con,'ware');
$select_value = Select_Get($db_con,'ware',"WHERE shop_id = $_SESSION[client_id] AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
$form->addElement('select', 'bases_ware_id', '拠点倉庫', $select_value);

//備考	note
$form->addElement("text", "note", "備考", "size=\"34\" maxlength=\"30\" $g_form_option");

//登録ボタン
$form->addElement("submit", "regist_button", "登　録", "onClick=\"javascript:return Dialogue4('登録します');\" $disabled");

//CSV出力ボタン
//$form->addElement("submit", "csv_button", "CSV出力", "$disabled");
$form->addElement("submit", "csv_button", "CSV出力", "onClick=\"javascript:document.forms[0].action='#';\"");

// クリアボタン
$form->addElement("button", "clear_button", "クリア", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");

//hidden
$form->addElement("hidden", "update_button"); //変更ボタン

$form->applyFilter('__ALL__', 'trim');

/************************************************/
//処理内容判別
/************************************************/
if ($_POST[update_button] == "変更前"){
	$action = "変更前";

} elseif ($_POST[csv_button] == "CSV出力"){
	$action = "CSV";

} elseif ($_POST[update_button] == "変更" && $auth[0] == "w"){
	$action = "変更";

} elseif ($_POST[regist_button] == "登　録" && $auth[0] == "w") {
	$action = "登録";

} else {
	$action = "初期表示";
}
//echo $action;

/************************************************/
//エラー処理
/************************************************/
//「登録」か「変更」の場合はエラーチェック実施
if ($action == "登録" || $action == "変更") {

	//ルール追加
	$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
	$form->registerRule("no_sp_name", "function", "No_Sp_Name");
	
	//ルールの指定
	$form->addRule('branch_cd',"「本支店コード」を入力して下さい。",'required');
	$form->addRule("branch_cd","「本支店コード」は半角数値のみです。","regex", '/^[0-9]+$/');
	$form->addRule("branch_name","「本支店名」を入力して下さい。",'required');
	$form->addRule("branch_name","「本支店名」にスペースのみの登録はできません。", "no_sp_name");
	$form->addRule("branch_name","「本支店名」は10文字以内です。","mb_maxlength","10");
	$form->addRule("bases_ware_id","「拠点倉庫」を選択して下さい。",'required');
	$form->addRule("note","「備考」は30文字以内です。","mb_maxlength","30");

	//エラーがあった場合は処理を「エラー」に切り替える
	if ($form->validate() == false ){
		$action = "エラー";
	}

}

/************************************************/
//処理実行
/************************************************/
//■登録処理
if ($action == "登録") {

	//登録処理
	$result = Regist_Branch($db_con);

	//登録失敗
	if($result === false){
		$form->setElementError("branch_cd", "同時に処理が行われたため登録処理に失敗しました。もう一度登録して下さい。");

	//登録成功
	}else{
		$mesg = "登録しました。";
		//フォームデータを空にする
		$constants_data = array(
			branch_cd     => "",
			branch_name   => "",
			bases_ware_id => "",
			note          => "",
			branch_id     => "",
			update_button => "",
		);
	}

//■変更処理
} elseif ($action == "変更"){

	//変更処理
	$result = Update_Branch($db_con);

	//変更失敗
	if($result === false){
		$form->setElementError("branch_cd", "既に使用されている本支店コードです。");

	//登録成功
	}else{
		$mesg = "変更しました。";
		//フォームデータを空にする
		$constants_data = array(
			branch_cd     => "",
			branch_name   => "",
			bases_ware_id => "",
			note          => "",
			branch_id     => "",
			update_button => "",
		);
	}

//■変更前処理
} elseif ($action == "変更前"){
	$constants_data                = Get_Branch($db_con);
	$constants_data[update_button] = "変更";

//■CSV出力処理
} elseif ($action == "CSV"){
	//CSV処理
	Csv_Branch($db_con);
	
//■CSV出力処理
} elseif ($action == "初期表示"){
	//特に処理なし

//■エラー処理
} elseif ($action == "エラー"){
	//特に処理なし
}

$form->setConstants($constants_data);
/****************************/
//表示データ取得
/****************************/
//DBからデータ取得
$branch_data = Get_Branch_Data($db_con);

//取得データをHTML用に変換
$branch_data = Html_Branch_Data($branch_data);

//全件数
$total_count = count($branch_data);


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
$page_menu = Create_Menu_f("system", "1");

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count."件)";
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//エラーをassign
$errors = $form->_errors;
$smarty->assign('errors', $errors);

//その他の変数をassign
$smarty->assign("var", array(
	"html_header" => "$html_header",
	"page_menu"   => "$page_menu",
	"page_header" => "$page_header",
	"html_footer" => "$html_footer",
	"total_count" => "$total_count",
	"mesg" => "$mesg",
	'auth_r_msg'    => "$auth_r_msg",
));
$smarty->assign("branch_data", $branch_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
//print_array($_POST);

?>
