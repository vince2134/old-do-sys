<?php
/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *
 * ��������꡼������
 * ��ݻĹ���дؿ���
 * �������ν����ɲä�ɬ�פǤ�
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!/

/********************
 * �����ɼ
 *
 *
 * �ѹ�����
 *    2006/07/19 (kaji)
 *      ��PDF��֥饦���ǳ����ʤ��褦�ˡ��ե�����̾�������ɼ�����դǽ��Ϥ���褦�ˡ�
 *    2006/08/19 (kaji)
 *      �������ɼ����ư�����ʤɤǼ���ơ��֥뤬�ʤ����Ȥ�����Τ���������SQL���ѹ�
 *    2006/08/24 (kaji)
 *      ����ɼ���ϥե饰��slip_flg�ˤ�true�ˤ���������ɲ�
 *    2006/09/02 (kaji) �������˾ä��줿���ᡢ����
 *      �����ҥץ�ե��������Ͽ�����Ұ���ɽ��
 *      �����������ɼ�ѥ�������Ͽ����Ƥ��ʤ����˥�å�������ɽ�����ƽ�λ����
 *    2006/10/05 (kaji) ɽ���򤤤��Ĥ��ѹ�
 *      �������ʬ��ֳݡסָ���
 *      ���롼�Ȥ�ô����̾
 *      �������ʬ������ξ���������ɽ�����ʤ�
 *      ������Ž�ꥹ�ڡ������礭�����礭��
 *    2006-10-30 �����˥������󥰤�Ԥ�ʤ��褦�˽���<suzuki>
 *    2006-11-01 ��Ǽ�ʽ��μ��������������ꤷ���ͤ�ɽ�������褦�˽���<suzuki>
 *               ���Ұ��ΰ����ѹ�<suzuki>
 *    2006-12-04 ������ʬ��̾������̾�Τ����SQL���ѹ�(suzuki-t)
 *
 ********************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/10      02-046      suzuki      ô���ԡ��������������������ܥ��󲡤��ȡ���������ɽ�����֤�ɽ��
 *
 *  2006-12-10      03-059      suzuki      �����ʬ���Ͱ������ʤΤȤ�����ۤ�ޥ��ʥ�ɽ��
 *                  03-060
 *  2007-02-02                  watanabe-k  ���ΰ��֤��ѹ�
 *  2007/02/06      B0702-001   kajioka-h   ��夬¸�ߤ��뤫�����å��ɲ�
 *  2007/03/19                  watanabe-k  �������Ϥ��ʤ����ϥ���󥸤�ɽ��
 *  2007/04/02                  watanabe-k  ʣ�̤Ǥ���褦���ѹ�
 *  2007/04/05                  watanabe-k  �вٰ�������ϤǤ���褦�˽���
 *  2007/04/12      xx-xxx      kajioka-h   ����饤����Ԥ���������ɼ�Ͻ��Ϥ��ʤ��褦�ˤʤäƤ����Τ�Ǥ���褦���ѹ�
 *                  xx-xxx      kajioka-h   ����������ɼ�ǡ����������ݻĹ⤬���ä�����ɽ������̤����ۤ򥢥�˥ƥ����α��˰�ư
 *  2007/04/13      ��˾20-4    kajioka-h   ��ݻĹ�ǰ��������б�
 *  2007/04/14                  morita-d    ͽ����ɼȯ�Ԥ������ܤ������Ρ�����ID������ˡ���ѹ�
 *  2007/05/02                  morita-d    ���ե饤����ԤΤ������ɼ�ϡ��롼�Ȥ������̾��ɽ������褦���ѹ�
 *  2007/05/14                  watanabe-k  �������󤫤���ɼȯ�ԤǤ���褦�˽���
 *  2007/06/10                  watanabe-k  ľ���褬���򤵤�Ƥ������Τ߽вٰ�������Ϥ���褦�˽��� 
 *  2007/06/16                  watanabe-k����ɼ�������ʤ��Υ����å����ɲ� 
 *  2007/07/03                  watanabe-k��Ŧ�����������̾��ɽ�� 
 *  2007/07/05                  watanabe-k�����̥����Ȥ�Ǽ�ʽ���μ���ˤ�ȿ�Ǥ���褦�˽��� 
 *  2007/07/09                  watanabe-k������ñ�̤�������ξ��Ͼ����ǡ��ǹ���ۤ�ɽ�����ʤ��� 
 *  2007/08/09                  watanabe-k��������̾�����ꥢ����ʤ��Х��ν��� 
 *  2009/09/16                  aoyama-n �� �Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
 *  2009/09/16                  aoyama-n �� �����ʬ��ɽ���ѹ��ʳݡ����ͳݡ����֡��ݰ����������֡�������
 *  2009/09/21                  watanabe-k  ��ɼ��ȯ�Ի��ν������ɲ�
 */

require_once("ENV_local.php");

//��ݻĹ�����ؿ�
require_once(INCLUDE_DIR."function_monthly_renew.inc");


require(FPDF_DIR);
$pdf=new MBFPDF('P','pp','a4');
$pdf->SetProtection(array('print', 'copy'));
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(MINCHO ,'SJIS');
$pdf->SetAutoPageBreak(false);

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$client_id  = $_SESSION[client_id];
$output_id_array = $_POST["output_id_array"];  //����ID����

if($_POST["sale_republish_flg"] == "true"){
    $check_num_array = $_POST["form_republish_check"];  //��ɼ�����å�
}else{
    $check_num_array = $_POST["form_slip_check"];  //��ɼ�����å�
}

$more_slip = $_POST["form_more_slip"];    //�вٰ��������å�
/****************************/
// �ؿ�
/****************************/
// ����η�������������ؿ�
function Monthly_Renew_Day($db_con){

    /*
        $conn           DB��³�ؿ�
    */

    // �ǽ�����������
    $sql  = "SELECT \n";
    $sql .= "   MAX(close_day) \n";
    $sql .= "FROM \n";
    $sql .= "   t_sys_renew \n";
    $sql .= "WHERE \n";
    $sql .= "   renew_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $renew_day = pg_fetch_result($res, 0);
    if ($renew_day != null){
        $ary_renew_day = explode("-", $renew_day);
        $renew_day = date("Y-m-d", mktime(0, 0, 0, $ary_renew_day[1] , $ary_renew_day[2], $ary_renew_day[0]));
    }else{
        // �������Ԥ��Ƥ��ʤ����ϥ����ƥ೫����������
        $renew_day = START_DAY;
    }

    // ���դ��֤�
    return $renew_day;

}


/****************************/
//����ID��������
/****************************/
//��ɼ�˥����å���������˹Ԥ�
if($check_num_array != NULL){
    $aord_array = NULL;    //��ɼ���ϼ���ID����
    while($check_num = each($check_num_array)){
        //����ź���μ���ID����Ѥ���
        $check = $check_num[0];
		if($check_num[1] == 1){
        	$aord_array[] = $output_id_array[$check];
//            $more_check_array[] = $more_slip[$check];
		}
    }
}

//ͽ����ɼȯ�Ԥ��餭������ID�μ�����ˡ���ۤʤ��
if($_POST[src_module] == "ͽ����ɼȯ��"){
    $aord_array = NULL;    //��ɼ���ϼ���ID����

    if($_POST["hdn_button"] == "��ȯ��"){
        $check_array = $_POST["form_re_slip_check"];  //��ɼ�����å�
    }else{
        $check_array = $_POST["form_slip_check"];  //��ɼ�����å�
    }
    
    foreach($check_array AS $key => $val){
        if($val != "f"){
            $aord_array[] = $val;
        }
    }
//�������󤫤������
}elseif($_POST[src_module] == "��������" || $_POST[src_module] == "��Խ���ɽ"){
    $aord_array = null;

    if($_POST["form_hdn_submit"] == "��ȯ��"){
        $target = $_POST["form_reslip_check"];
    }else{
        $target = $_POST["form_slip_check"];
    }

    //��ɼ�ֹ椬���򤵤�Ƥ�����
    if(count($target) > 0){

        foreach($target AS $key => $val){
            if($val != 'f'){
                $exp_aord_ary = explode(',',$val);
                foreach($exp_aord_ary AS $keys => $vals){
                    $aord_array[] = $vals;
                }
            }
        }
    }
}

//��ɼ��������ξ��ϥ��顼����
if(count($aord_array) == 0){
    //���󥹥�������
    $form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

    $form->addElement("button","form_close_button", "�Ĥ���", "OnClick=\"window.close()\"");

    $page_title = "�����ɼ";

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
        'message'       => "��ɼ�����򤷤Ʋ�������",
    ));

    //�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
    $smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
    exit;
}

/****************************/
//��ɼ�ѥ�������Ͽ����Ƥ��뤫
/****************************/
$sql = "SELECT COUNT(s_pattern_id) FROM t_slip_sheet WHERE shop_id = $client_id;";
$result = Db_Query($db_con,$sql);

if(pg_fetch_result($result, 0, 0) == 0){
    print "<font color=\"red\"><b>";
    print "�����ɼ��ȯ�Ը�����Ͽ����Ƥ��ޤ���<br>";
    print "�����ɼ�����ȯ�Ը�����Ͽ���Ƥ���������";
    print "</b></font>";
    exit;
}

/****************************/
//���������ɼ�ѥ��������ꤵ��Ƥ��뤫
/****************************/
for($s=0;$s<count($aord_array);$s++){

    //��ɼ���������Ƥ��ʤ��������å�
    $sql  = "SELECT aord_id FROM t_aorder_h WHERE aord_id = ".$aord_array[$s]." \n";
    $sql .= "UNION \n";
    $sql .= "SELECT sale_id FROM t_sale_h WHERE sale_id = ".$aord_array[$s]." \n";
    $sql .= ";";
    $result = Db_Query($db_con,$sql);
    if(pg_num_rows($result) == 0){
        print "<font color=\"red\"><b>";
        print "���ꤷ�������ɼ�Ϻ�����줿��ǽ��������ޤ���<br>";
        print "���������ɼ����ꤷ�Ƥ���������";
        print "</b></font>";
        exit;
    }

    //����������ꤵ�줿��ɼ�ѥ���������
    $sql  = "SELECT \n";
    $sql .= "    s_pattern_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "WHERE \n";
    $sql .= "    client_id IN \n";
    $sql .= "        ( \n";
    $sql .= "            (SELECT client_id FROM t_sale_h WHERE sale_id = ".$aord_array[$s].") \n";
    $sql .= "        UNION \n";
    $sql .= "            (SELECT client_id FROM t_aorder_h WHERE aord_id = ".$aord_array[$s].") \n";
    $sql .= "        ) \n";
    $sql .= ";\n";

    $result = Db_Query($db_con,$sql);

    if(pg_fetch_result($result, 0, 0) == ""){
        print "<font color=\"red\"><b>";
        print "�����ɼ��ȯ�Ը������ꤵ��Ƥ��ʤ������褬����ޤ���<br>";
        print "������ޥ�����ȯ�Ը������ꤷ�Ƥ���������";
        print "</b></font>";
        exit;
    }
}


