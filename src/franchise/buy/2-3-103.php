<?php
/********************************/
//  変更履歴
//      取引先コード２を抽出しないように変更
//
//    (2006-07-07 kaji)
//      shop_gidをなくす
//    2006/11/29  出荷予定数が受注数を満たない発注だと表示がおかしくなるのを修正
/********************************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/11　06-092　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-093　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-094　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-053　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-054　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-055　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-095　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-096　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-058　　　　watanabe-k　GETチェック追加
 * 　2006/02/06　      　　　　watanabe-k　発信日を表示しないように修正
 * 　2007/08/28　      　　　　watanabe-k　入荷数の抽出のCOUNTをSUMに修正
 * 　2009/08/28　      　　　  aoyama-n    通信欄を表示　
 * 　2009/09/18　      　　　  aoyama-n    値引商品の場合は赤字で表示　
 *
 */


$page_title = "発注照会";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);


/****************************/
//クエリ実行関数
/****************************/
//(クエリー結果・強制完了フラグ・処理状況・発注ID・DBコネクション)
function Get_Ord_Data($result,$finish_flg,$ord_stat,$ord_id,$db_con,$discount_flg){
    $result_count = pg_numrows($result);   //要素数
    $day_flg      = false;                 //連結フラグ
    $num          = 1;                     //連結行数

    //発注データID取得
    $data_sql  = "SELECT ";
    $data_sql .= "    t_order_d.ord_d_id ";
    $data_sql .= "FROM ";
    $data_sql .= "    t_order_d ";
    $data_sql .= "    LEFT JOIN ";
    $data_sql .= "        (SELECT";
    $data_sql .= "            t_aorder_d.goods_id,";
    $data_sql .= "            t_aorder_h.arrival_day ";
    $data_sql .= "        FROM ";
    $data_sql .= "            t_aorder_h ";
    $data_sql .= "        INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
    $data_sql .= "        WHERE ";
    $data_sql .= "            t_aorder_h.fc_ord_id = $ord_id";
    $data_sql .= "        GROUP BY \n";
    $data_sql .= "            t_aorder_d.goods_id, \n";
    $data_sql .= "            t_aorder_h.arrival_day \n";
    $data_sql .= "        )AS t_aorder ";
    $data_sql .= "    ON t_order_d.goods_id = t_aorder.goods_id ";  
    $data_sql .= "    LEFT JOIN ";
    $data_sql .= "    (SELECT";        
    $data_sql .= "        ord_d_id,";
//    $data_sql .= "        COUNT(num) AS buy_num";
    $data_sql .= "        SUM(num) AS buy_num";
    $data_sql .= "    FROM ";    
    $data_sql .= "        t_buy_d";
    $data_sql .= "    GROUP BY ord_d_id";    
    $data_sql .= "    ) AS t_buy_d";    
    $data_sql .= "    ON t_order_d.ord_d_id = t_buy_d.ord_d_id ";
    $data_sql .= "WHERE ";
    $data_sql .= "    t_order_d.ord_id = $ord_id ";
    $data_sql .= "ORDER BY ";
    $data_sql .= "    t_order_d.line;";
    $dresult = Db_Query($db_con,$data_sql);
    $id_list = Get_Data($dresult);

    for($i = 0; $i < $result_count; $i++){
        $ord_data[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
        //連結した行は非表示
        if($day_flg == true){
            $row[$i-1] = NULL;
            $day_flg = false;
        }
        //行の色指定
        //aoyama-n 2009-09-18
        if($discount_flg[$i] === 't'){
            $font_color = 'color: red; ';
        }else{
            $font_color = 'color: #555555; ';
        }
        #$row[$i][0] = "<tr class=\"Result1\">";
        $row[$i][0] = "<tr class=\"Result1\"i style=\"$font_color\">";

        for($j=0;$j<count($ord_data[$i]);$j++){
            //発注数
            if($j==2){
                $ord_data[$i][$j] = number_format($ord_data[$i][$j]);
                $ord_array = $ord_data[$i][$j];
            //仕入単価
            }else if($j==3){
                $ord_data[$i][$j] = number_format($ord_data[$i][$j],2);
                $ord_array = $ord_data[$i][$j];
            //仕入金額
            }else if($j==4){
                $ord_data[$i][$j] = number_format($ord_data[$i][$j]);
                $ord_array = $ord_data[$i][$j];
            //本部出荷予定日
            }else if($j==5 && $ord_stat=='2'){
                //商品コードと発注データIDが同じ間、本部出荷予定日を連結する
                if($row[$i-$num][1]==$ord_data[$i][0] && $idrow[$i-$num]==$id_list[$i][0]){
                    //前の行と同じ場合連結する
                    $ord_data[$i][$j] = htmlspecialchars($ord_data[$i][$j]);
                    $row[$i-$num][$j+1] = $row[$i-$num][$j+1]."<br>".$ord_data[$i][$j];
                    //連結した行は表示しない
                    $day_flg = true;
                    $num++;
                }else{
                    $num = 1;
                    $ord_array = $ord_data[$i][$j];
                }
            //発注完了理由
            }else if($j==7 || $j==8){
                if($ord_data[$i][$j] == NULL){
                    $ord_array = "　";
                }else{
                    $ord_array = $ord_data[$i][$j];
                }
            }else{
                $ord_array = $ord_data[$i][$j];
            }

            if($day_flg == false){
                $row[$i][$j+1] = htmlspecialchars($ord_array);
            }
        }
        //発注データID
        $idrow[$i] = $id_list[$i][0];
    }
    //最終行が連結した行か
    if($day_flg == true){
        $row[$i-1] = NULL;
    }

    //NULLの行は配列に入れない
    for($i = 0; $i < count($row); $i++){
        if($row[$i]!=null){
            $row_data[] = $row[$i];
        }
    }

    return $row_data;
}

/****************************/
//データ項目作成関数
/****************************/
//(強制完了フラグ・処理状況)
function Get_Ord_Item($finish_flg,$ord_stat){
    //強制フラグがtrueか
    if($finish_flg == 't'){
        //発注状況が発注受付か
        if($ord_stat == '2'){
            //�ゞ�制完了フラグ＝ｔ ＆ 発注状況が発注受付　の場合
            $row_item[] = array("No.","商品コード<br>商品名","発注数","仕入単価","仕入金額","本部出荷予定日","入荷数","発注残","発注完了理由");
        }else{
            //��強制完了フラグ＝ｔ　の場合
            $row_item[] = array("No.","商品コード<br>商品名","発注数","仕入単価","仕入金額","入荷数","発注残","発注完了理由");
        }
    }else{
        //発注状況が発注受付か
        if($ord_stat == '2'){
            //�６�制完了フラグ＝ｆ ＆ 発注状況が発注受付　の場合
            $row_item[] = array("No.","商品コード<br>商品名","発注数","仕入単価","仕入金額","本部出荷予定日");
        }else{
            //�ざ�制完了フラグ＝ｆ　の場合
            $row_item[] = array("No.","商品コード<br>商品名","発注数","仕入単価","仕入金額");
        }
    }

    return $row_item;
}

//アウトプットフラグがtrueの場合のみ
if($_GET[output_flg] == 'true'){
    /****************************/
    //発注書発行処理
    /****************************/
    $order_sheet  = " function Order_Sheet(hidden1,ord_id,head_flg){\n";
    $order_sheet .= "   var id = ord_id;\n";
    $order_sheet .= "   var hdn1 = hidden1;\n";
    $order_sheet .= "   if(head_flg == 't'){\n";
    $order_sheet .= "       window.open('../../franchise/buy/2-3-105.php?ord_id='+id,'_blank','');\n";
    $order_sheet .= "   }else{\n";
    $order_sheet .= "       window.open('../../franchise/buy/2-3-107.php?ord_id='+id,'_blank','');\n";
    $order_sheet .= "   }\n";
    $order_sheet .= "   document.dateForm.elements[hdn1].value = ord_id;\n";
    $order_sheet .= "   //同じウィンドウで遷移する\n";
    $order_sheet .= "   document.dateForm.target=\"_self\";\n";
    $order_sheet .= "   //自画面に遷移する\n";
    $order_sheet .= "   document.dateForm.action='#';\n";
    $order_sheet .= "   //POST情報を送信する\n";
    $order_sheet .= "   document.dateForm.submit();\n";
    $order_sheet .= "   return true;\n";
    $order_sheet .= "}\n";
}

/****************************/
//外部変数取得
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
//$shop_gid     = $_SESSION[shop_gid];
$ord_id       = $_GET["ord_id"];             //発注ID
Get_Id_Check3($ord_id);
Get_Id_Check2($ord_id);
$online_flg   = $_GET["online_flg"];         //発注入力オンライン識別フラグ
$offline_flg  = $_GET["offline_flg"];        //発注入力オフライン識別フラグ
$ord_flg      = $_GET["ord_flg"];            //発注照会識別フラグ
$output_flg   = $_GET["output_flg"];         //発注書出力フラグ

/****************************/
//部品定義
/****************************/

//発信日
$form->addElement(
    "text","form_send_date","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);


//発注日
$text="";
$text[] =& $form->createElement("static","y","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","-");
$form->addGroup( $text,"form_ord_time","form_ord_time");


//入荷予定日
$text="";
$text[] =& $form->createElement("static","y","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","-");
$form->addGroup( $text,"form_arrival_day","form_arrival_day");

//希望納期
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_hope_day","form_hope_day");
    
//発注番号
$form->addElement("static","form_ord_no","","");

//仕入先名
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//直送先名
$form->addElement("static","form_direct_name","","");
//仕入倉庫
$form->addElement("static","form_ware_name","","");
//取引区分
$form->addElement("static","form_trade_ord","","");
//担当者
$form->addElement("static","form_c_staff_name","","");
//通信欄（仕入先宛）
$form->addElement("static","form_note_my","","");
//通信欄（本部宛）
$form->addElement("static","form_note_your","","");

//売上金額合計
$form->addElement(
    "text","form_buy_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//消費税額(合計)
$form->addElement(
        "text","form_buy_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//売上金額（税込合計)
$form->addElement(
        "text","form_buy_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

if($_GET[output_flg] != "delete" && $_GET[output_flg] != "finish"){
    //発注書出力
    $first_list  = " SELECT ";
    $first_list .= " t_client.head_flg ";
    $first_list .= " FROM ";
    $first_list .= " t_order_h ";
    $first_list .= " INNER JOIN ";
    $first_list .= " t_client ";
    $first_list .= " ON t_order_h.client_id = t_client.client_id ";
    $first_list .= " WHERE ";
    if($online_flg == 'true'){
        $first_list .= " t_order_h.ord_stat IS NOT NULL";
        $first_list .= "    AND";
    }elseif($offline_flg == 'true'){
        $first_list .= " t_order_h.ord_stat IS NULL";
        $first_list .= "    AND";
    }elseif($ord_flg == 'true'){
        $first_list .= " (t_order_h.ord_stat != '3'";
        $first_list .= " OR";
        $first_list .= " t_order_h.ord_stat IS NULL)";
        $first_list .= " AND";
    }
    $first_list .= "    t_order_h.shop_id = $shop_id";
    $first_list .= "    AND";
    $first_list .= "    t_order_h.ord_id = $ord_id;";
    $result = Db_Query($db_con, $first_list);
    Get_Id_Check($result);
    $head_flg = pg_fetch_result($result,0,0);
}

//onLoad処理
//発注書出力ボタンが押されて遷移してきた場合に出力
if($output_flg  == true && $_GET[output_flg] != "delete" && $_GET[output_flg] != "finish"){
    $load = "onLoad=\"javascript:Order_Sheet('order_sheet_id',$ord_id,'$head_flg');\"";
}

//発注書発行ID
$form->addElement("hidden", "order_sheet_id");

//遷移元チェック
if($online_flg == true){
    //発注入力（オンライン）画面
    //OKボタン
    $form->addElement("button", "ok_button", "Ｏ　Ｋ", "onClick=\"location.href='".Make_Rtn_Page("ord")."'\"");
    $warning = "変更する際には、本部に取消を依頼して下さい。";
    $freeze_flg = true;    //発注完了メッセージ表示フラグ
}else if($offline_flg == true){
    //発注入力（オフライン）画面
    //OKボタン
    $form->addElement("button", "ok_button", "Ｏ　Ｋ", "onClick=\"location.href='".Make_Rtn_Page("ord")."'\"");
    //戻る
    $form->addElement("button", "return_button", "戻　る", "onClick=\"location.href='2-3-102.php?ord_id=$ord_id'\"");
    $freeze_flg = true;    //発注完了メッセージ表示フラグ
}else{
    //発注照会画面
    if($ord_flg == true){
        //戻る
        $form->addElement("button", "return_button", "戻　る", "onClick=\"Submit_Page('".Make_Rtn_Page("ord")."')\"");
    }else{
        //戻る
        $form->addElement("button","return_button","戻　る","onClick=\"javascript:history.back()\"");
    }
}

/****************************/
//発注書発行ボタン押下処理
/****************************/
if($_POST["order_sheet_id"]!=NULL){

    Db_Query($db_con, "BEGIN");

    $flg_update  = " UPDATE ";
    $flg_update .= "    t_order_h ";
    $flg_update .= "    SET ";
    $flg_update .= "    ord_sheet_flg = 't' ";
    $flg_update .= "    where ";
    $flg_update .= "    ord_id = ".$_POST["order_sheet_id"];
    $flg_update .= ";";

    //該当データ件数
    $result = @Db_Query($db_con, $flg_update);
    if($result == false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }
    Db_Query($db_con, "COMMIT");

    $load = NULL;
}

if($_GET[output_flg] != "delete" && $_GET[output_flg] != "finish"){

    /****************************/
    //発注ヘッダー抽出判定処理
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    ord_stat,";
    $sql .= "    ps_stat,";
    $sql .= "    finish_flg ";
    $sql .= "FROM ";
    $sql .= "    t_order_h ";
    $sql .= "WHERE ";
    $sql .= "    t_order_h.ord_id = $ord_id;";
    $result = Db_Query($db_con,$sql);
    //GETデータ判定
    Get_Id_Check($result);

    //発注状況取得
    $ord_stat = pg_fetch_result($result,0,0);
    //処理状況取得
    $ps_stat = pg_fetch_result($result,0,1);
    //強制完了フラグ取得
    $finish_flg = pg_fetch_result($result,0,2);

    //処理状況が日次更新後か
    if($ps_stat == '4'){
        /****************************/
        //発注ヘッダ抽出SQL（処理状況が日次更新後）
        /****************************/
        $sql  = "SELECT ";
        $sql .= "    t_order_h.ord_no,";
        $sql .= "    to_char(t_order_h.ord_time, 'yyyy-mm-dd'),";                        
        $sql .= "    t_order_h.hope_day,";
        $sql .= "    t_order_h.arrival_day,";
        $sql .= "    t_order_h.green_flg,";
        $sql .= "    t_order_h.trans_name,";
        $sql .= "    t_order_h.client_cd1,";
//      $sql .= "    t_order_h.client_cd2,";
        $sql .= "    t_order_h.client_cname,";
        $sql .= "    t_order_h.direct_name,";
        $sql .= "    t_order_h.ware_name,";
        $sql .= "    CASE t_order_h.trade_id";            
        $sql .= "        WHEN '21' THEN '掛仕入'";
        $sql .= "        WHEN '71' THEN '現金仕入'";
        $sql .= "    END,";
        $sql .= "    t_order_h.c_staff_name,";
        $sql .= "    t_order_h.note_my,";
        $sql .= "    t_order_h.note_your, ";
        $sql .= "    t_order_h.net_amount, ";
        $sql .= "    t_order_h.tax_amount, ";
        $sql .= "    to_char(t_order_h.send_date, 'yyyy-mm-dd hh24:mi') ";
        $sql .= "FROM ";
        $sql .= "    t_order_h ";
        $sql .= "WHERE ";
        $sql .= "    t_order_h.ord_id = $ord_id;";
    }else{
        /****************************/
        //発注ヘッダー抽出SQL
        /****************************/
        $sql  = "SELECT ";
        $sql .= "    t_order_h.ord_no,";
        $sql .= "    to_char(t_order_h.ord_time, 'yyyy-mm-dd'),";                        
        $sql .= "    t_order_h.hope_day,";
        $sql .= "    t_order_h.arrival_day,";
        $sql .= "    t_order_h.green_flg,";
//    $sql .= "    t_trans.trans_name,";
//  $sql .= "    t_client.client_cd1,";
//    $sql .= "    t_client.client_name,";
//    $sql .= "    t_direct.direct_name,";
//    $sql .= "    t_ware.ware_name,";
        $sql .= "    t_order_h.trans_name,";
        $sql .= "    t_order_h.client_cd1,";
        $sql .= "    t_order_h.client_cname,";
        $sql .= "    t_order_h.direct_name,";
        $sql .= "    t_order_h.ware_name,";
        $sql .= "    CASE t_order_h.trade_id";            
        $sql .= "        WHEN '21' THEN '掛仕入'";
        $sql .= "        WHEN '71' THEN '現金仕入'";
        $sql .= "    END,";
//    $sql .= "    t_staff.staff_name,";
        $sql .= "    t_order_h.c_staff_name,";
        $sql .= "    t_order_h.note_my,";
        $sql .= "    t_order_h.note_your,";
        $sql .= "    t_order_h.net_amount, ";
        $sql .= "    t_order_h.tax_amount, ";
        $sql .= "    to_char(t_order_h.send_date, 'yyyy-mm-dd hh24:mi') ";
        $sql .= "FROM ";
        $sql .= "    t_order_h ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_trans  ";
        $sql .= "    ON t_order_h.trans_id   = t_trans.trans_id ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_direct ";
        $sql .= "    ON t_order_h.direct_id  = t_direct.direct_id ";

        $sql .= "    INNER JOIN t_client ON t_order_h.client_id  = t_client.client_id ";
        $sql .= "    INNER JOIN t_ware   ON t_order_h.ware_id    = t_ware.ware_id ";
        $sql .= "    INNER JOIN t_staff  ON t_order_h.c_staff_id = t_staff.staff_id ";
        $sql .= "WHERE ";
        $sql .= "    t_order_h.ord_id = $ord_id;";
    }
    $result = Db_Query($db_con,$sql);
    $h_data_list = Get_Data($result);
}
//aoyama-n 2009-08-28
//本部からの通信欄を抽出
$sql  = "SELECT ";
$sql .= "    t_aorder_h.note_your ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "WHERE ";
$sql .= "    t_aorder_h.fc_ord_id = $ord_id ";
$sql .= "ORDER BY t_aorder_h.arrival_day;";

$result = Db_Query($db_con,$sql);
$array_note_head = Get_Data($result);

//強制完了フラグがtrueか
if($finish_flg == 't'){
    //発注状況が発注受付か
    if($ord_stat == '2'){
        /****************************/
        //発注データ+(出荷予定日・入荷数・発注残・発注完了理由) 抽出SQL
        //�ゞ�制完了フラグ＝ｔ ＆ 発注状況が発注受付　の場合
        /****************************/
        $data_sql  = "SELECT ";
        //処理状況が日次更新後か
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd,";
        }else{
//            $data_sql .= "    t_goods.goods_cd,";
            $data_sql .= "    t_order_d.goods_cd,";
        }
        $data_sql .= "    t_order_d.goods_name,";
        $data_sql .= "    t_order_d.num,";            
        $data_sql .= "    t_order_d.buy_price,";
        $data_sql .= "    t_order_d.buy_amount,";
        $data_sql .= "    t_aorder.arrival_day,";
        $data_sql .= "    COALESCE(t_buy_d.buy_num,0),";
        $data_sql .= "    t_order_d.num - COALESCE(t_buy_d.buy_num,0) AS ord_close_num,";
        $data_sql .= "    t_order_d.reason ";
        $data_sql .= "FROM ";
        $data_sql .= "    t_order_d ";

        $data_sql .= "    LEFT JOIN ";
        $data_sql .= "        (SELECT";
        $data_sql .= "            t_aorder_d.goods_id,";
        $data_sql .= "            t_aorder_h.arrival_day ";
        $data_sql .= "        FROM ";
        $data_sql .= "            t_aorder_h ";
        $data_sql .= "        INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
        $data_sql .= "        WHERE ";
        $data_sql .= "            t_aorder_h.fc_ord_id = $ord_id";
        $data_sql .= "        GROUP BY \n";
        $data_sql .= "            t_aorder_d.goods_id, \n";
        $data_sql .= "            t_aorder_h.arrival_day \n";
        $data_sql .= "        )AS t_aorder ";
        $data_sql .= "    ON t_order_d.goods_id = t_aorder.goods_id ";
          
        $data_sql .= "    LEFT JOIN ";
        $data_sql .= "    (SELECT";        
        $data_sql .= "        ord_d_id,";
//        $data_sql .= "        COUNT(num) AS buy_num";
        $data_sql .= "        SUM(num) AS buy_num";
        $data_sql .= "    FROM ";    
        $data_sql .= "        t_buy_d";
        $data_sql .= "    GROUP BY ord_d_id";    
        $data_sql .= "    ) AS t_buy_d";    
        $data_sql .= "    ON t_order_d.ord_d_id = t_buy_d.ord_d_id ";

        $data_sql .= "    INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id ";
        //処理状況が日次更新後ではない
        if($ps_stat != '4'){
            $data_sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
        }

        $data_sql .= "WHERE ";
        $data_sql .= "    t_order_d.ord_id = $ord_id ";
        $data_sql .= "AND ";
        $data_sql .= "    t_order_h.shop_id = $shop_id ";
        $data_sql .= "ORDER BY ";
        //処理状況が日次更新後か
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd;";
        }else{
//            $data_sql .= "    t_goods.goods_cd;";
            $data_sql .= "    t_order_d.goods_cd;";
        }
    }else{
        /****************************/
        //発注データ+(入荷数・発注残・発注完了理由) 抽出SQL
        //��強制完了フラグ＝ｔ　の場合
        /****************************/
        $data_sql  = "SELECT ";
        //処理状況が日次更新後か
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd,";
        }else{
//            $data_sql .= "    t_goods.goods_cd,";
            $data_sql .= "    t_order_d.goods_cd,";
        }
        $data_sql .= "    t_order_d.goods_name,";
        $data_sql .= "    t_order_d.num,";            
        $data_sql .= "    t_order_d.buy_price,";
        $data_sql .= "    t_order_d.buy_amount,";
        $data_sql .= "    COALESCE(t_buy_d.buy_num,0),";
        $data_sql .= "    t_order_d.num - COALESCE(t_buy_d.buy_num,0) AS ord_close_num,";
        $data_sql .= "    t_order_d.reason ";
        $data_sql .= "FROM ";
        $data_sql .= "    t_order_d ";
          
        $data_sql .= "    LEFT JOIN ";
        $data_sql .= "    (SELECT";        
        $data_sql .= "        ord_d_id,";
//        $data_sql .= "        COUNT(num) AS buy_num";
        $data_sql .= "        SUM(num) AS buy_num";
        $data_sql .= "    FROM ";    
        $data_sql .= "        t_buy_d";
        $data_sql .= "    GROUP BY ord_d_id";    
        $data_sql .= "    ) AS t_buy_d";    
        $data_sql .= "    ON t_order_d.ord_d_id = t_buy_d.ord_d_id ";

        $data_sql .= "    INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id ";

        //処理状況が日次更新後ではない
        if($ps_stat != '4'){
            $data_sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
        }

        $data_sql .= "WHERE ";
        $data_sql .= "    t_order_d.ord_id = $ord_id ";
        $data_sql .= "AND ";
        $data_sql .= "    t_order_h.shop_id = $shop_id ";
        $data_sql .= "ORDER BY ";
        //処理状況が日次更新後か
        if($ps_stat == '4'){
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }else{
//            $data_sql .= "    t_goods.goods_cd;";
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }
    }
}else{
    //発注状況が発注受付か
    if($ord_stat == '2'){
        /****************************/
        //発注データ+(出荷予定日) 抽出SQL
        //�６�制完了フラグ＝ｆ ＆ 発注状況が発注受付　の場合
        /****************************/
        $data_sql  = "SELECT ";
        //処理状況が日次更新後か
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd,";
        }else{
//            $data_sql .= "    t_goods.goods_cd,";
            $data_sql .= "    t_order_d.goods_cd,";
        }
        $data_sql .= "    t_order_d.goods_name,";
        $data_sql .= "    t_order_d.num,";            
        $data_sql .= "    t_order_d.buy_price,";
        $data_sql .= "    t_order_d.buy_amount, ";
        $data_sql .= "    t_aorder.arrival_day ";
        $data_sql .= "FROM ";
        $data_sql .= "    t_order_d ";

        $data_sql .= "    LEFT JOIN ";
        $data_sql .= "        (SELECT";
        $data_sql .= "            t_aorder_d.goods_id,";
        $data_sql .= "            t_aorder_h.arrival_day ";
        $data_sql .= "        FROM ";
        $data_sql .= "            t_aorder_h ";
        $data_sql .= "        INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
        $data_sql .= "        WHERE ";
        $data_sql .= "            t_aorder_h.fc_ord_id = $ord_id";
        $data_sql .= "        GROUP BY \n";
        $data_sql .= "            t_aorder_d.goods_id, \n";
        $data_sql .= "            t_aorder_h.arrival_day \n";
        $data_sql .= "        )AS t_aorder ";
        $data_sql .= "    ON t_order_d.goods_id = t_aorder.goods_id ";

        $data_sql .= "    INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id ";
        //処理状況が日次更新後ではない
        if($ps_stat != '4'){
            $data_sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
        }

        $data_sql .= "WHERE ";
        $data_sql .= "    t_order_d.ord_id = $ord_id ";
        $data_sql .= "AND ";
        $data_sql .= "    t_order_h.shop_id = $shop_id ";
        $data_sql .= "ORDER BY ";
        //処理状況が日次更新後か
        if($ps_stat == '4'){
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }else{
//            $data_sql .= "    t_goods.goods_cd;";
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }
    }else{
        /****************************/
        //発注データ抽出SQL
        //�ざ�制完了フラグ＝ｆ　の場合
        /****************************/
        $data_sql  = "SELECT ";
        //処理状況が日次更新後か
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd,";
        }else{
//            $data_sql .= "    t_goods.goods_cd,";
            $data_sql .= "    t_order_d.goods_cd,";
        }
        $data_sql .= "    t_order_d.goods_name,";
        $data_sql .= "    t_order_d.num,";            
        $data_sql .= "    t_order_d.buy_price,";
        $data_sql .= "    t_order_d.buy_amount ";
        $data_sql .= "FROM ";
        $data_sql .= "    t_order_d ";
        $data_sql .= "    INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id ";
        //処理状況が日次更新後ではない
        if($ps_stat != '4'){
            $data_sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
        }

        $data_sql .= "WHERE ";
        $data_sql .= "    t_order_d.ord_id = $ord_id ";
        $data_sql .= "AND ";
        $data_sql .= "    t_order_h.shop_id = $shop_id ";
        $data_sql .= "ORDER BY ";
        //処理状況が日次更新後か
        if($ps_stat == '4'){
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }else{
//            $data_sql .= "    t_goods.goods_cd;";
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }
    }
}
$result = Db_Query($db_con,$data_sql);

