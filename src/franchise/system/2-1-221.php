<?php
/**************************
�ѹ�����
    ��URL����Ͽ����褦���ѹ�(200/05/23)
    ��ά����7ʸ�����ѹ�(2006/08/01)
    ���ѹ����������򿷵����ʥޥ�����Ͽ���̤��ѹ���2006/08/21��
	(2006/11/30)���ꥢ�����ɽ�����ɲ�
***************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0090    suzuki      �ѹ����˥��˾���̾����Ͽ����褦�˽���
 *  2006-12-08      ban_0098    kaji        �����������̵�����ʤ��ޤޤ�Ƥ����Τ�ޤޤʤ��褦���ѹ�
 *  2007-06-26                  watanabe-k  ���ʥޥ������ѹ������ޥ�����ȿ�Ǥ���褦�˽���
 *  2009-09-21                  watanabe-k  ������maxlength��5���ѹ�
 *  2009-10-08                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *  2015/05/01                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 *
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
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
session_start();
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

$get_goods_id = $_GET["goods_id"];      //GET��������ID

/****************************/
//���������
/****************************/
$defa_data["form_state"] = 1;
$defa_data["form_rental"] = "f";
$defa_data["form_serial"] = "f";
$form->setDefaults($defa_data);


//GET��������
if($_GET["goods_id"] != null){
    Get_Id_Check3($_GET["goods_id"]);

    $get_flg = true;                                            //GET�ե饰

    $sql  = " SELECT";
    $sql .= "   t_goods.goods_cd,";                             //���ʥ�����
    $sql .= "   t_goods.goods_name,";                           //����̾
    $sql .= "   t_goods.goods_cname,";                          //ά��
    $sql .= "   t_goods.attri_div,";                            //°����ʬ
    $sql .= "   CASE t_goods.attri_div";                        //°����ʬ̾
    $sql .= "       WHEN '1' THEN '����'";
    $sql .= "       WHEN '2' THEN '����'";
    $sql .= "       WHEN '3' THEN '����'";
    $sql .= "       WHEN '4' THEN 'ƻ��¾'";
    $sql .= "   END,";
    $sql .= "   t_g_goods.g_goods_id,";                         //�Ͷ�ʬID
    $sql .= "   t_g_goods.g_goods_name,";                       //�Ͷ�ʬ̾
    $sql .= "   t_product.product_id,";                         //������ʬID
    $sql .= "   t_product.product_name,";                       //������ʬ̾
    $sql .= "   t_goods.unit,";                                 //ñ��
    $sql .= "   t_goods.in_num,";                               //����
    $sql .= "   t_client.client_cd1,";                          //�����襳����
    $sql .= "   t_client.client_name,";                         //������̾
    $sql .= "   t_goods.sale_manage,";                          //�������
    $sql .= "   CASE t_goods.sale_manage";                      //�������̾
    $sql .= "       WHEN '1' THEN 'ͭ'";
    $sql .= "       WHEN '2' THEN '̵'";
    $sql .= "   END,";
    #2009-10-08 hashimoto-y
    #$sql .= "   t_goods.stock_manage,";                         //�߸˴���
    #$sql .= "   CASE t_goods.stock_manage";                     //�߸˴���̾
    $sql .= "   t_goods_info.stock_manage,";                         //�߸˴���
    $sql .= "   CASE t_goods_info.stock_manage";                     //�߸˴���̾
    $sql .= "       WHEN '1' THEN 'ͭ'";
    $sql .= "       WHEN '2' THEN '̵'";
    $sql .= "   END,";
    $sql .= "   t_goods.stock_only,";                           //�߸˸¤���
    $sql .= "   CASE t_goods.stock_only";                       //�߸˸¤���̾
    $sql .= "       WHEN '1' THEN '�߸˸¤���'";
    $sql .= "       WHEN '0' THEN ''";
    $sql .= "   END,";
    $sql .= "   t_goods_info.order_point,";                     //ȯ����
    $sql .= "   t_goods_info.order_unit, ";                     //ȯ��ñ�̿�
    $sql .= "   t_goods_info.lead,";                            //�꡼�ɥ����������
    $sql .= "   t_goods.name_change,";                          //��̾�ѹ�
    $sql .= "   CASE t_goods.name_change";                      //��̾�ѹ�̾
    $sql .= "       WHEN '1' THEN '�ѹ���'";
    $sql .= "       WHEN '2' THEN '�ѹ��Բ�'";
    $sql .= "   END,";
    $sql .= "   t_goods.tax_div,";                              //���Ƕ�ʬ
    $sql .= "   CASE t_goods.tax_div";                          //���Ƕ�ʬ̾
//    $sql .= "       WHEN '1' THEN '����'";
    $sql .= "       WHEN '1' THEN '����'";
    $sql .= "       WHEN '2' THEN '����'";
    $sql .= "       WHEN '3' THEN '�����'";
    $sql .= "   END,";
    $sql .= "   t_goods_info.note, ";                           //����
    $sql .= "   t_goods.public_flg, ";                           //��ͭ�ե饰
    $sql .= "   t_goods.state, ";                                //����
    $sql .= "   t_goods.url,";
    $sql .= "   t_goods.mark_div,";                            //�ޡ���
    $sql .= "   CASE t_goods.mark_div";                        //�ޡ���
    $sql .= "       WHEN '1' THEN '����'";
    $sql .= "       WHEN '2' THEN '�ǣ�'";
    $sql .= "       WHEN '3' THEN '�ţ�'";
    $sql .= "       WHEN '4' THEN '��Ŭ'";
    $sql .= "       WHEN '5' THEN '��ʪ'";
    $sql .= "   END,";
	$sql .= "   t_g_product.g_product_id,";                     //����ʬ��ID
	$sql .= "   t_g_product.g_product_name, ";                  //����ʬ��̾
    $sql .= "   t_goods.rental_flg,";                           //��󥿥�
	$sql .= "   t_goods.serial_flg";                            //���ꥢ�����
    $sql .= " FROM";
    $sql .= "   t_goods,";                                      //���ʥޥ���
    $sql .= "   t_g_goods,";                                    //�Ͷ�ʬ�ޥ���
    $sql .= "   t_product,";                                    //������ʬ�ޥ���
	$sql .= "   t_g_product,";                                  //����ʬ��ޥ���
    $sql .= "   t_goods_info";                                  //����å��̾��ʾ���ơ��֥�
    $sql .= " LEFT JOIN";
    $sql .= "   t_client";                                      //������ޥ���
    $sql .= " ON t_goods_info.supplier_id = t_client.client_id";
    $sql .= " WHERE";
    $sql .= "   t_goods.goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods.g_goods_id = t_g_goods.g_goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods.product_id = t_product.product_id";
	$sql .= "   AND";
    $sql .= "   t_goods.g_product_id = t_g_product.g_product_id";
    $sql .= "   AND";
    $sql .= "   t_goods.goods_id = t_goods_info.goods_id";
    $sql .= "   AND";
    $sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
    $sql .= "   AND";
    //$sql .= ($group_kind == "2") ? " t_goods.state IN (1,3) " : " t_goods.state = 1";
    if($group_kind == "2"){
        $sql .= "     (t_goods.state IN ('1', '3') OR (t_goods.state = '2' AND t_goods.shop_id IN (".Rank_Sql()."))) \n";
    }else{
        $sql .= "     (t_goods.state = '1' OR (t_goods.state = '2' AND t_goods.shop_id = $shop_id)) \n";
    }
    $sql .= " ;";

    //������ȯ��
    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);

    //�ǡ�������
    $get_goods_data = @pg_fetch_array ($result, 0, PGSQL_NUM);

    //��������Ƚ��
    if($get_goods_data[27] == 't')
    {
		//������
		$where_sql  = " WHERE";
		$where_sql .= "  client_div = '2'";
		$where_sql .= "  AND";
		$where_sql .= "  head_flg = 'f'";
		$where_sql .= "  AND";
        $where_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";

		$code_value = Code_Value("t_client",$conn,"$where_sql",2);
        $head_flg = true;                                       //��������Ƚ��ե饰
        $type = "static";
        $read = "style=\"color : #525552; border : #ffffff 1px solid;background-color: #ffffff;\" readonly";

        // ���������򤵤줿���ʤ��������ʤξ��
        $sql  = "SELECT ";
        $sql .= "   client_id, ";
        $sql .= "   client_cd1, ";
        $sql .= "   client_name ";
        $sql .= "FROM ";
        $sql .= "   t_client ";
        $sql .= "WHERE ";
        $sql .= "   head_flg = 't' ";
        $sql .= "   AND shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($conn, $sql);
        $head_item = pg_fetch_array($res, 0, PGSQL_ASSOC);

        $head_item_form["form_supplier"]["cd"]      = $head_item["client_cd1"];
        $head_item_form["form_supplier"]["name"]    = $head_item["client_name"];

    }else{
		//������
		$where_sql  = " WHERE";
		$where_sql .= "  client_div = '2'";
		$where_sql .= "  AND";
        $where_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";

		$code_value = Code_Value("t_client",$conn,"$where_sql",2);
        $type = "text";
        $read = $g_form_oprion;
    }

    //����ͥǡ���
    $def_data["form_goods_cd"]          = $get_goods_data[0];         //���ʥ�����
    $def_data["form_goods_name"]        = ($head_flg != true) ? $get_goods_data[1]
                                                              : htmlspecialchars($get_goods_data[1]);         //����̾
    $def_data["form_goods_cname"]       = ($head_flg != true) ? $get_goods_data[2]
                                                              : htmlspecialchars($get_goods_data[2]);         //ά��  
    $def_data["form_attri_div"]         = $get_goods_data[3];         //°����ʬ
    $def_data["form_attri_name"]        = $get_goods_data[4];         //°����ʬ̾
    $def_data["form_g_goods_id"]        = $get_goods_data[5];         //�Ͷ�ʬID
    $def_data["form_g_goods_name"]      = ($head_flg != true) ? $get_goods_data[6]
                                                              : htmlspecialchars($get_goods_data[6]);         //�Ͷ�ʬ̾
    $def_data["form_product_id"]        = $get_goods_data[7];         //������ʬID
    $def_data["form_product_name"]      = ($head_flg != true) ? $get_goods_data[8]
                                                              : htmlspecialchars($get_goods_data[8]);         //������ʬ̾
    $def_data["form_unit"]              = ($head_flg != true) ? $get_goods_data[9]
                                                              : htmlspecialchars($get_goods_data[9]);         //ñ��  
    $def_data["form_sale_manage"]       = $get_goods_data[13];        //�������
    $def_data["form_sale_manage_name"]  = $get_goods_data[14];        //�������̾
    $def_data["form_stock_manage"]      = $get_goods_data[15];        //�߸˴���
    $def_data["form_stock_manage_name"] = $get_goods_data[16];        //�߸˴���̾
    $def_data["form_stock_only"]        = $get_goods_data[17];        //�߸˸¤���
    $def_data["form_stock_only_name"]   = $get_goods_data[18];        //�߸˸¤���̾
    $def_data["form_name_change"]       = $get_goods_data[22];        //��̾�ѹ�
    $def_data["form_name_change_name"]  = $get_goods_data[23];        //��̾�ѹ�̾
    $def_data["form_tax_div"]           = $get_goods_data[24];        //���Ƕ�ʬ
    $def_data["form_tax_div_name"]      = $get_goods_data[25];        //���Ƕ�ʬ̾
    $def_data["form_in_num"]            = $get_goods_data[10];        //����  
    //�������ʤξ��
    if ($get_goods_data[27] == 't'){
        $def_data["form_supplier"]["cd"]    = $head_item["client_cd1"];     // �����襳����
        $def_data["form_supplier"]["name"]  = htmlspecialchars($head_item["client_name"]);    // ������̾
    }else{
        $def_data["form_supplier"]["cd"]    = $get_goods_data[11];          //�����襳����
        $def_data["form_supplier"]["name"]  = $get_goods_data[12];          //������̾
    }
    $def_data["form_order_point"]       = $get_goods_data[19];        //ȯ����
    $def_data["form_order_unit"]        = $get_goods_data[20];        //ȯ��ñ�̿�
    $def_data["form_lead"]              = $get_goods_data[21];        //�꡼�ɥ����������
    $def_data["form_note"]              = $get_goods_data[26];        //����  
    $def_data["form_state"]             = $get_goods_data[28];        //����
    $def_data["form_url"]               = ($head_flg != true) ? $get_goods_data[29]
                                                              : htmlspecialchars($get_goods_data[29]);        //url
    $def_data["form_mark_div"]          = $get_goods_data[30];        //�ޡ���
    $def_data["form_mark_name"]         = $get_goods_data[31];        //�ޡ���̾
	$def_data["form_g_product_id"]      = $get_goods_data[32];        //����ʬ��ID
	$def_data["form_g_product_name"]    = ($head_flg != true) ? $get_goods_data[33]
                                                              : htmlspecialchars($get_goods_data[33]);        //����ʬ��̾
    $def_data["form_rental"]            = $get_goods_data[34];        //��󥿥�
	$def_data["form_serial"]            = $get_goods_data[35];        //���ꥢ�����

    $album_url                          = addslashes($get_goods_data[29]);        //URL

    //���������
    $form->setDefaults($def_data);

    $id_data = Make_Get_Id($conn, "goods", $get_goods_data[0], '2');
    $next_id = $id_data[0]; 
    $back_id = $id_data[1];

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
    $def_data["form_sale_manage"]   = 1;                        //�������
    $def_data["form_stock_manage"]  = 1;                        //�߸˴���
    $def_data["form_name_change"]   = 1;                        //��̾�ѹ�
    $def_data["form_tax_div"]       = 1;                        //���Ƕ�ʬ
    $def_data["form_mark_div"]      = 1;                        //���Ƕ�ʬ
    //���������
    $form->setDefaults($def_data);

    $type = "text";
}

