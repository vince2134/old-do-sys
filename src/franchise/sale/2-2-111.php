<?php
/**
 *
 * ����ͽ��в١ʰ�����
 *
 *   ͽ��ǡ���������ô���Ԥ��Ȥ�ɬ�פʾ��ʤ򽸷פ���
 *   ���ô���Ԥ�ô���Ҹˤ˾��ʤ��ư����
 *
 *   ���׾���
 *   ����ɼ�ֹ椬���äƤ�����ɼ�����򽸷�
 *   ��������桼���Υ���åפ���ɼ��ô����Ź�ˤ򽸷�
 *   �������ɼ����Ф��ʤ�
 *
 *
 *
 * ������
 * 1.0.0 (2006/08/01) ��������
 * 1.0.1 (2006/08/08) �����åդ�ô���Ҹˤ����ꤵ��Ƥ��ʤ����ϡ����ܽв��Ҹˤ�ɽ������褦�ѹ�
 * 1.0.2 (2006/08/18) ô���Ҹˤ����ꤵ��Ƥ��ʤ����ϴ��ܽв��Ҹˡ����ꤵ��Ƥ������ô���Ҹˤ�ɽ��
 *                    ����إå�����������ܤ˽в��Ҹ�̾�������ѡˤ��ɲ�
 * 1.0.3 (2006/08/29) �����ź����ȴ���Ƥ��Τ��ɲ�
 *                    ��Ф�SQL����Ԥξ���Ĥ���
 * 1.0.4 (2006/09/06) �����Ƥ�Ȥ��ϡְ�����иˡס������Ʋ���ϡְ��������ˡ�
 * 1.0.5 (2006/10/12) ��ɼ�ֹ椬���äƤ���Τ������פ���褦��
 * 1.0.6 (2006/11/02) ��������ɽ������ʬɽ��<suzuki>
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2006/09/06)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/07      02-047      suzuki      ���ո����������Ԥ���褦�˽���
 *  2006/11/07      02-048      suzuki      ô���Գ��Ϥ���ꤷ�����Ǥ���褦�˽���
 *  2006/11/07      02-052      suzuki      ô���Ԥ��Ȥ��Ҹˤΰ�ư���Ԥ���褦�˽���
 *  2006/11/07      02-057      suzuki      ô���Ը����������Ǥ���褦�˽���
 *  2006/11/11      02-051      suzuki      ��ץܥ��󲡲�����POST�ο��̤��ʤ���С�DB�ο��̤�ɽ��
 *  2006/12/04      ssl-0049    kajioka-h   ��ץܥ��󲡲�����ô���Ԥ��ȤΥ쥳���ɿ���hidden�˳�Ǽ�������ȴ������
 *  2006/12/10      02-070      suzuki      ����Τߤξ��ʤǤ⡢��׿���ɽ�������褦�˽���
 *  2006/12/11      02-064      suzuki      �����������ͽ��ǡ������ѹ����줿���˥��顼ɽ������褦�˽���
 *  2007/02/16      �׷�5-1     kajioka-h   ���ʤΰ�ư����ô����Ź�ε����Ҹˡ���ư���ô���Ԥ�ô���Ҹˤ��ѹ�
 *  2007/02/22      xx-xxx      kajioka-h   Ģɼ���ϵ�ǽ����
 *  2007/02/26      B0702-011   kajioka-h   ɽ���ܥ��󲡲�����JS���顼���ФƤ����Τ���
 *  2007/02/27      xx-xxx      kajioka-h   ����̾��ά��ɽ�����ѹ�
 *  2007/03/21      �׷�21      kajioka-h   �����ɼ����Ф��ʤ��褦���ѹ�
 *  2007/03/28      �׷�21¾    kajioka-h   ����ͽ��вٻ��ν����ϰʲ���ư����ѹ�
 *                                              �������ΰ����������
 *                                              ��ô�����Ҹˤ˰���
 *                                              ������إå��νв��Ҹˤ�ô���Ԥε����Ҹˤ˹���
 *  2007/03/30      ����¾106   kajioka-h   �Ͷ�ʬ��������ʬ������ʬ�ࡢ����CD�ǥ����Ȥ��ѹ�
 *                  ����¾109   kajioka-h   ��ô���Ԥι�פϰ��־��ɽ��
 *  2007/04/04      xx-xxx      kajioka-h   ����̾��ά�Ρˤ��龦��̾��ɽ���ѹ�
 *  2007/04/13      ����¾      kajioka-h   ���������ע���ͽ�������פ�ɽ���ѹ�
 *                  ����¾126   kajioka-h   �ֿ��̡ע���ͽ��вٿ��פ�ɽ���ѹ�
 *  2007/04/16      ����¾      kajioka-h   ���������ѹ�
 *  2007/04/30      ����¾      fukuda      �����Ѳ��ڡ������ɲá�A3�ġ�
 *  2007/05/22      ����¾      watanabe-k  �ܥ���̾���ѹ�����Խ���ɽ���͡���Դ��ֽ���ɽ
 *  2007/06/23      xx-xxx      kajioka-h   ���������פ��ǽ��
 *
 */

//$page_title = "����ͽ��вٰ���";
$page_title = "����ͽ��в�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//�������ܤδؿ��Ȥ�
require_once(INCLUDE_DIR."common_quickform.inc");


//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_attach_branch"=> "",
    "form_round_staff"  => array("cd" => "", "select" => ""),
    "form_part"         => "",
    "form_multi_staff"  => "",
    "form_ware"         => "",
    "form_round_day"    => array(
/*
        "sy" => "",
        "sm" => "",
        "sd" => "",
        "ey" => "",
        "em" => "",
        "ed" => "",
*/
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
    ),
    "form_not_multi_staff"  => "",
    "form_count_radio"      => "1",
);



/****************************/
//�����ѿ�����
/****************************/
$group_kind = $_SESSION["group_kind"];


//������λ���Υ�å�����ɽ��
if($_GET["done_flg"] == "true"){
    $html = "<font color=\"blue\"><b>��λ���ޤ�����</b></font>";
}elseif($_GET["err_flg"] == "true"){
    $html  = "<font color=\"red\"><b>�������ͽ��ǡ������ѹ���ȯ�����ޤ�����<br>";
    $html .= "�⤦���ٻϤᤫ�����Ƥ�������</font>";
}else{
    $html = null;
}


/****************************/
// ���������
/****************************/
// ���ڡ���ñ�̥������
$page_return = 0;
// ���ڡ����Կ���ô�������ѡ�
$return_num  = 53;


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form($db_con, $form, $ary_form_list);

// ɽ���������
$form->removeElement("form_display_num");
// �ܵ�ô����Ź����
$form->removeElement("form_client_branch");
// ���������
$form->removeElement("form_client");
// ���������
$form->removeElement("form_claim");
// ����������
$form->removeElement("form_claim_day");
// ������FC����
$form->removeElement("form_charge_fc");

// �������ô���ԥ����ɡʥ���޶��ڤ��
$form->addElement("text", "form_not_multi_staff", "", "size=\"40\" style=\"$g_form_style\" $g_form_option");

//���׶�ʬ
$form_count_radio = NULL;
$form_count_radio[] =& $form->createElement("radio", NULL, NULL, "���ָ�", "1", "");
$form_count_radio[] =& $form->createElement("radio", NULL, NULL, "������", "2", "");
$form->addGroup($form_count_radio, "form_count_radio", "���׶�ʬ");



/*
// ���ô���ԥ�����
$text44_1[] =& $form->createElement("text", "scd", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_charge[scd]','form_charge[ecd]',4)\" $g_form_option");
$text44_1[] =& $form->createElement("static", "", "", "������");
$text44_1[] =& $form->createElement("text", "ecd", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text44_1, "form_charge", "");
*/

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����", null);

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear", "���ꥢ", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");

//���̥����ȥ벣�β������إܥ���
$form->addElement("button", "href_2-2-113", "��������", "onClick=\"javascript:location.href('2-2-113.php')\"");
if($group_kind == "2"){
    $form->addElement("button", "href_2-2-116", "��Դ��ֽ���ɽ", "onClick=\"javascript:location.href('2-2-116.php')\"");
}
$form->addElement("button", "href_2-2-204", "ͽ����ɼȯ��", "onClick=\"javascript:location.href('2-2-204.php')\"");
$form->addElement("button", "href_2-2-111", "����ͽ��в�", $g_button_color." onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");


/*
//���ܽв��Ҹ�̾�����
$sql  = "SELECT ";
$sql .= "    t_ware.ware_id, ";
$sql .= "    t_ware.ware_name ";
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "    INNER JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
$sql .= "WHERE ";
$sql .= "    t_client.client_id = ".$_SESSION["client_id"]." ";
$sql .= ";";

$result = Db_Query($db_con, $sql);
if($result == false) {
    exit();
}
$basic_ware_id   = pg_fetch_result($result, 0, "ware_id");          //���ܽв��Ҹ�ID
$basic_ware_name = pg_fetch_result($result, 0, "ware_name");        //���ܽв��Ҹ�̾

//$form->addElement("hidden", "hdn_basic_ware_id", $basic_ware_id);   //���ܽв��Ҹ�ID
*/


//hidden����
$form->addElement("hidden", "hdn_move_staff_id");       //��ư���륹���åդ�ID


//ͽ��в٤�ԤäƤ�����椫�ɤ������ǧ���뤿��Υ�ˡ����ʥ����å�����������
$form->addElement("hidden", "hdn_ship_chk_cd", "");
if($_POST["form_display"] != ""){
    //$microtime    = NULL;
    $microtime   = explode(" ",microtime());
    $ship_chk_cd = $microtime[1].substr("$microtime[0]", 2, 5);     //�����å�������
}else{
    $ship_chk_cd = $_POST["hdn_ship_chk_cd"];
}
$con_data["hdn_ship_chk_cd"] = $ship_chk_cd;
//echo "�����å������ɡ�$ship_chk_cd<br>";

//��ɽ���ܥ���ײ������˼��������쥳���ɿ���Ǽ��
$form->addElement("hidden", "hdn_ship_chk_num");

//���׶�ʬ�饸���ܥ���
$form->addElement("hidden", "hdn_count_div");

