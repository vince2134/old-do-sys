<?php
/******************************/
// DB��Ͽ����
/******************************/
// �Ķ�����ե�����
require_once("ENV_local.php");

// DB��³����
$conn = Db_Connect();
$create_day = date("Y-m-d");
/******************************/
// ��Ͽ����
/******************************/
$filepath =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/product.csv';
$logfile =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/price.log';
$errfile =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/price_err.log';
$buffer = file_get_contents($filepath);
$buffer = mb_convert_encoding($buffer, "eucJP-win", "SJIS-win");
$fp = tmpfile();
fwrite($fp, $buffer);
rewind($fp);

$i=0;
while (($line = fgetcsv($fp)) !== FALSE) {
    if($i == 0){
        // �����ȥ��
        $header = $line;
        $i++;
        continue;
    }
    $records[] = $line;

    $i++;
}

fclose($fp);
$shop_id = 173;         // FCID ����client_id

for ($i=0; $i<count($records); $i++){
	//if (10 < $i) break;
	$d = $records[$i];	
    $goods_cd   = 10000000 + $record_count + 1;                //����CD
    $price[0]   = intval($d[28]);                                //��������
    $price[1]   = intval($d[29]);                                //�߸˸�����
    $price[2]   = intval($d[30]);                                //�Ķȸ���
    $price[3]   = intval($d[31]);                                //ɸ�����
    
   for ($j=0; $j<4; $j++){
   	$rank_cd = $j + 1;
	$insert_sql  = " INSERT INTO t_price (
		price_id,
		goods_id,
		rank_cd,
		r_price,
		shop_id
		)VALUES(
		(SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),
		(SELECT COALESCE(MIN(goods_id), 0) FROM t_goods WHERE goods_cd={$goods_cd} AND shop_id={$shop_id}),
		{$rank_cd},
		{$price[$j]},
		{$shop_id}
		)";

    $result = Db_Query($conn, $insert_sql);
	if($result === false){
		$err = "$record_count $goods_name \n $goods_sql\n";
		file_put_contents($errfile, $err, FILE_APPEND | LOCK_EX);
	} 
   }



	$record_count++;
	$msg = "$record_count price inserted OK.\n";
	file_put_contents($logfile, $msg, FILE_APPEND | LOCK_EX);
	print "$msg<br />";		

}
	print "$record_count records were inserted.<br />";
?>
