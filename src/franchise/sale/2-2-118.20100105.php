<?php
/**
 *
 * ͽ����
 *
 *
 * @author      
 * @version     
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/06/07      �׷�64      kajioka-h   �����ɼȯ�Ԥ�ͽ�����Ѥ��Ѥ���
 *  2007/06/11      B0702-060   kajioka-h   �ѹ��ΤȤ����Ҹ�̾�����˥������󥰤���Ƥ��ʤ��Х�����
 *  2007/06/13      ����¾14    kajioka-h   �����⡢�ԥ��ꥢ
 *  2007/06/20      xx-xxx      kajioka-h   ��ɼʣ��
 *  2007/07/03      xx-xxx      kajioka-h   ��ɼ�ֹ�����֤��ʤ��褦�˻����ѹ�
 *                  B0702-068   kajioka-h   �ѹ����̤������衢����褬�ѹ��Ǥ��ʤ��Х�����
 *  2007/08/29                  kajioka-h   �����ɼ�������������Τǰ켰���ξ�硢������׳ۤϸ���ñ����Ʊ���ˤ���
 *  2007/11/28                  kajioka-h   �����ɼ�������������ۤξ�硢�����ꥨ�顼�ˤʤ�Х�����
 *                              kajioka-h   �����ɼ�����������Ϥ�������Ͽ���褦�Ȥ���ȷٹ�ɽ�������Х�����
 *  2009/09/09                  aoyama-n    �Ͱ���ǽ�ɲ�
 *  2009/09/09                  aoyama-n    �����ʤ����ξ��ʤ���̾�ѹ��ե饰��о��ߥ�����
 *  2009/10/06      rev.1.3     kajioka-h   ͽ����������������2����ʾ������ȷٹ��å������ɲ�
 *  2009/12/22                  aoyama-n    ��Ψ��TaxRate���饹�������
 *
 */

$page_title = "ͽ������ɼȯ��";

//�Ķ�����ե�����
require_once("ENV_local.php");

//�����ʬ�δؿ�
require_once(PATH ."function/trade_fc.fnc");

//�����ʡ���ưPOST������δؿ�
require_once(INCLUDE_DIR ."function_keiyaku.inc");

//���顼��å������γ����ե�����
require_once(INCLUDE_DIR ."error_msg_list.inc");

//��������ID��Ͽ�������ؿ�
require_once(INCLUDE_DIR ."daily_slip.inc");


//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB��³
$db_con = Db_Connect();
//���������ξ�������������к�
//$db_con = (strpos($_SERVER["PHP_SELF"], "demo") !== false) ? Db_Connect() : Db_Connect("amenity_kaji_make");
//echo "<font color=red style=\"font-family: 'HGS�Խ���';\"><b>�Խ���ˤĤ������ޤ���Ͽ�Ǥ��ޤ���</b></font>";


// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

// GET����ID�������������å�
if (Get_Id_Check_Db($db_con, $_GET["aord_id"], "aord_id", "t_aorder_h", "num") == false && $_GET["aord_id"] != null){
    Header("Location: ../top.php");
    exit;
}

/*****************************/ 
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("contract");
}


/****************************/
//�����ѿ�����
/****************************/
$shop_id     = $_POST["hdn_cclient_id"];
$intro_account_id   = $_POST["hdn_intro_account_id"];
$client_h_id = $_SESSION["client_id"];
$rank_cd     = $_SESSION["rank_cd"];
$e_staff_id  = $_SESSION["staff_id"];
$group_kind  = $_SESSION["group_kind"];
//$sale_id     = $_GET["sale_id"];     //���ID
//Get_Id_Check3($sale_id);
$aord_id     = $_GET["aord_id"];     //����ID
$done_flg    = $_GET["done_flg"];     //��Ͽ��λ�ե饰
$slip_del_flg = $_GET["slip_del_flg"];  //��ɼ����ե饰
//$hand_slip_flg = true;                  //�����ɼ�ե饰
$hand_plan_flg = true;                  //ͽ����ե饰

$back_display = $_GET["back_display"];   //ͽ�����٤����ܸ�
//ͽ��ǡ������٤�ɽ�����볺���������Ƥμ���ID
if($_POST["aord_id_array"] != null){
    $array_id = $_POST["aord_id_array"];
}elseif($_GET["aord_id_array"] != null){
    $array_id   = $_GET["aord_id_array"];
}
//���󥷥ꥢ�饤����
$aord_id_array = stripslashes($array_id);
$aord_id_array = urldecode($aord_id_array);
$aord_id_array = unserialize($aord_id_array);
//print_array($aord_id_array);



//����ID��hidden�ˤ���ݻ�����
if($_GET["aord_id"] != NULL){
    if($_GET["slip_copy"] != "true"){
        $set_id_data["hdn_aord_id"] = $aord_id;
        $form->setConstants($set_id_data);
    }
}else{
    $aord_id = $_POST["hdn_aord_id"];
}

//����ʬ
$contract_div = ($_POST["daiko_check"] == "1" || $_POST["daiko_check"] == null) ? "1" : $_POST["daiko_check"];
//print_array($contract_div, "����ʬ");


$error_flg = false;

#2009-12-22 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($client_h_id);


/****************************/
// ���������Ѥ�
/****************************/

//������ѡ��ޤ��Ϻ���Ѥξ�礹���
if($aord_id != null){
    $sql  = "SELECT confirm_flg FROM t_aorder_h WHERE aord_id = $aord_id AND ";
    $sql .= ($group_kind == "2") ? "shop_id IN (".Rank_Sql().");" : "shop_id = $client_h_id;";
    $result = Db_Query($db_con, $sql);
    //Get_Id_Check($result);
    if(pg_num_rows($result) != 0){
        if(pg_fetch_result($result, 0, "confirm_flg") == "t"){
            $renew_flg = "true";
            //if($_POST["hdn_comp_button"] == "�ϡ���"){
			//rev.1.3 ͽ������2����ʾ�Υ��Ƥ���̵��ܥ��󲡲����ɲ�
            if($_POST["hdn_comp_button"] == "�ϡ���" || $_POST["form_lump_change_warn"] == "�ٹ��̵�뤷������"){
                $slip_renew_mess = $h_mess[48];
                $error_flg = true;
            }
        }else{
            $renew_flg = "false";
        }
    }else{
        $renew_flg = "false";
    }
}else{
    $renew_flg = "false";
}

if($renew_flg == "true"){
    $form->freeze();
}


/****************************/
//�������
/****************************/
//ɽ���Կ�
//if($_POST["max_row"] != null){
//    $max_row = $_POST["max_row"];
//}else{
    $max_row = 5;
//}
//�����褬���ꤵ��Ƥ��뤫
//if($_POST["hdn_client_id"] == null || $_POST["hdn_ware_id"] == null){
if($_POST["hdn_client_id"] == null){
    $warning = "����������򤷤Ƥ���������";

}else{
    $warning = null;
    $client_id    = $_POST["hdn_client_id"];
    $ware_id      = $_POST["hdn_ware_id"];
    $coax         = $_POST["hdn_coax"];
    $tax_franct   = $_POST["hdn_tax_franct"];
    $client_shop_id = $_POST["client_shop_id"];
    $client_name  = $_POST["form_client"]["name"];

}


