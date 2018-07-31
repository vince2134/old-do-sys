<?php
$page_title = "ユーザ権限設定";

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

PRINT_HTML_SRC;


/****************************/
// 外部パラメータ取得
/****************************/
// スタッフID
$staff_id   = $_GET["staff_id"];

// 担当者コード
$charge_cd  = $_POST["form_charge_cd"];

// スタッフ名
$staff_name = $_POST["form_staff_name"];

//　スタッフ登録以外からの遷移はTOPへ遷移させる
//if ($_POST["staff_url"] == null){
//    header("Location: ../top.php");
//}

/****************************/
// フォームパーツ作成
/****************************/
/*** 本部チェック項目の配列作成 ***/
$ary_h_mod_data = array(
    "0" =>  array(
        "0" =>  "売上管理",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "受注取引",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "月例清算販売書",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "売上取引",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "請求管理",
                "1" =>  array(),
            ),
            "4" =>  array(
                "0" =>  "入金管理",
                "1" =>  array(),
            ),
            "5" =>  array(
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
                "0" =>  "本部管理マスタ",
                "1" =>  array("業種", "業態", "施設", "サービス", "構成品",),
            ),
            "1" =>  array(
                "0" =>  "一部共有マスタ",
                "1" =>  array("スタッフ", "Ｍ区分", "管理区分", "商品分類", "商品",),
            ),  
            "2" =>  array(
                "0" =>  "個別マスタ",
                "1" =>  array("部署", "倉庫", "地区", "銀行", "製造品", "FC区分", "FC", "得意先", "契約", "仕入先", "直送先", "運送業者",),
            ),
            "3" =>  array(
                "0" =>  "帳票設定",
                "1" =>  array(
                    "発注書コメント", "注文書フォーマット", "売上伝票", "納品書", "請求書",),
            ),
            "4" =>  array(
                "0" =>  "システム設定",
                "1" =>  array("本部プロフィール", "買掛残高初期設定", "売掛残高初期設定", "請求残高初期設定", "パスワード変更",),
            ),
        ),
    ),
);

/*** 本部チェックボックス要素の個数設定 ***/
// メニュー数
$ary_h[0] = 6;
// 各メニュー内のサブメニュー数
$ary_h[1] = array(6, 4, 2, 1, 5, 5);
// 各サブメニュー内のチェックボックス数
$ary_h[2] = array(
    0 => array(0, 0, 0, 0, 0, 0),
    1 => array(0, 0, 0, 0),
    2 => array(0, 0),
    3 => array(0),
    4 => array(0, 0, 0, 0, 0),
    5 => array(5, 5, 12, 5, 5),
);

// rowspan算出
$h_rowspan = 0;
for ($i=0; $i<count($ary_h[2]); $i++){
    $h_rowspan++;
    $h_menu_rowspan[$i] = count($ary_h[2][$i]) + array_sum($ary_h[2][$i]);
    for ($j=0; $j<count($ary_h[2][$i]); $j++){
        $h_rowspan++;
        $h_rowspan += $ary_h[2][$i][$j];
    }
}
$h_submenu_rowspan = $ary_h[2];


$ary_opt  = array("r", "w", "n");
for ($i=0; $i<count($ary_opt); $i++){

    // 本部トップチェック
    // // jsの第2引数説明
    // // [0]: 本部かFCか
    // // [1]: メニュー数を配列で
    // // [2]: メニュー毎のサブメニュー数を配列で
    // // [3]: メニュー毎のサブメニュー毎の項目数を配列で
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[h][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[h][0][0][0][".$ary_opt[$i]."]', ['h', 6, [6, 4, 2, 1, 5, 5], [[0, 0, 0, 0, 0, 0], [0, 0, 0, 0], [0, 0], [0], [0, 0, 0, 0, 0], [5, 5, 12, 5, 5]], '".$ary_opt[$i]."']);\"");
    }else{
        $form->addElement("hidden", "permit[h][0][0][0][".$ary_opt[$i]."]", "");
    }

    // 本部メニューチェック
    // // jsの第2引数説明
    // // [0]: 本部かFCか
    // // [1]: メニュー番号
    // // [2]: サブメニュー数を配列で
    // // [3]: サブメニュー毎の項目数を配列で
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[h][1][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][1][0][0][".$ary_opt[$i]."]', ['h', 1, 6, [0, 0, 0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][2][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][2][0][0][".$ary_opt[$i]."]', ['h', 2, 4, [0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][3][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][3][0][0][".$ary_opt[$i]."]', ['h', 3, 2, [0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][4][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][4][0][0][".$ary_opt[$i]."]', ['h', 4, 1, [0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][5][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][5][0][0][".$ary_opt[$i]."]', ['h', 5, 5, [0, 0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][6][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][6][0][0][".$ary_opt[$i]."]', ['h', 6, 5, [5, 5, 12, 5, 5], '".$ary_opt[$i]."']);\"");
    }else{
        $form->addElement("hidden", "permit[h][1][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][2][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][3][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][4][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][5][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][6][0][0][".$ary_opt[$i]."]", "");
    }
}

