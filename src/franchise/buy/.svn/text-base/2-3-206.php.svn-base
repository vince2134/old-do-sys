<?php
/********************
 * 割賦仕入入力
 *
 *
 * 変更履歴
 *    2006/07/07 (kaji)
 *      ・shop_gidをなくす
 *    2006/09/16 (kaji)
 *      ・分割回数を2回以上に
 *      ・支払日は翌月支払日以降に
 *    2006/09/20 (fukuda-sss)
 *      ・権限処理修正
 *    2006/10/26 (kaji)
 *      ・支払日は仕入入力で入力された仕入日を基準に
 *    2006/10/27 (kaji)
 *      ・仕入先名は略称を表示
 *
 *    2006/11/27 (watanabe-k)
 *      ・基準日＋支払日（月）とするように修正
 ********************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/13      03-083      ふ          割賦設定中に仕入伝票が変更された場合の対処
 *  2006/12/14      kaji-0200   watanbe-k   割賦入力中に伝票を削除された場合にクエリエラーが表示されるバグの修正
 *  2007/01/16      仕様変更    watanbe-k   割賦回数を２〜６０に変更
 *
 */

//$page_title = "仕入照会";
$page_title = "割賦仕入入力";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form = &new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
// 外部変数取得
/****************************/
$staff_id       = $_SESSION["staff_id"];
$shop_id        = $_SESSION["client_id"];
//$shop_gid       = $_SESSION["shop_gid"];
$buy_id         = ($_POST["add_button"] != null) ? $_POST["hdn_get_id"] : $_GET["buy_id"];    // 仕入ID
Get_Id_Check2($buy_id);
Get_Id_Check3($buy_id);
$division_flg   = $_GET["division_flg"];       // 分割設定済フラグ


// 伝票変更日時をセットデフォルト
$sql = "SELECT change_day FROM t_buy_h WHERE buy_id = $buy_id ;";
$res = Db_Query($db_con, $sql);
Get_Id_Check($res);
$set_change_date["hdn_change_date"] = pg_fetch_result($res, 0, 0);
$form->setDefaults($set_change_date);

/****************************/
// 正当性チェック
/****************************/
// GETした仕入IDの伝票が割賦仕入かチェック
$sql = "SELECT * FROM t_buy_h WHERE buy_id = $buy_id AND trade_id = 25;";
$res = Db_Query($db_con, $sql);
$num = pg_num_rows($res);
($num == 0) ? header("Location: ../top.php") : null; 

if ($_GET["buy_id"] != null){
    $set_id["hdn_get_id"] = $_GET["buy_id"];
    $form->setConstants($set_id);
}

/****************************/
// 部品定義
/****************************/
// 発注番号
$form->addElement("static", "form_ord_no", "", "");

// 仕入先
$text = null;
$text[] = &$form->createElement("static", "cd1", "", "");
$text[] = &$form->createElement("static", "", "", "-");
$text[] = &$form->createElement("static", "cd2", "", "");
$text[] = &$form->createElement("static", "", "", " ");
$text[] = &$form->createElement("static", "name", "", "");
$form->addGroup($text, "form_client", "");

// 伝票番号
$form->addElement("static", "form_buy_no", "", "");

// 入荷日
$text = null;
$text[] = &$form->createElement("static", "y", "", "");
$text[] = &$form->createElement("static", "", "", "-");
$text[] = &$form->createElement("static", "m", "", "");
$text[] = &$form->createElement("static", "", "", "-");
$text[] = &$form->createElement("static", "d", "", "");
$form->addGroup($text, "form_arrival_day", "");

// 取引区分
$form->addElement("static", "form_trade_buy", "", "");

// 仕入日
$text = null;
$text[] = &$form->createElement("static", "y", "", "");
$text[] = &$form->createElement("static", "", "", "-");
$text[] = &$form->createElement("static", "m", "", "");
$text[] = &$form->createElement("static", "", "", "-");
$text[] = &$form->createElement("static", "d", "", "");
$form->addGroup($text, "form_buy_day", "");

// 仕入倉庫
$form->addElement("static", "form_ware_name", "", "");

// 直送先
$form->addElement("static", "form_direct_name", "", "");

// 発注担当者
$form->addElement("static", "form_oc_staff_name", "", "");

// 仕入担当者
$form->addElement("static", "form_c_staff_name", "", "");

// 備考
$form->addElement("static", "form_note", "", "");


