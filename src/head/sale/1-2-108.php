<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/03　08-067　　　　watanabe-k＿サニタイズ処理を無効化
 * 　2006/11/03　08-073　　　　watanabe-k　Getチェック追加
 * 　2006/11/03　08-074　　　　watanabe-k　Getチェック追加
 * 　2006/11/03　08-074　　　　watanabe-k　Getチェック追加
 * 　2006/11/03　08-141　　　　watanabe-k　直送先、運送業者名を略称表示に変更
 * 　2006/11/03　08-146　　　　watanabe-k　オンライン、オフライン時に遷移先変更
 * 　2006/12/01　　　      　　watanabe-k　単価が切り上げられているバグの修正
 *   2007/03/01                  morita-d    商品名は正式名称を表示するように変更 
 *   2009/09/25  rev.1.2       kajioka-h   受注入力オフラインが分納対応したことにより、受注入力後の戻るボタン削除
 *   2009/10/12                hashimoto-y 値引き商品を赤字表示に変更
 *
 */


$page_title = "受注照会";

//environment setting file 環境設定ファイル
require_once("ENV_local.php");

//Create HTML_QuickForm HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB接続 connect Database
$db_con = Db_Connect();

// 権限チェック aithority check
$auth       = Auth_Check($db_con);


/****************************/
//データ項目作成関数 data item creation function
/****************************/
//(引数：FC発注ID) argument:FC ordering number 
function Get_Ord_Item($fc_ord_id){
    //オンラインか is it online order?
    if($fc_ord_id != NULL){
        //オンライン online order
        $row_item[] = array("No.","商品コード<br>商品名","出荷数","原価単価<br>売上単価","原価金額<br>売上金額");
    }else{
        //オフライン offline order 
        $row_item[] = array("No.","商品コード<br>商品名","受注数","原価単価<br>売上単価","原価金額<br>売上金額");
    }

    return $row_item;
}

/****************************/
//外部変数取得 acquire external variables 
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
$aord_id      = $_GET["aord_id"];             //受注ID order ID
$fc_ord_id    = $_GET["fc_ord_id"];           //FC発注ID FC ordering ID
$input_flg    = $_GET["input_flg"];           //受注入力識別 discern order input 
$del_flg      = $_GET["del_flg"];             //発注取り消しフラグ ordering cancellation flag
$add_flg      = $_GET["add_flg"];             //受注登録済みフラグ order registered flag
$aord_del_flg = $_GET["aord_del_flg"];        //受注削除フラグ deleted order flag
$add_del_flg  = $_GET["add_del_flg"];         //受注削除フラグ deleted order flag
Get_Id_Check3($_GET[aord_id]);
Get_Id_Check3($_GET[fc_ord_id]);
/****************************/
//オンライン処理 online process
/****************************/
$aord_id = null;
//遷移元判定 determine where it transitioned from
if($del_flg == true || $aord_del_flg == true || $add_del_flg == true || $add_flg == true){
}elseif($fc_ord_id != NULL){
    //出荷予定入力画面 input screen for planned delivery
    $sql  = "SELECT ";
    $sql .= "    aord_id ";
    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "WHERE ";
    $sql .= "    fc_ord_id = $fc_ord_id;";
    $result = Db_Query($db_con,$sql);
    //GETデータ判定 determine GET data
    Get_Id_Check($result);

    //受注ID分ヘッダーとデータ表示 header and data display of order ID
    while($aord_id_data = pg_fetch_array($result)){
        $aord_id[] = $aord_id_data[0];
    }
}else{
    //受注入力画面・受注照会 order input screen・order inquiry
    //オフラインは、一件表示 display 1 item if it's offline
    $num = 1;
    $aord_id[0]      = $_GET["aord_id"];             //受注ID order ID
    Get_Id_Check2($aord_id[0]);
}


