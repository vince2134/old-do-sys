<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<title>����Υ�������</title>
</head>
<body>
<?php
$year = 2005;
$month = 11;

$wstr = array('��', '��', '��', '��', '��', '��', '��');
//ǯ�����
$now = mktime(0, 0, 0, $month, 1, $year);
//�������
$dnum = date("t", $now);
//�������ʬ
for ($i = 1; $i <= $dnum; $i++) {
	$x = $i -1;
    $t = mktime(0, 0, 0, $month, $i, $year);
    $w = date("w", $t);
    $day_count[$x] = $wstr[$w];
}
print "<pre>";
print_r ($day_count);
print "</pre>";

?>
</body>
</html>