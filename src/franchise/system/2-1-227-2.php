<?php
$page_title = "コースマスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
$shop_gid  = $_SESSION[shop_gid];

/****************************/
//部品定義
/****************************/
// 担当者
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_select", "", $select_value, $g_form_option_select);

//ボタン
// 表示
$form->addElement("submit","show_button","表　示","onClick=\"javascript:document.dateForm.submit()\"");
//クリア
$form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

// ヘッダ用ボタン
// 登録画面
$form->addElement("button", "new_button", "登録画面", "onClick=\"javascript:Referer('2-1-228.php')\"");

// 変更・一覧
$form->addElement("button", "change_button", "変更・一覧", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");


/****************************/
// 一覧表用データ作成
/****************************/
$ary_list_item[0] = array(
    "0" =>  array(                          // 担当者毎データ
        "0" =>  "Result1",                  // セル背景色指定
        "1" =>  array("0", "担当者１"),     // staff_id, staff_name
        "2" =>  array(                      // 週(A-D)毎データ
            "0" =>  array("横浜西口コース", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "戸塚コース", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "-", "-", "マレーシアコース", "フルコース", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-")
        ),
    ),
    "1" =>  array(
        "0" =>  "Result2",
        "1" =>  array("1", "担当者２"),
        "2" =>  array(
            "0" =>  array("横浜西口コース", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "戸塚コース", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "１２３４５６７８９０", "-", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "磯子コース")
        ),
    ),
    "2" =>  array(
        "0" =>  "Result1",
        "1" =>  array("2", "担当者３"),
        "2" =>  array(
            "0" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "関内コース", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-")
        )
    )
);

$ary_list_item[1] = array(
    "0" =>  array(                          // 担当者毎データ
        "0" =>  "Result1",                  // セル背景色指定
        "1" =>  array("0", "担当者１"),     // staff_id, staff_name
        "2" =>  array(                      // 週(A-D)毎データ
            "0" =>  array("横浜西口コース", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "戸塚コース", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "-", "-", "マレーシアコース", "フルコース", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "4" =>  array("月末コース")     // 月末
        ),
    ),
    "1" =>  array(
        "0" =>  "Result2",
        "1" =>  array("1", "担当者２"),
        "2" =>  array(
            "0" =>  array("横浜西口コース", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "戸塚コース", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "１２３４５６７８９０", "-", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "磯子コース"),
            "4" =>  array("-")              // 月末
        ),
    ),
    "2" =>  array(
        "0" =>  "Result1",
        "1" =>  array("2", "担当者３"),
        "2" =>  array(
            "0" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "関内コース", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "4" =>  array("-")              // 月末
        )
    )
);

$ary_list_item[2] = array(
    "0" =>  array(                          // 担当者毎データ
        "0" =>  "Result1",                  // セル背景色指定
        "1" =>  array("0", "担当者１"),     // staff_id, staff_name
        "2" =>  array(                      // 週(A-D)毎データ
            "0" =>  array("横浜西口コース", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "戸塚コース", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "-", "-", "マレーシアコース", "フルコース", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-")
        ),
    ),
    "1" =>  array(
        "0" =>  "Result2",
        "1" =>  array("1", "担当者２"),
        "2" =>  array(
            "0" =>  array("横浜西口コース", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "戸塚コース", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "１２３４５６７８９０", "-", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "磯子コース")
        ),
    ),
    "2" =>  array(
        "0" =>  "Result1",
        "1" =>  array("2", "担当者３"),
        "2" =>  array(
            "0" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "関内コース", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-")
        )
    )
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
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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
	'total_count'   => "$total_count",
    'auth_r_msg'    => "$auth_r_msg",
	'comp_msg'   	=> "$comp_msg"
));

$smarty->assign("ary_list_item", $ary_list_item);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