//if($_POST["form_display"] == ""){
if($_POST["form_display"] == "ɽ����"){
    $con_data["hdn_ship_chk_num"]   = $_POST["hdn_ship_chk_num"];
    $count_div                      = $_POST["form_count_radio"];
    $con_data["hdn_count_div"]      = $count_div;
}elseif($_POST != null){
    $count_div                      = $_POST["hdn_count_div"];
    $con_data["form_count_radio"]   = $count_div;
}

$form->setConstants($con_data);



//////////////////////////////
//���顼�����å�
//  �ʲ��Υܥ��󲡲���
//  ��ô���Ԥΰ�ư�ܥ���
//  ������ư�ܥ���
//  ��ɽ���ܥ���
//  ����ץܥ���
//////////////////////////////
$err_flg = false;

if($_POST["move_button"] != "" || $_POST["move_all_button"] != "" || $_POST["form_display"] != "" || $_POST["sum_button"] != "" ){

    // �����̥ե���������å�
    Search_Err_Chk($form);

    // ���������ô���ԡ�ʣ�������
    Err_Chk_Delimited($form, "form_not_multi_staff", "�������ô���ԡ�ʣ������� �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���");


    //ͽ�������ʻϤ��
    $ord_sdate  = str_pad($_POST["form_round_day"]["sy"], 4, "0", STR_PAD_LEFT);
    $ord_sdate .= "-"; 
    $ord_sdate .= str_pad($_POST["form_round_day"]["sm"], 2, "0", STR_PAD_LEFT);
    $ord_sdate .= "-"; 
    $ord_sdate .= str_pad($_POST["form_round_day"]["sd"], 2, "0", STR_PAD_LEFT);
    //ͽ�������ʽ�����
    $ord_edate  = str_pad($_POST["form_round_day"]["ey"], 4, "0", STR_PAD_LEFT);
    $ord_edate .= "-";
    $ord_edate .= str_pad($_POST["form_round_day"]["em"], 2, "0", STR_PAD_LEFT);
    $ord_edate .= "-"; 
    $ord_edate .= str_pad($_POST["form_round_day"]["ed"], 2, "0", STR_PAD_LEFT);

    //ͽ�������������������å�
    $ord_sdate_y = (int)$_POST["form_round_day"]["sy"];
    $ord_sdate_m = (int)$_POST["form_round_day"]["sm"];
    $ord_sdate_d = (int)$_POST["form_round_day"]["sd"];
    $ord_edate_y = (int)$_POST["form_round_day"]["ey"];
    $ord_edate_m = (int)$_POST["form_round_day"]["em"];
    $ord_edate_d = (int)$_POST["form_round_day"]["ed"];
/*
    $check_ord_sdate = checkdate($ord_sdate_m,$ord_sdate_d,$ord_sdate_y);
    if($check_ord_sdate == false && $ord_sdate != "0000-00-00"){
        $form->setElementError("form_round_day","ͽ�������������ǤϤ���ޤ���");
        $err_flg = true;
    }
    $check_ord_edate = checkdate($ord_edate_m,$ord_edate_d,$ord_edate_y);
    if($check_ord_edate == false && $ord_edate != "0000-00-00"){
        $form->setElementError("form_round_day","ͽ�������������ǤϤ���ޤ���");
        $err_flg = true;
    }
*/

	/*
	 * ����
	 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
	 * ��2006/11/02��02-040��������suzuki-t������������ɽ������ʬɽ��
	 *
	*/
	$ord_date = str_pad($ord_edate_y,4,"0", STR_PAD_LEFT)."-".str_pad($ord_edate_m,2,"0", STR_PAD_LEFT)."-".str_pad($ord_edate_d,2,"0", STR_PAD_LEFT);

	//������ɽ�����ּ���
	require_once(INCLUDE_DIR."function_keiyaku.inc");
	$cal_array = Cal_range($db_con,$_SESSION[client_id],true);
	$check_edate   = $cal_array[1];     //�оݽ�λ����

	if($check_edate != "0000-00-00" && $ord_date > $check_edate){
        $form->setElementError("form_round_day","ͽ������ �ϥ�������ɽ�����������ꤷ�Ʋ�������");
        $err_flg = true;
    }

/*
	//ô���ԥ����ɤ�Ⱦ�ѿ��������å�
	if(!ereg("^[0-9]+$",$_POST["form_charge"]["scd"]) && $_POST["form_charge"]["scd"] != NULL){
		$charges_msg = "���ô���ԥ�����(����) ��Ⱦ�ѿ����ΤߤǤ���";
        $err_flg = true;
	}
	if(!ereg("^[0-9]+$",$_POST["form_charge"]["ecd"])  && $_POST["form_charge"]["ecd"] != NULL){
		$chargee_msg = "���ô���ԥ�����(��λ) ��Ⱦ�ѿ����ΤߤǤ���";
        $err_flg = true;
	}

	//���ô���ԡ�ʣ������ˤ�Ⱦ�ѿ��������å�
    if($_POST["form_multi_staff"] != null){
        $array_charge = explode(",",$_POST["form_multi_staff"]);
        $count = count($array_charge);
        for($i=0;$i<$count;$i++){
			if(!ereg("^[0-9]+$",$array_charge[$i])){
				$decimal_msg = "���ô���ԡ�ʣ������ˤ�Ⱦ�ѿ����ȡ�,�פΤߤǤ���";
        		$err_flg = true;
				break;
			}
        }
    }

    //�������ô���ԡ�ʣ������ˤ����ꤵ��Ƥ�����
    if($_POST["form_not_multi_staff"] != null){
        $array_nocharge = explode(",",$_POST["form_not_multi_staff"]);
        $count = count($array_nocharge);
        for($i=0;$i<$count;$i++){
			if(!ereg("^[0-9]+$",$array_nocharge[$i])){
				$nodecimal_msg = "�������ô���ԥ����ɡ�ʣ������ˤ�Ⱦ�ѿ����ȡ�,�פΤߤǤ���";
        		$err_flg = true;
				break;
			}
        }
    }
*/

    if($_POST["move_button"] != "" || $_POST["move_all_button"] != "" || $_POST["sum_button"] != "" ){

        //��ư�оݤΥ����å�ID�����
        if($_POST["hdn_move_staff_id"] == "ALL" || $_POST["hdn_move_staff_id"] == ""){
            $form_staff_keys = array_keys($_POST["form_num"]);
        }else{
            $form_staff_keys[0] = $_POST["hdn_move_staff_id"];
        }
        $array_count_staff = count($form_staff_keys);   //��ʬ

        //�����å�ID�����롼�פ���
        for($i=0;$i<$array_count_staff;$i++){
            $form_count_goods = count($_POST["form_num"][$form_staff_keys[$i]]);       //����ID�����롼��
            $form_goods_keys  = array_keys($_POST["form_num"][$form_staff_keys[$i]]);  //����ID�����

            //����ID�����롼��
            for($j=0;$j<$form_count_goods;$j++){
                // Ⱦ�ѿ��������å�
                if(!ereg("^[0-9]+$", $_POST["form_num"][$form_staff_keys[$i]][$form_goods_keys[$j]])){
                    $err_flg_num = true;
                    break 2;
                }
            }
        }

        if($err_flg_num === true){
            $form_num_mess = "ͽ��вٿ���Ⱦ�ѿ����ΤߤǤ���";
        }else{
            $form_num_mess = null;
        }

    }


    //////////////////////////////
    // ���顼�����å���̽���
    //////////////////////////////

    // �����å�Ŭ��
    $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : $err_flg;


}//���顼�����å������



/****************************/
//��ư������ư�ܥ��󲡲�
/****************************/
if(($_POST["move_button"] != "" || $_POST["move_all_button"] != "") && (!$err_flg && !$err_flg_num) && $count_div == "1"){
/* suzuki  */
	//��ô���Ԥΰ�ư�ܥ��󲡲�Ƚ��
	if($_POST["hdn_move_staff_id"] != "ALL"){
		//�оݴ��֤ΰ�ư���ʰ����ˤ����
	    $array_tmp = L_List_SQL_Get(
	            $form,
	            $count_div,
	            $ord_sdate,
	            $ord_edate,
	            $_POST["form_round_staff"]["cd"],
	            $_POST["form_round_staff"]["select"],
	            $_POST["form_multi_staff"],
	            $_POST["form_not_multi_staff"],
	            $_POST["form_part"],
	            $_POST["form_ware"],
	            $_POST["form_attach_branch"],
	            "t_aorder_d.aord_d_id",
	            $err_flg,
				$_POST["hdn_move_staff_id"]
	        );
	}else{
		//�оݴ��֤ΰ�ư���ʰ����ˤ����
	    $array_tmp = L_List_SQL_Get(
	            $form,
	            $count_div,
	            $ord_sdate,
	            $ord_edate,
	            $_POST["form_round_staff"]["cd"],
	            $_POST["form_round_staff"]["select"],
	            $_POST["form_multi_staff"],
	            $_POST["form_not_multi_staff"],
	            $_POST["form_part"],
	            $_POST["form_ware"],
	            $_POST["form_attach_branch"],
	            "t_aorder_d.aord_d_id",
	            $err_flg
	        );
	}
	$sql = $array_tmp[0];
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);
    if($result == false) {
        //Db_Query($db_con, "ROLLBACK;");
        exit();
    }

    $record_count = pg_num_rows($result);   //���쥳���ɿ��ʼ�ʧ�˽񤫤ʤ��Ȥ����ʤ�����
    $array_query = Get_Data($result);

    //����ID�ν�ʣ�������
    for($i=0;$i<$record_count;$i++){
        $array_vacuum[$array_query[$i][5]] = 0;
    }
//print_array($array_vacuum, "�оݤ�������ID");exit();
    //$array_tmp_count = count(array_unique($array_vacuum)); //����ID�ο�
    $array_tmp_count = count($array_vacuum); //����ID�ο�
//echo "�Կ���$array_tmp_count<br>";
//echo "�Կ�2��".$_POST["hdn_ship_chk_num"]."<br>";
//echo "�Կ�3��".$_POST["hdn_ship_chk_cd"]."<br>";
    $sql = "SELECT COUNT(aord_id) FROM t_aorder_h WHERE ship_chk_cd = ".$_POST["hdn_ship_chk_cd"].";";
