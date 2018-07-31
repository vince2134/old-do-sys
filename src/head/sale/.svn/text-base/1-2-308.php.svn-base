<?php
/****************************/
//
// ・ (2006/05/31)新規作成＜watanabe-k＞
//
/****************************/

$page_title = "請求データ作成";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

/****************************/
//フォーム作成
/****************************/
$form->addElement("button", "form_ok_button","Ｏ　Ｋ","onClick=\"location.href('./1-2-301.php')\"");

/****************************/
//外部変数取得
/****************************/
$shop_id = $_SESSION["client_id"];
$shop_gid = $_SESSION["shop_gid"];


if($_GET[add_flg] != true){
    header("Location:../top.php");
}

/***************************/
//GETがある場合
/***************************/
$get_data = $_SESSION["get_data"];

if(count($get_data) > 0){
    $judge_id = implode(",",$get_data);

    $warning = "※ 未更新の請求書を更新しないと翌月の請求書が作成されません。";

    $sql  = "SELECT";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id IN ($judge_id)";
    $sql .= " ORDER BY client_cd1, client_cd2 ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_judge_data = pg_fetch_all($result);

    for($i = 0; $i < count($get_judge_data); $i++){
        $err_msg[$i]  = $get_judge_data[$i]["client_cd1"]."-";
        $err_msg[$i] .= $get_judge_data[$i]["client_cd2"]."　";
        $err_msg[$i] .= $get_judge_data[$i]["client_cname"];
        $err_msg[$i] .= "の請求書は、未更新の請求書があったため作成できませんでした。";
    }
}


/*
$no_sheet_data = $_SESSION["no_sheet_data"];
if(count($no_sheet_data) > 0){
    $no_sheet_id = implode(",",$no_sheet_data);

    $sql  = "SELECT";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id IN ($no_sheet_id)";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_no_sheet_data = pg_fetch_all($result);

    for($i = 0; $i < count($get_no_sheet_data); $i++){
        $err_msg2[$i]  = $get_no_sheet_data[$i]["client_cd1"]."-";
        $err_msg2[$i] .= $get_no_sheet_data[$i]["client_cd2"]."　";
        $err_msg2[$i] .= $get_no_sheet_data[$i]["client_cname"];
        $err_msg2[$i] .= "の請求書は、請求書フォーマット設定を行っていないため作成できませんでした。";
    }
}

$renew_data = $_SESSION["renew_data"];
if(count($renew_data) > 0){
    $renew_data_id = implode(",",$renew_data);
    $sql  = "SELECT";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id IN ($renew_data_id)";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $get_renew_data = pg_fetch_all($result);

    for($i = 0; $i < count($get_renew_data); $i++){

        $err_msg3[$i]  = $get_renew_data[$i]["client_cd1"]."-";
        $err_msg3[$i] .= $get_renew_data[$i]["client_cd2"]."　";
        $err_msg3[$i] .= $get_renew_data[$i]["client_cname"];
        $err_msg3[$i] .= "の請求書は、前回の請求更新日以前の日付を指定していたため作成できませんでした。";
    }
}

$made_data = $_SESSION["made_data"];
if(count($made_data) > 0){
    $judge_id = implode(",",$made_data);
    $sql  = "SELECT";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id IN ($judge_id)";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_judge_data = pg_fetch_all($result);

    for($i = 0; $i < count($get_judge_data); $i++){
        $err_msg4[$i]  = $get_judge_data[$i]["client_cd1"]."-";
        $err_msg4[$i] .= $get_judge_data[$i]["client_cd2"]."　";
        $err_msg4[$i] .= $get_judge_data[$i]["client_cname"];
        $err_msg4[$i] .= "の請求書は、既に作成済みです。";
    }
}
*/


unset($_SESSION["get_data"]);
unset($_SESSION["no_sheet_data"]);
unset($_SESSION["renew_data"]);
unset($_SESSION["made_data"]);

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
$page_menu = Create_Menu_h('sale','3');
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
    'warning'       => "$warning",
));

$smarty->assign("err_msg",$err_msg);
$smarty->assign("err_msg2",$err_msg2);
$smarty->assign("err_msg3",$err_msg3);
$smarty->assign("err_msg4",$err_msg4);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
