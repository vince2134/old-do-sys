<?php
//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);
//*******************���ϲս�*********************

//;��
$left_margin = 40;
$top_margin = 40;

//�إå����Υե���ȥ�����
$font_size = 9;
//�ڡ���������
$page_size = 1110;

//A3
$pdf=new MBFPDF('L','pt','A3');

//�����ȥ�
$title = "��ݻĹ����ɽ";
$page_count = 1; 

//����̾������align
$list[0] = array("30","NO","C");
$list[1] = array("180","������","C");
$list[2] = array("80","����̤��","C");
$list[3] = array("80","��������","C");
$list[4] = array("80","Ĵ����","C");
$list[5] = array("80","���۳�","C");
$list[6] = array("80","�������","C");
$list[7] = array("80","������","C");
$list[8] = array("80","�ǹ����","C");
$list[9] = array("80","����Ĺ�","C");
$list[10] = array("130","����","C");
$list[11] = array("130","ô����","C");

//���̾
$list_sub[0] = array("180","���","L");

//align(�ǡ���)
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

//�ǡ�������SQL
$sql = "select shop_name,money1,money2,money3,money4,money5,money6,money7,money8,part,staff from t_sale;";

//���ߤ����ռ���SQL
$sql_sale = "SELECT DISTINCT date FROM t_sale;";

//�ڡ�������ɽ����
$page_max = 50;


//***********************************************

//DB��³
$db_con = Db_Connect("amenity_test");

//���ռ���
$result = Db_Query($db_con,$sql_sale);
$time = pg_fetch_result($result,0,0);

$result = Db_Query($db_con,$sql);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("�������Yǯm��d����H:i");

//���ռ����������ѹ�
$year = substr($time,0,4);
$month = substr($time,5,2);
$time = $year."ǯ".$month."�����";

//�إå���ɽ��
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

//�ģ¤��ͤ�ɽ��
//�Կ����ڡ����������Υڡ���ɽ���������ס���ס�����͡������
$count = 0;
$page_count++;
$page_next = $page_max;
$data_total = array();
$goods = "";

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$page_count++;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

//************************�ǡ���ɽ��***************************

	//���ֹ�
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<11;$x++){
		//ɽ����
		$contents = "";
		//ɽ��line		
		$line = "";

		//������
		if(is_numeric($data_list[$x-1])){
			//�ͤ򾮷פ�­���Ƥ���
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

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$page_count++;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//*************************��׽���*******************************

for($x=0;$x<11;$x++){
	//��׹��ֹ�
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//���̾
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	}else{
	//�����
		if(is_numeric($data_total[$x])){
			$data_total[$x] = number_format($data_total[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
//���ɽ��
$count--;
$pdf->Cell($list[$x][0], 14, "$count"."��", '1', '0','R','1');

//****************************************************************

$pdf->Output();

?>