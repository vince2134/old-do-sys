<?php
/*********************
�ѹ�����
    (2006/05/23)URL����Ͽ����褦���ѹ�
    (2006/05/26)�ޡ�������Ͽ����褦���ѹ�
    (2006/07/31)���Ƕ�ʬ����ǡ�����Ǥ��ѹ�
    (2006/08/01)ά����ʸ�����ѹ�
    (2006/08/02)RtoR��Ͽ��ǽ���ɲ�
    (2006/08/21)�ѹ����������򿷵����ʥޥ�����Ͽ���̤��ѹ�
    (2006/10/23)���ʥ���Х��URL�򥨥������פ���褦���ѹ�
    (2006/10/23)GET�η������å����ɲ�
    (2006/11/30)���ꥢ������������ɲ�
*********************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-01-22      �����ѹ�����watanabe-k���ܥ���ο����ѹ�
 *  2007-03-19              ����watanabe-k���ѹ�����������ñ������˽���
 *  2007-04-26      ����¾      kajioka-h   ����������ޥ�����FC�ޥ�����ʻ�礵�줿�Τ�ȼ�����������FC���ѹ�
 *  2007-06-25      ����¾      watanabe-k  ���ʥޥ������ѹ������ޥ�����ͽ��ǡ�����ȿ�Ǥ���������ɲ�
 *  2009-09-21      	        watanabe-k  ������maxlength��5���ѹ�
 *  2009-10-06                  hashimoto-y �߸˴����ե饰���ʥޥ������饷��å��̾��ʾ���ơ��֥���ѹ�
 *   2016/01/20                amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�    
 */

$page_title = "���ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //�����Ϣ�δؿ�


//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

//DB����³    
$conn = Db_connect();    

// ���¥����å�
$auth       = Auth_Check($conn);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];

$get_goods_id = $_GET["goods_id"];                          //GET��������ID

/****************************/
//���������
/****************************/
$defa_data["form_state"] = 1;
$defa_data["form_rental"] = 'f';
$defa_data["form_serial"] = 'f';
$defa_data["form_accept"] = 2;
$form->setDefaults($defa_data);

