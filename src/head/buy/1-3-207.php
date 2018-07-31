<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * 2007/01/25                  watanabe-k  �ܥ���ο��ѹ�  
 * 2007/02/28                  morita-d  ����̾������̾�Τ�ɽ������褦���ѹ� 
 * 2007/03/09    ��˾9-1       kajioka-h   ���������ѹ�����Ȼ��������Ѥ��褦���ѹ�
 * 2007/03/13                  watanabe-k  �����ʬ��������ξ�����������褦�˽���
 * 2007/03/13                  watanabe-k  ���ʤν�ʣ���顼�����Ū�����򤹤�褦�˽���
 * 2007/05/18                  watanabe-k  ľ����Υץ��������ѹ�
 * 2007/06/10                  watanabe-k  ȯ���鵯������������ǹ��ɲä��ǽ�ˤ��� 
 * 2007/06/29                   fukuda      ���ͤ����ϥե�������礭������
 * 2007-07-12                  fukuda      �ֻ�ʧ���פ�ֻ������פ��ѹ�
 * 2007-07-13                  watanabe-k  0�����ηٹ�ɽ�������Х��ν���
 * 2007-08-28                  watanabe-k  ��������ȯ�������ä�����ȯ��Ĥ��Ǿä�������������ǹԤʤ鷺��ȯ����ǹԤʤ���
 * 2007-12-01                  watanabe-k  ʣ����������Ԥ�����ȯ��Ĥ�¿���Ǿä����Ƥ��ޤ��Х��ν���
 * 2009-09-01                  aoyama-n    �Ͱ���ǽ�ɲ� 
 * 2009-09-15                  aoyama-n    �����ʬ���Ͱ������ʤ�����Ͱ����ʤ��ֻ���ɽ��
 * 2009/09/28      �ʤ�        hashimoto-y �����ʬ�����Ͱ������ѻ�
 * 2009/10/13                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 * 2009/10/19      �ʤ�        hashimoto-y ȯ��Ĥ������ܤ������ˡ�����ñ�����ѹ��Ǥ��ʤ��Х�����
 * 2009/10/20      �ʤ�        hashimoto-y 10-19�ν����ΥХ��ʾ��ʥ����ɤ����ϤǤ����
 * 2009/12/21      �ʤ�        aoyama-n    ��Ψ��TaxRate���饹������� 
 *   2016/01/22                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б� 
 */

$page_title = "��������";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_motocho.inc");
require_once(INCLUDE_DIR."function_buy.inc");
//print_array($_POST);

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
//�����ѿ�����
/*****************************/
$shop_id  = $_SESSION["client_id"];
$rank_cd  = $_SESSION["rank_cd"];
$staff_id = $_SESSION["staff_id"];


/*****************************/
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST["form_buy_button"] == null && $_POST["form_comp_button"] == null){
    Set_Rtn_Page("buy");
}


/*****************************/
//���ɽ������
/*****************************/

#2009-12-21 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($shop_id);

//��ư���֤�ȯ���ֹ����
$sql  = "SELECT";
$sql .= "   MAX(buy_no)";
$sql .= " FROM";
$sql .= "   t_buy_h";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= ";"; 

$result = Db_Query($db_con, $sql);
$order_no = pg_fetch_result($result, 0 ,0);
$order_no = $order_no +1;
$order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

$def_data["form_buy_no"] = $order_no;

//�Ҹ�
//�Ҹˤ����򤵤�Ƥ��������Ҹ�����ե饰��Ω�Ƥ�
$ware_search_flg = ($_POST["form_ware"] != null)? true : false;

$sql  = "SELECT";
$sql .= "   ware_id";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_id = $shop_id";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$def_ware_id = pg_fetch_result($result ,0,0);
if($def_ware_flg != null){
    $ware_search_flg = true;
}

$def_data["form_ware"] = $def_ware_id;

//�вٲ�ǽ��
$def_data["form_designated_date"] = 7;

//ô����
$def_data["form_buy_staff"] = $staff_id;

//�����ʬ
$def_data["form_trade"] = 21;

// ������
$def_data["form_arrival_day"]["y"] = date("Y");
$def_data["form_arrival_day"]["m"] = date("m");
$def_data["form_arrival_day"]["d"] = date("d");

// ������
$def_data["form_buy_day"]["y"] = date("Y");
$def_data["form_buy_day"]["m"] = date("m");
$def_data["form_buy_day"]["d"] = date("d");

$form->setDefaults($def_data);

//���ɽ�������ѹ�
$form_potision = "<body bgcolor=\"#D8D0C8\">";

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
#$rate  = bcdiv($tax_rate,100,2);        //������Ψ

//�ǡ���ɽ���Կ�
if($_POST["max_row"] != NULL){
    $max_row = $_POST["max_row"];
//���ɽ���Τ�
}else{
    $max_row = 5;
}

//������ID��̵ͭ�ˤ�ꡢ�������������
$client_search_flg = ($_POST["hdn_client_id"] != NULL)? true : false;

if($client_search_flg == true){
    //������ξ�������
    $client_id  = $_POST["hdn_client_id"];      //������ID
    $coax       = $_POST["hdn_coax"];           //�ݤ��ʬ
    $tax_franct = $_POST["hdn_tax_franct"];     //ü����ʬ
}else{
    $client_search_flg = false;
}

//ȯ��ID������С�ȯ��ե饰��Ω�Ƥ�
$order_flg = ($_POST["hdn_order_id"] != null)? true : false;

if($order_flg == true){
     $order_id = $_POST["hdn_order_id"];
}

//����Կ�
$del_history[] = NULL;

//Submit�������˻����ޤ��ǡ���
$goods_id       = $_POST["hdn_goods_id"];
$stock_manage   = $_POST["hdn_stock_manage"];
$name_change    = $_POST["hdn_name_change"];
$order_d_id     = $_POST["hdn_order_d_id"];

/****************************/
//�Ժ������
/****************************/
if($_POST["del_row"] != NULL){
    $now_form = NULL;    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];    //������������ˤ��롣
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

//���ʤ����򤵤줿��硢���ʸ����ե饰��true�򥻥å�
$goods_search_flg = ($_POST["hdn_goods_search_flg"] != NULL)? true : false;       //���ʸ����ե饰

//��ץܥ��󤬲������줿���
$sum_button_flg = ($_POST["hdn_sum_button_flg"] == 't')? true : false;            //��ץܥ��󲡲��ե饰

//�ѹ��ξ���ord_id��Get���ϤäƤ������ˡ��ѹ��ե饰��true�򥻥å�
$update_data_flg = ($_GET["buy_id"] != NULL)? true : false;                            //ȯ���ѹ��ե饰
Get_Id_Check3($_GET["buy_id"]);
$update_flg = ($_POST["hdn_buy_id"] != null)? true : false;
$get_buy_id = $_POST["hdn_buy_id"];

//ɽ���ܥ��󤬲������줿���
$show_button_flg = ($_POST["hdn_show_button_flg"] == "t")? true : false;   //ɽ���ܥ��󲡲��ե饰

