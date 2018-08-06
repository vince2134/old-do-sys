<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/07      08-072      suzuki      Ģɼ���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  2006/11/07      08-100      suzuki      ���ID��ʸ�������Ϥ��줿�Ȥ��ˣԣϣФ����ܤ�����褦�˽���
 *  2006/11/07      08-101      suzuki      ������åװʳ������ID�����Ϥ��줿�Ȥ��ˣԣϣФ����ܤ�����褦�˽���
 *
 *
 */

/*
 �ѹ�����
 2006-11-27 Ǽ�ʽ�˸�����������褦�˽��� <suzuki>
 *   2007/03/01                  morita-d    ����̾������̾�Τ�ɽ������褦���ѹ� 
 *   2007/05/11                  watanabe-k  ľ���ξ�硢�вٰ����κ���ϡ�ľ����ξ���ױ����ϡְ��긵�ξ���פ�ɽ������ 
 *   2007/06/08                  watanabe-k  �����ʬ�ˤ���ۤ�ޥ��ʥ�ɽ������褦�˽��� 
 *   2007/06/14                  watanabe-k  �ѿ��ν�������Ǥ��ʤä��Х��ν��� 
 *   2009/09/16                  aoyama-n    �Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
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

// ���¥����å�
$auth = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];

$photo = COMPANY_SEAL_DIR.$shop_id.".jpg";    //�Ұ��Υե�����̾���������ô����Ź�Ρ�
$photo_exists = file_exists($photo);                    //�Ұ���¸�ߤ��뤫�ե饰

/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");
//����Ƚ��
Get_ID_Check3($_GET["sale_id"]);

//���ܸ�Ƚ��
if($_GET["sale_id"] != NULL){
    //��ǧ���̤�������
    $sale_id      = array($_GET["sale_id"]);
	//������Ƚ��ؿ�
	Injustice_check($db_con,"sale",$sale_id[0],$shop_id);
}else{
    //���ȯ�Ԥ�������
    if($_POST["hdn_button"]==  "��ȯ��"){
        $ary_sale_id      = @array_values($_POST["re_slip_check"]);          //���ID����
    }else{
        $ary_sale_id      = @array_values($_POST["slip_check"]);          //���ID����
    }

    for($i = 0; $i < count($ary_sale_id); $i++){
        if($ary_sale_id[$i] != 'f' &&  $ary_sale_id[$i] != null ){
            $sale_id[] = $ary_sale_id[$i];
			//������Ƚ��ؿ�
			Injustice_check($db_con,"sale",$ary_sale_id[$i],$shop_id);
        }
    }

    //�����å�����Ƥ��뤫�������
    if(count($sale_id) > 0){
        $imp_sale_id = implode(",",$sale_id);
    }else{
        print "<font color=\"red\"><b><li>ȯ�Ԥ�����ɼ����Ĥ����򤵤�Ƥ��ޤ���</b></font>";
        exit;
    }

    //��ɼȯ�ԥե饰��������
    Db_Query($db_con,"BEGIN");

    $sql  = "UPDATE t_sale_h ";
    $sql .= " SET";
    $sql .= "   slip_flg = 't',";
    $sql .= "   slip_out_day = NOW()";
    $sql .= " WHERE";
    $sql .= "   sale_id IN ($imp_sale_id)";
    $sql .= "   AND ";
    $sql .= "   slip_flg = 'f'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }

    Db_Query($db_con, "COMMIT");
}

for($s=0;$s<count($sale_id);$s++){
    $pdf->AddPage();
    /****************************/
    //���إå�������SQL
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    t_sale_h.renew_flg, ";
    $sql .= "    t_sale_h.direct_id, ";
    $sql .= "    CASE t_sale_h.trade_id ";
    $sql .= "       WHEN '11' THEN net_amount ";
    $sql .= "       WHEN '15' THEN net_amount ";
    $sql .= "       WHEN '61' THEN net_amount ";
    $sql .= "       ELSE net_amount * -1 ";
    $sql .= "    END AS net_amount, ";
    $sql .= "    CASE t_sale_h.trade_id ";
    $sql .= "       WHEN '11' THEN tax_amount ";
    $sql .= "       WHEN '15' THEN tax_amount ";
    $sql .= "       WHEN '61' THEN tax_amount ";
    $sql .= "       ELSE tax_amount * -1 ";
    //aoyama-n 2009-09-16
    #$sql .= "    END AS tax_amount ";
    $sql .= "    END AS tax_amount, ";
    $sql .= "    t_sale_h.trade_id ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "WHERE ";
    $sql .= "    t_sale_h.sale_id = ".$sale_id[$s].";";
    $result = Db_Query($db_con,$sql);
    Get_Id_Check($result);
    $stat = Get_Data($result);
    $renew_flg   = $stat[0][0];            //���������ե饰
    $direct_id   = $stat[0][1];            //ľ����ID

    $sale_amount = $stat[0][2];            //����۹�ס���ȴ��
    $tax_amount  = $stat[0][3];            //������

    //aoyama-n 2009-09-16
    $total_amount = $sale_amount+$tax_amount; //����۹�ס��ǹ���

    //aoyama-n 2009-09-16
    $trade       = $stat[0][4];            //�����ʬ

    /****************************/
    //�إå��������SQL
    /****************************/
    //���������夫
    if($renew_flg == 't'){
        //����������
        $sql  = "SELECT ";
        $sql .= "    t_sale_h.client_cd1,";
        $sql .= "    t_sale_h.client_cd2,";
        $sql .= "    t_sale_h.c_post_no1,";
        $sql .= "    t_sale_h.c_post_no2,";
        $sql .= "    t_sale_h.c_address1,";
        $sql .= "    t_sale_h.c_address2,";
        $sql .= "    t_sale_h.c_address3,";
        $sql .= "    t_sale_h.c_shop_name,";
        $sql .= "    t_sale_h.c_shop_name2,";
        $sql .= "    t_sale_h.sale_day,";
        $sql .= "    t_sale_h.sale_no,";
        $sql .= "    t_sale_h.c_staff_name, ";
        $sql .= "    t_client.tax_div, ";
		$sql .= "    t_client.compellation, ";
        $sql .= "    t_sale_h.note ";      
        $sql .= "FROM ";
        $sql .= "    t_sale_h ";
        $sql .= "    INNER JOIN t_client ON t_client.client_id = t_sale_h.client_id ";
        $sql .= "WHERE ";
        $sql .= "    t_sale_h.sale_id = ".$sale_id[$s].";";
    }else{
        //����������
        $sql  = "SELECT ";
        $sql .= "    t_sale_h.client_cd1,";
        $sql .= "    t_sale_h.client_cd2,";
        $sql .= "    t_sale_h.c_post_no1,";
        $sql .= "    t_sale_h.c_post_no2,";
        $sql .= "    t_sale_h.c_address1,";
        $sql .= "    t_sale_h.c_address2,";
        $sql .= "    t_sale_h.c_address3,";
        $sql .= "    t_sale_h.c_shop_name,";
        $sql .= "    t_sale_h.c_shop_name2,";
        $sql .= "    t_sale_h.sale_day,";
        $sql .= "    t_sale_h.sale_no,";
        $sql .= "    t_sale_h.c_staff_name, ";
        $sql .= "    t_client.tax_div, ";
		$sql .= "    t_client.compellation, ";      
        $sql .= "    t_sale_h.note ";      
        $sql .= "FROM ";
        $sql .= "    t_sale_h ";
        $sql .= "    INNER JOIN t_client ON t_client.client_id = t_sale_h.client_id ";
        $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_sale_h.c_staff_id ";
        $sql .= "WHERE ";
        $sql .= "    t_sale_h.sale_id = ".$sale_id[$s].";";
    }
    $result = Db_Query($db_con,$sql);
    $data_list = Get_Data($result,2);
    
    //ľ���褬������
    if($direct_id != NULL){
        $sql  = "SELECT ";
        $sql .= "    t_sale_h.direct_cd,";
        $sql .= "    t_sale_h.d_post_no1,";
        $sql .= "    t_sale_h.d_post_no2,";
        $sql .= "    t_sale_h.d_address1,";
        $sql .= "    t_sale_h.d_address2,";
        $sql .= "    t_sale_h.d_address3,";
        $sql .= "    t_sale_h.direct_name,";
        $sql .= "    t_sale_h.direct_name2,";
        $sql .= "    t_sale_h.d_tel,";
        $sql .= "    t_sale_h.d_fax,";
        $sql .= "    t_aorder_h.hope_day,";
        $sql .= "    t_sale_h.green_flg,";
        $sql .= "    t_aorder_h.note_your ";
        $sql .= "FROM ";
        $sql .= "    t_sale_h ";
        $sql .= "    LEFT JOIN t_direct ON t_direct.direct_id = t_sale_h.direct_id ";
        $sql .= "    LEFT JOIN t_aorder_h ON t_sale_h.aord_id = t_aorder_h.aord_id ";
        $sql .= "WHERE ";
        $sql .= "    t_sale_h.sale_id = ".$sale_id[$s].";";
    }

    $result = Db_Query($db_con,$sql);
    $direct_data = Get_Data($result,2);


    $code = $data_list[0][0]."-".$data_list[0][1]; //�����ͥ�����No
    $post = $data_list[0][2]."-".$data_list[0][3]; //͹���ֹ�
    $address1 = $data_list[0][4];                  //���꣱����
    $address2 = $data_list[0][5];                  //���ꣲ����
    $address3 = $data_list[0][6];                  //���ꣳ����
    $company  = $data_list[0][7];                  //���̾1
    $company2 = $data_list[0][8];                  //���̾2
    $memo     = Textarea_Non_Break($data_list[0][14],3);//���

	//�ɾ�Ƚ��
    if($data_list[0][13] == 1){
        //����
        $compell      = "����";
    }else{
        //��
        $compell      = "��";
    }

    //�ɾη��Ƚ��
    if($company2 != NULL){
        $company2 .= "��".$compell;
    }else{
        $company .= "��".$compell;
    }

    //�ѿ������
    unset($direct);
    unset($client_data);
    //ľ���褬���ꤵ��Ƥ������
    if($direct_id != null){


        $client_data["direct"] = $direct_data[0][6]."����ʬ";     //ľ����̾
        $client_data["name"] = $data_list[0][7]."����";         //������̾

        if($direct_data[0][11] == 't'){
            $client_data[4]  = "��˾Ǽ����".$direct_data[0][10]."�����꡼����ꡧͭ";
        }else{
            $client_data[4]  = "��˾Ǽ����".$direct_data[0][10]."�����꡼����ꡧ̵";
        }

        $direct[0]      = "ľ���襳����No.";
        $direct[1]      = $direct_data[0][0];
        $direct[2]      = $direct_data[0][1]."-".$direct_data[0][2];
        $direct[3]      = $direct_data[0][3];
        $direct[4]      = $direct_data[0][4];
        $direct[5]      = $direct_data[0][5];

		//ľ���裲����Ƚ��
		if($direct_data[0][7] != NULL){
			$direct[6]  = $direct_data[0][6];
			$direct[7]  = $direct_data[0][7]."������";
        }else{
			$direct[6]  = $direct_data[0][6]."������";
        }

        $direct[8]      = "TEL��".$direct_data[0][8]."��FAX:".$direct_data[0][9];

    }else{


        $direct[0]      = "�����襳����No.";
        $direct[1]      = $data_list[0][0]."-".$data_list[0][1];
        $direct[2]      = $data_list[0][2]."-".$data_list[0][3];
        $direct[3]      = $data_list[0][4];
        $direct[4]      = $data_list[0][5];
        $direct[5]      = $data_list[0][6];
        $direct[6]      = $company;
        $direct[7]      = $company2;
    }
    
    //��������
    $date = explode('-',$data_list[0][9]);
    $date_y = $date[0];                            //ǯ
    $date_m = $date[1];                            //��
    $date_d = $date[2];                            //��
    $slip   = $data_list[0][10];                   //��ɼ�ֹ�
    $charge = $data_list[0][11];                   //ô����
    $tax_div = $data_list[0][12];                  //����ñ��

    /****************************/
    //Ǽ�ʽ񥳥�������
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    d_memo1, ";        //Ǽ�ʽ񥳥���1
    $sql .= "    d_memo2, ";        //Ǽ�ʽ񥳥���2
    $sql .= "    d_memo3 ";         //Ǽ�ʽ񥳥���3
    $sql .= "FROM ";
    $sql .= "    t_h_ledger_sheet;";
    $result = Db_Query($db_con,$sql);
    $d_memo = Get_Data($result,2);

    //�����ɼ�ǥ�⤬���ꤵ��Ƥ��ʤ����ϥץ�ӥ塼��ͥ�褹��
    if($memo == null){
        $memo = Textarea_Non_Break($d_memo[0][2],3);
    }
    /****************************/
    //�ǡ����������SQL
    /****************************/
    $data_sql  = "SELECT ";
    //���������ե饰��true��
    if($renew_flg == 't'){
        $data_sql .= "    t_sale_d.goods_cd,";
    }else{
        $data_sql .= "    t_sale_d.goods_cd,";
    }
    $data_sql .= "    t_sale_d.official_goods_name,";
    $data_sql .= "    t_sale_d.num,";
    $data_sql .= "    t_sale_d.unit,";
    $data_sql .= "    CASE t_sale_h.trade_id \n";
    $data_sql .= "      WHEN '11' THEN t_sale_d.sale_price ";
    $data_sql .= "      WHEN '15' THEN t_sale_d.sale_price ";
    $data_sql .= "      WHEN '61' THEN t_sale_d.sale_price ";
    $data_sql .= "      ELSE  t_sale_d.sale_price * -1";
    $data_sql .= "    END AS sale_price, ";
    $data_sql .= "    CASE t_sale_h.trade_id \n";
    $data_sql .= "      WHEN '11' THEN t_sale_d.sale_amount ";
    $data_sql .= "      WHEN '15' THEN t_sale_d.sale_amount ";
    $data_sql .= "      WHEN '61' THEN t_sale_d.sale_amount ";
    $data_sql .= "      ELSE  t_sale_d.sale_amount * -1";
    //aoyama-n 2009-09-16
    #$data_sql .= "    END AS sale_amount ";
    $data_sql .= "    END AS sale_amount, ";
    $data_sql .= "    t_goods.discount_flg ";
    $data_sql .= "FROM ";
    $data_sql .= "    t_sale_d ";
    $data_sql .= "    INNER JOIN t_sale_h ON t_sale_d.sale_id = t_sale_h.sale_id ";
    $data_sql .= "    INNER JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id ";
    $data_sql .= "WHERE ";
    $data_sql .= "    t_sale_d.sale_id = ".$sale_id[$s];
    $data_sql .= " AND ";
    $data_sql .= "    t_sale_h.shop_id = $shop_id ";
    $data_sql .= "ORDER BY ";
    //���������ե饰��true��
    if($renew_flg == 't'){
        $data_sql .= "    t_sale_d.line;";
    }else{
        $data_sql .= "    t_sale_d.line;";
    }

    $result = Db_Query($db_con,$data_sql);
    $sale_data = Get_Data($result,2);

    //���ڡ�������׻�
    $sale_count = count($sale_data);
    $page_count = $sale_count / 5;
    $page_count = floor($page_count);
    $page_count2 = $sale_count % 5;
    if($page_count2 != 0){
        $page_count++;
    }

    //�ƥإå��ξ��ʥǡ���ʬɽ��
    for($page=1;$page<=$page_count;$page++){
        //���֤����
        $branch_no = str_pad($page, 2, "0", STR_PAD_LEFT);
        $branch_no = "-".$branch_no;       //��ɼ�ֹ�

        //��ڡ����ܤϡ����˥إå���ʬ�Ǻ������Ƥ��뤫�顢�ڡ������ɲä��ʤ�
        if($page != 1){
            $pdf->AddPage();
        }
        
        /****************************/
        //Ǽ�ʽ��������
        /****************************/
        $left_margin = 45;
        $posY = 11;

        //��������
        $pdf->SetLineWidth(0.2);
        //���ο�
		$pdf->SetDrawColor(153,102,0);
        //�ե��������
        $pdf->SetFont(GOTHIC,'', 9);
        //�ƥ����Ȥο�
		$pdf->SetTextColor(153,102,0); 
        //�طʿ�
		$pdf->SetFillColor(240,230,140);

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
        if($direct_id != NULL){
            $pdf->SetFont(GOTHIC,'', 8);
            $pdf->SetXY($left_margin+15, $posY+107);
            $pdf->Cell(50, 12,$client_data["direct"], '0', '1', 'L','0');
        }

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
        $pdf->RoundedRect($left_margin+10, $posY+120, 575, 115, 5, 'FD',1234);

        //��������
        $pdf->SetLineWidth(0.2);
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
        $pdf->RoundedRect($left_margin+10, $posY+130, 575, 105, 5, 'FD',34);

        //��������
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+333, $posY+236, 185, 47, 5, 'FD',34);

        $pdf->SetFont(GOTHIC,'', 8);
        //��������
        $pdf->SetLineWidth(0.2);

		//�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0); 

        //���ʥǡ����Կ�����
        $height = array('130','151','172','193','214');
        $h=0;
        for($x=0+(($page-1)*5);$x<($page*5);$x++){

            //aoyama-n 2009-09-16
            //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
            if($sale_data[$x][6] === 't' || $trade == '13' || $trade == '14' || $trade == '63' || $trade == '64'){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0);
            }

            if($x==($page*5)-1){
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                //���ʥ����ɤ�NULL����ʤ��Ȥ�����ɽ��
                if($sale_data[$x][0] != NULL && $sale_data[$x][1] != NULL){
                    $pdf->Cell(219, 21,$sale_data[$x][0]."/".$sale_data[$x][1], '0', '1', 'L','0');  //���ʥ����ɡ�̾��
                }else{
                    $pdf->Cell(219, 21,'', '0', '1', 'C','0');  //��ɽ��
                }
                $pdf->SetXY($left_margin+229, $posY+$height[$h]);
                //���̤�NULL����ʤ��Ȥ����������ѹ�
                if($sale_data[$x][2] != NULL){
                    $pdf->Cell(74, 21,number_format($sale_data[$x][2]), '1', '1', 'R','0');          //����
                }else{
                    $pdf->Cell(74, 21,($sale_data[$x][2]), '1', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+303, $posY+$height[$h]);
                $pdf->Cell(30, 21,$sale_data[$x][3], '1', '1', 'C','0');                             //ñ��
                $pdf->SetXY($left_margin+333, $posY+$height[$h]);
                //ñ����NULL����ʤ��Ȥ�����ɽ��
                if($sale_data[$x][4] != NULL){
                    $pdf->Cell(89, 21,number_format($sale_data[$x][4],2), 'R', '1', 'R','0');        //ñ��
                }else{
                    $pdf->Cell(89, 21,'', 'R', '1', 'R','0');                              
                }
                $pdf->SetXY($left_margin+422, $posY+$height[$h]);
                //��ۤ�NULL����ʤ��Ȥ����������ѹ�
                if($sale_data[$x][5] != NULL){
                    $pdf->Cell(96, 21,number_format($sale_data[$x][5]), 'R', '1', 'R','0');          //���
                }else{
                    $pdf->Cell(96, 21,$sale_data[$x][5], 'R', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $pdf->Cell(67, 21,'', '0', '1', 'L','0');                                            //����
            }else{
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if($sale_data[$x][0] != NULL && $sale_data[$x][1] != NULL){
                    $pdf->Cell(219, 21,$sale_data[$x][0]."/".$sale_data[$x][1], '1', '1', 'L','0');  
                }else{
                    $pdf->Cell(219, 21,'', '1', '1', 'L','0');  //��ɽ��
                }
                $pdf->SetXY($left_margin+229, $posY+$height[$h]);
                if($sale_data[$x][2] != NULL){
                    $pdf->Cell(74, 21,number_format($sale_data[$x][2]), '1', '1', 'R','0');
                }else{
                    $pdf->Cell(74, 21,$sale_data[$x][2], '1', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+303, $posY+$height[$h]);
                $pdf->Cell(30, 21,$sale_data[$x][3], '1', '1', 'C','0');
                $pdf->SetXY($left_margin+333, $posY+$height[$h]);
                //ñ����NULL����ʤ��Ȥ�����ɽ��
                if($sale_data[$x][4] != NULL){
                    $pdf->Cell(89, 21,number_format($sale_data[$x][4],2), '1', '1', 'R','0');
                }else{
                    $pdf->Cell(89, 21,'', '1', '1', 'C','0');                              
                }
                $pdf->SetXY($left_margin+422, $posY+$height[$h]);
                if($sale_data[$x][5] != NULL){
                    $pdf->Cell(96, 21,number_format($sale_data[$x][5]), '1', '1', 'R','0');
                }else{
                    $pdf->Cell(96, 21,$sale_data[$x][5], '1', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $pdf->Cell(67, 21,'', '1', '1', 'L','0');
            }
            $h++;
        }

        //�طʿ�
		$pdf->SetFillColor(240,230,140);
        $pdf->RoundedRect($left_margin+333, $posY+235, 89, 48, 5, 'FD',4);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+422, $posY+235, 96, 48, 5, 'FD',3);

		//�ƥ����Ȥο�
		$pdf->SetTextColor(153,102,0); 

        //��ȴ���
        $pdf->SetFont(GOTHIC,'', 9);
        $pdf->SetXY($left_margin+333, $posY+235);
        $pdf->Cell(89, 16,'��������', 'RB', '1', 'C','0');

		//�ƥ����Ȥο�
        //aoyama-n 2009-09-16
        #$pdf->SetTextColor(0,0,0); 
        if($trade == '13' || $trade == '14' || $trade == '63' || $trade == '64' || $total_amount < 0){
            $pdf->SetTextColor(255,0,16);
        }else{
            $pdf->SetTextColor(0,0,0); 
        }

        $pdf->SetXY($left_margin+422, $posY+235);
        //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
        if($page==$page_count){
            $pdf->Cell(96, 16,number_format($sale_amount), 'B', '1', 'R','0');
        }else{
            $pdf->Cell(96, 16,'', 'B', '1', 'R','0');
        }

        //����ñ��Ƚ��
        //��ɼñ��

		//�ƥ����Ȥο�
		$pdf->SetTextColor(153,102,0); 

        //������
        $pdf->SetFont(GOTHIC,'', 9);
        $pdf->SetXY($left_margin+333, $posY+251);
        $pdf->Cell(89, 16,'�á�����', 'RB', '1', 'C','0');

		//�ƥ����Ȥο�
        //aoyama-n 2009-09-16
        #$pdf->SetTextColor(0,0,0); 
        if($trade == '13' || $trade == '14' || $trade == '63' || $trade == '64' || $total_amount < 0){
            $pdf->SetTextColor(255,0,16);
        }else{
            $pdf->SetTextColor(0,0,0); 
        }

        $pdf->SetXY($left_margin+422, $posY+251);
        if($page==$page_count){
            $pdf->Cell(96, 16,number_format($tax_amount), 'B', '1', 'R','0');
        }else{
            $pdf->Cell(96, 16,"", 'B', '1', 'R','0');
        }

		//�ƥ����Ȥο�
		$pdf->SetTextColor(153,102,0); 

        //�ǹ����
        //aoyama-n 2009-09-16
        #$total_amount = $sale_amount+$tax_amount;
        $pdf->SetFont(GOTHIC,'', 9);
        $pdf->SetXY($left_margin+333, $posY+267);
        $pdf->Cell(89, 16,'�硡����', 'R', '1', 'C','0');

		//�ƥ����Ȥο�
        //aoyama-n 2009-09-16
        #$pdf->SetTextColor(0,0,0); 
        if($trade == '13' || $trade == '14' || $trade == '63' || $trade == '64' || $total_amount < 0){
            $pdf->SetTextColor(255,0,16);
        }else{
            $pdf->SetTextColor(0,0,0); 
        }

        $pdf->SetXY($left_margin+422, $posY+267);
        if($page==$page_count){
            $pdf->Cell(96, 16,number_format($total_amount), '0', '1', 'R','0');
        }else{
            $pdf->Cell(96, 16,"", '0', '1', 'R','0');
        }

		//�ƥ����Ȥο�
		$pdf->SetTextColor(153,102,0); 


        //Ŧ��
		$pdf->SetFont(GOTHIC,'', 8);
        $pdf->SetXY($left_margin+10, $posY+240);
        $pdf->Cell(10, 12,'�� �� ', '0', '1', 'L','0');

		$pdf->SetTextColor(0,0,0); 
        $pdf->RoundedRect($left_margin+10, $posY+250, 300, 33, 5, 'FD',1234);
        $pdf->SetXY($left_margin+10, $posY+253);
        $pdf->MultiCell(300, 10,$memo, '0', '1', '','0');


		$pdf->SetTextColor(153,102,0); 
        $pdf->SetXY($left_margin+525, $posY+238);
        $pdf->Cell(33, 28,'', '1', '1', 'C','0');
        $pdf->SetXY($left_margin+558, $posY+238);
        $pdf->Cell(33, 28,'', '1', '1', 'C','0');

        $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+540, $posY+270,56,18);

        /**********************************/
        //Ǽ�ʽ�����
        /**********************************/
        $posY = 315;

        //��������
        $pdf->SetLineWidth(0.2);
        //���ο�
		$pdf->SetDrawColor(129,53,255);
        //�ե��������
        $pdf->SetFont(GOTHIC,'', 9);
        //�ƥ����Ȥο�
		$pdf->SetTextColor(129,53,255); 
        //�طʿ�
		$pdf->SetFillColor(238,227,255);

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
        if($direct_id != NULL){
            $pdf->SetFont(GOTHIC,'', 8);
            $pdf->SetXY($left_margin+15, $posY+107);
            $pdf->Cell(50, 12,$client_data["direct"], '0', '1', 'L','0');
        }

		
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
        $pdf->RoundedRect($left_margin+10, $posY+120, 575, 115, 5, 'FD',1234);

        //��������
        $pdf->SetLineWidth(0.2);
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
        $pdf->RoundedRect($left_margin+10, $posY+130, 575, 105, 5, 'FD',34);

		//�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0); 

        //��������
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+333, $posY+235, 185, 47, 5, 'FD',34);
        $pdf->SetFont(GOTHIC,'', 8);
        //��������
        $pdf->SetLineWidth(0.2);
        //���ʥǡ����Կ�����
        $height = array('130','151','172','193','214');
        $h=0;
        for($x=0+(($page-1)*5);$x<($page*5);$x++){

            //aoyama-n 2009-09-16
            //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
            if($sale_data[$x][6] === 't' || $trade == '13' || $trade == '14' || $trade == '63' || $trade == '64'){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0);
            }

            if($x==($page*5)-1){
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                //���ʥ����ɤ�NULL����ʤ��Ȥ�����ɽ��
                if($sale_data[$x][0] != NULL && $sale_data[$x][1] != NULL){
                    $pdf->Cell(219, 21,$sale_data[$x][0]."/".$sale_data[$x][1], '0', '1', 'L','0');  //���ʥ����ɡ�̾��
                }else{
                    $pdf->Cell(219, 21,'', '0', '1', 'C','0');  //��ɽ��
                }
                $pdf->SetXY($left_margin+229, $posY+$height[$h]);
                //���̤�NULL����ʤ��Ȥ����������ѹ�
                if($sale_data[$x][2] != NULL){
                    $pdf->Cell(74, 21,number_format($sale_data[$x][2]), '1', '1', 'R','0');          //����
                }else{
                    $pdf->Cell(74, 21,($sale_data[$x][2]), '1', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+303, $posY+$height[$h]);
                $pdf->Cell(30, 21,$sale_data[$x][3], '1', '1', 'C','0');                             //ñ��
                $pdf->SetXY($left_margin+333, $posY+$height[$h]);
                //ñ����NULL����ʤ��Ȥ�����ɽ��
                if($sale_data[$x][4] != NULL){
                    $pdf->Cell(89, 21,number_format($sale_data[$x][4],2), 'R', '1', 'R','0');        //ñ��
                }else{
                    $pdf->Cell(89, 21,'', 'R', '1', 'C','0');                              
                }
                $pdf->SetXY($left_margin+422, $posY+$height[$h]);
                //��ۤ�NULL����ʤ��Ȥ����������ѹ�
                if($sale_data[$x][5] != NULL){
                    $pdf->Cell(96, 21,number_format($sale_data[$x][5]), 'R', '1', 'R','0');          //���
                }else{
                    $pdf->Cell(96, 21,$sale_data[$x][5], 'R', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $pdf->Cell(67, 21,'', '0', '1', 'L','0');                                            //����
            }else{
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if($sale_data[$x][0] != NULL && $sale_data[$x][1] != NULL){
                    $pdf->Cell(219, 21,$sale_data[$x][0]."/".$sale_data[$x][1], '1', '1', 'L','0');  
                }else{
                    $pdf->Cell(219, 21,'', '1', '1', 'C','0');  //��ɽ��
                }
                $pdf->SetXY($left_margin+229, $posY+$height[$h]);
                if($sale_data[$x][2] != NULL){
                    $pdf->Cell(74, 21,number_format($sale_data[$x][2]), '1', '1', 'R','0');
                }else{
                    $pdf->Cell(74, 21,$sale_data[$x][2], '1', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+303, $posY+$height[$h]);
                $pdf->Cell(30, 21,$sale_data[$x][3], '1', '1', 'C','0');
                $pdf->SetXY($left_margin+333, $posY+$height[$h]);
                //ñ����NULL����ʤ��Ȥ�����ɽ��
                if($sale_data[$x][4] != NULL){
                    $pdf->Cell(89, 21,number_format($sale_data[$x][4],2), '1', '1', 'R','0');
                }else{
                    $pdf->Cell(89, 21,'', '1', '1', 'C','0');                              
                }
                $pdf->SetXY($left_margin+422, $posY+$height[$h]);
                if($sale_data[$x][5] != NULL){
                    $pdf->Cell(96, 21,number_format($sale_data[$x][5]), '1', '1', 'R','0');
                }else{
                    $pdf->Cell(96, 21,$sale_data[$x][5], '1', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $pdf->Cell(67, 21,'', '1', '1', 'L','0');
            }
            $h++;
        }
        //�طʿ�
		$pdf->SetFillColor(238,227,255);
        $pdf->RoundedRect($left_margin+333, $posY+235, 89, 48, 5, 'FD',4);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+422, $posY+235, 96, 48, 5, 'FD',3);

		//�ƥ����Ȥο�
        $pdf->SetTextColor(129,53,255); 

        //��ȴ���
        $pdf->SetFont(GOTHIC,'', 9);
        $pdf->SetXY($left_margin+333, $posY+235);
        $pdf->Cell(89, 16,'��������', 'RB', '1', 'C','0');

		//�ƥ����Ȥο�
        //aoyama-n 2009-09-16
        #$pdf->SetTextColor(0,0,0); 
        if($trade == '13' || $trade == '14' || $trade == '63' || $trade == '64' || $total_amount < 0){
            $pdf->SetTextColor(255,0,16);
        }else{
            $pdf->SetTextColor(0,0,0); 
        }

        $pdf->SetXY($left_margin+422, $posY+235);
        //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
        if($page==$page_count){
            $pdf->Cell(96, 16,number_format($sale_amount), 'B', '1', 'R','0');
        }else{
            $pdf->Cell(96, 16,'', 'B', '1', 'C','0');
        }
        
		//�ƥ����Ȥο�
        $pdf->SetTextColor(129,53,255); 

        //����ñ��Ƚ��
        if($tax_div == '1'){
            //����ñ�̤������ξ��ϡ���������ˡ����ӡפ�ɽ��������פ���ȴ��ۤ�ɽ��

            //������
            $pdf->SetFont(GOTHIC,'', 9);
            $pdf->SetXY($left_margin+333, $posY+251);
            $pdf->Cell(89, 16,'�á�����', 'RB', '1', 'C','0');
            $pdf->SetXY($left_margin+422, $posY+251);
            if($page==$page_count){
                $pdf->Cell(96, 16,"����", 'B', '1', 'C','0');
            }else{
                $pdf->Cell(96, 16,"", 'B', '1', 'C','0');
            }

            //��ȴ���
            //aoyama-n 2009-09-16
            #$total_amount = $sale_amount;
            $pdf->SetFont(GOTHIC,'', 9);
            $pdf->SetXY($left_margin+333, $posY+267);
            $pdf->Cell(89, 16,'�硡����', 'R', '1', 'C','0');

			//�ƥ����Ȥο�
            //aoyama-n 2009-09-16
        	#$pdf->SetTextColor(0,0,0); 
            if($trade == '13' || $trade == '14' || $trade == '63' || $trade == '64' || $total_amount < 0){
                $pdf->SetTextColor(255,0,16);
            }else{
        	    $pdf->SetTextColor(0,0,0); 
            }
         

            $pdf->SetXY($left_margin+422, $posY+267);
            if($page==$page_count){
                //aoyama-n 2009-09-16
                #$pdf->Cell(96, 16,number_format($total_amount), '0', '1', 'R','0');
                $pdf->Cell(96, 16,number_format($sale_amount), '0', '1', 'R','0');
            }else{
                $pdf->Cell(96, 16,"", '0', '1', 'C','0');
            }
        }else{
            //��ɼñ��

            //������
            $pdf->SetFont(GOTHIC,'', 9);
            $pdf->SetXY($left_margin+333, $posY+251);
            $pdf->Cell(89, 16,'�á�����', 'RB', '1', 'C','0');

			//�ƥ����Ȥο�
            //aoyama-n 2009-09-16
        	#$pdf->SetTextColor(0,0,0); 
            if($trade == '13' || $trade == '14' || $trade == '63' || $trade == '64' || $total_amount < 0){
                $pdf->SetTextColor(255,0,16);
            }else{
        	    $pdf->SetTextColor(0,0,0); 
            }

            $pdf->SetXY($left_margin+422, $posY+251);
            if($page==$page_count){
                $pdf->Cell(96, 16,number_format($tax_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(96, 16,"", 'B', '1', 'C','0');
            }

			//�ƥ����Ȥο�
        	$pdf->SetTextColor(129,53,255); 

            //�ǹ����
            //aoyama-n 2009-09-16
            #$total_amount = $sale_amount+$tax_amount;
            $pdf->SetFont(GOTHIC,'', 9);
            $pdf->SetXY($left_margin+333, $posY+267);
            $pdf->Cell(89, 16,'�硡����', 'R', '1', 'C','0');

			//�ƥ����Ȥο�
            //aoyama-n 2009-09-16
        	#$pdf->SetTextColor(0,0,0); 
            if($trade == '13' || $trade == '14' || $trade == '63' || $trade == '64' || $total_amount < 0){
                $pdf->SetTextColor(255,0,16);
            }else{
        	    $pdf->SetTextColor(0,0,0); 
            }

            $pdf->SetXY($left_margin+422, $posY+267);
            if($page==$page_count){
                $pdf->Cell(96, 16,number_format($total_amount), '0', '1', 'R','0');
            }else{
                $pdf->Cell(96, 16,"", '0', '1', 'C','0');
            }
        }

		//�ƥ����Ȥο�
        $pdf->SetTextColor(129,53,255); 

        //Ŧ��
		$pdf->SetFont(GOTHIC,'', 8);
        $pdf->SetXY($left_margin+10, $posY+240);
        $pdf->Cell(10, 12,'�� �� ', '0', '1', 'L','0');

        $pdf->SetTextColor(0,0,0); 
        $pdf->RoundedRect($left_margin+10, $posY+250, 300, 33, 5, 'FD',1234);
        $pdf->SetXY($left_margin+10, $posY+253);
        $pdf->MultiCell(300, 10,$memo, '0', '1', '','0');


        $pdf->SetTextColor(129,53,255); 
        $pdf->SetXY($left_margin+525, $posY+238);
        $pdf->Cell(33, 28,'', '1', '1', 'C','0');
        $pdf->SetXY($left_margin+558, $posY+238);
        $pdf->Cell(33, 28,'', '1', '1', 'C','0');

        $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+540, $posY+270,56,18);

        /*********************************/
        //�вٰ����
        /*********************************/

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

        $pdf->SetFont(GOTHIC,'', 8);
        $pdf->SetXY($left_margin+10, $posY+10);
        $pdf->Cell(60, 12,$direct[0], '0', '1', 'C','0');
        $pdf->SetXY($left_margin+70, $posY+10);
        $pdf->Cell(100, 12,$direct[1],'0', '1', 'L','0');

		//�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0); 

        //͹���ֹ�
        $pdf->SetFont(GOTHIC,'', 9.5);
        $pdf->SetXY($left_margin+10, $posY+25);
        $pdf->Cell(15, 12,'��', '0', '1', 'L','0');
        $pdf->SetXY($left_margin+25, $posY+25);
        $pdf->Cell(50, 12,$direct[2], '0', '1', 'L','0');
    
        //���ꡦ��̾
        $pdf->SetFont(GOTHIC,'', 8);
        $pdf->SetXY($left_margin+15, $posY+38);
        $pdf->Cell(50, 12,$direct[3], '0', '1', 'L','0');
        $pdf->SetXY($left_margin+15, $posY+50);
        $pdf->Cell(50, 12,$direct[4], '0', '1', 'L','0');
        $pdf->SetXY($left_margin+15, $posY+62);
        $pdf->Cell(50, 12,$direct[5], '0', '1', 'L','0');
        //ľ���褬���ꤵ��Ƥ�����
        if($direct_id != NULL){
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+15, $posY+74);
            $pdf->Cell(50, 10,$direct[8], '0', '1', 'L','0');
            $pdf->SetFont(GOTHIC,'', 11);
            $pdf->SetXY($left_margin+20, $posY+84);
            $pdf->Cell(50, 12,$direct[6], '0', '1', 'L','0');
            $pdf->SetXY($left_margin+20, $posY+96);
            $pdf->Cell(50, 12,$direct[7], '0', '1', 'L','0');
        }else{
            $pdf->SetFont(GOTHIC,'', 11);
            $pdf->SetXY($left_margin+20, $posY+77);
            $pdf->Cell(50, 12,$direct[6], '0', '1', 'L','0');
            $pdf->SetXY($left_margin+20, $posY+92);
            $pdf->Cell(50, 12,$direct[7], '0', '1', 'L','0');
        }

		//�ƥ����Ȥο�
        $pdf->SetTextColor(255,0,16); 

        $pdf->SetFont(GOTHIC,'', 10);

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
        $pdf->RoundedRect($left_margin+10, $posY+120, 575, 115, 5, 'FD',1234);

        //��������
        $pdf->SetLineWidth(0.2);
        $pdf->RoundedRect($left_margin+10, $posY+120, 575, 10, 5, 'FD',12);
        $pdf->SetXY($left_margin+10, $posY+120);
        $pdf->Cell(219, 10,'���������ɡ�/���� �� �� �� ̾', 'R', '1', 'C','0');
        $pdf->SetXY($left_margin+229, $posY+120);
        $pdf->Cell(74, 10,'������ ��', 'R', '1', 'C','0');
        $pdf->SetXY($left_margin+303, $posY+120);
        $pdf->Cell(30, 10,'ñ ��', 'R', '1', 'C','0');
        $pdf->SetXY($left_margin+333, $posY+120);
        $pdf->Cell(252, 10,'����������', '0', '1', 'C','0');

		//�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0); 

        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+10, $posY+130, 575, 105, 5, 'FD',34);

        $pdf->SetFont(GOTHIC,'', 8);
        //��������
        $pdf->SetLineWidth(0.2);
        //���ʥǡ����Կ�����
        $height = array('130','151','172','193','214');
        $h=0;
        for($x=0+(($page-1)*5);$x<($page*5);$x++){

            //aoyama-n 2009-09-16
            //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
            if($sale_data[$x][6] === 't' || $trade == '13' || $trade == '14' || $trade == '63' || $trade == '64'){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0);
            }

            if($x==($page*5)-1){
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                //���ʥ����ɤ�NULL����ʤ��Ȥ�����ɽ��
                if($sale_data[$x][0] != NULL && $sale_data[$x][1] != NULL){
                    $pdf->Cell(219, 21,$sale_data[$x][0]."/".$sale_data[$x][1], '0', '1', 'L','0');  //���ʥ����ɡ�̾��
                }else{
                    $pdf->Cell(219, 21,'', '0', '1', 'C','0');  //��ɽ��
                }
                $pdf->SetXY($left_margin+229, $posY+$height[$h]);
                if($sale_data[$x][2] != NULL){
                    $pdf->Cell(74, 21,number_format($sale_data[$x][2]), '1', '1', 'R','0');          //����
                }else{
                    $pdf->Cell(74, 21,$sale_data[$x][2], '1', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+303, $posY+$height[$h]);
                $pdf->Cell(30, 21,$sale_data[$x][3], '1', '1', 'C','0');                             //ñ��
                $pdf->SetXY($left_margin+333, $posY+$height[$h]);
                $pdf->Cell(252, 21,$client_data[$h], '0', '1', 'L','0');
            }else{
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if($sale_data[$x][0] != NULL && $sale_data[$x][1] != NULL){
                    $pdf->Cell(219, 21,$sale_data[$x][0]."/".$sale_data[$x][1], '1', '1', 'L','0');  
                }else{
                    $pdf->Cell(219, 21,'', '1', '1', 'C','0');  //��ɽ��
                }
                $pdf->SetXY($left_margin+229, $posY+$height[$h]);
                if($sale_data[$x][2] != NULL){
                    $pdf->Cell(74, 21,number_format($sale_data[$x][2]), '1', '1', 'R','0');
                }else{
                    $pdf->Cell(74, 21,$sale_data[$x][2], '1', '1', 'R','0');
                }
                $pdf->SetXY($left_margin+303, $posY+$height[$h]);
                $pdf->Cell(30, 21,$sale_data[$x][3], '1', '1', 'C','0');
                $pdf->SetXY($left_margin+333, $posY+$height[$h]);
                $pdf->Cell(252, 21,$client_data[$h], '0', '1', 'L','0');
            }
            $h++;
        }

        $pdf->SetFont(GOTHIC,'', 8);
        $pdf->SetXY($left_margin+47, $posY+247);

		//�ƥ����Ȥο�
        $pdf->SetTextColor(255,0,16); 

        //Ŧ��  
        $pdf->SetFont(GOTHIC,'', 8);
        $pdf->SetXY($left_margin+10, $posY+240);
        $pdf->Cell(10, 12,'�� �� ', '0', '1', 'L','0');

        $pdf->SetTextColor(0,0,0);
        $pdf->RoundedRect($left_margin+10, $posY+250, 300, 33, 5, 'FD',1234);
        $pdf->SetXY($left_margin+10, $posY+253);
        $pdf->MultiCell(300, 10,$memo, '0', '1', '','0');


        $pdf->SetXY($left_margin+525, $posY+238);
        $pdf->Cell(33, 28,'', '1', '1', 'C','0');
        $pdf->SetXY($left_margin+558, $posY+238);
        $pdf->Cell(33, 28,'', '1', '1', 'C','0');
        $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+540, $posY+270,56,18);
    }
}

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