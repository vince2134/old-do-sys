<?php

/******************************
 *  �ѹ�����
 *      ����2006-10-26�����Ψ������ν��ô���Ԥ�ɽ��<suzuki>
 *
 *
******************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/03/05      ��˾6-3     kajioka-h   �����ƥ�̾��������ʾ���ʬ��ܾ���̾�ˡפȡ�ά�Ρ�ɽ����
 *  2007/03/09      xx-xxx      kajioka-h   ������������ɽ������
 *  2007/03/22      ��˾21      kajioka-h   ��ɼ����������ɲ�
 *  2007/03/26      ��˾21      kajioka-h   ���ꡢ��𡢾�ǧ��ǽ���ɲ�
 *  2007/03/27      ��˾21      kajioka-h   ����ͽ��вٺѤ���ɼ�κ�����˾��ʤ��᤹�Ҹˤ�����ǽ��
 *  2007/04/05      ����¾25    kajioka-h   ��������Ҳ����������λ���������Υ����å������ɲ�
 *  2007/04/06      ��˾1-4     kajioka-h   �Ҳ���¤λ����ѹ��ˤ�ꡢ�Ҳ����̾���Ҳ���¶�ۤȡ����ͤ�ɽ��
 *  2007/04/13      ����¾      kajioka-h   ���������ע���ͽ�������פ�ɽ���ѹ�
 *  2007/04/27      ¾79,152    kajioka-h   ������λ����ѹ�
 *  2007/05/08      ����¾      kajioka-h   �ֽ�ϩ�ס�������CD�סּ���ID�׽��ɽ��
 *  2007/05/17      xx-xxx      kajioka-h   ͽ��ǡ������١�ͽ��ǡ��������������ɼ�����������ɼ�ǥ쥤�����Ȥ��碌��
 *  2007/05/23      xx-xxx      kajioka-h   �����ɼ�θ�������ǽ�ˤ�ꡢ���顼��å������ɲ�
 *  2007/05/24      B0702-057   kajioka-h   ���ͤβ��Ԥ�;�פ˲��Ԥ���Ƥ���Х�����
 *  2007/06/05      �׷�64      kajioka-h   ͽ����Ǻ�ä���ɼ��ͽ��������ܤ���褦��
 *                  �׷�64      kajioka-h   ͽ����Ǻ�ä���ɼ��ľ�����ɽ������褦��
 *  2007/06/14      ����¾14    kajioka-h   ������
 *  2007/06/25                  fukuda      ����/��ǧ����ͽ��������̤��ξ��ϥ��顼
 *  2007/08/20      �ݼ�66      kajioka-h   ͽ�������ΰ��������ǽ
 *  2009/09/18                  aoyama-n    �Ͱ����ʤξ����ֻ���ɽ��
 *  2009/10/06      rev.1.3     kajioka-h   ͽ����������������2����ʾ������ȷٹ��å������ɲ�
 *  2010/01/23      rev.1.4     hashimoto-y ���������Ԥä����ˡ������إå��ξ����ǳۤ������˱����ƹ�������������ɲ�
 *
 */


$page_title = "ͽ��ǡ�������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

//echo "<font color=red style=\"font-family: 'HGS�Խ���';\"><b>�Խ���ˤĤ���ư���ޤ���</b></font>";

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���¥����å�
//$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

require_once(PATH ."function/trade_fc.fnc");


//--------------------------//
//���顼��å������ե�����
//--------------------------//
require_once(INCLUDE_DIR."error_msg_list.inc");


/*****************************/
//�����ѿ�����
/*****************************/
$id           = $_GET["aord_id"];        //����ID
$array_id     = $_GET["aord_id_array"];  //�����������Ƥμ���ID
$back_display = $_GET["back_display"];   //���ܸ�
$staff_id     = $_GET["staff_id"];       //���ô����ID
$client_id    = $_SESSION["client_id"];  //�����ID
$shop_id      = $_SESSION["client_id"];  //�����ID
$group_kind   = $_SESSION["group_kind"]; //���롼�׼���

//����IDʣ��Ƚ��
if($id != NULL && $array_id == NULL){
    //��Ĥ��������󥯤�������

    $aord_id = $id;
}else{
    //�����������ե�󥯤�������

    //���󥷥ꥢ�饤����
    $array_id = stripslashes($array_id);
    $array_id = urldecode($array_id);
    $array_id = unserialize($array_id);

    $count = count($array_id);
    for($i=0, $array_id_tmp=""; $i<$count; $i++){
        $array_id_tmp .= $array_id[$i].", ";
    }
    $array_id_tmp = substr($array_id_tmp, 0, strlen($array_id_tmp)-2);

    if($array_id_tmp == null){
        header("Location: ".Make_Rtn_Page("contract"));
        exit();
    }

    //��ϩ��������CD������ID���¤��ؤ�
    $sql  = "SELECT \n";
    $sql .= "    aord_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "WHERE \n";
    $sql .= "    aord_id IN (".$array_id_tmp.") \n";
    $sql .= "ORDER BY \n";
    $sql .= "    route, \n";
    $sql .= "    client_cd1, \n";
    $sql .= "    client_cd2, \n";
    $sql .= "    aord_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $count = pg_num_rows($result);

    for($i=0, $array_id=array(); $i<$count; $i++){
        $array_id[] = pg_fetch_result($result, $i, 0);
    }



    $aord_id = $array_id;
}
Get_Id_Check2($aord_id);

//����Ƚ��
Get_ID_Check3($id);
Get_ID_Check3($staff_id);
Get_ID_Check3($array_id);

/*****************************/
//�ե��������
/*****************************/
// ���ܥ���������Ƚ��
switch($back_display){
    case "cal_month" :
        // ��󥫥�����(��)
        $form->addElement("button","modoru","�ᡡ��","onClick=\"location.href='".FC_DIR."sale/2-2-101-2.php?search=1'\"");
        break;
    case "cal_week" :
        // ��󥫥�����(��)
        $form->addElement("button","modoru","�ᡡ��","onClick=\"location.href='".FC_DIR."sale/2-2-102-2.php?search=1'\"");
        break;
    case "confirm" :
        // ͽ����ɼ������
        $form->addElement("button","modoru","�ᡡ��","onClick=\"location.href='".FC_DIR."sale/2-2-206.php?search=1'\"");
        break;
    case "output" :
        // ��ɼȯ��
        $form->addElement("button","modoru","�ᡡ��","onClick=\"location.href='".FC_DIR."sale/2-2-204.php?search=1'\"");
        break;
    case "count_daily" :
        // ��������
        $form->addElement("button","modoru","�ᡡ��","onClick=\"location.href='".FC_DIR."sale/2-2-113.php?search=1'\"");
        break;
    case "round" :
        // �������
        $form->addElement("button","modoru","�ᡡ��","onClick=\"location.href='".FC_DIR."system/2-1-237.php?search=1'\"");
        break;
    case "round_act" :
        // �������
        $form->addElement("button","modoru","�ᡡ��","onClick=\"location.href='".FC_DIR."system/2-1-238.php?search=1'\"");
        break;
    case "reserve" :
        // �����ɼ����
        $form->addElement("button","modoru","�ᡡ��","onClick=\"javascript:location.href('../sale/2-2-209.php?search=1');\"");
        break;
    case "act_count" :
        // ��Խ���ɽ
        $form->addElement("button","modoru","�ᡡ��","onClick=\"javascript:location.href('../sale/2-2-116.php?search=1');\"");
        break;
    Default:
        //̵�����ϡ���������(��)������
//        header("Location: ".FC_DIR."sale/2-2-101-2.php");
        header("Location: ".Make_Rtn_Page("contract"));
}

$form->addElement("hidden", "check_value_flg");     //ͽ��ǡ������������å��ܥå�������Ƚ��ե饰
$con_data["check_value_flg"]   = "t";
$form->setConstants($con_data);