//GET��ȯ��ID�����ä����
$get_ord_id_flg  = ($_GET["ord_id"] != null)? true : false;                     //ȯ��Ĥ�������ܥե饰
Get_Id_Check3($_GET["ord_id"]);
/****************************/
//��׽���
/****************************/
//��ץܥ��󲡲��ե饰��true�ξ��
if($sum_button_flg == true){

    $buy_data   = $_POST["form_buy_amount"];   //�������
    $price_data = NULL;                        //���ʤλ������
    $tax_div    = NULL;                        //���Ƕ�ʬ

    //������ۤι���ͷ׻�
    for($i=0;$i<$max_row;$i++){
        if($buy_data[$i] != "" && !in_array("$i", $del_history)){
            $price_data[] = $buy_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
        }       
    }

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_buy_day"]["y"]."-".$_POST["form_buy_day"]["m"]."-".$_POST["form_buy_day"]["d"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

    //���ɽ�������ѹ�
    $height = $max_row * 30;
    $form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";

    //�ե�������ͥ��å�
    $set_data["form_buy_money"]     = number_format($data[0]);
    $set_data["form_tax_money"]     = number_format($data[1]);
    $set_data["form_total_money"]   = number_format($data[2]);
    $set_data["hdn_sum_button_flg"] = "";   

/****************************/
//�����ѹ�����
/****************************/
}elseif($update_data_flg == true && $_POST[hdn_ware_select_flg] != 't' && $goods_search_flg == false){
    $get_buy_id = $_GET["buy_id"];

    //�����إå�
    $sql  = "SELECT\n";
    $sql .= "   t_buy_h.buy_id,\n";
    $sql .= "   t_buy_h.buy_no,\n";
    $sql .= "   t_order_h.ord_no,\n";
    $sql .= "   to_date(t_order_h.ord_time,'YYYY/mm/dd') AS ord_time ,\n";
    $sql .= "   t_order_h.arrival_day AS arrival_hope_day,\n";
    $sql .= "   t_client.client_id,\n";
    $sql .= "   t_client.client_cd1,\n";
    $sql .= "   t_client.client_cd2,\n";
//    $sql .= "   t_client.client_name,\n";
    $sql .= "   t_client.client_cname,\n";
    $sql .= "   t_client.tax_franct,\n";
    $sql .= "   t_client.coax,\n";
    $sql .= "   t_buy_h.direct_id\n,";
    $sql .= "   t_buy_h.ware_id,\n";
    $sql .= "   t_buy_h.trade_id,\n";
    $sql .= "   t_buy_h.c_staff_id,\n";
    $sql .= "   t_buy_h.note,\n";
    $sql .= "   t_buy_h.renew_flg,\n";
    $sql .= "   t_buy_h.ord_id,\n";
    $sql .= "   t_buy_h.buy_day,\n";
    $sql .= "   t_buy_h.arrival_day,\n";
    $sql .= "   t_buy_h.oc_staff_id,\n";
    $sql .= "   t_order_h.enter_day AS ord_enter_day,\n";
    $sql .= "   t_buy_h.enter_day AS buy_enter_day, \n";
    $sql .= "   t_order_h.change_day \n";
    $sql .= " FROM\n";
    $sql .= "   t_buy_h\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   t_order_h\n";
    $sql .= "   ON t_buy_h.ord_id = t_order_h.ord_id\n ";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_client\n";
    $sql .= "   ON t_buy_h.client_id = t_client.client_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_buy_h.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.buy_id = $get_buy_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.renew_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   t_buy_h.buy_div = '2'\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);

    Get_Id_Check($result);
    $buy_h_data = pg_fetch_array($result);

    $order_id = $buy_h_data["ord_id"];

    //ȯ��������ʬ��
    $order_date = explode("-",$buy_h_data["ord_time"]);

    //����ͽ������ʬ��
    $arrival_hope_date = explode("-",$buy_h_data["arrival_hope_day"]);

    //��������ʬ��
    $buy_date   = explode("-",$buy_h_data["buy_day"]);

    //��������ʬ��
    $arrival_date   = explode("-", $buy_h_data["arrival_day"]);

    $set_data["hdn_buy_id"]                     = $buy_h_data["buy_id"];        //����ID
    $set_data["form_buy_no"]                    = $buy_h_data["buy_no"];        //�����ֹ�
    $set_data["hdn_order_id"]                   = $buy_h_data["ord_id"];        //ȯ��ID
    $set_data["form_order_no"]                  = $buy_h_data["ord_no"];        //ȯ���ֹ�
    $set_data["form_order_day"]["y"]            = $order_date[0];               //ȯ������ǯ��
    $set_data["form_order_day"]["m"]            = $order_date[1];               //ȯ�����ʷ��
    $set_data["form_order_day"]["d"]            = $order_date[2];               //ȯ����������
    $set_data["form_arrival_hope_day"]["y"]     = $arrival_hope_date[0];        //����ͽ������ǯ��
    $set_data["form_arrival_hope_day"]["m"]     = $arrival_hope_date[1];        //����ͽ�����ʷ��
    $set_data["form_arrival_hope_day"]["d"]     = $arrival_hope_date[2];        //����ͽ����������
    $set_data["hdn_client_id"]                  = $buy_h_data["client_id"];     //������ID
    $set_data["form_client"]["cd1"]             = $buy_h_data["client_cd1"];   //������CD
    $set_data["form_client"]["cd2"]             = $buy_h_data["client_cd2"];   //������CD
    $set_data["form_client"]["name"]            = $buy_h_data["client_cname"];  //������̾
    $set_data["hdn_coax"]                       = $buy_h_data["coax"];          //�ݤ��ʬ
    $set_data["hdn_tax_franct"]                 = $buy_h_data["tax_franct"];    //ü����ʬ
    $set_data["form_direct"]                    = $buy_h_data["direct_id"];     //ľ����
    $set_data["form_ware"]                      = $buy_h_data["ware_id"];       //�Ҹ�
    $set_data["form_trade"]                     = $buy_h_data["trade_id"];      //�����ʬ
    $set_data["form_buy_staff"]                 = $buy_h_data["c_staff_id"];    //����ô����
    $set_data["form_note"]                      = $buy_h_data["note"];          //����
    $set_data["form_arrival_day"]["y"]          = $arrival_date[0];             //����ͽ������ǯ��
    $set_data["form_arrival_day"]["m"]          = $arrival_date[1];             //����ͽ�����ʷ��
    $set_data["form_arrival_day"]["d"]          = $arrival_date[2];             //����ͽ����������
    $set_data["form_buy_day"]["y"]              = $buy_date[0];                 //����ͽ������ǯ��
    $set_data["form_buy_day"]["m"]              = $buy_date[1];                 //����ͽ�����ʷ��
    $set_data["form_buy_day"]["d"]              = $buy_date[2];                 //����ͽ����������
    $set_data["form_order_staff"]               = $buy_h_data["oc_staff_id"];   //ȯ��ô����
    $set_data["hdn_ord_enter_day"]              = $buy_h_data["ord_enter_day"]; //ȯ��������
    $set_data["hdn_buy_enter_day"]              = $buy_h_data["buy_enter_day"]; //����������
    $set_data["hdn_ord_change_day"]             = $buy_h_data["change_day"];    //ȯ���ѹ�����

    //�ʹߤν����ǻ����ޤ��������ID
    $client_id  = $buy_h_data["client_id"];
    $tax_franct = $buy_h_data["tax_franct"];
    $coax       = $buy_h_data["coax"];

    //�����ǡ���
    $sql  = "SELECT\n";
    $sql .= "   t_buy_d.ord_d_id,\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_buy_d.goods_cd,\n";
    $sql .= "   t_buy_d.goods_name,\n";
    $sql .= "   t_goods.tax_div,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";

    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS stock_num,\n";
    $sql .= "   t_order_d.num AS order_num,\n";
    $sql .= "   t_buy_d.num AS buy_num,\n";
    $sql .= "   t_buy_d.buy_price,\n";
    $sql .= "   t_buy_d.buy_amount,\n";
    $sql .= "   CASE\n";
    $sql .= "       WHEN t_order_d.num IS NOT NULL THEN t_order_d.num - COALESCE(t_buy_d.num,0)\n";
    $sql .= "   END AS on_order_num,\n";
    $sql .= "   t_goods.name_change,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";

    //aoyama-n 2009-09-01
    #$sql .= "   t_goods.in_num\n";
    $sql .= "   t_goods.in_num,\n";
    $sql .= "   t_goods.discount_flg\n";
    $sql .= " FROM\n";
    $sql .= "   t_buy_h\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_buy_d\n";
    $sql .= "   ON t_buy_h.buy_id = t_buy_d.buy_id\n";
    $sql .= "   LEFT JOIN\n ";
    $sql .= "   (SELECT\n";
    $sql .= "       goods_id,\n";
    $sql .= "       SUM(stock_num)AS stock_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "   WHERE\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       ware_id = $buy_h_data[ware_id]\n";
    $sql .= "       GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_buy_d.goods_id = t_stock.goods_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods\n";
    $sql .= "   ON t_buy_d.goods_id = t_goods.goods_id";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   t_order_d\n";
    $sql .= "   ON t_buy_d.ord_d_id = t_order_d.ord_d_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods_info\n";
    $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id";
    $sql .= " WHERE\n";
    $sql .= "   t_buy_d.buy_id = $get_buy_id\n";
    $sql .= "   AND\n ";
    $sql .= "   t_buy_h.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods_info.shop_id = $shop_id\n";
    $sql .= " ORDER BY t_buy_d.line\n ";
    $sql .= ";\n"; 

    $result = Db_Query($db_con, $sql);
    $num = pg_num_rows($result);

    //�ʹߤν����ǻ����ޤ��ǡ���
    $goods_id = null;
    $stock_manage = null;
    $name_change = null;

    for($i = 0; $i < $num; $i++){
        $buy_d_data = pg_fetch_array($result, $i );
        $price_data = explode('.',$buy_d_data[8]);

        $buy_amount[]   = $buy_d_data[9];
        $tax_div[]      = $buy_d_data[4];

        $set_data["hdn_order_d_id"][$i]         = $buy_d_data["ord_d_id"];                                          //ȯ��ǡ���ID
        $set_data["hdn_goods_id"][$i]           = $buy_d_data["goods_id"];                                          //����ID
        $set_data["form_goods_cd"][$i]          = $buy_d_data["goods_cd"];                                          //����CD
        $set_data["form_goods_name"][$i]        = $buy_d_data["goods_name"];                                        //����̾
        $set_data["hdn_tax_div"][$i]            = $buy_d_data["tax_div"];                                           //���Ƕ�ʬ��hidden�ѡ�
        $set_data["form_stock_num"][$i]         = $buy_d_data["stock_num"];                                         //�߸˿�
        $set_data["form_order_num"][$i]         = ($buy_h_data["ord_no"] != null)? $buy_d_data["order_num"] : '-';  //ȯ���
        $set_data["form_buy_num"][$i]           = $buy_d_data["buy_num"];                                           //������
        $set_data["form_buy_price"][$i]["i"]    = $price_data[0];                                                   //����ñ������������
        $set_data["form_buy_price"][$i]["d"]    = ($price_data[1] != NULL)? $price_data[1] : "00";                  //����ñ���ʾ�������
        $set_data["form_buy_amount"][$i]        = number_format($buy_d_data[9]);                                    //������ۡ���ȴ����
        $set_data["form_rorder_num"][$i]        = ($buy_h_data["ord_no"] != null)? $buy_d_data["on_order_num"] : '-';//ȯ���
        $set_data["hdn_name_change"][$i]        = $buy_d_data["name_change"];                                       //��̾�ѹ�
        $set_data["hdn_stock_manage"][$i]       = $buy_d_data["stock_manage"];                                      //�߸˴���
        $set_data["form_in_num"][$i]            = $buy_d_data["in_num"];                                            //����
        //aoyama-n 2009-09-01
        $set_data["hdn_discount_flg"][$i]       = $buy_d_data["discount_flg"];                                      //�Ͱ��ե饰

        if($buy_d_data["buy_num"]%$buy_d_data["in_num"] == 0 && $buy_d_data["in_num"]!=null && $buy_d_data["in_num"] !=0){
            $set_buy_data["form_order_in_num"]  = $buy_d_data["buy_num"]/$buy_d_data["in_num"];
        }

    //�ʹߤν����ǻ����ޤ��ǡ���
        $goods_id[$i]                         = $buy_d_data["goods_id"];             //����ID
        $stock_manage[$i]                     = $buy_d_data["stock_manage"];         //�߸˴����ʺ߸˿�ɽ��Ƚ���
        $name_change[$i]                      = $buy_d_data["name_change"];          //��̾�ѹ�����̾�ѹ��ղ�Ƚ���
        $order_d_id[$i]                       = $buy_d_data["ord_d_id"];             //ȯ��ǡ���ID
    }

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($buy_h_data["buy_day"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

    //�ե�������ͥ��å�
    $set_data["form_buy_money"]     = number_format($data[0]);
    $set_data["form_tax_money"]     = number_format($data[1]);
    $set_data["form_total_money"]   = number_format($data[2]);

    //Get�Ǽ�������ȯ��ID��hidden�ǻ����ޤ��
//    $set_data["hdn_order_id"] = $get_ord_id;
    if($buy_h_data["ord_id"] != null){
        $order_flg = true;
    }

    $max_row = $num;
    $client_search_flg = true;
    $ware_search_flg = true;
    $update_flg = true;

/****************************/
//�����襳��������
/****************************/
}elseif($client_input_flg == true){
    $client_cd1 = $_POST["form_client"]["cd1"];         //�����襳����
    $client_cd2 = $_POST["form_client"]["cd2"];         //�����襳����

    //���ꤵ�줿������ξ�������
    $sql  = "SELECT";
    $sql .= "   client_id,";                            //������ID
    $sql .= "   client_cname,";                         //������̾
    $sql .= "   coax,";                                 //�ݤ��ʬ
    $sql .= "   tax_franct,";                            //ü����ʬ
    $sql .= "   buy_trade_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '3'";
    $sql .= "   AND";
    $sql .= "   shop_id = '$shop_id'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_client_data_count = pg_num_rows($result);
    $get_client_data       = pg_fetch_array($result);

    //������������褬���ä����Τ߽�������
    if($get_client_data_count > 0){
        //�ʹߤν����ǻ����ޤ��������ID
        $client_id  = $get_client_data["client_id"];
        $tax_franct = $get_client_data["tax_franct"];
        $coax       = $get_client_data["coax"];

        //��Ф���������ξ���򥻥å�
        $set_data = NULL;
        $set_data["hdn_client_id"]                  = $get_client_data["client_id"];        //������ID
        $set_data["form_client"]["name"]            = $get_client_data["client_cname"];     //������̾
        $set_data["hdn_tax_franct"]                 = $get_client_data["tax_franct"];       //�ݤ��ʬ
        $set_data["hdn_coax"]                       = $get_client_data["coax"];             //ü����ʬ
        $set_data["form_trade"]                     = $get_client_data["buy_trade_id"];     //�����ʬ

        //������������褬����Τǡ������踡���ե饰��Ω�Ƥ�
        //�ٹ��å�����������
        $client_search_flg = true;

    //��������ǡ������ʤ��ä����ϡ��������ϺѤߤξ��ʥǡ��������ƽ����
    }else{
        $set_data = NULL;       //���åȤ���ǡ����ν����
        $set_data["hdn_client_id"]                  = "";       //������ID
        $set_data["form_client"]["name"]            = "";       //������̾

        for($i = 0; $i < $max_row; $i++){
            $set_data["hdn_goods_id"][$i]           = "";       //����ID
            $set_data["form_goods_cd"][$i]          = "";       //����CD
            $set_data["form_goods_name"][$i]        = "";       //����̾
            $set_data["hdn_stock_manage"][$i]       = "";       //�߸˴���
            $set_data["hdn_name_change"][$i]        = "";       //��̾�ѹ�
            $set_data["form_stock_num"][$i]         = "";       //���߸Ŀ�
            $set_data["form_rstock_num"][$i]        = "";       //ȯ��ѿ�
            $set_data["form_rorder_num"][$i]        = "";       //�вٲ�ǽ��
            $set_data["form_designated_num"][$i]    = "";       //������
            $set_data["form_buy_price"][$i]["i"]    = "";       //����ñ������������
            $set_data["form_buy_price"][$i]["d"]    = "";       //����ñ���ʾ�������
            $set_data["hdn_tax_div"][$i]            = "";       //���Ƕ�ʬ
            $set_data["form_in_num"][$i]            = "";       //����
            $set_data["form_order_in_num"][$i]      = "";       //����
            $set_data["form_buy_amount"][$i]        = "";       //ȯ����
            $set_data["form_buy_num"][$i]           = "";       //ȯ����
            //aoyama-n 2009-09-01
            $set_data["hdn_discount_flg"][$i]       = "";       //�Ͱ��ե饰

            $goods_id     = null;
            $stock_manage = null;
            $name_change  = null;
            $client_id    = null;
        }

        //������������褬�ʤ��Τǡ������踡���ե饰�ˤ�false�򥻥å�
        $client_search_flg = false;
    }

    //�����踡���ե饰������
    $set_data["hdn_client_search_flg"]              = "";

/****************************/
//�����Ҹ�����
/****************************/
//}elseif($ware_select_flg == true){
}elseif($_POST[hdn_ware_select_flg] == true){
    $ware_id = $_POST["form_ware"];

    if($ware_id != NULL){
        //���ʤ����İʾ����򤵤�Ƥ���н�������
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

                $set_data["form_stock_num"][$i] = ($stock_data != NULL)? $stock_data : 0;     //���߸Ŀ�
            }
        }
        $ware_search_flg = true;
    }else{
        $ware_search_flg = false;
    }

    $set_data["hdn_ware_select_flg"]    = "";

/****************************/
//ȯ��ID��������
/****************************/
//ɽ���ܥ��󸡺��ե饰��true
}elseif($show_button_flg == true || $get_ord_id_flg == true){
    //ɽ���ܥ��󲡲���
    if($show_button_flg == true){
       $get_order_id = $_POST["form_order_no"];
    }elseif($get_ord_id_flg == true){
       $get_order_id = $_GET["ord_id"];
    }

    if($get_order_id != null){

        $sql  = " SELECT\n";
        $sql .= "   t_order_h.ord_id,\n";
        $sql .= "   to_date(t_order_h.ord_time,'YYYY/mm/dd') AS ord_time,\n";
        $sql .= "   arrival_day,\n";
        $sql .= "   t_client.client_id,\n";
        $sql .= "   t_client.client_cd1,\n";
        $sql .= "   t_client.client_cd2,\n";
//        $sql .= "   t_client.client_name,\n";
        $sql .= "   t_client.client_cname,\n";
        $sql .= "   t_client.coax,\n";
        $sql .= "   t_client.tax_franct,\n";
        $sql .= "   t_order_h.direct_id,\n";
        $sql .= "   t_order_h.ware_id,\n";
        $sql .= "   t_order_h.trade_id,\n";
        $sql .= "   t_order_h.c_staff_id,\n";
        $sql .= "   t_order_h.ps_stat,\n";
        $sql .= "   t_client.head_flg,\n";
        $sql .= "   t_order_h.ord_staff_id,\n";
        $sql .= "   t_order_h.enter_day,";
        $sql .= "   t_order_h.ord_no,";
        $sql .= "   t_order_h.change_day";
        $sql .= " FROM\n";
        $sql .= "   t_order_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_client\n";
        $sql .= "   ON t_order_h.client_id = t_client.client_id\n";
        $sql .= " WHERE\n";
        $sql .= "   (t_order_h.ord_stat <> 3\n";
        $sql .= "   OR\n";
        $sql .= "   t_order_h.ord_stat IS NULL)\n";
        $sql .= "   AND\n";
        $sql .= "   t_order_h.ord_id = $get_order_id\n";
        $sql .= "   AND\n";
        $sql .= "   t_order_h.shop_id = $shop_id\n";
        $sql .= "   AND\n";
        $sql .= "   t_order_h.ps_stat IN (1,2)\n";
        $sql .= ";\n";

        $result         = Db_Query($db_con, $sql);
        Get_Id_Check($result);
        $get_ord_h_data = pg_fetch_array($result, $sql);
        $get_ord_h_num  = pg_num_rows($result);

        //��Ф����ǡ�����ɽ������������ѹ�
        $order_date     = explode("-", $get_ord_h_data["ord_time"]);
        $arrival_date   = explode("-", $get_ord_h_data["arrival_day"]);

        //��Ф���������ξ���򥻥å�
        $set_data = NULL;
        $set_data["hdn_client_id"]              = $get_ord_h_data["client_id"];     //������ID
        $set_data["form_client"]["cd1"]          = $get_ord_h_data["client_cd1"];    //������CD
        $set_data["form_client"]["cd2"]          = $get_ord_h_data["client_cd2"];    //������CD
        $set_data["form_client"]["name"]        = $get_ord_h_data["client_cname"];  //������̾
        $set_data["hdn_tax_franct"]             = $get_ord_h_data["tax_franct"];    //�ݤ��ʬ
        $set_data["hdn_coax"]                   = $get_ord_h_data["coax"];          //ü����ʬ

        //�ǡ�����ե�����˥��å�
        $set_data["hdn_order_id"]               = $get_ord_h_data["ord_id"];        //ȯ��ID��hidden�ѡ�
        $set_data["form_order_no"]              = $get_ord_h_data["ord_id"];        //ȯ��ID
        $set_data["form_order_day"]["y"]        = $order_date[0];                   //ȯ����
        $set_data["form_order_day"]["m"]        = $order_date[1];
        $set_data["form_order_day"]["d"]        = $order_date[2];
        $set_data["form_arrival_hope_day"]["y"] = $arrival_date[0];                 //����ͽ����
        $set_data["form_arrival_hope_day"]["m"] = $arrival_date[1];
        $set_data["form_arrival_hope_day"]["d"] = $arrival_date[2];
        $set_data["form_direct"]                = $get_ord_h_data["direct_id"];     //ľ����
        $set_data["form_ware"]                  = $get_ord_h_data["ware_id"];       //�Ҹ�ID
        $set_data["form_trade"]                 = $get_ord_h_data["trade_id"];      //�����ʬ
        $set_data["form_order_staff"]           = $get_ord_h_data["ord_staff_id"];  //ȯ��ô����
        $set_data["form_buy_staff"]             = $get_ord_h_data["c_staff_id"];    //ô����ID
        $set_data["hdn_ord_enter_day"]          = $get_ord_h_data["enter_day"];     //ȯ����Ͽ��
        $set_data["hdn_ord_change_day"]         = $get_ord_h_data["change_day"];    //ȯ���ѹ���

        //�ʹߤν����ǻ����ޤ����
        $client_search_flg = true;                                                  //�����踡���ե饰
        $ware_search_flg   = true;                                                  //�Ҹ˸����ե饰
        $client_id         = $get_ord_h_data["client_id"];                          //������ID
        $coax              = $get_ord_h_data["coax"];                               //�ݤ��ʬ
        $tax_franct        = $get_ord_h_data["tax_franct"];

        //ȯ��ǡ��������
        $sql  = "SELECT\n";
        $sql .= "   t_order_d.ord_d_id,\n";                                         //ȯ��ǡ���ID
        $sql .= "   t_goods.goods_id,\n";                                           //����ID
        $sql .= "   t_order_d.goods_cd,\n";                                         //���ʥ�����
        $sql .= "   t_order_d.goods_name,\n";                                       //����̾
        #2009-10-13 hashimoto-y
        #$sql .= "   CASE t_goods.stock_manage\n";                                   //�߸˴���
        $sql .= "   CASE t_goods_info.stock_manage\n";                                   //�߸˴���

        $sql .= "        WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
        $sql .= "   END AS stock_num,\n";
        $sql .= "   t_order_d.num AS order_num,\n";                                 //ȯ���
        $sql .= "   COALESCE(t_buy.buy_num,0) AS buy_num,\n";                       //������
        $sql .= "   t_order_d.buy_price,\n";                                        //����ñ��
        $sql .= "   t_order_d.tax_div,\n";                                          //���Ƕ�ʬ
        $sql .= "   t_order_d.buy_amount,\n";                                       //�������
        $sql .= "   t_goods.name_change,\n";                                        //��̾�ѹ�
        //aoyama-n 2009-09-01
        #$sql .= "   t_goods.in_num\n";                                              //����
        $sql .= "   t_goods.in_num,\n";                                             //����
        $sql .= "   t_goods.discount_flg\n";                                        //�Ͱ��ե饰
        $sql .= " FROM\n";
        $sql .= "   t_order_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_order_d\n";
        $sql .= "   ON t_order_h.ord_id = t_order_d.ord_id\n";
        $sql .= "       LEFT JOIN\n";
        $sql .= "   (SELECT\n";
        $sql .= "       goods_id,\n";
        $sql .= "       SUM(stock_num)AS stock_num\n";
        $sql .= "   FROM\n";    
        $sql .= "       t_stock\n";     
        $sql .= "   WHERE\n";   
        $sql .= "        shop_id = $shop_id\n";     
        $sql .= "        AND\n";    
        $sql .= "        ware_id = $get_ord_h_data[ware_id]\n";     
        $sql .= "   GROUP BY t_stock.goods_id\n";   
        $sql .= "   )AS t_stock\n";     
        $sql .= "   ON t_order_d.goods_id = t_stock.goods_id\n";    
        $sql .= "       LEFT JOIN\n";   
        $sql .= "   (SELECT\n ";    
        $sql .= "       ord_d_id,\n";   
        $sql .= "       SUM(num) AS buy_num\n";     
        $sql .= "   FROM\n";    
        $sql .= "       t_buy_d\n";     
        $sql .= "   GROUP BY ord_d_id\n";   
        $sql .= "   )t_buy\n";  
        $sql .= "   ON t_order_d.ord_d_id = t_buy.ord_d_id\n";  
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_goods\n";
        $sql .= "   ON t_order_d.goods_id = t_goods.goods_id\n";
        $sql .= "       INNER JOIN\n";  
        $sql .= "   t_goods_info\n";    
        $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id\n";     
        $sql .= " WHERE\n";     
        $sql .= "   t_order_h.ord_id = $get_ord_h_data[ord_id]\n";     
        $sql .= "   AND\n";     
        $sql .= "   t_order_d.rest_flg = 't'\n";    
        $sql .= "   AND\n";     
        $sql .= "   t_order_h.shop_id = $shop_id\n";    
        $sql .= "   AND\n";
        $sql .= "   t_goods_info.shop_id = $shop_id\n";
        $sql .= " ORDER BY t_order_d.line";
        $sql .= ";";
        
        $result = Db_Query($db_con, $sql);
        $get_ord_d_num = pg_num_rows($result);

        //�ѿ������
        $goods_id = null;
        $stock_manage = null;
        $name_change = null;
        $order_d_id = null;

        //ȯ��������ʬ�롼��
        for($i = 0; $i < $get_ord_d_num; $i++){
            //��Ԥ��ĥǡ��������
            $get_ord_d_data = pg_fetch_array($result, $i);

            //ȯ���
            $rorder_num = $get_ord_d_data["order_num"] - $get_ord_d_data["buy_num"]; 

            //��׶�ۤ򻻽�
            $price      = $get_ord_d_data["buy_price"];
    
            $buy_amount_data = bcmul($price, $rorder_num,2);
            $buy_amount[$i] = Coax_Col($coax, $buy_amount_data);
            //����ñ����ʬ��
            $price_data = explode(".",$price);

            //���ʥǡ�����Ф������ʤΥǡ����򥻥å�
            $set_data["hdn_goods_id"][$i]         = $get_ord_d_data["goods_id"];        //����ID
            $set_data["hdn_name_change"][$i]      = $get_ord_d_data["name_change"];     //��̾�ѹ�
            $set_data["hdn_stock_manage"][$i]     = $get_ord_d_data["stock_manage"];    //�߸˴���
            $set_data["form_goods_cd"][$i]        = $get_ord_d_data["goods_cd"];        //���ʥ�����
            $set_data["form_goods_name"][$i]      = $get_ord_d_data["goods_name"];      //����̾
            $set_data["form_stock_num"][$i]       = $get_ord_d_data["stock_num"];       //���߸Ŀ�
            $set_data["hdn_stock_num"][$i]        = $get_ord_d_data["stock_num"];       //���߸Ŀ�(hiddn��)
            $set_data["form_buy_price"][$i]["i"]  = $price_data[0];                     //����ñ������������
            $set_data["form_buy_price"][$i]["d"]  = $price_data[1];                     //����ñ���ʾ�������
            $set_data["form_buy_amount"][$i]      = number_format($buy_amount[$i]);     //������ۡ���ȴ����
            $set_data["form_order_num"][$i]       = $get_ord_d_data["order_num"];       //ȯ���
            $set_data["form_rorder_num"][$i]      = $rorder_num;                        //ȯ��ѿ�
            $set_data["form_rbuy_num"][$i]        = $get_ord_d_data["buy_num"];         //�����ѿ�
            $set_data["form_buy_num"][$i]         = $rorder_num;                        //������
            $set_data["form_order_in_num"][$i]    = "";                                 //��������
            $set_data["hdn_tax_div"][$i]          = $get_ord_d_data["tax_div"];         //���Ƕ�ʬ
            $set_data["form_in_num"][$i]          = $get_ord_d_data["in_num"];          //����
            $set_data["hdn_order_d_id"][$i]       = $get_ord_d_data["ord_d_id"];        //ȯ��ǡ���ID
            //aoyama-n 2009-09-01
            $set_data["hdn_discount_flg"][$i]     = $get_ord_d_data["discount_flg"];    //�Ͱ��ե饰

            //�ʹߤν����ǻ����ޤ��ǡ���
            $goods_id[$i]                         = $get_ord_d_data["goods_id"];        //����ID
            $stock_manage[$i]                     = $get_ord_d_data["stock_manage"];    //�߸˴����ʺ߸˿�ɽ��Ƚ���
            $name_change[$i]                      = $get_ord_d_data["name_change"];     //��̾�ѹ�����̾�ѹ��ղ�Ƚ���
            $order_d_id[$i]                       = $get_ord_d_data["ord_d_id"];        //ȯ��ǡ���ID
        }

        $buy_data   = $_POST["form_buy_amount"];   //�������
        $price_data = NULL;                        //���ʤλ������
        $tax_div    = NULL;                        //���Ƕ�ʬ

        //�����ǡ����η����ɽ���������Ȥ��롣
        $max_row = $get_ord_d_num; 

        //������ۤι���ͷ׻�
        for($i=0;$i<$max_row;$i++){
            $price_data[] = $buy_amount[$i];
            $tax_div[]    = $set_data["hdn_tax_div"][$i];
        }

        #2009-12-21 aoyama-n
        $tax_rate_obj->setTaxRateDay($def_data["form_buy_day"]["y"]."-".$def_data["form_buy_day"]["m"]."-".$def_data["form_buy_day"]["d"]);
        $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

        $data = Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

        //�ե�������ͥ��å�
        $set_data["form_buy_money"]   = number_format($data[0]);
        $set_data["form_tax_money"]   = number_format($data[1]);
        $set_data["form_total_money"] = number_format($data[2]);

        //ȯ��ե饰��true�˥��å�
        $order_flg = true;


    //�������򤵤줿���
    }else{
        header("Location:./1-3-207.php");
        exit;
    }
    $set_data["hdn_show_button_flg"] = "";

/****************************/
//���ʥ���������
/****************************/
//���ʸ����ե饰��true�ξ��
}elseif($goods_search_flg === true){

    $search_row = $_POST["hdn_goods_search_flg"];           //���ʸ�����
    $goods_cd   = $_POST["form_goods_cd"]["$search_row"];   //���ʥ�����
    $ware_id    = $_POST["form_ware"];                      //�Ҹ�ID

    $sql  = "SELECT\n ";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";

    $sql .= "   t_goods.goods_cd,\n";
    //$sql .= "   t_goods.goods_name,\n";dd
    $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //����̾
    $sql .= "   t_goods.tax_div,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";

    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS stock_num,\n";
    $sql .= "   t_price.r_price,\n";
//    $sql .= "   t_goods_info.in_num\n";
    //aoyama-n 2009-09-01
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
    $sql .= "   (SELECT\n";
    $sql .= "       goods_id,\n";
    $sql .= "       SUM(stock_num)AS stock_num\n";
    $sql .= "    FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "    WHERE\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       ware_id = $ware_id\n";
    $sql .= "   GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_goods.goods_id = t_stock.goods_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods_info\n";
    $sql .= "   ON t_goods.goods_id = t_goods_info.goods_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_cd = '$goods_cd'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods_info.shop_id = $shop_id\n";
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
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $goods_data_num = pg_num_rows($result);
    $goods_data = pg_fetch_array($result);

    //�嵭��SQL�ǳ�������쥳���ɤ����ä����(�����ʾ��ʥ����ɤ����Ϥ��줿���)
    if($goods_data_num > 0){

        //��Ф���ñ���ǡ����򥻥åȤ���������ѹ�
        //��Ф���ñ�����ѿ��˥��å�
        $price = $goods_data["r_price"];

        //���Ǥ�ȯ��������Ϥ���Ƥ�����硢��ۤ�Ʒ׻�����
        //ȯ�������Ƚ��
        if($_POST["form_buy_num"][$search_row] != null){
            $buy_amount = bcmul($price, $_POST["form_buy_num"][$search_row],2);
            $buy_amount = Coax_Col($coax, $buy_amount);
        }

        //����ñ����ʬ��
        $price_data = explode(".",$price);

        //���ʥǡ�����Ф������ʤΥǡ����򥻥å�
        $set_data["hdn_goods_id"][$search_row]         = $goods_data["goods_id"];         //����ID
        $set_data["hdn_name_change"][$search_row]      = $goods_data["name_change"];      //��̾�ѹ�
        $set_data["hdn_stock_manage"][$search_row]     = $goods_data["stock_manage"];     //�߸˴���
        $set_data["form_goods_name"][$search_row]      = $goods_data["goods_name"];       //����̾
        $set_data["form_stock_num"][$search_row]       = $goods_data["stock_num"];        //���߸Ŀ�
        $set_data["hdn_stock_num"][$search_row]        = $goods_data["stock_num"];        //���߸Ŀ�(hiddn��)
        $set_data["form_buy_price"][$search_row]["i"]  = $price_data[0];                  //����ñ������������
        $set_data["form_buy_price"][$search_row]["d"]  = $price_data[1];                  //����ñ���ʾ�������
        $set_data["form_buy_amount"][$search_row]      = number_format($buy_amount);      //������ۡ���ȴ����
        $set_data["form_order_num"][$search_row]       = "-";
        $set_data["form_rorder_num"][$search_row]      = "-";
        $set_data["form_rbuy_num"][$search_row]        = "-";
        $set_data["hdn_tax_div"][$search_row]          = $goods_data["tax_div"];          //���Ƕ�ʬ
        $set_data["form_in_num"][$search_row]          = $goods_data["in_num"];           //����
        //aoyama-n 2009-09-01
        $set_data["hdn_discount_flg"][$search_row]     = $goods_data["discount_flg"];     //�Ͱ��ե饰

        //�ʹߤν����ǻ����ޤ��ǡ���
        $goods_id[$search_row]                         = $goods_data["goods_id"];         //����ID
        $stock_manage[$search_row]                     = $goods_data["stock_manage"];     //�߸˴����ʺ߸˿�ɽ��Ƚ���
        $name_change[$search_row]                      = $goods_data["name_change"];      //��̾�ѹ�����̾�ѹ��ղ�Ƚ���
      

    //�������ͤ����Ϥ��줿���
    }else{
        $set_data["hdn_goods_id"][$search_row]         = "";                              //����ID
        $set_data["hdn_name_change"][$search_row]      = "";                              //��̾�ѹ�
        $set_data["hdn_stock_manage"][$search_row]     = "";                              //�߸˴���
        $set_data["form_goods_name"][$search_row]      = "";                              //����̾
        $set_data["form_stock_num"][$search_row]       = "";                              //���߸Ŀ�
        $set_data["hdn_stock_num"][$search_row]        = "";                              //���߸Ŀ���hidden�ѡ�
        $set_data["form_buy_price"][$search_row]["i"]  = "";                              //����ñ������������
        $set_data["form_buy_price"][$search_row]["d"]  = "";                              //����ñ���ʾ�������
        $set_data["form_buy_amount"][$search_row]      = "";                              //������ۡ���ȴ����
        $set_data["form_order_num"][$search_row]       = "";                              //ȯ���
        $set_data["form_rorder_num"][$search_row]      = "";                              //ȯ��ѿ�
        $set_data["form_rbuy_num"][$search_row]        = "";                              //�����ѿ�
        $set_data["hdn_tax_div"][$search_row]          = "";                              //���Ƕ�ʬ
        $set_data["form_in_num"][$search_row]          = "";                              //����
        //aoyama-n 2009-09-01
        $set_data["hdn_discount_flg"][$search_row]     = "";                              //�Ͱ��ե饰
        $goods_id[$search_row]                         = null;                            //����ID
        $stock_num[$search_row]                        = null;                            //���߸Ŀ�(�����)
        $stock_manage[$search_row]                     = null;                            //�߸˴����ʺ߸˿�ɽ��Ƚ���
        $name_change[$search_row]                      = null;                            //��̾�ѹ�����̾�ѹ��ղ�Ƚ���
    }

    //�������ϥե饰������
    $set_data["hdn_goods_search_flg"]                = "";
}

