<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/22      11-021      ��          ɽ���ǡ����Υ��˥��������줹������
 *  2006/11/22      11-006      ��          �ǡ�����ɽ�������
 *
 *
 */

//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$shop_id      = $_SESSION["client_id"]; 

$goods_cd   = $_POST["form_goods_cd"];              //���ʥ�����
$goods_name = $_POST["form_goods_cname"];            //����̾
$ware_id    = $_POST["form_ware"];                  //�Ҹ�ID
if($_POST["form_hand_day"]["sy"] != NULL){
	$hand_day_s = $_POST["form_hand_day"]["sy"]."ǯ".$_POST["form_hand_day"]["sm"]."��".$_POST["form_hand_day"]["sd"]."��"; //�谷������
}
if($_POST["form_hand_day"]["ey"] != NULL){
	$hand_day_e = $_POST["form_hand_day"]["ey"]."ǯ".$_POST["form_hand_day"]["em"]."��".$_POST["form_hand_day"]["ed"]."��"; //�谷��λ��
}
//SQL����Ѥμ谷��
$hand_day_s2 = $_POST["form_hand_day"]["sy"]."-".$_POST["form_hand_day"]["sm"]."-".$_POST["form_hand_day"]["sd"]; 
$hand_day_e2 = $_POST["form_hand_day"]["ey"]."-".$_POST["form_hand_day"]["em"]."-".$_POST["form_hand_day"]["ed"]; 

/****************************/
//���顼�����å�(PHP)
/****************************/
//���谷������
//�����������������å�
if($_POST["form_hand_day"]["sy"] != null || $_POST["form_hand_day"]["sm"] != null || $_POST["form_hand_day"]["sd"] != null){
    $day_y = (int)$_POST["form_hand_day"]["sy"];
    $day_m = (int)$_POST["form_hand_day"]["sm"];
    $day_d = (int)$_POST["form_hand_day"]["sd"];
    if(!checkdate($day_m,$day_d,$day_y)){
		print "<font color=\"red\"><b><li>�谷���� �����դ������ǤϤ���ޤ���</b></font>";
	    exit;
    }
}

//���谷��λ��
//�����������������å�
/*
if($_POST["form_hand_day"]["ey"] != null || $_POST["form_hand_day"]["em"] != null || $_POST["form_hand_day"]["ed"] != null){
    $day_y = (int)$_POST["form_hand_day"]["ey"];
    $day_m = (int)$_POST["form_hand_day"]["em"];
    $day_d = (int)$_POST["form_hand_day"]["ed"];
    if(!checkdate($day_m,$day_d,$day_y)){
		print "<font color=\"red\"><b><li>�谷���� �����դ������ǤϤ���ޤ���</b></font>";
	    exit;
    }
}
*/
if ($_POST["form_hand_day"]["ey"] == null || $_POST["form_hand_day"]["em"] == null || $_POST["form_hand_day"]["ed"] == null){
    // ��ǯ�������Ƥ�NULL�פǤϤʤ����
    if (!($_POST["form_hand_day"]["ey"] == null && $_POST["form_hand_day"]["em"] == null && $_POST["form_hand_day"]["ed"] == null)){ 
        print "<font color=\"red\"><b><li>�谷���� �θ����ˤϡ�ǯ�סַ�ס����פ�����ɬ�����ϤǤ���</b></font>";
        exit;   
    }
}else{
    if (!ereg("^[0-9]+$", $_POST["form_hand_day"]["ey"]) ||
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["em"]) || 
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["ed"])){
        print "<font color=\"red\"><b><li>�谷���� �������ǤϤ���ޤ���</b></font>";
        exit;   
    }
    if(!checkdate((int)$_POST["form_hand_day"]["em"], (int)$_POST["form_hand_day"]["ed"], (int)$_POST["form_hand_day"]["ey"])){
        print "<font color=\"red\"><b><li>�谷���� �������ǤϤ���ޤ���</b></font>";
        exit;   
    }
}