//echo "$sql<br>";
    $result = Db_Query($db_con, $sql);
    if($result == false) {
        exit();
    }
    $chk_record_count = pg_fetch_result($result, 0, 0);     //ɽ���ܥ��󲡲����˥����ɤ����ꤷ���쥳���ɿ�
//echo "�Կ���$chk_record_count<br>";

    //ɽ���ܥ��󲡲����Υ쥳���ɿ�����Ӥ����ۤʤ���ϥ��顼
    if($_POST["hdn_ship_chk_num"] != $chk_record_count || (($_POST["hdn_ship_chk_num"] != $array_tmp_count) && $_POST["hdn_move_staff_id"] == "ALL") || (($_POST["hdn_ship_staff_num"][$_POST["hdn_move_staff_id"]] != $array_tmp_count) && $_POST["hdn_move_staff_id"] != "ALL")){
        //$err_ship_chk = true;
        //$err_ship_chk_mess = "�оݤ�ͽ��ǡ������ѹ�����ޤ�����<br>�Ϥᤫ��⤦���٤��ľ���Ƥ���������";
//print_array($_POST["hdn_ship_chk_num"]);
//print_array($chk_record_count);
//print_array($_POST["hdn_ship_chk_num"]);
//print_array($array_tmp_count);
//print_array($_POST["hdn_move_staff_id"]);
//print_array($_POST["hdn_ship_staff_num"][$_POST["hdn_move_staff_id"]]);
//print_array($_POST["hdn_move_staff_id"]);
//print_array($array_tmp_count);
//print_array($_POST["hdn_move_staff_id"]);
        header("Location: $_SERVER[PHP_SELF]?err_flg=true");
        exit();
    }



    //���顼���ʤ���С���ʧ������إå���SQL��»�
    if($err_flg !== true && $err_flg_num !== true){

        //�ȥ�󥶥�����󳫻ϡʥ����åդ��Ȥ���Ͽ��
        Db_Query($db_con, "BEGIN;");

        //�оݤμ���ID�򥫥�޶��ڤ��
        $str_aord_id = "";
        foreach($array_vacuum as $key => $value){
            $str_aord_id .= $key.", ";
        }
        $str_aord_id = substr($str_aord_id, 0, (strlen($str_aord_id) - 2));

        //�оݤμ���μ�ʧ�������
        $sql  = "DELETE FROM t_stock_hand \n";
        $sql .= "WHERE aord_d_id IN ( \n";
        $sql .= "    SELECT aord_d_id FROM t_aorder_d WHERE aord_id IN (".$str_aord_id.") \n";
        $sql .= "    ) \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        if($result == false){
            Db_Query($db_con, "ROLLBACK;");
            exit();
        }


        //�쥳���ɿ�ʬ�롼��
        for($i=0, $array_update_ware=array();$i<$record_count;$i++){

            //$staff_ware_id = ($array_query[$i][3] == null) ? $basic_ware_id : $array_query[$i][3];  //�����åդ�ô���Ҹ�ID
            $staff_ware_id = $array_query[$i][3];       //�����åդ�ô���Ҹ�ID
            $ord_no        = $array_query[$i][6];       //��ɼ�ֹ�
            $aord_d_id     = $array_query[$i][7];       //����ǡ���ID
            $goods_id      = $array_query[$i][8];       //����ID
            $reserve_num   = $array_query[$i][11];      //��ư���ʰ�������
            $bases_ware_id = $array_query[$i][15];      //�����Ҹ�ID

/*
            //�����Ҹˤ��������ư������SQL
            $sql  = "INSERT INTO ";
            $sql .= "    t_stock_hand ( ";
            $sql .= "        goods_id, ";
            $sql .= "        enter_day, ";
            $sql .= "        work_day, ";
            $sql .= "        work_div, ";
            $sql .= "        ware_id, ";
            $sql .= "        io_div, ";
            $sql .= "        num, ";
            $sql .= "        slip_no, ";
            $sql .= "        aord_d_id, ";
            $sql .= "        staff_id, ";
            $sql .= "        shop_id ";
            $sql .= "    ) VALUES ( ";
            $sql .= "        ".$goods_id.", ";
            $sql .= "        CURRENT_TIMESTAMP, ";
            $sql .= "        CURRENT_TIMESTAMP, ";
            $sql .= "        '1', ";
            $sql .= "        ".$bases_ware_id.", ";
            $sql .= "        '1', ";
            $sql .= "        ".$reserve_num.", ";
            $sql .= "        '".$ord_no."', ";
            $sql .= "        ".$aord_d_id.", ";
            $sql .= "        ".$_SESSION["staff_id"].", ";
            $sql .= "        ".$_SESSION["client_id"]." ";
            $sql .= "    ) ";
            $sql .= ";";
//echo "$sql<br>";

            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }
*/

            //ô���Ҹˤذ�����ư�νи�SQL
            $sql  = "INSERT INTO ";
            $sql .= "    t_stock_hand ( ";
            $sql .= "        goods_id, ";
            $sql .= "        enter_day, ";
            $sql .= "        work_day, ";
            $sql .= "        work_div, ";
            $sql .= "        ware_id, ";
            $sql .= "        io_div, ";
            $sql .= "        num, ";
            $sql .= "        slip_no, ";
            $sql .= "        aord_d_id, ";
            $sql .= "        staff_id, ";
            $sql .= "        shop_id ";
            $sql .= "    ) VALUES ( ";
            $sql .= "        ".$goods_id.", ";
            $sql .= "        CURRENT_TIMESTAMP, ";
            $sql .= "        CURRENT_TIMESTAMP, ";
            $sql .= "        '1', ";
            $sql .= "        ".$staff_ware_id.", ";
            $sql .= "        '2', ";
            $sql .= "        ".$reserve_num.", ";
            $sql .= "        '".$ord_no."', ";
            $sql .= "        ".$aord_d_id.", ";
            $sql .= "        ".$_SESSION["staff_id"].", ";
            $sql .= "        ".$_SESSION["client_id"]." ";
            $sql .= "    ) ";
            $sql .= ";";
//echo "$sql<br>";

            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }

            //����إå������Ѥ�ô���Ҹ�ID�����
            //$array_update_ware[$array_query[$i][5]] = $array_query[$i][3];

            //����إå������Ѥ˵����Ҹ�ID�����
            $array_update_ware[$array_query[$i][5]] = $array_query[$i][15];

        }

        //����ID���Ȥ˰�ư�ѥե饰���в��Ҹˤ򹹿�
        $array_aord_id       = array_keys($array_update_ware);
        $array_aord_id_count = count($array_update_ware);

        for($i=0;$i<$array_aord_id_count;$i++){

            //$ware_id = ($array_update_ware[$array_aord_id[$i]] == null) ? $basic_ware_id : $array_update_ware[$array_aord_id[$i]];
            $ware_id = $array_update_ware[$array_aord_id[$i]];

            //�����ʬ����åե饰�����
            $sql = "SELECT contract_div, cancel_flg FROM t_aorder_h WHERE aord_id = ".$array_aord_id[$i].";";
            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }
            $contract_div   = pg_fetch_result($result, 0, "contract_div");
            $cancel_flg     = pg_fetch_result($result, 0, "cancel_flg");

            $sql  = "UPDATE ";
            $sql .= "    t_aorder_h ";
            $sql .= "SET ";
            //����饤����Ԥǡ���åե饰��true����ɼ�Ͻв��Ҹˤ򹹿����ʤ��ʰ�����𤷤����ᡢ�в��ҸˤϹ����ѡ�
            if(!($contract_div == "2" && $cancel_flg == "t")){
                $sql .= "    ware_id = ".$ware_id.", ";
                //1.0.2 (2006/08/18) ����إå�����������ܤ˽в��Ҹ�̾�������ѡˤ��ɲ�
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = ".$ware_id."), ";
            }
            $sql .= "    move_flg = true ";
            $sql .= "WHERE ";
            $sql .= "    aord_id = ".$array_aord_id[$i]." ";
            $sql .= ";";
//echo "$sql<br>";

            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }
        }


        /*** ��������߸˰�ưSQL ***/

        //�����å�ID�����롼�פ���
        for($i=0;$i<$array_count_staff;$i++){

            $form_count_goods = count($_POST["form_num"][$form_staff_keys[$i]]);       //����ID�����롼��
            $form_goods_keys  = array_keys($_POST["form_num"][$form_staff_keys[$i]]);  //����ID�����
//print_array($form_goods_keys);

            for($j=0;$j<$form_count_goods;$j++){
                //�����Ҹˤ���߸˰�ư�νи�SQL
                $sql  = "INSERT INTO ";
                $sql .= "    t_stock_hand ( ";
                $sql .= "        goods_id, ";
                $sql .= "        enter_day, ";
                $sql .= "        work_day, ";
                $sql .= "        work_div, ";
                $sql .= "        ware_id, ";
                $sql .= "        io_div, ";
                $sql .= "        num, ";
                $sql .= "        staff_id, ";
                $sql .= "        shop_id ";
                $sql .= "    ) VALUES ( ";
                $sql .= "        ".$form_goods_keys[$j].", ";
                $sql .= "        CURRENT_TIMESTAMP, ";
                $sql .= "        CURRENT_TIMESTAMP, ";
                $sql .= "        '5', ";
                //$sql .= "        ".$basic_ware_id.", ";
                $sql .= "        ".$_POST["hdn_bases_ware_id"][$form_staff_keys[$i]].", ";
                $sql .= "        '2', ";
                $sql .= "        ".$_POST["form_num"][$form_staff_keys[$i]][$form_goods_keys[$j]].", ";
                $sql .= "        ".$_SESSION["staff_id"].", ";
                $sql .= "        ".$_SESSION["client_id"]." ";
                $sql .= "    ) ";
                $sql .= ";";
//echo "$sql<br>";

                $result = Db_Query($db_con, $sql);
                if($result == false) {
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }


                //ô���Ҹˤغ߸˰�ư������SQL
                $sql  = "INSERT INTO ";
                $sql .= "    t_stock_hand ( ";
                $sql .= "        goods_id, ";
                $sql .= "        enter_day, ";
                $sql .= "        work_day, ";
                $sql .= "        work_div, ";
                $sql .= "        ware_id, ";
                $sql .= "        io_div, ";
                $sql .= "        num, ";
                $sql .= "        staff_id, ";
                $sql .= "        shop_id ";
                $sql .= "    ) VALUES ( ";
                $sql .= "        ".$form_goods_keys[$j].", ";
                $sql .= "        CURRENT_TIMESTAMP, ";
                $sql .= "        CURRENT_TIMESTAMP, ";
                $sql .= "        '5', ";
                $sql .= "        ".$_POST["hdn_staff_ware_id"][$form_staff_keys[$i]].", ";
                $sql .= "        '1', ";
                $sql .= "        ".$_POST["form_num"][$form_staff_keys[$i]][$form_goods_keys[$j]].", ";
                $sql .= "        ".$_SESSION["staff_id"].", ";
                $sql .= "        ".$_SESSION["client_id"]." ";
                $sql .= "    ) ";
                $sql .= ";";
//echo "$sql<br>";

                $result = Db_Query($db_con, $sql);
                if($result == false) {
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

            }

        }//�����å�ID�롼�׽����ʺ߸˰�ưSQL��

        /*** �����ޤǺ߸˰�ưSQL ***/


        //���ｪλ��
        $result = Db_Query($db_con, "COMMIT;");
        //$result = Db_Query($db_con, "ROLLBACK;");
        if($result != false){
            header("Location: $_SERVER[PHP_SELF]?done_flg=true");
        }

    }//���ϥ��顼���ʤ��ä�����SQL�����

}//��ư�ܥ�����������ޤ�



