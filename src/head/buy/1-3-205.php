<?php
/****************************/
// 変更履歴
//   テーブルに存在していないカラムを参照しているためエラーがでているので、修正
/***************************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/11　06-074　　　　watanabe-k　GETチェック追加
 *   2007/03/08  その他25      kajioka-h   自動で起きた仕入なら、日次更新していなくても明細表示するように変更
 *   2009/09/18                aoyama-n    値引商品及び取引区分が値引・返品の場合は赤字で表示
 *   2009/09/18                aoyama-n    商品のソート順をlineに修正
 *
 */

$page_title = "仕入照会";

// 環境設定ファイル env setting file
require_once("ENV_local.php");

// HTML_QuickFormを作成 create
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続 connect db
$db_con = Db_Connect();

// 権限チェック auth check
$auth   = Auth_Check($db_con);

/****************************/
// 外部変数取得 acquire external variable
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
$buy_id       = $_GET["buy_id"];             // 仕入ID purchase Id
Get_Id_Check3($buy_id);
Get_Id_Check2($buy_id);
$input_flg    = $_GET["input_flg"];          // 遷移元識別フラグ identification flag where the page transitioned from 
$buy_div      = $_GET["buy_div"];           //仕入先区分 purchase client classification


/****************************/
// 部品定義 component definition
/****************************/
// 入荷日 purchase arrival date
$text="";
$text[] =& $form->createElement("static", "y", "", "");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("static", "m", "", "");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("static", "d", "", "");
$form->addGroup($text, "form_arrival_day", "");

// 仕入日 purchase date
$text="";
$text[] =& $form->createElement("static", "y", "", "");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("static", "m", "", "");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("static", "d", "", "");
$form->addGroup($text, "form_buy_day", "");

// 発注番号 purchase order number
$form->addElement("static", "form_ord_no", "", "");
// 伝票番号 slip number
$form->addElement("static", "form_buy_no", "", "");

// 仕入先名 purchase client nmae
$form_client[] =& $form->createElement("static", "cd1", "", "");
$form_client[] =& $form->createElement("static", "", "", " ");
$form_client[] =& $form->createElement("static", "name", "", "");
$form->addGroup($form_client, "form_client", "");

// 直送先名 direct destination name
$form->addElement("static", "form_direct_name", "", "");
// 仕入倉庫 purchase warehose
$form->addElement("static", "form_ware_name", "", "");
// 取引区分 trade classification
$form->addElement("static", "form_trade_buy", "", "");
// 担当者 assigned staff
$form->addElement("static", "form_oc_staff_name", "", "");
// 担当者 assigned staff
$form->addElement("static", "form_c_staff_name", "", "");
// 備考 remarks
$form->addElement("static", "form_note", "", "");

// 遷移元チェック check where it transitioned from
if($input_flg == true){
    // 仕入入力（オフライン）画面 input purchase (offline) screen
    $form->addElement("button", "ok_button", "Ｏ　Ｋ", "onClick=\"Submit_Page('".Make_Rtn_Page("buy")."');\"");

    // 戻る go back
    if ($_GET[change_ord_flg] == null && $_GET["inst_err"] == null){

        if($buy_div == '1'){
            $form->addElement("button", "return_button", "戻　る", "onClick=\"location.href='1-3-201.php?buy_id=$buy_id'\"");
        }else{
            $form->addElement("button", "return_button", "戻　る", "onClick=\"location.href='1-3-207.php?buy_id=$buy_id'\"");
        }
    }
    $freeze_flg = true;    // 仕入完了メッセージ表示フラグ purchase complete message display flag
}else{
    // 発注照会画面 purchase order inquiry screen
    // 戻る go back
    $form->addElement("button", "return_button", "戻　る", "onClick=\"javascript:history.back()\"");
}

// 売上金額合計 total sales amount
$form->addElement("text", "form_buy_total", "", "size=\"18\" maxLength=\"15\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #FFFFFF; text-align: right\" readonly");

// 消費税額(合計) total tax amount
$form->addElement("text", "form_buy_tax", "", "size=\"18\" maxLength=\"15\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: right\" readonly");

