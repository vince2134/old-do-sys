<?php
/********************
 * ȯ������
 *
 *
 * �ѹ�����
 *   2006/07/06 (kaji)
 *     ��shop_gid��ʤ���
 *   2006/07/19 (kaji)
 *     ���߸˼�ʧ�ơ��֥�ؤν����SQL����
 *       �ʺ�ȶ�ʬȴ���������ȴ����
 *�� 2006/07/21
 *     ���������ʥޥ����Τ˰�ư�������Ȥˤ���ѹ�
 *   �����������׻����ѹ�
 *   2006/07/26 (watanabe-k)
 *���� �����ʤ���о����ѹ�
 *   2006/07/31 (watanabe-k)
 *     �������Ƿ׻������ѹ�
 *   2006/09/16 (fukuda-sss)
 *     �������Ƿ׻������ѹ�
 *   2006/12/01 (suzuki)
 *     ��������۷׻������ѹ�
 *     ���������ѹ����˾��ʽ����
********************/
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2006/10/16  06-001        watanabe-k  ��˽вٲ�ǽ����ʾ����Ϥ�����˾��ʥ����ɤ����Ϥ���Ⱦ���̾��ɽ������ʤ��Х��ν��� 
 *   2006/10/16  06-003        watanabe-k  ȯ�����ٹ�ȯ�����Ϥز������ܤ�����硢���ɲåܥ���򥯥�å��ä��Ƥ����ϹԤ������ʤ��Х��ν���
 *   2006/10/16  06-004        watanabe-k  �߸˾Ȳ�ȯ�����Ϥز������ܤ�����硢��󥿥��२�顼��ȯ������Х��ν���
 *   2006/10/16  06-004        watanabe-k  �߸˾Ȳ�ȯ�����Ϥز������ܤ�����硢��󥿥��२�顼��ȯ������Х��ν���
 *   2006/10/16  06-006        watanabe-k  ����������ȯ����Ԥ�������ȯ���Ȳ��ɽ������ȳݻ�����ɽ�������Х��ν���
 *   2006/10/16  06-007        watanabe-k  ȯ�����ϲ��̤Ǿ���̾��֥�󥯤ˤ���ȯ����Ԥ��ȡ��־��ʤ���Ĥ����򤵤�Ƥ��ޤ��󡣡פȤ�����å�������ɽ�������Х��ν���
 *   2006/10/16  06-004        watanabe-k  �߸˾Ȳ�ȯ�����Ϥز������ܤ�����硢��󥿥��२�顼��ȯ������Х��ν���
 *   2006/10/17  06-018        watanabe-k  �����ʾ��ʥ����ɤ����Ϥ��Ƥ⥨�顼��ɽ������ʤ��Х��ν��� 
 *   2006/10/17  06-019        watanabe-k�����������ñ����aaa,000�ˤ����Ϥ��Ƥ⥨�顼��å�������ɽ������ʤ��Х��ν��� 
 *   2006/10/17  06-022        watanabe-k��ȯ�����Υ��顼��å�����������FC�Ȥǰۤʤ�Х��ν��� 
 *   2006/10/17  06-025        watanabe-k  Ʊ��������Ԥ��ȥ��顼���򤤲��̤ˤʤ�Х��ν���
 *   2006/10/17  06-025        watanabe-k  �����ƥ೫���������������ȯ�����Ǥ��Ƥ��ޤ��Х��ν���
 *   2006/10/17  06-025        watanabe-k  ��ۤξ������ʲ���֥�󥯤ˤ���ȯ������ȥ��顼�ˤʤ�Х��ν���
 * ��2006/10/18  06-024        watanabe-k  Ʊ��������Ԥ��ȥ��顼�ˤʤ�Х��ν���
 * ��2006/10/18  06-038        watanabe-k  URL����SQL���顼��ɽ�������Х��ν���
 * ��2006/10/19  06-040        watanabe-k  ���ʥ����ɤ��������Ϥ����ե����������ư���ʤ��ޤ�ȯ����ǧ���̤إܥ���򥯥�å�����ȡ���ǧ���̤����ܤ��Ƥ��ޤ���
 * ��2006/10/19  06-044        watanabe-k  �����襳���ɤ��������Ϥ����ե����������ư���ʤ��ޤ�ȯ����ǧ���̤إܥ���򥯥�å�����ȡ���ǧ���̤����ܤ��Ƥ��ޤ���
 * ��2006/11/11  06-047        watanabe-k���������ϺѤߤ�ȯ���ǡ������ѹ���ǽ�ʥХ�����
 * ��2006/11/11  06-049        watanabe-k��Ĺ������̾��ɽ������Ƥ��ʤ��Х��ν���
 * ��2006/11/13  06-079        watanabe-k���������ȯ���ѹ����Ǥ��Ƥ��ޤ��Х��ν���
 * ��2006/11/13  06-105        watanabe-k��������λ���ȯ���ѹ��Ǥ��Ƥ��ޤ��Х��ν���
 * ��2006/11/13  06-081        watanabe-k�����åȿ���ʸ��������Ϥ����NaN��ɽ�������Х��ν���
 * ��2007/01/24  �����ѹ�      watanabe-k���ܥ���ο��ѹ�
 * ��2007/02/01                watanabe-k��ȯ�����ľ�����TEL����Ͽ����
 * ��2007/02/05                watanabe-k��ȯ������ɽ�����ʤ��褦�˽���
 *   2007/02/28                  morita-d  ����̾������̾�Τ�ɽ������褦���ѹ� 
 *   2007/03/13                watanabe-k  Ʊ�쾦�ʤ�ʣ�����򤷤����Υ��顼�����Ū��ɽ������褦�˽���
 *   2007/05/18                watanabe-k  ľ����Υץ��������������ѹ�
 *   2007/05/25                  morita-d  ȯ����ϻ�����ޥ����Ǥʤ��ƣåޥ�������Ѥ���褦���ѹ� 
 *   2007/05/25                  morita-d  �ѹ����˾��ʤ�5�ԤޤǤ���ɽ������ʤ��Զ����� 
 *	 2009/06/16	 ����-No.13		 aizawa-m  �߸˾Ȳ�Υ����Ȥ�Ʊ�������ѹ�
 *	 2009/06/17	 �������ޤ�		 aizawa-m  ���ֻ̡�����ۡפΥǥե���Ȥ�0�ǽ��Ϥ�����ѹ�
 *	 2009/09/08			�������� aoyama-n  �Ͱ���ǽ�ɲ�
 *   2009/09/15               hashimoto-y  ���ʤ��Ͱ������ֻ�ɽ���˽���
 *   2009/10/09  rev.1.3        kajioka-h  ľ����ƥ��������ϡ�������������
 *               rev.1.3        kajioka-h  ����åפ��Ȥ˾��ʤκ߸˴����ե饰������ѹ��б�
 *   2009/10/13                 kajioka-h  ȯ���ѹ�����������ô���ԡ�client_charger1�ˤ�t_client.tel�����äƤ����Τ�t_client.charger1�˽���
 *   2009/12/21                 aoyama-n   ��Ψ��TaxRate���饹�������
 *     
 */



$page_title = "ȯ������";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_buy.inc");

$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("ord");
}


/*****************************/
//�����ѿ�����
/*****************************/
//$shop_gid = $_SESSION["shop_gid"];
$shop_id  = $_SESSION["client_id"];
$rank_cd  = $_SESSION["rank_cd"];
$staff_id = $_SESSION["staff_id"];

/*****************************/
//���ɽ������
/*****************************/

#2009-12-21 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($shop_id);

//��ư���֤�ȯ���ֹ����
$sql  = "SELECT";
$sql .= "   MAX(ord_no)";
$sql .= " FROM";
$sql .= "   t_order_h";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= ";"; 

$result = Db_Query($db_con, $sql);
$order_no = pg_fetch_result($result, 0 ,0);
$order_no = $order_no +1;
$order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

$def_data["form_order_no"] = $order_no;

//�в��Ҹ�
$sql  = "SELECT";
$sql .= "   ware_id";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_id = $shop_id";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$def_data["form_ware"] = pg_fetch_result($result, 0, 0);

//�вٲ�ǽ��
$def_data["form_designated_date"] = 7;

//ô����
$def_data["form_staff"] = $staff_id;

//�����ʬ
$def_data["form_trade"] = 21;

//ȯ����
$def_data["form_order_day"]["y"] = date("Y");
$def_data["form_order_day"]["m"] = date("m");
$def_data["form_order_day"]["d"] = date("d");

