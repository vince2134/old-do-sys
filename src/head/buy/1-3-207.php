<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 2007/01/25                  watanabe-k  ボタンの色変更  
 * 2007/02/28                  morita-d  商品名は正式名称を表示するように変更 
 * 2007/03/09    要望9-1       kajioka-h   入荷日を変更すると仕入日が変わるように変更
 * 2007/03/13                  watanabe-k  取引区分に得意先の情報を取得するように修正
 * 2007/03/13                  watanabe-k  商品の重複エラーを具体的に選択するように修正
 * 2007/05/18                  watanabe-k  直送先のプルダウンを変更
 * 2007/06/10                  watanabe-k  発注から起こした仕入れで行追加を可能にする 
 * 2007/06/29                   fukuda      備考の入力フォームを大きくする
 * 2007-07-12                  fukuda      「支払締」を「仕入締」に変更
 * 2007-07-13                  watanabe-k  0除算の警告が表示されるバグの修正
 * 2007-08-28                  watanabe-k  仕入数が発注数を上回った場合に発注残の打消し処理を仕入数で行なわず、発注数で行なう。
 * 2007-12-01                  watanabe-k  複数回仕入れを行う場合に発注残を多く打消ししてしまうバグの修正
 * 2009-09-01                  aoyama-n    値引機能追加 
 * 2009-09-15                  aoyama-n    取引区分の値引・返品および値引商品は赤字で表示
 * 2009/09/28      なし        hashimoto-y 取引区分から値引きを廃止
 * 2009/10/13                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 * 2009/10/19      なし        hashimoto-y 発注残から遷移した場合に、仕入単価が変更できないバグ修正
 * 2009/10/20      なし        hashimoto-y 10-19の修正のバグ（商品コードが入力できる）
 * 2009/12/21      なし        aoyama-n    税率をTaxRateクラスから取得 
 *   2016/01/22                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応 
 */

$page_title = "仕入入力";

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_motocho.inc");
require_once(INCLUDE_DIR."function_buy.inc");
//print_array($_POST);

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
//外部変数取得
/*****************************/
$shop_id  = $_SESSION["client_id"];
$rank_cd  = $_SESSION["rank_cd"];
$staff_id = $_SESSION["staff_id"];


/*****************************/
// 再遷移先をSESSIONにセット
/*****************************/
// GET、POSTが無い場合
if ($_GET == null && $_POST["form_buy_button"] == null && $_POST["form_comp_button"] == null){
    Set_Rtn_Page("buy");
}


/*****************************/
//初期表示設定
/*****************************/

#2009-12-21 aoyama-n
//税率クラス　インスタンス生成
$tax_rate_obj = new TaxRate($shop_id);

//自動採番の発注番号取得
$sql  = "SELECT";
$sql .= "   MAX(buy_no)";
$sql .= " FROM";
$sql .= "   t_buy_h";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= ";"; 

$result = Db_Query($db_con, $sql);
$order_no = pg_fetch_result($result, 0 ,0);
$order_no = $order_no +1;
$order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

$def_data["form_buy_no"] = $order_no;

//倉庫
//倉庫が選択されていた場合は倉庫選択フラグを立てる
$ware_search_flg = ($_POST["form_ware"] != null)? true : false;

$sql  = "SELECT";
$sql .= "   ware_id";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_id = $shop_id";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$def_ware_id = pg_fetch_result($result ,0,0);
if($def_ware_flg != null){
    $ware_search_flg = true;
}

$def_data["form_ware"] = $def_ware_id;

//出荷可能数
$def_data["form_designated_date"] = 7;

//担当者
$def_data["form_buy_staff"] = $staff_id;

//取引区分
$def_data["form_trade"] = 21;

// 入荷日
$def_data["form_arrival_day"]["y"] = date("Y");
$def_data["form_arrival_day"]["m"] = date("m");
$def_data["form_arrival_day"]["d"] = date("d");

// 仕入日
$def_data["form_buy_day"]["y"] = date("Y");
$def_data["form_buy_day"]["m"] = date("m");
$def_data["form_buy_day"]["d"] = date("d");

$form->setDefaults($def_data);

//初期表示位置変更
$form_potision = "<body bgcolor=\"#D8D0C8\">";

/*****************************/
//初期設定＆共通処理
/*****************************/
//自分の消費税を抽出
#2009-12-21 aoyama-n
#$sql  = "SELECT";
#$sql .= "   tax_rate_n";
#$sql .= " FROM";
#$sql .= "   t_client";
#$sql .= " WHERE";
#$sql .= "   client_id = $shop_id";
#$sql .= ";";

#$result = Db_Query($db_con, $sql);
#$tax_rate = pg_fetch_result($result,0,0);
#$rate  = bcdiv($tax_rate,100,2);        //消費税率

//データ表示行数
if($_POST["max_row"] != NULL){
    $max_row = $_POST["max_row"];
//初期表示のみ
}else{
    $max_row = 5;
}

//仕入先IDの有無により、仕入先情報を取得
$client_search_flg = ($_POST["hdn_client_id"] != NULL)? true : false;

if($client_search_flg == true){
    //仕入先の情報を取得
    $client_id  = $_POST["hdn_client_id"];      //仕入先ID
    $coax       = $_POST["hdn_coax"];           //丸め区分
    $tax_franct = $_POST["hdn_tax_franct"];     //端数区分
}else{
    $client_search_flg = false;
}

//発注IDがあれば、発注フラグを立てる
$order_flg = ($_POST["hdn_order_id"] != null)? true : false;

if($order_flg == true){
     $order_id = $_POST["hdn_order_id"];
}

//削除行数
$del_history[] = NULL;

//Submitした場合に持ちまわるデータ
$goods_id       = $_POST["hdn_goods_id"];
$stock_manage   = $_POST["hdn_stock_manage"];
$name_change    = $_POST["hdn_name_change"];
$order_d_id     = $_POST["hdn_order_d_id"];

/****************************/
//行削除処理
/****************************/
if($_POST["del_row"] != NULL){
    $now_form = NULL;    //削除リストを取得
    $del_row = $_POST["del_row"];    //削除履歴を配列にする。
    $del_history = explode(",", $del_row);

    //削除したデータの商品ID等にNULLをセット
    for($i = 0; $i < count($del_history); $i++){
        $goods_id[$del_histoty[$i]]     = null;
        $stock_num[$del_history[$i]]    = null;
        $stock_manage[$del_history[$i]] = null;
        $name_change[$del_history[$i]]  = null;
    }
    //削除した行数
    $del_num     = count($del_history)-1;
}

