<?php

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 *   2007/01/06  xx-xxx        kajioka-h   直営のときの「仕入先」「FC」切替ボタンを黄色にした
 *   2007/02/20                watanabe-k  初期表示に支店倉庫を表示するように修正   
 *   2007/03/07                watanabe-k  倉庫には拠点倉庫のみ表示するように修正   
 *   2007/03/09  要望9-1       kajioka-h   入荷日を変更すると仕入日が変わるように変更
 *   2007/03/13                watanabe-k  取引区分に自分の取引区分をセットするように修正
 *   2007/03/16                watanabe-k  現金取引時に49をセットするように修正
 *   2007/05/18                watanabe-k  直送先のプルダウンを等幅フォントに変更 
 */

$page_title = "仕入入力";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"], NULL, "onSubmit=return confirm(true)");

//DB接続
$conn = Db_Connect();


// 権限チェック
$auth       = Auth_Check($conn);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// 再遷移先をSESSIONにセット
/*****************************/
// GET、POSTが無い場合
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("buy");
}


/****************************/
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
//$shop_gid = $_SESSION["shop_gid"];
$rank_cd    = $_SESSION["rank_cd"];
$staff_id   = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];

if ($_GET == null && $_POST["form_buy_button"] == null && $_POST["comp_button"] == null){
    $_SESSION["referer"]["f"]["buy"] = "2-3-207";
}

//発注IDを取得
if($_GET["ord_id"] != NULL){
    Get_Id_Check3($_GET["ord_id"]);
    $get_order_id = $_GET["ord_id"];
    $order_get_flg = true;
}

//仕入IDを取得
if($_GET["buy_id"] != NULL){
    Get_Id_Check3($_GET["buy_id"]);
    $get_buy_id = $_GET["buy_id"];
    $buy_get_flg = true;
}elseif($_POST["hdn_buy_id"] != NULL){
    $get_buy_id = $_POST["hdn_buy_id"];
    $buy_get_flg = true;
}

//直営ではない場合TOP画面へ遷移
if($group_kind != '2'){
    header("Location:../top.php");
}

/****************************/
//初期設定
/****************************/
//表示行数
if($_POST["max_row"] != NULL){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}

//初期表示位置変更
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//削除行数
$del_history[] = NULL; 

//仕入先が指定されているか
if($_POST["hdn_client_id"] != NULL){
    $client_search_flg = true; 
    $client_id  = $_POST["hdn_client_id"];
    $head_flg   = $_POST["head_flg"];
    $coax       = $_POST["hdn_coax"];
    $tax_franct = $_POST["hdn_tax_franct"];
    $royalty    = $_POST["hdn_royalty"];
}

//倉庫が指定されているか
if($_POST["form_ware"] != NULL){
    $stock_search_flg = true;
}

//商品名変更可・変更不可判定フラグ
$name_change = $_POST["hdn_name_change"];

//自分の消費税額、ロイヤリティを抽出
$sql  = "SELECT";
$sql .= "   tax_rate_n,";
$sql .= "   royalty_rate";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_id = $shop_id";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$tax_rate = pg_fetch_result($result,0,0);
$rate  = bcdiv($tax_rate,100,2);                //消費税率
$royalty_rate = pg_fetch_result($result ,0,1);  //ロイヤリティ

//自動採番の発注番号取得
$sql  = "SELECT";
$sql .= "   MAX(buy_no)";
$sql .= " FROM";
$sql .= "   t_buy_h";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$buy_no = pg_fetch_result($result, 0 ,0);
$buy_no = $buy_no +1;
$buy_no = str_pad($buy_no, 8, 0, STR_PAD_LEFT);

//倉庫ID取得
/*
$sql  = "SELECT";
$sql .= "   ware_id";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_id = $shop_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$def_ware_id = @pg_fetch_result($result, 0,0);
*/

$def_ware_id = Get_ware_id($conn, Get_Branch_Id($conn));
if($def_ware_id != null){
    $stock_search_flg = true;
}

//初期値セット
$def_data["form_ware"] = $def_ware_id;
$def_data["form_buy_no"] = $buy_no;
$def_data["form_buy_staff"] = $staff_id;
//$def_data["form_order_staff"] = $staff_id;
$def_data["form_trade"]  = '21';

// 入荷日
$def_data["form_arrival_day"]["y"] = date("Y");
$def_data["form_arrival_day"]["m"] = date("m");
$def_data["form_arrival_day"]["d"] = date("d");

// 仕入日
$def_data["form_buy_day"]["y"] = date("Y");
$def_data["form_buy_day"]["m"] = date("m");
$def_data["form_buy_day"]["d"] = date("d");

$form->setDefaults($def_data);

$freeze_flg       = $_POST["freeze_flg"];
$order_freeze_flg = $_POST["order_freeze_flg"];