//�����ѹ�Ƚ��
if($aord_id != NULL && $client_id == NULL && $done_flg != "true"){
    //����إå�����SQL
    $sql  = "SELECT \n";
    $sql .= "    t_aorder_h.ord_no, \n";            // 0 �����ֹ�
    $sql .= "    t_aorder_h.client_id, \n";         // 1 ������ID
    $sql .= "    t_aorder_h.client_cd1, \n";        // 2 ������CD1
    $sql .= "    t_aorder_h.client_cd2, \n";        // 3 ������CD2
    $sql .= "    t_aorder_h.client_cname, \n";      // 4 ������̾��ά�Ρ�
    $sql .= "    t_aorder_h.ord_time, \n";          // 5 ͽ������
    $sql .= "    t_aorder_h.arrival_day, \n";       // 6 ������
    $sql .= "    t_aorder_h.ware_id, \n";           // 7 �в��Ҹ�ID
    $sql .= "    t_aorder_h.trade_id, \n";          // 8 �����ʬ
    $sql .= "    t_aorder_h.note, \n";              // 9 ����
    $sql .= "    t_aorder_h.shop_id, \n";           //10 ����å�ID
    $sql .= "    t_aorder_h.claim_id, \n";          //11 ������ID
    $sql .= "    t_aorder_h.claim_div, \n";         //12 �������ʬ
    $sql .= "    t_aorder_h.enter_day, \n";         //13 ��Ͽ��
    $sql .= "    t_aorder_h.intro_account_id, \n";  //14 �Ҳ��ID
    $sql .= "    t_aorder_h.intro_ac_cd1, \n";      //15 �Ҳ��CD1
    $sql .= "    t_aorder_h.intro_ac_cd2, \n";      //16 �Ҳ��CD2
    $sql .= "    t_aorder_h.intro_ac_name, \n";     //17 �Ҳ��̾
    $sql .= "    t_aorder_h.intro_ac_div, \n";      //18 �Ҳ�����ʬ
    $sql .= "    t_aorder_h.intro_ac_price, \n";    //19 �Ҳ����ʸ����
    $sql .= "    t_aorder_h.intro_ac_rate, \n";     //20 �Ҳ�����Ψ��
    $sql .= "    t_aorder_h.act_id, \n";            //21 ��Լ�ID
    $sql .= "    t_aorder_h.act_cd1, \n";           //22 ��Լ�CD1
    $sql .= "    t_aorder_h.act_cd2, \n";           //23 ��Լ�CD2
    $sql .= "    t_aorder_h.act_name, \n";          //24 ��Լ�̾
    $sql .= "    t_aorder_h.act_div, \n";           //25 �������ʬ
    $sql .= "    t_aorder_h.act_request_price, \n"; //26 ������ʸ����
    $sql .= "    t_aorder_h.act_request_rate, \n";  //27 �������Ψ��
    $sql .= "    t_aorder_h.contract_div, \n";      //28 �����ʬ
    $sql .= "    t_aorder_h.reason_cor, \n";        //29 ������ͳ
    $sql .= "    t_aorder_h.route, \n";             //30 ��ϩ
    $sql .= "    t_aorder_staff1.staff_id, \n";     //31 ���ԥᥤ��1
    $sql .= "    t_aorder_staff1.sale_rate, \n";    //32 ���Ψ�ᥤ��1
    $sql .= "    t_aorder_staff2.staff_id, \n";     //33 ���ԥ���2
    $sql .= "    t_aorder_staff2.sale_rate, \n";    //34 ���Ψ����2
    $sql .= "    t_aorder_staff3.staff_id, \n";     //35 ���ԥ���3
    $sql .= "    t_aorder_staff3.sale_rate, \n";    //36 ���Ψ����3
    $sql .= "    t_aorder_staff4.staff_id, \n";     //37 ���ԥ���4
    $sql .= "    t_aorder_staff4.sale_rate, \n";    //38 ���Ψ����4
    $sql .= "    t_aorder_h.ware_name, \n";         //39 �в��Ҹ�̾
    $sql .= "    t_aorder_h.net_amount, \n";        //40 ����ۡ���ȴ��
    $sql .= "    t_aorder_h.tax_amount, \n";        //41 �����ǳ�
    $sql .= "    t_aorder_h.direct_id, \n";         //42 ľ����ID
    $sql .= "    t_aorder_h.advance_offset_totalamount ";   //43 �������껦�۹��

    $sql .= "FROM \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "    LEFT JOIN t_aorder_staff AS t_aorder_staff1 ON t_aorder_h.aord_id = t_aorder_staff1.aord_id \n";
    $sql .= "        AND t_aorder_staff1.staff_div = '0' \n";
    $sql .= "    LEFT JOIN t_aorder_staff AS t_aorder_staff2 ON t_aorder_h.aord_id = t_aorder_staff2.aord_id \n";
    $sql .= "        AND t_aorder_staff2.staff_div = '1' \n";
    $sql .= "    LEFT JOIN t_aorder_staff AS t_aorder_staff3 ON t_aorder_h.aord_id = t_aorder_staff3.aord_id \n";
    $sql .= "        AND t_aorder_staff3.staff_div = '2' \n";
    $sql .= "    LEFT JOIN t_aorder_staff AS t_aorder_staff4 ON t_aorder_h.aord_id = t_aorder_staff4.aord_id \n";
    $sql .= "        AND t_aorder_staff4.staff_div = '3' \n";
    $sql .= "WHERE \n";
    if($group_kind == "2"){
        $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().")\n";
    }else{
        $sql .= "    t_aorder_h.shop_id = $client_h_id ";
    }
    $sql .= "    AND \n";
    $sql .= "    t_aorder_h.aord_id = $aord_id \n";
    $sql .= ";";
//print_array($sql, "����إå����SQL");

    $result = Db_Query($db_con, $sql);

    //GET�ǡ���Ƚ��
    Get_Id_Check($result);
    $h_data_list = Get_Data($result, 2);
//print_array($h_data_list);

    //����ǡ�������SQL
    $sql  = "SELECT \n";
    $sql .= "    t_aorder_d.aord_d_id, \n";         // 0 ����ǡ���ID
    $sql .= "    t_aorder_d.aord_id, \n";           // 1 ����ID
    $sql .= "    t_aorder_d.line, \n";              // 2 ���ֹ�
    $sql .= "    t_aorder_d.sale_div_cd, \n";       // 3 �����ʬ
    $sql .= "    t_aorder_d.serv_print_flg, \n";    // 4 �����ӥ������ե饰
    $sql .= "    t_aorder_d.serv_id, \n";           // 5 �����ӥ�ID
    $sql .= "    t_aorder_d.serv_name, \n";         // 6 �����ӥ�̾
    $sql .= "    t_aorder_d.serv_cd, \n";           // 7 �����ӥ�CD
    $sql .= "    t_aorder_d.goods_print_flg, \n";   // 8 �����ƥ�����ե饰
    $sql .= "    t_aorder_d.goods_id, \n";          // 9 �����ƥ�ID
    $sql .= "    t_aorder_d.goods_cd, \n";          //10 �����ƥ�CD
    $sql .= "    t_aorder_d.official_goods_name, \n";   //11 �����ƥ�̾��������
    $sql .= "    t_aorder_d.goods_name, \n";        //12 �����ƥ�̾��ά�Ρ�
    $sql .= "    t_goods.name_change, \n";          //13 ��̾�ѹ�
    $sql .= "    t_aorder_d.tax_div, \n";           //14 ���Ƕ�ʬ
    $sql .= "    t_aorder_d.num, \n";               //15 ����
    $sql .= "    t_aorder_d.set_flg, \n";           //16 �켰�ե饰
    $sql .= "    t_aorder_d.cost_price, \n";        //17 �Ķȸ���
    $sql .= "    t_aorder_d.sale_price, \n";        //18 ���ñ��
    $sql .= "    t_aorder_d.cost_amount, \n";       //19 �������
    $sql .= "    t_aorder_d.sale_amount, \n";       //20 �����
    $sql .= "    t_aorder_d.egoods_id, \n";         //21 ������ID
    $sql .= "    t_aorder_d.egoods_cd, \n";         //22 ������CD
    $sql .= "    t_aorder_d.egoods_name, \n";       //23 ������̾
    $sql .= "    t_aorder_d.egoods_num, \n";        //24 �����ʿ�
    $sql .= "    t_goods2.name_change, \n";         //25 ������̾�ѹ�
    $sql .= "    t_aorder_d.rgoods_id, \n";         //26 ���ξ���ID
    $sql .= "    t_aorder_d.rgoods_cd, \n";         //27 ���ξ���CD
    $sql .= "    t_aorder_d.rgoods_name, \n";       //28 ���ξ���̾
    $sql .= "    t_aorder_d.rgoods_num, \n";        //29 ���ξ��ʿ�
    $sql .= "    t_goods3.name_change, \n";         //30 ���ξ���̾�ѹ�
    $sql .= "    t_aorder_d.account_price, \n";     //31 ����ñ��
    $sql .= "    t_aorder_d.account_rate, \n";      //32 ����Ψ
    $sql .= "    t_aorder_d.advance_flg, \n";           //33 �����껦�ե饰
    //aoyama-n 2009-09-09
    #$sql .= "    t_aorder_d.advance_offset_amount \n";  //34 �����껦��
    $sql .= "    t_aorder_d.advance_offset_amount, \n";  //34 �����껦��
    $sql .= "    t_goods.discount_flg \n";               //35 �Ͱ��ե饰

    $sql .= "FROM \n";
    $sql .= "    t_aorder_d \n";
    $sql .= "    LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id \n";
    //aoyama-n 2009-09-09
    //�����ʤ����ξ��ʤ���̾�ѹ��ե饰��о��ߥ�����
    #$sql .= "    LEFT JOIN t_goods AS t_goods2 ON t_aorder_d.goods_id = t_goods2.goods_id \n";
    #$sql .= "    LEFT JOIN t_goods AS t_goods3 ON t_aorder_d.goods_id = t_goods3.goods_id \n";
    $sql .= "    LEFT JOIN t_goods AS t_goods2 ON t_aorder_d.egoods_id = t_goods2.goods_id \n";
    $sql .= "    LEFT JOIN t_goods AS t_goods3 ON t_aorder_d.rgoods_id = t_goods3.goods_id \n";

    $sql .= "WHERE \n";
    $sql .= "    aord_id = $aord_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "    t_aorder_d.line \n";
    $sql .= ";";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    $data_list = Get_Data($result, 2);

    //������ξ�������
    $sql  = "SELECT";
    $sql .= "   t_client.client_id,";
    $sql .= "   t_client.coax,";
    $sql .= "   t_client.tax_franct,";
    $sql .= "   t_client_info.cclient_shop ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= "   INNER JOIN t_client_info ON t_client_info.client_id = t_client.client_id ";
    $sql .= " WHERE";
    $sql .= "   t_client.client_id = ".$h_data_list[0][1];
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $client_list = Get_Data($result, 2);


    //--------------------------//
    //�ե�������ͤ�����
    //--------------------------//
    $sale_money = NULL;                        //���ʤ������
    $tax_div    = NULL;                        //���Ƕ�ʬ

    //�إå�������
    $update_goods_data["form_sale_no"]                   = $h_data_list[0][0];       //��ɼ�ֹ�

    $update_goods_data["form_client"]["cd1"]            = $h_data_list[0][2];       //�����襳���ɣ�
    $update_goods_data["form_client"]["cd2"]            = $h_data_list[0][3];       //�����襳���ɣ�
    $update_goods_data["form_client"]["name"]           = $h_data_list[0][4];       //������̾

    //ͽ��������ǯ������ʬ����
    $ex_sale_day = explode('-',$h_data_list[0][5]);
    $update_goods_data["form_delivery_day"]["y"]        = $ex_sale_day[0];          //ͽ������
    $update_goods_data["form_delivery_day"]["m"]        = $ex_sale_day[1];
    $update_goods_data["form_delivery_day"]["d"]        = $ex_sale_day[2];
    $update_goods_data["hdn_former_deli_day"]           = $h_data_list[0][5];		//rev.1.3 �ѹ�����ͽ��������hidden���ݻ�

    //��������ǯ������ʬ����
    $ex_claim_day = explode('-',$h_data_list[0][6]);
    $update_goods_data["form_request_day"]["y"]         = $ex_claim_day[0];         //������
    $update_goods_data["form_request_day"]["m"]         = $ex_claim_day[1];
    $update_goods_data["form_request_day"]["d"]         = $ex_claim_day[2];

    $update_goods_data["hdn_ware_name"]                 = htmlspecialchars($h_data_list[0][39]);    //�в��Ҹ�̾
    //��htmlspecialchars���ʤ��ȥ���äݤ���hidden �� JS �� ���̡������顩��
    $update_goods_data["hdn_ware_id"]                   = $h_data_list[0][7];       //�в��Ҹ�ID
    $update_goods_data["trade_aord"]                    = $h_data_list[0][8];       //�����ʬ
    $update_goods_data["form_note"]                     = $h_data_list[0][9];       //����

    $update_goods_data["hdn_cclient_id"]                = $h_data_list[0][10];      //����å�ID��ô����ŹID��
    $update_goods_data["form_claim"]                    = $h_data_list[0][11].",".$h_data_list[0][12];  //������

    $update_goods_data["hdn_enter_day"]                 = $h_data_list[0][13];      //��Ͽ��

    $intro_account_id                                   = $h_data_list[0][14];      //�Ҳ��ID
    $update_goods_data["hdn_intro_account_id"]          = $intro_account_id;
    $intro_ac_div                                       = $h_data_list[0][18];      //�Ҳ�����ʬ
    $update_goods_data["intro_ac_div[]"]                = $intro_ac_div;
    $update_goods_data["intro_ac_price"]                = $h_data_list[0][19];      //�Ҳ����ʸ����
    $update_goods_data["intro_ac_rate"]                 = $h_data_list[0][20];      //�Ҳ�����Ψ��

    $act_id                                             = $h_data_list[0][21];      //��Լ�ID
    $update_goods_data["hdn_daiko_id"]                  = $act_id;
    $update_goods_data["form_daiko"]["cd1"]             = $h_data_list[0][22];      //��Լ�CD1
    $update_goods_data["form_daiko"]["cd2"]             = $h_data_list[0][23];      //��Լ�CD2
    $update_goods_data["form_daiko"]["name"]            = $h_data_list[0][24];      //��Լ�̾��ά�Ρ�
    $update_goods_data["act_div[]"]                     = $h_data_list[0][25];      //�������ʬ
    $update_goods_data["act_request_price"]             = $h_data_list[0][26];      //��԰������ʸ���ۡ�
    $update_goods_data["act_request_rate"]              = $h_data_list[0][27];      //��԰������ʡ��

    //����褬�����硢�����Τޤ���ʬ�����
    if($act_id != null){
        $sql = "SELECT coax FROM t_client WHERE client_id = $act_id;";
        $result = Db_Query($db_con, $sql);
        $daiko_coax = pg_fetch_result($result, 0, "coax");
        $update_goods_data["hdn_daiko_coax"] = $daiko_coax;
    }


    $contract_div = ($_POST["daiko_check"] != null) ? $contract_div : $h_data_list[0][28];  //�����ʬ
    $update_goods_data["daiko_check"]                   = $contract_div;

    $update_goods_data["form_reason"]                   = $h_data_list[0][29];      //������ͳ

    $h_data_list[0][30]                                 = str_pad($h_data_list[0][30], 4, 0, STR_PAD_LEFT); //��ϩ
    $update_goods_data["form_route_load"][1]            = substr($h_data_list[0][30], 0, 2);
    $update_goods_data["form_route_load"][2]            = substr($h_data_list[0][30], 2, 2);

    $update_goods_data["form_c_staff_id1"]              = $h_data_list[0][31];      //���ԥᥤ��1
    $update_goods_data["form_sale_rate1"]               = $h_data_list[0][32];      //���Ψ�ᥤ��1
    $update_goods_data["form_c_staff_id2"]              = $h_data_list[0][33];      //���ԥ���2
    $update_goods_data["form_sale_rate2"]               = $h_data_list[0][34];      //���Ψ����2
    $update_goods_data["form_c_staff_id3"]              = $h_data_list[0][35];      //���ԥ���3
    $update_goods_data["form_sale_rate3"]               = $h_data_list[0][36];      //���Ψ����3
    $update_goods_data["form_c_staff_id4"]              = $h_data_list[0][37];      //���ԥ���4
    $update_goods_data["form_sale_rate4"]               = $h_data_list[0][38];      //���Ψ����4

    $update_goods_data["form_direct_select"]            = $h_data_list[0][42];      //ľ����


    //�ǡ�������
    $loop_num = count($data_list);
    for($i=0; $i<$loop_num; $i++){
        $update_line = $data_list[$i][2];

        //�Ҳ�����ʬ�ν���ͤ����ꤷ�ʤ�������
        $aprice_array[] = $update_line;

        $update_goods_data["form_divide"][$update_line]             = $data_list[$i][3];        //�����ʬ

        //$update_goods_data["form_print_flg1"][$update_line]         = ($data_list[$i][4] == "t") ? "1" : "";    //�����ӥ������ե饰
        //if($_POST["check_value_flg"] == "t"){
        //}
        $update_goods_data["form_serv"][$update_line]               = $data_list[$i][5];        //�����ӥ�ID

        //$update_goods_data["form_print_flg2"][$update_line]         = ($data_list[$i][8] == "t") ? "1" : "";    //�����ƥ�����ե饰
        //if($_POST["check_value_flg"] == "t"){
        //}
        $update_goods_data["hdn_goods_id1"][$update_line]           = $data_list[$i][9];        //�����ƥ�ID
        $update_goods_data["form_goods_cd1"][$update_line]          = $data_list[$i][10];       //�����ƥ�CD
        $update_goods_data["official_goods_name"][$update_line]     = $data_list[$i][11];       //�����ƥ�̾��������
        $update_goods_data["form_goods_name1"][$update_line]        = $data_list[$i][12];       //�����ƥ�̾��ά�Ρ�
        $update_goods_data["hdn_name_change1"][$update_line]        = $data_list[$i][13];       //��̾�ѹ��ե饰
        $hdn_name_change[1][$update_line]                           = $data_list[$i][13];       //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥ���
        $update_goods_data["hdn_tax_div"][$update_line]             = $data_list[$i][14];       //���Ƕ�ʬ

        $update_goods_data["form_goods_num1"][$update_line]         = $data_list[$i][15];       //����
        //$update_goods_data["form_issiki"][$update_line]             = ($data_list[$i][16] == "t") ? "1" : "";   //�켰

        //ͽ��ǡ������٤����褿���˥����å��ܥå�������������ʤ�����
        if($_POST["check_value_flg"] == "t"){
            $con_data["form_print_flg1"][$update_line]              = ($data_list[$i][4] == "t") ? "1" : "";    //�����ӥ������ե饰
            $con_data["form_print_flg2"][$update_line]              = ($data_list[$i][8] == "t") ? "1" : "";    //�����ƥ�����ե饰
            $con_data["form_issiki"][$update_line]                  = ($data_list[$i][16] == "t") ? "1" : "";   //�켰
        }

        //����ñ�����������Ⱦ�������ʬ����
        $cost_mprice = explode('.', $data_list[$i][17]);
        $update_goods_data["form_trade_price"][$update_line]["1"]   = $cost_mprice[0];          //����ñ��
        $update_goods_data["form_trade_price"][$update_line]["2"]   = ($cost_mprice[1] != null)? $cost_mprice[1] : "00";
        $update_goods_data["form_trade_amount"][$update_line]       = number_format($data_list[$i][19]);    //�������

        //���ñ�����������Ⱦ�������ʬ����
        $sale_mprice = explode('.', $data_list[$i][18]);
        $update_goods_data["form_sale_price"][$update_line]["1"]    = $sale_mprice[0];          //���ñ��
        $update_goods_data["form_sale_price"][$update_line]["2"]    = ($sale_mprice[1] != null)? $sale_mprice[1] : "00";
        $update_goods_data["form_sale_amount"][$update_line]        = number_format($data_list[$i][20]);    //�����

        $update_goods_data["hdn_goods_id3"][$update_line]           = $data_list[$i][21];       //������ID
        $update_goods_data["form_goods_cd3"][$update_line]          = $data_list[$i][22];       //������CD
        $update_goods_data["form_goods_name3"][$update_line]        = $data_list[$i][23];       //������̾
        $update_goods_data["form_goods_num3"][$update_line]         = $data_list[$i][24];       //�����ʿ�
        $update_goods_data["hdn_name_change3"][$update_line]        = $data_list[$i][25];       //������̾�ѹ��ե饰
        $hdn_name_change[3][$update_line]                           = $data_list[$i][25];       //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���

        $update_goods_data["hdn_goods_id2"][$update_line]           = $data_list[$i][26];       //���ξ���ID
        $update_goods_data["form_goods_cd2"][$update_line]          = $data_list[$i][27];       //���ξ���CD
        $update_goods_data["form_goods_name2"][$update_line]        = $data_list[$i][28];       //���ξ���̾
        $update_goods_data["form_goods_num2"][$update_line]         = $data_list[$i][29];       //���ξ��ʿ�
        $update_goods_data["hdn_name_change2"][$update_line]        = $data_list[$i][30];       //���ξ���̾�ѹ��ե饰
        $hdn_name_change[2][$update_line]                           = $data_list[$i][30];       //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���

        //�Ҳ���
        if($intro_account_id != null){
            //����ñ������ξ��ϡָ���ۡ�
            if($data_list[$i][31] != null && $data_list[$i][32] == null){
                $update_goods_data["form_aprice_div"][$update_line] = "2";
                $update_goods_data["form_account_price"][$update_line] = $data_list[$i][31];
            //����Ψ����ξ��ϡ����Ρ�
            }elseif($data_list[$i][31] == null && $data_list[$i][32] != null){
                $update_goods_data["form_aprice_div"][$update_line] = "3";
                $update_goods_data["form_account_rate"][$update_line] = $data_list[$i][32];
            //����ñ��������Ψ�Ȥ���ξ��ϡ֤ʤ���
            }else{
                $update_goods_data["form_aprice_div"][$update_line] = "1";
            }
        //�Ҳ�Ԥ��ʤ����ϡ֤ʤ���
        }else{
            $update_goods_data["form_aprice_div"][$update_line] = "1";
        }

        $update_goods_data["form_ad_offset_radio"][$update_line]    = $data_list[$i][33];       //�����껦�ե饰
        $update_goods_data["form_ad_offset_amount"][$update_line]   = $data_list[$i][34];       //�����껦��

        //aoyama-n 2009-09-09
        $update_goods_data["hdn_discount_flg"][$update_line]        = $data_list[$i][35];       //�Ͱ��ե饰


        $sale_money[]   = $data_list[$i][20];   //����۹��
        $tax_div[]      = $data_list[$i][14];   //���Ƕ�ʬ
    }

    //�������������
    $client_id      = $client_list[0][0];        //������ID
    $coax           = $client_list[0][1];        //�ݤ��ʬ�ʶ�ۡ�
    $tax_franct     = $client_list[0][2];        //ü����ʬ�ʾ����ǡ�
    $client_shop_id = $client_list[0][3];        //������Υ���å�ID
    //$client_shop_id = $h_data_list[0][10];       //������Υ���å�ID
    $warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
    $update_goods_data["client_shop_id"]      = $client_shop_id;

/*
    //���ߤξ�����Ψ
    $sql  = "SELECT ";
    $sql .= "    tax_rate_n ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_id = $client_shop_id;";
    $result = Db_Query($db_con, $sql); 
    $tax_num = pg_fetch_result($result, 0,0);

    $total_money = Total_Amount($sale_money, $tax_div, $coax, $tax_franct, $tax_num, $client_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);
*/
    $sale_money = number_format($h_data_list[0][40]);
    $tax_money  = number_format($h_data_list[0][41]);
    $st_money   = number_format($h_data_list[0][40] + $h_data_list[0][41]);
    $advance_offset_totalamount = ($h_data_list[0][43] == null) ? "" : number_format($h_data_list[0][43]);
    $ad_rest_price = number_format(Advance_Offset_Claim($db_con, $h_data_list[0][5], $client_id, $h_data_list[0][12]));

    //�ե�������ͥ��å�
    $update_goods_data["form_sale_total"]      = $sale_money;
    $update_goods_data["form_sale_tax"]        = $tax_money;
    $update_goods_data["form_sale_money"]      = $st_money;
    $update_goods_data["form_ad_offset_total"] = $advance_offset_totalamount;
    $update_goods_data["form_ad_rest_price"]   = $ad_rest_price;
    $update_goods_data["sum_button_flg"]       = "";

    //������Ͽ�ե饰
    if($_POST["hdn_new_entry"] == null){
        $new_entry = "false";
        $form->setDefaults(array("hdn_new_entry" => "false"));
    }else{
        $new_entry = $_POST["hdn_new_entry"];
    }

//print_array($update_goods_data, "update_goods_data");
    //$form->setConstants($update_goods_data);
    $form->setDefaults($update_goods_data);

    //ͽ��ǡ������٤����褿���ˡ�����Ū��setConstants���ʤ��ȥ����å��ܥå�������������ʤ�
    if($_POST["check_value_flg"] == "t"){
        $form->setConstants($con_data);
    }

    //ͽ��ǡ������٤����ܸ���ʬ�ȡ�����ID�����hidden�˻�������
    $array_id = serialize($aord_id_array);
    $array_id = urlencode($array_id);
    $form->setDefaults(
        array(
            "back_display" => $back_display,
            "aord_id_array" => $array_id,
        )
    );

/*
    //ɽ���Կ�
    if($_POST["max_row"] != NULL){
        $max_row = $_POST["max_row"];
    }else{
        //����ǡ����ο�
        $max_row = count($data_list);
    }
*/
    $max_row = 5;

}else{
/*
    //��ư���֤���ɼ�ֹ����
    //ľ�Ĥξ��
    if($group_kind == "2"){
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
    //FC�ξ��
    }else{
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $client_h_id;";
    }

    $result = Db_Query($db_con, $sql);
    $sale_no = pg_fetch_result($result, 0 ,0);
    $sale_no = $sale_no +1;
    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

    $def_data["form_sale_no"] = $sale_no;
*/

    //ô����
    //$def_data["form_ac_staff_select"] = $e_staff_id;

    //�����ʬ
    $def_data["trade_aord"] = 11;

    //���׾���
    $def_data["form_delivery_day"]["y"] = date("Y");
    $def_data["form_delivery_day"]["m"] = date("m");
    $def_data["form_delivery_day"]["d"] = date("d");

    //������
    $def_data["form_request_day"]["y"] = date("Y");
    $def_data["form_request_day"]["m"] = date("m");
    $def_data["form_request_day"]["d"] = date("d");

    //�в��Ҹ�
/*
    //������桼����ô����Ź�ε����Ҹˤ����
    $sql  = "SELECT \n";
    $sql .= "    t_branch.bases_ware_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_branch \n";
    $sql .= "    INNER JOIN t_part ON t_branch.branch_id = t_part.branch_id \n";
    $sql .= "    INNER JOIN t_attach ON t_part.part_id = t_attach.part_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_attach.staff_id = $e_staff_id \n";
    $sql .= ";";

    $result = Db_Query($db_con,$sql);
    $def_ware_id = pg_fetch_result($result,0,0);

    $def_data["form_ware_select"] = $def_ware_id;
    $def_data["hdn_ware_id"]      = $def_ware_id;
*/

    //ô���ԡʥᥤ��1�ˤ����Ψ��100��
    $def_data["form_sale_rate1"] = "100";

    //������Ͽ�ե饰
    if($_POST["hdn_new_entry"] == null){
        $new_entry = "true";
        $form->setDefaults(array("hdn_new_entry" => "true"));
    }else{
        $new_entry = $_POST["hdn_new_entry"];
    }

    //�Ҳ�����ʬ
    $def_data["intro_ac_div[]"] = ($_POST["intro_ac_div"][0] != null) ? $_POST["intro_ac_div"][0] : "1" ;

    //�������ʬ
    $def_data["act_div[]"] = ($_POST["act_div"][0] != null) ? $_POST["act_div"][0] : "1" ;

    //������
    //�饸���ܥ��������������
    $aprice_array = array();


    //ɽ���Կ�
    //if($_POST["max_row"] != NULL){
    //    $max_row = $_POST["max_row"];
    //}else{
        $max_row = 5;
    //}

}

