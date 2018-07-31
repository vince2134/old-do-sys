<?php

//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

//�إå���ɽ���ؿ�
//������PDF���֥������ȡ��ޡ����󡦥����ȥ롦����/����/����/�����Υإå����ܡ��ڡ�����������̾��
function Header_rental($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$list){

	$pdf->SetFont(GOTHIC, 'B', 12);
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell(762, 14, $title, '0', '1', 'C');
	$pdf->SetFont(GOTHIC, 'B', 14);
	$pdf->SetXY($left_margin,$top_margin+15);
	$pdf->Cell(762, 25, $left_top."������", '0', '1', 'L');
	$pdf->SetXY($left_margin,$top_margin+15);
	$pdf->Cell(762, 25, $right_top, '0', '1', 'R');
	$pdf->SetFont(GOTHIC, 'B', 12);
	$pdf->SetXY($left_margin,$top_margin+40);
	$pdf->Cell(762, 16, $left_bottom, '0', '1', 'L');
	$pdf->SetXY($left_margin,$top_margin+40);
	$pdf->Cell(762, 16, $page_count."�ڡ���", '0', '1', 'R');
	$pdf->SetFont(GOTHIC, 'B', 9);

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
$left_margin = 40;
$top_margin = 40;

//�ڡ���������
//A4
$pdf=new MBFPDF('L','pt','a4');

//�����ȥ�
$title = "��󥿥�������";
$page_count = "1"; 
$right = "������ҡ�����˥ƥ�";

//���աʲ���
$date = "2005ǯ11��ʬ";

//����̾������align
$list[0] = array("145","��󥿥���","C");
$list[1] = array("282","����̾","C");
$list[2] = array("65","��󥿥���","C");
$list[3] = array("55","��󥿥��","C");
$list[4] = array("65","��󥿥��","C");
$list[5] = array("150","����","C");

//���ס����̾
$list_sub[0] = array("145","����","L");
$list_sub[1] = array("145","���","L");

//align(�ǡ���)
$data_align[0] = "L";
$data_align[1] = "L";
$data_align[2] = "R";
$data_align[3] = "R";
$data_align[4] = "R";
$data_align[5] = "L";

//����å׼���SQL
$sql_shop = "SELECT DISTINCT shop_id FROM t_rental;";

//�ڡ�������ɽ����
$page_max = 32;

//***********************************************

//DB��³
$db_con = Db_Connect("amenity");

$result_shop = Db_Query($db_con,$sql_shop);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//����åפ�¸�ߤ���ֽ���
while($shop_list = pg_fetch_array($result_shop)){

	//�ǡ�������SQL

	//��󥿥�������SQL(��󥿥��衦����̾����󥿥�������󥿥������󥿥�ۡ����͡���󥿥�ID)
	$sql = "SELECT rental_client,t_goods.goods_name,rental_price,";
	$sql .= "rental_num,rental_amount,note,t_shop.shop_name ";
	$sql .= "FROM t_goods,t_rental,t_shop ";
	$sql .= "WHERE t_goods.goods_id = t_rental.goods_id ";
	$sql .= "AND t_shop.shop_id = t_rental.shop_id ";
	$sql .= "AND t_rental.shop_id = ".$shop_list[0];
	$sql .= " ORDER BY rental_client ASC;";

	$result = Db_Query($db_con,$sql);

	$pdf->SetFont(GOTHIC, 'B', 12);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//�ģ¤��ͤ�ɽ��
	//�Կ����ڡ����������Υڡ���ɽ���������ס���ס�����͡������
	$count = 0;
	$page_count = 1;
	$page_next = $page_max;
	$data_sub = array();
	$data_total = array();
	$goods = "";

	while($data_list = pg_fetch_array($result)){
		$count++;
	/**********************�إå�������**************************/
		//����ܤξ�硢�إå�����
		if($count == 1){
			//����å�̾����
			$shop = $data_list[6];
			//�إå���ɽ��
			Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);
		}
	/************************************************************/


	//*******************���ڡ�������*****************************

		//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
		if($page_next+1 == $count){
			$page_count++;
			$pdf->AddPage();

			//�إå���ɽ��
			Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);

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
				for($x=0;$x<5;$x++){
					//����̾
					if($x==0){
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
				$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
				//���׽����
				$data_sub = array();
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
			Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);

			//���κ���ɽ����
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

	//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, '', 9);

	//************************�ǡ���ɽ��***************************

		for($x=0;$x<5;$x++){
			//ɽ����
			$contents = "";
			//ɽ��line		
			$line = "";

			if($x==0 && $count == 1 || $space_flg == true){
				//������Ƚ��
				//�ڡ����κ���ɽ������
				$contents = $data_list[$x];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				$space_flg = false;
			}else if($x==0){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			}else{
				if(is_numeric($data_list[$x])){
					//�ͤ򾮷פ�­���Ƥ���
					$data_sub[$x] = $data_sub[$x] + $data_list[$x];
					$data_list[$x] = number_format($data_list[$x]);
				}
				$contents = $data_list[$x];
				$line = '1';
			}
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_list[$x], '1', '2', $data_align[$x]);
	}
//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(213,213,213);
	$count++;

	//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$page_count++;
		$pdf->AddPage();

		//�إå���ɽ��
		Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************�ǽ����׽���***********************************
		
	for($x=0;$x<5;$x++){
		//����̾
		if($x==0){
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
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
	//���׽����
	$data_sub = array();

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(145,145,145);
	$count++;

	//*******************���ڡ�������*****************************

	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$page_count++;
		$pdf->AddPage();

		//�إå���ɽ��
		Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//*************************��׽���*******************************

	for($x=0;$x<5;$x++){
		//���̾
		if($x==0){
			$pdf->Cell($list_sub[1][0], 14, $list_sub[1][1], '1', '0',$list_sub[1][2],'1');
		}else{
		//�����
			if(is_numeric($data_total[$x])){
				$data_total[$x] = number_format($data_total[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');

	//****************************************************************

}

$pdf->Output();

?>