$html = NULL;     //HTML表示データ初期化 initialization of HTML display data 
for($s=0;$s<count($aord_id);$s++){
    /****************************/
    //受注ヘッダー抽出判定処理 order header extraction determination process
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    ps_stat,";
    $sql .= "    client_id ";
    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "WHERE ";
    $sql .= "    t_aorder_h.aord_id = ".$aord_id[$s].";";
    $result = Db_Query($db_con,$sql);
    //GETデータ判定 determine GET data
    Get_Id_Check($result);

    //処理状況取得 acquire process status
    $ps_stat = pg_fetch_result($result,0,0);
    //得意先ID取得 acquire customer ID 
    $client_id = pg_fetch_result($result,0,1);

    //処理状況が日次更新後か is the process status after the daily update is done?
    if($ps_stat == '4' && $input_flg != "true"){
        /****************************/
        //受注ヘッダ抽出SQL（処理状況が日次更新後）SQL for order header extraction (order process is after the daily update)
        /****************************/
        $sql  = "SELECT ";
        $sql .= "    t_aorder_h.ord_no,";
        $sql .= "    t_aorder_h.ord_time,";                        
        $sql .= "    t_aorder_h.hope_day,";
        $sql .= "    t_aorder_h.arrival_day,";
        $sql .= "    t_aorder_h.green_flg,";
        $sql .= "    t_aorder_h.trans_cname,";
        $sql .= "    t_aorder_h.client_cd1,";
        $sql .= "    t_aorder_h.client_cd2,";
        $sql .= "    t_aorder_h.client_cname,";
        $sql .= "    t_aorder_h.direct_cname,";
        $sql .= "    t_aorder_h.ware_name,";
        $sql .= "    CASE t_aorder_h.trade_id";            
        $sql .= "        WHEN '11' THEN '掛売上'";
        $sql .= "        WHEN '61' THEN '現金売上'";
        $sql .= "    END,";
        $sql .= "    t_aorder_h.c_staff_name,";
        $sql .= "    t_aorder_h.note_your,";
        $sql .= "    t_aorder_h.note_my, ";
        $sql .= "    t_aorder_h.net_amount, ";
        $sql .= "    t_aorder_h.tax_amount ";
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";
        $sql .= "WHERE ";
        $sql .= "    t_aorder_h.aord_id = ".$aord_id[$s]."";
        $sql .= "    AND";
        $sql .= "    t_aorder_h.ps_stat = '4'";
    }elseif($ps_stat == '1' && $input_flg != 'true' && $fc_ord_id == null){
        header("Location:../top.php");
        exit;
    }else{
        /****************************/
        //受注ヘッダー抽出SQL SQL for order header extraction 
        /****************************/
        $sql  = "SELECT ";
        $sql .= "    t_aorder_h.ord_no,";
        $sql .= "    t_aorder_h.ord_time,";                        
        $sql .= "    t_aorder_h.hope_day,";
        $sql .= "    t_aorder_h.arrival_day,";
        $sql .= "    t_aorder_h.green_flg,";
//        $sql .= "    t_trans.trans_name,";
//        $sql .= "    t_client.client_cd1,";
//        $sql .= "    t_client.client_cd2,";
//        $sql .= "    t_client.client_name,";
//        $sql .= "    t_direct.direct_name,";
//        $sql .= "    t_ware.ware_name,";
        $sql .= "    t_aorder_h.trans_cname,";
        $sql .= "    t_aorder_h.client_cd1,";
        $sql .= "    t_aorder_h.client_cd2,";
        $sql .= "    t_aorder_h.client_cname,";
        $sql .= "    t_aorder_h.direct_cname,";
        $sql .= "    t_aorder_h.ware_name,";
        $sql .= "    CASE t_aorder_h.trade_id";            
        $sql .= "        WHEN '11' THEN '掛売上'";
        $sql .= "        WHEN '61' THEN '現金売上'";
        $sql .= "    END,";
//        $sql .= "    t_staff.staff_name,";
        $sql .= "    t_aorder_h.c_staff_name,";
        $sql .= "    t_aorder_h.note_your,";
        $sql .= "    t_aorder_h.note_my, ";
        $sql .= "    t_aorder_h.net_amount, ";
        $sql .= "    t_aorder_h.tax_amount ";
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_trans  ";
        $sql .= "    ON t_aorder_h.trans_id   = t_trans.trans_id ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_direct ";
        $sql .= "    ON t_aorder_h.direct_id  = t_direct.direct_id ";

        $sql .= "    INNER JOIN t_client ON t_aorder_h.client_id  = t_client.client_id ";
        $sql .= "    INNER JOIN t_ware   ON t_aorder_h.ware_id    = t_ware.ware_id ";
        $sql .= "    INNER JOIN t_staff  ON t_aorder_h.c_staff_id = t_staff.staff_id ";
        $sql .= "WHERE ";
        $sql .= "    t_aorder_h.aord_id = ".$aord_id[$s]."";
        $sql .= "    AND";
        $sql .= "    t_aorder_h.ps_stat <> '4'";
        $sql .= ";";
    }
    $result = Db_Query($db_con,$sql);
    Get_Id_Check($result);
    $h_data_list = Get_Data($result);

    /****************************/
    //受注データ抽出SQL SQL for order data extraction
    /****************************/
    $data_sql  = "SELECT ";
    //処理状況が日次更新後か is the process status after the daily update
//    if($ps_stat == '4'){
        $data_sql .= "    t_aorder_d.goods_cd,";
//    }else{
//        $data_sql .= "    t_goods.goods_cd,";
//        $data_sql .= "    t_aorder_d.goods_cd,";
//    }
    $data_sql .= "    t_aorder_d.official_goods_name,";
    $data_sql .= "    t_aorder_d.num,";
    $data_sql .= "    t_aorder_d.cost_price,";
    $data_sql .= "    t_aorder_d.sale_price,";
    $data_sql .= "    t_aorder_d.cost_amount,";          
    #2009-10-13 hashimoto-y
    #$data_sql .= "    t_aorder_d.sale_amount ";
    $data_sql .= "    t_aorder_d.sale_amount, ";
    $data_sql .= "    t_goods.discount_flg ";

    $data_sql .= "FROM ";
    $data_sql .= "    t_aorder_d ";
    $data_sql .= "    INNER JOIN t_aorder_h ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
    //処理状況が日次更新後ではない the process status is not after the daily update
    #2010-03-31 hashimoto-y
    #if($ps_stat != '4'){
    #    $data_sql .= "    INNER JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id ";
    #}
    $data_sql .= "    INNER JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id ";

    $data_sql .= "WHERE ";
    $data_sql .= "    t_aorder_d.aord_id = ".$aord_id[$s];
    $data_sql .= " AND ";
    $data_sql .= "    t_aorder_h.shop_id = $shop_id ";
    $data_sql .= "ORDER BY ";
    $data_sql .= "    t_aorder_d.line;";

    $result = Db_Query($db_con,$data_sql);
    /****************************/
    //受注データー表示 display order data
    /****************************/
    //行項目部品を作成 create the row item component 
    $row_item = Get_Ord_Item($fc_ord_id);
    //行データ部品を作成 create the row data component
    $row_data = Get_Data($result);

    $sale_money                    =   number_format($h_data_list[0][15]);                     //税抜金額 amount without tax
    $tax_money                     =   number_format($h_data_list[0][16]);                     //消費税 consumption tax
    $st_money                      =   $h_data_list[0][15] + $h_data_list[0][16];              //税込金額 amount with tax
    $st_money                      =   number_format($st_money);

    /****************************/
    //ヘッダーHTML作成 create HTML header 
    /****************************/
    //グリーン指定されているか is it green assigned?
    if($h_data_list[0][4] == 't'){
        $green_flg = "グリーン指定あり　";
    }else{
        $green_flg = null;
    }

    //日付形式変更 change the format of the date
    $form_sale_day                                 =   explode('-',$h_data_list[0][1]);
    $form_hope_day                                 =   explode('-',$h_data_list[0][2]);
    $form_arr_day                                  =   explode('-',$h_data_list[0][3]);

    $html .= "<tr>";
    $html .= "<td>";
/*
    $html .= "<table  class=\"Data_Table\" border=\"1\" width=\"650\">";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>受注番号</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][0]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>得意先</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][6]."  -  ".$h_data_list[0][7]."　".$h_data_list[0][8]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>受注日</b></td>";
    $html .= "<td class=\"Value\">".$form_sale_day[0]." - ".$form_sale_day[1]." - ".$form_sale_day[2]."</td>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>希望納期</b></td>";
    if($form_hope_day[0] != NULL){
        $html .= "<td class=\"Value\">".$form_hope_day[0]." - ".$form_hope_day[1]." - ".$form_hope_day[2]."</td>";
    }else{
        $html .= "<td class=\"Value\">　</td>";
    }
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>出荷予定日</b></td>";
    if($form_arr_day[0] != NULL){
        $html .= "<td class=\"Value\" colspan=\"3\">".$form_arr_day[0]." - ".$form_arr_day[1]." - ".$form_arr_day[2]."</td>";
    }else{
        $html .= "<td class=\"Value\" colspan=\"3\">　</td>";
    }
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>運送業者</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$green_flg."　".$h_data_list[0][5]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>直送先</b></td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][9]."</td>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>出荷倉庫</b></td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][10]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>取引区分</b></td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][11]."</td>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>担当者</b></td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][12]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>通信欄<br>（得意先宛）</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][13]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>通信欄<br>（本部宛）</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][14]."</td>";
    $html .= "</tr>";
    $html .= "</table>";
*/
    $html .= "<table class=\"Data_Table\" border=\"1\">";
    $html .= "<col width=\"110\" style=\"font-weight: bold;\">";
    $html .= "<col>"; 
    $html .= "<col width=\"60\" style=\"font-weight: bold;\">";
    $html .= "<col>"; 
    $html .= "<col width=\"90\" style=\"font-weight: bold;\">";
    $html .= "<col>"; 
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">受注番号</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][0]."</td>";
    $html .= "<td class=\"Title_Blue\">得意先</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][6]."  -  ".$h_data_list[0][7]."　".$h_data_list[0][8]."</td>";
    $html .= "<td class=\"Title_Blue\">受注日</td>";
    $html .= "<td class=\"Value\">".$form_sale_day[0]." - ".$form_sale_day[1]." - ".$form_sale_day[2]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">運送業者</td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$green_flg.$h_data_list[0][5]."</td>";
    $html .= "<td class=\"Title_Blue\">希望納期</td>";
    if($form_hope_day[0] != NULL){
        $html .= "<td class=\"Value\">".$form_hope_day[0]." - ".$form_hope_day[1]." - ".$form_hope_day[2]."</td>";
    }else{
        $html .= "<td class=\"Value\">　</td>";
    }
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">直送先</td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][9]."</td>";
    $html .= "<td class=\"Title_Blue\">出荷予定日</td>";
    if($form_arr_day[0] != NULL){
        $html .= "<td class=\"Value\">".$form_arr_day[0]." - ".$form_arr_day[1]." - ".$form_arr_day[2]."</td>";
    }else{
        $html .= "<td class=\"Value\">　</td>";
    }
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">取引区分</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][11]."</td>";
    $html .= "<td class=\"Title_Blue\">担当者</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][12]."</td>";
    $html .= "<td class=\"Title_Blue\">出荷倉庫</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][10]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">通信欄<br>（得意先宛）</td>";
    $html .= "<td class=\"Value\" colspan=\"5\">".$h_data_list[0][13]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">通信欄<br>（本部宛）</td>";
    $html .= "<td class=\"Value\" colspan=\"5\">".$h_data_list[0][14]."</td>";
    $html .= "</tr>";
    $html .= "</table>";

    $html .= "<br>";
    $html .= "</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td>";
    /****************************/
    //データHTML作成 create data HTML 
    /****************************/
    //項目作成 create items
    $html .= "<table class=\"List_Table\" border=\"1\" width=\"100%\">";
    $html .= "<tr align=\"center\">";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][0]."</b></td>";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][1]."</b></td>";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][2]."</b></td>";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][3]."</b></td>";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][4]."</b></td>";
    $html .= "</tr>";

    //データ作成 create date
    $num = 1;
    for($x=0;$x<count($row_data);$x++){
        if($row_data[$x][7] == 't'){
            $html .= "<tr class=\"Result1\">";
            $html .=    "<td align=\"right\" style=\"color: red\">$num</td>";
            $html .=    "<td align=\"left\" style=\"color: red\">".$row_data[$x][0]."<br>".$row_data[$x][1]."</td>";
            $html .=    "<td align=\"right\" style=\"color: red\">".number_format($row_data[$x][2])."</td>";
            $html .=    "<td align=\"right\" style=\"color: red\">".number_format($row_data[$x][3],2)."<br>".number_format($row_data[$x][4],2)."</td>";
            $html .=    "<td align=\"right\" style=\"color: red\">".number_format($row_data[$x][5])."<br>".number_format($row_data[$x][6])."</td>";
            $html .= "</tr>";
        }else{
            $html .= "<tr class=\"Result1\">";
            $html .=    "<td align=\"right\">$num</td>";
            $html .=    "<td align=\"left\">".$row_data[$x][0]."<br>".$row_data[$x][1]."</td>";
            $html .=    "<td align=\"right\">".number_format($row_data[$x][2])."</td>";
            $html .=    "<td align=\"right\">".number_format($row_data[$x][3],2)."<br>".number_format($row_data[$x][4],2)."</td>";
            $html .=    "<td align=\"right\">".number_format($row_data[$x][5])."<br>".number_format($row_data[$x][6])."</td>";
            $html .= "</tr>";
        }
        $num++;
    }
    $html .= "</table>";
    /****************************/
    //合計HTML作成 create total HTML
    /****************************/
    $html .= "<table width=\"100%\">";
    $html .= "<tr>";
    $html .= "<td align=\"right\">";
    $html .= "<table class=\"List_Table\" border=\"1\">";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Pink\" width=\"70\" align=\"center\"><b>税抜金額</b></td>";
    $html .= "<td class=\"Value\" width=\"100\" align=\"right\">$sale_money</td>";
    $html .= "<td class=\"Title_Pink\" width=\"70\" align=\"center\"><b>消費税</b></td>";
    $html .= "<td class=\"Value\" width=\"100\" align=\"right\">$tax_money</td>";
    $html .= "<td class=\"Title_Pink\" width=\"70\" align=\"center\"><b>税込金額</b></td>";
    $html .= "<td class=\"Value\" width=\"100\" align=\"right\">$st_money</td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "</td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "</td>";
    $html .= "</tr>";
}


