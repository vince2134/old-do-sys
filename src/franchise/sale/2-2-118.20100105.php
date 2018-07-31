<?php
/**
 *
 * 予定手書
 *
 *
 * @author      
 * @version     
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/06/07      要件64      kajioka-h   手書伝票発行を、予定手書用に変えた
 *  2007/06/11      B0702-060   kajioka-h   変更のときに倉庫名がサニタイジングされていないバグ修正
 *  2007/06/13      その他14    kajioka-h   前受金、行クリア
 *  2007/06/20      xx-xxx      kajioka-h   伝票複写
 *  2007/07/03      xx-xxx      kajioka-h   伝票番号を付番しないように仕様変更
 *                  B0702-068   kajioka-h   変更画面で得意先、代行先が変更できないバグ修正
 *  2007/08/29                  kajioka-h   代行伝票で代行料が売上％ので一式○の場合、原価合計額は原価単価と同じにする
 *  2007/11/28                  kajioka-h   代行伝票で代行料が固定額の場合、クエリエラーになるバグ修正
 *                              kajioka-h   代行伝票で代行先を入力せずに登録しようとすると警告が表示されるバグ修正
 *  2009/09/09                  aoyama-n    値引機能追加
 *  2009/09/09                  aoyama-n    消耗品と本体商品の品名変更フラグ抽出条件ミス修正
 *  2009/10/06      rev.1.3     kajioka-h   予定巡回日の訂正時に2ヶ月以上前だと警告メッセージ追加
 *  2009/12/22                  aoyama-n    税率をTaxRateクラスから取得
 *
 */

$page_title = "予定手書伝票発行";

//環境設定ファイル
require_once("ENV_local.php");

//取引区分の関数
require_once(PATH ."function/trade_fc.fnc");

//構成品、自動POSTあたりの関数
require_once(INCLUDE_DIR ."function_keiyaku.inc");

//エラーメッセージの外部ファイル
require_once(INCLUDE_DIR ."error_msg_list.inc");

//集計日報ID登録＆取得関数
require_once(INCLUDE_DIR ."daily_slip.inc");


//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB接続
$db_con = Db_Connect();
//請求チームの勝手に日次更新対策
//$db_con = (strpos($_SERVER["PHP_SELF"], "demo") !== false) ? Db_Connect() : Db_Connect("amenity_kaji_make");
//echo "<font color=red style=\"font-family: 'HGS行書体';\"><b>編集中につき、あまり登録できません</b></font>";


// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

// GETしたIDの正当性チェック
if (Get_Id_Check_Db($db_con, $_GET["aord_id"], "aord_id", "t_aorder_h", "num") == false && $_GET["aord_id"] != null){
    Header("Location: ../top.php");
    exit;
}

/*****************************/ 
// 再遷移先をSESSIONにセット
/*****************************/
// GET、POSTが無い場合
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("contract");
}


/****************************/
//外部変数取得
/****************************/
$shop_id     = $_POST["hdn_cclient_id"];
$intro_account_id   = $_POST["hdn_intro_account_id"];
$client_h_id = $_SESSION["client_id"];
$rank_cd     = $_SESSION["rank_cd"];
$e_staff_id  = $_SESSION["staff_id"];
$group_kind  = $_SESSION["group_kind"];
//$sale_id     = $_GET["sale_id"];     //売上ID
//Get_Id_Check3($sale_id);
$aord_id     = $_GET["aord_id"];     //受注ID
$done_flg    = $_GET["done_flg"];     //登録完了フラグ
$slip_del_flg = $_GET["slip_del_flg"];  //伝票削除フラグ
//$hand_slip_flg = true;                  //手書伝票フラグ
$hand_plan_flg = true;                  //予定手書フラグ

$back_display = $_GET["back_display"];   //予定明細の遷移元
//予定データ明細で表示する該当日の全ての受注ID
if($_POST["aord_id_array"] != null){
    $array_id = $_POST["aord_id_array"];
}elseif($_GET["aord_id_array"] != null){
    $array_id   = $_GET["aord_id_array"];
}
//アンシリアライズ化
$aord_id_array = stripslashes($array_id);
$aord_id_array = urldecode($aord_id_array);
$aord_id_array = unserialize($aord_id_array);
//print_array($aord_id_array);



//受注IDをhiddenにより保持する
if($_GET["aord_id"] != NULL){
    if($_GET["slip_copy"] != "true"){
        $set_id_data["hdn_aord_id"] = $aord_id;
        $form->setConstants($set_id_data);
    }
}else{
    $aord_id = $_POST["hdn_aord_id"];
}

//巡回区分
$contract_div = ($_POST["daiko_check"] == "1" || $_POST["daiko_check"] == null) ? "1" : $_POST["daiko_check"];
//print_array($contract_div, "巡回区分");


$error_flg = false;

#2009-12-22 aoyama-n
//税率クラス　インスタンス生成
$tax_rate_obj = new TaxRate($client_h_id);


/****************************/
// 日次更新済か
/****************************/

//売上確定済、または削除済の場合するよ
if($aord_id != null){
    $sql  = "SELECT confirm_flg FROM t_aorder_h WHERE aord_id = $aord_id AND ";
    $sql .= ($group_kind == "2") ? "shop_id IN (".Rank_Sql().");" : "shop_id = $client_h_id;";
    $result = Db_Query($db_con, $sql);
    //Get_Id_Check($result);
    if(pg_num_rows($result) != 0){
        if(pg_fetch_result($result, 0, "confirm_flg") == "t"){
            $renew_flg = "true";
            //if($_POST["hdn_comp_button"] == "Ｏ　Ｋ"){
			//rev.1.3 予定巡回日2ヶ月以上離れている無視ボタン押下時追加
            if($_POST["hdn_comp_button"] == "Ｏ　Ｋ" || $_POST["form_lump_change_warn"] == "警告を無視して訂正"){
                $slip_renew_mess = $h_mess[48];
                $error_flg = true;
            }
        }else{
            $renew_flg = "false";
        }
    }else{
        $renew_flg = "false";
    }
}else{
    $renew_flg = "false";
}

if($renew_flg == "true"){
    $form->freeze();
}


/****************************/
//初期設定
/****************************/
//表示行数
//if($_POST["max_row"] != null){
//    $max_row = $_POST["max_row"];
//}else{
    $max_row = 5;
//}
//得意先が指定されているか
//if($_POST["hdn_client_id"] == null || $_POST["hdn_ware_id"] == null){
if($_POST["hdn_client_id"] == null){
    $warning = "得意先を選択してください。";

}else{
    $warning = null;
    $client_id    = $_POST["hdn_client_id"];
    $ware_id      = $_POST["hdn_ware_id"];
    $coax         = $_POST["hdn_coax"];
    $tax_franct   = $_POST["hdn_tax_franct"];
    $client_shop_id = $_POST["client_shop_id"];
    $client_name  = $_POST["form_client"]["name"];

}


