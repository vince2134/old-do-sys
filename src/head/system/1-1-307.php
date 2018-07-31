<?php

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/12/14　      　　　　suzuki　    ページ処理修正
 *   2016/01/20                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応
 */

$page_title = "請求残高初期設定";
//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$staff_name = $_SESSION["staff_name"];

/****************************/
// フォームデフォルト値
/****************************/
$def_fdata["form_state"] = "1";
$def_fdata["form_type"] = "3";
$form->setDefaults($def_fdata);

/****************************/
// フォームパーツ定義
/****************************/
// 状態
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "取引中", "1");
$radio[] =& $form->createElement("radio", null, null, "解約・休止中", "2");
//$radio[] =& $form->createElement("radio", null, null, "解約", "3");
$radio[] =& $form->createElement("radio", null, null, "全て", "4");
$form->addGroup($radio, "form_state", "");

//請求残高
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "未登録", "1");
//$radio[] =& $form->createElement("radio", null, null, "０のみ", "1");
$radio[] =& $form->createElement("radio", null, null, "登録済み", "2");
//$radio[] =& $form->createElement("radio", null, null, "全て", "2");
$radio[] =& $form->createElement("radio", null, null, "全て", "3");
$form->addGroup($radio, "form_type", "");

// 表示件数
$hyoujikensuu_arr = array(
                        "10" => "10",
                        "50" => "50",
                        "100" => "100",
                        "all" => "全て", 
                    );
$form->addElement("select", "hyoujikensuu", "表示件数", $hyoujikensuu_arr);

// 表示ボタン
$form->addElement("button", "form_show_button", "表　示", "onClick=\"javascript:Button_Submit('show_button_flg','#','true', this)\"");

// 登録ボタン
$form->addElement("submit", "form_add_button", "登　録", "$disabled");

// hidden
$form->addElement("hidden", "show_button_flg");

//取引区分
$select_value6 = Select_Get($db_con,'trade_aord');
$form->addElement('select', 'form_trade', 'セレクトボックス', $select_value6,$g_form_option_select);

//締日
$sql1  = "SELECT";
$sql1 .= "   DISTINCT close_day";
$sql1 .= " FROM";
$sql1 .= "   t_client";
$sql1 .= " WHERE";
$sql1 .= "   client_div = '3'";
$sql1 .= "   AND";
$sql1 .= "   shop_id = $shop_id";
$sql1 .= ";";

$result = Db_Query($db_con, $sql1);
$num = pg_num_rows($result);
$select_value[null] = null;
for($i = 0; $i < $num; $i++){
    $client_close_day[] = pg_fetch_result($result, $i,0);
}

asort($client_close_day);
$client_close_day = array_values($client_close_day);

for($i = 0; $i < $num; $i++){
    if($client_close_day[$i] < 29 && $client_close_day[$i] != ''){
        $select_value[$client_close_day[$i]] = $client_close_day[$i]."日";
    }elseif($client_close_day[$i] != '' && $client_close_day[$i] >= 29){
        $select_value[$client_close_day[$i]] = "月末";
    }
}
$form->addElement("select", "form_close_day", "", $select_value);

//
$form_bill_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_bill_day[y]','form_bill_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_bill_day[y]','form_bill_day[m]','form_bill_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_bill_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_bill_day[m]','form_bill_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_bill_day[y]','form_bill_day[m]','form_bill_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_bill_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onFocus=\"onForm_today(this,this.form,'form_bill_day[y]','form_bill_day[m]','form_bill_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_bill_day,"form_bill_day","", " - ");

//エラー埋め込みフォーム
$form->addElement("text", "bill_amount_err");
$form->addElement("text", "bill_day_err");
$form->addElement("text", "bill_all_err");

