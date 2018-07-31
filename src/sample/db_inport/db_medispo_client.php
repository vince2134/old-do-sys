<?php
//�����ȥ�
$page_title = "DB��Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once("file.fnc");

//DB��³
$db_con = Db_Connect("amenity_demo_new");

$file_name = "/usr/local/apache2/htdocs/amenity/src/sample/db_inport/tmp/medispo_euc.csv";

$file = fopen($file_name, "r");

//�ԥ롼��
$j = 1;

Db_Query($db_con, "BEGIN;");
while($file_data  = fgets($file, "1000") ){
    $client_cd1 = null;
    $client_cd2 = null;

    $insert_data  = explode(',',$file_data);

    //�����襳���ɣ�
    $client_cd1   = str_pad(trim($insert_data[0]), 6, 0, STR_PAD_LEFT);

    //�����襳���ɣ�
    $client_cd2   = str_pad(trim($insert_data[1]), 4, 0, STR_PAD_LEFT);

    //������̾
    $client_name_data = trim($insert_data[2]);
    //ʸ������ζ������
    $ary_client_name = explode(' ', $client_name_data);
    $client_name = null;

    for($i = 0; $i < count($ary_client_name); $i++){
        if($ary_client_name[$i] != ''){
            $client_name .= $ary_client_name[$i];
            $client_name .= " ";
        }
    }
    $client_name1 = addslashes(trim($client_name));

    //������̾��
    $client_name2_data = trim($insert_data[3]);
    //ʸ������ζ������
    $ary_client_name2 = explode(' ', $client_name2_data);
    $client_name2 = null;

    for($i = 0; $i < count($ary_client_name2); $i++){
        if($ary_client_name2[$i] != ''){
            $client_name2 .= $ary_client_name2[$i];
            $client_name2 .= " ";
        }
    }
    $client_name2 = addslashes(trim($client_name2));

    //ά��
    $client_cname = addslashes(trim($insert_data[4])); 

    //������̾�ʥեꥬ�ʡ�
    $client_read  = trim($insert_data[5]);

    //͹���ֹ�
    $post_data    = explode("-", $insert_data[8]);
    $post_no1     = trim($post_data[0]);
    $post_no2     = trim($post_data[1]);

    //����1
    $address1     = trim($insert_data[9]);

    //���ꣲ
    $address2     = trim($insert_data[10]);

    //TEL
    $tel          = trim($insert_data[11]);

    //FAX
    $fax          = trim($insert_data[12]);

    //����
    if($insert_data[18] == '*'){
        $state    = '2';
    }else{
        $state    = '1';
    }

    //���������
    if(strlen(trim($insert_data[19])) == '10'){
        $cont_sday = $insert_data[19];
    }

    //��ɽ��
    $rep_name     = trim($insert_data[22]);

    //ô���ԣ�
    $charger      = trim($insert_data[23]);

    //ô������
    $charger_part = trim($insert_data[24]);
 
    //����
    if($insert_data[25] > 28 || $insert_data[25] == 0){
        $close_day = 29;
    }else{
        $close_day = (int)trim($insert_data[25]);
    }

    //������
    //��
    if(trim($insert_data[26]) == 0){
        $pay_m = '1';
    }else{
        $pay_m = (int)trim($insert_data[26]);
    }
    //��
    if($insert_data[27] > 28 || trim($insert_data[27]) == 0){
        $pay_d = '29';
    }else{
        $pay_d = (int)trim($insert_data[27]);
    }

    //������ޥ�������Ͽ
    $sql  = "INSERT INTO t_client (\n";
    $sql .= "    client_id,\n";                    //������ID
    $sql .= "    client_cd1,\n";                   //�����襳����
    $sql .= "    client_cd2,\n";                   //��Ź������
    $sql .= "    client_name,\n";                  //������̾
    $sql .= "    client_name2,\n";                 //������̾    
    $sql .= "    client_cname,\n";                 //ά��
    $sql .= "    client_read,\n";                  //������̾�ʥեꥬ�ʡ�
    $sql .= "    post_no1,\n";                     //͹���ֹ棱
    $sql .= "    post_no2,\n";                     //͹���ֹ棲
    $sql .= "    address1,\n";                     //���꣱
    $sql .= "    address2,\n";                     //���ꣲ
    $sql .= "    tel,\n";                          //TEL
    $sql .= "    fax,\n";                          //FAX
    $sql .= "    url,\n";                          //URL
    $sql .= "    state,\n";                        //����
    if($cont_sday != null){
        $sql .= "    cont_sday,\n";                    //���󳫻���
    }
    $sql .= "    rep_name,\n";                     //��ɽ��
    $sql .= "    charger1,\n";                     //ô���ԣ�
    $sql .= "    charger_part1,\n";                //ô������
    $sql .= "    close_day,\n";                    //����
    $sql .= "    pay_m,\n";                        //��ʧ���ʷ��
    $sql .= "    pay_d,\n";                        //��ʧ��������
    $sql .= "    coax,\n";                         //�ݤ��ʬ
    $sql .= "    tax_franct,\n";                   //ü����ʬ
    $sql .= "    tax_div,\n";                      //����ñ�� 
    $sql .= "    client_div,\n";                   //������ʬ
    $sql .= "    shop_div,\n";                     //�ܼһټҶ�ʬ
    $sql .= "    slip_out,\n";                     //��ɼ����
    $sql .= "    trade_id,\n";                     //�����ʬ
    $sql .= "    claim_out,\n";                    //��������
    $sql .= "    area_id,\n";                      //�϶��ID
    $sql .= "    sbtype_id,\n";                    //�ȼ�ID
    $sql .= "    create_day,\n";                   //������
    $sql .= "    shop_id,\n";                      //����å�ID
    $sql .= "    his_client_cd1,\n";               //����襳���ɣ��������
    $sql .= "    his_client_cd2,\n";               //����襳���ɣ��������
    $sql .= "    his_client_name,\n";              //�����̾
    $sql .= "    type,\n";                         //����
    $sql .= "    compellation,\n";                 //�ɾ�
    $sql .= "    bank_div,\n";                     //��Լ������ô��ʬ
    $sql .= "    deliver_effect,\n";               //�����ɼ������
    $sql .= "    claim_send\n";                    //���������
    $sql .= ")VALUES(\n";
    $sql .= "    (SELECT MAX(client_id)+1 FROM t_client),\n";
    $sql .= "    '$client_cd1',\n";                 //�����襳����
    $sql .= "    '$client_cd2',\n";                 //��Ź������
    $sql .= "    '$client_name1',\n";                //������̾
    $sql .= "    '$client_name2',\n";               //������̾
    $sql .= "    '$client_cname',\n";               //ά��
    $sql .= "    '$client_read',\n";                //������̾�ʥեꥬ��)
    $sql .= "    '$post_no1',\n";                   //͹���ֹ棱
    $sql .= "    '$post_no2',\n";                   //͹���ֹ棲
    $sql .= "    '$address1',\n";                   //���꣱
    $sql .= "    '$address2',\n";                   //���ꣲ
    $sql .= "    '$tel',\n";                        //TEL
    $sql .= "    '$fax',\n";                        //FAX
    $sql .= "    '$url',\n";                        //URL
    $sql .= "    '$state',\n";                      //����
    if($cont_sday != null){
        $sql .= "    '$cont_sday',\n";                  //���󳫻���
    }
    $sql .= "    '$rep_name',\n";                   //��ɽ��
    $sql .= "    '$charger',\n";                    //ô���ԣ�
    $sql .= "    '$charger_part',\n";               //ô������
    $sql .= "    '$close_day',\n";                  //����
    $sql .= "    '$pay_m',\n";                      //��ʧ���ʷ��
    $sql .= "    '$pay_d',\n";                      //��ʧ��������
    $sql .= "    '1',\n";                           //�ݤ��ʬ
    $sql .= "    '1',\n";                           //ü����ʬ
    $sql .= "    '1',\n";                           //����ñ��
    $sql .= "    '1',\n";                           //������ʬ
    $sql .= "    '',\n";                            //�ܼҡ��ټҶ�ʬ
    $sql .= "    '1',\n";                           //��ɼ����
    $sql .= "    '11',\n";                          //�����ʬ
    $sql .= "    '1',\n";                           //��������
    $sql .= "    305,\n";                           //�϶�ID(��ǥ������϶�)
    $sql .= "    62,\n";                            //�ȼ�ID�ʤ���¾��
    $sql .= "    NOW(),\n";                         //������
    $sql .= "    189,\n";                           //����å�ID�ʥ�ǥ����ݡ�
    $sql .= "    '$client_cd1',\n";                 //�����襳���ɣ�
    $sql .= "    '$client_cd2',\n";                 //�����襳���ɣ� 
    $sql .= "    '$client_name',\n";                //������̾
    $sql .= "    '1',\n";                           //����
    $sql .= "    '1',\n";                           //�ɾ�
    $sql .= "    '1',\n";                           //��Լ������ô��ʬ
    $sql .= "    '1',\n";                           //�����ɼ������
    $sql .= "    '1'\n";                            //���������
    $sql .= ");";

    $result = Db_Query($db_con, $sql);

    if($result === false){
        print_array($sql);
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    //������ID�����
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

    //�����襳���ɣ�
    $claim_cd1  = str_pad(trim($insert_data[6]), 6, 0, STR_PAD_LEFT);

    //�����襳���ɣ�
    $claim_cd2  = str_pad(trim($insert_data[7]), 4, 0, STR_PAD_LEFT);

    //������ID�����
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
