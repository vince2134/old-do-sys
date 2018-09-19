<?php
/*
 * �ѹ�����
 *   (2006/07/31)�����Ƿ׻��������ѹ���watanabe-k��
 *   (2006/12/13)����ô����ɽ���ǡ����ѹ���suzuki��
*/
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/01��08-040��������watanabe-k������饤������ѹ���λ�������ʥ����ɤ�ɽ������Ƥ��ʥХ��ν���
 * ��2006/11/01��08-041��������watanabe-k����ǧ���̤�ɽ�����줺�˴�λ���̤����ܤ���Х��ν���
 * ��2006/11/01��08-042��������watanabe-k���̿���β��Ԥ���br/��ˤʤäƤ���Х��ν���
 * ��2006/11/03��      ��������watanabe-k��ȯ���ֹ椬ɽ������Ƥ��ʤ��Х��ν���
 * ��2006/11/03��      ��������watanabe-k�����꡼�����ȼԤ����򤵤�Ƥ��ʤ��Τ˥����å�����Ƥ���Х��ν���
 * ��2006/11/03��08-081��������watanabe-k��Get�����å��ɲ�
 * ��2006/11/03��08-082��������watanabe-k��Get�����å��ɲ�
 * ��2006/11/09��08-145��������suzuki��    ������ɼ��������������������褦�˽���
 * ��2006/11/09��08-125��������watanabe-k���̿���������谸�ˤβ��Ԥ�<br />��ɽ������Ƥ���
 * ��2006/11/09��08-126��������watanabe-k���в�ͽ������NULL�ˤ�����Ͽ����ǽ�ʥХ��ν���
 * ��2006/11/09��08-150��������watanabe-k���̿���������谸�ˤΥ����å��ɲ�
 * ��2007/01/25��      ��������watanabe-k���ܥ���ο��ѹ�
 *   2007/03/01                  morita-d  ����̾������̾�Τ�ɽ������褦���ѹ� 
 *   2007/03/08                 fukuda-s     ��ê�������������Фʤ��Զ�罤��
 *   2009/10/12                hashimoto-y �Ͱ������ʤ��ֻ�ɽ�����ѹ�
 *   2009/10/13                hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *   2009/12/21                aoyama-n    ��Ψ��TaxRate���饹�������
 *   2016/01/20                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */

$page_title = "��������";

//�Ķ�����ե����� Environment Setting file 
require_once("ENV_local.php");

//HTML_QuickForm����� Create HTML_QuickForm
//$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
$form =& new HTML_QuickForm("dateForm", "POST", "#");

//DB��³ Connect DB
$db_con = Db_Connect();

// ���¥����å� Authority Check
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å����� No input/edit authority message
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled button disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ����� acquire the external variable
/****************************/
$shop_id     = $_SESSION["client_id"];
$shop_gid    = $_SESSION["shop_gid"];
$rank_cd     = $_SESSION["rank_cd"];
$o_staff_id  = $_SESSION["staff_id"];
$aord_id     = $_GET["aord_id"];
Get_Id_Check3($_GET["aord_id"]);
Get_Id_Check2($_GET["aord_id"]);

//�����褬���ꤵ��Ƥ��뤫 Is the customer assigned
if($_POST["hdn_client_id"] == null){
    $warning = "����������򤷤Ʋ�������";
}else{
    $warning = null;
    $client_id   = $_POST["hdn_client_id"];
    $coax        = $_POST["hdn_coax"];
    $tax_franct  = $_POST["hdn_tax_franct"];
    $attach_gid  = $_POST["attach_gid"];
    $client_name = $_POST["form_client"]["name"];
}

//�ѹ������оݥǡ������������Ƥ��ʤ��������å�    Check if the corrseponding data is not being deleted before edit
$sql  = "SELECT";
$sql .= "   COUNT(*) ";
$sql .= "FROM";
$sql .= "   t_aorder_h ";
$sql .= "WHERE";
$sql .= "   aord_id = $aord_id"; 
$sql .= ";";

$result = Db_Query($db_con, $sql);
if(pg_fetch_result($result,0,0) == 0){
    header("Location: ./1-2-108.php?add_del_flg='t'");
    exit;
}

/****************************/
//������� initial setting
/****************************/

#2009-12-21 aoyama-n
//��Ψ���饹�����󥹥������� tax rate class create instance 
$tax_rate_obj = new TaxRate($shop_id);