//更新判別フラグ
$form->addElement("hidden","renew_flg","1");
/****************************/
//請求初期残高登録処理
/****************************/
if($_POST["form_add_button"] == "登　録"){
    $client_id      = $_POST["hdn_client_id"];         //得意先ID
    $claim_div      = $_POST["hdn_claim_div"];         //請求先区分
    $bill_amount    = $_POST["form_bill_amount"];      //請求初期残高
    $bill_day       = $_POST["form_bill_day"];         //請求日
    $input_flg      = $_POST["hdn_input_flg"];         //入力可能フラグ
    $claim_id       = $_POST["hdn_claim_id"];          //請求先ID

    //日付チェック
    //半角チェック
    if(!ereg("^[0-9]+$", $bill_day["y"]) || !ereg("^[0-9]+$", $bill_day["m"]) || !ereg("^[0-9]+$", $bill_day["d"])){
        $form->setElementError("bill_day_err","請求締日の日付は妥当ではありません。");
        $err_flg = true;
    }else{
        //日付妥当性チェック
        if(!checkdate($bill_day["m"],$bill_day["d"],$bill_day["y"])){
            $form->setElementError("bill_day_err","請求締日の日付は妥当ではありません。");
            $err_flg = true;
        //未来の日付はNG
        }elseif(date('Ymd') < date('Ymd', mktime(0,0,0,$bill_day["m"], $bill_day["d"], $bill_day["y"]))){
            $form->setElementError("bill_day_err","請求締日の日付は妥当ではありません。");
            $err_flg = true;
        //システム開始日以前OR月次更新日以前はNG
        }else{
            $err_mess = Sys_Start_Date_Chk($bill_day["y"], $bill_day["m"], $bill_day["d"], "請求締日");
            if($err_mess != null){
                $form->setElementError("form_close_day",$err_mess);
                $err_flg = true;
            }else{
                $sql = "SELECT MAX(close_day) FROM t_sys_renew WHERE renew_div = '2' AND shop_id = $shop_id;";
                $result = Db_Query($db_con, $sql);
                $close_day_last = (pg_fetch_result($result, 0, 0) != null) ? pg_fetch_result($result, 0, 0) : START_DAY;

                if($bill_day["y"]."-".$bill_day["m"]."-".$bill_day["d"] <= $close_day_last){
                    $form->setElementError("form_close_day","請求締日 は、前回月次更新年月日 より先の日付を入力してください。");
                    $err_flg = true;
                }
            }
        }
    }

    //表示件数分ループ
    for($i = 0; $i < count($client_id); $i++){

/*
        //入力可能フラグがｔで金額または、日付に入力がある場合に処理開始    
        if(($bill_amount[$i] != null 
            || 
        ($bill_day[$i]["y"] != null || $bill_day[$i]["m"] != null || $bill_day[$i]["d"] != null))
            && 
        $input_flg[$i] == 't'){

            //エラーチェック
            //入力チェック
            if($bill_amount[$i] == null 
                || 
            $bill_day[$i]["y"] == null
                || 
            $bill_day[$i]["m"] == null
                || 
            $bill_day[$i]["d"] == null
            ){ 
                $form->setElementError("bill_all_err","初期請求残高設定に金額と日付は必須入力です。");
                $err_flg = true;
            }else{
                $input_data_flg = true;
            }

            //初期残高半角チェック
            if(!ereg("^[-]?[0-9]+$", $bill_amount[$i])){
                $form->setElementError("bill_amount_err","売掛初期残高は数値のみ入力可能です。");
                $err_flg = true;
            } 

            //登録対象のでーたで纏める
            $add_client_id[]    = $client_id[$i];
            $add_claim_id[]     = $claim_id[$i];
            $add_claim_div[]    = $claim_div[$i];
            $add_bill_amount[]  = $bill_amount[$i];
            $add_bill_day[]     = $bill_day[$i];
            $add_claim_id[]     = $claim_id[$i];
        }
        $set_data["input_flg"][$i] = "";

*/
        if($bill_amount[$i] != null && $input_flg[$i] == 't'){
            //初期残高半角チェック
            if(!ereg("^[-]?[0-9]+$", $bill_amount[$i])){
                $form->setElementError("bill_amount_err","売掛初期残高は数値のみ入力可能です。");
                $err_flg = true;
            }

            //登録対象のでーたで纏める
            $add_client_id[]    = $client_id[$i];
            $add_claim_id[]     = $claim_id[$i];
            $add_claim_div[]    = $claim_div[$i];
            $add_bill_amount[]  = $bill_amount[$i];
            $add_claim_id[]     = $claim_id[$i];    
        }
    }
    /********************************/
    //値検証
    /********************************/
    if($form->validate() && $err_flg != true && count($add_client_id)> 0){

        /**********************************/
        //入力されたデータ件数分登録
        /**********************************/
        Db_Query($db_con, "BEGIN;");

        for($i = 0; $i < count($add_client_id); $i++){

            $message = "登録しました。";

            //二重登録をチェック
            $sql  = "SELECT";
            $sql .= "   COUNT(t_bill_d.bill_d_id) \n";
            $sql .= "FROM\n";
            $sql .= "   t_bill\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_bill_d\n";
            $sql .= "   ON t_bill.bill_id = t_bill_d.bill_id\n";
            $sql .= "WHERE\n";
            $sql .= "   t_bill.first_set_flg = 't'\n";
            $sql .= "   AND\n";
            $sql .= "   t_bill.shop_id = $shop_id\n";
            $sql .= "   AND\n";
            $sql .= "   t_bill_d.client_id = $add_client_id[$i]\n";

            $result = Db_Query($db_con, $sql);
            $add_count = pg_fetch_result($result,0,0);
            if($add_count > 0){
                $message = "";
                continue;
            }

            //請求書番号抽出    
            $sql  = "SELECT";
            $sql .= "   MAX(bill_no)\n";
            $sql .= "FROM";
            $sql .= "   t_bill\n";
            $sql .= "WHERE\n";
            $sql .= "   first_set_flg = 't'\n";
            $sql .= "   AND\n";
            $sql .= "   shop_id = $shop_id\n";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            $max_no = pg_fetch_result($result,0,0)+1;
            //抽出した連番を8桁になるように左側を0埋めする
            $claim_sheet_no = str_pad($max_no, 8, 0, STR_PAD_LEFT);

            $sql  = "INSERT INTO t_bill(";
            $sql .= "   bill_id,";              //請求ID
            $sql .= "   bill_no,";              //請求書番号
            $sql .= "   fix_flg,";              //確定フラグ
            $sql .= "   last_update_flg,";      //更新フラグ
            $sql .= "   last_update_day,";      //更新実施日
            $sql .= "   create_staff_name,";    //請求でデータ作成日
            $sql .= "   fix_day,";              //確定日
            $sql .= "   shop_id,";              //取引先ID
            $sql .= "   first_set_flg";         //残高設定フラグ
            $sql .= ")VALUES(";
            $sql .= "   (SELECT COALESCE(MAX(bill_id), 0)+1 FROM t_bill),";
            $sql .= "   '$claim_sheet_no',";
            $sql .= "   't',";
            $sql .= "   't',";
            $sql .= "   NOW(),";
            $sql .= "   '$staff_name',";
            $sql .= "   NOW(),";
            $sql .= "   $shop_id,";
            $sql .= "   't'";
            $sql .= ");";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                $err_message = pg_last_error();
                $err_format = "t_bill_bill_no_key";
                Db_Query($db_con, "ROLLBACK");

                //請求NOが重複した場合
                if(strstr($err_message,$err_format) !== false){
                    $error = "同時に請求残高を行ったため、登録できませんでした。再度設定してください。";
                    $duplicate_err = true;
                    break;
                }else{
                    exit;
                }
            }

            //請求データに登録
            $sql  = "INSERT INTO t_bill_d(";
            $sql .= "   bill_d_id,";
            $sql .= "   bill_id,";
            $sql .= "   bill_close_day_this,";
            $sql .= "   client_id,";
            $sql .= "   claim_div,";
            $sql .= "   bill_amount_this";
            $sql .= ")VALUES(";
            $sql .= "   (SELECT COALESCE(MAX(bill_d_id),0)+1 FROM t_bill_d),";
            $sql .= "   (SELECT";
            $sql .= "       bill_id";
            $sql .= "   FROM";
            $sql .= "       t_bill";
            $sql .= "   WHERE";
            $sql .= "       shop_id = $shop_id";
            $sql .= "       AND";
            $sql .= "       bill_no = '$claim_sheet_no'";
            $sql .= "       AND";   
            $sql .= "       first_set_flg = 't'";
            $sql .= "   ),";
            //$sql .= "   '".$add_bill_day[$i]["y"]."-".$add_bill_day[$i]["m"]."-".$add_bill_day[$i]["d"]."',";
            $sql .= "   '".$bill_day["y"]."-".$bill_day["m"]."-".$bill_day["d"]."',";
            $sql .= "   $add_client_id[$i],";
            $sql .= "   '$add_claim_div[$i]',";
            $sql .= "   $add_bill_amount[$i]";
            $sql .= ");";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
        Db_Query($db_con, "COMMIT;");
    }
}

