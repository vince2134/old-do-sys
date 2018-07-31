<?php

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/12/14　      　　　　suzuki　    ページ処理修正
 *
 */

$page_title = "請求照会";

//環境設定ファイル
require_once("ENV_local.php");

//請求関連で使用する関数ファイル
require_once(INCLUDE_DIR."seikyu.inc");

//現モジュール内のみで使用する関数ファイル
require_once(INCLUDE_DIR.(basename($_SERVER[PHP_SELF].".inc")));

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST");

//DB接続
$db_con = Db_Connect();

//処理開始時間
$s_time = microtime();

/****************************/
//権限チェック
/****************************/
$auth       = Auth_Check($db_con);
$auth[0] = "w";

// 入力・変更権限無しメッセージ
if ($auth[0] == "r") {
	$disabled = "disabled";
} 


/****************************/
//変数名の置き換え（以後$_POSTは使用しない）
/****************************/
//ユーザ入力
if ($_POST[renew_flg] == "1"){ 
	$hyoujikensuu     = $_POST[hyoujikensuu];
	$bill_no          = $_POST[bill_no];
	$close_day_s      = $_POST[close_day_s];
	$close_day_e      = $_POST[close_day_e];
	$claim_cd         = $_POST[claiem_cd];
	$claim_cname      = $_POST[claim_cname];
	$client_cd        = $_POST[client_cd];
	$client_cname     = $_POST[client_cname];
	$bill_amount_last = $_POST[bill_amount_last];
	$pay_amount       = $_POST[pay_amount];
	$rest_amount      = $_POST[rest_amount];
	$sale_amount      = $_POST[sale_amount];
	$tax_amount       = $_POST[tax_amount];
	$intax_amount     = $_POST[intax_amount];
	$bill_amount_this = $_POST[bill_amount_this];
	$fix              = $_POST[fix];
	$claim_update     = $_POST[claim_update];
	$where            = $_POST;
 
	//その他
	$f_page1          = $_POST[f_page1];
	$hyouji_button    = $_POST[hyouji_button];
	$cancel_button    = $_POST[cancel_button];
	$bill_id          = $_POST[bill_id];
	$link_action      = $_POST[link_action];
	$renew_flg        = $_POST[renew_flg];
//初期表示
}else{
	$f_page1 = 1;
	$hyoujikensuu = 50;
}


/****************************/
// フォーム定義（静的）
/****************************/
// 表示件数
$hyoujikensuu_arr = array(
"10" => "10",
"50" => "50",
"100" => "100",
"all" => "全て",
);
$form->addElement("select", "hyoujikensuu", "表示件数", $hyoujikensuu_arr);