/****************************/
//行数追加
/****************************/
if($_POST["add_row_flg"]==true){

    //最大行に、＋５する
    $max_row = $_POST["max_row"]+5;

    //行数追加フラグをクリア
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//行削除処理
/****************************/
if(isset($_POST["del_row"])){

    //削除リストを取得
    $del_row = $_POST["del_row"];

    //削除履歴を配列にする。
    $del_history = explode(",", $del_row);

    //削除した行数
    $del_num     = count($del_history)-1;
}

/****************************/
//仕入IDがある場合
/****************************/
if($_GET[buy_id] != null && $_POST["first_set_flg"] == null){
    //仕入ヘッダ
    $sql  = "SELECT\n";
    $sql .= "   t_buy_h.buy_id,\n";
    $sql .= "   t_buy_h.buy_no,\n";
/*******************************************************************
    $sql .= "   t_order_h.ord_no,";
    $sql .= "   to_date(t_order_h.ord_time,'YYYY/mm/dd') AS ord_time,";
    $sql .= "   t_order_h.arrival_day AS arrival_hope_day,";
*******************************************************************/
    $sql .= "   CASE renew_flg\n";
    $sql .= "       WHEN 'f' THEN (SELECT client_id FROM t_client WHERE t_client.client_id = t_buy_h.client_id)\n ";
    $sql .= "   END AS client_id,\n";
    $sql .= "   CASE renew_flg\n";
    $sql .= "       WHEN 'f' THEN (SELECT client_cd1 FROM t_client WHERE t_client.client_id = t_buy_h.client_id)\n ";
    $sql .= "   END AS client_cd1,\n";
    $sql .= "   CASE renew_flg\n";
    $sql .= "       WHEN 'f' THEN (SELECT client_cd2 FROM t_client WHERE t_client.client_id = t_buy_h.client_id)\n ";
    $sql .= "   END AS client_cd2,\n";
    $sql .= "   CASE renew_flg\n";
    $sql .= "       WHEN 'f' THEN (SELECT client_cname FROM t_client WHERE t_client.client_id = t_buy_h.client_id)\n ";
    $sql .= "   END AS client_cname,\n";
    $sql .= "   t_buy_h.direct_id,\n";
    $sql .= "   t_buy_h.ware_id,\n";
    $sql .= "   t_buy_h.trade_id,\n";
    $sql .= "   t_buy_h.c_staff_id,\n";
    $sql .= "   t_buy_h.note,\n";
    $sql .= "   t_buy_h.renew_flg,\n";
/*******************************************************************
    $sql .= "   t_buy_h.ord_id,";
*******************************************************************/
    $sql .= "   t_buy_h.buy_day,\n";
    $sql .= "   t_buy_h.arrival_day,\n";
/*******************************************************************
    $sql .= "   t_buy_h.oc_staff_id,\n";
*******************************************************************/
    $sql .= "   t_buy_h.enter_day AS buy_enter_day \n";
/*******************************************************************
    $sql .= "   t_order_h.enter_day AS ord_enter_day,";
    $sql .= "   t_order_h.change_day ";
*******************************************************************/
    $sql .= " FROM\n";
    $sql .= "   t_buy_h\n";
/*******************************************************************
    $sql .= "       LEFT JOIN\n";
    $sql .= "   t_order_h\n";
    $sql .= "   ON t_buy_h.ord_id = t_order_h.ord_id \n";
*******************************************************************/
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_client\n";
    $sql .= "   ON t_buy_h.client_id = t_client.client_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_buy_h.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.buy_id = $get_buy_id\n";
    //代行IDと照会IDはnull
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.intro_sale_id IS NULL\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.act_sale_id IS NULL\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.renew_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.buy_div = '2'\n";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $buy_h_data = pg_fetch_array($result);

    $order_id = $buy_h_data[14];

    //仕入データ
    $sql  = "SELECT ";
/*******************************************************************
    $sql .= "   t_buy_d.ord_d_id,";
*******************************************************************/
    $sql .= "   t_goods.goods_id,";
    $sql .= "   t_buy_d.goods_cd,";
    $sql .= "   t_buy_d.goods_name,";
    $sql .= "   t_goods.tax_div,";
    $sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num,";
/*******************************************************************
    $sql .= "   t_order_d.num AS order_num,";
*******************************************************************/
    $sql .= "   t_buy_d.num AS buy_num,";
    $sql .= "   t_buy_d.buy_price,";
    $sql .= "   t_buy_d.buy_amount,";
    $sql .= "   CASE WHEN t_order_d.num IS NOT NULL THEN t_order_d.num - COALESCE(t_buy_d.num,0) END AS on_order_num,";
    $sql .= "   t_goods.name_change,";
    $sql .= "   t_goods.stock_manage,";
    $sql .= "   t_goods.in_num,";
    $sql .= "   t_goods.royalty";
    $sql .= " FROM";
    $sql .= "   t_buy_h INNER JOIN t_buy_d ON t_buy_h.buy_id = t_buy_d.buy_id";
    $sql .= "   LEFT JOIN ";
    $sql .= "   (SELECT";
    $sql .= "       goods_id,";
    $sql .= "       SUM(stock_num)AS stock_num";
    $sql .= "   FROM";
    $sql .= "       t_stock";
    $sql .= "   WHERE";
    $sql .= "       shop_id = $shop_id";
    $sql .= "       AND";
    $sql .= "       ware_id = $buy_h_data[9]";
    $sql .= "       GROUP BY t_stock.goods_id";
    $sql .= "   )AS t_stock";
    $sql .= "   ON t_buy_d.goods_id = t_stock.goods_id";
    $sql .= "   INNER JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id";
    $sql .= "   LEFT JOIN t_order_d ON t_buy_d.ord_d_id = t_order_d.ord_d_id";
    $sql .= " WHERE";
    $sql .= "   t_buy_d.buy_id = $get_buy_id";
    $sql .= "   AND ";
    $sql .= "   t_buy_h.shop_id = $shop_id";
    $sql .= " ORDER BY t_buy_d.line ";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $buy_d_data_num = pg_num_rows($result);
	$max_row = $buy_d_data_num;                 //表示行数

    for($i = 0; $i < $buy_d_data_num; $i++){
        $buy_d_data[] = pg_fetch_array($result);
    }

/*******************************************************************
    //発注日時を分割
    $order_date = explode("-",$buy_h_data["ord_time"]);

    //入荷予定日を分割
    $arrival_hope_date = explode("-",$buy_h_data["arriaval_hope_day"]);
*******************************************************************/
    //仕入日を分割
    $buy_date   = explode("-",$buy_h_data["buy_day"]);

    //入荷日を分割
    $arrival_date   = explode("-", $buy_h_data["arrival_day"]);

    //フォームに値をセット
    $set_buy_data["hdn_buy_id"]                     = $buy_h_data["buy_id"];        //仕入ID
    $set_buy_data["form_buy_no"]                    = $buy_h_data["buy_no"];        //仕入番号
/*******************************************************************
    $set_buy_data["hdn_order_id"]                   = $buy_h_data[14];          //発注ID
    $set_buy_data["form_order_no"]                  = $buy_h_data[2];           //発注番号
    $set_buy_data["form_order_day"]["y"]            = $order_date[0];           //発注日（年）
    $set_buy_data["form_order_day"]["m"]            = $order_date[1];           //発注日（月）
    $set_buy_data["form_order_day"]["d"]            = $order_date[2];           //発注日（日）
    $set_buy_data["form_arrival_hope_day"]["y"]     = $arrival_hope_date[0];    //入荷予定日（年）
    $set_buy_data["form_arrival_hope_day"]["m"]     = $arrival_hope_date[1];    //入荷予定日（月）
    $set_buy_data["form_arrival_hope_day"]["d"]     = $arrival_hope_date[2];    //入荷予定日（日）
    $set_buy_data["hdn_ord_enter_day"]              = $buy_h_data["ord_enter_day"];   //発注登録日
    $set_buy_data["hdn_buy_enter_day"]              = $buy_h_data["buy_enter_day"]; //仕入登録日
*******************************************************************/
    $set_buy_data["hdn_client_id"]                  = $buy_h_data["client_id"];     //仕入先ID
    $set_buy_data["form_client"]["cd1"]             = $buy_h_data["client_cd1"];    //仕入先CD
    $set_buy_data["form_client"]["cd2"]             = $buy_h_data["client_cd2"];    //仕入先CD
    $set_buy_data["form_client"]["name"]            = $buy_h_data["client_cname"];  //仕入先名
    $set_buy_data["form_direct"]                    = $buy_h_data["direct_id"];     //直送先
    $set_buy_data["form_ware"]                      = $buy_h_data["ware_id"];       //倉庫
    $set_buy_data["form_trade"]                     = $buy_h_data["trade_id"];      //取引区分
    $set_buy_data["form_buy_staff"]                 = $buy_h_data["c_staff_id"];    //仕入担当者
    $set_buy_data["form_note"]                      = $buy_h_data["note"];          //備考
    $set_buy_data["form_arrival_day"]["y"]          = $arrival_date[0];             //入荷日（年）
    $set_buy_data["form_arrival_day"]["m"]          = $arrival_date[1];             //入荷日（月）
    $set_buy_data["form_arrival_day"]["d"]          = $arrival_date[2];             //入荷日（日）
    $set_buy_data["form_buy_day"]["y"]              = $buy_date[0];                 //仕入日（年）
    $set_buy_data["form_buy_day"]["m"]              = $buy_date[1];                 //仕入日（月）
    $set_buy_data["form_buy_day"]["d"]              = $buy_date[2];                 //仕入日（日）
/*******************************************************************
    $set_buy_data["form_order_staff"]               = $buy_h_data[""];              //発注担当者
********************************************************************/
    $set_buy_data["hdn_buy_enter_day"]              = $buy_h_data["buy_enter_day"]; //仕入登録日
    $set_buy_data["hdn_ord_change_day"]             = $buy_h_data["change_day"];    //発注変更日

    $client_id  = $buy_h_data["client_id"];

    //仕入先の丸め区分、端数区分を抽出
    $sql  = "SELECT";
    $sql .= "   coax,";
    $sql .= "   tax_franct";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= ";";

    $result     = Db_Query($conn, $sql);
    $coax       = pg_fetch_result($result, 0, "coax");
    $tax_franct = pg_fetch_result($result, 0, "tax_franct");

    //hiddenに金額まるめ、端数区分をセット
    $set_buy_data["hdn_coax"]       = $coax;
    $set_buy_data["hdn_tax_franct"] = $tax_franct;

    for($i = 0; $i < $max_row; $i++){

        if($buy_d_data[$i]["goods_id"] != NULL){
            //仕入単価を分割
            $price_data = explode('.',$buy_d_data[$i]["buy_price"]);

            $buy_amount[]   = $buy_d_data[$i]["buy_amount"];
            $tax_div[]      = $buy_d_data[$i]["tax_div"];
            $royalty[]      = $buy_d_data[$i]["royalty"];

/*******************************************************************
            $set_buy_data["hdn_order_d_id"][$i]         = $buy_d_data[$i][0];                                       //発注データID
*******************************************************************/
            $set_buy_data["hdn_goods_id"][$i]           = $buy_d_data[$i]["goods_id"];                              //商品ID
            $set_buy_data["form_goods_cd"][$i]          = $buy_d_data[$i]["goods_cd"];                              //商品CD
            $set_buy_data["form_goods_name"][$i]        = $buy_d_data[$i]["goods_name"];                            //商品名
            $set_buy_data["hdn_tax_div"][$i]            = $buy_d_data[$i]["tax_div"];                               //課税区分（hidden用）
            $set_buy_data["form_stock_num"][$i]         = ($buy_d_data[$i]["stock_manage"] == '1')? $buy_d_data[$i]["stock_num"] : '-';   //在庫数
/*******************************************************************
            $set_buy_data["form_order_num"][$i]         = ($buy_d_data[$i][0] != null)? $buy_d_data[$i][6] : '-';   //発注数
*******************************************************************/
            $set_buy_data["form_buy_num"][$i]           = $buy_d_data[$i]["buy_num"];                               //仕入数
            $set_buy_data["form_buy_price"][$i]["i"]    = $price_data[0];                                           //仕入単価（整数部）
            $set_buy_data["form_buy_price"][$i]["d"]    = ($price_data[1] != NULL)? $price_data[1] : "00";          //仕入単価（少数部）
            $set_buy_data["form_buy_amount"][$i]        = number_format($buy_d_data[$i]["buy_amount"]);             //仕入金額（税抜き）
/*******************************************************************
            $set_buy_data["form_rorder_num"][$i]        = ($buy_d_data[$i][0] != null)? $buy_d_data[$i][10] : '-';  //発注残
*******************************************************************/
            $set_buy_data["form_rorder_num"][$i]        = '-';                                                      //発注残
            $set_buy_data["hdn_name_change"][$i]        = $buy_d_data[$i]["name_change"];                           //品名変更
            $set_buy_data["hdn_stock_manage"][$i]       = $buy_d_data[$i]["stock_manage"];                          //在庫管理
            $set_buy_data["form_in_num"][$i]            = $buy_d_data[$i]["in_num"];                                //入数
/*******************************************************************
            $set_buy_data["form_rbuy_num"][$i]          = ($buy_d_data[$i][0] != null)? $buy_d_data[$i][6] - $buy_d_data[$i][10] : '-'; //仕入済数
*******************************************************************/
            $set_buy_data["form_rbuy_num"][$i]          = '-';                                                      //仕入済数

            //仕入入数
            if($buy_d_data[$i]["buy_num"] % $buy_d_data[$i]["in_num"] == 0 && $buy_d_data[$i]["in_num"]!=null){
                $set_buy_data["form_order_in_num"][$i]  = $buy_d_data[$i]["buy_num"] / $buy_d_data[$i]["in_num"];
            }

            $set_buy_data["hdn_royalty"][$i]            = $buy_d_data[$i]["royalty"];                               //ロイヤリティ

            $name_change[$i] = $buy_d_data[$i]["name_change"];                                                      //品名変更
        }
    }

    $client_search_flg = true;
    $stock_search_flg  = true;

    $renew_flg = $buy_h_data[13];   //日時更新フラグ

    //日次更新フラグ＝ｆ　AND　発注番号＝NULLの場合
    if($renew_flg == 'f' && $order_id == NULL){
//        $set_buy_data["order_freeze_flg"] = $order_freeze_flg;
    //日次更新フラグ＝ｆ　発注番号<>NULLの場合
    }elseif($renew_flg == 'f' && $order_id != NULL){
        $freeze_flg = true;
        $order_freeze_flg = true;
        $set_buy_data["order_freeze_flg"] = $order_freeze_flg;
        $set_buy_data["freeze_flg"] = $freeze_flg;
    }

    $total_amount_data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $conn);

    $set_buy_data["form_buy_money"]     = number_format($total_amount_data[0]);
    $set_buy_data["form_tax_money"]     = number_format($total_amount_data[1]);
    $set_buy_data["form_total_money"]   = number_format($total_amount_data[2]);

    $form->setDefaults($set_buy_data);

/****************************/
//表示ボタン押下処理＆発注IDがある場合
/****************************/
//GETの発注IDがあるもしくは表示ボタンが押下される
//AND
//得意先検索フラグがtureでない
//AND
//倉庫検索フラグがtrueでない
//AND
//しんれ完了フラグが押されていない
//AND
//合計ボタンが押下されていない
/*
}elseif(($_POST["show_button_flg"] == true || $order_get_flg == true) 
        && 
        $_POST["client_search_flg"] != true 
        && 
        $_POST["stock_search_flg"] != true 
        && 
        $_POST["comp_button"] != "仕入完了"
        &&
        $_POST["sum_button_flg"] != true){

    //表示ボタン押下時
    if($_POST["show_button_flg"] == true){
        $get_order_id = $_POST["form_order_no"];
    }

    if($get_order_id != null){
        $sql  = " SELECT";
        $sql .= "   t_order_h.ord_id,";
        $sql .= "   t_order_h.ord_no,";
        $sql .= "   to_date(t_order_h.ord_time,'YYYY/mm/dd'),";
        $sql .= "   arrival_day,";
        $sql .= "   t_client.client_id,";
        $sql .= "   t_client.client_cd1,";
//        $sql .= "   t_client.client_name,";
        $sql .= "   t_client.client_cname,";
        $sql .= "   t_order_h.direct_id,";
        $sql .= "   t_order_h.ware_id,";
        $sql .= "   t_order_h.trade_id,";
        $sql .= "   t_order_h.c_staff_id,";
        $sql .= "   t_order_h.ps_stat,";
        $sql .= "   t_client.head_flg,";
        $sql .= "   t_order_h.ord_staff_id,";
        $sql .= "   t_order_h.enter_day,";
        $sql .= "   t_order_h.change_day, ";
        $sql .= "   t_client.tax_franct, ";
        $sql .= "   t_client.coax ";
        $sql .= " FROM";
        $sql .= "   t_order_h INNER JOIN t_client ON t_order_h.client_id = t_client.client_id";
        $sql .= " WHERE";
        $sql .= "   (t_order_h.ord_stat <> 3";
        $sql .= "   OR";
        $sql .= "   t_order_h.ord_stat IS NULL)";
        $sql .= "   AND";
        $sql .= "   t_order_h.ord_id = $get_order_id";
        $sql .= "   AND";
        $sql .= "   t_order_h.shop_id = $shop_id";
        $sql .= "   AND";
        $sql .= "   t_order_h.ps_stat IN (1,2)";
        $sql .= ";";

        $result         = Db_Query($conn, $sql);

        //発注IDがある場合はGETしたIDのチェック
        if($order_get_flg == true){
            Get_Id_Check($result);
        }

        $order_h_num    = pg_num_rows($result);
        $order_h_data   = pg_fetch_array($result);

        $ps_stat = $order_h_data[10];
    }else{
        header("Location: ./2-3-201.php");
        exit;
    }

    if($ps_stat == '3'){
        $finish = "入力された発注番号の商品は全て仕入済みです。";

    //発注ヘッダに登録があれば
    }elseif($order_h_num > 0){
        $sql  = "SELECT ";
        $sql .= "   t_order_d.ord_d_id,";                               //発注データID
        $sql .= "   t_goods.goods_id,";                                 //商品ID
        $sql .= "   t_goods.goods_cd,";                                 //商品コード
        $sql .= "   t_order_d.goods_name,";                             //商品名
        $sql .= "   CASE t_goods.stock_manage";                         //在庫管理
        $sql .= "        WHEN 1 THEN COALESCE(t_stock.stock_num,0)";
        $sql .= "   END AS stock_num,";
        $sql .= "   t_order_d.num AS order_num,";                       //発注数
        $sql .= "   COALESCE(t_buy.buy_num,0) AS buy_num,";             //仕入数
        $sql .= "   t_order_d.buy_price,";                              //仕入単価
        $sql .= "   t_order_d.tax_div,";                                //課税区分
        $sql .= "   t_order_d.buy_amount,";                             //仕入金額
        $sql .= "   t_goods.name_change,";                              //品名変更
        $sql .= "   t_goods.in_num,";
        $sql .= "   t_goods.royalty,";
        $sql .= "   t_goods.stock_manage";
        $sql .= " FROM";
        $sql .= "   t_order_h INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id";
        $sql .= "   LEFT JOIN"; 
        $sql .= "   (SELECT";
        $sql .= "   goods_id,";
        $sql .= "   SUM(stock_num)AS stock_num";
        $sql .= "   FROM";
        $sql .= "        t_stock";
        $sql .= "   WHERE";
        $sql .= "        shop_id = $shop_id";
        $sql .= "        AND";
        $sql .= "        ware_id = $order_h_data[8]";
        $sql .= "   GROUP BY t_stock.goods_id";
        $sql .= "   )AS t_stock";
        $sql .= "   ON t_order_d.goods_id = t_stock.goods_id";
        $sql .= "   LEFT JOIN ";
        $sql .= "   (SELECT ";
        $sql .= "       ord_d_id,";
        $sql .= "       SUM(num) AS buy_num";
        $sql .= "   FROM ";
        $sql .= "       t_buy_d";
        $sql .= "   GROUP BY ord_d_id";
        $sql .= "   )t_buy";
        $sql .= "   ON t_order_d.ord_d_id = t_buy.ord_d_id";
        $sql .= "   INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id";
        $sql .= " WHERE";
        $sql .= "   t_order_h.ord_id = $order_h_data[0]";
        $sql .= "   AND";   
        $sql .= "   t_order_d.rest_flg = 't'";
        $sql .= "   AND";
        $sql .= "   t_order_h.shop_id = $shop_id";
        $sql .= " ORDER BY t_order_d.line";

        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $order_d_num = pg_num_rows($result);

        for($i = 0; $i < $order_d_num; $i++){
            $order_d_data[] = pg_fetch_array($result, $i);
        }

        //発注日時を分割
        $order_date = explode("-",$order_h_data[2]);

        //入荷予定日を分割
        $arrival_date = explode("-", $order_h_data[3]);

        //発注データをフォームにセット
        $set_order_data["hdn_order_id"]                 = $order_h_data[0];                                     //発注ID
        $set_order_data["form_order_no"]                = $order_h_data[0];                                     //発注番号
        $set_order_data["form_order_day"]["y"]          = $order_date[0];                                       //発注日（年）
        $set_order_data["form_order_day"]["m"]          = $order_date[1];                                       //発注日（月）
        $set_order_data["form_order_day"]["d"]          = $order_date[2];                                       //発注日（日）
        $set_order_data["form_arrival_hope_day"]["y"]   = ($arrival_date[0] == null)? "" : $arrival_date[0];    //入荷予定日（年）
        $set_order_data["form_arrival_hope_day"]["m"]   = ($arrival_date[1] == null)? "" : $arrival_date[1];    //入荷予定日（月）
        $set_order_data["form_arrival_hope_day"]["d"]   = ($arrival_date[2] == null)? "" : $arrival_date[2];    //入荷予定日（日）
        $set_order_data["hdn_client_id"]                = $order_h_data[4];                                     //仕入先ID
        $set_order_data["form_client"]["cd"]            = $order_h_data[5];                                     //仕入先CD
        $set_order_data["form_client"]["name"]          = $order_h_data[6];                                     //仕入先名
        $set_order_data["form_direct"]                  = $order_h_data[7];                                     //直送先
        $set_order_data["form_ware"]                    = $order_h_data[8];                                     //倉庫
        $set_order_data["form_trade"]                   = $order_h_data[9];                                     //取引区分
        //$set_order_data["form_buy_staff"]               = $order_h_data[13];                                    //仕入担当者
        $set_order_data["form_buy_staff"]               = $_SESSION[staff_id];                                    //仕入担当者
        $set_order_data["form_order_staff"]             = $order_h_data[10];                                    //発注担当者
        $set_order_data["form_buy_day"]["y"]            = date('Y');                                            //仕入日（年）
        $set_order_data["form_buy_day"]["m"]            = date('m');                                            //仕入日（月）
        $set_order_data["form_buy_day"]["d"]            = date('d');                                            //仕入日（日）
        $set_order_data["form_arrival_day"]["y"]        = date('Y');                                            //入荷日（年）
        $set_order_data["form_arrival_day"]["m"]        = date('m');                                            //入荷日（月）
        $set_order_data["form_arrival_day"]["d"]        = date('d');                                            //入荷日（日）
        $set_order_data["hdn_ord_enter_day"]            = $order_h_data["enter_day"];
        $set_order_data["hdn_ord_change_day"]           = $order_h_data["change_day"];
        $set_order_data["hdn_coax"]                     = $order_h_data["coax"];
        $set_order_data["hdn_tax_franct"]               = $order_h_data["tax_franct"];

        $tax_franct = $order_h_data["tax_franct"];      //端数区分
        $coax       = $order_h_data["coax"];            //金額丸め区分

        $head_flg = $order_h_data[11];                  //本部フラグ

        $client_id = $order_h_data[4];                  //仕入先ID

        for($i = 0; $i < $order_d_num; $i++){

            //課税区分
            $tax_div[]      = $order_d_data[$i][8];

            //仕入金額
            $buy_amount[]   = $order_d_data[$i][9];

            //ロイヤリティ
            $royalty[]      = $order_d_data[$i]["royalty"];


            //仕入単価
            $price = explode('.',$order_d_data[$i][7]);

            //発注残数を算出
            $rorder_num  = $order_d_data[$i][5] - $order_d_data[$i][6];

            $set_order_data["hdn_order_d_id"][$i]       = $order_d_data[$i][0];                             //発注データID
            $set_order_data["hdn_goods_id"][$i]         = $order_d_data[$i][1];                             //商品ID
            $set_order_data["form_goods_cd"][$i]        = $order_d_data[$i][2];                             //商品コード
            $set_order_data["form_goods_name"][$i]      = $order_d_data[$i][3];                             //商品名
            $set_order_data["form_stock_num"][$i]       = ($order_d_data[$i]["stock_manage"] == '1')? $order_d_data[$i][4] : "-";   //在庫数
            $set_order_data["hdn_stock_manage"][$i]     = $order_d_data[$i]["stock_manage"];                //在庫管理 
            $set_order_data["form_order_num"][$i]       = $order_d_data[$i][5];                             //発注数
            $set_order_data["form_rbuy_num"][$i]        = $order_d_data[$i][6];                             //仕入済数
            $set_order_data["form_buy_price"][$i]["i"]  = $price[0];                                        //仕入単価（整数部）
            $set_order_data["form_buy_price"][$i]["d"]  = $price[1];                                        //仕入単価（小数部）
            $set_order_data["hdn_tax_div"][$i]          = $order_d_data[$i][8];                             //課税区分
            //$set_order_data["form_buy_amount"][$i]      = number_format($order_d_data[$i][9]);              //仕入金額（税抜き）
            $buy_amount[$i]                             = number_format(Coax_Col($coax, bcmul($order_d_data[$i][7], $rorder_num,2)));              //仕入金額（税抜き）
            $set_order_data["form_buy_amount"][$i]      = $buy_amount[$i];              //仕入金額（税抜き）
            $set_order_data["hdn_name_change"][$i]      = $order_d_data[$i][10];                            //品名変更
            $set_order_data["form_in_num"][$i]          = $order_d_data[$i][11];                            //入数
            $set_order_data["form_rorder_num"][$i]      = $rorder_num;                                      //発注残
            $set_order_data["form_buy_num"][$i]         = $rorder_num;                                      //仕入数
            $set_order_data["hdn_royalty"][$i]          = $order_d_data[$i]["royalty"];                     //ロイヤリティ
            $name_change[$i]                            = $order_d_data[$i][10];                            //品名変更 

            //ロット入り数
            if($order_d_data[$i][5]%$order_d_data[$i][11] == 0 && $order_d_data[$i][11]!=null){
                $set_order_data["form_order_in_num"][$i]  = $order_d_data[$i][5]/$order_d_data[$i][11];
            }
        }

        //最大行数設定
        $max_row = $order_d_num;

        $client_search_flg  = true;
        $stock_search_flg   = true;

        $freeze_flg         = true;
        $set_order_data["freeze_flg"] = $freeze_flg;

        $order_freeze_flg = true;

        //仕入金額（税抜）、消費税合計、仕入金額（税込）を算出
        $total_amount_data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $conn);

        $set_order_data["form_buy_money"]   = number_format($total_amount_data[0]);
        $set_order_data["form_tax_money"]   = number_format($total_amount_data[1]);
        $set_order_data["form_total_money"] = number_format($total_amount_data[2]);
    }

    $set_order_data["show_button_flg"] = ""; 
    $form->setConstants($set_order_data);

/****************************/
//仕入先コード入力
/****************************/
}elseif($_POST["client_search_flg"] == true){
    $post_client_cd1 = $_POST["form_client"]["cd1"];
    $post_client_cd2 = $_POST["form_client"]["cd2"];

    $sql  = "SELECT";
    $sql .= "   client_id,";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   client_cname,";
    $sql .= "   coax,";
    $sql .= "   tax_franct, ";
    $sql .= "   buy_trade_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$post_client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$post_client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '3'";
    $sql .= "   AND";
    $sql .= "   rank_cd != '0003'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $num = pg_num_rows($result);
    $client_data = pg_fetch_array($result);
    if($num != 0){

        //取得したデータをhiddenセット
        $set_client_data["client_search_flg"]       = "";
        $set_client_data["hdn_client_id"]           = $client_data["client_id"];    //仕入先ID 
        $set_client_data["form_client"]["cd1"]      = $client_data["client_cd1"];   //仕入先CD1
        $set_client_data["form_client"]["cd2"]      = $client_data["client_cd2"];   //仕入先CD2
        $set_client_data["form_client"]["name"]     = $client_data["client_cname"]; //仕入先名
        $set_client_data["hdn_coax"]                = $client_data["coax"];         //丸め区分（商品
        $set_client_data["hdn_tax_franct"]          = $client_data["tax_franct"];   //端数区分（消費税）
        $set_client_data["form_trade"]              = $client_data["buy_trade_id"];   //取引区分

        $client_id  = $client_data["client_id"];                                    //得意先ID
        $coax       = $client_data["coax"];                                         //丸め区分
        $tax_franct = $client_data["tax_franct"];                                   //端数区分

        $client_search_flg = true;

    }else{
        $set_client_data["client_search_flg"]               = "";                   //仕入先検索フラグ
        $set_client_data["hdn_client_id"]                   = "";                   //得意先ID
        $set_client_data["form_client"]["name"]             = "";                   //得意先名
        $set_client_data["head_flg"]                        = "";                   //本部フラグ
        $set_client_data["hdn_coax"]                        = "";                   //丸め区分
        $set_client_data["hdn_tax_franct"]                  = "";                   //端数区分
        $client_search_flg = NULL;
        $client_id = null;
    }

    //全ての値をクリア        
    for($i = 0; $i < $max_row; $i++){
        $set_client_data["hdn_goods_id"][$i]            = "";                       //商品ID
        $set_client_data["form_goods_cd"][$i]           = "";                       //商品コード
        $set_client_data["form_goods_name"][$i]         = "";                       //商品名
        $set_client_data["form_stock_num"][$i]          = "";                       //現在個数
        $set_client_data["form_order_num"][$i]          = "";                       //発注済数
        $set_client_data["form_rorder_num"][$i]         = "";                       //発注残数
        $set_client_data["form_buy_num"][$i]            = "";                       //仕入数
        $set_client_data["form_rbuy_num"][$i]           = "";                       //仕入済数
        $set_client_data["form_buy_price"][$i]["i"]     = "";                       //仕入単価（整数部）
        $set_client_data["form_buy_price"][$i]["d"]     = "";                       //仕入単価（少数部）
        $set_client_data["form_tax_amount"][$i]         = "";                       //消費税額
        $set_client_data["form_buy_amount"][$i]         = "";                       //仕入金額（税抜き）
        $set_client_data["hdn_name_change"][$i]         = "";                       //品名変更（hidden）
        $set_client_data["hdn_stock_manage"][$i]        = "";                       //在庫管理（hidden）
        $set_client_data["hdn_tax_div"][$i]             = "";                       //課税区分（hidden）
        $set_client_data["hdn_royalty"][$i]             = "";                       //ロイヤリティ
        $set_client_data["form_in_num"][$i]             = "";                       //ロット数
        $set_client_data["form_order_in_num"][$i]       = "";                       //ロット仕入数

        $name_change[$i]                                = NULL;
        $goods_id[$i]                                   = NULL;
    }


    $set_client_data["show_button_flg"]     = "";        //表示ボタン
    $set_client_data["form_order_no"]       = "";        //発注番号
    $form->setConstants($set_client_data);

/****************************/
//仕入倉庫入力
/****************************/
}elseif($_POST["stock_search_flg"] == true){
    
    $ware_id = $_POST["form_ware"];
    
    //商品が１つ以上選択されていれば処理開始
    if($ware_id != NULL){

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

                $result         = Db_Query($conn, $sql);
                $stock_data_num = pg_num_rows($result);

                if($stock_data_num != 0){
                    $stock_data = pg_fetch_result($result,0,0);
                }
                $set_stock_data["form_stock_num"][$i] = ($stock_data != NULL)? $stock_data : 0;     //現在個数
            }
        }
        $stock_search_flg = true;
    }else{
        $stock_search_flg = NULL;
    }
    
    $set_stock_data["stock_search_flg"]    = "";
    $set_stock_data["show_button_flg"]     = "";            //表示ボタン
    $set_stock_data["form_order_no"]       = "";            //発注番号
    $form->setConstants($set_stock_data);