//�����ʥ�����
//��Ⱦ�ѿ��������å�
if($goods_cd != null && !ereg("^[0-9]+$", $goods_cd)){
    print "<font color=\"red\"><b><li>���ʥ����� ��Ⱦ�ѿ����ΤߤǤ���</b></font>";
	exit;
}

//*********************************//
//Ģɼ�ι������ϲս�
//*********************************//
//;��
$left_margin = 40;
$top_margin = 40;

//�إå����Υե���ȥ�����
$font_size = 9;
//�ڡ���������
$page_size = 1110;

//A3
$pdf=new MBFPDF('L','pt','A3');

//�ڡ�������ɽ����
$page_max = 50;

//*********************************//
//�إå��������ϲս�
//*********************************//
//�����ȥ�
$title = "��ʧ���ٰ���ɽ";
$page_count = 1; 

//�谷���֤�ɽ�������ѹ�
if($hand_day_s == NULL && $hand_day_e == NULL){
    $time = "�谷���֡�����ʤ�";
}else{
	$time = "�谷���֡�$hand_day_s �� $hand_day_e";
}

//����̾������align
$list[0] = array("30","NO","C");
$list[1] = array("110","�Ҹ�","C");
$list[2] = array("300","����̾","C");
$list[3] = array("80","�谷��","C");
$list[4] = array("80","�����ʬ","C");
$list[5] = array("80","��ɼ�ֹ�","C");
$list[6] = array("190","��ʧ��","C");
$list[7] = array("80","���˿�","C");
$list[8] = array("80","�и˿�","C");
$list[9] = array("80","ñ��","C");

//*********************************//
//�ǡ����������ϲս�
//*********************************//
//�Ҹ˷ס�����
$list_sub[0] = array("30","","R");
$list_sub[1] = array("110","�Ҹ˷ס�","L");
$list_sub[2] = array("110","���ס�","L");
$list_sub[3] = array("300","","R");
$list_sub[4] = array("80","","L");
$list_sub[5] = array("80","","R");
$list_sub[6] = array("80","","R");
$list_sub[7] = array("190","","L");
$list_sub[8] = array("80","","R");
$list_sub[9] = array("80","","R");
$list_sub[10] = array("80","","C");

//���ʷ�
$list_sub2[0] = array("30","","R");
$list_sub2[1] = array("110","","C");
$list_sub2[2] = array("300","���ʷס�","L");
$list_sub2[3] = array("80","","R");
$list_sub2[4] = array("80","","L");
$list_sub2[5] = array("80","","R");
$list_sub2[6] = array("190","","L");
$list_sub2[7] = array("80","","R");
$list_sub2[8] = array("80","","R");
$list_sub2[9] = array("80","","C");

//align(�ǡ���)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "C";
$data_align[4] = "C";
$data_align[5] = "L";
$data_align[6] = "L";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "L";

//***********************
//���ϥǡ�������SQL���ϲս�
//***********************
//DB��³
$db_con = Db_Connect();

