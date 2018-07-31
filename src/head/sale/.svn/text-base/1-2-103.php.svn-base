<?php
$page_title = "受注明細";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//HTMLイメージ作成用部品
//require_once(PATH."include/html_quick.php");

//select作成用部品
//require_once(PATH."include/select_part.php");

/****************************/
// フォームパーツ定義
/****************************/
// 受注日時
$text3_1[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$form->addGroup( $text3_1, "f_date_a1", "");

// 運送業者
$form->addElement('checkbox', 'form_trans_check', 'グリーン指定', '<b>グリーン指定</b>　');

$select_value = Select_Get($db_con, "trans");
$form->addElement("select", "form_trans_1", "", $select_value, $g_form_option_select);

// 出荷倉庫
$select_value = Select_Get($db_con, "ware");
$form->addElement("select", "form_ware_1", "", $select_value, $g_form_option_select);

// 取引区分
$select_value = Select_Get($db_con, "trade_aord");
$form->addElement("select", "trade_aord_1", "", $select_value, $g_form_option_select);

// 担当者
$select_value = Select_Get($db_con, "staff", null, true);
$form->addElement("select", "form_staff_1", "", $select_value, $g_form_option_select);

// 通信欄（得意先宛）
$form->addElement("textarea", "f_textarea", "", "rows=\"2\" cols=\"75\" $g_form_option_area");

// 注文書発行ボタン
$form->addElement("submit", "hattyuusho", "注文書発行", "onClick=\"javascript:window.open('".FC_DIR."buy/2-3-105.php','_blank','')\"");

// 登録ボタン
$form->addElement("button", "touroku", "登　録", "onClick=\"javascript:Dialogue4('登録します。')\" $disabled");

// 戻るボタン
$form->addElement("button", "modoru", "戻　る", "onClick=\"javascript:history.back()\"");

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
$page_menu = Create_Menu_h('sale','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);





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
    'auth_r_msg'    => "$auth_r_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
