<?php

/**
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      ban_0051    suzuki      担当者CDの検索条件修正
 *
 *
 * 概要 請求書に関するデータを取得する
 *
 * 説明 第5引数にcountが指定された場合は、一致する件数を返します。
 *
 * @param string   $db_con          DB接続リソース
 * @param string   $sale_amount     売上金額
 * @param string   $tax_amount      消費税額
 * @param array    $client_data     得意先の情報
 * @param string   $div             1:ロイヤリティ　2:一括消費税
 *
 *
 * @return 
 */
function Insert_Sale_Head ($db_con, $sale_amount, $tax_amount, $client_data, $div){

    //ロイヤリティの場合
    if($div == '1'){
        //■ロイヤリティ商品のデータ抽出　
        //[20-1] 商品コード
        //[20-2] 商品名
        //[20-3] ロイヤリティ　AS　ロイヤリティ区分
        //
        //■抽出条件
        //商品ID　=　1325
        //
        $sql  = "SELECT \n";
        $sql .= "   goods_id, \n";
        $sql .= "   goods_cd, \n";
        $sql .= "   goods_name \n";
        $sql .= "FROM \n";
        $sql .= "   t_goods \n";
        $sql .= "WHERE \n";
        $sql .= "   goods_cd = '0000002'\n";
        $sql .= "; \n";

    }else{
        //■一括消費税諸品のデータ抽出  
        $sql  = "SELECT \n";
        $sql .= "   goods_id, \n";
        $sql .= "   goods_cd, \n";
        $sql .= "   goods_name \n";
        $sql .= "FROM \n";
        $sql .= "   t_goods \n";
        $sql .= "WHERE \n";
        $sql .= "   goods_cd = '0000001'\n";
        $sql .= "; \n";
    }

    $result = Db_Query($db_con, $sql);
    $goods_data = pg_fetch_array($result);

    //配列の要素をそれぞれデータにセット
    $claim_close_day = $client_data[0];        //請求締日
    $c_client_id     = $client_data[1];        //得意先ID
    $bill_id         = $client_data[2];        //請求書ID
    $shop_id         = $client_data[3];        //ショップID

    $sql  = "INSERT INTO t_lump_amount(";
    $sql .= "   goods_id, ";
    $sql .= "   goods_name, ";
    $sql .= "   allocate_day, ";
    $sql .= "   client_id, ";
    $sql .= "   net_amount, ";
    $sql .= "   tax_amount, ";
    $sql .= "   data_div, ";
    $sql .= "   bill_id, ";
    $sql .= "   shop_id ";
    $sql .= ")VALUES( ";
    $sql .= "   ".$goods_data["goods_id"].",";
    $sql .= "   '".$goods_data["goods_name"]."',";
    $sql .= "   '".$claim_close_day."',";
    $sql .= "   ".$c_client_id.",";
    $sql .= "   ".$sale_amount.",";
    $sql .= "   ".$tax_amount.",";
    $sql .= "   '$div',";
    $sql .= "   ".$bill_id.",";
    $sql .= "   ".$shop_id."";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }
    return;
}


//画面に表示する作成履歴用にデータを形成
function Branch_Page_Data ($page_data, $now_date, $last_date, $db_con){

    $return_ary["last_date"] = $last_date;
    $return_ary["now_date"]  = $now_date;
/*
    $select_value = Select_Get($conn,'close');
    unset($select_value[null]);
    $return_ary["close_day"] = array_values($select_value);
*/
    //データ分ループ
    $i = 0;
    foreach($page_data AS $key => $val){

        //締日の配列
        if($val["close_day"] < 29){
            $close_day        = $val["close_day"];
            $val["close_day"] = $val["close_day"]."日";
        }else{
            $val["close_day"] = "月末";
            $close_day        = "月末";
        }

        if(@!in_array($val["close_day"],$return_ary["close_day"])){
            $return_ary["close_day"][$i] = $val["close_day"];
            $close_day_ary["close_day"][$i] = $close_day; 
        }

        //支店ごとに結果を纏める
        $return_ary["cd"][]                = $val["branch_cd"];
        $return_ary[$val["branch_cd"]]["name"] = htmlspecialchars($val["branch_name"]);
        $return_ary[$val["branch_cd"]]["data"][$val["close_day"]]["last"] = ($val["bill_close_day_last"] != NULL)? $val["bill_close_day_last"] : "-";
        $return_ary[$val["branch_cd"]]["data"][$val["close_day"]]["now"]  = ($val["bill_close_day_now"]  != NULL)? $val["bill_close_day_now"]  : "-";

        $i++;
    }

    //締め日をソート
    $i = 0;
    asort($close_day_ary["close_day"]);
    unset($return_ary["close_day"]);
    foreach($close_day_ary["close_day"] AS $key => $val){
        if($val != "月末"){
            $return_ary["close_day"][$i] = $val."日";
        }else{
            $return_ary["close_day"][$i] = $val;
        }
        $i++;
    }

    //重複除去
    $return_ary["cd"]   = array_values(array_unique($return_ary["cd"]));

    //支店数
    $return_ary["colspan"] = count($return_ary["cd"]);
    return $return_ary;
}