//�ǡ�����̵�����¶�ʬ�ν��������
for($i=1;$i<=5;$i++){
    if(!in_array($i, $aprice_array)) {
        //�ʤ�
        $def_data["form_aprice_div[$i]"] = "1";
        $def_data["form_ad_offset_radio"][$i] = "1";
    }
}


//ʣ���ɲäξ�硢��������ɼ�ֹ�����
if($_GET["slip_copy"] == "true"){
/*
    //��ư���֤���ɼ�ֹ����
    //ľ�Ĥξ��
    if($_SESSION["group_kind"] == "2"){
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
    //FC�ξ��
    }else{
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = ".$_SESSION["client_id"].";";
    }

    $result = Db_Query($db_con, $sql);
    $sale_no = pg_fetch_result($result, 0 ,0);
    $sale_no = $sale_no +1;
    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

    $def_data["form_sale_no"] = $sale_no;
*/

    $aord_id = "";

/*
    //������Ͽ�ե饰
    if($_POST["hdn_new_entry"] == null){
        $new_entry = "true";
        $form->setDefaults(array("hdn_new_entry" => "true"));
    }
*/

}


$form->setDefaults($def_data);



//���ɽ�������ѹ�
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//����Կ�
$del_history[] = NULL; 

/****************************/
//�Կ��ɲý���
/****************************/
/*
if($_POST["add_row_flg"]==true){
    if($_POST["max_row"] == NULL){
        //����ͤ�POST��̵���١�
        $max_row = 10;
    }else{
        //����Ԥˡ��ܣ�����
        $max_row = $_POST["max_row"]+5;
    }
    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}
*/

/****************************/
//�Ժ������
/****************************/
/*
if($_POST["del_row"] != ""){

    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);
    //��������Կ�
    $del_num     = count($del_history)-1;
}
*/

//***************************/
//����Կ���hidden�˥��å�
/****************************/
/*
$max_row_data["max_row"] = $max_row;
$form->setConstants($max_row_data);
*/



/****************************/
//�����襳�������Ͻ���
/****************************/
if($_POST["client_search_flg"] == true && $done_flg != "true"){
    $client_cd1         = $_POST["form_client"]["cd1"];       //�����襳����1
    $client_cd2         = $_POST["form_client"]["cd2"];       //�����襳����2

    //������ξ�������
    $sql  = "SELECT \n";
    $sql .= "    t_client.client_id, \n";               // 0
    $sql .= "    t_client.shop_id, \n";                 // 1
    $sql .= "    t_client.client_cname, \n";            // 2
    $sql .= "    t_client.coax, \n";                    // 3
    $sql .= "    t_client.tax_franct, \n";              // 4
    $sql .= "    t_client.rank_cd, \n";                 // 5
    $sql .= "    t_client_info.cclient_shop, \n";       // 6
    $sql .= "    t_client_info.intro_account_id, \n";   // 7
    $sql .= "    t_info_account.client_cname, \n";      // 8
    $sql .= "    t_client.trade_id \n";                 // 9 �����ʬ
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_client_info ON t_client.client_id = t_client_info.client_id \n";
    $sql .= "    LEFT JOIN t_client AS t_info_account ON t_client_info.intro_account_id = t_info_account.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_cd1 = '$client_cd1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_cd2 = '$client_cd2' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_div = '1' \n";
    $sql .= "    AND \n";
    if($group_kind == "2"){
        $sql .= "    t_client.shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "   t_client.shop_id = $client_h_id \n";
    }
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
    //�����ǡ���������
    if($num == 1){
        $client_id      = pg_fetch_result($result, 0,0);        //������ID
        $client_shop_id = pg_fetch_result($result, 0,1);        //������Υ���å�ID
        $client_name    = pg_fetch_result($result, 0,2);        //������̾��ά�Ρ�
        $coax           = pg_fetch_result($result, 0,3);        //�ݤ��ʬ�ʾ��ʡ�
        $tax_franct     = pg_fetch_result($result, 0,4);        //ü����ʬ�ʾ����ǡ�
        $rank_cd        = pg_fetch_result($result, 0,5);        //�ܵҶ�ʬ������
        $shop_id        = pg_fetch_result($result, 0,6);        //ô����Ź
        $intro_account_id   = pg_fetch_result($result, 0,7);    //�Ҳ������ID
        $client_ac_name = pg_fetch_result($result, 0,8);        //�Ҳ������̾

        //���������ǡ�����ե�����˥��å�
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = $client_id;
        $client_data["client_shop_id"]      = $client_shop_id;
        $client_data["form_client"]["name"] = $client_name;
        $client_data["hdn_coax"]            = $coax;
        $client_data["hdn_tax_franct"]      = $tax_franct;
        //$client_data["hdn_rank_cd"]         = $rank_cd;
        $client_data["hdn_cclient_id"]      = $shop_id;
        $client_data["hdn_intro_account_id"]    = ($intro_account_id != null) ? $intro_account_id : "";
        $client_data["form_intro_account_name"] = ($intro_account_id != null) ? $client_ac_name : "";

        $warning = null;

        $client_data["daiko_check"]         = $contract_div;    //��Զ�ʬ
        $client_data["trade_aord"]          = pg_fetch_result($result, 0, 9);   //�����ʬ


        //------------------------------------//
        // �ƹԤζ�ۤ�������Τޤ��ǺƷ׻� //
        //------------------------------------//
        //$cost_money  = NULL;    //���ʤθ������
        $sale_money  = NULL;    //���ʤ������
        $tax_div_arr = NULL;    //���Ƕ�ʬ

        for($i = 1; $i <= $max_row; $i++){
            //�����ӥ����ޤ��ϥ����ƥब���Ϥ���Ƥ���ԤΤ߼���
            if($_POST["form_serv"][$i] != null || $_POST["hdn_goods_id1"][$i] != null){

                //���̤���ξ�硢ñ���߿��̡���
                if($_POST["form_goods_num1"][$i] != null){
                    $price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];
                    $price = $price * $_POST["form_goods_num1"][$i];
                //���̤ʤ��ξ�硢��ۡ�0
                }else{
                    $price = 0;
                }
                //������ۤ�ޤ��
                if($contract_div == "1" || $_POST["hdn_daiko_id"] == null){
                    //���ҽ�󡢤ޤ�����Ԥ���������褬���ꤵ��Ƥʤ�����������Τޤ���ʬ
                    $price = Coax_Col($coax, $price);
                }elseif($_POST["hdn_daiko_id"] != null){
                    //�����ɼ�ǡ�����褬���ꤵ��Ƥ�����������Τޤ���ʬ
                    $price = Coax_Col($_POST["hdn_daiko_coax"], $price);
                }

                $client_data["form_trade_amount"][$i] = number_format($price);  //������ۥե������ɽ��
                //$cost_money[] = $price;


                //���ñ����������ۤ�׻�
                if($_POST["form_issiki"][$i] != null){
                    //�켰�˥����å��������硢ñ���ߣ�����
                    $price = $_POST["form_sale_price"][$i][1].".".$_POST["form_sale_price"][$i][2];
                }elseif($_POST["form_goods_num1"][$i] != null){
                    //�켰�ʤ������̤���ξ�硢ñ���߿��̡���
                    $price = $_POST["form_sale_price"][$i][1].".".$_POST["form_sale_price"][$i][2];
                    $price = $price * $_POST["form_goods_num1"][$i];
                }else{
                    //�켰�ʤ������̤ʤ��ξ�硢��ۡ�0
                    $price = 0;
                }
                //����ۤ�ޤ��
                $price = Coax_Col($coax, $price);

                $client_data["form_sale_amount"][$i] = number_format($price);   //����ۥե������ɽ��
                $sale_money[] = $price;


                //�����ƥब���Ϥ���Ƥ�����ϥ����ƥ�β��Ƕ�ʬ�����
                if($_POST["hdn_goods_id1"][$i] != null){
                    $sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
                //�����ƥब�ʤ����ϥ����ӥ��β��Ƕ�ʬ�����
                }else{
                    $sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
                }

                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);    //���Ƕ�ʬ������ˤĤ��
            }
        }

        #2009-12-22 aoyama-n
        #$tax_num = Get_Tax_Rate($db_con, $shop_id);     //������Ρʵ��ô����Ź�ξ�����Ψ�����

        #2009-12-22 aoyama-n
        $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
        $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

/*
        //���ҽ�󡢤ޤ�����Ԥ���������褬���ꤵ��Ƥʤ���硢������������δݤ�Ǥޤ��
        if($contract_div == "1" || $_POST["hdn_daiko_id"] == null){
            $total_money = Total_Amount($cost_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);

        //��Ԥξ�硢�����������δݤ�Ǥޤ��
        }else{
            $total_money = Total_Amount($cost_money, $tax_div_arr, $_POST["hdn_daiko_coax"], $tax_franct, $tax_num, $client_id, $db_con);
        }
        $cost_money  = $total_money[0];     //������ۡ���ȴ��
*/

        $total_money = Total_Amount($sale_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);
        $sale_money  = $total_money[0];     //����ۡ���ȴ��
        $sale_tax    = $total_money[1];     //�����ǳ�

        //�ե�������ͥ��å�
        $client_data["form_sale_total"]   = number_format($sale_money);
        $client_data["form_sale_tax"]     = number_format($sale_tax);
        $client_data["form_sale_money"]   = number_format($sale_money + $sale_tax);
        //$client_data["form_ad_offset_total"] = $ad_offset_total;

    }else{
        $warning = "����������򤷤Ƥ���������";
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = "";
        $client_data["client_shop_id"]      = "";
        $client_data["form_client"]["name"] = "";
        $client_data["hdn_coax"]            = "";
        $client_data["hdn_tax_franct"]      = "";
        //$client_data["hdn_rank_cd"]         = "";
        $client_data["hdn_cclient_id"]      = "";
        $client_data["hdn_intro_account_id"]    = "";
        $intro_account_id                   = "";
        $client_data["form_intro_account_name"] = "";
        $client_id                          = null;      //������ID

        $client_data["daiko_check"]         = $contract_div;    //��Զ�ʬ
        $client_data["trade_aord"]          = 11;       //�����ʬ

    }
/*
    //�������Ϥ��줿�ͤ�����
    for($i = 1; $i <= $max_row; $i++){
        //����ǡ���
        $client_data["hdn_tax_div"][$i]             = "";
        //$client_data["form_sale_num"][$i]          = "";
        $client_data["form_goods_num1"][$i]         = "";
        $client_data["form_trade_price"]["$i"]["1"] = "";
        $client_data["form_trade_price"]["$i"]["2"] = "";
        $client_data["form_trade_amount"][$i]       = "";
        $client_data["form_sale_price"]["$i"]["1"]  = "";
        $client_data["form_sale_price"]["$i"]["2"]  = "";
        $client_data["form_sale_amount"][$i]        = "";
        //$client_data["form_aorder_num"][$i]        = "";
        $client_data["form_divide"][$i]             = "";
        $client_data["form_serv"][$i]               = "";
        //$client_data["form_stock_num"][$i]         = "";
        $client_data["form_issiki"][$i]             = "";
        $client_data["form_print_flg1"][$i]         = "";
        $client_data["form_print_flg2"][$i]         = "";

        for($j=1;$j<=3;$j++){
            $client_data["hdn_goods_id".$j][$i]         = "";
            $client_data["form_goods_cd".$j][$i]        = "";
            $client_data["form_goods_name".$j][$i]      = "";
            $client_data["hdn_name_change".$j][$i]      = "";
            $client_data["form_goods_num".$j][$i]       = "";
        }
        $client_data["official_goods_name"][$i]     = "";
        $client_data["form_aprice_div"][$i]         = "1";
        $client_data["form_account_price"][$i]      = "";
        $client_data["form_account_rate"][$i]       = "";
        $client_data["form_ad_offset_radio"][$i]    = "1";
        $client_data["form_ad_offset_amount"][$i]   = "";
    }
    $client_data["del_row"]             = "";        //������ֹ�
    $client_data["max_row"]             = "";        //�Կ�
    $client_data["form_sale_total"]     = "";        //��ȴ���
    $client_data["form_sale_tax"]       = "";        //������
    $client_data["form_sale_money"]     = "";        //�ǹ����
    $client_data["show_button_flg"]     = "";        //ɽ���ܥ���
    $client_data["form_ad_offset_total"]= "";       //�������껦�۹��
*/
    $client_data["form_ad_rest_price"]  = "";       //������Ĺ�

    $client_data["daiko_check"]         = $contract_div;    //��Զ�ʬ

    $form->setConstants($client_data);
}


//�Ҳ�Ԥ�FC�������褫Ƚ��
if($intro_account_id != null){
    $sql = "SELECT client_cd1, client_cd2, client_cname, client_div FROM t_client WHERE client_id = $intro_account_id;";
    $result = Db_Query($db_con, $sql);
    //������ξ�硢�Ҳ��CD1�Τ�
    if(pg_fetch_result($result, 0, "client_div") == "2"){
        $ac_name = pg_fetch_result($result, 0, "client_cd1")."<br>".htmlspecialchars(pg_fetch_result($result, 0, "client_cname"));
    }else{
        $ac_name = pg_fetch_result($result, 0, "client_cd1")."-".pg_fetch_result($result, 0, "client_cd2")."<br>".htmlspecialchars(pg_fetch_result($result, 0, "client_cname"));
    }
//�Ҳ�Ԥ��ʤ����
}else{
    $ac_name = "̵��";
    $con_data2["intro_ac_div[]"] = 1;
}


/****************************/
//����������
/****************************/
$daiko_cd1 = $_POST["form_daiko"]["cd1"];   //��ԥ�����1
$daiko_cd2 = $_POST["form_daiko"]["cd2"];   //��ԥ�����2

