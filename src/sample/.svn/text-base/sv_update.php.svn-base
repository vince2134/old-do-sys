<?php



require_once("ENV_local.php");

$db_con = Db_Connect("amenity_demo_new");

$sql  = "SELECT";
$sql .= "   client_id,";
$sql .= "   c_staff_id1,";
$sql .= "   c_staff_id2,";
$sql .= "   d_staff_id1,";
$sql .= "   d_staff_id2,";
$sql .= "   d_staff_id3";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_div ='3'";
$sql .= ";";

$res = Db_Query($db_con, $sql);
$data_num = pg_num_rows($res);

print $data_num."<hr>";

Db_Query($db_con,"BEGIN;");

$j = 0;
for($i = 0; $i < $data_num; $i++){
    $up_data = pg_fetch_array($res, $i);

    if($up_data["c_staff_id1"] != null){
        $sql  = "UPDATE t_client SET\n";
        $sql .= "   sv_staff_id = ".$up_data["c_staff_id1"]."\n";
        $sql .= " WHERE\n";
        $sql .= "   t_client.client_id = ".$up_data["client_id"]."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }
    }

    if($up_data["c_staff_id2"] != null){
        $sql  = "UPDATE t_client SET\n";
        $sql .= "   b_staff_id1 = ".$up_data["c_staff_id2"]."\n";
        $sql .= " WHERE\n";
        $sql .= "   t_client.client_id = ".$up_data["client_id"]."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }
    }

    if($up_data["d_staff_id1"] != null){
        $sql  = "UPDATE t_client SET\n";
        $sql .= "   b_staff_id2 = ".$up_data["d_staff_id1"]."\n";
        $sql .= " WHERE\n";
        $sql .= "   t_client.client_id = ".$up_data["client_id"]."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }
    }

    if($up_data["d_staff_id2"] != null){
        $sql  = "UPDATE t_client SET\n";
        $sql .= "   b_staff_id3 = ".$up_data["d_staff_id2"]."\n";
        $sql .= " WHERE\n";
        $sql .= "   t_client.client_id = ".$up_data["client_id"]."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }
    }

    if($up_data["d_staff_id3"] != null){
        $sql  = "UPDATE t_client SET\n";
        $sql .= "   b_staff_id4 = ".$up_data["d_staff_id3"]."\n";
        $sql .= " WHERE\n";
        $sql .= "   t_client.client_id = ".$up_data["client_id"]."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }
    }
    $j = $j+1;
}

print $j;
Db_Query($db_con,"COMMIT;");

?>
