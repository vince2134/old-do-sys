<?php
$page_title = "スタッフ権限一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//DB接続
$db_con = Db_Connect();


/*****************************/
// 権限関連処理
/*****************************/
// 権限チェック
//$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


//print_array($_POST);
//print_array($_GET);
//print_array($_SESSION);
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
//    "form_screen_compe" => "3",
//    "form_compe_kind" => "1",
);
$form->setDefaults($def_data);


/*************************/
//hidden作成
/*************************/
$form->addElement("hidden","set_flg",null);

$form->addElement("hidden","permit[h][1][1][0][r]",null);
$form->addElement("hidden","permit[h][1][1][0][w]",null);
$form->addElement("hidden","permit[h][1][2][0][r]",null);
$form->addElement("hidden","permit[h][1][2][0][w]",null);
$form->addElement("hidden","permit[h][1][3][0][r]",null);
$form->addElement("hidden","permit[h][1][3][0][w]",null);
$form->addElement("hidden","permit[h][1][4][0][r]",null);
$form->addElement("hidden","permit[h][1][4][0][w]",null);
$form->addElement("hidden","permit[h][1][5][0][r]",null);
$form->addElement("hidden","permit[h][1][5][0][w]",null);
$form->addElement("hidden","permit[h][1][6][0][r]",null);
$form->addElement("hidden","permit[h][1][6][0][w]",null);
$form->addElement("hidden","permit[h][2][1][0][r]",null);
$form->addElement("hidden","permit[h][2][1][0][w]",null);
$form->addElement("hidden","permit[h][2][2][0][r]",null);
$form->addElement("hidden","permit[h][2][2][0][w]",null);
$form->addElement("hidden","permit[h][2][3][0][r]",null);
$form->addElement("hidden","permit[h][2][3][0][w]",null);
$form->addElement("hidden","permit[h][2][4][0][r]",null);
$form->addElement("hidden","permit[h][2][4][0][w]",null);
$form->addElement("hidden","permit[h][3][1][0][r]",null);
$form->addElement("hidden","permit[h][3][1][0][w]",null);
$form->addElement("hidden","permit[h][3][2][0][r]",null);
$form->addElement("hidden","permit[h][3][2][0][w]",null);
$form->addElement("hidden","permit[h][4][1][0][r]",null);
$form->addElement("hidden","permit[h][4][1][0][w]",null);
$form->addElement("hidden","permit[h][5][1][0][r]",null);
$form->addElement("hidden","permit[h][5][1][0][w]",null);
$form->addElement("hidden","permit[h][5][2][0][r]",null);
$form->addElement("hidden","permit[h][5][2][0][w]",null);
$form->addElement("hidden","permit[h][5][3][0][r]",null);
$form->addElement("hidden","permit[h][5][3][0][w]",null);
$form->addElement("hidden","permit[h][5][4][0][r]",null);
$form->addElement("hidden","permit[h][5][4][0][w]",null);
$form->addElement("hidden","permit[h][5][5][0][r]",null);
$form->addElement("hidden","permit[h][5][5][0][w]",null);
$form->addElement("hidden","permit[h][6][1][0][r]",null);
$form->addElement("hidden","permit[h][6][1][0][w]",null);
$form->addElement("hidden","permit[h][6][1][1][r]",null);
$form->addElement("hidden","permit[h][6][1][1][w]",null);
$form->addElement("hidden","permit[h][6][1][2][r]",null);
$form->addElement("hidden","permit[h][6][1][2][w]",null);
$form->addElement("hidden","permit[h][6][1][3][r]",null);
$form->addElement("hidden","permit[h][6][1][3][w]",null);
$form->addElement("hidden","permit[h][6][1][4][r]",null);
$form->addElement("hidden","permit[h][6][1][4][w]",null);
$form->addElement("hidden","permit[h][6][1][5][r]",null);
$form->addElement("hidden","permit[h][6][1][5][w]",null);
$form->addElement("hidden","permit[h][6][2][0][r]",null);
$form->addElement("hidden","permit[h][6][2][0][w]",null);
$form->addElement("hidden","permit[h][6][2][1][r]",null);
$form->addElement("hidden","permit[h][6][2][1][w]",null);
$form->addElement("hidden","permit[h][6][2][2][r]",null);
$form->addElement("hidden","permit[h][6][2][2][w]",null);
$form->addElement("hidden","permit[h][6][2][3][r]",null);
$form->addElement("hidden","permit[h][6][2][3][w]",null);
$form->addElement("hidden","permit[h][6][2][4][r]",null);
$form->addElement("hidden","permit[h][6][2][4][w]",null);
$form->addElement("hidden","permit[h][6][2][5][r]",null);
$form->addElement("hidden","permit[h][6][2][5][w]",null);
$form->addElement("hidden","permit[h][6][3][0][r]",null);
$form->addElement("hidden","permit[h][6][3][0][w]",null);
$form->addElement("hidden","permit[h][6][3][1][r]",null);
$form->addElement("hidden","permit[h][6][3][1][w]",null);
$form->addElement("hidden","permit[h][6][3][2][r]",null);
$form->addElement("hidden","permit[h][6][3][2][w]",null);
$form->addElement("hidden","permit[h][6][3][3][r]",null);
$form->addElement("hidden","permit[h][6][3][3][w]",null);
$form->addElement("hidden","permit[h][6][3][4][r]",null);
$form->addElement("hidden","permit[h][6][3][4][w]",null);
$form->addElement("hidden","permit[h][6][3][5][r]",null);
$form->addElement("hidden","permit[h][6][3][5][w]",null);
$form->addElement("hidden","permit[h][6][3][6][r]",null);
$form->addElement("hidden","permit[h][6][3][6][w]",null);
$form->addElement("hidden","permit[h][6][3][7][r]",null);
$form->addElement("hidden","permit[h][6][3][7][w]",null);
$form->addElement("hidden","permit[h][6][3][8][r]",null);
$form->addElement("hidden","permit[h][6][3][8][w]",null);
$form->addElement("hidden","permit[h][6][3][9][r]",null);
$form->addElement("hidden","permit[h][6][3][9][w]",null);
$form->addElement("hidden","permit[h][6][3][10][r]",null);
$form->addElement("hidden","permit[h][6][3][10][w]",null);
$form->addElement("hidden","permit[h][6][3][11][r]",null);
$form->addElement("hidden","permit[h][6][3][11][w]",null);
$form->addElement("hidden","permit[h][6][3][12][r]",null);
$form->addElement("hidden","permit[h][6][3][12][w]",null);
$form->addElement("hidden","permit[h][6][4][0][r]",null);
$form->addElement("hidden","permit[h][6][4][0][w]",null);
$form->addElement("hidden","permit[h][6][4][1][r]",null);
$form->addElement("hidden","permit[h][6][4][1][w]",null);
$form->addElement("hidden","permit[h][6][4][2][r]",null);
$form->addElement("hidden","permit[h][6][4][2][w]",null);
$form->addElement("hidden","permit[h][6][4][3][r]",null);
$form->addElement("hidden","permit[h][6][4][3][w]",null);
$form->addElement("hidden","permit[h][6][4][4][r]",null);
$form->addElement("hidden","permit[h][6][4][4][w]",null);
$form->addElement("hidden","permit[h][6][4][5][r]",null);
$form->addElement("hidden","permit[h][6][4][5][w]",null);
$form->addElement("hidden","permit[h][6][5][0][r]",null);
$form->addElement("hidden","permit[h][6][5][0][w]",null);
$form->addElement("hidden","permit[h][6][5][1][r]",null);
$form->addElement("hidden","permit[h][6][5][1][w]",null);
$form->addElement("hidden","permit[h][6][5][2][r]",null);
$form->addElement("hidden","permit[h][6][5][2][w]",null);
$form->addElement("hidden","permit[h][6][5][3][r]",null);
$form->addElement("hidden","permit[h][6][5][3][w]",null);
$form->addElement("hidden","permit[h][6][5][4][r]",null);
$form->addElement("hidden","permit[h][6][5][4][w]",null);

