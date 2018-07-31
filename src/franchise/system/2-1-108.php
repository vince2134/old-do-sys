<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/16) 所属マスタの追加・更新処理の追加(suzuki-t)
 *       (2006/05/26) 変更できない項目を変更
 *       (2006/08/09) 部署が変更できないバグ修正
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.0.0 (2006/03/16)
*/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/25      21-040      ふ          スタッフ名にスペースのみの登録が可能なバグを修正
 *  2006-12-08      ban_0092    suzuki      削除時にログに残すように修正
 *  2007-02-09                  watanabe-k　担当倉庫の登録処理を追加
 *  2007/03/30      B0702-018   kajioka-h   group_kindの判定式が「=」になっていたのを「==」に修正
 *  2007/06/25                  fukuda      担当者コードに文字列を入力するとチェック処理のクエリエラーが発生する不具合の修正
 *  2007/09/03      0709問合せ3 kajioka-h   スタッフ削除時にDBの参照整合性エラーを出ないように関数を使わないよう変更
 *
 */


/****************************/
// ページ内初期設定
/****************************/
$page_title = "スタッフマスタ";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
// 外部パラメータ取得
/****************************/
// スタッフID（GET）
if ($_GET["staff_id"] != null){
    $staff_id = $_GET["staff_id"];
}else
// スタッフID（POST）
if ($_POST["form_staff_id"] != null){
    $staff_id = $_POST["form_staff_id"];
}

// SESSION
$client_id      = $_SESSION["client_id"];           // ショップID
$ss_staff_id    = $_SESSION["staff_id"];            // スタッフID（自分）
$rank_cd        = $_SESSION["rank_cd"];             //顧客区分CD
$group_kind     = $_SESSION["group_kind"];          //グループ種別

/* GETした値が正当かチェック */
if ($staff_id != null){
    if ($staff_id != null && !ereg("^[0-9]+$", $staff_id)){
        header("Location: ../top.php");
        exit;   
    }
    $sql  = "SELECT ";
    $sql .= "   staff_id ";
    $sql .= "FROM ";
    $sql .= "   t_attach ";
    $sql .= "WHERE ";
    $sql .= "   staff_id = $staff_id ";
    $sql .= "AND ";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $client_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    if (pg_num_rows($res) == 0){
        header("Location: ../top.php");
        exit;   
    }
}else{
    ($_SESSION["group_kind"] == "2") ? header("Location: 2-1-107.php") : null;
}


/****************************/
// 権限設定
/****************************/
// 新規/変更初期画面時
if ($_POST == null){
    $_SESSION["108_permit"]         = null; 
    $_SESSION["108_permit_delete"]  = null; 
    $_SESSION["108_permit_accept"]  = null; 
}


// 新規登録時
if ($_POST == null){

    $ary_mod_data = Permit_Item();

    // FC分権限チェックボックスのSESSIONを作成
    $ary_f_mod_data = $ary_mod_data[1];
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
    $ary_opt  = array("r", "w", "n");
    for ($i=0; $i<=$ary_f[0]; $i++){
        for ($j=0; $j<=$ary_f[1][$i-1]; $j++){
            for ($k=0; $k<=$ary_f[2][$i-1][$j-1]; $k++){
                for ($l=0; $l<count($ary_opt); $l++){
                    $_SESSION["108_permit"]["f"][$i][$j][$k][$ary_opt[$l]] = "";
                }       
            }       
        }       
    }

    // 削除、承認権限チェックボックスのSESSION作成
    $_SESSION["108_permit_delete"] = "";
    $_SESSION["108_permit_accept"] = "";

}

// 新規登録時、権限ページで設定ボタンが押下されている＋戻るボタンが押下されていない場合
if ($_POST["set_permit_flg"] != null && $_POST["permit_rtn_flg"] != "true"){

    // POSTされた権限情報をSESSIONにセット
    foreach ($_SESSION["108_permit"] as $key_a => $value_a){
        foreach ($value_a as $key_b => $value_b){
            foreach ($value_b as $key_c => $value_c){
                foreach ($value_c as $key_d => $value_d){
                    foreach ($value_d as $key_e => $value_e){
                        $_SESSION["108_permit"][$key_a][$key_b][$key_c][$key_d][$key_e] =
                        ($_POST["permit"][$key_a][$key_b][$key_c][$key_d][$key_e] != null) ?
                        $_POST["permit"][$key_a][$key_b][$key_c][$key_d][$key_e] : "";
                    }
                }
            }
        }
    }
    $_SESSION["108_permit_delete"]  = ($_POST["permit_delete"] != null) ? $_POST["permit_delete"] : "";
    $_SESSION["108_permit_accept"]  = ($_POST["permit_accept"] != null) ? $_POST["permit_accept"] : "";

}

// 新規登録時、権限ページで戻るボタンが押下された場合
if ($_POST["permit_rtn_flg"] == "true"){

    // SESSIONにセットしてある権限情報をPOSTにセット
    $_POST["permit"]        = $set_permit["permit"]         = $_SESSION["108_permit"];
    $_POST["permit_delete"] = $set_permit["permit_delete"]  = $_SESSION["108_permit_delete"];
    $_POST["permit_accept"] = $set_permit["permit_accept"]  = $_SESSION["108_permit_accept"];
    $form->setConstants($set_permit);

    // 権限ページの戻るボタンフラグをクリア
    $clear["permit_rtn_flg"] = "";
    $form->setConstants($clear);

}


/****************************/
// 初期処理
/****************************/
/* ログイン情報の扱いメッセージ */
// スタッフ変更時
if ($staff_id != null){
    // ログインマスタテーブルに登録があるか確認
    $sql  = "SELECT * FROM t_login WHERE staff_id = $staff_id ;";
    $res  = Db_Query($db_con, $sql);
    // ログイン情報新規登録時/ログイン情報変更時
    $login_info_type = (pg_num_rows($res) == 0) ? "登録" : "変更";
    $password_msg    = (pg_num_rows($res) == 0) ? null : "変更しない場合は未入力";
// スタッフ新規登録時
}else{
    $login_info_type = "登録";
}
$login_info_msg = $login_info_type."する を選択した場合、以下の項目は必須入力になります";

/* 権限設定メッセージ */
// スタッフ変更時
if ($staff_id != null){
    // 権限マスタテーブルに登録があるか確認
    $sql  = "SELECT COUNT(staff_id) FROM t_permit WHERE staff_id = $staff_id ;";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_fetch_result($res, 0, 0);
    // 過去に登録されている
    if ($num > 0){
        $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "変更準備ができました" : "設定済";
    // 一度も登録したことがない
    }else{
        $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "設定されました" : null;
    }
// スタッフ新規登録時
}else{
    $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "設定されました" : null;
}
$cons_data["permit_set_msg"] = "$permit_set_msg";
$form->setConstants($cons_data);


