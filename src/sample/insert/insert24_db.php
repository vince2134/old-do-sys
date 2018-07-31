<?php

//DB実行
$connect = pg_connect("dbname=amenity user=postgres");
	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-01','00008051','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-01','00008051','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-01','00008051','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-08','00008052','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-08','00008052','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-08','00008052','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-15','00008053','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-15','00008053','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-03-15','00008053','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-01','00008054','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-01','00008054','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-01','00008054','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-08','00008055','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-08','00008055','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-08','00008055','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-15','00008056','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-15','00008056','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-04-15','00008056','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-01','00008057','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-01','00008057','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-01','00008057','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-08','00008058','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-08','00008058','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-08','00008058','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-15','00008059','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-15','00008059','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-05-15','00008059','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-01','00008060','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-01','00008060','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-01','00008060','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-08','00008061','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-08','00008061','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-08','00008061','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-15','00008062','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-15','00008062','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-06-15','00008062','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-01','00008063','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-01','00008063','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-01','00008063','32','振込入金','',0,0,0,3200);";
	$result = pg_query($connect,$sql);

	$money = 2000;
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-08','00008064','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-08','00008064','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-08','00008064','32','振込入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	
	for($x=1;$x<5;$x++){
		//データ挿入SQL
		$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-15','00008065','61','商品".$x."','0001',1,1000,1000,0);";
		$result = pg_query($connect,$sql);
		$money = $money + 1000;
	}
	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-15','00008065','','消費税','',0,0,200,0);";
	$result = pg_query($connect,$sql);

	$sql = "insert into t_ledger values('御得意先1','100000-0001','2005-07-15','00008065','31','現金入金','',0,0,0,4200);";
	$result = pg_query($connect,$sql);

	

?>
