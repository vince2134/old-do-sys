<?php
/***********************************/
//�ѹ�����
//  ��2006/05/29�����ô���Ԥ����ꤹ��褦���ѹ�
//  ��2006/06/07�˸��߸˿�ɽ�����ѹ�
//   (2006/06/20) �����鵯�����Ƥ��������ѹ��Ǥ��ʤ��Х�����
//
//   (2006/07/10) attach_gid��ʤ���
//   (2006/07/31) �����Ǥη׻���ˡ���ѹ�
//   (2006/08/22) �ѹ����ϻ������ʤ��ɲä��Ǥ��ʤ��Х��ν���
//   (2006/08/23) �����̵ͭ�˴ؤ�餺�����Ϥ��ѹ����Ǥ���褦�˽���
//   (2006/09/04) ����������Ͻ������ɲ�
//   (2006/09/16) ����������Ͻ���������������
//                �ǥե����2�������ѹ�
//   (2006/09/16) ����ʬ��̾��Ĥ��褦���ѹ�  
/***********************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/30      08-045      ��          ������̾��ά��ɽ�����ѹ�
 *  2006/10/30      08-061      ��          �������󥯡�������������������ˤ�ľ�ĥ���åפ����Ϥ���Ƥ��ʤ��Х�����
 *  2006/10/31      08-005      ��          ɽ�����褦�Ȥ��Ƥ�����ɼ���������»ܺѤǤ�������ѥ⥸�塼������ܤ�����������ɲ�
 *  2006/11/06      08-047      watanabe-k  ����İ����ˤʤ������ֹ椬�ץ������˴ޤޤ�Ƥ���Х��ν���
 *  2006/11/06      08-047      watanabe-k  ������ʬ�˳�����夬ɽ������Ƥ��ʥХ��ν���
 *  2006/11/06      08-048      watanabe-k  ���׾�����ɬ�ܥ��顼�Υ�å�������Ŭ�ڤǤϤʤ��Х��ν���
 *  2006/11/06      08-050      watanabe-k  �������Υ��顼��å�������ɽ������Ƥ��ʤ��Х��ν���
 *  2006/11/06      08-047      watanabe-k  ����̾��;�פ˥��˥���������Ƥ���Х��ν���
 *  2006/11/06      08-110      watanabe-k  ������˥����ƥ೫�������������դ����ϲ�ǽ�ȤʤäƤ���Х��ν���
 *  2006/11/06      08-111      watanabe-k  �������˥����ƥ೫�������������դ����ϲ�ǽ�ȤʤäƤ���Х��ν���
 *  2006/11/07      08-091      watanabe-k  GetId�����å��ɲ�
 *  2006/11/07      08-092      watanabe-k  SQL����ѹ�
 *  2006/11/07      08-093      watanabe-k  SQL����ѹ�
 *  2006/11/07      08-118      watanabe-k  �����ȼԡ�ľ�����ά�Τ�Ĥ��褦�˽���
 *  2006/11/07      08-006      watanabe-k  ��Ͽ���˥ǡ���̵ͭ�����å����ɲ�
 *  2006/11/07      08-010      watanabe-k  ��Ͽ���˥ǡ���̵ͭ�����å����ɲ�
 *  2006/11/07      08-015      watanabe-k  ��Ͽ���˥ǡ���̵ͭ�����å����ɲ�
 *  2006/11/09      08-131      suzuki      �������ά�Τ���Ͽ
 *  2006/11/13      08-152      watanabe-k  �����Ͽ��˼�����ѹ��������˥��顼��ɽ������ʤ��Х��ν���
 *  2006/11/13      08-153      watanabe-k  ����������ѹ�����������̾�Υƥ����ȥܥå�����static�Ǥʤ��Х��ν���
 *  2006/11/13      08-154      watanabe-k  ɬ�ܤǤʤ�����̾�ˢ������դ��Ƥ���Х��ν���
 *  2006/11/14      08-157      watanabe-k  �������κݤ��ѹ��Ǥ��ʤ��Х��ν���
 *  2006/11/14      08-159      watanabe-k  ��ǧ���̤ǥ�å�������ɽ������Ƥ���Х��ν���
 *  2006/11/30      scl_204-4-7 suzuki      �������κݤ������ֹ���н�������
 *  2006/11/30      scl_204-4-7 suzuki      �������κݤ�����ۤ˾����ǳۤ�ޤ��褦�˽���
 *  2006/11/30      scl_0048    watanabe-k  ���Ϥ���ȥ����ꥨ�顼���Ф�Х��ν���    
 *  2006/12/16      scl_0085    kajioka-h   ��褬����ξ��ˡ����إå���ʬ����2�����Ͽ����褦�˽���    
 *  2006/12/18                  watanabe-k  �ޥ��ʥ���۽������ɲ�
 *  2007/01/16      0052        kajioka-h   �������η���������å����������������å��Υ�å�������ȿ�ФˤʤäƤ����Τ���
 *  2007/01/24                  ��          ��ư���⥯����ˡ�����������̾����Ͽ���ɲ�
 *  2007/01/25                  ��          ��ư���⥯����μ����ʬ���31:��������פ����39:�������פ��ѹ�
 *  2007/01/25                  watanabe-k  �ܥ���ο��ѹ�
 *  2007/02/06      B0702-001   ��          GET����ID�������������å��ɲ�
 *  2007/02/07                  watanabe-k  �����ǧ���Ƥ��ʤ���Τ�ꥹ�Ȥ�ɽ������褦�˽���
 *  2007/02/28                  morita-d    ����̾������̾�Τ�ɽ������褦���ѹ� 
 *  2007/03/09      ��˾9-1     kajioka-h   ���׾������ѹ���������������Ѥ��褦���ѹ�
 *  2007/03/13                  watanabe-k  �����ʬ�����򤷤�FC�Υǡ�����ɽ������褦�˽���
 *  2007/03/13                  watanabe-k��Ʊ�쾦�ʤ�ʣ�����顼�����Ū��ɽ��
 *  2007/05/01      �ʤ�        fukuda      ������ξ��֤���Ϥ���褦����
 *  2007/05/01      �ʤ�        fukuda      �ּ����װʳ���������������ǽ�˽���
 *  2007/05/15      �ʤ�        watanabe-k  ��ɼ��ȯ�Է�����Ĥ��褦�˽���
 *  2007/05/18      �ʤ�        watanabe-k  ľ����Υץ������������ե���Ȥ��ѹ�
 *  2007/05/22      �ʤ�        watanabe-k  ������������ˤ�ľ�������Ͽ�Ǥ���褦�˽���
 *  2007/06/10      �ʤ�        watanabe-k  Ŧ�פ�����ѹ������ƥ����Ȥ���ƥ������ꥢ���ѹ�
 *  2009/07/10      �ʤ�        aoyama-n    �߸˼�ʧ�ơ��֥��������̾��ά�Ρˤ�Ĥ��褦�˽���
 *  2009/09/04      �ʤ�        aoyama-n    �Ͱ���ǽ�ɲ�
 *  2009/09/10      �ʤ�        hashimoto-y ���ʤ��Ͱ����ڤӼ����ʬ�����ʡ��Ͱ������ֻ�ɽ���˽���
 *  2009/09/28      �ʤ�        hashimoto-y �����ʬ�����Ͱ������ѻ�
 *  2009/10/13      �ʤ�        hashimoto-y ���ʤ��Ͱ����ֻ�ɽ���ν���ϳ��
 *  2009/10/13                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *  2009/10/21                  kajioka-h   ��ץܥ��󲡲�����������ξ�����Ψ��ȤäƤ����Τ������ξ�����Ψ����Ѥ���褦����
 *  2009/10/21                  kajioka-h   ������Ψ�����׾�����������ʲ���
 *  2009/11/25                  hashimoto-y ��Ψ��TaxRate���饹�������
 *  2010/02/03                  aoyama-n    �������ʤξ�硢����ۤ�����ۤ����פ��Ƥ��ʤ��Զ�罤�� 
 *  2010/09/09                  aoyama-n    �ѹ�������claim_id����������ʤ��Զ�罤�� 
  *   2016/01/20                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */

$page_title = "�������";

//�Ķ�����ե����� env setting file
require_once("ENV_local.php");

//HTML_QuickForm����� create HTML_QuickForm
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB��³ connect to db
$db_con = Db_Connect();

// ���¥����å� authority check
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å����� message for no authorization to input/edit
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled disabled button
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// ���������SESSION�˥��å� set the page to return to in SESSION
/*****************************/
// GET��POST��̵����� if there is no GET,POST
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("sale");
}


/****************************/
//�����ѿ����� acquire external variable
/****************************/
$shop_id      = $_SESSION["client_id"];
$rank_cd      = $_SESSION["rank_cd"];
$e_staff_id   = $_SESSION["staff_id"];
$e_staff_name = $_SESSION["staff_name"];
$sale_id      = $_GET["sale_id"];     //���ID
$aord_id      = $_GET["aord_id"];     //����ID

// GET����ID�������������å� check the validity of the ID that was GET
if (Get_Id_Check_Db($db_con, $_GET["sale_id"], "sale_id", "t_sale_h", "num") == false && $_GET["sale_id"] != null){
    Header("Location: ../top.php");
    exit;
}
if (Get_Id_Check_Db($db_con, $_GET["aord_id"], "aord_id", "t_aorder_h", "num") == false && $_GET["aord_id"] != null){
    Header("Location: ../top.php");
    exit;
}

//���ID��hidden�ˤ���ݻ����� hold the Sales ID by hidden
if($_GET["sale_id"] != NULL){
    $set_id_data["hdn_sale_id"] = $sale_id;
    $form->setConstants($set_id_data);
}else{
    $sale_id = $_POST["hdn_sale_id"];
}
//����ID��hidden�ˤ���ݻ����� hold the sales order ID by hidden
if($_GET["aord_id"] != NULL){
    $set_id_data["hdn_aord_id"] = $aord_id;
    $form->setConstants($set_id_data);
}else{
    $aord_id = $_POST["hdn_aord_id"];
}

/*****************************/
// ��������������Ƥ�����ɼ��
// �����Υ⥸�塼��ǳ�������
// ���������Υڡ������ܽ�����page transition process when an already daily updated slip was attempted to be opened in module
/*****************************/
Get_Id_Check3($_GET["sale_id"]);
Get_Id_Check3($_GET["aord_id"]);
if ($_GET["sale_id"] != null && $_POST["form_sale_btn"] != "����ǧ���̤�" && $_POST["comp_button"] != "���OK"){
    $get_sale_id = (float)$_GET["sale_id"];
    $sql = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $get_sale_id;";
    $res = Db_Query($db_con, $sql);

    if(pg_fetch_result($res, 0, 0) == "t"){
        Header("Location: ./1-2-205.php?sale_id=$get_sale_id&slip_flg=true");
        exit;   
    }
}

/****************************/
//������� initial setting
/****************************/

#2009-11-25 hashimoto-y
//��Ψ���饹�����󥹥������� tax rate class create instance 
$tax_rate_obj = new TaxRate($shop_id);

//ɽ���Կ� display number of rows
if($_POST["max_row"] != null){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}
//�����褬���ꤵ��Ƥ��뤫 is the customer being assigned
if($_POST["hdn_client_id"] == null || $_POST["hdn_ware_id"] == null){
    $warning = "������Ƚв��Ҹ����򤷤Ƥ���������";
}else{
    $warning = null;
    $client_id    = $_POST["hdn_client_id"];
    $ware_id      = $_POST["hdn_ware_id"];
    $coax         = $_POST["hdn_coax"];
    $tax_franct   = $_POST["hdn_tax_franct"];
    $client_shop_id = $_POST["client_shop_id"];
    $client_name  = $_POST["form_client"]["name"];
}