/****************************/
// フォームデフォルト値設定
/****************************/
// 登録・変更判定
if ($staff_id != null || $_POST["form_staff_id"] != null){

    // 該当スタッフデータ取得
    $sql  = "SELECT ";
    $sql .= "    t_staff.staff_cd1, ";                      // ネットワーク証ID１
    $sql .= "    t_staff.staff_cd2, ";                      // ネットワーク証ID２
    $sql .= "    t_staff.charge_cd,";                       // 担当者コード
    $sql .= "    t_staff.staff_name, ";                     // スタッフ名
    $sql .= "    t_staff.staff_read, ";                     // スタッフ名(フリガナ)
    $sql .= "    t_staff.staff_ascii, ";                    // スタッフ名(ローマ字)
    $sql .= "    t_staff.sex, ";                            // 性別
    $sql .= "    t_staff.birth_day, ";                      // 生年月日
    $sql .= "    t_staff.state, ";                          // 在職識別
    $sql .= "    t_staff.join_day, ";                       // 入社年月日
    $sql .= "    t_staff.retire_day, ";                     // 退職日
    $sql .= "    t_staff.employ_type , ";                   // 雇用形態
    $sql .= "    t_staff.position, ";                       // 役職
    $sql .= "    t_staff.job_type, ";                       // 職種
    $sql .= "    t_staff.study, ";                          // 研修履歴
    $sql .= "    t_staff.toilet_license, ";                 // トイレ診断士資格
    $sql .= "    t_staff.license, ";                        // 取得資格
    $sql .= "    t_staff.note, ";                           // 備考
    $sql .= "    t_staff.photo,";                           // 写真（ファイル名）
    $sql .= "    t_staff.change_flg, ";                     // 変更不可能フラグ
    $sql .= "    t_login.login_id, ";                       // ログインID
    $sql .= "    t_staff.round_staff_flg, ";
    $sql .= "    t_staff.h_change_flg ";
    $sql .= "FROM ";
    $sql .= "    t_staff ";
    $sql .= "        LEFT  JOIN t_login  ON t_staff.staff_id = t_login.staff_id ";
    $sql .= "        INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
    $sql .= "WHERE ";
    $sql .= "    t_staff.staff_id = $staff_id ";
    $sql .= "AND ";
    //直営判定
    if($_SESSION[group_kind] == '2'){
        //直営
        $sql .= "    t_attach.shop_id IN(".Rank_Sql().")";
    }else{ 
        //ＦＣ
        $sql .= "    t_attach.shop_id = $client_id ";
    }
    $sql .= ";";
    $res = Db_Query($db_con, $sql);

    // GETデータ判定（不正であればTOPへ遷移）
    Get_Id_Check($res);
    $data_list = pg_fetch_array($res, 0);

    $change_flg                                          =    $data_list["change_flg"];

    // フォームに値を復元
    // ネットワーク証IDが無い場合は非表示
    if ($data_list["staff_cd1"] == null && $data_list["staff_cd2"] == null){
        $staff_code_flg                                  =    't';
    }else{
        $def_fdata["form_staff_cd"]["cd1"]               =    $data_list["staff_cd1"];
        $def_fdata["form_staff_cd"]["cd2"]               =    $data_list["staff_cd2"]; 
    }

    // 担当者コードに０を埋める
    $data_list["charge_cd"] = str_pad($data_list["charge_cd"], 4, 0, STR_POS_LEFT);
    $def_fdata["form_charge_cd"]                         =    $data_list["charge_cd"];
    $def_fdata["h_charge_cd"]                            =    $data_list["charge_cd"];
    $def_fdata["form_staff_name"]                        =    ($change_flg == "t") ? htmlspecialchars($data_list["staff_name"]) : $data_list["staff_name"];
    $def_fdata["h_staff_name"]                           =    ($change_flg == "t") ? htmlspecialchars($data_list["staff_name"]) : $data_list["staff_name"];
    $def_fdata["form_staff_read"]                        =    ($change_flg == "t") ? htmlspecialchars($data_list["staff_read"]) : $data_list["staff_read"];
    $def_fdata["form_staff_ascii"]                       =    ($change_flg == "t") ? htmlspecialchars($data_list["staff_ascii"]) : $data_list["staff_ascii"];
    
    // 変更不可能判定
    if ($change_flg == "t"){
        $def_fdata["form_sex"]                           =    ($data_list["sex"] == "1") ? "男" : "女";
    }else{
        $def_fdata["form_sex"]                           =    $data_list["sex"];
    }

    // 生年月日が無い場合は非表示
    if ($data_list["birth_day"] == null){
        $birth_day_flg                                   =    "t";
    }else{
        $def_fdata["form_birth_day"]["y"]                =    substr($data_list["birth_day"], 0, 4);
        $def_fdata["form_birth_day"]["m"]                =    substr($data_list["birth_day"], 5, 2);
        $def_fdata["form_birth_day"]["d"]                =    substr($data_list["birth_day"], 8, 2);
    }

    $def_fdata["form_state"]                             =    $data_list["state"];
    // 入社年月日が無い場合は非表示
    if ($data_list["join_day"] == null){
        $join_day_flg                                    =    "t";
    }else{
        $def_fdata["form_join_day"]["y"]                 =    substr($data_list["join_day"], 0, 4);
        $def_fdata["form_join_day"]["m"]                 =    substr($data_list["join_day"], 5, 2);
        $def_fdata["form_join_day"]["d"]                 =    substr($data_list["join_day"], 8, 2);
    }
    
    // 退職日が無い場合は非表示
    if ($data_list["retire_day"] == null){
        $retire_day_flg                                  =    "t";
    }else{
        $def_fdata["form_retire_day"]["y"]               =    substr($data_list["retire_day"], 0, 4);
        $def_fdata["form_retire_day"]["m"]               =    substr($data_list["retire_day"], 5, 2);
        $def_fdata["form_retire_day"]["d"]               =    substr($data_list["retire_day"], 8, 2);
    }

    $def_fdata["form_employ_type"]                       =    $data_list["employ_type"]; 
    $def_fdata["form_position"]                          =    $data_list["position"];
    $def_fdata["form_job_type"]                          =    $data_list["job_type"]; 
    $def_fdata["form_study"]                             =    ($change_flg == "t") ? htmlspecialchars($data_list["study"]) : $data_list["study"];
    
    // 変更不可能判定
    if ($change_flg == "t"){
        if ($data_list["toilet_license"] == "1"){
            $def_fdata["form_toilet_license"]            =    "１級トイレ診断士";
        }else if ($data_list["toilet_license"] == "2"){
            $def_fdata["form_toilet_license"]            =    "２級トイレ診断士";
        }else{
            $def_fdata["form_toilet_license"]            =    "無";
        }
    }else{
        $def_fdata["form_toilet_license"]                =    $data_list["toilet_license"];
    }

    $def_fdata["form_license"]                           =    $data_list["license"];
    $def_fdata["form_note"]                              =    $data_list["note"];
    $def_fdata["form_photo"]                             =    $data_list["photo"];
    $def_fdata["form_photo_del"]                         =    "1";
    $def_fdata["form_login_id"]                          =    $data_list["login_id"];
    $def_fdata["form_staff_id"]                          =    $staff_id;
    $def_fdata["staff_url"]                              =    "true";
    $def_fdata["form_round_staff"]                       =    ($data_list["round_staff_flg"] == "t") ? true : false;
    $def_fdata["form_h_change_flg"]                      =    ($data_list["h_change_flg"] == "t") ? true : false;

    // 次へ・前へボタンにセットする値を作成
    $id_data = Make_Get_Id($db_con, "staff", $data_list[2], "2");
    $next_id = $id_data[0];
    $back_id = $id_data[1];

    // 所属マスタから変更情報取得
    $sql  = "SELECT ";
    $sql .= "    t_attach.shop_id, ";                 // 取引先ID
    $sql .= "    t_attach.part_id, ";                 // 部署ID
    $sql .= "    t_attach.section, ";                 // 所属部署（課）
    $sql .= "    t_attach.ware_id,  ";                // 倉庫ID
    $sql .= "    t_part.branch_id ";
    $sql .= "FROM ";
    $sql .= "    t_attach "; 
    $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
    $sql .= "    INNER JOIN t_part  ON t_attach.part_id = t_part.part_id ";
    $sql .= "WHERE ";
    //直営判定
    if($_SESSION[group_kind] == '2'){
        //直営
        $sql .= "    t_attach.shop_id IN(".Rank_Sql().")";
    }else{ 
        //ＦＣ
        $sql .= "    t_attach.shop_id = $client_id ";
    }
    $sql .= "AND ";
    $sql .= "    t_attach.staff_id = $staff_id ";
    $res = Db_Query($db_con,$sql.";");

    $data_list = pg_fetch_array($res, 0);
    $def_fdata["form_cshop"]                            =    $data_list["shop_id"];
    $def_fdata["form_part"][0]                          =    $data_list["branch_id"];
    $def_fdata["form_part"][1]                          =    $data_list["part_id"];
    $def_fdata["form_section"]                          =    $data_list["section"];
    $def_fdata["form_ware"]                             =    $data_list["ware_id"];

}else{
    $def_fdata = array(
        "form_sex"             => "1",
        "form_state"           => "在職中",
        "form_employ_type"     => "正スタッフ",
        "form_job_type"        => "営業",
        "form_toilet_license"  => "3",
        "staff_url"            => "true",
    );
    $staff_code_flg = "f";     // ネットワーク証ID表示
    $birth_day_flg  = "f";     // 生年月日表示
    $join_day_flg   = "f";     // 入社年月日表示
    $retire_day_flg = "f";     // 退職日表示

}