/****************************/
//�ե��������
/****************************/
if($head_flg != true){
    //����
	$form_state[] =& $form->createElement( "radio",NULL,NULL, "ͭ��","1");
	$form_state[] =& $form->createElement( "radio",NULL,NULL, "̵��","2");
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
}else{
    //����
	$form_state[] =& $form->createElement( "radio",NULL,NULL, "ͭ��","1");
	$form_state[] =& $form->createElement( "radio",NULL,NULL, "̵��","2");
	$form->addGroup($form_state, "form_state", "");

    //��󥿥�
	$form_rental[] =& $form->createElement( "radio",NULL,NULL, "����","t");
	$form_rental[] =& $form->createElement( "radio",NULL,NULL, "�ʤ�","f");
	$form->addGroup($form_rental, "form_rental", "");

	//���ꥢ��
	$form_serial[] =& $form->createElement("radio",NULL,NULL,"����","t");
	$form_serial[] =& $form->createElement("radio",NULL,NULL,"�ʤ�","f");
	$form->addGroup($form_serial,"form_serial", "");

    $form->freeze(form_state);
	$form->freeze(form_rental);
	$form->freeze(form_serial);
}
//���ʥ�����
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        $read"
);

//����̾
$form->addElement(
        $type,"form_goods_name","","size=\"70\" maxLength=\"30\"
         $g_form_option"
);

