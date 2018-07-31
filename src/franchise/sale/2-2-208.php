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
$title = "����������ɼ����";
$page_count = 1; 

//���λ���
$time = "�������2005ǯ04��01����2005ǯ04��11��";

//����̾������align
$list[0] = array("30","NO","C");
$list[1] = array("140","������̾","C");
$list[2] = array("50","��ɼ�ֹ�","C");
$list[3] = array("60","�����","C");
$list[4] = array("100","���ô��","C");
$list[5] = array("280","����̾","C");
$list[6] = array("50","�����ʬ","C");
$list[7] = array("70","����","C");
$list[8] = array("70","���ñ��","C");
$list[9] = array("70","�����","C");
$list[10] = array("190","����","C");

//������ס����סʾ�����/�ǹ��ס�
$list_sub[0] = array("140","�������","L");
$list_sub[1] = array("140","����","L");
$list_sub[2] = array("60","�����ǡ�","L");
$list_sub[3] = array("280","�ǹ��ס�","L");
//��ɼ�סʾ�����/�ǹ��ס�
$list_sub[4] = array("50","��ɼ��","L");
$list_sub[5] = array("100","�����ǡ�","L");
$list_sub[6] = array("50","�ǹ��ס�","L");

//align(�ǡ���)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "C";
$data_align[4] = "L";
$data_align[5] = "L";
$data_align[6] = "C";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "L";
$data_align[11] = "C";
$data_align[12] = "L";

//�ǡ�������SQL
$sql = "select person1,sale_num,sale_date,person2,goods,division,num1,num2,num3,note from t_decision;";

//�ڡ�������ɽ����
$page_max = 50;

//������
$tax = 0.05;

//***********************************************

//DB��³
$db_con = Db_Connect("amenity_test");
$result = Db_Query($db_con,$sql);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("�������Yǯm��d����H:i");

//�إå���ɽ��
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

//�ģ¤��ͤ�ɽ��
//�Կ������Υڡ���ɽ���������Υڡ���ɽ��������ɼ�ס�������ס���ס�����͡������ǡ��ǹ���ۡ������
$count = 0;
$page_next = $page_max;
$page_back = 0;
$data_sub = array();
$data_sub2 = array();
$data_total = array();
$person = "";
$slip = "";
$money_tax = 0;
$money = 0;
$money_tax2 = 0;
$money2 = 0;

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************��ɼ�׽���***********************************

	//�ͤ��Ѥ�ä���硢��ɼ��ɽ��
	if($slip != $data_list[1]){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//�ͤξ�άȽ��ե饰
			$space_flg2 = true;
			for($x=0;$x<10;$x++){
				//��ɼ�׹��ֹ�
				if($x==0){
					$pdf->SetFont(GOTHIC, '', 9);
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
					$pdf->SetFont(GOTHIC, 'B', 9);
				//������̾
				}else if($x==1){
					//���ڡ���������ΰ���ܤ�����ɼ�פξ�硢������̾ɽ��
					if($page_back == $count){
						$pdf->SetFont(GOTHIC, '', 9);
						$pdf->Cell($list[$x][0], 14, $customer, 'LR', '0','L','');
						$pdf->SetFont(GOTHIC, 'B', 9);
						//�������ɽ�����������ϡ��ǡ�������������ά
						$slip_flg = true;
					}else{
						$pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
						$slip_flg = false;
					}
				//��ɼ��̾
				}else if($x==2){
					$pdf->Cell($list_sub[4][0], 14, $list_sub[4][1], '1', '0',$list_sub[0][2],'1');
				//��ɼ����
				}else if($x==3){
					//��ɼ���ͤ����ͤ�­���Ƥ���
					$data_total[2] = $data_total[2] + $data_sub2[9];
					//�����Ƿ׻�
					$money_tax2 = $data_sub2[9] * $tax;
					//�ǹ���۷׻�
					$money2 = $data_sub2[9] * (1+$tax);
					//�����ѹ�
					$money_tax2 = number_format($money_tax2);
					$money2 = number_format($money2);
					$data_sub2[9] = number_format($data_sub2[9]);
					
					$pdf->Cell($list[$x][0], 14, $data_sub2[9], '1', '0','R','1');
				//������̾
				}else if($x==4){
					$pdf->Cell($list_sub[5][0], 14, $list_sub[5][1], '1', '0',$list_sub[5][2],'1');
				//��������
				}else if($x==5){
					$pdf->Cell($list[$x][0], 14, $money_tax2, '1', '0','R','1');
				//�ǹ���̾
				}else if($x==6){
					$pdf->Cell($list_sub[6][0], 14, $list_sub[6][1], '1', '0',$list_sub[6][2],'1');
				//�ǹ�����
				}else if($x==7){
					$pdf->Cell($list[$x][0], 14, $money2, '1', '0','R','1');
				//������ͤ�ɽ��
				}else if($x==9){
					$pdf->Cell($list[$x][0], 14, $data_sub2[2], '1', '0','R','1');
				}else{
					$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
				}
			}
			$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
			//��ɼ�ס������ǡ��ǹ��ס������
			$data_sub2 = array();
			$money_tax2 = 0;
			$money2 = 0;
			$count++;
		}
		$slip = $data_list[1];
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);

	//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************������׽���***********************************

	//�ͤ��Ѥ�ä���硢�������ɽ��
	if($person != $data_list[0]){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			$pdf->SetFillColor(180,180,180);
			//�ͤξ�άȽ��ե饰
			$space_flg = true;
			for($x=0;$x<10;$x++){
				//���׹��ֹ�
				if($x==0){
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
				//ô���Է�̾
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//ô���Է���
				}else if($x==2){
					//�����ͤ����ͤ�­���Ƥ���
					$data_total[2] = $data_total[2] + $data_sub[9];
					//�����Ƿ׻�
					$money_tax = $data_sub[9] * $tax;
					//�ǹ���۷׻�
					$money = $data_sub[9] * (1+$tax);
					//�����ѹ�
					$money_tax = number_format($money_tax);
					$money = number_format($money);
					$data_sub[9] = number_format($data_sub[9]);
					
					$pdf->Cell($list[$x][0], 14, $data_sub[9], '1', '0','R','1');
				//������̾
				}else if($x==3){
					$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
				//��������
				}else if($x==4){
					$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
				//�ǹ���̾
				}else if($x==5){
					$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
				//�ǹ�����
				}else if($x==6){
					$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
				//������ͤ�ɽ��
				}else if($x==9){
					$pdf->Cell($list[$x][0], 14, $data_sub[2], '1', '0','R','1');
				}else{
					$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
				}
			}
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//������ס������ǡ��ǹ��ס������
			$data_sub = array();
			$money_tax = 0;
			$money = 0;
			$count++;
		}
		$person = $data_list[0];
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

	//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 9);

