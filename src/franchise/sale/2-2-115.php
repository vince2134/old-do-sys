<?php

//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

class PDF extends MBFPDF
{ 
//A3の横幅は、1110
//ヘッダ部分表示
function Header(){
			$left_margin = 40;
			$top_margin = 40;
			$time = "20060214";//対象期間
			$time2 = "20060313";//対象期間
			$title = "巡回予定カレンダー（週）";//タイトル
			$staff = "担当者A";//担当者名
			$position = "部署A";//部署名
			$date = date("印刷時刻　Y年m月d日　H：i");//印刷時刻
			$year = substr($time,0,4);//年のみ取得
			$month = substr($time,4,2);//月のみ取得
			$day = substr($time,6,2);//日のみ取得
			$year2 = substr($time2,0,4);//年のみ取得
			$month2 = substr($time2,4,2);//月のみ取得
			$day2 = substr($time2,6,2);//日のみ取得
			$time = $year."年".$month."月".$day."日";
			$time2 = $year2."年".$month2."月".$day2."日";
			
			$count_cell = date("w", mktime(0, 0, 0, $month, $day, $year));//曜日を取得する
			//A3の横幅は、1110
			$this->SetXY($left_margin,$top_margin);
			$this->Cell(1110, 14,"変更予定表", '0', '1', 'L');
			$this->SetXY($left_margin,$top_margin);
			$this->Cell(1110, 14, $title, '0', '1', 'C');
			$this->SetXY($left_margin,$top_margin);
			$this->PageNo();
			$this->Cell(1110, 14, $this->PageNo()."ページ", '0', '1', 'R');
			$this->SetX($left_margin);
			$this->Cell(1110, 14, $date, '0', '1', 'R');
			$this->SetXY($left_margin,$top_margin+14);
			$this->Cell(1110, 14,"部署：".$position, '0', '1', 'L');
			$this->SetXY($left_margin,$top_margin+28);
			$this->Cell(1110, 14,"対象期間：".$time."〜".$time2, '0', '2', 'R');
	}
}

//*******************入力箇所*********************

//ページサイズ
//A3
$pdf=new PDF('L','pt','A3');

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(0,100);
$pdf->AddPage();
$staff = "担当者A";//担当者名
$time = "200512";//対象期間
$round='C';//巡回基準
$row_day = 0;//一日の件数
$row_1 = 1;
$data_row = 1;
$i = 1;

$left_margin = 40;
$top_margin = 40;

//背景色を付ける
$pdf->SetFillColor(215,215,215);
$pdf->Rect(40,82,140,750,FD);
$pdf->SetFillColor(255);
$pdf->Rect(170,82,140,750,FD);
$pdf->Rect(310,82,140,750,FD);
$pdf->Rect(450,82,140,750,FD);
$pdf->Rect(590,82,140,750,FD);
$pdf->Rect(730,82,140,750,FD);
$pdf->SetFillColor(204,204,255);
$pdf->Rect(870,82,140,750,FD);
$pdf->SetFillColor(255,204,207);
$pdf->Rect(1010,82,140,750,FD);

//項目名・幅・align
$list[0] = array("130","巡回基準","C");
$list[1] = array("420","Ｂ","C");
$list[2] = array("560","Ｃ","C");

for($s=1;$s<5;$s++){
	for($i=1;$i<100;$i++){
		$data_list[$s] .= array("巡回担当".$s,$s."-".$i,"得意先".$i,$day);
		if($day == 31){
			$day=1;
		}else{
			$day++;
		}
	}
}

//巡回基準の行を表示（A、B、C、Dと表示する部分）
$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(200,200,200);
$pdf->Cell($list[0][0], 14, $list[0][1], '1', '0', $list[0][2],'1');
$pdf->Cell($list[1][0], 14, $list[1][1], '1', '0', $list[1][2],'1');
$pdf->Cell($list[2][0], 14, $list[2][1], '1', '0', $list[2][2],'1');


//項目名・幅・align
$list[0] = array("130","巡回日","C");
$list[1] = array("140","20日","C");
$list[2] = array("140","21日","C");
$list[3] = array("140","22日","C");
$list[4] = array("140","23日","C");
$list[5] = array("140","24日","C");
$list[6] = array("140","25日","C");
$list[7] = array("140","26日","C");