/****************************/
//ɽ������ץܥ��󲡲�
//��ư������ư�ܥ��󲡲����ĥ��顼���ʲ��̺�ɽ����
/****************************/
//if($_POST["form_display"] != ""){
if($_POST["form_display"] != "" || $_POST["sum_button"] != "" || ($_POST["hdn_move_staff_id"] != "" && $err_flg_num)){

    //���顼�ǤϤʤ���硢�����������
    if($err_flg != true){

        /*** ��������SQL���������¹� ***/

/* suzuki  */
		//��ô���Ԥΰ�ư�ܥ��󲡲�Ƚ��
		if($_POST["hdn_move_staff_id"] != "ALL"){
	        $array_tmp = L_List_SQL_Get(
	                $form, 
	                $count_div,
	                $ord_sdate, 
	                $ord_edate, 
                    $_POST["form_round_staff"]["cd"],
                    $_POST["form_round_staff"]["select"],
                    $_POST["form_multi_staff"],
                    $_POST["form_not_multi_staff"],
                    $_POST["form_part"],
                    $_POST["form_ware"],
                    $_POST["form_attach_branch"],
	                //"t_goods.goods_cd", 
	                "t_g_goods.g_goods_cd, t_product.product_cd, t_g_product.g_product_cd, t_goods.goods_cd", 
	                $err_flg,
					$_POST["hdn_move_staff_id"]
	            );
		}else{
			$array_tmp = L_List_SQL_Get(
	                $form, 
	                $count_div,
	                $ord_sdate, 
	                $ord_edate, 
                    $_POST["form_round_staff"]["cd"],
                    $_POST["form_round_staff"]["select"],
                    $_POST["form_multi_staff"],
                    $_POST["form_not_multi_staff"],
                    $_POST["form_part"],
                    $_POST["form_ware"],
                    $_POST["form_attach_branch"],
	                //"t_goods.goods_cd", 
	                "t_g_goods.g_goods_cd, t_product.product_cd, t_g_product.g_product_cd, t_goods.goods_cd", 
	                $err_flg
	            );
		}
        $sql = $array_tmp[0];
//echo "$sql<br>";
        $ord_sdate = $array_tmp[1];
        $ord_edate = $array_tmp[2];

        $result = Db_Query($db_con, $sql);
            if($result == false) {
            exit();
        }

        /*** �����ޤ�SQL���������¹� ***/

        /*** ��������HTML������ ***/

        $array_query = Get_Data($result);
//print_array($array_query);

        $record_count = pg_num_rows($result);   //���쥳���ɿ��ʼ�ʧ�˽񤫤ʤ��Ȥ����ʤ�����

        //0����ä����
        if($record_count == 0){
            $html  = "<font color=\"blue\"><b>";
            $html .= "ͽ��ǡ���������ޤ���";
            $html .= "</b></font>";
        }else{
            //��ô���Ԥνв�ͽ���SQL�η�̹Կ�ʬ�󤹡�
            //for($i=0, $array_goods=array(), $array_sum=array();$i<$record_count;$i++){
            for($i=0, $array_goods=array(), $array_sum=array(), $array_hidden_aord_id=array();$i<$record_count;$i++){
                $staff_id        = $array_query[$i][0];     //�����å�ID
				$staff_cd        = $array_query[$i][1];     //�����å�CD
                $staff_name      = $array_query[$i][2];     //�����å�̾
                //$ware_id    = ($array_query[$i][3] == null) ? $basic_ware_id : $array_query[$i][3];     //ô���Ҹ�ID
                //$ware_name  = ($array_query[$i][4] == null) ? $basic_ware_name : $array_query[$i][4];   //ô���Ҹ�̾
                $ware_id         = $array_query[$i][3];     //ô���Ҹ�ID
                $ware_name       = $array_query[$i][4];     //ô���Ҹ�̾
                $goods_id        = $array_query[$i][8];     //����ID
                $goods_cd        = $array_query[$i][9];     //����CD
                $goods_name      = $array_query[$i][10];    //����̾
                $goods_num       = $array_query[$i][11];    //ͽ��вٿ�
                $bases_ware_id   = $array_query[$i][15];    //�����Ҹ�ID
                $bases_ware_name = $array_query[$i][16];    //�����Ҹ�
                $g_goods_name    = $array_query[$i][17];    //�Ͷ�ʬ
                $product_name    = $array_query[$i][18];    //������ʬ
                $g_product_name  = $array_query[$i][19];    //����ʬ��

                //��ô���Ԥ��Ȥ˥������
                $array_goods[$staff_id][$goods_id]["staff_name"] = $staff_name;
                $array_goods[$staff_id][$goods_id]["staff_cd"]   = $staff_cd;
                $array_goods[$staff_id][$goods_id]["ware_id"]    = $ware_id;
                $array_goods[$staff_id][$goods_id]["ware_name"]  = $ware_name;
                $array_goods[$staff_id][$goods_id]["goods_cd"]   = $goods_cd;
                $array_goods[$staff_id][$goods_id]["goods_name"] = $goods_name;
                //(2006/08/29) kaji �����ź����ȴ���Ƥ��Τ��ɲ�
                //$array_goods[$staff_id][$goods_id]["num"]        = $array_goods[$goods_id]["num"] + $goods_num;
                $array_goods[$staff_id][$goods_id]["num"]        = $array_goods[$staff_id][$goods_id]["num"] + $goods_num;
                $array_goods[$staff_id][$goods_id]["bases_ware_id"]   = $bases_ware_id;
                $array_goods[$staff_id][$goods_id]["bases_ware_name"] = $bases_ware_name;
                $array_goods[$staff_id][$goods_id]["g_goods_name"]      = $g_goods_name;
                $array_goods[$staff_id][$goods_id]["product_name"]      = $product_name;
                $array_goods[$staff_id][$goods_id]["g_product_name"]    = $g_product_name;

                //��ץơ��֥��ѤΥ������
                //$array_sum[$goods_id]["num"] = $array_sum[$goods_id]["num"] + $goods_num;

                //ɽ���ܥ��󲡲����ϥ쥳���ɿ����Ǽ
                if($_POST["form_display"] != ""){
                    //�����å������ɹ����Ѥ˼���ID��������
                    //$array_aord_id[$i] = $array_query[$i][5];
                    $array_aord_id[$i] = $array_query[$i][5];

					//ô���Ԥ��Ȥμ���ID�η��
					$staff_aord_id[$staff_id][] = $array_query[$i][5];
                }

            }//��ץ�����Ƚ����
//print_array($array_goods);
//print_array($array_hidden_aord_id);


            //ɽ���ܥ��󲡲����ϥ쥳���ɿ����Ǽ
            if($_POST["form_display"] != ""){
                //�����å��������Ѥμ���ID�����󤫤��ʣ��Ȥ�
                $array_tmp = array_unique($array_aord_id);
                $array_aord = array_values($array_tmp);
//print_array($array_aord);
                $array_aord_count = count($array_aord);
//echo "�Կ������ˡ�$array_aord_count<br>";

                //ɽ���ܥ��󲡲����ϼ��������쥳���ɿ�������å��Ѥ�hidden�˳�Ǽ
                $form->setConstants(array("hdn_ship_chk_num" => $array_aord_count));

				//ɽ���ܥ��󲡲����ϼ�������ô���Ԥ��ȤΥ쥳���ɿ�������å��Ѥ�hidden�˳�Ǽ
				while($staff_data = each($staff_aord_id)){
					$staff_num = $staff_data[0];
					//�����å��������Ѥμ���ID�����󤫤��ʣ��Ȥ�
                	$staff_check = array_unique($staff_aord_id[$staff_num]);
                	$staff_n = array_values($staff_check);
					$staff_aord_num = count($staff_n);
					$form->addElement("hidden", "hdn_ship_staff_num[$staff_num]", "");
					$set_staff["hdn_ship_staff_num[$staff_num]"] = $staff_aord_num;
                	$form->setConstants($set_staff);
				}

                for($i=0,$str_aord="";$i<$array_aord_count;$i++){
                    $str_aord .= $array_aord[$i];
                    $str_aord .= ($i != $array_aord_count-1) ? ", " : "";
                }
//echo "�����å������ɡ�$str_aord<br>";

                //������������إå��˥����å������ɤ���Ϳ
                $sql  = "UPDATE ";
                $sql .= "    t_aorder_h ";
                $sql .= "SET ";
                $sql .= "    ship_chk_cd = ".$ship_chk_cd." ";
                $sql .= "WHERE ";
                $sql .= "    aord_id IN (".$str_aord.") ";
                $sql .= ";";
//echo "$sql<br>";

                $result = Db_Query($db_con, $sql);
                    if($result == false) {
                    exit();
                }
            //�����å������ɳ�ǧ�����

            //��ץܥ��󲡲�����ô���Ԥ��ȤΥ쥳���ɿ���hidden�˳�Ǽ
            }elseif($_POST["sum_button"] != ""){
                foreach($_POST["hdn_ship_staff_num"] as $staff_num => $staff_aord_num){
                    $form->addElement("hidden", "hdn_ship_staff_num[$staff_num]");
                    $set_staff["hdn_ship_staff_num[$staff_num]"] = $staff_aord_num;
                }
                $form->setConstants($set_staff);
            }


            $array_staff_count = count($array_goods);
            $array_staff_keys  = array_keys($array_goods);

            //��ô���Ԥνв�ͽ��ʥ�����Ȥ�������ʬ�󤹡�
            for($i=0;$i<$array_staff_count;$i++){

                $array_goods_count = count($array_goods[$array_staff_keys[$i]]);
                $array_goods_keys  = array_keys($array_goods[$array_staff_keys[$i]]);

                //��ô���Ԥξ���ʬ�롼��
                for($j=0;$j<$array_goods_count;$j++){

                    //��ץܥ��󡢰�ư�ܥ���ޤ�������ư�ܥ��󲡲����ƥ��顼�ξ�硢POST�Υǡ����������
                    if($_POST["form_num"][$array_staff_keys[$i]][$array_goods_keys[$j]] != NULL && ($_POST["sum_button"] != "" || $_POST["move_button"] != "" || $_POST["move_all_button"] != "")){
                        $goods_num = $_POST["form_num"][$array_staff_keys[$i]][$array_goods_keys[$j]];
                    }else{
                        $goods_num = $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["num"];
                    }

                    $tmp = "form_num[".$array_staff_keys[$i]."][".$array_goods_keys[$j]."]";
                    $con_data_num[$tmp] = $goods_num;
                }
            }
            $form->setConstants($con_data_num);


            //��ô���Ԥνв�ͽ��ʥ�����Ȥ�������ʬ�󤹡�
            for($i=0, $html="", $goods_num_sum=0, $array_sum=array();$i<$array_staff_count;$i++){

                $array_goods_count = count($array_goods[$array_staff_keys[$i]]);
                $array_goods_keys  = array_keys($array_goods[$array_staff_keys[$i]]);

//for($b=0;$b<20;$b++){   // fukuda test

                //��ô���Ԥξ���ʬ�롼��
                for($j=0;$j<$array_goods_count;$j++){

                    //1���ܤϥơ��֥�Υإå���ɽ��
                    if($j == 0){
                        // ô����̾�ơ��֥����
                        $html .= "<br>";
                        $ary_return = L_Html_U_Table_Header(
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["staff_name"], 
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["staff_cd"], 
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["ware_name"], 
                            $ord_sdate, 
                            $ord_edate, 
                            $form, 
                            $array_staff_keys[$i], 
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["ware_id"], 
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["bases_ware_id"],
                            $return_num,
                            $page_return
                        );
                        $html .= $ary_return[0];
                        $page_return = $ary_return[1];
                        // �󥿥��ȥ����
                        $ary_return = L_Html_Table_Header($return_num, $page_return);
                        $html .= $ary_return[0];
                        $page_return = $ary_return[1];
                    }

                    //��ץܥ��󡢰�ư�ܥ���ޤ�������ư�ܥ��󲡲����ƥ��顼�ξ�硢POST�Υǡ����������
                    if($_POST["form_num"][$array_staff_keys[$i]][$array_goods_keys[$j]] != NULL && ($_POST["sum_button"] != "" || $_POST["move_button"] != "" || $_POST["move_all_button"] != "")){
                        $goods_num = $_POST["form_num"][$array_staff_keys[$i]][$array_goods_keys[$j]];

                    }else{
                        $goods_num = $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["num"];
                    }

                    //��ץơ��֥��ѤΥ������
                    $array_sum[$array_goods_keys[$j]]["num"] = $array_sum[$array_goods_keys[$j]]["num"] + $goods_num;

//for($a=0;$a<10;$a++){   // fukuda test
                    // ���ʹԺ���
                    $ary_return = L_Html_Draw_Row(
                        $j+1,                               //��No.
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["goods_cd"], //���ʥ�����
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["goods_name"],     //����̾
                        $goods_num,                         //���ʿ�
                        $form, 
                        $array_staff_keys[$i],              //�����å�ID 
                        $array_goods_keys[$j],              //����ID
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["g_goods_name"],     //�Ͷ�ʬ
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["product_name"],     //������ʬ
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["g_product_name"],   //����ʬ��
                        $return_num,
                        $page_return,
                        $count_div
                    );
                    $html .= $ary_return[0];
                    $page_return = $ary_return[1];
//}   // fukuda test

                    //��׹��ѤΥ������
                    $goods_num_sum = $goods_num_sum + $goods_num;

                    //�ǽ��Ԥξ�硢��פ�ɽ��
                    if($j == $array_goods_count-1){
                        //1.0.1 (2006/08/08) ô���Ҹˤ����ꤵ��Ƥ��ʤ����ϡ����ܽв��Ҹˤ�ɽ��
                        //$staff_ware_name = ($staff_ware_name == null) ? $basic_ware_name : $staff_ware_name;
                        //1.0.2 (2006/08/18) ô���Ҹˤ����ꤵ��Ƥ��ʤ����ϴ��ܽв��Ҹˡ����ꤵ��Ƥ������ô���Ҹˤ�ɽ����Ƚ��Ͼ�Ǥ�äƤޤ���
                        $staff_ware_name = $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["ware_name"];
                        $bases_ware_name = $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["bases_ware_name"];
                        // ��׹Ժ���
                        $ary_return = L_Html_Table_Footer(
                            $goods_num_sum,
                            $bases_ware_name,
                            $staff_ware_name,
                            $form,
                            $array_staff_keys[$i],
                            $disabled,
                            $return_num, 
                            $page_return,
                            $count_div
                        );
                        $html .= $ary_return[0];
                        $page_return = $ary_return[1];

                        //��׹��ѤΥ�������ѿ������
                        $goods_num_sum = 0;
                    }

                }//����ʬ�Υ롼�׽����

//}   // fukuda test

            }//�����å�ʬ�Υ롼�׽����

            //$html .= "<hr>\n";

            //��פ�ɽ�����뾦�ʤξ���ID�����������,�׶��ڤ�ˤ���
            $array_sum_goods_keys = array_keys($array_sum);
            $count_array_sum_goods_keys = count($array_sum_goods_keys);
            for($i=0,$string_goods_sum_keys="";$i<$count_array_sum_goods_keys;$i++){
                $string_sum_goods_keys .= $array_sum_goods_keys[$i];
                $string_sum_goods_keys .= ($i!=$count_array_sum_goods_keys-1) ? ", " : "" ;
            }
//echo $string_goods_sum_keys;

            //��פ˻Ȥ������Ҹ�ID�����Ƽ���������,�׶��ڤ�ˤ���
            $sql = "SELECT bases_ware_id FROM t_branch WHERE shop_id = ".$_SESSION["client_id"].";";
            $result = Db_Query($db_con, $sql);
                if($result == false) {
                exit();
            }
            $array_bases_tmp = pg_fetch_all($result);
            $array_bases_tmp_count = pg_num_rows($result);
            for($i=0;$i<$array_bases_tmp_count;$i++){
                $array_bases_tmp2[] = $array_bases_tmp[$i]["bases_ware_id"];
            }
            $array_all_bases_ware_id = array_unique($array_bases_tmp2);
            $all_bases_ware_id = "";
            foreach($array_all_bases_ware_id as $value){
                $all_bases_ware_id .= "$value, ";
            }
            $all_bases_ware_id = substr($all_bases_ware_id, 0, (strlen($all_bases_ware_id) - 2));


            //��פ�ɽ�����뾦��ID�κ߸˿���ȯ��Ĥ����
            $sql  = "SELECT \n";
            $sql .= "    t_goods.goods_id, \n";
            $sql .= "    t_goods.goods_cd, \n";
            //$sql .= "    t_goods.goods_name, \n";
            //$sql .= "    t_goods.goods_cname, \n";
            $sql .= "    t_goods.goods_name, \n";
            $sql .= "    COALESCE (t_stock.stock_num,0) AS stock_num, \n";
            $sql .= "    COALESCE (t_inventory_on_order.inventory_on_order_num, 0) AS inventory_on_order_num, \n";
            $sql .= "    t_g_goods.g_goods_name, \n";       // 5 �Ͷ�ʬ̾
            $sql .= "    t_product.product_name, \n";       // 6 ������ʬ̾
            $sql .= "    t_g_product.g_product_name \n";    // 7 ����ʬ��̾
            $sql .= "FROM \n";
			$sql .= "    t_goods \n";
            $sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
            $sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
            $sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
			$sql .= "    LEFT JOIN \n";
            $sql .= "    ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            goods_id, \n";
            $sql .= "            SUM(stock_num) AS stock_num \n";
            $sql .= "        FROM \n";
            $sql .= "            t_stock \n";
            $sql .= "        WHERE \n";
            $sql .= "            shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            //$sql .= "            ware_id = $basic_ware_id \n";
            $sql .= "            ware_id IN (".$all_bases_ware_id.") \n";
            $sql .= "        GROUP BY \n";
            $sql .= "            goods_id \n";
            $sql .= "    ) AS t_stock ON t_stock.goods_id = t_goods.goods_id \n";
            $sql .= "    LEFT JOIN ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            goods_id, \n";
            $sql .= "            SUM( \n";
            $sql .= "                CASE io_div \n";
            $sql .= "                    WHEN 1 THEN num \n";
            $sql .= "                    WHEN 2 THEN num * (-1) \n";
            $sql .= "                END \n";
            $sql .= "            ) AS inventory_on_order_num \n";
            $sql .= "            FROM \n";
            $sql .= "            t_stock_hand \n";
            $sql .= "        WHERE \n";
/*
            $sql .= "            goods_id IN ($string_sum_goods_keys) \n";
            $sql .= "            AND \n";
*/
            $sql .= "            shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            //$sql .= "            ware_id = $basic_ware_id \n";
            $sql .= "            ware_id IN (".$all_bases_ware_id.") \n";
            $sql .= "            AND \n";
            $sql .= "            work_div = '3' \n";
            $sql .= "        GROUP BY \n";
            $sql .= "            goods_id \n";
            $sql .= "    ) AS t_inventory_on_order ON t_stock.goods_id = t_inventory_on_order.goods_id \n";
			$sql .= "WHERE \n";
			$sql .= "    t_goods.goods_id IN ($string_sum_goods_keys) \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_g_goods.g_goods_cd, \n";
            $sql .= "    t_product.product_cd, \n";
            $sql .= "    t_g_product.g_product_cd, \n";
            $sql .= "    t_goods.goods_cd \n";
            $sql .= ";";
//print_array($sql, "���");

            $result = Db_Query($db_con, $sql);
                if($result == false) {
                exit();
            }

            $array_sum_query = Get_Data($result);

            //��ư���뾦�ʤι�פ򥫥���Ȥ�������˺߸˿���ȯ��Ĥ��ɲ�
            for($i=0;$i<$count_array_sum_goods_keys;$i++){
                $goods_id = $array_sum_query[$i][0];

                //��ץܥ��󡢰�ư�ܥ���ޤ�������ư�ܥ��󲡲����ƥ��顼�ξ�硢POST�Υǡ����������
                if($err_flg_num){
                    $goods_num_sum = $_POST["form_num_all"][$goods_id];
                }else{
                    $goods_num_sum = $array_sum[$goods_id]["num"];
                }

                $array_goods_sum[$i]["goods_id"]   = $goods_id;                             //����ID
                $array_goods_sum[$i]["goods_cd"]   = $array_sum_query[$i][1];               //����CD
                $array_goods_sum[$i]["goods_name"] = $array_sum_query[$i][2];               //����̾
                $array_goods_sum[$i]["stock_num"]  = $array_sum_query[$i][3];               //�߸˿�
                $array_goods_sum[$i]["inventory_on_order_num"] = $array_sum_query[$i][4];   //ȯ���
                $array_goods_sum[$i]["num"] = $goods_num_sum;                               //������
                $array_goods_sum[$i]["g_goods_name"]    = $array_sum_query[$i][5];          //�Ͷ�ʬ
                $array_goods_sum[$i]["product_name"]    = $array_sum_query[$i][6];          //������ʬ
                $array_goods_sum[$i]["g_product_name"]  = $array_sum_query[$i][7];          //����ʬ��

                $tmp = "form_num_all[".$goods_id."]";
                $con_data_sum[$tmp] = $goods_num_sum;
            }

            $form->setConstants($con_data_sum);

            //��פΥơ��֥�����
            //$html .= L_Html_SumTable($ord_sdate, $ord_edate, $basic_ware_name, $array_goods_sum, $form, $err_flg_num,$disabled);
            $page_return = 15;
            $ary_sum_table   = L_Html_SumTable($ord_sdate, $ord_edate, $array_goods_sum, $form, $err_flg_num,$disabled, $page_return, $count_div);
            $html_sum_table  = $ary_sum_table[0];
            $html_sum_table .= "<br><br><hr><br>";

            /*** �����ޤ�HTML������ ***/
        }

    }//���顼�ǤϤʤ�����������������ޤ�

}//ɽ���ܥ��󲡲����������ޤ�



/****************************/
// HTML�����ʸ�������
/****************************/
// ���̸����ơ��֥�
$html_s = Search_Table($form);



/****************************/
//HTML�إå�
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title,"amenity.js", "global.css", "", "ie8");

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
$page_title .= "��".$form->_elements[$form->_elementIndex["href_2-2-113"]]->toHtml();
if($group_kind == "2"){
    $page_title .= "��".$form->_elements[$form->_elementIndex["href_2-2-116"]]->toHtml();
}
$page_title .= "��".$form->_elements[$form->_elementIndex["href_2-2-204"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["href_2-2-111"]]->toHtml();
$page_header = Create_Header($page_title);


/****************************/
//�ڡ�������
/****************************/

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
    'html'          => "$html",
    'html_sum_table'    => "$html_sum_table",
    'form_num_mess' => "$form_num_mess",
	'auth_r_msg'    => "$auth_r_msg",
	//'charges_msg'   => "$charges_msg",
    //'chargee_msg'   => "$chargee_msg",
	//'decimal_msg'   => "$decimal_msg",
    //'nodecimal_msg' => "$nodecimal_msg",
));

// html��assign
$smarty->assign("html", array(
    "html_s"        =>  $html_s,
));


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


//print_array($_POST);


/***   �����������   ***/

