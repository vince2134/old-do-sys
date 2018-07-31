<?php
/********************
 * Ǽ�ʽ�ץ�ӥ塼
 *
 *
 * �ѹ�����
 * ��2006-11-01 Ǽ�ʽ�ο��ѹ�
 *
 ********************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2007/02/02��    �������� watanabe-k�� ���ΰ��֤��ѹ�
 *
 */


require_once("ENV_local.php");
require(FPDF_DIR);
$pdf=new MBFPDF('P','pp','a4');
$pdf->SetProtection(array('print', 'copy'));
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(MINCHO ,'SJIS');
$pdf->SetAutoPageBreak(false);

//DB��³
$db_con = Db_Connect();

$pdf->AddPage();

/****************************/
//�����ѿ�����
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];

$photo = COMPANY_SEAL_DIR.$shop_id.".jpg";    //�Ұ��Υե�����̾���������ô����Ź�Ρ�
$photo_exists = file_exists($photo);                    //�Ұ���¸�ߤ��뤫�ե饰

/****************************/
//Ǽ�ʽ񥳥�������
/****************************/
$sql  = "SELECT ";
$sql .= "    d_memo1, ";		//Ǽ�ʽ񥳥���1
$sql .= "    d_memo2, ";		//Ǽ�ʽ񥳥���2
$sql .= "    d_memo3 ";			//Ǽ�ʽ񥳥���3
$sql .= "FROM ";
$sql .= "    t_h_ledger_sheet;";
$result = Db_Query($db_con,$sql);
$d_memo = Get_Data($result,2);

/****************************/
//Ǽ�ʽ��������
/****************************/
$left_margin = 45;
//$posY = 18;
$posY = 11;

//��������
$pdf->SetLineWidth(0.2);
//���ο�
//$pdf->SetDrawColor(29,0,120);
$pdf->SetDrawColor(153,102,0);

//�ե��������
$pdf->SetFont(GOTHIC,'', 9);
//�ƥ����Ȥο�
//$pdf->SetTextColor(61,1,255); 
$pdf->SetTextColor(153,102,0); 

//�طʿ�
//$pdf->SetFillColor(200,230,255);
$pdf->SetFillColor(240,230,140);

