<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/09      03-040      kajioka-h   取消リンクの表示条件修正
 *  2006/11/11      03-042      kajioka-h   保留削除したものは表示しないように修正
 *  2006/11/13      03-036      kajioka-h   承認時、既に承認されていないかチェック処理追加
 *                  03-037      kajioka-h   取消時、既に取消されていないかチェック処理追加
 *                  03-038      kajioka-h   承認時、既に取消されていないかチェック処理追加
 *                  03-039      kajioka-h   取消時、既に日次更新されていないかチェック処理追加
 *  2007/01/06      xx-xxx      kajioka-h   代行伝票（得意先宛）に代行先の情報を残す処理追加
 *  2007/02/21      xx-xxx      watanabe-k  基本出荷倉庫を拠点倉庫に変更
 *
 */

$page_title = "巡回報告一覧（委託先用）";

//環境設定ファイル
require_once("ENV_local.php");

//確定処理関数定義
require_once(PATH ."function/trade_fc.fnc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
//$auth       = Auth_Check($db_con);

// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
// 検索セッション破棄
/****************************/
// 自画面のモジュール番号取得
$page_name  = substr($_SERVER[PHP_SELF], strrpos($_SERVER[PHP_SELF], "/")+1);
$module_no  = substr($page_name, 0, strpos($page_name, "."));

// 自画面で生成したセッションがあり、POSTがない場合
if ($_SESSION[$module_no] != null && $_POST == null){
    // 自画面で生成した検索セッションを破棄
    unset($_SESSION[$module_no]);
}

$_SESSION["referer"]["f"]["sale"] = $module_no;

/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];    //ログインID
$staff_id   = $_SESSION["staff_id"];     //ログイン者ID
$staff_name = addslashes($_SESSION["staff_name"]);   //ログイン者名
$group_kind = $_SESSION["group_kind"];   //顧客区分


/****************************/
// 表示件数設定
/****************************/
// 表示ボタン押下時はPOSTされたフォーム値
if ($_POST["form_display"] != null){
    $range = $_POST["form_range_select"];
// 表示ボタン以外のPOST時はhiddenの値
}elseif ($_POST != null && $_POST["form_display"] == null){
    $range = $_POST["hdn_range_select"];
// POSTがない場合はデフォルトの100件
}else{
    $range = 100;
}


/****************************/
// 正当性チェック
/****************************/
//FC判定
if ($group_kind != "2"){
    //FC以外は、TOPに遷移
    header("Location: ".FC_DIR."top.php");
    exit;
}


/****************************/
// フォームデフォルト値設定
/****************************/
$def_fdata = array(
    "form_range_select" => "100", 
);
$form->setDefaults($def_fdata);


/****************************/
// フォームパーツ定義
/****************************/
// 伝票番号
$form->addElement("text", "form_slip_num", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 表示件数
$ary_range_list = array("10" => "10", "50" => "50", "100" => "100", null => "全て");
$form->addElement("select", "form_range_select", "", $ary_range_list, $g_form_option_select);

// 得意先コード
$text = "";
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\" $g_form_option"
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text, "form_client", "");

// 得意先名
$form->addElement("text", "form_client_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// 代行先コード
$text = "";
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_act[cd1]','form_act[cd2]',6)\"
    $g_form_option"
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option"
);
$form->addGroup($text, "form_act", "");

