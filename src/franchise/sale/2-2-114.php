<?php
/**
 * ���������PDF��
 *
 *
 * �ѹ�����
 *    2006/09/06 (kaji)
 *      �������ɼ�����֤��оݤˤ��ʤ�
 *    2006/10/04 (kaji)
 *      ��ľ�İʳ���FC�Ѥ��ֹ����֥ơ��֥뤫����ɼ�ֹ����
 *    2006/11/02 (suzuki)
 *      �����˺�����줿��ɼ�ξ�硢���顼ɽ��
 *
 */

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/12/16��scl-0088����  watanabe-k��FC�������ɼ�ˤϺ��ֽ������¹Ԥ���ʤ��褦�˽���
 * ��2007/01/25��        ����  watanabe-k����ɼ��15��ɽ������褦�˽���
 * ��2007/01/25��        ����  watanabe-k���������ʤ�8��4��˽���
 * ��2007/01/25��        ����  watanabe-k���������򱦲���ɽ��
 * ��2007/01/25��        ����  watanabe-k����¦�˥ե�����󥰥��ڡ�����ɽ��
 * ��2007/01/26��        ����  ��        ���ư����ܥ������ʬ�����դäݤ��ä��Τ���
 * ��2007/01/30��        ����  watanabe-k��ȯ�Է���������ǽ���ɲäˤ�꽤��
 * ��2007/02/07��       ������ watanabe-k��ľ�İʳ��ξ��������ɼ�ξ����о�狼��ϳ��Ƥ����Х��ν���
 * ��2007/03/12��       ������ watanabe-k  ���ɽ�����ѹ�
 * ��2007/03/19��       ������ watanabe-k  ������̾��2�ʤ�ɽ�� 
 * ��2007/03/22��       ������ watanabe-k  �����ɼ��ɽ�����ʤ��褦�˽��� 
 * ��2007/03/23��       ������ watanabe-k  ����ޥ�����Ʊ�������� 
 * ��2007/04/24��       ������ watanabe-k  ��Ԥζ�ۤ���Ф��륫�����ѹ� 
 * ��2007/05/03��       ������ watanabe-k  ��ϩ�ǥ�����
 * ��2007/05/11��       ������ watanabe-k  ���ν������󤬽Ф�褦�˽��� 
 * ��2007/05/14��       ������ watanabe-k  ȯ������Ĥ��褦�˽��� 
 * ��2007/05/15��       ������ watanabe-k  ȯ��ID��Ĥ��褦��ɽ�� 
 * ��2007/07/31��       ������ watanabe-k  �ѻ�����꤭��ʤ�����ޡ�������� 
 * ��2007/09/18��       ������ watanabe-k  ��ɼȯ�Է����ϼ���إå��ǤϤʤ�������ޥ����򻲾Ȥ���褦�˽��� 
 * ��2008/05/31��       ������ watanabe-k  �и��ʥꥹ�Ȥ�ɽ�����뾦�ʤϼ���ǡ����򻲾Ȥ���褦�˽��� 
 * ��2008/07/19��       ������ watanabe-k  �����ƥ�Ⱦ����ʤ��̡�����Ф���褦�˽���
 */



require_once("ENV_local.php");
require_once(INCLUDE_DIR."daily_slip.inc"); //���������Ѵؿ�

$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/***************************/
//�����ѿ�����
/***************************/
//���å����
$shop_id            = $_SESSION["client_id"];           //�����ID
$group_kind         = $_SESSION["group_kind"];          //���롼�׼���

//POST
$send_day           = $_POST["hdn_send_day"];           //������
$staff_id           = $_POST["hdn_staff_id"];           //�����å�ID1
$act_flg            = $_POST["hdn_act_flg"];            //��Զ�ʬ
$daily_slip_id      = $_POST["hdn_daily_slip_id"];      //��������ID
$imp_slip_id        = $_POST["hdn_imp_slip_id"];      //��������ID
$button_value       = $_POST["form_hdn_submit"];      //�ܥ���value

//�ץ�ӥ塼���ϥե饰
$no_data_flg        = ($_GET["format"] == "true")? true : false;

/***************************/
//���顼�����å�
/***************************/
//�����������¦�ǰ�Ĥ�����å�����Ƥ��ʤ����ϥ��顼
if($button_value == '��������ȯ��'){
    $slipout_check      = $_POST["form_slipout_check"];

}elseif($button_value == '���ơ�ȯ���ԡ�'){
    $slipout_check      = $_POST["form_reslipout_check"];

}elseif($button_value == '������ȯ��'){
    $slipout_check   = $_POST["form_preslipout_check"];
}

if(count($slipout_check) == 0 && $no_data_flg === false){
    $check_err = "��ɼ�����򤷤Ʋ�������";
    $err_flg = true;
}

/***************************/
//�����ֹ�ȯ��
/***************************/
Db_Query($db_con, "BEGIN;");

$slipout_check_key  = @array_keys($slipout_check);      //����������������å�
$re_print_flg = false;                                  //�ư����ܥ�����ɽ���ե饰

