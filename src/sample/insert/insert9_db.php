<?php

//DB�¹�
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=300;$x++){
	if($x==1 || $x==30 || $x==60 || $x==90 || $x==120 || $x==150 || $x==180 || $x==210 || $x==240 || $x==270){
		$count = $x;
		//�ǡ�������SQL
		$sql = "insert into t_reser values(".$x.",'ô����".$x."','������','00010001','2005-04-11','����1','��ʬ1',10,1000,10000,'����1','��','��ͳ1');";
	}else{
		$sql = "insert into t_reser values(".$x.",'ô����".$count."','������','00010001','2005-04-11','����1','��ʬ1',10,1000,10000,'����1','��','��ͳ1');";
	}
	$result = pg_query($connect,$sql);
}

?>