//��˾Ǽ��
$def_data["form_hope_day"]["y"] = date("Y", mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$def_data["form_hope_day"]["m"] = date("m", mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$def_data["form_hope_day"]["d"] = date("d", mktime(0,0,0,date("m"),date("d")+1,date("Y")));

//����ͽ����
$def_data["form_arrival_day"]["y"] = date("Y", mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$def_data["form_arrival_day"]["m"] = date("m", mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$def_data["form_arrival_day"]["d"] = date("d", mktime(0,0,0,date("m"),date("d")+1,date("Y")));


$form->setDefaults($def_data);

/*****************************/
//�����������̽���
/*****************************/
//��ʬ�ξ����Ǥ����
#2009-12-21 aoyama-n
#$sql  = "SELECT";
#$sql .= "   tax_rate_n";
#$sql .= " FROM";
#$sql .= "   t_client";
#$sql .= " WHERE";
#$sql .= "   client_id = $shop_id";
#$sql .= ";";

#$result = Db_Query($db_con, $sql);
#$tax_rate = pg_fetch_result($result,0,0);
#$rate  = bcdiv($tax_rate,100,2);                //������Ψ

//�ǡ���ɽ���Կ�
if($_POST["max_row"] != NULL){
    $max_row = $_POST["max_row"];
//���ɽ���Τ�
}else{
    $max_row = 5;
}

//������ID��̵ͭ�ˤ�ꡢ��å���������OR�������������
$client_search_flg = ($_POST["hdn_client_id"] != NULL)? true : false;

if($client_search_flg == true){
    //������ξ�������
    $client_id  = $_POST["hdn_client_id"];      //������ID
    $coax       = $_POST["hdn_coax"];           //�ݤ��ʬ
    $tax_franct = $_POST["hdn_tax_franct"];     //ü����ʬ
}else{
    $warning = "����������򤷤Ƥ���������";
    $client_search_flg = false;
}

//����Կ�
$del_history[] = NULL;

//Submit�������˻����ޤ��ǡ���
$goods_id       = $_POST["hdn_goods_id"];
$stock_num      = $_POST["hdn_stock_num"];
$stock_manage   = $_POST["hdn_stock_manage"];
$name_change    = $_POST["hdn_name_change"];

/****************************/
//�ե��������
/****************************/
//ȯ���İ���
$form->addElement("button","ord_button","ȯ���İ���","onClick=\"javascript:location.href='1-3-106.php'\"");
//���ϡ��ѹ�
$form->addElement("button","new_button","������",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�Ȳ�
$form->addElement("button","change_button","�Ȳ��ѹ�","onClick=\"javascript:location.href='1-3-104.php'\"");

//ȯ����
$form->addElement(
    "text","form_send_date","",
    "style=\"color : #000000; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//�вٲ�ǽ��
$form->addElement(
    "text","form_designated_date","",
    "size=\"4\" maxLength=\"4\" 
    $g_form_option 
    style=\"text-align: right; $g_form_style \"
    onChange=\"javascript:Button_Submit('hdn_designated_date_flg','#','t')\""
);

//ȯ���ֹ�
$form->addElement(
    "text","form_order_no","",
    "style=\"color : #000000; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//ȯ����
$form_order_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form,'form_order_day[y]','form_order_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_order_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form, 'form_order_day[m]','form_order_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_order_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\"
    style=\"$g_form_style \" 
    onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_order_day,"form_order_day","","-");

//��˾Ǽ��
$form_hope_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style \" 
    onkeyup=\"changeText(this.form,'form_hope_day[y]','form_hope_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_hope_day[] = $form->createElement(
    "text","m","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \" 
    onkeyup=\"changeText(this.form,'form_hope_day[m]','form_hope_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_hope_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \" 
    onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_hope_day,"form_hope_day","","-");

//����ͽ����
$form_arrival_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style \" 
    onkeyup=\"changeText(this.form,'form_arrival_day[y]','form_arrival_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arrival_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_arrival_day[] = $form->createElement(
    "text","m","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \" 
    onkeyup=\"changeText(this.form,'form_arrival_day[m]','form_arrival_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arrival_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_arrival_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \" 
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arriva_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_arrival_day,"form_arrival_day","","-");


//���꡼�����ȼ�
$select_value = Select_Get($db_con,"trans");
$form->addElement("select", "form_trans",'', $select_value, $g_form_option_select);

//ȯ����
/*
$form_client[] = $form->createElement(
    "text","cd","",
    "size=\"7\" maxLength=\"6\" 
    style=\"$g_form_style \" 
    onChange=\"javascript:Button_Submit('hdn_client_search_flg','#','true')\" 
    $g_form_option"
);
*/
$form_client[] = $form->createElement(
    "text","cd1","",
    "size=\"7\" maxLength=\"6\"
    style=\"$g_form_style\"
    onChange=\"javascript:Change_Submit('hdn_client_search_flg','#','true','form_client[cd2]')\"
    onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"
    $g_form_option"
);
$form_client[] = $form->createElement("static","","","-");
$form_client[] = $form->createElement(
    "text","cd2","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style\"
    onChange=\"javascript:Button_Submit('hdn_client_search_flg','#','true')\"
    $g_form_option"
);
$form_client[] = $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly");
$form->addGroup( $form_client, "form_client", "");

//ľ����
//$select_value = Select_Get($db_con,'direct');
//$form->addElement('select', 'form_direct', "", $select_value,"class=\"Tohaba\"".$g_form_option_select);
//rev.1.3 �ƥ��������Ϥ��ѹ�
$form_direct[] = $form->createElement(
    "text","cd","","size=\"4\" maxLength=\"4\"
     style=\"$g_form_style\"
     onChange=\"javascript:Button_Submit('hdn_direct_search_flg','#','true')\"
     $g_form_option"
);
$form_direct[] = $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly");
$form_direct[] = $form->createElement(
    "text","claim","",
    "size=\"34\" $g_text_readonly");
$form->addGroup($form_direct, "form_direct_text", "");


//�����Ҹ�
$where  = " WHERE";
$where .= "  shop_id = $_SESSION[client_id]";
$where .= "  AND";
$where .= "  nondisp_flg = 'f'";
$select_value = Select_Get($db_con,'ware', $where);
$form->addElement('select', 'form_ware', '', $select_value,$g_form_option_select);

//�����ʬ
$select_value = Select_Get($db_con,'trade_ord');
$form->addElement('select', 'form_trade', '', $select_value,$g_form_option_select);

//ô����
$select_value = Select_Get($db_con,'staff','',true);
$form->addElement('select', 'form_staff', '', $select_value,$g_form_option_select);

//�̿���ʻ����谸��
$form->addElement("textarea","form_note_your",""," rows=\"2\" cols=\"75\" $g_form_option_area");

// �����̿���ʻ����谸��
$form->addElement("textarea","form_note_your2",""," rows=\"4\" cols=\"75\" $g_form_option_area");

//�������(���)
$form->addElement(
        "text","form_buy_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//�����ǳ�(���)
$form->addElement(
        "text","form_tax_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//������ۡ��ǹ����)
$form->addElement(
        "text","form_total_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//hidden
//�����ϥե饰
$form->addElement("hidden", "hdn_client_search_flg");       //�����襳�������ϥե饰
$form->addElement("hidden", "hdn_direct_search_flg");       //rev.1.3 ľ���襳�������ϥե饰
$form->addElement("hidden", "form_direct");                 //rev.1.3 ľ����ID
$form->addElement("hidden", "hdn_goods_search_flg");        //���ʥ��������ϥե饰
$form->addElement("hidden", "hdn_designated_date_flg");     //�вٲ�ǽ�����ϥե饰
$form->addElement("hidden", "hdn_sum_button_flg");          //��ץܥ��󲡲��ե饰
$form->addElement("hidden", "add_row_flg");                 //���ɲåܥ��󲡲��ե饰
//�������ơ�����
$form->addElement("hidden", "hdn_first_disp_flg");          //���ɽ����λ�ե饰
//�����ޤ�������ξ���
$form->addElement("hidden", "hdn_coax");                    //�ݤ��ʬ
$form->addElement("hidden", "hdn_tax_franct");              //ü����ʬ
$form->addElement("hidden", "hdn_client_id");               //������ID
$form->addElement("hidden", "hdn_order_id");                //�ѹ�����ȯ��ID��
$form->addElement("hidden", "hdn_ord_enter_day");           //��Ͽ����
//ɽ���Կ��˴ط��������
$form->addElement("hidden", "del_row");                     //�����
$form->addElement("hidden", "max_row");                     //����Կ�

#2009-09-15 hashimoto-y
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $form->addElement("hidden","hdn_discount_flg[$i]","","");
    }
}


/****************************/
//�Ժ������
/****************************/
if($_POST["del_row"] != NULL){
    $now_form = NULL;
    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);

    //��������ǡ����ξ���ID����NULL�򥻥å�
    for($i = 0; $i < count($del_history); $i++){
        $goods_id[$del_histoty[$i]]     = null;
        $stock_num[$del_history[$i]]    = null;
        $stock_manage[$del_history[$i]] = null;
        $name_change[$del_history[$i]]  = null;
    }
    //��������Կ�
    $del_num     = count($del_history)-1;
}

/****************************/
//�Կ��ɲ�
/****************************/
if($_POST["add_row_flg"]== 'true'){
    //����Ԥˡ��ܣ�����
    $max_row = $_POST["max_row"]+5;

    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//�ƽ���Ƚ��
/****************************/
//�����褬���Ϥ��줿��硢�����踡���ե饰��true�򥻥å�
$client_input_flg = ($_POST["hdn_client_search_flg"] == 'true')? true : false;       //����������Ƚ��ե饰

//rev.1.3 ľ���褬���Ϥ��줿��硢ľ���踡���ե饰��true�򥻥å�
$direct_input_flg = ($_POST["hdn_direct_search_flg"] == 'true') ? true : false;      //ľ��������Ƚ��ե饰

//���ʤ����򤵤줿��硢���ʸ����ե饰��true�򥻥å�
$goods_search_flg = ($_POST["hdn_goods_search_flg"] != NULL)? true : false;       //���ʸ����ե饰

//�вٲ�ǽ�����ѹ����줿��硢�вٲ�ǽ���ѹ��ե饰��ture�򥻥å�
$designated_date_flg = ($_POST["hdn_designated_date_flg"] == 't' && ereg("^[0-9]+$", $_POST["form_designated_date"]))? true : false;  //�вٲ�ǽ���ѹ��ե饰

//��ץܥ��󤬲������줿���
$sum_button_flg = ($_POST["hdn_sum_button_flg"] == 't')? true : false;            //��ץܥ��󲡲��ե饰

//�ѹ��ξ���ord_id��Get���ϤäƤ������ˡ��ѹ��ե饰��true�򥻥å�
$update_flg = ($_GET["ord_id"] != NULL)? true : false;                            //ȯ���ѹ��ե饰
Get_Id_Check3($_GET["ord_id"]);
if($update_flg == false){
    $update_flg = ($_POST["hdn_order_id"] != null)? true : false;
    $get_order_id = $_POST["hdn_order_id"];
}

//�߸�Ĵ��������ȯ�����ٹ𤫤����ܤ��Ƥ������
$get_flg = (count($_GET["order_goods_id"]) > 0)? true : false;                    //�߸�Ĵ��������ȯ�����ٹ𤫤�����ܥե饰
Get_Id_Check3($_GET["order_goods_id"]);

//ȯ���ܥ��󤬲������줿���
$add_ord_flg = ($_POST["form_order_button"] == "ȯ����ǧ���̤�")? true : false;   //ȯ�����ܥ��󲡲��ե饰

//ȯ����λ�ܥ��󤬲������줿���
$add_comp_flg = ($_POST["form_comp_button"] == "ȯ����λ")? true : false;         //ȯ����λ�ܥ��󲡲��ե饰

//ȯ����λ����ɼ���Ϥ��������줿���
$add_comp_slip_flg = ($_POST["form_slip_comp_button"] == "ȯ����λ��ȯ�������")? true : false; //ȯ����λ����ɼ���ϥܥ��󲡲��ե饰

//�߸�Ĵ��������ȯ�����ٹ𤫤����ܤ��Ƥ������ǡ����ɽ��������λ���Ƥ�����true
$first_disp_flg = ($_POST["hdn_first_disp_flg"] == true)? true : false;             //���ɽ����λ�ե饰

/****************************/
//��׽���
/****************************/
//��ץܥ��󲡲��ե饰��true�ξ��
if($sum_button_flg == true || $add_ord_flg == true){
    $buy_data   = $_POST["form_buy_amount"];

    //���������
    $price_data = NULL;
    $tax_div    = NULL;
    //���Ƕ�ʬ
    //������ۤι���ͷ׻�
    for($i=0;$i<$max_row;$i++){
        if($buy_data[$i] != "" && !in_array("$i", $del_history)){
            $price_data[] = $buy_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
        }
    }

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_order_day"]["y"]."-".$_POST["form_order_day"]["m"]."-".$_POST["form_order_day"]["d"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

    //�ե�������ͥ��å�
    $set_data["form_buy_money"]     = number_format($data[0]);
    $set_data["form_tax_money"]     = number_format($data[1]);
    $set_data["form_total_money"]   = number_format($data[2]);
    $set_data["hdn_sum_button_flg"] = "";
}

/****************************/
//���������Ͻ���
/****************************/
//�����踡���ե饰��ture�ξ��
if(true == $client_input_flg){
    //$client_cd = $_POST["form_client"]["cd"];       //�����襳����
    $client_cd1 = $_POST["form_client"]["cd1"];       //�����襳����
    $client_cd2 = $_POST["form_client"]["cd2"];       //�����襳����

    //���ꤵ�줿������ξ�������
    $sql  = "SELECT";
    $sql .= "   client_id,";                        //������ID
    $sql .= "   client_cname,";                      //������̾
    $sql .= "   coax,";                             //�ݤ��ʬ
    $sql .= "   tax_franct,";                        //ü����ʬ
    $sql .= "   buy_trade_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    //$sql .= "   client_cd1 = '$client_cd'";
    //$sql .= "   AND";
    //$sql .= "   client_div = '2'";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '3'";
    $sql .= "   AND";
    //$sql .= "   shop_gid = '$shop_gid'";
    if($_SESSION[group_kind] == "2"){
        $sql .= "   shop_id IN (".Rank_Sql().") ";
    }else{
        $sql .= "   shop_id = $shop_id";
    }

    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_client_data_count = pg_num_rows($result);
    $get_client_data       = pg_fetch_array($result);

    //������������褬���ä����Τ߽�������
    if($get_client_data_count > 0){
        //�ʹߤν����ǻ����ޤ��������ID
        $client_id = $get_client_data["client_id"];

        //��Ф���������ξ���򥻥å�
        $set_data = NULL;
        $set_data["hdn_client_id"]                  = $get_client_data["client_id"];    //������ID
        $set_data["form_client"]["name"]            = $get_client_data["client_cname"];  //������̾
        $set_data["hdn_tax_franct"]                 = $get_client_data["tax_franct"];   //�ݤ��ʬ
        $set_data["hdn_coax"]                       = $get_client_data["coax"];         //ü����ʬ
        $set_data["form_trade"]                     = $get_client_data["buy_trade_id"];     //�����ʬ

        //������������褬����Τǡ������踡���ե饰��Ω�Ƥ�
        //�ٹ��å�����������
        $client_search_flg = true;
        $warning = null;

    //��������ǡ������ʤ��ä����ϡ��������ϺѤߤξ��ʥǡ��������ƽ����
    }else{
        $set_data = NULL;       //���åȤ���ǡ����ν����
        $set_data["hdn_client_id"]                  = "";       //������ID
        $set_data["form_client"]["name"]            = "";       //������̾

        //������������褬�ʤ��Τǡ������踡���ե饰�ˤ�false�򥻥å�
        $client_search_flg = false;
        $warning = "����������Ϥ��Ʋ�������";
    }

    if($get_flg != true){
	    for($i = 0; $i < $max_row; $i++){
            $set_data["hdn_goods_id"][$i]           = "";       //����ID
            $set_data["form_goods_cd"][$i]          = "";       //����CD
            $set_data["form_goods_name"][$i]        = "";       //����̾
            $set_data["hdn_stock_manage"][$i]       = "";       //�߸˴���
            $set_data["hdn_name_change"][$i]        = "";       //��̾�ѹ�
            $set_data["form_stock_num"][$i]         = "";       //��ê��
            $set_data["form_rstock_num"][$i]        = "";       //ȯ���ѿ�
            $set_data["form_rorder_num"][$i]        = "";       //�вٲ�ǽ��
            $set_data["form_designated_num"][$i]    = "";       //������
            $set_data["form_buy_price"][$i]["i"]    = "";       //����ñ������������
            $set_data["form_buy_price"][$i]["d"]    = "";       //����ñ���ʾ�������
            $set_data["hdn_tax_div"][$i]            = "";       //���Ƕ�ʬ
            $set_data["form_in_num"][$i]            = "";       //����
            $set_data["form_buy_amount"][$i]        = "";       //ȯ�����
            $set_data["form_order_num"][$i]         = "";       //ȯ����
            //aoyama-n 
            $set_data["hdn_discount_flg"][$i]       = "";       //�Ͱ��ե饰

            $goods_id[$i]                           = "";       //����ID
            $stock_num[$i]                          = "";       //��ê��(�����)
            $stock_manage[$i]                       = "";       //�߸˴����ʺ߸˿�ɽ��Ƚ���
            $name_change[$i]                        = "";       //��̾�ѹ�����̾�ѹ��ղ�Ƚ���
        } 
	    $max_row = 5;
	    $set_data["max_row"]            = 5;
    }

	$set_data["del_row"]            = "";
	$set_data["form_buy_money"]     = "";
    $set_data["form_tax_money"]     = "";
    $set_data["form_total_money"]   = "";
	//����Կ�
    unset($del_history);
    $del_history[] = NULL;
	$del_row = NULL;

    //�����踡���ե饰������
    $set_data["hdn_client_search_flg"]          = "";                            

/****************************/
//ȯ�����ٹ�OR�߸˾Ȳ񤫤����ܤ��Ƥ������
/****************************/
//���åȥե饰��true && �����踡���ե饰�ξ��
}elseif($get_flg == true && $first_disp_flg === false){

    //GET���ϤäƤ�������ID
    $get_goods_id = $_GET["order_goods_id"];    

    //����ID�򥫥�޶��ڤ�ˤ���
//    $ary_get_goods_id = implode(',',$get_goods_id);

    //GET���ϤäƤ����вٲ�ǽ��
    $designated_date = (ereg("^[0-9]+$", $_GET["designated_date"]))? $_GET["designated_date"] : 0;

    //GET���ϤäƤ���������ˡ�ʸ����ORNULL�����ä����ϥ��顼
    for($i = 0; $i < count($get_goods_id); $i++){
        //������ͤξ��ϥ���޶��ڤ��Ϣ��
        if(ereg("^[0-9]+$", $get_goods_id[$i])){

            if($i > 0){
                $ary_get_goods_id .= ",";
            }

            $ary_get_goods_id .= $get_goods_id[$i];
        }else{
            header("Location:../top.php");
            exit;
        }
    }

    $sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    //$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "   t_goods.goods_cd,\n";
//    $sql .= "   t_goods.goods_cname,\n";
    //$sql .= "   t_goods.goods_name,\n";
    $sql .= "     (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //����̾
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS rack_num,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_stock_io.order_num,0)\n";
    $sql .= "   END AS on_order_num,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//    $sql .= "            - COALESCE(t_allowance_io.allowance_io_num,0)\n";
    $sql .= "   END AS allowance_total,\n";
    $sql .= "   COALESCE(t_stock.stock_num,0)\n";
    $sql .= "    + COALESCE(t_stock_io.order_num,0)\n";
//    $sql .= "    - (COALESCE(t_stock.rstock_num,0)\n";
    $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total,\n";
    $sql .= "   t_price.r_price,\n";
    $sql .= "   t_goods.tax_div,\n";
//    $sql .= "   t_goods_info.in_num\n";
    //aoyama-n 2009-09-08
    #$sql .= "   t_goods.in_num\n";
    $sql .= "   t_goods.in_num,\n";
    $sql .= "   t_goods.discount_flg\n";
    $sql .= " FROM\n";
    $sql .= "   t_goods\n";
    $sql .= "     INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price\n";
    $sql .= "   ON t_goods.goods_id = t_price.goods_id\n";

    $sql .= "       LEFT JOIN\n";

    //�߸˿�
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock.goods_id,\n";
    $sql .= "       SUM(t_stock.stock_num)AS stock_num,\n";
    $sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock.shop_id =  $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_goods.goods_id = t_stock.goods_id\n";

    $sql .= "       LEFT JOIN\n";

    //ȯ���Ŀ�
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num\n";
    $sql .= "            * CASE t_stock_hand.io_div\n";
    $sql .= "               WHEN 1 THEN 1\n";
    $sql .= "               WHEN 2 THEN -1\n";
    $sql .= "       END ) AS order_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = '3'\n";
    $sql .= "       AND\n";
    $sql .= "       t_stock_hand.shop_id =  $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n";
//    $sql .= "       AND\n"; 
    $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io\n";
    $sql .= "   ON t_goods.goods_id=t_stock_io.goods_id\n";

    $sql .= "       LEFT JOIN\n";

    //������
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num\n";
    $sql .= "           * CASE t_stock_hand.io_div\n";
    $sql .= "               WHEN 1 THEN -1\n";
    $sql .= "               WHEN 2 THEN 1\n";
    $sql .= "           END ) AS allowance_io_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = '1'\n";
    $sql .= "       AND\n";
    $sql .= "       t_stock_hand.shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//    $sql .= "       t_stock_hand.work_day > (CURRENT_DATE + $designated_date)\n";
    $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io\n";
    $sql .= "   ON t_goods.goods_id = t_allowance_io.goods_id\n";

	//-- 20090616 �ɲ�
	// �����Ⱦ���Ʊ���ˤ��뤿�ᡢINNER JOIN�ɲ�
	$sql.=	"	INNER JOIN t_g_goods ON t_g_goods.g_goods_id = t_goods.g_goods_id \n"
		.	"	INNER JOIN t_product ON t_product.product_id = t_goods.product_id \n";
	//-------

	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods_info\n";
    $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_id IN ($ary_get_goods_id)\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.public_flg = 't'\n";
    $sql .= "   AND\n";
    $sql .= "   t_price.rank_cd = '1'\n";
    $sql .= "   AND\n";
    //$sql .= "   t_goods.shop_gid = $shop_gid\n";
    if($_SESSION[group_kind] == "2"){
        $sql .= "   t_goods.shop_id IN (".Rank_Sql().") ";
    }else{
        $sql .= "   t_goods.shop_id = $_SESSION[client_id]";
    }

    $sql .= "   AND\n";
    //$sql .= "   t_price.shop_gid = $shop_gid\n";
    if($_SESSION[group_kind] == "2"){
        $sql .= "   t_price.shop_id IN (".Rank_Sql().") ";
    }else{
        $sql .= "   t_price.shop_id = $_SESSION[client_id]";
    }

    $sql .= "   AND\n";
    //$sql .= "   t_goods_info.shop_gid = $shop_gid\n";
//    if($_SESSION[group_kind] == "2"){
//        $sql .= "   t_goods_info.shop_id IN (".Rank_Sql().") ";
//    }else{
        $sql .= "   t_goods_info.shop_id = $_SESSION[client_id]";
//    }

	//-- 2009/06/16 ����No.13 �ɲ�
	// �������ɲ�(�߸˾Ȳ��Ʊ�����)
	$sql.= 	" ORDER BY\n"
		. 	"	t_g_goods.g_goods_cd, \n"
		. 	"	t_product.product_cd, \n"
		. 	"	t_g_product.g_product_id, \n"
		. 	"	t_goods.goods_cd, \n"
		.	"	t_goods.attri_div \n";
	//------

    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    Get_Id_Check($result);
    $get_data_count = pg_num_rows($result);

    $set_data = NULL;       //���åȤ���ǡ����ν����

    //��Ф����쥳���ɿ���롼��
    for($i = 0; $i < $get_data_count; $i++){
        //��Ф����ǡ���
        $get_data = pg_fetch_array($result, $i);

        //��Ф���ñ���ǡ����򥻥åȤ���������ѹ�
        //��Ф���ñ�����ѿ��˥��å�
        $goods_price        = $get_data["r_price"];      //����ñ��
        //ñ�����������Ⱦ�������ʬ����
        $goods_price_data   = explode(".", $goods_price); 

        //��Ф����ǡ���������˥��å�
        $set_data["hdn_goods_id"][$i]          = $get_data["goods_id"];          //����ID
        $set_data["form_goods_cd"][$i]         = $get_data["goods_cd"];          //���ʥ�����
        $set_data["form_goods_name"][$i]       = $get_data["goods_name"];        //����̾
        $set_data["hdn_stock_manage"][$i]      = $get_data["stock_manage"];      //�߸˴���
        $set_data["hdn_name_change"][$i]       = $get_data["name_change"];       //��̾�ѹ�
        $set_data["form_stock_num"][$i]        = $get_data["rack_num"];          //��ê��
        $set_data["hdn_stock_num"][$i]         = $get_data["rack_num"];          //��ê��(hidden��)
        $order_num                             = $get_data["on_order_num"];      //ȯ���ѿ�
        $set_data["form_rorder_num"][$i]       = ($order_num != NULL)? $order_num : '-';
        $rstock_num                            = $get_data["allowance_total"];   //������
        $set_data["form_rstock_num"][$i]       = ($rstock_num != NULL)? $rstock_num : '0';
        $stock_total                           = $get_data["stock_total"];       //�вٲ�ǽ��
        $set_data["form_designated_num"][$i]   = ($stock_total != NULL)? $stock_total : '0';
        $set_data["form_buy_price"][$i]["i"]   = $goods_price_data[0];           //����ñ��
        $set_data["form_buy_price"][$i]["d"]   = $goods_price_data[1];
        $set_data["hdn_tax_div"][$i]           = $get_data["tax_div"];           //���Ƕ�ʬ
        $set_data["form_in_num"][$i]           = $get_data["in_num"];            //����
		//-- 2009/06/17 �������ޤ� �ɲ�
		// �ǥե���Ȥ�0�򥻥å�
		$set_data["form_buy_amount"][$i] = 0;	//�������
		//---

        //aoyama-n 2009-09-08
        $set_data["hdn_discount_flg"][$i]      = $get_data["discount_flg"];      //�Ͱ��ե饰

        //�ʹߤν����ǻ����ޤ����
        $stock_manage[$i]                      = $get_data["stock_manage"];      //�߸˴���
        $stock_num[$i]                         = $get_data["rack_num"];          //�߸˿�
        $name_change[$i]                       = $get_data["name_change"];       //��̾�ѹ�
        $goods_id[$i]                          = $get_data["goods_id"];          //����ID
   }

    //����Կ��򥻥å�
    $max_row = $get_data_count;

    $set_data["hdn_goods_search_flg"]          = "";                             //���ʥ��������ϥե饰������
    $set_data["hdn_first_disp_flg"]            = true;                           //���ɽ����λ�ե饰

/*****************************/
//���ʥ��������Ͻ���
/*****************************/
//���ʸ����ե饰��ture�ξ��
}elseif(true == $goods_search_flg){
    $search_row = $_POST["hdn_goods_search_flg"];                       //���ʸ�����

    $goods_cd  = $_POST["form_goods_cd"][$search_row];                  //�����оݾ��ʥ�����
    
    //�вٲ�ǽ�������������ξ��ϣ�������
    $designated_date = ($_POST["form_designated_date"] != NULL && ereg("^[0-9]+$", $_POST["form_designated_date"]))? $_POST["form_designated_date"] : 0;

    $sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";                                   //����ID
    $sql .= "   t_goods.name_change,\n";                                //��̾�ѹ�
    //$sql .= "   t_goods.stock_manage,\n";                               //�߸˴���
    $sql .= "   t_goods_info.stock_manage,\n";                          //�߸˴��� rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "   t_goods.goods_cd,\n";                                   //���ʥ�����
    //$sql .= "   t_goods.goods_name,\n";                                 //����̾
    $sql .= "     (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //����̾
    //$sql .= "   CASE t_goods.stock_manage\n";                           //��ê��
    $sql .= "   CASE t_goods_info.stock_manage\n";                      //��ê�� rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";       
    $sql .= "       END AS rack_num,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";                           //ȯ���ѿ�
    $sql .= "   CASE t_goods_info.stock_manage\n";                         //ȯ���ѿ� rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_stock_io.order_num,0)\n";
    $sql .= "   END AS on_order_num,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";                           //������
    $sql .= "   CASE t_goods_info.stock_manage\n";                         //������ rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//    $sql .= "        - COALESCE(t_allowance_io.allowance_io_num,0)\n";
    $sql .= "   END AS allowance_total,\n";
    $sql .= "   COALESCE(t_stock.stock_num,0)\n";                       //�вٲ�ǽ��
    $sql .= "       + COALESCE(t_stock_io.order_num,0)\n";
//    $sql .= "       - (COALESCE(t_stock.rstock_num,0)\n";
    $sql .= "       - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total,\n";
    $sql .= "   t_price.r_price,\n";                                    //����ñ��
    $sql .= "   t_goods.tax_div,\n";                                    //���Ƕ�ʬ
//    $sql .= "   t_goods_info.in_num\n";
    //aoyama-n 2009-09-08
    #$sql .= "   t_goods.in_num\n";
    $sql .= "   t_goods.in_num,\n";
    $sql .= "   t_goods.discount_flg\n";
    $sql .= " FROM\n";
    $sql .= "   t_goods \n";
    $sql .= "       INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_price\n";
    $sql .= "   ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "      LEFT JOIN\n";

    //�߸˿�
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock.goods_id,\n";
    $sql .= "       SUM(t_stock.stock_num)AS stock_num, \n";
	$sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock.shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_goods.goods_id = t_stock.goods_id\n";

    $sql .= "       LEFT JOIN \n";

    //ȯ���Ŀ�
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num\n";
    $sql .= "               * CASE t_stock_hand.io_div\n";
    $sql .= "                    WHEN 1 THEN 1\n";
    $sql .= "                    WHEN 2 THEN -1\n";
    $sql .= "       END ) AS order_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = '3' \n";
    $sql .= "       AND\n";
    $sql .= "       t_stock_hand.shop_id =  $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day \n";
//    $sql .= "       AND\n"; 
    $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io\n";
    $sql .= "   ON t_goods.goods_id=t_stock_io.goods_id\n";

    $sql .= "      LEFT JOIN \n";
    //������
    $sql .= "   (SELECT\n";
    $sql .= "        t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div\n";
    $sql .= "                        WHEN 1 THEN -1\n";
    $sql .= "                        WHEN 2 THEN 1\n";
    $sql .= "       END ) AS allowance_io_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = '1'\n";
    $sql .= "       AND\n";
    $sql .= "       t_stock_hand.shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//    $sql .= "       t_stock_hand.work_day > (CURRENT_DATE + $designated_date)\n";
    $sql .= "       t_stock_hand.work_day  <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io\n";
    $sql .= "   ON t_goods.goods_id = t_allowance_io.goods_id\n";

	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods_info\n";
    $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id\n";

    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_cd = '$goods_cd'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.public_flg = 't'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.compose_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.state <> '2'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.accept_flg = '1'\n";
    $sql .= "   AND\n";
    $sql .= "   t_price.rank_cd = '1'\n";
    $sql .= "   AND\n";
    //$sql .= "   t_goods.shop_gid = $shop_gid\n";
    if($_SESSION[group_kind] == "2"){
        $sql .= "   t_goods.shop_id IN (".Rank_Sql().") ";
    }else{
        $sql .= "   t_goods.shop_id = $_SESSION[client_id]";
    }

    $sql .= "   AND\n";
    //$sql .= "   t_price.shop_gid = $shop_gid\n";
    if($_SESSION[group_kind] == "2"){
        $sql .= "   t_price.shop_id IN (".Rank_Sql().") ";
    }else{
        $sql .= "   t_price.shop_id = $_SESSION[client_id]";
    }

	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "   AND\n";
    //$sql .= "   t_goods_info.shop_gid = $shop_gid\n";
//    if($_SESSION[group_kind] == "2"){
//        $sql .= "   t_goods_info.shop_id IN (".Rank_Sql().") ";
//    }else{
        $sql .= "   t_goods_info.shop_id = $_SESSION[client_id]";
//    }

    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $get_goods_data_count   = pg_num_rows($result);
    $get_goods_data         = pg_fetch_array($result);

    //�嵭��SQL�ǳ�������쥳���ɤ����ä����(�����ʾ��ʥ����ɤ����Ϥ��줿���)
    if($get_goods_data_count == 1){
        //��Ф���ñ���ǡ����򥻥åȤ���������ѹ�
        //��Ф���ñ�����ѿ��˥��å�
        $goods_price        = $get_goods_data["r_price"];      //����ñ��
        //ñ�����������Ⱦ�������ʬ����
        $goods_price_data   = explode(".", $goods_price); 

        //���Ǥ�ȯ���������Ϥ���Ƥ�����硢��ۤ�Ʒ׻�����
        //ȯ��������Ƚ��

        if($_POST["form_order_num"][$search_row] != NULL){

            //������ۡ���ȴ��)
            $buy_amount = bcmul($goods_price, $_POST["form_order_num"][$search_row],2);
            $buy_amount = Coax_Col($coax, $buy_amount);
        }

        //��Ф������ʤΥǡ����򥻥å�
        $set_data = NULL;       //���åȤ���ǡ����ν����
        $set_data["hdn_goods_id"][$search_row]          = $get_goods_data["goods_id"];          //����ID
        $set_data["form_goods_name"][$search_row]       = $get_goods_data["goods_name"];        //����̾
        $set_data["hdn_stock_manage"][$search_row]      = $get_goods_data["stock_manage"];      //�߸˴���
        $set_data["hdn_name_change"][$search_row]       = $get_goods_data["name_change"];       //��̾�ѹ�
        $set_data["form_stock_num"][$search_row]        = $get_goods_data["rack_num"];          //��ê��
        $set_data["hdn_stock_num"][$search_row]         = $get_goods_data["rack_num"];          //��ê��(hidden��)
        $order_num                                      = $get_goods_data["on_order_num"];      //ȯ���ѿ�
        $set_data["form_rorder_num"][$search_row]       = ($order_num != NULL)? $order_num : '-';
        $rstock_num                                     = $get_goods_data["allowance_total"];   //������
        $set_data["form_rstock_num"][$search_row]       = ($rstock_num != NULL)? $rstock_num : '0';
        $stock_total                                    = $get_goods_data["stock_total"];       //�вٲ�ǽ��
        $set_data["form_designated_num"][$search_row]   = ($stock_total != NULL)? $stock_total : '0';
        $set_data["form_buy_price"][$search_row]["i"]   = $goods_price_data[0];                 //����ñ��
        $set_data["form_buy_price"][$search_row]["d"]   = $goods_price_data[1];
        $set_data["hdn_tax_div"][$search_row]           = $get_goods_data["tax_div"];           //���Ƕ�ʬ
        $set_data["form_in_num"][$search_row]           = $get_goods_data["in_num"];            //����
        $set_data["form_buy_amount"][$search_row]       = number_format($buy_amount);           //�������
        //aoyama-n 2009-09-08
        $set_data["hdn_discount_flg"][$search_row]      = $get_goods_data["discount_flg"];      //�Ͱ��ե饰


        //�ʹߤν����ǻ����ޤ��ǡ���
        $goods_id[$search_row]                          = $get_goods_data["goods_id"];          //����ID
        $stock_num[$search_row]                         = $get_goods_data["rack_num"];          //��ê��(�����)
        $stock_manage[$search_row]                      = $get_goods_data["stock_manage"];      //�߸˴����ʺ߸˿�ɽ��Ƚ���
        $name_change[$search_row]                       = $get_goods_data["name_change"];       //��̾�ѹ�����̾�ѹ��ղ�Ƚ���

    //�������ͤ����Ϥ��줿���
    }else{
        //��Ф������ʤΥǡ����򥻥å�
        //���åȤ���ǡ����ν����
        $set_data = NULL;       //���åȤ���ǡ����ν����
        $set_data["hdn_goods_id"][$search_row]          = "";       //����ID
        $set_data["form_goods_name"][$search_row]       = "";       //����̾
        $set_data["hdn_stock_manage"][$search_row]      = "";       //�߸˴���
        $set_data["hdn_name_change"][$search_row]       = "";       //��̾�ѹ�
        $set_data["form_stock_num"][$search_row]        = "";       //��ê��
        $set_data["form_rstock_num"][$search_row]       = "";       //ȯ���ѿ�
        $set_data["form_rorder_num"][$search_row]       = "";       //�вٲ�ǽ��
        $set_data["form_designated_num"][$search_row]   = "";       //������
        $set_data["form_buy_price"][$search_row]["i"]   = "";       //����ñ������������
        $set_data["form_buy_price"][$search_row]["d"]   = "";       //����ñ���ʾ�������
        $set_data["hdn_tax_div"][$search_row]           = "";       //���Ƕ�ʬ
        $set_data["form_in_num"][$search_row]           = "";       //����
        $set_data["form_buy_amount"][$search_row]       = "";       //ȯ�����
        $set_data["form_stock_num"][$search_row]        = "";       //��ê��
        $set_data["hdn_stock_num"][$search_row]         = "";       //��ê��(hidden��)
        $set_data["form_order_num"][$search_row]        = "";       //ȯ����
        //aoyama-n 2009-09-08
        $set_data["hdn_discount_flg"][$search_row]      = "";       //�Ͱ��ե饰	

        $goods_id[$search_row]                          = null;     //����ID
        $stock_num[$search_row]                         = null;     //��ê��(�����)
        $stock_manage[$search_row]                      = null;     //�߸˴����ʺ߸˿�ɽ��Ƚ���
        $name_change[$search_row]                       = null;     //��̾�ѹ�����̾�ѹ��ղ�Ƚ���
    }

    //�������ϥե饰������
    $set_data["hdn_goods_search_flg"] = "";

/****************************/
//�вٲ�ǽ���Ʒ׻�����
/****************************/
//�вٲ�ǽ���ѹ��ե饰��ture�ξ��
}elseif(true === $designated_date_flg){

    //���Ϥ��줿�в�ͽ����
    $designated_date = $_POST["form_designated_date"];

    //���Ϥ���Ƥ��뾦�ʤξ���ID
    $ary_goods_id = $_POST["hdn_goods_id"];

    //ɽ������Ƥ��뾦�����ϹԿ�ʬ�롼��
    for($i = 0; $i < $max_row; $i++){
        //���ʤ����Ϥ���Ƥ���ԤΤ߽�������
        if($ary_goods_id[$i] != NULL){
            $sql  = "SELECT\n";
            $sql .= "   t_goods.goods_id,\n";
            $sql .= "   t_goods.name_change,\n";
            //$sql .= "   t_goods.stock_manage,\n";
            $sql .= "   t_goods_info.stock_manage,\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
            $sql .= "   t_goods.goods_cd,\n";
            $sql .= "   t_goods.goods_name,\n";
            //$sql .= "   CASE t_goods.stock_manage\n";
            $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
            $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
            $sql .= "   END AS rack_num,\n";
            //$sql .= "   CASE t_goods.stock_manage\n";
            $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
            $sql .= "       WHEN 1 THEN COALESCE(t_stock_io.order_num,0)\n";
            $sql .= "    END AS on_order_num,\n";
            //$sql .= "   CASE t_goods.stock_manage\n";
            $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
            $sql .= "       WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//            $sql .= "                    - COALESCE(t_allowance_io.allowance_io_num,0)\n";
            $sql .= "   END AS allowance_total,\n";
            $sql .= "   COALESCE(t_stock.stock_num,0)\n";
            $sql .= "    + COALESCE(t_stock_io.order_num,0)\n";
//            $sql .= "    - (COALESCE(t_stock.rstock_num,0)\n";
            $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total,\n";
            $sql .= "   t_price.r_price,\n";
            $sql .= "   t_goods.tax_div\n";
            $sql .= " FROM\n";
            $sql .= "   t_goods\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_price\n";
            $sql .= "   ON t_goods.goods_id = t_price.goods_id\n";
            $sql .= "   LEFT JOIN\n";

            //�߸˿�
            $sql .= "   (SELECT\n";
            $sql .= "       t_stock.goods_id,\n";
            $sql .= "       SUM(t_stock.stock_num)AS stock_num,\n";
            $sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
            $sql .= "   FROM\n";
            $sql .= "       t_stock\n";
            $sql .= "           INNER JOIN\n";
            $sql .= "       t_ware\n";
            $sql .= "       ON t_stock.ware_id = t_ware.ware_id\n";
            $sql .= "   WHERE\n";
            $sql .= "        t_stock.shop_id = $shop_id\n";
            $sql .= "        AND\n";
            $sql .= "        t_ware.count_flg = 't'\n";
            $sql .= "   GROUP BY t_stock.goods_id\n";
            $sql .= "   )AS t_stock\n";
            $sql .= "   ON t_goods.goods_id = t_stock.goods_id\n";

            $sql .= "       LEFT JOIN\n";

            //ȯ���Ŀ�
            $sql .= "   (SELECT\n";
            $sql .= "       t_stock_hand.goods_id,\n";
            $sql .= "       SUM(t_stock_hand.num\n";
            $sql .= "           * CASE t_stock_hand.io_div\n";
            $sql .= "               WHEN 1 THEN 1\n";
            $sql .= "               WHEN 2 THEN -1\n";
            $sql .= "       END ) AS order_num\n";
            $sql .= "   FROM\n";
            $sql .= "       t_stock_hand\n";
            $sql .= "           INNER JOIN\n";
            $sql .= "       t_ware\n";
            $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
            $sql .= "   WHERE\n";
            $sql .= "       t_stock_hand.work_div = 3\n";
            $sql .= "       AND\n";
            $sql .= "       t_stock_hand.shop_id = $shop_id\n";
            $sql .= "       AND\n";
            $sql .= "       t_ware.count_flg = 't'\n";
            $sql .= "       AND\n";
//            $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n";
//            $sql .= "       AND\n";
            $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
            $sql .= "   GROUP BY t_stock_hand.goods_id\n";
            $sql .= "   ) AS t_stock_io\n";
            $sql .= "   ON t_goods.goods_id=t_stock_io.goods_id\n";

            $sql .= "       LEFT JOIN \n";

            //������
            $sql .= "   (SELECT\n";
            $sql .= "       t_stock_hand.goods_id,\n";
            $sql .= "       SUM(t_stock_hand.num\n";
            $sql .= "            * CASE t_stock_hand.io_div\n";
            $sql .= "               WHEN 1 THEN -1\n";
            $sql .= "               WHEN 2 THEN 1\n";
            $sql .= "       END ) AS allowance_io_num\n";
            $sql .= "   FROM\n";
            $sql .= "       t_stock_hand\n";
            $sql .= "           INNER JOIN\n";
            $sql .= "       t_ware\n";
            $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
            $sql .= "   WHERE\n";
            $sql .= "       t_stock_hand.work_div = 1\n";
            $sql .= "       AND\n";
            $sql .= "       t_stock_hand.shop_id = $shop_id\n";
            $sql .= "       AND\n";
            $sql .= "       t_ware.count_flg = 't'\n";
            $sql .= "       AND\n";
//            $sql .= "       t_stock_hand.work_day > (CURRENT_DATE + $designated_date)\n";
            $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
            $sql .= "   GROUP BY t_stock_hand.goods_id\n";
            $sql .= "   ) AS t_allowance_io\n";
            $sql .= "   ON t_goods.goods_id = t_allowance_io.goods_id\n";

			$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";    //rev.1.3 ����åפ��Ȥ˺߸˴����ե饰

            $sql .= " WHERE\n";
            $sql .= "   t_goods.goods_id = $goods_id[$i]\n";
            $sql .= "   AND\n";
            $sql .= "   t_goods.public_flg = 't'\n";
            $sql .= "   AND\n";
            $sql .= "   t_price.rank_cd = '1'\n";

			//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
            $sql .= "    AND \n";
            $sql .= "    t_goods_info.shop_id = $shop_id \n";

            $sql .= ";\n";  

            $result = Db_Query($db_con, $sql);
            $get_designated_data = pg_fetch_array($result);

            //��Ф������ʤΥǡ����򥻥å�
            $set_data = NULL;       //���åȤ���ǡ����ν����
//            $set_data["hdn_goods_id"][$i]           = $get_designated_data["goods_id"];          //����ID
//            $set_data["form_goods_name"][$i]        = $get_designated_data["goods_name"];        //����̾
//            $set_data["hdn_stock_manage"][$i]       = $get_designated_data["stock_manage"];      //�߸˴���
//            $set_data["hdn_name_change"][$i]        = $get_designated_data["name_change"];       //��̾�ѹ�
            $set_data["form_stock_num"][$i]         = $get_designated_data["stock_num"];         //��ê��
            $order_num      = $get_designated_data["on_order_num"];                              //ȯ���ѿ�
            $set_data["form_rorder_num"][$i]        = ($order_num != NULL)? $order_num : '-';
            $rstock_num     = $get_designated_data["allowance_total"];                           //������
            $set_data["form_rstock_num"][$i]        = ($rstock_num != NULL)? $rstock_num : '0';
            $stock_total    = $get_designated_data["stock_total"];                               //�вٲ�ǽ��
            $set_data["form_designated_num"][$i]    = ($stock_total != NULL)? $stock_total : '0';
//            $set_data["form_buy_price"][$i]["i"]    = $goods_price_data[0];                      //����ñ��
//            $set_data["form_buy_price"][$i]["d"]    = $goods_price_data[1];
//            $set_data["hdn_tax_div"][$i]            = $get_designated_data["tax_div"];           //���Ƕ�ʬ
//            $set_data["form_in_num"][$i]            = $get_designated_data["in_num"];            //����
//            $set_data["form_buy_amount"][$i]        = number_format($buy_amount);                //�������

            //�ʹߤν����ǻ����ޤ��ǡ���
//            $goods_id[$i]                           = $get_designated_data["goods_id"];          //����ID              
            $stock_num[$i]                          = $get_designated_data["rack_num"];          //��ê��(�����)
//            $stock_manage[$i]                       = $get_designated_data["stock_manage"];      //�߸˴����ʺ߸˿�ɽ��Ƚ���
//            $name_change[$i]                        = $get_designated_data["name_change"];       //��̾�ѹ�����̾�ѹ��ղ�Ƚ���
        }
        //�вٲ�ǽ�����ϥե饰������
        $set_data["hdn_designated_date_flg"] = "";
    }

//--------------------------//
// rev.1.3 ľ�������Ͻ���
//--------------------------//
//ľ���踡���ե饰��true�ξ��
}elseif($direct_input_flg){
	$direct_cd = $_POST["form_direct_text"]["cd"];

	//���ꤵ�줿ľ����ξ�������
	$sql  = "SELECT \n";
	$sql .= "    direct_id, \n";            //ľ����ID
	$sql .= "    direct_cd, \n";            //ľ���襳����
	$sql .= "    direct_name, \n";          //ľ����̾
	$sql .= "    direct_cname, \n";         //ά��
	$sql .= "    t_client.client_cname \n"; //������
	$sql .= "FROM \n";
	$sql .= "    t_direct \n";
	$sql .= "    LEFT JOIN t_client ON t_direct.client_id = t_client.client_id \n";
	$sql .= "WHERE \n";
	$sql .= "    t_direct.shop_id = $shop_id \n";
	$sql .= "    AND \n";
	$sql .= "    t_direct.direct_cd = '$direct_cd' \n";
	$sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_direct_data_count = pg_num_rows($result);
    $get_direct_data       = pg_fetch_array($result);

    //��������ľ���褬���ä����Τ߽�������
    if($get_direct_data_count > 0){
        //��Ф���ľ����ξ���򥻥å�
        $set_data = NULL;
        $set_data["form_direct"]				= $get_direct_data["direct_id"];	//ľ����ID
        $set_data["form_direct_text"]["name"]	= $get_direct_data["direct_cname"];	//ľ����̾ά��
        $set_data["form_direct_text"]["claim"]	= $get_direct_data["client_cname"];	//������

    //��������ǡ������ʤ��ä����ϡ��������ϥǡ��������ƽ����
    }else{
        $set_data = NULL;
        $set_data["form_direct"]                = "";	//ľ����ID
        $set_data["form_direct_text"]["cd"]     = "";   //ľ���襳����
        $set_data["form_direct_text"]["name"]   = "";   //ľ����̾ά��
        $set_data["form_direct_text"]["claim"]  = "";   //������
	}

    //ľ���踡���ե饰������
    $set_data["hdn_direct_search_flg"]          = "";

}


/****************************/
//�͸���
/****************************/
//ȯ����ǧ�إܥ��󲡲��ե饰��true
//  OR
//ȯ����λ�ܥ��󲡲��ե饰��true
//  OR
//ȯ����λ��ȯ������ϥܥ��󲡲��ե饰��true
//�ξ��
if($add_ord_flg == true || $add_comp_flg == true || $add_comp_slip_flg == true){

    //�롼�����
    //������
    //ɬ�ܥ����å�
    $form->addGroupRule('form_client', array(
            //'cd' => array(
            //        array('�����������襳���ɤ����Ϥ��Ƥ���������', 'required')
            //),
            'cd1' => array(
                    array('�����������襳���ɤ����Ϥ��Ƥ���������', 'required')
            ),
            'cd2' => array(
                    array('�����������襳���ɤ����Ϥ��Ƥ���������', 'required')
            ),
            'name' => array(
                    array('�����������襳���ɤ����Ϥ��Ƥ���������','required')
            )
    ));

    //�вٲ�ǽ��
    $form->addRule("form_designated_date","ȯ���ѿ��Ȱ��������θ����������Ⱦ�ѿ��ͤΤߤǤ���","regex", '/^[0-9]+$/');

    //ȯ����
    //��ɬ�ܥ����å�
    $form->addGroupRule('form_order_day', array(
            'y' => array(
                    array('������ȯ���������Ϥ��Ƥ���������', 'required'),
                    array('������ȯ���������Ϥ��Ƥ���������', 'numeric')
            ),
            'm' => array(
                    array('������ȯ���������Ϥ��Ƥ���������','required'),
                    array('������ȯ���������Ϥ��Ƥ���������','numeric')
            ),
            'd' => array(
                    array('������ȯ���������Ϥ��Ƥ���������','required'),
                    array('������ȯ���������Ϥ��Ƥ���������','numeric')
            )
    ));
    //�����ƥ೫����


    //��˾Ǽ��
    //��Ⱦ�ѥ����å�
    $form->addGroupRule('form_hope_day', array(
            'y' => array(
                    array('��������˾Ǽ�������Ϥ��Ƥ���������', 'numeric')
            ),
            'm' => array(
                    array('��������˾Ǽ�������Ϥ��Ƥ���������','numeric')
            ),
            'd' => array(
                    array('��������˾Ǽ�������Ϥ��Ƥ���������','numeric')
            )
    ));

    //����ͽ����
    //��Ⱦ�ѥ����å�
    $form->addGroupRule('form_arrival_day', array(
            'y' => array(
                    array('����������ͽ���������Ϥ��Ƥ���������', 'numeric')
            ),      
            'm' => array(
                    array('����������ͽ���������Ϥ��Ƥ���������','numeric')
            ),      
            'd' => array(
                    array('����������ͽ���������Ϥ��Ƥ���������','numeric')
            )       
    ));

    //�����Ҹ�
    //��ɬ�ܥ����å�
    $form->addRule("form_ware","�����Ҹˤ����򤷤Ƥ���������","required");

    //�����ʬ
    //��ɬ�ܥ����å�
    $form->addRule("form_trade","�����ʬ�����򤷤Ƥ���������","required");    

    //ô����
    //��ɬ�ܥ����å�
    $form->addRule("form_staff","ô���Ԥ����򤷤Ƥ���������","required");


    //�̿���   //��ʸ���������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note_your","�̿���ʻ����谸�ˤ�95ʸ������Ǥ���","mb_maxlength","95");

    // �����̿���
    // ��ʸ���������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note_your2", "�����̿���ʻ����谸�ˤ�200ʸ������Ǥ���", "mb_maxlength", "200");

    //POST����
    $designated_date    = $_POST["form_designated_date"];               //�вٲ�ǽ��
    $order_no           = $_POST["form_order_no"];                      //ȯ���ֹ�
    $order_day["y"]     = $_POST["form_order_day"]["y"];                //ȯ������ǯ��
    $order_day["m"]     = $_POST["form_order_day"]["m"];                //ȯ�����ʷ��
    $order_day["d"]     = $_POST["form_order_day"]["d"];                //ȯ����������
    $hope_day["y"]      = $_POST["form_hope_day"]["y"];                 //��˾Ǽ����ǯ��
    $hope_day["m"]      = $_POST["form_hope_day"]["m"];                 //��˾Ǽ���ʷ��
    $hope_day["d"]      = $_POST["form_hope_day"]["d"];                 //��˾Ǽ��������
    $arrival_day["y"]   = $_POST["form_arrival_day"]["y"];              //����ͽ������ǯ��
    $arrival_day["m"]   = $_POST["form_arrival_day"]["m"];              //����ͽ�����ʷ��
    $arrival_day["d"]   = $_POST["form_arrival_day"]["d"];              //����ͽ����������
    $trade              = $_POST["form_trade"];                         //�����ʬ
    $direct             = $_POST["form_direct"];
    $trans              = $_POST["form_trans"];                         //�����ȼ�
    $staff              = $_POST["form_staff"];                         //ô����ID
    $ware               = $_POST["form_ware"];                          //�Ҹ�ID 
    $note_your          = $_POST["form_note_your"];                     //����
    $note_your2         = $_POST["form_note_your2"];                    // �����̿���
    //$client_cd          = $_POST["form_client"]["cd"];                  //�����襳����
    $client_cd1         = $_POST["form_client"]["cd1"];                  //�����襳����
    $client_cd2         = $_POST["form_client"]["cd2"];                  //�����襳����
    $client_id          = $_POST["hdn_client_id"];

    //�����ȼԤΥ��꡼��ե饰�����
    if($trans != null){
        $sql  = "SELECT";
        $sql .= "   green_trans";
        $sql .= " FROM";    
        $sql .= "   t_trans";   
        $sql .= " WHERE";   
        $sql .= "   trans_id = $trans";     
        $sql .= ";";

        $result = Db_Query($db_con, $sql);    
        $trans_flg = pg_fetch_result($result ,0,0);
    }else{
        $trans     = null;
        $trans_flg = 'f';   
    }


    //����������å�
    $sql  = "SELECT";
    $sql .= "   COUNT(client_id) ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    //$sql .= "   client_cd1 = '$client_cd'";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $client_num = pg_fetch_result($result, 0,0);

    if($client_num != 1){
        $form->setElementError("form_client", "���������������� ȯ����ǧ���̤إܥ��� <br>��������ޤ�����������ľ���Ƥ���������");
    //}elseif($client_cd != null){
    }elseif($client_cd1 != null && $client_cd2 != null){
        //�ͤ�����å�����ؿ�
        $check_data = Row_Data_Check(
                                 $_POST[hdn_goods_id],                          //����ID
                                 $_POST[form_goods_cd],                         //���ʥ�����
                                 $_POST[form_goods_name],                       //����̾
                                 $_POST[form_order_num],                        //ȯ����
                                 $_POST[form_buy_price],                        //����ñ��
                                 str_replace(',','',$_POST[form_buy_amount]),   //�������
                                 $_POST[hdn_tax_div],                           //���Ƕ�ʬ
                                 $del_history,                                  //�Ժ������
                                 $max_row,                                      //����Կ�
                                 'ord',                                         //��ʬ
                                 //aoyama-n 2009-09-08
                                 #$db_con                                        //DB���ͥ���
                                 $db_con,                                        //DB���ͥ���
                                 null,
                                 null,
                                 null,
                                 null,
                                 $_POST[hdn_discount_flg]                        //�Ͱ��ե饰
                                );
        //�ѿ������
        $goods_id   = null;
        $goods_cd   = null;
        $goods_name = null;
        $order_num  = null;
        $buy_price  = null;
        $buy_amount = null;
        $tax_div    = null;

        //���顼�����ä����
        if($check_data[0] === true){
            //���ʤ���Ĥ����򤵤�Ƥ��ʤ����
            $form->setElementError("form_buy_money",$check_data[1]);

            //���������ʥ����ɤ����Ϥ���Ƥ��ʤ����
            $goods_err = $check_data[2];

            //ȯ�����Ȼ���ñ�������Ϥ����뤫
            $price_num_err = $check_data[3];

            //ȯ����Ⱦ�ѿ��������å�
            $num_err = $check_data[4];

            //ñ��Ⱦ�ѥ����å�
            $price_err = $check_data[5];

            $err_flg = true;
        //���顼���ʤ��ä����
        }else{

            //��Ͽ�оݥǡ������ѿ��˥��å�
            $goods_id   = $check_data[1][goods_id];
            $goods_cd   = $check_data[1][goods_cd];
            $goods_name = $check_data[1][goods_name];
            $order_num  = $check_data[1][num];
            $buy_price  = $check_data[1][price];
            $buy_amount = $check_data[1][amount];
            $tax_div    = $check_data[1][tax_div];
            $def_line   = $check_data[1][def_line];
        }
    }

    /******************************/
    //PHP�ǥ����å�
    /******************************/

    //ȯ�������������������å�
    if(!checkdate((int)$order_day["m"], (int)$order_day["d"], (int)$order_day["y"])){
        $form->setElementError("form_order_day", "ȯ���������դ������ǤϤ���ޤ���");
    }else{
        //�����ƥ೫���������å�
        //ȯ����
        $order_day_err   = Sys_Start_Date_Chk($order_day["y"], $order_day["m"], $order_day["d"], "ȯ����");
        if($order_day_err != Null){
            $form->setElementError("form_order_day", $order_day_err);
        }
    }

    //��˾Ǽ�������å�
    if($hope_day["m"] != null || $hope_day["d"] != null || $hope_day["y"] != null){
        $hope_day_input_flg = true;
    }
    if(!checkdate((int)$hope_day["m"], (int)$hope_day["d"], (int)$hope_day["y"]) && $hope_day_input_flg == true){
        $form->setElementError("form_hope_day", "��˾Ǽ�������դ������ǤϤ���ޤ���");
    }else{
        //��˾Ǽ��
        $hope_day_err    = Sys_Start_Date_Chk($hope_day["y"], $hope_day["m"], $hope_day["d"], "��˾Ǽ��");
        if($hope_day_err != null){
            $form->setElementError("form_hope_day", $hope_day_err);
        }
    }
 
    //����ͽ���������å�
    if($arrival_day["m"] != null || $arrival_day["d"] != null || $arrival_day["y"] != null){
        $arrival_day_input_flg = true;
    }

    if(!checkdate((int)$arrival_day["m"], (int)$arrival_day["d"], (int)$arrival_day["y"]) && $arrival_day_input_flg == true){
        $form->setElementError("form_arrival_day", "����ͽ���������դ������ǤϤ���ޤ���");
    }else{
        //����ͽ����
        $arrival_day_err = Sys_Start_Date_Chk($arrival_day["y"], $arrival_day["m"], $arrival_day["d"], "����ͽ����");
        if($arrival_day_err != null){
            $form->setElementError("form_arrival_day", $arrival_day_err); 
        }
    }

    //���ʥ����å�
    //���ʽ�ʣ�����å�
    $goods_count = count($goods_id);
    for($i = 0; $i < $goods_count; $i++){

        //���˥����å��Ѥߤξ��ʤξ��ώ������̎�
        if(@in_array($goods_id[$i], $checked_goods_id)){
            continue;
        }

        //�����å��оݤȤʤ뾦��
        $err_goods_cd = $goods_cd[$i];
        $mst_line = $def_line[$i];

        for($j = $i+1; $j < $goods_count; $j++){
            //���ʤ�Ʊ�����
            if($goods_id[$i] == $goods_id[$j]) {
                $duplicate_line .= ", ".($def_line[$j]);
            }
        }
        $checked_goods_id[] = $goods_id[$i];    //�����å��Ѥ߾���

        if($duplicate_line != null){
            $duplicate_goods_err[] =  "���ʥ����ɡ�".$err_goods_cd."�ξ��ʤ�ʣ�����򤵤�Ƥ��ޤ���(".$mst_line.$duplicate_line."����)";
        }

        $err_goods_cd   = null;
        $mst_line       = null;
        $duplicate_line = null;
    }

    //����
    //���顼���ʤ�����������
    if($form->validate() && $err_flg != true){

        //ȯ���ǡ�����Ͽ����
        //ȯ����λ�ܥ��󲡲��ե饰��true
        //  OR
        //ȯ����λ��ȯ������ϥܥ��󲡲��ե饰��true�ξ��
        if($add_comp_flg == true || $add_comp_slip_flg == true){
            //���դ���
            $hope_date      = $hope_day["y"]."-".$hope_day["m"]."-".$hope_day["d"];     //��˾Ǽ��
            $order_date     = $order_day["y"]."-".$order_day["m"]."-".$order_day["d"];  //ȯ����
            $arrival_date   = $arrival_day["y"]."-".$arrival_day["m"]."-".$arrival_day["d"];  //ȯ����

            #2009-12-21 aoyama-n
            $tax_rate_obj->setTaxRateDay($order_date);
            $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

            //��ȴ��ס������Ƕ�ۤ򻻽�
            for($i = 0; $i < count($goods_id); $i++){
                $total_amount_data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);
            }

            Db_Query($db_con, "BEGIN;");

            //�ѹ�����
            //�ѹ��ե饰��true�ξ��
            if($update_flg == true){

                //ȯ�����������Ƥ��ʤ������ǧ
                $update_check_flg = Update_Check($db_con, "t_order_h", "ord_id", $get_order_id, $_POST["hdn_ord_enter_day"]);
                //���˺������Ƥ������
                if($update_check_flg === false){ 
                    header("Location: ./1-3-103.php?ord_id=$get_order_id&output_flg=delete");
                    exit;   
                }       

                //��������λ����Ƥ��ʤ������ǧ
                $finish_check_flg = Finish_Check($db_con, "t_order_h", "ord_id", $get_order_id);
                //���˴�λ���Ƥ������
                if($finish_check_flg === false){
                    header("Location: ./1-3-103.php?ord_id=$get_order_id&output_flg=finish");
                    exit;
                }

                //ȯ���إå��򥢥åץǡ���
                $sql  = "UPDATE t_order_h SET\n";
                $sql .= "   ord_no = '$order_no',";                                             //ȯ���ֹ�
                $sql .= "   client_id = $client_id,";                                           //������ID
                $sql .= ($direct != null) ? " direct_id = $direct,\n" : " direct_id = NULL, ";  //ľ����ID
                $sql .= "   trade_id  = '$trade',\n";                                           //�����ʬ
                $sql .= "   green_flg = '$trans_flg',\n";                                       //���꡼��ե饰
                $sql .= ($trans != null) ? " trans_id = '$trans',\n" : " trans_id = NULL, ";    //�����ȼ�
                $sql .= "   ord_time  = '$order_date',\n";                                      //ȯ����
                //��˾Ǽ�������Ϥ��줿���
                if($hope_date != '--'){
                    $sql .= "   hope_day = '$hope_date',\n";                                    //��˾Ǽ��
                //��˾Ǽ�������Ϥ���ʤ��ä����
                }else{
                    $sql .= "   hope_day = null,\n";
                }

                //����ͽ���������Ϥ��줿���
                if($arrival_date != '--'){
                    $sql .= "   arrival_day = '$arrival_date',\n";
                //����ͽ���������Ϥ���ʤ��ä����
                }else{
                    $sql .= "   arrival_day = null,\n";
                }
                $sql .= "   note_your = '$note_your',\n";               //�̿���
                $sql .= "   note_your2 = '$note_your2',\n";             // �����̿���
                $sql .= "   c_staff_id = $staff,\n";                    //ô����ID
                $sql .= "   ware_id = $ware,\n";                        //�Ҹ�ID 
                $sql .= "   ord_staff_id = $staff_id,\n";               //ȯ����ID
                $sql .= "   net_amount = $total_amount_data[0],\n";     //��ȴ���
                $sql .= "   tax_amount = $total_amount_data[1],\n";     //�����ǳ�
                $sql .= "   client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   c_shop_name1 = (SELECT shop_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   c_shop_name2 = (SELECT shop_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_post_no1 = (SELECT post_no1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_post_no2 = (SELECT post_no2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_address1 = (SELECT address1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_address2 = (SELECT address2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_address3 = (SELECT address3 FROM t_client WHERE client_id = $client_id), ";
                //$sql .= "   client_charger1 = (SELECT tel FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   client_charger1 = (SELECT charger1 FROM t_client WHERE client_id = $client_id), ";	//kajioka-h 2009/10/13
                $sql .= "   client_tel = (SELECT tel FROM t_client WHERE client_id = $client_id), ";
                $sql .= ($direct != null) ? " direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct), " : " direct_name = NULL, ";
                $sql .= ($direct != null) ? " direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), " : " direct_name2 = NULL, ";
                $sql .= ($direct != null) ? " direct_cname = (SELECT direct_cname FROM t_direct WHERE direct_id = $direct), " : " direct_cname = NULL, ";
                $sql .= ($direct != null) ? " direct_post_no1 = (SELECT post_no1 FROM t_direct WHERE direct_id = $direct), " : " direct_post_no1 = NULL, ";
                $sql .= ($direct != null) ? " direct_post_no2 = (SELECT post_no2 FROM t_direct WHERE direct_id = $direct), " : " direct_post_no2 = NULL, ";
                $sql .= ($direct != null) ? " direct_address1 = (SELECT address1 FROM t_direct WHERE direct_id = $direct), " : " direct_address1 = NULL, ";
                $sql .= ($direct != null) ? " direct_address2 = (SELECT address2 FROM t_direct WHERE direct_id = $direct), " : " direct_address2 = NULL, ";
                $sql .= ($direct != null) ? " direct_address3 = (SELECT address3 FROM t_direct WHERE direct_id = $direct), " : " direct_address3 = NULL, ";
                $sql .= ($direct != null) ? " direct_tel = (SELECT tel FROM t_direct WHERE direct_id = $direct), " : " direct_tel = NULL, ";
                $sql .= ($trans != null) ? " trans_name = (SELECT trans_name FROM t_trans WHERE trans_id = $trans), " : "trans_name = NULL, ";
                $sql .= "   ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";
                $sql .= "   c_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $staff), ";
                $sql .= "   ord_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), ";
                $sql .= "   client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id),";
                $sql .= "   change_day = CURRENT_TIMESTAMP";
                $sql .= " WHERE";
                $sql .= "    ord_id = $get_order_id";            //ȯ��ID
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //ȯ���ǡ�������
                $sql  = "DELETE FROM";
                $sql .= "    t_order_d";
                $sql .= " WHERE";
                $sql .= "    ord_id = $get_order_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

            //������Ͽ����
            }else{
                //ȯ���إå��ơ��֥����Ͽ
                $sql  = "INSERT INTO t_order_h (\n";
                $sql .= "   ord_id,\n";             //ȯ��ID
                $sql .= "   ord_no,\n";             //ȯ���ֹ�
                $sql .= "   client_id,\n";          //������ID
                $sql .= ($direct != null) ? " direct_id,\n" : null;          //ľ����ID
                $sql .= "   trade_id,\n";           //�����ʬ
                $sql .= "   green_flg,\n";          //���꡼��ե饰
                $sql .= ($trans != null) ? " trans_id,\n" : null;           //�����ȼ�
                $sql .= "   ord_time,\n";           //ȯ����
                //��˾Ǽ�������Ϥ����ä����
                if($hope_date != '--'){
                    $sql .= "   hope_day,\n";       //��˾Ǽ��
                }
                //����ͽ���������Ϥ����ä����
                if($arrival_date !=  '--'){
                    $sql .= "   arrival_day,\n";    //����ͽ����
                } 
                $sql .= "   note_your,\n";            //�̿���
                $sql .= "   note_your2,\n";         // �����̿���
                $sql .= "   c_staff_id,\n";         //ô����ID
                $sql .= "   ware_id,\n";            //�Ҹ�ID
                $sql .= "   ord_staff_id,\n";       //ȯ����ID
                $sql .= "   ps_stat,\n";            //��������
                $sql .= "   net_amount,\n";         //��ȴ���
                $sql .= "   tax_amount,\n";         //�����ǳ�
                //$sql .= "   shop_id,\n";            //����å�ID
                $sql .= "   shop_id,\n";            //����å�ID
                //$sql .= "   shop_gid\n";            //FC���롼��ID
                $sql .= "   client_cd1, ";
                $sql .= "   client_cd2, ";
                $sql .= "   client_name, ";
                $sql .= "   client_name2, ";
                $sql .= "   client_post_no1, ";
                $sql .= "   client_post_no2, ";
                $sql .= "   client_address1, ";
                $sql .= "   client_address2, ";
                $sql .= "   client_address3, ";
                $sql .= "   client_charger1, ";
                $sql .= "   client_tel, ";
                if ($direct != null){
                    $sql .= "   direct_name, ";
                    $sql .= "   direct_name2, ";
                    $sql .= "   direct_cname, ";
                    $sql .= "   direct_post_no1, ";
                    $sql .= "   direct_post_no2, ";
                    $sql .= "   direct_address1, ";
                    $sql .= "   direct_address2, ";
                    $sql .= "   direct_address3, ";
                    $sql .= "   direct_tel, ";
                }
                $sql .= ($trans != null) ? " trans_name, " : null;
                $sql .= "   ware_name, ";
                $sql .= "   c_staff_name, ";
                $sql .= "   ord_staff_name, ";
                $sql .= "   my_client_name, ";
                $sql .= "   my_client_name2,";
                $sql .= "   send_date,";
                $sql .= "   client_cname, ";
                $sql .= "   c_shop_name1, ";
                $sql .= "   c_shop_name2 ";
                $sql .= " )VALUES(\n";
                $sql .= "   (SELECT COALESCE(MAX(ord_id), 0)+1 FROM t_order_h),";   //ȯ��ID
                $sql .= "   '$order_no',\n";        //ȯ���ֹ�
                $sql .= "   $client_id,\n";         //������ID
                $sql .= ($direct != null) ? " $direct,\n" : null;            //ľ����ID
                $sql .= "   '$trade',\n";           //�����ʬ
                $sql .= "   '$trans_flg',\n";       //���꡼��ե饰
                $sql .= ($trans != null) ? " $trans,\n" : null;             //�����ȼ�ID
                $sql .= "   '$order_date',\n";       //ȯ����
                //��˾Ǽ�������Ϥ����ä����
                if($hope_date != '--'){
                    $sql .= "   '$hope_date',\n";       //��˾Ǽ��
                }
                //����ͽ���������Ϥ����ä����
                if($arrival_date != '--'){
                    $sql .= "   '$arrival_date',\n";    //����ͽ����
                }
                $sql .= "   '$note_your',\n";         //�̿���
                $sql .= "   '$note_your2',\n";      // �����̿���
                $sql .= "   $staff,\n";             //ô����
                $sql .= "   $ware,\n";              //�Ҹ�ID
                $sql .= "   $staff_id,\n";          //ȯ����ID
                $sql .= "   '1',\n";                //��������
                $sql .= "   $total_amount_data[0],\n";
                $sql .= "   $total_amount_data[1],\n";
                //$sql .= "   $shop_id,\n";
                $sql .= "   $shop_id,\n";
                //$sql .= "   $shop_gid\n";
                $sql .= "   (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT post_no1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT post_no2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT address1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT address2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT address3 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT charger1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT tel      FROM t_client WHERE client_id = $client_id), ";
                $sql .= ($direct != null) ? " (SELECT direct_name FROM t_direct WHERE direct_id = $direct), "  : null;
                $sql .= ($direct != null) ? " (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), " : null;
                $sql .= ($direct != null) ? " (SELECT direct_cname FROM t_direct WHERE direct_id = $direct), " : null;
                $sql .= ($direct != null) ? " (SELECT post_no1 FROM t_direct WHERE direct_id = $direct), "     : null;
                $sql .= ($direct != null) ? " (SELECT post_no2 FROM t_direct WHERE direct_id = $direct), "     : null;
                $sql .= ($direct != null) ? " (SELECT address1 FROM t_direct WHERE direct_id = $direct), "     : null;
                $sql .= ($direct != null) ? " (SELECT address2 FROM t_direct WHERE direct_id = $direct), "     : null;
                $sql .= ($direct != null) ? " (SELECT address3 FROM t_direct WHERE direct_id = $direct), "     : null;
                $sql .= ($direct != null) ? " (SELECT tel      FROM t_direct WHERE direct_id = $direct), "     : null;
                $sql .= ($trans != null) ? " (SELECT trans_name FROM t_trans WHERE trans_id = $trans), "       : null;
                $sql .= "   (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";
                $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $staff), ";
                $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), ";
                $sql .= "   (SELECT shop_name FROM t_client WHERE client_id = $shop_id), ";
                $sql .= "   (SELECT shop_name2 FROM t_client WHERE client_id = $shop_id), ";
                $sql .= "   NOW(),";
                $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT shop_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "   (SELECT shop_name2 FROM t_client WHERE client_id = $client_id) ";
                $sql .= ");";

                $result = Db_Query($db_con, $sql);

                //ȯ���ֹ椬��ʣ�������Ϻ��ٺ��֤��ʤ���
                if($result === false){
                    $err_message = pg_last_error(); 
                    $err_format = "t_order_h_ord_no_key";

                    Db_Query($db_con, "ROLLBACK;");
                    if(strstr($err_message, $err_format) != false){
                        $error = "Ʊ����ȯ����Ԥä����ᡢȯ��NO����ʣ���ޤ������⤦����ȯ���򤷤Ʋ�������";

                        //����ȯ��NO���������
                        $sql  = "SELECT ";
                        $sql .= "   MAX(ord_no)";
                        $sql .= " FROM";
                        $sql .= "   t_order_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $shop_id";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $order_no = pg_fetch_result($result, 0 ,0);
                        $order_no = $order_no +1;
                        $order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                        $set_data["form_order_no"] = $order_no;

                        $duplicate_flg = true;
                    }else{
                        exit;
                    }
                }
            }

            //ȯ���ֹ�ν�ʣ��̵���ä���硢ȯ���ǡ�������Ͽ
            if($duplicate_flg != true){
                //���Ϥ��줿���ʿ�ʬ�롼��
                for($i = 0; $i < count($goods_id); $i++){ 
                    //��
                    $line = $i + 1;

                    //����ñ�����������Ⱦ���������
                    $price = $buy_price[$i]["i"].".".$buy_price[$i]["d"];    //����ñ�� 

                    //���������ȴ�����򻻽�
                    $buy_amount = bcmul($price, $order_num[$i],2);
					$buy_amount = Coax_Col($coax,$buy_amount);

                    $sql  = "INSERT INTO t_order_d (\n";
                    $sql .= "   ord_d_id,\n";           //ȯ���ǡ���ID
                    $sql .= "   ord_id,\n";             //ȯ��ID
                    $sql .= "   line,\n";               //��
                    $sql .= "   goods_id,\n";           //����ID
                    $sql .= "   goods_name,\n";         //����̾
                    $sql .= "   num,\n";                //ȯ����
                    $sql .= "   tax_div,\n";            //���Ƕ�ʬ
                    $sql .= "   buy_price,\n";          //����ñ��
                    $sql .= "   buy_amount,\n";         //������۹��
                    $sql .= "   goods_cd, ";
                    $sql .= "   goods_cname, ";
                    $sql .= "   in_num ";
                    $sql .= ")VALUES(\n";
                    $sql .= "   (SELECT COALESCE(MAX(ord_d_id), 0)+1 FROM t_order_d),\n";
                    $sql .= "   (SELECT\n";
                    $sql .= "       ord_id\n";
                    $sql .= "   FROM\n";
                    $sql .= "       t_order_h\n";
                    $sql .= "   WHERE\n";
                    $sql .= "       ord_no = '$order_no'\n";
                    $sql .= "       AND\n";
                    $sql .= "       shop_id = $shop_id\n";
                    $sql .= "   ),\n";
                    $sql .= "   $line,\n";
                    $sql .= "   $goods_id[$i],\n";
                    $sql .= "   '$goods_name[$i]',\n";
                    $sql .= "   '$order_num[$i]',\n";
                    $sql .= "   '$tax_div[$i]',\n";
                    $sql .= "   $price,\n";
                    $sql .= "   $buy_amount, \n";
                    $sql .= "   (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_id[$i]), ";
                    $sql .= "   (SELECT goods_cname FROM t_goods WHERE goods_id = $goods_id[$i]), ";
                    $sql .= "   (SELECT in_num FROM t_goods WHERE goods_id = $goods_id[$i]) ";
                    $sql .= ");\n";

                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }

                    //�߸˼�ʧ�ơ��֥����Ͽ
                    //�߸˴������뾦�ʤ�ľ���褬���򤵤�Ƥ��ʤ����
//                    if($stock_manage[$i] != '2' ||  $direct == null){
//                    if($stock_manage[$i] != '2'){
//�����ʤ�������ʧ���ơ��֥�ˤ�ɽ������褦���ѹ�
                        $sql  = "INSERT INTO t_stock_hand (\n";
                        $sql .= "   goods_id,\n";
                        $sql .= "   enter_day,\n";
                        $sql .= "   work_day,\n";
                        $sql .= "   work_div,\n";
                        $sql .= "   client_id,\n";
                        $sql .= "   ware_id,\n";
                        $sql .= "   io_div,\n";
                        $sql .= "   num,\n";
                        $sql .= "   slip_no,\n";
                        $sql .= "   ord_d_id,\n";
                        $sql .= "   staff_id,\n";
                        $sql .= "   shop_id, \n";
                        $sql .= "   client_cname \n";
                        $sql .= " )VALUES(\n";
                        $sql .= "   $goods_id[$i],\n";
                        $sql .= "   NOW(),\n";
                        $sql .= "   '$order_date',\n";
                        //2006-07-19 kaji ��ȶ�ʬ��ȴ���Ƥ��Τ��ɲ�
                        $sql .= "   '3',\n";
                        $sql .= "   $client_id,\n";
                        $sql .= "   $ware,\n";
                        $sql .= "   '1',";
                        $sql .= "   $order_num[$i],\n";
                        $sql .= "   '$order_no',\n";
                        $sql .= "   (SELECT\n";
                        $sql .= "       ord_d_id\n";
                        $sql .= "   FROM\n";
                        $sql .= "       t_order_d\n";
                        $sql .= "   WHERE\n";
                        $sql .= "       line = $line\n";
                        $sql .= "       AND\n";
                        $sql .= "       ord_id = (SELECT\n";
                        $sql .= "                   ord_id\n";
                        $sql .= "                FROM\n";
                        $sql .= "                   t_order_h\n";
                        $sql .= "                WHERE\n";
                        $sql .= "                   ord_no = '$order_no'";
                        $sql .= "                   AND\n";
                        $sql .= "                   shop_id = $shop_id";
                        $sql .= "               )\n";
                        $sql .= "   ),\n";
                        //2006-07-19 kaji �����å�ID�θ�Υ����ȴ�����ɲ�
                        $sql .= "   $staff_id,\n";
                        $sql .= "   $shop_id,\n";
                        $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
//                    }
                }

                Db_Query($db_con, "COMMIT;");

                //ȯ����ǧ���̤�����
                //Get���Ϥ��ͤ����
                $sql  = "SELECT";
                $sql .= "   ord_id";
                $sql .= " FROM";
                $sql .= "   t_order_h";
                $sql .= " WHERE";
                $sql .= "   ord_no = '$order_no'";
                $sql .= "   AND";
                $sql .= "   shop_id = $shop_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                $order_id = pg_fetch_result($result,0,0);

                //ȯ����λ�ܥ��󲡲��ե饰��true�ξ��
                if($add_comp_flg == true){
                    header("Location: ./1-3-103.php?ord_id=$order_id&output_flg=false");
                //ȯ����λ��ȯ������ϥܥ��󲡲��ե饰��true�ξ��
                }elseif($add_comp_slip_flg == true){
                    header("Location: ./1-3-103.php?ord_id=$order_id&output_flg=true");
                }
            }

        //ȯ����ǧ�إܥ��󲡲��ե饰��true�ξ��
        }else{
            //�ե������Ǥ�뤿��Υե꡼���ե饰
            $freeze_flg = true;
        }
    }
/****************************/
//�ѹ��ν���
/****************************/
//�ѹ��ե饰��ture�ξ��
}elseif(true === $update_flg 
        && 
        null == $get_order_id 
        && 
        true != $goods_search_flg 
        && 
        true != $sum_button_flg
        &&
        true != $client_search_flg
        &&
        true != $designated_date_flg
    ){
    $get_ord_id = $_GET["ord_id"];              //GET�Ǽ�������ȯ��ID

    //ȯ���إå����鲼�������
    $sql  = "SELECT\n";
    $sql .= "   t_order_h.ord_no,\n";                                       //ȯ���ֹ�
    $sql .= "   to_char(t_order_h.ord_time, 'YYYY-mm-dd') AS ord_time,\n";  //ȯ����
    $sql .= "   t_order_h.hope_day,\n";                                     //��˾Ǽ��
    $sql .= "   t_order_h.arrival_day,\n";                                  //����ͽ����
    $sql .= "   t_order_h.trans_id,\n";                                     //�����ȼ�
    $sql .= "   t_client.client_id,\n";                                     //������ID
    $sql .= "   t_client.client_cd1,\n";                                    //�����襳����
    $sql .= "   t_client.client_cd2,\n";                                    //�����襳����
//    $sql .= "   t_client.client_name,\n";       //������̾
    $sql .= "   t_client.client_cname,\n";                                  //������̾
    $sql .= "   t_client.tax_franct,\n";                                    //ü����ʬ
    $sql .= "   t_client.coax,\n";                                          //�ݤ��ʬ
    $sql .= "   t_order_h.direct_id,\n";                                    //ľ����ID
    $sql .= "   t_order_h.ware_id,\n";                                      //�Ҹ�ID
    $sql .= "   t_order_h.trade_id,\n";                                     //�����ʬ������
    $sql .= "   t_order_h.c_staff_id,\n";                                   //ô����ID
    $sql .= "   t_order_h.note_your,\n";                                    //�̿���
    $sql .= "   t_order_h.note_your2,\n";                                   // �����̿���
    $sql .= "   to_char(t_order_h.send_date, 'yyyy-mm-dd hh24:mi') AS send_date,\n";
    $sql .= "   t_order_h.enter_day\n";

	//rev.1.3 ľ����ƥ����Ȳ�
	$sql .= ",\n";
    $sql .= "    t_direct.direct_cd, \n";		//ľ����CD
    $sql .= "    t_order_h.direct_cname, \n";	//ľ����ά��
    $sql .= "    t_direct_claim.client_cname AS direct_claim \n";	//ľ����������

    $sql .= " FROM\n";
    $sql .= "   t_order_h\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_client\n";
    $sql .= "   ON t_order_h.client_id = t_client.client_id\n";
	$sql .= "   LEFT JOIN t_direct ON t_order_h.direct_id = t_direct.direct_id \n";							//rev.1.3 ľ����ƥ����Ȳ�
	$sql .= "   LEFT JOIN t_client AS t_direct_claim ON t_direct.client_id = t_direct_claim.client_id \n";	//rev.1.3 ľ����ƥ����Ȳ�
    $sql .= " WHERE\n";
    $sql .= "   t_order_h.ord_id = $get_ord_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_order_h.ps_stat = '1'\n";
    $sql .= "   AND\n";
    $sql .= "   t_order_h.shop_id = $shop_id\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    Get_Id_Check($result);
    $update_data = pg_fetch_array($result, 0);
    
    //Get�򸵤���Ф����ǡ����򥻥å�
    $set_data["form_order_no"]          = $update_data["ord_no"];           //ȯ���ֹ�
    $set_data["hdn_client_id"]          = $update_data["client_id"];        //������ID
    $set_data["hdn_coax"]               = $update_data["coax"];             //�ݤ��ʬ
    $set_data["hdn_tax_franct"]         = $update_data["tax_franct"];       //ü����ʬ
    //$set_data["form_client"]["cd"]      = $update_data["client_cd1"];       //�����襳����
    $set_data["form_client"]["cd1"]     = $update_data["client_cd1"];       //�����襳����
    $set_data["form_client"]["cd2"]     = $update_data["client_cd2"];       //�����襳����
    $set_data["form_client"]["name"]    = $update_data["client_cname"];     //������̾
    $order_day = explode("-", $update_data["ord_time"]);                    //ȯ������
    $set_data["form_order_day"]["y"]    = $order_day[0];
    $set_data["form_order_day"]["m"]    = $order_day[1];
    $set_data["form_order_day"]["d"]    = $order_day[2];
    $hope_day  = explode("-", $update_data["hope_day"]);                    //��˾Ǽ��
    $set_data["form_hope_day"]["y"]     = $hope_day[0];
    $set_data["form_hope_day"]["m"]     = $hope_day[1];
    $set_data["form_hope_day"]["d"]     = $hope_day[2];
    $arrival_day = explode("-", $update_data["arrival_day"]);               //����ͽ����
    $set_data["form_arrival_day"]["y"]  = $arrival_day[0];
    $set_data["form_arrival_day"]["m"]  = $arrival_day[1];
    $set_data["form_arrival_day"]["d"]  = $arrival_day[2];
    $set_data["form_staff"]             = $update_data["c_staff_id"];       //ô����ID
    $set_data["form_ware"]              = $update_data["ware_id"];          //�Ҹ�ID
    $set_data["form_trade"]             = $update_data["trade_id"];         //�����ʬ
    $set_data["form_note_your"]         = $update_data["note_your"];        //�̿���
    $set_data["form_note_your2"]        = $update_data["note_your2"];       // �����̿���
    $set_data["form_direct"]            = $update_data["direct_id"];        //ľ����
    $set_data["form_trans"]             = $update_data["trans_id"];         //�����ȼ�
    $set_data["form_send_date"]         = $update_data["send_date"];        //ȯ����
    $set_data["hdn_ord_enter_day"]      = $update_data["enter_day"];        //��Ͽ��

	//rev.1.3 ľ����ƥ����Ȳ�
    $set_data["form_direct_text"]["cd"]	= $update_data["direct_cd"];        //ľ����CD
    $set_data["form_direct_text"]["name"]	= $update_data["direct_cname"];	//ľ����ά��
    $set_data["form_direct_text"]["claim"]	= $update_data["direct_claim"];	//ľ����������

    //�����踡���ե饰��true�򥻥å�
    $client_search_flg = true;
 
    //�ʹߤν����ǻ����ޤ��ǡ���
    $client_id  = $update_data["client_id"];
    $coax       = $update_data["coax"];
    $tax_franct = $update_data["tax_franct"];

    //ȯ���ǡ����������
    $sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    //$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "   t_order_d.goods_cd,\n";
    $sql .= "   t_order_d.goods_name,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS rack_num,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_stock_io.order_num,0)\n";
    $sql .= "   END AS on_order_num,\n ";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//    $sql .= "                - COALESCE(t_allowance_io.allowance_io_num,0)\n";
    $sql .= "   END AS allowance_total,\n";
    $sql .= "   COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   + COALESCE(t_stock_io.order_num,0)\n";
//    $sql .= "   - (COALESCE(t_stock.rstock_num,0)\n";
    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total,\n";
    $sql .= "   t_order_d.num,\n";
    $sql .= "   t_order_d.buy_price,\n";
    $sql .= "   t_order_d.tax_div,\n";
    $sql .= "   t_order_d.buy_amount,\n";
//    $sql .= "   t_goods_info.in_num\n";
    //aoyama-n 2009-09-08
    #$sql .= "   t_goods.in_num\n";
    $sql .= "   t_goods.in_num,\n";
    $sql .= "   t_goods.discount_flg\n";
    $sql .= " FROM\n ";
    $sql .= "   t_order_d\n";
    $sql .= "       INNER JOIN\n ";
    $sql .= "   t_order_h\n";
    $sql .= "   ON t_order_d.ord_id = t_order_h.ord_id\n ";
    $sql .= "       INNER JOIN\n ";
    $sql .= "   t_goods\n ";
    $sql .= "   ON t_order_d.goods_id = t_goods.goods_id\n";
    $sql .= "       LEFT JOIN \n";

    //�߸˿�
    $sql .= "   (SELECT\n ";
    $sql .= "       t_stock.goods_id,\n";
    $sql .= "       SUM(t_stock.stock_num)AS stock_num,\n";
    $sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock.shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock \n";
    $sql .= "   ON t_order_d.goods_id = t_stock.goods_id\n";
    $sql .= "       LEFT JOIN\n";

    //ȯ���Ŀ�
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div\n";
    $sql .= "                                    WHEN 1 THEN 1\n";
    $sql .= "                                    WHEN 2 THEN -1\n";
    $sql .= "                              END\n";
    $sql .= "    ) AS order_num\n ";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 3\n";
    $sql .= "       AND\n";
    $sql .= "       t_stock_hand.shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n ";
//    $sql .= "       AND\n";
    $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io\n";
    $sql .= "   ON t_order_d.goods_id=t_stock_io.goods_id\n";
    $sql .= "       LEFT JOIN\n";

    //������
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div\n";
    $sql .= "                                    WHEN 1 THEN 1\n";
    $sql .= "                                    WHEN 2 THEN -1\n";
    $sql .= "                              END\n";
    $sql .= "        ) AS allowance_io_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 1\n";
    $sql .= "       AND\n";
    $sql .= "       t_stock_hand.shop_id =  $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//    $sql .= "       t_stock_hand.work_day > (CURRENT_DATE + 7)\n";
    $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io\n";
    $sql .= "   ON t_order_d.goods_id = t_allowance_io.goods_id\n";

	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       INNER JOIN\n ";
    $sql .= "   t_goods_info\n ";
    $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_order_d.ord_id = $get_ord_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_order_h.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    //$sql .= "   t_goods_info.shop_gid = $shop_gid\n";
//    if($_SESSION[group_kind] == "2"){
//        $sql .= "   t_goods_info.shop_id IN (".Rank_Sql().") ";
//    }else{
        $sql .= "   t_goods_info.shop_id = $_SESSION[client_id]";
//    }

    $sql .= " ORDER BY t_order_d.line\n";
    $sql .= ";\n"; 

    $result = Db_Query($db_con, $sql);
    Get_Id_Check($result);
    $update_data_num = pg_num_rows($result);

    for($i = 0; $i < $update_data_num; $i++){
        //��Ф����ǡ���
        $update_d_data = pg_fetch_array($result, $i);

        //��Ф���ñ���ǡ����򥻥åȤ���������ѹ�
        //��Ф���ñ�����ѿ��˥��å�
        $goods_price        = $update_d_data["buy_price"];      //����ñ��
        //ñ�����������Ⱦ�������ʬ����
        $goods_price_data   = explode(".", $goods_price); 

        //��Ф����ǡ�����ե�����˥��å�
        $set_data["form_goods_id"][$i]      = $update_d_data["goods_id"];        //����ID
        $set_data["hdn_stock_manage"][$i]   = $update_d_data["stock_manage"];    //�߸˴���
        $set_data["hdn_name_change"][$i]    = $update_d_data["name_change"];     //��̾�ѹ�
        $set_data["hdn_goods_id"][$i]       = $update_d_data["goods_id"];        //����ID
        $set_data["form_goods_cd"][$i]      = $update_d_data["goods_cd"];        //���ʥ�����
        $set_data["form_goods_name"][$i]    = $update_d_data["goods_name"];      //����̾
        $set_data["form_stock_num"][$i]     = $update_d_data["rack_num"];        //��ê��
        $set_data["hdn_stock_num"][$i]      = $update_d_data["rack_num"];        //��ê��
        $set_data["hdn_stock_manage"][$i]   = $update_d_data["stock_manage"];    //��ê��
        $set_data["form_rorder_num"][$i]    = $update_d_data["on_order_num"];    //ȯ���Ŀ�
        $set_data["form_designated_num"][$i]= $update_d_data["stock_total"];     //�вٲ�ǽ��
        $set_data["form_rstock_num"][$i]    = $update_d_data["allowance_total"]; //������
        $set_data["form_order_num"][$i]     = $update_d_data["num"];             //ȯ����
        $set_data["hdn_tax_div"][$i]        = $update_d_data["tax_div"];         //���Ƕ�ʬ
        $set_data["form_in_num"][$i]        = $update_d_data["in_num"];          //����
        $set_data["form_buy_price"][$i]["i"]= $goods_price_data[0];              //����ñ������������
        $set_data["form_buy_price"][$i]["d"]= $goods_price_data[1];              //����ñ���ʾ������� 
        $set_data["form_buy_amount"][$i]    = $update_d_data["buy_amount"];      //�������
        $set_data["hdn_tax_div"][$i]        = $update_d_data["tax_div"];         //���Ƕ�ʬ
        //aoyama-n 2009-09-08
        $set_data["hdn_discount_flg"][$i]   = $update_d_data["discount_flg"];    //�Ͱ��ե饰

        //�ʹߤν����ǻ����ޤ��ǡ���
        $goods_id[$i]                       = $update_d_data["goods_id"];        //����ID
        $stock_num[$i]                      = $update_d_data["rack_num"];        //��ê��(�����)
        $stock_manage[$i]                   = $update_d_data["stock_manage"];    //�߸˴����ʺ߸˿�ɽ��Ƚ���
        $name_change[$i]                    = $update_d_data["name_change"];     //��̾�ѹ�����̾�ѹ��ղ�Ƚ���

        //��פ���뤿��β��Ƕ�ʬ
        $price_data[$i] = $update_d_data["buy_amount"];   //���
        $tax_div[$i] = $update_d_data["tax_div"];         //���Ƕ�ʬ
    }

    //�Կ��򥻥å�
    $max_row = $update_data_num;

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($update_data["ord_time"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

    //�ե�������ͥ��å�
    $set_data["form_buy_money"]     = number_format($data[0]);
    $set_data["form_tax_money"]     = number_format($data[1]);
    $set_data["form_total_money"]   = number_format($data[2]);

    //Get�Ǽ�������ȯ��ID��hidden�ǻ����ޤ��
    $set_data["hdn_order_id"] = $get_ord_id;
}

//����Կ���hidden�˥��å�
$set_data["max_row"] = $max_row;

//�嵭�����ˤ�����������ͤ�ե�����˥��å�
$form->setConstants($set_data);

/****************************/
//ưŪ����������ե��������
/****************************/
//�����褬���򤵤�Ƥ��ʤ����
if($client_search_flg === false || $freeze_flg == true){
    #2009-09-15 hashimoto-y
    #$style = "color : #000000;
    #        border : #ffffff 1px solid; 
    #        background-color: #ffffff";
    $style = "border : #ffffff 1px solid; 
            background-color: #ffffff";
    $type = "readonly";
}
$row_num= 1;
for($i = 0; $i < $max_row; $i++){
    //ɽ����Ƚ��(�������ˤʤ��ԤΤ�ɽ��)
    if(!in_array("$i", $del_history)){

        $del_data = $del_row.",".$i;

        #2009-09-15 hashimoto-y
        //�Ͱ����ʤ����򤷤����ˤ��ֻ����ѹ�
        $font_color = "";

        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

        #print_r($hdn_discount_flg);

        if($hdn_discount_flg === 't'){
            $font_color = "color: red; ";
        }else{
            $font_color = "color: #000000; ";
        }



        //����ID
        $form->addElement("hidden","hdn_goods_id[$i]");

        //���ʥ�����
        $form->addElement(
            "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\" 
             style=\"$font_color $style $g_form_style \" $type 
            onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'hdn_goods_search_flg', $i ,$row_num);\""
        );

        //����̾
        if($name_change[$i] == '2'){
            $read_only = "readonly";
        }else{
            $read_only = null;
        }
        $form->addElement(
            "text","form_goods_name[$i]","",
            "size=\"54\" maxlength=\"41\" 
            style=\"$font_color $style \"
            $read_only"
        );

        //��̾�ѹ��ե饰
        $form->addElement("hidden","hdn_name_change[$i]");

        //�߸˴���
        $form->addElement("hidden","hdn_stock_manage[$i]");

        //��ê��
        $form->addElement("hidden","hdn_stock_num[$i]");

        $form->addElement("link",
            "form_stock_num[$i]","","#","$stock_num[$i]",
            "onClick=\"javascript:Open_mlessDialmg_g('1-3-111.php','$goods_id[$i]',1,300,160);\""
        );

        //ȯ���ѿ�
        $form->addElement(
            "text","form_rorder_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //������
        $form->addElement("text","form_rstock_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //�вٲ�ǽ��
        $form->addElement("text","form_designated_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //����
        $form->addElement("text","form_in_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" 
            readonly'"
        );

        //��ʸ����
        $form->addElement("text","form_order_in_num[$i]","",
            "size=\"6\" maxLength=\"5\"
             onKeyup=\"in_num($i,'hdn_goods_id[$i]','form_order_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
            style=\"text-align: right; $font_color $style $g_form_style \"
            $type"
        );
        //ȯ����
        $form->addElement("text","form_order_num[$i]","",
            "size=\"6\" maxLength=\"5\"
             onKeyup=\"Mult('hdn_goods_id[$i]','form_order_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');ord_in_num($i);\"
            style=\"text-align: right; $font_color $style $g_form_style \"
            $type"
        );

        //����ñ��
        $form_buy_price[$i][] =& $form->createElement(
            "text","i","",
            "size=\"11\" maxLength=\"9\" class=\"money\"
            onKeyup=\"Mult('hdn_goods_id[$i]','form_order_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
            style=\"text-align: right; $font_color $style $g_form_style \"
            $type"
        );
        $form_buy_price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\"
             onKeyup=\"Mult('hdn_goods_id[$i]','form_order_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
            style=\"text-align: left; $font_color $style $g_form_style \"
            $type"
        );
        $form->addGroup( $form_buy_price[$i], "form_buy_price[$i]", "",".");

        //���Ƕ�ʬ
        $form->addElement("hidden","hdn_tax_div[$i]","","");

        //���(��ȴ��)
        $form->addElement(
            "text","form_buy_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$font_color
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //aoyama-n 2009-09-08
        //�Ͱ��ե饰
        #$form->addElement("hidden","hdn_discount_flg[$i]","","");

        //����¾���ʤ���Ͽ��ǧ���̤ξ�����ɽ��
        if($client_search_flg === true && $freeze_flg != true){
            //�������
            $form->addElement(
                "link","form_search[$i]","","#","����",
                "TABINDEX=-1 
                onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','hdn_goods_search_flg'), 500, 450,5,$client_id,$i,$row_num);\""
            );

            //������
            //�ǽ��Ԥ��������硢���������κǽ��Ԥ˹�碌��
            if($row_num == $max_row-$del_num){
                $form->addElement(
                    "link","form_del_row[$i]","",
                    "#","<font color='#FEFEFE'>���</font>",
                    "TABINDEX=-1 
                    onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1);return false;\"");

            //�ǽ��԰ʳ����������硢�������Ԥ�Ʊ��NO�ιԤ˹�碌��
            }else{
                $form->addElement(
                    "link","form_del_row[$i]","","#",
                    "<font color='#FEFEFE'>���</font>",
                    "TABINDEX=-1 
                    onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num);return false;\""                                  );
            }
        }
        /****************************/
        //ɽ����HTML����
        /****************************/
        $html .= " <tr class=\"Result1\">";
        $html .= "  <A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .= "  <td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        //�����褬���򤵤줿���
        if($client_search_flg === true && $freeze_flg != true){
            $html .= "      ��".$form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml()."��";
        }
        $html .= "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\" width=\"80\">";

        //�߸˴���������
        if($stock_manage[$i] == 1){
            $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .=        $form->_elements[$form->_elementIndex["form_rorder_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .=        $form->_elements[$form->_elementIndex["form_rstock_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .=        $form->_elements[$form->_elementIndex["form_designated_num[$i]"]]->toHtml();
            $html .= "  </td>";
        //�߸˴������ʤ����
        }elseif($stock_manage[$i] == 2){
            #2009-09-15 hashimoto-y
            $html .= "<p style=\"$font_color\">";
            $html .= "-";
            $html .= "</p>";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "<p style=\"$font_color\">";
            $html .= "-";
            $html .= "</p>";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "<p style=\"$font_color\">";
            $html .= "-";
            $html .= "</p>";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "<p style=\"$font_color\">";
            $html .= "-";
            $html .= "</p>";
            $html .= "  </td>";
        //����¾
        }else{
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "  </td>";
        }

        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_order_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_order_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_price[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_amount[$i]"]]->toHtml();
        $html .= "  </td>";

        //�����褬���򤵤줿���
        if($client_search_flg === true && $freeze_flg != true){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
            $html .= "  </td>";
        }
        $html .= " </tr>";

        //���ֹ��ܣ�
        $row_num = $row_num+1;
    }
}

//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ�
if($freeze_flg != true){
    //button
    $form->addElement("submit","form_order_button","ȯ����ǧ���̤�", $disabled);
    $form->addElement("button","form_sum_button","�硡��",
            "onClick=\"javascript:Button_Submit('hdn_sum_button_flg','#foot','t')\"");
/*
    $form->addElement("link","form_client_link","","#","ȯ����","
        onClick=\"return Open_SubWin('../dialog/1-0-208.php',Array('form_client[cd]','form_client[name]', 'hdn_client_search_flg'),500,450,5,1);\""    );    
*/
    $form->addElement("link","form_client_link","#","./1-3-207.php","ȯ����","
    onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','hdn_client_search_flg'),500,450,'1-3-207',1);\"");

	//rev.1.3 ľ����������������
    $form->addElement("link","form_direct_link","#","./1-3-207.php","ľ����","
    onClick=\"return Open_SubWin('../dialog/1-0-260.php',Array('form_direct_text[cd]','form_direct_text[name]','form_direct_text[claim]','hdn_direct_search_flg'),500,450,'1-3-207',1);\"");


    //�����褬���򤵤�Ƥ��ʤ����ϥե꡼��
    //���ɲåܥ���
    if($client_search_flg === true){
        $form->addElement("button","form_add_row_button", "�ɡ���", "onClick=\"javascript:Button_Submit('add_row_flg','#foot','true')\"");
    }

}else{
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
    //���  
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    
    //OK
    $form->addElement("submit","form_comp_button","ȯ����λ", $disabled);

    //ȯ�������
    $form->addElement("submit","form_slip_comp_button","ȯ����λ��ȯ�������", $disabled);

    //ȯ����
    $form->addElement("static","form_client_link","","ȯ����"); 

    //ľ����
    $form->addElement("static","form_direct_link","","ȯ����"); 

    $form->freeze();
}

/****************************/
//javascript
/****************************/
//���åȿ���׻�����
$js  = " function in_num(num,id,order_num,price_i,price_d,amount,coax){\n";
$js .= "    var in_num = \"form_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_in_num = \"form_order_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_num = \"form_order_num\"+\"[\"+num+\"]\";\n";
$js .= "    var buy_amount = \"form_buy_amount\"+\"[\"+num+\"]\";\n";
$js .= "    var v_in_num = document.dateForm.elements[in_num].value;\n";
$js .= "    var v_ord_in_num = document.dateForm.elements[ord_in_num].value;\n";
$js .= "    var v_ord_num = document.dateForm.elements[ord_num].value;\n";
$js .= "    var v_num = v_in_num * v_ord_in_num;\n";
$js .= "    if(isNaN(v_num) == true){\n";
$js .= "        var v_num = \"\"\n";
$js .= "    }\n";
$js .= "    document.dateForm.elements[ord_num].value = v_num;\n";
$js .= "    Mult(id,order_num,price_i,price_d,amount,coax);\n";
$js .= "}\n";

//��ʸ���åȿ���׻�����
$js .= "function ord_in_num(num){\n";
$js .= "    var in_num = \"form_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_in_num = \"form_order_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_num = \"form_order_num\"+\"[\"+num+\"]\";\n";
$js .= "    var v_in_num = document.dateForm.elements[in_num].value;\n";
$js .= "    var v_ord_in_num = document.dateForm.elements[ord_in_num].value;\n";
$js .= "    var v_ord_num = document.dateForm.elements[ord_num].value;\n";
$js .= "    var result = v_ord_num % v_in_num;    if(result == 0){\n";
$js .= "        var res = v_ord_num / v_in_num;\n";
$js .= "        document.dateForm.elements[ord_in_num].value = res;\n";
$js .= "    }else{  \n";
$js .= "        document.dateForm.elements[ord_in_num].value = \"\";\n";
$js .= "    }\n";
$js .= "}\n";


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
$page_menu = Create_Menu_h('buy','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[ord_button]]->toHtml();
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
    'html'          => "$html",
    'client_search_flg'    => "$client_search_flg",
    'warning'       => "$warning",
    'js'            => "$js",
    'freeze_flg'    => "$freeze_flg",
    'goods_twice'   => "$goods_twice",
    'error'         => "$error",
    'update_flg'    => "$update_flg",
));

$smarty->assign('price_err',$price_err);
$smarty->assign('price_num_err',$price_num_err);
$smarty->assign('num_err',$num_err);
$smarty->assign('goods_err',$goods_err);
$smarty->assign('duplicate_goods_err', $duplicate_goods_err);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>