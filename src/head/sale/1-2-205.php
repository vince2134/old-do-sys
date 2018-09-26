<?php
/************************************
 * 変更履歴
 *   2006/06/16                watanabe-k    日時更新後の売上データ抽出SQLを変更
 *   2007/03/01                  morita-d    商品名は正式名称を表示するように変更 
 *
 *
 ************************************/
$page_title = "売上照会";

//環境設定ファイル env setting file
require_once("ENV_local.php");

//HTML_QuickFormを作成 create HTML_quickform
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB接続 connect to db
$db_con = Db_Connect();

// 権限チェック authority check
$auth       = Auth_Check($db_con);


/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/07　08-097　　　　watnabe-k　 Getチェック追加
 * 　2006/11/07　08-098　　　　watnabe-k　 Getチェック追加
 * 　2006/11/07　08-099　　　　watnabe-k　 SQL条件修正 
 * 　2006/11/07　08-116　　　　suzuki　    売上伝票一括発行から遷移できるように修正 
 * 　2006/11/08　08-132　　　　suzuki　    得意先名を略称表示 
 * 　2009/07/06　      　　　　aoyama-n　  伝票内容のソート順を商品コードからlineに修正 
 *   2009/10/13                hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *
 */

/****************************/
//データ項目作成関数 create function for data items
/****************************/
//(引数：受注ID) argument: sales order ID 
function Get_Sale_Item($aord_id){
    if($aord_id != NULL){
        //受注から興したか was it recorded from sales order
        $row_item[] = array("No.","商品コード<br>商品名","受注数","現在庫数","出荷数","原価単価<br>売上単価","原価金額<br>売上金額");
    }else{
        //売上から興したか was it recorded from sales 
        $row_item[] = array("No.","商品コード<br>商品名","現在庫数","出荷数","原価単価<br>売上単価","原価金額<br>売上金額");
    }

    return $row_item;
}

/****************************/
//伝票発行処理 issue slip process
/****************************/
$order_sheet  = " function Order_Sheet(hidden1,ord_id){\n";
$order_sheet .= "    res = window.confirm(\"伝票を発行します。よろしいですか？\");\n";
$order_sheet .= "    if (res == true){\n";
$order_sheet .= "        var id = ord_id;\n";
$order_sheet .= "        var hdn1 = hidden1;\n";
$order_sheet .= "        window.open('../../head/sale/1-2-206.php?sale_id='+id,'_blank','');\n";
$order_sheet .= "        document.dateForm.elements[hdn1].value = ord_id;\n";
$order_sheet .= "        //同じウィンドウで遷移する\n";
$order_sheet .= "        document.dateForm.target=\"_self\";\n";
$order_sheet .= "        //自画面に遷移する\n";
$order_sheet .= "        document.dateForm.action='#';\n";
$order_sheet .= "        //POST情報を送信する\n";
$order_sheet .= "        document.dateForm.submit();\n";
$order_sheet .= "        return true;\n";
$order_sheet .= "   }else{\n";
$order_sheet .= "        return false;\n";
$order_sheet .= "    }\n";
$order_sheet .= "}\n";

/****************************/
//契約関数定義 function definition for contract
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");
/****************************/
//外部変数取得 acquire external vairiable
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
$sale_id      = $_GET["sale_id"];             //受注ID Sales order ID
$input_flg    = $_GET["input_flg"];           //売上入力識別フラグ sales input identification flag
$slip_flg     = $_GET["slip_flg"];           //売上照会・一括発行識別フラグ sales inquiry/ issue all at once identification flag
$del_flg     = $_GET["del_flg"];                //削除フラグ delete flag 
$renew_flg     = $_GET["renew_flg"];           //日次更新フラグ daily update flag
$aord_del_flg  = $_GET["aord_del_flg"];     //受注削除フラグ sales order delete flag
$aord_finish_flg  = $_GET["aord_finish_flg"];     //受注削除フラグ sales order delete flag

