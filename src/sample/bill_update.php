<?php
/*****************************/
//  
//  
//
//
//
/*****************************/

require_once("ENV_local.php");

$db_con = Db_Connect();


if($_POST[submit] == "START"){



//得意先ごとの売掛残高額を抽出

$sql  = "SELECT";
$sql .= "   t_client.client_id,\n";     //得意先ID 
$sql .= "   claim_id,\n";               //請求先ID
$sql .= "   ar_balance \n";            //売掛残高
$sql .= "FROM\n";
$sql .= "   t_first_ar_balance \n";
$sql .= "       INNER JOIN\n";
$sql .= "   t_client\n";
$sql .= "   ON t_first_ar_balance.client_id = t_client.client_id \n";
$sql .= "       INNER JOIN\n";
$sql .= "   t_claim\n";
$sql .= "   ON t_client.client_id = t_claim.client_id \n";
$sql .= "WHERE\n";
//$sql .= "   t_client.shop_id IN (SELECT client_id FROM t_client WHERE rank_cd = '0003')\n";
$sql .= "   t_client.shop_id = 93\n";
$sql .= "   AND\n";
$sql .= "   t_claim.claim_div = 1\n";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);

$data = pg_fetch_all($result);

//請求先テーブルに登録
for($i = 0; $i < count($data); $i++){

    //既にレコードがあるか無いかを確認
    $sql  = "SELECT\n";    
    $sql .= "   t_bill_d.bill_d_id \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_bill_d\n";
    $sql .= "   ON t_bill.bill_id = t_bill_d.bill_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_bill.first_set_flg = 't'\n";
    $sql .= "   AND\n";
    $sql .= "   t_bill.shop_id = 93\n";
    $sql .= "   AND\n";
    $sql .= "   t_bill_d.client_id = ".$data[$i][client_id]."\n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $add_count = pg_num_rows($result);

    //既に存在する場合
    if($add_count > 0){

        $bill_d_id = pg_fetch_result($result, 0,0);

        $sql  = "UPDATE\n ";
        $sql .= "   t_bill_d\n ";
        $sql .= "SET\n";
        $sql .= "   bill_amount_this = ".$data[$i][ar_balance]."\n";
        $sql .= "WHERE\n";
        $sql .= "   t_bill_d.bill_id = ".$bill_d_id."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        print_array($sql);

    //存在しない場合は登録
    }else{

        //請求書番号抽出
        $sql  = "SELECT";
        $sql .= "   MAX(bill_no)\n";
        $sql .= "FROM";
        $sql .= "   t_bill\n";
        $sql .= "WHERE\n";
        $sql .= "   first_set_flg = 't'\n";
        $sql .= "   AND\n";
        $sql .= "   shop_id = 93\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        $max_no = pg_fetch_result($result,0,0)+1;            //抽出した連番を8桁になるように左側を0埋めする

        $claim_sheet_no = str_pad($max_no, 8, 0, STR_PAD_LEFT);

        $sql  = "INSERT INTO t_bill(\n";
        $sql .= "   bill_id,\n";              //請求ID
        $sql .= "   bill_no,\n";              //請求書番号
        $sql .= "   fix_flg,\n";              //確定フラグ
        $sql .= "   last_update_flg,\n";      //更新フラグ
        $sql .= "   last_update_day,\n";      //更新実施日
        $sql .= "   create_staff_name,\n";    //請求でデータ作成日
        $sql .= "   fix_day,\n";              //確定日
        $sql .= "   shop_id,\n";              //取引先ID
        $sql .= "   first_set_flg\n";         //残高設定フラグ
        $sql .= ")VALUES(\n";
        $sql .= "   (SELECT COALESCE(MAX(bill_id), 0)+1 FROM t_bill),\n";
        $sql .= "   '$claim_sheet_no',\n";
        $sql .= "   't',\n";
        $sql .= "   't',\n";
        $sql .= "   NOW(),\n";
        $sql .= "   '小松芳夫',\n";
        $sql .= "   NOW(),\n";
        $sql .= "   93,\n";
        $sql .= "   't'\n";
        $sql .= ");\n";

        $result = Db_Query($db_con, $sql);
        if($result === false){ 
            Db_Query($db_con, "ROLLBACK");
            exit;   
        }

        //請求データに登録
        $sql  = "INSERT INTO t_bill_d(\n";
        $sql .= "   bill_d_id,\n";
        $sql .= "   bill_id,\n";
        $sql .= "   bill_close_day_this,\n";
        $sql .= "   client_id,\n";
        $sql .= "   claim_div,\n";
        $sql .= "   bill_amount_this\n";
        $sql .= ")VALUES(\n";
        $sql .= "   (SELECT COALESCE(MAX(bill_d_id),0)+1 FROM t_bill_d),\n";
        $sql .= "   (SELECT\n";
        $sql .= "       bill_id\n";
        $sql .= "   FROM\n";
        $sql .= "       t_bill\n";
        $sql .= "   WHERE\n";
        $sql .= "       shop_id = 93\n";
        $sql .= "       AND\n";
        $sql .= "       bill_no = '$claim_sheet_no'\n";
        $sql .= "       AND\n";
        $sql .= "       first_set_flg = 't'\n";
        $sql .= "   ),\n";
        $sql .= "   '2005-10-31',\n";
        $sql .= "   ".$data[$i][client_id].",\n";
        $sql .= "   '1',\n";
        $sql .= "   ".$data[$i][ar_balance]."\n";
        $sql .= ");\n";

        print_array($sql);
        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
    }

}



}


?>

<html>
    <head>
        <title>aaaa</title>
    </head>
<body>

<form action="./bill_update.php" method="POST">
    <input type="submit" value="START" name="submit">
</form>

</body>
</html>