//$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+330, $posY+30,56,18);

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(60, 12,'�����ͥ�����No.', '0', '1', 'C','0');
$pdf->SetXY($left_margin+70, $posY+10);
$pdf->Cell(100, 12,$code, '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

//͹���ֹ�
$pdf->SetFont(GOTHIC,'', 9.5);
$pdf->SetXY($left_margin+10, $posY+25);
$pdf->Cell(15, 12,'��', '0', '1', 'L','0');
$pdf->SetXY($left_margin+25, $posY+25);
$pdf->Cell(50, 12,$post, '0', '1', 'L','0');

//���ꡦ��̾
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+15, $posY+38);
$pdf->Cell(50, 12,$address1, '0', '1', 'L','0');
$pdf->SetXY($left_margin+15, $posY+50);
$pdf->Cell(50, 12,$address2, '0', '1', 'L','0');
$pdf->SetXY($left_margin+15, $posY+62);
$pdf->Cell(50, 12,$address3, '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'', 11);
$pdf->SetXY($left_margin+20, $posY+77);
$pdf->Cell(50, 12,$company, '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+92);
$pdf->Cell(50, 12,$company2, '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(153,102,0); 

$pdf->SetFont(GOTHIC,'', 10);
$pdf->SetXY($left_margin+214, $posY+5);
$pdf->Cell(160, 15,'Ǽ�����ʡ����� ��(��)', '1', '1', 'C','1');

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+392, $posY+7);
$pdf->Cell(20, 12,$date_y, '0', '1', 'C','0');
$pdf->SetXY($left_margin+412, $posY+7);
$pdf->Cell(12, 12,'ǯ', '0', '1', 'C','0');
$pdf->SetXY($left_margin+424, $posY+7);
$pdf->Cell(12, 12,$date_m, '0', '1', 'C','0');
$pdf->SetXY($left_margin+436, $posY+7);
$pdf->Cell(12, 12,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+448, $posY+7);
$pdf->Cell(12, 12,$date_d, '0', '1', 'C','0');
$pdf->SetXY($left_margin+460, $posY+7);
$pdf->Cell(12, 12,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+487, $posY+7);
$pdf->Cell(33, 12,'��ɼNo.', '0', '1', 'R','0');
$pdf->SetXY($left_margin+520, $posY+7);
$pdf->Cell(50, 12,$slip.$branch_no, '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

$pdf->SetFont(GOTHIC,'B', 10.5);
$pdf->SetXY($left_margin+400, $posY+34);
$pdf->Cell(45, 12,'�������', '0', '1', 'C','0');
$pdf->SetFont(GOTHIC,'B', 15);
$pdf->SetXY($left_margin+453, $posY+32);
$pdf->Cell(115,14,'�� �� �� �� ��', '0','1', 'C','0');
$pdf->SetFont(MINCHO,'B', 7);
$pdf->SetXY($left_margin+422, $posY+51);
$pdf->Cell(37,12,'��ɽ������', '0','1', 'R','0');
$pdf->SetFont(MINCHO,'B', 9);
$pdf->SetXY($left_margin+459, $posY+50);
$pdf->Cell(110,14,'�� ���� ��Τ ����', '0','1', 'C','0');

$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+415, $posY+68);
$pdf->Cell(174,8,$d_memo[0][0], '0','1', 'L','0');

$pdf->SetXY($left_margin+415, $posY+77);
$pdf->Cell(174,8,$d_memo[0][1], '0','1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(153,102,0); 

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+332, $posY+90);
$pdf->Cell(40, 12,'ô���� : ', '0', '1', 'C','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

$pdf->SetFont(GOTHIC,'', 10);
$pdf->SetXY($left_margin+367, $posY+90);
$pdf->Cell(188, 12,$charge, 'B', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(153,102,0); 

$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+330, $posY+109);
$pdf->Cell(250, 10,'���٤��꤬�Ȥ��������ޤ����������̤�Ǽ���פ��ޤ��ΤǸ溺����������', '0', '1', 'R','0');

//��������
$pdf->SetLineWidth(0.8);
//$pdf->RoundedRect(55, 138, 575, 115, 5, 'FD',1234);
$pdf->RoundedRect($left_margin+10, $posY+120 , 575, 115, 5, 'FD',1234);

//��������
$pdf->SetLineWidth(0.2);
//$pdf->RoundedRect(55, 138, 575, 10, 5, 'FD',12);
$pdf->RoundedRect($left_margin+10, $posY+120, 575, 10, 5, 'FD',12);
$pdf->SetXY($left_margin+10, $posY+120);
$pdf->Cell(219, 10,'���������ɡ�/���� �� �� �� ̾', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+229, $posY+120);
$pdf->Cell(74, 10,'������ ��', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+303, $posY+120);
$pdf->Cell(30, 10,'ñ ��', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+333, $posY+120);
$pdf->Cell(89, 10,'ñ��������', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+422, $posY+120);
$pdf->Cell(96, 10,'�⡡���� ��', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+120);
$pdf->Cell(67, 10,'��������', '0', '1', 'C','0');

//�طʿ�
$pdf->SetFillColor(255);
//$pdf->RoundedRect(55, 148, 575, 105, 5, 'FD',34);
$pdf->RoundedRect($left_margin+10, $posY+130, 575, 105, 5, 'FD',34);


//��������
$pdf->SetLineWidth(0.8);
//$pdf->RoundedRect(378, 254, 185, 47, 5, 'FD',34);
$pdf->RoundedRect($left_margin+333, $posY+236, 185, 47, 5, 'FD',34);

$pdf->SetFont(GOTHIC,'', 8);
//��������
$pdf->SetLineWidth(0.2);

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

//���ʥǡ����Կ�����
$height = array('130','151','172','193','214');
for($x=0;$x<5;$x++){
	$pdf->SetXY($left_margin+10, $posY+$height[$x]);
	if($x==5-1){
		$pdf->Cell(219, 21,'', 'TR', '1', 'C','0');
	}else{
		$pdf->Cell(219, 21,'', '1', '1', 'C','0');
	}
	$pdf->SetXY($left_margin+229, $posY+$height[$x]);
	$pdf->Cell(74, 21,'', '1', '1', 'C','0');

	$pdf->SetXY($left_margin+303, $posY+$height[$x]);
	$pdf->Cell(30, 21,'', '1', '1', 'C','0');
	$pdf->SetXY($left_margin+333, $posY+$height[$x]);
	$pdf->Cell(89, 21,'', '1', '1', 'C','0');
	
	$pdf->SetXY($left_margin+422, $posY+$height[$x]);
	$pdf->Cell(96, 21,'', '1', '1', 'C','0');

	$pdf->SetXY($left_margin+518, $posY+$height[$x]);
	if($x==5-1){
		$pdf->Cell(67, 21,'', 'TL', '1', 'C','0');
	}else{
		$pdf->Cell(67, 21,'', '1', '1', 'C','0');
	}
}

//�طʿ�
//$pdf->SetFillColor(200,230,255);
$pdf->SetFillColor(240,230,140);

//$pdf->RoundedRect(378, 253, 89, 48, 5, 'FD',4);
$pdf->RoundedRect($left_margin+333, $posY+235, 89, 48, 5, 'FD',4);
//�طʿ�
$pdf->SetFillColor(255);
//$pdf->RoundedRect(467, 253, 96, 48, 5, 'FD',3);
$pdf->RoundedRect($left_margin+422, $posY+235, 96, 48, 5, 'FD',3);

//�ƥ����Ȥο�
$pdf->SetTextColor(153,102,0); 

//��ȴ���
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+333, $posY+235);
$pdf->Cell(89, 16,'��������', 'RB', '1', 'C','0');
$pdf->SetXY($left_margin+422, $posY+235);
$pdf->Cell(96, 16,'', 'B', '1', 'C','0');

//������
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+333, $posY+251);
$pdf->Cell(89, 16,'�á�����', 'RB', '1', 'C','0');
$pdf->SetXY($left_margin+422, $posY+251);
$pdf->Cell(96, 16,"", 'B', '1', 'C','0');

//�ǹ����
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+333, $posY+267);
$pdf->Cell(89, 16,'�硡����', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+422, $posY+267);	
$pdf->Cell(96, 16,"", '0', '1', 'C','0');