// 請求番号
$form->addElement("text", "bill_no", "請求番号", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 請求締日（開始）
Addelement_Date($form,"close_day_s","請求締日","-");

// 請求締日（終了）
Addelement_Date($form,"close_day_e","請求締日","-");

// 得意先コード
$client_cd_arr[] =& $form->createElement("text", "1", "", 
"size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'client_cd[1]', 'client_cd[2]', 6)\" $g_form_option");
$client_cd_arr[] =& $form->createElement("text", "2", "", 
"size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($client_cd_arr, "client_cd", "得意先コード","-");

// 得意先名
$form->addElement("text", "client_cname", "得意先名", "size=\"34\" maxLength=\"15\" $g_form_option");

// 請求先コード
$claim_cd_arr[] =& $form->createElement("text", "1", "", 
"size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'claim_cd[1]', 'claim_cd[2]', 6)\" $g_form_option");
$claim_cd_arr[] =& $form->createElement("text", "2", "", 
"size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($claim_cd_arr, "claim_cd", "請求先コード","-");

// 請求先名
$form->addElement("text", "claim_cname", "請求先名", "size=\"34\" maxLength=\"15\" $g_form_option");

// 担当者コード
$form->addElement("text", "staff_cd", "担当者コード", "size=\"34\" maxLength=\"15\" style=\"$g_form_style\" $g_form_option");

// 担当者名
//$select_value = Select_Get($db_con, "staff");
//$form->addElement("select", "staff_name", "担当者名", $select_value, $g_form_option_select);
$form->addElement("text", "staff_name", "担当者名", "size=\"34\" maxLength=\"15\" $g_form_option");


// 前回御請求額
$bill_amount_last_arr[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$bill_amount_last_arr[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$form->addGroup($bill_amount_last_arr, "bill_amount_last", "前回御請求額", "　〜　");

// 今回入金額
$pay_amount_arr[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$pay_amount_arr[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$form->addGroup($pay_amount_arr, "pay_amount", "今回入金額", "　〜　");

// 繰越残高額
$rest_amount_arr[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$rest_amount_arr[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$form->addGroup($rest_amount_arr, "rest_amount", "繰越残高額", "　〜　");

// 今回御請求額
$bill_amount_this_arr[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$bill_amount_this_arr[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$form->addGroup($bill_amount_this_arr, "bill_amount_this", "今回御請求額", "　〜　");

// 請求更新
$claim_update_arr[] =& $form->createElement("radio", null, null, "指定なし", "1");
$claim_update_arr[] =& $form->createElement("radio", null, null, "実施済", "2");
$claim_update_arr[] =& $form->createElement("radio", null, null, "未実施", "3");
$form->addGroup($claim_update_arr, "claim_update", "請求更新");

// 表示ボタン
$form->addElement("button", "hyouji_button", "表　示", "onClick=\"javascript:submit(); return false;\"");

// クリアボタン
$form->addElement("button", "kuria_button", "クリア", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");

//hidden
$form->addElement("hidden","link_action");   //リンククリック時の動作
$form->addElement("hidden","bill_id");       //請求書ID
$form->addElement("hidden","renew_flg","1"); //画面更新フラグ


/****************************/
//フォームのデフォルト値をセット
/****************************/
$defaults_data = array(
	"hyoujikensuu"  => "$hyoujikensuu",
	"claim_update"  => "1",
);
$form->setDefaults($defaults_data);


/****************************/
//エラーチェック
/****************************/

//表示件数
if (!(0 <= $hyoujikensuu || $hyoujikensuu <= 3)){
	echo "不正な値が入力されました。";
	exit;
}

//請求更新
if (!(1 <= $claim_update || $claim_update <= 3)){
	echo "不正な値が入力されました。";
	exit;
}

$form->registerRule("check_date","function","Check_Date");
$form->addRule("bill_no","「請求番号」は半角数値のみです。","regex", '/^[0-9]+$/');
$form->addRule("close_day_s", "「請求締日（開始）」に正しい日付を入力して下さい。",  "check_date", $close_day_s);
$form->addRule("close_day_e", "「請求締日（終了）」に正しい日付を入力して下さい。",  "check_date", $close_day_e);
$form->addRule("collect_day_s", "「回収予定日（開始）」に正しい日付を入力して下さい。",  "check_date", $collect_day_s);
$form->addRule("collect_day_e", "「回収予定日（終了）」に正しい日付を入力して下さい。",  "check_date", $collect_day_e);
$form->addGroupRule('claim_cd', array(
        '1' => array(array('「得意先コード」は半角数値のみです。', "regex", '/^[0-9]+$/')),
        '2' => array(array('「得意先コード」は半角数値のみです。', "regex", '/^[0-9]+$/'))
));
$form->addGroupRule('client_cd', array(
        '1' => array(array('「請求先コード」は半角数値のみです。', "regex", '/^[0-9]+$/')),
        '2' => array(array('「請求先コード」は半角数値のみです。', "regex", '/^[0-9]+$/'))
));
$form->addRule("staff_cd","「担当者コード」は半角数値のみです。","regex", '/^[0-9]+$/');

$form->addGroupRule('pay_amount', array(
        'min' => array(array('「今回入金額」は - または 半角数値のみです。', "regex", '/^-?[0-9]+$/')),
        'max' => array(array('「今回入金額」は - または 半角数値のみです。', "regex", '/^-?[0-9]+$/'))
));

$form->addGroupRule('bill_amount_last', array(
        'min' => array(array('「前回御請求額」は - または 半角数値のみです。', "regex", '/^-?[0-9]+$/')),
        'max' => array(array('「前回御請求額」は - または 半角数値のみです。', "regex", '/^-?[0-9]+$/'))
));

$form->addGroupRule('rest_amount', array(
        'min' => array(array('「繰越残高額」は - または 半角数値のみです。', "regex", '/^-?[0-9]+$/')),
        'max' => array(array('「繰越残高額」は - または 半角数値のみです。', "regex", '/^-?[0-9]+$/'))
));

$form->addGroupRule('bill_amount_this', array(
        'min' => array(array('「今回御請求額」は - または 半角数値のみです。', "regex", '/^-?[0-9]+$/')),
        'max' => array(array('「今回御請求額」は - または 半角数値のみです。', "regex", '/^-?[0-9]+$/'))
));


/****************************/
//処理
/****************************/
//一覧表示処理
if ($form->validate() || $renew_flg == ""){
	//該当件数取得
	$total_count = Get_Claim_Data($db_con, $where, "", "", "count");

	//1ページの表示件数が全件の場合
	if ($hyoujikensuu == "all") {
		$range = $total_count;
	} else {
		$range = $hyoujikensuu;
	}
	
	//現在のページ数をチェックする
	$page_info = Check_Page($total_count, $range, $f_page1);
	$page      = $page_info[0]; //現在のページ数
	$page_snum = $page_info[1]; //表示開始件数
	$page_enum = $page_info[2]; //表示終了件数

	//ページプルダウン表示判定
	if($page == 1){
		//ページ数が１ならページプルダウンを非表示
		$c_page = NULL;
	}else{
		//ページ数分プルダウンに表示
		$c_page = $page;
	}
	
	//ページ作成
	$html_page  = Html_Page($total_count,$c_page,1,$range);
	$html_page2 = Html_Page($total_count,$c_page,2,$range);
	
	//請求書データ取得
	$claim_data  = Get_Claim_Data($db_con, $where, $page_snum, $page_enum);
}

/****************************/
// フォーム定義（動的）
/****************************/
//for($j = $page_snum; $j <= $page_enum; $j++){
//}

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
$page_menu = Create_Menu_f('sale','3');

/****************************/
//画面ヘッダー作成
/****************************/
//$page_header = Create_Header($page_title);
$page_header = Bill_Header($page_title);


/****************************/
//テンプレートへの処理
/****************************/
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//エラーをassign
$errors = $form->_errors;
$smarty->assign('errors', $errors);

//検索結果
$smarty->assign('claim_data', $claim_data);

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
/*
$e_time = microtime();
echo "$s_time"."<br>";
echo "$e_time"."<br>";

echo "<pre>";
print_r($_POST);
echo "</pre>";
*/

?>
