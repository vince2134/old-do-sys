<?
require_once("ENV_local.php");

$conn = Db_Connect();

//権限テーブルよりカラム名を取得
$column = shell_exec('/usr/local/pgsql/bin/psql -d amenity -c "\d t_permit" | awk -F " " \'{print $1}\' | grep -e h_ -e f_ | grep -v accept_flg | grep -v del_flg | grep -v staff_id');

$ary_column = explode("\n", $column);
array_pop($ary_column);

print_array($ary_column);


Db_Query($conn, "BEGIN;");

for($i = 0; $i < count($ary_column); $i++){
    $sql = "UPDATE t_permit SET ".$ary_column[$i]." = 'w';";
    $result = Db_Query($conn, $sql);

    if($result == false){
        $result = Db_Query($conn, "ROLLBACK;");
        exit;
    }
}

$sql = "UPDATE t_permit SET accept_flg = 't';";
$result = Db_Query($conn, $sql);
if($result == false){
    $result = Db_Query($conn, "ROLLBACK;");
    exit;
}

$sql = "UPDATE t_permit SET del_flg = 't';";
$result = Db_Query($conn, $sql);
if($result == false){
    $result = Db_Query($conn, "ROLLBACK;");
    exit;
}

Db_Query($conn, "COMMIT;");
print "完了";
?>