/*** �ʲ�������ؿ� ***/


/**
 *
 * ��ô���ԤΥơ��֥��ô����̾�Ȥ��Ρˤ�����
 *
 * @param       string      $staff_name     �����å�̾
 * @param       string      $staff_cd       �����å�CD
 * @param       string      $ware_name      ô���Ҹ�̾
 * @param       string      $ord_sdate      ɽ�����֡ʻϤ��
 * @param       string      $ord_edate      ɽ�����֡ʽ�����
 * @param       object      $form           QuickForm�Υ��֥�������
 * @param       int         $staff_id       �����å�ID
 * @param       int         $staff_ware_id  ô���Ҹ�ID
 * @param       int         $basesware_id   �����Ҹ�ID
 * @param       int         $return_num     ���ڡ�������������Կ�
 * @param       int         $page_return    ���ߤιԿ�
 *
 * @return      string      ��������HTML
 * @return      int         ���ߤιԿ�
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2007/02/16)
 *
 */
function L_Html_U_Table_Header($staff_name,$staff_cd,$ware_name, $ord_sdate, $ord_edate, $form, $staff_id, $staff_ware_id, $bases_ware_id, $return_num, $page_return)
{
	$staff_cd = str_pad($staff_cd,4,"0", STR_PAD_LEFT);

    $page_return += 3;

    if (bcmod($page_return-2, $return_num) == 0 && $page_return != 0){
        $page_return_print = " style=\"page-break-before: always;\"";
    }else
    if (bcmod($page_return-1, $return_num) == 0 && $page_return != 0){
        $page_return_print = " style=\"page-break-before: always;\"";
    }else
    if (bcmod($page_return-0, $return_num) == 0 && $page_return != 0){
        $page_return_print = " style=\"page-break-before: always;\"";
    }else{
        $page_return_print = null;
    }

    $page_return += 1;

    $html  = "<br".$page_return_print.">";
    $html .= "<table width=\"970px\" valign=\"top\"><tr><td align=\"left\">";

    $html .= "<table  class=\"Data_Table\" border=\"1\" width=\"500\">\n";
    $html .= "    <tr>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>ô����</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">".$staff_cd." : ".$staff_name."</td>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>ô���Ҹ�</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">$ware_name</td>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>ͽ������</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">$ord_sdate �� $ord_edate</td>\n";
    $html .= "    </tr>\n";
    $html .= "</table>\n";

    $form->addElement("hidden", "hdn_staff_ware_id[$staff_id]", $staff_ware_id);
    $form->addElement("hidden", "hdn_bases_ware_id[$staff_id]", $bases_ware_id);

    return array($html, $page_return);

}


/**
 *
 * ��ô���ԤΥơ��֥�إå��ʳƾ��ʤΡˤ�����
 *
 * @param       int         $return_num     ���ڡ�������������Կ�
 * @param       int         $page_return    ���ߤιԿ�
 *
 * @return      string      ��������HTML
 * @return      int         ���ߤιԿ�
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/01)
 *
 */
function L_Html_Table_Header($return_num, $page_return)
{

    $page_return_print = (bcmod($page_return, $return_num) == 0) ? " style=\"page-break-before: always;\"" : null;
    $page_return += 1;

    $html  = "<br".$page_return_print.">";
    //$html  = "<table class=\"List_Table\" border=\"1\" width=\"650\">\n";
    $html .= "<table class=\"List_Table\" border=\"1\" width=\"970\">\n";
    $html .= "    <tr align=\"center\">\n";
    $html .= "        <td class=\"Title_Pink\"><b>No.</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>���ʥ�����</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>�Ͷ�ʬ</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>������ʬ</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>����ʬ��</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>����̾</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>ͽ��вٿ�</b></td>\n";
    $html .= "    </tr>\n";

    return array($html, $page_return);

}


/**
 *
 * �ơ��֥��1������
 * @param       int         $no             �ơ��֥��ɽ��������ֹ�
 * @param       string      $goods_cd       ����CD
 * @param       string      $goods_name     ����̾
 * @param       int         $goods_num      �߸˰�ư�ե�����˾��ʿ�
 * @param       object      $form           QuickForm�Υ��֥�������
 * @param       int         $staff_id       �����å�ID
 * @param       int         $goods_id       ����ID
 * @param       string      $g_goods_name   �Ͷ�ʬ̾
 * @param       string      $product_name   ������ʬ̾
 * @param       string      $g_product_name ����ʬ��̾
 * @param       int         $return_num     ���ڡ�������������Կ�
 * @param       int         $page_return    ���ߤιԿ�
 * @param       string      $count_div      ���׶�ʬ
 *
 * @return      string      ��������HTML
 * @return      int         ���ߤιԿ�
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/01)
 *
 */
function L_Html_Draw_Row($no, $goods_cd, $goods_name, $goods_num, $form, $staff_id, $goods_id, $g_goods_name, $product_name, $g_product_name, $return_num, $page_return, $count_div)
{
    global $g_form_style, $g_form_option;

    $page_return_print = (bcmod($page_return, $return_num) == 0) ? " style=\"page-break-before: always;\"" : null;
    $page_return += 1;

    $html  = "    <tr class=\"Result1\"".$page_return_print.">\n";
    $html .= "        <td align=\"right\">$no</td>\n";
    $html .= "        <td align=\"left\">$goods_cd</td>\n";
    $html .= "        <td align=\"left\">$g_goods_name</td>\n";
    $html .= "        <td align=\"left\">$product_name</td>\n";
    $html .= "        <td align=\"left\">$g_product_name</td>\n";
    $html .= "        <td align=\"left\">$goods_name</td>\n";

    //$form->setConstants(array("form_num[$staff_id][$goods_id]" => $goods_num));

    $html .= "        <td align=\"right\">";
    if($count_div == "1"){
        $form_num_style = "style=\"text-align:right; $g_form_style\" $g_form_option";
    }else{
        $form_num_style = "style=\"text-align:right; $g_form_style border: #ffffff 1px solid; background-color: #ffffff;\" readonly tabindex=\"-1\"";
    }
    $form->addElement(
        "text", 
        "form_num[$staff_id][$goods_id]", 
        "", 
        "size=\"6\" maxLength=\"5\" $form_num_style"
    );
    $html .= $form->_elements[$form->_elementIndex["form_num[$staff_id][$goods_id]"]]->toHtml();
    $html .= "</td>\n";

    $html .= "    </tr>\n";

    return array($html, $page_return);

}