$sql .= "SELECT ";
$sql .= "    t_ware.ware_name,";
$sql .= "    t_goods.goods_name,";
$sql .= "    t_stock_hand.work_day,";
$sql .= "    CASE t_stock_hand.work_div";             
$sql .= "        WHEN '2' THEN '���'";
$sql .= "        WHEN '4' THEN '����'";
$sql .= "        WHEN '5' THEN '��ư'";
$sql .= "        WHEN '6' THEN 'Ĵ��'";
$sql .= "        WHEN '7' THEN '��Ω'";
$sql .= "    END,";
$sql .= "    t_stock_hand.slip_no,";
$sql .= "    t_client.client_name,";
$sql .= "    t_stock_hand.io_div,";
$sql .= "    t_stock_hand.num,";
$sql .= "    t_goods.unit ";
$sql .= "FROM ";
$sql .= "    t_stock_hand ";
$sql .= "    LEFT JOIN t_client ON t_client.client_id = t_stock_hand.client_id ";
$sql .= "    INNER JOIN t_ware ON t_ware.ware_id = t_stock_hand.ware_id ";
$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_stock_hand.goods_id ";
$sql .= "    LEFT JOIN t_g_product ON t_goods.goods_id = t_g_product.g_product_id ";
$sql .= "WHERE ";
$sql .= "    t_goods.stock_manage = '1' ";
$sql .= "AND ";
$sql .= "    t_stock_hand.shop_id = $shop_id ";
$sql .= "AND ";
$sql .= "    work_div NOT IN ('1','3') ";
//�谷���������ꤵ��Ƥ��뤫
if($_POST["form_hand_day"]["sy"] != NULL){
	$sql .= "    AND ";
	$sql .= "        t_stock_hand.work_day >= '$hand_day_s2' ";
}
if($_POST["form_hand_day"]["ey"] != NULL){
	$sql .= "    AND ";
	$sql .= "        t_stock_hand.work_day <= '$hand_day_e2' ";
}
//�Ҹ�ID�����ꤵ�줿���
if($ware_id != null){
    $sql .= "   AND ";
    $sql .= "   t_ware.ware_id = $ware_id ";
}
//���ʥ����ɤ����ꤵ�줿���
if($goods_cd != null){
    $sql .= "   AND ";
    $sql .= "   t_goods.goods_cd LIKE '$goods_cd%' ";
}
//����̾�����ꤵ�줿���
if($goods_name != null){
    $sql .= "   AND";
    $sql .= "   t_goods.goods_name LIKE '%$goods_name%' ";
}
$sql .= "ORDER BY ";
$sql .= "    t_g_product.g_product_cd, t_goods.goods_cd, t_stock_hand.work_day DESC, t_stock_hand.work_div, t_stock_hand.slip_no ";
$result = Db_Query($db_con, $sql);
$data_num = pg_num_rows($result);
$data_list = Get_Data($result, 2);

//***********************
//���Ͻ���
//***********************
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("�������Yǯm��d����H:i");
//�إå���ɽ��
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

$count = 0;                 //�Կ�
$page_next = $page_max;     //���Υڡ���ɽ����
$page_back = 0;             //���Υڡ���ɽ����
$ware = "";                 //�Ҹˤν�ʣ��
$goods = "";                //���ʤν�ʣ��
$in_count = 0;              //���˿��ι��
$out_count = 0;             //�и˿��ι��
$in_total = 0;              //���˿��������
$out_total = 0;             //�и˿��������

for($c=0;$c<$data_num;$c++){
	$count++;

	//***********************
	//���ڡ�������
	//***********************
	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ����ʷפξ�硢�Ҹ�̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

	//***********************
	//���ʷ׽���
	//***********************
	//�ͤ��Ѥ�ä���硢���ʷ�ɽ��
	if($goods != $data_list[$c][1]){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//�ͤξ�άȽ��ե饰
			$space_flg2 = true;
			for($x=0;$x<count($list_sub2)-1;$x++){
				//���ʷ׹��ֹ�
				if($x==0){
					$pdf->SetFont(GOTHIC, '', 8);
					$pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
					$pdf->SetFont(GOTHIC, 'B', 8);
				//�Ҹ�̾
				}else if($x==1){
					//���ڡ���������ΰ���ܤ������ʷפξ�硢�Ҹ�̾ɽ��
					if($page_back == $count){
						$pdf->SetFont(GOTHIC, '', 8);
						$pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
						$pdf->SetFont(GOTHIC, 'B', 8);
						//�Ҹˤ�ɽ�����������ϡ��ǡ������Ҹˤ��ά
						$goods_flg = true;
					}else if($page_next == $count){
						$pdf->SetFont(GOTHIC, '', 8);
						$pdf->Cell($list_sub2[$x][0], 14, '', 'LBR', '0','L','');
						$pdf->SetFont(GOTHIC, 'B', 8);
						$goods_flg = false;
					}else{
						$pdf->Cell($list_sub2[$x][0], 14, "", 'LR', '0','R','');
					}
				//���ʷ�̾
				}else if($x==2){
					$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2],'1');
				//���˿�
				}else if($x==7){
					$in_count = number_format($in_count);
					$pdf->Cell($list_sub2[$x][0], 14, $in_count, '1', '0',$list_sub2[$x][2],'1');
				//�и˿�
				}else if($x==8){
					$out_count = number_format($out_count);
					$pdf->Cell($list_sub2[$x][0], 14, $out_count, '1', '0',$list_sub2[$x][2],'1');
				}else{
					$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2],'1');
				}
			}
			//���ڡ�������ʬ����ɽ��
			$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '2',$list_sub2[$x][2],'1');

			$in_count = 0;
			$out_count = 0;
			$count++;
		}
		$goods = $data_list[$c][1];
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);

	//***********************
	//���ڡ�������
	//***********************
	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ����ʷפξ�硢�Ҹ�̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

	//***********************
	//�Ҹ˷׽���
	//***********************
	//�ͤ��Ѥ�ä���硢�Ҹ˷�ɽ��
	if($ware != $data_list[$c][0]){
		//����ܤϡ��ͤ򥻥åȤ������
		if($count != 1){
			$pdf->SetFillColor(180,180,180);
			//�ͤξ�άȽ��ե饰
			$space_flg = true;
			$goods_flg = false;
			for($x=0;$x<count($list_sub)-1;$x++){
				//�Ҹ˷׹��ֹ�
				if($x==0){
					$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
				//�Ҹ˷�̾
				}else if($x==1){
					$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
				//���˿�
				}else if($x==7){
					$in_sub = number_format($in_sub);
					$pdf->Cell($list_sub[$x][0], 14, $in_sub, '1', '0',$list_sub[$x][2],'1');
				//�и˿�
				}else if($x==8){
					$out_sub = number_format($out_sub);
					$pdf->Cell($list_sub[$x][0], 14, $out_sub, '1', '0',$list_sub[$x][2],'1');
				}else if($x!=2){
					$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
				}
			}
			//���ڡ�������ʬ����ɽ��
			$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '2',$list_sub[$x][2],'1');
		
			$in_sub  = 0;
			$out_sub = 0;
			$count++;
		}
		$ware = $data_list[$c][0];
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

	//***********************
	//���ڡ�������
	//***********************
	//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���ڡ��������ǽ�ιԤ����ʷפξ�硢�Ҹ�̾��ɽ��������٤ˡ����Υڡ�����ɽ����������
		$page_back = $page_next+1;
		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

	//***********************
	//�ǡ���ɽ������
	//***********************
	//���ֹ�
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	//�ǽ�Ϲ��ֹ��ɽ������١��ݥ��󥿤ϰ줫��Ϥ��
	for($x=1;$x<count($data_list[$c])+1;$x++){
		//ɽ����
		$contents = "";
		//ɽ��line
		$line = "";

		//�Ҹ�̾�ξ�άȽ��
		//���ʷפ��Ҹˤ�ɽ�������Ƥ��ʤ������ġ�����ܤ����פθ�ξ��ϡ���ά���ʤ���
		if($x==1 && $goods_flg == false && ($count == 1 || $space_flg == true)){
			//������Ƚ��
			//�ڡ����κ���ɽ������
			$contents = $data_list[$c][$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LR';
			}
			//���ʷפ�ɽ���������Ҹ�̾������
			$customer = $data_list[$c][$x-1];
			//�Ҹ�̾���ά����
			$space_flg = false;
			$goods_flg = false;
		//���ʷפ��Ҹˤ�ɽ�����ޤ��ϡ������Ҹˤ�ɽ����������
		}else if($x==1){
			//�ڡ����κ���ɽ������
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
			$customer = $data_list[$c][$x-1];
		//����ܤ����ʷפθ�ʳ����ͤξ�ά
		}else if($x==2 && ($count == 1 || $space_flg2 == true)){
			//������Ƚ��
			//�ڡ����κ���ɽ������
			$contents = $data_list[$c][$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//��ά����
			$space_flg2 = false;
		//���˾���̾��ɽ�����Ƥ��롣
		}else if($x==2){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//���и˶�ʬ
		}else if($x==7){
			$in_put_flg = NULL;
			$out_put_flg = NULL;
			//���ˡ��и�Ƚ��
			if($data_list[$c][$x-1] == '1'){
				//����
				$in_put_flg = true;
			}else{
				//�и�
				$out_put_flg = true;
			}
		//���˿����и˿�
		}else if($x==8){
			//���˿����и˿��׻�Ƚ��
			if($in_put_flg == true){
				//���˿��׻�
				$in_count = $in_count + $data_list[$c][$x-1];    //���ʷ���
				$in_sub   = $in_sub + $data_list[$c][$x-1];      //�Ҹ˷���
				$in_total = $in_total + $data_list[$c][$x-1];    //������
			}else if($out_put_flg == true){
				//�и˿��׻�
				$out_count = $out_count + $data_list[$c][$x-1];  //���ʷ���
				$out_sub   = $out_sub + $data_list[$c][$x-1];    //�Ҹ˷���
				$out_total = $out_total + $data_list[$c][$x-1];  //������
			}
			$data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
			$contents = $data_list[$c][$x-1];
			$line = '1';
		}else{
			$contents = $data_list[$c][$x-1];
			$line = '1';
		}
		//���и˶�ʬ�ʳ�ɽ��
		if($x != 7){
			//ñ�̤�ɽ��������ϡ�����
			if($x==9){
				$pdf->Cell($list[$x][0], 14, $contents, $line, '2', $data_align[9]);
			//���ˡ��и˿��ϥǡ������Ф�����Ԥ���١����줾��ɽ��
			}else if($x==8){
				if($in_put_flg == true){
					$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[7]);
					$pdf->Cell($list[$x+1][0], 14, "", $line, '0', $data_align[8]);
				}else if($out_put_flg == true){
					$pdf->Cell($list[$x][0], 14, "", $line, '0', $data_align[7]);
					$pdf->Cell($list[$x+1][0], 14, $contents, $line, '0', $data_align[8]);
				}
			}else{
				$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
			}
		}
	}
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(220,220,220);
$count++;