//����ѹ�Ƚ�� determine the change in sales 
if($sale_id != NULL && $client_id == NULL){
    //�إå�������SQL
    $sql  = "SELECT ";
    $sql .= "    t_sale_h.sale_no,";
    $sql .= "    t_sale_h.aord_id,";
    $sql .= "    t_sale_h.client_id,";
/*
    $sql .= "    t_client.client_cd1,";
    $sql .= "    t_client.client_cd2,";
    $sql .= "    t_client.client_cname,";
*/
    $sql .= "    t_sale_h.client_cd1,";
    $sql .= "    t_sale_h.client_cd2,";
    $sql .= "    t_sale_h.client_cname,";
    $sql .= "    t_aorder_h.ord_time,";
    $sql .= "    t_aorder_h.arrival_day,";
    $sql .= "    t_sale_h.sale_day,";
    $sql .= "    t_sale_h.claim_day,";
    $sql .= "    t_sale_h.green_flg,";
    $sql .= "    t_sale_h.trans_id,";
    $sql .= "    t_sale_h.direct_id,";
    $sql .= "    t_sale_h.ware_id,";
    $sql .= "    t_sale_h.trade_id,";
    $sql .= "    t_sale_h.c_staff_id,";
    $sql .= "    t_sale_h.note,";
    $sql .= "    t_sale_h.aord_id,";
    $sql .= "    t_sale_h.ac_staff_id,";
    $sql .= "    t_client.royalty_rate, ";
    $sql .= "    t_client.rank_cd, ";
    $sql .= "    t_sale_h.enter_day, ";
    $sql .= "    t_sale_h.change_day ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h";
    $sql .= "    INNER JOIN t_client ON t_sale_h.client_id = t_client.client_id ";
    $sql .= "    LEFT JOIN t_aorder_h ON t_sale_h.aord_id = t_aorder_h.aord_id ";
    $sql .= "WHERE ";
    $sql .= "    t_sale_h.sale_id = $sale_id";
    $sql .= "    AND";
    $sql .= "    t_sale_h.shop_id = $shop_id";
    $sql .= "    AND";
    $sql .= "    t_sale_h.renew_flg = 'f';";

    $result = Db_Query($db_con, $sql);

    //GET�ǡ���Ƚ�� determine GET data
    Get_Id_Check($result);
    $h_data_list = Get_Data($result,2);

    //�ǡ�������SQL SQL that acquire DATA
    $sql  = "SELECT ";
    $sql .= "    t_goods.goods_id,";
    $sql .= "    t_goods.name_change,";
    $sql .= "    t_sale_d.goods_cd,";
    //$sql .= "    t_sale_d.goods_name,";
    $sql .= "    t_sale_d.official_goods_name,";
    $sql .= "    t_sale_d.num,";
    $sql .= "    t_sale_d.tax_div,";
    $sql .= "    t_sale_d.cost_price,";
    $sql .= "    t_sale_d.sale_price,";
    $sql .= "    t_sale_d.cost_amount,";
    $sql .= "    t_sale_d.sale_amount,";
    //����ID��������ϡ��������ɽ�� Display the received orders of units of product if there is a sales order ID
//  if($h_data_list[0][17] != NULL){
        $sql .= "   t_aorder_d.num, ";
//  }
    #2009-10-13_1 hashimoto-y
    #$sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num,";
    $sql .= "    CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num,";

    //aoyama-n 2009-09-04
    #$sql .= "    t_goods.royalty ";
    $sql .= "    t_goods.royalty,";
    $sql .= "    t_goods.discount_flg ";
    $sql .= "FROM ";
    $sql .= "    t_sale_d ";
    $sql .= "    INNER JOIN t_sale_h ON t_sale_h.sale_id = t_sale_d.sale_id ";
    $sql .= "    INNER JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id ";
//  if($h_data_list[0][17] != NULL){
        $sql .= "    LEFT JOIN t_aorder_d ON t_sale_d.aord_d_id = t_aorder_d.aord_d_id ";
//  }
    $sql .= "   LEFT JOIN ";
    $sql .= "   (SELECT";
    $sql .= "       goods_id,";
    $sql .= "       SUM(stock_num)AS stock_num";
    $sql .= "   FROM";
    $sql .= "       t_stock";
    $sql .= "   WHERE";
    $sql .= "       shop_id = $shop_id";
    $sql .= "       AND";
    $sql .= "       ware_id = ".$h_data_list[0][13];
    $sql .= "       GROUP BY t_stock.goods_id";
    $sql .= "   )AS t_stock";
    $sql .= "   ON t_sale_d.goods_id = t_stock.goods_id ";
    #2009-10-13_1 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id\n";

    $sql .= "WHERE ";
    $sql .= "    t_sale_h.sale_id = $sale_id ";
    $sql .= "AND ";
    $sql .= "    t_sale_h.shop_id = $shop_id ";
    #2009-10-13_1 hashimoto-y
    $sql .= "AND\n";
    $sql .= "    t_goods_info.shop_id = $shop_id ";

    $sql .= "ORDER BY t_sale_d.line;";

    $result = Db_Query($db_con, $sql);
    $data_list = Get_Data($result,2);

    //������ξ������� extract the information of the customer
    $sql  = "SELECT";
    $sql .= "   client_id,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
    //$sql .= "   attach_gid ";
    $sql .= "   shop_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$h_data_list[0][2];
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $client_list = Get_Data($result,2);

    /****************************/
    //�ե�������ͤ����� restore the value in form
    /****************************/
    $sale_money = NULL;                        //���ʤ������ sales amount of the product
    $tax_div    = NULL;                        //���Ƕ�ʬ tax classification

    if ($_POST["client_search_flg"] != true){
    //�إå������� restore header
    $update_goods_data["form_sale_no"]                 = $h_data_list[0][0];  //��ɼ�ֹ� slip number
    $update_goods_data["form_ord_no"]                  = $h_data_list[0][1];  //�����ֹ� order number

    $update_goods_data["form_client"]["cd1"]           = $h_data_list[0][3];  //�����襳���ɣ� sales order code 1
    $update_goods_data["form_client"]["cd2"]           = $h_data_list[0][4];  //�����襳���ɣ� sales order code 2
    $update_goods_data["form_client"]["name"]          = $h_data_list[0][5];  //������̾ name of the person who ordered

    //��������ǯ������ʬ���� separate the sales order date in to year months day 
    $ex_ord_day = explode('-',$h_data_list[0][6]);
    $update_goods_data["form_order_day"]["y"]          = $ex_ord_day[0];   //������ sales order date
    $update_goods_data["form_order_day"]["m"]          = $ex_ord_day[1];   
    $update_goods_data["form_order_day"]["d"]          = $ex_ord_day[2];   

    //�в�ͽ������ǯ������ʬ���� separate the scheduled shipment date in to year months day 
    $ex_arr_day = explode('-',$h_data_list[0][7]);
    $update_goods_data["form_arrival_day"]["y"]        = $ex_arr_day[0];   //�в�ͽ���� scheduled shipment date
    $update_goods_data["form_arrival_day"]["m"]        = $ex_arr_day[1];   
    $update_goods_data["form_arrival_day"]["d"]        = $ex_arr_day[2];   

    //���׾�����ǯ������ʬ���� separate the sales recorded date in to year months day 
    $ex_sale_day = explode('-',$h_data_list[0][8]);
    $update_goods_data["form_sale_day"]["y"]           = $ex_sale_day[0];  //���׾��� sales recorded date
    $update_goods_data["form_sale_day"]["m"]           = $ex_sale_day[1];   
    $update_goods_data["form_sale_day"]["d"]           = $ex_sale_day[2];   

    //��������ǯ������ʬ���� separate the invoice date in to year months day 
    $ex_claim_day = explode('-',$h_data_list[0][9]);
    $update_goods_data["form_claim_day"]["y"]          = $ex_claim_day[0];  //������ invoice date
    $update_goods_data["form_claim_day"]["m"]          = $ex_claim_day[1];   
    $update_goods_data["form_claim_day"]["d"]          = $ex_claim_day[2];   

    //�����å����դ��뤫Ƚ�� determine if there will be a check
    if($h_data_list[0][10]=='t'){
        $update_goods_data["form_trans_check"]         = $h_data_list[0][10];  //���꡼����� green designation
    }

    $update_goods_data["form_trans_select"]            = $h_data_list[0][11];  //�����ȼ� carrier 
    $update_goods_data["form_direct_select"]           = $h_data_list[0][12];  //ľ���� direct destination
    $update_goods_data["form_ware_select"]             = $h_data_list[0][13];  //�Ҹ� warehouse
    $update_goods_data["hdn_ware_id"]                  = $h_data_list[0][13];  //�Ҹ� warehouse
    $update_goods_data["trade_sale_select"]            = $h_data_list[0][14];  //�����ʬ trade classification
    $update_goods_data["form_cstaff_select"]           = $h_data_list[0][15];  //���ô���� assigned staff for sales
    $update_goods_data["form_note"]                    = $h_data_list[0][16];  //���� remarks
    $update_goods_data["form_staff_select"]            = $h_data_list[0][18];  //����ô���� sales order staff
    $update_goods_data["hdn_aord_id"]                  = $h_data_list[0][17];  //����ID sales order ID
    $aord_id                                           = $h_data_list[0][17];
    $update_goods_data["hdn_royalty_rate"]             = $h_data_list[0][19];  //�����ƥ� roylaty
    $update_goods_data["hdn_rank_cd"]                  = $h_data_list[0][20];  //�ܵҶ�ʬ customer classifcation
    $update_goods_data["hdn_sale_enter_day"]           = $h_data_list[0][21];  //��Ͽ�� registration date
    $update_goods_data["hdn_aord_change_day"]          = $h_data_list[0][22];  //�ѹ��� change date
    }

    //�ǡ������� restore date
    for($i=0;$i<count($data_list);$i++){
        $update_goods_data["hdn_goods_id"][$i]         = $data_list[$i][0];   //����ID product ID

        $update_goods_data["hdn_name_change"][$i]      = $data_list[$i][1];   //��̾�ѹ��ե饰 product name change flag
        $hdn_name_change[$i]                           = $data_list[$i][1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ��� to determine if the product name can be changed or not before POST

        $update_goods_data["form_goods_cd"][$i]        = $data_list[$i][2];   //����CD Product CD
        $update_goods_data["form_goods_name"][$i]      = $data_list[$i][3];   //����̾ product name
        if($h_data_list[0][17] != NULL){
            $update_goods_data["form_aorder_num"][$i]  = $data_list[$i][10];  //����� number of units ordered
        }
        $update_goods_data["form_stock_num"][$i]       = $data_list[$i][11];  //���߸˿� current inventory number
        $update_goods_data["hdn_royalty"][$i]          = $data_list[$i][12];  //�����ƥ� royalty
        $update_goods_data["form_sale_num"][$i]        = $data_list[$i][4];   //�вٿ� number of units shipped
        $update_goods_data["hdn_tax_div"][$i]          = $data_list[$i][5];   //���Ƕ�ʬ tax classifciation

        //����ñ�����������Ⱦ�������ʬ���� separate the cost per unit into integer and decimal
        $cost_price = explode('.', $data_list[$i][6]);
        $update_goods_data["form_cost_price"][$i]["i"] = $cost_price[0];     //����ñ�� cost per unit
        $update_goods_data["form_cost_price"][$i]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     
        $update_goods_data["form_cost_amount"][$i]     = number_format($data_list[$i][8]);  //������� total cost

        //���ñ�����������Ⱦ�������ʬ���� separate the selling price per unit to integer and decimal
        $sale_price = explode('.', $data_list[$i][7]);
        $update_goods_data["form_sale_price"][$i]["i"] = $sale_price[0];     //���ñ�� seeling price per unit
        $update_goods_data["form_sale_price"][$i]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';
        $update_goods_data["form_sale_amount"][$i]     = number_format($data_list[$i][9]);  //����� sales price

        $sale_money[]                                  = $data_list[$i][9];  //����۹�� total sales price
        $tax_div[]                                     = $data_list[$i][5];  //���Ƕ�ʬ tax classification
        //aoyama-n 2009-09-04
        $update_goods_data["hdn_discount_flg"][$i]     = $data_list[$i][13]; //�Ͱ��ե饰 discounted flag
    }

    //������������� restore the customer information
    $client_id      = $client_list[0][0];        //������ID customer ID
    $coax           = $client_list[0][1];        //�ݤ��ʬ�ʶ�ۡ�round up/down - amount
    $tax_franct     = $client_list[0][2];        //ü����ʬ�ʾ����ǡ� round up/down - tax
    //$attach_gid     = $client_list[0][3];        //��°���롼�� belonging group
    $client_shop_id = $client_list[0][3];        //������Υ���å�ID customer's shopID
    $warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
    //$update_goods_data["attach_gid"]          = $attach_gid;
    $update_goods_data["client_shop_id"]      = $client_shop_id;

/*
    //���ߤξ�����Ψ current tax rate
    $sql  = "SELECT ";
    $sql .= "    tax_rate_n ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_id = $shop_id;";
    $result = Db_Query($db_con, $sql); 
    $tax_num = pg_fetch_result($result, 0,0);
*/
	//2009-10-21 kajioka-h ������Ψ����
	#$tax_num = Get_TaxRate_Day($db_con, $shop_id, $client_id, $h_data_list[0][8]);

    #2009-11-25 hashimoto-y
    $tax_rate_obj->setTaxRateDay($h_data_list[0][8]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num,$client_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);

    //�ե�������ͥ��å� set the value to form
    $update_goods_data["form_sale_total"]      = $sale_money;
    $update_goods_data["form_sale_tax"]        = $tax_money;
    $update_goods_data["form_sale_money"]      = $st_money;
    $update_goods_data["sum_button_flg"]       = "";

    $form->setConstants($update_goods_data);

    //ɽ���Կ� displayed number of rows
    if($_POST["max_row"] != NULL){
        $max_row = $_POST["max_row"];
    }else{
        //����ǡ����ο� number of sales order data
        $max_row = count($data_list);
    }

//�������Ƚ�� determine sales input 
//}else if($aord_id != NULL && $aord_id != 0){
}else if($aord_id != NULL && $aord_id != 0 && $client_id == null){

    //��ư���֤���ɼ�ֹ���� acquire the auto number of slip number
    $sql  = "SELECT";
    $sql .= "   MAX(sale_no)";
    $sql .= " FROM";
    $sql .= "   t_sale_h";
    $sql .= " WHERE";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $sale_no = pg_fetch_result($result, 0 ,0);
    $sale_no = $sale_no +1;
    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

    //�إå�������SQL SQL that acquire the header
    $sql  = "SELECT ";
//  $sql .= "    t_aorder_h.ord_no,";
    $sql .= "    t_aorder_h.aord_id,";
    $sql .= "    t_aorder_h.client_id,";
/*
    $sql .= "    t_client.client_cd1,";
    $sql .= "    t_client.client_cd2,";
    $sql .= "    t_client.client_cname,";
*/
    $sql .= "    t_aorder_h.client_cd1,";
    $sql .= "    t_aorder_h.client_cd2,";
    $sql .= "    t_aorder_h.client_cname,";
    $sql .= "    t_aorder_h.ord_time,";
    $sql .= "    t_aorder_h.arrival_day,";
    $sql .= "    t_aorder_h.green_flg,";
    $sql .= "    t_aorder_h.trans_id,";
    $sql .= "    t_aorder_h.direct_id,";
    $sql .= "    t_aorder_h.ware_id,";
    $sql .= "    t_aorder_h.trade_id,";
    $sql .= "    t_aorder_h.c_staff_id, ";
    $sql .= "    t_client.royalty_rate, ";
    $sql .= "    t_aorder_h.enter_day, ";
    $sql .= "    t_aorder_h.change_day ";
    $sql .= "FROM ";
    $sql .= "    t_aorder_h";
    $sql .= "    INNER JOIN t_client ON t_aorder_h.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= "    t_aorder_h.aord_id = $aord_id ";
    $sql .= "AND ";
    $sql .= "    t_aorder_h.shop_id = $shop_id;";

    $result = Db_Query($db_con, $sql);
    //GET�ǡ���Ƚ�� determine the GET data
    Get_Id_Check($result);
    $h_data_list = Get_Data($result,2);

    //�ǡ�������SQL SQL that acquire data
    $sql  = "SELECT";
    $sql .= "   t_goods.goods_id,";
    $sql .= "   t_goods.goods_cd,";
    //$sql .= "   t_aorder_d.goods_name,";
    $sql .= "   t_aorder_d.official_goods_name,";
    $sql .= "   t_aorder_d.num,";
    $sql .= "   t_aorder_d.tax_div,";
    $sql .= "   t_aorder_d.cost_price,";
    $sql .= "   t_aorder_d.sale_price,";
    $sql .= "   t_aorder_d.cost_amount,";
    $sql .= "   t_aorder_d.sale_amount,";
    #2009-10-13_1 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num, ";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num, ";

    $sql .= "   t_goods.royalty,";
    //aoyama-n 2009-09-04
    #$sql .= "   t_goods.name_change";
    $sql .= "   t_goods.name_change,";
    $sql .= "   t_goods.discount_flg";
    $sql .= " FROM";
    $sql .= "   t_aorder_d ";

    $sql .= "   INNER JOIN  t_aorder_h ON t_aorder_d.aord_id = t_aorder_h.aord_id";
    $sql .= "   INNER JOIN  t_goods ON t_aorder_d.goods_id = t_goods.goods_id";

    $sql .= "   LEFT JOIN ";
    $sql .= "   (SELECT";
    $sql .= "       goods_id,";
    $sql .= "       SUM(stock_num)AS stock_num";
    $sql .= "   FROM";
    $sql .= "       t_stock";
    $sql .= "   WHERE";
    $sql .= "       shop_id = $shop_id";
    $sql .= "       AND";
    $sql .= "       ware_id = ".$h_data_list[0][10];
    $sql .= "       GROUP BY t_stock.goods_id";
    $sql .= "   )AS t_stock";
    $sql .= "   ON t_aorder_d.goods_id = t_stock.goods_id ";
    #2009-10-13_1 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

    $sql .= " WHERE ";
    $sql .= "       t_aorder_h.aord_id = $aord_id ";
    $sql .= " AND ";
    $sql .= "       t_aorder_h.shop_id = $shop_id ";
    #2009-10-13_1 hashimoto-y
    $sql .= " AND\n";
    $sql .= "       t_goods_info.shop_id = $shop_id ";

    $sql .= " ORDER BY t_aorder_d.line;";

    $result = Db_Query($db_con, $sql);
    $data_list = Get_Data($result,2);

    //������ξ������� extract the info of the customer
    $sql  = "SELECT";
    $sql .= "   client_id,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
    //$sql .= "   attach_gid ";
    $sql .= "   shop_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$h_data_list[0][1];
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $client_list = Get_Data($result);

    /****************************/
    //�ե�������ͤ����� restore the value to form
    /****************************/
    $sale_money = NULL;                        //���ʤ������ selling price of a product
    $tax_div    = NULL;                        //���Ƕ�ʬ tax classification

    //�إå������� restore header
    $update_goods_data["form_sale_no"]                 = $sale_no;            //��ɼ�ֹ� slip number
    $update_goods_data["form_ord_no"]                  = $h_data_list[0][0];  //�����ֹ� sales order number

    $update_goods_data["form_client"]["cd1"]           = $h_data_list[0][2];  //�����襳���ɣ� customer code 1
    $update_goods_data["form_client"]["cd2"]           = $h_data_list[0][3];  //�����襳���ɣ� customer code 2
    $update_goods_data["form_client"]["name"]          = $h_data_list[0][4];  //������̾ customer name

    //��������ǯ������ʬ���� separate the sales order date into year mm and day
    $ex_ord_day = explode('-',$h_data_list[0][5]);
    $update_goods_data["form_order_day"]["y"]          = $ex_ord_day[0];      //������ sales order date
    $update_goods_data["form_order_day"]["m"]          = $ex_ord_day[1];   
    $update_goods_data["form_order_day"]["d"]          = $ex_ord_day[2];   

    //�в�ͽ������ǯ������ʬ���� separate the scheduled shispment date into year mm and day 
    $ex_arr_day = explode('-',$h_data_list[0][6]);
    $update_goods_data["form_arrival_day"]["y"]        = $ex_arr_day[0];      //�в�ͽ���� scheduled shipment date
    $update_goods_data["form_arrival_day"]["m"]        = $ex_arr_day[1];   
    $update_goods_data["form_arrival_day"]["d"]        = $ex_arr_day[2];   

    //���׾�����ǯ������ʬ���� separate the sales recorded date into yyyy mm dd
    $update_goods_data["form_sale_day"]["y"]           = date('Y');  //���׾��� sales recorded date
    $update_goods_data["form_sale_day"]["m"]           = date('m');   
    $update_goods_data["form_sale_day"]["d"]           = date('d');   

    //��������ǯ������ʬ���� separate the invoice date into yyyy mm dd
    $update_goods_data["form_claim_day"]["y"]          = date('Y');  //������ invoice date
    $update_goods_data["form_claim_day"]["m"]          = date('m');   
    $update_goods_data["form_claim_day"]["d"]          = date('d');   

    $trans_check                                       = $h_data_list[0][7];  //���꡼����� green desgination
    $update_goods_data["form_trans_select"]            = $h_data_list[0][8];  //�����ȼ� carrier

    $update_goods_data["form_direct_select"]           = $h_data_list[0][9];  //ľ���� direct destination
    $update_goods_data["form_ware_select"]             = $h_data_list[0][10];  //�Ҹ� warehouse
    $update_goods_data["hdn_ware_id"]                  = $h_data_list[0][10];   //�Ҹˡ�hidden�ѡ� warehouse for hidden
    $update_goods_data["trade_sale_select"]            = $h_data_list[0][11]; //�����ʬ trade classifcation
    $update_goods_data["form_staff_select"]            = $h_data_list[0][12]; //ô���� assigned staff

    $update_goods_data["hdn_royalty_rate"]                  = $h_data_list[0][13]; //�����ƥ� royalty
    $update_goods_data["hdn_aord_enter_day"]            = $h_data_list[0][14]; //��Ͽ�� registration date
    $update_goods_data["hdn_aord_change_day"]          = $h_data_list[0][15]; //�ѹ��� change date

    //�ǡ������� resstore data
    for($i=0;$i<count($data_list);$i++){
        $update_goods_data["hdn_goods_id"][$i]         = $data_list[$i][0];   //����ID product ID

        $update_goods_data["form_goods_cd"][$i]        = $data_list[$i][1];   //����CD product CD
        $update_goods_data["form_goods_name"][$i]      = $data_list[$i][2];   //����̾ product name

        $update_goods_data["form_aorder_num"][$i]      = $data_list[$i][3];   //����� number of units ordered 
        $update_goods_data["form_stock_num"][$i]       = $data_list[$i][9];   //���߸˿� current inventory no.
        $update_goods_data["form_sale_num"][$i]        = $data_list[$i][3];   //�вٿ� shipped no of units of prod
        $update_goods_data["hdn_tax_div"][$i]          = $data_list[$i][4];   //���Ƕ�ʬ tax class

        //����ñ�����������Ⱦ�������ʬ���� separate the cost price per unit to integer and decimal
        $cost_price = explode('.', $data_list[$i][5]);
        $update_goods_data["form_cost_price"][$i]["i"] = $cost_price[0];     //����ñ�� cost price per unit
        $update_goods_data["form_cost_price"][$i]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     
        $update_goods_data["form_cost_amount"][$i]     = number_format($data_list[$i][7]);  //������� total cost

        //���ñ�����������Ⱦ�������ʬ���� separate the selling price per unit to integer and decimal
        $sale_price = explode('.', $data_list[$i][6]);
        $update_goods_data["form_sale_price"][$i]["i"] = $sale_price[0];     //���ñ�� seeling price per unit
        $update_goods_data["form_sale_price"][$i]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';
        $update_goods_data["form_sale_amount"][$i]     = number_format($data_list[$i][8]);  //����� sales price

        $update_goods_data["hdn_royalty"][$i]          = $data_list[$i][10]; //�����ƥ� royalty

        $sale_money[]                                  = $data_list[$i][8];  //����۹�� total sales price
        $tax_div[]                                     = $data_list[$i][4];  //���Ƕ�ʬ tax class

        $update_goods_data["hdn_name_change"][$i]      = $data_list[$i][11];   //��̾�ѹ��ե饰 product name change flag
        $hdn_name_change[$i]                           = $data_list[$i][11];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ��� to determine if the product name is editable or not before POST
        //aoyama-n 2009-09-04
        $update_goods_data["hdn_discount_flg"][$i]     = $data_list[$i][12];   //�Ͱ��ե饰 discounted flag
    }

    //������������� restore customer info
    $client_id      = $client_list[0][0];        //������ID customer ID
    $coax           = $client_list[0][1];        //�ݤ��ʬ�ʶ�ۡ� round up/down - amount
    $tax_franct     = $client_list[0][2];        //ü����ʬ�ʾ����ǡ�round up/down - tax
    //$attach_gid     = $client_list[0][3];        //��°���롼�� belogning group
    $client_shop_id = $client_list[0][3];        //������Υ���å�ID custoemr shop ID
    //���ߤξ�����Ψ curret tax rate
    $sql  = "SELECT ";
    $sql .= "    tax_rate_n ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_id = $shop_id;";
    $result = Db_Query($db_con, $sql); 
    $tax_num = pg_fetch_result($result, 0,0);
*/
	//2009-10-21 kajioka-h ������Ψ���� acquire tax rate
	#$tax_num = Get_TaxRate_Day($db_con, $shop_id, $client_id, date("Y-m-d"));

    #2009-11-25 hashimoto-y
    $tax_rate_obj->setTaxRateDay(date("Y-m-d"));
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num,$client_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
    //$update_goods_data["attach_gid"]          = $attach_gid;
    $update_goods_data["client_shop_id"]      = $client_shop_id;
    $update_goods_data["form_cstaff_select"] = $e_staff_id;

/*
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);

    //�ե�������ͥ��å� set the value to form
    $update_goods_data["form_sale_total"]      = $sale_money;
    $update_goods_data["form_sale_tax"]        = $tax_money;
    $update_goods_data["form_sale_money"]      = $st_money;
    $update_goods_data["sum_button_flg"]       = "";

    $form->setConstants($update_goods_data);
    //����ǡ����ο� number of sales order data
    $max_row = count($data_list);

}else{
    //��ư���֤���ɼ�ֹ���� acquire the autonumber of slip number
    $sql  = "SELECT";
    $sql .= "   MAX(sale_no)";
    $sql .= " FROM";
    $sql .= "   t_sale_h";
    $sql .= " WHERE";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $sale_no = pg_fetch_result($result, 0 ,0);
    $sale_no = $sale_no +1;
    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

    $def_data["form_sale_no"] = $sale_no;

    //ô���� assigned staff
    $def_data["form_cstaff_select"] = $e_staff_id;
//  $def_data["form_staff_select"] = $e_staff_id;
    //�����ʬ
    $def_data["trade_sale_select"] = 11;

    //���׾��� sales recorded date
    $def_data["form_sale_day"]["y"] = date("Y");
    $def_data["form_sale_day"]["m"] = date("m");
    $def_data["form_sale_day"]["d"] = date("d");
    //������ invoice date
    $def_data["form_claim_day"]["y"] = date("Y"); 
    $def_data["form_claim_day"]["m"] = date("m"); 
    $def_data["form_claim_day"]["d"] = date("d"); 

    //�Ҹ� warehouse
    $sql  = "SELECT";
    $sql .= "   ware_id ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $def_ware_id = pg_fetch_result($result,0,0);

    $def_data["form_ware_select"] = $def_ware_id;
    $def_data["hdn_ware_id"]      = $def_ware_id;

    $form->setDefaults($def_data);

    //ɽ���Կ� number of row displayed
    if($_POST["max_row"] != NULL){
        $max_row = $_POST["max_row"];
    }else{
        $max_row = 5;
    }
}

//���ɽ�������ѹ� change the initial display position
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//����Կ���number of delete rows
$del_history[] = NULL; 

/****************************/
//�Կ��ɲý��� process for addign rows
/****************************/
if($_POST["add_row_flg"]==true){
    if($_POST["max_row"] == NULL){
        //����ͤ�POST��̵���١�sicne there is no POST in initial value
        $max_row = 10;
    }else{
        //����Ԥˡ��ܣ����� +1 to the max row
        $max_row = $_POST["max_row"]+5;
    }
    //�Կ��ɲåե饰�򥯥ꥢ clear the add row flag
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//�Ժ������ process for deleting the row
/****************************/
if($_POST["del_row"] != ""){

    //����ꥹ�Ȥ���� acquire the delete list
    $del_row = $_POST["del_row"];

    //������������ˤ��롣array the delete hisotry
    $del_history = explode(",", $del_row);
    //��������Կ� number of row deleted 
    $del_num     = count($del_history)-1;
}

//***************************/
//����Կ���hidden�˥��å� set the max row number to hidden
/****************************/
$max_row_data["max_row"] = $max_row;
$form->setConstants($max_row_data);

//***************************/
//���꡼���������å����� process for green desgination
/****************************/
//�����å��ξ��ϡ������ȼԤΥץ��������ͤ��ѹ����� change the value of the pulldown for carrier if there is a check
if($_POST["trans_check_flg"] == true){
    $where  = " WHERE ";
    $where .= "    shop_id = $shop_id";
    $where .= " AND";
    $where .= "    green_trans = 't'";

    //����� initialize
    $trans_data["trans_check_flg"]     = "";
    $trans_data["show_button_flg"]     = "";        //ɽ���ܥ��� display button
    $trans_data["form_ord_no"]         = "";        //�����ֹ� sales order number
    $form->setConstants($trans_data);
}else{
    $where = "";
}

/****************************/
//���ʺ��� create component 
/****************************/
//��ɼ�ֹ� slip number 
$form->addElement(
    "text","form_sale_no","",
    "style=\"color : #585858; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//�����ֹ� sales order number 
//���Ȳ���ɼȯ�Ԥ������ܤ���������ID��̵�� there is no sales order ID transitioned from the sales inquiry and slip issue page
$select_value[] = null;
$sql  = "SELECT\n";
$sql .= "    t_aorder_h.aord_id,\n";
$sql .= "    t_aorder_h.ord_no\n";
$sql .= " FROM\n";
$sql .= "    t_aorder_h\n";
$sql .= " WHERE\n";
$sql .= "    t_aorder_h.shop_id = $shop_id \n";
$sql .= " AND \n";
$sql .= "    t_aorder_h.ps_stat < '3' \n";
//$sql .= " AND \n";
//$sql .= "    (t_aorder_h.check_flg = 't' OR t_aorder_h.fc_ord_id IS NOT NULL) \n";
$sql .= " ORDER BY t_aorder_h.ord_no\n";
$sql .= ";\n ";

$result = Db_Query($db_con, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $ord_id = pg_fetch_result($result,$i,0);
    $ord_no = pg_fetch_result($result,$i,1);
    $select_value[$ord_id] = $ord_no;
}
$freeze = $form->addElement("select","form_ord_no","",$select_value, $g_form_option_select);

if($sale_id != NULL && $aord_id != NULL){
    $freeze->freeze();
}

//������ sales oreder date
$form_order_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"color : #585858;$g_form_style
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_order_day[] = $form->createElement("static","","","-");
$form_order_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"color : #585858;$g_form_style
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_order_day[] = $form->createElement("static","","","-");
$form_order_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"color : #585858;$g_form_style
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form->addGroup( $form_order_day,"form_order_day","");

//�в�ͽ���� scheduled shipment date
$form_arrival_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"color : #585858;$g_form_style
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_arrival_day[] = $form->createElement("static","","","-");
$form_arrival_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"color : #585858;$g_form_style
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_arrival_day[] = $form->createElement("static","","","-");
$form_arrival_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"color : #585858;$g_form_style
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form->addGroup( $form_arrival_day,"form_arrival_day","");

//���׾��� sales recorded date
$text = NULL;
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_sale_day[y]','form_sale_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_sale_day[y]','form_sale_day[m]','form_sale_day[d]')\" onBlur=\"blurForm(this)\" onChange=\"Claim_Day_Change('form_sale_day', 'form_claim_day')\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_sale_day[m]','form_sale_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_sale_day[y]','form_sale_day[m]','form_sale_day[d]')\" onBlur=\"blurForm(this)\" onChange=\"Claim_Day_Change('form_sale_day', 'form_claim_day')\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_sale_day[y]','form_sale_day[m]','form_sale_day[d]')\" onBlur=\"blurForm(this)\" onChange=\"Claim_Day_Change('form_sale_day', 'form_claim_day')\"");
$form->addGroup( $text,"form_sale_day","form_sale_day");

//������ invoice date
$text = NULL;
$text[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" style=\"$g_form_style\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_claim_day[y]','form_claim_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_claim_day[y]','form_claim_day[m]','form_claim_day[d]')\" onBlur=\"blurForm(this)\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" style=\"$g_form_style\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_claim_day[m]','form_claim_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_claim_day[y]','form_claim_day[m]','form_claim_day[d]')\" onBlur=\"blurForm(this)\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" style=\"$g_form_style\" maxLength=\"2\" onFocus=\"onForm_today(this,this.form,'form_claim_day[y]','form_claim_day[m]','form_claim_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $text,"form_claim_day","form_claim_day");

//�����襳���� customer code
//����Ȳ񡦼���Ĥ������ܤ�����硢�ѹ��Բ� if transitioned from order inqiury or backlog list then cannot be edited
if($aord_id == NULL){
//if($sale_id == NULL){
    //�ѹ��� can be edited
    $form_client[] =& $form->createElement(
            "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
            );
    $form_client[] =& $form->createElement(
            "static","","","-"
            );
    $form_client[] =& $form->createElement(
            "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onChange=\"javascript:Button_Submit('client_search_flg','#','true', this)\"".$g_form_option."\""
            );
    $form_client[] =& $form->createElement("text","name","�ƥ����ȥե�����","size=\"34\" $g_text_readonly");
    $form->addGroup( $form_client, "form_client", "");
}else{
    //�ѹ��Բ� cannot be edited
    $form_client[] =& $form->createElement(
            "text","cd1","","size=\"7\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: left\" readonly\""
            );
    $form_client[] =& $form->createElement(
            "static","","","-"
            );
    $form_client[] =& $form->createElement(
            "text","cd2","","size=\"7\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: left\" readonly\""
            );
    $form_client[] =& $form->createElement("text","name","�ƥ����ȥե�����","size=\"34\" $g_text_readonly");
    $form->addGroup( $form_client, "form_client", "");
}
//��ȴ��� amount with no tax
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//������ tax
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//�ǹ���� amount with tax
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//���꡼����� green designation
if($aord_id == NULL){
    $form->addElement('checkbox', 'form_trans_check', '���꡼�����', '<b>���꡼�����</b>��',"onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");
}else{
    //���꡼�����Ƚ�� determine if green designation is checked
    if($trans_check == 't'){
        $str = "���꡼����ꤢ�ꡡ";
    }
    $form->addElement("static","form_trans_check","","$str");
}

//�����ȼ� carrier
$select_value = Select_Get($db_con,'trans',$where);
if($aord_id == NULL){
    $form->addElement('select', 'form_trans_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
}else{
    $aord_freeze[] = $form->addElement('select', 'form_trans_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
}

//ľ���� direct destination
if($aord_id == NULL){
    $select_value = Select_Get($db_con,'direct');
    $form->addElement('select', 'form_direct_select', '���쥯�ȥܥå���', $select_value,"Class=\"Tohaba\"".$g_form_option_select);
}else{
    //�����餪��������������åפΥǡ�����ꥹ�ȥ��åפ��� listup all shops' data if it was a sales from the sales order��
    $select_value = Select_Get($db_con,'direct',"WHERE t_direct.shop_id IS NOT NULL");
    $aord_freeze[] = $form->addElement('select', 'form_direct_select', '���쥯�ȥܥå���', $select_value,"Class=\"Tohaba\"".$g_form_option_select);
}

//�Ҹ� warehouse
$select_value = Select_Get($db_con,'ware');
if($aord_id == NULL){
    $form->addElement('select', 'form_ware_select', '���쥯�ȥܥå���', $select_value,"onkeydown=\"chgKeycode();\" onChange=\"javascript:Button_Submit('stock_search_flg','#','true', this);window.focus();\"");
}else{
    $aord_freeze[] = $form->addElement('select', 'form_ware_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
}

//�����ʬ trade classification
if($aord_id == NULL){
    //���Ȳ񡦰��ȯ�Ԥ������� transitioned from sales inquiry and issue at once
    $select_value = Select_Get($db_con,'trade_sale');
}else{
    //����ġ�����Ȳ񤫤����� transitioned from order inquiry backlog list
    $select_value = Select_Get($db_con,'trade_sale_aord');
}
$trade_form=$form->addElement('select', 'trade_sale_select', null, null, $g_form_option_select);

//���ʡ��Ͱ����ο����ѹ� change the color of discounted and return product
$select_value_key = array_keys($select_value);
for($i = 0; $i < count($select_value); $i++){
    if($select_value_key[$i] == 13 || $select_value_key[$i] == 14 || $select_value_key[$i] == 63 || $select_value_key[$i] == 64){
        $color= "style=color:red";
    }else{
        $color="";
    }
    #2009-09-28 hashimoto-y
    #�����ʬ�����Ͱ�����ɽ�����ʤ����ڤ��ᤷ�ξ��ˤϤ�����ifʸ�򳰤��� do not display the discounted from the trade classification.��take out this if statement if you are cutting back
    if( $select_value_key[$i] != 14 && $select_value_key[$i] != 64){
        #echo "$select_value_key[$i]<br>";
        $trade_form->addOption($select_value[$select_value_key[$i]], $select_value_key[$i],$color);
    }
}

if($sale_id != null && $aord_id != null){
    $trade_form->freeze();
}

//����ô����ô���� assigned staff for the sales order
if($aord_id != NULL || $sale_id != NULL){
    $select_value = Select_Get($db_con,'staff',null,true);
}
$aord_freeze[] = $form->addElement('select', 'form_staff_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//���ô����ô���� staff for sales
$select_value = Select_Get($db_con,'staff',null,true);
$form->addElement('select', 'form_cstaff_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//���� remarks
//$form->addElement("text","form_note","","size=\"20\" maxLength=\"20\" $g_form_option");

$form->addElement("textarea","form_note",""," rows=\"2\" cols=\"75\" $g_form_option_area");
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note","����60ʸ������Ǥ���","mb_maxlength","60");


//���׾������������������ʬ�����͡��ʳ��������Բ� sales recorded date, ivoice date, trade classification, remarks are the only one editable
for($i = 0; $i < count($aord_freeze); $i++){
    $aord_freeze[$i]->freeze();
}

/*
//�����ɼ���ȯ�� sales slip issue all at once
$form->addElement("button","sale_button","�����ɼ���ȯ��","onClick=\"javascript:Referer('1-2-202.php')\"");
//���ϡ��ѹ� input/edit
$form->addElement("button","new_button","���ϡ��ѹ�",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�Ȳ� inqiury
$form->addElement("button","change_button","�ȡ���","onClick=\"javascript:Referer('1-2-203.php')\"");
*/
// �إå�����󥯥ܥ��� header link button
$form->addElement("button", "203_button", "�Ȳ��ѹ�", "onClick=\"javascript: Referer('1-2-203.php');\"");
$form->addElement("button", "201_button", "������", "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

//hidden
$form->addElement("hidden", "hdn_sale_id");         //���ID sales ID
$form->addElement("hidden", "hdn_aord_id");         //����ID sales order ID
$form->addElement("hidden", "hdn_client_id");       //������ID customer ID
$form->addElement("hidden", "hdn_ware_id");         //�в��Ҹ�ID shipped warehouse ID
$form->addElement("hidden", "hdn_rank_cd");         //�ܵҶ�ʬ������ customer classification code
$form->addElement("hidden", "client_shop_id");      //������Υ���å�ID customer shop ID
$form->addElement("hidden", "client_search_flg");   //�����襳�������ϥե饰 customer code input flag
$form->addElement("hidden", "hdn_coax");            //�ݤ��ʬ round up or down classification
$form->addElement("hidden", "hdn_tax_franct");      //ü����ʬ round up or down classification
$form->addElement("hidden", "del_row");             //����� deleted row
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰 additional row 
$form->addElement("hidden", "max_row");             //����Կ� max row number 
$form->addElement("hidden", "goods_search_row");    //���ʥ��������Ϲ� product code input row
$form->addElement("hidden", "sum_button_flg");      //��ץܥ��󲡲��ե饰 flag when total button pressed
$form->addElement("hidden", "trans_check_flg");     //���꡼���������å��ե饰 flag for green designation check box
$form->addElement("hidden", "show_button_flg");     //ɽ���ܥ��󲡲�Ƚ�� determine if the display button is pressed 
$form->addElement("hidden", "stock_search_flg");    //���߸Ŀ������ե饰 current inventory number search flag
$form->addElement("hidden", "hdn_royalty_rate");    //�����ƥ� royalty
$form->addElement("hidden", "hdn_sale_enter_day");  //�����Ͽ�� sales registered date
$form->addElement("hidden", "hdn_aord_enter_day");  //�����Ͽ�� sales registered date
$form->addElement("hidden", "hdn_aord_change_day");  //�����Ͽ�� sales registered date

#2009-09-10 hashimoto-y
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $form->addElement("hidden","hdn_discount_flg[$i]");
    }
}


/****************************/
//�����襳�������Ͻ��� process for inputting customer code
/****************************/
if($_POST["client_search_flg"] == true){
    $client_cd1         = $_POST["form_client"]["cd1"];       //�����襳����1 customer code1
    $client_cd2         = $_POST["form_client"]["cd2"];       //�����襳����2 customer code2

    //������ξ������� extract the info of customer
    $sql  = "SELECT";
    $sql .= "   client_id,";
    $sql .= "   shop_id,";
    $sql .= "   client_cname,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
    $sql .= "   rank_cd, ";
    $sql .= "   royalty_rate,";
    $sql .= "   client_cd1, ";
    $sql .= "   client_cd2, ";
    $sql .= "   trade_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '3' ";
//    $sql .= "   AND";
//    $sql .= "   state = '1' ";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
    //�����ǡ��������� there is a corresponding date
    if($num == 1){
        $client_id      = pg_fetch_result($result, 0,0);        //������ID customer ID
        $client_shop_id     = pg_fetch_result($result, 0,1);    //������Υ���å�ID shop Id of a customer
        $client_name    = pg_fetch_result($result, 0,2);        //������̾ customer name
        $coax           = pg_fetch_result($result, 0,3);        //�ݤ��ʬ�ʾ��ʡ� round up or down - product
        $tax_franct     = pg_fetch_result($result, 0,4);        //ü����ʬ�ʾ����ǡ� round up or down - tax
        $rank_cd        = pg_fetch_result($result, 0,5);        //�ܵҶ�ʬ������ custoemr classification code
        $royalty_rate   = pg_fetch_result($result, 0,6);        //�����ƥ� royalty

        //���������ǡ�����ե�����˥��å� set the data acquire to form
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = $client_id;
        $client_data["client_shop_id"]      = $client_shop_id;
        $client_data["form_client"]["name"] = $client_name;
        $client_data["hdn_coax"]            = $coax;
        $client_data["hdn_tax_franct"]      = $tax_franct;
        $client_data["hdn_rank_cd"]         = $rank_cd;
        $client_data["hdn_royalty_rate"]    = $royalty_rate;
        $client_data["form_client"]["cd1"]    = pg_fetch_result($result, 0,7);
        $client_data["form_client"]["cd2"]    = pg_fetch_result($result, 0,8);
        $client_data["trade_sale_select"]   = pg_fetch_result($result, 0, 9);

        //�в��Ҹˤ����򤵤�Ƥ����顢�ٹ���ɽ�� do not display warning if the shipping warehouse is selected
        if($_POST["form_ware_select"] != NULL){
            $warning = null;
        }

    }else{
        $warning = "������Ƚв��Ҹ����򤷤Ƥ���������";
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = "";
        $client_data["client_shop_id"]      = "";
        $client_data["form_client"]["name"] = "";
        $client_data["hdn_coax"]            = "";
        $client_data["hdn_tax_franct"]      = "";
        $client_data["hdn_rank_cd"]         = "";
        $client_data["hdn_royalty_rate"]    = "";
        $client_id = null;
    }

    //�������Ϥ��줿�ͤ����� initialize the value inputted before
    for($i = 0; $i < $max_row; $i++){
        //����ǡ��� sales order data
        $client_data["hdn_goods_id"][$i]           = "";
        $client_data["form_stock_num"][$i]         = "";
        $client_data["hdn_tax_div"][$i]            = "";
        $client_data["form_goods_cd"][$i]          = "";
        $client_data["form_goods_name"][$i]        = "";
        $client_data["form_sale_num"][$i]          = "";
        $client_data["form_cost_price"]["$i"]["i"] = "";
        $client_data["form_cost_price"]["$i"]["d"] = "";
        $client_data["form_cost_amount"][$i]       = "";
        $client_data["form_sale_price"]["$i"]["i"] = "";
        $client_data["form_sale_price"]["$i"]["d"] = "";
        $client_data["form_sale_amount"][$i]       = "";
        $client_data["form_aorder_num"][$i]        = "";
        $client_data["hdn_royalty"][$i]            = "";
        //aoyama-n 2009-09-04
        $client_data["hdn_discount_flg"][$i]       = "";
    }
    $client_data["del_row"]             = "";        //������ֹ� delete row number 
    $client_data["max_row"]             = "";        //�Կ� row number 
    $client_data["form_sale_total"]     = "";        //��ȴ��� amount without tax
    $client_data["form_sale_tax"]       = "";        //������ tax
    $client_data["form_sale_money"]     = "";        //�ǹ���� amt with tax
    $client_data["show_button_flg"]     = "";        //ɽ���ܥ��� display button
    $client_data["form_ord_no"]         = "";        //�����ֹ� sales order number
    $form->setConstants($client_data);
}

/****************************/
//�в��Ҹ����� input shipping warehouse
/****************************/
if($_POST["stock_search_flg"] == true){
    
    $ware_id = $_POST["form_ware_select"];   //�в��Ҹ� shipping warehouse
  
    //���ʤ����İʾ����򤵤�Ƥ���н������� start the process if one or more product is selected
    if($ware_id != NULL){

        for($i = 0; $i < $max_row; $i++){

            $goods_id = $_POST["hdn_goods_id"][$i];

            if($goods_id != NULL){            
                $sql  = "SELECT";
                $sql .= "   stock_num";
                $sql .= " FROM";
                $sql .= "   t_stock";
                $sql .= " WHERE";
                $sql .= "   shop_id = $shop_id";
                $sql .= "   AND";
                $sql .= "   ware_id = $ware_id";
                $sql .= "   AND";
                $sql .= "   goods_id = $goods_id";
                $sql .= ";";

                $result         = Db_Query($db_con, $sql);
                $stock_data_num = pg_num_rows($result);

                if($stock_data_num != 0){
                    $stock_data = pg_fetch_result($result,0,0);
                }

                $set_stock_data["form_stock_num"][$i] = ($stock_data != NULL)? $stock_data : 0;     //���߸Ŀ� ccuren inv number
            }

        }

        //�����褬���򤵤�Ƥ����顢�ٹ���ɽ�� do not display warning if customer is selected
        if($_POST["hdn_client_id"] != NULL){
            $warning = null;
        }
    }else{
        $warning = "������Ƚв��Ҹˤ����򤷤Ƥ���������";
    }
    
    $set_stock_data["hdn_ware_id"]         = $ware_id;  
    $set_stock_data["stock_search_flg"]    = "";
    $set_stock_data["show_button_flg"]     = "";        //ɽ���ܥ��� display button
    $set_stock_data["form_ord_no"]         = "";        //ȯ���ֹ� purhcase order number
    $form->setConstants($set_stock_data);

}

/****************************/
//��ץܥ��󲡲����� process when total button is pressed
/****************************/
if($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["form_sale_btn"] == "����ǧ���̤�"){

    //����ꥹ�Ȥ���� acquire the deleted list
    $del_row = $_POST["del_row"];
    //������������ˤ��롣 array the delete history
    $del_history = explode(",", $del_row); 

    $sale_data  = $_POST["form_sale_amount"];  //����� sales amount
    $sale_money = NULL;                        //���ʤ������ product's sales amount 
    $tax_div    = NULL;                        //���Ƕ�ʬ tax classification

    //����ۤι���ͷ׻� compute the total amount of sales
    for($i=0;$i<$max_row;$i++){
        if($sale_data[$i] != "" && !in_array("$i", $del_history)){
            $sale_money[] = $sale_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
        }
    }

/*
    //���ߤξ�����Ψ current tax rate
    $sql  = "SELECT ";
    $sql .= "    tax_rate_n ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    //$sql .= "    client_id = $client_id;";
	$sql .= "    client_id = $shop_id;";	//2009/10/21 kajioka-h ��ʬ�ξ�����Ψ��Ȥ� use your own tax rate
    $result = Db_Query($db_con, $sql); 
    $tax_num = pg_fetch_result($result, 0,0);
*/
	//2009-10-21 kajioka-h ������Ψ���� acquire the tax rate
	#$tax_num = Get_TaxRate_Day($db_con, $shop_id, $client_id, $_POST["form_sale_day"]["y"]."-".$_POST["form_sale_day"]["m"]."-".$_POST["form_sale_day"]["d"]);


    #2009-11-25 hashimoto-y
    $tax_rate_obj->setTaxRateDay($_POST["form_sale_day"]["y"]."-".$_POST["form_sale_day"]["m"]."-".$_POST["form_sale_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num,$client_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);

    if($_POST["sum_button_flg"] == true){
        //���ɽ�������ѹ� change the initial display positon
        $height = $max_row * 30;
        $form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";
    }

    //�ե�������ͥ��å� set the value to form
    $money_data["form_sale_total"]   = $sale_money;
    $money_data["form_sale_tax"]     = $tax_money;
    $money_data["form_sale_money"]   = $st_money;
    $money_data["sum_button_flg"]    = "";
    $form->setConstants($money_data);
}

/****************************/
//���ʥ��������� input the product code
/****************************/
if($_POST["goods_search_row"] != null){
    //���ʥǡ������������� row that acquire the product data
    $search_row = $_POST["goods_search_row"];

    //$attach_gid   = $_POST["attach_gid"];         //������ν�°���롼�� belonging group of a customer
    $client_shop_id = $_POST["client_shop_id"];   //������Υ���å�ID shop ID of a customer
    $rank_cd      = $_POST["hdn_rank_cd"];        //������θܵҶ�ʬ customer classification of a customer
    $ware_id      = $_POST["form_ware_select"];   //�в��Ҹ� shipping warehouse

    $sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    $sql .= "   t_goods.goods_cd,\n";
    //$sql .= "   t_goods.goods_name,\n";
    $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //����̾ official name

    $sql .= "   initial_cost.r_price AS initial_price,\n";
    $sql .= "   sale_price.r_price AS sale_price,\n";
    $sql .= "   t_goods.tax_div,\n";
    #2009-10-13_1 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num, \n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num, \n";

    //aoyama-n 2009-09-04
    #$sql .= "   royalty\n";
    $sql .= "   royalty,\n";
    $sql .= "   t_goods.discount_flg\n";

    $sql .= " FROM\n";
    $sql .= "   t_goods \n";
    $sql .= "     INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";

    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id \n";

    $sql .= "   LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       goods_id,\n";
    $sql .= "       SUM(stock_num)AS stock_num\n";
    $sql .= "    FROM\n";
    $sql .= "        t_stock\n";
    $sql .= "    WHERE\n";
    $sql .= "        shop_id = $shop_id\n";
    $sql .= "        AND\n";
    $sql .= "        ware_id = $ware_id\n";
    $sql .= "    GROUP BY t_stock.goods_id\n"; 
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_goods.goods_id = t_stock.goods_id\n";
    #2009-10-13_1 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id\n";

    $sql .= " WHERE \n";
    $sql .= "       t_goods.goods_cd = '".$_POST["form_goods_cd"][$search_row]."'\n";
    $sql .= " AND \n";
    $sql .= "       t_goods.public_flg = 't'\n ";
    $sql .= " AND \n";
    $sql .= "       t_goods.accept_flg = '1'\n";
    $sql .= " AND \n";
    $sql .= "       t_goods.compose_flg = 'f'\n";
    $sql .= " AND \n";
    $sql .= "       t_goods.state IN (1,3)\n";
    $sql .= " AND \n";
    $sql .= "       initial_cost.rank_cd = '1' \n";
    #2009-10-13_1 hashimoto-y
    $sql .= " AND\n";
    $sql .= "       t_goods_info.shop_id = $shop_id \n";

    $sql .= " AND \n";
    $sql .= "       sale_price.rank_cd = '$rank_cd';\n";

    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);

    //�ǡ�����¸�ߤ�����硢�ե�����˥ǡ�����ɽ�� display the data in the form if the data exists
    if($data_num == 1){
        $goods_data = pg_fetch_array($result);

        $set_goods_data["hdn_goods_id"][$search_row]         = $goods_data[0];   //����ID product ID

        $set_goods_data["hdn_name_change"][$search_row]      = $goods_data[1];   //��̾�ѹ��ե饰 change product name flag
        $hdn_name_change[$search_row]                        = $goods_data[1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ��� to determine if the product name can be changed or not before POST

        $set_goods_data["form_goods_cd"][$search_row]        = $goods_data[2];   //����CD product CD
        $set_goods_data["form_goods_name"][$search_row]      = $goods_data[3];   //����̾ product name

        //����ñ�����������Ⱦ�������ʬ���� separate the cost price per unit to integer and decimal
        $cost_price = explode('.', $goods_data[4]);
        $set_goods_data["form_cost_price"][$search_row]["i"] = $cost_price[0];  //����ñ�� cost per unit
        $set_goods_data["form_cost_price"][$search_row]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     

        //���ñ�����������Ⱦ�������ʬ���� separate the selling price to integer and decimal 
        $sale_price = explode('.', $goods_data[5]);
        $set_goods_data["form_sale_price"][$search_row]["i"] = $sale_price[0];  //���ñ�� selling price per unit
        $set_goods_data["form_sale_price"][$search_row]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';

        $set_goods_data["hdn_royalty"][$search_row]         = $goods_data[8];

        if($_POST["form_sale_num"][$search_row] != null){
            //������۷׻� compute the cost
            $cost_amount = bcmul($goods_data[4], $_POST["form_sale_num"][$search_row],2);
            $cost_amount = Coax_Col($coax, $cost_amount);
            //����۷׻� compute the sales amount 
            $sale_amount = bcmul($goods_data[5], $_POST["form_sale_num"][$search_row],2);
            $sale_amount = Coax_Col($coax, $sale_amount);
            //�вٿ������Ϥ���Ƥ������ϡ��Ʒ׻� recompute if the shipping number of units was inputted
            $set_goods_data["form_cost_amount"][$search_row]     = number_format($cost_amount);
            $set_goods_data["form_sale_amount"][$search_row]     = number_format($sale_amount);
        }

        $set_goods_data["hdn_tax_div"][$search_row]          = $goods_data[6]; //���Ƕ�ʬ tax classifcation
        $set_goods_data["form_stock_num"][$search_row]       = $goods_data[7]; //���߸˿� current inventory number
        //aoyama-n 2009-09-04
        $set_goods_data["hdn_discount_flg"][$search_row]     = $goods_data[9]; //�Ͱ��ե饰 discounted flag

    }else{
        //�ǡ�����̵�����ϡ������ if there is no data then initialize
        $no_goods_flg                                        = true;     //�������뾦�ʤ�̵����Хǡ�����ɽ�����ʤ� do not display the data if there is no corresponding product
        $set_goods_data["hdn_goods_id"][$search_row]         = "";
        $set_goods_data["hdn_name_change"][$search_row]      = "";
        $set_goods_data["form_goods_cd"][$search_row]        = "";
        $set_goods_data["form_goods_name"][$search_row]      = "";
        $set_goods_data["form_sale_num"][$search_row]        = "";
        $set_goods_data["form_cost_price"][$search_row]["i"] = "";
        $set_goods_data["form_cost_price"][$search_row]["d"] = "";
        $set_goods_data["form_cost_amount"][$search_row]     = "";
        $set_goods_data["form_sale_price"][$search_row]["i"] = "";
        $set_goods_data["form_sale_price"][$search_row]["d"] = "";
        $set_goods_data["form_sale_amount"][$search_row]     = "";
        $set_goods_data["hdn_tax_div"][$search_row]          = "";
        $set_goods_data["form_stock_num"][$search_row]       = "";
        $set_goods_data["hdn_royalty"][$search_row]       = "";
        //aoyama-n 2009-09-04
        $set_goods_data["hdn_discount_flg"][$search_row]     = "";
    }
    $set_goods_data["goods_search_row"]                  = "";
    $form->setConstants($set_goods_data);
}

/****************************/
//ɽ���ܥ��󲡲����� process when display button is pressed
/****************************/
if($_POST["show_button_flg"] == true && $_POST["client_search_flg"] != true && $_POST["trans_check_flg"] != true && $_POST["comp_button"] != "���OK"){
    $aord_id = $_POST["form_ord_no"];       //����ID sales order ID

    //�ץ������μ����ֹ�����򤷤����Τ�GET������ղä������ܤ��� add the GET information and transition only if the sales order number from the dropdown was selected
    if($aord_id != NULL && $aord_id != 0){
        //����ID��GET���ɲä��������̤����� add the sales order ID in GET and transition it to the screen
        header("Location: ./1-2-201.php?aord_id=$aord_id");
    }else{
        header("Location: ./1-2-201.php");
    }
}

/****************************/
//���顼�����å�(addRule) error check
/****************************/
//���׾��� sales recorded date
//��ɬ�ܥ����å� require fields
//��Ⱦ�ѿ��������å� hald width check
$form->addGroupRule('form_sale_day', array(
        'y' => array(
                array('���׾��� �����դ������ǤϤ���ޤ���', 'required'),
                array('���׾��� �����դ������ǤϤ���ޤ���', 'numeric')
        ),      
        'm' => array(
                array('���׾��� �����դ������ǤϤ���ޤ���','required'),
                array('���׾��� �����դ������ǤϤ���ޤ���', 'numeric')
        ),       
        'd' => array(
                array('���׾��� �����դ������ǤϤ���ޤ���','required'),
                array('���׾��� �����դ������ǤϤ���ޤ���', 'numeric')
        )       
));

//������ invoice date
//��ɬ�ܥ����å� require fields
//��Ⱦ�ѿ��������å� hald width check
$form->addGroupRule('form_claim_day', array(
        'y' => array(
                array('������ �����դ������ǤϤ���ޤ���', 'required'),
                array('������ �����դ������ǤϤ���ޤ���', 'numeric')
        ),      
        'm' => array(
                array('������ �����դ������ǤϤ���ޤ���','required'),
                array('������ �����դ������ǤϤ���ޤ���', 'numeric')
        ),       
        'd' => array(
                array('������ �����դ������ǤϤ���ޤ���','required'),
                array('������ �����դ������ǤϤ���ޤ���', 'numeric')
        )       
));

//������ customer 
//��ɬ�ܥ����å� required field
$form->addGroupRule('form_client', array(
        'cd1' => array(
                array('�����������襳���ɤ����Ϥ��Ƥ���������','required')
        ),
        'cd2' => array(
                array('�����������襳���ɤ����Ϥ��Ƥ���������','required')
        ),
        'name' => array(
                array('�����������襳���ɤ����Ϥ��Ƥ���������','required')
        )
));

//���꡼����ꤷ�����ϡ������ȼԤ�ɬ�� if green designation was clicked carrier is a required field
if($_POST["form_trans_check"] != NULL){
    //�����ȼ� carrier 
    //��ɬ�ܥ����å� require fuield
    $form->addRule('form_trans_select','�����ȼԤ����򤷤Ƥ���������','required');
}

//�в��Ҹ� shipping warehouse 
//��ɬ�ܥ����å� require field 
$form->addRule('form_ware_select','�в��Ҹˤ����򤷤Ƥ���������','required');

//�����ʬ trade classification
//��ɬ�ܥ����å� require field
$form->addRule('trade_sale_select','�����ʬ�����򤷤Ƥ���������','required');

//ô���� assigned staff
//��ɬ�ܥ����å� require field
$form->addRule('form_cstaff_select','���ô���Ԥ����򤷤Ƥ���������','required');

/****************************/
//��Ͽ�ܥ��󲡲����� process when registration button is pressd
/****************************/
if($_POST["form_sale_btn"] == "����ǧ���̤�" || $_POST["comp_button"] == "���OK"){

    //�إå������� header information
    $sale_no              = $_POST["form_sale_no"];            //��ɼ�ֹ� slip number
    $sale_day_y           = $_POST["form_sale_day"]["y"];      //����� sales date
    $sale_day_m           = $_POST["form_sale_day"]["m"];            
    $sale_day_d           = $_POST["form_sale_day"]["d"];            
    $claim_day_y          = $_POST["form_claim_day"]["y"];     //������ invoice date
    $claim_day_m          = $_POST["form_claim_day"]["m"];            
    $claim_day_d          = $_POST["form_claim_day"]["d"];            
    $note                 = $_POST["form_note"];               //���� remarks
    //POST���󤬤��뤫 is ther POST info
    if($_POST["form_trans_check"] != NULL){
        $trans_check          = 't';                           //���꡼����� green desig
    }
    $trans_id             = $_POST["form_trans_select"];       //�����ȼ� carrier

    //����������ξ��ϼ������ľ����ID�򤷤褦 if its a sales from the sales order then use the direct destination ID at the receipt of the order
    if($aord_id != null){
        $sql = "SELECT direct_id FROM t_aorder_h WHERE aord_id = $aord_id;";
        $result = Db_Query($db_con,$sql);

        $direct_id = pg_fetch_result($result, 0,0);

    }else{
        $direct_id            = $_POST["form_direct_select"];      //ľ���� direct destination
    }
    $ware_id              = $_POST["form_ware_select"];        //�Ҹ� warehouse
    $trade_sale           = $_POST["trade_sale_select"];       //�����ʬ trade classification
    $c_staff_id           = $_POST["form_cstaff_select"];      //���ô���� sales staff
    $ac_staff_id          = $_POST["form_staff_select"];       //����ô���� sales order staff
    $royalty_rate         = $_POST["hdn_royalty_rate"];        //�����ƥ� royalty

    /****************************/
    //���顼�����å�(PHP) error check
    /****************************/
    $error_flg = false;                                         //���顼Ƚ��ե饰 error determination flag

    //�ǡ������� data info
    $check_ary = array(
                    $_POST[hdn_goods_id],                           //����ID product Id
                    $_POST[form_goods_cd],                          //���ʥ����� product code
                    $_POST[form_goods_name],                        //����̾ product name
                    $_POST[form_sale_num],                          //�вٿ� shipping number of units 
                    $_POST[form_cost_price],                        //����ñ�� cost per unit
                    $_POST[form_sale_price],                        //���ñ�� selling price per unit
                    $_POST[form_cost_amount],                       //������� cost price
                    $_POST[form_sale_amount],                       //����� sales price
                    $_POST[hdn_tax_div],                            //���Ƕ�ʬ tax classification
                    $del_history,                                   //������� delete history
                    $max_row,                                       //����Կ� max row number 
                    'sale',                                         //��������ʬ sales order sales classificcation
                    $db_con,                                        //DB���ͥ������ DB connection
                    $_POST[form_aorder_num],                        //����� number of units received as order
                    //aoyama-n 2009-09-04
                    #$_POST[hdn_royalty]                             //�����ƥ� royalty
                    $_POST[hdn_royalty],                            //�����ƥ� royalty
                    $_POST[hdn_discount_flg]                        //�Ͱ��ե饰 discounted flag
                );


    $check_data = Row_Data_Check2($check_ary);

    //���顼�����ä���� if there is an erro 
    if($check_data[0] === true){
        //����̤���򥨥顼 error for not selecting the product
        $goods_error0 = $check_data[1];

        //���ʥ��������� invalid product code
        $goods_error1 = $check_data[2];

        //�����������ñ�������ñ�����ϥ����å� number of units recived as order, cost per unit, selling price per unit check
        $goods_error2 = $check_data[3];

        //�����Ⱦ�ѥ��顼 number of units received as order half width check
        $goods_error3 = $check_data[4];

        //����ñ��Ⱦ�ѥ��顼 cost per unit haldwidth check
        $goods_error4 = $check_data[5];

        //���ñ��Ⱦ�ѥ��顼 selling price per unit halfwidth check
        $goods_error5 = $check_data[6];

        $error_flg = true; 
    //���顼��̵���ä���� if there is no error
    }else{  
        $goods_id         = $check_data[1][goods_id];       //����ID product ID
        $goods_cd         = $check_data[1][goods_cd];       //����ID product ID
        $goods_name       = $check_data[1][goods_name];     //����̾ product name
        $sale_num         = $check_data[1][sale_num];       //�вٿ� shipping number of prdodcts
        $c_price          = $check_data[1][cost_price];     //����ñ������������ cost per unit integer
        $s_price          = $check_data[1][sale_price];     //���ñ������������ selling price oper unit integer
        $tax_div          = $check_data[1][tax_div];        //���Ƕ�ʬ tax classification
        $cost_amount      = $check_data[1][cost_amount];    //������� cost price
        $sale_amount      = $check_data[1][sale_amount];    //����� sales price
        $aorder_num       = $check_data[1][aord_num];       //����� number of units received as order
        $royalty          = $check_data[1][royalty];        //�����ƥ� royalty
        $def_line         = $check_data[1][def_line];
    }

    $royalty_data = Total_Royalty($sale_amount, $royalty, $royalty_rate,$coax);

    //���ʥ����å� product check
    //���ʽ�ʣ�����å� product duplication check
    $goods_count = count($goods_id);
    for($i = 0; $i < $goods_count; $i++){

        //���˥����å��Ѥߤξ��ʤξ��ώ������̎� skip if its a product already cehcked
        if(@in_array($goods_id[$i], $checked_goods_id)){
            continue;
        }

        //�����å��оݤȤʤ뾦�� product target for check
        $err_goods_cd = $goods_cd[$i];
        $mst_line = $def_line[$i];

        for($j = $i+1; $j < $goods_count; $j++){
            //���ʤ�Ʊ�����if the product is the same
            if($goods_id[$i] == $goods_id[$j]) {
                $duplicate_line .= ", ".($def_line[$j]);
            }
        }
        $checked_goods_id[] = $goods_id[$i];    //�����å��Ѥ߾��� checked product

        if($duplicate_line != null){
            $duplicate_goods_err[] =  "���ʥ����ɡ�".$err_goods_cd."�ξ��ʤ�ʣ�����򤵤�Ƥ��ޤ���(".$mst_line.$duplicate_line."����)";
        }

        $err_goods_cd   = null;
        $mst_line       = null;
        $duplicate_line = null;
    }

    //�����׾��� sales recorded date
    //��ʸ��������å� check the type of string
    if($sale_day_y != null && $sale_day_m != null && $sale_day_d != null){
        $sale_day_y = (int)$sale_day_y;
        $sale_day_m = (int)$sale_day_m;
        $sale_day_d = (int)$sale_day_d;
        if(!checkdate($sale_day_m,$sale_day_d,$sale_day_y)){
            $form->setElementError("form_sale_day","���׾��� �����դ������ǤϤ���ޤ���");
        }else{
            //�����ƥ೫���������å� system check starting date
            $err_msge = Sys_Start_Date_Chk($sale_day_y, $sale_day_m, $sale_day_d, "���׾���");
            if($err_msge != null){
                $form->setElementError("form_sale_day","$err_msge"); 
            }
            //�� ���׾��� sales recorded date
            //����� monthly update
            if(Check_Monthly_Renew($db_con, $client_id, "1", $sale_day_y, $sale_day_m, $sale_day_d) === false){
                $form->setElementError("form_sale_day","������˷���������������դ���Ͽ�Ǥ��ޤ���");
            }
        }
    }

    //�������� invoice date
    //��ʸ��������å� check the type of string
    if($claim_day_y != null || $claim_day_m != null || $claim_day_d != null){
        $claim_day_y = (int)$claim_day_y;
        $claim_day_m = (int)$claim_day_m;
        $claim_day_d = (int)$claim_day_d;
        if(!checkdate($claim_day_m,$claim_day_d,$claim_day_y)){
            $form->setElementError("form_claim_day","������ �����դ������ǤϤ���ޤ���");
        }else{
            //�����ƥ೫���������å� system check starting date
            $err_msge = Sys_Start_Date_Chk($claim_day_y, $claim_day_m, $claim_day_d, "������");
            if($err_msge != null){
                $form->setElementError("form_claim_day","$err_msge"); 
            }        

            //�������� invoice date
            //����� monthly update
            if(Check_Monthly_Renew($db_con, $client_id, "1", $claim_day_y, $claim_day_m, $claim_day_d) === false){
                $form->setElementError("form_claim_day","�������˷���������������դ���Ͽ�Ǥ��ޤ���");
            }

            //�������� invoice date
            //���������� invoice closing date
            if(Check_Bill_Close_Day($db_con, $client_id, $claim_day_y, $claim_day_m, $claim_day_d) === false){
                $form->setElementError("form_claim_day","�����������������Ѥ����դ����Ϥ���Ƥ��ޤ���<br>���������ѹ����뤫�������������Ʋ�������");
            }
        }
    }


    //�����ֹ��ʣ�����å� check if sales order number is duplicated
    //������������Ϥ򵯤������ˡ��ѹ��ǤϤʤ���� if you will record the sales from the sales order and if it is not an edit
    if($aord_id != null && $sale_id == null){
        $sql  = "SELECT";
        $sql .= "   t_aorder_h.ord_no";
        $sql .= " FROM";
        $sql .= "   (SELECT";
        $sql .= "       aord_id";
        $sql .= "   FROM";
        $sql .= "       t_sale_h";
        $sql .= "   WHERE";
        $sql .= "       t_sale_h.aord_id = $aord_id";
        $sql .= "   ) AS t_sale_h";
        $sql .= "       INNER JOIN";
        $sql .= "   t_aorder_h";
        $sql .= "   ON t_sale_h.aord_id = t_aorder_h.aord_id";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $aord_no = @pg_fetch_result($result,0,0);

        if($aord_no != null){
            $aord_id_err = "�����ֹ�".$aord_no."�ϴ���������ϺѤߤǤ���";
            $error_flg = true;
        }
    }

    //aoyama-n 2009-09-04
    //�Ͱ�����������μ����ʬ�����å����Ͱ������ʤϻ����Բġ� check the trade classification when a discounted product is selected (discounted and returned products cant be used)
    if(($trade_sale == '13' || $trade_sale == '14' || $trade_sale == '63' || $trade_sale == '64') 
      && (in_array('t', $_POST[hdn_discount_flg]))){
        $form->setElementError("trade_sale_select", "�Ͱ����ʤ����򤷤���硢���ѤǤ�������ʬ�ϡֳ���塢������塢�������פΤߤǤ���");
    }

    //�����ʬ�����ʳ��ǹ�׶�ۤ��ޥ��ʥ��ξ��ϥ��顼 error if the trade classification's total is minus other than the sales  
    if($trade_sale != "11" 
        && 
        $trade_sale != "61" 
    ){
        $check_money = Total_Amount($sale_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
    
        if($check_money[2] < 0){
            $form->setElementerror("form_sale_money","�����ʬ�ˡ�13,14,15,63,64�������򤷤����˥ޥ��ʥ���ۤ���Ͽ�Ǥ��ޤ���");
        }
    }

    //���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ� do not proceed if its an error
    if($form->validate() && $error_flg == false){

        //��ϿȽ�� determine registration
        if($_POST["comp_button"] == "���OK"){

/*
            //���ߤξ�����Ψ crrent tax rate
            $sql  = "SELECT ";
            $sql .= "    tax_rate_n ";
            $sql .= "FROM ";
            $sql .= "    t_client ";
            $sql .= "WHERE ";
            $sql .= "    client_id = $shop_id;";
            $result = Db_Query($db_con, $sql); 
            $tax_num = pg_fetch_result($result, 0,0);
*/
			//2009-10-21 kajioka-h ������Ψ���� acquire tax rate
			#$tax_num = Get_TaxRate_Day($db_con, $shop_id, $client_id, $sale_day_y."-".$sale_day_m."-".$sale_day_d);

            #2009-11-25 hashimoto-y
            $tax_rate_obj->setTaxRateDay($sale_day_y."-".$sale_day_m."-".$sale_day_d);
            $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

            $total_money = Total_Amount($cost_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
            $cost_money  = $total_money[0];

            $total_money = Total_Amount($sale_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
            $sale_money  = $total_money[0];
            $sale_tax    = $total_money[1];

            //���դη����ѹ� change the format of the date
            $sale_day  = $sale_day_y."-".$sale_day_m."-".$sale_day_d;
            $claim_day  = $claim_day_y."-".$claim_day_m."-".$claim_day_d;

            //���إå������ǡ�������Ͽ������SQL sales header, sales data, registration, update SQL
            Db_Query($db_con, "BEGIN");

            //�ѹ�����Ƚ�� determine edit process
            if($sale_id != NULL){

                $update_check_flg = Update_Check($db_con, "t_sale_h", "sale_id", $sale_id, $_POST["hdn_sale_enter_day"]);
                if($update_check_flg === false){
                    Db_Query($db_con, "ROLLBACK;");
                    header("Location: ./1-2-205.php?sale_id=$sale_id&input_flg=ture&del_flg=true");
                    exit;
                }

                $renew_check_flg = Renew_Check($db_con, "t_sale_h", "sale_id", $sale_id);
                if($renew_check_flg === false){
                    Db_Query($db_con, "ROLLBACK;");
                    header("Location: ./1-2-205.php?sale_id=$sale_id&input_flg=ture&renew_flg=true");
                    exit;
                }

                if($aord_id != null){
                    $update_data_check_flg = Update_Data_Check($db_con, "t_aorder_h", "aord_id", $aord_id, $_POST["hdn_aord_change_day"]);
                    if($update_data_chekc_flg === false){
                        Db_Query($db_con, "ROLLBACK;");
                        header("Location: ./1-2-205.php?sale_id=$sale_id&input_flg=ture&aord_finish_flg=true");
                        exit;
                    }
                }

                //���إå����ѹ� change the sales header
                $sql  = "UPDATE t_sale_h SET ";
                $sql .= "    sale_no = '$sale_no',";
                $sql .= "    sale_day = '$sale_day',";
                $sql .= "    claim_day = '$claim_day',";
                $sql .= "    client_id = $client_id,";

                //ľ���褬���ꤵ��Ƥ��뤫 is the direct destination selected
                if($direct_id != null){
                    $sql .= "    direct_id = $direct_id,";
                }else{
                    $sql .= "    direct_id = NULL,";
                }
                $sql .= "    trade_id = '$trade_sale',";

                //�����ȼԤ����ꤵ��Ƥ��뤫 is the carrier selected
                if($trans_id != null){
                    $sql .= "    trans_id = $trans_id,";
                }else{
                    $sql .= "    trans_id = NULL,";
                }

                //�����å��ͤ�boolean���ѹ� change the value in the checbox to boolean
                if($trans_check=='t'){
                    $sql .= "green_flg = true,";    
                }else{
                    $sql .= "green_flg = false,";    
                }

                $sql .= "    note = '$note',";
                $sql .= "    cost_amount = $cost_money,";    
                $sql .= "    net_amount = $sale_money,";    
                $sql .= "    tax_amount = $sale_tax,";    
                $sql .= "    c_staff_id = $c_staff_id,";
                $sql .= "    ware_id = $ware_id,";
                $sql .= "    e_staff_id = $e_staff_id, ";
                $sql .= ($ac_staff_id != null)? "ac_staff_id = $ac_staff_id,": null;
                $sql .= "    client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_post_no1 = (SELECT post_no1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_post_no2 = (SELECT post_no2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_address1 = (SELECT address1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_address2 = (SELECT address2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_address3 = (SELECT address3 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_shop_name = (SELECT shop_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_shop_name2 = (SELECT shop_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= ($direct_id != null) ? " direct_cd = (SELECT direct_cd FROM t_direct WHERE direct_id = $direct_id), " : " direct_cd = NULL, ";
                $sql .= ($direct_id != null) ? " direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), " : "direct_name = NULL, ";
                $sql .= ($direct_id != null) ? " direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), " : " direct_name2 = NULL, ";
                $sql .= ($direct_id != null) ? " direct_cname = (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), " : " direct_cname = NULL, ";
                $sql .= ($direct_id != null) ? " d_post_no1 = (SELECT post_no1 FROM t_direct WHERE direct_id = $direct_id), " : " d_post_no1 = NULL, ";
                $sql .= ($direct_id != null) ? " d_post_no2 = (SELECT post_no2 FROM t_direct WHERE direct_id = $direct_id), " : " d_post_no2 = NULL, ";
                $sql .= ($direct_id != null) ? " d_address1 = (SELECT address1 FROM t_direct WHERE direct_id = $direct_id), " : " d_address1 = NULL, ";
                $sql .= ($direct_id != null) ? " d_address2 = (SELECT address2 FROM t_direct WHERE direct_id = $direct_id), " : " d_address2 = NULL, ";
                $sql .= ($direct_id != null) ? " d_address3 = (SELECT address3 FROM t_direct WHERE direct_id = $direct_id), " : " d_address3 = NULL, ";
                $sql .= ($direct_id != null) ? " d_tel = (SELECT tel FROM t_direct WHERE direct_id = $direct_id), " : " d_tel = NULL, ";
                $sql .= ($direct_id != null) ? " d_fax = (SELECT fax FROM t_direct WHERE direct_id = $direct_id), " : " d_fax = NULL, ";
                $sql .= ($trans_id != null) ? " trans_name = (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), " : " trans_name = NULL, ";
                $sql .= ($trans_id != null) ? " trans_cname = (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), " : " trans_cname = NULL, ";
                $sql .= "   ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
                $sql .= "   c_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id), ";
                $sql .= "   e_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $e_staff_id), ";
                $sql .= ($ac_staff_id != null)? " ac_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $ac_staff_id), " : null;
                $sql .= "   royalty_amount = $royalty_data,";
                #2010-09-09 aoyama-n claim_id�ɲ� add
                $sql .= "   claim_id = (SELECT claim_id FROM t_claim WHERE client_id = $client_id AND claim_div = '1'),";
                $sql .= "   change_day  = CURRENT_TIMESTAMP, ";
                $sql .= "   slip_out = (SELECT slip_out FROM t_client WHERE client_id = $client_id ) ";
                $sql .= " WHERE ";
                $sql .= "    sale_id = $sale_id;";

                $result = Db_Query($db_con,$sql);
                if($result == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }

                //���ǡ������� delete SALES data
                $sql  = "DELETE FROM";
                $sql .= "    t_sale_d";
                $sql .= " WHERE";
                $sql .= "    sale_id = $sale_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                //ʬ��ơ��֥����Ͽ����Ƥ���ǡ������� delete the data registered in the installment table
                $sql  = "DELETE FROM\n";
                $sql .= "   t_installment_sales\n";
                $sql .= " WHERE\n";
                $sql .= "   sale_id = $sale_id\n";
                $sql .= ";"; 

                $result = Db_Query($db_con, $sql);
                //���Ԥ������ϥ���Хå� rollback if failed
                if($result === false){ 
                    Db_Query($db_con, $sql);
                    exit;   
                }       

                //���ǡ������� delete the sales data
                $sql  = "DELETE FROM";
                $sql .= "    t_payin_h";
                $sql .= " WHERE";
                $sql .= "    sale_id = $sale_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

            }else{

                if($aord_id != null){
                    $aord_check_flg = Update_Check($db_con, "t_aorder_h", "aord_id", $aord_id, $_POST["hdn_aord_enter_day"]);
                    if($aord_check_flg === false){
                        Db_Query($db_con, "ROLLBACK;");
                        header("Location: ./1-2-205.php?sale_id=$sale_id&input_flg=ture&aord_del_flg=true");
                        exit;
                    }
                    $update_data_check_flg = Update_Data_Check($db_con, "t_aorder_h", "aord_id", $aord_id, $_POST["hdn_aord_change_day"]);
                    if($update_data_check_flg === false){
                        Db_Query($db_con, "ROLLBACK;");
                        header("Location: ./1-2-205.php?sale_id=$sale_id&input_flg=ture&aord_finish_flg=true");
                        exit;
                    }
                }

                //���إå�����Ͽ register the sales header
                $sql  = "INSERT INTO t_sale_h ("; 
                $sql .= "    sale_id,";
                $sql .= "    sale_no,";
                if($aord_id != NULL){
                    $sql .= "aord_id,";
                }
                $sql .= "    sale_day,";
                $sql .= "    claim_day,";
                $sql .= "    client_id,";
                //ľ���褬���ꤵ��Ƥ��뤫 is the direct destination selected
                if($direct_id != null){
                    $sql .= "    direct_id,";
                }
                $sql .= "    trade_id,";
                //�����ȼԤ����ꤵ��Ƥ��뤫 is the carrier selected
                if($trans_id != null){
                    $sql .= "    trans_id,";
                }
                //���꡼����꤬���ꤵ��Ƥ��뤫 is the green designation selected 
                if($trans_check != null){
                    $sql .= "    green_flg,";
                }
                $sql .= "    note,";
                $sql .= "    cost_amount,";   
                $sql .= "    net_amount,";                  
                $sql .= "    tax_amount,";              
                $sql .= "    c_staff_id,";
                $sql .= "    ware_id,";
                $sql .= "    e_staff_id,";
                $sql .= "    shop_id,";
                $sql .= ($ac_staff_id != null)? "ac_staff_id, ": null;
                $sql .= "    client_cd1, ";
                $sql .= "    client_cd2, ";
                $sql .= "    client_name, ";
                $sql .= "    client_name2, ";
                $sql .= "    client_cname, ";
                $sql .= "    c_post_no1, ";
                $sql .= "    c_post_no2, ";
                $sql .= "    c_address1, ";
                $sql .= "    c_address2, ";
                $sql .= "    c_address3, ";
                $sql .= "    c_shop_name, ";
                $sql .= "    c_shop_name2, ";
                if ($direct_id != null){
                    $sql .= "    direct_cd, ";
                    $sql .= "    direct_name, ";
                    $sql .= "    direct_name2, ";
                    $sql .= "    direct_cname, ";
                    $sql .= "    d_post_no1, ";
                    $sql .= "    d_post_no2, ";
                    $sql .= "    d_address1, ";
                    $sql .= "    d_address2, ";
                    $sql .= "    d_address3, ";
                    $sql .= "    d_tel, ";
                    $sql .= "    d_fax, ";
                }
                $sql .= ($trans_id != null) ? " trans_name, " : null;
                $sql .= ($trans_id != null) ? " trans_cname, " : null;
                $sql .= "    ware_name, ";
                $sql .= "    c_staff_name, ";
                $sql .= "    e_staff_name, ";
                $sql .= ($ac_staff_name != null)? "    ac_staff_name, " : null;
                $sql .= "    royalty_amount,";
                $sql .= "    claim_id, ";
                $sql .= "    claim_div,";
                $sql .= "    total_split_num,";
                $sql .= "    slip_out ";
                $sql .= ")VALUES(";
                $sql .= "    (SELECT COALESCE(MAX(sale_id), 0)+1 FROM t_sale_h),";         
                $sql .= "    '$sale_no',";
                if($aord_id != NULL){
                    $sql .= "$aord_id,";
                }
                $sql .= "    '$sale_day',";
                $sql .= "    '$claim_day',";
                $sql .= "    $client_id,";
                //ľ���褬���ꤵ��Ƥ��뤫 is the direct destination selected 
                if($direct_id != null){
                    $sql .= "    $direct_id,";
                }
                $sql .= "    '$trade_sale',";
                //�����ȼԤ����ꤵ��Ƥ��뤫 is the carrier selected 
                if($trans_id != null){
                    $sql .= "    $trans_id,";
                }
                //���꡼����꤬���ꤵ��Ƥ��뤫 is the green designation selected 
                if($trans_check != null){
                    if($trans_check=='t'){
                        $sql .= "true,";    
                    }else{
                        $sql .= "false,";    
                    }
                }
                $sql .= "    '$note',"; 
                $sql .= "    $cost_money,";   
                $sql .= "    $sale_money,";                  
                $sql .= "    $sale_tax,";        
                $sql .= "    $c_staff_id,";
                $sql .= "    $ware_id,";           
                $sql .= "    $e_staff_id,";
                $sql .= "    $shop_id,";
                $sql .= ($ac_staff_id != null)? $ac_staff_id."," : null;
                $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT post_no1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT post_no2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT address1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT address2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT address3 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT shop_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    (SELECT shop_name2 FROM t_client WHERE client_id = $client_id), ";
                if ($direct_id != null){
                    $sql .= "   (SELECT direct_cd FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT post_no1 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT post_no2 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT address1 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT address2 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT address3 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT tel FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "   (SELECT fax FROM t_direct WHERE direct_id = $direct_id), ";
                }
                $sql .= ($trans_id != null) ? " (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), " : null;
                $sql .= ($trans_id != null) ? " (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), " : null;
                $sql .= "   (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
                $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id), ";
                $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $e_staff_id), ";
                $sql .= ($ac_staff_name != null)? "   (SELECT staff_name FROM t_staff WHERE staff_id = $ac_staff_id), " : null;
                $sql .= "   $royalty_data,";
                $sql.= "    (SELECT claim_id FROM t_claim WHERE client_id = $client_id AND claim_div = '1'),";
                $sql .= "   1,";
                $sql .= ($trade_sale == "15") ? "   2," : "   1,";
                $sql .= "    (SELECT slip_out FROM t_client WHERE client_id = $client_id) ";
                $sql .= ");";

                $result = Db_Query($db_con, $sql);
                //Ʊ���¹�������� restrict simultaenous execution of process
                if($result == false){
                    $err_message = pg_last_error();
                    $err_format = "t_sale_h_sale_no_key";

                    Db_Query($db_con, "ROLLBACK");

                    //��ɼ�ֹ椬��ʣ������� if the slip number is duplicated
                    if((strstr($err_message, $err_format) != false)){ 
                        $error = "Ʊ������Ͽ��Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦������Ͽ�򤷤Ʋ�������";
     
                        //������ɼ�ֹ���������reacquire the slip number
                        $sql  = "SELECT ";
                        $sql .= "   MAX(sale_no)";
                        $sql .= " FROM";
                        $sql .= "   t_sale_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $shop_id";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $sale_no = pg_fetch_result($result, 0 ,0);
                        $sale_no = $sale_no +1;
                        $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

                        $err_data["form_sale_no"] = $sale_no;

                        $form->setConstants($err_data);

                        $duplicate_flg = true;
                    }else{
                        exit;
                    }
                }
            }

            if($duplicate_flg != true){

                //���ID����� extract sales ID
                $sql  = "SELECT";
                $sql .= "   sale_id ";
                $sql .= "FROM";
                $sql .= "   t_sale_h ";
                $sql .= "WHERE";
                $sql .= "   sale_no = '$sale_no'";
                $sql .= "   AND";
                $sql .= "   shop_id = $shop_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                $insert_sale_id= pg_fetch_result($result,0,0);


                //�������ơ��֥����Ͽ register in installement sales table
                if($trade_sale == "15"){
                    Db_Query($db_con, "BEGIN;");
                    $division_array = Division_Price($db_con, $client_id, ($sale_money + $sale_tax), $claim_day_y, $claim_day_m);
                    for($k=0;$k<2;$k++){
                        $sql  = "INSERT INTO t_installment_sales (";
                        $sql .= "   installment_sales_id,";
                        $sql .= "   sale_id,";
                        $sql .= "   collect_day,";
                        $sql .= "   collect_amount";
                        $sql .= ")VALUES(";
                        $sql .= "   (SELECT COALESCE(MAX(installment_sales_id),0)+1 FROM t_installment_sales),";
                        $sql .= "   $insert_sale_id,";
                        $sql .= "   '".$division_array[1][$k]."',";
                        $sql .= "   ".$division_array[0][$k]." ";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                    }

                    //���إå���ʬ������Ͽ register the installment number in sales header
                    $sql = "UPDATE t_sale_h SET total_split_num = 2 WHERE sale_id = $insert_sale_id;";
                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }

                    Db_Query($db_con, "COMMIT;");
                }

                //���ǡ�����Ͽ register the sales data
                for($i = 0; $i < count($goods_id); $i++){
                    //�� row
                    $line = $i + 1;

                    //�����ѹ� change the format
//                  $c_price = $cost_price_i[$i].".".$cost_price_d[$i];   //������� cost price
//                  $s_price = $sale_price_i[$i].".".$sale_price_d[$i];   //����� sales price

                    //����ǡ���ID����� extract the sales order data
                    if($aord_id != NULL){
                        $sql  = "SELECT";
                        $sql .= "   aord_d_id";
                        $sql .= " FROM";
                        $sql .= "   t_aorder_d";
                        $sql .= " WHERE";
                        $sql .= "   aord_id = $aord_id";
                        $sql .= "   AND";
                        $sql .= "   line = $line";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $aord_d_id = pg_fetch_result($result,0,0);
                    }

/*
                    //�������ơ��֥����Ͽ register in the isntallement sales data
                    $sql  = "INSERT INTO t_installment_sales (";
                    $sql .= "   installment_sales_id,";
                    $sql .= "   sale_id,";
                    $sql .= "   collect_day,";
                    $sql .= "   collect_amount";
                    $sql .= ")VALUES(";
                    $sql .= "   (SELECT COALESCE(MAX(installment_sales_id),0)+1 FROM t_installment_sales),";
                    $sql .= "   $insert_sale_id,";
                    $sql .= "   '$claim_day',";
                    $sql .= "   $sale_amount[$i]";
                    $sql .= ");";

                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, $sql);
                        exit;
                    }
*/

                    //���ǡ����ơ��֥����Ͽ register the sales data in table
                    $sql  = "INSERT INTO t_sale_d (\n";
                    $sql .= "    sale_d_id,\n";
                    $sql .= "    sale_id,\n";
                    $sql .= "    line,\n";
                    $sql .= "    goods_id,\n";
                    //$sql .= "    goods_name,\n";
                    $sql .= "    official_goods_name,\n";
                    $sql .= "    num,\n";
                    $sql .= "    tax_div,\n";
                    $sql .= "    cost_price,\n";
                    $sql .= "    cost_amount,\n";
                    $sql .= "    sale_price,\n";
                    $sql .= "    sale_amount, \n";
                    if($aord_id != NULL){
                        $sql .= "aord_d_id, \n";
                    }
                    $sql .= "    goods_cd, \n";
                    $sql .= "    unit, \n";
                    $sql .= "    royalty,\n";
                    $sql .= "    g_product_name\n";
                    $sql .= ")VALUES(\n";
                    $sql .= "    (SELECT COALESCE(MAX(sale_d_id), 0)+1 FROM t_sale_d),\n";  
/*
                    $sql .= "    (SELECT";
                    $sql .= "         sale_id";
                    $sql .= "     FROM";
                    $sql .= "        t_sale_h";
                    $sql .= "     WHERE";
                    $sql .= "        sale_no = '$sale_no'";
                    $sql .= "        AND";
                    $sql .= "        shop_id = $shop_id";
                    $sql .= "    ),";
*/
                    $sql .= "    $insert_sale_id,\n";
                    $sql .= "    '$line',\n";
                    $sql .= "    $goods_id[$i],\n";
                    $sql .= "    '$goods_name[$i]',\n"; 
                    $sql .= "    '$sale_num[$i]',\n";
                    $sql .= "    '$tax_div[$i]',\n";
                    $sql .= "    $c_price[$i],\n";
                    $sql .= "    $cost_amount[$i],\n";
                    $sql .= "    $s_price[$i],\n";
                    $sql .= "    $sale_amount[$i], \n";
                    if($aord_id != NULL){
                        $sql .= "$aord_d_id, \n";
                    }
                    $sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_id[$i]), \n";
                    $sql .= "    (SELECT unit FROM t_goods WHERE goods_id = $goods_id[$i]), \n";
                    $sql .= "   '$royalty[$i]',\n";
                    $sql .= "    (SELECT t_g_product.g_product_name FROM t_goods INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id WHERE t_goods.goods_id = $goods_id[$i])\n";
                    $sql .= ");\n";
                    $result = Db_Query($db_con, $sql);

                    if($result == false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }
                }

                //�����ʬ���Ͱ����ξ��Ͻ������ʤ� dont process if the trade classification is not the discounted one
                if($trade_sale != "14" && $trade_sale != "64"){

                    for($i = 0; $i < count($goods_id); $i++){
                        $line = $i + 1;
                        //����ʧ���ơ��֥����Ͽ register it in stock balance table

                        $sql  = " INSERT INTO t_stock_hand (";
                        $sql .= "    goods_id,";
                        $sql .= "    enter_day,";
                        $sql .= "    work_day,";
                        $sql .= "    work_div,";
                        $sql .= "    client_id,";
                        //aoyama-n 2009-07-10
                        $sql .= "    client_cname,";
                        $sql .= "    ware_id,";
                        $sql .= "    io_div,";
                        $sql .= "    num,";
                        $sql .= "    slip_no,";
                        $sql .= "    sale_d_id,";
                        $sql .= "    staff_id,";
                        $sql .= "    shop_id";
                        $sql .= ")VALUES(";
                        $sql .= "    $goods_id[$i],";
                        $sql .= "    NOW(),";
                        $sql .= "    '$sale_day',";
                        $sql .= "    '2',";
                        $sql .= "    $client_id,";
                        //aoyama-n 2009-07-10
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id),";
                        $sql .= "    $ware_id,";

                        //�����ʬ�����ʤξ������ˤǽ������� if the trade classification is a returned product then process it at the stock entry
                        if($trade_sale == "13" || $trade_sale == "63"){
                            $sql .= "    '1',";
                        }else{
                            $sql .= "    '2',";
                        }

                        $sql .= "    $sale_num[$i],";
                        $sql .= "    '$sale_no',";
                        $sql .= "    (SELECT";
                        $sql .= "        sale_d_id";
                        $sql .= "    FROM";
                        $sql .= "        t_sale_d";
                        $sql .= "    WHERE";
                        $sql .= "        line = $line";
                        $sql .= "        AND";
                        $sql .= "        sale_id = (SELECT";
                        $sql .= "                    sale_id";
                        $sql .= "                 FROM";
                        $sql .= "                    t_sale_h";
                        $sql .= "                 WHERE";
                        $sql .= "                    sale_no = '$sale_no'";
                        $sql .= "                    AND";
                        $sql .= "                    shop_id = $shop_id";
                        $sql .= "                )";
                        $sql .= "    ),";
                        $sql .= "    $e_staff_id,";
                        $sql .= "    $shop_id";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        if($result == false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }

                        //�������������ϡ��������ʧ����Ͽ if there is a number of units ordered then register the reserved units of product in the stock balance table too
                        if($aord_id != NULL){
                            $sql  = " INSERT INTO t_stock_hand (";
                            $sql .= "    goods_id,";
                            $sql .= "    enter_day,";
                            $sql .= "    work_day,";
                            $sql .= "    work_div,";
                            $sql .= "    client_id,";
                            $sql .= "    ware_id,";
                            $sql .= "    io_div,";
                            $sql .= "    num,";
                            $sql .= "    slip_no,";
                            $sql .= "    sale_d_id,";
                            $sql .= "    staff_id,";
                            $sql .= "    shop_id";
                            $sql .= ")VALUES(";
                            $sql .= "    $goods_id[$i],";
                            $sql .= "    NOW(),";
                            $sql .= "    '$sale_day',";
                            $sql .= "    '1',";
                            $sql .= "    $client_id,";
                            $sql .= "    $ware_id,";
                            $sql .= "    '1',";
                            $sql .= "    $aorder_num[$i],";
                            $sql .= "    '$sale_no',";
                            $sql .= "    (SELECT";
                            $sql .= "        sale_d_id";
                            $sql .= "    FROM";
                            $sql .= "        t_sale_d";
                            $sql .= "    WHERE";
                            $sql .= "        line = $line";
                            $sql .= "        AND";
                            $sql .= "        sale_id = (SELECT";
                            $sql .= "                    sale_id";
                            $sql .= "                 FROM";
                            $sql .= "                    t_sale_h";
                            $sql .= "                 WHERE";
                            $sql .= "                    sale_no = '$sale_no'";
                            $sql .= "                    AND";
                            $sql .= "                    shop_id = $shop_id";
                            $sql .= "                )";
                            $sql .= "    ),";
                            $sql .= "    $e_staff_id,";
                            $sql .= "    $shop_id";
                            $sql .= ");";

                            $result = Db_Query($db_con, $sql);
                            if($result == false){
                                Db_Query($db_con, "ROLLBACK");
                                exit;
                            }
                        }
                    }
                }

                //����Ȳ񡦼���Ĥ������ܤ��Ƥ������ϡ�����إå��ν���������λ�ˤ��� complete the sales order header's process status if the page transitioned from the sales order inquiry or backlog list
                if($aord_id != NULL){
                    $sql  = "UPDATE t_aorder_h SET ";
                    $sql .= "    ps_stat = '3' ";
                    $sql .= "WHERE ";
                    $sql .= "    aord_id = $aord_id;";
                    
                    $result = Db_Query($db_con, $sql);
                    if($result == false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }
                }

                //������Ͽ�ξ��ϡ�GET����̵���١�GET������� create GET info because there is no GET info for new registration
                if($sale_id == null){
                    //����ǧ���Ϥ����ID���� acquire ID you will pass for sales confirmation
                    $sql  = "SELECT ";
                    $sql .= "    sale_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_sale_h ";
                    $sql .= "WHERE ";
                    $sql .= "    sale_no = '$sale_no'";
                    $sql .= "AND ";
                    $sql .= "    shop_id = $shop_id;";
                    $result = Db_Query($db_con, $sql);
                    $sale_id = pg_fetch_result($result,0,0);
                }

                //�����ʬ�˸������ꤷ����������ơ��֥����Ͽ��Ԥ� register in the payment table if the trade classification is cash
                if($trade_sale == '61' || $trade_sale == '63' || $trade_sale == '64'){

                    //��ư���֤���ɼ�ֹ���� acquire the autonumber of slip number
                    $sql  = "SELECT";
                    $sql .= "   MAX(pay_no)";
                    $sql .= " FROM";
                    $sql .= "   t_payin_h";
                    $sql .= " WHERE";
                    $sql .= "   shop_id = $shop_id";
                    $sql .= ";"; 

                    $result = Db_Query($db_con, $sql);
                    $pay_no = pg_fetch_result($result, 0 ,0);
                    $pay_no = $pay_no +1;
                    $pay_no = str_pad($pay_no, 8, 0, STR_PAD_LEFT);

                    $sql  = "INSERT INTO t_payin_h(\n";
                    $sql .= "   pay_id,\n";                         //����ID payment Id
                    $sql .= "   pay_no,\n";                         //����NO payment NO
                    $sql .= "   pay_day,\n";                        //������ payment date
                    $sql .= "   client_id,\n";                      //������ID customer ID
                    $sql .= "   client_cd1,\n";                     //�����襳���ɣ� customer code 1
                    $sql .= "   client_cd2,\n";                     //�����襳���ɣ� customer code 2
                    $sql .= "   client_name,\n";                    //������̾ cusotmer name
                    $sql .= "   client_cname,\n";                   //ά�� abbreviation
                    $sql .= "   claim_div,\n";                      //�������ʬ customer classification
                    $sql .= "   claim_cd1,\n";                      //�����襳���ɣ� customer code 1
                    $sql .= "   claim_cd2,\n";                      //�����襳���ɣ� customer code 2
                    $sql .= "   claim_cname,\n";                    //ά�� abbreviation
                    $sql .= "   input_day,\n";                      //������ input date
                    $sql .= "   e_staff_id,\n";                     
                    $sql .= "   e_staff_name,\n";
                    $sql .= "   ac_staff_id,\n";
                    $sql .= "   ac_staff_name,\n";
                    $sql .= "   sale_id,\n";
                    $sql .= "   shop_id,\n";
                    $sql .= "   collect_staff_id,\n";
                    $sql .= "   collect_staff_name\n";
                    $sql .= ")VALUES(\n";
                    //$sql .= "   (SELECT COALESCE(MAX(pay_id),0)+1 FROM t_payin_h WHERE shop_id = $shop_id),\n";
                    $sql .= "   (SELECT COALESCE(MAX(pay_id),0)+1 FROM t_payin_h),\n";
                    $sql .= "   '$pay_no',\n";
                    $sql .= "   '$sale_day',\n";
                    $sql .= "   $client_id,\n";
                    $sql .= "   (SELECT client_cd1 FROM t_client WHERE client_id = $client_id),\n";
                    $sql .= "   (SELECT client_cd2 FROM t_client WHERE client_id = $client_id),\n";
                    $sql .= "   (SELECT client_name FROM t_client WHERE client_id = $client_id),\n";
                    $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $client_id),\n";
                    $sql .= "   '1',\n";
                    $sql .= "   (SELECT\n";
                    $sql .= "       client_cd1\n";
                    $sql .= "   FROM\n";
                    $sql .= "       t_claim\n";
                    $sql .= "           INNER JOIN \n";
                    $sql .= "       t_client\n";
                    $sql .= "       ON t_claim.claim_id = t_client.client_id\n";
                    $sql .= "   WHERE\n";
                    $sql .= "       t_claim.client_id = $client_id\n";
                    $sql .= "       AND\n";
                    $sql .= "       t_claim.claim_div = '1'\n";
                    $sql .= "   ),\n";
                    $sql .= "   (SELECT\n";
                    $sql .= "       client_cd2\n";
                    $sql .= "   FROM\n";
                    $sql .= "       t_claim\n";
                    $sql .= "           INNER JOIN\n";
                    $sql .= "       t_client\n";
                    $sql .= "       ON t_claim.claim_id = t_client.client_id\n";
                    $sql .= "   WHERE\n";
                    $sql .= "       t_claim.client_id = $client_id\n";
                    $sql .= "       AND\n";
                    $sql .= "       t_claim.claim_div = '1'\n";
                    $sql .= "   ),\n";
                    $sql .= "   (SELECT\n";
                    $sql .= "       client_cname\n";
                    $sql .= "   FROM\n";
                    $sql .= "       t_claim\n";
                    $sql .= "           INNER JOIN\n";
                    $sql .= "       t_client\n";
                    $sql .= "       ON t_claim.claim_id = t_client.client_id\n";
                    $sql .= "   WHERE\n";
                    $sql .= "       t_claim.client_id = $client_id\n";
                    $sql .= "       AND\n";
                    $sql .= "       t_claim.claim_div = '1'\n";
                    $sql .= "   ),\n";
                    $sql .= "   '$sale_day',\n";
                    $sql .= "   $e_staff_id,\n";
                    $sql .= "   '".addslashes($e_staff_name)."',\n";
                    $sql .= "   $c_staff_id,\n";
                    $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id),\n";
                    $sql .= "   $insert_sale_id,\n";
                    $sql .= "   $shop_id,\n";
                    $sql .= "   $c_staff_id,\n";
                    $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id)\n";
                    $sql .= ");";

                    $result = Db_Query($db_con, $sql);

                    //Ʊ���¹�������� restrict simultaenous execution
                    if($result == false){
                        $err_message = pg_last_error();
                        $err_format = "t_payin_h_pay_no_key";

                        Db_Query($db_con, "ROLLBACK");

                        //��ɼ�ֹ椬��ʣ�������            if the slip number is duplicated
                        if((strstr($err_message, $err_format) != false)){ 
                            $error = "Ʊ������Ͽ��Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦������Ͽ�򤷤Ʋ�������";
                            $duplicate_flg = true;
                        }else{
                            exit;
                        }
                    }

                    //����ǡ�������Ͽ register in payment table

                    //�����Ͱ������������ʤξ��ϡݤ��դ��� payment discount. if its a cash return then minus.
                    if($trade_sale == '63' || $trade_sale == '64'){
                        $sale_money = "-".$sale_money;
                        #2010-02-03 aoyama-n 
                        $sale_tax = "-".$sale_tax;
                    }

                    $sql  = "INSERT INTO t_payin_d(\n";
                    $sql .= "   pay_d_id,\n";
                    $sql .= "   pay_id,\n";
                    $sql .= "   trade_id,\n";
                    $sql .= "   amount\n";
                    $sql .= ")VALUES(";
                    $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payin_d),\n";
                    $sql .= "   (SELECT\n";
                    $sql .= "       pay_id\n";
                    $sql .= "   FROM\n";
                    $sql .= "       t_payin_h\n";
                    $sql .= "   WHERE\n";
                    $sql .= "       pay_no = '$pay_no'\n";
                    $sql .= "       AND\n";
                    $sql .= "       shop_id = $shop_id\n";
                    $sql .= "   ),\n";
                    $sql .= "   '39',\n";
                    $sql .= "   ($sale_money + $sale_tax)\n";
                    $sql .= ");\n";

                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }
                }

                Db_Query($db_con, "COMMIT");
                header("Location: ./1-2-205.php?sale_id=$sale_id&input_flg=true");
            }
        }else{
            //��Ͽ��ǧ���̤�ɽ���ե饰 display flag the registration screen
            $comp_flg = true;
        }
    }else{
        //���顼���ļ���ID��̵����н���� initialize if there is no error and sales order ID
        if($aord_id == NULL){
            $client_data["show_button_flg"]     = "";        //ɽ���ܥ��� display button
            $client_data["form_ord_no"]         = "";        //�����ֹ� sales order number
            $form->setConstants($client_data);
        }
    }
}

/****************************/
// ������ξ��ּ��� acquire customer status 
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);

/****************************/
//���ʺ����ʲ��ѡ�create component (variable)
/****************************/
//���ֹ楫���� row number counter
$row_num = 1;


//�����褬���򤵤�Ƥ��ʤ����ϥե�������ɽ�� if the customer is not selected dont display form 
if($warning != null || $comp_flg == true){
    #2009-09-15 hashimoto-y
    #$style = "color: #000000; border: #ffffff 1px solid; background-color: #ffffff";
    $style = "border: #ffffff 1px solid; background-color: #ffffff";
    $type = "readonly";
}else{
    $type = $g_form_option;
}

for($i = 0; $i < $max_row; $i++){
    //ɽ����Ƚ�� determine display row
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;


        #2009-09-10 hashimoto-y
        //�Ͱ����ʤ����򤷤����ˤ��ֻ����ѹ� make it a net loss if a discounted product is selected
        $font_color = "";

        $trade_sale_select = $form->getElementValue("trade_sale_select");
        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

        #print_r($hdn_discount_flg);

        if($hdn_discount_flg === 't' || 
           $trade_sale_select[0] == '13' || $trade_sale_select[0] == '14' || $trade_sale_select[0] == '63' || $trade_sale_select[0] == '64'
        ){
            $font_color = "color: red; ";
        }else{
            $font_color = "color: #000000; ";
        }


//�����̵ͭ�ˤ�����餺�ѹ��Ĥˤ����watanabe-k�� make it editable whether there is a sales order or not 
        //����������Ƚ�� determine the screen to transition to
        if($aord_id == NULL){
            //���Ȳ���ɼȯ�Ԥ������ܤ��Ƥ������ if it transitioned from sales inquiry or slip issuance

            //���ʥ�����      product code
            #2009-09-10 hashimoto-y
            $form->addElement(
                "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
                style=\"$font_color $style $g_form_style \" $type 
                onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'goods_search_row', $i ,$row_num)\""
            );
          
        }else{
            //����Ȳ񡦼���Ĥ������ܤ������ ifit transitioned from sales order inquiry and backlog list

            //���ʥ�����      product list
            #2009-09-10 hashimoto-y
            $form->addElement(
                "text","form_goods_cd[$i]","",
                "size=\"10\" style=\" $font_color
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: left\" readonly'"
            );
        }       

            //����̾ product name
            //�ѹ��Բ�Ƚ�� determine if editable or not
            if(($_POST["hdn_name_change"][$i] == '2' || $hdn_name_change[$i] == '2') && $comp_flg != true){
                //�Բ� cannot 
                #2009-09-10 hashimoto-y
                $form->addElement(
                    "text","form_goods_name[$i]","",
                    "size=\"52\" style=\" $font_color \" $g_text_readonly" 
                );
            }else{
                //�� can
                #2009-09-10 hashimoto-y
                $form->addElement(
                    "text","form_goods_name[$i]","",
                    "size=\"52\" maxLength=\"41\" 
                    style=\"$font_color $style\" $type"
                );
            }

            //���߸˿� current inv number
            #2009-09-10 hashimoto-y
            $form->addElement(
                "text","form_stock_num[$i]","",
//                "size=\"11\" style=\"color : #585858; 
//                border : #ffffff 1px solid; 
//                background-color: #ffffff; 
//                text-align: right\" readonly'"
                "class=\"money\" size=\"11\" maxLength=\"9\"
                 style=\"$font_color border: #ffffff 1px solid; background-color: #ffffff; $g_form_style\"
                 $g_text_readonly"
            );

            //�вٿ� shipping number of prod
            #2009-09-10 hashimoto-y
            #2009-10-13 hashimoto-y
            //�����鵯���������Ͻвٿ��ѹ��Բ� sales recorded from the sales order cant change the shipping number of product 
            if($aord_id != null){
                $form->addElement(
                    "text","form_sale_num[$i]","",
                    "class=\"money\" size=\"11\" maxLength=\"5\"
                     style=\"$font_color border: #ffffff 1px solid; background-color: #ffffff; $g_form_style\"
                     $g_text_readonly"
                );
            }else{
                $form->addElement(
                    "text","form_sale_num[$i]","",
                    "class=\"money\" size=\"11\" maxLength=\"5\" 
                    onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"
                    style=\"text-align: right; $font_color $style $g_form_style \" $type "
                );
            }

            //����ñ�� cost per pirce
            #2009-09-10 hashimoto-y
            $form_cost_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" maxLength=\"9\"
                class=\"money\"
                onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $style $g_form_style\"
                $type"
            );
            $form_cost_price[$i][] =& $form->createElement("static","","",".");
            #2009-09-10 hashimoto-y
            $form_cost_price[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\" 
                onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"
                style=\"text-align: left; $font_color $style $g_form_style\"
                $type"
            );
            $form->addGroup( $form_cost_price[$i], "form_cost_price[$i]", "");

            //������� cost price
            #2009-09-10 hashimoto-y
            $form->addElement(
                "text","form_cost_amount[$i]","",
                "size=\"25\" maxLength=\"18\" 
                style=\" $font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
            
            //���ñ�� sales per price
            #2009-09-10 hashimoto-y
            $form_sale_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" maxLength=\"9\"
                class=\"money\"
                onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $style $g_form_style\"
                $type"
            );
            $form_sale_price[$i][] =& $form->createElement("static","","",".");
            #2009-09-10 hashimoto-y
            $form_sale_price[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\" 
                onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"
                style=\"text-align: left; $font_color $style $g_form_style\"
                $type"
            );
            $form->addGroup( $form_sale_price[$i], "form_sale_price[$i]", "");

            //����� sales price
            #2009-09-10 hashimoto-y
            $form->addElement(
                "text","form_sale_amount[$i]","",
                "size=\"25\" maxLength=\"18\" 
                style=\" $font_color
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );

            //��Ͽ��ǧ���̤ξ�����ɽ�� dont display if registration screen
            if($comp_flg != true){
                //������� search link
                $form->addElement(
                    "link","form_search[$i]","","#","����",
                    "TABINDEX=-1 onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,5,'',$i,$row_num);\""
                );

                //������ delete link
                //�ǽ��Ԥ��������硢���������κǽ��Ԥ˹�碌��math it with the row previous to the last row if the last row was deleted 
                if($row_num == $max_row-$del_num){
                    $form->addElement(
                        "link","form_del_row[$i]","",
                        "#","<font color='#FEFEFE'>���</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1);return false;\""
                    );
                //�ǽ��԰ʳ����������硢�������Ԥ�Ʊ��NO�ιԤ˹�碌�� match it with the row being deleted if the row being deleted is not the last row
                }else{
                    $form->addElement(
                        "link","form_del_row[$i]","",
                        "#","<font color='#FEFEFE'>���</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num);return false;\""
                    );
                }
            }

            //����� recived number of products ordered
            //�������ϡ�����Ĥ������ܤ��Ƥ�����硢�������ɽ�� display received no of products if it transtiioned from order input or backlog olist
            if($aord_id != NULL){
                $form->addElement(
                    "text","form_aorder_num[$i]","",
//                    "size=\"11\" style=\"color : #585858; 
//                    border : #ffffff 1px solid; 
//                    background-color: #ffffff; 
//                    text-align: right\" readonly'"
                    "class=\"money\" size=\"11\" maxLength=\"9\"
                     style=\"$font_color border: #ffffff 1px solid; background-color: #ffffff; $g_form_style\"
                     $g_form_option"
                );
            }

            //����ID product Id
            $form->addElement("hidden","hdn_goods_id[$i]");
            //���Ƕ�ʬ tax class
            $form->addElement("hidden", "hdn_tax_div[$i]");
            //��̾�ѹ��ե饰 change product name flag
            $form->addElement("hidden","hdn_name_change[$i]");
            //�����ƥ� royalty
            $form->addElement("hidden","hdn_royalty[$i]");
            //aoyama-n 2009-09-04
            //�Ͱ��ե饰 discounted flag
            #$form->addElement("hidden","hdn_discount_flg[$i]");
