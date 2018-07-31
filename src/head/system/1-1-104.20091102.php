<?php
$page_title = "契約マスタ";
// 環境設定ファイル
require_once("ENV_local.php");

// DBに接続
$db_con = Db_Connect();

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

// 表示データ
$disp_data[0] = array(
    "Result1",
    "1000",
    "1500",
);

$disp_data[1] = array(
    "Result2",
    "600",
    "1200",
);

$disp_data[2] = array(
    "Result1",
    "2000",
    "3000",
);

/****************************/
// HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成
/****************************/
$page_menu = Create_Menu_h("system", "2");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// 部品定義
/****************************/
// セレクトボックス用

// ○ヶ月周期
$array_rmonth = array(
	"" => "",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4",
	"5" => "5",
	"6" => "6",
);

// ○週間周期
$array_rweek = array(
	"" => "",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4",
);

// 曜日
$array_week = array(
	"" => "",
	"1" => "月",
	"2" => "火",
	"3" => "水",
	"4" => "木",
	"5" => "金",
	"6" => "土",
	"7" => "日"
);

// フォームのデフォルト値
$def_date = array(
	"shop_txt"       => "$shop_name",
	"f_radio72"      => "1",
	"form_round_div" => "1",
	"form_slip_flg"  => "1",
	"form_cost_div"  => "1",
);
$form->setDefaults($def_date);

//グリーン指定
$form->addElement("checkbox", "form_trans_check", "グリーン指定", "<b>グリーン指定</b>　", "onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");

// 運送業者
$select_value = Select_Get($db_con, "trans", $where);
$form->addElement("select", "form_trans_select", "", $select_value, $g_form_option_select);

// 直送先
$select_value = Select_Get($db_con, "direct");
$form->addElement("select", "form_direct_select", "", $select_value, $g_form_option_select);

// 出荷倉庫
$select_value = Select_Get($db_con, "ware");
$form->addElement("select", "form_ware_select", "", $select_value, $g_form_option_select);

// 担当者
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_select", "", $select_value, $g_form_option_select);

// 通信欄（得意先宛）
$form->addElement("textarea", "form_note_your", "", "rows=\"2\" cols=\"75\" \".$g_form_option_area.\" ");

// 巡回日（ラジオボタン）
$form_round_div[] =& $form->createElement("radio", null, null, "", "1");
$form_round_div[] =& $form->createElement("radio", null, null, "", "2");
$form->addGroup($form_round_div, "form_round_div", "form_round_div", "<br>");

// (1)
// 日
$form->addElement("select", "form_rweek", "", $array_rweek, $g_form_option_select);
$form->addElement("select", "form_week", "", $array_week, $g_form_option_select);

$form_stand_day1[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day1[y]','form_stand_day1[m]',4)\"".$g_form_option."\"");
$form_stand_day1[] =& $form->createElement("static", "", "", "-");
$form_stand_day1[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" $g_form_option");
$form->addGroup($form_stand_day1, "form_stand_day1", "");

// (2)
$form->addElement("select", "form_rmonth", "", $array_rmonth, $g_form_option_select);
$select_value = Select_Get($db_con, "close");
$form->addElement("select", "form_day", "", $select_value);

$form_stand_day2[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day2[y]','form_stand_day2[m]',4)\"".$g_form_option."\"");
$form_stand_day2[] =& $form->createElement("static", "", "", "-");
$form_stand_day2[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" $g_form_option");
$form->addGroup($form_stand_day2, "form_stand_day2", "");

// 行追加ボタン
$form->addElement("button", "add_row_link", "行追加", "onClick=\"javascript:Button_Submit_1('add_row_flg', '#foot', 'true')\"");

// 合計ボタン
$form->addElement("button", "form_sum_btn", "合　計", "onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true')\"");

// 登録ボタン
$form->addElement("button", "entry_button", "登　録" ,"onClick=\"javascript:return Dialogue('登録します。','1-1-123.php');\"");

// 戻るボタン
$form->addElement("button", "return_button", "戻　る", "onClick=\"javascript:history.back()\"");

/*** 画面表示用のためだけに作ったとりあえずフォームｗｗｗｗｗｗｗｗｗｗ ***/
// 商品コード
$form->addElement("text", "form_goods_cd", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_opotion\"");
// 商品名
$form->addElement("text", "form_goods_name", "", "size=\"34\" style=\"$g_form_option\"");
// 数量
$form->addElement("text", "form_num", "", "size=\"4\"");
// 原価単価
$text = null;
$text[] = $form->createElement("text", "1", "", "size=\"4\"");
$text[] = $form->createElement("static", "", "", ".");
$text[] = $form->createElement("text", "2", "", "size=\"2\"");
$form->addGroup($text, "form_genkatanka", "");
// 売上単価
$text = null;
$text[] = $form->createElement("text", "1", "", "size=\"4\"");
$text[] = $form->createElement("static", "", "", ".");
$text[] = $form->createElement("text", "2", "", "size=\"2\"");
$form->addGroup($text, "form_uriagetanka", "");


/****************************/
// ページ作成
/****************************/

//  Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
	"html_header"   => $html_header,
	"page_menu"     => $page_menu,
	"page_header"   => $page_header,
	"html_footer"   => $html_footer,
));
$smarty->assign("disp_data", $disp_data);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