//GET��������
if($_GET["goods_id"] != null){
    $get_flg = true;                                            //GET�ե饰

    Get_Id_Check3($_GET["goods_id"]);

    $sql  = " SELECT";
    $sql .= "   t_goods.goods_cd,";                             //���ʥ�����
    $sql .= "   t_goods.goods_name,";                           //����̾
    $sql .= "   t_goods.goods_cname,";                          //ά��
    $sql .= "   t_goods.attri_div,";                            //°����ʬ
    $sql .= "   t_g_goods.g_goods_id,";                         //�Ͷ�ʬID�ʣͶ�ʬ��
    $sql .= "   t_product.product_id,";                         //������ʬID�ʴ�����ʬ��
    $sql .= "   t_goods.unit,";                                 //ñ��
    $sql .= "   t_goods.in_num,";                               //����
    $sql .= "   client1.client_cd1,";                           //������1������1
    $sql .= "   client1.client_cname,";                         //������̾
    $sql .= "   client2.client_cd1,";                           //������2������1
    $sql .= "   client2.client_cname,";                         //������̾2
    $sql .= "   client3.client_cd1,";                           //������3������1
    $sql .= "   client3.client_cname,";                         //������̾3
    $sql .= "   t_goods.sale_manage,";                          //�������
    #2009-10-06 hashimoto-y
    #$sql .= "   t_goods.stock_manage,";                         //�߸˴���
    $sql .= "   t_goods_info.stock_manage,";                         //�߸˴���
    $sql .= "   t_goods.stock_only,";                           //�߸˸¤���
    $sql .= "   t_goods_info.order_point,";                     //ȯ����
    $sql .= "   t_goods_info.order_unit, ";                     //ȯ��ñ�̿�
    $sql .= "   t_goods_info.lead,";                            //�꡼�ɥ����������
    $sql .= "   t_goods.name_change,";                          //��̾�ѹ�
    $sql .= "   t_goods.tax_div,";                              //���Ƕ�ʬ
    $sql .= "   t_goods.royalty,";                              //�����ƥ���̵ͭ��
    $sql .= "   t_goods_info.note, ";                           //����
    $sql .= "   t_goods.state, ";                               //����
    $sql .= "   t_goods.url,";
    $sql .= "   t_goods.mark_div,";
	$sql .= "   t_g_product.g_product_id,";                     //����ʬ��ID
    $sql .= "   t_goods.accept_flg,";                           //��ǧ�ե饰
    $sql .= "   t_goods.no_change_flg,";                        //�ѹ��Բĥե饰
    $sql .= "   t_goods.rental_flg,";                           //RtoR
	$sql .= "   t_goods.serial_flg,";                           //���ꥢ�����
    $sql .= "   client1.client_cd2,";                           //������1������2 32
    $sql .= "   client2.client_cd2,";                           //������2������2 33
    $sql .= "   client3.client_cd2 ";                           //������3������2 34
    $sql .= " FROM";
    $sql .= "   t_goods,";                                      //���ʥޥ���
    $sql .= "   t_g_goods,";                                    //�Ͷ�ʬ�ޥ���
    $sql .= "   t_product,";                                    //������ʬ�ޥ���
	$sql .= "   t_g_product,";                                  //����ʬ��ޥ���
    $sql .= "   t_goods_info";                                  //����å��̾��ʾ���ơ��֥�
    
    $sql .= " LEFT JOIN";
    $sql .= "   t_client AS client1 ";                          //������ޥ���
    $sql .= " ON t_goods_info.supplier_id = client1.client_id";
    
    $sql .= " LEFT JOIN";
    $sql .= "   t_client AS client2 ";                          //������ޥ���
    $sql .= " ON t_goods_info.supplier_id2 = client2.client_id";
    
    $sql .= " LEFT JOIN";
    $sql .= "   t_client AS client3 ";                          //������ޥ���
    $sql .= " ON t_goods_info.supplier_id3 = client3.client_id";
    
    $sql .= " WHERE";
    $sql .= "   t_goods.goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods.public_flg = 't'";
    $sql .= "   AND";
    $sql .= "   t_goods.g_goods_id = t_g_goods.g_goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods.product_id = t_product.product_id";
	$sql .= "   AND";
    $sql .= "   t_goods.g_product_id = t_g_product.g_product_id";
    $sql .= "   AND";
    $sql .= "   t_goods.goods_id = t_goods_info.goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods_info.shop_id = $shop_id";
    $sql .= " ;";

    //������ȯ��
    $result = Db_Query($conn, $sql) or die("�����ꥨ�顼");
    Get_Id_Check($result);

    //�ǡ�������
    $get_data = @pg_fetch_array ($result, 0, PGSQL_NUM);

    //����ͥǡ���
    $def_data["form_goods_cd"]          = $get_data[0];         //���ʥ�����
    $def_data["form_goods_name"]        = $get_data[1];         //����̾
    $def_data["form_goods_cname"]       = $get_data[2];         //ά��
    $def_data["form_attri_div"]         = $get_data[3];         //°����ʬ
    $def_data["form_g_goods"]           = $get_data[4];         //�Ͷ�ʬ
    $def_data["form_product"]           = $get_data[5];         //������ʬ
    $def_data["form_unit"]              = $get_data[6];         //ñ��
    $def_data["form_in_num"]            = $get_data[7];         //����
    $def_data["form_supplier"]["cd1"]   = $get_data[8];         //������1������1
    $def_data["form_supplier"]["cd2"]   = $get_data[32];        //������1������2
    $def_data["form_supplier"]["name"]  = $get_data[9];         //������̾
    $def_data["form_supplier2"]["cd1"]  = $get_data[10];        //������2������1
    $def_data["form_supplier2"]["cd2"]  = $get_data[33];        //������2������2
    $def_data["form_supplier2"]["name"] = $get_data[11];        //������̾2
    $def_data["form_supplier3"]["cd1"]  = $get_data[12];        //������3������1
    $def_data["form_supplier3"]["cd2"]  = $get_data[34];        //������3������2
    $def_data["form_supplier3"]["name"] = $get_data[13];        //������̾3
    $def_data["form_sale_manage"]       = $get_data[14];        //�������
    $def_data["form_stock_manage"]      = $get_data[15];        //�߸˴���
    $def_data["form_stock_only"]        = $get_data[16];        //�߸˸¤���
    $def_data["form_order_point"]       = $get_data[17];        //ȯ����
    $def_data["form_order_unit"]        = $get_data[18];        //ȯ��ñ�̿�
    $def_data["form_lead"]              = $get_data[19];        //�꡼�ɥ����������
    $def_data["form_name_change"]       = $get_data[20];        //��̾�ѹ�
    $def_data["form_tax_div"]           = $get_data[21];        //���Ƕ�ʬ
    $def_data["form_royalty"]           = $get_data[22];        //�����ƥ���̵ͭ��
    $def_data["form_note"]              = $get_data[23];        //����
    $def_data["form_state"]             = $get_data[24];        //����
    $def_data["form_url"]               = $get_data[25];        //url
    $def_data["form_mark_div"]          = $get_data[26];        //�ޡ���
	$def_data["form_g_product"]         = $get_data[27];        //����ʬ��
	$def_data["form_accept"]            = $get_data[28];        //��ǧ
	$accept_disp_flg = ($get_data[28] == '1')? true : false;        //ɽ���ե饰

    $album_url = addslashes($get_data[25]); 
    $no_change_flg                      = $get_data[29];        //�ѹ��Բĥե饰
    $def_data["form_rental"]            = $get_data[30];        //RtoR
	$def_data["form_serial"]            = $get_data[31];        //���ꥢ�����

    //��������� 

    $form->setDefaults($def_data);

    //���ء����إܥ������
    $id_data = Make_Get_Id($conn, "goods", $get_data[0],"1");
    $next_id = $id_data[0];
    $back_id = $id_data[1];


    if($no_change_flg == 't'){
        $freeze_flg = true;
    }


    //�ǿ�����������
    $sql  = "SELECT";
    $sql .= "   MAX(work_day) ";
    $sql .= "FROM";
    $sql .= "   t_stock_hand ";
    $sql .= "WHERE";
    $sql .= "   work_div = '2'";
    $sql .= "   AND";
    $sql .= "   goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $max_sale_day = (pg_fetch_result($result, 0,0) != null)? pg_fetch_result($result, 0,0) : "���Ϥ���ޤ���";

    //�ǿ������������
    $sql  = "SELECT";
    $sql .= "   MAX(work_day) ";
    $sql .= "FROM";
    $sql .= "   t_stock_hand ";
    $sql .= "WHERE";
    $sql .= "   work_div = '4'";
    $sql .= "   AND";
    $sql .= "   goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $max_buy_day = (pg_fetch_result($result, 0,0) != null)? pg_fetch_result($result, 0,0) : "�����Ϥ���ޤ���";

}else{
    //����ͥǡ���

    $def_data["form_attri_div"]     = 1;                        //°����ʬ
    $def_data["form_mark_div"]      = 1;                        //�ޡ���
    $def_data["form_sale_manage"]   = 1;                        //�������
    $def_data["form_stock_manage"]  = 1;                        //�߸˴���
    $def_data["form_name_change"]   = 1;                        //��̾�ѹ�
    $def_data["form_tax_div"]       = 1;                        //���Ƕ�ʬ
    $def_data["form_royalty"]       = 1;                        //�����ƥ���̵ͭ��

    //���������
    $form->setDefaults($def_data);
}