//aoyama-n 2009-09-18
//値引フラグ抽出
$sql  = "SELECT ";
$sql .= "    t_goods.discount_flg ";
$sql .= "FROM ";
$sql .= "    t_order_h INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id ";
$sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
$sql .= "WHERE ";
$sql .= "    t_order_d.ord_id = $ord_id ";
$sql .= "AND ";
$sql .= "    t_order_h.shop_id = $shop_id ";
$sql .= "ORDER BY ";
$sql .= "    t_order_d.line;";
$sql_result = Db_Query($db_con,$sql);
for($i = 0; $i < pg_numrows($sql_result); $i++){
    $discount_flg[] = pg_fetch_result ($sql_result, $i, "discount_flg");
}


/****************************/
//発注データー表示
/****************************/
//行項目部品を作成
$row_item = Get_Ord_Item($finish_flg,$ord_stat);
//行データ部品を作成
//aoyama-n 2009-09-18
#$row_data = Get_Ord_Data($result,$finish_flg,$ord_stat,$ord_id,$db_con);
$row_data = Get_Ord_Data($result,$finish_flg,$ord_stat,$ord_id,$db_con,$discount_flg);

/****************************/
//発注ヘッダー表示
/****************************/
//日付生成
$form_ord_date    = explode('-',$h_data_list[0][1]);
$form_hope_day    = explode('-',$h_data_list[0][2]);
$form_arrival_day = explode('-',$h_data_list[0][3]);

