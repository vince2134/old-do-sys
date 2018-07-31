<?php
/****************************
 * �ѹ�����
 *  ��(2006-08-03)���ʤ�ά�Τ�������̾�Τ��ѹ�<watanabe-k>
 *  ��(2006-08-21)����ʬ���ɽ������褦���ѹ�<watanabe-k>
 *
 *
*****************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/22      11-007      ��          �谷���ָ����ե�����Υ��顼�����å�����
 *  2006/11/22      11-008      ��          �谷���ָ����ե�����Υ��顼�����å�����
 *  2006/11/23      11-199~204  ��          ��ʧ�ǡ����������������ľ��
 *  2006/12/06      ban_0013    suzuki      ���դΥ�������ɲ�
 *  2006/12/15                  suzuki      ���ɽ���μ谷���֤�����η�����ˤ���褦�˽���
 *  2007/02/22                  watanabe-k  ���׵�ǽ�κ��    
 *  2007/04/17      B0702-043   kajioka-h   ������ɥ������ȥ�˲������إܥ����HTML�����Ϥ���Ƥ����Τ���
 *  2009/10/09                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *  2009/10/09_1                hashimoto-y �谷���֤γ�������ե�������ѹ�
 *  2009/10/12                  aoyama-n    ��׾���CSV���ϵ�ǽ�ɲ� 
 *  2009/10/20                  aoyama-n    ��׾���CSV�Υǡ����Ȥ��ơְ�ư�ס���Ω�פ��ɲ� 
 *  2009/10/21                  hashimoto-y ���ɽ���ǳ�������setConstants���Ƥʤ��Х����� 
 *  2010/01/08                  aoyama-n    �߸˾Ȳ񤫤����ܸ塢ɽ���ܥ���򥯥�å������CSV�����Ϥ�����Զ�罤��
 *  2010/05/12      Rev.1.5     hashimoto-y ���ɽ���˸������ܤ���ɽ�����뽤��
*  2016/01/22                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�  
 *
*/

$page_title = "�߸˼�ʧ�Ȳ�";

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
$shop_id      = $_SESSION["client_id"]; 
$get_goods_id = $_GET["goods_id"];       
$get_ware_id  = $_GET["ware_id"];

/*** GET�ǡ����������������å� ***/
if ($get_goods_id != null && Get_Id_Check_Db($db_con, $get_goods_id, "goods_id", "t_goods", "num", "shop_id = 1") != true){
    header("Location: ../top.php");
}
if ($get_ware_id != null && Get_Id_Check_Db($db_con, $get_ware_id, "ware_id", "t_ware", "num", "shop_id = 1") != true){
    header("Location: ../top.php");
}

//����ID��hidden�ˤ���ݻ�����
if($_GET["goods_id"] != NULL){
    Get_Id_Check3($_GET["goods_id"]);
    $set_id_data["hdn_goods_id"] = $get_goods_id;
    $form->setConstants($set_id_data);
}else{
    $get_goods_id = $_POST["hdn_goods_id"];
}
//�Ҹ�ID��hidden�ˤ���ݻ�����
if($_GET["ware_id"] != NULL){
    Get_Id_Check3($_GET["ware_id"]);
    $set_id_data["hdn_ware_id"] = $get_ware_id;
    $form->setConstants($set_id_data);
}else{
    $get_ware_id = $_POST["hdn_ware_id"];
}

/****************************/
//�ǥե����������
/****************************/
/*
$def_data = array(
    "form_output"           => "1"
);
*/

//2009-10-12 aoyama-n
$def_data = array(
    "form_output_type"      => "1"
);

//�ǿ��η�����������
$plus1_flg = true;
$sql  = "SELECT";
$sql .= "   COALESCE(MAX(close_day), null) ";
$sql .= "FROM";
$sql .= "   t_sys_renew ";
$sql .= "WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= "   AND";
$sql .= "   renew_div = '2'";
$sql .= ";";
$result = Db_Query($db_con, $sql);
$max_close_day = pg_fetch_result($result, 0,0);

if($max_close_day == null){
    $plus1_flg = false;
    $sql  = "SELECT \n";
    $sql .= "   COALESCE(MIN(work_day), null) \n";
    $sql .= "FROM \n";
    $sql .= "   t_stock_hand \n";
    $sql .= "WHERE \n";
    $sql .= "   work_div = '6' \n";
    $sql .= "AND \n";
    $sql .= "   adjust_reason = '1' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $max_close_day = pg_fetch_result($result, 0,0);
}
$ary_close_day = explode('-', $max_close_day);

// �������1�٤Ǥ�Ԥ��Ƥ�����Ϸ�������ܣ��ˤ���
if ($plus1_flg === true){
    $plus1_date = date("Y-m-d", mktime(0, 0, 0, $ary_close_day[1] , $ary_close_day[2]+1, $ary_close_day[0]));
    $ary_close_day = explode('-', $plus1_date);
}else{
    $plus1_date = $max_close_day;
}

$def_data[form_hand_day][sy] = $ary_close_day[0];
$def_data[form_hand_day][sm] = $ary_close_day[1];
$def_data[form_hand_day][sd] = $ary_close_day[2];

$form->setDefaults($def_data);

$max_close_day = $ary_close_day[0]."-".$ary_close_day[1]."-".$ary_close_day[2];