$form->addElement("hidden", "hdn_slip_del");        //����ܥ���Ƚ��ե饰
$form->addElement("hidden", "hdn_confirm");         //����ܥ���Ƚ��ե饰
$form->addElement("hidden", "hdn_report");          //���ܥ���Ƚ��ե饰
$form->addElement("hidden", "hdn_accept");          //��ǧ�ܥ���Ƚ��ե饰


//�������
Addelement_Date($form, "form_lump_change_date", "", "-");   //�������ϥե�����
$form->addElement("button", "btn_lump_change", "�������", " onClick=\"Dialogue_1('����������ޤ���', 'true', 'hdn_lump_change');\" $disabled");
$form->addElement("hidden", "hdn_lump_change");     //��������ܥ���Ƚ��ե饰

//rev.1.3 �ѹ���ͽ������
$form->addElement("hidden", "hdn_former_delivery_day");


//--------------------------//
//��������ܥ��󲡲�����
//--------------------------//
//if($_POST["hdn_lump_change"] == "true"){
//rev.1.3 �ٹ�ܥ��󲡲��������ɲ�
if($_POST["hdn_lump_change"] == "true" || $_POST["form_lump_change_warn"] == "�ٹ��̵�뤷�ư������"){

    //ͽ������
    //��ɬ�ܥ����å�
    $form->addGroupRule("form_lump_change_date", array(
        "y" => array(array($h_mess[35], "required")),
        "m" => array(array($h_mess[35], "required")),
        "d" => array(array($h_mess[35], "required")),
    ));
    //���ͥ����å�
    $form->addGroupRule("form_lump_change_date", array(
        "y" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
        "m" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
        "d" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
    ));

    if($form->validate()){
        //�����������å�
        if(!checkdate((int)$_POST["form_lump_change_date"]["m"], (int)$_POST["form_lump_change_date"]["d"], (int)$_POST["form_lump_change_date"]["y"])){
            $form->setElementError("form_lump_change_date", $h_mess[35]);
        }

		//rev.1.3 �ٹ�̵��ܥ��󲡲�����Ƥʤ�����2����ʾ�Υ��Ƥ��뤫�����å�
		if($_POST["form_lump_change_warn"] != "�ٹ��̵�뤷�ư������"){
			$b_lump_day = date("Y-m-d", mktime(0, 0, 0, $_POST["form_lump_change_date"]["m"] - 2, $_POST["form_lump_change_date"]["d"], $_POST["form_lump_change_date"]["y"]));	//2������
			$a_lump_day = date("Y-m-d", mktime(0, 0, 0, $_POST["form_lump_change_date"]["m"] + 2, $_POST["form_lump_change_date"]["d"], $_POST["form_lump_change_date"]["y"]));	//2�����
			//2����ʾ�Υ��Ƥ���
			if(($_POST["hdn_former_delivery_day"] <= $b_lump_day) || ($_POST["hdn_former_delivery_day"] >= $a_lump_day)){
				$warn_lump_change = "���Ϥ���ͽ��������2����ʾ�Υ��Ƥ��ޤ���";
				$form->addElement("submit", "form_lump_change_warn", "�ٹ��̵�뤷�ư������");
			//�����ϰ���
			}else{
				$warn_lump_change = null;
			}
		}else{
			$warn_lump_change = null;
		}

    }

    $error_flg = (count($form->_errors) > 0) ? true : false;


    //������������������
    //if($error_flg == false){
	//rev.1.3 ���顼����ʤ���2����ʾ�Υ��Ƥ��ʤ�
    if($error_flg == false && $warn_lump_change == null){

        $lump_change_date  = str_pad($_POST["form_lump_change_date"]["y"], 4, "0", STR_PAD_LEFT);
        $lump_change_date .= "-";
        $lump_change_date .= str_pad($_POST["form_lump_change_date"]["m"], 2, "0", STR_PAD_LEFT);
        $lump_change_date .= "-";
        $lump_change_date .= str_pad($_POST["form_lump_change_date"]["d"], 2, "0", STR_PAD_LEFT);


        //����ID�����IN��ǻȤ�����˥���޶��ڤ�ˤ���
        $count = count($aord_id);
        for($i=0, $array_id_tmp=""; $i<$count; $i++){
            $array_id_tmp .= $aord_id[$i].", ";
        }
        $array_id_tmp = substr($array_id_tmp, 0, strlen($array_id_tmp)-2);


        //WHERE������
        $where_sql .= "WHERE \n";
        if($group_kind == "2"){
            //ľ��
            $where_sql .= "    shop_id IN (".Rank_Sql().") \n";
        }else{
            //FC�ʼ��ҽ�󡢤ޤ��ϼ�ʬ����������ɼ��
            $where_sql .= "    ( \n";
            $where_sql .= "        shop_id = $shop_id \n";
            $where_sql .= "        OR \n";
            $where_sql .= "        act_id = $shop_id \n";
            $where_sql .= "    ) \n";
        }
        $where_sql .= "    AND \n";
        $where_sql .= "    aord_id IN ($array_id_tmp) \n";
        $where_sql .= "    AND \n";
        $where_sql .= "    confirm_flg = false \n";         //�����ꤷ�Ƥ��ʤ�
        $where_sql .= "    AND \n";
        $where_sql .= "    trust_confirm_flg = false \n";   //��Ԥ���𤷤Ƥ��ʤ�
        $where_sql .= "    AND \n";
        $where_sql .= "    del_flg = false \n";             //�����ɼ����ʤ�


        Db_Query($db_con, "BEGIN;");

        //�����оݤη���������
        $sql  = "SELECT \n";
        $sql .= "    COUNT(*) \n";
        $sql .= "FROM \n";
        $sql .= "    t_aorder_h \n";
        $sql .= $where_sql;
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        //�����оݤ�0��ξ��
        if(pg_fetch_result($result, 0, 0) == 0){
            $lump_change_comp_mess = "����������оݤ�ͽ��ǡ���������ޤ���";
            Db_Query($db_con, "ROLLBACK;");

        //�����оݤ�������
        }else{

            //�оݤ�ͽ��ǡ����򹹿�
            $sql  = "UPDATE \n";
            $sql .= "    t_aorder_h \n";
            $sql .= "SET \n";
            $sql .= "    ord_time = '$lump_change_date', \n";       //ͽ������
            $sql .= "    arrival_day = '$lump_change_date', \n";    //������
            $sql .= "    change_flg = true, \n";                    //�������ѹ��ե饰
            $sql .= "    slip_flg = false, \n";                     //��ɼ���ϥե饰
            $sql .= "    slip_out_day = NULL, \n";                  //�����ɼ������
            $sql .= "    ord_staff_id = ".$_SESSION["staff_id"].", \n";                     //���ڥ졼��ID
            $sql .= "    ord_staff_name = '".addslashes($_SESSION["staff_name"])."', \n";   //���ڥ졼��̾
            $sql .= "    ship_chk_cd = NULL \n";                    //�ѹ������å�������
            $sql .= $where_sql;
            $sql .= ";";
//print_array($sql);

            $result = Db_Query($db_con, $sql);





            #2010-01-23 hashimoto-y
            #�����إå��ξ����ǳ��ѹ��������ɲ�
            #ͽ���������ѹ������ǡ�����shop_id��client_id���������
            $count = count($aord_id);
            for($i=0; $i<$count; $i++){

                #�����إå��Υ���å�ID
                #�����إå��Υ��饤�����ID
                $aorder_h_shop_id   = NULL;
                $aorder_h_client_id = NULL;


               //�����оݤ�shop_id,client_id���
                $sql  = "SELECT \n";
                $sql .= "    shop_id, \n";
                $sql .= "    client_id \n";
                $sql .= "FROM \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "WHERE \n";
                $sql .= "    aord_id = ".$aord_id[$i];
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                $aorder_h_shop_id    = pg_fetch_result($result, 0, "shop_id");
                $aorder_h_client_id  = pg_fetch_result($result, 0, "client_id");


                #���������Ѥ��뤿�����ID��shop_id�����������������ƣä������о����դˤ����������Ψ���������
                #��Ψ���饹�����󥹥�������
                $tax_rate_obj = new TaxRate($aorder_h_shop_id);

                $tax_rate_obj->setTaxRateDay($lump_change_date);

                $tax_num = $tax_rate_obj->getClientTaxRate($aorder_h_client_id);


                #�����ǳۥ��饹�����󥹥�������
                $tax_amount_obj = new TaxAmount();

                #�ѹ��������ID��getAorderTaxAmount�᥽�åɤ��Ϥ������ǳۤ�׻�
                $tax_amount = $tax_amount_obj->getAorderTaxAmount($tax_num, $aord_id[$i]);

                #�����إå��ξ����ǳ۹���
                $sql  = "UPDATE t_aorder_h SET ";
                $sql .= "    tax_amount = ".$tax_amount;
                $sql .= "WHERE ";
                $sql .= "    aord_id = ".$aord_id[$i].";";
                $result = Db_Query($db_con, $sql);

            }



            if($result == false){
                $lump_change_comp_mess = "��������Ǥ��ޤ���Ǥ�����";
                Db_Query($db_con, "ROLLBACK;");
            }else{
                $lump_change_comp_mess = "����������ޤ�����";
                Db_Query($db_con, "COMMIT;");
            }

        }

    }//�����ޤǰ����������


    $lump_con_data["hdn_lump_change"]   = "";   //��������ܥ��󲡲��ե饰������

    $lump_con_data["hdn_slip_del"]  = "";       //����ܥ��󲡲��ե饰������
    $lump_con_data["hdn_confirm"]   = "";       //����ܥ��󲡲����˥��åȤ�������ID������
    $lump_con_data["hdn_report"]    = "";       //���ܥ��󲡲����˥��åȤ�������ID������
    $lump_con_data["hdn_accept"]    = "";       //��ǧ�ܥ��󲡲����˥��åȤ�������ID������
    $form->setConstants($lump_con_data);

    $_POST["hdn_confirm"]   = "";       //POST�γ���ܥ��������
    $_POST["hdn_report"]    = "";       //POST�����ܥ��������
    $_POST["hdn_accept"]    = "";       //POST�ξ�ǧ�ܥ��������

}


