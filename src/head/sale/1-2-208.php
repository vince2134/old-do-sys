<?php
/************************************/
//�ѹ�����
//  ��������������ǡ������SQL���ѹ���2006/06/16��watanabe-k��
//
//��2006/09/15��kaji��
//  ��������򺣲������ʹߤβ������
//  ��ʬ������2��ʾ��
//��2006/10/26 kaji��
//  ���������������Ϥ����Ϥ��줿���׾��������
//
//��2006/11/27 koji��
//  �����ˤʤ�����+�������Ȥ���褦�˽���
/************************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/30      08-058      ��          ��ǧ/��λ���̤�OK�ܥ��������
 *  2006/11/07      08-117      suzuki      �إå��������SQL�η�����ѹ�
 *  2006/11/07      08-094      suzuki      ���ID��¸��Ƚ���Ԥ�
 *                  08-087
 *                  08-016
 *                  08-017
 *  2006/11/07      08-095      suzuki      ���ID�ο���Ƚ���Ԥ�
 *                  08-088
 *  2006/11/07      08-096      suzuki      �������ʳ�����ɼ��TOP�����ܤ���褦���ѹ�
 *                  08-089
 *  2006/11/07      08-119      suzuki      ���Ȳ񤫤����ܤ����ݤˡ�division_flg���ѹ�������TOP�����ܤ���褦�˽���
 *  2006/11/13      080155      ��          ����������˻�����ɼ���ѹ����줿�����н�
 *  2006/12/14      kaji-198    kaji        ������Ͽľ���˸�����夬������줿���ޤ��������������줿���ν����ɲ�
 *  2007/01/16      �����ѹ�    watanabe-k  ʬ�����򣲡������ޤǤ��ѹ�
 *  2009/10/13                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *   2016/01/20                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 *
 */
//$page_title = "���Ȳ�";
$page_title = "�����������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
//�����ѿ�����
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];

$sale_id      = $_GET["sale_id"];             //����ID
Get_Id_Check2($sale_id);
Get_Id_Check3($sale_id);
$division_flg   = $_GET["division_flg"];       // ʬ������ѥե饰

$slip_bill_flg  = $_POST["slip_bill_flg"];     //�����������Ƚ��ե饰
$slip_data["slip_bill_flg"] = $slip_bill_flg;
$form->setConstants($slip_data);   
if($division_flg == NULL && $slip_bill_flg == NULL){
	Header("Location: ../top.php");  
}

// ��ɼ�ѹ������򥻥åȥǥե����
$sql = "SELECT change_day FROM t_sale_h WHERE sale_id = $sale_id ;";
$res = Db_Query($db_con, $sql);
Get_Id_Check($res);
$set_change_date["hdn_change_date"] = pg_fetch_result($res, 0, 0);
$form->setDefaults($set_change_date);


/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");
//������Ƚ��ؿ�
Injustice_check($db_con,"sale_cup",$sale_id,$shop_id);

/****************************/
//�������
/****************************/
//���׾���
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_sale_day","form_sale_day");

//������
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_claim_day","form_claim_day");

//��ɼ�ֹ�
$form->addElement("static","form_sale_no","","");
//�����ֹ�
$form->addElement("static","form_ord_no","","");

//������̾
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//���꡼�����
$form->addElement("static","form_trans_check","","");
//�����ȼ�̾
$form->addElement("static","form_trans_name","","");
//ľ����̾
$form->addElement("static","form_direct_name","","");
//�в��Ҹ�
$form->addElement("static","form_ware_name","","");
//�����ʬ
$form->addElement("static","form_trade_sale","","");
//����ô����
$form->addElement("static","form_staff_name","","");
//���ô����
$form->addElement("static","form_cstaff_name","","");
//����
//����
$form->addElement("static","form_note","","");

//��ɼȯ��
$form->addElement("submit","add_button","ʬ��������Ͽ","$disabled");

