<?php
//DB��³
$connect = pg_connect("dbname=amenity user=postgres");
//��³���顼Ƚ��
if($connect == false)
{
	print "DB����³�Ǥ��ޤ���";
	exit;
}
?>