//������������orPOST�˥����ɤ�������
if($_POST["daiko_search_flg"] == true && $contract_div != "1" && $done_flg != "true"){

    //������ξ�������
    $sql  = "SELECT \n";
    $sql .= "    t_client.client_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_cd1 = '$daiko_cd1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_cd2 = '$daiko_cd2' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_div = '3' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.state = '1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_rank.group_kind = '3' \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
    //�����ǡ���������
    if($num == 1){
        //�ǡ�������
        $act_id = pg_fetch_result($result, 0, 0);     //������ID
        $con_data2["hdn_daiko_id"] = $act_id;

        //�����ξ�������
        $sql  = "SELECT \n";
        $sql .= "    t_client.client_cname, \n";
        $sql .= "    t_client.client_cd1, \n";
        $sql .= "    t_client.client_cd2, \n";
        $sql .= "    t_client.coax \n";
        $sql .= "FROM \n";
        $sql .= "    t_client \n";
        $sql .= "WHERE \n";
        $sql .= "    t_client.client_id = $act_id \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        Get_Id_Check($result);
        $data_list = Get_Data($result, 2);

        $daiko_cname    = $data_list[0][0];        //��̾
        $daiko_cd1      = $data_list[0][1];        //���CD1
        $daiko_cd2      = $data_list[0][2];        //���CD2
        $daiko_coax     = $data_list[0][3];        //��Ԥδݤ��ʬ

        //POST�����ѹ�
        $con_data2["form_daiko"]["cd1"]  = $daiko_cd1;
        $con_data2["form_daiko"]["cd2"]  = $daiko_cd2;
        $con_data2["form_daiko"]["name"] = $daiko_cname;
        $con_data2["hdn_daiko_coax"]     = $daiko_coax;
        $con_data2["daiko_search_flg"]   = "";


        //������Τޤ���ʬ�ǱĶȶ�ۤ�Ʒ׻�
        for($i=1; $i<=$max_row; $i++){

            if($_POST["form_trade_price"][$i][1] != null || $_POST["form_trade_price"][$i][2] != null){
                $t_price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];

                //��۷׻�����Ƚ��
                if($_POST["form_goods_num1"][$i] != null){
                //���̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�
                    //�Ķȶ��
                    $t_amount = bcmul($t_price, $_POST["form_goods_num1"][$i], 2);
                    $t_amount = Coax_Col($daiko_coax, $t_amount);

                //���̡ߤξ�硢ñ���ߣ�
                }else{
                    //�Ķȶ��
                    $t_amount = bcmul($t_price, 1, 2);
                    $t_amount = Coax_Col($daiko_coax, $t_amount);
                }

                //��׶�ۥե�����˥��å�
                $con_data2["form_trade_amount"][$i] = number_format($t_amount);

            }
        }


    //����褬¸�ߤ��ʤ���硢POST��������
    }else{
        $con_data2["hdn_daiko_id"]       = "";
        $con_data2["form_daiko"]["cd1"]  = "";
        $con_data2["form_daiko"]["cd2"]  = "";
        $con_data2["form_daiko"]["name"] = "";
        $con_data2["hdn_daiko_coax"]     = "";
        $con_data2["daiko_search_flg"]   = "";


        //������Τޤ���ʬ�ǱĶȶ�ۤ�Ʒ׻�
        for($i=1; $i<=$max_row; $i++){

            if($_POST["form_trade_price"][$i][1] != null || $_POST["form_trade_price"][$i][2] != null){
                $t_price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];

                //��۷׻�����Ƚ��
                if($_POST["form_goods_num1"][$i] != null){
                //���̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�
                    //�Ķȶ��
                    $t_amount = bcmul($t_price, $_POST["form_goods_num1"][$i], 2);
                    $t_amount = Coax_Col($coax, $t_amount);

                //���̡ߤξ�硢ñ���ߣ�
                }else{
                    //�Ķȶ��
                    $t_amount = bcmul($t_price, 1, 2);
                    $t_amount = Coax_Col($coax, $t_amount);
                }

                //��׶�ۥե�����˥��å�
                $con_data2["form_trade_amount"][$i] = number_format($t_amount);

            }
        }

    }

//�������Ϥ��Ƥ�����
}elseif($_POST["hdn_daiko_id"] != null && $contract_div != "1" && $done_flg != "true"){
    $act_id = $_POST["hdn_daiko_id"];
    $daiko_coax = $_POST["hdn_daiko_coax"];

//�������Ϥ��Ƥ��뤱�ɼ��ҽ��ξ��
}elseif($_POST["hdn_daiko_id"] != null && $contract_div == "1" && $done_flg != "true"){
    $act_id = null;
    $daiko_coax = null;
}



/****************************/
// ô���ԥ��쥯������
/****************************/
if($_POST["hdn_staff_ware"] == true){

    if($_POST["form_c_staff_id1"] != null){
        $staff_bases_ware_id = Get_Ware_Id($db_con, Get_Branch_Id($db_con, $_POST["form_c_staff_id1"]));    //�����åդε����Ҹ�

        $sql  = "SELECT ware_name \n";
        $sql .= "FROM t_ware \n";
        $sql .= "WHERE ware_id = $staff_bases_ware_id \n";
        $sql .= ($group_kind == "2") ? "AND shop_id IN (".Rank_Sql().") \n" : "AND shop_id = $client_h_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);

        $set_staff_ware["hdn_ware_name"]    = htmlspecialchars(pg_fetch_result($result, 0, "ware_name"));
        $set_staff_ware["hdn_ware_id"]      = $staff_bases_ware_id; //�в��Ҹˤ�ô���Ԥε����Ҹˤˤ���

    }else{
        //���ô���ԡʥᥤ��1�ˤ����ˤ���
        $set_staff_ware["hdn_ware_name"]    = "";
        $set_staff_ware["hdn_ware_id"]      = "";
    }

    $set_staff_ware["hdn_staff_ware"]   = "";                   //�����åդΥ��쥯�����򤵤줿�ե饰�����

    $form->setConstants($set_staff_ware);
}


/****************************/
//��ץܥ��󲡲�����
/****************************/
//if($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["form_sale_btn"] == "����ǧ���̤�"){
if(($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || ($_POST["form_sale_btn"] == "��ǧ���̤�" && $client_id != null)) && $done_flg != "true"){
/*
    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];
    //������������ˤ��롣
    $del_history = explode(",", $del_row);
*/
    $sale_data   = $_POST["form_sale_amount"];  //�����
    $sale_money  = NULL;                        //���ʤ������
    $tax_div_arr = NULL;                        //���Ƕ�ʬ
    $ad_offset_total = null;                    //�����껦�۹��

    //����ۤι���ͷ׻�
    //for($i=0;$i<$max_row;$i++){
    for($i=1;$i<=5;$i++){
        if($sale_data[$i] != "" && !in_array("$i", $del_history)){
            $sale_money[] = $sale_data[$i];
            if($_POST["hdn_goods_id1"][$i] == null && $_POST["form_serv"][$i] == null){
				$tax_div_arr[] = "1";
				$tax_div[$i]   = "1";
			}elseif($_POST["hdn_goods_id1"][$i] == null){
				$sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
			    $result = Db_Query($db_con, $sql);
			    $tax_div_arr[] = pg_fetch_result($result, 0, 0);
			    $tax_div[$i]   = pg_fetch_result($result, 0, 0);
			}else{
				$sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
			    $result = Db_Query($db_con, $sql);
			    $tax_div_arr[] = pg_fetch_result($result, 0, 0);
			    $tax_div[$i]   = pg_fetch_result($result, 0, 0);
				//$tax_div_arr[] = $_POST["hdn_tax_div"][$i];
				//$tax_div[$i]   = $_POST["hdn_tax_div"][$i];
			}
        }

        //�����껦�۹�׷׻�
        if($_POST["form_ad_offset_radio"][$i] == "2"){
            $ad_offset_total += $_POST["form_ad_offset_amount"][$i];
        }
    }

    //���ߤξ�����Ψ
    #2009-12-22 aoyama-n
    #$sql  = "SELECT ";
    #$sql .= "    tax_rate_n ";
    #$sql .= "FROM ";
    #$sql .= "    t_client ";
    #$sql .= "WHERE ";
    //$sql .= "    client_id = $client_id;";
    #$sql .= "    client_id = ";
    #$sql .= ($shop_id != null) ? $shop_id : $_SESSION["client_id"];
    #$result = Db_Query($db_con, $sql);
    #$tax_num = pg_fetch_result($result, 0,0);

    #2009-12-22 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div_arr,$coax,$tax_franct,$tax_num,$client_id, $db_con);
    //$total_money = Total_Amount($sale_money, $tax_div_arr,$coax,$tax_franct,$tax_num,$client_shop_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);
    $ad_offset_total = ($ad_offset_total !== null) ? number_format($ad_offset_total) : null;

    if($_POST["sum_button_flg"] == true){
        //���ɽ�������ѹ�
        $height = $max_row * 30;
        $form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";
    }

    //�ե�������ͥ��å�
    $money_data["form_sale_total"]   = $sale_money;
    $money_data["form_sale_tax"]     = $tax_money;
    $money_data["form_sale_money"]   = $st_money;
    $money_data["form_ad_offset_total"] = $ad_offset_total;
    $money_data["sum_button_flg"]    = "";
    $form->setConstants($money_data);
}



/****************************/
//���ʥ���������
/****************************/
if($_POST["goods_search_row"] != null && $done_flg != "true"){

    //���ʥ����ɼ��̾���
    $row_data = $_POST["goods_search_row"];
    //���ʥǡ�������������
    $search_row = substr($row_data,0,1);
    //���ʥǡ��������������
    $search_line = substr($row_data,1,1);


    $client_shop_id = $_POST["client_shop_id"];   //������Υ���å�ID
    //$rank_cd      = $_POST["hdn_rank_cd"];        //������θܵҶ�ʬ
    //$ware_id      = $_POST["form_ware_select"];   //�в��Ҹ�

    $sql  = "SELECT \n";
    $sql .= "   t_goods.goods_id, \n";      //����ID 0
    $sql .= "   t_goods.name_change, \n";   //��̾�ѹ� 1
    $sql .= "   t_goods.goods_cd, \n";      //����CD 2
    $sql .= "   t_goods.goods_cname, \n";   //����̾��ά�Ρ� 3
    $sql .= "   initial_cost.r_price AS initial_price, \n"; //�Ķȸ��� 4
    $sql .= "   sale_price.r_price AS sale_price, \n";      //���ñ����ɸ���5
    $sql .= "   t_goods.tax_div, \n";       //���Ƕ�ʬ 6
    $sql .= "   null, \n";                  //̤���� 7
    $sql .= "   null, \n";                  //̤���� 8
    $sql .= "   t_goods.compose_flg, \n";   //�����ʥե饰 9
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_g_product.g_product_name IS NULL THEN t_goods.goods_name \n";
    $sql .= "       ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
    //aoyama-n 2009-09-09
    #$sql .= "   END \n";                    //����ʬ��̾��Ⱦ���ڡܾ���̾ 10
    $sql .= "   END, \n";                    //����ʬ��̾��Ⱦ���ڡܾ���̾ 10
    $sql .= "   t_goods.discount_flg \n";    //�Ͱ��ե饰 11

    $sql .= "FROM \n";
    $sql .= "   t_goods \n";
    $sql .= "   LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "   LEFT JOIN t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id \n";
    $sql .= "        AND initial_cost.rank_cd = '2' \n";
    if($group_kind == "2"){
        $sql .= "    AND initial_cost.shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "    AND initial_cost.shop_id = $client_h_id \n";
    }

    $sql .= "   LEFT JOIN t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id \n";
    $sql .= "        AND sale_price.rank_cd = '4' \n";

    $sql .= "WHERE \n";
    $sql .= "    t_goods.goods_cd = '".$_POST["form_goods_cd".$search_line][$search_row]."' \n";
    $sql .= "    AND \n";
    $sql .= "    t_goods.accept_flg = '1' \n";

    //ľ�Ĥξ��ϡ�ͭ����ľ�ĤΤ�ͭ���ǡ��������ʡ�ľ�ľ��ʤ����
    if($group_kind == "2"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.state IN (1,3) \n";
        $sql .= "    AND \n";
        $sql .= "    ( \n";
        $sql .= "        t_goods.public_flg = true \n";
        $sql .= "        OR \n";
        $sql .= "        t_goods.shop_id IN (".Rank_Sql().") \n";
        $sql .= "    ) \n ";
    //FC�ξ��ϡ�ͭ���ǡ��������ʡ�FC���ʤ����
    }else{
        $sql .= "    AND \n";
        $sql .= "    t_goods.state = 1 \n";
        $sql .= "    AND \n";
        $sql .= "    ( \n";
        $sql .= "        t_goods.public_flg = true \n";
        $sql .= "        OR \n";
        $sql .= "        t_goods.shop_id = $client_h_id \n";
        $sql .= "    ) \n ";
    }
    //���ξ��ʤϹ����ʤϥ���
    if($search_line == "2"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.compose_flg = 'f' \n";
    }
    //��Զ�ʬ����Ԥξ����������ʤΤ�ɽ��
    if($contract_div != "1"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.public_flg = true \n";
    }
    $sql .= ";";
//print_array($sql, "��������");
    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);

    //�ǡ�����¸�ߤ�����硢�ե�����˥ǡ�����ɽ��
    if($data_num == 1){
        $goods_data = Get_Data($result, 2);

        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = $goods_data[0][0];    //����ID

        $set_goods_data["hdn_name_change".$search_line][$search_row]    = $goods_data[0][1];    //��̾�ѹ��ե饰
        $hdn_name_change[$search_line][$search_row]                     = $goods_data[0][1];    //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���
        $_POST["hdn_name_change".$search_line][$search_row]             = $goods_data[0][1];    //�����ѹ�����hidden��Ƚ�ꤷ�ʤ�����

        $set_goods_data["form_goods_cd".$search_line][$search_row]      = $goods_data[0][2];    //����CD
        $set_goods_data["form_goods_name".$search_line][$search_row]    = $goods_data[0][3];    //����̾

        $reset_goods_flg = false;   //���������ϻ��Υե�����ꥻ�åȥե饰

        //�����ʤξ�硢�Ҥ�ñ�����פ�����Τ������ʤ�ñ���ˤʤ�
        if($goods_data[0][9] == "t"){
            $shop_id = ($shop_id != null) ? $shop_id : $_SESSION["client_id"];
            $array_price = Compose_price($db_con, $shop_id, $goods_data[0][0]);
			//�����ʤλҤ�ñ������Ƚ��
			if($array_price == false){
				$reset_goods_flg = true;   //���Ϥ��줿���ʾ���򥯥ꥢ
			}else{
                $goods_data[0][4] = $array_price[0];    //����
                $goods_data[0][5] = $array_price[1];    //���
            }

        //�����ʤ���ʤ���硢ñ����null�ʤ�ե�����ꥻ�å�
        }elseif($goods_data[0][4] == null || $goods_data[0][5] == null){
            $reset_goods_flg = true;
        }

        //�����ʥ��顼����ʤ����
        if($reset_goods_flg == false){
            //�����ƥ����ϻ��Τ�ñ������۷׻�����������̾�������
            if($search_line == "1"){
                //��Զ�ʬ�����ҡ��ޤ�����԰��������ʡ�˰ʳ��ξ���DB���顢��Ԥǡʡ�ˤξ������ñ���ˡʡ�ˤ򤫤�����Τ򸶲�ñ���������
                if($contract_div != "1" && $_POST["act_div"]["0"] == "3"){
                    //��԰����������Ϥ���Ƥ��ʤ�����0�ˤ����
                    if($_POST["act_request_rate"] == null){
                        $cost_price = 0;
                    }else{
                        $cost_price = bcmul($goods_data[0][5], bcdiv($_POST["act_request_rate"], 100, 2), 2);
                    }

                }else{
                    $cost_price = $goods_data[0][4];
                }

                //����ñ�����������Ⱦ�������ʬ����
                $arr_cost_price = explode('.', $cost_price);
                $set_goods_data["form_trade_price"][$search_row]["1"] = $arr_cost_price[0];  //����ñ��
                $set_goods_data["form_trade_price"][$search_row]["2"] = ($arr_cost_price[1] != null)? $arr_cost_price[1] : '00';

                //���ñ�����������Ⱦ�������ʬ����
                $sale_price = $goods_data[0][5];
                $arr_sale_price = explode('.', $sale_price);
                $set_goods_data["form_sale_price"][$search_row]["1"] = $arr_sale_price[0];  //���ñ��
                $set_goods_data["form_sale_price"][$search_row]["2"] = ($arr_sale_price[1] != null)? $arr_sale_price[1] : '00';

                $set_goods_data["hdn_tax_div"][$search_row]          = $goods_data[0][6]; //���Ƕ�ʬ


                //��۷׻�����Ƚ��
                if($_POST["form_issiki"][$search_row] != null && $_POST["form_goods_num1"][$search_row] != null){
                //�켰�������̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�����ۤϡ�ñ���ߣ�
                    //�Ķȶ��
                    //$trade_amount = bcmul($cost_price, $_POST["form_goods_num1"][$search_row],2);
                    //�Ķȶ��
                    //�����ɼ�������������Τǰ켰���ξ�硢������׳ۤϸ���ñ����Ʊ��
                    //���켰���ΤȤ����ñ��������׳ۤǡ�����ñ�������ñ����������������׳ۡ��������Ḷ����׳�
                    //����äơ����̣��Ƿ׻����Ƹ���ñ���Ḷ����׳ۤ���Ͽ
                    if($contract_div != "1" && $_POST["act_div"][0] == "3"){
                        $trade_amount = bcmul($cost_price, 1, 2);
                    //����ʳ���ñ���߿���
                    }else{
                        $trade_amount = bcmul($cost_price, $_POST["form_goods_num1"][$search_row],2);
                    }
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //�����
                    $sale_amount = bcmul($sale_price, 1,2);
                    $sale_amount = Coax_Col($coax, $sale_amount);

                //�켰�������̡ߤξ�硢ñ���ߣ�
                }else if($_POST["form_issiki"][$search_row] != null && $_POST["form_goods_num1"][$search_row] == null){
                    //�Ķȶ��
                    $trade_amount = bcmul($cost_price, 1,2);
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //�����
                    $sale_amount = bcmul($sale_price, 1,2);
                    $sale_amount = Coax_Col($coax, $sale_amount);

                //�켰�ߡ����̡��ξ�硢ñ���߿���
                }else if($_POST["form_issiki"][$search_row] == null && $_POST["form_goods_num1"][$search_row] != null){
                    //�Ķȶ��
                    $trade_amount = bcmul($cost_price, $_POST["form_goods_num1"][$search_row],2);
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //�����
                    $sale_amount = bcmul($sale_price, $_POST["form_goods_num1"][$search_row],2);
                    $sale_amount = Coax_Col($coax, $sale_amount);
                }

                $set_goods_data["form_trade_amount"][$search_row]   = number_format($trade_amount);
                $set_goods_data["form_sale_amount"][$search_row]    = number_format($sale_amount);


                //����̾�������ˤ������
                $set_goods_data["official_goods_name"][$search_row] = $goods_data[0][10];

                //aoyama-n 2009-09-09
                //�Ͱ��ե饰
                $set_goods_data["hdn_discount_flg"][$search_row]    = $goods_data[0][11];

            }//�����ƥ����ϻ��Τ߶�۷׻������

		//�����ʤλҤ�ñ�������ꤵ��Ƥ��ʤ��Ȥ������ʾ��󥯥ꥢ
		}else{
	        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = "";
	        $set_goods_data["hdn_name_change".$search_line][$search_row]    = "";
	        $set_goods_data["form_goods_cd".$search_line][$search_row]      = "";
	        $set_goods_data["form_goods_name".$search_line][$search_row]    = "";
	        $set_goods_data["form_goods_num".$search_line][$search_row]     = "";
            //�����ƥ����ϻ��ϸ�������塢�����ե饰�����Ƕ�ʬ������
            if($search_line == "1"){
    	        $set_goods_data["form_trade_price"][$search_row]["1"]   = "";
	            $set_goods_data["form_trade_price"][$search_row]["2"]   = "";
	            $set_goods_data["form_trade_amount"][$search_row]       = "";
	            $set_goods_data["form_sale_price"][$search_row]["1"]    = "";
    	        $set_goods_data["form_sale_price"][$search_row]["2"]    = "";
	            $set_goods_data["form_sale_amount"][$search_row]        = "";
	            $set_goods_data["form_print_flg2"][$search_row]         = "";
	            $set_goods_data["hdn_tax_div"][$search_row]             = "";
            }
		}
    }else{
        //�ǡ�����̵�����ϡ������
        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = "";
        $set_goods_data["hdn_name_change".$search_line][$search_row]    = "";
        $set_goods_data["form_goods_cd".$search_line][$search_row]      = "";
        $set_goods_data["form_goods_name".$search_line][$search_row]    = "";
        $set_goods_data["form_goods_num".$search_line][$search_row]     = "";
        //�����ƥ����ϻ��ϸ�������塢�����ե饰�����Ƕ�ʬ�������ƥ�����̾������
        if($search_line == "1"){
            $set_goods_data["form_trade_price"][$search_row]["1"]   = "";
            $set_goods_data["form_trade_price"][$search_row]["2"]   = "";
            $set_goods_data["form_trade_amount"][$search_row]       = "";
            $set_goods_data["form_sale_price"][$search_row]["1"]    = "";
            $set_goods_data["form_sale_price"][$search_row]["2"]    = "";
            $set_goods_data["form_sale_amount"][$search_row]        = "";
            $set_goods_data["form_print_flg2"][$search_row]         = "";
            $set_goods_data["hdn_tax_div"][$search_row]             = "";
            $set_goods_data["official_goods_name"][$search_row]     = "";
            //aoyama-n 2009-09-09
            $set_goods_data["hdn_discount_flg"][$search_row]        = "";
        }
    }
    $set_goods_data["goods_search_row"] = "";
    $form->setConstants($set_goods_data);
}


