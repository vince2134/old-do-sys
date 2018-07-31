<?php
$page_title = "仕入照会";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();

/****************************/
//デフォルト値設定
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_renew"           => "1"
);
$form->setDefaults($def_fdata);

/****************************/
//部品定義
/****************************/
//入力・変更
$form->addElement("button","new_button","入力・変更","onClick=\"javascript:Referer('1-3-201.php')\"");
//照会
$form->addElement("button","change_button","照　会","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//表示
$form->addElement("submit","show_button","表　示","onClick=\"javascript:Which_Type('form_output_type','2-3-203.php','#');\"");

//クリア
$form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

//伝票番号
$form->addElement("text","form_slip_no","テキストフォーム","size=\"10\" maxLength=\"8\" style=\"$g_form_style\" ".$g_form_option."\"");

//発注番号
$form->addElement("text","form_ord_no","テキストフォーム","size=\"10\" maxLength=\"8\" style=\"$g_form_style\" ".$g_form_option."\"");

//仕入先コード
$form->addElement("text","form_buy_name","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" ".$g_form_option."\"");

//仕入先名
$form->addElement("text","form_buy_name","テキストフォーム","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");

//仕入金額
$form_buy_amount[] =& $form->createElement(
"text","start","テキストフォーム","size=\"11\" maxLength=\"9\" style=\"text-align: right;$g_form_style\" onkeyup=\"changeText(this.form,'form_buy_amount[start]','form_buy_amount[end]',9)\"".$g_form_option."\""
);
$form_buy_amount[] =& $form->createElement("static","","","　〜　");
$form_buy_amount[] =& $form->createElement(
"text","end","テキストフォーム","size=\"11\" maxLength=\"9\" style=\"text-align: right;$g_form_style\"".$g_form_option."\""
);
$form->addGroup( $form_buy_amount,"form_buy_amount","form_buy_amount");

//仕入日
$form_buy_day[] =& $form->createElement(
"text","start_y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_buy_day[start_y]','form_buy_day[start_m]',4)\"".$g_form_option."\""
);
$form_buy_day[] =& $form->createElement("static","","","-");
$form_buy_day[] =& $form->createElement(
"text","start_m","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_buy_day[start_m]','form_buy_day[start_d]',2)\"".$g_form_option."\""
);
$form_buy_day[] =& $form->createElement("static","","","-");
$form_buy_day[] =& $form->createElement(
"text","start_d","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_buy_day[start_d]','form_buy_day[end_y]',2)\"".$g_form_option."\""
);
$form_buy_day[] =& $form->createElement("static","","","　〜　");
$form_buy_day[] =& $form->createElement(
"text","end_y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_buy_day[end_y]','form_buy_day[end_m]',4)\"".$g_form_option."\""
);
$form_buy_day[] =& $form->createElement("static","","","-");
$form_buy_day[] =& $form->createElement(
"text","end_m","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_buy_day[end_m]','form_buy_day[end_d]',2)\"".$g_form_option."\""
);
$form_buy_day[] =& $form->createElement("static","","","-");
$form_buy_day[] =& $form->createElement(
"text","end_d","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\""
);
$form->addGroup( $form_buy_day,"form_buy_day","form_buy_day");

//出力形式
$form_output_type[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$form_output_type[] =& $form->createElement( "radio",NULL,NULL, "帳票","2");
$form->addGroup($form_output_type, "form_output_type", "出力形式");

//日次更新
$form_renew[] =& $form->createElement( "radio",NULL,NULL, "指定なし","1");
$form_renew[] =& $form->createElement( "radio",NULL,NULL, "実施済","2");
$form_renew[] =& $form->createElement( "radio",NULL,NULL, "未実施","3");
$form->addGroup($form_renew, "form_renew", "日次更新");

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
$page_menu = Create_Menu_h('buy','2');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

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
