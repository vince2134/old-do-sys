<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");
require_once("file.fnc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect("amenity_060315");

extract($_POST);


//■設定***********************************/
$l_up_dir = "tmp/"; //サーバ側での保存先
/******************************************/

if($_POST[submit] == "登　録"){

        // ファイルアップロード
        $File_Upload = File_Upload("l_file", $l_up_dir, "$l_file_name");

		//アップロードされたファイルをEUC-JPへ変換
		File_Mb_Convert("$l_up_dir"."$l_file_name");


        if(!$File_Upload)exit;

        //テーブルのfield数を取得
        $sql         = "SELECT * from $l_db_tname where false;";
        $result      = pg_query($sql);
        $field_count = pg_num_fields($result);


        $fp = fopen("$l_up_dir"."$l_file_name","r");
        if($field_count == 0 ){
                echo "テーブルの列数が0です";
                exit;
        }

        Db_Query($db_con, "BEGIN;");
        //行ループ
        $j = 1;
        while($insert_data = fgetcsv($fp, "1000", "$l_ifs") ){
$in_num = $j;
print $in_num;
            $insert_data[$i] = trim(stripslashes($insert_data[$i]));
            $insert_data[$i] = mb_convert_encoding($insert_data[$i], "EUC-JP", "SJIS");

            //FCグループマスタ
            $shop_gcd   = str_pad($j,4,0,STR_PAD_LEFT);
            $shop_gname = "am-".str_pad($j,3,0,STR_PAD_LEFT);

            if($insert_data[6] == '1'){
                $rank_cd = '0001';
            }elseif($insert_data[6] == '2'){
                $rank_cd = '0002';
            }elseif($insert_data[6] == '3'){
                $rank_cd = '0003';
            }elseif($insert_data[6] == '4'){
                $rank_cd = '0004';
            }else{
                $rank_cd = '0099';
            }

            $sql  = "INSERT INTO t_shop_gr (";
            $sql .= "   shop_gid,";
            $sql .= "   shop_gcd,";
            $sql .= "   shop_gname,";   
            $sql .= "   rank_cd";
            $sql .= " )VALUES(";
            $sql .= "   (SELECT MAX(shop_gid)+1 FROM t_shop_gr),";
            $sql .= "   '$shop_gcd',";
            $sql .= "   '$shop_gname',";
            $sql .= "   '$rank_cd'";
            $sql .= ");";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            //取引先マスタ（本部を仕入先として登録）
            //得意先マスタの情報を抽出
            $sql  = "SELECT";
            $sql .= "   t_client.client_cd1,";          //取引先コード１
            $sql .= "   t_client.state,";               //状態
            $sql .= "   t_client.client_name,";         //取引先名
            $sql .= "   t_client.client_cname,";        //取引先名（フリガナ）
            $sql .= "   t_client.post_no1,";            //郵便番号１
            $sql .= "   t_client.post_no2,";            //郵便番号２
            $sql .= "   t_client.address1,";            //住所１
            $sql .= "   t_client.address2,";            //住所２
            $sql .= "   t_client.tel,";                 //電話番号
            $sql .= "   t_client.close_day,";           //締日  
            $sql .= "   t_client.pay_m,";               //支払日（月）
            $sql .= "   t_client.pay_d,";               //支払日（日）
            $sql .= "   t_client.coax,";                //丸め区分
            $sql .= "   t_client.tax_div,";             //課税単位
            $sql .= "   t_client.tax_franct";           //端数区分
            $sql .= " FROM";
            $sql .= "   t_client";
            $sql .= " WHERE";
            $sql .= "   t_client.client_div = '0'";
            $sql .= ";"; 

            $result = Db_Query($db_con,$sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            $client_cd1     = @pg_fetch_result($result, 0 ,0);
            $state          = @pg_fetch_result($result, 0 ,1);
            $client_name    = @pg_fetch_result($result, 0 ,2);
            $client_cname   = @pg_fetch_result($result, 0 ,3);
            $post_no1       = @pg_fetch_result($result, 0, 4);
            $post_no2       = @pg_fetch_result($result, 0, 5);
            $address1       = @pg_fetch_result($result, 0, 6);
            $address2       = @pg_fetch_result($result, 0, 7);
            $tel            = @pg_fetch_result($result, 0, 8);
            $close_day      = @pg_fetch_result($result, 0, 9);
            $pay_m          = @pg_fetch_result($result, 0, 10);
            $pay_d          = @pg_fetch_result($result, 0, 11);
            $coax           = @pg_fetch_result($result, 0, 12);
            $tax_div        = @pg_fetch_result($result, 0, 13);
            $tax_franct     = @pg_fetch_result($result, 0, 14);

            //得意先マスタに登録
            $insert_sql  = "INSERT INTO t_client (";
            $insert_sql .= "    client_id,";
            $insert_sql .= "    shop_gid,";
            $insert_sql .= "    create_day,";
            $insert_sql .= "    client_cd1,";
            $insert_sql .= "    client_cd2,";
            $insert_sql .= "    state,";
            $insert_sql .= "    client_name,";
            $insert_sql .= "    client_cname,";
            $insert_sql .= "    post_no1,";
            $insert_sql .= "    post_no2,";
            $insert_sql .= "    address1,";
            $insert_sql .= "    address2,";
            $insert_sql .= "    tel,";
            $insert_sql .= "    close_day,";
            $insert_sql .= "    pay_m,";
            $insert_sql .= "    pay_d,";
            $insert_sql .= "    coax,";
            $insert_sql .= "    tax_div,";
            $insert_sql .= "    tax_franct,";
            $insert_sql .= "    client_div,";
            $insert_sql .= "    head_flg,";
            $insert_sql .= "    rep_name,";
            $insert_sql .= "    shop_name,";
            $insert_sql .= "    shop_div,";
            $insert_sql .= "    royalty_rate,";
            $insert_sql .= "    tax_rate_n";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
            $insert_sql .= "    (SELECT ";
            $insert_sql .= "        shop_gid";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_shop_gr";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_gcd = '$shop_gcd'";
            $insert_sql .= "    ),";
            $insert_sql .= "    now(),";
            $insert_sql .= "    '$client_cd1',";
            $insert_sql .= "    '0000',";
            $insert_sql .= "    '$state',";
            $insert_sql .= "    '$client_name',";
            $insert_sql .= "    '$client_cname',";
            $insert_sql .= "    '$post_no1',";
            $insert_sql .= "    '$post_no2',";
            $insert_sql .= "    '$address1',";
            $insert_sql .= "    '$address2',";
            $insert_sql .= "    '$tel',";
            $insert_sql .= "    '$close_day',";
            $insert_sql .= "    '$pay_m',";
            $insert_sql .= "    '$pay_d',";
            $insert_sql .= "    '$coax',";
            $insert_sql .= "    '$tax_div',";
            $insert_sql .= "    '$tax_fracnt',";
            $insert_sql .= "    '2',";
            $insert_sql .= "    't',";
            $insert_sql .= "    '',";
            $insert_sql .= "    '',";
            $insert_sql .= "    '',";
            $insert_sql .= "    '',";
            $insert_sql .= "    ''";
            $insert_sql .= ");";

            $result = Db_Query($db_con, $insert_sql);

            //登録されている本部商品の情報を抽出

            $sql  = "SELECT";
            $sql .= "   t_goods.goods_id,";
            $sql .= "   t_price.r_price";
            $sql .= " FROM";
            $sql .= "    (SELECT goods_id,price_id FROM t_price WHERE rank_cd = '' AND r_price IS NOT NULL and shop_gid = ) AS my_price";
            $sql .= "   INNER JOIN";
            $sql .= "    (SELECT goods_id, price_id, r_price FROM t_price WHERE rank_cd = '4') AS t_price";
            $sql .= "   ON my_price.goods_id = t_price.goods_id";
            $sql .= "   INNER JOIN";
            $sql .= "   t_goods";
            $sql .= "   ON t_price.goods_id = t_goods.goods_id";
            $sql .= " WHERE";
            $sql .= "   t_goods.public_flg = 't'";
            $sql .= ";";
/*
            $sql  = "SELECT";
            $sql .= "   t_goods.goods_id,";
            $sql .= "   t_price.r_price";
            $sql .= " FROM";
            $sql .= "   t_goods,";
            $sql .= "   t_price";
            $sql .= " WHERE";
            $sql .= "   t_goods.public_flg = 't'";
            $sql .= "   AND";
            $sql .= "   t_goods.goods_id = t_price.goods_id";
            $sql .= "   AND";
            $sql .= "   t_price.rank_cd = '4'";
            $sql .= ";";
*/
            $result = Db_Query($db_con, $sql);
       
            $goods_num = pg_num_rows($result);

            for($i = 0; $i < $goods_num; $i++){
                $goods_data[] = pg_fetch_array($result, $i, PGSQL_NUM);
            }

            if($goods_num != 0){
                //単価テーブルに登録
                for($i = 0; $i < $goods_num; $i++){
                    for($k = 2; $k < 4; $k++){
                        $insert_sql  = "INSERT INTO t_price (";
                        $insert_sql .= "    price_id,";
                        $insert_sql .= "    goods_id,";
                        $insert_sql .= "    rank_cd,";
                        $insert_sql .= "    cost_rate,";
                        $insert_sql .= "    cost_price,";
                        $insert_sql .= "    r_price,";
                        $insert_sql .= "    shop_gid";
                        $insert_sql .= ")VALUES(";
                        $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                        $insert_sql .= "    ".$goods_data[$i][0].",";
                        $insert_sql .= "    '$k',";
                        $insert_sql .= "    '100',";
                        $insert_sql .= "    ".$goods_data[$i][0].",";
                        $insert_sql .= "    ".$goods_data[$i][1].",";
                        $insert_sql .= "    (SELECT shop_gid FROM t_shop_gr WHERE shop_gcd = '$shop_gcd')";
                        $insert_sql .= ");";
                        $result = Db_Query($db_con, $insert_sql);

                        if($result === false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                    }
                }

                //ショップ別商品情報テーブルに登録
                for($i = 0; $i < $goods_num; $i++){
                    $insert_sql  = "INSERT INTO t_goods_info (";
                    $insert_sql .= "    goods_id,";
                    $insert_sql .= "    compose_flg,";
                    $insert_sql .= "    head_fc_flg,";
                    $insert_sql .= "    shop_gid";
                    $insert_sql .= ")VALUES(";
                    $insert_sql .= "    ".$goods_data[$i][0].",";
                    $insert_sql .= "    'f',";
                    $insert_sql .= "    'f',";
                    $insert_sql .= "    (SELECT ";
                    $insert_sql .= "        shop_gid";
                    $insert_sql .= "    FROM";
                    $insert_sql .= "        t_shop_gr";
                    $insert_sql .= "    WHERE";
                    $insert_sql .= "        shop_gcd = '$shop_gcd'";
                    $insert_sql .= "    )";
                    $insert_sql .= ");";
                    $result = Db_Query($db_con, $insert_sql);

                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
                }
            }


            //得意先コード１，２・ショップコード１，２
            $client_cd1 = str_pad($j,6,0,STR_PAD_LEFT);
            $client_cd2 = str_pad($j,4,0,STR_PAD_LEFT);

            //郵便番号
            if($insert_data[3] != ""){
                $post_no1 = substr($insert_data[3], 0, 3);
                $post_no2 = substr($insert_data[3], 3, 4);
            }

            //締日
            if($insert_data[9] <= 29){
                $close_day = $insert_data[9];
            }else{
                $close_day = '28';
            }

            //伝票出力
            if($insert_data[12] == ''){
                $slip_out = '';
            }elseif($insert_data[12] == 1){
                $slip_out = '1';
            }

            //得意先マスタに登録
            $insert_sql  = "INSERT INTO t_client (";
            $insert_sql .= "    client_id,";        //取引先ID
            $insert_sql .= "    shop_gid,";         //FCグループID
            $insert_sql .= "    attach_gid,";       //所属グループID
            $insert_sql .= "    create_day,";       //作成日
            $insert_sql .= "    client_cd1,";       //取引先コード１
            $insert_sql .= "    client_cd2,";       //取引先コード２
            $insert_sql .= "    state,";            //状態
            $insert_sql .= "    client_name,";      //取引先名
            $insert_sql .= "    client_cname,";     //取引先略称
            $insert_sql .= "    post_no1,";         //郵便番号１
            $insert_sql .= "    post_no2,";         //郵便番号２
            $insert_sql .= "    address1,";         //住所１
            $insert_sql .= "    tel,";              //TEL
            $insert_sql .= "    close_day,";        //締日
            $insert_sql .= "    pay_m,";            //支払日（月）
            $insert_sql .= "    pay_d,";            //支払日（日）
            $insert_sql .= "    coax,";             //丸め区分
            $insert_sql .= "    tax_div,";          //課税単位
            $insert_sql .= "    tax_franct,";       //端数区分
            $insert_sql .= "    client_div,";       //取引先区
            $insert_sql .= "    rep_name,";         //代表者氏名
            $insert_sql .= "    shop_name,";        //社名
            $insert_sql .= "    shop_div,";         //本社・支社区分
            $insert_sql .= "    royalty_rate,";     //ロイヤリティ
            $insert_sql .= "    tax_rate_n,";        //消費税
            $insert_sql .= "    slip_out,";
            $insert_sql .= "    claim_out";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
            $insert_sql .= "    1,";
            $insert_sql .= "    (SELECT MAX(shop_gid) FROM t_shop_gr),";
            $insert_sql .= "    NOW(),";
            $insert_sql .= "    '$client_cd1',";
            $insert_sql .= "    '$client_cd2',";
            $insert_sql .= "    '1',";
            $insert_sql .= "    '$insert_data[1]',";
            $insert_sql .= "    '$insert_data[2]',";
            $insert_sql .= "    '$post_no1',";
            $insert_sql .= "    '$post_no2',";
            $insert_sql .= "    '$insert_data[4]',";
            $insert_sql .= "    '$insert_data[5]',";
            $insert_sql .= "    '$close_day',";
            $insert_sql .= "    '$insert_data[10]',";
            $insert_sql .= "    '$insert_data[11]',";
            $insert_sql .= "    '2',";
            $insert_sql .= "    '2',";
            $insert_sql .= "    '2',";
            $insert_sql .= "    '3',";
            $insert_sql .= "    '$insert_data[8]',";
            $insert_sql .= "    '$insert_data[1]',";
            $insert_sql .= "    '1',";
            $insert_sql .= "    '',";
            $insert_sql .= "    '5',";
            $insert_sql .= "    '',";
            $insert_sql .= "    '1'";
            $insert_sql .= ");"; 
            $result = Db_Query($db_con, $insert_sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            $sql = "SELECT MAX(client_id) FROM t_client;";
            $result = Db_Query($db_con, $sql);
            $client_id = pg_fetch_result($result,0,0);

            shell_exec('echo '.$insert_data[0].','.$client_id.' >> ./client_log.text');

            $j = $j+1;  
        }
/*
        while($claim_data = fgetcsv($fp, "1000", "$l_ifs") ){

            $client_id = $client_data[$claim_data[0]];
            $claim_id = $client_data[$claim_data[7]];
        
            $insert_sql  = "INSERT INTO t_client_info (";
            $insert_sql .= "    client_id,";    
            $insert_sql .= "    claim_id";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    $client_id,";
            $insert_sql .= "    $claim_id";
            $insert_sql .= ")";
            
            $result = Db_Query($db_con, $insert_sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
*/    

    print "終わりました。";
    Db_Query($db_con, "COMMIT;");

}

//初期値
$def_data = array(
    "l_db_name"   => "amenity",
    "l_db_tname"  => "t_parts",
    "l_file_name" => "test.txt",
    "l_ifs"       => ",",
);
$form->setDefaults($def_data);

//フォーム定義
$sql = "SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY schemaname;";
$result = Db_Query($db_con,$sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $select_a[pg_fetch_result($result, $i,0)] = pg_fetch_result($result, $i , 0);
}
$form->addElement("text","l_file_name","保存ファイル名");
$form->addElement("text","l_db_name","DB名");
$form->addElement("select","l_db_tname","テーブル名",$select_a);
$form->addElement("file","l_file","CSVファイル");
$form->addElement("text","l_ifs","区切り文字");
$form->addElement("submit","submit","登　録");

$form->display();

?>
