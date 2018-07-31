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
$title = "確定済売上伝票一覧";
$page_count = 1; 

//仮の時刻
$time = "売上日：2005年04月01日〜2005年04月11日";

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("140","得意先名","C");
$list[2] = array("50","伝票番号","C");
$list[3] = array("60","売上日","C");
$list[4] = array("100","巡回担当","C");
$list[5] = array("280","商品名","C");
$list[6] = array("50","販売区分","C");
$list[7] = array("70","売上数","C");
$list[8] = array("70","売上単価","C");
$list[9] = array("70","売上金額","C");
$list[10] = array("190","備考","C");

//得意先計・総合計（消費税/税込計）
$list_sub[0] = array("140","得意先計","L");
$list_sub[1] = array("140","総合計","L");
$list_sub[2] = array("60","消費税：","L");
$list_sub[3] = array("280","税込計：","L");
//伝票計（消費税/税込計）
$list_sub[4] = array("50","伝票計","L");
$list_sub[5] = array("100","消費税：","L");
$list_sub[6] = array("50","税込計：","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "C";
$data_align[4] = "L";
$data_align[5] = "L";
$data_align[6] = "C";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "L";
$data_align[11] = "C";
$data_align[12] = "L";

//データ取得SQL
$sql = "select person1,sale_num,sale_date,person2,goods,division,num1,num2,num3,note from t_decision;";

//ページ最大表示数
$page_max = 50;

//消費税
$tax = 0.05;

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
//行数・次のページ表示数・前のページ表示数・伝票計・得意先計・合計・比較値・消費税・税込金額、初期化
$count = 0;
$page_next = $page_max;
$page_back = 0;
$data_sub = array();
$data_sub2 = array();
$data_total = array();
$person = "";
$slip = "";
$money_tax = 0;
$money = 0;
$money_tax2 = 0;
$money2 = 0;

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、得意先名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************伝票計処理***********************************

	//値が変わった場合、伝票計表示
	if($slip != $data_list[1]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//値の省略判定フラグ
			$space_flg2 = true;
			for($x=0;$x<10;$x++){
				//伝票計行番号
				if($x==0){
					$pdf->SetFont(GOTHIC, '', 9);
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
					$pdf->SetFont(GOTHIC, 'B', 9);
				//得意先名
				}else if($x==1){
					//改ページした後の一行目が、伝票計の場合、得意先名表示
					if($page_back == $count){
						$pdf->SetFont(GOTHIC, '', 9);
						$pdf->Cell($list[$x][0], 14, $customer, 'LR', '0','L','');
						$pdf->SetFont(GOTHIC, 'B', 9);
						//得意先を表示させた場合は、データの得意先を省略
						$slip_flg = true;
					}else{
						$pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
						$slip_flg = false;
					}
				//伝票計名
				}else if($x==2){
					$pdf->Cell($list_sub[4][0], 14, $list_sub[4][1], '1', '0',$list_sub[0][2],'1');
				//伝票計値
				}else if($x==3){
					//伝票計値を合計値に足していく
					$data_total[2] = $data_total[2] + $data_sub2[9];
					//消費税計算
					$money_tax2 = $data_sub2[9] * $tax;
					//税込金額計算
					$money2 = $data_sub2[9] * (1+$tax);
					//形式変更
					$money_tax2 = number_format($money_tax2);
					$money2 = number_format($money2);
					$data_sub2[9] = number_format($data_sub2[9]);
					
					$pdf->Cell($list[$x][0], 14, $data_sub2[9], '1', '0','R','1');
				//消費税名
				}else if($x==4){
					$pdf->Cell($list_sub[5][0], 14, $list_sub[5][1], '1', '0',$list_sub[5][2],'1');
				//消費税値
				}else if($x==5){
					$pdf->Cell($list[$x][0], 14, $money_tax2, '1', '0','R','1');
				//税込計名
				}else if($x==6){
					$pdf->Cell($list_sub[6][0], 14, $list_sub[6][1], '1', '0',$list_sub[6][2],'1');
				//税込計値
				}else if($x==7){
					$pdf->Cell($list[$x][0], 14, $money2, '1', '0','R','1');
				//２列の値を表示
				}else if($x==9){
					$pdf->Cell($list[$x][0], 14, $data_sub2[2], '1', '0','R','1');
				}else{
					$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
				}
			}
			$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
			//伝票計・消費税・税込計、初期化
			$data_sub2 = array();
			$money_tax2 = 0;
			$money2 = 0;
			$count++;
		}
		$slip = $data_list[1];
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、得意先名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************得意先計処理***********************************

	//値が変わった場合、得意先計表示
	if($person != $data_list[0]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(180,180,180);
			//値の省略判定フラグ
			$space_flg = true;
			for($x=0;$x<10;$x++){
				//小計行番号
				if($x==0){
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
				//担当者計名
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//担当者計値
				}else if($x==2){
					//小計値を合計値に足していく
					$data_total[2] = $data_total[2] + $data_sub[9];
					//消費税計算
					$money_tax = $data_sub[9] * $tax;
					//税込金額計算
					$money = $data_sub[9] * (1+$tax);
					//形式変更
					$money_tax = number_format($money_tax);
					$money = number_format($money);
					$data_sub[9] = number_format($data_sub[9]);
					
					$pdf->Cell($list[$x][0], 14, $data_sub[9], '1', '0','R','1');
				//消費税名
				}else if($x==3){
					$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
				//消費税値
				}else if($x==4){
					$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
				//税込計名
				}else if($x==5){
					$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
				//税込計値
				}else if($x==6){
					$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
				//２列の値を表示
				}else if($x==9){
					$pdf->Cell($list[$x][0], 14, $data_sub[2], '1', '0','R','1');
				}else{
					$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
				}
			}
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//得意先計・消費税・税込計、初期化
			$data_sub = array();
			$money_tax = 0;
			$money = 0;
			$count++;
		}
		$person = $data_list[0];
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
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、得意先名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

//************************データ表示***************************
	//行番号
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<10;$x++){
		//表示値
		$contents = "";
		//表示line
		$line = "";

		//得意先名の省略判定
		//伝票計に得意先を表示させていない。かつ、一行目か小計の後の場合は、省略しない。
		if($x==1 && $slip_flg == false && ($count == 1 || $space_flg == true)){
			//セル結合判定
			//ページの最大表示数か
			$contents = $data_list[$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LR';
			}
			//伝票計に表示させる得意先名を代入
			$customer = $data_list[$x-1];
			//得意先名を省略する
			$space_flg = false;
		//伝票計に得意先を表示、または、既に得意先を表示させたか
		}else if($x==1){
			//ページの最大表示数か
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
			$customer = $data_list[$x-1];
		//一行目か伝票計の後以外は値の省略
		}else if($x==2 && ($count == 1 || $space_flg2 == true)){
			//セル結合判定
			//ページの最大表示数か
			$contents = $data_list[$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//省略する
			$space_flg2 = false;
		//既に伝票番号を表示している。
		}else if($x==2){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//売上金額計算
		}else if($x==9){
			//値を伝票計に足していく
			$data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
			//値を得意先計に足していく
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
	$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '2', $data_align[$x]);

}
//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(220,220,220);
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、得意先名表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************最終伝票計処理***********************************
	
for($x=0;$x<10;$x++){
	//伝票計行番号
	if($x==0){
		$pdf->SetFont(GOTHIC, '', 9);
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
		$pdf->SetFont(GOTHIC, 'B', 9);
	//得意先名
	}else if($x==1){
		//改ページした後の一行目が、伝票計の場合、得意先名表示
		if($page_back == $count){
			$pdf->SetFont(GOTHIC, '', 9);
			$pdf->Cell($list[$x][0], 14, $customer, 'LR', '0','L','');
			$pdf->SetFont(GOTHIC, 'B', 9);
			//得意先を表示させた場合は、データの得意先を省略
			$slip_flg = true;
		}else{
			$pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
			$slip_flg = false;
		}
	//伝票計名
	}else if($x==2){
		$pdf->Cell($list_sub[4][0], 14, $list_sub[4][1], '1', '0',$list_sub[0][2],'1');
	//伝票計値
	}else if($x==3){
		//伝票計値を合計値に足していく
		$data_total[2] = $data_total[2] + $data_sub2[9];
		//消費税計算
		$money_tax2 = $data_sub2[9] * $tax;
		//税込金額計算
		$money2 = $data_sub2[9] * (1+$tax);
		//形式変更
		$money_tax2 = number_format($money_tax2);
		$money2 = number_format($money2);
		$data_sub2[9] = number_format($data_sub2[9]);
		
		$pdf->Cell($list[$x][0], 14, $data_sub2[9], '1', '0','R','1');
	//消費税名
	}else if($x==4){
		$pdf->Cell($list_sub[5][0], 14, $list_sub[5][1], '1', '0',$list_sub[5][2],'1');
	//消費税値
	}else if($x==5){
		$pdf->Cell($list[$x][0], 14, $money_tax2, '1', '0','R','1');
	//税込計名
	}else if($x==6){
		$pdf->Cell($list_sub[6][0], 14, $list_sub[6][1], '1', '0',$list_sub[6][2],'1');
	//税込計値
	}else if($x==7){
		$pdf->Cell($list[$x][0], 14, $money2, '1', '0','R','1');
	//２列の値を表示
	}else if($x==9){
		$pdf->Cell($list[$x][0], 14, $data_sub2[2], '1', '0','R','1');
	}else{
		$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
//伝票計・消費税・税込計、初期化
$data_sub2 = array();
$money_tax2 = 0;
$money2 = 0;

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、得意先名表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//****************最終得意先計処理*******************************

for($x=0;$x<10;$x++){
	//小計行番号
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//担当者計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//担当者計値
	}else if($x==2){
		//小計値を合計値に足していく
		$data_total[2] = $data_total[2] + $data_sub[9];
		//消費税計算
		$money_tax = $data_sub[9] * $tax;
		//税込金額計算
		$money = $data_sub[9] * (1+$tax);
		//形式変更
		$money_tax = number_format($money_tax);
		$money = number_format($money);
		$data_sub[9] = number_format($data_sub[9]);
		
		$pdf->Cell($list[$x][0], 14, $data_sub[9], '1', '0','R','1');
	//消費税名
	}else if($x==3){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	//消費税値
	}else if($x==4){
		$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
	//税込計名
	}else if($x==5){
		$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
	//税込計値
	}else if($x==6){
		$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
	//２列の値を表示
	}else if($x==9){
		$pdf->Cell($list[$x][0], 14, $data_sub[2], '1', '0','R','1');
	}else{
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//得意先計・消費税・税込計、初期化
$data_sub = array();
$money_tax = 0;
$money = 0;

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
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、得意先名表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
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
	}else if($x==2){
		//消費税計算
		$money_tax = $data_total[2] * $tax;
		//税込金額計算
		$money = $data_total[2] * (1+$tax);
		//形式変更
		$money_tax = number_format($money_tax);
		$money = number_format($money);
		$data_total[2] = number_format($data_total[2]);

		$pdf->Cell($list[$x][0], 14, $data_total[2], '1', '0','R','1');
	//消費税名
	}else if($x==3){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	//消費税値
	}else if($x==4){
		$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
	//税込計名
	}else if($x==5){
		$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
	//税込計値
	}else if($x==6){
		$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
	}else{
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');
//****************************************************************

$pdf->Output();

?>