//ά��
$form->addElement(
        $type,"form_goods_cname","","size=\"15\" maxLength=\"7\"
        $g_form_option"
);


if($_GET["goods_id"] == null){
	//������
	$where_sql  = " WHERE";
	$where_sql .= "  client_div = '2'";
	$where_sql .= "  AND";
    $where_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";

	$code_value = Code_Value("t_client",$conn,"$where_sql",2);
}
//°����ʬ
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "����","3");
$attri_div[] =& $form->createElement("radio",NULL,NULL, "ƻ��¾","4");
$attri_div[] =& $form->createElement("radio",NULL,NULL, "�ݸ�","5");
$form->addGroup( $attri_div, "form_attri_div", "°����ʬ");
$form->addElement($type,"form_attri_name","","size\"34\" maxLength=\"10\"
        $form_option"
);

//�ޡ���
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "�ǣ�","2");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "�ţ�","3");
$mark_div[] =& $form->createElement("radio",NULL,NULL, "��Ŭ","4");
$mark_div[] =& $form->createElement("radio",NULL,NULL, "��ʪ","5");
$form->addGroup( $mark_div, "form_mark_div", "°����ʬ");
$form->addElement($type,"form_mark_name","","size\"34\" maxLength=\"10\"
        $form_option"
);

//�Ͷ�ʬ
$g_goods_ary = Select_Get($conn, 'g_goods');
$form->addElement('select', 'form_g_goods_id',"", $g_goods_ary, $g_form_option_select);
$form->addElement($type,"form_g_goods_name","","size=\"25\"
                $g_form_option"
);

