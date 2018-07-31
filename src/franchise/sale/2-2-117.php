<?php
/*
 * ����
 * �����ա�������BɼNo.���� ô���ԡ��������ơ�
 * 2007-03-22               watanabe-k  �����ɼ��ɽ�����ʤ�
 * 2007-03-23               watanabe-k  ����ޥ�����Ʊ�������Ȥ򤹤�褦�˽��� 
 * 2007-05-14               watanabe-k  ȯ������Ĥ��褦�˽��� 
 * 2007-05-22               watanabe-k  �����ȥ���ѹ� 
 * 2007-05-22               watanabe-k  15��ɼ��ɽ���������2�ڡ����ܤ˶�����Խ���ɽ��ɽ�������Х��ν��� 
 * 2007-05-23               watanabe-k  ��������ID����Ͽ����褦�˽��� 
 * 2007-07-31               watanabe-k  �ѻ�����꤭��ʤ�����ޡ��������� 
 * 2007-09-18               watanabe-k  ��ɼȯ�Ԥ�������ޥ����򻲾Ȥ���褦�˽��� 
 * 2008-05-31               watanabe-k  �и��ʥꥹ�Ȥˤϼ���ǡ����ơ��֥�ξ��ʤ�ɽ������褦�˽��� 
 * 2008-07-19				watanabe-k  �����ƥ�Ⱦ����ʤ��̡�����Ф���褦�˽���
 */

require_once("ENV_local.php");
require_once(INCLUDE_DIR."daily_slip.inc"); //���������Ѵؿ�

$db_con = Db_Connect();

// ���¥����å�
//$auth       = Auth_Check($db_con);


/****************************/
//���å��������å�
/****************************/

if($_SESSION["group_kind"] != "2"){
    header("Location: ".FC_DIR."top.php");
}

/***************************/
//�����ѿ�����
/***************************/
//���å����
$shop_id        = $_SESSION["client_id"];           //�����ID

//POST
$button_value   = $_POST["form_hdn_submit"];        //�ܥ���value

//������ȯ��
if($button_value == "������ȯ��"){
    $aord_id    = $_POST["form_preslip_out"];           //����ID
    $button     = "1";
//��������ȯ��
}elseif($button_value == "��������ȯ��"){
    $aord_id    = $_POST["form_unslip_out"];
    $button     = "2";
//��ȯ��
}elseif($button_value == "���ơ�ȯ���ԡ�"){
    $aord_id    = $_POST["form_slip_out"];
    $button     = "3";
}

/*********************************/
//�оݥǡ������
/*********************************/
//�ǡ�������ԶȼԤ��Ȥ�Ż���
$act_data = Make_Client_Data ($aord_id, $db_con);

//��Ĥ����򤵤�Ƥ��ʤ����
if($act_data === false){
    $check_err = "��ɼ�����򤷤Ʋ�������";
    Show_Template($check_err, $smarty);
}else{
    $act_data_count = count($act_data);     
}

//��ɼ������ȯ�ԤΥ����ߥ󥰤Ǻ������Ƥ������
if($act_data_count == 0){
    $check_err = "��������ɼ���������Ƥ��ޤ���";
    Show_Template($check_err, $smarty);
}

/*********************************/
//�ܥ��󲡲����٥�Ƚ���
/*********************************/
//��������ܥ��󲡲�����
//�����ֹ�ȯ��
if($button == "2"){
    $act_data = Set_Aord_No ($act_data, $db_con);

    //���顼�ξ��
    if($act_data === false){
        $duplicate_err = "��������ΰ�����Ʊ���˹Ԥʤ�줿���ᡢ<br>��ɼ�ֹ�����֤˼��Ԥ��ޤ�����";
        Show_Template($duplicate_err, $smarty);
    }

//��ȯ�ԥܥ��󲡲�����
}elseif($button == "3"){
    //��ȯ��������ɼ���ɲä��줿��票�顼��å�����ɽ��
    foreach($act_data AS $key => $var){
        if(in_array(null, $act_data[$key]["head"])){
            $check_err = "��ɼ���������ɲä��줿���ᡢ�������֤��Ʋ�������";
            Show_Template($check_err, $smarty);
        }
    }
}

/*********************************/
//�������
/*********************************/
//������������
$sql  = "SELECT ";
$sql .= "   stand_day ";
$sql .= "FROM\n";
$sql .= "   t_stand";
$sql .= ";";

$day_res = Db_Query($db_con, $sql);
$stand_day = explode("-", pg_fetch_result($day_res, 0,0));

$max_row     = 15;  //ɽ�ιԿ�
$max_line    = 5;   //���ʤ����
$top_margin  = 40;
$left_margin = 60;

/*********************************/
//ɽ������
/*********************************/
//�ǡ�������
$page_data = Make_Show_Data ($act_data, $db_con, $max_row, $max_line);

require(FPDF_DIR);
//PDF����
Make_Pdf($page_data, $top_margin, $left_margin, $max_row, $max_line);