//���ܸ������å�
//������ϲ���
//OK
$form->addElement("button", "ok_button", "�ϡ���",
    "onClick=javascript:location.href='".Make_Rtn_Page("sale")."'"
);
//���
$form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back();\"");

//����۹��
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//�����ǳ�(���)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//����ۡ��ǹ����)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"8\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//ʬ����
$select_value[null] = null;
/*
$select_value[2]    = "2��";
$select_value[3]    = "3��";
$select_value[6]    = "6��";
$select_value[12]   = "12��";
$select_value[24]   = "24��";
$select_value[36]   = "36��";
$select_value[48]   = "48��";
$select_value[60]   = "60��";
*/

for($i = 2; $i <= 60; $i++){
    $select_value[$i] = $i."��";
}
$form->addElement(
        "select","form_division_num", "", $select_value, "$g_form_option_select");
// hidden       
$form->addElement("hidden", "hdn_division_submit", "");
$form->addElement("hidden", "hdn_pay_m", "");
$form->addElement("hidden", "hdn_pay_d", "");
$form->addElement("hidden", "hdn_division_num", "");
$form->addElement("hidden","slip_bill_flg");    //����������ܥե饰 
$form->addElement("hidden", "hdn_change_date");
$form->addElement("hidden", "hdn_mst_pay_m");

//������
//��
$select_month[null] = null; 
//for($i = 1; $i <= 12; $i++){

for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "����"; 
    }elseif($i == 1){

//    if($i == 1){
        $select_month[1] = "���"; 
    }else{  
        $select_month[$i] = $i."�����";
    }
}
$form->addElement("select", "form_pay_m", "���쥯�ȥܥå���", $select_month, $g_form_option_select);

//��
for($i = 0; $i <= 29; $i++){
    if($i == 29){ 
        $select_day[$i] = '����'; 
    }elseif($i == 0){
        $select_day[null] = null; 
    }else{  
        $select_day[$i] = $i."��";
    }
}
$freeze_pay_d = $form->addElement("select", "form_pay_d", "���쥯�ȥܥå���", $select_day, $g_form_option_select);
$freeze_pay_d->freeze();

//ʬ������ܥ���
$form->addElement(
        "button", "form_conf_button", "ʬ������",
        "onClick=\"Button_Submit('hdn_division_submit','#', 't', this);\" $disabled"
);

/****************************/
//���إå������Ƚ�����
/****************************/
$sql  = "SELECT ";
$sql .= "    aord_id,";
$sql .= "    renew_flg ";
$sql .= "FROM ";
$sql .= "    t_sale_h ";
$sql .= "WHERE ";
$sql .= "    t_sale_h.sale_id = $sale_id ";
$sql .= "    AND ";
$sql .= "    shop_id = $shop_id;";
$result = Db_Query($db_con,$sql);
//GET�ǡ���Ƚ��
Get_Id_Check($result);
$stat = Get_Data($result);
$aord_id   = $stat[0][0];            //����ID
$renew_flg = $stat[0][1];            //���������ե饰
$division_flg = ($renew_flg == "t") ? "true" : $division_flg;

//ʬ������ܥ��󲡲�����������������Ƥ�����票�顼
if($renew_flg == "t" && isset($_POST["add_button"])){
    $renew_msg = "������������Ƥ��뤿�ᡢ����������ϤǤ��ޤ���";
}

