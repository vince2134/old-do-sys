<?php
//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);


//*******************�إå����ؿ�*********************
function Header_sale($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_center,$right_center,$left_bottom,$right_bottom,$page_count,$list,$font_size,$page_size){

	$pdf->SetFont(GOTHIC, '', $font_size);
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell($page_size, 14, $title, '0', '1', 'C');
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell($page_size, 14, $page_count."�ڡ���", '0', '2', 'R');
	$pdf->SetX($left_margin);
	$pdf->Cell($page_size, 14, $left_top, '0', '1', 'L');
	$pdf->SetXY($left_margin,$top_margin+14);
	$pdf->Cell($page_size, 14, $right_top, '0', '1', 'R');
	$pdf->SetXY($left_margin,$top_margin+28);
	$pdf->Cell($page_size, 14, $right_center, '0', '1', 'R');
	$pdf->SetXY($left_margin,$top_margin+28);
	$pdf->Cell($page_size, 14, $left_center, '0', '1', 'L');
	$pdf->SetXY($left_margin,$top_margin+42);
	$pdf->Cell($page_size, 14, $right_bottom, '0', '1', 'R');
	$pdf->SetXY($left_margin,$top_margin+42);
	$pdf->Cell($page_size, 14, $left_bottom, '0', '2', 'L');

	//����ɽ��
	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	for($i=0;$i<count($list)-1;$i++)
	{
		$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
	}
	$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

}

//*******************���ϲս�*********************

//;��
$left_margin = 48;
$top_margin = 40;

//�إå����Υե���ȥ�����
$font_size = 8;
//�ڡ���������
$page_size = 495;

//A4
$pdf=new MBFPDF('P','pt','A4');

//�����ȥ�
$title = "�������踵Ģ";
$page_count = "1"; 

//����̾������align
$list[0] = array("45","����","C");
$list[1] = array("40","��ɼ�ֹ�","C");
$list[2] = array("40","�����ʬ","C");
$list[3] = array("90","����̾","C");
$list[4] = array("40","ô����","C");
$list[5] = array("40","����","C");
$list[6] = array("50","ñ��","C");
$list[7] = array("50","���","C");
$list[8] = array("50","������","C");
$list[9] = array("50","��ݻĹ�","C");

//��ס��������̾
$list_sub[0] = array("90","���","R");
$list_sub[1] = array("90","����","R");
$list_sub[2] = array("90","�������","R");

//align(�ǡ���)
$data_align[0] = "C";
$data_align[1] = "L";
$data_align[2] = "C";
$data_align[3] = "L";
$data_align[4] = "L";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "R";

//�ǡ�������SQL(���ա���ɼ�ֹ桦�����ʬ������̾��ô���ԡ����̡�ñ������ۡ�������)
$sql = "select date,slip,invent,goods,person,num1,num2,num3,num4 from t_ledger;";

//������̾�������襳���ɼ���SQL
$sql_stock = "SELECT DISTINCT stock_name,stock_code FROM t_ledger;";

//�ڡ�������ɽ����
$page_max = 50;

//***********************************************

$head_name = "�������衧";

//DB��³
$db_con = Db_Connect("amenity_test");
$result = Db_Query($db_con,$sql_stock);

//������̾����
$name = pg_fetch_result($result,0,0)." ��";
//�����襳���ɼ���
$code = pg_fetch_result($result,0,1);

$head_name .= $code."��".$name;

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//���λ���
$time = "������֡�2005ǯ04��01����2005ǯ04��31��";
//����
$close = "������25��";
//��ʧ��
$pay = "��ʧ����1������25��";

$date = date("�������Yǯm��d����H��i");

//�Х�������Ѥΰ�ɽ��
$pdf->Image(IMAGE_DIR.'triangle.png',18,413,5,10);

//�إå���ɽ��
Header_sale($pdf,$left_margin,$top_margin,$title,'',$date,$head_name,$close,$time,$pay,$page_count,$list,$font_size,$page_size);

//�ģ¤��ͤ�ɽ��
//�Կ����ڡ����������Υڡ���ɽ��������ס����ǡ�������ס�����͡������
$count = 0;
$page_next = $page_max;
$data_sub = array();
$data_sub2 = array();
$data_total = array();
$date_day = "";
$date_day2 = "";