/****************************/
//�����褬���򤵤�Ƥ��������ݻĹ��׻�
/****************************/
if($client_search_flg == true){

/*
    //���������
    $sql  = "SELECT\n";
    $sql .= "   close_day\n";
    $sql .= " FROM\n";
    $sql .= "   t_client\n";
    $sql .= " WHERE\n";
    $sql .= "   t_client.client_id = $client_id\n";
    $sql .= ";";

    $result = Db_Query($db_con,$sql);
    $close_day = pg_fetch_result($result, 0, 0);

    //��������
    $yy = date('Y');
    $mm = date('m');
    if($close_day < 29){
        $last_close_day = date('Ymd', mktime(0,0,0,$mm, $close_day, $yy));
    }else{
        $last_close_day = date('Ymd', mktime(0,0,0,$mm+1,-1,$yy));
    }

    //������������������ۤ����
    $sql  = "SELECT\n";
    $sql .= "    (COALESCE(t_plus.net_amount,0) - COALESCE(t_minus.net_amount,0)) AS ap_balance\n";
    $sql .= " FROM\n";
    $sql .= "    (SELECT\n";
    $sql .= "        client_id,\n";
    $sql .= "        SUM(t_buy_h.net_amount)AS net_amount\n";
    $sql .= "    FROM\n";
    $sql .= "        t_buy_h\n";
    $sql .= "    WHERE\n";
    $sql .= "       t_buy_h.client_id = $client_id\n";
    $sql .= "       AND\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_buy_h.trade_id IN ('21', '25')\n";
    $sql .= "       AND\n";
    $sql .= "       t_buy_h.buy_day > (SELECT\n";
    $sql .= "                           COALESCE(MAX(payment_close_day), '".START_DAY."')\n";
    $sql .= "                       FROM\n";
    $sql .= "                           t_schedule_payment\n";
    $sql .= "                       WHERE\n";
    $sql .= "                           shop_id = $shop_id\n";
    $sql .= "                           AND\n";
    $sql .= "                           client_id = $client_id\n";
    $sql .= "                       )\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.buy_day <= '$last_close_day'\n";
    $sql .= "    GROUP BY client_id\n";
    $sql .= "    ) AS t_plus\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    (SELECT\n";
    $sql .= "        client_id,\n";
    $sql .= "        SUM(t_buy_h.net_amount)AS net_amount\n";
    $sql .= "    FROM\n";
    $sql .= "        t_buy_h\n";
    $sql .= "    WHERE\n";
    $sql .= "       t_buy_h.client_id = $client_id\n";
    $sql .= "       AND\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_buy_h.trade_id IN ('23', '24')\n";
    $sql .= "       AND\n";
    $sql .= "       t_buy_h.buy_day > (SELECT\n";
    $sql .= "                           COALESCE(MAX(payment_close_day), '".START_DAY."')\n";
    $sql .= "                       FROM\n";
    $sql .= "                           t_schedule_payment\n";
    $sql .= "                       WHERE\n";
    $sql .= "                           shop_id = $shop_id\n";
    $sql .= "                           AND\n";
    $sql .= "                           client_id = $client_id\n";
    $sql .= "                       )\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.buy_day <= '$last_close_day'\n";
    $sql .= "    GROUP BY client_id\n";
    $sql .= "    ) AS t_minus\n";
    $sql .= "    ON t_plus.client_id = t_minus.client_id\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $ap_balance = number_format(@pg_fetch_result($result,0,0));
*/

    /****************************/
    // ��ݥǡ��������ʻĹ�Τߡ�
    /****************************/
    // ��ɼ���٥ǡ��������ʥǡ�����̵�����϶����������
    $sql = Ap_Particular_Sql(START_DAY, date("Y-m-d"), $client_id);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    $ary_ap_particular_data = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // ��ݻĹ⻻��
    foreach ($ary_ap_particular_data as $key => $value){
        $ap_balance += ($value["buy_amount"] - $value["payout_amount"]);
    }

    $ap_balance = number_format($ap_balance);

}