//���������ե饰��true��
if($renew_flg == 't'){
    /****************************/
    //���إå����SQL�������������
    /****************************/
    $sql  = "SELECT ";                             
    $sql .= "    t_sale_h.sale_no,";
    $sql .= "    t_aorder_h.ord_no,";
    $sql .= "    t_sale_h.sale_day,";
    $sql .= "    t_sale_h.claim_day,";
    $sql .= "    t_sale_h.client_cd1,";
    $sql .= "    t_sale_h.client_cd2,";
    $sql .= "    t_sale_h.client_cname,";
    $sql .= "    t_sale_h.green_flg,";
    $sql .= "    t_sale_h.trans_name,";
    $sql .= "    t_sale_h.direct_name,";
    $sql .= "    t_sale_h.ware_name,";
    $sql .= "    CASE t_sale_h.trade_id";            
    $sql .= "        WHEN '11' THEN '�����'";
    $sql .= "        WHEN '13' THEN '������'";
    $sql .= "        WHEN '14' THEN '���Ͱ�'";
    $sql .= "        WHEN '15' THEN '�������'";
    $sql .= "        WHEN '61' THEN '�������'";
    $sql .= "        WHEN '63' THEN '��������'";
    $sql .= "        WHEN '64' THEN '�����Ͱ�'";
    $sql .= "    END,";
    $sql .= "    t_sale_h.c_staff_name,";
    $sql .= "    t_sale_h.note, ";
    $sql .= "    t_sale_h.net_amount, ";
    $sql .= "    t_sale_h.tax_amount, ";
    $sql .= "    t_sale_h.ac_staff_name,";
    $sql .= "    t_sale_h.ware_id, ";
    $sql .= "    t_sale_h.client_id ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";

    $sql .= "    LEFT JOIN ";
    $sql .= "    t_aorder_h ";
    $sql .= "    ON t_sale_h.aord_id = t_aorder_h.aord_id ";

    $sql .= "WHERE ";
    $sql .= "    t_sale_h.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    t_sale_h.sale_id = $sale_id;";
}else{
    /****************************/
    //���إå������SQL
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "    t_sale_h.sale_no,\n";
    $sql .= "    t_aorder_h.ord_no,\n";
    $sql .= "    t_sale_h.sale_day,\n";
    $sql .= "    t_sale_h.claim_day,\n";
//    $sql .= "    t_client.client_cd1,\n";
//    $sql .= "    t_client.client_cd2,\n";
//    $sql .= "    t_client.client_name,\n";
    $sql .= "    t_sale_h.client_cd1,\n";
    $sql .= "    t_sale_h.client_cd2,\n";
    $sql .= "    t_sale_h.client_cname,\n";
    $sql .= "    t_sale_h.green_flg,\n";
//    $sql .= "    t_trans.trans_cname,\n";
//    $sql .= "    t_direct.direct_cname,\n";
//    $sql .= "    t_ware.ware_name,\n";
    $sql .= "    t_sale_h.trans_cname,\n";
    $sql .= "    t_sale_h.direct_cname,\n";
    $sql .= "    t_sale_h.ware_name,\n";
    $sql .= "    CASE t_sale_h.trade_id\n";
    $sql .= "        WHEN '11' THEN '�����'\n";
    $sql .= "        WHEN '13' THEN '������'\n";
    $sql .= "        WHEN '14' THEN '���Ͱ�'\n";
    $sql .= "        WHEN '15' THEN '�������'\n";
    $sql .= "        WHEN '61' THEN '�������'\n";
    $sql .= "        WHEN '63' THEN '��������'\n";
    $sql .= "        WHEN '64' THEN '�����Ͱ�'\n";
    $sql .= "    END,\n";
    $sql .= "    c_staff.staff_name,\n";
    $sql .= "    t_sale_h.note, \n";
    $sql .= "    t_sale_h.net_amount, \n";
    $sql .= "    t_sale_h.tax_amount, \n";
//    $sql .= "    ac_staff.staff_name, \n";
    $sql .= "    t_sale_h.ac_staff_name, \n";
    $sql .= "    t_sale_h.ware_id, \n";
    $sql .= "    t_sale_h.client_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_sale_h \n";

    $sql .= "    LEFT JOIN \n";
    $sql .= "    t_trans \n";
    $sql .= "    ON t_sale_h.trans_id  = t_trans.trans_id \n";

    $sql .= "    LEFT JOIN \n";
    $sql .= "    t_direct \n";
    $sql .= "    ON t_sale_h.direct_id  = t_direct.direct_id \n";

    $sql .= "    LEFT JOIN \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "    ON t_sale_h.aord_id = t_aorder_h.aord_id \n";

    $sql .= "    INNER JOIN t_client ON t_sale_h.client_id  = t_client.client_id \n";
    $sql .= "    INNER JOIN t_ware   ON t_sale_h.ware_id    = t_ware.ware_id \n";
    $sql .= "    INNER JOIN t_staff AS c_staff  ON t_sale_h.c_staff_id = c_staff.staff_id \n";
    $sql .= "    LEFT JOIN t_staff AS ac_staff  ON t_sale_h.ac_staff_id = ac_staff.staff_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_sale_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "    t_sale_h.sale_id = $sale_id;\n";
}