$def_fdata["form_send_date"]                    =   $h_data_list[0][16];                  //発信日
$def_fdata["form_ord_no"]                       =   $h_data_list[0][0];                   //発注No.

$def_fdata["form_ord_time"]["y"]                =   $form_ord_date[0];                    //発注日(年)
$def_fdata["form_ord_time"]["m"]                =   $form_ord_date[1];                    //発注日(月)
$def_fdata["form_ord_time"]["d"]                =   $form_ord_date[2];                    //発注日(日)

if($form_hope_day[0] != NULL){
    $def_fdata["form_hope_day"]["y"]            =   $form_hope_day[0]." -";               //希望納期(年)
    $def_fdata["form_hope_day"]["m"]            =   $form_hope_day[1]." -";               //希望納期(月)
    $def_fdata["form_hope_day"]["d"]            =   $form_hope_day[2];                    //希望納期(日)
}

$def_fdata["form_arrival_day"]["y"]             =   $form_arrival_day[0];                 //入荷予定日(年)
$def_fdata["form_arrival_day"]["m"]             =   $form_arrival_day[1];                 //入荷予定日(月)
$def_fdata["form_arrival_day"]["d"]             =   $form_arrival_day[2];                 //入荷予定日(日)

//グリーン指定＆運送業者部品作成
$text="";
//グリーン指定されているか
if($h_data_list[0][4] == 't'){
    $text[] =& $form->createElement("static","green_trans","","");
    $text[] =& $form->createElement("static","","","　");
    $def_fdata["form_trans"]["green_trans"]     =  ($h_data_list[0][4] == 't')? グリーン指定あり : null;
}
$text[] =& $form->createElement("static","trans_name","","");
$def_fdata["form_trans"]["trans_name"]          =   $h_data_list[0][5];                      //運送業者
$form->addGroup( $text,"form_trans","form_trans");
              
