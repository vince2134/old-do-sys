<?php
require('../../fpdf/mbfpdf.php');
//環境設定ファイル
require_once("ENV_local.php");
//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ページサイズ
//A3
$pdf=new MBFPDF('L','pt','A3');

//タイトル
$title = "サンプル一覧表";
$page_count = 1; 

//時刻
$time = "2005年04月　現在";

//***********************************************
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("印刷時刻　Y年m月d日　H:i");

//A3の横幅は、1110
$pdf->SetXY($left_margin,$top_margin);
$pdf->Cell(1110, 14, $title, '0', '1', 'C');
$pdf->SetXY($left_margin,$top_margin);
$pdf->Cell(1110, 14, $page_count."ページ", '0', '1', 'R');
$pdf->SetX($left_margin);
$pdf->Cell(1110, 14, $date, '0', '1', 'R');
$pdf->SetXY($left_margin+555,$top_margin+28);
$pdf->Cell(555, 14, $time, '0', '2', 'R');
//*******************入力箇所*********************

//項目名・幅・align
$list[0] = array("50","NO","C");
$list[1] = array("260","商品名","C");
$list[2] = array("150","担当者","C");
$list[3] = array("150","部門","C");
$list[4] = array("100","売上金額","C");
$list[5] = array("100","請求金額","C");
$list[6] = array("100","単価","C");
$list[7] = array("100","入金金額","C");
$list[8] = array("100","仕入金額","C");

//小計・合計名
$list_sub[0] = array("260","商品計","L");
$list_sub[1] = array("260","合計","L");

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

//データ取得SQL
$sql = "select * from t_test;";

//ページ最大表示数
$page_max = 50;

//***********************************************

//DB接続
$db_con = Db_Connect();
$result = Db_Query($db_con,$sql);

//項目表示
$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
for($i=0;$i<count($list)-1;$i++)
{
	$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
}
$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・小計・合計・比較値、初期化
$count = 0;
$page_count++;
$page_next = $page_max;
$data_sub = array();
$data_total = array();
$goods = "";

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		//A3の横幅は、1110
		$pdf->SetXY($left_margin,$top_margin);
		$pdf->Cell(1110, 14, $title, '0', '1', 'C');
		$pdf->SetXY($left_margin,$top_margin);
		$pdf->Cell(1110, 14, $page_count."ページ", '0', '1', 'R');
		$pdf->SetX($left_margin);
		$pdf->Cell(1110, 14, $date, '0', '1', 'R');
		$pdf->SetXY($left_margin+555,$top_margin+28);
		$pdf->Cell(555, 14, $time, '0', '2', 'R');

		//項目表示
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		for($i=0;$i<count($list)-1;$i++)
		{
			$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
		}
		$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

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
	if($goods != $data_list[1]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(213,213,213);
			//値の省略判定フラグ
			$space_flg = true;
			for($x=0;$x<8;$x++){
				//小計行番号
				if($x==0){
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
				//小計名
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
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
			if(is_numeric($data_sub[$x])){
				$data_total[$x] = $data_total[$x] + $data_sub[$x];
				$data_sub[$x] = number_format($data_sub[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//小計初期化
			$data_sub = array();
			$count++;
		}
		$goods = $data_list[1];
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

//************************データ表示***************************

	for($x=0;$x<8;$x++){
		//行番号
		if($x==0){
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
			//一行目か小計の後以外は値の省略
		}else if($x==1 && $count == 1 || $space_flg == true){
			//セル結合判定
			//ページの最大表示数か
			if($page_next == $count){
				$pdf->Cell($list[$x][0], 14, $data_list[$x], 'LRBT', '0',$data_align[$x]);
			}else{
				$pdf->Cell($list[$x][0], 14, $data_list[$x], 'LRT', '0',$data_align[$x]);
			}
			$space_flg = false;
		}else if($x==1){
			if($page_next == $count){
				$pdf->Cell($list[$x][0], 14, '', 'LBR', '0',$data_align[$x]);
			}else{
				$pdf->Cell($list[$x][0], 14, '', 'LR', '0',$data_align[$x]);
			}
		}else{
			if(is_numeric($data_list[$x])){
				//値を小計に足していく
				$data_sub[$x] = $data_sub[$x] + $data_list[$x];
				$data_list[$x] = number_format($data_list[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_list[$x], '1', '0', $data_align[$x]);
		}
	}
	if(is_numeric($data_list[$x])){
		$data_sub[$x] = $data_sub[$x] + $data_list[$x];
		$data_list[$x] = number_format($data_list[$x]);
	}
	$pdf->Cell($list[$x][0], 14, $data_list[$x], '1', '2', $data_align[$x]);
}
//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(213,213,213);
	$count++;
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************最終小計処理***********************************
	
for($x=0;$x<8;$x++){
	//小計行番号
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//小計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	}else{
	//小計値
		if(is_numeric($data_sub[$x])){
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
if(is_numeric($data_sub[$x])){
	$data_total[$x] = $data_total[$x] + $data_sub[$x];
	$data_sub[$x] = number_format($data_sub[$x]);
}
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//小計初期化
$data_sub = array();

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//*************************合計処理*******************************

for($x=0;$x<8;$x++){
	//合計行番号
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//合計名
	}else if($x==1){
		$pdf->Cell($list_sub[1][0], 14, $list_sub[1][1], '1', '0',$list_sub[1][2],'1');
	}else{
	//合計値
		if(is_numeric($data_total[$x])){
			$data_total[$x] = number_format($data_total[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
if(is_numeric($data_total[$x])){
	$data_total[$x] = number_format($data_total[$x]);
}
$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');

//****************************************************************

$pdf->Output();

?>