$result = Db_Query($db_con,$sql);
$h_data_list = Get_Data($result);

/****************************/
//���ǡ������SQL
/****************************/
$data_sql  = "SELECT ";
//���������ե饰��true��
if($renew_flg == 't'){
    $data_sql .= "    t_sale_d.goods_cd,";
}else{
//    $data_sql .= "    t_goods.goods_cd,";
    $data_sql .= "    t_sale_d.goods_cd,";
}
$data_sql .= "    t_sale_d.goods_name,";
$data_sql .= "    t_sale_d.num,"; 
$data_sql .= "    t_sale_d.cost_price,";
$data_sql .= "    t_sale_d.sale_price,";
$data_sql .= "    t_sale_d.cost_amount, ";
$data_sql .= "    t_sale_d.sale_amount, ";

//����ID��������ϡ��������ɽ��
if($aord_id != NULL){
    $data_sql .= "    t_aorder_d.num, ";
}
#2009-10-13 hashimoto-y
#$data_sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num ";
$data_sql .= "    CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num ";

$data_sql .= "FROM ";
$data_sql .= "    t_sale_d ";
$data_sql .= "    INNER JOIN t_sale_h ON t_sale_d.sale_id = t_sale_h.sale_id ";

//����ID��������ϡ�����ǡ����ơ��֥�ȷ��
if($aord_id != NULL){
    $data_sql .= "    INNER JOIN t_aorder_d ON t_sale_d.aord_d_id = t_aorder_d.aord_d_id ";
}

//���������ե饰��true��
$data_sql .= "    INNER JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id ";
$data_sql .= "   LEFT JOIN ";
$data_sql .= "   (SELECT";
$data_sql .= "       goods_id,";
$data_sql .= "       SUM(stock_num)AS stock_num";
$data_sql .= "   FROM";
$data_sql .= "       t_stock";
$data_sql .= "   WHERE";
$data_sql .= "       shop_id = $shop_id";
$data_sql .= "       AND";
$data_sql .= "       ware_id = ".$h_data_list[0][17];
$data_sql .= "       GROUP BY t_stock.goods_id";
$data_sql .= "   )AS t_stock";
$data_sql .= "   ON t_sale_d.goods_id = t_stock.goods_id ";
#2009-10-13 hashimoto-y
$data_sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

$data_sql .= "WHERE ";
$data_sql .= "    t_sale_d.sale_id = $sale_id ";
$data_sql .= "AND ";
$data_sql .= "    t_sale_h.shop_id = $shop_id ";
#2009-10-13 hashimoto-y
$data_sql .= "AND ";
$data_sql .= "    t_goods_info.shop_id = $shop_id ";

$data_sql .= "ORDER BY ";
//���������ե饰��true��
if($renew_flg == 't'){
    $data_sql .= "    t_sale_d.goods_cd;";
}else{
//    $data_sql .= "    t_goods.goods_cd;";
    $data_sql .= "    t_sale_d.goods_cd;";
}

$result = Db_Query($db_con,$data_sql);

/****************************/
//���إå���ɽ��
/****************************/
$def_fdata["form_sale_no"]                      =   $h_data_list[0][0];                          //��ɼ�ֹ�
$def_fdata["form_ord_no"]                       =   $h_data_list[0][1];                          //�����ֹ�

//��������
$form_sale_day                                  =   explode('-',$h_data_list[0][2]);
$form_claim_day                                 =   explode('-',$h_data_list[0][3]);

