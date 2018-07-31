<?php

// �Ķ�����ե�����
require_once("ENV_local.php");

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);

require('../../../fpdf/mbfpdf.php');

$pdf=new MBFPDF('P','pt','a4');

$pdf->AddMBFont(GOTHIC ,'SJIS');

$pdf->SetAutoPageBreak(false);

$pdf->AddPage();

//�����ͥ����ɺ���ǯ����
$card[0] = "2005";//ǯ
$card[1] = "4";//��
$card[2] = "28";//��

$top[0] = "";//��ô��
$top[1] = "";//�Ĵ���
$top[2] = "";//��̳��
$top[3] = "";//�����

//��������
$customer[0] = "";//Ǽ����̾�եꥬ��
$customer[1] = "";//Ǽ����̾
$customer[2] = "";//͹���ֹ�
$customer[3] = "";//����եꥬ��
$customer[4] = "";//����
$customer[5] = "";//TEL
$customer[6] = "";//FAX

$representative[0] = "";//��ɽ��
$charge[0] = "";//�����褴ô��
$charge[1] = "";//�����褴ô��
$charge[2] = "";//�����褴ô��
$charge[3] = "";//�����褴ô��
$charge[4] = "";//�����褴ô��


//�ĶȻ���1����
$business[0] = "10";//��(��)
$business[1] = "00";//ʬ(��)
$business[2] = "10";//��(��)
$business[3] = "00";//ʬ(��)
//�ĶȻ���2����
$business[4] = "14";//��(��)
$business[5] = "00";//ʬ(��)
$business[6] = "14";//��(��)
$business[7] = "00";//ʬ(��)
$business[8] = "������¾";//�ȼ�
$business[9] = "";//����
$holiday = "";//������


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

$payment[0] = "����";//����(��)
$payment[1] = "30��";//����(��)
$payment[2] = "�⡹��";//��ʧ��(��)
$payment[3] = "30��";//��ʧ��(��)
$payment[4] = "����";//��ʧ��ˡ
$payment[5] = "";//����̾��

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

//�طʿ�
$pdf->SetFillColor(180,180,180);

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
$left_margin = 8;
//����
$posY = $pdf->GetY();
$pdf->SetFont(GOTHIC, 'B', 14);
$pdf->SetLineWidth(0.8);
$pdf->SetXY($left_margin+38, $posY+15);
$pdf->Cell(97, 49,'�����ͥ�����', '1', '1', 'C');
$pdf->SetXY($left_margin+155, $posY+15);
$pdf->Cell(150, 49,'', '1', '1', 'C');
$pdf->SetXY($left_margin+338, $posY+15);
$pdf->Cell(200, 49,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+69);
$pdf->Cell(500, 217,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+289);
$pdf->Cell(500, 218,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+512);
$pdf->Cell(500, 184,'', '1', '1', 'C');
$pdf->SetFont(GOTHIC,'', 10.5);
//TOP
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+155, $posY+15);
$pdf->Cell(150, 15,'�����ͥ����ɺ���ǯ����', '1', '1', 'C','1');
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
$pdf->Cell(40, 15,'��ô1', '1', '1', 'C','1');
$pdf->SetXY($left_margin+378, $posY+15);
$pdf->Cell(40, 15,'��ô2', '1', '1', 'C','1');
$pdf->SetXY($left_margin+418, $posY+15);
$pdf->Cell(40, 15,'���1', '1', '1', 'C','1');
$pdf->SetXY($left_margin+458, $posY+15);
$pdf->Cell(40, 15,'���2', '1', '1', 'C','1');
$pdf->SetXY($left_margin+498, $posY+15);
$pdf->Cell(40, 15,'���3', '1', '1', 'C','1');
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