//代行先名
$form->addElement("text", "form_act_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//巡回日(開始)
$text = ""; 
$text[] =& $form->createElement("text", "sy", "",
    "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[sy]', 'form_aord_day[sm]',4)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[sy]','form_aord_day[sm]','form_aord_day[sd]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "sm", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[sm]', 'form_aord_day[sd]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[sy]','form_aord_day[sm]','form_aord_day[sd]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "sd", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[sd]','form_aord_day[ey]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[sy]','form_aord_day[sm]','form_aord_day[sd]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","〜");
$text[] =& $form->createElement("text", "ey", "",
    "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[ey]', 'form_aord_day[em]',4)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[ey]','form_aord_day[em]','form_aord_day[ed]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "em", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[em]', 'form_aord_day[ed]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[ey]','form_aord_day[em]','form_aord_day[ed]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "ed", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[ey]','form_aord_day[em]','form_aord_day[ed]')\"
     onBlur=\"blurForm(this)\""
);
$form->addGroup($text, "form_aord_day", "");

// 表示ボタン
$form->addElement("submit", "form_display", "表　示");

//クリア
$form->addElement("button", "form_clear", "クリア", "onClick=\"javascript: location.href('".$_SERVER[PHP_SELF]."');\"");

//承認ボタン
$form->addElement("button", "form_confirm", "承　認", 
    "onClick=\"javascript:Button_Submit('confirm_flg','".FC_DIR."system/2-1-237.php',true)\" $disabled"
);

//入力値記憶用hidden
$form->addElement("hidden","hdn_aord_day_sy");              //巡回日（開始）年
$form->addElement("hidden","hdn_aord_day_sm");              //巡回日（開始）月
$form->addElement("hidden","hdn_aord_day_sd");              //巡回日（開始）日
$form->addElement("hidden","hdn_aord_day_ey");              //巡回日（終了）年
$form->addElement("hidden","hdn_aord_day_em");              //巡回日（終了）月
$form->addElement("hidden","hdn_aord_day_ed");              //巡回日（終了）日
$form->addElement("hidden","hdn_slip_num");                 //伝票番号
$form->addElement("hidden","hdn_range_select");             //表示件数
$form->addElement("hidden","hdn_client_cd1");               //得意先ＣＤ１
$form->addElement("hidden","hdn_client_cd2");               //得意先ＣＤ２
$form->addElement("hidden","hdn_client_name");              //得意先名
$form->addElement("hidden","hdn_act_cd1");                  //代行先ＣＤ１
$form->addElement("hidden","hdn_act_cd2");                  //代行先ＣＤ２
$form->addElement("hidden","hdn_act_name");                 //代行先名
$form->addElement("hidden","confirm_flg");                  //承認フラグ
$form->addElement("hidden","hdn_cancel_id");                //取消売上ID

/****************************/
// 表示ページ数をSESSIONにセット
/****************************/
// ページ番号POSTがある場合
if ($_POST["f_page1"] != null){
    // 現在の表示ページ数をSESSIONにセット
    $_SESSION[$module_no]["f_page1"] = $_POST["f_page1"];
    $_SESSION[$module_no]["f_page2"] = $_POST["f_page2"];
}


/***************************/
//取消リンクが押された場合
/***************************/
if($_POST["hdn_cancel_id"] == true){

    $cancel_id = $_POST["hdn_cancel_id"];  //受注ID

    Db_Query($db_con, "BEGIN");

    $sql = "SELECT contract_div, trust_confirm_flg FROM t_aorder_h WHERE aord_id = $cancel_id;";
    $result = Db_Query($db_con, $sql);
    $contract_div       = pg_fetch_result($result, 0, "contract_div");
    $trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg");

    //オンライン代行ですでに取消されている（オフラインの場合は後勝ちのため判定しない）
    if($contract_div == "2" && $trust_confirm_flg == "f"){
        $cancel_err = "取消されているため、取消できません。";
        Db_Query($db_con, "ROLLBACK;");

    //
    }else{

        //売上レコードがあるかチェック
        $sql = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $cancel_id;";
        $result = Db_Query($db_con, $sql);
        if(pg_num_rows($result) != 0){
            $renew_flg = pg_fetch_result($result, 0, "renew_flg");
            //日次更新されている
            if($renew_flg == "t"){
                $renew_err = "日次更新されているため、取消できません。";
                Db_Query($db_con, "ROLLBACK;");
            }
        }

        //日次更新されていない or 売上レコードがない（オンラインで未承認）
        if($renew_err == null){

            //売上データ全て削除SQL
            $sql  = "DELETE FROM t_sale_h ";
            $sql .= "WHERE";
            $sql .= "   sale_id = $cancel_id;";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            //受注ヘッダの確定フラグをfalse
            $sql  = "UPDATE t_aorder_h SET";
            $sql .= "   confirm_flg = 'f',";         //確定フラグ
            $sql .= "   trust_confirm_flg = 'f',";   //確定フラグ(受託)
            $sql .= "   cancel_flg = 't',";          //取消フラグ
            $sql .= "   ps_stat = '1' ";             //処理状況
            $sql .= "WHERE";
            $sql .= "   aord_id = $cancel_id;";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            Db_Query($db_con, "COMMIT");

            $post_flg       = true;                  //POSTフラグ

            $con_data["hdn_cancel_id"] = "";         //初期化
            $form->setConstants($con_data);
        }
    }
}

/****************************/
// 承認ボタン押下処理
/****************************/
if($_POST["confirm_flg"] == true){

    $con_data["confirm_flg"] = false;   // 承認ボタン初期化

    $output_id_array = $_POST["output_id_array"];  //受注ID配列
    $check_num_array = $_POST["form_slip_check"];  //伝票チェック

    //伝票にチェックがある場合に行う
    if($check_num_array != NULL){
        $aord_array = NULL;    //伝票出力受注ID配列
        while($check_num = each($check_num_array)){
            //この添字の受注IDを使用する
            $check = $check_num[0];

            //未承認行のみ配列に追加
            if($check_num[1] != NULL){
                $aord_array[] = $output_id_array[$check];
            }
        }
    }

    //チェック判定
    if($aord_array != NULL){

        Db_Query($db_con, "BEGIN");

        //チェックした受注ID分伝票表示
        for($s=0;$s<count($aord_array);$s++){

            //エラー時に表示する伝票番号取得
            $sql  = "SELECT ord_no FROM t_aorder_h WHERE aord_id = ".$aord_array[$s].";";
            $result = Db_Query($db_con, $sql);
            $ord_no = pg_fetch_result($result,0,"ord_no"); //伝票番号

            //既に承認されていないかチェック
            $sql = "SELECT renew_flg FROM t_sale_h WHERE sale_id = ".$aord_array[$s].";";
            $result = Db_Query($db_con, $sql);
            if(pg_num_rows($result) != 0){
                $confirm_err = "以下の伝票は、承認されているため承認できません。";
                $confirm_err_no[$ord_no] = $ord_no;
            }

            //まだ承認されていない場合のみ以降の処理実行
            if($confirm_err_no[$ord_no] == NULL){
                $sql  = "SELECT \n";
                $sql .= "    contract_div, \n";
                $sql .= "    confirm_flg, \n";
                $sql .= "    trust_confirm_flg, \n";
                $sql .= "    reserve_del_flg, \n";
                $sql .= "    act_id \n";
                $sql .= "FROM \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "WHERE \n";
                $sql .= "    aord_id = ".$aord_array[$s]." \n";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                $contract_div       = pg_fetch_result($result, 0, "contract_div");      //契約区分
                $confirm_flg        = pg_fetch_result($result, 0, "confirm_flg");       //確定（承認）フラグ
                $trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg"); //受託先確定（報告）フラグ
                $reserve_del_flg    = pg_fetch_result($result, 0, "reserve_del_flg");   //保留削除フラグ
                $act_id             = pg_fetch_result($result, 0, "act_id");            //代行者ID

                if($reserve_del_flg == "t"){
                    $reserve_del_err = "以下の伝票は、保留削除されているため承認できません。";
                    $reserve_del_err_no[$ord_no] = $ord_no;
                }

                //オンライン代行で取消されているかチェック
                if($contract_div == "2" && $trust_confirm_flg == "f"){
                    $cancel_err = "以下の伝票は、取消されているため承認できません";
                    $cancel_err_no[$ord_no] = $ord_no;
                }


                $buy_amount = NULL;   //紹介料配列

                /****************************/
                //受注ヘッダーテーブル更新
                /****************************/
                $sql  = "UPDATE t_aorder_h SET";
                $sql .= "   confirm_flg = 't',";         //確定フラグ
                $sql .= "   ps_stat = '3' ";             //処理状況
                $sql .= "WHERE";
                $sql .= "   aord_id = ".$aord_array[$s];
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                /****************************/
                //受注ヘッダーを基に、売上ヘッダー作成
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    ord_no,"; //0
                $sql .= "    ord_time,"; //1
                $sql .= "    arrival_day,"; //2
                $sql .= "    client_id,"; //3
                $sql .= "    trade_id,"; //4
                $sql .= "    ware_id,"; //5
                $sql .= "    note,"; //6
                $sql .= "    cost_amount,"; //7
                $sql .= "    net_amount,"; //8
                $sql .= "    tax_amount,"; //9
                $sql .= "    intro_ac_name,"; //10
                $sql .= "    slip_flg,"; //11
                $sql .= "    shop_id, "; //12
                $sql .= "    intro_account_id,"; //13
                $sql .= "    intro_amount,"; //14
                $sql .= "    contract_div,"; //15
                $sql .= "    client_cd1,"; //16                  
                $sql .= "    client_cd2,"; //17                
                $sql .= "    client_cname,"; //18              
                $sql .= "    client_name,"; //19               
                $sql .= "    client_name2,"; //20              
                $sql .= "    ware_name, ";    //21             
                $sql .= "    reason_cor,";    //22      
                $sql .= "    route,";         //23       
                $sql .= "    intro_ac_price,"; //24     
                $sql .= "    intro_ac_rate,";  //25          
                $sql .= "    claim_id,";   //26         
                $sql .= "    claim_div,  "; //27
                $sql .= "    round_form,";  //28
                $sql .= "    slip_out ";    //29     
                $sql .= "FROM ";
                $sql .= "    t_aorder_h ";
                $sql .= "WHERE ";
                $sql .= "   aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list = Get_Data($result,3);

                //配送日を取得
                $array_date = explode("-", $data_list[0][1]);
                //配送日が前回月次更新より先かチェック
                if(Check_Monthly_Renew($db_con, $data_list[0][3], "1", $array_date[0], $array_date[1], $array_date[2]) == false){
                    $deli_day_renew_err = "以下の伝票は、配送日が前回の月次更新以前の伝票です。";
                    $deli_day_renew_err_no[$ord_no] = $ord_no;
                }
                //請求日を取得
                $array_date = explode("-", $data_list[0][2]);
                //請求日が前回月次更新より先かチェック
                if(Check_Monthly_Renew($db_con, $data_list[0][3], "1", $array_date[0], $array_date[1], $array_date[2]) == false){
                    $claim_day_renew_err = "以下の伝票は、請求日が前回の月次更新以前の伝票です。";
                    $claim_day_renew_err_no[$ord_no] = $ord_no;
                }
                //請求日が前回より先かチェック
                if(Check_Bill_Close_Day($db_con, $data_list[0][3], $array_date[0], $array_date[1], $array_date[2]) == false){
                    $claim_day_bill_err  = "以下の伝票は、請求日に請求書作成済の日付が入力されています。<br>";
                    $claim_day_bill_err .= "　請求日を変更するか、請求書を削除して下さい。";
                    $claim_day_bill_err_no[$ord_no] = $ord_no;
                }

                $sql  = "INSERT INTO t_sale_h(";
                $sql .= "    sale_id,";         //売上ID
                $sql .= "    sale_no,";         //売上番号
                $sql .= "    aord_id,";         //受注ID
                $sql .= "    sale_day,";        //売上日
                $sql .= "    claim_day,";       //請求日
                $sql .= "    client_id,";       //得意先ID
                $sql .= "    trade_id,";        //取引区分
                $sql .= "    ware_id,";         //出荷倉庫
                $sql .= "    note,";            //備考
                $sql .= "    cost_amount,";     //原価金額
                $sql .= "    net_amount,";      //売上金額
                $sql .= "    tax_amount,";      //消費税額
                $sql .= "    intro_ac_name,";   //紹介口座名
                $sql .= "    slip_flg,";        //伝票出力フラグ
                $sql .= "    shop_id,";         //取引先ID
                $sql .= "    intro_account_id,";//紹介口座ID
                $sql .= "    intro_amount,";    //紹介口座料
                $sql .= "    c_shop_name,";     //ショップ名
                $sql .= "    c_shop_name2,";    //ショップ名２
                $sql .= "    client_cd1,";      //得意先CD1
                $sql .= "    client_cd2,";      //得意先CD2
                $sql .= "    client_cname,";    //略称
                $sql .= "    client_name,";     //得意先名1
                $sql .= "    client_name2,";    //得意先名2
                $sql .= "    c_post_no1,";      //郵便番号1
                $sql .= "    c_post_no2,";      //郵便番号2
                $sql .= "    c_address1,";      //住所１
                $sql .= "    c_address2,";      //住所２
                $sql .= "    c_address3,";      //住所３
                $sql .= "    ware_name,";       //出荷倉庫名
                $sql .= "    reason_cor,";      //訂正理由
                $sql .= "    route,";           //順路
                $sql .= "    intro_ac_price,";  //口座単価(得意先)
                $sql .= "    intro_ac_rate,";   //口座率(得意先)
                $sql .= "    claim_id,";        //請求先ID
                $sql .= "    claim_div,";       //請求先区分
                $sql .= "    round_form,";      //巡回形式
                $sql .= "    contract_div,";    //契約区分
                $sql .= "    slip_out,";        //伝票形式
                $sql .= "    e_staff_id,";      //オペレータID
                $sql .= "    e_staff_name, ";   //オペレータ名
                $sql .= "    act_id,";          //代行者ID
                $sql .= "    act_cd1,";         //代行者CD1
                $sql .= "    act_cd2,";         //代行者CD2
                $sql .= "    act_name1,";       //代行者名1
                $sql .= "    act_name2,";       //代行者名2
                $sql .= "    act_cname";        //代行者名（略称）
                $sql .= ")VALUES(";
                $sql .= "    ".$aord_array[$s].",";
                //受注番号指定判定
                if($data_list[0][0] != NULL){
                    $sql .= "    '".$data_list[0][0]."',";
                }else{
                    $sql .= "    NULL,";
                }
                $sql .= "    ".$aord_array[$s].",";
                $sql .= "    '".$data_list[0][1]."',";
                $sql .= "    '".$data_list[0][2]."',";
                $sql .= "    ".$data_list[0][3].",";
                $sql .= "    '".$data_list[0][4]."',";
                $sql .= "    NULL,";         //代行伝票の出荷倉庫は代行側なので売上にはNULL
                $sql .= "    '".$data_list[0][6]."',";
                $sql .= "    ".$data_list[0][7].",";
                $sql .= "    ".$data_list[0][8].",";
                $sql .= "    ".$data_list[0][9].",";
                $sql .= "    '".$data_list[0][10]."',";
                $sql .= "    '".$data_list[0][11]."',";
                $sql .= "    ".$data_list[0][12].",";
                //紹介口座判定
                if($data_list[0][13] != NULL){
                    $sql .= "    ".$data_list[0][13].",";
                }else{
                    $sql .= "    NULL,";
                }
                //紹介口座料判定
                if($data_list[0][14] != NULL){
                    $sql .= "    ".$data_list[0][14].",";
                }else{
                    $sql .= "    NULL,";
                }

                $sql .= "    (SELECT ";
                $sql .= "        t_client.shop_name ";   //ショップ名
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.shop_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.shop_name2 ";  //ショップ名2
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.shop_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    '".$data_list[0][16]."',";
                $sql .= "    '".$data_list[0][17]."',";
                $sql .= "    '".$data_list[0][18]."',";
                $sql .= "    '".$data_list[0][19]."',";
                $sql .= "    '".$data_list[0][20]."',";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.post_no1 ";      //郵便番号1
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.post_no2 ";      //郵便番号2
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address1 ";      //住所１
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address2 ";      //住所２
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address3 ";      //住所３
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    NULL,";   //代行伝票の出荷倉庫は代行側なので売上にはNULL
                $sql .= "    '".$data_list[0][22]."',";
                //順路指定判定
                if($data_list[0][23] != NULL){
                    $sql .= "    ".$data_list[0][23].",";
                }else{
                    $sql .= "    NULL,";
                }
                //口座単価(得意先)指定判定
                if($data_list[0][24] != NULL){
                    $sql .= "    ".$data_list[0][24].",";
                }else{
                    $sql .= "    NULL,";
                }
                $sql .= "    '".$data_list[0][25]."',";
                $sql .= "    ".$data_list[0][26].",";
                $sql .= "    '".$data_list[0][27]."',";
                $sql .= "    '".$data_list[0][28]."',";
                //契約区分
                $sql .= "    '".$data_list[0][15]."',";
                $sql .= "    '".$data_list[0][29]."',";
                $sql .= "    ".$staff_id.",";
                $sql .= "    '".$staff_name."',";
                $sql .= "    $act_id,";     //代行者ID
                $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $act_id),";     //代行者CD1
                $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $act_id),";     //代行者CD2
                $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $act_id),";    //代行者名1
                $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $act_id),";   //代行者名2
                $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $act_id)";    //代行者名（略称）
                $sql .= ");";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                /****************************/
                //巡回担当者テーブル登録
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    staff_div,";
                $sql .= "    staff_id,";
                $sql .= "    sale_rate,";
                $sql .= "    staff_name,";
                $sql .= "    course_id ";
                $sql .= "FROM ";
                $sql .= "    t_aorder_staff ";
                $sql .= "WHERE ";
                $sql .= "    aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list3 = Get_Data($result,3);

                for($a=0;$a<count($data_list3);$a++){
                    $sql  = "INSERT INTO t_sale_staff( ";
                    $sql .= "    sale_id,";                         //売上ID
                    $sql .= "    staff_div,";                       //担当者識別
                    $sql .= "    staff_id,";                        //担当者ID
                    $sql .= "    sale_rate,";                       //売上率
                    $sql .= "    staff_name,";                      //担当者名
                    $sql .= "    course_id ";                       //コースID
                    $sql .= "    )VALUES(";
                    $sql .= "    ".$aord_array[$s].",";             
                    $sql .= "    '".$data_list3[$a][0]."',";        
                    $sql .= "    ".$data_list3[$a][1].",";          
                    //売上率指定判定
                    if($data_list3[$a][2] != NULL){
                        $sql .= "    ".$data_list3[$a][2].",";     
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list3[$a][3]."',";
                    //コース指定判定
                    if($data_list3[$a][4] != NULL){
                        $sql .= "    ".$data_list3[$a][4];
                    }else{
                        $sql .= "    NULL";
                    }
                    $sql .= ");";
                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }
                }

                /****************************/
                //受注データを基に、売上データ作成
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    t_aorder_d.aord_d_id,";        //受注データID0
                $sql .= "    t_aorder_d.line,";             //行1
                $sql .= "    t_aorder_d.sale_div_cd, ";     //販売区分2
                $sql .= "    t_aorder_d.serv_print_flg, ";  //サービス印字3
                $sql .= "    t_aorder_d.serv_id,";          //サービスID4
                $sql .= "    t_aorder_d.set_flg,";          //一式フラグ5
                $sql .= "    t_aorder_d.goods_print_flg, "; //アイテム印字6
                $sql .= "    t_aorder_d.goods_id,";         //アイテムID7
                $sql .= "    t_aorder_d.goods_name,";       //アイテム名8
                $sql .= "    t_aorder_d.num,";              //アイテム数9
                $sql .= "    t_aorder_d.tax_div,";          //課税区分10
                $sql .= "    t_aorder_d.buy_price,";        //仕入単価11
                $sql .= "    t_aorder_d.cost_price,";       //営業単価12
                $sql .= "    t_aorder_d.sale_price,";       //売上単価13
                $sql .= "    t_aorder_d.buy_amount,";       //仕入金額14
                $sql .= "    t_aorder_d.cost_amount,";      //営業金額15
                $sql .= "    t_aorder_d.sale_amount,";      //売上金額16
                $sql .= "    t_aorder_d.rgoods_id,";        //本体ID
                $sql .= "    t_aorder_d.rgoods_name,";      //本体名
                $sql .= "    t_aorder_d.rgoods_num,";       //本体数
                $sql .= "    t_aorder_d.egoods_id,";        //消耗品ID
                $sql .= "    t_aorder_d.egoods_name,";      //消耗品名
                $sql .= "    t_aorder_d.egoods_num,";       //消耗品数
                $sql .= "    t_aorder_d.contract_id,";      //契約情報ID
                $sql .= "    t_aorder_d.account_price,";    //口座単位
                $sql .= "    t_aorder_d.account_rate,";     //口座率

                $sql .= "    t_aorder_d.serv_name, ";       //サービス名
                $sql .= "    t_aorder_d.serv_cd, ";         //サービスCD
                $sql .= "    t_aorder_d.goods_cd, ";        //アイテムCD
                $sql .= "    t_aorder_d.rgoods_cd, ";       //本体CD
                $sql .= "    t_aorder_d.egoods_cd, ";       //消耗品CD
                $sql .= "    t_goods.unit, ";               //商品単位
                $sql .= "    t_aorder_d.g_product_name,";   //商品分類名
                $sql .= "    t_aorder_d.official_goods_name ";  //正式名
                $sql .= "FROM ";
                $sql .= "    t_aorder_d ";
                $sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_aorder_d.goods_id ";
                $sql .= "WHERE ";
                $sql .= "   t_aorder_d.aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list2 = Get_Data($result,3);

                for($a=0;$a<count($data_list2);$a++){
    /*
                    //アイテムID指定判定
                    if($data_list2[$a][7] != NULL){
                        //商品分類・正式名称取得
                        $sql  = "SELECT ";
                        $sql .= "    t_g_product.g_product_name,";
                        $sql .= "    t_goods.goods_name ";
                        $sql .= "FROM ";
                        $sql .= "    t_g_product ";
                        $sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
                        $sql .= "WHERE ";
                        $sql .= "    t_goods.goods_id = ".$data_list2[$a][7].";";
                        $result = Db_Query($db_con, $sql);
                        $pro_data = NULL;
                        $pro_data = Get_Data($result,3);
                    }
    */

                    $sql  = "INSERT INTO t_sale_d(";
                    $sql .= "    sale_d_id,";         //売上データID
                    $sql .= "    sale_id,";           //売上ID
                    $sql .= "    line,";              //行
                    $sql .= "    sale_div_cd,";       //販売区分CD
                    $sql .= "    serv_print_flg,";    //サービス印字
                    $sql .= "    serv_id,";           //サービスID
                    $sql .= "    set_flg,";           //一式フラグ
                    $sql .= "    goods_print_flg, ";  //アイテム印字
                    $sql .= "    goods_id,";          //アイテムID
                    $sql .= "    goods_name,";        //アイテム名
                    $sql .= "    num,";               //アイテム数
                    $sql .= "    tax_div,";           //課税区分
                    $sql .= "    buy_price,";         //仕入単価
                    $sql .= "    cost_price,";        //営業単価
                    $sql .= "    sale_price,";        //売上単価
                    $sql .= "    buy_amount,";        //仕入金額
                    $sql .= "    cost_amount,";       //営業金額
                    $sql .= "    sale_amount,";       //売上金額
                    $sql .= "    rgoods_id,";         //本体ID
                    $sql .= "    rgoods_name,";       //本体名
                    $sql .= "    rgoods_num,";        //本体数
                    $sql .= "    egoods_id,";         //消耗品ID
                    $sql .= "    egoods_name,";       //消耗品名
                    $sql .= "    egoods_num,";        //消耗品数
                    $sql .= "    aord_d_id,";         //受注データID
                    $sql .= "    contract_id,";       //契約情報ID
                    $sql .= "    account_price,";     //口座単価
                    $sql .= "    account_rate, ";     //口座率
                    $sql .= "    serv_name,";         //サービス名
                    $sql .= "    serv_cd, ";          //サービスCD
                    $sql .= "    goods_cd, ";         //アイテムCD
                    $sql .= "    rgoods_cd,";         //本体CD
                    $sql .= "    egoods_cd, ";        //消耗品CD
                    $sql .= "    unit, ";             //商品単位
                    $sql .= "    g_product_name,";    //商品分類
                    $sql .= "    official_goods_name";//アイテム名(正式名称)
                    $sql .= ")VALUES(";
                    $sql .= "    ".$data_list2[$a][0].",";
                    $sql .= "    ".$aord_array[$s].",";
                    $sql .= "    '".$data_list2[$a][1]."',";
                    $sql .= "    '".$data_list2[$a][2]."',";
                    $sql .= "    '".$data_list2[$a][3]."',";
                    //サービスID
                    if($data_list2[$a][4] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][4].",";
                    }else{
                        $sql .= "    NULL,";
                    }                                      
                    $sql .= "    '".$data_list2[$a][5]."',";
                    $sql .= "    '".$data_list2[$a][6]."',";
                    //アイテム商品ID
                    if($data_list2[$a][7] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][7].",";
                    }else{
                        $sql .= "    NULL,";
                    }            
                    $sql .= "    '".$data_list2[$a][8]."',";
                    //アイテム数
                    if($data_list2[$a][9] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][9].",";
                    }else{
                        $sql .= "    NULL,";
                    }                             
                    $sql .= "    '".$data_list2[$a][10]."',";
                    $sql .= "    ".$data_list2[$a][12].",";
                    $sql .= "    ".$data_list2[$a][12].",";
                    $sql .= "    ".$data_list2[$a][13].",";
                    $sql .= "    ".$data_list2[$a][15].",";
                    $sql .= "    ".$data_list2[$a][15].",";
                    $sql .= "    ".$data_list2[$a][16].",";
                    //本体商品ID
                    if($data_list2[$a][17] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][17].",";
                    }else{
                        $sql .= "    NULL,";
                    }                             
                    $sql .= "    '".$data_list2[$a][18]."',";
                    //本体数
                    if($data_list2[$a][19] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][19].",";
                    }else{
                        $sql .= "    NULL,";
                    }                
                    //消耗品ID
                    if($data_list2[$a][20] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][20].",";
                    }else{
                        $sql .= "    NULL,";
                    }               
                    $sql .= "    '".$data_list2[$a][21]."',";
                    //消耗品数
                    if($data_list2[$a][22] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][22].",";
                    }else{
                        $sql .= "    NULL,";
                    }               
                    $sql .= "    ".$data_list2[$a][0].",";
                    $sql .= "    ".$data_list2[$a][23].",";
                    //口座単価 
                    if($data_list2[$a][24] != NULL){  
                        $sql .= "    ".$data_list2[$a][24].",";
                    }else{
                        $sql .= "    NULL,";
                    }   
                    $sql .= "    '".$data_list2[$a][25]."',";

                    $sql .= "    '".$data_list2[$a][26]."',"; 
                    $sql .= "    '".$data_list2[$a][27]."',"; 
                    $sql .= "    '".$data_list2[$a][28]."',"; 
                    $sql .= "    '".$data_list2[$a][29]."',";
                    $sql .= "    '".$data_list2[$a][30]."',";
                    $sql .= "    '".$data_list2[$a][31]."',";
                    $sql .= "    '".$data_list2[$a][32]."',";
                    $sql .= "    '".$data_list2[$a][33]."');";  
                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }

                    /****************************/
                    //受注の内訳テーブルを基に、売上の内訳テーブル作成
                    /****************************/
                    $sql  = "SELECT ";
                    $sql .= "    aord_d_id,";
                    $sql .= "    line,";
                    $sql .= "    goods_id,";
                    $sql .= "    goods_name,";
                    $sql .= "    num,";
                    $sql .= "    trade_price,";
                    $sql .= "    trade_amount,";
                    $sql .= "    sale_price,";
                    $sql .= "    sale_amount, ";
                    $sql .= "    goods_cd ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_detail ";
                    $sql .= "WHERE ";
                    $sql .= "    aord_d_id = ".$data_list2[$a][0];
                    $result = Db_Query($db_con, $sql);
                    $data_list4 = Get_Data($result,3);

                    for($x=0;$x<count($data_list4);$x++){
                        $sql  = "INSERT INTO t_sale_detail( ";
                        $sql .= "    sale_d_id,";
                        $sql .= "    line,";
                        $sql .= "    goods_id,";
                        $sql .= "    goods_name,";
                        $sql .= "    num,";
                        $sql .= "    trade_price,";
                        $sql .= "    trade_amount,";
                        $sql .= "    sale_price,";
                        $sql .= "    sale_amount,";
                        $sql .= "    goods_cd ";
                        $sql .= "    )VALUES(";
                        $sql .= "    ".$data_list4[$x][0].",";          
                        $sql .= "    ".$data_list4[$x][1].",";    
                        $sql .= "    ".$data_list4[$x][2].",";          
                        $sql .= "    '".$data_list4[$x][3]."',";        
                        $sql .= "    ".$data_list4[$x][4].",";          
                        $sql .= "    ".$data_list4[$x][5].",";          
                        $sql .= "    ".$data_list4[$x][6].",";          
                        $sql .= "    ".$data_list4[$x][7].",";          
                        $sql .= "    ".$data_list4[$x][8].",";
                        $sql .= "    '".$data_list4[$x][9]."'";          
                        $sql .= ");";
                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }

                    /****************************/
                    //受注の出庫品テーブルを基に、売上の出庫品テーブル作成
                    /****************************/
                    $sql  = "SELECT ";
                    $sql .= "    aord_d_id,";
                    $sql .= "    goods_id,";
                    $sql .= "    goods_name,";
                    $sql .= "    num,";
                    $sql .= "    goods_cd ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_ship ";
                    $sql .= "WHERE ";
                    $sql .= "    aord_d_id = ".$data_list2[$a][0].";";
                    $result = Db_Query($db_con, $sql);
                    $data_list5 = Get_Data($result,3);

                    //ログインIDの情報を抽出
