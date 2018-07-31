<?php
$page_title = "権限指定画面設定";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");


//DB接続
$db_con = Db_Connect();

// 権限チェック
//$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
/****************************/
// Javascript定義
/****************************/
$js_data = <<<PRINT_HTML_SRC

/*** サブメニューチェック ***/
function Allcheck_Submenu2(me, ary_key){

    /* チェック判定 */
    if (document.dateForm.elements[me].checked == true){
        /* サブメニュー内フォーム数分ループ */
        for (i=1; i<=ary_key[3]; i++){
            /* チェックON */
            var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+ary_key[2]+"]["+i+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = true;
        }
    }else{
        /* サブメニュー内フォーム数分ループ */
        for (i=1; i<=ary_key[3]; i++){
            /* チェックOFF */
            var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+ary_key[2]+"]["+i+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = false;
        }
    }

}


/*** メニューチェック ***/
function Allcheck_Menu2(me, ary_key){

    /* チェック判定 */
    if (document.dateForm.elements[me].checked == true){
        /* サブメニュー数分ループ */
        for (i=1; i<=ary_key[2]; i++){
            /* サブメニューチェックON */
            var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+i+"]["+0+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = true;
            /* サブメニュー内フォーム数分ループ */
            for (j=1; j<=ary_key[3][i-1]; j++){
                /* チェックON */
                var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+i+"]["+j+"]["+ary_key[4]+"]";
                document.dateForm.elements[target].checked = true;
            }
        }
    }else{
        /* サブメニュー数分ループ */
        for (i=1; i<=ary_key[2]; i++){
            /* サブメニューチェックOFF */
            var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+i+"]["+0+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = false;
            /* サブメニュー内フォーム数分ループ */
            for (j=1; j<=ary_key[3][i-1]; j++){
                /* チェックOFF */
                var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+i+"]["+j+"]["+ary_key[4]+"]";
                document.dateForm.elements[target].checked = false;
            }
        }
    }

}


/*** トップチェック ***/
function Allcheck_Top2(me, ary_key){

    if (document.dateForm.elements[me].checked == true){
        /* メニュー数分ループ */
        for (i=1; i<=ary_key[1]; i++){
            /* メニューチェックON */
            var target = "permit"+"["+ary_key[0]+"]["+i+"]["+0+"]["+0+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = true;
            /* サブメニュー数分ループ */
            for (j=1; j<=ary_key[2][i-1]; j++){
                /* サブメニューチェックON */
                var target = "permit"+"["+ary_key[0]+"]["+i+"]["+j+"]["+0+"]["+ary_key[4]+"]";
                document.dateForm.elements[target].checked = true;
                /* サブメニュー内フォーム数分ループ */
                for(k=1; k<=ary_key[3][i-1][j-1]; k++){
                    /* チェックON */
                    var target = "permit"+"["+ary_key[0]+"]["+i+"]["+j+"]["+k+"]["+ary_key[4]+"]";
                    document.dateForm.elements[target].checked = true;
                }
            }
        }
    }else{
        /* メニュー数分ループ */
        for (i=1; i<=ary_key[1]; i++){
            /* メニューチェックOFF */
            var target = "permit"+"["+ary_key[0]+"]["+i+"]["+0+"]["+0+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = false;
            /* サブメニュー数分ループ */
            for (j=1; j<=ary_key[2][i-1]; j++){
                /* サブメニューチェックOFF */
                var target = "permit"+"["+ary_key[0]+"]["+i+"]["+j+"]["+0+"]["+ary_key[4]+"]";
                document.dateForm.elements[target].checked = false;
                /* サブメニュー内フォーム数分ループ */
                for(k=1; k<=ary_key[3][i-1][j-1]; k++){
                    /* チェックOFF */
                    var target = "permit"+"["+ary_key[0]+"]["+i+"]["+j+"]["+k+"]["+ary_key[4]+"]";
                    document.dateForm.elements[target].checked = false;
                }
            }
        }
    }
}
/*** 設定ボタン ***/
function back_win(){
    permit = new Array();
    ary_key = new Array(1,6,5,3,2,6,6);
    ary_key2 = new Array(1,13,7,4,6,6);
    permit[1] = new Array();
    /* FC画面 */
    for(i = 1 ; i < 7 ; i++ ){
        permit[1][i] = new Array();
        for(j = 1 ; j < ary_key[i] ; j++){
            permit[1][i][j] = new Array();
            permit[1][i][j][0] = new Array();
            var hdn = "permit[f]["+i+"]["+j+"][0][r]"
            permit[1][i][j][0][1] = document.dateForm.elements[hdn].checked;
            var hdn = "permit[f]["+i+"]["+j+"][0][w]";
            permit[1][i][j][0][0] = document.dateForm.elements[hdn].checked;
//alert("permit[f]["+i+"]["+j+"][0][r] "+permit[1][i][j][0][1]);
//alert("permit[f]["+i+"]["+j+"][0][w] "+permit[1][i][j][0][0]);
            if(i>5 && j > 0 ){
                for(l = 1 ; l < ary_key2[j] ; l++){
                    permit[1][i][j][l] = new Array();
                    var hdn = "permit[f]["+i+"]["+j+"]["+l+"][r]";
                    permit[1][i][j][l][1] = document.dateForm.elements[hdn].checked;
                    var hdn = "permit[f]["+i+"]["+j+"]["+l+"][w]";
                    permit[1][i][j][l][0] = document.dateForm.elements[hdn].checked;
//alert("permit[f]["+i+"]["+j+"]["+l+"][r] "+permit[1][i][j][l][1]);
//alert("permit[f]["+i+"]["+j+"]["+l+"][w] "+permit[1][i][j][l][0]);
                }
            }
        }
    }
    returnValue = permit;
    window.close();
}

