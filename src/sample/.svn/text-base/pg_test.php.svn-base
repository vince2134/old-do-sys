<?php

//環境設定ファイル
require_once("ENV_local.php");

print "部署マスタから全件抽出するSQL対決";
print "<br>";

print "エグゼキュート";
print "<br>　　VS<br>";
print "通常<br><br><hr>";


$conn = Db_Connect();

$sql = "SELECT";
$sql .= "   part_cd,";
$sql .= "   shop_id ";
$sql .= "FROM";
$sql .= "   t_part ";
$sql .= ";";

$result = Db_Query($conn, $sql);

$var = pg_fetch_all($result);

//-----------------------------------------------------

print "エグゼキュート使用時<br>";
$start = getmicrotime();
$data ="select * from t_part where shop_id = $1 AND part_cd = $2";

$sql = "PREPARE sample(int, varchar) AS $data ";
Db_Query($conn, $sql);

for($i = 0; $i < count($var); $i++){

    $sql = "EXECUTE sample(".$var[$i][shop_id]." , '".$var[$i][part_cd]."')";

    $result = @Db_Query($conn, $sql);
    $data = pg_fetch_all($result);
}

$end = getmicrotime();
print $a = (float)$end - (float)$start;

//-------------------------------------------------------


print "<hr>";
print "通常時<br>";
$start = getmicrotime();

for($i = 0; $i < count($var); $i++){
    $sql = "SELECT";
    $sql .= "   *";
    $sql .= "FROM";
    $sql .= "   t_part ";
    $sql .= "WHERE";
    $sql .= "   shop_id = ".$var[$i][shop_id];
    $sql .= "   AND";
    $sql .= "   part_cd = '".$var[$i][part_cd]."'";
    $sql .= ";";

    $result = @Db_Query($conn, $sql);
    $data = pg_fetch_all($result);
}

$end = getmicrotime();
print $b = (float)$end - (float)$start;

if($a < $b){
    print "<hr><br>エグゼキュートの勝利";
}else{
    print "<hr><br>通常の勝利";
}


function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$sec + (float)$usec);
}

?>