/****************************/
//�������
/****************************/
//���ʡ��Ҹˤ����ꤵ��Ƥ��뤫
if($get_goods_id == NULL && $get_ware_id == NULL){
/*
    //���Ϸ���
    $radio = "";
    $radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
    $radio[] =& $form->createElement( "radio",NULL,NULL, "Ģɼ","2");
    $form->addGroup($radio, "form_output", "���Ϸ���");
*/
    //2009-10-12 aoyama-n
    //���Ϸ���
    $radio = "";
    $radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
    $radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
    $form->addGroup($radio, "form_output_type", "���Ϸ���");

    //���ʥ�����
    $form->addElement("text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

    //����̾
    $form->addElement("text","form_goods_cname","","size=\"34\" maxLength=\"15\" $g_form_goods");

    //����ʬ��
    $select_value = Select_Get($db_con, "g_product");
    $form->addElement("select", "form_g_product", "", $select_value, $g_form_option_select);

    //�Ҹ�
    $select_value = Select_Get($db_con,'ware');
    $form->addElement('select', 'form_ware', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
}

//�谷����
$text="";
#2009-10-09_1 hashimoto-y
#$text[] =& $form->createElement(
#"text","sy","�ƥ����ȥե�����"," size=\"4\" maxLength=\"4\" style=\"color : #000000;border : #ffffff 1px solid;background-color: #ffffff; text-align: right;\" onkeyup=\"changeText(this.form,'form_hand_day[sy]','form_hand_day[sm]',4)\" readonly"
#);
$text[] =& $form->createElement(
"text","sy","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_hand_day[sy]','form_hand_day[sm]',4)\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[sy]','form_hand_day[sm]','form_hand_day[sd]')\"
        onBlur=\"blurForm(this)\" "

);


$text[] =& $form->createElement("static","","","-");

#2009-10-09_1 hashimoto-y
#$text[] =& $form->createElement(
#"text","sm","�ƥ����ȥե�����"," size=\"1\" maxLength=\"2\" style=\"color : #000000;border : #ffffff 1px solid;background-color:#ffffff; text-align: right;\" onkeyup=\"changeText(this.form,'form_hand_day[sm]','form_hand_day[sd]',2)\" readonly"
#);
$text[] =& $form->createElement(
"text","sm","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_hand_day[sm]','form_hand_day[sd]',2)\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[sy]','form_hand_day[sm]','form_hand_day[sd]')\"
        onBlur=\"blurForm(this)\""
);


$text[] =& $form->createElement("static","","","-");

#2009-10-09_1 hashimoto-y
$text[] =& $form->createElement(
"text","sd","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[sy]','form_hand_day[sm]','form_hand_day[sd]')\"
        onBlur=\"blurForm(this)\""
);


/*
$text[] =& $form->createElement("static","","","������");
$text[] =& $form->createElement(
"text","ey","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hand_day[ey]','form_hand_day[em]',4)\"".$g_form_option."\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
"text","em","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hand_day[em]','form_hand_day[ed]',2)\"".$g_form_option."\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
"text","ed","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\""
);
$form->addGroup( $text,"form_hand_day","form_hand_day");
*/
$text[] =& $form->createElement("static","","","������");
$text[] =& $form->createElement(
"text","ey","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_hand_day[ey]','form_hand_day[em]',4)\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[ey]','form_hand_day[em]','form_hand_day[ed]')\"
        onBlur=\"blurForm(this)\" "
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
"text","em","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_hand_day[em]','form_hand_day[ed]',2)\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[ey]','form_hand_day[em]','form_hand_day[ed]')\"
        onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
"text","ed","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[ey]','form_hand_day[em]','form_hand_day[ed]')\"
        onBlur=\"blurForm(this)\""
);
$form->addGroup( $text,"form_hand_day","form_hand_day");



// �߸˾Ȳ��󥯥ܥ���
$form->addElement("button", "4_101_button", "�߸˾Ȳ�", "onClick=\"location.href('./1-4-101.php');\"");

// �߸˼�ʧ��󥯥ܥ���
$form->addElement("button", "4_105_button", "�߸˼�ʧ", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

// ��α�߸˰�����󥯥ܥ���
$form->addElement("button", "4_110_button", "��α�߸˰���", "onClick=\"javascript:location.href('./1-4-110.php')\"");




//���ܸ�Ƚ��
if(($get_goods_id == NULL && $get_ware_id == NULL) || ($get_goods_id != NULL && $get_ware_id != NULL)){
//��ʧ�Ȳ񡦺߸˾Ȳ�ξ��
    //ɽ��
//    $form->addElement("submit","show_button","ɽ����","onClick=\"javascript:Which_Type('form_output','1-4-106.php','#');\"");
    $form->addElement("submit","show_button","ɽ����","#");
    //���ꥢ
    $form->addElement("button","clear_button","���ꥢ","onClick=\"javascript:location.href='1-4-105.php?ware_id=".$get_ware_id."&goods_id=".$get_goods_id."'\"");
}else{
//ȯ�����ٹ𡦽в�ͽ������ξ��
    //ɽ��
    $form->addElement("button","show_button","ɽ����","onClick=\"javascript:Button_Submit('show_button_flg','1-4-105.php','true', this)\"");  
    //�Ĥ���
    $form->addElement("button","clear_button","�Ĥ���","onClick=\"window.close()\"");
}

$form->addElement("hidden", "show_button_flg");      //ɽ���ܥ��󲡲�Ƚ��
$form->addElement("hidden", "hdn_goods_id");         //����ID
$form->addElement("hidden", "hdn_ware_id");          //�Ҹ�ID
$form->addElement("hidden", "hdn_g_product_id");     //����ʬ��ID

$form->addElement("hidden", "h_ware_id");            //���������Ҹ�ID
$form->addElement("hidden", "h_goods_cd");           //�������ξ���CD
$form->addElement("hidden", "h_goods_cname");         //�������ξ���̾
$form->addElement("hidden", "h_hand_start");         //�������μ谷������
$form->addElement("hidden", "h_hand_end");           //�������μ谷��λ��

/****************************/
//�ڡ������������
/****************************/
$page_count  = $_POST["f_page1"];       //���ߤΥڡ�����
if($page_count == NULL){
    $offset = 0;
}else{
    $offset = $page_count * 100 - 100;   
}

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["show_button"] == "ɽ����" || $_POST["show_button_flg"] == true){
    //���ߤΥڡ����������
    $page_count = null;
    $offset = 0;
    $client_data["show_button_flg"]     = "";        //ɽ���ܥ���
    $form->setConstants($client_data);

    /****************************/
    //POST�������
    /****************************/
    if($_POST["form_ware"] != NULL){
        $ware_id    = $_POST["form_ware"];        //�Ҹ�ID
        $set_data["h_ware_id"] = stripslashes($ware_id);
//      $ware_data["h_ware_id"] = stripslashes($ware_id);
//      $form->setConstants($ware_data);
    }
    if($_POST["form_goods_cd"] != NULL){
        $goods_cd   = $_POST["form_goods_cd"];    //����CD
        $set_data["h_goods_cd"] = stripslashes($goods_cd);
//      $goods_data["h_goods_cd"] = stripslashes($goods_cd);
//      $form->setConstants($goods_data);
    }
    if($_POST["form_goods_cname"] != NULL){
        $goods_cname = $_POST["form_goods_cname"];  //����̾
        $set_data["h_goods_cname"] = stripslashes($goods_cname);
//      $goods2_data["h_goods_cname"] = stripslashes($goods_cname);
//      $form->setConstants($goods2_data);
    }
    //�谷������
    if($_POST["form_hand_day"]["sy"] != NULL && $_POST["form_hand_day"]["sm"] != NULL && $_POST["form_hand_day"]["sd"] != NULL){
        $hand_start = $_POST["form_hand_day"]["sy"]."-".$_POST["form_hand_day"]["sm"]."-".$_POST["form_hand_day"]["sd"];
        //2009-10-20 aoyama-n
		$y_day = str_pad($_POST["form_hand_day"]["sy"],4, 0, STR_PAD_LEFT);  
		$m_day = str_pad($_POST["form_hand_day"]["sm"],2, 0, STR_PAD_LEFT); 
		$d_day = str_pad($_POST["form_hand_day"]["sd"],2, 0, STR_PAD_LEFT); 
        $hand_start   = $y_day."-".$m_day."-".$d_day;
        $set_data["h_hand_start"] = stripslashes($hand_start);
//      $start_data["h_hand_start"] = stripslashes($hand_start);
//      $form->setConstants($start_data);
    }
    //�谷��λ��
    if($_POST["form_hand_day"]["ey"] != NULL && $_POST["form_hand_day"]["em"] != NULL && $_POST["form_hand_day"]["ed"] != NULL){
		$y_day = str_pad($_POST["form_hand_day"]["ey"],4, 0, STR_PAD_LEFT);  
		$m_day = str_pad($_POST["form_hand_day"]["em"],2, 0, STR_PAD_LEFT); 
		$d_day = str_pad($_POST["form_hand_day"]["ed"],2, 0, STR_PAD_LEFT); 
        $hand_end   = $y_day."-".$m_day."-".$d_day;
        $set_data["h_hand_end"] = stripslashes($hand_end);
//      $form->setConstants($end_data);
    }
    //����ʬ��
    if($_POST["form_g_product"] != null){
        $g_product_id = $_POST["form_g_product"];
        $set_data["hdn_g_product_id"] = $g_product_id;
    }
    $form->setConstants($set_data);

    //2009-10-12 aoyama-n
    //���Ϸ���
    if($_POST["form_output_type"] != null){
        $output_type = $_POST["form_output_type"];
    }

//ɽ���ܥ��󤬲�����Ƥ��ʤ����ʥڡ���������
}else if(count($_POST) > 0 && ($_POST["show_button"] != "ɽ����" || $_POST["show_button_flg"] != true)){

    /****************************/
    //POST�������
    /****************************/
    if($_POST["h_ware_id"] != NULL){
        $ware_id    = $_POST["h_ware_id"];     //�Ҹ�ID
    }
    if($_POST["h_goods_cd"] != NULL){
        $goods_cd   = $_POST["h_goods_cd"];    //����CD
    }
    if($_POST["h_goods_cname"] != NULL){
        $goods_cname = $_POST["h_goods_cname"];  //����̾
    }
    //�谷������
    if($_POST["h_hand_start"] != NULL){
        $hand_start = $_POST["h_hand_start"];
    }
    //�谷��λ��
    if($_POST["h_hand_end"] != NULL){
        $hand_end   = $_POST["h_hand_end"];
    }
    //����ʬ��
    if($_POST["hdn_g_product_id"] != null){
        $g_product_id = $_POST["hdn_g_product_id"];
    }
    //2009-10-12 aoyama-n
    //���Ϸ���
    if($_POST["form_output_type"] != null){
        $output_type = $_POST["form_output_type"];
    }
//���ɽ�������ꥢ�ܥ��󤬲����줿���
}else{
//    $hand_start = $max_close_day;
    $hand_start = $plus1_date;
    //2009-10-12 aoyama-n
    $output_type = "1";              //���Ϸ���   

    #2009-10-21 hashimoto-y
    $set_data["h_hand_start"] = $hand_start;
    $form->setConstants($set_data);
}

/****************************/
//���顼�����å�(PHP)
/****************************/
$error_flg = false;             //���顼Ƚ��ե饰
/*
//���谷������
//�����������������å�
if ($_POST["show_button"] != null && 
    ($_POST["form_hand_day"]["sy"] != null || $_POST["form_hand_day"]["sm"] != null || $_POST["form_hand_day"]["sd"] != null)){
    $day_y = (int)$_POST["form_hand_day"]["sy"];
    $day_m = (int)$_POST["form_hand_day"]["sm"];
    $day_d = (int)$_POST["form_hand_day"]["sd"];
    if(!checkdate($day_m,$day_d,$day_y)){
        $error = "�谷���� �θ����ˤϡ�ǯ�סַ�ס����פ�����ɬ�����ϤǤ���";
        $error_flg = true;
    }
}
*/
#2009-10-09_1 hashimoto-y
if ($_POST["show_button"] != null && 
    ($_POST["form_hand_day"]["sy"] != null || $_POST["form_hand_day"]["sm"] != null || $_POST["form_hand_day"]["sd"] != null)){
    if ($_POST["form_hand_day"]["sy"] == null || $_POST["form_hand_day"]["sm"] == null || $_POST["form_hand_day"]["sd"] == null){
        $error = "�谷���� �������θ����ˤϡ�ǯ�סַ�ס����פ�����ɬ�����ϤǤ���";
        $error_flg = true;
    }elseif (!ereg("^[0-9]+$", $_POST["form_hand_day"]["sy"]) ||
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["sm"]) || 
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["sd"])){
        $error = "�谷���� �������ǤϤ���ޤ���";
        $error_flg = true;
    }elseif(!checkdate((int)$_POST["form_hand_day"]["sm"], (int)$_POST["form_hand_day"]["sd"], (int)$_POST["form_hand_day"]["sy"])){
        $error = "�谷���� �������ǤϤ���ޤ���";
        $error_flg = true;
    }
}