//受注変更判定
if($aord_id != NULL && $client_id == NULL && $done_flg != "true"){
    //受注ヘッダ取得SQL
    $sql  = "SELECT \n";
    $sql .= "    t_aorder_h.ord_no, \n";            // 0 受注番号
    $sql .= "    t_aorder_h.client_id, \n";         // 1 得意先ID
    $sql .= "    t_aorder_h.client_cd1, \n";        // 2 得意先CD1
    $sql .= "    t_aorder_h.client_cd2, \n";        // 3 得意先CD2
    $sql .= "    t_aorder_h.client_cname, \n";      // 4 得意先名（略称）
    $sql .= "    t_aorder_h.ord_time, \n";          // 5 予定巡回日
    $sql .= "    t_aorder_h.arrival_day, \n";       // 6 請求日
    $sql .= "    t_aorder_h.ware_id, \n";           // 7 出荷倉庫ID
    $sql .= "    t_aorder_h.trade_id, \n";          // 8 取引区分
    $sql .= "    t_aorder_h.note, \n";              // 9 備考
    $sql .= "    t_aorder_h.shop_id, \n";           //10 ショップID
    $sql .= "    t_aorder_h.claim_id, \n";          //11 請求先ID
    $sql .= "    t_aorder_h.claim_div, \n";         //12 請求先区分
    $sql .= "    t_aorder_h.enter_day, \n";         //13 登録日
    $sql .= "    t_aorder_h.intro_account_id, \n";  //14 紹介者ID
    $sql .= "    t_aorder_h.intro_ac_cd1, \n";      //15 紹介者CD1
    $sql .= "    t_aorder_h.intro_ac_cd2, \n";      //16 紹介者CD2
    $sql .= "    t_aorder_h.intro_ac_name, \n";     //17 紹介者名
    $sql .= "    t_aorder_h.intro_ac_div, \n";      //18 紹介料区分
    $sql .= "    t_aorder_h.intro_ac_price, \n";    //19 紹介料（固定）
    $sql .= "    t_aorder_h.intro_ac_rate, \n";     //20 紹介料（率）
    $sql .= "    t_aorder_h.act_id, \n";            //21 代行者ID
    $sql .= "    t_aorder_h.act_cd1, \n";           //22 代行者CD1
    $sql .= "    t_aorder_h.act_cd2, \n";           //23 代行者CD2
    $sql .= "    t_aorder_h.act_name, \n";          //24 代行者名
    $sql .= "    t_aorder_h.act_div, \n";           //25 代行料区分
    $sql .= "    t_aorder_h.act_request_price, \n"; //26 代行料（固定）
    $sql .= "    t_aorder_h.act_request_rate, \n";  //27 代行料（率）
    $sql .= "    t_aorder_h.contract_div, \n";      //28 契約区分
    $sql .= "    t_aorder_h.reason_cor, \n";        //29 訂正理由
    $sql .= "    t_aorder_h.route, \n";             //30 順路
    $sql .= "    t_aorder_staff1.staff_id, \n";     //31 巡回者メイン1
    $sql .= "    t_aorder_staff1.sale_rate, \n";    //32 売上率メイン1
    $sql .= "    t_aorder_staff2.staff_id, \n";     //33 巡回者サブ2
    $sql .= "    t_aorder_staff2.sale_rate, \n";    //34 売上率サブ2
    $sql .= "    t_aorder_staff3.staff_id, \n";     //35 巡回者サブ3
    $sql .= "    t_aorder_staff3.sale_rate, \n";    //36 売上率サブ3
    $sql .= "    t_aorder_staff4.staff_id, \n";     //37 巡回者サブ4
    $sql .= "    t_aorder_staff4.sale_rate, \n";    //38 売上率サブ4
    $sql .= "    t_aorder_h.ware_name, \n";         //39 出荷倉庫名
    $sql .= "    t_aorder_h.net_amount, \n";        //40 売上金額（税抜）
    $sql .= "    t_aorder_h.tax_amount, \n";        //41 消費税額
    $sql .= "    t_aorder_h.direct_id, \n";         //42 直送先ID
    $sql .= "    t_aorder_h.advance_offset_totalamount ";   //43 前受金相殺額合計

    $sql .= "FROM \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "    LEFT JOIN t_aorder_staff AS t_aorder_staff1 ON t_aorder_h.aord_id = t_aorder_staff1.aord_id \n";
    $sql .= "        AND t_aorder_staff1.staff_div = '0' \n";
    $sql .= "    LEFT JOIN t_aorder_staff AS t_aorder_staff2 ON t_aorder_h.aord_id = t_aorder_staff2.aord_id \n";
    $sql .= "        AND t_aorder_staff2.staff_div = '1' \n";
    $sql .= "    LEFT JOIN t_aorder_staff AS t_aorder_staff3 ON t_aorder_h.aord_id = t_aorder_staff3.aord_id \n";
    $sql .= "        AND t_aorder_staff3.staff_div = '2' \n";
    $sql .= "    LEFT JOIN t_aorder_staff AS t_aorder_staff4 ON t_aorder_h.aord_id = t_aorder_staff4.aord_id \n";
    $sql .= "        AND t_aorder_staff4.staff_div = '3' \n";
    $sql .= "WHERE \n";
    if($group_kind == "2"){
        $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().")\n";
    }else{
        $sql .= "    t_aorder_h.shop_id = $client_h_id ";
    }
    $sql .= "    AND \n";
    $sql .= "    t_aorder_h.aord_id = $aord_id \n";
    $sql .= ";";
//print_array($sql, "受注ヘッダ抽出SQL");

    $result = Db_Query($db_con, $sql);

    //GETデータ判定
    Get_Id_Check($result);
    $h_data_list = Get_Data($result, 2);
//print_array($h_data_list);

    //受注データ取得SQL
    $sql  = "SELECT \n";
    $sql .= "    t_aorder_d.aord_d_id, \n";         // 0 受注データID
    $sql .= "    t_aorder_d.aord_id, \n";           // 1 受注ID
    $sql .= "    t_aorder_d.line, \n";              // 2 行番号
    $sql .= "    t_aorder_d.sale_div_cd, \n";       // 3 販売区分
    $sql .= "    t_aorder_d.serv_print_flg, \n";    // 4 サービス印字フラグ
    $sql .= "    t_aorder_d.serv_id, \n";           // 5 サービスID
    $sql .= "    t_aorder_d.serv_name, \n";         // 6 サービス名
    $sql .= "    t_aorder_d.serv_cd, \n";           // 7 サービスCD
    $sql .= "    t_aorder_d.goods_print_flg, \n";   // 8 アイテム印字フラグ
    $sql .= "    t_aorder_d.goods_id, \n";          // 9 アイテムID
    $sql .= "    t_aorder_d.goods_cd, \n";          //10 アイテムCD
    $sql .= "    t_aorder_d.official_goods_name, \n";   //11 アイテム名（正式）
    $sql .= "    t_aorder_d.goods_name, \n";        //12 アイテム名（略称）
    $sql .= "    t_goods.name_change, \n";          //13 品名変更
    $sql .= "    t_aorder_d.tax_div, \n";           //14 課税区分
    $sql .= "    t_aorder_d.num, \n";               //15 数量
    $sql .= "    t_aorder_d.set_flg, \n";           //16 一式フラグ
    $sql .= "    t_aorder_d.cost_price, \n";        //17 営業原価
    $sql .= "    t_aorder_d.sale_price, \n";        //18 売上単価
    $sql .= "    t_aorder_d.cost_amount, \n";       //19 原価合計
    $sql .= "    t_aorder_d.sale_amount, \n";       //20 売上合計
    $sql .= "    t_aorder_d.egoods_id, \n";         //21 消耗品ID
    $sql .= "    t_aorder_d.egoods_cd, \n";         //22 消耗品CD
    $sql .= "    t_aorder_d.egoods_name, \n";       //23 消耗品名
    $sql .= "    t_aorder_d.egoods_num, \n";        //24 消耗品数
    $sql .= "    t_goods2.name_change, \n";         //25 消耗品名変更
    $sql .= "    t_aorder_d.rgoods_id, \n";         //26 本体商品ID
    $sql .= "    t_aorder_d.rgoods_cd, \n";         //27 本体商品CD
    $sql .= "    t_aorder_d.rgoods_name, \n";       //28 本体商品名
    $sql .= "    t_aorder_d.rgoods_num, \n";        //29 本体商品数
    $sql .= "    t_goods3.name_change, \n";         //30 本体商品名変更
    $sql .= "    t_aorder_d.account_price, \n";     //31 口座単価
    $sql .= "    t_aorder_d.account_rate, \n";      //32 口座率
    $sql .= "    t_aorder_d.advance_flg, \n";           //33 前受相殺フラグ
    //aoyama-n 2009-09-09
    #$sql .= "    t_aorder_d.advance_offset_amount \n";  //34 前受相殺額
    $sql .= "    t_aorder_d.advance_offset_amount, \n";  //34 前受相殺額
    $sql .= "    t_goods.discount_flg \n";               //35 値引フラグ

    $sql .= "FROM \n";
    $sql .= "    t_aorder_d \n";
    $sql .= "    LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id \n";
    //aoyama-n 2009-09-09
    //消耗品と本体商品の品名変更フラグ抽出条件ミス修正
    #$sql .= "    LEFT JOIN t_goods AS t_goods2 ON t_aorder_d.goods_id = t_goods2.goods_id \n";
    #$sql .= "    LEFT JOIN t_goods AS t_goods3 ON t_aorder_d.goods_id = t_goods3.goods_id \n";
    $sql .= "    LEFT JOIN t_goods AS t_goods2 ON t_aorder_d.egoods_id = t_goods2.goods_id \n";
    $sql .= "    LEFT JOIN t_goods AS t_goods3 ON t_aorder_d.rgoods_id = t_goods3.goods_id \n";

    $sql .= "WHERE \n";
    $sql .= "    aord_id = $aord_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "    t_aorder_d.line \n";
    $sql .= ";";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    $data_list = Get_Data($result, 2);

    //得意先の情報を抽出
    $sql  = "SELECT";
    $sql .= "   t_client.client_id,";
    $sql .= "   t_client.coax,";
    $sql .= "   t_client.tax_franct,";
    $sql .= "   t_client_info.cclient_shop ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= "   INNER JOIN t_client_info ON t_client_info.client_id = t_client.client_id ";
    $sql .= " WHERE";
    $sql .= "   t_client.client_id = ".$h_data_list[0][1];
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $client_list = Get_Data($result, 2);


    //--------------------------//
    //フォームに値を復元
    //--------------------------//
    $sale_money = NULL;                        //商品の売上金額
    $tax_div    = NULL;                        //課税区分

    //ヘッダー復元
    $update_goods_data["form_sale_no"]                   = $h_data_list[0][0];       //伝票番号

    $update_goods_data["form_client"]["cd1"]            = $h_data_list[0][2];       //得意先コード１
    $update_goods_data["form_client"]["cd2"]            = $h_data_list[0][3];       //得意先コード２
    $update_goods_data["form_client"]["name"]           = $h_data_list[0][4];       //得意先名

    //予定巡回日を年月日に分ける
    $ex_sale_day = explode('-',$h_data_list[0][5]);
    $update_goods_data["form_delivery_day"]["y"]        = $ex_sale_day[0];          //予定巡回日
    $update_goods_data["form_delivery_day"]["m"]        = $ex_sale_day[1];
    $update_goods_data["form_delivery_day"]["d"]        = $ex_sale_day[2];
    $update_goods_data["hdn_former_deli_day"]           = $h_data_list[0][5];		//rev.1.3 変更前の予定巡回日をhiddenに保持

    //請求日を年月日に分ける
    $ex_claim_day = explode('-',$h_data_list[0][6]);
    $update_goods_data["form_request_day"]["y"]         = $ex_claim_day[0];         //請求日
    $update_goods_data["form_request_day"]["m"]         = $ex_claim_day[1];
    $update_goods_data["form_request_day"]["d"]         = $ex_claim_day[2];

    $update_goods_data["hdn_ware_name"]                 = htmlspecialchars($h_data_list[0][39]);    //出荷倉庫名
    //（htmlspecialcharsしないとダメっぽい　hidden → JS → 画面　だから？）
    $update_goods_data["hdn_ware_id"]                   = $h_data_list[0][7];       //出荷倉庫ID
    $update_goods_data["trade_aord"]                    = $h_data_list[0][8];       //取引区分
    $update_goods_data["form_note"]                     = $h_data_list[0][9];       //備考

    $update_goods_data["hdn_cclient_id"]                = $h_data_list[0][10];      //ショップID（担当支店ID）
    $update_goods_data["form_claim"]                    = $h_data_list[0][11].",".$h_data_list[0][12];  //請求先

    $update_goods_data["hdn_enter_day"]                 = $h_data_list[0][13];      //登録日

    $intro_account_id                                   = $h_data_list[0][14];      //紹介者ID
    $update_goods_data["hdn_intro_account_id"]          = $intro_account_id;
    $intro_ac_div                                       = $h_data_list[0][18];      //紹介料区分
    $update_goods_data["intro_ac_div[]"]                = $intro_ac_div;
    $update_goods_data["intro_ac_price"]                = $h_data_list[0][19];      //紹介料（固定）
    $update_goods_data["intro_ac_rate"]                 = $h_data_list[0][20];      //紹介料（率）

    $act_id                                             = $h_data_list[0][21];      //代行者ID
    $update_goods_data["hdn_daiko_id"]                  = $act_id;
    $update_goods_data["form_daiko"]["cd1"]             = $h_data_list[0][22];      //代行者CD1
    $update_goods_data["form_daiko"]["cd2"]             = $h_data_list[0][23];      //代行者CD2
    $update_goods_data["form_daiko"]["name"]            = $h_data_list[0][24];      //代行者名（略称）
    $update_goods_data["act_div[]"]                     = $h_data_list[0][25];      //代行料区分
    $update_goods_data["act_request_price"]             = $h_data_list[0][26];      //代行依頼料（固定額）
    $update_goods_data["act_request_rate"]              = $h_data_list[0][27];      //代行依頼料（％）

    //代行先がある場合、代行先のまるめ区分を取得
    if($act_id != null){
        $sql = "SELECT coax FROM t_client WHERE client_id = $act_id;";
        $result = Db_Query($db_con, $sql);
        $daiko_coax = pg_fetch_result($result, 0, "coax");
        $update_goods_data["hdn_daiko_coax"] = $daiko_coax;
    }


    $contract_div = ($_POST["daiko_check"] != null) ? $contract_div : $h_data_list[0][28];  //契約区分
    $update_goods_data["daiko_check"]                   = $contract_div;

    $update_goods_data["form_reason"]                   = $h_data_list[0][29];      //訂正理由

    $h_data_list[0][30]                                 = str_pad($h_data_list[0][30], 4, 0, STR_PAD_LEFT); //順路
    $update_goods_data["form_route_load"][1]            = substr($h_data_list[0][30], 0, 2);
    $update_goods_data["form_route_load"][2]            = substr($h_data_list[0][30], 2, 2);

    $update_goods_data["form_c_staff_id1"]              = $h_data_list[0][31];      //巡回者メイン1
    $update_goods_data["form_sale_rate1"]               = $h_data_list[0][32];      //売上率メイン1
    $update_goods_data["form_c_staff_id2"]              = $h_data_list[0][33];      //巡回者サブ2
    $update_goods_data["form_sale_rate2"]               = $h_data_list[0][34];      //売上率サブ2
    $update_goods_data["form_c_staff_id3"]              = $h_data_list[0][35];      //巡回者サブ3
    $update_goods_data["form_sale_rate3"]               = $h_data_list[0][36];      //売上率サブ3
    $update_goods_data["form_c_staff_id4"]              = $h_data_list[0][37];      //巡回者サブ4
    $update_goods_data["form_sale_rate4"]               = $h_data_list[0][38];      //売上率サブ4

    $update_goods_data["form_direct_select"]            = $h_data_list[0][42];      //直送先


    //データ復元
    $loop_num = count($data_list);
    for($i=0; $i<$loop_num; $i++){
        $update_line = $data_list[$i][2];

        //紹介料区分の初期値を設定しない行配列
        $aprice_array[] = $update_line;

        $update_goods_data["form_divide"][$update_line]             = $data_list[$i][3];        //販売区分

        //$update_goods_data["form_print_flg1"][$update_line]         = ($data_list[$i][4] == "t") ? "1" : "";    //サービス印字フラグ
        //if($_POST["check_value_flg"] == "t"){
        //}
        $update_goods_data["form_serv"][$update_line]               = $data_list[$i][5];        //サービスID

        //$update_goods_data["form_print_flg2"][$update_line]         = ($data_list[$i][8] == "t") ? "1" : "";    //アイテム印字フラグ
        //if($_POST["check_value_flg"] == "t"){
        //}
        $update_goods_data["hdn_goods_id1"][$update_line]           = $data_list[$i][9];        //アイテムID
        $update_goods_data["form_goods_cd1"][$update_line]          = $data_list[$i][10];       //アイテムCD
        $update_goods_data["official_goods_name"][$update_line]     = $data_list[$i][11];       //アイテム名（正式）
        $update_goods_data["form_goods_name1"][$update_line]        = $data_list[$i][12];       //アイテム名（略称）
        $update_goods_data["hdn_name_change1"][$update_line]        = $data_list[$i][13];       //品名変更フラグ
        $hdn_name_change[1][$update_line]                           = $data_list[$i][13];       //POSTする前に商品名の変更不可判定を行う為
        $update_goods_data["hdn_tax_div"][$update_line]             = $data_list[$i][14];       //課税区分

        $update_goods_data["form_goods_num1"][$update_line]         = $data_list[$i][15];       //数量
        //$update_goods_data["form_issiki"][$update_line]             = ($data_list[$i][16] == "t") ? "1" : "";   //一式

        //予定データ明細から来た場合にチェックボックスが復元されないため
        if($_POST["check_value_flg"] == "t"){
            $con_data["form_print_flg1"][$update_line]              = ($data_list[$i][4] == "t") ? "1" : "";    //サービス印字フラグ
            $con_data["form_print_flg2"][$update_line]              = ($data_list[$i][8] == "t") ? "1" : "";    //アイテム印字フラグ
            $con_data["form_issiki"][$update_line]                  = ($data_list[$i][16] == "t") ? "1" : "";   //一式
        }

        //原価単価を整数部と少数部に分ける
        $cost_mprice = explode('.', $data_list[$i][17]);
        $update_goods_data["form_trade_price"][$update_line]["1"]   = $cost_mprice[0];          //原価単価
        $update_goods_data["form_trade_price"][$update_line]["2"]   = ($cost_mprice[1] != null)? $cost_mprice[1] : "00";
        $update_goods_data["form_trade_amount"][$update_line]       = number_format($data_list[$i][19]);    //原価金額

        //売上単価を整数部と少数部に分ける
        $sale_mprice = explode('.', $data_list[$i][18]);
        $update_goods_data["form_sale_price"][$update_line]["1"]    = $sale_mprice[0];          //売上単価
        $update_goods_data["form_sale_price"][$update_line]["2"]    = ($sale_mprice[1] != null)? $sale_mprice[1] : "00";
        $update_goods_data["form_sale_amount"][$update_line]        = number_format($data_list[$i][20]);    //売上金額

        $update_goods_data["hdn_goods_id3"][$update_line]           = $data_list[$i][21];       //消耗品ID
        $update_goods_data["form_goods_cd3"][$update_line]          = $data_list[$i][22];       //消耗品CD
        $update_goods_data["form_goods_name3"][$update_line]        = $data_list[$i][23];       //消耗品名
        $update_goods_data["form_goods_num3"][$update_line]         = $data_list[$i][24];       //消耗品数
        $update_goods_data["hdn_name_change3"][$update_line]        = $data_list[$i][25];       //消耗品名変更フラグ
        $hdn_name_change[3][$update_line]                           = $data_list[$i][25];       //POSTする前に商品名の変更不可判定を行なう為

        $update_goods_data["hdn_goods_id2"][$update_line]           = $data_list[$i][26];       //本体商品ID
        $update_goods_data["form_goods_cd2"][$update_line]          = $data_list[$i][27];       //本体商品CD
        $update_goods_data["form_goods_name2"][$update_line]        = $data_list[$i][28];       //本体商品名
        $update_goods_data["form_goods_num2"][$update_line]         = $data_list[$i][29];       //本体商品数
        $update_goods_data["hdn_name_change2"][$update_line]        = $data_list[$i][30];       //本体商品名変更フラグ
        $hdn_name_change[2][$update_line]                           = $data_list[$i][30];       //POSTする前に商品名の変更不可判定を行なう為

        //紹介料
        if($intro_account_id != null){
            //口座単価ありの場合は「固定額」
            if($data_list[$i][31] != null && $data_list[$i][32] == null){
                $update_goods_data["form_aprice_div"][$update_line] = "2";
                $update_goods_data["form_account_price"][$update_line] = $data_list[$i][31];
            //口座率ありの場合は「売上の」
            }elseif($data_list[$i][31] == null && $data_list[$i][32] != null){
                $update_goods_data["form_aprice_div"][$update_line] = "3";
                $update_goods_data["form_account_rate"][$update_line] = $data_list[$i][32];
            //口座単価、口座率とも空の場合は「なし」
            }else{
                $update_goods_data["form_aprice_div"][$update_line] = "1";
            }
        //紹介者がない場合は「なし」
        }else{
            $update_goods_data["form_aprice_div"][$update_line] = "1";
        }

        $update_goods_data["form_ad_offset_radio"][$update_line]    = $data_list[$i][33];       //前受相殺フラグ
        $update_goods_data["form_ad_offset_amount"][$update_line]   = $data_list[$i][34];       //前受相殺額

        //aoyama-n 2009-09-09
        $update_goods_data["hdn_discount_flg"][$update_line]        = $data_list[$i][35];       //値引フラグ


        $sale_money[]   = $data_list[$i][20];   //売上金額合計
        $tax_div[]      = $data_list[$i][14];   //課税区分
    }

    //得意先情報復元
    $client_id      = $client_list[0][0];        //得意先ID
    $coax           = $client_list[0][1];        //丸め区分（金額）
    $tax_franct     = $client_list[0][2];        //端数区分（消費税）
    $client_shop_id = $client_list[0][3];        //得意先のショップID
    //$client_shop_id = $h_data_list[0][10];       //得意先のショップID
    $warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
    $update_goods_data["client_shop_id"]      = $client_shop_id;

/*
    //現在の消費税率
    $sql  = "SELECT ";
    $sql .= "    tax_rate_n ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_id = $client_shop_id;";
    $result = Db_Query($db_con, $sql); 
    $tax_num = pg_fetch_result($result, 0,0);

    $total_money = Total_Amount($sale_money, $tax_div, $coax, $tax_franct, $tax_num, $client_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);
*/
    $sale_money = number_format($h_data_list[0][40]);
    $tax_money  = number_format($h_data_list[0][41]);
    $st_money   = number_format($h_data_list[0][40] + $h_data_list[0][41]);
    $advance_offset_totalamount = ($h_data_list[0][43] == null) ? "" : number_format($h_data_list[0][43]);
    $ad_rest_price = number_format(Advance_Offset_Claim($db_con, $h_data_list[0][5], $client_id, $h_data_list[0][12]));

    //フォームに値セット
    $update_goods_data["form_sale_total"]      = $sale_money;
    $update_goods_data["form_sale_tax"]        = $tax_money;
    $update_goods_data["form_sale_money"]      = $st_money;
    $update_goods_data["form_ad_offset_total"] = $advance_offset_totalamount;
    $update_goods_data["form_ad_rest_price"]   = $ad_rest_price;
    $update_goods_data["sum_button_flg"]       = "";

    //新規登録フラグ
    if($_POST["hdn_new_entry"] == null){
        $new_entry = "false";
        $form->setDefaults(array("hdn_new_entry" => "false"));
    }else{
        $new_entry = $_POST["hdn_new_entry"];
    }

//print_array($update_goods_data, "update_goods_data");
    //$form->setConstants($update_goods_data);
    $form->setDefaults($update_goods_data);

    //予定データ明細から来た場合に、明示的にsetConstantsしないとチェックボックスが復元されない
    if($_POST["check_value_flg"] == "t"){
        $form->setConstants($con_data);
    }

    //予定データ明細の遷移元区分と、受注ID配列をhiddenに持たせる
    $array_id = serialize($aord_id_array);
    $array_id = urlencode($array_id);
    $form->setDefaults(
        array(
            "back_display" => $back_display,
            "aord_id_array" => $array_id,
        )
    );

/*
    //表示行数
    if($_POST["max_row"] != NULL){
        $max_row = $_POST["max_row"];
    }else{
        //受注データの数
        $max_row = count($data_list);
    }
*/
    $max_row = 5;

}else{
/*
    //自動採番の伝票番号取得
    //直営の場合
    if($group_kind == "2"){
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
    //FCの場合
    }else{
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $client_h_id;";
    }

    $result = Db_Query($db_con, $sql);
    $sale_no = pg_fetch_result($result, 0 ,0);
    $sale_no = $sale_no +1;
    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

    $def_data["form_sale_no"] = $sale_no;
*/

    //担当者
    //$def_data["form_ac_staff_select"] = $e_staff_id;

    //取引区分
    $def_data["trade_aord"] = 11;

    //売上計上日
    $def_data["form_delivery_day"]["y"] = date("Y");
    $def_data["form_delivery_day"]["m"] = date("m");
    $def_data["form_delivery_day"]["d"] = date("d");

    //請求日
    $def_data["form_request_day"]["y"] = date("Y");
    $def_data["form_request_day"]["m"] = date("m");
    $def_data["form_request_day"]["d"] = date("d");

    //出荷倉庫
/*
    //ログインユーザの担当支店の拠点倉庫を取得
    $sql  = "SELECT \n";
    $sql .= "    t_branch.bases_ware_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_branch \n";
    $sql .= "    INNER JOIN t_part ON t_branch.branch_id = t_part.branch_id \n";
    $sql .= "    INNER JOIN t_attach ON t_part.part_id = t_attach.part_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_attach.staff_id = $e_staff_id \n";
    $sql .= ";";

    $result = Db_Query($db_con,$sql);
    $def_ware_id = pg_fetch_result($result,0,0);

    $def_data["form_ware_select"] = $def_ware_id;
    $def_data["hdn_ware_id"]      = $def_ware_id;
*/

    //担当者（メイン1）の売上率を100に
    $def_data["form_sale_rate1"] = "100";

    //新規登録フラグ
    if($_POST["hdn_new_entry"] == null){
        $new_entry = "true";
        $form->setDefaults(array("hdn_new_entry" => "true"));
    }else{
        $new_entry = $_POST["hdn_new_entry"];
    }

    //紹介料区分
    $def_data["intro_ac_div[]"] = ($_POST["intro_ac_div"][0] != null) ? $_POST["intro_ac_div"][0] : "1" ;

    //代行料区分
    $def_data["act_div[]"] = ($_POST["act_div"][0] != null) ? $_POST["act_div"][0] : "1" ;

    //口座料
    //ラジオボタン指定配列初期化
    $aprice_array = array();


    //表示行数
    //if($_POST["max_row"] != NULL){
    //    $max_row = $_POST["max_row"];
    //}else{
        $max_row = 5;
    //}

}