/*****************************/
//����ܥ��󲡲���
/*****************************/
if($_POST["hdn_slip_del"] != null){
    $array_tmp = explode(",", $_POST["hdn_slip_del"]);
    $del_line       = $array_tmp[0];        //�����ܤ���ɼ�������롩
    $del_aord_id    = $array_tmp[1];        //����������ID
    $to_ware_id     = $_POST["back_ware"][$del_line];   //��ư����Ҹ�ID

    //�оݤ���ɼ�ξ�������
    $sql  = "SELECT \n";
    $sql .= "    confirm_flg, \n";
    $sql .= "    trust_confirm_flg, \n";
    $sql .= "    move_flg, \n";
    $sql .= "    contract_div \n";
    $sql .= "FROM \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "WHERE \n";
    $sql .= "    aord_id = $del_aord_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);

    $chk_confirm_flg        = pg_fetch_result($result, 0, "confirm_flg");       //����ե饰����ԤΤȤ��Ͼ�ǧ��
    $chk_trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg"); //������ե饰
    $chk_move_flg           = pg_fetch_result($result, 0, "move_flg");          //����ͽ��вٺѥե饰
    $contract_div           = pg_fetch_result($result, 0, "contract_div");      //�����ʬ

    //���顼�����å�
    $error_flg = false;

    //����ͽ��вٺѤǡ�
    //�����ҽ��
    //������饤����ԤǼ��������
    //�ξ�硢�߸˰�ư���Ҹ˻��ꥻ�쥯�Ȥ�ɬ�ܥ����å�
    if($chk_move_flg == "t" &&
        ($contract_div == "1" || ($contract_div == "2" && $group_kind != "2"))
    ){
        $form->addRule("back_ware[$del_line]", "�߸ˤ��ֵѤ����Ҹˤ���ꤷ�Ƥ���������", "required");
    }

    //��������å�
    //���ҽ��ξ��
    if($contract_div == "1" && $chk_confirm_flg == "t"){
        $form->setElementError("del_err_mess", "��ɼ�������ꤵ��Ƥ��뤿�ᡢ����Ǥ��ޤ���");
        $error_flg = true;
    //����饤����Ԥ�ľ�ġ��ޤ��ϥ��ե饤����Ԥξ��
    }elseif(($contract_div == "2" || $contract_div == "3") && $chk_confirm_flg == "t"){
        $form->setElementError("del_err_mess", "��ɼ�����ǧ����Ƥ��뤿�ᡢ����Ǥ��ޤ���");
        $error_flg = true;
    //����饤����Ԥ�FC�����������夲�����
    }elseif($contract_div == "2" && $chk_trust_confirm_flg == "t"){
        $form->setElementError("del_err_mess", "��ɼ�������𤵤�Ƥ��뤿�ᡢ����Ǥ��ޤ���");
        $error_flg = true;
    }


    //���顼����ʤ���硢���������������
    if($form->validate() && $error_flg != true){
        Db_Query($db_con, "BEGIN;");

        //����ե饰��true��
        $sql = "UPDATE t_aorder_h SET del_flg = true WHERE aord_id = $del_aord_id;";
        $result = Db_Query($db_con, $sql);
        if($result == false){
            Db_Query($db_con, "ROLLBACK;");
            exit();
        }

        //��ʧ��ä�
        $sql = "DELETE FROM t_stock_hand WHERE aord_d_id IN (SELECT aord_d_id FROM t_aorder_d WHERE aord_id = $del_aord_id);";
        $result = Db_Query($db_con, $sql);
        if($result == false){
            Db_Query($db_con, "ROLLBACK;");
            exit();
        }

        //�ֵ��Ҹˤ������硢��ư�Ѥ߾��ʤ��᤹
        if($_POST["back_ware"][$del_line] != null){

            //��ư����ô�����Ҹ�ID�����
            $sql = "SELECT staff_id FROM t_aorder_staff WHERE aord_id = $del_aord_id AND staff_div = '0';";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }
            $from_ware_id = Get_Staff_Ware_Id($db_con, pg_fetch_result($result, "staff_id"));


            //�и��ʥơ��֥뤫���᤹���ʤ����
            $sql  = "SELECT aord_d_id, goods_id, num \n";
            $sql .= "FROM t_aorder_ship \n";
            $sql .= "WHERE aord_d_id IN ( \n";
            $sql .= "    SELECT aord_d_id FROM t_aorder_d WHERE aord_id = $del_aord_id \n";
            $sql .= ");";

            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }
            $stock_hand_data = Get_Data($result, 3);

            $stock_hand_data_count = pg_num_rows($result);
            for($i=0; $i<$stock_hand_data_count; $i++){
                //ô���Ҹˤ���и�
                $sql  = "INSERT INTO t_stock_hand ( ";
                $sql .= "    goods_id, ";
                $sql .= "    enter_day, ";
                $sql .= "    work_day, ";
                $sql .= "    work_div, ";
                $sql .= "    ware_id, ";
                $sql .= "    io_div, ";
                $sql .= "    num, ";
                $sql .= "    aord_d_id, ";
                $sql .= "    staff_id, ";
                $sql .= "    shop_id ";
                $sql .= ") VALUES ( ";
                $sql .= "    ".$stock_hand_data[$i][1].", ";
                $sql .= "    CURRENT_TIMESTAMP, ";
                $sql .= "    CURRENT_TIMESTAMP, ";
                $sql .= "    '5', ";
                $sql .= "    ".$from_ware_id.", ";
                $sql .= "    '2', ";
                $sql .= "    ".$stock_hand_data[$i][2].", ";
                $sql .= "    ".$stock_hand_data[$i][0].", ";
                $sql .= "    ".$_SESSION["staff_id"].", ";
                $sql .= "    ".$_SESSION["client_id"]." ";
                $sql .= "); ";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

                //�����Ҹˤ�����
                $sql  = "INSERT INTO t_stock_hand ( ";
                $sql .= "    goods_id, ";
                $sql .= "    enter_day, ";
                $sql .= "    work_day, ";
                $sql .= "    work_div, ";
                $sql .= "    ware_id, ";
                $sql .= "    io_div, ";
                $sql .= "    num, ";
                $sql .= "    aord_d_id, ";
                $sql .= "    staff_id, ";
                $sql .= "    shop_id ";
                $sql .= ") VALUES ( ";
                $sql .= "    ".$stock_hand_data[$i][1].", ";
                $sql .= "    CURRENT_TIMESTAMP, ";
                $sql .= "    CURRENT_TIMESTAMP, ";
                $sql .= "    '5', ";
                $sql .= "    ".$to_ware_id.", ";
                $sql .= "    '1', ";
                $sql .= "    ".$stock_hand_data[$i][2].", ";
                $sql .= "    ".$stock_hand_data[$i][0].", ";
                $sql .= "    ".$_SESSION["staff_id"].", ";
                $sql .= "    ".$_SESSION["client_id"]." ";
                $sql .= "); ";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }
            }
        }

        Db_Query($db_con, "COMMIT;");


        //����ID�������ͤ�ʤ���
        $aord_id_tmp = array();
        foreach($aord_id as $value){
            if($value != $del_aord_id){
                $aord_id_tmp[] = $value;
            }
        }
        $aord_id = $aord_id_tmp;

        //ɽ������ͽ��ǡ�����0��ˤʤä����ϡ����顼��å������β������ܥ����ɽ������
        $modoru_disp_flg = (count($aord_id) == 0) ? true : false;

        $del_comp_mess = "������ޤ�����";      //��λ��å�����

    //���顼�ξ��
    }else{
        $form->addElement("text", "del_err_mess");

        $modoru_disp_flg = false;               //���ܥ����ɽ�����ʤ�
        $del_comp_mess = null;                  //��λ��å�����
    }

    $del_con_data["hdn_slip_del"]   = "";       //����ܥ��󲡲��ե饰������
    $del_con_data["hdn_confirm"]    = "";       //����ܥ��󲡲����˥��åȤ�������ID������
    $del_con_data["hdn_report"]     = "";       //���ܥ��󲡲����˥��åȤ�������ID������
    $del_con_data["hdn_accept"]     = "";       //��ǧ�ܥ��󲡲����˥��åȤ�������ID������
    $form->setConstants($del_con_data);

    $_POST["hdn_confirm"]   = "";       //POST�γ���ܥ��������
    $_POST["hdn_report"]    = "";       //POST�����ܥ��������
    $_POST["hdn_accept"]    = "";       //POST�ξ�ǧ�ܥ��������
}