//���谷���ֽ�λ��
//�����������������å�
// ǯ�����Τ����줫��NULL��������
if ($_POST["show_button"] != null && 
    $_POST["form_hand_day"]["ey"] == null || $_POST["form_hand_day"]["em"] == null || $_POST["form_hand_day"]["ed"] == null){
    // ��ǯ�������Ƥ�NULL�פǤϤʤ����
    if (!($_POST["form_hand_day"]["ey"] == null && $_POST["form_hand_day"]["em"] == null && $_POST["form_hand_day"]["ed"] == null)){
        $error = "�谷���� ��λ���θ����ˤϡ�ǯ�סַ�ס����פ�����ɬ�����ϤǤ���";
        $error_flg = true;
    }
}else{
    if (!ereg("^[0-9]+$", $_POST["form_hand_day"]["ey"]) ||
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["em"]) || 
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["ed"])){
        $error = "�谷���� �������ǤϤ���ޤ���";
        $error_flg = true;
    }
    if(!checkdate((int)$_POST["form_hand_day"]["em"], (int)$_POST["form_hand_day"]["ed"], (int)$_POST["form_hand_day"]["ey"])){
        $error = "�谷���� �������ǤϤ���ޤ���";
        $error_flg = true;
    }
}
/*
//������Υǡ��������
$sql  = "SELECT \n";
$sql .= "   MAX(close_day) AS renew_date\n";
$sql .= " FROM \n";
$sql .= "   t_sys_renew \n";
$sql .= " WHERE \n";
$sql .= "   renew_div = '2'\n";
$sql .= "   AND \n";
$sql .= "   shop_id = $shop_id\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$renew_day = pg_fetch_result($result, 0,0);         //�������
*/
/*
//���˷������ԤäƤ�����ǡ��谷���ֳ����������ꤵ�줿���
if($renew_day != null && $hand_start != null){

    $sql  = "SELECT \n";
    $sql .= "   COUNT(*) \n";
    $sql .= "FROM\n";
    $sql .= "   t_sys_renew \n";
    $sql .= "WHERE\n";
    $sql .= "   close_day = '$hand_start'\n";
    $sql .= "   AND\n";
    $sql .= "   renew_div = '2'\n";
    $sql .= "   AND\n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $day_count = pg_fetch_result($result, 0,0);

    if($day_count == 0){
        $error = "�谷���֤γ������ˤϼ��Ҥ���������ꤷ�Ƥ���������";
        $error_flg = true;
    }else{
        $renew_day = $hand_start;
    }
}

/****************************/
//������ʧ�ǡ�������SQL
/****************************/
// �谷���ֳ�������NULL�ξ��ϥ����ƥ೫����������
$hand_start = ($hand_start == null || $hand_start == '--') ? START_DAY : $hand_start;