//������ʬ
$product_ary = Select_Get($conn, 'product');
$form->addElement('select', 'form_product_id',"", $product_ary, $g_form_option_select);
$form->addElement($type,"form_product_name","","size=\"25\"
                $g_form_option"
);

//����ʬ��
$g_product_ary = Select_Get($conn, 'g_product');
$form->addElement('select', 'form_g_product_id',"", $g_product_ary);
$form->addElement($type,"form_g_product_name","","size=\"25\"
                $g_form_option"
);

//ñ��
$form->addElement(
        $type,"form_unit","","size=\"11\" maxLength=\"5\" 
        $g_form_option"
);

//����
$head_freeze = $form->addElement(
        "text","form_in_num","","size=\"11\" maxLength=\"5\" style=\"text-align: right;$g_form_style\"
        $g_form_option"
);
($head_flg == true) ? $head_freeze->freeze() : null;    // �������ʤϥե꡼��


$supplier[] =& $form->createElement("text","cd","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" 
        onKeyUp=\"javascript:client(this,'form_supplier[name]')\" $g_form_option");
$supplier[] =& $form->createElement("text","name","","size=\"48\" $g_text_readonly");
$head_item_form = $form->addGroup( $supplier, "form_supplier", "");

//�������
$sale_manage[] =& $form->createElement( "radio",NULL,NULL, "ͭ","1");
$sale_manage[] =& $form->createElement( "radio",NULL,NULL, "̵","2");
$form->addGroup( $sale_manage, "form_sale_manage", "");
$form->addElement($type,"form_sale_manage_name","","size=\"4\" maxLength=\"4\""
);

//�߸˴���
$stock_manage[] =& $form->createElement( "radio",NULL,NULL, "ͭ","1");
$stock_manage[] =& $form->createElement( "radio",NULL,NULL, "̵","2");
$form->addGroup( $stock_manage, "form_stock_manage", "");
$form->addElement($type,"form_stock_manage_name","",""
);


//�߸˸¤���
$form->addElement('checkbox', 'form_stock_only', '', '');
$form->addElement($type,"form_stock_only_name","",""
);

