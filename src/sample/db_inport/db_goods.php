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

    Db_Query($db_con, "BEGIN");

    //�ԥ롼��
    $j = 1;
    $k = 1;
    while($insert_data = fgetcsv($fp, "1000", "$l_ifs") ){
        
        for($i = 0; $i < count($insert_data); $i++){
            $insert_data[$i] = trim(pg_escape_string($insert_data[$i]));
        }


        /*******************************/
        //���ʥޥ���
        /*******************************/

        //���ʥ�����
        $goods_cd = str_pad($insert_data[0], 8, 0, STR_PAD_LEFT);

        //���ʶ�ʬ�ɣ�
        $product_cd = str_pad($insert_data[4], 4, 0, STR_PAD_LEFT);
        $sql  = "SELECT";
        $sql .= "   product_id";
        $sql .= " FROM";
        $sql .= "   t_product";
        $sql .= " WHERE";
        $sql .= "   product_cd = '$product_cd'";
        $sql .= "   AND";
        $sql .= "   public_flg = 't'";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $prodcut_id = pg_fetch_result($result,0,0);

        //�Ͷ�ʬ�ɣ�
        $g_goods_cd = str_pad($insert_data[5], 4, 0, STR_PAD_LEFT);
        $sql  = "SELECT";
        $sql .= "   g_goods_id";
        $sql .= " FROM";
        $sql .= "   t_g_goods";
        $sql .= " WHERE";
        $sql .= "   g_goods_cd = '$g_goods_cd'";
        $sql .= "   AND";
        $sql .= "   public_flg = 't'";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $g_goods_id = pg_fetch_result($result, 0,0);

        //���Ƕ�ʬ
        if($insert_data[15] == ''){
            $tax_div = '1';
        }elseif($insert_data[15] == '1'){
            $tax_div = '2';
        }elseif($isnert_data[15] == '2'){
            $tax_div = '3';
        }

        //��̾�ѹ�
        if($insert_data[16] == '2'){
            $name_change = '1';
        }elseif($insert_data[16] == ''){
            $name_change = '2';
        }

        //�߸˴���
        if($insert_data[17] == '1'){
            $stock_manage = '1';
        }else{
            $stock_manage = '2';
        }

        //�߸˸¤���
        if($insert_data[18] == ''){
            $stock_only = '2';
        }elseif($insert_data[18] == '1'){
            $stock_only = '1';
        }

        //��Ͽ����
        $insert_sql  = "INSERT INTO t_goods (";
        $insert_sql .= "    goods_id,";                 //���ʣɣ�
        $insert_sql .= "    goods_cd,";                 //���ʥ�����
        $insert_sql .= "    goods_name,";               //����̾
        $insert_sql .= "    goods_cname,";              //ά��
        $insert_sql .= "    attri_div,";                //°����ʬ
        $insert_sql .= "    product_id,";               //���ʶ�ʬ�ɣ�
        $insert_sql .= "    g_goods_id,";               //�Ͷ�ʬ�ɣ�
        $insert_sql .= "    unit,";                     //ñ��
        $insert_sql .= "    tax_div,";                  //���Ƕ�ʬ
        $insert_sql .= "    name_change,";              //��̾�ѹ�
        $insert_sql .= "    stock_manage,";             //�߸˴���
        $insert_sql .= "    stock_only,";               //�߸˸¤���
        $insert_sql .= "    sale_manage,";              //�������
        $insert_sql .= "    royalty,";                  //�����ƥ���ͭ��̵��
//        $insert_sql .= "    make_goods_flg,";           //��¤�ʥե饰
        $insert_sql .= "    public_flg,";               //��ͭ�ե饰
        $insert_sql .= "    shop_gid";                  //�ƣå��롼�ףɣ�
        $insert_sql .= ")VALUES(";
        $insert_sql .= "    $j,";                       //���ʣɣ�
        $insert_sql .= "    '$goods_cd',";              //���ʥ�����
        $insert_sql .= "    '$insert_data[1]',";        //����̾
        $insert_sql .= "    '$insert_data[2]',";        //ά��
        $insert_sql .= "    '$insert_data[3]',";        //°����ʬ
        $insert_sql .= "    $prodcut_id,";              //���ʶ�ʬID
        $insert_sql .= "    $g_goods_id,";              //�Ͷ�ʬID
        $insert_sql .= "    '$insert_data[6]',";        //ñ��
        $insert_sql .= "    '$tax_div',";               //���Ƕ�ʬ
        $insert_sql .= "    '$name_change',";           //��̾�ѹ�
        $insert_sql .= "    '$stock_manage',";          //�߸˴���
        $insert_sql .= "    '$stock_only',";            //�߸˸���
        $insert_sql .= "    '1',";                      //�������
        $insert_sql .= "    '' ,";                      //�����ƥ�
//        $insert_sql .= "    '',";
        $insert_sql .= "    't',";
        $insert_sql .= "    1";
        $insert_sql .= ");";

        $result = Db_Query($db_con, $insert_sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }

        /********************************/
        //����å��̾��ʾ���ơ��֥�
        /********************************/
        //��ʻ�����
        /*
        if($insert_data[8] != null){
            $sql  = "SELECT";
            $sql .= "   client_id";
            $sql .= " FROM";
            $sql .= "   client_cd1 = '$insert_data[8]'";
            $sql .= " WHERE";
            $sql .= "   shop_gid = 1";
            $sql .= "   AND";
            $sql .= "   client_div = '2'";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $client_id = pg_fetch_result($result, 0,0);
        }else{
            $client_id = null;
        }
        */

        //��Ͽ����
        $insert_sql  = "INSERT INTO t_goods_info (";
        $insert_sql .= "    goods_id,";                 //����ID
        $insert_sql .= "    in_num,";                   //����
        $insert_sql .= "    order_point,";              //ȯ����
        $insert_sql .= "    order_unit,";               //ȯ��ñ�̿�
        $insert_sql .= "    lead,";                     //�꡼�ɥ�����
        $insert_sql .= "    note,";                     //����
        $insert_sql .= "    supplier_id,";              //��ʻ�����
        $insert_sql .= "    compose_flg,";              //�����ʥե饰
        $insert_sql .= "    head_fc_flg,";              //������FC�ե饰
        $insert_sql .= "    shop_gid";                  //FC���롼��ID
        $insert_sql .= ")VALUES(";
        $insert_sql .= "    $j,";
        $insert_sql .= "    $insert_data[7],";
        if($insert_data[13] != ''){
            $insert_sql .= "    $insert_data[19],";
        }else{
            $insert_sql .= "    0,";
        } 
        $insert_sql .= "    ".($insert_data[20] != '')? $insert_data[20] : '' ."";
        $insert_sql .= "    ,";
        $insert_sql .= "    '$insert_data[21]',";
        $insert_sql .= "    '$insert_data[21]',";
        $insert_sql .= "    null,";
        $insert_sql .= "    false,";
        $insert_sql .= "    't',";
        $insert_sql .= "    1";
        $insert_sql .= ")";

        $result = Db_Query($db_con, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        /**************************************/
        //ñ���ơ��֥�
        /**************************************/
        $price[0] = $insert_data[9];
        $price[1] = $insert_data[10];

        $rprice[0] = $insert_data[11];
        $rprice[1] = $insert_data[12];

        $price_cdsy[0] = $insert_data[13];
        $price_cday[1] = $insert_data[14];

        $rank[0] = '1';
        $rank[1] = '4';

        for($s = 0; $s < 2; $s++){
            $insert_sql  = "INSERT INTO t_price(";
            $insert_sql .= "    price_id,"; 
            $insert_sql .= "    goods_id,";
            $insert_sql .= "    rank_cd,";
            $insert_sql .= "    cost_rate,";
            $insert_sql .= "    cost_price,";
            $insert_sql .= "    r_price,";
            $insert_sql .= "    shop_gid";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    $k,";
            $insert_sql .= "    $j,";
            $insert_sql .= "    '$rank[$s]',";
            $insert_sql .= "    '100',";
            $insert_sql .= "    $price[$s],";
            $insert_sql .= "    $price[$s],";
            $insert_sql .= "    1";
            $insert_sql .= ");";

            $result = Db_Query($db_con, $insert_sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            if($price_cday[$s] != ""){
                $insert_sql  = "INSERT INTO t_rprice (";
                $insert_sql .= "    price_id,";
                $insert_sql .= "    price,";
                $insert_sql .= "    rprice,";
                $insert_sql .= "    price_cday,";
                $insert_sql .= "    rprice_flg";
                $insert_sql .= " )VALUES(";
                $insert_sql .= "    $k,";
                $insert_sql .= "    $rprice[$s],";
                $insert_sql .= "    $price[$s],";
                $insert_sql .= "    '$price_cday[$s]',";
                $insert_sql .= "    't'";
                $insert_sql .= ");";

                $result = Db_Query($db_con, $insert_sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }
            }
            $k = $k+1;
        }

        $j = $j+1;
    }
    Db_Query($db_con, "COMMIT");

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
$form->addElement("link","price_link","","./db_price.php","price");
$form->display();

?>