/*****************************/
//����ܥ��󲡲���
/*****************************/
if($_POST["hdn_confirm"] != null || $_POST["warn_confirm_flg"] == true){
    $aord_array[0] = $_POST["hdn_confirm"];             //���ꤹ�����ID

    require(INCLUDE_DIR."fc_sale_confirm.inc");

    if($move_warning == null){
        $confirm_con_data["hdn_confirm"]    = "";       //����ܥ��󲡲����˥��åȤ�������ID������
    }
    $confirm_con_data["hdn_slip_del"]       = "";       //����ܥ��󲡲��ե饰������
    $confirm_con_data["hdn_report"]         = "";       //���ܥ��󲡲����˥��åȤ�������ID������
    $form->setConstants($confirm_con_data);

    $_POST["hdn_slip_del"]  = "";       //POST�κ���ܥ��������
}


/****************************/
//���ܥ��󲡲�����
/****************************/
if($_POST["hdn_report"] != null || $_POST["warn_report_flg"] == true){
    $aord_array[0] = $_POST["hdn_report"];              //��𤹤����ID

    require(INCLUDE_DIR."fc_sale_report.inc");

    if($move_warning == null){
        $repo_con_data["hdn_report"]        = "";       //���ܥ��󲡲����˥��åȤ�������ID������
    }
    $repo_con_data["hdn_slip_del"]          = "";       //����ܥ��󲡲��ե饰������
    $repo_con_data["hdn_confirm"]           = "";       //����ܥ��󲡲����˥��åȤ�������ID������
    $form->setConstants($repo_con_data);

    $_POST["hdn_slip_del"]  = "";       //POST�κ���ܥ��������
}


/****************************/
//��ǧ�ܥ��󲡲�����
/****************************/
if($_POST["hdn_accept"] != null || $_POST["warn_accept_flg"] == true){
    $aord_array[0] = $_POST["hdn_accept"];              //��ǧ�������ID

    require(INCLUDE_DIR."fc_sale_accept.inc");

    $accept_con_data["hdn_accept"]          = "";       //��ǧ�ܥ��󲡲����˥��åȤ�������ID������
    $accept_con_data["hdn_slip_del"]        = "";       //����ܥ��󲡲��ե饰������
    $form->setConstants($accept_con_data);

    $_POST["hdn_slip_del"]  = "";       //POST�κ���ܥ��������
}