$def_fdata["form_sale_day"]["y"]                =   $form_sale_day[0];                           //�����(ǯ)
$def_fdata["form_sale_day"]["m"]                =   $form_sale_day[1];                           //�����(��)
$def_fdata["form_sale_day"]["d"]                =   $form_sale_day[2];                           //�����(��)

$def_fdata["form_claim_day"]["y"]               =   $form_claim_day[0];                          //������(ǯ)
$def_fdata["form_claim_day"]["m"]               =   $form_claim_day[1];                          //������(��)
$def_fdata["form_claim_day"]["d"]               =   $form_claim_day[2];                          //������(��)

$def_fdata["form_client"]["cd1"]                =   $h_data_list[0][4];                          //������cd1
$def_fdata["form_client"]["cd2"]                =   $h_data_list[0][5];                          //������cd2
$def_fdata["form_client"]["name"]               =   $h_data_list[0][6];                          //������̾

//���꡼�����Ƚ��
if($h_data_list[0][7] == 't'){
    $def_fdata["form_trans_check"]              = "���꡼����ꤢ�ꡡ";
}
$def_fdata["form_trans_name"]                   =   $h_data_list[0][8];                         //�����ȼ�
$def_fdata["form_direct_name"]                  =   $h_data_list[0][9];                         //ľ����
$def_fdata["form_ware_name"]                    =   $h_data_list[0][10];                         //�Ҹ�
$def_fdata["form_trade_sale"]                   =   $h_data_list[0][11];                         //�����ʬ
$def_fdata["form_cstaff_name"]                  =   $h_data_list[0][12];                         //���ô����
$def_fdata["form_note"]                         =   $h_data_list[0][13];

$def_fdata["form_sale_total"]                   =   number_format($h_data_list[0][14]);          //��ȴ���
$def_fdata["form_sale_tax"]                     =   number_format($h_data_list[0][15]);          //������
$total_money                                    =   $h_data_list[0][14] + $h_data_list[0][15];   //�ǹ����

$def_fdata["form_sale_money"]                   =   number_format($total_money);                         
$def_fdata["form_split_bill_amount"][0]         =   number_format($total_money);

$def_fdata["form_staff_name"]                   =   $h_data_list[0][16];                         //����ô����                         

//�����������
$sql = "SELECT pay_m, pay_d FROM t_client WHERE client_id = ".$h_data_list[0][18].";";
$result = Db_Query($db_con,$sql);
$pay_m = (int)pg_fetch_result($result, 0, "pay_m");
$pay_d = (int)pg_fetch_result($result, 0, "pay_d");
$form->setConstants(array("form_pay_d"=>$pay_d));
$form->setConstants(array("hdn_mst_pay_m"=>$pay_m));

$form->setDefaults($def_fdata);

//ʬ�����򥻥å�
$division_num = 1;
/*
$yy = date('Y');
$mm = date('m');
*/
//���Ϥ��줿����������ˤ���
$yy = (int)$form_claim_day[0];
$mm = (int)$form_claim_day[1];

if($_POST["hdn_division_select"] == 't'){

    if($_POST["form_division_num"] != Null 
    && $_POST["form_pay_m"] != null
    && $_POST["form_pay_d"] != null){

        $division_num = $_POST["form_division_num"];        //ʬ����

        $total_money = $_POST["form_sale_money"];        //�ǹ����
        $total_money = str_replace(",","",$total_money);

        $pay_m = $_POST["form_pay_m"];                  //�������ʷ��
        $pay_d = $_POST["form_pay_d"];                  //������������
    }

    $set_data[hdn_division_select] == 't';

}

