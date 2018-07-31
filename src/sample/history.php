<?php
//¼è¤ê¹þ¤ß»þ¤Î¥Ç¡¼¥¿¤ò¥Þ¥¹¥¿¤Ë»Ä¤¹

require_once("ENV_local.php");

//¥Ü¥¿¥ó¤¬²¡¤µ¤ì¤¿¤é½èÍý³«»Ï
if($_POST["submit"] == "ÍúÎòÅÐÏ¿"){

$con = Db_Connect("demo_0405");

//­¡4·î5Æü»þÅÀ¤ÎÆÀ°ÕÀè
$sql  = "SELECT";
$sql .= "   client_id,";
$sql .= "   client_cd1,";
$sql .= "   client_cd2,";
$sql .= "   client_name";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   shop_gid = 43";
$sql .= "   AND";
$sql .= "   client_div = '1'";
$sql .= ";";

$result = Db_Query($con, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $client_data[] = pg_fetch_array($result, $i);

}

//­¢4·î5Æü»þÅÀ¤Î¾¦ÉÊ
$sql  = "SELECT";
$sql .= "   goods_id,";
$sql .= "   goods_cd,";
$sql .= "   goods_name";
$sql .= " FROM";
$sql .= "   t_goods";
$sql .= " WHERE";
$sql .= "   public_flg = 't'";
$sql .= ";";

$result = Db_Query($con, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $goods_data[] = pg_fetch_array($result, $i);
}

//­£4·î5Æü»þÅÀ¤Î¾¦ÉÊ·²
$sql  = "SELECT";
$sql .= "   g_goods_id,";
$sql .= "   g_goods_cd,";
$sql .= "   g_goods_name";
$sql .= " FROM";
$sql .= "   t_g_goods";
$sql .= " WHERE";
$sql .= "   public_flg = 't'";
$sql .= ";";

$result = Db_Query($con, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $g_goods_data[] = pg_fetch_array($result, $i);
}

//­¤4·î5Æü»þÅÀ¤ÎÀ½ÉÊ¶èÊ¬
$sql  = "SELECT";
$sql .= "   product_id,";
$sql .= "   product_cd,";
$sql .= "   product_name";
$sql .= " FROM";
$sql .= "   t_product";
$sql .= " WHERE";
$sql .= "   public_flg = 't'";
$sql .= ";";   


$result = Db_Query($con, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $product_data[] = pg_fetch_array($result, $i);
}
print "<pre>";
print_r($product_data);


//­¥4·î5Æü»þÅÀ¤Î»ÅÆþÀè
$sql  = "SELECT";
$sql .= "   client_id,";
$sql .= "   client_cd1,";
$sql .= "   client_name";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_div = '2'";
$sql .= "   AND";
$sql .= "   shop_gid = 1";
$sql .= ";";

$result = Db_Query($con, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $supplier_data[] = pg_fetch_array($result, $i);
}

//­¥4·î5Æü»þÅÀ¤ÎFC
$sql  = "SELECT";
$sql .= "   client_id,";
$sql .= "   client_cd1,";
$sql .= "   client_cd2,";
$sql .= "   client_name";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_div = '3'";
$sql .= ";";

$result = Db_Query($con, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $fc_data[] = pg_fetch_array($result, $i);
}


/*
$con = Db_Connect();
Db_Query($con, "BEGIN;");

//ÆÀ°ÕÀè
for($i = 0; $i < count($client_data); ++$i){
    $sql  = "UPDATE t_client SET";
    $sql .= "   his_client_cd1 = '".$client_data[$i][client_cd1]."',";
    $sql .= "   his_client_cd2 = '".$client_data[$i][client_cd2]."',";
    $sql .= "   his_client_name = '".$client_data[$i][client_name]."'";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$client_data[$i][client_id]."";
    $sql .= ";";

    $result = Db_Query($con, $sql);
    if($result === false ){
        print $sql."<br>";
    }
}

print "<hr>";

//¾¦ÉÊ
for($i = 0; $i < count($goods_data); ++$i){
    $sql  = "UPDATE t_goods SET";
    $sql .= "   his_goods_cd = '".$goods_data[$i][goods_cd]."',";
    $sql .= "   his_goods_name = '".addslashes($goods_data[$i][goods_name])."'";
    $sql .= " WHERE";
    $sql .= "   goods_id = ".$goods_data[$i][goods_id]."";
    $sql .= ";";

    $result = Db_Query($con, $sql);
    if($result === false ){
        print $sql."<br>";
    }
}
print "<hr>";

//¾¦ÉÊ·²
for($i = 0; $i < count($g_goods_data); ++$i){
    $sql  = "UPDATE t_g_goods SET";
    $sql .= "   his_g_goods_cd = '".$g_goods_data[$i][g_goods_cd]."',";
    $sql .= "   his_g_goods_name = '".$g_goods_data[$i][g_goods_name]."'";
    $sql .= " WHERE";
    $sql .= "   g_goods_id = ".$g_goods_data[$i][g_goods_id]."";
    $sql .= ";";

    $result = Db_Query($con, $sql);
    if($result === false ){
        print $sql."<br>";
    }
}
print "<hr>";

//À½ÉÊ¶èÊ¬
for($i = 0; $i < count($product_data); ++$i){
    $sql  = "UPDATE t_product SET";
    $sql .= "   his_product_cd = '".$product_data[$i][product_cd]."',";
    $sql .= "   his_product_name = '".$product_data[$i][product_name]."'";
    $sql .= " WHERE";
    $sql .= "   product_id = ".$product_data[$i][product_id]."";
    $sql .= ";";

    $result = Db_Query($con, $sql);
    if($result === false ){
        print $sql."<br>";
    }
}
print "<hr>";

//»ÅÆþÀè
for($i = 0; $i < count($supplier_data); ++$i){
    $sql  = "UPDATE t_client SET";
    $sql .= "   his_client_cd1 = '".$supplier_data[$i][client_cd1]."',";
    $sql .= "   his_client_name = '".$supplier_data[$i][client_name]."'";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$supplier_data[$i][client_id]."";
    $sql .= ";";   

    $result = Db_Query($con, $sql);
    if($result === false ){
        print $sql."<br>";
    }
}
print "<hr>";

//FC
for($i = 0; $i < count($fc_data); ++$i){
    $sql  = "UPDATE t_client SET";
    $sql .= "   his_client_cd1 = '".$fc_data[$i][client_cd1]."',";
    $sql .= "   his_client_cd2 = '".$fc_data[$i][client_cd2]."',";
    $sql .= "   his_client_name = '".$fc_data[$i][client_name]."'";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$fc_data[$i][client_id]."";
    $sql .= ";";

    $result = Db_Query($con, $sql);
    if($result === false ){
        print $sql."<br>";
    }
}

Db_Query($con, "COMMIT;");
*/
}
?>
<html>
<head></head>
<body>
<form action="./history.php" method="post">
<input type="submit" name="submit" value="ÍúÎòÅÐÏ¿">
</form>
</body>
</html>