//データが無い口座区分の初期値設定
for($i=1;$i<=5;$i++){
    if(!in_array($i, $aprice_array)) {
        //なし
        $def_data["form_aprice_div[$i]"] = "1";
        $def_data["form_ad_offset_radio"][$i] = "1";
    }
}


//複写追加の場合、新しい伝票番号を取得
if($_GET["slip_copy"] == "true"){
/*
    //自動採番の伝票番号取得
    //直営の場合
    if($_SESSION["group_kind"] == "2"){
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
    //FCの場合
    }else{
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = ".$_SESSION["client_id"].";";
    }

    $result = Db_Query($db_con, $sql);
    $sale_no = pg_fetch_result($result, 0 ,0);
    $sale_no = $sale_no +1;
    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

    $def_data["form_sale_no"] = $sale_no;
*/

    $aord_id = "";

/*
    //新規登録フラグ
    if($_POST["hdn_new_entry"] == null){
        $new_entry = "true";
        $form->setDefaults(array("hdn_new_entry" => "true"));
    }
*/

}


$form->setDefaults($def_data);



//初期表示位置変更
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//削除行数
$del_history[] = NULL; 

/****************************/
//行数追加処理
/****************************/
/*
if($_POST["add_row_flg"]==true){
    if($_POST["max_row"] == NULL){
        //初期値はPOSTが無い為、
        $max_row = 10;
    }else{
        //最大行に、＋１する
        $max_row = $_POST["max_row"]+5;
    }
    //行数追加フラグをクリア
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}
*/

/****************************/
//行削除処理
/****************************/
/*
if($_POST["del_row"] != ""){

    //削除リストを取得
    $del_row = $_POST["del_row"];

    //削除履歴を配列にする。
    $del_history = explode(",", $del_row);
    //削除した行数
    $del_num     = count($del_history)-1;
}
*/

//***************************/
//最大行数をhiddenにセット
/****************************/
/*
$max_row_data["max_row"] = $max_row;
$form->setConstants($max_row_data);
*/



/****************************/
//得意先コード入力処理
/****************************/
if($_POST["client_search_flg"] == true && $done_flg != "true"){
    $client_cd1         = $_POST["form_client"]["cd1"];       //得意先コード1
    $client_cd2         = $_POST["form_client"]["cd2"];       //得意先コード2

    //得意先の情報を抽出
    $sql  = "SELECT \n";
    $sql .= "    t_client.client_id, \n";               // 0
    $sql .= "    t_client.shop_id, \n";                 // 1
    $sql .= "    t_client.client_cname, \n";            // 2
    $sql .= "    t_client.coax, \n";                    // 3
    $sql .= "    t_client.tax_franct, \n";              // 4
    $sql .= "    t_client.rank_cd, \n";                 // 5
    $sql .= "    t_client_info.cclient_shop, \n";       // 6
    $sql .= "    t_client_info.intro_account_id, \n";   // 7
    $sql .= "    t_info_account.client_cname, \n";      // 8
    $sql .= "    t_client.trade_id \n";                 // 9 取引区分
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_client_info ON t_client.client_id = t_client_info.client_id \n";
    $sql .= "    LEFT JOIN t_client AS t_info_account ON t_client_info.intro_account_id = t_info_account.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_cd1 = '$client_cd1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_cd2 = '$client_cd2' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_div = '1' \n";
    $sql .= "    AND \n";
    if($group_kind == "2"){
        $sql .= "    t_client.shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "   t_client.shop_id = $client_h_id \n";
    }
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
    //該当データがある
    if($num == 1){
        $client_id      = pg_fetch_result($result, 0,0);        //得意先ID
        $client_shop_id = pg_fetch_result($result, 0,1);        //得意先のショップID
        $client_name    = pg_fetch_result($result, 0,2);        //得意先名（略称）
        $coax           = pg_fetch_result($result, 0,3);        //丸め区分（商品）
        $tax_franct     = pg_fetch_result($result, 0,4);        //端数区分（消費税）
        $rank_cd        = pg_fetch_result($result, 0,5);        //顧客区分コード
        $shop_id        = pg_fetch_result($result, 0,6);        //担当支店
        $intro_account_id   = pg_fetch_result($result, 0,7);    //紹介口座先ID
        $client_ac_name = pg_fetch_result($result, 0,8);        //紹介口座先名

        //取得したデータをフォームにセット
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = $client_id;
        $client_data["client_shop_id"]      = $client_shop_id;
        $client_data["form_client"]["name"] = $client_name;
        $client_data["hdn_coax"]            = $coax;
        $client_data["hdn_tax_franct"]      = $tax_franct;
        //$client_data["hdn_rank_cd"]         = $rank_cd;
        $client_data["hdn_cclient_id"]      = $shop_id;
        $client_data["hdn_intro_account_id"]    = ($intro_account_id != null) ? $intro_account_id : "";
        $client_data["form_intro_account_name"] = ($intro_account_id != null) ? $client_ac_name : "";

        $warning = null;

        $client_data["daiko_check"]         = $contract_div;    //代行区分
        $client_data["trade_aord"]          = pg_fetch_result($result, 0, 9);   //取引区分


        //------------------------------------//
        // 各行の金額を得意先のまるめで再計算 //
        //------------------------------------//
        //$cost_money  = NULL;    //商品の原価金額
        $sale_money  = NULL;    //商品の売上金額
        $tax_div_arr = NULL;    //課税区分

        for($i = 1; $i <= $max_row; $i++){
            //サービス、またはアイテムが入力されている行のみ取得
            if($_POST["form_serv"][$i] != null || $_POST["hdn_goods_id1"][$i] != null){

                //数量ありの場合、単価×数量＝金額
                if($_POST["form_goods_num1"][$i] != null){
                    $price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];
                    $price = $price * $_POST["form_goods_num1"][$i];
                //数量なしの場合、金額＝0
                }else{
                    $price = 0;
                }
                //原価金額をまるめ
                if($contract_div == "1" || $_POST["hdn_daiko_id"] == null){
                    //自社巡回、または代行だけど代行先が指定されてない場合は得意先のまるめ区分
                    $price = Coax_Col($coax, $price);
                }elseif($_POST["hdn_daiko_id"] != null){
                    //代行伝票で、代行先が指定されている場合は代行先のまるめ区分
                    $price = Coax_Col($_POST["hdn_daiko_coax"], $price);
                }

                $client_data["form_trade_amount"][$i] = number_format($price);  //原価金額フォームに表示
                //$cost_money[] = $price;


                //売上単価から売上金額を計算
                if($_POST["form_issiki"][$i] != null){
                    //一式にチェックがある場合、単価×１＝金額
                    $price = $_POST["form_sale_price"][$i][1].".".$_POST["form_sale_price"][$i][2];
                }elseif($_POST["form_goods_num1"][$i] != null){
                    //一式なし、数量ありの場合、単価×数量＝金額
                    $price = $_POST["form_sale_price"][$i][1].".".$_POST["form_sale_price"][$i][2];
                    $price = $price * $_POST["form_goods_num1"][$i];
                }else{
                    //一式なし、数量なしの場合、金額＝0
                    $price = 0;
                }
                //売上金額をまるめ
                $price = Coax_Col($coax, $price);

                $client_data["form_sale_amount"][$i] = number_format($price);   //売上金額フォームに表示
                $sale_money[] = $price;


                //アイテムが入力されている場合はアイテムの課税区分を取得
                if($_POST["hdn_goods_id1"][$i] != null){
                    $sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
                //アイテムがない場合はサービスの課税区分を取得
                }else{
                    $sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
                }

                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);    //課税区分を配列につめる
            }
        }

        #2009-12-22 aoyama-n
        #$tax_num = Get_Tax_Rate($db_con, $shop_id);     //得意先の（旧）担当支店の消費税率を取得

        #2009-12-22 aoyama-n
        $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
        $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

/*
        //自社巡回、または代行だけど代行先が指定されてない場合、原価は得意先の丸めでまるめ
        if($contract_div == "1" || $_POST["hdn_daiko_id"] == null){
            $total_money = Total_Amount($cost_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);

        //代行の場合、原価は代行先の丸めでまるめ
        }else{
            $total_money = Total_Amount($cost_money, $tax_div_arr, $_POST["hdn_daiko_coax"], $tax_franct, $tax_num, $client_id, $db_con);
        }
        $cost_money  = $total_money[0];     //原価金額（税抜）
*/

        $total_money = Total_Amount($sale_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);
        $sale_money  = $total_money[0];     //売上金額（税抜）
        $sale_tax    = $total_money[1];     //消費税額

        //フォームに値セット
        $client_data["form_sale_total"]   = number_format($sale_money);
        $client_data["form_sale_tax"]     = number_format($sale_tax);
        $client_data["form_sale_money"]   = number_format($sale_money + $sale_tax);
        //$client_data["form_ad_offset_total"] = $ad_offset_total;

    }else{
        $warning = "得意先を選択してください。";
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = "";
        $client_data["client_shop_id"]      = "";
        $client_data["form_client"]["name"] = "";
        $client_data["hdn_coax"]            = "";
        $client_data["hdn_tax_franct"]      = "";
        //$client_data["hdn_rank_cd"]         = "";
        $client_data["hdn_cclient_id"]      = "";
        $client_data["hdn_intro_account_id"]    = "";
        $intro_account_id                   = "";
        $client_data["form_intro_account_name"] = "";
        $client_id                          = null;      //得意先ID

        $client_data["daiko_check"]         = $contract_div;    //代行区分
        $client_data["trade_aord"]          = 11;       //取引区分

    }
/*
    //前に入力された値を初期化
    for($i = 1; $i <= $max_row; $i++){
        //受注データ
        $client_data["hdn_tax_div"][$i]             = "";
        //$client_data["form_sale_num"][$i]          = "";
        $client_data["form_goods_num1"][$i]         = "";
        $client_data["form_trade_price"]["$i"]["1"] = "";
        $client_data["form_trade_price"]["$i"]["2"] = "";
        $client_data["form_trade_amount"][$i]       = "";
        $client_data["form_sale_price"]["$i"]["1"]  = "";
        $client_data["form_sale_price"]["$i"]["2"]  = "";
        $client_data["form_sale_amount"][$i]        = "";
        //$client_data["form_aorder_num"][$i]        = "";
        $client_data["form_divide"][$i]             = "";
        $client_data["form_serv"][$i]               = "";
        //$client_data["form_stock_num"][$i]         = "";
        $client_data["form_issiki"][$i]             = "";
        $client_data["form_print_flg1"][$i]         = "";
        $client_data["form_print_flg2"][$i]         = "";

        for($j=1;$j<=3;$j++){
            $client_data["hdn_goods_id".$j][$i]         = "";
            $client_data["form_goods_cd".$j][$i]        = "";
            $client_data["form_goods_name".$j][$i]      = "";
            $client_data["hdn_name_change".$j][$i]      = "";
            $client_data["form_goods_num".$j][$i]       = "";
        }
        $client_data["official_goods_name"][$i]     = "";
        $client_data["form_aprice_div"][$i]         = "1";
        $client_data["form_account_price"][$i]      = "";
        $client_data["form_account_rate"][$i]       = "";
        $client_data["form_ad_offset_radio"][$i]    = "1";
        $client_data["form_ad_offset_amount"][$i]   = "";
    }
    $client_data["del_row"]             = "";        //削除行番号
    $client_data["max_row"]             = "";        //行数
    $client_data["form_sale_total"]     = "";        //税抜金額
    $client_data["form_sale_tax"]       = "";        //消費税
    $client_data["form_sale_money"]     = "";        //税込金額
    $client_data["show_button_flg"]     = "";        //表示ボタン
    $client_data["form_ad_offset_total"]= "";       //前受金相殺額合計
*/
    $client_data["form_ad_rest_price"]  = "";       //前受金残高

    $client_data["daiko_check"]         = $contract_div;    //代行区分

    $form->setConstants($client_data);
}


//紹介者がFCか仕入先か判定
if($intro_account_id != null){
    $sql = "SELECT client_cd1, client_cd2, client_cname, client_div FROM t_client WHERE client_id = $intro_account_id;";
    $result = Db_Query($db_con, $sql);
    //仕入先の場合、紹介者CD1のみ
    if(pg_fetch_result($result, 0, "client_div") == "2"){
        $ac_name = pg_fetch_result($result, 0, "client_cd1")."<br>".htmlspecialchars(pg_fetch_result($result, 0, "client_cname"));
    }else{
        $ac_name = pg_fetch_result($result, 0, "client_cd1")."-".pg_fetch_result($result, 0, "client_cd2")."<br>".htmlspecialchars(pg_fetch_result($result, 0, "client_cname"));
    }
//紹介者がない場合
}else{
    $ac_name = "無し";
    $con_data2["intro_ac_div[]"] = 1;
}


/****************************/
//受託先入力
/****************************/
$daiko_cd1 = $_POST["form_daiko"]["cd1"];   //代行コード1
$daiko_cd2 = $_POST["form_daiko"]["cd2"];   //代行コード2