/**
 *
 * ��ô���ԤΥơ��֥�եå��ʳƾ��ʤΡˤ�����
 *
 * @param       int         $goods_num_sum      ���ʹ�׿�
 * @param       string      $basic_ware_name    ���ܽв��Ҹ�̾
 * @param       string      $staff_ware_name    ���ô���Ԥ�ô���Ҹ�̾
 * @param       object      $form               QuickForm�Υ��֥�������
 * @param       int         $staff_id           �����å�ID
 * @param       int         $disabled           �ɼ�긢��
 * @param       int         $return_num         ���ڡ�������������Կ�
 * @param       int         $page_return        ���ߤιԿ�
 * @param       string      $count_div          ���׶�ʬ
 *
 * @return      string      ��������HTML
 * @return      int         ���ߤιԿ�
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/01)
 *
 */
function L_Html_Table_Footer($goods_num_sum, $basic_ware_name, $staff_ware_name, $form, $staff_id,$disabled, $return_num, $page_return, $count_div)
{

    $page_return_print = (bcmod($page_return, $return_num) == 0 && $page_return != 0) ? " style=\"page-break-before: always;\"" : null;
    $page_return += 1;

    $html  = "    <tr class=\"Result2\"".$page_return_print.">\n";
    $html .= "        <td align=\"left\"><b>���</b></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"><b>$goods_num_sum</b></td>\n";
    $html .= "    </tr>\n";
    $html .= "</table>\n";

    //���פ����ָ�ξ��Τ߰�ư�ܥ���ɽ��
    if($count_div == "1"){

        $html .= "<table border=\"0\" width=\"100%\">\n";
        $html .= "    <tr>\n";
        $html .= "        <td align=\"right\" valign=\"middle\">";
        $html .=             "<font color = \"#555555\">".$basic_ware_name." ���� ".$staff_ware_name." �� </font>";

        //��ư�ܥ���
        $form->addElement(
            "submit","move_button[$staff_id]","�ܡ�ư",
            "onClick=\"javascript:return Dialogue_2('��ư���ޤ���','".$_SERVER["PHP_SELF"]."', '$staff_id', 'hdn_move_staff_id')\" $disabled"
        );
        $html .= $form->_elements[$form->_elementIndex["move_button[$staff_id]"]]->toHtml();
        $html .=         "</td>\n";
        $html .= "    </tr>\n";
        $html .= "</table>\n";

    }

    $html .= "</td></tr></table>\n";
    $html .= "<br>\n";

    return array($html, $page_return);

}


/**
 *
 * ���ʹ�פΥơ��֥������
 *
 * @param       string      $ord_sdate          ɽ�����֡ʻϤ��
 * @param       string      $ord_edate          ɽ�����֡ʽ�����
 * @param       string      $basic_ware_name    ���ܽв��Ҹ�̾
 * @param       array       $array_goods_sum    �ơ��֥��ɽ�����뾦�ʤ�����
 * @param       object      $form               QuickForm�Υ��֥�������
 * @param       boolean     $err_flg_num        ���顼�ե饰��Ⱦ�ѿ��ͥ����å���
 * @param       int         $disabled           �ɼ�긢��
 * @param       int         $page_return        ���ߤιԿ�
 * @param       string      $count_div          ���׶�ʬ
 *
 * @return      string      ��������HTML
 * @return      int         ���ߤιԿ�
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2007/02/16)
 *
 */
//function L_Html_SumTable($ord_sdate, $ord_edate, $basic_ware_name, $array_goods_sum, $form, $err_flg_num,$disabled)
function L_Html_SumTable($ord_sdate, $ord_edate, $array_goods_sum, $form, $err_flg_num,$disabled, $page_return, $count_div)
{

    $html  = "<fieldset style=\"width:970px;\">\n";
    $html .= "<legend><font color=\"#555555\" style=\"font-size:16px\"><b>��ô����</b></font></legend>\n";
    $html .= "<br>\n";

    $html .= "<table width=\"100%\"><tr><td align=\"left\">";

    $html .= "<table class=\"Data_Table\" border=\"1\" width=\"380\">\n";
    $html .= "    <tr>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>ô����</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">��ô���Է�</td>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>ͽ������</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">$ord_sdate �� $ord_edate</td>\n";
    $html .= "    </tr>\n";
    $html .= "</table>\n";
    $html .= "<br>\n";

    //$html .= "<font color = \"#555555\">�� ".$basic_ware_name." �θ��߸˿���ȯ��Ĥ�ɽ�����Ƥ��ޤ�</font>\n";
    $html .= "<font color = \"#555555\">�� �Ƶ����Ҹˤθ��߸˿���ȯ��Ĥι�פ�ɽ�����Ƥ��ޤ�</font>\n";
    $html .= "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
    $html .= "    <tr align=\"center\">\n";
    $html .= "        <td class=\"Title_Pink\"><b>No.</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>���ʥ�����</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>�Ͷ�ʬ</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>������ʬ</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>����ʬ��</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>����̾</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>���߸˿�</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>ȯ���</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>ͽ��вٿ�</b></td>\n";
    $html .= "    </tr>\n";

    // ���ڡ���ñ�̥������
    $page_return += 5;

    //1��ɽ��
    $array_count = count($array_goods_sum);

//for($a=0;$a<10;$a++){   // fukuda test
    for($i=0, $stock_num_sum=0, $inventory_on_order_num_sum=0, $num_sum=0;$i<$array_count;$i++){
        $page_return_print = (bcmod($page_return, 58) == 0) ? " style=\"page-break-before: always;\"" : null;
        $page_return += 1;
        $html .= "    <tr class=\"Result1\" $page_return_print>\n";
        $html .= "        <td align=\"right\">".(string)($i+1)."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["goods_cd"]."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["g_goods_name"]."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["product_name"]."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["g_product_name"]."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["goods_name"]."</td>\n";
        $html .= "        <td align=\"right\">".$array_goods_sum[$i]["stock_num"]."</td>\n";
        $html .= "        <td align=\"right\">".$array_goods_sum[$i]["inventory_on_order_num"]."</td>\n";
        $html .= "        <td align=\"right\">";

        $goods_id = $array_goods_sum[$i]["goods_id"];

/*
        if(!$err_flg_num){
            $form->setConstants(array("form_num_all[$goods_id]" => $array_goods_sum[$i]["num"]));
        }
*/

        $form->addElement(
            "text", 
            "form_num_all[$goods_id]", 
            "", 
            "size=\"6\" maxLength=\"5\" style=\"text-align:right; $g_form_style border: #ffffff 1px solid; background-color: #ffffff;\" readonly tabindex=\"-1\""
        );
        $html .= $form->_elements[$form->_elementIndex["form_num_all[$goods_id]"]]->toHtml();
        $html .=         "</td>\n";
        $html .= "    </tr>\n";

        $stock_num_sum = $stock_num_sum + $array_goods_sum[$i]["stock_num"];
        $inventory_on_order_num_sum = $inventory_on_order_num_sum + $array_goods_sum[$i]["inventory_on_order_num"];
        $num_sum = $num_sum + $array_goods_sum[$i]["num"];
    }
//}   // fukuda test

    //��׹�ɽ��
    $page_return_print = (bcmod($page_return, 58) == 0) ? " style=\"page-break-before: always;\"" : null;
    $page_return += 1;
    $html .= "    <tr class=\"Result2\" $page_return_print>\n";
    $html .= "        <td align=\"left\"><b>���</b></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"><b>$stock_num_sum</b></td>\n";
    $html .= "        <td align=\"right\"><b>$inventory_on_order_num_sum</b></td>\n";
    $html .= "        <td align=\"right\"><b>$num_sum</b></td>\n";
    $html .= "    </tr>\n";
    $html .= "</table>\n";

    $html .= "</td></tr><tr><td align=\"right\">";

    //���פ����ָ�ξ��Τ߹�ס�����ư�ܥ���ɽ��
    if($count_div == "1"){

        $html .= "<table border=\"0\" width=\"650\">\n";
        $html .= "    <tr>\n";
        $html .= "        <td align=\"right\" valign=\"middle\">";
        $html .=             "<font color=\"#555555\">ô���Ԥ�ͽ��вٿ����ѹ��������ϡ�����ư�ܥ���򲡤����˹�ץܥ���򲡤��Ʋ�������</font>";
        //��ץܥ���
        $form->addElement("submit","sum_button","���", "$disabled");
        $html .= $form->_elements[$form->_elementIndex["sum_button"]]->toHtml();
        $html .= "<br>\n";
        $html .=             "<font color = \"#555555\">�Ƶ����Ҹ� ���� ��ô���Ҹ� �� </font>";
        //��ư�ܥ���
        $form->addElement(
            "submit","move_all_button","�����ܡ�ư",
            "onClick=\"javascript:return Dialogue_2('��ư���ޤ���','".$_SERVER[PHP_SELF]."', 'ALL', 'hdn_move_staff_id')\" $disabled"
        );
        $html .= $form->_elements[$form->_elementIndex["move_all_button"]]->toHtml();
        $html .= "        </td>\n";
        $html .= "    </tr>\n";
        $html .= "</table>";

        $page_return += 2;
    }

    $html .= "</td></tr></table>";

    $html .= "</fieldset>\n";

    // ���ڡ���ñ�̥������
    $page_return += 3;

    return array($html, $page_return);

}