/****************************/
//���ʺ���
/****************************/
if($done_flg != "true"){

    //���ʴ�Ϣ
    require_once(INCLUDE_DIR ."plan_data.inc");

    //���
    require_once(INCLUDE_DIR ."fc_hand_daiko.inc");


    //���ô���ԥᥤ��1���ѹ�����ȡ��в��Ҹˤ򤽤�ô���Ԥε����Ҹˤˤ���°���ɲ�
    $form->updateElementAttr(
        "form_c_staff_id1", 
        "onKeyDown=\"chgKeycode();\" onChange=\"javascript:Button_Submit('hdn_staff_ware','#','true');\""
    );


    //hidden
    $form->addElement("hidden", "hdn_aord_id");     //����ID
    $form->addElement("hidden", "back_display");    //������Ƚ��
    $form->addElement("hidden", "aord_id_array");   //����ID����
    $form->addElement("hidden", "hdn_former_deli_day");		//rev.1.3 �ѹ���ͽ������


}else{

    //�����ɼ���Ϸ��������
    $sql  = "SELECT slip_out FROM t_aorder_h WHERE aord_id = $aord_id AND ";
    $sql .= ($group_kind == "2") ? "shop_id IN (".Rank_Sql().") " : "shop_id = $client_h_id ";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $disable_slip_out = (pg_fetch_result($result, 0, "slip_out") == "2") ? "disabled" : "";


    //�ѹ���
    if($_GET["change_flg"] == "true"){

        if($_GET["back_display"] != null){
            $array_id = stripslashes($_GET["aord_id_array"]);
            $array_id = urldecode($array_id);
            $array_id = unserialize($array_id);
            $array_id = serialize($array_id);
            $array_id = urlencode($array_id);

            //OK�ܥ���
            $form->addElement("button", "ok_button", "����λ", "onClick=\"location.href='".FC_DIR."sale/2-2-106.php?aord_id[0]=$aord_id&aord_id_array=".$array_id."&back_display=".$_GET["back_display"]."'\"");

            //OK��ɼ�ܥ���
            $form->addElement("submit", "ok_slip_button", "��ɼ��ȯ�Ԥ��ƴ�λ", 
                "onClick=\"Post_book_vote('./2-2-205.php','".FC_DIR."sale/2-2-106.php?aord_id[0]=$aord_id&aord_id_array=".$array_id."&back_display=".$_GET["back_display"]."');\"
                $disable_slip_out"
            );

        //�����̤��ʤ����ϼ�ʬ�����
        }else{
            //OK�ܥ���
            $form->addElement("button", "ok_button", "����λ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

            //OK��ɼ�ܥ���
            $form->addElement("submit", "ok_slip_button", "��ɼ��ȯ�Ԥ��ƴ�λ", 
                "onClick=\"Post_book_vote('./2-2-205.php','".$_SERVER["PHP_SELF"]."');\"
                $disable_slip_out"
            );
        }

    //������Ͽ��
    }else{
        //OK�ܥ���
        $form->addElement("button", "ok_button", "����λ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

        //OK��ɼ�ܥ���
        $form->addElement("submit", "ok_slip_button", "��ɼ��ȯ�Ԥ��ƴ�λ", 
            "onClick=\"Post_book_vote('./2-2-205.php','".$_SERVER["PHP_SELF"]."');\"
            $disable_slip_out"
        );
    }

    //���
    //$form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='./2-2-207.php?search=1'\"");

    //�����ɼ���Ϥ�hidden
    $form->addElement("hidden", "output_id_array[0]", "$aord_id");
    $form->addElement("hidden", "form_slip_check[0]", "1");

}


/****************************/
//�����⽸�ץܥ��󲡲�����
/****************************/
//if(($_POST["ad_sum_button_flg"] == true || $_POST["del_row"] != "" || (($_POST["form_sale_btn"] == "��ǧ���̤�" || $_POST["hdn_comp_button"] == "�ϡ�>��") && $client_id != null)) && $done_flg != "true"){
//rev.1.3 ͽ������2����ʾ�̵��ܥ����ɲ�
if(($_POST["ad_sum_button_flg"] == true || $_POST["del_row"] != "" || (($_POST["form_sale_btn"] == "��ǧ���̤�" || $_POST["hdn_comp_button"] == "�ϡ���" || $_POST["form_lump_change_warn"] == "�ٹ��̵�뤷������") && $client_id != null)) && $done_flg != "true"){

    //������
    //��ɬ�ܥ����å�
    //$form->addGroupRule("form_delivery_day", $h_mess[26], "required");
    $form->addGroupRule("form_delivery_day", array(
        "y" => array(array("ͽ������ �����Ϥ��Ƥ���������", "required")),
        "m" => array(array("ͽ������ �����Ϥ��Ƥ���������", "required")),
        "d" => array(array("ͽ������ �����Ϥ��Ƥ���������", "required")),
    ));
    //���ͥ����å�
    $form->addGroupRule("form_delivery_day", array(
        "y" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
        "m" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
        "d" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
    ));

    if($form->validate()){
        //�����������å�
        if(!checkdate((int)$_POST["form_delivery_day"]["m"], (int)$_POST["form_delivery_day"]["d"], (int)$_POST["form_delivery_day"]["y"])){
            $form->setElementError("form_delivery_day", $h_mess[35]);
        }
    }

    $error_flg = (count($form->_errors) > 0) ? true : false;


    //���顼���ʤ���硢�Ĺ⽸��
    if($error_flg == false){
        $count_day  = str_pad($_POST["form_delivery_day"]["y"], 4, 0, STR_PAD_LEFT);
        $count_day .= "-";
        $count_day .= str_pad($_POST["form_delivery_day"]["m"], 2, 0, STR_PAD_LEFT);
        $count_day .= "-";
        $count_day .= str_pad($_POST["form_delivery_day"]["d"], 2, 0, STR_PAD_LEFT);

        $claim_data = $_POST["form_claim"];     //������,�������ʬ
        $c_data = explode(',', $claim_data);

        $ad_rest_price  = Advance_Offset_Claim($db_con, $count_day, $client_id, $c_data[1]);
        $ad_rest_price2 = Numformat_Ortho($ad_rest_price, 0, true);

    //���顼�ξ�硢���򥻥å�
    }else{
        $ad_rest_price2 = "";

    }

    $con_data2["form_ad_rest_price"]    = $ad_rest_price2;
    $con_data2["ad_sum_button_flg"]     = "";

}


/****************************/
//�ԥ��ꥢ����
/****************************/
if($_POST["clear_line"] != ""){
    Clear_Line_Data2($form, $_POST["clear_line"]);
}


//���ֹ楫����
$row_num = 1;


/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
//if(($_POST["form_sale_btn"] == "��ǧ���̤�" || $_POST["hdn_comp_button"] == "�ϡ���") && $done_flg != "true"){
//rev.1.3 ͽ������2����ʾ�̵��ܥ����ɲ�
if(($_POST["form_sale_btn"] == "��ǧ���̤�" || $_POST["hdn_comp_button"] == "�ϡ���" || $_POST["form_lump_change_warn"] == "�ٹ��̵�뤷������") && $done_flg != "true"){
    //�إå�������
    //$sale_no              = $_POST["form_sale_no"];             //��ɼ�ֹ�
    $note                 = $_POST["form_note"];                //����

    $ware_id              = $_POST["hdn_ware_id"];              //�в��Ҹ�ID
    $trade_aord           = $_POST["trade_aord"];               //�����ʬ

    //������
    $array_tmp = explode(",", $_POST["form_claim"]);
    $claim_id  = $array_tmp[0];     //������ID
    $claim_div = $array_tmp[1];     //�������ʬ

    $array_divide = Select_Get($db_con, "divide_con");
    $array_serv = Select_Get($db_con, "serv_con");


    //������client_id�����
    $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
    $result = Db_Query($db_con, $sql);
    $head_id = pg_fetch_result($result, 0, "client_id");        //������client_id


    //POST�����Ȥ�
    require_once(INCLUDE_DIR."fc_sale_post_bfr.inc");


	/****************************/
	//���顼�����å�(addRule)
	/****************************/

	//�����ʬ
	//��ɬ�ܥ����å�
	$form->addRule("trade_aord", $h_mess[30], "required");


    //�Ҳ������ID��������ʬ����
    $sql  = "SELECT \n";
    $sql .= "    t_client_info.intro_account_id, \n";
    $sql .= "    t_client.client_div \n";
    $sql .= "FROM \n";
    $sql .= "    t_client_info \n";
    $sql .= "    LEFT JOIN t_client ON t_client_info.intro_account_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client_info.client_id = $client_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $intro_account_id = pg_fetch_result($result, 0, "intro_account_id");    //�Ҳ������ID
    $intro_client_div = pg_fetch_result($result, 0, "client_div");          //�Ҳ������μ�����ʬ


    //���顼�����å�(PHP)
    require_once(INCLUDE_DIR."fc_sale_post_atr.inc");


    //�ѹ���������줿�������å�
    if($aord_id != NULL){

        $sql = "SELECT del_flg FROM t_aorder_h WHERE aord_id = $aord_id;";
        $result = Db_Query($db_con, $sql);

        if(pg_fetch_result($result, 0, "del_flg") == "t"){
            $error_flg = true;
            $slip_del_flg = true;

            //����ID�����ͤ�ľ��
            $aord_id_tmp = array();
            foreach($aord_id_array as $value){
                if($value != $aord_id){
                    $aord_id_tmp[] = $value;
                }
            }
            $array_id = $aord_id_tmp;

            //OK�ܥ���
            if(count($array_id) != 0){
                $array_id = serialize($array_id);
                $array_id = urlencode($array_id);
                $form->addElement("button","ok_button","�ϡ���","onClick=\"location.href='".FC_DIR."sale/2-2-106.php?aord_id[0]=$aord_id&aord_id_array=".$array_id."&back_display=".$_POST["back_display"]."'\"");
            }else{
                //��������ͽ��ǡ������٤�ɽ������ǡ�����0��ˤʤä����
                $form->addElement("button","ok_button","�ϡ���","onClick=\"location.href='".Make_Rtn_Page("contract")."'\"");
            }
        }
    }


    //�������ô����Ź���Ҳ���������
    $sql  = "SELECT \n";
    $sql .= "    t_client.coax, \n";
    $sql .= "    t_client.tax_franct, \n";
    $sql .= "    t_client_info.cclient_shop \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_client_info ON t_client.client_id = t_client_info.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_id = $client_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $coax           = pg_fetch_result($result, 0, "coax");              //�ޤ���ʬ
    $tax_franct     = pg_fetch_result($result, 0, "tax_franct");        //������ü����ʬ
    $cclient_shop   = pg_fetch_result($result, 0, "cclient_shop");      //ô����Ź

    $cost_money  = NULL;                        //���ʤθ������
    $sale_money  = NULL;                        //���ʤ������
    $tax_div_arr = NULL;                        //���Ƕ�ʬ

    //����ۤι���ͷ׻�
    for($i=1;$i<=5;$i++){
        if($serv_id[$i] != null || $goods_item_id[$i] != null){
            $cost_money[] = $trade_amount[$i];
            $sale_money[] = $sale_amount[$i];
            if($_POST["hdn_goods_id1"][$i] == null && $_POST["form_serv"][$i] == null){
                $tax_div_arr[] = "1";
                $tax_div[$i]   = "1";		//DB��Ͽ��
            }elseif($_POST["form_serv"][$i] != null && $_POST["hdn_goods_id1"][$i] == null){
                $sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);
                $tax_div[$i]   = pg_fetch_result($result, 0, 0);		//DB��Ͽ��
            }else{
                $sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);
                $tax_div[$i]   = pg_fetch_result($result, 0, 0);

            }
        }
    }

    //���ߤ�ô������åפξ�����Ψ
    #2009-12-22 aoyama-n
    #$tax_num = Get_Tax_Rate($db_con, $cclient_shop);

    $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    //���ҽ��ξ�硢������������δݤ�Ǥޤ��
    if($contract_div == "1"){
        $total_money = Total_Amount($cost_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);

    //��Ԥξ�硢�����������δݤ�Ǥޤ��
    }else{
        $total_money = Total_Amount($cost_money, $tax_div_arr, $daiko_coax, $tax_franct, $tax_num, $client_id, $db_con);
    }
    $cost_money  = $total_money[0];     //������ۡ���ȴ��

    $total_money = Total_Amount($sale_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);
    $sale_money  = $total_money[0];     //����ۡ���ȴ��
    $sale_tax    = $total_money[1];     //�����ǳ�


    //ľ�Ĥ���Ԥξ�硢�ʼ������ѡ�����ۡ������ǳۤ�׻��ǵ���
    //if($group_kind == "2" && $contract_div != "1"){
    if($group_kind == "2" && $contract_div != "1" && $act_id != null){

        //������������ˤξ�����Ψ����
        #2009-12-22 aoyama-n
        #$act_tax_num = Get_Tax_Rate($db_con, $act_id);

        #2009-12-22 aoyama-n
        //��Ψ���饹�����󥹥�������
        $act_tax_rate_obj = new TaxRate($act_id);
        $act_tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
        $act_tax_num = $act_tax_rate_obj->getOwnShopTaxRate();

        //���������ۤΤޤ���ʬ��ü����ʬ���������ʻ�ʧ���ˤ����
        $sql = "SELECT coax, tax_franct, client_id FROM t_client WHERE act_flg = true AND shop_id = ".$act_id.";";
        $result = Db_Query($db_con, $sql);
        $toyo_coax = pg_fetch_result($result, 0, "coax");               //�ޤ���ʬ
        $toyo_tax_franct = pg_fetch_result($result, 0, "tax_franct");   //ü����ʬ
        $toyo_id = pg_fetch_result($result, 0, "client_id");            //�����ID


        //5��ʬ�Ρʼ������ѡ�����ۼ������׻�
        for($i=1; $i<=$max_row; $i++){

            //�ǡ������Ϥ��줿�Ȥ���������
            if($serv_id[$i] != null || $goods_item_id[$i] != null){
                //���������ۤξ��ϡ�0��
                if($_POST["act_div"][0] == "2"){

                    $trust_sale_price[$i]  = 0;
                    $trust_sale_amount[$i] = 0;
                    $trust_sale_money[] = $trust_sale_amount[$i];       //�ʼ�����˾����ǳ۷׻���

                //���������ξ��
                }else{

                    $trust_sale_price[$i] = $trade_price[$i];

                    //�켰�������̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�����ۤϡ�ñ���ߣ�
                    if($set_flg[$i] == "true" && $_POST["form_goods_num1"][$i] != null){
                        //�����ɼ�������������Τǰ켰���ξ�硢������׳ۤϸ���ñ����Ʊ��
                        //���켰���ΤȤ����ñ��������׳ۤǡ�����ñ�������ñ����������������׳ۡ��������Ḷ����׳�
                        //����äơ����̣��Ƿ׻����Ƹ���ñ���Ḷ����׳ۤ���Ͽ
                        if($_POST["act_div"][0] == "3"){
                            $trust_sale_amount[$i] = bcmul($trust_sale_price[$i], 1, 2);
                        //����ʳ���ñ���߿���
                        }else{
                            $trust_sale_amount[$i] = bcmul($trust_sale_price[$i], $_POST["form_goods_num1"][$i], 2);
                        }
                        $trust_sale_amount[$i] = Coax_Col($toyo_coax, $trust_sale_amount[$i]);

                    //�켰�������̡ߤξ�硢ñ���ߣ�
                    }elseif($set_flg[$i] == "true" && $_POST["form_goods_num1"][$i] == null){
                        $trust_sale_amount[$i] = bcmul($trust_sale_price[$i], 1, 2);
                        $trust_sale_amount[$i] = Coax_Col($toyo_coax, $trust_sale_amount[$i]);

                    //�켰�ߡ����̡��ξ�硢ñ���߿���
                    }elseif($set_flg[$i] == "false" && $_POST["form_goods_num1"][$i] != null){
                        $trust_sale_amount[$i] = bcmul($trust_sale_price[$i], $_POST["form_goods_num1"][$i], 2);
                        $trust_sale_amount[$i] = Coax_Col($toyo_coax, $trust_sale_amount[$i]);

                    }

                    $trust_sale_money[] = $trust_sale_amount[$i];

                }//�ʼ������ѡ�����ۼ������׻������

            }//�ǡ������Ϥ��줿�Ȥ��������������

        }//5��ʬ�Ρʼ������ѡ�����ۼ������׻������


        //�إå��Ρʼ������ѡ�����ۡ���ȴ�ˡ��ʼ������ѡ˾����ǳۤ�׻�
        $total_money = Total_Amount($trust_sale_money, $tax_div_arr, $toyo_coax, $toyo_tax_franct, $act_tax_num, $toyo_id, $db_con);
        $trust_sale_money   = $total_money[0];      //�ʼ������ѡ�����ۡ���ȴ��
        $trust_sale_tax     = $total_money[1];      //�ʼ������ѡ˾����ǳ�


    }//�ʼ������ѡ�����ۡ������ǳۤ�׻������


    //�������ʬ���ָ���ۡס����ġ�����������ȱĶȶ�۹�פ����פ��ʤ����
    if($act_div == "2" && ($cost_money != $act_request_price)){
        $form->setElementError("act_request_price",$h_mess[68]);
    }


    //������ۤΥ����å�
    if($ad_offset_flg){

        //��ɼ��ס��ǹ��ˤ�������껦�۹�פ��礭����硢�ٹ��ɽ��
        if(($sale_money + $sale_tax) < $ad_offset_total_amount){
            $ad_total_warn_mess = $h_mess[78];
        }

/*
        //�ֳ����פξ��
        if($trade_aord == "11"){
            //�����껦�۹�פ����ߤ�������Ĺ����礭�����ϥ��顼
            if($ad_offset_total_amount > $ad_rest_price){
                $form->setElementError("form_ad_offset_total", $h_mess[75]);
            }
        }
*/
    }//������ۥ����å������



    $form->validate();
    $error_flg = (count($form->_errors) > 0) ? true : $error_flg;


	//rev.1.3 �ٹ�̵��ܥ��󲡲�����Ƥʤ�����2����ʾ�Υ��Ƥ��뤫�����å�
	if($error_flg == false && $aord_id != null && $_POST["form_lump_change_warn"] != "�ٹ��̵�뤷������"){
		$b_lump_day = date("Y-m-d", mktime(0, 0, 0, $delivery_day_m - 2, $delivery_day_d, $delivery_day_y));	//2������
		$a_lump_day = date("Y-m-d", mktime(0, 0, 0, $delivery_day_m + 2, $delivery_day_d, $delivery_day_y));	//2�����
		//2����ʾ�Υ��Ƥ���
		if(($_POST["hdn_former_deli_day"] <= $b_lump_day) || ($_POST["hdn_former_deli_day"] >= $a_lump_day)){
			$warn_lump_change = "���Ϥ���ͽ��������2����ʾ�Υ��Ƥ��ޤ���";
			$form->addElement("submit", "form_lump_change_warn", "�ٹ��̵�뤷������", $disabled);
		//�����ϰ���
		}else{
			$warn_lump_change = null;
		}
	}else{
		$warn_lump_change = null;
	}



    //���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
    //if($form->validate() && $error_flg == false){
    //if($error_flg == false){
	//rev.1.3 ���顼����ʤ���ͽ��������2����ʾ�Υ��Ƥ��ʤ�
    if($error_flg == false && $warn_lump_change == null){

        //��ϿȽ��
        //if($_POST["comp_button"] == "�ϡ���"){
        //if($_POST["hdn_comp_button"] == "�ϡ���"){
        if($_POST["hdn_comp_button"] == "�ϡ���" || $_POST["form_lump_change_warn"] == "�ٹ��̵�뤷������"){

            //���դη����ѹ�
            $sale_day   = $delivery_day;    //ͽ��������
            $claim_day  = $request_day;     //������

            //���ҽ��ξ�硢�в��Ҹˡ����ô���Ԥ�ô���Ҹˡˤ����
            if($contract_div == "1"){
                $sql  = "SELECT \n";
                $sql .= "    t_ware.ware_id, \n";
                $sql .= "    t_ware.ware_name \n";
                $sql .= "FROM \n";
                $sql .= "    t_attach \n";
                $sql .= "    INNER JOIN t_ware ON t_attach.ware_id = t_ware.ware_id \n";
                $sql .= "WHERE \n";
                $sql .= "    t_attach.staff_id = ".$staff_check[0]." \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql); 
                $staff_ware_id      = pg_fetch_result($result, 0, "ware_id");       //ô���Ҹ�ID
                $staff_ware_name    = pg_fetch_result($result, 0, "ware_name");     //ô���Ҹ�̾
            }


            //(2006/08/26) ��ʣ���顼�����å��ѥե饰������
            //$duplicate_flg = false;

            //�������󥨥顼�ե饰������
            //$daily_slip_error_flg = false;


            //����إå�������ǡ�������Ͽ������SQL
            Db_Query($db_con, "BEGIN;");

            //�ѹ�����Ƚ��
            if($aord_id != NULL){

                //����ͽ��вٰ����Ǻ߸˰�ư�Ѥ�ͽ��ǡ����ϡ��в��Ҹˤ�ô����(�ᥤ��)��ô���Ҹˤ��ѹ�����
                $sql = "SELECT move_flg FROM t_aorder_h WHERE aord_id = $aord_id;";
                $result = Db_Query($db_con, $sql);
                $move_flg = pg_fetch_result($result, 0, 0);     //��ư�ե饰


                //����إå��ѹ�
                $sql  = "UPDATE \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "SET \n";
                $sql .= "    aord_id = $aord_id, \n";
                //$sql .= "    ord_no = '$sale_no', \n";
                $sql .= "    ord_time = '$sale_day', \n";
                $sql .= "    arrival_day = '$claim_day', \n";
                $sql .= "    trade_id = '$trade_aord', \n";
                $sql .= "    client_id = $client_id, \n";
                $sql .= "    client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), \n";
                $sql .= "    slip_out = (SELECT slip_out FROM t_client WHERE client_id = $client_id), \n";

                $sql .= "    claim_id = $claim_id, \n";     //������ID
                $sql .= "    claim_div = $claim_div, \n";   //�������ʬ

                //ľ���褬���ꤵ��Ƥ�����
                if($direct_id != null){
                    $sql .= "    direct_id = $direct_id, ";
                    $sql .= "    direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    direct_cname = (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), ";
                }else{
                    $sql .= "    direct_id = null, ";
                    $sql .= "    direct_name = null, ";
                    $sql .= "    direct_name2 = null, ";
                    $sql .= "    direct_cname = null, ";
                }

                //���ҽ��ξ��
                //���в��Ҹ���Ͽ
                //����Ԥ����
                if($contract_div == "1"){
                    //ͽ��в٤ǰ�ư�Ѥ�ô���Ԥ�ô���Ҹ�
                    if($move_flg == "t"){
                        $sql .= "    ware_id = (SELECT ware_id FROM t_attach WHERE staff_id = ".$staff_check[0]." AND shop_id = ".$client_h_id."), \n";
                        $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = ";
                        $sql .= "(SELECT ware_id FROM t_attach WHERE staff_id = ".$staff_check[0]." AND shop_id = ".$client_h_id.")), \n";

                    //��ư���Ƥʤ�����ô���Ԥε����Ҹ�
                    }else{
                        $sql .= "    ware_id = $ware_id, \n";
                        $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), \n";
                    }
                    $sql .= "    route = $route, \n";
                    $sql .= "    act_id = null, \n";
                    $sql .= "    act_cd1 = null, \n";
                    $sql .= "    act_cd2 = null, \n";
                    $sql .= "    act_name = null, \n";
                    $sql .= "    act_div = '1', \n";        //�������ʬ
                    $sql .= "    trust_net_amount = NULL, \n";     //�ʼ������ѡ�����ۡ���ȴ��
                    $sql .= "    trust_tax_amount = NULL, \n";      //�ʼ������ѡ˾����ǳ�
                //��Ԥξ��
                //���в��Ҹˤ����
                //����Ԥ���Ͽ
                }else{
                    $sql .= "    ware_id = null, \n";
                    $sql .= "    ware_name = null, \n";
                    $sql .= "    route = null, \n";
                    $sql .= "    act_id = $act_id, \n";
                    $sql .= "    act_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $act_id), \n";
                    $sql .= "    act_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $act_id), \n";
                    $sql .= "    act_name = (SELECT client_cname FROM t_client WHERE client_id = $act_id), \n";
                    $sql .= "    act_div = '$act_div', \n"; //�������ʬ
                    $sql .= "    trust_net_amount = $trust_sale_money, \n";     //�ʼ������ѡ�����ۡ���ȴ��
                    $sql .= "    trust_tax_amount = $trust_sale_tax, \n";       //�ʼ������ѡ˾����ǳ�
                }
                if($act_request_rate != null){              //������ʡ��
                    $sql .= "    act_request_rate = '$act_request_rate', \n";
                }else{
                    $sql .= "    act_request_rate = null, \n";
                }
                if($act_request_price != null){             //������ʸ���ۡ�
                    $sql .= "    act_request_price = $act_request_price, \n";
                }else{
                    $sql .= "    act_request_price = null, \n";
                }

                $sql .= "    ord_staff_id = $e_staff_id, \n";       //���ڥ졼��ID
                $sql .= "    ord_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $e_staff_id), \n";
                $sql .= "    cost_amount = $cost_money, \n";        //������ۡ���ȴ��
                $sql .= "    net_amount = $sale_money, \n";         //����ۡ���ȴ��
                $sql .= "    tax_amount = $sale_tax, \n";           //�����ǳ�
                $sql .= "    note = '$note', \n";                   //����
                $sql .= "    reason_cor = '$reason', \n";           //������ͳ
                $sql .= "    shop_id = $cclient_shop, \n";          //ô������åסʥ���å�ID��
                $sql .= "    contract_div = '$contract_div', \n";   //�����ʬ
                if($ad_offset_flg == true){                         //�����껦�۹��
                    $sql .= "    advance_offset_totalamount = $ad_offset_total_amount, ";
                }else{
                    $sql .= "    advance_offset_totalamount = null, ";
                }
                $sql .= "    ship_chk_cd = NULL, \n";               //�ѹ������å�������
                $sql .= "    slip_flg = false, \n";                 //��ɼ���ϥե饰
                $sql .= "    slip_out_day = NULL, \n";              //��ɼ������
                $sql .= "    change_flg = true, \n";                //�ѹ��ե饰
                $sql .= "    change_day = CURRENT_TIMESTAMP \n";    //�ǡ����ѹ���
                $sql .= "WHERE \n";
                $sql .= "    aord_id = $aord_id \n";
                $sql .= ";";
//print_array($sql, "����إå�����");

                $result = Db_Query($db_con,$sql);
                if($result == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }

                //������ô���ơ��֥����
                $sql  = "DELETE FROM ";
                $sql .= "    t_aorder_staff ";
                $sql .= "WHERE ";
                $sql .= "    aord_id = $aord_id ";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //����ǡ�������
                $sql  = "DELETE FROM ";
                $sql .= "    t_aorder_d ";
                $sql .= " WHERE ";
                $sql .= "    aord_id = $aord_id ";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }


                //�ѹ����ϴ�λ��˰��������
                $change_flg = "true";


            //������Ͽ
            }else{

/*
                //��ư���֤���ɼ�ֹ�����ʥ����å��ѡ�
                //ľ�Ĥξ��
                if($group_kind == "2"){
                    $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                //FC�ξ��
                }else{
                    $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                }

                $result = Db_Query($db_con, $sql);
                $chk_sale_no = pg_fetch_result($result, 0 ,0);
                $chk_sale_no = $chk_sale_no +1;
                $chk_sale_no = str_pad($chk_sale_no, 8, 0, STR_PAD_LEFT);


                //��ɼ�ֹ椬Ʊ���ʥ��顼����ʤ��˾�硢��������ID�򿶤�
                if($sale_no === $chk_sale_no){
                    //��������ID��Ͽ������
                    $daily_slip_id = Get_Daily_Slip_Id($db_con);
                }


                if($sale_no === $chk_sale_no && $daily_slip_id !== false){

                    //�����ֹ����֥ơ��֥���Ͽ
                    if($group_kind == "2"){
                        $sql = "INSERT INTO t_aorder_no_serial (ord_no) VALUES ('$sale_no');";
                    }else{
                        $sql = "INSERT INTO t_aorder_no_serial_fc (ord_no, shop_id) VALUES ('$sale_no', $shop_id);";
                    }
                    $result = Db_Query($db_con, $sql );
                    if($result == false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
*/

                    //��������ID����
                    $aord_id = Get_Pkey();


                    //����إå�����ϿSQL
                    $sql  = "INSERT INTO \n";
                    $sql .= "    t_aorder_h \n";
                    $sql .= "( \n";
                    $sql .= "    aord_id, \n";          //����ID
                    //$sql .= "    ord_no, \n";           //�����ֹ�
                    $sql .= "    ord_time, \n";         //ͽ������
                    $sql .= "    client_id, \n";        //������ID
                    $sql .= "    client_cd1, \n";       //�����襳����
                    $sql .= "    client_cd2, \n";       //�����襳���ɣ�
                    $sql .= "    client_cname, \n";     //ά��
                    $sql .= "    client_name, \n";      //������̾
                    $sql .= "    client_name2, \n";     //������̾��
                    $sql .= "    claim_id, \n";         //������ID
                    $sql .= "    claim_div, \n";        //�����ʬ
                    $sql .= "    trade_id, \n";         //�����ʬ������
                    $sql .= "    arrival_day, \n";      //������
                    //ľ���褬���ꤵ��Ƥ�����
                    if($direct_id != null){
                        $sql .= "    direct_id, ";
                        $sql .= "    direct_name, ";
                        $sql .= "    direct_name2, ";
                        $sql .= "    direct_cname, ";
                    }
                    //��Զ�ʬȽ��
                    if($contract_div == "1"){
                        //���ҽ��ξ��
                        $sql .= "    route, \n";            //��ϩ
                        $sql .= "    ware_id, \n";          //�в��Ҹ�ID
                        $sql .= "    ware_name, \n";        //�в��Ҹ�̾
                    }else{
                        //���ե饤����Ԥξ��
                        $sql .= "    act_id, \n";           //���ID
                        $sql .= "    act_cd1, \n";          //����襳����
                        $sql .= "    act_cd2, \n";          //����襳���ɣ�
                        $sql .= "    act_name, \n";         //�����̾
                        $sql .= "    act_div, \n";          //�������ʬ
                        $sql .= "    act_request_rate, \n"; //�������Ψ��
                        $sql .= "    act_request_price, \n";//������ʸ���ۡ�
                        $sql .= "    trust_net_amount, \n"; //�ʼ������ѡ�����ۡ���ȴ��
                        $sql .= "    trust_tax_amount, \n"; //�ʼ������ѡ˾����ǳ�
                    }
                    $sql .= "    cost_amount, \n";      //������ۡ���ȴ��
                    $sql .= "    net_amount, \n";       //����ۡ���ȴ��
                    $sql .= "    tax_amount, \n";       //�����ǳ�
                    $sql .= "    note, \n";             //����
                    $sql .= "    ps_stat, \n";          //��������
                    $sql .= "    shop_id, \n";          //����å�ID
                    $sql .= "    slip_out, \n";         //��ɼ����
                    $sql .= "    contract_div, \n";     //�����ʬ
                    //$sql .= "    round_form, \n";       //������
                    $sql .= "    ord_staff_id, \n";     //���ڥ졼��ID
                    $sql .= "    ord_staff_name, \n";   //���ڥ졼��̾
                    //$sql .= "    daily_slip_id, \n";        //��������ID
                    //$sql .= "    daily_slip_out_day, \n";   //�������������
                    $sql .= "    advance_offset_totalamount, \n";   //�����껦�۹��
                    $sql .= "    hand_plan_flg \n";     //ͽ����ե饰

                    $sql .= ") VALUES ( \n";

                    $sql .= "    $aord_id, \n";         //����ID
                    //$sql .= "    '$sale_no', \n";       //�����ֹ�
                    $sql .= "    '$sale_day', \n";      //ͽ������
                    $sql .= "    $client_id, \n";       //������ID
                    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), \n";   //������CD1
                    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), \n";   //������CD2
                    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), \n"; //������̾��ά�Ρ�
                    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), \n";  //������̾
                    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), \n"; //������̾2
                    $sql .= "    $claim_id, \n";
                    $sql .= "    $claim_div, \n";
                    $sql .= "    '$trade_aord', \n";    //�����ʬ������
                    $sql .= "    '$claim_day', \n";     //������

                    //ľ���褬���ꤵ��Ƥ�����
                    if($direct_id != null){
                        $sql .= "    $direct_id, ";
                        $sql .= "    (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), ";
                    }
                    //��Զ�ʬȽ��
                    if($contract_div == "1"){
                        //���ҽ��ξ��
                        $sql .= "    $route, \n";       //��ϩ
                        $sql .= "    $ware_id,\n";      //�в��Ҹ�ID
                        $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), \n";      //�в��Ҹ�̾
                    }else{
                        //���ե饤����Ԥξ��
                        $sql .= "    $act_id, \n";
                        $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $act_id), \n";  //�����CD1
                        $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $act_id), \n";  //�����CD2
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $act_id), ";  //�����̾��ά�Ρ�
                        $sql .= "    '$act_div', \n";           //�������ʬ
                        $sql .= "    '$act_request_rate', ";    //�������Ψ��
                        $sql .= ($act_request_price != null) ? "    $act_request_price, \n" : "    null, \n";   //������ʸ���ۡ�
                        $sql .= "    $trust_sale_money, \n";    //�ʼ������ѡ�����ۡ���ȴ��
                        $sql .= "    $trust_sale_tax, \n";      //�ʼ������ѡ˾����ǳ�
                    }
                    $sql .= "    $cost_money, \n";      //������ۡ���ȴ��
                    $sql .= "    $sale_money, \n";      //����ۡ���ȴ��
                    $sql .= "    $sale_tax, \n";        //�����ǳ�
                    $sql .= "    '$note', \n";          //����
                    $sql .= "    '1', \n";              //̤����
                    $sql .= "    $cclient_shop ,\n";    //����å�ID
                    $sql .= "    (SELECT slip_out FROM t_client WHERE client_id = $client_id), \n";     //��ɼ����
                    $sql .= "    '$contract_div', \n";  //�����ʬ
                    //$sql .= "    'ͽ������ɼ',\n";    //������
                    $sql .= "    $e_staff_id, \n";      //���ڥ졼��ID
                    $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $e_staff_id), \n";    //���ڥ졼��̾
                    //$sql .= "    $daily_slip_id, \n";   //��������ID
                    //$sql .= "    CURRENT_TIMESTAMP, \n";//�������������
                    $sql .= ($ad_offset_flg == true) ? "    $ad_offset_total_amount, \n" : "    NULL, \n";
                    $sql .= "    true \n";              //ͽ����ե饰

                    $sql .= ");";
