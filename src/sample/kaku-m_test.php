<?php
$page_title = "権限ＣＳＶ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//DB接続
$db_con = Db_Connect("amenity_demo_new");


/*****************************/
// 権限関連処理
/*****************************/
// 権限チェック
//$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
//外部変数取得
/****************************/

/****************************/
//初期設定
/****************************/
$def_data = array(
    "form_del_compe" => "1",
    "form_accept_compe" => "1",
    "form_compe_invest" => "1",
    "form_staff_state" => "在職中",
);
$form->setDefaults($def_data);

/****************************/
//フォーム作成（固定）
/****************************/
//CSV出力ボタン
$form->addElement("submit", "csv_btn", "CSV出力");
//表示
$form->addElement("submit","show_btn","表　示");
//クリア
$form->addElement("button","clear_btn","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

//ショップコード
$text[] =& $form->createElement("text","cd1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_client_cd[cd1]','form_client_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  ".$g_form_option."\"");
$form->addGroup( $text, "form_client_cd", "form_client_cd");
//担当者コード
$form->addElement("text","form_charge_cd","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"  ".$g_form_option."\"");

//削除権限
$radio[] =& $form->createElement( "radio",NULL,NULL, "全","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "有","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "無","3");
$form->addGroup($radio, "form_del_compe", "削除権限");
//承認権限
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "全","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "有","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "無","3");
$form->addGroup($radio, "form_accept_compe", "承認権限権限");
//権限付与
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "全","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "済","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "未","3");
$form->addGroup($radio, "form_compe_invest", "権限付与");
//在職識別
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "在職中","在職中");
$radio[] =& $form->createElement( "radio",NULL,NULL, "退職","退職");
$radio[] =& $form->createElement( "radio",NULL,NULL, "休業","休業");
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","全て");
$form->addGroup($radio, "form_staff_state", "在職識別");

