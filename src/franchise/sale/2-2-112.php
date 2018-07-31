<?php
//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

//*******************���ϲս�*********************

//;��
$left_margin = 40;
$top_margin = 40;

//�إå����Υե���ȥ�����
$font_size = 8;
//�ڡ���������
$page_size = 515;

//A4
$pdf=new MBFPDF('P','pt','A4');

//�����ȥ�
$title = "����ͽ��вٰ���ɽ";
$page_count = "0"; 

//���λ���
$werehouse ="��������2005ǯ04��01����2005ǯ04��31��";

//����̾������align 515
$list[0] = array("30","NO","C");
$list[1] = array("50","���ʥ�����","C");
$list[2] = array("280","����̾","C");
$list[3] = array("55","����","C");
$list[4] = array("55","������","C");
$list[5] = array("45","��ǧ��","C");

//�Ͷ�ʬ�ס����̾
$list_sub[0] = array("50","���","L");
$list_sub[1] = array("50","����","L");

//align(�ǡ���)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "R";
$data_align[4] = "L";
$data_align[5] = "R";

//ô���Լ���SQL
$sql_person = "SELECT DISTINCT person FROM t_article;";

//�ڡ�������ɽ����
$page_max = 50;

//***********************************************

//DB��³
$db_con = Db_Connect("amenity_test");

// ���¥����å�
//$auth       = Auth_Check($db_con);

$result_person = Db_Query($db_con,$sql_person);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//ô���Ԥ�¸�ߤ���ֽ���
while($person_list = pg_fetch_array($result_person)){

	//�ǡ�������SQL(���ʥ�����,����̾,����)
	$sql = "SELECT goods_num,goods,num1 FROM t_article ";
	$sql .= "WHERE person = '".$person_list[0]."';";

	$result = Db_Query($db_con,$sql);

	//ô���Լ���
	$person ="ô���ԡ�".$person_list[0];

	$pdf->SetFont(GOTHIC, '', 8);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//�ģ¤��ͤ�ɽ��
	//�Կ����ڡ����������Υڡ���ɽ���������ס���ס�����͡������
	$count = 0;
	$page_count++;
	$page_next = $page_max;
	$data_sub = array();
	$data_total = array();

	//ô���Ԥ��Ȥ˽���
	while($data_list = pg_fetch_array($result)){

		$count++;
		/**********************�إå�������**************************/
		//����ܤξ�硢�إå�����
		if($count == 1){

			$pdf->SetXY($left_margin+90,$top_margin);
			$pdf->Cell(40,10,"��ǧ��",'LTBR','2','C');
			$pdf->Cell(40,28,"",'LRB');

			$date = date("�������Yǯm��d����H��i");
			//�إå���ɽ��
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);
		}

		//*******************���ڡ�������*****************************

			//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
			if($page_next+1 == $count){
				$pdf->AddPage();
				$pdf->SetXY($left_margin+90,$top_margin);
				$pdf->Cell(40,10,"��ǧ��",'LTBR','2','C');
				$pdf->Cell(40,28,"",'LRB');

				//�إå���ɽ��
				Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);

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
		for($x=1;$x<3;$x++){
			//ɽ����
			$contents = "";
			//ɽ��line		
			$line = "";

			//���ʥ����ɡ�����̾
			$contents = $data_list[$x-1];
			$line = '1';
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
		//����
		//�ͤ򾮷פ�­���Ƥ���
		$data_total[$x] = $data_total[$x] + $data_list[$x-1];
		$data_list[$x-1] = number_format($data_list[$x-1]);
		$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '0', $data_align[$x]);
		$x++;
		//������
		$pdf->Cell($list[$x][0], 14, '', '1', '0', $data_align[$x]);
		$x++;
		//��ǧ��
		$pdf->Cell($list[$x][0], 14, '', '1', '2', $data_align[$x]);
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
		$pdf->SetXY($left_margin+90,$top_margin);
		$pdf->Cell(40,10,"��ǧ��",'LTBR','2','C');
		$pdf->Cell(40,28,"",'LRB');

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$page_count++;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//*************************��׽���*******************************

	for($x=0;$x<3;$x++){
		//��׹��ֹ�
		if($x==0){
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
		//���̾
		}else if($x==1){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		//���ʥ����ɡ�����̾
		}else{
			$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
		}
	}
	//����
	$data_total[$x] = number_format($data_total[$x]);
	$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	$x++;
	//������
	$pdf->Cell($list[$x][0], 14, '', '1', '0', $data_align[$x]);
	$x++;
	//��ǧ��
	$pdf->Cell($list[$x][0], 14, '', '1', '2', $data_align[$x]);
}

//************************��ô���Է�**********************************

//���ҷ׼���SQL
$sql = "SELECT goods_num,goods,sum(num1) ";
$sql .= "FROM t_article GROUP BY goods_num,goods ";
$sql .= "ORDER BY goods_num ASC;";

$result = Db_Query($db_con,$sql);

//ô���Լ���
$person ="ô���ԡ���ô����";

$pdf->SetFont(GOTHIC, '', 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//�ģ¤��ͤ�ɽ��
//�Կ����ڡ����������Υڡ���ɽ���������ס���ס�����͡������
$count = 0;
$page_count++;
$page_next = $page_max;
$data_sub = array();
$data_total = array();

//���ʥ����ɡ�����̾���Ȥ˽���
while($data_list = pg_fetch_array($result)){

	$count++;
	/**********************�إå�������**************************/
	//����ܤξ�硢�إå�����
	if($count == 1){

		$pdf->SetXY($left_margin+90,$top_margin);
		$pdf->Cell(40,10,"��ǧ��",'LTBR','2','C');
		$pdf->Cell(40,28,"",'LRB');

		$date = date("�������Yǯm��d����H��i");
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);
	}

	//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$pdf->SetXY($left_margin+90,$top_margin);
		$pdf->Cell(40,10,"��ǧ��",'LTBR','2','C');
		$pdf->Cell(40,28,"",'LRB');

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$page_count++;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

	//************************�ǡ���ɽ��***************************

	//��ɽ��
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);

	for($x=1;$x<3;$x++){
		$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '0', $data_align[$x]);
	}
	//����
	//�ͤ򾮷פ�­���Ƥ���
	$data_total[$x] = $data_total[$x] + $data_list[$x-1];
	$data_list[$x-1] = number_format($data_list[$x-1]);
	$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '0', $data_align[$x]);
	$x++;
	//������
	$pdf->Cell($list[$x][0], 14, '', '1', '0', $data_align[$x]);
	$x++;
	//��ǧ��
	$pdf->Cell($list[$x][0], 14, '', '1', '2', $data_align[$x]);
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
	$pdf->SetXY($left_margin+90,$top_margin);
	$pdf->Cell(40,10,"��ǧ��",'LTBR','2','C');
	$pdf->Cell(40,28,"",'LRB');

	//�إå���ɽ��
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$werehouse,$page_count,$list,$font_size,$page_size);

	//���κ���ɽ����
	$page_next = $page_max * $page_count;
	$page_count++;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//*************************��׽���*******************************

for($x=0;$x<3;$x++){
	//��׹��ֹ�
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//���̾
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//���ʥ����ɡ�����̾
	}else{
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
//����
$data_total[$x] = number_format($data_total[$x]);
$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
$x++;
//������
$pdf->Cell($list[$x][0], 14, '', '1', '0', $data_align[$x]);
$x++;
//��ǧ��
$pdf->Cell($list[$x][0], 14, '', '1', '2', $data_align[$x]);

$pdf->Output();

?>
