<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2016/01/20                amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */
$page_title = "����������Ͽ����§�������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

// DB��³
$db_con = Db_Connect();

/****************************/
// �ե�����ѡ��ĺ���
/****************************/
// ����ܥ���
$form->addElement("button", "form_set_button", "�ߡ���", "onClick=\"javascript:Dialogue('��§�������ꤷ�ޤ���','".HEAD_DIR."system/1-1-104.php', this)\"");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// �Ĥ���ܥ���
$form->addElement("button", "form_close_button", "�Ĥ���", "onClick=\"window.close()\"");

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
$page_header = Create_Header($page_title);

//��������(�����������ɤ򸫤䤹�����뤿������)
define('YEAR', 0);
define('MONTH', 1);
define('DAY', 2);

//����������(ǯ�����)��$date������Ȥ�������
$date = date('Y n d');
$date = explode(' ', $date);
$date[MONTH] = (int) $date[MONTH]-1;

for($m2=1;$m2<7;$m2++){
	$calendar .= '<table cellpadding="15"><tr><td valign="top">'."\n";

	for($m1=1;$m1<5;$m1++){
		//����Ū���ѿ������������Ѵ�
		$date[MONTH] = (int) $date[MONTH];
		$date[YEAR] = (int) $date[YEAR];
		$date[DAY] = (int) $date[DAY];
		//�12����ä��鼡�η��1��
		if($date[MONTH] == 12){
			$date[MONTH] = 1;
			$date[YEAR] = $date[YEAR]+1;
		//12��ʳ����ä���ܣ���
		}else{
			$date[MONTH] = $date[MONTH]+1;
		}

		//������������ǽ�������Ǹ����������������
		$days = date('d', mktime(0, 0, 0, $date[MONTH]+1, 0, $date[YEAR]));
		$first_day = date('w', mktime(0, 0, 0, $date[MONTH], 1, $date[YEAR]));
		$last_day = date('w', mktime(0, 0, 0, $date[MONTH], $days, $date[YEAR]));
		
		if($first_day == 0){
			$first_day = 6;
		}else{
			$first_day = $first_day-1;
		}
		
		if($last_day == 0){
			$last_day = 6;
		}else{
			$last_day = $last_day-1;
		}
		
		//�Ǹ�ν�������������
		$last_week_days = ($days + $first_day) % 7;
		if ($last_week_days == 0){
			$weeks = ($days + $first_day) / 7;
		}else{
			$weeks = ceil(($days + $first_day) / 7);
		}
		//����������ɽ�Ȥ��ƽ��Ϥ���
		$calendar .= '<table class=\'List_Table\' border=\'1\' width=\'200\'>'."\n";
		$calendar .= '<caption><b><font size="+1">��'.$date[YEAR].'ǯ'.$date[MONTH].'���</font></b></caption>';

		$calendar .= '<tr><th class=\'Title_Purple\'>��</th><th class=\'Title_Purple\'>��</th><th class=\'Title_Purple\'>��</th><th class=\'Title_Purple\'>��</th><th class=\'Title_Purple\'>��</th><th class=\'Title_Purple\'>��</th><th class=\'Title_Purple\'>��</th></tr>';

		$i=$j=$day=0;
		while($i<$weeks){
			$calendar .= '<tr class=\'Result1\' align=\'center\'>'."\n";
			$j=0;
			while($j<7){
				$calendar .= '<td';
				if(($i==0 && $j<$first_day) || ($i==$weeks-1 && $j>$last_day)){
					$calendar .= '> '."\n";
				}else{
					$calendar .= '>'."\n";
					$calendar .= ++$day;
					$calendar .= "<br>";
					//�����å��ܥå������
					$form->addElement('checkbox', "check_".$date[YEAR]."-".$date[MONTH]."-".$day, '�����å��ܥå���', '');
					$calendar .= $form->_elements[$form->_elementIndex["check_".$date[YEAR]."-".$date[MONTH]."-".$day]]->toHtml();
				}
				$calendar .= '</td>'."\n";
				$j++;
			}
			$calendar .= '</tr>'."\n";
			$i++;
		}
		$calendar .= '</table></td><td valign="top">'."\n";
	}
	$calendar .= '</tr>'."\n";
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
	'calendar'      => "$calendar",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