/*********************************/
//�ؿ�
/*********************************/
//PDF����
function Make_Pdf ($page_data, $top_margin, $left_margin, $max_row, $max_line){

    //ɽ���Կ�
    $page_line = 15;

    //�����ȥ�
	$title = "������ �� �� �� �� �� ɽ����";

    //����̾������align
    $list[0] = array("70","ͽ���ꡡ��","C");
    $list[1] = array("40","��ɼNo.","C");
    $list[2] = array("140","�����ա���","C");
    $list[3] = array("130","������������","C");
    $list[4] = array("130","������������","C");
    $list[5] = array("130","������������","C");
    $list[6] = array("130","������������","C");
    $list[7] = array("130","������������","C");
    $list[8] = array("70","�á�����","C");
    $list[9] = array("140","�䡡�塡�硡�ס���","C");

	$goods_width = array("0","180","360","540","720");

	//�ڡ���������
	//A3
	$pdf=new MBFPDF('L','pt','A3');
	$pdf->AddMBFont(GOTHIC ,'SJIS');
	$pdf->SetAutoPageBreak(false);

	//Ģɼ����  
	for($i = 0; $i < $page_data["page"]; $i++){

        $act_id = $page_data[$i]["act_id"];
		
	    $pdf->AddPage();
	    ///////////////////////////�ڡ�����/////////////////////////////////
		$pdf->SetFont(GOTHIC, '', 10);
		//A3�β����ϡ�1110
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY(30,20);
		$pdf->Cell(1110, 12, ($i+1)."/".$page_data["page"], '0', '1', 'R');

		////////////////////////////�����ȥ�////////////////////////////////

		$pdf->SetFont(GOTHIC, '', 20);
		//A3�β����ϡ�1110
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY($left_margin,$top_margin);
		$pdf->Cell(1110, 20, $title, '0', '1', 'C');

		///////////////////////////�����ȥ�β��Υ���//////////////////////////////
		//��������
		$pdf->SetLineWidth(1);
		//���ο�
		$pdf->SetDrawColor(150,150,255);
		$pdf->SetFont(GOTHIC, '', 10);

		$pdf->SetXY($left_margin+700,$top_margin);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(50,11,"������",'LTB','2','C','1');
		$pdf->Cell(50,40,"",'LB');

		$pdf->SetXY($left_margin+750,$top_margin);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(50,11,"������",'TB','2','C','1');
		$pdf->Cell(50,40,"",'B');

		$pdf->SetXY($left_margin+800,$top_margin);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(50,11,"ô����",'TRB','2','C','1');
		$pdf->Cell(50,40,"",'RB');

		$pdf->SetDrawColor(150,155,255);
		$pdf->Line($left_margin+749.5,$top_margin+1,$left_margin+749.5,$top_margin+10);
		$pdf->Line($left_margin+799.5,$top_margin+1,$left_margin+799.5,$top_margin+10);

		$pdf->SetLineWidth(0.5);
		$pdf->SetDrawColor(150,150,255);
		$pdf->Line($left_margin+749.5,$top_margin+11.5,$left_margin+749.5,$top_margin+55);
		$pdf->Line($left_margin+799.5,$top_margin+11.5,$left_margin+799.5,$top_margin+55);

        /***************���β��Υ���*****************/

        $pdf->SetLineWidth(1);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetXY($left_margin+900,$top_margin-7);
        $pdf->Cell(160,15,"������������ǯ���������",'0','0','C','1');

        $pdf->SetXY($left_margin+900,$top_margin+9);
        $pdf->Cell(50,40,"�롼��",'LTR','2','C','1');
        $pdf->SetXY($left_margin+950,$top_margin+9);
        $pdf->Cell(160,20,"��Զȼ� �� ".$page_data["id".$act_id]["act_cd"],'LTR','0','L','1');
        $pdf->SetXY($left_margin+950,$top_margin+29);
        $pdf->Cell(160,20,$page_data["id".$act_id]["act_name"],'LR','0','L','1');

        $pdf->SetXY($left_margin+900,$top_margin+35);

        $pdf->SetLineWidth(0.5);
        $pdf->SetDrawColor(150,150,255);

		////////////////////////////����///////////////////////////////////////
		$pdf->SetLineWidth(1);
		//�ƥ����Ȥο�
		$pdf->SetTextColor(0,0,0); 

		//����ɽ��
		$pdf->SetXY($left_margin,$top_margin+50);
		$pdf->SetFillColor(255,255,255);
		for($m = 0; $m < count($list); $m++){
            if($m == 9){
                $pdf->SetFillColor(255,255,255);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell($list[$m][0], 15, $list[$m][1], '1', '2', $list[$m][2],'1');
                $pdf->SetFillColor(255,255,255);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell('70', 15, '������', '1', '0', 'C','1');
                $pdf->Cell('70', 15, '�䡡��', '1', '0', 'C','1');
            }else{
			    $pdf->Cell($list[$m][0], 30, $list[$m][1], '1', '0', $list[$m][2],'1');
            }
		}

		/////////////////////////////�ǡ���////////////////////////////////////
		//�ǡ���ɽ��
		$pdf->SetFont(GOTHIC, '', 9);
		$pdf->SetDrawColor(150,150,255);          //���ο�
		$pdf->SetXY($left_margin,$top_margin+80);
		$pdf->SetLineWidth(0.5);

		//ɽ�ιԿ�ʬɽ��
		for($c=0; $c < $page_line; $c++){
			$posY = $pdf->GetY();
			$pdf->SetXY($left_margin, $posY);
		    $pdf->SetTextColor(0,0,0);                //�ե���Ȥο�

            //---------------------------------------------------------
            //������
            //---------------------------------------------------------
			//ͽ�����ζ�����ʬ��ɽ��
			$pdf->Cell("70", 12, "", "LTR", '0','C','1');

			//��ɼ�ֹ楻��ζ�����ʬ��ɽ��
			$pdf->Cell("40", 12, "", "LTR", '0','C','1');

	        //������̾��ɽ��
	        $pdf->Cell("100", 12, $page_data[$i][$c]["client_cd"] , "LTB", "0", "L","1");
		    $pdf->SetTextColor(255,0,0);                //�ե���Ȥο�
	        $pdf->Cell("40", 12, $page_data[$i][$c]["slip_out"] , "TBR", "0", "R","1");
		    $pdf->SetTextColor(0,0,0);                //�ե���Ȥο�

	        //����̾��ɽ��
            for($j = 0; $j < $max_line; $j++){
			    $pdf->Cell(80, 12, $page_data[$i][$c]["goods_name"][$j],                   'LT', '0','L','1');
			    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$c]["sale_price"][$j]), 'TR', '0','R','1');
            }

	        //�����Ǥ�ɽ��
	        $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	        //����׶�ۤ�ɽ��
	        $pdf->Cell(70, 12, "", '1', '0', 'R', '1');
	        $pdf->Cell(70, 12, "", '1', '2', 'R', '1');

            //---------------------------------------------------------
            //������
            //---------------------------------------------------------
			$posY = $pdf->GetY();
			$pdf->SetXY($left_margin, $posY);
			$pdf->SetFillColor(255,255,255);      //�طʿ�

			//ͽ�����ζ�����ʬ��ɽ��
			$pdf->Cell("70", 12, $page_data[$i][$c]["ord_time"], "LR", '0','C','1');

	        //��ɼ�ֹ��ɽ��
			$pdf->Cell(40 , 12, $page_data[$i][$c]["ord_no"], 'LR', '0','C','1');

			//������ξ�ζ��򥻥��ɽ��
			$pdf->Cell(140, 12, $page_data[$i][$c]["client_cname"], '1', '0','L','1');

	        //����ñ����ɽ��
            for($j = 0; $j < $max_line; $j++){
			    $pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$c]["num"][$j])  ,       '1', '0','R','1');
			    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$c]["sale_amount"][$j]), '1', '0','R','1');
            }

	        //�����ǲ��ζ����ɽ��
	        $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$c]["tax_amount"]), '1', '0', 'R', '1');

	        //����׶�ۤ�ɽ��
	        $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$c]["net_amount1"]), '1', '0', 'R', '1');
	        $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$c]["net_amount2"]), '1', '2', 'R', '1');

            //---------------------------------------------------------
            //������
            //---------------------------------------------------------
			$posY = $pdf->GetY();
			$pdf->SetXY($left_margin, $posY);
			$pdf->SetFillColor(255,255,255);      //�طʿ�

			//ͽ�����ζ�����ʬ��ɽ��
			$pdf->Cell("70", 12, "", "LBR", '0','C','1');

			//��ɼ�ֹ楻��ζ�����ʬ��ɽ��
			$pdf->Cell(40 , 12, "", 'LBR', '0','C','1');

			//�������ɽ��
			$pdf->Cell(140, 12, $page_data[$i][$c]["client_cname2"], '1', '0','L','1');

	        //����ñ���ι��ܤ�ɽ��
            for($j = 0; $j < $max_line; $j++){
			    $pdf->Cell(50 , 12, "", '1', '0','C','1');
			    $pdf->Cell(80 , 12, "", '1', '0','C','1');
            }

	        //�����ǲ��ζ����ɽ��
	        $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	        //����׶�ۤ�ɽ��
	        $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');
	        $pdf->Cell(70 , 12, "", '1', '2', 'C', '1');
        }

        /********************���ʡ�����*********************/
        $cnt = 0;
        for($x=0;$x<4;$x++){
            $pdf->SetXY($left_margin+$goods_width[$x],$top_margin+635);
            $pdf->Cell(120,12,"��������",'1','0','C','1');
            $pdf->Cell(50,12,"��������",'1','2','C','1');

            for($c=0;$c<8;$c++){
                $posY = $pdf->GetY();
                $pdf->SetXY($left_margin+$goods_width[$x], $posY);
                $pdf->Cell(120,12,$page_data[$i]["goods_data"][$cnt]["goods_name"],'1','0','C','1');
                $pdf->Cell(50,12,My_Number_Format($page_data[$i]["goods_data"][$cnt]["sum"]),'1','2','R','1');
                $cnt++;
            }
        }

        /*******************���****************************/
        //�ڡ������
        $pdf->SetFont(GOTHIC, '', 11);
        $pdf->SetXY($left_margin+820,$top_margin+620);
        $pdf->Cell(80,26,"�ǡ�����",'1','0','C','1');

        $pdf->Cell(70,13,"",'1','0','R','1');
        if($page_data[$i]["last_flg"] != true){
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["net_amount1"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["net_amount2"])  ,'1','0','R','1');
            $pdf->SetXY($left_margin+900,$top_margin+633);
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["tax_amount"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["intax_amount1"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["intax_amount2"])  ,'1','0','R','1');
        }else{ 
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->SetXY($left_margin+900,$top_margin+633);
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
        }

        //�������
        $pdf->SetXY($left_margin+820, $top_margin+646);
        $pdf->SetFillColor(180,180,180);      //�طʿ�
        $pdf->Cell(80,26,"�硡����",'1','0','C','1');
        $pdf->Cell(70,13,""                                    ,'1','0','0','1');


        if($page_data[$i]["last_flg"] == true){
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["net_amount1"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["net_amount2"])  ,'1','0','R','1');
            $pdf->SetXY($left_margin+900,$top_margin+659);
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["tax_amount"])      ,'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["intax_amount1"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["intax_amount2"])  ,'1','0','R','1');
        }else{
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->SetXY($left_margin+900,$top_margin+659);
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
        }

        $pdf->SetXY($left_margin,$posY+100);
		$pdf->SetFillColor(255,255,255);      //�طʿ�
        $pdf->SetXY($left_margin,$top_margin+750);
        $pdf->Cell(160,15,"����������".date('Y')."ǯ��".date('m')."�".date('d')."��",'0','0','L','1');
		$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_marginx+70, $top_margin);
	}

	$pdf->Output();
}