//print_array($sql, "����إå���Ͽ");

                    $result = Db_Query($db_con, $sql);
                    //Ʊ���¹��������
                    if($result === false){
/*
                        $err_message = pg_last_error();
                        $err_format = "t_aorder_h_ord_no_key";

                        Db_Query($db_con, "ROLLBACK;");

                        //��ɼ�ֹ椬��ʣ�������            
                        if((strstr($err_message, $err_format) !== false)){ 
                            $error = "Ʊ������Ͽ��Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦������Ͽ�򤷤Ʋ�������";

                            //������ɼ�ֹ���������
                            //ľ�Ĥξ��
                            if($group_kind == "2"){
                                $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                            //FC�ξ��
                            }else{
                                $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                            }

                            $result = Db_Query($db_con, $sql);
                            $sale_no = pg_fetch_result($result, 0 ,0);
                            $sale_no = $sale_no +1;
                            $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

                            $err_data["form_sale_no"] = $sale_no;

                            $form->setConstants($err_data);

                            $duplicate_flg = true;
                        }else{
*/
                            Db_Query($db_con, "ROLLBACK;");
                            exit();
                        //}

                    }

                    //�ѹ����ϴ�λ��˰��������
                    if($new_entry == "false"){
                        $change_flg = "true";
                    }

/*
                }elseif($sale_no !== $chk_sale_no){

                    Db_Query($db_con, "ROLLBACK;");

                    //��ɼ�ֹ椬��ʣ�������
                    $error = "Ʊ������Ͽ��Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦������Ͽ�򤷤Ʋ�������";

                    //������ɼ�ֹ���������
                    //ľ�Ĥξ��
                    if($group_kind == "2"){
                        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                    //FC�ξ��
                    }else{
                        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                    }

                    $result = Db_Query($db_con, $sql);
                    $sale_no = pg_fetch_result($result, 0 ,0);
                    $sale_no = $sale_no +1;
                    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

                    $err_data["form_sale_no"] = $sale_no;

                    $form->setConstants($err_data);

                    $duplicate_flg = true;

                //INSERT����ɼ�ֹ��ʣ��ǧ�����

                //��������ID����ʣ����
                }else{

                    //��������ID����ʣ�������
                    $daily_slip_error = "Ʊ������Ͽ��Ԥä����ᡢ��������No.����ʣ���ޤ������⤦������Ͽ�򤷤Ʋ�������";

                    $daily_slip_error_flg = true;

                }
*/

            }//����إå�������Ͽ�����


            //����إå���Ͽ�����������ｪλ�������ô���ơ��֥롢����ǡ����ơ��֥����Ͽ
            //if($duplicate_flg === false && $daily_slip_error_flg === false){

                //���ҽ��ξ��Τ߽��ô���ơ��֥���Ͽ
                if($contract_div == "1"){
                    for($i=0;$i<=3;$i++){
                        //�����åդ����ꤵ��Ƥ��뤫Ƚ��
                        if($staff_check[$i] != NULL){
                            $sql  = "INSERT INTO t_aorder_staff ( ";
                            $sql .= "    aord_id, ";
                            $sql .= "    staff_div, ";
                            $sql .= "    staff_id, ";
                            $sql .= "    sale_rate, ";
                            $sql .= "    staff_name ";
                            $sql .= ") VALUES ( ";
                            $sql .= "    $aord_id, ";                   //����ID
                            $sql .= "    '$i', ";                       //���ô���Լ���
                            $sql .= "    ".$staff_check[$i].", ";       //���ô����ID
                            $sql .= ($staff_rate[$i] != NULL) ? "    ".$staff_rate[$i].", " : "    NULL, ";             //���Ψ
                            $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = ".$staff_check[$i].") ";      //ô����̾
                            $sql .= ");";
                            $result = Db_Query($db_con, $sql);
                            if($result === false){
                                Db_Query($db_con, "ROLLBACK;");
                                exit();
                            }
                        }
                    }
                }//���ô���ԥơ��֥���Ͽ�����

                //����ǡ�����Ͽ
                for($i = 1; $i <= 5; $i++){

                    //�����ӥ����ޤ��ϥ����ƥब���Ϥ���Ƥ���ԤΤ���Ͽ
                    if($serv_id[$i] != null || $goods_item_id[$i] != null){

                        //�����ѹ�
                        $c_price = $trade_price[$i];    //�Ķȸ���
                        $s_price = $sale_price[$i];     //���ñ��

                        //���ҽ��ǡ������ƥब���Ϥ���Ƥ����硢����ñ���ʺ߸�ñ���ˤ����
                        //if($goods_item_id[$i] != null){
                        if($contract_div == "1" && $goods_item_id[$i] != null){
                            //���ʤ������ʤ��ɤ���
                            $sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_item_id[$i].";";
                            $result = Db_Query($db_con, $sql);
                            if($result == false){
                                Db_Query($db_con, "ROLLBACK;");
                                exit();
                            }
                            $compose_flg = pg_fetch_result($result, 0, "compose_flg");

                            //���ʤκ߸�ñ���ʻ���ñ�������������ˤ����
                            if($compose_flg == "t"){
                                $array_price = Compose_price($db_con, $shop_id, $goods_item_id[$i]);
                                $b_price = $array_price[2];
                                $b_amount = $array_price[2] * $goods_item_num[$i];
                            }else{
                                $sql  = "SELECT ";
                                $sql .= "    r_price ";
                                $sql .= "FROM ";
                                $sql .= "    t_price ";
                                $sql .= "WHERE ";
                                $sql .= "    goods_id = ".$goods_item_id[$i]." ";
                                $sql .= "AND ";
                                if($_SESSION["group_kind"] == "2"){
                                    $sql .= "    shop_id IN (".Rank_Sql().") ";
                                }else{
                                    $sql .= "    shop_id = ".$shop_id." ";
                                }
                                $sql .= "AND ";
                                $sql .= "    rank_cd = '3' ";   //�߸�ñ��
                                $sql .= ";";

                                $result = Db_Query($db_con, $sql);
                                if($result == false){
                                    Db_Query($db_con, "ROLLBACK;");
                                    exit;
                                }
                                $b_price = pg_fetch_result($result, 0, "r_price");
                                $b_amount = $b_price * $goods_item_num[$i];
                            }
                        //�����ӥ��������ޤ�����Ԥξ��ϱĶȸ�����Ʊ����ۤ������
                        }else{
                            $b_price = $c_price;
                            $b_amount = $trade_amount[$i];
                        }

                        //����ǡ�����Ͽ
                        $sql  = "INSERT INTO ";
                        $sql .= "    t_aorder_d ";
                        $sql .= "( ";
                        $sql .= "    aord_d_id, ";
                        $sql .= "    aord_id, ";
                        $sql .= "    line, ";
                        $sql .= "    sale_div_cd, ";
                        //�����ӥ�
                        if($serv_id[$i] != null){
                            $sql .= "    serv_print_flg, ";
                            $sql .= "    serv_id, ";
                            $sql .= "    serv_cd, ";
                            $sql .= "    serv_name, ";
                        }
                        //�����ƥ�
                        if($goods_item_id[$i] != null){
                            $sql .= "    goods_print_flg, ";
                            $sql .= "    goods_id, ";
                            $sql .= "    goods_cd, ";
                            $sql .= "    goods_name, ";
                            //$sql .= "    unit, ";
                            $sql .= "    g_product_name, ";
                            $sql .= "    official_goods_name, ";
                        }
                        //����
                        if($goods_item_num[$i] != null){
                            $sql .= "    num, ";
                        }
                        //�켰�ե饰
                        if($set_flg[$i] == true){
                            $sql .= "    set_flg, ";
                        }
                        //������
                        if($goods_expend_id[$i] != null){
                            $sql .= "    egoods_id, ";
                            $sql .= "    egoods_cd, ";
                            $sql .= "    egoods_name, ";
                            $sql .= "    egoods_num, ";
                        }
                        //���ξ���
                        if($goods_body_id[$i] != null){
                            $sql .= "    rgoods_id, ";
                            $sql .= "    rgoods_cd, ";
                            $sql .= "    rgoods_name, ";
                            $sql .= "    rgoods_num, ";
                        }
                        //�Ҳ���
                        if($aprice_div[$i] == "2"){
                            $sql .= "    account_price, ";
                        }elseif($aprice_div[$i] == "3"){
                            $sql .= "    account_rate, ";
                        }
                        $sql .= "    tax_div, ";
                        $sql .= "    buy_price, ";
                        $sql .= "    cost_price, ";
                        $sql .= "    sale_price, ";
                        $sql .= "    buy_amount, ";
                        $sql .= "    cost_amount, ";
                        $sql .= "    sale_amount, ";
                        //��Ԥξ��
                        if($contract_div != "1"){
                            $sql .= "    trust_sale_price, ";
                            $sql .= "    trust_sale_amount, ";
                        }
                        $sql .= "    advance_flg, ";
                        $sql .= "    advance_offset_amount ";

                        $sql .= ") VALUES ( ";

                        //����ǡ���ID����
                        $aord_d_id = Get_Pkey();
                        $sql .= "    $aord_d_id, ";

                        $sql .= "    $aord_id, ";
                        $sql .= "    ".(string)$i.", ";
                        $sql .= "    '".$divide[$i]."', ";
                        if($serv_id[$i] != null){
                            $sql .= "    ".$slip_flg[$i].", ";
                            $sql .= "    ".$serv_id[$i].", ";
                            $sql .= "    (SELECT serv_cd FROM t_serv WHERE serv_id = ".$serv_id[$i]."), ";
                            $sql .= "    (SELECT serv_name FROM t_serv WHERE serv_id = ".$serv_id[$i]."), ";
                        }
                        if($goods_item_id[$i] != null){
                            $sql .= "    ".$goods_item_flg[$i].", ";    //�����ƥ�����ե饰
                            $sql .= "    ".$goods_item_id[$i].", ";     //�����ƥ�ID
                            $sql .= "    '".$goods_item_cd[$i]."', ";
                            $sql .= "    '".$goods_item_name[$i]."', ";
                            $sql .= "    (SELECT g_product_name FROM t_g_product WHERE g_product_id = (SELECT g_product_id FROM t_goods WHERE goods_id = ".$goods_item_id[$i].")), ";
                            $sql .= "    '".$official_goods_name[$i]."', "; //�����ƥ�̾��������
                        }
                        if($goods_item_num[$i] != null){
                            $sql .= "    ".$goods_item_num[$i].", ";
                        }
                        if($set_flg[$i] == true){
                            $sql .= "    '".$set_flg[$i]."', ";
                        }
                        //������
                        if($goods_expend_id[$i] != null){
                            $sql .= "    ".$goods_expend_id[$i].", ";
                            $sql .= "    '".$goods_expend_cd[$i]."', ";
                            $sql .= "    '".$goods_expend_name[$i]."', ";
                            $sql .= "    ".$goods_expend_num[$i].", ";
                        }
                        //���ξ���
                        if($goods_body_id[$i] != null){
                            $sql .= "    ".$goods_body_id[$i].", ";
                            $sql .= "    '".$goods_body_cd[$i]."', ";
                            $sql .= "    '".$goods_body_name[$i]."', ";
                            $sql .= "    ".$goods_body_num[$i].", ";
                        }
                        //�Ҳ���
                        if($aprice_div[$i] == "2"){
                            $sql .= "    ".$ac_price[$i].", ";
                        }elseif($aprice_div[$i] == "3"){
                            $sql .= "    '".$ac_rate[$i]."', ";
                        }
                        $sql .= "    '".$tax_div[$i]."', ";
                        $sql .= "    $b_price, ";
                        $sql .= "    $c_price, ";
                        $sql .= "    $s_price, ";
                        $sql .= "    $b_amount, ";
                        $sql .= "    ".$trade_amount[$i].", ";
                        $sql .= "    ".$sale_amount[$i].", ";
                        //��Ԥξ��
                        if($contract_div != "1"){
                            $sql .= "    ".$trust_sale_price[$i].", ";
                            $sql .= "    ".$trust_sale_amount[$i].", ";
                        }
                        $sql .= "    '".$ad_flg[$i]."', ";
                        $sql .= ($ad_flg[$i] == "2") ? "    ".$ad_offset_amount[$i]." " : "    NULL ";

                        $sql .= ");";
//echo "$sql<br>";

                        $result = Db_Query($db_con, $sql);
                        if($result == false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit();
                        }


                        //���ҽ��ξ�硢�и��ʥơ��֥롢�߸˼�ʧ����Ͽ
                        if($contract_div == "1"){
                            $s = $i;                    //�롼�ץ�����
                            $cshop_id = $cclient_shop;  //����å�ID��ô����ŹID��
                            require(INCLUDE_DIR."plan_data_sql_stock_hand.inc");
                        }

                    }//���Ϲ�Ƚ�ꤪ���

                }//����ǡ�����Ͽ�����


                //����إå��ξҲ�Դط�����Ͽ
                $sql  = "UPDATE \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "SET \n";
                if($intro_account_id != null){
                    $sql .= "    intro_account_id = $intro_account_id, \n";     //�Ҳ��ID
                    $sql .= "    intro_ac_name = (SELECT client_cname FROM t_client WHERE client_id = $intro_account_id), \n";  //�Ҳ��̾��ά�Ρ�
                    $sql .= "    intro_ac_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $intro_account_id), \n";     //�Ҳ��CD1
                    $sql .= "    intro_ac_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $intro_account_id), \n";     //�Ҳ��CD1
                }else{
                    $sql .= "    intro_account_id = null, \n";
                    $sql .= "    intro_ac_name = null, \n";
                    $sql .= "    intro_ac_cd1 = null, \n";
                    $sql .= "    intro_ac_cd2 = null, \n";
                }
                $sql .= "    intro_ac_div = '$intro_ac_div', \n";               //�Ҳ���¶�ʬ
                $sql .= ($intro_ac_price != null) ? "    intro_ac_price = $intro_ac_price, \n" : "    intro_ac_price = null, \n";   //�Ҳ����ñ��
                $sql .= ($intro_ac_rate != null) ? "    intro_ac_rate = '$intro_ac_rate' \n" : "    intro_ac_rate = null \n";       //�Ҳ����Ψ
                $sql .= "WHERE \n";
                $sql .= "    aord_id = $aord_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

                //������˾Ҳ�Ԥ����ꤵ��Ƥ��ơ�ȯ�����ʤ�����ʤ���硢�Ҳ��������׻�
                if($intro_account_id != null && $intro_ac_div != "1"){
                    $intro_amount = FC_Intro_Amount_Calc($db_con, "aord", $aord_id);
                }else{
                    $intro_amount = null;
                }
                //����إå��ξҲ�������Ͽ
                $sql  = "UPDATE \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "SET \n";
                $sql .= ($intro_amount !== null) ? "    intro_amount = $intro_amount \n" : "    intro_amount = null \n";    //�Ҳ���¶��
                $sql .= "WHERE \n";
                $sql .= "    aord_id = $aord_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }


                //������ζ�۹����ؿ�
                if($group_kind == "2"){
                    $result = Update_Act_Amount($db_con, $aord_id, "aord");
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
                }


                Db_Query($db_con, "COMMIT;");


                //���ܸ���ʬ�ȼ���ID������᤹
                $back_display = $_POST["back_display"];
                //���󥷥ꥢ�饤����
                $array_id = serialize($aord_id_array);
                $array_id = urlencode($array_id);

                //header("Location: ".$_SERVER["PHP_SELF"]."?aord_id=$aord_id&done_flg=true&change_flg=$change_flg&installment_flg=$trade_aord");
                header("Location: ".$_SERVER["PHP_SELF"]."?aord_id=$aord_id&done_flg=true&change_flg=$change_flg&back_display=$back_display&aord_id_array=$array_id");

            //}//����ǡ�����������ԥơ��֥롢����и��ʡ��߸˼�ʧ�ơ��֥���Ͽ�����

        }else{
            //��Ͽ��ǧ����
            if($contract_div == "1"){
                //���ҽ��ξ�硢���������԰����������
                $confirm_set_data["form_daiko"] = "";
                $confirm_set_data["form_daiko_price"] = "";
            //��Ԥξ�硢�ҸˤȽв��Ҹˤ����
            }else{
                $confirm_set_data["form_ac_staff_select"] = "";
                //$confirm_set_data["form_ware_select"] = "";
            }
            $form->setConstants($confirm_set_data);

            //��Ͽ��ǧ���̤�ɽ���ե饰
            $comp_flg = true;
            $form->freeze();
        }
    }else{
        //���顼���ļ���ID��̵����н����
        //if($aord_id == NULL){
            //$client_data["form_sale_btn"]       = "";        //��ǧ���̤إܥ���
            $client_data["show_button_flg"]     = "";        //ɽ���ܥ���
            $form->setConstants($client_data);
        //}
    }
}