/****************************/
//行数追加
/****************************/
if($_POST["add_row_flg"]== 'true'){
    //最大行に、＋５する
    $max_row = $_POST["max_row"]+5;

    //行数追加フラグをクリア
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//各処理判定
/****************************/
//仕入先が入力された場合、仕入先検索フラグにtrueをセット
$client_input_flg = ($_POST["hdn_client_search_flg"] == 'true')? true : false;       //仕入先入力判定フラグ

//商品が選択された場合、商品検索フラグにtrueをセット
$goods_search_flg = ($_POST["hdn_goods_search_flg"] != NULL)? true : false;       //商品検索フラグ

//合計ボタンが押下された場合
$sum_button_flg = ($_POST["hdn_sum_button_flg"] == 't')? true : false;            //合計ボタン押下フラグ

//変更の場合（ord_idがGetで渡ってきた場合）、変更フラグにtrueをセット
$update_data_flg = ($_GET["buy_id"] != NULL)? true : false;                            //発注変更フラグ
Get_Id_Check3($_GET["buy_id"]);
$update_flg = ($_POST["hdn_buy_id"] != null)? true : false;
$get_buy_id = $_POST["hdn_buy_id"];

//表示ボタンが押下された場合
$show_button_flg = ($_POST["hdn_show_button_flg"] == "t")? true : false;   //表示ボタン押下フラグ

//GETで発注IDがあった場合
$get_ord_id_flg  = ($_GET["ord_id"] != null)? true : false;                     //発注残からの遷移フラグ
Get_Id_Check3($_GET["ord_id"]);
/****************************/
//合計処理
/****************************/
//合計ボタン押下フラグがtrueの場合
if($sum_button_flg == true){

    $buy_data   = $_POST["form_buy_amount"];   //仕入金額
    $price_data = NULL;                        //商品の仕入金額
    $tax_div    = NULL;                        //課税区分

    //仕入金額の合計値計算
    for($i=0;$i<$max_row;$i++){
        if($buy_data[$i] != "" && !in_array("$i", $del_history)){
            $price_data[] = $buy_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
        }       
    }

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_buy_day"]["y"]."-".$_POST["form_buy_day"]["m"]."-".$_POST["form_buy_day"]["d"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

    //初期表示位置変更
    $height = $max_row * 30;
    $form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";

    //フォームに値セット
    $set_data["form_buy_money"]     = number_format($data[0]);
    $set_data["form_tax_money"]     = number_format($data[1]);
    $set_data["form_total_money"]   = number_format($data[2]);
    $set_data["hdn_sum_button_flg"] = "";   

/****************************/
//仕入変更処理
/****************************/
}elseif($update_data_flg == true && $_POST[hdn_ware_select_flg] != 't' && $goods_search_flg == false){
    $get_buy_id = $_GET["buy_id"];

    //仕入ヘッダ
    $sql  = "SELECT\n";
    $sql .= "   t_buy_h.buy_id,\n";
    $sql .= "   t_buy_h.buy_no,\n";
    $sql .= "   t_order_h.ord_no,\n";
    $sql .= "   to_date(t_order_h.ord_time,'YYYY/mm/dd') AS ord_time ,\n";
    $sql .= "   t_order_h.arrival_day AS arrival_hope_day,\n";
    $sql .= "   t_client.client_id,\n";
    $sql .= "   t_client.client_cd1,\n";
    $sql .= "   t_client.client_cd2,\n";
//    $sql .= "   t_client.client_name,\n";
    $sql .= "   t_client.client_cname,\n";
    $sql .= "   t_client.tax_franct,\n";
    $sql .= "   t_client.coax,\n";
    $sql .= "   t_buy_h.direct_id\n,";
    $sql .= "   t_buy_h.ware_id,\n";
    $sql .= "   t_buy_h.trade_id,\n";
    $sql .= "   t_buy_h.c_staff_id,\n";
    $sql .= "   t_buy_h.note,\n";
    $sql .= "   t_buy_h.renew_flg,\n";
    $sql .= "   t_buy_h.ord_id,\n";
    $sql .= "   t_buy_h.buy_day,\n";
    $sql .= "   t_buy_h.arrival_day,\n";
    $sql .= "   t_buy_h.oc_staff_id,\n";
    $sql .= "   t_order_h.enter_day AS ord_enter_day,\n";
    $sql .= "   t_buy_h.enter_day AS buy_enter_day, \n";
    $sql .= "   t_order_h.change_day \n";
    $sql .= " FROM\n";
    $sql .= "   t_buy_h\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   t_order_h\n";
    $sql .= "   ON t_buy_h.ord_id = t_order_h.ord_id\n ";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_client\n";
    $sql .= "   ON t_buy_h.client_id = t_client.client_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_buy_h.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.buy_id = $get_buy_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.renew_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.buy_div = '2'\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);

    Get_Id_Check($result);
    $buy_h_data = pg_fetch_array($result);

    $order_id = $buy_h_data["ord_id"];

    //発注日時を分割
    $order_date = explode("-",$buy_h_data["ord_time"]);

    //入荷予定日を分割
    $arrival_hope_date = explode("-",$buy_h_data["arrival_hope_day"]);

    //仕入日を分割
    $buy_date   = explode("-",$buy_h_data["buy_day"]);

    //入荷日を分割
    $arrival_date   = explode("-", $buy_h_data["arrival_day"]);

    $set_data["hdn_buy_id"]                     = $buy_h_data["buy_id"];        //仕入ID
    $set_data["form_buy_no"]                    = $buy_h_data["buy_no"];        //仕入番号
    $set_data["hdn_order_id"]                   = $buy_h_data["ord_id"];        //発注ID
    $set_data["form_order_no"]                  = $buy_h_data["ord_no"];        //発注番号
    $set_data["form_order_day"]["y"]            = $order_date[0];               //発注日（年）
    $set_data["form_order_day"]["m"]            = $order_date[1];               //発注日（月）
    $set_data["form_order_day"]["d"]            = $order_date[2];               //発注日（日）
    $set_data["form_arrival_hope_day"]["y"]     = $arrival_hope_date[0];        //入荷予定日（年）
    $set_data["form_arrival_hope_day"]["m"]     = $arrival_hope_date[1];        //入荷予定日（月）
    $set_data["form_arrival_hope_day"]["d"]     = $arrival_hope_date[2];        //入荷予定日（日）
    $set_data["hdn_client_id"]                  = $buy_h_data["client_id"];     //仕入先ID
    $set_data["form_client"]["cd1"]             = $buy_h_data["client_cd1"];   //仕入先CD
    $set_data["form_client"]["cd2"]             = $buy_h_data["client_cd2"];   //仕入先CD
    $set_data["form_client"]["name"]            = $buy_h_data["client_cname"];  //仕入先名
    $set_data["hdn_coax"]                       = $buy_h_data["coax"];          //丸め区分
    $set_data["hdn_tax_franct"]                 = $buy_h_data["tax_franct"];    //端数区分
    $set_data["form_direct"]                    = $buy_h_data["direct_id"];     //直送先
    $set_data["form_ware"]                      = $buy_h_data["ware_id"];       //倉庫
    $set_data["form_trade"]                     = $buy_h_data["trade_id"];      //取引区分
    $set_data["form_buy_staff"]                 = $buy_h_data["c_staff_id"];    //仕入担当者
    $set_data["form_note"]                      = $buy_h_data["note"];          //備考
    $set_data["form_arrival_day"]["y"]          = $arrival_date[0];             //入荷予定日（年）
    $set_data["form_arrival_day"]["m"]          = $arrival_date[1];             //入荷予定日（月）
    $set_data["form_arrival_day"]["d"]          = $arrival_date[2];             //入荷予定日（日）
    $set_data["form_buy_day"]["y"]              = $buy_date[0];                 //入荷予定日（年）
    $set_data["form_buy_day"]["m"]              = $buy_date[1];                 //入荷予定日（月）
    $set_data["form_buy_day"]["d"]              = $buy_date[2];                 //入荷予定日（日）
    $set_data["form_order_staff"]               = $buy_h_data["oc_staff_id"];   //発注担当者
    $set_data["hdn_ord_enter_day"]              = $buy_h_data["ord_enter_day"]; //発注入力日
    $set_data["hdn_buy_enter_day"]              = $buy_h_data["buy_enter_day"]; //仕入入力日
    $set_data["hdn_ord_change_day"]             = $buy_h_data["change_day"];    //発注変更日時

    //以降の処理で持ちまわる得意先ID
    $client_id  = $buy_h_data["client_id"];
    $tax_franct = $buy_h_data["tax_franct"];
    $coax       = $buy_h_data["coax"];

    //仕入データ
    $sql  = "SELECT\n";
    $sql .= "   t_buy_d.ord_d_id,\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_buy_d.goods_cd,\n";
    $sql .= "   t_buy_d.goods_name,\n";
    $sql .= "   t_goods.tax_div,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";

    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS stock_num,\n";
    $sql .= "   t_order_d.num AS order_num,\n";
    $sql .= "   t_buy_d.num AS buy_num,\n";
    $sql .= "   t_buy_d.buy_price,\n";
    $sql .= "   t_buy_d.buy_amount,\n";
    $sql .= "   CASE\n";
    $sql .= "       WHEN t_order_d.num IS NOT NULL THEN t_order_d.num - COALESCE(t_buy_d.num,0)\n";
    $sql .= "   END AS on_order_num,\n";
    $sql .= "   t_goods.name_change,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";

    //aoyama-n 2009-09-01
    #$sql .= "   t_goods.in_num\n";
    $sql .= "   t_goods.in_num,\n";
    $sql .= "   t_goods.discount_flg\n";
    $sql .= " FROM\n";
    $sql .= "   t_buy_h\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_buy_d\n";
    $sql .= "   ON t_buy_h.buy_id = t_buy_d.buy_id\n";
    $sql .= "   LEFT JOIN\n ";
    $sql .= "   (SELECT\n";
    $sql .= "       goods_id,\n";
    $sql .= "       SUM(stock_num)AS stock_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "   WHERE\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       ware_id = $buy_h_data[ware_id]\n";
    $sql .= "       GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_buy_d.goods_id = t_stock.goods_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods\n";
    $sql .= "   ON t_buy_d.goods_id = t_goods.goods_id";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   t_order_d\n";
    $sql .= "   ON t_buy_d.ord_d_id = t_order_d.ord_d_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods_info\n";
    $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id";
    $sql .= " WHERE\n";
    $sql .= "   t_buy_d.buy_id = $get_buy_id\n";
    $sql .= "   AND\n ";
    $sql .= "   t_buy_h.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods_info.shop_id = $shop_id\n";
    $sql .= " ORDER BY t_buy_d.line\n ";
    $sql .= ";\n"; 

    $result = Db_Query($db_con, $sql);
    $num = pg_num_rows($result);

    //以降の処理で持ちまわるデータ
    $goods_id = null;
    $stock_manage = null;
    $name_change = null;

    for($i = 0; $i < $num; $i++){
        $buy_d_data = pg_fetch_array($result, $i );
        $price_data = explode('.',$buy_d_data[8]);

        $buy_amount[]   = $buy_d_data[9];
        $tax_div[]      = $buy_d_data[4];

        $set_data["hdn_order_d_id"][$i]         = $buy_d_data["ord_d_id"];                                          //発注データID
        $set_data["hdn_goods_id"][$i]           = $buy_d_data["goods_id"];                                          //商品ID
        $set_data["form_goods_cd"][$i]          = $buy_d_data["goods_cd"];                                          //商品CD
        $set_data["form_goods_name"][$i]        = $buy_d_data["goods_name"];                                        //商品名
        $set_data["hdn_tax_div"][$i]            = $buy_d_data["tax_div"];                                           //課税区分（hidden用）
        $set_data["form_stock_num"][$i]         = $buy_d_data["stock_num"];                                         //在庫数
        $set_data["form_order_num"][$i]         = ($buy_h_data["ord_no"] != null)? $buy_d_data["order_num"] : '-';  //発注数
        $set_data["form_buy_num"][$i]           = $buy_d_data["buy_num"];                                           //仕入数
        $set_data["form_buy_price"][$i]["i"]    = $price_data[0];                                                   //仕入単価（整数部）
        $set_data["form_buy_price"][$i]["d"]    = ($price_data[1] != NULL)? $price_data[1] : "00";                  //仕入単価（少数部）
        $set_data["form_buy_amount"][$i]        = number_format($buy_d_data[9]);                                    //仕入金額（税抜き）
        $set_data["form_rorder_num"][$i]        = ($buy_h_data["ord_no"] != null)? $buy_d_data["on_order_num"] : '-';//発注残
        $set_data["hdn_name_change"][$i]        = $buy_d_data["name_change"];                                       //品名変更
        $set_data["hdn_stock_manage"][$i]       = $buy_d_data["stock_manage"];                                      //在庫管理
        $set_data["form_in_num"][$i]            = $buy_d_data["in_num"];                                            //入数
        //aoyama-n 2009-09-01
        $set_data["hdn_discount_flg"][$i]       = $buy_d_data["discount_flg"];                                      //値引フラグ

        if($buy_d_data["buy_num"]%$buy_d_data["in_num"] == 0 && $buy_d_data["in_num"]!=null && $buy_d_data["in_num"] !=0){
            $set_buy_data["form_order_in_num"]  = $buy_d_data["buy_num"]/$buy_d_data["in_num"];
        }

    //以降の処理で持ちまわるデータ
        $goods_id[$i]                         = $buy_d_data["goods_id"];             //商品ID
        $stock_manage[$i]                     = $buy_d_data["stock_manage"];         //在庫管理（在庫数表示判定）
        $name_change[$i]                      = $buy_d_data["name_change"];          //品名変更（品名変更付加判定）
        $order_d_id[$i]                       = $buy_d_data["ord_d_id"];             //発注データID
    }

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($buy_h_data["buy_day"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

    //フォームに値セット
    $set_data["form_buy_money"]     = number_format($data[0]);
    $set_data["form_tax_money"]     = number_format($data[1]);
    $set_data["form_total_money"]   = number_format($data[2]);

    //Getで取得した発注IDをhiddenで持ちまわる
//    $set_data["hdn_order_id"] = $get_ord_id;
    if($buy_h_data["ord_id"] != null){
        $order_flg = true;
    }

    $max_row = $num;
    $client_search_flg = true;
    $ware_search_flg = true;
    $update_flg = true;

/****************************/
//仕入先コード入力
/****************************/
}elseif($client_input_flg == true){
    $client_cd1 = $_POST["form_client"]["cd1"];         //得意先コード
    $client_cd2 = $_POST["form_client"]["cd2"];         //得意先コード

    //指定された仕入先の情報を抽出
    $sql  = "SELECT";
    $sql .= "   client_id,";                            //仕入先ID
    $sql .= "   client_cname,";                         //仕入先名
    $sql .= "   coax,";                                 //丸め区分
    $sql .= "   tax_franct,";                            //端数区分
    $sql .= "   buy_trade_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '3'";
    $sql .= "   AND";
    $sql .= "   shop_id = '$shop_id'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_client_data_count = pg_num_rows($result);
    $get_client_data       = pg_fetch_array($result);

    //該当する仕入先があった場合のみ処理開始
    if($get_client_data_count > 0){
        //以降の処理で持ちまわる得意先ID
        $client_id  = $get_client_data["client_id"];
        $tax_franct = $get_client_data["tax_franct"];
        $coax       = $get_client_data["coax"];

        //抽出した仕入先の情報をセット
        $set_data = NULL;
        $set_data["hdn_client_id"]                  = $get_client_data["client_id"];        //仕入先ID
        $set_data["form_client"]["name"]            = $get_client_data["client_cname"];     //仕入先名
        $set_data["hdn_tax_franct"]                 = $get_client_data["tax_franct"];       //丸め区分
        $set_data["hdn_coax"]                       = $get_client_data["coax"];             //端数区分
        $set_data["form_trade"]                     = $get_client_data["buy_trade_id"];     //取引区分

        //該当する仕入先があるので、仕入先検索フラグを立てる
        //警告メッセージを初期化
        $client_search_flg = true;

    //該当するデータがなかった場合は、既に入力済みの商品データを全て初期化
    }else{
        $set_data = NULL;       //セットするデータの初期化
        $set_data["hdn_client_id"]                  = "";       //仕入先ID
        $set_data["form_client"]["name"]            = "";       //仕入先名

        for($i = 0; $i < $max_row; $i++){
            $set_data["hdn_goods_id"][$i]           = "";       //商品ID
            $set_data["form_goods_cd"][$i]          = "";       //商品CD
            $set_data["form_goods_name"][$i]        = "";       //商品名
            $set_data["hdn_stock_manage"][$i]       = "";       //在庫管理
            $set_data["hdn_name_change"][$i]        = "";       //品名変更
            $set_data["form_stock_num"][$i]         = "";       //現在個数
            $set_data["form_rstock_num"][$i]        = "";       //発注済数
            $set_data["form_rorder_num"][$i]        = "";       //出荷可能数
            $set_data["form_designated_num"][$i]    = "";       //引当数
            $set_data["form_buy_price"][$i]["i"]    = "";       //仕入単価（整数部）
            $set_data["form_buy_price"][$i]["d"]    = "";       //仕入単価（少数部）
            $set_data["hdn_tax_div"][$i]            = "";       //課税区分
            $set_data["form_in_num"][$i]            = "";       //入数
            $set_data["form_order_in_num"][$i]      = "";       //入数
            $set_data["form_buy_amount"][$i]        = "";       //発注金額
            $set_data["form_buy_num"][$i]           = "";       //発注金額
            //aoyama-n 2009-09-01
            $set_data["hdn_discount_flg"][$i]       = "";       //値引フラグ

            $goods_id     = null;
            $stock_manage = null;
            $name_change  = null;
            $client_id    = null;
        }

        //該当する仕入先がないので、仕入先検索フラグにはfalseをセット
        $client_search_flg = false;
    }

    //仕入先検索フラグを初期化
    $set_data["hdn_client_search_flg"]              = "";

/****************************/
//仕入倉庫入力
/****************************/
//}elseif($ware_select_flg == true){
}elseif($_POST[hdn_ware_select_flg] == true){
    $ware_id = $_POST["form_ware"];

    if($ware_id != NULL){
        //商品が１つ以上選択されていれば処理開始
        for($i = 0; $i < $max_row; $i++){
            $goods_id = $_POST["hdn_goods_id"][$i];

            if($goods_id != NULL){
                $sql  = "SELECT";
                $sql .= "   stock_num";
                $sql .= " FROM";
                $sql .= "   t_stock";
                $sql .= " WHERE";
                $sql .= "   shop_id = $shop_id";
                $sql .= "   AND";
                $sql .= "   ware_id = $ware_id";
                $sql .= "   AND";
                $sql .= "   goods_id = $goods_id";
                $sql .= ";";

                $result         = Db_Query($db_con, $sql);
                $stock_data_num = pg_num_rows($result);

                if($stock_data_num != 0){
                    $stock_data = pg_fetch_result($result,0,0);
                }

                $set_data["form_stock_num"][$i] = ($stock_data != NULL)? $stock_data : 0;     //現在個数
            }
        }
        $ware_search_flg = true;
    }else{
        $ware_search_flg = false;
    }

    $set_data["hdn_ware_select_flg"]    = "";

/****************************/
//発注IDがある場合
/****************************/
//表示ボタン検索フラグがtrue
}elseif($show_button_flg == true || $get_ord_id_flg == true){
    //表示ボタン押下時
    if($show_button_flg == true){
       $get_order_id = $_POST["form_order_no"];
    }elseif($get_ord_id_flg == true){
       $get_order_id = $_GET["ord_id"];
    }

    if($get_order_id != null){

        $sql  = " SELECT\n";
        $sql .= "   t_order_h.ord_id,\n";
        $sql .= "   to_date(t_order_h.ord_time,'YYYY/mm/dd') AS ord_time,\n";
        $sql .= "   arrival_day,\n";
        $sql .= "   t_client.client_id,\n";
        $sql .= "   t_client.client_cd1,\n";
        $sql .= "   t_client.client_cd2,\n";
//        $sql .= "   t_client.client_name,\n";
        $sql .= "   t_client.client_cname,\n";
        $sql .= "   t_client.coax,\n";
        $sql .= "   t_client.tax_franct,\n";
        $sql .= "   t_order_h.direct_id,\n";
        $sql .= "   t_order_h.ware_id,\n";
        $sql .= "   t_order_h.trade_id,\n";
        $sql .= "   t_order_h.c_staff_id,\n";
        $sql .= "   t_order_h.ps_stat,\n";
        $sql .= "   t_client.head_flg,\n";
        $sql .= "   t_order_h.ord_staff_id,\n";
        $sql .= "   t_order_h.enter_day,";
        $sql .= "   t_order_h.ord_no,";
        $sql .= "   t_order_h.change_day";
        $sql .= " FROM\n";
        $sql .= "   t_order_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_client\n";
        $sql .= "   ON t_order_h.client_id = t_client.client_id\n";
        $sql .= " WHERE\n";
        $sql .= "   (t_order_h.ord_stat <> 3\n";
        $sql .= "   OR\n";
        $sql .= "   t_order_h.ord_stat IS NULL)\n";
        $sql .= "   AND\n";
        $sql .= "   t_order_h.ord_id = $get_order_id\n";
        $sql .= "   AND\n";
        $sql .= "   t_order_h.shop_id = $shop_id\n";
        $sql .= "   AND\n";
        $sql .= "   t_order_h.ps_stat IN (1,2)\n";
        $sql .= ";\n";

        $result         = Db_Query($db_con, $sql);
        Get_Id_Check($result);
        $get_ord_h_data = pg_fetch_array($result, $sql);
        $get_ord_h_num  = pg_num_rows($result);

        //抽出したデータを表示する形式に変更
        $order_date     = explode("-", $get_ord_h_data["ord_time"]);
        $arrival_date   = explode("-", $get_ord_h_data["arrival_day"]);

        //抽出した仕入先の情報をセット
        $set_data = NULL;
        $set_data["hdn_client_id"]              = $get_ord_h_data["client_id"];     //仕入先ID
        $set_data["form_client"]["cd1"]          = $get_ord_h_data["client_cd1"];    //仕入先CD
        $set_data["form_client"]["cd2"]          = $get_ord_h_data["client_cd2"];    //仕入先CD
        $set_data["form_client"]["name"]        = $get_ord_h_data["client_cname"];  //仕入先名
        $set_data["hdn_tax_franct"]             = $get_ord_h_data["tax_franct"];    //丸め区分
        $set_data["hdn_coax"]                   = $get_ord_h_data["coax"];          //端数区分

        //データをフォームにセット
        $set_data["hdn_order_id"]               = $get_ord_h_data["ord_id"];        //発注ID（hidden用）
        $set_data["form_order_no"]              = $get_ord_h_data["ord_id"];        //発注ID
        $set_data["form_order_day"]["y"]        = $order_date[0];                   //発注日
        $set_data["form_order_day"]["m"]        = $order_date[1];
        $set_data["form_order_day"]["d"]        = $order_date[2];
        $set_data["form_arrival_hope_day"]["y"] = $arrival_date[0];                 //入荷予定日
        $set_data["form_arrival_hope_day"]["m"] = $arrival_date[1];
        $set_data["form_arrival_hope_day"]["d"] = $arrival_date[2];
        $set_data["form_direct"]                = $get_ord_h_data["direct_id"];     //直送先
        $set_data["form_ware"]                  = $get_ord_h_data["ware_id"];       //倉庫ID
        $set_data["form_trade"]                 = $get_ord_h_data["trade_id"];      //取引区分
        $set_data["form_order_staff"]           = $get_ord_h_data["ord_staff_id"];  //発注担当者
        $set_data["form_buy_staff"]             = $get_ord_h_data["c_staff_id"];    //担当者ID
        $set_data["hdn_ord_enter_day"]          = $get_ord_h_data["enter_day"];     //発注登録日
        $set_data["hdn_ord_change_day"]         = $get_ord_h_data["change_day"];    //発注変更日

        //以降の処理で持ちまわる値
        $client_search_flg = true;                                                  //仕入先検索フラグ
        $ware_search_flg   = true;                                                  //倉庫検索フラグ
        $client_id         = $get_ord_h_data["client_id"];                          //仕入先ID
        $coax              = $get_ord_h_data["coax"];                               //丸め区分
        $tax_franct        = $get_ord_h_data["tax_franct"];

        //発注データを抽出
        $sql  = "SELECT\n";
        $sql .= "   t_order_d.ord_d_id,\n";                                         //発注データID
        $sql .= "   t_goods.goods_id,\n";                                           //商品ID
        $sql .= "   t_order_d.goods_cd,\n";                                         //商品コード
        $sql .= "   t_order_d.goods_name,\n";                                       //商品名
        #2009-10-13 hashimoto-y
        #$sql .= "   CASE t_goods.stock_manage\n";                                   //在庫管理
        $sql .= "   CASE t_goods_info.stock_manage\n";                                   //在庫管理

        $sql .= "        WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
        $sql .= "   END AS stock_num,\n";
        $sql .= "   t_order_d.num AS order_num,\n";                                 //発注数
        $sql .= "   COALESCE(t_buy.buy_num,0) AS buy_num,\n";                       //仕入数
        $sql .= "   t_order_d.buy_price,\n";                                        //仕入単価
        $sql .= "   t_order_d.tax_div,\n";                                          //課税区分
        $sql .= "   t_order_d.buy_amount,\n";                                       //仕入金額
        $sql .= "   t_goods.name_change,\n";                                        //品名変更
        //aoyama-n 2009-09-01
        #$sql .= "   t_goods.in_num\n";                                              //入数
        $sql .= "   t_goods.in_num,\n";                                             //入数
        $sql .= "   t_goods.discount_flg\n";                                        //値引フラグ
        $sql .= " FROM\n";
        $sql .= "   t_order_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_order_d\n";
        $sql .= "   ON t_order_h.ord_id = t_order_d.ord_id\n";
        $sql .= "       LEFT JOIN\n";
        $sql .= "   (SELECT\n";
        $sql .= "       goods_id,\n";
        $sql .= "       SUM(stock_num)AS stock_num\n";
        $sql .= "   FROM\n";    
        $sql .= "       t_stock\n";     
        $sql .= "   WHERE\n";   
        $sql .= "        shop_id = $shop_id\n";     
        $sql .= "        AND\n";    
        $sql .= "        ware_id = $get_ord_h_data[ware_id]\n";     
        $sql .= "   GROUP BY t_stock.goods_id\n";   
        $sql .= "   )AS t_stock\n";     
        $sql .= "   ON t_order_d.goods_id = t_stock.goods_id\n";    
        $sql .= "       LEFT JOIN\n";   
        $sql .= "   (SELECT\n ";    
        $sql .= "       ord_d_id,\n";   
        $sql .= "       SUM(num) AS buy_num\n";     
        $sql .= "   FROM\n";    
        $sql .= "       t_buy_d\n";     
        $sql .= "   GROUP BY ord_d_id\n";   
        $sql .= "   )t_buy\n";  
        $sql .= "   ON t_order_d.ord_d_id = t_buy.ord_d_id\n";  
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_goods\n";
        $sql .= "   ON t_order_d.goods_id = t_goods.goods_id\n";
        $sql .= "       INNER JOIN\n";  
        $sql .= "   t_goods_info\n";    
        $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id\n";     
        $sql .= " WHERE\n";     
        $sql .= "   t_order_h.ord_id = $get_ord_h_data[ord_id]\n";     
        $sql .= "   AND\n";     
        $sql .= "   t_order_d.rest_flg = 't'\n";    
        $sql .= "   AND\n";     
        $sql .= "   t_order_h.shop_id = $shop_id\n";    
        $sql .= "   AND\n";
        $sql .= "   t_goods_info.shop_id = $shop_id\n";
        $sql .= " ORDER BY t_order_d.line";
        $sql .= ";";
        
        $result = Db_Query($db_con, $sql);
        $get_ord_d_num = pg_num_rows($result);

        //変数初期化
        $goods_id = null;
        $stock_manage = null;
        $name_change = null;
        $order_d_id = null;

        //発注した商品分ループ
        for($i = 0; $i < $get_ord_d_num; $i++){
            //一行ずつデータを抽出
            $get_ord_d_data = pg_fetch_array($result, $i);

            //発注残
            $rorder_num = $get_ord_d_data["order_num"] - $get_ord_d_data["buy_num"]; 

            //合計金額を算出
            $price      = $get_ord_d_data["buy_price"];
    
            $buy_amount_data = bcmul($price, $rorder_num,2);
            $buy_amount[$i] = Coax_Col($coax, $buy_amount_data);
            //仕入単価を分割
            $price_data = explode(".",$price);

            //商品データ抽出した商品のデータをセット
            $set_data["hdn_goods_id"][$i]         = $get_ord_d_data["goods_id"];        //商品ID
            $set_data["hdn_name_change"][$i]      = $get_ord_d_data["name_change"];     //品名変更
            $set_data["hdn_stock_manage"][$i]     = $get_ord_d_data["stock_manage"];    //在庫管理
            $set_data["form_goods_cd"][$i]        = $get_ord_d_data["goods_cd"];        //商品コード
            $set_data["form_goods_name"][$i]      = $get_ord_d_data["goods_name"];      //商品名
            $set_data["form_stock_num"][$i]       = $get_ord_d_data["stock_num"];       //現在個数
            $set_data["hdn_stock_num"][$i]        = $get_ord_d_data["stock_num"];       //現在個数(hiddn用)
            $set_data["form_buy_price"][$i]["i"]  = $price_data[0];                     //仕入単価（整数部）
            $set_data["form_buy_price"][$i]["d"]  = $price_data[1];                     //仕入単価（小数部）
            $set_data["form_buy_amount"][$i]      = number_format($buy_amount[$i]);     //仕入金額（税抜き）
            $set_data["form_order_num"][$i]       = $get_ord_d_data["order_num"];       //発注数
            $set_data["form_rorder_num"][$i]      = $rorder_num;                        //発注済数
            $set_data["form_rbuy_num"][$i]        = $get_ord_d_data["buy_num"];         //仕入済数
            $set_data["form_buy_num"][$i]         = $rorder_num;                        //仕入数
            $set_data["form_order_in_num"][$i]    = "";                                 //仕入入数
            $set_data["hdn_tax_div"][$i]          = $get_ord_d_data["tax_div"];         //課税区分
            $set_data["form_in_num"][$i]          = $get_ord_d_data["in_num"];          //入数
            $set_data["hdn_order_d_id"][$i]       = $get_ord_d_data["ord_d_id"];        //発注データID
            //aoyama-n 2009-09-01
            $set_data["hdn_discount_flg"][$i]     = $get_ord_d_data["discount_flg"];    //値引フラグ

            //以降の処理で持ちまわるデータ
            $goods_id[$i]                         = $get_ord_d_data["goods_id"];        //商品ID
            $stock_manage[$i]                     = $get_ord_d_data["stock_manage"];    //在庫管理（在庫数表示判定）
            $name_change[$i]                      = $get_ord_d_data["name_change"];     //品名変更（品名変更付加判定）
            $order_d_id[$i]                       = $get_ord_d_data["ord_d_id"];        //発注データID
        }

        $buy_data   = $_POST["form_buy_amount"];   //仕入金額
        $price_data = NULL;                        //商品の仕入金額
        $tax_div    = NULL;                        //課税区分

        //仕入データの件数を表示する件数とする。
        $max_row = $get_ord_d_num; 

        //仕入金額の合計値計算
        for($i=0;$i<$max_row;$i++){
            $price_data[] = $buy_amount[$i];
            $tax_div[]    = $set_data["hdn_tax_div"][$i];
        }

        #2009-12-21 aoyama-n
        $tax_rate_obj->setTaxRateDay($def_data["form_buy_day"]["y"]."-".$def_data["form_buy_day"]["m"]."-".$def_data["form_buy_day"]["d"]);
        $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

        $data = Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

        //フォームに値セット
        $set_data["form_buy_money"]   = number_format($data[0]);
        $set_data["form_tax_money"]   = number_format($data[1]);
        $set_data["form_total_money"] = number_format($data[2]);

        //発注フラグをtrueにセット
        $order_flg = true;


    //空白が選択された場合
    }else{
        header("Location:./1-3-207.php");
        exit;
    }
    $set_data["hdn_show_button_flg"] = "";

/****************************/
//商品コード入力
/****************************/
//商品検索フラグがtrueの場合
}elseif($goods_search_flg === true){

    $search_row = $_POST["hdn_goods_search_flg"];           //商品検索行
    $goods_cd   = $_POST["form_goods_cd"]["$search_row"];   //商品コード
    $ware_id    = $_POST["form_ware"];                      //倉庫ID

    $sql  = "SELECT\n ";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";

    $sql .= "   t_goods.goods_cd,\n";
    //$sql .= "   t_goods.goods_name,\n";dd
    $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //正式名
    $sql .= "   t_goods.tax_div,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";

    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS stock_num,\n";
    $sql .= "   t_price.r_price,\n";
//    $sql .= "   t_goods_info.in_num\n";
    //aoyama-n 2009-09-01
    #$sql .= "   t_goods.in_num\n";
    $sql .= "   t_goods.in_num,\n";
    $sql .= "   t_goods.discount_flg\n";
    $sql .= " FROM\n";
    $sql .= "   t_goods\n";
    $sql .= "     INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price\n";
    $sql .= "   ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       goods_id,\n";
    $sql .= "       SUM(stock_num)AS stock_num\n";
    $sql .= "    FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "    WHERE\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       ware_id = $ware_id\n";
    $sql .= "   GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_goods.goods_id = t_stock.goods_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods_info\n";
    $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_cd = '$goods_cd'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods_info.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.public_flg = 't'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.compose_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.state <> '2'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.accept_flg = '1'\n";
    $sql .= "   AND\n";
    $sql .= "   t_price.rank_cd = '1'\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $goods_data_num = pg_num_rows($result);
    $goods_data = pg_fetch_array($result);

    //上記のSQLで該当するレコードがあった場合(正当な商品コードが入力された場合)
    if($goods_data_num > 0){

        //抽出した単価データをセットする形式に変更
        //抽出した単価を変数にセット
        $price = $goods_data["r_price"];

        //すでに発注数が入力されていた場合、金額を再計算する
        //発注数入力判定
        if($_POST["form_buy_num"][$search_row] != null){
            $buy_amount = bcmul($price, $_POST["form_buy_num"][$search_row],2);
            $buy_amount = Coax_Col($coax, $buy_amount);
        }

        //仕入単価を分割
        $price_data = explode(".",$price);

        //商品データ抽出した商品のデータをセット
        $set_data["hdn_goods_id"][$search_row]         = $goods_data["goods_id"];         //商品ID
        $set_data["hdn_name_change"][$search_row]      = $goods_data["name_change"];      //品名変更
        $set_data["hdn_stock_manage"][$search_row]     = $goods_data["stock_manage"];     //在庫管理
        $set_data["form_goods_name"][$search_row]      = $goods_data["goods_name"];       //商品名
        $set_data["form_stock_num"][$search_row]       = $goods_data["stock_num"];        //現在個数
        $set_data["hdn_stock_num"][$search_row]        = $goods_data["stock_num"];        //現在個数(hiddn用)
        $set_data["form_buy_price"][$search_row]["i"]  = $price_data[0];                  //仕入単価（整数部）
        $set_data["form_buy_price"][$search_row]["d"]  = $price_data[1];                  //仕入単価（小数部）
        $set_data["form_buy_amount"][$search_row]      = number_format($buy_amount);      //仕入金額（税抜き）
        $set_data["form_order_num"][$search_row]       = "-";
        $set_data["form_rorder_num"][$search_row]      = "-";
        $set_data["form_rbuy_num"][$search_row]        = "-";
        $set_data["hdn_tax_div"][$search_row]          = $goods_data["tax_div"];          //課税区分
        $set_data["form_in_num"][$search_row]          = $goods_data["in_num"];           //入数
        //aoyama-n 2009-09-01
        $set_data["hdn_discount_flg"][$search_row]     = $goods_data["discount_flg"];     //値引フラグ

        //以降の処理で持ちまわるデータ
        $goods_id[$search_row]                         = $goods_data["goods_id"];         //商品ID
        $stock_manage[$search_row]                     = $goods_data["stock_manage"];     //在庫管理（在庫数表示判定）
        $name_change[$search_row]                      = $goods_data["name_change"];      //品名変更（品名変更付加判定）
      

    //不正な値が入力された場合
    }else{
        $set_data["hdn_goods_id"][$search_row]         = "";                              //商品ID
        $set_data["hdn_name_change"][$search_row]      = "";                              //品名変更
        $set_data["hdn_stock_manage"][$search_row]     = "";                              //在庫管理
        $set_data["form_goods_name"][$search_row]      = "";                              //商品名
        $set_data["form_stock_num"][$search_row]       = "";                              //現在個数
        $set_data["hdn_stock_num"][$search_row]        = "";                              //現在個数（hidden用）
        $set_data["form_buy_price"][$search_row]["i"]  = "";                              //仕入単価（整数部）
        $set_data["form_buy_price"][$search_row]["d"]  = "";                              //仕入単価（小数部）
        $set_data["form_buy_amount"][$search_row]      = "";                              //仕入金額（税抜き）
        $set_data["form_order_num"][$search_row]       = "";                              //発注数
        $set_data["form_rorder_num"][$search_row]      = "";                              //発注済数
        $set_data["form_rbuy_num"][$search_row]        = "";                              //仕入済数
        $set_data["hdn_tax_div"][$search_row]          = "";                              //課税区分
        $set_data["form_in_num"][$search_row]          = "";                              //入数
        //aoyama-n 2009-09-01
        $set_data["hdn_discount_flg"][$search_row]     = "";                              //値引フラグ
        $goods_id[$search_row]                         = null;                            //商品ID
        $stock_num[$search_row]                        = null;                            //現在個数(リンク用)
        $stock_manage[$search_row]                     = null;                            //在庫管理（在庫数表示判定）
        $name_change[$search_row]                      = null;                            //品名変更（品名変更付加判定）
    }

    //商品入力フラグを初期化
    $set_data["hdn_goods_search_flg"]                = "";
}

/****************************/
//仕入先が選択されている場合は買掛残高を計算
/****************************/
if($client_search_flg == true){

/*
    //締日を抽出
    $sql  = "SELECT\n";
    $sql .= "   close_day\n";
    $sql .= " FROM\n";
    $sql .= "   t_client\n";
    $sql .= " WHERE\n";
    $sql .= "   t_client.client_id = $client_id\n";
    $sql .= ";";

    $result = Db_Query($db_con,$sql);
    $close_day = pg_fetch_result($result, 0, 0);

    //日付生成
    $yy = date('Y');
    $mm = date('m');
    if($close_day < 29){
        $last_close_day = date('Ymd', mktime(0,0,0,$mm, $close_day, $yy));
    }else{
        $last_close_day = date('Ymd', mktime(0,0,0,$mm+1,-1,$yy));
    }

    //前回締め日からの買上額を抽出
    $sql  = "SELECT\n";
    $sql .= "    (COALESCE(t_plus.net_amount,0) - COALESCE(t_minus.net_amount,0)) AS ap_balance\n";
    $sql .= " FROM\n";
    $sql .= "    (SELECT\n";
    $sql .= "        client_id,\n";
    $sql .= "        SUM(t_buy_h.net_amount)AS net_amount\n";
    $sql .= "    FROM\n";
    $sql .= "        t_buy_h\n";
    $sql .= "    WHERE\n";
    $sql .= "       t_buy_h.client_id = $client_id\n";
    $sql .= "       AND\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_buy_h.trade_id IN ('21', '25')\n";
    $sql .= "       AND\n";
    $sql .= "       t_buy_h.buy_day > (SELECT\n";
    $sql .= "                           COALESCE(MAX(payment_close_day), '".START_DAY."')\n";
    $sql .= "                       FROM\n";
    $sql .= "                           t_schedule_payment\n";
    $sql .= "                       WHERE\n";
    $sql .= "                           shop_id = $shop_id\n";
    $sql .= "                           AND\n";
    $sql .= "                           client_id = $client_id\n";
    $sql .= "                       )\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.buy_day <= '$last_close_day'\n";
    $sql .= "    GROUP BY client_id\n";
    $sql .= "    ) AS t_plus\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    (SELECT\n";
    $sql .= "        client_id,\n";
    $sql .= "        SUM(t_buy_h.net_amount)AS net_amount\n";
    $sql .= "    FROM\n";
    $sql .= "        t_buy_h\n";
    $sql .= "    WHERE\n";
    $sql .= "       t_buy_h.client_id = $client_id\n";
    $sql .= "       AND\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_buy_h.trade_id IN ('23', '24')\n";
    $sql .= "       AND\n";
    $sql .= "       t_buy_h.buy_day > (SELECT\n";
    $sql .= "                           COALESCE(MAX(payment_close_day), '".START_DAY."')\n";
    $sql .= "                       FROM\n";
    $sql .= "                           t_schedule_payment\n";
    $sql .= "                       WHERE\n";
    $sql .= "                           shop_id = $shop_id\n";
    $sql .= "                           AND\n";
    $sql .= "                           client_id = $client_id\n";
    $sql .= "                       )\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.buy_day <= '$last_close_day'\n";
    $sql .= "    GROUP BY client_id\n";
    $sql .= "    ) AS t_minus\n";
    $sql .= "    ON t_plus.client_id = t_minus.client_id\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $ap_balance = number_format(@pg_fetch_result($result,0,0));
*/

    /****************************/
    // 買掛データ取得（残高のみ）
    /****************************/
    // 伝票明細データ取得（データが無い場合は空配列作成）
    $sql = Ap_Particular_Sql(START_DAY, date("Y-m-d"), $client_id);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    $ary_ap_particular_data = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // 買掛残高算出
    foreach ($ary_ap_particular_data as $key => $value){
        $ap_balance += ($value["buy_amount"] - $value["payout_amount"]);
    }

    $ap_balance = number_format($ap_balance);

}

//最大行数をhiddenにセット
$set_data["max_row"] = $max_row;

//上記処理により生成した値をフォームにセット
$form->setConstants($set_data);

//仕入先OR倉庫が選択されていない場合
if($client_search_flg == true && $ware_search_flg == true){
    //画面に表示する警告メッセージ
    $warning = "商品を選択して下さい。"; 
    //入力を制限するフラグ
    $select_flg = true;
}else{
    //画面に表示する警告メッセージ
    $warning = "仕入先と倉庫を選択して下さい。";
    //入力を制限するフラグ
    $select_flg = false;  
}    

/****************************/
//フォーム作成
/****************************/
//伝票番号
$form->addElement(
    "text","form_buy_no","",
    "style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//発注残
//if($update_data_flg == true || $_POST[hdn_buy_id] != null){
if($update_data_flg == true || $update_flg == true){
    $form->addElement(
        "text","form_order_no","",
        "style=\"color : #525552; 
        border : #ffffff 1px solid; 
        background-color: #ffffff; 
        text-align: left\" readonly'"
    );

}else{
    $select_value[null] = null;
    $sql  = "SELECT";
    $sql .= "    t_order_h.ord_id,";
    $sql .= "    t_order_h.ord_no";
    $sql .= " FROM";
    $sql .= "    t_order_h";
    $sql .= "        INNER JOIN";
    $sql .= "    (SELECT";
    $sql .= "        ord_id";
    $sql .= "    FROM";
    $sql .= "        t_order_d";
    $sql .= "    WHERE";
    $sql .= "        rest_flg = 't'";
    $sql .= "    GROUP BY ord_id) AS t_order_d";
    $sql .= "    ON t_order_h.ord_id = t_order_d.ord_id";
    $sql .= " WHERE";
    $sql .= "    t_order_h.shop_id = $shop_id";
    $sql .= "    AND";
    $sql .= "    t_order_h.ord_stat IS NULL";
    $sql .= "    AND";
    $sql .= "    t_order_h.ps_stat IN ('1','2')";
    $sql .= " ORDER BY t_order_h.ord_no";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $num = pg_num_rows($result);
    for($i = 0; $i < $num; $i++){
        $ord_id = pg_fetch_result($result,$i,0);
        $ord_no = pg_fetch_result($result,$i,1);
        $select_value[$ord_id] = $ord_no;
    }
    $form->addElement("select","form_order_no","",$select_value, $g_form_option_select);
}

//発注日
$form_order_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_order_day[] = $form->createElement("static","","","-");
$form_order_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_order_day[] = $form->createElement("static","","","-");
$form_order_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form->addGroup( $form_order_day,"form_order_day","");

//入荷予定日
$form_arrival_hope_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_arrival_hope_day[] = $form->createElement("static","","","-");
$form_arrival_hope_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_arrival_hope_day[] = $form->createElement("static","","","-");
$form_arrival_hope_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form->addGroup( $form_arrival_hope_day,"form_arrival_hope_day","");

//入荷日
$form_arrival_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_arrival_day[y]','form_arrival_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arrival_day[d]')\"
    onBlur=\"blurForm(this)\"
    onChange=\"Claim_Day_Change('form_arrival_day', 'form_buy_day')\"
    "
);
$form_arrival_day[] = $form->createElement("static","","","-");
$form_arrival_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_arrival_day[m]','form_arrival_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arrival_day[d]')\"
    onBlur=\"blurForm(this)\"
    onChange=\"Claim_Day_Change('form_arrival_day', 'form_buy_day')\"
    "
);
$form_arrival_day[] = $form->createElement("static","","","-");
$form_arrival_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arrival_day[d]')\"
    onBlur=\"blurForm(this)\"
    onChange=\"Claim_Day_Change('form_arrival_day', 'form_buy_day')\"
    "
);
$form->addGroup( $form_arrival_day,"form_arrival_day","");

//仕入日
$form_buy_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_buy_day[y]','form_buy_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_buy_day[y]','form_buy_day[m]','form_buy_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_buy_day[] = $form->createElement("static","","","-");
$form_buy_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_buy_day[m]','form_buy_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_buy_day[y]','form_buy_day[m]','form_buy_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_buy_day[] = $form->createElement("static","","","-");
$form_buy_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onFocus=\"onForm_today(this,this.form,'form_buy_day[y]','form_buy_day[m]','form_buy_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_buy_day,"form_buy_day","");

//仕入先
//仕入先
$freeze_form = $form_client[] = $form->createElement(
    "text","cd1","",
    "size=\"7\" maxLength=\"6\"
    style=\"$g_form_style\"
    onChange=\"javascript:Change_Submit('hdn_client_search_flg','#','true','form_client[cd2]')\"
    onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"
    $g_form_option"
);
//仕入変更　OR　発注からの仕入時には仕入先は変更不可
if($update_data_flg == true || $_POST[hdn_buy_id] != null || $order_flg == true){
    $freeze_form->freeze();
}
$form_client[] = $form->createElement("static","","","-");
$freeze_form = $form_client[] = $form->createElement(
    "text","cd2","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style\"
    onChange=\"javascript:Button_Submit('hdn_client_search_flg','#','true', this)\"
    $g_form_option"
);

//仕入変更　OR　発注からの仕入時には仕入先は変更不可
if($update_data_flg == true || $_POST[hdn_buy_id] != null || $order_flg == true){
    $freeze_form->freeze();
}
$form_client[] = $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly"
);
$form->addGroup($form_client, "form_client", "");