//************************�ǡ���ɽ��***************************
	//���ֹ�
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<10;$x++){
		//ɽ����
		$contents = "";
		//ɽ��line
		$line = "";

		//������̾�ξ�άȽ��
		//��ɼ�פ��������ɽ�������Ƥ��ʤ������ġ�����ܤ����פθ�ξ��ϡ���ά���ʤ���
		if($x==1 && $slip_flg == false && ($count == 1 || $space_flg == true)){
			//������Ƚ��
			//�ڡ����κ���ɽ������
			$contents = $data_list[$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LR';
			}
			//��ɼ�פ�ɽ��������������̾������
			$customer = $data_list[$x-1];
			//������̾���ά����
			$space_flg = false;
		//��ɼ�פ��������ɽ�����ޤ��ϡ������������ɽ����������
		}else if($x==1){
			//�ڡ����κ���ɽ������
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
			$customer = $data_list[$x-1];
		//����ܤ���ɼ�פθ�ʳ����ͤξ�ά
		}else if($x==2 && ($count == 1 || $space_flg2 == true)){
			//������Ƚ��
			//�ڡ����κ���ɽ������
			$contents = $data_list[$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//��ά����
			$space_flg2 = false;
		//������ɼ�ֹ��ɽ�����Ƥ��롣
		}else if($x==2){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//����۷׻�
		}else if($x==9){
			//�ͤ���ɼ�פ�­���Ƥ���
			$data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
			//�ͤ�������פ�­���Ƥ���
			$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
			$data_list[$x-1] = number_format($data_list[$x-1]);

			$contents = $data_list[$x-1];
			$line = '1';
		}else{
			if(is_numeric($data_list[$x-1])){
				$data_list[$x-1] = number_format($data_list[$x-1]);
			}
			$contents = $data_list[$x-1];
			$line = '1';
		}
		$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
	}
	$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '2', $data_align[$x]);

}
//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(220,220,220);
	$count++;

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************�ǽ���ɼ�׽���***********************************
	
