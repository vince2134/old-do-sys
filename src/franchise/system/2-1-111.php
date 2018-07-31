<?php
/**************************
*�ѹ�����
*   ��2006/05/08��
*       �����ե�����ɽ���ܥ����ɲá�watanabe-k��
*       ɽ���ǡ�����������̾����ά�Τ��ѹ���watanabe-k��
*    (2006/08/10)
*       ��Զȼԡ����ô���ԥᥤ�󡢥��֣������Ǥθ��������ɲá�watanabe-k��
*       ľ�İʳ��Υ���åפ˴ؤ��ƤϾ嵭�ν����Ϥʤ�
***************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-02-22                  watanabe-k  ���׵�ǽ�κ��
 *  2007-03-16                  watanabe-k  ���̤κ��
 *  2007-03-26                  morita-d    CSV�Ƿ������٤���Ϥ���褦�˽���
 *  2007-05-10                  watanabe-k  �����������Ƚ��ô���Ԥ�ɽ�� 
 *  2007-05-30                  fukuda      �������ܡַ�����֡פΥǥե���Ȥ�ּ����פ��ѹ�
 *  2007-07-26                  watanabe-k  ��No.�ȷ�������פ���褦�˽���
 *  2007-07-31                  watanabe-k  ������θ���ۤ�CSV��ɽ������褦�˽���
 *  2007-08-28                  watanabe-k  CSV�������껦�ۤ�ɽ�� 
 *  2009-06-19		����No.35	aizawa-m  	CSV����Ʊ����ɽ�� 
 *  2010-05-12      Rev.1.5     hashimoto-y ���ɽ���˸������ܤ���ɽ�����뽤��
 *  2011-06-23      �Х�����    aoyama-n    CSV�������ʬ�ֹ����ס֤���¾�פ����������Ϥ���ʤ�
 *
*/



$page_title = "����ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

//��������Ͽ
//$_SESSION["back_page"] = basename($_SERVER[PHP_SELF]);
Set_Rtn_Page("contract");

/****************************/
//�����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];

/****************************/
//�ǥե����������
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_turn"     => "1",
    "form_show_page"     => "1",
    "form_state"     => "�����",
//    "form_type"     => "3"
);
$form->setDefaults($def_fdata);

/****************************/
//HTML���᡼������������
/****************************/
//���Ϸ���
$radio1[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio1, "form_output_type", "���Ϸ���");

//�����襳����
$form_client[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
        );
$form_client[] =& $form->createElement(
        "static","","","-"
        );
$form_client[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\""
        );
$form->addGroup( $form_client, "form_client", "");

//������̾
$form->addElement("text","form_client_name","�ƥ����ȥե�����",'size="34" maxLength="15" '." $g_form_option");

//��Զȼԥ�����
$form_trust[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_trust[cd1]','form_trust[cd2]',6)\"".$g_form_option."\""
        );
$form_trust[] =& $form->createElement(
        "static","","","-"
        );
$form_trust[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\""
        );
$form->addGroup( $form_trust, "form_trust", "");

//��Զȼ�̾
$form->addElement("text","form_trust_name","�ƥ����ȥե�����",'size="34" maxLength="15" '." $g_form_option");

//TEL
$form->addElement("text","form_tel","","size=\"15\" maxLength=\"13\" style=\"$g_form_style\""." $g_form_option");

//�϶�
$area_ary[] = "";

$area_sql  = " SELECT";
$area_sql .= "      area_id,";
$area_sql .= "      area_name";
$area_sql .= " FROM";
$area_sql .= "      t_area";
$area_sql .= " WHERE";
$area_sql .= "      shop_id = $shop_id";
$area_sql .= ";";

$area_res = Db_Query($conn, $area_sql);
for($i = 0; $i < pg_num_rows($area_res); $i++){
    $area[] = pg_fetch_array($area_res, $i, PGSQL_NUM);
    $area_ary[$area[$i][0]] = $area[$i][1];
}
$form->addElement('select', 'form_area_id',"", $area_ary);

//����ô����1
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_c_staff_id1',"", $select_ary, $g_form_option_select );

//���ô����
$form->addElement('select', 'form_con_staff', "",$select_ary, $g_form_option_select);

//ɽ����
$radio3[] =& $form->createElement( "radio",NULL,NULL, "�����ɽ�","1");
$radio3[] =& $form->createElement( "radio",NULL,NULL, "������������","2");
$radio3[] =& $form->createElement( "radio",NULL,NULL, "����ô���ԥ����ɽ�","3");
$form->addGroup($radio3, "form_turn", "ɽ����");

//ɽ�����
$radio4[] =& $form->createElement( "radio",NULL,NULL, "100��ɽ��","1");
$radio4[] =& $form->createElement( "radio",NULL,NULL, "����ɽ��","2");
$form->addGroup($radio4, "form_show_page", "ɽ�����");

// �������
$radio5[] =& $form->createElement( "radio",NULL,NULL, "�����","�����");
$radio5[] =& $form->createElement( "radio",NULL,NULL, "�ٻ���","�ٻ���");
$radio5[] =& $form->createElement( "radio",NULL,NULL, "����","����");
$form->addGroup($radio5, "form_state", "�������");