// 税抜金額
$form->addElement("text", "form_buy_total", "", "size=\"25\" maxLength=\"18\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #FFFFFF; text-align: right\" readonly");

// 消費税
$form->addElement("text", "form_buy_tax", "", "size=\"25\" maxLength=\"18\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: right\" readonly");

// 税込金額
$form->addElement("text", "form_buy_money", "", "size=\"25\" maxLength=\"18\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: right\" readonly");


// 支払日（月）
$select_month[null] = null; 
//for($i = 1; $i <= 12; $i++){
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "当月"; 
    }elseif($i == 1){
//    if($i == 1){
        $select_month[1] = "翌月";
    }else{
        $select_month[$i] = $i."ヶ月後";
    }
}
$form->addElement("select", "form_pay_m", "", $select_month, $g_form_option_select);

// 支払日（日）
for($i = 0; $i <= 29; $i++){
    if($i == 29){
        $select_day[$i] = '月末';
    }elseif($i == 0){
        $select_day[null] = null;
    }else{
        $select_day[$i] = $i."日";
    }
}
$freeze_pay_d = $form->addElement("select", "form_pay_d", "", $select_day, $g_form_option_select);
$freeze_pay_d->freeze();

// 分割回数
$select_value[null] = null;
/*
$ary_division_num  = array(2, 3, 6, 12, 24, 36, 48, 60);
for ($i=0; $i<count($ary_division_num); $i++){
    $select_value[$ary_division_num[$i]] = $ary_division_num[$i]."回";
}
*/

for($i = 2; $i <= 60; $i++){
    $select_value[$i] = $i."回";
}
$form->addElement("select", "form_division_num", "", $select_value, $g_form_option_select);

// 分割設定ボタン
$form->addElement("button", "form_conf_button", "分割設定", "onClick=\"Button_Submit('hdn_division_submit','#','t');\" $disabled");

// 分割支払登録ボタン
$form->addElement("submit", "add_button", "分割支払登録", "$disabled");

// OKボタン
$form->addElement("button", "ok_button", "Ｏ　Ｋ",
    "onClick=\"location.href='".Make_Rtn_Page("buy")."'\""
);

// 戻るボタン
$form->addElement("button", "return_button", "戻　る", "onClick=\"javascript:history.back()\"");

// hidden
$form->addElement("hidden", "hdn_get_id", "");
$form->addElement("hidden", "hdn_division_submit", "");
$form->addElement("hidden", "hdn_pay_m", "");
$form->addElement("hidden", "hdn_pay_d", "");
$form->addElement("hidden", "hdn_division_num", "");
$form->addElement("hidden", "hdn_change_date");
$form->addElement("hidden", "hdn_payout_m");

/****************************/
// 仕入ヘッダ用データ取得
/****************************/
// 抽出判定処理
$sql    = "SELECT renew_flg FROM t_buy_h WHERE t_buy_h.buy_id = $buy_id AND ";
$sql .= ($_SESSION["group_kind"] == "2") ? "shop_id IN (".Rank_Sql().");" : "shop_id = $shop_id;";
$result = Db_Query($db_con, $sql);
// GETデータ判定
Get_Id_Check($result);

// 日次更新フラグ取得
$renew_flg = pg_fetch_result($result, 0, 0);
$division_flg = ($renew_flg == "t") ? "true" : $division_flg;

