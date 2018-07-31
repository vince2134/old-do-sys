<?php
//�����ȥ�
$page_title = "DB��Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once("file.fnc");

//DB��³
$db_con = Db_Connect("amenity_demo_new");

$file_name = "/usr/local/apache2/htdocs/amenity/src/sample/db_inport/tmp/toyo_client.txt";

$file = fopen($file_name, "r");

//�ԥ롼��
$j = 1;
while($file_data = fgets($file, "1000") ){

    $insert_data = explode(',',$file_data);

    //�����襳���ɣ�����������åץ����ɣ�����
    $client_cd = explode("    ",$insert_data[0]);
    $client_cd[0] = trim($client_cd[0]);
    $client_cd[1] = trim($client_cd[1]);
    if($client_cd[1] == ''){
        $client_cd[1] = '0000';
    }

    //������̾
    $client_name  = trim($insert_data[1]);

    //ά��
    $client_cname = trim($insert_data[2]); 

    //����
    $address = trim($insert_data[4]);

    //TEL
    $tel     = trim($insert_data[5]);

    //��ɽ��
    $rep_name = trim($insert_data[8]);

    //͹���ֹ�
    if($insert_data[3] != ""){
        $post_no1 = substr($insert_data[3], 0, 3);
        $post_no2 = substr($insert_data[3], 3, 4);
    }

    //����
    if($insert_data[7] == '9'){
        $state = '2';       //����ٻ�
    }elseif($insert_data[7] == ''){
        $state = '1';
    }

    //����
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

    //��ɼ����
    if($insert_data[12] == '1'){
        $slip_out = '2';
    }else{
        $slip_out = '1';
    }

    //��������
    if($insert_data[13] == '1'){
        $claim_out = '3';
    }else{
        $claim_out = '1';
    }

    //�ݤ��ʬ
    if($insert_data[14] == '5'){
        $coax = '2';
    }elseif($insert_data[14] == '9'){
        $coax = '3';
    }else{
        $coax = '1';
    }

    //ü����ʬ
    if($insert_data[16] == '5'){
        $tax_franct = '2';
    }elseif($insert_data[16] == '9'){
        $tax_franct = '3';
    }else{
        $tax_franct = '1';
    }

    //����ñ��
    if($insert_data[15] == '1'){
        $tax_div = '1';
    }else{
        $tax_div = '2';
    }

    //������ޥ�������Ͽ
    $insert_sql  = "INSERT INTO t_client (";
    $insert_sql .= "    state,";
    $insert_sql .= "    create_day,";
    $insert_sql .= "    client_id,";                    //������ID
    $insert_sql .= "    shop_gid,";                     //FC���롼��ID
    $insert_sql .= "    client_cd1,";                   //�����襳����
    $insert_sql .= "    client_cd2,";                   //��Ź������
    $insert_sql .= "    client_name,";                  //����å�̾
    $insert_sql .= "    client_cname,";                 //ά��
    $insert_sql .= "    post_no1,";                     //͹���ֹ棱
    $insert_sql .= "    post_no2,";                     //͹���ֹ棲
    $insert_sql .= "    address1,";                     //���꣱
    $insert_sql .= "    rep_name,";                     //��ɽ��
    $insert_sql .= "    tel,";                          //�����ֹ�
    $insert_sql .= "    close_day,";                    //����
    $insert_sql .= "    pay_m,";                        //��ʧ���ʷ��
    $insert_sql .= "    pay_d,";                        //��ʧ��������
    $insert_sql .= "    coax,";                         //�ݤ��ʬ
    $insert_sql .= "    tax_franct,";                   //ü����ʬ
    $insert_sql .= "    tax_div,";                       //����ñ�� 
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
    $insert_sql .= "    '$client_cd[0]',";              //�����襳����
    $insert_sql .= "    '$client_cd[1]',";              //��Ź������
    $insert_sql .= "    '$client_name',";            //������̾
    $insert_sql .= "    '$client_cname',";            //ά��
    $insert_sql .= "    '$post_no1',";                  //͹���ֹ棱
    $insert_sql .= "    '$post_no2',";                  //͹���ֹ棲
    $insert_sql .= "    '$address',";            //���꣱
    $insert_sql .= "    '$rep_name',";            //��ɽ��
    $insert_sql .= "    '$tel',";            //�����ֹ�
    $insert_sql .= "    '$close_day',";            //����
    $insert_sql .= "    '$insert_data[10]',";            //��ʧ���ʷ��
    $insert_sql .= "    '$insert_data[11]',";            //��ʧ��������
    $insert_sql .= "    '$coax',";                      //�ݤ��ʬ
    $insert_sql .= "    '$tax_franct',";                //ü����ʬ
    $insert_sql .= "    '$tax_div',";                    //����ñ��
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
        //������ޥ�������Ͽ
        $insert_sql  = "INSERT INTO t_client (";
        $insert_sql .= "    state,";
        $insert_sql .= "    create_day,";
        $insert_sql .= "    client_id,";                    //������ID
        $insert_sql .= "    shop_gid,";                     //FC���롼��ID
        $insert_sql .= "    client_cd1,";                   //�����襳����
        $insert_sql .= "    client_cd2,";                       //��Ź������
        $insert_sql .= "    client_name,";                  //����å�̾
        $insert_sql .= "    client_cname,";                 //ά��
        $insert_sql .= "    post_no1,";                     //͹���ֹ棱
        $insert_sql .= "    post_no2,";                     //͹���ֹ棲
        $insert_sql .= "    address1,";                     //���꣱
        $insert_sql .= "    rep_name,";                     //��ɽ��
        $insert_sql .= "    tel,";                          //�����ֹ�
        $insert_sql .= "    close_day,";                    //����
        $insert_sql .= "    pay_m,";                        //��ʧ���ʷ��
        $insert_sql .= "    pay_d,";                        //��ʧ��������
        $insert_sql .= "    coax,";                         //�ݤ��ʬ
        $insert_sql .= "    tax_franct,";                   //ü����ʬ
        $insert_sql .= "    tax_div,";                       //����ñ�� 
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
        $insert_sql .= "    '$client_cd[0]',";              //�����襳����
        $insert_sql .= "    '9999',";              //��Ź������
        $insert_sql .= "    '$client_name',";            //������̾
        $insert_sql .= "    '$client_cname',";            //ά��
        $insert_sql .= "    '$post_no1',";                  //͹���ֹ棱
        $insert_sql .= "    '$post_no2',";                  //͹���ֹ棲
        $insert_sql .= "    '$address',";            //���꣱
        $insert_sql .= "    '$rep_name',";            //��ɽ��
        $insert_sql .= "    '$tel',";            //�����ֹ�
        $insert_sql .= "    '$close_day',";            //����
        $insert_sql .= "    '$insert_data[10]',";            //��ʧ���ʷ��
        $insert_sql .= "    '$insert_data[11]',";            //��ʧ��������
        $insert_sql .= "    '$coax',";                      //�ݤ��ʬ
        $insert_sql .= "    '$tax_franct',";                //ü����ʬ
        $insert_sql .= "    '$tax_div',";                    //����ñ��
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
            print "������̾".$insert_data[1]."<br>";
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