PRINT_HTML_SRC;



/****************************/
// フォームパーツ作成
/****************************/

/*** FCチェック項目の配列作成 ***/
$ary_f_mod_data = array(
    "0" =>  array(
        "0" =>  "売上管理",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "予定取引",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "売上取引",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "請求管理",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "入金管理",
                "1" =>  array(),
            ),
            "4" =>  array(
                "0" =>  "実績管理",
                "1" =>  array(),
            ),
        ),
    ),
    "1" =>  array(
        "0" =>  "仕入管理",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "発注取引",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "仕入取引",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "支払管理",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "実績管理",
                "1" =>  array(),
            ),
        ),
    ),
    "2" =>  array(
        "0" =>  "在庫管理",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "在庫取引",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "棚卸管理",
                "1" =>  array(),
            ),
        ),
    ),
    "3" =>  array(
        "0" =>  "更新",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "更新管理",
                "1" =>  array(),
            ),
        ),
    ),
    "4" =>  array(
        "0" =>  "データ出力",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "統計情報",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "売上推移",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "ABC分析",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "仕入推移",
                "1" =>  array(),
            ),
            "4" =>  array(
                "0" =>  "CSV出力",
                "1" =>  array(),
            ),
        ),
    ),
    "5" =>  array(
        "0" =>  "マスタ・設定",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "個別マスタ",
                "1" =>  array("部署", "倉庫", "地区", "銀行", "コース", "グループ","得意先", "契約", "仕入先", "直送先", "運送業者", "レンタルTOレンタル"),
            ),
            "1" =>  array(
                "0" =>  "一部共有マスタ",
                "1" =>  array("スタッフ", "権限一覧", "Ｍ区分", "管理区分", "商品分類", "商品",),
            ),
            "2" =>  array(
                "0" =>  "帳票設定",
                "1" =>  array("発注書コメント", "売上伝票", "請求書",),
            ),
            "3" =>  array(
                "0" =>  "システム設定",
                "1" =>  array("自社プロフィール", "買掛残高初期設定", "売掛残高初期設定", "請求残高初期設定", "休日設定",),
            ),
            "4" =>  array(
                "0" =>  "本部管理マスタ",
                "1" =>  array("業種", "業態", "施設", "サービス", "構成品",),
            ),
        ),
    ),
);


/*** FCチェックボックス要素の個数設定 ***/
// メニュー数
$ary_f[0] = 6;
// 各メニュー内のサブメニュー数
$ary_f[1] = array(5, 4, 2, 1, 5, 5);
// 各サブメニュー内のチェックボックス数
$ary_f[2] = array(
    0 => array(0, 0, 0, 0, 0),
    1 => array(0, 0, 0, 0),
    2 => array(0, 0),
    3 => array(0),
    4 => array(0, 0, 0, 0, 0),
    5 => array(12, 6, 3, 5, 5)
);

