<?php

//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);

$staff_id = $_GET[staff_id];

// staff_id�������������å�
if ($_GET["staff_id"] != null && Get_Id_Check_Db($db_con, $_GET["staff_id"], "staff_id", "t_staff", "num") != true){
    $valid_flg = true;
}elseif ($_GET["staff_id"] == null){
    $valid_flg = true;
}
if ($valid_flg == true){
    print "<span style=\"color: #ff0000; font-weight: bold; line-height: 130%; font-size: 14px;\">";
    print "<li>¸�ߤ��ʤ������åդǤ�</li>";
    print "</span><br>";
}
// ���դ������������å�
if ($_GET["y"] != null || $_GET["m"] != null || $_GET["d"] != null){
    $date_y = (int)$_GET["y"];
    $date_m = (int)$_GET["m"];
    $date_d = (int)$_GET["d"];
    $date_err_flg = !checkdate($date_m, $date_d, $date_y) ? true : false;
}else{
    $date_y = date("Y");
    $date_m = date("m");
    $date_d = date("d");
}
if ($date_err_flg == true){
    print "<span style=\"color: #ff0000; font-weight: bold; line-height: 130%; font-size: 14px;\">";
    print "<li>ȯ����������������ޤ���</li>";
    print "</span><br>";
}

///// �������鲼��GET�Υ����å��˹�ʤ�����������
if ($valid_flg == false && $date_err_flg == false){

$sql  = "SELECT ";
$sql .= " t_staff.staff_cd1, ";                   //�����åե����ɣ�
$sql .= " t_staff.staff_cd2, ";                   //�����åե����ɣ�
$sql .= " t_client.shop_name, ";                  //����å�̾
$sql .= " t_staff.staff_name, ";                  //�����å�̾
$sql .= " t_staff.staff_ascii, ";                 //�����å�̾(���޻�)
$sql .= " t_client.client_name, ";                //��̾
$sql .= " t_client.address1, ";                   //���꣱
$sql .= " t_client.address2, ";                   //���ꣲ
$sql .= " t_client.tel, ";                        //�����ֹ�
$sql .= " t_staff.photo ";                        //�̿�
$sql .= "FROM ";
$sql .= " t_client, ";
$sql .= " t_staff ";
$sql .= "LEFT JOIN ";
$sql .= " t_login ";
$sql .= "ON ";
$sql .= " t_staff.staff_id = t_login.staff_id ";
$sql .= "WHERE ";
$sql .= " t_staff.staff_id = $staff_id;";
$result = Db_Query($db_con,$sql);

$label_out = pg_fetch_array($result);
/*********************************************/

$pdf=new MBFPDF('P','pt','a4');
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(PGOTHIC,'SJIS');
$pdf->AddMBFont(MINCHO ,'SJIS');
$pdf->AddMBFont(PMINCHO,'SJIS');
$pdf->AddMBFont(KOZMIN ,'SJIS');
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//;�����
$left_margin = 40;
$top_margin = 40;

//�Ȼ���
$pdf->SetXY($left_margin,$top_margin);
$pdf->Rect($left_margin,$top_margin,220,150.5);

$pdf->SetFont(GOTHIC, 'B', 6);

//ID
$pdf->SetXY($left_margin+162,$top_margin+7.5);
$pdf->Cell(38,8,"�ɣġ�$label_out[0]-$label_out[1]",'0','1','L');

//ȯ����
$pdf->SetXY($left_margin+150,$top_margin+15);
$pdf->Cell(38,8,$date_y."ǯ ".$date_m."�� ".$date_d."��ȯ��",'0','1','L');

//����å�̾
$pdf->SetFont(GOTHIC, 'B', 7.5);
$pdf->SetXY($left_margin+106,$top_margin+33);
$pdf->Cell(85,8,"����˥ƥ��ͥåȥ������Ź",'0','1','L');
$pdf->SetFont(GOTHIC, 'B', 9);
$pdf->SetXY($left_margin+106,$top_margin+43);
$pdf->Cell(110,16,$label_out[2],'0','1','R');

//̾��
$pdf->SetFont(GOTHIC, 'B', 14);
$pdf->SetXY($left_margin+103,$top_margin+70);
$pdf->Cell(90,16,$label_out[3],'0','1','C');

//���޻�
$pdf->SetFont(GOTHIC, 'B', 9);
$pdf->SetXY($left_margin+103,$top_margin+90);
$pdf->Cell(90,16,$label_out[4],'0','1','C');

//�嵭�μ�
$pdf->SetFont(GOTHIC, '', 6.5);
$pdf->SetXY($left_margin+108,$top_margin+106);
$pdf->Cell(85,16,"�嵭�μԤ򥢥�˥ƥ��ͥåȥ����",'0','1','C');
$pdf->SetXY($left_margin+101,$top_margin+113);
$pdf->Cell(85,16,"���С��Ǥ��뤳�Ȥ�������롣",'0','1','C');

//tel
$pdf->SetFont(GOTHIC, '', 6);
$pdf->SetXY($left_margin+145,$top_margin+135);
$pdf->Cell(85,16,"tel��".$label_out[8],'0','1','C');

//��
$pdf->SetLineWidth(0.5);
$pdf->SetDrawColor(204,255,255);
$pdf->SetFillColor(204,255,255);
$pdf->SetXY($left_margin+0.5,$top_margin+0.5);
$pdf->Cell($left_margin+25.5,$top_margin+109.5,"",'0','1','L','1');
$pdf->Line(100,144,257,144);

//��
$pdf->Image(IMAGE_DIR.'company-rogo_clear.png',$left_margin+7, $top_margin+2,80,26);

//AMENITY
$pdf->SetFont(GOTHIC, '', 7);
$pdf->SetXY($left_margin+13,$top_margin+25);
$pdf->Cell(85,16,"AMENITY NETWORK",'0','1','L');
$pdf->SetXY($left_margin+4,$top_margin+34);
$pdf->Cell(76.3,16,"ID CARD",'0','1','C');
if($label_out[9] != null){
	//�̿�
	$pdf->SetFillColor(255,255,255);
	$pdf->Image('../../../data/photo/'.$label_out[9],$left_margin+15.37, $top_margin+50,62,65);
	$pdf->Image(IMAGE_DIR.'fframe.png',$left_margin+15.37, $top_margin+50,62,65);
}
//����
$pdf->SetFont(GOTHIC, '', 6);
$pdf->SetXY($left_margin+4,$top_margin+125);
$pdf->Cell(85,16,$label_out[5],'0','1','L');
$pdf->SetXY($left_margin+9,$top_margin+134);
$pdf->Cell(85,16,$label_out[6].$label_out[7],'0','1','L');

$pdf->Output();

}

?>
