<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/16) 所属マスタの追加・更新処理の追加(suzuki-t)
 * 1.1.0 (2006/03/21) 登録処理を修正(suzuki-t)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.1.0 (2006/03/21)
*/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/25      21-039      ふ          スタッフ名にスペースのみの登録が可能なバグを修正
 *  2006-12-08      ban_0091    suzuki      削除時にログに残すように修正
 *  2007-01-23      仕様変更    watanabe-k  ボタンの色を変更
 *  2007-02-07                  watanabe-k  スタッフマスタ登録時に担当倉庫を登録する処理を追加
 *  2007-02-09                  ふ          本部による変更不可のスタッフの場合はフリーズさせる処理を追加
 *  2007-02-19                  watanabe-k  支店から部署を登録するように修正
 *  2007-02-27                  watanabe-k  FC側からの変更を許可するというチェックボックスを削除
 *  2007-03-29                  fukuda      ヘッダ部分に出力している件数に本部スタッフが含まれていたため修正
 *  2007/06/25                  fukuda      担当者コードに文字列を入力するとチェック処理のクエリエラーが発生する不具合の修正
 *  2007/06/26      B0702-065   kajioka-h   次へ、前へボタンのソートが一覧と異なるバグ修正
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

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
// 外部パラメータ取得
/****************************/
// GET
$staff_id       = $_GET["staff_id"];                // スタッフID


// SESSION
$client_id      = $_SESSION["client_id"];           // ショップID
$ss_staff_id    = $_SESSION["staff_id"];            // スタッフID（自分）
$group_kind     = $_SESSION["group_kind"];

/* GETしたIDの正当性チェック */
if ($staff_id != null && !ereg("^[0-9]+$", $staff_id)){
    header("Location: ../top.php");
    exit;   
}
if ($staff_id != null && Get_Id_Check_Db($db_con, $staff_id, "staff_id", "t_staff", "num") != true){
    header("Location: ../top.php");
    exit;   
}

if ($staff_id != null){
    $set_id["hdn_staff_id"] = $staff_id;
    $form->setConstants($set_id);
}
if ($_POST["hdn_staff_id"] != null){
    $staff_id = $_POST["hdn_staff_id"];
}


/****************************/
// 権限設定
/****************************/
// 新規/変更初期画面時
if ($_POST == null){
    $_SESSION["109_permit"]         = null;
    $_SESSION["109_permit_delete"]  = null;
    $_SESSION["109_permit_accept"]  = null;
}


// 新規登録時
if ($_POST == null){

    $ary_mod_data = Permit_Item();

    // 本部分権限チェックボックスのSESSIONを作成
    $ary_h_mod_data = $ary_mod_data[0];
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
    $ary_opt = array("r", "w", "n");
    for ($i=0; $i<=$ary_h[0]; $i++){
        for ($j=0; $j<=$ary_h[1][$i-1]; $j++){
            for ($k=0; $k<=$ary_h[2][$i-1][$j-1]; $k++){
                for ($l=0; $l<count($ary_opt); $l++){
                    $_SESSION["109_permit"]["h"][$i][$j][$k][$ary_opt[$l]] = "";
                }
            }
        }
    }

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
                    $_SESSION["109_permit"]["f"][$i][$j][$k][$ary_opt[$l]] = "";
                }
            }
        }
    }

    // 削除、承認権限チェックボックスのSESSION作成
    $_SESSION["109_permit_delete"] = "";
    $_SESSION["109_permit_accept"] = "";

}

// 新規登録時、権限ページで設定ボタンが押下されている＋戻るボタンが押下されていない場合
if ($_POST["set_permit_flg"] != null && $_POST["permit_rtn_flg"] != "true"){

    // POSTされた権限情報をSESSIONにセット
    foreach ($_SESSION["109_permit"] as $key_a => $value_a){
        foreach ($value_a as $key_b => $value_b){
            foreach ($value_b as $key_c => $value_c){
                foreach ($value_c as $key_d => $value_d){
                    foreach ($value_d as $key_e => $value_e){
                        $_SESSION["109_permit"][$key_a][$key_b][$key_c][$key_d][$key_e] = 
                        ($_POST["permit"][$key_a][$key_b][$key_c][$key_d][$key_e] != null) ?
                        $_POST["permit"][$key_a][$key_b][$key_c][$key_d][$key_e] : "";
                    }
                }
            }
        }
    }
    $_SESSION["109_permit_delete"]  = ($_POST["permit_delete"] != null) ? $_POST["permit_delete"] : "";
    $_SESSION["109_permit_accept"]  = ($_POST["permit_accept"] != null) ? $_POST["permit_accept"] : "";

}

// 新規登録時、権限ページで戻るボタンが押下された場合
if ($_POST["permit_rtn_flg"] == "true"){

    // SESSIONにセットしてある権限情報をPOSTにセット
    $_POST["permit"]        = $set_permit["permit"]         = $_SESSION["109_permit"];
    $_POST["permit_delete"] = $set_permit["permit_delete"]  = $_SESSION["109_permit_delete"];
    $_POST["permit_accept"] = $set_permit["permit_accept"]  = $_SESSION["109_permit_accept"];
    $form->setConstants($set_permit);

    // 権限ページの戻るボタンフラグをクリア
    $clear["permit_rtn_flg"] = "";
    $form->setConstants($clear);

}


/****************************/
// 初期処理
/****************************/
/* 本部変更不可能フラグを確認 */
if ($staff_id != null){
    $sql = "SELECT h_change_flg FROM t_staff WHERE staff_id = $staff_id;";
    $res = Db_Query($db_con, $sql);
    $h_change_ng_flg = (pg_fetch_result($res, 0) == "t") ? true : false;
}

/* 所属関連メッセージ */
// 得意先が指定されていなければメッセージ出力
if (($_POST["form_staff_kind"] == null || $_POST["form_staff_kind"] == "0") && $staff_id == null){
    $warning1 = "スタッフ種別を選択して下さい。";
}else{
    $warning1 = null;
}

// ショップ名が指定されていなければメッセージ出力
if ($_POST["form_cshop"] == null && $staff_id == null && $_POST["form_staff_kind"] != 3){
    $warning2 = "ショップ名を選択して下さい。";
}else{
    $warning2 = null;
}

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
        $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "設定しました" : null;
    }
// スタッフ新規登録時
}else{
    $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "設定しました" : null;
}
$cons_data["permit_set_msg"] = "$permit_set_msg";
$form->setConstants($cons_data);