//������ñ�̤���ԥǡ�����Ż���
function Make_Client_Data ($aord_id, $db_con){

    $count = count($aord_id);

    if($count == 0){
        return false;
    }
 
    //�������̤ǤΥ����å��ܥå����ο�ʬ�롼��
    foreach($aord_id AS $key => $var){
        //�����å�����Ƥ��ʤ�����f
        if($var != 'f'){
            //���󥷥ꥢ�饤��
            $target_aord_id = unserialize(urldecode(stripslashes($var)));

            //������������ȤΥǡ���
            $sql  = "SELECT \n";
            $sql .= "   t_aorder_h.ord_no,\n";
            $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";
            $sql .= "   t_aorder_h.client_cname, \n";

            //--�����ʤ�̵�����ϡ������ӥ�̾��ɽ������
            $sql .= "   (CASE \n";
            $sql .= "       WHEN t_aorder_d.goods_name IS NULL THEN t_aorder_d.serv_name \n";
            $sql .= "       WHEN t_aorder_d.goods_name = '' THEN t_aorder_d.serv_name \n";
            $sql .= "   ELSE t_aorder_d.goods_name \n";
            $sql .= "   END) AS goods_name, \n";
            $sql .= "   t_aorder_d.num, \n";
            $sql .= "   t_aorder_d.sale_price, \n";
            $sql .= "   t_client.trade_id, \n";
            $sql .= "   t_aorder_h.net_amount, \n";
            $sql .= "   t_aorder_h.tax_amount, \n";
            $sql .= "   t_aorder_d.sale_amount, \n";
            $sql .= "   t_aorder_h.aord_id,\n";
            $sql .= "   act_id, \n";
            $sql .= "   t_aorder_h.act_cd1 || '-' || t_aorder_h.act_cd2 AS act_cd, \n";
            $sql .= "   act_name, \n";
            $sql .= "   ord_time, \n";
//            $sql .= "   CASE t_aorder_h.slip_out ";
            $sql .= "   CASE t_client.slip_out ";
            $sql .= "       WHEN '1' THEN '' ";
            $sql .= "       WHEN '2' THEN '��' ";
            $sql .= "   END AS slip_out ";
            $sql .= "FROM\n";
            $sql .= "    t_aorder_h\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "    t_aorder_d\n";
            $sql .= "    ON t_aorder_d.aord_id = t_aorder_h.aord_id\n";
            $sql .= "       INNER JOIN ";
            $sql .= "    t_client ";
            $sql .= "    ON t_aorder_h.client_id = t_client.client_id ";
            $sql .= "WHERE\n";
            $sql .= "    t_aorder_h.aord_id IN (".implode(',',$target_aord_id).") \n";
            $sql .= "    AND\n";
            $sql .= "    t_aorder_h.del_flg = false \n";

            $sql .= "ORDER BY\n";
            $sql .= "   t_aorder_h.client_cd1,\n";
            $sql .= "   t_aorder_h.client_cd2,\n";
            $sql .= "   ord_time,\n";
            $sql .= "   t_aorder_h.aord_id, \n";
            $sql .= "   t_aorder_d.line \n";
            $sql .= ";\n";

            $result = Db_Query($db_con, $sql);
            $day_client_data = pg_fetch_all($result);
            $day_slip_count  = pg_num_rows($result);

            for($j = 0; $j < $day_slip_count; $j++){
                $act_id  = $day_client_data[$j]["act_id"];
                $aord_id = $day_client_data[$j]["aord_id"];

                //��ԥǡ���
                $client_data[$act_id]["act_id"]         = $day_client_data[$j]["act_id"];
                $client_data[$act_id]["act_cd"]         = $day_client_data[$j]["act_cd"];
                $client_data[$act_id]["act_name"]       = $day_client_data[$j]["act_name"];

                //�إå�
                $client_data[$act_id]["head"][$aord_id]["ord_time"]     = $day_client_data[$j]["ord_time"];
                $client_data[$act_id]["head"][$aord_id]["aord_id"]      = $day_client_data[$j]["aord_id"];
                $client_data[$act_id]["head"][$aord_id]["ord_no"]       = $day_client_data[$j]["ord_no"];
                $client_data[$act_id]["head"][$aord_id]["client_cd"]    = $day_client_data[$j]["client_cd"];
                $client_data[$act_id]["head"][$aord_id]["client_cname"] = $day_client_data[$j]["client_cname"];
                $client_data[$act_id]["head"][$aord_id]["trade_id"]     = $day_client_data[$j]["trade_id"];
                $client_data[$act_id]["head"][$aord_id]["net_amount"]   = $day_client_data[$j]["net_amount"];
                $client_data[$act_id]["head"][$aord_id]["tax_amount"]   = $day_client_data[$j]["tax_amount"];
                $client_data[$act_id]["head"][$aord_id]["slip_out"]     = $day_client_data[$j]["slip_out"];

                //�ǡ���
                $client_data[$act_id][$aord_id]["goods_name"][]         = $day_client_data[$j]["goods_name"];
                $client_data[$act_id][$aord_id]["num"][]                = $day_client_data[$j]["num"];
                $client_data[$act_id][$aord_id]["sale_price"][]         = $day_client_data[$j]["sale_price"];
                $client_data[$act_id][$aord_id]["sale_amount"][]        = $day_client_data[$j]["sale_amount"];
            }

        }else{
            $f++;
            continue;
        }
    }

    //��Ĥ����򤵤�Ƥ��ʤ����
    if($f == $count){
        return false;
    }

    return $client_data;
}