/*
                    $sql  = "SELECT";
                    $sql .= "   t_ware.ware_id ";
                    $sql .= " FROM";
                    $sql .= "   t_client LEFT JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
                    $sql .= " WHERE";
                    $sql .= "   client_id = $shop_id";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql); 
                    $client_data = Get_Data($result);
                    $ware_id     = $client_data[0][0];        //出荷倉庫ID
*/
                    //拠点倉庫ID
                    $ware_id = Get_ware_id($db_con, Get_Branch_Id($db_con));

                    //受払に登録するデータ取得
                    $sql  = "SELECT ";
                    $sql .= "    t_sale_h.sale_day,";     //巡回日
                    $sql .= "    t_sale_h.sale_no ";      //受注番号
                    $sql .= "FROM ";
                    $sql .= "    t_sale_h ";
                    $sql .= "    INNER JOIN t_sale_d ON t_sale_d.sale_id = t_sale_h.sale_id ";
                    $sql .= "WHERE ";
                    $sql .= "    t_sale_h.sale_id = ".$aord_array[$s].";";
                    $result = Db_Query($db_con, $sql);
                    $stock_data = Get_Data($result);

                    for($c=0;$c<count($data_list5);$c++){
                        $sql  = "INSERT INTO t_sale_ship( ";
                        $sql .= "    sale_d_id,";
                        $sql .= "    goods_id,";
                        $sql .= "    goods_name,";
                        $sql .= "    num,";
                        $sql .= "    goods_cd ";
                        $sql .= "    )VALUES(";
                        $sql .= "    ".$data_list5[$c][0].",";    
                        $sql .= "    ".$data_list5[$c][1].",";         
                        $sql .= "    '".$data_list5[$c][2]."',";
                        $sql .= "    ".$data_list5[$c][3].",";
                        $sql .= "    '".$data_list5[$c][4]."'";
                        $sql .= ");";
                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }
                }

                /****************************/
                //売上IDから紹介料を計算し、仕入テーブルへ登録
                /****************************/
                //紹介料指定判定
                $sql  = "SELECT ";
                $sql .= "    intro_amount ";
                $sql .= "FROM ";
                $sql .= "    t_sale_h ";
                $sql .= "WHERE ";
                $sql .= "    sale_id = ".$aord_array[$s];
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
            
                $intro_amount = pg_fetch_result($result, 0, "intro_amount");    //紹介料

                //紹介料が指定されていた場合、登録
                if($intro_amount != NULL){
                    $result = FC_Intro_Buy_Query($db_con, $aord_array[$s], $data_list[0][13]);
                    if($result === false){
                        //同時実行制御処理
                        $err_message = pg_last_error();
                        $err_format = "t_buy_h_buy_no_key";

                        //仕入番号が重複した場合            
                        if(strstr($err_message,$err_format) != false){
                            $error_buy = "以下の伝票は、仕入番号が重複しました。もう一度承認を行ってください。";
                            $error_buy_no[$ord_no] = $ord_no;

                            $err_data["confirm_flg"] = false;
                            $form->setConstants($err_data);
                        }else{
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }
                }

                //代行料存在判定
                $sql  = "SELECT act_sale_id FROM t_buy_h WHERE act_sale_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql.";");
                $aord_count = pg_num_rows($result);
                //存在していなければ登録
                if($aord_count == 0){
                    /****************************/
                    //代行料登録処理
                    /****************************/
                    $sql  = "SELECT ";
                    $sql .= "    act_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_h ";
                    $sql .= "WHERE ";
                    $sql .= "   aord_id = ".$aord_array[$s];
                    $sql .= ";";
                    $result = Db_Query($db_con, $sql);
                    $shop_data = Get_Data($result);
                    $buy_d_id = FC_Act_Buy_Query($db_con, $aord_array[$s],$shop_data[0][0],$shop_id);
                    if($buy_d_id === false){
                        //同時実行制御処理
                        $err_message = pg_last_error();
                        $err_format = "t_buy_h_buy_no_key";

                        //仕入番号が重複した場合            
                        if(strstr($err_message,$err_format) != false){
                            $error_buy = "以下の伝票は、仕入番号が重複しました。もう一度承認を行ってください。";
                            $error_buy_no[$ord_no] = $ord_no;

                            $err_data["confirm_flg"] = false;
                            $form->setConstants($err_data);
                        }else{
                             Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }
                }
            }
        }

        //エラーの場合、自画面に遷移しない
        if( $error_buy == NULL && 
            $deli_day_renew_err == NULL && 
            $claim_day_renew_err == NULL && 
            $claim_day_bill_err == NULL && 
            $confirm_err == NULL && 
            $reserve_del_err == NULL && 
            $cancel_err == NULL 
        ){
            //正常

            Db_Query($db_con, "COMMIT");
//            header("Location: ./2-1-237.php");

        }else{
            //エラー

            Db_Query($db_con, "ROLLBACK;");
            
            //既に承認
            if($confirm_err_no != NULL){
                while($error_confirm_no = each($confirm_err_no)){
                    $e_confirm_no = $error_confirm_no[0];
                    $confirm_err .= "<br>　　".$e_confirm_no;
                }
            }

            //保留削除
            if($reserve_del_err_no != NULL){
                while($error_reserve_no = each($reserve_del_err_no)){
                    $e_reserve_no = $error_reserve_no[0];
                    $reserve_del_err .= "<br>　　".$e_reserve_no;
                }
            }

            //既に取消
            if($cancel_err_no != NULL){
                while($error_cancel_no = each($cancel_err_no)){
                    $e_cancel_no = $error_cancel_no[0];
                    $cancel_err .= "<br>　　".$e_cancel_no;
                }
            }

            //配送日 が前回の月次更新以前
            if($deli_day_renew_err_no != NULL){
                while($error_deli_day_no = each($deli_day_renew_err_no)){
                    $e_deli_day_no = $error_deli_day_no[0];
                    $deli_day_renew_err .= "<br>　　".$e_deli_day_no;
                }
            }

            //請求日 が前回の月次更新以前
            if($claim_day_renew_err_no != NULL){
                while($error_claim_day_renew_no = each($claim_day_renew_err_no)){
                    $e_claim_day_renew_no = $error_claim_day_renew_no[0];
                    $claim_day_renew_err .= "<br>　　".$e_claim_day_renew_no;
                }
            }

            //請求日 に請求書作成済
            if($claim_day_bill_err_no != NULL){
                while($error_claim_day_bill_no = each($claim_day_bill_err_no)){
                    $e_claim_day_bill_no = $error_claim_day_bill_no[0];
                    $claim_day_bill_err .= "<br>　　".$e_claim_day_bill_no;
                }
            }

            //仕入番号が重複
            if($error_buy_no != NULL){
                while($error_buy_no = each($error_buy_no)){
                    $e_buy_no = $error_buy_no[0];
                    $error_buy .= "<br>　　".$e_buy_no;
                }
            }
        }
    }else{
        //チェックが無い場合はエラー

        $error_msg3 = "承認する伝票が一つも選択されていません。";
        $error_flg = true;
    }
}

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_display"] == "表　示"){
    //現在のページ数初期化
    $page_count = null;
    $offset = 0;

    /******************************/
    //POST情報取得
    /******************************/
    $aord_day_sy  = $_POST["form_aord_day"]["sy"];                      //巡回日開始（年）
    $aord_day_sm  = $_POST["form_aord_day"]["sm"];                      //巡回日開始（月）
    $aord_day_sd  = $_POST["form_aord_day"]["sd"];                      //巡回日開始（日）
    if($aord_day_sy != NULL && $aord_day_sm != NULL && $aord_day_sd != NULL){
        $sday  = str_pad($_POST["form_aord_day"]["sy"], 4, 0, STR_PAD_LEFT);    //巡回日開始（年）
        $sday .= "-";
        $sday .= str_pad($_POST["form_aord_day"]["sm"], 2, 0, STR_PAD_LEFT);    //巡回日開始（月）
        $sday .= "-";
        $sday .= str_pad($_POST["form_aord_day"]["sd"], 2, 0, STR_PAD_LEFT);    //巡回日開始（日）
    }
    $aord_day_ey  = $_POST["form_aord_day"]["ey"];                      //巡回日終了（年）
    $aord_day_em  = $_POST["form_aord_day"]["em"];                      //巡回日終了（月）
    $aord_day_ed  = $_POST["form_aord_day"]["ed"];                      //巡回日終了（日）
    if($aord_day_ey != NULL && $aord_day_em != NULL && $aord_day_ed != NULL){
        $eday  = str_pad($_POST["form_aord_day"]["ey"], 4, 0, STR_PAD_LEFT);    //巡回日終了（年）
        $eday .= "-";
        $eday .= str_pad($_POST["form_aord_day"]["em"], 2, 0, STR_PAD_LEFT);    //巡回日終了（月）
        $eday .= "-";
        $eday .= str_pad($_POST["form_aord_day"]["ed"], 2, 0, STR_PAD_LEFT);    //巡回日終了（日）
    }

    $slip_num     = $_POST["form_slip_num"];                           //伝票番号
    $client_cd1   = $_POST["form_client"]["cd1"];                      //得意先CD1
    $client_cd2   = $_POST["form_client"]["cd2"];                      //得意先CD2                           
    $client_name  = $_POST["form_client_name"];                        //得意先名
    
    $act_cd1   = $_POST["form_act"]["cd1"];                            //代行先CD1
    $act_cd2   = $_POST["form_act"]["cd2"];                            //代行先CD2                           
    $act_name  = $_POST["form_act_name"];                              //代行先名

    $post_flg     = true;                                              //POSTフラグ