/*****************************/
//���٥ǡ����������
/*****************************/
//��ɼʬ�������
for($s=0;$s<count($aord_id);$s++){

    /****************************/
    //�����إå����SQL
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    t_aorder_h.ord_no,";                     //��ɼ�ֹ�0
    $sql .= "    t_aorder_h.ord_time,";                   //ͽ������1
    $sql .= "    t_aorder_h.route,";                      //��ϩ2
    $sql .= "    t_aorder_h.client_cd1,";                 //������cd13
    $sql .= "    t_aorder_h.client_cd2,";                 //������cd24
    $sql .= "    t_aorder_h.client_cname,";               //������̾5
    $sql .= "    CASE t_aorder_h.trade_id";               //�����ʬ6
    $sql .= "        WHEN '11' THEN '�����'";
    $sql .= "        WHEN '13' THEN '������'";
    $sql .= "        WHEN '14' THEN '���Ͱ�'";
    $sql .= "        WHEN '61' THEN '�������'";
    $sql .= "        WHEN '63' THEN '��������'";
    $sql .= "        WHEN '64' THEN '�����Ͱ�'";
    $sql .= "    END,";                       
    $sql .= "    t_aorder_h.hope_day,";                   //���׾���7
    $sql .= "    t_aorder_h.arrival_day,";                //������8
    $sql .= "    '1:' || t_staff1.staff_name || "; //ô���ԣ������Ψ��9
    $sql .= "    '(' || t_staff1.sale_rate || '%)',"; 
    $sql .= "    '2:' || t_staff2.staff_name || "; //ô���ԣ������Ψ��10
    $sql .= "    '(' || t_staff2.sale_rate || '%)',"; 
    $sql .= "    '3:' || t_staff3.staff_name || "; //ô���ԣ������Ψ��11
    $sql .= "    '(' || t_staff3.sale_rate || '%)',"; 
    $sql .= "    '4:' || t_staff4.staff_name || "; //ô���ԣ������Ψ��12
    $sql .= "    '(' || t_staff4.sale_rate || '%)',"; 
    $sql .= "    t_aorder_h.net_amount, ";                //���ʹ��13
    $sql .= "    t_aorder_h.tax_amount, ";                //������14
    $sql .= "    t_aorder_h.reason_cor,";                 //������ͳ15
    $sql .= "    t_aorder_h.aord_id, ";                   //����ID 16
    $sql .= "    t_aorder_h.client_id,";                  //������ID 17
    $sql .= "    t_aorder_h.confirm_flg,";                //����ե饰 18
    $sql .= "    t_aorder_h.act_id, ";                    //�����ID19
    $sql .= "    t_aorder_h.contract_div,";               //�����ʬ20
    $sql .= "    t_aorder_h.trust_confirm_flg, ";         //����ե饰(������) 21
    //$sql .= "    t_aorder_h.reserve_del_flg ";            //��α��ɼ����ե饰 22
    $sql .= "    t_aorder_h.del_flg, ";                     //����ե饰 22
    $sql .= "    t_aorder_h.move_flg, ";                    //����ͽ��в٤Ǻ߸˰�ư�ѥե饰 23
    $sql .= "    t_aorder_h.note, ";                        //���� 24
    $sql .= "    t_aorder_h.trust_note, ";                  //���͡ʼ������ѡ� 25
    $sql .= "    t_aorder_h.intro_account_id, ";            //�Ҳ��ID 26
    $sql .= "    t_aorder_h.intro_ac_cd1, ";                //�Ҳ��CD1 27
    $sql .= "    t_aorder_h.intro_ac_cd2, ";                //�Ҳ��CD2 28
    $sql .= "    t_aorder_h.intro_ac_name, ";               //�Ҳ��̾ 29
    $sql .= "    t_aorder_h.intro_ac_div, ";                //�Ҳ���¶�ʬ 30
    $sql .= "    t_aorder_h.intro_amount, ";                //�Ҳ���¶�� 31
    $sql .= "    t_aorder_h.act_div, ";                     //�������ʬ 32
    $sql .= "    t_aorder_h.act_request_rate, ";            //������ʡ��33
    $sql .= "    t_aorder_h.act_request_price, ";           //������ʸ���ۡ�34
    $sql .= "    t_aorder_h.trust_net_amount, ";            //����ۡʼ������35
    $sql .= "    t_aorder_h.trust_tax_amount, ";            //�����ǳۡʼ������36
    $sql .= "    t_aorder_h.act_cd1, ";                     //��Լ�CD1 37
    $sql .= "    t_aorder_h.act_cd2, ";                     //��Լ�CD2 38
    $sql .= "    t_aorder_h.act_name, ";                    //��Լ�̾ 39
    $sql .= "    t_aorder_h.hand_plan_flg, ";               //ͽ����ե饰 40
    $sql .= "    t_aorder_h.direct_id, ";                   //ľ����ID 41
    $sql .= "    t_direct.direct_cd, ";                     //ľ����CD 42
    $sql .= "    t_direct.direct_cname, ";                  //ľ����̾��ά�Ρ� 43
    $sql .= "    t_d_claim.client_cname, ";                 //ľ�����������̾��ά�Ρ� 44
    $sql .= "    t_aorder_h.claim_div, ";                   //�������ʬ 45
    $sql .= "    t_aorder_h.advance_offset_totalamount ";   //�����껦�۹�� 46

    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
    $sql .= "    LEFT JOIN t_direct ON t_aorder_h.direct_id = t_direct.direct_id ";
    $sql .= "    LEFT JOIN t_client AS t_d_claim ON t_direct.client_id = t_d_claim.client_id ";

    $sql .= "    LEFT JOIN ";
    $sql .= "        (SELECT ";
    $sql .= "             t_aorder_staff.aord_id,";
    $sql .= "             t_aorder_staff.staff_name,";
    $sql .= "             t_aorder_staff.sale_rate ";
    $sql .= "         FROM ";
    $sql .= "             t_aorder_staff ";
    $sql .= "         WHERE ";
    $sql .= "             t_aorder_staff.staff_div = '0'";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/25��02-015��������suzuki-t�������Ψ�������ô����ɽ��
 *
    $sql .= "         AND \n";
    $sql .= "             t_aorder_staff.sale_rate != '0'\n";
*/
    $sql .= "         AND \n";
    $sql .= "             t_aorder_staff.sale_rate IS NOT NULL\n";
    $sql .= "        )AS t_staff1 ON t_staff1.aord_id = t_aorder_h.aord_id ";
     
    $sql .= "    LEFT JOIN ";
    $sql .= "        (SELECT ";
    $sql .= "             t_aorder_staff.aord_id,";
    $sql .= "             t_aorder_staff.staff_name,";
    $sql .= "             t_aorder_staff.sale_rate ";
    $sql .= "         FROM ";
    $sql .= "             t_aorder_staff ";
    $sql .= "         WHERE ";
    $sql .= "             t_aorder_staff.staff_div = '1'";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/25��02-015��������suzuki-t�������Ψ�������ô����ɽ��
 *
    $sql .= "         AND \n";
    $sql .= "             t_aorder_staff.sale_rate != '0'\n";
*/
    $sql .= "         AND \n";
    $sql .= "             t_aorder_staff.sale_rate IS NOT NULL\n";
    $sql .= "        )AS t_staff2 ON t_staff2.aord_id = t_aorder_h.aord_id ";

    $sql .= "    LEFT JOIN ";
    $sql .= "        (SELECT ";
    $sql .= "             t_aorder_staff.aord_id,";
    $sql .= "             t_aorder_staff.staff_name,";
    $sql .= "             t_aorder_staff.sale_rate ";
    $sql .= "         FROM ";
    $sql .= "             t_aorder_staff ";
    $sql .= "         WHERE ";
    $sql .= "             t_aorder_staff.staff_div = '2'";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/25��02-015��������suzuki-t�������Ψ�������ô����ɽ��
 *
    $sql .= "         AND \n";
    $sql .= "             t_aorder_staff.sale_rate != '0'\n";
*/
    $sql .= "         AND \n";
    $sql .= "             t_aorder_staff.sale_rate IS NOT NULL\n";
    $sql .= "        )AS t_staff3 ON t_staff3.aord_id = t_aorder_h.aord_id ";

    $sql .= "    LEFT JOIN ";
    $sql .= "        (SELECT ";
    $sql .= "             t_aorder_staff.aord_id,";
    $sql .= "             t_aorder_staff.staff_name,";
    $sql .= "             t_aorder_staff.sale_rate ";
    $sql .= "         FROM ";
    $sql .= "             t_aorder_staff ";
    $sql .= "         WHERE ";
    $sql .= "             t_aorder_staff.staff_div = '3'";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/25��02-015��������suzuki-t�������Ψ�������ô����ɽ��
 *
    $sql .= "         AND \n";
    $sql .= "             t_aorder_staff.sale_rate != '0'\n";
*/
    $sql .= "         AND \n";
    $sql .= "             t_aorder_staff.sale_rate IS NOT NULL\n";
    $sql .= "        )AS t_staff4 ON t_staff4.aord_id = t_aorder_h.aord_id ";

    $sql .= "WHERE ";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-017��������suzuki-t����������֤˴ط��ʤ�������ɽ��
 *
    $sql .= "    t_client.state = '1' ";
    $sql .= "AND ";
*/
    $sql .= "    t_aorder_h.aord_id = ".$aord_id[$s]." \n";
    $sql .= ";";
//print($sql);

    $result = Db_Query($db_con,$sql);
    $h_data_list[$s] = Get_Data($result);

    //FC¦�������ɼɽ��Ƚ��
    //if($h_data_list[$s][0][19] != NULL && $group_kind == 3){
    //FC�ϥ��ե饤����Ԥ򸫤��ʤ�����
    if($h_data_list[$s][0][19] != NULL && $h_data_list[$s][0][20] == "2" && $group_kind == 3){
        //�ƣ�¦�Υ���饤�������ɼ

        /****************************/
        //������Ƚ��ؿ�
        /****************************/
        Injustice_check($db_con,"a_trust",$aord_id[$s],$client_id);
    }else{
        //�̾���ɼ�����ե饤�������ɼ��ľ��¦�Υ���饤�������ɼ

        /****************************/
        //������Ƚ��ؿ�
        /****************************/
        Injustice_check($db_con,"aorder",$aord_id[$s],$client_id);
    }

    /****************************/
    //�����衦����������
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    t_client.client_cname,";    //������̾
    $sql .= "    t_aorder_h.round_form,";    //������
    $sql .= "    t_client.client_cd1 || '-' || t_client.client_cd2 ";    //������CD 
    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.claim_id ";
    $sql .= "WHERE ";
    $sql .= "    t_aorder_h.aord_id = ".$aord_id[$s].";";
    $result = Db_Query($db_con,$sql);
    $con_data_list[$s] = Get_Data($result);

    //--------------------------//
    //�Ҳ���¼���
    //--------------------------//
    if($h_data_list[$s][0][26] != null){
        $sql = "SELECT client_div FROM t_client WHERE client_id = ".$h_data_list[$s][0][26].";";
        $result = Db_Query($db_con, $sql);
        //�Ҳ�Ԥ�������ξ��
        if(pg_fetch_result($result, 0, "client_div") == "2"){
            $h_data_list[$s][0][27] = $h_data_list[$s][0][27];
        //FC�ξ�硢������1�˥�����2�򤯤äĤ���
        }else{
            $h_data_list[$s][0][27] = $h_data_list[$s][0][27]."-".$h_data_list[$s][0][28];
        }
    }


    /****************************/
    //�����ǡ������SQL
    /****************************/
    $data_sql  = "SELECT ";
    $data_sql .= "    CASE t_aorder_d.sale_div_cd ";     //�����ʬ
    $data_sql .= "         WHEN '01' THEN '��ԡ���'";
    $data_sql .= "         WHEN '02' THEN '����'";
    $data_sql .= "         WHEN '03' THEN '��󥿥�'";
    $data_sql .= "         WHEN '04' THEN '�꡼��'";
    $data_sql .= "         WHEN '05' THEN '����'";
    $data_sql .= "         WHEN '06' THEN '����¾'";
    $data_sql .= "    END,";
    $data_sql .= "    CASE t_aorder_d.serv_print_flg ";  //�����ӥ�����
    $data_sql .= "         WHEN 't' THEN '��'";
    $data_sql .= "         WHEN 'f' THEN '��'";
    $data_sql .= "    END,";
    $data_sql .= "    t_aorder_d.serv_cd,";              //�����ӥ�cd
    $data_sql .= "    t_aorder_d.serv_name,";            //�����ӥ�̾
    $data_sql .= "    CASE t_aorder_d.goods_print_flg "; //�����ƥ����
    $data_sql .= "         WHEN 't' THEN '��'";
    $data_sql .= "         WHEN 'f' THEN '��'";
    $data_sql .= "    END,";                        

    $data_sql .= "    t_aorder_d.goods_cd,";             //�����ƥ�cd
    $data_sql .= "    t_aorder_d.goods_name,";           //�����ƥ�̾

    $data_sql .= "    t_aorder_d.set_flg,";              //�켰�ե饰
    $data_sql .= "    t_aorder_d.num,";                  //�����ƥ��

    $data_sql .= "    t_aorder_d.sale_price,";          //���ñ��
    $data_sql .= "    t_aorder_d.sale_amount,";         //�����

    $data_sql .= "    t_aorder_d.egoods_cd,";            //������cd
    $data_sql .= "    t_aorder_d.egoods_name,";          //������̾
    $data_sql .= "    t_aorder_d.egoods_num,";           //�����ʿ�

    $data_sql .= "    t_aorder_d.rgoods_cd,";            //����cd
    $data_sql .= "    t_aorder_d.rgoods_name,";          //����̾
    $data_sql .= "    t_aorder_d.rgoods_num,";           //���ο�

    $data_sql .= "    t_aorder_d.aord_d_id,";            //�����ǡ���ID 17
    $data_sql .= "    t_aorder_d.aord_id, ";             //����ID 18

    $data_sql .= "    t_aorder_d.contract_id, ";         //����ID 19

    //FC¦�������ɼɽ��Ƚ��
    if($h_data_list[$s][0][19] != NULL && $group_kind == 3){
        $data_sql .= "    t_aorder_d.trust_cost_price, ";   //�Ķȸ���(������) 20
        $data_sql .= "    t_aorder_d.trust_cost_amount, ";  //�Ķȶ��(������) 21
    }else{
        $data_sql .= "    t_aorder_d.cost_price,";           //�Ķȸ��� 20
        $data_sql .= "    t_aorder_d.cost_amount, ";         //�Ķȶ�� 21
    }

    $data_sql .= "    t_aorder_d.official_goods_name, ";    //�����ƥ�̾��������22
    $data_sql .= "    t_aorder_d.account_price, ";          //�Ҳ����ñ�� 23
    $data_sql .= "    t_aorder_d.account_rate, ";           //�Ҳ����Ψ 24
    $data_sql .= "    t_aorder_d.advance_flg, ";            //�����껦�ե饰 25
    //aoyama-n 2009-09-18
    #$data_sql .= "    t_aorder_d.advance_offset_amount ";   //�����껦�� 26
    $data_sql .= "    t_aorder_d.advance_offset_amount, ";   //�����껦�� 26
    $data_sql .= "    t_goods.discount_flg ";                //�Ͱ��ե饰 27

    $data_sql .= "FROM ";
    $data_sql .= "    t_aorder_d ";
    $data_sql .= "    INNER JOIN t_aorder_h ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
    //aoyama-n 2009-09-18
    $data_sql .= "    LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id ";

    $data_sql .= "WHERE ";
    $data_sql .= "    t_aorder_d.aord_id = ".$aord_id[$s];

    $data_sql .= " ORDER BY ";
    $data_sql .= "    t_aorder_d.line;";

    $result = Db_Query($db_con,$data_sql);
    $data_list[$s] = Get_Data($result);

    //�����å�ID�����ꤵ��Ƥ�����Τߥ�����̾ɽ��
    //if($staff_id != NULL){
        /****************************/
        //������̾����
        /****************************/
        //$course_data[$s] = Course_Id_Get($db_con,$data_list[$s][0][19],$staff_id,$client_id);
    //}
}

