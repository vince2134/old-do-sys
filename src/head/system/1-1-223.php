<?php
/*************************
*�ѹ�����
*   ��2006/05/08�˸����ե�����ɽ���ܥ�����ɲ�(watanabe-kq)
*
*
*************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-01-24      �����ѹ�    watanabe-k  �ܥ���ο����ѹ�
 */


$page_title = "��¤�ʥޥ���";

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
$shop_id = $_SESSION["client_id"];

/* GET����ID�������������å� */
$where = " make_goods_flg = 't' AND shop_id = 1 ";
//if ($_GET["goods_id"] != null && Get_Id_Check_Db($conn, $_GET["goods_id"], "goods_id", "t_goods", "num", $where) != true){
//    header("Location: ../top.php");
//}

/****************************/
//�ե���������
/****************************/
//���Ϸ���
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup( $radio, "form_output_type", "���Ϸ���");

//���ʥ�����
$form->addElement(
        "text","form_make_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        ".$g_form_option."\""
    );

//����̾
$form->addElement(
        "text","form_make_goods_name","",'size="34" 
        '." $g_form_option"
    );

//��Ͽ
$form->addElement("button","new_button","��Ͽ����","onClick=\"javascript:Referer('1-1-224.php')\"");
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$button[] = $form->createElement(
    "submit","show_button","ɽ����"
    );
$button[] = $form->createElement(
    "button","clear_button","���ꥢ",
    "onClick=\"location.href='$_SERVER[PHP_SELF]'\"
    ");
$form->addGroup($button, "form_button", "");

//�����ե�����ɽ���ܥ���
$form->addElement("submit","form_search_button","�����ե������ɽ��");

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
    $output_type    = $_POST["form_output_type"];                   //���Ϸ���
    $make_goods_cd       = trim($_POST["form_make_goods_cd"]);           //���ʥ�����
    $make_goods_name     = trim($_POST["form_make_goods_name"]);         //����̾

    $post_flg = true;                                               //POST�ե饰
}

/****************************/
//POST�������
/****************************/
if(count($_POST) > 0 && !isset($_POST["form_button"]["show_button"])){
    $page_count     = $_POST["f_page1"];                            //�ڡ�����
    $output_type    = $_POST["form_hidden_output_type"];            //���Ϸ���
    $make_goods_cd       = $_POST["form_hidden_make_goods_cd"];     //���ʥ�����    
    $make_goods_name     = $_POST["form_hidden_make_goods_name"];   //����̾

    $post_flg = true;                                               //POST�ե饰
}

/****************************/
//�����ǡ������åȡ�
/****************************/
$goods_form = array(
    "form_make_goods_cd"            => stripslashes($make_goods_cd),              //���ʥ�����
    "form_make_goods_name"          => stripslashes($make_goods_name),            //����̾
    "form_hidden_goods_cd"          => stripslashes($make_goods_cd),              //���ʥ�����
    "form_hidden_goods_name"        => stripslashes($make_goods_name),            //����̾
);

$form->setConstants($goods_form);

/****************************/
//where_sql����
/****************************/
if($post_flg == true){

    //���ʥ�����
    if($make_goods_cd != null){
        $make_goods_cd_sql  = " AND t_goods.goods_cd LIKE '$make_goods_cd%'";
    }

    //����̾
    if($make_goods_name != null){
        $make_goods_name_sql .= " AND t_goods.goods_name LIKE '%$make_goods_name%'";
    }

    $where_sql = $make_goods_cd_sql.$make_goods_name_sql;
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

    $make_goods_sql  = " SELECT";
    $make_goods_sql .= "    t_goods.goods_cd,";
    $make_goods_sql .= "    t_goods.goods_id,";
    $make_goods_sql .= "    t_goods.goods_name";
    $make_goods_sql .= " FROM";
    $make_goods_sql .= "    t_goods";
    $make_goods_sql .= " WHERE";
    $make_goods_sql .= "    t_goods.shop_id = $shop_id";
    $make_goods_sql .= "    AND";
    $make_goods_sql .= "    t_goods.make_goods_flg = 't'";
    $make_goods_sql .= $where_sql;
    
    $make_goods_sql .= "ORDER BY goods_id LIMIT 100 OFFSET $offset";
    $make_goods_sql .= ";";

    $make_goods_res = Db_query($conn, $make_goods_sql);
	$search_num = pg_num_rows($make_goods_res);
    $make_goods_data = Get_Data($make_goods_res, $output_type);

/******************************/
//CSV����
/******************************/
}elseif($output_type == 2){
    $make_goods_sql  = " SELECT";
    $make_goods_sql .= "    t_goods.goods_cd,";
    $make_goods_sql .= "    t_goods.goods_name,";
    $make_goods_sql .= "    t_parts.goods_cd,";
    $make_goods_sql .= "    t_parts.goods_name,";
    $make_goods_sql .= "    t_make_goods.numerator,";
    $make_goods_sql .= "    t_make_goods.denominator";
    $make_goods_sql .= " FROM";
    $make_goods_sql .= "    t_goods,";
    $make_goods_sql .= "    t_goods AS t_parts,";
    $make_goods_sql .= "    t_make_goods";
    $make_goods_sql .= " WHERE";
    $make_goods_sql .= "    t_goods.shop_id = $shop_id";
    $make_goods_sql .= "    AND";
    $make_goods_sql .= "    t_goods.make_goods_flg = 't'";
    $make_goods_sql .= $where_sql;
    $make_goods_sql .= "    AND";
    $make_goods_sql .= "    t_goods.goods_id = t_make_goods.goods_id";
    $make_goods_sql .= "    AND";
    $make_goods_sql .= "    t_make_goods.parts_goods_id = t_parts.goods_id";
    $make_goods_sql .= " ORDER BY t_goods.goods_cd, t_parts.goods_cd";
    $make_goods_sql .= ";";

    $make_goods_res = Db_query($conn, $make_goods_sql);
    $make_goods_data = Get_Data($make_goods_res, $output_type);

    $csv_file_name = "��¤�ʥޥ���".date("Ymd").".csv";
    $csv_header = array(
        "��¤�ʥ�����",
        "��¤��̾",
        "���ʥ�����", 
        "����̾",
        "ʬ��",
        "ʬ��"
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($make_goods_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/****************************/
//���������
/****************************/
$make_goods_sql  = " SELECT";
$make_goods_sql .= "    COUNT(t_goods.goods_id)";
$make_goods_sql .= " FROM";
$make_goods_sql .= "    t_goods";
$make_goods_sql .= " WHERE";
$make_goods_sql .= "    t_goods.shop_id = $shop_id";
$make_goods_sql .= "    AND";
$make_goods_sql .= "    t_goods.make_goods_flg = 't'";

//�إå�����ɽ�������������
$total_count_sql = $make_goods_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

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
	"total_count"   => "$total_count",
    "search_num"    => "$search_num",
));
$smarty->assign('make_goods_data', $make_goods_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