$def_fdata["form_client"]["cd1"]                =   $h_data_list[0][6];                      //仕入先    
//$def_fdata["form_client"]["cd2"]                =   $h_data_list[0][7];                          
$def_fdata["form_client"]["name"]               =   $h_data_list[0][7];                          

$def_fdata["form_direct_name"]                  =   $h_data_list[0][8];                      //直送先
$def_fdata["form_ware_name"]                    =   $h_data_list[0][9];                     //倉庫
$def_fdata["form_trade_ord"]                    =   $h_data_list[0][10];                     //取引区分
$def_fdata["form_c_staff_name"]                 =   $h_data_list[0][11];                     //担当者
//aoyama-n 2009-08-28
#$def_fdata["form_note_my"]                      =   $h_data_list[0][12];                     //通信欄(仕入先)
#$note_my                     =   $h_data_list[0][12];                     //通信欄(仕入先)
$def_fdata["form_note_my"]                      =   $h_data_list[0][13];                     //通信欄(仕入先宛のコメント)

$def_fdata["form_buy_total"]                    =   number_format($h_data_list[0][14]);      //税抜金額
$def_fdata["form_buy_tax"]                      =   number_format($h_data_list[0][15]);      //消費税
$total_money                                    =   $h_data_list[0][14] + $h_data_list[0][15];  //税込金額
$def_fdata["form_buy_money"]                    =   number_format($total_money);  
//aoyama-n 2009-08-28
$def_fdata["form_note_head"]                    =   $array_note_head;  


$form->setDefaults($def_fdata);

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
$page_menu = Create_Menu_f('buy','1');

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
    'offline_flg'   => "$offline_flg",
    'order_sheet'   => "$order_sheet",
    'load'          => "$load",
    //aoyama-n 2009-08-28 
    #'note_my'       => "$note_my",
    'freeze_flg'    => "$freeze_flg",
));
$smarty->assign('item',$row_item);
$smarty->assign('row',$row_data);
//aoyama-n 2009-08-28
//通信欄（ＦＣ宛）
$smarty->assign('note_head',$array_note_head);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
