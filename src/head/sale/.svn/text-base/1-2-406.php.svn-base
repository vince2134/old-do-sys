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
$page_size = 1110;

//A3
$pdf=new MBFPDF('L','pt','A3');

//タイトル
$title = "入金一覧表";
$page_count = 1; 

//仮の時刻
$time = "集計期間：2005年04月01日〜2005年04月11日";

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("120","取引区分","C");
$list[2] = array("120","銀行","C");
$list[3] = array("80","入金番号","C");
$list[4] = array("170","得意先","C");
$list[5] = array("80","入金日","C");
$list[6] = array("80","入金額","C");
$list[7] = array("80","手数料","C");
$list[8] = array("80","手形期日","C");
$list[9] = array("60","券面番号","C");
$list[10] = array("210","備考","C");

//小計・合計名
$list_sub[0] = array("120","取引区分計","L");
$list_sub[1] = array("120","総合計","L");
$list_sub[2] = array("120","入金総合計","L");
$list_sub[3] = array("170","入金計","L");
$list_sub[4] = array("80","手数料","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "L";
$data_align[4] = "L";
$data_align[5] = "C";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "C";
$data_align[9] = "L";
$data_align[10] = "L";

//データ取得SQL
$sql = "select trade,bank,pay_no,shop_name,pay_date,pay_money,pay_money2,pay_date2,payable,note from t_payin;";

//ページ最大表示数
$page_max = 50;

//***********************************************

//DB接続
$db_con = Db_Connect("amenity_test");
$result = Db_Query($db_con,$sql);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("印刷時刻　Y年m月d日　H:i");

//ヘッダー表示
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・小計・合計・比較値・件数・全件数、初期化
$count = 0;
$page_count++;
$page_next = $page_max;
$data_sub = array();
$data_total = array();
$goods = "";
$row_count = 0;
$total_count = 0;

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$page_count++;
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
				//取引区分計名
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//入金総合計名
				}else if($x==2){
					$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
				//入金総合計値
				}else if($x==3){
					//入金計＋手数料
					$data_sub[$x] = $data_sub[6] + $data_sub[7];
					//小計値を合計値に足していく
					$data_total[$x] = $data_total[$x] + $data_sub[$x];
					//形式変更
					$data_sub[$x] = number_format($data_sub[$x]);
					
					$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
				//入金計名
				}else if($x==4){
					$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
				//入金計値を表示
				}else if($x==5){
					//小計値を合計値に足していく
					$data_total[6] = $data_total[6] + $data_sub[6];
					$data_sub[6] = number_format($data_sub[6]);
					$pdf->Cell($list[5][0], 14, $data_sub[6], '1', '0','R','1');
				//手数料名
				}else if($x==6){
					$pdf->Cell($list_sub[4][0], 14, $list_sub[4][1], '1', '0',$list_sub[4][2],'1');
				//件数表示
				}else if($x==9){
					$pdf->Cell($list[$x][0], 14, "$row_count"."件", '1', '0','R','1');
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
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//小計初期化
			$data_sub = array();
			$count++;
			//合計件数
			$total_count = $total_count + $row_count;
			$row_count = 0;
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

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$page_count++;
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
		if($x==1 && ($count == 1 || $space_flg == true)){
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
		//券面番号・入金番号
		}else if($x==9 || $x==3){
			$contents = $data_list[$x-1];
			$line = '1';
		}else{
			if(is_numeric($data_list[$x-1])){
				//値を小計に足していく
				$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
				$data_list[$x-1] = number_format($data_list[$x-1]);
			}
			$contents = $data_list[$x-1];
			$line = '1';
		}
		$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
	}
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

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$page_count++;
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
	//取引区分計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//入金総合計名
	}else if($x==2){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	//入金総合計値
	}else if($x==3){
		//入金計＋手数料
		$data_sub[$x] = $data_sub[6] + $data_sub[7];
		//小計値を合計値に足していく
		$data_total[$x] = $data_total[$x] + $data_sub[$x];
		//形式変更
		$data_sub[$x] = number_format($data_sub[$x]);
		
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	//入金計名
	}else if($x==4){
		$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
	//入金計値を表示
	}else if($x==5){
		//小計値を合計値に足していく
		$data_total[6] = $data_total[6] + $data_sub[6];
		$data_sub[6] = number_format($data_sub[6]);
		$pdf->Cell($list[5][0], 14, $data_sub[6], '1', '0','R','1');
	//手数料名
	}else if($x==6){
		$pdf->Cell($list_sub[4][0], 14, $list_sub[4][1], '1', '0',$list_sub[4][2],'1');
	//件数表示
	}else if($x==9){
		$pdf->Cell($list[$x][0], 14, "$row_count"."件", '1', '0','R','1');
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
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//小計初期化
$data_sub = array();
$count++;
//合計件数
$total_count = $total_count + $row_count;
$row_count = 0;

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$page_count++;
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
	//入金総合計名
	}else if($x==2){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	//入金計名
	}else if($x==4){
		$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
	//入金計値を表示
	}else if($x==5){
		$data_total[6] = number_format($data_total[6]);
		$pdf->Cell($list[5][0], 14, $data_total[6], '1', '0','R','1');
	//手数料名を表示
	}else if($x==6){
		$pdf->Cell($list_sub[4][0], 14, $list_sub[4][1], '1', '0',$list_sub[4][2],'1');
	//件数表示
	}else if($x==9){
		$pdf->Cell($list[$x][0], 14, "$total_count"."件", '1', '0','R','1');
	//取引区分計名
	}else{
	//合計値
		if(is_numeric($data_total[$x])){
			$data_total[$x] = number_format($data_total[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');

//****************************************************************

$pdf->Output();

?>
