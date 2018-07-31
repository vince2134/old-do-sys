<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ヘッダーのフォントサイズ
$font_size = 8;
//ページサイズ
$page_size = 515;

//A4
$pdf=new MBFPDF('P','pt','A4');

//タイトル
$title = "商品予定出荷一覧表";
$page_count = "0"; 

//仮の時刻
$werehouse ="配送日：2005年04月01日〜2005年04月31日";

//項目名・幅・align 515
$list[0] = array("30","NO","C");
$list[1] = array("50","商品コード","C");
$list[2] = array("280","商品名","C");
$list[3] = array("55","数量","C");
$list[4] = array("55","訂正欄","C");
$list[5] = array("45","確認欄","C");

//Ｍ区分計・合計名
$list_sub[0] = array("50","合計","L");
$list_sub[1] = array("50","総合計","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "R";
$data_align[4] = "L";
$data_align[5] = "R";

//担当者取得SQL
$sql_person = "SELECT DISTINCT person FROM t_article;";

//ページ最大表示数
$page_max = 50;

//***********************************************

//DB接続
$db_con = Db_Connect("amenity_test");

// 権限チェック
//$auth       = Auth_Check($db_con);

$result_person = Db_Query($db_con,$sql_person);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//担当者が存在する間出力
while($person_list = pg_fetch_array($result_person)){

	//データ取得SQL(商品コード,商品名,数量)
	$sql = "SELECT goods_num,goods,num1 FROM t_article ";
	$sql .= "WHERE person = '".$person_list[0]."';";

	$result = Db_Query($db_con,$sql);

	//担当者取得
	$person ="担当者：".$person_list[0];

	$pdf->SetFont(GOTHIC, '', 8);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//ＤＢの値を表示
	//行数・ページ数・次のページ表示数・小計・合計・比較値、初期化
	$count = 0;
	$page_count++;
	$page_next = $page_max;
	$data_sub = array();
	$data_total = array();

	//担当者ごとに出力
	while($data_list = pg_fetch_array($result)){

		$count++;
		/**********************ヘッダー処理**************************/
		//一行目の場合、ヘッダ出力
		if($count == 1){

			$pdf->SetXY($left_margin+90,$top_margin);
			$pdf->Cell(40,10,"確認欄",'LTBR','2','C');
			$pdf->Cell(40,28,"",'LRB');

			$date = date("印刷時刻　Y年m月d日　H：i");
			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);
		}

		//*******************改ページ処理*****************************

			//行番号がページ最大表示数になった場合、改ページする
			if($page_next+1 == $count){
				$pdf->AddPage();
				$pdf->SetXY($left_margin+90,$top_margin);
				$pdf->Cell(40,10,"確認欄",'LTBR','2','C');
				$pdf->Cell(40,28,"",'LRB');

				//ヘッダー表示
				Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);

				//次の最大表示数
				$page_next = $page_max * $page_count;
				$page_count++;
			}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, '', 9);

		//************************データ表示***************************
		//行番号
		$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
		for($x=1;$x<3;$x++){
			//表示値
			$contents = "";
			//表示line		
			$line = "";

			//商品コード・商品名
			$contents = $data_list[$x-1];
			$line = '1';
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
		//数量
		//値を小計に足していく
		$data_total[$x] = $data_total[$x] + $data_list[$x-1];
		$data_list[$x-1] = number_format($data_list[$x-1]);
		$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '0', $data_align[$x]);
		$x++;
		//訂正欄
		$pdf->Cell($list[$x][0], 14, '', '1', '0', $data_align[$x]);
		$x++;
		//確認欄
		$pdf->Cell($list[$x][0], 14, '', '1', '2', $data_align[$x]);
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
		$pdf->SetXY($left_margin+90,$top_margin);
		$pdf->Cell(40,10,"確認欄",'LTBR','2','C');
		$pdf->Cell(40,28,"",'LRB');

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$page_count++;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//*************************合計処理*******************************

	for($x=0;$x<3;$x++){
		//合計行番号
		if($x==0){
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
		//合計名
		}else if($x==1){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		//商品コード・商品名
		}else{
			$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
		}
	}
	//数量
	$data_total[$x] = number_format($data_total[$x]);
	$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	$x++;
	//訂正欄
	$pdf->Cell($list[$x][0], 14, '', '1', '0', $data_align[$x]);
	$x++;
	//確認欄
	$pdf->Cell($list[$x][0], 14, '', '1', '2', $data_align[$x]);
}

//************************全担当者計**********************************

//全社計取得SQL
$sql = "SELECT goods_num,goods,sum(num1) ";
$sql .= "FROM t_article GROUP BY goods_num,goods ";
$sql .= "ORDER BY goods_num ASC;";

$result = Db_Query($db_con,$sql);

//担当者取得
$person ="担当者：全担当者";

$pdf->SetFont(GOTHIC, '', 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・小計・合計・比較値、初期化
$count = 0;
$page_count++;
$page_next = $page_max;
$data_sub = array();
$data_total = array();

//商品コード・商品名ごとに出力
while($data_list = pg_fetch_array($result)){

	$count++;
	/**********************ヘッダー処理**************************/
	//一行目の場合、ヘッダ出力
	if($count == 1){

		$pdf->SetXY($left_margin+90,$top_margin);
		$pdf->Cell(40,10,"確認欄",'LTBR','2','C');
		$pdf->Cell(40,28,"",'LRB');

		$date = date("印刷時刻　Y年m月d日　H：i");
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);
	}

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$pdf->SetXY($left_margin+90,$top_margin);
		$pdf->Cell(40,10,"確認欄",'LTBR','2','C');
		$pdf->Cell(40,28,"",'LRB');

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$page_count++;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

	//************************データ表示***************************

	//行表示
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);

	for($x=1;$x<3;$x++){
		$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '0', $data_align[$x]);
	}
	//数量
	//値を小計に足していく
	$data_total[$x] = $data_total[$x] + $data_list[$x-1];
	$data_list[$x-1] = number_format($data_list[$x-1]);
	$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '0', $data_align[$x]);
	$x++;
	//訂正欄
	$pdf->Cell($list[$x][0], 14, '', '1', '0', $data_align[$x]);
	$x++;
	//確認欄
	$pdf->Cell($list[$x][0], 14, '', '1', '2', $data_align[$x]);
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
	$pdf->SetXY($left_margin+90,$top_margin);
	$pdf->Cell(40,10,"確認欄",'LTBR','2','C');
	$pdf->Cell(40,28,"",'LRB');

	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);

	//次の最大表示数
	$page_next = $page_max * $page_count;
	$page_count++;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//*************************合計処理*******************************

for($x=0;$x<3;$x++){
	//合計行番号
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//合計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//商品コード・商品名
	}else{
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
//数量
$data_total[$x] = number_format($data_total[$x]);
$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
$x++;
//訂正欄
$pdf->Cell($list[$x][0], 14, '', '1', '0', $data_align[$x]);
$x++;
//確認欄
$pdf->Cell($list[$x][0], 14, '', '1', '2', $data_align[$x]);

$pdf->Output();

?>
