<?php
/********************
 * ͽ�������ɼȯ��
 *
 *
 * �ѹ�����
 *    2006/09/11 (kaji)
 *      ������Ѥ���ɼ�����ٲ��̤򤽤줾����ѹ����̤�freeze���̤��ѹ�
 *    2006/09/20 (kaji)
 *      ������̾���ѹ��������ɼ���ȯ�Ԣ�ͽ�������ɼȯ�ԡ�
 *    2006/10/10 (suzuki)
 *      �������ɽ���������ٸ�������ȥ��顼�ˤʤ�Τ���
 *    2006/10/26 (suzuki)
 *      �����Ψ��0%��ô���Ԥ�ɽ������褦���ѹ�
 *      �����ô���ԡʥᥤ��ˤΤ�ɽ��
 *    2006-10-30 ����ɼ�ѥ��������ꤵ��Ƥ��ʤ�����ȯ�ԺѤˤ��ʤ�<suzuki>
 *    2006-11-01 �����ե����å����ѿ�̾����äƤ����ٽ���<suzuki>
 *    2006-11-02 ����������ɽ������ʬɽ��<suzuki>
 *    2006-12-06 ����ɼ�����ˡ����ơפ��ɲ�<suzuki>
 *
 ********************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/10      02-058      suzuki      ô���ԥ����ɤ�Ⱦ�ѿ��������å����ɲ�
 *  2006/12/07      bun_0060����suzuki���������դ򥼥����
 *  2007/02/22      xx-xxx      kajioka-h   CSV���ϵ�ǽ����
 *  2007/03/01      xx-xxx      watanabe-k  �ܥ���̾�Ȳ���̾���ѹ�
 *  2007/03/14      xx-xxx      watanabe-k  ��ȯ�Խ������ɲ� 
 *  2007/03/22      xx-xxx      watanabe-k  �����ɼ��ɽ�����ʤ����إå��Υܥ���ɽ�� 
 *  2007/03/26      xx-xxx      watanabe-k  ���ô���Խ�˥����Ȥ���褦���ѹ� 
 *  2007/04/12      xx-xxx      morita-d    �������ܤ�¾�β��̤����� 
 *  2007/04/12      xx-xxx      morita-d    ������������������ɲ� 
 *  2007/04/12      xx-xxx      morita-d    ����оݤ�ּ���ơ��֥�פΤߤȤ������ơ��֥�פ�����оݤȤ��ʤ� 
 *  2007/04/13      xx-xxx      morita-d    ������ɽ������褦���ѹ�
 *  2007/04/17      xx-xxx      morita-d    ������̤δ���Ԥ��򡢶����Ԥ��Ф�ɽ������褦���ѹ�
 *  2007/05/22      xx-xxx      watanabe-k  �ܥ���̾����Խ���ɽ����Դ��ֽ���ɽ
 *  2007-06-20                  fukuda      �����ȥ�󥯤Ĥ�����
 *  2007-06-20                  fukuda      �ڡ������ڤ��ؤ��ؿ��������ơ��֥��Ʊ�����ǽФƤ����Զ�罤��
 *  2007-06-20                  fukuda      �٤��ѿ�����®������
 *  2007-07-20                  watanabe-k  ��ɼȯ�Է����ϥޥ����򻲾Ȥ���褦�˽���

 */
$page_title = "ͽ����ɼȯ��";
$s_time = microtime();

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");
require_once(INCLUDE_DIR."function_keiyaku.inc");
require_once(INCLUDE_DIR.(basename($_SERVER["PHP_SELF"].".inc")));  // ���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth      = Auth_Check($db_con);


/****************************/
//�����������
/****************************/
//�����ե�������������
$ary_form_list = array(	
    "form_display_num"  => "1", 	
    "form_client_branch"=> "",  	
    "form_attach_branch"=> "",  	
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""), 	
    "form_round_staff"  => array("cd" => "", "select" => ""), 	
    "form_part"         => "",  	
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""), 	
    "form_multi_staff"  => "",  	
    "form_ware"         => "",  	
    "form_round_day"    => array(	
        "sy" => date("Y"),	
        "sm" => date("m"),	
        "sd" => "01",	
        "ey" => date("Y"),	
        "em" => date("m"),	
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))),	
    "form_charge_fc"    => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_claim_day"    => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 	

    "slip_out"          => "0",
    "slip_flg"          => "0",
    "ord_no"            => "",
    "contract_div"      => "0",
);