//ダイアログ入力orPOSTにコードがある場合
if($_POST["daiko_search_flg"] == true && $contract_div != "1" && $done_flg != "true"){

    //受託先の情報を抽出
    $sql  = "SELECT \n";
    $sql .= "    t_client.client_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_cd1 = '$daiko_cd1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_cd2 = '$daiko_cd2' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_div = '3' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.state = '1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_rank.group_kind = '3' \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
    //該当データがある
    if($num == 1){
        //データあり
        $act_id = pg_fetch_result($result, 0, 0);     //受託先ID
        $con_data2["hdn_daiko_id"] = $act_id;

        //代行先の情報を抽出
        $sql  = "SELECT \n";
        $sql .= "    t_client.client_cname, \n";
        $sql .= "    t_client.client_cd1, \n";
        $sql .= "    t_client.client_cd2, \n";
        $sql .= "    t_client.coax \n";
        $sql .= "FROM \n";
        $sql .= "    t_client \n";
        $sql .= "WHERE \n";
        $sql .= "    t_client.client_id = $act_id \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        Get_Id_Check($result);
        $data_list = Get_Data($result, 2);

        $daiko_cname    = $data_list[0][0];        //社名
        $daiko_cd1      = $data_list[0][1];        //代行CD1
        $daiko_cd2      = $data_list[0][2];        //代行CD2
        $daiko_coax     = $data_list[0][3];        //代行の丸め区分

        //POST情報変更
        $con_data2["form_daiko"]["cd1"]  = $daiko_cd1;
        $con_data2["form_daiko"]["cd2"]  = $daiko_cd2;
        $con_data2["form_daiko"]["name"] = $daiko_cname;
        $con_data2["hdn_daiko_coax"]     = $daiko_coax;
        $con_data2["daiko_search_flg"]   = "";


        //委託先のまるめ区分で営業金額を再計算
        for($i=1; $i<=$max_row; $i++){

            if($_POST["form_trade_price"][$i][1] != null || $_POST["form_trade_price"][$i][2] != null){
                $t_price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];

                //金額計算処理判定
                if($_POST["form_goods_num1"][$i] != null){
                //数量○の場合、営業金額は、単価×数量。
                    //営業金額
                    $t_amount = bcmul($t_price, $_POST["form_goods_num1"][$i], 2);
                    $t_amount = Coax_Col($daiko_coax, $t_amount);

                //数量×の場合、単価×１
                }else{
                    //営業金額
                    $t_amount = bcmul($t_price, 1, 2);
                    $t_amount = Coax_Col($daiko_coax, $t_amount);
                }

                //合計金額フォームにセット
                $con_data2["form_trade_amount"][$i] = number_format($t_amount);

            }
        }


    //代行先が存在しない場合、POST情報初期化
    }else{
        $con_data2["hdn_daiko_id"]       = "";
        $con_data2["form_daiko"]["cd1"]  = "";
        $con_data2["form_daiko"]["cd2"]  = "";
        $con_data2["form_daiko"]["name"] = "";
        $con_data2["hdn_daiko_coax"]     = "";
        $con_data2["daiko_search_flg"]   = "";


        //得意先のまるめ区分で営業金額を再計算
        for($i=1; $i<=$max_row; $i++){

            if($_POST["form_trade_price"][$i][1] != null || $_POST["form_trade_price"][$i][2] != null){
                $t_price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];

                //金額計算処理判定
                if($_POST["form_goods_num1"][$i] != null){
                //数量○の場合、営業金額は、単価×数量。
                    //営業金額
                    $t_amount = bcmul($t_price, $_POST["form_goods_num1"][$i], 2);
                    $t_amount = Coax_Col($coax, $t_amount);

                //数量×の場合、単価×１
                }else{
                    //営業金額
                    $t_amount = bcmul($t_price, 1, 2);
                    $t_amount = Coax_Col($coax, $t_amount);
                }

                //合計金額フォームにセット
                $con_data2["form_trade_amount"][$i] = number_format($t_amount);

            }
        }

    }

//既に入力してある場合
}elseif($_POST["hdn_daiko_id"] != null && $contract_div != "1" && $done_flg != "true"){
    $act_id = $_POST["hdn_daiko_id"];
    $daiko_coax = $_POST["hdn_daiko_coax"];

//既に入力してあるけど自社巡回の場合
}elseif($_POST["hdn_daiko_id"] != null && $contract_div == "1" && $done_flg != "true"){
    $act_id = null;
    $daiko_coax = null;
}



/****************************/
// 担当者セレクト選択
/****************************/
if($_POST["hdn_staff_ware"] == true){

    if($_POST["form_c_staff_id1"] != null){
        $staff_bases_ware_id = Get_Ware_Id($db_con, Get_Branch_Id($db_con, $_POST["form_c_staff_id1"]));    //スタッフの拠点倉庫

        $sql  = "SELECT ware_name \n";
        $sql .= "FROM t_ware \n";
        $sql .= "WHERE ware_id = $staff_bases_ware_id \n";
        $sql .= ($group_kind == "2") ? "AND shop_id IN (".Rank_Sql().") \n" : "AND shop_id = $client_h_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);

        $set_staff_ware["hdn_ware_name"]    = htmlspecialchars(pg_fetch_result($result, 0, "ware_name"));
        $set_staff_ware["hdn_ware_id"]      = $staff_bases_ware_id; //出荷倉庫を担当者の拠点倉庫にする

    }else{
        //巡回担当者（メイン1）が空にする
        $set_staff_ware["hdn_ware_name"]    = "";
        $set_staff_ware["hdn_ware_id"]      = "";
    }

    $set_staff_ware["hdn_staff_ware"]   = "";                   //スタッフのセレクト選択されたフラグを空に

    $form->setConstants($set_staff_ware);
}


/****************************/
//合計ボタン押下処理
/****************************/
//if($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["form_sale_btn"] == "売上確認画面へ"){
if(($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || ($_POST["form_sale_btn"] == "確認画面へ" && $client_id != null)) && $done_flg != "true"){
/*
    //削除リストを取得
    $del_row = $_POST["del_row"];
    //削除履歴を配列にする。
    $del_history = explode(",", $del_row);
*/
    $sale_data   = $_POST["form_sale_amount"];  //売上金額
    $sale_money  = NULL;                        //商品の売上金額
    $tax_div_arr = NULL;                        //課税区分
    $ad_offset_total = null;                    //前受相殺額合計

    //売上金額の合計値計算
    //for($i=0;$i<$max_row;$i++){
    for($i=1;$i<=5;$i++){
        if($sale_data[$i] != "" && !in_array("$i", $del_history)){
            $sale_money[] = $sale_data[$i];
            if($_POST["hdn_goods_id1"][$i] == null && $_POST["form_serv"][$i] == null){
				$tax_div_arr[] = "1";
				$tax_div[$i]   = "1";
			}elseif($_POST["hdn_goods_id1"][$i] == null){
				$sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
			    $result = Db_Query($db_con, $sql);
			    $tax_div_arr[] = pg_fetch_result($result, 0, 0);
			    $tax_div[$i]   = pg_fetch_result($result, 0, 0);
			}else{
				$sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
			    $result = Db_Query($db_con, $sql);
			    $tax_div_arr[] = pg_fetch_result($result, 0, 0);
			    $tax_div[$i]   = pg_fetch_result($result, 0, 0);
				//$tax_div_arr[] = $_POST["hdn_tax_div"][$i];
				//$tax_div[$i]   = $_POST["hdn_tax_div"][$i];
			}
        }

        //前受相殺額合計計算
        if($_POST["form_ad_offset_radio"][$i] == "2"){
            $ad_offset_total += $_POST["form_ad_offset_amount"][$i];
        }
    }

    //現在の消費税率
    #2009-12-22 aoyama-n
    #$sql  = "SELECT ";
    #$sql .= "    tax_rate_n ";
    #$sql .= "FROM ";
    #$sql .= "    t_client ";
    #$sql .= "WHERE ";
    //$sql .= "    client_id = $client_id;";
    #$sql .= "    client_id = ";
    #$sql .= ($shop_id != null) ? $shop_id : $_SESSION["client_id"];
    #$result = Db_Query($db_con, $sql);
    #$tax_num = pg_fetch_result($result, 0,0);

    #2009-12-22 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div_arr,$coax,$tax_franct,$tax_num,$client_id, $db_con);
    //$total_money = Total_Amount($sale_money, $tax_div_arr,$coax,$tax_franct,$tax_num,$client_shop_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);
    $ad_offset_total = ($ad_offset_total !== null) ? number_format($ad_offset_total) : null;

    if($_POST["sum_button_flg"] == true){
        //初期表示位置変更
        $height = $max_row * 30;
        $form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";
    }

    //フォームに値セット
    $money_data["form_sale_total"]   = $sale_money;
    $money_data["form_sale_tax"]     = $tax_money;
    $money_data["form_sale_money"]   = $st_money;
    $money_data["form_ad_offset_total"] = $ad_offset_total;
    $money_data["sum_button_flg"]    = "";
    $form->setConstants($money_data);
}



/****************************/
//商品コード入力
/****************************/
if($_POST["goods_search_row"] != null && $done_flg != "true"){

    //商品コード識別情報
    $row_data = $_POST["goods_search_row"];
    //商品データを取得する行
    $search_row = substr($row_data,0,1);
    //商品データを取得する列
    $search_line = substr($row_data,1,1);


    $client_shop_id = $_POST["client_shop_id"];   //得意先のショップID
    //$rank_cd      = $_POST["hdn_rank_cd"];        //得意先の顧客区分
    //$ware_id      = $_POST["form_ware_select"];   //出荷倉庫

    $sql  = "SELECT \n";
    $sql .= "   t_goods.goods_id, \n";      //商品ID 0
    $sql .= "   t_goods.name_change, \n";   //品名変更 1
    $sql .= "   t_goods.goods_cd, \n";      //商品CD 2
    $sql .= "   t_goods.goods_cname, \n";   //商品名（略称） 3
    $sql .= "   initial_cost.r_price AS initial_price, \n"; //営業原価 4
    $sql .= "   sale_price.r_price AS sale_price, \n";      //売上単価（標準）5
    $sql .= "   t_goods.tax_div, \n";       //課税区分 6
    $sql .= "   null, \n";                  //未使用 7
    $sql .= "   null, \n";                  //未使用 8
    $sql .= "   t_goods.compose_flg, \n";   //構成品フラグ 9
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_g_product.g_product_name IS NULL THEN t_goods.goods_name \n";
    $sql .= "       ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
    //aoyama-n 2009-09-09
    #$sql .= "   END \n";                    //商品分類名＋半スペ＋商品名 10
    $sql .= "   END, \n";                    //商品分類名＋半スペ＋商品名 10
    $sql .= "   t_goods.discount_flg \n";    //値引フラグ 11

    $sql .= "FROM \n";
    $sql .= "   t_goods \n";
    $sql .= "   LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "   LEFT JOIN t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id \n";
    $sql .= "        AND initial_cost.rank_cd = '2' \n";
    if($group_kind == "2"){
        $sql .= "    AND initial_cost.shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "    AND initial_cost.shop_id = $client_h_id \n";
    }

    $sql .= "   LEFT JOIN t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id \n";
    $sql .= "        AND sale_price.rank_cd = '4' \n";

    $sql .= "WHERE \n";
    $sql .= "    t_goods.goods_cd = '".$_POST["form_goods_cd".$search_line][$search_row]."' \n";
    $sql .= "    AND \n";
    $sql .= "    t_goods.accept_flg = '1' \n";

    //直営の場合は、有効・直営のみ有効で、本部商品・直営商品を抽出
    if($group_kind == "2"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.state IN (1,3) \n";
        $sql .= "    AND \n";
        $sql .= "    ( \n";
        $sql .= "        t_goods.public_flg = true \n";
        $sql .= "        OR \n";
        $sql .= "        t_goods.shop_id IN (".Rank_Sql().") \n";
        $sql .= "    ) \n ";
    //FCの場合は、有効で、本部商品・FC商品を抽出
    }else{
        $sql .= "    AND \n";
        $sql .= "    t_goods.state = 1 \n";
        $sql .= "    AND \n";
        $sql .= "    ( \n";
        $sql .= "        t_goods.public_flg = true \n";
        $sql .= "        OR \n";
        $sql .= "        t_goods.shop_id = $client_h_id \n";
        $sql .= "    ) \n ";
    }
    //本体商品は構成品はダメ
    if($search_line == "2"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.compose_flg = 'f' \n";
    }
    //代行区分が代行の場合は本部商品のみ表示
    if($contract_div != "1"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.public_flg = true \n";
    }
    $sql .= ";";
//print_array($sql, "商品入力");
    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);

    //データが存在した場合、フォームにデータを表示
    if($data_num == 1){
        $goods_data = Get_Data($result, 2);

        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = $goods_data[0][0];    //商品ID

        $set_goods_data["hdn_name_change".$search_line][$search_row]    = $goods_data[0][1];    //品名変更フラグ
        $hdn_name_change[$search_line][$search_row]                     = $goods_data[0][1];    //POSTする前に商品名の変更不可判定を行なう為
        $_POST["hdn_name_change".$search_line][$search_row]             = $goods_data[0][1];    //商品変更前のhiddenで判定しないため

        $set_goods_data["form_goods_cd".$search_line][$search_row]      = $goods_data[0][2];    //商品CD
        $set_goods_data["form_goods_name".$search_line][$search_row]    = $goods_data[0][3];    //商品名

        $reset_goods_flg = false;   //構成品入力時のフォームリセットフラグ

        //構成品の場合、子の単価を合計したものが構成品の単価になる
        if($goods_data[0][9] == "t"){
            $shop_id = ($shop_id != null) ? $shop_id : $_SESSION["client_id"];
            $array_price = Compose_price($db_con, $shop_id, $goods_data[0][0]);
			//構成品の子の単価設定判定
			if($array_price == false){
				$reset_goods_flg = true;   //入力された商品情報をクリア
			}else{
                $goods_data[0][4] = $array_price[0];    //原価
                $goods_data[0][5] = $array_price[1];    //売上
            }

        //構成品じゃない場合、単価がnullならフォームリセット
        }elseif($goods_data[0][4] == null || $goods_data[0][5] == null){
            $reset_goods_flg = true;
        }

        //構成品エラーじゃない場合
        if($reset_goods_flg == false){
            //アイテム入力時のみ単価、金額計算、商品正式名を入れる
            if($search_line == "1"){
                //代行区分が自社、または代行委託料が（％）以外の場合はDBから、代行で（％）の場合は売上単価に（％）をかけたものを原価単価に入れる
                if($contract_div != "1" && $_POST["act_div"]["0"] == "3"){
                    //代行委託料が入力されていない場合は0にするよ
                    if($_POST["act_request_rate"] == null){
                        $cost_price = 0;
                    }else{
                        $cost_price = bcmul($goods_data[0][5], bcdiv($_POST["act_request_rate"], 100, 2), 2);
                    }

                }else{
                    $cost_price = $goods_data[0][4];
                }

                //原価単価を整数部と少数部に分ける
                $arr_cost_price = explode('.', $cost_price);
                $set_goods_data["form_trade_price"][$search_row]["1"] = $arr_cost_price[0];  //原価単価
                $set_goods_data["form_trade_price"][$search_row]["2"] = ($arr_cost_price[1] != null)? $arr_cost_price[1] : '00';

                //売上単価を整数部と少数部に分ける
                $sale_price = $goods_data[0][5];
                $arr_sale_price = explode('.', $sale_price);
                $set_goods_data["form_sale_price"][$search_row]["1"] = $arr_sale_price[0];  //売上単価
                $set_goods_data["form_sale_price"][$search_row]["2"] = ($arr_sale_price[1] != null)? $arr_sale_price[1] : '00';

                $set_goods_data["hdn_tax_div"][$search_row]          = $goods_data[0][6]; //課税区分


                //金額計算処理判定
                if($_POST["form_issiki"][$search_row] != null && $_POST["form_goods_num1"][$search_row] != null){
                //一式○　数量○の場合、営業金額は、単価×数量。売上金額は、単価×１
                    //営業金額
                    //$trade_amount = bcmul($cost_price, $_POST["form_goods_num1"][$search_row],2);
                    //営業金額
                    //代行伝票で代行料が売上％ので一式○の場合、原価合計額は原価単価と同じ
                    //　一式○のとき売上単価＝売上合計額で、原価単価＝売上単価×代行料％＝売上合計額×代行料％＝原価合計額
                    //　よって、数量１で計算して原価単価＝原価合計額を登録
                    if($contract_div != "1" && $_POST["act_div"][0] == "3"){
                        $trade_amount = bcmul($cost_price, 1, 2);
                    //それ以外は単価×数量
                    }else{
                        $trade_amount = bcmul($cost_price, $_POST["form_goods_num1"][$search_row],2);
                    }
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //売上金額
                    $sale_amount = bcmul($sale_price, 1,2);
                    $sale_amount = Coax_Col($coax, $sale_amount);

                //一式○　数量×の場合、単価×１
                }else if($_POST["form_issiki"][$search_row] != null && $_POST["form_goods_num1"][$search_row] == null){
                    //営業金額
                    $trade_amount = bcmul($cost_price, 1,2);
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //売上金額
                    $sale_amount = bcmul($sale_price, 1,2);
                    $sale_amount = Coax_Col($coax, $sale_amount);

                //一式×　数量○の場合、単価×数量
                }else if($_POST["form_issiki"][$search_row] == null && $_POST["form_goods_num1"][$search_row] != null){
                    //営業金額
                    $trade_amount = bcmul($cost_price, $_POST["form_goods_num1"][$search_row],2);
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //売上金額
                    $sale_amount = bcmul($sale_price, $_POST["form_goods_num1"][$search_row],2);
                    $sale_amount = Coax_Col($coax, $sale_amount);
                }

                $set_goods_data["form_trade_amount"][$search_row]   = number_format($trade_amount);
                $set_goods_data["form_sale_amount"][$search_row]    = number_format($sale_amount);


                //商品名（正式）を入れる
                $set_goods_data["official_goods_name"][$search_row] = $goods_data[0][10];

                //aoyama-n 2009-09-09
                //値引フラグ
                $set_goods_data["hdn_discount_flg"][$search_row]    = $goods_data[0][11];

            }//アイテム入力時のみ金額計算おわり

		//構成品の子に単価が設定されていないとき、商品情報クリア
		}else{
	        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = "";
	        $set_goods_data["hdn_name_change".$search_line][$search_row]    = "";
	        $set_goods_data["form_goods_cd".$search_line][$search_row]      = "";
	        $set_goods_data["form_goods_name".$search_line][$search_row]    = "";
	        $set_goods_data["form_goods_num".$search_line][$search_row]     = "";
            //アイテム入力時は原価、売上、印字フラグ、課税区分も初期化
            if($search_line == "1"){
    	        $set_goods_data["form_trade_price"][$search_row]["1"]   = "";
	            $set_goods_data["form_trade_price"][$search_row]["2"]   = "";
	            $set_goods_data["form_trade_amount"][$search_row]       = "";
	            $set_goods_data["form_sale_price"][$search_row]["1"]    = "";
    	        $set_goods_data["form_sale_price"][$search_row]["2"]    = "";
	            $set_goods_data["form_sale_amount"][$search_row]        = "";
	            $set_goods_data["form_print_flg2"][$search_row]         = "";
	            $set_goods_data["hdn_tax_div"][$search_row]             = "";
            }
		}
    }else{
        //データが無い場合は、初期化
        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = "";
        $set_goods_data["hdn_name_change".$search_line][$search_row]    = "";
        $set_goods_data["form_goods_cd".$search_line][$search_row]      = "";
        $set_goods_data["form_goods_name".$search_line][$search_row]    = "";
        $set_goods_data["form_goods_num".$search_line][$search_row]     = "";
        //アイテム入力時は原価、売上、印字フラグ、課税区分、アイテム正式名も初期化
        if($search_line == "1"){
            $set_goods_data["form_trade_price"][$search_row]["1"]   = "";
            $set_goods_data["form_trade_price"][$search_row]["2"]   = "";
            $set_goods_data["form_trade_amount"][$search_row]       = "";
            $set_goods_data["form_sale_price"][$search_row]["1"]    = "";
            $set_goods_data["form_sale_price"][$search_row]["2"]    = "";
            $set_goods_data["form_sale_amount"][$search_row]        = "";
            $set_goods_data["form_print_flg2"][$search_row]         = "";
            $set_goods_data["hdn_tax_div"][$search_row]             = "";
            $set_goods_data["official_goods_name"][$search_row]     = "";
            //aoyama-n 2009-09-09
            $set_goods_data["hdn_discount_flg"][$search_row]        = "";
        }
    }
    $set_goods_data["goods_search_row"] = "";
    $form->setConstants($set_goods_data);
}