/****************************/
//�ե��������
/****************************/
//����
$form_state[] =& $form->createElement( "radio",NULL,NULL, "ͭ��","1");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "̵��","2");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "ͭ����ľ�ġ�","3");
$form->addGroup($form_state, "form_state", "");

//��󥿥�
$form_rental[] =& $form->createElement( "radio",NULL,NULL, "����","t");
$form_rental[] =& $form->createElement( "radio",NULL,NULL, "�ʤ�","f");
$form->addGroup($form_rental, "form_rental", "");

//���ꥢ��
$text = NULL;
$text[] =& $form->createElement("radio",NULL,NULL,"����","t");
$text[] =& $form->createElement("radio",NULL,NULL,"�ʤ�","f");
$form->addGroup($text,"form_serial", "");

//��ǧ
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "��ǧ��","1");
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "̤��ǧ","2");
$freeze = $form->addGroup($form_accept, "form_accept", "");
if($accept_disp_flg == true){
    $freeze->freeze();
}

//���ʥ�����
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        onKeyUp=\"javascript:display(this,'goods')\" 
        $g_form_option"
);

//����̾
$form->addElement(
        "text","form_goods_name","",'size="70" maxLength="30" 
        '." $g_form_option"
);

//ά��
$form->addElement(
        "text","form_goods_cname","",'size="15" maxLength="7" 
        '." $g_form_option"
);

//URL
$form->addElement(
        "text","form_url","�ƥ����ȥե�����","size=\"48\" maxLength=\"100\" style=\"$g_form_style\"
        $g_form_option"
);      

//°����ʬ
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "����","3");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "ƻ��¾","4");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "�ݸ�","5");
$form->addGroup( $attri_div, "form_attri_div", "°����ʬ");

//�ޡ���
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "�ǣ�","2");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "�ţ�","3");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "��Ŭ","4");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "��ʪ","5");
$form->addGroup( $mark_div, "form_mark_div", "�ޡ���");

//�Ͷ�ʬ
$select_ary = Select_Get($conn, "g_goods");
$form->addElement("select", "form_g_goods", "", $select_ary, $g_form_option_select);

//������ʬ
$select_ary = Select_Get($conn,"product");
$form->addElement("select", "form_product", "", $select_ary, $g_form_option_select);

//����ʬ��
$g_product_ary = Select_Get($conn, 'g_product');
$form->addElement('select', 'form_g_product',"", $g_product_ary);

//ñ��
$form->addElement(
        "text","form_unit","",'size="11" maxLength="5" 
        '." $g_form_option"
);

//����
$form->addElement(
        "text","form_in_num","","size=\"11\" maxLength=\"5\" style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
);

//�����裱
$jouken  = "WHERE";
$jouken .= " client_div = '3' ";
$jouken .= " AND";
$jouken .= " shop_id = $shop_id";

$code_value = Code_Value("t_client",$conn,$jouken,"9");
$supplier[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier[cd1]', 'form_supplier[cd2]' ,'form_supplier[name]')\" 
        $g_form_option"
);
$supplier[] =& $form->createElement("static","","","-");
$supplier[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier[cd1]', 'form_supplier[cd2]' ,'form_supplier[name]')\" 
        $g_form_option"
);
$supplier[] =& $form->createElement(
        "text","name","","size=\"48\" 
        $g_text_readonly"
);
$form->addGroup( $supplier, "form_supplier", "");

//�����裲
$supplier2[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier2[cd1]', 'form_supplier2[cd2]' ,'form_supplier2[name]')\" 
        $g_form_option"
);
$supplier2[] =& $form->createElement("static","","","-");
$supplier2[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier2[cd1]', 'form_supplier2[cd2]' ,'form_supplier2[name]')\" 
        $g_form_option"
);
$supplier2[] =& $form->createElement(
        "text","name","","size=\"48\" 
        $g_text_readonly"
);
$form->addGroup( $supplier2, "form_supplier2", "");

//�����裳
$supplier3[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier3[cd1]', 'form_supplier3[cd2]' ,'form_supplier3[name]')\" 
        $g_form_option"
);
$supplier3[] =& $form->createElement("static","","","-");
$supplier3[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier3[cd1]', 'form_supplier3[cd2]' ,'form_supplier3[name]')\" 
        $g_form_option"
);
$supplier3[] =& $form->createElement(
        "text","name","","size=\"48\" 
        $g_text_readonly"
);
$form->addGroup( $supplier3, "form_supplier3", "");

//��������������ѥ��ߡ�hidden
$form->addElement("hidden", "hdn_dummy");


//�������
$sale_manage[] =& $form->createElement( "radio",NULL,NULL, "ͭ","1");
$sale_manage[] =& $form->createElement( "radio",NULL,NULL, "̵","2");
$form->addGroup( $sale_manage, "form_sale_manage", ""); 