$form->addElement("hidden","permit[f][1][1][0][r]",null);
$form->addElement("hidden","permit[f][1][1][0][w]",null);
$form->addElement("hidden","permit[f][1][2][0][r]",null);
$form->addElement("hidden","permit[f][1][2][0][w]",null);
$form->addElement("hidden","permit[f][1][3][0][r]",null);
$form->addElement("hidden","permit[f][1][3][0][w]",null);
$form->addElement("hidden","permit[f][1][4][0][r]",null);
$form->addElement("hidden","permit[f][1][4][0][w]",null);
$form->addElement("hidden","permit[f][1][5][0][r]",null);
$form->addElement("hidden","permit[f][1][5][0][w]",null);
$form->addElement("hidden","permit[f][2][1][0][r]",null);
$form->addElement("hidden","permit[f][2][1][0][w]",null);
$form->addElement("hidden","permit[f][2][2][0][r]",null);
$form->addElement("hidden","permit[f][2][2][0][w]",null);
$form->addElement("hidden","permit[f][2][3][0][r]",null);
$form->addElement("hidden","permit[f][2][3][0][w]",null);
$form->addElement("hidden","permit[f][2][4][0][r]",null);
$form->addElement("hidden","permit[f][2][4][0][w]",null);
$form->addElement("hidden","permit[f][3][1][0][r]",null);
$form->addElement("hidden","permit[f][3][1][0][w]",null);
$form->addElement("hidden","permit[f][3][2][0][r]",null);
$form->addElement("hidden","permit[f][3][2][0][w]",null);
$form->addElement("hidden","permit[f][4][1][0][r]",null);
$form->addElement("hidden","permit[f][4][1][0][w]",null);
$form->addElement("hidden","permit[f][5][1][0][r]",null);
$form->addElement("hidden","permit[f][5][1][0][w]",null);
$form->addElement("hidden","permit[f][5][2][0][r]",null);
$form->addElement("hidden","permit[f][5][2][0][w]",null);
$form->addElement("hidden","permit[f][5][3][0][r]",null);
$form->addElement("hidden","permit[f][5][3][0][w]",null);
$form->addElement("hidden","permit[f][5][4][0][r]",null);
$form->addElement("hidden","permit[f][5][4][0][w]",null);
$form->addElement("hidden","permit[f][5][5][0][r]",null);
$form->addElement("hidden","permit[f][5][5][0][w]",null);
$form->addElement("hidden","permit[f][6][1][0][r]",null);
$form->addElement("hidden","permit[f][6][1][0][w]",null);
$form->addElement("hidden","permit[f][6][1][1][r]",null);
$form->addElement("hidden","permit[f][6][1][1][w]",null);
$form->addElement("hidden","permit[f][6][1][2][r]",null);
$form->addElement("hidden","permit[f][6][1][2][w]",null);
$form->addElement("hidden","permit[f][6][1][3][r]",null);
$form->addElement("hidden","permit[f][6][1][3][w]",null);
$form->addElement("hidden","permit[f][6][1][4][r]",null);
$form->addElement("hidden","permit[f][6][1][4][w]",null);
$form->addElement("hidden","permit[f][6][1][5][r]",null);
$form->addElement("hidden","permit[f][6][1][5][w]",null);
$form->addElement("hidden","permit[f][6][1][6][r]",null);
$form->addElement("hidden","permit[f][6][1][6][w]",null);
$form->addElement("hidden","permit[f][6][1][7][r]",null);
$form->addElement("hidden","permit[f][6][1][7][w]",null);
$form->addElement("hidden","permit[f][6][1][8][r]",null);
$form->addElement("hidden","permit[f][6][1][8][w]",null);
$form->addElement("hidden","permit[f][6][1][9][r]",null);
$form->addElement("hidden","permit[f][6][1][9][w]",null);
$form->addElement("hidden","permit[f][6][1][10][r]",null);
$form->addElement("hidden","permit[f][6][1][10][w]",null);
$form->addElement("hidden","permit[f][6][1][11][r]",null);
$form->addElement("hidden","permit[f][6][1][11][w]",null);
$form->addElement("hidden","permit[f][6][1][12][r]",null);
$form->addElement("hidden","permit[f][6][1][12][w]",null);
$form->addElement("hidden","permit[f][6][2][0][r]",null);
$form->addElement("hidden","permit[f][6][2][0][w]",null);
$form->addElement("hidden","permit[f][6][2][1][r]",null);
$form->addElement("hidden","permit[f][6][2][1][w]",null);
$form->addElement("hidden","permit[f][6][2][2][r]",null);
$form->addElement("hidden","permit[f][6][2][2][w]",null);
$form->addElement("hidden","permit[f][6][2][3][r]",null);
$form->addElement("hidden","permit[f][6][2][3][w]",null);
$form->addElement("hidden","permit[f][6][2][4][r]",null);
$form->addElement("hidden","permit[f][6][2][4][w]",null);
$form->addElement("hidden","permit[f][6][2][5][r]",null);
$form->addElement("hidden","permit[f][6][2][5][w]",null);
$form->addElement("hidden","permit[f][6][3][0][r]",null);
$form->addElement("hidden","permit[f][6][3][0][w]",null);
$form->addElement("hidden","permit[f][6][3][1][r]",null);
$form->addElement("hidden","permit[f][6][3][1][w]",null);
$form->addElement("hidden","permit[f][6][3][2][r]",null);
$form->addElement("hidden","permit[f][6][3][2][w]",null);
$form->addElement("hidden","permit[f][6][3][3][r]",null);
$form->addElement("hidden","permit[f][6][3][3][w]",null);
$form->addElement("hidden","permit[f][6][4][0][r]",null);
$form->addElement("hidden","permit[f][6][4][0][w]",null);
$form->addElement("hidden","permit[f][6][4][1][r]",null);
$form->addElement("hidden","permit[f][6][4][1][w]",null);
$form->addElement("hidden","permit[f][6][4][2][r]",null);
$form->addElement("hidden","permit[f][6][4][2][w]",null);
$form->addElement("hidden","permit[f][6][4][3][r]",null);
$form->addElement("hidden","permit[f][6][4][3][w]",null);
$form->addElement("hidden","permit[f][6][4][4][r]",null);
$form->addElement("hidden","permit[f][6][4][4][w]",null);
$form->addElement("hidden","permit[f][6][4][5][r]",null);
$form->addElement("hidden","permit[f][6][4][5][w]",null);
$form->addElement("hidden","permit[f][6][5][0][r]",null);
$form->addElement("hidden","permit[f][6][5][0][w]",null);
$form->addElement("hidden","permit[f][6][5][1][r]",null);
$form->addElement("hidden","permit[f][6][5][1][w]",null);
$form->addElement("hidden","permit[f][6][5][2][r]",null);
$form->addElement("hidden","permit[f][6][5][2][w]",null);
$form->addElement("hidden","permit[f][6][5][3][r]",null);
$form->addElement("hidden","permit[f][6][5][3][w]",null);
$form->addElement("hidden","permit[f][6][5][4][r]",null);
$form->addElement("hidden","permit[f][6][5][4][w]",null);
$form->addElement("hidden","permit[f][6][5][5][r]",null);
$form->addElement("hidden","permit[f][6][5][5][w]",null);

/****************************/
//フォーム作成（固定）
/****************************/
//CSV出力ボタン
$form->addElement("submit", "csv_btn", "CSV出力");
//," onClick=\"javascript:Button_Submit('post_csv', '#', 'post_csv');\"");
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
$form->addElement("text","form_charge_cd","テキストフォーム","size=\"5\" maxLength=\"4\" style=\"$g_form_style\"  ".$g_form_option."\"");

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

