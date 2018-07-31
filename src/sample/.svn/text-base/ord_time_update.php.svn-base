<?php
/**
    発信日の登録されていないレコードを抽出し、発注日でアップデートする
**/

require_once("ENV_local.php");

$conn = Db_Connect();


if($_POST["start"] == "実　行"){

    Db_Query($conn, "BEGIN;");

    //発信日の入っていないデータを抽出
    $sql  = "SELECT\n";
    $sql .= "   ord_id,\n";
    $sql .= "   ord_time\n";
    $sql .= " FROM\n";
    $sql .= "   t_order_h\n";
    $sql .= " WHERE\n";
    $sql .= "   send_date IS NULL\n";
    $sql .= ";\n";

    $res = Db_Query($conn, $sql);
    $num = pg_num_rows($res);

    //上記で抽出したデータ分ループ
    for($i = 0; $i < $num; $i++){
        $ord_data = pg_fetch_array($res, $i);

        $ord_id   = $ord_data["ord_id"];            //発注ID
        $ord_time = $ord_data["ord_time"];          //発注日

        //発信日をアップデート
        $sql  = "UPDATE \n";
        $sql .= "   t_order_h \n";
        $sql .= "SET \n";
        $sql .= "   send_date = '$ord_time' \n";
        $sql .= "WHERE \n";
        $sql .= "   ord_id = $ord_id \n";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, 'ROLLBACK;');
            exit;
        }else{
            print $sql."<br>";
        }
    }

    Db_Query($conn, "COMMIT;");

    print "完了";
}
?>
<html>
    <head>
        <title></title>
    </head>
<body>
<form method="post" action="./ord_time_update.php">
<input type="submit" name="start" value="実　行">
</form>
</body>
</html>
