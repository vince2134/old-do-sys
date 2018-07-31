<?php


/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-08-27                  watanabe-k  �����襳���ɤι��ܤ��ɲ�
 *                              watanabe-k  ��������������ޥ�������Ͽ����ɽ������褦�˽���
 *                              watanabe-k  �ѹ�������¤Ӥ򾺽���ѹ�
 *  
 *
*/


// �Ķ�����ե�����
require_once("ENV_local.php");

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);

require('../../../fpdf/mbfpdf.php');

$pdf=new MBFPDF('P','pt','a3w');

$pdf->AddMBFont(GOTHIC ,'SJIS');

$pdf->SetAutoPageBreak(false);

/***********************/
//�����ѿ�
/***********************/
$post_client_id = $_POST["form_card_check"];

/***********************/
//�������
/***********************/
$con_rows     = 10;   //�����ɽ������Կ�
$left_margin  = 55;    //���ޡ�����
$top_margin   = 15;    //��ޡ�����

/***********************/
//�ᥤ�����(PDF����)
/***********************/
//���򤵤줿������ο�ʬ�롼��
foreach($post_client_id AS $client_id){

    //�����å��ܥå��������򤵤�Ƥ��ʤ����
    if($client_id == null || $client_id == 'f'){
        $null_count += 1;
        continue;
    }

    //������ξ�������
    $client_card_data = Client_Card_Data($db_con, $client_id);

    //������ޥ������ѹ������������
    $client_change_history = Client_Change_History($db_con, $client_id); 

    //������ο�ʬ�롼��(����롼�׿���)
    foreach($client_card_data AS $claim_data){

        //�����褴�Ȥη���ǡ��������
        $claim_con_data = Claim_Con_Data($db_con, $client_id, $claim_data["claim_id"], $claim_data["claim_div"]);

        $con_goods_count = count($claim_con_data);      //���󤷤Ƥ��뾦�ʿ�

        //���ʿ������ɽ�����ǳ�ꡢ�롼�ײ��������(ü���ھ夲)
        $roup_count = ceil($con_goods_count / $con_rows);
        if($roup_count == 0){
            $roup_count = 1;
        }

        for($i = 0; $i < $roup_count; $i++){
            //PDF����
            $pdf->AddPage();

            //�إå�����
            $top_margin_1 = Client_Card_H($pdf, $left_margin, $top_margin, $claim_data);

            //�������������
            $top_margin_2 = Client_Card_D($pdf, $left_margin, $top_margin_1, $claim_data);

            //�������������
            $top_margin_3 = Client_Card_D($pdf, $left_margin, $top_margin_2, $claim_data, 1);

            //�����������
            $top_margin_4 = Client_Card_C($pdf, $left_margin, $top_margin_3, $claim_con_data, $i);

            //������ޥ������ѹ����������
            Client_Card_History ($pdf, $left_margin, $top_margin_4, $claim_data["round_day"], $client_change_history);
        }
    }
}


//���顼����
if($null_count === count($_POST["form_card_check"])){
    print "<b>";
    print " <font color=#ff0000><li>�����ͥ����ɤ������������������򤷤Ʋ�������</font>";
    print "</b>"; 

    exit;   
}

$pdf->Output();