/*
        }else{
            //����Ȳ񡦼���Ĥ������ܤ������ if it transitioned from sales order inquiry or bakclog list

            //���ʥ�����       product code
            $form->addElement(
                "text","form_goods_cd[$i]","",
                "size=\"10\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: left\" readonly'"
            );
        
            //����̾ product name
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"34\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: left\" readonly'"
            );

            //���߸˿� current inv number
            $form->addElement(
                "text","form_stock_num[$i]","",
                "size=\"11\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );

            //�вٿ� shipping number of product
            $form->addElement(
                "text","form_sale_num[$i]","",
                "size=\"11\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );

            //����ñ�� cost per prod
            $form_cost_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
            $form_cost_price[$i][] =& $form->createElement("static","","",".");
            $form_cost_price[$i][] =& $form->createElement(
                "text","d","",
                "size=\"2\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: left\" readonly'"
            );
            $form->addGroup( $form_cost_price[$i], "form_cost_price[$i]", "");

            //������� total cost
            $form->addElement(
                "text","form_cost_amount[$i]","",
                "size=\"25\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
            
            //���ñ�� selling priceper uinit
            $form_sale_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
            $form_sale_price[$i][] =& $form->createElement("static","","",".");
            $form_sale_price[$i][] =& $form->createElement(
                "text","d","",
                "size=\"2\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: left\" readonly'"
            );
            $form->addGroup( $form_sale_price[$i], "form_sale_price[$i]", "");

            //����� total sales
            $form->addElement(
                "text","form_sale_amount[$i]","",
                "size=\"25\" style=\"color : #585858; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );

            //����� recveived no of units of prod
            //�������ϡ�����Ĥ������ܤ��Ƥ�����硢�������ɽ�� if it transitioned form the order input and backlog list
            if($aord_id != NULL){
                $form->addElement(
                    "text","form_aorder_num[$i]","",
                    "size=\"11\" style=\"color : #585858; 
                    border : #ffffff 1px solid; 
                    background-color: #ffffff; 
                    text-align: right\" readonly'"
                );
            }

            //����ID product id
            $form->addElement("hidden","hdn_goods_id[$i]");
            //���Ƕ�ʬ tax class
            $form->addElement("hidden", "hdn_tax_div[$i]");
            //��̾�ѹ��ե饰 change product name flag
            $form->addElement("hidden","hdn_name_change[$i]");
        }
        /****************************/
        //ɽ����HTML���� create display HTML
        /****************************/
        $html .= "<tr class=\"Result1\">";
        $html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        if($warning == null && $aord_id == NULL && $comp_flg != true){
            $html .=    "��";
            $html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
            $html .=    "��";
        }
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>";
        if($aord_id != NULL){
            $html .=    "<td align=\"right\">";
            $html .=        $form->_elements[$form->_elementIndex["form_aorder_num[$i]"]]->toHtml();
            $html .=    "</td>";
        }
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_sale_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_cost_price[$i]"]]->toHtml();
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_sale_price[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_cost_amount[$i]"]]->toHtml();
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_sale_amount[$i]"]]->toHtml();
        $html .=    "</td>";

        if($warning == null && $aord_id == NULL && $comp_flg != true){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
            $html .= "  </td>";
        }
        $html .= "</tr>";

        //���ֹ��ܣ� +1 row number
        $row_num = $row_num+1;
    }
}