/****************************/
// フォームデフォルト値設定
/****************************/
// 登録・変更判定
if ($staff_id != null && $_POST["first_time"] == false){

    // 該当スタッフデータ取得
    $sql  = "SELECT ";
    $sql .= "    staff_cd1, ";                      // ネットワーク証ID１
    $sql .= "    staff_cd2, ";                      // ネットワーク証ID２
    $sql .= "    charge_cd,";                       // 担当者コード
    $sql .= "    staff_name, ";                     // スタッフ名
    $sql .= "    staff_read, ";                     // スタッフ名(フリガナ)
    $sql .= "    staff_ascii, ";                    // スタッフ名(ローマ字)
    $sql .= "    sex, ";                            // 性別
    $sql .= "    birth_day, ";                      // 生年月日
    $sql .= "    state, ";                          // 在職識別
    $sql .= "    join_day, ";                       // 入社年月日
    $sql .= "    retire_day, ";                     // 退職日
    $sql .= "    employ_type , ";                   // 雇用形態
    $sql .= "    position, ";                       // 役職
    $sql .= "    job_type, ";                       // 職種
    $sql .= "    study, ";                          // 研修履歴
    $sql .= "    toilet_license, ";                 // トイレ診断士資格
    $sql .= "    license, ";                        // 取得資格
    $sql .= "    note, ";                           // 備考
    $sql .= "    photo,";                           // 写真（ファイル名）
    $sql .= "    change_flg, ";                     // 変更不可能フラグ
    $sql .= "    t_login.login_id, ";               // ログインID
    $sql .= "    t_attach.shop_id, ";
    $sql .= "    t_staff.round_staff_flg ";
    $sql .= "FROM ";
    $sql .= "    t_staff ";
    $sql .= "        LEFT JOIN t_login ON t_staff.staff_id = t_login.staff_id ";
    $sql .= "        LEFT JOIN t_attach ON t_staff.staff_id = t_attach.staff_id ";
    $sql .= "WHERE ";
    $sql .= "    t_staff.staff_id = $staff_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    // GETデータ判定（不正であればTOPへ遷移）
    Get_Id_Check($res);
    $data_list = pg_fetch_array($res, 0, PGSQL_ASSOC);

    // フォームに値を復元
    $def_fdata["form_change_flg"]           = ($data_list["change_flg"] == "t") ?  true : false;
    $def_fdata["form_staff_cd"]["cd1"]      = $data_list["staff_cd1"];
    $def_fdata["form_staff_cd"]["cd2"]      = $data_list["staff_cd2"];
    $def_fdata["form_staff_name"]           = $data_list["staff_name"]; 
    $def_fdata["form_staff_read"]           = $data_list["staff_read"]; 
    $def_fdata["form_staff_ascii"]          = $data_list["staff_ascii"];
    $def_fdata["form_sex"]                  = $data_list["sex"];
    $def_fdata["form_birth_day"]["y"]       = substr($data_list["birth_day"], 0, 4);
    $def_fdata["form_birth_day"]["m"]       = substr($data_list["birth_day"], 5, 2);
    $def_fdata["form_birth_day"]["d"]       = substr($data_list["birth_day"], 8, 2);
    $def_fdata["form_retire_day"]["y"]      = substr($data_list["retire_day"], 0, 4);
    $def_fdata["form_retire_day"]["m"]      = substr($data_list["retire_day"], 5, 2);
    $def_fdata["form_retire_day"]["d"]      = substr($data_list["retire_day"], 8, 2);
    $def_fdata["form_study"]                = $data_list["study"];
    $def_fdata["form_toilet_license"]       = $data_list["toilet_license"];
    $def_fdata["form_photo"]                = $data_list["photo"];
    $def_fdata["form_photo_del"]            ="1";

    $def_fdata["form_charge_cd"]            = str_pad($data_list["charge_cd"], 4, 0, STR_POS_LEFT); 
    $def_fdata["form_join_day"]["y"]        = substr($data_list["join_day"], 0, 4);
    $def_fdata["form_join_day"]["m"]        = substr($data_list["join_day"], 5, 2);
    $def_fdata["form_join_day"]["d"]        = substr($data_list["join_day"], 8, 2);
    $def_fdata["form_employ_type"]          = $data_list["employ_type"]; 
    $def_fdata["form_position"]             = $data_list["position"];
    $def_fdata["form_state"]                = $data_list["state"];
    $def_fdata["form_job_type"]             = $data_list["job_type"]; 
    $def_fdata["form_note"]                 = $data_list["note"];
    $def_fdata["form_license"]              = $data_list["license"];
    $def_fdata["form_round_staff"]          = ($data_list["round_staff_flg"] == "t") ? true : false;

    $def_fdata["form_login_id"]             = $data_list["login_id"];

    // 次へ、前へボタンのリンク先を取得
    //$id_data = Make_Get_Id($db_con, "staff", $data_list["charge_cd"]);
    $id_data = Make_Get_Id($db_con, "staff", $staff_id);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

    // 所属マスタから変更情報取得
    $sql  = "SELECT ";
    $sql .= "    t_attach.shop_id, ";                //取引先ID
    $sql .= "    t_attach.part_id, ";                //部署ID
    $sql .= "    t_attach.section, ";                //所属部署（課）
    $sql .= "    t_attach.ware_id, ";                //倉庫ID
    $sql .= "    CASE t_rank.group_kind";           //スタッフ種別
    $sql .= "        WHEN '1' THEN '3' ";
    $sql .= "        WHEN '2' THEN '2' ";
    $sql .= "        WHEN '3' THEN '1' ";
    $sql .= "    END, ";
    $sql .= "    t_part.branch_id ";
    $sql .= "FROM ";
    $sql .= "    t_attach "; 
    $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
    $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd  ";
    $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
    $sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
    $sql .= "WHERE ";
    $sql .= "    t_attach.staff_id = $staff_id ";
    $res  = Db_Query($db_con, $sql.";");

    $data_num = pg_num_rows($res);

    // 本部・直営($data_num == 2)の場合は、二件該当する為
    if ($data_num == 2){

        // 本部
        $head_sql  = "SELECT ";
        $head_sql .= "    t_client.client_id, ";             // 本部ID
        $head_sql .= "    t_client.client_name, ";           // 本部名
        $head_sql .= "    t_attach.part_id, ";               // 部署ID
        $head_sql .= "    t_attach.section, ";               // 所属部署
        $head_sql .= "    t_attach.ware_id  ";              // 倉庫ID
        $head_sql .= "FROM ";
        $head_sql .= "    t_attach "; 
        $head_sql .= "      INNER JOIN \n";
        $head_sql .= "    t_client \n";
        $head_sql .= "    ON t_attach.shop_id = t_client.client_id ";
        $head_sql .= "WHERE ";
        $head_sql .= "    t_attach.staff_id = $staff_id ";
        $head_sql .= "AND ";
        $head_sql .= "    t_client.client_div = '0' ";
        $head_sql .= "AND ";
        $head_sql .= "    h_staff_flg = 't'";

        $res       = Db_Query($db_con, $head_sql.";");
        $data_list = pg_fetch_array($res, 0, PGSQL_ASSOC);

        $def_fdata["client_id_head"]                        = $data_list["client_id"];
        $def_fdata["form_cshop_head"]                       = $data_list["client_name"];
        $def_fdata["form_part_head"]                        = $data_list["part_id"];
        $def_fdata["form_section_head"]                     = $data_list["section"];
        $def_fdata["form_ware_head"]                        = $data_list["ware_id"];

        // 直営
        $sql  = "SELECT ";
        $sql .= "    t_attach.shop_id, ";                //取引先ID
        $sql .= "    t_attach.part_id, ";                //部署ID
        $sql .= "    t_attach.section, ";                //所属部署（課）
        $sql .= "    t_attach.ware_id, ";                //倉庫ID
        $sql .= "    CASE t_rank.group_kind";           //スタッフ種別
        $sql .= "        WHEN '1' THEN '3' ";
        $sql .= "        WHEN '2' THEN '2' ";
        $sql .= "        WHEN '3' THEN '1' ";
        $sql .= "    END, ";
        $sql .= "    t_part.branch_id ";
        $sql .= "FROM ";
        $sql .= "    t_attach "; 
        $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
        $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd  ";
        $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
        $sql .= "    INNER JOIN t_part ON t_attach.part_id = t_part.part_id ";
        $sql .= "WHERE ";
        $sql .= "    t_attach.staff_id = $staff_id ";
        $sql .= "    AND \n";
        $sql .= "    t_attach.h_staff_flg = 'f' \n";

        $res       = Db_Query($db_con, $sql);
        $data_list = pg_fetch_array($res, 0, PGSQL_ASSOC);
        $def_fdata["form_cshop"]                            = $data_list["shop_id"];
        $cshop_id                                           = $data_list["shop_id"];
        $def_fdata["form_section"]                          = $data_list["section"];
        $def_fdata["form_ware"]                             = $data_list["ware_id"];
        $def_fdata["form_part"][0]                          = $data_list["branch_id"];
        $def_fdata["form_part"][1]                          = $data_list["part_id"];
        $def_fdata["form_staff_kind"]                       = "4";
        $cshop_head_flg                                     = "true";           // 本部入力欄表示フラグ

    }else{

        // FC・直営
        $data_list = pg_fetch_array($res, 0, PGSQL_ASSOC);
        $def_fdata["form_cshop"]                            = $data_list["shop_id"];
        $cshop_id                                           = $data_list["shop_id"];
//        $def_fdata["form_part"]                             = $data_list["part_id"];
        $def_fdata["form_section"]                          = $data_list["section"];
        $def_fdata["form_ware"]                             = $data_list["ware_id"];
        $def_fdata["form_part"][0]                          = $data_list["branch_id"];
        $def_fdata["form_part"][1]                          = $data_list["part_id"];
        $staff_kind                                         = $data_list["case"];

        // 本部
        $head_sql  = "SELECT ";
        $head_sql .= "    t_client.client_id, ";             // 本部ID
        $head_sql .= "    t_client.client_name, ";           // 本部名
        $head_sql .= "    t_attach.part_id, ";               // 部署ID
        $head_sql .= "    t_attach.section, ";               // 所属部署
        $head_sql .= "    t_attach.ware_id  ";               // 倉庫ID
        $head_sql .= "FROM ";
        $head_sql .= "    t_attach "; 
        $head_sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
        $head_sql .= "WHERE ";
        $head_sql .= "    t_attach.staff_id = $staff_id ";
        $head_sql .= "AND ";
        $head_sql .= "    t_client.client_div = '0' ";
        $head_sql .= "AND ";
        $head_sql .= "    h_staff_flg = 't';";
        $res       = Db_Query($db_con, $head_sql);
        $data_num  = pg_num_rows($res);
        if ($data_num != 0){
            $data_list = pg_fetch_array($res, 0);
            $def_fdata["client_id_head"]                    = $data_list["clietn_id"];
            $def_fdata["form_cshop_head"]                   = $data_list["client_name"];
            $def_fdata["form_part_head"]                    = $data_list["part_id"];
            $def_fdata["form_section_head"]                 = $data_list["section"];
            $def_fdata["form_ware_head"]                    = $data_list["ware_id"];
            //本部入力欄表示フラグ(ショップ名欄は無し)
            $only_head_flg                                  = "true";
        }
        $def_fdata["form_staff_kind"]                       = $staff_kind;
    }

    //変更の初期表示処理は、一番最初だけしか行わないようにする
    $def_fdata["first_time"]                                = true;

}else{

    $def_fdata = array(
        "form_sex"              => "1",
        "form_state"            => "在職中",
        "form_employ_type"      => "正スタッフ",
        "form_job_type"         => "営業",
        "form_toilet_license"   => "3"
    );

}
$def_fdata["form_login_info"] = "1";