// 売上金額（税込合計) total sales with tax
$form->addElement("text", "form_buy_money", "", "size=\"18\" maxLength=\"15\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: right\" readonly");

/****************************/
// 仕入ヘッダー抽出判定処理 decision process for extracting purchase header 
/****************************/
if($_GET[del_buy_flg] == null && $_GET[del_ord_flg] == null && $_GET[change_ord_flg] == null && $_GET["inst_err"] == null && $_GET["ps_stat"] == null){
    $sql  = "SELECT renew_flg FROM t_buy_h WHERE t_buy_h.buy_id = $buy_id AND shop_id = $shop_id;";
    $result = Db_Query($db_con, $sql);
    // GETデータ判定 decidison of GET data
    Get_Id_Check($result);

    // 日次更新フラグ取得 acquire daily update flag
    $renew_flg = pg_fetch_result($result, 0, 0);

    //自動で起きた仕入かどうか判定 decide if it was an automatic purchase
    $sql  = "SELECT \n";
    $sql .= "    CASE \n";
    $sql .= "        WHEN intro_sale_id IS NOT NULL OR act_sale_id IS NOT NULL \n";
    $sql .= "            THEN 't' \n";
    $sql .= "            ELSE 'f' \n";
    $sql .= "    END AS intro_act_flg \n";
    $sql .= "FROM \n";
    $sql .= "    t_buy_h \n";
    $sql .= "WHERE \n";
    $sql .= "    buy_id = $buy_id AND shop_id = $shop_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    //自動で起きた仕入なら、日次更新フラグを"t"にして明細表示する if it was an automatic purchase then make the daily update flag "t" then show details
    $renew_flg = (pg_fetch_result($result, 0, 0) == "t") ? "t" : $renew_flg;

    //日次更新フラグが’ｔ’で登録フラグがtrueの場合トップへ遷移 if the daily update is "t" and the register flag is true then transition to the top screen
    if($renew_flg == 't' && $input_flg == 'true'){
        header("Location:../top.php");
    }elseif($renew_flg == 'f' && $input_flg != 'true'){
        header("Location:../top.php");
    }

    $sql  = "SELECT ";
    $sql .= "    t_buy_h.buy_no, ";
    $sql .= "    t_order_h.ord_no, ";
    $sql .= "    t_buy_h.buy_day, ";
    $sql .= "    t_buy_h.arrival_day, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.client_cd1, "   : " t_client.client_cd1, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.client_name, "  : " t_client.client_name, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.direct_name, "  : " t_direct.direct_name, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.ware_name, "    : " t_ware.ware_name, ";
    $sql .= "   CASE buy_div\n";
    $sql .= "       WHEN '2' THEN t_buy_h.client_cd1 || '-'|| t_buy_h.client_cd2\n";
    $sql .= "       ELSE t_buy_h.client_cd1\n";
    $sql .= "   END AS client_cd1,\n";
//    $sql .= "    t_buy_h.client_cd1, ";
    $sql .= "    t_buy_h.client_cname, ";
    $sql .= "    t_buy_h.direct_name, ";
    $sql .= "    t_buy_h.ware_name, ";
    $sql .= "    t_trade.trade_name,";
//$sql .= ($renew_flg == "t") ? " t_buy_h.c_staff_name, " : " t_staff.staff_name, ";
    $sql .= "    t_buy_h.c_staff_name, ";
    $sql .= "    t_buy_h.note, ";
    $sql .= "    t_buy_h.net_amount, ";
    $sql .= "    t_buy_h.tax_amount, ";
    $sql .= "    t_buy_h.trade_id, ";
    $sql .= "   t_buy_h.client_id ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";
//$sql .= ($renew_flg != "t") ? " LEFT JOIN " : null;
//$sql .= ($renew_flg != "t") ? " t_direct "  : null;
//$sql .= ($renew_flg != "t") ? " ON t_buy_h.direct_id  = t_direct.direct_id " : null;
    $sql .= "    LEFT JOIN ";
    $sql .= "    t_order_h ";
    $sql .= "    ON t_buy_h.ord_id = t_order_h.ord_id ";
    $sql .= "    INNER JOIN";
    $sql .= "    t_trade";
    $sql .= "    ON t_buy_h.trade_id = t_trade.trade_id ";
//if ($renew_flg != "t"){
//    $sql .= "    INNER JOIN t_client ON t_buy_h.client_id  = t_client.client_id ";
//    $sql .= "    INNER JOIN t_ware   ON t_buy_h.ware_id    = t_ware.ware_id ";
//    $sql .= "    INNER JOIN t_staff  ON t_buy_h.c_staff_id = t_staff.staff_id ";
//}
    $sql .= "WHERE ";
    $sql .= "    t_buy_h.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    t_buy_h.buy_id = $buy_id;";

    $result = Db_Query($db_con, $sql);
    $h_data_list = Get_Data($result);

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

    $result = Db_Query($db_con,$sql);   
    $oc_staff = Get_Data($result);
}