// �����ȥ��
$ary_sort_item = array(
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_area"           => "�϶�", 
    "sl_staff_cd"       => "����ô����1",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_client_cd");

//�ܥ���
$button[] = $form->createElement("submit","show_button","ɽ����");
$button[] = $form->createElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addGroup($button, "form_button", "�ܥ���");

//��Ͽ(�إå���)
$form->addElement("button","input_button","�С�Ͽ","onClick=\"location.href='2-1-104.php?flg=add'\"");
$form->addElement("button","change_button","�ѹ�������",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addElement("submit","form_search_button","�����ե������ɽ��");

//hidden
$form->addElement("hidden", "hdn_output_type","","");
$form->addElement("hidden", "hdn_client_cd1","","");
$form->addElement("hidden", "hdn_client_cd2","","");
$form->addElement("hidden", "hdn_client_name","","");
$form->addElement("hidden", "hdn_area_id","","");
$form->addElement("hidden", "hdn_c_staff_id1","","");
$form->addElement("hidden", "hdn_tel","","");
$form->addElement("hidden", "hdn_state","","");
$form->addElement("hidden", "hdn_turn","","");
$form->addElement("hidden", "hdn_show_page","","");
$form->addElement("hidden", "hdn_search_flg");
$form->addElement("hidden", "hdn_trust_cd1","","");
$form->addElement("hidden", "hdn_trust_cd2","","");
$form->addElement("hidden", "hdn_trust_name","","");
$form->addElement("hidden", "hdn_con_staff","","");
$form->addElement("hidden", "hdn_state","","");

/****************************/
//���������
/****************************/
$client_sql  = " SELECT ";
$client_sql .= "     DISTINCT(t_client.client_id) ";
$client_sql .= " FROM";
$client_sql .= "     t_client ";
$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
$client_sql .= " WHERE";
if($_SESSION["group_kind"] == '2'){
    $client_sql .= "    t_client.shop_id IN (".Rank_Sql().")";
}else{
    $client_sql .= "     t_client.shop_id = $shop_id";
}
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = '1'";

//�إå�����ɽ�������������
$count_res = Db_Query($conn, $client_sql.";");
$total_count = pg_num_rows($count_res);

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_button"]["show_button"] == "ɽ����"){

    $output_type    = $_POST["form_output_type"];           //���Ϸ���
    $client_cd1     = trim($_POST["form_client"]["cd1"]);   //�����襳����1
    $client_cd2     = trim($_POST["form_client"]["cd2"]);   //�����襳����2
    $client_name    = trim($_POST["form_client_name"]);     //������̾
    $area_id        = $_POST["form_area_id"];               //�϶�ID
    $staff_id       = $_POST["form_c_staff_id1"];           //����ô���ԣ�
    $tel            = $_POST["form_tel"];                   //TEL
    $turn           = $_POST["form_turn"];                  //ɽ����
    $show_page      = $_POST["form_show_page"];
    $search_flg     = $_POST["hdn_search_flg"];
    $trust_cd1      = trim($_POST["form_trust"]["cd1"]);    //��Զȼԥ����ɣ�
    $trust_cd2      = trim($_POST["form_trust"]["cd2"]);    //��Զȼԥ����ɣ�
    $trust_name     = trim($_POST["form_trust_name"]);      //��Զȼ�̾
    $con_staff      = $_POST["form_con_staff"];             //���ô����
    $state          = $_POST["form_state"];                 // �������

    $offset = 0;
    $sort_col = $_POST["hdn_sort_col"];

    $post_flg       = true;                                 //POST�ե饰
//�����ե�����ɽ���ܥ��󲡲�
}elseif($_POST["form_search_button"] == "�����ե������ɽ��"){
    $output_type    = '1';
    $turn           = '1';
    $show_page      = '1';
    $offset         = 0;
    $state          = "�����";
    $search_flg     = true;
    $sort_col = $_POST["hdn_sort_col"];

}elseif(count($_POST) > 0 
    && $_POST["form_button"]["show_button"] != "ɽ����"
    && $_POST["form_search_button"] != "�����ե������ɽ��"){

    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;
    $output_type    = $_POST["form_output_type"];
    $client_cd1     = $_POST["hdn_client_cd1"];
    $client_cd2     = $_POST["hdn_client_cd2"];
    $client_name    = $_POST["hdn_client_name"];
    $area_id        = $_POST["hdn_area_id"];
    $staff_id       = $_POST["hdn_c_staff_id1"];
    $tel            = $_POST["hdn_tel"];
    $turn           = $_POST["hdn_turn"];
    $show_page      = $_POST["hdn_show_page"]; 
    $search_flg     = $_POST["hdn_search_flg"];
    $trust_cd1      = $_POST["hdn_trust_cd1"];
    $trust_cd2      = $_POST["hdn_trust_cd2"];
    $trust_name     = $_POST["hdn_trust_name"];
    $con_staff      = $_POST["hdn_con_staff"];
    $state          = $_POST["hdn_state"];
    $sort_col = $_POST["hdn_sort_col"];

    $post_flg       = true;
}else{
    $output_type    = '1';
    $turn           = '1';
    $show_page      = '1';
    $state          = "�����";
    $offset         = 0;
    $sort_col = "sl_client_cd";
}

$set_data["form_output_type"]       = stripslashes($output_type);
$set_data["form_client"]["cd1"]     = stripslashes($client_cd1);
$set_data["form_client"]["cd2"]     = stripslashes($client_cd2);
$set_data["form_client_name"]       = stripslashes($client_name);
$set_data["form_area_id"]           = stripslashes($area_id);
$set_data["form_c_staff_id1"]       = stripslashes($staff_id);
$set_data["form_tel"]               = stripslashes($tel);
$set_data["form_trun"]              = stripslashes($turn);
$set_data["form_show_page"]         = stripslashes($show_page);
$set_data["form_trust"]["cd1"]      = stripslashes($trust_cd1);
$set_data["form_trust"]["cd2"]      = stripslashes($trust_cd2);
$set_data["form_trust_name"]        = stripslashes($trust_name);
$set_data["form_con_staff"]         = stripslashes($con_staff);
$set_data["form_state"]             = $state;
$set_data["hdn_output_type"]        = stripslashes($output_type);
$set_data["hdn_client_cd1"]         = stripslashes($client_cd1);
$set_data["hdn_client_cd2"]         = stripslashes($client_cd2);
$set_data["hdn_client_name"]        = stripslashes($client_name);
$set_data["hdn_area_id"]            = stripslashes($area_id);
$set_data["hdn_c_staff_id1"]        = stripslashes($staff_id);
$set_data["hdn_tel"]                = stripslashes($tel);
$set_data["hdn_turn"]               = stripslashes($turn);
$set_data["hdn_show_page"]          = stripslashes($show_page);
$set_data["hdn_search_flg"]         = stripslashes($search_flg);
$set_data["hdn_trust_cd1"]          = stripslashes($trust_cd1);
$set_data["hdn_trust_cd2"]          = stripslashes($trust_cd2);
$set_data["hdn_trust_name"]         = stripslashes($trust_name);
$set_data["hdn_con_staff"]          = $con_staff;
$set_data["hdn_state"]              = $state;

$form->setConstants($set_data);

if($post_flg == true){
    /****************************/
    //where_sql����
    /****************************/
    //�����襳����1
    if($client_cd1 != null){
        $client_cd1_sql  = " AND t_client.client_cd1 LIKE '$client_cd1%'";
    }
       
    //�����襳����2
    if($client_cd2 != null){
        $client_cd2_sql  = " AND t_client.client_cd2 LIKE '$client_cd2%'";
    }

    //������̾
    if($client_name != null){
        $client_name_sql  = " AND (t_client.client_name LIKE '%$client_name%' OR t_client.client_name2 LIKE '%$client_name%' OR t_client.client_cname LIKE '%$client_name%') ";
    }

    //�϶�
    if($area_id != 0){
        $area_id_sql = " AND t_area.area_id = $area_id";
    }

    //����ô����
    if($staff_id != 0){
        $staff_id_sql = " AND t_client.c_staff_id1 = $staff_id";
    }

    //TEL
    if($tel != null){
        $tel_sql  = " AND t_client.tel LIKE '$tel%'";
    }

/*
    //����
    if($type != '3'){
        $type_sql = " AND t_client.type = '$type'";
    } 
*/

    //��Զȼԥ����� OR����Զȼ�̾
    if($trust_cd1 != null || $trust_cd2 != null || $trust_name != null){

        $trust_sql  = " AND ";
        $trust_sql .= " t_client.client_id IN (SELECT ";
        $trust_sql .= "                             client_id ";
        $trust_sql .= "                         FROM ";
        $trust_sql .= "                             t_contract ";
        $trust_sql .= "                         WHERE ";
        $trust_sql .= "                             t_contract.trust_id IN (SELECT \n";
        $trust_sql .= "                                                     client_id \n";
        $trust_sql .= "                                                  FROM \n";
        $trust_sql .= "                                                     t_client \n";
        $trust_sql .= "                                                 WHERE \n";
        $trust_sql .= "                                                     client_div = '3' \n";
        //��Զȼԥ����ɣ�
        if($trust_cd1 != null){
            $trust_sql .= "                                                 AND\n";
            $trust_sql .= "                                                 client_cd1 LIKE '$trust_cd1%' \n";
        }
        //��Զȼԥ����ɣ�
        if($trust_cd2 != null){
            $trust_sql .= "                                                 AND\n";
            $trust_sql .= "                                                 client_cd2 LIKE '$trust_cd2%' \n";
        }
        //��Զȼ�̾
        if($trust_name != null){
            $trust_sql .= "                                                 AND\n";
            $trust_sql .= "                                                 (client_name LIKE '%$trust_name%'\n";
            $trust_sql .= "                                                 OR\n";
            $trust_sql .= "                                                 client_cname LIKE '%$trust_name%')\n";
        }
        $trust_sql .= "                                             )\n";
        $trust_sql .= "                     ) \n";
    }

    //���ô���ԡʽ��ô����1��4�������оݡ�
		//CSV�ξ��
		if($output_type == 2 && $con_staff != null){
        $con_staff_sql  = " AND(\n";
        $con_staff_sql .= " t_con_staff1.staff_id = $con_staff\n";
        $con_staff_sql .= " OR \n";
        $con_staff_sql .= " t_con_staff2.staff_id = $con_staff\n";
        $con_staff_sql .= " OR \n";
        $con_staff_sql .= " t_con_staff3.staff_id = $con_staff\n";
        $con_staff_sql .= " OR \n";
        $con_staff_sql .= " t_con_staff4.staff_id = $con_staff\n";
        $con_staff_sql .= " )\n";

		//���̽��Ϥξ��
    }elseif($con_staff != null){
        $con_staff_sql  = " AND";
        $con_staff_sql .= " t_contract.contract_id IN (SELECT ";
        $con_staff_sql .= "                             contract_id ";
        $con_staff_sql .= "                         FROM ";
        $con_staff_sql .= "                             t_con_staff ";
        $con_staff_sql .= "                         WHERE ";
        $con_staff_sql .= "                             t_con_staff.staff_id = $con_staff\n";
        $con_staff_sql .= "                         )";
    }

    $where_sql  = $client_cd1_sql;
    $where_sql .= $client_cd2_sql;
    $where_sql .= $client_name_sql;
    $where_sql .= $area_id_sql;
    $where_sql .= $staff_id_sql;
    $where_sql .= $tel_sql;
//    $where_sql .= $type_sql;
    $where_sql .= $trust_sql;
    $where_sql .= $con_staff_sql;
}

/****************************/
//ɽ���ǡ�������
/****************************/

#2010-05-13 hashimoto-y
if($post_flg == true){


/****************************/
//���ǡ�������
/****************************/
$client_sql  = "SELECT DISTINCT \n";
$client_sql .= "    t_client.client_id,\n";
$client_sql .= "    t_client.client_cd1,\n";
$client_sql .= "    t_client.client_cd2,\n";
$client_sql .= "    t_client.client_name,\n";
$client_sql .= "    t_client.client_cname,\n";
$client_sql .= "    t_area.area_name,\n";
$client_sql .= "    t_client.tel,\n";
//$client_sql .= "    t_client.state,\n";
$client_sql .= "    t_staff.staff_name,\n";
$client_sql .= "    t_staff.charge_cd,\n";
//$client_sql .= "    t_staff.staff_cd1 || '-' ||t_staff.staff_cd2,\n";
//$client_sql .= "    t_client.type, \n";
$client_sql .= "    t_client.client_name2, \n";
//$client_sql .= "    t_client.address1, \n";
//$client_sql .= "    t_client.address2, \n";
//$client_sql .= "    t_client.address3, \n";
$client_sql .= "    CASE ";
$client_sql .= "        WHEN t_con_state.client_id IS NOT NULL THEN '�����' ";
$client_sql .= "        ELSE '�ٻ���' ";
$client_sql .= "    END AS state, ";
$client_sql .= "    t_staff2.staff_id AS staff2_id, \n";
$client_sql .= "    t_staff2.charge_cd AS staff2_charge_cd, \n";
$client_sql .= "    t_staff2.staff_name AS staff2_name, \n";
$client_sql .= "    t_trust_client.client_id AS trust_client_id, \n";
$client_sql .= "    t_trust_client.client_cd1 AS trust_client_cd1, \n";
$client_sql .= "    t_trust_client.client_cd2 AS trust_client_cd2, \n";
$client_sql .= "    t_trust_client.client_name AS trust_client_name, \n";
$client_sql .= "    t_area.area_cd \n";

$client_sql .= "FROM \n";
$client_sql .= "    t_contract\n";

//������ޥ��������
$client_sql .= "        INNER JOIN\n";
$client_sql .= "    t_client\n";
$client_sql .= "    ON t_client.client_id = t_contract.client_id\n ";
$client_sql .= "        INNER JOIN \n";

//�϶������
$client_sql .= "    t_area\n";
$client_sql .= "    ON t_client.area_id = t_area.area_id";

//����ô���������
$client_sql .= "        LEFT JOIN\n";
$client_sql .= "    t_staff\n";
$client_sql .= "    ON t_client.c_staff_id1 = t_staff.staff_id \n ";

//���ô���������
$client_sql .= "        LEFT JOIN \n";
$client_sql .= "    t_con_staff\n";
$client_sql .= "    ON t_contract.contract_id = t_con_staff.contract_id\n";
$client_sql .= "        LEFT JOIN \n";
$client_sql .= "    t_staff AS t_staff2\n";
$client_sql .= "    ON t_con_staff.staff_id = t_staff2.staff_id \n";

//����������
$client_sql .= "        LEFT JOIN \n";
$client_sql .= "    t_client AS t_trust_client ";
$client_sql .= "    ON t_contract.trust_id = t_trust_client.client_id ";

// ������������
$client_sql .= "        LEFT JOIN \n";
$client_sql .= "    (SELECT \n";
$client_sql .= "        client_id ";
$client_sql .= "    FROM ";
$client_sql .= "        t_contract ";
$client_sql .= "    WHERE ";
$client_sql .= "        state = '1' ";
$client_sql .= "    ) AS t_con_state ";
$client_sql .= "    ON t_client.client_id = t_con_state.client_id ";


$client_sql .= " WHERE\n";
$client_sql .= "     t_client.shop_id = $shop_id\n";
$client_sql .= "     AND\n";
$client_sql .= "     t_client.client_div = 1\n";
$client_sql .= "     AND\n";
$client_sql .= "     t_client.area_id = t_area.area_id \n";

// �������
if ($state == "�����"){
    $client_sql .= " AND t_con_state.client_id IS NOT NULL \n";
}else
if ($state == "�ٻ���"){
    $client_sql .= " AND t_con_state.client_id IS NULL \n";
}else
if ($state == "����"){
    $cleint_sql .= null;
}else
if ($state == null){
    $client_sql .= " AND t_con_state.client_id IS NOT NULL \n";
}
    
/*
if (($_POST["form_button"]["show_button"] != "ɽ����")){
    $client_sql .= "AND \n";
    $client_sql .= "    t_con_state.client_id IS NOT NULL \n";
}
*/

//ɽ����
//CSV�ξ��ϡַ���NO.�סֹԡפΥ����Ȥ��դ��ä���
if($output_type == '2'){
	$csv_order = ",t_contract.line,t_con_info.line ";
}else{
	$csv_order = ",t_staff2.charge_cd, t_trust_client.client_cd1, t_trust_client.client_cd2 ";
}
/*
if($turn == '1'){
    $turn_sql = " ORDER BY t_client.client_cd1,t_client.client_cd2 $csv_order ASC\n";
}else if($turn == '2'){
    $turn_sql = " ORDER BY t_client.client_name $csv_order ASC\n";
}else{
    $turn_sql = " ORDER BY t_staff.charge_cd, t_client.client_cd1, t_client.client_cd2 $csv_order ASC\n";
}
*/
switch ($sort_col){
    case "sl_client_cd":
        $turn_sql = " ORDER BY t_client.client_cd1,t_client.client_cd2 $csv_order ASC\n";
        break;
    case "sl_client_name":
        $turn_sql = " ORDER BY t_client.client_name $csv_order ASC\n";
        break;
    case "sl_area":
        $turn_sql = " ORDER BY t_area.area_cd, t_client.client_cd1, t_client.client_cd2 $csv_order ASC\n";
        break;
    case "sl_staff_cd":
        $turn_sql = " ORDER BY t_staff.charge_cd, t_client.client_cd1, t_client.client_cd2 $csv_order ASC\n";
        break;
}


if($show_page == '1'){
//    $limit = " LIMIT 100 OFFSET $offset";
}

//���������
if($output_type != '2'){
    
    //�������
    $client_sql .= $where_sql.$turn_sql;
    $total_count_sql = $client_sql.";";
    $result = Db_Query($conn, $total_count_sql);
    $page_data = Make_Show_Data($result);
    $t_count = count($page_data); 

    //�ڡ���ʬ����Ԥʤ�
    $page_data = Make_Page_Data($page_data, $show_page, $offset);
    $match_count = count($page_data);

/*
    $sql = $client_sql.$limit.";";
    $result = Db_Query($conn, $sql);
    $match_count = pg_num_rows($result);
    
    $page_data = Make_Show_Data($result);
    $match_count = count($page_data); 
*/
//CSV���Ͻ���
}else if($output_type == 2){

	//ľ�Ĥ���Դ�Ϣ�ι��ܤ����
	if($_SESSION["group_kind"] == '2'){
		$act_column ="
            t_trust_client.client_cd1||'-'||t_trust_client.client_cd2 AS trust_cd,
            t_trust_client.shop_name AS trust_name,
			CASE t_contract.contract_div
				WHEN '1' THEN '�̾�'
				WHEN '2' THEN '����饤�����'
				WHEN '3' THEN '���ե饤�����'
			END,
--			t_contract.act_request_rate || '%',
            CASE t_contract.act_div
                WHEN '2' THEN CAST(act_request_price AS varchar)
            END,
            CASE t_contract.act_div
                WHEN '3' THEN t_contract.act_request_rate || '%'
            END,
			t_contract.trust_ahead_note ,
			t_contract.trust_note       ,
--			CASE t_contract.request_state
--				WHEN '1' THEN '������'
--				WHEN '2' THEN '������'
--			END,
            CASE
                WHEN contract_div IN ('2','3') THEN 
                                                CASE t_contract.request_state
                                				    WHEN '1' THEN '������'
				                                    WHEN '2' THEN '������'
                                                END
            END,

		";
	}

	$sql = "
	SELECT 
	t_client.client_cd1 || '-' || t_client.client_cd2 ,
	t_contract.line             ,
	t_con_info.line               ,
	t_client.client_name,
	t_client.client_name2,
	t_client.client_cname,
	--t_contract.sale_amount      ,
	--t_contract.trade_amount     ,
	--t_con_staff.trade_amount     ,
    CASE t_contract.state 
        WHEN '1' THEN '�����'
        WHEN '2' THEN '���󡦵ٻ���'
    END AS state,
	lpad(t_contract.route, 4, '0'),
	round_div AS ����ʬ,
	CASE     
	    WHEN round_div = '1' AND (abcd_week=1 OR abcd_week=2 OR abcd_week=3 OR abcd_week=4 ) THEN '4' || '��'
	    WHEN round_div = '1' AND (abcd_week=21 OR abcd_week=22 OR abcd_week=23 OR abcd_week=24 ) THEN '8' || '��'
	    WHEN round_div = '1' AND (abcd_week=5 OR abcd_week=6)  THEN '2' || '��'
	    WHEN round_div = '2' THEN '1' || '����'
	    WHEN round_div = '3' THEN '1' || '����'
	    WHEN round_div = '4' THEN cycle || '��'
	    WHEN round_div = '5' THEN cycle || '����'
	    WHEN round_div = '6' THEN cycle || '����'
	END AS ����,
	
	CASE
	    WHEN round_div = '1' AND (abcd_week=1 OR abcd_week=21) THEN 'A��'
	    WHEN round_div = '1' AND (abcd_week=2 OR abcd_week=22) THEN 'B��'
	    WHEN round_div = '1' AND (abcd_week=3 OR abcd_week=23) THEN 'C��'
	    WHEN round_div = '1' AND (abcd_week=4 OR abcd_week=24) THEN 'D��'
	    WHEN round_div = '1' AND (abcd_week=5) THEN 'AC��'
	    WHEN round_div = '1' AND (abcd_week=6) THEN 'BD��'
	    WHEN round_div = '3' THEN '��' || cale_week || '��'
	END AS ����ʬ,
	
	CASE t_contract.round_div        
	    WHEN '2' THEN rday ||'��'  
	    WHEN '5' THEN rday ||'��'  
	    WHEN '7' THEN '��§��'  
	END AS ������,
	
	CASE t_contract.week_rday        
	    WHEN '1' THEN '����'
	    WHEN '2' THEN '����'
	    WHEN '3' THEN '����'
	    WHEN '4' THEN '����'
	    WHEN '5' THEN '����'
	    WHEN '6' THEN '����'
	    WHEN '7' THEN '����'
	END AS ��������,
	t_contract.last_day         ,
	t_staff.staff_name,
	t_con_staff1.staff_name,
	t_con_staff1.sale_rate,
	t_con_staff2.staff_name,
	t_con_staff2.sale_rate,
	t_con_staff3.staff_name,
	t_con_staff3.sale_rate,
	t_con_staff4.staff_name,
	t_con_staff4.sale_rate,
	
	--t_contract.round_div        ,
	--t_contract.cycle            ,
	--t_contract.cycle_unit       ,
	--t_contract.rday             ,
	--t_contract.week_rday        ,
	--t_contract.shop_id          ,
	--t_contract.act_request_day  ,
	--t_contract.act_trust_day    ,
	--t_contract.trust_id         ,
	$act_column
	
	--t_contract.act_goods_id     ,
	--t_contract.trust_line       ,
	--t_contract.intro_ac_price   ,
	--t_contract.intro_ac_rate    ,
	--t_contract.claim_id         ,
	--t_contract.claim_div        ,
	--t_contract.state            ,
	--t_contract.intro            ,
	t_contract.enter_day        ,
	t_contract.contract_day     ,
	t_contract.stand_day        ,
	t_contract.update_day       ,
	t_contract.contract_eday    ,
	
	----------------------------------------------
	--t_con_info.con_info_id        ,
	--t_con_info.contract_id        ,
    --2011-06-23 aoyama-n
	CASE t_con_info.divide
		WHEN '01' THEN '��ԡ���'
		WHEN '02' THEN '����'
		WHEN '03' THEN '��󥿥�'
		WHEN '04' THEN '�꡼��'
		WHEN '05' THEN '����'
		WHEN '06' THEN '����¾'
		--WHEN '05' THEN '��'
		--WHEN '06' THEN '����'
		--WHEN '07' THEN '����¾'
	END,
	--t_con_info.serv_id            ,
	t_serv.serv_cd,
	t_serv.serv_name,
	CASE t_con_info.serv_pflg
		WHEN 't' THEN '����'
		ELSE '���ʤ�'
	END,
	--t_con_info.goods_id           ,
	t_goods.goods_cd          ,
	t_con_info.official_goods_name         ,
	t_con_info.goods_name         ,
	CASE t_con_info.goods_pflg
		WHEN 't' THEN '����'
		ELSE '���ʤ�'
	END,
	t_con_info.num                ,
	CASE t_con_info.set_flg
		WHEN 't' THEN '��'
		ELSE ''
	END,
	t_con_info.trade_price        ,
	t_con_info.trade_amount       ,
	t_con_info.sale_price         ,
	t_con_info.sale_amount        ,
	--t_con_info.egoods_id          ,
	t_egoods.goods_cd          ,
	t_con_info.egoods_name        ,
	t_con_info.egoods_num         ,
	--t_con_info.rgoods_id          ,
	t_rgoods.goods_cd          ,
	t_con_info.rgoods_name        ,
	t_con_info.rgoods_num         ,
	t_con_info.account_price      ,
	CASE t_con_info.account_rate
		WHEN NULL THEN ''
		WHEN '' THEN ''
		ELSE t_con_info.account_rate || '%'
	END,
	--t_con_info.trust_trade_price  ,
	--t_con_info.trust_trade_amount 
    CASE t_con_info.advance_flg 
        WHEN '2' THEN advance_offset_amount
    END AS advance_total,
--	t_contract.note
-- 2009/06/19 ����No.35 �ɲ�
	t_contract.note,
	CASE t_con_info.mst_sync_flg
		WHEN 't' THEN '��'
		ELSE ''
	END
-- -----------------
	---------------------------------------
	FROM t_contract
	INNER JOIN t_con_info ON t_contract.contract_id = t_con_info.contract_id
	INNER JOIN t_client ON t_client.client_id = t_contract.client_id
    LEFT JOIN t_client AS t_trust_client ON t_contract.trust_id = t_trust_client.client_id 

-- �ʲ�����ɬ�פʤ�
--        LEFT JOIN
--    (SELECT
--        (client_id)
--    FROM
--        t_contract
--    WHERE
--        state = '1'
--    ) AS t_con_state 
--    ON t_client.client_id = t_con_state.client_id 
	INNER JOIN t_area ON t_client.area_id = t_area.area_id
	LEFT JOIN t_staff ON t_client.c_staff_id1 = t_staff.staff_id 
	LEFT JOIN t_goods AS t_goods ON t_con_info.goods_id = t_goods.goods_id
	LEFT JOIN t_goods AS t_rgoods ON t_con_info.rgoods_id = t_rgoods.goods_id
	LEFT JOIN t_goods AS t_egoods ON t_con_info.egoods_id = t_egoods.goods_id
	LEFT JOIN t_serv  ON t_con_info.serv_id = t_serv.serv_id
	LEFT JOIN 
		(
			SELECT t_con_staff.contract_id, t_con_staff.staff_id, staff_name, sale_rate 
			FROM t_con_staff 
			INNER JOIN t_staff ON t_con_staff.staff_id = t_staff.staff_id 
			WHERE t_con_staff.staff_div='0'
		) AS t_con_staff1
		ON t_contract.contract_id = t_con_staff1.contract_id
	
	LEFT JOIN 
		(
			SELECT t_con_staff.contract_id, t_con_staff.staff_id, staff_name, sale_rate 
			FROM t_con_staff 
			INNER JOIN t_staff ON t_con_staff.staff_id = t_staff.staff_id 
			WHERE t_con_staff.staff_div='1'
		) AS t_con_staff2
		ON t_contract.contract_id = t_con_staff2.contract_id
	
	LEFT JOIN 
		(
			SELECT t_con_staff.contract_id, t_con_staff.staff_id, staff_name, sale_rate 
			FROM t_con_staff 
			INNER JOIN t_staff ON t_con_staff.staff_id = t_staff.staff_id 
			WHERE t_con_staff.staff_div='2'
		) AS t_con_staff3
		ON t_contract.contract_id = t_con_staff3.contract_id
	
	LEFT JOIN 
		(
			SELECT t_con_staff.contract_id, t_con_staff.staff_id, staff_name, sale_rate 
			FROM t_con_staff 
			INNER JOIN t_staff ON t_con_staff.staff_id = t_staff.staff_id 
			WHERE t_con_staff.staff_div='3'
		) AS t_con_staff4
		ON t_contract.contract_id = t_con_staff4.contract_id
	WHERE t_contract.shop_id = $shop_id
	$where_sql
    ";
    // �������
/*
    if ($state == "�����"){
        $sql .= " AND t_contract.state = '' \n";
        $sql .= " AND t_con_state.client_id IS NOT NULL \n";
    }else
    if ($state == "�ٻ���"){
        $sql .= " AND t_con_state.client_id IS NULL \n";
    }else
    if ($state == "����"){
        $sql .= null;
    }else
    if ($state == null){
        $sql .= " AND t_con_state.client_id IS NOT NULL \n";
    }
*/
    if ($state == "�����"){
        $sql .= " AND t_contract.state = '1' \n";

    } elseif ($state == "�ٻ���"){
        $sql .= " AND t_contract.state = '2' \n";
    }


    $sql .= "
	$turn_sql
	;
	";

	$result      = Db_Query($conn, $sql);
    $i = 0;
	while($csv_page_data[] = pg_fetch_row($result));

    //�������
    //$client_sql .= $where_sql.$turn_sql;
    //$sql = $client_sql.";";
/*
    $count_res = Db_Query($conn, $sql);
    $match_count = pg_num_rows($count_res);    
    $page_data = Get_Data($count_res, $output_type);

    //CSV����
    $result = Db_Query($conn, $sql);
        for($i = 0; $i < $match_count; $i++){
            $csv_page_data[$i][0] = $page_data[$i][1]."-".$page_data[$i][2];
            $csv_page_data[$i][1] = $page_data[$i][3];
            $csv_page_data[$i][2] = $page_data[$i][12];
            $csv_page_data[$i][3] = $page_data[$i][4];
            $csv_page_data[$i][4] = $page_data[$i][5];
            $csv_page_data[$i][5] = $page_data[$i][13];
            $csv_page_data[$i][6] = $page_data[$i][14];
            $csv_page_data[$i][7] = $page_data[$i][15];
            $csv_page_data[$i][8] = $page_data[$i][6];
            if($page_data[$i][7] == 1){
                $page_data[$i][7] = "�����";
            }else{
                $page_data[$i][7] = "�ٻ���";
            }
            $csv_page_data[$i][9] = $page_data[$i][7];

        }
*/
	$csv_file_name = "����ޥ���".date("Ymd").".csv";

	//------------------
	//CSV�إå�����
	//------------------
	$csv_header_1 = array(
	"�����襳����",
	"����No.",
	"��",
	"������̾1",
	"������̾2",
	"ά��",
	"�������",
	"��ϩ",
	"����ʬ",
	"����",
	"����ʬ",
	"������",
	"��������",
	"��§�ǽ���",
	"����ô����",
	"���ô����1",
	"���Ψ1",
	"���ô����2",
	"���Ψ2",
	"���ô����3",
	"���Ψ3",
	"���ô����4",
	"���Ψ4",
	);

	$csv_header_2 = array(
	"�����襳����",
	"������̾",
	"��Զ�ʬ",
	"��԰�����(�����)",
	"��԰�����(���Ψ)",
	"��������͡��������",
	"��������͡ʼ��������",
	"��Ծ���",
	);

	$csv_header_3 = array(
	"�����Ͽ��",
	"��Ͽ��",
	"����ȯ����",
	"����ȯ����",
	"����λ��",
	"�����ʬ",
	"�����ӥ�������",
	"�����ӥ�̾",
	"�����ӥ�����",
	"�����ƥॳ����",
	"�����ƥ�̾��������",
	"�����ƥ�̾��ά�Ρ�",
	"�����ƥ����",
	"�����ƥ��",
	"�켰",
	"�Ķȸ���",
	"������׳�",
	"���ñ��",
	"����׳�",
	"�����ʥ�����",
	"������̾",
	"�����ʿ�",
	"���ξ��ʥ�����",
	"���ξ���̾",
	"���ξ��ʿ�",
	"�Ҳ���³�",
	"�Ҳ����Ψ",
    "�����껦��",
	"����",
	"��Ʊ��",//--2009/06/19 ����No.35 �ɲ�
	);

	//ľ�Ĥ���Դ�Ϣ�ι��ܤ����
	if($_SESSION["group_kind"] == '2'){
		$csv_header = array_merge($csv_header_1, $csv_header_2,$csv_header_3);

	//FC�ξ��
	}else{
		$csv_header = array_merge($csv_header_1, $csv_header_3);
	}
	
	
	$csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
	//$csv_file_name = time().".csv";
	$csv_data = Make_Csv($csv_page_data, $csv_header);
	Header("Content-disposition: attachment; filename=$csv_file_name");
	Header("Content-type: application/octet-stream; name=$csv_file_name");
	print $csv_data;
	exit;
}

/*
//�ڡ���ʬ����󥯲���������
if(count($_POST) > 0 
    && $_POST["form_button"]["show_button"] != "ɽ����" 
    && $_POST["form_search_button"] != "�����ե������ɽ��"){

    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;
    if($show_page != '2'){
        $limit = " LIMIT 100 OFFSET $offset";
    }
    $sql = $client_sql.$limit.";";
}


//ɽ���ǡ�������������
if ($_POST["form_button"]["show_button"] == "ɽ����" || $_POST["form_search_button"] == "�����ե������ɽ��"){

    for($i = 0; $i < $match_count; $i++){
    //ô���ԥ����ɤ����ä���硢�ϥ��ե��Ĥ���
        if($page_data[$i][8] != null){
            $page_data[$i][8] = $page_data[$i][8]."-";
        }
        $shop_state[$i][0] = 'f'.$page_data[$i][0];
        $shop_state[$i][1] = $page_data[$i][0];
    }
    $form->setConstants($update_data);
}

//�ڡ���ʬ����󥯲�������
if(count($_POST) > 0 
    && $_POST["form_button"]["show_button"] != "ɽ����"  
    && $_POST["form_search_button"] != "�����ե������ɽ��"){
    $page_count  = $_POST["f_page1"];
    
    $offset = $page_count * 100 - 100;
    if($show_page != '2'){
        $limit = " LIMIT 100 OFFSET $offset";
    }

    $sql = $client_sql.$limit.";";
    $result = Db_Query($conn, $sql);
//  $t_count = pg_num_rows($result);
}

$result = Db_Query($conn, $sql);
$match_count = pg_num_rows($result);

//���֤Ǹ������������ѹ��ˤ�äƥڡ����������Ѥ����
if($match_count == 0){
    if($_POST["f_page1"] == 2){
        //�ڡ����������ڡ����ˤʤ���
        $offset = 0;
        $page_count  = 0;
    }else{
        //�ڡ����������ڡ����ʾ�ξ��
        $page_count  = $_POST["f_page1"]-1;
        $offset = $page_count * 100 - 100;
    }
    if($show_page != '2'){
        $limit = " LIMIT 100 OFFSET $offset";
    }
    $sql = $client_sql.$limit.";";
    $page_change = true;
}
$result = Db_Query($conn, $sql);

$match_count = pg_num_rows($result);
$page_data = Get_Data($result, '1');


for($i = 0; $i < $match_count; $i++){
    //�����襳���ɤ˥ϥ��ե���ղ�
    $page_data[$i][1] = $page_data[$i][1]."-";

	if($page_data[$i][9] != NULL){
    $page_data[$i][9] = str_pad ($page_data[$i][9],4, "0", STR_PAD_LEFT);
  }
}
$form->setConstants($update1_data);
*/


#2010-05-12 hashimoto-y
$display_flg = true;
}


/****************************/
//�ǡ��������ؿ�
/****************************/
function Make_Show_Data($result){

    $page_data = pg_fetch_all($result);

    //�ǡ������ʤ����
    if(!is_array($page_data)){
        return;
    }

    $line = -1;
    $row  = 0 ; //�ԣΣ

    foreach($page_data AS $key => $var){

        //�����褬�Ѥ�ä����
        if($client_id != $var["client_id"]){

            $client_id = $var["client_id"];

            $line++;

            $make_data[$line]["client_id"]          = $var["client_id"];
            $make_data[$line]["client_cd1"]         = $var["client_cd1"];
            $make_data[$line]["client_cd2"]         = $var["client_cd2"];
            $make_data[$line]["client_name"]        = htmlspecialchars($var["client_name"]);
            $make_data[$line]["client_cname"]       = htmlspecialchars($var["client_cname"]);
            $make_data[$line]["area_name"]          = htmlspecialchars($var["area_name"]);
            $make_data[$line]["tel"]                = $var["tel"];
            if($var["charge_cd"] != null){
                $make_data[$line]["charge_cd"]      = str_pad($var["charge_cd"], 4, "0", STR_PAD_LEFT) ;
            }

            $make_data[$line]["staff_name"]         = htmlspecialchars($var["staff_name"]);
            $make_data[$line]["state"]              = $var["state"];

            //���ô���Ԥ�������
            if($var["staff2_id"] != null){
                $make_data[$line]["staff_id"][]     = $var["staff2_id"];
                $make_data[$line]["staff2"]         = str_pad($var["staff2_charge_cd"], 4, "0", STR_PAD_LEFT);
                $make_data[$line]["staff2"]        .= "<br>".htmlspecialchars($var["staff2_name"]);
            }

            //����褬������
            if($var["trust_client_id"] != null){
                $make_data[$line]["trust_id"][]     = $var["trust_client_id"];
                $make_data[$line]["trust"]          = $var["trust_client_cd1"];
                $make_data[$line]["trust"]         .= "-".$var["trust_client_cd2"];
                $make_data[$line]["trust"]         .= "<br>".htmlspecialchars($var["trust_client_name"]);
            }

        //Ʊ��������Υǡ����ξ��
        }else{
            //���ô��
            if($var["staff2_id"] == null){
            }elseif(count($make_data[$line]["staff_id"]) == 0){
                $make_data[$line]["staff_id"][]     = $var["staff2_id"];
                $make_data[$line]["staff2"]         = str_pad($var["staff2_charge_cd"], 4, "0", STR_PAD_LEFT);
                $make_data[$line]["staff2"]        .= "<br>".htmlspecialchars($var["staff2_name"]);
            }elseif(!in_array($var["staff_id"], $make_data[$line]["staff_id"])){
                $make_data[$line]["staff_id"][]     = $var["staff2_id"];
                $make_data[$line]["staff2"]        .= "<br>".str_pad($var["staff2_charge_cd"], 4, "0", STR_PAD_LEFT);
                $make_data[$line]["staff2"]        .= "<br>".htmlspecialchars($var["staff2_name"]);
            }

            //���
            if($var["trust_client_id"] == null){
            }elseif(count($make_data[$line]["trust_id"]) == 0){
                $make_data[$line]["trust_id"][]     = $var["trust_client_id"];
                $make_data[$line]["trust"]          = $var["trust_client_cd1"];
                $make_data[$line]["trust"]         .= "-".$var["trust_client_cd2"];
                $make_data[$line]["trust"]         .= "<br>".htmlspecialchars($var["trust_client_name"]);
            }elseif(!in_array($var["trust_client_id"], $make_data[$line]["trust_id"])){
                $make_data[$line]["trust_id"][]     = $var["trust_client_id"];
                $make_data[$line]["trust"]         .= "<br>".$var["trust_client_cd1"];
                $make_data[$line]["trust"]         .= "-".$var["trust_client_cd2"];
                $make_data[$line]["trust"]         .= "<br>".htmlspecialchars($var["trust_client_name"]);
            }
        }
    }

    return $make_data;
}


//�ڡ������ȤΥǡ�����Ż���ؿ�
function Make_Page_Data($make_data, $show_page, $offset=0){

    //100��ɽ���ǤϤʤ����
    if($show_page != '1'){
        return $make_data;
    }
    for($i = $offset, $j=0; $i < $offset+100; $i++, $j++){

        if(!is_array($make_data[$i])){
            break;
        }

        $page_data[$j] = $make_data[$i];
    }

    return $page_data;
}

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
$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[input_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
//ɽ���ϰϻ���
$range = "100";

$html_page = Html_Page($t_count,$page_count,1,$range);
$html_page2 = Html_Page($t_count,$page_count,2,$range);

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
    'match_count'   => "$match_count",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'page_change'   => "$page_change",
    'display_flg'   => "$display_flg",
    
));
$smarty->assign('row',$page_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
