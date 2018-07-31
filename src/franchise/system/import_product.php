<?php
/******************************/
// DB登録情報
/******************************/
// 環境設定ファイル
require_once("ENV_local.php");
function replaceText($str){
    $arr = array(
	"\x87\x40" => '(1)',
	"\x87\x41" => '(2)',
	"\x87\x42" => '(3)',
	"\x87\x43" => '(4)',
	"\x87\x44" => '(5)',
	"\x87\x45" => '(6)',
	"\x87\x46" => '(7)',
	"\x87\x47" => '(8)',
	"\x87\x48" => '(9)',
	"\x87\x49" => '(10)',
	"\x87\x4a" => '(11)',
	"\x87\x4b" => '(12)',
	"\x87\x4c" => '(13)',
	"\x87\x4d" => '(14)',
	"\x87\x4e" => '(15)',
	"\x87\x4f" => '(16)',
	"\x87\x50" => '(17)',
	"\x87\x51" => '(18)',
	"\x87\x52" => '(19)',
	"\x87\x53" => '(20)',
	"\x87\x54" => 'I',
	"\x87\x55" => 'II',
	"\x87\x56" => 'III',
	"\x87\x57" => 'IV',
	"\x87\x58" => 'V',
	"\x87\x59" => 'VI',
	"\x87\x5a" => 'VII',
	"\x87\x5b" => 'VIII',
	"\x87\x5c" => 'IX',
	"\x87\x5d" => 'X',
	"\x87\x5f" => 'ﾐﾘ',
	"\x87\x60" => 'ｷﾛ',
	"\x87\x61" => 'ｾﾝﾁ',
	"\x87\x62" => 'ﾒｰﾄﾙ',
	"\x87\x63" => 'ｸﾞﾗﾑ',
	"\x87\x64" => 'ﾄﾝ',
	"\x87\x65" => 'ｱｰﾙ',
	"\x87\x66" => 'ﾍｸﾀｰﾙ',
	"\x87\x67" => 'ﾘｯﾄﾙ',
	"\x87\x68" => 'ﾜｯﾄ',
	"\x87\x69" => 'ｶﾛﾘｰ',
	"\x87\x6a" => 'ﾄﾞﾙ',
	"\x87\x6b" => 'ｾﾝﾁ',
	"\x87\x6c" => 'ﾊﾟｰｾﾝﾄ',
	"\x87\x6d" => 'ﾐﾘﾊﾞｰﾙ',
	"\x87\x6e" => 'ﾍﾟｰｼﾞ',
	"\x87\x6f" => 'mm',
	"\x87\x70" => 'cm',
	"\x87\x71" => 'km',
	"\x87\x72" => 'mg',
	"\x87\x73" => 'kg',
	"\x87\x74" => 'cc',
	"\x87\x75" => 'm2',
	"\x87\x7e" => '平成',
	"\x87\x80" => '“',
	"\x87\x81" => '”',
	"\x87\x82" => 'No.',
	"\x87\x83" => 'K.K.',
	"\x87\x84" => 'TEL',
	"\x87\x85" => '（上）',
	"\x87\x86" => '（中）',
	"\x87\x87" => '（下）',
	"\x87\x88" => '（左）',
	"\x87\x89" => '（右）',
	"\x87\x8a" => '（株）',
	"\x87\x8b" => '（有）',
	"\x87\x8c" => '（代）',
	"\x87\x8d" => '明治',
	"\x87\x8e" => '大正',
	"\x87\x8f" => '昭和',
	"\x87\x90" => '≒',
	"\x87\x91" => '≡',
	"\x87\x92" => '∫',  
	"\x87\x93" => 'c∫',
	"\x87\x94" => 'Σ',
	"\x87\x95" => '√',
	"\x87\x96" => '⊥',
	"\x87\x97" => '∠',
	"\x87\x98" => '└',
	"\x87\x99" => 'Δ',
	"\x87\x9a" => '∵',
	"\x87\x9b" => '∩',
	"\x87\x9c" => '∪',
);
mb_convert_variables("Shift_Jis", "EUC-JP", $arr);
    return str_replace(array_keys($arr), array_values($arr), $str);
}

function removeSpace($str) {
	$arr = array(
		' ' => '',
		'　' => '');
	return str_replace(array_keys($arr), array_values($arr), $str);
}