/****************************/
//部品作成
/****************************/
if($done_flg != "true"){

    //部品関連
    require_once(INCLUDE_DIR ."plan_data.inc");

    //代行
    require_once(INCLUDE_DIR ."fc_hand_daiko.inc");


    //巡回担当者メイン1を変更すると、出荷倉庫をその担当者の拠点倉庫にする属性追加
    $form->updateElementAttr(
        "form_c_staff_id1", 
        "onKeyDown=\"chgKeycode();\" onChange=\"javascript:Button_Submit('hdn_staff_ware','#','true');\""
    );


    //hidden
    $form->addElement("hidden", "hdn_aord_id");     //受注ID
    $form->addElement("hidden", "back_display");    //戻る画面判定
    $form->addElement("hidden", "aord_id_array");   //受注ID配列
    $form->addElement("hidden", "hdn_former_deli_day");		//rev.1.3 変更前予定巡回日


}else{

    //売上伝票出力形式を取得
    $sql  = "SELECT slip_out FROM t_aorder_h WHERE aord_id = $aord_id AND ";
    $sql .= ($group_kind == "2") ? "shop_id IN (".Rank_Sql().") " : "shop_id = $client_h_id ";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $disable_slip_out = (pg_fetch_result($result, 0, "slip_out") == "2") ? "disabled" : "";


    //変更時
    if($_GET["change_flg"] == "true"){

        if($_GET["back_display"] != null){
            $array_id = stripslashes($_GET["aord_id_array"]);
            $array_id = urldecode($array_id);
            $array_id = unserialize($array_id);
            $array_id = serialize($array_id);
            $array_id = urlencode($array_id);

            //OKボタン
            $form->addElement("button", "ok_button", "完　了", "onClick=\"location.href='".FC_DIR."sale/2-2-106.php?aord_id[0]=$aord_id&aord_id_array=".$array_id."&back_display=".$_GET["back_display"]."'\"");

            //OK伝票ボタン
            $form->addElement("submit", "ok_slip_button", "伝票を発行して完了", 
                "onClick=\"Post_book_vote('./2-2-205.php','".FC_DIR."sale/2-2-106.php?aord_id[0]=$aord_id&aord_id_array=".$array_id."&back_display=".$_GET["back_display"]."');\"
                $disable_slip_out"
            );

        //戻る画面がない場合は自分に戻る
        }else{
            //OKボタン
            $form->addElement("button", "ok_button", "完　了", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

            //OK伝票ボタン
            $form->addElement("submit", "ok_slip_button", "伝票を発行して完了", 
                "onClick=\"Post_book_vote('./2-2-205.php','".$_SERVER["PHP_SELF"]."');\"
                $disable_slip_out"
            );
        }

    //新規登録時
    }else{
        //OKボタン
        $form->addElement("button", "ok_button", "完　了", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

        //OK伝票ボタン
        $form->addElement("submit", "ok_slip_button", "伝票を発行して完了", 
            "onClick=\"Post_book_vote('./2-2-205.php','".$_SERVER["PHP_SELF"]."');\"
            $disable_slip_out"
        );
    }

    //戻る
    //$form->addElement("button","return_button","戻　る","onClick=\"location.href='./2-2-207.php?search=1'\"");

    //売上伝票に渡すhidden
    $form->addElement("hidden", "output_id_array[0]", "$aord_id");
    $form->addElement("hidden", "form_slip_check[0]", "1");

}


/****************************/
//前受金集計ボタン押下処理
/****************************/
//if(($_POST["ad_sum_button_flg"] == true || $_POST["del_row"] != "" || (($_POST["form_sale_btn"] == "確認画面へ" || $_POST["hdn_comp_button"] == "Ｏ　>Ｋ") && $client_id != null)) && $done_flg != "true"){
//rev.1.3 予定巡回日2ヶ月以上無視ボタン追加
if(($_POST["ad_sum_button_flg"] == true || $_POST["del_row"] != "" || (($_POST["form_sale_btn"] == "確認画面へ" || $_POST["hdn_comp_button"] == "Ｏ　Ｋ" || $_POST["form_lump_change_warn"] == "警告を無視して訂正") && $client_id != null)) && $done_flg != "true"){

    //配送日
    //●必須チェック
    //$form->addGroupRule("form_delivery_day", $h_mess[26], "required");
    $form->addGroupRule("form_delivery_day", array(
        "y" => array(array("予定巡回日 を入力してください。", "required")),
        "m" => array(array("予定巡回日 を入力してください。", "required")),
        "d" => array(array("予定巡回日 を入力してください。", "required")),
    ));
    //数値チェック
    $form->addGroupRule("form_delivery_day", array(
        "y" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
        "m" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
        "d" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
    ));

    if($form->validate()){
        //妥当性チェック
        if(!checkdate((int)$_POST["form_delivery_day"]["m"], (int)$_POST["form_delivery_day"]["d"], (int)$_POST["form_delivery_day"]["y"])){
            $form->setElementError("form_delivery_day", $h_mess[35]);
        }
    }

    $error_flg = (count($form->_errors) > 0) ? true : false;


    //エラーがない場合、残高集計
    if($error_flg == false){
        $count_day  = str_pad($_POST["form_delivery_day"]["y"], 4, 0, STR_PAD_LEFT);
        $count_day .= "-";
        $count_day .= str_pad($_POST["form_delivery_day"]["m"], 2, 0, STR_PAD_LEFT);
        $count_day .= "-";
        $count_day .= str_pad($_POST["form_delivery_day"]["d"], 2, 0, STR_PAD_LEFT);

        $claim_data = $_POST["form_claim"];     //請求先,請求先区分
        $c_data = explode(',', $claim_data);

        $ad_rest_price  = Advance_Offset_Claim($db_con, $count_day, $client_id, $c_data[1]);
        $ad_rest_price2 = Numformat_Ortho($ad_rest_price, 0, true);

    //エラーの場合、空をセット
    }else{
        $ad_rest_price2 = "";

    }

    $con_data2["form_ad_rest_price"]    = $ad_rest_price2;
    $con_data2["ad_sum_button_flg"]     = "";

}


/****************************/
//行クリア処理
/****************************/
if($_POST["clear_line"] != ""){
    Clear_Line_Data2($form, $_POST["clear_line"]);
}


//行番号カウンタ
$row_num = 1;


/****************************/
//登録ボタン押下処理
/****************************/
//if(($_POST["form_sale_btn"] == "確認画面へ" || $_POST["hdn_comp_button"] == "Ｏ　Ｋ") && $done_flg != "true"){
//rev.1.3 予定巡回日2ヶ月以上無視ボタン追加
if(($_POST["form_sale_btn"] == "確認画面へ" || $_POST["hdn_comp_button"] == "Ｏ　Ｋ" || $_POST["form_lump_change_warn"] == "警告を無視して訂正") && $done_flg != "true"){
    //ヘッダー情報
    //$sale_no              = $_POST["form_sale_no"];             //伝票番号
    $note                 = $_POST["form_note"];                //備考

    $ware_id              = $_POST["hdn_ware_id"];              //出荷倉庫ID
    $trade_aord           = $_POST["trade_aord"];               //取引区分

    //請求先
    $array_tmp = explode(",", $_POST["form_claim"]);
    $claim_id  = $array_tmp[0];     //請求先ID
    $claim_div = $array_tmp[1];     //請求先区分

    $array_divide = Select_Get($db_con, "divide_con");
    $array_serv = Select_Get($db_con, "serv_con");


    //本部のclient_idを取得
    $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
    $result = Db_Query($db_con, $sql);
    $head_id = pg_fetch_result($result, 0, "client_id");        //本部のclient_id


    //POST取得とか
    require_once(INCLUDE_DIR."fc_sale_post_bfr.inc");


	/****************************/
	//エラーチェック(addRule)
	/****************************/

	//取引区分
	//●必須チェック
	$form->addRule("trade_aord", $h_mess[30], "required");


    //紹介口座先ID、取引先区分取得
    $sql  = "SELECT \n";
    $sql .= "    t_client_info.intro_account_id, \n";
    $sql .= "    t_client.client_div \n";
    $sql .= "FROM \n";
    $sql .= "    t_client_info \n";
    $sql .= "    LEFT JOIN t_client ON t_client_info.intro_account_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client_info.client_id = $client_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $intro_account_id = pg_fetch_result($result, 0, "intro_account_id");    //紹介口座先ID
    $intro_client_div = pg_fetch_result($result, 0, "client_div");          //紹介口座先の取引先区分


    //エラーチェック(PHP)
    require_once(INCLUDE_DIR."fc_sale_post_atr.inc");


    //変更時削除されたかチェック
    if($aord_id != NULL){

        $sql = "SELECT del_flg FROM t_aorder_h WHERE aord_id = $aord_id;";
        $result = Db_Query($db_con, $sql);

        if(pg_fetch_result($result, 0, "del_flg") == "t"){
            $error_flg = true;
            $slip_del_flg = true;

            //受注ID配列を詰め直す
            $aord_id_tmp = array();
            foreach($aord_id_array as $value){
                if($value != $aord_id){
                    $aord_id_tmp[] = $value;
                }
            }
            $array_id = $aord_id_tmp;

            //OKボタン
            if(count($array_id) != 0){
                $array_id = serialize($array_id);
                $array_id = urlencode($array_id);
                $form->addElement("button","ok_button","Ｏ　Ｋ","onClick=\"location.href='".FC_DIR."sale/2-2-106.php?aord_id[0]=$aord_id&aord_id_array=".$array_id."&back_display=".$_POST["back_display"]."'\"");
            }else{
                //削除されて予定データ明細に表示するデータが0件になった場合
                $form->addElement("button","ok_button","Ｏ　Ｋ","onClick=\"location.href='".Make_Rtn_Page("contract")."'\"");
            }
        }
    }


    //得意先の担当支店、紹介口座先取得
    $sql  = "SELECT \n";
    $sql .= "    t_client.coax, \n";
    $sql .= "    t_client.tax_franct, \n";
    $sql .= "    t_client_info.cclient_shop \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_client_info ON t_client.client_id = t_client_info.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_id = $client_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $coax           = pg_fetch_result($result, 0, "coax");              //まるめ区分
    $tax_franct     = pg_fetch_result($result, 0, "tax_franct");        //消費税端数区分
    $cclient_shop   = pg_fetch_result($result, 0, "cclient_shop");      //担当支店

    $cost_money  = NULL;                        //商品の原価金額
    $sale_money  = NULL;                        //商品の売上金額
    $tax_div_arr = NULL;                        //課税区分

    //売上金額の合計値計算
    for($i=1;$i<=5;$i++){
        if($serv_id[$i] != null || $goods_item_id[$i] != null){
            $cost_money[] = $trade_amount[$i];
            $sale_money[] = $sale_amount[$i];
            if($_POST["hdn_goods_id1"][$i] == null && $_POST["form_serv"][$i] == null){
                $tax_div_arr[] = "1";
                $tax_div[$i]   = "1";		//DB登録用
            }elseif($_POST["form_serv"][$i] != null && $_POST["hdn_goods_id1"][$i] == null){
                $sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);
                $tax_div[$i]   = pg_fetch_result($result, 0, 0);		//DB登録用
            }else{
                $sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);
                $tax_div[$i]   = pg_fetch_result($result, 0, 0);

            }
        }
    }

    //現在の担当ショップの消費税率
    #2009-12-22 aoyama-n
    #$tax_num = Get_Tax_Rate($db_con, $cclient_shop);

    $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    //自社巡回の場合、原価は得意先の丸めでまるめ
    if($contract_div == "1"){
        $total_money = Total_Amount($cost_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);

    //代行の場合、原価は代行先の丸めでまるめ
    }else{
        $total_money = Total_Amount($cost_money, $tax_div_arr, $daiko_coax, $tax_franct, $tax_num, $client_id, $db_con);
    }
    $cost_money  = $total_money[0];     //原価金額（税抜）

    $total_money = Total_Amount($sale_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);
    $sale_money  = $total_money[0];     //売上金額（税抜）
    $sale_tax    = $total_money[1];     //消費税額


    //直営で代行の場合、（受託先用）売上金額・消費税額を計算で求める
    //if($group_kind == "2" && $contract_div != "1"){
    if($group_kind == "2" && $contract_div != "1" && $act_id != null){

        //受託先（代行先）の消費税率取得
        #2009-12-22 aoyama-n
        #$act_tax_num = Get_Tax_Rate($db_con, $act_id);

        #2009-12-22 aoyama-n
        //税率クラス　インスタンス生成
        $act_tax_rate_obj = new TaxRate($act_id);
        $act_tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
        $act_tax_num = $act_tax_rate_obj->getOwnShopTaxRate();

        //得意先東陽のまるめ区分、端数区分、請求日（支払日）を取得
        $sql = "SELECT coax, tax_franct, client_id FROM t_client WHERE act_flg = true AND shop_id = ".$act_id.";";
        $result = Db_Query($db_con, $sql);
        $toyo_coax = pg_fetch_result($result, 0, "coax");               //まるめ区分
        $toyo_tax_franct = pg_fetch_result($result, 0, "tax_franct");   //端数区分
        $toyo_id = pg_fetch_result($result, 0, "client_id");            //取引先ID


        //5行分の（受託先用）売上金額取得、計算
        for($i=1; $i<=$max_row; $i++){

            //データ入力されたとこだけ取得
            if($serv_id[$i] != null || $goods_item_id[$i] != null){
                //代行料固定額の場合は「0」
                if($_POST["act_div"][0] == "2"){

                    $trust_sale_price[$i]  = 0;
                    $trust_sale_amount[$i] = 0;
                    $trust_sale_money[] = $trust_sale_amount[$i];       //（受託先）消費税額計算用

                //代行料売上％の場合
                }else{

                    $trust_sale_price[$i] = $trade_price[$i];

                    //一式○　数量○の場合、営業金額は、単価×数量。売上金額は、単価×１
                    if($set_flg[$i] == "true" && $_POST["form_goods_num1"][$i] != null){
                        //代行伝票で代行料が売上％ので一式○の場合、原価合計額は原価単価と同じ
                        //　一式○のとき売上単価＝売上合計額で、原価単価＝売上単価×代行料％＝売上合計額×代行料％＝原価合計額
                        //　よって、数量１で計算して原価単価＝原価合計額を登録
                        if($_POST["act_div"][0] == "3"){
                            $trust_sale_amount[$i] = bcmul($trust_sale_price[$i], 1, 2);
                        //それ以外は単価×数量
                        }else{
                            $trust_sale_amount[$i] = bcmul($trust_sale_price[$i], $_POST["form_goods_num1"][$i], 2);
                        }
                        $trust_sale_amount[$i] = Coax_Col($toyo_coax, $trust_sale_amount[$i]);

                    //一式○　数量×の場合、単価×１
                    }elseif($set_flg[$i] == "true" && $_POST["form_goods_num1"][$i] == null){
                        $trust_sale_amount[$i] = bcmul($trust_sale_price[$i], 1, 2);
                        $trust_sale_amount[$i] = Coax_Col($toyo_coax, $trust_sale_amount[$i]);

                    //一式×　数量○の場合、単価×数量
                    }elseif($set_flg[$i] == "false" && $_POST["form_goods_num1"][$i] != null){
                        $trust_sale_amount[$i] = bcmul($trust_sale_price[$i], $_POST["form_goods_num1"][$i], 2);
                        $trust_sale_amount[$i] = Coax_Col($toyo_coax, $trust_sale_amount[$i]);

                    }

                    $trust_sale_money[] = $trust_sale_amount[$i];

                }//（受託先用）売上金額取得、計算おわり

            }//データ入力されたとこだけ取得おわり

        }//5行分の（受託先用）売上金額取得、計算おわり


        //ヘッダの（受託先用）売上金額（税抜）、（受託先用）消費税額を計算
        $total_money = Total_Amount($trust_sale_money, $tax_div_arr, $toyo_coax, $toyo_tax_franct, $act_tax_num, $toyo_id, $db_con);
        $trust_sale_money   = $total_money[0];      //（受託先用）売上金額（税抜）
        $trust_sale_tax     = $total_money[1];      //（受託先用）消費税額


    }//（受託先用）売上金額・消費税額を計算おわり


    //代行料区分が「固定額」　かつ　固定代行料と営業金額合計が一致しない場合
    if($act_div == "2" && ($cost_money != $act_request_price)){
        $form->setElementError("act_request_price",$h_mess[68]);
    }


    //前受金額のチェック
    if($ad_offset_flg){

        //伝票合計（税込）より前受相殺額合計が大きい場合、警告を表示
        if(($sale_money + $sale_tax) < $ad_offset_total_amount){
            $ad_total_warn_mess = $h_mess[78];
        }

/*
        //「掛売上」の場合
        if($trade_aord == "11"){
            //前受相殺額合計が現在の前受金残高より大きい場合はエラー
            if($ad_offset_total_amount > $ad_rest_price){
                $form->setElementError("form_ad_offset_total", $h_mess[75]);
            }
        }
*/
    }//前受金額チェックおわり



    $form->validate();
    $error_flg = (count($form->_errors) > 0) ? true : $error_flg;


	//rev.1.3 警告無視ボタン押下されてない場合は2ヶ月以上離れているかチェック
	if($error_flg == false && $aord_id != null && $_POST["form_lump_change_warn"] != "警告を無視して訂正"){
		$b_lump_day = date("Y-m-d", mktime(0, 0, 0, $delivery_day_m - 2, $delivery_day_d, $delivery_day_y));	//2ヶ月前
		$a_lump_day = date("Y-m-d", mktime(0, 0, 0, $delivery_day_m + 2, $delivery_day_d, $delivery_day_y));	//2ヶ月後
		//2ヶ月以上離れている
		if(($_POST["hdn_former_deli_day"] <= $b_lump_day) || ($_POST["hdn_former_deli_day"] >= $a_lump_day)){
			$warn_lump_change = "入力した予定巡回日は2ヶ月以上離れています。";
			$form->addElement("submit", "form_lump_change_warn", "警告を無視して訂正", $disabled);
		//守備範囲内
		}else{
			$warn_lump_change = null;
		}
	}else{
		$warn_lump_change = null;
	}



    //エラーの場合はこれ以降の表示処理を行なわない
    //if($form->validate() && $error_flg == false){
    //if($error_flg == false){
	//rev.1.3 エラーじゃなく、予定巡回日が2ヶ月以上離れていない
    if($error_flg == false && $warn_lump_change == null){

        //登録判定
        //if($_POST["comp_button"] == "Ｏ　Ｋ"){
        //if($_POST["hdn_comp_button"] == "Ｏ　Ｋ"){
        if($_POST["hdn_comp_button"] == "Ｏ　Ｋ" || $_POST["form_lump_change_warn"] == "警告を無視して訂正"){

            //日付の形式変更
            $sale_day   = $delivery_day;    //予定巡回日日
            $claim_day  = $request_day;     //請求日

            //自社巡回の場合、出荷倉庫（売上担当者の担当倉庫）を取得
            if($contract_div == "1"){
                $sql  = "SELECT \n";
                $sql .= "    t_ware.ware_id, \n";
                $sql .= "    t_ware.ware_name \n";
                $sql .= "FROM \n";
                $sql .= "    t_attach \n";
                $sql .= "    INNER JOIN t_ware ON t_attach.ware_id = t_ware.ware_id \n";
                $sql .= "WHERE \n";
                $sql .= "    t_attach.staff_id = ".$staff_check[0]." \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql); 
                $staff_ware_id      = pg_fetch_result($result, 0, "ware_id");       //担当倉庫ID
                $staff_ware_name    = pg_fetch_result($result, 0, "ware_name");     //担当倉庫名
            }


            //(2006/08/26) 重複エラーチェック用フラグを初期化
            //$duplicate_flg = false;

            //集計日報エラーフラグを初期化
            //$daily_slip_error_flg = false;


            //受注ヘッダ・受注データ　登録・更新SQL
            Db_Query($db_con, "BEGIN;");

            //変更処理判定
            if($aord_id != NULL){

                //商品予定出荷一覧で在庫移動済の予定データは、出荷倉庫を担当者(メイン)の担当倉庫に変更する
                $sql = "SELECT move_flg FROM t_aorder_h WHERE aord_id = $aord_id;";
                $result = Db_Query($db_con, $sql);
                $move_flg = pg_fetch_result($result, 0, 0);     //移動フラグ


                //受注ヘッダ変更
                $sql  = "UPDATE \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "SET \n";
                $sql .= "    aord_id = $aord_id, \n";
                //$sql .= "    ord_no = '$sale_no', \n";
                $sql .= "    ord_time = '$sale_day', \n";
                $sql .= "    arrival_day = '$claim_day', \n";
                $sql .= "    trade_id = '$trade_aord', \n";
                $sql .= "    client_id = $client_id, \n";
                $sql .= "    client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    slip_out = (SELECT slip_out FROM t_client WHERE client_id = $client_id), \n";

                $sql .= "    claim_id = $claim_id, \n";     //請求先ID
                $sql .= "    claim_div = $claim_div, \n";   //請求先区分

                //直送先が指定されている場合
                if($direct_id != null){
                    $sql .= "    direct_id = $direct_id, ";
                    $sql .= "    direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    direct_cname = (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), ";
                }else{
                    $sql .= "    direct_id = null, ";
                    $sql .= "    direct_name = null, ";
                    $sql .= "    direct_name2 = null, ";
                    $sql .= "    direct_cname = null, ";
                }

                //自社巡回の場合
                //・出荷倉庫登録
                //・代行を空に
                if($contract_div == "1"){
                    //予定出荷で移動済は担当者の担当倉庫
                    if($move_flg == "t"){
                        $sql .= "    ware_id = (SELECT ware_id FROM t_attach WHERE staff_id = ".$staff_check[0]." AND shop_id = ".$client_h_id."), \n";
                        $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = ";
                        $sql .= "(SELECT ware_id FROM t_attach WHERE staff_id = ".$staff_check[0]." AND shop_id = ".$client_h_id.")), \n";

                    //移動してない場合は担当者の拠点倉庫
                    }else{
                        $sql .= "    ware_id = $ware_id, \n";
                        $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), \n";
                    }
                    $sql .= "    route = $route, \n";
                    $sql .= "    act_id = null, \n";
                    $sql .= "    act_cd1 = null, \n";
                    $sql .= "    act_cd2 = null, \n";
                    $sql .= "    act_name = null, \n";
                    $sql .= "    act_div = '1', \n";        //代行料区分
                    $sql .= "    trust_net_amount = NULL, \n";     //（受託先用）売上金額（税抜）
                    $sql .= "    trust_tax_amount = NULL, \n";      //（受託先用）消費税額
                //代行の場合
                //・出荷倉庫を空に
                //・代行を登録
                }else{
                    $sql .= "    ware_id = null, \n";
                    $sql .= "    ware_name = null, \n";
                    $sql .= "    route = null, \n";
                    $sql .= "    act_id = $act_id, \n";
                    $sql .= "    act_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $act_id), \n";
                    $sql .= "    act_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $act_id), \n";
                    $sql .= "    act_name = (SELECT client_cname FROM t_client WHERE client_id = $act_id), \n";
                    $sql .= "    act_div = '$act_div', \n"; //代行料区分
                    $sql .= "    trust_net_amount = $trust_sale_money, \n";     //（受託先用）売上金額（税抜）
                    $sql .= "    trust_tax_amount = $trust_sale_tax, \n";       //（受託先用）消費税額
                }
                if($act_request_rate != null){              //代行料（％）
                    $sql .= "    act_request_rate = '$act_request_rate', \n";
                }else{
                    $sql .= "    act_request_rate = null, \n";
                }
                if($act_request_price != null){             //代行料（固定額）
                    $sql .= "    act_request_price = $act_request_price, \n";
                }else{
                    $sql .= "    act_request_price = null, \n";
                }

                $sql .= "    ord_staff_id = $e_staff_id, \n";       //オペレータID
                $sql .= "    ord_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $e_staff_id), \n";
                $sql .= "    cost_amount = $cost_money, \n";        //原価金額（税抜）
                $sql .= "    net_amount = $sale_money, \n";         //売上金額（税抜）
                $sql .= "    tax_amount = $sale_tax, \n";           //消費税額
                $sql .= "    note = '$note', \n";                   //備考
                $sql .= "    reason_cor = '$reason', \n";           //訂正理由
                $sql .= "    shop_id = $cclient_shop, \n";          //担当ショップ（ショップID）
                $sql .= "    contract_div = '$contract_div', \n";   //契約区分
                if($ad_offset_flg == true){                         //前受相殺額合計
                    $sql .= "    advance_offset_totalamount = $ad_offset_total_amount, ";
                }else{
                    $sql .= "    advance_offset_totalamount = null, ";
                }
                $sql .= "    ship_chk_cd = NULL, \n";               //変更チェックコード
                $sql .= "    slip_flg = false, \n";                 //伝票出力フラグ
                $sql .= "    slip_out_day = NULL, \n";              //伝票出力日
                $sql .= "    change_flg = true, \n";                //変更フラグ
                $sql .= "    change_day = CURRENT_TIMESTAMP \n";    //データ変更日
                $sql .= "WHERE \n";
                $sql .= "    aord_id = $aord_id \n";
                $sql .= ";";
//print_array($sql, "受注ヘッダ更新");

                $result = Db_Query($db_con,$sql);
                if($result == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }

                //受注巡回担当テーブルを削除
                $sql  = "DELETE FROM ";
                $sql .= "    t_aorder_staff ";
                $sql .= "WHERE ";
                $sql .= "    aord_id = $aord_id ";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //受注データを削除
                $sql  = "DELETE FROM ";
                $sql .= "    t_aorder_d ";
                $sql .= " WHERE ";
                $sql .= "    aord_id = $aord_id ";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }


                //変更時は完了後に一覧へ戻る
                $change_flg = "true";


            //新規登録
            }else{

/*
                //自動採番の伝票番号取得（チェック用）
                //直営の場合
                if($group_kind == "2"){
                    $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                //FCの場合
                }else{
                    $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                }

                $result = Db_Query($db_con, $sql);
                $chk_sale_no = pg_fetch_result($result, 0 ,0);
                $chk_sale_no = $chk_sale_no +1;
                $chk_sale_no = str_pad($chk_sale_no, 8, 0, STR_PAD_LEFT);


                //伝票番号が同じ（エラーじゃない）場合、集計日報IDを振る
                if($sale_no === $chk_sale_no){
                    //集計日報ID登録＆取得
                    $daily_slip_id = Get_Daily_Slip_Id($db_con);
                }


                if($sale_no === $chk_sale_no && $daily_slip_id !== false){

                    //受注番号付番テーブル登録
                    if($group_kind == "2"){
                        $sql = "INSERT INTO t_aorder_no_serial (ord_no) VALUES ('$sale_no');";
                    }else{
                        $sql = "INSERT INTO t_aorder_no_serial_fc (ord_no, shop_id) VALUES ('$sale_no', $shop_id);";
                    }
                    $result = Db_Query($db_con, $sql );
                    if($result == false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
*/

                    //新規受注ID取得
                    $aord_id = Get_Pkey();


                    //受注ヘッダー登録SQL
                    $sql  = "INSERT INTO \n";
                    $sql .= "    t_aorder_h \n";
                    $sql .= "( \n";
                    $sql .= "    aord_id, \n";          //受注ID
                    //$sql .= "    ord_no, \n";           //受注番号
                    $sql .= "    ord_time, \n";         //予定巡回日
                    $sql .= "    client_id, \n";        //得意先ID
                    $sql .= "    client_cd1, \n";       //得意先コード
                    $sql .= "    client_cd2, \n";       //得意先コード２
                    $sql .= "    client_cname, \n";     //略称
                    $sql .= "    client_name, \n";      //得意先名
                    $sql .= "    client_name2, \n";     //得意先名２
                    $sql .= "    claim_id, \n";         //請求先ID
                    $sql .= "    claim_div, \n";        //請求区分
                    $sql .= "    trade_id, \n";         //取引区分コード
                    $sql .= "    arrival_day, \n";      //請求日
                    //直送先が指定されている場合
                    if($direct_id != null){
                        $sql .= "    direct_id, ";
                        $sql .= "    direct_name, ";
                        $sql .= "    direct_name2, ";
                        $sql .= "    direct_cname, ";
                    }
                    //代行区分判定
                    if($contract_div == "1"){
                        //自社巡回の場合
                        $sql .= "    route, \n";            //順路
                        $sql .= "    ware_id, \n";          //出荷倉庫ID
                        $sql .= "    ware_name, \n";        //出荷倉庫名
                    }else{
                        //オフライン代行の場合
                        $sql .= "    act_id, \n";           //代行ID
                        $sql .= "    act_cd1, \n";          //代行先コード
                        $sql .= "    act_cd2, \n";          //代行先コード２
                        $sql .= "    act_name, \n";         //代行先名
                        $sql .= "    act_div, \n";          //代行料区分
                        $sql .= "    act_request_rate, \n"; //代行料（率）
                        $sql .= "    act_request_price, \n";//代行料（固定額）
                        $sql .= "    trust_net_amount, \n"; //（受託先用）売上金額（税抜）
                        $sql .= "    trust_tax_amount, \n"; //（受託先用）消費税額
                    }
                    $sql .= "    cost_amount, \n";      //原価金額（税抜）
                    $sql .= "    net_amount, \n";       //売上金額（税抜）
                    $sql .= "    tax_amount, \n";       //消費税額
                    $sql .= "    note, \n";             //備考
                    $sql .= "    ps_stat, \n";          //処理状況
                    $sql .= "    shop_id, \n";          //ショップID
                    $sql .= "    slip_out, \n";         //伝票形式
                    $sql .= "    contract_div, \n";     //契約区分
                    //$sql .= "    round_form, \n";       //巡回形式
                    $sql .= "    ord_staff_id, \n";     //オペレータID
                    $sql .= "    ord_staff_name, \n";   //オペレータ名
                    //$sql .= "    daily_slip_id, \n";        //集計日報ID
                    //$sql .= "    daily_slip_out_day, \n";   //集計日報出力日
                    $sql .= "    advance_offset_totalamount, \n";   //前受相殺額合計
                    $sql .= "    hand_plan_flg \n";     //予定手書フラグ

                    $sql .= ") VALUES ( \n";

                    $sql .= "    $aord_id, \n";         //受注ID
                    //$sql .= "    '$sale_no', \n";       //受注番号
                    $sql .= "    '$sale_day', \n";      //予定巡回日
                    $sql .= "    $client_id, \n";       //得意先ID
                    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), \n";   //得意先CD1
                    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), \n";   //得意先CD2
                    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), \n"; //得意先名（略称）
                    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), \n";  //得意先名
                    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), \n"; //得意先名2
                    $sql .= "    $claim_id, \n";
                    $sql .= "    $claim_div, \n";
                    $sql .= "    '$trade_aord', \n";    //取引区分コード
                    $sql .= "    '$claim_day', \n";     //請求日

                    //直送先が指定されている場合
                    if($direct_id != null){
                        $sql .= "    $direct_id, ";
                        $sql .= "    (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), ";
                    }
                    //代行区分判定
                    if($contract_div == "1"){
                        //自社巡回の場合
                        $sql .= "    $route, \n";       //順路
                        $sql .= "    $ware_id,\n";      //出荷倉庫ID
                        $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), \n";      //出荷倉庫名
                    }else{
                        //オフライン代行の場合
                        $sql .= "    $act_id, \n";
                        $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $act_id), \n";  //代行先CD1
                        $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $act_id), \n";  //代行先CD2
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $act_id), ";  //代行先名（略称）
                        $sql .= "    '$act_div', \n";           //代行料区分
                        $sql .= "    '$act_request_rate', ";    //代行料（率）
                        $sql .= ($act_request_price != null) ? "    $act_request_price, \n" : "    null, \n";   //代行料（固定額）
                        $sql .= "    $trust_sale_money, \n";    //（受託先用）売上金額（税抜）
                        $sql .= "    $trust_sale_tax, \n";      //（受託先用）消費税額
                    }
                    $sql .= "    $cost_money, \n";      //原価金額（税抜）
                    $sql .= "    $sale_money, \n";      //売上金額（税抜）
                    $sql .= "    $sale_tax, \n";        //消費税額
                    $sql .= "    '$note', \n";          //備考
                    $sql .= "    '1', \n";              //未処理
                    $sql .= "    $cclient_shop ,\n";    //ショップID
                    $sql .= "    (SELECT slip_out FROM t_client WHERE client_id = $client_id), \n";     //伝票形式
                    $sql .= "    '$contract_div', \n";  //契約区分
                    //$sql .= "    '予定手書伝票',\n";    //巡回形式
                    $sql .= "    $e_staff_id, \n";      //オペレータID
                    $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $e_staff_id), \n";    //オペレータ名
                    //$sql .= "    $daily_slip_id, \n";   //集計日報ID
                    //$sql .= "    CURRENT_TIMESTAMP, \n";//集計日報出力日
                    $sql .= ($ad_offset_flg == true) ? "    $ad_offset_total_amount, \n" : "    NULL, \n";
                    $sql .= "    true \n";              //予定手書フラグ

                    $sql .= ");";
