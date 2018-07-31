<?php
/***********************************/
//�ѹ�����
//  ��2006/03/15��
//  ������SQL�ѹ�
//����shop_id��client_id���ѹ�
//  (2006/05/08)
//  �������ե�����ɽ���ܥ�����ɲ�
//  (2006/07/06)
//  ��shop_gid��ʤ���(kaji)
/***********************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-05      ban_0007     suzuki     CSV���ϻ��˥��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  2007-05-09                   kaku-m     csv���Ϥι��ܤ��ɲ�
 *  2010-05-12      Rev.1.5      hashimoto-y ���ɽ���˸������ܤ���ɽ�����뽤��
 *
*/

$page_title = "������ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

/****************************/
//�����ѿ�����
/****************************/
$shop_id  = $_SESSION[client_id];
//$shop_gid = $_SESSION[shop_gid];

/****************************/
//�ǥե����������
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_state_type"     => "1",
    "form_turn"     => "1"
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
$form->addElement("text","form_client_cd","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\""." $g_form_option");

//������̾
$form->addElement("text","form_client_name","�ƥ����ȥե�����",'size="34" maxLength="15"'." $g_form_option");

//ά��
$form->addElement("text","form_client_cname","�ƥ����ȥե�����",'size="21" maxLength="10"'." $g_form_option");

//TEL
$form->addElement("text","form_tel","","size=\"15\" maxLength=\"13\" style=\"$g_form_style\""." $g_form_option");

//����
$radio2[] =& $form->createElement( "radio",NULL,NULL, "�����","1");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "���󡦵ٻ���","2");
//$radio2[] =& $form->createElement( "radio",NULL,NULL, "����","3");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "����","4");
$form->addGroup($radio2, "form_state_type", "����");

//�϶�
$select_value = Select_Get($conn, "area");
$form->addElement('select', 'form_area_id',"", $select_value);

//�ܥ���
$button[] = $form->createElement("submit","show_button","ɽ����");
$button[] = $form->createElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addGroup($button, "form_button", "�ܥ���");
$form->addElement("button","change_button","�ѹ�������",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","��Ͽ����","onClick=\"location.href='2-1-216.php'\"");
$form->addElement("submit","form_search_button","�����ե������ɽ��");

