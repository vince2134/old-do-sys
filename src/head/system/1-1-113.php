<?php
/******************************
*�ѹ�����
*   ��2006/05/08��
*       �����ե�����ɽ���ܥ����ɲá�watanabe-k��
*       ɽ���ǡ�����������̾����ά�Τ��ѹ���watanabe-k��
*
*   ��2006/07/07��
*       �����ˤɤ������褫��FC̾���ɲá�kaji��
*
*   ��2006/08/11��
*       ��ʬ��ȼ�ޥ����Ȥη���LEFT JOIN�˽���(hashimoto)
*******************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-05      ban_0004     suzuki     �϶�Υե������ץ�����󤫤�ƥ����Ȥ��ѹ�
 *  2006-12-07      ban_0096     suzuki     ɽ���ܥ��󲡲����˹�NO�����
 *  2006-12-07      ban_0095     suzuki     �ǡ�����з���､��
 *  2007-01-24      �����ѹ�     watanabe-k �ܥ���ο��ѹ�
 *  2007-01-24      �����ѹ�     watanabe-k �إå��Υܥ�����
 *  2007-02-22                   watanabe-k ���׵�ǽ�κ��
 *  2007-05-16                   kaku-m     �ե����ࡦ�������ܤ��ɲäȺ����CSV�ν�����
 *  2010-05-13      Rev.1.5     hashimoto-y ���ɽ���˸������ܤ���ɽ�����뽤��
*/

$page_title = "������ޥ���";

//environment setting file �Ķ�����ե�����
require_once("ENV_local.php");

//create HTML_QuickForm HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null, "onSubmit=return confirm(true)");

// register templace function �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//connect to Database DB����³
$conn = Db_Connect();

// authorization check ���¥����å�
$auth       = Auth_Check($conn);

/****************************/
//acquire outside variable �����ѿ�����
/****************************/
$shop_id = $_SESSION[client_id];

/****************************/
//set default value�ǥե����������
/****************************/
$def_fdata = array(
    "form_output_type"  => "1",
    "form_show_page"    => "1",
//    "form_display_num"  => "1",
//    "form_client_gr"    => "",
//    "form_parents_div"  => "3",
    "form_shop"         => array("cd1"=> "","cd2"=>""),
    "form_client"       => array("cd1" => "", "cd2" => ""),
//    "form_area_id"      => "",
    "form_tel"          => "",
//    "form_c_staff"      => "",
    "form_btype"        => "",
    "form_rank"         => "",
    "form_state_type"   => "1",
    "form_state_type_s"   => "1",
//    "form_trade"        => "",
);
// restore search condition �����������
//Restore_Filter2($form, "contract", "show_button", $def_fdata);
$form->setDefaults($def_fdata);

/****************************/
//HTML���᡼������������ component for creating HTML image 
/****************************/
//�ܥ��� button
//�ѹ������� edit��list
//$form->addElement("button", "new_button", "��Ͽ����", "onClick=\"javascript:Referer('1-1-115.php')\"");

//��Ͽ(�إå�) register (header)
//$form->addElement("button", "change_button", "�ѹ�������", $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//output format ���Ϸ���
$radio1[] =& $form->createElement("radio", null, null, "����", "1");
$radio1[] =& $form->createElement("radio", null, null, "CSV", "2");
$form->addGroup($radio1, "form_output_type", "���Ϸ���");

//customer code �����襳����
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" $g_form_option ");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($text, "form_client", "form_client");