//ȯ����
$form->addElement(
        "text","form_order_point","","size=\"11\" maxLength=\"9\" 
        $g_form_option 
        style=\"text-align: right;$g_form_style\""
);

//ȯ��ñ�̿�
$form->addElement(
        "text","form_order_unit","","size=\"11\" maxLength=\"4\" 
        $g_form_option 
        style=\"text-align: right;$g_form_style\""
);

//�꡼�ɥ�����
$form->addElement(
        "text","form_lead","","size=\"11\" maxLength=\"2\" style=\"$g_form_style\" 
        $g_form_option"
);

//��̾�ѹ�
$name_change[] =& $form->createElement( "radio",NULL,NULL, "�ѹ���","1");
$name_change[] =& $form->createElement( "radio",NULL,NULL, "�ѹ��Բ�","2");
$form->addGroup( $name_change, "form_name_change", "");
$form->addElement($type,"form_name_change_name","","size=\"10\" maxLength=\"8\"
       $g_form_option"
);

//���Ƕ�ʬ
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "�����","3");
$form->addGroup( $tax_div, "form_tax_div", "");
$form->addElement($type,"form_tax_div_name","","size=\"10\" maxLength=\"8\"
       $g_form_option"
);

//����
$form->addElement(
        "text","form_note","","size=\"70\" maxLength=\"30\" 
        $g_form_option"
);

//�ܥ���
$form->addElement(
    "button","new_button","��Ͽ����",
    $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\""
);
$form->addElement(
    "button","change_button","�ѹ�������",
    "onClick=\"javascript:Referer('2-1-220.php')\""
);
//$form->addElement(
//    "button","form_set_price_button","ñ������",
//    "onClick='javascript:location.href = \"2-1-222.php?goods_id=$get_goods_id\"'
//");