$form->setDefaults($def_fdata);


/****************************/
// 設定できる権限を調べる
/****************************/
// スタッフ種別に入力があるけど0(未選択)ではない
// またはクエリで取得してきたスタッフ種別がある場合
if (($_POST["form_staff_kind"] != null && $_POST["form_staff_kind"] != 0 ) || $def_fdata["form_staff_kind"] != null){
    $select_staff_kind = true;
    $staff_kind_auth = ($def_fdata["form_staff_kind"] != null) ? $def_fdata["form_staff_kind"] : $_POST["form_staff_kind"];
}else{
    $select_staff_kind = false;
}

// 選択されたスタッフ種別から設定可能な権限を調べる
if ($select_kind_auth == true){

    switch ($staff_kind_auth){
        case 1:
            $auth_type = array("fc");
            break;
        case 2:
            $auth_type = array("fc");
            break;
        case 3:
            $auth_type = array("head");
            break;
        case 4:
            $auth_type = array("head", "fc");
            break;
    }

}


/****************************/
// フォームパーツ定義
/****************************/
// スタッフ種別
$select_value = array(
/*
    "",
    "FCスタッフ",
    "直営スタッフ",
    "本部スタッフ",
    "本部・直営スタッフ",
*/
    ""  => "",
    "1" => "FCスタッフ",
    "4" => "本部・直営スタッフ",
);
//$freeze1=$form->addElement("select", "form_staff_kind", "", $select_value, "onChange=\"javascript: Button_Submit('staff_search_flg','#','true');window.focus();\"");
$freeze1=$form->addElement("select", "form_staff_kind", "", $select_value, "onChange=\"javascript: Button_Submit('staff_search_flg','#','true');\"");

// 本部
// スタッフ種別が（本部）or（本部・直営）の場合
$form->addElement("text", "form_cshop_head", "", "size=\"34\" maxLength=\"15\" style=\"color: #585858; border: white 1px solid; background-color: white; text-align: left\" readonly");

// ショップ名
// スタッフ種別が（本部・直営）or（直営）の場合
if ($_POST["form_staff_kind"] == 2 || $_POST["form_staff_kind"] == 4 || $staff_kind == 2 || $staff_kind == 4 || $cshop_head_flg == "true"){
    // 直営のショップ
//    $select_value = Select_Get($db_con, "dshop");
    $sql = "SELECT client_id, client_cd1, client_cd2, client_cname FROM t_client where client_id = 93;";
    $result = Db_Query($db_con,$sql);
    $select_value = null;
    $select_value[""] = "";
    while($data_list = pg_fetch_array($result)){
        $data_list[0] = htmlspecialchars($data_list[0]);
        $data_list[1] = htmlspecialchars($data_list[1]);
        $data_list[2] = htmlspecialchars($data_list[2]);
        $data_list[3] = htmlspecialchars($data_list[3]);
        $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." ： ".$data_list[3];
    } 
    $group_kind = 2;
// スタッフ種別が（FC）の場合
}else if ($_POST["form_staff_kind"] == 1 || $staff_kind == 1){
    // FCのショップ
    $select_value = Select_Get($db_con, "fshop");
    $group_kind = null;
}else{
    // 初期値
    $select_value = null;
    $group_kind = null;
}
//$freeze2=$form->addElement("select", "form_cshop", "", $select_value, "onChange=\"javascript:Button_Submit('cshop_search_flg','#','true');window.focus();\"");
$freeze2=$form->addElement("select", "form_cshop", "", $select_value, "onChange=\"javascript:Button_Submit('cshop_search_flg','#','true');\"");

//変更の場合にショップ間でのスタッフの移動を不可とする
if($staff_id != null){
    $freeze1->freeze();
    $freeze2->freeze();
}

// 在職識別
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "在職中", "在職中");
$radio[] =& $form->createElement("radio", null, null, "退職", "退職");
$radio[] =& $form->createElement("radio", null, null, "休業", "休業");
$change_ng_freeze_radio = $form->addGroup($radio, "form_state", "在職");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// FC側からの変更を許可しない
$change_ng_freeze[] = $form->addElement("checkbox", "form_change_flg", "", "FC側からの変更を許可しない");

// ネットワーク証ID
$text = "";
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_staff_cd[cd1]','form_staff_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"3\" maxLength=\"3\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup($text, "form_staff_cd", "form_staff_cd");

// スタッフ名
$change_ng_freeze[] = $form->addElement("text", "form_staff_name", "", "size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

// スタッフ名(フリガナ)
$change_ng_freeze[] = $form->addElement("text", "form_staff_read", "", "size=\"22\" maxLength=\"20\" ".$g_form_option."\"");

// スタッフ名(ローマ字)
$change_ng_freeze[] = $form->addElement("text", "form_staff_ascii", "", "size=\"22\" maxLength=\"30\" ".$g_form_option."\"");

// 性別
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "男", "1");
$radio[] =& $form->createElement("radio", null, null, "女", "2");
$change_ng_freeze_radio = $form->addGroup($radio, "form_sex", "性別");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// 生年月日    
$text="";
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_birth_day[y]','form_birth_day[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_birth_day[m]','form_birth_day[d]',2)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addGroup($text, "form_birth_day", "form_birth_day");

// 退職日
$text="";
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_retire_day[y]','form_retire_day[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_retire_day[m]','form_retire_day[d]',2)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addGroup($text, "form_retire_day", "form_retire_day");

// 研修履歴
$change_ng_freeze[] = $form->addElement("text", "form_study", "", "size=\"34\" maxLength=\"50\" ".$g_form_option."\"");

// トイレ診断資格
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "１級トイレ診断士", "1");
$radio[] =& $form->createElement("radio", null, null, "２級トイレ診断士", "2");
$radio[] =& $form->createElement("radio", null, null, "無", "3");
$change_ng_freeze_radio = $form->addGroup($radio, "form_toilet_license", "トイレ診断資格");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// ファイル（証明写真）
if ($h_change_ng_flg != true){
    $form->addElement("file", "form_photo_ref", "証明写真", "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\"");
}

// 証明写真ファイル名
$form->addElement("hidden", "form_photo");

// 証明写真削除
// 登録判定
if ($staff_id != null && $h_change_ng_flg != true){
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "削除しない<br>", "1");
    $radio[] =& $form->createElement("radio", null, null, "削除する", "2");
    $form->addGroup($radio, "form_photo_del", "証明写真");
}

