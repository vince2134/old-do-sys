<?php

//DB�¹�
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=130;$x++){
	if($x<=30){
		//�ǡ�������SQL
		$sql = "insert into t_restock values(".$x.",'�Ҹ�1','2005-04-01','����".$x."',10,10000);";
	}else if($x<=60){
		//�ǡ�������SQL
		$sql = "insert into t_restock values(".$x.",'�Ҹ�1','2005-04-02','����".$x."',10,10000);";
	}else if($x<=90){
		//�ǡ�������SQL
		$sql = "insert into t_restock values(".$x.",'�Ҹ�2','2005-04-03','����".$x."',10,10000);";
	}else if($x<=130){
		$sql = "insert into t_restock values(".$x.",'�Ҹ�3','2005-04-04','����".$x."',10,10000);";
	}
	$result = pg_query($connect,$sql);
}

?>