//直送先
$select_value = Select_Get($db_con,'direct');
$update_form[0] = $form->addElement('select', 'form_direct', "", $select_value,"class=\"Tohaba\"".$g_form_option_select);

//仕入倉庫
$where  = " WHERE";
$where .= "  shop_id = $_SESSION[client_id]";
$where .= "  AND";
$where .= "  nondisp_flg = 'f'";
$select_value = Select_Get($db_con,'ware', $where);
$update_form[1] = $form->addElement(
        'select', 'form_ware', '', $select_value,"
        onChange=\"javascript:Button_Submit('hdn_ware_select_flg','#','t', this)\""
);

//取引区分
$select_value = null;
//発注IDがある場合
if($order_flg == true){
    $select_value = select_Get($db_con, 'trade_buy_ord');
}else{
    $select_value = Select_Get($db_con, 'trade_buy');
}
$select_value = Select_Get($db_con, 'trade_buy');
$update_form[2] = $form->addElement('select', 'form_trade', null, null,$g_form_option_select);
//返品、値引きの色を変更
$select_value_key = array_keys($select_value);
for($i = 0; $i < count($select_value); $i++){
    if($select_value_key[$i] == 23 || $select_value_key[$i] == 24 || $select_value_key[$i] == 73 || $select_value_key[$i] == 74){
         $color= "style=color:red";
    }else{
          $color="";
    }
    #2009-09-28 hashimoto-y
    #取引区分から値引きを表示しない。切り戻しの場合にはここのif文を外す。
    if($select_value_key[$i] != 24 && $select_value_key[$i] != 74){
        $update_form[2]->addOption($select_value[$select_value_key[$i]], $select_value_key[$i],$color);
    }
}

