<?php
/********************
 * �����ɼ�ץ�ӥ塼
 *
 *
 * �ѹ�����
 *    2006/09/02 (kaji) 
 *      ��FC�������ɼ����ץ�ӥ塼�Ѥˤ���
 *
 ********************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/25��0104����      watanabe-k  ���˸������ɼ�Υ�⤬ɽ������Ƥ���Х��ν���
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

/****************************/
//�����ѿ�����
/****************************/
if($_POST[pattern_select] == null){
    print "<font color=\"red\"><b><li>�ѥ���������򤷤Ƥ���������</b></font>";
    exit;
}
//print_array($_POST);

$shop_id = $_SESSION["client_id"];

$sql  = "SELECT ";
$sql .= "    s_memo1, ";        //�����ɼ������1
$sql .= "    s_memo2, ";        //�����ɼ������2
$sql .= "    s_memo3, ";        //�����ɼ������3
$sql .= "    s_memo4, ";        //�����ɼ������4
$sql .= "    s_memo5, ";        //�����ɼ������5
$sql .= "    s_fsize1,";        //������1�ե���ȥ�����
$sql .= "    s_fsize2,";        //������2�ե���ȥ�����
$sql .= "    s_fsize3,";        //������3�ե���ȥ�����
$sql .= "    s_fsize4,";        //������4�ե���ȥ�����
$sql .= "    s_fsize5,";        //������5�ե���ȥ�����
$sql .= "    s_memo6, ";        //�����ɼ������6
$sql .= "    s_memo7, ";        //�����ɼ������7
$sql .= "    s_memo8, ";        //�����ɼ������8
$sql .= "    s_memo9, ";        //�����ɼ������9
$sql .= "    bill_send_flg ";   //������Ϥ��ե饰
$sql .= "FROM ";
$sql .= "    t_slip_sheet ";
$sql .= "WHERE ";
$sql .= "    s_pattern_id = ".$_POST["pattern_select"]." ";
$sql .= "    AND ";
$sql .= "    shop_id = $shop_id ";
$sql .= ";";

$result = Db_Query($db_con,$sql);
//DB���ͤ��������¸
$s_memo = Get_Data($result,2);

//�������Ϥ��Ȥ����С��Ϥ��ʤ��Ȥ��ϡ����졼
$bill_flg = $s_memo[0][14];

$photo = COMPANY_SEAL_DIR.$shop_id.".jpg";      //�Ұ��Υե�����̾���������ô����Ź�Ρ�
$photo_exists = file_exists($photo);            //�Ұ���¸�ߤ��뤫�ե饰


$pdf->AddPage();