/*************************/
//�ڡ�����ؿ�
/*************************/
//�����ͥ����ɤ�TOP������
function Client_Card_H ($pdf, $left_margin, $top_margin, $client_data){

    //�طʿ�
    $pdf->SetFillColor(180,180,180);

    //�ڡ�����¦
    $pdf->SetFont(GOTHIC,'', 10.5);
    $pdf->SetXY($left_margin+575, $top_margin);
    $pdf->Cell(510, 13,'����������������¾', '1', '1', 'C','1');

    $pdf->SetFont(GOTHIC, 'B', 14);
    $pdf->SetXY($left_margin,  $top_margin);
    $pdf->Cell(97, 49,'�����ͥ�����', '1', '1', 'C');
    $pdf->SetXY($left_margin+117, $top_margin);
    $pdf->Cell(150, 49,'', '1', '1', 'C');
    $pdf->SetXY($left_margin+300, $top_margin);
    $pdf->Cell(200, 49,'', '1', '1', 'C');
    $pdf->SetFont(GOTHIC,'', 10.5);
    $pdf->SetXY($left_margin+575, $top_margin+25);
    $pdf->Cell(510, 13,'����', '1', '1', 'C','1');

    //����
    $note = explode('
', $client_data["note"]);
    $pdf->SetXY($left_margin+575, $top_margin+38);
    $pdf->Cell(510, 20,$note[0], 'LTR', '1', 'L');
    $row_margin = 20;
    for($i = 0; $i < 35; $i++){
        $pdf->SetXY($left_margin+575, $top_margin+38+$row_margin);
        $pdf->Cell(510, 20,$note[$i+1], 'LR', '1', 'L');
        $row_margin+=20;
    }
    $pdf->SetXY($left_margin+575, $top_margin+38+$row_margin);
    $pdf->Cell(510, 32, '', 'LBR', '1', 'R');

    //TOP
    //�����ͥ����ɺ���ǯ����

    $create_day = explode("-", $client_data["create_day"]);


    $pdf->SetLineWidth(0.2);
    $pdf->SetXY($left_margin+117, $top_margin);
    $pdf->Cell(150, 15,'�����ͥ����ɺ���ǯ����', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+132, $top_margin+15);
    $pdf->Cell(30, 34, $create_day[0], '0', '1', 'R');
    $pdf->SetXY($left_margin+162, $top_margin+15);
    $pdf->Cell(15, 34,'ǯ', '0', '1', 'L');
    $pdf->SetXY($left_margin+177, $top_margin+15);
    $pdf->Cell(20, 34, $create_day[1], '0', '1', 'R');
    $pdf->SetXY($left_margin+197, $top_margin+15);
    $pdf->Cell(15, 34,'��', '0', '1', 'L');
    $pdf->SetXY($left_margin+212, $top_margin+15);
    $pdf->Cell(20, 34, $create_day[2], '0', '1', 'R');
    $pdf->SetXY($left_margin+232, $top_margin+15);
    $pdf->Cell(15, 34,'��', '0', '1', 'L');
    $pdf->SetXY($left_margin+300, $top_margin);
    $pdf->Cell(100, 15,'������ô��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+400, $top_margin);
    $pdf->Cell(100, 15,'�������ô��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+300, $top_margin+15);
    $pdf->Cell(100, 34,$client_data["c_staff_name1"], '1', '1', 'C');
    $pdf->SetXY($left_margin+400, $top_margin+15);
    $pdf->Cell(100, 34,$client_data["c_staff_name2"], '1', '1', 'C');

    $top_margin = $pdf->GetY(); //�إå�������TOP�ޡ�����

    return $top_margin;
}

//�����衦������ξ�������褹��ؿ�
//$client_div == '1'�ΤȤ���������ξ���
function Client_Card_D ($pdf, $left_margin, $top_margin, $client_data, $client_div=null){

    //������ξ���������ξ���Ʊ���ѿ���Ż���
    //������ξ��
    if($client_div == null){
        $client_cd      = $client_data["client_cd"];                //�����襳����
        $client_name    = $client_data["client_name"];              //������̾
        $client_read    = $client_data["client_read"];              //������̾�ʥեꥬ�ʡ�
        $post_no        = $client_data["post_no"];                  //͹���ֹ�
        $address1       = $client_data["address1"];                 //���꣱
        $address2       = $client_data["address2"];                 //���ꣲ
        $address3       = $client_data["address3"];                 //���ꣳ
        $address_read   = $client_data["address_read"];             //����ʥեꥬ�ʡ�
        $tel            = $client_data["tel"];                      //TEL
        $fax            = $client_data["fax"];                      //FAX
        $rep_name       = $client_data["rep_name"];                 //��ɽ�Ի�̾
        $charger1       = $client_data["charger1"];                 //ô����
        $charger2       = $client_data["charger2"];                 //ô����
        $charger3       = $client_data["charger3"];                 //ô����
        $c_part1        = $client_data["charger_part1"];            //ô��������
        $c_part2        = $client_data["charger_part2"];            //ô��������
        $c_part3        = $client_data["charger_part3"];            //ô��������
        $c_represe1     = $client_data["charger_represe1"];         //ô������
        $c_represe2     = $client_data["charger_represe2"];         //ô������
        $c_represe3     = $client_data["charger_represe3"];         //ô������
        $c_note         = Mb_Str_Split($client_data["charger_note"],37);//ô������
        $stime1         = explode(':',$client_data["trade_stime1"]);//�������ϻ���
        $etime1         = explode(':',$client_data["trade_etime1"]);//������λ����
        $stime2         = explode(':',$client_data["trade_stime2"]);//��峫�ϻ���
        $etime2         = explode(':',$client_data["trade_etime2"]);//��彪λ����
        $holiday        = $client_data["holiday"];                  //����
        $btype_name     = $client_data["btype_name"];               //�ȼ�
        $bstruct_name   = $client_data["bstruct_name"];             //����

        //����̾
        $title1 = "������";
        $title2 = "Ǽ����̾";
        $title3 = "Ǽ����";

    //������ξ��
    }else{
        $client_cd      = $client_data["claim_cd"];                 //�����襳����
        $client_name    = $client_data["claim_name"];               //������̾
        $client_read    = $client_data["claim_read"];               //������̾�ʥեꥬ�ʡ�
        $post_no        = $client_data["claim_post_no"];            //͹���ֹ�
        $address1       = $client_data["claim_address1"];           //���꣱
        $address2       = $client_data["claim_address2"];           //���ꣲ
        $address3       = $client_data["claim_address3"];           //���ꣳ
        $address_read   = $client_data["claim_address_read"];       //����ʥեꥬ�ʡ�
        $tel            = $client_data["claim_tel"];                //TEL
        $fax            = $client_data["claim_fax"];                //FAX
        $rep_name       = $client_data["claim_rep_name"];           //��ɽ�Ի�̾
        $charger1       = $client_data["claim_charger1"];           //ô����
        $charger2       = $client_data["claim_charger2"];           //ô����
        $charger3       = $client_data["claim_charger3"];           //ô����
        $c_part1        = $client_data["claim_charger_part1"];      //ô��������
        $c_part2        = $client_data["claim_charger_part2"];      //ô��������
        $c_part3        = $client_data["claim_charger_part3"];      //ô��������
        $c_represe1     = $client_data["claim_charger_represe1"];   //ô������
        $c_represe2     = $client_data["claim_charger_represe2"];   //ô������
        $c_represe3     = $client_data["claim_charger_represe3"];   //ô������
        $c_note         = $client_data["claim_charger_note"];       //ô������
        $trade_name     = $client_data["claim_trade"];              //�����ʬ
        $close_day      = $client_data["claim_close_day"];          //����
        $pay_m          = $client_data["claim_pay_m"];              //�������ʷ��
        $pay_d          = $client_data["claim_pay_d"];              //������������
        $pay_way        = $client_data["claim_pay_way"];            //������ˡ
        $pay_name       = $client_data["claim_pay_name"];           //����̾��

        //����̾
        $title1 = "������";
        $title2 = "������̾";
        $title3 = "������";
    }

    //�ȥåץޡ�����˥��ڡ�����ץ饹
    $top_margin += 5;       //�ȥåץޡ�����

    //������ǡ���
    $pdf->SetXY($left_margin, $top_margin);
    $pdf->Cell(46, 104,$title1, '1', '1', 'C','1');
    $pdf->SetFont(GOTHIC,'', 8);
    //������̾�ʥեꥬ�ʡ�
    $pdf->SetXY($left_margin+46, $top_margin);
    $pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
    $pdf->SetFont(GOTHIC,'', 10.5);
    $pdf->SetXY($left_margin+96, $top_margin);
    $pdf->Cell(404, 12.5,$client_read, '1', '1', 'L');
    //�����襳����
    $pdf->SetXY($left_margin+46, $top_margin+12.5);
    $pdf->Cell(50, 12.25,$title3, 'LTR', '1', 'C','1');
    $pdf->SetXY($left_margin+46, $top_margin+24.75);
    $pdf->Cell(50, 12.25,"������", 'LBR', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+12.5);
    $pdf->Cell(70, 24.5,$client_cd, '1', '1', 'L');
    //������̾
    $pdf->SetXY($left_margin+166, $top_margin+12.5);
    $pdf->Cell(50, 24.5,$title2, '1', '1', 'C','1');
    $pdf->SetXY($left_margin+216, $top_margin+12.5);
    $pdf->Cell(284, 24.5,$client_name, '1', '1', 'L');
    //͹���ֹ�
    $pdf->SetXY($left_margin+46, $top_margin+37);
    $pdf->Cell(50, 15,'͹���ֹ�', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+37);
    $pdf->Cell(404, 15,$post_no, '1', '1', 'L');
    //����ʥեꥬ�ʡ�
    $pdf->SetFont(GOTHIC,'', 8);
    $pdf->SetXY($left_margin+46, $top_margin+52);
    $pdf->Cell(50, 12.5,'�� �� �� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+52);
    //����
    $pdf->SetFont(GOTHIC,'', 10.5);
    $pdf->Cell(404, 12.5,$address_read, '1', '1', 'L');
    $pdf->SetXY($left_margin+46, $top_margin+64.5);
    $pdf->Cell(50, 24.5,'��������', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+64.5);
    $pdf->Cell(404, 24.5,$address1.$address2.$address3, '1', '1', 'L');
    //TEL
    $pdf->SetXY($left_margin+46, $top_margin+89);
    $pdf->Cell(50, 15,'�� �� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+89);
    $pdf->Cell(114, 15,$tel, '1', '1', 'L');
    //FAX
    $pdf->SetXY($left_margin+210, $top_margin+89);
    $pdf->Cell(47, 15,'�� �� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+257, $top_margin+89);
    $pdf->Cell(243, 15,$fax, '1', '1', 'L');
    //��ɽ��̾
    $pdf->SetXY($left_margin, $top_margin+104);
    $pdf->Cell(96, 14.5,'�� ɽ ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+104);
    $pdf->Cell(404, 14.5,$rep_name, '1', '1', 'L');
    //ô���Ծ���
    $pdf->SetXY($left_margin, $top_margin+118.5);
    $pdf->Cell(46, 101.5,'ô������', '1', '1', 'C', '1');
    //ô��1
    $pdf->SetXY($left_margin+46, $top_margin+118.5);
    $pdf->Cell(15, 14.5,'��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+61, $top_margin+118.5);
    $pdf->Cell(35, 14.5,'�� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+118.5);
    $pdf->Cell(111, 14.5,$c_part1, '1', '1', 'L');
    $pdf->SetXY($left_margin+207, $top_margin+118.5);
    $pdf->Cell(35, 14.5,'�� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+242, $top_margin+118.5);
    $pdf->Cell(111, 14.5,$c_represe1, '1', '1', 'L');
    $pdf->SetXY($left_margin+353, $top_margin+118.5);
    $pdf->Cell(35, 14.5,'�� ̾', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+388, $top_margin+118.5);
    $pdf->Cell(112, 14.5,$charger1, '1', '1', 'L');
    //ô��2
    $pdf->SetXY($left_margin+46, $top_margin+133);
    $pdf->Cell(15, 14.5,'��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+61, $top_margin+133);
    $pdf->Cell(35, 14.5,'�� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+133);
    $pdf->Cell(111, 14.5,$c_part2, '1', '1', 'L');
    $pdf->SetXY($left_margin+207, $top_margin+133);
    $pdf->Cell(35, 14.5,'�� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+242, $top_margin+133);
    $pdf->Cell(111, 14.5,$c_represe2, '1', '1', 'L');
    $pdf->SetXY($left_margin+353, $top_margin+133);
    $pdf->Cell(35, 14.5,'�� ̾', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+388, $top_margin+133);
    $pdf->Cell(112, 14.5,$charger2, '1', '1', 'L');
    //ô��3
    $pdf->SetXY($left_margin+46, $top_margin+147.5);
    $pdf->Cell(15, 14.5,'��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+61, $top_margin+147.5);
    $pdf->Cell(35, 14.5,'�� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+147.5);
    $pdf->Cell(111, 14.5,$c_part3, '1', '1', 'L');
    $pdf->SetXY($left_margin+207, $top_margin+147.5);
    $pdf->Cell(35, 14.5,'�� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+242, $top_margin+147.5);
    $pdf->Cell(111, 14.5,$c_represe3, '1', '1', 'L');
    $pdf->SetXY($left_margin+353, $top_margin+147.5);
    $pdf->Cell(35, 14.5,'�� ̾', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+388, $top_margin+147.5);
    $pdf->Cell(112, 14.5,$charger3, '1', '1', 'L');
    //����
    $pdf->SetXY($left_margin+46, $top_margin+162);
    $pdf->Cell(50, 58,'�� ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+96, $top_margin+162);
    $pdf->Cell(404, 14.5,$c_note[0], 'R', '1', 'L');
    $pdf->SetXY($left_margin+96, $top_margin+176.5);
    $pdf->Cell(404, 14.5,$c_note[1], 'R', '1', 'L');
    $pdf->SetXY($left_margin+96, $top_margin+191);
    $pdf->Cell(404, 14.5,$c_note[2], 'R', '1', 'L');
    $pdf->SetXY($left_margin+96, $top_margin+205.5);
    $pdf->Cell(404, 14.5,$c_note[3], 'BR', '1', 'L');

    $top_margin = $pdf->GetY(); //������OR���������������TOP�ޡ�����
    
    //���������
    if($client_div == null){
        //�ĶȻ���
        $pdf->SetXY($left_margin, $top_margin);
        $pdf->Cell(96, 26,'�ĶȻ���', '1', '1', 'C','1');
        //����
        $pdf->SetXY($left_margin+96, $top_margin);
        $pdf->Cell(25, 13,$stime1[0], '1', '1', 'C');
        $pdf->SetXY($left_margin+121, $top_margin);
        $pdf->Cell(10, 13,'��', '1', '1', 'C');
        $pdf->SetXY($left_margin+131, $top_margin);
        $pdf->Cell(25, 13,$stime1[1], '1', '1', 'C');
        $pdf->SetXY($left_margin+156, $top_margin);
        $pdf->Cell(15, 13,'��', '1', '1', 'C');
        $pdf->SetXY($left_margin+171, $top_margin);
        $pdf->Cell(25, 13,$etime1[0], '1', '1', 'C');
        $pdf->SetXY($left_margin+196, $top_margin);
        $pdf->Cell(10, 13,'��', '1', '1', 'C');
        $pdf->SetXY($left_margin+206, $top_margin);
        $pdf->Cell(25, 13,$etime1[1], '1', '1', 'C');
        //���
        $pdf->SetXY($left_margin+96, $top_margin+13);
        $pdf->Cell(25, 13,$etime1[0], '1', '1', 'C');
        $pdf->SetXY($left_margin+121, $top_margin+13);
        $pdf->Cell(10, 13,'��', '1', '1', 'C');
        $pdf->SetXY($left_margin+131, $top_margin+13);
        $pdf->Cell(25, 13,$etime1[1], '1', '1', 'C');
        $pdf->SetXY($left_margin+156, $top_margin+13);
        $pdf->Cell(15, 13,'��', '1', '1', 'C');
        $pdf->SetXY($left_margin+171, $top_margin+13);
        $pdf->Cell(25, 13,$etime2[0], '1', '1', 'C');
        $pdf->SetXY($left_margin+196, $top_margin+13);
        $pdf->Cell(10, 13,'��', '1', '1', 'C');
        $pdf->SetXY($left_margin+206, $top_margin+13);
        $pdf->Cell(25, 13,$etime2[1], '1', '1', 'C');
        //����
        $pdf->SetXY($left_margin+231, $top_margin);
        $pdf->Cell(35, 26,'�� ��', '1', '1', 'C','1');
        $pdf->SetXY($left_margin+266, $top_margin);
        $pdf->Cell(60, 26,$holiday, '1', '1', 'C');
        //�ȼ�
        $pdf->SetXY($left_margin+326, $top_margin);
        $pdf->Cell(35, 13,'�� ��', '1', '1', 'C','1');
        $pdf->SetXY($left_margin+361, $top_margin);
        $pdf->Cell(139, 13,$btype_name, '1', '1', 'L');
        //����
        $pdf->SetXY($left_margin+326, $top_margin+13);
        $pdf->Cell(35, 13,'�� ��', '1', '1', 'C','1');
        $pdf->SetXY($left_margin+361, $top_margin+13);
        $pdf->Cell(139, 13,$bstruct_name, '1', '1', 'L');
    }else{
        $pdf->SetXY($left_margin, $top_margin);
        $pdf->Cell(46, 12.5,'����', '1', '1', 'C','1');
        $pdf->SetXY($left_margin+46, $top_margin);
        $pdf->Cell(100, 12.5,'��ʧ��', '1', '1', 'C','1');
        $pdf->SetXY($left_margin+146, $top_margin);
        $pdf->Cell(50, 12.5,'��ʧ��ˡ', '1', '1', 'C','1');
        $pdf->SetXY($left_margin+196, $top_margin);
        $pdf->Cell(304, 12.5,'����̾��', '1', '1', 'C','1');
        $pdf->SetXY($left_margin, $top_margin+12.5);
        $pdf->Cell(46, 13,$trade_name, '1', '1', 'C');
        $pdf->SetXY($left_margin, $top_margin+25.5);
        $pdf->Cell(46, 13,$close_day, '1', '1', 'C');
        $pdf->SetXY($left_margin+46, $top_margin+12.5);
        $pdf->Cell(50, 26,$pay_m, '1', '1', 'C');
        $pdf->SetXY($left_margin+96, $top_margin+12.5);
        $pdf->Cell(50, 26,$pay_d, '1', '1', 'C');
        $pdf->SetXY($left_margin+146, $top_margin+12.5);
        $pdf->Cell(50, 26,$pay_way, '1', '1', 'C');
        $pdf->SetXY($left_margin+196, $top_margin+12.5);
        $pdf->Cell(304, 26,$pay_name, '1', '1', 'L');
    }

    $top_margin = $pdf->GetY(); //������OR���������������TOP�ޡ�����

    return $top_margin;
}

//����ǡ�������
function Client_Card_C($pdf, $left_margin, $top_margin, $con_data, $page){
    //�ȥåץޡ�����˥��ڡ�����ץ饹
    $top_margin += 5;       //�ȥåץޡ�����

    //����̾
    $pdf->SetFont(GOTHIC,'', 9);
    $pdf->SetXY($left_margin, $top_margin);
    $pdf->Cell(20, 24,'����', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+20, $top_margin);
    $pdf->Cell(35, 12,'����ñ��', 'LTR', '1', 'C','1');
    $pdf->SetXY($left_margin+20, $top_margin+12);
    $pdf->Cell(35, 12,'(W��M)', 'LBR', '1', 'C','1');
    $pdf->SetXY($left_margin+55, $top_margin);
    $pdf->Cell(20, 24,'��̾', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+75, $top_margin);
    $pdf->Cell(20, 12,'����', 'LTR', '1', 'C','1');
    $pdf->SetXY($left_margin+75, $top_margin+12);
    $pdf->Cell(20, 12,'��', 'LBR', '1', 'C','1');
    $pdf->SetXY($left_margin+95, $top_margin);
    $pdf->Cell(230, 24,'�����ӥ�/�����ƥ�', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+325, $top_margin);
    $pdf->Cell(20, 24,'����', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+345, $top_margin);
    $pdf->Cell(40, 24,'ñ ��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+385, $top_margin);
    $pdf->Cell(40, 24,'�⡡��', '1', '1', 'C','1');
    $pdf->SetXY($left_margin+425, $top_margin);
    $pdf->Cell(75, 24,'���ô����', '1', '1', 'C','1');

    $top_margin = $pdf->GetY(); 

    $pdf->SetFont(GOTHIC,'', 7);
    //�ǡ����ܺ�
    $row_margin = 0;
    for($i = $page; $i < $page+10; $i++){

        //�ѿ��֤�����
        //��ʣ����򥯥ꥢ
        if($contract_id == $con_data[$i]["contract_id"]){
            $cycle  = null;
            $unit   = null;
            $week   = null;
            $rday   = null;
            $staff_name = null;
        }else{
            $contract_id = $con_data[$i]["contract_id"];
            $cycle  = $con_data[$i]["cycle"];
            $unit   = $con_data[$i]["unit"];
            $week   = $con_data[$i]["week"];
            $rday   = $con_data[$i]["rday"];
            $staff_name = $con_data[$i]["staff_name"];
        }

        $goods_name = $con_data[$i]["goods_name"];
        $num        = $con_data[$i]["num"];
        $sale_price = My_Number_Format($con_data[$i]["sale_price"],2);
        $sale_amount = My_Number_Format($con_data[$i]["sale_amount"]);

        $pdf->SetXY($left_margin, $top_margin+$row_margin);
        $pdf->Cell(20, 15,$cycle, '1', '1', 'C');
        $pdf->SetXY($left_margin+20, $top_margin+$row_margin);
        $pdf->Cell(35, 15,$unit, '1', '1', 'C');
        $pdf->SetXY($left_margin+55, $top_margin+$row_margin);
        $pdf->Cell(20, 15,$week, '1', '1', 'C');
        $pdf->SetXY($left_margin+75, $top_margin+$row_margin);
        $pdf->Cell(20, 15,$rday, '1', '1', 'C');
        $pdf->SetXY($left_margin+95, $top_margin+$row_margin);
        $pdf->Cell(230, 15,$goods_name, '1', '1', 'L');
        $pdf->SetXY($left_margin+325, $top_margin+$row_margin);
        $pdf->Cell(20, 15,$num, '1', '1', 'R');
        $pdf->SetXY($left_margin+345, $top_margin+$row_margin);
        $pdf->Cell(40, 15,$sale_price, '1', '1', 'R');
        $pdf->SetXY($left_margin+385, $top_margin+$row_margin);
        $pdf->Cell(40, 15,$sale_amount, '1', '1', 'R');
        $pdf->SetXY($left_margin+425, $top_margin+$row_margin);
        $pdf->Cell(75, 15,$staff_name, '1', '1', 'L');

        //����
        $row_margin += 15;

        //ñ���ι��
        if($con_data[$i]["sale_price"] != null){
            $total_price = bcadd($total_price, $con_data[$i]["sale_price"],2);
        }
        //����ۤι��
        if($con_data[$i]["sale_amount"]){
            $total_amount = bcadd($total_amount, $con_data[$i]["sale_amount"]);
        }
    }

    //���
    $pdf->SetFont(GOTHIC,'', 9);
    $pdf->SetXY($left_margin+325, $top_margin+150);
    $pdf->Cell(20, 16.5,'���', '1', '1', 'C','1');
    $pdf->SetFont(GOTHIC,'', 7);
    $pdf->SetXY($left_margin+345, $top_margin+150);
    $pdf->Cell(40, 16.5,My_Number_Format($total_price,2), '1', '1', 'R');
    $pdf->SetXY($left_margin+385, $top_margin+150);
    $pdf->Cell(40, 16.5,My_Number_Format($total_amount), '1', '1', 'R');

    $top_margin = $pdf->GetY(); //�������������TOP�ޡ�����

    return $top_margin;
}

//������ޥ����ι��������ɽ������
function Client_Card_History ($pdf, $left_margin, $top_margin, $start_day, $history_data){

    $top_margin = $top_margin - 15;


    $pdf->SetFont(GOTHIC,'', 9);

    //������
    $start_day  = explode("-",$start_day);

    $pdf->SetXY($left_margin, $top_margin);
    $pdf->Cell(22, 15,'������', 'B', '1', 'C');
    $pdf->SetXY($left_margin+22, $top_margin);
    $pdf->Cell(35, 15,$start_day["0"], 'B', '1', 'R');
    $pdf->SetXY($left_margin+57, $top_margin);
    $pdf->Cell(10, 15,'ǯ', 'B', '1', 'L');
    $pdf->SetXY($left_margin+67, $top_margin);
    $pdf->Cell(20, 15,$start_day["1"], 'B', '1', 'R');
    $pdf->SetXY($left_margin+87, $top_margin);
    $pdf->Cell(10, 15,'��', 'B', '1', 'L');
    $pdf->SetXY($left_margin+97, $top_margin);
    $pdf->Cell(20, 15,$start_day["2"], 'B', '1', 'R');
    $pdf->SetXY($left_margin+117, $top_margin);
    $pdf->Cell(10, 15,'��', 'B', '1', 'L');

    $top_margin = $pdf->GetY(); 

    //��������
    $his_count = count($history_data);
    $row_margin = 0;
    for($i = 0; $i < $his_count; $i++){

        $his_day = explode('-',$history_data[$i]["renew_time"]);


        $pdf->SetXY($left_margin, $top_margin+$row_margin);
        $pdf->Cell(22, 15,'������', 'B', '1', 'C');
        $pdf->SetXY($left_margin+22, $top_margin+$row_margin);
        $pdf->Cell(35, 15,$his_day["0"], 'B', '1', 'R');
        $pdf->SetXY($left_margin+57, $top_margin+$row_margin);
        $pdf->Cell(10, 15,'ǯ', 'B', '1', 'L');
        $pdf->SetXY($left_margin+67, $top_margin+$row_margin);
        $pdf->Cell(20, 15,$his_day["1"], 'B', '1', 'R');
        $pdf->SetXY($left_margin+87, $top_margin+$row_margin);
        $pdf->Cell(10, 15,'��', 'B', '1', 'L');
        $pdf->SetXY($left_margin+97, $top_margin+$row_margin);
        $pdf->Cell(20, 15,$his_day["2"], 'B', '1', 'R');
        $pdf->SetXY($left_margin+117, $top_margin+$row_margin);
        $pdf->Cell(10, 15,'��', 'B', '1', 'L');
        $pdf->SetXY($left_margin+127, $top_margin+$row_margin);
        $pdf->Cell(50, 15,'������', 'B', '1', 'C');
        $pdf->SetXY($left_margin+177, $top_margin+$row_margin);
        $pdf->Cell(100, 15,$history_data[$i]["staff_name"], 'B', '1', 'L');

        $row_margin += 15;
    }
}

//������ξ������Ф���ؿ�
function Client_Card_Data ($db_con, $client_id){

    $sql = "
            SELECT
                --���������
                t_client.client_cd1 || '-' || t_client.client_cd2 AS client_cd,
                TO_DATE(t_client.create_day, 'YYYY-MM-DD') AS create_day,
                t_client.client_name,
                t_client.client_read,
                t_client.post_no1 || '-' || t_client.post_no2 AS post_no,
                t_client.address1,
                t_client.address2,
                t_client.address3,
                t_client.address_read,
                t_client.tel,
                t_client.fax,
                t_client.rep_name,
                t_client.charger1,
                t_client.charger2,
                t_client.charger3,
                t_client.charger_part1,
                t_client.charger_part2,
                t_client.charger_part3,
                t_client.charger_represe1,
                t_client.charger_represe2,
                t_client.charger_represe3,
                t_client.charger_note,
                t_client.trade_stime1,
                t_client.trade_etime1,
                t_client.trade_stime2,
                t_client.trade_etime2,
                t_client.holiday,
                t_client.round_day,
                t_client.note,
                t_lbtype.lbtype_name || '/' || t_sbtype.sbtype_name AS btype_name,
                t_bstruct.bstruct_name,
                t_staff1.staff_name AS c_staff_name1,
                t_staff2.staff_name AS c_staff_name2,
                --������1����
                t_claim_client.client_id AS claim_id,
                t_claim.claim_div,
                t_claim_client.client_cd1 || '-' || t_claim_client.client_cd2 AS claim_cd,
                t_claim_client.client_name AS claim_name,
                t_claim_client.client_read AS claim_read,
                t_claim_client.post_no1 || '-' || t_claim_client.post_no2 AS claim_post_no,
                t_claim_client.address1 AS claim_address1,
                t_claim_client.address2 AS claim_address2,
                t_claim_client.address3 AS claim_address3,
                t_claim_client.tel AS claim_tel,
                t_claim_client.fax AS claim_fax,
                t_claim_client.address_read AS claim_address_read,
                t_claim_client.charger1 AS claim_charger1,
                t_claim_client.charger2 AS claim_charger2,
                t_claim_client.charger3 AS claim_charger3,
                t_claim_client.charger_part1 AS claim_charger_part1,
                t_claim_client.charger_part2 AS claim_charger_part2,
                t_claim_client.charger_part3 AS claim_charger_part3,
                t_claim_client.charger_represe1 AS claim_charger_represe1,
                t_claim_client.charger_represe2 AS claim_charger_represe2,
                t_claim_client.charger_represe3 AS claim_charger_represe3,
                t_claim_client.charger_note AS claim_charger_note,
                CASE t_claim_client.trade_id
                    WHEN '11' THEN '����'
                    WHEN '12' THEN '����'
                END AS claim_trade,
                CASE t_claim_client.close_day
                    WHEN '29' THEN '����'
                    ELSE t_claim_client.close_day || '��'
                END AS claim_close_day,
                CASE t_claim_client.pay_m
                    WHEN '0' THEN '����'
                    WHEN '1' THEN '���'
                    ELSE t_claim_client.pay_m || '�����'
                END AS claim_pay_m,
                CASE t_claim_client.pay_d
                    WHEN '29' THEN '����'
                    ELSE t_claim_client.pay_d || '��'
                END AS claim_pay_d,
                CASE t_claim_client.pay_way 
                    WHEN '1' THEN '��ư����'
                    WHEN '2' THEN '����'
                    WHEN '3' THEN 'ˬ�佸��'
                    WHEN '4' THEN '���'
                    WHEN '5' THEN '����¾'
                END AS claim_pay_way,
                t_claim_client.pay_name AS claim_pay_name
            FROM
                t_client
                    INNER JOIN
                t_sbtype
                ON t_client.sbtype_id = t_sbtype.sbtype_id
                    INNER JOIN
                t_lbtype
                ON t_sbtype.lbtype_id = t_lbtype.lbtype_id
                    LEFT JOIN
                t_bstruct
                ON t_client.b_struct = t_bstruct.bstruct_id
                    LEFT JOIN
                t_staff AS t_staff1
                ON t_client.c_staff_id1 = t_staff1.staff_id
                    LEFT JOIN
                t_staff AS t_staff2
                ON t_client.c_staff_id2 = t_staff2.staff_id
                    INNER JOIN
                t_claim AS t_claim
                ON t_client.client_id = t_claim.client_id
                    LEFT JOIN
                t_client AS t_claim_client
                ON t_claim.claim_id = t_claim_client.client_id
            WHERE
                t_client.client_id = $client_id
            ORDER BY t_claim.claim_div
        ;
    ";

    $result =  Db_Query($db_con, $sql);
    $client_card_data = pg_fetch_all($result);

    return $client_card_data;
}

//������ޥ������ѹ��������Ф���ؿ�
function Client_Change_History($db_con, $client_id){
    $sql = "
        SELECT
            TO_DATE(t_renew.renew_time, 'YYYY-MM-DD') AS renew_time,
            t_staff.staff_name
        FROM
            t_renew
                INNER JOIN 
            t_staff
            ON t_renew.staff_id = t_staff.staff_id
        WHERE
            t_renew.client_id = $client_id
        ORDER BY renew_time DESC LIMIT 3
        ;
    ";

    $result = Db_Query($db_con, $sql);
    $renew_data = pg_fetch_all($result);

    return $renew_data;

}

//����ޥ����ξ�������
function Claim_Con_Data($db_con, $client_id, $claim_id, $claim_div){
    $sql = "
        SELECT
            t_contract.contract_id,
            --����
            CASE t_contract.round_div
                WHEN '1' THEN   CASE 
                                    WHEN t_contract.abcd_week IN ('1','2','3','4') THEN '4'
                                    WHEN t_contract.abcd_week IN ('5','6') THEN '2'
                                    ELSE '8'
                                END 
                WHEN '2' THEN   '��'
                WHEN '3' THEN   '��'
                WHEN '4' THEN   t_contract.cycle
                WHEN '5' THEN   t_contract.cycle
                WHEN '6' THEN   t_contract.cycle
                WHEN '7' THEN   ''
            END AS cycle,
            --����ñ��(M/W)
            CASE t_contract.round_div
                WHEN '1' THEN   'W'
                WHEN '2' THEN   'M'
                WHEN '3' THEN   'M'
                WHEN '4' THEN   'W'
                WHEN '5' THEN   'M'
                WHEN '6' THEN   'M'
                WHEN '7' THEN   ''
            END AS unit,
            --��̾
            CASE t_contract.round_div
                WHEN '1' THEN   CASE
                                    WHEN t_contract.abcd_week IN ('1','21') THEN 'A'
                                    WHEN t_contract.abcd_week IN ('2','22') THEN 'B'
                                    WHEN t_contract.abcd_week IN ('3','23') THEN 'C'
                                    WHEN t_contract.abcd_week IN ('4','24') THEN 'D'
                                    WHEN t_contract.abcd_week = '5'         THEN 'A, C'
                                    WHEN t_contract.abcd_week = '6'         THEN 'B, D'
                                END
                WHEN '3' THEN   t_contract.cale_week
                WHEN '6' THEN   t_contract.cale_week
                ELSE ''
            END AS week,
            --��������
            CASE t_contract.round_div
                WHEN '2' THEN   CASE t_contract.rday
                                    WHEN '30' THEN '����'
                                    ELSE t_contract.rday || '��' 
                                END
                ELSE    CASE t_contract.week_rday
                            WHEN '1' THEN '��'
                            WHEN '2' THEN '��'
                            WHEN '3' THEN '��'
                            WHEN '4' THEN '��'
                            WHEN '5' THEN '��'
                            WHEN '6' THEN '��'
                            WHEN '7' THEN '��'
                        END
            END AS rday,
            --�����ӥ��������ƥ�̾
            CASE 
                WHEN t_con_info.serv_pflg = 't' AND t_con_info.goods_pflg = 't' 
                    THEN t_serv.serv_name || '/' || t_con_info.official_goods_name
                WHEN t_con_info.serv_pflg = 't' AND t_con_info.goods_pflg = 'f'
                    THEN t_serv.serv_name
                WHEN t_con_info.serv_pflg = 'f' AND t_con_info.goods_pflg = 't'
                    THEN t_con_info.official_goods_name 
            END AS goods_name,
            --����
            t_con_info.num,
            --ñ��
            t_con_info.sale_price,
            --���
            t_con_info.sale_amount,
            --���ô����
            t_staff.staff_name
        FROM
            t_contract
                INNER JOIN
            t_con_info
            ON t_contract.contract_id = t_con_info.contract_id
                LEFT JOIN
            t_serv
            ON t_con_info.serv_id = t_serv.serv_id
                LEFT JOIN
            t_con_staff
            ON t_contract.contract_id = t_con_staff.contract_id
            AND t_con_staff.staff_div = '0'
                LEFT JOIN
            t_staff
            ON t_con_staff.staff_id = t_staff.staff_id 
        WHERE
            t_contract.client_id = $client_id
            AND
            t_contract.claim_div = $claim_div
            AND
            t_contract.claim_id = $claim_id
            AND
            t_contract.state = '1'
        ORDER BY t_contract.line
        ;
    ";
            
    $result = Db_Query($db_con, $sql);
    $con_data = pg_fetch_all($result);

    return $con_data;
}

//���ͤ�ɽ�������˹�碌��ؿ�
function Mb_Str_Split($note, $len){

    for($i = 0; $i < 4; $i++){

        $res[] = mb_substr($note,0+$brk,$len);
        $brk += $len;
    }

    return $res;
}

?>