/****************************/
//商品コード入力
/****************************/
}elseif($_POST["goods_search_row"] != NULL){

    $search_row = $_POST["goods_search_row"];               //商品検索行
    $goods_cd   = $_POST["form_goods_cd"]["$search_row"];   //商品コード
    $ware_id    = $_POST["form_ware"];                      //倉庫ID

    $sql  = "SELECT ";
    $sql .= "   t_goods.goods_id,";
    $sql .= "   t_goods.name_change,";
    $sql .= "   t_goods.stock_manage,";
    $sql .= "   t_goods.goods_cd,";
    $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //正式名
    //$sql .= "   t_goods.goods_name,";
    $sql .= "   t_goods.tax_div,";
    $sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num,";
    $sql .= "   t_price.r_price,";
    $sql .= "   t_goods.in_num,";
    $sql .= "   t_goods.royalty";
    $sql .= " FROM";
    $sql .= "   t_goods";
    $sql .= "     INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "       INNER JOIN";
    $sql .= "   t_price";
    $sql .= "   ON t_goods.goods_id = t_price.goods_id";
    $sql .= "       LEFT JOIN";
    $sql .= "   (SELECT";
    $sql .= "       goods_id,";
    $sql .= "       SUM(stock_num)AS stock_num";
    $sql .= "    FROM";
    $sql .= "        t_stock";
    $sql .= "    WHERE";
    $sql .= "        shop_id = $shop_id";
    $sql .= "        AND";
    $sql .= "        ware_id = $ware_id";
    $sql .= "    GROUP BY t_stock.goods_id"; 
    $sql .= "   )AS t_stock";
    $sql .= "   ON t_goods.goods_id = t_stock.goods_id";
    $sql .= " WHERE";
    $sql .= "   t_goods.goods_cd = '$goods_cd'";
    $sql .= "   AND";
    $sql .= "   t_goods.accept_flg = '1'";
    $sql .= "   AND";
    $sql .= ($group_kind == 2) ? " t_goods.state IN (1,3)" : " t_goods.state = 1";
    $sql .= "   AND";
    $sql .= "   t_goods.public_flg = 't' ";
    $sql .= "   AND";
    $sql .= "   t_price.rank_cd = '$rank_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $goods_data_num = pg_num_rows($result);
    $goods_data = pg_fetch_array($result);

    if($goods_data_num > 0){

        //仕入金額
        $price = $goods_data["r_price"];
 
        if($_POST["form_buy_num"][$search_row] != null){
            $buy_amount = bcmul($price, $_POST["form_buy_num"][$search_row],2);
            $buy_amount = Coax_Col($coax, $buy_amount);
        }

        //仕入単価を分割
        $price_data = explode(".",$price);

        //品名変更
        $name_change[$search_row]   = $goods_data["name_change"];

        //課税区分
        $tax_div[$search_row]       = $goods_data["tax_div"];

        //ロイヤリティ
        $royalty[$search_row]       = $goods_data["royalty"];

        //商品ID
        $goods_id[$search_row]      = $goods_data["goods_id"];

        //商品データ
        $set_goods_data["hdn_goods_id"][$search_row]         = $goods_data["goods_id"];                         //商品ID
        $set_goods_data["hdn_name_change"][$search_row]      = $goods_data["name_change"];                      //品名変更
        $set_goods_data["hdn_stock_manage"][$search_row]     = $goods_data["stock_manage"];                     //在庫管理
        $set_goods_data["form_goods_cd"][$search_row]        = $goods_data["goods_cd"];                         //商品コード
        $set_goods_data["form_goods_name"][$search_row]      = $goods_data["goods_name"];                       //発注数
        $set_goods_data["form_stock_num"][$search_row]       = ($goods_data["stock_manage"] == '1')? $goods_data["stock_num"] : "-";   //実棚数
        $set_goods_data["form_buy_price"][$search_row]["i"]  = $price_data[0];                                  //仕入単価（整数部）
        $set_goods_data["form_buy_price"][$search_row]["d"]  = ($price_data[1] != NULL)? $price_data[1] : '00'; //仕入単価（小数部）
        $set_goods_data["form_buy_amount"][$search_row]      = number_format($buy_amount);                      //仕入金額（税抜き）
        $set_goods_data["form_order_num"][$search_row]       = "-";
        $set_goods_data["form_rorder_num"][$search_row]      = "-";
        $set_goods_data["form_rbuy_num"][$search_row]        = "-";
        $set_goods_data["hdn_tax_div"][$search_row]          = $goods_data["tax_div"];                          //課税区分
        $set_goods_data["form_in_num"][$search_row]          = $goods_data["in_num"];                           //入数
        $set_goods_data["hdn_royalty"][$search_row]          = $goods_data["royalty"];                          //ロイヤリティ

    //商品コードに不正な値を入力された場合
    }else{
        //商品データ
        $set_goods_data["hdn_goods_id"][$search_row]         = "";              //商品ID
        $set_goods_data["hdn_name_change"][$search_row]      = "";              //品名変更
        $set_goods_data["hdn_stock_manage"][$search_row]     = "";              //在庫管理
        $set_goods_data["form_goods_cd"][$search_row]        = "";              //商品コード
        $set_goods_data["form_goods_name"][$search_row]      = "";              //発注数
        $set_goods_data["form_stock_num"][$search_row]       = "";              //実棚数
        $set_goods_data["form_buy_price"][$search_row]["i"]  = "";              //仕入単価（整数部）
        $set_goods_data["form_buy_price"][$search_row]["d"]  = "";              //仕入単価（小数部）
        $set_goods_data["hdn_tax_div"][$search_row]          = "";              //課税区分
        $set_goods_data["form_order_num"][$search_row]       = "";              //発注数
        $set_goods_data["form_buy_amount"][$search_row]      = "";              //仕入金額（税抜き）
        $set_goods_data["form_order_num"][$search_row]       = "";              //発注数
        $set_goods_data["form_rorder_num"][$search_row]      = "";              //発注残数
        $set_goods_data["form_rbuy_num"][$search_row]        = "";              //仕入済数
        $set_goods_data["form_in_num"][$search_row]          = "";              //入数
        $set_goods_data["form_order_in_num"][$search_row]    = "";              //ロット仕入数
        $set_goods_data["form_buy_num"][$search_row]         = "";              //仕入数
        $set_goods_data["hdn_royalty"][$search_row]          = "";              //ロイヤリティ
        $name_change[$search_row]                            = "";              //品名変更
        $tax_div[$search_row]                                = "";
        $royalty[$search_row]                                = "";
        $goods_id[$search_row]                               = "";
    }

    $set_goods_data["goods_search_row"] = "";
    $form->setConstants($set_goods_data);
}

