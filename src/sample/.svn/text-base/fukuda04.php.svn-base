<?php

// 環境設定ファイル指定
require_once("ENV_local.php");

// DB接続設定
//$db_con = Db_Connect("amenity_demo_new");
//$db_con = Db_Connect("amenity_morita");
$db_con = Db_Connect();

$permit_col = Permit_Col("head");
//print_array($permit_col);
foreach ($permit_col as $key_hf => $value_hf){
    foreach ($value_hf as $key_1 => $value_1){
        foreach ($value_1 as $key_2 => $value_2){
            foreach ($value_2 as $key_3 => $value_3){
                foreach ($value_3 as $key_4 => $value_4){
                    ($value_4 != null) ? $ary[] = $value_4 : null;
                }
            }
        }
    }
}

/*
print count($ary)."<br><br>";

foreach ($ary as $key => $value){
    print "$value<br>";

}
*/

print_array($permit_col);


$str = "\">";
print "<input type=\"text\" value=\"$str\">";

?>
