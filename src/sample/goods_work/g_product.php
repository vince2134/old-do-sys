<?php
//�����ȥ�
$page_title = "DB��Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect("watanabe-k");

if($_POST[submit] == "�С�Ͽ"){


    Db_Query($db_con, "BEGIN");

    //�����ɤο����ؤ�
    //�����ߤΥ����ɤ����
    $sql1  = "SELECT";
    $sql1 .= "   g_product_id,\n";
    $sql1 .= "   g_product_cd \n";
    $sql1 .= "FROM\n";
    $sql1 .= "   t_g_product \n";
    $sql1 .= "WHERE\n";
    $sql1 .= "   shop_id = 1\n";
    $sql1 .= ";";

    $result = Db_Query($db_con, $sql1);

    $g_product_data = pg_fetch_all($result);

    for($i = 0, $new_cd = 4000; $i < count($g_product_data); $i++, $new_cd++){
   
        $sql  = "UPDATE\n";
        $sql .= "   t_g_product \n";
        $sql .= "SET\n";
        $sql .= "   g_product_cd = '$new_cd'\n ";
        $sql .= "WHERE\n";
        $sql .= "   g_product_id = ".$g_product_data[$i]['g_product_id']."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
    }

    $result = Db_Query($db_con, $sql1);
    
    //�ե�����򳫤�
    $handle = fopen("./20061215/g_product.txt", "r");

    //�ԥ롼��
    while($csv_data = fgets($handle, "1000") ){

        $insert_data = explode(',',$csv_data);

        $insert_data[0] = addslashes(trim($insert_data[0]));
        $insert_data[1] = addslashes(trim($insert_data[1]));
        $insert_data[2] = addslashes(trim($insert_data[2]));

        $sql  = "INSERT INTO t_g_product (";
        $sql .= "   g_product_id,\n";
        $sql .= "   g_product_cd, \n";
        $sql .= "   g_product_name,\n";
        $sql .= "   note, \n";
        $sql .= "   public_flg, \n";
        $sql .= "   accept_flg, \n";
        $sql .= "   shop_id, \n";
        $sql .= "   update_flg \n";
        $sql .= ") VALUES (\n";
        $sql .= "   (SELECT COALESCE(MAX(g_product_id),0)+1 FROM t_g_product),\n";
        $sql .= "   '$insert_data[0]',\n";
        $sql .= "   '$insert_data[1]',\n";
        $sql .= "   '$insert_data[2]',\n";
        $sql .= "   't',\n";
        $sql .= "   '1',\n";
        $sql .= "   1,\n";
        $sql .= "   't' \n";
        $sql .= ");\n";

        $result = Db_Query($db_con, $sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACk;");
            exit;
        }
    }
    Db_Query($db_con, "COMMIT");

    print '��������λ';

}

?>

<html>
<head>
<title>����ʬ�ࢪ����ʬ��</title>
</head>
<body>
<form method="post" action=./g_product.php>
    <input type="submit" name="submit" value="�С�Ͽ">
</form>

</body>
</html>






