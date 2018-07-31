<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

if($_POST[submit] == "登　録"){


    Db_Query($db_con, "BEGIN");

    //コードの振り替え
    //今現在のコードを抽出
    $sql1  = "SELECT";
    $sql1 .= "   product_id,\n";
    $sql1 .= "   product_cd \n";
    $sql1 .= "FROM\n";
    $sql1 .= "   t_product \n";
    $sql1 .= "WHERE\n";
    $sql1 .= "   shop_id = 1\n";
    $sql1 .= ";";

    $result = Db_Query($db_con, $sql1);

    $product_data = pg_fetch_all($result);

    for($i = 0, $new_cd = 9000; $i < count($product_data); $i++, $new_cd++){
   
        $sql  = "UPDATE\n";
        $sql .= "   t_product \n";
        $sql .= "SET\n";
        $sql .= "   product_cd = '$new_cd'\n ";
        $sql .= "WHERE\n";
        $sql .= "   product_id = ".$product_data[$i]['product_id']."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
    }

    $result = Db_Query($db_con, $sql1);
    
    //ファイルを開く
    $handle = fopen("t_product.txt", "r");

    //行ループ
    while($csv_data = fgets($handle, "1000") ){

        $insert_data = explode(',',$csv_data);

        $insert_data[0] = addslashes(trim($insert_data[0]));
        $insert_data[1] = addslashes(trim($insert_data[1]));

        $sql  = "INSERT INTO t_product (";
        $sql .= "   product_id,\n";
        $sql .= "   product_cd, \n";
        $sql .= "   product_name,\n";
        $sql .= "   public_flg, \n";
        $sql .= "   accept_flg, \n";
        $sql .= "   shop_id, \n";
        $sql .= "   update_flg \n";
        $sql .= ") VALUES (\n";
        $sql .= "   (SELECT COALESCE(MAX(product_id),0)+1 FROM t_product),\n";
        $sql .= "   '$insert_data[0]',\n";
        $sql .= "   '$insert_data[1]',\n";
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

print "完　　　了";
}

?>

<html>
<head>
<title>管理区分→管理区分</title>
</head>
<body>
<form method="post" action=./product.php>
    <input type="submit" name="submit" value="登　録">
</form>

</body>
</html>