/*
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+47, $posY+247);
$pdf->Cell(40, 12,'Ŧ �� '.$d_memo[0][2], '0', '1', 'L','0');
$pdf->Line($left_margin+78,$posY+259,$left_margin+255,$posY+259);
*/
//Ŧ��
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+10, $posY+240);
$pdf->Cell(10, 12,'�� �� ', '0', '1', 'L','0');
$pdf->SetTextColor(0,0,0);
$pdf->RoundedRect($left_margin+10, $posY+250, 300, 33, 5, 'FD',1234);
$pdf->SetXY($left_margin+10, $posY+253);
$pdf->MultiCell(300, 10,Textarea_Non_Break($d_memo[0][2],3), '0', '1', '','0');


$pdf->SetXY($left_margin+525, $posY+238);
$pdf->Cell(33, 28,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+558, $posY+238);
$pdf->Cell(33, 28,'', '1', '1', 'C','0');

//��
$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+540, $posY+270,56,18);

/*************************************/
//Ǽ�ʽ�
/*************************************/
//$posY = 327;
$posY = 315;

//��������
$pdf->SetLineWidth(0.2);
//���ο�
//$pdf->SetDrawColor(14,104,20);
$pdf->SetDrawColor(129,53,255);

//�ե��������
$pdf->SetFont(GOTHIC,'', 9);
//�ƥ����Ȥο�
//$pdf->SetTextColor(18,133,25); 
$pdf->SetTextColor(129,53,255); 

//�طʿ�
//$pdf->SetFillColor(198,246,195);
$pdf->SetFillColor(238,227,255);