/****************************/
// 仕入データ抽出SQL（日次更新後）SQL for extracting purchase data (after DU)
/****************************/
$data_sql  = "SELECT ";
//$data_sql .= ($renew_flg == "t") ? " t_buy_d.goods_cd," : " t_goods.goods_cd,";
$data_sql .= "    t_buy_d.goods_cd, ";
$data_sql .= "    t_buy_d.goods_name,";
$data_sql .= "    t_buy_d.num,"; 
$data_sql .= "    t_buy_d.buy_price,";
//aoyama-n 2009-09-18
#$data_sql .= "    t_buy_d.buy_amount ";
$data_sql .= "    t_buy_d.buy_amount, ";
$data_sql .= "    t_goods.discount_flg ";
$data_sql .= "FROM ";
$data_sql .= "    t_buy_d ";
$data_sql .= "    INNER JOIN t_buy_h ON t_buy_d.buy_id = t_buy_h.buy_id ";
//aoyama-n 2009-09-18
$data_sql .= "    INNER JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id ";
//$data_sql .= ($renew_flg != "t") ? "INNER JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id " : null;
$data_sql .= "WHERE ";
$data_sql .= "    t_buy_d.buy_id = $buy_id ";
$data_sql .= "AND ";
$data_sql .= "    t_buy_h.shop_id = $shop_id ";
$data_sql .= "ORDER BY ";
//$data_sql .= ($renew_flg == "t") ? " t_buy_d.goods_cd;" : " t_goods.goods_cd;";
//aoyama-n 2009-09-18
#$data_sql .= " t_buy_d.goods_cd;";
$data_sql .= " t_buy_d.line;";

$result = Db_Query($db_con,$data_sql);

/****************************/
// 仕入データー表示 display purchase data
/****************************/
// 行データ部品を作成 create the row data component
$row_data = Get_Data($result);
for($i=0; $i<count($row_data); $i++){
    for($j=0; $j<count($row_data[$i]); $j++){
        if($j == 2 || $j == 4){
            $row_data[$i][$j] = number_format($row_data[$i][$j]);
        }else if($j == 3){
            $row_data[$i][$j] = number_format($row_data[$i][$j], 2);
        }
    }
}

/****************************/
// 仕入ヘッダー表示 display purchase header
/****************************/
$def_fdata["form_buy_no"]           =   $h_data_list[0][0];                         // 伝票番号 slip number
$def_fdata["form_ord_no"]           =   $h_data_list[0][1];                         // 発注番号 purchase order number

// 日付生成 create date
$form_buy_day                       =   explode("-", $h_data_list[0][2]);
$form_arrival_day                   =   explode("-", $h_data_list[0][3]);

$def_fdata["form_buy_day"]["y"]     =   $form_buy_day[0];                           // 仕入日(年) purchase date year
$def_fdata["form_buy_day"]["m"]     =   $form_buy_day[1];                           // 仕入日(月) purchase date mth
$def_fdata["form_buy_day"]["d"]     =   $form_buy_day[2];                           // 仕入日(日) purchase date day

$def_fdata["form_arrival_day"]["y"] =   $form_arrival_day[0];                       // 入荷日(年) purchase arrival date year
$def_fdata["form_arrival_day"]["m"] =   $form_arrival_day[1];                       // 入荷日(月)purchase arrival date mth
$def_fdata["form_arrival_day"]["d"] =   $form_arrival_day[2];                       // 入荷日(日) purchase arrival date day