/**
 *
 * ��ư��ɽ���Ѥ�SQL����
 *
 * @param       object      $form               QuickForm�Υ��֥�������
 * @param       string      $count_div          ���׶�ʬ
 *                                                  "1" �����ָ�
 *                                                  "2" ��������
 * @param       string      $ord_sdate          ͽ�������ʻϤ��
 * @param       string      $ord_edate          ͽ�������ʽ�����
 * @param       string      $charge_cd          ô���ԥ����ɡʥƥ����ȡ�
 * @param       string      $charge_id          ô����ID�ʥ��쥯�ȡ�
 * @param       string      $charge_decimal     ô���ԥ����ɡʥ���޶��ڤ��
 * @param       string      $charge_nodecimal   ����ô���ԥ����ɡʥ���޶��ڤ��
 * @param       string      $part_id            ����ID
 * @param       string      $bases_ware_id      ô���Ԥε����Ҹ�ID
 * @param       int         $branch_id          ô����ŹID
 * @param       string      $order_sql          SQL��ORDER��˻��ꤹ�륫���
 * @param       boolean     $err_flg            ���顼�ե饰��ͽ�������������������å���
 * @param       int         $staff_id           ��ư�ܥ��󲡲�����ô���Ԥ�ID
 *
 * @return      array       0 => ��������SQL
 *                          1 => ɽ�����֡ʻϤ�ˡ�yyyy-mm-dd������
 *                          2 => ɽ�����֡ʽ����ˡ�yyyy-mm-dd������
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.2.0 (2007/04/16)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/04/16      ����¾      kajioka-h   ���������ѹ����б�
 *  2007/06/22      xx-xxx      kajioka-h   ���������פ��ǽ��
 */
function L_List_SQL_Get($form, $count_div, $ord_sdate, $ord_edate, $charge_cd, $charge_id, $charge_decimal, $charge_nodecimal, $part_id, $bases_ware_id, $branch_id, $order_sql, $err_flg, $staff_id = NULL)
{
    global $db_con;

    $where_sql = "";

    //���顼�ǤϤʤ���硢�����������
    if($err_flg != true){

        /*** ��������Ƹ���������Ϳ ***/

        //ͽ�������ν�᤬���ꤵ��Ƥ�����
        if($ord_sdate != "0000-00-00"){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_aorder_h.ord_time >= '$ord_sdate' \n";
        }else{
            //�ơ��֥�δ��֤����Ѥ��뤿�ᡢ�����
            $ord_sdate = "";
        }

		/*
		 * ����
		 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
		 * ��2006/11/02��02-040��������suzuki-t������������ɽ������ʬɽ��
		 *
		*/
		//ͽ�������ν���꤬���ꤵ��Ƥ��ʤ���硢��������ɽ�����֤Υǡ���������
        if($ord_edate == "0000-00-00"){
			//������ɽ�����ּ���
			require_once(INCLUDE_DIR."function_keiyaku.inc");
			$cal_array = Cal_range($db_con,$_SESSION[client_id],true);
			$ord_edate   = $cal_array[1];     //�оݽ�λ����

			$ord_cal["form_round_day"]["ey"] = str_pad(substr($ord_edate,0,4),4,"0", STR_PAD_LEFT);
			$ord_cal["form_round_day"]["em"] = str_pad(substr($ord_edate,5,2),2,"0", STR_PAD_LEFT);
			$ord_cal["form_round_day"]["ed"] = str_pad(substr($ord_edate,8,2),2,"0", STR_PAD_LEFT);
			$form->setConstants($ord_cal);

		}

        $where_sql .= "    AND \n";
        $where_sql .= "    t_aorder_h.ord_time <= '$ord_edate' \n";

        //ô���ԥ����ɤ����ꤵ��Ƥ�����
        if($charge_cd != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_staff.charge_cd = ".(int)$charge_cd." \n";
        }

        //ô����ID�����ꤵ��Ƥ�����
        if($charge_id != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_staff.staff_id = ".(int)$charge_id." \n";
        }

        //ô���ԥ����ɡʥ���޶��ڤ�ˤ����ꤵ��Ƥ�����
        if($charge_decimal != null){
            $array_charge = explode(",",$charge_decimal);
            $where_sql .= "    AND ( \n";

            $count = count($array_charge);
            for($i=0;$i<$count;$i++){
                $where_sql .= "    t_staff.charge_cd = ".(int)$array_charge[$i]." \n";
                $where_sql .= ($i != $count-1) ? " OR \n" : " ) \n";
            }
        }

        //����ô���ԥ����ɡʥ���޶��ڤ�ˤ����ꤵ��Ƥ�����
        if($charge_nodecimal != null){
            $array_nocharge = explode(",",$charge_nodecimal);
            $where_sql .= "    AND ( \n";

            $count = count($array_nocharge);
            for($i=0;$i<$count;$i++){
                $where_sql .= "    t_staff.charge_cd != ".(int)$array_nocharge[$i]." \n";
                $where_sql .= ($i != $count-1) ? " AND \n" : " ) \n";
            }
        }

        //����
        if($part_id != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_part.part_id = $part_id \n";
        }

        //�����Ҹ�
        if($bases_ware_id != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_bases_ware.ware_id = $bases_ware_id \n";
        }

        //ô����Ź
        if($branch_id != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_branch.branch_id = $branch_id \n";
        }
//echo $where_sql;

        /*** �����ޤǳƸ���������Ϳ ***/

        /*** ��������SQL������ ***/
        $sql  = "SELECT \n";
        $sql .= "    t_aorder_staff.staff_id, \n";      // 0 �����å�ID
        $sql .= "    t_staff.charge_cd, \n";            // 1 �����å�CD
        $sql .= "    t_staff.staff_name, \n";           // 2 �����å�̾
        //$sql .= "    t_ware.ware_id, \n";             //ô���Ԥ�ô���Ҹ�ID
        //$sql .= "    t_ware.ware_name, \n";           //ô���Ԥ�ô���Ҹ�̾
        $sql .= "    t_charge_ware.ware_id AS charge_ware_id, \n";      // 3 ô���Ҹ�ID
        $sql .= "    t_charge_ware.ware_name AS charge_ware_name, \n";  // 4 ô���Ҹ�̾
        $sql .= "    t_aorder_h.aord_id, \n";           // 5 ����ID
        $sql .= "    t_aorder_h.ord_no, \n";            // 6 �����ֹ�
        $sql .= "    t_aorder_d.aord_d_id, \n";         // 7 ����ǡ���ID
        $sql .= "    t_aorder_ship.goods_id, \n";       // 8 ����ID
        $sql .= "    t_goods.goods_cd, \n";             // 9 ����CD
        $sql .= "    t_goods.goods_name, \n";           //10 ����̾
        //$sql .= "    t_goods.goods_cname, \n";           //10 ����̾��ά�Ρ�
        $sql .= "    t_aorder_ship.num, \n";            //11 ���ʿ���
        $sql .= "    t_branch.branch_id, \n";           //12 ��ŹID
        $sql .= "    t_branch.branch_cd, \n";           //13 ��ŹCD
        $sql .= "    t_branch.branch_name, \n";         //14 ��Ź̾
        $sql .= "    t_bases_ware.ware_id AS bases_ware_id, \n";        //15 �����Ҹ�ID
        $sql .= "    t_bases_ware.ware_name AS bases_ware_name, \n";    //16 �����Ҹ�̾
        $sql .= "    t_g_goods.g_goods_name, \n";       //17 �Ͷ�ʬ̾
        $sql .= "    t_product.product_name, \n";       //18 ������ʬ̾
        $sql .= "    t_g_product.g_product_name \n";    //19 ����ʬ��̾

        $sql .= "FROM \n";
        $sql .= "    t_aorder_h \n";
        $sql .= "    INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id \n";
        $sql .= "        AND t_aorder_h.move_flg = 'f' \n";         //��ư�ѤǤʤ�
        $sql .= "    INNER JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
        $sql .= "        AND t_aorder_staff.staff_div = '0' \n";    //���ô���Ԥϥᥤ��1�����ʥ��֤�ޤ��Ƚ�ʣ�����
        $sql .= "    INNER JOIN t_aorder_ship ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id \n";
        $sql .= "    INNER JOIN t_goods ON t_aorder_ship.goods_id = t_goods.goods_id \n";
        $sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
        $sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
        $sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
        $sql .= "    INNER JOIN t_staff ON t_aorder_staff.staff_id = t_staff.staff_id \n";
        $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id \n";
        $sql .= "        AND t_attach.shop_id = ".$_SESSION["client_id"]." \n";
        //$sql .= "    LEFT JOIN t_ware ON t_attach.ware_id = t_ware.ware_id \n";
        $sql .= "    INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        $sql .= "    INNER JOIN t_branch ON t_part.branch_id = t_branch.branch_id \n";
        $sql .= "    INNER JOIN t_ware AS t_bases_ware ON t_branch.bases_ware_id = t_bases_ware.ware_id \n";
        $sql .= "    INNER JOIN t_ware AS t_charge_ware ON t_attach.ware_id = t_charge_ware.ware_id \n";

        $sql .= "WHERE \n";
        //(2006/08/29) kaji ��Ԥξ���Ĥ���
        $sql .= "    ( \n";
        $sql .= "        (t_aorder_h.contract_div = '1' AND t_aorder_h.shop_id = ".$_SESSION["client_id"]." AND t_aorder_h.confirm_flg = 'f') \n";
        $sql .= "        OR \n";
        $sql .= "        (t_aorder_h.contract_div = '2' AND t_aorder_h.act_id = ".$_SESSION["client_id"]." AND (t_aorder_h.trust_confirm_flg = 'f' AND t_aorder_h.cancel_flg = 'f')) \n";
        $sql .= "    ) \n";

        $sql .= "    AND \n";
        if($count_div == "1"){
            $sql .= "    t_aorder_h.ord_no IS NOT NULL \n";
        }else{
            $sql .= "    t_aorder_h.ord_no IS NULL \n";
        }

        //�������ͽ����ɼ�Ͻ��פ��ʤ�
        $sql .= "    AND \n";
        $sql .= "    t_aorder_h.del_flg = false \n";

        $sql .= $where_sql;
/* suzuki  */
		//��ô���Ԥΰ�ư�ܥ��󲡲�Ƚ��
        if($staff_id != NULL){
			//��ư�ܥ��󲡲�����ô���Ԥ�ID
			$sql .= " AND t_staff.staff_id = $staff_id \n";
		}

        $sql .= "ORDER BY \n";
        $sql .= "    t_staff.charge_cd, \n";
        $sql .= "    ".$order_sql." \n";

        $sql .= ";\n";
//print_array($sql);
        $return = array($sql, $ord_sdate, $ord_edate);

        /*** �����ޤ�SQL������ ***/

    }else{
        $return = false;
    }

    return $return;

}

?>