//$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+330, $posY+42,56,18);

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(60, 12,'�����ͥ�����No.', '0', '1', 'C','0');
$pdf->SetXY($left_margin+70, $posY+10);
$pdf->Cell(100, 12,$code, '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0);

//͹���ֹ�
$pdf->SetFont(GOTHIC,'', 9.5);
$pdf->SetXY($left_margin+10, $posY+25);
$pdf->Cell(15, 12,'��', '0', '1', 'L','0');
$pdf->SetXY($left_margin+25, $posY+25);
$pdf->Cell(50, 12,$post, '0', '1', 'L','0');

//���ꡦ��̾
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+15, $posY+38);
$pdf->Cell(50, 12,$address1, '0', '1', 'L','0');
$pdf->SetXY($left_margin+15, $posY+50);
$pdf->Cell(50, 12,$address2, '0', '1', 'L','0');
$pdf->SetXY($left_margin+15, $posY+62);
$pdf->Cell(50, 12,$address3, '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'', 11);
$pdf->SetXY($left_margin+20, $posY+77);
$pdf->Cell(50, 12,$company, '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+92);
$pdf->Cell(50, 12,$company2, '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(129,53,255); 

$pdf->SetFont(GOTHIC,'', 10);
$pdf->SetXY($left_margin+214, $posY+5);
$pdf->Cell(160, 15,'Ǽ�� ���ʡ� ����', '1', '1', 'C','1');

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+392, $posY+7);
$pdf->Cell(20, 12,$date_y, '0', '1', 'C','0');
$pdf->SetXY($left_margin+412, $posY+7);
$pdf->Cell(12, 12,'ǯ', '0', '1', 'C','0');
$pdf->SetXY($left_margin+424, $posY+7);
$pdf->Cell(12, 12,$date_m, '0', '1', 'C','0');
$pdf->SetXY($left_margin+436, $posY+7);
$pdf->Cell(12, 12,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+448, $posY+7);
$pdf->Cell(12, 12,$date_d, '0', '1', 'C','0');
$pdf->SetXY($left_margin+460, $posY+7);
$pdf->Cell(12, 12,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+487, $posY+7);
$pdf->Cell(33, 12,'��ɼNo.', '0', '1', 'R','0');
$pdf->SetXY($left_margin+520, $posY+7);
$pdf->Cell(50, 12,$slip.$branch_no, '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0);

if($photo_exists){
    $pdf->Image($photo,$left_margin+480, $posY+35,52);
}


$pdf->SetFont(GOTHIC,'B', 10.5);
$pdf->SetXY($left_margin+400, $posY+34);
$pdf->Cell(45, 12,'�������', '0', '1', 'C','0');
$pdf->SetFont(GOTHIC,'B', 15);
$pdf->SetXY($left_margin+453, $posY+32);
$pdf->Cell(115,14,'�� �� �� �� ��', '0','1', 'C','0');
$pdf->SetFont(MINCHO,'B', 7);
$pdf->SetXY($left_margin+422, $posY+51);
$pdf->Cell(37,12,'��ɽ������', '0','1', 'R','0');
$pdf->SetFont(MINCHO,'B', 9);
$pdf->SetXY($left_margin+459, $posY+50);
$pdf->Cell(110,14,'�� ���� ��Τ ����', '0','1', 'C','0');

$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+415, $posY+68);
$pdf->Cell(174,8,$d_memo[0][0], '0','1', 'L','0');

$pdf->SetXY($left_margin+415, $posY+77);
$pdf->Cell(174,8,$d_memo[0][1], '0','1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(129,53,255); 

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+332, $posY+90);
$pdf->Cell(40, 12,'ô���� : ', '0', '1', 'C','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

$pdf->SetFont(GOTHIC,'', 10);
$pdf->SetXY($left_margin+367, $posY+90);
$pdf->Cell(188, 12,$charge, 'B', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(129,53,255); 

$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+330, $posY+109);
$pdf->Cell(250, 10,'���٤��꤬�Ȥ��������ޤ����������̤�Ǽ���פ��ޤ��ΤǸ溺����������', '0', '1', 'R','0');

//��������
$pdf->SetLineWidth(0.8);
//$pdf->RoundedRect(55, 447, 575, 115, 5, 'FD',1234);
$pdf->RoundedRect($left_margin+10, $posY+120, 575, 115, 5, 'FD',1234);

//��������
$pdf->SetLineWidth(0.2);
//$pdf->RoundedRect(55, 447, 575, 10, 5, 'FD',12);
$pdf->RoundedRect($left_margin+10, $posY+120, 575, 10, 5, 'FD',12);
$pdf->SetXY($left_margin+10, $posY+120);
$pdf->Cell(219, 10,'���������ɡ�/���� �� �� �� ̾', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+229, $posY+120);
$pdf->Cell(74, 10,'������ ��', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+303, $posY+120);
$pdf->Cell(30, 10,'ñ ��', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+333, $posY+120);
$pdf->Cell(89, 10,'ñ��������', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+422, $posY+120);
$pdf->Cell(96, 10,'�⡡���� ��', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+120);
$pdf->Cell(67, 10,'��������', '0', '1', 'C','0');

//�طʿ�
$pdf->SetFillColor(255);
//$pdf->RoundedRect(55, 457, 575, 105, 5, 'FD',34);
$pdf->RoundedRect($left_margin+10, $posY+130, 575, 105, 5, 'FD',34);

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

//��������
$pdf->SetLineWidth(0.8);
//$pdf->RoundedRect(378, 563, 185, 47, 5, 'FD',34);
$pdf->RoundedRect($left_margin+333, $posY+236, 185, 47, 5, 'FD',34);
$pdf->SetFont(GOTHIC,'', 8);
//��������
$pdf->SetLineWidth(0.2);
//���ʥǡ����Կ�����
$height = array('130','151','172','193','214');
for($x=0;$x<5;$x++){
	$pdf->SetXY($left_margin+10, $posY+$height[$x]);
	if($x==5-1){
		$pdf->Cell(219, 21,'', 'TR', '1', 'C','0');
	}else{
		$pdf->Cell(219, 21,'', '1', '1', 'C','0');
	}
	$pdf->SetXY($left_margin+229, $posY+$height[$x]);
	$pdf->Cell(74, 21,'', '1', '1', 'C','0');

	$pdf->SetXY($left_margin+303, $posY+$height[$x]);
	$pdf->Cell(30, 21,'', '1', '1', 'C','0');
	$pdf->SetXY($left_margin+333, $posY+$height[$x]);
	$pdf->Cell(89, 21,'', '1', '1', 'C','0');
	
	$pdf->SetXY($left_margin+422, $posY+$height[$x]);
	$pdf->Cell(96, 21,'', '1', '1', 'C','0');

	$pdf->SetXY($left_margin+518, $posY+$height[$x]);
	if($x==5-1){
		$pdf->Cell(67, 21,'', 'TL', '1', 'C','0');
	}else{
		$pdf->Cell(67, 21,'', '1', '1', 'C','0');
	}
}

//�طʿ�
//$pdf->SetFillColor(198,246,195);
$pdf->SetFillColor(238,227,255);

//$pdf->RoundedRect(378, 562, 89, 48, 5, 'FD',4);
$pdf->RoundedRect($left_margin+333, $posY+235, 89, 48, 5, 'FD',4);
//�طʿ�
$pdf->SetFillColor(255);
//$pdf->RoundedRect(467, 562, 96, 48, 5, 'FD',3);
$pdf->RoundedRect($left_margin+422, $posY+235, 96, 48, 5, 'FD',3);

//�ƥ����Ȥο�
$pdf->SetTextColor(129,53,255); 

//��ȴ���
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+333, $posY+235);
$pdf->Cell(89, 16,'��������', 'RB', '1', 'C','0');
$pdf->SetXY($left_margin+422, $posY+235);
$pdf->Cell(96, 16,'', 'B', '1', 'C','0');

//������
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+333, $posY+251);
$pdf->Cell(89, 16,'�á�����', 'RB', '1', 'C','0');
$pdf->SetXY($left_margin+422, $posY+251);
$pdf->Cell(96, 16,"", 'B', '1', 'C','0');

//�ǹ����
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+333, $posY+267);
$pdf->Cell(89, 16,'�硡����', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+422, $posY+267);	
$pdf->Cell(96, 16,"", '0', '1', 'C','0');