/****************************/
//合計ボタン押下処理
/****************************/
if($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["form_buy_button"] == "仕入確認画面へ"){

    //削除リストを取得
    $del_row = $_POST["del_row"];
    //削除履歴を配列にする。
    $del_history = explode(",", $del_row);

    $buy_data   = $_POST["form_buy_amount"];    //仕入金額
    $price_data = NULL;                         //商品の仕入金額
    $tax_div    = NULL;                         //課税区分

    //仕入金額の合計値計算
    for($i=0;$i<$max_row;$i++){
        if($buy_data[$i] != "" && !in_array("$i", $del_history)){
            $price_data[] = $buy_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
        }
    }

    $data = Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $conn);

    if($_POST["sum_button_flg"] == true){
        //初期表示位置変更
        $height = $max_row * 30;
        $form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";
    }

    //フォームに値セット
    $money_data["form_buy_money"]   = number_format($data[0]);
    $money_data["form_tax_money"]   = number_format($data[1]);
    $money_data["form_total_money"] = number_format($data[2]);
    $money_data["sum_button_flg"]   = "";   
    $form->setConstants($money_data);
}

/*****************************/
//買掛残高を抽出
/*****************************/
if($client_search_flg == true){
    //締日を抽出
    $sql  = "SELECT\n";
    $sql .= "   close_day\n";
    $sql .= " FROM\n";
    $sql .= "   t_client\n";
    $sql .= " WHERE\n";
    $sql .= "   t_client.client_id = $client_id\n";
    $sql .= ";";

    $result = Db_Query($conn,$sql);
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
    $sql .= "        t_buy_h.client_id = $client_id\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.trade_id IN ('21', '25')\n";
    $sql .= "        AND\n";
//    $sql .= "        t_buy_h.buy_day > '2006-05-31'\n";
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
    $sql .= "        t_buy_h.buy_day < '$last_close_day'\n";
    $sql .= "    GROUP BY client_id\n";
    $sql .= "    ) AS t_plus\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    (SELECT\n";
    $sql .= "        client_id,\n";
    $sql .= "        SUM(t_buy_h.net_amount)AS net_amount\n";
    $sql .= "    FROM\n";
    $sql .= "        t_buy_h\n";
    $sql .= "    WHERE\n";
    $sql .= "        t_buy_h.client_id = $client_id\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.trade_id IN ('23','24')\n";
    $sql .= "        AND\n";
    $sql .= "       t_buy_h.buy_day > (SELECT\n";
    $sql .= "                           COALESCE(MAX(payment_close_day), '".START_DAY."')\n";
    $sql .= "                       FROM\n";
    $sql .= "                           t_schedule_payment\n";
    $sql .= "                       WHERE\n";
    $sql .= "                           shop_id = $shop_id\n";
    $sql .= "                           AND\n";
    $sql .= "                           client_id = $client_id\n";
    $sql .= "                       )\n";

//    $sql .= "        t_buy_h.buy_day > '2006-05-31'\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.buy_day < '$last_close_day'\n";
    $sql .= "    GROUP BY client_id\n";
    $sql .= "    ) AS t_minus\n";
    $sql .= "    ON t_plus.client_id = t_minus.client_id\n";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    $ap_balance = number_format(@pg_fetch_result($result,0,0));
}

//***************************/
//最大行数をhiddenにセット
/****************************/
$max_row_data["max_row"] = $max_row;

$form->setConstants($max_row_data);

/****************************/
//出力メッセージ作成
/****************************/
if($client_search_flg == true && $stock_search_flg == true){
    if($head_flg == 't'){
        $message = "本部商品のみ選択可能です。";
    }else{
        $message = "本部商品以外が選択可能です。";
    }
}else{
    $warning = "仕入先と仕入倉庫を選択してください。";
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

/*
//発注残
$select_value[null] = null;
$sql  = "SELECT";
$sql .= "    t_order_h.ord_id,";
$sql .= "    t_order_h.ord_no";
$sql .= " FROM";
$sql .= "    t_order_h";
$sql .= "        INNER JOIN";
$sql .= "    (SELECT";
$sql .= "        ord_id";
$sql .= "     FROM";
$sql .= "        t_order_d";
$sql .= "    WHERE";
$sql .= "        rest_flg = 't'";
$sql .= "    GROUP BY ord_id) AS t_order_d";
$sql .= "    ON t_order_h.ord_id = t_order_d.ord_id";
$sql .= " WHERE";
//$sql .= "    t_order_h.shop_id = 93";
$sql .= "    t_order_h.shop_id = $_SESSION[client_id]";
$sql .= "    AND";
$sql .= "    (t_order_h.ord_stat <> 3";
$sql .= "    OR";
$sql .= "    t_order_h.ord_stat IS NULL)";
$sql .= "    AND";
$sql .= "    t_order_h.ps_stat IN ('1','2')";
$sql .= " ORDER BY t_order_h.ord_no";
$sql .= ";";

$result = Db_Query($conn, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $ord_id = pg_fetch_result($result,$i,0);
    $ord_no = pg_fetch_result($result,$i,1);
    $select_value[$ord_id] = $ord_no;
}

//発注番号
if($buy_get_flg == true){
    $form->addElement(
        "text","form_order_no","",
        "size=\"11\" maxLength=\"8\" 
        style=\"color : #525552; 
        border : #ffffff 1px solid; 
        background-color: #ffffff; 
        text-align: left\" readonly'"
    );
}else{
//   $order_freeze[] = $form->addElement("select","form_order_no","",$select_value, $g_form_option_select);
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
$order_freeze[] = $form->addGroup( $form_order_day,"form_order_day","");

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
*/
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
$freeze_form = $form_client[] = $form->createElement(
    "text","cd1","",
    "size=\"7\" maxLength=\"6\" 
    style=\"$g_form_style\"
    onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\"
    onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\" 
    $g_form_option"
);

//仕入先コード入力不可
if($freeze_flg == true || $buy_get_flg == true){
    $freeze_form->freeze();
}
$freeze_form = $form_client[] = $form->createElement(
    "static" ,"-","-","-"
);
$freeze_form = $form_client[] = $form->createElement(
    "text","cd2","",
    "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\"
    onChange=\"javascript:Button_Submit('client_search_flg','#','true')\" 
    $g_form_option"
);

//仕入先コード入力不可
if($freeze_flg == true || $buy_get_flg == true){
    $freeze_form->freeze();
}
$form_client[] = $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly"
);
$form->addGroup($form_client, "form_client", "");

