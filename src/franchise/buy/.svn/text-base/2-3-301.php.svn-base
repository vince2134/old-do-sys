<?php

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/23　07-016　　　yamanaka-s　　仕入先名／略称の入力文字数を修正
 * 　2006/10/24　07-018　　　yamanaka-s　　チェックボックス選択後支払入力ボタン押下処理。GETからSESSIONに切り替え
 * 　2006/11/29　ssl_0006　　watanabe-k　　仕入先にはコード２を表示しないバグの修正
 * 　2006/12/07　ban_0041　　suzuki　　　　日付にゼロ埋め追加
 * 　2006/12/07　ban_0042　　suzuki　　　　仕入先CD2で検索する際に取引区分も条件にする
 * 　2006/12/07　ban_0043　　suzuki　　　　仕入先名で検索可
 * 　2006/12/12　ssl_0069　　kaji　　　　　何もチェックしないで支払入力へボタンを押下するとクエリーエラーを修正
 *  2007-04-03              fukuda          検索条件復元処理追加
 *
 * 変更：
 *　日付　　　　担当者　　　内容　
 *　2007/06/08　aizawa_m　　支払入力を削除・仕入締日と明細リンクを追加
 *　2007/06/14　aizawa_m　　検索項目：「仕入締日」を追加,「表示件数」を「全て」「100」に変更
 *　2007/06/27　watanabe-k  更新、取消を追加
 *　2007/07/05　watanabe-k  検索項目に、更新状況を追加
 *  2007-07-12  fukuda      「支払締」を「仕入締」に変更
 *  2007-07-12  fukuda      「支払更新」を「仕入締更新」に変更
 *
 */

// ページ名
$page_title = "支払予定一覧";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");
//現モジュール内のみで使用する関数ファイル
require_once(INCLUDE_DIR."schedule_payment.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();
//$db_con = Db_Connect('aizawa');


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_pay_day"      => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_client"       => array("cd1" => "", "cd2" => ""),
    "form_client_name"  => "",
    "form_buy_amouont"  => array("s" => "", "e" => ""),
    "form_pay_amouont"  => array("s" => "", "e" => ""),
    //↓2007.06.14変更
//    "form_show_num"     => "2",
    "form_show_num"     => "1",
    "form_close_day"    => array(   "y" => date("Y") ,
                                    "m" => date("m") ,
                                    "d" => "00",
                            ),
     "form_update_state" => 'all',

);

// 検索条件復元
Restore_Filter2($form, "payout", "show_button", $ary_form_list);


/****************************/
// 外部変数取得
/****************************/
$group_kind = $_SESSION["group_kind"];


/****************************/
// 初期値設定
/****************************/
$form->setDefaults($ary_form_list);

//$limit          = "50";     // LIMIT  2007.06.14#コメント
$limit          = "0";      // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
// フォームパーツ定義
/****************************/
// 支払予定一覧 −ボタンの色を変更 2007.06.14−
$form->addElement("button", "pay_button", "支払予定一覧", "style=color:#ff0000 onClick=\"location.href='$_SERVER[PHP_SELF]'\"".$g_button_color);

// 入力
$form->addElement("button", "new_button", "仕入締処理", "onClick=\"javascript:Referer('2-3-307.php')\"");

// 支払予定日
Addelement_Date_Range($form, "form_order_day", "支払予定日", "-");

// 仕入先コード
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($text, "form_client", "", "");

// 仕入先名／略称
$form->addElement("text", "form_client_name", "仕入先名／略称", "size=\"34\" maxLength=\"15\" $g_form_option");