/*
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+47, $posY+247);
$pdf->Cell(40, 12,'Ŧ �� '.$d_memo[0][2], '0', '1', 'L','0');
$pdf->Line($left_margin+78,$posY+259,$left_margin+255,$posY+259);
*/

//Ŧ��
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+10, $posY+240);
$pdf->Cell(10, 12,'�� �� ', '0', '1', 'L','0');
$pdf->SetTextColor(0,0,0);
$pdf->RoundedRect($left_margin+10, $posY+250, 300, 33, 5, 'FD',1234);
$pdf->SetXY($left_margin+10, $posY+253);
$pdf->MultiCell(300, 10,Textarea_Non_Break($d_memo[0][2],3), '0', '1', '','0');



$pdf->SetXY($left_margin+525, $posY+238);
$pdf->Cell(33, 28,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+558, $posY+238);
$pdf->Cell(33, 28,'', '1', '1', 'C','0');

//��
$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+540, $posY+270,56,18);


/**********************************/
//�вٰ����
/**********************************/
//$posY = 637;
$posY = 625;

//��������
$pdf->SetLineWidth(0.2);
//���ο�
$pdf->SetDrawColor(238,0,14);
//�ե��������
$pdf->SetFont(GOTHIC,'', 9);
//�ƥ����Ȥο�
$pdf->SetTextColor(255,0,16); 
//�طʿ�
$pdf->SetFillColor(255,204,207);