//shop code ����åץ�����
Addelement_Client_64($form, "form_shop", "����åץ�����", " - ");
//����å�̾
$form->addElement("text", "form_shop_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//FC��customer classification FC���������ʬ
$select_value = Select_Get($conn, "rank");
$form->addElement("select", "form_rank", "FC��������ʬ", $select_value, $g_form_option_select);



//industry �ȼ�
$sql  = "SELECT t_lbtype.lbtype_cd, t_lbtype.lbtype_name, t_sbtype.sbtype_id, t_sbtype.sbtype_cd, t_sbtype.sbtype_name ";
$sql .= "FROM   t_lbtype ";
$sql .= "       INNER JOIN t_sbtype ";
$sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id ";
$sql .= "ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd ";
$sql .= ";";
$result = Db_Query($conn, $sql);
while($data_list = pg_fetch_array($result)){
    $max_len = ($max_len < mb_strwidth($data_list[1])) ? mb_strwidth($data_list[1]) : $max_len;
}
$result = Db_Query($conn, $sql);
$select_value = null;
$select_value[null] = null;
while($data_list = pg_fetch_array($result)){
    for($i = 0; $i< $max_len; $i++){
        $data_list[1] = (mb_strwidth($data_list[1]) <= $max_len && $i != 0) ? $data_list[1]."��" : $data_list[1];
    }
    $select_value[$data_list[2]] = $data_list[0]." �� ".$data_list[1]."���� ".$data_list[3]." �� ".$data_list[4];
}
$form->addElement('select', 'form_btype',"", $select_value, $g_form_option_select);


//customer name ������̾
$form->addElement("text", "form_client_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//TEL
$form->addElement("text", "form_tel", "", "size=\"15\" maxLength=\"13\" style=\"$g_form_style\" $g_form_option");

//map �϶�
/*
$select_value = "";
$select_value = Select_Get($conn, "h_area");
$form->addElement("select", 'form_area_id', "", $select_value);
*/
$form->addElement("text", "form_area_id", "", "size=\"25\" maxLength=\"10\" $g_form_option");


//condition (customer) ���֡��������
$radio2[] =& $form->createElement("radio", null, null, "�����", "1");
$radio2[] =& $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
//$radio2[] =& $form->createElement("radio", null, null, "����", "3");
$radio2[] =& $form->createElement("radio", null, null, "����", "4");
$form->addGroup($radio2, "form_state_type", "����");


//condition (shop) ���֡ʥ���åס�
$radios[] =& $form->createElement("radio", null, null, "�����", "1");
$radios[] =& $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
//$radio2[] =& $form->createElement("radio", null, null, "����", "3");
$radios[] =& $form->createElement("radio", null, null, "����", "4");
$form->addGroup($radios, "form_state_type_s", "����");




//type/classification ����
//$form_type[] =& $form->createElement("radio", null, null, "��ԡ���", "1");
//$form_type[] =& $form->createElement("radio", null, null, "��ԡ��ȳ�", "2");
//$form_type[] =& $form->createElement("radio", null, null, "����", "3");
//$form->addGroup($form_type, "form_type", "����");

//page separation �ڡ���ʬ��
$radio4[] =& $form->createElement("radio", null, null, "100��ɽ��", "1");
$radio4[] =& $form->createElement("radio", null, null, "����ɽ��", "2");
$form->addGroup($radio4, "form_show_page", "ɽ������");

//button �ܥ���
$button[] = $form->createElement("submit", "show_button", "ɽ����");
$button[] = $form->createElement("button", "clear_button", "���ꥢ", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addGroup($button, "form_button", "�ܥ���");

//sort link �����ȥ��
$ary_sort_item = array(
    "sl_rank"           => "FC��������ʬ",
    "sl_shop_cd"        => "����åץ�����",
    "sl_shop_name"      => "����å�̾",
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    //"sl_area"           => "�϶�", 
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_shop_cd");

//hidden
$form->addElement("hidden", "hdn_output_type", "", "");
$form->addElement("hidden", "hdn_client_cd1", "", "");
$form->addElement("hidden", "hdn_client_cd2", "", "");
$form->addElement("hidden", "hdn_client_name", "", "");
$form->addElement("hidden", "hdn_btype", "", "");
$form->addElement("hidden", "hdn_rank", "", "");
$form->addElement("hidden", "hdn_area_id", "", "");
$form->addElement("hidden", "hdn_tel", "", "");
$form->addElement("hidden", "hdn_shop_cd1","","");
$form->addElement("hidden", "hdn_shop_cd2","","");
$form->addElement("hidden", "hdn_shop_name", "", "");
$form->addElement("hidden", "hdn_show_page", "", "");
//$form->addElement("hidden", "hdn_type");            //type ����
$form->addElement("hidden", "hdn_state");           //condition ����
$form->addElement("hidden", "hdn_state_s");           //condition ����

/****************************/
//��������� acquire all items 
/****************************/
$count_sql  = " SELECT COUNT(client_id) FROM t_client WHERE t_client.client_div = '1';";

//�إå�����ɽ������������� all items that will be displayed in the header
$total_count_sql = $count_sql;
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res, 0, 0);


/****************************/
//POST
/****************************/
if($_POST["form_button"]["show_button"] == "ɽ����"){
    $output_type    = $_POST["form_output_type"];           //���Ϸ��� output format
    $client_cd1     = trim($_POST["form_client"]["cd1"]);   //�����襳����1 customer code 1
    $client_cd2     = trim($_POST["form_client"]["cd2"]);   //�����襳����2 customer code 2
    $client_name    = trim($_POST["form_client_name"]);     //������̾ customer name 
    $btype          = $_POST["form_btype"];                 // �ȼ� industry
    $rank           = $_POST["form_rank"];
    $area_id        = $_POST["form_area_id"];               //�϶�ID district ID
    $state          = $_POST["form_state_type"];            //���� condition 
    $state_s          = $_POST["form_state_type_s"];            //���� condition 
    $tel            = $_POST["form_tel"];                   //TEL
    $shop_cd1       = trim($_POST["form_shop"]["cd1"]);
    $shop_cd2       = trim($_POST["form_shop"]["cd2"]);
    $shop_name      = trim($_POST["form_shop_name"]);             //����å�̾ shop name
    $show_page      = $_POST["form_show_page"];
    $post_flg       = true;                                 //POST�ե饰 POST flag

    $sort_col       = $_POST["hdn_sort_col"];

    $offset = 0;

}elseif(count($_POST) > 0
    && $_POST["form_button"]["show_button"] != "ɽ����"){
    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;

    $output_type    = $_POST["hdn_output_type"];
    $client_cd1     = $_POST["hdn_client_cd1"];
    $client_cd2     = $_POST["hdn_client_cd2"];
    $btype          = $_POST["hdn_btype"];
    $rank           = $_POST["hdn_rank"];
    $client_name    = $_POST["hdn_client_name"];
    $area_id        = $_POST["hdn_area_id"];
    $state          = $_POST["hdn_state"];
    $state_s          = $_POST["hdn_state_s"];
    $tel            = $_POST["hdn_tel"];
    $shop_cd1       = $_POST["hdn_shop_cd1"];
    $shop_cd2       = $_POST["hdn_shop_cd2"];
    $shop_name      = $_POST["hdn_shop_name"];
    $show_page      = $_POST["hdn_show_page"];
    $post_flg       = true;

    $sort_col       = $_POST["hdn_sort_col"];


}else{
    $output_type    = '1';
    $state          = '1';
    $state_s        = '1';
    $show_page      = '1';
    $btype          = '0';
    $rank           = '0';
    $offset         = 0;

    $sort_col       = "sl_shop_cd";
}


/*****************************/
//������糧�å� set search condition
/*****************************/

$set_data["form_output_type"]       = stripslashes($output_type);
$set_data["form_client"]["cd1"]     = stripslashes($client_cd1);
$set_data["form_client"]["cd2"]     = stripslashes($client_cd2);
$set_data["form_client_name"]       = stripslashes($client_name);
$set_data["form_btype"]             = stripslashes($btype);
$set_data["form_rank"]              = stripslashes($rank);
$set_data["form_area_id"]           = stripslashes($area_id);
$set_data["form_state_type"]        = stripslashes($state);
$set_data["form_state_type_s"]      = stripslashes($state_s);
$set_data["form_tel"]               = stripslashes($tel);
$set_data["form_shop"]["cd1"]       = stripslashes($shop_cd1);
$set_data["form_shop"]["cd2"]       = stripslashes($shop_cd2);
$set_data["form_shop_name"]         = stripslashes($shop_name);
$set_data["form_show_page"]         = stripslashes($show_page);
$set_data["hdn_output_type"]        = stripslashes($output_type);
$set_data["hdn_client_cd1"]         = stripslashes($client_cd1);
$set_data["hdn_client_cd2"]         = stripslashes($client_cd2);
$set_data["hdn_client_name"]        = stripslashes($client_name);
$set_data["hdn_btype"]              = stripslashes($btype);
$set_data["hdn_rank"]              = stripslashes($rank);
$set_data["hdn_shop_cd1"]           = stripslashes($shop_cd1);
$set_data["hdn_shop_cd2"]           = stripslashes($shop_cd2);
$set_data["hdn_shop_name"]          = stripslashes($shop_name);
$set_data["hdn_area_id"]            = stripslashes($area_id);
$set_data["hdn_state"]              = stripslashes($state);
$set_data["hdn_state_s"]              = stripslashes($state_s);
$set_data["hdn_tel"]                = stripslashes($tel);
$set_data["hdn_show_page"]          = stripslashes($show_page);
//$set_data["hdn_type"]               = stripslashes($type);      //type ����

$form->setConstants($set_data);
if($post_flg == true){

    /****************************/
    //where_sql���� create where_sql
    /****************************/
    if($post_flg == true){
        //����å�̾ shop name
        $where_sql .= ($shop_name != null) ? " AND (fc.client_name LIKE '%$shop_name%' OR fc.client_cname LIKE '%$shop_name%' OR fc.client_name2 LIKE '%$shop_name%')" : null;
        //�����襳����1 customer code 1
        $where_sql .= ($client_cd1 != null) ? " AND t_client.client_cd1 LIKE '$client_cd1%' " : null;
        //�����襳����2 customer code 2
        $where_sql .= ($client_cd2 != null) ? " AND t_client.client_cd2 LIKE '$client_cd2%' " : null;
        //������̾��ά�� customer name��abbreviation
        $where_sql .= ($client_name != null) ? " AND (t_client.client_name LIKE '%$client_name%' OR t_client.client_cname LIKE '%$client_name%' OR t_client.client_name2 LIKE '%$client_name%') " : null;

        //����åץ����ɣ� shop code 1 
        $where_sql .= ($shop_cd1 != null)? " AND fc.client_cd1 LIKE '$shop_cd1%'":null;
        //����åץ����ɣ� shop code 2
        $where_sql .= ($shop_cd2 != null)? " AND fc.client_cd2 LIKE '$shop_cd2%'":null;
        
/*        //����å�̾ shop name
        if($shop_name != null){
            $where_sql .= "AND (";
            $where_sql .= "     fc.client_name LIKE '$shop_name%'";
            $where_sql .= "     OR fc.client_name2 LIKE '$shop_name%'";
            $where_sql .= "     OR fc.client_cname LIKE '$shop_name%'";
            $where_sql .= ") ";
        }
*/


        //�ȼ� industry
        $where_sql .= ($btype != 0) ? " AND t_sbtype.sbtype_id = $btype " : null;

        //FC��������ʬ FC��transacting client classification
        $where_sql .= ($rank != 0) ? " AND fc.rank_cd = '$rank' " : null;

        //�϶� district
        //$where_sql .= $area_id_sql      = ($area_id != 0) ? " AND t_area.area_id = $area_id " : null;
        $where_sql .= ($area_id != NULL) ? " AND t_area.area_name LIKE '%$area_id%' " : null;
        //TEL
        $where_sql .= ($tel != null) ? " AND t_client.tel LIKE '$tel%' " : null;
        //���� type
//        $where_sql .= ($type != '3') ? " AND t_client.type = '$type' " : null;
    }
}

/****************************/
//ɽ���ǡ������� create display data
/****************************/

#2010-05-13 hashimoto-y
if($post_flg == true){


/****************************/
//��������� acquire all items
/****************************/
$sql  = " SELECT";
$sql .= "     t_client.client_id,";                     // 0 customer ID ������ID
$sql .= "     t_client.client_cd1,";                    // 1 customer code 1 �����襳���ɣ�
$sql .= "     t_client.client_cd2,";                    // 2 customer code 2 �����襳���ɣ�
$sql .= "     t_client.client_name,";                   // 3 customer name ������̾
$sql .= "     t_client.client_cname,";                  // 4 customer name (abbreviation) ������̾��ά�Ρ�
$sql .= "     t_area.area_name,";                       // 5 district name �϶�̾
$sql .= "     t_client.tel,";                           // 6 TEL
$sql .= "     t_client.state,";                         // 7 condition ����
$sql .= "     t_client.type,";                          // 8 type ����
$sql .= "     fc.client_name AS fc_name, ";             // 9 shop name ����å�̾
$sql .= "     t_client_claim.client_name AS claim_name, ";// 10 invoicing client ������
$sql .= "     t_sbtype.sbtype_id, ";                    // 11 industry ID �ȼ�ID
$sql .= "     fc.client_cd1, ";                         // 12 shop code1 ����åץ����ɣ�
$sql .= "     fc.client_cd2, ";                         // 13 shop code2 ����åץ����ɣ�
$sql .= "     t_client_claim.client_cd1,";              // 14 invoicing client 1 code 1�����裱�����ɣ�
$sql .= "     t_client_claim.client_cd2,";              // 15 invoicing client 1 code 2�����裱�����ɣ�
$sql .= "     t_client_claim2.client_cd1,";             // 16 invoicing vlient 2 code 1�����裲�����ɣ�
$sql .= "     t_client_claim2.client_cd2,";             // 17 invoicing client 2 code 2�����裲�����ɣ�
$sql .= "     t_client_claim2.client_name, ";           // 18 invoicing client 2 �����裲
$sql .= "     fc.state, ";                              // 19 condition (shop) ���֡ʥ���åס�
$sql .= "     t_rank.rank_name ";                       // 20 FC��transacting client classification FC��������ʬ
if($output_type == 2){
$sql .= "   ,";
$sql .= "   t_lbtype.lbtype_name ||' '||t_sbtype.sbtype_name,";// 21  industry name �ȼ�̾
$sql .= "   t_inst.inst_name,";                         // 22  facility name ����̾
$sql .= "   t_bstruct.bstruct_name,";                   // 23  business type name ����̾
$sql .= "   t_client.client_read,";                     // 24  customer name 1 (phonetic in katakana) ������̾���ʥեꥬ�ʡ�
$sql .= "   t_client.client_name2,";                    // 25  customer name 2 ������̾��
$sql .= "   t_client.client_read2,";                    // 26  customer name 2 (phonetic in katakana) ������̾���ʥեꥬ�ʡ�
$sql .= "   t_client.client_cread,";                    // 27  abbreviation (phonetic in katakan) ά�Ρʥեꥬ�ʡ�
$sql .= "   CASE t_client.compellation \n";
$sql .= "       WHEN '1' THEN '����'\n";
$sql .= "       ELSE '��'\n";
$sql .= "   END \n";
$sql .= "   AS compellation, \n";                       // 28  honorific �ɾ�
$sql .= "   t_client.rep_name, \n";                     // 29  representative name ��ɽ�Ի�̾
$sql .= "   t_client.represe, \n";                      // 30  representative position ��ɽ����
$sql .= "   t_client.post_no1, \n";                     // 31  postal code 1͹���ֹ棱
$sql .= "   t_client.post_no2, \n";                     // 32  psotal code 2͹���ֹ棲
$sql .= "   t_client.address1, \n";                     // 33  address 1 ���꣱
$sql .= "   t_client.address2, \n";                     // 34  address 2 ���ꣲ
$sql .= "   t_client.address3, \n";                     // 35  address 3 ���ꣳ
$sql .= "   t_client.address_read, \n";                 // 36  address (phonetic in katakana) ����ʥեꥬ�ʡ�
$sql .= "   t_client.fax, \n";                          // 37  FAX
$sql .= "   t_client.establish_day, \n";                // 38  establishment date �϶���
$sql .= "   t_client.email, \n";                        // 39  assigned staff email ô����EMAIL
$sql .= "   t_client.company_name, \n";                 // 40  parent company name �Ʋ��̾
$sql .= "   t_client.company_tel, \n";                  // 41  parent company TEL �Ʋ��TEL
$sql .= "   t_client.company_address, \n";              // 42  parent company address �Ʋ�ҽ���
$sql .= "   t_client.capital, \n";                      // 43  capital ���ܶ�
$sql .= "   t_client.parent_establish_day, \n";         // 44  parent company establishment date �Ʋ���϶���
$sql .= "   t_client.parent_rep_name, \n";              // 45  parent company representative name �Ʋ����ɽ�Ի�̾
$sql .= "   t_client.url, \n";                          // 46  URL
$sql .= "   t_client.charger_part1, \n";                // 47  assigned staff department 1ô������
$sql .= "   t_client.charger_part2, \n";                // 48  assigned staff department 2ô������
$sql .= "   t_client.charger_part3, \n";                // 49  assigned staff department 3ô������
$sql .= "   t_client.charger_represe1, \n";             // 50  assigned staff position 1ô���򿦣�
$sql .= "   t_client.charger_represe2, \n";             // 51  assigned staff position 2ô���򿦣�
$sql .= "   t_client.charger_represe3, \n";             // 52  assigned staff position 3ô���򿦣�
$sql .= "   t_client.charger1, \n";                     // 53  assigned staff name 1ô���Ի�̾��
$sql .= "   t_client.charger2, \n";                     // 54  assigned staff name 2ô���Ի�̾��
$sql .= "   t_client.charger3, \n";                     // 55  assigned staff name 3ô���Ի�̾��
$sql .= "   t_client.charger_note, \n";                 // 56  assigned staff remark ô��������
$sql .= "   t_client.trade_stime1, \n";                 // 57  operating hour (morning starting time) �ĶȻ��֡ʸ������ϡ�
$sql .= "   t_client.trade_etime1, \n";                 // 58  operating hour (morning ending time) �ĶȻ��֡ʸ�����λ��
$sql .= "   t_client.trade_stime2, \n";                 // 59  operating hour (afternoon starting time) �ĶȻ��֡ʸ�峫�ϡ�
$sql .= "   t_client.trade_etime2, \n";                 // 60  operating hour (afternoon ending time) �ĶȻ��֡ʸ�彪λ��
$sql .= "   t_client.holiday, \n";                      // 61  holiday ����
$sql .= "   t_client.holiday, \n";                      // 62  holiday ����
$sql .= "   t_client.credit_limit, \n";                 // 63  credit limit Ϳ������
$sql .= "   t_client.col_terms, \n";                    // 64  collection condition������
$sql .= "   t_trade.trade_name, \n";                    // 65  transaction classification �����ʬ
$sql .= "   CASE t_client.close_day \n";
$sql .= "       WHEN '29' THEN '����' \n";
$sql .= "       ELSE t_client.close_day || '��'\n";
$sql .= "   END AS close_day, \n";                      // 66  closing date ����
$sql .= "   CASE t_client.pay_m \n";
$sql .= "       WHEN '0' THEN '����' \n";
$sql .= "       WHEN '1' THEN '���' \n";
$sql .= "       ELSE t_client.pay_m || '�����' \n";
$sql .= "   END AS pay_m, \n";                          // 67  collection date (month) �������ʷ��
$sql .= "   CASE t_client.pay_d \n";
$sql .= "       WHEN '29' THEN '����' \n";
$sql .= "       ELSE t_client.pay_d || '��' \n";
$sql .= "   END AS pay_d, \n";                          // 68  collection date (day) ������������
$sql .= "   CASE t_client.pay_way \n";
$sql .= "       WHEN '1' THEN '��ư����' \n";
$sql .= "       WHEN '2' THEN '����' \n";
$sql .= "       WHEN '3' THEN 'ˬ�佸��' \n";
$sql .= "       WHEN '4' THEN '���' \n";
$sql .= "       WHEN '5' THEN '����¾' \n";
$sql .= "   END AS pay_way, \n";                        // 69  collection money method ������ˡ
$sql .= "   CASE \n";
$sql .= "       WHEN t_client.account_id IS NOT NULL \n";
$sql .= "       THEN t_bank.bank_name || '��' || t_b_bank.b_bank_name || '��' ||     
                CASE t_account.deposit_kind  WHEN '1' THEN '���� '     
                    WHEN '2' THEN '���� ' END || t_account.account_no";
$sql .= "       ELSE '' \n";
$sql .= "   END \n";
$sql .= "   AS pay_bank, \n";                           // 70  transfer money bank account ������Ը���
$sql .= "   t_client.pay_name, \n";                     // 71  client name 1 whom money will be transferred ����̾����
$sql .= "   t_client.account_name, \n";                 // 72  client name 2 whom money will be transferred ����̾����
$sql .= "   CASE t_client.bank_div ";
$sql .= "       WHEN '1' THEN '��������ô' \n";
$sql .= "       WHEN '2' THEN '������ô' \n";
$sql .= "   END AS bank_div, \n";                       // 73  bank transaction fee shoulder classification ��Լ������ô��ʬ
$sql .= "   t_client.cont_sday, \n";                    // 74  contracted date ����ǯ����
$sql .= "   t_client.cont_rday, \n";                    // 75  contract updating date ���󹹿���
$sql .= "   t_client.cont_eday, \n";                    // 76  contract ending date ����λ��
$sql .= "   t_client.cont_peri, \n";                    // 77  contract period �������
$sql .= "   CASE t_client.slip_out \n";
$sql .= "       WHEN '1' THEN 'ͭ' \n";
$sql .= "       WHEN '2' THEN '����' \n";
$sql .= "       WHEN '3' THEN '̵' \n";
$sql .= "   END AS slip_out, \n";                       // 78  issue slip ��ɼȯ��
$sql .= "   t_slip_sheet.s_pattern_name, \n";           // 79  sales slip issue �����ɼȯ�Ը�
$sql .= "   CASE t_client.deliver_effect \n";
$sql .= "       WHEN '1' THEN '������̵��' \n";
$sql .= "       WHEN '2' THEN '���̥�����ͭ��' \n";
$sql .= "       ELSE '���Υ�����ͭ��' \n";
$sql .= "   END AS deliver_effect, \n";                 // 80  sales slip comment effect �����ɼ�����ȸ���
$sql .= "   CASE t_client.claim_out \n";
$sql .= "       WHEN '1' THEN '���������' \n";
$sql .= "       WHEN '2' THEN '��������' \n";
$sql .= "       WHEN '3' THEN '���Ϥ��ʤ�' \n";
$sql .= "       ELSE '����' \n";
$sql .= "   END AS claim_out, \n";                      // 81  issue invoice �����ȯ��
$sql .= "   CASE t_client.claim_send \n";
$sql .= "       WHEN '1' THEN '͹��' \n";
$sql .= "       WHEN '2' THEN '�᡼��' \n";
$sql .= "       WHEN '4' THEN 'WEB' \n";
$sql .= "       ELSE '͹�����᡼��' \n";
$sql .= "   END AS claim_send, \n";                     // 82  send invoice ���������
$sql .= "   t_claim_sheet.c_pattern_name, \n";          // 83  origin of the issued invoice �����ȯ�Ը�
$sql .= "   t_client.claim_note, \n";                   // 84  invoice remarks ���������
$sql .= "   CASE t_client.coax \n";
$sql .= "       WHEN '1' THEN '�ڼ�' \n";
$sql .= "       WHEN '2' THEN '�ͼθ���' \n";
$sql .= "       ELSE '�ھ�' \n";
$sql .= "   END AS claim_note, \n";                     // 85  amount: round off decimals��۴ݤ��ʬ
$sql .= "   CASE t_client.tax_div \n";
$sql .= "       WHEN '2' THEN '��ɼñ��' \n";
$sql .= "       ELSE '����ñ��' \n";
$sql .= "   END AS tax_div, \n";                        // 86  consumption tax: taxation unit �����ǡ�����ñ��
$sql .= "   CASE t_client.tax_franct \n";
$sql .= "       WHEN '1' THEN '�ڼ�' \n";
$sql .= "       WHEN '2' THEN '�ͼθ���' \n";
$sql .= "       ELSE '�ھ�' \n";
$sql .= "   END AS tax_franct, \n";                     // 87  consumption tax: fraction classification �����ǡ�ü����ʬ
$sql .= "   CASE t_client.c_tax_div \n";
$sql .= "       WHEN '1' THEN '����' \n";
$sql .= "       ELSE '����' \n";
$sql .= "   END AS tax_div, \n";                        // 88  consumption tax: tax classification �����ǡ����Ƕ�ʬ
$sql .= "   t_client.note, \n";                         // 89  equipment information��others ����������������¾
$sql .= "   t_branch.branch_name, \n";                  // 90  assigned branch ô����Ź
$sql .= "   t_staff1.staff_name, \n";                   // 91  currenc contract assigned staff ������ô��
$sql .= "   t_staff2.staff_name, \n";                   // 92  employee name �������Ұ�
$sql .= "   t_client.round_day, \n";                    // 93  patrol start date ��󳫻���
$sql .= "   t_client.deal_history, \n";                 // 94  transaction history �������
$sql .= "   t_client.importance, \n";                   // 95  important matter ���׻���
$sql .= "   t_client.parents_flg,\n";                   // 96 parent-child flag �ƻҥե饰
$sql .= "   t_client_gr.client_gr_name,";               // 97 group name ���롼��̾
$sql .= "   t_client.deliver_note, ";                   // 98 sales slip comment �����ɼ������
$sql .= "   t_intro_ac.client_cd1,  \n";                // 99 bank account inquiry code 1 �Ȳ���¥�����1
$sql .= "   t_intro_ac.client_name, \n";                // 100 introduced bank account name �Ҳ����̾
$sql .= "   t_client.intro_ac_name, \n";                // 101 bank account name for payment ���������̾
$sql .= "   t_client.intro_bank, \n";                   // 102 bank/branch ���/��Ź̾
$sql .= "   t_client.intro_ac_num,\n";                  // 103 account number �����ֹ�
$sql .= "   t_intro_ac.client_cd2,";                    // 104 bank account inquiry code 2 �Ȳ���¥����ɣ�
$sql .= "   t_intro_ac.client_div, ";                    // 105 transaction classification of bank account inquiry �Ȳ���¤μ����ʬ

$sql .= "   CASE t_claim.month1_flg \n";         // 106 create january invoice1����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month2_flg \n";         // 107 create Feb invoice2����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month3_flg \n";         // 108 create March invoice3����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month4_flg \n";         // 109 create april invoice4����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month5_flg \n";         // 110 create May invoice5����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month6_flg \n";         // 111 create june invoice6����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month7_flg \n";         // 112 create july  invoice7����������    
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month8_flg \n";         // 113 create august invoice8����������    
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month9_flg \n";         // 114 create sept invoice9����������    
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month10_flg \n";        // 115 create oct invoice10����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month11_flg \n";        // 116 create Nov invoice11����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month12_flg \n";        // 117 create Dec invoice12����������
$sql .= "       WHEN 't' THEN '��' \n";
$sql .= "       WHEN 'f' THEN '��' \n";
$sql .= "   END  ";

}


$sql .= " FROM";
$sql .= "   t_client ";
$sql .= "   INNER JOIN t_claim ";
$sql .= "       ON t_client.client_id = t_claim.client_id AND t_claim.claim_div='1'";
$sql .= "   INNER JOIN t_client AS t_client_claim ";
$sql .= "       ON t_claim.claim_id = t_client_claim.client_id ";
$sql .= "   INNER JOIN t_sbtype ";
$sql .= "       ON t_client.sbtype_id = t_sbtype.sbtype_id ";
$sql .= "   INNER JOIN t_area ";
$sql .= "       ON t_client.area_id = t_area.area_id  ";
$sql .= "   INNER JOIN t_client AS fc";
$sql .= "       ON t_client.shop_id = fc.client_id AND (fc.client_div = '0' OR fc.client_div = '3')";
$sql .= "   INNER JOIN t_rank ";
$sql .= "       ON t_rank.rank_cd = fc.rank_cd ";
$sql .= "   LEFT JOIN t_claim AS t_claim2 ";
$sql .= "       ON t_client.client_id = t_claim2.client_id AND t_claim2.claim_div='2' ";
$sql .= "   LEFT JOIN t_client AS t_client_claim2 ";
$sql .= "       ON t_claim2.claim_id = t_client_claim2.client_id ";
if($output_type==2){
$sql .= "   LEFT JOIN t_inst ";
$sql .= "       ON t_inst.inst_id = t_client.inst_id";
$sql .= "   LEFT JOIN t_bstruct \n";
$sql .= "       ON t_bstruct.bstruct_id = t_client.b_struct \n";
$sql .= "   LEFT JOIN t_trade \n";
$sql .= "       ON t_trade.trade_id = t_client.trade_id \n";
$sql .= "   LEFT JOIN t_account \n";
$sql .= "       ON t_account.account_id = t_client.account_id \n";
$sql .= "   LEFT JOIN t_b_bank \n";
$sql .= "       ON t_b_bank.b_bank_id = t_account.b_bank_id \n";
$sql .= "   LEFT JOIN t_bank \n";
$sql .= "       ON t_bank.bank_id = t_b_bank.bank_id \n";
$sql .= "   LEFT JOIN t_slip_sheet \n";
$sql .= "       ON t_client.s_pattern_id = t_slip_sheet.s_pattern_id \n";
$sql .= "   LEFT JOIN t_claim_sheet \n";
$sql .= "       ON t_client.c_pattern_id = t_claim_sheet.c_pattern_id \n";
$sql .= "   LEFT JOIN t_branch \n";
$sql .= "       ON t_client.charge_branch_id = t_branch.branch_id \n";
$sql .= "   LEFT JOIN t_staff AS t_staff1 \n";
$sql .= "       ON t_staff1.staff_id = t_client.c_staff_id1 \n";
$sql .= "   LEFT JOIN t_staff AS t_staff2 \n";
$sql .= "       ON t_staff2.staff_id = t_client.c_staff_id2 \n";
$sql .= "   LEFT JOIN t_client_gr ";
$sql .= "       ON t_client_gr.client_gr_id = t_client.client_gr_id \n";
$sql .= "   INNER JOIN t_client_info \n";
$sql .= "   ON t_client.client_id = t_client_info.client_id \n";
$sql .= "   LEFT JOIN t_client AS t_intro_ac \n";
$sql .= "   ON t_client_info.intro_account_id = t_intro_ac.client_id \n";
$sql .= "   LEFT JOIN t_lbtype \n";
$sql .= "   ON t_lbtype.lbtype_id = t_sbtype.lbtype_id \n";
}
$sql .= " WHERE ";
$sql .= "     t_client.client_div = '1' ";

//condition ����
$sql .= ($state != null && $state != 4) ? " AND t_client.state = $state " : null;
$sql .= ($state_s != null && $state_s != 4) ? " AND fc.state = $state_s " : null;

//ɽ���� display order
// ����å�̾�Ǿ���� shop name ascending order
if ($sort_col == "sl_shop_name"){
    $order_sql = " ORDER BY fc.client_name, t_client.client_cd1, t_client.client_cd2 ASC ";
// �����襳���ɤǾ���� client code ascending order
}elseif ($sort_col == "sl_client_cd"){
    $order_sql = " ORDER BY t_client.client_cd1, t_client.client_cd2 ASC ";
// ������̾�Ǿ���� customer name ascending order
}elseif ($sort_col == "sl_client_name"){
    $order_sql = " ORDER BY t_client.client_name, t_client.client_cd1, t_client.client_cd2 ASC ";
// �϶�Ǿ���� district ascending order
}elseif ($sort_col == "sl_area"){
    $order_sql = " ORDER BY t_area.area_name, t_client.client_cd1, t_client.client_cd2 ASC ";
// ����åץ����� shop code 
}elseif ($sort_col == "sl_shop_cd"){
    $order_sql = " ORDER BY fc.client_cd1, fc.client_cd2,t_client.client_cd1,t_client.client_cd2 ASC ";
// FC��������ʬ FC��transacting client classification
}elseif ($sort_col == "sl_rank"){
    $order_sql = " ORDER BY fc.rank_cd, fc.client_cd1, fc.client_cd2 ,t_client.client_cd1, t_client.client_cd2 ASC ";
// �ǥե���Ȥ������襳���ɤǾ��� by default sort with customer code in ascending order
}else{
    $order_sql = "ORDER BY t_client.client_cd1,t_client.client_cd2 ASC ";
}

//��������� when a scren is selected
if($output_type == 1 || $output_type==""){

    $limit = ($show_page != '2') ? " LIMIT 100 OFFSET $offset " : null;

    //������� matched items
    $sql .= $where_sql.$state_sql.$order_sql;
    $total_count_sql = $sql.";";
    $result = Db_Query($conn, $total_count_sql);
    $t_count = pg_num_rows($result);

    //ɽ����� displaying items
    switch($show_page){
        case "1":
            $range = "100";
            break;
        case "2":
            $range = $t_count;
            break;
    }




    $sql = $sql.$limit.";";
    $count_res = Db_Query($conn, $sql);
    $match_count = pg_num_rows($count_res);
        
    $page_data = Get_Data($count_res, $output_type);
    for($i = 0; $i< $match_count; $i++){
        for($j = 0; $j < $match_count; $j++){
            if($i != $j && $page_data[$i][0] == $page_data[$j][0]){
                $page_data[$j][0] = null;
            }
        }
    }

    for($i = 0; $i < $t_count; $i++){
        if($page_data[$i][0] == null){
            $tr[$i] = $tr[$i-1];
        }else{  
            $tr[$i] = ($tr[$i-1] == "Result1") ? "Result2" : "Result1";
        }
    }
}else if($output_type == 2){

    //������� matched items
    $sql    .= $where_sql.$state_sql.$order_sql;
    $sql            = $sql.";";
    $count_res      = Db_Query($conn, $sql);
    $match_count    = pg_num_rows($count_res);    
    $page_data      = Get_Data($count_res, $output_type);
    //CSV���� creat csv
    for($i = 0; $i < $match_count; $i++){
//print "<br>$i".$page_data[$i][96];
        $csv_page_data[$i][0] = ($page_data[$i][19] == "1") ? "�����" : "���󡦵ٻ���"; //����å� ���� shop status
        $csv_page_data[$i][1] = $page_data[$i][12]."-".$page_data[$i][13];  //����åץ����� shop code
        $csv_page_data[$i][2] = $page_data[$i][9];  //����å�̾ shop name
        $csv_page_data[$i][3] = ($page_data[$i][7] == "1") ? "�����" : "���󡦵ٻ���"; //������ ���� customer status
        $csv_page_data[$i][4] = $page_data[$i][97]; //���롼��̾ group name
        $csv_page_data[$i][5] = (($page_data[$i][96] == 't')? "��":(($page_data[$i][96] == 'f')?"��":"��Ω"));    //�ƻҶ�ʬ parent-child classification
        $csv_page_data[$i][6] = $page_data[$i][5];      //�϶� district
        $csv_page_data[$i][7] = $page_data[$i][21];     //�ȼ� industry
        $csv_page_data[$i][8] = $page_data[$i][22];     //���� facility
        $csv_page_data[$i][9] = $page_data[$i][23];     //���� business type
        $csv_page_data[$i][10] = $page_data[$i][1]."-".$page_data[$i][2];   //�����襳���� customer code
        $csv_page_data[$i][11] = $page_data[$i][3];     //������̾�� customer name 1
        $csv_page_data[$i][12] = $page_data[$i][25];    //������̾�� customer name 2
        $csv_page_data[$i][13] = $page_data[$i][24];    //������̾���ʥեꥬ�ʡ� customer name 1 (phonetic in katakana)
        $csv_page_data[$i][14] = $page_data[$i][26];    //������̾���ʥեꥬ�ʡ� customer name 2 (phonetic in katakana)
        $csv_page_data[$i][15] = $page_data[$i][4];     //ά�� abbreviation
        $csv_page_data[$i][16] = $page_data[$i][27];    //ά�Ρʥեꥬ�ʡ�abbreviation (phonetic in katakana)
        $csv_page_data[$i][17] = $page_data[$i][28];    //�ɾ� honorific
        $csv_page_data[$i][18] = $page_data[$i][29];    //��ɽ�Ի�̾ representative name
        $csv_page_data[$i][19] = $page_data[$i][30];    //��ɽ���� representative position
        $csv_page_data[$i][20] = $page_data[$i][31]."-".$page_data[$i][32]; //͹���ֹ棱 postal code 1
        $csv_page_data[$i][21] = $page_data[$i][33];    //���꣱ address 1
        $csv_page_data[$i][22] = $page_data[$i][34];    //���ꣲ address 2
        $csv_page_data[$i][23] = $page_data[$i][35];    //���ꣳ address 3
        $csv_page_data[$i][24] = $page_data[$i][36];    //����ʥեꥬ�ʡ�address (phonetic in katakana)
        $csv_page_data[$i][25] = $page_data[$i][6];     //TEL
        $csv_page_data[$i][26] = $page_data[$i][37];    //FAX
        $csv_page_data[$i][27] = $page_data[$i][38];    //�϶��� establishment date
        $csv_page_data[$i][28] = $page_data[$i][39];    //ô����EMAIL assigned staff email
        $csv_page_data[$i][29] = $page_data[$i][40];    //�Ʋ��̾  parent company name
        $csv_page_data[$i][30] = $page_data[$i][41];    //�Ʋ��TEL parent company TEL
        $csv_page_data[$i][31] = $page_data[$i][42];    //�Ʋ�ҽ��� parent company address
        $csv_page_data[$i][32] = $page_data[$i][43];    //���ܶ� capital
        $csv_page_data[$i][33] = $page_data[$i][44];    //�Ʋ���϶��� parent company establishment date
        $csv_page_data[$i][34] = $page_data[$i][45];    //�Ʋ����ɽ�Ի�̾ parent company representative name
        $csv_page_data[$i][35] = $page_data[$i][46];    //URL
        $csv_page_data[$i][36] = $page_data[$i][47];    //ô�������� assigned staff 1 department
        $csv_page_data[$i][37] = $page_data[$i][50];    //ô������ assigned staff 1 position
        $csv_page_data[$i][38] = $page_data[$i][53];    //ô������̾ assigned staff 1 name
        $csv_page_data[$i][39] = $page_data[$i][48];    //ô�������� assigned staff 2 department
        $csv_page_data[$i][40] = $page_data[$i][51];    //ô������ assigned staff 2 position 
        $csv_page_data[$i][41] = $page_data[$i][54];    //ô������̾ assigned staff 2 name
        $csv_page_data[$i][42] = $page_data[$i][49];    //ô�������� assigned staff 3 department
        $csv_page_data[$i][43] = $page_data[$i][52];    //ô������ assigned staff 3 position
        $csv_page_data[$i][44] = $page_data[$i][55];    //ô������̾assigned staff 3 name
        $csv_page_data[$i][45] = $page_data[$i][56];    //ô�������� assigned staff remark
        $csv_page_data[$i][46] = ($page_data[$i][57]!=null || $page_data[$i][58]!=null)?$page_data[$i][57]."��".$page_data[$i][58]:"";    //operating hour (morning)�ĶȻ��֡ʸ�����
        $csv_page_data[$i][47] =  ($page_data[$i][59]!=null || $page_data[$i][60]!=null)?$page_data[$i][59]."��".$page_data[$i][60]:"";    //operating hour (afternoon)�ĶȻ��֡ʸ���
        $csv_page_data[$i][48] = $page_data[$i][61];    //���� holiday
        $csv_page_data[$i][49] = $page_data[$i][14]."-".$page_data[$i][15]; //invoicing client 1 code�����裱������
        $csv_page_data[$i][50] = $page_data[$i][10];    //�����裱 invoicing client 1
        $csv_page_data[$i][51] = ($page_data[$i][16]!=null)?$page_data[$i][16]."-".$page_data[$i][17]:null; //�����裲������
        $csv_page_data[$i][52] = $page_data[$i][18];    //�����裲 invoicing client 2
        $csv_page_data[$i][53] = $page_data[$i][63];    //Ϳ������ credit limit
        $csv_page_data[$i][54] = $page_data[$i][64];    //������ collection condition
        $csv_page_data[$i][55] = $page_data[$i][65];    //�����ʬ transaction classification
        $csv_page_data[$i][56] = $page_data[$i][66];    //���� closing date
        $csv_page_data[$i][57] = $page_data[$i][67]."��".$page_data[$i][68];    //collection date ������
        $csv_page_data[$i][58] = $page_data[$i][69];    //������ˡ collection method
        $csv_page_data[$i][59] = $page_data[$i][70];    //������Ը��� bank account for payment
        $csv_page_data[$i][60] = $page_data[$i][71];    //����̾���� payment client name 1
        $csv_page_data[$i][61] = $page_data[$i][72];    //����̾���� payment client name 2
        $csv_page_data[$i][62] = $page_data[$i][73];    //��Լ������ô��ʬ bank transaction fee shoulder classification
        $csv_page_data[$i][63] = $page_data[$i][74];    //����ǯ���� contracted date
        $csv_page_data[$i][64] = $page_data[$i][75];    //���󹹿��� contract update date
        $csv_page_data[$i][65] = $page_data[$i][77];    //������� contract period
        $csv_page_data[$i][66] = $page_data[$i][76];    //����λ�� contract ending date
        $csv_page_data[$i][67] = $page_data[$i][78];    //��ɼȯ�� issue slip 
        $csv_page_data[$i][68] = $page_data[$i][79];    //�����ɼȯ�Ը� origin of issued sales slip 
        $csv_page_data[$i][69] = $page_data[$i][80];    //�����ɼ�����ȸ��� sales slip comment effect
        $csv_page_data[$i][70] = $page_data[$i][98];    //�����ɼ������ sales slip comment
        $csv_page_data[$i][71] = $page_data[$i][81];    //�����ȯ�� issue invoice
        $csv_page_data[$i][72] = $page_data[$i][82];    //��������� send invoice
        $csv_page_data[$i][73] = $page_data[$i][83];    //�����ȯ�Ը� origin of issued invoice
        $csv_page_data[$i][74] = $page_data[$i][84];    //��������� invoice remark
        $csv_page_data[$i][75] = $page_data[$i][85];    //��۴ݤ��ʬ amount decimal round off classification
        $csv_page_data[$i][76] = $page_data[$i][86];    //�����ǡ�����ñ�� consumption tax: taxation unit
        $csv_page_data[$i][77] = $page_data[$i][87];    //�����ǡ�ü����ʬ consumption tax: fraction classification
        $csv_page_data[$i][78] = $page_data[$i][88];    //�����ǡ����Ƕ�ʬ consumption tax: tax classification
        $csv_page_data[$i][79] = $page_data[$i][89];    //����������������¾ equipment information��others
        if($page_data[$i][105] == "3"){
            $page_data[$i][99] = $page_data[$i][99]."-".$page_data[$i][104];
        }
        $csv_page_data[$i][80] = $page_data[$i][99];    //���Ҳ���¥����� introduced bank account code
        $csv_page_data[$i][81] = $page_data[$i][100];   //���Ҳ����̾ introduced bank account name
        $csv_page_data[$i][82] = $page_data[$i][101];   //�����������̾  bank account name for money transfer
        $csv_page_data[$i][83] = $page_data[$i][102];   //���/��Ź̾ bank/branch name
        $csv_page_data[$i][84] = $page_data[$i][103];   //�����ֹ� bank account number 
        $csv_page_data[$i][85] = $page_data[$i][90];    //ô����Ź assigned branch
        $csv_page_data[$i][86] = $page_data[$i][91];    //������ô�� assigned staff for this contract 
        $csv_page_data[$i][87] = $page_data[$i][92];    //�������Ұ� employee name
        $csv_page_data[$i][88] = $page_data[$i][93];    //��󳫻��� patrol start date
        $csv_page_data[$i][89] = $page_data[$i][94];    //������� trade history
        $csv_page_data[$i][90] = $page_data[$i][95];    //���׻��� important matter

        //���������� invoice creation month
        $csv_page_data[$i][91] = $page_data[$i][106];
        $csv_page_data[$i][92] = $page_data[$i][107];
        $csv_page_data[$i][93] = $page_data[$i][108];
        $csv_page_data[$i][94] = $page_data[$i][109];
        $csv_page_data[$i][95] = $page_data[$i][110];
        $csv_page_data[$i][96] = $page_data[$i][111];
        $csv_page_data[$i][97] = $page_data[$i][112];
        $csv_page_data[$i][98] = $page_data[$i][113];
        $csv_page_data[$i][99] = $page_data[$i][114];
        $csv_page_data[$i][100] = $page_data[$i][115];
        $csv_page_data[$i][101] = $page_data[$i][116];
        $csv_page_data[$i][102] = $page_data[$i][117];
        


}
    $csv_file_name = "������ޥ���".date("Ymd").".csv";
    $csv_header = array(
        "����å� ����",
        "����åץ�����",
        "����å�̾",
        "������ ����",
        "���롼��̾",
        "�ƻҶ�ʬ",
        "�϶�",
        "�ȼ�",
        "����",
        "����",
        "�����襳����",
        "������̾��",
        "������̾��",
        "������̾���ʥեꥬ�ʡ�",
        "������̾���ʥեꥬ�ʡ�",
        "ά��",
        "ά�Ρʥեꥬ�ʡ�",
        "�ɾ�",
        "��ɽ�Ի�̾",
        "��ɽ����",
        "͹���ֹ�",
        "���꣱",
        "���ꣲ",
        "���ꣳ",
        "���ꣲ�ʥեꥬ�ʡ�",
        "TEL",
        "FAX",
        "�϶���",
        "ô����Email",
        "�Ʋ��̾",
        "�Ʋ��TEL",
        "�Ʋ�ҽ���",
        "���ܶ�",
        "�Ʋ���϶���",
        "�Ʋ����ɽ�Ի�̾",
        "URL",
        "ô��������",
        "ô������",
        "ô������̾",
        "ô��������",
        "ô������",
        "ô������̾",
        "ô��������",
        "ô������",
        "ô������̾",
        "ô��������",
        "�ĶȻ��֡ʸ�����",
        "�ĶȻ��֡ʸ���",
        "����",
        "�����裱�ʥ����ɡ�",
        "�����裱��̾����",
        "�����裲�ʥ����ɡ�",
        "�����裲��̾����",
        "Ϳ������",
        "������",
        "�����ʬ",
        "����",
        "������",
        "������ˡ",
        "������Ը���",
        "����̾����",
        "����̾����",
        "��Լ������ô��ʬ",
        "����ǯ����",
        "���󹹿���",
        "�������",
        "����λ��",
        "��ɼȯ��",
        "�����ɼȯ�Ը�",
        "�����ɼ�����ȸ���",
        "�����ɼ������",
        "�����ȯ��",
        "���������",
        "�����ȯ�Ը�",
        "���������",
        "��۴ݤ��ʬ",
        "�����ǡ�����ñ��",
        "�����ǡ�ü����ʬ",
        "�����ǡ����Ƕ�ʬ",
        "����������������¾",
        "���Ҳ���¥�����",
        "���Ҳ����̾",
        "�����������̾",
        "���/��Ź̾",
        "�����ֹ�",
        "ô����Ź",
        "������ô��",
        "�������Ұ�",
        "��󳫻���",
        "�������",
        "���׻���",
         "1������",
         "2������",
         "3������",
         "4������",
         "5������",
         "6������",
         "7������",
         "8������",
         "9������",
         "10������",
         "11������",
         "12������",
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}


//print_array($_POST);


/****************************/
//���֤��ִ����� replace the status/condition
/****************************/ 
if($state == "1"){
    $state_type = "�����";
}else
if ($state == "2" || $state == "3"){
    $state_type = "���󡦵ٻ���";
}else
if ($state == "4"){
    $state_type = "����";
}



#2010-05-13 hashimoto-y
$display_flg = true;
}


/****************************/
//HTML�إå� HTML header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� HTML footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå������� create screen header
/****************************/
$page_title .= "(��".$total_count."��)";
//$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
//$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//�ڡ������� create page
/****************************/
//ɽ���ϰϻ��� specify display range
//$range = "100";

$html_page = Html_Page($t_count,$page_count,1,$range);
$html_page2 = Html_Page($t_count,$page_count,2,$range);

// Render��Ϣ������ render related settings
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign form related variable
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assign other variable
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'match_count'   => "$match_count",
    'state_type'    => "$state_type",
    'display_flg'    => "$display_flg",
));
$smarty->assign('row',$page_data);
$smarty->assign('tr',$tr);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