/****************************/
//一覧データ作成
/****************************/
//if($_POST["show_button_flg"] == true || $_POST["form_add_button"] == "登　録"){
if($_POST["renew_flg"] == 1){

    $state       = $_POST["form_state"];        //状態
    $claim_type  = $_POST["form_type"];         //請求残高
    $kensu       = $_POST["hyoujikensuu"];      //表示件数
    $f_page1     = $_POST["f_page1"];           //ページ数
    $close_day   = $_POST["form_close_day"];    //締日
    $trade       = $_POST["form_trade"];        //取引区分

    //状態の「全て」以外が指定された場合
    if($state != '4'){
        $where_sql .= "     AND\n";
        $where_sql .= "     t_client.state = $state\n";
    }

    //請求残高の「0のみ」が指定された場合
    if($claim_type == '1'){
        $where_sql .= "     AND\n";
        $where_sql .= "     input_data.client_id IS NOT NULL\n";
    }elseif($claim_type == "2"){
        $where_sql .= "     AND\n";
        $where_sql .= "     input_data.client_id IS NULL\n";
    }

    //締日を選択した場合
    if($close_day != null){
        $where_sql .= " AND\n";
        $where_sql .= " t_client.close_day = $close_day\n";
    }
    
    //取引区分を選択した場合
    if($trade != null){
        $where_sql .= " AND\n";
        $where_sql .= " t_client.trade_id = $trade\n";
    }

    //表示件数を取得    
    $sql_column  = "SELECT\n";
    $sql_column .= "   t_client.client_id,\n";
    $sql_column .= "   t_client.client_cd1||'-'||t_client.client_cd2,\n";
    $sql_column .= "   t_client.client_name,\n";
    $sql_column .= "   t_client.client_name2,\n";
    $sql_column .= "   t_claim.claim_id,\n";
    $sql_column .= "   claim_data.claim_cd1||'-'||claim_data.claim_cd2,\n";
    $sql_column .= "   claim_data.claim_name1,\n";
    $sql_column .= "   claim_data.claim_name2,\n";
    $sql_column .= "   t_claim.claim_div,\n";
    $sql_column .= "   COALESCE(bill_data.bill_amount_this,0) AS bill_amount_this, \n";
    $sql_column .= "   bill_data.bill_close_day_this,\n";
    $sql_column .= "   input_data.input_flg \n";

    $sql  = "FROM\n";
    $sql .= "   t_client\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_claim\n";
    $sql .= "   ON t_client.client_id = t_claim.client_id\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   (SELECT DISTINCT\n";
    $sql .= "       t_claim.claim_id,\n";
    $sql .= "       t_client.client_cd1 AS claim_cd1,\n";
    $sql .= "       t_client.client_cd2 AS claim_cd2,\n";
    $sql .= "       t_client.client_name AS claim_name1,\n";
    $sql .= "       t_client.client_name2 AS claim_name2\n";
    $sql .= "   FROM\n";
    $sql .= "       t_claim\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_client\n";
    $sql .= "       ON t_claim.claim_id = t_client.client_id\n";
    $sql .= "   ) AS claim_data\n";
    $sql .= "   ON t_claim.claim_id = claim_data.claim_id\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_bill_d.client_id,\n";
    $sql .= "       t_bill_d.claim_div,\n";
    $sql .= "       t_bill_d.bill_amount_this,\n";
    $sql .= "       t_bill_d.bill_close_day_this\n";
    $sql .= "   FROM\n";
    $sql .= "       t_bill\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_bill_d\n";
    $sql .= "       ON t_bill.bill_id = t_bill_d.bill_id\n";
    $sql .= "   WHERE\n";
//    $sql .= "       t_bill.bill_no IS NULL\n";
    $sql .= "       t_bill.first_set_flg = 't'";
    $sql .= "   ) AS bill_data\n";
    $sql .= "   ON t_client.client_id = bill_data.client_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_claim.claim_div = bill_data.claim_div\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_client.client_id,\n";
    $sql .= "       t_claim.claim_div,\n";
    $sql .= "       't' AS input_flg\n";
    $sql .= "   FROM\n";
    $sql .= "       t_client\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_claim \n";
    $sql .= "       ON t_client.client_id = t_claim.client_id\n";
    $sql .= "           LEFT JOIN\n";
    $sql .= "       t_sale_h\n";
    $sql .= "       ON t_client.client_id = t_sale_h.client_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_claim.claim_div = t_sale_h.claim_div\n";
    $sql .= "           LEFT JOIN\n";
    $sql .= "       t_payin_h\n";
    $sql .= "       ON t_client.client_id = t_payin_h.client_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_claim.claim_div = t_payin_h.claim_div\n";
    $sql .= "           LEFT JOIN\n";
    $sql .= "       t_bill_d\n";
    $sql .= "       ON t_client.client_id = t_bill_d.client_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_claim.claim_div = t_bill_d.claim_div\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_sale_h.client_id IS NULL\n";
    $sql .= "       AND \n";
    $sql .= "       t_payin_h.client_id IS NULL\n";
    $sql .= "       AND\n";
    $sql .= "       t_bill_d.client_id IS NULL\n";
    $sql .= "       AND\n";
    $sql .= "       t_client.client_div = '3'\n";
    $sql .= "       AND\n";
    $sql .= "       t_client.shop_id = $shop_id\n";
    $sql .= "   ) AS input_data\n";
    $sql .= "   ON t_client.client_id = input_data.client_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_claim.claim_div = input_data.claim_div \n";
    $sql .= "WHERE\n";
    $sql .= "   t_client.client_div = '3'\n";
    $sql .= "   AND\n";
    $sql .= "   t_client.shop_id = $shop_id\n";
    $sql .= "   $where_sql";

    //全件数を抽出
    $count_sql   = "SELECT COUNT(t_client.client_id) ";
    $result      = Db_Query($db_con, $count_sql.$sql.";");
    $total_count = pg_fetch_result($result, 0,0);

    //1ページの表示件数が全件の場合
    if ($kensu == "all") {
        $range = $total_count;
    } else {
        $range = $kensu;
    }

    //現在のページ数をチェックする
    $page_info = Check_Page($total_count, $range, $f_page1);
    $page      = $page_info[0]; //現在のページ数
    $page_snum = $page_info[1]; //表示開始件数
    $page_enum = $page_info[2]; //表示終了件数

	//ページプルダウン表示判定
	if($page == 1){
		//ページ数が１ならページプルダウンを非表示
		$c_page = NULL;
	}else{
		//ページ数分プルダウンに表示
		$c_page = $page;
	}

    //ページ作成
    $html_page  = Html_Page($total_count,$c_page,1,$range);
    $html_page2 = Html_Page($total_count,$c_page,2,$range);

    //表示データ作成
    $offset = $page_snum-1; //表示しない件数
    $limit  = ($page_enum - $page_snum) +1;    //一ページあたりの件数

    $sql_another = "ORDER BY t_client.client_cd1, t_client.client_cd2, t_claim.claim_div\n";
    
    $sql .= "   $where_sql";
    if ($kensu != "all") {
        $sql_another .= "LIMIT $limit OFFSET $offset ";
    }

    $result = Db_Query($db_con, $sql_column.$sql.$sql_another.";");
    $page_data = Get_Data($result);
    $data = pg_fetch_all($result);
}

