<?php

/******************************
 *  �ѹ�����
 *      ����2006-10-30����§�����̤����ܥ��󲡲������ѹ�<suzuki>
 *      ��              ��§������������ɽ���������ѹ�<suzuki>                      
 *
 *
******************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/06/29      B0702-067   kajioka-h   ���ꥢ�ܥ���򲡤��������̤����������Х�����
 *  2009/06/24      ����No.37	aizawa-m	��������ɽ����2ǯʬ��5ǯʬ���ѹ�
 *  2009/06/25      ����No.37	aizawa-m	��������ɽ���Դ֤�<hr>���ɲ�
 *
 */


$page_title = "��§������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB����³
$db_con = Db_Connect();
// ���¥����å�
$auth       = Auth_Check($db_con);

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/****************************/
//�����ѿ�
/****************************/
$flg       = $_GET["flg"];
$client_id = $_GET["client_id"];
$get_con_id = $_GET["contract_id"];

//����Ƚ��
Get_ID_Check3($client_id);
Get_ID_Check3($get_con_id);


/****************************/
//���ɽ��
/****************************/
if($_POST["form_issiki"] != NULL){
	$con_data["form_cost_div"] = 1;
	$form->setConstants($con_data);
}

/****************************/
//hidden�Ƿ�����Ͽ���������
/****************************/
require_once(INCLUDE_DIR."keiyaku_hidden.inc");

//���ڡ�����hidden���ݻ�
$form->addElement('hidden', "daiko_page_flg");


/****************************/
//hidden���������������
/****************************/
/*
//������Ͽ�ιԿ�ʬ
for($i=1;$i<=5;$i++){
	//������Ͽ�ιԿ�ʬ
	for($j=1;$j<=5;$j++){
		//���ʥ�����
		$form->addElement("hidden","break_goods_cd[$i][$j]","");
		//����̾
		$form->addElement("hidden","break_goods_name[$i][$j]","");
		//���ʿ�
		$form->addElement("hidden","break_goods_num[$i][$j]","");
		//����ID
		$form->addElement("hidden","hdn_bgoods_id[$i][$j]","");
		//��̾�ѹ��ե饰
		$form->addElement("hidden","hdn_bname_change[$i][$j]","");

		//�Ķȸ���
		$form->addElement("hidden","break_trade_price[$i][$j][1]","");
		$form->addElement("hidden","break_trade_price[$i][$j][2]","");
		//�������
		$form->addElement("hidden","break_trade_amount[$i][$j]","");
		//���ñ��
		$form->addElement("hidden","break_sale_price[$i][$j][1]","");
		$form->addElement("hidden","break_sale_price[$i][$j][2]","");
		//�����
		$form->addElement("hidden","break_sale_amount[$i][$j]","");
	}
}
*/


/****************************/
//���ꥢ�ܥ��󲡲�����
/****************************/
//-- 2009/06/24 ����No.37 �ɲ�
$term = 5;	//ǯ��
//----
if($_POST["clear_flg"] == true){
	//��§�����ͽ����
	$year  = date("Y");
	$month = date("m");

	//-- 2009/06/25 ����No.37 �ѹ�
	// ɽ������򻻽�
	$m_term = $term * 12;	//����򻻽�
	for($i=0;$i<$m_term;$i++){
	//for($i=0;$i<28;$i++){
		//�����������
		$now = mktime(0, 0, 0, $month+$i,1,$year);
		$num = date("t",$now);
		//��ǯ��������ʬ�ǡ�������
		for($s=1;$s<=$num;$s++){
			$now = mktime(0, 0, 0, $month+$i,$s,$year);
			$syear  = (int) date("Y",$now);
			$smonth = (int) date("n",$now);
			$sday   = (int) date("d",$now);
			$input_date = "check_".$syear."-".$smonth."-".$sday;

			//�����å����줿���դ��������
			if($_POST["$input_date"] != NULL){
				$con_data["$input_date"]      = "";
			}
		}
	}

	/*
	 * ����
	 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
	 * ��2006/10/30��01-009��������suzuki-t������§�����̤����ܥ��󲡲������ѹ�
	 *
	*/
	//���ꥢ�ܥ��󲡲���Ƚ��
	if($_POST["clear_count"] == NULL){
		//���ꥢ�ܥ��󲡲��������ξ��ϡ��������������Ͽ���̤ΰ�-1�򥻥å�
		$clear_count = -1;
	}else{
		//���ߤβ�����������
		$clear_count = $_POST["clear_count"];
	}
	$clear_count--;
	$con_data["clear_count"] = $clear_count;

	$con_data["clear_flg"]      = "";
}

