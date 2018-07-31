<?php
//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);
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
$title = "ê������ɽ";
$page_count = "0"; 

//����̾������align
$list[0] = array("40","NO","C");
$list[1] = array("140","�Ͷ�ʬ","C");
$list[2] = array("300","����̾","C");
$list[3] = array("90","ê����","C");
$list[4] = array("90","ê��ñ��","C");
$list[5] = array("90","ê�����","C");
$list[6] = array("90","����߸˿�","C");
$list[7] = array("90","����߸˳�","C");
$list[8] = array("90","���������","C");
$list[9] = array("90","����������","C");

//�Ҹ˷ס��Ͷ�ʬ̾
$list_sub[0] = array("140","�Ҹ˷�","L");
$list_sub[1] = array("140","����","L");
$list_sub[2] = array("140","�Ͷ�ʬ��","L");

//align(�ǡ���)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "R";
$data_align[4] = "R";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "R";

//�ڡ�������ɽ����
$page_max = 50;

//�Ҹˡ�ê������Ĵ��ɽ�ֹ桢����SQL
$sql_house = "SELECT DISTINCT warehouse,stock_date,invent_num FROM t_shelf;";

//***********************************************

//DB��³
$db_con = Db_Connect("amenity_test");

$result_house = Db_Query($db_con,$sql_house);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//�Ҹˤ�¸�ߤ���ֽ���
while($house_list = pg_fetch_array($result_house)){

	//�Ͷ�ʬ������̾��ê������ê��ñ����ê����ۡ�����߸˿�������߸˳ۡ��������������������ۼ���SQL
	$sql = "SELECT goods,goods_name,num1,num2,";
	$sql .= "num3,num4,num5,num6,num7 ";
	$sql .= "FROM t_shelf ";
	$sql .= "WHERE warehouse = '".$house_list[0]."';";

	//�Ҹ�̾����
	$warehouse = "�Ҹ�̾: ".$house_list[0];

	//���ռ���
	$house_date = $house_list[1];

	//Ĵ��ɽ�ֹ����
	$invent_num = "ê��Ĵ��ɽ�ֹ桧".$house_list[2];

	$pdf->SetFont(GOTHIC, '', 9);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//�ģ¤��ͤ�ɽ��
	//�Կ����ڡ����������Υڡ���ɽ�������Ҹ˷ס��Ͷ�ʬ�ס����ס�����͡������
	$count = 0;
	$page_count++;
	$page_next = $page_max;
	$data_sub = array();
	$data_sub2 = array();
	$data_total = array();
	$goods = "";

	//�ǡ�������
	$result = Db_Query($db_con,$sql);

	while($data_list = pg_fetch_array($result)){
		$count++;

		/**********************�إå�������**************************/
		//����ܤξ�硢�إå�����
		if($count == 1){
			//���ߤλ������
			$date = date("�������Yǯm��d����H��i");
			//�����ѹ�
			$year = substr($house_date,0,4);
			$month = substr($house_date,5,2);
			$day = substr($house_date,8,2);
			$house_date = "ê������".$year."ǯ".$month."��".$day."��";

			//�إå���ɽ��
			Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);
		}

		//*******************���ڡ�������*****************************

		//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
		if($page_next+1 == $count){
			$page_count++;
			$pdf->AddPage();
			//�إå���ɽ��
			Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

			//���κ���ɽ����
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

		//******************�Ͷ�ʬ�׽���***********************************

		//�ͤ��Ѥ�ä���硢�Ͷ�ʬ��ɽ��
		if($goods != $data_list[0]){
			//����ܤϡ��ͤ򥻥åȤ������
			if($count != 1){
				$pdf->SetFillColor(220,220,220);
				//�ͤξ�άȽ��ե饰
				$space_flg = true;
				for($x=0;$x<9;$x++){
					//���ֹ�
					if($x==0){
						$pdf->SetFont(GOTHIC, '', 9);
						$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
						$pdf->SetFont(GOTHIC, 'B', 9);
					//�Ͷ�ʬ��̾
					}else if($x==1){
						$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
					}else{
					//�Ͷ�ʬ����
						//����Ƚ��
						if(is_numeric($data_sub2[$x])){
							$data_sub2[$x] = number_format($data_sub2[$x]);
						}
						$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
					}
				}
				//���������
				$data_sub2[$x] = number_format($data_sub2[$x]);
				$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
				//�Ͷ�ʬ�����
				$data_sub2 = array();
				$count++;
			}
			$goods = $data_list[0];
		}


		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

		//*******************���ڡ�������*****************************

		//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
		if($page_next+1 == $count){
			$page_count++;
			$pdf->AddPage();
			//�إå���ɽ��
			Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

			//���κ���ɽ����
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

		//************************�ǡ���ɽ��***************************
		//���ֹ�
		$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
		for($x=1;$x<9;$x++){
			//ɽ����
			$contents = "";
			//ɽ��line		
			$line = "";

			//����ܤ��Ͷ�ʬ�פθ�ʳ����ͤξ�ά
			if($x==1 && ($count == 1 || $space_flg == true)){
				//������Ƚ��
				//�ڡ����κ���ɽ������
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//��ά����
				$space_flg = false;
			//���˾���̾��ɽ����������
			}else if($x==1){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			}else{
				if(is_numeric($data_list[$x-1])){
					//�ͤ�Ͷ�ʬ�פ�­���Ƥ���
					$data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
					//�ͤ��Ҹ˷פ�­���Ƥ���
					$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
					$data_list[$x-1] = number_format($data_list[$x-1]);
				}
				$contents = $data_list[$x-1];
				$line = '1';
			}
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
		//���������
		$data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
		$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
		$data_list[$x-1] = number_format($data_list[$x-1]);
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
		$page_count++;
		$pdf->AddPage();
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************�ǽ��Ͷ�ʬ�׽���***********************************

	for($x=0;$x<9;$x++){
		//���ֹ�
		if($x==0){
			$pdf->SetFont(GOTHIC, '', 9);
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
			$pdf->SetFont(GOTHIC, 'B', 9);
		//�Ͷ�ʬ��̾
		}else if($x==1){
			$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
		}else{
		//�Ͷ�ʬ����
			//����Ƚ��
			if(is_numeric($data_sub2[$x])){
				$data_sub2[$x] = number_format($data_sub2[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
		}
	}
	//���������
	$data_sub2[$x] = number_format($data_sub2[$x]);
	$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
	//�Ͷ�ʬ�����
	$data_sub2 = array();

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(180,180,180);
	$count++;

	//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$page_count++;
		$pdf->AddPage();
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************�ǽ��Ҹ˷׽���***********************************
		
	for($x=0;$x<9;$x++){
		//���ֹ�
		if($x==0){
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
		//�Ҹ˷�̾
		}else if($x==1){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		}else{
		//�Ҹ˷���
			//����Ƚ��
			if(is_numeric($data_sub[$x])){
				$data_sub[$x] = number_format($data_sub[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
		}
	}
	//���������
	$data_sub[$x] = number_format($data_sub[$x]);
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
	//�Ҹ˽����
	$data_sub = array();

	//*************************************************************
}

//*************************���Ҹ˷׽���*******************************

//���Ҹ˷׼���SQL
$sql = "SELECT goods,goods_name,sum(num1),sum(num2),";
$sql .= "sum(num3),sum(num4),sum(num5),sum(num6),sum(num7) ";
$sql .= "FROM t_shelf ";
$sql .= "GROUP BY goods,goods_name ";
$sql .= "ORDER BY goods ASC;";

$result = Db_Query($db_con,$sql);

//�Ҹ�̾����
$warehouse = "�Ҹ�̾: ���Ҹ˷�";

$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//�ģ¤��ͤ�ɽ��
//�Կ����ڡ����������Υڡ���ɽ�������Ҹ˷ס��Ͷ�ʬ�ס����ס�����͡������
$count = 0;
$page_count++;
//���ڡ����׻��ѤΥڡ�����
$page_count2 = 1;
$page_next = $page_max;
$data_sub = array();
$data_sub2 = array();
$data_total = array();
$goods = "";

//�ǡ�������
$result = Db_Query($db_con,$sql);

while($data_list = pg_fetch_array($result)){
	$count++;

	/**********************�إå�������**************************/
	//����ܤξ�硢�إå�����
	if($count == 1){

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);
	}

	//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$page_count++;
		$page_count2++;
		$pdf->AddPage();
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count2;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************�Ͷ�ʬ�׽���***********************************

	//�ͤ��Ѥ�ä���硢�Ͷ�ʬ��ɽ��
	if($goods != $data_list[0]){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//�ͤξ�άȽ��ե饰
			$space_flg = true;
			for($x=0;$x<9;$x++){
				//���ֹ�
				if($x==0){
					$pdf->SetFont(GOTHIC, '', 9);
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
					$pdf->SetFont(GOTHIC, 'B', 9);
				//�Ͷ�ʬ��̾
				}else if($x==1){
					$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
				}else{
				//�Ͷ�ʬ����
					//����Ƚ��
					if(is_numeric($data_sub2[$x])){
						$data_sub2[$x] = number_format($data_sub2[$x]);
					}
					$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
				}
			}
			//���������
			$data_sub2[$x] = number_format($data_sub2[$x]);
			$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
			//�Ͷ�ʬ�����
			$data_sub2 = array();
			$count++;
		}
		$goods = $data_list[0];
	}


	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$page_count++;
		$page_count2++;
		$pdf->AddPage();
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count2;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//************************�ǡ���ɽ��***************************
	//���ֹ�
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<9;$x++){
		//ɽ����
		$contents = "";
		//ɽ��line		
		$line = "";

		//����ܤ��Ͷ�ʬ�פθ�ʳ����ͤξ�ά
		if($x==1 && ($count == 1 || $space_flg == true)){
			//������Ƚ��
			//�ڡ����κ���ɽ������
			$contents = $data_list[$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//��ά����
			$space_flg = false;
		//���˾���̾��ɽ����������
		}else if($x==1){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		}else{
			if(is_numeric($data_list[$x-1])){
				//�ͤ�Ͷ�ʬ�פ�­���Ƥ���
				$data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
				//�ͤ��Ҹ˷פ�­���Ƥ���
				$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
				$data_list[$x-1] = number_format($data_list[$x-1]);
			}
			$contents = $data_list[$x-1];
			$line = '1';
		}
		$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
	}
	//���������
	$data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
	$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
	$data_list[$x-1] = number_format($data_list[$x-1]);
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
	$page_count++;
	$page_count2++;
	$pdf->AddPage();
	//�إå���ɽ��
	Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

	//���κ���ɽ����
	$page_next = $page_max * $page_count2;
	$space_flg = true;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//******************�ǽ��Ͷ�ʬ�׽���***********************************

for($x=0;$x<9;$x++){
	//���ֹ�
	if($x==0){
		$pdf->SetFont(GOTHIC, '', 9);
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
		$pdf->SetFont(GOTHIC, 'B', 9);
	//�Ͷ�ʬ��̾
	}else if($x==1){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	}else{
	//�Ͷ�ʬ����
		//����Ƚ��
		if(is_numeric($data_sub2[$x])){
			$data_sub2[$x] = number_format($data_sub2[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
	}
}
//���������
$data_sub2[$x] = number_format($data_sub2[$x]);
$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
//�Ͷ�ʬ�����
$data_sub2 = array();

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//*******************���ڡ�������*****************************

//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
if($page_next+1 == $count){
	$page_count++;
	$page_count2++;
	$pdf->AddPage();
	//�إå���ɽ��
	Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

	//���κ���ɽ����
	$page_next = $page_max * $page_count2;
	$space_flg = true;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//******************�ǽ��Ҹ˷׽���***********************************
	
for($x=0;$x<9;$x++){
	//���ֹ�
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//�Ҹ˷�̾
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	}else{
	//�Ҹ˷���
		//����Ƚ��
		if(is_numeric($data_sub[$x])){
			$data_sub[$x] = number_format($data_sub[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
//���������
$data_sub[$x] = number_format($data_sub[$x]);
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//�Ҹ˽����
$data_sub = array();

//*************************************************************

$pdf->Output();

?>
