<?php

//DB�¹�
$connect = pg_connect("dbname=amenity user=postgres");

for($x=1;$x<=50;$x++){
	if($x<=9){
		//�ǡ�������SQL
		$sql = "insert into t_goods_group values(".$x.",'0000000".$x."','����".$x."');";
	}else{
		//�ǡ�������SQL
		$sql = "insert into t_goods_group values(".$x.",'000000".$x."','����".$x."');";
	}
	$result = pg_query($connect,$sql);
}

?>
