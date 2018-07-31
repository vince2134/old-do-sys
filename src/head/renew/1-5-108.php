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
$title = "オペレータ入力情報";
$page_count = "1"; 

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("180","担当者名","C");
$list[2] = array("180","売上計上日","C");
$list[3] = array("80","現金売上","C");
$list[4] = array("80","掛売上","C");
$list[5] = array("80","売上合計","C");
$list[6] = array("80","現金消費税","C");
$list[7] = array("80","掛消費税","C");
$list[8] = array("80","現金税込計","C");
$list[9] = array("80","掛税込計","C");
$list[10] = array("80","税込総合計","C");
$list[11] = array("80","粗利金額","C");

//Ｍ区分計・合計名
$list_sub[0] = array("180","部署計","L");
$list_sub[1] = array("180","総合計","L");

//入金日情報
$list_sub2[0] = array("87.5","入金日","L");
$list_sub2[1] = array("87.5","現金入金","L");
$list_sub2[2] = array("87.5","振込入金","L");
$list_sub2[3] = array("87.5","手形入金","L");
$list_sub2[4] = array("87.5","その他入金","L");
$list_sub2[5] = array("87.5","手数料","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "C";
$data_align[3] = "R";
$data_align[4] = "R";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "R";
$data_align[11] = "R";

//入力者取得SQL
$sql_person = "SELECT DISTINCT person FROM t_op;";

//ページ最大表示数
$page_max = 50;

//開始期間
$start_time = "2005-04-01";
$end_time = "2005-04-02";

//仮の時刻
$time = "対象期間：2005年04月01日　18:00 〜 2005年04月02日　18:00";

//***********************************************

//DB接続
$db_con = Db_Connect("amenity_test");

// 権限チェック
$auth       = Auth_Check($db_con);

$result_person = Db_Query($db_con,$sql_person);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//入力者が存在する間出力
while($person_list = pg_fetch_array($result_person)){

	//データ取得SQL(部署・担当者・売上計上日・現金売上・掛売上・売上合計・現金消費税・掛消費税・現金税込計・掛税込計・税込総合計・粗利金額)
	$sql = "SELECT section,person2,date,money1,money2,money3,money4,money5,money6,money7,money8,money9 FROM t_op WHERE person = '".$person_list[0]."';";

	$result = Db_Query($db_con,$sql);

	//入力者取得
	$person ="オペレータ：".$person_list[0];

	$pdf->SetFont(GOTHIC, '', 9);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();
	
	//ＤＢの値を表示
	//行数・ページ数・次のページ表示数・比較値、初期化
	$count = 0;
	$row_count = 0;
	$page_count = 1;
	$page_next = $page_max;
	$data_sub = array();
	$data_total = array();
	$section = "";
	$charge = "";

	//部署ごとに出力
	while($data_list = pg_fetch_array($result)){

		$count++;
		$row_count++;
		/**********************ヘッダー処理**************************/
		//一行目の場合、ヘッダ出力
		if($row_count == 1){

			$date = date("印刷時刻　Y年m月d日　H:i");
			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

		}

		//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $row_count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

		//******************担当者省略判定*****************************

		//担当者が同じ場合(日付が違う)
		if($charge != $data_list[1]){
			//値の省略判定フラグ
			$space_flg = true;
			$charge = $data_list[1];
		}

		//******************小計処理***********************************

		//値が変わった場合、小計表示
		if($section != $data_list[0]){
			//一行目は、値をセットするだけ
			if($row_count != 1){
				$pdf->SetFillColor(220,220,220);
				
				for($x=0;$x<11;$x++){
					//小計行番号
					if($x==0){
						$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
					//部署計名
					}else if($x==1){
						$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
					//部署計値
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
				//粗利金額
				//小計値を合計値に足していく
				$data_total[$x] = $data_total[$x] + $data_sub[$x];
				$data_sub[$x] = number_format($data_sub[$x]);
				$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
				//小計、初期化
				$data_sub = array();
				$count++;
				$row_count++;
			}
			$section = $data_list[0];
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, '', 9);

		//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $row_count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

		//************************データ表示***************************

		for($x=0;$x<11;$x++){
			//表示値
			$contents = "";
			//表示line		
			$line = "";

			//行番号
			if($x==0){
				$contents = "$count";
				$line = '1';
			//担当者が一行目か省略フラグがtrueの時、セルを結合
			}else if($x==1 && $row_count == 1 || $space_flg == true){
				//ページの最大表示数・左テーブルの最大表示数・データの行数
				$contents = $data_list[$x];
				if($page_next == $row_count || $row == $row_count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//省略する
				$space_flg = false;
			//既に小計名を表示させたか
			}else if($x==1){
				$contents = '';
				if($page_next == $row_count || $row == $row_count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			}else{
				//数値の場合は、小計算
				if(is_numeric($data_list[$x])){
					//値を小計に足していく
					$data_sub[$x] = $data_sub[$x] + $data_list[$x];
					$data_list[$x] = number_format($data_list[$x]);
				}
				$contents = $data_list[$x];
				$line = '1';
			}
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
		//粗利金額
		$data_sub[$x] = $data_sub[$x] + $data_list[$x];
		$data_list[$x] = number_format($data_list[$x]);
		$pdf->Cell($list[$x][0], 14, $data_list[$x], '1', '2', $data_align[$x]);
	}
	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(220,220,220);
	$count++;
	$row_count++;

	//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $row_count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

	//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

	//******************最終小計処理***********************************
		
	for($x=0;$x<11;$x++){
		//小計行番号
		if($x==0){
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
		//部署計名
		}else if($x==1){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		//部署計値
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
	//粗利金額
	//小計値を合計値に足していく
	$data_total[$x] = $data_total[$x] + $data_sub[$x];
	$data_sub[$x] = number_format($data_sub[$x]);
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
	//小計、初期化
	$data_sub = array();

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(180,180,180);
	$count++;
	$row_count++;

	//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $row_count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

	//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

	//*************************合計処理*******************************

	for($x=0;$x<11;$x++){
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
	//合計、初期化
	$data_total = array();

	$row_count++;
	//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $row_count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//空白行
	$pdf->Cell(1110, 14, "", '', '2','C');

	//*************************入金日処理*******************************

	//入金日・現金入金・振込入金・手形入金・その他入金・手数料、取得
	$sql = "SELECT date,money1,money2,money3,money4,money5 FROM t_op_maney WHERE person = '".$person_list[0]."' AND date BETWEEN '".$start_time."' AND '".$end_time."';";
	$result = Db_Query($db_con,$sql);
	//入金情報が存在する間
	while($data_list = pg_fetch_array($result)){

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$count++;
		$row_count++;

		//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $row_count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		//*************************************************************

		//行
		$pdf->Cell($list[0][0], 14, "$count", '1', '0',$data_align[0]);
		for($x=0;$x<5;$x++){
			//入金日
			if($x==0){
				$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2]);
				$pdf->Cell(92.5, 14, $data_list[$x], '1', '0','C');
			//現金入金
			}else{
				$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2]);
				$data_list[$x] = number_format($data_list[$x]);
				$pdf->Cell(92.5, 14, $data_list[$x], '1', '0','R');
			}
		}
		//手数料
		$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2]);
		$data_list[$x] = number_format($data_list[$x]);
		$pdf->Cell(92.5, 14, $data_list[$x], '1', '2','R');
	}
}

//*************************全社計処理*******************************

//全社計取得SQL
$sql = "SELECT section,person2,date,sum(money1),sum(money2),sum(money3),sum(money4),sum(money5),sum(money6),sum(money7),sum(money8),sum(money9) FROM t_op GROUP BY staff_id,section,person2,date ORDER BY staff_id ASC;";

$result = Db_Query($db_con,$sql);

$person ="オペレータ：全社計";

$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・比較値、初期化
$count = 0;
$row_count = 0;
$page_count = 1;
$page_next = $page_max;
$data_sub = array();
$data_total = array();
$section = "";
$charge = "";

//担当者・日付ごとに出力
while($data_list = pg_fetch_array($result)){

	$count++;
	$row_count++;

	/**********************ヘッダー処理**************************/
	//一行目の場合、ヘッダ出力
	if($row_count == 1){

		//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

	}

	//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $row_count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************担当者省略判定*****************************

	//担当者が同じ場合(日付が違う)
	if($charge != $data_list[1]){
		//値の省略判定フラグ
		$space_flg = true;
		$charge = $data_list[1];
	}

	//******************小計処理***********************************

	//値が変わった場合、小計表示
	if($section != $data_list[0]){
		//一行目は、値をセットするだけ
		if($row_count != 1){
			$pdf->SetFillColor(220,220,220);
			
			for($x=0;$x<11;$x++){
				//小計行番号
				if($x==0){
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
				//部署計名
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//部署計値
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
			//粗利金額
			//小計値を合計値に足していく
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//小計、初期化
			$data_sub = array();
			$count++;
			$row_count++;
		}
		$section = $data_list[0];
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

	//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $row_count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//************************データ表示***************************

	for($x=0;$x<11;$x++){
		//表示値
		$contents = "";
		//表示line		
		$line = "";

		//行番号
		if($x==0){
			$contents = "$count";
			$line = '1';
		//担当者が一行目か省略フラグがtrueの時、セルを結合
		}else if($x==1 && $row_count == 1 || $space_flg == true){
			//ページの最大表示数・左テーブルの最大表示数・データの行数
			$contents = $data_list[$x];
			if($page_next == $row_count || $row == $row_count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//省略する
			$space_flg = false;
		//既に小計名を表示させたか
		}else if($x==1){
			$contents = '';
			if($page_next == $row_count || $row == $row_count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		}else{
			//数値の場合は、小計算
			if(is_numeric($data_list[$x])){
				//値を小計に足していく
				$data_sub[$x] = $data_sub[$x] + $data_list[$x];
				$data_list[$x] = number_format($data_list[$x]);
			}
			$contents = $data_list[$x];
			$line = '1';
		}
		$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
	}
	//粗利金額
	$data_sub[$x] = $data_sub[$x] + $data_list[$x];
	$data_list[$x] = number_format($data_list[$x]);
	$pdf->Cell($list[$x][0], 14, $data_list[$x], '1', '2', $data_align[$x]);
}
//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(220,220,220);
$count++;
$row_count++;

//*******************改ページ処理*****************************

//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $row_count){
	$page_count++;
	$pdf->AddPage();

	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

	//次の最大表示数
	$page_next = $page_max * $page_count;
	$space_flg = true;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//******************最終小計処理***********************************
	
for($x=0;$x<11;$x++){
	//小計行番号
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//部署計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//部署計値
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
//粗利金額
//小計値を合計値に足していく
$data_total[$x] = $data_total[$x] + $data_sub[$x];
$data_sub[$x] = number_format($data_sub[$x]);
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//小計、初期化
$data_sub = array();

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;
$row_count++;

//*******************改ページ処理*****************************

//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $row_count){
	$page_count++;
	$pdf->AddPage();

	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

	//次の最大表示数
	$page_next = $page_max * $page_count;
	$space_flg = true;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//*************************合計処理*******************************

for($x=0;$x<11;$x++){
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
//合計、初期化
$data_total = array();

$row_count++;
//*******************改ページ処理*****************************

//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $row_count){
	$page_count++;
	$pdf->AddPage();

	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

	//次の最大表示数
	$page_next = $page_max * $page_count;
	$space_flg = true;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//空白行
$pdf->Cell(1110, 14, "", '', '2','C');

//*************************入金日処理*******************************

//入金日・現金入金・振込入金・手形入金・その他入金・手数料、取得
$sql = "SELECT date,sum(money1),sum(money2),sum(money3),sum(money4),sum(money5) FROM t_op_maney WHERE date BETWEEN '".$start_time."' AND '".$end_time."' GROUP BY date;";
$result = Db_Query($db_con,$sql);
//入金情報が存在する間
while($data_list = pg_fetch_array($result)){

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$count++;
	$row_count++;

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $row_count){
		$page_count++;
		$pdf->AddPage();

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	//*************************************************************

	//行
	$pdf->Cell($list[0][0], 14, "$count", '1', '0',$data_align[0]);
	for($x=0;$x<5;$x++){
		//入金日
		if($x==0){
			$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2]);
			$pdf->Cell(92.5, 14, $data_list[$x], '1', '0','C');
		//現金入金
		}else{
			$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2]);
			$data_list[$x] = number_format($data_list[$x]);
			$pdf->Cell(92.5, 14, $data_list[$x], '1', '0','R');
		}
	}
	//手数料
	$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2]);
	$data_list[$x] = number_format($data_list[$x]);
	$pdf->Cell(92.5, 14, $data_list[$x], '1', '2','R');
}

$pdf->Output();

?>