// データ取得
$sql  = "SELECT ";
$sql .= "    t_buy_h.buy_no, ";
$sql .= "    t_order_h.ord_no, ";
$sql .= "    t_buy_h.buy_day, ";
$sql .= "    t_buy_h.arrival_day, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.client_cd1, "   : " t_client.client_cd1, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.client_name, "  : " t_client.client_name, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.direct_name, "  : " t_direct.direct_name, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.ware_name, "    : " t_ware.ware_name, ";
$sql .= "    t_buy_h.client_cd1, ";
$sql .= "    t_buy_h.client_cname, ";
$sql .= "    t_buy_h.direct_name, ";
$sql .= "    t_buy_h.ware_name, ";
$sql .= "    CASE t_buy_h.trade_id";
$sql .= "        WHEN '21' THEN '掛仕入' ";
$sql .= "        WHEN '22' THEN '掛返品' ";
$sql .= "        WHEN '23' THEN '掛値引' ";
//$sql .= ($renew_flg == "f") ? " WHEN '25' THEN '割賦仕入' " : null;
$sql .= "        WHEN '25' THEN '割賦仕入' ";
$sql .= "        WHEN '71' THEN '現金仕入' ";
$sql .= "        WHEN '72' THEN '現金返品' ";
$sql .= "        WHEN '73' THEN '現金値引' ";
$sql .= "    END,";
//$sql .= ($renew_flg == "t") ? " t_buy_h.c_staff_name, " : " t_staff.staff_name, ";
$sql .= "    t_buy_h.c_staff_name, ";
$sql .= "    t_buy_h.note, ";
$sql .= "    t_buy_h.net_amount, ";
$sql .= "    t_buy_h.tax_amount, ";
$sql .= "    t_buy_h.client_id, ";
$sql .= "    t_buy_h.renew_flg, ";
$sql .= "    t_buy_h.client_cd2 ";
$sql .= "FROM ";
$sql .= "    t_buy_h ";
//$sql .= ($renew_flg == "f") ? " LEFT JOIN t_direct ON t_buy_h.direct_id   = t_direct.direct_id " : null;
$sql .= "    LEFT JOIN t_order_h ON t_buy_h.ord_id = t_order_h.ord_id ";
//$sql .= ($renew_flg == "f") ? " INNER JOIN t_client ON t_buy_h.client_id  = t_client.client_id " : null;
//$sql .= ($renew_flg == "f") ? " INNER JOIN t_ware   ON t_buy_h.ware_id    = t_ware.ware_id " : null;
//$sql .= ($renew_flg == "f") ? " INNER JOIN t_staff  ON t_buy_h.c_staff_id = t_staff.staff_id " : null;
$sql .= "WHERE ";
$sql .= "    t_buy_h.shop_id = $shop_id ";
$sql .= "AND ";
$sql .= "    t_buy_h.buy_id = $buy_id;";

$result = Db_Query($db_con, $sql);
$h_data_list = Get_Data($result);

// 発注担当者取得
$sql  = "SELECT ";
//$sql .= "    t_staff.staff_name ";
$sql .= "    t_buy_h.oc_staff_name ";
$sql .= "FROM ";
$sql .= "    t_buy_h ";
$sql .= "    INNER JOIN t_staff ON t_buy_h.oc_staff_id = t_staff.staff_id ";
$sql .= "WHERE ";
$sql .= "    t_buy_h.shop_id = $shop_id ";
$sql .= "AND ";
$sql .= "    t_buy_h.buy_id = $buy_id;";
$result = Db_Query($db_con, $sql);   
$oc_staff = Get_Data($result);

if($h_data_list[0][14] == "t" && isset($_POST["add_button"])){
   $renew_msg = "日次更新されているため、割賦売上入力できません。";
}

/****************************/
// 取得データを仕入ヘッダにSET
/****************************/
$def_fdata["form_buy_no"]           =   $h_data_list[0][0];                         // 伝票番号
$def_fdata["form_ord_no"]           =   $h_data_list[0][1];                         // 発注番号

$form_buy_day                       =   explode("-", $h_data_list[0][2]);
$def_fdata["form_buy_day"]["y"]     =   $form_buy_day[0];                           // 仕入日(年)
$def_fdata["form_buy_day"]["m"]     =   $form_buy_day[1];                           // 仕入日(月)
$def_fdata["form_buy_day"]["d"]     =   $form_buy_day[2];                           // 仕入日(日)

$form_arrival_day                   =   explode("-", $h_data_list[0][3]);
$def_fdata["form_arrival_day"]["y"] =   $form_arrival_day[0];                       // 入荷日(年)
$def_fdata["form_arrival_day"]["m"] =   $form_arrival_day[1];                       // 入荷日(月)
$def_fdata["form_arrival_day"]["d"] =   $form_arrival_day[2];                       // 入荷日(日)

$def_fdata["form_client"]["cd1"]    =   $h_data_list[0][4];                         // 仕入先コード   
$def_fdata["form_client"]["cd2"]    =   $h_data_list[0][15];                         // 仕入先コード   
$def_fdata["form_client"]["name"]   =   $h_data_list[0][5];                         // 仕入先名

$def_fdata["form_direct_name"]      =   $h_data_list[0][6];                         // 直送先
$def_fdata["form_ware_name"]        =   $h_data_list[0][7];                         // 倉庫
$def_fdata["form_trade_buy"]        =   $h_data_list[0][8];                         // 取引区分
$def_fdata["form_oc_staff_name"]    =   $oc_staff[0][0];                            // 発注担当者
$def_fdata["form_c_staff_name"]     =   $h_data_list[0][9];                         // 仕入担当者
$def_fdata["form_note"]             =   $h_data_list[0][10];                        // 備考

