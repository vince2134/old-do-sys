<?php

//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

class PDF extends MBFPDF
{ 
//A3�β����ϡ�1110
//�إå���ʬɽ��
function Header(){
			$left_margin = 40;
			$top_margin = 40;
			$time = "20060214";//�оݴ���
			$time2 = "20060313";//�оݴ���
			$title = "���ͽ�ꥫ�������ʽ���";//�����ȥ�
			$staff = "ô����A";//ô����̾
			$position = "����A";//����̾
			$date = date("�������Yǯm��d����H��i");//��������
			$year = substr($time,0,4);//ǯ�Τ߼���
			$month = substr($time,4,2);//��Τ߼���
			$day = substr($time,6,2);//���Τ߼���
			$year2 = substr($time2,0,4);//ǯ�Τ߼���
			$month2 = substr($time2,4,2);//��Τ߼���
			$day2 = substr($time2,6,2);//���Τ߼���
			$time = $year."ǯ".$month."��".$day."��";
			$time2 = $year2."ǯ".$month2."��".$day2."��";
			
			$count_cell = date("w", mktime(0, 0, 0, $month, $day, $year));//�������������
			//A3�β����ϡ�1110
			$this->SetXY($left_margin,$top_margin);
			$this->Cell(1110, 14,"�ѹ�ͽ��ɽ", '0', '1', 'L');
			$this->SetXY($left_margin,$top_margin);
			$this->Cell(1110, 14, $title, '0', '1', 'C');
			$this->SetXY($left_margin,$top_margin);
			$this->PageNo();
			$this->Cell(1110, 14, $this->PageNo()."�ڡ���", '0', '1', 'R');
			$this->SetX($left_margin);
			$this->Cell(1110, 14, $date, '0', '1', 'R');
			$this->SetXY($left_margin,$top_margin+14);
			$this->Cell(1110, 14,"����".$position, '0', '1', 'L');
			$this->SetXY($left_margin,$top_margin+28);
			$this->Cell(1110, 14,"�оݴ��֡�".$time."��".$time2, '0', '2', 'R');
	}
}

//*******************���ϲս�*********************

//�ڡ���������
//A3
$pdf=new PDF('L','pt','A3');

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(0,100);
$pdf->AddPage();
$staff = "ô����A";//ô����̾
$time = "200512";//�оݴ���
$round='C';//�����
$row_day = 0;//�����η��
$row_1 = 1;
$data_row = 1;
$i = 1;

$left_margin = 40;
$top_margin = 40;

//�طʿ����դ���
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

//����̾������align
$list[0] = array("130","�����","C");
$list[1] = array("420","��","C");
$list[2] = array("560","��","C");

for($s=1;$s<5;$s++){
	for($i=1;$i<100;$i++){
		$data_list[$s] .= array("���ô��".$s,$s."-".$i,"������".$i,$day);
		if($day == 31){
			$day=1;
		}else{
			$day++;
		}
	}
}

//�����ιԤ�ɽ����A��B��C��D��ɽ��������ʬ��
$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(200,200,200);
$pdf->Cell($list[0][0], 14, $list[0][1], '1', '0', $list[0][2],'1');
$pdf->Cell($list[1][0], 14, $list[1][1], '1', '0', $list[1][2],'1');
$pdf->Cell($list[2][0], 14, $list[2][1], '1', '0', $list[2][2],'1');


//����̾������align
$list[0] = array("130","�����","C");
$list[1] = array("140","20��","C");
$list[2] = array("140","21��","C");
$list[3] = array("140","22��","C");
$list[4] = array("140","23��","C");
$list[5] = array("140","24��","C");
$list[6] = array("140","25��","C");
$list[7] = array("140","26��","C");

$posY = $posY+14; //�ԤΥݥ��󥿤򼡤ιԤ�
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(200,200,200);
for($i=0;$i<8;++$i){
	//$pdf->Cell($list[0][0], 14, $list[0][1], '1', '0', $list[0][2],'1');
	$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2],'1');
}
//���ռ����������ѹ�
$year = substr($time,0,4);//ǯ�Τ߼���
$month = substr($time,4,2);//��Τ߼���
$when = mktime(0, 0, 0, $month, 1, $year);
$date_month = date("t", $when);//�������
//***********************************************
$count_cell = date("w", mktime(0, 0, 0, $month, $day, $year));//�������������


//�ƽ��γ����������
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

//�����ν���������
for($i=$week_sday[1];$i<32;$i++){
	$work_count[$i] = count($data[$i]); //�����ν����
}