//発注IDがある場合
if($order_flg == true){
    //発注担当者
    $select_value = Select_Get($db_con,'staff');
    $order_form[] = $form->addElement('select', 'form_order_staff', '', $select_value,$g_form_option_select);
    $count = count($order_form);
    for($i = 0; $i < $count; $i++){
        $order_form[$i]->freeze();
    }
}

$select_value = Select_Get($db_con,'staff','true');
//仕入担当者
$update_form[3] = $form->addElement('select', 'form_buy_staff', '', $select_value,$g_form_option_select);

//仕入入力変更の際は指定したフォームをフリーズする
//if($update_flg == true && $order_flg == true){
if($update_flg == true && $order_flg == true){
    for($i = 0; $i < count($update_form); $i++){
        $update_form[$i]->freeze();
    }
}

//備考
//$form->addElement("text","form_note","","size=\"50\" maxLength=\"20\" $g_form_option");
$form->addElement("textarea","form_note",""," rows=\"2\" cols=\"75\" $g_form_option_area");

//仕入金額(合計)
$form->addElement(
        "text","form_buy_money","",
        "size=\"25\" maxLength=\"18\"
         style=\"color : #000000;
         border : #FFFFFF 1px solid; 
         background-color: #FFFFFF; 
         text-align: right\"
         readonly"
);

//消費税額(合計)
$form->addElement(
        "text","form_tax_money","",
        "size=\"25\" maxLength=\"18\"
         style=\"color : #000000;
         border : #FFFFFF 1px solid; 
         background-color: #FFFFFF; 
         text-align: right\"
         readonly"
);

//仕入金額（税込合計)
$form->addElement(
        "text","form_total_money","",
        "size=\"25\" maxLength=\"18\"
         style=\"color : #000000;
         border : #FFFFFF 1px solid; 
         background-color: #FFFFFF; 
         text-align: right\"
         readonly"
);

//追加リンク
$form->addElement("link","add_row_link","","#","追加","
    onClick=\"javascript:Button_Submit_1('add_row_flg', '#', 'true', this);\""
);

//入力・変更
$form->addElement("button","new_button","入　力",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//照会
$form->addElement("button","change_button","照会・変更","onClick=\"javascript:Referer('1-3-202.php')\"");

/*
if($update_flg === false || $update_data_flg === false){
    //仕入先対象
    $form->addElement("button","form_client_button","仕入先","onClick=\"javascript:location.href='./1-3-201.php'\"");
    //FC 対象
    $form->addElement("button","form_fc_button","Ｆ　Ｃ",$g_button_color."onClick=\"javascript:location.href='./1-3-207.php';\"");
}
*/

//hidden
//各入力フラグ
$form->addElement("hidden", "hdn_client_search_flg");       //仕入先コード入力フラグ
$form->addElement("hidden", "hdn_goods_search_flg");        //商品コード入力フラグ
$form->addElement("hidden", "hdn_ware_select_flg");         //倉庫選択フラグ
$form->addElement("hidden", "hdn_sum_button_flg");          //合計ボタン押下フラグ
$form->addElement("hidden", "add_row_flg");                 //行追加ボタン押下フラグ
$form->addElement("hidden", "hdn_show_button_flg");         //表示ボタン押下フラグ
//持ちまわる仕入先の情報
$form->addElement("hidden", "hdn_coax");                    //丸め区分
$form->addElement("hidden", "hdn_tax_franct");              //端数区分
$form->addElement("hidden", "hdn_client_id");               //得意先ID
$form->addElement("hidden", "hdn_order_id");                //変更時（発注ID）
$form->addElement("hidden", "hdn_buy_id");
$form->addElement("hidden", "hdn_buy_enter_day");           //仕入登録日
$form->addElement("hidden", "hdn_ord_enter_day");           //発注登録日
$form->addElement("hidden", "hdn_ord_change_day");          //発注変更日

//表示行数に関係する情報
$form->addElement("hidden", "del_row");                     //削除行
$form->addElement("hidden", "max_row");                     //最大行数

//更新フラグ
$form->addElement("hidden", "renew_flg", "1");

//aoyama-n 2009-09-15
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;
        $form->addElement("hidden","hdn_discount_flg[$i]");
    }
}

