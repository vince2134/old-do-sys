<?php

//DB�¹�
$connect = pg_connect("dbname=amenity user=postgres");
//�Ҹˣ�
for($x=1;$x<=100;$x++){

	if(1 <= $x && 10 > $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$x.",'0000001','�Ҹ�1','2005-04-01','�Ͷ�ʬ1','���ʶ�ʬ1','0000000".$x."','����".$x."','20','20');";
	}

	if(10 <= $x && 30 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$x.",'0000001','�Ҹ�1','2005-04-01','�Ͷ�ʬ1','���ʶ�ʬ2','000000".$x."','����".$x."','20','20');";
	}

	if(31 <= $x && 50 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$x.",'0000001','�Ҹ�1','2005-04-01','�Ͷ�ʬ2','���ʶ�ʬ3','000000".$x."','����".$x."','20','20');";
	}

	if(51 <= $x && 70 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$x.",'0000001','�Ҹ�1','2005-04-01','�Ͷ�ʬ2','���ʶ�ʬ4','000000".$x."','����".$x."','20','20');";
	}

	if(71 <= $x && 90 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$x.",'0000001','�Ҹ�1','2005-04-01','�Ͷ�ʬ3','���ʶ�ʬ5','000000".$x."','����".$x."','20','20');";
	}

	if(91 <= $x && 100 > $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$x.",'0000001','�Ҹ�1','2005-04-01','�Ͷ�ʬ3','���ʶ�ʬ6','000000".$x."','����".$x."','20','20');";
	}

	if(100 == $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$x.",'0000001','�Ҹ�1','2005-04-01','�Ͷ�ʬ3','���ʶ�ʬ6','00000".$x."','����".$x."','20','20');";
	}

	$result = pg_query($connect,$sql);
}

//�Ҹˣ�
for($x=1;$x<=152;$x++){
	$y = $x + 100;
	if(1 <= $x && 10 > $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�2','2005-04-01','�Ͷ�ʬ1','���ʶ�ʬ1','0000000".$x."','����".$x."','20','20');";
	}

	if(10 <= $x && 30 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�2','2005-04-01','�Ͷ�ʬ1','���ʶ�ʬ2','000000".$x."','����".$x."','20','20');";
	}

	if(31 <= $x && 50 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�2','2005-04-01','�Ͷ�ʬ2','���ʶ�ʬ3','000000".$x."','����".$x."','20','20');";
	}

	if(51 <= $x && 70 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�2','2005-04-01','�Ͷ�ʬ2','���ʶ�ʬ4','000000".$x."','����".$x."','20','20');";
	}

	if(71 <= $x && 90 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�2','2005-04-01','�Ͷ�ʬ3','���ʶ�ʬ5','000000".$x."','����".$x."','20','20');";
	}

	if(91 <= $x && 100 > $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�2','2005-04-01','�Ͷ�ʬ3','���ʶ�ʬ6','000000".$x."','����".$x."','20','20');";
	}

	if(100 == $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�2','2005-04-01','�Ͷ�ʬ3','���ʶ�ʬ6','00000".$x."','����".$x."','20','20');";
	}

	if(101 <= $x && 152 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�2','2005-04-01','�Ͷ�ʬ4','���ʶ�ʬ7','00000".$x."','����".$x."','20','20');";
	}
	$result = pg_query($connect,$sql);
}

//�Ҹ�3
for($x=1;$x<=47;$x++){
	$y = $x + 252;
	if(1 <= $x && 10 > $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�3','2005-04-01','�Ͷ�ʬ1','���ʶ�ʬ1','0000000".$x."','����".$x."','20','20');";
	}

	if(10 <= $x && 30 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�3','2005-04-01','�Ͷ�ʬ1','���ʶ�ʬ2','000000".$x."','����".$x."','20','20');";
	}

	if(31 <= $x && 47 >= $x){
		//�ǡ�������SQL
		$sql = "insert into t_invent values(".$y.",'0000001','�Ҹ�3','2005-04-01','�Ͷ�ʬ2','���ʶ�ʬ3','000000".$x."','����".$x."','20','20');";
	}

	$result = pg_query($connect,$sql);
}

?>