/****************************/
//�إå����ǡ��������ɽ�������ѹ�
/****************************/
//����ID���ꥢ�饤����
$array_id = serialize($aord_id);
$array_id = urlencode($array_id);

for($i=0;$i<count($h_data_list);$i++){

    //��ϩ����Ƚ��
    if($h_data_list[$i][0][2] != NULL){
        //��ϩ�����ѹ�
        $h_data_list[$i][0][2] = str_pad($h_data_list[$i][0][2], 4, 0, STR_POS_LEFT); //��ϩ
        $route1         = substr($h_data_list[$i][0][2],0,2);  
        $route2         = substr($h_data_list[$i][0][2],2,2);  
        $h_data_list[$i][0][2] = $route1."-".$route2;
    }else{
        $h_data_list[$i][0][2] = "�� ��";
    }

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/14��02-063��������kajioka-h ����ɼ���ѹ��ܥ����ɽ��Ƚ���ѹ�����α������줿��ɽ�����ʤ��褦�ˡ�
 *
*/
/*
    //���ҽ�󡦥��ե饤����Ԥǳ��ꤷ�Ƥ��ʤ�������饤����ԤǼ����褬��𤷤Ƥ��ʤ������Τ����������ܲ�
    if(
        (
            ($h_data_list[$i][0][20] != "2" && $h_data_list[$i][0][18] == 'f') || ($h_data_list[$i][0][20] == "2" && $h_data_list[$i][0][21] == 'f')
        ) && $h_data_list[$i][0][22] != "t"
    ){
*/
    //ľ�Ĥϳ��ꤷ�Ƥ��ʤ���
    //FC�ϼ��ҽ��ǳ��ꤷ�Ƥ��ʤ����ޤ��ϥ���饤����Ԥ���𤷤Ƥ��ʤ���
    //���ĺ����ɼ����ʤ������Τ����������ܲ�
    if(
        (
            ($group_kind == "2" && $h_data_list[$i][0][18] == "f") ||
            ($group_kind != "2" && 
                ($h_data_list[$i][0][20] != "2" && $h_data_list[$i][0][18] == "f") || ($h_data_list[$i][0][20] == "2" && $h_data_list[$i][0][21] == "f") 
            )
        ) && $h_data_list[$i][0][22] != "t" 
    ){
        //ͽ����ɼ���������ܥܥ���
        if($h_data_list[$i][0][40] == "f"){
            $form->addElement("button","slip_change[$i]","��ɼ���ѹ�","onClick=\"Submit_Page2('".FC_DIR."sale/2-2-107.php?aord_id=".$h_data_list[$i][0][16]."&back_display=$back_display&aord_id_array=$array_id');\"");
        }else{
            $form->addElement("button","slip_change[$i]","��ɼ���ѹ�","onClick=\"Submit_Page2('".FC_DIR."sale/2-2-118.php?aord_id=".$h_data_list[$i][0][16]."&back_display=$back_display&aord_id_array=$array_id');\"");
        }
    }

    //���Ƚ��
    if($h_data_list[$i][0][19] != NULL && $group_kind == 3){
        //��԰�������ܥܥ���
        $form->addElement("button","con_change[$i]","����ޥ������ѹ�","onClick=\"location.href='".FC_DIR."system/2-1-239.php?aord_id=".$h_data_list[$i][0][16]."&aord_id_array=$array_id&get_flg=cal&back_display=$back_display'\"");
    }else{
        //����ޥ��������ܥܥ���
        $form->addElement("button","con_change[$i]","����ޥ������ѹ�","onClick=\"location.href='".FC_DIR."system/2-1-115.php?aord_id=".$h_data_list[$i][0][16]."&aord_id_array=$array_id&client_id=".$h_data_list[$i][0][17]."&get_flg=cal&back_display=$back_display'\"");
    }

    //������Ƥ��ʤ�������
    //�����ҽ�󡦥��ե饤����Ԥǳ��ꤷ�Ƥ��ʤ���
    //������饤����ԤǼ����褬��𤷤Ƥ��ʤ�
    //    ����ͽ��в٤��Ƥ�����ϼ�����Τߺ����ǽ
    //��硢����ܥ���
    if($h_data_list[$i][0][22] != "t" &&
        (
            ($h_data_list[$i][0][20] != "2" && $h_data_list[$i][0][18] == "f") || 
            ($h_data_list[$i][0][20] == "2" && $h_data_list[$i][0][21] == "f" && 
                (($group_kind == "2" && $h_data_list[$i][0][23] == "f") || $group_kind != "2")
            )
        )
    ){
        //����ܥ���
        $form->addElement("button", "slip_del[$i]", "���", " onClick=\"Dialogue_1('������ޤ���', '$i,".$h_data_list[$i][0][16]."', 'hdn_slip_del');\" $disabled");

        //����ͽ��вٺѤǡ�
        //�����ҽ��
        //������饤����ԤǼ��������
        //�ξ�硢�߸˰�ư���Ҹ˻��ꥻ�쥯��
        if($h_data_list[$i][0][23] == "t" &&
            ($h_data_list[$i][0][20] == "1" || ($h_data_list[$i][0][20] == "2" && $group_kind != "2"))
        ){
            $ware_where  = " WHERE ";
            if($group_kind == "2"){
                $ware_where .= "    shop_id IN (".Rank_Sql().") ";
            }else{
                $ware_where .= "    shop_id = ".$_SESSION["client_id"]." ";
            }
            $ware_where .= " AND ";
            $ware_where .= "    staff_ware_flg = false ";
            $ware_where .= " AND ";
            $ware_where .= "    nondisp_flg = false ";

            $select_value = Select_Get($db_con, 'ware', $ware_where);
            $form->addElement("select", "back_ware[$i]", '���쥯�ȥܥå���', $select_value, "onkeydown=\"chgKeycode();\" $g_form_option_select");
        }
    }

    //��ɼ�ֹ����ֺѤǳ��ꤷ�Ƥ��ʤ��ƺ�����Ƥ��ʤ��ơ����ҽ��Τߡ�����ܥ���
    if($h_data_list[$i][0][0] != null && $h_data_list[$i][0][20] == "1" && $h_data_list[$i][0][18] == 'f' && $h_data_list[$i][0][22] != "t"){
        //����ܥ���
        $form->addElement("button", "confirm[$i]", "�Ρ���", " onClick=\"Dialogue_1('���ꤷ�ޤ���', '".$h_data_list[$i][0][16]."', 'hdn_confirm');\" $disabled");
    }

    //��ɼ�ֹ����ֺѤ���𤷤Ƥ��ʤ��ƺ�����Ƥ��ʤ��ơ�����饤����Ԥμ���¦�Τߡ����ܥ���
    if($h_data_list[$i][0][0] != null && $h_data_list[$i][0][20] != "1" && $h_data_list[$i][0][21] == 'f' && $h_data_list[$i][0][22] != "t" && $group_kind != "2"){
        //���ܥ���
        $form->addElement("button", "report[$i]", "�󡡹�", " onClick=\"Dialogue_1('��𤷤ޤ���', '".$h_data_list[$i][0][16]."', 'hdn_report');\" $disabled");
    }

    //��ɼ�ֹ����ֺѤǳ��ꤷ�Ƥ��ʤ��ƺ�����Ƥ��ʤ��ư���¦�ǡ�����饤����Ԥʤ����Ѥǥ��ե饤����Ԥʤ��äˤʤ��Τߡ���ǧ�ܥ���
    if($h_data_list[$i][0][0] != null && $h_data_list[$i][0][18] == "f" && $h_data_list[$i][0][22] != "t" && $group_kind == "2" && (($h_data_list[$i][0][20] == "2" && $h_data_list[$i][0][21] == "t") || $h_data_list[$i][0][20] == "3")){
        //��ǧ�ܥ���
        $form->addElement("button", "accept[$i]", "����ǧ", " onClick=\"Dialogue_1('��ǧ���ޤ���', '".$h_data_list[$i][0][16]."', 'hdn_accept');\" $disabled");
    }


    //���ô���������Ψɽ��Ƚ��
    for($c=9;$c<=12;$c++){
        //����Ƚ��
        if(!ereg("[0-9]",$h_data_list[$i][0][$c])){
            //�ͤ����Ϥ���Ƥ��ʤ����ϡ�NULL
            $h_data_list[$i][0][$c] = NULL;
        }else{
            //�ͤ����Ϥ���Ƥ�����ϡ��ᥤ��ʳ��ϲ��Ԥ��ɲ�
            if($c!=9){
                $h_data_list[$i][0][$c] = "<br>".$h_data_list[$i][0][$c];
            }
        }
    }

    //��ɼ��׷׻�����
    $h_data_list[$i][0][22] = $h_data_list[$i][0][13] + $h_data_list[$i][0][14];

    //��۷����ѹ�
    //��ȴ���
    $h_data_list[$i][0][13] = number_format($h_data_list[$i][0][13]);
    //������
    $h_data_list[$i][0][14] = number_format($h_data_list[$i][0][14]);
    //��ɼ���
    $h_data_list[$i][0][22] = number_format($h_data_list[$i][0][22]);
    //�Ҳ���
    $h_data_list[$i][0][31] = number_format($h_data_list[$i][0][31]);
    //������Ĺ�
    $h_data_list[$i][0][45] = number_format(Advance_Offset_Claim($db_con, $h_data_list[$i][0][1], $h_data_list[$i][0][17], $h_data_list[$i][0][45]));
    //�����껦�۹��
    $h_data_list[$i][0][46] = ($h_data_list[$i][0][46] != null) ? number_format($h_data_list[$i][0][46]) : null;

/*
    //����
    $h_data_list[$i][0][24] = nl2br($h_data_list[$i][0][24]);
    //���͡ʼ������
    $h_data_list[$i][0][25] = nl2br($h_data_list[$i][0][25]);
*/

    //������
    if($h_data_list[$i][0][32] == "1"){
        $h_data_list[$i][0][36] = "ȯ�����ʤ�";
    }elseif($h_data_list[$i][0][32] == "2"){
        $h_data_list[$i][0][36] = number_format($h_data_list[$i][0][34])."�ʸ���ۡ�";
    }elseif($h_data_list[$i][0][32] == "3"){
        $h_data_list[$i][0][36] = number_format($h_data_list[$i][0][35])."������".$h_data_list[$i][0][33]."���";
    }
    //������
    $h_data_list[$i][0][35] = $h_data_list[$i][0][37]."-".$h_data_list[$i][0][38]."<br>".$h_data_list[$i][0][39];

    //������
    $h_data_list[$i][0][32] = $con_data_list[$i][0][0];
    //������CD
    $h_data_list[$i][0][33] = $con_data_list[$i][0][2];
    //������
    $h_data_list[$i][0][34] = $con_data_list[$i][0][1];
    //������̾
    //$h_data_list[$i][0][27] = $course_data[$i][1];

    //ľ����̾
    $h_data_list[$i][0][34] = $con_data_list[$i][0][1];
}
//print_array($course_data);
// �֤�����
for ($i=0; $i<count($data_list); $i++){
    for ($j=0; $j<count($data_list[$i]); $j++){
        $data_list[$i][$j][8] = my_number_format($data_list[$i][$j][8]);
        $data_list[$i][$j][9] = my_number_format($data_list[$i][$j][9],2);
        $data_list[$i][$j][10] = my_number_format($data_list[$i][$j][10]);
        $data_list[$i][$j][13] = my_number_format($data_list[$i][$j][13]);
        $data_list[$i][$j][16] = my_number_format($data_list[$i][$j][16]);

        $data_list[$i][$j][20] = my_number_format($data_list[$i][$j][20],2);
        $data_list[$i][$j][21] = my_number_format($data_list[$i][$j][21]);
        $data_list[$i][$j][23] = my_number_format($data_list[$i][$j][23]);
        $data_list[$i][$j][26] = my_number_format($data_list[$i][$j][26]);

/*
        //��������Ƚ��
        $sql  = "SELECT aord_d_id FROM t_aorder_detail WHERE aord_d_id = ".$data_list[$i][$j][17].";";
        $result = Db_Query($db_con, $sql);
        $row_num = pg_num_rows($result);
        if(1 <= $row_num){
            //�������ɽ��
            $data_list[$i][$j][22] = true;
        }else{
            //���������ɽ��
            $data_list[$i][$j][22] = false;
        }
*/
    }
}