/****************************/
//部品定義 component definition
/****************************/
//遷移元チェック check the where it transitioned from
if($input_flg == true && $ps_stat != '4'){
    //受注入力画面 order input screen
    //OKボタン ok button
    $form->addElement("button", "ok_button", "Ｏ　Ｋ",
        "onClick=\"location.href='".Make_Rtn_Page("aord")."'\""
    );

    //オンライン・オフライン判定 determin if online or offline    
    $sql  = "SELECT";
    $sql .= "   CASE ";
    $sql .= "       WHEN fc_ord_id IS NOT NULL THEN 't'";
    $sql .= "       ELSE 'f'";
    $sql .= "   END ";
    $sql .= "FROM";
    $sql .= "   t_aorder_h ";
    $sql .= "WHERE";
    $sql .= "   aord_id = $aord_id[0]";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $online_div = (pg_fetch_result($result, 0,0) == 't')? true: false;

    if($online_div === true){    
        //戻る back
        $form->addElement("button","return_button","戻　る","onClick=\"location.href='1-2-110.php?aord_id=".$aord_id[0]."'\""); 
    }else{
        //戻る back
		//rev.1.2 受注入力オフライン後の戻るボタン削除 delete the back button after offline order input
        //$form->addElement("button","return_button","戻　る","onClick=\"location.href='1-2-101.php?aord_id=".$aord_id[0]."'\""); 
    }
    $freeze_flg = true;    //受注完了メッセージ表示フラグ flag display order completion message 

}else{
    //OKボタン ok button
    if ($fc_ord_id != null){
        $form->addElement("button", "ok_button", "Ｏ　Ｋ",
            "onClick=\"Submit_Page('".Make_Rtn_Page("aord")."');\""
        );
    }
    if($del_flg != true && $aord_del_flg != true && $fc_ord_id == null){
        //戻る back
        $form->addElement("button","return_button","戻　る","onClick=\"javascript:history.back()\"");
    }
}


/****************************/
//HTMLヘッダ HTML header 
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ HTML footer 
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu
/****************************/
$page_menu = Create_Menu_h('sale','1');

/****************************/
//画面ヘッダー作成 create screen header 
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定 render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variable
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign other variable
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html'          => "$html",
    'freeze_flg'    => "$freeze_flg",
));

//テンプレートへ値を渡す pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
s