$def_fdata["form_buy_total"]        =   number_format($h_data_list[0][11]);         // 税抜金額
$def_fdata["form_buy_tax"]          =   number_format($h_data_list[0][12]);         // 消費税
$total_money                        =   $h_data_list[0][11] + $h_data_list[0][12];  // 税込金額
$def_fdata["form_buy_money"]        =   number_format($total_money);                         

//支払日（毎月）
$sql = "SELECT payout_d, payout_m FROM t_client WHERE client_id = ".$h_data_list[0][13].";";
$result = Db_Query($db_con,$sql);
$def_fdata["form_pay_d"] = pg_fetch_result($result, 0, 0);
$def_fdata["hdn_payout_m"] = pg_fetch_result($result, 0,1);

$form->setDefaults($def_fdata);

//入力された仕入日を基準にする
$yy = (int)$form_buy_day[0];
$mm = (int)$form_buy_day[1];

/****************************/
// 分割設定確認のみの場合
/****************************/
if ($division_flg == "true"){

    // 該当仕入IDの分割データを取得
    $sql = "SELECT pay_day, split_pay_amount FROM t_amortization WHERE buy_id = $buy_id ORDER BY pay_day;";
    $res = Db_Query($db_con, $sql);
    $i = 0;
    while ($ary_res = @pg_fetch_array($res, $i, PGSQL_ASSOC)){
        $ary_division_data[$i]["pay_day"] = $ary_res["pay_day"];
        $ary_division_data[$i]["split_pay_amount"] = $ary_res["split_pay_amount"];
        $i++;
    }

    for ($i=0; $i<count($ary_division_data); $i++){
        $form->addElement("static", "form_pay_date[$i]", "");
        $form->addElement("static", "form_pay_amount[$i]", "");
        $division_data["form_pay_date[$i]"]     = $ary_division_data[$i]["pay_day"];
        $division_data["form_pay_amount[$i]"]   = number_format($ary_division_data[$i]["split_pay_amount"]);
        $form->setConstants($division_data);
    }

/****************************/
// 分割設定を行う・未設定の場合
/****************************/
}else{

    /****************************/
    // 分割設定ボタン押下時　前処理
    /****************************/
    if ($_POST["hdn_division_submit"] == "t"){

        /*** 分割設定エラーチェック ***/

        // エラーフラグ格納先作成
        $ary_division_err_flg = array();

        // 支払日
        if ($_POST["form_pay_m"] == null || $_POST["form_pay_d"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "支払日は必須です。";
        }

        // 分割回数
        if ($_POST["form_division_num"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "分割回数は必須です。";
        }

        // エラーチェック結果集計
        $division_err_flg = (in_array(true, $ary_division_err_flg)) ? true : false;

        // 分割設定フラグ格納
        $division_set_flg = ($division_err_flg === false) ? true : false;

        // 分割設定内容をhiddenにSET
        if ($division_set_flg == true){
            $hdn_set["hdn_pay_m"]           = $_POST["form_pay_m"];
            $hdn_set["hdn_pay_d"]           = $_POST["form_pay_d"];
            $hdn_set["hdn_division_num"]    = $_POST["form_division_num"];
            $form->setConstants($hdn_set);
        }

        // hiddenにSETされた分割設定ボタン押下情報を削除
        $hdn_del["hdn_division_submit"] = "";
        $form->setConstants($hdn_del);

    }

    /****************************/
    // 分割支払登録ボタン押下時　前処理
    /****************************/
    if (isset($_POST["add_button"])){

        // （分割支払登録ボタンが表示されている＝分割設定内容に問題なしなので）分割設定フラグONを格納
        $division_set_flg = true;

        // （分割設定ボタン押下時に）hiddenにSETした分割設定内容を変数へ代入
        $hdn_pay_m           = $_POST["hdn_pay_m"];
        $hdn_pay_d           = $_POST["hdn_pay_d"];
        $hdn_division_num    = $_POST["hdn_division_num"];

        // さらにフォームへSET（表示用）
        $division_set["form_pay_m"]         = $_POST["hdn_pay_m"];
        $division_set["form_pay_d"]         = $_POST["hdn_pay_d"];
        $division_set["form_division_num"]  = $_POST["hdn_division_num"];
        $form->setConstants($division_set);

    }

    /****************************/
    // 分割設定処理
    /****************************/
    // 分割設定フラグが真の場合
    if ($division_set_flg === true){

/*
        // 分割設定前処理
        $pay_m          = isset($_POST["add_button"]) ? $hdn_pay_m : $_POST["form_pay_m"];                  // 支払日（月）
        $pay_m          = $pay_m + $_POST["hdn_payout_m"];
        $pay_d          = isset($_POST["add_button"]) ? $hdn_pay_d : $_POST["form_pay_d"];                  // 支払日（日）
        $division_num   = isset($_POST["add_button"]) ? $hdn_division_num : $_POST["form_division_num"];    // 分割回数
        $total_money    = str_replace(",", "", $total_money);   // 税込金額（カンマ抜き）
        $total_money    = str_replace(",", "", $_POST["form_buy_money"]);   // 税込金額（カンマ抜き）
        //$yy             = date("Y");
        //$mm             = date("m");
*/
        // 分割設定前処理
        $pay_m          = isset($_POST["add_button"]) ? $hdn_pay_m : $_POST["form_pay_m"];                  // 支払日（月）
        $pay_d          = isset($_POST["add_button"]) ? $hdn_pay_d : $_POST["form_pay_d"];                  // 支払日（日）
        $division_num   = isset($_POST["add_button"]) ? $hdn_division_num : $_POST["form_division_num"];    // 分割回数
        $total_money    = str_replace(",", "", $total_money);   // 税込金額（カンマ抜き）

        // 税込金額÷分割回数の商
        $division_quotient_price    = bcdiv($total_money, $division_num);
        // 税込金額÷分割回数の余り
        $division_franct_price      = bcmod($total_money, $division_num);
        // 2回目以降の支払金額
        $second_over_price          = str_pad(substr($division_quotient_price, 0, 3), strlen($division_quotient_price), 0);
        // 1回目の支払金額
        $first_price                = ($division_quotient_price - $second_over_price) * $division_num + $division_franct_price + $second_over_price;
        // 金額が分割回数で割り切れる場合
        if ($division_franct_price == "0"){
            $first_price = $second_over_price = $division_quotient_price;
        }

        // 分割回数分ループ
        for ($i=0; $i<$division_num; $i++){

            // 分割支払日作成
            $date_y     = date("Y", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $date_m     = date("m", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $mktime_m   = ($pay_d == "29") ? $mm + $pay_m + $i + 1 : $mm + $pay_m + $i;
            $mktime_d   = ($pay_d == "29") ? 0 : $pay_d;
            $date_d     = date("d", mktime(0, 0, 0, $mktime_m, $mktime_d, $yy));

            // 分割支払日を配列にSET
            $division_date[]    = "$date_y-$date_m-$date_d";

            // 分割支払金額を配列にSET
            $division_price[]   = ($i == 0) ? $first_price : $second_over_price;

            // 分割支払日フォーム作成
            $form_pay_date = null;
            $form_pay_date[] = &$form->createElement("static", "y", "", "");
            $form_pay_date[] = &$form->createElement("static", "m", "", "");
            $form_pay_date[] = &$form->createElement("static", "d", "", "");
            $form->addGroup($form_pay_date, "form_pay_date[$i]", "", "-");

            // 分割支払金額フォーム作成
            $form->addElement("text", "form_split_pay_amount[$i]", "", "class=\"money\" size=\"11\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

            // 分割支払金額をセット
            $set_data["form_split_pay_amount"][$i] = ($i == 0) ? $first_price : $second_over_price;

            // 分割支払日をセット
            $set_data["form_pay_date"][$i]["y"] = $date_y;
            $set_data["form_pay_date"][$i]["m"] = $date_m;
            $set_data["form_pay_date"][$i]["d"] = $date_d;

            // 分割支払金額、分割支払日データをSET（分割支払登録ボタン押下時はフォームデータを引き継ぐ）
            isset($_POST["add_button"]) ? $form->setDefaults($set_data) : $form->setConstants($set_data);

        }

    }

    /****************************/
    // 分割支払登録ボタン押下処理
    /****************************/
    if (isset($_POST["add_button"])){

        /****************************/
        // エラーチェック
        /****************************/
        /* 分割設定時に、仕入伝票が変更されていないか調べる */
        $sql = "SELECT * FROM t_buy_h WHERE buy_id = $buy_id AND change_day = '".$_POST["hdn_change_date"]."';";
        $res = Db_Query($db_con, $sql);
        if (pg_num_rows($res) == 0){
            // 正当なデータでない場合は仕入完了画面へ遷移
            header("Location:2-3-205.php?inst_err=true&buy_id=0&input_flg=true");
            exit;
        }

        /* 合計金額チェック */
        // 分割支払金額
        $sum_err_flg = ($total_money != array_sum($_POST["form_split_pay_amount"])) ? true : false;
        if ($sum_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "分割支払金額の合計が不正です。");
        }

        /* 半角数字チェック */
        // 分割支払金額
        for ($i=0; $i<$division_num; $i++){
            $ary_numeric_err_flg[] = (ereg("^[0-9]+$", $_POST["form_split_pay_amount"][$i])) ? false : true;
        }
        if (in_array(true, $ary_numeric_err_flg)){
            $form->setElementError("form_split_pay_amount[0]", "分割支払金額は半角数字のみです。");
        }
    
        /* 必須項目チェック */
        // 分割支払金額
        $required_err_flg = (in_array(null, $_POST["form_split_pay_amount"])) ? true : false;
        if ($required_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "分割支払金額は必須です。");
        }

        // エラーチェック結果集計
        $err_flg = ($sum_err_flg == true || in_array(true, $ary_numeric_err_flg) || $required_err_flg == true) ? true : false;

        $form->validate();

        /****************************/
        // DB処理
        /****************************/
        // エラーが無ければ
        if ($err_flg == false){

            $form->freeze();

            // トランザクション開始
            Db_Query($db_con, "BEGIN;");

            // 更新状況フラグの定義
            $db_err_flg = array();

            /* 仕入ヘッダテーブル更新処理(UPDATE) */
            $sql = "UPDATE t_buy_h SET total_split_num = $division_num WHERE buy_id = $buy_id;";
            $res  = Db_Query($db_con, $sql);

            // 更新失敗時ロールバック
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* 割賦支払テーブル更新処理(DELETE) */
            $sql = "DELETE from t_amortization WHERE buy_id = $buy_id;";
            $res  = Db_Query($db_con, $sql);

            // 更新失敗時ロールバック
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* 割賦支払テーブル更新処理(INSERT) */
            for ($i=0; $i<$division_num; $i++){
                $sql  = "INSERT INTO t_amortization (";
                $sql .= "    amortization_id,";
                $sql .= "    buy_id,";
                $sql .= "    pay_day,";
                $sql .= "    split_pay_amount";
                $sql .= ") VALUES (";
                $sql .= "    (SELECT COALESCE(MAX(amortization_id), 0)+1 FROM t_amortization),";
                $sql .= "    $buy_id,";
                $sql .= "    '$division_date[$i]',";
                $sql .= $_POST["form_split_pay_amount"][$i];
                $sql .= ");";
                $res  = Db_Query($db_con, $sql);

                // 更新失敗時ロールバック
                if ($res == false){
                    Db_Query($db_con, "ROLLBACK;");
                    $db_err_flg[] = true;
                    exit;
                }
            }

            // SQLエラーが無い場合
            if (!in_array(true, $db_err_flg)){

                Db_Query($db_con, "COMMIT;");

                // 分割支払登録フラグにTRUEをSET
                $division_comp_flg = true;

                // 画面表示用にナンバーフォーマットした分割支払金額をセット
                if (isset($_POST["add_button"])){
                    for ($i=0; $i<count($_POST["form_split_pay_amount"]); $i++){
                        $number_format_data["form_split_pay_amount"][$i] = number_format($_POST["form_split_pay_amount"][$i]);
                    }
                }
                $form->setConstants($number_format_data);
            }

        }

    }

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
// メニュー作成
/****************************/
$page_menu = Create_Menu_h("buy", "2");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

//  Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
    "html_header"           => "$html_header",
    "page_menu"             => "$page_menu",
    "page_header"           => "$page_header",
    "html_footer"           => "$html_footer",
    "division_set_flg"      => $division_set_flg,
    "division_err_flg"      => $division_err_flg,
    "ary_division_err_msg"  => $ary_division_err_msg,
    "division_comp_flg"     => $division_comp_flg,
    "division_flg"          => $division_flg,
    "freeze_flg"            => "$freeze_flg",
    "renew_msg"             => "$renew_msg"             
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