for($i = 0; $i < count($slipout_check); $i++){
    //���򤵤줿����������ɼ����ɼ�ֹ����֤���
    //�����Ȥʤ����ID�����

	//�����ɼ
    if($act_flg[$slipout_check_key[$i]] == '��' && $group_kind == '2'){
        $sql  = "SELECT\n";
        $sql .= "   aord_id,\n";
        $sql .= "   ord_no, \n";
        $sql .= "   '', \n";
        $sql .= "   daily_slip_id ";
        $sql .= "FROM\n";
        $sql .= "    t_aorder_h\n";
        $sql .= "WHERE\n";
        $sql .= "   aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].")";
        $sql .= "   AND ";
        $sql .= "    del_flg = false \n";

        $sql .= "ORDER BY\n";
        $sql .= "    route,\n";
        $sql .= "    client_cd1,\n";
        $sql .= "    client_cd2, \n";
        $sql .= "    aord_id \n";

        $sql .= ";\n";

	//�̾���ɼ
    }else{
        $sql  = "SELECT\n";
        $sql .= "   t_aorder_h.aord_id, \n";
        $sql .= "   t_aorder_h.ord_no, \n";
        $sql .= "   t_aorder_h.contract_div, \n";
        $sql .= "   daily_slip_id ";
        $sql .= "FROM\n";
        $sql .= "   t_aorder_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_aorder_staff\n";
        $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_staff.staff_div = 0 \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_staff.staff_id = ".$staff_id[$slipout_check_key[$i]]." \n";

        $sql .= "       INNER JOIN\n";
        $sql .= "   t_staff\n";
        $sql .= "   ON t_aorder_staff.staff_id = t_staff.staff_id\n";

        $sql .= "WHERE\n";

        $sql .= "   t_aorder_h.aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].") ";

        $sql .= "   AND ";
        $sql .= "   del_flg = false ";

        //FC¦�������ɼ���ֹ�Ͽ���ʤ���
        $sql .= "    AND \n";
        $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().")" : " (shop_id = $shop_id OR act_id = $shop_id)\n";

        $sql .= "ORDER BY\n";
        $sql .= "   t_aorder_h.route,\n";
        $sql .= "   t_aorder_h.client_cd1,\n";
        $sql .= "   t_aorder_h.client_cd2, \n";
        $sql .= "   t_aorder_h.aord_id \n";
        $sql .= ";\n";
    }
    $res = Db_Query($db_con, $sql);
    $res_num = pg_num_rows($res);

	/*
	* ����
	* �����ա�������BɼNo.��������ô���ԡ��������ơ�
	* ��2006/11/02��02-006��������suzuki-t��  ������줿��ɼ�κݤ˥��顼ɽ��
	*/
	//���˺�����줿��ɼ��Ƚ��
	if($res_num == 0){
	    $check_err = "��������ɼ���������Ƥ��ޤ���";
	    $err_flg = true;
		Db_Query($db_con, "ROLLBACK;");
		$re_print_flg = true;//�ư����ܥ�����ɽ���ե饰
		break;
	}

    //��������ȯ�ԥܥ��󤬲������줿���Τ���ɼ�ֹ������
    if($button_value == '��������ȯ��'){

        //��������ID�����
        $max_id = Get_Daily_Slip_Id($db_con);

        //ID�μ����˼��Ԥ������
        if($max_id === false){
            $err_flg = true;
            $duplicate_err = "��������ΰ�����Ʊ���˹Ԥʤ�줿���ᡢ<br>��ɼ�ֹ�����֤˼��Ԥ��ޤ�����";
            $duplicate_flg = true;
        }

        for($j = 0; $j < $res_num; $j++){

            $aord_id = pg_fetch_result($res, $j,0);
            $aord_no = pg_fetch_result($res, $j,1);
            $contract_div = @pg_fetch_result($res, $j,2);

            //��Ԥξ�����ɼ�֤����դ�Ԥʤ�ʤ�
            if($group_kind != "2" && $contract_div == "2"){
                //PDF�ǡ�����л��ˤ��褦
                $daily_slip_id[$slipout_check_key[$i]] = @pg_fetch_result($res, $j,3);
                continue;
            //��ɼ�ֹ椬�ʤ�����������
            }elseif($aord_no == null){

                //PDF�ǡ�����л��ˤ��褦
                $daily_slip_id[$slipout_check_key[$i]] = $max_id;

                //ľ�Ĥξ��
                //�����ֹ�����
                if($group_kind == '2'){
                    $sql  = "SELECT";
                    $sql .= "   MAX(ord_no) ";
                    $sql .= "FROM";
                    $sql .= "   t_aorder_no_serial";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);

                    $order_no = pg_fetch_result($result, 0 ,0);
                    $order_no = $order_no +1;
                    $order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                    //�����ֹ���Ͽ����
                    $sql  = "INSERT INTO t_aorder_no_serial (\n";
                    $sql .= "   ord_no\n";
                    $sql .= ")VALUES(\n";
                    $sql .= "   '$order_no'\n";
                    $sql .= ");\n";

                    $result = Db_Query($db_con, $sql);

                    if($result === false){
                        $err_message = pg_last_error();
                        $err_format = "t_aorder_no_serial_pkey";
                        $err_flg = true;
                        Db_Query($db_con, "ROLLBACK;");

                        if(strstr($err_message, $err_format) != false){
                            $duplicate_err = "��������ΰ�����Ʊ���˹Ԥʤ�줿���ᡢ<br>��ɼ�ֹ�����֤˼��Ԥ��ޤ�����";
                            $duplicate_flg = true;
                        }else{
                            exit;
                        }
                    }
                //ľ�İʳ��ξ��ϼ���إå������ֹ����
                //�ǤϤʤ���FC�����ֹ����֥ơ��֥뤫���ֹ����(kaji)
                }else{
                    $sql  = "SELECT \n";
                    $sql .= "   MAX(ord_no) \n";
                    $sql .= "FROM \n";
                    $sql .= "   t_aorder_no_serial_fc \n";
                    $sql .= "WHERE \n";
                    $sql .= "   shop_id = $shop_id \n";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);

                    $order_no = pg_fetch_result($result, 0 ,0);
                    $order_no = $order_no +1;
                    $order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                    //�����ֹ���Ͽ����
                    $sql  = "INSERT INTO t_aorder_no_serial_fc ( \n";
                    $sql .= "    ord_no, \n";
                    $sql .= "    shop_id \n";
                    $sql .= ") VALUES ( \n";
                    $sql .= "   '$order_no', \n";
                    $sql .= "    $shop_id \n";
                    $sql .= ");\n";

                    $result = Db_Query($db_con, $sql);

                    if($result === false){
                        $err_message = pg_last_error();
                        $err_format = "t_aorder_no_serial_fc_pkey";
                        $err_flg = true;
                        Db_Query($db_con, "ROLLBACK;");

                        if(strstr($err_message, $err_format) != false){
                            $duplicate_err = "��������ΰ�����Ʊ���˹Ԥʤ�줿���ᡢ<br>��ɼ�ֹ�����֤˼��Ԥ��ޤ�����";
                            $duplicate_flg = true;
                        }else{
                            exit;
                        }
                    }
                }

                if($duplicate_flg != true){
                    //��ɼ�ֹ�ˡܣ������ͤ���Ͽ
                    $sql  = "UPDATE ";
                    $sql .= "   t_aorder_h ";
                    $sql .= "SET";
                    $sql .= "   ord_no = '$order_no', \n";
                    $sql .= "   daily_slip_out_day = NOW(), ";
                    $sql .= "   daily_slip_id = $max_id ";
                    $sql .= "WHERE\n";
                    $sql .= "   aord_id = $aord_id\n";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);
                    //Ʊ����ɼ��Ʊ���˺��ֽ������¹Ԥ��줿��票�顼
                    if($result === false){
                        $err_message = pg_last_error();
                        $err_format = "t_aorder_h_ord_no_key";
                        $err_flg = true;
                        Db_Query($db_con, "ROLLBACK;");

                        if(strstr($err_message, $err_format) != false){
                            $duplicate_err = "��������ΰ�����Ʊ���˹Ԥʤ�줿���ᡢ<br>��ɼ�ֹ�����֤˼��Ԥ��ޤ�����";
                        }else{
                            exit;
                        }
                    }
                }
            }else{
                //PDF�ǡ�����л��ˤ��褦
                $daily_slip_id[$slipout_check_key[$i]] = @pg_fetch_result($res, $j,3);
            }
        }
    //��ȯ�ԥܥ��󤬲������줿���
    }elseif($button_value == '���ơ�ȯ���ԡ�'){
        //��ȯ��������ɼ���ɲä��줿��票�顼��å�����ɽ��
        for($j = 0; $j < $res_num; $j++){
            $aord_no = pg_fetch_result($res, $j,1);
            if($aord_no == null){
                $check_err = "��ɼ���������ɲä��줿���ᡢ�������֤��Ʋ�������";
	            $err_flg = true;
		        Db_Query($db_con, "ROLLBACK;");
		        $re_print_flg = true;           //�ư����ܥ�����ɽ���ե饰
                break;
            }
        }
    }else{
        for($j = 0; $j < $res_num; $j++){
            
            //PDF�ǡ�����л��ˤ��褦
            $daily_slip_id[$slipout_check_key[$i]] = @pg_fetch_result($res, $j,3);
        }
    }
}
Db_Query($db_con, "COMMIT;");