$array_id = stripslashes($_GET["aord_id_array"]);
$array_id = urldecode($array_id);
$array_id = unserialize($array_id);
$array_id = serialize($array_id);
$array_id = urlencode($array_id);

//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ�
//if($_POST["form_sale_btn"] != "��ǧ���̤�" && $_POST["comp_button"] != "�ϡ���"){
if($comp_flg != true){

    //button
    $form->addElement("submit","form_sale_btn","��ǧ���̤�", $disabled);
    //$form->addElement("button","form_back_button","�ᡡ��","onClick=\"location.href='2-2-207.php?search=1'\"");
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"location.href='2-2-106.php?aord_id=$aord_id&back_display=$back_display&aord_id_array=$array_id'\"");

    //���
    $form->addElement("button","form_sum_btn","�硡��","onClick=\"javascript:Button_Submit('sum_button_flg','#hand','true')\"");

//}elseif($_POST["form_sale_btn"] == "��ǧ���̤�"){
}else{
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
    //OK
    $form->addElement("button","comp_button","�ϡ���", "onclick=\"Double_Post_Prevent('comp_button', 'hdn_comp_button', '�ϡ���');\"");
    $form->addElement("hidden","hdn_comp_button");

    $form->addElement("button","history_back","�ᡡ��","onClick=\"javascript: history.back();\"");

}

