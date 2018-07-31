<?php
//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);

//�إå���ɽ���ؿ�
//������PDF���֥������ȡ��ޡ����󡦥����ȥ롦����/����/����/�����Υإå����ܡ��ڡ��������ڡ�����������
function Header_user($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$page_size){

	$pdf->SetFont(GOTHIC, '', 9);
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell($page_size, 14, $title, '0', '1', 'C');
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell($page_size, 14, $page_count."�ڡ���", '0', '2', 'R');
	$pdf->SetX($left_margin);
	$pdf->Cell($page_size, 14, $left_top, '0', '1', 'L');
	$pdf->SetXY($left_margin,$top_margin+14);
	$pdf->Cell($page_size, 14, $right_top, '0', '1', 'R');
	$pdf->SetXY($left_margin,$top_margin+28);
	$pdf->Cell($page_size, 14, $right_bottom, '0', '1', 'R');
	$pdf->SetXY($left_margin,$top_margin+28);
	$pdf->Cell($page_size, 14, $left_bottom, '0', '2', 'L');

	//����
	$pdf->SetXY($left_margin+320,$top_margin);
	$pdf->Cell(40,10,"��ǧ��",'LTR','2','C');
	$pdf->Cell(40,25,"",'LRB');
	$pdf->Line($left_margin+320,$top_margin+10,$left_margin+360,$top_margin+10);

}

//*******************���ϲս�*********************

//;��
$left_margin = 40;
$top_margin = 40;

//�ڡ���������
$page_size = 515;

//A4
$pdf=new MBFPDF('P','pt','A4');

//�����ȥ�
$title = "�桼����������";
//�ڡ�����
$page_count = "1";

//�����å�̾�ʲ���
$staff_name = "�����å�̾: ";
$staff_name .= "�ǥ�桼��";
//����å�̾�ʲ���
$shop_name = "����å�̾: ";
$shop_name .= "������ҥ���˥ƥ�";

//����̾������align

//FC
$list[0] = array("250","ɽ�� ����","R");
$list[1] = array("250","FC","L");
$list[2] = array("235","������","L");
$list[3] = array("220","ͽ����","L");
$list[4] = array("205","ô�����̷��ͽ��ɽ","L");
$list[5] = array("205","�����̽���ͽ��ɽ","L");
$list[6] = array("205","ͽ��ǡ�������","L");
$list[7] = array("205","�������������ǧ","L");
$list[8] = array("205","ͽ��ǡ�������","L");
$list[9] = array("205","ͽ��ǡ����������","L");
$list[10] = array("205","���ʽвٳ�ǧ","L");
$list[11] = array("205","��������","L");
$list[12] = array("205","�����ɼ����","L");
$list[13] = array("220","�����","L");
$list[14] = array("205","�����ɼ����","L");
$list[15] = array("205","�����ɼ����","L");
$list[16] = array("205","�����ɼ����","L");
$list[17] = array("205","��α��ɼ����","L");
$list[18] = array("205","������ɼ����","L");
$list[19] = array("205","�¤����ʰ���","L");
$list[20] = array("205","�������ٰ���","L");
$list[21] = array("205","��塦�����Ѱ���","L");

//�����å���(FC)
//ɽ��
$list_check[0] = "��";
$list_check[1] = "��";
$list_check[2] = "��";
$list_check[3] = "��";
$list_check[4] = "��";
$list_check[5] = "��";
$list_check[6] = "��";
$list_check[7] = "��";
$list_check[8] = "��";
$list_check[9] = "";
$list_check[10] = "��";
$list_check[11] = "��";
$list_check[12] = "��";
$list_check[13] = "��";
$list_check[14] = "��";
$list_check[15] = "��";
$list_check[16] = "��";
$list_check[17] = "��";

//����
$list_check2[0] = "��";
$list_check2[1] = "��";
$list_check2[2] = "��";
$list_check2[3] = "��";
$list_check2[4] = "��";
$list_check2[5] = "��";
$list_check2[6] = "��";
$list_check2[7] = "��";
$list_check2[8] = "��";
$list_check2[9] = "";
$list_check2[10] = "��";
$list_check2[11] = "��";
$list_check2[12] = "��";
$list_check2[13] = "��";
$list_check2[14] = "��";
$list_check2[15] = "��";
$list_check2[16] = "��";
$list_check2[17] = "��";


//***********************************************

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

$date = date("�������Yǯm��d����H��i");

//�إå���ɽ��
Header_user($pdf,$left_margin,$top_margin,$title,$staff_name,"",$shop_name,$date,$page_count,$page_size);

//����ɽ��(FC)
for($i=0;$i<count($list);$i++)
{
	//ɽ��������ɽ��
	if($i==0){
		$pdf->SetFillColor(85,85,85);
		$pdf->SetTextColor(255,255,255); 
		$pdf->SetXY($left_margin,$top_margin+45);
		$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2],'1');
		$pdf->SetTextColor(0,0,0); 
	//FCɽ��
	}else if($i==1){
		$pdf->SetFillColor(239,176,240);
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin,$posY);
		$pdf->Cell($list[$i][0], 14, $list[$i][1], 'LRT', '2', $list[$i][2],'1');
	//�ᥤ���˥塼ɽ��
	}else if($i==2){
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell($list[$i][0], 14, $list[$i][1], 'LRT', '2', $list[$i][2],'1');
	//���֥�˥塼ɽ��
	}else if($i==3 || $i==13){
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(236,218,240);
		$pdf->Cell($list[$i][0], 14, $list[$i][1], 'LRT', '2', $list[$i][2],'1');
	//����̾ɽ��
	}else{
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(236,218,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->Cell($list[$i][0], 14, $list[$i][1], 'LR', '2', $list[$i][2]);
	}
}

//�����å�ɽ��(FC)
$pdf->SetXY($left_margin, $top_margin+101);
for($i=0;$i<count($list_check);$i++)
{
	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin+206, $posY);
	$pdf->Cell('20', 14, $list_check[$i], '', '0', 'C');
	$pdf->Cell('23', 14, $list_check2[$i], '', '2', 'C');
}

//������(FC)
//������
$pdf->Line($left_margin+45,$top_margin+101,$left_margin+250,$top_margin+101);
$pdf->Line($left_margin+45,$top_margin+241,$left_margin+250,$top_margin+241);
$pdf->Line($left_margin,$top_margin+353,$left_margin+250,$top_margin+353);



$pdf->Output();

?>
