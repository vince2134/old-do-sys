<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/24��04-007��������watanabe-k���������ṹ����Ԥʤ��ȡ�Ʊ���ǡ�����2��ɽ������롣
 *                                         ������������ṹ����Ԥʤ��ȡ�Ʊ���ǡ�����3��ɽ�������Х��ν���
 *
 * ��2007/04/24��      ��������morita-d  ������������ս������Ǥ���褦�˽���
 *                                         ���ֺ���θ��ʧ�ۡפ�ɽ�����ܤ��ɲ�
 *                                         ��4��ޤǤι�NO�������ˤ�����ʤ��褦�˽���
 *   2007/06/20                watanabe-k  �������ȯ�ԾҲ�θ������б�
 */

$page_title = "�������ɽ";

//�Ķ�����ե�����
require_once("ENV_local.php");

//�����Ϣ�ǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR."seikyu.inc");

require_once(INCLUDE_DIR."common_quickform.inc");

//���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR.(basename($_SERVER["PHP_SELF"].".inc")));

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST");

//DB��³
$db_con = Db_Connect();

//�������ϻ���
$s_time = microtime();


/****************************/
// ���¥����å�
/****************************/
$auth   = Auth_Check($db_con);


/****************************/
//�ѿ�̾���֤������ʰʸ�$_POST�ϻ��Ѥ��ʤ���
/****************************/
// �桼������
if ($_POST["renew_flg"] == "1"){

    $display_num        = $_POST["form_display_num"];
    $output_type        = $_POST["form_output_type"];
    $client_branch      = $_POST["form_client_branch"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $round_staff_cd     = $_POST["form_round_staff"]["cd"];
    $round_staff_select = $_POST["form_round_staff"]["select"];
    $part               = $_POST["form_part"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $amount_this_s      = $_POST["form_amount_this"]["s"];
    $amount_this_e      = $_POST["form_amount_this"]["e"];
    $close_day_sy       = $_POST["form_close_day"]["sy"];
    $close_day_sm       = $_POST["form_close_day"]["sm"];
    $close_day_sd       = $_POST["form_close_day"]["sd"];
    $close_day_ey       = $_POST["form_close_day"]["ey"];
    $close_day_em       = $_POST["form_close_day"]["em"];
    $close_day_ed       = $_POST["form_close_day"]["ed"];
    $collect_day_sy     = $_POST["form_collect_day"]["sy"];
    $collect_day_sm     = $_POST["form_collect_day"]["sm"];
    $collect_day_sd     = $_POST["form_collect_day"]["sd"];
    $collect_day_ey     = $_POST["form_collect_day"]["ey"];
    $collect_day_em     = $_POST["form_collect_day"]["em"];
    $collect_day_ed     = $_POST["form_collect_day"]["ed"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $issue              = $_POST["form_issue"];
    $claim_send         = $_POST["form_cliam_send"];
    $last_update        = $_POST["form_last_update"];
    $bill_no_s          = $_POST["form_bill_no"]["s"];
    $bill_no_e          = $_POST["form_bill_no"]["e"];

    $where              = $_POST; 
    $claim_fix          = $_POST["claim_fix"];
    $claim_renew        = $_POST["claim_renew"];
    $claim_cancel       = $_POST["claim_cancel"];
    $branch_id          = $_POST["form_branch_id"];
 
    //����¾
    $f_page1            = $_POST["f_page1"];
    $hyouji_button      = $_POST["hyouji_button"];
    $fix_button         = $_POST["fix_button"];
    $renew_button       = $_POST["renew_button"];
    $cancel_button      = $_POST["cancel_button"];
    $bill_id            = $_POST["bill_id"];
    $link_action        = $_POST["link_action"];
    $renew_flg          = $_POST["renew_flg"];

    $post_flg           = true; 

}


/*********************************/
// �����å���hidden����
/*********************************/
/* ���̥ե����� */
Search_Form_Claim($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// �����ȯ��
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤ȯ��", "2");
$obj[]  =&  $form->createElement("radio", null, null, "ȯ�Ժ�", "3");
$form->addGroup($obj, "form_issue", "", " ");

// ���������
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",         "1");
$obj[]  =&  $form->createElement("radio", null, null, "͹��",         "2");
$obj[]  =&  $form->createElement("radio", null, null, "�᡼��",       "3");
$obj[]  =&  $form->createElement("radio", null, null, "WEB",          "5");
$obj[]  =&  $form->createElement("radio", null, null, "͹�����᡼��", "4");
$form->addGroup($obj, "form_claim_send", "", " ");

// ���ṹ��
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤�»�", "2");
$obj[]  =&  $form->createElement("radio", null, null, "�»ܺ�", "3");
$form->addGroup($obj, "form_last_update", "", " ");

// �����ֹ�
Addelement_Slip_Range($form, "form_bill_no", "�����ֹ�");

// ɽ���ܥ���
$form->addElement("text", "hyouji_button", "ɽ����");


/****************************/
// ���顼�����å�
/****************************/
/****************************/
// �饸���ܥ���������POST�����å�
/****************************/
$err_chk_radio = array(
    array($display_num,  "2"),      // ɽ�����
    array($output_type,  "2"),      // ���Ϸ���
    array($issue,        "3"),      // �����ȯ��
    array($claim_send,   "5"),      // ���������
    array($claim_update, "3"),      // ���ṹ��
);

foreach ($err_chk_radio as $key => $value){
    if (!("1" <= $value[0] || $value[0] <= $value[1])){
        print "�������ͤ����Ϥ���ޤ�����(".($key+1).")<br>";
        exit;
    }
}

// ����POST�ǡ�����0���
$_POST["form_close_day"]    = Str_Pad_Date($_POST["form_close_day"]);
$_POST["form_collect_day"]  = Str_Pad_Date($_POST["form_collect_day"]);

/****************************/
// ���顼�����å�
/****************************/
// �����ô����
$err_msg = "���ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
Err_Chk_Num($form, "form_round_staff", $err_msg);

// �������
$err_msg = "����� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
Err_Chk_Int($form, "form_amount_this", $err_msg);

// ����������
//$err_msg = "�������� �����դ������ǤϤ���ޤ���";
//Err_Chk_Date($form, "form_close_day", $err_msg);

// ����������
$err_msg = "�������� �����դ������ǤϤ���ޤ���";
// ʸ��������å�
if (    
    ($_POST["form_close_day"]["y"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["y"])) ||
    ($_POST["form_close_day"]["m"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["m"]))
){
    $form->setElementError("form_close_day", $err_msg);
}else   
// �����������å�
if ($_POST["form_close_day"]["m"] != null && ($_POST["form_close_day"]["m"] < 1 || $_POST["form_close_day"]["m"] > 12)){ 
    $form->setElementError("form_close_day", $err_msg);
}




// �����ͽ����
$err_msg = "���ͽ���� �����դ������ǤϤ���ޤ���";
Err_Chk_Date($form, "form_collect_day", $err_msg);

/****************************/
// ���顼�����å���̽���
/****************************/
// �����å�Ŭ��
$form->validate();
// ��̤�ե饰��
$err_flg = (count($form->_errors) > 0) ? true : false;

$post_flg = ($err_flg != true) ? true : false;


/****************************/
// ����ɽ������
/****************************/
if ($post_flg == true && $err_flg != true){

    //�����������
    $total_count = Get_Claim_Data($db_con, $where, "", "", "count");

    //���ߤΥڡ�����������å�����
    $page_info = Check_Page($total_count, $total_count, $f_page1);
    $page      = $page_info[0]; //���ߤΥڡ�����
    $page_snum = $page_info[1]; //ɽ�����Ϸ��
    $page_enum = $page_info[2]; //ɽ����λ���

    //�ڡ�������
    $data_list  = Get_Claim_Data($db_con, $where, $page_snum, $page_enum);

    require(FPDF_DIR);

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
    $title = "�������ɽ";
    $page_count = "1"; 

    //����
    $width[0]  = "25";
    $width[1]  = "45";
    $width[2]  = "55";
    $width[3]  = "300";
    $width[4]  = "55";
    $width[5]  = "70";
    $width[6]  = "70";
    $width[7]  = "70";
    $width[8]  = "70";
    $width[9]  = "70";
    $width[10] = "70";
    $width[11] = "70";
    $width[12] = "70";
    $width[13] = "70";


    //��������̾��align
    $list[0]  = array($width[0], "NO","C");
    $list[1]  = array($width[1], "�����ֹ�","C");
    $list[2]  = array($width[2], "������","C");
    $list[3]  = array($width[3], "������","C");
    $list[4]  = array($width[4], "���ͽ����","C");
    $list[5]  = array($width[5], BILL_AMOUNT_LAST,"C");
    $list[6]  = array($width[6], PAYIN_AMOUNT,"C");
    $list[7]  = array($width[7], TUNE_AMOUNT,"C");
    $list[8]  = array($width[8], REST_AMOUNT,"C");
    $list[9]  = array($width[9], SALE_AMOUNT,"C");
    $list[10] = array($width[10],TAX_AMOUNT,"C");
    $list[11] = array($width[11],INTAX_AMOUNT,"C");
    $list[12] = array($width[12],BILL_AMOUNT_THIS,"C");
    $list[13] = array($width[13],PAYMENT_THIS,"C");
//    $list[5] = array("150","���ô��","C");

    //���̾
    $list_sub[0] = array("50","���","L");

    //align(�ǡ���)�ͤ�������ϻ��Ѥ���Ƥ��ʤ�(2007/04/27:morita-d)
    $data_align[0] = "R";
    $data_align[1] = "L";
    $data_align[2] = "C";
    $data_align[3] = "L";
    $data_align[4] = "C";
    $data_align[5] = "R";
    $data_align[6] = "R";
    $data_align[7] = "R";
    $data_align[8] = "R";
    $data_align[9] = "R";
    $data_align[10] = "R";
    $data_align[11] = "R";
    $data_align[12] = "R";
//    $data_align[5] = "L";

    //�ڡ�������ɽ����
    $page_max = 50;

		//���
    $td_count = count($list);

    //���λ���
    if($close_day_s[y] != null && $close_day_e[y] != null){
        $time = "������֡�$close_day_s[y]ǯ$close_day_s[m]��$close_day_s[d]����$close_day_e[y]ǯ$close_day_e[m]��$close_day_e[d]��";
    }elseif($close_day_s[y] != null){
        $time = "������֡�$close_day_s[y]ǯ$close_day_s[m]��$close_day_s[d]����";
    }elseif($close_day_e[y] != null){
        $time = "������֡���$close_day_e[y]ǯ$close_day_e[m]��$close_day_e[d]��";
    }else{
        $time = "������֡�������̵��";
    }
    //***********************************************

    //DB��³
//    $result = Db_Query($db_con,$sql);

    $pdf->AddMBFont(GOTHIC ,'SJIS');
    $pdf->SetFont(GOTHIC, '', 9);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    $date = date("�������Yǯm��d����H:i");

    //�إå���ɽ��
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //�ģ¤��ͤ�ɽ��
    //�Կ����ڡ����������Υڡ���ɽ���������ס���ס�����͡�����������
    $count = 0;
    $page_count++;
    $page_next = $page_max;
    $data_total = array();
    $shop = "";
    $shop_count = 0;

//    while($data_list = pg_fetch_array($result)){
      for($i = 0; $i < count($data_list); $i++){
        $count++;
        //*******************���ڡ�������*****************************

	    //���ֹ椬�ڡ�������ɽ�����ˤʤä���硢���ڡ�������
	    if($page_next+1 == $count){
		    $pdf->AddPage();

		    //�إå���ɽ��
		    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		    //���κ���ɽ����
		    $page_next = $page_max * $page_count;
		    $page_count++;
	    }

        //************************��������***************************
/*
	    //�����褬�ѹ�������硢�����ܣ�
	    if($data_list[$i][3] != $shop){
		    $shop_count++;
	    $shop = $data_list[$i][slip_no];
	    }
*/
        //*************************************************************

	    $posY = $pdf->GetY();
	    $pdf->SetXY($left_margin, $posY);
	    $pdf->SetFont(GOTHIC, '', 9);

        //************************�ǡ���ɽ��***************************
	    //���ֹ�
//	    $pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
/*
	    for($x=1;$x<14;$x++){
		    $line = '1';
            if($x < 6){
		        $pdf->Cell($list[$x][0], 14, $data_list[$i][$x-1], 1, '0', 'L');
            }elseif($x < 13){
		        $pdf->Cell($list[$x][0], 14, $data_list[$i][$x-1], 1, '0', 'R');
            }else{
		        $pdf->Cell($list[$x][0], 14, $data_list[$i][$x-1], 1, '2', 'R');
            }
	    }
*/
        $number = $i+1;
        $pdf->Cell($width[0],  14, "$number", 1, '0', 'R');
        $pdf->Cell($width[1],  14, $data_list[$i][0],  1, '0', 'L');
        $pdf->Cell($width[2],  14, $data_list[$i][1],  1, '0', 'C');
        $pdf->Cell($width[3],  14, $data_list[$i][14]."-".$data_list[$i][15]."��".$data_list[$i][2], 1, '0', 'L');
        $pdf->Cell($width[4],  14, $data_list[$i][3],  1, '0', 'C');
        $pdf->Cell($width[5],  14, $data_list[$i][5],  1, '0', 'R');
        $pdf->Cell($width[6],  14, $data_list[$i][6],  1, '0', 'R');
        $pdf->Cell($width[7],  14, $data_list[$i][7],  1, '0', 'R');
        $pdf->Cell($width[8],  14, $data_list[$i][8],  1, '0', 'R');
        $pdf->Cell($width[9],  14, $data_list[$i][9],  1, '0', 'R');
        $pdf->Cell($width[10], 14, $data_list[$i][10], 1, '0', 'R');
        $pdf->Cell($width[11], 14, $data_list[$i][11], 1, '0', 'R');
        $pdf->Cell($width[12], 14, $data_list[$i][12], 1, '0', 'R');
        $pdf->Cell($width[13], 14, $data_list[$i][13], 1, '2', 'R');

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

		//�إå���ɽ��
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//���κ���ɽ����
		$page_next = $page_max * $page_count;
		$page_count++;
	}

    //*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

    //*************************��׽���*******************************
    for($x=0; $x<$td_count; $x++){
    //for($x=0;$x<13;$x++){
	    //��׹��ֹ�
	    if($x==0){
		    $pdf->Cell($width[$x], 14, "", '1', '0','R','1');
	    //���̾
	    }else if($x==1){
		    $pdf->Cell($width[$x], 14, $list_sub[0][1], '1', '0','R','1');
	    }else if($x==2){
		    $pdf->Cell($width[$x], 14, "", '1', '0','R','1');
	    //���
	    }else if($x==3){
		    $pdf->Cell($width[$x], 14, $data_list[0][sum][no]."��", '1', '0','R','1');
	    }else if($x==4){
		    $pdf->Cell($width[$x], 14, "", '1', '0','R','1');
	    //���
	    }else if($x > 4) {
		    //�����
		    $pdf->Cell($width[$x], 14, number_format($data_list[0][sum][$x]), '1', '0','R','1');
	    }
    }
    //****************************************************************

    $pdf->Output();
    exit;
//���顼�ξ��ϥƥ�ץ졼�Ȥ�ɽ��
}else{
    /****************************/
    //HTML�إå�
    /****************************/
    $html_header = Html_Header($page_title);

    /****************************/
    //HTML�եå�
    /****************************/
    $html_footer = Html_Footer();


    /****************************/
    //�ƥ�ץ졼�Ȥؤν���
    /****************************/
    // Render��Ϣ������
    $renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
    $form->accept($renderer);

    //form��Ϣ���ѿ���assign
    $smarty->assign('form',$renderer->toArray());

    //���顼��assign
    $errors = $form->_errors;
    $smarty->assign('errors', $errors);

    //�������
    $smarty->assign('claim_data', $claim_data);

    //����¾���ѿ���assign
    $smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    "auth_r_msg"  => "$auth_r_msg"
    ));

    //�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
    $smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));
}


































?>