// rowspan算出
$f_rowspan = 0;
for ($i=0; $i<count($ary_f[2]); $i++){
    $f_rowspan++;
    $f_menu_rowspan[$i] = count($ary_f[2][$i]) + array_sum($ary_f[2][$i]);
    for ($j=0; $j<count($ary_f[2][$i]); $j++){
        $f_rowspan++;
        $f_rowspan += $ary_f[2][$i][$j];
    }
}
$f_submenu_rowspan = $ary_f[2];


$ary_opt  = array("r", "w", "n");
for ($i=0; $i<count($ary_opt); $i++){

    // FCトップチェック
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[f][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[f][0][0][0][".$ary_opt[$i]."]', ['f', 6, [5, 4, 2, 1, 5, 5], [[0, 0, 0, 0, 0], [0, 0, 0, 0], [0, 0], [0], [0, 0, 0, 0, 0], [12, 6, 3, 5, 5]], '".$ary_opt[$i]."']);\"");
    }else{
        $form->addElement("hidden", "permit[f][0][0][0][".$ary_opt[$i]."]", "");
    }

    // FCメニューチェック
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[f][1][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][1][0][0][".$ary_opt[$i]."]', ['f', 1, 5, [0, 0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][2][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][2][0][0][".$ary_opt[$i]."]', ['f', 2, 4, [0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][3][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][3][0][0][".$ary_opt[$i]."]', ['f', 3, 2, [0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][4][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][4][0][0][".$ary_opt[$i]."]', ['f', 4, 1, [0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][5][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][5][0][0][".$ary_opt[$i]."]', ['f', 5, 5, [0, 0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][6][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][6][0][0][".$ary_opt[$i]."]', ['f', 6, 5, [12, 6, 3, 5, 5], '".$ary_opt[$i]."']);\"");
    }else{
        $form->addElement("hidden", "permit[f][1][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][2][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][3][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][4][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][5][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][6][0][0][".$ary_opt[$i]."]", "");
    }
}

$ary_opt  = array("r", "w", "n");
// FCサブメニュー以下チェック
for ($i=1; $i<=$ary_f[0]; $i++){
   for ($j=1; $j<=$ary_f[1][$i-1]; $j++){
       for ($k=0; $k<=$ary_f[2][$i-1][$j-1]; $k++){
            for ($l=0; $l<count($ary_opt); $l++){
                $me = "permit[f][$i][$j][$k][$ary_opt[$l]]";
                if ($ary_opt[$l] != "n"){
                    if ($k == 0){
                        $js = "onClick=\"javascript: Allcheck_Submenu2('$me', ['f', $i, $j, ".$ary_f[2][$i-1][$j-1].", '$ary_opt[$l]']);\"";
                    }else{
                        $js = null;
                    }
                    $form->addElement("checkbox", $me, "", "", $js);
                }else{
                    $form->addElement("hidden", $me, "");
                }
            }
        }
    }
}

// 設定ボタン
$form->addElement("button", "form_set_button", "設　定","onClick=\"back_win();\"");
//$form->addElement("submit", "form_set_button", "設　定", "onClick=\"return Dialogue('設定します。','kaku-m_test2.php');window.close()\" $disabled");

// 戻るボタン
$form->addElement("button", "form_return_button", "戻　る", "onClick=\"javascript:self.window.close()\"");


