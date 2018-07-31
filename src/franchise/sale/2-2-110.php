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
$title = "�������������ǧɽ";
$page_count = 1; 

//����̾������align
$list[0] = array("30","NO","C");
$list[1] = array("120","������̾","C");
$list[2] = array("50","��ϩ","C");
$list[3] = array("50","��ɼ�ֹ�","C");
$list[4] = array("165","������̾","C");
$list[5] = array("115","�����ʬ","C");
$list[6] = array("130","����̾","C");
$list[7] = array("50","�����ʬ","C");
$list[8] = array("50","����","C");
$list[9] = array("80","ñ��","C");
$list[10] = array("80","���","C");
$list[11] = array("80","������","C");
$list[12] = array("110","����","C");

//���̾
$list_sub[0] = array("50","��ɼ��","L");
$list_sub[1] = array("120","���","L");
$list_sub[2] = array("115","�����ǡ�","L");
$list_sub[3] = array("50","�ǹ��ס�","L");

//align(�ǡ���)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "L";
$data_align[4] = "L";
$data_align[5] = "C";
$data_align[6] = "L";
$data_align[7] = "C";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "R";
$data_align[11] = "R";
$data_align[12] = "L";

//ô���Լ���SQL
$sql_person = "SELECT DISTINCT client FROM t_deli;";

//�ڡ�������ɽ����
$page_max = 50;

//������
$tax = 0.05;

//***********************************************

//DB��³
$db_con = Db_Connect("amenity_test");

