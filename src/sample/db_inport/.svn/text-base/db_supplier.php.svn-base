<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");
require_once("file.fnc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

//■設定***********************************/
$l_up_dir = "./tmp/"; //サーバ側での保存先
/******************************************/


$file_name = $l_up_dir."head_supplier.txt";

$file = fopen($file_name, "r");

Db_Query($db_con, "BEGIN;");

while($file_data = fgets($file, "1000") ){

    $insert_data = explode(',',$file_data);

    //仕入先コード
    $supplier_cd = str_pad($insert_data[0], 6, 0, STR_PAD_LEFT);

    //郵便番号
    $post_no1 = substr($insert_data[3], 0, 3);
    $post_no2 = substr($insert_data[3], 3, 4);

    //丸め区分
    if($insert_data[10] == ''){
        $coax = '2';
    }elseif($insert_data[10] == '5'){
        $coax = '1';
    }elseif($insert_data[10] == '9'){
        $coax = '3';
    }

    //課税単位
    if($insert_data[12] == '' ){
        $tax_div = '1';
    }elseif($insert_data[12] == '1'){
        $tax_div = '2';
    }

    //端数区分
    if($insert_data[13] == ''){
        $tax_franct = '1';
    }elseif($insert_data[13] == ''){
        $tax_franct = '2';
    }

    $insert_sql  = "INSERT INTO t_client (";
    $insert_sql .= "    client_id,";
    $insert_sql .= "    shop_gid,";
    $insert_sql .= "    state,";
    $insert_sql .= "    create_day,";
    $insert_sql .= "    client_cd1,";
    $insert_sql .= "    client_cd2,";
    $insert_sql .= "    client_name,";
    $insert_sql .= "    client_cname,";
    $insert_sql .= "    post_no1,";
    $insert_sql .= "    post_no2,";
    $insert_sql .= "    address1,";
    $insert_sql .= "    tel,";
    $insert_sql .= "    rep_name,";
    $insert_sql .= "    close_day,";
    $insert_sql .= "    pay_m,";
    $insert_sql .= "    pay_d,";
    $insert_sql .= "    coax,";
    $insert_sql .= "    tax_div,";
    $insert_sql .= "    tax_franct,";
    $insert_sql .= "    client_div,";
    $insert_sql .= "    shop_name,";
    $insert_sql .= "    shop_div,";
    $insert_sql .= "    royalty_rate,";
    $insert_sql .= "    area_id,";
    $insert_sql .= "    tax_rate_n";
    $insert_sql .= ")VALUES(";
    $insert_sql .= "    (SELECT MAX(client_id)+1 FROM t_client),";
    $insert_sql .= "    1,";
    $insert_sql .= "    '1',";
    $insert_sql .= "    NOW(),";
    $insert_sql .= "    '$supplier_cd',";
    $insert_sql .= "    '0000',";
    $insert_sql .= "    '$insert_data[1]',";
    $insert_sql .= "    '$insert_data[2]',";
    $insert_sql .= "    '$post_no1',";
    $insert_sql .= "    '$post_no2',";
    $insert_sql .= "    '$insert_data[4]',";
    $insert_sql .= "    '$insert_data[5]',";
    $insert_sql .= "    '$insert_data[6]',";
    $insert_sql .= "    '$insert_data[7]',";
    $insert_sql .= "    '$insert_data[8]',";
    $insert_sql .= "    '$insert_data[9]',";
    $insert_sql .= "    '$coax',";
    $insert_sql .= "    '$tax_div',";
    $insert_sql .= "    '$tax_franct',";
    $insert_sql .= "    '2',";
    $insert_sql .= "    '',";
    $insert_sql .= "    '',";
    $insert_sql .= "    '',";
    $insert_sql .= "    1,";
    $insert_sql .= "    ''";
    $insert_sql .= ");";

    $result = Db_Query($db_con, $insert_sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK");   
        exit;
    }

    Db_Query($db_con, "COMMIT;");
}

?>