// �إå�������˿��Ѥ�
for ($i=0; $i<count($h_data_list); $i++){
    $h_data_list[$i][0][23] = (bcmod($i, 2) == 0) ? "Result1" : "Result2";
    
    //���Ƚ��
    if($h_data_list[$i][0][20] != '1'){
        //���
        $h_data_list[$i][0][23] = "Result6";
        $color_flg = true; //��Ԥξ�硢�ǡ����⿧�ѹ�
    }

    // �ǡ���������˿��Ѥ�
    for ($j=0; $j<count($data_list[$i]); $j++){
        //��Ƚ��
        //�ȤäƤʤ��Τǡ�t_aorder_d.contract_id��19�ˤ˵ͤ�ޤ�
        if($color_flg == true){
            $data_list[$i][$j][19] = "Result6";
        }else{
            $data_list[$i][$j][19] = (bcmod($i, 2) == 0) ? "Result1" : "Result2";
        }
    }
    
    $color_flg = false;
}

//rev.1.3 �ѹ�����ͽ��������hidden�˻�������
$form->setConstants(array("hdn_former_delivery_day" => $h_data_list[0][0][1]));


/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
//$page_menu = Create_Menu_f('sale','1');

/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'modoru_disp_flg'   => $modoru_disp_flg,
    'del_line'      => "$del_line",
    'move_warning'  => "$move_warning",

    //��λ��å�����
    'del_comp_mess' => "$del_comp_mess",
    'confirm_comp_mess'     => "$confirm_comp_mess",
    'repo_comp_mess'        => "$repo_comp_mess",
    'accept_comp_mess'      => "$accept_comp_mess",
    'lump_change_comp_mess' => "$lump_change_comp_mess",


    //���ꥨ�顼��å�����
    'confirm_err'               => "$confirm_err",
    'del_err'                   => "$del_err",
    'deli_day_renew_err'        => "$deli_day_renew_err",
    'deli_day_start_err'        => "$deli_day_start_err",
    'claim_day_renew_err'       => "$claim_day_renew_err",
    'claim_day_start_err'       => "$claim_day_start_err",
    'claim_day_bill_err'        => "$claim_day_bill_err",
    "buy_err_mess1"             => "$buy_err_mess1",
    "buy_err_mess2"             => "$buy_err_mess2",
    "buy_err_mess3"             => "$buy_err_mess3",
    "error_pay_no"              => "$error_pay_no",
    "error_buy_no"              => "$error_buy_no",

    //���ꥨ�顼����ɼ�ֹ�
    "ary_err_confirm"           => $ary_err_confirm,
    "ary_err_del"               => $ary_err_del,
    "ary_err_deli_day_renew"    => $ary_err_deli_day_renew,
    "ary_err_deli_day_start"    => $ary_err_deli_day_start,
    "ary_err_claim_day_renew"   => $ary_err_claim_day_renew,
    "ary_err_claim_day_start"   => $ary_err_claim_day_start,
    "ary_err_claim_day_bill"    => $ary_err_claim_day_bill,
    "ary_err_buy1"              => $ary_err_buy1,
    "ary_err_buy2"              => $ary_err_buy2,
    "ary_err_buy3"              => $ary_err_buy3,
    "ary_err_pay_no"            => $ary_err_pay_no,
    "ary_err_buy_no"            => $ary_err_buy_no,

    // �������顼��å�����
    "trust_confirm_err"         => "$trust_confirm_err",    // ���˽����𤵤�Ƥ��ʤ��������å�
    "ord_time_itaku_err"        => "$ord_time_itaku_err",   // ����������å���ʰ����褬��������Ф��Ʒ��äƤ���������Ǥ��ʤ��Τǡ�
    "del_err"                   => "$del_err",              // �������Ƥ��뤫�����å�
    "ord_time_err"              => "$ord_time_err",         // ����������å���ʼ�ʬ����������Ф��Ʒ��äƤ�������
    "ord_time_start_err"        => "$ord_time_start_err",   // ����������å������ƥ೫����
    "claim_day_bill_err"        => "$claim_day_bill_err",   // ��������������ʹߤ������å�
    "error_sale"                => "$error_sale",           // �ֹ椬��ʣ�������
    "err_future_date_msg"       => "$err_future_date_msg",  // ͽ��������̤�����դξ��Υ��顼
    // �������顼����ɼ�ֹ�
    "trust_confirm_no"          => $trust_confirm_no,
    "ord_time_itaku_no"         => $ord_time_itaku_no,
    "del_no"                    => $del_no,
    "ord_time_start_no"         => $ord_time_start_no,
    "ord_time_no"               => $ord_time_no,
    "claim_day_bill_no"         => $claim_day_bill_no,
    "err_sale_no"               => $err_sale_no,
    "ary_future_date_no"        => $ary_future_date_no,

    //��ǧ���顼��å�����
    'cancel_err'    => "$cancel_err",
    'error_buy'     => "$error_buy",
    'error_payin'   => "$error_payin",
    'deli_day_act_renew_err'    => "$deli_day_act_renew_err",
    'pay_day_act_err'           => "$pay_day_act_err",
    'deli_day_intro_renew_err'  => "$deli_day_intro_renew_err",
    'pay_day_intro_renew_err'   => "$pay_day_intro_renew_err",

    // ������Ϣ���顼��å�����
    "err_trade_advance_msg"     => "$err_trade_advance_msg",
    "err_future_date_msg"       => "$err_future_date_msg",
    "err_advance_fix_msg"       => "$err_advance_fix_msg",
    "err_paucity_advance_msg"   => "$err_paucity_advance_msg",
    //"err_day_advance_msg"       => "$err_day_advance_msg",

    // ������Ϣ���顼�Τ��ä���ɼ�ֹ�����
    "ary_err_trade_advance"     => $ary_err_trade_advance,
    "ary_err_future_date"       => $ary_err_future_date,
    "ary_err_advance_fix"       => $ary_err_advance_fix,
    "ary_err_paucity_advance"   => $ary_err_paucity_advance,
    "ary_trade_advance_no"      => $ary_trade_advance_no,
    "ary_future_date_no"        => $ary_future_date_no,
    "ary_advance_fix_no"        => $ary_advance_fix_no,
    "ary_paucity_advance_no"    => $ary_paucity_advance_no,

    // rev.1.3 �������������ηٹ��å�����
    "warn_lump_change"          => $warn_lump_change,


//    'error_pay'     => "$error_pay",
//    'buy_err_mess'  => "$buy_err_mess",

));

//ɽ���ǡ���
$smarty->assign("data_list", $data_list);
$smarty->assign("h_data_list",$h_data_list);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

//print_array($_POST);


?>