/****************************/
//ボタン押下処理判定
/****************************/
$buy_button_flg = ($_POST["form_buy_button"] == "仕入確認画面へ")? true : false;

$buy_comp_flg   = ($_POST["form_comp_button"] == "仕入完了")?　true : false;

/****************************/
//仕入確認ボタン押下処理
/****************************/
if($buy_button_flg == true || $buy_comp_flg == true){

    /******************************/
    //ルール作成（QuickForm）
    /******************************/
    //入荷日
    //●必須チェック
    $form->addGroupRule('form_arrival_day', array(
            'y' => array(
                    array('入荷日の日付は妥当ではありません。', 'required')
            ),
            'm' => array(
                    array('入荷日の日付は妥当ではありません。','required')
            ),
            'd' => array(
                    array('入荷日の日付は妥当ではありません。','required')
            )               
    ));
    $form->addGroupRule('form_arrival_day', array(
            'y' => array(
                    array('入荷日の日付は妥当ではありません。', 'numeric')
            ),              
            'm' => array(
                    array('入荷日の日付は妥当ではありません。','numeric')
            ),              
            'd' => array(
                    array('入荷日の日付は妥当ではありません。','numeric')
            )               
    ));
    
    //仕入日
    //●必須チェック
    $form->addGroupRule('form_buy_day', array(
            'y' => array(
                    array('仕入日の日付は妥当ではありません。','required')
            ),              
            'm' => array(
                    array('仕入日の日付は妥当ではありません。','required')
            ),              
            'd' => array(
                    array('仕入日の日付は妥当ではありません。','required')
            )               
    ));
    $form->addGroupRule('form_buy_day', array(
            'y' => array(
                    array('仕入日の日付は妥当ではありません。','numeric')
            ),              
            'm' => array(
                    array('仕入日の日付は妥当ではありません。','numeric')
            ),
            'd' => array(
                    array('仕入日の日付は妥当ではありません。','numeric')
            )
    ));

    //仕入先CD
    //●必須チェック
    $form->addGroupRule('form_client', array(
            'cd1' => array(
                    array('正しい仕入先コードを入力してください。','required')
            ),
            'cd2' => array(
                    array('正しい仕入先コードを入力してください。','required')
            ),
            'name' => array(
                    array('正しい仕入先コードを入力してください。','required')
            )
    ));

    //仕入倉庫
    //●必須チェック
    $form->addRule('form_ware','仕入倉庫を選択してください。','required');

    //取引区分
    //●必須チェック
    $form->addRule('form_trade','取引区分を選択してください。','required');

    //仕入担当者
    //●必須チェック
    $form->addRule('form_buy_staff','仕入担当者を選択してください。','required');

    // ■備考
    // 文字数チェック
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note", "備考は100文字以内です。","mb_maxlength", "100");

    /******************************/
    //POST取得
    /******************************/
    $client_id                  = $_POST["hdn_client_id"];                  //仕入ID
    $client_cd1                 = $_POST["form_client"]["cd1"];             //仕入先CD
    $client_cd2                 = $_POST["form_client"]["cd2"];             //仕入先CD
    $buy_no                     = $_POST["form_buy_no"];                    //仕入番号
    $order_no                   = $_POST["form_order_no"];                  //発注番号
    $order_date                 = $_POST["form_order_day"]["y"];            //発注日（年）
    $order_date                 = $_POST["form_order_day"]["m"];            //発注日（月）
    $order_date                 = $_POST["form_order_day"]["d"];            //発注日（日）
    $arrival_day["y"]           = $_POST["form_arrival_day"]["y"];          //入荷日（年）
    $arrival_day["m"]           = $_POST["form_arrival_day"]["m"];          //入荷日（月）
    $arrival_day["d"]           = $_POST["form_arrival_day"]["d"];          //入荷日（日）
    $buy_day["y"]               = $_POST["form_buy_day"]["y"];              //仕入日（年）
    $buy_day["m"]               = $_POST["form_buy_day"]["m"];              //仕入日（月）
    $buy_day["d"]               = $_POST["form_buy_day"]["d"];              //仕入日（日）
    $direct                     = ($_POST["form_direct"] != NULL)? $_POST["form_direct"] : NULL;  //直送先
    $ware                       = $_POST["form_ware"];                      //仕入倉庫
    $trade                      = $_POST["form_trade"];                     //取引区分
    $buy_staff                  = $_POST["form_buy_staff"];                 //仕入担当者
    $order_staff                = ($_POST["form_order_staff"] != null)? $_POST["form_order_staff"] : null; //仕入担当者
    $note                       = $_POST["form_note"];                      //備考

    //発注ステータスチェック
    if($order_id != null && $buy_get_flg == false){
        $sql  = "SELECT \n";
        $sql .= "   t_order_h.ps_stat \n";
        $sql .= "FROM \n";
        $sql .= "   t_order_h \n";
        $sql .= "WHERE \n";
        $sql .= "   t_order_h.ord_id = $order_id\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        if(pg_num_rows($result) > 0){
            $ps_stat = pg_fetch_result($result, 0,0);
        }

        //発注の処理状況が完了の場合
        if($ps_stat == '3'){
            header("Location:./1-3-205.php?buy_id=0&input_flg=true&ps_stat=true");
        }
    }

    //仕入先チェック
    $sql  = "SELECT";
    $sql .= "   COUNT(client_id) ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= "   AND";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$client_cd2'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $client_num = pg_fetch_result($result, 0, 0);

    //仕入先コードが不正な場合
    if($client_num != 1){
        $form->setElementError("form_client", "仕入先情報取得前に 発注確認画面へボタン <br>が押されました。操作をやり直してください。");

    //仕入先コードが正当な場合
    }elseif($client_cd1 != null && $client_cd2 != null){
 
        //aoyama-n 2009-09-01
        //値引商品選択時の取引区分チェック（値引・返品は使用不可）
        if(($trade == '23' || $trade == '24' || $trade == '73' || $trade == '74') && (in_array('t', $_POST[hdn_discount_flg]))){
            $form->setElementError("form_trade", "値引商品を選択した場合、使用できる取引区分は「掛仕入、割賦仕入、現金仕入」のみです。");
            #2009-09-15 hashimoto-y
            $trade_err = true;
        }

        //データチェックに渡す引数生成
        $check_ary = array($db_con, $order_id, $_POST["hdn_ord_enter_day"], $get_buy_id);

        //データチェック
        $check_data = Row_Data_Check(
                                $_POST[hdn_goods_id],       //商品ID
                                $_POST[form_goods_cd],      //商品コード
                                $_POST[form_goods_name],    //商品名
                                $_POST[form_buy_num],       //仕入数
                                $_POST[form_buy_price],     //仕入単価
                                $_POST[form_buy_amount],    //仕入金額
                                $_POST[hdn_tax_div],        //課税区分
                                $del_history,               //削除履歴
                                $max_row,                   //最大行数
                                "buy",                      //区分
                                $db_con,
                                $_POST[form_order_num],     //発注数
                                $_POST[hdn_royalty],        //ロイヤリティ
                                $_POST[hdn_order_d_id],     //発注データID
                                //aoyama-n 2009-09-01
                                #$check_ary
                                $check_ary,
                                $_POST[hdn_discount_flg]    //値引フラグ
                                );
        //変数初期化
        $goods_id   = null;
        $goods_cd   = null;
        $goods_name = null;
        $buy_num    = null;
        $buy_price  = null;
        $buy_amount = null;
        $tax_div    = null;
        $order_num  = null;
        $royalty    = null;
        $order_d_id = null;

        //エラーがあった場合
        if($check_data[0] === true){
            //商品が一つも選択されていない場合
            $form->setElementError("form_buy_no",$check_data[1]);
    
            //正しい商品コードが入力されていない場合
            $goods_err = $check_data[2];

            //発注数と仕入単価に入力があるか
            $price_num_err = $check_data[3];

            //発注数半角数字チェック
            $num_err = $check_data[4];

            //単価半角チェック
            $price_err = $check_data[5];

            //発注数を仕入数が超えた場合
            $ord_num_err = $check_data[6];

            if($check_data[1] != null || $goods_err != null || $price_num_err != null || $num_err != null || $price_err != null){
                $err_flg = true;
            }

            $order_d_id = $_POST["hdn_order_d_id"];

        #2009-09-15 hashimoto-y
        }elseif($trade_err === true){
        //取引区分がエラーの場合  何もしない

        }else{
        //エラーがなかった場合

            //登録対象データを変数にセット
            $goods_id   = $check_data[1][goods_id];
            $goods_cd   = $check_data[1][goods_cd];
            $goods_name = $check_data[1][goods_name];
            $buy_num    = $check_data[1][num];
            $buy_price  = $check_data[1][price];
            $buy_amount = $check_data[1][amount];
            $tax_div    = $check_data[1][tax_div];
            $order_d_id = $check_data[1][data_id];
            $order_num  = $check_data[1][num2];
            $royalty    = $check_data[1][royalty];
            $def_line   = $check_data[1][def_line];


            //発注数を仕入数が超えた場合
            $ord_num_err = $check_data[2];
        }
    }

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($buy_day["y"]."-".$buy_day["m"]."-".$buy_day["d"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

    //フォームに値セット
    $set_data["form_buy_money"]     = number_format($data[0]);
    $set_data["form_tax_money"]     = number_format($data[1]);
    $set_data["form_total_money"]   = number_format($data[2]);
    $form->setConstants($set_data);

    /******************************/
    //ルール作成
    /******************************/
    //入荷日
    //●日付妥当性チェック
    if(!checkdate((int)$arrival_day["m"], (int)$arrival_day["d"], (int)$arrival_day["y"])){
        $form->setElementError("form_arrival_day", "入荷日の日付は妥当ではありません。");
    }else{
        //月次更新
        if(Check_Monthly_Renew($db_con, $client_id, '2', $arrival_day["y"], $arrival_day["m"], $arrival_day["d"]) === false){
            $form->setElementError("form_arrival_day", "入荷日に月次更新日以前の日付は登録できません。");
        }

        //システム開始日チェック
        $arrival_day_err   = Sys_Start_Date_Chk($arrival_day["y"], $arrival_day["m"], $arrival_day["d"], "入荷日");
        if($arrival_day_err != Null){
            $form->setElementError("form_arrival_day", $arrival_day_err);
        }       
    }

    //仕入日
    //●日付妥当性チェック
    if(!checkdate((int)$buy_day["m"], (int)$buy_day["d"], (int)$buy_day["y"])){
        $form->setElementError("form_buy_day", "仕入日の日付は妥当ではありません。");
    }else{
        //月次更新
        if(Check_Monthly_Renew($db_con, $client_id, '2', $buy_day["y"], $buy_day["m"], $buy_day["d"]) === false){
            $form->setElementError("form_buy_day", "仕入日に月次更新日以前の日付は登録できません。");
        }

        //仕入締日チェック
        if(Check_Payment_Close_Day($db_con, $client_id, $buy_day["y"], $buy_day["m"], $buy_day["d"]) === false){
            $form->setElementError("form_buy_day", "仕入日に仕入締日以前の日付は登録できません。");
        }

        //システム開始日チェック
        $buy_day_err   = Sys_Start_Date_Chk($buy_day["y"], $buy_day["m"], $buy_day["d"], "仕入日");
        if($buy_day_err != Null){
            $form->setElementError("form_buy_day", $buy_day_err);
        }       
    }

    //更新処理実施日チェック
    $buy_day["m"] = str_pad($buy_day["m"], 2, 0, STR_PAD_LEFT);
    $buy_day["d"] = str_pad($buy_day["d"], 2, 0, STR_PAD_LEFT);

    $buy_date = $buy_day["y"]."-".$buy_day["m"]."-".$buy_day["d"];

/*
    for($i = 0; $i < count($goods_id); $i++){
        //商品チェック
        //商品重複チェック
        for($j = 0; $j < count($goods_id); $j++){
            if($goods_id[$i] != null && $goods_id[$j] != null && $i != $j && $goods_id[$i] == $goods_id[$j]){
                //$form->setElementError("form_buy_no", "同じ商品が２度選択されています。");
                $goods_twice =  "同じ商品が複数選択されています。";
            }
        }
    }
*/
    //商品チェック
    //商品重複チェック
    $goods_count = count($goods_id);
    for($i = 0; $i < $goods_count; $i++){

        //既にチェック済みの商品の場合はｽｷｯﾌﾟ
        if(@in_array($goods_id[$i], $checked_goods_id)){
            continue;
        }

        //チェック対象となる商品
        $err_goods_cd = $goods_cd[$i];
        $mst_line = $def_line[$i];

        for($j = $i+1; $j < $goods_count; $j++){
            //商品が同じ場合
            if($goods_id[$i] == $goods_id[$j]) {
                $duplicate_line .= ", ".($def_line[$j]);
            }
        }
        $checked_goods_id[] = $goods_id[$i];    //チェック済み商品

        if($duplicate_line != null){
            $duplicate_goods_err[] =  "商品コード：".$err_goods_cd."の商品が複数選択されています。(".$mst_line.$duplicate_line."行目)";
        }

        $err_goods_cd   = null;
        $mst_line       = null;
        $duplicate_line = null;
    }

    /*****************************/
    //値検証
    /*****************************/
    if($form->validate()){

        /*******************************/
        //登録処理
        /*******************************/
        //仕入完了ボタンフラグがtrueの場合
        if($buy_comp_flg == true){

            $total_amount_data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

            //日付を結合
            $arrival_date   = $arrival_day["y"]."-".$arrival_day["m"]."-".$arrival_day["d"];  //入荷日

            Db_Query($db_con, "BEGIN");

            //仕入変更入力の場合
            if($update_flg == true){

                //仕入が削除されていないか確認
                $update_check_flg = Update_Check($db_con, "t_buy_h", "buy_id", $get_buy_id, $_POST["hdn_buy_enter_day"]);
                //既に削除されていた場合
                if($update_check_flg === false){
                    header("Location:./1-3-205.php?buy_id=$get_buy_id&input_flg=true&del_buy_flg=true");
                    exit;
                }
                if($order_id != null){
                    //発注が変更されていないか確認
                    $update_data_check_flg = Update_Data_Check($db_con, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_change_day"]);
                    if($update_data_check_flg === false){
                        header("Location:./1-3-205.php?buy_id=0&input_flg=true&change_ord_flg=true");
                        exit;
                    }
                }
                //支払ヘッダをとりあえず削除
                $sql  = "DELETE FROM t_payout_h WHERE buy_id = $get_buy_id";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //「仕入ヘッダテーブル」の下記の情報を更新
                $sql  = "UPDATE\n";
                $sql .= "    t_buy_h\n";
                $sql .= " SET\n";
                $sql .= "    buy_no = '$buy_no',\n";
                $sql .= "    buy_day = '$buy_date',\n";
                $sql .= "    arrival_day = '$arrival_date',\n";
                $sql .= "    client_id = $client_id,\n";
                $sql .= ($direct != null) ? " direct_id = $direct,\n" : " direct_id = NULL, ";
                $sql .= "    trade_id = '$trade',\n";
                $sql .= "    note = '$note',\n";
                $sql .= "    c_staff_id = $buy_staff,\n";
                $sql .= ($order_staff != null) ? " oc_staff_id = $order_staff,\n" : " oc_staff_id = NULL, ";
                $sql .= "    ware_id = $ware,\n";
                $sql .= "    e_staff_id = $staff_id,\n";
                $sql .= "    net_amount = $total_amount_data[0],\n";
                $sql .= "    tax_amount = $total_amount_data[1],\n";
                $sql .= ($trade == 25) ? "    total_split_num = 2," : "    total_split_num = 1,";
                $sql .= "    client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= ($direct != null) ? " direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct), " : " direct_name = NULL, ";
                $sql .= ($direct != null) ? " direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), " : " direct_name2 = NULL, ";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";
                $sql .= "    c_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $buy_staff), ";
                $sql .= "    e_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), ";
                $sql .= ($order_staff != null) ? " oc_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $order_staff), " : " oc_staff_name = NULL, ";
                $sql .= "    client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id),";
                $sql .= "    change_day = CURRENT_TIMESTAMP";
                $sql .= " WHERE\n";
                $sql .= "    buy_id = $get_buy_id\n";
                $sql .= ";\n";

                $result = Db_Query($db_con, $sql);

                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                //「仕入データテーブル」からGETで取得した仕入IDとマッチするデータを削除
                $sql  = "DELETE FROM";
                $sql .= "    t_buy_d";
                $sql .= " WHERE";
                $sql .= "    buy_id = $get_buy_id";
                $sql .= ";";
               
                $result = Db_Query($db_con, $sql);
                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                //分割テーブルに登録されているデータを削除
                $sql  = "DELETE FROM\n";
                $sql .= "   t_amortization\n";
                $sql .= " WHERE\n";
                $sql .= "   buy_id = $get_buy_id\n";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($db_con, $sql);
                    exit;
                }

                //発注から起こしている場合には一度強制完了していない発注に対して発注残フラグをtrueにする
                if($order_flg == true){
                    $sql  = "UPDATE";
                    $sql .= "   t_order_d \n";
                    $sql .= "SET\n";
                    $sql .= "   rest_flg = 't' \n";
                    $sql .= "WHERE\n";
                    $sql .= "   ord_id = $order_id\n";
                    $sql .= "   AND\n";
                    $sql .= "   finish_flg = 'f'\n";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
                }

            //新規仕入入力の場合
            }else{
                if($order_flg == true){
                    //発注が削除されていないかを確認
                    $update_check_flg = Update_Check($db_con, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_enter_day"]);

                    //既に削除されていた場合
                    if($update_check_flg === false){
                        header("Location:./1-3-205.php?buy_id=0&input_flg=true&del_ord_flg=true");
                        exit;
                    }

                    //発注が変更されていないか確認
                    $update_data_check_flg = Update_Data_Check($db_con, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_change_day"]);
                    if($update_data_check_flg === false){
                        header("Location:./1-3-205.php?buy_id=0&input_flg=true&change_ord_flg=true");
                        exit;
                    }
                }
                $sql  = "INSERT INTO t_buy_h (\n";
                $sql .= "    buy_id,\n";                                                            //仕入先ID
                $sql .= "    buy_no,\n";                                                            //仕入番号
                if($order_flg == true){
                    $sql .= "    ord_id,\n";                                                        //発注ID
                }
                $sql .= "    buy_day,\n";                                                           //仕入日
                $sql .= "    arrival_day,\n";                                                       //入荷日
                $sql .= "    client_id,\n";                                                         //得意先ID
                if($direct != null){
                    $sql .= "    direct_id,\n";                                                     //直送先ID
                }
                $sql .= "    trade_id,\n";                                                          //取引先CD
                $sql .= "    note,\n";                                                              //備考
                $sql .= "    c_staff_id,\n";                                                        //仕入担当者ID
                $sql .= "    ware_id,\n";                                                           //倉庫ID
                $sql .= "    e_staff_id,\n";                                                        //入力者ID
                $sql .= "    shop_id,\n";                                                           //ショップID
                $sql .= "    net_amount,\n";                                                        //仕入金額（税抜き）
                $sql .= "    tax_amount,\n";                                                        //消費税額
                $sql .= ($order_staff != null) ? " oc_staff_id,\n" : null;                          //発注担当者ID
                $sql .= "    total_split_num, \n";                                                  //分割回数
                $sql .= "    client_cd1, ";                                                         //得意先コード１
                $sql .= "    client_cd2, ";                                                         //得意先コード２
                $sql .= "    client_name, ";                                                        //得意先名１
                $sql .= "    client_name2, ";                                                       //得意先名２
                $sql .= ($direct != null) ? " direct_name, " : null;                                //直送先名１
                $sql .= ($direct != null) ? " direct_name2, " : null;                               //直送先名２
                $sql .= "    ware_name, ";                                                          //倉庫名
                $sql .= "    c_staff_name, ";                                                       //仕入担当者名
                $sql .= ($order_staff != null) ? " oc_staff_name, " : null;                         //発注担当者名
                $sql .= "    e_staff_name, ";                                                       //入力者名
                $sql .= "    client_cname, ";                                                       //略称
                $sql .= "    buy_div ";                                                             //仕入区分
                $sql .= ")VALUES(\n";
                $sql .= "    (SELECT COALESCE(MAX(buy_id), 0)+1 FROM t_buy_h),\n";                  //仕入先ID
                $sql .= "    '$buy_no',\n";                                                         //仕入番号
                if($order_flg == true){
                    $sql .= "    $order_id,\n";                                                     //発注ID
                }
                $sql .= "    '$buy_date',\n";                                                       //仕入日
                $sql .= "    '$arrival_date',\n";                                                   //入荷予定日
                $sql .= "    $client_id,\n";                                                        //得意先ID
                if($direct != null){
                    $sql .= "    $direct,\n";                                                       //直送先ID
                }
                $sql .= "    '$trade',\n";                                                          //取引先ID
                $sql .= "    '$note',\n";                                                           //備考
                $sql .= "    $buy_staff,\n";                                                        //仕入担当者ID
                $sql .= "    $ware,\n";                                                             //倉庫ID
                $sql .= "    $staff_id,\n";                                                         //入力者ID
                $sql .= "    $shop_id,\n";                                                          //ショップID
                $sql .= "    $total_amount_data[0],\n";                                             //仕入金額（税抜き）
                $sql .= "    $total_amount_data[1],\n";                                             //消費税額
                $sql .= ($order_staff != null) ? " $order_staff,\n" : null;                         //発注担当者
                $sql .= ($trade == 25) ? "   2, \n" : "   1, \n";                                   //分割支払回数
                $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";     //得意先コード１
                $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";     //得意先コード２
                $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";    //得意先名
                $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";   //得意先名２
                $sql .= ($direct != null) ? " (SELECT direct_name FROM t_direct WHERE direct_id = $direct), " : null;   //直送先名１
                $sql .= ($direct != null) ? " (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), " : null;  //直送先名２
                $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";               //倉庫名
                $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $buy_staff), ";       //仕入担当者名
                $sql .= ($order_staff != null) ? " (SELECT staff_name FROM t_staff WHERE staff_id = $order_staff), " : null;//発注担当者名
                $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), ";        //入力者名
                $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id),\n";  //得意先名略称
                $sql .= "   '2'\n";                                                                 //仕入区分
                $sql .= ");\n";

                $result = Db_Query($db_con, $sql);

                //失敗した場合はロールバック
                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_buy_h_buy_no_key";
                    Db_Query($db_con, "ROLLBACK");

                    //発注NOが重複した場合
                    if(strstr($err_message,$err_format) !== false){
                        $error = "同時に仕入を行ったため、伝票番号が重複しました。もう一度仕入を行ってください。";

                        //再度発注NOを取得する
                        $sql  = "SELECT ";
                        $sql .= "   MAX(buy_no)";
                        $sql .= " FROM";
                        $sql .= "   t_buy_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $shop_id";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $buy_no = pg_fetch_result($result, 0 ,0);

                        $buy_no = $buy_no +1;
                        $buy_no = str_pad($buy_no, 8, 0, STR_PAD_LEFT);
                        $err_data["form_buy_no"] = $buy_no;
                        $form->setConstants($err_data);
                        $duplicate_err = true;
                    }else{
                        exit;
                    }
                }
            }
            if($duplicate_err != true){

                //仕入IDを抽出
                $sql  = "SELECT";
                $sql .= "   buy_id";
                $sql .= " FROM";
                $sql .= "   t_buy_h";
                $sql .= " WHERE";
                $sql .= "   buy_no = '$buy_no'";
                $sql .= "   AND";
                $sql .= "   shop_id = $shop_id";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                $buy_id = pg_fetch_result($result,0,0);

                //割賦支払テーブルに登録
                if($trade == "25"){
                    $division_array = Division_Price($db_con, $client_id, ($total_amount_data[0] + $total_amount_data[1]), $buy_day["y"], $buy_day["m"], 2);
                    for($k=0;$k<2;$k++){
                        $sql  = "INSERT INTO t_amortization (\n";
                        $sql .= "   amortization_id,\n";
                        $sql .= "   buy_id,\n";
                        $sql .= "   pay_day,\n";
                        $sql .= "   split_pay_amount\n";
                        $sql .= " )VALUES(\n";
                        $sql .= "   (SELECT COALESCE(MAX(amortization_id),0)+1 FROM t_amortization),\n";
                        $sql .= "   $buy_id,\n";
                        $sql .= "   '".$division_array[1][$k]."', \n";
                        $sql .= "   ".$division_array[0][$k]." \n";
                        $sql .= ");";

                        $reuslt = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                    }
                }

                for($i = 0; $i < count($goods_id); $i++){
                    //行
                    $line = $i + 1;

                    //仕入金額税抜き、消費税額、消費税合計を算出
                    $price = $buy_price[$i]["i"].".".$buy_price[$i]["d"];   //仕入金額
                    $buy_amount = bcmul($price, $buy_num[$i],3);
                    $buy_amount = Coax_Col($coax, $buy_amount);

                    $sql  = "INSERT INTO t_buy_d (\n";
                    $sql .= "    buy_d_id,\n";
                    $sql .= "    buy_id,\n";
                    $sql .= "    line,\n";
                    $sql .= "    goods_id,\n";
                    $sql .= "    goods_name,\n";
                    $sql .= "    num,\n";
                    $sql .= "    tax_div,\n";
                    $sql .= "    buy_price,\n";
                    $sql .= "    buy_amount,\n";
                    $sql .= ($order_d_id[$i] != null) ? " ord_d_id,\n " : null;
                    $sql .= "    goods_cd, \n";
                    $sql .= "    in_num \n";
                    $sql .= ")VALUES(\n";
                    $sql .= "    (SELECT COALESCE(MAX(buy_d_id), 0)+1 FROM t_buy_d),\n";
                    $sql .= "    $buy_id,\n";
                    $sql .= "    $line,\n";
                    $sql .= "    $goods_id[$i],\n";
                    $sql .= "    '$goods_name[$i]',\n";
                    $sql .= "    $buy_num[$i],\n";
                    $sql .= "    $tax_div[$i],\n";
                    $sql .= "    $price,\n";
                    $sql .= "    $buy_amount,\n";
                    $sql .= ($order_d_id[$i] != null) ? "    $order_d_id[$i],\n " : null;
                    $sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_id[$i]),\n ";
                    $sql .= "    (SELECT in_num FROM t_goods WHERE goods_id = $goods_id[$i]) \n";
                    $sql .= ");\n";

                    $result = Db_Query($db_con, $sql);
                    //失敗した場合はロールバック
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }

                    //仕入データIDを抽出
                    $sql  = "SELECT";
                    $sql .= "   buy_d_id";
                    $sql .= " FROM";
                    $sql .= "   t_buy_d";
                    $sql .= " WHERE";
                    $sql .= "   buy_id = $buy_id";
                    $sql .= "   AND";
                    $sql .= "   line = $line";
                    $sql .= ";";
                    $result = Db_Query($db_con, $sql);
                    $buy_d_id = pg_fetch_result($result,0,0);

                    //直送先が選択されていなければ処理開始
//                    if($direct == null){

                    //在庫数テーブル
                    //１　発注ID<>NULLの場合
                    if($order_id != NULL){

                        if($order_d_id[$i] != "NULL"){
                            //在庫受け払いテーブル
                            //発注残削除
                            $sql  = "INSERT INTO t_stock_hand (\n";
                            $sql .= "    goods_id,\n";
                            $sql .= "    enter_day,\n";
                            $sql .= "    work_day,\n";
                            $sql .= "    work_div,\n";
                            $sql .= "    client_id,\n";
                            $sql .= "    ware_id,\n";
                            $sql .= "    io_div,\n";
                            $sql .= "    num,\n";
                            $sql .= "    slip_no,\n";
                            $sql .= "    buy_d_id,\n";
                            $sql .= "    staff_id,\n";
                            $sql .= "    shop_id,\n";
                            $sql .= "    client_cname\n";
                            $sql .= ")VALUES(\n";
                            $sql .= "    $goods_id[$i],\n";
                            $sql .= "    NOW(),\n";
                            $sql .= "    '$arrival_date',\n";
                            $sql .= "    '3',\n";
                            $sql .= "    $client_id,\n";
                            $sql .= "    $ware,\n";
                            $sql .= "    '2',\n";
//                        $sql .= "    $order_num[$i] - $buy_num[$i],";

                            //発注残打消し可能数を抽出
                            $deny_num = Get_Deny_Num($db_con, $order_d_id[$i], $buy_id);
//print "仕入数：".$buy_num[$i] ."<br>";
//print "発注残打消可能数：".$deny_num ."<br>";
                            //仕入数が発注残打消可能数を超えた場合
                            if($buy_num[$i] > $deny_num){
                                $del_num = $deny_num;
                            }else{
                                $del_num = $buy_num[$i];
                            }
//print "発注残打消数：".$del_num ."<br>";

                            $sql .= "    $del_num,\n";
                            $sql .= "    '$buy_no',\n";
                            $sql .= "    $buy_d_id,\n";
                            $sql .= "    $staff_id,\n";
                            $sql .= "    $shop_id,\n";
                            $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                            $sql .= ");\n";

                            $result = Db_Query($db_con, $sql);
                            //失敗した場合はロールバック
                            if($result === false){
                                Db_Query($db_con,"ROLLBACK");
                                exit;
                            }

                        }

                        //仕入発生
                        $sql  = "INSERT INTO t_stock_hand (";
                        $sql .= "    goods_id,";
                        $sql .= "    enter_day,";
                        $sql .= "    work_day,";
                        $sql .= "    work_div,";
                        $sql .= "    client_id,";
                        $sql .= "    ware_id,";
                        $sql .= "    io_div,";
                        $sql .= "    num,";
                        $sql .= "    slip_no,";
                        $sql .= "    buy_d_id,";
                        $sql .= "    staff_id,";
                        $sql .= "    shop_id,";
                        $sql .= "    client_cname";
                        $sql .= ")VALUES(";
                        $sql .= "    $goods_id[$i],";
                        $sql .= "    NOW(),";
                        $sql .= "    '$arrival_date',";
                        $sql .= "    '4',";
                        $sql .= "    $client_id,";
                        $sql .= "    $ware,";
                        $sql .= "    '1',";
                        $sql .= "    $buy_num[$i],";
                        $sql .= "    '$buy_no',";
                        $sql .= "    $buy_d_id,";
                        $sql .= "    $staff_id,";
                        $sql .= "    $shop_id,";
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }

                    //２　発注ID＝NULL　AND　取引区分＝２１（掛仕入）・７１（現金仕入）の場合
                    }elseif($order_id == NULL && ($trade == '21' || $trade == '71' || $trade == '25')){

                        $result = Db_Query($db_con, $sql);
                        $num = pg_num_rows($result);
   
                        //在庫受け払いテーブル（仕入発生）
                        $sql  = "INSERT INTO t_stock_hand (";
                        $sql .= "    goods_id,";
                        $sql .= "    enter_day,";
                        $sql .= "    work_day,";
                        $sql .= "    work_div,";
                        $sql .= "    client_id,";
                        $sql .= "    ware_id,";
                        $sql .= "    io_div,";
                        $sql .= "    num,";
                        $sql .= "    slip_no,";
                        $sql .= "    buy_d_id,";
                        $sql .= "    staff_id,";
                        $sql .= "    shop_id,";
                        $sql .= "    client_cname";
                        $sql .= " )VALUES(";
                        $sql .= "    $goods_id[$i],";
                        $sql .= "    NOW(),";
                        $sql .= "    '$arrival_date',";
                        $sql .= "    '4',";
                        $sql .= "    $client_id,";
                        $sql .= "    $ware,";
                        $sql .= "    '1',";
                        $sql .= "    $buy_num[$i],";
                        $sql .= "    '$buy_no',";
                        $sql .= "    $buy_d_id,";
                        $sql .= "    $staff_id,";
                        $sql .= "    $shop_id,";
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($db_con,"ROLLBACK");
                            exit;
                        }
                    //３　発注ID＝NULL　AND　取引区分＝２２（掛返品）・７２（現金返品）の場合
                    }elseif($order_id == NULL && ($trade == '23' || $trade == '73')){

                        //在庫受け払い（仕入発生）
                        $sql  = "INSERT INTO t_stock_hand (";
                        $sql .= "    goods_id,";
                        $sql .= "    enter_day,";
                        $sql .= "    work_day,";
                        $sql .= "    work_div,";
                        $sql .= "    client_id,";
                        $sql .= "    ware_id,";
                        $sql .= "    io_div,";
                        $sql .= "    num,";
                        $sql .= "    slip_no,";
                        $sql .= "    buy_d_id,";
                        $sql .= "    staff_id,";
                        $sql .= "    shop_id,";
                        $sql .= "    client_cname";
                        $sql .= ")VALUES(";
                        $sql .= "    $goods_id[$i],";
                        $sql .= "    NOW(),";
                        $sql .= "    '$arrival_date',";
                        $sql .= "    '4',";
                        $sql .= "    $client_id,";
                        $sql .= "    $ware,";
                        $sql .= "    '2',";
                        $sql .= "    $buy_num[$i],";
                        $sql .= "    '$buy_no',";
                        $sql .= "    $buy_d_id,";
                        $sql .= "    $staff_id,";
                        $sql .= "    $shop_id,";
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($db_con,"ROLLBACK");
                            exit;
                        }
