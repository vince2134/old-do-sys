<?php

//DB�¹�
$connect = pg_connect("dbname=amenity user=postgres");
//ô���ԣ�
for($x=1;$x<=30;$x++){

	if(1 <= $x && 9 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_person values(".$x.",'2005-11-0".$x."','ô����1','������1','������1',10,1000,10,1000,0);";
	}

	if(10 <= $x && 30 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_person values(".$x.",'2005-11-".$x."','ô����1','������1','������1',10,1000,10,1000,0);";
	}

	$result = pg_query($connect,$sql);
}

//ô����2
for($x=1;$x<=30;$x++){
	$y = $x + 30;
	if(1 <= $x && 9 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_person values(".$y.",'2005-11-0".$x."','ô����2','������2','������2',10,1000,10,1000,0);";
	}

	if(10 <= $x && 30 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_person values(".$y.",'2005-11-".$x."','ô����2','������2','������2',10,1000,10,1000,0);";
	}

	$result = pg_query($connect,$sql);
}

//ô����3
for($x=1;$x<=30;$x++){
	$y = $x + 60;
	if(1 <= $x && 9 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_person values(".$y.",'2005-11-0".$x."','ô����3','������3','������3',10,1000,10,1000,0);";
	}

	if(10 <= $x && 30 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_person values(".$y.",'2005-11-".$x."','ô����3','������3','������3',10,1000,10,1000,0);";
	}

	$result = pg_query($connect,$sql);
}

//ô����4
for($x=1;$x<=30;$x++){
	$y = $x + 90;
	if(1 <= $x && 9 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_person values(".$y.",'2005-11-0".$x."','ô����4','������4','������4',10,1000,10,1000,0);";
	}

	if(10 <= $x && 30 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_person values(".$y.",'2005-11-".$x."','ô����4','������4','������4',10,1000,10,1000,0);";
	}

	$result = pg_query($connect,$sql);
}

?>