$def_fdata["form_login_info"] = "1";

$form->setDefaults($def_fdata);


/****************************/
// フォームパーツ定義
/****************************/
// 在職識別
// 変更不可能判定
if ($change_flg == "t"){
    $form->addElement("static", "form_state", "", "");
}else{
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "在職中", "在職中");
    $radio[] =& $form->createElement("radio", null, null, "退職", "退職");
    $radio[] =& $form->createElement("radio", null, null, "休業", "休業");
    $form->addGroup($radio, "form_state", "在職");
}

// 本部からの変更を許可しない
$form->addElement("checkbox", "form_h_change_flg", "", "本部からの変更を許可しない");

// ネットワーク証ID
// 登録かネットワーク証IDが登録されていない場合、非表示
if ($staff_id != null && $staff_code_flg != "t"){
    $text = null;
    $text[] =& $form->createElement("static", "cd1", "", "");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("static", "cd2", "", "");
    $form->addGroup($text, "form_staff_cd", "form_staff_cd");
}

// スタッフ名
// 変更不可能判定
$type = ($change_flg == "t") ? "static" : "text";
$opt  = ($change_flg == "t") ? "" : "size=\"22\" maxLength=\"10\" ".$g_form_option."\"";
$form->addElement($type, "form_staff_name", "", $opt);

// スタッフ名(フリガナ)
// 変更不可能判定
$type = ($change_flg == "t") ? "static" : "text";
$opt  = ($change_flg == "t") ? "" : "size=\"22\" maxLength=\"20\" ".$g_form_option."\"";
$form->addElement($type, "form_staff_read", "", $opt);

// スタッフ名(ローマ字)
// 変更不可能判定
$type = ($change_flg == "t") ? "static" : "text";
$opt  = ($change_flg == "t") ? "" : "size=\"22\" maxLength=\"30\" style=\"$g_form_style\" ".$g_form_option."\"";
$form->addElement($type, "form_staff_ascii", "", $opt);

// 性別
// 変更不可能判定
if ($change_flg == "t"){
    $form->addElement("static", "form_sex", "", "");
}else{
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "男", "1");
    $radio[] =& $form->createElement("radio", null, null, "女", "2");
    $form->addGroup($radio, "form_sex", "性別");
}

// 生年月日
// 変更不可能判定
if ($change_flg == "t"){
    // 生年月日が登録されていない場合、非表示
    if ($birth_day_flg != "t"){
        $text = null;
        $text[] =& $form->createElement("static", "y", "", "");
        $text[] =& $form->createElement("static", "", "", "-");
        $text[] =& $form->createElement("static", "m", "", "");
        $text[] =& $form->createElement("static", "", "", "-");
        $text[] =& $form->createElement("static", "d", "", "");
        $form->addGroup( $text, "form_birth_day", "form_birth_day");
    }
}else{
    $text = null;
    $text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_birth_day[y]','form_birth_day[m]',4)\"".$g_form_option."\"");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_birth_day[m]','form_birth_day[d]',2)\"".$g_form_option."\"");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
    $form->addGroup( $text, "form_birth_day", "form_birth_day");
}

// 退職日
// 変更不可能判定
if ($change_flg == "t"){
    // 退職日が登録されていない場合、非表示
    if ($retire_day_flg != "t"){
        $text = null;
        $text[] =& $form->createElement("static", "y", "", "");
        $text[] =& $form->createElement("static", "", "", "-");
        $text[] =& $form->createElement("static", "m", "", "");
        $text[] =& $form->createElement("static", "", "", "-");
        $text[] =& $form->createElement("static", "d", "", "");
        $form->addGroup( $text, "form_retire_day", "form_retire_day");
    }
}else{
    $text = null;
    $text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_retire_day[y]','form_retire_day[m]',4)\"".$g_form_option."\"");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_retire_day[m]','form_retire_day[d]',2)\"".$g_form_option."\"");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "d", "",  "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
    $form->addGroup( $text, "form_retire_day", "form_retire_day");
}

// 研修履歴
// 変更不可能判定
if ($change_flg == "t"){
    $form->addElement("static", "form_study", "", "");
}else{
    $form->addElement("text", "form_study", "", "size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
}

// トイレ診断資格
// 変更不可能判定
if ($change_flg == "t"){
    $form->addElement("static", "form_toilet_license", "", "");
}else{
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "１級トイレ診断士", "1");
    $radio[] =& $form->createElement("radio", null, null, "２級トイレ診断士", "2");
    $radio[] =& $form->createElement("radio", null, null, "無", "3");
    $form->addGroup($radio, "form_toilet_license", "トイレ診断資格");
}

// 証明写真削除ラジオボタン
// 変更不可能or登録判定
if ($change_flg != "t" && $staff_id != null){
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "削除しない<br>", "1");
    $radio[] =& $form->createElement("radio", null, null, "削除する", "2");
    $form->addGroup($radio, "form_photo_del", "証明写真");
}

// ファイル（証明写真）
// 変更不可能判定
if ($change_flg != "t"){
    $form->addElement("file", "form_photo_ref", "証明写真", "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\"");
}

// 証明写真ファイル名
$form->addElement("hidden", "form_photo");

// 担当者コード
$form->addElement("text", "form_charge_cd", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");

// 入社年月日
$text = null;
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_join_day[y]','form_join_day[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_join_day[m]','form_join_day[d]',2)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
$form->addGroup( $text, "form_join_day", "form_join_day");

// 雇用形態
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "正スタッフ", "正スタッフ");
$radio[] =& $form->createElement("radio", null, null, "パート", "パート");
$radio[] =& $form->createElement("radio", null, null, "アルバイト", "アルバイト");
$radio[] =& $form->createElement("radio", null, null, "契約", "契約");
$radio[] =& $form->createElement("radio", null, null, "委託", "委託");
$radio[] =& $form->createElement("radio", null, null, "その他", "その他");
$form->addGroup($radio, "form_employ_type", "雇用形態");

// 所属部署
/*
$select_value = Select_Get($db_con, "part");
$form->addElement("select", "form_part", "", $select_value, $g_form_option_select);
*/
$obj_bank_select =& $form->addElement("hierselect", "form_part", "", "");
$obj_bank_select->setOptions(Make_Ary_Branch($db_con));

// 所属部署(課)
$form->addElement("text", "form_section", "", "size=\"22\" maxLength=\"7\" ".$g_form_option."\"");

// 役職
$form->addElement("text", "form_position", "", "size=\"15\" maxLength=\"7\" ".$g_form_option."\"");

// 職種
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "営業", "営業");
$radio[] =& $form->createElement("radio", null, null, "サービス", "サービス");
$radio[] =& $form->createElement("radio", null, null, "事務", "事務");
$radio[] =& $form->createElement("radio", null, null, "その他", "その他");
$form->addGroup($radio, "form_job_type", "職種");

// 担当倉庫
//担当倉庫は表示しない
//$select_value = Select_Get($db_con, "ware");
//$form->addElement("select", "form_ware", "", $select_value, $g_form_option_select);
$form->addElement("hidden", "form_ware");

// 巡回担当者
$form->addElement("checkbox", "form_round_staff", "", "");

// 取得資格
$form->addElement("textarea", "form_license", "", "rows=\"5\" cols=\"59\"".$g_form_option_area."\"");

// 備考
//$form->addElement("text", "form_note", "", "size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
$form->addElement("textarea", "form_note", "", "rows=\"5\" cols=\"59\"".$g_form_option_area."\"");

// ログインID
$form->addElement("text", "form_login_id", "", "size=\"24\" maxLength=\"20\" style=\"$g_form_style\" ".$g_form_option."\"");

// パスワード＆パスワード（確認）
$form->addElement("password", "form_password1", "", "size=\"24\" maxLength=\"20\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addElement("password", "form_password2", "", "size=\"24\" maxLength=\"20\" style=\"$g_form_style\" ".$g_form_option."\"");