/****************************/
//件数分フォーム作成
/****************************/
for($i = 0; $i < count($page_data); $i++){

    //得意先ID
    $form->addElement("hidden", "hdn_client_id[$i]");
    $set_data[hdn_client_id][$i] = "";
    $set_data[hdn_client_id][$i] = $data[$i][client_id];

    //請求先区分
    $form->addElement("hidden", "hdn_claim_div[$i]");
    $set_data[hdn_claim_div][$i] = "";
    $set_data[hdn_claim_div][$i] = $data[$i][claim_div];

    //入力可能フラグがｔの場合
    if($data[$i][input_flg] == 't'){
        $form->addElement(
            "text", "form_bill_amount[$i]", "", "class=\"money\" size=\"11\" maxLength=\"9\"
            $g_form_option style=\"text-align: right; $g_form_style\""
        );
/*
        $form_bill_day[$i][] = $form->createElement(
            "text","y","",
            "size=\"4\" maxLength=\"4\" 
            style=\"$g_form_style\"
            onkeyup=\"changeText(this.form,'form_bill_day[$i][y]','form_bill_day[$i][m]',4)\" 
            onFocus=\"onForm_today(this,this.form,'form_bill_day[$i][y]','form_bill_day[$i][m]','form_bill_day[$i][d]')\"
            onBlur=\"blurForm(this)\""
        );
        $form_bill_day[$i][] = $form->createElement(
            "text","m","","size=\"2\" maxLength=\"2\" 
            style=\"$g_form_style\"
            onkeyup=\"changeText(this.form,'form_bill_day[$i][m]','form_bill_day[$i][d]',2)\" 
            onFocus=\"onForm_today(this,this.form,'form_bill_day[$i][y]','form_bill_day[$i][m]','form_bill_day[$i][d]')\"
            onBlur=\"blurForm(this)\""
        );
        $form_bill_day[$i][] = $form->createElement(
            "text","d","",
            "size=\"2\" maxLength=\"2\" 
            style=\"$g_form_style\"
            onFocus=\"onForm_today(this,this.form,'form_bill_day[$i][y]','form_bill_day[$i][m]','form_bill_day[$i][d]')\"
            onBlur=\"blurForm(this)\""
        );
        $form->addGroup( $form_bill_day[$i],"form_bill_day[$i]","", " - ");

        $set_data[form_bill_day][$i][y]    = "";
        $set_data[form_bill_day][$i][m]    = "";
        $set_data[form_bill_day][$i][d]    = "";
*/
        $set_data[form_bill_amount][$i] = "";
        //入力可能フラグ
        $form->addElement("hidden", "hdn_input_flg[$i]");
        $set_data[hdn_input_flg][$i] = "";
        $set_data[hdn_input_flg][$i] = $data[$i][input_flg];
    }else{
        $form->addElement(
            "text", "form_bill_amount[$i]", "","size =\"13\"
            style=\"text-align : right;
            border : #ffffff 1px solid;
            background-color: #ffffff;\"
            readonly"
        );
/*
        $form_bill_day[$i][] = $form->createElement(
            "text","y","",
            "size=\"4\" maxLength=\"4\" 
            style=\"text-align : right;
            border : #ffffff 1px solid;
            background-color: #ffffff;\"
            readonly"
        );
        $form_bill_day[$i][] = $form->createElement(
            "text","m","","size=\"2\" maxLength=\"2\" 
            style=\"text-align : right;
            border : #ffffff 1px solid;
            background-color: #ffffff;\"
            readonly"
        );
        $form_bill_day[$i][] = $form->createElement(
            "text","d","",
            "size=\"2\" maxLength=\"2\" 
            style=\"text-align : right;
            border : #ffffff 1px solid;
            background-color: #ffffff;\"
            readonly"
        );
        $form->addGroup($form_bill_day[$i],"form_bill_day[$i]","", " - ");
*/
        $set_data[form_bill_amount][$i] = "";
        $set_data[form_bill_amount][$i] = number_format($data[$i][bill_amount_this]);
/*
        $set_date = explode("-",$data[$i][bill_close_day_this]);
        $set_data[form_bill_day][$i][y]    = ($set_date[0] != null)? $set_date[0] : "";
        $set_data[form_bill_day][$i][m]    = ($set_date[1] != null)? $set_date[1] : "";
        $set_data[form_bill_day][$i][d]    = ($set_date[2] != null)? $set_date[2] : "";
*/
        //入力可能フラグ
        $form->addElement("hidden", "hdn_input_flg[$i]");
        $set_data[hdn_input_flg][$i] = "";
        $set_data[hdn_input_flg][$i] = 'f';

        $total_amount = $total_amount + $data[$i][bill_amount_this];
    }
    if($page_data[$i][0] == $page_data[$i-1][0]){
        $page_data[$i][0] = "";
        $page_data[$i][1] = "";
        $page_data[$i][2] = "";
        $page_data[$i][3] = "";
    }
}

//抽出した値をフォームにセット
$form->setConstants($set_data);

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
$page_menu = Create_Menu_f('system','3');

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$smarty->register_modifier("number_format","number_format");
$smarty->register_modifier("stripslashes","stripslashes");
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
    'auth_r_msg'    => "$auth_r_msg",
    'total_amount'  => "$total_amount",
    'message'       => "$message",
    'match_count'   => "$match_count",
    'page_snum'     => "$page_snum",
));

$smarty->assign("page_data", $page_data);


//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