//�����ֹ����
function Set_Aord_No($act_data, $db_con){
    Db_Query($db_con, "BEGIN;");

    //�����η��ʬ�롼��
    foreach($act_data AS $key => $var){

        //��������ID�����
        $max_id = Get_Daily_Slip_Id($db_con);

        //ID�μ����˼��Ԥ������
        if($max_id === false){ 
            return false;
        }       


        //��ɼ���ʬ�롼��
        foreach($act_data[$key]["head"] AS $keys => $var2){

            //��ɼ�˺��֤���
            if($act_data[$key]["head"][$keys]["ord_no"] == null){

                //�����ֹ�����
                $sql  = "SELECT";
                $sql .= "   MAX(ord_no) ";
                $sql .= "FROM";
                $sql .= "   t_aorder_no_serial";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);

                $order_no = pg_fetch_result($result, 0 ,0);
                $order_no = $order_no +1;
                $act_data[$key]["head"][$keys]["ord_no"] = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                //�����ֹ���Ͽ����
                $sql  = "INSERT INTO t_aorder_no_serial (\n";
                $sql .= "   ord_no\n";
                $sql .= ")VALUES(\n";
                $sql .= "   '".$act_data[$key]["head"][$keys]["ord_no"]."'\n";
                $sql .= ");\n";

                $result = Db_Query($db_con, $sql);

                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_aorder_no_serial_pkey";
                    $err_flg = true;
                    Db_Query($db_con, "ROLLBACK;");

                    if(strstr($err_message, $err_format) != false){
                        return false;
                    }else{
                        exit;
                    }
                }

                //��ɼ�ֹ�ˡܣ������ͤ���Ͽ
                $sql  = "UPDATE ";
                $sql .= "   t_aorder_h ";
                $sql .= "SET";
                $sql .= "   ord_no = '".$act_data[$key]["head"][$keys]["ord_no"]."', \n";
                $sql .= "   daily_slip_out_day = NOW(), ";
                $sql .= "   daily_slip_id = $max_id "; 
                $sql .= "WHERE\n";
                $sql .= "   aord_id = ".$keys."\n";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);

                //Ʊ����ɼ��Ʊ���˺��ֽ������¹Ԥ��줿��票�顼
                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_aorder_h_ord_no_key";
                    $err_flg = true;
                    Db_Query($db_con, "ROLLBACK;");

                    if(strstr($err_message, $err_format) != false){
                        return false;
                    }else{
                        exit;
                    }
                }
            //���˺��ֺѤߤξ��ώ������̎�
            }else{
                continue;
            }
        }
    }
    Db_Query($db_con, "COMMIT;");

    return $act_data;
}