// 担当者コード
$change_ng_freeze[] = $form->addElement("text", "form_charge_cd", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");

// 入社年月日
$text="";
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_join_day[y]','form_join_day[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_join_day[m]','form_join_day[d]',2)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addGroup($text, "form_join_day", "form_join_day");

// 雇用形態
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "正スタッフ", "正スタッフ");
$radio[] =& $form->createElement("radio", null, null, "パート", "パート");
$radio[] =& $form->createElement("radio", null, null, "アルバイト", "アルバイト");
$radio[] =& $form->createElement("radio", null, null, "契約", "契約");
$radio[] =& $form->createElement("radio", null, null, "委託", "委託");
$radio[] =& $form->createElement("radio", null, null, "その他", "その他");
$change_ng_freeze_radio = $form->addGroup($radio, "form_employ_type", "雇用形態");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// 職種
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "営業", "営業");
$radio[] =& $form->createElement("radio", null, null, "サービス", "サービス");
$radio[] =& $form->createElement("radio", null, null, "事務", "事務");
$radio[] =& $form->createElement("radio", null, null, "その他", "その他");
$change_ng_freeze_radio = $form->addGroup($radio, "form_job_type", "職種");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// 役職部署（本部）
/*
$select_value = Select_Get($db_con, "part");
$change_ng_freeze[] = $form->addElement("select", "form_part_head", "", $select_value, $g_form_option_select);
*/