//ショップ名
$form->addElement("text","form_client_name","テキストフォーム","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");
//スタッフ名
$form->addElement("text","form_staff_name","テキストフォーム","size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

//中項目？
$select_value="";
$select_value=array(""=>"","中分類"=>"中分類",);
$form->addElement("select","form_select_kind","セレクトボックス",$select_value,$g_form_option_select);

/*************************/
//hidden作成
/*************************/

$form->addElement("hidden","permit[h][0][0][0][n]",null);
$form->addElement("hidden","permit[h][0][0][0][r]",null);
$form->addElement("hidden","permit[h][0][0][0][w]",null);
$form->addElement("hidden","permit[h][1][0][0][n]",null);
$form->addElement("hidden","permit[h][1][0][0][r]",null);
$form->addElement("hidden","permit[h][1][0][0][w]",null);
$form->addElement("hidden","permit[h][1][1][0][n]",null);
$form->addElement("hidden","permit[h][1][1][0][r]",null);
$form->addElement("hidden","permit[h][1][1][0][w]",null);
$form->addElement("hidden","permit[h][1][2][0][n]",null);
$form->addElement("hidden","permit[h][1][2][0][r]",null);
$form->addElement("hidden","permit[h][1][3][0][n]",null);
$form->addElement("hidden","permit[h][1][3][0][r]",null);
$form->addElement("hidden","permit[h][1][3][0][w]",null);
$form->addElement("hidden","permit[h][1][4][0][n]",null);
$form->addElement("hidden","permit[h][1][4][0][r]",null);
$form->addElement("hidden","permit[h][1][4][0][w]",null);
$form->addElement("hidden","permit[h][1][5][0][n]",null);
$form->addElement("hidden","permit[h][1][5][0][r]",null);
$form->addElement("hidden","permit[h][1][5][0][w]",null);
$form->addElement("hidden","permit[h][1][6][0][n]",null);
$form->addElement("hidden","permit[h][1][6][0][r]",null);
$form->addElement("hidden","permit[h][1][6][0][w]",null);
$form->addElement("hidden","permit[h][2][0][0][n]",null);
$form->addElement("hidden","permit[h][2][0][0][r]",null);
$form->addElement("hidden","permit[h][2][0][0][w]",null);
$form->addElement("hidden","permit[h][2][1][0][n]",null);
$form->addElement("hidden","permit[h][2][1][0][r]",null);
$form->addElement("hidden","permit[h][2][1][0][w]",null);
$form->addElement("hidden","permit[h][2][2][0][n]",null);
$form->addElement("hidden","permit[h][2][2][0][r]",null);
$form->addElement("hidden","permit[h][2][3][0][n]",null);
$form->addElement("hidden","permit[h][2][3][0][r]",null);
$form->addElement("hidden","permit[h][2][3][0][w]",null);
$form->addElement("hidden","permit[h][2][4][0][n]",null);
$form->addElement("hidden","permit[h][2][4][0][r]",null);
$form->addElement("hidden","permit[h][2][4][0][w]",null);
$form->addElement("hidden","permit[h][3][0][0][n]",null);
$form->addElement("hidden","permit[h][3][0][0][r]",null);
$form->addElement("hidden","permit[h][3][0][0][w]",null);
$form->addElement("hidden","permit[h][3][1][0][n]",null);
$form->addElement("hidden","permit[h][3][1][0][r]",null);
$form->addElement("hidden","permit[h][3][1][0][w]",null);
$form->addElement("hidden","permit[h][3][2][0][n]",null);
$form->addElement("hidden","permit[h][3][2][0][r]",null);
$form->addElement("hidden","permit[h][3][2][0][w]",null);
$form->addElement("hidden","permit[h][4][0][0][n]",null);
$form->addElement("hidden","permit[h][4][0][0][r]",null);
$form->addElement("hidden","permit[h][4][0][0][w]",null);
$form->addElement("hidden","permit[h][4][1][0][n]",null);
$form->addElement("hidden","permit[h][4][1][0][r]",null);
$form->addElement("hidden","permit[h][4][1][0][w]",null);
$form->addElement("hidden","permit[h][5][0][0][n]",null);
$form->addElement("hidden","permit[h][5][0][0][r]",null);
$form->addElement("hidden","permit[h][5][0][0][w]",null);
$form->addElement("hidden","permit[h][5][1][0][n]",null);
$form->addElement("hidden","permit[h][5][1][0][r]",null);
$form->addElement("hidden","permit[h][5][1][0][w]",null);
$form->addElement("hidden","permit[h][5][2][0][n]",null);
$form->addElement("hidden","permit[h][5][2][0][r]",null);
$form->addElement("hidden","permit[h][5][3][0][n]",null);
$form->addElement("hidden","permit[h][5][3][0][r]",null);
$form->addElement("hidden","permit[h][5][3][0][w]",null);
$form->addElement("hidden","permit[h][5][4][0][n]",null);
$form->addElement("hidden","permit[h][5][4][0][r]",null);
$form->addElement("hidden","permit[h][5][4][0][w]",null);
$form->addElement("hidden","permit[h][5][5][0][n]",null);
$form->addElement("hidden","permit[h][5][5][0][r]",null);
$form->addElement("hidden","permit[h][5][5][0][w]",null);
$form->addElement("hidden","permit[h][6][0][0][n]",null);
$form->addElement("hidden","permit[h][6][0][0][r]",null);
$form->addElement("hidden","permit[h][6][0][0][w]",null);
$form->addElement("hidden","permit[h][6][1][0][n]",null);
$form->addElement("hidden","permit[h][6][1][0][r]",null);
$form->addElement("hidden","permit[h][6][1][0][w]",null);
$form->addElement("hidden","permit[h][6][1][1][n]",null);
$form->addElement("hidden","permit[h][6][1][1][r]",null);
$form->addElement("hidden","permit[h][6][1][1][w]",null);
$form->addElement("hidden","permit[h][6][1][2][n]",null);
$form->addElement("hidden","permit[h][6][1][2][r]",null);
$form->addElement("hidden","permit[h][6][1][2][w]",null);
$form->addElement("hidden","permit[h][6][1][3][n]",null);
$form->addElement("hidden","permit[h][6][1][3][r]",null);
$form->addElement("hidden","permit[h][6][1][3][w]",null);
$form->addElement("hidden","permit[h][6][1][4][n]",null);
$form->addElement("hidden","permit[h][6][1][4][r]",null);
$form->addElement("hidden","permit[h][6][1][4][w]",null);
$form->addElement("hidden","permit[h][6][1][5][n]",null);
$form->addElement("hidden","permit[h][6][1][5][r]",null);
$form->addElement("hidden","permit[h][6][1][5][w]",null);
$form->addElement("hidden","permit[h][6][2][0][n]",null);
$form->addElement("hidden","permit[h][6][2][0][r]",null);
$form->addElement("hidden","permit[h][6][2][0][w]",null);
$form->addElement("hidden","permit[h][6][2][1][n]",null);
$form->addElement("hidden","permit[h][6][2][1][r]",null);
$form->addElement("hidden","permit[h][6][2][1][w]",null);
$form->addElement("hidden","permit[h][6][2][2][n]",null);
$form->addElement("hidden","permit[h][6][2][2][r]",null);
$form->addElement("hidden","permit[h][6][2][2][w]",null);
$form->addElement("hidden","permit[h][6][2][3][n]",null);
$form->addElement("hidden","permit[h][6][2][3][r]",null);
$form->addElement("hidden","permit[h][6][2][3][w]",null);
$form->addElement("hidden","permit[h][6][2][4][n]",null);
$form->addElement("hidden","permit[h][6][2][4][r]",null);
$form->addElement("hidden","permit[h][6][2][4][w]",null);
$form->addElement("hidden","permit[h][6][2][5][n]",null);
$form->addElement("hidden","permit[h][6][2][5][r]",null);
$form->addElement("hidden","permit[h][6][2][5][w]",null);
$form->addElement("hidden","permit[h][6][3][0][n]",null);
$form->addElement("hidden","permit[h][6][3][0][r]",null);
$form->addElement("hidden","permit[h][6][3][0][w]",null);
$form->addElement("hidden","permit[h][6][3][1][n]",null);
$form->addElement("hidden","permit[h][6][3][1][r]",null);
$form->addElement("hidden","permit[h][6][3][1][w]",null);
$form->addElement("hidden","permit[h][6][3][2][n]",null);
$form->addElement("hidden","permit[h][6][3][2][r]",null);
$form->addElement("hidden","permit[h][6][3][2][w]",null);
$form->addElement("hidden","permit[h][6][3][3][n]",null);
$form->addElement("hidden","permit[h][6][3][3][r]",null);
$form->addElement("hidden","permit[h][6][3][3][w]",null);
$form->addElement("hidden","permit[h][6][3][4][n]",null);
$form->addElement("hidden","permit[h][6][3][4][r]",null);
$form->addElement("hidden","permit[h][6][3][4][w]",null);
$form->addElement("hidden","permit[h][6][3][5][n]",null);
$form->addElement("hidden","permit[h][6][3][5][r]",null);
$form->addElement("hidden","permit[h][6][3][5][w]",null);
$form->addElement("hidden","permit[h][6][3][6][n]",null);
$form->addElement("hidden","permit[h][6][3][6][r]",null);
$form->addElement("hidden","permit[h][6][3][6][w]",null);
$form->addElement("hidden","permit[h][6][3][7][n]",null);
$form->addElement("hidden","permit[h][6][3][7][r]",null);
$form->addElement("hidden","permit[h][6][3][7][w]",null);
$form->addElement("hidden","permit[h][6][3][8][n]",null);
$form->addElement("hidden","permit[h][6][3][8][r]",null);
$form->addElement("hidden","permit[h][6][3][8][w]",null);
$form->addElement("hidden","permit[h][6][3][9][n]",null);
$form->addElement("hidden","permit[h][6][3][9][r]",null);
$form->addElement("hidden","permit[h][6][3][9][w]",null);
$form->addElement("hidden","permit[h][6][3][10][n]",null);
$form->addElement("hidden","permit[h][6][3][10][r]",null);
$form->addElement("hidden","permit[h][6][3][10][w]",null);
$form->addElement("hidden","permit[h][6][3][11][n]",null);
$form->addElement("hidden","permit[h][6][3][11][r]",null);
$form->addElement("hidden","permit[h][6][3][11][w]",null);
$form->addElement("hidden","permit[h][6][3][12][n]",null);
$form->addElement("hidden","permit[h][6][3][12][r]",null);
$form->addElement("hidden","permit[h][6][3][12][w]",null);
$form->addElement("hidden","permit[h][6][4][0][n]",null);
$form->addElement("hidden","permit[h][6][4][0][r]",null);
$form->addElement("hidden","permit[h][6][4][0][w]",null);
$form->addElement("hidden","permit[h][6][4][1][n]",null);
$form->addElement("hidden","permit[h][6][4][1][r]",null);
$form->addElement("hidden","permit[h][6][4][1][w]",null);
$form->addElement("hidden","permit[h][6][4][2][n]",null);
$form->addElement("hidden","permit[h][6][4][2][r]",null);
$form->addElement("hidden","permit[h][6][4][2][w]",null);
$form->addElement("hidden","permit[h][6][4][3][n]",null);
$form->addElement("hidden","permit[h][6][4][3][r]",null);
$form->addElement("hidden","permit[h][6][4][3][w]",null);
$form->addElement("hidden","permit[h][6][4][4][n]",null);
$form->addElement("hidden","permit[h][6][4][4][r]",null);
$form->addElement("hidden","permit[h][6][4][4][w]",null);
$form->addElement("hidden","permit[h][6][4][5][n]",null);
$form->addElement("hidden","permit[h][6][4][5][r]",null);
$form->addElement("hidden","permit[h][6][4][5][w]",null);
$form->addElement("hidden","permit[h][6][5][0][n]",null);
$form->addElement("hidden","permit[h][6][5][0][r]",null);
$form->addElement("hidden","permit[h][6][5][0][w]",null);
$form->addElement("hidden","permit[h][6][5][1][n]",null);
$form->addElement("hidden","permit[h][6][5][1][r]",null);
$form->addElement("hidden","permit[h][6][5][1][w]",null);
$form->addElement("hidden","permit[h][6][5][2][n]",null);
$form->addElement("hidden","permit[h][6][5][2][r]",null);
$form->addElement("hidden","permit[h][6][5][2][w]",null);
$form->addElement("hidden","permit[h][6][5][3][n]",null);
$form->addElement("hidden","permit[h][6][5][3][r]",null);
$form->addElement("hidden","permit[h][6][5][3][w]",null);
$form->addElement("hidden","permit[h][6][5][4][n]",null);
$form->addElement("hidden","permit[h][6][5][4][r]",null);
$form->addElement("hidden","permit[h][6][5][4][w]",null);

$form->addElement("hidden","permit[f][0][0][0][0]",null);
$form->addElement("hidden","permit[f][0][0][0][r]",null);
$form->addElement("hidden","permit[f][0][0][0][w]",null);
$form->addElement("hidden","permit[f][1][0][0][n]",null);
$form->addElement("hidden","permit[f][1][0][0][r]",null);
$form->addElement("hidden","permit[f][1][0][0][w]",null);
$form->addElement("hidden","permit[f][1][1][0][n]",null);
$form->addElement("hidden","permit[f][1][1][0][r]",null);
$form->addElement("hidden","permit[f][1][1][0][w]",null);
$form->addElement("hidden","permit[f][1][2][0][n]",null);
$form->addElement("hidden","permit[f][1][2][0][r]",null);
$form->addElement("hidden","permit[f][1][3][0][n]",null);
$form->addElement("hidden","permit[f][1][3][0][r]",null);
$form->addElement("hidden","permit[f][1][3][0][w]",null);
$form->addElement("hidden","permit[f][1][4][0][n]",null);
$form->addElement("hidden","permit[f][1][4][0][r]",null);
$form->addElement("hidden","permit[f][1][4][0][w]",null);
$form->addElement("hidden","permit[f][1][5][0][n]",null);
$form->addElement("hidden","permit[f][1][5][0][r]",null);
$form->addElement("hidden","permit[f][1][5][0][w]",null);
$form->addElement("hidden","permit[f][2][0][0][n]",null);
$form->addElement("hidden","permit[f][2][0][0][r]",null);
$form->addElement("hidden","permit[f][2][0][0][w]",null);
$form->addElement("hidden","permit[f][2][1][0][n]",null);
$form->addElement("hidden","permit[f][2][1][0][r]",null);
$form->addElement("hidden","permit[f][2][1][0][w]",null);
$form->addElement("hidden","permit[f][2][2][0][n]",null);
$form->addElement("hidden","permit[f][2][2][0][r]",null);
$form->addElement("hidden","permit[f][2][3][0][n]",null);
$form->addElement("hidden","permit[f][2][3][0][r]",null);
$form->addElement("hidden","permit[f][2][3][0][w]",null);
$form->addElement("hidden","permit[f][2][4][0][n]",null);
$form->addElement("hidden","permit[f][2][4][0][r]",null);
$form->addElement("hidden","permit[f][2][4][0][w]",null);
$form->addElement("hidden","permit[f][3][0][0][n]",null);
$form->addElement("hidden","permit[f][3][0][0][r]",null);
$form->addElement("hidden","permit[f][3][0][0][w]",null);
$form->addElement("hidden","permit[f][3][1][0][n]",null);
$form->addElement("hidden","permit[f][3][1][0][r]",null);
$form->addElement("hidden","permit[f][3][1][0][w]",null);
$form->addElement("hidden","permit[f][3][2][0][n]",null);
$form->addElement("hidden","permit[f][3][2][0][r]",null);
$form->addElement("hidden","permit[f][4][0][0][n]",null);
$form->addElement("hidden","permit[f][4][0][0][r]",null);
$form->addElement("hidden","permit[f][4][0][0][w]",null);
$form->addElement("hidden","permit[f][4][1][0][n]",null);
$form->addElement("hidden","permit[f][4][1][0][r]",null);
$form->addElement("hidden","permit[f][4][1][0][w]",null);
$form->addElement("hidden","permit[f][5][0][0][n]",null);
$form->addElement("hidden","permit[f][5][0][0][r]",null);
$form->addElement("hidden","permit[f][5][0][0][w]",null);
$form->addElement("hidden","permit[f][5][1][0][n]",null);
$form->addElement("hidden","permit[f][5][1][0][r]",null);
$form->addElement("hidden","permit[f][5][1][0][w]",null);
$form->addElement("hidden","permit[f][5][2][0][n]",null);
$form->addElement("hidden","permit[f][5][2][0][r]",null);
$form->addElement("hidden","permit[f][5][3][0][n]",null);
$form->addElement("hidden","permit[f][5][3][0][r]",null);
$form->addElement("hidden","permit[f][5][3][0][w]",null);
$form->addElement("hidden","permit[f][5][4][0][n]",null);
$form->addElement("hidden","permit[f][5][4][0][r]",null);
$form->addElement("hidden","permit[f][5][4][0][w]",null);
$form->addElement("hidden","permit[f][5][5][0][n]",null);
$form->addElement("hidden","permit[f][5][5][0][r]",null);
$form->addElement("hidden","permit[f][5][5][0][w]",null);
$form->addElement("hidden","permit[f][6][0][0][n]",null);
$form->addElement("hidden","permit[f][6][0][0][r]",null);
$form->addElement("hidden","permit[f][6][0][0][w]",null);
$form->addElement("hidden","permit[f][6][1][0][n]",null);
$form->addElement("hidden","permit[f][6][1][0][r]",null);
$form->addElement("hidden","permit[f][6][1][0][w]",null);
$form->addElement("hidden","permit[f][6][1][1][n]",null);
$form->addElement("hidden","permit[f][6][1][1][r]",null);
$form->addElement("hidden","permit[f][6][1][1][w]",null);
$form->addElement("hidden","permit[f][6][1][2][n]",null);
$form->addElement("hidden","permit[f][6][1][2][r]",null);
$form->addElement("hidden","permit[f][6][1][2][w]",null);
$form->addElement("hidden","permit[f][6][1][3][n]",null);
$form->addElement("hidden","permit[f][6][1][3][r]",null);
$form->addElement("hidden","permit[f][6][1][3][w]",null);
$form->addElement("hidden","permit[f][6][1][4][n]",null);
$form->addElement("hidden","permit[f][6][1][4][r]",null);
$form->addElement("hidden","permit[f][6][1][4][w]",null);
$form->addElement("hidden","permit[f][6][1][5][n]",null);
$form->addElement("hidden","permit[f][6][1][5][r]",null);
$form->addElement("hidden","permit[f][6][1][5][w]",null);
$form->addElement("hidden","permit[f][6][1][6][n]",null);
$form->addElement("hidden","permit[f][6][1][6][r]",null);
$form->addElement("hidden","permit[f][6][1][6][w]",null);
$form->addElement("hidden","permit[f][6][1][7][n]",null);
$form->addElement("hidden","permit[f][6][1][7][r]",null);
$form->addElement("hidden","permit[f][6][1][7][w]",null);
$form->addElement("hidden","permit[f][6][1][8][n]",null);
$form->addElement("hidden","permit[f][6][1][8][r]",null);
$form->addElement("hidden","permit[f][6][1][8][w]",null);
$form->addElement("hidden","permit[f][6][1][9][n]",null);
$form->addElement("hidden","permit[f][6][1][9][r]",null);
$form->addElement("hidden","permit[f][6][1][9][w]",null);
$form->addElement("hidden","permit[f][6][1][10][n]",null);
$form->addElement("hidden","permit[f][6][1][10][r]",null);
$form->addElement("hidden","permit[f][6][1][10][w]",null);
$form->addElement("hidden","permit[f][6][1][11][n]",null);
$form->addElement("hidden","permit[f][6][1][11][r]",null);
$form->addElement("hidden","permit[f][6][1][11][w]",null);
$form->addElement("hidden","permit[f][6][2][0][n]",null);
$form->addElement("hidden","permit[f][6][2][0][r]",null);
$form->addElement("hidden","permit[f][6][2][0][w]",null);
$form->addElement("hidden","permit[f][6][2][1][n]",null);
$form->addElement("hidden","permit[f][6][2][1][r]",null);
$form->addElement("hidden","permit[f][6][2][1][w]",null);
$form->addElement("hidden","permit[f][6][2][2][n]",null);
$form->addElement("hidden","permit[f][6][2][2][r]",null);
$form->addElement("hidden","permit[f][6][2][2][w]",null);
$form->addElement("hidden","permit[f][6][2][3][n]",null);
$form->addElement("hidden","permit[f][6][2][3][r]",null);
$form->addElement("hidden","permit[f][6][2][3][w]",null);
$form->addElement("hidden","permit[f][6][2][4][n]",null);
$form->addElement("hidden","permit[f][6][2][4][r]",null);
$form->addElement("hidden","permit[f][6][2][4][w]",null);
$form->addElement("hidden","permit[f][6][2][5][n]",null);
$form->addElement("hidden","permit[f][6][2][5][r]",null);
$form->addElement("hidden","permit[f][6][2][5][w]",null);
$form->addElement("hidden","permit[f][6][3][0][n]",null);
$form->addElement("hidden","permit[f][6][3][0][r]",null);
$form->addElement("hidden","permit[f][6][3][0][w]",null);
$form->addElement("hidden","permit[f][6][3][1][n]",null);
$form->addElement("hidden","permit[f][6][3][1][r]",null);
$form->addElement("hidden","permit[f][6][3][1][w]",null);
$form->addElement("hidden","permit[f][6][3][2][n]",null);
$form->addElement("hidden","permit[f][6][3][2][r]",null);
$form->addElement("hidden","permit[f][6][3][2][w]",null);
$form->addElement("hidden","permit[f][6][3][3][n]",null);
$form->addElement("hidden","permit[f][6][3][3][r]",null);
$form->addElement("hidden","permit[f][6][3][3][w]",null);
$form->addElement("hidden","permit[f][6][4][0][n]",null);
$form->addElement("hidden","permit[f][6][4][0][r]",null);
$form->addElement("hidden","permit[f][6][4][0][w]",null);
$form->addElement("hidden","permit[f][6][4][1][n]",null);
$form->addElement("hidden","permit[f][6][4][1][r]",null);
$form->addElement("hidden","permit[f][6][4][1][w]",null);
$form->addElement("hidden","permit[f][6][4][2][n]",null);
$form->addElement("hidden","permit[f][6][4][2][r]",null);
$form->addElement("hidden","permit[f][6][4][2][w]",null);
$form->addElement("hidden","permit[f][6][4][3][n]",null);
$form->addElement("hidden","permit[f][6][4][3][r]",null);
$form->addElement("hidden","permit[f][6][4][3][w]",null);
$form->addElement("hidden","permit[f][6][4][4][n]",null);
$form->addElement("hidden","permit[f][6][4][4][r]",null);
$form->addElement("hidden","permit[f][6][4][4][w]",null);
$form->addElement("hidden","permit[f][6][4][5][n]",null);
$form->addElement("hidden","permit[f][6][4][5][r]",null);
$form->addElement("hidden","permit[f][6][4][5][w]",null);
$form->addElement("hidden","permit[f][6][5][0][n]",null);
$form->addElement("hidden","permit[f][6][5][0][r]",null);
$form->addElement("hidden","permit[f][6][5][0][w]",null);
$form->addElement("hidden","permit[f][6][5][1][n]",null);
$form->addElement("hidden","permit[f][6][5][1][r]",null);
$form->addElement("hidden","permit[f][6][5][1][w]",null);
$form->addElement("hidden","permit[f][6][5][2][n]",null);
$form->addElement("hidden","permit[f][6][5][2][r]",null);
$form->addElement("hidden","permit[f][6][5][2][w]",null);
$form->addElement("hidden","permit[f][6][5][3][n]",null);
$form->addElement("hidden","permit[f][6][5][3][r]",null);
$form->addElement("hidden","permit[f][6][5][3][w]",null);
$form->addElement("hidden","permit[f][6][5][4][n]",null);
$form->addElement("hidden","permit[f][6][5][4][r]",null);
$form->addElement("hidden","permit[f][6][5][4][w]",null);
$form->addElement("hidden","permit[f][6][5][5][n]",null);
$form->addElement("hidden","permit[f][6][5][5][r]",null);
$form->addElement("hidden","permit[f][6][5][5][w]",null);








/*************************/
//CSV用の前件抽出ｓｑｌ
/*************************/

$non = "×";
$read = "△";
$write = "○";
$head_sql = "
SELECT 
    t_client.client_cd1 || '-' || t_client.client_cd2 AS client_cd ,
    t_client.client_name,
    lpad(t_staff.charge_cd,4,'0') AS charge_cd,
CASE t_rank.group_kind
    WHEN '1' THEN '本部'
END AS group_kind,
CASE t_staff.staff_cd1
    WHEN null THEN null
    else t_staff.staff_cd1 || '-' || t_staff.staff_cd2
END AS staff_cd,
    t_staff.staff_name,
    t_staff.state, 
CASE del_flg
    WHEN 't' THEN '有'
    WHEN 'f' THEN '無'
END,
CASE accept_flg
    WHEN 't' THEN '有'
    WHEN 'f' THEN '無'
END,
CASE h_2_102
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_6_204
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_2_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_2_301
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_2_401
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_2_501
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_3_101
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_3_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_3_302
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_3_401
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_4_101
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_4_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_5_109
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_6_132
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_6_103
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_6_112
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_6_122
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_6_301
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_205
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_234
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_233
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_231
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_230
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_109
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_211
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_209
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_235
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_221
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_203
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_213
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_207
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_224
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_227
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_103
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_115
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_116
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_216
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_219
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_225
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_303
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_304
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_311
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_312
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_310
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_301
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_305
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_306
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE h_1_307
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
    t_client.client_cd1,
    t_client.client_cd2 
FROM t_staff LEFT JOIN t_permit ON t_permit.staff_id = t_staff.staff_id 
INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id 
INNER JOIN t_client ON t_client.client_id = t_attach.shop_id 
INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd 
WHERE t_rank.group_kind = '1' ";
$head_sql2 = " ORDER BY client_cd1,client_cd2,charge_cd 
;";
$fc_sql = "
SELECT 
    t_client.client_cd1 || '-' || t_client.client_cd2 AS client_cd,
    t_client.client_name,
    lpad(t_staff.charge_cd,4,'0') AS charge_cd,
CASE t_rank.group_kind
    WHEN '2' THEN '直営'
    WHEN '3' THEN 'FC'
END AS group_kind,
CASE t_staff.staff_cd1
    WHEN null THEN null
    else t_staff.staff_cd1 || '-' || t_staff.staff_cd2
END AS staff_cd,
    t_staff.staff_name,
    t_staff.state, 
CASE del_flg
    WHEN 't' THEN '有'
    WHEN 'f' THEN '無'
END,
CASE accept_flg
    WHEN 't' THEN '有'
    WHEN 'f' THEN '無'
END,
CASE f_2_101
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_2_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_2_301
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_2_401
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_2_501
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_3_101
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_3_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_3_302
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_3_401
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_4_101
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_4_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_5_105
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_6_132
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_6_103
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_6_112
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_6_122
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_6_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_201
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_203
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_213
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_207
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_227
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_103
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_104
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_216
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_219
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_225
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_141
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_108
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_211
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_209
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_241
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_221
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_303
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_308
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_307
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_301
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_304
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_305
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_306
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_350
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_231
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_234
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_233
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_232
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
CASE f_1_229
    WHEN 'n' THEN '$non'
    WHEN 'r' THEN '$read'
    WHEN 'w' THEN '$write'
END,
    t_client.client_cd1,
    t_client.client_cd2 
FROM t_staff LEFT JOIN t_permit ON t_permit.staff_id = t_staff.staff_id 
INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id 
INNER JOIN t_client ON t_client.client_id = t_attach.shop_id 
INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd 
WHERE (t_rank.group_kind = '2' OR t_rank.group_kind = '3' ) ";
$fc_sql2 = " order by client_cd1,client_cd2,charge_cd 
;";

$head1 = array("本部",
        );

$head2 = array("スタッフ情報","","","","","","","","",
                "売上管理","","","","","",
                "仕入管理","","","",
                "在庫管理","",
                "更新",
                "データ出力","","","","",
                "マスタ・設定",
        );
$head3 = array("ショップコード",
                "ショップ名",
                "担当者コード",
                "スタッフ種別",
                "ネットワーク証ID",
                "スタッフ名",
                "在職識別",
                "削除",
                "承認",
                "受注取引","月例精算","売上取引","請求管理","入金管理","実績管理",
                "発注取引","仕入取引","支払管理","実績管理",
                "在庫取引","棚卸管理",
                "更新管理",
                "統計情報","売上推移","ABC分析","仕入推移","CSV出力",
                "本部管理マスタ","","","","",
                "一部共有マスタ","","","","",
                "個別マスタ","","","","","","","","","","","",
                "帳簿設定","","","","",
                "システム設定"
        );
$head4 = array("","","","","","","","","","","","","","","","","","","","","","","","","","","",
                "業種",
                "業態",
                "施設",
                "サービス",
                "構成品",
                "スタッフ",
                "Ｍ区分",
                "管理区分",
                "商品分類",
                "商品",
                "部署",
                "倉庫",
                "地区",
                "銀行",
                "製造品",
                "FC区分",
                "FC",
                "得意先",
                "契約",
                "仕入先",
                "直送先",
                "運送業者",
                "発注書コメント",
                "注文書フォーマット",
                "売上伝票",
                "納品書",
                "請求書",
                "本部プロフィール",
                "買掛残高初期設定",
                "売掛残高初期設定",
                "請求残高初期設定",
        );
$fc1 = array("FC",
        );
$fc2 = array("スタッフ情報","","","","","","","","",
                "売上管理","","","","",
                "仕入管理","","","",
                "在庫管理","",
                "更新",
                "データ出力","","","","",
                "マスタ・設定",
        );
$fc3 = array("ショップコード",
                "ショップ名",
                "担当者コード",
                "スタッフ種別",
                "ネットワーク証ID",
                "スタッフ名",
                "在職識別",
                "削除",
                "承認",
                "予定取引","売上取引","請求管理","入金管理","実績管理",
                "発注取引","仕入取引","支払管理","実績管理",
                "在庫取引","棚卸管理",
                "更新管理",
                "統計情報","売上推移","ABC分析","仕入推移","CSV出力",
                "個別マスタ","","","","","","","","","","",
                "一部共有マスタ","","","","",
                "帳票設定","","",
                "システム設定","","","","",
                "本部管理マスタ",
        );
  $fc4 = array("","","","","","","","","","","","","","","","","","","","","","","","","","",
                "部署",
                "倉庫",
                "地区",
                "銀行",
                "コース",
                "得意先",
                "契約",
                "仕入先",
                "直送先",
                "運送業者",
                "レンタルTOレンタル",
                "スタッフ",
                "Ｍ区分",
                "管理区分",
                "商品分類",
                "商品",
                "発注書コメント",
                "売上伝票",
                "請求書",
                "自社プロフィール",
                "買掛残高初期設定",
                "売掛残高初期設定",
                "請求残高初期設定",
                "休日設定",
                "業種",
                "業態",
                "施設",
                "サービス",
                "構成品",
        );
//表示ボタン押下
if($_POST['show_btn'] != null){
//print_array($_POST);
    $client_cd1 = $_POST['form_client_cd']['cd1'];
    $client_cd2 = $_POST['form_client_cd']['cd2'];
    $client_name = $_POST['form_client_name'];
    $charge_cd = $_POST['form_charge_cd']['cd1'];
    $staff_name = $_POST['form_staff_name'];
    $del_compe = $_POST['form_del_compe']; 
    $accept_compe = $_POST['form_accept_compe'];
    $compe_invest = $_POST['form_compe_invest'];
    $staff_state = $_POST['form_staff_state'];

    $sql = "";
    if($client_cd1 != null){
        $sql .= " AND client_cd1 LIKE '%$client_cd1%' ";
    }

    if($client_cd2 != null){
        $sql .= " AND client_cd2 LIKE '%$client_cd2%' ";
    }

    if($client_name != null){
        $sql .= "AND (t_client.client_name LIKE '%$client_name%' 
                        OR t_client.client_read LIKE '%$client_name%' 
                        OR t_client.client_cname LIKE '%$client_name%') ";
    }

    if($charge_cd != null){
        $sql .= " AND t_staff.charge_cd LIKE '%$charge_cd%' ";
    }

    if($staff_name != null){
        $sql .= " AND t_staff.staff_name LIKE '%$staff_name%' ";
    }

    if($del_compe == '2'){
        $sql .= " AND del_flg = 't' ";
    }elseif($del_compe == '3'){
        $sql .= " AND del_flg = 'f' ";
    }

    if($accept_compe == '2'){
        $sql .= " AND accept_flg = 't' ";
    }elseif($accept_compe == '3'){
        $sql .= " AND accept_flg = 'f' ";
    }

    if($compe_invest == '2'){
        $sql .= " AND del_flg is not null ";
    }elseif($compe_invest == '3'){
        $sql .= " AND del_flg is null ";
    }

    if($staff_state != '全て'){
        $sql .= " AND t_staff.state = '$staff_state'";
    }

    $head_res = Db_Query($db_con,$head_sql.$sql.$head_sql2);
    $fc_res = Db_Query($db_con,$fc_sql.$sql.$fc_sql2);
    if(pg_num_rows($head_res) > 0){
        for($i=0;$i<pg_num_rows($head_res);$i++){
            $head_staff[] = pg_fetch_array($head_res,$i,PGSQL_NUM);
        }
    }
    if(pg_num_rows($fc_res) > 0){
        for($i=0;$i<pg_num_rows($fc_res);$i++){
            $fc_staff[] = pg_fetch_array($fc_res,$i,PGSQL_NUM);
        }
    }
    for($i=0;$i<count($head_staff);$i++){
        for($j=0;$j<7;$j++){
            $head_staff[$i][$j] = htmlspecialchars($head_staff[$i][$j]);
        }
    }
    for($i=0;$i<count($fc_staff);$i++){
        for($j=0;$j<7;$j++){
            $fc_staff[$i][$j] = htmlspecialchars($fc_staff[$i][$j]);
        }
    }

$html =  "<table border = 1>";
$html .= "<tr><td colspan=59 bgcolor=white>".implode("</td><td>",$head1)."</td></tr>";
$html .= "<tr><td></td><td>".implode("</td><td>",$head2)."</td></tr>";
$html .= "<tr><td>No.</td><td>".implode("</td><td>",$head3)."</td></tr>";
$html .= "<tr><td></td><td>".implode("</td><td>",$head4)."</td></tr>";
$num = 0;
    for($i=0;$i<count($head_staff);$i++){
        array_pop($head_staff[$i]);
        array_pop($head_staff[$i]);
        $num++;
        $html .= "<tr><td>$num</td><td>".implode("</td><td>",$head_staff[$i])."</td></tr>";
    }
$html .= "</table>";

$html .= "<br><table border = 1>";
$html .=  "<tr><td colspan=56 bgcolor=white>".implode("</td><td>",$fc1)."</td></tr>";
$html .= "<tr><td></td><td>".implode("</td><td>",$fc2)."</td></tr>";
$html .= "<tr><td>No.</td><td>".implode("</td><td>",$fc3)."</td></tr>";
$html .= "<tr><td></td><td>".implode("</td><td>",$fc4)."</td></tr>";
    for($i=0;$i<count($fc_staff);$i++){
        array_pop($fc_staff[$i]);
        array_pop($fc_staff[$i]);
        $num++;
        $html .= "<tr><td>$num</td><td>".implode("</td><td>",$fc_staff[$i])."</td></tr>";
    }
$html .= "</table>";
$num = "全 ".$num." 件";

}
//設定済み？
if($_POST['form_set_button'] != null){

}
if($_POST != null){
//print_array($_POST);
}
//csv出力ボタン押下
if($_POST['csv_btn'] != null){
        $client_cd1 = $_POST['form_client_cd']['cd1'];
        $client_cd2 = $_POST['form_client_cd']['cd2'];
        $client_name = $_POST['form_client_name'];
        $charge_cd = $_POST['form_charge_cd']['cd1'];
        $staff_name = $_POST['form_staff_name'];
        $del_compe = $_POST['form_del_compe'];
        $accept_compe = $_POST['form_accept_compe'];
        $compe_invest = $_POST['form_compe_invest'];
        $staff_state = $_POST['form_staff_state'];

        $sql = "";
        if($client_cd1 != null){
            $sql .= " AND client_cd1 LIKE '%$client_cd1%' ";
        }

        if($client_cd2 != null){
            $sql .= " AND client_cd2 LIKE '%$client_cd2%' ";
        }

        if($client_name != null){
            $sql .= "AND (t_client.client_name LIKE '%$client_name%'
                        OR t_client.client_read LIKE '%$client_name%'
                        OR t_client.client_cname LIKE '%$client_name%') ";
        }

        if($charge_cd != null){
            $sql .= " AND t_staff.charge_cd LIKE '%$charge_cd%' ";
        }

        if($staff_name != null){
            $sql .= " AND t_staff.staff_name LIKE '%$staff_name%' ";
        }

        if($del_compe == '2'){
            $sql .= " AND del_flg = 't' ";
        }elseif($del_compe == '3'){
            $sql .= " AND del_flg = 'f' ";
        }

        if($accept_compe == '2'){
            $sql .= " AND accept_flg = 't' ";
        }elseif($accept_compe == '3'){
            $sql .= " AND accept_flg = 'f' ";
        }

        if($compe_invest == '2'){
            $sql .= " AND del_flg is not null ";
        }elseif($compe_invest == '3'){
            $sql .= " AND del_flg is null ";
        }

        if($staff_state != '全て'){
            $sql .= " AND t_staff.state = '$staff_state'";
        }
    
        $head_res = Db_Query($db_con,$head_sql.$sql.$head_sql2);
        $fc_res = Db_Query($db_con,$fc_sql.$sql.$fc_sql2);

    $count = pg_num_rows($head_res);
    $fccount = pg_num_rows($fc_res);

    $staff[] = $head1;
    $staff[] = $head2;
    $staff[] = $head3;
    $staff[] = $head4;

    $fcstaff[] = $fc1;
    $fcstaff[] = $fc2;
    $fcstaff[] = $fc3;
    $fcstaff[] = $fc4;

    for($i =0 ;$i < $count ;$i++){
        $staff[] = @pg_fetch_array($head_res,$i,PGSQL_NUM);
    }
    for($i=0;$i<$fccount;$i++){
        $fcstaff[] = @pg_fetch_array($fc_res,$i,PGSQL_NUM);
    }
    //csv作成？
    $csv_file_name = $page_title.date("Ymd").".csv";
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_head = Change_Csv($staff);
    $csv_fc = Change_Csv($fcstaff);


    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_head;
    print $csv_fc;
    exit;


}
function Change_Csv($ary){
    for($i=0;$i<count($ary);$i++){
        if($i > 3){
            array_pop($ary[$i]);
            array_pop($ary[$i]);
        }
        for($j=0;$j<count($ary[$i]);$j++){
            //エンコード
            $ary[$i][$j] = mb_convert_encoding($ary[$i][$j], "SJIS", "EUC-JP");
            //"を""に
            $ary[$i][$j] = str_replace("\"", "\"\"", $ary[$i][$j]);
            //""を""に
            $ary[$i][$j] = mb_ereg_replace("\"", "\"\"", $ary[$i][$j]);
            //最初と最後に"をつける
            $ary[$i][$j] = "\"".$ary[$i][$j]."\"";
        }
        //カンマ区切りで結合
        $data_csv[$i] = implode(",", $ary[$i]);
        
    }
    //改行
    $data_csv = implode("\n",$data_csv);
    $data_csv = $data_csv."\n";
    return $data_csv;
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
$page_menu = Create_Menu_h('buy','3');

/****************************/
//画面ヘッダー作成
/****************************/
//$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
//$page_title .= "　".$form->_elements[$form->_elementIndex[pay_button]]->toHtml();
//$page_header = Create_Header($page_title);



// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());
//その他の変数をassign
$smarty->assign('var',array(
        'html_header'               => "$html_header",
    'html'                      => "$html",
    'num'                   => "$num",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
));


//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
