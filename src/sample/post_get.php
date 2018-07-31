<?php
$page_title = "郵便番号検索";


//環境設定ファイル
require_once("ENV_local.php");
//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$conn = Db_Connect();
//3文字-4文字
$text6[] =& $form->createElement("text","post1","テキストフォーム",'size="3" maxLength="3" value="" onkeyup="changeText11(this.form,1)" onFocus="onForm(this)" onBlur="blurForm(this)"');
$text6[] =& $form->createElement("static","","","-");
$text6[] =& $form->createElement("text","post2","テキストフォーム",'size="4" maxLength="4" value="" onFocus="onForm(this)" onBlur="blurForm(this)"');
$form->addGroup( $text6, "form_post", "form_post");

$form->addElement("text","form_address_read","テキストフォーム",'size="34" maxLength="55" name="address_read" onFocus="onForm(this)" onBlur="blurForm(this)"');

$form->addElement("text","form_address1","テキストフォーム",'size="34" maxLength="15" name="address1" onFocus="onForm(this)" onBlur="blurForm(this)"');

$form->addElement("text","form_address2","テキストフォーム",'size="34" maxLength="15" name="address2" onFocus="onForm(this)" onBlur="blurForm(this)"');

$button[] = $form->createElement("submit","auto_input","自動入力");
$form->addGroup($button, "button", "");

$post1     = $_POST["form_post"]["post1"];             //得意先コード１
$post2     = $_POST["form_post"]["post2"];             //得意先コード２
if($_POST["button"]["auto_input"] == "自動入力"){
$post_value = Post_Get($post1,$post2,$conn);
}
$cons_data["form_address_read"] = $post_value[0];
$cons_data["form_address1"] = $post_value[1];
$cons_data["form_address2"] = $post_value[2];

$form->setConstants($cons_data);


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
$page_menu = Create_Menu_h('system','1');

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
	'post_value_kana'   => "$post_value[0]",
	'post_value_add1'   => "$post_value[1]",
	'post_value_add2'   => "$post_value[2]",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