//$work_count��콵�֤��Ȥ������ʬ����
$num=array_chunk($work_count, 7);

//���κ����������
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
	$end_Y=$pdf->GetY();//�ǽ�Y��ɸ
	//�Ϥ߽Ф����طʿ������ɤ�Ĥ֤�
	$pdf->SetFillColor(255);
	$pdf->Rect(0,$end_Y+0.5,1190,760,F);
	$pdf->SetLineWidth(0.8);
	$pdf->Line(40,$end_Y,1150,$end_Y);
	$pdf->AddPage();
	$page1=0;
}

$round = array(
	"1" => "ô����1",
	"2" => "ô����2",
	"3" => "ô����3",
	"4" => "ô����4",
	"5" => "ô����5",
	"6" => "ô����6",
	"7" => "ô����7",
);
//function Print_DataList($pdf,$row,$start_Y,$round,$week_sday,$data,$date_month){
Print_DataList($pdf,$week_maxrow[2],$start_Y,$round[2],$week_sday[2],$data,$date_month);
$start_Y = $start_Y+14*$week_maxrow[2]+14;
$page1= $page1+$week_maxrow[2];

if(47<$page1+$week_maxrow[3]) {
	$start_Y = "96";
	$end_Y=$pdf->GetY();//�ǽ�Y��ɸ
	//�Ϥ߽Ф����طʿ������ɤ�Ĥ֤�
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
	$end_Y=$pdf->GetY();//�ǽ�Y��ɸ
	//�Ϥ߽Ф����طʿ������ɤ�Ĥ֤�
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
		$end_Y=$pdf->GetY();//�ǽ�Y��ɸ
		//�Ϥ߽Ф����طʿ������ɤ�Ĥ֤�
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
		$end_Y=$pdf->GetY();//�ǽ�Y��ɸ
		//�Ϥ߽Ф����طʿ������ɤ�Ĥ֤�
		$pdf->SetFillColor(255);
		$pdf->Rect(0,$end_Y+0.5,1190,760,F);
		$pdf->SetLineWidth(0.8);
		$pdf->Line(40,$end_Y,1150,$end_Y);
		$pdf->AddPage();
	}
	Print_DataList($pdf,$week_maxrow[6],$start_Y,$round[6],$week_sday[6],$data,$date_month);
	$start_Y = $start_Y+14*$week_maxrow[6]+14;
}

$end_Y=$pdf->GetY();//�ǽ�Y��ɸ
//�Ϥ߽Ф����طʿ������ɤ�Ĥ֤�
$pdf->SetFillColor(255);
$pdf->Rect(0,$end_Y+0.5,1190,760,F);
$pdf->SetLineWidth(0.8);
$pdf->Line(40,$end_Y,1150,$end_Y);
$pdf->Output();

//**********************�ǡ���ɽ����ʬ�ؿ�***********************
function Print_DataList($pdf,$row,$start_Y,$round,$week_sday,$data,$date_month){

	//���������
	$start_X=40;
	$end_Y = $row*14+14+$start_Y;

	//�������
	$pdf->SetXY($start_X,$start_Y);
	$pdf->Cell(130, $row*14+14, $round, '1', '2','C');
	//$pdf->Cell(130, $row*14+14, 'ô����', '1', '2','C');

	//���λ�����ɸ�����
	$date_y=$start_Y;
	$start_X= $start_X+130;

	//�콵��ʬ��7���ˤΥǡ�����ɽ��
	for($j=$week_sday;$j<$week_sday+7;$j++){
		/***********************************/
		//1�����餽�η�κǽ����ޤ�
		if($j>=1 && $j<=$date_month){
			//���դ��
			$pdf->SetXY($start_X,$start_Y);
			//�����
			$j = str_pad($j, 2, 0, STR_POS_LEFT);
			$pdf->Cell(140, 14,'01-'.$j.'   ������'.$j, '0', '2','C');
		}

		for($i=0;$i<$row;++$i){
			//���ǡ�����ɽ��
			$date_y = $date_y+14;
			$pdf->SetXY($start_X,$date_y);
			$pdf->Cell(140, 14, $data[$j][$i], '0', '2',L);
		}

		//���λ�����ɸ�����
		$date_y=$start_Y;
		$start_X= $start_X+140;
		/***********************************/
	}
	//����
	$pdf->Line(40,$end_Y,1150,$end_Y);

	//���ղ���
	$pdf->SetLineWidth(0.05);//����٤�����
	$pdf->Line(170,$start_Y+14,1150,$start_Y+14);
}

//*****************************************************************

?>