//���ʾ������
function Make_Goods_Data ($act_data, $db_con){

	//--������
	$sql  = "(SELECT  ";
    $sql .= " t_aorder_d.egoods_name AS goods_name, ";
    $sql .= "  sum(t_aorder_ship.num) AS sum ";
    $sql .= "FROM ";
    $sql .= "  t_aorder_d ";
    $sql .= "      INNER JOIN ";
    $sql .= "  t_aorder_ship ";
    $sql .= "  ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id  ";
    $sql .= "  AND t_aorder_d.aord_id IN (".implode(",",$act_data).") ";
    $sql .= "  AND t_aorder_d.egoods_id = t_aorder_ship.goods_id ";
    $sql .= "GROUP BY ";
    $sql .= "  t_aorder_ship.goods_cd, ";
    $sql .= "  t_aorder_d.egoods_name ";
    $sql .= "ORDER BY ";
    $sql .= "  t_aorder_ship.goods_cd  ";
    $sql .= ") ";
    $sql .= "UNION  ";
	//--�����ƥ�
    $sql .= "(SELECT  ";
    $sql .= "  t_aorder_d.goods_name, ";
    $sql .= "  sum(t_aorder_ship.num) AS sum ";
    $sql .= "FROM ";
    $sql .= "  t_aorder_d ";
    $sql .= "      INNER JOIN ";
    $sql .= "  t_aorder_ship ";
    $sql .= "  ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id  ";
    $sql .= "  AND t_aorder_d.aord_id IN (".implode(",",$act_data).") ";
    $sql .= "  AND t_aorder_d.goods_id = t_aorder_ship.goods_id ";
    $sql .= "GROUP BY ";
    $sql .= "  t_aorder_ship.goods_cd, ";
    $sql .= "  t_aorder_d.goods_name ";
    $sql .= "ORDER BY ";
    $sql .= "  t_aorder_ship.goods_cd ";
    $sql .= ") ";


    $result = Db_Query($db_con, $sql);

    if(pg_num_rows($result) > 0){
        $goods_data = pg_fetch_all($result);
    }

    return $goods_data;

}

