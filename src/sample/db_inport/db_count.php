<?php

require_once("ENV_local.php");
$db_con = Db_Connect("goods_test");


$sql = "SELECT goods_cname FROM t_goods";

$result = Db_Query($db_con, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $name[] = pg_fetch_result($result,$i,0);
}

for($i = 0; $i < $num; $i++){
    if(mb_strlen($name[$i]) >= 20){
        print "Ê¸»ú¿ô".mb_strlen($name[$i]).":".$name[$i]."<br>";
    }
}

$a = mb_convert_encoding("ÀîùõÅ¹" ,"SJIS");
print mb_convert_encoding($a ,"EUC-JP", "SJIS");

?>
