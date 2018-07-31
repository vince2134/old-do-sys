<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect("watanabe-k");

if($_POST[submit] == "登　録"){


    Db_Query($db_con, "BEGIN");

    //ファイルを開く
    $handle = fopen("t_goods2.txt", "r");

    //行ループ
    while($csv_data = fgets($handle, "1000") ){

        $insert_data = explode(',',$csv_data);

        $insert_data["g_goods_cd"]      = str_pad($insert_data[0], '4', '0', STR_PAD_LEFT);
        $insert_data["product_cd"]      = str_pad($insert_data[1], '4', '0', STR_PAD_LEFT);
        $insert_data["g_product_cd"]    = str_pad($insert_data[2], '4', '0', STR_PAD_LEFT);
        $insert_data["goods_cd"]        = str_pad($insert_data[4], '8', '0', STR_PAD_LEFT);
        $insert_data["goods_name"]      = addslashes(trim($insert_data[5]));
        $insert_data["goods_cname"]     = addslashes(trim($insert_data[6]));

        $sql  = "UPDATE\n";
        $sql .= "   t_goods \n";
        $sql .= "SET\n";
        $sql .= "   goods_name = '$insert_data[goods_name]',";
        $sql .= "   goods_cname = '$insert_data[goods_cname]',";
        $sql .= "   g_goods_id = (SELECT g_goods_id FROM t_g_goods WHERE g_goods_cd = '".$insert_data[g_goods_cd]."'),\n";
        $sql .= "   product_id = (SELECT product_id FROM t_product WHERE product_cd = '".$insert_data[product_cd]."'), \n";
        $sql .= "   g_product_id = (SELECT g_product_id FROM t_g_product WHERE g_product_cd = '".$insert_data[g_product_cd]."'), \n";
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

    print '完　　　了';

}

?>

<html>
<head>
<title>商品データ更新</title>
</head>
<body>
<form method="post" action=./goods2.php>
    <input type="submit" name="submit" value="登　録">
</form>

</body>
</html>