//ɽ�������˺���Ѥ���                       //��          //��
function Make_Show_Data ($act_data, $db_con, $max_slip, $max_line){


    //�����
    $page = 0;          //�ڡ�����
    $row  = 0;          //�Կ�
    $line = 0;
    $slip_num = 0;      //��ɼ��

    $max_row = $max_slip * 3;

    $first = true;
    //�����ʬ�롼��
    foreach($act_data AS $key => $var){

        //����褬�Ѥ�ä����
        if($act_id != $act_data[$key]["act_id"] && $first != true){

            //�Ǹ�Υڡ���
            //��׶�ۤ�ɽ����Ƚ��  
            $page_data[$page]["last_flg"] = true;

            $renew_page_flg = true;
        }

        $first = false;

        //���ڡ����ե饰��true
        if($renew_page_flg == true){

            //�����νи���
            $page_data[$page]["goods_data"] = Make_Goods_Data ($arod_id[$page], $db_con);

            $page++;            //���ڡ���
            $row = 0;           //�Կ����ꥢ
            $slip_num = 0;      //��ɼ��

            //�ڡ�����פ򥯥ꥢ
            $act_net_amount1 = 0;
            $act_intax_amount1 = 0;
            $act_net_amount2 = 0;
            $act_intax_amount2 = 0;
            $act_tax_amount  = 0;

            $renew_page_flg = false;

            $act_id = $act_data[$key]["act_id"];    //���ID
            $page_data[$page]["act_id"] = $act_id;  //���ID
        }

        $act_id = $act_data[$key]["act_id"];        //���ID
        $page_data[$page]["act_id"] = $act_id;      //���ID

        $page_data["id".$act_id]["act_cd"]   = $act_data[$key]["act_cd"];    //��ԥ�����

        $page_data["id".$act_id]["act_name"] = $act_data[$key]["act_name"];  //���̾


        //������̾��15ʸ���ʾ�ξ���2�ʤ�ʬ����
        if(mb_strlen($act_data[$key]["act_name"]) > 15){
            $page_data["id".$act_id]["act_name"]     = mb_substr($act_data[$key]["act_name"],0,15);
            $page_data["id".$act_id]["act_name2"]    = mb_substr($act_data[$key]["act_name"],15);
        }else{
            $page_data["id".$act_id]["act_name"]     = $act_data[$key]["act_name"];     //������̾
        }

        //��ۥǡ������ꥢ
        $act_net_amount   = null;
        $act_tax_amount   = null;

        //��ɼ���ʬ�롼��
        foreach($act_data[$key]["head"] AS $key2 => $var2){

            //�ե饰�����
            $renew_row_flg = false;

            //���ڡ����ե饰��true
            if($renew_page_flg == true){
                //�ڡ������Ȥνи���
                $page_data[$page]["goods_data"] = Make_Goods_Data ($arod_id[$page], $db_con);

                $page++;        //���ڡ���
                $row = 0;       //�Կ����ꥢ
                $slip_num = 0;  //��ɼ�����ꥢ

                //�ڡ�����פ򥯥ꥢ
                $act_net_amount1 = 0;
                $act_intax_amount1 = 0;
                $act_net_amount2 = 0;
                $act_intax_amount2 = 0;
                $act_tax_amount  = 0;

                $renew_page_flg = false;
                $act_id = $act_data[$key]["act_id"];    //���ID
                $page_data[$page]["act_id"] = $act_id;    //���ID
            }

            //��ɼ�ǡ���
            $page_data[$page][$slip_num]["ord_no"]        = $act_data[$key]["head"][$key2]["ord_no"];       //��ɼ�ֹ�
            $page_data[$page][$slip_num]["aord_id"]       = $act_data[$key]["head"][$key2]["aord_id"];      //����ID
            $arod_id[$page][] = $page_data[$page][$slip_num]["aord_id"]; 
            $ord_time                                     = $act_data[$key]["head"][$key2]["ord_time"];     //������
            $page_data[$page][$slip_num]["ord_time"]      = Get_Basic_Date($stand_day, $ord_time);          //������
            $page_data[$page][$slip_num]["client_cd"]     = $act_data[$key]["head"][$key2]["client_cd"];    //�����襳����
            $page_data[$page][$slip_num]["client_cname"]  = $act_data[$key]["head"][$key2]["client_cname"]; //������̾
            $page_data[$page][$slip_num]["slip_out"]      = $act_data[$key]["head"][$key2]["slip_out"];     //��ɼȯ�Է���

            //������̾��15ʸ���ʾ�ξ���2�ʤ�ʬ����
            if(mb_strlen($act_data[$key]["head"][$key2]["client_cname"]) > 15){
                $page_data[$page][$slip_num]["client_cname"]     = mb_substr($act_data[$key]["head"][$key2]["client_cname"],0,15);
                $page_data[$page][$slip_num]["client_cname2"]    = mb_substr($act_data[$key]["head"][$key2]["client_cname"],15);
            }else{
                $page_data[$page][$slip_num]["client_cname"]     = $act_data[$key]["head"][$key2]["client_cname"];     //������̾
            }

            $page_data[$page][$slip_num]["trade_id"]      = $act_data[$key]["head"][$key2]["trade_id"];     //�����ʬ

            $page_data[$page][$slip_num]["tax_amount"]    = $act_data[$key]["head"][$key2]["tax_amount"];   //�����ǳ�

            //����ξ��
            if($page_data[$page][$slip_num]["trade_id"] == "61"){
                $page_data[$page][$slip_num]["net_amount1"]    = $act_data[$key]["head"][$key2]["net_amount"];   //����ۡ���ȴ��
                $page_data[$page][$slip_num]["intax_amount1"]  = $page_data[$page][$slip_num]["net_amount1"] + $page_data[$page][$slip_num]["tax_amount"];   //����ۡ��ǹ���
            //��
            }else{
                $page_data[$page][$slip_num]["net_amount2"]    = $act_data[$key]["head"][$key2]["net_amount"];   //����ۡ���ȴ��
                $page_data[$page][$slip_num]["intax_amount2"]  = $page_data[$page][$slip_num]["net_amount2"] + $page_data[$page][$slip_num]["tax_amount"];   //����ۡ��ǹ���
            }            

            //�ڡ������
            $act_net_amount1    += $page_data[$page][$slip_num]["net_amount1"];       //������(��ȴ)
            $page_data[$page]["net_amount1"] = $act_net_amount1;                        

            $act_intax_amount1  += $page_data[$page][$slip_num]["intax_amount1"];   //������(�ǹ�)
            $page_data[$page]["intax_amount1"] = $act_intax_amount1;                        

            $act_net_amount2    += $page_data[$page][$slip_num]["net_amount2"];       //�ݹ��(��ȴ)
            $page_data[$page]["net_amount2"] = $act_net_amount2;

            $act_intax_amount2  += $page_data[$page][$slip_num]["intax_amount2"];   //������(�ǹ�)
            $page_data[$page]["intax_amount2"] = $act_intax_amount2;                        

            $act_tax_amount     += $page_data[$page][$slip_num]["tax_amount"];        //�����ǹ��
            $page_data[$page]["tax_amount"] = $act_tax_amount;

            //�������
            $page_data["id".$act_id]["net_amount1"]     +=  $page_data[$page][$slip_num]["net_amount1"]; 
            $page_data["id".$act_id]["intax_amount1"]   +=  $page_data[$page][$slip_num]["intax_amount1"];
            $page_data["id".$act_id]["net_amount2"]     +=  $page_data[$page][$slip_num]["net_amount2"];
            $page_data["id".$act_id]["intax_amount2"]   +=  $page_data[$page][$slip_num]["intax_amount2"];
            $page_data["id".$act_id]["tax_amount"]      +=  $page_data[$page][$slip_num]["tax_amount"];

            //����ʬ�롼��
            $goods_num = count($act_data[$key][$key2]["goods_name"]);
            for($j = 0; $j < $goods_num; $j++){
                //���ԥե饰��true
                if($renew_row_flg === true){
                    $row+=3;      //����
                    $slip_num++;  //��ɼ��

                    //���ڡ����ե饰
                    $renew_page_flg = ($row >= $max_row)? true : false;

                    //���ڡ����ե饰��true
                    if($renew_page_flg === true){

                        //�ڡ������Ȥνи���
                        $page_data[$page]["goods_data"] = Make_Goods_Data ($arod_id[$page], $db_con);

                        $page++;         //���ڡ���
                        $row = 0;        //�Կ����ꥢ
                        $slip_num = 0;   //��ɼ�����ꥢ

                        //�ڡ�����פ򥯥ꥢ
                        $act_net_amount1 = 0;
                        $act_intax_amount1 = 0;
                        $act_net_amount2 = 0;
                        $act_intax_amount2 = 0;
                        $act_tax_amount  = 0;

                        $act_id = $act_data[$key]["act_id"];    //���ID
                        $page_data[$page]["act_id"] = $act_id;  //���ID
                    }

                    $line = 0;      //������ꥢ
                    $renew_row_flg  = false;
                    $renew_page_flg = false;
                }

                //���ʥǡ���
                $page_data[$page][$slip_num]["goods_name"][$line]    = $act_data[$key][$key2]["goods_name"][$j];    //����̾ 
                $page_data[$page][$slip_num]["num"][$line]           = $act_data[$key][$key2]["num"][$j];           //����
                $page_data[$page][$slip_num]["sale_price"][$line]    = $act_data[$key][$key2]["sale_price"][$j];    //ñ�� 
                $page_data[$page][$slip_num]["sale_amount"][$line]   = $act_data[$key][$key2]["sale_amount"][$j];   //��� 

                $line++;    //���ư

                //���ԥե饰
                $renew_row_flg = ($line == $max_line)? true : false;
            }

            $line = 0;   //������ꥢ
            $slip_num++; //��ɼ��
            $row+=3;     //����

            //���ڡ����ե饰
            $renew_page_flg = ($row >= $max_row)? true : false;
        }

        //�ڡ������Ȥνи���
        $page_data[$page]["goods_data"] = Make_Goods_Data ($arod_id[$page], $db_con);
        $page_data[$page]["last_flg"] = true;

        //���ڡ����ե饰��true
        if($renew_page_flg === true  && count($act_data[next]) != 0){

            $page++;                    //���ڡ���
            $row = 0;                   //�Կ����ꥢ
            $slip_num = 0;              //��ɼ�����ꥢ
            $renew_page_flg = false;
        }

        $row++;           //����
        $slip_num++;     //��ɼ��

        //���ڡ����ե饰
        $renew_page_flg = ($row >= $max_row)? true : false;
    }

    //�ڡ�����
    $page++;
    $page_data["page"] = $page;


    return $page_data;
}

