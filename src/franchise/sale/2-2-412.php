<?php
/*
 *
 *
 *
 *
 */

$page_title = "前受金照会";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// テンプレート関数をレジスト
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_client_branch"    => "",
    "form_attach_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_staff"            => array("cd" => "", "select" => ""),
    "form_part"             => "",
    "form_pay_day"          => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_advance_no"       => array("s" => "", "e" => ""),
    "form_input_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_amount"           => array("s" => "", "e" => ""),
    "form_bank"             => array("cd" => "", "name" => ""),
    "form_b_bank"           => array("cd" => "", "name" => ""),
    "form_account_no"       => "",
    "form_deposit_kind"     => "1",
    "form_fix"              => "1",
);

// 検索条件復元
Restore_Filter2($form, "advance", "form_display", $ary_form_list);


/****************************/
//外部変数取得
/****************************/
// SESSION
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$staff_name = $_SESSION["staff_name"];


/****************************/
// 初期値設定
/****************************/
$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
// POST時にチェック・hdnを初期化
/****************************/
if ($_POST != null){

    // 前受金確定ALLチェックをクリア
    $clear_form["form_fix_all"] = "";
    // 伝票選択チェックをクリア
    if ($_POST["form_fix_chk"] != null){
        foreach ($_POST["form_fix_chk"] as $key => $value){
            $clear_form["form_fix_chk"][$key] = "";
        }
    }
    $form->setConstants($clear_form);

}


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form_Advance($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// ソートリンク
$ary_sort_item = array(
    "sl_slip"           => "伝票番号",
    "sl_payin_day"      => "入金日",
    "sl_input_day"      => "入力日",
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    "sl_staff"          => "担当者",
    "sl_bank_cd"        => "銀行コード",
    "sl_bank_name"      => "銀行名",
    "sl_b_bank_cd"      => "支店コード",
    "sl_b_bank_name"    => "支店名",
    "sl_deposit_kind"   => "預金種目",
    "sl_account_no"     => "口座番号",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_payin_day");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

// クリアボタン
$form->addElement("button","form_clear","クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// ヘッダ部リンクボタン
$ary_h_btn_list = array("照会・変更" => $_SERVER["PHP_SELF"], "入　力" => "./2-2-411.php");
Make_H_Link_Btn($form, $ary_h_btn_list, 1);

// エラーセット用
$form->addElement("text", "err_del");               // 削除エラー用

// 処理フラグ
$form->addElement("hidden", "hdn_fix_flg");         // 前受金確定フラグ
$form->addElement("hidden", "hdn_del_id");          // 削除伝票ID
$form->addElement("hidden", "hdn_del_enter_day");   // 削除伝票の登録日時


/***************************/
// 前受金確定ボタン押下時
/***************************/
if ($_POST["hdn_fix_flg"] == "true"){

    // 送信フラグtrue
    $post_flg = true;

    // 伝票選択チェック
    if (count($_POST["form_fix_chk"]) == 0){
        $form->setElementError("form_fix_chk", "前受金確定を行う伝票を選択してください。");
    }else{
        $ary_cnt_vals = array_count_values($_POST["form_fix_chk"]);
        if (count($_POST["form_fix_chk"]) == $ary_cnt_vals["f"]){
            $form->setElementError("form_fix_chk", "前受金確定を行う伝票を選択してください。");
        }
    }

    // 上記エラーのない場合
    if ($form->getElementError("form_fix_chk") == null){

        // トランザクション開始
        Db_Query($db_con, "BEGIN;");

        // 選択された伝票IDでループ
        foreach ($_POST["form_fix_chk"] as $key => $value){

            // 前受金IDがある場合
            if ($value != "f"){

                $sql  = "SELECT \n";
                $sql .= "   advance_no \n";
                $sql .= "FROM \n";
                $sql .= "   t_advance \n";
                $sql .= "WHERE \n";
                $sql .= "   advance_id = $value \n";

                // 削除されている伝票のIDを取得
                $sql .= "AND \n";
                $sql .= "   enter_day = '".$_POST["hdn_enter_day"][$value]."' \n";
                $res  = Db_Query($db_con, $sql.";");
                $num  = pg_num_rows($res);
                if ($num == 0){
                    $ary_deleted_id[] = $value;
                    continue;
                }

                // 確定されている伝票番号を取得
                $sql .= "AND \n";
                $sql .= "   fix_day IS NOT NULL \n";
                $res  = Db_Query($db_con, $sql);
                $num  = pg_num_rows($res);
                if ($num > 0){
                    $ary_fixed_id[] = pg_fetch_result($res, 0, 0);
                    continue;
                }

                // 前受金確定処理実行
                $sql  = "UPDATE \n";
                $sql .= "   t_advance \n";
                $sql .= "SET \n";
                $sql .= "   fix_day = NOW(), \n";
                $sql .= "   fix_staff_id = $staff_id, \n";
                $sql .= "   fix_staff_name = '".addslashes($staff_name)."' \n";
                $sql .= "WHERE \n";
                $sql .= "   advance_id = $value \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

            }

        }

        // トランザクション完結
        Db_Query($db_con, "COMMIT;");

    }

    // hiddenの伝票作成日時をクリア
    foreach ($_POST["hdn_enter_day"] as $key => $value){
        $clear_hdn["hdn_enter_day"][$key] = "";
    }

    // 前受金確定フラグをクリア
    $clear_hdn["hdn_fix_flg"] = "";
    $form->setConstants($clear_hdn);

}


/***************************/
// 削除リンク押下時
/***************************/
if ($_POST["hdn_del_id"] != null){

    // 送信フラグtrue
    $post_flg = true;

    // 削除IDと伝票登録日時を変数に
    $del_id         = $_POST["hdn_del_id"];
    $del_enter_day  = $_POST["hdn_del_enter_day"];

    // 確定されていないかチェック
    $sql  = "SELECT \n";
    $sql .= "   advance_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   advance_id = $del_id \n";
    $sql .= "AND \n";
    $sql .= "   enter_day = '$del_enter_day' \n";
    $sql .= "AND \n";
    $sql .= "   fix_day IS NOT NULL \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $form->setElementError("err_del", "前受金確定されているため、削除できません。");
    }

    // 上記エラーのない場合
    if ($form->getElementError("err_del") == null){

        // トランザクション開始
        Db_Query($db_con, "BEGIN;");

        // 削除処理実行
        $sql  = "DELETE FROM \n";
        $sql .= "   t_advance \n";
        $sql .= "WHERE \n";
        $sql .= "   advance_id = $del_id \n";
        $sql .= "AND \n";
        $sql .= "   enter_day = '$del_enter_day' \n";
        $sql .= "AND \n";
        $sql .= "   fix_day IS NULL \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        if ($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        // トランザクション完結
        Db_Query($db_con, "COMMIT;");

    }

    // hdnの削除ID・伝票登録日時をクリア
    $clear_hdn["hdn_del_id"]        = "";
    $clear_hdn["hdn_del_enter_day"] = "";
    $form->setConstants($clear_hdn);

}


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["form_display"] != null){

    // 日付POSTデータの0埋め
    $_POST["form_pay_day"]      = Str_Pad_Date($_POST["form_pay_day"]);
    $_POST["form_input_day"]    = Str_Pad_Date($_POST["form_input_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■担当者コード
    Err_Chk_Num($form, "form_staff", "担当者 は数値のみ入力可能です。");

    // ■入金日
    Err_Chk_Date($form, "form_pay_day", "入金日 の日付が妥当ではありません。");

    // ■入力日
    Err_Chk_Date($form, "form_input_day", "入力日 の日付が妥当ではありません。");

    // ■金額
    Err_Chk_Int($form, "form_amount", "金額 は数値のみ入力可能です。");

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $test = $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// 1. 表示ボタン押下＋エラーなし時
// 2. ページ切り替え時、その他のPOST時
/****************************/
if (($_POST["form_display"] != null && $err_flg != true) || ($_POST != null && $_POST["form_display"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_pay_day"]      = Str_Pad_Date($_POST["form_pay_day"]);
    $_POST["form_input_day"]    = Str_Pad_Date($_POST["form_input_day"]);

    // POSTデータを変数にセット
    $display_num        = $_POST["form_display_num"];
    $client_branch      = $_POST["form_client_branch"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $staff_cd           = $_POST["form_staff"]["cd"];
    $staff_select       = $_POST["form_staff"]["select"];
    $part               = $_POST["form_part"];
    $pay_day_sy         = $_POST["form_pay_day"]["sy"];
    $pay_day_sm         = $_POST["form_pay_day"]["sm"];
    $pay_day_sd         = $_POST["form_pay_day"]["sd"];
    $pay_day_ey         = $_POST["form_pay_day"]["ey"];
    $pay_day_em         = $_POST["form_pay_day"]["em"];
    $pay_day_ed         = $_POST["form_pay_day"]["ed"];
    $advance_no_s       = $_POST["form_advance_no"]["s"];
    $advance_no_e       = $_POST["form_advance_no"]["e"];
    $input_day_sy       = $_POST["form_input_day"]["sy"];
    $input_day_sm       = $_POST["form_input_day"]["sm"];
    $input_day_sd       = $_POST["form_input_day"]["sd"];
    $input_day_ey       = $_POST["form_input_day"]["ey"];
    $input_day_em       = $_POST["form_input_day"]["em"];
    $input_day_ed       = $_POST["form_input_day"]["ed"];
    $amount_s           = $_POST["form_amount"]["s"];
    $amount_e           = $_POST["form_amount"]["e"];
    $bank_cd            = $_POST["form_bank"]["cd"];
    $bank_name          = $_POST["form_bank"]["name"];
    $b_bank_cd          = $_POST["form_b_bank"]["cd"];
    $b_bank_name        = $_POST["form_b_bank"]["name"];
    $account_no         = $_POST["form_account_no"];
    $deposit_kind       = $_POST["form_deposit_kind"];
    $fix                = $_POST["form_fix"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // 顧客担当支店
    $sql .= ($client_branch != null) ? "AND t_client.charge_branch_id = $client_branch \n" : null;
    // 所属本支店
    if ($attach_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_staff.staff_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_attach \n";
        $sql .= "           INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_part.branch_id = $attach_branch \n";
        $sql .= "   ) \n";
    }
    // 得意先コード１
    $sql .= ($client_cd1 != null) ? "AND t_advance.client_cd1 LIKE '$client_cd1%' \n" : null;
    // 得意先コード２
    $sql .= ($client_cd2 != null) ? "AND t_advance.client_cd2 LIKE '$client_cd2%' \n" : null;
    // 得意先名
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_advance.client_name1 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_advance.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_advance.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // 担当者コード
    $sql .= ($staff_cd != null) ? "AND t_staff.charge_cd = '$staff_cd' \n" : null;
    // 担当者セレクト
    $sql .= ($staff_select != null) ? "AND t_advance.staff_id = $staff_select \n" : null;
    // 部署
    $sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
    // 入金日（開始）
    $pay_day_s  = $pay_day_sy."-".$pay_day_sm."-".$pay_day_sd;
    $sql .= ($pay_day_s != "--") ? "AND t_advance.pay_day >= '$pay_day_s' \n" : null;
    // 入金日（終了）
    $pay_day_e  = $pay_day_ey."-".$pay_day_em."-".$pay_day_ed;
    $sql .= ($pay_day_e != "--") ? "AND t_advance.pay_day <= '$pay_day_e' \n" : null;
    // 伝票番号（開始）
    $sql .= ($advance_no_s != null) ? "AND t_advance.advance_no >= '".str_pad($advance_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 伝票番号（終了）
    $sql .= ($advance_no_e != null) ? "AND t_advance.advance_no <= '".str_pad($advance_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 入力日（開始）
    $input_day_s  = $input_day_sy."-".$input_day_sm."-".$input_day_sd;
    $sql .= ($input_day_s != "--") ? "AND t_advance.input_day >= '$input_day_s' \n" : null;
    // 入力日（終了）
    $input_day_e  = $input_day_ey."-".$input_day_em."-".$input_day_ed;
    $sql .= ($input_day_e != "--") ? "AND t_advance.input_day <= '$input_day_e' \n" : null;
    // 金額（開始）
    $sql .= ($amount_s != null) ? "AND t_advance.amount >= $amount_s \n" : null;
    // 金額（終了）
    $sql .= ($amount_e != null) ? "AND t_advance.amount <= $amount_e \n" : null;
    // 銀行コード
    $sql .= ($bank_cd != null) ? "AND t_advance.bank_cd LIKE '$bank_cd%' \n" : null;
    // 銀行名
    $sql .= ($bank_name != null) ? "AND t_advance.bank_name LIKE '%$bank_name%' \n" : null;
    // 支店コード
    $sql .= ($b_bank_cd != null) ? "AND t_advance.b_bank_cd LIKE '$b_bank_cd%' \n" : null;
    // 支店名
    $sql .= ($b_bank_name != null) ? "AND t_advance.b_bank_name LIKE '%$b_bank_name%' \n" : null;
    // 口座番号
    $sql .= ($account_no != null) ? "AND t_advance.account_no LIKE '$account_no%' \n" : null;
    // 預金種目
    if ($deposit_kind == "2"){
        $sql .= "AND t_advance.deposit_kind = '1' \n";
    }else
    if ($deposit_kind == "3"){
        $sql .= "AND t_advance.deposit_kind = '2' \n";
    }
    // 前受金確定
    if ($fix == "2"){
        $sql .= "AND t_advance.fix_day IS NULL \n";
    }else
    if ($fix == "3"){
        $sql .= "AND t_advance.fix_day IS NOT NULL \n";
    }

    // 変数詰め替え
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 伝票番号
        case "sl_slip":
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 入金日
        case "sl_payin_day":
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 入力日
        case "sl_input_day":
            $sql .= "   t_advance.input_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 得意先コード
        case "sl_client_cd":
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day \n";
            break;
        // 得意先名
        case "sl_client_name":
            $sql .= "   t_advance.client_cname, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 担当者
        case "sl_staff":
            $sql .= "   t_staff.charge_cd, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 銀行コード
        case "sl_bank_cd":
            $sql .= "   t_advance.bank_cd, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 銀行名
        case "sl_bank_name":
            $sql .= "   t_advance.bank_name, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 支店コード
        case "sl_b_bank_cd":
            $sql .= "   t_advance.b_bank_cd, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 支店名
        case "sl_b_bank_name":
            $sql .= "   t_advance.b_bank_name, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 預金種目
        case "sl_deposit_kind":
            $sql .= "   t_advance.deposit_kind, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
        // 口座番号
        case "sl_account_no":
            $sql .= "   t_advance.account_no, \n";
            $sql .= "   t_advance.pay_day, \n";
            $sql .= "   t_advance.advance_no, \n";
            $sql .= "   t_advance.client_cd1, \n";
            $sql .= "   t_advance.client_cd2 \n";
            break;
    }

    // 変数詰め替え
    $order_sql = $sql;

}


/****************************/
// 一覧データ取得
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_advance.advance_id, \n";                  // 前受金ID
    $sql .= "   t_advance.advance_no, \n";                  // 前受金No.
    $sql .= "   t_advance.pay_day, \n";                     // 入金日
    $sql .= "   t_advance.input_day, \n";                   // 入力日
    $sql .= "   t_advance.client_cd1 || '-' || t_advance.client_cd2 \n";
    $sql .= "   AS client_cd, \n";                          // 得意先コード
    $sql .= "   t_advance.client_cname, \n";                // 得意先名略称
    $sql .= "   CAST(LPAD(t_staff.charge_cd, 4, '0') AS TEXT) \n";
    $sql .= "   AS charge_cd, \n";                          // 担当者コード
    $sql .= "   t_advance.staff_name, \n";                  // 担当者名
    $sql .= "   t_advance.amount, \n";                      // 金額
    $sql .= "   t_advance.bank_cd, \n";                     // 銀行コード
    $sql .= "   t_advance.bank_name, \n";                   // 銀行名
    $sql .= "   t_advance.b_bank_cd, \n";                   // 支店コード
    $sql .= "   t_advance.b_bank_name, \n";                 // 支店名
    $sql .= "   CASE t_advance.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '普通' \n";
    $sql .= "       WHEN '2' THEN '当座' \n";
    $sql .= "   END \n";
    $sql .= "   AS deposit_kind, \n";                       // 預金種目
    $sql .= "   t_advance.account_no, \n";                  // 口座番号
    $sql .= "   TO_DATE(t_advance.fix_day, 'YYYY-MM-DD') \n";
    $sql .= "   AS fix_day, \n";                            // 前受金確定日
    $sql .= "   t_advance.enter_day \n";                    // 伝票登録日時
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "   LEFT JOIN t_client ON  t_advance.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_staff  ON  t_advance.staff_id = t_staff.staff_id \n";
    $sql .= "   LEFT JOIN t_attach ON  t_staff.staff_id = t_attach.staff_id \n";
    $sql .= "                      AND t_attach.shop_id IN ".Rank_Sql2()." \n";
    $sql .= "WHERE \n";
    $sql .= "   t_advance.shop_id IN ".Rank_Sql2()." \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // 全件数取得
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // 表示件数
    switch ($display_num){
        case "1":
            $limit = $total_count;
            break;
        case "2":
            $limit = "100";
            break;
    }

    // 取得開始位置
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // 行削除でページに表示するレコードが無くなる場合の対処
    if($page_count != null){
        // 行削除でtotal_countとoffsetの関係が崩れた場合
        if ($total_count <= $offset){
            // オフセットを選択件前に
            $offset     = $offset - $limit;
            // 表示するページを1ページ前に（一気に2ページ分削除されていた場合などには対応してないです）
            $page_count = $page_count - 1;
            // 選択件数以下時はページ遷移を出力させない(nullにする)
            $page_count = ($total_count <= $display_num) ? null : $page_count;
        }
    }else{
        $offset = 0;
    }

    // ページ内データ取得
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_data       = Get_Data($res, 2, "ASSOC");

}


/****************************/
// 表示用データ作成
/****************************/
if ($post_flg == true && $err_flg != true){

    // 初期値
    $html_l     = null;
    $sum_amount = 0;

    // 取得データがある場合、データ数分ループ
    if (count($ary_data) > 0){
    foreach ($ary_data as $key => $value){

        /****************************/
        // 前準備
        /****************************/
        // 行色
        $ary_disp_data[$key]["css"] = (bcmod($key, 2) == 0) ? "Result1" : "Result2";

        // No.
        $ary_disp_data[$key]["no"] = (($page_count - 1) * $limit) + $key + 1;

        // 伝票番号リンク
        $form->addElement("link", "link_advance_no[$key]", "", "./2-2-411.php?advance_id=".$value["advance_id"], $value["advance_no"], "");

        // 入金日・入力日
        $ary_disp_data[$key]["day"] = $value["pay_day"]."<br>".$value["input_day"]."<br>";

        // 得意先
        $ary_disp_data[$key]["client"] = $value["client_cd"]."<br>".htmlspecialchars($value["client_cname"])."<br>";

        // 担当者
        if ($value["charge_cd"] != null){
            $ary_disp_data[$key]["staff"] = $value["charge_cd"]." ： ".htmlspecialchars($value["staff_name"]);
        }else{
            $ary_disp_data[$key]["staff"] = null;
        }

        // 金額
        $ary_disp_data[$key]["amount"] = $value["amount"];

        // 銀行
        $ary_disp_data[$key]["bank"] = $value["bank_cd"]."<br>".htmlspecialchars($value["bank_name"])."<br>";

        // 支店
        $ary_disp_data[$key]["b_bank"] = $value["b_bank_cd"]."<br>".htmlspecialchars($value["b_bank_name"])."<br>";

        // 預金種目・口座番号
        $ary_disp_data[$key]["account"] = $value["deposit_kind"]."<br>".$value["account_no"]."<br>";

        // 削除リンク
        if ($value["fix_day"] == null && $disabled == null){
            $form->addElement("link", "link_del[$key]", "", "#", "削除", "
                onClick=\"javascript: Dialogue_5(
                    '削除します。', ".$value["advance_id"].", 'hdn_del_id', '".$value["enter_day"]."', 'hdn_del_enter_day', '".$_SERVER["PHP_SELF"]."'
                );\""
            );
        }

        // 前受金確定チェック
        if ($value["fix_day"] == null){
            $form->addElement("advcheckbox", "form_fix_chk[$key]", null, null, null, array("f", $value["advance_id"]));
        }else{
            $ary_disp_data[$key]["fix_day"] = $value["fix_day"];
        }

        // 合計金額加算
        $sum_amount += $value["amount"];

        // 前受金ALLチェック用データ作成
        if ($value["fix_day"] == null){
            $ary_chk_data[$key] = $value["advance_id"];
        }

        // 伝票作成日時をhiddenにセット
        $form->addElement("hidden", "hdn_enter_day[".$value["advance_id"]."]");
        $hdn_set["hdn_enter_day"][$value["advance_id"]] = $value["enter_day"];

        /****************************/
        // html作成
        /****************************/
        $html_l .= "    <tr class=\"".$ary_disp_data[$key]["css"]."\">\n";
        $html_l .= "        <td align=\"right\">".$ary_disp_data[$key]["no"]."</td>\n";
        $html_l .= "        <td align=\"center\">".($form->_elements[$form->_elementIndex["link_advance_no[$key]"]]->toHtml())."</td>\n";
        $html_l .= "        <td align=\"center\">".$ary_disp_data[$key]["day"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["client"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["staff"]."</td>\n";
        $html_l .= "        <td align=\"right\">".Number_Format_Color($ary_disp_data[$key]["amount"])."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["bank"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["b_bank"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["account"]."</td>\n";
        if ($value["fix_day"] == null && $disabled == null){
        $html_l .= "        <td align=\"center\">".($form->_elements[$form->_elementIndex["link_del[$key]"]]->toHtml())."</td>\n";
        }else{
        $html_l .= "        <td align=\"center\"></td>\n";
        }
        if ($value["fix_day"] == null){
        $html_l .= "        <td align=\"center\">".($form->_elements[$form->_elementIndex["form_fix_chk[$key]"]]->toHtml())."</td>\n";
        }else{
        $html_l .= "        <td align=\"center\">".$ary_disp_data[$key]["fix_day"]."</td>\n";
        }
        $html_l .= "    </tr>\n";

    }
    }

    // 伝票作成日時をhiddenにセット
    $form->setConstants($hdn_set);

    // ページ分けhtml作成
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

    // 前受金ALLチェック用js作成
    $js = Create_Allcheck_Js("All_Check_Fix", "form_fix_chk", $ary_chk_data);

    // 前受金ALLチェック作成
    $form->addElement("checkbox", "form_fix_all", "", "前受金確定", "onClick=\"javascript: All_Check_Fix('form_fix_all');\"");

    // 前受金確定ボタン作成
    $form->addElement("button", "form_fix_button", "前受金確定", "
        onClick=\"javascript:
            return Dialogue_2('前受金確定します。', '".$_SERVER["PHP_SELF"]."', 'true', 'hdn_fix_flg'
        );\"
        $disabled
    ");


}


/****************************/
// HTML作成（検索部）
/****************************/
// 共通検索テーブル
$html_s .= Search_Table_Advance($form);
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_display"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


/****************************/
// 関数
/****************************/
function Number_Format_Color($num){
    return ($num < 0) ? "<span style=\"color: #ff0000;\">".number_format($num)."</span>" : number_format($num);
}


/****************************/
// HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
    "sum_amount"    => "$sum_amount",
));

// htmlをassign
$smarty->assign("html", array(
    "html_page"     =>  $html_page,
    "html_page2"    =>  $html_page2,
    "html_s"        =>  $html_s,
    "html_l"        =>  $html_l,
    "js"            =>  $js,
));

// エラーをassign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