/***************************/
//
/***************************/
if($_GET != null){
    $get_data = array_keys($_GET);
    $get_data = explode(",",$get_data[0]);
    print_array($get_data);
    $set_data["permit"]["f"][1][1][0]["w"] = ($get_data[3] == "true")?true:false;
    $set_data["permit"]["f"][1][1][0]["r"] = ($get_data[4] == "true")?true:false;
    $set_data["permit"]["f"][1][2][0]["w"] = ($get_data[5] == "true")?true:false;
    $set_data["permit"]["f"][1][2][0]["r"] = ($get_data[6] == "true")?true:false;
    $set_data["permit"]["f"][1][3][0]["w"] = ($get_data[7] == "true")?true:false;
    $set_data["permit"]["f"][1][3][0]["r"] = ($get_data[8] == "true")?true:false;
    $set_data["permit"]["f"][1][4][0]["w"] = ($get_data[9] == "true")?true:false;
    $set_data["permit"]["f"][1][4][0]["r"] = ($get_data[10] == "true")?true:false;
    $set_data["permit"]["f"][1][5][0]["w"] = ($get_data[11] == "true")?true:false;
    $set_data["permit"]["f"][1][5][0]["r"] = ($get_data[12] == "true")?true:false;

    $set_data["permit"]["f"][2][1][0]["w"] = ($get_data[14] == "true")?true:false;
    $set_data["permit"]["f"][2][1][0]["r"] = ($get_data[15] == "true")?true:false;
    $set_data["permit"]["f"][2][2][0]["w"] = ($get_data[16] == "true")?true:false;
    $set_data["permit"]["f"][2][2][0]["r"] = ($get_data[17] == "true")?true:false;
    $set_data["permit"]["f"][2][3][0]["w"] = ($get_data[18] == "true")?true:false;
    $set_data["permit"]["f"][2][3][0]["r"] = ($get_data[19] == "true")?true:false;
    $set_data["permit"]["f"][2][4][0]["w"] = ($get_data[20] == "true")?true:false;
    $set_data["permit"]["f"][2][4][0]["r"] = ($get_data[21] == "true")?true:false;

    $set_data["permit"]["f"][3][1][0]["w"] = ($get_data[23] == "true")?true:false;
    $set_data["permit"]["f"][3][1][0]["r"] = ($get_data[24] == "true")?true:false;
    $set_data["permit"]["f"][3][2][0]["w"] = ($get_data[25] == "true")?true:false;
    $set_data["permit"]["f"][3][2][0]["r"] = ($get_data[26] == "true")?true:false;

    $set_data["permit"]["f"][4][1][0]["w"] = ($get_data[28] == "true")?true:false;
    $set_data["permit"]["f"][4][1][0]["r"] = ($get_data[29] == "true")?true:false;

    $set_data["permit"]["f"][5][1][0]["w"] = ($get_data[31] == "true")?true:false;
    $set_data["permit"]["f"][5][1][0]["r"] = ($get_data[32] == "true")?true:false;
    $set_data["permit"]["f"][5][2][0]["w"] = ($get_data[33] == "true")?true:false;
    $set_data["permit"]["f"][5][2][0]["r"] = ($get_data[34] == "true")?true:false;
    $set_data["permit"]["f"][5][3][0]["w"] = ($get_data[35] == "true")?true:false;
    $set_data["permit"]["f"][5][3][0]["r"] = ($get_data[36] == "true")?true:false;
    $set_data["permit"]["f"][5][4][0]["w"] = ($get_data[37] == "true")?true:false;
    $set_data["permit"]["f"][5][4][0]["r"] = ($get_data[38] == "true")?true:false;
    $set_data["permit"]["f"][5][5][0]["w"] = ($get_data[39] == "true")?true:false;
    $set_data["permit"]["f"][5][5][0]["r"] = ($get_data[40] == "true")?true:false;

    $set_data["permit"]["f"][6][1][0]["w"] = ($get_data[42] == "true")?true:false;
    $set_data["permit"]["f"][6][1][0]["r"] = ($get_data[43] == "true")?true:false;
    $set_data["permit"]["f"][6][1][1]["w"] = ($get_data[44] == "true")?true:false;
    $set_data["permit"]["f"][6][1][1]["r"] = ($get_data[45] == "true")?true:false;
    $set_data["permit"]["f"][6][1][2]["w"] = ($get_data[46] == "true")?true:false;
    $set_data["permit"]["f"][6][1][2]["r"] = ($get_data[47] == "true")?true:false;
    $set_data["permit"]["f"][6][1][3]["w"] = ($get_data[48] == "true")?true:false;
    $set_data["permit"]["f"][6][1][3]["r"] = ($get_data[49] == "true")?true:false;
    $set_data["permit"]["f"][6][1][4]["w"] = ($get_data[50] == "true")?true:false;
    $set_data["permit"]["f"][6][1][4]["r"] = ($get_data[51] == "true")?true:false;
    $set_data["permit"]["f"][6][1][5]["w"] = ($get_data[52] == "true")?true:false;
    $set_data["permit"]["f"][6][1][5]["r"] = ($get_data[53] == "true")?true:false;
    $set_data["permit"]["f"][6][1][6]["w"] = ($get_data[54] == "true")?true:false;
    $set_data["permit"]["f"][6][1][6]["r"] = ($get_data[55] == "true")?true:false;
    $set_data["permit"]["f"][6][1][7]["w"] = ($get_data[56] == "true")?true:false;
    $set_data["permit"]["f"][6][1][7]["r"] = ($get_data[57] == "true")?true:false;
    $set_data["permit"]["f"][6][1][8]["w"] = ($get_data[58] == "true")?true:false;
    $set_data["permit"]["f"][6][1][8]["r"] = ($get_data[59] == "true")?true:false;
    $set_data["permit"]["f"][6][1][9]["w"] = ($get_data[60] == "true")?true:false;
    $set_data["permit"]["f"][6][1][9]["r"] = ($get_data[61] == "true")?true:false;
    $set_data["permit"]["f"][6][1][10]["w"] = ($get_data[62] == "true")?true:false;
    $set_data["permit"]["f"][6][1][10]["r"] = ($get_data[63] == "true")?true:false;
    $set_data["permit"]["f"][6][1][11]["w"] = ($get_data[64] == "true")?true:false;
    $set_data["permit"]["f"][6][1][11]["r"] = ($get_data[65] == "true")?true:false;
    $set_data["permit"]["f"][6][1][12]["w"] = ($get_data[66] == "true")?true:false;
    $set_data["permit"]["f"][6][1][12]["r"] = ($get_data[67] == "true")?true:false;

    $set_data["permit"]["f"][6][2][0]["w"] = ($get_data[68] == "true")?true:false;
    $set_data["permit"]["f"][6][2][0]["r"] = ($get_data[69] == "true")?true:false;
    $set_data["permit"]["f"][6][2][1]["w"] = ($get_data[70] == "true")?true:false;
    $set_data["permit"]["f"][6][2][1]["r"] = ($get_data[71] == "true")?true:false;
    $set_data["permit"]["f"][6][2][2]["w"] = ($get_data[72] == "true")?true:false;
    $set_data["permit"]["f"][6][2][2]["r"] = ($get_data[73] == "true")?true:false;
    $set_data["permit"]["f"][6][2][3]["w"] = ($get_data[74] == "true")?true:false;
    $set_data["permit"]["f"][6][2][3]["r"] = ($get_data[75] == "true")?true:false;
    $set_data["permit"]["f"][6][2][4]["w"] = ($get_data[76] == "true")?true:false;
    $set_data["permit"]["f"][6][2][4]["r"] = ($get_data[77] == "true")?true:false;
    $set_data["permit"]["f"][6][2][5]["w"] = ($get_data[78] == "true")?true:false;
    $set_data["permit"]["f"][6][2][5]["r"] = ($get_data[79] == "true")?true:false;
    $set_data["permit"]["f"][6][2][6]["w"] = ($get_data[80] == "true")?true:false;
    $set_data["permit"]["f"][6][2][6]["r"] = ($get_data[81] == "true")?true:false;

    $set_data["permit"]["f"][6][3][0]["w"] = ($get_data[82] == "true")?true:false;
    $set_data["permit"]["f"][6][3][0]["r"] = ($get_data[83] == "true")?true:false;
    $set_data["permit"]["f"][6][3][1]["w"] = ($get_data[84] == "true")?true:false;
    $set_data["permit"]["f"][6][3][1]["r"] = ($get_data[85] == "true")?true:false;
    $set_data["permit"]["f"][6][3][2]["w"] = ($get_data[86] == "true")?true:false;
    $set_data["permit"]["f"][6][3][2]["r"] = ($get_data[87] == "true")?true:false;
    $set_data["permit"]["f"][6][3][3]["w"] = ($get_data[88] == "true")?true:false;
    $set_data["permit"]["f"][6][3][3]["r"] = ($get_data[89] == "true")?true:false;

    $set_data["permit"]["f"][6][4][0]["w"] = ($get_data[90] == "true")?true:false;
    $set_data["permit"]["f"][6][4][0]["r"] = ($get_data[91] == "true")?true:false;
    $set_data["permit"]["f"][6][4][1]["w"] = ($get_data[92] == "true")?true:false;
    $set_data["permit"]["f"][6][4][1]["r"] = ($get_data[93] == "true")?true:false;
    $set_data["permit"]["f"][6][4][2]["w"] = ($get_data[94] == "true")?true:false;
    $set_data["permit"]["f"][6][4][2]["r"] = ($get_data[95] == "true")?true:false;
    $set_data["permit"]["f"][6][4][3]["w"] = ($get_data[96] == "true")?true:false;
    $set_data["permit"]["f"][6][4][3]["r"] = ($get_data[97] == "true")?true:false;
    $set_data["permit"]["f"][6][4][4]["w"] = ($get_data[98] == "true")?true:false;
    $set_data["permit"]["f"][6][4][4]["r"] = ($get_data[99] == "true")?true:false;
    $set_data["permit"]["f"][6][4][5]["w"] = ($get_data[100] == "true")?true:false;
    $set_data["permit"]["f"][6][4][5]["r"] = ($get_data[101] == "true")?true:false;
    $set_data["permit"]["f"][6][5][0]["w"] = ($get_data[102] == "true")?true:false;
    $set_data["permit"]["f"][6][5][0]["r"] = ($get_data[103] == "true")?true:false;
    $set_data["permit"]["f"][6][5][1]["w"] = ($get_data[104] == "true")?true:false;
    $set_data["permit"]["f"][6][5][1]["r"] = ($get_data[105] == "true")?true:false;
    $set_data["permit"]["f"][6][5][2]["w"] = ($get_data[106] == "true")?true:false;
    $set_data["permit"]["f"][6][5][2]["r"] = ($get_data[107] == "true")?true:false;
    $set_data["permit"]["f"][6][5][3]["w"] = ($get_data[108] == "true")?true:false;
    $set_data["permit"]["f"][6][5][3]["r"] = ($get_data[109] == "true")?true:false;
    $set_data["permit"]["f"][6][5][4]["w"] = ($get_data[110] == "true")?true:false;
    $set_data["permit"]["f"][6][5][4]["r"] = ($get_data[111] == "true")?true:false;
    $set_data["permit"]["f"][6][5][5]["w"] = ($get_data[112] == "true")?true:false;
    $set_data["permit"]["f"][6][5][5]["r"] = ($get_data[113] == "true")?true:false;

    $form->setDefaults($set_data);
}