//link
$form->addElement("link","open_win","リンク","#","画面","onClick=\"open_sub();\"");
if($_POST['set_flg'] == true){$m_permit = $_POST['permit'];}
$js = "
function open_sub(){
    if(document.dateForm[\"set_flg\"].value == 'true' ){
        var ary_key = new Array(1,7,5,3,2,6,6);
        var ary_key2 = new Array(1,6,6,13,6,5);
        var permit = new Array(2);
        permit[0] = new Array();
        for(var i = 1 ; i < 7 ; i++ ){
            permit[0][i] = new Array();
            for(var j = 1 ; j < ary_key[i] ; j++){
                permit[0][i][j] = new Array();
                permit[0][i][j][0] = new Array();
                var hdn = \"permit[h][\"+i+\"][\"+j+\"][0][w]\";
                permit[0][i][j][0][0] = document.dateForm.elements[hdn].value;
                var hdn = \"permit[h][\"+i+\"][\"+j+\"][0][r]\";
                permit[0][i][j][0][1] = document.dateForm.elements[hdn].value;
                if(i>5 && j > 0 ){
                    for(l = 1 ; l < ary_key2[j] ; l++){
                        permit[0][i][j][l] = new Array();
                        var hdn = \"permit[h][\"+i+\"][\"+j+\"][\"+l+\"][w]\";
                        permit[0][i][j][l][0] = document.dateForm.elements[hdn].value;
                        var hdn = \"permit[h][\"+i+\"][\"+j+\"][\"+l+\"][r]\";
                        permit[0][i][j][l][1] = document.dateForm.elements[hdn].value;
                    }
                }
            }
        }
        ary_key = new Array(1,6,5,3,2,6,6);
        ary_key2 = new Array(1,13,6,4,6,6);
        permit[1] = new Array();
        for(i = 1 ; i < 7 ; i++ ){
            permit[1][i] = new Array();
            for(j = 1 ; j < ary_key[i] ; j++){
                permit[1][i][j] = new Array();
                permit[1][i][j][0] = new Array();
                var hdn = \"permit[f][\"+i+\"][\"+j+\"][0][w]\";
                permit[1][i][j][0][0] = document.dateForm.elements[hdn].value;
                var hdn = \"permit[f][\"+i+\"][\"+j+\"][0][r]\";
                permit[1][i][j][0][1] = document.dateForm.elements[hdn].value;
                if(i>5 && j > 0 ){
                    for(l = 1 ; l < ary_key2[j] ; l++){
                        permit[1][i][j][l] = new Array();
                        var hdn = \"permit[f][\"+i+\"][\"+j+\"][\"+l+\"][w]\";
                        permit[1][i][j][l][0] = document.dateForm.elements[hdn].value;
                        var hdn = \"permit[f][\"+i+\"][\"+j+\"][\"+l+\"][r]\";
                        permit[1][i][j][l][1] = document.dateForm.elements[hdn].value;
                    }
                }
            }
        }
        var ary = showModalDialog('kaku-m_sub.php?'+permit,null,'dialogHeight:1000px;dialogWidth:600px');
    }else{
        var ary = showModalDialog('kaku-m_sub.php',null,'dialogHeight:1000px;dialogWidth:600px');
    }
if(ary != null){
    ary_key = new Array(1,7,5,3,2,6,6);
    ary_key2 = new Array(1,6,6,13,6,5);
    for(i = 1 ; i < 7 ; i++ ){
        for(j = 1 ; j < ary_key[i] ; j++){
//            var hdn = \"permit[h][\"+i+\"][\"+j+\"][0][w]\";
//            document.dateForm.elements[hdn].value = ary[0][i][j][0][0];
//            var hdn = \"permit[h][\"+i+\"][\"+j+\"][0][r]\";
//            document.dateForm.elements[hdn].value = ary[0][i][j][0][1];
            if(i==6 && j > 0 ){
                for(l = 1 ; l < ary_key2[j] ; l++){
                    var hdn = \"permit[h][\"+i+\"][\"+j+\"][\"+l+\"][w]\";
                    document.dateForm.elements[hdn].value = ary[0][i][j][l][0];
                    var hdn = \"permit[h][\"+i+\"][\"+j+\"][\"+l+\"][r]\";
                    document.dateForm.elements[hdn].value = ary[0][i][j][l][1];
                }
            }else{
                var hdn = \"permit[h][\"+i+\"][\"+j+\"][0][w]\";
                document.dateForm.elements[hdn].value = ary[0][i][j][0][0];
                var hdn = \"permit[h][\"+i+\"][\"+j+\"][0][r]\";
                document.dateForm.elements[hdn].value = ary[0][i][j][0][1];
            }
        }
    }

    ary_key = new Array(1,6,5,3,2,6,6);
    ary_key2 = new Array(1,13,6,4,6,6);
    for(i = 1 ; i < 7 ; i++ ){
        for(j = 1 ; j < ary_key[i] ; j++){
//            var hdn = \"permit[f][\"+i+\"][\"+j+\"][0][w]\";
//            document.dateForm.elements[hdn].value = ary[1][i][j][0][0];
//            var hdn = \"permit[f][\"+i+\"][\"+j+\"][0][r]\";
//            document.dateForm.elements[hdn].value = ary[1][i][j][0][1];
            if(i==6 && j > 0 ){
                for(l = 1 ; l < ary_key2[j] ; l++){
                    var hdn = \"permit[f][\"+i+\"][\"+j+\"][\"+l+\"][w]\";
                    document.dateForm.elements[hdn].value = ary[1][i][j][l][0];
                    var hdn = \"permit[f][\"+i+\"][\"+j+\"][\"+l+\"][r]\";
                    document.dateForm.elements[hdn].value = ary[1][i][j][l][1];
                }
            }else{   
            var hdn = \"permit[f][\"+i+\"][\"+j+\"][0][w]\";
            document.dateForm.elements[hdn].value = ary[1][i][j][0][0];
            var hdn = \"permit[f][\"+i+\"][\"+j+\"][0][r]\";
            document.dateForm.elements[hdn].value = ary[1][i][j][0][1];
            }
        }
    }
document.dateForm[\"set_flg\"].value = true;
document.dateForm.submit();
}

//document.dateForm.submit();



}
";



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
CASE f_1_113
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
                "一部共有マスタ","","","","","",
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
                "グループ",
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
    $sqlh = Search_sql("h");
    $sqlf = Search_sql("f");
    $head_res = Db_Query($db_con,$head_sql.$sqlh.$head_sql2);
    $fc_res = Db_Query($db_con,$fc_sql.$sqlf.$fc_sql2);
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

$html =  "<table border = 1 class=\"List_Table\">";
$html .= "<tr  style=\"font-weight: bold;\"><td colspan=56 class=\"Title_Purple\">".implode("</td><td>",$head1)."</td></tr>";
$html .= "<tr align=center style=\"font-weight: bold;\"><td colspan=7 class=\"Title_Purple\">スタッフ情報</td>";
$html .= "<td colspan=6 class=\"Title_Purple\">売上管理</td>";
$html .= "<td colspan=4 class=\"Title_Purple\">仕入管理</td>";
$html .= "<td colspan=2 class=\"Title_Purple\">在庫管理</td>";
$html .= "<td colspan=1 class=\"Title_Purple\">更新</td>";
$html .= "<td colspan=5 class=\"Title_Purple\">データ出力</td>";
$html .= "<td colspan=31 class=\"Title_Purple\">マスタ・設定</td>";
$html .= "</tr>";
$html .= "<tr align=center style=\"font-weight: bold;\"><td rowspan=2 class=\"Title_Purple\">No.</td>";
$html .= "<td rowspan=2  class=\"Title_Purple\">ショップコード<br>ショップ名</td>";
for($i=2;$i<27;$i++){
    if($i==4){
        $html .= "<td rowspan=2 class=\"Title_Purple\">".$head3[$i]."<br>".$head3[$i+1]."</td>";
        $i++;
    }elseif($i==3){
    }else{
        $html .= "<td rowspan=2 class=\"Title_Purple\">".$head3[$i]."</td>";
    }
}
$html .= "<td class=\"Title_Purple\" colspan=5>本部管理マスタ</td>";
$html .= "<td class=\"Title_Purple\" colspan=5>一部共有マスタ</td>";
$html .= "<td class=\"Title_Purple\" colspan=12>個別マスタ</td>";
$html .= "<td class=\"Title_Purple\" colspan=5>帳票設定</td>";
$html .= "<td class=\"Title_Purple\" colspan=4>システム設定</td>";
$html .= "</tr><tr align=center style=\"font-weight: bold;\">";
for($i=0;$i<count($head4);$i++){
    if($head4[$i]!=""){
        if(mb_strlen($head4[$i]) == 2){
            $html .= "<td class=\"Title_Purple\">".mb_substr($head4[$i],0,1)."　".mb_substr($head4[$i],1,1)."</td>";
        }else{
            $html .= "<td class=\"Title_Purple\">".$head4[$i]."</td>";
        }
    }
}
$html .= "</tr>";
$num = 0;
    for($i=0;$i<count($head_staff);$i++){
        array_pop($head_staff[$i]);
        array_pop($head_staff[$i]);
        $num++;
        $html .= "<tr class=\"Result1\"><td>$num</td>";
        for($j=0;$j<count($head_staff[$i]);$j++){
            if($j==0 && ($i==0 || $head_staff[$i-1][0] != $head_staff[$i][0])){
                $html .= "<td>".$head_staff[$i][0]."<br>".$head_staff[$i][1]."</td>";
                $j++;
            }elseif($j==0 && $head_staff[$i-1][0] == $head_staff[$i][0]){
                $html .= "<td></td>";
                $j++;
            }elseif($j==3){
            }elseif($j==4){
                $html .= "<td>".$head_staff[$i][$j]."<br>".$head_staff[$i][$j+1]."</td>";
                $j++;
            }elseif($j>6){
                $html .= "<td align=center>".$head_staff[$i][$j]."</td>";
            }else{
                $html .= "<td>".$head_staff[$i][$j]."</td>";
            }
        }
        $html .= "</tr>";
    }
$html .= "</table><br><br>";
$num = "本部　全 <span style=\"font-weight: bold;\">".$num."</span> 件";
$html_f = "";
$html_f .= "<table border = 1 class=\"List_Table\">";
$html_f .= "<tr style=\"font-weight: bold;\"><td colspan=56 class=\"Title_Purple\">ＦＣ</td></tr>";
$html_f .= "<tr align=center style=\"font-weight: bold;\">";
$html_f .= "<td colspan=8 class=\"Title_Purple\">スタッフ情報</td>";
$html_f .= "<td colspan=5 class=\"Title_Purple\">売上管理</td>";
$html_f .= "<td colspan=4 class=\"Title_Purple\">仕入管理</td>";
$html_f .= "<td colspan=2 class=\"Title_Purple\">在庫管理</td>";
$html_f .= "<td colspan=1 class=\"Title_Purple\">更新</td>";
$html_f .= "<td colspan=5 class=\"Title_Purple\">データ出力</td>";
$html_f .= "<td colspan=30 class=\"Title_Purple\">マスタ・設定</td>";
$html_f .= "</tr>";
$html_f .= "<tr align=center style=\"font-weight: bold;\"><td rowspan=2 class=\"Title_Purple\">No.</td>";
$html_f .= "<td rowspan=2  class=\"Title_Purple\">ショップコード<br>ショップ名</td>";
for($i=2;$i<26;$i++){
    if($i==4){
        $html_f .= "<td rowspan=2 class=\"Title_Purple\">".$fc3[$i]."<br>".$fc3[$i+1]."</td>";
        $i++;
    }else{
        $html_f .= "<td rowspan=2 class=\"Title_Purple\">".$fc3[$i]."</td>";
    }
}
$html_f .= "<td class=\"Title_Purple\" colspan=12>個別マスタ</td>";
$html_f .= "<td class=\"Title_Purple\" colspan=5>一部共有マスタ</td>";
$html_f .= "<td class=\"Title_Purple\" colspan=3>帳票設定</td>";
$html_f .= "<td class=\"Title_Purple\" colspan=5>システム設定</td>";
$html_f .= "<td class=\"Title_Purple\" colspan=5>本部管理マスタ</td>";
$html_f .= "</tr><tr align=center style=\"font-weight: bold;\">";
for($i=0;$i<count($fc4);$i++){
    if($fc4[$i] != ""){
        if(mb_strlen($fc4[$i]) == 2){
            $html_f .= "<td class=\"Title_Purple\">".mb_substr($fc4[$i],0,1)."　".mb_substr($fc4[$i],1,1)."</td>";
        }else{
            $html_f .= "<td class=\"Title_Purple\">".$fc4[$i]."</td>";
        }
    }
}
$f_num = 0;
    for($i=0;$i<count($fc_staff);$i++){
        array_pop($fc_staff[$i]);
        array_pop($fc_staff[$i]);
        $f_num++;
        $html_f .= "<tr class=\"Result1\"><td>$f_num</td>";
        for($j=0;$j<count($fc_staff[$i]);$j++){
            if($j==0 && ($i==0 || $fc_staff[$i-1][0] != $fc_staff[$i][0])){
                $html_f .= "<td>".$fc_staff[$i][0]."<br>".$fc_staff[$i][1]."</td>";
                $j++;
            }elseif($j==0 && $fc_staff[$i-1][0] == $fc_staff[$i][0]){
                $html_f .= "<td></td>";
                $j++;
            }elseif($j==4){
                $html_f .= "<td>".$fc_staff[$i][$j]."<br>".$fc_staff[$i][$j+1]."</td>";
                $j++;
            }elseif($j>6){
                $html_f .= "<td align=center>".$fc_staff[$i][$j]."</td>";
            }else{
                $html_f .= "<td>".$fc_staff[$i][$j]."</td>";
            }
        }
    $html_f .= "</tr>";
    }
$html_f .= "</table>";
$f_num = "ＦＣ　全 <span style=\"font-weight: bold;\">".$f_num."</span> 件";
}
//設定済み？
if($_POST['form_set_button'] != null){

}
if($_POST['set_flg']==true){
    $data_set = "設定済み";
//print_array($_POST);
}
//csv出力ボタン押下
if($_POST['csv_btn'] != null){
    $sqlh = Search_sql("h");
    $sqlf = Search_sql("f");

    $head_res = Db_Query($db_con,$head_sql.$sqlh.$head_sql2);
    $fc_res = Db_Query($db_con,$fc_sql.$sqlf.$fc_sql2);

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
function Search_sql($type){
    $client_cd1 = $_POST['form_client_cd']['cd1'];
    $client_cd2 = $_POST['form_client_cd']['cd2'];
    $client_name = $_POST['form_client_name'];
    $charge_cd = $_POST['form_charge_cd'];
    $staff_name = $_POST['form_staff_name'];
    $del_compe = $_POST['form_del_compe'];
    $accept_compe = $_POST['form_accept_compe'];
    $compe_invest = $_POST['form_compe_invest'];
    $staff_state = $_POST['form_staff_state'];

    $sql = "";
    if($client_cd1 != null){
        $sql .= " AND client_cd1 LIKE '$client_cd1%' ";
    }

    if($client_cd2 != null){
        $sql .= " AND client_cd2 LIKE '$client_cd2%' ";
    }

    if($client_name != null){
        $sql .= "AND (t_client.client_name LIKE '%$client_name%'
                        OR t_client.client_read LIKE '%$client_name%'
                        OR t_client.client_cname LIKE '%$client_name%') ";
    }

    if($charge_cd != null){
        $sql .= " AND t_staff.charge_cd LIKE '$charge_cd%' ";
    }

    if($staff_name != null){
        $sql .= " AND (t_staff.staff_name LIKE '%$staff_name%' ";
        $sql .= "       OR t_staff.staff_read LIKE '%$staff_name%' ";
        $sql .= "       OR t_staff.staff_ascii LIKE '%$staff_name%' ) ";
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

    if($_POST['set_flg'] == 'true'){

        $sqlh = "";

        if($_POST['permit']['h'][1][1][0]['w'] == 'true'){
            $sqlh .= " AND h_2_102 = 'w' ";
        }elseif($_POST['permit']['h'][1][1][0]['r'] == 'true'){
            $sqlh .= " AND h_2_102 = 'r' ";
        }

        if($_POST['permit']['h'][1][2][0]['w'] == 'true'){
            $sqlh .= " AND h_6_204 = 'w' ";
        }elseif($_POST['permit']['h'][1][2][0]['r'] == 'true'){
            $sqlh .= " AND h_6_204 = 'r' ";
        }

        if($_POST['permit']['h'][1][3][0]['w'] == 'true'){
            $sqlh .= " AND h_2_201 = 'w' ";
        }elseif($_POST['permit']['h'][1][3][0]['r'] == 'true'){
            $sqlh .= " AND h_2_201 = 'r' ";
        }

        if($_POST['permit']['h'][1][4][0]['w'] == 'true'){
            $sqlh .= " AND h_2_301 = 'w' ";
        }elseif($_POST['permit']['h'][1][4][0]['r'] == 'true'){
            $sqlh .= " AND h_2_301 = 'r' ";
        }

        if($_POST['permit']['h'][1][5][0]['w'] == 'true'){
            $sqlh .= " AND h_2_401 = 'w' ";
        }elseif($_POST['permit']['h'][1][5][0]['r'] == 'true'){
            $sqlh .= " AND h_2_401 = 'r' ";
        }

        if($_POST['permit']['h'][1][6][0]['w'] == 'true'){
            $sqlh .= " AND h_2_501 = 'w' ";
        }elseif($_POST['permit']['h'][1][6][0]['r'] == 'true'){
            $sqlh .= " AND h_2_501 = 'r' ";
        }

        if($_POST['permit']['h'][2][1][0]['w'] == 'true'){
            $sqlh .= " AND h_3_101 = 'w' ";
        }elseif($_POST['permit']['h'][2][1][0]['r'] == 'true'){
            $sqlh .= " AND h_3_101 = 'r' ";
        }

        if($_POST['permit']['h'][2][2][0]['w'] == 'true'){
            $sqlh .= " AND h_3_201 = 'w' ";
        }elseif($_POST['permit']['h'][2][2][0]['r'] == 'true'){
            $sqlh .= " AND h_3_201 = 'r' ";
        }

        if($_POST['permit']['h'][2][3][0]['w'] == 'true'){
            $sqlh .= " AND h_3_302 = 'w' ";
        }elseif($_POST['permit']['h'][2][3][0]['r'] == 'true'){
            $sqlh .= " AND h_3_302 = 'r' ";
        }

        if($_POST['permit']['h'][2][4][0]['w'] == 'true'){
            $sqlh .= " AND h_3_401 = 'w' ";
        }elseif($_POST['permit']['h'][2][4][0]['r'] == 'true'){
            $sqlh .= " AND h_3_401 = 'r' ";
        }
        if($_POST['permit']['h'][1][2][0]['w'] == 'true'){
            $sqlh .= " AND h_6_204 = 'w' ";
        }elseif($_POST['permit']['h'][1][2][0]['r'] == 'true'){
            $sqlh .= " AND h_6_204 = 'r' ";
        }

        if($_POST['permit']['h'][1][3][0]['w'] == 'true'){
            $sqlh .= " AND h_2_201 = 'w' ";
        }elseif($_POST['permit']['h'][1][3][0]['r'] == 'true'){
            $sqlh .= " AND h_2_201 = 'r' ";
        }

        if($_POST['permit']['h'][1][4][0]['w'] == 'true'){
            $sqlh .= " AND h_2_301 = 'w' ";
        }elseif($_POST['permit']['h'][1][4][0]['r'] == 'true'){
            $sqlh .= " AND h_2_301 = 'r' ";
        }

        if($_POST['permit']['h'][1][5][0]['w'] == 'true'){
            $sqlh .= " AND h_2_401 = 'w' ";
        }elseif($_POST['permit']['h'][1][5][0]['r'] == 'true'){
            $sqlh .= " AND h_2_401 = 'r' ";
        }

        if($_POST['permit']['h'][1][6][0]['w'] == 'true'){
            $sqlh .= " AND h_2_501 = 'w' ";
        }elseif($_POST['permit']['h'][1][6][0]['r'] == 'true'){
            $sqlh .= " AND h_2_501 = 'r' ";
        }

        if($_POST['permit']['h'][2][1][0]['w'] == 'true'){
            $sqlh .= " AND h_3_101 = 'w' ";
        }elseif($_POST['permit']['h'][2][1][0]['r'] == 'true'){
            $sqlh .= " AND h_3_101 = 'r' ";
        }

        if($_POST['permit']['h'][2][2][0]['w'] == 'true'){
            $sqlh .= " AND h_3_201 = 'w' ";
        }elseif($_POST['permit']['h'][2][2][0]['r'] == 'true'){
            $sqlh .= " AND h_3_201 = 'r' ";
        }

        if($_POST['permit']['h'][2][3][0]['w'] == 'true'){
            $sqlh .= " AND h_3_302 = 'w' ";
        }elseif($_POST['permit']['h'][2][3][0]['r'] == 'true'){
            $sqlh .= " AND h_3_302 = 'r' ";
        }

        if($_POST['permit']['h'][2][4][0]['w'] == 'true'){
            $sqlh .= " AND h_3_401 = 'w' ";
        }elseif($_POST['permit']['h'][2][4][0]['r'] == 'true'){
            $sqlh .= " AND h_3_401 = 'r' ";
        }

        if($_POST['permit']['h'][3][1][0]['w'] == 'true'){
            $sqlh .= " AND h_4_101 = 'w' ";
        }elseif($_POST['permit']['h'][3][1][0]['r'] == 'true'){
            $sqlh .= " AND h_4_101 = 'r' ";
        }

        if($_POST['permit']['h'][3][2][0]['w'] == 'true'){
            $sqlh .= " AND h_4_201 = 'w' ";
        }elseif($_POST['permit']['h'][3][2][0]['r'] == 'true'){
            $sqlh .= " AND h_4_201 = 'r' ";
        }

        if($_POST['permit']['h'][4][1][0]['w'] == 'true'){
            $sqlh .= " AND h_5_109 = 'w' ";
        }elseif($_POST['permit']['h'][4][1][0]['r'] == 'true'){
            $sqlh .= " AND h_5_109 = 'r' ";
        }

        if($_POST['permit']['h'][5][1][0]['w'] == 'true'){
            $sqlh .= " AND h_6_132 = 'w' ";
        }elseif($_POST['permit']['h'][5][1][0]['r'] == 'true'){
            $sqlh .= " AND h_6_132 = 'r' ";
        }

        if($_POST['permit']['h'][5][2][0]['w'] == 'true'){
            $sqlh .= " AND h_6_103 = 'w' ";
        }elseif($_POST['permit']['h'][5][2][0]['r'] == 'true'){
            $sqlh .= " AND h_6_103 = 'r' ";
        }

        if($_POST['permit']['h'][5][3][0]['w'] == 'true'){
            $sqlh .= " AND h_6_112 = 'w' ";
        }elseif($_POST['permit']['h'][5][3][0]['r'] == 'true'){
            $sqlh .= " AND h_6_112 = 'r' ";
        }

        if($_POST['permit']['h'][5][4][0]['w'] == 'true'){
            $sqlh .= " AND h_6_122 = 'w' ";
        }elseif($_POST['permit']['h'][5][4][0]['r'] == 'true'){
            $sqlh .= " AND h_6_122 = 'r' ";
        }

        if($_POST['permit']['h'][5][5][0]['w'] == 'true'){
            $sqlh .= " AND h_6_301 = 'w' ";
        }elseif($_POST['permit']['h'][5][5][0]['r'] == 'true'){
            $sqlh .= " AND h_6_301 = 'r' ";
        }

        if($_POST['permit']['h'][6][1][1]['w'] == 'true'){
            $sqlh .= " AND h_1_205 = 'w' ";
        }elseif($_POST['permit']['h'][6][1][1]['r'] == 'true'){
            $sqlh .= " AND h_1_205 = 'r' ";
        }

        if($_POST['permit']['h'][6][1][2]['w'] == 'true'){
            $sqlh .= " AND h_1_234 = 'w' ";
        }elseif($_POST['permit']['h'][6][1][2]['r'] == 'true'){
            $sqlh .= " AND h_1_234 = 'r' ";
        }

        if($_POST['permit']['h'][6][1][3]['w'] == 'true'){
            $sqlh .= " AND h_1_233 = 'w' ";
        }elseif($_POST['permit']['h'][6][1][3]['r'] == 'true'){
            $sqlh .= " AND h_1_233 = 'r' ";
        }

        if($_POST['permit']['h'][6][1][4]['w'] == 'true'){
            $sqlh .= " AND h_1_231 = 'w' ";
        }elseif($_POST['permit']['h'][6][1][4]['r'] == 'true'){
            $sqlh .= " AND h_1_231 = 'r' ";
        }

        if($_POST['permit']['h'][6][1][5]['w'] == 'true'){
            $sqlh .= " AND h_1_230 = 'w' ";
        }elseif($_POST['permit']['h'][6][1][5]['r'] == 'true'){
            $sqlh .= " AND h_1_230 = 'r' ";
        }

        if($_POST['permit']['h'][6][2][1]['w'] == 'true'){
            $sqlh .= " AND h_1_109 = 'w' ";
        }elseif($_POST['permit']['h'][6][2][1]['r'] == 'true'){
            $sqlh .= " AND h_1_109 = 'r' ";
        }

        if($_POST['permit']['h'][6][2][2]['w'] == 'true'){
            $sqlh .= " AND h_1_211 = 'w' ";
        }elseif($_POST['permit']['h'][6][2][2]['r'] == 'true'){
            $sqlh .= " AND h_1_211 = 'r' ";
        }

        if($_POST['permit']['h'][6][2][3]['w'] == 'true'){
            $sqlh .= " AND h_1_209 = 'w' ";
        }elseif($_POST['permit']['h'][6][2][3]['r'] == 'true'){
            $sqlh .= " AND h_1_209 = 'r' ";
        }

        if($_POST['permit']['h'][6][2][4]['w'] == 'true'){
            $sqlh .= " AND h_1_235 = 'w' ";
        }elseif($_POST['permit']['h'][6][2][4]['r'] == 'true'){
            $sqlh .= " AND h_1_235 = 'r' ";
        }

        if($_POST['permit']['h'][6][2][5]['w'] == 'true'){
            $sqlh .= " AND h_1_221 = 'w' ";
        }elseif($_POST['permit']['h'][6][2][5]['r'] == 'true'){
            $sqlh .= " AND h_1_221 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][1]['w'] == 'true'){
            $sqlh .= " AND h_1_201 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][1]['r'] == 'true'){
            $sqlh .= " AND h_1_201 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][2]['w'] == 'true'){
            $sqlh .= " AND h_1_203 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][2]['r'] == 'true'){
            $sqlh .= " AND h_1_203 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][3]['w'] == 'true'){
            $sqlh .= " AND h_1_213 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][3]['r'] == 'true'){
            $sqlh .= " AND h_1_213 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][4]['w'] == 'true'){
            $sqlh .= " AND h_1_207 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][4]['r'] == 'true'){
            $sqlh .= " AND h_1_207 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][5]['w'] == 'true'){
            $sqlh .= " AND h_1_224 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][5]['r'] == 'true'){
            $sqlh .= " AND h_1_224 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][6]['w'] == 'true'){
            $sqlh .= " AND h_1_227 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][6]['r'] == 'true'){
            $sqlh .= " AND h_1_227 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][7]['w'] == 'true'){
            $sqlh .= " AND h_1_103 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][7]['r'] == 'true'){
            $sqlh .= " AND h_1_103 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][8]['w'] == 'true'){
            $sqlh .= " AND h_1_115 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][8]['r'] == 'true'){
            $sqlh .= " AND h_1_115 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][9]['w'] == 'true'){
        print "6-3-9-w";
            $sqlh .= " AND h_1_116 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][9]['r'] == 'true'){
            $sqlh .= " AND h_1_116 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][10]['w'] == 'true'){
            $sqlh .= " AND h_1_216 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][10]['r'] == 'true'){
            $sqlh .= " AND h_1_216 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][11]['w'] == 'true'){
            $sqlh .= " AND h_1_219 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][11]['r'] == 'true'){
            $sqlh .= " AND h_1_219 = 'r' ";
        }

        if($_POST['permit']['h'][6][3][12]['w'] == 'true'){
            $sqlh .= " AND h_1_225 = 'w' ";
        }elseif($_POST['permit']['h'][6][3][12]['r'] == 'true'){
            $sqlh .= " AND h_1_225 = 'r' ";
        }
        if($_POST['permit']['h'][6][4][1]['w'] == 'true'){
            $sqlh .= " AND h_1_303 = 'w' ";
        }elseif($_POST['permit']['h'][6][4][1]['r'] == 'true'){
            $sqlh .= " AND h_1_303 = 'r' ";
        }

        if($_POST['permit']['h'][6][4][2]['w'] == 'true'){
            $sqlh .= " AND h_1_304 = 'w' ";
        }elseif($_POST['permit']['h'][6][4][2]['r'] == 'true'){
            $sqlh .= " AND h_1_304 = 'r' ";
        }

        if($_POST['permit']['h'][6][4][3]['w'] == 'true'){
            $sqlh .= " AND h_1_311 = 'w' ";
        }elseif($_POST['permit']['h'][6][4][3]['r'] == 'true'){
            $sqlh .= " AND h_1_311 = 'r' ";
        }

        if($_POST['permit']['h'][6][4][4]['w'] == 'true'){
            $sqlh .= " AND h_1_312 = 'w' ";
        }elseif($_POST['permit']['h'][6][4][4]['r'] == 'true'){
            $sqlh .= " AND h_1_312 = 'r' ";
        }

        if($_POST['permit']['h'][6][4][5]['w'] == 'true'){
            $sqlh .= " AND h_1_310 = 'w' ";
        }elseif($_POST['permit']['h'][6][4][5]['r'] == 'true'){
            $sqlh .= " AND h_1_310 = 'r' ";
        }

        if($_POST['permit']['h'][6][5][1]['w'] == 'true'){
            $sqlh .= " AND h_1_301 = 'w' ";
        }elseif($_POST['permit']['h'][6][5][1]['r'] == 'true'){
            $sqlh .= " AND h_1_301 = 'r' ";
        }

        if($_POST['permit']['h'][6][5][2]['w'] == 'true'){
            $sqlh .= " AND h_1_305 = 'w' ";
        }elseif($_POST['permit']['h'][6][5][2]['r'] == 'true'){
            $sqlh .= " AND h_1_305 = 'r' ";
        }

        if($_POST['permit']['h'][6][5][3]['w'] == 'true'){
            $sqlh .= " AND h_1_306 = 'w' ";
        }elseif($_POST['permit']['h'][6][5][3]['r'] == 'true'){
            $sqlh .= " AND h_1_306 = 'r' ";
        }

        if($_POST['permit']['h'][6][5][4]['w'] == 'true'){
            $sqlh .= " AND h_1_307 = 'w' ";
        }elseif($_POST['permit']['h'][6][5][4]['r'] == 'true'){
            $sqlh .= " AND h_1_307 = 'r' ";
        }

        $sqlf = "";

        if($_POST['permit']['f'][1][1][0]['w'] == 'true'){
            $sqlf .= " AND f_2_101 = 'w' ";
        }elseif($_POST['permit']['f'][1][1][0]['r'] == 'true'){
            $sqlf .= " AND f_2_101 = 'r' ";
        }

        if($_POST['permit']['f'][1][2][0]['w'] == 'true'){
            $sqlf .= " AND f_2_201 = 'w' ";
        }elseif($_POST['permit']['f'][1][2][0]['r'] == 'true'){
            $sqlf .= " AND f_2_201 = 'r' ";
        }

        if($_POST['permit']['f'][1][3][0]['w'] == 'true'){
            $sqlf .= " AND f_2_301 = 'w' ";
        }elseif($_POST['permit']['f'][1][3][0]['r'] == 'true'){
            $sqlf .= " AND f_2_301 = 'r' ";
        }

        if($_POST['permit']['f'][1][4][0]['w'] == 'true'){
            $sqlf .= " AND f_2_401 = 'w' ";
        }elseif($_POST['permit']['f'][1][4][0]['r'] == 'true'){
            $sqlf .= " AND f_2_401 = 'r' ";
        }

        if($_POST['permit']['f'][1][5][0]['w'] == 'true'){
            $sqlf .= " AND f_2_501 = 'w' ";
        }elseif($_POST['permit']['f'][1][5][0]['r'] == 'true'){
            $sqlf .= " AND f_2_501 = 'r' ";
        }

        if($_POST['permit']['f'][2][1][0]['w'] == 'true'){
            $sqlf .= " AND f_3_101 = 'w' ";
        }elseif($_POST['permit']['f'][2][1][0]['r'] == 'true'){
            $sqlf .= " AND f_3_101 = 'r' ";
        }

        if($_POST['permit']['f'][2][2][0]['w'] == 'true'){
            $sqlf .= " AND f_3_201 = 'w' ";
        }elseif($_POST['permit']['f'][2][2][0]['r'] == 'true'){
            $sqlf .= " AND f_3_201 = 'r' ";
        }

        if($_POST['permit']['f'][2][3][0]['w'] == 'true'){
            $sqlf .= " AND f_3_302 = 'w' ";
        }elseif($_POST['permit']['f'][2][3][0]['r'] == 'true'){
            $sqlf .= " AND f_3_302 = 'r' ";
        }

        if($_POST['permit']['f'][2][4][0]['w'] == 'true'){
            $sqlf .= " AND f_3_401 = 'w' ";
        }elseif($_POST['permit']['f'][2][4][0]['r'] == 'true'){
            $sqlf .= " AND f_3_401 = 'r' ";
        }

        if($_POST['permit']['f'][3][1][0]['w'] == 'true'){
            $sqlf .= " AND f_4_101 = 'w' ";
        }elseif($_POST['permit']['f'][3][1][0]['r'] == 'true'){
            $sqlf .= " AND f_4_101 = 'r' ";
        }

        if($_POST['permit']['f'][3][2][0]['w'] == 'true'){
            $sqlf .= " AND f_4_201 = 'w' ";
        }elseif($_POST['permit']['f'][3][2][0]['r'] == 'true'){
            $sqlf .= " AND f_4_201 = 'r' ";
        }

        if($_POST['permit']['f'][4][1][0]['w'] == 'true'){
            $sqlf .= " AND f_5_105 = 'w' ";
        }elseif($_POST['permit']['f'][4][1][0]['r'] == 'true'){
            $sqlf .= " AND f_5_105 = 'r' ";
        }

        if($_POST['permit']['f'][5][1][0]['w'] == 'true'){
            $sqlf .= " AND f_6_132 = 'w' ";
        }elseif($_POST['permit']['f'][5][1][0]['r'] == 'true'){
            $sqlf .= " AND f_6_132 = 'r' ";
        }

        if($_POST['permit']['f'][5][2][0]['w'] == 'true'){
            $sqlf .= " AND f_6_103 = 'w' ";
        }elseif($_POST['permit']['f'][5][2][0]['r'] == 'true'){
            $sqlf .= " AND f_6_103 = 'r' ";
        }

        if($_POST['permit']['f'][5][3][0]['w'] == 'true'){
            $sqlf .= " AND f_6_112 = 'w' ";
        }elseif($_POST['permit']['f'][5][3][0]['r'] == 'true'){
            $sqlf .= " AND f_6_112 = 'r' ";
        }

        if($_POST['permit']['f'][5][4][0]['w'] == 'true'){
            $sqlf .= " AND f_6_122 = 'w' ";
        }elseif($_POST['permit']['f'][5][4][0]['r'] == 'true'){
            $sqlf .= " AND f_6_122 = 'r' ";
        }

        if($_POST['permit']['f'][5][5][0]['w'] == 'true'){
            $sqlf .= " AND f_6_201 = 'w' ";
        }elseif($_POST['permit']['f'][5][5][0]['r'] == 'true'){
            $sqlf .= " AND f_6_201 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][1]['w'] == 'true'){
            $sqlf .= " AND f_1_201 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][1]['r'] == 'true'){
            $sqlf .= " AND f_1_201 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][2]['w'] == 'true'){
            $sqlf .= " AND f_1_203 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][2]['r'] == 'true'){
            $sqlf .= " AND  f_1_203 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][3]['w'] == 'true'){
            $sqlf .= " AND f_1_213 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][3]['r'] == 'true'){
            $sqlf .= " AND f_1_213 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][4]['w'] == 'true'){
            $sqlf .= " AND f_1_207 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][4]['r'] == 'true'){
            $sqlf .= " AND f_1_207 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][5]['w'] == 'true'){
            $sqlf .= " AND f_1_227 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][5]['r'] == 'true'){
            $sqlf .= " AND f_1_227 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][6]['w'] == 'true'){
            $sqlf .= " AND f_1_103 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][6]['r'] == 'true'){
            $sqlf .= " AND f_1_103 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][7]['w'] == 'true'){
            $sqlf .= " AND f_1_104 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][7]['r'] == 'true'){
            $sqlf .= " AND f_1_104 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][8]['w'] == 'true'){
            $sqlf .= " AND f_1_216 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][8]['r'] == 'true'){
            $sqlf .= " AND f_1_216 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][9]['w'] == 'true'){
            $sqlf .= " AND f_1_219 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][9]['r'] == 'true'){
            $sqlf .= " AND f_1_219 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][10]['w'] == 'true'){
            $sqlf .= " AND f_1_225 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][10]['r'] == 'true'){
            $sqlf .= " AND f_1_225 = 'r' ";
        }

        if($_POST['permit']['f'][6][1][11]['w'] == 'true'){
            $sqlf .= " AND f_1_141 = 'w' ";
        }elseif($_POST['permit']['f'][6][1][11]['r'] == 'true'){
            $sqlf .= " AND f_1_141 = 'r' ";
        }

        if($_POST['permit']['f'][6][2][1]['w'] == 'true'){
            $sqlf .= " AND f_1_108 = 'w' ";
        }elseif($_POST['permit']['f'][6][2][1]['r'] == 'true'){
            $sqlf .= " AND f_1_108 = 'r' ";
        }

        if($_POST['permit']['f'][6][2][2]['w'] == 'true'){
            $sqlf .= " AND f_1_211 = 'w' ";
        }elseif($_POST['permit']['f'][6][2][2]['r'] == 'true'){
            $sqlf .= " AND f_1_211 = 'r' ";
        }

        if($_POST['permit']['f'][6][2][3]['w'] == 'true'){
            $sqlf .= " AND f_1_209 = 'w' ";
        }elseif($_POST['permit']['f'][6][2][3]['r'] == 'true'){
            $sqlf .= " AND f_1_209 = 'r' ";
        }

        if($_POST['permit']['f'][6][2][4]['w'] == 'true'){
            $sqlf .= " AND f_1_241 = 'w' ";
        }elseif($_POST['permit']['f'][6][2][4]['r'] == 'true'){
            $sqlf .= " AND f_1_241 = 'r' ";
        }

        if($_POST['permit']['f'][6][2][5]['w'] == 'true'){
            $sqlf .= " AND f_1_221 = 'w' ";
        }elseif($_POST['permit']['f'][6][2][5]['r'] == 'true'){
            $sqlf .= " AND f_1_221 = 'r' ";
        }

        if($_POST['permit']['f'][6][3][1]['w'] == 'true'){
            $sqlf .= " AND f_1_303 = 'w' ";
        }elseif($_POST['permit']['f'][6][3][1]['r'] == 'true'){
            $sqlf .= " AND f_1_303 = 'r' ";
        }

        if($_POST['permit']['f'][6][3][2]['w'] == 'true'){
            $sqlf .= " AND f_1_308 = 'w' ";
        }elseif($_POST['permit']['f'][6][3][2]['r'] == 'true'){
            $sqlf .= " AND f_1_308 = 'r' ";
        }

        if($_POST['permit']['f'][6][3][3]['w'] == 'true'){
            $sqlf .= " AND f_1_307 = 'w' ";
        }elseif($_POST['permit']['f'][6][3][3]['r'] == 'true'){
            $sqlf .= " AND f_1_307 = 'r' ";
        }

        if($_POST['permit']['f'][6][4][1]['w'] == 'true'){
            $sqlf .= " AND f_1_301 = 'w' ";
        }elseif($_POST['permit']['f'][6][4][1]['r'] == 'true'){
            $sqlf .= " AND f_1_301 = 'r' ";
        }

        if($_POST['permit']['f'][6][4][2]['w'] == 'true'){
            $sqlf .= " AND f_1_304 = 'w' ";
        }elseif($_POST['permit']['f'][6][4][2]['r'] == 'true'){
            $sqlf .= " AND f_1_304 = 'r' ";
        }

        if($_POST['permit']['f'][6][4][3]['w'] == 'true'){
            $sqlf .= " AND f_1_305 = 'w' ";
        }elseif($_POST['permit']['f'][6][4][3]['r'] == 'true'){
            $sqlf .= " AND f_1_305 = 'r' ";
        }

        if($_POST['permit']['f'][6][4][4]['w'] == 'true'){
            $sqlf .= " AND f_1_306 = 'w' ";
        }elseif($_POST['permit']['f'][6][4][4]['r'] == 'true'){
            $sqlf .= " AND f_1_306 = 'r' ";
        }

        if($_POST['permit']['f'][6][4][5]['w'] == 'true'){
            $sqlf .= " AND f_1_350 = 'w' ";
        }elseif($_POST['permit']['f'][6][4][5]['r'] == 'true'){
            $sqlf .= " AND f_1_350 = 'r' ";
        }

        if($_POST['permit']['f'][6][5][1]['w'] == 'true'){
            $sqlf .= " AND f_1_231 = 'w' ";
        }elseif($_POST['permit']['f'][6][5][1]['r'] == 'true'){
            $sqlf .= " AND f_1_231 = 'r' ";
        }

        if($_POST['permit']['f'][6][5][2]['w'] == 'true'){
            $sqlf .= " AND f_1_234 = 'w' ";
        }elseif($_POST['permit']['f'][6][5][2]['r'] == 'true'){
            $sqlf .= " AND f_1_234 = 'r' ";
        }

        if($_POST['permit']['f'][6][5][3]['w'] == 'true'){
            $sqlf .= " AND f_1_233 = 'w' ";
        }elseif($_POST['permit']['f'][6][5][3]['r'] == 'true'){
            $sqlf .= " AND f_1_233 = 'r' ";
        }

        if($_POST['permit']['f'][6][5][4]['w'] == 'true'){
            $sqlf .= " AND f_1_232 = 'w' ";
        }elseif($_POST['permit']['f'][6][5][4]['r'] == 'true'){
            $sqlf .= " AND f_1_232 = 'r' ";
        }

        if($_POST['permit']['f'][6][5][5]['w'] == 'true'){
            $sqlf .= " AND f_1_229 = 'w' ";
        }elseif($_POST['permit']['f'][6][5][5]['r'] == 'true'){
            $sqlf .= " AND f_1_229 = 'r' ";
        }

    }

    if($type == "h"){
        return $sql.$sqlh;
    }elseif($type == "f"){
        return $sql.$sqlf;
    }
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
            //"を""に
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
/*
$st = "<table border=1>
<tr><td colspan=9 rowspan=2>スタッフのとこ</td>
<td colspan=6 rowspan=2>売上管理</td>
<td colspan=4 rowspan=2>仕入管理</td>
<td colspan=2 rowspan=2>在庫管理</td>
<td rowspan=2>更新</td>
<td colspan=5 rowspan=2>データ出力</td>
<td colspan=31>マスタ・設定</td></tr>
<tr><td colspan=5>本部管理マスタ</td><td colspan=5>一部共有マスタ</td>
<td colspan=12>個別マスタ</td><td colspan=5>帳簿設定</td>
<td colspan=4>システム設定</td></tr>
<tr><td colspan=9>スタッフ情報</td><td>受注取引</td><td>月例清算販売書</td><td>売上取引</td><td>請求管理</td><td>入金管理</td><td>実績管理</td>

<td>発注取引</td><td>仕入取引</td><td>支払管理</td><td>実績管理</td>

<td>在庫取引</td><td>棚卸管理</td>

<td>更新管理</td>

<td>統計情報</td><td>売上推移</td><td>ABC分析</td><td>仕入推移</td><td>CSV出力</td>

<td>業種</td><td>業態</td><td>施設</td><td>サービス</td><td>構成品</td>

<td>スタッフ</td><td>Ｍ区分</td><td>管理区分</td><td>商品分類</td><td>商品</td>

<td>部署</td><td>倉庫</td><td>地区</td><td>銀行</td><td>製造品</td><td>FC区分</td><td>FC</td><td>得意先</td><td>契約</td><td>仕入先</td><td>>直送先</td><td>運送業者</td>

<td>発注書コメント</td><td>注文書フォーマット</td><td>売上伝票</td><td>納品書</td><td>請求書</td>

<td>本部プロフィール</td><td>買掛残高初期設定</td><td>売掛残高初期設定</td><td>請求残高初期設定</td>
</tr>
";
$st2 = "
<tr><td colspan=9 rowspan=2>スタッフのとこ</td><td colspan=5 rowspan=2>売上管理</td><td colspan=4 rowspan=2>仕入管理</td><td colspan=2 rowspan=2>在庫管理</td><td rowspan=2>更新</td><td colspan=5 rowspan=2>データ出力</td><td colspan=29>マスタ・設定</td><td></td><td></td>
</tr>
<tr><td colspan=11>個別マスタ</td><td colspan=5>一部共有マスタ</td><td colspan=3>帳簿設定</td><td colspan=5>システム設定</td><td colspan=5>本
部管理マスタ</td>
<td></td><td></td>
</tr>
<tr><td colspan=9>スタッフ情報</td><td>予定取引</td><td>売上取引</td><td>請求管理</td><td>入金管理</td><td>実績管理</td>

<td>発注取引</td><td>仕入取引</td><td>支払管理</td><td>実績管理</td>

<td>在庫取引</td><td>棚卸管理</td>

<td>更新管理</td>

<td>統計情報</td><td>売上推移</td><td>ABC分析</td><td>仕入推移</td><td>CSV出力</td>

<td>部署</td><td>倉庫</td><td>地区</td><td>銀行</td><td>コース</td><td>得意先</td><td>契約</td><td>仕入先</td><td>直送先</td><td>運送業者</td><td>レンタルTOレンタル</td>

<td>スタッフ</td><td>Ｍ区分</td><td>管理区分</td><td>商品分類</td><td>商品</td>

<td>発注書コメント</td><td>売上伝票</td><td>請求書</td>

<td>自社プロフィール</td><td>買掛残高初期設定</td><td>売掛残高初期設定</td><td>請求残高初期設定</td><td>休日設定</td>

<td>業種</td><td>業態</td><td>施設</td><td>サービス</td><td>構成品</td>
<td> </td><td> </td><td> </td>
";
*/
//print $name;
//print implode(",",$pmt);
/*
print "<table border =1><tr><td>";
print implode("</td><td>",$head2);
print "</td></tr><tr><td>";
print implode("</td><td>",$head3);
print "</td></tr><tr><td>";
print implode("</td><td>",$head4);
print "</td></tr><tr><td>";
print implode("</td><td>",$fc2);
print "</td></tr><tr><td>";
print implode("</td><td>",$fc3);
print "</td></tr><tr><td>";
print implode("</td><td>",$fc4);
print "</td></tr></table>";
*/


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
$page_header = Create_Header($page_title);



// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());
//その他の変数をassign
$smarty->assign('var',array(
        'html_header'               => "$html_header",
    'html'                      => "$html",
    'html_f'                    => "$html_f",
    'js'                        => "$js",
    'num'                   => "$num",
    'f_num'                 => "$f_num",
    'data_set'              => "$data_set",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
));
$smarty->assign('ary_data',$ary);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