$ary_opt  = array("r", "w", "n");
// 本部サブメニュー以下チェック
for ($i=1; $i<=$ary_h[0]; $i++){
    for ($j=1; $j<=$ary_h[1][$i-1]; $j++){
        for ($k=0; $k<=$ary_h[2][$i-1][$j-1]; $k++){
            for ($l=0; $l<count($ary_opt); $l++){
                $me = "permit[h][$i][$j][$k][$ary_opt[$l]]";
                if ($ary_opt[$l] != "n"){
                    if ($k == 0){
                        $js = "onClick=\"javascript: Allcheck_Submenu2('$me', ['h', $i, $j, ".$ary_h[2][$i-1][$j-1].", '$ary_opt[$l]']);\"";
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
                "1" =>  array("部署", "倉庫", "地区", "銀行", "コース", "得意先", "契約", "仕入先", "直送先", "運送業者",),
            ),
            "1" =>  array(
                "0" =>  "一部共有マスタ",
                "1" =>  array("スタッフ", "Ｍ区分", "管理区分", "商品分類", "商品",),
            ),
            "2" =>  array(
                "0" =>  "帳票設定",
                "1" =>  array("発注書コメント", "売上伝票", "請求書",),
            ),
            "3" =>  array(
                "0" =>  "システム設定",
                "1" =>  array("自社プロフィール", "買掛残高初期設定", "売掛残高初期設定", "請求残高初期設定", "パスワード変更", "休日設定",),
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
    5 => array(10, 5, 3, 6, 5)
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
        $form->addElement("checkbox", "permit[f][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[f][0][0][0][".$ary_opt[$i]."]', ['f', 6, [5, 4, 2, 1, 5, 5], [[0, 0, 0, 0, 0], [0, 0, 0, 0], [0, 0], [0], [0, 0, 0, 0, 0], [10, 5, 3, 6, 5]], '".$ary_opt[$i]."']);\"");
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
        $form->addElement("checkbox", "permit[f][6][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][6][0][0][".$ary_opt[$i]."]', ['f', 6, 5, [10, 5, 3, 6, 5], '".$ary_opt[$i]."']);\"");
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

// 削除権限を付与するチェック
$form->addElement("checkbox", "permit_delete", "", "");

// 承認権限を付与するチェック
$form->addElement("checkbox", "permit_accept", "", "");

// 設定ボタン
$form->addElement("submit", "form_set_button", "設　定", "onClick=\"return Dialogue('設定します。','1-1-109-2.php?staff_id=$staff_id');\" $disabled");

// 印刷ボタン
$form->addElement("button", "form_print_button", "印　刷", "onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-124.php','_blank','')\"");

// 戻るボタン
$form->addElement("button", "form_return_button", "戻　る", "onClick=\"javascript:history.back()\"");


/****************************/
// フォームパーツ定義 - スタッフマスタ
/****************************/
$form->addElement("hidden", "form_staff_kind", "");
$form->addElement("hidden", "form_cshop_head", "");
$form->addElement("hidden", "form_cshop", "");
$form->addElement("hidden", "form_state", "");
$form->addElement("hidden", "form_change_flg", "");
$form->addElement("hidden", "form_staff_cd[cd1]", "");
$form->addElement("hidden", "form_staff_cd[cd2]", "");
$form->addElement("hidden", "form_staff_name", "");
$form->addElement("hidden", "form_photo_ref", "");
$form->addElement("hidden", "form_photo_del", "");
$form->addElement("hidden", "form_staff_read", "");
$form->addElement("hidden", "form_staff_ascii", "");
$form->addElement("hidden", "form_sex", "");
$form->addElement("hidden", "form_birth_day[y]", "");
$form->addElement("hidden", "form_birth_day[m]", "");
$form->addElement("hidden", "form_birth_day[d]", "");
$form->addElement("hidden", "form_retire_day[y]", "");
$form->addElement("hidden", "form_retire_day[m]", "");
$form->addElement("hidden", "form_retire_day[d]", "");
$form->addElement("hidden", "form_study", "");
$form->addElement("hidden", "form_toilet_license", "");
$form->addElement("hidden", "form_charge_cd", "");
$form->addElement("hidden", "form_join_day[y]", "");
$form->addElement("hidden", "form_join_day[m]", "");
$form->addElement("hidden", "form_join_day[d]", "");
$form->addElement("hidden", "form_employ_type", "");
$form->addElement("hidden", "form_part_head", "");
$form->addElement("hidden", "form_part", "");
$form->addElement("hidden", "form_section_head", "");
$form->addElement("hidden", "form_section", "");
$form->addElement("hidden", "form_position", "");
$form->addElement("hidden", "form_job_type", "");
$form->addElement("hidden", "form_ware_head", "");
$form->addElement("hidden", "form_ware", "");
$form->addElement("hidden", "form_license", "");
$form->addElement("hidden", "form_note", "");
$form->addElement("hidden", "form_login_info", "");
$form->addElement("hidden", "form_login_id", "");
$form->addElement("hidden", "form_password1", "");
$form->addElement("hidden", "form_password2", "");


/****************************/
// フォームデフォルト値設定
/****************************/
// スタッフID有＋権限があれば
if ($_GET["staff_id"] != null && $_POST["form_set_button"] == null){
    $sql = "SELECT * FROM t_permit WHERE staff_id = $staff_id;";
    $res = Db_Query($db_con, $sql);
    $ary_permit_data = (pg_num_rows($res) != 0) ? pg_fetch_array($res, 0, PGSQL_ASSOC) : null;

    /*** 本部　権限チェック項目<->権限テーブルカラム名 対応一覧 ***/
    /* 売上管理 */
    // 売上管理 - 受注取引
    $permit_col["h"][1][1][0]   = array("h_2_101", "h_2_102", "h_2_103", "h_2_104", "h_2_105", "h_2_106", "h_2_107", "h_2_108", "h_2_109");
    // 売上管理 - 月例清算販売書
    $permit_col["h"][1][2][0]   = array(null);
    // 売上管理 - 売上取引
    $permit_col["h"][1][3][0]   = array("h_2_201", "h_2_202", "h_2_203", "h_2_205", "h_2_206", "h_2_207", "h_2_208");
    // 売上管理 - 請求管理
    $permit_col["h"][1][4][0]   = array("h_2_301", "h_2_302", "h_2_303", "h_2_304", "h_2_305", "h_2_306");
    // 売上管理 - 入金管理
    $permit_col["h"][1][5][0]   = array("h_2_401", "h_2_402", "h_2_403", "h_2_404", "h_2_406");
    // 売上管理 - 実績管理
    $permit_col["h"][1][6][0]   = array("h_2_501", "h_2_502", "h_2_503", "h_2_504");

    /* 仕入管理 */
    // 仕入管理 - 発注取引
    $permit_col["h"][2][1][0]   = array("h_3_101", "h_3_102", "h_3_104", "h_3_105", "h_3_106", "h_3_111");
    // 仕入管理 - 仕入取引
    $permit_col["h"][2][2][0]   = array("h_3_201", "h_3_202", "h_3_203", "h_3_205");
    // 仕入管理 - 支払管理
    $permit_col["h"][2][3][0]   = array("h_3_301", "h_3_302", "h_3_303", "h_3_304", "h_3_306");
    // 仕入管理 - 実績管理
    $permit_col["h"][2][4][0]   = array("h_3_401", "h_3_402", "h_3_403", "h_3_404");

    /* 在庫管理 */
    // 在庫管理 - 在庫取引
    $permit_col["h"][3][1][0]   = array("h_4_101", "h_4_102", "h_4_104", "h_4_105", "h_4_106", "h_4_107", "h_4_108", "h_4_109", "h_4_110", "h_4_111", "h_4_112", "h_4_114");
    // 在庫管理 - 棚卸管理
    $permit_col["h"][3][2][0]   = array("h_4_201", "h_4_202", "h_4_204", "h_4_205", "h_4_206", "h_4_207", "h_4_208", "h_4_209");

    /* 更新 */
    // 更新管理
    $permit_col["h"][4][1][0]   = array("h_5_101", "h_5_102", "h_5_103", "h_5_104", "h_5_105", "h_5_106", "h_5_107", "h_5_108", "h_5_109");

    /* データ出力 */
    // データ出力 - 統計情報
    $permit_col["h"][5][1][0]   = array("h_6_132", "h_6_131", "h_6_133", "h_6_135", "h_6_143");
    // データ出力 - 売上推移
    $permit_col["h"][5][2][0]   = array("h_6_101", "h_6_103", "h_6_104", "h_6_105", "h_6_106", "h_6_107", "h_6_108");
    // データ出力 - ABC分析
    $permit_col["h"][5][3][0]   = array("h_6_110", "h_6_111", "h_6_112", "h_6_113", "h_6_114");
    // データ出力 - 仕入推移
    $permit_col["h"][5][4][0]   = array("h_6_121", "h_6_122");
    // データ出力 - CSV出力
    $permit_col["h"][5][5][0]   = array("h_6_301", "h_6_302", "h_6_303");

    /* マスタ設定 */
    // マスタ・設定 - 本部管理マスタ
    $permit_col["h"][6][1][0]   = array(null);
    $permit_col["h"][6][1][1]   = array("h_1_205");// 業種
    $permit_col["h"][6][1][2]   = array("h_1_234");// 業態
    $permit_col["h"][6][1][3]   = array("h_1_233");// 施設
    $permit_col["h"][6][1][4]   = array("h_1_231", "h_1_232");// サービス
    $permit_col["h"][6][1][5]   = array("h_1_229", "h_1_230");// 構成品
    // マスタ・設定 - 一部共有マスタ
    $permit_col["h"][6][2][0]   = array(null);
    $permit_col["h"][6][2][1]   = array("h_1_107", "h_1_108", "h_1_109", "h_1_110", "h_1_120", "h_1_124");// スタッフ
    $permit_col["h"][6][2][2]   = array("h_1_211");// Ｍ区分
    $permit_col["h"][6][2][3]   = array("h_1_209");// 管理区分
    $permit_col["h"][6][2][4]   = array(null);// 商品分類
    $permit_col["h"][6][2][5]   = array("h_1_220", "h_1_221", "h_1_222");// 商品
    // マスタ・設定 - 個別マスタ
    $permit_col["h"][6][3][0]   = array(null);
    $permit_col["h"][6][3][1]   = array("h_1_201");// 部署
    $permit_col["h"][6][3][2]   = array("h_1_203");// 倉庫
    $permit_col["h"][6][3][3]   = array("h_1_213");// 地区
    $permit_col["h"][6][3][4]   = array("h_1_207", "h_1_208");// 銀行
    $permit_col["h"][6][3][5]   = array("h_1_223", "h_1_224");// 製造品
    $permit_col["h"][6][3][6]   = array("h_1_227");// FC区分
    $permit_col["h"][6][3][7]   = array("h_1_101", "h_1_102", "h_1_103");// FC
    $permit_col["h"][6][3][8]   = array("h_1_113", "h_1_114", "h_1_111", "h_1_115");// 得意先
    $permit_col["h"][6][3][9]   = array("h_1_116", "h_1_123", "h_1_104", "h_1_105", "h_1_119", "h_1_106", "h_1_112");// 契約
    $permit_col["h"][6][3][10]  = array("h_1_215", "h_1_216", "h_1_217");// 仕入先
    $permit_col["h"][6][3][11]  = array("h_1_218", "h_1_219");// 直送先
    $permit_col["h"][6][3][12]  = array("h_1_225");// 運送業者
    // マスタ・設定 - 帳票設定
    $permit_col["h"][6][4][0]   = array(null);
    $permit_col["h"][6][4][1]   = array("h_1_303");// 発注書コメント
    $permit_col["h"][6][4][2]   = array("h_1_304");// 注文書フォーマット
    $permit_col["h"][6][4][3]   = array("h_1_311");// 売上伝票
    $permit_col["h"][6][4][4]   = array("h_1_312");// 納品書
    $permit_col["h"][6][4][5]   = array("h_1_310");// 請求書
    // マスタ・設定 - システム設定
    $permit_col["h"][6][5][0]   = array(null);
    $permit_col["h"][6][5][1]   = array("h_1_301");// 本部プロフィール
    $permit_col["h"][6][5][2]   = array("h_1_305");// 買掛残高初期設定
    $permit_col["h"][6][5][3]   = array("h_1_306");// 売掛残高初期設定
    $permit_col["h"][6][5][4]   = array("h_1_307");// 請求残高初期設定
    $permit_col["h"][6][5][5]   = array("h_1_302");// パスワード変更

    /*** FC　権限チェック項目<->権限テーブルカラム名 対応一覧 ***/
    /* 売上管理 */
    // 売上管理 - 予定取引 
    $permit_col["f"][1][1][0]   = array("f_2_101", "f_2_102", "f_2_103", "f_2_115", "f_2_104", "f_2_106", "f_2_107", "f_2_108", "f_2_111", "f_2_112", "f_2_113", "f_2_114");
    // 売上管理 - 売上取引
    $permit_col["f"][1][2][0]   = array("f_2_201", "f_2_202", "f_2_204", "f_2_205", "f_2_206", "f_2_207", "f_2_208", "f_2_209", "f_2_210", "f_2_211", "f_2_212", "f_2_213", "f_2_214");
    // 売上管理 - 請求管理 
    $permit_col["f"][1][3][0]   = array("f_2_301", "f_2_302", "f_2_303", "f_2_304", "f_2_305", "f_2_306");
    // 売上管理 - 入金管理 
    $permit_col["f"][1][4][0]   = array("f_2_401", "f_2_402", "f_2_403", "f_2_404", "f_2_406");
    // 売上管理 - 実績管理 
    $permit_col["f"][1][5][0]   = array("f_2_501", "f_2_502", "f_2_503", "f_2_504");

    /* 仕入管理 */
    // 仕入管理 - 発注取引
    $permit_col["f"][2][1][0]   = array("f_3_101", "f_3_102", "f_3_103", "f_3_104", "f_3_105", "f_3_107", "f_3_106", "f_3_111");
    // 仕入管理 - 仕入取引
    $permit_col["f"][2][2][0]   = array("f_3_201", "f_3_202", "f_3_203", "f_3_205");
    // 仕入管理 - 支払管理
    $permit_col["f"][2][3][0]   = array("f_3_301", "f_3_302", "f_3_303", "f_3_304", "f_3_306");
    // 仕入管理 - 実績管理
    $permit_col["f"][2][4][0]   = array("f_3_401", "f_3_402", "f_3_403", "f_3_404");

    /* 在庫管理 */
    // 在庫管理 - 在庫取引
    $permit_col["f"][3][1][0]   = array("f_4_101", "f_4_102", "f_4_105", "f_4_106", "f_4_107", "f_4_108", "f_4_109", "f_4_110", "f_4_111", "f_4_113");
    // 在庫管理 - 棚卸管理
    $permit_col["f"][3][2][0]   = array("f_4_201", "f_4_202", "f_4_204", "f_4_205", "f_4_206", "f_4_207", "f_4_208", "f_4_209");

    /* 更新 */
    // 更新 - 更新管理
    $permit_col["f"][4][1][0]   = array("f_5_101", "f_5_102", "f_5_103", "f_5_104", "f_5_105", "f_5_106", "f_5_107", "f_5_108", "f_5_109");

    /* データ出力 */
    // データ出力 - 統計情報
    $permit_col["f"][5][1][0]   = array("f_6_132", "f_6_131", "f_6_135", "f_6_137", "f_6_151", "f_6_153");
    // データ出力 - 売上推移
    $permit_col["f"][5][2][0]   = array("f_6_100", "f_6_101", "f_6_103", "f_6_104", "f_6_106", "f_6_108");
    // データ出力 - ABC分析
    $permit_col["f"][5][3][0]   = array("f_6_110", "f_6_112", "f_6_114");
    // データ出力 - 仕入推移
    $permit_col["f"][5][4][0]   = array("f_6_121", "f_6_122");
    // データ出力 - CSV出力
    $permit_col["f"][5][5][0]   = array("f_6_201", "f_6_202", "f_6_203");

    /* マスタ・設定 */
    // マスタ・設定 - 個別マスタ
    $permit_col["f"][6][1][0]   = array(null);
    $permit_col["f"][6][1][1]   = array("f_1_201");// 部署
    $permit_col["f"][6][1][2]   = array("f_1_203");// 倉庫
    $permit_col["f"][6][1][3]   = array("f_1_213");// 地区
    $permit_col["f"][6][1][4]   = array("f_1_207", "f_1_208");// 銀行
    $permit_col["f"][6][1][5]   = array("f_1_227");// コース
    $permit_col["f"][6][1][6]   = array("f_1_101", "f_1_102", "f_1_103", "f_1_106");// 得意先
    $permit_col["f"][6][1][7]   = array("f_1_111", "f_1_115", "f_1_104", "f_1_105", "f_1_114");// 契約
    $permit_col["f"][6][1][8]   = array("f_1_215", "f_1_216", "f_1_217");// 仕入先
    $permit_col["f"][6][1][9]   = array("f_1_218", "f_1_219");// 直送先
    $permit_col["f"][6][1][10]  = array("f_1_225");// 運送業者
    // マスタ・設定 - 一部共有マスタ
    $permit_col["f"][6][2][0]   = array(null);
    $permit_col["f"][6][2][1]   = array("f_1_107", "f_1_108", "f_1_110", "f_1_112", "f_1_124");// スタッフ
    $permit_col["f"][6][2][2]   = array("f_1_211");// Ｍ区分
    $permit_col["f"][6][2][3]   = array(null);// 管理区分
    $permit_col["f"][6][2][4]   = array(null);// 商品分類
    $permit_col["f"][6][2][5]   = array("f_1_220", "f_1_221", "f_1_222");// 商品
    // マスタ・設定 - 帳票設定
    $permit_col["f"][6][3][0]   = array(null);
    $permit_col["f"][6][3][1]   = array("f_1_303");// 発注書コメント
    $permit_col["f"][6][3][2]   = array("f_1_308");// 売上伝票
    $permit_col["f"][6][3][3]   = array("f_1_307");// 請求書
    // マスタ・設定 - システム設定
    $permit_col["f"][6][4][0]   = array(null);
    $permit_col["f"][6][4][1]   = array("f_1_301");// 自社プロフィール
    $permit_col["f"][6][4][2]   = array("f_1_304");// 買掛残高初期設定
    $permit_col["f"][6][4][3]   = array("f_1_305");// 売掛残高初期設定
    $permit_col["f"][6][4][4]   = array("f_1_306");// 請求残高初期設定
    $permit_col["f"][6][4][5]   = array("f_1_302");// パスワード変更
    $permit_col["f"][6][4][6]   = array(null);// 休日設定
    // マスタ・設定 - 本部管理マスタ
    $permit_col["f"][6][5][0]   = array(null);
    $permit_col["f"][6][5][1]   = array("f_1_231");// 業種
    $permit_col["f"][6][5][2]   = array("f_1_234");// 業態
    $permit_col["f"][6][5][3]   = array("f_1_233");// 施設
    $permit_col["f"][6][5][4]   = array(null);// サービス
    $permit_col["f"][6][5][5]   = array(null);// 構成品

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
    'js_data'       => "$js_data",
    'charge_cd'     => "$charge_cd",
    'staff_name'    => "$staff_name",
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