for($x=0;$x<10;$x++){
	//��ɼ�׹��ֹ�
	if($x==0){
		$pdf->SetFont(GOTHIC, '', 9);
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
		$pdf->SetFont(GOTHIC, 'B', 9);
	//������̾
	}else if($x==1){
		//���ڡ���������ΰ���ܤ�����ɼ�פξ�硢������̾ɽ��
		if($page_back == $count){
			$pdf->SetFont(GOTHIC, '', 9);
			$pdf->Cell($list[$x][0], 14, $customer, 'LR', '0','L','');
			$pdf->SetFont(GOTHIC, 'B', 9);
			//�������ɽ�����������ϡ��ǡ�������������ά
			$slip_flg = true;
		}else{
			$pdf->Cell($list[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
			$slip_flg = false;
		}
	//��ɼ��̾
	}else if($x==2){
		$pdf->Cell($list_sub[4][0], 14, $list_sub[4][1], '1', '0',$list_sub[0][2],'1');
	//��ɼ����
	}else if($x==3){
		//��ɼ���ͤ����ͤ�­���Ƥ���
		$data_total[2] = $data_total[2] + $data_sub2[9];
		//�����Ƿ׻�
		$money_tax2 = $data_sub2[9] * $tax;
		//�ǹ���۷׻�
		$money2 = $data_sub2[9] * (1+$tax);
		//�����ѹ�
		$money_tax2 = number_format($money_tax2);
		$money2 = number_format($money2);
		$data_sub2[9] = number_format($data_sub2[9]);
		
		$pdf->Cell($list[$x][0], 14, $data_sub2[9], '1', '0','R','1');
	//������̾
	}else if($x==4){
		$pdf->Cell($list_sub[5][0], 14, $list_sub[5][1], '1', '0',$list_sub[5][2],'1');
	//��������
	}else if($x==5){
		$pdf->Cell($list[$x][0], 14, $money_tax2, '1', '0','R','1');
	//�ǹ���̾
	}else if($x==6){
		$pdf->Cell($list_sub[6][0], 14, $list_sub[6][1], '1', '0',$list_sub[6][2],'1');
	//�ǹ�����
	}else if($x==7){
		$pdf->Cell($list[$x][0], 14, $money2, '1', '0','R','1');
	//������ͤ�ɽ��
	}else if($x==9){
		$pdf->Cell($list[$x][0], 14, $data_sub2[2], '1', '0','R','1');
	}else{
		$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
//��ɼ�ס������ǡ��ǹ��ס������
$data_sub2 = array();
$money_tax2 = 0;
$money2 = 0;

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//****************�ǽ�������׽���*******************************

for($x=0;$x<10;$x++){
	//���׹��ֹ�
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//ô���Է�̾
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//ô���Է���
	}else if($x==2){
		//�����ͤ����ͤ�­���Ƥ���
		$data_total[2] = $data_total[2] + $data_sub[9];
		//�����Ƿ׻�
		$money_tax = $data_sub[9] * $tax;
		//�ǹ���۷׻�
		$money = $data_sub[9] * (1+$tax);
		//�����ѹ�
		$money_tax = number_format($money_tax);
		$money = number_format($money);
		$data_sub[9] = number_format($data_sub[9]);
		
		$pdf->Cell($list[$x][0], 14, $data_sub[9], '1', '0','R','1');
	//������̾
	}else if($x==3){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	//��������
	}else if($x==4){
		$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
	//�ǹ���̾
	}else if($x==5){
		$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
	//�ǹ�����
	}else if($x==6){
		$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
	//������ͤ�ɽ��
	}else if($x==9){
		$pdf->Cell($list[$x][0], 14, $data_sub[2], '1', '0','R','1');
	}else{
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//������ס������ǡ��ǹ��ס������
$data_sub = array();
$money_tax = 0;
$money = 0;

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ���ɼ�פξ�硢������̾ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//*************************��׽���*******************************

for($x=0;$x<10;$x++){
	//��׹��ֹ�
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//����̾
	}else if($x==1){
		$pdf->Cell($list_sub[1][0], 14, $list_sub[1][1], '1', '0',$list_sub[1][2],'1');
	//ô���Է���
	}else if($x==2){
		//�����Ƿ׻�
		$money_tax = $data_total[2] * $tax;
		//�ǹ���۷׻�
		$money = $data_total[2] * (1+$tax);
		//�����ѹ�
		$money_tax = number_format($money_tax);
		$money = number_format($money);
		$data_total[2] = number_format($data_total[2]);

		$pdf->Cell($list[$x][0], 14, $data_total[2], '1', '0','R','1');
	//������̾
	}else if($x==3){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	//��������
	}else if($x==4){
		$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
	//�ǹ���̾
	}else if($x==5){
		$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
	//�ǹ�����
	}else if($x==6){
		$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
	}else{
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');
//****************************************************************

$pdf->Output();

?>
