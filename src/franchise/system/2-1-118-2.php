<?php
$page_title = "����ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");


//DB��³
$db_con = Db_Connect();

/****************************/
//�ե��������
/****************************/

//�ǥե�����ͤ�����
$def_date = array(
    "form_round_div_1"     => "1",
	"form_round_div_2"     => "1",
);
$form->setDefaults($def_date);

//������
$text19[] =& $form->createElement("text","code1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" onkeyup=\"changeText_customer(this.form)\" ".$g_form_option."\"");
$text19[] =& $form->createElement("static","","","-");
$text19[] =& $form->createElement("text","code2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" ".$g_form_option."\"");
$text19[] =& $form->createElement("text","name","�ƥ����ȥե�����",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');
$form->addGroup( $text19, "f_customer", "f_customer");

//������
$text36[] =& $form->createElement("text","code1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" onKeyUp=\"javascript:display(this,'claim')\" ".$g_form_option."\"");
$text36[] =& $form->createElement("static","","","-");
$text36[] =& $form->createElement("text","code2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" onKeyUp=\"javascript:display(this,'claim')\" ".$g_form_option."\"");
$text36[] =& $form->createElement("text","name","�ƥ����ȥե�����",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');
$form->addGroup( $text36, "f_claim", "f_claim");

//������
//$team_ary = Select_Get($db_con,'team');
$form->addElement('select', 'form_team', '���쥯�ȥܥå���', $team_ary, $g_form_option_select);


//���ô����(1)
$select_value = Select_Get($db_con,'staff');
$form->addElement('select', 'f_select1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//���ô����(2)
$form->addElement('select', 'f_select2', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//����(1)
$form->addElement("text","f_goods1","�ƥ����ȥե�����","size=\"10\" maxLength=\"8\" onKeyUp=\"javascript:display4(this,'goods1')\" ".$g_form_option."\"");
$form->addElement("text","t_goods1","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");
//����(2)
$form->addElement("text","f_goods2","�ƥ����ȥե�����","size=\"10\" maxLength=\"8\" onKeyUp=\"javascript:display4(this,'goods2')\" ".$g_form_option."\"");
$form->addElement("text","t_goods2","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//���ñ��(1)
$text5_1[] =& $form->createElement("text","f_text9","�ƥ����ȥե�����","size=\"11\" maxLength=\"9\" onkeyup=\"changeText10(this.form,1)\" style=\"text-align: right\"".$g_form_option."\"");
$text5_1[] =& $form->createElement("static","","",".");
$text5_1[] =& $form->createElement("text","f_text2","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"text-align: left\" ".$g_form_option."\"");
$form->addGroup( $text5_1, "f_code_c1", "f_code_c1");
//���ñ��(2)
$text5_2[] =& $form->createElement("text","f_text9","�ƥ����ȥե�����","size=\"11\" maxLength=\"9\" onkeyup=\"changeText10(this.form,2)\" style=\"text-align: right\" ".$g_form_option."\"");
$text5_2[] =& $form->createElement("static","","",".");
$text5_2[] =& $form->createElement("text","f_text2","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");
$form->addGroup( $text5_2, "f_code_c2", "f_code_c2");

//(4)����� (1)
$text = "";
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day4_1[y]','form_stand_day4_1[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day4_1[m]','form_stand_day4_1[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day4_1[d]','form_cale_mon4_1',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day4_1","form_stand_day4_1","-");

$form->addElement("text","form_cale_mon4_1","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day4_1","�ƥ����ȥե�����",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(4)����� (2)
$text = "";
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day4_2[y]','form_stand_day4_2[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day4_2[m]','form_stand_day4_2[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day4_2[d]','form_cale_mon4_2',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day4_2","form_stand_day4_2","-");

$form->addElement("text","form_cale_mon4_2","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day4_2","�ƥ����ȥե�����",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(5)����� (1)
$text = "";
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day5_1[y]','form_stand_day5_1[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day5_1[m]','form_stand_day5_1[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day5_1[d]','form_cale_mon5_1',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day5_1","form_stand_day5_1","-");

$form->addElement("text","form_cale_mon5_1","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day5_1","�ƥ����ȥե�����",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(5)����� (2)
$text = "";
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day5_2[y]','form_stand_day5_2[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day5_2[m]','form_stand_day5_2[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day5_2[d]','form_cale_mon5_2',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day5_2","form_stand_day5_2","-");

$form->addElement("text","form_cale_mon5_2","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day5_2","�ƥ����ȥե�����",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(6)����� (1)
$text = "";
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day6_1[y]','form_stand_day6_1[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day6_1[m]','form_stand_day6_1[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day6_1[d]','form_week_num6_1',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day6_1","form_stand_day6_1","-");

$form->addElement("text","form_week_num6_1","�ƥ����ȥե�����","size=\"1\" maxLength=\"1\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day6_1","�ƥ����ȥե�����",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//(6)����� (2)
$text = "";
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_stand_day6_2[y]','form_stand_day6_2[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day6_2[m]','form_stand_day6_2[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_stand_day6_2[d]','form_week_num6_2',2)\" ".$g_form_option."\"");
$form->addGroup($text,"form_stand_day6_2","form_stand_day6_2","-");

$form->addElement("text","form_week_num6_2","�ƥ����ȥե�����","size=\"1\" maxLength=\"1\" ".$g_form_option."\"");

$form->addElement("text","f_cale_day6_2","�ƥ����ȥե�����",'size="1" maxLength="1" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//ɽ��
$button[] = $form->createElement("submit","hyouji","ɽ����");
//���ꥢ
$button[] = $form->createElement("button","kuria","���ꥢ","onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");
//�������
$button[] = $form->createElement("button","change2","�������","onClick=\"javascript:location.href='2-1-114.php'\"");

//���
$button[] = $form->createElement("button","modoru","�ᡡ��","onClick=\"javascript:history.back()\"");
//��Ͽ(�إå���)
$form->addElement("button","new_button","�С�Ͽ","onClick=\"location.href='2-1-104.php?flg=add'\"");
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:Referer('2-1-111.php')\"");
//�������(�إå���)
$form->addElement("button","all_button","�������","style=\"color: #ff0000;\" onClick=\"location.href='2-1-114.php'\"");
$form->addGroup($button, "button", "");

/****************************/
//�ǥ�ǡ���
/****************************/
$demo_data = array(
    array("A����������", "���ݥ�������",          "���ݥ�������", "MSG-CP","70", "100", "��ƣ�칰"),
    array("D����������", "����������Ź��ȳ������","���ݥ�������", "MSG-CV","72", "100", "����˥ƥ������"),
    array("������",  "�ѡ��顼���ȥ�",          "���ݥ�������", "DSS3-W","77", "100", "����˥ƥ������"),
    array("������",  "������ҥ�������",        "���ݥ�������", "DSS7-W","75", "100", "���״֡���"),
);


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
$total_count = 7;
$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

$smarty->assign("demo_data",$demo_data);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'total_count'    => "$total_count",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
