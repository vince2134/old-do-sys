<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/24　04-007　　　　watanabe-k　翌月の請求更新を行なうと、同じデータが2つ表示される。
 *                                         さらに翌月の請求更新を行なうと、同じデータが3つ表示されるバグの修正
 *
 * 　2006/10/25　04-025　　　　morita-d　　表示ボタンをbuttonからsubmitに変更
 *                                         (表示処理と削除処理が同時に実行される可能性があるため）
 * 　2006/12/14　      　　　　suzuki　    ページ処理修正
 * 　2007/01/27　      　　　　morita-d　　請求更新の機能を追加
 * 　2007/01/27　      　　　　morita-d　　以下の機能を追加
 *                                         請求書一括発行画面の「削除」という表現は「取消」に変更する。
 *                                         「取消」を選択した場合には、作成した請求書を削除する。
 *   2007/03/08                watanabe-k  月次更新日以前で請求取消をできないように変更
 *   2007/03/14                watanabe-k  請求書再発行処理を作成
 *   2007/03/27                watanabe-k  検索条件を復元 
 *   2007/03/27                watanabe-k  本支店での検索機能追加 
 *   2007/03/30                watanabe-k  個別明細書作成 
 *   2007/04/16                watanabe-k  請求更新済みのものは請求取り消しはできないようにする。 
 *   2007/04/16                watanabe-k  請求更確定機能は削除 
 *   2007/05/07                watanabe-k  個別請求書を選択可能 
 */

$page_title = "請求書発行照会";

//環境設定ファイル
require_once("ENV_local.php");

//請求関連で使用する関数ファイル
require_once(INCLUDE_DIR."seikyu.inc");

require_once(INCLUDE_DIR."common_quickform.inc");

//現モジュール内のみで使用する関数ファイル
require_once(INCLUDE_DIR.(basename($_SERVER["PHP_SELF"].".inc")));

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// テンプレート関数をレジスト
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//DB接続
$db_con = Db_Connect();

//処理開始時間
$s_time = microtime();

/****************************/
//権限チェック
/****************************/
$auth       = Auth_Check($db_con);

// 入力・変更権限無しメッセージ
if ($auth[0] == "r") {
    $disabled = "disabled";
} 


/****************************/
// 検索条件復元関連 
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_output_type"      => "1",
    "form_client_branch"    => "",
    "form_attach_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_round_staff"      => array("cd" => "", "select" => ""),
    "form_part"             => "",
    "form_claim"            => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_amount_this"      => array("s" => "", "e" => ""),
    "form_close_day"        => array("y" => date("Y"), "m" => date("m"), "d" => "0",),
    "form_collect_day"      => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_charge_fc"        => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_issue"            => "1",
    "form_claim_send"       => "1",
    "form_last_update"      => "1",
    "form_bill_no"          => array("s" => "", "e" => ""),
);

$ary_pass_list = array(
    "form_output_type"      => "1",
);

// 検索条件復元
Restore_Filter2($form, "claim", "hyouji_button", $ary_form_list);