/****************************/
//�롼�����(QuickForm)
/****************************/
if($head_flg != true){
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

    //��������å�
    $form->addRule(
        'form_goods_cd', '���ʥ����ɤ�8ʸ����Ⱦ�ѿ����Ǥ���', 
        'rangelength', array(8, 8)
    );

    //������̾
    //��ɬ�ܥ����å�
    $form->addRule(
        "form_goods_name", "����̾�ϣ�ʸ���ʾ�30ʸ���ʲ��Ǥ���",
        'required');
    // ����/Ⱦ�ѥ��ڡ����Τߥ����å�
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_goods_name", "����̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

    //��ά��
    //��ɬ�ܥ����å�
    $form->addRule(
        "form_goods_cname","ά�Τ�1ʸ���ʾ�7ʸ���ʲ��Ǥ���",
        'required');
    $form->addRule("form_goods_cname", "ά�� �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

    //���Ͷ�ʬ
    //��ɬ�ܥ����å�
    $form->addRule(
        "form_g_goods_id", "�Ͷ�ʬ��ɬ�ܹ��ܤǤ���",
        "required");

    //��������ʬ
    //��ɬ�ܥ����å�
    $form->addRule(
        "form_product_id", "������ʬ��ɬ�ܹ��ܤǤ���",
        "required");

	//������ʬ��
	//��ɬ�ܥ����å�
	$form->addRule('form_g_product_id', "����ʬ���ɬ�ܹ��ܤǤ���","required"
	);

}

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
        "regex", "/^[0-9]+$/");
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
/*****************************/
//�롼�������PHP��
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ" ){

    /****************************/
    //POST����
    /****************************/
    $state          = $_POST["form_state"];                 //����
    $goods_cd       = $_POST["form_goods_cd"];              //����CD
    $goods_name     = $_POST["form_goods_name"];            //����̾
    $goods_cname    = $_POST["form_goods_cname"];           //ά��
    $attri_div      = $_POST["form_attri_div"];             //°����ʬ
    $g_goods_id     = $_POST["form_g_goods_id"];            //�Ͷ�ʬID
    $product_id     = $_POST["form_product_id"];            //������ʬID
	$g_product_id   = $_POST["form_g_product_id"];          //����ʬ��
    $unit           = $_POST["form_unit"];                  //ñ��  
    $in_num         = $_POST["form_in_num"];                //����  
    $supplier_cd    = $_POST["form_supplier"]["cd"];        //�����襳����
    $supplier_name  = $_POST["form_supplier"]["name"];      //�����襳����
    $sale_manage    = $_POST["form_sale_manage"];           //�������
    $stock_manage   = $_POST["form_stock_manage"];          //�߸˴���
    $stock_only     = $_POST["form_stock_only"];            //�߸˸¤���
    $order_point    = $_POST["form_order_point"];           //ȯ����
    $order_unit     = $_POST["form_order_unit"];            //ȯ��ñ�̿�
    $lead           = $_POST["form_lead"];                  //�꡼�ɥ����������
    $name_change    = $_POST["form_name_change"];           //��̾�ѹ�
    $tax_div        = $_POST["form_tax_div"];               //���Ƕ�ʬ
    $note           = $_POST["form_note"];                  //����  
    $url            = $_POST["form_url"];                   //URL
    $mark_div       = $_POST["form_mark_div"];               //�ޡ���

    //��������
    //��ɬ�ܥ����å�
    if($supplier_cd != null && $supplier_name == null){
        $form->setElementError("form_supplier", "�����������襳���ɤ����Ϥ��Ʋ�������");
    }

    //URL�����å�
    if(!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) && $url != null){
        $form->setElementError("form_url","������URL�����Ϥ��Ʋ�������");
    }

    if($head_flg != true){
        //���������ηϥ����å�
        if($goods_cd != null && (strlen($goods_cd) >= 8) && 
            substr($goods_cd, 0, 1) == 0){
            $form->setElementError("form_goods_cd","���ʥ����ɤξ壱��ϡ֣��װʳ��Ǥ���");
        }

        //�����ʥ����ɶ��������å�
        $goods_cd_sql  = " SELECT";
        $goods_cd_sql .= "     goods_cd";
        $goods_cd_sql .= " FROM";
        $goods_cd_sql .= "     t_goods";
        $goods_cd_sql .= " WHERE";
        $goods_cd_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
        $goods_cd_sql .= "     AND";
        $goods_cd_sql .= "     goods_cd = '$goods_cd'";
        $goods_cd_sql .= " ;";

        $result = Db_Query($conn, $goods_cd_sql) or die("�����ꥨ�顼");
        $goods_cd_res = @pg_fetch_result($result, 0,0);

        if($goods_cd_res != null && $get_flg != true){
            $form->setElementError("form_goods_cd","���˻��Ѥ���Ƥ��뾦�ʥ����ɤǤ���");
        }elseif($goods_cd_res != null && $get_flg == true && $get_goods_data[0] != $goods_cd_res){
            $form->setElementError("form_goods_cd","���˻��Ѥ���Ƥ��뾦�ʥ����ɤǤ���");
        }
    }

    /***************************/
    //����
    /***************************/
    if($form->validate()){
 
        /***************************/
        //ɬ�ܥǡ�������
        /***************************/
        $make_goods_flg = 0;                                    //��¤�ʥե饰
        $public_flg     = 0;                                    //��ͭ�ե饰
        $compose_flg    = 0;                                    //�����ʥե饰
        $head_fc_flg  = 0;                                    //�������̥ե饰

        /****************************/
        //null���֤�����
        /****************************/
        if($order_point == null){
            $order_point = "null"; 
        }

        /****************************/
        //������Ͽ
        /****************************/
        //�ѹ����������ʤǤʤ���

        Db_Query($conn, "BEGIN;");

        if($get_flg == true && $head_flg != true){
            //���ʥޥ���
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
            #2009-10-08 hashimoto-y
            #$goods_sql .= "     stock_manage = '$stock_manage',";
            $goods_sql .= "     stock_only = '$stock_only',";
            $goods_sql .= "     url = '$url',";
            $goods_sql .= "     mark_div = '$mark_div', ";
            $goods_sql .= "     in_num = '$in_num' ";
            $goods_sql .= " WHERE";
            $goods_sql .= "     goods_id = $get_goods_id";
            $goods_sql .= ";";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //���ʥޥ������ѹ������ޥ�����ȿ�Ǥ���
            $result = Mst_Sync_Goods($conn,$get_goods_id,"name");
            if($result === false){
                exit;
            }
        }

        //�ѹ�    
        if($get_flg == true){
            //����å��̾��ʾ���ơ��֥�
            $goods_sql  = " UPDATE";
            $goods_sql .= "     t_goods_info";
            $goods_sql .= " SET";
            $goods_sql .= "     goods_id = $get_goods_id,";
            $goods_sql .= "     order_point = $order_point,";
            $goods_sql .= "     order_unit = '$order_unit',";
            $goods_sql .= "     lead = '$lead',";
            $goods_sql .= "     note = '$note',";
            #2009-10-08 hashimoto-y
            $goods_sql .= "     stock_manage = '$stock_manage',";

            //�����褬���ꤵ��Ƥ������
            if($supplier_cd != null){
                $goods_sql .= "     supplier_id = (";
                $goods_sql .= "                 SELECT";
                $goods_sql .= "                     client_id";
                $goods_sql .= "                 FROM";
                $goods_sql .= "                     t_client";
                $goods_sql .= "                 WHERE";
                $goods_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd1 = '$supplier_cd'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_div = '2'";
                $goods_sql .= "                 )";
            }else{
                $goods_sql .= "     supplier_id = null";
            }
            $goods_sql .= " WHERE";
            $goods_sql .= "     goods_id = $get_goods_id";
            $goods_sql .= "     AND";
            $goods_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
            $goods_sql .= ";";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

			$sql  = "SELECT ";
			$sql .= "    goods_name ";
			$sql .= "FROM ";
			$sql .= "    t_goods ";
			$sql .= "WHERE ";
			$sql .= "    goods_id = $get_goods_id;";
			$result = Db_Query($conn, $sql); 
			$data_list = Get_Data($result,3);
			$goods_name = $data_list[0][0];

            $work_div = '2';


        }
    
        //������Ͽ
        if($get_flg != true){        
            //���ʥޥ���
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
            #2009-10-08 hashimoto-y
            #$goods_sql .= "     stock_manage,";
            $goods_sql .= "     stock_only,";
            $goods_sql .= "     make_goods_flg,";
            $goods_sql .= "     public_flg,";
            $goods_sql .= "     shop_id,";
            $goods_sql .= "     state,";
            $goods_sql .= "     url,";
            $goods_sql .= "     mark_div, ";
            $goods_sql .= "     in_num,";
            $goods_sql .= "     accept_flg";
            $goods_sql .= " )VALUES (";
            $goods_sql .= "     (SELECT COALESCE(MAX(goods_id), 0)+1 FROM t_goods),";
            $goods_sql .= "     '$goods_cd',";
            $goods_sql .= "     '$goods_name',";
            $goods_sql .= "     '$goods_cname',";
            $goods_sql .= "     '$attri_div',";
            $goods_sql .= "     $product_id,";
			$goods_sql .= "     $g_product_id,";
            $goods_sql .= "     $g_goods_id,";
            $goods_sql .= "     '$unit',";
            $goods_sql .= "     '$tax_div',";
            $goods_sql .= "     '$name_change',";
            $goods_sql .= "     '$sale_manage',";
            #2009-10-08 hashimoto-y
            #$goods_sql .= "     '$stock_manage',";
            $goods_sql .= "     '$stock_only',";
            $goods_sql .= "     '$make_goods_flg',";
            $goods_sql .= "     '$public_flg',";
            $goods_sql .= "     $shop_id,";
            $goods_sql .= "     '$state',";
            $goods_sql .= "     '$url',";
            $goods_sql .= "     '$mark_div', ";
            $goods_sql .= "     '$in_num',";
            $goods_sql .= "     '1'";
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
            #2009-10-08 hashimoto-y
            $goods_sql .= "     stock_manage,";
            $goods_sql .= "     supplier_id,";
            $goods_sql .= "     compose_flg,";
            $goods_sql .= "     shop_id,";
            $goods_sql .= "     head_fc_flg";
            $goods_sql .= ") VALUES (";
            $goods_sql .= "     (SELECT";
            $goods_sql .= "         goods_id";
            $goods_sql .= "     FROM";
            $goods_sql .= "         t_goods";
            $goods_sql .= "     WHERE";
            $goods_sql .= "         goods_cd = '$goods_cd'";
            $goods_sql .= "         AND";
            $goods_sql .= "         shop_id = $shop_id";
            $goods_sql .= "     ),";
            $goods_sql .= "     $order_point,";
            $goods_sql .= "     '$order_unit',";
            $goods_sql .= "     '$lead',";
            $goods_sql .= "     '$note',";
            #2009-10-08 hashimoto-y
            $goods_sql .= "     '$stock_manage',";

            //�����褬���ꤵ��Ƥ������
            if($supplier_cd != null){
                $goods_sql .= "     (";
                $goods_sql .= "      SELECT";
                $goods_sql .= "        client_id";
                $goods_sql .= "      FROM";
                $goods_sql .= "        t_client";
                $goods_sql .= "      WHERE";
                $goods_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd1 = '$supplier_cd'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_div = '2'";
                $goods_sql .= "    ),";
            }else{
                $goods_sql .= "null,";
            }
            $goods_sql .= "    '$compose_flg',";
            $goods_sql .= "    $shop_id,";
            $goods_sql .= "    '$head_fc_flg'";
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
        Db_Query($conn, "COMMIT;");
        $freeze_flg = true;
    }
}