//月次更新以降かチェック
function Bill_Monthly_Renew_Check($db_con, $claim_close_day){
    $sql  = "SELECT";
    $sql .= "   COALESCE(MAX(close_day), '2005-01-01') AS renew_day ";
    $sql .= "FROM ";
    $sql .= "   t_sys_renew ";
    $sql .= "WHERE ";
    $sql .= "   shop_id = ".$_SESSION[client_id]." \n";
    $sql .= "   AND ";
    $sql .= "   renew_div = '2' \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $renew_day = pg_fetch_result($result, 0,0);

    if($renew_day >= $claim_close_day){
        return true;
    }

    return false;
}


//回収した請求データを更新する関数
function Collect_Bill_D_Update($db_con, $bill_id, $client_id, $claim_div, $collect_end_day){


    //回収した請求データを更新
    $sql  = "UPDATE \n";
    $sql .= "   t_bill_d \n";
    $sql .= "SET \n"; 


    //請求IDが０でない場合
    if($bill_id != 0){
        $sql .= "   collect_bill_d_id = (   SELECT \n";
        $sql .= "                               bill_d_id \n";
        $sql .= "                           FROM \n";
        $sql .= "                               t_bill_d \n";
        $sql .= "                           WHERE \n";
        $sql .= "                               t_bill_d.bill_id = $bill_id \n";
        $sql .= "                               AND \n";
        $sql .= "                               t_bill_d.client_id = $client_id \n";
        $sql .= "                               AND \n";
        $sql .= "                               t_bill_d.close_day IS NOT NULL \n";
        $sql .= "                       ) \n";
        $sql .= "WHERE  \n";
        $sql .= "   t_bill_d.bill_d_id IN ( SELECT \n";
        $sql .= "                               t_bill_d.bill_d_id \n";
        $sql .= "                           FROM \n";
        $sql .= "                               t_bill \n";
        $sql .= "                                   INNER JOIN \n";
        $sql .= "                               t_bill_d \n";
        $sql .= "                               ON t_bill.bill_id = t_bill_d.bill_id \n";
        $sql .= "                           WHERE \n";
        $sql .= "                               t_bill.collect_day <= '".$collect_end_day."'\n";
        $sql .= "                               AND\n";
        $sql .= "                               t_bill_d.client_id = $client_id\n";
        $sql .= "                               AND \n";
        $sql .= "                               t_bill_d.claim_div = '".$claim_div."'\n";
        $sql .= "                               AND \n";
        $sql .= "                               t_bill_d.close_day IS NOT NULL \n";
        $sql .= "                               AND \n";
        $sql .= "                               t_bill_d.collect_bill_d_id IS NULL \n";
        $sql .= "                           )\n";
        $sql .= ";\n"; 
    }else{
        $sql .= "   collect_bill_d_id = 0 \n";
        $sql .= "WHERE \n";
        $sql .= "   t_bill_d.client_id = $client_id \n";
        $sql .= "   AND \n";
        $sql .= "   t_bill_d.claim_div = '".$claim_div."' ";
        $sql .= "   AND \n";
        $sql .= "   t_bill_d.collect_bill_d_id IS NULL \n";
    } 



    $result = Db_Query($db_con, $sql);

    if($result === false){ 
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

}


//随時の日付補完JavaScript作成関数
function Create_Claim_Close_Day_Js($db_con){
    //請求先１で使用する
    $sql  = "SELECT \n";
    $sql .= "    client_cd1,   \n";
    $sql .= "    client_cd2,   \n";
    $sql .= "    client_cname, \n";
    $sql .= "    close_day \n";
    $sql .= "FROM \n";
    $sql .= "   (SELECT DISTINCT \n";
    $sql .= "       claim_id ";
    $sql .= "   FROM \n";
    $sql .= "       t_claim ";
    $sql .= "   ) AS t_claim ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_client ";
    $sql .= "   ON t_claim.claim_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   ";

    //本部の場合
    if($_SESSION["group_kind"] == '1'){
        $sql .= "   t_client.client_div = '3'";
        $sql .= "   AND ";
        $sql .= "   shop_id = $_SESSION[client_id] ";
    //FCの場合
    }else{
        $sql .= "   t_client.client_div = '1'";
        $sql .= "   AND ";
        $sql .= "   shop_id = $_SESSION[client_id] ";
    }

    $sql .= "; \n"; 

    $result = Db_Query($db_con, $sql);
    $row = pg_num_rows($result);

    $js   = "function Claim_Data_Set(code1,code2,name,day){\n";
    $js  .= "  data1 = new Array($row);\n";
    $js  .= "  data2 = new Array($row);\n";

    for($i=0;$i<$row;$i++){
        //code1取得
        $cd1 = pg_fetch_result($result,$i,0);
        //code2取得
        $cd2 = pg_fetch_result($result,$i,1);
        //name取得
        $name = pg_fetch_result($result,$i,2);
        $name = addslashes($name);
        //締日
        $close_day = pg_fetch_result($result,$i,3);        

        $js .= "  data1['$cd1-$cd2'] = \"$name\";\n";
        $js .= "  data2['$cd1-$cd2'] = \"$close_day\";\n";
    }

    $js .= "  var data1 = data1[document.dateForm.elements[code1].value+'-'+document.dateForm.elements[code2].value];\n";
    $js .= "  var data2 = data2[document.dateForm.elements[code1].value+'-'+document.dateForm.elements[code2].value];\n";

    $js .= "  if(data2 == '29'){";
    $js .= "    data2 = '月末';";
    $js .= "  }else{";
    $js .= "    data2 = data2+'日';";
    $js .= "  }";


    $js .= "  len1 = document.dateForm.elements[code1].value.length;\n";
    $js .= "  len2 = document.dateForm.elements[code2].value.length;\n";

    $js .= "  if(data1 == undefined){\n";
    $js .= "      document.dateForm.elements[name].value = \"\";\n";
    $js .= "  }else if(len1 == 6 && len2 == 4){\n";
    $js .= "      document.dateForm.elements[name].value = data1; \n";
    $js .= "      document.dateForm.elements[day].value = data2; \n";
    $js .= "  }\n";
    $js .= "}\n";

    return $js;
}


//前受金関数
//2007-09-03 watanabe-k 抽出期間が正しくないバグの修正
function Advance_Offset_Claim_Bill($db_con, $bill_close_day_last, $bill_close_day_this, $client_id, $claim_div){

    //前回の前受金残高額
    $sql  = "SELECT \n"; 
    $sql .= "   COALESCE(SUM(advance_balance), 0) AS advance_balance_last \n";
    $sql .= "FROM ";
    $sql .= "   t_bill_d ";
    $sql .= "WHERE ";
    $sql .= "   client_id = $client_id ";
    $sql .= "   AND ";
    $sql .= "   claim_div = '$claim_div' ";
    $sql .= "   AND ";
    $sql .= "   bill_close_day_this = '$bill_close_day_last' ";
    $sql .= "   AND ";
    $sql .= "   close_day IS NOT NULL \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    if(pg_num_rows($result) > 0){
        $advance_total_last = pg_fetch_result($result, 0,0);
    }else{
        $advance_total_last = 0;
    }

    //当月前受金の前受金合計
    $sql  = "SELECT \n";
    $sql .= "   COALESCE(SUM(amount), 0) AS advance_total \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_day > '$bill_close_day_last' \n";
    $sql .= "   AND \n";
    $sql .= "   pay_day <= '$bill_close_day_this' \n";
    $sql .= "   AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "   AND \n";
    $sql .= "   claim_div = '$claim_div' \n";
    $sql .= "   AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    
    if(pg_num_rows($result) > 0){
        $advance_total = pg_fetch_result($result, 0,0);
    }else{
        $advance_total = 0;
    }

    //当月の前受金相殺額
    $sql  = "SELECT \n";
    $sql .= "   COALESCE(SUM(t_payin_d.amount), 0) AS payin_total \n";  
    $sql .= "FROM \n";
    $sql .= "   t_payin_h \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_payin_d \n";
    $sql .= "   ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_day > '$bill_close_day_last' \n";
    $sql .= "   AND \n";
    $sql .= "   pay_day <= '$bill_close_day_this' \n";
    $sql .= "   AND \n";
    $sql .= "   t_payin_d.trade_id = '40' \n";
    $sql .= "   AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "   AND \n";
    $sql .= "   claim_div = '$claim_div' \n";
    $sql .= "   AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    
    if(pg_num_rows($result) > 0){
        $advance_payin_total = pg_fetch_result($result, 0,0);
    }else{
        $advance_payin_total = 0;
    }

    //今回前受金残高
    //今回前受金額 = 前回前受金残高額＋当月前受金額ー今回前受金相殺額
    $advance_total_this = $advance_total_last + $advance_total - $advance_payin_total;

    return array(
                "advance_total_this"    => $advance_total_this,     //今回前受金残高額
                "advance_total_last"    => $advance_total_last,     //前回前受金残高額
                "advance_total"         => $advance_total,          //当月前受金額
                "advance_payin_total"   => $advance_payin_total,    //当月前受金相殺額
            );
}


?>