//����Կ���hidden�˥��å�
$set_data["max_row"] = $max_row;

//�嵭�����ˤ�����������ͤ�ե�����˥��å�
$form->setConstants($set_data);

//������OR�Ҹˤ����򤵤�Ƥ��ʤ����
if($client_search_flg == true && $ware_search_flg == true){
    //���̤�ɽ������ٹ��å�����
    $warning = "���ʤ����򤷤Ʋ�������"; 
    //���Ϥ����¤���ե饰
    $select_flg = true;
}else{
    //���̤�ɽ������ٹ��å�����
    $warning = "��������Ҹˤ����򤷤Ʋ�������";
    //���Ϥ����¤���ե饰
    $select_flg = false;  
}    

/****************************/
//�ե��������
/****************************/
//��ɼ�ֹ�
$form->addElement(
    "text","form_buy_no","",
    "style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//ȯ���
//if($update_data_flg == true || $_POST[hdn_buy_id] != null){
if($update_data_flg == true || $update_flg == true){
    $form->addElement(
        "text","form_order_no","",
        "style=\"color : #525552; 
        border : #ffffff 1px solid; 
        background-color: #ffffff; 
        text-align: left\" readonly'"
    );

}else{
    $select_value[null] = null;
    $sql  = "SELECT";
    $sql .= "    t_order_h.ord_id,";
    $sql .= "    t_order_h.ord_no";
    $sql .= " FROM";
    $sql .= "    t_order_h";
    $sql .= "        INNER JOIN";
    $sql .= "    (SELECT";
    $sql .= "        ord_id";
    $sql .= "    FROM";
    $sql .= "        t_order_d";
    $sql .= "    WHERE";
    $sql .= "        rest_flg = 't'";
    $sql .= "    GROUP BY ord_id) AS t_order_d";
    $sql .= "    ON t_order_h.ord_id = t_order_d.ord_id";
    $sql .= " WHERE";
    $sql .= "    t_order_h.shop_id = $shop_id";
    $sql .= "    AND";
    $sql .= "    t_order_h.ord_stat IS NULL";
    $sql .= "    AND";
    $sql .= "    t_order_h.ps_stat IN ('1','2')";
    $sql .= " ORDER BY t_order_h.ord_no";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $num = pg_num_rows($result);
    for($i = 0; $i < $num; $i++){
        $ord_id = pg_fetch_result($result,$i,0);
        $ord_no = pg_fetch_result($result,$i,1);
        $select_value[$ord_id] = $ord_no;
    }
    $form->addElement("select","form_order_no","",$select_value, $g_form_option_select);
}

//ȯ����
$form_order_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_order_day[] = $form->createElement("static","","","-");
$form_order_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_order_day[] = $form->createElement("static","","","-");
$form_order_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form->addGroup( $form_order_day,"form_order_day","");

//����ͽ����
$form_arrival_hope_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_arrival_hope_day[] = $form->createElement("static","","","-");
$form_arrival_hope_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form_arrival_hope_day[] = $form->createElement("static","","","-");
$form_arrival_hope_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"color : #525552; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
$form->addGroup( $form_arrival_hope_day,"form_arrival_hope_day","");

//������
$form_arrival_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_arrival_day[y]','form_arrival_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arrival_day[d]')\"
    onBlur=\"blurForm(this)\"
    onChange=\"Claim_Day_Change('form_arrival_day', 'form_buy_day')\"
    "
);
$form_arrival_day[] = $form->createElement("static","","","-");
$form_arrival_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_arrival_day[m]','form_arrival_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arrival_day[d]')\"
    onBlur=\"blurForm(this)\"
    onChange=\"Claim_Day_Change('form_arrival_day', 'form_buy_day')\"
    "
);
$form_arrival_day[] = $form->createElement("static","","","-");
$form_arrival_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onFocus=\"onForm_today(this,this.form,'form_arrival_day[y]','form_arrival_day[m]','form_arrival_day[d]')\"
    onBlur=\"blurForm(this)\"
    onChange=\"Claim_Day_Change('form_arrival_day', 'form_buy_day')\"
    "
);
$form->addGroup( $form_arrival_day,"form_arrival_day","");

//������
$form_buy_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_buy_day[y]','form_buy_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_buy_day[y]','form_buy_day[m]','form_buy_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_buy_day[] = $form->createElement("static","","","-");
$form_buy_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_buy_day[m]','form_buy_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_buy_day[y]','form_buy_day[m]','form_buy_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_buy_day[] = $form->createElement("static","","","-");
$form_buy_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onFocus=\"onForm_today(this,this.form,'form_buy_day[y]','form_buy_day[m]','form_buy_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_buy_day,"form_buy_day","");

//������
//������
$freeze_form = $form_client[] = $form->createElement(
    "text","cd1","",
    "size=\"7\" maxLength=\"6\"
    style=\"$g_form_style\"
    onChange=\"javascript:Change_Submit('hdn_client_search_flg','#','true','form_client[cd2]')\"
    onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"
    $g_form_option"
);
//�����ѹ���OR��ȯ����λ������ˤϻ�������ѹ��Բ�
if($update_data_flg == true || $_POST[hdn_buy_id] != null || $order_flg == true){
    $freeze_form->freeze();
}
$form_client[] = $form->createElement("static","","","-");
$freeze_form = $form_client[] = $form->createElement(
    "text","cd2","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style\"
    onChange=\"javascript:Button_Submit('hdn_client_search_flg','#','true', this)\"
    $g_form_option"
);

//�����ѹ���OR��ȯ����λ������ˤϻ�������ѹ��Բ�
if($update_data_flg == true || $_POST[hdn_buy_id] != null || $order_flg == true){
    $freeze_form->freeze();
}
$form_client[] = $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly"
);
$form->addGroup($form_client, "form_client", "");

//ľ����
$select_value = Select_Get($db_con,'direct');
$update_form[0] = $form->addElement('select', 'form_direct', "", $select_value,"class=\"Tohaba\"".$g_form_option_select);

//�����Ҹ�
$where  = " WHERE";
$where .= "  shop_id = $_SESSION[client_id]";
$where .= "  AND";
$where .= "  nondisp_flg = 'f'";
$select_value = Select_Get($db_con,'ware', $where);
$update_form[1] = $form->addElement(
        'select', 'form_ware', '', $select_value,"
        onChange=\"javascript:Button_Submit('hdn_ware_select_flg','#','t', this)\""
);

//�����ʬ
$select_value = null;
//ȯ��ID��������
if($order_flg == true){
    $select_value = select_Get($db_con, 'trade_buy_ord');
}else{
    $select_value = Select_Get($db_con, 'trade_buy');
}
$select_value = Select_Get($db_con, 'trade_buy');
$update_form[2] = $form->addElement('select', 'form_trade', null, null,$g_form_option_select);
//���ʡ��Ͱ����ο����ѹ�
$select_value_key = array_keys($select_value);
for($i = 0; $i < count($select_value); $i++){
    if($select_value_key[$i] == 23 || $select_value_key[$i] == 24 || $select_value_key[$i] == 73 || $select_value_key[$i] == 74){
         $color= "style=color:red";
    }else{
          $color="";
    }
    #2009-09-28 hashimoto-y
    #�����ʬ�����Ͱ�����ɽ�����ʤ����ڤ��ᤷ�ξ��ˤϤ�����ifʸ�򳰤���
    if($select_value_key[$i] != 24 && $select_value_key[$i] != 74){
        $update_form[2]->addOption($select_value[$select_value_key[$i]], $select_value_key[$i],$color);
    }
}

//ȯ��ID��������
if($order_flg == true){
    //ȯ��ô����
    $select_value = Select_Get($db_con,'staff');
    $order_form[] = $form->addElement('select', 'form_order_staff', '', $select_value,$g_form_option_select);
    $count = count($order_form);
    for($i = 0; $i < $count; $i++){
        $order_form[$i]->freeze();
    }
}

$select_value = Select_Get($db_con,'staff','true');
//����ô����
$update_form[3] = $form->addElement('select', 'form_buy_staff', '', $select_value,$g_form_option_select);

//���������ѹ��κݤϻ��ꤷ���ե������ե꡼������
//if($update_flg == true && $order_flg == true){
if($update_flg == true && $order_flg == true){
    for($i = 0; $i < count($update_form); $i++){
        $update_form[$i]->freeze();
    }
}

//����
//$form->addElement("text","form_note","","size=\"50\" maxLength=\"20\" $g_form_option");
$form->addElement("textarea","form_note",""," rows=\"2\" cols=\"75\" $g_form_option_area");

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

//�ɲå��
$form->addElement("link","add_row_link","","#","�ɲ�","
    onClick=\"javascript:Button_Submit_1('add_row_flg', '#', 'true', this);\""
);

//���ϡ��ѹ�
$form->addElement("button","new_button","������",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�Ȳ�
$form->addElement("button","change_button","�Ȳ��ѹ�","onClick=\"javascript:Referer('1-3-202.php')\"");

/*
if($update_flg === false || $update_data_flg === false){
    //�������о�
    $form->addElement("button","form_client_button","������","onClick=\"javascript:location.href='./1-3-201.php'\"");
    //FC �о�
    $form->addElement("button","form_fc_button","�ơ���",$g_button_color."onClick=\"javascript:location.href='./1-3-207.php';\"");
}
*/

//hidden
//�����ϥե饰
$form->addElement("hidden", "hdn_client_search_flg");       //�����襳�������ϥե饰
$form->addElement("hidden", "hdn_goods_search_flg");        //���ʥ��������ϥե饰
$form->addElement("hidden", "hdn_ware_select_flg");         //�Ҹ�����ե饰
$form->addElement("hidden", "hdn_sum_button_flg");          //��ץܥ��󲡲��ե饰
$form->addElement("hidden", "add_row_flg");                 //���ɲåܥ��󲡲��ե饰
$form->addElement("hidden", "hdn_show_button_flg");         //ɽ���ܥ��󲡲��ե饰
//�����ޤ�������ξ���
$form->addElement("hidden", "hdn_coax");                    //�ݤ��ʬ
$form->addElement("hidden", "hdn_tax_franct");              //ü����ʬ
$form->addElement("hidden", "hdn_client_id");               //������ID
$form->addElement("hidden", "hdn_order_id");                //�ѹ�����ȯ��ID��
$form->addElement("hidden", "hdn_buy_id");
$form->addElement("hidden", "hdn_buy_enter_day");           //������Ͽ��
$form->addElement("hidden", "hdn_ord_enter_day");           //ȯ����Ͽ��
$form->addElement("hidden", "hdn_ord_change_day");          //ȯ���ѹ���

//ɽ���Կ��˴ط��������
$form->addElement("hidden", "del_row");                     //�����
$form->addElement("hidden", "max_row");                     //����Կ�

//�����ե饰
$form->addElement("hidden", "renew_flg", "1");

//aoyama-n 2009-09-15
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;
        $form->addElement("hidden","hdn_discount_flg[$i]");
    }
}

/****************************/
//�ܥ��󲡲�����Ƚ��
/****************************/
$buy_button_flg = ($_POST["form_buy_button"] == "������ǧ���̤�")? true : false;

$buy_comp_flg   = ($_POST["form_comp_button"] == "������λ")?��true : false;