//***********************
//���ڡ�������
//***********************
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
if($page_next+1 == $count){
	$pdf->AddPage();
	$page_count++;
	//�إå���ɽ��
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

	//���ڡ��������ǽ�ιԤ����ʷפξ�硢�Ҹ�̾ɽ��������٤ˡ����Υڡ�����ɽ����������
	$page_back = $page_next+1;
	//���κ���ɽ����
	$page_next = $page_max * $page_count;
	$space_flg = true;
	$space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//���ʷ׽���
//***********************
$pdf->SetFillColor(220,220,220);
//�ͤξ�άȽ��ե饰
$space_flg2 = true;
for($x=0;$x<count($list_sub2)-1;$x++){
	//���ʷ׹��ֹ�
	if($x==0){
		$pdf->SetFont(GOTHIC, '', 8);
		$pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
		$pdf->SetFont(GOTHIC, 'B', 8);
	//�Ҹ�̾
	}else if($x==1){
		//���ڡ���������ΰ���ܤ������ʷפξ�硢�Ҹ�̾ɽ��
		if($page_back == $count){
			$pdf->SetFont(GOTHIC, '', 8);
			$pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
			$pdf->SetFont(GOTHIC, 'B', 8);
			//�Ҹˤ�ɽ�����������ϡ��ǡ������Ҹˤ��ά
			$goods_flg = true;
		}else if($page_next == $count){
			$pdf->SetFont(GOTHIC, '', 8);
			$pdf->Cell($list_sub2[$x][0], 14, '', 'LBR', '0','L','');
			$pdf->SetFont(GOTHIC, 'B', 8);
			$goods_flg = false;
		}else{
			$pdf->Cell($list_sub2[$x][0], 14, "", 'LR', '0','R','');
		}
	//���ʷ�̾
	}else if($x==2){
		$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2],'1');
	//���˿�
	}else if($x==7){
		$in_count = number_format($in_count);
		$pdf->Cell($list_sub2[$x][0], 14, $in_count, '1', '0',$list_sub2[$x][2],'1');
	//�и˿�
	}else if($x==8){
		$out_count = number_format($out_count);
		$pdf->Cell($list_sub2[$x][0], 14, $out_count, '1', '0',$list_sub2[$x][2],'1');
	}else{
		$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2],'1');
	}
}
//���ڡ�������ʬ����ɽ��
$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '2',$list_sub2[$x][2],'1');