//$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+330, $posY+42,56,18);
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(60, 12,'�����ͥ�����No.', '0', '1', 'C','0');
$pdf->SetXY($left_margin+70, $posY+10);
$pdf->Cell(100, 12,$code, '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

//͹���ֹ�
$pdf->SetFont(GOTHIC,'', 9.5);
$pdf->SetXY($left_margin+10, $posY+25);
$pdf->Cell(15, 12,'��', '0', '1', 'L','0');
$pdf->SetXY($left_margin+25, $posY+25);
$pdf->Cell(50, 12,$post, '0', '1', 'L','0');

//���ꡦ��̾
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+15, $posY+38);
$pdf->Cell(50, 12,$address1, '0', '1', 'L','0');
$pdf->SetXY($left_margin+15, $posY+50);
$pdf->Cell(50, 12,$address2, '0', '1', 'L','0');
$pdf->SetXY($left_margin+15, $posY+62);
$pdf->Cell(50, 12,$address3, '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'', 11);
$pdf->SetXY($left_margin+20, $posY+77);
$pdf->Cell(50, 12,$company, '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+92);
$pdf->Cell(50, 12,$company2, '0', '1', 'L','0');


//�ƥ����Ȥο�
$pdf->SetTextColor(255,0,16); 

$pdf->SetFont(GOTHIC,'', 10);
$pdf->SetXY($left_margin+214, $posY+5);
$pdf->Cell(160, 15,'�С��١��ơ��⡡��', '1', '1', 'C','1');

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+392, $posY+7);
$pdf->Cell(20, 12,$date_y, '0', '1', 'C','0');
$pdf->SetXY($left_margin+412, $posY+7);
$pdf->Cell(12, 12,'ǯ', '0', '1', 'C','0');
$pdf->SetXY($left_margin+424, $posY+7);
$pdf->Cell(12, 12,$date_m, '0', '1', 'C','0');
$pdf->SetXY($left_margin+436, $posY+7);
$pdf->Cell(12, 12,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+448, $posY+7);
$pdf->Cell(12, 12,$date_d, '0', '1', 'C','0');
$pdf->SetXY($left_margin+460, $posY+7);
$pdf->Cell(12, 12,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+487, $posY+7);
$pdf->Cell(33, 12,'��ɼNo.', '0', '1', 'R','0');
$pdf->SetXY($left_margin+520, $posY+7);
$pdf->Cell(50, 12,$slip.$branch_no, '0', '1', 'L','0');

if($photo_exists){
    $pdf->Image($photo,$left_margin+480, $posY+35,52);
}

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

$pdf->SetFont(GOTHIC,'B', 10.5);
$pdf->SetXY($left_margin+400, $posY+34);
$pdf->Cell(45, 12,'�������', '0', '1', 'C','0');
$pdf->SetFont(GOTHIC,'B', 15);
$pdf->SetXY($left_margin+453, $posY+32);
$pdf->Cell(115,14,'�� �� �� �� ��', '0','1', 'C','0');
$pdf->SetFont(MINCHO,'B', 7);
$pdf->SetXY($left_margin+422, $posY+51);
$pdf->Cell(37,12,'��ɽ������', '0','1', 'R','0');
$pdf->SetFont(MINCHO,'B', 9);
$pdf->SetXY($left_margin+459, $posY+50);
$pdf->Cell(110,14,'�� ���� ��Τ ����', '0','1', 'C','0');

$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+415, $posY+68);
$pdf->Cell(174,8,$d_memo[0][0], '0','1', 'L','0');