$result = Db_Query($db_con,$sql);

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		
		//�Х�������Ѥΰ�ɽ��
		$pdf->Image(IMAGE_DIR.'triangle.png',18,413,5,10);

		//�إå���ɽ��
		Header_sale($pdf,$left_margin,$top_margin,$title,'',$date,$head_name,$close,$time,$pay,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//******************���վ�άȽ��***********************************

	//�����Ѥ�ä���硢����ɽ��
	if($date_day2 != $data_list[0]){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			//�ͤξ�άȽ��ե饰
			$space_flg = true;
		}
		$date_day2 = $data_list[0];
	}

//******************��ס����ǽ���***********************************

	//ǯ��Ѥ�ä���硢���ɽ��
	if($date_day != substr($data_list[0],0,7)){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//�ͤξ�άȽ��ե饰
			$space_flg = true;

			//��������������פȰ���ɽ��
			$month = substr($date_day,5,2);
			//���ξ��ˤϡ�0����
			if($month <= 9){
				$month = substr($month,1,1);
			}

			for($x=0;$x<9;$x++){
				//��׹��ֹ�
				if($x==3){
					$pdf->Cell($list_sub[0][0], 14, $month.$list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//�����
				}else{
					//����Ƚ��
					if(is_numeric($data_sub[$x])){
						//����ͤ���������ͤ�­���Ƥ���
						$data_total[$x] = $data_total[$x] + $data_sub[$x];
						$data_sub[$x] = number_format($data_sub[$x]);
					}
					$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
				}
			}
			//����ͤ���������ͤ�­���Ƥ���
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//��ס������
			$data_sub = array();
			$count++;

			/****************************************************************/

			$posY = $pdf->GetY();
			$pdf->SetXY($left_margin, $posY);
			$pdf->SetFillColor(180,180,180);
			/****************************************************************/

			//����
			for($x=0;$x<9;$x++){
				//���ǹ��ֹ�
				if($x==3){
					$pdf->Cell($list_sub[1][0], 14, $month.$list_sub[1][1], '1', '0',$list_sub[1][2],'1');
				//���Ǥ������ۤϣ���ɽ�������ʤ�
				}else if($x==8){
					$pdf->Cell($list[$x][0], 14, '', '1', '0','R','1');
				//������
				}else{
					//����Ƚ��
					if(is_numeric($data_sub2[$x])){
						//�����ͤ���������ͤ�­���Ƥ���
						$data_total[$x] = $data_total[$x] + $data_sub2[$x];
						$data_sub2[$x] = number_format($data_sub2[$x]);
					}
					$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
				}
			}
			//���Ǥˤ���ݻĹ�Ϥʤ�
			$pdf->Cell($list[$x][0], 14, '', '1', '2','R','1');
			//���ǡ������
			$data_sub2 = array();
			$count++;
		}
		//ǯ��������������ǯ������
		$date_day = substr($data_list[0],0,7);
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		
		//�Х�������Ѥΰ�ɽ��
		$pdf->Image(IMAGE_DIR.'triangle.png',18,413,5,10);

		//�إå���ɽ��
		Header_sale($pdf,$left_margin,$top_margin,$title,'',$date,$head_name,$close,$time,$pay,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

//************************�ǡ���ɽ��***************************

	for($x=0;$x<9;$x++){
		//ɽ����
		$contents = "";
		//ɽ��line		
		$line = "";

		if($x==0 && $count == 1 || $space_flg == true){
			//������Ƚ��
			//�ڡ����κ���ɽ������
			$contents = $data_list[$x];
			//�����ѹ�(�㡢05-03-10)
			$year = substr($contents,2,2);
			$month = substr($contents,5,2);
			$day = substr($contents,8,2);
			$contents = $year."-".$month."-".$day;
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//���դ��ά����
			$space_flg = false;
		//���˷��̾��ɽ����������
		}else if($x==0){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//��ۤ�������ɽ��
		}else if($x==7 || $x==8){
			//���Ǥȷ�פη׻���ʬ����
			if($data_list[3] == "������"){
				//�ͤ���Ǥ�­���Ƥ���
				$data_sub2[$x] = $data_sub2[$x] + $data_list[$x];
			}else{
				//�ͤ��פ�­���Ƥ���
				$data_sub[$x] = $data_sub[$x] + $data_list[$x];
			}
			$data_result = number_format($data_list[$x]);
			$contents = $data_result;
			$line = '1';
		//���⡦��������ξ��ϡ���ɼ�ֹ����ɽ��
		}else if($x==1 && ($data_list[2] == "31" || $data_list[2] == "32")){
			$contents = '';
			$line = '1';
		}else{
			if(is_numeric($data_list[$x]) && $x!=1 && $x!=4){
				$data_list[$x] = number_format($data_list[$x]);
			}
			$contents = $data_list[$x];
			$line = '1';
		}
		//�����Ǥϱ���
		if($contents == "������"){
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', 'R');
		//��ݻĹ�ʳ��ϣ���ɽ�����ʤ�
		}else if($contents == '0'){
			$pdf->Cell($list[$x][0], 14, '', $line, '0', $data_align[$x]);
		}else{
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
	}
	//�����ʬ������ξ�硢��ɼ���Ȥ�����׻���Ԥ�
	if($data_list[2] == "31" || $data_list[2] == "32"){
		//��ݻĹ��������
		$data_sub[$x] = $data_sub[$x] - $data_list[8];
	}else{
		//��ݻĹ�(���ʤ��Ȥζ�ۤ�ץ饹���Ƥ���)
		$data_sub[$x] = $data_sub[$x] + $data_list[7];
	}
	$data_result = number_format($data_sub[$x]);
	$pdf->Cell($list[$x][0], 14, $data_result, '1', '2', $data_align[$x]);
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
		
		//�Х�������Ѥΰ�ɽ��
		$pdf->Image(IMAGE_DIR.'triangle.png',18,413,5,10);

		//�إå���ɽ��
		Header_sale($pdf,$left_margin,$top_margin,$title,'',$date,$head_name,$close,$time,$pay,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//******************�ǽ���׽���***********************************
	
//��������������פȰ���ɽ��
$month = substr($date_day,5,2);
//���ξ��ˤϡ�0����
if($month <= 9){
	$month = substr($month,1,1);
}

for($x=0;$x<9;$x++){
	//��׹��ֹ�
	if($x==3){
		$pdf->Cell($list_sub[0][0], 14, $month.$list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//�����
	}else{
		//����Ƚ��
		if(is_numeric($data_sub[$x])){
			//����ͤ���������ͤ�­���Ƥ���
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
		}
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
//����ͤ���������ͤ�­���Ƥ���
$data_total[$x] = $data_total[$x] + $data_sub[$x];
$data_sub[$x] = number_format($data_sub[$x]);
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//��ס������
$data_sub = array();
$count++;

/****************************************************************/

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		
		//�Х�������Ѥΰ�ɽ��
		$pdf->Image(IMAGE_DIR.'triangle.png',18,413,5,10);

		//�إå���ɽ��
		Header_sale($pdf,$left_margin,$top_margin,$title,'',$date,$head_name,$close,$time,$pay,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

/****************�ǽ����ǽ���*****************************/

//����
for($x=0;$x<9;$x++){
	//���ǹ��ֹ�
	if($x==3){
		$pdf->Cell($list_sub[1][0], 14, $month.$list_sub[1][1], '1', '0',$list_sub[1][2],'1');
	//���Ǥ������ۤϣ���ɽ�������ʤ�
	}else if($x==8){
		$pdf->Cell($list[$x][0], 14, '', '1', '0','R','1');
	//������
	}else{
		//����Ƚ��
		if(is_numeric($data_sub2[$x])){
			//�����ͤ���������ͤ�­���Ƥ���
			$data_total[$x] = $data_total[$x] + $data_sub2[$x];
			$data_sub2[$x] = number_format($data_sub2[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
	}
}
//���Ǥˤ���ݻĹ�Ϥʤ�
$pdf->Cell($list[$x][0], 14, '', '1', '2','R','1');
//���ǡ������
$data_sub2 = array();

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
		
		//�Х�������Ѥΰ�ɽ��
		$pdf->Image(IMAGE_DIR.'triangle.png',18,413,5,10);

		//�إå���ɽ��
		Header_sale($pdf,$left_margin,$top_margin,$title,'',$date,$head_name,$close,$time,$pay,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//*************************������׽���*******************************

for($x=0;$x<9;$x++){
	//��׹��ֹ�
	if($x==3){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	//ô���Է���
	}else{
		//�����������
		//����Ƚ��
		if(is_numeric($data_total[$x])){
			//�����ѹ�
			$data_total[$x] = number_format($data_total[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
//�����ѹ�
$data_total[$x] = number_format($data_total[$x]);

$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');
//****************************************************************

$pdf->Output();

?>