//�߸˴���
$stock_manage[] =& $form->createElement( "radio",NULL,NULL, "ͭ","1");
$stock_manage[] =& $form->createElement( "radio",NULL,NULL, "̵","2");
$form->addGroup( $stock_manage, "form_stock_manage", ""); 

//�߸˸¤���
$form->addElement('checkbox', 'form_stock_only', '', '');

//ȯ����
$form->addElement(
        "text","form_order_point","","size=\"11\" maxLength=\"9\" 
        style=\"text-align: right; $g_form_style\"
        $g_form_option"
);

//ȯ��ñ�̿�
$form->addElement(
        "text","form_order_unit","","size=\"11\" maxLength=\"4\" style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
);

//�꡼�ɥ�����
$form->addElement(
        "text","form_lead","","size=\"11\" maxLength=\"2\" style=\"$g_form_style\"
        "." $g_form_option"
);

//��̾�ѹ�
$name_change[] =& $form->createElement( "radio",NULL,NULL, "�ѹ���","1");
$name_change[] =& $form->createElement( "radio",NULL,NULL, "�ѹ��Բ�","2");
$form->addGroup( $name_change, "form_name_change", "");

//���Ƕ�ʬ
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "�����","3");
$form->addGroup( $tax_div, "form_tax_div", "");

//�����ƥ�
$royalty[] =& $form->createElement( "radio",NULL,NULL, "ͭ","1");
$royalty[] =& $form->createElement( "radio",NULL,NULL, "̵","2");
$form->addGroup( $royalty, "form_royalty", ""); 

//����
$form->addElement(
        "text","form_note","",'size="70" maxLength="30" 
        '." $g_form_option"
);

//�ܥ���
$form->addElement(
    "button","new_button","��Ͽ����",
    $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\""
);
$form->addElement(
    "button","change_button","�ѹ�������",
    "onClick=\"javascript:Referer('1-1-220.php')\""
);

/****************************/
//�롼�����(QuickForm)
/****************************/
//�����ʥ�����
//��ɬ�ܥ����å�
$form->addRule( 
        "form_goods_cd", "���ʥ����ɤ�8ʸ����Ⱦ�ѿ����Ǥ���",
        "required"
);

//�����������å�
$form->addRule(
        "form_goods_cd", "���ʥ����ɤ�8ʸ����Ⱦ�ѿ����Ǥ���",
        "regex", "/^[0-9]+$/"
);

//������̾
//��ɬ�ܥ����å�
$form->addRule(
        "form_goods_name", "����̾��1ʸ���ʾ�30ʸ���ʲ��Ǥ���",
        "required"
);
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_goods_name", "����̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

$form->addRule(
        "form_goods_cname", "ά����1ʸ���ʾ�7ʸ���ʲ��Ǥ���",
        "required"
);
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_goods_cname", "ά�� �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");


//���Ͷ�ʬ
//��ɬ�ܥ����å�
$form->addRule('form_g_goods', "�Ͷ�ʬ��ɬ�ܹ��ܤǤ���","required"
);
//��������ʬ
//��ɬ�ܥ����å�
$form->addRule('form_product', "������ʬ��ɬ�ܹ��ܤǤ���","required"
);
//������ʬ��
//��ɬ�ܥ����å�
$form->addRule('form_g_product', "����ʬ���ɬ�ܹ��ܤǤ���","required"
);
//������
//�����������å�
$form->addRule(
        "form_in_num", "������Ⱦ�ѿ����ΤߤǤ���",
        "regex", "/^[0-9]+$/"
);

//��ȯ����
//�����������å�
$form->addRule(
        "form_order_point", "ȯ������Ⱦ�ѿ����ΤߤǤ���",
        "regex", "/^[0-9]+$/"
);

//��ȯ��ñ�̿�
//�����������å�
$form->addRule(
        "form_order_unit", "ȯ��ñ�̿���Ⱦ�ѿ����ΤߤǤ���",
        "regex", "/^[0-9]+$/"
);