//��λ����
if($done_flg == "true"){

    //��ɼʣ��
    $form->addElement("button", "slip_copy_button", "��ɼʣ��", 
        "onClick=\"Submit_Page2('".$_SERVER["PHP_SELF"]."?slip_copy=true&aord_id=".$aord_id."&back_display=$back_display&aord_id_array=$array_id');\""
    );

    //���
    $form->addElement("button", "return_edit_button", "�ᡡ��", 
        //"onClick=\"javascript: location.href='".$_SERVER["PHP_SELF"]."?aord_id=$aord_id'\""
        "onClick=\"Submit_Page2('".$_SERVER["PHP_SELF"]."?aord_id=".$aord_id."&back_display=$back_display&aord_id_array=$array_id');\""
    );

    //�����å��ܥå�������Ƚ��ե饰
    $form->addElement("hidden", "check_value_flg", "t");
}

/*
if($_GET["renew_flg"] == "true"){
    $form->addElement("button","return_button","�ᡡ��","onClick=\"history.back();\"");
}else{
    //$form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='./2-2-207.php?search=1'\"");
    $form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='./2-2-106.php?aord_id=$aord_id&back_display=$back_display&aord_id_array=$array_id'\"");
}
*/


$form->setConstants($con_data2);


//�ե����ब�ե꡼�����Ƥ뤫
$freeze_flg = $form->isFrozen();
#2009-09-18 hashimoto-y
#�ֻ�ɽ���ԤΥե饰�򥻥åȤ���
if($freeze_flg == true){
    $num = 5;
    $toSmarty_discount_flg = array();
    for ($i=1; $i<=$num; $i++){
        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");
        if($hdn_discount_flg === 't'){
            $toSmarty_discount_flg[$i] = 't';
        }else{
            $toSmarty_discount_flg[$i] = 'f';
        }
    }
}


/****************************/
// ������ξ��ּ���
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


/****************************/
//javascript
/****************************/
$java_sheet = "";

//�켰�˥����å����դ�����硢��۷׻�����
$java_sheet  .= "function Set_num(row, coax, daiko_coax){\n";
//FC��ľ��Ƚ��
if($group_kind == 2){
    //ľ�Ĥϡ���������θ�����׻�
    $java_sheet  .= "    Mult_double3('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false,row,'',daiko_coax);\n";
}else{
    //�ƣäϡ����̤ΰ켰�η׻�
    $java_sheet  .= "    Mult_double2('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false);\n";
}
$java_sheet  .= "}\n\n";


/*
//���ʥ��������ؿ�
$java_sheet  .= <<<DAIKO
function Open_SubWin_Plan(url, arr, x, y,display,select_id,shop_aid,place,head_flg)
{
    //�������������ꤵ��Ƥ�����ϡ��Ҹ�ID or ê��Ĵ��ID ��ɬ��
    if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){

        //�����ʬ���̾�ʳ��ϡ������ξ��ʤ�����ɽ��
        if(head_flg != 1){
            //����饤�󡦥��ե饤�����
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,true);
        }else{
            //�̾�
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,false);
        }

        if(typeof(rtnarr) != "undefined"){
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }

        //����ޥ����ξ��ϲ��̤Υ�����submit����
        if(display==6 || display==7){
            var next = '#'+place;
            document.dateForm.action=next;
            document.dateForm.submit();
        }

    }

    return false;
}

DAIKO;
*/


//��԰�������å��ܥå���
$java_sheet  .= <<<DAIKO
function tegaki_daiko_checked(){
    //��԰���Ƚ��
    if(!document.dateForm.daiko_check[0].checked){
        //����饤����ԡ����ե饤�����

        //�����
        for(i=0;i<3;i++){
            document.dateForm.elements["act_div[]"][i].disabled = false;
        }
        document.dateForm.elements["act_request_price"].disabled = false;
        document.dateForm.elements["act_request_rate"].disabled = false;
        document.dateForm.elements["act_request_price"].style.backgroundColor = "white";
        document.dateForm.elements["act_request_rate"].style.backgroundColor = "white";

        //������
        document.dateForm.elements["form_daiko[cd1]"].disabled = false;
        document.dateForm.elements["form_daiko[cd2]"].disabled = false;
        document.dateForm.elements["form_daiko[name]"].disabled = false;
        document.dateForm.elements["form_daiko[cd1]"].style.backgroundColor = "white";
        document.dateForm.elements["form_daiko[cd2]"].style.backgroundColor = "white";
        document.dateForm.elements["form_daiko[name]"].style.backgroundColor = "white";

        //�������ʬ��value�ͼ���
        num = document.forms[0].elements["act_div[]"].length;
        for (i=0;i<num;i++) {
            flag = document.forms[0].elements["act_div[]"][i].checked;
            if (flag){
                act_div = document.forms[0].elements["act_div[]"][i].value;
            }
        }

        //�Ķȸ���
        if(act_div == "3"){
            for(i=1;i<=5;i++){
                form_name = "form_trade_price["+i+"][1]";
                document.dateForm.elements[form_name].readOnly = true;
                form_name = "form_trade_price["+i+"][2]";
                document.dateForm.elements[form_name].readOnly = true;
            }
        }

        //�в��Ҹ�
        ware_name.innerHTML = "";

        //���ô����
        document.dateForm.elements["form_c_staff_id1"].disabled = true;
        document.dateForm.elements["form_c_staff_id1"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_sale_rate1"].disabled = true;
        document.dateForm.elements["form_sale_rate1"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_c_staff_id2"].disabled = true;
        document.dateForm.elements["form_c_staff_id2"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_sale_rate2"].disabled = true;
        document.dateForm.elements["form_sale_rate2"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_c_staff_id3"].disabled = true;
        document.dateForm.elements["form_c_staff_id3"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_sale_rate3"].disabled = true;
        document.dateForm.elements["form_sale_rate3"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_c_staff_id4"].disabled = true;
        document.dateForm.elements["form_c_staff_id4"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_sale_rate4"].disabled = true;
        document.dateForm.elements["form_sale_rate4"].style.backgroundColor = "gainsboro";

        //��ϩ
        document.dateForm.elements["form_route_load[1]"].disabled = true;
        document.dateForm.elements["form_route_load[1]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_route_load[2]"].disabled = true;
        document.dateForm.elements["form_route_load[2]"].style.backgroundColor = "gainsboro";

    }else{
        //�̾�

        //�����
        for(i=0;i<3;i++){
            document.dateForm.elements["act_div[]"][i].disabled = true;
        }
        document.dateForm.elements["act_request_price"].disabled = true;
        document.dateForm.elements["act_request_rate"].disabled = true;
        document.dateForm.elements["act_request_price"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["act_request_rate"].style.backgroundColor = "gainsboro";

        //�Ķȸ���
        for(i=1;i<=5;i++){
            form_name = "form_trade_price["+i+"][1]";
            document.dateForm.elements[form_name].readOnly = false;
            form_name = "form_trade_price["+i+"][2]";
            document.dateForm.elements[form_name].readOnly = false;
        }

        //������
        document.dateForm.elements["form_daiko[cd1]"].disabled = true;
        document.dateForm.elements["form_daiko[cd2]"].disabled = true;
        document.dateForm.elements["form_daiko[name]"].disabled = true;
        document.dateForm.elements["form_daiko[cd1]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_daiko[cd2]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_daiko[name]"].style.backgroundColor = "gainsboro";

        //�в��Ҹ�
        ware_name.innerHTML = document.dateForm.elements["hdn_ware_name"].value;

        //���ô����
        document.dateForm.elements["form_c_staff_id1"].disabled = false;
        document.dateForm.elements["form_c_staff_id1"].style.backgroundColor = "white";
        document.dateForm.elements["form_sale_rate1"].disabled = false;
        document.dateForm.elements["form_sale_rate1"].style.backgroundColor = "white";
        document.dateForm.elements["form_c_staff_id2"].disabled = false;
        document.dateForm.elements["form_c_staff_id2"].style.backgroundColor = "white";
        document.dateForm.elements["form_sale_rate2"].disabled = false;
        document.dateForm.elements["form_sale_rate2"].style.backgroundColor = "white";
        document.dateForm.elements["form_c_staff_id3"].disabled = false;
        document.dateForm.elements["form_c_staff_id3"].style.backgroundColor = "white";
        document.dateForm.elements["form_sale_rate3"].disabled = false;
        document.dateForm.elements["form_sale_rate3"].style.backgroundColor = "white";
        document.dateForm.elements["form_c_staff_id4"].disabled = false;
        document.dateForm.elements["form_c_staff_id4"].style.backgroundColor = "white";
        document.dateForm.elements["form_sale_rate4"].disabled = false;
        document.dateForm.elements["form_sale_rate4"].style.backgroundColor = "white";

        //��ϩ
        document.dateForm.elements["form_route_load[1]"].disabled = false;
        document.dateForm.elements["form_route_load[1]"].style.backgroundColor = "white";
        document.dateForm.elements["form_route_load[2]"].disabled = false;
        document.dateForm.elements["form_route_load[2]"].style.backgroundColor = "white";

    }
    
    return true;
}

DAIKO;


//��Ԥ�JS���ɲ�
$java_sheet .= Create_Js("daiko");

//plan_data.inc��JS���ɲ�
$java_sheet .= $plan_data_js;



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
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'warning'       => "$warning",
    //'html'          => "$html",
    'form_potision' => "$form_potision",
    'error_flg'     => $error_flg,
    //'duplicate_err' => "$error",
    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_msg16'   => "$error_msg16",
    //'daily_slip_error'  => "$daily_slip_error",
    //'sale_div_error' => "$sale_div_error",
    'comp_flg'      => "$comp_flg",
    'auth_r_msg'    => "$auth_r_msg",
    'done_flg'      => "$done_flg", 
    'client_id'     => "$client_id", 
    'aord_id'       => "$aord_id", 
    'html_js'       => "$java_sheet", 
    'renew_flg'     => "$renew_flg", 
    'new_entry'     => "$new_entry",
    'slip_del_flg'  => "$slip_del_flg",
    'slip_renew_mess' => "$slip_renew_mess",
    'ad_total_warn_mess'    => "$ad_total_warn_mess",
    'freeze_flg'    => $freeze_flg,
    'buy_err_mess'  => "$buy_err_mess",
    'ac_name'       => "$ac_name",
    'warn_lump_change'		=> "$warn_lump_change",	//rev.1.3 ͽ������2����ʾ�Υ��Ƥ����å�����

    'contract_div'  => "$contract_div",
    "client_state_print"    => "$client_state_print",
));

$smarty->assign('error_msg4',$error_msg4);
$smarty->assign('error_msg5',$error_msg5);
$smarty->assign('error_msg10',$error_msg10);

$loop_array = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");
$smarty->assign('loop_num',$loop_array);
$smarty->assign('error_loop_num1',$loop_array);
$error_loop_num3 = array(0=>"0",1=>"1",2=>"2",3=>"3",4=>"4");
$smarty->assign('error_loop_num3',$error_loop_num3);

#2009-09-17 hashimoto-y
$smarty->assign('toSmarty_discount_flg',$toSmarty_discount_flg);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"] .".tpl"));


//echo "<font color=red style=\"font-family: 'HGS�Խ���';\"><b>�Խ���ˤĤ������ޤ���Ͽ�Ǥ��ޤ���</b></font>";
//print_array($smarty);
//print_array ($_POST);
//print_array ($_SESSION);
//print_array($new_entry, '$new_entry');

?>