// ログイン情報の扱い
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, $login_info_type."しない", "1");
$radio[] =& $form->createElement("radio", null, null, $login_info_type."する", "2");
if ($login_info_type == "変更"){$radio[] =& $form->createElement("radio", null, null, "削除する", "3");}
$form->addGroup($radio, "form_login_info", "ログイン情報の扱い");

// 登録(ヘッダ)
$form->addElement("button", "new_button", "登録画面", "style=\"color:#ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
// 変更・一覧
$form->addElement("button", "change_button", "変更・一覧", "onClick=\"javascript:Referer('2-1-107.php')\"");

/*** hiddenフォーム ***/
// GETで取得したスタッフIDを保存
$form->addElement("hidden", "form_staff_id");

// 変更不可の場合でも、担当者コード・スタッフ名は保持する
$form->addElement("hidden", "h_charge_cd");
$form->addElement("hidden", "h_staff_name");

// スタッフ登録画面のURL
$form->addElement("hidden", "staff_url");

// 権限未設定エラー埋め込み用フォーム
$form->addElement("text", "permit_error");

// 権限設定済フラグ
$form->addElement("hidden", "set_permit_flg");


/****************************/
// フォームパーツ定義(権限)
/****************************/
/*** FCチェックボックス要素の個数設定 ***/
$ary_mod_data = Permit_Item();

$ary_f_mod_data = $ary_mod_data[1];

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

$ary_opt  = array("r", "w", "n");
for ($i=0; $i<=$ary_f[0]; $i++){
    for ($j=0; $j<=$ary_f[1][$i-1]; $j++){
        for ($k=0; $k<=$ary_f[2][$i-1][$j-1]; $k++){
            for ($l=0; $l<count($ary_opt); $l++){
                $me = "permit[f][$i][$j][$k][$ary_opt[$l]]";
                $form->addElement("hidden", $me, "");
            }       
        }       
    }
}


// 削除権限チェック
$form->addElement("hidden", "permit_delete", "");

// 承認権限チェック
$form->addElement("hidden", "permit_accept", "");

// 設定ボタン
$form->addElement("hidden", "form_set_button", "");


/****************************/
// 登録ボタン押下時処理
/****************************/
if ($_POST["entry_button"] != null){

    /****************************/
    // エラーチェック(AddRule)
    /****************************/
    /*** 担当者コード ***/
    // 変更不可能判定
    if ($change_flg != "t"){
        // 必須チェック
        $form->addRule("form_charge_cd", "担当者コード は半角数字のみです。", "required");
        // 文字種チェック
        $form->addRule("form_charge_cd", "担当者コード は半角数字のみです。", "regex", "/^[0-9]+$/");
    }

    /*** スタッフ名 ***/
    // 変更不可能判定
    if ($change_flg != "t"){
        //・必須チェック
        $form->addRule("form_staff_name", "スタッフ名 は10文字以内です。", "required");
        // スペースチェック
        $form->registerRule("no_sp_name", "function", "No_Sp_Name");
        $form->addRule("form_staff_name", "スタッフ名に スペースのみの登録はできません。", "no_sp_name");
    }

    /*** スタッフ名（ローマ字） ***/
    // 変更不可能判定
    if ($change_flg != "t"){
        // 必須チェック
        $form->addRule("form_staff_ascii", "スタッフ名(ローマ字) はアスキーコードのみ使用可です。", "required");
        // 文字種チェック
        $form->addRule("form_staff_ascii", "スタッフ名(ローマ字) はアスキーコードのみ使用可です。", "ascii");
    }

    /*** 証明写真 ***/
    // 拡張子チェック
    $form->addRule("form_photo_ref", "不正な画像ファイルです。", "mimetype", array("image/jpeg", "image/jpeg","image/pjpeg"));

    /*** 生年月日 ***/
    // 文字種チェック
    $form->addGroupRule("form_birth_day", array(
        "y" => array(
            array("生年月日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
        "m" => array(
            array("生年月日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
        "d" => array(
            array("生年月日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
    ));

    /*** 入社年月日 ***/
    // 文字種チェック
    $form->addGroupRule("form_join_day", array(
        "y" => array(
            array("入社年月日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
        "m" => array(
            array("入社年月日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
        "d" => array(
            array("入社年月日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
    ));

    /*** 退職日 ***/
    // 文字種チェック
    $form->addGroupRule("form_retire_day", array(
        "y" => array(
            array("退職日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
        "m" => array(
            array("退職日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
        "d" => array(
            array("退職日 の日付は妥当ではありません。", "regex", "/^[0-9]+$/")
        ),
    ));

    /*** 取得資格 ***/
    // 文字数チェック
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_license","取得資格 は200文字以内です。","mb_maxlength","200");

    /*** 備考 ***/
    // 文字数チェック
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note","備考 は2000文字以内です。","mb_maxlength","2000");


    // ログイン情報を登録/変更する にチェックが付いている場合
    if ($_POST["form_login_info"] == "2"){

        /*** ログインID ***/
        // 必須チェック
        $form->addRule("form_login_id", "ログインID は6文字以上20文字以内です。", "required");
        // 文字数チェック
        $form->addRule("form_login_id", "ログインID は6文字以上20文字以内です。", "rangelength", array(6, 20));

        /*** パスワード ***/
        // 更新の場合はパスワードは必須ではない
        if ($login_info_type == "登録"){
            // 必須チェック
            $form->addRule("form_password1", "パスワード は6文字以上20文字以内です。", "required");
        }
        // 文字数チェック
        $form->addRule("form_password1", "パスワード は6文字以上20文字以内です。", "rangelength", array(6, 20));

        /*** 権限 ***/
        // 登録/変更する　かつ　権限設定ボタンが押下されていない場合
        if ($_POST["form_login_info"] == "2" && $_POST["set_permit_flg"] == null){
            // スタッフ変更時
            if ($staff_id != null){
                // 権限テーブルに登録が無ければエラー
                $sql = "SELECT staff_id FROM t_permit WHERE staff_id = $staff_id;";
                $res = Db_Query($db_con, $sql);
                if (pg_num_rows($res) == 0){
                    $form->setElementError("permit_error", "権限 の設定は必須です。");
                }
            // スタッフ新規登録時
            }else{
                // 問答無用でエラー
                $form->setElementError("permit_error", "権限 の設定は必須です。");
            }
        }

    }

    // 変更不可能か
    if ($_POST["form_charge_cd"] != null){
        $charge_cd      = $_POST["form_charge_cd"];      //担当者コード
    }else{
        $charge_cd      = $_POST["h_charge_cd"];         //担当者コード
    }
    $staff_name     = $_POST["form_staff_name"];         //スタッフ名
    $staff_read     = $_POST["form_staff_read"];         //スタッフ名(フリガナ)
    $staff_ascii    = $_POST["form_staff_ascii"];        //スタッフ名(ローマ字)
    $sex            = $_POST["form_sex"];                //性別
    $birth_day_y    = $_POST["form_birth_day"]["y"];     //生年月日
    $birth_day_m    = $_POST["form_birth_day"]["m"]; 
    $birth_day_d    = $_POST["form_birth_day"]["d"];
    $state          = $_POST["form_state"];              //在職識別
    $join_day_y     = $_POST["form_join_day"]["y"];      //入社年月日
    $join_day_m     = $_POST["form_join_day"]["m"];     
    $join_day_d     = $_POST["form_join_day"]["d"];
    $retire_day_y   = $_POST["form_retire_day"]["y"];    //退職日
    $retire_day_m   = $_POST["form_retire_day"]["m"];    
    $retire_day_d   = $_POST["form_retire_day"]["d"];
    $employ_type    = $_POST["form_employ_type"];        //雇用形態
    $part_id        = $_POST["form_part"][1];               //部署ID
    $section        = $_POST["form_section"];            //所属部署（課）
    $position       = $_POST["form_position"];           //役職
    $job_type       = $_POST["form_job_type"];           //職種
    $study          = $_POST["form_study"];              //研修履歴
    $toilet_license = $_POST["form_toilet_license"];     //トイレ診断士資格
    $license        = $_POST["form_license"];            //取得資格
    $note           = $_POST["form_note"];               //備考
    $ware_id        = $_POST["form_ware"];               //担当倉庫ID
    $photo_del      = $_POST["form_photo_del"];          //写真削除フラグ
    $photo          = $_POST["form_photo"];              //写真ファイル名
    $login_id       = $_POST["form_login_id"];           //ログインID
    $password1      = $_POST["form_password1"];          //パスワード
    $password2      = $_POST["form_password2"];          //パスワード確認
    $permit_msg     = $_POST["permit_msg"];              //権限設定メッセージ
    $round_staff    = ($_POST["form_round_staff"] == "1") ? "t" : "f";        // 巡回担当者
    $h_change_flg   = ($_POST["form_h_change_flg"] == "1") ? "t" : "f";

    /****************************/
    // エラーチェック(PHP)
    /****************************/
    /*** 担当者コード ***/
    // 重複チェック
    if ($charge_cd != null && ereg("^[0-9]+$", $charge_cd)){

        // 担当者コードに０を埋める
        $charge_cd = str_pad($charge_cd, 4, 0, STR_POS_LEFT);

        //グループ種別判定
        if($group_kind == '2'){
            //直営

            // 入力したコードがマスタに存在するかチェック
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
            $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = '$charge_cd' ";
            $sql .= "AND ";
            $sql .= "    t_rank.rank_cd = '$rank_cd' ";

        }else if($group_kind == '3'){
            //ＦＣ

            // 入力したコードがマスタに存在するかチェック
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff  ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = '$charge_cd' ";
            $sql .= "AND ";
            $sql .= "    t_attach.shop_id = $client_id ";
        }
        // 変更の場合は、自分のデータ以外を参照する
        if ($staff_id != null){
            $sql .= " AND NOT ";
            $sql .= "t_attach.staff_id = '$staff_id'";
        }
        $sql .= ";";
        $res = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($res);
        if ($row_count != 0){
            $form->setElementError("form_charge_cd", "既に使用されている 担当者コード です。");
        }
    }

    /*** 生年月日 ***/
    // 日付の存在チェック
    // 何か入力された場合にチェックを行う
    if ($birth_day_y != null || $birth_day_m != null || $birth_day_d != null){
        $birth_day_y = (int)$birth_day_y;
        $birth_day_m = (int)$birth_day_m;
        $birth_day_d = (int)$birth_day_d;
        // 日付の妥当性チェック
        if (checkdate($birth_day_m,$birth_day_d,$birth_day_y)){
            $birth_day_y = str_pad($birth_day_y, 4, "0", STR_PAD_LEFT);
            $birth_day_m = str_pad($birth_day_m, 2, "0", STR_PAD_LEFT);
            $birth_day_d = str_pad($birth_day_d, 2, "0", STR_PAD_LEFT);
            $birth_day = "'".$birth_day_y."-".$birth_day_m."-".$birth_day_d."'";
        }else{
            $form->setElementError("form_birth_day","生年月日 が妥当ではありません。");
        }
    }else{
        // 何も入力されていない場合はNULL代入
        $birth_day = "null";
    }

    /*** 入社年月日 ***/
    // 日付の存在チェック
    if ($join_day_y != null || $join_day_m != null || $join_day_d != null){
        $join_day_y = (int)$join_day_y;
        $join_day_m = (int)$join_day_m;
        $join_day_d = (int)$join_day_d;
        if (checkdate($join_day_m,$join_day_d,$join_day_y)){
            $join_day_y = str_pad($join_day_y, 4, "0", STR_PAD_LEFT);
            $join_day_m = str_pad($join_day_m, 2, "0", STR_PAD_LEFT);
            $join_day_d = str_pad($join_day_d, 2, "0", STR_PAD_LEFT);
            $join_day = "'".$join_day_y."-".$join_day_m."-".$join_day_d."'";
        }else{
            $form->setElementError("form_join_day","入社年月日 が妥当ではありません。");
        }
    }else{
        $join_day = "null";
    }

    /*** 退職日 ***/
    // 日付の存在チェック
    if ($retire_day_y != null || $retire_day_m != null || $retire_day_d != null){
        $retire_day_y = (int)$retire_day_y;
        $retire_day_m = (int)$retire_day_m;
        $retire_day_d = (int)$retire_day_d;
        if (checkdate($retire_day_m,$retire_day_d,$retire_day_y)){
            $retire_day_y = str_pad($retire_day_y, 4, "0", STR_PAD_LEFT);
            $retire_day_m = str_pad($retire_day_m, 2, "0", STR_PAD_LEFT);
            $retire_day_d = str_pad($retire_day_d, 2, "0", STR_PAD_LEFT);
            $retire_day = "'".$retire_day_y."-".$retire_day_m."-".$retire_day_d."'";
        }else{
            $form->setElementError("form_retire_day","退職日 が妥当ではありません。");
        }
    }else{
        $retire_day = "null";
    }

    // ログイン情報登録・更新にチェックが付いてる場合
    if ($_POST["form_login_info"] == "2"){

        /*** ログインID ***/
        // 文字種チェック
        if (!ereg("^[0-9a-zA-Z_-]+$", $login_id) && $login_id != null){
            $form->setElementError("form_login_id","ログインID は半角英数字、ハイフン、アンダーバーのみ使用可です。");
        }

        // 重複チェック
        if ($login_id != null){
            //入力したコードがマスタに存在するかチェック
            $sql  = "SELECT ";
            $sql .= "    login_id ";
            $sql .= "FROM ";
            $sql .= "    t_login ";
            $sql .= "WHERE ";
            $sql .= "    login_id = '$login_id' ";
            // 変更の場合は、自分のデータ以外を参照する
            if ($staff_id != null){
                $sql .= "AND NOT ";
                $sql .= "    staff_id = '$staff_id'";
            }
            $sql .= ";";
            $res = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_login_id", "既に使用されている ログインID です。");
            }
        }

        /*** パスワード・パスワード確認 ***/
        // 文字種チェック
        if (!ereg("^[0-9a-zA-Z_-]+$", $password1) && $password1 != null){
            $form->setElementError("form_password1","パスワード は半角英数字、ハイフン、アンダーバーのみ使用可です。");
        }
        // 値が等しいか
        if ($password1 != $password2 && $password1 != null){
            $form->setElementError("form_password1","パスワードと確認用に入力されたパスワードが異なります。");
        }
    }

    /***所属部署***/
    //必須チェック
    if($part_id == null){
       $form->setElementError("form_part","所属部署は必須です。"); 
    }

    // エラーの際には、登録・変更処理を行わない
    if ($form->validate() && $err_flg == false){
        Db_Query($db_con, "BEGIN;");

        // 登録の場合だけ処理を行なう
        if ($staff_id == null){
            // スタッフID取得
            // 排他制御
            Db_Query($db_con,"LOCK TABLE t_staff;");
            $sql  = "SELECT COALESCE(MAX(staff_id), 0)+1 FROM t_staff;";
            $res = Db_Query($db_con,$sql);
            $staff_id_get = pg_fetch_result($res, 0, 0);
        }

        /****************************/
        // 画像のアップロード・削除
        /****************************/
        // 削除しないにチェック&ファイルが指定されてるとき・登録時にファイルが指定されているか
        if (($photo_del == 1 && $_FILES["form_photo_ref"]["tmp_name"] != null) || 
            ($staff_id == null && $_FILES["form_photo_ref"]["tmp_name"] != null)){
            // 写真のファイル名指定
            if ($staff_id == null){
                $photo = $staff_id_get.".jpg";
            }else{
                //  変更処理
                $photo = $staff_id.".jpg";
            }
            // アップロード先のパス指定
            $up_file = STAFF_PHOTO_DIR.$photo;
            // アップロード
            $res = move_uploaded_file($_FILES['form_photo_ref']['tmp_name'], $up_file);
            if ($res == false){
                Db_Query($db_con,"ROLLBACK;");
                exit;
            }
        }

        // 写真の削除判定
        if ($photo_del == 2){
            // 変更処理
            $photo = $staff_id.".jpg";
            // アップロード先のパス指定
            $up_file = STAFF_PHOTO_DIR.$photo;
            // ファイル存在判定
            if (file_exists($up_file)){
                // ファイル削除
                $res = unlink($up_file);
                if ($res == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }
            }
            $photo = "";
        }

        Db_Query($db_con, "BEGIN;");

        /****************************/
        // スタッフマスタ登録・更新処理
        /****************************/
        if ($staff_id != null){

            /*** 変更処理 ***/
            // 作業区分は更新
            $work_div = "2";

            // 変更不可能判定
//            if ($change_flg != "t"){
                $sql  = "UPDATE \n";
                $sql .= "    t_staff \n";
                $sql .= "SET \n";
                if ($change_flg != "t"){
                    $sql .= "    staff_name       = '$staff_name', \n";    
                    $sql .= "    staff_read       = '$staff_read', \n";    
                    $sql .= "    staff_ascii      = '$staff_ascii', \n";    
                    $sql .= "    sex              = '$sex',\n";
                    $sql .= "    birth_day        = $birth_day, \n";    
                    $sql .= "    retire_day       = $retire_day, \n";    
                    $sql .= "    study            = '$study', \n";        
                    $sql .= "    toilet_license   = '$toilet_license', \n";
                    $sql .= "    photo            = '$photo', \n";
                    $sql .= "    state            = '$state', \n";        
                }
                $sql .= "    charge_cd        = '$charge_cd',\n";        
                $sql .= "    join_day         = $join_day, \n";        
                $sql .= "    employ_type      = '$employ_type', \n";
                $sql .= "    position         = '$position', \n";        
                $sql .= "    job_type         = '$job_type', \n";        
                $sql .= "    license          = '$license', \n";        
                $sql .= "    note             = '$note', \n";    
                $sql .= "    round_staff_flg  = '$round_staff', \n"; 
                $sql .= "    h_change_flg     = '$h_change_flg' \n"; 
                $sql .= "WHERE \n";
                $sql .= "    staff_id = $staff_id;";
//            }

        }else{

            /*** 登録処理 ***/
            // 作業区分は登録
            $work_div = '1';

            $sql  = "INSERT INTO ";
            $sql .= "    t_staff ";
            $sql .= "VALUES(";
            $sql .= "    $staff_id_get,";
            $sql .= "    null,";
            $sql .= "    null,";
            $sql .= "    '$staff_name',";
            $sql .= "    '$staff_read',";
            $sql .= "    '$staff_ascii',";
            $sql .= "    '$sex',";
            $sql .= "    $birth_day,";
            $sql .= "    '$state',";
            $sql .= "    $join_day,";
            $sql .= "    $retire_day,";
            $sql .= "    '$employ_type',";
            $sql .= "    '$position',";
            $sql .= "    '$job_type',";
            $sql .= "    '$study',";
            $sql .= "    '$toilet_license',";
            $sql .= "    '$license',";
            $sql .= "    '$note',";
            $sql .= "    '$photo',";
            $sql .= "    false,";
            $sql .= "    '$charge_cd',";
            $sql .= "    '$round_staff', ";
            $sql .= "    '$h_change_flg');";

        }

        $res = Db_Query($db_con,$sql);
        if ($res == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        // スタッフマスタの値をログに書き込む
        $res = Log_Save($db_con, "staff", $work_div, $charge_cd, $staff_name);
        // ログ登録時にエラーになった場合
        if ($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /****************************/
        // 所属マスタ登録・更新処理
        /****************************/

        //担当倉庫登録関数
        $create_ware_staff_data = array($charge_cd,     //担当者コード
                                        $staff_name,    //担当者名
                                        $client_id,     //ショップID
                                        $staff_id_get,  //スタッフID
                                        $db_con,        //Dbコネクション
                                        $ware_id        //倉庫ID
                                );
        $ware_id    = Create_Ware_Staff($create_ware_staff_data);

        // 変更判定
        if ($staff_id != null){
            // 更新処理
            $sql  = "UPDATE\n ";
            $sql .= "    t_attach \n";
            $sql .= "SET \n";
            // 所属部署存在判定
            $sql .= ($part_id != null) ? "part_id = $part_id, \n" : null;
            // 担当倉庫存在判定
            $sql .= ($ware_id != null) ? "ware_id = $ware_id, \n" : "ware_id = NULL, \n";
            $sql .= "    section = '$section' \n";
            $sql .= "WHERE \n";
            $sql .= "    staff_id = $staff_id \n";
            $sql .= "AND \n";
            $sql .= ($group_kind == '2')? "shop_id IN (".Rank_Sql().") \n" : "  shop_id = $client_id\n";
            $sql .= "; \n";
        }else{
            // 登録処理
            $sql  = "INSERT INTO ";
            $sql .= "    t_attach ";
            $sql .= "VALUES(";
            $sql .= "    $client_id,";
            $sql .= "    $staff_id_get,";
            // 所属部署存在判定
            $sql .= ($part_id != null) ? "$part_id, " : "NULL, ";
            $sql .= "    '$section',";
            // 担当倉庫存在判定
            $sql .= ($ware_id != null) ? "$ware_id,"  : "NULL, ";
            $sql .= "'f',";
            $sql .= "'f');";
        }   
        $res = Db_Query($db_con,$sql);
        if ($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /****************************/
        // ログインマスタ登録・更新処理
        /****************************/
        // ログイン情報登録・更新にチェックが付いている場合
        if ($_POST["form_login_info"] == "2"){
            // パスワードをハッシュ化
            $crypt_pass = crypt($password1);
            // 登録・変更判定
            if ($login_info_type == "登録"){
                // スタッフ登録と同時にログイン情報を登録する場合
                if ($staff_id == null){
                    $sql  = "INSERT INTO ";
                    $sql .= "    t_login ";
                    $sql .= "VALUES(";
                    $sql .= "(SELECT ";
                    $sql .= "    t_staff.staff_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_staff ";
                    $sql .= "    INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
                    $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
                    $sql .= "WHERE ";
                    $sql .= "    t_staff.charge_cd = $charge_cd ";
                    $sql .= "AND ";
                    $sql .= "    t_attach.shop_id = $client_id ";
                    $sql .= "),";
                    $sql .= "'$login_id',";
                    $sql .= "'$crypt_pass');";
                }else{
                // スタッフ登録後に、追加でログイン情報を登録する場合
                    $sql  = "INSERT INTO ";
                    $sql .= "    t_login ";
                    $sql .= "        (";
                    $sql .= "        staff_id, ";
                    $sql .= "        login_id, ";
                    $sql .= "        password";
                    $sql .= "        ) ";
                    $sql .= "VALUES ";
                    $sql .= "        (";
                    $sql .= "        $staff_id, ";
                    $sql .= "        '$login_id', ";
                    $sql .= "        '$crypt_pass'";
                    $sql .= "        )";
                    $sql .= ";";
                 }  
            }else{
                //変更処理
                $sql  = "UPDATE ";
                $sql .= "   t_login ";
                $sql .= "SET ";
                $sql .= "   login_id = '$login_id' ";
                //パスワードが未入力の場合は、更新しない
                if ($password1!=null){
                    $sql .= ",";
                    $sql .= "password = '$crypt_pass' ";
                }
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id;";
            }
            $res = Db_Query($db_con,$sql);
            if ($res == false){
                Db_Query($db_con,"ROLLBACK;");
                exit;
            }
        }

        /****************************/
        // 権限マスタ登録・更新処理
        /****************************/
        // ログイン情報登録/更新＋権限設定されている場合
        if ($_POST["form_login_info"] == "2" && $_POST["set_permit_flg"] != null){
            // 削除権限
            $permit_delete = ($_POST["permit_delete"] != null) ? "TRUE" : "FALSE";

            // 承認権限
            $permit_accept = ($_POST["permit_accept"] != null) ? "TRUE" : "FALSE";

            //
            $permit_col = Permit_Col("fc");

            $p = 0;
            // FC　権限テーブルのカラム名と付与する権限（n, r, w）をセットにした配列の作成
            for ($i=1; $i<=$ary_f[0]; $i++){
                for ($j=1; $j<=$ary_f[1][$i-1]; $j++){
                    for ($k=1; $k<=$ary_f[2][$i-1][$j-1]; $k++){
                        $me = "[$i][$j][$k]";
                        if ($_POST[permit][f][$i][$j][$k][n] == null){  $permit_data[$p] = array($permit_col[f][$i][$j][$k], "n");}
                        if ($_POST[permit][f][$i][$j][$k][r] == 1){     $permit_data[$p] = array($permit_col[f][$i][$j][$k], "r");}
                        if ($_POST[permit][f][$i][$j][$k][w] == 1){     $permit_data[$p] = array($permit_col[f][$i][$j][$k], "w");}
                        $p++;
                    }
                }
            }
            $p = 0;
            // 権限テーブルのカラム名と付与する権限（n, r, w）をセットにした配列の作成
            for ($j=1; $j<=count($permit_col[f]); $j++){
                for ($k=1; $k<=count($permit_col[f][$j]); $k++){
                    for ($l=0; $l<count($permit_col[f][$j][$k]); $l++){
                        $permit_data[$p] = ($_POST[permit][f][$j][$k][$l][n] == null)   ? array($permit_col[f][$j][$k][$l], "n") : null;
                        $permit_data[$p] = ($_POST[permit][f][$j][$k][$l][r] == 1)      ? array($permit_col[f][$j][$k][$l], "r") : $permit_data[$p];
                        $permit_data[$p] = ($_POST[permit][f][$j][$k][$l][w] == 1)      ? array($permit_col[f][$j][$k][$l], "w") : $permit_data[$p];
                        $p++;
                    }
                }
            }

            // 空の要素を取り除く
            for ($i=0; $i<count($permit_data); $i++){
                if ($permit_data[$i][0][0] != null){
                    $permit_data_unnull[] = $permit_data[$i];
                }
            }
            $permit_data = $permit_data_unnull;

            /*** SQL作成 ***/
            // レコード挿入か更新か判断
            if ($staff_id != null){
                $sql  = "SELECT ";
                $sql .= "   staff_id ";
                $sql .= "FROM ";
                $sql .= "   t_permit ";
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id ";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                $num  = pg_num_rows($res);
                $status = ($num < 1) ? "insert" : "update";
            }else{
                $status = "insert";
            }

            // 新規登録のスタッフ　または
            // 変更で過去に権限登録が行われていないスタッフ
            if ($status == "insert"){
                $sql  = "INSERT INTO ";
                $sql .= "   t_permit ";
                $sql .= "       (";
                $sql .= "       staff_id, ";
                $sql .= "       del_flg, ";
                $sql .= "       accept_flg, ";
                for ($i=0; $i<count($permit_data); $i++){
                    for ($j=0; $j<count($permit_data[$i][0]); $j++){
                        $sql .= $permit_data[$i][0][$j];
                        $sql .= (($i == count($permit_data)-1) && ($j == count($permit_data[$i][0])-1)) ? " " : ", ";
                    }
                }
                $sql .= "       ) ";
                $sql .= "VALUES";
                $sql .= "       (";
                $sql .= "       (SELECT ";
                $sql .= "           t_staff.staff_id ";
                $sql .= "       FROM ";
                $sql .= "           t_staff ";
                $sql .= "           INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
                $sql .= "           INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
                $sql .= "       WHERE ";
                $sql .= "           t_staff.charge_cd = '$charge_cd' ";
                $sql .= "       AND ";
                $sql .= ($_SESSION["group_kind"] == "2") ? "t_attach.shop_id IN (".Rank_Sql().") " : " t_attach.shop_id = $client_id ";
                $sql .= "       ), ";
                $sql .= "       $permit_delete, ";
                $sql .= "       $permit_accept, ";
                for ($i=0; $i<count($permit_data); $i++){
                    for ($j=0; $j<count($permit_data[$i][0]); $j++){
                    $sql .= "'".$permit_data[$i][1]."'";
                        $sql .= (($i == count($permit_data)-1) && ($j == count($permit_data[$i][0])-1)) ? " " : ", ";
                    }
                }
                $sql .= "       ) ";
                $sql .= ";";
            // 変更で過去に権限登録が行われているスタッフ
            }else{
                $sql  = "UPDATE ";
                $sql .= "   t_permit ";
                $sql .= "SET ";
                $sql .= "   del_flg = '$permit_delete', ";
                $sql .= "   accept_flg = '$permit_accept'";
                $sql .= ($permit_data != null) ? "," : " ";
                for ($i=0; $i<count($permit_data); $i++){
                    for ($j=0; $j<count($permit_data[$i][0]); $j++){
                        $sql .= "   ".$permit_data[$i][0][$j]." = '".$permit_data[$i][1]."'";
                        $sql .= (($i == count($permit_data)-1) && ($j == count($permit_data[$i][0])-1)) ? " " : ", ";
                    }
                }
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id ";
                $sql .= ";";
            }

            $res = Db_Query($db_con, $sql);
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

        }


        /****************************/
        // ログイン情報削除処理
        /****************************/
        // ログイン情報削除にチェックが付いている場合
        if ($_POST["form_login_info"] == "3"){

            // ログインマスタ
            $sql  = "DELETE FROM t_login WHERE staff_id = $staff_id;";
            $res  = Db_Query($db_con, $sql);
            if ($res === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            // 権限マスタ
            $sql  = "DELETE FROM t_permit WHERE staff_id = $staff_id;";
            $res  = Db_Query($db_con, $sql);
            if ($res === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

        }

        // 新規登録の場合は、GET情報が無い為、GET情報作成
        if ($staff_id == ""){
            $staff_id = $staff_id_get;        //スタッフID
        }

        Db_Query($db_con, "COMMIT;");
        $freeze_flg = true;
    }


/******************************/
// 削除ボタン押下処理
/******************************/
}elseif ($_POST["del_button_flg"] == true){

    // 削除しようとしているスタッフが自分の場合
    if ($staff_id == $ss_staff_id){

        $staff_del_restrict_msg = "このスタッフは削除できません。";
        $staff_del_restrict_flg = true; 

    // 削除しようとしているスタッフが自分でない場合
    }else{  

        Db_Query($db_con, "BEGIN;");

        // 倉庫IDを取得
        $sql  = "SELECT ware_id FROM t_attach WHERE staff_id = $staff_id AND h_staff_flg = 'f';";
        $res  = Db_Query($db_con, $sql);
        $num_ware   = pg_num_rows($res);
        if ($num_ware > 0){
            $del_ware_id = pg_fetch_result($res, 0, 0);
        }

		//ログ用の担当者CD・スタッフ名取得
		$sql  = "SELECT ";
		$sql .= "    charge_cd,";
		$sql .= "    staff_name ";
		$sql .= "FROM ";
		$sql .= "    t_staff ";
		$sql .= "WHERE ";
		$sql .= "    staff_id = $staff_id;";
		$result = Db_Query($db_con, $sql); 
		$data_list = Get_Data($result,3);

        // スタッフマスタ
        $sql  = "DELETE FROM t_staff WHERE staff_id = $staff_id;";
        //$res  = Db_Query($db_con, $sql);
        $res  = @pg_query($db_con, $sql);

        // 削除不可レコードの場合
        if ($res == false){ 
            $err_return = pg_last_error();
            $err_format = "violates foreign key";

            Db_Query($db_con, "ROLLBACK;");

            if (strstr($err_return, $err_format) != false){ 
                $staff_del_restrict_msg = "このスタッフは削除できません。";
                $staff_del_restrict_flg = true; 
            }       

        // 削除完了
        }else{  

			//スタッフマスタの値をログに書き込む
			//（データコード：スタッフCD  名称：スタッフ名）
	        $res = Log_Save($db_con, "staff", 3,$data_list[0][0],$data_list[0][1]);
	        //ログ登録時にエラーになった場合
	        if($result === false){
	            Db_Query($db_con,"ROLLBACK;");
	            exit;
	        }

            // 担当倉庫も削除する
            if ($del_ware_id != null){
                $sql  = "DELETE FROM t_ware WHERE ware_id = $del_ware_id;";
                //$res  = Db_Query($db_con, $sql);
                $res  = @pg_query($db_con, $sql);
                // 削除不可レコードの場合
                if ($res == false){ 
                    $err_return = pg_last_error();
                    $err_format = "violates foreign key";
                    Db_Query($db_con, "ROLLBACK;");
                    if (strstr($err_return, $err_format) != false){ 
                        $staff_del_restrict_msg = "このスタッフは削除できません。";
                        $staff_del_restrict_flg = true; 
                    }
                }
            }

            Db_Query($db_con, "COMMIT;");
            header("Location: 2-1-107.php");

        }

    }

}
    
/******************************/
// 可変フォームパーツ定義
/******************************/
/*** 入力画面でのみ表示するフォーム ***/
if ($freeze_flg != true){

    // 登録ボタン
    $form->addElement("submit", "entry_button", "登　録", "onClick=\"javascript:return Dialogue4('登録します。')\" $disabled");
    // 削除ボタン
    $form->addElement("button", "del_button", "削　除", "style=\"color: #ff0000;\" onClick=\"javascript:Dialogue_2('削除します。', '#', 'true', 'del_button_flg')\" $del_disabled");
    $form->addElement("hidden", "del_button_flg", "", "");
    $form->addElement("hidden", "freeze_flg", "", "");
    // 権限リンク
    $form->addElement("link", "form_permit_link", "", "#", "権限", "onClick=\"javascript:return Submit_Page2('2-1-112.php?staff_id=$staff_id');\"");
    // 次へボタン
    $option = ($next_id != null) ? "onClick=\"location.href='./2-1-108.php?staff_id=$next_id'\"" : "disabled";
    $form->addElement("button", "next_button", "次　へ", $option);
    // 前へボタン
    $option = ($back_id != null) ? "onClick=\"location.href='./2-1-108.php?staff_id=$back_id'\"" : "disabled";
    $form->addElement("button", "back_button", "前　へ", $option);

/*** 登録確認画面でのみ表示するフォーム ***/
}else{

    // 戻るボタンの戻り先（変更画面）のスタッフIDを取得する
    $sql  = "SELECT \n";
    $sql .= "   t_staff.staff_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_staff.charge_cd = '$charge_cd' \n";
    $sql .= "AND \n"; 
    $sql .= "   t_attach.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $return_id = pg_fetch_result($res, 0, 0);
    }

    //戻るボタン
    $form->addElement("button", "return_button", "戻　る", "onClick=\"location.href='./2-1-108.php?staff_id=".$return_id."'\"");
    //OKボタン
    $form->addElement("button", "comp_button", "Ｏ　Ｋ", "onClick=\"location.href='./2-1-108.php'\"");
    //権限リンク
    $form->addElement("static", "form_permit_link", "", "権限");

    $form->freeze();

    $password_msg = null;
//    $permit_set_msg = "変更されました";

    // 「ログイン情報を削除する」の場合
    if ($_POST["form_login_info"] == "3"){
        // ログイン情報テーブルの表示を空にする
        $clear_login_form["form_login_id"]  = "";
        $clear_login_form["form_password1"] = "";
        $clear_login_form["form_password2"] = "";
        $permit_set_msg                     = "削除しました";
        $form->setConstants($clear_login_form);
    // 「登録/変更する」の場合
    }elseif ($_POST["form_login_info"] == "2"){
        if ($permit_set_msg == "変更準備ができました"){
            $permit_set_msg = "変更しました"; 
        }elseif ($permit_set_msg == "設定済"){
            $permit_set_msg = "設定済"; 
        }else{  
            $permit_set_msg = "登録しました"; 
        }       
    // 「登録/変更しない」の場合
    }elseif ($_POST["form_login_info"] == "1"){
        if ($staff_id == null){
            $clear_login_form["form_login_id"]  = "";
            $clear_login_form["form_password1"] = "";
            $clear_login_form["form_password2"] = "";
            $form->setConstants($clear_login_form);
        }else{  
            $sql = "SELECT staff_id FROM t_permit WHERE staff_id = $staff_id;";
            $res = Db_Query($db_con, $sql);
            if (pg_num_rows($res) == 0){
                $clear_login_form["form_login_id"]  = "";
                $clear_login_form["form_password1"] = "";
                $clear_login_form["form_password2"] = "";
                $permit_set_msg = ""; 
                $form->setConstants($clear_login_form);
            }else{
                $sql = "SELECT login_id FROM t_login WHERE staff_id = $staff_id;";
                $res = Db_Query($db_con, $sql);
                $set_login_form["form_login_id"]  = pg_fetch_result($res, 0);
                $set_login_form["form_password1"] = "";
                $set_login_form["form_password2"] = "";
                $form->setConstants($set_login_form);
                $permit_set_msg = "設定済";
            }       
        }       
    }

}

function Create_Ware_Staff($ary){

    $charge_cd  = $ary[0];  //担当者コード
    $staff_name = $ary[1];  //担当者名
    $attach_id  = $ary[2];  //FCショップID  ※本部はセッションのIDをしよう
    $staff_id   = $ary[3];  //登録したスタッフID
    $conn       = $ary[4];  //DBコネクション
    $ware_id    = $ary[5];  //倉庫ID

    //変更
    //倉庫IDがある場合
    if($ware_id != null){
        //倉庫のデータを更新
        $sql  = "UPDATE \n";
        $sql .= "   t_ware \n";
        $sql .= "SET \n";
        $sql .= "   ware_cd   = '$charge_cd',  \n";
        $sql .= "   ware_name = '$staff_name' \n";
        $sql .= "WHERE \n";
        $sql .= "   ware_id = $ware_id \n";
        $sql .= ";";
    //新規登録
    //倉庫IDが無い場合
    }else{
        //倉庫マスタにスタッフ名倉庫を作成
        $sql  = "INSERT INTO t_ware (";
        $sql .= "   ware_id,\n";
        $sql .= "   ware_cd, \n";
        $sql .= "   ware_name,\n";
        $sql .= "   count_flg, \n";
        $sql .= "   nondisp_flg, \n";
        $sql .= "   shop_id, \n";
        $sql .= "   staff_ware_flg \n";
        $sql .= ")VALUES(\n";
        $sql .= "   (SELECT COALESCE(MAX(ware_id),0)+1 FROM t_ware),\n";
        $sql .= "   '$charge_cd',\n";
        $sql .= "   '$staff_name',\n";
        $sql .= "   'f',\n";
        $sql .= "   'f',\n";
        $sql .= "   $attach_id,\n";
        $sql .= "   't' \n";
        $sql .= ");\n";
    }

    $result = Db_Query($conn, $sql);
    if($result === false){
        Db_Query($conn, "ROLLBACk;");
    }

    //登録後の倉庫IDを抽出
    $sql  = "SELECT \n";
    $sql .= "   t_ware.ware_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_ware \n";
    $sql .= "WHERE \n";
    $sql .= "   t_ware.ware_cd = '$charge_cd'\n";
    $sql .= "   AND \n";
    $sql .= "   t_ware.shop_id = $attach_id \n";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $add_ware_id = pg_fetch_result($result, 0, 0);

    return $add_ware_id;
}

/******************************/
//ヘッダーに表示させる全件数
/*****************************/
/** スタッフマスタ取得SQL作成 **/
$sql  = "SELECT ";
$sql .= "    count(staff_id) ";                    //スタッフID
$sql .= "FROM ";
$sql .= "    t_attach ";
$sql .= "WHERE ";
$sql .= "    shop_id = $client_id ";
$res = Db_Query($db_con,$sql.";");
//全件数取得(ヘッダー)
$total_count_h = pg_fetch_result($res,0,0);

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
$page_title .= "(全".$total_count_h."件)";
if ($_SESSION["group_kind"] != "2"){
    $page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
    $page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
}
$page_header = Create_Header($page_title);

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign
$smarty->assign("var", array(
    'html_header'               => "$html_header",
    'page_menu'                 => "$page_menu",
    'page_header'               => "$page_header",
    'html_footer'               => "$html_footer",
    'password_msg'              => "$password_msg",
    'login_info_msg'            => "$login_info_msg",
    'login_msg'                 => "$login_msg",
    'staff_id'                  => "$staff_id",
    'staff_id'                  => "$staff_id",
    'change_flg'                => "$change_flg",
    'back_id'                   => "$back_id",
    'next_id'                   => "$next_id",
    'freeze_flg'                => "$freeze_flg",
    'permit_set_msg'            => "$permit_set_msg",
    'staff_del_restrict_msg'    => "$staff_del_restrict_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