//����IDʬ��ɼɽ��
for($s=0;$s<count($aord_array);$s++){

    //2006/08/24 (kaji) ��ɼ���ϥե饰��slip_flg�ˤ�true�ˤ���������ɲ�
    $sql = "UPDATE t_aorder_h SET slip_flg = true, slip_out_day=NOW() WHERE aord_id = ".$aord_array[$s]." AND slip_out_day IS NULL;";
    $result = Db_Query($db_con,$sql);
    $sql = "UPDATE t_sale_h SET slip_flg = true, slip_out_day=NOW() WHERE sale_id = ".$aord_array[$s]." AND slip_out_day IS NULL;";
    $result = Db_Query($db_con,$sql);

    $pdf->AddPage();

    /****************************/
    //����������SQL
    /****************************/
    //����إå� 
    $sql  = "SELECT ";
    $sql .= "    t_aorder_h.client_cd1,";       // 0
    $sql .= "    t_aorder_h.client_cd2,";       // 1
    $sql .= "    t_aorder_h.client_name,";      // 2
    $sql .= "    t_aorder_h.client_name2,";     // 3
    $sql .= "    CASE t_aorder_h.trade_id ";    // 4
    //2006/10/05 (kaji) �����ʬ��ֳݡסָ��פ��ѹ�
    //$sql .= "     WHEN '11' THEN '�����' ";
    //$sql .= "     WHEN '61' THEN '�������' ";
    $sql .= "     WHEN '11' THEN '��' ";
    $sql .= "     WHEN '61' THEN '��' ";
    $sql .= "    END,";
    $sql .= "    t_aorder_h.ord_time,";         // 5
    $sql .= "    t_client.close_day, ";         // 6
    $sql .= "    t_client.tel,";                // 7
    $sql .= "    t_aorder_h.net_amount,";       // 8
    $sql .= "    t_aorder_h.tax_amount,";       // 9
    $sql .= "    t_aorder_d.line,";             //10
    $sql .= "    t_aorder_d.goods_cd,";         //11
    $sql .= "    t_aorder_d.serv_name,";        //12
    //$sql .= "    t_aorder_d.g_product_name || ' ' || t_aorder_d.official_goods_name,"; 
    $sql .= "    t_aorder_d.official_goods_name,";  //13
    $sql .= "    t_aorder_d.goods_name,";       //14
    $sql .= "    t_aorder_d.num,";              //15
    $sql .= "    t_aorder_d.sale_price,";       //16
    $sql .= "    t_aorder_d.sale_amount,";      //17
    $sql .= "    t_aorder_h.ord_no,";           //18
    $sql .= "    t_aorder_d.serv_print_flg,";   //19
    $sql .= "    t_aorder_d.goods_print_flg,";  //20
    $sql .= "    t_aorder_d.set_flg, ";         //21
    $sql .= "    t_g_goods.g_goods_name, ";     //22
    $sql .= "    t_aorder_d.rgoods_name,";      //23
    $sql .= "    t_aorder_h.client_id, ";       //24
    $sql .= "    '(' || t_aorder_d.rgoods_num || ')', ";     //25 ���ο���
    $sql .= "    t_client.compellation, ";      //26
    //2006/10/05 (kaji) �롼�Ȥ�ɽ�������Ѥν��ô���ԡʥᥤ��˼���
    $sql .= "    t_aorder_staff.staff_name, ";  //27

    //͹���ֹ桢����
    $sql .= "    '',";      //28
    $sql .= "    '',";      //29
    $sql .= "    '',";      //30
    $sql .= "    '',";      //31
    $sql .= "    '',";      //32
    $sql .= "    '',";      //33
    
    //��Ծ���
    $sql .= "    t_aorder_h.contract_div,";     //34
    $sql .= "    t_aorder_h.act_id,";           //35
    $sql .= "    t_aorder_h.act_name, ";        //36

    //ľ�������
    $sql .= "    t_aorder_h.direct_id, ";       //37
    $sql .= "    t_direct.direct_cd, ";         //38
    $sql .= "    t_aorder_h.direct_name, ";     //39
    $sql .= "    t_aorder_h.direct_name2, ";    //40
    $sql .= "    t_aorder_h.direct_cname, ";    //41
    $sql .= "    t_direct.post_no1 AS d_post_no1, ";    //42
    $sql .= "    t_direct.post_no2 AS d_post_no2, ";    //43
    $sql .= "    t_direct.address1 AS d_address1, ";    //44
    $sql .= "    t_direct.address2 AS d_address2, ";    //45
    $sql .= "    t_direct.address3 AS d_address3, ";    //46
    $sql .= "    t_direct.tel AS d_tel, ";      //47
    $sql .= "    t_direct.fax AS d_fax, ";       //48

    $sql .= "    t_client.client_slip1, ";      //49
    $sql .= "    t_client.client_slip2, ";      //50
    //aoyama-n 2009-09-16
    #$sql .= "    t_client.tax_div ";            //51������ñ�̡ʣ�������ñ�̡�������ɼñ�̡�
    $sql .= "    t_client.tax_div, ";            //51������ñ�̡ʣ�������ñ�̡�������ɼñ�̡�
    $sql .= "    t_goods.discount_flg ";         //52���Ͱ��ե饰


    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
    $sql .= "    INNER JOIN t_client ON t_aorder_h.client_id = t_client.client_id ";
    $sql .= "    LEFT JOIN t_direct ON t_aorder_h.direct_id = t_direct.direct_id ";
    $sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_aorder_d.goods_id ";
    $sql .= "    LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
    $sql .= "    LEFT JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id ";
    $sql .= "    LEFT JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id ";
    $sql .= "        AND t_aorder_staff.staff_div = '0' ";
    $sql .= "WHERE ";
    //$sql .= "    t_aorder_h.ps_stat = '1' ";
    //$sql .= "AND ";
    $sql .= "    t_aorder_h.confirm_flg = 'f' ";
    $sql .= "AND ";
    $sql .= "    t_aorder_h.aord_id = ".$aord_array[$s];

    $sql .= " UNION ";

    //���إå� 
    $sql .= "SELECT ";
    $sql .= "    t_sale_h.client_cd1,";      //������CD1 0
    $sql .= "    t_sale_h.client_cd2,";      //������CD2 1
    $sql .= "    t_sale_h.client_name,";     //������̾1 2
    $sql .= "    t_sale_h.client_name2,";    //������̾2 3
    $sql .= "    CASE t_sale_h.trade_id ";   //�����ʬ  4
    //2006/10/05 (kaji) �����ʬ��ֳݡסָ��פ��ѹ�
    //$sql .= "     WHEN '11' THEN '�����' ";
    //$sql .= "     WHEN '13' THEN '������' ";
    //$sql .= "     WHEN '14' THEN '���Ͱ�' ";
    //$sql .= "     WHEN '61' THEN '�������' ";
    //$sql .= "     WHEN '63' THEN '��������' ";
    //$sql .= "     WHEN '64' THEN '�����Ͱ�' ";
    $sql .= "     WHEN '11' THEN '��' ";
    //aoyama-n 2009-09-16
    #$sql .= "     WHEN '13' THEN '��' ";
    $sql .= "     WHEN '13' THEN '����' ";
    //aoyama-n 2009-09-16
    #$sql .= "     WHEN '14' THEN '��' ";
    $sql .= "     WHEN '14' THEN '�ݰ�' ";
    $sql .= "     WHEN '15' THEN '��' ";
    $sql .= "     WHEN '61' THEN '��' ";
    //aoyama-n 2009-09-16
    #$sql .= "     WHEN '63' THEN '��' ";
    $sql .= "     WHEN '63' THEN '����' ";
    //aoyama-n 2009-09-16
    #$sql .= "     WHEN '64' THEN '��' ";
    $sql .= "     WHEN '64' THEN '����' ";
    $sql .= "    END,";
    $sql .= "    t_sale_h.sale_day,";        //����� 5
    $sql .= "    t_client.close_day, ";      //����   6
    $sql .= "    t_client.tel,";             //�����ֹ� 7

    //$sql .= "    t_sale_h.net_amount,";      //����۹�� 8
	$sql .= "    t_sale_h.net_amount \n";
	$sql .= "    * ";
	$sql .= "    CASE t_sale_h.trade_id";
	$sql .= "        WHEN 13 THEN -1";
	$sql .= "        WHEN 63 THEN -1";
	$sql .= "        WHEN 14 THEN -1";
	$sql .= "        WHEN 64 THEN -1";
	$sql .= "        ELSE 1";
	$sql .= "    END, ";

    //$sql .= "    t_sale_h.tax_amount,";      //�����ǳ� 9
	$sql .= "    t_sale_h.tax_amount \n";         
	$sql .= "    * ";
	$sql .= "    CASE t_sale_h.trade_id";
	$sql .= "        WHEN 13 THEN -1";
	$sql .= "        WHEN 63 THEN -1";
	$sql .= "        WHEN 14 THEN -1";
	$sql .= "        WHEN 64 THEN -1";
	$sql .= "        ELSE 1";
	$sql .= "    END, ";

    $sql .= "    t_sale_d.line,";            //�� 10
    $sql .= "    t_sale_d.goods_cd,";        //����CD 11
    $sql .= "    t_sale_d.serv_name,";       //�����ӥ�̾ 12
    //$sql .= "    t_sale_d.g_product_name || ' ' || t_sale_d.official_goods_name,"; //����̾��(����ʬ�ࡦ����̾)
    $sql .= "    t_sale_d.official_goods_name,"; //����̾��(����ʬ�ࡦ����̾) 13
    $sql .= "    t_sale_d.goods_name,";      //ά�� 14
    $sql .= "    t_sale_d.num,";             //���� 15

    $sql .= "    t_sale_d.sale_price ";      //���ñ�� 16
	$sql .= "    * ";
	$sql .= "    CASE t_sale_h.trade_id";
	$sql .= "        WHEN 13 THEN -1";
	$sql .= "        WHEN 63 THEN -1";
	$sql .= "        WHEN 14 THEN -1";
	$sql .= "        WHEN 64 THEN -1";
	$sql .= "        ELSE 1";
	$sql .= "    END, ";

    $sql .= "    t_sale_d.sale_amount ";     //����� 17
	$sql .= "    * ";
	$sql .= "    CASE t_sale_h.trade_id";
	$sql .= "        WHEN 13 THEN -1";
	$sql .= "        WHEN 63 THEN -1";
	$sql .= "        WHEN 14 THEN -1";
	$sql .= "        WHEN 64 THEN -1";
	$sql .= "        ELSE 1";
	$sql .= "    END, ";

    $sql .= "    t_sale_h.sale_no,";         //����ֹ� 18
    $sql .= "    t_sale_d.serv_print_flg,";  //�����ӥ����� 19
    $sql .= "    t_sale_d.goods_print_flg,"; //�����ƥ���� 20
    $sql .= "    t_sale_d.set_flg, ";        //�켰�ե饰 21
    $sql .= "    t_g_goods.g_goods_name,";   //�Ͷ�ʬ 22
    $sql .= "    t_sale_d.rgoods_name,";     //����̾ 23
    $sql .= "    t_sale_h.client_id,";       //������ID 24
    $sql .= "    '(' || t_sale_d.rgoods_num || ')', ";     //���ο��� 25
    $sql .= "    t_client.compellation, ";  //26
    //2006/10/05 (kaji) �롼�Ȥ�ɽ�������Ѥν��ô���ԡʥᥤ��˼���
    $sql .= "    t_sale_staff.staff_name, ";//27
    //͹���ֹ桢����
    $sql .= "    t_sale_h.c_post_no1,";     //28
    $sql .= "    t_sale_h.c_post_no2,";     //29
    $sql .= "    t_sale_h.c_address1,";     //30
    $sql .= "    t_sale_h.c_address2,";     //31
    $sql .= "    t_sale_h.c_address3, ";    //32
    $sql .= "    t_sale_d.unit, ";          //ñ�� 33
    //��Ծ���
    $sql .= "    t_sale_h.contract_div,";   //34
    $sql .= "    t_sale_h.act_id,";         //35
    $sql .= "    t_sale_h.act_cname, ";     //36

    //ľ�������
    $sql .= "    t_sale_h.direct_id, ";     //37
    $sql .= "    t_sale_h.direct_cd, ";     //38
    $sql .= "    t_sale_h.direct_name, ";   //39
    $sql .= "    t_sale_h.direct_name2, ";  //40
    $sql .= "    t_sale_h.direct_cname, ";  //41
    $sql .= "    t_sale_h.d_post_no1, ";    //42
    $sql .= "    t_sale_h.d_post_no2, ";    //43
    $sql .= "    t_sale_h.d_address1, ";    //44
    $sql .= "    t_sale_h.d_address2, ";    //45
    $sql .= "    t_sale_h.d_address3, ";    //46
    $sql .= "    t_sale_h.d_tel, ";  //47
    $sql .= "    t_sale_h.d_fax,  ";  //48

    $sql .= "    t_client.client_slip1, ";      //49
    $sql .= "    t_client.client_slip2,  ";      //50
    //aoyama-n 2009-09-16
    #$sql .= "    t_client.tax_div ";            //51������ñ�̡ʣ�������ñ�̡�������ɼñ�̡�
    $sql .= "    t_client.tax_div, ";            //51������ñ�̡ʣ�������ñ�̡�������ɼñ�̡�
    $sql .= "    t_goods.discount_flg ";         //52���Ͱ��ե饰
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "    INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id ";
    $sql .= "    INNER JOIN t_client ON t_sale_h.client_id = t_client.client_id ";
    $sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_sale_d.goods_id ";
    $sql .= "    LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
    $sql .= "    LEFT JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id ";
    $sql .= "    LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id ";
    $sql .= "        AND t_sale_staff.staff_div = '0' ";
    $sql .= "WHERE ";
    //(2006/08/19) kaji �����ɼ����ư�����ʤɤǼ���ơ��֥뤬�ʤ����Ȥ�����Τǰʲ������ȥ�����
    //$sql .= "    t_sale_h.aord_id IS NOT NULL ";
    //$sql .= "AND ";
    $sql .= "    t_sale_h.sale_id = ".$aord_array[$s];

    $sql .= " ORDER BY ";
    $sql .= "    6,11;";

    $result = Db_Query($db_con,$sql);
    $data_list = Get_Data($result,2);


    // ����η�����������������ޤǤ���ݻĹ�����
    $ar_balance_this    = Get_Balance($db_con, "sale", $data_list[0][24]);


    /****************************/
    //DB������
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    t_client.s_pattern_id, ";      //�ѥ�����
    $sql .= "    t_client.deliver_effect, ";    //�����ȥե饰
    $sql .= "    t_client.deliver_note, ";      //������
    $sql .= "    t_client_info.cclient_shop ";  //ô����ŹID
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "    INNER JOIN t_client_info ON t_client.client_id = t_client_info.client_id ";
    $sql .= "WHERE ";
    $sql .= "    t_client.client_id = ".$data_list[0][24]." ";
    $sql .= "; ";

    $result = Db_Query($db_con,$sql);
    $client_memo = Get_Data($result,2);

    $sql  = "SELECT ";
    $sql .= "    s_memo1, ";        //�����ɼ������1 0
    $sql .= "    s_memo2, ";        //�����ɼ������2 1
    $sql .= "    s_memo3, ";        //�����ɼ������3 2
    $sql .= "    s_memo4, ";        //�����ɼ������4 3
    $sql .= "    s_memo5, ";        //�����ɼ������5 4
    $sql .= "    s_fsize1,";        //������1�ե���ȥ����� 5
    $sql .= "    s_fsize2,";        //������2�ե���ȥ����� 6
    $sql .= "    s_fsize3,";        //������3�ե���ȥ����� 7
    $sql .= "    s_fsize4,";        //������4�ե���ȥ����� 8
    $sql .= "    s_fsize5,";        //������5�ե���ȥ����� 9
    $sql .= "    s_memo6, ";        //�����ɼ������6 10
    $sql .= "    s_memo7, ";        //�����ɼ������7 11 
    $sql .= "    s_memo8, ";        //�����ɼ������8 12
    $sql .= "    s_memo9, ";        //�����ɼ������9 13
    $sql .= "    bill_send_flg, ";  //������Ϥ��ե饰 14
    $sql .= "    s_pattern_no ";    //�ѥ�����NO
    $sql .= "FROM ";
    $sql .= "    t_slip_sheet ";
    $sql .= "WHERE ";
    $sql .= "    s_pattern_id = ".$client_memo[0][0].";";
    $result = Db_Query($db_con,$sql);
    //DB���ͤ��������¸
    $s_memo = Get_Data($result,2);

    //��������ͥ��Ƚ���3:���Υ�����ͭ���Ϥ��Τޤ�table���ȡ�
    if($client_memo[0][1] == '1'){
        //������̵���ϡ�����ɽ��
        $s_memo[0][10] = NULL;
        $s_memo[0][12] = NULL;
        $s_memo[0][13] = NULL;
    }else if($client_memo[0][1] == '2'){
        //���������ꤷ��������
        $s_memo[0][10] = $client_memo[0][2];
        $s_memo[0][12] = $client_memo[0][2];
        $s_memo[0][13] = $client_memo[0][2];
    }

    //�������Ϥ��Ȥ����С��Ϥ��ʤ��Ȥ��ϡ����졼
    //                                      ����ʤ��ƥ����
    $bill_flg = $s_memo[0][14];

    //$photo = 'shain.png';   //�Ұ��Υե�����̾
    $photo = COMPANY_SEAL_DIR.$client_memo[0][3].".jpg";    //�Ұ��Υե�����̾���������ô����Ź�Ρ�
    $photo_exists = file_exists($photo);                    //�Ұ���¸�ߤ��뤫�ե饰

    
    /****************************/
    //�إå����ͼ���
    /****************************/
    $code = $data_list[0][0]."-".$data_list[0][1];     //�����ͥ�����No

    //��ɼ����������
    if($data_list[0][49] != '1'){
        $client_name1 = $data_list[0][2];                  //������̾1
    }else{
        $client_name1 = null;
    }

    //��ɼ����������
    if($data_list[0][50] != '1'){
        $client_name2 = $data_list[0][3];                  //������̾2
    }else{
        $client_name2 = null;
    }

    //�ɾ�Ƚ��
    if($data_list[0][26] == 1){
        //����
        $compell      = "����";
    }else{
        //��
        $compell      = "��";
    }
    //�ɾη��Ƚ��
    if($client_name2 != NULL){
        $client_name2 .= "��".$compell;
    }else{
        $client_name1 .= "��".$compell;
    }

    $trade_name   = $data_list[0][4];                  //�����ʬ
    $today        = $data_list[0][5];                  //������
    $close_day    = $data_list[0][6];                  //����

    //2006/10/05 (kaji) �����ϳݤξ������ʸ���ξ���ɽ�����ʤ���
    //aoyama-n 2009-09-16
    #if($trade_name == "��"){
    if($trade_name == "��" || $trade_name == '����' || $trade_name == '�ݰ�'){
        //���շ����ѹ�
        if($close_day == "29"){
            //����
            $close_day = "����";
        }else{
            //����������
            $close_day = $close_day."��";
        }
    } else {
        $close_day = "";
    }

    $tel          = $data_list[0][7];                  //�����ֹ�
    $slip         = $data_list[0][18];                 //��ɼ�ֹ�

    $route        = $data_list[0][27];                 //�롼�ȡʽ��ô����̾�ʥᥤ��ˡ�

    //�������ɼ�Υ롼��̾
    //���ե饤�������ɼ�ξ��
    if($data_list[0][34] == "3"){
        $route_kaiage        = $data_list[0][36];                 //������̾

    //�̾�or����饤����Ԥξ��
    }else{
        $route_kaiage        = $route;                 //�롼�ȡʽ��ô����̾�ʥᥤ��ˡ�
    }


    $sale_amount  = $data_list[0][8];            //����۹��
    //��ɼ�˾����Ǥ�ɽ������ե饰
    $tax_disp_flg            = ($data_list[0][51] == '2')? true : false;
    if($tax_disp_flg === false){
        $tax_amount   = null;                       //�����ǳ�
        $intax_amount = null;
        $tax_message1 = "-";
        $tax_message2 = "�������";
    }else{
        $tax_amount   = $data_list[0][9];        //�����ǳ�
        $tax_message1 = null;
        $tax_message2 = null;
    }
    $intax_amount = $sale_amount + $tax_amount ;


    /****************************/
    //ľ�������
    /****************************/
    unset($direct);
    //ľ���褬���򤵤�Ƥ������
    if($data_list[0][37] != null){

        //�вٰ������ϥե饰��true�ˤ���
        $more_check_array[$s] = true;

        //ľ����ξ���򥻥å�
        $direct["cd"]       = $data_list[0][38];

        $direct["name"]     = $data_list[0][39];
        $direct["name2"]    = $data_list[0][40];

        if($direct["name2"] != null){
            $direct["name2"] = $direct["name2"]."������";
        }else{
            $direct["name"]  = $direct["name"]."������";
        }

        $direct["cname"]    = $data_list[0][41];
        $direct["post_no1"] = $data_list[0][42];
        $direct["post_no2"] = $data_list[0][43];
        $direct["address1"] = $data_list[0][44];
        $direct["address2"] = $data_list[0][45];
        $direct["address3"] = $data_list[0][46];
        $direct["tel"]      = $data_list[0][47];
        $direct["fax"]      = $data_list[0][48];
        $direct["client_name"]  = $client_name1."������";
    }

    /****************************/
    //���ڡ�������׻�
    /****************************/
    $data_count = pg_num_rows($result);
    $page_count = $data_count / 5;
    $page_count = floor($page_count);
    $page_count2 = $data_count % 5;
    if($page_count2 != 0){
        $page_count++;
    }
    //�ƥإå��ξ��ʥǡ���ʬɽ��
    for($page=1, $p=0 ;$page<=$page_count;$page++, $p++){
        //���֤����
        $branch_no = str_pad($page, 2, "0", STR_PAD_LEFT);
        $branch_no = "-".$branch_no;       //��ɼ�ֹ�

        //��ڡ����ܤϡ����˥إå���ʬ�Ǻ������Ƥ��뤫�顢�ڡ������ɲä��ʤ�
        if($page != 1){
            $pdf->AddPage();
        }

        /****************************/
        //���㤤�夲��ɼ�������
        /****************************/
        $left_margin=50;
        $posY=16;
        //��������
        $pdf->SetLineWidth(0.8);
        //���ο�
        $pdf->SetDrawColor(80,80,80);
        //�ե��������
        $pdf->SetFont(GOTHIC,'', 7);
        //�طʿ�
        $pdf->SetFillColor(221,221,221);
        //����Ѵ�(��)
        $pdf->RoundedRect($left_margin+10, $posY+10, 260, 12, 5, 'FD',12);
        //�ƥ����Ȥο�
        $pdf->SetTextColor(80,80,80); 
        //�طʿ�
        $pdf->SetFillColor(255);
        //����Ѵ�(��)
        $pdf->RoundedRect($left_margin+10, $posY+22, 260, 53, 5, 'FD',34);
        $pdf->SetXY($left_margin+15, $posY);
        $pdf->Cell(100, 8,"�����ͥ����ɡ�$code", '', '1', 'L','0');
        $pdf->SetXY($left_margin+490, $posY);
        $pdf->Cell(100, 8,"��ɼ�ֹ桡".$slip.$branch_no, '', '1', 'R','0');
        //�ե��������
        $pdf->SetFont(GOTHIC,'', 9);
        $pdf->RoundedRect($left_margin+10, $posY+22, 260, 53, 5, 'FD',34);
        $pdf->SetXY($left_margin+10, $posY+10);
        $pdf->Cell(260, 12,'�桡���������ա����衡��̾', 'B', '1', 'C','0');
        //��������
        $pdf->SetLineWidth(0.2);
        //�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0); 
        //�ե��������
        $pdf->SetFont(GOTHIC,'B', 8);
        $pdf->SetXY($left_margin+10, $posY+23);
        $pdf->Cell(240, 9,$client_name1, '0', '1', 'L','0');
        $pdf->SetXY($left_margin+10, $posY+34);
        $pdf->Cell(240, 9,$client_name2, '0', '1', 'L','0');
        //�طʿ�
        $pdf->SetFillColor(221,221,221);
        //�ƥ����Ȥο�
        $pdf->SetTextColor(80,80,80); 

        //�ե��������
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+10, $posY+45);
        $pdf->Cell(260, 12,'', '1', '0', 'C','0');
        $pdf->SetXY($left_margin+10.4, $posY+45);
        $pdf->Cell(22, 12,'���', '0', '0', 'C','1');
        $pdf->Cell(52, 12,'����ǯ����', '0', '0', 'C','1');
        $pdf->Cell(90, 12,'�롼��', '0', '0', 'C','1');
        $pdf->Cell(25, 12,'����', '0', '0', 'C','1');
        $pdf->Cell(70, 12,'�š��á��֡���', '0', '0', 'C','1');
        
        //�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0);
        //�ե��������
        $pdf->SetFont(GOTHIC,'', 7);
        $pdf->SetXY($left_margin+10.4, $posY+57);
        $pdf->Cell(22, 17.5,$trade_name, 'R', '0', 'C','0');
        $pdf->Cell(52, 17.5,$today, 'R', '0', 'C','0');
        $pdf->Cell(90, 17.5, $route_kaiage, 'R', '0', 'L','0');
        $pdf->Cell(25, 17.5,$close_day, 'LR', '0', 'C','0');
        $pdf->Cell(70.4, 17.5,$tel, '0', '0', 'L','0');

        //�ƥ����Ȥο�
        $pdf->SetTextColor(80,80,80); 
        $pdf->SetFont(GOTHIC,'B', 11);
        $pdf->SetXY($left_margin+273, $posY+10);
        $pdf->Cell(110, 12,'�� �� �� �� ɼ '.$s_memo[0][15].'', 'B', '1', 'C','0');

        //��������
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+285, $posY+30, 10, 45, 3, 'FD',14);

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
        $pdf->RoundedRect($left_margin+295, $posY+30, 65, 45, 3, 'FD',23);
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
        $pdf->RoundedRect($left_margin+10, $posY+80, 575, 10, 5, 'FD',12);

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
        $pdf->Cell(66, 10,'��������������', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+518, $posY+80);
        $pdf->Cell(66.7, 10,'�¡���������', '0', '1', 'C','0');

        //�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0); 

        //��������
        $pdf->SetLineWidth(0.8);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+10, $posY+90, 575, 105, 5, 'FD',34);

        //�ե��������
        $pdf->SetFont(GOTHIC,'', 7);
        //��������
        $pdf->SetLineWidth(0.2);

        //���ʥǡ����Կ�����
        $height = array('90','111','132','153','174');
        $h=0;
        for($x=0+(($page-1)*5);$x<($page*5);$x++){

            //aoyama-n 2009-09-16
            //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
            if($data_list[$x][52] === 't' || 
               $trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����'){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0);
            }

            //�Ǹ�ιԤ�Ƚ��
            if($x==($page*5)-1){
                //���ʥ�����
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if ($data_list[$x][20] == 't'){
                    $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');  
                }else{
                    $pdf->Cell(40, 21,'', 'T', '1', 'L','0');  
                }
                //�����ӥ�/�����ƥ�̾
                $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                //̾��Ƚ��
                if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                    //�����ӥ��������ƥ�̾(ά��)
                    $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                    //�����ӥ�̾�Τ�
                    $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                    //�����ƥ�̾�Τ�(����̾��)
                    $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                }else{
                    //NULL
                    $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                }

                //����
                $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                /*
                 * ����
                 *  ����            BɼNo.      ô����      ����
                 *  2006/11/09      02-059      kajioka-h   �켰���ꡢ���̤ʤ��ξ��˿�����ˡְ켰�פ�ɽ������褦���ѹ�
				 *	2009/06/18		����No.39	aizawa-m	5���ܡ����̤�"�켰"�ν��Ϥ򱦴����ѹ�
                 *
                 */
                //���̻���Ƚ��
                if($data_list[$x][21] == 't'){
                    //���̤����뤫�ġ��켰�˥����å���������
					//-- 2009/06/18 ����No.39 "C"��"R"���ѹ� 
                    $pdf->Cell(32, 21,'�켰', '1', '1', 'R','0');
                    //$pdf->Cell(32, 21,'�켰', '1', '1', 'C','0');
                }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                    //���̤����뤫�İ켰�˥����å����ʤ�
                    $pdf->Cell(32, 21,number_format($data_list[$x][15]), '1', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(32, 21,'', '1', '1', 'C','0');                              
                }

                //ñ��
                $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                //ñ������Ƚ��
                if($data_list[$x][16] != NULL){
                    //�����ѹ�
                    $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LTB', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');
                }

                //���
                $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                //��ۻ���Ƚ��
                if($data_list[$x][17] != NULL){
                    //�����ѹ�
                    $pdf->Cell(62, 21,number_format($data_list[$x][17]), '1', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(62, 21,'', '1', '1', 'R','0');
                }

                //����
                $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                $pdf->Cell(66, 21,'', '1', '1', 'C','0');

                //�¤�
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], "T",'L','0');


            }else{
                //���ʥ�����
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if ($data_list[$x][20] == 't'){
                    $pdf->Cell(40, 21,$data_list[$x][11], 'LRT', '1', 'L','0');  
                }else{
                    $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');  
                }
                //�����ӥ�/�����ƥ�̾
                $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                //̾��Ƚ��
                if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                    //�����ӥ��������ƥ�̾(ά��)
                    $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], 'LRT', '1', 'L','0');
                }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                    //�����ӥ�̾�Τ�
                    $pdf->Cell(256, 21,$data_list[$x][12], 'LRT', '1', 'L','0');
                }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                    //�����ƥ�̾�Τ�(����̾��)
                    $pdf->Cell(256, 21,$data_list[$x][13], 'LRT', '1', 'L','0');
                }else{
                    //NULL
                    $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');
                }

                //����
                $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                /*
                 * ����
                 *  ����            BɼNo.      ô����      ����
                 *  2006/11/09      02-059      kajioka-h   �켰���ꡢ���̤ʤ��ξ��˿�����ˡְ켰�פ�ɽ������褦���ѹ�
                 *
                 */
                //���̻���Ƚ��
                if($data_list[$x][21] == 't'){
                    //���̤����뤫�ġ��켰�˥����å���������
                    $pdf->Cell(32, 21,'�켰', 'LRT', '1', 'R','0');
                }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                    //���̤����뤫�İ켰�˥����å����ʤ�
                    $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                }

                //ñ��
                $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                //ñ������Ƚ��
                if($data_list[$x][16] != NULL){
                    //�����ѹ�
                    $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LT', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');
                }

                //���
                $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                //��ۻ���Ƚ��
                if($data_list[$x][17] != NULL){
                    //�����ѹ�
                    $pdf->Cell(62, 21,number_format($data_list[$x][17]), 'LRT', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');
                }

                //����
                $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                $pdf->Cell(66, 21,'', 'LRT', '1', 'C','0');

                //�¤�
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'LRT','L','0');
            }
            $h++;
        }

        //aoyama-n 2009-09-16
        //�����Υƥ����Ȥο�
        if($trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����' ||
           $intax_amount < 0 ){
            $pdf->SetTextColor(255,0,16);
        }else{
            $pdf->SetTextColor(0,0,0);
        }

        //��������
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+452, $posY+195, 66, 57, 5, 'FD',34);
        //��������
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+452, $posY+195);
        $pdf->Cell(66, 19,'', '1', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+214);
        $pdf->Cell(66, 19,$tax_message2, '1', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+233);
        $pdf->Cell(66, 19,'', 'T', '1', 'C','0');


        //��������
        $pdf->SetLineWidth(0.8);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+390, $posY+195, 62, 57, 5, 'FD',34);
        //��������
        $pdf->SetLineWidth(0.2);

        //��ȴ���
        //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
        $pdf->SetXY($left_margin+390, $posY+195);
        if($page==$page_count){
            $pdf->Cell(62, 19,number_format($sale_amount), 'B', '1', 'R','0');
        }else{
            $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
        }

        //�����ǳ�
        //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
        $pdf->SetXY($left_margin+390, $posY+214);
        if($page==$page_count){

            if($tax_disp_flg === true){
                $pdf->Cell(62, 19,My_number_format($tax_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'-', 'B', '1', 'C','0');
            } 
        }else{
            $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
        }

        //��׶��
        //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
        $pdf->SetXY($left_margin+390, $posY+233);
        if($page==$page_count){
            $pdf->Cell(62, 19,number_format($intax_amount), '0', '1', 'R','0');
        }else{
            $pdf->Cell(62, 19,'', '0', '1', 'R','0');
        }
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
        $pdf->RoundedRect($left_margin+10, $posY+205, 260, 58, 5, 'FD',1234);

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
        $pdf->RoundedRect($left_margin+280, $posY+205,  56, 10, 3, 'FD',12);
        //��������
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+280, $posY+205);
        $pdf->Cell(56, 10,'ô �� �� ̾', '0', '1', 'C','0');
        //��������
        $pdf->SetLineWidth(0.8);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+280, $posY+215, 56, 48, 3, 'FD',34);

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

        $pdf->Line($left_margin+32.4,$posY+45,$left_margin+32.4,$posY+75);
        $pdf->Line($left_margin+84.4,$posY+45,$left_margin+84.4,$posY+75);
        $pdf->Line($left_margin+174.4,$posY+45,$left_margin+174.4,$posY+75);
        $pdf->Line($left_margin+199.4,$posY+45,$left_margin+199.4,$posY+75);

        // ̤����ɽ��
        //aoyama-n 2009-09-16
        #if ($trade_name == "��" && $ar_balance_this != 0 && $ar_balance_this != null){
        if (($trade_name == '��' || $trade_name == '����' || $trade_name == '����') && 
            $ar_balance_this != 0 && $ar_balance_this != null){
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+50, $posY+265);
            $pdf->Cell(0, 10, number_format($ar_balance_this).'�ߤ�̤����ȤʤäƤ���ޤ���', '0', '1', 'L','0');
        }

        //��
        $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+265,45,15);

        $posY=325;
        
        //�μ���ɽ��Ƚ��
        //if($trade_name == '�������' || $trade_name == '��������' || $trade_name == '�����Ͱ�'){
        //aoyama-n 2009-09-16
        #if($trade_name == '��'){
        if($trade_name == '��' || $trade_name == '����' || $trade_name == '����'){
            /****************************/
            //�μ�����ɼ�������
            /****************************/
            //��������
            $pdf->SetLineWidth(0.8);
            //���ο�
            $pdf->SetDrawColor(29,0,120);
            //�ե��������
            $pdf->SetFont(GOTHIC,'', 9);
            //�طʿ�
            $pdf->SetFillColor(200,230,255);
            //����Ѵ�(��)
            $pdf->RoundedRect($left_margin+10, $posY+10, 260, 12, 5, 'FD',12);
            //�ƥ����Ȥο�
            $pdf->SetTextColor(61,50,180); 
            //�طʿ�
            $pdf->SetFillColor(255);

            //�ե��������
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+15, $posY);
            $pdf->Cell(100, 8,"�����ͥ����ɡ�$code", '', '1', 'L','0');
            $pdf->SetXY($left_margin+490, $posY);
            $pdf->Cell(100, 8,"��ɼ�ֹ桡".$slip.$branch_no, '', '1', 'R','0');

            //����Ѵ�(��)
            $pdf->SetFont(GOTHIC,'', 9);
            $pdf->RoundedRect($left_margin+10, $posY+22, 260, 53, 5, 'FD',34);
            $pdf->SetXY($left_margin+10, $posY+10);
            $pdf->Cell(260, 12,'�桡���������ա����衡��̾', 'B', '1', 'C','0');
            //��������
            $pdf->SetLineWidth(0.2);
            //�ƥ����Ȥο�
            $pdf->SetTextColor(0,0,0); 
            //�ե��������
            $pdf->SetFont(GOTHIC,'B', 8);
            $pdf->SetXY($left_margin+10, $posY+23);
            $pdf->Cell(240, 9,$client_name1, '0', '1', 'L','0');
            $pdf->SetXY($left_margin+10, $posY+34);
            $pdf->Cell(240, 9,$client_name2, '0', '1', 'L','0');
            //�ƥ����Ȥο�
            $pdf->SetTextColor(61,50,180); 
            //�طʿ�
            $pdf->SetFillColor(200,230,255);
            //�ե��������
            $pdf->SetFont(GOTHIC,'', 6);
            $pdf->SetXY($left_margin+10, $posY+45);
            $pdf->Cell(260, 12,'', '1', '0', 'C','0');
            $pdf->SetXY($left_margin+10.4, $posY+45);
            $pdf->Cell(22, 12,'���', '0', '0', 'C','1');
            $pdf->Cell(52, 12,'����ǯ����', '0', '0', 'C','1');
            $pdf->Cell(90, 12,'�롼��', '0', '0', 'C','1');
            $pdf->Cell(25, 12,'����', '0', '0', 'C','1');
            $pdf->Cell(70, 12,'�š��á��֡���', '0', '0', 'C','1');

            if($photo_exists){
                $pdf->Image($photo,$left_margin+455, $posY+25,52);
            }

            //�ƥ����Ȥο�
            $pdf->SetTextColor(0,0,0); 
            //�ե��������
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+10.4, $posY+57);
            $pdf->Cell(22, 17.5,$trade_name, 'R', '0', 'C','0');
            $pdf->Cell(52, 17.5,$today, 'R', '0', 'C','0');
            $pdf->Cell(90, 17.5, $route, 'R', '0', 'L','0');
            $pdf->Cell(25, 17.5,$close_day, 'C', '0', 'C','0');
            $pdf->Cell(74.4, 17.5,$tel, '0', '0', 'L','0');

            //�ƥ����Ȥο�
            $pdf->SetTextColor(61,50,180); 
            $pdf->SetFont(GOTHIC,'B', 11);
            $pdf->SetXY($left_margin+273, $posY+10);
            $pdf->Cell(90, 12,'�Ρ�����������', 'B', '1', 'C','0');


            $pdf->SetFont(GOTHIC,'', 8);
            $pdf->SetXY($left_margin+544, $posY+217);
            $pdf->Cell(10, 10,'��', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+544, $posY+250);
            $pdf->Cell(10, 10,'��', '0', '1', 'C','0');

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
            $pdf->SetFillColor(29,0,120);
            $pdf->RoundedRect($left_margin+10, $posY+80, 575, 10, 5, 'FD',12);

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
            $pdf->Cell(66, 10,'��������������', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+518, $posY+80);
            $pdf->Cell(66.7, 10,'�¡���������', '0', '1', 'C','0');

            //�ƥ����Ȥο�
            $pdf->SetTextColor(0,0,0); 

            //��������
            $pdf->SetLineWidth(0.8);
            //�طʿ�
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+10, $posY+90, 575, 105, 5, 'FD',34);

            //��������
            $pdf->SetLineWidth(0.2);
            //�طʿ�
            $pdf->SetFillColor(200,230,255);
            $pdf->SetFont(GOTHIC,'', 7);

            //���ʥǡ����Կ�����
            $height = array('90','111','132','153','174');
            $h=0;
            for($x=0+(($page-1)*5);$x<($page*5);$x++){

                //aoyama-n 2009-09-16
                //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
                if($data_list[$x][52] === 't' || 
                   $trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����'){
                    $pdf->SetTextColor(255,0,16);
                }else{
                    $pdf->SetTextColor(0,0,0);
                }

                //�Ǹ�ιԤ�Ƚ��
                if($x==($page*5)-1){
                    //���ʥ�����
                    $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');  
                    }else{
                        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');  
                    }
                    //�����ӥ�/�����ƥ�̾
                    $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                    //̾��Ƚ��
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //�����ӥ��������ƥ�̾(ά��)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //�����ӥ�̾�Τ�
                        $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //�����ƥ�̾�Τ�(����̾��)
                        $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                    //���̻���Ƚ��
                    /*
                     * ����
                     *  ����            BɼNo.      ô����      ����
                     *  2006/11/09      02-059      kajioka-h   �켰���ꡢ���̤ʤ��ξ��˿�����ˡְ켰�פ�ɽ������褦���ѹ�
				 	 *	2009/06/18		����No.39	aizawa-m	5���ܡ����̤�"�켰"�ν��Ϥ򱦴����ѹ�
                     *
                     */
                    if($data_list[$x][21] == 't'){
                        //���̤����뤫�ġ��켰�˥����å���������
						//-- 2009/06/18 ����No.39 "C"��"R"���ѹ� 
                        $pdf->Cell(32, 21,number_format('�켰'), '1', '1', 'R','0');
                        //$pdf->Cell(32, 21,'�켰', '1', '1', 'C','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //���̤����뤫�İ켰�˥����å����ʤ�
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), '1', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(32, 21,'', '1', '1', 'C','0');                              
                    }

                    //ñ��
                    $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                    //ñ������Ƚ��
                    if($data_list[$x][16] != NULL){
                        //�����ѹ�
                        $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LTB', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');
                    }

                    //���
                    $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                    //��ۻ���Ƚ��
                    if($data_list[$x][17] != NULL){
                        //�����ѹ�
                        $pdf->Cell(62, 21,number_format($data_list[$x][17]), '1', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(62, 21,'', '1', '1', 'R','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                    $pdf->Cell(66, 21,'', '1', '1', 'C','0');

                    //�¤�
                    $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                    $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                    $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'T','L','0');


                }else{
                    //���ʥ�����
                    $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'LRT', '1', 'L','0');  
                    }else{
                        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');  
                    }
                    //�����ӥ�/�����ƥ�̾
                    $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                    //̾��Ƚ��
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //�����ӥ��������ƥ�̾(ά��)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], 'LRT', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //�����ӥ�̾�Τ�
                        $pdf->Cell(256, 21,$data_list[$x][12], 'LRT', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //�����ƥ�̾�Τ�(����̾��)
                        $pdf->Cell(256, 21,$data_list[$x][13], 'LRT', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                    /*
                     * ����
                     *  ����            BɼNo.      ô����      ����
                     *  2006/11/09      02-059      kajioka-h   �켰���ꡢ���̤ʤ��ξ��˿�����ˡְ켰�פ�ɽ������褦���ѹ�
                     *
                     */
                    //���̻���Ƚ��
                    if($data_list[$x][21] == 't'){
                        //���̤����뤫�ġ��켰�˥����å���������
                        $pdf->Cell(32, 21,'�켰', 'LRT', '1', 'R','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //���̤����뤫�İ켰�˥����å����ʤ�
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                    }

                    //ñ��
                    $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                    //ñ������Ƚ��
                    if($data_list[$x][16] != NULL){
                        //�����ѹ�
                        $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LT', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');
                    }

                    //���
                    $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                    //��ۻ���Ƚ��
                    if($data_list[$x][17] != NULL){
                        //�����ѹ�
                        $pdf->Cell(62, 21,number_format($data_list[$x][17]), 'LRT', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                    $pdf->Cell(66, 21,'', 'LRT', '1', 'C','0');

                    //�¤�
                    $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                    $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                    $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'LRT','L','0');
                }
                $h++;
            }

            //aoyama-n 2009-09-16
            //�����Υƥ����Ȥο�
            if($trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����' ||
               $intax_amount < 0 ){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0); 
            }

            //��������
            $pdf->SetLineWidth(0.8);
            //�طʿ�
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+452, $posY+195,55, 57, 5, 'FD',34);

            //��������
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+452, $posY+195);
            $pdf->Cell(54.7, 19,'', '1', '2', 'C','0');
            $pdf->Cell(54.7, 19,$tax_message2, '1', '2', 'C','0');
            $pdf->Cell(54.7, 19,'', '', '1', 'C','0');

            //��������
            $pdf->SetLineWidth(0.8);
            //�طʿ�
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+390, $posY+195, 62, 57, 5, 'FD',34);
            //��������
            $pdf->SetLineWidth(0.2);

            //��ȴ���
            //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
            $pdf->SetXY($left_margin+390, $posY+195);
            if($page==$page_count){
                $pdf->Cell(62, 19,number_format($sale_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
            }

            //�����ǳ�
            //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
            $pdf->SetXY($left_margin+390, $posY+214);
            if($page==$page_count){
                if($tax_disp_flg === true){
                    $pdf->Cell(62, 19,My_number_format($tax_amount), 'B', '1', 'R','0');
                }else{
                    $pdf->Cell(62, 19,'-', 'B', '1', 'C','0');
                } 
            }else{
                $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
            }

            //��׶��
            //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
            $pdf->SetXY($left_margin+390, $posY+233);
            if($page==$page_count){
                $pdf->Cell(62, 19,number_format($intax_amount), '0', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'', '0', '1', 'R','0');
            }
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
            $pdf->RoundedRect($left_margin+10, $posY+205, 260, 58, 5, 'FD',1234);

            //�ƥ����Ȥο�
            $pdf->SetTextColor(0,0,0); 

			/*
			 * ����
			 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
			 * ��2006/11/01��02-033��������suzuki-t����Ǽ�ʽ��μ��������������ꤷ���ͤ�ɽ�������褦�˽���
			 *
			*/
            //������
            $pdf->SetFont(GOTHIC,'', 6);
            $pdf->SetXY($left_margin+16, $posY+210);
            $pdf->MultiCell(254, 9,$s_memo[0][13], '0', '1', 'L','0');

            //�ƥ����Ȥο�
            $pdf->SetTextColor(61,50,180); 

            //�طʿ�
            $pdf->SetFillColor(200,230,255);
            $pdf->RoundedRect($left_margin+280, $posY+205, 56, 10, 3, 'FD',12);
            //��������
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+280, $posY+205);
            $pdf->Cell(56, 10,'�Ρ�������', '0', '1', 'C','0');
            //��������
            $pdf->SetLineWidth(0.8);
            //�طʿ�
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+280, $posY+215, 56, 48, 3, 'FD',34);

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

            $pdf->Line($left_margin+32.4,$posY+45,$left_margin+32.4,$posY+75);
            $pdf->Line($left_margin+84.4,$posY+45,$left_margin+84.4,$posY+75);
            $pdf->Line($left_margin+174.4,$posY+45,$left_margin+174.4,$posY+75);
            $pdf->Line($left_margin+199.4,$posY+45,$left_margin+199.4,$posY+75);

            //��
            $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+265,45,15);

            //�����������
            $pdf->SetLineWidth(0.1);
            $left_margin = 548;
            $posY = 505;
            for($i=14;$i<86;$i=$i+1.2){
                $pdf->Line($left_margin+$i, $posY+20, $left_margin+$i+0.5, $posY+20);
            }
            for($i=20;$i<96;$i=$i+1.2){
                $pdf->Line($left_margin+13, $posY+$i, $left_margin+13, $posY+$i+0.5);
            }
            for($i=14;$i<86;$i=$i+1.2){
                $pdf->Line($left_margin+$i, $posY+96, $left_margin+$i+0.5, $posY+96);
            }
            $left_margin = 621;
            for($i=20;$i<96;$i=$i+1.2){
                $pdf->Line($left_margin+13, $posY+$i, $left_margin+13, $posY+$i+0.5);
            }   

        }else{

            /****************************/
            //�������ɼ�������
            /****************************/
            //��������
            $pdf->SetLineWidth(0.8);

            //�������Ϥ��Ȥ����С��Ϥ��ʤ��Ȥ��ϡ����졼
            if($bill_flg == 't'){
                //�Ϥ�
                //���ο�
                $line_color = array(46,140,46);
                //�طʿ�
                $bg_color   = array(198,246,195);
            }else{
                //�Ϥ��ʤ�

/*
                //���ο�
                $line_color = array(80,80,80);
                //�طʿ�
                $bg_color   = array(221,221,221);
*/
                //���ο�
                $line_color = array(255,153,0);
                //�طʿ�
                $bg_color   = array(255,255,204);

            }

            $pdf->SetDrawColor($line_color[0],$line_color[1],$line_color[2]);
            $pdf->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);

            //�ե��������
            $pdf->SetFont(GOTHIC,'', 9);
            
            //����Ѵ�(��)
            $pdf->RoundedRect($left_margin+10, $posY+10, 260, 12, 5, 'FD',12);

                //�ƥ����Ȥο�
            $pdf->SetTextColor($line_color[0],$line_color[1],$line_color[2]);

            //�طʿ�
            $pdf->SetFillColor(255);

            //�ե��������
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+15, $posY);
            $pdf->Cell(100, 8,"�����ͥ����ɡ�$code", '', '1', 'L','0');
            $pdf->SetXY($left_margin+490, $posY);
            $pdf->Cell(100, 8,"��ɼ�ֹ桡".$slip.$branch_no, '', '1', 'R','0');

            //����Ѵ�(��)
            $pdf->SetFont(GOTHIC,'', 9);
            $pdf->RoundedRect($left_margin+10, $posY+22, 260,53, 5, 'FD',34);
            $pdf->SetXY($left_margin+10, $posY+10);
            $pdf->Cell(260, 12,'�桡���������ա����衡��̾', 'B', '1', 'C','0');
            //��������
            $pdf->SetLineWidth(0.2);
            //�ƥ����Ȥο�
            $pdf->SetTextColor(0,0,0);
            //�ե��������
            $pdf->SetFont(GOTHIC,'B', 8);
            $pdf->SetXY($left_margin+10, $posY+23);
            $pdf->Cell(240, 9,$client_name1, '0', '1', 'L','0');
            $pdf->SetXY($left_margin+10, $posY+34);
            $pdf->Cell(240, 9,$client_name2, '0', '1', 'L','0');

            //�طʿ�
            $pdf->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);

            //�ƥ����Ȥο�
            $pdf->SetTextColor($line_color[0],$line_color[1],$line_color[2]);

            //�ե��������
            $pdf->SetFont(GOTHIC,'', 6);
            $pdf->SetXY($left_margin+10, $posY+45);
            $pdf->Cell(260, 12,'', '1', '0', 'C','0');
            $pdf->SetXY($left_margin+10.4, $posY+45);
            $pdf->Cell(22, 12,'���', '0', '0', 'C','1');
            $pdf->Cell(52, 12,'����ǯ����', '0', '0', 'C','1');
            $pdf->Cell(90, 12,'�롼��', '0', '0', 'C','1');
            $pdf->Cell(25, 12,'����', '0', '0', 'C','1');
            $pdf->Cell(70, 12,'�š��á��֡���', '0', '0', 'C','1');

            if($photo_exists){
                $pdf->Image($photo,$left_margin+455, $posY+25,52);
            }

            //�ƥ����Ȥο�
            $pdf->SetTextColor(0,0,0); 
            //�ե��������
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+10.4, $posY+57);
            $pdf->Cell(22, 17.5,$trade_name, 'R', '0', 'C','0');
            $pdf->Cell(52, 17.5,$today, 'R', '0', 'C','0');
            $pdf->Cell(90, 17.5, $route, 'R', '0', 'L','0');
            $pdf->Cell(25, 17.5,$close_day, 'C', '0', 'C','0');
            $pdf->Cell(70.4, 17.5,$tel, '0', '0', 'L','0');
            
            //�ƥ����Ȥο�
            $pdf->SetTextColor($line_color[0],$line_color[1],$line_color[2]);

            $pdf->SetFont(GOTHIC,'B', 11);
            $pdf->SetXY($left_margin+273, $posY+10);
            $pdf->Cell(90, 12,'�������ᡡ����', 'B', '1', 'C','0');
            //��������
            $pdf->SetLineWidth(0.8);
            $pdf->RoundedRect($left_margin+285, $posY+30, 10, 45, 3, 'FD',14);

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
            $pdf->RoundedRect($left_margin+295, $posY+30, 65, 45, 3, 'FD',23);

            //��������
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont(GOTHIC,'B', 12);

            //�ƥ����Ȥο�
            //$pdf->SetTextColor(80,80,80);
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
            $pdf->SetFillColor($line_color[0],$line_color[1],$line_color[2]);
            //���ο�
            $pdf->SetDrawColor($line_color[0],$line_color[1],$line_color[2]);
            $pdf->RoundedRect($left_margin+10, $posY+80, 575, 10, 5, 'FD',12);

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
            $pdf->Cell(66, 10,'������������', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+518, $posY+80);
            $pdf->Cell(66.7, 10,'�¡���������', '0', '1', 'C','0');

            //�ƥ����Ȥο�
            $pdf->SetTextColor(0,0,0);

            //��������
            $pdf->SetLineWidth(0.8);
            //�طʿ�
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+10, $posY+90, 575, 105, 5, 'FD',34);

            //��������
            $pdf->SetLineWidth(0.2);

            //�طʿ�
            $pdf->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);

            $pdf->SetFont(GOTHIC,'', 7);

            //���ʥǡ����Կ�����
            $height = array('90','111','132','153','174');
            $h=0;
            for($x=0+(($page-1)*5);$x<($page*5);$x++){

                //aoyama-n 2009-09-16
                //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
                if($data_list[$x][52] === 't' || 
                   $trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����'){
                    $pdf->SetTextColor(255,0,16);
                }else{
                    $pdf->SetTextColor(0,0,0);
                }

                //�Ǹ�ιԤ�Ƚ��
                if($x==($page*5)-1){
                    //���ʥ�����
                    $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');  
                    }else{
                        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');  
                    }
                    //�����ӥ�/�����ƥ�̾
                    $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                    //̾��Ƚ��
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //�����ӥ��������ƥ�̾(ά��)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //�����ӥ�̾�Τ�
                        $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //�����ƥ�̾�Τ�(����̾��)
                        $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                    /*
                     * ����
                     *  ����            BɼNo.      ô����      ����
                     *  2006/11/09      02-059      kajioka-h   �켰���ꡢ���̤ʤ��ξ��˿�����ˡְ켰�פ�ɽ������褦���ѹ�
				 	 *	2009/06/18		����No.39	aizawa-m	5���ܡ����̤�"�켰"�ν��Ϥ򱦴����ѹ�
                     *
                     */
                    //���̻���Ƚ��
                    if($data_list[$x][21] == 't'){
                        //���̤����뤫�ġ��켰�˥����å���������
						//-- 2009/06/18 ����No.39 "C"��"R"���ѹ� 
                        $pdf->Cell(32, 21,'�켰', '1', '1', 'R','0');
                        //$pdf->Cell(32, 21,'�켰', '1', '1', 'C','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //���̤����뤫�İ켰�˥����å����ʤ�
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), '1', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(32, 21,'', '1', '1', 'C','0');                              
                    }

                    //ñ��
                    $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                    //ñ������Ƚ��
                    if($data_list[$x][16] != NULL){
                        //�����ѹ�
                        $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LTB', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');
                    }

                    //���
                    $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                    //��ۻ���Ƚ��
                    if($data_list[$x][17] != NULL){
                        //�����ѹ�
                        $pdf->Cell(62, 21,number_format($data_list[$x][17]), '1', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(62, 21,'', '1', '1', 'R','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                    $pdf->Cell(66, 21,'', '1', '1', 'C','0');

                    //�¤�
                    $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                    $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                    $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'T','L','0');

                }else{
                    //���ʥ�����
                    $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'LRT', '1', 'L','0');  
                    }else{
                        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');  
                    }
                    //�����ӥ�/�����ƥ�̾
                    $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                    //̾��Ƚ��
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //�����ӥ��������ƥ�̾(ά��)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], 'LRT', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //�����ӥ�̾�Τ�
                        $pdf->Cell(256, 21,$data_list[$x][12], 'LRT', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //�����ƥ�̾�Τ�(����̾��)
                        $pdf->Cell(256, 21,$data_list[$x][13], 'LRT', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                    /*
                     * ����
                     *  ����            BɼNo.      ô����      ����
                     *  2006/11/09      02-059      kajioka-h   �켰���ꡢ���̤ʤ��ξ��˿�����ˡְ켰�פ�ɽ������褦���ѹ�
                     *
                     */
                    //���̻���Ƚ��
                    if($data_list[$x][21] == 't'){
                        //���̤����뤫�ġ��켰�˥����å���������
                        $pdf->Cell(32, 21,'�켰', 'LRT', '1', 'R','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //���̤����뤫�İ켰�˥����å����ʤ�
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                    }

                    //ñ��
                    $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                    //ñ������Ƚ��
                    if($data_list[$x][16] != NULL){
                        //�����ѹ�
                        $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LT', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');
                    }

                    //���
                    $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                    //��ۻ���Ƚ��
                    if($data_list[$x][17] != NULL){
                        //�����ѹ�
                        $pdf->Cell(62, 21,number_format($data_list[$x][17]), 'LRT', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                    $pdf->Cell(66, 21,'', 'LRT', '1', 'C','0');

                    //�¤�
                    $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                    $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                    $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'LRT','L','0');
                }
                $h++;
            }

            //aoyama-n 2009-09-16
            //�����Υƥ����Ȥο�
            if($trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����' ||
               $intax_amount < 0 ){
                $pdf->SetTextColor(255,0,16); 
            }else{
                $pdf->SetTextColor(0,0,0); 
            }

            //��������
            $pdf->SetLineWidth(0.8);
            //�طʿ�
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+452, $posY+195,66, 57, 5, 'FD',34);
            //��������
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+452, $posY+195);
            $pdf->Cell(66, 19,'', '1', '1', 'C','0');
            $pdf->SetXY($left_margin+452, $posY+214);
            $pdf->Cell(66, 19,$tax_message2, '1', '1', 'C','0');
            $pdf->SetXY($left_margin+452, $posY+233);
            $pdf->Cell(66, 19,'', '', '1', 'C','0');


            //��������
            $pdf->SetLineWidth(0.8);
            //�طʿ�
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+390, $posY+195, 62, 57, 5, 'FD',34);
            //��������
            $pdf->SetLineWidth(0.2);

            //��ȴ���
            //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
            $pdf->SetXY($left_margin+390, $posY+195);
            if($page==$page_count){
                $pdf->Cell(62, 19,number_format($sale_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
            }

            //�����ǳ�
            //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
            $pdf->SetXY($left_margin+390, $posY+214);
            if($page==$page_count){
                if($tax_disp_flg === true){
                    $pdf->Cell(62, 19,My_number_format($tax_amount), 'B', '1', 'R','0');
                }else{
                    $pdf->Cell(62, 19,'-', 'B', '1', 'C','0');
                } 
            }else{
                $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
            }

            //��׶��
            //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
            $pdf->SetXY($left_margin+390, $posY+233);
            if($page==$page_count){
                $pdf->Cell(62, 19,number_format($intax_amount), '0', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'', '0', '1', 'R','0');
            }

            //�ƥ����Ȥο�
            $pdf->SetTextColor($line_color[0],$line_color[1],$line_color[2]);

            //�ե��������
            $pdf->SetFont(GOTHIC,'', 6.5);
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
            $pdf->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);

            $pdf->RoundedRect($left_margin+280,$posY+205 , 56, 10, 3, 'FD',12);
            //��������
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+280, $posY+205);
            $pdf->Cell(56, 10,'ô �� �� ̾', '0', '1', 'C','0');
            //��������
            $pdf->SetLineWidth(0.8);
            //�طʿ�
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+280, $posY+215, 56, 48, 3, 'FD',34);

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
            $pdf->SetDrawColor($line_color[0], $line_color[1], $line_color[2]);
            $pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
            $pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

            // ̤����ɽ��
            //aoyama-n 2009-09-16
            #if ($trade_name == "��" && $ar_balance_this != 0 && $ar_balance_this != null){
            if (($trade_name == '��' || $trade_name == '����' || $trade_name == '����') && 
                $ar_balance_this != 0 && $ar_balance_this != null){
                $pdf->SetLineWidth(0.2);
                $pdf->SetXY($left_margin+50, $posY+265);
                $pdf->Cell(0, 10, number_format($ar_balance_this).'�ߤ�̤����ȤʤäƤ���ޤ���', '0', '1', 'L','0');
            }

            //��
            $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+265,45,15);
            $pdf->Line($left_margin+32.4,$posY+45,$left_margin+32.4,$posY+75);
            $pdf->Line($left_margin+84.4,$posY+45,$left_margin+84.4,$posY+75);
            $pdf->Line($left_margin+174.4,$posY+45,$left_margin+174.4,$posY+75);
            $pdf->Line($left_margin+199.4,$posY+45,$left_margin+199.4,$posY+75);
        }

        /****************************/
        //Ǽ�ʽ���ɼ�������
        /****************************/
        $left_margin=50;
        $posY=635;

        //��������
        $pdf->SetLineWidth(0.8);
        //���ο�
        $pdf->SetDrawColor(17,136,255);
        //�طʿ�
        $pdf->SetFillColor(170,212,255);
        //����Ѵ�(��)
        $pdf->RoundedRect($left_margin+10, $posY+10, 260, 12, 5, 'FD',12);
        //�ƥ����Ȥο�
        $pdf->SetTextColor(17,136,255);
        //�طʿ�
        $pdf->SetFillColor(255);
        
        //�ե��������
        $pdf->SetFont(GOTHIC,'', 7);
        $pdf->SetXY($left_margin+15, $posY);
        $pdf->Cell(100, 8,"�����ͥ����ɡ�$code", '', '1', 'L','0');
        $pdf->SetXY($left_margin+490, $posY);
        $pdf->Cell(100, 8,"��ɼ�ֹ桡".$slip.$branch_no, '', '1', 'R','0');

        //����Ѵ�(��)
        //�ե��������
        $pdf->SetFont(GOTHIC,'', 9);
        $pdf->RoundedRect($left_margin+10, $posY+22, 260, 53, 5, 'FD',34);
        $pdf->SetXY($left_margin+10, $posY+10);
        $pdf->Cell(260, 12,'�桡���������ա����衡��̾', 'B', '1', 'C','0');

        //��������
        $pdf->SetLineWidth(0.2);
        //�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0);
        //�ե��������
        $pdf->SetFont(GOTHIC,'B', 8);
        $pdf->SetXY($left_margin+10, $posY+23);
        $pdf->Cell(240, 9,$client_name1, '0', '1', 'L','0');
        $pdf->SetXY($left_margin+10, $posY+34);
        $pdf->Cell(240, 9,$client_name2, '0', '1', 'L','0');
        //�ƥ����Ȥο�
        $pdf->SetTextColor(17,136,255);
        //�طʿ�
        $pdf->SetFillColor(170,212,255);

        //�ե��������
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+10, $posY+45);
        $pdf->Cell(260, 12,'', '1', '0', 'C','0');
        $pdf->SetXY($left_margin+10.4, $posY+45);
        $pdf->Cell(22, 12,'���', '0', '0', 'C','1');
        $pdf->Cell(52, 12,'����ǯ����', '0', '0', 'C','1');
        $pdf->Cell(90, 12,'�롼��', '0', '0', 'C','1');
        $pdf->Cell(25, 12,'����', '0', '0', 'C','1');
        $pdf->Cell(70, 12,'�š��á��֡���', '0', '0', 'C','1');

        if($photo_exists){
            $pdf->Image($photo,$left_margin+455, $posY+25,52);
        }
        //�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0); 
        //�ե��������
        $pdf->SetFont(GOTHIC,'', 7);
        $pdf->SetXY($left_margin+10.4, $posY+57);
        $pdf->Cell(22, 17.5,$trade_name, 'R', '0', 'C','0');
        $pdf->Cell(52, 17.5,$today, 'R', '0', 'C','0');
        $pdf->Cell(90, 17.5, $route, 'R', '0', 'L','0');
        $pdf->Cell(25, 17.5,$close_day, 'C', '0', 'C','0');
        $pdf->Cell(70.4, 17.5,$tel, '0', '0', 'L','0');
        
        //�ƥ����Ȥο�
        $pdf->SetTextColor(17,136,255);

        $pdf->SetFont(GOTHIC,'B', 11);
        $pdf->SetXY($left_margin+273, $posY+10);
        $pdf->Cell(90, 12,'Ǽ�����ʡ�����', 'B', '1', 'C','0');
        //��������
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+285, $posY+30, 10, 45, 3, 'FD',14);

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
        $pdf->RoundedRect($left_margin+295, $posY+30, 65, 45, 3, 'FD',23);

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
        $pdf->RoundedRect($left_margin+10, $posY+80, 575, 10, 5, 'FD',12);

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
        $pdf->Cell(66, 10,'��������������', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+518, $posY+80);
        $pdf->Cell(66.7, 10,'�¡���������', '0', '1', 'C','0');

        //�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0);

        //��������
        $pdf->SetLineWidth(0.8);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+10, $posY+90, 575, 105, 5, 'FD',34);

        //��������
        $pdf->SetLineWidth(0.2);
        //�طʿ�
        $pdf->SetFillColor(170,212,255);
        $pdf->SetFont(GOTHIC,'', 7);

        //���ʥǡ����Կ�����
        $height = array('90','111','132','153','174');
        $h=0;
        for($x=0+(($page-1)*5);$x<($page*5);$x++){

            //aoyama-n 2009-09-16
            //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
            if($data_list[$x][52] === 't' || 
               $trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����'){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0);
            }

            //�Ǹ�ιԤ�Ƚ��
            if($x==($page*5)-1){
                //���ʥ�����
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if ($data_list[$x][20] == 't'){
                    $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');  
                }else{
                    $pdf->Cell(40, 21,'', 'T', '1', 'L','0');  
                }
                //�����ӥ�/�����ƥ�̾
                $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                //̾��Ƚ��
                if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                    //�����ӥ��������ƥ�̾(ά��)
                    $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                    //�����ӥ�̾�Τ�
                    $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                    //�����ƥ�̾�Τ�(����̾��)
                    $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                }else{
                    //NULL
                    $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                }

                //����
                $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                /*
                 * ����
                 *  ����            BɼNo.      ô����      ����
                 *  2006/11/09      02-059      kajioka-h   �켰���ꡢ���̤ʤ��ξ��˿�����ˡְ켰�פ�ɽ������褦���ѹ�
				 *	2009/06/18		����No.39	aizawa-m	5���ܡ����̤�"�켰"�ν��Ϥ򱦴����ѹ�
                 *
                 */
                //���̻���Ƚ��
                if($data_list[$x][21] == 't'){
                    //���̤����뤫�ġ��켰�˥����å���������
					//-- 2009/06/18 ����No.39 "C"��"R"���ѹ�
                    $pdf->Cell(32, 21,'�켰', '1', '1', 'R','0');
                    //$pdf->Cell(32, 21,'�켰', '1', '1', 'C','0');
                }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                    //���̤����뤫�İ켰�˥����å����ʤ�
                    $pdf->Cell(32, 21,number_format($data_list[$x][15]), '1', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(32, 21,'', '1', '1', 'C','0');                              
                }

                //ñ��
                $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                //ñ������Ƚ��
                if($data_list[$x][16] != NULL){
                    //�����ѹ�
                    $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LTB', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');
                }

                //���
                $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                //��ۻ���Ƚ��
                if($data_list[$x][17] != NULL){
                    //�����ѹ�
                    $pdf->Cell(62, 21,number_format($data_list[$x][17]), '1', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(62, 21,'', '1', '1', 'R','0');
                }

                //����
                $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                $pdf->Cell(66, 21,'', '1', '1', 'C','0');

                //�¤�
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'T','L','0');

            }else{
                //���ʥ�����
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if ($data_list[$x][20] == 't'){
                    $pdf->Cell(40, 21,$data_list[$x][11], 'LRT', '1', 'L','0');  
                }else{
                    $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');  
                }
                //�����ӥ�/�����ƥ�̾
                $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                //̾��Ƚ��
                if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                    //�����ӥ��������ƥ�̾(ά��)
                    $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], 'LRT', '1', 'L','0');
                }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                    //�����ӥ�̾�Τ�
                    $pdf->Cell(256, 21,$data_list[$x][12], 'LRT', '1', 'L','0');
                }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                    //�����ƥ�̾�Τ�(����̾��)
                    $pdf->Cell(256, 21,$data_list[$x][13], 'LRT', '1', 'L','0');
                }else{
                    //NULL
                    $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');
                }

                //����
                $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                /*
                 * ����
                 *  ����            BɼNo.      ô����      ����
                 *  2006/11/09      02-059      kajioka-h   �켰���ꡢ���̤ʤ��ξ��˿�����ˡְ켰�פ�ɽ������褦���ѹ�
                 *
                 */
                //���̻���Ƚ��
                if($data_list[$x][21] == 't'){
                    //���̤����뤫�ġ��켰�˥����å���������
                    $pdf->Cell(32, 21,'�켰', 'LRT', '1', 'R','0');
                }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                    //���̤����뤫�İ켰�˥����å����ʤ�
                    $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                }

                //ñ��
                $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                //ñ������Ƚ��
                if($data_list[$x][16] != NULL){
                    //�����ѹ�
                    $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LT', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');
                }

                //���
                $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                //��ۻ���Ƚ��
                if($data_list[$x][17] != NULL){
                    //�����ѹ�
                    $pdf->Cell(62, 21,number_format($data_list[$x][17]), 'LRT', '1', 'R','0');
                }else{
                    //��ɽ��
                    $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');
                }

                //����
                $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                $pdf->Cell(66, 21,'', 'LRT', '1', 'C','0');

                //�¤�
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'LRT','L','0');
            }
            $h++;
        }

        //aoyama-n 2009-09-16
        //�����Υƥ����Ȥο�
        if($trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����' ||
           $intax_amount < 0 ){
            $pdf->SetTextColor(255,0,16);
        }else{
            $pdf->SetTextColor(0,0,0); 
        }

        //��������
        $pdf->SetLineWidth(0.8);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+452, $posY+195,66, 57, 5, 'FD',34);

        //��������
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+452, $posY+195);
        $pdf->Cell(66, 19,'', '1', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+214);
        $pdf->Cell(66, 19,$tax_message2, '1', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+233);
        $pdf->Cell(66, 19,'', '', '1', 'C','0');


        //��������
        $pdf->SetLineWidth(0.8);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+390, $posY+195, 62, 57, 5, 'FD',34);
        //��������
        $pdf->SetLineWidth(0.2);

        //��ȴ���
        //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
        $pdf->SetXY($left_margin+390, $posY+195);
        if($page==$page_count){
            $pdf->Cell(62, 19,number_format($sale_amount), 'B', '1', 'R','0');
        }else{
            $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
        }

        //�����ǳ�
        //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
        $pdf->SetXY($left_margin+390, $posY+214);
        if($page==$page_count){
            if($tax_disp_flg === true){
                $pdf->Cell(62, 19,My_number_format($tax_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'-', 'B', '1', 'C','0');
            } 
        }else{
            $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
        }

        //��׶��
        //��ɼ��ʣ���礢���硢�Ǹ�Υڡ����˹�׶��ɽ��
        $pdf->SetXY($left_margin+390, $posY+233);
        if($page==$page_count){
            $pdf->Cell(62, 19,number_format($intax_amount), '0', '1', 'R','0');
        }else{
            $pdf->Cell(62, 19,'', '0', '1', 'R','0');
        }

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
        $pdf->RoundedRect($left_margin+10, $posY+205, 260, 58, 5, 'FD',1234);

        //�ƥ����Ȥο�
        $pdf->SetTextColor(0,0,0);


		/*
		 * ����
		 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
		 * ��2006/11/01��02-033��������suzuki-t����Ǽ�ʽ��μ��������������ꤷ���ͤ�ɽ�������褦�˽���
		 *
		*/
        //������
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+16, $posY+210);
        $pdf->MultiCell(254, 9,$s_memo[0][12], '0', '1', 'L','0');

        //�ƥ����Ȥο�
        $pdf->SetTextColor(17,136,255);

        //�طʿ�
        $pdf->SetFillColor(170,212,255);
        $pdf->RoundedRect($left_margin+280, $posY+205, 56, 10, 3, 'FD',12);
        //��������
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+280, $posY+205);
        $pdf->Cell(56, 10,'ô �� �� ̾', '0', '1', 'C','0');
        //��������
        $pdf->SetLineWidth(0.8);
        //�طʿ�
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+280, $posY+215, 56, 48, 3, 'FD',34);

        $pdf->SetDrawColor(255);
        $pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

        //��������
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+340, $posY+254);
        $pdf->Cell(250, 10,'���٤��꤬�Ȥ��������ޤ����嵭���̤�Ǽ���פ��ޤ��ΤǸ溺����������', '0', '1', 'R','0');

        $pdf->SetLineWidth(0.2);
        $pdf->Line($left_margin+50, $posY+81,$left_margin+50,$posY+89);
        $pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
        $pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
        $pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
        $pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
        $pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

        //���ο�
        $pdf->SetDrawColor(17,136,255);
        $pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
        $pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);
        $pdf->Line($left_margin+32.4, $posY+45,$left_margin+32.4,$posY+75);
        $pdf->Line($left_margin+84.4, $posY+45,$left_margin+84.4,$posY+75);
        $pdf->Line($left_margin+174.4,$posY+45,$left_margin+174.4,$posY+75);
        $pdf->Line($left_margin+199.4,$posY+45,$left_margin+199.4,$posY+75);

        // ̤����ɽ��
        //aoyama-n 2009-09-16
        #if ($trade_name == "��" && $ar_balance_this != 0 && $ar_balance_this != null){
        if (($trade_name == '��' || $trade_name == '����' || $trade_name == '����') && 
            $ar_balance_this != 0 && $ar_balance_this != null){
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+50, $posY+265);
            $pdf->Cell(0, 10, number_format($ar_balance_this).'�ߤ�̤����ȤʤäƤ���ޤ���', '0', '1', 'L','0');
        }

        //��
        $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+265,45,15);


        //�вٰ����
        if($more_check_array[$s] === true){
            $pdf->AddPage();

            //Y��ɸ
            $ary_posY = array(11, 315, 625);

            //��ɼ̾
            $slip_name = array("�С��١��ơ��⡡��",
                                "�С��١��ơ��⡡��ʹ���", 
                                "�С��١��ء�������");

            //���ο�
            $line_color = null;
            $line_color = array(array(238,0,14),
                                array(153,102,0),
                                array(129,53,255)
                            );

            //�ƥ����Ȥο�
            $text_color = null;
            $text_color = array(array(255,0,16),
                                array(153,102,0),
                                array(129,53,255)
                            );

            //�طʿ�
            $bg_color   = null;
            $bg_color   = array(array(255,204,207),
                                array(240,230,140),
                                array(238,227,255)
                            );

            for($i = 0; $i < 3; $i++){

                $left_margin=50;
                $posY= $ary_posY[$i];

                /****************************/
                //���ʽвٰ����
                /****************************/
                //��������
                $pdf->SetLineWidth(0.2);
                //���ο�
                $pdf->SetDrawColor($line_color[$i][0],$line_color[$i][1],$line_color[$i][2]);
                //�ե��������
                $pdf->SetFont(GOTHIC,'', 9);
                //�ƥ����Ȥο�
                $pdf->SetTextColor($text_color[$i][0],$text_color[$i][1],$text_color[$i][2]);
                //�طʿ�
                $pdf->SetFillColor($bg_color[$i][0],$bg_color[$i][1],$bg_color[$i][2]);

                $pdf->SetFont(GOTHIC,'', 8);
                $pdf->SetXY($left_margin+10, $posY+10);
                $pdf->Cell(60, 12,'ľ���襳����No.', '0', '1', 'C','0');
                $pdf->SetXY($left_margin+70, $posY+10);
                $pdf->Cell(100, 12,$direct["cd"], '0', '1', 'L','0');

                //�ƥ����Ȥο�
                $pdf->SetTextColor(0,0,0);

                //͹���ֹ�
                $pdf->SetFont(GOTHIC,'', 9.5);
                $pdf->SetXY($left_margin+10, $posY+25);
                $pdf->Cell(15, 12,'��', '0', '1', 'L','0');
                $pdf->SetXY($left_margin+25, $posY+25);
                $pdf->Cell(50, 12,$direct["post_no1"]."-".$direct["post_no2"], '0', '1', 'L','0');

                //���ꡦ��̾
                $pdf->SetFont(GOTHIC,'', 8);
                $pdf->SetXY($left_margin+15, $posY+38);
                $pdf->Cell(50, 12,$direct["address1"], '0', '1', 'L','0');
                $pdf->SetXY($left_margin+15, $posY+50);
                $pdf->Cell(50, 12,$direct["address2"], '0', '1', 'L','0');
                $pdf->SetXY($left_margin+15, $posY+62);
                $pdf->Cell(50, 12,$direct["address3"], '0', '1', 'L','0');
                $pdf->SetFont(GOTHIC,'', 11);
                $pdf->SetXY($left_margin+20, $posY+77);
                $pdf->Cell(50, 12,$direct["name"], '0', '1', 'L','0');
                $pdf->SetXY($left_margin+20, $posY+92);
                $pdf->Cell(50, 12,$direct["name2"], '0', '1', 'L','0');

                //�ƥ����Ȥο�
                $pdf->SetTextColor($text_color[$i][0],$text_color[$i][1],$text_color[$i][2]);

                $pdf->SetFont(GOTHIC,'', 10);
                $pdf->SetXY($left_margin+214, $posY+5);
                $pdf->Cell(160, 15,$slip_name[$i], '1', '1', 'C','1');

                $pdf->SetFont(GOTHIC,'', 8);

                $sale_day = explode("-", $data_list[$p][5]);
                $pdf->SetXY($left_margin+392, $posY+7);
                $pdf->Cell(20, 12,$sale_day[0], '0', '1', 'C','0');
                $pdf->SetXY($left_margin+412, $posY+7);
                $pdf->Cell(12, 12,'ǯ', '0', '1', 'C','0');
                $pdf->SetXY($left_margin+424, $posY+7);
                $pdf->Cell(12, 12,$sale_day[1], '0', '1', 'C','0');
                $pdf->SetXY($left_margin+436, $posY+7);
                $pdf->Cell(12, 12,'��', '0', '1', 'C','0');
                $pdf->SetXY($left_margin+448, $posY+7);
                $pdf->Cell(12, 12,$sale_day[2], '0', '1', 'C','0');
                $pdf->SetXY($left_margin+460, $posY+7);
                $pdf->Cell(12, 12,'��', '0', '1', 'C','0');
                $pdf->SetXY($left_margin+487, $posY+7);
                $pdf->Cell(33, 12,'��ɼNo.', '0', '1', 'R','0');
                $pdf->SetXY($left_margin+520, $posY+7);
                $pdf->Cell(50, 12,$slip.$branch_no, '0', '1', 'L','0');

                if($photo_exists){
                     $pdf->Image($photo,$left_margin+455, $posY+30,52);
                }

                //�ƥ����Ȥο�
                //��������
                $pdf->SetLineWidth(0.2);
                $pdf->SetFont(GOTHIC,'B', 12);
                //�ƥ����Ȥο�
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
                $pdf->SetXY($left_margin+415, $posY+19);
                $pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
                $pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
                $pdf->SetXY($left_margin+465, $posY+19);
                $pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

                $pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
                $pdf->SetXY($left_margin+415, $posY+21+$s_memo[0][6]);
                $pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
                $pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
                $pdf->SetXY($left_margin+465, $posY+21+$s_memo[0][6]);
                $pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

                $pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
                $pdf->SetXY($left_margin+387, $posY+22+$s_memo[0][6]+$s_memo[0][8]);
                $pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

                //�ƥ����Ȥο�
                $pdf->SetTextColor($text_color[$i][0], $text_color[$i][1], $text_color[$i][2]);

                $pdf->SetFont(GOTHIC,'', 8);
                $pdf->SetXY($left_margin+332, $posY+90);
                $pdf->Cell(40, 12,'ô���� : ', '0', '1', 'C','0');

               //�ƥ����Ȥο�
                $pdf->SetTextColor(0,0,0);

                $pdf->SetFont(GOTHIC,'', 10);
                $pdf->SetXY($left_margin+367, $posY+90);
                $pdf->Cell(188, 12,$route, 'B', '1', 'L','0');

                //�ƥ����Ȥο�
                $pdf->SetTextColor($text_color[$i][0], $text_color[$i][1], $text_color[$i][2]); 
                $pdf->SetFont(GOTHIC,'', 7);
                $pdf->SetXY($left_margin+376, $posY+109);
                $pdf->Cell(150, 10,'���٤��꤬�Ȥ��������ޤ����������̤�в��פ��ޤ�����', '0', '1', 'R','0');

                //��������
                $pdf->SetLineWidth(0.8);
                $pdf->RoundedRect($left_margin+10, $posY+120, 575, 115, 5, 'FD',1234);

                //�ե��������
                $pdf->SetLineWidth(0.2);
                $pdf->RoundedRect($left_margin+10, $posY+120, 575, 10, 5, 'FD',12);
                $pdf->SetXY($left_margin+10, $posY+120);
                $pdf->Cell(40, 10,'���ʥ�����', 'R', '1', 'C','0');
                $pdf->SetXY($left_margin+50, $posY+120);
                $pdf->Cell(256, 10,'�� �� �� ����/���� �� �� �� ̾', 'R', '1', 'C','0');
                $pdf->SetXY($left_margin+306, $posY+120);
                $pdf->Cell(32, 10,'��������', 'R', '1', 'C','0');
                $pdf->SetXY($left_margin+338, $posY+120);
                $pdf->Cell(30, 10,'ñ����', 'R', '1', 'C','0');
                $pdf->SetXY($left_margin+367, $posY+120);
                $pdf->Cell(220, 10,'����������������', '0', '1', 'C','0');

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

                for($x=0+(($page-1)*5);$x<($page*5);$x++){

                    //aoyama-n 2009-09-16
                    //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
                    if($data_list[$x][52] === 't' || 
                       $trade_name == '����' || $trade_name == '�ݰ�' || $trade_name == '����' || $trade_name == '����'){
                        $pdf->SetTextColor(255,0,16);
                    }else{
                        $pdf->SetTextColor(0,0,0);
                    }

                    //���ʥ�����
                    $pdf->SetXY($left_margin+10, $posY+$height[$x]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');
                    }else{
                        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');
                    }

                    //�����ӥ�/�����ƥ�̾
                    $pdf->SetXY($left_margin+50, $posY+$height[$x]);
                    //̾��Ƚ��
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //�����ӥ��������ƥ�̾(ά��)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //�����ӥ�̾�Τ�
                        $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //�����ƥ�̾�Τ�(����̾��)
                        $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                    }

                    //����
                    $pdf->SetXY($left_margin+306, $posY+$height[$x]);
                    //���̻���Ƚ��
                    if($data_list[$x][21] == 't'){
                        //���̤����뤫�ġ��켰�˥����å���������
                        $pdf->Cell(32, 21,'�켰', 'LRT', '1', 'R','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //���̤����뤫�İ켰�˥����å����ʤ�
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                    }else{
                        //��ɽ��
                        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                    }
 
                    //ñ��
                    $pdf->SetXY($left_margin+338, $posY+$height[$x]);
                    $pdf->Cell(30, 21,$data_list[$x][33], '1', '1', 'C','0');
                }

                $pdf->SetFont(GOTHIC,'', 8);

                $pdf->SetXY($left_margin+47, $posY+247);

                //�ƥ����Ȥο�
                $pdf->SetTextColor($text_color[$i][0],$text_color[$i][1],$text_color[$i][2]);

                $pdf->Cell(40, 12,'Ŧ ��', '0', '1', 'L','0');
                $pdf->SetTextColor(0,0,0);
                $pdf->SetXY($left_margin+75, $posY+247);
                $pdf->Cell(40, 12,$direct["client_name"], '0', '1', 'L','0');
                $pdf->SetTextColor($text_color[$i][0],$text_color[$i][1],$text_color[$i][2]);
                $pdf->Line($left_margin+78,$posY+259,$left_margin+255,$posY+259);

                $pdf->SetXY($left_margin+525, $posY+238);
                $pdf->Cell(33, 28,'', '1', '1', 'C','0');
                $pdf->SetXY($left_margin+558, $posY+238);
                $pdf->Cell(33, 28,'', '1', '1', 'C','0');

                //��
                $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+270,45,15);
            }
        }
    }
}

//$pdf->Output();
$pdf->Output(mb_convert_encoding("�����ɼ".date("Ymd").".pdf", "SJIS", "EUC"),"D");
?>
