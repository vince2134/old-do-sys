<?php

//DB�¹�
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=210;$x++){
	if($x==1 || $x==30 || $x==60 || $x==90 || $x==120 || $x==150 || $x==180){
		$count = $x;
		//�ǡ�������SQL
		$sql = "insert into t_long values(".$x.",'2005-04-01','�Ͷ�ʬ".$x."','����".$x."','�Ҹ�1',10,5,1000,10000,5000,152,'2005-03-20');";
	}else{
		$sql = "insert into t_long values(".$x.",'2005-04-01','�Ͷ�ʬ".$count."','����".$x."','�Ҹ�1',10,5,1000,10000,5000,152,'2005-03-20');";
	}
	$result = pg_query($connect,$sql);
}

?>