//������ǡ���
$pdf->SetXY($left_margin+38, $posY+69);
$pdf->Cell(46, 104,'������', '1', '1', 'C','1');
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+84, $posY+69);
$pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+134, $posY+69);
$pdf->Cell(404, 12.5,$customer[0], '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+81.5);
$pdf->Cell(50, 24.5,'Ǽ����̾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+81.5);
$pdf->Cell(404, 24.5,$customer[1], '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+106);
$pdf->Cell(50, 15,'͹���ֹ�', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+106);
$pdf->Cell(404, 15,$customer[2], '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+84, $posY+121);
$pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+121);
$pdf->Cell(404, 12.5,$customer[3], '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+84, $posY+133.5);
$pdf->Cell(50, 24.5,'��������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+133.5);
$pdf->Cell(404, 24.5,$customer[4], '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+158);
$pdf->Cell(50, 15,'�� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+158);
$pdf->Cell(114, 15,$customer[5], '1', '1', 'L');
$pdf->SetXY($left_margin+248, $posY+158);
$pdf->Cell(47, 15,'�� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+295, $posY+158);
$pdf->Cell(243, 15,$customer[6], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+173);
$pdf->Cell(46, 14.5,'�� ɽ ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+173);
$pdf->Cell(454, 14.5,$representative[0], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+187.5);
$pdf->Cell(46, 14.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+187.5);
$pdf->Cell(454, 14.5,$charge[0], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+202);
$pdf->Cell(46, 14.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+202);
$pdf->Cell(454, 14.5,$charge[1], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+216.5);
$pdf->Cell(46, 14.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+216.5);
$pdf->Cell(454, 14.5,$charge[2], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+231);
$pdf->Cell(46, 14.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+231);
$pdf->Cell(454, 14.5,$charge[3], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+245.5);
$pdf->Cell(46, 14.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+245.5);
$pdf->Cell(454, 14.5,$charge[4], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+260);
$pdf->Cell(46, 26,'�ĶȻ���', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+260);
$pdf->Cell(39, 13,$business[0], '1', '1', 'C');
$pdf->SetXY($left_margin+123, $posY+260);
$pdf->Cell(20, 13,'��', '1', '1', 'C');
$pdf->SetXY($left_margin+143, $posY+260);
$pdf->Cell(39, 13,$business[1], '1', '1', 'C');
$pdf->SetXY($left_margin+182, $posY+260);
$pdf->Cell(20, 13,'��', '1', '1', 'C');
$pdf->SetXY($left_margin+202, $posY+260);
$pdf->Cell(39, 13,$business[2], '1', '1', 'C');
$pdf->SetXY($left_margin+241, $posY+260);
$pdf->Cell(20, 13,'��', '1', '1', 'C');
$pdf->SetXY($left_margin+261, $posY+260);
$pdf->Cell(39, 13,$business[3], '1', '1', 'C');
$pdf->SetXY($left_margin+300, $posY+260);
$pdf->Cell(29.5, 26,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+329.5, $posY+260);
$pdf->Cell(60, 26,$holiday, '1', '1', 'C');
$pdf->SetXY($left_margin+389.5, $posY+260);
$pdf->Cell(48.5, 13,'�ȼ�', '1', '1', 'C','1');
$pdf->SetXY($left_margin+438, $posY+260);
$pdf->Cell(100, 13,$business[8], '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+273);
$pdf->Cell(39, 13,$business[4], '1', '1', 'C');
$pdf->SetXY($left_margin+123, $posY+273);
$pdf->Cell(20, 13,'��', '1', '1', 'C');
$pdf->SetXY($left_margin+143, $posY+273);
$pdf->Cell(39, 13,$business[5], '1', '1', 'C');
$pdf->SetXY($left_margin+182, $posY+273);
$pdf->Cell(20, 13,'��', '1', '1', 'C');
$pdf->SetXY($left_margin+202, $posY+273);
$pdf->Cell(39, 13,$business[6], '1', '1', 'C');
$pdf->SetXY($left_margin+241, $posY+273);
$pdf->Cell(20, 13,'��', '1', '1', 'C');
$pdf->SetXY($left_margin+261, $posY+273);
$pdf->Cell(39, 13,$business[7], '1', '1', 'C');
$pdf->SetXY($left_margin+389.5, $posY+273);
$pdf->Cell(48.5, 13,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+438, $posY+273);
$pdf->Cell(100, 13,$business[9], '1', '1', 'L');

//������ǡ���
$pdf->SetXY($left_margin+38, $posY+289);
$pdf->Cell(46, 104,'������', '1', '1', 'C','1');
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+84, $posY+289);
$pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+289);
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->Cell(404, 12.5,$claim[1], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+301.5);
$pdf->Cell(50, 24.5,'������̾', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+301.5);
$pdf->Cell(404, 24.5,$claim[2], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+326);
$pdf->Cell(50, 15,'͹���ֹ�', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+326);
$pdf->Cell(404, 15,$claim[0], '1', '1', 'C');
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+84, $posY+341);
$pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+341);
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->Cell(404, 12.5,$claim[3], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+353.5);
$pdf->Cell(50, 24.5,'��������', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+353.5);
$pdf->Cell(404, 24.5,$claim[4], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+378);
$pdf->Cell(50, 15,'�� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+378);
$pdf->Cell(114, 15,$claim[5], '1', '1', 'C');
$pdf->SetXY($left_margin+248, $posY+378);
$pdf->Cell(47, 15,'�� �� ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+295, $posY+378);
$pdf->Cell(243, 15,$claim[6], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+393);
$pdf->Cell(46, 12.5,'�� ɽ ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+393);
$pdf->Cell(454, 12.5,$representative[1], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+405.5);
$pdf->Cell(46, 12.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+405.5);
$pdf->Cell(454, 12.5,$charge[5], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+418);
$pdf->Cell(46, 12.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+418);
$pdf->Cell(454, 12.5,$charge[6], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+430.5);
$pdf->Cell(46, 12.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+430.5);
$pdf->Cell(454, 12.5,$charge[7], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+443);
$pdf->Cell(46, 12.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+443);
$pdf->Cell(454, 12.5,$charge[8], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+455.5);
$pdf->Cell(46, 12.5,'��ô����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+455.5);
$pdf->Cell(454, 12.5,$charge[9], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+468);
$pdf->Cell(46, 12.5,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+468);
$pdf->Cell(100, 12.5,'��ʧ��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+184, $posY+468);
$pdf->Cell(50, 12.5,'��ʧ��ˡ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+234, $posY+468);
$pdf->Cell(304, 12.5,'����̾��', '1', '1', 'C','1');
$pdf->SetXY($left_margin+38, $posY+480.5);
$pdf->Cell(46, 13,$payment[0], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+493.5);
$pdf->Cell(46, 13,$payment[1], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+480.5);
$pdf->Cell(50, 26,$payment[2], '1', '1', 'C');
$pdf->SetXY($left_margin+134, $posY+480.5);
$pdf->Cell(50, 26,$payment[3], '1', '1', 'C');
$pdf->SetXY($left_margin+184, $posY+480.5);
$pdf->Cell(50, 26,$payment[4], '1', '1', 'C');
$pdf->SetXY($left_margin+234, $posY+480.5);
$pdf->Cell(304, 26,$payment[5], '1', '1', 'C');

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
$pdf->SetXY($left_margin+318.2, $posY+696);
$pdf->Cell(30.8, 16.5,'���ǹ��', '1', '1', 'C','1');
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
$pdf->Cell(30.8, 16.5,'�� ��', '1', '1', 'C','1');
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

$pdf->AddPage();
//�ڡ�����¦
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+38, $posY+15);
$pdf->Cell(500, 13,'����������������¾', '1', '1', 'C','1');

$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+38, $posY+40);
$pdf->Cell(500, 13,'����', '1', '1', 'C','1');
$pdf->SetXY($left_margin+38, $posY+53);
$pdf->Cell(500, 712,'', '1', '1', 'C');

$pdf->Output();


?>