// DB接続設定
$conn = Db_Connect();
$create_day = date("Y-m-d");
/******************************/
// 登録処理
/******************************/
$filepath =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/product.csv';
$logfile =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/product.log';
$errfile =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/product.log';
$buffer = file_get_contents($filepath);
$buffer = mb_convert_encoding(replaceText($buffer), "eucJP-win", "SJIS-win");
$fp = tmpfile();
fwrite($fp, $buffer);
rewind($fp);

$i=0;
while (($line = fgetcsv($fp)) !== FALSE) {
    if($i == 0){
        // タイトル行
        $header = $line;
        $i++;
        continue;
    }
    $records[] = $line;

    $i++;
}

fclose($fp);
$arr_attri_div = array('1' => '商品', '2' => '製品', '3' => 'レンタル', '4' => '道具・他');
$arr_mark_div = array('1' => '汎用', '2' => 'ＧＭ', '3' => 'ＥＣ', '4' => 'Ｇ適', '5' => '劇物');
$arr_manage = array('1' => '有', '2' => '無');
$arr_stock_only = array('1' => '○');
$arr_name_change = array('1' => '変更可', '2' => '変更不可');
$arr_tax_div = array('1' => '課税', '2' => '非課税');
$arr_product = array('90' => '防汚衛生', '91' => '室内管理', '93' => '害虫管理', '96' => 'ダスト管理', '99' => 'その他', '100' => '電池');
$shop_id = 173;         // FCID 光様client_id
$make_goods_flg = 0;                                    //製造品フラグ
$public_flg     = 0; 
$compose_flg    = 0;                                    //構成品フラグ
$head_fc_flg  = 0;                                    //本部識別フラグ
$record_count = 0;

