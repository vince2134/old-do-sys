<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect("watanabe-k");

if($_POST[submit] == "登　録"){


    Db_Query($db_con, "BEGIN");

    //コードの振り替え
    //今現在のコードを抽出
    $sql1  = "SELECT";
    $sql1 .= "   g_goods_id,\n";
    $sql1 .= "   g_goods_cd \n";
    $sql1 .= "FROM\n";
    $sql1 .= "   t_g_goods \n";
    $sql1 .= "WHERE\n";
    $sql1 .= "   shop_id = 1\n";
    $sql1 .= ";";

    $result = Db_Query($db_con, $sql1);

    $g_goods_data = pg_fetch_all($result);

    for($i = 0, $new_cd = 2000; $i < count($g_goods_data); $i++, $new_cd++){
   
        $sql  = "UPDATE\n";
        $sql .= "   t_g_goods \n";
        $sql .= "SET\n";
        $sql .= "   g_goods_cd = '$new_cd'\n ";
        $sql .= "WHERE\n";
        $sql .= "   g_goods_id = ".$g_goods_data[$i]['g_goods_id']."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
    }

    $result = Db_Query($db_con, $sql1);
    
    //ファイルを開く
    $handle = fopen("./20061215/g_goods.txt", "r");

    //行ループ
    while($csv_data = fgets($handle, "1000") ){

        $insert_data = explode(',',$csv_data);

        $insert_data[0] = addslashes(trim($insert_data[0]));
        $insert_data[1] = addslashes(trim($insert_data[1]));
        $insert_data[2] = addslashes(trim($insert_data[2]));

        $sql  = "INSERT INTO t_g_goods (";
        $sql .= "   g_goods_id,\n";
        $sql .= "   g_goods_cd, \n";
        $sql .= "   g_goods_name,\n";
        $sql .= "   note, \n";
        $sql .= "   public_flg, \n";
        $sql .= "   accept_flg, \n";
        $sql .= "   shop_id, \n";
        $sql .= "   update_flg \n";
        $sql .= ") VALUES (\n";
        $sql .= "   (SELECT COALESCE(MAX(g_goods_id),0)+1 FROM t_g_goods),\n";
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

    print '完　　　了';

}

?>

<html>
<head>
<title>Ｍ区分→M区分</title>
</head>
<body>
<form method="post" action=./g_goods.php>
    <input type="submit" name="submit" value="登　録">
</form>

</body>
</html>