/****************************/
//������ǧ�ܥ��󲡲�����
/****************************/
if($buy_button_flg == true || $buy_comp_flg == true){

    /******************************/
    //�롼�������QuickForm��
    /******************************/
    //������
    //��ɬ�ܥ����å�
    $form->addGroupRule('form_arrival_day', array(
            'y' => array(
                    array('�����������դ������ǤϤ���ޤ���', 'required')
            ),
            'm' => array(
                    array('�����������դ������ǤϤ���ޤ���','required')
            ),
            'd' => array(
                    array('�����������դ������ǤϤ���ޤ���','required')
            )               
    ));
    $form->addGroupRule('form_arrival_day', array(
            'y' => array(
                    array('�����������դ������ǤϤ���ޤ���', 'numeric')
            ),              
            'm' => array(
                    array('�����������դ������ǤϤ���ޤ���','numeric')
            ),              
            'd' => array(
                    array('�����������դ������ǤϤ���ޤ���','numeric')
            )               
    ));
    
    //������
    //��ɬ�ܥ����å�
    $form->addGroupRule('form_buy_day', array(
            'y' => array(
                    array('�����������դ������ǤϤ���ޤ���','required')
            ),              
            'm' => array(
                    array('�����������դ������ǤϤ���ޤ���','required')
            ),              
            'd' => array(
                    array('�����������դ������ǤϤ���ޤ���','required')
            )               
    ));
    $form->addGroupRule('form_buy_day', array(
            'y' => array(
                    array('�����������դ������ǤϤ���ޤ���','numeric')
            ),              
            'm' => array(
                    array('�����������դ������ǤϤ���ޤ���','numeric')
            ),
            'd' => array(
                    array('�����������դ������ǤϤ���ޤ���','numeric')
            )
    ));

    //������CD
    //��ɬ�ܥ����å�
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

    //�����Ҹ�
    //��ɬ�ܥ����å�
    $form->addRule('form_ware','�����Ҹˤ����򤷤Ƥ���������','required');

    //�����ʬ
    //��ɬ�ܥ����å�
    $form->addRule('form_trade','�����ʬ�����򤷤Ƥ���������','required');

    //����ô����
    //��ɬ�ܥ����å�
    $form->addRule('form_buy_staff','����ô���Ԥ����򤷤Ƥ���������','required');

    // ������
    // ʸ���������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note", "���ͤ�100ʸ������Ǥ���","mb_maxlength", "100");

    /******************************/
    //POST����
    /******************************/
    $client_id                  = $_POST["hdn_client_id"];                  //����ID
    $client_cd1                 = $_POST["form_client"]["cd1"];             //������CD
    $client_cd2                 = $_POST["form_client"]["cd2"];             //������CD
    $buy_no                     = $_POST["form_buy_no"];                    //�����ֹ�
    $order_no                   = $_POST["form_order_no"];                  //ȯ���ֹ�
    $order_date                 = $_POST["form_order_day"]["y"];            //ȯ������ǯ��
    $order_date                 = $_POST["form_order_day"]["m"];            //ȯ�����ʷ��
    $order_date                 = $_POST["form_order_day"]["d"];            //ȯ����������
    $arrival_day["y"]           = $_POST["form_arrival_day"]["y"];          //��������ǯ��
    $arrival_day["m"]           = $_POST["form_arrival_day"]["m"];          //�������ʷ��
    $arrival_day["d"]           = $_POST["form_arrival_day"]["d"];          //������������
    $buy_day["y"]               = $_POST["form_buy_day"]["y"];              //��������ǯ��
    $buy_day["m"]               = $_POST["form_buy_day"]["m"];              //�������ʷ��
    $buy_day["d"]               = $_POST["form_buy_day"]["d"];              //������������
    $direct                     = ($_POST["form_direct"] != NULL)? $_POST["form_direct"] : NULL;  //ľ����
    $ware                       = $_POST["form_ware"];                      //�����Ҹ�
    $trade                      = $_POST["form_trade"];                     //�����ʬ
    $buy_staff                  = $_POST["form_buy_staff"];                 //����ô����
    $order_staff                = ($_POST["form_order_staff"] != null)? $_POST["form_order_staff"] : null; //����ô����
    $note                       = $_POST["form_note"];                      //����

    //ȯ���ơ����������å�
    if($order_id != null && $buy_get_flg == false){
        $sql  = "SELECT \n";
        $sql .= "   t_order_h.ps_stat \n";
        $sql .= "FROM \n";
        $sql .= "   t_order_h \n";
        $sql .= "WHERE \n";
        $sql .= "   t_order_h.ord_id = $order_id\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        if(pg_num_rows($result) > 0){
            $ps_stat = pg_fetch_result($result, 0,0);
        }

        //ȯ��ν�����������λ�ξ��
        if($ps_stat == '3'){
            header("Location:./1-3-205.php?buy_id=0&input_flg=true&ps_stat=true");
        }
    }

    //����������å�
    $sql  = "SELECT";
    $sql .= "   COUNT(client_id) ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= "   AND";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
    $sql .= "   client_cd2 = '$client_cd2'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $client_num = pg_fetch_result($result, 0, 0);

    //�����襳���ɤ������ʾ��
    if($client_num != 1){
        $form->setElementError("form_client", "���������������� ȯ���ǧ���̤إܥ��� <br>��������ޤ�����������ľ���Ƥ���������");

    //�����襳���ɤ������ʾ��
    }elseif($client_cd1 != null && $client_cd2 != null){
 
        //aoyama-n 2009-09-01
        //�Ͱ�����������μ����ʬ�����å����Ͱ������ʤϻ����Բġ�
        if(($trade == '23' || $trade == '24' || $trade == '73' || $trade == '74') && (in_array('t', $_POST[hdn_discount_flg]))){
            $form->setElementError("form_trade", "�Ͱ����ʤ����򤷤���硢���ѤǤ�������ʬ�ϡֳݻ����������������������פΤߤǤ���");
            #2009-09-15 hashimoto-y
            $trade_err = true;
        }

        //�ǡ��������å����Ϥ���������
        $check_ary = array($db_con, $order_id, $_POST["hdn_ord_enter_day"], $get_buy_id);

        //�ǡ��������å�
        $check_data = Row_Data_Check(
                                $_POST[hdn_goods_id],       //����ID
                                $_POST[form_goods_cd],      //���ʥ�����
                                $_POST[form_goods_name],    //����̾
                                $_POST[form_buy_num],       //������
                                $_POST[form_buy_price],     //����ñ��
                                $_POST[form_buy_amount],    //�������
                                $_POST[hdn_tax_div],        //���Ƕ�ʬ
                                $del_history,               //�������
                                $max_row,                   //����Կ�
                                "buy",                      //��ʬ
                                $db_con,
                                $_POST[form_order_num],     //ȯ���
                                $_POST[hdn_royalty],        //�����ƥ�
                                $_POST[hdn_order_d_id],     //ȯ��ǡ���ID
                                //aoyama-n 2009-09-01
                                #$check_ary
                                $check_ary,
                                $_POST[hdn_discount_flg]    //�Ͱ��ե饰
                                );
        //�ѿ������
        $goods_id   = null;
        $goods_cd   = null;
        $goods_name = null;
        $buy_num    = null;
        $buy_price  = null;
        $buy_amount = null;
        $tax_div    = null;
        $order_num  = null;
        $royalty    = null;
        $order_d_id = null;

        //���顼�����ä����
        if($check_data[0] === true){
            //���ʤ���Ĥ����򤵤�Ƥ��ʤ����
            $form->setElementError("form_buy_no",$check_data[1]);
    
            //���������ʥ����ɤ����Ϥ���Ƥ��ʤ����
            $goods_err = $check_data[2];

            //ȯ����Ȼ���ñ�������Ϥ����뤫
            $price_num_err = $check_data[3];

            //ȯ���Ⱦ�ѿ��������å�
            $num_err = $check_data[4];

            //ñ��Ⱦ�ѥ����å�
            $price_err = $check_data[5];

            //ȯ������������Ķ�������
            $ord_num_err = $check_data[6];

            if($check_data[1] != null || $goods_err != null || $price_num_err != null || $num_err != null || $price_err != null){
                $err_flg = true;
            }

            $order_d_id = $_POST["hdn_order_d_id"];

        #2009-09-15 hashimoto-y
        }elseif($trade_err === true){
        //�����ʬ�����顼�ξ��  ���⤷�ʤ�

        }else{
        //���顼���ʤ��ä����

            //��Ͽ�оݥǡ������ѿ��˥��å�
            $goods_id   = $check_data[1][goods_id];
            $goods_cd   = $check_data[1][goods_cd];
            $goods_name = $check_data[1][goods_name];
            $buy_num    = $check_data[1][num];
            $buy_price  = $check_data[1][price];
            $buy_amount = $check_data[1][amount];
            $tax_div    = $check_data[1][tax_div];
            $order_d_id = $check_data[1][data_id];
            $order_num  = $check_data[1][num2];
            $royalty    = $check_data[1][royalty];
            $def_line   = $check_data[1][def_line];


            //ȯ������������Ķ�������
            $ord_num_err = $check_data[2];
        }
    }

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($buy_day["y"]."-".$buy_day["m"]."-".$buy_day["d"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

    //�ե�������ͥ��å�
    $set_data["form_buy_money"]     = number_format($data[0]);
    $set_data["form_tax_money"]     = number_format($data[1]);
    $set_data["form_total_money"]   = number_format($data[2]);
    $form->setConstants($set_data);

    /******************************/
    //�롼�����
    /******************************/
    //������
    //�����������������å�
    if(!checkdate((int)$arrival_day["m"], (int)$arrival_day["d"], (int)$arrival_day["y"])){
        $form->setElementError("form_arrival_day", "�����������դ������ǤϤ���ޤ���");
    }else{
        //�����
        if(Check_Monthly_Renew($db_con, $client_id, '2', $arrival_day["y"], $arrival_day["m"], $arrival_day["d"]) === false){
            $form->setElementError("form_arrival_day", "�������˷���������������դ���Ͽ�Ǥ��ޤ���");
        }

        //�����ƥ೫���������å�
        $arrival_day_err   = Sys_Start_Date_Chk($arrival_day["y"], $arrival_day["m"], $arrival_day["d"], "������");
        if($arrival_day_err != Null){
            $form->setElementError("form_arrival_day", $arrival_day_err);
        }       
    }

    //������
    //�����������������å�
    if(!checkdate((int)$buy_day["m"], (int)$buy_day["d"], (int)$buy_day["y"])){
        $form->setElementError("form_buy_day", "�����������դ������ǤϤ���ޤ���");
    }else{
        //�����
        if(Check_Monthly_Renew($db_con, $client_id, '2', $buy_day["y"], $buy_day["m"], $buy_day["d"]) === false){
            $form->setElementError("form_buy_day", "�������˷���������������դ���Ͽ�Ǥ��ޤ���");
        }

        //�������������å�
        if(Check_Payment_Close_Day($db_con, $client_id, $buy_day["y"], $buy_day["m"], $buy_day["d"]) === false){
            $form->setElementError("form_buy_day", "�������˻����������������դ���Ͽ�Ǥ��ޤ���");
        }

        //�����ƥ೫���������å�
        $buy_day_err   = Sys_Start_Date_Chk($buy_day["y"], $buy_day["m"], $buy_day["d"], "������");
        if($buy_day_err != Null){
            $form->setElementError("form_buy_day", $buy_day_err);
        }       
    }

    //���������»��������å�
    $buy_day["m"] = str_pad($buy_day["m"], 2, 0, STR_PAD_LEFT);
    $buy_day["d"] = str_pad($buy_day["d"], 2, 0, STR_PAD_LEFT);

    $buy_date = $buy_day["y"]."-".$buy_day["m"]."-".$buy_day["d"];

/*
    for($i = 0; $i < count($goods_id); $i++){
        //���ʥ����å�
        //���ʽ�ʣ�����å�
        for($j = 0; $j < count($goods_id); $j++){
            if($goods_id[$i] != null && $goods_id[$j] != null && $i != $j && $goods_id[$i] == $goods_id[$j]){
                //$form->setElementError("form_buy_no", "Ʊ�����ʤ��������򤵤�Ƥ��ޤ���");
                $goods_twice =  "Ʊ�����ʤ�ʣ�����򤵤�Ƥ��ޤ���";
            }
        }
    }
*/
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

    /*****************************/
    //�͸���
    /*****************************/
    if($form->validate()){

        /*******************************/
        //��Ͽ����
        /*******************************/
        //������λ�ܥ���ե饰��true�ξ��
        if($buy_comp_flg == true){

            $total_amount_data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);

            //���դ���
            $arrival_date   = $arrival_day["y"]."-".$arrival_day["m"]."-".$arrival_day["d"];  //������

            Db_Query($db_con, "BEGIN");

            //�����ѹ����Ϥξ��
            if($update_flg == true){

                //�������������Ƥ��ʤ�����ǧ
                $update_check_flg = Update_Check($db_con, "t_buy_h", "buy_id", $get_buy_id, $_POST["hdn_buy_enter_day"]);
                //���˺������Ƥ������
                if($update_check_flg === false){
                    header("Location:./1-3-205.php?buy_id=$get_buy_id&input_flg=true&del_buy_flg=true");
                    exit;
                }
                if($order_id != null){
                    //ȯ���ѹ�����Ƥ��ʤ�����ǧ
                    $update_data_check_flg = Update_Data_Check($db_con, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_change_day"]);
                    if($update_data_check_flg === false){
                        header("Location:./1-3-205.php?buy_id=0&input_flg=true&change_ord_flg=true");
                        exit;
                    }
                }
                //��ʧ�إå���Ȥꤢ�������
                $sql  = "DELETE FROM t_payout_h WHERE buy_id = $get_buy_id";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //�ֻ����إå��ơ��֥�פβ����ξ���򹹿�
                $sql  = "UPDATE\n";
                $sql .= "    t_buy_h\n";
                $sql .= " SET\n";
                $sql .= "    buy_no = '$buy_no',\n";
                $sql .= "    buy_day = '$buy_date',\n";
                $sql .= "    arrival_day = '$arrival_date',\n";
                $sql .= "    client_id = $client_id,\n";
                $sql .= ($direct != null) ? " direct_id = $direct,\n" : " direct_id = NULL, ";
                $sql .= "    trade_id = '$trade',\n";
                $sql .= "    note = '$note',\n";
                $sql .= "    c_staff_id = $buy_staff,\n";
                $sql .= ($order_staff != null) ? " oc_staff_id = $order_staff,\n" : " oc_staff_id = NULL, ";
                $sql .= "    ware_id = $ware,\n";
                $sql .= "    e_staff_id = $staff_id,\n";
                $sql .= "    net_amount = $total_amount_data[0],\n";
                $sql .= "    tax_amount = $total_amount_data[1],\n";
                $sql .= ($trade == 25) ? "    total_split_num = 2," : "    total_split_num = 1,";
                $sql .= "    client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= ($direct != null) ? " direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct), " : " direct_name = NULL, ";
                $sql .= ($direct != null) ? " direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), " : " direct_name2 = NULL, ";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";
                $sql .= "    c_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $buy_staff), ";
                $sql .= "    e_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), ";
                $sql .= ($order_staff != null) ? " oc_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $order_staff), " : " oc_staff_name = NULL, ";
                $sql .= "    client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id),";
                $sql .= "    change_day = CURRENT_TIMESTAMP";
                $sql .= " WHERE\n";
                $sql .= "    buy_id = $get_buy_id\n";
                $sql .= ";\n";

                $result = Db_Query($db_con, $sql);

                //���Ԥ������ϥ���Хå�
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                //�ֻ����ǡ����ơ��֥�פ���GET�Ǽ�����������ID�ȥޥå�����ǡ�������
                $sql  = "DELETE FROM";
                $sql .= "    t_buy_d";
                $sql .= " WHERE";
                $sql .= "    buy_id = $get_buy_id";
                $sql .= ";";
               
                $result = Db_Query($db_con, $sql);
                //���Ԥ������ϥ���Хå�
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                //ʬ��ơ��֥����Ͽ����Ƥ���ǡ�������
                $sql  = "DELETE FROM\n";
                $sql .= "   t_amortization\n";
                $sql .= " WHERE\n";
                $sql .= "   buy_id = $get_buy_id\n";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                //���Ԥ������ϥ���Хå�
                if($result === false){
                    Db_Query($db_con, $sql);
                    exit;
                }

                //ȯ���鵯�����Ƥ�����ˤϰ��ٶ�����λ���Ƥ��ʤ�ȯ����Ф���ȯ��ĥե饰��true�ˤ���
                if($order_flg == true){
                    $sql  = "UPDATE";
                    $sql .= "   t_order_d \n";
                    $sql .= "SET\n";
                    $sql .= "   rest_flg = 't' \n";
                    $sql .= "WHERE\n";
                    $sql .= "   ord_id = $order_id\n";
                    $sql .= "   AND\n";
                    $sql .= "   finish_flg = 'f'\n";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
                }

            //�����������Ϥξ��
            }else{
                if($order_flg == true){
                    //ȯ���������Ƥ��ʤ������ǧ
                    $update_check_flg = Update_Check($db_con, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_enter_day"]);

                    //���˺������Ƥ������
                    if($update_check_flg === false){
                        header("Location:./1-3-205.php?buy_id=0&input_flg=true&del_ord_flg=true");
                        exit;
                    }

                    //ȯ���ѹ�����Ƥ��ʤ�����ǧ
                    $update_data_check_flg = Update_Data_Check($db_con, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_change_day"]);
                    if($update_data_check_flg === false){
                        header("Location:./1-3-205.php?buy_id=0&input_flg=true&change_ord_flg=true");
                        exit;
                    }
                }
                $sql  = "INSERT INTO t_buy_h (\n";
                $sql .= "    buy_id,\n";                                                            //������ID
                $sql .= "    buy_no,\n";                                                            //�����ֹ�
                if($order_flg == true){
                    $sql .= "    ord_id,\n";                                                        //ȯ��ID
                }
                $sql .= "    buy_day,\n";                                                           //������
                $sql .= "    arrival_day,\n";                                                       //������
                $sql .= "    client_id,\n";                                                         //������ID
                if($direct != null){
                    $sql .= "    direct_id,\n";                                                     //ľ����ID
                }
                $sql .= "    trade_id,\n";                                                          //�����CD
                $sql .= "    note,\n";                                                              //����
                $sql .= "    c_staff_id,\n";                                                        //����ô����ID
                $sql .= "    ware_id,\n";                                                           //�Ҹ�ID
                $sql .= "    e_staff_id,\n";                                                        //���ϼ�ID
                $sql .= "    shop_id,\n";                                                           //����å�ID
                $sql .= "    net_amount,\n";                                                        //������ۡ���ȴ����
                $sql .= "    tax_amount,\n";                                                        //�����ǳ�
                $sql .= ($order_staff != null) ? " oc_staff_id,\n" : null;                          //ȯ��ô����ID
                $sql .= "    total_split_num, \n";                                                  //ʬ����
                $sql .= "    client_cd1, ";                                                         //�����襳���ɣ�
                $sql .= "    client_cd2, ";                                                         //�����襳���ɣ�
                $sql .= "    client_name, ";                                                        //������̾��
                $sql .= "    client_name2, ";                                                       //������̾��
                $sql .= ($direct != null) ? " direct_name, " : null;                                //ľ����̾��
                $sql .= ($direct != null) ? " direct_name2, " : null;                               //ľ����̾��
                $sql .= "    ware_name, ";                                                          //�Ҹ�̾
                $sql .= "    c_staff_name, ";                                                       //����ô����̾
                $sql .= ($order_staff != null) ? " oc_staff_name, " : null;                         //ȯ��ô����̾
                $sql .= "    e_staff_name, ";                                                       //���ϼ�̾
                $sql .= "    client_cname, ";                                                       //ά��
                $sql .= "    buy_div ";                                                             //������ʬ
                $sql .= ")VALUES(\n";
                $sql .= "    (SELECT COALESCE(MAX(buy_id), 0)+1 FROM t_buy_h),\n";                  //������ID
                $sql .= "    '$buy_no',\n";                                                         //�����ֹ�
                if($order_flg == true){
                    $sql .= "    $order_id,\n";                                                     //ȯ��ID
                }
                $sql .= "    '$buy_date',\n";                                                       //������
                $sql .= "    '$arrival_date',\n";                                                   //����ͽ����
                $sql .= "    $client_id,\n";                                                        //������ID
                if($direct != null){
                    $sql .= "    $direct,\n";                                                       //ľ����ID
                }
                $sql .= "    '$trade',\n";                                                          //�����ID
                $sql .= "    '$note',\n";                                                           //����
                $sql .= "    $buy_staff,\n";                                                        //����ô����ID
                $sql .= "    $ware,\n";                                                             //�Ҹ�ID
                $sql .= "    $staff_id,\n";                                                         //���ϼ�ID
                $sql .= "    $shop_id,\n";                                                          //����å�ID
                $sql .= "    $total_amount_data[0],\n";                                             //������ۡ���ȴ����
                $sql .= "    $total_amount_data[1],\n";                                             //�����ǳ�
                $sql .= ($order_staff != null) ? " $order_staff,\n" : null;                         //ȯ��ô����
                $sql .= ($trade == 25) ? "   2, \n" : "   1, \n";                                   //ʬ���ʧ���
                $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";     //�����襳���ɣ�
                $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";     //�����襳���ɣ�
                $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";    //������̾
                $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";   //������̾��
                $sql .= ($direct != null) ? " (SELECT direct_name FROM t_direct WHERE direct_id = $direct), " : null;   //ľ����̾��
                $sql .= ($direct != null) ? " (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), " : null;  //ľ����̾��
                $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";               //�Ҹ�̾
                $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $buy_staff), ";       //����ô����̾
                $sql .= ($order_staff != null) ? " (SELECT staff_name FROM t_staff WHERE staff_id = $order_staff), " : null;//ȯ��ô����̾
                $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), ";        //���ϼ�̾
                $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id),\n";  //������̾ά��
                $sql .= "   '2'\n";                                                                 //������ʬ
                $sql .= ");\n";

                $result = Db_Query($db_con, $sql);

                //���Ԥ������ϥ���Хå�
                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_buy_h_buy_no_key";
                    Db_Query($db_con, "ROLLBACK");

                    //ȯ��NO����ʣ�������
                    if(strstr($err_message,$err_format) !== false){
                        $error = "Ʊ���˻�����Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦���ٻ�����ԤäƤ���������";

                        //����ȯ��NO���������
                        $sql  = "SELECT ";
                        $sql .= "   MAX(buy_no)";
                        $sql .= " FROM";
                        $sql .= "   t_buy_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $shop_id";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $buy_no = pg_fetch_result($result, 0 ,0);

                        $buy_no = $buy_no +1;
                        $buy_no = str_pad($buy_no, 8, 0, STR_PAD_LEFT);
                        $err_data["form_buy_no"] = $buy_no;
                        $form->setConstants($err_data);
                        $duplicate_err = true;
                    }else{
                        exit;
                    }
                }
            }
            if($duplicate_err != true){

                //����ID�����
                $sql  = "SELECT";
                $sql .= "   buy_id";
                $sql .= " FROM";
                $sql .= "   t_buy_h";
                $sql .= " WHERE";
                $sql .= "   buy_no = '$buy_no'";
                $sql .= "   AND";
                $sql .= "   shop_id = $shop_id";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                $buy_id = pg_fetch_result($result,0,0);

                //�����ʧ�ơ��֥����Ͽ
                if($trade == "25"){
                    $division_array = Division_Price($db_con, $client_id, ($total_amount_data[0] + $total_amount_data[1]), $buy_day["y"], $buy_day["m"], 2);
                    for($k=0;$k<2;$k++){
                        $sql  = "INSERT INTO t_amortization (\n";
                        $sql .= "   amortization_id,\n";
                        $sql .= "   buy_id,\n";
                        $sql .= "   pay_day,\n";
                        $sql .= "   split_pay_amount\n";
                        $sql .= " )VALUES(\n";
                        $sql .= "   (SELECT COALESCE(MAX(amortization_id),0)+1 FROM t_amortization),\n";
                        $sql .= "   $buy_id,\n";
                        $sql .= "   '".$division_array[1][$k]."', \n";
                        $sql .= "   ".$division_array[0][$k]." \n";
                        $sql .= ");";

                        $reuslt = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                    }
                }

                for($i = 0; $i < count($goods_id); $i++){
                    //��
                    $line = $i + 1;

                    //���������ȴ���������ǳۡ������ǹ�פ򻻽�
                    $price = $buy_price[$i]["i"].".".$buy_price[$i]["d"];   //�������
                    $buy_amount = bcmul($price, $buy_num[$i],3);
                    $buy_amount = Coax_Col($coax, $buy_amount);

                    $sql  = "INSERT INTO t_buy_d (\n";
                    $sql .= "    buy_d_id,\n";
                    $sql .= "    buy_id,\n";
                    $sql .= "    line,\n";
                    $sql .= "    goods_id,\n";
                    $sql .= "    goods_name,\n";
                    $sql .= "    num,\n";
                    $sql .= "    tax_div,\n";
                    $sql .= "    buy_price,\n";
                    $sql .= "    buy_amount,\n";
                    $sql .= ($order_d_id[$i] != null) ? " ord_d_id,\n " : null;
                    $sql .= "    goods_cd, \n";
                    $sql .= "    in_num \n";
                    $sql .= ")VALUES(\n";
                    $sql .= "    (SELECT COALESCE(MAX(buy_d_id), 0)+1 FROM t_buy_d),\n";
                    $sql .= "    $buy_id,\n";
                    $sql .= "    $line,\n";
                    $sql .= "    $goods_id[$i],\n";
                    $sql .= "    '$goods_name[$i]',\n";
                    $sql .= "    $buy_num[$i],\n";
                    $sql .= "    $tax_div[$i],\n";
                    $sql .= "    $price,\n";
                    $sql .= "    $buy_amount,\n";
                    $sql .= ($order_d_id[$i] != null) ? "    $order_d_id[$i],\n " : null;
                    $sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_id[$i]),\n ";
                    $sql .= "    (SELECT in_num FROM t_goods WHERE goods_id = $goods_id[$i]) \n";
                    $sql .= ");\n";

                    $result = Db_Query($db_con, $sql);
                    //���Ԥ������ϥ���Хå�
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }

                    //�����ǡ���ID�����
                    $sql  = "SELECT";
                    $sql .= "   buy_d_id";
                    $sql .= " FROM";
                    $sql .= "   t_buy_d";
                    $sql .= " WHERE";
                    $sql .= "   buy_id = $buy_id";
                    $sql .= "   AND";
                    $sql .= "   line = $line";
                    $sql .= ";";
                    $result = Db_Query($db_con, $sql);
                    $buy_d_id = pg_fetch_result($result,0,0);

                    //ľ���褬���򤵤�Ƥ��ʤ���н�������
//                    if($direct == null){

                    //�߸˿��ơ��֥�
                    //����ȯ��ID<>NULL�ξ��
                    if($order_id != NULL){

                        if($order_d_id[$i] != "NULL"){
                            //�߸˼���ʧ���ơ��֥�
                            //ȯ��ĺ��
                            $sql  = "INSERT INTO t_stock_hand (\n";
                            $sql .= "    goods_id,\n";
                            $sql .= "    enter_day,\n";
                            $sql .= "    work_day,\n";
                            $sql .= "    work_div,\n";
                            $sql .= "    client_id,\n";
                            $sql .= "    ware_id,\n";
                            $sql .= "    io_div,\n";
                            $sql .= "    num,\n";
                            $sql .= "    slip_no,\n";
                            $sql .= "    buy_d_id,\n";
                            $sql .= "    staff_id,\n";
                            $sql .= "    shop_id,\n";
                            $sql .= "    client_cname\n";
                            $sql .= ")VALUES(\n";
                            $sql .= "    $goods_id[$i],\n";
                            $sql .= "    NOW(),\n";
                            $sql .= "    '$arrival_date',\n";
                            $sql .= "    '3',\n";
                            $sql .= "    $client_id,\n";
                            $sql .= "    $ware,\n";
                            $sql .= "    '2',\n";
//                        $sql .= "    $order_num[$i] - $buy_num[$i],";

                            //ȯ����Ǿä���ǽ�������
                            $deny_num = Get_Deny_Num($db_con, $order_d_id[$i], $buy_id);
//print "��������".$buy_num[$i] ."<br>";
//print "ȯ����Ǿò�ǽ����".$deny_num ."<br>";
                            //��������ȯ����Ǿò�ǽ����Ķ�������
                            if($buy_num[$i] > $deny_num){
                                $del_num = $deny_num;
                            }else{
                                $del_num = $buy_num[$i];
                            }
//print "ȯ����Ǿÿ���".$del_num ."<br>";

                            $sql .= "    $del_num,\n";
                            $sql .= "    '$buy_no',\n";
                            $sql .= "    $buy_d_id,\n";
                            $sql .= "    $staff_id,\n";
                            $sql .= "    $shop_id,\n";
                            $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                            $sql .= ");\n";

                            $result = Db_Query($db_con, $sql);
                            //���Ԥ������ϥ���Хå�
                            if($result === false){
                                Db_Query($db_con,"ROLLBACK");
                                exit;
                            }

                        }

                        //����ȯ��
                        $sql  = "INSERT INTO t_stock_hand (";
                        $sql .= "    goods_id,";
                        $sql .= "    enter_day,";
                        $sql .= "    work_day,";
                        $sql .= "    work_div,";
                        $sql .= "    client_id,";
                        $sql .= "    ware_id,";
                        $sql .= "    io_div,";
                        $sql .= "    num,";
                        $sql .= "    slip_no,";
                        $sql .= "    buy_d_id,";
                        $sql .= "    staff_id,";
                        $sql .= "    shop_id,";
                        $sql .= "    client_cname";
                        $sql .= ")VALUES(";
                        $sql .= "    $goods_id[$i],";
                        $sql .= "    NOW(),";
                        $sql .= "    '$arrival_date',";
                        $sql .= "    '4',";
                        $sql .= "    $client_id,";
                        $sql .= "    $ware,";
                        $sql .= "    '1',";
                        $sql .= "    $buy_num[$i],";
                        $sql .= "    '$buy_no',";
                        $sql .= "    $buy_d_id,";
                        $sql .= "    $staff_id,";
                        $sql .= "    $shop_id,";
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        //���Ԥ������ϥ���Хå�
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }

                    //����ȯ��ID��NULL��AND�������ʬ�ᣲ���ʳݻ����ˡ������ʸ�������ˤξ��
                    }elseif($order_id == NULL && ($trade == '21' || $trade == '71' || $trade == '25')){

                        $result = Db_Query($db_con, $sql);
                        $num = pg_num_rows($result);
   
                        //�߸˼���ʧ���ơ��֥�ʻ���ȯ����
                        $sql  = "INSERT INTO t_stock_hand (";
                        $sql .= "    goods_id,";
                        $sql .= "    enter_day,";
                        $sql .= "    work_day,";
                        $sql .= "    work_div,";
                        $sql .= "    client_id,";
                        $sql .= "    ware_id,";
                        $sql .= "    io_div,";
                        $sql .= "    num,";
                        $sql .= "    slip_no,";
                        $sql .= "    buy_d_id,";
                        $sql .= "    staff_id,";
                        $sql .= "    shop_id,";
                        $sql .= "    client_cname";
                        $sql .= " )VALUES(";
                        $sql .= "    $goods_id[$i],";
                        $sql .= "    NOW(),";
                        $sql .= "    '$arrival_date',";
                        $sql .= "    '4',";
                        $sql .= "    $client_id,";
                        $sql .= "    $ware,";
                        $sql .= "    '1',";
                        $sql .= "    $buy_num[$i],";
                        $sql .= "    '$buy_no',";
                        $sql .= "    $buy_d_id,";
                        $sql .= "    $staff_id,";
                        $sql .= "    $shop_id,";
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        //���Ԥ������ϥ���Хå�
                        if($result === false){
                            Db_Query($db_con,"ROLLBACK");
                            exit;
                        }
                    //����ȯ��ID��NULL��AND�������ʬ�ᣲ���ʳ����ʡˡ������ʸ������ʡˤξ��
                    }elseif($order_id == NULL && ($trade == '23' || $trade == '73')){

                        //�߸˼���ʧ���ʻ���ȯ����
                        $sql  = "INSERT INTO t_stock_hand (";
                        $sql .= "    goods_id,";
                        $sql .= "    enter_day,";
                        $sql .= "    work_day,";
                        $sql .= "    work_div,";
                        $sql .= "    client_id,";
                        $sql .= "    ware_id,";
                        $sql .= "    io_div,";
                        $sql .= "    num,";
                        $sql .= "    slip_no,";
                        $sql .= "    buy_d_id,";
                        $sql .= "    staff_id,";
                        $sql .= "    shop_id,";
                        $sql .= "    client_cname";
                        $sql .= ")VALUES(";
                        $sql .= "    $goods_id[$i],";
                        $sql .= "    NOW(),";
                        $sql .= "    '$arrival_date',";
                        $sql .= "    '4',";
                        $sql .= "    $client_id,";
                        $sql .= "    $ware,";
                        $sql .= "    '2',";
                        $sql .= "    $buy_num[$i],";
                        $sql .= "    '$buy_no',";
                        $sql .= "    $buy_d_id,";
                        $sql .= "    $staff_id,";
                        $sql .= "    $shop_id,";
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        //���Ԥ������ϥ���Хå�
                        if($result === false){
                            Db_Query($db_con,"ROLLBACK");
                            exit;
                        }
//                        }
                    }

                    //ȯ��򵯤������Ƥ����ΤϽ�������
                    if($order_id != NULL){
                        //�����˾��ʤ��ɲä��줿���
                        if($order_d_id[$i] == null){
                            $order_d_id[$i] = "null";
                        }

                        //ȯ��إå��ơ��֥�ʽ�����������������
                        $sql  = "UPDATE\n";
                        $sql .=     " t_order_d\n";
                        $sql .= " SET\n";
                        $sql .= "    rest_flg='f'\n ";
                        $sql .= " FROM\n";
                        $sql .= "   (SELECT\n";
                        $sql .= "       ord_d_id,\n";
                        $sql .= "       SUM(num) AS buy_num\n ";
                        $sql .= "   FROM\n";
                        $sql .= "       t_buy_d\n";
                        $sql .= "   GROUP BY ord_d_id\n";
                        $sql .= "   ) AS t_buy_d\n";
                        $sql .= " WHERE\n ";
                        $sql .= "   t_order_d.ord_d_id = t_buy_d.ord_d_id\n";
                        $sql .= "   AND\n ";
                        $sql .= "   t_order_d.ord_d_id = $order_d_id[$i]\n";
                        $sql .= "   AND \n";
                        $sql .= "   t_order_d.num <= t_buy_d.buy_num\n";
                        $sql .= ";\n";

                        $result = Db_Query($db_con, $sql);
                        //���Ԥ������ϥ���Хå�
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }

                        //���������������ȯ�����Ķ���Ƥ��ʤ�����ǧ
                        //������ǽ��������
                        $sql  = "SELECT\n";
                        $sql .= "    t_order_h.num - COALESCE(t_buy_h.num, 0) AS num \n";
                        $sql .= "FROM\n";
                        $sql .= "    (SELECT\n";
                        $sql .= "        num,\n";
                        $sql .= "        ord_d_id \n";
                        $sql .= "    FROM\n";
                        $sql .= "        t_order_d\n";
                        $sql .= "    WHERE\n";
                        $sql .= "        t_order_d.ord_d_id = $order_d_id[$i]\n";
                        $sql .= "    ) AS t_order_h\n";
                        $sql .= "        LEFT JOIN\n";
                        $sql .= "    (SELECT\n";
                        $sql .= "        SUM(num) AS num,\n";
                        $sql .= "        ord_d_id \n";
                        $sql .= "    FROM\n";
                        $sql .= "        t_buy_h\n";
                        $sql .= "            INNER JOIN\n";
                        $sql .= "        t_buy_d\n";
                        $sql .= "        ON t_buy_h.buy_id = t_buy_d.buy_id\n";
                        $sql .= "    WHERE\n";
                        $sql .= "        t_buy_d.ord_d_id = $order_d_id[$i]\n";
                        $sql .= "        AND\n";
                        $sql .= "        t_buy_h.buy_id <> $buy_id\n";
                        $sql .= "    GROUP BY ord_d_id\n";
                        $sql .= "    ) AS t_buy_h\n";
                        $sql .= "    ON t_order_h.ord_d_id = t_buy_h.ord_d_id\n";
                        $sql .= ";\n";

                        $result = Db_Query($db_con, $sql);

                        if(pg_num_rows($result) > 0){
                            $buy_ord_num = pg_fetch_result($result,0,0);
                        }

                        //��������ȯ�������äƤ�����
                        if($buy_ord_num < 0){
                            Db_Query($db_con, "ROLLBACK;");
                            $rollback_flg = true;
                            $buy_ord_num_err = "��������ȯ�����Ķ���Ƥ��ޤ���";
                            break;
                        }
                    }
                }

                if($rollback_flg != true){
                    //ȯ��򵯤����Ƥ����ΤϽ�������
                    if($order_id != NULL){
                        //����������������
                        $ary_order_d_id = implode(",",$order_d_id);

                        $sql  = "SELECT";
                        $sql .= "   rest_flg";
                        $sql .= " FROM";
                        $sql .= "   t_order_d";
                        $sql .= " WHERE";
                        $sql .= "   ord_d_id IN ($ary_order_d_id)";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $data_num = pg_num_rows($result);
                        for($i = 0; $i < $data_num; $i++){
                            $rest_data[] = pg_fetch_result($result,$i,0);
                        }

                        //ȯ��Ĥ�������
                        if(in_array('t',$rest_data)){
                            $sql  = "UPDATE";
                            $sql .= "    t_order_h";
                            $sql .= " SET";
                            $sql .= "    ps_stat = '2'";
                            $sql .= " WHERE";
                            $sql .= "    ord_id = $order_id";
                            $sql .= ";";
                        //ȯ�������Ƥξ��ʤ�ȯ��ĥե饰��f�ξ��
                        }else{
                            $sql  = "UPDATE";
                            $sql .= "    t_order_h";
                            $sql .= " SET";
                            $sql .= "    ps_stat = '3'";
                            $sql .= " WHERE";
                            $sql .= "    ord_id = $order_id";
                            $sql .= ";";
                        }

                        $result = Db_Query($db_con, $sql);
                        //���Ԥ������ϥ���Хå�
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }

                    }

                    //�������μ�ư��ʧ����
                    //�����ʬ�᣷���ʸ�������ˡ���3�ʸ����Ͱ��ˡ���4�ʸ������ʡˤξ��Τ߽�������
                    if($trade == '71' || $trade == '73' || $trade == '74'){

                        $sql  = "SELECT";
                        $sql .= "   MAX(pay_no)";
                        $sql .= " FROM";
                        $sql .= "   t_payout_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $shop_id";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $pay_no = pg_fetch_result($result, 0,0);
                        $pay_no = $pay_no + 1;
                        $pay_no = str_pad($pay_no, 8, 0, STR_PAD_LEFT);

                        $sql  = "INSERT INTO t_payout_h(\n";
                        $sql .= "   pay_id,\n";               //��ʧID
                        $sql .= "   pay_no,\n";               //��ʧ�ֹ�
                        $sql .= "   pay_day,\n";              //��ʧ��
                        $sql .= "   client_id,\n";            //������ID
                        $sql .= "   client_name,\n";          //������̾
                        $sql .= "   client_name2,\n";         //������̾��
                        $sql .= "   client_cname,\n";         //�������ά�Ρ�
                        $sql .= "   client_cd1,\n";           //�����襳����
                        $sql .= "   client_cd2,\n";           //�����襳����
                        $sql .= "   e_staff_id,\n";           //���ϼ�ID
                        $sql .= "   e_staff_name,\n";         //���ϼ�̾
                        $sql .= "   c_staff_id,\n";           //ô����ID
                        $sql .= "   c_staff_name,\n";         //ô����̾
                        $sql .= "   input_day,\n";            //������
                        $sql .= "   buy_id,\n";               //����ID
                        $sql .= "   shop_id\n";               //����å�ID
                        $sql .= ")VALUES(\n";
                        $sql .= "   (SELECT COALESCE(MAX(pay_id), 0)+1 FROM t_payout_h),\n";
                        $sql .= "   '$pay_no',\n";
                        $sql .= "   '".$buy_date."',\n";
                        $sql .= "   $client_id,\n";
                        $sql .= "   (SELECT client_name FROM t_client WHERE client_id = $client_id),\n";
                        $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = $client_id),\n";
                        $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $client_id), \n";
                        $sql .= "   (SELECT client_cd1 FROM t_client WHERE client_id = $client_id),\n";
                        $sql .= "   (SELECT client_cd2 FROM t_client WHERE client_id = $client_id),\n";
                        $sql .= "   $staff_id,\n";
                        $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), \n";
                        $sql .= "   $buy_staff,\n";
                        $sql .= "   (SELECT staff_name FROM t_staff WHERE staff_id = $buy_staff),\n";
                        $sql .= "   NOW(), \n";
                        $sql .= "   $buy_id, \n";
                        $sql .= "   $shop_id \n";
                        $sql .= "); \n";

                        $result = Db_Query($db_con, $sql);

                        //���Ԥ������ϥ���Хå�
                        if($result === false){
                            $err_message = pg_last_error();
                            $err_format = "t_payout_h_pay_no_key";
                            $err_flg = true;
                            Db_Query($db_con, "ROLLBACK;");

                            //��ʣ�������
                            if(strstr($err_message, $err_format) != false){
                                $duplicate_msg = "��ʧ��Ʊ���˹Ԥʤ�줿���ᡢ��ɼ�ֹ�����֤˼��Ԥ��ޤ�����";
                                $duplicate_flg = true;
                            }else{
                                exit;
                            }
                        }

                        if($duplicate_flg != true){
                            //��Ͽ������ʧ�إå�ID�����
                            $sql  = "SELECT";
                            $sql .= "   pay_id ";
                            $sql .= "FROM";
                            $sql .= "   t_payout_h ";
                            $sql .= "WHERE";
                            $sql .= "   pay_no = '$pay_no'";
                            $sql .= "   AND";
                            $sql .= "   shop_id = $shop_id";
                            $sql .= ";";

                            $result = Db_Query($db_con, $sql);
                            $pay_id = pg_fetch_result($result, 0,0);

                            //��ʧ���ǡ����ơ��֥����Ͽ
                            $sql  = "INSERT INTO t_payout_d (";
                            $sql .= "   pay_d_id,";
                            $sql .= "   pay_id,";
                            $sql .= "   trade_id,";
                            $sql .= "   pay_amount";
                            $sql .= ")VALUES(";
                            $sql .= "   (SELECT COALESCE(MAX(pay_d_id),0)+1 FROM t_payout_d),";
                            $sql .= "   $pay_id,";
                            $sql .= "   '49',";
                            //�����ʬ�����������ʧ�ξ��
                            if($trade == '71'){
                                $sql .= "   $total_amount_data[2]";
                            //�����ʬ�������������ξ��
                            }else{
                                $sql .= "   $total_amount_data[2]*-1";
                            }
                            $sql .= ");";

                            $result = Db_Query($db_con, $sql);
                            if($result === false){
                                Db_Query($db_con, "ROLLBACK;");
                                exit;
                            }
                        }
                    }

                    Db_Query($db_con, "COMMIT");
                    header("Location:./1-3-205.php?buy_id=$buy_id&input_flg=true&buy_div=2");
                }
            }

        //ȯ���ǧ�إܥ��󲡲��ե饰��true�ξ��
        }elseif($buy_button_flg == true){
            //�ե������Ǥ�뤿��Υե꡼���ե饰
            $freeze_flg = true;
        }
    }
}

