<?php

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "dateForm","POST");

/**************HTML���᡼������������********************/

//����������ϥƥ�����
$text[] =& $form->createElement("text","t_year","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime','t_year','t_month',1)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text[] =& $form->createElement("static","","","ǯ");
$text[] =& $form->createElement("text","t_month","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime','t_month','t_day',2)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text[] =& $form->createElement("static","","","��");
$text[] =& $form->createElement("text","t_day","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" value=\"\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text[] =& $form->createElement("static","","","��");
$form->addGroup( $text, "f_datetime", "f_datetime");

//�������ϥƥ�����
$text2[] =& $form->createElement("text","t_year","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime2','t_year','t_month',1)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text2[] =& $form->createElement("static","","","ǯ");
$text2[] =& $form->createElement("text","t_month","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime2','t_month','t_day',2)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text2[] =& $form->createElement("static","","","��");
$text2[] =& $form->createElement("text","t_day","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" value=\"\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text2[] =& $form->createElement("static","","","��");
$form->addGroup( $text2, "f_datetime2", "f_datetime2");

//����������ɽ��
$text1[] =& $form->createElement("text","t_year","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"move_text(this.form,'next_date','t_year','t_month',1)\" onFocus=\"Comp_Form_NextToday(this,this.form,'next_date','t_year','t_month','t_day')\" onBlur=\"blurForm(this)\"");
$text1[] =& $form->createElement("static","","","ǯ");
$text1[] =& $form->createElement("text","t_month","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"move_text(this.form,'next_date','t_month','t_day',2)\" onFocus=\"Comp_Form_NextToday(this,this.form,'next_date','t_year','t_month','t_day')\" onBlur=\"blurForm(this)\"");
$text1[] =& $form->createElement("static","","","��");
$text1[] =& $form->createElement("text","t_day","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" value=\"\" onFocus=\"Comp_Form_NextToday(this,this.form,'next_date','t_year','t_month','t_day')\" onBlur=\"blurForm(this)\"");
$text1[] =& $form->createElement("static","","","��");
$form->addGroup( $text1, "next_date", "next_date");

//����ɽ���ƥ�����
$form->addElement("text","t_display","�ƥ����ȥե�����",'size="15" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//��Ͽ�ܥ���
$form->addElement("submit","touroku","�С�Ͽ","onClick=\"javascript: return dialogue('��Ͽ���ޤ���','#')\"");

//���ꥢ�ܥ���
$form->addElement("submit","reset","���ꥢ");

/**********************��Ͽ�ܥ��󲡲�����*****************/

if(isset($_POST["touroku"])){
	
	//���������
	$b_year = $_POST["f_datetime"]["t_year"];
	$b_month = $_POST["f_datetime"]["t_month"];
	$b_day = $_POST["f_datetime"]["t_day"];
	//���ռ���
	$year = $_POST["f_datetime2"]["t_year"];
	$month = $_POST["f_datetime2"]["t_month"];
	$day = $_POST["f_datetime2"]["t_day"];

	//����������
	$display = Basic_date($b_year,$b_month,$b_day,$year,$month,$day);

	if($display == false){
		$display = "���顼";
	}else{
		$display = $display[0]."����".$display[1]."����";
	}

	//POST������ѹ�
	$delete_data = array(
		"t_display"     => "$display"
	);
	$form->setConstants($delete_data);

}

/**********************���ꥢ�ܥ��󲡲�����***************/

if(isset($_POST["reset"])){
	//POST������ѹ�
	$delete_data = array(
	    "f_datetime[t_year]"     => "",
		"f_datetime[t_month]"     => "",
		"f_datetime[t_week]"     => "",
		"f_datetime[t_day]"     => "",
		"f_datetime2[t_year]"     => "",
		"f_datetime2[t_month]"     => "",
		"f_datetime2[t_week]"     => "",
		"f_datetime2[t_day]"     => "",
		"t_display"     => ""
	);
	$form->setConstants($delete_data);
}

/*********************************************************/


/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
