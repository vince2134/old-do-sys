<?php

/******
�ѹ�����
���ǡ�����̵����exit

******/
exit;


//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

class PDF extends MBFPDF
{ 
//A3�β����ϡ�1110
//�إå���ʬɽ��
function Header(){
			//�طʿ����դ���
			$this->SetFillColor(215,215,215);
			$this->Rect(40,82,140,750,FD);
			$this->SetFillColor(255);
			$this->Rect(170,82,140,750,FD);
			$this->Rect(310,82,140,750,FD);
			$this->Rect(450,82,140,750,FD);
			$this->Rect(590,82,140,750,FD);
			$this->Rect(730,82,140,750,FD);
			$this->SetFillColor(204,204,255);
			$this->Rect(870,82,140,750,FD);
			$this->SetFillColor(255,204,207);
			$this->Rect(1010,82,140,750,FD);
			//����̾������align
			$list[0] = array("130","�����","C");
			$list[1] = array("140","��","C");
			$list[2] = array("140","��","C");
			$list[3] = array("140","��","C");
			$list[4] = array("140","��","C");
			$list[5] = array("140","��","C");
			$list[6] = array("140","��","C");
			$list[7] = array("140","��","C");

			$left_margin = 40;
			$top_margin = 40;
			$time = "200512";//�оݴ���
			$title = "���ͽ�ꥫ�������ʷ��";//�����ȥ�
			$staff = "ô����A";//ô����̾
			$position = "����A";//����̾
			$date = date("�������Yǯm��d����H��i");//��������
			$year = substr($time,0,4);//ǯ�Τ߼���
			$month = substr($time,4,2);//��Τ߼���
			$time = $year."ǯ".$month."��";
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
			$this->Cell(1110, 14,"���ô����".$staff, '0', '2', 'L');
			$this->SetXY($left_margin,$top_margin+28);
			$this->Cell(1110, 14,"�оݴ��֡�".$time, '0', '2', 'R');
			//����ɽ��
			$posY = $this->GetY();
			$this->SetXY($left_margin, $posY);
			$this->SetFillColor(200,200,200);
			for($i=0;$i<count($list)-2;$i++)
			{
				$this->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2],'1');
				if($i==5){
					$this->SetFillColor(204,204,255);
					$this->Cell($list[6][0], 14, $list[6][1], '1', '0', $list[6][2],'1');
				}
			}
			$this->SetFillColor(255,204,207);
			$this->Cell($list[7][0], 14, $list[7][1], '1', '2', $list[7][2],'1');
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
$round='C';//�����c
$row_day = 0;//�����η��
$row_1 = 1;
$data_row = 1;
$i = 1;

//$list_flg = false;//�콵�ܤ���Ϥ�����
//align(�ǡ���)
$data_align[0] = "C";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "L";
$data_align[4] = "L";
$data_align[5] = "L";
$data_align[6] = "L";
$data_align[7] = "L";
//���ռ����������ѹ�
$year = substr($time,0,4);//ǯ�Τ߼���
$month = substr($time,4,2);//��Τ߼���
$when = mktime(0, 0, 0, $month, 1, $year);
$date_month = date("t", $when);//�������
//***********************************************

//DB��³
$db_con = Db_Connect("amenity_test");

// ���¥����å�
//$auth       = Auth_Check($db_con);

//�ǡ�������
$sql    = "SELECT arrival_day,staff_name,client_name,route ";
$sql   .= "FROM t_calendar ";
$sql   .= "WHERE staff_name = '$staff' ";
$sql   .= " AND arrival_day LIKE '$year-$month%' ";
$sql   .= "ORDER BY arrival_day ASC;";
$result = Db_Query($db_con,$sql);

$count_cell = date("w", mktime(0, 0, 0, $month, 1, $year));//��ΰ������������������
$count_cell1 = $count_cell;
//**********************�ǡ���ɽ����ʬ�ؿ�***********************
function Print_DataList($pdf,$row,$start_Y,$round,$week_sday,$data,$date_month){
	
	//���������
	$start_X=40;
	$end_Y = $row*14+14+$start_Y;

	//�������
	$pdf->SetXY($start_X,$start_Y);
	$pdf->Cell(130, $row*14+14, $round, '1', '2','C');

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
			$pdf->Cell(140, 14, $j.'��', '0', '2','C');
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


//ɽ���ǡ������������Ͽ����
while($data_list = pg_fetch_array($result)){
	$work_day    = (int)substr($data_list[0],8,2); //�����
	$client_name = $data_list[2];                  //������̾
	$data[$work_day][] = "$client_name";
}

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

Print_DataList($pdf,$week_maxrow[1],$start_Y,$round,$week_sday[1],$data,$date_month);
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
if($round=='A'){
	$round='B';
}else if($round=='B'){
	$round='C';
}else if($round=='C'){
	$round='D';
}else if($round=='D'){
	$round='A';
}
Print_DataList($pdf,$week_maxrow[2],$start_Y,$round,$week_sday[2],$data,$date_month);
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
if($round=='A'){
	$round='B';
}else if($round=='B'){
	$round='C';
}else if($round=='C'){
	$round='D';
}else if($round=='D'){
	$round='A';
}
Print_DataList($pdf,$week_maxrow[3],$start_Y,$round,$week_sday[3],$data,$date_month);
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
if($round=='A'){
	$round='B';
}else if($round=='B'){
	$round='C';
}else if($round=='C'){
	$round='D';
}else if($round=='D'){
	$round='A';
}
Print_DataList($pdf,$week_maxrow[4],$start_Y,$round,$week_sday[4],$data,$date_month);
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
	if($round=='A'){
		$round='B';
	}else if($round=='B'){
		$round='C';
	}else if($round=='C'){
		$round='D';
	}else if($round=='D'){
		$round='A';
	}
	Print_DataList($pdf,$week_maxrow[5],$start_Y,$round,$week_sday[5],$data,$date_month);
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
	if($round=='A'){
		$round='B';
	}else if($round=='B'){
		$round='C';
	}else if($round=='C'){
		$round='D';
	}else if($round=='D'){
		$round='A';
	}
	Print_DataList($pdf,$week_maxrow[6],$start_Y,$round,$week_sday[6],$data,$date_month);
	$start_Y = $start_Y+14*$week_maxrow[6]+14;
}

$end_Y=$pdf->GetY();//�ǽ�Y��ɸ
//�Ϥ߽Ф����طʿ������ɤ�Ĥ֤�
$pdf->SetFillColor(255);
$pdf->Rect(0,$end_Y+0.5,1190,760,F);
$pdf->SetLineWidth(0.8);
$pdf->Line(40,$end_Y,1150,$end_Y);
$pdf->Output();


?>