<?php
//�����ȥ�
$page_title = "DB��Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once("file.fnc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect("amenity_060315");

extract($_POST);


//������***********************************/
$l_up_dir = "tmp/"; //������¦�Ǥ���¸��
/******************************************/

if($_POST[submit] == "�С�Ͽ"){

        // �ե����륢�åץ���
        $File_Upload = File_Upload("l_file", $l_up_dir, "$l_file_name");

		//���åץ��ɤ��줿�ե������EUC-JP���Ѵ�
		File_Mb_Convert("$l_up_dir"."$l_file_name");


        if(!$File_Upload)exit;

        //�ơ��֥��field�������
        $sql         = "SELECT * from $l_db_tname where false;";
        $result      = pg_query($sql);
        $field_count = pg_num_fields($result);


        $fp = fopen("$l_up_dir"."$l_file_name","r");
        if($field_count == 0 ){
                echo "�ơ��֥�������0�Ǥ�";
                exit;
        }

        Db_Query($db_con, "BEGIN;");
        //�ԥ롼��
        $j = 1;
        while($insert_data = fgetcsv($fp, "1000", "$l_ifs") ){
$in_num = $j;
print $in_num;
            $insert_data[$i] = trim(stripslashes($insert_data[$i]));
            $insert_data[$i] = mb_convert_encoding($insert_data[$i], "EUC-JP", "SJIS");

            //FC���롼�ץޥ���
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

            //�����ޥ����������������Ȥ�����Ͽ��
            //������ޥ����ξ�������
            $sql  = "SELECT";
            $sql .= "   t_client.client_cd1,";          //����襳���ɣ�
            $sql .= "   t_client.state,";               //����
            $sql .= "   t_client.client_name,";         //�����̾
            $sql .= "   t_client.client_cname,";        //�����̾�ʥեꥬ�ʡ�
            $sql .= "   t_client.post_no1,";            //͹���ֹ棱
            $sql .= "   t_client.post_no2,";            //͹���ֹ棲
            $sql .= "   t_client.address1,";            //���꣱
            $sql .= "   t_client.address2,";            //���ꣲ
            $sql .= "   t_client.tel,";                 //�����ֹ�
            $sql .= "   t_client.close_day,";           //����  
            $sql .= "   t_client.pay_m,";               //��ʧ���ʷ��
            $sql .= "   t_client.pay_d,";               //��ʧ��������
            $sql .= "   t_client.coax,";                //�ݤ��ʬ
            $sql .= "   t_client.tax_div,";             //����ñ��
            $sql .= "   t_client.tax_franct";           //ü����ʬ
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

            //������ޥ�������Ͽ
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

            //��Ͽ����Ƥ����������ʤξ�������

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
                //ñ���ơ��֥����Ͽ
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

                //����å��̾��ʾ���ơ��֥����Ͽ
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


            //�����襳���ɣ�����������åץ����ɣ�����
            $client_cd1 = str_pad($j,6,0,STR_PAD_LEFT);
            $client_cd2 = str_pad($j,4,0,STR_PAD_LEFT);

            //͹���ֹ�
            if($insert_data[3] != ""){
                $post_no1 = substr($insert_data[3], 0, 3);
                $post_no2 = substr($insert_data[3], 3, 4);
            }

            //����
            if($insert_data[9] <= 29){
                $close_day = $insert_data[9];
            }else{
                $close_day = '28';
            }

            //��ɼ����
            if($insert_data[12] == ''){
                $slip_out = '';
            }elseif($insert_data[12] == 1){
                $slip_out = '1';
            }

            //������ޥ�������Ͽ
            $insert_sql  = "INSERT INTO t_client (";
            $insert_sql .= "    client_id,";        //�����ID
            $insert_sql .= "    shop_gid,";         //FC���롼��ID
            $insert_sql .= "    attach_gid,";       //��°���롼��ID
            $insert_sql .= "    create_day,";       //������
            $insert_sql .= "    client_cd1,";       //����襳���ɣ�
            $insert_sql .= "    client_cd2,";       //����襳���ɣ�
            $insert_sql .= "    state,";            //����
            $insert_sql .= "    client_name,";      //�����̾
            $insert_sql .= "    client_cname,";     //�����ά��
            $insert_sql .= "    post_no1,";         //͹���ֹ棱
            $insert_sql .= "    post_no2,";         //͹���ֹ棲
            $insert_sql .= "    address1,";         //���꣱
            $insert_sql .= "    tel,";              //TEL
            $insert_sql .= "    close_day,";        //����
            $insert_sql .= "    pay_m,";            //��ʧ���ʷ��
            $insert_sql .= "    pay_d,";            //��ʧ��������
            $insert_sql .= "    coax,";             //�ݤ��ʬ
            $insert_sql .= "    tax_div,";          //����ñ��
            $insert_sql .= "    tax_franct,";       //ü����ʬ
            $insert_sql .= "    client_div,";       //������
            $insert_sql .= "    rep_name,";         //��ɽ�Ի�̾
            $insert_sql .= "    shop_name,";        //��̾
            $insert_sql .= "    shop_div,";         //�ܼҡ��ټҶ�ʬ
            $insert_sql .= "    royalty_rate,";     //�����ƥ�
            $insert_sql .= "    tax_rate_n,";        //������
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

    print "�����ޤ�����";
    Db_Query($db_con, "COMMIT;");

}

//�����
$def_data = array(
    "l_db_name"   => "amenity",
    "l_db_tname"  => "t_parts",
    "l_file_name" => "test.txt",
    "l_ifs"       => ",",
);
$form->setDefaults($def_data);

//�ե��������
$sql = "SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY schemaname;";
$result = Db_Query($db_con,$sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $select_a[pg_fetch_result($result, $i,0)] = pg_fetch_result($result, $i , 0);
}
$form->addElement("text","l_file_name","��¸�ե�����̾");
$form->addElement("text","l_db_name","DB̾");
$form->addElement("select","l_db_tname","�ơ��֥�̾",$select_a);
$form->addElement("file","l_file","CSV�ե�����");
$form->addElement("text","l_ifs","���ڤ�ʸ��");
$form->addElement("submit","submit","�С�Ͽ");

$form->display();

?>