//���꡼�ɥ�����
//�����������å�
$form->addRule(
        "form_lead", "�꡼�ɥ������Ⱦ�ѿ����ΤߤǤ���",
        "regex", "/^[0-9]+$/"
);
if($_POST["form_entry_button"] == "�С�Ͽ"){
    /****************************/
    //POST����
    /****************************/
    $state          = $_POST["form_state"];                 //����
    $goods_cd       = $_POST["form_goods_cd"];              //���ʥ�����
    $goods_name     = $_POST["form_goods_name"];            //����̾
    $goods_cname    = $_POST["form_goods_cname"];           //ά��
    $attri_div      = $_POST["form_attri_div"];             //°����ʬ
    $g_goods_id     = $_POST["form_g_goods"];               //�Ͷ�ʬ
    $product_id     = $_POST["form_product"];               //������ʬ
	$g_product_id   = $_POST["form_g_product"];             //����ʬ��
    $unit           = $_POST["form_unit"];                  //ñ��
    $in_num         = $_POST["form_in_num"];                //����
    $supplier_cd1   = $_POST["form_supplier"]["cd1"];       //������1������1
    $supplier_cd2   = $_POST["form_supplier"]["cd2"];       //������1������2
    $supplier_name  = $_POST["form_supplier"]["name"];      //������1̾
    $supplier2_cd1  = $_POST["form_supplier2"]["cd1"];      //������2������1
    $supplier2_cd2  = $_POST["form_supplier2"]["cd2"];      //������2������2
    $supplier2_name = $_POST["form_supplier2"]["name"];     //������2̾
    $supplier3_cd1  = $_POST["form_supplier3"]["cd1"];      //������3������1
    $supplier3_cd2  = $_POST["form_supplier3"]["cd2"];      //������3������2
    $supplier_name3 = $_POST["form_supplier3"]["name"];     //������3̾
    $sale_manage    = $_POST["form_sale_manage"];           //�������
    $stock_manage   = $_POST["form_stock_manage"];          //�߸˴���
    $stock_only     = $_POST["form_stock_only"];            //�߸˸¤���
    $order_point    = $_POST["form_order_point"];           //ȯ����
    $order_unit     = $_POST["form_order_unit"];            //ȯ��ñ�̿�
    $lead           = $_POST["form_lead"];                  //�꡼�ɥ����������
    $name_change    = $_POST["form_name_change"];           //��̾�ѹ�
    $tax_div        = $_POST["form_tax_div"];               //���Ƕ�ʬ
    $royalty        = $_POST["form_royalty"];               //�����ƥ���̵ͭ��
    $note           = $_POST["form_note"];                  //����
    $url            = $_POST["form_url"];                   //URL
    $mark_div       = $_POST["form_mark_div"];              //�ޡ���
    $accept_flg     = $_POST["form_accept"];
    $rental_flg     = $_POST["form_rental"];                //RtoR
	$serial_flg     = $_POST["form_serial"];                //���ꥢ�����

    //���������ηϥ����å�
    if($goods_cd != null && (strlen($goods_cd) >= 8) && substr($goods_cd, 0, 1) != 0){
        $form->setElementError("form_goods_cd","���ʥ����ɤξ壱��ϡ֣��פǤ���");
    }

    //URL�����å�
    if((!ereg("^.+\.html$|htm$|jpg$|jpeg$", $url) || strstr($url,'/')) && $url != null){
        $form->setElementError("form_url","�ե�����̾�γ�ĥ�Ҥ�html,htm,jpg,jpeg �Ȥ��Ƥ���������");
    }

    //��������1
    //��ɬ�ܥ����å�
    if(($_POST["form_supplier"]["cd1"] != NULL || $_POST["form_supplier"]["cd2"] != NULL) && $_POST["form_supplier"]["name"] == NULL){
        $form->setElementError("form_supplier","�����������襳���ɤ����Ϥ��Ʋ�������");
    }
    
    //��������2
    //��ɬ�ܥ����å�
    if(($_POST["form_supplier2"]["cd1"] != NULL || $_POST["form_supplier2"]["cd2"] != NULL) && $_POST["form_supplier2"]["name"] == NULL){
        $form->setElementError("form_supplier2","������������2�����ɤ����Ϥ��Ʋ�������");
    }

    //��������3
    //��ɬ�ܥ����å�
    if(($_POST["form_supplier3"]["cd1"] != NULL || $_POST["form_supplier3"]["cd2"] != NULL) && $_POST["form_supplier3"]["name"] == NULL){
        $form->setElementError("form_supplier3","������������3�����ɤ����Ϥ��Ʋ�������");
    }

    /***************************/
    //���ʥ���������
    /***************************/
    $goods_cd = str_pad($goods_cd, 8, 0, STR_PAD_LEFT);

    /****************************/
    //���ʥ����ɶ��������å�
    /****************************/
    $goods_cd_sql  = " SELECT";
    $goods_cd_sql .= "     goods_cd";
    $goods_cd_sql .= " FROM";
    $goods_cd_sql .= "     t_goods";
    $goods_cd_sql .= " WHERE";
    $goods_cd_sql .= "     shop_id = $shop_id";
    $goods_cd_sql .= "     AND";
    $goods_cd_sql .= "     goods_cd = '$goods_cd'";
    $goods_cd_sql .= " ;";

    $result = Db_Query($conn, $goods_cd_sql);
    $goods_cd_res = @pg_fetch_result($result, 0,0);

    if($goods_cd_res != null && $get_flg != true){
        $form->setElementError("form_goods_cd","���˻��Ѥ���Ƥ��� ���ʥ����� �Ǥ���");
    }elseif($goods_cd_res != null && $get_flg == true && $get_data[0] != $goods_cd_res){
        $form->setElementError("form_goods_name","���˻��Ѥ���Ƥ��� ���ʥ����� �Ǥ���");
    }

    /****************************/
    //���Ǹ���
    /****************************/
    if($form->validate()){
 
        /***************************/
        //ɬ�ܥǡ�������
        /***************************/
        $make_goods_flg = 0;                                    //��¤�ʥե饰
        $public_flg = 1;                                        //��ͭ�ե饰
        $compose_flg = 0;                                       //�����ʥե饰

        /****************************/
        //null���֤�����
        /****************************/
        if($order_point == null){
            $order_point = "null";
        }

        /****************************/
        //������Ͽ
        /****************************/
        //��Ͽ������Ƚ��
        if($get_flg == true){
            //���ʥޥ���
            Db_Query($conn,"BEGIN;");

            $goods_sql  = " UPDATE";
            $goods_sql .= "     t_goods";
            $goods_sql .= " SET";
            $goods_sql .= "     state = '$state',";
            $goods_sql .= "     goods_cd = '$goods_cd',";
            $goods_sql .= "     goods_name = '$goods_name',";
            $goods_sql .= "     goods_cname = '$goods_cname',";
            $goods_sql .= "     attri_div = '$attri_div',";
            $goods_sql .= "     product_id = $product_id,";
			$goods_sql .= "     g_product_id = $g_product_id,";
            $goods_sql .= "     g_goods_id = $g_goods_id,";
            $goods_sql .= "     unit = '$unit',";
            $goods_sql .= "     tax_div = '$tax_div',";
            $goods_sql .= "     name_change = '$name_change',";
            $goods_sql .= "     sale_manage = '$sale_manage',";
            #2009-10-06 hashimoto-y
            #$goods_sql .= "     stock_manage = '$stock_manage',";
            $goods_sql .= "     stock_only = '$stock_only',";
            $goods_sql .= "     royalty = '$royalty',";
            $goods_sql .= "     url = '$url',";
            $goods_sql .= "     mark_div = '$mark_div',";
            $goods_sql .= "     in_num = '$in_num', ";
            $goods_sql .= "     accept_flg = '$accept_flg',";
            $goods_sql .= "     rental_flg = '$rental_flg',";
			$goods_sql .= "     serial_flg = '$serial_flg'";
            $goods_sql .= " WHERE";
            $goods_sql .= "     goods_id = $get_goods_id";
            $goods_sql .= ";";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //����å��̾��ʾ���ơ��֥�
            $goods_sql  = " UPDATE";
            $goods_sql .= "     t_goods_info";
            $goods_sql .= " SET";
            $goods_sql .= "     goods_id = $get_goods_id,";
            $goods_sql .= "     order_point = $order_point,";
            $goods_sql .= "     order_unit = '$order_unit',";
            $goods_sql .= "     lead = '$lead',";
            $goods_sql .= "     note = '$note',";
            #2009-10-06 hashimoto-y
            $goods_sql .= "     stock_manage = '$stock_manage',";

            //�����褬���ꤵ��Ƥ������
            if($supplier_cd1 != null && $supplier_cd2 != null){
                $goods_sql .= "     supplier_id = (";
                $goods_sql .= "                 SELECT";
                $goods_sql .= "                     client_id";
                $goods_sql .= "                 FROM";
                $goods_sql .= "                     t_client";
                $goods_sql .= "                 WHERE";
                $goods_sql .= "                     shop_id = $shop_id";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd1 = '$supplier_cd1'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd2 = '$supplier_cd2'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_div = '3'";
                $goods_sql .= "                 ),";
            }else{
                $goods_sql .= "     supplier_id = null,";
            }
            //������2�����ꤵ��Ƥ������
            if($supplier2_cd1 != null && $supplier2_cd2 != null){        
                $goods_sql .= "     supplier_id2 = (";
                $goods_sql .= "                 SELECT";
                $goods_sql .= "                     client_id";
                $goods_sql .= "                 FROM";
                $goods_sql .= "                     t_client";
                $goods_sql .= "                 WHERE";
                $goods_sql .= "                     shop_id = $shop_id";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd1 = '$supplier2_cd1'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd2 = '$supplier2_cd2'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_div = '3'";
                $goods_sql .= "                 ),";
            }else{
                $goods_sql .= "     supplier_id2 = null,";
            }
            //�����褬���ꤵ��Ƥ������
            if($supplier3_cd1 != null && $supplier3_cd2 != null){
                $goods_sql .= "     supplier_id3 = (";
                $goods_sql .= "                 SELECT";
                $goods_sql .= "                     client_id";
                $goods_sql .= "                 FROM";
                $goods_sql .= "                     t_client";
                $goods_sql .= "                 WHERE";
                $goods_sql .= "                     shop_id = $shop_id";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd1 = '$supplier3_cd1'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd2 = '$supplier3_cd2'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_div = '3'";
                $goods_sql .= "                 )";
            }else{
                $goods_sql .= "     supplier_id3 = null";
            }
            $goods_sql .= " WHERE";
            $goods_sql .= "     goods_id = $get_goods_id";
            $goods_sql .= "     AND";
            $goods_sql .= "     shop_id = $shop_id";
            $goods_sql .= ";";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
            }

            $work_div = '2';

            //���ʥޥ������ѹ������ޥ�����ͽ��ǡ�����ȿ��
            $result = Mst_Sync_Goods($conn,$get_goods_id,"name");
            if($result === false){
                exit;
            }

        //������Ͽ
        }else{
            //���ʥޥ���
            Db_Query($conn, "BEGIN;");            

            $goods_sql  = " INSERT INTO t_goods (";
            $goods_sql .= "     goods_id,";
            $goods_sql .= "     goods_cd,";
            $goods_sql .= "     goods_name,";
            $goods_sql .= "     goods_cname,";
            $goods_sql .= "     attri_div,";
            $goods_sql .= "     product_id,";
			$goods_sql .= "     g_product_id,";
            $goods_sql .= "     g_goods_id,";
            $goods_sql .= "     unit,";
            $goods_sql .= "     tax_div,";
            $goods_sql .= "     name_change,";
            $goods_sql .= "     sale_manage,";
            #2009-10-06 hashimoto-y
            #$goods_sql .= "     stock_manage,";
            $goods_sql .= "     stock_only,";
            $goods_sql .= "     royalty,";
            $goods_sql .= "     make_goods_flg,";
            $goods_sql .= "     public_flg,";
            $goods_sql .= "     shop_id,";
            $goods_sql .= "     state,";
            $goods_sql .= "     url,";
            $goods_sql .= "     mark_div, ";
            $goods_sql .= "     in_num, ";
            $goods_sql .= "     accept_flg,";
            $goods_sql .= "     rental_flg,";
			$goods_sql .= "     serial_flg";
            $goods_sql .= " )VALUES (";
            $goods_sql .= "     (SELECT COALESCE(MAX(goods_id), 0)+1 FROM t_goods),";
            $goods_sql .= "     '$goods_cd',";
            $goods_sql .= "     '$goods_name',";
            $goods_sql .= "     '$goods_cname',";
            $goods_sql .= "     '$attri_div',";
            $goods_sql .= "     '$product_id',";
			$goods_sql .= "     '$g_product_id',";
            $goods_sql .= "     '$g_goods_id',";
            $goods_sql .= "     '$unit',";
            $goods_sql .= "     '$tax_div',";
            $goods_sql .= "     '$name_change',";
            $goods_sql .= "     '$sale_manage',";
            #2009-10-06 hashimoto-y
            #$goods_sql .= "     '$stock_manage',";
            $goods_sql .= "     '$stock_only',";
            $goods_sql .= "     '$royalty',";
            $goods_sql .= "     '$make_goods_flg',";
            $goods_sql .= "     '$public_flg',";
            $goods_sql .= "     $shop_id,";
            $goods_sql .= "     '$state',";
            $goods_sql .= "     '$url',";
            $goods_sql .= "     '$mark_div',";
            $goods_sql .= "     '$in_num',";
            $goods_sql .= "     '$accept_flg',";
            $goods_sql .= "     '$rental_flg',";
			$goods_sql .= "     '$serial_flg'";
            $goods_sql .= ");";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //����å��̾��ʾ���ơ��֥�
            $goods_sql  = " INSERT INTO t_goods_info (";
            $goods_sql .= "     goods_id,";
            $goods_sql .= "     order_point,";
            $goods_sql .= "     order_unit,";
            $goods_sql .= "     lead,";
            $goods_sql .= "     note,";
            #2009-10-06 hashimoto-y
            $goods_sql .= "     stock_manage,";
            $goods_sql .= "     supplier_id,";
            $goods_sql .= "     compose_flg,";
            $goods_sql .= "     shop_id,";
            $goods_sql .= "     head_fc_flg,";
            $goods_sql .= "     supplier_id2,";
            $goods_sql .= "     supplier_id3";
            $goods_sql .= ") VALUES (";
            $goods_sql .= "     (SELECT";
            $goods_sql .= "         goods_id";
            $goods_sql .= "     FROM";
            $goods_sql .= "         t_goods";
            $goods_sql .= "     WHERE";
            $goods_sql .= "         shop_id = $shop_id";
            $goods_sql .= "     AND";
            $goods_sql .= "         goods_cd = '$goods_cd'";
            $goods_sql .= "     ),";
            $goods_sql .= "     $order_point,";
            $goods_sql .= "     '$order_unit',";
            $goods_sql .= "     '$lead',";
            $goods_sql .= "     '$note',";
            #2009-10-06 hashimoto-y
            $goods_sql .= "     '$stock_manage',";

            //�����褬���ꤵ��Ƥ������
            if($supplier_cd1 != null && $supplier_cd2 != null){
                $goods_sql .= "     (";
                $goods_sql .= "      SELECT";
                $goods_sql .= "        client_id";
                $goods_sql .= "      FROM";
                $goods_sql .= "        t_client";
                $goods_sql .= "      WHERE";
                $goods_sql .= "        shop_id = $shop_id";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd1 = '$supplier_cd1'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd2 = '$supplier_cd2'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_div = '3'";
                $goods_sql .= "    ),";
            }else{
                $goods_sql .= "null,";
            }
            $goods_sql .= "    '$compose_flg',";
            $goods_sql .= "    $shop_id,";
            $goods_sql .= "    't',";
            //�����褬���ꤵ��Ƥ������
            if($supplier2_cd1 != null && $supplier2_cd2 != null){
                $goods_sql .= "     (";
                $goods_sql .= "      SELECT";
                $goods_sql .= "        client_id";
                $goods_sql .= "      FROM";
                $goods_sql .= "        t_client";
                $goods_sql .= "      WHERE";
                $goods_sql .= "        shop_id = $shop_id";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd1 = '$supplier2_cd1'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd2 = '$supplier2_cd2'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_div = '3'";
                $goods_sql .= "    ),";
            }else{
                $goods_sql .= "null,";
            }
            //�����褬���ꤵ��Ƥ������
            if($supplier3_cd1 != null && $supplier3_cd2 != null){
                $goods_sql .= "     (";
                $goods_sql .= "      SELECT";
                $goods_sql .= "        client_id";
                $goods_sql .= "      FROM";
                $goods_sql .= "        t_client";
                $goods_sql .= "      WHERE";
                $goods_sql .= "        shop_id = $shop_id";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd1 = '$supplier3_cd1'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd2 = '$supplier3_cd2'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_div = '3'";
                $goods_sql .= "    )";
            }else{
                $goods_sql .= "null";
            }
            $goods_sql .= ");"; 

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

        $work_div = '1';

        }





        $result = Log_Save( $conn, "goods", $work_div, $goods_cd, $goods_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //������¹�
        Db_Query($conn, "COMMIT");
        $freeze_flg = true;
    }
}