// 今回仕入額（税込）
$text = null;
$text[] =& $form->createElement("text", "s", "", "size=\"11\" maxLength=\"9\"
    $g_form_option style=\"text-align: right; $g_form_style\" class=\"money\"
    onkeyup=\"changeText(this.form,'form_buy_amount[s]','form_buy_amount[e]',9)\" $g_form_option
");
$text[] =& $form->createElement("static", "", "", "〜");
$text[] =& $form->createElement("text", "e", "",
    "size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\" class=\"money\""
);
$form->addGroup($text, "form_buy_amount", "", "");

// 今回支払予定額
$text = null;
$text[] =& $form->createElement("text", "s", "", "size=\"11\" maxLength=\"9\"
    $g_form_option style=\"text-align: right; $g_form_style\" class=\"money\"
    onkeyup=\"changeText(this.form,'form_pay_amount[s]','form_pay_amount[e]',9)\" $g_form_option
");
$text[] =& $form->createElement("static", "", "", "〜");
$text[] =& $form->createElement("text", "e", "",
    "size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\" class=\"money\""
);
$form->addGroup($text, "form_pay_amount", "", "");

// 仕入締更新ALL
$form->addElement("checkbox", "payment_all_update", "", "仕入締更新","onClick=\"javascript:All_Check_Update('payment_all_update');\"");
// 支払取り消しALL
$form->addElement("checkbox", "payment_all_delete", "", "仕入締取消", "onClick=\"javascript:All_Check_Delete('payment_all_delete');\"");
// 仕入締更新ボタン
$form->addElement("submit", "renew_button", "仕入締更新", "onClick=\"javascript:return(Dialogue4('更新します。'));\" $disabled");
// 支払取消ボタン
$form->addElement("submit", "cancel_button", "仕入締取消", 
                "onClick=\"javascript:return(Dialogue4('仕入締の取消しと、仕入締期間内の仕入・支払伝票の日次更新解除を行ないます。'));\" $disabled");


/******************************/
//検索項目の変更_2007.06.14
//*****************************/
// 表示件数
$number[]   = $form->createElement("radio" , "num" , NULL , "全て " , "1" );
$number[]   = $form->createElement("radio" , "num" , NULL , "100"  , "2" );
$form->addGroup($number , "form_show_num" , "" , "" );
// 仕入締日
//Addelement_Date_Range($form, "form_close_day", "仕入締日", "-");
$sql  = "SELECT \n";
$sql .= "   DISTINCT close_day \n";
$sql .= "FROM \n";
$sql .= "   t_client \n";
$sql .= "WHERE \n";
$sql .= "   client_div = '2' \n";
$sql .= "AND \n";
$sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
$sql .= ";"; 

$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);

for ($i = 0; $i < $num; $i++){
    $client_close_day[] = pg_fetch_result($res, $i, 0); 
}
if ($num > 0){
    asort($client_close_day);
    $client_close_day = array_values($client_close_day);
}

$item   =   null;
$item[0]=   "全て"; 

for ($i = 0; $i < $num; $i++){
    if ($client_close_day[$i] < 29 && $client_close_day[$i] != ""){
         $item[(int)$client_close_day[$i]] = (int)$client_close_day[$i]."日";
    }elseif ($client_close_day[$i] != "" && $client_close_day[$i] >= 29){
         $item[(int)$client_close_day[$i]] = "月末";
    }
}
$obj    =   null;
$obj[]  =&  $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
        onkeyup=\"changeText(this.form, 'form_close_day[y]', 'form_close_day[m]', 4);\"
        onFocus=\"onForm_today2(this, this.form, 'form_close_day[y]', 'form_close_day[m]');\"
        onBlur=\"blurForm(this);\"");
$obj[]  =&  $form->createElement("text", "m", "", "size=\"1\" maxLength=\"2\" class=\"ime_disabled\"
        onkeyup=\"changeText(this.form, 'form_close_day[m]', 'form_close_day[d]', 4);\"
        onFocus=\"onForm_today2(this, this.form, 'form_close_day[y]', 'form_close_day[m]');\"
        onBlur=\"blurForm(this);\"");
$obj[]  =&  $form->createElement("select", "d", "", $item, $g_form_option_select);$form->addGroup($obj, "form_close_day", "仕入締日", "-");


//更新状況
$form_update_state[] = $form->createElement("radio" , null , Null , "全て " , "all" );
$form_update_state[] = $form->createElement("radio" , null , Null , "未実施", "f" );
$form_update_state[] = $form->createElement("radio" , null , Null , "実施済", "t" );
$form->addGroup($form_update_state , "form_update_state" , "" , "");

//$number = array("1" => "10", "2" => "50", "3" => "100", "4" => "全て");
//$form->addElement("select", "form_show_num", "", $number, $g_form_option_select);
/******************************/

// 表示ボタン
$form->addElement("submit", "show_button", "表　示");