if($aord_del_flg != true && $aord_finish_flg != true && $_GET["inst_err"] != true){
    //不正値チェック判定 determine invald value
    Get_Id_Check2($_GET["sale_id"]);
    Get_Id_Check3($_GET["sale_id"]);

    if($del_flg != 'true' && $renew_flg != 'true'){
        //整合性判定関数 function for determining compatibility 
        Injustice_check($db_con,"sale",$sale_id,$shop_id);
    }
}
/****************************/
//部品定義 component definition
/****************************/
//売上計上日 sales recorded date
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_sale_day","form_sale_day");

//請求日 invoice date
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_claim_day","form_claim_day");

//伝票番号 slip number 
$form->addElement("static","form_sale_no","","");
//受注番号 sales order number 
$form->addElement("static","form_ord_no","","");

//得意先名 customer name
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//グリーン指定 green designation
$form->addElement("static","form_trans_check","","");
//運送業者名 carrier 
$form->addElement("static","form_trans_name","","");
//直送先名 direct destination name
$form->addElement("static","form_direct_name","","");
//出荷倉庫 shipping warehouse
$form->addElement("static","form_w are_name","","");
//取引区分 trade classification
$form->addElement("static","form_trade_sale","","");
//受注担当者 sales order staff
$form->addElement("static","form_staff_name","","");
//売上担当者 sales staff
$form->addElement("static","form_cstaff_name","","");
//備考 remakrs
//備考 remarks 
$form->addElement("static","form_note","","");

//伝票発行 issue slip
$form->addElement("button","order_button","伝票発行","onClick=\"javascript:Order_Sheet('order_sheet_id',$sale_id);\"");
//伝票発行ID issue slip ID
$form->addElement("hidden", "order_sheet_id");

//遷移元チェック check the page transitioned from
if($input_flg == true){
    //売上入力画面 sales input screen
    //OKボタン ok button
    $form->addElement("button", "ok_button", "Ｏ　Ｋ",
        "onClick=\"location.href='".Make_Rtn_Page("sale")."'\""
    );
    //戻る back 
    $form->addElement("button","return_button","戻　る","onClick=\"location.href='1-2-201.php?sale_id=$sale_id'\"");

    //納品書出力 delivery note output
    $form->addElement("button","order_button","伝票発行","onClick=\"javascript:Order_Sheet('order_sheet_id',$sale_id);\"");

    $freeze_flg = true;    //売上完了メッセージ表示フラグ sales complete message display flag

}else{
    //遷移元識別判定 determine the page transitioned from
    if($slip_flg == true){
        //売上照会 sales inquiry 
        //戻る back 
        $form->addElement("button", "return_button", "戻　る",
        "onClick=\"location.href='".Make_Rtn_Page("sale")."'\""
        );
    }else{
        //一括発行画面 issue all at one screen
        //戻る back
        $form->addElement("button","return_button","戻　る","onClick=\"location.href='1-2-202.php'\"");
    }
}

//売上金額合計 total sales 
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//消費税額(合計) tax total
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//売上金額（税込合計) sales total with tax
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