/****************************/
//ページ分けリンク押下処理
/****************************/
}elseif(count($_POST)>0 && $_POST["form_display"] != "表　示"){

    /******************************/
    //POST情報取得
    /******************************/
    $aord_day_sy  = $_POST["hdn_aord_day_sy"];                          //巡回日開始（年）
    $aord_day_sm  = $_POST["hdn_aord_day_sm"];                          //巡回日開始（月）
    $aord_day_sd  = $_POST["hdn_aord_day_sd"];                          //巡回日開始（日）
    if($aord_day_sy != NULL && $aord_day_sm != NULL && $aord_day_sd != NULL){
        $sday  = str_pad($_POST["hdn_aord_day_sy"], 4, 0, STR_PAD_LEFT);        //巡回日開始（年）
        $sday .= "-";
        $sday .= str_pad($_POST["hdn_aord_day_sm"], 2, 0, STR_PAD_LEFT);        //巡回日開始（月）
        $sday .= "-";
        $sday .= str_pad($_POST["hdn_aord_day_sd"], 2, 0, STR_PAD_LEFT);        //巡回日開始（日）
    }
    $aord_day_ey  = $_POST["hdn_aord_day_ey"];                          //巡回日終了（年）
    $aord_day_em  = $_POST["hdn_aord_day_em"];                          //巡回日終了（月）
    $aord_day_ed  = $_POST["hdn_aord_day_ed"];                          //巡回日終了（日）
    if($aord_day_ey != NULL && $aord_day_em != NULL && $aord_day_ed != NULL){
        $eday  = str_pad($_POST["hdn_aord_day_ey"], 4, 0, STR_PAD_LEFT);        //巡回日終了（年）
        $eday .= "-";
        $eday .= str_pad($_POST["hdn_aord_day_em"], 2, 0, STR_PAD_LEFT);        //巡回日終了（月）
        $eday .= "-";
        $eday .= str_pad($_POST["hdn_aord_day_ed"], 2, 0, STR_PAD_LEFT);        //巡回日終了（日）
    }
    
    $slip_num     = $_POST["hdn_slip_num"];                         //伝票番号
    $client_cd1   = $_POST["hdn_client_cd1"];                       //得意先CD1
    $client_cd2   = $_POST["hdn_client_cd2"];                       //得意先CD2                           
    $client_name  = $_POST["hdn_client_name"];                      //得意先名

    $act_cd1   = $_POST["hdn_act_cd1"];                             //代行CD1
    $act_cd2   = $_POST["hdn_act_cd2"];                             //代行先CD2                           
    $act_name  = $_POST["hdn_act_name"];                            //代行先名

    $page_count  = $_POST["f_page1"];
    
    $offset = $page_count * $range - $range;

    $post_flg       = true;                                         //POSTフラグ

    // hiddenの検索条件をフォームにセット
    $form_set["form_slip_num"]          = stripslashes($_POST["hdn_slip_num"]);
    $form_set["form_range_select"]      = stripslashes($_POST["hdn_range_select"]);
    $form_set["form_client"]["cd1"]     = stripslashes($_POST["hdn_client_cd1"]);
    $form_set["form_client"]["cd2"]     = stripslashes($_POST["hdn_client_cd2"]);
    $form_set["form_client_name"]       = stripslashes($_POST["hdn_client_name"]);
    $form_set["form_act"]["cd1"]        = stripslashes($_POST["hdn_act_cd1"]);
    $form_set["form_act"]["cd2"]        = stripslashes($_POST["hdn_act_cd2"]);
    $form_set["form_act_name"]          = stripslashes($_POST["hdn_act_name"]);
    $form_set["form_aord_day"]["sy"]    = stripslashes($_POST["hdn_aord_day_sy"]);
    $form_set["form_aord_day"]["sm"]    = stripslashes($_POST["hdn_aord_day_sm"]);
    $form_set["form_aord_day"]["sd"]    = stripslashes($_POST["hdn_aord_day_sd"]);
    $form_set["form_aord_day"]["ey"]    = stripslashes($_POST["hdn_aord_day_ey"]);
    $form_set["form_aord_day"]["em"]    = stripslashes($_POST["hdn_aord_day_em"]);
    $form_set["form_aord_day"]["ed"]    = stripslashes($_POST["hdn_aord_day_ed"]);
    $form->setConstants($form_set);

}

