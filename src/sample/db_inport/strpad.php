<?php

require_once("ENV_local.php");
$conn = Db_Connect("");

//得意先として登録してあるもの
$sql .= "SELECT COUNT(client_id) FROM t_client WHERE client_div = '1';";
$result = Db_Query($conn, $sql);
$num = pg_fetch_result($result,0,0);

//Db_Query($conn, "BEGIN");
//件数分ループ
for($i = 0; $i < $num; $i++){
    $sql  = "SELECT";
    $sql .= "   client_id,";
    $sql .= "   client_cd1,";
    $sql .= "   client_cd2,";
    $sql .= "   shop_gid";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_div = '1'";
    $sql .= " ORDER BY client_cd1, client_cd2 LIMIT 1 offset $i;";

    $result = Db_Query($conn, $sql);
    $id  = pg_fetch_result($result, 0,0);                   //得意先ID
    $bfr_cd1 = pg_fetch_result($result ,0,1);               //得意先コード１
    $bfr_cd2 = pg_fetch_result($result ,0,2);               //得意先コード２
    $shop_gid = pg_fetch_result($result, 0,3);              //FCグループID

    if(strlen($bfr_cd1) < 6 || strlen($bfr_cd2) < 4){

        $aft_cd1 = str_pad($bfr_cd1, 6, 0, STR_PAD_LEFT); 
        $aft_cd2 = str_pad($bfr_cd2, 4, 0, STR_PAD_LEFT); 
/*
        $sql  = "SELECT";
        $sql .= "   client_id";
        $sql .= " FROM";
        $sql .= "   t_client";
        $sql .= " WHERE";
        $sql .= "   client_div = '1'";
        $sql .= "   AND";
        $sql .= "   client_cd1 = '$aft_cd1'";
        $sql .= "   AND";
        $sql .= "   client_cd2 = '$aft_cd2'";
        $sql .= "   AND";
        $sql .= "   shop_gid   = $shop_gid";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $duplicate_id =  @pg_fetch_result($result,0,0);

        print $duplicate_id."<br>";
*/

        $sql  = "UPDATE t_client SET";
        $sql .= "   client_cd1 = '$aft_cd1',";
        $sql .= "   client_cd2 = '$aft_cd2'";
        $sql .= " WHERE";
        $sql .= "   client_id = $id ;";

        $result = Db_Query($conn, $sql);
        if($result === false){
            $sql  = "UPDATE t_client SET";
            $sql .= "   client_cd1 = '$aft_cd1',";
            $sql .= "   client_cd2 = '9999'";
            $sql .= " WHERE";
            $sql .= "   client_id =$id ;";

            $result = Db_Query($conn, $sql);
/*
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
*/
        }
    }
}

//Db_Query($conn, "COMMIT");

?>