//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ� dont display the following dbuttons in the registration screens
if($comp_flg != true){

    //ɽ�� display
    if($sale_id == NULL){
        $form->addElement("button","form_show_button","ɽ����","onClick=\"javascript:Button_Submit('show_button_flg','#','true', this)\"");
    }

    //button
    $form->addElement("submit","form_sale_btn","����ǧ���̤�", $disabled);
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"javascript:history.back()\"");

    //��� total
//  if($aord_id == NULL){
        $form->addElement("button","form_sum_btn","�硡��","onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true', this)\"");
//  }

    //���ɲå�� row addition link
    if($aord_id == NULL){
        $form->addElement("button","add_row_link","���ɲ�","onClick=\"javascript:Button_Submit_1('add_row_flg', '#foot', 'true', this)\"");
    }

}else{
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ�� display the following in the reg screen
    //��� back
    $form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    
    //OK
    $form->addElement("submit","comp_button","���OK", $disabled);
    
    $form->freeze();
}

#2009-09-28 hashimoto-y
#$debug_trade_sale = $form->getElementValue("trade_sale_select");
#$debug_trade_sale = $trade_form->loadArray("trade_sale_select");
#$debug_trade_sale = $trade_form->getSelected();
#print_r($debug_trade_sale);


/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/
/****************************/
//HTML�إå� HTML header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� HTML footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h('sale','2');
/****************************/
//���̥إå������� create screen header
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["203_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["201_button"]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign form related variables
$smarty->assign('form',$renderer->toArray());



$smarty->assign('goods_error1',$goods_error1);
$smarty->assign('goods_error2',$goods_error2);
$smarty->assign('goods_error3',$goods_error3);
$smarty->assign('goods_error4',$goods_error4);
$smarty->assign('goods_error5',$goods_error5);
$smarty->assign("duplicate_goods_err", $duplicate_goods_err);

//����¾���ѿ���assign assign opther variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'warning'       => "$warning",
    'html'          => "$html",
    'form_potision' => "$form_potision",
    'aord_id'       => "$aord_id",
    'duplicate_err' => "$error",
    'goods_error0'  => "$goods_error0",
    'comp_flg'      => "$comp_flg",
    'aord_id_err'   => "$aord_id_err",
    'auth_r_msg'    => "$auth_r_msg",
    "client_state_print"    => "$client_state_print",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
