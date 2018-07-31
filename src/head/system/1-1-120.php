<?php

/**
 *　履歴
 *  2007/02/19           watanabe-k  印刷ボタン削除
 *   2016/01/21                amano  Button_Submit_1 関数でボタン名が送られない IE11 バグ対応
**/

$page_title = "ユーザ権限設定";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
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

/* GETしたIDの正当性チェック */
if ($staff_id != null && !ereg("^[0-9]+$", $staff_id)){
    header("Location: ../top.php");
    exit;       
}   
if ($staff_id != null && Get_Id_Check_Db($db_con, $staff_id, "staff_id", "t_staff", "num") != true){
    header("Location: ../top.php");
    exit;
}

/* 本部変更不可能フラグを確認 */
if ($staff_id != null){
    $sql = "SELECT h_change_flg FROM t_staff WHERE staff_id = $staff_id;";
    $res = Db_Query($db_con, $sql);
    $h_change_ng_flg = (pg_fetch_result($res, 0) == "t") ? true : false;
}

/****************************/
// フォームパーツ作成
/****************************/
/*** 本部チェック項目の配列作成 ***/
if ($_POST["form_staff_kind"] == "1"){
    $type = "fc";
}else
if ($_POST["form_staff_kind"] == "4"){
    $type = "head";
}
$ary_mod_data = Permit_Item($type);
$ary_h_mod_data = $ary_mod_data[0];