// ���򤵤줿���ʤ��������ʤξ��
if($get_goods_data[27] == 't'){
    // ���ʥ����ɥե������ե꡼��
    $head_item_form->freeze();
    // �������󥯤򥹥��ƥ��å���
    $form->addElement("static","form_client_link","","������");
}


if($freeze_flg == true){
//    if($get_flg != true){
        /****************************/
        //GET�ǡ�������
        /****************************/
        $goods_id_sql  = "SELECT";
        $goods_id_sql .= "   goods_id";
        $goods_id_sql .= " FROM";
        $goods_id_sql .= "   t_goods";
        $goods_id_sql .= " WHERE";
        $goods_id_sql .= "  goods_cd = '$goods_cd'";
        $goods_id_sql .= "  AND (";
        $goods_id_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
        $goods_id_sql .= "  OR\n";
        $goods_id_sql .= "  public_flg ='t'\n";
        $goods_id_sql .= "  )";
        $goods_id_sql .= ";"; 

        $result = Db_Query($conn, $goods_id_sql);

        $get_goods_id = pg_fetch_result($result, 0);
//    }

    //������Ƚ��
//    if($get_flg == true){
        $target = "./2-1-222.php?goods_id=".$get_goods_id;
//    }else{
//        $target = "./2-1-221.php";
//    }

    $form->addElement("button","form_entry_button","�ϡ���","onClick=\"javascript:location.href='$target'\"");
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"location.href='./2-1-221.php?goods_id=$get_goods_id'\"");

    $form->addElement("static","form_client_link","","������");
    $form->freeze();
    
}else{
    $form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");
    $form->addElement(
        "button","form_show_dialog_button","��Ͽ�Ѱ�����ǧ",
        "onClick='javascript:showModelessDialog(\"../dialog/2-0-210-1.php\",window,\"status:false;dialogWidth:540px;dialogHeight:500px;edge:sunken;\")'
    ");
    //���إܥ���
    if($next_id != null){
        $form->addElement("button","next_button","������","onClick=\"location.href='./2-1-221.php?goods_id=$next_id'\"");
    }else{  
        $form->addElement("button","next_button","������","disabled");
    }
    //���إܥ���
    if($back_id != null){
        $form->addElement("button","back_button","������","onClick=\"location.href='./2-1-221.php?goods_id=$back_id'\"");
    }else{  
        $form->addElement("button","back_button","������","disabled");
    }
    if($get_goods_data[27] == 't'){
        //������
        $form->addElement(
            "link","form_client_link","","#","������",
            "onClick=\"return Open_SubWin('../dialog/2-0-208.php?head_flg=true', Array('form_supplier[cd]', 'form_supplier[name]'), 500, 450);\""
        );
       }else{
        //������
   	    $form->addElement(
            "link","form_client_link","","#","������",
            "onClick=\"return Open_SubWin('../dialog/2-0-208.php?head_flg=false', Array('form_supplier[cd]', 'form_supplier[name]'), 500, 450);\""
   	    );
    }
}
$form->addElement(
    "button","form_set_price_button","ñ������",
    "onClick='javascript:location.href = \"2-1-222.php?goods_id=$get_goods_id\"'
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
//$page_menu = Create_Menu_f('system','1');

/****************************/
//���̥إå�������
/****************************/
$goods_sql  = " SELECT";
$goods_sql .= "     COUNT(t_goods_info.goods_id)";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods_info,";
$goods_sql .= "     t_goods";
$goods_sql .= " WHERE";
$goods_sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
$goods_sql .= " AND";
$goods_sql .= "     t_goods_info.goods_id = t_goods.goods_id";
$goods_sql .= " AND";
$goods_sql .= "     t_goods.accept_flg = '1'";
$goods_sql .= " AND";
$goods_sql .= "     t_goods.compose_flg = 'f'";
$goods_sql .= " AND";
$goods_sql .= "    (";
$goods_sql .= ($group_kind == "2") ? "     t_goods.state IN ('1', '3')" : "     t_goods.state = '1'";
$goods_sql .= "    OR";
$goods_sql .= "        (t_goods.state = '2' AND ";
$goods_sql .= ($group_kind == "2") ? "t_goods.shop_id IN (".Rank_Sql().")) " : " t_goods.shop_id = $shop_id) ";
$goods_sql .= "    )";
$goods_sql .= " AND ";
$goods_sql .= " length(t_goods.goods_cd) = 8";
$goods_sql .= " ;";


$result = Db_Query($conn,$goods_sql);
//���������(�إå���)
$t_count = pg_fetch_result($result,0,0);

$goods_sql  = " SELECT";
$goods_sql .= "     COUNT(t_goods_info.goods_id)";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods,";
$goods_sql .= "     t_goods_info";
$goods_sql .= " WHERE";
$goods_sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods_info.goods_id = t_goods.goods_id";
$goods_sql .= "     AND";
$goods_sql .= ($group_kind == "2") ? " t_goods.state IN (1,3)" : " t_goods.state = 1";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.compose_flg = 'f'";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.accept_flg = '1'";
$goods_sql .= " AND ";
$goods_sql .= " length(t_goods.goods_cd) = 8";
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
	'page_menu'             => "$page_menu",
	'page_header'           => "$page_header",
	'html_footer'           => "$html_footer",
    'head_flg'              => "$head_flg",
    'code_value'            => "$code_value",
    'buy_day'               => "$max_buy_day",
    'sale_day'              => "$max_sale_day",
	'get_goods_id'          => "$get_goods_id"
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