#2010-05-12 hashimoto-y
if( ($_POST["show_button"] == "ɽ����" || $_POST["show_button_flg"] == true) || (count($_POST) > 0 && ($_POST["show_button"] != "ɽ����" || $_POST["show_button_flg"] != true)) ){

//���顼�ξ���ɽ����Ԥʤ�ʤ�
if($error_flg == false){

    //2009-10-12 aoyama-n
    //���Ϸ������ֲ��̡פξ��
    #2010-01-08 aoyama-n
    #if($output_type == "1"){
    if($output_type != "2"){

        $sql  = "SELECT \n";
        $sql .= "   t_ware.ware_name, \n";                              // �Ҹ�̾
        $sql .= "   t_goods.goods_cd, \n";                              // ���ʥ�����
        $sql .= "   t_goods.goods_name, \n";                            // ����̾
        $sql .= "   t_stock_total.ware_id, \n";                         // �߸˽��פ��Ҹ�ID
        $sql .= "   t_stock_total.goods_id, \n";                        // �߸˽��פξ���ID
        $sql .= "   COALESCE(t_stock_total.old_count,0) AS zenzai, \n";             // ���ĺ߸�
        $sql .= "   COALESCE(t_stock_total.in_count,0)  AS nyuuko, \n";             // ���˿�
        $sql .= "   COALESCE(t_stock_total.out_count,0) AS syukko, \n";             // �и˿�
        $sql .= "   COALESCE(t_stock_total.old_count,0) \n";
        $sql .= "   + COALESCE(t_stock_total.in_count,0) \n";
        $sql .= "   - COALESCE(t_stock_total.out_count,0) AS genzai, \n";           // ���߸˿�
        $sql .= "   t_g_product.g_product_name \n";

        $sql .= "FROM \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           stock_hand.ware_id, \n";
        $sql .= "           stock_hand.goods_id, \n";
        $sql .= "           stock_hand.shop_id, \n";
        $sql .= "           t_ware_in.in_count, \n";
        $sql .= "           t_ware_out.out_count, \n";
        //2009-10-11 aoyama-n
        #$sql .= "           COALESCE(t_last_stock_num1.old_count1, 0) + COALESCE(t_last_stock_num2.old_count2, 0) AS old_count \n";
        $sql .= "           COALESCE(t_last_stock_num1.old_count1, 0) AS old_count \n";
        $sql .= "       FROM \n";
                            // ���Ҹˡ����ʡ�����åפμ�ʧ����ʼ�ʧ�ơ��֥�˰�����ȯ��İʳ�
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   ware_id, \n";
        $sql .= "                   goods_id, \n";
        $sql .= "                   shop_id, \n";
        $sql .= "                   ware_id || '-' || goods_id AS ware_goods_id \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_stock_hand \n";
        $sql .= "               WHERE \n";
        $sql .= "                   shop_id = $shop_id \n";
        if($hand_end != NULL){
        $sql .= "               AND \n";
        $sql .= "                   work_day <= '$hand_end' \n";
        }
        $sql .= "               AND \n";
        $sql .= "                   work_div NOT IN ('1', '3') \n";
        $sql .= "               GROUP BY \n";
        $sql .= "                   ware_id, goods_id, shop_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS stock_hand \n";
                            // �����˿��ʼ�ʧ�ơ��֥�˰�����ȯ��ġ������ƥ೫�Ϻ߸�Ĵ���ʳ�
        $sql .= "           LEFT JOIN \n";
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   ware_id || '-' || goods_id AS ware_goods_id, \n";
        $sql .= "                   SUM(num) AS in_count \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_stock_hand \n";
        $sql .= "               WHERE \n";
        $sql .= "                   shop_id = $shop_id \n";
        $sql .= "               AND \n";
        $sql .= "                   '$hand_start' <= work_day \n";
        if($hand_end != NULL){
        $sql .= "               AND \n";
        $sql .= "                   work_day <= '$hand_end' \n";
        }
        $sql .= "               AND \n";
        $sql .= "                   io_div = '1' \n";
        $sql .= "               AND \n";
        $sql .= "                   work_div NOT IN ('1', '3') \n";
        //2009-10-12 aoyama-n
        #$sql .= "               AND \n";
        #$sql .= "                   NOT (work_div = '6' AND adjust_reason = '1') \n";
        $sql .= "               GROUP BY \n";
        $sql .= "                   ware_id, goods_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS t_ware_in \n";
        $sql .= "           ON stock_hand.ware_goods_id = t_ware_in.ware_goods_id \n";
                        // ���и˿��ʼ�ʧ�ơ��֥�˰�����ȯ��ġ������ƥ೫�Ϻ߸�Ĵ���ʳ�
        $sql .= "           LEFT JOIN \n";
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   ware_id || '-' || goods_id AS ware_goods_id,\n";
        $sql .= "                   SUM (num) AS out_count \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_stock_hand \n";
        $sql .= "               WHERE \n";
        $sql .= "                   shop_id = $shop_id \n";
        $sql .= "               AND \n";
        $sql .= "                   '$hand_start' <= work_day \n";
        if($hand_end != NULL){
        $sql .= "               AND \n";
        $sql .= "                   work_day <= '$hand_end' \n";
        }
        $sql .= "               AND \n";
        $sql .= "                   io_div = '2' \n";
        $sql .= "               AND \n";
        $sql .= "                   work_div NOT IN ('1', '3') \n";
        //2009-10-12 aoyama-n
        #$sql .= "               AND \n";
        #$sql .= "                   NOT (work_div = '6' AND adjust_reason = '1') \n";
        $sql .= "               GROUP BY \n";
        $sql .= "                   ware_id, goods_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS t_ware_out \n";
        $sql .= "           ON stock_hand.ware_goods_id = t_ware_out.ware_goods_id \n";
                        // �����ĺ߸�1/2�ʼ�ʧ�ơ��֥�˼谷���ֳ�����������μ�ʧ�ǡ����ʰ�����ȯ��Ĥ������
        $sql .= "           LEFT JOIN \n";
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   ware_id || '-' || goods_id AS ware_goods_id, \n";
        $sql .= "                   SUM(COALESCE(num, 0) * \n";
        $sql .= "                       CASE io_div \n";
        $sql .= "                           WHEN '1' THEN 1 \n";
        $sql .= "                           WHEN '2' THEN -1 \n";
        $sql .= "                       END \n";
        $sql .= "                   ) \n";
        $sql .= "                   AS old_count1 \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_stock_hand \n";
        $sql .= "               WHERE \n";
        $sql .= "                   shop_id = $shop_id \n";
        $sql .= "               AND \n";
        $sql .= "                   work_day < '$hand_start' \n";
        $sql .= "               AND \n";
        $sql .= "                   work_div NOT IN ('1', '3') \n";
        $sql .= "               GROUP BY \n";
        $sql .= "                   ware_id, goods_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS t_last_stock_num1 \n";
        $sql .= "           ON stock_hand.ware_goods_id = t_last_stock_num1.ware_goods_id \n";
                        // �����ĺ߸�2/2�ʼ�ʧ�ơ��֥�˼谷���ֳ������ʹߤΥ����ƥ೫�Ϻ߸�Ĵ��
        //2009-10-12 aoyama-n
        #$sql .= "           LEFT JOIN \n";
        #$sql .= "           ( \n";
        #$sql .= "               SELECT \n";
        #$sql .= "                   ware_id || '-' || goods_id AS ware_goods_id, \n";
        #$sql .= "                   SUM(COALESCE(num, 0) * \n";
        #$sql .= "                       CASE io_div \n";
        #$sql .= "                           WHEN '1' THEN 1 \n";
        #$sql .= "                           WHEN '2' THEN -1 \n";
        #$sql .= "                       END \n";
        #$sql .= "                   ) \n";
        #$sql .= "                   AS old_count2 \n";
        #$sql .= "               FROM \n";
        #$sql .= "                   t_stock_hand \n";
        #$sql .= "               WHERE \n";
        #$sql .= "                   shop_id = $shop_id \n";
        #$sql .= "               AND \n";
        #$sql .= "                   '$hand_start' <= work_day \n";
        #$sql .= "               AND \n";
        #$sql .= "                   work_div = '6' AND adjust_reason = '1' \n";
        #$sql .= "               GROUP BY \n";
        #$sql .= "                   ware_id, goods_id \n";
        #$sql .= "           ) \n";
        #$sql .= "           AS t_last_stock_num2 \n";
        #$sql .= "           ON stock_hand.ware_goods_id = t_last_stock_num2.ware_goods_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS t_stock_total \n";

        $sql .= "   INNER JOIN t_ware ON t_ware.ware_id = t_stock_total.ware_id \n";
        $sql .= "   INNER JOIN t_goods ON t_goods.goods_id = t_stock_total.goods_id \n";
        $sql .= "   INNER JOIN t_client ON t_client.client_id = t_stock_total.shop_id \n";
        $sql .= "   INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
        #2009-10-09 hashimoto-y
        $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

        $sql .= "WHERE \n";
        #2009-10-09 hashimoto-y
        #$sql .= "   t_goods.stock_manage = '1' \n";
        $sql .= "   t_goods_info.stock_manage = '1' \n";
        $sql .= "   AND \n";
        $sql .= "   t_goods_info.shop_id = $shop_id ";

        // GET����˾���ID�����ä����
        $sql .= ($get_goods_id != NULL) ?   "AND t_stock_total.goods_id = $get_goods_id \n" : null;
        // GET������Ҹ�ID�����ä����
        $sql .= ($get_ware_id != NULL) ?    "AND t_stock_total.ware_id = $get_ware_id \n" : null;
        // �Ҹ�ID�����ꤵ��Ƥ�����
        $sql .= ($ware_id != NULL) ?        "AND t_stock_total.ware_id = $ware_id \n" : null;
        // ����ʬ�ब���ꤵ��Ƥ�����
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // ����CD�����ꤵ��Ƥ�����
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //����̾�����ꤵ��Ƥ�����
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;

        $sql .= "ORDER BY \n";
        $sql .= "   t_ware.ware_cd, t_g_product.g_product_cd, t_goods.goods_cd \n";

        $result = Db_Query($db_con,$sql."LIMIT 100 OFFSET $offset;\n");
        $page_data = Get_Data($result);

        for($x=0;$x<count($page_data);$x++){
            for($j=0;$j<count($page_data[$x]);$j++){
                //���˿��Ϸ����ѹ�
                if($j==5){
                    $page_data[$x][$j] = number_format($page_data[$x][$j]);
                //�и˿��Ϸ����ѹ�
                }else if($j==6){
                    $page_data[$x][$j] = number_format($page_data[$x][$j]);
                }
            }
        }

        $result = Db_Query($db_con,$sql.";");
        //�����
        $total_count = pg_num_rows($result);

        //ɽ���ϰϻ���
        $range = "100";


    //2009-10-12 aoyama-n
    //���Ϸ�������CSV�פξ��
    }else{

        $sql  = "SELECT\n";
        $sql .= "  work_day,\n";
        $sql .= "  g_product_cd,\n";
        $sql .= "  g_product_name,\n";
        $sql .= "  goods_cd,\n";
        $sql .= "  goods_name,\n";
        $sql .= "  num,\n";
        $sql .= "  price,\n";
        $sql .= "  work_div,\n";
        $sql .= "  io_div,\n";
        $sql .= "  client_cname \n";
        $sql .= "FROM\n";
        //���ǡ���
        $sql .= "  (SELECT\n";
        $sql .= "    t_stock_hand.work_day,\n";
        $sql .= "    t_g_product.g_product_cd,\n";
        $sql .= "    t_g_product.g_product_name,\n";
        $sql .= "    t_goods.goods_cd,\n";
        $sql .= "    t_goods.goods_name,\n";
        $sql .= "    t_stock_hand.num,\n";
        $sql .= "    t_sale_d.sale_price AS price,\n";
        $sql .= "    '���' AS work_div,\n";
        $sql .= "    CASE io_div WHEN 1 THEN '����' WHEN 2 THEN '�и�' END AS io_div,\n";
        $sql .= "    t_stock_hand.client_cname\n";
        $sql .= "  FROM\n";
        $sql .= "    t_stock_hand INNER JOIN t_sale_d\n";
        $sql .= "    ON t_stock_hand.sale_d_id = t_sale_d.sale_d_id\n";
        $sql .= "    INNER JOIN t_goods\n";
        $sql .= "    ON t_stock_hand.goods_id = t_goods.goods_id\n";
        $sql .= "    INNER JOIN t_goods_info\n";
        $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id\n";
        $sql .= "    LEFT JOIN t_g_product\n";
        $sql .= "    ON t_goods.g_product_id = t_g_product.g_product_id\n";
        $sql .= "  WHERE\n";
        $sql .= "    t_stock_hand.shop_id = $shop_id\n";
        $sql .= "    AND t_stock_hand.work_div = '2'\n";
        $sql .= "    AND t_stock_hand.work_day >= '$hand_start'\n";
        if($hand_end != NULL){
        $sql .= "    AND t_stock_hand.work_day <= '$hand_end'\n";
        }
        $sql .= "    AND t_goods_info.stock_manage = '1'\n";
        $sql .= "    AND t_goods_info.shop_id = $shop_id\n";
 
        // GET����˾���ID�����ä����
        #$sql .= ($get_goods_id != NULL) ?   "AND t_stock_hand.goods_id = $get_goods_id \n" : null;
        // GET������Ҹ�ID�����ä����
        #$sql .= ($get_ware_id != NULL) ?    "AND t_stock_hand.ware_id = $get_ware_id \n" : null;
        // �Ҹ�ID�����ꤵ��Ƥ�����
        $sql .= ($ware_id != NULL) ?        "AND t_stock_hand.ware_id = $ware_id \n" : null;
        // ����ʬ�ब���ꤵ��Ƥ�����
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // ����CD�����ꤵ��Ƥ�����
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //����̾�����ꤵ��Ƥ�����
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;
 
        $sql .= "  UNION ALL\n";
        //�����ǡ���
        $sql .= "  SELECT\n";
        $sql .= "    t_stock_hand.work_day,\n";
        $sql .= "    t_g_product.g_product_cd,\n";
        $sql .= "    t_g_product.g_product_name,\n";
        $sql .= "    t_goods.goods_cd,\n";
        $sql .= "    t_goods.goods_name,\n";
        $sql .= "    t_stock_hand.num,\n";
        $sql .= "    t_buy_d.buy_price AS price,\n";
        $sql .= "    '����' AS work_div,\n";
        $sql .= "    CASE io_div WHEN 1 THEN '����' WHEN 2 THEN '�и�' END AS io_div,\n";
        $sql .= "    t_stock_hand.client_cname\n";
        $sql .= "  FROM\n";
        $sql .= "    t_stock_hand INNER JOIN t_buy_d\n";
        $sql .= "    ON t_stock_hand.buy_d_id = t_buy_d.buy_d_id\n";
        $sql .= "    INNER JOIN t_goods\n";
        $sql .= "    ON t_stock_hand.goods_id = t_goods.goods_id\n";
        $sql .= "    INNER JOIN t_goods_info\n";
        $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id\n";
        $sql .= "    LEFT JOIN t_g_product\n";
        $sql .= "    ON t_goods.g_product_id = t_g_product.g_product_id\n";
        $sql .= "  WHERE\n";
        $sql .= "    t_stock_hand.shop_id = $shop_id\n";
        $sql .= "    AND t_stock_hand.work_div = '4'\n";
        $sql .= "    AND t_stock_hand.work_day >= '$hand_start'\n";
        if($hand_end != NULL){
        $sql .= "    AND t_stock_hand.work_day <= '$hand_end'\n";
        }
        $sql .= "    AND t_goods_info.stock_manage = '1'\n";
        $sql .= "    AND t_goods_info.shop_id = $shop_id\n";
 
        // GET����˾���ID�����ä����
        #$sql .= ($get_goods_id != NULL) ?   "AND t_stock_hand.goods_id = $get_goods_id \n" : null;
        // GET������Ҹ�ID�����ä����
        #$sql .= ($get_ware_id != NULL) ?    "AND t_stock_hand.ware_id = $get_ware_id \n" : null;
        // �Ҹ�ID�����ꤵ��Ƥ�����
        $sql .= ($ware_id != NULL) ?        "AND t_stock_hand.ware_id = $ware_id \n" : null;
        // ����ʬ�ब���ꤵ��Ƥ�����
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // ����CD�����ꤵ��Ƥ�����
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //����̾�����ꤵ��Ƥ�����
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;
 
        $sql .= "  UNION ALL\n";
        //Ĵ���ǡ���
        $sql .= "  SELECT\n";
        $sql .= "    t_stock_hand.work_day,\n";
        $sql .= "    t_g_product.g_product_cd,\n";
        $sql .= "    t_g_product.g_product_name,\n";
        $sql .= "    t_goods.goods_cd,\n";
        $sql .= "    t_goods.goods_name,\n";
        $sql .= "    t_stock_hand.num,\n";
        $sql .= "    t_stock_hand.adjust_price AS price,\n";
        $sql .= "    'Ĵ��' AS work_div,\n";
        $sql .= "    CASE io_div WHEN 1 THEN '����' WHEN 2 THEN '�и�' END AS io_div,\n";
        $sql .= "    '���Ҹ�' AS client_cname\n";
        $sql .= "  FROM\n";
        $sql .= "    t_stock_hand INNER JOIN t_goods\n";
        $sql .= "    ON t_stock_hand.goods_id = t_goods.goods_id\n";
        $sql .= "    INNER JOIN t_goods_info\n";
        $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id\n";
        $sql .= "    LEFT JOIN t_g_product\n";
        $sql .= "    ON t_goods.g_product_id = t_g_product.g_product_id\n";
        $sql .= "  WHERE\n";
        $sql .= "    t_stock_hand.shop_id = $shop_id\n";
        $sql .= "    AND t_stock_hand.work_div = '6'\n";
        $sql .= "    AND t_stock_hand.work_day >= '$hand_start'\n";
        if($hand_end != NULL){
        $sql .= "    AND t_stock_hand.work_day <= '$hand_end'\n";
        }
        $sql .= "    AND t_goods_info.stock_manage = '1'\n";
        $sql .= "    AND t_goods_info.shop_id = $shop_id\n";
        // GET����˾���ID�����ä����
        #$sql .= ($get_goods_id != NULL) ?   "AND t_stock_hand.goods_id = $get_goods_id \n" : null;
        // GET������Ҹ�ID�����ä����
        #$sql .= ($get_ware_id != NULL) ?    "AND t_stock_hand.ware_id = $get_ware_id \n" : null;
        // �Ҹ�ID�����ꤵ��Ƥ�����
        $sql .= ($ware_id != NULL) ?        "AND t_stock_hand.ware_id = $ware_id \n" : null;
        // ����ʬ�ब���ꤵ��Ƥ�����
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // ����CD�����ꤵ��Ƥ�����
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //����̾�����ꤵ��Ƥ�����
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;
   
        //2009-10-20 aoyama-n
        $sql .= "  UNION ALL\n";
        //��ư����Ω�ǡ���
        $sql .= "  SELECT\n";
        $sql .= "    t_stock_hand.work_day,\n";
        $sql .= "    t_g_product.g_product_cd,\n";
        $sql .= "    t_g_product.g_product_name,\n";
        $sql .= "    t_goods.goods_cd,\n";
        $sql .= "    t_goods.goods_name,\n";
        $sql .= "    t_stock_hand.num,\n";
        $sql .= "    NULL AS price,\n";
        $sql .= "    CASE work_div WHEN '5' THEN '��ư' WHEN '7' THEN '��Ω' END AS work_div,\n";
        $sql .= "    CASE io_div WHEN 1 THEN '����' WHEN 2 THEN '�и�' END AS io_div,\n";
        $sql .= "    COALESCE( client_cname,'���Ҹ�' ) AS client_cname\n";
        $sql .= "  FROM\n";
        $sql .= "    t_stock_hand INNER JOIN t_goods\n";
        $sql .= "    ON t_stock_hand.goods_id = t_goods.goods_id\n";
        $sql .= "    INNER JOIN t_goods_info\n";
        $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id\n";
        $sql .= "    LEFT JOIN t_g_product\n";
        $sql .= "    ON t_goods.g_product_id = t_g_product.g_product_id\n";
        $sql .= "  WHERE\n";
        $sql .= "    t_stock_hand.shop_id = $shop_id\n";
        $sql .= "    AND t_stock_hand.work_div IN ('5', '7')\n";
        $sql .= "    AND t_stock_hand.work_day >= '$hand_start'\n";
        if($hand_end != NULL){
        $sql .= "    AND t_stock_hand.work_day <= '$hand_end'\n";
        }
        $sql .= "    AND t_goods_info.stock_manage = '1'\n";
        $sql .= "    AND t_goods_info.shop_id = $shop_id\n";
        // GET����˾���ID�����ä����
        #$sql .= ($get_goods_id != NULL) ?   "AND t_stock_hand.goods_id = $get_goods_id \n" : null;
        // GET������Ҹ�ID�����ä����
        #$sql .= ($get_ware_id != NULL) ?    "AND t_stock_hand.ware_id = $get_ware_id \n" : null;
        // �Ҹ�ID�����ꤵ��Ƥ�����
        $sql .= ($ware_id != NULL) ?        "AND t_stock_hand.ware_id = $ware_id \n" : null;
        // ����ʬ�ब���ꤵ��Ƥ�����
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // ����CD�����ꤵ��Ƥ�����
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //����̾�����ꤵ��Ƥ�����
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;

        $sql .= "  ) AS stock_hand\n";
        $sql .= "ORDER BY g_product_cd,goods_cd,work_day\n";
 
        //SQL�¹�
        $res        = Db_Query($db_con, $sql);
        $stock_hand_data = Get_Data($res, $output_type);
   
        //CSV�ե�����̾
        $csv_file_name = "�߸˲�׾���".date("Ymd").".csv";
  
        // CSV�Υ����ȥ�
        $csv_header = array(
                    "��ʧ��",
                    "����ʬ�ॳ����",
                    "����ʬ��̾",
                    "���ʥ�����",
                    "����̾",
                    "��ʧ��",
                    "ñ��",
                    "��ȶ�ʬ",
                    "���и˶�ʬ",
                    "��ʧ��"
        );
 
        //������η�̤򥻥å�
        $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
        $csv_data = Make_Csv($stock_hand_data, $csv_header);
 
        //CSV����
        Header("Content-disposition: attachment; filename=$csv_file_name");
        Header("Content-type: application/octet-stream; name=$csv_file_name");
        print $csv_data;
        exit;
  
    }
    
}else{
    //�����
    $total_count = 0;
    //ɽ���ϰϻ���
    $range = "100";
}

#2010-05-12 hashimoto-y
$display_flg = true;
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
//$page_menu = Create_Menu_h('stock','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["4_101_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_105_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_110_button"]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'hand_start'    => "$hand_start",
    'hand_end'      => "$hand_end",
    'error'         => "$error",
    'get_goods_id'  => "$get_goods_id",
    'get_ware_id'   => "$get_ware_id",
    'display_flg'    => "$display_flg",
));
$smarty->assign('row',$page_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