// クリアボタン
$form->addElement("button", "clear_button", "クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

/*/ 支払入力へボタン    2007.06.08＃コメント
$form->addElement(
    "button", "form_order_button", "支払入力へ",
    "onClick=\"javascript: Button_Submit('order_button_flg', '".$_SERVER["PHP_SELF"]."', 'true'); \" $disabled"
);
*/

// 処理フラグ
$form->addElement("hidden","order_button_flg");


/****************************/
// 表示ボタン押下処理
/****************************/
if($_POST["show_button"] == "表　示"){

    // 日付POSTデータの0埋め
    $_POST["form_order_day"]    = Str_Pad_Date($_POST["form_order_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■支払予定日
    // エラーメッセージ
    $err_msg = "支払予定日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_order_day", $err_msg);

    // ■今回仕入額（税込）
    // エラーメッセージ
    $err_msg = "今回仕入額（税込） は数値のみ入力可能です。";
    Err_Chk_Int($form, "form_buy_amount", $err_msg);

    // ■今回支払予定額
    // エラーメッセージ
    $err_msg = "今回支払予定額 は数値のみ入力可能です。";
    Err_Chk_Int($form, "form_pay_amount", $err_msg);
    
    //↓2007.06.14追加↓
    // ■仕入締日
    // エラーメッセージ
//    $err_msg = "仕入締日 の日付が妥当ではありません。";
//    Err_Chk_Date($form, "form_close_day", $err_msg);

    // ■仕入締日
    $err_msg = "仕入締日 の日付が妥当ではありません。";
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

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

//更新処理
}elseif($_POST["renew_button"] == "仕入締更新"){

    $ary_update_id = $_POST["payment_update"];

    if(count($ary_update_id) > 0){

        while($update_id = each($ary_update_id)){
            if($update_id["1"] == 'f'){
                continue;
            }

            $result = Update_Schedule_Payment($db_con, $update_id["1"]);
            if($result === false){
                exit;
            }
        }
    }

//削除処理
}elseif($_POST["cancel_button"] == "仕入締取消"){

    $ary_delete_id = $_POST["payment_delete"];

    $result = Delete_Schedule_Payment($db_con, $ary_delete_id);

    //支払エラー
    if(is_array($result)){

        foreach($result AS $key => $var){
            $err_message[] = $var["payment_close_day"]."締の".$var["client_name"]."の支払予定データに対して既に
                            支払番号：".$var["pay_no"]."の支払が起こっているため削除できません。";
        }

    //トランザクション失敗
    }elseif($result === false){
        exit;
    }
}


/****************************/
// 1. 表示ボタン押下＋エラーなし時
// 2. ページ切り替え時
/****************************/
if (($_POST["show_button"] != null && $err_flg != true ) || ($_POST != null && $_POST["show_button"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_order_day"]    = Str_Pad_Date($_POST["form_order_day"]);
    $_POST["form_close_day"]    = Str_Pad_Date($_POST["form_close_day"]);   //2007.06.14追加

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $order_day_sy   = $_POST["form_order_day"]["sy"];
    $order_day_sm   = $_POST["form_order_day"]["sm"];
    $order_day_sd   = $_POST["form_order_day"]["sd"];
    $order_day_ey   = $_POST["form_order_day"]["ey"];
    $order_day_em   = $_POST["form_order_day"]["em"];
    $order_day_ed   = $_POST["form_order_day"]["ed"];
    $client_cd1     = $_POST["form_client"]["cd1"];
//    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client_name"];
    $buy_amount_s   = $_POST["form_buy_amount"]["s"];
    $buy_amount_e   = $_POST["form_buy_amount"]["e"];
    $pay_amount_s   = $_POST["form_pay_amount"]["s"];
    $pay_amount_e   = $_POST["form_pay_amount"]["e"];
    //↓2007.06.14追加↓
    ////$show_num       = $_POST["form_show_num"];
    $show_num       = $_POST["form_show_num"]["num"];
    $close_day_sy   = ($_POST["form_close_day"]["y"] != null)? $_POST["form_close_day"]["y"] : "____";
    $close_day_sm   = ($_POST["form_close_day"]["m"] != null)? $_POST["form_close_day"]["m"] : "__";
    $close_day_sd   = $_POST["form_close_day"]["d"];
    $update_state   = $_POST["form_update_state"];
/*
    $close_day_sy   = $_POST["form_close_day"]["sy"];
    $close_day_sm   = $_POST["form_close_day"]["sm"];
    $close_day_sd   = $_POST["form_close_day"]["sd"];
    $close_day_ey   = $_POST["form_close_day"]["ey"];
    $close_day_em   = $_POST["form_close_day"]["em"];
    $close_day_ed   = $_POST["form_close_day"]["ed"];
*/
    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // 支払予定日（開始）
    $order_day_s = $order_day_sy."-".$order_day_sm."-".$order_day_sd;
    $sql .= ($order_day_s != "--") ? "AND '$order_day_s' <= t_schedule_payment.payment_expected_date \n" : null;
    // 支払予定日（終了）
    $order_day_e = $order_day_ey."-".$order_day_em."-".$order_day_ed;
    $sql .= ($order_day_e != "--") ? "AND t_schedule_payment.payment_expected_date <= '$order_day_e' \n" : null;
    // 仕入先コード1
    $sql .= ($client_cd1 != null) ? "AND t_schedule_payment.client_cd1 LIKE '$client_cd1%' \n" : null;
    // 仕入先コード2
    $sql .= ($client_cd2 != null) ? "AND t_schedule_payment.client_cd2 LIKE '$client_cd2%' \n" : null;
    // 仕入先名
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_schedule_payment.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // 今回仕入額（税込）（開始）
    $sql .= ($buy_amount_s != null) ? "AND $buy_amount_s <= t_schedule_payment.account_payable \n" : null;
    // 今回仕入額（税込）（終了）
    $sql .= ($buy_amount_e != null) ? "AND t_schedule_payment.account_payable <= $buy_amount_e \n" : null;
    // 今回支払予定額（開始）
    $sql .= ($pay_amount_s != null) ? "AND $pay_amount_s <= t_schedule_payment.schedule_of_payment_this \n" : null;
    // 今回支払予定額（終了）
    $sql .= ($pay_amount_e != null) ? "AND t_schedule_payment.schedule_of_payment_this <= $pay_amount_e \n" : null;

    /*******************/
    //2007.06.14追加
    /*******************/
/*
    // 仕入締日（開始）
    $close_day_s = $close_day_sy."-".$close_day_sm."-".$close_day_sd;
    $sql .= ($close_day_s != "--") ? "AND '$close_day_s' <= t_schedule_payment.payment_close_day \n" : null;
    // 仕入締日（終了）
    $close_day_e = $close_day_ey."-".$close_day_em."-".$close_day_ed;
    $sql .= ($close_day_e != "--") ? "AND t_schedule_payment.payment_close_day <= '$close_day_e' \n" : null;
*/
    if ($close_day_sd == "00"){
        $sql .= "AND t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-__' \n";
    }else  
    // 請求締日（日：月末）
    if ($close_day_sd == "29"){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-28' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-29' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-30' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-31' \n";
        $sql .= "   ) \n";
    // 請求締日（日：日付指定）
    }else{ 
        $sql .= "AND t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-".$close_day_sd."' \n";
    }

    //更新状況
    $sql .= ($update_state != 'all') ? "AND t_schedule_payment.last_update_flg = '$update_state' \n" : null;


    // 変数詰め替え
    $where_sql = $sql;

//} 2007.06.14#コメント


/****************************/
// 一覧データ取得
/****************************/
if ($err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_schedule_payment.client_cd1, \n";
    $sql .= "   t_schedule_payment.client_cd2, \n";
    $sql .= "   to_char(t_schedule_payment.payment_expected_date, 'yyyy-mm-dd'), \n";
    $sql .= "   t_schedule_payment.last_account_payable, \n";
    $sql .= "   t_schedule_payment.payment, \n";
    $sql .= "   t_schedule_payment.rest_amount, \n";
    $sql .= "   t_schedule_payment.sale_amount, \n";
    $sql .= "   t_schedule_payment.tax_amount, \n";
    $sql .= "   t_schedule_payment.account_payable, \n";
    $sql .= "   t_schedule_payment.ca_balance_this, \n";
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";
    $sql .= "   t_schedule_payment.schedule_payment_id, \n";
    $sql .= "   t_schedule_payment.client_cname, \n";
    $sql .= "   t_client.client_div, \n";
    $sql .= "   t_schedule_payment.payment_close_day, \n";  //仕入締日を抽出　2007.06.08追加
    $sql .= "   t_schedule_payment.client_id, \n";           //仕入先IDを抽出　2007.06.11追加
    $sql .= "   t_schedule_payment.last_update_flg, \n";
    $sql .= "   t_schedule_payment.last_update_day \n";
    $sql .= "FROM \n";
    $sql .= "   t_schedule_payment \n";
    $sql .= "   INNER JOIN t_client ON t_schedule_payment.client_id = t_client.client_id \n";

//    if ($group_kind == "2"){
//    $sql .= "WHERE t_schedule_payment.shop_id IN (".Rank_Sql().") \n";
//    }else{
    $sql .= "WHERE t_schedule_payment.shop_id = ".$_SESSION["client_id"]." \n";
//    }
    $sql .= "   AND first_set_flg = 'f' ";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= "   payment_close_day, client_cd1, client_cd2 \n";

    // 全件数取得
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // LIMIT, OFFSET条件作成
    if ($post_flg == true && $err_flg != true){

        //表示件数 -2007.06.14変更-
        if ($show_num == "1" ) {
            $limit = $total_count;  //全件
        }
        else {
            $limit = 100;   //100件
        }
/*  2007.06.14#コメント
        if($show_num == "1"){
            $limit = "10";
        }else if($show_num == "2"){
           $limit = "50";
        }else if($show_num == "3"){
           $limit = "100";
        }else if($show_num == "4"){
           $limit = $total_count;
        }
*/

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

    }

    // ページ内データ取得
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $row_count      = pg_num_rows($res);
    $page_data      = Get_Data($res);

    /****************************/
    // ページ作成
    /****************************/
    //2007.06.14_処理位置変更：一覧表示有りの場合のみ作成
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);
}

}//IF一覧SQL作成


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


// 金額をカンマで区切る
for($i = 0; $i < $row_count; $i++){

    //仕入先ごとの最新のレコードのみ合計に反映
    if(!@in_array($page_data[$i][15],$max_client_id)){

        $max_client_id[] = $page_data[$i][15];

        $sql  = "SELECT";
        $sql .= "   COALESCE(last_account_payable,0) AS last_account_payable, ";
        $sql .= "   COALESCE(payment,0) AS payment, ";
        $sql .= "   COALESCE(rest_amount,0) AS rest_amount, ";
        $sql .= "   COALESCE(sale_amount,0) AS sale_amount, ";
        $sql .= "   COALESCE(tax_amount,0) AS tax_amount, ";
        $sql .= "   COALESCE(account_payable,0) AS account_payable, ";
        $sql .= "   COALESCE(ca_balance_this,0) AS ca_balance_this, ";
        $sql .= "   COALESCE(schedule_of_payment_this,0) AS schedule_of_payment_this ";
        $sql .= "FROM ";
        $sql .= "   t_schedule_payment ";
        $sql .= "WHERE ";
        $sql .= "   schedule_payment_id IN (SELECT ";
        $sql .= "                               MAX(schedule_payment_id) ";
        $sql .= "                           FROM ";
        $sql .= "                               t_schedule_payment ";
        $sql .= "                           WHERE ";
        $sql .= "                               client_id = ".$page_data[$i][15]."";
        $sql .= "                               $where_sql";
        $sql .= "                           )";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        $ary_amount = pg_fetch_assoc($result, 0);


        $sum1 = bcadd($sum1, $ary_amount["last_account_payable"]);  //前回買掛残高
        $sum2 = bcadd($sum2, $ary_amount["payment"]);               //今回支払額
        $sum3 = bcadd($sum3, $ary_amount["rest_amount"]);           //繰越額
        $sum4 = bcadd($sum4, $ary_amount["sale_amount"]);           //今回仕入額
        $sum5 = bcadd($sum5, $ary_amount["tax_amount"]);            //今回消費税額
        $sum6 = bcadd($sum6, $ary_amount["account_payable"]);       //今回仕入額(税込)
        $sum7 = bcadd($sum7, $ary_amount["ca_balance_this"]);       //今回買掛残高(税込)
        $sum8 = bcadd($sum8, $ary_amount["schedule_of_payment_this"]);          //今回支払予定額
    }

    //仕入締未更新の場合
    $check_payment_id = $page_data[$i][11];
    if($page_data[$i][16] == 'f'){
        //更新のチェックボックスを作成
        $form->addElement("advcheckbox", "payment_update[$i]", null, null, null, array("f", "$check_payment_id"));
        $payment_update_data[$i] = $check_payment_id;

        //月次更新日より後の支払のみ削除可能
        if($max_renew_day < $page_data[$i][14]){
            //削除のチェックボックスを作成
            $form->addElement("advcheckbox", "payment_delete[$i]", null, null, null, array("f", "$check_payment_id"));
            $payment_delete_data[$i] = $check_payment_id;
        }       

    }else{  
        //更新のチェックボックスを作成
        $form->addElement("static", "payment_update[$i]", "", $page_data[$i][17]);
        $set_data["payment_update"][$i] = $page_data[$i][17];
    }
}

$form->setConstants($set_data);

//締更新(ALLチェックJSを作成)
$javascript  = Create_Allcheck_Js ("All_Check_Update","payment_update", $payment_update_data);
//締削除（ALLチェックJSを作成）
$javascript .= Create_Allcheck_Js ("All_Check_Delete","payment_delete", $payment_delete_data);


/****************************/
// チェックボックス作成
/****************************/
/*/ 支払入力チェック    2007.06.08＃コメント
$form->addElement("checkbox", "form_order_all_check", "", "支払入力", ";
    onClick=\"javascript: All_check('form_order_all_check', 'form_order_check', $row_count)\"
");

for($j = 0; $j < $row_count; $j++){
    $form->addElement("checkbox", "form_order_check[$j]");
}

for($j = 0; $j < $row_count; $j++){
    $clear_data["form_order_check"][$j] = "";
}
$clear_data["form_order_all_check"] = "";
$form->setConstants($clear_data);
*/

/****************************/
// 支払入力へボタン押下処理
/****************************/
/* 2007.06.14#コメント
if ($_POST["order_button_flg"] == "true" && $_POST["show_button"] == null){

    // hiddenのフラグをクリア
    $clear_hdn["order_button_flg"] = "";
    $form->setConstants($clear_hdn);

    // 未チェック時
    if (count($_POST["form_order_check"]) == 0){
        //2007.06.08＃コメント
       // $form->setElementError("form_order_all_check","支払入力を行う仕入先を選択してください。");

    // チェックがある場合
    }else{

        /****************************/
        // 発注商品IDを取得
        /****************************/
/*        for($i = 0; $i < $total_count; $i++){
            if($_POST["form_order_check"][$i] == 1){
                $order_goods_id[] = $page_data[$i][11];
            }
        }
        // 重複を纏める
        asort($order_goods_id);
        $order_goods_id = array_values(array_unique($order_goods_id));

        /****************************/
        // GETする値を生成
        /****************************/
/*        $r = 0;
        for($i = 0; $i < count($order_goods_id); $i++){
            $get_goods_id .= "schedule_payment_id[".$r."]=".$order_goods_id[$i];
            
            // セッションに詰める
            $_SESSION["schedule_payment_id"][$i] = $order_goods_id[$i];
            if($i != count($order_goods_id)-1){
                $get_goods_id .= "&";
                $r = $r+1;
            }else{
                break;
            }
        }

        header("Location: ".FC_DIR."buy/2-3-302.php");

    }

}
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
//$page_menu = Create_Menu_h('buy','3');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[pay_button]]->toHtml();
$page_header = Create_Header($page_title);


//Render関連の設定
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
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
        'sum1'          => "$sum1",
        'sum2'          => "$sum2",
        'sum3'          => "$sum3",
        'sum4'          => "$sum4",
        'sum5'          => "$sum5",
        'sum6'          => "$sum6",
        'sum7'          => "$sum7",
        'sum8'          => "$sum8",
        'r'          => "$limit",
    "err_flg"       => "$err_flg",
    "javascript"    => "$javascript",
));
$smarty->assign('row',$page_data);
$smarty->assign('post_flg',$post_flg);  //2007.06.14追加
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
?>