$def_fdata["form_client"]["cd1"]    =   $h_data_list[0][4];                         // 仕入先    purchase client
$def_fdata["form_client"]["name"]   =   $h_data_list[0][5];                          

$def_fdata["form_direct_name"]      =   $h_data_list[0][6];                         // 直送先 direct destination
$def_fdata["form_ware_name"]        =   $h_data_list[0][7];                         // 倉庫 warehouse
$def_fdata["form_trade_buy"]        =   $h_data_list[0][8];                         // 取引区分 trade classification
$def_fdata["form_c_staff_name"]     =   $h_data_list[0][9];                         // 担当者 assigned staff
$def_fdata["form_note"]             =   $h_data_list[0][10];

$def_fdata["form_buy_total"]        =   number_format($h_data_list[0][11]);         // 税抜金額 amount without tax
$def_fdata["form_buy_tax"]          =   number_format($h_data_list[0][12]);         // 消費税 tax
$total_money                        =   $h_data_list[0][11] + $h_data_list[0][12];  // 税込金額 amount with tax
$def_fdata["form_buy_money"]        =   number_format($total_money);                         
$def_fdata["form_oc_staff_name"]    =   $oc_staff[0][0];                            // 発注担当者 purchase order assigned staff

$client_id                          =   $h_data_list[0][14];                        // 仕入先ID purchase client ID

$form->setDefaults($def_fdata);

//取引区分が割賦の場合、割賦入力ボタン作成 if trade classification "installement" then create the "input installmenT" button
if($h_data_list[0][13] == '25' && $input_flg == true){
    $form->addElement("button", "form_split_button","割賦仕入","onClick=\"location.href='1-3-206.php?buy_id=".$buy_id."'\"");
}


/****************************/
// 仕入先の状態取得 acqiore the condition of the purchase client
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


/****************************/
// 業務代行料の伝票明細時は
// 該当の売上伝票番号と売上額を出力する output the sales slip number and sales amount in the detail of the agency fee
/****************************/
if ($input_flg == null){

    $sql  = "SELECT \n";
    $sql .= "   t_sale_h.sale_no, \n";
    $sql .= "   t_sale_h.net_amount + t_sale_h.tax_amount AS sale_amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "   INNER JOIN t_sale_h ON t_buy_h.act_sale_id = t_sale_h.sale_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_buy_h.buy_id = $buy_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // レコードがある場合 if there is a record
    if ($num > 0){

        $act_sale_flg    = true;                            // 業務代行料フラグ agency fee flag

        $act_sale_no     = pg_fetch_result($res, 0, 0);     // 売上番号 sale number
        $act_sale_amount = pg_fetch_result($res, 0, 1);     // 代行売上額  agency sales amount

        // フォームに値をセット set the value in form
        $set_act_data["form_act_sale_no"]       = str_pad($act_sale_no, 8, "0", STR_PAD_LEFT);
        $set_act_data["form_act_sale_amount"]   = number_format($act_sale_amount);
        $form->setConstants($set_act_data);

        // 売上番号 sale number
        $form->addElement("text", "form_act_sale_no", "", "size=\"18\" maxLength=\"15\"
            style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: left\" readonly
        ");

        // 代行売上額 agency sale amount
        $form->addElement("text", "form_act_sale_amount", "", "size=\"18\" maxLength=\"15\"
            style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: right\" readonly
        ");

    }


}


/****************************/
// HTMLヘッダ html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ html footer
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成 create menu
/****************************/
$page_menu = Create_Menu_h("buy", "2");

/****************************/
// 画面ヘッダー作成 create screen header
/****************************/
$page_header = Create_Header($page_title);

//  Render関連の設定 render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign assign form related variable
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign assign other variables
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "input_flg"     => "$input_flg",
    "freeze_flg"    => "$freeze_flg",
    "act_sale_flg"  => "$act_sale_flg",
    "client_state_print"    => "$client_state_print",
));
$smarty->assign("row", $row_data);
// テンプレートへ値を渡す pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