/****************************/
// ʬ�������ǧ�Τߤξ��
/****************************/
if ($division_flg == "true"){
    // ��������ID��ʬ��ǡ��������
    $sql = "SELECT collect_day, collect_amount FROM t_installment_sales WHERE sale_id = $sale_id ORDER BY collect_day;";
    $res = Db_Query($db_con, $sql);

    $i = 0;
     while ($ary_res = @pg_fetch_array($res, $i)){
        $ary_division_data[$i]["pay_day"] = $ary_res["collect_day"];
        $ary_division_data[$i]["split_pay_amount"] = $ary_res["collect_amount"];
        $i++;
    }

    for ($i=0; $i<count($ary_division_data); $i++){
        $form->addElement("static", "form_pay_date[$i]", "");
        $form->addElement("static", "form_pay_amount[$i]", "");
        $division_data["form_pay_date[$i]"]     = $ary_division_data[$i]["pay_day"];
        $division_data["form_pay_amount[$i]"]   = number_format($ary_division_data[$i]["split_pay_amount"]);
        $form->setConstants($division_data);
    }

/****************************/
// ʬ�������Ԥ���̤����ξ��
/****************************/
}else{
    /****************************/
    // ʬ������ܥ��󲡲�����������
    /****************************/
    if ($_POST["hdn_division_submit"] == "t"){

        /*** ʬ�����ꥨ�顼�����å� ***/
        // ���顼�ե饰��Ǽ�����
        $ary_division_err_flg = array();

        // �����
        if ($_POST["form_pay_m"] == null || $_POST["form_pay_d"] == null){
        //if ($_POST["form_pay_m"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "�������ɬ�ܤǤ���";
        }

        // ʬ����
        if ($_POST["form_division_num"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "ʬ������ɬ�ܤǤ���";
        }

        // ���顼�����å���̽���
        $division_err_flg = (in_array(true, $ary_division_err_flg)) ? true : false;

        // ʬ������ե饰��Ǽ
        $division_set_flg = ($division_err_flg === false) ? true : false;

        // ʬ���������Ƥ�hidden��SET
        if ($division_set_flg == true){
            $hdn_set["hdn_pay_m"]           = $_POST["form_pay_m"];
            $hdn_set["hdn_pay_d"]           = $_POST["form_pay_d"];
            $hdn_set["hdn_division_num"]    = $_POST["form_division_num"];
            $form->setConstants($hdn_set);
        }

        // hidden��SET���줿ʬ������ܥ��󲡲��������
        $hdn_del["hdn_division_submit"] = "";
        $form->setConstants($hdn_del);

    }

    /****************************/
    // ʬ������Ͽ�ܥ��󲡲�����������
    /****************************/
    if (isset($_POST["add_button"])){

        // ��ʬ������Ͽ�ܥ���ɽ������Ƥ����ʬ���������Ƥ�����ʤ��ʤΤǡ�ʬ������ե饰ON���Ǽ
        $division_set_flg = true;

        // ��ʬ������ܥ��󲡲����ˡ�hidden��SET����ʬ���������Ƥ��ѿ�������
        $hdn_pay_m           = $_POST["hdn_pay_m"];
        $hdn_pay_d           = $_POST["hdn_pay_d"];
        $hdn_division_num    = $_POST["hdn_division_num"];

        // ����˥ե������SET��ɽ���ѡ�
        $division_set["form_pay_m"]         = $_POST["hdn_pay_m"];
        $division_set["form_pay_d"]         = $_POST["hdn_pay_d"];
        $division_set["form_division_num"]  = $_POST["hdn_division_num"];
        $form->setConstants($division_set);

    }

    /****************************/
    // ʬ���������
    /****************************/
    // ʬ������ե饰�����ξ��
    if ($division_set_flg === true){

        // ʬ������������
        $pay_m          = isset($_POST["add_button"]) ? $hdn_pay_m : $_POST["form_pay_m"];                  // ������ʷ��

//        $pay_m          = $pay_m + $_POST["hdn_mst_pay_m"];                  // ������ʷ��
        $pay_d          = isset($_POST["add_button"]) ? $hdn_pay_d : $_POST["form_pay_d"];                  // �����������
        $division_num   = isset($_POST["add_button"]) ? $hdn_division_num : $_POST["form_division_num"];    // ʬ����
        $total_money    = str_replace(",", "", $total_money);   // �ǹ���ۡʥ����ȴ����
//        $total_money    = str_replace(",", "", $_POST["form_sale_money"]);   // �ǹ���ۡʥ����ȴ����
        //$yy             = date("Y");
        //$mm             = date("m");

        // �ǹ���ۡ�ʬ�����ξ�
        $division_quotient_price    = bcdiv($total_money, $division_num);
        // �ǹ���ۡ�ʬ������;��
        $division_franct_price      = bcmod($total_money, $division_num);
        // 2���ܰʹߤβ�����
        $second_over_price          = str_pad(substr($division_quotient_price, 0, 3), strlen($division_quotient_price), 0);
        // 1���ܤβ�����
        $first_price                = ($division_quotient_price - $second_over_price) * $division_num + $division_franct_price + $second_over_price;
        // ��ۤ�ʬ�����ǳ���ڤ����
        if ($division_franct_price == "0"){
            $first_price = $second_over_price = $division_quotient_price;
        }

        // ʬ����ʬ�롼��
        for ($i=0; $i<$division_num; $i++){

            // ʬ����������
            $date_y     = date("Y", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $date_m     = date("m", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $mktime_m   = ($pay_d == "29") ? $mm + $pay_m + $i + 1 : $mm + $pay_m + $i;
            $mktime_d   = ($pay_d == "29") ? 0 : $pay_d;
            $date_d     = date("d", mktime(0, 0, 0, $mktime_m, $mktime_d, $yy));

            // ʬ�������������SET
            $division_date[]    = "$date_y-$date_m-$date_d";

            // ʬ������ۤ������SET
            $division_price[]   = ($i == 0) ? $first_price : $second_over_price;

            // ʬ�������ե��������
            $form_pay_date = null;
            $form_pay_date[] = &$form->createElement("static", "y", "", "");
            $form_pay_date[] = &$form->createElement("static", "m", "", "");
            $form_pay_date[] = &$form->createElement("static", "d", "", "");
            $form->addGroup($form_pay_date, "form_pay_date[$i]", "", "-");

            // ʬ������ۥե��������
            $form->addElement("text", "form_split_pay_amount[$i]", "", "class=\"money\" size=\"11\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

            // ʬ������ۤ򥻥å�
            $set_data["form_split_pay_amount"][$i] = ($i == 0) ? $first_price : $second_over_price;

            // ʬ�������򥻥å�
            $set_data["form_pay_date"][$i]["y"] = $date_y;
            $set_data["form_pay_date"][$i]["m"] = $date_m;
            $set_data["form_pay_date"][$i]["d"] = $date_d;

            // ʬ������ۡ�ʬ�������ǡ�����SET��ʬ������Ͽ�ܥ��󲡲����ϥե�����ǡ���������Ѥ���
            isset($_POST["add_button"]) ? $form->setDefaults($set_data) : $form->setConstants($set_data);

        }

    }

    /****************************/
    // ʬ������Ͽ�ܥ��󲡲�����
    /****************************/
    if (isset($_POST["add_button"])){

        /****************************/
        // ���顼�����å�
        /****************************/
        /* ʬ��������ˡ�������ɼ���ѹ�����Ƥ��ʤ���Ĵ�٤� */
        $sql = "SELECT * FROM t_sale_h WHERE sale_id = $sale_id AND change_day = '".$_POST["hdn_change_date"]."';";
        $res = Db_Query($db_con, $sql);
        if (pg_num_rows($res) == 0){
            // �����ʥǡ����Ǥʤ����ϻ�����λ���̤�����
            header("Location:1-2-205.php?inst_err=true&sale_id=0&input_flg=true");
            exit;
        }

        /* ��׶�ۥ����å� */
        // ʬ�������
        $sum_err_flg = ($total_money != array_sum($_POST["form_split_pay_amount"])) ? true : false;
        if ($sum_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "ʬ�������ۤι�פ������Ǥ���");
        }

        /* Ⱦ�ѿ��������å� */
        // ʬ�������
        for ($i=0; $i<$division_num; $i++){
            $ary_numeric_err_flg[] = (ereg("^[0-9]+$", $_POST["form_split_pay_amount"][$i])) ? false : true;
        }
        if (in_array(true, $ary_numeric_err_flg)){
            $form->setElementError("form_split_pay_amount[0]", "ʬ�������ۤ�Ⱦ�ѿ����ΤߤǤ���");
        }

        /* ɬ�ܹ��ܥ����å� */
        // ʬ�������
        $required_err_flg = (in_array(null, $_POST["form_split_pay_amount"])) ? true : false;
        if ($required_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "ʬ�������ۤ�ɬ�ܤǤ���");
        }

        // ���顼�����å���̽���
        $err_flg = ($sum_err_flg == true || in_array(true, $ary_numeric_err_flg) || $required_err_flg == true) ? true : false;

        // �Х�ǡ�������
        $form->validate();
        /****************************/
        // DB����
        /****************************/
        // ���顼��̵�����
        if ($err_flg == false){

            // �ե꡼��
            $form->freeze();

            // �ȥ�󥶥�����󳫻�
            Db_Query($db_con, "BEGIN;");

            // ���������ե饰�����
            $db_err_flg = array();

            /* �����إå��ơ��֥빹������(UPDATE) */
            $sql = "UPDATE t_sale_h SET total_split_num = $division_num WHERE sale_id = $sale_id;";
            $res  = Db_Query($db_con, $sql);

            // �������Ի�����Хå�
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* �������ơ��֥빹������(DELETE) */
            $sql = "DELETE from t_installment_sales WHERE sale_id = $sale_id;";
            $res  = Db_Query($db_con, $sql);

            // �������Ի�����Хå�
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* �������ơ��֥빹������(INSERT) */
            for ($i=0; $i<$division_num; $i++){
                $sql  = "INSERT INTO \n";
                $sql .= "    t_installment_sales \n";
                $sql .= "( \n";
                $sql .= "    installment_sales_id, \n";
                $sql .= "    sale_id, \n";
                $sql .= "    collect_day, \n";
                $sql .= "    collect_amount \n";
                $sql .= ") VALUES ( \n";
                $sql .= "    (SELECT COALESCE(MAX(installment_sales_id), 0)+1 FROM t_installment_sales), \n";
                $sql .= "    $sale_id, \n";
                $sql .= "    '$division_date[$i]', \n";
                $sql .= "    ".$_POST["form_split_pay_amount"][$i]." \n";
                $sql .= ");\n";

                $res  = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }

            // SQL���顼��̵�����
            if (!in_array(true, $db_err_flg)){

                // ����åȤ���
                Db_Query($db_con, "COMMIT;");

                // ʬ������Ͽ�ե饰��TRUE��SET
                $division_comp_flg = true;

                // ����ɽ���Ѥ˥ʥ�С��ե����ޥåȤ���ʬ������ۤ򥻥å�
                if (isset($_POST["add_button"])){
                    for ($i=0; $i<count($_POST["form_split_pay_amount"]); $i++){
                        $number_format_data["form_split_pay_amount"][$i] = number_format($_POST["form_split_pay_amount"][$i]);
                    }
                }
                $form->setConstants($number_format_data);
            }

        }

    }

}


//print_array($_POST);

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
//$page_menu = Create_Menu_h('sale','2');
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
    'html_header'           => "$html_header",
    'page_menu'             => "$page_menu",
    'page_header'           => "$page_header",
    'html_footer'           => "$html_footer",
    "division_set_flg"      => $division_set_flg,
    "division_err_flg"      => $division_err_flg,
    "ary_division_err_msg"  => $ary_division_err_msg,
    "division_comp_flg"     => $division_comp_flg,
    "division_flg"          => $division_flg,
    'renew_msg'             => "$renew_msg",
    "freeze_flg"            => $freeze_flg,
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