//���顼�ե饰��true�ξ��
//����ɼ�ֹ椬��ʣ�������
//�оݤȤʤ뽸���������򤵤�Ƥ��ʤ��ä�����
//�оݤ���ɼ��������줿����
if($err_flg == true && $no_data_flg === false){
    //���󥹥�������
    $form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

    $form->addElement("button","form_close_button", "�Ĥ���", "OnClick=\"window.close()\"");
    //�����å������ͤ�Ĥ�
    for($i = 0; $i < count($slipout_check); $i++){
        $form->addElement("hidden", "form_slipout_check[$slipout_check_key[$i]]");
        $form->addElement("hidden", "hdn_send_day[$slipout_check_key[$i]]");
        $form->addElement("hidden", "hdn_staff_id[$slipout_check_key[$i]]");
        $form->addElement("hidden", "hdn_act_flg[$slipout_check_key[$i]]");

        $set_data["form_slipout_check"][$slipout_check_key[$i]] = '1';
        $set_data["hdn_send_day"][$slipout_check_key[$i]] = $send_day[$slipout_check_key[$i]];
        $set_data["hdn_staff_id"][$slipout_check_key[$i]] = $staff_id[$slipout_check_key[$i]];
        $set_data["hdn_act_flg"][$slipout_check_key[$i]]  = $act_flg[$slipout_check_key[$i]];
    }
    $form->setConstants($set_data);

    /****************************/
    //HTML�إå�
    /****************************/
    $html_header = Html_Header($page_title);

    /****************************/
    //HTML�եå�
    /****************************/
    $html_footer = Html_Footer();

    /****************************/
    //���̥إå�������
    /****************************/
    // Render��Ϣ������
    $renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
    $form->accept($renderer);

    //form��Ϣ���ѿ���assign
    $smarty->assign('form',$renderer->toArray());

    //����¾���ѿ���assign
    $smarty->assign('var',array(
        'html_header'   => "$html_header",
        'html_footer'   => "$html_footer",
        'check_err'     => "$check_err",
        'duplicate_err' => "$duplicate_err",
    ));

    //�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
    $smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
//���顼���ʤ�����Ģɼ���Ͻ�������
}else{
    require(FPDF_DIR);

	//*******************���ϲս�*********************
    if($no_data_flg === true){
        $roup_max = 1;
    }else{
        $roup_max = count($slipout_check);
    }        

    for($i = 0; $i < $roup_max; $i++){

        if($no_data_flg === false){

		    //ɽ����SQL����
            //��Ԥξ��
            if($act_flg[$slipout_check_key[$i]] == '��' && $group_kind == '2'){
                //�����̾�ȡ�����NO���
                $sql  = "SELECT \n";
                $sql .= "   client_cname, \n";
                $sql .= "   client_cd1 || '-' || client_cd2 ";
                $sql .= "FROM \n";
                $sql .= "   t_client \n";
                $sql .= "WHERE \n";
                $sql .= "   client_id = ".$staff_id[$slipout_check_key[$i]]."\n";
                $sql .= ";\n";

                $result = Db_Query($db_con, $sql);
                $header[$i][0] = "��Զȼԡ���".pg_fetch_result($result,0,1);       //��Զȼԥ�����
                $header[$i][1] = pg_fetch_result($result,0,0);                      //��Զȼ�̾
                $header[$i][2] = $send_day[$slipout_check_key[$i]];
                $header[$i][3] = true;                                              //���Ƚ�̥ե饰

                //���������ѤΥǡ��������
                $sql  = "SELECT \n";
                $sql .= "   t_aorder_h.ord_no,\n";
                $sql .= "   t_aorder_h.route, \n";
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
//                $sql .= "   t_aorder_h.trade_id, \n";
                $sql .= "   t_client.trade_id, \n";
                $sql .= "   t_aorder_h.net_amount, \n";
                $sql .= "   t_aorder_d.sale_amount,\n";                 //�ɲ�


                $sql .= "   t_aorder_h.tax_amount, \n";
                $sql .= "   t_aorder_h.aord_id, \n";
                $sql .= "   t_aorder_d.tax_div, \n";
                $sql .= "   t_aorder_h.contract_div, \n";
//                $sql .= "   CASE t_aorder_h.slip_out \n";
                $sql .= "   CASE t_client.slip_out \n";
                $sql .= "       WHEN '1' THEN '' \n";
                $sql .= "       WHEN '2' THEN '��' \n";
                $sql .= "   END AS slip_out \n";

                $sql .= "FROM\n";
                $sql .= "    t_aorder_h\n";
                $sql .= "       INNER JOIN\n";
                $sql .= "    t_aorder_d\n";
                $sql .= "    ON t_aorder_d.aord_id = t_aorder_h.aord_id\n"; 
                $sql .= "       INNER JOIN\n";
                $sql .= "    t_client ";
                $sql .= "    ON t_aorder_h.client_id = t_client.client_id \n";
                $sql .= "WHERE\n";

/*
                $sql .= "    t_aorder_h.ord_time = '".$send_day[$slipout_check_key[$i]]."' \n";
                $sql .= "    AND\n";
                $sql .= "    t_aorder_h.act_id = ".$staff_id[$slipout_check_key[$i]]." \n";
                $sql .= "    AND\n";
                $sql .= "    t_aorder_h.del_flg = false \n";    //(2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�


                if($daily_slip_id[$slipout_check_key[$i]] != null){
                    $sql .= "    AND";
                    $sql .= "    daily_slip_id = ".$daily_slip_id[$slipout_check_key[$i]]." ";
                }else{
                    $sql .= "    AND";
                    $sql .= "    daily_slip_id IS NULL ";
                }
*/
                $sql .= "   t_aorder_h.aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].")";

                $sql .= "ORDER BY\n";
                $sql .= "   t_aorder_h.route,\n";
                $sql .= "   t_aorder_h.client_cd1,\n";
                $sql .= "   t_aorder_h.client_cd2,\n";
                $sql .= "   ord_time,\n";
                $sql .= "   t_aorder_h.aord_id, \n";
                $sql .= "   t_aorder_d.line \n";


                $sql .= ";\n";

            }else{
            //���ô����̾�ȡ�����NO�����
                $sql  = "SELECT\n";
                $sql .= "   (substr( replace( t_aorder_h.ord_time, '-','') ,3)\n";
                $sql .= "        ||\n";
                $sql .= "   lpad(t_staff.charge_cd, 4, '0'))AS No,\n";                          // --����No.
                $sql .= "   t_staff.staff_name,\n";                                             //--���ô����
                $sql .= "   LPAD( CAST(t_staff.charge_cd AS text), 4, '0') AS charge_cd\n";     //--�����åե����ɡ�0����
                $sql .= "FROM\n";
                $sql .= "   t_aorder_h\n";
                $sql .= "       INNER JOIN\n";
                $sql .= "   t_aorder_staff\n";
                $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
                $sql .= "   AND t_aorder_staff.staff_div = 0\n";                                //--�ᥤ��ô����
                $sql .= "       INNER JOIN\n";
                $sql .= "   t_staff ON  t_staff.staff_id = t_aorder_staff.staff_id\n";
                $sql .= "WHERE\n";


/*
                $sql .= "   t_aorder_h.ord_time = '".$send_day[$slipout_check_key[$i]]."'\n";
                $sql .= "   AND\n";
                $sql .= "   t_aorder_staff.staff_id = ".$staff_id[$slipout_check_key[$i]]."\n";

                //��������ID
                if($daily_slip_id[$slipout_check_key[$i]] != null){
                    $sql .= "    AND";
                    $sql .= "    daily_slip_id = ".$daily_slip_id[$slipout_check_key[$i]]." ";
                }else{
                    $sql .= "    AND";
                    $sql .= "    daily_slip_id IS NULL ";
                }
*/
                $sql .= "   t_aorder_h.aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].")";

                $sql .= ";\n";

                $result = Db_Query($db_con, $sql);
                $slip_no[$i] = pg_fetch_result($result, 0,0);       //����NO

                $header[$i][0]  = "���ô���ԡ�".pg_fetch_Result($result, 0,2);         //���ô���ԥ�����
                $header[$i][1]  = pg_fetch_result($result, 0,1);                        //���ô����̾
                $header[$i][2]  = $send_day[$slipout_check_key[$i]];                    //ͽ����
                $header[$i][3]  = false;                                                //���Ƚ�̥ե饰

                //���������ѤΥǡ��������
                $sql  = "SELECT \n"; 
                $sql .= "   t_aorder_h.ord_no, \n";
                $sql .= "   t_aorder_h.route, \n";
                $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";
                $sql .= "   t_aorder_h.client_cname, \n";
                $sql .= "   (CASE \n";
                $sql .= "       WHEN t_aorder_d.goods_name IS NULL THEN t_aorder_d.serv_name \n";
                $sql .= "       WHEN t_aorder_d.goods_name = '' THEN t_aorder_d.serv_name \n";
                $sql .= "   ELSE t_aorder_d.goods_name \n";
                $sql .= "   END) AS goods_name, \n";
                $sql .= "   t_aorder_d.num, \n";
                $sql .= "   t_aorder_h.trade_id, \n";

                //ľ�Ĥξ��
                if($group_kind == "2"){
                    $sql .= "   t_aorder_d.sale_price, \n";
                    $sql .= "   t_aorder_h.net_amount, \n";
                    $sql .= "   t_aorder_d.sale_amount, \n";            //�ɲ�
                    $sql .= "   t_aorder_h.tax_amount, \n";
                }else{
                    //ľ�İʳ��ξ��
                    $sql .= "   CASE contract_div ";
                    $sql .= "       WHEN '2' THEN t_aorder_d.trust_cost_price ";
                    $sql .= "       ELSE t_aorder_d.sale_price ";
                    $sql .= "   END AS sale_price, \n";
                    $sql .= "   CASE contract_div ";
                    $sql .= "       WHEN '2' THEN t_aorder_d.trust_cost_amount ";
                    $sql .= "       ELSE t_aorder_d.sale_amount \n";
                    $sql .= "   END AS sale_amount, \n"; 
                    $sql .= "   CASE contract_div ";
                    $sql .= "       WHEN '2' THEN t_aorder_h.trust_net_amount ";
                    $sql .= "       ELSE t_aorder_h.net_amount \n";
                    $sql .= "   END AS net_amount, \n";
                    $sql .= "   CASE contract_div ";
                    $sql .= "       WHEN '2' THEN t_aorder_h.trust_tax_amount ";
                    $sql .= "       ELSE t_aorder_h.tax_amount ";
                    $sql .= "   END AS tax_amount, \n";
                }

                $sql .= "   t_aorder_h.aord_id, \n";
                $sql .= "   t_aorder_d.tax_div, \n";
                $sql .= "   t_aorder_h.contract_div, \n";
//                $sql .= "   CASE t_aorder_h.slip_out \n";
                $sql .= "   CASE t_client.slip_out \n";
                $sql .= "       WHEN '1' THEN '' \n";
                $sql .= "       WHEN '2' THEN '��' \n";
                $sql .= "   END AS slip_out \n";
                $sql .= "FROM\n";
                $sql .= "   t_aorder_h \n";
                $sql .= "       INNER JOIN \n";
                $sql .= "   t_aorder_d \n";
                $sql .= "   ON t_aorder_d.aord_id = t_aorder_h.aord_id \n";
                $sql .= "       INNER JOIN \n";
                $sql .= "   t_aorder_staff \n";
                $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
                $sql .= "   AND t_aorder_staff.staff_div = 0 \n";
                $sql .= "   AND t_aorder_staff.staff_id = ".$staff_id[$slipout_check_key[$i]]." \n";

                $sql .= "       INNER JOIN\n";
                $sql .= "   t_staff\n";
                $sql .= "   ON t_aorder_staff.staff_id = t_staff.staff_id\n";

                $sql .= "       INNER JOIN \n";
                $sql .= "   t_client \n";
                $sql .= "   ON t_aorder_h.client_id = t_client.client_id \n";


                $sql .= "WHERE\n";
                $sql .= "   t_aorder_h.aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].")";
                $sql .= "    AND\n";
                $sql .= "    t_aorder_h.del_flg = false \n";

                $sql .= "ORDER BY \n";
                $sql .= "   t_aorder_h.route, \n";
                $sql .= "   t_aorder_h.client_cd1, \n";
                $sql .= "   t_aorder_h.client_cd2, \n";
                $sql .= "   t_staff.charge_cd,\n";
                $sql .= "   t_aorder_h.ord_time, \n";
                $sql .= "   t_aorder_h.aord_id, \n";
                $sql .= "   t_aorder_d.line \n";
                $sql .= ";\n";
            }

            $result   = Db_Query($db_con, $sql);
            $data_num = pg_num_rows($result);

            //��ɼ���ʬ�롼��        
            for($j = 0; $j < $data_num; $j++){
                $db_data[$j] = @pg_fetch_array($result, $j);
                //��Ф����ǡ�������ɼ���Ȥ�Ż���
                //if($db_data[$j]["ord_no"] != $db_data[$j-1]["ord_no"] || $j == 0){
                if($db_data[$j]["aord_id"] != $db_data[$j-1]["aord_id"] || $j == 0){
                    $slip_data[$i][$j]["no"]             = $db_data[$j]["ord_no"];           //��ɼ�ֹ�
                    $slip_data[$i][$j]["client_cd"]      = $db_data[$j]["client_cd"];        //�����襳����

                    //������̾��15ʸ���ʾ�ξ���2�ʤ�ʬ����
                    if(mb_strlen($db_data[$j]["client_cname"]) > 15){
                        $slip_data[$i][$j]["client"]     = mb_substr($db_data[$j]["client_cname"],0,15);
                        $slip_data[$i][$j]["client2"]    = mb_substr($db_data[$j]["client_cname"],15);
                    }else{
                        $slip_data[$i][$j]["client"]     = $db_data[$j]["client_cname"];     //������̾
                    }

                    $slip_data[$i][$j]["trade"]          = $db_data[$j]["trade_id"];         //�����ʬ
                    $slip_data[$i][$j]["slip_out"]       = $db_data[$j]["slip_out"];         //��ɼȯ��

                    $slip_data[$i][$j]["contract_div"]   = $contract_div = $db_data[$j]["contract_div"];     //�����ʬ
                    $net_amount = $db_data[$j]["net_amount"];

                    //�ݤξ��
                    if($db_data[$j]["trade_id"] < 20 ){
                        $slip_data[$i][$j]["net_ins"]    = $net_amount;   //��ۡʳݡ�
                    //����ξ��
                    }else{
                        $slip_data[$i][$j]["net_money"]  = $net_amount;   //��ۡʸ����
                    }

                    $slip_data[$i][$j]["tax"]            = $db_data[$j]["tax_amount"];       //������
                    $slip_data[$i][$j]["ord_id"]         = $db_data[$j]["aord_id"];           //��ɼ�ֹ�

                    //�����Ȥʤ���(���ֹ�)
                    $mst = $j;
                }

                //����ɼ�ξ��ʤ����Ĥ�Ķ�������
                if(count($slip_data[$i][$mst]["goods"]) >= 5){
                    $mst = $mst+1;
                    $slip_data[$i][$mst]["no"]           = "";                              //��ɼ�ֹ�
                    $slip_data[$i][$mst]["client_cd"]    = "";                              //�����襳����
                    $slip_data[$i][$mst]["client"]       = "";                              //������̾
                    $slip_data[$i][$mst]["client2"]      = "";                              //������̾
                    $slip_data[$i][$mst]["trade"]        = "";                              //�����ʬ
                    $slip_data[$i][$mst]["net_ins"]      = "";                              //���
                    $slip_data[$i][$mst]["net_money"]    = "";                              //���
                    $slip_data[$i][$mst]["tax"]          = "";                              //������
                    $slip_data[$i][$mst]["ord_id"]       = "";                              //��ɼID
                    $slip_data[$i][$mst]["contract_div"] = "";                              //�����ʬ
//                $slip_data[$i][$mst]["goods"][]      = $db_data[$j]["goods_name"];      //����̾
                    $slip_data[$i][$mst]["num"][]        = $db_data[$j]["num"];             //����
    
                    $slip_data[$i][$mst]["price"][]      = $db_data[$j]["sale_price"];      //ñ��
                    $slip_data[$i][$mst]["sale_amount"][]= $db_data[$j]["sale_amount"];     //���
                    $slip_data[$i][$mst]["tax_div"][]    = $db_data[$j]["tax_div"];         //���Ƕ�ʬ
                
                }else{
                    $slip_data[$i][$mst]["goods"][]      = $db_data[$j]["goods_name"];      //����̾
                    $slip_data[$i][$mst]["num"][]        = $db_data[$j]["num"];             //����
                    $slip_data[$i][$mst]["price"][]      = $db_data[$j]["sale_price"];      //ñ��
                    $slip_data[$i][$mst]["sale_amount"][]= $db_data[$j]["sale_amount"];     //���

                    $slip_data[$i][$mst]["tax_div"][]    = $db_data[$j]["tax_div"];         //���Ƕ�ʬ
                }
            }

            //�����ź������0����Ϣ�֤ˤ��롣
            $slip_data[$i] = @array_values($slip_data[$i]);
            $count = 0;     //���ʿ�������
            for($j = 0; $j < count($slip_data[$i]); $j++){

                if($slip_data[$i][$j]["no"] != ""){
                    $count  = count($slip_data[$i][$j]["goods"]);
                    //��ɼ�ֹ�򵭲�
                    $err_no = $slip_data[$i][$j]["no"];
                }else{
                    $count = $count+ count($slip_data[$i][$j]["goods"]);
                }
            }

            //�嵭�Ǻ�����������ɼñ�̤Υǡ����򡢽��Ϥ���������Խ�
            //���ʿ�
            $count = 0;
            //�ڡ�����
            $page = 0;

            //�Կ�
            $s = 0;

            for($j = 0; $j < count($slip_data[$i]); $j++){
                //���ʿ��������
                $count = $count + count($slip_data[$i][$j]["goods"]);

                //���ʿ���70��Ķ������
                //��OR
                //�Կ���������Ķ������ڡ���ʬ��
                if(($j%15*($page+1) == 0) && $j != 0){
                    $page = $page + 1;  //�ڡ�������ܣ�
                    $s = 0;             //�Կ�������
                }

                $page_data[$i][$page][$s] = $slip_data[$i][$j];
    
                //�ڡ������
                $page_ins_amount[$i][$page]   = $page_ins_amount[$i][$page]  + $page_data[$i][$page][$s]["net_ins"];
                $page_money_amount[$i][$page] = $page_money_amount[$i][$page]  + $page_data[$i][$page][$s]["net_money"];

                //�����ǹ����
                if($page_data[$i][$page][$s]["net_ins"] != null){
                    $page_ins_tax_amount[$i][$page]   = $page_ins_tax_amount[$i][$page] + $page_data[$i][$page][$s]["net_ins"] + $page_data[$i][$page][$s]["tax"];
                //������ǹ����
                }elseif($page_data[$i][$page][$s]["net_money"] != null){
                    $page_money_tax_amount[$i][$page] = $page_money_tax_amount[$i][$page] + $page_data[$i][$page][$s]["net_money"] + $page_data[$i][$page][$s]["tax"];
                }
            
                $page_tax_amount[$i][$page]   = $page_tax_amount[$i][$page]  + $page_data[$i][$page][$s]["tax"];

                //����������
                $total_ins_amount[$i]         = $total_ins_amount[$i]   + $page_data[$i][$page][$s]["net_ins"];
                $total_money_amount[$i]       = $total_money_amount[$i] + $page_data[$i][$page][$s]["net_money"];
                $total_tax_amount[$i]         = $total_tax_amount[$i]   + $page_data[$i][$page][$s]["tax"];
            
                //�����ǹ����
                if($page_data[$i][$page][$s]["net_ins"] != null){
                    $total_ins_tax_amount[$i]     = $total_ins_tax_amount[$i] + $page_data[$i][$page][$s]["net_ins"] + $page_data[$i][$page][$s]["tax"];
                //������ǹ����
                }elseif($page_data[$i][$page][$s]["net_money"] != null){
                    $total_money_tax_amount[$i]   = $total_money_tax_amount[$i] + $page_data[$i][$page][$s]["net_money"] + $page_data[$i][$page][$s]["tax"];
                }
                //�Կ���ܣ�
                $s = $s + 1;
            }

            //���ʿ��ι�פ����
            //�ڡ�����ʬ�롼��
            for($j = 0; $j < count($page_data[$i]); $j++){
                $in_aord_id = null;
                //�Կ�ʬ�롼��
                for($r = 0; $r < count($page_data[$i][$j]); $r++){
                    //��ɼ�ֹ�ɽ���Ԥξ��
                    if($page_data[$i][$j][$r]["ord_id"]){
                        $in_aord_id[] = $page_data[$i][$j][$r]["ord_id"];
                    }
                }
                $ary_in_aord_id = implode(",", $in_aord_id);
 
                //���ʹ��SQL
				//--�����������
                $sql2  = "(SELECT  ";
                $sql2 .= " t_aorder_d.egoods_name AS goods_name, ";
                $sql2 .= "  sum(t_aorder_ship.num) AS sum ";
                $sql2 .= "FROM ";
                $sql2 .= "  t_aorder_d ";
                $sql2 .= "      INNER JOIN ";
                $sql2 .= "  t_aorder_ship ";
                $sql2 .= "  ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id  ";
                $sql2 .= "  AND t_aorder_d.aord_id IN ($ary_in_aord_id) ";
                $sql2 .= "  AND t_aorder_d.egoods_id = t_aorder_ship.goods_id ";
                $sql2 .= "GROUP BY ";
                $sql2 .= "  t_aorder_ship.goods_cd, ";
                $sql2 .= "  t_aorder_d.egoods_name ";
                $sql2 .= "ORDER BY ";
                $sql2 .= "  t_aorder_ship.goods_cd  ";
                $sql2 .= ") ";
                $sql2 .= "UNION  ";
				//--�����ƥ������
                $sql2 .= "(SELECT  ";
                $sql2 .= "  t_aorder_d.goods_name, ";
                $sql2 .= "  sum(t_aorder_ship.num) AS sum ";
                $sql2 .= "FROM ";
                $sql2 .= "  t_aorder_d ";
                $sql2 .= "      INNER JOIN ";
                $sql2 .= "  t_aorder_ship ";
                $sql2 .= "  ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id  ";
                $sql2 .= "  AND t_aorder_d.aord_id IN ($ary_in_aord_id) ";
                $sql2 .= "  AND t_aorder_d.goods_id = t_aorder_ship.goods_id ";
                $sql2 .= "GROUP BY ";
                $sql2 .= "  t_aorder_ship.goods_cd, ";
                $sql2 .= "  t_aorder_d.goods_name ";
                $sql2 .= "ORDER BY ";
                $sql2 .= "  t_aorder_ship.goods_cd ";
                $sql2 .= ") ";

#print_array($sql2); 

                $sum_res = Db_Query($db_con, $sql2);
                $sum_goods_num = pg_num_rows($sum_res);

            //��Ĥ�ɽ��ɽ������Τ�12���ʤޤʤΤǡ��������ʤ��Ĥ������Ż���
                $cell = 0;
                for($l = 0; $l < $sum_goods_num; $l++){
                    $sum_goods_data = pg_fetch_array($sum_res, $l);
//print_array($sum_goods_data);
//                if($l%12 == 0 && $l != 0){
                    if($l%8 == 0 && $l != 0){
                        $cell = $cell+1;
                    }

                    $goods_data[$i][$j][$cell]["name"][] = $sum_goods_data["goods_name"];
                    $goods_data[$i][$j][$cell]["num"][]  = $sum_goods_data["sum"];
                }
            }

            //������������
            $sql  = "SELECT ";
            $sql .= "   stand_day ";
            $sql .= "FROM\n";
            $sql .= "   t_stand";
            $sql .= ";";

            $day_res = Db_Query($db_con, $sql);
