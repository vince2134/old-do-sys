<?php
//タイトル
$page_title = "DB登録";


if($_POST["submit"] == "実行"){


    //環境設定ファイル
    require_once("ENV_local.php");
    require_once("file.fnc");

    //DB接続
    $db_con = Db_Connect();

    $file_name = "/usr/local/apache2/htdocs/amenity/src/sample/updata/amenity_goods_history.csv";

    $file = fopen($file_name, "r");

    Db_Query($db_con, "BEGIN;");

    //行ループ
    $j = 1;
    while($file_data = fgets($file, "1000") ){

        $insert_data = explode(',',$file_data);

        $goods_id       = addslashes(trim($insert_data[0]));
        $his_goods_cd   = addslashes(trim($insert_data[1]));
        $his_goods_name = addslashes(trim($insert_data[2]));

        $sql  = "UPDATE\n";
        $sql .= "   t_goods \n";
        $sql .= "SET\n";
        $sql .= "   his_goods_cd   = '$his_goods_cd ', \n";
        $sql .= "   his_goods_name = '$his_goods_name' \n";
        $sql .= "WHERE\n";
        $sql .= "   goods_id = $goods_id\n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }else{
            print "OK <br>";
        }
    }
    Db_Query($db_con, "COMMIT;");
}

?>

<html>
<head>
<title></title>
</head>
<body>
    <form action="./his_goods.php" method="post">
    <input type="submit" name="submit" value="実行">
    </form>
</body>
</html>
