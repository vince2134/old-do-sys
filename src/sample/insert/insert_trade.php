<?php

$data[0] = array('11','�����','1');
$data[1] = array('12','�����(-)','1');
$data[2] = array('13','������','1');
$data[3] = array('14','���Ͱ�','1');
$data[4] = array('18','�¤��߽�','1');
$data[5] = array('19','�¤����','1');
$data[6] = array('61','�������','1');
$data[7] = array('62','�������(-)','1');
$data[8] = array('63','��������','1');
$data[9] = array('64','�����Ͱ�','1');

$data[10] = array('31','��������','2');
$data[11] = array('35','��������(-)','2');
$data[12] = array('32','��������','2');
$data[13] = array('33','�������','2');
$data[14] = array('34','�껦','2');
$data[15] = array('38','�����å��껦','2');
$data[16] = array('39','����Ĵ��','2');
$data[17] = array('37','����¾����','2');

$data[18] = array('21','�ݻ���','3');
$data[19] = array('22','�ݻ���(-)','3');
$data[20] = array('23','������','3');
$data[21] = array('24','���Ͱ�','3');
$data[22] = array('71','�������','3');
$data[23] = array('72','�������(-)','3');
$data[24] = array('73','��������','3');
$data[25] = array('74','�����Ͱ�','3');

$data[26] = array('41','�����ʧ','4');
$data[27] = array('42','�����ʧ(-)','4');
$data[28] = array('43','������ʧ','4');
$data[29] = array('44','�����ʧ','4');
$data[30] = array('45','�껦','4');
$data[31] = array('46','��ʧĴ��','4');
$data[32] = array('47','����¾��ʧ','4');

//DB��³
$connect = pg_connect("dbname=amenity user=postgres");
for($x=0;$x<count($data);$x++){
	$sql = "insert into t_trade values('".$data[$x][0]."','".$data[$x][1]."','".$data[$x][2]."');";
	$result = pg_query($connect,$sql);
}

?>