// 所属部署(課)（本部）
$change_ng_freeze[] = $form->addElement("text", "form_section_head", "", "size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

// 所属部署(課)
$change_ng_freeze[] = $form->addElement("text", "form_section", "", "size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

// 役職
$change_ng_freeze[] = $form->addElement("text", "form_position", "", "size=\"15\" maxLength=\"7\" ".$g_form_option."\"");

// 取得資格
$change_ng_freeze[] = $form->addElement("textarea", "form_license", "", "rows=\"5\" cols=\"59\"".$g_form_option_area."\"");

// 備考
//$change_ng_freeze[] = $form->addElement("text", "form_note", "", "size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addElement("textarea", "form_note", "", "rows=\"5\" cols=\"59\"".$g_form_option_area."\"");

// 巡回担当者
$change_ng_freeze[] = $form->addElement("checkbox", "form_round_staff", "", "");

// ログイン情報の扱い
$radio = null;
$radio[] =& $form->createElement("radio", null, null, $login_info_type."しない", "1");
$radio[] =& $form->createElement("radio", null, null, $login_info_type."する", "2");
if ($login_info_type == "変更"){$radio[] =& $form->createElement("radio", null, null, "削除する", "3");}
$change_ng_freeze_radio = $form->addGroup($radio, "form_login_info", "ログイン情報の扱い");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

//ログインID
$change_ng_freeze[] = $form->addElement("text", "form_login_id", "", "size=\"24\" maxLength=\"20\" style=\"$g_form_style\" ".$g_form_option."\"");

//パスワード＆パスワード（確認）
$change_ng_freeze[] = $form->addElement("password", "form_password1", "", "size=\"24\" maxLength=\"20\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addElement("password", "form_password2", "", "size=\"24\" maxLength=\"20\" ".$g_form_option."\"");

//登録画面ボタン（ヘッダ部）
//$form->addElement("button", "new_button", "登録画面", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button", "new_button", "登録画面",$g_button_color."  onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//変更・一覧ボタン（ヘッダ部）
$form->addElement("button", "change_button", "変更・一覧", "onClick=\"javascript:Referer('1-1-107.php')\"");


// スタッフ種別が（本部）or（本部・直営）の場合
if ($_POST["form_staff_kind"] == 3 || $_POST["form_staff_kind"] == 4 || $cshop_head_flg == "true" || $only_head_flg == "true"){
    // 本部ID取得
    $sql  = "SELECT ";
    $sql .= "    client_id, ";
    $sql .= "    client_name ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_div = '0' ";
    $aql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    // 該当データ有
    if ($num == 1){
        $data_list = pg_fetch_array($res, 0);
        $head_data["client_id_head"]  = $data_list[0];
        $head_data["form_cshop_head"] = $data_list[1];
    }
    // 初期化
    $head_data["staff_search_flg"] = "";
    $form->setConstants($head_data);
}

// 担当倉庫（本部）
$where  = "WHERE shop_id = $client_id";
$where .= " AND nondisp_flg = 'f'";
$select_value = Select_Get($db_con, "ware", $where);
$change_ng_freeze[] = $form->addElement("select", "form_ware_head", "", $select_value, $g_form_option_select);

// ＦＣ・直営の所属グループ取得
if ($_POST["form_cshop"] != null || $staff_kind == 1 || $staff_kind == 2 || $cshop_head_flg == "true"){
    if ($_POST["form_cshop"] != null){
        $cshop_id = $_POST["form_cshop"];
    }
    
    // 初期化
    $fc_data["cshop_search_flg"] = "";
    $form->setConstants($fc_data);
}

// 所属部署
$obj_bank_select =& $form->addElement("hierselect", "form_part", "", "");
/*
if ($cshop_id != null){
    $where  = "WHERE ";
    $where .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql("0003").") " : " shop_id = $cshop_id ";
    $select_value = Select_Get($db_con, "part", $where);
}else{
    // 初期値
    $select_value = null;
}
$change_ng_freeze[] = $form->addElement("select", "form_part", "", $select_value, $g_form_option_select);
*/
$cshop_id;
if($cshop_id != null){
    $obj_bank_select->setOptions(Make_Ary_Branch($db_con, $cshop_id));
}else{
    $obj_bank_select->setOptions(null);
}


// 担当倉庫
// 担当倉庫は画面には表示しないため、hiddenで値を持ちまわる
/*
if ($cshop_id != null){
//    $where  = "WHERE shop_id = $cshop_id ";
    $where  = "WHERE ";
    $where .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql("0003").") " : " shop_id = $cshop_id ";
    $where .= "AND nondisp_flg = 'f'";
    // 初期値
    $select_value = null;
    $select_value = Select_Get($db_con, "ware", $where);
}else{
    // 初期値
    $select_value = null;
}
$form->addElement("select", "form_ware", "", $select_value, $g_form_option_select);
*/
$form->addElement("hidden", "form_ware");


/*** hiddenフォーム ***/
// スタッフ種別フラグ
$form->addElement("hidden", "staff_search_flg");
// ショップ名フラグ
$form->addElement("hidden", "cshop_search_flg");
// 本部ID
$form->addElement("hidden", "client_id_head");
// 初期表示フラグ
$form->addElement("hidden", "first_time");
// 権限未設定エラー埋め込み用フォーム
$form->addElement("text", "permit_error");
// 権限設定済フラグ
$form->addElement("hidden", "set_permit_flg");
// スタッフID
$form->addElement("hidden", "hdn_staff_id");


/****************************/
// フォームパーツ定義 - 権限
/****************************/
/*** 本部チェックボックス要素の個数設定 ***/
$ary_mod_data = Permit_Item();

$ary_h_mod_data = $ary_mod_data[0];

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

$ary_opt = array("r", "w", "n");
for ($i=0; $i<=$ary_h[0]; $i++){
    for ($j=0; $j<=$ary_h[1][$i-1]; $j++){
        for ($k=0; $k<=$ary_h[2][$i-1][$j-1]; $k++){
            for ($l=0; $l<count($ary_opt); $l++){
                $me = "permit[h][$i][$j][$k][$ary_opt[$l]]";
                $form->addElement("hidden", $me, "");
            }
        }
    }
}

/*** FCチェックボックス要素の個数設定 ***/
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
    //エラーチェック(AddRule)
    /****************************/
    //本部の場合はチェック無し
    if ($_POST["form_staff_kind"] != 3){
        /*** ショップ名 ***/
        // 必須チェック
        $form->addRule("form_cshop", "ショップ名を選択して下さい。", "required");
    }

    /*** ネットワーク証ID ***/
    // 文字種チェック
    $form->addGroupRule("form_staff_cd", array(
        "cd1" => array(
            array("ネットワーク証ID は半角数字のみです。", "regex", "/^[0-9]+$/")
        ),
        "cd2" => array(
            array("ネットワーク証ID は半角数字のみです。", "regex", "/^[0-9]+$/"),
        )
    ));

    /*** 担当者コード ***/
    // 必須チェック
    $form->addRule("form_charge_cd", "担当者コード は半角数字のみです。", "required");
    // 文字種チェック
    $form->addRule("form_charge_cd", "担当者コード は半角数字のみです。", "regex", "/^[0-9]+$/");

    /*** スタッフ名 ***/
    // 必須チェック
    $form->addRule("form_staff_name", "スタッフ名 は10文字以内です。", "required");
    // スペースチェック
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_staff_name", "スタッフ名に スペースのみの登録はできません。", "no_sp_name");

    /*** スタッフ名（ローマ字）***/
    // 必須チェック
    $form->addRule("form_staff_ascii", "スタッフ名(ローマ字) はアスキーコードのみ使用可です。", "required");
    //・文字種チェック
    $form->addRule("form_staff_ascii", "スタッフ名(ローマ字) はアスキーコードのみ使用可です。", "ascii");

    /*** 証明写真 ***/
    // 拡張子チェック
    $form->addRule("form_photo_ref", "不正な画像ファイルです。", "mimetype", array("image/jpeg", "image/jpeg", "image/pjpeg"));

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

    /*** 退職日***/
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
    $form->addRule("form_license", "取得資格 は200文字以内です。", "mb_maxlength", "200");

    /*** 備考 ***/
    // 文字数チェック
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note", "備考 は2000文字以内です。", "mb_maxlength", "2000");

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

    // POST取得
    $cshop_id       = $_POST["form_cshop"];                 // ショップID
    $change_flg     = $_POST["form_change_flg"];            // 変更不可能フラグ
    $staff_cd1      = $_POST["form_staff_cd"]["cd1"];       // ネットワーク証ID1
    $staff_cd2      = $_POST["form_staff_cd"]["cd2"];       // ネットワーク証ID2
    $staff_name     = $_POST["form_staff_name"];            // スタッフ名
    $charge_cd      = $_POST["form_charge_cd"];             // 担当者コード
    $staff_name     = $_POST["form_staff_name"];            // スタッフ名
    $staff_read     = $_POST["form_staff_read"];            // スタッフ名(フリガナ)
    $staff_ascii    = $_POST["form_staff_ascii"];           // スタッフ名(ローマ字)
    $sex            = $_POST["form_sex"];                   // 性別
    $birth_day_y    = $_POST["form_birth_day"]["y"];        // 生年月日
    $birth_day_m    = $_POST["form_birth_day"]["m"]; 
    $birth_day_d    = $_POST["form_birth_day"]["d"];
    $state          = $_POST["form_state"];                 // 在職識別
    $join_day_y     = $_POST["form_join_day"]["y"];         // 入社年月日
    $join_day_m     = $_POST["form_join_day"]["m"];     
    $join_day_d     = $_POST["form_join_day"]["d"];
    $retire_day_y   = $_POST["form_retire_day"]["y"];       // 退職日
    $retire_day_m   = $_POST["form_retire_day"]["m"];    
    $retire_day_d   = $_POST["form_retire_day"]["d"];
    $employ_type    = $_POST["form_employ_type"];           // 雇用形態
    $part_id        = $_POST["form_part"][1];               // 部署ID
    $section        = $_POST["form_section"];               // 所属部署（課）
    $position       = $_POST["form_position"];              // 役職
    $job_type       = $_POST["form_job_type"];              // 職種
    $ware_id_head   = $_POST["form_ware_head"];             // 担当倉庫ID (本部)
    $study          = $_POST["form_study"];                 // 研修履歴
    $toilet_license = $_POST["form_toilet_license"];        // トイレ診断士資格
    $license        = $_POST["form_license"];               // 取得資格
    $note           = $_POST["form_note"];                  // 備考
    $ware_id        = $_POST["form_ware"];                  // 担当倉庫ID
    $photo_del      = $_POST["form_photo_del"];             // 写真削除フラグ
    $photo          = $_POST["form_photo"];                 // 写真ファイル名
    $login_info     = $_POST["form_login_info"];            // ログイン情報の扱い
    $login_id       = $_POST["form_login_id"];              // ログインID
    $password1      = $_POST["form_password1"];             // パスワード
    $password2      = $_POST["form_password2"];             // パスワード確認
    $round_staff    = ($_POST["form_round_staff"] == "1") ? "t" : "f";

    // 本部情報POST取得
    $client_id_head = $_POST["client_id_head"];             // ショップID (本部)
    $part_id_head   = $_POST["form_part_head"];             // 部署ID (本部)
    $section_head   = $_POST["form_section_head"];          // 所属部署(課) (本部)

    /****************************/
    //エラーチェック(PHP)
    /****************************/
    /*** ネットワーク証ID ***/
    // 重複チェック
    if ($staff_cd1 != null && $staff_cd2 != null){

        // ネットワーク証ID0埋め
        $staff_cd1 = str_pad($staff_cd1, 6, 0, STR_POS_LEFT);
        $staff_cd2 = str_pad($staff_cd2, 3, 0, STR_POS_LEFT);

        //入力されたネットワーク証IDがマスタに存在するかチェック
        $sql  = "SELECT ";
        $sql .= "   staff_cd1, ";
        $sql .= "   staff_cd2 ";
        $sql .= "FROM ";
        $sql .= "   t_staff ";
        $sql .= "WHERE ";
        $sql .= "   staff_cd1 = '$staff_cd1' ";
        $sql .= "AND ";
        $sql .= "   staff_cd2 = '$staff_cd2' ";
        //変更の場合は、自分のデータ以外を参照する
        if ($staff_id != null){
            $sql .= "AND NOT ";
            $sql .= "   staff_id = '$staff_id' ";
        }
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($res);
        if ($row_count != 0){
            $form->setElementError("form_staff_cd", "既に使用されている ネットワーク証ID です。");
        }

    }

    // 方側のみの入力はエラー
    if ($staff_cd1 != null || $staff_cd2 != null){
        if ($staff_cd1 == null || $staff_cd2 == null){
            $form->setElementError("form_staff_cd", "ネットワーク証ID は半角数字のみです。");
        }
    }

    /*** 担当者コード ***/
    // 重複チェック
//    if ($charge_cd != null && $cshop_id != null){
    if ($charge_cd != null && ereg("^[0-9]+$", $charge_cd)){

        //FCのショップの重複チェック
        if ($_POST["form_staff_kind"] == 1 && $cshop_id != null){

            //担当者コード0埋め
            $charge_cd = str_pad($charge_cd, 4, 0, STR_POS_LEFT);

            //入力したコードがマスタに存在するかチェック
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = $charge_cd ";
            $sql .= "AND ";
            $sql .= "    t_attach.shop_id = $cshop_id ";
            
            //変更の場合は、自分のデータ以外を参照する
            if ($staff_id != null){
                $sql .= "AND NOT ";
                $sql .= "   t_attach.staff_id = '$staff_id'";
            }
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_charge_cd", "既に使用されている 担当者コード です。");
            }

        }
        //直営のショップの重複チェック
        if (($_POST["form_staff_kind"] == 2 || $_POST["form_staff_kind"] == 4) && $cshop_id != null){

            //担当者コード0埋め
            $charge_cd = str_pad($charge_cd, 4, 0, STR_POS_LEFT);

            //入力したコードがマスタに存在するかチェック
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
            $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = $charge_cd ";
            $sql .= "AND ";
            $sql .= "    t_rank.rank_cd = (";
            $sql .= "                     SELECT ";
            $sql .= "                         rank_cd ";
            $sql .= "                     FROM ";
            $sql .= "                         t_client ";
            $sql .= "                     WHERE ";
            $sql .= "                         client_id = $cshop_id ";
            $sql .= "                     ) ";
            
            //変更の場合は、自分のデータ以外を参照する
            if ($staff_id != null){
                $sql .= "AND NOT ";
                $sql .= "   t_attach.staff_id = '$staff_id'";
            }
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_charge_cd", "既に使用されている 担当者コード です。");
            }

        }

        // 本部グループでの担当者コードの重複チェック
        if (($_POST["form_staff_kind"] == 3 || $_POST["form_staff_kind"] == 4)  && $cshop_id == null){

            //入力したコードがマスタに存在するかチェック
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = '$charge_cd' ";
            $sql .= "AND ";
            $sql .= "    t_attach.shop_id = $client_id_head ";

            //変更の場合は、自分のデータ以外を参照する
            if ($staff_id != null){
                $sql .= " AND NOT ";
                $sql .= "t_attach.staff_id = '$staff_id'";
            }
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_charge_cd", "既に使用されている 担当者コード です。");
            }

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
            $form->setElementError("form_birth_day", "生年月日 が妥当ではありません。");
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
            $form->setElementError("form_join_day", "入社年月日 が妥当ではありません。");
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
            $form->setElementError("form_retire_day", "退職日 が妥当ではありません。");
        }
    }else{
        $retire_day = "null";
    }

    // ログイン情報登録・変更にチェックが付いている場合
    if ($_POST["form_login_info"] == "2"){

        /*** ログインID ***/
        // 文字種チェック
        if (!ereg("^[0-9a-zA-Z_-]+$", $login_id) && $login_id != null){
            $form->setElementError("form_login_id", "ログインID は半角英数字、ハイフン、アンダーバーのみ使用可です。");
        }

        // 重複チェック
        if ($login_id != null){
            // 入力したコードがマスタに存在するかチェック
            $sql  = "SELECT ";
            $sql .= "   login_id ";
            $sql .= "FROM ";
            $sql .= "   t_login ";
            $sql .= "WHERE ";
            $sql .= "   login_id = '$login_id' ";
            // 変更の場合は、自分のデータ以外を参照する
            if ($staff_id != null){
                $sql .= "AND NOT ";
                $sql .= "   staff_id = '$staff_id' ";
            }
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_login_id", "既に使用されている ログインID です。");
            }
        }

        /*** パスワード・パスワード確認 ***/
        // 文字種チェック
        if (!ereg("^[0-9a-zA-Z_-]+$", $password1) && $password1 != null){
            $form->setElementError("form_password1", "パスワード は半角英数字、ハイフン、アンダーバーのみ使用可です。");
        }
        // 値が等しいか
        if ($password1 != $password2 && $password1 != null){
            $form->setElementError("form_password1", "パスワードと確認用に入力されたパスワードが異なります。");
        }

    }

    if($part_id == null){
        $form->setElementError("form_part","所属部署は必須です。");
    }

    // エラーの際には、登録・変更処理を行わない
    if ($form->validate()){
        Db_Query($db_con, "BEGIN;");

        // 登録の場合だけ処理を行なう
        if ($staff_id == null){
            // スタッフID取得
            // 排他制御
            Db_Query($db_con, "LOCK TABLE t_staff;");
            $sql  = "SELECT COALESCE(MAX(staff_id), 0)+1 FROM t_staff;";
            $res  = Db_Query($db_con, $sql);
            //登録するスタッフID
            $staff_id_get = pg_fetch_result($res, 0, 0);
            
        }else{
            $staff_id_get = $staff_id;
        }

        /****************************/
        //画像のアップロード・削除
        /****************************/
        //削除しないにチェック＋ファイルが指定されてるとき、または登録時にファイルが指定されているか
        if (($photo_del == 1 && $_FILES["form_photo_ref"]["tmp_name"] != null) || 
            ($staff_id == null && $_FILES["form_photo_ref"]["tmp_name"] != null)){
            // 写真のファイル名指定
            if ($staff_id == null){
                $photo = $staff_id_get.".jpg";
            }else{
                // 変更処理
                $photo = $staff_id.".jpg";
            }
            // アップロード先のパス指定
            $up_file = STAFF_PHOTO_DIR.$photo;
            // アップロード
            $res = move_uploaded_file($_FILES["form_photo_ref"]["tmp_name"], $up_file);
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


        /****************************/
        // スタッフマスタ登録・更新処理
        /****************************/
        $staff_cd1_sql = ($staff_cd1 != null) ? "'$staff_cd1'" : "NULL";
        $staff_cd2_sql = ($staff_cd2 != null) ? "'$staff_cd2'" : "NULL";

        //登録・変更判定
        if ($staff_id != null){

            /*** 変更処理 ***/
            //作業区分は更新
            $work_div = "2";

            $sql  = "UPDATE ";
            $sql .= "   t_staff ";
            $sql .= "SET ";
            $sql .= "   staff_cd1        = $staff_cd1_sql, ";        
            $sql .= "   staff_cd2        = $staff_cd2_sql, ";        
            $sql .= "   charge_cd        = '$charge_cd', ";        
            $sql .= "   staff_name       = '$staff_name', ";    
            $sql .= "   staff_read       = '$staff_read', ";    
            $sql .= "   staff_ascii      = '$staff_ascii', ";    
            $sql .= "   sex              = '$sex', ";            
            $sql .= "   birth_day        = $birth_day, ";    
            $sql .= "   state            = '$state', ";        
            $sql .= "   join_day         = $join_day, ";        
            $sql .= "   retire_day       = $retire_day, ";    
            $sql .= "   employ_type      = '$employ_type', ";
            $sql .= "   position         = '$position', ";        
            $sql .= "   job_type         = '$job_type', ";        
            $sql .= "   study            = '$study', ";        
            $sql .= "   toilet_license   = '$toilet_license', ";
            $sql .= "   license          = '$license', ";        
            $sql .= "   note             = '$note', ";    
            $sql .= "   photo            = '$photo', ";    
            $sql .= ($change_flg == 1) ? "change_flg = 't', " : "change_flg = 'f', ";
            $sql .= "   round_staff_flg  = '$round_staff' ";
            $sql .= "WHERE ";
            $sql .= "   staff_id = $staff_id;";

        }else{

            /*** 登録処理 ***/
            //作業区分は登録
            $work_div = "1";

            $sql  = "INSERT INTO ";
            $sql .= "   t_staff ";
            $sql .= "VALUES( ";
            $sql .= "   $staff_id_get, ";
            $sql .= "   $staff_cd1_sql, ";
            $sql .= "   $staff_cd2_sql, ";
            $sql .= "   '$staff_name', ";
            $sql .= "   '$staff_read', ";
            $sql .= "   '$staff_ascii', ";
            $sql .= "   '$sex', ";
            $sql .= "   $birth_day, ";
            $sql .= "   '$state', ";
            $sql .= "   $join_day, ";
            $sql .= "   $retire_day, ";
            $sql .= "   '$employ_type', ";
            $sql .= "   '$position', ";
            $sql .= "   '$job_type', ";
            $sql .= "   '$study', ";
            $sql .= "   '$toilet_license', ";
            $sql .= "   '$license', ";
            $sql .= "   '$note', ";
            $sql .= "   '$photo', ";
            $sql .=     ($change_flg == 1) ? "'t', " : "'f', ";
            $sql .= "   '$charge_cd', ";
            $sql .= "   '$round_staff' ";
            $sql .= ");";
        }
        $res = Db_Query($db_con, $sql);
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
/*
        //変更判定
        if ($staff_id != null){
            //更新処理
            //staff_idを条件にデータ削除
            $sql  = "DELETE FROM ";
            $sql .= "    t_attach ";
            $sql .= "WHERE ";
            $sql .= "    staff_id = $staff_id;";
            $res = Db_Query($db_con,$sql);
        }
*/

        //登録・変更にかかわらず、所属マスタを一度削除する。
        $sql = "DELETE FROM t_attach WHERE staff_id = $staff_id_get;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /*** 登録処理 ***/
        //スタッフ種別判定
        switch ($_POST["form_staff_kind"]){
            case "1":

            //FC or 直営
            case "2":
/*
                $sql  = "INSERT INTO ";
                $sql .= "    t_attach ";
                $sql .= "VALUES(";
                $sql .= "    $cshop_id,";
                $sql .= "    $staff_id_get,";
                $sql .=      ($part_id != null) ? "$part_id, " : "null, ";
                $sql .= "    '$section',";
                $sql .=      ($ware_id != null) ? "$ware_id, " : "null, ";
                $sql .= "    'f',";
                $sql .= "    'f');";
*/

                //担当倉庫作成
                //関数に渡す配列を作成
                $create_ware_staff_data = array($charge_cd,     //担当者コード
                                                $staff_name,    //スタッフ名
                                                $cshop_id,      //所属ショップID
                                                $staff_id_get,  //スタッフID（登録）
                                                $db_con,        //DBコネクション
                                                $ware_id        //倉庫ID
                                            );
                $ware_id = Create_Ware_Staff($create_ware_staff_data);

                //所属マスタ登録
                //関数に渡す配列を作成
                $add_attach_data = array($staff_id_get,
                                         $part_id,
                                         $section,
                                         $ware_id,
                                         'f',
                                         'f',
                                         $cshop_id
                                    );
                $sql = Add_Attach($add_attach_data);

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
                break;
            //本部
            case "3":
/*
                $sql  = "INSERT INTO ";
                $sql .= "    t_attach ";
                $sql .= "VALUES(";
                $sql .= "    $client_id_head,";
                $sql .= "    $staff_id_get,";
                $sql .=      ($part_id_head != null) ? "$part_id_head, " : "null, ";
                $sql .= "    '$section_head',";
                $sql .=      ($ware_id_head != null) ? "$ware_id_head, " : "null, ";
                $sql .= "    't',";
                $sql .= "    'f');";
*/
                break;

            // 本部
            // 直営
            case "4":
/*
                $head_sql  = "INSERT INTO ";
                $head_sql .= "    t_attach ";
                $head_sql .= "VALUES(";
                $head_sql .= "    $client_id_head,";
                $head_sql .= "    $staff_id_get,";
                $head_sql .= "    1, ";
                $head_sql .= "    '$section_head',";
                $head_sql .=      ($ware_id_head != null) ? "$ware_id_head, " : "null, ";
                $head_sql .= "    't',";
                $head_sql .= "    't');";

                $sql  = "INSERT INTO ";
                $sql .= "    t_attach ";
                $sql .= "VALUES(";
                $sql .= "    $cshop_id,";
                $sql .= "    $staff_id_get,";
                $sql .=      ($part_id != null) ? "$part_id, " : "null, ";
                $sql .= "    '$section',";
                $sql .=      ($ware_id != null) ? "$ware_id, " : "null, ";
                $sql .= "    'f',";
                $sql .= "    't');";
*/

                //直営スタッフ 
                //担当倉庫作成
                //関数に渡す配列を作成
                $create_ware_staff_data = array($charge_cd,     //担当者コード
                                                $staff_name,    //スタッフ名
                                                $cshop_id,      //所属ショップID
                                                $staff_id_get,  //スタッフID（登録）
                                                $db_con,        //DBコネクション
                                                $ware_id        //倉庫ID
                                            );
                $ware_id = Create_Ware_Staff($create_ware_staff_data);

                //所属マスタ登録
                //関数に渡す配列を作成
                $add_attach_data = array($staff_id_get,
                                         $part_id,
                                         $section,
                                         $ware_id,
                                         'f',
                                         't',
                                         $cshop_id
                                    );
                $sql = Add_Attach($add_attach_data);

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                }

                //本部スタッフ(本部スタッフは倉庫の登録は行なわない)
                //所属マスタ登録
                //関数に渡す配列を作成
                $add_attach_data = array($staff_id_get,
                                         null,
                                         null,
                                         null,
                                         't',
                                         't',
                                         $client_id
                                    );
                $sql = Add_Attach($add_attach_data);

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
        }
/*
        // 本部・直営の場合は、それぞれ登録する
        if ($_POST["form_staff_kind"] == "4"){
            $head_result = Db_Query($db_con, $head_sql);
            if ($head_result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
        $res = Db_Query($db_con,$sql);
        if ($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
*/
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
                    $sql .= "WHERE ";
                    $sql .= "    t_staff.charge_cd = $charge_cd ";
                    $sql .= "AND ";
                    //スタッフ種別判定
                    switch ($_POST["form_staff_kind"]){
                        //FCor直営のスタッフID取得条件
                        case "1":
                        case "2":
                            $sql .= "    t_attach.shop_id = $cshop_id ";
                            break;
                        //本部or本部・直営のスタッフID取得条件
                        case "3":
                        case "4":
                            $sql .= "    t_attach.shop_id = $client_id_head ";
                            break;
                    }
                    $sql .= "),";
                    $sql .= "'$login_id',";
                    $sql .= "'$crypt_pass');";
                // スタッフ登録後に、追加でログイン情報を登録する場合
                }else{
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
                // 更新処理
                $sql  = "UPDATE ";
                $sql .= "   t_login ";
                $sql .= "SET ";
                $sql .= "   login_id = '$login_id' ";
                // パスワードが未入力の場合は、更新しない
                if ($password1!=null){
                    $sql .= ",";
                    $sql .= "password = '$crypt_pass' ";
                }
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id;";
            }
            $res = Db_Query($db_con, $sql);
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
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
            $permit_col = Permit_Col("head");

            $p = 0;
            $ary_type = array("h", "f");
            // 権限テーブルのカラム名と付与する権限（n, r, w）をセットにした配列の作成
            for ($i=0; $i<count($ary_type); $i++){
                for ($j=1; $j<=count($permit_col[$ary_type[$i]]); $j++){
                    for ($k=1; $k<=count($permit_col[$ary_type[$i]][$j]); $k++){
                        for ($l=0; $l<count($permit_col[$ary_type[$i]][$j][$k]); $l++){
                            $permit_data[$p] = ($_POST[permit][$ary_type[$i]][$j][$k][$l][n] == null)   ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : null;
                            $permit_data[$p] = ($_POST[permit][$ary_type[$i]][$j][$k][$l][r] == 1)      ? array($permit_col[$ary_type[$i]][$j][$k][$l], "r") : $permit_data[$p];
                            $permit_data[$p] = ($_POST[permit][$ary_type[$i]][$j][$k][$l][w] == 1)      ? array($permit_col[$ary_type[$i]][$j][$k][$l], "w") : $permit_data[$p];
                            $p++;
                        }
                    }
                }
            }

            /* スタッフ種別による権限変更 */
            // スタッフ種別内容（本部・FC）を取得し、配列に
            switch ($_POST["form_staff_kind"]){
                case 1:
                    $auth_type = array("fc");
                    break;
                case 2:
                    $auth_type = array("fc");
                    break;
                case 3:
                    $auth_type = array("head");
                    break;
                case 4:
                    $auth_type = array("head", "fc");
                    break;
            }
            $p = 0;
            $ary_type = array("h", "f");
            for ($i=0; $i<count($ary_type); $i++){
                for ($j=1; $j<=count($permit_col[$ary_type[$i]]); $j++){
                    for ($k=1; $k<=count($permit_col[$ary_type[$i]][$j]); $k++){
                        for ($l=0; $l<count($permit_col[$ary_type[$i]][$j][$k]); $l++){
                            // スタッフ種別内容に本部が無い場合
                            if (!in_array("head", $auth_type)){
                                // 本部用権限をnoneにする
                                $permit_data[$p] = ($ary_type[$i] == "h") ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : $permit_data[$p];
                            }
                            // スタッフ種別内容にFCが無い場合
                            if (!in_array("fc", $auth_type)){
                                // FC用権限をnoneにする
                                $permit_data[$p] = ($ary_type[$i] == "f") ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : $permit_data[$p];
                            }
                            $p++;
                        }
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
                $sql .= "(SELECT ";
                $sql .= "    t_staff.staff_id ";
                $sql .= "FROM ";
                $sql .= "    t_staff ";
                $sql .= "    INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
                $sql .= "WHERE ";
                $sql .= "    t_staff.charge_cd = $charge_cd ";
                $sql .= "AND ";
                //スタッフ種別判定
                switch ($_POST["form_staff_kind"]){
                    //FCor直営のスタッフID取得条件
                    case "1":
                    case "2":
                        $sql .= "    t_attach.shop_id = $cshop_id ";
                        break;
                    //本部or本部・直営のスタッフID取得条件
                    case "3":
                    case "4":
                        $sql .= "    t_attach.shop_id = $client_id_head ";
                        break;
                }
                $sql .= "),";
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

        // 「ログイン情報を変更しない」にチェックが付いている場合かつ、スタッフ変更の場合
        }elseif ($_POST["form_login_info"] == "1" && $staff_id != null){

            // 権限テーブルに登録がある場合
            $sql = "SELECT staff_id FROM t_permit WHERE staff_id = $staff_id;";
            $res = Db_Query($db_con, $sql);
            $num = pg_num_rows($res);
            if ($num > 0){

                /* スタッフ種別による権限変更 */
                // スタッフ種別内容（本部・FC）を取得し、配列に
                switch ($_POST["form_staff_kind"]){
                    case 1:
                        $auth_type = array("fc");
                        break;
                    case 2:
                        $auth_type = array("fc");
                        break;
                    case 3:
                        $auth_type = array("head");
                        break;
                    case 4:
                        $auth_type = array("head", "fc");
                        break;
                }

                $permit_col = Permit_Col("head");

                $p = 0;
                $ary_type = array("h", "f");
                for ($i=0; $i<count($ary_type); $i++){
                    for ($j=1; $j<=count($permit_col[$ary_type[$i]]); $j++){
                        for ($k=1; $k<=count($permit_col[$ary_type[$i]][$j]); $k++){
                            for ($l=0; $l<count($permit_col[$ary_type[$i]][$j][$k]); $l++){
                                // スタッフ種別内容に本部が無い場合
                                if (!in_array("head", $auth_type)){
                                    // 本部用権限をnoneにする
                                    $permit_data[$p] = ($ary_type[$i] == "h") ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : null;
                                }
                                // スタッフ種別内容にFCが無い場合
                                if (!in_array("fc", $auth_type)){
                                    // FC用権限をnoneにする
                                    $permit_data[$p] = ($ary_type[$i] == "f") ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : null;
                                }
                                $p++;
                            }
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

                // 権限削除SQL
                $sql  = "UPDATE ";
                $sql .= "   t_permit ";
                $sql .= "SET ";
                $sql .= "   staff_id = $staff_id";
                $sql .= (count($permit_data) > 0) ? ", " : " ";
                for ($i=0; $i<count($permit_data); $i++){
                    for ($j=0; $j<count($permit_data[$i][0]); $j++){
                        $sql .= "   ".$permit_data[$i][0][$j]." = '".$permit_data[$i][1]."'";
                        $sql .= (($i == count($permit_data)-1) && ($j == count($permit_data[$i][0])-1)) ? " " : ", ";
                    }
                }
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id ";
                $sql .= ";";
                $res = Db_Query($db_con, $sql);
                if ($res == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

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

        // 新規登録の場合はGET情報が無い為、GET情報作成
        if ($staff_id == ""){
            $sql  = "SELECT ";
            $sql .= "    t_staff.staff_id ";
            $sql .= "FROM ";
            $sql .= "    t_staff ";
            $sql .= "    INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = $charge_cd ";
            $sql .= "AND ";
            //スタッフ種別判定
            switch ($_POST["form_staff_kind"]){
                //FCor直営のスタッフID取得条件
                case "1":
                case "2":
                    $sql .= "    t_attach.shop_id = $cshop_id ";
                    break;
                //本部or本部・直営のスタッフID取得条件
                case "3":
                case "4":
                    $sql .= "    t_attach.shop_id = $client_id_head ";
                    break;
            }
            $sql .= ";";
            $res  = Db_Query($db_con,$sql);
            $staff_id = pg_fetch_result($res, 0, 0);        //スタッフID
        }

        Db_Query($db_con, "COMMIT;");
        $freeze_flg = true;

    }


/******************************/
// 削除ボタン押下時処理
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

            Db_Query($db_con, "COMMIT;");

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
            header("Location: 1-1-107.php");

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
    // 権限リンク
    $form->addElement("link", "form_permit_link", "", "#", "権限", "onClick=\"javascript:return Submit_Page2('1-1-120.php?staff_id=$staff_id')\"");
    // 次へボタン
    $option = ($next_id != null) ? "onClick=\"location.href='./1-1-109.php?staff_id=$next_id'\"" : "disabled";
    $form->addElement("button", "next_button", "次　へ", $option);
    // 前へボタン
    $option = ($back_id != null) ? "onClick=\"location.href='./1-1-109.php?staff_id=$back_id'\"" : "disabled";
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
    $sql .= "   t_attach.shop_id = $cshop_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $return_id = pg_fetch_result($res, 0, 0);
    }

    // 戻るボタン
    $form->addElement("button", "return_button", "戻　る", "onClick=\"location.href='./1-1-109.php?staff_id=".$return_id."'\"");
    // OKボタン
    $form->addElement("button", "comp_button", "O 　K", "onClick=\"location.href='./1-1-109.php'\" $disabled");
    // 権限リンク
    $form->addElement("static", "form_permit_link", "", "権限");

    $form->freeze();

    $password_msg = null;
//    $permit_set_msg = "変更しました";

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

/******************************/
//ヘッダーに表示させる全件数
/*****************************/
/** スタッフマスタ取得SQL作成 **/
$sql  = "SELECT \n";
$sql .= "   count(staff_id) \n";                    //スタッフID
$sql .= "FROM \n";
$sql .= "   t_attach \n";
$sql .= "WHERE shop_id != 1 \n";
$result = Db_Query($db_con,$sql.";");
//全件数取得(ヘッダー)
$total_count_h = pg_fetch_result($result,0,0);


/****************************/
// 本部による変更不可スタッフの場合はフリーズ
/****************************/
if ($h_change_ng_flg == true){
    $freeze = $form->addGroup($change_ng_freeze, "change_ng_freeze", "");
    $freeze->freeze();
}


/****************************/
//関数
/****************************/
/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
**/
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

/**
 * 所属マスタに登録する関数
 *
 *
 *
 *
**/
function Add_Attach($ary){

    $staff_id    = $ary[0];    //スタッフID
    $part_id     = $ary[1];    //部署ID
    $section     = $ary[2];    //課
    $ware_id     = $ary[3];    //倉庫ID
    $h_staff_flg = $ary[4];    //本部スタッフフラグ
    $sys_flg     = $ary[5];    //システム切替フラグ
    $shop_id     = $ary[6];    //所属ショップID

    $sql  = "INSERT INTO t_attach (";
    $sql .= "   staff_id,";
    $sql .= "   part_id, ";
    $sql .= "   section, ";
    $sql .= "   ware_id, ";
    $sql .= "   h_staff_flg, ";
    $sql .= "   sys_flg,";
    $sql .= "   shop_id ";
    $sql .= ")VALUES(";
    $sql .= "   $staff_id,";
    $sql .=     ($part_id != null) ? "$part_id, " : "null, ";
    $sql .= "   '$section', ";
    $sql .=     ($ware_id != null) ? "$ware_id, " : "null, ";
    $sql .= "   '$h_staff_flg',";
    $sql .= "   '$sys_flg',";
    $sql .= "   $shop_id ";
    $sql .= ");";

    return $sql;

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
$page_menu = Create_Menu_h("system", "1");

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count_h."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

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
    'staff_id'                  => "$staff_id",
    'back_id'                   => "$back_id",
    'next_id'                   => "$next_id",
    'freeze_flg'                => "$freeze_flg",
    'cshop_head_flg'            => "$cshop_head_flg",
    'only_head_flg'             => "$only_head_flg",
    'warning'                   => "$warning1",
    'warning2'                  => "$warning2",
    'permit_set_msg'            => "$permit_set_msg",
    'staff_del_restrict_msg'    => "$staff_del_restrict_msg",
    'select_staff_kind'         => "$select_staff_kind",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