//�ѹ�����Ƚ�� edit process decision
if($aord_id != NULL){

    //����إå�����SQL SQL that acquire sales order header 
    $sql  = "SELECT ";
    $sql .= "    t_aorder_h.ord_no,";
    $sql .= "    t_aorder_h.ord_time,";
    $sql .= "    t_aorder_h.hope_day,";
    $sql .= "    t_aorder_h.arrival_day,";
    $sql .= "    t_aorder_h.green_flg,";
    $sql .= "    t_aorder_h.trans_id,";
    $sql .= "    t_aorder_h.client_id,";
/*
    $sql .= "    t_client.client_cd1,";
    $sql .= "    t_client.client_cd2,";
    $sql .= "    t_client.client_cname,";
*/
	$sql .= "    t_aorder_h.client_cd1,";
    $sql .= "    t_aorder_h.client_cd2,";
    $sql .= "    t_aorder_h.client_cname,";
    $sql .= "    t_aorder_h.direct_id,";
    $sql .= "    t_aorder_h.ware_id,";
    $sql .= "    t_aorder_h.trade_id,";
    $sql .= "    t_aorder_h.c_staff_id,";
    $sql .= "    t_aorder_h.note_your,";
    $sql .= "    t_aorder_h.note_my,";
    $sql .= "    t_direct.direct_cname, ";
    $sql .= "    t_order_h.ord_no ";
    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "       INNER JOIN";
    $sql .= "    t_client";
    $sql .= "    ON t_client.client_id = t_aorder_h.client_id ";
    $sql .= "       INNER JOIN";
    $sql .= "    t_order_h";
    $sql .= "    ON t_aorder_h.fc_ord_id = t_order_h.ord_id";
    $sql .= "       LEFT JOIN";
    $sql .= "    t_direct";
    $sql .= "    ON t_direct.direct_id = t_aorder_h.direct_id ";
    $sql .= "WHERE ";
    $sql .= "    t_aorder_h.aord_id = $aord_id ";
    $sql .= "    AND ";
    $sql .= "    t_aorder_h.ps_stat = '1';";

    $result = Db_Query($db_con,$sql);

    //GET�ǡ���Ƚ�� decide GET data
    Get_Id_Check($result);
    $h_data_list = Get_Data($result,2);

    //����ǡ�������SQL SQL that acquire sales order data
    $sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    #2009-10-13_1 hashimoto-y
    #$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";

//    $sql .= "   t_goods.goods_cd,";
    $sql .= "   t_aorder_d.goods_cd,\n";
    //$sql .= "   t_aorder_d.goods_name,\n";
    $sql .= "   t_aorder_d.official_goods_name,\n";
    #2009-10-13_1 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";

//    $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) \n";
    $sql .= " END AS allowance_total,\n";
    $sql .= "   COALESCE(t_stock.stock_num,0)\n"; 
    $sql .= "   + COALESCE(t_stock_io.order_num,0)\n";
//    $sql .= "   - (COALESCE(t_stock.rstock_num,0)\n";
    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total,\n";
    $sql .= "   t_aorder_d.num,\n";
    $sql .= "   t_aorder_d.tax_div,\n";
    $sql .= "   t_aorder_d.cost_price,\n";
    $sql .= "   t_aorder_d.sale_price,\n";
    $sql .= "   t_aorder_d.cost_amount,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   t_aorder_d.sale_amount \n";
    $sql .= "   t_aorder_d.sale_amount, \n";
    $sql .= "   t_goods.discount_flg \n";

    $sql .= " FROM\n";
    $sql .= "   t_aorder_d \n";

    $sql .= "   INNER JOIN  t_aorder_h ON t_aorder_d.aord_id = t_aorder_h.aord_id\n";
    $sql .= "   INNER JOIN  t_goods ON t_aorder_d.goods_id = t_goods.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //�߸˿� inventory count
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock.goods_id,\n";
    $sql .= "       SUM(t_stock.stock_num)AS stock_num,\n";
    $sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
    $sql .= "       FROM\n";
    $sql .= "            t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id\n";
    $sql .= "       WHERE\n";
//    $sql .= "            t_stock.shop_id =  ".$h_data_list[0][6]."\n";
    $sql .= "            t_stock.shop_id =  1\n";
    $sql .= "       AND\n";
    $sql .= "            t_ware.count_flg = 't'\n";
    $sql .= "       GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock ON t_aorder_d.goods_id = t_stock.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //ȯ��Ŀ� number of outstanding orders 
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 3\n";
    $sql .= "   AND\n";
//    $sql .= "       t_stock_hand.client_id = ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock_hand.shop_id = ".$shop_id."\n";
    $sql .= "   AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
//    $sql .= "   AND\n";
//    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n";
    $sql .= "   AND\n";
    $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io ON t_aorder_d.goods_id=t_stock_io.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //������ reserved quantity
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS allowance_io_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 1\n";
    $sql .= "   AND\n";
//    $sql .= "       t_stock_hand.client_id = ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock_hand.shop_id = ".$shop_id."\n";
    $sql .= "   AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   AND\n";
//    $sql .= "       t_stock_hand.work_day >= (CURRENT_DATE + 7)\n";
    $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io ON t_aorder_d.goods_id = t_allowance_io.goods_id\n";

    #2009-10-13_1 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id\n";

    $sql .= " WHERE \n";
    $sql .= "       t_aorder_d.aord_id = $aord_id \n";
    $sql .= " AND \n";
    $sql .= "       t_aorder_h.shop_id = $shop_id \n";
    #2009-10-13_1 hashimoto-y
    $sql .= " AND\n";
    $sql .= "       t_goods_info.shop_id = $shop_id \n";

    $sql .= " ORDER BY t_aorder_d.line;\n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $data_list = Get_Data($result,2);

    //������ξ������� extract the customer information
    $sql  = "SELECT";
    $sql .= "   client_id,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
//    $sql .= "   attach_gid ";
    $sql .= "   shop_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$h_data_list[0][6];
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $client_list = Get_Data($result);

    /****************************/
    //�ե�������ͤ����� restore the form's value
    /****************************/
    $sale_money = NULL;                        //���ʤ������ Sales amount of the product
    $tax_div    = NULL;                        //���Ƕ�ʬ tax classification

    //�إå������� restore header
    $update_goods_data["form_order_no"]                = $h_data_list[0][0];  //�����ֹ� sales order number

    //��������ǯ������ʬ���� separate the order date into year/month/day
    $ex_ord_day = explode('-',$h_data_list[0][1]);
    $update_goods_data["form_ord_day"]["y"]            = $ex_ord_day[0];   //������ sales order date
    $update_goods_data["form_ord_day"]["m"]            = $ex_ord_day[1];   
    $update_goods_data["form_ord_day"]["d"]            = $ex_ord_day[2];   

    //��˾Ǽ����ǯ������ʬ���� separate the desired delivery date into year/month/day
    $ex_hope_day = explode('-',$h_data_list[0][2]);
    $update_goods_data["form_hope_day"]["y"]           = $ex_hope_day[0];  //��˾Ǽ�� desired delivery date
    $update_goods_data["form_hope_day"]["m"]           = $ex_hope_day[1];   
    $update_goods_data["form_hope_day"]["d"]           = $ex_hope_day[2];   

    //����ͽ������ǯ������ʬ���� separate the scheduled delivery date into year/month/day
    $ex_arr_day = explode('-',$h_data_list[0][3]);
    $update_goods_data["form_arr_day"]["y"]            = $ex_arr_day[0];   //����ͽ���� scheduled delivery date
    $update_goods_data["form_arr_day"]["m"]            = $ex_arr_day[1];   
    $update_goods_data["form_arr_day"]["d"]            = $ex_arr_day[2];   

    $update_goods_data["form_trans_check"]             = ($h_data_list[0][4] == 't')? 1:null;  //���꡼����� green assignment
    $update_goods_data["form_trans_select"]            = $h_data_list[0][5];  //�����ȼ� carrier 
    $update_goods_data["form_client"]["cd1"]           = $h_data_list[0][7];  //�����襳���ɣ� customer code 1 
    $update_goods_data["form_client"]["cd2"]           = $h_data_list[0][8];  //�����襳���ɣ� customer code 2
    $update_goods_data["form_client"]["name"]          = htmlspecialchars($h_data_list[0][9]);  //������̾ customer name
    $update_goods_data["form_direct_select"]           = $h_data_list[0][10]; //ľ���� direct destination
    $update_goods_data["form_ware_select"]             = $h_data_list[0][11]; //�Ҹ� warehouse
    $update_goods_data["trade_aord_select"]            = $h_data_list[0][12]; //�����ʬ trade classification
    $update_goods_data["form_staff_select"]            = $h_data_list[0][13]; //ô���� assigned staff
    $update_goods_data["form_note_client"]             = $h_data_list[0][14]; //�̿����������� communication field (addressed to customer)
    $update_goods_data["form_note_head"]               = nl2br(htmlspecialchars($h_data_list[0][15])); //�̿����������
    $update_goods_data["form_direct_name"]             = htmlspecialchars($h_data_list[0][16]); //ľ����̾ direct destination name
    $update_goods_data["form_fc_order_no"]             = $h_data_list[0][17]; //ȯ���ֹ� purchase order number

    //�ǡ�������
    for($i=0;$i<count($data_list);$i++){
        $update_goods_data["hdn_goods_id"][$i]         = $data_list[$i][0];   //����ID product ID
        $hdn_goods_id[$i]                              = $data_list[$i][0];   //POST�������˾���ID����߸˿��ǻ��Ѥ���� For the reason that product ID will be used in the total inventory count before POST

        $update_goods_data["hdn_name_change"][$i]      = $data_list[$i][1];   //��̾�ѹ��ե饰 product name change flag
        $hdn_name_change[$i]                           = $data_list[$i][1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ��� For the reason that product name will be checked if it is non-editable or not before POST

        $update_goods_data["hdn_stock_manage"][$i]     = $data_list[$i][2];   //�߸˴��� inventory control
        $hdn_stock_manage[$i]                          = $data_list[$i][2];   //POST�������˼�ê���κ߸˴���Ƚ���Ԥʤ��� For the reason that actual shelf number will be decided in inventory control before POST
 
        $update_goods_data["form_goods_cd"][$i]        = $data_list[$i][3];   //����CD Product CD
        $update_goods_data["form_goods_name"][$i]      = $data_list[$i][4];   //����̾ Prodcut Name

        $update_goods_data["form_stock_num"][$i]       = number_format($data_list[$i][5]);   //��ê�� actual shelf number
        $update_goods_data["hdn_stock_num"][$i]        = number_format($data_list[$i][5]);   //��ê����hidden��actual shelf number (hidden)
        $stock_num[$i]                                 = number_format($data_list[$i][5]);   //��ê��(��󥯤���) actual shelf number (link's value)

        $update_goods_data["form_rorder_num"][$i]      = $data_list[$i][6];   //ȯ��ѿ� purchase orders ordered number
        $update_goods_data["form_rstock_num"][$i]      = $data_list[$i][7];   //������ reserved quantity of products for sales order
        $update_goods_data["form_designated_num"][$i]  = $data_list[$i][8];   //�вٲ�ǽ�� deliverable number of stocks
        $update_goods_data["form_sale_num"][$i]        = $data_list[$i][9];   //����� no of sales order 
        $update_goods_data["hdn_tax_div"][$i]          = $data_list[$i][10];  //���Ƕ�ʬ tax classification

        //����ñ�����������Ⱦ�������ʬ���� separate the decimal from integer for the product cost
        $cost_price = explode('.', $data_list[$i][11]);
        $update_goods_data["form_cost_price"][$i]["i"] = $cost_price[0];  //����ñ����product cost per unit
        $update_goods_data["form_cost_price"][$i]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     
        $update_goods_data["form_cost_amount"][$i]     = number_format($data_list[$i][13]);  //������� ��total product cost

        //���ñ�����������Ⱦ�������ʬ���� separate the decimal from integer for the sales price per unit
        $sale_price = explode('.', $data_list[$i][12]);
        $update_goods_data["form_sale_price"][$i]["i"] = $sale_price[0];  //���ñ�� sales price per unit
        $update_goods_data["form_sale_price"][$i]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';
        $update_goods_data["form_sale_amount"][$i]     = number_format($data_list[$i][14]);  //����� sales price

        $sale_money[]                                  = $data_list[$i][14];  //����۹�� total sales price
        $tax_div[]                                     = $data_list[$i][10];  //�����ǹ�� taxation classification

        #2009-10-13 hashimoto-y
        $update_goods_data["hdn_discount_flg"][$i]     = $data_list[$i][15]; //�Ͱ��ե饰 discount flag
    }

    //������������� restore customer information
    $client_id      = $client_list[0][0];        //������ID customer ID
    $coax           = $client_list[0][1];        //�ݤ��ʬ�ʶ�ۡ� round up/down classification (amount)
    $tax_franct     = $client_list[0][2];        //ü����ʬ�ʾ����ǡ�round up/down classification (consumption tax)
    $attach_gid     = $client_list[0][3];        //��°���롼�� belonged group
    $warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
    $update_goods_data["attach_gid"]          = $attach_gid;

    //���ߤξ�����Ψ current consumption tax rate
    #2009-12-21 aoyama-n
    #$sql  = "SELECT ";
    #$sql .= "    tax_rate_n ";
    #$sql .= "FROM ";
    #$sql .= "    t_client ";
    #$sql .= "WHERE ";
    #$sql .= "    client_id = ".$h_data_list[0][6].";";
    #$result = Db_Query($db_con, $sql); 
    #$tax_num = pg_fetch_result($result, 0,0);

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($h_data_list[0][1]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);

    //�ե�������ͥ��å� set the value to the form
    $update_goods_data["form_sale_total"]      = $sale_money;
    $update_goods_data["form_sale_tax"]        = $tax_money;
    $update_goods_data["form_sale_money"]      = $st_money;
//    $update_goods_data["sum_button_flg"]       = "";
    $update_goods_data["form_designated_date"] = 7; //�вٲ�ǽ�� possible number of delivery

//    $form->setConstants($update_goods_data);
    $form->setDefaults($update_goods_data);

    //ɽ���Կ� displayed number of row 
    if($_POST["max_row"] != NULL){
        $max_row = $_POST["max_row"];
    }else{
        //����ǡ����ο� number of sales order data
        $max_row = count($data_list);
    }

//����ID��̵����� if there is no sales order ID
}else{

}

//���ɽ�������ѹ� edit the initial display position
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//����Կ� deleted number of rows
$del_history[] = NULL; 

/****************************/
//�Կ��ɲý��� process for adding number of rows 
/****************************/
if($_POST["add_row_flg"]==true){
    //����Ԥˡ��ܣ����� +1 to the current max number of rows
    $max_row = $_POST["max_row"]+1;
    //�Կ��ɲåե饰�򥯥ꥢ clear the row addition flag
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//�Ժ������ process for deletion of row
/****************************/
if($_POST["del_row"] != ""){

    //����ꥹ�Ȥ���� acquire delete list 
    $del_row = $_POST["del_row"];

    //������������ˤ��롣make an array for the delete request
    $del_history = explode(",", $del_row);
}

//***************************/
//����Կ���hidden�˥��å� set the max row number to hidden
/****************************/
$max_row_data["max_row"] = $max_row;

$form->setConstants($max_row_data);

//***************************/
//���꡼���������å����� green assignment check process
/****************************/
//�����å��ξ��ϡ������ȼԤΥץ��������ͤ��ѹ����� if there is a check, then change the value of the carrier's dropdown
if($_POST["trans_check_flg"] == true){
    $where  = " WHERE ";
    $where .= "    shop_id = $shop_id";
//  $where .= "    shop_gid = $shop_gid";
    $where .= " AND";
    $where .= "    green_trans = 't'";

    //����� initialization
    $trans_data["trans_check_flg"]   = "";
    $form->setConstants($trans_data);
}else{
    $where = "";
}

/****************************/
//���ʺ��� create component
/****************************/
//ȯ���ֹ� purchase order number 
$form->addElement("static","form_fc_order_no","");

//�����ֹ� sales order number
$form->addElement("static","form_order_no","");

//������ customer 
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//�вٲ�ǽ�� deliverable number of stock
$form->addElement(
    "text","form_designated_date","",
    "size=\"4\" maxLength=\"4\" 
    $g_form_option 
     style=\"$g_form_style;text-align: right\"
    onChange=\"javascript:Button_Submit('recomp_flg','#','true', this)\"
    "
);

//������ sales order date
$form_ord_day[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ord_day[y]','form_ord_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ord_day[m]','form_ord_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_ord_day,"form_ord_day","form_ord_day");

//��˾Ǽ�� desired delivery date
$form_hope_day[] =& $form->createElement("static","y","�ƥ����ȥե�����","");
$form_hope_day[] =& $form->createElement("static","m","�ƥ����ȥե�����","");
$form_hope_day[] =& $form->createElement("static","d","�ƥ����ȥե�����","");
$form->addGroup( $form_hope_day,"form_hope_day","form_hope_day","-");

//����ͽ���� desired delivery date
$form_arr_day[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_arr_day[y]','form_arr_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form_arr_day[] =& $form->createElement("static","","","-");
$form_arr_day[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_arr_day[m]','form_arr_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form_arr_day[] =& $form->createElement("static","","","-");
$form_arr_day[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_arr_day,"form_arr_day","form_arr_day");


//����۹�� total sales amount 
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"$g_form_style;color : #000000; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//�����ǳ�(���) consumption tax amount (total)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"$g_form_style;color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//����ۡ��ǹ����) sales amount (with consumption tax)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"$g_form_style;color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//�̿���������谸��communication field  (addressed to customer)
$form->addElement("textarea","form_note_client","�ƥ����ȥե�����",' rows="2" cols="75" onFocus="onForm(this)" onBlur="blurForm(this)"');
//�̿������������communication field (HQ)
$form->addElement("static","form_note_head","");

//���꡼����� Green designation
$form->addElement('checkbox', 'form_trans_check', '���꡼�����', '<b>���꡼�����</b>��',"onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");
//�����ȼ� carrier
$select_value = Select_Get($db_con,'trans',$where);
$form->addElement('select', 'form_trans_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ľ���� direct destination
//$select_value = Select_Get($db_con,'direct');
//$form->addElement('select', 'form_direct_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
$form->addElement('static', 'form_direct_name', '���쥯�ȥܥå���' );

//�Ҹ� warehouse
$select_value = Select_Get($db_con,'ware');
$form->addElement('select', 'form_ware_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//�����ʬ trade classification
$select_value = Select_Get($db_con,'trade_aord');
$form->addElement('select', 'trade_aord_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//ô���� assigned staff
$select_value = Select_Get($db_con,'staff',null,true);
$form->addElement('select', 'form_staff_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//�����ǧ���̤� sales order confirm screen
$form->addElement("submit","order_conf","�����ǧ���̤�", $disabled);
//���� sales order
$form->addElement("submit","order","������", $disabled);
//��� total
//$form->addElement("button","form_sum_button","�硡��","onClick=\"javascript:Button_Submit('sum_button_flg','#','true')\"");

// �إå�����󥯥ܥ��� header link button
$ary_h_btn_list = array("�Ȳ��ѹ�" => "./1-2-105.php", "������" => "./1-2-101.php", "����İ���" => "./1-2-106.php");
Make_H_Link_Btn($form, $ary_h_btn_list, 2);

//hidden
$form->addElement("hidden", "hdn_client_id");       //������ID customer ID
$form->addElement("hidden", "attach_gid");          //��°���롼��ID belonged group ID
$form->addElement("hidden", "client_search_flg");   //�����襳�������ϥե饰 customer code input flag
$form->addElement("hidden", "hdn_coax");            //�ݤ��ʬ round up/down
$form->addElement("hidden", "hdn_tax_franct");      //ü����ʬ round up/down
$form->addElement("hidden", "del_row");             //����� deleted row
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰 add row flag
$form->addElement("hidden", "max_row");             //����Կ� max row number
$form->addElement("hidden", "goods_search_row");    //���ʥ��������Ϲ� input field for product code
$form->addElement("hidden", "sum_button_flg");      //��ץܥ��󲡲��ե饰 total button pressed flag
$form->addElement("hidden", "complete_flg");        //�����å���λ�ܥ��󲡲��ե饰 flag when confirm/complete button is pressed
$form->addElement("hidden", "trans_check_flg");     //���꡼���������å��ե饰 flag for green designatin check box
$form->addElement("hidden", "recomp_flg");          //�вٲ�ǽ���ե饰 deliverable stock count flag

#2009-10-13 hashimoto-y
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $form->addElement("hidden","hdn_discount_flg[$i]");
    }
}

/****************************/
//�вٲ�ǽ������ input delvierable stock count 
/****************************/
/*
if($_POST["recomp_flg"] == true){
    //�вٲ�ǽ�� deliverable stock count
    $designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;
    //�����ʳ������Ϥ���Ƥ�����
    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 0;
    }

    $attach_gid   = $_POST["attach_gid"];     //������ν�°���롼�� the group which the custoemr belongs
    $ary_goods_id = $_POST["hdn_goods_id"];   //���Ϥ�������ID inputted product ID

    //���Ϥ��줿���ʤθĿ���Ʒ׻����� recompute the number of unit of the product inputted
    for($i = 0; $i < count($ary_goods_id); $i++){
        //����¸��Ƚ�� check if the product exists
        if($ary_goods_id[$i] != NULL){
            //�Ʒ׻�SQL recompute SQL
            $sql  = "SELECT";
            $sql .= "   t_goods.goods_id,";
            $sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
            $sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
            $sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.rstock_num,0) - COALESCE(t_allowance_io.allowance_io_num,0) ";
            $sql .= " END AS allowance_total,";
            $sql .= "   CASE t_goods.stock_manage WHEN 1 THEN";
            $sql .= "   COALESCE(t_stock.stock_num,0)"; 
            $sql .= "   + COALESCE(t_stock_io.order_num,0)";
            $sql .= "   - (COALESCE(t_stock.rstock_num,0)";
            $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0)) END AS stock_total ";
            $sql .= " FROM";
            $sql .= "   t_goods ";

            $sql .= "   INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
            $sql .= "   INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

            $sql .= "   LEFT JOIN";
            $sql .= "   (SELECT";
            $sql .= "       t_stock.goods_id,";
            $sql .= "       SUM(t_stock.stock_num)AS stock_num,";
            $sql .= "       SUM(t_stock.rstock_num)AS rstock_num";
            $sql .= "       FROM";
            $sql .= "            t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id";
            $sql .= "       WHERE";
            $sql .= "            t_stock.shop_id =  $shop_id";
            $sql .= "       AND";
            $sql .= "            t_ware.count_flg = 't'";
            $sql .= "       GROUP BY t_stock.goods_id";
            $sql .= "   )AS t_stock ON t_goods.goods_id = t_stock.goods_id";

            $sql .= "   LEFT JOIN";
            $sql .= "   (SELECT";
            $sql .= "       t_stock_hand.goods_id,";
            $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num";
            $sql .= "   FROM";
            $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
            $sql .= "   WHERE";
            $sql .= "       t_stock_hand.work_div = 3";
            $sql .= "   AND";
            $sql .= "       t_stock_hand.client_id = $shop_id";
            $sql .= "   AND";
            $sql .= "       t_ware.count_flg = 't'";
            $sql .= "   AND";
            $sql .= "       CURRENT_DATE <= t_stock_hand.work_day";
            $sql .= "   AND";
            $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)";
            $sql .= "   GROUP BY t_stock_hand.goods_id";
            $sql .= "   ) AS t_stock_io ON t_goods.goods_id=t_stock_io.goods_id";

            $sql .= "   LEFT JOIN";
            $sql .= "   (SELECT";
            $sql .= "       t_stock_hand.goods_id,";
            $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS allowance_io_num";
            $sql .= "   FROM";
            $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
            $sql .= "   WHERE";
            $sql .= "       t_stock_hand.work_div = 1";
            $sql .= "   AND";
            $sql .= "       t_stock_hand.client_id = $shop_id";
            $sql .= "   AND";
            $sql .= "       t_ware.count_flg = 't'";
            $sql .= "   AND";
            $sql .= "       t_stock_hand.work_day >= (CURRENT_DATE + $designated_date)";
            $sql .= "   GROUP BY t_stock_hand.goods_id";
            $sql .= "   ) AS t_allowance_io ON t_goods.goods_id = t_allowance_io.goods_id";

            $sql .= " WHERE ";
            $sql .= "       t_goods.goods_id = $ary_goods_id[$i]";
            $sql .= " AND ";
            $sql .= "       t_goods.public_flg = 't' ";
            $sql .= " AND ";
            $sql .= "       initial_cost.rank_cd = '1' ";
            $sql .= " AND ";
            $sql .= "       sale_price.rank_cd = ";
            $sql .= "       (SELECT ";
            $sql .= "           rank_cd ";
            $sql .= "       FROM ";
//          $sql .= "           t_shop_gr ";
            $sql .= "           t_client ";
            $sql .= "       WHERE ";
//          $sql .= "           shop_gid = $attach_gid);";
            $sql .= "           shop_id  = $attach_gid);";

            $result = Db_Query($db_con, $sql);
            $goods_data = pg_fetch_array($result);

            $set_designated_data["hdn_goods_id"][$i]         = $goods_data[0];   //����ID Product ID
            $set_designated_data["form_stock_num"][$i]       = $goods_data[1];   //��ê�� actual shelf number
            $set_designated_data["hdn_stock_num"][$i]        = $goods_data[1];   //��ê����hidden�� ��hidden��actual shelf number 
            $stock_num[$i]                                   = $goods_data[1];   //��ê��(��󥯤���) actual shelf number (link's value)

            $set_designated_data["form_rorder_num"][$i]      = $goods_data[2];   //ȯ��ѿ� outstanding purchase order
            $set_designated_data["form_rstock_num"][$i]      = $goods_data[3];   //������ number of product resereved for order
            $set_designated_data["form_designated_num"][$i]  = $goods_data[4];   //�вٲ�ǽ�� deliverable number of units of product
        }
    }

    //�вٲ�ǽ�����ϥե饰�˶���򥻥å� set blank in the input deliverable number of units of product flag
    $set_designated_data["recomp_flg"] = "";
    $form->setConstants($set_designated_data);
}

/****************************/
//���顼�����å�(addRule) error check (addRule)
/****************************/
//������ customer

//�вٲ�ǽ�� deliverable number of units of product
$form->addRule("form_designated_date","ȯ��ѿ��Ȱ��������θ����������Ⱦ�ѿ��ͤΤߤǤ���","regex", '/^[0-9]+$/');

//������ sales order date
//��ɬ�ܥ����å� required field
//��Ⱦ�ѿ��������å� check if half-width
$form->addGroupRule('form_ord_day', array(
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

//����ͽ���� scheduled delivery date
//��Ⱦ�ѿ��������å� check if half-width
$form->addGroupRule('form_arr_day', array(
        'y' => array(
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���', 'required'),
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���', 'numeric')
        ),
        'm' => array(
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���', 'required'),
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���','numeric')
        ),
        'd' => array(
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���', 'required'),
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���','numeric')
        ),
));

//�в��Ҹ� outbound warehouse
//��ɬ�ܥ����å� required field 
$form->addRule("form_ware_select","�в��Ҹˤ����򤷤Ƥ���������","required");

//�����ʬ trade classification
//��ɬ�ܥ����å� required field 
$form->addRule("trade_aord_select","�����ʬ�����򤷤Ƥ���������","required");

//ô���� assigned staff 
//��ɬ�ܥ����å� required field
$form->addRule("form_staff_select","ô���Ԥ����򤷤Ƥ���������","required");

//�̿������������ communication field (HQ)
//��ʸ���������å� check the number of letter.
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_client","�̿���������谸�ˤ�50ʸ������Ǥ���","mb_maxlength","50");

/****************************/
//����ܥ��󲡲�����process for when the slaes order button is pressed
/****************************/
if($_POST["order"] == "������" || $_POST["order_conf"] == "�����ǧ���̤�" ){
    //�إå������� header info
    $ord_no               = $_POST["form_order_no"];           //�����ֹ� slaes order no.
    $designated_date      = $_POST["form_designated_date"];    //�вٲ�ǽ�� deliverable number of units of product
    $ord_day_y            = $_POST["form_ord_day"]["y"];       //������ sales order date
    $ord_day_m            = $_POST["form_ord_day"]["m"];            
    $ord_day_d            = $_POST["form_ord_day"]["d"];            
    $hope_day_y           = $_POST["form_hope_day"]["y"];      //��˾Ǽ�� desired delivery date
    $hope_day_m           = $_POST["form_hope_day"]["m"];           
    $hope_day_d           = $_POST["form_hope_day"]["d"];           
    $arr_day_y            = $_POST["form_arr_day"]["y"];       //����ͽ���� scheduled deliver date
    $arr_day_m            = $_POST["form_arr_day"]["m"];            
    $arr_day_d            = $_POST["form_arr_day"]["d"];            
    $client_cd1           = $_POST["form_client"]["cd1"];      //������CD1 customer CD1
    $client_cd2           = $_POST["form_client"]["cd2"];      //������CD2 customer CD2
    $client_name          = $_POST["form_client"]["name"];     //������̾ customer name
    $note_client          = $_POST["form_note_client"];        //�̿����������� communication field (customer)
    $note_head            = $_POST["form_note_head"];          //�̿���������� communication field (Hq)
    $trans_check          = $_POST["form_trans_check"];        //���꡼����� green designation
    $trans_id             = $_POST["form_trans_select"];       //�����ȼ� carrier
    $direct_id            = $_POST["form_direct_select"];      //ľ���� direct destination
    $ware_id              = $_POST["form_ware_select"];        //�Ҹ� warehouse
    $trade_aord           = $_POST["trade_aord_select"];       //�����ʬ trade classification
    $c_staff_id           = $_POST["form_staff_select"];       //ô���� assigned staff

    //�ǡ������� data info
    $j = 0;
    for($i = 0; $i < $max_row; $i++){
        if($_POST["form_goods_name"][$i] != null){
            $goods_id[$j]         = $_POST["hdn_goods_id"][$i];                         //����ID product Id
            $goods_cd[$j]         = $_POST["form_goods_cd"][$i];                        //����CD product code
            $goods_name[$j]       = $_POST["form_goods_name"][$i];                      //����̾ product name
            $sale_num[$j]         = $_POST["form_sale_num"][$i];                        //����� ordered number of units
            $cost_price_i[$j]     = $_POST["form_cost_price"][$i]["i"];                 //����ñ������������ product cost per unit (integer part)
            $cost_price_d[$j]     = $_POST["form_cost_price"][$i]["d"];                 //����ñ���ʾ�������product cost per unit (decimal part)
            $sale_price_i[$j]     = $_POST["form_sale_price"][$i]["i"];                 //���ñ������������product selling price per unit (integer part)
            $sale_price_d[$j]     = $_POST["form_sale_price"][$i]["d"];                 //���ñ���ʾ�������product selling per unit (decimal)
            $tax_div[$j]          = $_POST["hdn_tax_div"][$i];                          //���Ƕ�ʬ tax classification
            $stock_manage_flg[$j] = $_POST["hdn_stock_manage"][$i];                     //�߸˴��� inventory control
            $cost_amount[$j]      = str_replace(',','',$_POST["form_cost_amount"][$i]); //������� total cost
            $sale_amount[$j]      = str_replace(',','',$_POST["form_sale_amount"][$i]); //����� total selling price
            $j++;

        }
    }

    /****************************/
    //���顼�����å�(PHP) error check (PHP)
    /****************************/
    $error_flg = false;                                         //���顼Ƚ��ե饰 deciding error flag

    //������������å�check product selection
    for($i = 0; $i < count($goods_id); $i++){
        if($goods_name[$i] != null){
           $input_error_flg = true;
        }
    }
    if($input_error_flg != true){
        $goods_error0 ="���ʤ���Ĥ����򤵤�Ƥ��ޤ���";
        $error_flg = true;
    }

    //�������� sales order date
    //��ʸ��������å� check string type
    if($ord_day_y != null && $ord_day_m != null && $ord_day_d != null){
        $ord_day_y = (int)$ord_day_y;
        $ord_day_m = (int)$ord_day_m;
        $ord_day_d = (int)$ord_day_d;
        if(!checkdate($ord_day_m,$ord_day_d,$ord_day_y)){
            $form->setElementError("form_ord_day","������ �����դ������ǤϤ���ޤ���");
        }else{
            $err_msge = Sys_Start_Date_Chk($ord_day_y, $ord_day_m, $ord_day_d, "������");
            if($err_msge != null){
                $form->setElementError("form_ord_day","$err_msge");
            }
        }       
    }

    //������ͽ���� desired delivery date
    //��ʸ��������å� check string type
    if($arr_day_y != null || $arr_day_m != null || $arr_day_d != null){
        $arr_day_y = (int)$arr_day_y;
        $arr_day_m = (int)$arr_day_m;
        $arr_day_d = (int)$arr_day_d;
        if(!checkdate($arr_day_m,$arr_day_d,$arr_day_y)){
            $form->setElementError("form_arr_day","����ͽ���� �����դ������ǤϤ���ޤ���");
        }else{
            $err_msge = Sys_Start_Date_Chk($arr_day_y, $arr_day_m, $arr_day_d, "������");
            if($err_msge != null){
                $form->setElementError("form_arr_day","$err_msge");
            }

            $arr_day_y = str_pad($arr_day_y, 4, "0", STR_PAD_LEFT);
            $arr_day_m = str_pad($arr_day_m, 2, "0", STR_PAD_LEFT);
            $arr_day_d = str_pad($arr_day_d, 2, "0", STR_PAD_LEFT);
            $arr_day_ymd = $arr_day_y.$arr_day_m.$arr_day_d;

            $ord_day_y = str_pad($ord_day_y, 4, "0", STR_PAD_LEFT);
            $ord_day_m = str_pad($ord_day_m, 2, "0", STR_PAD_LEFT);
            $ord_day_d = str_pad($ord_day_d, 2, "0", STR_PAD_LEFT);
            $ord_day_ymd = $ord_day_y.$ord_day_m.$ord_day_d;

            if($arr_day_ymd < $ord_day_ymd){
                $form->setElementError("form_arr_day","�в�ͽ�����ϼ������ʹߤ����դ���ꤷ�Ƥ���������");
            }       
        }
    }
    
    //���ʥ����å� product check 
    //���ʽ�ʣ�����å�product duplication check
    for($i = 0; $i < count($goods_id); $i++){
        for($j = 0; $j < count($goods_id); $j++){
            if($i != $j && $goods_id[$i] == $goods_id[$j]){
                $goods_error1 = "Ʊ�����ʤ��������򤵤�Ƥ��ޤ���";
//                $error_flg = true;
            }
        }
    }

    //���ʥ����å� product check 
    //�����������ñ�������ñ�������ϥ����å� number of sales order, cost price per unit, sales price per unit, input check 
    for($i = 0; $i < count($goods_id); $i++){
        if($goods_id[$i] != null && ($sale_num[$i] == null || $cost_price_i[$i] == null || $cost_price_d[$i] == null || $sale_price_i[$i] == null || $sale_price_d[$i] == null)){
            $goods_error2 = "�������Ϥ˼�����ȸ���ñ�������ñ����ɬ�ܤǤ���";
            $error_flg = true;
        }

        //�����Ⱦ�ѿ��������å� check if number of sales order is inputted in halfwidth number
        if(!ereg("^[0-9]+$",$sale_num[$i]) && $sale_num[$i] != null){
            $goods_error3 = "�������Ⱦ�ѿ����ΤߤǤ���";
            $error_flg = true;
        }


        #2009-10-13 hashimoto-y 
        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");
        #echo $hdn_discount_flg ."<br>";

        if($hdn_discount_flg === 't'){

            //����ñ��Ⱦ�ѿ��������å� check if cost per unit of product is inputted in halfwidth number
            if(!ereg("^[-0-9]+$",$cost_price_i[$i]) || !ereg("^[0-9]+$",$cost_price_d[$i])){
                $goods_error4 = "����ñ���ϡ�-�פ�Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                $error_flg = true;
            }elseif($cost_price_i[$i] > 0){
                $goods_error4 = "���ʤ��Ͱ�����ꤷ����硢����ñ���ϣ��ʲ��ο��ͤΤ����ϲ�ǽ�Ǥ���";
                $error_flg = true;
            }

            //���ñ��Ⱦ�ѿ��������å� check if selling price per unit is inputted in halfwidth number
            if(!ereg("^[-0-9]+$",$sale_price_i[$i]) || !ereg("^[0-9]+$",$sale_price_d[$i])){
                $goods_error5 = "���ñ���ϡ�-�פ�Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���";
                $error_flg = true;
            }elseif($sale_price_i[$i] > 0){
                $goods_error5 = "���ʤ��Ͱ�����ꤷ����硢���ñ���ϣ��ʲ��ο��ͤΤ����ϲ�ǽ�Ǥ���";
                $error_flg = true;
            }

        }else{

            //����ñ��Ⱦ�ѿ��������å� check if cost per unit of product is inputted in halfwidth number
            if(!ereg("^[0-9]+$",$cost_price_i[$i]) || !ereg("^[0-9]+$",$cost_price_d[$i])){
                $goods_error4 = "����ñ����Ⱦ�ѿ����ΤߤǤ���";
                $error_flg = true;
            }

            //���ñ��Ⱦ�ѿ��������å� check if selling price per unit is inputted in halfwidth number
            if(!ereg("^[0-9]+$",$sale_price_i[$i]) || !ereg("^[0-9]+$",$sale_price_d[$i])){
                $goods_error5 = "���ñ����Ⱦ�ѿ����ΤߤǤ���";
                $error_flg = true;
            }
        }

    }

    //���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ� do not do anymore view process if error occurs
    if($form->validate() && $error_flg == false){

        //��������� array for sales price
        $sale_money = $_POST["form_sale_amount"];
        //���Ƕ�ʬ���� array for the tax amount classification
        $tax_div    = $_POST["hdn_tax_div"];

        //���ߤξ�����Ψ current consumption tax rate
        #2009-12-21 aoyama-n
        #$sql  = "SELECT ";
        #$sql .= "    tax_rate_n ";
        #$sql .= "FROM ";
        #$sql .= "    t_client ";
        #$sql .= "WHERE ";
        #$sql .= "    client_id = $client_id;";
        #$result = Db_Query($db_con, $sql); 
        #$tax_num = pg_fetch_result($result, 0,0);

        #2009-12-21 aoyama-n
        $tax_rate_obj->setTaxRateDay($ord_day_y."-".$ord_day_m."-".$ord_day_d);
        $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

        $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num,$client_id, $db_con);
        $sale_money  = $total_money[0];
        $sale_tax    = $total_money[1];

        //���դη����ѹ� changethe format of the date
        $ord_day  = $ord_day_y."-".$ord_day_m."-".$ord_day_d;
        if($hope_day_y != null){
            $hope_day = $hope_day_y."-".$hope_day_m."-".$hope_day_d;
        }
        if($arr_day_y != null){
            $arr_day  = $arr_day_y."-".$arr_day_m."-".$arr_day_d;
        }
        //����إå�������ǡ�������Ͽ������SQL sales order header, sales order data, register/updateSQL
        Db_Query($db_con, "BEGIN");

        //��Ͽ�ܥ��󤬲����줿��� if registered button is pressed
        if($_POST["order"] == "������"){

            //�ѹ�����Ƚ�� decide on edit process 
            if($aord_id != NULL){
                //����إå����ѹ� edit sales order header
                $sql  = "UPDATE t_aorder_h SET ";
                $sql .= "    ord_time = '$ord_day',";
                $sql .= "    trade_id = '$trade_aord',";
                //�����ȼԤ����ꤵ��Ƥ��뤫 is the carrier being selected?
                if($trans_id != null){
                    $sql .= "    trans_id = $trans_id,";
                }
                //�����å��ͤ�boolean���ѹ� change the check value to boolean value
                if($trans_check==1){
                    $sql .= "green_flg = true,";    
                }else{
                    $sql .= "green_flg = false,";    
                }
                //�в�ͽ���������ꤵ��Ƥ��뤫 is the scheduled delivery date selected?
                if($arr_day != null){
                    $sql .= "    arrival_day = '$arr_day',";
                }
                //$sql .= "    note_my = '$note_head',";
                $sql .= "    note_your = '$note_client',";
                $sql .= "    net_amount = $sale_money,";    
                $sql .= "    tax_amount = $sale_tax,";    
                $sql .= "    c_staff_id = $c_staff_id,";
                $sql .= "    ware_id = $ware_id,";
                $sql .= "    ord_staff_id = $o_staff_id, ";
                $sql .= ($trans_id != NULL) ? " trans_name = (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), " : " trans_name = NULL, ";
                $sql .= ($trans_id != NULL) ? " trans_cname = (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id) " : " trans_cname = NULL, ";
                $sql .= "    change_day = CURRENT_TIMESTAMP ";
                $sql .= "WHERE ";
                $sql .= "    aord_id = $aord_id;";

                $result = Db_Query($db_con,$sql);
                if($result == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }

                //����ǡ������� delete the sales order data
                $sql  = "DELETE FROM";
                $sql .= "    t_aorder_d";
                $sql .= " WHERE";
                $sql .= "    aord_id = $aord_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }
            }

            //����ǡ�����Ͽ register the sales order data
            for($i = 0; $i < count($goods_id); $i++){
                //�� row
                $line = $i + 1;

                //�����ѹ� change the format
                $c_price = $cost_price_i[$i].".".$cost_price_d[$i];   //������� cost price
                $s_price = $sale_price_i[$i].".".$sale_price_d[$i];   //����� sales price

                $total_tax = Total_Amount($sale_amount[$i], $tax_div[$i],$coax,$tax_franct,$tax_num, $client_id, $db_con);
          
                //�����ǳ� consumption tax amount
                $t_price = $total_tax[1];

                $sql  = "INSERT INTO t_aorder_d (";
                $sql .= "    aord_d_id,";
                $sql .= "    aord_id,";
                $sql .= "    line,";
                $sql .= "    goods_id,";
                $sql .= "    goods_cd,";
                //$sql .= "    goods_name,";
                $sql .= "    official_goods_name,";
                $sql .= "    num,";
                $sql .= "    tax_div,";
                $sql .= "    cost_price,";
                $sql .= "    cost_amount,";
                $sql .= "    sale_price,";
                $sql .= "    sale_amount";
                $sql .= ")VALUES(";
                $sql .= "    (SELECT COALESCE(MAX(aord_d_id), 0)+1 FROM t_aorder_d),";  
                $sql .= "    (SELECT";
                $sql .= "         aord_id";
                $sql .= "     FROM";
                $sql .= "        t_aorder_h";
                $sql .= "     WHERE";
                $sql .= "        ord_no = '" .$h_data_list[0][0] ."'";
                $sql .= "        AND";
                $sql .= "        shop_id = $shop_id";
                $sql .= "    ),";
                $sql .= "    '$line',";
                $sql .= "    $goods_id[$i],";
                $sql .= "    '$goods_cd[$i]',";
                $sql .= "    '$goods_name[$i]',"; 
                $sql .= "    '$sale_num[$i]',";
                $sql .= "    '$tax_div[$i]',";
                $sql .= "    $c_price,";
                $sql .= "    $cost_amount[$i],";
                $sql .= "    $s_price,";
                $sql .= "    $sale_amount[$i]";
                $sql .= ");";

                $result = Db_Query($db_con, $sql);

                if($result == false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }
            }

            for($i = 0; $i < count($goods_id); $i++){
                $line = $i + 1;

                if($stock_manage_flg[$i] == '1'){
                    //����ʧ���ơ��֥����Ͽ register it in receipts and payment table 
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
                    $sql .= "    aord_d_id,";
                    $sql .= "    staff_id,";
                    $sql .= "    shop_id,";
                    $sql .= "    client_cname";
                    $sql .= ")VALUES(";
                    $sql .= "    $goods_id[$i],";
                    $sql .= "    NOW(),";
                    $sql .= "    '$ord_day',";
                    $sql .= "    '1',";
                    $sql .= "    $client_id,";
                    $sql .= "    $ware_id,";
                    $sql .= "    '2',";
                    $sql .= "    $sale_num[$i],";
                    $sql .= "    '$ord_no',";
                    $sql .= "    (SELECT";
                    $sql .= "        aord_d_id";
                    $sql .= "    FROM";
                    $sql .= "        t_aorder_d";
                    $sql .= "    WHERE";
                    $sql .= "        line = $line";
                    $sql .= "        AND";
                    $sql .= "        aord_id = (SELECT";
                    $sql .= "                    aord_id";
                    $sql .= "                 FROM";
                    $sql .= "                    t_aorder_h";
                    $sql .= "                 WHERE";
                    $sql .= "                    ord_no = '".$h_data_list[0][0] ."'";
                    $sql .= "                    AND";
                    $sql .= "                    shop_id = $shop_id";
                    $sql .= "                )";
                    $sql .= "    ),";
                    $sql .= "    $o_staff_id,";
                    $sql .= "    $shop_id,";
                    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                    $sql .= ");";

                    $result = Db_Query($db_con, $sql);
                    if($result == false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }
                }
            }

            Db_Query($db_con, "COMMIT");
            header("Location: ./1-2-108.php?aord_id=$aord_id&input_flg=true");
        }else{
            $freeze_flg = true;
            $form->freeze();
        }
    }
}

/****************************/
//���ʺ����ʲ��ѡ� create component (variable)
/****************************/
//���ֹ楫���� row number counter
$row_num = 1;

for($i = 0; $i < $max_row; $i++){
    //ɽ����Ƚ�� decide row view 
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;


        #2009-10-13 hashimoto-y
        //�Ͱ����ʤ����򤷤����ˤ��ֻ����ѹ� If discounted product was selected make it a net loss
        $font_color = "";

        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

        if($hdn_discount_flg === 't'){
            $font_color = "color: red; ";
        }else{
            $font_color = "color: #000000; ";
        }


        //���ʥ����� product code      
        $form->addElement(
            "text","form_goods_cd[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: left\" readonly'"
        );
      
        //����̾ product name
        $form->addElement(
            "text","form_goods_name[$i]","",
            "size=\"52\" maxLength=\"41\" 
            style=\"$font_color
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: left\" readonly'"
        );

        //��ê�� actual shelf number
        //�߸˴���Ƚ�� decide inventory control
        if($no_goods_flg!=true && ($_POST["hdn_stock_manage"][$i] == '1' || $hdn_stock_manage[$i] == '1')){
            //ͭ exist

            //POST�������ΤȤ��ʳ��ϡ�hidden���ͤ���Ѥ���(��ê��) use the hidden value (actual shelf number) except before POST
            if($_POST["hdn_stock_num"][$i] != NULL){
                $hdn_num = $_POST["hdn_stock_num"][$i];
            }else{
                $hdn_num = $stock_num[$i];
            }
            //POST�������ΤȤ��ʳ��ϡ�hidden���ͤ���Ѥ���(����ID) use the hidden value (Product ID) except before POST
            if($_POST["hdn_goods_id"][$i] != NULL){
                if($_POST["hdn_goods_id"][$i] == $hdn_goods_id[$i]){
                    $hdn_id = $_POST["hdn_goods_id"][$i];
                }else{
                    $hdn_id = $hdn_goods_id[$i];
                }
            }else{
                $hdn_id = $hdn_goods_id[$i];
            }
//            $form->addElement("link","form_stock_num[$i]","","#","$hdn_num","onClick=\"Open_mlessDialog_g('1-2-107.php',$hdn_id,$client_id,300,160);\"");
            $form->addElement("link","form_stock_num[$i]","","#","$hdn_num","onClick=\"Open_mlessDialmg_g('1-2-107.php',$hdn_id,$client_id,300,160);\"");
        }else if($no_goods_flg!=true && ($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2')){
            //̵ non-exist
            #2009-10-13 hashimoto-y
            #$form->addElement("static","form_stock_num[$i]","#","-","");

            $form->addElement(
                "text","form_stock_num[$i]","",
                "size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
            $form->setConstants(array("form_stock_num[$i]" => "-"));

        $form->addElement(
            "text","form_goods_name[$i]","",
            "size=\"52\" maxLength=\"41\" 
            style=\"$font_color
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: left\" readonly'"
        );
        }else{
            $form->addElement(
                "text","form_stock_num[$i]","",
                "size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
        }

        //ȯ��ѿ� number of pruchase orders ordered 
        //�߸˴���Ƚ�� decision on inventory control
        if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
            //̵ non-exist
            #2009-10-13 hashimoto-y
            #$form->addElement("static","form_rorder_num[$i]","#","-","");

            $form->addElement(
                "text","form_rorder_num[$i]","",
                "class=\"money\" size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
            $form->setConstants(array("form_rorder_num[$i]" => "-"));

        }else{
            $form->addElement(
                "text","form_rorder_num[$i]","",
                "class=\"money\" size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
        }

        //������ number of unit of stocks reserved 
        //�߸˴���Ƚ�� decision on inventory control
        if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
            //̵
            #2009-10-13 hashimoto-y
            #$form->addElement("static","form_rstock_num[$i]","#","-","");

            $form->addElement("text","form_rstock_num[$i]","",
                "class=\"money\" size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
            $form->setConstants(array("form_rstock_num[$i]" => "-"));

        }else{
            $form->addElement("text","form_rstock_num[$i]","",
                "class=\"money\" size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
        }

        //�вٲ�ǽ�� deliverable number of units of stocks
        if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
            //̵ non-exist
            #2009-10-13 hashimoto-y
            #$form->addElement("static","form_designated_num[$i]","#","-","");

            $form->addElement("text","form_designated_num[$i]","",
                "class=\"money\" size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
            $form->setConstants(array("form_designated_num[$i]" => "-"));

        }else{
            $form->addElement("text","form_designated_num[$i]","",
                "class=\"money\" size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
            );
        }

        //����� sales order
        $form->addElement(
            "text","form_sale_num[$i]","",
            "class=\"money\" size=\"11\" maxLength=\"9\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
        );

        //����ñ�� cost price per unit
        $form_cost_price[$i][] =& $form->createElement(
            "text","i","",
            "size=\"11\" maxLength=\"9\"
            class=\"money\"
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
        );
        $form_cost_price[$i][] =& $form->createElement("static","","",".");
        $form_cost_price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\" 
                style=\"$font_color 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'"
        );
        $form->addGroup( $form_cost_price[$i], "form_cost_price[$i]", "");

        //������� total cost price
        $form->addElement(
            "text","form_cost_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$g_form_style; $font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );
        
        //���ñ�� sales price per unit
        $form_sale_price[$i][] =& $form->createElement(
            "text","i","",
            "size=\"11\" maxLength=\"9\"
            class=\"money\"
            style=\"$g_form_style; $font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );
        $form_sale_price[$i][] =& $form->createElement("static","","",".");
        $form_sale_price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\" 
            style=\"$g_form_style; $font_color
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );
        $form->addGroup( $form_sale_price[$i], "form_sale_price[$i]", "");

        //����� total sales
        $form->addElement(
            "text","form_sale_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$g_form_style; $font_color
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //������� search link
        $form->addElement(
            "link","form_search[$i]","","#","����",
            "onClick=\"return Open_SubWin('../dialog/1-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,5,1,$i);\""
        );

        //������ delete link 
        //1.0.4 (2006/03/29) kaji ��ǧ���������Υ���󥻥�ܥ��󲡲����Ǥ���Ͽ����Ƥ��ޤ��Х��к� bug fix for when the user can register after clicking cancel in the confirmation message box
        $form->addElement(
            "link","form_del_row[$i]","",
            "#","���","onClick=\"return Dialogue_1('������ޤ���', '$del_data', 'del_row');\""
        ); 

        //����ID productID
        $form->addElement("hidden","hdn_goods_id[$i]");
        //���Ƕ�ʬ tax classification
        $form->addElement("hidden", "hdn_tax_div[$i]");
        //��̾�ѹ��ե饰 change product name flag
        $form->addElement("hidden","hdn_name_change[$i]");
        //�߸˴��� inventory control
        $form->addElement("hidden","hdn_stock_manage[$i]");
        //��ê�� actual shelf number
        $form->addElement("hidden","hdn_stock_num[$i]");

        /****************************/
        //ɽ����HTML���� create HTML for display
        /****************************/
        if($freeze_flg == true && $hdn_discount_flg === 't'){
            $html .= "<tr class=\"Result1\">";
            $html .=    "<td align=\"right\">$row_num</td>";
            $html .=    "<td align=\"left\" style=\"color: red\">";
            $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
            $html .=    "<br>";
            $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
            $html .=    "</td>";
            $html .= "  <td align=\"right\" style=\"color: red\">";
            $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\" style=\"color: red\">";
            $html .=        $form->_elements[$form->_elementIndex["form_rorder_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\" style=\"color: red\">";
            $html .=        $form->_elements[$form->_elementIndex["form_rstock_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\" style=\"color: red\">";
            $html .=        $form->_elements[$form->_elementIndex["form_designated_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .=    "<td align=\"right\" style=\"color: red\">";
            $html .=        $form->_elements[$form->_elementIndex["form_sale_num[$i]"]]->toHtml();
            $html .=    "</td>";
            $html .=    "<td align=\"right\" style=\"color: red\">";
            $html .=        $form->_elements[$form->_elementIndex["form_cost_price[$i]"]]->toHtml();
            $html .=    "<br>";
            $html .=        $form->_elements[$form->_elementIndex["form_sale_price[$i]"]]->toHtml();
            $html .=    "</td>";
            $html .=    "<td align=\"right\" style=\"color: red\">";
            $html .=        $form->_elements[$form->_elementIndex["form_cost_amount[$i]"]]->toHtml();
            $html .=    "<br>";
            $html .=        $form->_elements[$form->_elementIndex["form_sale_amount[$i]"]]->toHtml();
            $html .=    "</td>";
            $html .= "</tr>";
        }else{
            $html .= "<tr class=\"Result1\">";
            $html .=    "<td align=\"right\">$row_num</td>";
            $html .=    "<td align=\"left\">";
            $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
            $html .=    "<br>";
            $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
            $html .=    "</td>";
            $html .= "  <td align=\"right\">";
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
            $html .= "</tr>";
        }

        //���ֹ��ܣ� +1 in row number
        $row_num = $row_num+1;
    }
}

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
$page_menu = Create_Menu_h('sale','1');
/****************************/
//���̥إå������� create screen header
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assifn form related variable
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assign other variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'warning'       => "$warning",
    'html'          => "$html",
    'goods_error0'  => "$goods_error0",
    'goods_error1'  => "$goods_error1",
    'goods_error2'  => "$goods_error2",
    'goods_error3'  => "$goods_error3",
    'goods_error4'  => "$goods_error4",
    'goods_error5'  => "$goods_error5",
    'aord_id'       => "$aord_id",
    'duplicate_err' => "$error",
    'form_potision' => "$form_potision",
    'auth_r_msg'    => "$auth_r_msg",
    'freeze_flg'    => "$freeze_flg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