/****************************/
// 変数名の置き換え（以後$_POSTは使用しない）
/****************************/
// ユーザ入力
//if ($_POST["renew_flg"] == "1" || $_GET["search"] != null){ 
if ($_POST["renew_flg"] == "1"){ 

    $display_num        = $_POST["form_display_num"];
    $output_type        = $_POST["form_output_type"];
    $client_branch      = $_POST["form_client_branch"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $round_staff_cd     = $_POST["form_round_staff"]["cd"];
    $round_staff_select = $_POST["form_round_staff"]["select"];
    $part               = $_POST["form_part"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $amount_this_s      = $_POST["form_amount_this"]["s"];
    $amount_this_e      = $_POST["form_amount_this"]["e"];
    $close_day_y        = $_POST["form_close_day"]["y"];
    $close_day_m        = $_POST["form_close_day"]["m"];
    $close_day_d        = $_POST["form_close_day"]["d"];
    $collect_day_sy     = $_POST["form_collect_day"]["sy"];
    $collect_day_sm     = $_POST["form_collect_day"]["sm"];
    $collect_day_sd     = $_POST["form_collect_day"]["sd"];
    $collect_day_ey     = $_POST["form_collect_day"]["ey"];
    $collect_day_em     = $_POST["form_collect_day"]["em"];
    $collect_day_ed     = $_POST["form_collect_day"]["ed"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $issue              = $_POST["form_issue"];
    $claim_send         = $_POST["form_cliam_send"];
    $last_update        = $_POST["form_last_update"];
    $bill_no_s          = $_POST["form_bill_no"]["s"];
    $bill_no_e          = $_POST["form_bill_no"]["e"];

    $where              = $_POST;
    $claim_fix          = $_POST["claim_fix"];
    $claim_renew        = $_POST["claim_renew"];
    $claim_cancel       = $_POST["claim_cancel"];
    $branch_id          = $_POST["form_branch_id"];
 
    //その他
    $f_page1            = $_POST["f_page1"];
    $hyouji_button      = $_POST["hyouji_button"];
    $fix_button         = $_POST["fix_button"];
    $renew_button       = $_POST["renew_button"];
    $cancel_button      = $_POST["cancel_button"];
    $bill_id            = $_POST["bill_id"];
    $link_action        = $_POST["link_action"];
    $renew_flg          = $_POST["renew_flg"];

    $post_flg           = true;

// 初期表示
}else{

    $f_page1            = ($_POST["f_page1"] != Null) ? $_POST["f_page1"] : 1;
    $display_num        = "1";

}


/****************************/
// フォーム定義（静的）
/****************************/
/* 共通フォーム */
Search_Form_Claim($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// 請求書発行
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "未発行", "2");
$obj[]  =&  $form->createElement("radio", null, null, "発行済", "3");
$form->addGroup($obj, "form_issue", "", " ");

// 請求書送付
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",         "1");
$obj[]  =&  $form->createElement("radio", null, null, "郵送",         "2");
$obj[]  =&  $form->createElement("radio", null, null, "メール",       "3");
$obj[]  =&  $form->createElement("radio", null, null, "WEB",          "5");
$obj[]  =&  $form->createElement("radio", null, null, "郵送・メール", "4");
$form->addGroup($obj, "form_claim_send", "", " ");

// 請求更新
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "未実施", "2");
$obj[]  =&  $form->createElement("radio", null, null, "実施済", "3");
$form->addGroup($obj, "form_last_update", "", " ");

// 請求番号
Addelement_Slip_Range($form, "form_bill_no", "請求番号");

// 請求確定ALL
$form->addElement("checkbox", "claim_fix_all",      "", "請求確定",   "onClick=\"javascript:All_Check_Claim_Fix('claim_fix_all');\"");

// 請求書発行ALL
$form->addElement("checkbox", "claim_issue_all",    "", "請求書発行", "onClick=\"javascript:All_Check_Claim_Issue('claim_issue_all');\"");

// 請求書再発行ALL
$form->addElement("checkbox", "re_claim_issue_all", "", "再発行",     "onClick=\"javascript:All_Re_Check_Claim_Issue('re_claim_issue_all');\"");

// 請求更新ALL
$form->addElement("checkbox", "claim_renew_all",    "", "請求更新",   "onClick=\"javascript:All_Check_Claim_Renew('claim_renew_all');\"");

// 請求取消ALL
$form->addElement("checkbox", "claim_cancel_all",   "", "請求取消",   "onClick=\"javascript:All_Check_Claim_Cancel('claim_cancel_all');\"");

// 表示ボタン
$form->addElement("submit", "hyouji_button", "表　示", "onClick=\"return(Submit_If_Url('2-2-303.php', 'form_output_type'));\"");

// クリアボタン
$form->addElement("button", "kuria_button", "クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// 請求確定ボタン
$form->addElement("submit", "fix_button", "請求確定", "
    onClick=\"javascript:return(Dialogue4('請求確定します。'));\" $disabled
");

// 請求更新ボタン
$form->addElement("submit", "renew_button", "請求更新", "
    onClick=\"javascript:return(Dialogue4('請求更新します。'));\" $disabled
");

// 請求取消ボタン
$form->addElement("submit", "cancel_button", "請求取消", "
    onClick=\"javascript:return(Dialogue4('請求取消しと、請求期間内の売上・入金伝票の日次更新解除を行ないます。'));\" $disabled
");

// 請求書発行ボタン
$form->addElement("button", "pre_hakkou_button", "控　発　行", "$g_button_color
     onClick=\"javascript:document.dateForm.elements['hdn_button'].value = '前発行';
    Submit_Blank_Window('2-2-307.php','請求書を発行します。');\" $disabled"
);

// 請求書発行ボタン
$form->addElement("button", "hakkou_button", "請求書発行", "
    onClick=\"javascript:document.dateForm.elements['hdn_button'].value = ''; 
    Submit_Blank_Window('2-2-307.php','請求書を発行します。');\" $disabled
");

// 再発行ボタン
$form->addElement("button", "re_hakkou_button", "再発行", "
    onClick=\"javascript:document.dateForm.elements['hdn_button'].value = '再発行'; 
    Submit_Blank_Window('2-2-307.php','請求書を発行します。');\" $disabled
");

// ソートリンク
$ary_sort_item = array(
    "sl_slip"           => "請求番号",
    "sl_close_day"      => "請求締日",
    "sl_claim_cd"       => "請求先コード",
    "sl_claim_name"     => "請求先名",
    "sl_collect_day"    => "回収予定日",
    "sl_staff"          => "担当者",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_close_day");

// hidden
$form->addElement("hidden", "link_action");         // リンククリック時の動作
$form->addElement("hidden", "bill_id");             // 請求書ID
$form->addElement("hidden", "renew_flg", "1");      // 画面更新フラグ
$form->addElement("hidden", "hdn_button");          // 再発行ボタン


/****************************/
// 初期値設定
/****************************/
$form->setDefaults($ary_form_list);

// 更新時はチェックボックスのチェックをはずす
if ($renew_flg == "1") {
    $constants_data = array(
        "claim_fix_all"         => "0",
        "claim_issue_all"       => "0",
        "re_claim_issue_all"    => "0",
        "claim_renew_all"       => "0",
        "claim_cancel_all"      => "0",
    );
    $form->setConstants($constants_data);
}

// 請求明細から戻った場合は請求書発行のチェックボックスのチェックをはずす
if ($_POST["hdn_back_btn"] == "post"){
    $clear_form["claim_issue"][0] = false;
    $form->setConstants($clear_form);
}


/****************************/
//エラーチェック
/****************************/
if($_POST["hyouji_button"] == "表　示"){

    /****************************/
    // ラジオボタン不正値POSTチェック
    /****************************/
    $err_chk_radio = array(
        array($display_num,  "2"),      // 表示件数
        array($output_type,  "2"),      // 出力形式
        array($issue,        "3"),      // 請求書発行
        array($claim_send,   "5"),      // 請求書送付
        array($claim_update, "3"),      // 請求更新
    );

    foreach ($err_chk_radio as $key => $value){
        if (!("1" <= $value[0] || $value[0] <= $value[1])){
            print "不正な値が入力されました。(".($key+1).")<br>";
            exit;
        }
    }

    // 日付POSTデータの0埋め
    $_POST["form_close_day"]    = Str_Pad_Date($_POST["form_close_day"]);
    $_POST["form_collect_day"]  = Str_Pad_Date($_POST["form_collect_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■巡回担当者
    $err_msg = "巡回担当者 は数値のみ入力可能です。";
    Err_Chk_Num($form, "form_round_staff", $err_msg);

    // ■請求額
    $err_msg = "請求額 は数値のみ入力可能です。";
    Err_Chk_Int($form, "form_amount_this", $err_msg);

    // ■請求締日
    $err_msg = "請求締日 の日付が妥当ではありません。";
    // 文字列チェック
    if (
        ($_POST["form_close_day"]["y"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["y"])) ||
        ($_POST["form_close_day"]["m"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["m"]))
    ){
        $form->setElementError("form_close_day", $err_msg);
    }else
    // 妥当性チェック
    if ($_POST["form_close_day"]["m"] != null && ($_POST["form_close_day"]["m"] < 1 || $_POST["form_close_day"]["m"] > 12)){
        $form->setElementError("form_close_day", $err_msg);
    }

    // ■回収予定日
    $err_msg = "回収予定日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_collect_day", $err_msg);

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $form->validate();
    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}

/****************************/
// 処理
/****************************/
// 出力形式「画面」の表示処理
if ($hyouji_button == "表　示" && $output_type == "1") {

    // 処理なし（他の処理と同時実行を防ぐために記述）

}else
// 出力形式「帳票」の表示処理
if ($hyouji_button == "表　示" && $output_type == "2") {

    // 処理なし（他の処理と同時実行を防ぐために記述）

}else
// 請求確定処理
if ($fix_button == "請求確定" && count($claim_fix) > 0) {

    Fix_Bill($db_con, $claim_fix);

}else
// 請求更新処理
if ($renew_button == "請求更新" && count($claim_renew) > 0) {

    Renew_Bill($db_con, $claim_renew);

}else
// 請求取消処理
if ($cancel_button == "請求取消" && count($claim_cancel) > 0) {

    // 更新取消時は請求書を削除するように修正
    // （排他制御の関係上、請求更新取消と削除処理は分けて実施する）

    // 請求取消
    $payin_data = Cancel_Bill($db_con, $claim_cancel);

    // 既に入金の起こっているデータがある場合
    if (count($payin_data) > 0){
        $i = 0;
        foreach ($payin_data AS $key => $val){
            // エラーメッセージ表示用フォーム
            $form->addElement("text", "payin_err[$i]");
            $form->setElementError("payin_err[$i]",
                "請求書番号：".$val["bill_no"]." に対して既に 入金番号：".$val["pay_no"]." の入金が起こっているため削除できません。"
            );
            $i++;
        }
    }else{
        // 請求削除
        while ($cancel_id = each($claim_cancel)) {
            Delete_Bill($db_con, $cancel_id[1]);
        }
    }

}else
// 削除処理
if ($link_action == "delete" && count($claim_cancel) > 0){

    $claim_cancel[] = $bill_id;

    // 請求取消
    Cancel_Bill($db_con, $claim_cancel);

    // 請求削除
    Delete_Bill($db_con, $bill_id);

}

// 一覧表示処理
if ($post_flg == true && $err_flg != true){

    // 該当件数取得
    $total_count = Get_Claim_Data($db_con, $where, "", "", "count");

    switch ($display_num){
        case "1":
            $range = $total_count;
            break;
        case "2":
            $range = "100";
            break;
    }

    // 現在のページ数をチェックする
    $page_info = Check_Page($total_count, $range, $f_page1);
    $page      = $page_info[0];     // 現在のページ数
    $page_snum = $page_info[1];     // 表示開始件数
    $page_enum = $page_info[2];     // 表示終了件数

    // ページプルダウン表示判定
    if($page == 1){
        // ページ数が１ならページプルダウンを非表示
        $c_page = null;
    }else{
        // ページ数分プルダウンに表示
        $c_page = $page;
    }
    
    // ページ作成
    $html_page  = Html_Page2($total_count, $c_page, 1, $range);
    $html_page2 = Html_Page2($total_count, $c_page, 2, $range);
    
    // 請求書データ取得
    $claim_data  = Get_Claim_Data($db_con, $where, $page_snum, $page_enum);

}


/****************************/
// 最新の月次更新日を抽出(請求更新のチェックボックスの表示判定用)
/****************************/
$sql  = "SELECT \n";
$sql .= "   COALESCE(MAX(close_day), '".START_DAY."') \n";
$sql .= "FROM \n";
$sql .= "   t_sys_renew \n";
$sql .= "WHERE \n";
$sql .= "   renew_div = '2' \n";
$sql .= "AND \n";
$sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$max_renew_day = pg_fetch_result($res, 0, 0);


/****************************/
// フォーム定義（検索結果）
/****************************/
$i = 0;
if (count($claim_data) > 0){
for ($j = $page_snum; $j <= $page_enum; $j++){

    $chk_bill_id = $claim_data[$i]["bill_id"];//請求ID

    // 請求書のフォーマットが出力しないOR指定以外の場合
    if($claim_data[$i]["bill_format"] != "3" && $claim_data[$i]["bill_format"] != "4"){

        //■請求書フォーマット
        $format_arr = null;
        $format_arr[] =& $form->createElement("radio", null, null, "明細", "1");
        $format_arr[] =& $form->createElement("radio", null, null, "合計", "2");
        $format_arr[] =& $form->createElement("radio", null, null, "個別", "5");
        $form->addGroup($format_arr, "format[$i]", "請求書"," ");

        //個別の場合は値を3に置き換える(請求書の処理に影響するため)
        $set_data["format[$i]"] = $claim_data[$i]["bill_format"];

        //■請求書発行
        //確定の判別はなし
        if ($claim_data[$i][issue_day] == null) {
            // 請求書発行
            $form->addElement("advcheckbox", "claim_issue[$i]", null, null, null, array("f", "$chk_bill_id"));
            $claim_issue_data[$i] = $chk_bill_id;
        //■請求書再発行
        }elseif($claim_data[$i][issue_day] != null){
            // 請求書発行
            $form->addElement("static", "claim_issue[$i]", '', $claim_data[$i][issue_day] );
            $form->addElement("advcheckbox", "re_claim_issue[$i]", null, null, null, array("f", "$chk_bill_id"));
            $set_data["claim_issue"][$i] = $claim_data[$i][issue_day];
            $re_claim_issue_data[$i] = $chk_bill_id;
        }

    }

    //■請求更新
    //確定のステータスは関係なし
    if ($claim_data[$i]["last_update_flg"] == "f" && $auth[0] == "w") {
        // 請求取消
        $form->addElement("advcheckbox", "claim_renew[$i]", null, null, null, array("f", "$chk_bill_id"));
        $claim_renew_data[$i] = $chk_bill_id;
    //更新済の場合は更新日を表示する
    }else{
      $form->addElement("static", "claim_renew[$i]", null, $claim_data[$i]["last_update_day"], null, "");
    }

    //■請求取消
    // 「更新済」かつ「書込み権限あり」の場合
    //請求取消IDがnullじゃない場合＜watanabe-k＞
    if ($claim_data[$i]["last_update_flg"] == "t" && $auth[0] == "w" && $claim_data[$i]["cancel_bill_id"] != null) {
        $cancel_flg = true;
    }

    //■削除
    // 「未更新」かつ「書込み権限あり」の場合、削除リンクを表示する
    if (($claim_data[$i]["last_update_flg"] == "f" && $auth[0] == "w")) {
        $delete_flg = true;
    }else{
        $delete_flg = false;
    }

    //「請求取消が可能」または「請求書削除が可能」は請求取消を可能にする
    //月次更新以前の請求は処理上、確定フラグをfalseにする
    if ($max_renew_day < $claim_data[$i]["close_day"]){
        $disp_flg = "t";
    }

    if($disp_flg == "t" && $delete_flg === true){

        $form->addElement("advcheckbox", "claim_cancel[$i]", null, null, null, array("f", "$chk_bill_id"));
        $claim_cancel_data[$i] = $chk_bill_id;

    //請求取消を不可能にする
    }else{
        //削除リンクを表示しない
        $claim_data[$i][delete] = "";   
    }
    
    $i++;

}
}

// ラジオボタンにセット
$form->setConstants($set_data);

// 請求確定(ALLチェックJSを作成)
$javascript  = Create_Allcheck_Js ("All_Check_Claim_Fix",      "claim_fix",      $claim_fix_data);
// 請求書発行（ALLチェックJSを作成）
$javascript .= Create_Allcheck_Js ("All_Check_Claim_Issue",    "claim_issue",    $claim_issue_data);
// 請求書再発行（ALLチェックJSを作成）
$javascript .= Create_Allcheck_Js ("All_Re_Check_Claim_Issue", "re_claim_issue", $re_claim_issue_data);
// 請求取消(ALLチェックJSを作成)
$javascript .= Create_Allcheck_Js ("All_Check_Claim_Cancel",   "claim_cancel",   $claim_cancel_data);
// 請求更新(ALLチェックJSを作成)
$javascript .= Create_Allcheck_Js ("All_Check_Claim_Renew",    "claim_renew",    $claim_renew_data);


/****************************/
// HTML作成（検索部）
/****************************/
// 共通検索テーブル
$html_s .= Search_Table_Claim($form);
// モジュール個別検索テーブル１
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">請求書発行</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_issue"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">請求書送付</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_claim_send"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// モジュール個別検索テーブル２
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">請求更新</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_last_update"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">請求番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_bill_no"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["hyouji_button"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["kuria_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


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
//$page_menu = Create_Menu_f('sale','3');

/****************************/
//画面ヘッダー作成
/****************************/
//$page_header = Create_Header($page_title);
$page_header = Bill_Header($page_title);

/****************************/
//テンプレートへの処理
/****************************/
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//エラーをassign
$errors = $form->_errors;
$smarty->assign('errors', $errors);

//検索結果
$smarty->assign('claim_data', $claim_data);

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'js'            => "$javascript", 
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));

$smarty->assign("html", array(
    "html_s"        => "$html_s",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

/*
$e_time = microtime();
echo "$s_time"."<br>";
echo "$e_time"."<br>";

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/
?>