/****************************/
//ưŪ����������ե��������
/****************************/
//���ֹ楫����
$row_num = 1;

for($i = 0; $i < $max_row; $i++){

    //�����褬���򤵤�Ƥ��ʤ���������Ͽ��ǧ�ξ��ϥե꡼��
    if($select_flg == false 
        || 
    //aoyama-n 2009-09-15
    #$order_d_id[$i] != null){
    #2009-10-19 hashimoto-y
    #$order_d_id[$i] != null || $freeze_flg == true){

    #2009-10-20 hashimoto-y
    # $freeze_flg == true){
    $order_d_id[$i] != null || $freeze_flg == true){

        //aoyama-n 2009-09-15
        /**********
        $style = "color : #000000;
              border : #ffffff 1px solid;
              background-color: #ffffff";
        **********/
        $style = "border: #ffffff 1px solid; background-color: #ffffff; ";
        $type = "readonly";
        //aoyama-n 2009-09-15
        $g_form_option = "";
    }else{
        $style = null;
        $type = $g_form_option;
    }

    //aoyama-n 2009-09-15
    //�Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
    $font_color = "";
    $form_trade       = $form->getElementValue("form_trade");
    $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

    if($hdn_discount_flg === 't' ||
       $form_trade[0] == '23' || $form_trade[0] == '24' || $form_trade[0] == '73' || $form_trade[0] == '74'){
        $font_color = "color: red; ";
    }else{
        $font_color = "color: #000000; ";
    }


    //ɽ����Ƚ��
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;

        //ȯ��ID
        $form->addElement("hidden","hdn_order_d_id[$i]");

        //����ID
        $form->addElement("hidden","hdn_goods_id[$i]");

        //���ʥ�����
        //aoyama-n 2009-09-15
        if($select_flg == true){
            $form->addElement(
                "text","form_goods_cd[$i]","",
                "size=\"10\" maxLength=\"8\"
                style=\"$font_color $style $g_form_style \" $type 
                onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'hdn_goods_search_flg', $i ,$row_num)\""
            );

        }else{
            $form->addElement(
                "text","form_goods_cd[$i]","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly"
            );
        }

        //����̾
        //aoyama-n 20009-09-15
        #if($name_change[$i] == '2'){
        #    $form->addElement(
        #        "text","form_goods_name[$i]","",
        #        "size=\"54\" style=\"$font_color $style\" $g_text_readonly"
        #    );
        #2009-10-20 hashimoto-y
        if($name_change[$i] == '2' && $freeze_flg != true){
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" style=\"$font_color\" $g_text_readonly $type"
            );
        }elseif($select_flg == false){
            $form->addElement(
                "text","form_goods_name[$i]","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly"
            );
        #2009-10-20 hashimoto-y
        }elseif($order_d_id[$i] != null && $freeze_flg != true){
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" maxLength=\"41\"
                 style=\"$font_color $g_form_option\""
            );
        }else{
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" maxLength=\"41\" 
                 style=\"$font_color $style $g_form_option\" $type" 
            );
        }

        $form->addElement("hidden","hdn_name_change[$i]","","");
        $form->addElement("hidden","hdn_stock_manage[$i]","","");

        //����
        //aoyama-n 2009-09-15
        $form->addElement("text","form_in_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" 
            readonly"
        );

        //��ʸ����
        //aoyama-n 2009-09-15
        if($freeze_flg == true){
            $form->addElement("text","form_order_in_num[$i]","",
                "size=\"6\" maxLength=\"5\"
                onKeyup=\"in_num($i,'hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $style \" $type"
            );
        }elseif($select_flg == false){
            $form->addElement(
                "text","form_order_in_num[$i]","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly'"
            );
        }else{
            $form->addElement("text","form_order_in_num[$i]","",
                "size=\"6\" maxLength=\"5\"
                onKeyup=\"in_num($i,'hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $g_form_style $g_form_option\" "
            );
        }

        //���߸˿�
        //aoyama-n 2009-09-15
        $form->addElement(
            "text","form_stock_num[$i]","",
            "size=\"11\" maxLength=\"5\" 
            style=\"$font_color
            border : #ffffff 1px solid;
            background-color: #ffffff; text-align: right\" 
            readonly"
        );

        //ȯ���
        //aoyama-n 2009-09-15
        $form->addElement(
            "hidden","form_order_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right \"readonly"
        );

        //�����ѿ�
        $form->addElement(
            "text","form_rbuy_num[$i]","",
            'size="11" maxLength=\"9\" 
            style="color : #000000; 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right" readonly'
        );

        //������
        //aoyama-n 2009-09-15
        if($freeze_flg == true){
            $form->addElement("text","form_buy_num[$i]","",
                "size=\"6\" maxLength=\"5\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');ord_in_num($i);\"
                style=\"text-align: right; $font_color $style $g_form_style \" $type"
            );
        }elseif($select_flg == false){
            $form->addElement(
                "text","form_buy_num[$i]","",
                "style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly'"
            );
        }else{
            $form->addElement("text","form_buy_num[$i]","",
                "size=\"6\" maxLength=\"5\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');ord_in_num($i);\"
                style=\"text-align: right; $font_color $g_form_style;\" $g_form_option "
            );
        }

        //����ñ��
        //aoyama-n 2009-09-15
        if($select_flg == false){
            $form_buy_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly"
            );
            $form_buy_price[$i][] =& $form->createElement("static","","",".");
            $form_buy_price[$i][] =& $form->createElement(
                "text","d","",
                "size=\"1\" style=\"color : #525552;
                border : #ffffff 1px solid;
                background-color: #ffffff;
                text-align: left\" readonly'"
            );

        #2009-10-20 hashimoto-y
        }elseif($order_d_id[$i] != null && $freeze_flg != true){
            $form_buy_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" maxLength=\"9\" class=\"money\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $g_form_style \" $g_form_option
                "
            );
            $form_buy_price[$i][] =& $form->createElement("static","","",".");
            $form_buy_price[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: left; $font_color $g_form_style \" $g_form_option
            "
            );
        }else{
            $form_buy_price[$i][] =& $form->createElement(
                "text","i","",
                "size=\"11\" maxLength=\"9\" class=\"money\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: right; $font_color $style $g_form_style \" $type
                "
            );
            $form_buy_price[$i][] =& $form->createElement("static","","",".");
            $form_buy_price[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\"
                onKeyup=\"Mult('hdn_goods_id[$i]','form_buy_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
                style=\"text-align: left; $font_color $style $g_form_style \" $type
            "
            );
        }
        $form->addGroup($form_buy_price[$i], "form_buy_price[$i]", "");

        //���Ƕ�ʬ
        $form->addElement(
            "text","form_tax_div[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"color : #000000; 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );
        $form->addElement("hidden","hdn_tax_div[$i]","","");

        //���(��ȴ��)
        //aoyama-n 2009-09-15
        $form->addElement(
            "text","form_buy_amount[$i]","",
            "size=\"25\" maxLength=\"18\"
             style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly"
        );

        //ȯ���
        //aoyama-n 2009-09-15
        $form->addElement(
            "text","form_rorder_num[$i]","",
            "size=\"11\" maxLength=\"9\"
            style=\"$font_color
            border : #ffffff 1px solid;
            background-color: #ffffff;
            text-align: right\" readonly'"
        );

        //�������
        $form->addElement(
            "link","form_search[$i]","","#","����",
            "TABINDEX=-1
            onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','hdn_goods_search_flg'), 500, 450,5,$client_id,$i,$row_num);\""
            );


        //��Ͽ��ǧ���̤ξ�����ɽ��
        if($select_flg === true ){
            //������
            //�ǽ��Ԥ��������硢���������κǽ��Ԥ˹�碌��
            if($row_num == $max_row-$del_num){
                $form->addElement(
                    "link","form_del_row[$i]","","#",
                    "<font color='#FEFEFE'>���</font>",
                    "TABINDEX=-1 
                    onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1);return false;\""
                );
            //�ǽ��԰ʳ����������硢�������Ԥ�Ʊ��NO�ιԤ˹�碌��
            }else{
                $form->addElement(
                    "link","form_del_row[$i]","","#",
                    "<font color='#FEFEFE'>���</font>",
                    "TABINDEX=-1 
                    onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num);return false;\""
                );
            }
        }

        //�ե꡼���ե饰��true�ξ��
        //aoyama-n 2009-09-15
        /********************
        if($freeze_flg == true){
            $form->freeze();
        }
        ********************/

        /****************************/
        //ɽ����HTML����
        /****************************/
        $html .= "<tr class=\"Result1\">";
        $html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        //�Ҹˡ������褬���򤵤�Ƥ��ơ���ǧ���̤�ɽ���Ǥʤ����
        if($select_flg === true && $freeze_flg != true 
               && 
        //ȯ��ǡ���ID��null�ξ��
        ($order_d_id[$i] == null)
        ){
            $html .=    "��";
            $html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
            $html .=    "��";
        }
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_rorder_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_order_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_price[$i]"]]->toHtml();
        $html .=    "</td>";

        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_amount[$i]"]]->toHtml();
        $html .=    "</td>";

        //�Ҹˡ������������Ѥ�OR��ǧ���̰ʳ�
        if($freeze_flg === true || $select_flg === false){
            $show_del_subject_flg = false;
        }elseif($select_flg === true && $freeze_flg != true && $order_d_id[$i] == null){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
            $html .= "  </td>";

            $show_del_subject_flg = true;
        }elseif($order_d_id[$i] != null){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .= "      <br>"; 
            $html .= "  </td>";
            $show_del_subject_flg = true;
        } 
       $html .= "</tr>";
        //���ֹ���1
        $row_num = $row_num+1;
    }
}