//print_array($sql, "受注ヘッダ登録");

                    $result = Db_Query($db_con, $sql);
                    //同時実行制御処理
                    if($result === false){
/*
                        $err_message = pg_last_error();
                        $err_format = "t_aorder_h_ord_no_key";

                        Db_Query($db_con, "ROLLBACK;");

                        //伝票番号が重複した場合            
                        if((strstr($err_message, $err_format) !== false)){ 
                            $error = "同時に登録を行ったため、伝票番号が重複しました。もう一度登録をして下さい。";

                            //再度伝票番号を取得する
                            //直営の場合
                            if($group_kind == "2"){
                                $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                            //FCの場合
                            }else{
                                $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                            }

                            $result = Db_Query($db_con, $sql);
                            $sale_no = pg_fetch_result($result, 0 ,0);
                            $sale_no = $sale_no +1;
                            $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

                            $err_data["form_sale_no"] = $sale_no;

                            $form->setConstants($err_data);

                            $duplicate_flg = true;
                        }else{
*/
                            Db_Query($db_con, "ROLLBACK;");
                            exit();
                        //}

                    }

                    //変更時は完了後に一覧へ戻る
                    if($new_entry == "false"){
                        $change_flg = "true";
                    }

/*
                }elseif($sale_no !== $chk_sale_no){

                    Db_Query($db_con, "ROLLBACK;");

                    //伝票番号が重複した場合
                    $error = "同時に登録を行ったため、伝票番号が重複しました。もう一度登録をして下さい。";

                    //再度伝票番号を取得する
                    //直営の場合
                    if($group_kind == "2"){
                        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                    //FCの場合
                    }else{
                        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                    }

                    $result = Db_Query($db_con, $sql);
                    $sale_no = pg_fetch_result($result, 0 ,0);
                    $sale_no = $sale_no +1;
                    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

                    $err_data["form_sale_no"] = $sale_no;

                    $form->setConstants($err_data);

                    $duplicate_flg = true;

                //INSERT前伝票番号重複確認おわり

                //集計日報IDが重複した
                }else{

                    //集計日報IDが重複した場合
                    $daily_slip_error = "同時に登録を行ったため、集計日報No.が重複しました。もう一度登録をして下さい。";

                    $daily_slip_error_flg = true;

                }
*/

            }//受注ヘッダ新規登録終わり


            //受注ヘッダ登録・更新が正常終了時、巡回担当テーブル、受注データテーブルを登録
            //if($duplicate_flg === false && $daily_slip_error_flg === false){

                //自社巡回の場合のみ巡回担当テーブル登録
                if($contract_div == "1"){
                    for($i=0;$i<=3;$i++){
                        //スタッフが指定されているか判定
                        if($staff_check[$i] != NULL){
                            $sql  = "INSERT INTO t_aorder_staff ( ";
                            $sql .= "    aord_id, ";
                            $sql .= "    staff_div, ";
                            $sql .= "    staff_id, ";
                            $sql .= "    sale_rate, ";
                            $sql .= "    staff_name ";
                            $sql .= ") VALUES ( ";
                            $sql .= "    $aord_id, ";                   //受注ID
                            $sql .= "    '$i', ";                       //巡回担当者識別
                            $sql .= "    ".$staff_check[$i].", ";       //巡回担当者ID
                            $sql .= ($staff_rate[$i] != NULL) ? "    ".$staff_rate[$i].", " : "    NULL, ";             //売上率
                            $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = ".$staff_check[$i].") ";      //担当者名
                            $sql .= ");";
                            $result = Db_Query($db_con, $sql);
                            if($result === false){
                                Db_Query($db_con, "ROLLBACK;");
                                exit();
                            }
                        }
                    }
                }//巡回担当者テーブル登録おわり

                //受注データ登録
                for($i = 1; $i <= 5; $i++){

                    //サービス、またはアイテムが入力されている行のみ登録
                    if($serv_id[$i] != null || $goods_item_id[$i] != null){

                        //形式変更
                        $c_price = $trade_price[$i];    //営業原価
                        $s_price = $sale_price[$i];     //売上単価

                        //自社巡回で、アイテムが入力されている場合、仕入単価（在庫単価）を求める
                        //if($goods_item_id[$i] != null){
                        if($contract_div == "1" && $goods_item_id[$i] != null){
                            //商品が構成品かどうか
                            $sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_item_id[$i].";";
                            $result = Db_Query($db_con, $sql);
                            if($result == false){
                                Db_Query($db_con, "ROLLBACK;");
                                exit();
                            }
                            $compose_flg = pg_fetch_result($result, 0, "compose_flg");

                            //商品の在庫単価（仕入単価カラムに入れる）を取得
                            if($compose_flg == "t"){
                                $array_price = Compose_price($db_con, $shop_id, $goods_item_id[$i]);
                                $b_price = $array_price[2];
                                $b_amount = $array_price[2] * $goods_item_num[$i];
                            }else{
                                $sql  = "SELECT ";
                                $sql .= "    r_price ";
                                $sql .= "FROM ";
                                $sql .= "    t_price ";
                                $sql .= "WHERE ";
                                $sql .= "    goods_id = ".$goods_item_id[$i]." ";
                                $sql .= "AND ";
                                if($_SESSION["group_kind"] == "2"){
                                    $sql .= "    shop_id IN (".Rank_Sql().") ";
                                }else{
                                    $sql .= "    shop_id = ".$shop_id." ";
                                }
                                $sql .= "AND ";
                                $sql .= "    rank_cd = '3' ";   //在庫単価
                                $sql .= ";";

                                $result = Db_Query($db_con, $sql);
                                if($result == false){
                                    Db_Query($db_con, "ROLLBACK;");
                                    exit;
                                }
                                $b_price = pg_fetch_result($result, 0, "r_price");
                                $b_amount = $b_price * $goods_item_num[$i];
                            }
                        //サービスだけ、または代行の場合は営業原価と同じ金額を入れる
                        }else{
                            $b_price = $c_price;
                            $b_amount = $trade_amount[$i];
                        }

                        //受注データ登録
                        $sql  = "INSERT INTO ";
                        $sql .= "    t_aorder_d ";
                        $sql .= "( ";
                        $sql .= "    aord_d_id, ";
                        $sql .= "    aord_id, ";
                        $sql .= "    line, ";
                        $sql .= "    sale_div_cd, ";
                        //サービス
                        if($serv_id[$i] != null){
                            $sql .= "    serv_print_flg, ";
                            $sql .= "    serv_id, ";
                            $sql .= "    serv_cd, ";
                            $sql .= "    serv_name, ";
                        }
                        //アイテム
                        if($goods_item_id[$i] != null){
                            $sql .= "    goods_print_flg, ";
                            $sql .= "    goods_id, ";
                            $sql .= "    goods_cd, ";
                            $sql .= "    goods_name, ";
                            //$sql .= "    unit, ";
                            $sql .= "    g_product_name, ";
                            $sql .= "    official_goods_name, ";
                        }
                        //数量
                        if($goods_item_num[$i] != null){
                            $sql .= "    num, ";
                        }
                        //一式フラグ
                        if($set_flg[$i] == true){
                            $sql .= "    set_flg, ";
                        }
                        //消耗品
                        if($goods_expend_id[$i] != null){
                            $sql .= "    egoods_id, ";
                            $sql .= "    egoods_cd, ";
                            $sql .= "    egoods_name, ";
                            $sql .= "    egoods_num, ";
                        }
                        //本体商品
                        if($goods_body_id[$i] != null){
                            $sql .= "    rgoods_id, ";
                            $sql .= "    rgoods_cd, ";
                            $sql .= "    rgoods_name, ";
                            $sql .= "    rgoods_num, ";
                        }
                        //紹介料
                        if($aprice_div[$i] == "2"){
                            $sql .= "    account_price, ";
                        }elseif($aprice_div[$i] == "3"){
                            $sql .= "    account_rate, ";
                        }
                        $sql .= "    tax_div, ";
                        $sql .= "    buy_price, ";
                        $sql .= "    cost_price, ";
                        $sql .= "    sale_price, ";
                        $sql .= "    buy_amount, ";
                        $sql .= "    cost_amount, ";
                        $sql .= "    sale_amount, ";
                        //代行の場合
                        if($contract_div != "1"){
                            $sql .= "    trust_sale_price, ";
                            $sql .= "    trust_sale_amount, ";
                        }
                        $sql .= "    advance_flg, ";
                        $sql .= "    advance_offset_amount ";

                        $sql .= ") VALUES ( ";

                        //受注データID取得
                        $aord_d_id = Get_Pkey();
                        $sql .= "    $aord_d_id, ";

                        $sql .= "    $aord_id, ";
                        $sql .= "    ".(string)$i.", ";
                        $sql .= "    '".$divide[$i]."', ";
                        if($serv_id[$i] != null){
                            $sql .= "    ".$slip_flg[$i].", ";
                            $sql .= "    ".$serv_id[$i].", ";
                            $sql .= "    (SELECT serv_cd FROM t_serv WHERE serv_id = ".$serv_id[$i]."), ";
                            $sql .= "    (SELECT serv_name FROM t_serv WHERE serv_id = ".$serv_id[$i]."), ";
                        }
                        if($goods_item_id[$i] != null){
                            $sql .= "    ".$goods_item_flg[$i].", ";    //アイテム印字フラグ
                            $sql .= "    ".$goods_item_id[$i].", ";     //アイテムID
                            $sql .= "    '".$goods_item_cd[$i]."', ";
                            $sql .= "    '".$goods_item_name[$i]."', ";
                            $sql .= "    (SELECT g_product_name FROM t_g_product WHERE g_product_id = (SELECT g_product_id FROM t_goods WHERE goods_id = ".$goods_item_id[$i].")), ";
                            $sql .= "    '".$official_goods_name[$i]."', "; //アイテム名（正式）
                        }
                        if($goods_item_num[$i] != null){
                            $sql .= "    ".$goods_item_num[$i].", ";
                        }
                        if($set_flg[$i] == true){
                            $sql .= "    '".$set_flg[$i]."', ";
                        }
                        //消耗品
                        if($goods_expend_id[$i] != null){
                            $sql .= "    ".$goods_expend_id[$i].", ";
                            $sql .= "    '".$goods_expend_cd[$i]."', ";
                            $sql .= "    '".$goods_expend_name[$i]."', ";
                            $sql .= "    ".$goods_expend_num[$i].", ";
                        }
                        //本体商品
                        if($goods_body_id[$i] != null){
                            $sql .= "    ".$goods_body_id[$i].", ";
                            $sql .= "    '".$goods_body_cd[$i]."', ";
                            $sql .= "    '".$goods_body_name[$i]."', ";
                            $sql .= "    ".$goods_body_num[$i].", ";
                        }
                        //紹介料
                        if($aprice_div[$i] == "2"){
                            $sql .= "    ".$ac_price[$i].", ";
                        }elseif($aprice_div[$i] == "3"){
                            $sql .= "    '".$ac_rate[$i]."', ";
                        }
                        $sql .= "    '".$tax_div[$i]."', ";
                        $sql .= "    $b_price, ";
                        $sql .= "    $c_price, ";
                        $sql .= "    $s_price, ";
                        $sql .= "    $b_amount, ";
                        $sql .= "    ".$trade_amount[$i].", ";
                        $sql .= "    ".$sale_amount[$i].", ";
                        //代行の場合
                        if($contract_div != "1"){
                            $sql .= "    ".$trust_sale_price[$i].", ";
                            $sql .= "    ".$trust_sale_amount[$i].", ";
                        }
                        $sql .= "    '".$ad_flg[$i]."', ";
                        $sql .= ($ad_flg[$i] == "2") ? "    ".$ad_offset_amount[$i]." " : "    NULL ";

                        $sql .= ");";
//echo "$sql<br>";

                        $result = Db_Query($db_con, $sql);
                        if($result == false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit();
                        }


                        //自社巡回の場合、出庫品テーブル、在庫受払を登録
                        if($contract_div == "1"){
                            $s = $i;                    //ループカウンタ
                            $cshop_id = $cclient_shop;  //ショップID（担当支店ID）
                            require(INCLUDE_DIR."plan_data_sql_stock_hand.inc");
                        }

                    }//入力行判定おわり

                }//受注データ登録終わり


                //受注ヘッダの紹介者関係を登録
                $sql  = "UPDATE \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "SET \n";
                if($intro_account_id != null){
                    $sql .= "    intro_account_id = $intro_account_id, \n";     //紹介者ID
                    $sql .= "    intro_ac_name = (SELECT client_cname FROM t_client WHERE client_id = $intro_account_id), \n";  //紹介者名（略称）
                    $sql .= "    intro_ac_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $intro_account_id), \n";     //紹介者CD1
                    $sql .= "    intro_ac_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $intro_account_id), \n";     //紹介者CD1
                }else{
                    $sql .= "    intro_account_id = null, \n";
                    $sql .= "    intro_ac_name = null, \n";
                    $sql .= "    intro_ac_cd1 = null, \n";
                    $sql .= "    intro_ac_cd2 = null, \n";
                }
                $sql .= "    intro_ac_div = '$intro_ac_div', \n";               //紹介口座区分
                $sql .= ($intro_ac_price != null) ? "    intro_ac_price = $intro_ac_price, \n" : "    intro_ac_price = null, \n";   //紹介口座単価
                $sql .= ($intro_ac_rate != null) ? "    intro_ac_rate = '$intro_ac_rate' \n" : "    intro_ac_rate = null \n";       //紹介口座率
                $sql .= "WHERE \n";
                $sql .= "    aord_id = $aord_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

                //得意先に紹介者が設定されていて、発生しないじゃない場合、紹介口座料を計算
                if($intro_account_id != null && $intro_ac_div != "1"){
                    $intro_amount = FC_Intro_Amount_Calc($db_con, "aord", $aord_id);
                }else{
                    $intro_amount = null;
                }
                //受注ヘッダの紹介料を登録
                $sql  = "UPDATE \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "SET \n";
                $sql .= ($intro_amount !== null) ? "    intro_amount = $intro_amount \n" : "    intro_amount = null \n";    //紹介口座金額
                $sql .= "WHERE \n";
                $sql .= "    aord_id = $aord_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }


                //受託先の金額更新関数
                if($group_kind == "2"){
                    $result = Update_Act_Amount($db_con, $aord_id, "aord");
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
                }


                Db_Query($db_con, "COMMIT;");


                //遷移元区分と受注ID配列を戻す
                $back_display = $_POST["back_display"];
                //アンシリアライズ化
                $array_id = serialize($aord_id_array);
                $array_id = urlencode($array_id);

                //header("Location: ".$_SERVER["PHP_SELF"]."?aord_id=$aord_id&done_flg=true&change_flg=$change_flg&installment_flg=$trade_aord");
                header("Location: ".$_SERVER["PHP_SELF"]."?aord_id=$aord_id&done_flg=true&change_flg=$change_flg&back_display=$back_display&aord_id_array=$array_id");

            //}//受注データ、受注巡回者テーブル、受注出庫品、在庫受払テーブル登録終わり

        }else{
            //登録確認画面
            if($contract_div == "1"){
                //自社巡回の場合、委託先と代行委託料を空に
                $confirm_set_data["form_daiko"] = "";
                $confirm_set_data["form_daiko_price"] = "";
            //代行の場合、倉庫と出荷倉庫を空に
            }else{
                $confirm_set_data["form_ac_staff_select"] = "";
                //$confirm_set_data["form_ware_select"] = "";
            }
            $form->setConstants($confirm_set_data);

            //登録確認画面を表示フラグ
            $comp_flg = true;
            $form->freeze();
        }
    }else{
        //エラーかつ受注IDが無ければ初期化
        //if($aord_id == NULL){
            //$client_data["form_sale_btn"]       = "";        //確認画面へボタン
            $client_data["show_button_flg"]     = "";        //表示ボタン
            $form->setConstants($client_data);
        //}
    }
}


