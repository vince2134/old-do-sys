<?php
$page_title = "���ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//����ץ�ؿ�
//require_once(PATH."function/sample_func_watanabe.inc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB����³
$conn = Db_Connect();

/****************************/
//�����ѿ�����
/****************************/
session_start();
$shop_id = $_SESSION["client_id"];

/****************************/
//�ե��������
/***************************/
$form->addElement(
    "submit","form_show_button","ɽ����"
);
$form->addElement(
    "button","form_clear_button","�Ĥ���",
    "onClick=\"window.close()\"
");

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

/******************************/
//�إå�����ɽ�������������
/*****************************/
if($_POST["form_show_button"] == "ɽ����") {
$goods_sql  = " SELECT";
$goods_sql .= "     t_goods.goods_cd,";
$goods_sql .= "     t_goods.goods_name,";
$goods_sql .= "     t_goods.goods_cname,";
$goods_sql .= "     t_product.product_name,";
$goods_sql .= "     t_g_goods.g_goods_name,";
$goods_sql .= "     CASE t_goods.attri_div";
$goods_sql .= "         WHEN '1' THEN '����'";
$goods_sql .= "         WHEN '2' THEN '����'";
$goods_sql .= "         WHEN '3' THEN '����'";
$goods_sql .= "         WHEN '4' THEN '����¾'";
$goods_sql .= "     END";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods,";
$goods_sql .= "     t_g_goods,";
$goods_sql .= "     t_product";
$goods_sql .= " WHERE";
$goods_sql .= "     t_goods.product_id = t_product.product_id";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.g_goods_id = t_g_goods.g_goods_id";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.public_flg = 't'";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.shop_id = $shop_id ";
$goods_sql .= "ORDER BY goods_cd";
$goods_sql .= ";";

$goods_res = Db_Query($conn, $goods_sql);
//$match_count = pg_num_rows($goods_res);
$goods_data = Get_Data($goods_res);
}

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
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
    'match_count'   => "$match_count",
));

$smarty->assign('page_data', $goods_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