//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ�
if($select_flg == true && $freeze_flg !== true){
    //button
    $form->addElement("submit","form_buy_button","������ǧ���̤�", $disabled);
    $form->addElement("button","form_sum_button","�硡��",
            "onClick=\"javascript:Button_Submit('hdn_sum_button_flg','#foot','t', this)\""
    );

    //ȯ��������򵯤����Ƥ������ɽ�����ʤ�
    //���ɲåܥ���
    if($order_flg != true){
        if($update_flg != true){
            //��������
/*
            $form->addElement("link","form_client_link","","./1-3-201.php","������","
                onClick=\"return Open_SubWin('../dialog/1-0-208.php',Array('form_client[cd]','form_client[name]', 'hdn_client_search_flg'),500,450,5,1);\""
            );
*/
            $form->addElement("link","form_client_link","#","./1-3-207.php","������","
            onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','hdn_client_search_flg'),500,450,'1-3-207',1);\"");
        }else{
            $form->addElement("static","form_client_link","","������");
        }
    }else{
        $form->addElement("static","form_client_link","","������");
//        $select_flg = false;
    }

        $form->addElement("button","form_add_row_button", "�ɡ���", 
            "onClick=\"javascript:Button_Submit('add_row_flg','./1-3-207.php#foot','true', this)\""
        );
    if($update_flg != true){    
        //ɽ���ܥ���
        $form->addElement("button","form_show_button","ɽ����",
            "onClick=\"javascript:Button_Submit('hdn_show_button_flg','#','t', this)\""
        );
    }
}elseif($freeze_flg == true){
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
    //���  
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    
    //OK    
    $form->addElement("submit","form_comp_button","������λ", $disabled);

    //ȯ����
    $form->addElement("static","form_client_link","","ȯ����"); 

    $form->freeze();
}else{
    //ɽ���ܥ���
    $form->addElement("button","form_show_button","ɽ����",
        "onClick=\"javascript:Button_Submit('hdn_show_button_flg','#','t', this)\""
    );

    $form->addElement("button","form_sum_button","�硡��",
            "onClick=\"javascript:Button_Submit('hdn_sum_button_flg','#foot','t', this)\""
    );
    //��������
/*
    $form->addElement("link","form_client_link","","./1-3-201.php","������","
        onClick=\"return Open_SubWin('../dialog/1-0-208.php',Array('form_client[cd]','form_client[name]', 'hdn_client_search_flg'),500,450,5,1);\""
    );
*/
    $form->addElement("link","form_client_link","#","./1-3-207.php","������","
            onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','hdn_client_search_flg'),500,450,'1-3-207',1);\"");

}

/**
 *��������ǽ������Ф���ؿ�
 *
 *
 *
 *
**/
function Get_Deny_Num($db_con, $ord_d_id, $buy_id){

    //������ǽ��������
    $sql  = "SELECT\n";
    $sql .= "    t_order_h.num - COALESCE(t_buy_h.num, 0) AS num \n";
    $sql .= "FROM\n";
    $sql .= "    (SELECT\n";
    $sql .= "        num,\n";
    $sql .= "        ord_d_id \n";
    $sql .= "    FROM\n";
    $sql .= "        t_order_d\n";
    $sql .= "    WHERE\n";
    $sql .= "        t_order_d.ord_d_id = $ord_d_id\n";
    $sql .= "    ) AS t_order_h\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    (SELECT\n";
    $sql .= "        SUM(num) AS num,\n";
    $sql .= "        ord_d_id \n";
    $sql .= "    FROM\n";
    $sql .= "        t_buy_h\n";
    $sql .= "            INNER JOIN\n";
    $sql .= "        t_buy_d\n";
    $sql .= "        ON t_buy_h.buy_id = t_buy_d.buy_id\n";
    $sql .= "    WHERE\n";
    $sql .= "        t_buy_d.ord_d_id = $ord_d_id\n";
    $sql .= "        AND\n";
    $sql .= "        t_buy_h.buy_id <> $buy_id\n";
    $sql .= "    GROUP BY ord_d_id\n";
    $sql .= "    ) AS t_buy_h\n";
    $sql .= "    ON t_order_h.ord_d_id = t_buy_h.ord_d_id\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $deny_num = pg_fetch_result($result, 0,0);

    return $deny_num;
}





//��åȿ���׻�����
$js  = " function in_num(num,id,order_num,price_i,price_d,amount,coax){\n";
$js .= "    var in_num = \"form_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_in_num = \"form_order_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_num = \"form_buy_num\"+\"[\"+num+\"]\";\n";
$js .= "    var buy_amount = \"form_buy_amount\"+\"[\"+num+\"]\";\n";
$js .= "    var v_in_num = document.dateForm.elements[in_num].value;\n";
$js .= "    var v_ord_in_num = document.dateForm.elements[ord_in_num].value;\n";
$js .= "    var v_ord_num = document.dateForm.elements[ord_num].value;\n";
$js .= "    var v_num = v_in_num * v_ord_in_num;\n";
$js .= "    if(isNaN(v_num) == true){\n";
$js .= "        v_num = \"\"\n";
$js .= "    }\n";
$js .= "    document.dateForm.elements[ord_num].value = v_num;\n";
$js .= "    Mult(id,order_num,price_i,price_d,amount,coax);\n";
$js .= "}\n";

//��ʸ��åȿ���׻�����
$js .= "function ord_in_num(num){\n";
$js .= "    var in_num = \"form_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_in_num = \"form_order_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_num = \"form_buy_num\"+\"[\"+num+\"]\";\n";
$js .= "    var v_in_num = document.dateForm.elements[in_num].value;\n";
$js .= "    var v_ord_in_num = document.dateForm.elements[ord_in_num].value;\n";
$js .= "    var v_ord_num = document.dateForm.elements[ord_num].value;\n";
$js .= "    var result = v_ord_num % v_in_num;\n";
$js .= "    if(result == 0){\n";
$js .= "        var res = v_ord_num / v_in_num;\n";
$js .= "        document.dateForm.elements[ord_in_num].value = res;\n";
$js .= "    }else{  \n";
$js .= "        document.dateForm.elements[ord_in_num].value = \"\";\n";
$js .= "    }\n";
$js .= "}\n";

/****************************/
// ������ξ��ּ���
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


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
$page_menu = Create_Menu_h('buy','2');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
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
    'select_flg'    => "$select_flg",
    'js'            => "$js",
    'form_potision' => "$form_potision",
    'freeze_flg'    => "$freeze_flg",
    'warning'       => "$warning",
    'ap_balance'    => "$ap_balance",
    'error'         => "$error",
    'order_flg'     => "$order_flg",
    'goods_twice'   => "$goods_twice",
    "client_state_print"    => "$client_state_print",
    "show_del_subject_flg" => "$show_del_subject_flg",
));


$smarty->assign("goods_err", $goods_err);
$smarty->assign("price_num_err", $price_num_err);
$smarty->assign("num_err", $num_err);
$smarty->assign("price_err", $price_err);
$smarty->assign("duplicate_goods_err", $duplicate_goods_err);
$smarty->assign("ord_num_err", $ord_num_err);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