$array_id = stripslashes($_GET["aord_id_array"]);
$array_id = urldecode($array_id);
$array_id = unserialize($array_id);
$array_id = serialize($array_id);
$array_id = urlencode($array_id);

//登録確認画面では、以下のボタンを表示しない
//if($_POST["form_sale_btn"] != "確認画面へ" && $_POST["comp_button"] != "Ｏ　Ｋ"){
if($comp_flg != true){

    //button
    $form->addElement("submit","form_sale_btn","確認画面へ", $disabled);
    //$form->addElement("button","form_back_button","戻　る","onClick=\"location.href='2-2-207.php?search=1'\"");
    $form->addElement("button","form_back_button","戻　る","onClick=\"location.href='2-2-106.php?aord_id=$aord_id&back_display=$back_display&aord_id_array=$array_id'\"");

    //合計
    $form->addElement("button","form_sum_btn","合　計","onClick=\"javascript:Button_Submit('sum_button_flg','#hand','true')\"");

//}elseif($_POST["form_sale_btn"] == "確認画面へ"){
}else{
    //登録確認画面では以下のボタンを表示
    //OK
    $form->addElement("button","comp_button","Ｏ　Ｋ", "onclick=\"Double_Post_Prevent('comp_button', 'hdn_comp_button', 'Ｏ　Ｋ');\"");
    $form->addElement("hidden","hdn_comp_button");

    $form->addElement("button","history_back","戻　る","onClick=\"javascript: history.back();\"");

}