$in_count = 0;
$out_count = 0;

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//***********************
//���ڡ�������
//***********************	
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
if($page_next+1 == $count){
	$pdf->AddPage();
	$page_count++;
	//�إå���ɽ��
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

	//���ڡ��������ǽ�ιԤ����ʷפξ�硢�Ҹ�̾ɽ��������٤ˡ����Υڡ�����ɽ����������
	$page_back = $page_next+1;
	//���κ���ɽ����
	$page_next = $page_max * $page_count;
	$space_flg = true;
	$space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//�ǽ��Ҹ˷׽���
//***********************	
$pdf->SetFillColor(180,180,180);
//�ͤξ�άȽ��ե饰
$space_flg = true;
$goods_flg = false;
for($x=0;$x<count($list_sub)-1;$x++){
	//�Ҹ˷׹��ֹ�
	if($x==0){
		$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
	//�Ҹ˷�̾
	}else if($x==1){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
	//���˿�
	}else if($x==8){
		$in_sub = number_format($in_sub);
		$pdf->Cell($list_sub[$x][0], 14, $in_sub, '1', '0',$list_sub[$x][2],'1');
	//�и˿�
	}else if($x==9){
		$out_sub = number_format($out_sub);
		$pdf->Cell($list_sub[$x][0], 14, $out_sub, '1', '0',$list_sub[$x][2],'1');
	}else if($x!=2){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
	}
}
//���ڡ�������ʬ����ɽ��
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '2',$list_sub[$x][2],'1');

$in_sub  = 0;
$out_sub = 0;

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//***********************
//���ڡ�������
//***********************	
//���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
if($page_next+1 == $count){
	$pdf->AddPage();
	$page_count++;
	//�إå���ɽ��
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

	//���ڡ��������ǽ�ιԤ����ʷפξ�硢�Ҹ�̾ɽ��������٤ˡ����Υڡ�����ɽ����������
	$page_back = $page_next+1;
	//���κ���ɽ����
	$page_next = $page_max * $page_count;
	$space_flg = true;
	$space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//���׽���
//***********************	
$pdf->SetFillColor(145,145,145);
//�ͤξ�άȽ��ե饰
$space_flg = true;
$goods_flg = false;
for($x=0;$x<count($list_sub)-1;$x++){
	//�Ҹ˷׹��ֹ�
	if($x==0){
		$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
	//����̾
	}else if($x==2){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
	//���˿�
	}else if($x==8){
		$in_total = number_format($in_total);
		$pdf->Cell($list_sub[$x][0], 14, $in_total, '1', '0',$list_sub[$x][2],'1');
	//�и˿�
	}else if($x==9){
		$out_total = number_format($out_total);
		$pdf->Cell($list_sub[$x][0], 14, $out_total, '1', '0',$list_sub[$x][2],'1');
	}else if($x!=1){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
	}
}
//���ڡ�������ʬ����ɽ��
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '2',$list_sub[$x][2],'1');

$in_sub  = 0;
$out_sub = 0;
$count++;

//����
$pdf->Output();

?>
