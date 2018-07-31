<?php

$page_title = "入金入力";

// 環境設定ファイル指定
require_once("ENV_local.php");

// DB接続設定
$db_con = Db_Connect();

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");


$ary_hier11 = array(
    0   => "0",
    1   => "1",
);
$ary_hier12 = array(
    0   => array(
        0   => "0-0",
        1   => "0-1",
    ),
    1   => array(
        0   => "1-0",
//        1   => htmlspecialchars("<b><i>1-1</i></b>"),
        1   => htmlspecialchars("1-1</option></select><select><option>test</option></select>"),
    ),
);
$ary_hier1 = array($ary_hier11, $ary_hier12);
//print_array($ary_hier1, "ヒアセレクト用アイテム配列 - エンティティ変換してるバージョン");
print "<span style=\"font: 10px; font-weight: bold; font-family: 'ＭＳ ゴシック'; \">ヒアセレクト用アイテム配列 - エンティティ変換してるバージョン</span>";
print "<xmp style=\"font: 10px; font-family: 'ＭＳ ゴシック'; \">";
print_r($ary_hier1);
print "</xmp><hr>";
$obj_select1 =& $form->addElement("hierselect", "form_select1", "", "", $attach_html);
$obj_select1->setOptions($ary_hier1);

$ary_hier21 = array(
    0   => "0",
    1   => "1",
);
$ary_hier22 = array(
    0   => array(
        0   => "0-0",
        1   => "0-1",
    ),
    1   => array(
        0   => "1-0",
//        1   => "<b><u>1-1</u></b>",
        1   => "1-1</option></select><select><option>test</option></select>",
    ),
);
$ary_hier2 = array($ary_hier21, $ary_hier22);
//print_array($ary_hier2, "ヒアセレクト用アイテム配列 - エンティティ変換してないバージョン");
print "<span style=\"font: 10px; font-weight: bold; font-family: 'ＭＳ ゴシック'; \">ヒアセレクト用アイテム配列 - エンティティ変換してないバージョン</span>";
print "<xmp style=\"font: 10px; font-family: 'ＭＳ ゴシック'; \">";
print_r($ary_hier2);
print "</xmp><hr>";
$obj_select2 =& $form->addElement("hierselect", "form_select2", "", "", $attach_html);
$obj_select2->setOptions($ary_hier2);


$form->addElement("submit", "form_submit", "サブミット");



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
$page_menu = Create_Menu_h('sale','4');

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
    "html_header"       => "$html_header",
    "page_menu"         => "$page_menu",
    "page_header"       => "$page_header",
    "html_footer"       => "$html_footer",
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


?>