/****************************/
//POSTがあれば
/****************************/
if($post_flg == true){
 
    /****************************/
    //エラーチェック(PHP)
    /****************************/
    //◇巡回日
    //・文字種チェック
    if($aord_day_sy != null || $aord_day_sm != null || $aord_day_sd != null){

        $aord_day_sy = str_pad($aord_day_sy,4, 0, STR_PAD_LEFT);  
        $aord_day_sm = str_pad($aord_day_sm,2, 0, STR_PAD_LEFT); 
        $aord_day_sd = str_pad($aord_day_sd,2, 0, STR_PAD_LEFT); 

        //数値判定
        if(!ereg("^[0-9]{4}$",$aord_day_sy) || !ereg("^[0-9]{2}$",$aord_day_sm) || !ereg("^[0-9]{2}$",$aord_day_sd)){
            $error_msg = "巡回日開始 の日付は妥当ではありません。";
            $error_flg = true;
        }

        //・文字種チェック
        $day_sy = (int)$aord_day_sy;
        $day_sm = (int)$aord_day_sm;
        $day_sd = (int)$aord_day_sd;
        if(!checkdate($day_sm,$day_sd,$day_sy)){
            $error_msg = "巡回日開始 の日付は妥当ではありません。";
            $error_flg = true;
        }
    }

    if($aord_day_ey != null || $aord_day_em != null || $aord_day_ed != null){

        $aord_day_ey = str_pad($aord_day_ey,4, 0, STR_PAD_LEFT);  
        $aord_day_em = str_pad($aord_day_em,2, 0, STR_PAD_LEFT); 
        $aord_day_ed = str_pad($aord_day_ed,2, 0, STR_PAD_LEFT); 

        //数値判定
        if(!ereg("^[0-9]{4}$",$aord_day_ey) || !ereg("^[0-9]{2}$",$aord_day_em) || !ereg("^[0-9]{2}$",$aord_day_ed)){
            $error_msg2 = "巡回日終了 の日付は妥当ではありません。";
            $error_flg = true;
        }

        //・文字種チェック
        $day_ey = (int)$aord_day_ey;
        $day_em = (int)$aord_day_em;
        $day_ed = (int)$aord_day_ed;
        if(!checkdate($day_em,$day_ed,$day_ey)){
            $error_msg2 = "巡回日終了 の日付は妥当ではありません。";
            $error_flg = true;
        }
    }

    /******************************/
    //値検証
    /******************************/
    if($error_flg == false){
   
        /*******************************/
        //検索条件をhiddenにセット
        /*******************************/
/*
        $def_data["form_aord_day"]["sy"]      = stripslashes($aord_day_sy);               
        $def_data["form_aord_day"]["sm"]      = stripslashes($aord_day_sm);               
        $def_data["form_aord_day"]["sd"]      = stripslashes($aord_day_sd);          
        $def_data["form_aord_day"]["ey"]      = stripslashes($aord_day_ey);               
        $def_data["form_aord_day"]["em"]      = stripslashes($aord_day_em);               
        $def_data["form_aord_day"]["ed"]      = stripslashes($aord_day_ed);          
        
        $def_data["form_slip_num"]            = stripslashes($slip_num);
      
        $def_data["form_client"]["cd1"]        = stripslashes($client_cd1);  
        $def_data["form_client"]["cd2"]        = stripslashes($client_cd2); 
        $def_data["form_client_name"]          = stripslashes($client_name);  

        $def_data["form_act"]["cd1"]           = stripslashes($act_cd1);  
        $def_data["form_act"]["cd2"]           = stripslashes($act_cd2); 
        $def_data["form_act_name"]             = stripslashes($act_name);  
*/

        $def_data["hdn_aord_day_sy"]          = stripslashes($aord_day_sy);               
        $def_data["hdn_aord_day_sm"]          = stripslashes($aord_day_sm);               
        $def_data["hdn_aord_day_sd"]          = stripslashes($aord_day_sd);          
        $def_data["hdn_aord_day_ey"]          = stripslashes($aord_day_ey);               
        $def_data["hdn_aord_day_em"]          = stripslashes($aord_day_em);               
        $def_data["hdn_aord_day_ed"]          = stripslashes($aord_day_ed);          
        
        $def_data["hdn_slip_num"]             = stripslashes($slip_num);      
        $def_data["hdn_client_cd1"]           = stripslashes($client_cd1);  
        $def_data["hdn_client_cd2"]           = stripslashes($client_cd2); 
        $def_data["hdn_client_name"]          = stripslashes($client_name);  
         
        $def_data["hdn_act_cd1"]              = stripslashes($act_cd1);  
        $def_data["hdn_act_cd2"]              = stripslashes($act_cd2); 
        $def_data["hdn_act_name"]             = stripslashes($act_name);  

        $def_data["hdn_range_select"]         = $_POST["form_range_select"];

        $form->setConstants($def_data); 

        // 表示ボタン押下時
        if ($_POST["form_display"] != null){
            // フォームデータをSESSIONにセット
            $_SESSION[$module_no]["hdn_slip_num"]       = stripslashes($_POST["form_slip_num"]);
            $_SESSION[$module_no]["hdn_range_select"]   = stripslashes($_POST["form_range_select"]);
            $_SESSION[$module_no]["hdn_client_cd1"]     = stripslashes($_POST["form_client"]["cd1"]);
            $_SESSION[$module_no]["hdn_client_cd2"]     = stripslashes($_POST["form_client"]["cd2"]);
            $_SESSION[$module_no]["hdn_client_name"]    = stripslashes($_POST["form_client_name"]);
            $_SESSION[$module_no]["hdn_act_cd1"]        = stripslashes($_POST["form_act"]["cd1"]);
            $_SESSION[$module_no]["hdn_act_cd2"]        = stripslashes($_POST["form_act"]["cd2"]);
            $_SESSION[$module_no]["hdn_act_name"]       = stripslashes($_POST["form_act_name"]);
            $_SESSION[$module_no]["hdn_aord_day_sy"]    = stripslashes($_POST["form_aord_day"]["sy"]);
            $_SESSION[$module_no]["hdn_aord_day_sm"]    = stripslashes($_POST["form_aord_day"]["sm"]);
            $_SESSION[$module_no]["hdn_aord_day_sd"]    = stripslashes($_POST["form_aord_day"]["sd"]);
            $_SESSION[$module_no]["hdn_aord_day_ey"]    = stripslashes($_POST["form_aord_day"]["ey"]);
            $_SESSION[$module_no]["hdn_aord_day_em"]    = stripslashes($_POST["form_aord_day"]["em"]);
            $_SESSION[$module_no]["hdn_aord_day_ed"]    = stripslashes($_POST["form_aord_day"]["ed"]);
            if ($_POST["f_page1"] == null || $_POST["form_display"] != null){
                $_SESSION[$module_no]["f_page1"]        = "1";
                $_SESSION[$module_no]["f_page2"]        = "1";
            }
        }

        /****************************/
        //WHERE_SQL作成
        /****************************/
        $where_sql  = "";

        //巡回日（開始）
        $where_sql .= $sday_sql         = ($sday != null) ? "AND '$sday' <= t_aorder_h.ord_time \n" : null;

        //巡回日（終了）
        $where_sql .= $eday_sql         = ($eday != null) ? "AND t_aorder_h.ord_time <= '$eday' \n" : null;

        //伝票番号
        $where_sql .= $slip_sql         = ($slip_num != null) ? "AND t_aorder_h.ord_no LIKE '$slip_num%' \n" : null;

        //得意先コード1
        $where_sql .= $client_cd1_sql   = ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
           
        //得意先コード2
        $where_sql .= $client_cd2_sql   = ($client_cd2 != null) ? "AND t_aorder_h.client_cd2 LIKE '$client_cd2%' \n" : null;

        //得意先名
        if($client_name != null){
            $client_name_sql  = "AND \n";
            $client_name_sql .= "   ( \n";
            $client_name_sql .= "       t_aorder_h.client_name LIKE '%$client_name%' \n";
            $client_name_sql .= "       OR \n";
            $client_name_sql .= "       t_aorder_h.client_name2 LIKE '%$client_name%' \n";
            $client_name_sql .= "       OR \n";
            $client_name_sql .= "       t_aorder_h.client_cname LIKE '%$client_name%' \n";
            $client_name_sql .= "   ) \n";
            $where_sql .= $client_name_sql;
        }

        //代行先コード1
        $where_sql .= $act_cd1_sql      = ($act_cd1 != null) ? "AND t_aorder_h.act_cd1 LIKE '$act_cd1%' \n" : null;
           
        //代行先コード2
        $where_sql .= $act_cd2_sql      = ($act_cd2 != null) ? "AND t_aorder_h.act_cd2 LIKE '$act_cd2%' \n" : null;

        //代行先名
        $where_sql .= $act_name_sql     = ($act_name != null) ? "AND t_aorder_h.act_name LIKE '%$act_name%' \n" : null;

    }
}

