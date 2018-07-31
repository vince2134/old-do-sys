<?php

$csv = "鈴木岳弘.csv";
$csv = mb_convert_encoding($csv, "SJIS", "EUC");

$data[0] = "す";
$data[1] = "ず";
$data[2] = "き";

$data[0] = mb_convert_encoding($data[0], "SJIS", "EUC");
$data[1] = mb_convert_encoding($data[1], "SJIS", "EUC");
$data[2] = mb_convert_encoding($data[2], "SJIS", "EUC");

$data = implode(",",$data);

Header("Content-disposition: attachment; filename=$csv");
Header("Content-type: application/octet-stream; name=$csv");

print $data;
exit;

?>