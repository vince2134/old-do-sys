<?php
$page_title = "保険料一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
($auth[0] == "r") ? $form->freeze() : null;


/****************************/
//デフォルト値設定
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_day_y"    =>"2006",
    "form_day_m"    =>"05",
);
$form->setDefaults($def_fdata);

/****************************/
// フォームパーツ作成
/****************************/

//出力形式
$radio1[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "帳票","2");
$form->addGroup($radio1, "form_output_type", "出力形式");

//表示ボタン
$form->addElement("button","form_show_button","表　示"); 
//クリアボタン
$form->addElement("button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");// 戻るボタン
$form->addElement("button", "form_back_button", "戻　る", "onClick=\"javascript:history.back()\"");

//登録ボタン
$form->addElement("button", "form_add_button", "登　録");

$form->addElement("button", "new_button", "登録画面", " onClick=\"javascript:location.href='1-1-131.php'\"");
$form->addElement("button", "change_button", "変更・一覧", $g_button_color."onClick=\"javascript:location.href='1-1-132.php'\"");

//年月
$form->addElement("text","form_day_y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_day[y]','form_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_day[y]','form_day[m]','form_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addElement("text","form_day_m","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_day[m]','form_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_day[y]','form_day[m]','form_day[d]')\" onBlur=\"blurForm(this)\"");

/****************************/
// 一覧表作成
/****************************/

$disp_data[0] = array(
    "Result1",
    "1",
    "東陽",
    "障害保険",
    "16",
    "10,240",
    "10,240",
    "67,730",
    "",
    "賠償保険",
    "16",
    "9,490",
    "9,490",
    "共済（代表者）",
    "0",
    "6,000",
    "0",
    "共済（従業員）",
    "16",
    "3,000",
    "48,000",
);

$disp_data[1] = array(
    "Result2",
    "2",
    "メディスポ",
    "障害保険",
    "3",
    "1,920",
    "1,920",
    "40,270",
    "",
    "賠償保険",
    "3",
    "2,350",
    "2,350",
    "共済（代表者）",
    "0",
    "6,000",
    "0",
    "共済（従業員）",
    "12",
    "3,000",
    "36,000",
);

$disp_data[2] = array(
    "Result1",
    "3",
    "四国",
    "障害保険",
    "2",
    "1,280",
    "1,280",
    "12,000",
    "",
    "賠償保険",
    "2",
    "1,720",
    "1,720",
    "共済（代表者）",
    "0",
    "6,000",
    "0",
    "共済（従業員）",
    "3",
    "3,000",
    "9,000",
);

$disp_data[3] = array(
    "Result2",
    "4",
    "システム",
    "障害保険",
    "3",
    "1,920",
    "1,920",
    "21,640",
    "",
    "賠償保険",
    "3",
    "1,720",
    "1,720",
    "共済（代表者）",
    "0",
    "6,000",
    "0",
    "共済（従業員）",
    "6",
    "3,000",
    "18,000",
);
/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//ディレクトリ
/****************************/
$head_page = HEAD_DIR."system/1-1-104.php";

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_h("system", "1");

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
	"head_page"     => "$head_page",	
));

//表示データ
$smarty->assign("disp_data", $disp_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
