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
$title = "売掛残高一覧表";
$page_count = 1; 

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("180","得意先","C");
$list[2] = array("80","前月未残","C");
$list[3] = array("80","当月入金","C");
$list[4] = array("80","調整額","C");
$list[5] = array("80","繰越額","C");
$list[6] = array("80","当月売上","C");
$list[7] = array("80","消費税","C");
$list[8] = array("80","税込売上","C");
$list[9] = array("80","今回残高","C");
$list[10] = array("130","部門","C");
$list[11] = array("130","担当者","C");

//合計名
$list_sub[0] = array("180","合計","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "R";
$data_align[3] = "R";
$data_align[4] = "R";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "L";
$data_align[11] = "L";

//データ取得SQL
$sql = "select shop_name,money1,money2,money3,money4,money5,money6,money7,money8,part,staff from t_sale;";

//現在の日付取得SQL
$sql_sale = "SELECT DISTINCT date FROM t_sale;";

//ページ最大表示数
$page_max = 50;


//***********************************************

//DB接続
$db_con = Db_Connect("amenity_test");

//日付取得
$result = Db_Query($db_con,$sql_sale);
$time = pg_fetch_result($result,0,0);

$result = Db_Query($db_con,$sql);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("印刷時刻　Y年m月d日　H:i");

//日付取得・形式変更
$year = substr($time,0,4);
$month = substr($time,5,2);
$time = $year."年".$month."月　現在";

//ヘッダー表示
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・小計・合計・比較値、初期化
$count = 0;
$page_count++;
$page_next = $page_max;
$data_total = array();
$goods = "";

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
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

//************************データ表示***************************

	//行番号
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<11;$x++){
		//表示値
		$contents = "";
		//表示line		
		$line = "";

		//数字か
		if(is_numeric($data_list[$x-1])){
			//値を小計に足していく
			$data_total[$x] = $data_total[$x] + $data_list[$x-1];
			$data_list[$x-1] = number_format($data_list[$x-1]);
		}
		$contents = $data_list[$x-1];
		$line = '1';
		$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
	}
	$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '2', $data_align[$x]);
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
	//合計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	}else{
	//合計値
		if(is_numeric($data_total[$x])){
			$data_total[$x] = number_format($data_total[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
//件数表示
$count--;
$pdf->Cell($list[$x][0], 14, "$count"."社", '1', '0','R','1');

//****************************************************************

$pdf->Output();

?>