//    $stand_day = explode("-", pg_fetch_result($result, 0,0));
            $stand_day = explode("-", pg_fetch_result($day_res, 0,0));

            //��������ʬ��
            $all_send_day[$i] = explode("-", $send_day[$slipout_check_key[$i]]);     

            //�����������������
            $send_day_w[$i]   = date('w', mktime(0,0,0,$all_send_day[$i][1], $all_send_day[$i][2], $all_send_day[$i][0]));

            if($send_day_w[$i] == '0'){
                $week_w[$i] = "��";
            }elseif($send_day_w[$i] == '1'){        
                $week_w[$i] = "��";
            }elseif($send_day_w[$i] == '2'){
                $week_w[$i] = "��";
            }elseif($send_day_w[$i] == '3'){
                $week_w[$i] = "��";
            }elseif($send_day_w[$i] == '4'){
                $week_w[$i] = "��";
            }elseif($send_day_w[$i] == '5'){
                $week_w[$i] = "��";
            }elseif($send_day_w[$i] == '6'){
                $week_w[$i] = "��";
            }

            $Basic_date_res[$i] = Basic_date($stand_day[0],$stand_day[1],$stand_day[2],$all_send_day[$i][0],$all_send_day[$i][1],$all_send_day[$i][2]);

            if($Basic_date_res[$i][0] == '1'){
                $week[$i] = "A";
            }elseif($Basic_date_res[$i][0] == '2'){
                $week[$i] = "B";
            }elseif($Basic_date_res[$i][0] == '3'){
                $week[$i] = "C";
            }elseif($Basic_date_res[$i][0] == '4'){
                $week[$i] = "D";
            }
        }
    }