$posY = $posY+14; //行のポインタを次の行へ
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(200,200,200);
for($i=0;$i<8;++$i){
	//$pdf->Cell($list[0][0], 14, $list[0][1], '1', '0', $list[0][2],'1');
	$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2],'1');
}
//日付取得・形式変更
$year = substr($time,0,4);//年のみ取得
$month = substr($time,4,2);//月のみ取得
$when = mktime(0, 0, 0, $month, 1, $year);
$date_month = date("t", $when);//月の日数
//***********************************************
$count_cell = date("w", mktime(0, 0, 0, $month, $day, $year));//曜日を取得する


//各週の開始日を取得
if($count_cell==1){
	$week_sday[1] = "1";
}else if($count_cell==2){
	$week_sday[1] = "0";
}else if($count_cell==3){
	$week_sday[1] = "-1";
}else if($count_cell==4){
	$week_sday[1] = "-2";
}else if($count_cell==5){
	$week_sday[1] = "-3";
}else if($count_cell==6){
	$week_sday[1] = "-4";
}else if($count_cell==7){
	$week_sday[1] = "-5";
}
$week_sday[2] = $week_sday[1]+7;
$week_sday[3] = $week_sday[2]+7;
$week_sday[4] = $week_sday[3]+7;
$week_sday[5] = $week_sday[4]+7;
$week_sday[6] = $week_sday[5]+7;

//一日の巡回件数を取得
for($i=$week_sday[1];$i<32;$i++){
	$work_count[$i] = count($data[$i]); //一日の巡回件数
}

//$work_countを一週間ごとの配列に分ける
$num=array_chunk($work_count, 7);

//週の最大件数を取得
$i=1;
while($val = each($num)){
	$week_maxrow[$i] = max($val[1]);
	$i++;
}

if($date_month==28 && $count_cell==1){
	$data_row = 4;
}else if($date_month==30 && $count_cell==7){
	$data_row = 6;
}else if($date_month==31 && $count_cell==7 || $date_month==31 && $count_cell==6){
	$data_row = 6;
}else{
	$data_row = 5;
}

$start_X = "40";
$start_Y = "96";

$page1=0;

//Print_DataList($pdf,$week_maxrow[1],$start_Y,$round,$week_sday[1],$data,$date_month);
$start_Y = $start_Y+14*$week_maxrow[1]+14;
$page1= $page1+$week_maxrow[1];

if(48<$page1+$week_maxrow[2]) {
	$start_Y = "96";
	$end_Y=$pdf->GetY();//最終Y座標
	//はみ出した背景色等を塗りつぶす
	$pdf->SetFillColor(255);
	$pdf->Rect(0,$end_Y+0.5,1190,760,F);
	$pdf->SetLineWidth(0.8);
	$pdf->Line(40,$end_Y,1150,$end_Y);
	$pdf->AddPage();
	$page1=0;
}

$round = array(
	"1" => "担当者1",
	"2" => "担当者2",
	"3" => "担当者3",
	"4" => "担当者4",
	"5" => "担当者5",
	"6" => "担当者6",
	"7" => "担当者7",
);
//function Print_DataList($pdf,$row,$start_Y,$round,$week_sday,$data,$date_month){
Print_DataList($pdf,$week_maxrow[2],$start_Y,$round[2],$week_sday[2],$data,$date_month);
$start_Y = $start_Y+14*$week_maxrow[2]+14;
$page1= $page1+$week_maxrow[2];

if(47<$page1+$week_maxrow[3]) {
	$start_Y = "96";
	$end_Y=$pdf->GetY();//最終Y座標
	//はみ出した背景色等を塗りつぶす
	$pdf->SetFillColor(255);
	$pdf->Rect(0,$end_Y+0.5,1190,760,F);
	$pdf->SetLineWidth(0.8);
	$pdf->Line(40,$end_Y,1150,$end_Y);
	$pdf->AddPage();
	$page1=0;
}

//Print_DataList($pdf,$week_maxrow[3],$start_Y,$round,$week_sday[3],$data,$date_month);
Print_DataList($pdf,$week_maxrow[3],$start_Y,$round[3],$week_sday[3],$data,$date_month);
$start_Y = $start_Y+14*$week_maxrow[3]+14;
$page1= $page1+$week_maxrow[3];

