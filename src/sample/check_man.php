<?php

$man = shell_exec("tail -20 ./check.txt");
$man = str_replace("\n","<br>",$man);
print "■過去１０回のチェック実施結果<br><br>";
print $man;

print "<br><a href=./check.php>戻る</a>";

?>
