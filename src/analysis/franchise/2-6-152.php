<?php
//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

//�إå���ɽ���ؿ�
//������PDF���֥������ȡ��ޡ����󡦥����ȥ롦����/�����Υإå����ܡ��ڡ�������
function Header_route($pdf,$left_margin,$top_margin,$title,$right_top,$right_bottom,$page_count){

	$pdf->SetFont(GOTHIC, '', 8);
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell(1110, 14, $title, '0', '1', 'C');
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell(1110, 14, $page_count."�ڡ���", '0', '1', 'R');
	$pdf->SetX($left_margin);
	$pdf->Cell(1110, 14, $right_top, '0', '1', 'R');
	$pdf->SetX($left_margin);
	$pdf->Cell(1110, 14, $right_bottom."������", '0', '2', 'R');

}


//*******************���ϲս�*********************

//;��
$left_margin = 40;
$top_margin = 40;

//�ڡ���������
//A3
$pdf=new MBFPDF('L','pt','A3');

//�����ȥ�
$title = "ô�����̥롼��ͽ��ɽ";
$page_count = "1"; 

//����̾������align
$list[0] = array("50","2005ǯ11��","C");
$list[1] = array("345","","C");
$list[2] = array("85","������̾","C");
$list[3] = array("70","������","C");
$list[4] = array("70","ͽ����","C");
$list[5] = array("70","������","C");
$list[6] = array("50","����","C");
$list[7] = array("20","���","C");
$list[8] = array("50","����","C");
$list[9] = array("20","���","C");
$list[10] = array("50","����","C");

//���̾
$list_sub[0] = array("50","���","L");

//align����(�ǡ���)
$data_align[0] = array("50","R");
$data_align[1] = array("85","L");
$data_align[2] = array("70","L");
$data_align[3] = array("20","R");
$data_align[4] = array("50","R");
$data_align[5] = array("20","R");
$data_align[6] = array("50","R");
$data_align[7] = array("50","R");

//���ߤ����ռ���SQL
$sql_stock = "SELECT DISTINCT stock_date FROM t_person;";

//ô���Լ���
$sql_person = "SELECT DISTINCT person FROM t_person;";

//DB��³
$db_con = Db_Connect("amenity_test");

//���ռ���
$result = Db_Query($db_con,$sql_stock);
$time = pg_fetch_result($result,0,0);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

$date = date("�������Yǯm��d����H��i");
//���ռ����������ѹ�
$year = substr($time,0,4);
$month = substr($time,5,2);
$time = $year."ǯ".$month."��";

//****************���շ׻�����************************

$wstr = array('��', '��', '��', '��', '��', '��', '��');
//ǯ�����
$now = mktime(0, 0, 0, $month, 1, $year);
//�������
$dnum = date("t", $now);
//�������ʬ
for ($i = 1; $i <= $dnum; $i++) {
	$x = $i - 1;
    $t = mktime(0, 0, 0, $month, $i, $year);
    $w = date("w", $t);

	//�����������
    $day_count[$x] = $i."��"."(".$wstr[$w].")";
	//����Ƚ�����ѿ�
	$holiday[$x] = $wstr[$w];
}

//****************************************************

//�إå���ɽ��
Header_route($pdf,$left_margin,$top_margin,$title,$date,$time,$page_count);

//ô���Լ���
$result_person = Db_Query($db_con,$sql_person);

//ô���ԿͿ������ס���ס������
$person_count = 0;
$data_sub = array();
$data_total = array();

