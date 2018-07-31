<?php
$page_title = "予定データ一括訂正";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

//HTMLイメージ作成用部品
//require_once(PATH."include/html_quick.php");

//select作成用部品
//require_once(PATH."include/select_part.php");

/****************************/
// フォームパーツ定義
/****************************/
//状態
$form_state[] =& $form->createElement( "radio",NULL,NULL, "巡回予定日","1","onClick=\"input_select();\"");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "巡回担当者","2","onClick=\"input_select();\"");
$form->addGroup($form_state, "form_type", "");

$def_data["form_type"] = "1";
$form->setDefaults($def_data);

// 【現予定】配送日
$text4_1[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText5(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText6(this.form,1)\" $g_form_option");
$text4_1[] =& $form->createElement("static", "", "", "-");
$text4_1[] =& $form->createElement("text", "d_start", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text4_1, "f_date_b1", "");

// 【現予定】巡回担当者
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_2", "", $select_value, $g_form_option_select);

// 【現予定】表示ボタン
$form->addElement("submit", "hyouji", "表　示");

// 【現予定】クリアボタン
$form->addElement("button", "kuria", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// 【訂正項目】配送日
$text3_1[] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText3(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText4(this.form,1)\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" onFocus=\"onForm2(this,this.form,1)\" onBlur=\"blurForm(this)\"");
$form->addGroup($text3_1, "f_date_a1", "");

// 【訂正項目】巡回担当者
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_2", "", $select_value, $g_form_option_select);

// 【訂正項目】訂正理由
$form->addElement("text", "f_text30", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// 【訂正項目】一括訂正ボタン
$form->addElement("button", "collective", "一括設定", "onClick=\"javascript:Dialogue2('一括設定します。','#')\"");

// 【訂正項目】クリアボタン
$form->addElement("button", "kuria", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// 一括訂正ALL
$check13[] =& $form->createElement("checkbox", "allcheck13", "", "一括訂正", "onClick=\"javascript:Allcheck(13)\"");
$form->addGroup($check13, "allcheck13", "");

// 一括訂正
$check13_2[] =& $form->createElement("checkbox", "check", "", "");
$form->addGroup($check13_2, "check13", "");

/****************************/
//デモ用データ
/****************************/
$demo_data = array(
        array("00000001", "2006-6-22","株式会社アポロ21世紀","伊藤一弘"),
        array("00000003", "2006-6-24","株式会社アポロ21世紀　松木SS","アメニティ西東京"),
        array("00000005", "2006-6-26","株式会社アポロ21世紀　旭が丘SS","アメニティ西東京"),
        array("00000007", "2006-6-28","株式会社アポロ21世紀　府中緑町SS","アメニティ西東京"),
        array("00000009", "2006-6-30","株式会社アポロ21世紀　玉川上水ＳＳ","アメニティ西東京"),
);

/****************************/
//js
/****************************/
$js  = "function input_select(){";
$js .= "    var C1 = document.dateForm.form_type[0].checked;\n";
$js .= "    var C2 = document.dateForm.form_type[1].checked;\n";
$js .= "    var B  = \"f_date_b1[y_start]\";\n";
$js .= "    var C  = \"f_date_b1[m_start]\";\n";
$js .= "    var D  = \"f_date_b1[d_start]\";\n";
$js .= "    var E  = \"form_staff_2\";\n";
$js .= "    if(C2 == true){\n";
$js .= "        document.dateForm.elements[B].disabled = true;\n";
$js .= "        document.dateForm.elements[C].disabled = true;\n";
$js .= "        document.dateForm.elements[D].disabled = true;\n";
$js .= "        document.dateForm.elements[B].style.backgroundColor = \"gainsboro\";\n";
$js .= "        document.dateForm.elements[C].style.backgroundColor = \"gainsboro\";\n";
$js .= "        document.dateForm.elements[D].style.backgroundColor = \"gainsboro\";\n";
$js .= "        document.dateForm.elements[E].disabled = false;\n";
$js .= "        document.dateForm.elements[E].style.backgroundColor = \"white\";\n";
$js .= "    }else if(C1 == true){\n";
$js .= "        document.dateForm.elements[B].disabled = false;\n";
$js .= "        document.dateForm.elements[C].disabled = false;\n";
$js .= "        document.dateForm.elements[D].disabled = false;\n";
$js .= "        document.dateForm.elements[B].style.backgroundColor = \"white\";\n";
$js .= "        document.dateForm.elements[C].style.backgroundColor = \"white\";\n";
$js .= "        document.dateForm.elements[D].style.backgroundColor = \"white\";\n";
$js .= "        document.dateForm.elements[E].disabled = true;\n";
$js .= "        document.dateForm.elements[E].style.backgroundColor = \"gainsboro\";\n";
$js .= "    }\n";
$js .= "}\n";

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
$page_menu = Create_Menu_f('sale','1');

/****************************/
//画面ヘッダー作成
/****************************/
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
    'js'            => "$js",
));

$smarty->assign("demo_data", $demo_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
