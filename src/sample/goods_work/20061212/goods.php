<?php
//�����ȥ�
$page_title = "DB��Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

if($_POST[submit] == "�С�Ͽ"){


    Db_Query($db_con, "BEGIN");

    //�ե�����򳫤�
    $handle = fopen("t_goods.txt", "r");

    //�ԥ롼��
    while($csv_data = fgets($handle, "1000") ){

        $insert_data = explode(',',$csv_data);

        $insert_data["g_goods_cd"]  = str_pad($insert_data[0], '4', '0', STR_PAD_LEFT);
        $insert_data["product_cd"]  = str_pad($insert_data[1], '4', '0', STR_PAD_LEFT);
        $insert_data["goods_cd"]    = str_pad($insert_data[2], '8', '0', STR_PAD_LEFT);
        $insert_data["goods_name"]  = addslashes(trim($insert_data[3]));
        $insert_data["goods_cname"] = addslashes(trim($insert_data[4]));

        $sql  = "UPDATE\n";
        $sql .= "   t_goods \n";
        $sql .= "SET\n";
        $sql .= "   goods_name = '$insert_data[goods_name]',";
        $sql .= "   goods_cname = '$insert_data[goods_cname]',";
        $sql .= "   g_goods_id = (SELECT g_goods_id FROM t_g_goods WHERE g_goods_cd = '".$insert_data[g_goods_cd]."'),\n";
        $sql .= "   product_id = (SELECT product_id FROM t_product WHERE product_cd = '".$insert_data[product_cd]."'), \n";
        $sql .= "   update_flg = 't'\n";
        $sql .= "WHERE\n";
        $sql .= "   goods_id = (\n";
        $sql .= "               SELECT\n";
        $sql .= "                    goods_id\n";
        $sql .= "               FROM\n";
        $sql .= "                    t_goods\n";
        $sql .= "               WHERE\n";
        $sql .= "                   goods_cd = '".$insert_data[goods_cd]."'\n";
        $sql .= "                   AND\n";
        $sql .= "                   public_flg = 't'\n";
        $sql .= "                   AND\n";
        $sql .= "                   compose_flg = 'f'\n";
        $sql .= "                   AND\n";
        $sql .= "                   shop_id = 1\n";
        $sql .= "           )\n";
        $sql .= ";\n";

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
<title>���ʥǡ�������</title>
</head>
<body>
<form method="post" action=./goods.php>
    <input type="submit" name="submit" value="�С�Ͽ">
</form>

</body>
</html>






