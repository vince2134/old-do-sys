<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<title>今月のカレンダー</title>
</head>
<body>
<?php
$year = 2005;
$month = 11;

$wstr = array('日', '月', '火', '水', '木', '金', '土');
//年月指定
$now = mktime(0, 0, 0, $month, 1, $year);
//月の日数
$dnum = date("t", $now);
//月の日数分
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