if($freeze_flg == true){
    /****************************/
    //GET�ǡ�������
    /****************************/
    $goods_id_sql  = "SELECT";
    $goods_id_sql .= "   goods_id";
    $goods_id_sql .= " FROM";
    $goods_id_sql .= "   t_goods";
    $goods_id_sql .= " WHERE";
    $goods_id_sql .= "  goods_cd = '$goods_cd'";
    $goods_id_sql .= "  AND";
    $goods_id_sql .= "  shop_id = $shop_id";
    $goods_id_sql .= ";";

    $result = Db_Query($conn, $goods_id_sql);

    $get_goods_id = pg_fetch_result($result, 0);

    //������Ƚ��
/*
    if($get_flg == true){
        $target = "./1-1-221.php";
    }else{
*/
        $target = "./1-1-222.php?goods_id=".$get_goods_id;
//    }
    
    if($no_change_flg == 't'){
        $form->addElement("button","form_back_button","�ᡡ��","onClick=\"location.href='./1-1-220.php'\"");
    }else{
        $form->addElement("button","form_entry_button","�ϡ���","onClick=\"javascript:Referer('$target')\"");
        $form->addElement("button","form_back_button","�ᡡ��","onClick=\"location.href='./1-1-221.php?goods_id=$get_goods_id'\"");
    }

    $form->addElement("static","form_client_link","","������1");
    $form->addElement("static","form_client_link2","","������2");
    $form->addElement("static","form_client_link3","","������3");

    $form->freeze();
}else{
    $form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");
    $form->addElement(
        "button","form_show_dialog_button","��Ͽ�Ѱ�����ǧ",
        "onClick='javascript:showModelessDialog(\"../dialog/1-0-210-1.php\",window,\"status:false;dialogWidth:540px;dialogHeight:500px;edge:sunken;\")'
    ");
    //���إܥ���
    if($next_id != null){
        $form->addElement("button","next_button","������","onClick=\"location.href='./1-1-221.php?goods_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","������","disabled");
    }
    //���إܥ���
    if($back_id != null){
        $form->addElement("button","back_button","������","onClick=\"location.href='./1-1-221.php?goods_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","������","disabled");
    }
    //������
    $form->addElement(
        "link","form_client_link","","#","������1",
        //"onClick=\"return Open_SubWin('../dialog/1-0-208.php', Array('form_supplier[cd]', 'form_supplier[name]'), 500, 450);\""
        "onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_supplier[cd1]','form_supplier[cd2]','form_supplier[name]','hdn_dummy'),500,450);\""
    );
    //������2
    $form->addElement(
        "link","form_client_link2","","#","������2",
        //"onClick=\"return Open_SubWin('../dialog/1-0-208.php', Array('form_supplier2[cd]', 'form_supplier2[name]'), 500, 450);\""
        "onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_supplier2[cd1]','form_supplier2[cd2]','form_supplier2[name]','hdn_dummy'),500,450);\""
    );
    //������3
    $form->addElement(
        "link","form_client_link3","","#","������3",
        //"onClick=\"return Open_SubWin('../dialog/1-0-208.php', Array('form_supplier3[cd]', 'form_supplier3[name]'), 500, 450);\""
        "onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_supplier3[cd1]','form_supplier3[cd2]','form_supplier3[name]','hdn_dummy'),500,450);\""
    );
}

$form->addElement(
        "button","form_set_price_button","ñ������",
        "onClick='javascript:location.href = \"./1-1-222.php?goods_id=$get_goods_id\"'
");

if($get_flg == true && $album_url != null){
    $form->addElement(
        "link","form_album_link","","#",
        "���ʥ���Х�",
        "onClick=\"window.open('".ALBUM_DIR.$album_url."');\""
    );
}else{
    $form->addElement(
        "static","form_album_link","","���ʥ���Х�"
    );
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
//$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå�������
/****************************/
$goods_sql  = " SELECT";
$goods_sql .= "     COUNT(goods_id)";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods";
$goods_sql .= " WHERE";
$goods_sql .= "     public_flg = 't'";
$goods_sql .= "     AND";
$goods_sql .= "     compose_flg = 'f'";
$goods_sql .= "     AND";
$goods_sql .= "     shop_id = $shop_id";
$goods_sql .= " ;";

$result = Db_Query($conn,$goods_sql);
//���������(�إå���)
$t_count = pg_fetch_result($result,0,0);

$goods_sql  = " SELECT";
$goods_sql .= "     COUNT(goods_id)";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods";
$goods_sql .= " WHERE";
$goods_sql .= "     public_flg = 't'";
$goods_sql .= "     AND";
$goods_sql .= "     shop_id = $shop_id";
$goods_sql .= "     AND";
$goods_sql .= "     compose_flg = 'f'";
$goods_sql .= "     AND";
$goods_sql .= "     state IN (1,3)";
$goods_sql .= " ;";

$result = Db_Query($conn,$goods_sql);
//���������(�إå���)
$dealing_count = pg_fetch_result($result,0,0);

$page_title .= "(ͭ��".$dealing_count."��/��".$t_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
if($get_goods_id != null){
    $page_title .= "��".$form->_elements[$form->_elementIndex[form_set_price_button]]->toHtml();
}

$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'           => "$html_header",
	//'page_menu'             => "$page_menu",
	'page_header'           => "$page_header",
	'html_footer'           => "$html_footer",
    'code_value'            => "$code_value",
    'next_id'               => "$next_id",
    'back_id'               => "$back_id",
    'url'                   => ALBAM_DIR,
    'auth_r_msg'            => "$auth_r_msg",
    'sale_day'              => "$max_sale_day",
    'buy_day'               => "$max_buy_day"
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


//print_array($_POST);


?>