if($del_flg != 'true' && $renew_flg != 'true' && $aord_del_flg != 'true' && $_GET["inst_err"] != true && $_GET["aord_finish_flg"] != true){
    /****************************/
    //売上ヘッダー抽出判定処理 sales header extraction determination process
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    aord_id,";
    $sql .= "    renew_flg ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "WHERE ";
    $sql .= "    t_sale_h.sale_id = $sale_id";
    $sql .= "    AND";
    $sql .= "    t_sale_h.shop_id = $shop_id";
    $sql .= ";";
    $result = Db_Query($db_con,$sql);

    //GETデータ判定 determine GET data
    Get_Id_Check($result);
    $stat = Get_Data($result);
    $aord_id   = $stat[0][0];            //受注ID sales order ID 
    $renew_flg = $stat[0][1];            //日次更新フラグ daily update flag

    //日次更新フラグがtrueか is the daily update flag true
    if($renew_flg == 't'){
        /****************************/
        //売上ヘッダ抽出SQL（日次更新後） sales header extract SQL (after daily update)
        /****************************/
        $sql  = "SELECT ";                             
        $sql .= "    t_sale_h.sale_no,";
        $sql .= "    t_aorder_h.ord_no,";
        $sql .= "    t_sale_h.sale_day,";
        $sql .= "    t_sale_h.claim_day,";
        $sql .= "    t_sale_h.client_cd1,";
        $sql .= "    t_sale_h.client_cd2,";
        $sql .= "    t_sale_h.client_cname,";
        $sql .= "    t_sale_h.green_flg,";
        $sql .= "    t_sale_h.trans_cname,";
        $sql .= "    t_sale_h.direct_cname,";
        $sql .= "    t_sale_h.ware_name,";
        $sql .= "    CASE t_sale_h.trade_id";            
        $sql .= "        WHEN '11' THEN '掛売上'";
        $sql .= "        WHEN '13' THEN '掛返品'";
        $sql .= "        WHEN '14' THEN '掛値引'";
        $sql .= "        WHEN '15' THEN '割賦売上'";
        $sql .= "        WHEN '61' THEN '現金売上'";
        $sql .= "        WHEN '63' THEN '現金返品'";
        $sql .= "        WHEN '64' THEN '現金値引'";
        $sql .= "    END,";
        $sql .= "    t_sale_h.c_staff_name,";
        $sql .= "    t_sale_h.note, ";
        $sql .= "    t_sale_h.net_amount, ";
        $sql .= "    t_sale_h.tax_amount, ";
//        $sql .= "    t_sale_h.ac_staff_name,";
        $sql .= "    t_aorder_h.c_staff_name,";
        $sql .= "    t_sale_h.ware_id, ";
        $sql .= "   t_sale_h.client_id \n";
        $sql .= "FROM ";
        $sql .= "    t_sale_h ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_aorder_h ";
        $sql .= "    ON t_sale_h.aord_id = t_aorder_h.aord_id ";

        $sql .= "WHERE ";
        $sql .= "    t_sale_h.shop_id = $shop_id ";
        $sql .= "AND ";
        $sql .= "    t_sale_h.sale_id = $sale_id;";
    }elseif($slip_flg == 'true' && $renew_flg == 'f'){
        header("Location:../top.php");
        exit;
    }else{
        /****************************/
        //売上ヘッダー抽出SQL sales header extract SQL
        /****************************/

        $sql  = "SELECT \n";
        $sql .= "    t_sale_h.sale_no,\n";
        $sql .= "    t_aorder_h.ord_no,\n";
        $sql .= "    t_sale_h.sale_day,\n";
        $sql .= "    t_sale_h.claim_day,\n";
//    $sql .= "    t_client.client_cd1,\n";
//    $sql .= "    t_client.client_cd2,\n";
//    $sql .= "    t_client.client_name,\n";
        $sql .= "    t_sale_h.client_cd1,\n";
        $sql .= "    t_sale_h.client_cd2,\n";
        $sql .= "    t_sale_h.client_cname,\n";
        $sql .= "    t_sale_h.green_flg,\n";
//    $sql .= "    t_trans.trans_cname,\n";
//    $sql .= "    t_direct.direct_cname,\n";
//    $sql .= "    t_ware.ware_name,\n";
        $sql .= "    t_sale_h.trans_cname,\n";
        $sql .= "    t_sale_h.direct_cname,\n";
        $sql .= "    t_sale_h.ware_name,\n";
        $sql .= "    CASE t_sale_h.trade_id\n";
        $sql .= "        WHEN '11' THEN '掛売上'\n";
        $sql .= "        WHEN '13' THEN '掛返品'\n";
        $sql .= "        WHEN '14' THEN '掛値引'\n";
        $sql .= "        WHEN '15' THEN '割賦売上'\n";
        $sql .= "        WHEN '61' THEN '現金売上'\n";
        $sql .= "        WHEN '63' THEN '現金返品'\n";
        $sql .= "        WHEN '64' THEN '現金値引'\n";
        $sql .= "    END,\n";
        $sql .= "    t_sale_h.c_staff_name,\n";
        $sql .= "    t_sale_h.note, \n";
        $sql .= "    t_sale_h.net_amount, \n";
        $sql .= "    t_sale_h.tax_amount, \n";
//    $sql .= "    ac_staff.staff_name, \n";
//        $sql .= "    t_sale_h.ac_staff_name, \n";
        $sql .= "    t_aorder_h.c_staff_name, \n";
        $sql .= "    t_sale_h.ware_id, \n";
        $sql .= "   t_sale_h.client_id \n";
        $sql .= "FROM \n";
        $sql .= "    t_sale_h \n";

        $sql .= "    LEFT JOIN \n";
        $sql .= "    t_trans \n";
        $sql .= "    ON t_sale_h.trans_id  = t_trans.trans_id \n";

        $sql .= "    LEFT JOIN \n";
        $sql .= "    t_direct \n";
        $sql .= "    ON t_sale_h.direct_id  = t_direct.direct_id \n";

        $sql .= "    LEFT JOIN \n";
        $sql .= "    t_aorder_h \n";
        $sql .= "    ON t_sale_h.aord_id = t_aorder_h.aord_id \n";

//    $sql .= "    INNER JOIN t_client ON t_sale_h.client_id  = t_client.client_id \n";
    //$sql .= "    INNER JOIN t_ware   ON t_sale_h.ware_id    = t_ware.ware_id \n";
//    $sql .= "    INNER JOIN t_staff AS c_staff  ON t_sale_h.c_staff_id = c_staff.staff_id \n";
//    $sql .= "    INNER JOIN t_staff AS ac_staff  ON t_sale_h.ac_staff_id = ac_staff.staff_id \n";
        $sql .= "WHERE \n";
        $sql .= "    t_sale_h.shop_id = $shop_id \n";
        $sql .= "AND \n";
        $sql .= "    t_sale_h.sale_id = $sale_id;\n";
    }

    $result = Db_Query($db_con,$sql);
    $h_data_list = Get_Data($result);

    /****************************/
    //売上データ抽出SQL sales data extract SQL
    /****************************/
    $data_sql  = "SELECT ";
    //日次更新フラグがtrueか daily update flag is true or not?
    if($renew_flg == 't'){
        $data_sql .= "    t_sale_d.goods_cd,";
    }else{
//    $data_sql .= "    t_goods.goods_cd,";
        $data_sql .= "    t_sale_d.goods_cd,";
    }
    //$data_sql .= "    t_sale_d.goods_name,";
    $data_sql .= "    t_sale_d.official_goods_name,";
    $data_sql .= "    t_sale_d.num,"; 
    $data_sql .= "    t_sale_d.cost_price,";
    $data_sql .= "    t_sale_d.sale_price,";
    $data_sql .= "    t_sale_d.cost_amount, ";
    $data_sql .= "    t_sale_d.sale_amount, ";
    //受注IDがある場合は、受注数を表示 display the ordered number of units received if there is a sales order ID 
    if($aord_id != NULL){
        $data_sql .= "    t_aorder_d.num, ";
    }
    #2009-10-13 hashimoto-y
    #$data_sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num ";
    $data_sql .= "    CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num ";

    $data_sql .= "FROM ";
    $data_sql .= "    t_sale_d ";
    $data_sql .= "    INNER JOIN t_sale_h ON t_sale_d.sale_id = t_sale_h.sale_id ";
    //受注IDがある場合は、受注データテーブルと結合 combine with sales order data table if there is a sales order ID
    if($aord_id != NULL){
        $data_sql .= "    INNER JOIN t_aorder_d ON t_sale_d.aord_d_id = t_aorder_d.aord_d_id ";
    }
    //日次更新フラグがtrueか is the faily update id true
    //if($renew_flg == 't'){
        $data_sql .= "    INNER JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id ";
    //}
    $data_sql .= "   LEFT JOIN ";
    $data_sql .= "   (SELECT";
    $data_sql .= "       goods_id,";
    $data_sql .= "       SUM(stock_num)AS stock_num";
    $data_sql .= "   FROM";
    $data_sql .= "       t_stock";
    $data_sql .= "   WHERE";
    $data_sql .= "       shop_id = $shop_id";
    $data_sql .= "       AND";
    $data_sql .= "       ware_id = ".$h_data_list[0][17];
    $data_sql .= "       GROUP BY t_stock.goods_id";
    $data_sql .= "   )AS t_stock";
    $data_sql .= "   ON t_sale_d.goods_id = t_stock.goods_id ";

    #2009-10-13 hashimoto-y
    $data_sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

    $data_sql .= "WHERE ";
    $data_sql .= "    t_sale_d.sale_id = $sale_id ";
    $data_sql .= "AND ";
    $data_sql .= "    t_sale_h.shop_id = $shop_id ";
    #2009-10-13 hashimoto-y
    $data_sql .= "AND ";
    $data_sql .= "    t_goods_info.shop_id = $shop_id ";

    $data_sql .= "ORDER BY ";
    //aoyama-n 2009-07-06
    //日次更新フラグがtrueか is the daily update flag true 
    //if($renew_flg == 't'){
    //    $data_sql .= "    t_sale_d.goods_cd;";
    //}else{
//    $data_sql .= "    t_goods.goods_cd;";
    //    $data_sql .= "    t_sale_d.goods_cd;";
    //}
    $data_sql .= "    t_sale_d.line;";

    $result = Db_Query($db_con,$data_sql);

    /****************************/
    //売上データー表示 display sales data
    /****************************/
    //行項目部品を作成 create row items components 
    $row_item = Get_Sale_Item($aord_id);

    //行データ部品を作成 create row data component 
    $row_data = Get_Data($result);
    for($i=0;$i<count($row_data);$i++){
        for($j=0;$j<count($row_data[$i]);$j++){
            //原価単価・売上単価 costper unit, selling price per unit 
            if($j==3 || $j==4){
                $row_data[$i][$j] = number_format($row_data[$i][$j],2);
            }
            //出荷数・原価金額・売上金額 number of units to be shipped, cost price, sales price
            if($j==2 || $j==5 || $j==6){
                $row_data[$i][$j] = number_format($row_data[$i][$j]);
            }
            //受注数を表示する場合、一つずれる為 it will deviate one each if number of units will be displayed 
            if($aord_id != NULL && $j==7){
                $row_data[$i][$j] = number_format($row_data[$i][$j]);
            }
        
            //受注数表示判定 determine if the ordered number of units will be displayed 
            if($aord_id != NULL && $j==8){
                //現在庫数 current inv number 
                $row_data[$i][$j] = number_format($row_data[$i][$j]);
            }else if($aord_id == NULL && $j==7){
                //現在庫数 current inv number
                $row_data[$i][$j] = number_format($row_data[$i][$j]);
            }
        }
    }
    /****************************/
    //売上ヘッダー表示 display sales header
    /****************************/
    $def_fdata["form_sale_no"]                      =   $h_data_list[0][0];                          //伝票番号 slip number 
    $def_fdata["form_ord_no"]                       =   $h_data_list[0][1];                          //受注番号 saleso rrder number 

    //日付生成 create daily update 
    $form_sale_day                                  =   explode('-',$h_data_list[0][2]);
    $form_claim_day                                 =   explode('-',$h_data_list[0][3]);

    $def_fdata["form_sale_day"]["y"]                =   $form_sale_day[0];                           //売上日(年) sales date year
    $def_fdata["form_sale_day"]["m"]                =   $form_sale_day[1];                           //売上日(月) sales date month
    $def_fdata["form_sale_day"]["d"]                =   $form_sale_day[2];                           //売上日(日) sales date day

    $def_fdata["form_claim_day"]["y"]               =   $form_claim_day[0];                          //請求日(年) invoice date year 
    $def_fdata["form_claim_day"]["m"]               =   $form_claim_day[1];                          //請求日(月) invoice date month 
    $def_fdata["form_claim_day"]["d"]               =   $form_claim_day[2];                          //請求日(日) invoice date day

    $def_fdata["form_client"]["cd1"]                =   $h_data_list[0][4];                          //得意先cd1 customer code 1 
    $def_fdata["form_client"]["cd2"]                =   $h_data_list[0][5];                          //得意先cd2customer code 2
    $def_fdata["form_client"]["name"]               =   $h_data_list[0][6];                          //得意先名 cusotmer name

    $client_id                                      =   $h_data_list[0][18];

    //グリーン指定判定 determube uf green destination is checked
    if($h_data_list[0][7] == 't'){
        $def_fdata["form_trans_check"]              = "グリーン指定あり　";
    }
    $def_fdata["form_trans_name"]                   =   $h_data_list[0][8];                         //運送業者 carrier
    $def_fdata["form_direct_name"]                  =   $h_data_list[0][9];                         //直送先 direct destination
    $def_fdata["form_ware_name"]                    =   $h_data_list[0][10];                         //倉庫 waarehouse
    $def_fdata["form_trade_sale"]                   =   $h_data_list[0][11];                         //取引区分 trade classification
    $def_fdata["form_cstaff_name"]                   =   $h_data_list[0][12];                         //売上担当者 sales staff
    $def_fdata["form_note"]                         =   $h_data_list[0][13];

    $def_fdata["form_sale_total"]                   =   number_format($h_data_list[0][14]);          //税抜金額 amount with no tax
    $def_fdata["form_sale_tax"]                     =   number_format($h_data_list[0][15]);          //消費税 tax
    $total_money                                    =   $h_data_list[0][14] + $h_data_list[0][15];   //税込金額 amt with tax
    $def_fdata["form_sale_money"]                   =   number_format($total_money);                         
    $def_fdata["form_staff_name"]                   =   $h_data_list[0][16];                         //受注担当者           sales order slaff              
    $form->setDefaults($def_fdata);

    /****************************/
    //伝票発行ボタン押下処理 when the issue slip button is pressed 
    /****************************/
    if($_POST["order_sheet_id"]!=NULL){

        Db_Query($db_con, "BEGIN");

        $flg_update  = " UPDATE ";
        $flg_update .= "    t_sale_h ";
        $flg_update .= "    SET ";
        $flg_update .= "    slip_flg = 't', ";
        $flg_update .= "    slip_out_day = NOW() ";
        $flg_update .= "    where ";
        $flg_update .= "    sale_id = ".$_POST["order_sheet_id"];
        $flg_update .= "    AND ";
        $flg_update .= "    slip_flg ='f' ";
        $flg_update .= ";";

        //該当データ件数 number of corresponding data
        $result = @Db_Query($db_con, $flg_update);
        if($result == false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }
        Db_Query($db_con, "COMMIT");

    }

    if($h_data_list[0][11] == "割賦売上" && $input_flg == true){
        //分割売上入力 input sales divided into 7 
        //$form->addElement("button","slip_bill_button","分割請求","onClick=\"location.href='1-2-208.php?sale_id=$sale_id'\"");
	    $form->addElement("button","slip_bill_button","分割請求","onClick=\"SubMenu2('".HEAD_DIR."sale/1-2-208.php?sale_id=".$sale_id."')\"");
	    $form->addElement("hidden","slip_bill_flg");    //売上入力遷移フラグ flag for transitioning to salses input  
	
	    $slip_data["slip_bill_flg"] = true;
	    $form->setConstants($slip_data);   
    }
}


/****************************/
// 得意先の状態出力 output the customer status 
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


/****************************/
//HTMLヘッダ html header 
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ html footer 
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu 
/****************************/
$page_menu = Create_Menu_h('sale','2');
/****************************/
//画面ヘッダー作成 create screen header 
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定 render related settings 
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variable
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign other variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'aord_id'       => "$aord_id",
    'input_flg'     => "$input_flg",
    'order_sheet'   => "$order_sheet",
    'freeze_flg'    => "$freeze_flg",
    "client_state_print"    => "$client_state_print",
));
$smarty->assign('item',$row_item);
$smarty->assign('row',$row_data);
//テンプレートへ値を渡す pass the value to the template 
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
