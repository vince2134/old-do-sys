<?php

//DB�¹�
$connect = pg_connect("dbname=amenity_test user=postgres");
	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-03-01','00008051','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-03-01','00008051','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-03-01','00008051','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-03-08','00008052','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-03-08','00008052','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-03-08','00008052','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-03-15','00008053','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-03-15','00008053','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-03-15','00008053','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-04-01','00008054','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-04-01','00008054','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-04-01','00008054','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-04-08','00008055','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-04-08','00008055','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-04-08','00008055','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-04-15','00008056','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-04-15','00008056','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-04-15','00008056','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-05-01','00008057','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-05-01','00008057','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-05-01','00008057','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-05-08','00008058','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-05-08','00008058','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-05-08','00008058','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-05-15','00008059','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-05-15','00008059','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-05-15','00008059','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-06-01','00008060','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-06-01','00008060','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-06-01','00008060','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-06-08','00008061','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
	}
	$sql = "insert into t_client values('�����1','100000','2005-06-08','00008061','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-06-08','00008061','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-06-15','00008062','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-06-15','00008062','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-06-15','00008062','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-07-01','00008063','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-07-01','00008063','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-07-01','00008063','42','������ʧ',0,0,0,3200);";
	$result = pg_query($connect,$sql);

	$money = 2000;
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-07-08','00008064','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-07-08','00008064','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-07-08','00008064','42','������ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_client values('�����1','100000','2005-07-15','00008065','21','����".$x."',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_client values('�����1','100000','2005-07-15','00008065','','������',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_client values('�����1','100000','2005-07-15','00008065','41','�����ʧ',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	

?>
