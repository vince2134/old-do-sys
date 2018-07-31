<?php
//タイトル
$page_title = "DB登録";


if($_POST["submit"] == "実行"){


    //環境設定ファイル
    require_once("ENV_local.php");
    require_once("file.fnc");

    //DB接続
    $db_con = Db_Connect();

    $file_name = "/usr/local/apache2/htdocs/amenity/src/sample/updata/amenity_client_history.csv";

    $file = fopen($file_name, "r");

    Db_Query($db_con, "BEGIN;");

    //行ループ
    $j = 1;
    while($file_data = fgets($file, "1000") ){

        $insert_data = explode(',',$file_data);

        $client_id       = stripslashes(trim($insert_data[0]));
        $his_client_cd1  = stripslashes(trim($insert_data[1]));
        $his_client_cd2  = stripslashes(trim($insert_data[2]));
        $his_client_name = stripslashes(trim($insert_data[3]));

        $sql  = "UPDATE\n";
        $sql .= "   t_client \n";
        $sql .= "SET\n";
        $sql .= "   his_client_cd1  = '$his_client_cd1', \n";
        $sql .= "   his_client_cd2  = '$his_client_cd2', \n";
        $sql .= "   his_client_name = '$his_client_name' \n";
        $sql .= "WHERE\n";
        $sql .= "   client_id = $client_id\n";
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
    <form action="./his_client.php" method="post">
    <input type="submit" name="submit" value="実行">
    </form>
</body>
</html>