/****************************/
//���㤤�夲��ɼ�������
/****************************/
$left_margin=50;
$posY=20;
//��������
$pdf->SetLineWidth(0.8);
//���ο�
$pdf->SetDrawColor(80,80,80);
//�ե��������
$pdf->SetFont(GOTHIC,'', 7);
//�طʿ�
$pdf->SetFillColor(221,221,221);
//����Ѵ�(��)
$pdf->RoundedRect(60, 30, 260, 12, 5, 'FD',12);
//�ƥ����Ȥο�
$pdf->SetTextColor(80,80,80); 
//�طʿ�
$pdf->SetFillColor(255);
//����Ѵ�(��)
$pdf->RoundedRect(60, 42, 260, 53, 5, 'FD',34);
$pdf->SetXY($left_margin+15, $posY);
$pdf->Cell(100, 8,"�����ͥ����ɡ�", '', '1', 'L','0');
$pdf->SetXY($left_margin+490, $posY);
$pdf->Cell(100, 8,"��ɼ�ֹ桡           ", '', '1', 'R','0');
//�ե��������
$pdf->SetFont(GOTHIC,'', 9);
$pdf->RoundedRect(60, 42, 260, 53, 5, 'FD',34);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(260, 12,'�桡���������ա����衡��̾', 'B', '1', 'C','0');
//��������
$pdf->SetLineWidth(0.2);
//�طʿ�
$pdf->SetFillColor(221,221,221);
//�ƥ����Ȥο�
$pdf->SetTextColor(80,80,80); 
//�ե��������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+45);
$pdf->Cell(260, 12,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+10.4, $posY+45);
$pdf->Cell(34, 12,'�����ʬ', '0', '1', 'C','1');
$pdf->SetXY($left_margin+44, $posY+45);
$pdf->Cell(63, 12,'�� �� ǯ �� ��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+107, $posY+45);
$pdf->Cell(34, 12,'�롼��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+141, $posY+45);
$pdf->Cell(22, 12,'����', '0', '1', 'C','1');
$pdf->SetXY($left_margin+163, $posY+45);
$pdf->Cell(106.4, 12,'�š����á����֡�����', '0', '1', 'C','1');

//�ƥ����Ȥο�
$pdf->SetTextColor(80,80,80); 
$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+365, $posY+7,45,15);
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+273, $posY+10);
$pdf->Cell(90, 12,'�� �� �� �� ɼ', 'B', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(335, 50, 10, 45, 3, 'FD',14);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+285, $posY+35);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+47.5);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+60);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(345, 50, 65, 45, 3, 'FD',23);
//��������
$pdf->SetLineWidth(0.2);
//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
$pdf->SetXY($left_margin+415, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
$pdf->SetXY($left_margin+465, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

$pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
$pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
$pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
$pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
$pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
$pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(80,80,80);
$pdf->RoundedRect(60, 100, 575, 10, 5, 'FD',12);

//�ƥ����Ȥο�
$pdf->SetTextColor(255); 
//��������
$pdf->SetLineWidth(0.2);
//�ե��������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+80);
$pdf->Cell(40, 10,'���ʥ�����', '0', '1', 'C','0');
$pdf->SetXY($left_margin+50, $posY+80);
$pdf->Cell(256, 10,'�� �� �� ����/���� �� �� �� ̾', '0', '1', 'C','0');
$pdf->SetXY($left_margin+306, $posY+80);
$pdf->Cell(32, 10,'��������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+338, $posY+80);
$pdf->Cell(52, 10,'ñ������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+390, $posY+80);
$pdf->Cell(62, 10,'�⡡����', '0', '1', 'C','0');
$pdf->SetXY($left_margin+452, $posY+80);
$pdf->Cell(66, 10,'�¡�����������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+80);
$pdf->Cell(66.7, 10,'������������', '0', '1', 'C','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(60, 110, 575, 105, 5, 'FD',4);

//�ե��������
$pdf->SetFont(GOTHIC,'', 7);
//��������
$pdf->SetLineWidth(0.2);

//���ʥǡ����Կ�����
$height = array('90','111','132','153','174');
for($x=0,$h=0;$x<5;$x++,$h++){
    //�Ǹ�ιԤ�Ƚ��
    if($x==5-1){
        //���ʥ�����
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');

        //�����ӥ�/�����ƥ�̾
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', '1', '1', 'L','0');

        //����
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', '1', '1', 'C','0');

        //ñ��
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');

        //���
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', '1', '1', 'R','0');

        //�¤�
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //����
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', '1', '1', 'C','0');

    }else{
        //���ʥ�����
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');

        //�����ӥ�/�����ƥ�̾
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');

        //����
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');

        //ñ��
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');

        //���
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');

        //�¤�
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //����
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', 'LRT', '1', 'C','0');
    }
}

//��������
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(568, 215, 67, 57, 5, 'FD',34);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+518, $posY+195);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+214);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+233);
$pdf->Cell(66.7, 19,'', 'T', '1', 'C','0');


//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(440, 215, 62, 57, 5, 'FD',34);
//��������
$pdf->SetLineWidth(0.2);

//��ȴ���
$pdf->SetXY($left_margin+390, $posY+195);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//�����ǳ�
$pdf->SetXY($left_margin+390, $posY+214);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//��׶��
$pdf->SetXY($left_margin+390, $posY+233);
$pdf->Cell(62, 19,'', '0', '1', 'R','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(80,80,80); 
//�ե��������
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+357, $posY+195);
$pdf->Cell(30, 19,'������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+214);
$pdf->Cell(30, 19,'������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+233);
$pdf->Cell(30, 19,'�硡��', '0', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(60, 225, 260, 58, 5, 'FD',1234);

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0);

//������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+16, $posY+210);
$pdf->MultiCell(254, 9,$s_memo[0][10], '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(80,80,80);

//�طʿ�
$pdf->SetFillColor(221,221,221);
$pdf->RoundedRect(330, 225, 56, 10, 3, 'FD',12);
//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+280, $posY+205);
$pdf->Cell(56, 10,'ô �� �� ̾', '0', '1', 'C','0');
//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(330, 235, 56, 48, 3, 'FD',34);

$pdf->SetDrawColor(255);
$pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+340, $posY+254);
$pdf->Cell(250, 10,'���٤��꤬�Ȥ��������ޤ����嵭���̤�Ǽ���פ��ޤ��ΤǸ溺����������', '0', '1', 'R','0');

$pdf->SetLineWidth(0.2);
$pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
$pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
$pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
$pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
$pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
$pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

//���ο�
$pdf->SetDrawColor(42,42,42);
$pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
$pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

$pdf->Line($left_margin+44.4,$posY+45,$left_margin+44.4,$posY+75);
$pdf->Line($left_margin+107,$posY+45,$left_margin+107,$posY+75);
$pdf->Line($left_margin+141,$posY+45,$left_margin+141,$posY+75);
$pdf->Line($left_margin+162,$posY+45,$left_margin+162,$posY+75);



/****************************/
//�������ɼ�������
/****************************/
$posY=325;
//��������
$pdf->SetLineWidth(0.8);

//���ο�
$pdf->SetDrawColor(46,140,46);
//�طʿ�
$pdf->SetFillColor(198,246,195);

//�ե��������
$pdf->SetFont(GOTHIC,'', 9);

//����Ѵ�(��)
$pdf->RoundedRect(60, 335, 260, 12, 5, 'FD',12);

//�ƥ����Ȥο�
$pdf->SetTextColor(46,140,46);

//�طʿ�
$pdf->SetFillColor(255);

//�ե��������
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+15, $posY);
$pdf->Cell(100, 8,"�����ͥ����ɡ�", '', '1', 'L','0');
$pdf->SetXY($left_margin+490, $posY);
$pdf->Cell(100, 8,"��ɼ�ֹ桡           ", '', '1', 'R','0');

//�ե��������
$pdf->SetFont(GOTHIC,'', 9);
//����Ѵ�(��)
$pdf->RoundedRect(60, 347, 260,53, 5, 'FD',34);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(260, 12,'�桡���������ա����衡��̾', 'B', '1', 'C','0');

//�ե��������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+45);
$pdf->SetFillColor(198,246,195);
$pdf->Cell(260, 12,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+10.4, $posY+45);
$pdf->Cell(34, 12,'�����ʬ', '0', '1', 'C','1');
$pdf->SetXY($left_margin+44, $posY+45);
$pdf->Cell(63, 12,'�� �� ǯ �� ��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+107, $posY+45);
$pdf->Cell(34, 12,'�롼��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+141, $posY+45);
$pdf->Cell(22, 12,'����', '0', '1', 'C','1');
$pdf->SetXY($left_margin+163, $posY+45);
$pdf->Cell(106.4, 12,'�š����á����֡�����', '0', '1', 'C','1');

if($photo_exists){
    $pdf->Image($photo,$left_margin+510, $posY+25,52);
}

$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+365, $posY+7,45,15);
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+273, $posY+10);
$pdf->Cell(90, 12,'�������ᡡ����', 'B', '1', 'C','0');
//��������
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(335, 355, 10, 45, 3, 'FD',14);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+285, $posY+35);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+47.5);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+60);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(345, 355, 65, 45, 3, 'FD',23);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'B', 12);