//�����
function Get_Basic_Date($stand_day, $send_day){

    //��������ʬ��
    $all_send_day = explode("-", $send_day);

    //�����������������
    $send_day_w   = date('w', mktime(0,0,0,$all_send_day[1], $all_send_day[2], $all_send_day[0]));

    if($send_day_w == '0'){
        $week_w = "��";
    }elseif($send_day_w == '1'){
        $week_w = "��";
    }elseif($send_day_w == '2'){
        $week_w = "��";
    }elseif($send_day_w == '3'){
        $week_w = "��";
    }elseif($send_day_w == '4'){
        $week_w = "��";
    }elseif($send_day_w == '5'){
        $week_w = "��";
    }elseif($send_day_w == '6'){
        $week_w = "��";
    }

    $basic_date_res = Basic_date($stand_day[0],$stand_day[1],$stand_day[2],$all_send_day[0],$all_send_day[1],$all_send_day[2]);

    if($basic_date_res[0] == '1'){
        $week = "A";
    }elseif($basic_date_res[0] == '2'){
        $week = "B";
    }elseif($basic_date_res[0] == '3'){
        $week = "C";
    }elseif($basic_date_res[0] == '4'){
        $week = "D";
    }

    $res = $all_send_day[0]."ǯ".$all_send_day[1]."��".$all_send_day[2]."��";

    return $res;
}

function Show_Template ($message, $smarty){
    //���󥹥�������
    $form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

    $form->addElement("button","form_close_button", "�Ĥ���", "OnClick=\"window.close()\"");

    $page_title = "��Խ���ɽ";

    //////////////////////////////
    //HTML�إå�
    //////////////////////////////
    $html_header = Html_Header($page_title);

    //////////////////////////////
    //HTML�եå�
    //////////////////////////////
    $html_footer = Html_Footer();

    // Render��Ϣ������
    $renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
    $form->accept($renderer);

    //form��Ϣ���ѿ���assign
    $smarty->assign('form',$renderer->toArray());

    //����¾���ѿ���assign
    $smarty->assign('var',array(
        'html_header'   => "$html_header",
        'html_footer'   => "$html_footer",
        'message'       => "$message",
    ));

    //�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
    $smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
    exit;
}
?>
