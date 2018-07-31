<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");
//担当者１
for($x=1;$x<=30;$x++){

	if(1 <= $x && 9 >= $x){
		//データ挿入SQL
		$sql = "insert into t_person values(".$x.",'2005-11-0".$x."','担当者1','コース1','コメント1',10,1000,10,1000,0);";
	}

	if(10 <= $x && 30 >= $x){
		//データ挿入SQL
		$sql = "insert into t_person values(".$x.",'2005-11-".$x."','担当者1','コース1','コメント1',10,1000,10,1000,0);";
	}

	$result = pg_query($connect,$sql);
}

//担当者2
for($x=1;$x<=30;$x++){
	$y = $x + 30;
	if(1 <= $x && 9 >= $x){
		//データ挿入SQL
		$sql = "insert into t_person values(".$y.",'2005-11-0".$x."','担当者2','コース2','コメント2',10,1000,10,1000,0);";
	}

	if(10 <= $x && 30 >= $x){
		//データ挿入SQL
		$sql = "insert into t_person values(".$y.",'2005-11-".$x."','担当者2','コース2','コメント2',10,1000,10,1000,0);";
	}

	$result = pg_query($connect,$sql);
}

//担当者3
for($x=1;$x<=30;$x++){
	$y = $x + 60;
	if(1 <= $x && 9 >= $x){
		//データ挿入SQL
		$sql = "insert into t_person values(".$y.",'2005-11-0".$x."','担当者3','コース3','コメント3',10,1000,10,1000,0);";
	}

	if(10 <= $x && 30 >= $x){
		//データ挿入SQL
		$sql = "insert into t_person values(".$y.",'2005-11-".$x."','担当者3','コース3','コメント3',10,1000,10,1000,0);";
	}

	$result = pg_query($connect,$sql);
}

//担当者4
for($x=1;$x<=30;$x++){
	$y = $x + 90;
	if(1 <= $x && 9 >= $x){
		//データ挿入SQL
		$sql = "insert into t_person values(".$y.",'2005-11-0".$x."','担当者4','コース4','コメント4',10,1000,10,1000,0);";
	}

	if(10 <= $x && 30 >= $x){
		//データ挿入SQL
		$sql = "insert into t_person values(".$y.",'2005-11-".$x."','担当者4','コース4','コメント4',10,1000,10,1000,0);";
	}

	$result = pg_query($connect,$sql);
}

?>
