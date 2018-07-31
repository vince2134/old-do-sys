<?php
require('../../fpdf/mbfpdf.php');
//�Ķ�����ե�����
require_once("ENV_local.php");
//*******************���ϲս�*********************

//;��
$left_margin = 40;
$top_margin = 40;

//�ڡ���������
//A3
$pdf=new MBFPDF('L','pt','A3');

//�����ȥ�
$title = "����ץ����ɽ";
$page_count = 1; 

//����
$time = "2005ǯ04�����";

//***********************************************
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("�������Yǯm��d����H:i");

//A3�β����ϡ�1110
$pdf->SetXY($left_margin,$top_margin);
$pdf->Cell(1110, 14, $title, '0', '1', 'C');
$pdf->SetXY($left_margin,$top_margin);
$pdf->Cell(1110, 14, $page_count."�ڡ���", '0', '1', 'R');
$pdf->SetX($left_margin);
$pdf->Cell(1110, 14, $date, '0', '1', 'R');
$pdf->SetXY($left_margin+555,$top_margin+28);
$pdf->Cell(555, 14, $time, '0', '2', 'R');
//*******************���ϲս�*********************

//����̾������align
$list[0] = array("50","NO","C");
$list[1] = array("260","����̾","C");
$list[2] = array("150","ô����","C");
$list[3] = array("150","����","C");
$list[4] = array("100","�����","C");
$list[5] = array("100","������","C");
$list[6] = array("100","ñ��","C");
$list[7] = array("100","������","C");
$list[8] = array("100","�������","C");

//���ס����̾
$list_sub[0] = array("260","���ʷ�","L");
$list_sub[1] = array("260","���","L");

//align(�ǡ���)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "L";
$data_align[4] = "R";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";

//�ǡ�������SQL
$sql = "select * from t_test;";

//�ڡ�������ɽ����
$page_max = 50;

//***********************************************

//DB��³
$db_con = Db_Connect();
$result = Db_Query($db_con,$sql);

//����ɽ��
$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
for($i=0;$i<count($list)-1;$i++)
{
	$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
}
$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

//�ģ¤��ͤ�ɽ��
//�Կ����ڡ����������Υڡ���ɽ���������ס���ס�����͡������
$count = 0;
$page_count++;
$page_next = $page_max;
$data_sub = array();
$data_total = array();
$goods = "";

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		//A3�β����ϡ�1110
		$pdf->SetXY($left_margin,$top_margin);
		$pdf->Cell(1110, 14, $title, '0', '1', 'C');
		$pdf->SetXY($left_margin,$top_margin);
		$pdf->Cell(1110, 14, $page_count."�ڡ���", '0', '1', 'R');
		$pdf->SetX($left_margin);
		$pdf->Cell(1110, 14, $date, '0', '1', 'R');
		$pdf->SetXY($left_margin+555,$top_margin+28);
		$pdf->Cell(555, 14, $time, '0', '2', 'R');

		//����ɽ��
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		for($i=0;$i<count($list)-1;$i++)
		{
			$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
		}
		$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$page_count++;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************���׽���***********************************

	//�ͤ��Ѥ�ä���硢����ɽ��
	if($goods != $data_list[1]){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			$pdf->SetFillColor(213,213,213);
			//�ͤξ�άȽ��ե饰
			$space_flg = true;
			for($x=0;$x<8;$x++){
				//���׹��ֹ�
				if($x==0){
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
				//����̾
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				}else{
				//������
					//����Ƚ��
					if(is_numeric($data_sub[$x])){
						//�����ͤ����ͤ�­���Ƥ���
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
			//���׽����
			$data_sub = array();
			$count++;
		}
		$goods = $data_list[1];
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

//************************�ǡ���ɽ��***************************

	for($x=0;$x<8;$x++){
		//���ֹ�
		if($x==0){
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
			//����ܤ����פθ�ʳ����ͤξ�ά
		}else if($x==1 && $count == 1 || $space_flg == true){
			//������Ƚ��
			//�ڡ����κ���ɽ������
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
				//�ͤ򾮷פ�­���Ƥ���
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

//******************�ǽ����׽���***********************************
	
for($x=0;$x<8;$x++){
	//���׹��ֹ�
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//����̾
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	}else{
	//������
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
//���׽����
$data_sub = array();

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//*************************��׽���*******************************

for($x=0;$x<8;$x++){
	//��׹��ֹ�
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//���̾
	}else if($x==1){
		$pdf->Cell($list_sub[1][0], 14, $list_sub[1][1], '1', '0',$list_sub[1][2],'1');
	}else{
	//�����
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