//直送先
$select_value = Select_Get($conn,'direct');
$order_freeze[] = $form->addElement('select', 'form_direct', "", $select_value,"class=\"Tohaba\"".$g_form_option_select);

//仕入倉庫
/*
$where  = " WHERE";
$where .= ($group_kind == "2")?  " own_shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
$where .= "  AND";
$where .= "  nondisp_flg = 'f'";
*/
//$select_value = Select_Get($conn,'ware', $where);
$select_value = Select_Get($conn,'ware',"WHERE shop_id = $_SESSION[client_id] AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
$order_freeze[] = $form->addElement('select', 'form_ware', '', $select_value,"onChange=\"javascript:Button_Submit('stock_search_flg','#','true')\"");

//取引区分
$select_value = null;
if($get_order_id != null){
    $select_value = Select_Get($conn,'trade_buy_ord');
}else{
    $select_value = Select_Get($conn,'trade_buy');
}
$trade = $form->addElement('select', 'form_trade', null, null,$g_form_option_select);

//返品、値引きの色を変更
$select_value_key = array_keys($select_value);
for($i = 0; $i < count($select_value); $i++){
    if($select_value_key[$i] == 23 || $select_value_key[$i] == 24 || $select_value_key[$i] == 73 || $select_value_key[$i] == 74){ 
         $color= "style=color:red";
    }else{  
          $color="";
    }
    $trade->addOption($select_value[$select_value_key[$i]], $select_value_key[$i],$color);
}
$order_freeze[] = $trade;

/*
//発注担当者
//$select_value = Select_Get($conn,'staff',null,true);
$freeze =  $form->addElement('select', 'form_order_staff', '', $select_value,$g_form_option_select);
$freeze->freeze();
*/

//仕入担当者
$select_value = Select_Get($conn,'staff',null,true);
//$order_freeze[] = $form->addElement('select', 'form_buy_staff', '', $select_value,$g_form_option_select);
//$select_value = Select_Get($conn,'staff');
$form->addElement('select', 'form_buy_staff', '', $select_value,$g_form_option_select);

//備考
$form->addElement("text","form_note","","size=\"20\" maxLength=\"20\" $g_form_option");

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

//入力・変更
$form->addElement("button","new_button","入　力",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//照会
$form->addElement("button","change_button","照会・変更","onClick=\"javascript:Referer('2-3-202.php')\"");
//合計
$form->addElement("button","form_sum_button","合　計","onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true')\"");

if($buy_get_flg != true){
    //仕入先対象
    $form->addElement("button","form_client_button","仕入先","onClick=\"javascript:location.href='./2-3-201.php'\"");
    //FC 対象
    $form->addElement("button","form_fc_button","Ｆ　Ｃ","$g_button_color onClick=\"javascript:location.href='./2-3-207.php';\"");
}

//hidden
$form->addElement("hidden", "del_row");             //削除行
$form->addElement("hidden", "add_row_flg");         //追加行フラグ
$form->addElement("hidden", "max_row");             //最大行数
$form->addElement("hidden", "show_button_flg");     //最大行数
$form->addElement("hidden", "client_search_flg");   //仕入先検索フラグ
$form->addElement("hidden", "hdn_coax");            //丸め区分
$form->addElement("hidden", "hdn_tax_franct");      //端数区分
$form->addElement("hidden", "goods_search_row");    //商品コード入力行
$form->addElement("hidden", "hdn_client_id");       //仕入先ID
$form->addElement("hidden", "stock_search_flg");    //現在個数検索フラグ
$form->addElement("hidden", "head_flg");            //本部フラグ
$form->addElement("hidden", "hdn_order_id");        //発注ID
$form->addElement("hidden", "hdn_buy_id");          //仕入ID
$form->addElement("hidden", "sum_button_flg");      //合計ボタン押下フラグ
$form->addElement("hidden", "freeze_flg");          //入力項目フリーズフラグ
$form->addElement("hidden", "order_freeze_flg");    //発注番号フリーズフラグ
$form->addElement("hidden", "hdn_ord_enter_day");   //発注登録日
$form->addElement("hidden", "hdn_buy_enter_day");   //仕入登録日
$form->addElement("hidden", "hdn_ord_change_day");  //発注変更日
$form->addElement("hidden", "first_set_flg","1");   //初期表示フラグ

/****************************/
//仕入ボタン押下処理
/****************************/
if($_POST["form_buy_button"] == "仕入確認画面へ" || $_POST["comp_button"] == "仕入完了"){

    /******************************/
    //POST取得
    /******************************/
    $client_id                  = $_POST["hdn_client_id"];                      //得意先ID
    $client_cd1                 = $_POST["form_client"]["cd1"];                 //得意先CD1
    $client_cd2                 = $_POST["form_client"]["cd2"];                 //得意先CD2
    $buy_no                     = $_POST["form_buy_no"];                        //仕入番号
    $order_id                   = ($_POST["hdn_order_id"] != NULL)? $_POST["hdn_order_id"] : NULL;    //発注ID
    $order_no                   = $_POST["form_order_no"];                      //発注番号
    $order_date                 = $_POST["form_order_day"]["y"];                //発注日（年）
    $order_date                 = $_POST["form_order_day"]["m"];                //発注日（月）
    $order_date                 = $_POST["form_order_day"]["d"];                //発注日（日）
    $arrival_date["y"]          = $_POST["form_arrival_day"]["y"];              //入荷日（年）
    $arrival_date["m"]          = $_POST["form_arrival_day"]["m"];              //入荷日（月）
    $arrival_date["d"]          = $_POST["form_arrival_day"]["d"];              //入荷日（日）
    $buy_date["y"]              = $_POST["form_buy_day"]["y"];                  //仕入日（年）
    $buy_date["m"]              = $_POST["form_buy_day"]["m"];                  //仕入日（月）
    $buy_date["d"]              = $_POST["form_buy_day"]["d"];                  //仕入日（日）
    $direct                     = ($_POST["form_direct"] != NULL)? $_POST["form_direct"] : NULL;  //直送先
    $ware                       = $_POST["form_ware"];                          //仕入倉庫
    $trade                      = $_POST["form_trade"];                         //取引区分
    $buy_staff                  = $_POST["form_buy_staff"];                     //仕入担当者
    $order_staff                = $_POST["form_order_staff"];                   //仕入担当者
    $note                       = $_POST["form_note"];                          //備考

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

    $result = Db_Query($conn, $sql);
    $client_num = pg_fetch_result($result, 0, 0);

    //登録前に仕入先を変更した場合はエラー
    if($client_num != 1){
        $form->setElementError("form_client", "仕入先情報取得前に 発注確認画面へボタン <br>が押されました。操作をやり直してください。");
    }elseif($client_cd1 != null && $client_cd2 != null){
        //データチェックに渡す引数生成
        $check_ary = array($conn, $order_id, $_POST["hdn_ord_enter_day"], $get_buy_id);
        //データチェック
        $check_data = Row_Data_Check(
                                $_POST["hdn_goods_id"],     //商品ID
                                $_POST["form_goods_cd"],    //商品コード
                                $_POST["form_goods_name"],  //商品名
                                $_POST["form_buy_num"],     //仕入数
                                $_POST["form_buy_price"],   //仕入単価
                                $_POST["form_buy_amount"],  //仕入金額
                                $_POST["hdn_tax_div"],      //課税区分
                                $del_history,               //削除履歴
                                $max_row,                   //最大行数
                                "buy",                      //区分
                                $conn,                      //リソース
                                $_POST["form_order_num"],   //発注数
                                $_POST["hdn_royalty"],      //ロイヤリティ
                                $_POST["hdn_order_d_id"],   //発注データID
                                $check_ary
                                );
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

            $err_flg = true;
        //エラーがなかった場合
        }else{  
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
        }
        //ロイヤリティ計算
        $royalty_data = Total_Royalty($buy_amount, $royalty, $royalty_rate, $coax);
    }
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

    /******************************/
    //ルール作成
    /******************************/

    //入荷日
    //●日付妥当性チェック
    if(!checkdate((int)$arrival_date["m"], (int)$arrival_date["d"], (int)$arrival_date["y"])){
        $form->setElementError("form_arrival_day", "入荷日の日付は妥当ではありません。");
    }else{
        //月次更新
        if(Check_Monthly_Renew($conn, $client_id, '2', $arrival_date["y"], $arrival_date["m"], $arrival_date["d"]) === false){
             $form->setElementError("form_arrival_day", "入荷日に月次更新日以前の日付は登録できません。");
        }
        //システム開始日チェック
        $arrival_day_err   = Sys_Start_Date_Chk($arrival_date["y"], $arrival_date["m"], $arrival_date["d"], "入荷日");
        if($arrival_day_err != Null){
            $form->setElementError("form_arrival_day", $arrival_day_err);
        }       
    }

    //仕入日
    //●日付妥当性チェック
    if(!checkdate((int)$buy_date["m"], (int)$buy_date["d"], (int)$buy_date["y"])){
        $form->setElementError("form_buy_day", "仕入日の日付は妥当ではありません。");
    }else{
          //月次更新
        if(Check_Monthly_Renew($conn, $client_id, '2', $buy_date["y"], $buy_date["m"], $buy_date["d"]) === false){
             $form->setElementError("form_buy_day", "仕入日に月次更新日以前の日付は登録できません。");
        }

        //支払締日チェック
        if(Check_Payment_Close_Day($conn, $client_id, $buy_date["y"], $buy_date["m"], $buy_date["d"]) === false){
             $form->setElementError("form_buy_day", "仕入日に支払締日以前の日付は登録できません。");
        }

        //システム開始日チェック
        $buy_day_err   = Sys_Start_Date_Chk($buy_date["y"], $buy_date["m"], $buy_date["d"], "仕入日");
        if($buy_day_err != Null){
            $form->setElementError("form_buy_day", $buy_day_err);
        }       
    }

/*
    for($i = 0; $i < count($goods_id); $i++){
        //商品チェック
        //商品重複チェック
        for($j = 0; $j < count($goods_id); $j++){
            if($goods_id[$i] != null && $goods_id[$j] != null && $i != $j && $goods_id[$i] == $goods_id[$j]){
                //$form->setElementError("form_buy_no", "同じ商品が２度選択されています。");
                $goods_twice = "同じ商品が２度選択されています。";
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
        if($_POST["comp_button"] == "仕入完了"){

            $total_amount_data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $conn);

            Db_Query($conn, "BEGIN");

            //仕入先IDがある場合
            if($buy_get_flg == true){

                //仕入が削除されていないか確認
                $update_check_flg = Update_Check($conn, "t_buy_h", "buy_id", $get_buy_id, $_POST["hdn_buy_enter_day"]);

                //既に削除されていた場合
                if($update_check_flg === false){
                    header("Location:./2-3-205.php?buy_id=$get_buy_id&input_flg=true&del_buy_flg=true");
                    exit;
                }

                if($order_id != null){
                    //発注が変更されていないか確認
                    $update_data_check_flg = Update_Data_Check($conn, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_change_day"]);
                    if($update_data_check_flg === false){
                        header("Location:./2-3-205.php?buy_id=0&input_flg=true&change_ord_flg=true");
                        exit;
                    } 
                }

                //支払データを一回消す
                $sql  = "DELETE FROM t_payout_h WHERE buy_id = $get_buy_id;";

                $result = Db_Query($conn, $sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }

                //「仕入ヘッダテーブル」「仕入データテーブル」を結合し下記の情報を抽出
                $sql  = "SELECT";
                $sql .= "   t_buy_h.ware_id,";
                $sql .= "   t_buy_d.goods_id,";
                $sql .= "   SUM(t_buy_d.num)";
                $sql .= " FROM";
                $sql .= "   t_buy_h INNER JOIN t_buy_d ON t_buy_h.buy_id = t_buy_d.buy_id";
                $sql .= " WHERE";
                $sql .= "   t_buy_h.buy_id = $get_buy_id";
                $sql .= " GROUP BY t_buy_h.ware_id, t_buy_d.goods_id, t_buy_d.line";
                $sql .= " ORDER BY t_buy_d.line";
                $sql .= ";";

                $result = Db_Query($conn, $sql);
                $count = pg_num_rows($result);

                for($i = 0; $i < $count; $i++){
                    $before_data = pg_fetch_array($result,$i,PGSQL_NUM);     
                }
     
                //「仕入ヘッダテーブル」の下記の情報を更新
                $insert_sql  = "UPDATE";
                $insert_sql .= "    t_buy_h";
                $insert_sql .= " SET";
                $insert_sql .= "    buy_no              = '$buy_no',";
                $insert_sql .= "    buy_day             = '".$buy_date["y"]."-".$buy_date["m"]."-".$buy_date["d"]."',";
                $insert_sql .= "    arrival_day         = '".$arrival_date["y"]."-".$arrival_date["m"]."-".$arrival_date["d"]."',";
                $insert_sql .= "    client_id           = $client_id,";
                $insert_sql .= ($direct != null) ? " direct_id = $direct," : " direct_id = NULL, ";
                $insert_sql .= "    trade_id            = '$trade',";
                $insert_sql .= "    note                = '$note',";
                $insert_sql .= "    c_staff_id          = $buy_staff,";
                $insert_sql .= ($order_staff != null) ? " oc_staff_id = $order_staff," : " oc_staff_id = null,";
                $insert_sql .= "    ware_id             = $ware,";
                $insert_sql .= "    e_staff_id          = $staff_id,";
                $insert_sql .= "    net_amount          = $total_amount_data[0],";
                $insert_sql .= "    tax_amount          = $total_amount_data[1],";
                $insert_sql .= ($trade == 25) ? " total_split_num = 2," : " total_split_num = 1,";
                $insert_sql .= "    client_cd1          = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_cd2          = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_name         = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_name2        = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= ($direct != null) ? " direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct), " : " direct_name = NULL, ";
                $insert_sql .= ($direct != null) ? " direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), " : " direct_name2 = NULL, ";
                $insert_sql .= "    c_staff_name        = (SELECT staff_name FROM t_staff WHERE staff_id = $buy_staff), ";
                $insert_sql .= "    e_staff_name        = (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), ";
                $insert_sql .= ($order_staff != null) ? " oc_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $order_staff), " : "oc_staff_name = NULL,";
                $insert_sql .= "    ware_name           = (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";
                $insert_sql .= "    royalty_amount      = $royalty_data,";
                $insert_sql .= "    client_cname        = (SELECT client_cname FROM t_client WHERE client_id = $client_id),";
                $insert_sql .= "    change_day          = CURRENT_TIMESTAMP ";
                $insert_sql .= " WHERE";
                $insert_sql .= "    buy_id              = $get_buy_id";
                $insert_sql .= ";";

                $result = Db_Query($conn, $insert_sql);

                //失敗した場合はロールバック
                if($result === false){ 
                    Db_Query($conn, "ROLLBACK");
                    exit;   
                }

                //「仕入データテーブル」からGETで取得した仕入IDとマッチするデータを削除
                $insert_sql  = "DELETE FROM";
                $insert_sql .= "    t_buy_d";
                $insert_sql .= " WHERE";
                $insert_sql .= "    buy_id = $get_buy_id";
                $insert_sql .= ";";
                
                $result = Db_Query($conn, $insert_sql);
                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($conn, "ROLLBACK");
                    exit;
                }

                //分割支払いテーブルを削除
                $insert_sql  = "DELETE FROM";
                $insert_sql .= "    t_amortization";
                $insert_sql .= " WHERE";
                $insert_sql .= "    buy_id = $get_buy_id";
                $insert_sql .= ";";

                $result = Db_Query($conn, $insert_sql);
                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }

                //発注から起こしている場合には一度強制完了していない発注に対して発注残フラグをtrueにする
                if($order_id != NULL){
                    $sql  = "UPDATE";
                    $sql .= "   t_order_d \n";
                    $sql .= "SET\n";
                    $sql .= "   rest_flg = 't' \n";
                    $sql .= "WHERE\n";
                    $sql .= "   ord_id = $order_id\n";
                    $sql .= "   AND\n";
                    $sql .= "   finish_flg = 'f'\n";
                    $sql .= ";";

                    $result = Db_Query($conn, $sql);
                    if($result === false){
                        Db_Query($conn, "ROLLBACK;");
                        exit;
                    }
                }       

            //仕入先IDがない場合
            }else{
                if($order_id != null){
                    //発注が削除されていないかを確認
                    $update_check_flg = Update_Check($conn, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_enter_day"]);
                    //既に削除されていた場合
                    if($update_check_flg === false){
                        header("Location:./2-3-205.php?buy_id=0&input_flg=true&del_ord_flg=true");
                        exit;
                    }

                    //発注が変更されていないか確認
                    $update_data_check_flg = Update_Data_Check($conn, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_change_day"]);
                    if($update_data_check_flg === false){
                        header("Location:./2-3-205.php?buy_id=0&input_flg=true&change_ord_flg=true");
                        exit;
                    }
                }

                $insert_sql  = "INSERT INTO t_buy_h (\n";
                $insert_sql .= "    buy_id,\n";                                                                 //仕入先ID
                $insert_sql .= "    buy_no,\n";                                                                 //仕入番号
                if($order_id != null){
                    $insert_sql .= "    ord_id,\n";                                                             //発注ID
                }
                $insert_sql .= "    buy_day,\n";                                                                //仕入日
                $insert_sql .= "    arrival_day,\n";                                                            //入荷日
                $insert_sql .= "    client_id,\n";                                                              //得意先ID
                if($direct != null){
                    $insert_sql .= "    direct_id,\n";                                                          //直送先ID
                }
                $insert_sql .= "    trade_id,\n";                                                               //取引先CD
                $insert_sql .= "    note,\n";                                                                   //備考
                $insert_sql .= "    c_staff_id,\n";                                                             //仕入担当者ID
                $insert_sql .= "    ware_id,\n";                                                                //倉庫ID
                $insert_sql .= "    e_staff_id,\n";                                                             //入力者ID
                $insert_sql .= "    shop_id,\n";                                                                //ショップID
                $insert_sql .= "    net_amount,\n";                                                             //仕入金額
                $insert_sql .= "    tax_amount,\n";                                                             //消費税金額
                $insert_sql .= ($order_staff != null) ? " oc_staff_id,\n" : null;                               //発注担当者
                $insert_sql .= "    total_split_num,\n";                                                        //分割回数
                $insert_sql .= "    client_cd1, \n";                                                            //得意先コード１
                $insert_sql .= "    client_cd2, \n";                                                            //得意先コード２
                $insert_sql .= "    client_name, \n";                                                           //得意先名１
                $insert_sql .= "    client_name2, \n";                                                          //得意先名２
                $insert_sql .= ($direct != null) ? " direct_name, \n" : null;                                   //直送先名
                $insert_sql .= ($direct != null) ? " direct_name2, \n" : null;                                  //直送先名２
                $insert_sql .= "    c_staff_name, \n";                                                          //仕入担当者
                $insert_sql .= "    e_staff_name, \n";                                                          //入力者
                $insert_sql .= ($order_staff != null) ? " oc_staff_name, \n" : null;                            //発注担当者名
                $insert_sql .= "    ware_name ,\n";                                                             //倉庫名
                $insert_sql .= "    royalty_amount,\n";                                                         //ロイヤリティ合計
                $insert_sql .= "    client_cname,\n";                                                           //得意先略称
                $insert_sql .= "    buy_div \n";                                                                //仕入先区分（FC、仕入先）
                $insert_sql .= ")VALUES(\n";
                $insert_sql .= "    (SELECT COALESCE(MAX(buy_id), 0)+1 FROM t_buy_h),\n";                       //仕入先ID
                $insert_sql .= "    '$buy_no',\n";                                                              //仕入番号
                if($order_id != null){
                    $insert_sql .= "    $order_id,\n";                                                          //発注ID
                }
                $insert_sql .= "    '".$buy_date["y"]."-".$buy_date["m"]."-".$buy_date["d"]."',\n";             //仕入日
                $insert_sql .= "    '".$arrival_date["y"]."-".$arrival_date["m"]."-".$arrival_date["d"]."',\n"; //入荷予定日
                $insert_sql .= "    $client_id,\n";                                                             //得意先ID
                if($direct != null){
                    $insert_sql .= "    $direct,\n";                                                            //直送先ID
                }
                $insert_sql .= "    '$trade',\n";                                                               //取引区分
                $insert_sql .= "    '$note',\n";                                                                //備考
                $insert_sql .= "    $buy_staff,\n";                                                             //仕入担当者ID
                $insert_sql .= "    $ware,\n";                                                                  //倉庫ID
                $insert_sql .= "    $staff_id,\n";                                                              //入力者ID
                $insert_sql .= "    $shop_id,\n";                                                               //ショップID
                $insert_sql .= "    $total_amount_data[0],\n";                                                  //仕入金額
                $insert_sql .= "    $total_amount_data[1],\n";                                                  //消費税額
                $insert_sql .= ($order_staff != Null) ? " $order_staff,\n" : null;                              //発注担当者
                $insert_sql .= ($trade == 25) ? "    2,\n" : "    1,\n";                                        //割賦回数
                $insert_sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id),\n ";        //得意先コード１
                $insert_sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id),\n ";        //得意先コード２
                $insert_sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id),\n ";       //得意先名
                $insert_sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id),\n ";      //得意先名２
                $insert_sql .= ($direct != null) ? " (SELECT direct_name FROM t_direct WHERE direct_id = $direct), \n" : null;  //直送先名１
                $insert_sql .= ($direct != null) ? " (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), \n" : null; //直送先名２
                $insert_sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $buy_staff), \n";          //仕入担当者
                $insert_sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), \n";           //入力者
                $insert_sql .= ($order_staff != Null) ? " (SELECT staff_name FROM t_staff WHERE staff_id = $order_staff), \n" : null; //発注担当者
                $insert_sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";                    //倉庫名
                $insert_sql .= "    $royalty_data,\n";                                                          //ロイヤリティ合計
                $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id),\n";       //略称
                $insert_sql .= "    '2'\n";                                                                     //仕入先区分(FC,仕入先)
                $insert_sql .= ");\n";

                $result = Db_Query($conn, $insert_sql);

                //失敗した場合はロールバック
                if($result === false){ 
                    $err_message = pg_last_error();
                    $err_format = "t_buy_h_buy_no_key";

                    Db_Query($conn, "ROLLBACK");

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

                        $result = Db_Query($conn, $sql);
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

                $result = Db_Query($conn, $sql);
                $buy_id = pg_fetch_result($result,0,0);

                //割賦支払テーブルに登録
                if($trade == "25"){
                    $division_array = Division_Price($conn, $client_id, ($total_amount_data[0] + $total_amount_data[1]), $buy_date["y"], $buy_date["m"], 2);

                    for($k=0;$k<2;$k++){
                        $sql  = "INSERT INTO t_amortization (";
                        $sql .= "   amortization_id,";
                        $sql .= "   buy_id,";
                        $sql .= "   pay_day,";
                        $sql .= "   split_pay_amount ";
                        $sql .= ") VALUES (";
                        $sql .= "   (SELECT COALESCE(MAX(amortization_id),0)+1 FROM t_amortization),";
                        $sql .= "   $buy_id,";
                        $sql .= "   '".$division_array[1][$k]."', ";
                        $sql .= "   ".$division_array[0][$k]." ";
                        $sql .= ");";

                        $result = Db_Query($conn, $sql);
                        if($resutlt === false){
                            Db_Query($conn, "ROLLBACK");
                            exit;
                        }
                    }
                }

                //入力された商品の数繰り返す
                for($i = 0; $i < count($goods_id); $i++){

                    //行
                    $line = $i + 1;

                    //仕入金額税抜き、消費税額、消費税合計を算出
                    $price = $buy_price[$i]["i"].".".$buy_price[$i]["d"];

                    //仕入金額
                    $buy_amount = bcmul($price, $buy_num[$i],3);

                    $buy_amount = Coax_Col($coax, $buy_amount);

                    //仕入データテーブル
                    $insert_sql  = "INSERT INTO t_buy_d (";
                    $insert_sql .= "    buy_d_id,";
                    $insert_sql .= "    buy_id,";
                    $insert_sql .= "    line,";
                    $insert_sql .= "    goods_id,";
                    $insert_sql .= "    goods_name,";
                    $insert_sql .= "    num,";
                    $insert_sql .= "    tax_div,";
                    $insert_sql .= "    buy_price,";
                    $insert_sql .= "    buy_amount,";
                    $insert_sql .= "    ord_d_id, ";
                    $insert_sql .= "    goods_cd, ";
                    $insert_sql .= "    in_num,";
                    $insert_sql .= "    royalty ";
                    $insert_sql .= ")VALUES(";
                    $insert_sql .= "    (SELECT COALESCE(MAX(buy_d_id), 0)+1 FROM t_buy_d),";
                    $insert_sql .= "    $buy_id,";
                    $insert_sql .= "    $line,";
                    $insert_sql .= "    $goods_id[$i],";
                    $insert_sql .= "    '$goods_name[$i]',";
                    $insert_sql .= "    $buy_num[$i],";
                    $insert_sql .= "    $tax_div[$i],";
                    $insert_sql .= "    $price,";
                    $insert_sql .= "    $buy_amount,";
                    $insert_sql .= "    $order_d_id[$i],";
                    $insert_sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_id[$i]), ";
                    $insert_sql .= "    (SELECT in_num FROM t_goods WHERE goods_id = $goods_id[$i]), ";
                    $insert_sql .= "    '$royalty[$i]'\n";
                    $insert_sql .= ");";

                    $result = Db_Query($conn, $insert_sql);
                    //失敗した場合はロールバック
                    if($result === false){
                        Db_Query($conn, "ROLLBACK");
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

                    $result = Db_Query($conn, $sql);
                    $buy_d_id = pg_fetch_result($result,0,0);

                    //在庫数テーブル
                    //１　発注ID<>NULLの場合
                    if($order_id != NULL){

                        //在庫受け払いテーブル
                        //発注残削除
                        $insert_sql  = "INSERT INTO t_stock_hand (";
                        $insert_sql .= "    goods_id,";
                        $insert_sql .= "    enter_day,";
                        $insert_sql .= "    work_day,";
                        $insert_sql .= "    work_div,";
                        $insert_sql .= "    client_id,";
                        $insert_sql .= "    ware_id,";
                        $insert_sql .= "    io_div,";
                        $insert_sql .= "    num,";
                        $insert_sql .= "    slip_no,";
                        $insert_sql .= "    buy_d_id,";
                        $insert_sql .= "    staff_id,";
                        $insert_sql .= "    shop_id,";
                        $insert_sql .= "    client_cname";
                        $insert_sql .= ")VALUES(";
                        $insert_sql .= "    $goods_id[$i],";
                        $insert_sql .= "    NOW(),";
                        $insert_sql .= "    '".$arrival_date["y"]."-".$arrival_date["m"]."-".$arrival_date["d"]."',";
                        $insert_sql .= "    '3',";
                        $insert_sql .= "    $client_id,";
                        $insert_sql .= "    $ware,";
                        $insert_sql .= "    '2',";
                        $insert_sql .= "    $buy_num[$i],";
                        $insert_sql .= "    '$buy_no',";
                        $insert_sql .= "    $buy_d_id,";
                        $insert_sql .= "    $staff_id,";
                        $insert_sql .= "    $shop_id,";
                        $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $insert_sql .= ");";

                        $result = Db_Query($conn, $insert_sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($conn,"ROLLBACK");
                            exit;
                        } 

                        //仕入発生
                        $insert_sql  = "INSERT INTO t_stock_hand (";
                        $insert_sql .= "    goods_id,";
                        $insert_sql .= "    enter_day,";
                        $insert_sql .= "    work_day,";
                        $insert_sql .= "    work_div,";
                        $insert_sql .= "    client_id,";
                        $insert_sql .= "    ware_id,";
                        $insert_sql .= "    io_div,";
                        $insert_sql .= "    num,";
                        $insert_sql .= "    slip_no,";
                        $insert_sql .= "    buy_d_id,";
                        $insert_sql .= "    staff_id,";
                        $insert_sql .= "    shop_id,";
                        $insert_sql .= "    client_cname";
                        $insert_sql .= ")VALUES(";
                        $insert_sql .= "    $goods_id[$i],";
                        $insert_sql .= "    NOW(),";
                        $insert_sql .= "    '".$arrival_date["y"]."-".$arrival_date["m"]."-".$arrival_date["d"]."',";
                        $insert_sql .= "    '4',";
                        $insert_sql .= "    $client_id,";
                        $insert_sql .= "    $ware,";
                        $insert_sql .= "    '1',";
                        $insert_sql .= "    $buy_num[$i],";
                        $insert_sql .= "    '$buy_no',";
                        $insert_sql .= "    $buy_d_id,";
                        $insert_sql .= "    $staff_id,";
                        $insert_sql .= "    $shop_id,";
                        $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $insert_sql .= ");";

                        $result = Db_Query($conn, $insert_sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($conn, "ROLLBACK");
                            exit;
                        }

                    //２　発注ID＝NULL　AND　取引区分＝２１（掛仕入）・７１（現金仕入）の場合
                    }elseif($order_id == NULL && ($trade == '21' || $trade == '71' || $trade == '25')){
            
                        //在庫受け払いテーブル（仕入発生）
                        $insert_sql  = "INSERT INTO t_stock_hand (";
                        $insert_sql .= "    goods_id,";
                        $insert_sql .= "    enter_day,";
                        $insert_sql .= "    work_day,";
                        $insert_sql .= "    work_div,";
                        $insert_sql .= "    client_id,";
                        $insert_sql .= "    ware_id,";
                        $insert_sql .= "    io_div,";
                        $insert_sql .= "    num,";
                        $insert_sql .= "    slip_no,";
                        $insert_sql .= "    buy_d_id,";
                        $insert_sql .= "    staff_id,";
                        $insert_sql .= "    shop_id,";
                        $insert_sql .= "    client_cname";
                        $insert_sql .= " )VALUES(";
                        $insert_sql .= "    $goods_id[$i],";
                        $insert_sql .= "    NOW(),";
                        $insert_sql .= "    '".$arrival_date["y"]."-".$arrival_date["m"]."-".$arrival_date["d"]."',";
                        $insert_sql .= "    '4',";
                        $insert_sql .= "    $client_id,";
                        $insert_sql .= "    $ware,";
                        $insert_sql .= "    '1',";
                        $insert_sql .= "    $buy_num[$i],";
                        $insert_sql .= "    '$buy_no',";
                        $insert_sql .= "    $buy_d_id,";
                        $insert_sql .= "    $staff_id,";
                        $insert_sql .= "    $shop_id,";
                        $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $insert_sql .= ");";

                        $result = Db_Query($conn, $insert_sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($conn, "ROLLBACK");
                            exit;
                        }

                    //３　発注ID＝NULL　AND　取引区分＝２２（掛返品）・７２（現金返品）の場合
                    }elseif($order_id == NULL && ($trade == '23' || $trade == '73')){

                        //在庫受け払い（仕入発生）
                        $insert_sql  = "INSERT INTO t_stock_hand (\n";
                        $insert_sql .= "    goods_id,\n";
                        $insert_sql .= "    enter_day,\n";
                        $insert_sql .= "    work_day,\n";
                        $insert_sql .= "    work_div,\n";
                        $insert_sql .= "    client_id,\n";
                        $insert_sql .= "    ware_id,\n";
                        $insert_sql .= "    io_div,\n";
                        $insert_sql .= "    num,\n";
                        $insert_sql .= "    slip_no,\n"; 
                        $insert_sql .= "    buy_d_id,\n";
                        $insert_sql .= "    staff_id,\n";
                        $insert_sql .= "    shop_id,\n";
                        $insert_sql .= "    client_cname\n";
                        $insert_sql .= ")VALUES(\n";
                        $insert_sql .= "    $goods_id[$i],\n";
                        $insert_sql .= "    NOW(),\n";
                        $insert_sql .= "    '".$arrival_date["y"]."-".$arrival_date["m"]."-".$arrival_date["d"]."',\n";
                        $insert_sql .= "    '4',\n";
                        $insert_sql .= "    $client_id,\n";
                        $insert_sql .= "    $ware,\n";
                        $insert_sql .= "    '2',\n";
                        $insert_sql .= "    $buy_num[$i],\n";
                        $insert_sql .= "    '$buy_no',\n";
                        $insert_sql .= "    $buy_d_id,\n";
                        $insert_sql .= "    $staff_id,\n";
                        $insert_sql .= "    $shop_id,\n";
                        $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $insert_sql .= ");\n";

                        $result = Db_Query($conn, $insert_sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($conn,"ROLLBACK");
                            exit;
                        }

                    }

                    //発注を起こしいているものは処理開始
                    if($order_id != NULL){
                        //発注ヘッダテーブル（処理状況更新処理）
                        $sql  = "UPDATE";
                        $sql .=     " t_order_d";
                        $sql .= " SET";
                        $sql .= "    rest_flg='f' ";
                        $sql .= " FROM";
                        $sql .= "   (SELECT";
                        $sql .= "        ord_d_id,";
                        $sql .= "        SUM(num) AS buy_num ";
                        $sql .= "   FROM";
                        $sql .= "       t_buy_d";
                        $sql .= "   GROUP BY ord_d_id";
                        $sql .= "   ) AS t_buy_d";
                        $sql .= " WHERE ";
                        $sql .= "   t_order_d.ord_d_id = t_buy_d.ord_d_id";
                        $sql .= "   AND ";
                        $sql .= "   t_order_d.ord_d_id = $order_d_id[$i]";
                        $sql .= "   AND ";
                        $sql .= "   t_order_d.num <= t_buy_d.buy_num";
                        $sql .= ";";

                        $result = Db_Query($conn, $sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($conn, "ROLLBACK");
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

                        $result = Db_Query($conn, $sql);
                        $buy_ord_num = pg_fetch_result($result,0,0);

                        //仕入数が発注数を上回っている場合
                        if($buy_ord_num < 0){
                            Db_Query($conn, "ROLLBACK;");
                            $rollback_flg = true;
                            $buy_ord_num_err = "仕入数が発注数を超えています。";
                            break;
                        }
                    }
                }

                //ロールバックフラグがtrueではない場合
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

                        $result = Db_Query($conn, $sql);
                        $data_num = pg_num_rows($result);
                        for($i = 0; $i < $data_num; $i++){
                            $rest_data[] = pg_fetch_result($result,$i,0);
                        }

                        //発注した全ての商品の発注残フラグ＝ｆの場合
                        if(in_array('t',$rest_data)){
                            $insert_sql  = "UPDATE";
                            $insert_sql .= "    t_order_h";
                            $insert_sql .= " SET";
                            $insert_sql .= "    ps_stat = '2'";
                            $insert_sql .= " WHERE";
                            $insert_sql .= "    ord_id = $order_id";
                            $insert_sql .= ";";
                        //上記以外の場合　
                        }else{
                            $insert_sql  = "UPDATE";
                            $insert_sql .= "    t_order_h";
                            $insert_sql .= " SET";
                            $insert_sql .= "    ps_stat = '3'";
                            $insert_sql .= " WHERE";
                            $insert_sql .= "    ord_id = $order_id";
                            $insert_sql .= ";";
                        }

                        $result = Db_Query($conn, $insert_sql);
                        //失敗した場合はロールバック
                        if($result === false){
                            Db_Query($conn, "ROLLBACK");
                            exit;
                        }
                    }

                    //現金取引の自動支払処理
                    //取引区分＝７１（現金仕入）・７3（現金値引）・７4（現金返品）の場合のみ処理する
                    if($trade == '71' || $trade == '73' || $trade == '74'){

                        //支払番号の最大値を抽出
                        //直営の場合
                        if($group_kind == '2'){
                            $sql  = "SELECT";
                            $sql .= "   MAX(pay_no)";
                            $sql .= "FROM";
                            $sql .= "   t_payout_no_serial";
                            $sql .= ";";

                            $result = Db_Query($conn, $sql);
                            $pay_no = pg_fetch_result($result, 0,0);
                            $pay_no = $pay_no + 1;
                            $pay_no = str_pad($pay_no, 8, 0, STR_PAD_LEFT); 

                            $sql  = "INSERT INTO t_payout_no_serial(";
                            $sql .= "   pay_no";
                            $sql .= ")VALUES(";
                            $sql .= "   '$pay_no'";
                            $sql .= ");";

                            $result = Db_Query($conn, $sql);
                            //重複した場合は
                            if($result === false){

                                $err_message = pg_last_error();
                                $err_format = "t_payout_no_serial_pkey";
                                $err_flg = true;
                                Db_Query($conn, "ROLLBACK;");

                                if(strstr($err_message, $err_format) != false){
                                    $duplicate_msg = "支払が同時に行なわれたため、伝票番号の付番に失敗しました。";
                                    $duplicate_flg = true;
                                }else{
                                    exit;
                                }
                            }

                        //直営以外の場合
                        }else{

                            $sql  = "SELECT";
                            $sql .= "   MAX(pay_no)";
                            $sql .= " FROM";
                            $sql .= "   t_payout_h";
                            $sql .= " WHERE";
                            $sql .= "   shop_id = $shop_id";
                            $sql .= ";";

                            $result = Db_Query($conn, $sql);

                            $pay_no = pg_fetch_result($result, 0,0);
                            $pay_no = $pay_no + 1;
                            $pay_no = str_pad($pay_no, 8, 0, STR_PAD_LEFT); 
                        }

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
                        $sql .= "   '".$buy_date["y"]."-".$buy_date["m"]."-".$buy_date["d"]."',\n";
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

                        $result = Db_Query($conn, $sql);

                        //失敗した場合はロールバック
                        if($result === false){
                            $err_message = pg_last_error();
                            $err_format = "t_payout_h_pay_no_key";
                            $err_flg = true;
                            Db_Query($conn, "ROLLBACK;");

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

                            $result = Db_Query($conn, $sql);
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

                            $result = Db_Query($conn, $sql);
                            if($result === false){
                                Db_Query($conn, "ROLLBACK;");
                                exit;
                            }
                        }
                    }

                    Db_Query($conn, "COMMIT");
                    header("Location:./2-3-205.php?buy_id=$buy_id&input_flg=true");
                }
            }
        }else{
            //登録確認画面を表示フラグ
            $comp_flg = true;
        }
    }
}

/****************************/
//フォーム作成（変動）
/****************************/
//行番号カウンタ
$row_num = 1;

//仕入先が選択されていないか仕入登録確認の場合はフリーズ
if($client_search_flg != true || $stock_search_flg != true || $comp_flg == true){
    $style = "color : #000000;
            border : #ffffff 1px solid;
            background-color: #ffffff;";
    $type = "readonly";
}else{
    $type = $g_form_option;
}

for($i = 0; $i < $max_row; $i++){
    //表示行判定
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;

        //発注ID
        $form->addElement("hidden","hdn_order_d_id[$i]");

        //商品ID
        $form->addElement("hidden","hdn_goods_id[$i]");

        //商品コード
        if($freeze_flg == true){
            $form->addElement("text","form_goods_cd[$i]","",
            "style=\"color : #525552;
             border : #ffffff 1px solid;
             background-color: #ffffff;
             text-align: left\" readonly'
            ");
        }else{
            $form->addElement(
                "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
                style=\"$style $g_form_style \" $type 
                onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'goods_search_row', $i ,$row_num)\""
            );
        }
        //商品名
        if($name_change[$i] == '2'){
            if($comp_flg == true){
                $freeze_style  = "style=\"";
                $freeze_style .= "color : #000000;";
                $freeze_style .= "border : #ffffff 1px solid;";
                $freeze_style .= "background-color: #ffffff;\"";
            }
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" $freeze_style $g_text_readonly"
            );
        }else{
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" maxLength=\"41\" 
                 style=\"$style\" $type"
            );
        }
        $form->addElement("hidden","hdn_name_change[$i]","","");
        $form->addElement("hidden","hdn_stock_manage[$i]","","");

        //入数
        $form->addElement("text","form_in_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"color : #000000; 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" 
            readonly'"
        );
        //注文入数
        $form->addElement("text","form_order_in_num[$i]","",
            "size=\"6\" maxLength=\"5\" 
            onKeyup=\"in_num($i,'hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
            style=\"text-align: right; $style $g_form_style \"
            $type"
        );

        //現在個数
        $form->addElement(
            "text","form_stock_num[$i]","",
            'size="11" maxLength=\"5\" 
            style="color : #000000;
            border : #ffffff 1px solid;
            background-color: #ffffff; text-align: right" 
            readonly'
        );
/*
        //発注数
        $form->addElement(
            "text","form_order_num[$i]","",
            'size="11" maxLength=\"9\" 
            style="color : #000000; 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right" readonly'
        );
*/
        //発注数
        $form->addElement(
            "hidden","form_order_num[$i]","",
            'size="11" maxLength=\"9\" 
            style="color : #000000; 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right" readonly'
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
        $form->addElement("text","form_buy_num[$i]","",
            "size=\"6\" maxLength=\"5\" 
            onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');ord_in_num($i);\"
            style=\"text-align: right; $style $g_form_style \"
            $type"
        );


        //仕入単価
        //仕入先が本部の場合は単価をフリーズ
/*
        if($head_flg == 't'){
            $form_buy_price[$i][] =& $form->createElement(
                "text","i","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align:right\" readonly'
            ");
            $form_buy_price[$i][] =& $form->createElement("static","","",".");
            $form_buy_price[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\" 
                style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align:left\" readonly'
            ");
            $form->addGroup( $form_buy_price[$i], "form_buy_price[$i]", "");
        }else{
*/
            $form_buy_price[$i][] =& $form->createElement(
                "text","i","","size=\"11\" maxLength=\"9\" class=\"money\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $style $g_form_style \"
                $type"
            );
            $form_buy_price[$i][] =& $form->createElement("static","","",".");
            $form_buy_price[$i][] =& $form->createElement(
                "text","d","","size=\"1\" maxLength=\"2\" 
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: left; $style $g_form_style \"
                $type"
            );
            $form->addGroup( $form_buy_price[$i], "form_buy_price[$i]", "");
//        }

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
        $form->addElement(
            "text","form_buy_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"color : #000000; 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //発注済数
        $form->addElement(
            "text","form_rorder_num[$i]","",
            "size=\"11\" maxLength=\"9\"
            style=\"color : #000000;
            border : #ffffff 1px solid;
            background-color: #ffffff;
            text-align: right\" readonly'"
        );

        $form->addElement("hidden","hdn_royalty[$i]","","");


        //登録確認画面の場合は非表示
        if($comp_flg != true){
            //検索リンク
            $form->addElement(
                "link","form_search[$i]","","#","検索",
                "TABINDEX=-1 onClick=\"return Open_SubWin_2('../dialog/2-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,5,$client_id,$i,$row_num);\""
            );

            //削除リンク
            //最終行を削除する場合、削除した後の最終行に合わせる
            if($row_num == $max_row-$del_num){
                $form->addElement(
                    "link","form_del_row[$i]","",
                    "#","<font color='#FEFEFE'>削除</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num-1);return false;\""
                );
            //最終行以外を削除する場合、削除する行と同じNOの行に合わせる
            }else{
                $form->addElement(
                    "link","form_del_row[$i]","",
                    "#","<font color='#FEFEFE'>削除</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num);return false;\""
                );
            }
        }
    
        /****************************/
        //表示用HTML作成
        /****************************/
/*
        $html .= "<tr class=\"Result1\">";
        $html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        if($client_search_flg === true && $stock_search_flg === true && $freeze_flg != true && $comp_flg != true){
            $html .=    "（";
            $html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
            $html .=    "）";
        }
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_order_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_order_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_rbuy_num[$i]"]]->toHtml();
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_price[$i]"]]->toHtml();
        $html .=    "</td>";

        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_amount[$i]"]]->toHtml();
        $html .=    "</td>";

        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_rorder_num[$i]"]]->toHtml();
        $html .=    "</td>";
        if($client_search_flg === true && $stock_search_flg === true && $freeze_flg != true && $comp_flg != true){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
            $html .= "  </td>";
        }
        $html .= "</tr>";
*/

        $html .= "<tr class=\"Result1\">";
        $html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        if($client_search_flg === true && $stock_search_flg === true && $freeze_flg != true && $comp_flg != true){
            $html .=    "（";
            $html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
            $html .=    "）";
        }
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
        $html .= "  </td>";
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

        $html .=    "</td>";
        if($client_search_flg === true && $stock_search_flg === true && $freeze_flg != true && $comp_flg != true){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
            $html .= "  </td>";
        }
        $html .= "</tr>";

        //行番号を＋１
        $row_num = $row_num+1;
    }
}

//登録確認画面では、以下のボタンを表示しない
if($comp_flg != true){

    //表示ボタン
//    if($order_freeze_flg != true){
    if($buy_get_flg != true){
        $form->addElement("button","form_show_button","表　示",
                "onClick=\"javascript:Button_Submit('show_button_flg','#','true')\""
        );
    }elseif($order_freeze_flg == true){
        for($i = 0; $i < count($order_freeze); $i++){
            $order_freeze[$i]->freeze();
        }
    }

    //button
    $form->addElement("submit","form_buy_button","仕入確認画面へ", $disabled);
    $form->addElement("button","form_back_button","戻　る","onClick=\"javascript:history.back()\"");
    $form->addElement("button","form_sum_button","合　計","onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true')\"");

    //仕入先リンク
    if($order_freeze_flg == true || $buy_get_flg == true){
        $form->addElement("static","form_client_link", "", "仕入先");
    }else{
        $form->addElement("link","form_client_link","","./2-3-207.php","仕入先","
            onClick=\"return Open_SubWin('../dialog/2-0-251.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,'3-207',1);\""
        );
    }

    //行追加リンク
    if($client_search_flg === true && $stock_search_flg === true && $freeze_flg != true){
        //行追加ボタン
        $form->addElement("button","add_row_link","行追加","onClick=\"javascript:Button_Submit_1('add_row_flg', '#foot', 'true')\"");
    }

}else{
    //登録確認画面では以下のボタンを表示
    //戻る
    $form->addElement("button","return_button","戻　る","onClick=\"javascript:history.back()\"");
    
    //OK
    $form->addElement("submit","comp_button","仕入完了", $disabled);

    //仕入先
    $form->addElement("static","form_client_link", "", "仕入先");
 
    $form->freeze();
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
$js .= "        v_num = \"\";\n";
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
$js .= "    var result = v_ord_num % v_in_num;    if(result == 0){\n";
$js .= "        var res = v_ord_num / v_in_num;\n";
$js .= "        document.dateForm.elements[ord_in_num].value = res;\n";
$js .= "    }else{  \n";
$js .= "        document.dateForm.elements[ord_in_num].value = \"\";\n";
$js .= "    }\n";
$js .= "}\n";


/****************************/
// 仕入先の状態取得
/****************************/
$client_state_print = Get_Client_State($conn, $client_id);


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
$page_menu = Create_Menu_f('buy','2');

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
    'html_header'       => "$html_header",
    'page_menu'         => "$page_menu",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
    'html'              => "$html",
    'message'           => "$message",
    'warning'           => "$warning",
    'freeze_flg'        => "$freeze_flg",
    'client_search_flg' => "$client_search_flg",
    'stock_search_flg'  => "$stock_search_flg",
    'form_potision'     => "$form_potision",
    'error'             => "$error",
    'buy_get_flg'       => "$buy_get_flg",
    'goods_twice'       => "$goods_twice",
    'js'                => "$js",
    'duplicate_msg'     => "$duplicate_msg",
    'comp_flg'          => "$comp_flg",
    'ap_balance'        => "$ap_balance",
    'goods_twice'       => "$goods_twice",
    'buy_ord_num_err'   => "$buy_ord_num_err",
    "client_state_print"=> "$client_state_print",
));


$smarty->assign("goods_err", $goods_err);
$smarty->assign("price_num_err", $price_num_err);
$smarty->assign("num_err", $num_err);
$smarty->assign("price_err", $price_err);
$smarty->assign("duplicate_goods_err",$duplicate_goods_err);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
