<?php

//DB�¹�
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=150;$x++){
	if($x<=9){
		//�ǡ�������SQL
		$sql = "insert into t_request values(".$x.",'0001000".$x."','2005-04-01','������".$x."','2005-04-02','ô����".$x."',2000,1000,0,1000,0,0,0,1000);";
	}else if($x<=99){
		$sql = "insert into t_request values(".$x.",'000100".$x."','2005-04-01','������".$x."','2005-04-02','ô����".$x."',2000,1000,0,1000,0,0,0,1000);";
	}else if($x<=150){
		$sql = "insert into t_request values(".$x.",'00010".$x."','2005-04-01','������".$x."','2005-04-02','ô����".$x."',2000,1000,0,1000,0,0,0,1000);";
	}
	$result = pg_query($connect,$sql);
}

?>