for ($i=0; $i<count($records); $i++){
	//if (10 < $i) break;
	$d = $records[$i];	
	$state          = 1;                                             //状態
    $goods_cd       = 10000000 + $record_count + 1;                //商品CD
    $goods_name     = mb_substr(removeSpace($d[10]), 0, 30, "euc-jp");  //商品名
    $goods_cname    = $d[11];                                        //略称
    $attri_div      = intval(array_search($d[12], $arr_attri_div));  //属性区分
    $g_goods_cd     = sprintf('%04d', intval($d[4]));                //Ｍ区分ID
    $product_id     = intval(array_search($d[7], $arr_product));   //管理区分ID
	$g_product_cd   = sprintf('%04d', intval($d[8]));               //商品分類
    $unit           = $d[15];                                        //単位  
    $in_num         = $d[16];                                        //入数  
    $supplier_cd    = sprintf('%06d', intval($d[17]));              //仕入先コード
    $supplier_name  = $d[18];                                        //仕入先コード
    $sale_manage    = intval(array_search($d[19], $arr_manage));     //販売管理
    $stock_manage   = intval(array_search($d[20], $arr_manage));     //在庫管理
    $stock_only     = intval(array_search($d[21], $arr_stock_only)); //在庫限り品
    $order_point    = intval($d[22]);                                //発注点
    $order_unit     = intval($d[23]);                                //発注単位数
    $lead           = intval($d[24]);                                //リードタイム（日）
    $name_change    = intval(array_search($d[25], $arr_stock_only)); //品名変更
    $tax_div        = intval(array_search($d[26], $arr_tax_div));    //課税区分
    $note           = $d[27];                                        //備考  
    $url            = $d[13];                                        //URL
    $mark_div       = intval(array_search($d[14], $arr_mark_div));   //マーク
    
    $query  = " SELECT g_goods_id FROM t_g_goods WHERE g_goods_cd ='{$g_goods_cd}'";
    $result = Db_Query($conn, $query);
    if ($result) $g_goods_id = @pg_fetch_result($result, 0,0);
	$g_goods_id = intval($g_goods_id);
	
    $query  = " SELECT g_product_id FROM t_g_product WHERE g_product_cd ='{$g_product_cd}'";
    $result = Db_Query($conn, $query);
    if ($result) $g_product_id = @pg_fetch_result($result, 0,0);
	$g_product_id = intval($g_product_id);

	
	//新規登録
	//商品マスタ
	$goods_sql  = " INSERT INTO t_goods (";
	$goods_sql .= "	 goods_id,";
	$goods_sql .= "	 goods_cd,";
	$goods_sql .= "	 goods_name,";
	$goods_sql .= "	 goods_cname,";
	$goods_sql .= "	 attri_div,";
	$goods_sql .= "	 product_id,";
	$goods_sql .= "	 g_product_id,";
	$goods_sql .= "	 g_goods_id,";
	$goods_sql .= "	 unit,";
	$goods_sql .= "	 tax_div,";
	$goods_sql .= "	 name_change,";
	$goods_sql .= "	 sale_manage,";
	$goods_sql .= "	 stock_only,";
	$goods_sql .= "	 make_goods_flg,";
	$goods_sql .= "	 public_flg,";
	$goods_sql .= "	 shop_id,";
	$goods_sql .= "	 state,";
	$goods_sql .= "	 url,";
	$goods_sql .= "	 mark_div, ";
	$goods_sql .= "	 in_num,";
	$goods_sql .= "	 accept_flg";
	$goods_sql .= " )VALUES (";
	$goods_sql .= "	 (SELECT COALESCE(MAX(goods_id), 0)+1 FROM t_goods),";
	$goods_sql .= "	 '$goods_cd',";
	$goods_sql .= "	 '$goods_name',";
	$goods_sql .= "	 '$goods_cname',";
	$goods_sql .= "	 '$attri_div',";
	$goods_sql .= "	 $product_id,";
	$goods_sql .= "	 $g_product_id,";
	$goods_sql .= "	 $g_goods_id,";
	$goods_sql .= "	 '$unit',";
	$goods_sql .= "	 '$tax_div',";
	$goods_sql .= "	 '$name_change',";
	$goods_sql .= "	 '$sale_manage',";
	$goods_sql .= "	 '$stock_only',";
	$goods_sql .= "	 '$make_goods_flg',";
	$goods_sql .= "	 '$public_flg',";
	$goods_sql .= "	 $shop_id,";
	$goods_sql .= "	 '$state',";
	$goods_sql .= "	 '$url',";
	$goods_sql .= "	 '$mark_div', ";
	$goods_sql .= "	 '$in_num',";
	$goods_sql .= "	 '1'";
	$goods_sql .= ");";
	
	$result = Db_Query($conn, $goods_sql);
	
	//print $goods_sql . "<br>";
	if($result){
		//ショップ別商品情報テーブル
		$goods_sql  = " INSERT INTO t_goods_info (";
		$goods_sql .= "	 goods_id,";
		$goods_sql .= "	 order_point,";
		$goods_sql .= "	 order_unit,";
		$goods_sql .= "	 lead,";
		$goods_sql .= "	 note,";
		$goods_sql .= "	 stock_manage,";
		$goods_sql .= "	 supplier_id,";
		$goods_sql .= "	 compose_flg,";
		$goods_sql .= "	 shop_id,";
		$goods_sql .= "	 head_fc_flg";
		$goods_sql .= ") VALUES (";
		$goods_sql .= "	 (SELECT";
		$goods_sql .= "		 goods_id";
		$goods_sql .= "	 FROM";
		$goods_sql .= "		 t_goods";
		$goods_sql .= "	 WHERE";
		$goods_sql .= "		 goods_cd = '$goods_cd'";
		$goods_sql .= "		 AND";
		$goods_sql .= "		 shop_id = $shop_id";
		$goods_sql .= "	 ),";
		$goods_sql .= "	 $order_point,";
		$goods_sql .= "	 '$order_unit',";
		$goods_sql .= "	 '$lead',";
		$goods_sql .= "	 '$note',";
		$goods_sql .= "	 '$stock_manage',";
		
		//仕入先が指定されていた場合
		if($supplier_cd != null){
			$goods_sql .= "	 (";
			$goods_sql .= "	  SELECT";
			$goods_sql .= "		client_id";
			$goods_sql .= "	  FROM";
			$goods_sql .= "		t_client";
			$goods_sql .= "	  WHERE";
			$goods_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
			$goods_sql .= "		AND";
			$goods_sql .= "		client_cd1 = '$supplier_cd'";
			$goods_sql .= "		AND";
			$goods_sql .= "		client_div = '2'";
			$goods_sql .= "	),";
		}else{
			$goods_sql .= "null,";
		}
		$goods_sql .= "	'$compose_flg',";
		$goods_sql .= "	$shop_id,";
		$goods_sql .= "	'$head_fc_flg'";
		$goods_sql .= ");";
		
		$result = Db_Query($conn, $goods_sql);
			//print $goods_sql . "<br>";
	}

	if($result === false){
		$err = "$record_count $goods_name \n $goods_sql\n";
		file_put_contents($errfile, $err, FILE_APPEND | LOCK_EX);
	} 
	$record_count++;
	$msg = "$record_count $goods_name inserted OK.\n";
	file_put_contents($logfile, $msg, FILE_APPEND | LOCK_EX);
	print "$msg<br />";		

}
	print "$record_count records were inserted.<br />";
?>