//                        }
                    }

                    //発注を起こしいているものは処理開始
                    if($order_id != NULL){
                        //新たに商品を追加された場合
                        if($order_d_id[$i] == null){
                            $order_d_id[$i] = "null";
                        }

                        //発注ヘッダテーブル（処理状況更新処理）
                        $sql  = "UPDATE\n";
                        $sql .=     " t_order_d\n";
                        $sql .= " SET\n";
                        $sql .= "    rest_flg='f'\n ";
                        $sql .= " FROM\n";
                        $sql .= "   (SELECT\n";
                        $sql .= "       ord_d_id,\n";
                        $sql .= "       SUM(num) AS buy_num\n ";
                        $sql .= "   FROM\n";
                        $sql .= "       t_buy_d\n";
                        $sql .= "   GROUP BY ord_d_id\n";
                        $sql .= "   ) AS t_buy_d\n";
                        $sql .= " WHERE\n ";
                        $sql .= "   t_order_d.ord_d_id = t_buy_d.ord_d_id\n";
                        $sql .= "   AND\n ";
                        $sql .= "   t_order_d.ord_d_id = $order_d_id[$i]\n";
                        $sql .= "   AND \n";
                        $sql .= "   t_order_d.num <= t_buy_d.buy_num\n";
                        $sql .= ";\n";

                        $result = Db_Query($db_con, $sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }

                        //今回仕入た数が、発注数を超えていないか確認
                        //仕入可能件数を抽出
                        $sql  = "SELECT\n";
                        $sql .= "    t_order_h.num - COALESCE(t_buy_h.num, 0) AS num \n";
                        $sql .= "FROM\n";
                        $sql .= "    (SELECT\n";
                        $sql .= "        num,\n";
                        $sql .= "        ord_d_id \n";
                        $sql .= "    FROM\n";
                        $sql .= "        t_order_d\n";
                        $sql .= "    WHERE\n";
                        $sql .= "        t_order_d.ord_d_id = $order_d_id[$i]\n";
                        $sql .= "    ) AS t_order_h\n";
                        $sql .= "        LEFT JOIN\n";
                        $sql .= "    (SELECT\n";
                        $sql .= "        SUM(num) AS num,\n";
                        $sql .= "        ord_d_id \n";
                        $sql .= "    FROM\n";
                        $sql .= "        t_buy_h\n";
                        $sql .= "            INNER JOIN\n";
                        $sql .= "        t_buy_d\n";
                        $sql .= "        ON t_buy_h.buy_id = t_buy_d.buy_id\n";
                        $sql .= "    WHERE\n";
                        $sql .= "        t_buy_d.ord_d_id = $order_d_id[$i]\n";
                        $sql .= "        AND\n";
                        $sql .= "        t_buy_h.buy_id <> $buy_id\n";
                        $sql .= "    GROUP BY ord_d_id\n";
                        $sql .= "    ) AS t_buy_h\n";
                        $sql .= "    ON t_order_h.ord_d_id = t_buy_h.ord_d_id\n";
                        $sql .= ";\n";

                        $result = Db_Query($db_con, $sql);

                        if(pg_num_rows($result) > 0){
                            $buy_ord_num = pg_fetch_result($result,0,0);
                        }

                        //仕入数が発注数を上回っている場合
                        if($buy_ord_num < 0){
                            Db_Query($db_con, "ROLLBACK;");
                            $rollback_flg = true;
                            $buy_ord_num_err = "仕入数が発注数を超えています。";
                            break;
                        }
                    }
                }

                if($rollback_flg != true){
                    //発注を起こしているものは処理開始
                    if($order_id != NULL){
                        //処理状況更新処理
                        $ary_order_d_id = implode(",",$order_d_id);

                        $sql  = "SELECT";
                        $sql .= "   rest_flg";
                        $sql .= " FROM";
                        $sql .= "   t_order_d";
                        $sql .= " WHERE";
                        $sql .= "   ord_d_id IN ($ary_order_d_id)";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $data_num = pg_num_rows($result);
                        for($i = 0; $i < $data_num; $i++){
                            $rest_data[] = pg_fetch_result($result,$i,0);
                        }

                        //発注残がある場合
                        if(in_array('t',$rest_data)){
                            $sql  = "UPDATE";
                            $sql .= "    t_order_h";
                            $sql .= " SET";
                            $sql .= "    ps_stat = '2'";
                            $sql .= " WHERE";
                            $sql .= "    ord_id = $order_id";
                            $sql .= ";";
                        //発注した全ての商品の発注残フラグ＝fの場合
                        }else{
                            $sql  = "UPDATE";
                            $sql .= "    t_order_h";
                            $sql .= " SET";
                            $sql .= "    ps_stat = '3'";
                            $sql .= " WHERE";
                            $sql .= "    ord_id = $order_id";
                            $sql .= ";";
                        }

                        $result = Db_Query($db_con, $sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }

                    }

                    //現金取引の自動支払処理
                    //取引区分＝７１（現金仕入）・７3（現金値引）・７4（現金返品）の場合のみ処理する
                    if($trade == '71' || $trade == '73' || $trade == '74'){

                        $sql  = "SELECT";
                        $sql .= "   MAX(pay_no)";
                        $sql .= " FROM";
                        $sql .= "   t_payout_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $shop_id";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $pay_no = pg_fetch_result($result, 0,0);
                        $pay_no = $pay_no + 1;
                        $pay_no = str_pad($pay_no, 8, 0, STR_PAD_LEFT);

                        $sql  = "INSERT INTO t_payout_h(\n";
                        $sql .= "   pay_id,\n";               //支払ID
                        $sql .= "   pay_no,\n";               //支払番号
                        $sql .= "   pay_day,\n";              //支払日
                        $sql .= "   client_id,\n";            //仕入先ID
                        $sql .= "   client_name,\n";          //仕入先名
                        $sql .= "   client_name2,\n";         //仕入先名２
                        $sql .= "   client_cname,\n";         //仕入先（略称）
                        $sql .= "   client_cd1,\n";           //仕入先コード
                        $sql .= "   client_cd2,\n";           //仕入先コード
                        $sql .= "   e_staff_id,\n";           //入力者ID
                        $sql .= "   e_staff_name,\n";         //入力者名
                        $sql .= "   c_staff_id,\n";           //担当者ID
                        $sql .= "   c_staff_name,\n";         //担当者名
                        $sql .= "   input_day,\n";            //入力日
                        $sql .= "   buy_id,\n";               //仕入ID
                        $sql .= "   shop_id\n";               //ショップID
                        $sql .= ")VALUES(\n";
                        $sql .= "   (SELECT COALESCE(MAX(pay_id), 0)+1 FROM t_payout_h),\n";
                        $sql .= "   '$pay_no',\n";
                        $sql .= "   '".$buy_date."',\n";
                        $sql .= "   $client_id,\n";
                        $sql .= "   (SELECT client_name FROM t_client WHERE client_id = $client_id),\n";
                        $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = $client_id),\n";
                        $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $client_id), \n";
                        $sql .= "   (SELECT client_cd1 FROM t_client WHERE client_id = $client_id),\n";
                        $sql .= "   (SELECT client_cd2 FROM t_client WHERE client_id = $client_id),\n";
                        $sql .= "   $staff_id,\n";
                        $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), \n";
                        $sql .= "   $buy_staff,\n";
                        $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $buy_staff),\n";
                        $sql .= "   NOW(), \n";
                        $sql .= "   $buy_id, \n";
                        $sql .= "   $shop_id \n";
                        $sql .= "); \n";

                        $result = Db_Query($db_con, $sql);

                        //失敗した場合はロールバック
                        if($result === false){
                            $err_message = pg_last_error();
                            $err_format = "t_payout_h_pay_no_key";
                            $err_flg = true;
                            Db_Query($db_con, "ROLLBACK;");

                            //重複した場合
                            if(strstr($err_message, $err_format) != false){
                                $duplicate_msg = "支払が同時に行なわれたため、伝票番号の付番に失敗しました。";
                                $duplicate_flg = true;
                            }else{
                                exit;
                            }
                        }

                        if($duplicate_flg != true){
                            //登録した支払ヘッダIDを抽出
                            $sql  = "SELECT";
                            $sql .= "   pay_id ";
                            $sql .= "FROM";
                            $sql .= "   t_payout_h ";
                            $sql .= "WHERE";
                            $sql .= "   pay_no = '$pay_no'";
                            $sql .= "   AND";
                            $sql .= "   shop_id = $shop_id";
                            $sql .= ";";

                            $result = Db_Query($db_con, $sql);
                            $pay_id = pg_fetch_result($result, 0,0);

                            //支払いデータテーブルへ登録
                            $sql  = "INSERT INTO t_payout_d (";
                            $sql .= "   pay_d_id,";
                            $sql .= "   pay_id,";
                            $sql .= "   trade_id,";
                            $sql .= "   pay_amount";
                            $sql .= ")VALUES(";
                            $sql .= "   (SELECT COALESCE(MAX(pay_d_id),0)+1 FROM t_payout_d),";
                            $sql .= "   $pay_id,";
                            $sql .= "   '49',";
                            //取引区分が７１現金支払の場合
                            if($trade == '71'){
                                $sql .= "   $total_amount_data[2]";
                            //取引区分が７３・７４の場合
                            }else{
                                $sql .= "   $total_amount_data[2]*-1";
                            }
                            $sql .= ");";

                            $result = Db_Query($db_con, $sql);
                            if($result === false){
                                Db_Query($db_con, "ROLLBACK;");
                                exit;
                            }
                        }
                    }

                    Db_Query($db_con, "COMMIT");
                    header("Location:./1-3-205.php?buy_id=$buy_id&input_flg=true&buy_div=2");
                }
            }

        //発注確認へボタン押下フラグがtrueの場合
        }elseif($buy_button_flg == true){
            //フォームを固めるためのフリーズフラグ
            $freeze_flg = true;
        }
    }
}