/****************************/
//�������
/****************************/
if ($_POST[daiko_page_flg] == "1") {
	$r_url = "2-1-240.php";
}else{
	$r_url = "2-1-104.php";
}

$form->addElement("submit","set","�ߡ���",
    "onClick=\"return Dialogue('���ꤷ�ޤ���','./$r_url?flg=$flg&client_id=$client_id&contract_id=$get_con_id&c_check=true');\""
	);

$form->addElement("button","kuria","���ꥢ","onClick=\"insert_row('clear_flg');\"");

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/30��01-009��������suzuki-t������§�����̤����ܥ��󲡲������ѹ�
 *
*/
//���ꥢ�ܥ��󲡲����ʳ��ϡ�������β��̤����
if($clear_count == NULL){
	$clear_count = -1;
}
//$form->addElement("button","back","�ᡡ��","onClick=\"SubMenu2('./2-1-104.php?flg=$flg&client_id=$client_id&contract_id=$get_con_id')\"");
$form->addElement("button","back","�ᡡ��","onClick=\"history.go($clear_count)\"");
//���ꥢ�ܥ��󲡲���
$form->addElement("hidden","clear_count");

/****************************/
//POST������ͤ��ѹ�
/****************************/
$form->setConstants($con_data);


//��������(�����������ɤ򸫤䤹�����뤿������)
define('YEAR', 0);
define('MONTH', 1);
define('DAY', 2);

//����������(ǯ�����)��$date������Ȥ�������
$date = date('Y n d');
$date = explode(' ', $date);
$date[MONTH] = (int) $date[MONTH]-1;

//-- 2009/06/24 ����No.37 �ѹ� ----------------
// ����������ɽ��ǯ�����ѹ�����
// ��ɽ��ǯ��*12����/ɽ�������
$rows = 4;	//ɽ�����
$line = (($term) * 12 / $rows) + 2;	//ɽ���Կ�(�ǹ⤬+2)

// ��������ɽ���κǽ������ѿ��˳�Ǽ
$last_date = date('Ynd', mktime(0, 0, 0, $date[MONTH]+1, 0, $date[YEAR]+$term));

for($m2=1;$m2<$line;$m2++){
//for($m2=1;$m2<7;$m2++){
//---------------------------------------------

	//-- 2009/06/25 ����No.37 �ѹ�
	//$calendar .= '<table cellpadding="15"><tr><td valign="top">'."\n";
	$calendar .= '<table cellpadding="15"><tr><td valign="top" width=200>'."\n";
	
	// ɽ������˹�碌�Ʒ��֤�
	for($m1=1;$m1<($rows+1);$m1++){
	//for($m1=1;$m1<5;$m1++){
	//---------

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

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/30��01-004��������suzuki-t������������������������Ϥ��褦���ѹ�
 *
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
*/
		
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
					++$day;
					#$calendar .= ++$day;
					#$calendar .= "<br>";
					//�����å��ܥå������
					$form->addElement('checkbox', "check_".$date[YEAR]."-".$date[MONTH]."-".$day, '�����å��ܥå���', "<br>"." $day");
					$calendar .= $form->_elements[$form->_elementIndex["check_".$date[YEAR]."-".$date[MONTH]."-".$day]]->toHtml();
				}
				$calendar .= '</td>'."\n";
				$j++;
			}
			$calendar .= '</tr>'."\n";
			$i++;
		}

		//-- 2009/06/25 ����No.37 �ɲ�
		//$calendar .= "</table></td><td valign='top'> \n";

		// ���ߤΥ�������ɽ����4���ܤξ��
		if ($m1 == $rows) {
			$calendar .= "</table></td> \n";
		} else {
			$calendar .= "</table></td><td valign='top' width=200> \n";
		}

		// 12��ξ��
		// ��������ɽ������Ԥ���
		if($date[MONTH] == 12) {
			$calendar .= "</td><tr><td colspan=4><hr></td></tr><td valign=top> \n";
			$m1 = $rows; 	//�롼�׽�λ 	
		}
		// ���ߥ�������ɽ�����줿���դȡ���������ɽ���ǽ�����Ʊ���ξ��
		else if($date[YEAR].$date[MONTH].$day == $last_date) {
			$m1 = $rows;	//�롼�׽�λ
		}
		//-----------------------------

	}
	$calendar .= '</tr>'."\n";
}

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

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

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
//	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'calendar'   => "$calendar",
	'onload'     => "$onload",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
