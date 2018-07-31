<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);
//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ヘッダーのフォントサイズ
$font_size = 9;
//ページサイズ
$page_size = 1110;

//A3
$pdf=new MBFPDF('L','pt','A3');

//タイトル
$title = "滞留在庫一覧表";
$page_count = "1"; 

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("110","Ｍ区分","C");
$list[2] = array("300","商品名","C");
$list[3] = array("110","倉庫","C");
$list[4] = array("80","在庫数","C");
$list[5] = array("80","引当数","C");
$list[6] = array("80","在庫単価","C");
$list[7] = array("80","在庫金額","C");
$list[8] = array("80","引当金額","C");
$list[9] = array("80","在庫日数","C");
$list[10] = array("80","最終取扱日","C");

//Ｍ区分計・合計名
$list_sub[0] = array("110","Ｍ区分計","L");
$list_sub[1] = array("110","合計","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "L";
$data_align[4] = "R";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "C";

//データ取得SQL(Ｍ区分,商品名,倉庫,在庫数,引当数,在庫単価,在庫金額,引当金額,在庫日数,最終取扱日)
$sql = "select goods,goods_name,house,num1,num2,num3,num4,num5,day,date from t_long;";

//現在の日付取得SQL
$sql_stock = "SELECT DISTINCT stock_date FROM t_long;";

//ページ最大表示数
$page_max = 50;

//***********************************************

//DB接続
$db_con = Db_Connect("amenity_test");
//日付取得
$result = Db_Query($db_con,$sql_stock);
$time = pg_fetch_result($result,0,0);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//仮の時刻
$border_time = "基準日数：100日以上";

$date = date("印刷時刻　Y年m月d日　H：i");
//日付取得・形式変更
$year = substr($time,0,4);
$month = substr($time,5,2);
$day = substr($time,8,2);
$time = $year."年".$month."月".$day."日　現在";

//ヘッダー表示
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・小計・合計・比較値・消費税・税込金額、初期化
$count = 0;
$page_next = $page_max;
$data_sub = array();
$data_total = array();
$goods = "";

$result = Db_Query($db_con,$sql);

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************小計処理***********************************

	//値が変わった場合、小計表示
	if($goods != $data_list[0]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(213,213,213);
			//値の省略判定フラグ
			$space_flg = true;
			for($x=0;$x<10;$x++){
				//小計行番号
				if($x==0){
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
				//Ｍ区分計名
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//Ｍ区分計値
				}else{
					//数値判定
					if(is_numeric($data_sub[$x])){
						//小計値を合計値に足していく
						$data_total[$x] = $data_total[$x] + $data_sub[$x];
						$data_sub[$x] = number_format($data_sub[$x]);
					}
					$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
				}
			}
			//最終取扱日
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//小計、初期化
			$data_sub = array();
			$count++;
		}
		$goods = $data_list[0];
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//************************データ表示***************************
	//行番号
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<10;$x++){
		//表示値
		$contents = "";
		//表示line		
		$line = "";

		//一行目か小計の後の場合は、省略しない。
		if($x==1 && $count == 1 || $space_flg == true){
			//セル結合判定
			//ページの最大表示数か
			$contents = $data_list[$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LR';
			}
			//小計名を省略する
			$space_flg = false;
		//既に小計名を表示させたか
		}else if($x==1){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//在庫日数
		}else if($x==9){
			if(is_numeric($data_list[$x-1])){
				$data_list[$x-1] = number_format($data_list[$x-1]);
			}
			$contents = $data_list[$x-1]."日";
			$line = '1';
		//在庫・引当金額
		}else if($x==7 || $x==8){
			//値を小計に足していく
			$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
			$data_list[$x-1] = number_format($data_list[$x-1]);
			$contents = $data_list[$x-1];
			$line = '1';
		}else{
			if(is_numeric($data_list[$x-1])){
				$data_list[$x-1] = number_format($data_list[$x-1]);
			}
			$contents = $data_list[$x-1];
			$line = '1';
		}
		$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
	}
	//最終取扱日、形式変更
	$year = substr($data_list[$x-1],0,4);
	$month = substr($data_list[$x-1],5,2);
	$day = substr($data_list[$x-1],8,2);
	$data_list[$x-1] = $year."年".$month."月".$day."日";
	$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '2', $data_align[$x]);

	//件数を足す
	$row_count++;
}
//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(213,213,213);
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************最終小計処理***********************************
	
for($x=0;$x<10;$x++){
	//小計行番号
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//Ｍ区分計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//Ｍ区分計値
	}else{
		//数値判定
		if(is_numeric($data_sub[$x])){
			//小計値を合計値に足していく
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
//最終取扱日
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//小計、初期化
$data_sub = array();
//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//*******************改ページ処理*****************************

//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $count){
	$pdf->AddPage();
	$page_count++;

	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

	//次の最大表示数
	$page_next = $page_max * $page_count;
	$space_flg = true;
}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//*************************合計処理*******************************

for($x=0;$x<10;$x++){
	//合計行番号
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//総合計名
	}else if($x==1){
		$pdf->Cell($list_sub[1][0], 14, $list_sub[1][1], '1', '0',$list_sub[1][2],'1');
	//担当者計値
	}else{
		//総合計値
		//数値判定
		if(is_numeric($data_total[$x])){
			//形式変更
			$data_total[$x] = number_format($data_total[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');
//****************************************************************

$pdf->Output();

?>


?>
