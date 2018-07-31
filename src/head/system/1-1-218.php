<?php
$page_title = "ľ����ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$shop_id  = $_SESSION[client_id];

/****************************/
//�ǥե����������
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
);
$form->setDefaults($def_fdata);

/****************************/
//�������
/****************************/
//���Ϸ���
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio, "form_output_type", "���Ϸ���");
//ľ���襳����
$form->addElement("text","form_direct_cd","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
//ľ����̾
$form->addElement("text","form_direct_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\"".$g_form_option."\"");
//ά��
$form->addElement("text","form_direct_cname","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\"".$g_form_option."\"");
//ɽ��
$form->addElement("submit","show_button","ɽ����");
//���ꥢ
$form->addElement("button","clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//�ѹ�������
//$form->addElement("button","change_button","�ѹ�������","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","�ѹ�������",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�������
$form->addElement("button","new_button","��Ͽ����","onClick=\"location.href='1-1-219.php'\"");

//����
$form->addElement("submit","form_search_button","�����ե������ɽ��");
/******************************/
//�إå�����ɽ�������������
/*****************************/
/** ľ����ޥ�������SQL���� **/
$sql = "SELECT ";
$sql .= "direct_id,";                //ľ����ID
$sql .= "direct_cd,";                //ľ���襳����
$sql .= "direct_name,";              //ľ����̾
$sql .= "direct_cname,";             //ά��
$sql .= "t_client.client_name ";     //������
$sql .= "FROM ";
$sql .= "t_direct ";
$sql .= "LEFT JOIN ";
$sql .= "t_client ";
$sql .= "ON ";
$sql .= "t_direct.client_id = t_client.client_id ";
$sql .= "WHERE ";
$sql .= "t_direct.shop_id = $shop_id ";

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["show_button"]=="ɽ����"){
    //���Ϸ���
    $output_type = $_POST["form_output_type"];
    //ľ���襳����
    $direct_cd   = $_POST["form_direct_cd"];
    //ľ����̾
    $direct_name = $_POST["form_direct_name"];
    //ά��
    $direct_cname = $_POST["form_direct_cname"];
}
    //CSV������Ƚ��
    if($output_type != 2){
        
        /** ������ **/
        //ľ���襳���ɻ����̵ͭ
        if($direct_cd != null){
            $sql .= "AND direct_cd LIKE '$direct_cd%' ";
        }
        //ľ����̾�����̵ͭ
        if($direct_name != null){
            $sql .= "AND direct_name LIKE '%$direct_name%' ";
        }
        //ά�λ����̵ͭ
        if($direct_cname != null){
            $sql .= "AND direct_cname LIKE '%$direct_cname%' ";
        }

        $sql .= "ORDER BY ";
        $sql .= "direct_cd;";
        $result = Db_Query($db_con,$sql);

        //���������
        $total_count = pg_num_rows($result);
    
    }else{
        /** CSV����SQL **/
        $sql = "SELECT ";
        $sql .= "direct_cd,";                // 0 ľ���襳����
        $sql .= "direct_name,";              // 1 ľ����̾
        $sql .= "direct_name2,";             // 2 ľ����̾��
        $sql .= "direct_cname,";             // 3 ά��
        $sql .= "t_direct.post_no1,";        // 4 ͹���ֹ�1
        $sql .= "t_direct.post_no2,";        // 5 ͹���ֹ�2
        $sql .= "t_direct.address1,";        // 6 ����1
        $sql .= "t_direct.address2,";        // 7 ����2
        $sql .= "t_direct.address3,";        // 8 ����3
        $sql .= "t_direct.tel,";             // 9 TEL
        $sql .= "t_direct.fax,";             // 10 FAX
        $sql .= "t_direct.note,";            // 11 ����
        $sql .= "t_client.client_cd1,";      // 12 �����襳���ɣ�
        $sql .= "t_client.client_cd2,";      // 13 �����襳���ɣ�
        $sql .= "t_client.client_name ";     // 14 ������
        $sql .= "FROM ";
        $sql .= "t_direct ";
        $sql .= "LEFT JOIN ";
        $sql .= "t_client ";
        $sql .= "ON ";
        $sql .= "t_direct.client_id = t_client.client_id ";
        $sql .= "WHERE ";
        $sql .= "t_direct.shop_id = $shop_id ";

        /** ������ **/
        //ľ���襳���ɻ����̵ͭ
        if($direct_cd != null){
            $sql .= "AND direct_cd LIKE '$direct_cd%' ";
        }
        //ľ����̾�����̵ͭ
        if($direct_name != null){
            $sql .= "AND direct_name LIKE '%$direct_name%' ";
        }
        //ά�λ����̵ͭ
        if($direct_cname != null){
            $sql .= "AND direct_cname LIKE '%$direct_cname%' ";
        }
        $sql .= "ORDER BY ";
        $sql .= "direct_cd;";

        $result = Db_Query($db_con,$sql);

        //CSV�ǡ�������
        $i=0;
        while($data_list = pg_fetch_array($result)){
            //ľ���襳����
            $direct_data[$i][0] = $data_list[0];
            //ľ����̾
            $direct_data[$i][1] = $data_list[1];
            //ľ����̾��
            $direct_data[$i][2] = $data_list[2];
            //ά��
            $direct_data[$i][3] = $data_list[3];
            //͹���ֹ�1-͹���ֹ�2(ξ��or������̤���Ϥξ���nullɽ��)
            if($data_list[4] != null && $data_list[5] != null){
                $direct_data[$i][4] = $data_list[4]."-".$data_list[5];
            }else{
                $direct_data[$i][4] = "";
            }
            //����
            $direct_data[$i][5] = $data_list[6];    //����1
            $direct_data[$i][6] = $data_list[7];    //����2
            $direct_data[$i][7] = $data_list[8];    //����3
            //TEL
            $direct_data[$i][8] = $data_list[9];
            //FAX
            $direct_data[$i][9] = $data_list[10];
            //�����襳����
            $direct_data[$i][10] = ($data_list[12]!=null)?$data_list[12]."-".$data_list[13]:"";
            //������̾
            $direct_data[$i][11] = $data_list[14];
            //����
            $direct_data[$i][12] = $data_list[11];
            $i++;
        }

        //CSV�ե�����̾
        $csv_file_name = "ľ����ޥ���".date("Ymd").".csv";
        //CSV�إå�����
        $csv_header = array(
            "ľ���襳����", 
            "ľ����̾1",
            "ľ����̾2",
            "ά��",
            "͹���ֹ�",
            "���꣱",
            "���ꣲ",
            "���ꣳ",
            "TEL",
            "FAX",
            "�����襳����",
            "������̾",
            "����",
        );
        $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
        $csv_data = Make_Csv($direct_data, $csv_header);
        Header("Content-disposition: attachment; filename=$csv_file_name");
        Header("Content-type: application/octet-stream; name=$csv_file_name");
        print $csv_data;
        exit;

    }
    //�ԥǡ������ʤ����
    $row = Get_Data($result,$output_type);


/******************************/
//�إå�����ɽ�������������
/*****************************/
/** ľ����ޥ�������SQL���� **/
$sql = "SELECT ";
$sql .= "COUNT(direct_id) ";                //ľ����ID
$sql .= "FROM ";
$sql .= "t_direct ";
$sql .= "WHERE ";
$sql .= "t_direct.shop_id = $shop_id ";
$result = Db_Query($db_con,$sql.";");
//���������(�إå���)
$total_count_h = pg_fetch_result($result,0,0);

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
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count_h."��)";
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
    'total_count'   => "$total_count",
));
$smarty->assign('row',$row);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
