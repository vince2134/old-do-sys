<?php
require "../../function/db_con.php";
$sql = "delete from t_post_no;";
$result = pg_query($connect,$sql);
if($result==false){
    print "SQLが実行できません";
    exit;
}else{
	print "　　　削除完了<br>";
	print "　　　<input type=\"submit\" value=\"閉じる\" onClick=\"javascript:window.close()\">";
}
?>