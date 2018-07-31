<?php

// �Ķ�����ե�����
require_once("ENV_local.php");

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);

require('../../../fpdf/mbfpdf.php');

$pdf=new MBFPDF('P','pt','a3w');

$pdf->AddMBFont(GOTHIC ,'SJIS');

$pdf->SetAutoPageBreak(false);

$pdf->AddPage();

//�طʿ�
$pdf->SetFillColor(180,180,180);
//��Ͽ�����ɺ���ǯ����
$card[0] = "2005";//ǯ
$card[1] = "4";//��
$card[2] = "28";//��

$top[0] = "";//SV��
$top[1] = "";//ô������
$top[2] = "";//ô������
$top[3] = "";//ô������
$top[4] = "";//ô������

//��������
$customer1 = "";//S������
$customer2 = "";//FC��������ʬ
$customer3 = "";//����
$customer4 = "";//����å�̾�եꥬ��
$customer5 = "";//����å�̾
$customer6 = "";//��̾�եꥬ��
$customer7 = "";//��̾
$customer8 = "";//͹���ֹ�
$customer9 = "";//����եꥬ��
$customer10 = "";//����
$customer11 = "";//TEL
$customer12 = "";//FAX
$customer13 = "";//��ɽ����
$customer14 = "";//��ɽ��
$customer15 = "";//��ɽ����
$customer16 = "";//Ϣ��ô����
$customer17 = "";//ô����̾
$customer18 = "";//ô������
$customer19 = "";//�ݾڿͣ�
$customer20 = "";//�ݾڿͣ�����
$customer21 = "";//�ݾڿͣ�
$customer22 = "";//�ݾڿͣ�����
$customer23 = "";//�Ķȵ���
$customer24 = "";//����
$customer25 = "";//����
$customer26 = "";//������
$customer27 = "";//�ݾڶ�
$customer28 = "";//�ێ��Ԏ؎Î�

$payment[0] = "30��";//����
$payment[1] = "�⡹��";//��ʧ��(��)
$payment[2] = "30��";//��ʧ��(��)
$payment[3] = "����";//��ʧ��ˡ
$payment[4] = "";//����̾��


$representative[0] = "";//��ɽ��
$charge[0] = "";//�����褴ô��
$charge[1] = "";//�����褴ô��
$charge[2] = "";//�����褴ô��
$charge[3] = "";//�����褴ô��
$charge[4] = "";//�����褴ô��

//��������
$claim[0] = "";//͹���ֹ�
$claim[1] = "";//������եꥬ��
$claim[2] = "";//������̾
$claim[3] = "";//����եꥬ��
$claim[4] = "";//����
$claim[5] = "";//TEL
$claim[6] = "";//FAX

$representative[1] = "";//��ɽ��
$charge[5] = "";//�����褴ô��
$charge[6] = "";//�����褴ô��
$charge[7] = "";//�����褴ô��
$charge[8] = "";//�����褴ô��
$charge[9] = "";//�����褴ô��

$start[0] = "2005";//������(ǯ)
$start[1] = "4";//������(��)
$start[2] = "28";//������(��)

$renewal[0] = "";//����1����(ǯ)
$renewal[1] = "";//����1����(��)
$renewal[2] = "";//����1����(��)
$renewal[3] = "";//������̾1����
$renewal[4] = "";//����2����(ǯ)
$renewal[5] = "";//����2����(��)
$renewal[6] = "";//����2����(��)
$renewal[7] = "";//������̾2����
$renewal[8] = "";//����3����(ǯ)
$renewal[9] = "";//����3����(��)
$renewal[10] = "";//����3����(��)
$renewal[11] = "";//������̾3����

$contract1 = "";//������̾
$contract2 = "";//������ɽ��̾
$contract3 = "";//����ǯ����
$contract4 = "";//�������


//�ǡ�������SQL
//$sql_select = "";