// �����������
Restore_Filter($form, "form_show_button", $ary_form_list);


//************************************************
// �����ѿ�����
//************************************************
$shop_id            = $_SESSION["client_id"];

$where              = $_POST;
$display_num        = $_POST["form_display_num"];
$f_page1            = $_POST["f_page1"];
$form_re_slip_check = $_POST["form_re_slip_check"];
$form_slip_check    = $_POST["form_slip_check"];


//************************************************
// �ե��������
//************************************************
// ���̥إå������إܥ���
$form->addElement("button", "2-2-113_button", "��������",       "onClick=\"location.href='2-2-113.php'\"");
$form->addElement("button", "2-2-116_button", "��Դ��ֽ���ɽ", "onClick=\"location.href='2-2-116.php'\"");
$form->addElement("button", "2-2-204_button", "ͽ����ɼȯ��",   $g_button_color."onClick=\"location.href='2-2-204.php'\"");
$form->addElement("button", "2-2-111_button", "����ͽ��в�",   "onClick=\"location.href='2-2-111.php'\"");

// ɸ�ม���ե�����
Search_Form($db_con, $form, $ary_form_list);

// ��ɼ����
$text = null;
$text[] =& $form->createElement("radio", null, null, "����",     "0");
$text[] =& $form->createElement("radio", null, null, "�̾���ɼ", "1");
$text[] =& $form->createElement("radio", null, null, "������ɼ", "2");
$text[] =& $form->createElement("radio", null, null, "¾ɼ", "3");
$form->addGroup($text,"slip_out", "��ɼ����");

// ȯ�Ծ���
$text = null;
$text[] =& $form->createElement("radio", null, null, "����",   "0");
$text[] =& $form->createElement("radio", null, null, "ȯ�Ժ�", "t");
$text[] =& $form->createElement("radio", null, null, "̤ȯ��", "f");
$form->addGroup($text,"slip_flg", "ȯ�Ծ���");

// ��ɼ�ֹ�
$text = null;
$text[] =& $form->createElement("text", "s", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option class=\"num\"");
$text[] =& $form->createElement("text", "e", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option class=\"num\"");
$form->addGroup($text, "ord_no", "��ɼ�ֹ�", "������");

// �����ʬ
$text = null;
$text[] =& $form->createElement("radio", null, null, "����",           "0");
$text[] =& $form->createElement("radio", null, null, "�̾�",           "1");
$text[] =& $form->createElement("radio", null, null, "����饤�����", "2");
// ľ�Ĥξ��
if ($_SESSION["group_kind"] == "2"){
	$text[] =& $form->createElement("radio", null, null, "���ե饤�����", "3");
}
$form->addGroup($text,"contract_div", "�����ʬ");

