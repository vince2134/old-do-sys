<?php

//DB�¹�
$connect = pg_connect("dbname=amenity user=postgres");
	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-01','00008051','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-01','00008051','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-01','00008051','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-08','00008052','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-08','00008052','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-08','00008052','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-15','00008053','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-15','00008053','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-03-15','00008053','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-01','00008054','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-01','00008054','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-01','00008054','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-08','00008055','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-08','00008055','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-08','00008055','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-15','00008056','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-15','00008056','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-04-15','00008056','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-01','00008057','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-01','00008057','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-01','00008057','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-08','00008058','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-08','00008058','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-08','00008058','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-15','00008059','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-15','00008059','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-05-15','00008059','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-01','00008060','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-01','00008060','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-01','00008060','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-08','00008061','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-08','00008061','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-08','00008061','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-15','00008062','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-15','00008062','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-06-15','00008062','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-01','00008063','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-01','00008063','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-01','00008063','32','��������','',0,0,0,3200);";
	$result = pg_query($connect,$sql);

	$money = 2000;
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-08','00008064','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-08','00008064','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-08','00008064','32','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//�ǡ�������SQL
		$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-15','00008065','61','����".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-15','00008065','','������','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('��������1','100000-0001','2005-07-15','00008065','31','��������','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	

?>