/****************************/
//受注ヘッダー取得SQL
/****************************/
// 表示フラグがあり、エラーのない場合
if ($post_flg == true && $err_flg != true){

    // オンライン代行
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                // 受注ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                 // 受注番号
    $sql .= "   t_staff1.charge_cd, \n";                                                // 担当者CD1
    $sql .= "   t_staff1.staff_name, \n";                                               // 担当者名1
    $sql .= "   t_aorder_h.ord_time, \n";                                               // 巡回日
    $sql .= "   t_aorder_h.client_cname, \n";                                           // 略称
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";// 得意先CD
    $sql .= "   t_aorder_h.act_cd1 || '-' || t_aorder_h.act_cd2 AS act_cd, \n";         // 代行先CD
    $sql .= "   t_aorder_h.act_name, \n";                                               // 代行先名
    $sql .= "   CASE t_aorder_h.confirm_flg \n";
    $sql .= "       WHEN 't' THEN '承認' \n";
    $sql .= "       WHEN 'f' THEN '未承認' \n";
    $sql .= "   END \n";
    $sql .= "   AS confirm_flg, \n";                                                    // 確定フラグ
    $sql .= "   'オン' AS contract_div, \n";                                            // 契約区分
    $sql .= "   t_trade.trade_name, \n";                                                // 取引区分
    $sql .= "   t_sale_h.renew_flg, \n";                                                // 日次更新フラグ
    $sql .= "   t_aorder_h.arrival_day, \n";                                            // 請求日
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS claim_cd, \n";     // 請求先コード
    $sql .= "   t_client.client_cname AS claim_cname, \n";                              // 請求先名
    $sql .= "   t_aorder_h.net_amount, \n";                                             // 税抜金額
    $sql .= "   t_aorder_h.tax_amount, \n";                                             // 消費税
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount \n";    // 金額合計
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff1 \n";
    $sql .= "   ON t_staff1.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_sale_h ON t_sale_h.sale_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade  ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.trust_confirm_flg = 't' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ps_stat = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.reserve_del_flg = 'f' \n";
    $sql .= $where_sql;

    $sql .= "UNION \n";

    // オフライン代行
    $sql .= "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                // 受注ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                 // 受注番号
    $sql .= "   t_staff1.charge_cd, \n";                                                // 担当者CD1
    $sql .= "   t_staff1.staff_name, \n";                                               // 担当者名1
    $sql .= "   t_aorder_h.ord_time, \n";                                               // 巡回日
    $sql .= "   t_aorder_h.client_cname, \n";                                           // 略称
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";// 得意先CD
    $sql .= "   t_aorder_h.act_cd1 || '-' || t_aorder_h.act_cd2 AS act_cd, \n";         // 代行先CD
    $sql .= "   t_aorder_h.act_name, \n";                                               // 代行先名
    $sql .= "   CASE t_aorder_h.confirm_flg \n";
    $sql .= "       WHEN 't' THEN '承認' \n";
    $sql .= "       WHEN 'f' THEN '未承認' \n";
    $sql .= "   END \n";
    $sql .= "   AS confirm_flg, \n";                                                    // 確定フラグ
    $sql .= "   'オフ' AS contract_div, \n";                                            // 契約区分
    $sql .= "   t_trade.trade_name, \n";                                                // 取引区分
    $sql .= "   t_sale_h.renew_flg, ";                                                  // 日次更新フラグ
    $sql .= "   t_aorder_h.arrival_day, \n";                                            // 請求日
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS claim_cd, \n";     // 請求先コード
    $sql .= "   t_client.client_cname AS claim_cname, \n";                              // 請求先名
    $sql .= "   t_aorder_h.net_amount, \n";                                             // 税抜金額
    $sql .= "   t_aorder_h.tax_amount, \n";                                             // 消費税
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount \n";    // 消費税
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff1 \n";
    $sql .= "   ON t_staff1.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_sale_h ON t_sale_h.sale_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade  ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.reserve_del_flg = 'f' \n";
    $sql .= $where_sql;

    // ソート順
    $sql .= "ORDER BY \n";
    $sql .= "   5, \n";     // 得意先名略称
    $sql .= "   3 \n";      // 巡回担当者

    // 全件取得（件数処理用）
    $res         = Db_Query($db_con, $sql.";");
    $total_count = pg_num_rows($res);

    // OFFSET作成
    if($page_count != null || $range != null){
        $offset = $page_count * $range - $range;
    }else{
        $offset = 0;
    }
    if ($range != null){
        $sql .= "LIMIT $range OFFSET $offset \n";
    }

    // 一覧データ取得（ページ分け用）
    $res_h = Db_Query($db_con, $sql.";");
    $num_h = pg_num_rows($res_h);
    if ($num_h > 0){
        $page_data_h = Get_Data($res_h, 2, "ASSOC");
    }else{
        $page_data_h = array(null);
    }

    // 上記で取得した受注ヘッダに該当する受注データの取得
    if ($num_h > 0){
        $sql  = "SELECT \n";
        $sql .= "   t_aorder_d.aord_id, \n";                // 受注ID
        $sql .= "   t_aorder_d.line, \n ";                  // 行
        $sql .= "   CASE t_aorder_d.sale_div_cd \n";
        $sql .= "       WHEN '01' THEN 'リピート' \n";
        $sql .= "       WHEN '02' THEN '商品' \n";
        $sql .= "       WHEN '03' THEN 'レンタル' \n";
        $sql .= "       WHEN '04' THEN 'リース' \n";
        $sql .= "       WHEN '05' THEN '卸' \n";
        $sql .= "       WHEN '06' THEN '工事' \n";
        $sql .= "       WHEN '07' THEN 'その他' \n";
        $sql .= "   END \n";
        $sql .= "   AS sale_div_cd, \n";                    // 販売区分
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.serv_print_flg = 't' \n";
        $sql .= "       THEN '○'\n";
        $sql .= "       ELSE '×' \n";
        $sql .= "   END \n";
        $sql .= "   AS serv_print_flg, \n";                 // サービス印字フラグ
        $sql .= "   t_aorder_d.serv_cd, \n";                // サービスコード
        $sql .= "   t_aorder_d.serv_name, \n";              // サービス名
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.goods_print_flg = 't' \n";
        $sql .= "       THEN '○'\n";
        $sql .= "       ELSE '×' \n";
        $sql .= "   END \n";
        $sql .= "   AS goods_print_flg, \n";                // 商品印字フラグ
        $sql .= "   t_aorder_d.goods_cd, \n";               // 商品コード
        $sql .= "   t_aorder_d.official_goods_name, \n";    // 商品名
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.set_flg = 't' \n";
        $sql .= "       THEN '一式<br>'\n";
        $sql .= "       ELSE NULL \n";
        $sql .= "   END \n";
        $sql .= "   AS set_flg, \n";                        // サービス一式フラグ
        $sql .= "   t_aorder_d.num, \n";                    // 数量
        $sql .= "   t_aorder_d.cost_price, \n";             // 営業原価
        $sql .= "   t_aorder_d.sale_price, \n";             // 売上単価
        $sql .= "   t_aorder_d.cost_amount, \n";            // 原価合計額
        $sql .= "   t_aorder_d.sale_amount, \n";            // 売上合計額
        $sql .= "   t_aorder_d.egoods_cd, \n";              // 消耗品コード
        $sql .= "   t_aorder_d.egoods_name, \n";            // 消耗品名
        $sql .= "   t_aorder_d.egoods_num, \n";             // 消耗品数量
        $sql .= "   t_aorder_d.rgoods_cd, \n";              // 本体商品コード
        $sql .= "   t_aorder_d.rgoods_name, \n";            // 本体商品名
        $sql .= "   t_aorder_d.rgoods_num \n";              // 本体商品数量
        $sql .= "FROM \n";
        $sql .= "   t_aorder_d \n";
        $sql .= "WHERE \n";
        $sql .= "   t_aorder_d.aord_id IN (";
        foreach ($page_data_h as $key_h => $value_h){
        $sql .= $value_h["aord_id"];  // 受注ヘッダ取得内容の受注ID
        $sql .= ($key_h+1 < $num_h) ? ", " : null;
        }
        $sql .= ") \n";
        $sql .= "ORDER BY \n";
        $sql .= "   t_aorder_d.aord_id, \n";
        $sql .= "   t_aorder_d.line \n";
        $sql .= ";";
        $res_d = Db_Query($db_con, $sql);
        $num_d = pg_num_rows($res_d);
        if ($num_d > 0){
            $page_data_d = Get_Data($res_d, 2, "ASSOC");
        }else{
            $page_data_d = array(null);
        }
    }

}