$data[0] = array("31","C");//����
$data[1] = array("39","C");//����ñ��
$data[2] = array("23.5","C");//��̾
$data[3] = array("23","C");//��������
$data[4] = array("163.5","L");//�����ӥ�������
$data[5] = array("31","R");//����
$data[6] = array("36","R");//ñ��
$data[7] = array("44","R");//���
$data[8] = array("109","L");//����

//align(�ǡ���)
$data_align[0] = "C";
$data_align[1] = "C";
$data_align[2] = "C";
$data_align[3] = "C";
$data_align[4] = "L";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "L";


$year1 = "2005";
$month1 = "09";
$day1 = "28";
$year2 = "2005";
$month2 = "10";
$renew1 = "����˥ƥ�����Ϻ";
$day2 = "01";
$year3 = "2005";
$month3 = "10";
$day3 = "15";
$renew2 = "����˥ƥ�����Ϻ";
$year4 = "2005";
$month4 = "10";
$day4 = "24";
$renew3 = "����˥ƥ�����Ϻ";

//����
$posY = $pdf->GetY();
$pdf->SetFont(GOTHIC, 'B', 14);
$pdf->SetLineWidth(0.8);
$pdf->SetXY($left_margin+38, $posY+15);
$pdf->Cell(97, 49,'��Ͽ������', '1', '1', 'C');
$pdf->SetXY($left_margin+155, $posY+15);
$pdf->Cell(150, 49,'', '1', '1', 'C');
$pdf->SetXY($left_margin+338, $posY+15);
$pdf->Cell(200, 49,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+69);
$pdf->Cell(500, 326,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+400);
$pdf->Cell(500, 108,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+512);
$pdf->Cell(500, 184,'', '1', '1', 'C');
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+650, $posY+15);
$pdf->Cell(500, 13,'������ʡ�����ʬ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+650, $posY+28);
$pdf->Cell(500, 225,'', '1', '1', 'C');
$pdf->SetXY($left_margin+650, $posY+269.5);
$pdf->Cell(500, 13,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+650, $posY+282.5);
$pdf->Cell(500, 225,'', '1', '1', 'C');
$pdf->SetXY($left_margin+650, $posY+524);
$pdf->Cell(500, 13,'����¾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+650, $posY+537);
$pdf->Cell(500, 225,'', '1', '1', 'C');
$pdf->SetXY($left_margin+318, $posY+696);
$pdf->Cell(111, 49.5,'', '1', '1', 'C');

//TOP
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+155, $posY+15);
$pdf->Cell(150, 15,'��Ͽ�����ɺ���ǯ����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+170, $posY+30);
$pdf->Cell(30, 34, $card[0], '0', '1', 'R');
$pdf->SetXY($left_margin+200, $posY+30);
$pdf->Cell(15, 34,'ǯ', '0', '1', 'L');
$pdf->SetXY($left_margin+215, $posY+30);
$pdf->Cell(20, 34, $card[1], '0', '1', 'R');
$pdf->SetXY($left_margin+235, $posY+30);
$pdf->Cell(15, 34,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+250, $posY+30);
$pdf->Cell(20, 34, $card[2], '0', '1', 'R');
$pdf->SetXY($left_margin+270, $posY+30);
$pdf->Cell(15, 34,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+338, $posY+15);
$pdf->Cell(40, 15,'SV', '1', '1', 'C','1');
$pdf->SetXY($left_margin+378, $posY+15);
$pdf->Cell(40, 15,'ô��1', '1', '1', 'C','1');
$pdf->SetXY($left_margin+418, $posY+15);
$pdf->Cell(40, 15,'ô��2', '1', '1', 'C','1');
$pdf->SetXY($left_margin+458, $posY+15);
$pdf->Cell(40, 15,'ô��3', '1', '1', 'C','1');
$pdf->SetXY($left_margin+498, $posY+15);
$pdf->Cell(40, 15,'ô��4', '1', '1', 'C','1');
$pdf->SetXY($left_margin+338, $posY+30);
$pdf->Cell(40, 34,$top[0], '1', '1', 'C');
$pdf->SetXY($left_margin+378, $posY+30);
$pdf->Cell(40, 34,$top[1], '1', '1', 'C');
$pdf->SetXY($left_margin+418, $posY+30);
$pdf->Cell(40, 34,$top[2], '1', '1', 'C');
$pdf->SetXY($left_margin+458, $posY+30);
$pdf->Cell(40, 34,$top[3], '1', '1', 'C');
$pdf->SetXY($left_margin+498, $posY+30);
$pdf->Cell(40, 34,$top[4], '1', '1', 'C');

$pdf->SetFont(GOTHIC, '', 9);
//������ǡ���
$pdf->SetXY($left_margin+38, $posY+69);
$pdf->Cell(46, 156,'����å�̾', '1', '1', 'C','1');
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+84, $posY+69);
$pdf->Cell(50, 15,'S ������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+69);
$pdf->Cell(101, 15,$customer1, '1', '1', 'C');
$pdf->SetXY($left_margin+235, $posY+69);
$pdf->Cell(50, 15,'FC��������ʬ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+285, $posY+69);
$pdf->Cell(101, 15,$customer2, '1', '1', 'C');
$pdf->SetXY($left_margin+386, $posY+69);
$pdf->Cell(50, 15,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+436, $posY+69);
$pdf->Cell(102, 15,$customer3, '1', '1', 'C');
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+84, $posY+84);
$pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+84);
$pdf->Cell(404, 12.5,$customer4, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+84, $posY+96.5);
$pdf->Cell(50, 24.5,'����å�̾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+96.5);
$pdf->Cell(404, 24.5,$customer5, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+84, $posY+121);
$pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+121);
$pdf->Cell(404, 12.5,$customer6, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+84, $posY+133.5);
$pdf->Cell(50, 24.5,'�ҡ�����̾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+133.5);
$pdf->Cell(404, 24.5,$customer7, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+158);
$pdf->Cell(50, 15,'͹���ֹ�', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+158);
$pdf->Cell(404, 15,$customer8, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+84, $posY+173);
$pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+173);
$pdf->Cell(404, 12.5,$customer9, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+84, $posY+185.5);
$pdf->Cell(50, 24.5,'����������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+185.5);
$pdf->Cell(404, 24.5,$customer10, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+210);
$pdf->Cell(50, 15,'�ԡ��š���', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+210);
$pdf->Cell(101, 15,$customer11, '1', '1', 'L');
$pdf->SetXY($left_margin+235, $posY+210);
$pdf->Cell(50, 15,'�ơ�������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+285, $posY+210);
$pdf->Cell(253, 15,$customer12, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+225);
$pdf->Cell(46, 15,'��ɽ����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+225);
$pdf->Cell(121,15,$customer13, '1', '1', 'L');
$pdf->SetXY($left_margin+205, $posY+225);
$pdf->Cell(46, 15,'�塡ɽ����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+251, $posY+225);
$pdf->Cell(121,15,$customer14, '1', '1', 'L');
$pdf->SetXY($left_margin+372, $posY+225);
$pdf->Cell(46, 15,'��ɽ����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+418, $posY+225);
$pdf->Cell(120,15,$customer15, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+240);
$pdf->Cell(46, 15,'Ϣ��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+240);
$pdf->Cell(121,15,$customer16, '1', '1', 'L');
$pdf->SetXY($left_margin+205, $posY+240);
$pdf->Cell(46, 15,'ô����̾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+251, $posY+240);
$pdf->Cell(121,15,$customer17, '1', '1', 'L');
$pdf->SetXY($left_margin+372, $posY+240);
$pdf->Cell(46, 15,'ô������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+418, $posY+240);
$pdf->Cell(120,15,$customer18, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+255);
$pdf->Cell(46, 15,'�ݾڿͣ�', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+255);
$pdf->Cell(121,15,$customer19, '1', '1', 'L');
$pdf->SetXY($left_margin+205, $posY+255);
$pdf->Cell(46, 15,'��������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+251, $posY+255);
$pdf->Cell(287,15,$customer20, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+270);
$pdf->Cell(46, 15,'�ݾڿͣ�', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+270);
$pdf->Cell(121,15,$customer21, '1', '1', 'L');
$pdf->SetXY($left_margin+205, $posY+270);
$pdf->Cell(46, 15,'��������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+251, $posY+270);
$pdf->Cell(287,15,$customer22, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+285);
$pdf->Cell(46, 15,'�Ķȵ���', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+285);
$pdf->Cell(287,15,$customer23, '1', '1', 'L');
$pdf->SetXY($left_margin+371, $posY+285);
$pdf->Cell(46, 15,'�١�����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+417, $posY+285);
$pdf->Cell(121,15,$customer24, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+300);
$pdf->Cell(46, 15,'��������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+300);
$pdf->Cell(454,15,$customer25, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+315);
$pdf->Cell(46, 15,'������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+315);
$pdf->Cell(454,15,$customer26, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+330);
$pdf->Cell(46, 15,'�ݾڶ�', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+330);
$pdf->Cell(454,15,$customer27, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+345);
$pdf->Cell(46, 15,'�ێ��Ԏ؎Î�', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+345);
$pdf->Cell(454,15,$customer28, '1', '1', 'L');

$pdf->SetXY($left_margin+38, $posY+360);
$pdf->Cell(46, 15,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+360);
$pdf->Cell(100, 15,'��ʧ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+184, $posY+360);
$pdf->Cell(50, 15,'��ʧ��ˡ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+234, $posY+360);
$pdf->Cell(304, 15,'����̾��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+38, $posY+375);
$pdf->Cell(46, 20,$payment[0], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+375);
$pdf->Cell(50, 20,$payment[1], '1', '1', 'C');
$pdf->SetXY($left_margin+134, $posY+375);
$pdf->Cell(50, 20,$payment[2], '1', '1', 'C');
$pdf->SetXY($left_margin+184, $posY+375);
$pdf->Cell(50, 20,$payment[3], '1', '1', 'C');
$pdf->SetXY($left_margin+234, $posY+375);
$pdf->Cell(304, 20,$payment[4], '1', '1', 'C');

$pdf->SetXY($left_margin+38, $posY+400);
$pdf->Cell(46, 108,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+400);
$pdf->Cell(50, 27,'������̾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+400);
$pdf->Cell(404, 27,$contract1, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+427);
$pdf->Cell(50, 27,'������ɽ̾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+427);
$pdf->Cell(404, 27,$contract2, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+454);
$pdf->Cell(50, 27,'����ǯ����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+454);
$pdf->Cell(404, 27,$contract3, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+481);
$pdf->Cell(50, 27,'�������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+481);
$pdf->Cell(404, 27,$contract4, '1', '1', 'L');

//�ǡ����ܺ�
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+38, $posY+512);
$pdf->Cell(31, 24,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+69.2, $posY+512);
$pdf->Cell(39, 24,'', '1', '1', 'C');
$pdf->SetXY($left_margin+69.2, $posY+512.2);
$pdf->Cell(39, 11.8,'����ñ��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+69.2, $posY+524);
$pdf->Cell(39, 11.8,'(W��M)', '0', '1', 'C','1');
$pdf->SetXY($left_margin+108, $posY+512);
$pdf->Cell(23.5, 24,'��̾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+131.7, $posY+512);
$pdf->Cell(23, 24,'', '1', '1', 'C');
$pdf->SetXY($left_margin+131.7, $posY+512.2);
$pdf->Cell(23, 11.8,'����', '0', '1', 'C','1');
$pdf->SetXY($left_margin+131.7, $posY+524);
$pdf->Cell(23, 11.8,'��', '0', '1', 'C','1');
$pdf->SetXY($left_margin+154.5, $posY+512);
$pdf->Cell(163.5, 24,'�����ӥ�������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+318, $posY+512);
$pdf->Cell(31, 24,'�� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+349, $posY+512);
$pdf->Cell(36, 24,'ñ ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+385, $posY+512);
$pdf->Cell(44, 24,'�⡡��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+429, $posY+512);
$pdf->Cell(109, 24,'�� ��', '1', '1', 'C','1');

$pdf->SetXY(10, 28.5);
$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->Line($left_margin+38,$posY+552,$left_margin+538,$posY+552);
$pdf->Line($left_margin+38,$posY+568,$left_margin+538,$posY+568);
$pdf->Line($left_margin+38,$posY+584,$left_margin+538,$posY+584);
$pdf->Line($left_margin+38,$posY+600,$left_margin+538,$posY+600);
$pdf->Line($left_margin+38,$posY+616,$left_margin+538,$posY+616);
$pdf->Line($left_margin+38,$posY+632,$left_margin+538,$posY+632);
$pdf->Line($left_margin+38,$posY+648,$left_margin+538,$posY+648);
$pdf->Line($left_margin+38,$posY+664,$left_margin+538,$posY+664);
$pdf->Line($left_margin+38,$posY+680,$left_margin+538,$posY+680);
$pdf->Line($left_margin+69,$posY+536,$left_margin+69,$posY+696);
$pdf->Line($left_margin+108,$posY+536,$left_margin+108,$posY+696);
$pdf->Line($left_margin+131.5,$posY+536,$left_margin+131.5,$posY+696);
$pdf->Line($left_margin+154.5,$posY+536,$left_margin+154.5,$posY+696);
$pdf->Line($left_margin+318,$posY+536,$left_margin+318,$posY+696);
$pdf->Line($left_margin+349,$posY+536,$left_margin+349,$posY+696);
$pdf->Line($left_margin+385,$posY+536,$left_margin+385,$posY+696);
$pdf->Line($left_margin+429,$posY+536,$left_margin+429,$posY+696);
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+318.2, $posY+696.3);
$pdf->Cell(30.8, 16.2,'���ǹ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+349, $posY+696);
$pdf->Cell(36, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+385, $posY+696);
$pdf->Cell(44, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+318.2, $posY+712.5);
$pdf->Cell(30.8, 16.5,'���ǹ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+349, $posY+712.5);
$pdf->Cell(36, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+385, $posY+712.5);
$pdf->Cell(44, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+318.2, $posY+729);
$pdf->Cell(30.8, 16.1,'�� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+349, $posY+729);
$pdf->Cell(36, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+385, $posY+729);
$pdf->Cell(44, 16.5,'', '1', '1', 'C');

$pdf->SetFont(GOTHIC,'', 9);
//BOTTOM
$pdf->Line($left_margin+38,$posY+712.5,$left_margin+170,$posY+712.5);
$pdf->Line($left_margin+38,$posY+729,$left_margin+310,$posY+729);
$pdf->Line($left_margin+38,$posY+745.5,$left_margin+310,$posY+745.5);
$pdf->Line($left_margin+38,$posY+762,$left_margin+310,$posY+762);

$pdf->SetXY($left_margin+38, $posY+696);
$pdf->Cell(22, 16.5,'������', '0', '1', 'L');
$pdf->SetXY($left_margin+60, $posY+696);
$pdf->Cell(35, 16.5,$year1, '0', '1', 'R');
$pdf->SetXY($left_margin+95, $posY+696);
$pdf->Cell(10, 16.5,'ǯ', '0', '1', 'L');
$pdf->SetXY($left_margin+105, $posY+696);
$pdf->Cell(20, 16.5,$month1, '0', '1', 'R');
$pdf->SetXY($left_margin+125, $posY+696);
$pdf->Cell(10, 16.5,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+135, $posY+696);
$pdf->Cell(20, 16.5,$day1, '0', '1', 'R');
$pdf->SetXY($left_margin+155, $posY+696);
$pdf->Cell(10, 16.5,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+712.5);
$pdf->Cell(22, 16.5,'������', '0', '1', 'L');
$pdf->SetXY($left_margin+60, $posY+712.5);
$pdf->Cell(35, 16.5,$year2, '0', '1', 'R');
$pdf->SetXY($left_margin+95, $posY+712.5);
$pdf->Cell(10, 16.5,'ǯ', '0', '1', 'L');
$pdf->SetXY($left_margin+105, $posY+712.5);
$pdf->Cell(20, 16.5,$month2, '0', '1', 'R');
$pdf->SetXY($left_margin+125, $posY+712.5);
$pdf->Cell(10, 16.5,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+135, $posY+712.5);
$pdf->Cell(20, 16.5,$day2, '0', '1', 'R');
$pdf->SetXY($left_margin+155, $posY+712.5);
$pdf->Cell(10, 16.5,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+175, $posY+712.5);
$pdf->Cell(30, 16.5,'������', '0', '1', 'L');
$pdf->SetXY($left_margin+255, $posY+712.5);
$pdf->Cell(41, 16.5,$renew1, '0', '1', 'R');
$pdf->SetXY($left_margin+38, $posY+729);
$pdf->Cell(22, 16.5,'������', '0', '1', 'L');
$pdf->SetXY($left_margin+60, $posY+729);
$pdf->Cell(35, 16.5,$year3, '0', '1', 'R');
$pdf->SetXY($left_margin+95, $posY+729);
$pdf->Cell(10, 16.5,'ǯ', '0', '1', 'L');
$pdf->SetXY($left_margin+105, $posY+729);
$pdf->Cell(20, 16.5,$month3, '0', '1', 'R');
$pdf->SetXY($left_margin+125, $posY+729);
$pdf->Cell(10, 16.5,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+135, $posY+729);
$pdf->Cell(20, 16.5,$day3, '0', '1', 'R');
$pdf->SetXY($left_margin+155, $posY+729);
$pdf->Cell(10, 16.5,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+175, $posY+729);
$pdf->Cell(22, 16.5,'������', '0', '1', 'L');
$pdf->SetXY($left_margin+255, $posY+729);
$pdf->Cell(41, 16.5,$renew2, '0', '1', 'R');
$pdf->SetXY($left_margin+38, $posY+745.5);
$pdf->Cell(22, 16.5,'������', '0', '1', 'L');
$pdf->SetXY($left_margin+60, $posY+745.5);
$pdf->Cell(35, 16.5,$year4, '0', '1', 'R');
$pdf->SetXY($left_margin+95, $posY+745.5);
$pdf->Cell(10, 16.5,'ǯ', '0', '1', 'L');
$pdf->SetXY($left_margin+105, $posY+745.5);
$pdf->Cell(20, 16.5,$month4, '0', '1', 'R');
$pdf->SetXY($left_margin+125, $posY+745.5);
$pdf->Cell(10, 16.5,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+135, $posY+745.5);
$pdf->Cell(20, 16.5,$day4, '0', '1', 'R');
$pdf->SetXY($left_margin+155, $posY+745.5);
$pdf->Cell(10, 16.5,'��', '0', '1', 'L');
$pdf->SetXY($left_margin+175, $posY+745.5);
$pdf->Cell(30, 16.5,'������', '', '1', 'L');
$pdf->SetXY($left_margin+255, $posY+745.5);
$pdf->Cell(41, 16.5,$renew3, '0', '1', 'R');


$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+349, $posY+754);
$pdf->Cell(80, 8,'�񼰺���2005ǯ08��30��', '0', '1', 'C');
$pdf->Output();


?>