/*** 本部チェックボックス要素の個数設定 ***/
// メニュー数
$ary_h[0] = count($ary_h_mod_data);
for ($i = 0; $i < $ary_h[0]; $i++){
    // 各メニュー内のサブメニュー数
    $ary_h[1][$i] = count($ary_h_mod_data[$i][1]);
    for ($j = 0; $j < $ary_h[1][$i]; $j++){
        // 各サブメニュー内のチェックボックス数
        $ary_h[2][$i][$j] = count($ary_h_mod_data[$i][1][$j][1]);
    }
}

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
    $js_opt_h  = "['h', ".$ary_h[0].", ";
    foreach ($ary_h[1] as $key => $value){
        $js_opt_h .= ($key == 0) ? "[" : null;
        $js_opt_h .= $value;
        $js_opt_h .= ($ary_h[0]-1 != $key) ? ", " : "], ";
    }
    foreach ($ary_h[2] as $key1 => $value1){
        $js_opt_h .= ($key1 == 0) ? "[" : null;
        foreach ($value1 as $key2 => $value2){
            $js_opt_h .= ($key2 == 0) ? "[" : null;
            $js_opt_h .= $value2;
            $js_opt_h .= ($ary_h[1][$key1]-1 != $key2) ? ", " : "]";
        }
        $js_opt_h .= (count($ary_h[1])-1 != $key1) ? ", " : "]";
    }
    $js_opt_h .= ", '".$ary_opt[$i]."']";
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[h][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[h][0][0][0][".$ary_opt[$i]."]', $js_opt_h);\"");
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
        foreach ($ary_h[2] as $key1 => $value1){
            $num = (int)$key1+1;
            $js_opt_sub = null;
            foreach ($value1 as $key2 => $value2){
                $js_opt_sub .= (count($value1)-1 != $key2) ? "$value2, " : "$value2";
            }
            $form->addElement("checkbox", "permit[h][".$num."][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][".$num."][0][0][".$ary_opt[$i]."]', ['h', ".$num.", ".$ary_h[1][$key1].", [".$js_opt_sub."], '".$ary_opt[$i]."']);\"");
        }
    }else{
        foreach ($ary_h[2] as $key => $value){
            $num = (int)$key+1;
            $form->addElement("hidden", "permit[h][".$num."][0][0][".$ary_opt[$i]."]", "");
        }
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
$ary_f_mod_data = $ary_mod_data[1];

/*** FCチェックボックス要素の個数設定 ***/
// メニュー数
$ary_f[0] = count($ary_f_mod_data);
for ($i = 0; $i < $ary_f[0]; $i++){
    // 各メニュー内のサブメニュー数
    $ary_f[1][$i] = count($ary_f_mod_data[$i][1]);
    for ($j = 0; $j < $ary_f[1][$i]; $j++){
        // 各サブメニュー内のチェックボックス数
        $ary_f[2][$i][$j] = count($ary_f_mod_data[$i][1][$j][1]);
    }
}

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
    // // jsの第2引数説明
    // // [0]: 本部かFCか
    // // [1]: メニュー数を配列で
    // // [2]: メニュー毎のサブメニュー数を配列で
    // // [3]: メニュー毎のサブメニュー毎の項目数を配列で
    $js_opt_f  = "['f', ".$ary_f[0].", ";
    foreach ($ary_f[1] as $key => $value){
        $js_opt_f .= ($key == 0) ? "[" : null;
        $js_opt_f .= $value;
        $js_opt_f .= ($ary_f[0]-1 != $key) ? ", " : "], ";
    }
    foreach ($ary_f[2] as $key1 => $value1){
        $js_opt_f .= ($key1 == 0) ? "[" : null;
        foreach ($value1 as $key2 => $value2){
            $js_opt_f .= ($key2 == 0) ? "[" : null;
            $js_opt_f .= $value2;
            $js_opt_f .= ($ary_f[1][$key1]-1 != $key2) ? ", " : "]";
        }
        $js_opt_f .= (count($ary_f[1])-1 != $key1) ? ", " : "]";
    }
    $js_opt_f .= ", '".$ary_opt[$i]."']";
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[f][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[f][0][0][0][".$ary_opt[$i]."]', $js_opt_f);\"");
    }else{
        $form->addElement("hidden", "permit[f][0][0][0][".$ary_opt[$i]."]", "");
    }

    // FCメニューチェック
    // // jsの第2引数説明
    // // [0]: 本部かFCか
    // // [1]: メニュー番号
    // // [2]: サブメニュー数を配列で
    // // [3]: サブメニュー毎の項目数を配列で
    if ($ary_opt[$i] != "n"){
        foreach ($ary_f[2] as $key1 => $value1){
            $num = (int)$key1+1;
            $js_opt_sub = null;
            foreach ($value1 as $key2 => $value2){
                $js_opt_sub .= (count($value1)-1 != $key2) ? "$value2, " : "$value2";
            }
            $form->addElement("checkbox", "permit[f][".$num."][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][".$num."][0][0][".$ary_opt[$i]."]', ['f', ".$num.", ".$ary_f[1][$key1].", [".$js_opt_sub."], '".$ary_opt[$i]."']);\"");
        }
    }else{
        foreach ($ary_f[2] as $key => $value){
            $num = (int)$key+1;
            $form->addElement("hidden", "permit[f][".$num."][0][0][".$ary_opt[$i]."]", "");
        }
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
if ($h_change_ng_flg != true){
    $form->addElement("submit", "form_set_button", "設　定", "
        onClick=\"javascript:Button_Submit_1('set_permit_flg', './1-1-109.php?staff_id=$staff_id', 'true', this);\"
        $disabled
    ");
}

// 戻るボタン
$form->addElement("button", "form_return_button", "戻　る", "
    onClick=\"javascript:Button_Submit_1('permit_rtn_flg', './1-1-109.php?staff_id=$staff_id', 'true', this);\"
");

$form->addElement("hidden", "set_permit_flg");
$form->addElement("hidden", "permit_rtn_flg");


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
$form->addElement("hidden", "form_part[0]", "");
$form->addElement("hidden", "form_part[1]", "");
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
$form->addElement("hidden", "form_round_staff", "");
$form->addElement("hidden", "hdn_staff_id");


/****************************/
// フォームデフォルト値設定
/****************************/
// スタッフID有＋権限があれば
if ($_GET["staff_id"] != null && $_POST["form_set_button"] == null && $_POST["set_permit_flg"] != "true"){
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


/****************************/
// 本部による変更が不可のスタッフの場合はフリーズ
/****************************/
if ($h_change_ng_flg == true){
    $form->freeze();
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