$result_person = Db_Query($db_con,$sql_person);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//ô���Ԥ�¸�ߤ���ֽ���
while($person_list = pg_fetch_array($result_person)){

	//�ǡ�������SQL(������̾,��ϩ,��ɼ�ֹ�,������,�����ʬ,����̾,�����ʬ,����,ñ��,���,������,����)
	$sql = "SELECT course_name,course,sale_num,person,";
	$sql .= "business,goods,sale,num1,num2,num3,num4,note ";
	$sql .= "FROM t_deli ";
	$sql .= "WHERE client = '".$person_list[0]."';";

	//ô���Լ���
	$person ="ô���ԡ�".$person_list[0];

	//���ߤ����ռ���SQL
	$sql_stock = "SELECT DISTINCT stock_date FROM t_deli;";

	//���ռ���
	$result = Db_Query($db_con,$sql_stock);
	$time = pg_fetch_result($result,0,0);

	$pdf->SetFont(GOTHIC, '', 9);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//�ģ¤��ͤ�ɽ��
	//�Կ����ڡ����������Υڡ���ɽ���������ס���ס������ǡ��ǹ���ۡ����������͡������
	$count = 0;	
	$page_count = 1;
	$page_next = $page_max;
	$data_sub = array();
	$data_total = array();
	$money_tax = 0;
	$money = 0;
	$row_count = 0;
	$total_count = 0;
	//������
	$cose = "";
	//��ϩ
	$route = "";
	//��ɼ�ֹ�
	$number = "";

	$result = Db_Query($db_con,$sql);

	while($data_list = pg_fetch_array($result)){
		$count++;

		/**********************�إå�������**************************/
		//����ܤξ�硢�إå�����
		if($count == 1){
			$date = date("�������Yǯm��d����H��i");
			//���ռ����������ѹ�
			$year = substr($time,0,4);
			$month = substr($time,5,2);
			$day = substr($time,8,2);
			$time = "��������".$year."ǯ".$month."��".$day."��";

			//����
			$pdf->SetXY($left_margin+830,$top_margin);
			$pdf->Cell(40,10,"��ǧ��",'LTR','2','C');
			$pdf->Cell(40,25,"",'LRB');
			$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

			//�إå���ɽ��
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);
		}

		//*******************���ڡ�������*****************************

		//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
		if($page_next+1 == $count){
			$pdf->AddPage();
			$page_count++;

			//����
			$pdf->SetXY($left_margin+830,$top_margin);
			$pdf->Cell(40,10,"��ǧ��",'LTR','2','C');
			$pdf->Cell(40,25,"",'LRB');
			$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

			//�إå���ɽ��
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//���κ���ɽ����
			$page_next = $page_max * $page_count;
			//��άȽ��ե饰
			$space_flg = true;		//��ɼ
			$space_flg2 = true;		//��ϩ
			$space_flg3 = true;		//������
			$space_flg4 = true;		//������
			$space_flg5 = true;		//�����ʬ
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);

		//******************��ϩ��άȽ�����***********************************

		//�ͤ��Ѥ�ä���硢��ϩɽ��
		if($route != $data_list[1]){
			//����ܤϡ��ͤ򥻥åȤ������
			if($count != 1){
				//�ͤξ�άȽ��ե饰
				$space_flg2 = true;
			}
			$route = $data_list[1];
		}

		//******************��������άȽ�����***********************************

		//�ͤ��Ѥ�ä���硢������ɽ��
		if($cose != $data_list[0]){
			//����ܤϡ��ͤ򥻥åȤ������
			if($count != 1){
				//�ͤξ�άȽ��ե饰
				$space_flg3 = true;
			}
			$cose = $data_list[0];
		}

		//******************���׽���***********************************

		//�ͤ��Ѥ�ä���硢����ɽ��
		if($number != $data_list[2]){
			//����ܤϡ��ͤ򥻥åȤ������
			if($count != 1){
				$pdf->SetFillColor(213,213,213);
				//�ͤξ�άȽ��ե饰
				$space_flg = true;
				$space_flg4 = true;
				$space_flg5 = true;

				for($x=0;$x<12;$x++){
					$pdf->SetFont(GOTHIC, 'B', 9);
					//���׹��ֹ�
					if($x==0){
						$pdf->SetFont(GOTHIC, '', 9);
						$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
					//��ɼ�פΰ١�ɽ�����ʤ�
					}else if($x==1 || $x==2){
						$pdf->Cell($list[$x][0], 14, "", 'LR', '0',$data_align[$x]);
					//��ɼ��̾
					}else if($x==3){
						$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
					//��ɼ����
					}else if($x==4){
						//��ɼ���ͤ����ͤ�­���Ƥ���
						$data_total[4] = $data_total[4] + $data_sub[10];
						//�����Ƿ׻�
						$money_tax = $data_sub[10] * $tax;
						//�ǹ���۷׻�
						$money = $data_sub[10] * (1+$tax);
						//�����ѹ�
						$money_tax = number_format($money_tax);
						$money = number_format($money);
						$data_sub[10] = number_format($data_sub[10]);
						
						$pdf->Cell($list[$x][0], 14, $data_sub[10], '1', '0','R','1');
					//������̾
					}else if($x==5){
						$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
					//��������
					}else if($x==6){
						$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
					//�ǹ���̾
					}else if($x==7){
						$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
					//�ǹ�����
					}else if($x==8){
						$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
					//�����ʬ���
					}else if($x==10){
						//������׻�
						$total_count = $total_count + $row_count;
						$pdf->Cell($list[$x][0], 14, $row_count."��", '1', '0','R','1');
					//������ξ���ɽ��
					}else if($x==11){
						$pdf->Cell($list[$x][0], 14, $data_sub[4], '1', '0','R','1');
					}else{
						$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
					}
				}
				$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
				//���ס������
				$data_sub = array();
				$money_tax = 0;
				$money = 0;
				$row_count = 0;
				$count++;
			}
			$number = $data_list[2];
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

			//����
			$pdf->SetXY($left_margin+830,$top_margin);
			$pdf->Cell(40,10,"��ǧ��",'LTR','2','C');
			$pdf->Cell(40,25,"",'LRB');
			$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

			//�إå���ɽ��
			Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

			//���κ���ɽ����
			$page_next = $page_max * $page_count;
			//��άȽ��ե饰
			$space_flg = true;		//��ɼ
			$space_flg2 = true;		//��ϩ
			$space_flg3 = true;		//������
			$space_flg4 = true;		//������
			$space_flg5 = true;		//�����ʬ
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, '', 9);

		//************************�ǡ���ɽ��***************************
		//���ֹ�
		$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
		for($x=1;$x<12;$x++){
			//ɽ����
			$contents = "";
			//ɽ��line		
			$line = "";

			//����ܤ����פθ�ξ��ϡ�������̾��ά���ʤ���
			if($x==1 && $count == 1 || $space_flg3 == true){
				//������Ƚ��
				//�ڡ����κ���ɽ������
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//����̾���ά����
				$space_flg3 = false;
			//���˥�����̾��ɽ����������
			}else if($x==1){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//��ϩ���Ѥ�ä���
			}else if($x==2 && $count == 1 || $space_flg2 == true){
				//������Ƚ��
				//�ڡ����κ���ɽ������
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//��ϩ���ά����
				$space_flg2 = false;
			//����ɽ����������
			}else if($x==2){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//��ɼ�ֹ椬�Ѥ�ä���
			}else if($x==3 && $count == 1 || $space_flg == true){
				//������Ƚ��
				//�ڡ����κ���ɽ������
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//��ɼ�ֹ���ά����
				$space_flg = false;
			//����ɽ����������
			}else if($x==3){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//�����褬�Ѥ�ä���
			}else if($x==4 && $count == 1 || $space_flg4 == true){
				//������Ƚ��
				//�ڡ����κ���ɽ������
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//��������ά����
				$space_flg4 = false;
			//����ɽ����������
			}else if($x==4){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//�����ʬ���Ѥ�ä���
			}else if($x==5 && $count == 1 || $space_flg5 == true){
				//������Ƚ��
				//�ڡ����κ���ɽ������
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//�����ʬ���ά����
				$space_flg5 = false;
			//����ɽ����������
			}else if($x==5){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			//���
			}else if($x==10){
				//�ͤ򾮷פ�­���Ƥ���
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
		//����
		$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '2', $data_align[$x]);
		//�����­��
		$row_count++;
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
		$page_count++;

		//����
		$pdf->SetXY($left_margin+830,$top_margin);
		$pdf->Cell(40,10,"��ǧ��",'LTR','2','C');
		$pdf->Cell(40,25,"",'LRB');
		$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		//��άȽ��ե饰
		$space_flg = true;		//��ɼ
		$space_flg2 = true;		//��ϩ
		$space_flg3 = true;		//������
		$space_flg4 = true;		//������
		$space_flg5 = true;		//�����ʬ
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************�ǽ����׽���***********************************
		
	for($x=0;$x<12;$x++){
		$pdf->SetFont(GOTHIC, 'B', 9);
		//���׹��ֹ�
		if($x==0){
			$pdf->SetFont(GOTHIC, '', 9);
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
		//��ɼ�פΰ١�ɽ�����ʤ�
		}else if($x==1 || $x==2){
			$pdf->Cell($list[$x][0], 14, "", 'LR', '0',$data_align[$x]);
		//��ɼ��̾
		}else if($x==3){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		//��ɼ����
		}else if($x==4){
			//��ɼ���ͤ����ͤ�­���Ƥ���
			$data_total[4] = $data_total[4] + $data_sub[10];
			//�����Ƿ׻�
			$money_tax = $data_sub[10] * $tax;
			//�ǹ���۷׻�
			$money = $data_sub[10] * (1+$tax);
			//�����ѹ�
			$money_tax = number_format($money_tax);
			$money = number_format($money);
			$data_sub[10] = number_format($data_sub[10]);
			
			$pdf->Cell($list[$x][0], 14, $data_sub[10], '1', '0','R','1');
		//������̾
		}else if($x==5){
			$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
		//��������
		}else if($x==6){
			$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
		//�ǹ���̾
		}else if($x==7){
			$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
		//�ǹ�����
		}else if($x==8){
			$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
		//�����ʬ���
		}else if($x==10){
			//������׻�
			$total_count = $total_count + $row_count;
			$pdf->Cell($list[$x][0], 14, $row_count."��", '1', '0','R','1');
		//������ξ���ɽ��
		}else if($x==11){
			$pdf->Cell($list[$x][0], 14, $data_sub[4], '1', '0','R','1');
		}else{
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
	//���ס������
	$data_sub = array();
	$money_tax = 0;
	$money = 0;
	$row_count = 0;

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

		//����
		$pdf->SetXY($left_margin+830,$top_margin);
		$pdf->Cell(40,10,"��ǧ��",'LTR','2','C');
		$pdf->Cell(40,25,"",'LRB');
		$pdf->Line($left_margin+830,$top_margin+10,$left_margin+870,$top_margin+10);

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$person,$time,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		//��άȽ��ե饰
		$space_flg = true;		//��ɼ
		$space_flg2 = true;		//��ϩ
		$space_flg3 = true;		//������
		$space_flg4 = true;		//������
		$space_flg5 = true;		//�����ʬ
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//*************************��׽���*******************************

	for($x=0;$x<12;$x++){
		$pdf->SetFont(GOTHIC, 'B', 9);
		//���׹��ֹ�
		if($x==0){
			$pdf->SetFont(GOTHIC, '', 9);
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
		//���̾
		}else if($x==1){
			$pdf->Cell($list_sub[1][0], 14, $list_sub[1][1], '1', '0',$list_sub[1][2],'1');
		//��ɼ����
		}else if($x==4){
			//�����Ƿ׻�
			$money_tax = $data_total[4] * $tax;
			//�ǹ���۷׻�
			$money = $data_total[4] * (1+$tax);
			//�����ѹ�
			$money_tax = number_format($money_tax);
			$money = number_format($money);
			$data_total[4] = number_format($data_total[4]);
			
			$pdf->Cell($list[$x][0], 14, $data_total[4], '1', '0','R','1');
		//������̾
		}else if($x==5){
			$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
		//��������
		}else if($x==6){
			$pdf->Cell($list[$x][0], 14, $money_tax, '1', '0','R','1');
		//�ǹ���̾
		}else if($x==7){
			$pdf->Cell($list_sub[3][0], 14, $list_sub[3][1], '1', '0',$list_sub[3][2],'1');
		//�ǹ�����
		}else if($x==8){
			$pdf->Cell($list[$x][0], 14, $money, '1', '0','R','1');
		//�����ʬ���
		}else if($x==10){
			//�����
			$pdf->Cell($list[$x][0], 14, $total_count."��", '1', '0','R','1');
		//������ξ���ɽ��
		}else{
			$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');

	//****************************************************************
}

$pdf->Output();

?>