/****************************/
//動的に増減するフォーム作成
/****************************/
//行番号カウンタ
$row_num = 1;

for($i = 0; $i < $max_row; $i++){

    //仕入先が選択されていないか仕入登録確認の場合はフリーズ
    if($select_flg == false 
        || 
    //aoyama-n 2009-09-15
    #$order_d_id[$i] != null){
    #2009-10-19 hashimoto-y
    #$order_d_id[$i] != null || $freeze_flg == true){

    #2009-10-20 hashimoto-y
    # $freeze_flg == true){
    $order_d_id[$i] != null || $freeze_flg == true){

        //aoyama-n 2009-09-15
        /**********
        $style = "color : #000000;
              border : #ffffff 1px solid;
              background-color: #ffffff";
        **********/
        $style = "border: #ffffff 1px solid; background-color: #ffffff; ";
        $type = "readonly";
        //aoyama-n 2009-09-15
        $g_form_option = "";
    }else{
        $style = null;
        $type = $g_form_option;
    }

    //aoyama-n 2009-09-15
    //値引商品及び取引区分が値引・返品の場合は赤字で表示
    $font_color = "";
    $form_trade       = $form->getElementValue("form_trade");
    $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

    if($hdn_discount_flg === 't' ||
       $form_trade[0] == '23' || $form_trade[0] == '24' || $form_trade[0] == '73' || $form_trade[0] == '74'){
        $font_color = "color: red; ";
    }else{
        $font_color = "color: #000000; ";
    }


    //表示行判定
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;

        //発注ID
        $form->addElement("hidden","hdn_order_d_id[$i]");

        //商品ID
        $form->addElement("hidden","hdn_goods_id[$i]");

        //商品コード
        //aoyama-n 2009-09-15
        if($select_flg == true){
            $form->addElement(
                "text","form_goods_cd[$i]","",
                "size=\"10\" maxLength=\"8\"
                style=\"$font_color $style $g_form_style \" $type 
                onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'hdn_goods_search_flg', $i ,$row_num)\""
            );

        }else{
            $form->addElement(
                "text","form_goods_cd[$i]","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly"
            );
        }

        //商品名
        //aoyama-n 20009-09-15
        #if($name_change[$i] == '2'){
        #    $form->addElement(
        #        "text","form_goods_name[$i]","",
        #        "size=\"54\" style=\"$font_color $style\" $g_text_readonly"
        #    );
        #2009-10-20 hashimoto-y
        if($name_change[$i] == '2' && $freeze_flg != true){
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" style=\"$font_color\" $g_text_readonly $type"
            );
        }elseif($select_flg == false){
            $form->addElement(
                "text","form_goods_name[$i]","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly"
            );
        #2009-10-20 hashimoto-y
        }elseif($order_d_id[$i] != null && $freeze_flg != true){
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" maxLength=\"41\"
                 style=\"$font_color $g_form_option\""
            );
        }else{
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" maxLength=\"41\" 
                 style=\"$font_color $style $g_form_option\" $type" 
            );
        }

        $form->addElement("hidden","hdn_name_change[$i]","","");
        $form->addElement("hidden","hdn_stock_manage[$i]","","");

        //入数
        //aoyama-n 2009-09-15
        $form->addElement("text","form_in_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" 
            readonly"
        );

        //注文入数
        //aoyama-n 2009-09-15
        if($freeze_flg == true){
            $form->addElement("text","form_order_in_num[$i]","",
                "size=\"6\" maxLength=\"5\"
                onKeyup=\"in_num($i,'hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $style \" $type"
            );
        }elseif($select_flg == false){
            $form->addElement(
                "text","form_order_in_num[$i]","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly'"
            );
        }else{
            $form->addElement("text","form_order_in_num[$i]","",
                "size=\"6\" maxLength=\"5\"
                onKeyup=\"in_num($i,'hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $g_form_style $g_form_option\" "
            );
        }

        //現在庫数
        //aoyama-n 2009-09-15
        $form->addElement(
            "text","form_stock_num[$i]","",
            "size=\"11\" maxLength=\"5\" 
            style=\"$font_color
            border : #ffffff 1px solid;
            background-color: #ffffff; text-align: right\" 
            readonly"
        );

        //発注残
        //aoyama-n 2009-09-15
        $form->addElement(
            "hidden","form_order_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right \"readonly"
        );

        //仕入済数
        $form->addElement(
            "text","form_rbuy_num[$i]","",
            'size="11" maxLength=\"9\" 
            style="color : #000000; 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right" readonly'
        );

        //仕入数
        //aoyama-n 2009-09-15
        if($freeze_flg == true){
            $form->addElement("text","form_buy_num[$i]","",
                "size=\"6\" maxLength=\"5\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');ord_in_num($i);\"
                style=\"text-align: right; $font_color $style $g_form_style \" $type"
            );
        }elseif($select_flg == false){
            $form->addElement(
                "text","form_buy_num[$i]","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly'"
            );
        }else{
            $form->addElement("text","form_buy_num[$i]","",
                "size=\"6\" maxLength=\"5\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');ord_in_num($i);\"
                style=\"text-align: right; $font_color $g_form_style;\" $g_form_option "
            );
        }

        //仕入単価
        //aoyama-n 2009-09-15
        if($select_flg == false){
            $form_buy_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly"
            );
            $form_buy_price[$i][] =& $form->createElement("static","","",".");
            $form_buy_price[$i][] =& $form->createElement(
                "text","d","",
                "size=\"1\" style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly'"
            );

        #2009-10-20 hashimoto-y
        }elseif($order_d_id[$i] != null && $freeze_flg != true){
            $form_buy_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" maxLength=\"9\" class=\"money\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $g_form_style \" $g_form_option
                "
            );
            $form_buy_price[$i][] =& $form->createElement("static","","",".");
            $form_buy_price[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: left; $font_color $g_form_style \" $g_form_option
            "
            );
        }else{
            $form_buy_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" maxLength=\"9\" class=\"money\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $style $g_form_style \" $type
                "
            );
            $form_buy_price[$i][] =& $form->createElement("static","","",".");
            $form_buy_price[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: left; $font_color $style $g_form_style \" $type
            "
            );
        }
        $form->addGroup($form_buy_price[$i], "form_buy_price[$i]", "");

        //課税区分
        $form->addElement(
            "text","form_tax_div[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"color : #000000; 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );
        $form->addElement("hidden","hdn_tax_div[$i]","","");

        //金額(税抜き)
        //aoyama-n 2009-09-15
        $form->addElement(
            "text","form_buy_amount[$i]","",
            "size=\"25\" maxLength=\"18\"
             style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly"
        );

        //発注残
        //aoyama-n 2009-09-15
        $form->addElement(
            "text","form_rorder_num[$i]","",
            "size=\"11\" maxLength=\"9\"
            style=\"$font_color
            border : #ffffff 1px solid;
            background-color: #ffffff;
            text-align: right\" readonly'"
        );

        //検索リンク
        $form->addElement(
            "link","form_search[$i]","","#","検索",
            "TABINDEX=-1
            onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','hdn_goods_search_flg'), 500, 450,5,$client_id,$i,$row_num);\""
            );


        //登録確認画面の場合は非表示
        if($select_flg === true ){
            //削除リンク
            //最終行を削除する場合、削除した後の最終行に合わせる
            if($row_num == $max_row-$del_num){
                $form->addElement(
                    "link","form_del_row[$i]","","#",
                    "<font color='#FEFEFE'>削除</font>",
                    "TABINDEX=-1 
                    onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num-1);return false;\""
                );
            //最終行以外を削除する場合、削除する行と同じNOの行に合わせる
            }else{
                $form->addElement(
                    "link","form_del_row[$i]","","#",
                    "<font color='#FEFEFE'>削除</font>",
                    "TABINDEX=-1 
                    onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num);return false;\""
                );
            }
        }

        //フリーズフラグがtrueの場合
        //aoyama-n 2009-09-15
        /********************
        if($freeze_flg == true){
            $form->freeze();
        }
        ********************/

        /****************************/
        //表示用HTML作成
        /****************************/
        $html .= "<tr class=\"Result1\">";
        $html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        //倉庫、仕入先が選択されていて、確認画面の表示でない場合
        if($select_flg === true && $freeze_flg != true 
               && 
        //発注データIDがnullの場合
        ($order_d_id[$i] == null)
        ){
            $html .=    "（";
            $html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
            $html .=    "）";
        }
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_rorder_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_order_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_price[$i]"]]->toHtml();
        $html .=    "</td>";

        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_amount[$i]"]]->toHtml();
        $html .=    "</td>";

        //倉庫、仕入先を選択済みOR確認画面以外
        if($freeze_flg === true || $select_flg === false){
            $show_del_subject_flg = false;
        }elseif($select_flg === true && $freeze_flg != true && $order_d_id[$i] == null){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
            $html .= "  </td>";

            $show_del_subject_flg = true;
        }elseif($order_d_id[$i] != null){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .= "      <br>"; 
            $html .= "  </td>";
            $show_del_subject_flg = true;
        } 
       $html .= "</tr>";
        //行番号を＋1
        $row_num = $row_num+1;
    }
}

