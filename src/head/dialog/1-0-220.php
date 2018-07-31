<?php
$page_title = "請求先一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//HTMLイメージ作成用部品
//require_once(PATH."include/html_quick.php");


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

/****************************/
// フォームパーツ作成
/****************************/
// 請求先コード
$claim_cd[] =& $form->createElement("text", "claim_cd1", "請求先コード１", "size=\"7\" maxLength=\"6\" value=\"\" onKeyUp=\"javascript:display(this,'claim'); changeText(this.form,'form_claim_cd[claim_cd1]', 'form_claim_cd[claim_cd2]', 6)\" style=\"$g_form_style\" $g_form_option");
$claim_cd[] =& $form->createElement("static","","","-");
$claim_cd[] =& $form->createElement("text","claim_cd2", "請求先コード２", "size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:display(this,'claim')\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $claim_cd, "form_claim_cd", "請求先コード");

// 請求先名
$form->addElement("text", "form_claim_name", "直送先名", "size=\"34\" maxLength=\"15\" $g_form_option");

// FC区分
$fc_kubun[] =& $form->createElement("radio", null, null, "FC","1");
$fc_kubun[] =& $form->createElement("radio", null, null, "得意先","2");
$form->addGroup($fc_kubun, "form_fc_kubun_radio", "FC区分");

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// 閉じるボタン
$form->addElement("button", "form_close_button", "閉じる", "onClick=\"window.close()\"");


$def_fdata = array(
    "form_fc_kubun_radio"     => "1"
);

$form->setDefaults($def_fdata);

/****************************/
//ページ作成
/****************************/
//仮の件数
$total_count = 100;

//表示範囲指定
$range = "20";

//ページ数を取得
$page_count = $_POST["f_page1"];

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

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
));


//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
