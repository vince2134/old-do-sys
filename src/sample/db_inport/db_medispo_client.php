<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");
require_once("file.fnc");

//DB接続
$db_con = Db_Connect("amenity_demo_new");

$file_name = "/usr/local/apache2/htdocs/amenity/src/sample/db_inport/tmp/medispo_euc.csv";

$file = fopen($file_name, "r");

//行ループ
$j = 1;

Db_Query($db_con, "BEGIN;");
while($file_data  = fgets($file, "1000") ){
    $client_cd1 = null;
    $client_cd2 = null;

    $insert_data  = explode(',',$file_data);

    //得意先コード１
    $client_cd1   = str_pad(trim($insert_data[0]), 6, 0, STR_PAD_LEFT);

    //得意先コード２
    $client_cd2   = str_pad(trim($insert_data[1]), 4, 0, STR_PAD_LEFT);

    //得意先名
    $client_name_data = trim($insert_data[2]);
    //文字列中の空白を削除
    $ary_client_name = explode(' ', $client_name_data);
    $client_name = null;

    for($i = 0; $i < count($ary_client_name); $i++){
        if($ary_client_name[$i] != ''){
            $client_name .= $ary_client_name[$i];
            $client_name .= " ";
        }
    }
    $client_name1 = addslashes(trim($client_name));

    //得意先名２
    $client_name2_data = trim($insert_data[3]);
    //文字列中の空白を削除
    $ary_client_name2 = explode(' ', $client_name2_data);
    $client_name2 = null;

    for($i = 0; $i < count($ary_client_name2); $i++){
        if($ary_client_name2[$i] != ''){
            $client_name2 .= $ary_client_name2[$i];
            $client_name2 .= " ";
        }
    }
    $client_name2 = addslashes(trim($client_name2));

    //略称
    $client_cname = addslashes(trim($insert_data[4])); 

    //得意先名（フリガナ）
    $client_read  = trim($insert_data[5]);

    //郵便番号
    $post_data    = explode("-", $insert_data[8]);
    $post_no1     = trim($post_data[0]);
    $post_no2     = trim($post_data[1]);

    //住所1
    $address1     = trim($insert_data[9]);

    //住所２
    $address2     = trim($insert_data[10]);

    //TEL
    $tel          = trim($insert_data[11]);

    //FAX
    $fax          = trim($insert_data[12]);

    //状態
    if($insert_data[18] == '*'){
        $state    = '2';
    }else{
        $state    = '1';
    }

    //取引開始日
    if(strlen(trim($insert_data[19])) == '10'){
        $cont_sday = $insert_data[19];
    }

    //代表者
    $rep_name     = trim($insert_data[22]);

    //担当者１
    $charger      = trim($insert_data[23]);

    //担当部署１
    $charger_part = trim($insert_data[24]);
 
    //締日
    if($insert_data[25] > 28 || $insert_data[25] == 0){
        $close_day = 29;
    }else{
        $close_day = (int)trim($insert_data[25]);
    }

    //集金日
    //月
    if(trim($insert_data[26]) == 0){
        $pay_m = '1';
    }else{
        $pay_m = (int)trim($insert_data[26]);
    }
    //日
    if($insert_data[27] > 28 || trim($insert_data[27]) == 0){
        $pay_d = '29';
    }else{
        $pay_d = (int)trim($insert_data[27]);
    }

    //得意先マスタに登録
    $sql  = "INSERT INTO t_client (\n";
    $sql .= "    client_id,\n";                    //得意先ID
    $sql .= "    client_cd1,\n";                   //得意先コード
    $sql .= "    client_cd2,\n";                   //支店コード
    $sql .= "    client_name,\n";                  //得意先名
    $sql .= "    client_name2,\n";                 //得意先名    
    $sql .= "    client_cname,\n";                 //略称
    $sql .= "    client_read,\n";                  //得意先名（フリガナ）
    $sql .= "    post_no1,\n";                     //郵便番号１
    $sql .= "    post_no2,\n";                     //郵便番号２
    $sql .= "    address1,\n";                     //住所１
    $sql .= "    address2,\n";                     //住所２
    $sql .= "    tel,\n";                          //TEL
    $sql .= "    fax,\n";                          //FAX
    $sql .= "    url,\n";                          //URL
    $sql .= "    state,\n";                        //状態
    if($cont_sday != null){
        $sql .= "    cont_sday,\n";                    //契約開始日
    }
    $sql .= "    rep_name,\n";                     //代表者
    $sql .= "    charger1,\n";                     //担当者１
    $sql .= "    charger_part1,\n";                //担当部署１
    $sql .= "    close_day,\n";                    //締日
    $sql .= "    pay_m,\n";                        //支払日（月）
    $sql .= "    pay_d,\n";                        //支払日（日）
    $sql .= "    coax,\n";                         //丸め区分
    $sql .= "    tax_franct,\n";                   //端数区分
    $sql .= "    tax_div,\n";                      //課税単位 
    $sql .= "    client_div,\n";                   //取引先区分
    $sql .= "    shop_div,\n";                     //本社支社区分
    $sql .= "    slip_out,\n";                     //伝票印刷
    $sql .= "    trade_id,\n";                     //取引区分
    $sql .= "    claim_out,\n";                    //請求書印刷
    $sql .= "    area_id,\n";                      //地区意ID
    $sql .= "    sbtype_id,\n";                    //業種ID
    $sql .= "    create_day,\n";                   //作成日
    $sql .= "    shop_id,\n";                      //ショップID
    $sql .= "    his_client_cd1,\n";               //取引先コード１（履歴）
    $sql .= "    his_client_cd2,\n";               //取引先コード２（履歴）
    $sql .= "    his_client_name,\n";              //取引先名
    $sql .= "    type,\n";                         //種別
    $sql .= "    compellation,\n";                 //敬称
    $sql .= "    bank_div,\n";                     //銀行手数料負担区分
    $sql .= "    deliver_effect,\n";               //売上伝票コメント
    $sql .= "    claim_send\n";                    //請求書送付
    $sql .= ")VALUES(\n";
    $sql .= "    (SELECT MAX(client_id)+1 FROM t_client),\n";
    $sql .= "    '$client_cd1',\n";                 //得意先コード
    $sql .= "    '$client_cd2',\n";                 //支店コード
    $sql .= "    '$client_name1',\n";                //得意先名
    $sql .= "    '$client_name2',\n";               //得意先名
    $sql .= "    '$client_cname',\n";               //略称
    $sql .= "    '$client_read',\n";                //得意先名（フリガナ)
    $sql .= "    '$post_no1',\n";                   //郵便番号１
    $sql .= "    '$post_no2',\n";                   //郵便番号２
    $sql .= "    '$address1',\n";                   //住所１
    $sql .= "    '$address2',\n";                   //住所２
    $sql .= "    '$tel',\n";                        //TEL
    $sql .= "    '$fax',\n";                        //FAX
    $sql .= "    '$url',\n";                        //URL
    $sql .= "    '$state',\n";                      //状態
    if($cont_sday != null){
        $sql .= "    '$cont_sday',\n";                  //契約開始日
    }
    $sql .= "    '$rep_name',\n";                   //代表者
    $sql .= "    '$charger',\n";                    //担当者１
    $sql .= "    '$charger_part',\n";               //担当部署１
    $sql .= "    '$close_day',\n";                  //締日
    $sql .= "    '$pay_m',\n";                      //支払日（月）
    $sql .= "    '$pay_d',\n";                      //支払日（日）
    $sql .= "    '1',\n";                           //丸め区分
    $sql .= "    '1',\n";                           //端数区分
    $sql .= "    '1',\n";                           //課税単位
    $sql .= "    '1',\n";                           //取引先区分
    $sql .= "    '',\n";                            //本社・支社区分
    $sql .= "    '1',\n";                           //伝票印刷
    $sql .= "    '11',\n";                          //取引区分
    $sql .= "    '1',\n";                           //請求書印刷
    $sql .= "    305,\n";                           //地区ID(メディスポ地区)
    $sql .= "    62,\n";                            //業種ID（その他）
    $sql .= "    NOW(),\n";                         //作成日
    $sql .= "    189,\n";                           //ショップID（メディスポ）
    $sql .= "    '$client_cd1',\n";                 //得意先コード１
    $sql .= "    '$client_cd2',\n";                 //得意先コード２ 
    $sql .= "    '$client_name',\n";                //得意先名
    $sql .= "    '1',\n";                           //種別
    $sql .= "    '1',\n";                           //敬称
    $sql .= "    '1',\n";                           //銀行手数料負担区分
    $sql .= "    '1',\n";                           //売上伝票コメント
    $sql .= "    '1'\n";                            //請求書送付
    $sql .= ");";

    $result = Db_Query($db_con, $sql);

    if($result === false){
        print_array($sql);
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    //得意先IDを抽出
    $sql  = "SELECT";
    $sql .= "   client_id";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '1'";
    $sql .= "   AND";
    $sql .= "   shop_id = 189";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $client_id = pg_fetch_result($result,0,0);

    //請求先コード１
    $claim_cd1  = str_pad(trim($insert_data[6]), 6, 0, STR_PAD_LEFT);

    //請求先コード２
    $claim_cd2  = str_pad(trim($insert_data[7]), 4, 0, STR_PAD_LEFT);

    //請求先IDを抽出
    $sql1  = "SELECT";
    $sql1 .= "   client_id";
    $sql1 .= " FROM";
    $sql1 .= "   t_client";
    $sql1 .= " WHERE";
    $sql1 .= "   client_cd1 = '$claim_cd1'";
    $sql1 .= "   AND";
    $sql1 .= "   client_cd2 = '$claim_cd2'";
    $sql1 .= "   AND";
    $sql1 .= "   client_div = '1'";
    $sql1 .= "   AND";
    $sql1 .= "   shop_id = 189";
    $sql1 .= ";";

    $result = Db_Query($db_con, $sql1);
    $claim_id = pg_fetch_result($result,0,0);

    $sql = "INSERT INTO t_client_info (";
    $sql .= "   client_id,";
    $sql .= "   claim_id,";
    $sql .= "   cclient_shop";
    $sql .= ")VALUES(";
    $sql .= "   $client_id,";
    $sql .= "   $claim_id,";
    $sql .= "   189";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        print $sql1;

        print_array($sql);
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    $j = $j+1;

    if($j % 10 == 0){
        print $j."<br>";
    }
}
Db_Query($db_con, "COMMIT;");
print $j;

?>