//完了画面
if($done_flg == "true"){

    //伝票複写
    $form->addElement("button", "slip_copy_button", "伝票複写", 
        "onClick=\"Submit_Page2('".$_SERVER["PHP_SELF"]."?slip_copy=true&aord_id=".$aord_id."&back_display=$back_display&aord_id_array=$array_id');\""
    );

    //戻る
    $form->addElement("button", "return_edit_button", "戻　る", 
        //"onClick=\"javascript: location.href='".$_SERVER["PHP_SELF"]."?aord_id=$aord_id'\""
        "onClick=\"Submit_Page2('".$_SERVER["PHP_SELF"]."?aord_id=".$aord_id."&back_display=$back_display&aord_id_array=$array_id');\""
    );

    //チェックボックス復元判定フラグ
    $form->addElement("hidden", "check_value_flg", "t");
}

/*
if($_GET["renew_flg"] == "true"){
    $form->addElement("button","return_button","戻　る","onClick=\"history.back();\"");
}else{
    //$form->addElement("button","return_button","戻　る","onClick=\"location.href='./2-2-207.php?search=1'\"");
    $form->addElement("button","return_button","戻　る","onClick=\"location.href='./2-2-106.php?aord_id=$aord_id&back_display=$back_display&aord_id_array=$array_id'\"");
}
*/


$form->setConstants($con_data2);


//フォームがフリーズしてるか
$freeze_flg = $form->isFrozen();
#2009-09-18 hashimoto-y
#赤字表示行のフラグをセットする
if($freeze_flg == true){
    $num = 5;
    $toSmarty_discount_flg = array();
    for ($i=1; $i<=$num; $i++){
        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");
        if($hdn_discount_flg === 't'){
            $toSmarty_discount_flg[$i] = 't';
        }else{
            $toSmarty_discount_flg[$i] = 'f';
        }
    }
}


/****************************/
// 得意先の状態取得
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


/****************************/
//javascript
/****************************/
$java_sheet = "";

//一式にチェックを付けた場合、金額計算処理
$java_sheet  .= "function Set_num(row, coax, daiko_coax){\n";
//FC・直営判定
if($group_kind == 2){
    //直営は、代行料を考慮した計算
    $java_sheet  .= "    Mult_double3('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false,row,'',daiko_coax);\n";
}else{
    //ＦＣは、普通の一式の計算
    $java_sheet  .= "    Mult_double2('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false);\n";
}
$java_sheet  .= "}\n\n";


/*
//商品ダイアログ関数
$java_sheet  .= <<<DAIKO
function Open_SubWin_Plan(url, arr, x, y,display,select_id,shop_aid,place,head_flg)
{
    //ダイアログが指定されている場合は、倉庫ID or 棚卸調査ID が必要
    if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){

        //契約区分が通常以外は、本部の商品だけを表示
        if(head_flg != 1){
            //オンライン・オフライン代行
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,true);
        }else{
            //通常
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,false);
        }

        if(typeof(rtnarr) != "undefined"){
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }

        //契約マスタの場合は画面のリンク先にsubmitする
        if(display==6 || display==7){
            var next = '#'+place;
            document.dateForm.action=next;
            document.dateForm.submit();
        }

    }

    return false;
}

DAIKO;
*/


//代行依頼チェックボックス
$java_sheet  .= <<<DAIKO
function tegaki_daiko_checked(){
    //代行依頼判定
    if(!document.dateForm.daiko_check[0].checked){
        //オンライン代行・オフライン代行

        //代行料
        for(i=0;i<3;i++){
            document.dateForm.elements["act_div[]"][i].disabled = false;
        }
        document.dateForm.elements["act_request_price"].disabled = false;
        document.dateForm.elements["act_request_rate"].disabled = false;
        document.dateForm.elements["act_request_price"].style.backgroundColor = "white";
        document.dateForm.elements["act_request_rate"].style.backgroundColor = "white";

        //委託先
        document.dateForm.elements["form_daiko[cd1]"].disabled = false;
        document.dateForm.elements["form_daiko[cd2]"].disabled = false;
        document.dateForm.elements["form_daiko[name]"].disabled = false;
        document.dateForm.elements["form_daiko[cd1]"].style.backgroundColor = "white";
        document.dateForm.elements["form_daiko[cd2]"].style.backgroundColor = "white";
        document.dateForm.elements["form_daiko[name]"].style.backgroundColor = "white";

        //代行料区分のvalue値取得
        num = document.forms[0].elements["act_div[]"].length;
        for (i=0;i<num;i++) {
            flag = document.forms[0].elements["act_div[]"][i].checked;
            if (flag){
                act_div = document.forms[0].elements["act_div[]"][i].value;
            }
        }

        //営業原価
        if(act_div == "3"){
            for(i=1;i<=5;i++){
                form_name = "form_trade_price["+i+"][1]";
                document.dateForm.elements[form_name].readOnly = true;
                form_name = "form_trade_price["+i+"][2]";
                document.dateForm.elements[form_name].readOnly = true;
            }
        }

        //出荷倉庫
        ware_name.innerHTML = "";

        //巡回担当者
        document.dateForm.elements["form_c_staff_id1"].disabled = true;
        document.dateForm.elements["form_c_staff_id1"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_sale_rate1"].disabled = true;
        document.dateForm.elements["form_sale_rate1"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_c_staff_id2"].disabled = true;
        document.dateForm.elements["form_c_staff_id2"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_sale_rate2"].disabled = true;
        document.dateForm.elements["form_sale_rate2"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_c_staff_id3"].disabled = true;
        document.dateForm.elements["form_c_staff_id3"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_sale_rate3"].disabled = true;
        document.dateForm.elements["form_sale_rate3"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_c_staff_id4"].disabled = true;
        document.dateForm.elements["form_c_staff_id4"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_sale_rate4"].disabled = true;
        document.dateForm.elements["form_sale_rate4"].style.backgroundColor = "gainsboro";

        //順路
        document.dateForm.elements["form_route_load[1]"].disabled = true;
        document.dateForm.elements["form_route_load[1]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_route_load[2]"].disabled = true;
        document.dateForm.elements["form_route_load[2]"].style.backgroundColor = "gainsboro";

    }else{
        //通常

        //代行料
        for(i=0;i<3;i++){
            document.dateForm.elements["act_div[]"][i].disabled = true;
        }
        document.dateForm.elements["act_request_price"].disabled = true;
        document.dateForm.elements["act_request_rate"].disabled = true;
        document.dateForm.elements["act_request_price"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["act_request_rate"].style.backgroundColor = "gainsboro";

        //営業原価
        for(i=1;i<=5;i++){
            form_name = "form_trade_price["+i+"][1]";
            document.dateForm.elements[form_name].readOnly = false;
            form_name = "form_trade_price["+i+"][2]";
            document.dateForm.elements[form_name].readOnly = false;
        }

        //委託先
        document.dateForm.elements["form_daiko[cd1]"].disabled = true;
        document.dateForm.elements["form_daiko[cd2]"].disabled = true;
        document.dateForm.elements["form_daiko[name]"].disabled = true;
        document.dateForm.elements["form_daiko[cd1]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_daiko[cd2]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_daiko[name]"].style.backgroundColor = "gainsboro";

        //出荷倉庫
        ware_name.innerHTML = document.dateForm.elements["hdn_ware_name"].value;

        //巡回担当者
        document.dateForm.elements["form_c_staff_id1"].disabled = false;
        document.dateForm.elements["form_c_staff_id1"].style.backgroundColor = "white";
        document.dateForm.elements["form_sale_rate1"].disabled = false;
        document.dateForm.elements["form_sale_rate1"].style.backgroundColor = "white";
        document.dateForm.elements["form_c_staff_id2"].disabled = false;
        document.dateForm.elements["form_c_staff_id2"].style.backgroundColor = "white";
        document.dateForm.elements["form_sale_rate2"].disabled = false;
        document.dateForm.elements["form_sale_rate2"].style.backgroundColor = "white";
        document.dateForm.elements["form_c_staff_id3"].disabled = false;
        document.dateForm.elements["form_c_staff_id3"].style.backgroundColor = "white";
        document.dateForm.elements["form_sale_rate3"].disabled = false;
        document.dateForm.elements["form_sale_rate3"].style.backgroundColor = "white";
        document.dateForm.elements["form_c_staff_id4"].disabled = false;
        document.dateForm.elements["form_c_staff_id4"].style.backgroundColor = "white";
        document.dateForm.elements["form_sale_rate4"].disabled = false;
        document.dateForm.elements["form_sale_rate4"].style.backgroundColor = "white";

        //順路
        document.dateForm.elements["form_route_load[1]"].disabled = false;
        document.dateForm.elements["form_route_load[1]"].style.backgroundColor = "white";
        document.dateForm.elements["form_route_load[2]"].disabled = false;
        document.dateForm.elements["form_route_load[2]"].style.backgroundColor = "white";

    }
    
    return true;
}

DAIKO;


//代行のJSを追加
$java_sheet .= Create_Js("daiko");

//plan_data.incのJSを追加
$java_sheet .= $plan_data_js;



/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

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
    'warning'       => "$warning",
    //'html'          => "$html",
    'form_potision' => "$form_potision",
    'error_flg'     => $error_flg,
    //'duplicate_err' => "$error",
    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_msg16'   => "$error_msg16",
    //'daily_slip_error'  => "$daily_slip_error",
    //'sale_div_error' => "$sale_div_error",
    'comp_flg'      => "$comp_flg",
    'auth_r_msg'    => "$auth_r_msg",
    'done_flg'      => "$done_flg", 
    'client_id'     => "$client_id", 
    'aord_id'       => "$aord_id", 
    'html_js'       => "$java_sheet", 
    'renew_flg'     => "$renew_flg", 
    'new_entry'     => "$new_entry",
    'slip_del_flg'  => "$slip_del_flg",
    'slip_renew_mess' => "$slip_renew_mess",
    'ad_total_warn_mess'    => "$ad_total_warn_mess",
    'freeze_flg'    => $freeze_flg,
    'buy_err_mess'  => "$buy_err_mess",
    'ac_name'       => "$ac_name",
    'warn_lump_change'		=> "$warn_lump_change",	//rev.1.3 予定巡回日2ヶ月以上離れているメッセージ

    'contract_div'  => "$contract_div",
    "client_state_print"    => "$client_state_print",
));

$smarty->assign('error_msg4',$error_msg4);
$smarty->assign('error_msg5',$error_msg5);
$smarty->assign('error_msg10',$error_msg10);

$loop_array = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");
$smarty->assign('loop_num',$loop_array);
$smarty->assign('error_loop_num1',$loop_array);
$error_loop_num3 = array(0=>"0",1=>"1",2=>"2",3=>"3",4=>"4");
$smarty->assign('error_loop_num3',$error_loop_num3);

#2009-09-17 hashimoto-y
$smarty->assign('toSmarty_discount_flg',$toSmarty_discount_flg);


//テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"] .".tpl"));


//echo "<font color=red style=\"font-family: 'HGS行書体';\"><b>編集中につき、あまり登録できません</b></font>";
//print_array($smarty);
//print_array ($_POST);
//print_array ($_SESSION);
//print_array($new_entry, '$new_entry');

?>
