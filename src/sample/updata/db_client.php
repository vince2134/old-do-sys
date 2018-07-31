<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");
require_once("file.fnc");

//DB接続
$db_con = Db_Connect("amenity_demo_new");

$file_name = "/usr/local/apache2/htdocs/amenity/src/sample/db_inport/tmp/toyo_client.txt";

$file = fopen($file_name, "r");

//行ループ
$j = 1;
while($file_data = fgets($file, "1000") ){

    $insert_data = explode(',',$file_data);

    //得意先コード１，２・ショップコード１，２
    $client_cd = explode("    ",$insert_data[0]);
    $client_cd[0] = trim($client_cd[0]);
    $client_cd[1] = trim($client_cd[1]);
    if($client_cd[1] == ''){
        $client_cd[1] = '0000';
    }

    //得意先名
    $client_name  = trim($insert_data[1]);

    //略称
    $client_cname = trim($insert_data[2]); 

    //住所
    $address = trim($insert_data[4]);

    //TEL
    $tel     = trim($insert_data[5]);

    //代表者
    $rep_name = trim($insert_data[8]);

    //郵便番号
    if($insert_data[3] != ""){
        $post_no1 = substr($insert_data[3], 0, 3);
        $post_no2 = substr($insert_data[3], 3, 4);
    }

    //状態
    if($insert_data[7] == '9'){
        $state = '2';       //取引休止
    }elseif($insert_data[7] == ''){
        $state = '1';
    }

    //締日
    if($insert_data[9] > 28){
        $close_day = 29;

        if($insert_data[9] == '91'){
            $trade_id = '61';
        }else{
            $trade_id = null;
        }
    }else{
        $close_day = $insert_data[9];
        $trade_id = null;
    }

    //伝票出力
    if($insert_data[12] == '1'){
        $slip_out = '2';
    }else{
        $slip_out = '1';
    }

    //請求書出力
    if($insert_data[13] == '1'){
        $claim_out = '3';
    }else{
        $claim_out = '1';
    }

    //丸め区分
    if($insert_data[14] == '5'){
        $coax = '2';
    }elseif($insert_data[14] == '9'){
        $coax = '3';
    }else{
        $coax = '1';
    }

    //端数区分
    if($insert_data[16] == '5'){
        $tax_franct = '2';
    }elseif($insert_data[16] == '9'){
        $tax_franct = '3';
    }else{
        $tax_franct = '1';
    }

    //課税単位
    if($insert_data[15] == '1'){
        $tax_div = '1';
    }else{
        $tax_div = '2';
    }

    //得意先マスタに登録
    $insert_sql  = "INSERT INTO t_client (";
    $insert_sql .= "    state,";
    $insert_sql .= "    create_day,";
    $insert_sql .= "    client_id,";                    //得意先ID
    $insert_sql .= "    shop_gid,";                     //FCグループID
    $insert_sql .= "    client_cd1,";                   //得意先コード
    $insert_sql .= "    client_cd2,";                   //支店コード
    $insert_sql .= "    client_name,";                  //ショップ名
    $insert_sql .= "    client_cname,";                 //略称
    $insert_sql .= "    post_no1,";                     //郵便番号１
    $insert_sql .= "    post_no2,";                     //郵便番号２
    $insert_sql .= "    address1,";                     //住所１
    $insert_sql .= "    rep_name,";                     //代表者
    $insert_sql .= "    tel,";                          //電話番号
    $insert_sql .= "    close_day,";                    //締日
    $insert_sql .= "    pay_m,";                        //支払日（月）
    $insert_sql .= "    pay_d,";                        //支払日（日）
    $insert_sql .= "    coax,";                         //丸め区分
    $insert_sql .= "    tax_franct,";                   //端数区分
    $insert_sql .= "    tax_div,";                       //課税単位 
    $insert_sql .= "    client_div,";
    $insert_sql .= "    shop_div,";
    $insert_sql .= "    slip_out,";
    if($trade_id != null){
        $insert_sql .= "    trade_id,";
    }
    $insert_sql .= "    claim_out,";
    $insert_sql .= "    area_id";
    $insert_sql .= ")VALUES(";
    $insert_sql .= "    '1',";
    $insert_sql .= "    now(),";
    $insert_sql .= "    (SELECT MAX(client_id)+1 FROM t_client),";
    $insert_sql .= "    43,";
    $insert_sql .= "    '$client_cd[0]',";              //得意先コード
    $insert_sql .= "    '$client_cd[1]',";              //支店コード
    $insert_sql .= "    '$client_name',";            //得意先名
    $insert_sql .= "    '$client_cname',";            //略称
    $insert_sql .= "    '$post_no1',";                  //郵便番号１
    $insert_sql .= "    '$post_no2',";                  //郵便番号２
    $insert_sql .= "    '$address',";            //住所１
    $insert_sql .= "    '$rep_name',";            //代表者
    $insert_sql .= "    '$tel',";            //電話番号
    $insert_sql .= "    '$close_day',";            //締日
    $insert_sql .= "    '$insert_data[10]',";            //支払日（月）
    $insert_sql .= "    '$insert_data[11]',";            //支払日（日）
    $insert_sql .= "    '$coax',";                      //丸め区分
    $insert_sql .= "    '$tax_franct',";                //端数区分
    $insert_sql .= "    '$tax_div',";                    //課税単位
    $insert_sql .= "    '1',";
    $insert_sql .= "    '',";
    $insert_sql .= "    '$slip_out',";
    if($trade_id != null){
        $insert_sql .= "    '$trade_id',";
    }
    $insert_sql .= "    '$claim_out',";
    $insert_sql .= "    17";
    $insert_sql .= ");";

    $result = Db_Query($db_con, $insert_sql);
    if($result === false){
        //得意先マスタに登録
        $insert_sql  = "INSERT INTO t_client (";
        $insert_sql .= "    state,";
        $insert_sql .= "    create_day,";
        $insert_sql .= "    client_id,";                    //得意先ID
        $insert_sql .= "    shop_gid,";                     //FCグループID
        $insert_sql .= "    client_cd1,";                   //得意先コード
        $insert_sql .= "    client_cd2,";                       //支店コード
        $insert_sql .= "    client_name,";                  //ショップ名
        $insert_sql .= "    client_cname,";                 //略称
        $insert_sql .= "    post_no1,";                     //郵便番号１
        $insert_sql .= "    post_no2,";                     //郵便番号２
        $insert_sql .= "    address1,";                     //住所１
        $insert_sql .= "    rep_name,";                     //代表者
        $insert_sql .= "    tel,";                          //電話番号
        $insert_sql .= "    close_day,";                    //締日
        $insert_sql .= "    pay_m,";                        //支払日（月）
        $insert_sql .= "    pay_d,";                        //支払日（日）
        $insert_sql .= "    coax,";                         //丸め区分
        $insert_sql .= "    tax_franct,";                   //端数区分
        $insert_sql .= "    tax_div,";                       //課税単位 
        $insert_sql .= "    client_div,";
        $insert_sql .= "    shop_div,";
        $insert_sql .= "    slip_out,";
        if($trade_id != null){
            $insert_sql .= "    trade_id,";
        }
        $insert_sql .= "    claim_out,";
        $insert_sql .= "    area_id";
        $insert_sql .= ")VALUES(";
        $insert_sql .= "    '1',";
        $insert_sql .= "    now(),";
        $insert_sql .= "    (SELECT MAX(client_id)+1 FROM t_client),";
        $insert_sql .= "    43,";
        $insert_sql .= "    '$client_cd[0]',";              //得意先コード
        $insert_sql .= "    '9999',";              //支店コード
        $insert_sql .= "    '$client_name',";            //得意先名
        $insert_sql .= "    '$client_cname',";            //略称
        $insert_sql .= "    '$post_no1',";                  //郵便番号１
        $insert_sql .= "    '$post_no2',";                  //郵便番号２
        $insert_sql .= "    '$address',";            //住所１
        $insert_sql .= "    '$rep_name',";            //代表者
        $insert_sql .= "    '$tel',";            //電話番号
        $insert_sql .= "    '$close_day',";            //締日
        $insert_sql .= "    '$insert_data[10]',";            //支払日（月）
        $insert_sql .= "    '$insert_data[11]',";            //支払日（日）
        $insert_sql .= "    '$coax',";                      //丸め区分
        $insert_sql .= "    '$tax_franct',";                //端数区分
        $insert_sql .= "    '$tax_div',";                    //課税単位
        $insert_sql .= "    '1',";
        $insert_sql .= "    '',";
        $insert_sql .= "    '$slip_out',";
        if($trade_id != null){
            $insert_sql .= "    '$trade_id',";
        }
        $insert_sql .= "    '$claim_out,'";
        $insert_sql .= "    17";
        $insert_sql .= ");";
    
        $result = Db_Query($db_con, $insert_sql);
        if($resutl === false){
            print $client_cd1."-".$client_cd2."<br>";
            print "得意先名".$insert_data[1]."<br>";
            print "<hr>";
        }
    }

    $j = $j + 1;

    if($result !== false){
        $sql = "SELECT MAX(client_id) FROM t_client;";
        $result = Db_Query($db_con, $sql);

        $client_id= pg_fetch_result($result, 0,0);

        $sql = "INSERT INTO t_client_info (";
        $sql .= "   client_id,";
        $sql .= "   claim_id,";
        $sql .= "   cclient_shop";
        $sql .= ")VALUES(";
        $sql .= "   $client_id,";
        $sql .= "   $client_id,";
        $sql .= "   93";
        $sql .= ");";

        Db_Query($db_con, $sql);
    }

}
?>