#2010-05-13 hashimoto-y
/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_button"]["show_button"] == "ɽ����"){
    $output_type    = $_POST["form_output_type"];           //���Ϸ���
    $client_cd      = trim($_POST["form_client_cd"]);       //�����襳����1
    $client_name    = trim($_POST["form_client_name"]);     //������̾
    $area_id       = $_POST["form_area_id"];               //�϶�
    $tel            = $_POST["form_tel"];                   //TEL
    $state          = $_POST["form_state_type"];            //����


    /****************************/
    //�ǡ����������
    /****************************/
    $client_sql  = "SELECT";
    $client_sql .= " t_client.client_id,";          // 0 ������ID
    $client_sql .= " t_client.client_cd1,";         // 1 �����襳���ɣ�
    $client_sql .= " t_client.client_name,";        // 2 ������̾
    $client_sql .= " t_area.area_name,";            // 3 �϶�
    $client_sql .= " t_client.tel,";                // 4 TEL
    $client_sql .= " t_client.state";               // 5 ����
    //����csvȽ���Ѥˡ�output_type����
    if($_POST["form_button"]["show_button"] == "ɽ����"){
    $output_type    = $_POST["form_output_type"];
    }
    //csv���ϻ�
    if($output_type == 2){
    $client_sql .= ", ";
    $client_sql .= "    t_sbtype.sbtype_name,";     // 6 �ȼ�̾
    $client_sql .= "    t_inst.inst_name,";         // 7 ����̾
    $client_sql .= "    t_bstruct.bstruct_name,";   // 8 ����̾
    $client_sql .= "    t_client.client_read,";     // 9 ������̾���եꥬ��
    $client_sql .= "    t_client.client_name2,";    // 10 ������̾��
    $client_sql .= "    t_client.client_read2,";    // 11 ������̾���եꥬ��
    $client_sql .= "    t_client.client_cname,";    // 12 ά��
    $client_sql .= "    t_client.client_cread,";    // 13 ά�Υեꥬ��
    $client_sql .= "    t_client.post_no1 || '-' || t_client.post_no2 ,";        // 14 ͹���ֹ�
    $client_sql .= "    t_client.address1,";        // 15 ���꣱
    $client_sql .= "    t_client.address2,";        // 16 ���ꣲ
    $client_sql .= "    t_client.address3,";        // 17 ���ꣳ
    $client_sql .= "    t_client.address_read,";    // 18 ���ꣲ�եꥬ��
    $client_sql .= "    t_client.capital,";         // 19 ���ܶ�
    $client_sql .= "    t_client.fax,";             // 20 FAX
    $client_sql .= "    t_client.email,";           // 21 Email
    $client_sql .= "    t_client.url,";             // 22 URL
    $client_sql .= "    t_client.rep_name,";        // 23 ��ɽ�Ի�̾
    $client_sql .= "    t_client.represe,";         // 24 ��ɽ����
    $client_sql .= "    t_client.rep_htel,";        // 25 ��ɽ�Է���
    $client_sql .= "    t_client.direct_tel,";      // 26 ľ��TEL
    $client_sql .= "    t_client.charger1,";        // 27 ���ô��
    $client_sql .= "    t_staff.staff_name,";       // 28 ����ô��
    $client_sql .= "    t_client.c_part_name,";     // 29 ����������
    $client_sql .= "    t_trade.trade_name,";       // 30 �������ʬ
    $client_sql .= "    CASE t_client.close_day ";  // 31 ����
    $client_sql .= "        WHEN '29' THEN '����' ";
    $client_sql .= "        ELSE t_client.close_day || '��' ";
    $client_sql .= "    END AS close_day,";
    $client_sql .= "    CASE t_client.payout_m ";   // 32 ��ʧ���ʷ��
    $client_sql .= "        WHEN '0' THEN '����' ";
    $client_sql .= "        WHEN '1' THEN '���' ";
    $client_sql .= "        ELSE t_client.payout_m || '�����' ";
    $client_sql .= "    END AS payout_m,";
    $client_sql .= "    CASE t_client.payout_d ";   // 33 ��ʧ��������
    $client_sql .= "        WHEN '29' THEN '����' ";
    $client_sql .= "        ELSE t_client.payout_d || '��' ";
    $client_sql .= "    END AS payout_d,";
    $client_sql .= "    t_client.col_terms,";       // 34 ��ʧ���
    $client_sql .= "    t_client.bank_name,";       // 35 ��������
    $client_sql .= "    t_client.b_bank_name,";     // 36 ��������ά��
    $client_sql .= "    t_client.holiday,";         // 37 ����
    $client_sql .= "    t_client.establish_day,";   // 38 �϶���
    $client_sql .= "    t_client.cont_sday,";       // 39 ���������
    $client_sql .= "    CASE t_client.coax ";       // 40 ��ۡ��ݤ��ʬ
    $client_sql .= "        WHEN '1' THEN '�ڼ�' ";
    $client_sql .= "        WHEN '2' THEN '�ͼθ���' ";
    $client_sql .= "        WHEN '3' THEN '�ھ�' ";
    $client_sql .= "    END AS coax, ";
    $client_sql .= "    CASE t_client.tax_div ";    // 41 ������:����ñ��
    $client_sql .= "        WHEN '1' THEN '����ñ��' ";
    $client_sql .= "        WHEN '2' THEN '��ɼñ��' ";
    $client_sql .= "    END AS tax_div,";
    $client_sql .= "    CASE t_client.tax_franct "; // 42 ������:ü����ʬ
    $client_sql .= "        WHEN '1' THEN '�ڼ�' ";
    $client_sql .= "        WHEN '2' THEN '�ͼθ���' ";
    $client_sql .= "        WHEN '3' THEN '�ھ�' ";
    $client_sql .= "    END AS tax_franct,";
    $client_sql .= "    CASE t_client.c_tax_div ";  // 43 ������:���Ƕ�ʬ
    $client_sql .= "        WHEN '1' THEN '����' ";
    $client_sql .= "        WHEN '2' THEN '����' ";
    $client_sql .= "    END AS c_tax_div,";
    $client_sql .= "    t_branch.branch_name,";     // 44 ô����Ź
    $client_sql .= "    t_client.deal_history,";    // 45 �������
    $client_sql .= "    t_client.importance, ";     // 46 ���׻���
    $client_sql .= "    t_client.note ";            // 47 ����
    }

    $client_sql .= " FROM";
    $client_sql .= " t_client";
    $client_sql .= "  LEFT JOIN";
    $client_sql .= " t_area ";
    $client_sql .= " ON t_client.area_id = t_area.area_id ";
    //csv���ϻ�
    if($output_type == 2){
    $client_sql .= " LEFT JOIN t_sbtype ";
    $client_sql .= "    ON t_sbtype.sbtype_id = t_client.sbtype_id ";
    $client_sql .= " LEFT JOIN t_inst ";
    $client_sql .= "    ON t_inst.inst_id = t_client.inst_id ";
    $client_sql .= " LEFT JOIN t_bstruct ";
    $client_sql .= "    ON t_bstruct.bstruct_id = t_client.b_struct ";
    $client_sql .= " LEFT JOIN t_staff ";
    $client_sql .= "    ON t_staff.staff_id = t_client.c_staff_id1 ";
    $client_sql .= " LEFT JOIN t_trade ";
    $client_sql .= "    ON t_trade.trade_id = t_client.trade_id ";
    $client_sql .= " LEFT JOIN t_branch ";
    $client_sql .= "    ON t_branch.branch_id = t_client.charge_branch_id ";
    }
    $client_sql .= " WHERE";
    //$client_sql .= "     t_client.shop_gid = $shop_gid";
    if($_SESSION[group_kind] == "2"){
        $client_sql .= "   t_client.shop_id IN (".Rank_Sql().") ";
    }else{
        $client_sql .= "   t_client.shop_id = $shop_id";
    }

    $client_sql .= "     AND";
    $client_sql .= "     t_client.client_div = 2 ";

    //�ǡ�����ɽ�������������
    $total_count_sql = $client_sql;
    $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
    $page_data = Get_Data($count_res);

    /****************************/
    //���������
    /****************************/
    $count_sql  = " SELECT";
    $count_sql .= "     COUNT(client_id)";
    $count_sql .= " FROM";
    $count_sql .= "     t_client";
    $count_sql .= " WHERE";
    //$count_sql .= "     t_client.shop_gid = $shop_gid";
    if($_SESSION[group_kind] == "2"){
        $count_sql .= "   t_client.shop_id IN (".Rank_Sql().") ";
    }else{
        $count_sql .= "   t_client.shop_id = $shop_id";
    }

    $count_sql .= "     AND";
    $count_sql .= "     t_client.client_div = '2'";
    $count_sql .= ";";

    //�إå�����ɽ�������������
    $count_res = Db_Query($conn, $count_sql);
    $total_count = pg_fetch_result($count_res,0,0);


    /****************************/
    //where_sql����
    /****************************/
        //�����襳����1
        if($client_cd != null){
            $client_cd_sql  = " AND t_client.client_cd1 LIKE '$client_cd%'";
        }
       
        //������̾
        if($client_name != null){
            $client_name_sql  = " AND t_client.client_name LIKE '%$client_name%'";
        }
        
        //ά��
        if($client_cname != null){
            $client_cname_sql  = " AND t_client.client_cname LIKE '%$client_cname%'";
        }
        
        //�϶�
        if($area_id != 0){
            $area_id_sql = " AND t_area.area_id = $area_id";
        }

        //TEL
        if($tel != null){
            $tel_sql  = " AND t_client.tel LIKE '$tel%'";
        }

        //����
        if($state != 4){
            $state_sql = " AND t_client.state = $state";
        }

        $where_sql  = $client_cd_sql;
        $where_sql .= $client_name_sql;
        $where_sql .= $client_cname_sql;
        $where_sql .= $area_id_sql;
        $where_sql .= $tel_sql;
        $where_sql .= $state_sql;
    /****************************/
    //ɽ���ǡ�������
    /****************************/
    //���������
    if($output_type != 2){
        //�������
        $client_sql .= $where_sql;
        $total_count_sql = $client_sql;
        $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
        $match_count = pg_num_rows($count_res);
        
        $page_data = Get_Data($count_res, $output_type);
    }else if($output_type == 2){

		//�������
        $client_sql .= $where_sql;
        $total_count_sql = $client_sql;
        $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
        $match_count = pg_num_rows($count_res);
        
        $page_data = Get_Data($count_res, $output_type);

        //CSV����
        for($i = 0; $i < $match_count; $i++){
            if($page_data[$i][5] == 1){
                $page_data[$i][5] = "�����";
            }else{
                $page_data[$i][5] = "���󡦵ٻ���";
            }
            $csv_page_data[$i][0] = $page_data[$i][5];          //����
            $csv_page_data[$i][1] = $page_data[$i][3];          //�϶�
            $csv_page_data[$i][2] = $page_data[$i][6];          //�ȼ�
            $csv_page_data[$i][3] = $page_data[$i][7];          //����
            $csv_page_data[$i][4] = $page_data[$i][8];          //����
            $csv_page_data[$i][5] = $page_data[$i][1];          //�����襳����
            $csv_page_data[$i][6] = $page_data[$i][2];          //������̾��
            $csv_page_data[$i][7] = $page_data[$i][9];          //������̾���եꥬ��
            $csv_page_data[$i][8] = $page_data[$i][10];         //������̾��
            $csv_page_data[$i][9] = $page_data[$i][11];         //������̾���եꥬ��
            $csv_page_data[$i][10] = $page_data[$i][12];        //ά��
            $csv_page_data[$i][11] = $page_data[$i][13];        //ά�Υեꥬ��
            $csv_page_data[$i][12] = $page_data[$i][14];        //͹���ֹ�
            $csv_page_data[$i][13] = $page_data[$i][15];        //���꣱
            $csv_page_data[$i][14] = $page_data[$i][16];        //���ꣲ
            $csv_page_data[$i][15] = $page_data[$i][17];        //���ꣳ
            $csv_page_data[$i][16] = $page_data[$i][18];        //���ꣲ�եꥬ��
            $csv_page_data[$i][17] = $page_data[$i][19];        //���ܶ�
            $csv_page_data[$i][18] = $page_data[$i][4];         //TEL
            $csv_page_data[$i][19] = $page_data[$i][20];        //FAX
            $csv_page_data[$i][20] = $page_data[$i][21];        //Email
            $csv_page_data[$i][21] = $page_data[$i][22];        //URL
            $csv_page_data[$i][22] = $page_data[$i][23];        //��ɽ�Ի�̾
            $csv_page_data[$i][23] = $page_data[$i][24];        //��ɽ����
            $csv_page_data[$i][24] = $page_data[$i][25];        //��ɽ�Է���
            $csv_page_data[$i][25] = $page_data[$i][26];        //ľ��TEL
            $csv_page_data[$i][26] = $page_data[$i][27];        //�����ô��
            $csv_page_data[$i][27] = $page_data[$i][28];        //����ô��
            $csv_page_data[$i][28] = $page_data[$i][29];        //����������
            $csv_page_data[$i][29] = $page_data[$i][30];        //�����ʬ
            $csv_page_data[$i][30] = $page_data[$i][31];        //����
            $csv_page_data[$i][31] = $page_data[$i][32]."��".$page_data[$i][33];  //��ʧ��
            $csv_page_data[$i][32] = $page_data[$i][34];        //��ʧ���
            $csv_page_data[$i][33] = $page_data[$i][36];        //��������
            $csv_page_data[$i][34] = $page_data[$i][37];        //��������ά��
            $csv_page_data[$i][35] = $page_data[$i][38];        //����
            $csv_page_data[$i][36] = $page_data[$i][39];        //�϶���
            $csv_page_data[$i][37] = $page_data[$i][40];        //��ۡ��ݤ��ʬ
            $csv_page_data[$i][38] = $page_data[$i][41];        //�����ǡ�����ñ��
            $csv_page_data[$i][39] = $page_data[$i][42];        //�����ǡ�ü����ʬ
            $csv_page_data[$i][40] = $page_data[$i][43];        //�����ǡ����Ƕ�ʬ
            $csv_page_data[$i][41] = $page_data[$i][44];        //ô����Ź
            $csv_page_data[$i][42] = $page_data[$i][45];        //�������
            $csv_page_data[$i][43] = $page_data[$i][46];        //���׻���
            $csv_page_data[$i][44] = $page_data[$i][47];        //����
        }

        $csv_file_name = "������ޥ���".date("Ymd").".csv";
        $csv_header = array(
            "����",
            "�϶�",
            "�ȼ�",
            "����",
            "����",
            "�����襳����",
            "������̾��",
            "������̾���ʥեꥬ�ʡ�",
            "������̾��",
            "������̾���ʥեꥬ�ʡ�",
            "ά��",
            "ά�Ρʥեꥬ�ʡ�",
            "͹���ֹ�",
            "���꣱",
            "���ꣲ",
            "���ꣳ",
            "���ꣲ�ʥեꥬ�ʡ�",
            "���ܶ�",
            "TEL",
            "FAX",
            "Email",
            "URL",
            "��ɽ�Ի�̾",
            "��ɽ����",
            "��ɽ�Է���",
            "ľ��TEL",
            "�����ô��",
            "����ô��",
            "����������",
            "�����ʬ",
            "����",
            "��ʧ��",
            "��ʧ���",
            "��������",
            "��������ά��",
            "����",
            "�϶���",
            "��ۡ��ݤ��ʬ",
            "�����ǡ�����ñ��",
            "�����ǡ�ü����ʬ",
            "�����ǡ����Ƕ�ʬ",
            "ô����Ź",
            "�������",
            "���׻���",
            "����",
          );

        $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
        $csv_data = Make_Csv($csv_page_data, $csv_header);
        Header("Content-disposition: attachment; filename=$csv_file_name");
        Header("Content-type: application/octet-stream; name=$csv_file_name");
        print $csv_data;
        exit;
    }

#2010-05-12 hashimoto-y
$display_flg = true;
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
//��˥塼����
/****************************/
$page_menu = Create_Menu_f('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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
    'match_count'   => "$match_count",
    'display_flg'    => "$display_flg",
));
$smarty->assign('row',$page_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
