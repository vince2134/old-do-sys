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
$title = "配送コース順確認表";
$page_count = 1; 

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("120","コース名","C");
$list[2] = array("50","順路","C");
$list[3] = array("50","伝票番号","C");
$list[4] = array("165","得意先名","C");
$list[5] = array("115","取引区分","C");
$list[6] = array("130","商品名","C");
$list[7] = array("50","販売区分","C");
$list[8] = array("50","数量","C");
$list[9] = array("80","単価","C");
$list[10] = array("80","金額","C");
$list[11] = array("80","消費税","C");
$list[12] = array("110","備考","C");

//合計名
$list_sub[0] = array("50","伝票計","L");
$list_sub[1] = array("120","合計","L");
$list_sub[2] = array("115","消費税：","L");
$list_sub[3] = array("50","税込計：","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "L";
$data_align[4] = "L";
$data_align[5] = "C";
$data_align[6] = "L";
$data_align[7] = "C";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "R";
$data_align[11] = "R";
$data_align[12] = "L";

//担当者取得SQL
$sql_person = "SELECT DISTINCT client FROM t_deli;";

//ページ最大表示数
$page_max = 50;

//消費税
$tax = 0.05;

//***********************************************

//DB接続
$db_con = Db_Connect("amenity_test");

$result_person = Db_Query($db_con,$sql_person);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//担当者が存在する間出力
while($person_list = pg_fetch_array($result_person)){

	//データ取得SQL(コース名,順路,伝票番号,得意先,取引区分,商品名,販売区分,数量,単価,金額,消費税,備考)
	$sql = "SELECT course_name,course,sale_num,person,";
	$sql .= "business,goods,sale,num1,num2,num3,num4,note ";
	$sql .= "FROM t_deli ";
	$sql .= "WHERE client = '".$person_list[0]."';";

	//担当者取得
	$person ="担当者：".$person_list[0];

	//現在の日付取得SQL
	$sql_stock = "SELECT DISTINCT stock_date FROM t_deli;";

	//日付取得
	$result = Db_Query($db_con,$sql_stock);
	$time = pg_fetch_result($result,0,0);

	$pdf->SetFont(GOTHIC, '', 9);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//ＤＢの値を表示
	//行数・ページ数・次のページ表示数・小計・合計・消費税・税込金額・件数・比較値、初期化
	$count = 0;	
	$page_count = 1;
	$page_next = $page_max;
	$data_sub = array();
	$data_total = array();
	$money_tax = 0;
	$money = 0;
	$row_count = 0;
	$total_count = 0;
	//コース
	$cose = "";
	//順路
	$route = "";
	//伝票番号
	$number = "";

	$result = Db_Query($db_con,$sql);

	while($data_list = pg_fetch_array($result)){
		$count++;

		/**********************ヘッダー処理**************************/
		//一行目の場合、ヘッダ出力
		if($count == 1){
			$date = date("印刷時刻　Y年m月d日　H：i");
			//日付取得・形式変更
			$year = substr($time,0,4);
			$month = substr($time,5,2);
			$day = substr($time,8,2);
			$time = "配送日：".$year."年".$month."月".$day."日";

			//セル
			$pdf->SetXY($left_margin+830,$top_margin);
			$pdf->Cell(40,10,"確認欄",'LTR','2','C');
			$pdf->Cell(40,25,"",'LRB');
			$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);
		}

		//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $count){
			$pdf->AddPage();
			$page_count++;

			//セル
			$pdf->SetXY($left_margin+830,$top_margin);
			$pdf->Cell(40,10,"確認欄",'LTR','2','C');
			$pdf->Cell(40,25,"",'LRB');
			$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			//省略判定フラグ
			$space_flg = true;		//伝票
			$space_flg2 = true;		//順路
			$space_flg3 = true;		//コース
			$space_flg4 = true;		//得意先
			$space_flg5 = true;		//取引区分
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);

		//******************順路省略判定処理***********************************

		//値が変わった場合、順路表示
		if($route != $data_list[1]){
			//一行目は、値をセットするだけ
			if($count != 1){
				//値の省略判定フラグ
				$space_flg2 = true;
			}
			$route = $data_list[1];
		}

		//******************コース省略判定処理***********************************

		//値が変わった場合、コース表示
		if($cose != $data_list[0]){
			//一行目は、値をセットするだけ
			if($count != 1){
				//値の省略判定フラグ
				$space_flg3 = true;
			}
			$cose = $data_list[0];
		}

		//******************小計処理***********************************

		//値が変わった場合、小計表示
		if($number != $data_list[2]){
			//一行目は、値をセットするだけ
			if($count != 1){
				$pdf->SetFillColor(213,213,213);
				//値の省略判定フラグ
				$space_flg = true;
				$space_flg4 = true;
				$space_flg5 = true;

				for($x=0;$x<12;$x++){
					$pdf->SetFont(GOTHIC, 'B', 9);
					//小計行番号
					if($x==0){
						$pdf->SetFont(GOTHIC, '', 9);
						$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
					//伝票計の為、表示しない
					}else if($x==1 || $x==2){
						$pdf->Cell($list[$x][0], 14, "", 'LR', '0',$data_align[$x]);
					//伝票計名
					}else if($x==3){
						$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
					//伝票計値
					}else if($x==4){
						//伝票計値を合計値に足していく
						$data_total[4] = $data_total[4] + $data_sub[10];
						//消費税計算
						$money_tax = $data_sub[10] * $tax;
						//税込金額計算
						$money = $data_sub[10] * (1+$tax);
						//形式変更
						$money_tax = number_format($money_tax);
						$money = number_format($money);
						$data_sub[10] = number_format($data_sub[10]);
						
						$pdf->Cell($list[$x][0], 14, $data_sub[10], '1', '0','R','1');
					//消費税名
					}else if($x==5){
						$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
					//消費税値
					}else if($x==6){
						$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
					//税込計名
					}else if($x==7){
						$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
					//税込計値
					}else if($x==8){
						$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
					//販売区分件数
					}else if($x==10){
						//全件数計算
						$total_count = $total_count + $row_count;
						$pdf->Cell($list[$x][0], 14, $row_count."件", '1', '0','R','1');
					//得意先の小計表示
					}else if($x==11){
						$pdf->Cell($list[$x][0], 14, $data_sub[4], '1', '0','R','1');
					}else{
						$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
					}
				}
				$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
				//小計、初期化
				$data_sub = array();
				$money_tax = 0;
				$money = 0;
				$row_count = 0;
				$count++;
			}
			$number = $data_list[2];
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

			//セル
			$pdf->SetXY($left_margin+830,$top_margin);
			$pdf->Cell(40,10,"確認欄",'LTR','2','C');
			$pdf->Cell(40,25,"",'LRB');
			$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			//省略判定フラグ
			$space_flg = true;		//伝票
			$space_flg2 = true;		//順路
			$space_flg3 = true;		//コース
			$space_flg4 = true;		//得意先
			$space_flg5 = true;		//取引区分
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, '', 9);

		//************************データ表示***************************
		//行番号
		$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
		for($x=1;$x<12;$x++){
			//表示値
			$contents = "";
			//表示line		
			$line = "";

			//一行目か小計の後の場合は、コース名省略しない。
			if($x==1 && $count == 1 || $space_flg3 == true){
				//セル結合判定
				//ページの最大表示数か
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//小計名を省略する
				$space_flg3 = false;
			//既にコース名を表示させたか
			}else if($x==1){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//順路が変わったか
			}else if($x==2 && $count == 1 || $space_flg2 == true){
				//セル結合判定
				//ページの最大表示数か
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//順路を省略する
				$space_flg2 = false;
			//既に表示させたか
			}else if($x==2){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//伝票番号が変わったか
			}else if($x==3 && $count == 1 || $space_flg == true){
				//セル結合判定
				//ページの最大表示数か
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//伝票番号を省略する
				$space_flg = false;
			//既に表示させたか
			}else if($x==3){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//得意先が変わったか
			}else if($x==4 && $count == 1 || $space_flg4 == true){
				//セル結合判定
				//ページの最大表示数か
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//得意先を省略する
				$space_flg4 = false;
			//既に表示させたか
			}else if($x==4){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//取引区分が変わったか
			}else if($x==5 && $count == 1 || $space_flg5 == true){
				//セル結合判定
				//ページの最大表示数か
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//取引区分を省略する
				$space_flg5 = false;
			//既に表示させたか
			}else if($x==5){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//金額
			}else if($x==10){
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
		//備考
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

		//セル
		$pdf->SetXY($left_margin+830,$top_margin);
		$pdf->Cell(40,10,"確認欄",'LTR','2','C');
		$pdf->Cell(40,25,"",'LRB');
		$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		//省略判定フラグ
		$space_flg = true;		//伝票
		$space_flg2 = true;		//順路
		$space_flg3 = true;		//コース
		$space_flg4 = true;		//得意先
		$space_flg5 = true;		//取引区分
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************最終小計処理***********************************
		
	for($x=0;$x<12;$x++){
		$pdf->SetFont(GOTHIC, 'B', 9);
		//小計行番号
		if($x==0){
			$pdf->SetFont(GOTHIC, '', 9);
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
		//伝票計の為、表示しない
		}else if($x==1 || $x==2){
			$pdf->Cell($list[$x][0], 14, "", 'LR', '0',$data_align[$x]);
		//伝票計名
		}else if($x==3){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		//伝票計値
		}else if($x==4){
			//伝票計値を合計値に足していく
			$data_total[4] = $data_total[4] + $data_sub[10];
			//消費税計算
			$money_tax = $data_sub[10] * $tax;
			//税込金額計算
			$money = $data_sub[10] * (1+$tax);
			//形式変更
			$money_tax = number_format($money_tax);
			$money = number_format($money);
			$data_sub[10] = number_format($data_sub[10]);
			
			$pdf->Cell($list[$x][0], 14, $data_sub[10], '1', '0','R','1');
		//消費税名
		}else if($x==5){
			$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
		//消費税値
		}else if($x==6){
			$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
		//税込計名
		}else if($x==7){
			$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
		//税込計値
		}else if($x==8){
			$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
		//販売区分件数
		}else if($x==10){
			//全件数計算
			$total_count = $total_count + $row_count;
			$pdf->Cell($list[$x][0], 14, $row_count."件", '1', '0','R','1');
		//得意先の小計表示
		}else if($x==11){
			$pdf->Cell($list[$x][0], 14, $data_sub[4], '1', '0','R','1');
		}else{
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
	//小計、初期化
	$data_sub = array();
	$money_tax = 0;
	$money = 0;
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
		$page_count++;

		//セル
		$pdf->SetXY($left_margin+830,$top_margin);
		$pdf->Cell(40,10,"確認欄",'LTR','2','C');
		$pdf->Cell(40,25,"",'LRB');
		$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		//省略判定フラグ
		$space_flg = true;		//伝票
		$space_flg2 = true;		//順路
		$space_flg3 = true;		//コース
		$space_flg4 = true;		//得意先
		$space_flg5 = true;		//取引区分
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//*************************合計処理*******************************

	for($x=0;$x<12;$x++){
		$pdf->SetFont(GOTHIC, 'B', 9);
		//小計行番号
		if($x==0){
			$pdf->SetFont(GOTHIC, '', 9);
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
		//合計名
		}else if($x==1){
			$pdf->Cell($list_sub[1][0], 14, $list_sub[1][1], '1', '0',$list_sub[1][2],'1');
		//伝票計値
		}else if($x==4){
			//消費税計算
			$money_tax = $data_total[4] * $tax;
			//税込金額計算
			$money = $data_total[4] * (1+$tax);
			//形式変更
			$money_tax = number_format($money_tax);
			$money = number_format($money);
			$data_total[4] = number_format($data_total[4]);
			
			$pdf->Cell($list[$x][0], 14, $data_total[4], '1', '0','R','1');
		//消費税名
		}else if($x==5){
			$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
		//消費税値
		}else if($x==6){
			$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
		//税込計名
		}else if($x==7){
			$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
		//税込計値
		}else if($x==8){
			$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
		//販売区分件数
		}else if($x==10){
			//全件数
			$pdf->Cell($list[$x][0], 14, $total_count."件", '1', '0','R','1');
		//得意先の小計表示
		}else{
			$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');

	//****************************************************************
}

$pdf->Output();

?>