//ô���Ԥ�¸�ߤ���ֽ���
while($person_list = pg_fetch_array($result_person)){
	
	//*******************���ڡ�������*****************************

	//ô���Ԥ��ڡ����ˣ���ɽ�������顢���ڡ�������
	if($person_count == 3){
		
		$pdf->AddPage();
		$page_count++;

		//�إå���ɽ��
		Header_route($pdf,$left_margin,$top_margin,$title,$date,$time,$page_count);

		//ô���ԿͿ�������
		$person_count = 0;
	}

	//*************************************************************


	/**********************���ܽ���**************************/
	
	//����ɽ������
	switch($person_count){
		//�����
	    case 0:
				$posY = $pdf->GetY();
				$pdf->SetXY($left_margin, $posY);
				$X = $left_margin+205;
				$Y = $top_margin+72;
				//����ܰʹߤϡ����դ�̵��
				$num = 0;
	      		break;
		//�����
	    case 1:
				$pdf->SetXY($left_margin+407.5,$top_margin+42);
				$X = $left_margin+562.5;
				$Y = $top_margin+72;
				$num = 1;
	      		break;
		//������
		case 2:
				$pdf->SetXY($left_margin+765,$top_margin+42);
				$X = $left_margin+920;
				$Y = $top_margin+72;
				$num = 1;
	      		break;
	    default:
  	}

	//����ɽ��
	for($i=$num;$i<count($list);$i++){
		if($i == 0){
			$pdf->Cell($list[$i][0], 45, $time, '1', '0', $list[$i][2]);
		}
		if($i == 1){
			$pdf->Cell($list[$i][0], 15, $person_list[0], '1', '2', $list[$i][2]);
		}
		if($i == 2 || $i == 3 || $i == 6){
			$pdf->Cell($list[$i][0], 30, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 4 || $i == 5){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 7){
			$pdf->SetXY($X,$Y);
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 8 || $i == 9 || $i == 10){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}	
	}

	//*************************************************************	

	//�ǡ�������SQL(No,ô����,������̾,������,����,���,����,���,����)
	$sql = "SELECT stock_date,course,talk,num1,num2,num3,num4,num5 FROM t_person WHERE person = '".$person_list[0]."';";
	$result = Db_Query($db_con,$sql);
	
	//************************�ǡ���ɽ��***************************

	//������ź�����ֹ�
	$day_num = 0;
	//��¸�ߥե饰
	$day_flg = false;

	//����ɽ������
	switch($person_count){
	    case 0:
				$pdf->SetXY($left_margin,$top_margin+87);
				$X2 = $left_margin;
				//����ܰʹߤϡ����եǡ�����ɽ�����ʤ�
				$num2 = 0;
	      		break;
	    case 1:
				$pdf->SetXY($left_margin+407.5,$top_margin+87);
				$X2 = $left_margin+407.5;
				$num2 = 1;
	      		break;
		case 2:
				$pdf->SetXY($left_margin+765,$top_margin+87);
				$X2 = $left_margin+765;
				$num2 = 1;
	      		break;
	    default:
  	}

	//ô���Խ���
	for($d=1;$d<=count($day_count);$d++){
		//�ͤ�¸�ߤ���������ɤ߹���
		if($day_flg == false){
			$data_list = pg_fetch_array($result);
		}
		$posY = $pdf->GetY();
		$pdf->SetXY($X2, $posY);

		//�����������ѹ�
		if($holiday[$day_num] == "��"){
			$pdf->SetFillColor(255,224,224);
		}else if($holiday[$day_num] == "��"){
			$pdf->SetFillColor(204,234,255);
		}else{
			$pdf->SetFillColor(255,255,255);
		}

		//��������ѿ�
		if($d <= 9){
			$day_check = $year."-".$month."-0".$d;
		}else{
			$day_check = $year."-".$month."-".$d;
		}
		//ͽ�꤬¸�ߤ��뤫
		if($data_list[0] != $day_check){
			//����Υ���
			$pdf->Cell($data_align[0][0], 14, $day_count[$day_num], '1', '0', $data_align[0][1],'1');
			for($j=1;$j<7;$j++){
				$pdf->Cell($data_align[$j][0], 14, '', '1', '0', $data_align[$j][1],'1');
			}
			$pdf->Cell($data_align[$j][0], 14, '', '1', '2', $data_align[$j][1],'1');
			//���ιԤˡ����ɤ߹�����Ԥ����
			$day_flg = true;
		}else{
			for($j=$num2;$j<7;$j++){
				if($j==0){
					$pdf->Cell($data_align[$j][0], 14, $day_count[$day_num], '1', '0', $data_align[$j][1],'1');				}else{
					//����Ƚ��
					if(is_numeric($data_list[$j])){
						//�����ͤ�­���Ƥ���
						$data_sub[$j] = $data_sub[$j] + $data_list[$j];
						$data_list[$j] = number_format($data_list[$j]);
					}
					$pdf->Cell($data_align[$j][0], 14, $data_list[$j], '1', '0', $data_align[$j][1],'1');
				}
			}
			$data_sub[$j] = $data_sub[$j] + $data_list[$j];
			$data_list[$j] = number_format($data_list[$j]);
			$pdf->Cell($data_align[$j][0], 14, $data_list[$j], '1', '2', $data_align[$j][1],'1');
			//�ͤ�ޤ��ɤ߹���褦�ˤ���
			$day_flg = false;
		}
		$day_num++;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($X2, $posY);
	$pdf->SetFillColor(213,213,213);

	//**************************����ɽ��***************************

	for($j=$num2;$j<7;$j++){
		//���̾
		if($j==0){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		}else{
			//����Ƚ��
			if(is_numeric($data_sub[$j])){
				//�����ͤ����ͤ�­���Ƥ���
				$data_total[$j] = $data_total[$j] + $data_sub[$j];
				$data_sub[$j] = number_format($data_sub[$j]);
			}
			$pdf->Cell($data_align[$j][0], 14, $data_sub[$j], '1', '0', $data_align[$j][1],'1');
		}
	}
	$data_total[$j] = $data_total[$j] + $data_sub[$j];
	$data_sub[$j] = number_format($data_sub[$j]);
	$pdf->Cell($data_align[$j][0], 14, $data_sub[$j], '1', '2', $data_align[$j][1],'1');

	//���ס������
	$data_sub = array();

	//*************************************************************

	//ô���ԿͿ���­��
	$person_count++;
}

//**************************��׽���***************************

//����̾������align
$list[1] = array("210","���","C");
$list[4] = array("80","ͽ����","C");
$list[5] = array("80","������","C");
$list[6] = array("50","����","C");
$list[7] = array("30","���","C");
$list[8] = array("50","����","C");
$list[9] = array("30","���","C");
$list[10] = array("50","����","C");

//align����(�ǡ���)
$data_align[2] = array("80","L");
$data_align[3] = array("30","R");
$data_align[4] = array("50","R");
$data_align[5] = array("30","R");
$data_align[6] = array("50","R");
$data_align[7] = array("50","R");

	//*******************���ڡ�������*****************************

	//ô���Ԥ��ڡ����ˣ���ɽ�������顢���ڡ�������
	if($person_count == 3){
		
		$pdf->AddPage();
		$page_count++;

		//�إå���ɽ��
		Header_route($pdf,$left_margin,$top_margin,$title,$date,$time,$page_count);

		//ô���ԿͿ�������
		$person_count = 0;
	}

	//*************************************************************


	/**********************���ܽ���**************************/
	
	//����ɽ������
	switch($person_count){
		//�����
	    case 0:
				$posY = $pdf->GetY();
				$pdf->SetXY($left_margin, $posY);
				$X = $left_margin+205;
				$Y = $top_margin+72;
				$num = 0;
	      		break;
		//�����
	    case 1:
				$pdf->SetXY($left_margin+407.5,$top_margin+42);
				$X = $left_margin+407.5;
				$Y = $top_margin+72;
				$num = 1;
	      		break;
		//������
		case 2:
				$pdf->SetXY($left_margin+765,$top_margin+42);
				$X = $left_margin+920;
				$Y = $top_margin+72;
				$num = 1;
	      		break;
	    default:
  	}

	//����ɽ��
	for($i=$num;$i<count($list);$i++){
		if($i == 0){
			$pdf->Cell($list[$i][0], 45, $time, '1', '0', $list[$i][2]);
		}
		if($i == 1){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '2', $list[$i][2]);
		}
		if($i == 6){
			$pdf->Cell($list[$i][0], 30, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 4 || $i == 5){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 7){
			$pdf->SetXY($X,$Y);
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 8 || $i == 9 || $i == 10){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}	
	}

	//*************************************************************	


	//************************�ǡ���ɽ��***************************

	//������ź�����ֹ�
	$day_num = 0;
	//��¸�ߥե饰
	$day_flg = false;

	//����ɽ������
	switch($person_count){
	    case 0:
				$pdf->SetXY($left_margin,$top_margin+87);
				$X2 = $left_margin;
				$num2 = 0;
	      		break;
	    case 1:
				$pdf->SetXY($left_margin+407.5,$top_margin+87);
				$X2 = $left_margin+407.5;
				$num2 = 3;
	      		break;
		case 2:
				$pdf->SetXY($left_margin+765,$top_margin+87);
				$X2 = $left_margin+765;
				$num2 = 3;
	      		break;
	    default:
  	}

	//ô���Խ���
	for($d=1;$d<=count($day_count);$d++){
		//�ͤ�¸�ߤ���������ɤ߹���
		if($day_flg == false){
			$data_list = pg_fetch_array($result);
		}
		$posY = $pdf->GetY();
		$pdf->SetXY($X2, $posY);

		//�����������ѹ�
		if($holiday[$day_num] == "��"){
			$pdf->SetFillColor(255,224,224);
		}else if($holiday[$day_num] == "��"){
			$pdf->SetFillColor(204,234,255);
		}else{
			$pdf->SetFillColor(255,255,255);
		}

		//��������ѿ�
		if($d <= 9){
			$day_check = $year."-".$month."-0".$d;
		}else{
			$day_check = $year."-".$month."-".$d;
		}
		//ͽ�꤬¸�ߤ��뤫
		if($data_list[0] != $day_check){
			//����Υ���
			for($j=$num2;$j<7;$j++){
				if($j==0){
					$pdf->Cell($data_align[0][0], 14, $day_count[$day_num], '1', '0', $data_align[0][1],'1');			//������̾�������Ȥ�ɽ�����ʤ�
				}else if($j==3 || $j==4 || $j==5 || $j==6){
					$pdf->Cell($data_align[$j][0], 14, '', '1', '0', $data_align[$j][1],'1');
				}
			}
			$pdf->Cell($data_align[$j][0], 14, '', '1', '2', $data_align[$j][1],'1');
			//���ιԤˡ����ɤ߹�����Ԥ����
			$day_flg = true;
		}else{
			for($j=$num2;$j<7;$j++){
				if($j==0){
					$pdf->Cell($data_align[$j][0], 14, $day_count[$day_num], '1', '0', $data_align[$j][1],'1');				}else if($j==3 || $j==4 || $j==5 || $j==6){
					//����Ƚ��
					if(is_numeric($data_list[$j])){
						//�����ͤ�­���Ƥ���
						$data_sub[$j] = $data_sub[$j] + $data_list[$j];
						$data_list[$j] = number_format($data_list[$j]);
					}
					$pdf->Cell($data_align[$j][0], 14, $data_list[$j], '1', '0', $data_align[$j][1],'1');
				}
			}
			$data_sub[$j] = $data_sub[$j] + $data_list[$j];
			$data_list[$j] = number_format($data_list[$j]);
			$pdf->Cell($data_align[$j][0], 14, $data_list[$j], '1', '2', $data_align[$j][1],'1');
			//�ͤ�ޤ��ɤ߹���褦�ˤ���
			$day_flg = false;
		}
		$day_num++;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($X2, $posY);
	$pdf->SetFillColor(213,213,213);

	//**************************���ɽ��***************************

	for($j=$num2;$j<7;$j++){
		//���̾
		if($j==0){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
			//������̾�������Ȥ�ɽ�����ʤ�
		}else if($j==3 || $j==4 || $j==5 || $j==6){
			$data_total[$j] = number_format($data_total[$j]);
			$pdf->Cell($data_align[$j][0], 14, $data_total[$j], '1', '0', $data_align[$j][1],'1');
		}
	}
	$data_total[$j] = number_format($data_total[$j]);
	$pdf->Cell($data_align[$j][0], 14, $data_total[$j], '1', '2', $data_align[$j][1],'1');

//*************************************************************

$pdf->Output();

?>