//�ǥХå�ɽ��
//    print_array($goods_array);
//    print_array($goods_data);
//    print_array($slip_no);
//    print_array($header);


    //���顼�ե饰��ture�ξ�������λ
    if($err_flg == true && $no_data_flg === false){
        //���󥹥�������
        $form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

        $form->addElement("submit","form_renew_button", "�ư���","");
        $form->addElement("button","form_close_button", "�Ĥ���", "OnClick=\"window.close()\"");

        //�����å������ͤ�Ĥ�
        for($i = 0; $i < count($slipout_check); $i++){
            $form->addElement("hidden", "form_slipout_check[$slipout_check_key[$i]]");
            $form->addElement("hidden", "hdn_send_day[$slipout_check_key[$i]]");
            $form->addElement("hidden", "hdn_staff_id[$slipout_check_key[$i]]");
            $form->addElement("hidden", "hdn_act_flg[$slipout_check_key[$i]]");

            $set_data["form_slipout_check"][$slipout_check_key[$i]] = '1';
            $set_data["hdn_send_day"][$slipout_check_key[$i]] = $send_day[$slipout_check_key[$i]];
            $set_data["hdn_staff_id"][$slipout_check_key[$i]] = $stff_id[$slipout_check_key[$i]];
            $set_data["hdn_act_flg"][$slipout_check_key[$i]]  = $act_flg[$slipout_check_key[$i]];
        }

        $form->setConstants($set_data);

        /****************************/
        //HTML�إå�
        /****************************/
        $html_header = Html_Header($page_title);

        /****************************/
        //HTML�եå�
        /****************************/
        $html_footer = Html_Footer();

        /****************************/
        //���̥إå�������
        /****************************/
        // Render��Ϣ������
        $renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
        $form->accept($renderer);

        //form��Ϣ���ѿ���assign
        $smarty->assign('form',$renderer->toArray());

        //����¾���ѿ���assign
        $smarty->assign('var',array(
            'html_header'   => "$html_header",
            'html_footer'   => "$html_footer",
            'duplicate_err' => "����ɼ�ֹ�".$err_no."�פλ������ʤ�71����ʾ�Τ���ɽ���Ǥ��ޤ���",
        ));

        //�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
        $smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

    //�Уģƺ���
    }else{
	    //������
	    $yy = date('Y');
	    $mm = date('m');
	    $dd = date('d');

		//�����ȥ�
		$title = "���������ס������󡡡�";

		//����̾������align
		$list[0] = array("40","��ɼNo.","C");
		$list[1] = array("140","�����ա���","C");
		$list[2] = array("130","������������","C");
		$list[3] = array("130","������������","C");
		$list[4] = array("130","������������","C");
		$list[5] = array("130","������������","C");
		$list[6] = array("130","������������","C");
		$list[7] = array("70","�á�����","C");
		$list[8] = array("140","�䡡�塡�硡�ס���","C");
		$list[9] = array("70","�䡡�塡��","C");

	    $goods_width = array("0","180","360","540","720");

		//�ڡ���������
		//A3
		$pdf=new MBFPDF('L','pt','A3');
		$pdf->AddMBFont(GOTHIC ,'SJIS');
		$pdf->SetAutoPageBreak(false);

	    //Ģɼ����  
	    for($i = 0; $i < $roup_max; $i++){
		
	        //�ڡ�����ʬ�롼��
            if($no_data_flg === true){
                $roup_max2 = 1;
            }else{
                $roup_max2 = count($page_data[$i]);
            } 
	        for($j = 0; $j < $roup_max2; $j++){
		
	            $pdf->AddPage();
	    	    //;��
			    $left_margin = 60;
			    $top_margin = 40;
	            /******************�ڡ�����************************/
			    $pdf->SetFont(GOTHIC, '', 10);
			    //A3�β����ϡ�1110
			    $pdf->SetTextColor(0,0,0);
			    $pdf->SetXY(30,20);
			    $pdf->Cell(1110, 12, ($j+1)."/".$roup_max2, '0', '1', 'R');

				$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $top_margin);
			    /*******************�����ȥ�***********************/

			    $pdf->SetFont(GOTHIC, '', 20);
			    //A3�β����ϡ�1110
			    $pdf->SetTextColor(0,0,0);
			    $pdf->SetXY($left_margin,$top_margin);
			    $pdf->Cell(1110, 20, $title, '0', '1', 'C');

			    /***************�����ȥ�β��Υ���*****************/
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
			    $pdf->Cell(160,15,"������������ǯ�������������������No.".$slip_no[$i],'0','0','C','1');

			    $pdf->SetXY($left_margin+900,$top_margin+5);
			    $pdf->Cell(50,30,"�롼��",'LTR','2','C','1');
                //��Ԥξ��
                if($header[$i][3] === true){
			        $pdf->SetFillColor(180,180,180);
                }
			    $pdf->SetXY($left_margin+950,$top_margin+5);
			    $pdf->Cell(160,15,$header[$i][0],'LTR','0','L','1');
			    $pdf->SetXY($left_margin+950,$top_margin+20);
			    $pdf->Cell(160,15,$header[$i][1],'LR','0','L','1');
			    $pdf->SetFillColor(255,255,255);
			    $pdf->SetXY($left_margin+900,$top_margin+35);
			    $pdf->Cell(50,15,"ͽ����",'LB','2','C','1');
			    $pdf->SetXY($left_margin+950,$top_margin+35);
			    $pdf->Cell(160,15,"��".$all_send_day[$i][0]."ǯ��".$all_send_day[$i][1]."�".$all_send_day[$i][2]."����".$week[$i]."����".$week_w[$i]."��",'BR','0','C','1');

			    $pdf->SetLineWidth(0.5);
			    $pdf->SetDrawColor(150,150,255);
			    $pdf->Line($left_margin+950,$top_margin+20,$left_margin+950,$top_margin+55);
			    $pdf->Line($left_margin+900,$top_margin+35,$left_margin+1110,$top_margin+35);

			    /*****************����****************************/

			    $pdf->SetLineWidth(1);
			    //�ƥ����Ȥο�
			    $pdf->SetTextColor(0,0,0); 

			    //����ɽ��
			    $pdf->SetXY($left_margin,$top_margin+50);
			    $pdf->SetFillColor(255,255,255);
			    for($m=0;$m<count($list)-1;$m++){
				    $pdf->SetFont(GOTHIC, '', 11);
				    if($m == 8){
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
				$pdf->SetXY($left_margin+1040, $top_margin+50);
				$pdf->Cell($list[$m][0], 15, $list[$m][1], 'LRT', '2', $list[$m][2],'1');
				$pdf->SetXY($left_margin+1040, $top_margin+65);
				$pdf->Cell('70', 15, '�����⡡��', 'LRB', '0', 'C','1');

				$pdf->SetDrawColor(150,150,255);
				$pdf->Line($left_margin+40  ,$top_margin+51,$left_margin+40,$top_margin+80);
				$pdf->Line($left_margin+180 ,$top_margin+51,$left_margin+180,$top_margin+80);
				$pdf->Line($left_margin+310 ,$top_margin+51,$left_margin+310,$top_margin+80);
				$pdf->Line($left_margin+440 ,$top_margin+51,$left_margin+440,$top_margin+80);
				$pdf->Line($left_margin+570 ,$top_margin+51,$left_margin+570,$top_margin+80);
				$pdf->Line($left_margin+700 ,$top_margin+51,$left_margin+700,$top_margin+80);
				$pdf->Line($left_margin+830 ,$top_margin+51,$left_margin+830,$top_margin+80);
				$pdf->Line($left_margin+900 ,$top_margin+65,$left_margin+900,$top_margin+80);
				$pdf->Line($left_margin+970 ,$top_margin+66,$left_margin+970,$top_margin+80);
				$pdf->Line($left_margin+1040,$top_margin+65,$left_margin+1040,$top_margin+80);

				/*****************�ǡ���****************************/
				//�ǡ���ɽ��
				$pdf->SetFont(GOTHIC, '', 9);
				$pdf->SetDrawColor(150,150,255);          //���ο�
				$pdf->SetXY($left_margin,$top_margin+80);
				$pdf->SetTextColor(0,0,0);                //�ե���Ȥο�
				$pdf->SetLineWidth(0.5);

				//ɽ�ιԿ�ʬɽ��
//				for($c=0;$c<13;$c++){
				for($c=0;$c<15;$c++){
					$posY = $pdf->GetY();
					$pdf->SetXY($left_margin, $posY);
					$pdf->SetFillColor(255,255,255);      //�طʿ�
	//--
					//��ɼ�ֹ楻��ζ�����ʬ��ɽ��
					$pdf->Cell("40", 12, "", "LTR", '0','C','1');

	                //������̾��ɽ��
	                $pdf->Cell("100", 12, $page_data[$i][$j][$c]["client_cd"], "LTB", "0", "L","1");
				    $pdf->SetTextColor(255,0,0);                //�ե���Ȥο�
	                $pdf->Cell("40", 12, $page_data[$i][$j][$c]["slip_out"], "TBR", "0", "R","1");

				    $pdf->SetTextColor(0,0,0);                //�ե���Ȥο�

	                //����̾��ɽ��
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][0],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][0]), 'TR', '0','R','1');
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][1],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][1]), 'TR', '0','R','1');
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][2],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][2]), 'TR', '0','R','1');
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][3],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][3]), 'TR', '0','R','1');
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][4],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][4]), 'TR', '0','R','1');

	                //�����Ǥ�ɽ��
	                $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	                //����׶�ۤ�ɽ��
	                $pdf->Cell(140, 12, "", '1', '0', 'R', '1');

	                //�����
	                $pdf->Cell(70 , 12, "", 'LR', '2', 'C', '1');

	//--
					$posY = $pdf->GetY();
					$pdf->SetXY($left_margin, $posY);
					$pdf->SetFillColor(255,255,255);      //�طʿ�

	                //��ɼ�ֹ��ɽ��
					$pdf->Cell(40 , 12, $page_data[$i][$j][$c]["no"], 'R', '0','C','1');

					//������ξ�ζ��򥻥��ɽ��
					$pdf->Cell(140, 12, $page_data[$i][$j][$c]["client"], '1', '0','L','1');

	                //����ñ����ɽ��
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][0])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][0]), '1', '0','R','1');
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][1])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][1]), '1', '0','R','1');
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][2])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][2]), '1', '0','R','1');
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][3])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][3]), '1', '0','R','1');
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][4])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][4]), '1', '0','R','1');

	                //�����ǲ��ζ����ɽ��
	                $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$j][$c]["tax"]), '1', '0', 'R', '1');

	                //����׶�ۤ�ɽ��
	                $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$j][$c]["net_money"]), '1', '0', 'R', '1');
	                $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$j][$c]["net_ins"]),   '1', '0', 'R', '1');

	                //����ۤ�ɽ��
	                $pdf->Cell(70 , 12, "", 'LR', '2', 'C', '1');

	//--
					$posY = $pdf->GetY();
					$pdf->SetXY($left_margin, $posY);
					$pdf->SetFillColor(255,255,255);      //�طʿ�

					//��ɼ�ֹ楻��ζ�����ʬ��ɽ��
					$pdf->Cell(40 , 12, "", 'LR', '0','C','1');

					//�������ɽ��
					$pdf->Cell(140, 12, $page_data[$i][$j][$c]["client2"], '1', '0','L','1');

	                //����ñ���ι��ܤ�ɽ��
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');

	                //�����ǲ��ζ����ɽ��
	                $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	                //����׶�ۤ�ɽ��
	                $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');
	                $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	                //�����
	                $pdf->Cell(70 , 12, "", '1', '2', 'C', '1');
				}
				$pdf->Line($left_margin,$top_margin+80,$left_margin+1110,$top_margin+80);

				//����
				$pdf->SetLineWidth(1);
				$line_width = $top_margin+80;
				for($c=1;$c<=15;$c++){
					$num = $c - 1;
					$pdf->Line($left_margin,$line_width+(36*$num),$left_margin,$line_width+36*$c);
					$pdf->Line($left_margin+180, $line_width+(36*$num),$left_margin+180,$line_width+36*$c);
					$pdf->Line($left_margin+830, $line_width+(36*$num),$left_margin+830,$line_width+36*$c);
					$pdf->Line($left_margin+900, $line_width+(36*$num),$left_margin+900,$line_width+36*$c);
					$pdf->Line($left_margin+1040,$line_width+(36*$num),$left_margin+1040,$line_width+36*$c);
					$pdf->Line($left_margin+1110,$line_width+(36*$num),$left_margin+1110,$line_width+36*$c);

					$pdf->Line($left_margin,$line_width+36*$c,$left_margin+1110,$line_width+36*$c);
				}

				/********************���ʡ�����*********************/
				for($x=0;$x<4;$x++){
					$pdf->SetXY($left_margin+$goods_width[$x],$top_margin+635);
					$pdf->Cell(120,12,"��������",'1','0','C','1');
					$pdf->Cell(50,12,"��������",'1','2','C','1');
					for($c=0;$c<8;$c++){
						$posY = $pdf->GetY();
						$pdf->SetXY($left_margin+$goods_width[$x], $posY);
						$pdf->Cell(120,12,$goods_data[$i][$j][$x]["name"][$c],'1','0','C','1');
						$pdf->Cell(50,12,My_Number_Format($goods_data[$i][$j][$x]["num"][$c]),'1','2','R','1');
					}
				}
				/*******************���****************************/
				$pdf->SetFont(GOTHIC, '', 11);
				$pdf->SetXY($left_margin+750,$top_margin+620);
				$pdf->Cell(80,26,"�ǡ�����",'1','0','C','1');


                //���礷���ʤ����
                if(count($page_data[$i]) == 1){
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','C','1');
				    $pdf->SetXY($left_margin+830,$top_margin+633);
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,""                                           ,'1','1','C','1');
                }else{
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($page_money_amount[$i][$j]),'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($page_ins_amount[$i][$j])  ,'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','C','1');
				    $pdf->SetXY($left_margin+830,$top_margin+633);
				    $pdf->Cell(70,13,My_Number_format($page_tax_amount[$i][$j]),'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($page_money_tax_amount[$i][$j]),'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($page_ins_tax_amount[$i][$j])  ,'1','0','R','1');
				    $pdf->Cell(70,13,""                                           ,'1','1','C','1');
                }
				$posY = $pdf->GetY();
				$pdf->SetXY($left_margin+750, $posY);
				$pdf->SetFillColor(180,180,180);      //�طʿ�
				$pdf->Cell(80,26,"�硡����",'1','0','C','1');

                if($j == count($page_data[$i])-1){
				    $pdf->Cell(70,13,""                                    ,'1','0','0','1');
				    $pdf->Cell(70,13,My_Number_format($total_money_amount[$i]),'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($total_ins_amount[$i])  ,'1','0','R','1');
				    $pdf->Cell(70,13,""                                    ,'1','0','C','1');

				    $pdf->SetXY($left_margin+830,$posY+13);
                    $pdf->Cell(70,13,My_Number_format($total_tax_amount[$i])      ,'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($total_money_tax_amount[$i]),'1','0','R','1');
    			    $pdf->Cell(70,13,My_Number_format($total_ins_tax_amount[$i])  ,'1','0','R','1');
				    $pdf->Cell(70,13,""                                        ,'1','1','C','1');
				    $pdf->SetXY($left_margin,$posY+100);
                }else{
				    $pdf->Cell(70,13,""                                    ,'1','0','0','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,""                                    ,'1','0','C','1');

				    $pdf->SetXY($left_margin+830,$posY+13);
                    $pdf->Cell(70,13,"", '1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
    			    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,""                                        ,'1','1','C','1');
				    $pdf->SetXY($left_margin,$posY+100);

                }
				$pdf->SetFillColor(255,255,255);      //�طʿ�
			    $pdf->Cell(160,15,"����������".$yy."ǯ��".$mm."�".$dd."��",'0','0','R','1');

				//����
				$pdf->SetLineWidth(1);

				$pdf->Line($left_margin+750 ,$top_margin+620.5,$left_margin+750,$top_margin+672.5);
				$pdf->Line($left_margin+830 ,$top_margin+620.5,$left_margin+830,$top_margin+672.5);
				$pdf->Line($left_margin+900 ,$top_margin+620.5,$left_margin+900,$top_margin+672.5);
				$pdf->Line($left_margin+1040,$top_margin+620.5,$left_margin+1040,$top_margin+672.5);
				$pdf->Line($left_margin+1110,$top_margin+620.5,$left_margin+1110,$top_margin+672.5);

				$pdf->Line($left_margin+750 ,$top_margin+646.5,$left_margin+1110,$top_margin+646.5);
				$pdf->Line($left_margin+750 ,$top_margin+672.5,$left_margin+1110,$top_margin+672.5);


			}
	    }
		$pdf->Output();
		//$pdf->Output(mb_convert_encoding("��������".date("Ymd").".pdf", "SJIS", "EUC"),"D");
	}
}

//������ǽ��������Ф����˾����Ǥ�׻�����ؿ�
function Aord_Tax_Amount($db_con, $sale_amount, $tax_div){


    //������Ψ�����
    $sql = "SELECT 
                tax_rate_n 
            FROM
                t_client 
            WHERE
                client_id = ".$_SESSION["client_id"]."
            ;
        ";
    $result = Db_Query($db_con, $sql);
    $tax_rate = pg_fetch_result($result, 0, 0);

    //���ۤδݤ��ʬ��ü����ʬ�����
    $sql = "SELECT 
                client_id, 
                coax, 
                tax_franct 
            FROM 
                t_client 
            WHERE 
                shop_id = ".$_SESSION["client_id"]." 
                AND 
                act_flg = true
            ;";
    
    $result = Db_Query($db_con, $sql);
    $toyo_data = pg_fetch_array($result, 0);

    $total_amount = Total_Amount($sale_amount, $tax_div, $toyo_data["coax"], $toyo_data["tax_franct"], $tax_rate, $toyo_data["client_id"], $db_con);


    return $total_amount[1];
}

?>