// �����ȥ��
$ary_sort_item = array(
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_slip"           => "��ɼ�ֹ�",
    "sl_round_day"      => "ͽ������",
    "sl_act_client_cd"  => "����襳����",
    "sl_act_client_name"=> "�����̾",
    "sl_staff"          => "���ô����<br>�ʥᥤ��1��",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_staff");

// ɽ���ܥ���
$form->addElement("submit","form_show_button", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

// �����ɼȯ��ALL
$form->addElement("checkbox", "form_slip_all_check", "", "�����ɼȯ��", "onClick=\"javascript:All_Check_Slip('form_slip_all_check');\"");

// ��ȯ��ALL
$form->addElement("checkbox", "form_re_slip_all_check", "", "��ȯ��", "onClick=\"javascript:All_Check_Re_Slip('form_re_slip_all_check');\"");

// hidden
$form->addElement("hidden","src_module","ͽ����ɼȯ��");    // �����ɼ��PDF�ˤ����ܸ����Τ뤿������
$form->addElement("hidden","hdn_button");                   // ?


//************************************************
// ��������Ƚ��
//************************************************
// ɽ���ܥ��󤬲����줿���ޤ��ϥڡ������إ�󥯤������줿���ޤ��ϥ����ȥ�󥯤������줿���
if ($_POST["form_show_button"] == "ɽ����" || $_POST["switch_page_flg"] == "t" || $_POST["hdn_sort_col"]){
	$action = "ɽ��";

}elseif ($_POST["form_sale_slip"] == "�����ɼȯ��"){
	$action = "ȯ��";

}elseif ($_POST["form_re_sale_slip"] == "�ơ�ȯ����"){
	$action = "��ȯ��";

}else{
	$action = "���ɽ��";
}


/***************************/
// ��ɼȯ�ԥܥ��󤬲����줿���
/***************************/
if ($action == "ɽ��"){
	// ���顼�����å�
	Search_Err_Chk($form);

}elseif ($action == "ȯ��" || $action == "��ȯ��"){

	// �����å����Ĥ��Ƥʤ����
	if($_POST["hdn_button"] == "error"){
		$err_msg = "ȯ�Ԥ�����ɼ����Ĥ����򤵤�Ƥ��ޤ���";
		//$form->setElementError(form_sale_slip, $err_msg);
	}

}


//************************************************
// HTML����
//************************************************
$search_html = Search_Table($form);

// ���ɽ���ʳ��ϸ�����̤����
if($action != "���ɽ��"){

	// �����å�Ŭ��
	$form->validate();
	$err_flg = (count($form->_errors) > 0) ? true : false;

	// ���顼��̵�����
	if(!$err_flg){

		// �����
		$total_count = Get_Slip_Data($db_con, $where, $page_snum, $page_enum, $kind="count");
	
		// ɽ�����������ξ��
		if ($display_num == "1") {
		    $range = $total_count;
		} else {
		    $range = 100;
		}
		
		// ���ߤΥڡ�����������å�����
		$page_info = Check_Page($total_count, $range, $f_page1);
		$page      = $page_info[0];     // ���ߤΥڡ�����
		$page_snum = $page_info[1];     // ɽ�����Ϸ��
		$page_enum = $page_info[2];     // ɽ����λ���
		
		// �ڡ����ץ������ɽ��Ƚ��
		if($page == 1){
		    // �ڡ����������ʤ�ڡ����ץ���������ɽ��
		    $c_page = null;
		}else{
		    // �ڡ�����ʬ�ץ�������ɽ��
		    $c_page = $page;
		}
	
		// �ڡ�������
		$html_page  = Html_Page2($total_count, $c_page, 1, $range);
		$html_page2 = Html_Page2($total_count, $c_page, 2, $range);

		// �ǡ�������
		$search_data = Get_Slip_Data($db_con, $where, $page_snum, $page_enum);
	
		// ɽ���ǡ������
		$match_count = count($search_data);
		$msg = "�����ɼ��ȯ�Ԥ��ޤ���";
		$form->addElement("submit","form_sale_slip", "�����ɼȯ��", "
            onClick=\"javascript:document.dateForm.hdn_button.value = 'ȯ��';
		    return(Post_Blank('$msg','".$_SERVER["PHP_SELF"]."','".FC_DIR."sale/2-2-205.php','__form_slip_check',$match_count))\"
        ");
		
		$form->addElement("submit","form_re_sale_slip", "�ơ�ȯ����", "
            onClick=\"javascript:document.dateForm.hdn_button.value = '��ȯ��';
		    return(Post_Blank('$msg','".$_SERVER["PHP_SELF"]."','".FC_DIR."sale/2-2-205.php','__form_re_slip_check',$match_count))\"
        ");

	}

}

// ������̤�����Ѥ��Ѵ�
$html_search_data   = HTML_Slip_Data($search_data,$form);
$result_html        = $html_search_data["html"];
$result_js          = $html_search_data["js"];


/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-113_button"]]->toHtml();
if($_SESSION["group_kind"] == "2"){
    $page_title .= "��".$form->_elements[$form->_elementIndex["2-2-116_button"]]->toHtml();
}
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-204_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-111_button"]]->toHtml();
$page_header = Create_Header($page_title);


//****************************
// �ƥ�ץ졼�Ƚ���
//****************************
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// �������
$smarty->assign("result_html", $result_html);
$smarty->assign("result_js",   $result_js);

// ����¾���ѿ���assign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
	"html_page"     => "$html_page",
	"html_page2"    => "$html_page2",
	"display_num"   => "$display_num",
	"display_num2"  => "$display_num2",
	"auth_r_msg"    => "$auth_r_msg",
	"search_html"   => "$search_html",
	"action"        => "$action",
	"err_msg"       => "$err_msg",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

/*
$e_time = microtime();
echo "$s_time"."<br>";
echo "$e_time"."<br>";
print_array($_POST);
print_array($_SESSION);
*/

?>