/****************************/
// 表示データ作成
/****************************/
// 金額が負数の場合にセル内の文字色を赤にする関数
function Font_Color($num, $dot = 0){
    return ((int)$num < 0) ? "<font style=\"color: #ff0000;\">".number_format($num, $dot)."</font>" : number_format($num, $dot);
}

// 表示フラグtrue、かつエラーのない場合
if ($post_flg == true && $err_flg != true){

    /****************************/
    // 承認チェックボックス作成用処理
    /****************************/
    //チェックボックス非表示行番号配列
    $hidden_check = array();

    // ヘッダ部でループ
    if ($num_h > 0){

        foreach ($page_data_h as $key_h => $value_h){
            // 受注IDをhiddenに追加
            $form->addElement("hidden","output_id_array[$key_h]");                      // 承認受注ID配列
            $con_data["output_id_array[$key_h]"] = $page_data_h[$key_h]["aord_id"];     // 受注ID
            // 確定判定
            if ($page_data_h[$key_h]["confirm_flg"] != "未承認"){
                // チェックボックス非表示行番号取得
                $hidden_check[] = $key_h;
            }
        }

    }

    /****************************/
    // フォーム動的部品作成
    /****************************/
    // 承認ALLチェック
    $form->addElement("checkbox", "form_slip_all_check", "", "承認",
        "onClick=\"javascript:All_check('form_slip_all_check','form_slip_check',$num_h)\""
    );

    if ($num_h > 0){
        // 承認チェック
        foreach ($page_data_h as $key_h => $value_h){
            // 表示行判定
            if (!in_array($key_h, $hidden_check)){
                // 未承認行はチェックボックス定義
                $form->addElement("checkbox", "form_slip_check[$key_h]","","","","");
            }else{
                // 承認行は非表示にする為にhiddenで定義
                $form->addElement("hidden","form_slip_check[$key_h]","");
            }
        }
    }

    /****************************/
    // POST時にチェック情報初期化
    /****************************/
    if(count($_POST) > 0){
        foreach ($page_data_h as $key_h => $value_h){
            $con_data["form_slip_check"][$key_h]  = "";   
        }
        $con_data["form_slip_all_check"] = "";   
    }
    $form->setConstants($con_data); 

    /****************************/
    // html作成初期設定
    /****************************/
    // 行色初期設定
    $row_col = "Result1";

    // 行No.初期設定
    $row_num = ($_POST["f_page1"] != null && $_POST["form_display"] == null) ? ($_POST["f_page1"]-1) * $range : 0;

    /****************************/
    // html作成
    /****************************/
    // 件数表示/ページ分け
    $range = ($range == null) ? $num_h : $range;
    $html_page  = Html_Page($total_count, $page_count, 1, $range);
    $html_page2 = Html_Page($total_count, $page_count, 2, $range);

    // 明細データ 列タイトル
    $html_l  = "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
    $html_l .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_l .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">伝票番号</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">巡回日</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">請求日</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">得意先コード<br>得意先名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">代行先コード<br>代行先名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">請求先コード<br>請求先名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">代行<br>区分</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">巡回担当者<br>（メイン1）</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">税抜合計</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">消費税</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">伝票金額</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">販売区分</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">サービスコード<br>サービス名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">商品コード<br>商品名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">営業原価<br>売上単価</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">原価合計額<br>売上合計額</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">消耗品コード<br>消耗品名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">本体商品コード<br>本体商品名</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">数量</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">承認</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">取消</td>\n";
    $html_l .= "        <td class=\"Title_Pink\" width=\"150\">";
    $html_l .=              $form->_elements[$form->_elementIndex["form_slip_all_check"]]->toHtml();
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";

    // ヘッダ部でループ
    if ($num_h > 0){
    foreach ($page_data_h as $key_h => $value_h){

        $row_col = ($row_col == "Result1") ? "Result2" : "Result1";  // 1->2, 2->1
        $href    = FC_DIR."sale/2-2-106.php?aord_id[0]=".$value_h["aord_id"]."&back_display=round"; // リンク先作成

        // 明細データ データ部の1行目のみ出力するヘッダ部データ その1
        $html_l .= "    <tr class=\"$row_col\">\n";
        $html_l .= "        <td align=\"right\">".++$row_num."</td>\n";                                                 // No.
        $html_l .= "        <td align=\"center\"><a href=\"$href\">".$value_h["ord_no"]."</a></td>\n";                  // 伝票番号
        $html_l .= "        <td align=\"center\">".$value_h["ord_time"]."</td>\n";                                      // 巡回日
        $html_l .= "        <td align=\"center\">".$value_h["arrival_day"]."</td>\n";                                   // 請求日
        $html_l .= "        <td>".$value_h["client_cd"]."<br>".htmlspecialchars($value_h["client_cname"])."<br></td>\n";// 得意先
        $html_l .= "        <td>".$value_h["act_cd"]."<br>".htmlspecialchars($value_h["act_name"])."<br></td>\n";       // 代行先
        $html_l .= "        <td>".$value_h["claim_cd"]."<br>".htmlspecialchars($value_h["claim_cname"])."<br></td>\n";  // 請求先
        $html_l .= "        <td align=\"center\">".$value_h["contract_div"]."</td>\n";                                  // 代行区分
        if ($value_h["charge_cd"] != null){
        $html_l .= "        <td>".$value_h["charge_cd"]." : ".htmlspecialchars($value_h["staff_name"])."</td>\n";       // 巡回担当者
        }else{
        $html_l .= "        <td></td>\n";
        }
        $html_l .= "        <td align=\"right\">".Font_Color($value_h["net_amount"])."</td>\n";                         // 税抜合計
        $html_l .= "        <td align=\"right\">".Font_Color($value_h["tax_amount"])."</td>\n";                         // 消費税
        $html_l .= "        <td align=\"right\">".Font_Color($value_h["net_tax_amount"])."</td>\n";                     // 伝票金額

        // データ部でループ
        foreach ($page_data_d as $key_d => $value_d){
            // ヘッダ部ループの受注IDとデータ部ループの受注IDが同じ場合（該当伝票のデータ部である場合）
            if ($value_h["aord_id"] == $value_d["aord_id"]){
                // データ部ループが1行目でない場合
                if ($value_d["line"] != "1"){
                    // 空tdを配置（12個）
                    $html_l .= "    <tr class=\"$row_col\">\n";
                    for ($i=0; $i<12; $i++){
                        // 明細データ ヘッダ部を出力しないデータ部データ その1（2行目以降のデータ部データ）
                        $html_l .= "        <td></td>\n";
                    }
                }
                // 明細データ データ部データ
                $html_l .= "        <td align=\"center\">".$value_d["sale_div_cd"]."</td>\n";                           // 販売区分
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["serv_print_flg"]."　".$value_d["serv_cd"]."<br>\n";                 // 印字/サービスコード
                $html_l .= "            ".htmlspecialchars($value_d["serv_name"])."<br>\n";                             // サービス名
                $html_l .= "        </td>\n";
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["goods_print_flg"]."　".$value_d["goods_cd"]."<br>\n";               // 印字/商品コード
                $html_l .= "            ".htmlspecialchars($value_d["official_goods_name"])."<br>\n";                   // 商品名
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">".$value_d["set_flg"].$value_d["num"]."</td>\n";                // 一式/数量
                $html_l .= "        <td align=\"right\">\n";
                $html_l .= "            ".Font_Color($value_d["cost_price"], 2)."<br>\n";                               // 営業原価
                $html_l .= "            ".Font_Color($value_d["sale_price"], 2)."<br>\n";                               // 売上単価
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">\n";                                                            
                $html_l .= "            ".Font_Color($value_d["cost_amount"])."<br>\n";                                 // 原価合計額
                $html_l .= "            ".Font_Color($value_d["sale_amount"])."<br>\n";                                 // 売上合計額
                $html_l .= "        </td>\n";
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["egoods_cd"]."<br>\n";                                               // 消耗品コード
                $html_l .= "            ".htmlspecialchars($value_d["egoods_name"])."<br>\n";                           // 消耗品名
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">".$value_d["egoods_num"]."</td>\n";                             // 数量
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["rgoods_cd"]."<br>\n";                                               // 本体商品コード
                $html_l .= "            ".htmlspecialchars($value_d["rgoods_name"])."<br>\n";                           // 本体商品名
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">".$value_d["rgoods_num"]."</td>\n";                             // 数量
                // データ部ループが1行目の場合
                if ($value_d["line"] == "1"){
                    // 明細データ データ部の1行目のみ出力するヘッダ部データ その2
                    $html_l .= "        <td align=\"center\">".$value_h["confirm_flg"]."</td>\n";                       // 承認
                    // オンラインかつ書き込み権限ありの場合
                    if ($value_h["contract_div"] == "オン" && $disabled == null){
                        $del_link   = "<a href=\"#\" onClick=\"return Dialogue_1('取消します。',".$value_h["aord_id"].",'hdn_cancel_id');\">取消</a>";
                    }else{
                        $del_link   = "";
                    }
                    $html_l .= "        <td align=\"center\">$del_link</td>\n";                                         // 取消リンク
                    $html_l .= "        <td align=\"center\">\n";                                                       // 承認チェックボックス
                    $html_l .= "            ".$form->_elements[$form->_elementIndex["form_slip_check[$key_h]"]]->toHtml()."\n";
                    $html_l .= "        </td>\n";
                // データ部ループが2行目以降の場合
                }else{
                    // 空tdを配置（3個）
                    for ($i=0; $i<3; $i++){
                        // 明細データ ヘッダ部を出力しないデータ部データ その2（2行目以降のデータ部データ）
                        $html_l .= "        <td></td>\n";
                    }
                }
                $html_l .= "    </tr>\n";
            }
        }
    }
    }

    // 最終行
    $html_l .= "    <tr class=\"Result3\">\n";
    for ($i=0; $i<24; $i++){
        $html_l .= "        <td></td>\n";
    }
    $html_l .= "        <td align=\"center\">".$form->_elements[$form->_elementIndex["form_confirm"]]->toHtml()."</td>\n";
    $html_l .= "    </tr>\n";

    $html_l .= "</table>\n";

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
//$page_menu = Create_Menu_f('sale','2');

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
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_buy'     => "$error_buy",
    'confirm_err'   => "$confirm_err",
    'reserve_del_err'   => "$reserve_del_err",
    'cancel_err'    => "$cancel_err",
    'renew_err'     => "$renew_err",
    'auth_r_msg'    => "$auth_r_msg",
    'disabled'      => "$disabled",
    'deli_day_renew_err'    => "$deli_day_renew_err",
    'claim_day_renew_err'   => "$claim_day_renew_err",
    'claim_day_bill_err'    => "$claim_day_bill_err",
    'group_kind'    => "$group_kind",
));

$smarty->assign("html_l", $html_l);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
