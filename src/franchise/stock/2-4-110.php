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
$title = "��α�߸˰���ɽ";
$page_count = "1"; 

//����̾������align
$list[0] = array("30","NO","C");
$list[1] = array("110","�Ͷ�ʬ","C");
$list[2] = array("300","����̾","C");
$list[3] = array("110","�Ҹ�","C");
$list[4] = array("80","�߸˿�","C");
$list[5] = array("80","������","C");
$list[6] = array("80","�߸�ñ��","C");
$list[7] = array("80","�߸˶��","C");
$list[8] = array("80","�������","C");
$list[9] = array("80","�߸�����","C");
$list[10] = array("80","�ǽ��谷��","C");

//�Ͷ�ʬ�ס����̾
$list_sub[0] = array("110","�Ͷ�ʬ��","L");
$list_sub[1] = array("110","���","L");

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
$data_align[9] = "R";
$data_align[10] = "C";

//�ǡ�������SQL(�Ͷ�ʬ,����̾,�Ҹ�,�߸˿�,������,�߸�ñ��,�߸˶��,�������,�߸�����,�ǽ��谷��)
$sql = "select goods,goods_name,house,num1,num2,num3,num4,num5,day,date from t_long;";

//���ߤ����ռ���SQL
$sql_stock = "SELECT DISTINCT stock_date FROM t_long;";

//�ڡ�������ɽ����
$page_max = 50;

//***********************************************

//DB��³
$db_con = Db_Connect("amenity_test");
//���ռ���
$result = Db_Query($db_con,$sql_stock);
$time = pg_fetch_result($result,0,0);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//���λ���
$border_time = "���������100���ʾ�";

$date = date("�������Yǯm��d����H��i");
//���ռ����������ѹ�
$year = substr($time,0,4);
$month = substr($time,5,2);
$day = substr($time,8,2);
$time = $year."ǯ".$month."��".$day."��������";

//�إå���ɽ��
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

//�ģ¤��ͤ�ɽ��
//�Կ����ڡ����������Υڡ���ɽ���������ס���ס�����͡������ǡ��ǹ���ۡ������
$count = 0;
$page_next = $page_max;
$data_sub = array();
$data_total = array();
$goods = "";

$result = Db_Query($db_con,$sql);

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************���׽���***********************************

	//�ͤ��Ѥ�ä���硢����ɽ��
	if($goods != $data_list[0]){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			$pdf->SetFillColor(213,213,213);
			//�ͤξ�άȽ��ե饰
			$space_flg = true;
			for($x=0;$x<10;$x++){
				//���׹��ֹ�
				if($x==0){
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
				//�Ͷ�ʬ��̾
				}else if($x==1){
					$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//�Ͷ�ʬ����
				}else{
					//����Ƚ��
					if(is_numeric($data_sub[$x])){
						//�����ͤ����ͤ�­���Ƥ���
						$data_total[$x] = $data_total[$x] + $data_sub[$x];
						$data_sub[$x] = number_format($data_sub[$x]);
					}
					$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
				}
			}
			//�ǽ��谷��
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//���ס������
			$data_sub = array();
			$count++;
		}
		$goods = $data_list[0];
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
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

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
	for($x=1;$x<10;$x++){
		//ɽ����
		$contents = "";
		//ɽ��line		
		$line = "";

		//����ܤ����פθ�ξ��ϡ���ά���ʤ���
		if($x==1 && $count == 1 || $space_flg == true){
			//������Ƚ��
			//�ڡ����κ���ɽ������
			$contents = $data_list[$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LR';
			}
			//����̾���ά����
			$space_flg = false;
		//���˾���̾��ɽ����������
		}else if($x==1){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//�߸�����
		}else if($x==9){
			if(is_numeric($data_list[$x-1])){
				$data_list[$x-1] = number_format($data_list[$x-1]);
			}
			$contents = $data_list[$x-1]."��";
			$line = '1';
		//�߸ˡ��������
		}else if($x==7 || $x==8){
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
	//�ǽ��谷���������ѹ�
	$year = substr($data_list[$x-1],0,4);
	$month = substr($data_list[$x-1],5,2);
	$day = substr($data_list[$x-1],8,2);
	$data_list[$x-1] = $year."ǯ".$month."��".$day."��";
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

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

//******************�ǽ����׽���***********************************
	
for($x=0;$x<10;$x++){
	//���׹��ֹ�
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//�Ͷ�ʬ��̾
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//�Ͷ�ʬ����
	}else{
		//����Ƚ��
		if(is_numeric($data_sub[$x])){
			//�����ͤ����ͤ�­���Ƥ���
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
//�ǽ��谷��
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//���ס������
$data_sub = array();
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
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,$border_time,$time,$page_count,$list,$font_size,$page_size);

	//���κ���ɽ����
	$page_next = $page_max * $page_count;
	$space_flg = true;
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
	}else{
		//������
		//����Ƚ��
		if(is_numeric($data_total[$x])){
			//�����ѹ�
			$data_total[$x] = number_format($data_total[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');
//****************************************************************

$pdf->Output();

?>


?>
