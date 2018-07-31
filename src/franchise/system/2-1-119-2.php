<?php
$page_title = "契約マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");


//DB接続
$db_con = Db_Connect();

/****************************/
//フォーム定義
/****************************/

//デフォルト値の設定
$def_date = array(
    "form_round_div_1"     => "1",
	"form_round_div_2"     => "1",
);
$form->setDefaults($def_date);

//得意先
$text19[] =& $form->createElement("text","code1","テキストフォーム","size=\"7\" maxLength=\"6\" onkeyup=\"changeText_customer(this.form)\" ".$g_form_option."\"");
$text19[] =& $form->createElement("static","","","-");
$text19[] =& $form->createElement("text","code2","テキストフォーム","size=\"4\" maxLength=\"4\" ".$g_form_option."\"");
$text19[] =& $form->createElement("text","name","テキストフォーム",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');
$form->addGroup( $text19, "f_customer", "f_customer");

//請求先
$text36[] =& $form->createElement("text","code1","テキストフォーム","size=\"7\" maxLength=\"6\" onKeyUp=\"javascript:display(this,'claim')\" ".$g_form_option."\"");
$text36[] =& $form->createElement("static","","","-");
$text36[] =& $form->createElement("text","code2","テキストフォーム","size=\"4\" maxLength=\"4\" onKeyUp=\"javascript:display(this,'claim')\" ".$g_form_option."\"");
$text36[] =& $form->createElement("text","name","テキストフォーム",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');
$form->addGroup( $text36, "f_claim", "f_claim");

//チーム
//$team_ary = Select_Get($db_con,'team');
$form->addElement('select', 'form_team', 'セレクトボックス', $team_ary, $g_form_option_select);


//巡回担当者(1)
$select_value = Select_Get($db_con,'staff');
$form->addElement('select', 'f_select1', 'セレクトボックス', $select_value,$g_form_option_select);
//巡回担当者(2)
$form->addElement('select', 'f_select2', 'セレクトボックス', $select_value,$g_form_option_select);

//商品(1)
$form->addElement("text","f_goods1","テキストフォーム","size=\"10\" maxLength=\"8\" onKeyUp=\"javascript:display4(this,'goods1')\" ".$g_form_option."\"");
$form->addElement("text","t_goods1","テキストフォーム","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");
//商品(2)
$form->addElement("text","f_goods2","テキストフォーム","size=\"10\" maxLength=\"8\" onKeyUp=\"javascript:display4(this,'goods2')\" ".$g_form_option."\"");
$form->addElement("text","t_goods2","テキストフォーム","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//売上単価(1)
$text5_1[] =& $form->createElement("text","f_text9","テキストフォーム","size=\"11\" maxLength=\"9\" onkeyup=\"changeText10(this.form,1)\" style=\"text-align: right\"".$g_form_option."\"");
$text5_1[] =& $form->createElement("static","","",".");
$text5_1[] =& $form->createElement("text","f_text2","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"text-align: left\" ".$g_form_option."\"");
$form->addGroup( $text5_1, "f_code_c1", "f_code_c1");
//売上単価(2)
$text5_2[] =& $form->createElement("text","f_text9","テキストフォーム","size=\"11\" maxLength=\"9\" onkeyup=\"changeText10(this.form,2)\" style=\"text-align: right\" ".$g_form_option."\"");
$text5_2[] =& $form->createElement("static","","",".");
$text5_2[] =& $form->createElement("text","f_text2","テキストフォーム","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");
$form->addGroup( $text5_2, "f_code_c2", "f_code_c2");

//(4)基準日 (1)
$text = "";
$text[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day4_1[y]','form_stand_day4_1[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day4_1[m]','form_stand_day4_1[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day4_1[d]','form_cale_mon4_1',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day4_1","form_stand_day4_1","-");

$form->addElement("text","form_cale_mon4_1","テキストフォーム","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day4_1","テキストフォーム",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(4)基準日 (2)
$text = "";
$text[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day4_2[y]','form_stand_day4_2[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day4_2[m]','form_stand_day4_2[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day4_2[d]','form_cale_mon4_2',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day4_2","form_stand_day4_2","-");

$form->addElement("text","form_cale_mon4_2","テキストフォーム","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day4_2","テキストフォーム",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(5)基準日 (1)
$text = "";
$text[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day5_1[y]','form_stand_day5_1[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day5_1[m]','form_stand_day5_1[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day5_1[d]','form_cale_mon5_1',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day5_1","form_stand_day5_1","-");

$form->addElement("text","form_cale_mon5_1","テキストフォーム","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day5_1","テキストフォーム",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(5)基準日 (2)
$text = "";
$text[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day5_2[y]','form_stand_day5_2[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day5_2[m]','form_stand_day5_2[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day5_2[d]','form_cale_mon5_2',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day5_2","form_stand_day5_2","-");

$form->addElement("text","form_cale_mon5_2","テキストフォーム","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day5_2","テキストフォーム",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(6)基準日 (1)
$text = "";
$text[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day6_1[y]','form_stand_day6_1[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day6_1[m]','form_stand_day6_1[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day6_1[d]','form_week_num6_1',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day6_1","form_stand_day6_1","-");

$form->addElement("text","form_week_num6_1","テキストフォーム","size=\"1\" maxLength=\"1\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day6_1","テキストフォーム",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(6)基準日 (2)
$text = "";
$text[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day6_2[y]','form_stand_day6_2[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day6_2[m]','form_stand_day6_2[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day6_2[d]','form_week_num6_2',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day6_2","form_stand_day6_2","-");

$form->addElement("text","form_week_num6_2","テキストフォーム","size=\"1\" maxLength=\"1\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day6_2","テキストフォーム",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//表示
$button[] = $form->createElement("submit","hyouji","表　示");
//クリア
$button[] = $form->createElement("button","kuria","クリア","onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");
//一括訂正
$button[] = $form->createElement("button","change2","一括訂正","onClick=\"javascript:location.href='2-1-114.php'\"");

//戻る
$button[] = $form->createElement("button","modoru","戻　る","onClick=\"javascript:history.back()\"");
//登録(ヘッダー)
$form->addElement("button","new_button","登　録","onClick=\"location.href='2-1-104.php?flg=add'\"");
//変更・一覧
$form->addElement("button","change_button","変更・一覧","onClick=\"javascript:Referer('2-1-111.php')\"");
//一括訂正(ヘッダー)
$form->addElement("button","all_button","一括訂正","style=\"color: #ff0000;\" onClick=\"location.href='2-1-114.php'\"");
$form->addGroup($button, "button", "");

/****************************/
//デモデータ
/****************************/
$demo_data = array(
    array("A週　月曜日", "アポロ２１世紀",          "アポロ２１世紀", "MSG-CP","70", "100", "伊藤一弘"),
    array("D週　水曜日", "石川島播磨重工業株式会社","アポロ２１世紀", "MSG-CV","72", "100", "アメニティ西東京"),
    array("毎月１０日",  "パーラーアトム",          "アポロ２１世紀", "DSS3-W","77", "100", "アメニティ西東京"),
    array("毎月２０日",  "株式会社アイエー",        "アポロ２１世紀", "DSS7-W","75", "100", "佐久間　茂"),
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
//メニュー作成
/****************************/
$page_menu = Create_Menu_f('system','1');
/****************************/
//画面ヘッダー作成
/****************************/
$total_count = 7;
$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

$smarty->assign("demo_data",$demo_data);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'total_count'    => "$total_count",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
