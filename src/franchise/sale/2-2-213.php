<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);
//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ヘッダーのフォントサイズ
$font_size = 9;
//ページサイズ
$page_size = 515;

//A4
$pdf=new MBFPDF('P','pt','A4');

//タイトル
$title = "商品預け数一覧表";
$page_count = "1";

//項目名・幅・align
$list[0] = array("30","No","C");
$list[1] = array("60","商品コード","C");
$list[2] = array("243","商品名","C");
$list[3] = array("122","得意先名","C");
$list[4] = array("60","預け数","C");

//商品計・合計名
$list_sub[0] = array("60","商品計","L");
$list_sub[1] = array("60","合計","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "L";
$data_align[4] = "R";

$time1 = "20050401";
$time2 = "20050431";

//データ取得SQL
$sql = "select goods_cd,goods_name,customer,dep_num from t_deposit;";

//ページ最大表示数
$page_max = 50;

//***********************************************

//DB接続
$db_con = Db_Connect("amenity_test");

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

$date = date("印刷時刻　Y年m月d日　H：i");
//日付取得・形式変更
$year1 = substr($time1,0,4);
$month1 = substr($time1,4,2);
$day1 = substr($time1,6,2);
$year2 = substr($time2,0,4);
$month2 = substr($time2,4,2);
$day2 = substr($time2,6,2);
$time = "契約期間：".$year1."年".$month1."月".$day1."日〜".$year2."年".$month2."月".$day2."日";

//ヘッダー表示
Header_disp($pdf,$left_margin,$top_margin,$title,$time,$date,"","",$page_count,$list,$font_size,$page_size);

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・小計・合計・比較値、初期化
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
		Header_disp($pdf,$left_margin,$top_margin,$title,$time,$date,"","",$page_count,$list,$font_size,$page_size);

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
			for($x=0;$x<4;$x++){
				//小計行番号
				if($x==0){
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
				//商品計名
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//商品計値
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
			//引当金額
			if(is_numeric($data_sub[$x])){
				//小計値を合計値に足していく
				$data_total[$x] = $data_total[$x] + $data_sub[$x];
				$data_sub[$x] = number_format($data_sub[$x]);
			}
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
		Header_disp($pdf,$left_margin,$top_margin,$title,$time,$date,"","",$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

//************************データ表示***************************
	//行番号
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<4;$x++){
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
		//在庫・
		}else if($x==4){
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
	//引当金額
	$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
	$data_list[$x-1] = number_format($data_list[$x-1]);
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
		Header_disp($pdf,$left_margin,$top_margin,$title,$time,$date,"","",$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************最終小計処理***********************************
	
for($x=0;$x<4;$x++){
	//小計行番号
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//商品計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//商品計値
	}else{
		//小計値
		//数値判定
		if(is_numeric($data_sub[$x])){
			//小計値を合計値に足していく
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
//小計値を合計値に足していく
$data_total[$x] = $data_total[$x] + $data_sub[$x];
$data_sub[$x] = number_format($data_sub[$x]);

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
		Header_disp($pdf,$left_margin,$top_margin,$title,$time,$date,"","",$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//*************************合計処理*******************************

for($x=0;$x<4;$x++){
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
//形式変更
$data_total[$x] = number_format($data_total[$x]);

$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');
//****************************************************************

$pdf->Output();

?>