//登録確認画面では、以下のボタンを表示しない
if($select_flg == true && $freeze_flg !== true){
    //button
    $form->addElement("submit","form_buy_button","仕入確認画面へ", $disabled);
    $form->addElement("button","form_sum_button","合　計",
            "onClick=\"javascript:Button_Submit('hdn_sum_button_flg','#foot','t', this)\""
    );

    //発注から仕入を起こしている場合は表示しない
    //行追加ボタン
    if($order_flg != true){
        if($update_flg != true){
            //仕入先リンク
/*
            $form->addElement("link","form_client_link","","./1-3-201.php","仕入先","
                onClick=\"return Open_SubWin('../dialog/1-0-208.php',Array('form_client[cd]','form_client[name]', 'hdn_client_search_flg'),500,450,5,1);\""
            );
*/
            $form->addElement("link","form_client_link","#","./1-3-207.php","仕入先","
            onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','hdn_client_search_flg'),500,450,'1-3-207',1);\"");
        }else{
            $form->addElement("static","form_client_link","","仕入先");
        }
    }else{
        $form->addElement("static","form_client_link","","仕入先");
//        $select_flg = false;
    }

        $form->addElement("button","form_add_row_button", "追　加", 
            "onClick=\"javascript:Button_Submit('add_row_flg','./1-3-207.php#foot','true', this)\""
        );
    if($update_flg != true){    
        //表示ボタン
        $form->addElement("button","form_show_button","表　示",
            "onClick=\"javascript:Button_Submit('hdn_show_button_flg','#','t', this)\""
        );
    }
}elseif($freeze_flg == true){
    //登録確認画面では以下のボタンを表示
    //戻る  
    $form->addElement("button","form_back_button","戻　る","onClick=\"javascript:history.back()\"");
    
    //OK    
    $form->addElement("submit","form_comp_button","仕入完了", $disabled);

    //発注先
    $form->addElement("static","form_client_link","","発注先"); 

    $form->freeze();
}else{
    //表示ボタン
    $form->addElement("button","form_show_button","表　示",
        "onClick=\"javascript:Button_Submit('hdn_show_button_flg','#','t', this)\""
    );

    $form->addElement("button","form_sum_button","合　計",
            "onClick=\"javascript:Button_Submit('hdn_sum_button_flg','#foot','t', this)\""
    );
    //仕入先リンク
/*
    $form->addElement("link","form_client_link","","./1-3-201.php","仕入先","
        onClick=\"return Open_SubWin('../dialog/1-0-208.php',Array('form_client[cd]','form_client[name]', 'hdn_client_search_flg'),500,450,5,1);\""
    );
*/
    $form->addElement("link","form_client_link","#","./1-3-207.php","仕入先","
            onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','hdn_client_search_flg'),500,450,'1-3-207',1);\"");

}

/**
 *　仕入可能数を抽出する関数
 *
 *
 *
 *
**/
function Get_Deny_Num($db_con, $ord_d_id, $buy_id){

    //仕入可能件数を抽出
    $sql  = "SELECT\n";
    $sql .= "    t_order_h.num - COALESCE(t_buy_h.num, 0) AS num \n";
    $sql .= "FROM\n";
    $sql .= "    (SELECT\n";
    $sql .= "        num,\n";
    $sql .= "        ord_d_id \n";
    $sql .= "    FROM\n";
    $sql .= "        t_order_d\n";
    $sql .= "    WHERE\n";
    $sql .= "        t_order_d.ord_d_id = $ord_d_id\n";
    $sql .= "    ) AS t_order_h\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    (SELECT\n";
    $sql .= "        SUM(num) AS num,\n";
    $sql .= "        ord_d_id \n";
    $sql .= "    FROM\n";
    $sql .= "        t_buy_h\n";
    $sql .= "            INNER JOIN\n";
    $sql .= "        t_buy_d\n";
    $sql .= "        ON t_buy_h.buy_id = t_buy_d.buy_id\n";
    $sql .= "    WHERE\n";
    $sql .= "        t_buy_d.ord_d_id = $ord_d_id\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.buy_id <> $buy_id\n";
    $sql .= "    GROUP BY ord_d_id\n";
    $sql .= "    ) AS t_buy_h\n";
    $sql .= "    ON t_order_h.ord_d_id = t_buy_h.ord_d_id\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $deny_num = pg_fetch_result($result, 0,0);

    return $deny_num;
}





//ロット数を計算する
$js  = " function in_num(num,id,order_num,price_i,price_d,amount,coax){\n";
$js .= "    var in_num = \"form_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_in_num = \"form_order_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_num = \"form_buy_num\"+\"[\"+num+\"]\";\n";
$js .= "    var buy_amount = \"form_buy_amount\"+\"[\"+num+\"]\";\n";
$js .= "    var v_in_num = document.dateForm.elements[in_num].value;\n";
$js .= "    var v_ord_in_num = document.dateForm.elements[ord_in_num].value;\n";
$js .= "    var v_ord_num = document.dateForm.elements[ord_num].value;\n";
$js .= "    var v_num = v_in_num * v_ord_in_num;\n";
$js .= "    if(isNaN(v_num) == true){\n";
$js .= "        v_num = \"\"\n";
$js .= "    }\n";
$js .= "    document.dateForm.elements[ord_num].value = v_num;\n";
$js .= "    Mult(id,order_num,price_i,price_d,amount,coax);\n";
$js .= "}\n";

//注文ロット数を計算する
$js .= "function ord_in_num(num){\n";
$js .= "    var in_num = \"form_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_in_num = \"form_order_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_num = \"form_buy_num\"+\"[\"+num+\"]\";\n";
$js .= "    var v_in_num = document.dateForm.elements[in_num].value;\n";
$js .= "    var v_ord_in_num = document.dateForm.elements[ord_in_num].value;\n";
$js .= "    var v_ord_num = document.dateForm.elements[ord_num].value;\n";
$js .= "    var result = v_ord_num % v_in_num;\n";
$js .= "    if(result == 0){\n";
$js .= "        var res = v_ord_num / v_in_num;\n";
$js .= "        document.dateForm.elements[ord_in_num].value = res;\n";
$js .= "    }else{  \n";
$js .= "        document.dateForm.elements[ord_in_num].value = \"\";\n";
$js .= "    }\n";
$js .= "}\n";

/****************************/
// 仕入先の状態取得
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


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
$page_menu = Create_Menu_h('buy','2');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
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
    'html'          => "$html",
    'select_flg'    => "$select_flg",
    'js'            => "$js",
    'form_potision' => "$form_potision",
    'freeze_flg'    => "$freeze_flg",
    'warning'       => "$warning",
    'ap_balance'    => "$ap_balance",
    'error'         => "$error",
    'order_flg'     => "$order_flg",
    'goods_twice'   => "$goods_twice",
    "client_state_print"    => "$client_state_print",
    "show_del_subject_flg" => "$show_del_subject_flg",
));


$smarty->assign("goods_err", $goods_err);
$smarty->assign("price_num_err", $price_num_err);
$smarty->assign("num_err", $num_err);
$smarty->assign("price_err", $price_err);
$smarty->assign("duplicate_goods_err", $duplicate_goods_err);
$smarty->assign("ord_num_err", $ord_num_err);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