$pdf->SetXY($left_margin+415, $posY+77);
$pdf->Cell(174,8,$d_memo[0][1], '0','1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(255,0,16); 

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+332, $posY+90);
$pdf->Cell(40, 12,'ô���� : ', '0', '1', 'C','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0);

$pdf->SetFont(GOTHIC,'', 10);
$pdf->SetXY($left_margin+367, $posY+90);
$pdf->Cell(188, 12,$charge, 'B', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(255,0,16); 

$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+376, $posY+109);
$pdf->Cell(150, 10,'���٤��꤬�Ȥ��������ޤ����������̤�в��פ��ޤ�����', '0', '1', 'R','0');


//��������
$pdf->SetLineWidth(0.8);
//$pdf->RoundedRect(55, 757, 575, 115, 5, 'FD',1234);
$pdf->RoundedRect($left_margin+10, $posY+120, 575, 115, 5, 'FD',1234);

//��������
        $pdf->SetLineWidth(0.2);
//        $pdf->RoundedRect(55, 757, 575, 10, 5, 'FD',12);
        $pdf->RoundedRect($left_margin+10, $posY+120, 575, 10, 5, 'FD',12);
        $pdf->SetXY($left_margin+10, $posY+120);
        $pdf->Cell(219, 10,'���������ɡ�/���� �� �� �� ̾', 'R', '1', 'C','0');
        $pdf->SetXY($left_margin+229, $posY+120);
        $pdf->Cell(74, 10,'������ ��', 'R', '1', 'C','0');
        $pdf->SetXY($left_margin+303, $posY+120);
        $pdf->Cell(30, 10,'ñ ��', 'R', '1', 'C','0');
        $pdf->SetXY($left_margin+333, $posY+120);
        $pdf->Cell(252, 10,'ľ����������������', '0', '1', 'C','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

//�طʿ�
$pdf->SetFillColor(255);
//$pdf->RoundedRect(55, 767, 575, 105, 5, 'FD',34);
$pdf->RoundedRect($left_margin+10, $posY+130, 575, 105, 5, 'FD',34);
$pdf->SetFont(GOTHIC,'', 8);
//��������
$pdf->SetLineWidth(0.2);
//���ʥǡ����Կ�����
$height = array('130','151','172','193','214');
for($x=0;$x<5;$x++){
	$pdf->SetXY($left_margin+10, $posY+$height[$x]);
	if($x==5-1){
		$pdf->Cell(219, 21,'', 'TR', '1', 'C','0');
	}else{
		$pdf->Cell(219, 21,'', '1', '1', 'C','0');
	}
	$pdf->SetXY($left_margin+229, $posY+$height[$x]);
	$pdf->Cell(74, 21,'', '1', '1', 'C','0');

	$pdf->SetXY($left_margin+303, $posY+$height[$x]);
	$pdf->Cell(30, 21,'', '1', '1', 'C','0');
	$pdf->SetXY($left_margin+333, $posY+$height[$x]);
/*
	$pdf->Cell(252, 21,'', '1', '1', 'C','0');
	$pdf->SetXY($left_margin+422, $posY+$height[$x]);
	$pdf->Cell(96, 21,'', '1', '1', 'C','0');

	$pdf->SetXY($left_margin+518, $posY+$height[$x]);
	if($x==5-1){
		$pdf->Cell(67, 21,'', 'TL', '1', 'C','0');
	}else{
		$pdf->Cell(67, 21,'', '1', '1', 'C','0');
	}
*/
}

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+47, $posY+247);

//�ƥ����Ȥο�
$pdf->SetTextColor(255,0,16); 

/*
$pdf->Cell(40, 12,'Ŧ �� '.$d_memo[0][2], '0', '1', 'L','0');
$pdf->Line($left_margin+78,$posY+259,$left_margin+255,$posY+259);
*/

//Ŧ��
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+10, $posY+240);
$pdf->Cell(10, 12,'�� �� ', '0', '1', 'L','0');
$pdf->SetTextColor(0,0,0);
$pdf->RoundedRect($left_margin+10, $posY+250, 300, 33, 5, 'FD',1234);
$pdf->SetXY($left_margin+10, $posY+253);
$pdf->MultiCell(300, 10,Textarea_Non_Break($d_memo[0][2],3), '0', '1', '','0');

$pdf->SetXY($left_margin+525, $posY+238);
$pdf->Cell(33, 28,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+558, $posY+238);
$pdf->Cell(33, 28,'', '1', '1', 'C','0');

//��
$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+540, $posY+270,56,18);

$pdf->Output();

//�ƥ����ȥ��ꥢ�ǲ��Ԥ�������ʾ�ξ���3���ܰʹߤ�̵�뤹�롣
function Textarea_Non_Break($val, $cnt){
    //ʸ����β��Ԥο��������
    $break_count = substr_count($val, "\n");

    //����������Կ������ʤ����ϲ��⤷�ʤ�
    if($break_count < $cnt){
        return $val;
    }

    //������ʹߤβ��Ԥ�̵��
    $split_val = str_split($val);
    $break=0;
    for($i = 0; $i < count($split_val); $i++){
        if($split_val[$i] == "\n"){
            $break++;
        }       

        if(($break > 2 && $split_val[$i] == "\n")){ 
            $split_val[$i] = '';
        }       
    }
    return implode('', $split_val);
}

?>