/****************************/
// スタッフID有＋権限があれば
/***************************/
if ($_GET["staff_id"] != null && $_POST["form_set_button"] == null){
    $sql = "SELECT * FROM t_permit WHERE staff_id = $staff_id;";
    $res = Db_Query($db_con, $sql);
    $ary_permit_data = (pg_num_rows($res) != 0) ? pg_fetch_array($res, 0, PGSQL_ASSOC) : null;

    $permit_col = Permit_Col("head");

    if ($ary_permit_data != null){
        $ary_type = array("h", "f");
        while (List($key, $value) = Each($ary_permit_data)){
            for ($i=0; $i<count($ary_type); $i++){
                for ($j=1; $j<=count($permit_col[$ary_type[$i]]); $j++){
                    for ($k=1; $k<=count($permit_col[$ary_type[$i]][$j]); $k++){
                        for ($l=0; $l<count($permit_col[$ary_type[$i]][$j][$k]); $l++){
                            if (in_array($key, $permit_col[$ary_type[$i]][$j][$k][$l])){
                                $def_fdata["permit"][$ary_type[$i]][$j][$k][$l][$value] = true;
                            }
                        }
                    }
                }
            }
        }
        $def_fdata["permit_delete"] = ($ary_permit_data["del_flg"] == "t") ? true : false;
        $def_fdata["permit_accept"] = ($ary_permit_data["accept_flg"] == "t") ? true : false;
        $form->setConstants($def_fdata);

    }


    

}
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
//$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
//$page_header = Create_Header($page_title);


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
    'js_data'       => "$js_data",
    'charge_cd'     => stripslashes(htmlspecialchars($charge_cd)),
    'staff_name'    => stripslashes(htmlspecialchars($staff_name)),
    'auth_r_msg'    => "$auth_r_msg",
    'h_rowspan'         => $h_rowspan,
    'h_menu_rowspan'    => $h_menu_rowspan,
    'h_submenu_rowspan' => $h_submenu_rowspan,
    'f_rowspan'         => $f_rowspan,
    'f_menu_rowspan'    => $f_menu_rowspan,
    'f_submenu_rowspan' => $f_submenu_rowspan,
));

$smarty->assign("ary_h_mod_data", $ary_h_mod_data);
$smarty->assign("ary_f_mod_data", $ary_f_mod_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>