if(46<$page1+$week_maxrow[4]) {
	$start_Y = "96";
	$end_Y=$pdf->GetY();//最終Y座標
	//はみ出した背景色等を塗りつぶす
	$pdf->SetFillColor(255);
	$pdf->Rect(0,$end_Y+0.5,1190,760,F);
	$pdf->SetLineWidth(0.8);
	$pdf->Line(40,$end_Y,1150,$end_Y);
	$pdf->AddPage();
	$page1=0;
}

Print_DataList($pdf,$week_maxrow[4],$start_Y,$round[4],$week_sday[4],$data,$date_month);
$start_Y = $start_Y+14*$week_maxrow[4]+14;
$page1= $page1+$week_maxrow[4];

if($data_row >= 5){
	if(45<$page1+$week_maxrow[5]) {
		$start_Y = "96";
		$end_Y=$pdf->GetY();//最終Y座標
		//はみ出した背景色等を塗りつぶす
		$pdf->SetFillColor(255);
		$pdf->Rect(0,$end_Y+0.5,1190,760,F);
		$pdf->SetLineWidth(0.8);
		$pdf->Line(40,$end_Y,1150,$end_Y);
		$pdf->AddPage();
		$page1=0;
	}
	Print_DataList($pdf,$week_maxrow[5],$start_Y,$round[5],$week_sday[5],$data,$date_month);
	$start_Y = $start_Y+14*$week_maxrow[5]+14;
	$page1= $page1+$week_maxrow[5];
}
if($data_row == 6){
	if(44<$page1+$week_maxrow[6]) {
		$start_Y = "96";
		$end_Y=$pdf->GetY();//最終Y座標
		//はみ出した背景色等を塗りつぶす
		$pdf->SetFillColor(255);
		$pdf->Rect(0,$end_Y+0.5,1190,760,F);
		$pdf->SetLineWidth(0.8);
		$pdf->Line(40,$end_Y,1150,$end_Y);
		$pdf->AddPage();
	}
	Print_DataList($pdf,$week_maxrow[6],$start_Y,$round[6],$week_sday[6],$data,$date_month);
	$start_Y = $start_Y+14*$week_maxrow[6]+14;
}

$end_Y=$pdf->GetY();//最終Y座標
//はみ出した背景色等を塗りつぶす
$pdf->SetFillColor(255);
$pdf->Rect(0,$end_Y+0.5,1190,760,F);
$pdf->SetLineWidth(0.8);
$pdf->Line(40,$end_Y,1150,$end_Y);
$pdf->Output();

//**********************データ表示部分関数***********************
function Print_DataList($pdf,$row,$start_Y,$round,$week_sday,$data,$date_month){

	//始点の定義
	$start_X=40;
	$end_Y = $row*14+14+$start_Y;

	//巡回基準日
	$pdf->SetXY($start_X,$start_Y);
	$pdf->Cell(130, $row*14+14, $round, '1', '2','C');
	//$pdf->Cell(130, $row*14+14, '担当者', '1', '2','C');

	//次の始点座標を定義
	$date_y=$start_Y;
	$start_X= $start_X+130;

	//一週間分（7日）のデータを表示
	for($j=$week_sday;$j<$week_sday+7;$j++){
		/***********************************/
		//1日からその月の最終日まで
		if($j>=1 && $j<=$date_month){
			//日付を書く
			$pdf->SetXY($start_X,$start_Y);
			//０埋め
			$j = str_pad($j, 2, 0, STR_POS_LEFT);
			$pdf->Cell(140, 14,'01-'.$j.'   得意先'.$j, '0', '2','C');
		}

		for($i=0;$i<$row;++$i){
			//巡回データを表示
			$date_y = $date_y+14;
			$pdf->SetXY($start_X,$date_y);
			$pdf->Cell(140, 14, $data[$j][$i], '0', '2',L);
		}

		//次の始点座標を定義
		$date_y=$start_Y;
		$start_X= $start_X+140;
		/***********************************/
	}
	//横線
	$pdf->Line(40,$end_Y,1150,$end_Y);

	//日付下線
	$pdf->SetLineWidth(0.05);//線を細くする
	$pdf->Line(170,$start_Y+14,1150,$start_Y+14);
}

//*****************************************************************

?>