//�ƥ����Ȥο�
$pdf->SetTextColor(80,80,80);

$pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
$pdf->SetXY($left_margin+415, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
$pdf->SetXY($left_margin+465, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

$pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
$pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
$pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
$pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
$pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
$pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

//��������
$pdf->SetLineWidth(0.8);

//�طʿ�
$pdf->SetFillColor(46,140,46);
//���ο�
$pdf->SetDrawColor(46,140,46);
$pdf->RoundedRect(60, 405, 575, 10, 5, 'FD',12);

//�ƥ����Ȥο�
$pdf->SetTextColor(255); 

//��������
$pdf->SetLineWidth(0.2);
//�ե��������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+80);
$pdf->Cell(40, 10,'���ʥ�����', '0', '1', 'C','0');
$pdf->SetXY($left_margin+50, $posY+80);
$pdf->Cell(256, 10,'�� �� �� ����/���� �� �� �� ̾', '0', '1', 'C','0');
$pdf->SetXY($left_margin+306, $posY+80);
$pdf->Cell(32, 10,'��������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+338, $posY+80);
$pdf->Cell(52, 10,'ñ������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+390, $posY+80);
$pdf->Cell(62, 10,'�⡡����', '0', '1', 'C','0');
$pdf->SetXY($left_margin+452, $posY+80);
$pdf->Cell(66, 10,'�¡�����������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+80);
$pdf->Cell(66.7, 10,'������������', '0', '1', 'C','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0);

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(60, 415, 575, 105, 5, 'FD',4);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 7);

//���ʥǡ����Կ�����
$height = array('90','111','132','153','174');

for($x=0,$h=0;$x<5;$x++,$h++){
    //�Ǹ�ιԤ�Ƚ��
    if($x==5-1){
        //���ʥ�����
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');

        //�����ӥ�/�����ƥ�̾
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', '1', '1', 'L','0');

        //����
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', '1', '1', 'C','0');

        //ñ��
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');

        //���
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', '1', '1', 'R','0');

        //�¤�
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //����
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', '1', '1', 'C','0');

    }else{
        //���ʥ�����
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');

        //�����ӥ�/�����ƥ�̾
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');

        //����
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');

        //ñ��
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');

        //���
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');

        //�¤�
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //����
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', 'LRT', '1', 'C','0');
    }
}

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(568, 520,67, 57, 5, 'FD',34);
//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+518, $posY+195);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+214);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+233);
$pdf->Cell(66.7, 19,'', '', '1', 'C','0');


//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(440, 520, 62, 57, 5, 'FD',34);
//��������
$pdf->SetLineWidth(0.2);

//��ȴ���
$pdf->SetXY($left_margin+390, $posY+195);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//�����ǳ�
$pdf->SetXY($left_margin+390, $posY+214);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//��׶��
$pdf->SetXY($left_margin+390, $posY+233);
$pdf->Cell(62, 19,'', '0', '1', 'R','0');

//�ե��������
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetTextColor(46,140,46);
$pdf->SetXY($left_margin+357, $posY+195);
$pdf->Cell(30, 19,'������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+214);
$pdf->Cell(30, 19,'������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+233);
$pdf->Cell(30, 19,'�硡��', '0', '1', 'C','0');

$pdf->SetLineWidth(0.8);
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+11, $posY+200);
$pdf->MultiCell(254, 9,$s_memo[0][11], '0', '1', 'L','0');

//�طʿ�
$pdf->SetFillColor(198,246,195);

$pdf->RoundedRect(330, 530, 56, 10, 3, 'FD',12);
//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+280, $posY+205);
$pdf->Cell(56, 10,'ô �� �� ̾', '0', '1', 'C','0');
//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(330, 540, 56, 48, 3, 'FD',34);

$pdf->SetDrawColor(255);
$pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+305, $posY+254);
$pdf->Cell(230, 10,'���٤��꤬�Ȥ��������ޤ����嵭���̤������פ��ޤ���', '0', '1', 'R','0');

$pdf->SetLineWidth(0.2);
$pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
$pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
$pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
$pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
$pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
$pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

//���ο�
$pdf->SetDrawColor(14,104,20);
$pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
$pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

$pdf->Line($left_margin+44.4,$posY+45,$left_margin+44.4,$posY+75);
$pdf->Line($left_margin+107,$posY+45,$left_margin+107,$posY+75);
$pdf->Line($left_margin+141,$posY+45,$left_margin+141,$posY+75);
$pdf->Line($left_margin+162,$posY+45,$left_margin+162,$posY+75);



/****************************/
//Ǽ�ʽ���ɼ�������
/****************************/
$posY=630;
$left_margin=50;

//��������
$pdf->SetLineWidth(0.8);
//���ο�
$pdf->SetDrawColor(17,136,255);
//�طʿ�
$pdf->SetFillColor(170,212,255);
//����Ѵ�(��)
$pdf->RoundedRect(60, 640, 260, 12, 5, 'FD',12);
//�ƥ����Ȥο�
$pdf->SetTextColor(17,136,255);
//�طʿ�
$pdf->SetFillColor(255);

//�ե��������
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+15, $posY);
$pdf->Cell(100, 8,"�����ͥ����ɡ�", '', '1', 'L','0');
$pdf->SetXY($left_margin+490, $posY);
$pdf->Cell(100, 8,"��ɼ�ֹ桡           ", '', '1', 'R','0');

//����Ѵ�(��)
//�ե��������
$pdf->SetFont(GOTHIC,'', 9);
$pdf->RoundedRect(60, 652, 260, 53, 5, 'FD',34);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(260, 12,'�桡���������ա����衡��̾', 'B', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.2);
//�ƥ����Ȥο�
$pdf->SetTextColor(17,136,255);
//�طʿ�
$pdf->SetFillColor(170,212,255);
//�ե��������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+45);
$pdf->Cell(260, 12,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+10.4, $posY+45);
$pdf->Cell(34, 12,'�����ʬ', '0', '1', 'C','1');
$pdf->SetXY($left_margin+44, $posY+45);
$pdf->Cell(63, 12,'�� �� ǯ �� ��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+107, $posY+45);
$pdf->Cell(34, 12,'�롼��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+141, $posY+45);
$pdf->Cell(22, 12,'����', '0', '1', 'C','1');
$pdf->SetXY($left_margin+163, $posY+45);
$pdf->Cell(106.4, 12,'�š����á����֡�����', '0', '1', 'C','1');

if($photo_exists){
    $pdf->Image($photo,$left_margin+510, $posY+25,52);
}

$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+365, $posY+7,45,15);
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+273, $posY+10);
$pdf->Cell(90, 12,'Ǽ�����ʡ�����', 'B', '1', 'C','0');
//��������
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(335, 660, 10, 45, 3, 'FD',14);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+285, $posY+35);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+47.5);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+60);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(345, 660, 65, 45, 3, 'FD',23);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'B', 12);

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0);

$pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
$pdf->SetXY($left_margin+415, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
$pdf->SetXY($left_margin+465, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

$pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
$pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
$pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
$pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
$pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
$pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');


//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(17,136,255);
$pdf->RoundedRect(60, 710, 575, 10, 5, 'FD',12);

//�ƥ����Ȥο�
$pdf->SetTextColor(255); 
//��������
$pdf->SetLineWidth(0.2);

//�ե��������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+80);
$pdf->Cell(40, 10,'���ʥ�����', '0', '1', 'C','0');
$pdf->SetXY($left_margin+50, $posY+80);
$pdf->Cell(256, 10,'�� �� �� ����/���� �� �� �� ̾', '0', '1', 'C','0');
$pdf->SetXY($left_margin+306, $posY+80);
$pdf->Cell(32, 10,'��������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+338, $posY+80);
$pdf->Cell(52, 10,'ñ������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+390, $posY+80);
$pdf->Cell(62, 10,'�⡡����', '0', '1', 'C','0');
$pdf->SetXY($left_margin+452, $posY+80);
$pdf->Cell(66, 10,'�¡�����������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+80);
$pdf->Cell(66.7, 10,'������������', '0', '1', 'C','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0);

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(60, 720, 575, 105, 5, 'FD',4);

//��������
$pdf->SetLineWidth(0.2);
//�طʿ�
$pdf->SetFillColor(170,212,255);
$pdf->SetFont(GOTHIC,'', 7);

//���ʥǡ����Կ�����
$height = array('90','111','132','153','174');
for($x=0,$h=0;$x<5;$x++,$h++){
    //�Ǹ�ιԤ�Ƚ��
    if($x==5-1){
        //���ʥ�����
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');

        //�����ӥ�/�����ƥ�̾
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', '1', '1', 'L','0');

        //����
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', '1', '1', 'C','0');

        //ñ��
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');

        //���
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', '1', '1', 'R','0');

        //�¤�
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //����
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', '1', '1', 'C','0');

    }else{
        //���ʥ�����
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');

        //�����ӥ�/�����ƥ�̾
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');

        //����
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');

        //ñ��
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');

        //���
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');

        //�¤�
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //����
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', 'LRT', '1', 'C','0');
    }
}


//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(568, 825,67, 57, 5, 'FD',34);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+518, $posY+195);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+214);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+233);
$pdf->Cell(66.7, 19,'', '', '1', 'C','0');


//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(440, 825, 62, 57, 5, 'FD',34);
//��������
$pdf->SetLineWidth(0.2);

//��ȴ���
$pdf->SetXY($left_margin+390, $posY+195);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//�����ǳ�
$pdf->SetXY($left_margin+390, $posY+214);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//��׶��
$pdf->SetXY($left_margin+390, $posY+233);
$pdf->Cell(62, 19,'', '0', '1', 'R','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(17,136,255);

//�ե��������
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+357, $posY+195);
$pdf->Cell(30, 19,'������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+214);
$pdf->Cell(30, 19,'������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+233);
$pdf->Cell(30, 19,'�硡��', '0', '1', 'C','0');


//��������
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(60, 835, 260, 58, 5, 'FD',1234);

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0);

//������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+16, $posY+210);
$pdf->MultiCell(254, 9,$s_memo[0][12], '0', '1', 'L','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(17,136,255);

//�طʿ�
$pdf->SetFillColor(170,212,255);
$pdf->RoundedRect(330, 835, 56, 10, 3, 'FD',12);
//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+280, $posY+205);
$pdf->Cell(56, 10,'ô �� �� ̾', '0', '1', 'C','0');
//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(330, 845, 56, 48, 3, 'FD',34);

$pdf->SetDrawColor(255);
$pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+340, $posY+254);
$pdf->Cell(250, 10,'���٤��꤬�Ȥ��������ޤ����嵭���̤�Ǽ���פ��ޤ��ΤǸ溺����������', '0', '1', 'R','0');

$pdf->SetLineWidth(0.2);
$pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
$pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
$pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
$pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
$pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
$pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

//���ο�
$pdf->SetDrawColor(17,136,255);
$pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
$pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

$pdf->Line($left_margin+44.4,$posY+45,$left_margin+44.4,$posY+75);
$pdf->Line($left_margin+107,$posY+45,$left_margin+107,$posY+75);
$pdf->Line($left_margin+141,$posY+45,$left_margin+141,$posY+75);
$pdf->Line($left_margin+162,$posY+45,$left_margin+162,$posY+75);



//���ڡ���
$pdf->AddPage();


/****************************/
//�μ�����ɼ�������
/****************************/
$posY=20;
//��������
$pdf->SetLineWidth(0.8);
//���ο�
$pdf->SetDrawColor(29,0,120);
//�طʿ�
$pdf->SetFillColor(200,230,255);
//����Ѵ�(��)
$pdf->RoundedRect(60, 30, 260, 12, 5, 'FD',12);
//�ƥ����Ȥο�
$pdf->SetTextColor(61,50,180); 
//�طʿ�
$pdf->SetFillColor(255);

//�ե��������
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+15, $posY);
$pdf->Cell(100, 8,"�����ͥ����ɡ�", '', '1', 'L','0');
$pdf->SetXY($left_margin+490, $posY);
$pdf->Cell(100, 8,"��ɼ�ֹ桡           ", '', '1', 'R','0');

$pdf->SetFont(GOTHIC,'', 9);
//����Ѵ�(��)
$pdf->RoundedRect(60, 42, 260, 53, 5, 'FD',34);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(260, 12,'�桡���������ա����衡��̾', 'B', '1', 'C','0');
//��������
$pdf->SetLineWidth(0.2);
//�ƥ����Ȥο�
$pdf->SetTextColor(61,50,180); 
//�طʿ�
$pdf->SetFillColor(200,230,255);
//�ե��������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+45);
$pdf->Cell(260, 12,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+10.4, $posY+45);
$pdf->Cell(34, 12,'�����ʬ', '0', '1', 'C','1');
$pdf->SetXY($left_margin+44, $posY+45);
$pdf->Cell(63, 12,'�� �� ǯ �� ��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+107, $posY+45);
$pdf->Cell(34, 12,'�롼��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+141, $posY+45);
$pdf->Cell(22, 12,'����', '0', '1', 'C','1');
$pdf->SetXY($left_margin+163, $posY+45);
$pdf->Cell(106.4, 12,'�š����á����֡�����', '0', '1', 'C','1');

if($photo_exists){
    $pdf->Image($photo,$left_margin+510, $posY+25,52);
}

//�ƥ����Ȥο�
$pdf->SetTextColor(61,50,180); 
$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+365, $posY+7,45,15);
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+273, $posY+10);
$pdf->Cell(90, 12,'�Ρ�����������', 'B', '1', 'C','0');


$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+480.5, $posY+217);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');
$pdf->SetXY($left_margin+480.5, $posY+240);
$pdf->Cell(10, 10,'��', '0', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.2);
//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
$pdf->SetXY($left_margin+415, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
$pdf->SetXY($left_margin+465, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

$pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
$pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
$pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
$pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
$pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
$pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(29,0,120);
$pdf->RoundedRect(60, 100, 575, 10, 5, 'FD',12);

//�ƥ����Ȥο�
$pdf->SetTextColor(255); 
//��������
$pdf->SetLineWidth(0.2);
//�ե��������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+80);
$pdf->Cell(40, 10,'���ʥ�����', '0', '1', 'C','0');
$pdf->SetXY($left_margin+50, $posY+80);
$pdf->Cell(256, 10,'�� �� �� ����/���� �� �� �� ̾', '0', '1', 'C','0');
$pdf->SetXY($left_margin+306, $posY+80);
$pdf->Cell(32, 10,'��������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+338, $posY+80);
$pdf->Cell(52, 10,'ñ������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+390, $posY+80);
$pdf->Cell(62, 10,'�⡡����', '0', '1', 'C','0');
$pdf->SetXY($left_margin+452, $posY+80);
$pdf->Cell(66, 10,'�¡�����������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+80);
$pdf->Cell(66.7, 10,'������������', '0', '1', 'C','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(60, 110, 575, 105, 5, 'FD',4);

//��������
$pdf->SetLineWidth(0.2);
//�طʿ�
$pdf->SetFillColor(200,230,255);
$pdf->SetFont(GOTHIC,'', 7);

//���ʥǡ����Կ�����
$height = array('90','111','132','153','174');

for($x=0,$h=0;$x<5;$x++,$h++){
    //�Ǹ�ιԤ�Ƚ��
    if($x==5-1){
        //���ʥ�����
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');

        //�����ӥ�/�����ƥ�̾
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', '1', '1', 'L','0');

        //����
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', '1', '1', 'C','0');

        //ñ��
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');

        //���
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', '1', '1', 'R','0');

        //�¤�
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //����
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', '1', '1', 'C','0');

    }else{
        //���ʥ�����
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');

        //�����ӥ�/�����ƥ�̾
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');

        //����
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');

        //ñ��
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');

        //���
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');

        //�¤�
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //����
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', 'LRT', '1', 'C','0');
    }
}


//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(568, 215, 67, 57, 5, 'FD',34);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+518, $posY+195);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+214);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+233);
$pdf->Cell(66.7, 19,'', '', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(440, 215, 62, 57, 5, 'FD',34);
//��������
$pdf->SetLineWidth(0.2);

//��ȴ���
$pdf->SetXY($left_margin+390, $posY+195);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//�����ǳ�
$pdf->SetXY($left_margin+390, $posY+214);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//��׶��
$pdf->SetXY($left_margin+390, $posY+233);
$pdf->Cell(62, 19,'', '0', '1', 'R','0');

//�ƥ����Ȥο�
$pdf->SetTextColor(61,50,180); 
//�ե��������
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+357, $posY+195);
$pdf->Cell(30, 19,'������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+214);
$pdf->Cell(30, 19,'������', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+233);
$pdf->Cell(30, 19,'�硡��', '0', '1', 'C','0');

//��������
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(60, 225, 260, 58, 5, 'FD',1234);

//�ƥ����Ȥο�
$pdf->SetTextColor(0,0,0); 

//������
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+16, $posY+210);
$pdf->MultiCell(254, 9,$s_memo[0][13], '0', '1', 'L','0');
//�ƥ����Ȥο�
$pdf->SetTextColor(61,50,180); 

//�طʿ�
$pdf->SetFillColor(200,230,255);
$pdf->RoundedRect(330, 225, 56, 10, 3, 'FD',12);
//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+280, $posY+205);
$pdf->Cell(56, 10,'�Ρ�������', '0', '1', 'C','0');
//��������
$pdf->SetLineWidth(0.8);
//�طʿ�
$pdf->SetFillColor(255);
$pdf->RoundedRect(330, 235, 56, 48, 3, 'FD',34);

$pdf->SetDrawColor(255);
$pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

//��������
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+337, $posY+254);
$pdf->Cell(150, 10,'���μ�����̵��ʪ��', '0', '1', 'L','0');
$pdf->SetXY($left_margin+353, $posY+265);
$pdf->Cell(150, 10,'̵�����פ��ޤ���', '0', '1', 'L','0');

$pdf->SetLineWidth(0.2);
$pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
$pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
$pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
$pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
$pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
$pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

//���ο�
$pdf->SetDrawColor(42,42,42);
$pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
$pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

$pdf->Line($left_margin+44.4,$posY+45,$left_margin+44.4,$posY+75);
$pdf->Line($left_margin+107,$posY+45,$left_margin+107,$posY+75);
$pdf->Line($left_margin+141,$posY+45,$left_margin+141,$posY+75);
$pdf->Line($left_margin+162,$posY+45,$left_margin+162,$posY+75);

            //�����������
            $pdf->SetLineWidth(0.1);
            $left_margin = 495;
            $posY = 205;
            for($i=14;$i<66;$i=$i+1.2){
                $pdf->Line($left_margin+$i, $posY+20, $left_margin+$i+0.5, $posY+20);
            }
            for($i=20;$i<76;$i=$i+1.2){
                $pdf->Line($left_margin+13, $posY+$i, $left_margin+13, $posY+$i+0.5);
            }
            for($i=14;$i<66;$i=$i+1.2){
                $pdf->Line($left_margin+$i, $posY+77, $left_margin+$i+0.5, $posY+77);
            }
            $left_margin = 549;
            for($i=20;$i<76;$i=$i+1.2){
                $pdf->Line($left_margin+13, $posY+$i, $left_margin+13, $posY+$i+0.5);
            }   


$pdf->Output();
//$pdf->Output(mb_convert_encoding("�����ɼ".date("Ymd").".pdf", "SJIS", "EUC"),"D");
?>
