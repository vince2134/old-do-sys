<?php
$page_title = "レンタルTOレンタル";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
($auth[0] == "r") ? $form->freeze() : null;

// GET
$rental_h_id    = $_GET["rental_h_id"];
$state          = $_GET["state"];

// 該当レンタルヘッダIDのショップがオンラインかオフラインか調べる
// 以下の処理はとりあえず
$fshop_network = ($rental_h_id == "5" || $rental_h_id == "6" || $rental_h_id == "7" || $rental_h_id == "8") ? "off" : "on"; 

// メッセージ作成
$comp_msg  = ($state == null || $state == "new_req") ? "新規" : "解約";
$comp_msg .= "申請処理を行いました。";


/****************************/
// フォームパーツ作成
/****************************/
/*** ヘッダフォーム ***/
// 登録画面
$form->addElement("button", "new_button", "登録画面", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// 変更・一覧
$form->addElement("button", "change_button", "変更・一覧", "onClick=\"javascript:location.href='1-1-142.php'\"");

/*** メインフォーム ***/
if ($state == null || $state == "new_req"){
    // 初回出荷の伝票入力を行なうボタン
    $form->addElement("button", "form_print_button", "初回出荷の伝票入力を行なう", "onClick=\"location.href='../sale/1-2-101.php'\"");
}else{
    // 解約の伝票入力を行なうボタン
    $form->addElement("button", "form_print_button", "解約の伝票入力を行なう", "onClick=\"location.href='..buy/1-3-102.php'\"");
}

// 終了ボタン
$form->addElement("button", "form_quit_button", "終　了", "onClick=\"location.href='./1-3-142.php'\"");


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
    "comp_msg"      => "$comp_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
