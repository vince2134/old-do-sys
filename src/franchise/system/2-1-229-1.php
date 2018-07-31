<?php
$page_title = "�����ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB����³
$conn = Db_Connect();

/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/****************************/
//�ե���������
/****************************/
//���Ϸ���
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup( $radio, "form_output_type", "���Ϸ���");

//���ʥ�����
$form->addElement(
        "text","form_compose_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\" 
        ".$g_form_option."\"" 
    );

//����̾
$form->addElement(
        "text","form_compose_goods_name","",'size="34" 
        '." $g_form_option"
    );

//�ܥ���
//��Ͽ
$form->addElement("button","new_button","��Ͽ����","onClick=\"javascript:Referer('2-1-230.php')\"");
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$button[] = $form->createElement(
    "submit","show_button","ɽ����"
    );
$button[] = $form->createElement(
    "button","clear_button","���ꥢ",
    "onClick=\"location.href='$_SERVER[PHP_SELF]'\"
    ");
$form->addGroup($button, "form_button", "");

//hidden
$form->addElement("hidden","form_hidden_output_type");
$form->addElement("hidden","form_hidden_goods_cd");
$form->addElement("hidden","form_hidden_goods_name");

/****************************/
//�ǥե����������
/****************************/
$def_form= array(
    "form_output_type"   => "1",
    );
$form->setDefaults($def_form);

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_button"]["show_button"] == "ɽ����"){
    $output_type    = $_POST["form_output_type"];                           //���Ϸ���
    $compose_goods_cd       = trim($_POST["form_compose_goods_cd"]);        //���ʥ�����
    $compose_goods_name     = trim($_POST["form_compose_goods_name"]);      //����̾

    $post_flg = true;                                                       //POST�ե饰
}

/****************************/
//POST�������
/****************************/
if(count($_POST) > 0 && !isset($_POST["form_button"]["show_button"])){
    $page_count             = $_POST["f_page1"];                            //�ڡ�����
    $output_type            = $_POST["form_hidden_output_type"];            //���Ϸ���
    $compose_goods_cd       = $_POST["form_hidden_compose_goods_cd"];       //���ʥ�����    
    $compose_goods_name     = $_POST["form_hidden_compose_goods_name"];     //����̾

    $post_flg = true;                                                       //POST�ե饰
}

/****************************/
//�����ǡ������åȡ�
/****************************/
$goods_form = array(
    "form_compose_goods_cd"         => stripslashes($compose_goods_cd),                   //���ʥ�����
    "form_compose_goods_name"       => stripslashes($compose_goods_name),                 //����̾
    "form_hidden_goods_cd"          => stripslashes($compose_goods_cd),                   //���ʥ�����
    "form_hidden_goods_name"        => stripslashes($compose_goods_name),                 //����̾
);

$form->setConstants($goods_form);

/****************************/
//where_sql����
/****************************/
if($post_flg == true){

    //���ʥ�����
    if($compose_goods_cd != null){
        $compose_goods_cd_sql  = " AND t_goods.goods_cd LIKE '$compose_goods_cd%'";
    }

    //����̾
    if($compose_goods_name != null){
        $compose_goods_name_sql .= " AND t_goods.goods_name LIKE '%$compose_goods_name%'";
    }

    $where_sql = $compose_goods_cd_sql.$compose_goods_name_sql;
}

/****************************/
//ɽ���ǡ�������
/****************************/
if($output_type == 1 || $output_type == null){    
    if(isset($_POST["f_page1"])){
        $page_count  = $_POST["f_page1"];
        $offset = $page_count * 100 - 100;
    }else{  
        $offset = 0;
    }

    $compose_goods_sql  = " SELECT";
    $compose_goods_sql .= " DISTINCT";
    $compose_goods_sql .= "    t_goods.goods_cd,";
    $compose_goods_sql .= "    t_goods.goods_id,";
    $compose_goods_sql .= "    t_goods.goods_name";
    $compose_goods_sql .= " FROM";
    $compose_goods_sql .= "    t_goods,";
    $compose_goods_sql .= "    t_compose";
    $compose_goods_sql .= " WHERE";
    $compose_goods_sql .= "    t_compose.goods_id = t_goods.goods_id ";
    $compose_goods_sql .= $where_sql;

    $compose_count_sql = $compose_goods_sql.";";
    $count_res = Db_query($conn, $compose_count_sql);
    $total_count = pg_num_rows($count_res);
	
    $compose_goods_sql .= "ORDER BY goods_cd LIMIT 100 OFFSET $offset";
    $compose_goods_sql .= ";";

    $compose_goods_res = Db_query($conn, $compose_goods_sql);
    $compose_goods_data = Get_Data($compose_goods_res, $output_type);

/******************************/
//CSV����
/******************************/
}elseif($output_type == 2){
    $compose_goods_sql  = " SELECT";
    $compose_goods_sql .= "    t_goods.goods_cd,";
    $compose_goods_sql .= "    t_goods.goods_name,";
    $compose_goods_sql .= "    t_parts.goods_cd,";
    $compose_goods_sql .= "    t_parts.goods_name,";
    $compose_goods_sql .= "    t_compose.count";
    $compose_goods_sql .= " FROM";
    $compose_goods_sql .= "    t_goods,";
    $compose_goods_sql .= "    t_goods AS t_parts,";
    $compose_goods_sql .= "    t_compose,";
    $compose_goods_sql .= "    t_goods_info";
    $compose_goods_sql .= " WHERE";
    $compose_goods_sql .= ($group_kind == "2") ? " t_goods.shop_id IN (".Rank_Sql().") " : " t_goods.shop_id = $shop_id ";
    $compose_goods_sql .= "    AND";
    $compose_goods_sql .= "    t_goods.goods_id = t_goods_info.goods_id";
    $compose_goods_sql .= "    AND";
    $compose_goods_sql .= "    t_goods_info.compose_flg = 't'";
    $compose_goods_sql .= $where_sql;
    $compose_goods_sql .= "    AND";
    $compose_goods_sql .= "    t_goods.goods_id = t_compose.goods_id";
    $compose_goods_sql .= "    AND";
    $compose_goods_sql .= "    t_compose.parts_goods_id = t_parts.goods_id";
    $compose_goods_sql .= " ORDER BY t_goods.goods_cd, t_parts.goods_cd";
    $compose_goods_sql .= ";";

    $compose_goods_res = Db_query($conn, $compose_goods_sql);
    $compose_goods_data = Get_Data($compose_goods_res, $output_type);
    $csv_file_name = "��¤�ʥޥ���".date("Ymd").".csv";
    $csv_header = array(
        "�ƾ��ʥ�����",
        "�ƾ���̾",
        "�����ʥ�����",
        "������̾",
        "����"
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($compose_goods_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");

    print $csv_data;
    exit;
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
	"total_count" => "$total_count",
));

$smarty->assign('compose_goods_data', $compose_goods_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
