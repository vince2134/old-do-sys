<?php
$page_title = "入金入力";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();

/*****************************/
// 権限関連処理
/*****************************/
// 権限チェック
$auth   = Auth_Check($db_con);

/****************************/
// フォームパーツ作成
/****************************/
// 入金ボタン押下時の最終エラーチェックにひっかかった場合
if ($_GET["err"] == "1"){

    $err_msg = "伝票変更中に日次更新処理が行われたため、変更できません。";
    $form->addElement("button","ok_button","Ｏ　Ｋ", "onClick=\"location.href='2-2-403.php?search=1'\"");

}else
// 入金ボタン押下時の最終エラーチェックにひっかかった場合
if ($_GET["err"] == "2"){

    $err_msg = "請求書が削除されたため、入金できません。";
    $form->addElement("button","ok_button","Ｏ　Ｋ", "onClick=\"location.href='2-2-403.php?search=1'\"");

}else
// 入金ボタン押下時の最終エラーチェックにひっかかった場合
if ($_GET["err"] == "3"){

    $err_msg = "伝票変更中に伝票が削除されたため、変更できません。";
    $form->addElement("button","ok_button","Ｏ　Ｋ", "onClick=\"location.href='2-2-403.php?search=1'\"");

}else{

    if ($_GET["flg"] == "get"){
        $form->addElement("button","ok_button","Ｏ　Ｋ", "onClick=\"location.href='2-2-403.php?search=1'\"");
    }else{
        $form->addElement("button","ok_button","Ｏ　Ｋ", "onClick=\"location.href='2-2-405.php'\"");
    }

}

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
$page_menu = Create_Menu_h("buy", "3");

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign
$smarty->assign("var",array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "err_msg"       => "$err_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>

