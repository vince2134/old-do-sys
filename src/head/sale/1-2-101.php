<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/29) ��ê�����������ΥХ�����(suzuki-t)
 * 1.0.1 (2006/03/29) ��������������ɽ������ʤ��Х�����(suzuki-t)
 * 1.0.2 (2006/03/29) ��ɼ�ֹ�Σ����ΥХ�����(suzuki-t)
 * 1.0.3 (2006/03/29) ȯ��ѿ��ΥХ�����(suzuki-t)
 * (2006/07/26) ���ʤ���о���ѹ�(watanabe-k)
 * (2006/07/31) �����Ƿ׻���ˡ�ѹ�(watanabe-k)
 * (2006/09/13) ��󥿥���Ͽ�������ܤ������ˡ���󥿥�������������褦���ѹ�(suzuki-t)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/30      08-021      ��          ������̾��ά��ɽ�����ѹ�
 *  2006/10/30      08-060      ��          �������󥯡�������������������ˤ�ľ�ĥ���åפ����Ϥ���Ƥ��ʤ��Х�����
 *  2006/10/31      08-012      watanabe-k  �����å���λ��������̲��̤Ǽ���������줿����TOP���̤����Х��ν���
 *  2006/10/31      08-022      watanabe-k  ���ե饤������ѹ����������ѹ��侦���ɲä��Ǥ��ʤ��Х��ν���
 *  2006/10/31      08-023      watanabe-k  ���ϥ����å�������̾�����椫�����ڤ��Х��ν��� 
 *  2006/11/01      08-014      watanabe-k  ��¾�����ԤäƤ��ʤ��Х��ν��� 
 *  2006/11/03      08-062      watanabe-k  �����襳���ɤ�NULL����Ͽ����ȥ����ꥨ�顼��ɽ�������Х��ν���
 *  2006/11/03      08-083      watanabe-k  Get�����å��ɲ�
 *  2006/11/03      08-084      watanabe-k  08-085��Ʊ��
 *  2006/11/03      08-085      watanabe-k  Get�����å��ɲ�
 *  2006/11/03      08-086      watanabe-k  Get�����å��ɲ�
 *  2006/11/09      08-138      suzuki      ������ɼ�����������������
 *  2006/11/09      08-139      suzuki      �����ȼԡ�ľ�����ά�Τ���Ͽ
 *  2006/11/09      08-127      watanabe-k  �в�ͽ��������˾Ǽ����NULL�ˤ�����Ͽ����ǽ�ʥХ��ν���
 *  2006/11/27      scl_0027    watanabe-k  �߸˴������ʤ����ʤνв�ͽ�����ɽ������Ƥ���Х��ν���
 *  2006/11/29      scl_�ߡ�    suzuki      �ѹ��������ϥ����å��ե饰������
 *  2006/11/29      scl_202-3-1 suzuki      ��󥿥뤫�����ܤ��Ƥ������ˡ���󥿥������ô���Ԥ���ɽ������
 *  2006/12/13      0056        suzuki      �ѹ����˼���ô������˥��ڥ졼����ɽ�����Ƥ����Τ���
 *  2006/11/07                  watanabe-k  �����å���λ��������������Ͽ���ˤϤ��ʤ餺�����å���λ���֤ˤʤ�褦���ѹ� 
 *  2007/01/25                  watanabe-k  �ܥ���ο��ѹ� 
 *  2007/02/28                  morita-d    ����̾������̾�Τ�ɽ������褦���ѹ� 
 *  2007/03/13                  watanabe-k  �����ʬ�����򤷤�FC�Τ�Τ�ɽ������褦�˽���
 *  2007/05/14                  watanabe-k  ����̾����Ͽ������official_goods_name �˽���
 *  2007/05/14                  watanabe-k  ������ID��Ĥ��褦�˽���
 *  2007/05/17                  watanabe-k  ľ����ץ��������������ѹ�
 *  2007/09/20                  watanabe-k  ��ê���Υ��֥�����ɥ���������ɽ������ʤ��Х��ν���
 *  2009/10/01 		rev.1.2		kajioka-h	ʬǼ��ǽ�ɲ�
 *  2009/10/09 		rev.1.3		kajioka-h	ľ����ƥ��������ϡ�����������
 *  		 		rev.1.3		kajioka-h	����åפ��Ȥ˾��ʤκ߸˴����ե饰������ѹ��б�
 *   2009/12/21                 aoyama-n    ��Ψ��TaxRate���饹�������
 *   2016/01/22                amano  Dialogue, Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */
$page_title = "��������(���ե饤��)";

//�Ķ�����ե����� Environment set up file
require_once("ENV_local.php");

//HTML_QuickForm����� Create HTML_QuickForm
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//$form =& new HTML_QuickForm("dateForm", "POST", "#");

//DB��³ Connect to DB
$db_con = Db_Connect();

// ���¥����å� authority check
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å����� message for no input/edit authority
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled Button Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// ���������SESSION�˥��å� Set the redirect page to SESSION
/*****************************/
// GET��POST��̵����� if there  is no GET POST
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("aord");
}


/****************************/
//�����ѿ����� acquire the external variable
/****************************/
$shop_id     = $_SESSION["client_id"];
$rank_cd     = $_SESSION["rank_cd"];
$o_staff_id  = $_SESSION["staff_id"];
$aord_id     = $_GET["aord_id"];
//$check_flg   = $_GET["check_flg"];      //����Ȳ�Ƚ��ե饰  order inquiry deecision flag
$rental_flg  = $_POST["rental_flg"];    //��󥿥���������ե饰 rental information restoration flag

//����ID��hidden�ˤ���ݻ����� store the order ID by making it hidden
Get_Id_Check3($_GET["aord_id"]);
if($_GET["aord_id"] != NULL){
	$set_id_data["hdn_aord_id"] = $aord_id;
	$form->setConstants($set_id_data);
}else{
	$aord_id = $_POST["hdn_aord_id"];
}

//����Ȳ�Ƚ��ե饰��hidden�ˤ���ݻ����� store the order inquiry decision flag by making it hidden

/**********************************************************

if($_GET["check_flg"] != NULL){
	$set_flg_data["hdn_check_flg"] = $check_flg;
	$form->setConstants($set_flg_data);
}else{
	$check_flg = $_POST["hdn_check_flg"];
}

***********************************************************/

//�����褬���ꤵ��Ƥ��뤫 is the customer assigned
if($_POST["hdn_client_id"] == null){
	$warning = "����������򤷤Ʋ�������";
}else{
	$warning = null;
	$client_id    = $_POST["hdn_client_id"];
    $coax         = $_POST["hdn_coax"];
    $tax_franct   = $_POST["hdn_tax_franct"];
    $client_name  = $_POST["form_client"]["name"];
	$hdn_goods_id = $_POST["hdn_goods_id"];
	$stock_num    = $_POST["hdn_stock_num"];
}

//�����ޤ���ͤ���� acquire value
$hdn_name_change = $_POST["hdn_name_change"];
$hdn_stock_manage = $_POST["hdn_stock_manage"];

/****************************/
//������� initial setting
/****************************/

#2009-12-21 aoyama-n
//��Ψ���饹�����󥹥������� tax rate create an instance
$tax_rate_obj = new TaxRate($shop_id);

//�ѹ�����Ƚ�� edit process decision
if($aord_id != NULL && $client_id == NULL && $_POST[complete_flg] != true){

	//����إå�����SQL SQL that aquire order header
	$sql  = "SELECT ";
	$sql .= "    t_aorder_h.ord_no,";
	$sql .= "    t_aorder_h.ord_time,";
	$sql .= "    t_aorder_h.hope_day,";
	$sql .= "    t_aorder_h.arrival_day,";
	$sql .= "    t_aorder_h.green_flg,";
	$sql .= "    t_aorder_h.trans_id,";
	$sql .= "    t_aorder_h.client_id,";
	//$sql .= "    t_client.client_cd1,";
	//$sql .= "    t_client.client_cd2,";
	//$sql .= "    t_client.client_cname,";
	$sql .= "    t_aorder_h.client_cd1,";
	$sql .= "    t_aorder_h.client_cd2,";
	$sql .= "    t_aorder_h.client_cname,";
	$sql .= "    t_aorder_h.direct_id,";
	$sql .= "    t_aorder_h.ware_id,";
	$sql .= "    t_aorder_h.trade_id,";
	$sql .= "    t_aorder_h.c_staff_id,";
	$sql .= "    t_aorder_h.note_your,";
	$sql .= "    t_aorder_h.note_my ";

	//rev.1.3 ľ����ƥ����Ȳ� transform direct destination to text
	$sql .= ",";
	$sql .= "    t_direct.direct_cd, ";			//ľ����CD direct destional CD
	$sql .= "    t_aorder_h.direct_cname, ";	//ľ����ά�� direct destination abbreviation
	$sql .= "    t_direct_claim.client_cname AS direct_claim ";	//ľ���������� direct destination billing destination


	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	//$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

	//rev.1.3 ľ����ƥ����Ȳ� transform direct destination to text
	$sql .= "    LEFT JOIN t_direct ON t_aorder_h.direct_id = t_direct.direct_id ";
	$sql .= "    LEFT JOIN t_client AS t_direct_claim ON t_direct.client_id = t_direct_claim.client_id ";

	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.aord_id = $aord_id ";
	$sql .= "    AND ";
    $sql .= "    t_aorder_h.ps_stat = '1'";
    $sql .= "    AND ";
    $sql .= "    t_aorder_h.fc_ord_id IS NULL ";

/*******************************************************

    if($check_flg == "true"){
        $sql .= "AND ";
        $sql .= "t_aorder_h.check_flg = 'f'";
    }

********************************************************/

    $sql .= ";";

	$result = Db_Query($db_con,$sql);
	//GET�ǡ���Ƚ�� GET data decision
	Get_Id_Check($result);
	$h_data_list = Get_Data($result,2);

	//����ǡ�������SQL SQL that acquire order data
	$sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    //$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";		//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
    $sql .= "   t_aorder_d.goods_cd,\n";
//    $sql .= "   t_aorder_d.goods_name,\n";
    $sql .= "   t_aorder_d.official_goods_name,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS rack_num,";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
    $sql .= "       WHEN 1 THEN COALESCE(t_stock_io.order_num,0)\n";
    $sql .= "   END AS on_order_num,";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
    $sql .= "       WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0) \n";
//    $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) \n";
	$sql .= "   END AS allowance_total, \n";
    $sql .= "   COALESCE(t_stock.stock_num,0) \n"; 
    $sql .= "       + COALESCE(t_stock_io.order_num,0) \n";
//    $sql .= "       - (COALESCE(t_stock.rstock_num,0) \n";
    $sql .= "       - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total, \n";
    $sql .= "   t_aorder_d.num, \n";
	$sql .= "   t_aorder_d.tax_div, \n";
	$sql .= "   t_aorder_d.cost_price, \n";
	$sql .= "   t_aorder_d.sale_price, \n";
	$sql .= "   t_aorder_d.cost_amount, \n";
    #2009-09-29 hashimoto-y
	#$sql .= "   t_aorder_d.sale_amount  \n";
	$sql .= "   t_aorder_d.sale_amount,  \n";
    $sql .= "   t_goods.discount_flg \n";
    $sql .= " FROM \n";
	$sql .= "   t_aorder_d \n";

	$sql .= "       INNER JOIN\n";
    $sql .= "   t_aorder_h\n";
    $sql .= "   ON t_aorder_d.aord_id = t_aorder_h.aord_id \n";

    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods\n";
    $sql .= "   ON t_aorder_d.goods_id = t_goods.goods_id \n";

    $sql .= "       LEFT JOIN\n";

    //�߸˿� stock count
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
    //$sql .= "       t_stock.shop_id =  ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock.shop_id =  ".$shop_id."\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_aorder_d.goods_id = t_stock.goods_id";

    $sql .= "       LEFT JOIN\n";

    //ȯ��Ŀ� remaining ordered goods but not yet delviered
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 3\n";
    $sql .= "       AND\n";
    //$sql .= "       t_stock_hand.shop_id = ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock_hand.shop_id = ".$shop_id."\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n";
//    $sql .= "       AND\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io ON t_aorder_d.goods_id=t_stock_io.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //������ count of stocks that are ordered already
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 1\n";
    $sql .= "       AND\n";
    //$sql .= "       t_stock_hand.shop_id = ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock_hand.shop_id = ".$shop_id."\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//	$sql .= "       t_stock_hand.work_day > (CURRENT_DATE + 7)\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io\n";
    $sql .= "   ON t_aorder_d.goods_id = t_allowance_io.goods_id \n";

	$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";    //rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop

    $sql .= " WHERE \n";
    $sql .= "       t_aorder_d.aord_id = $aord_id \n";
    $sql .= "       AND \n";
    $sql .= "       t_aorder_h.shop_id = $shop_id \n";

	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
    $sql .= "       AND \n";
    $sql .= "       t_goods_info.shop_id = $shop_id \n";

	$sql .= " ORDER BY t_aorder_d.line;";

    $result = Db_Query($db_con, $sql);
	$data_list = Get_Data($result,2);

	//������ξ������� extract the information of the customer
    $sql  = "SELECT";
	$sql .= "   client_id,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
    $sql .= "   shop_id";
//    $sql .= "   attach_gid ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$h_data_list[0][6];
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
	$client_list = Get_Data($result,2);

	/****************************/
	//�ե�������ͤ����� restore the value to form
	/****************************/
	$sale_money = NULL;                        //���ʤ������ sales of the particular product
    $tax_div    = NULL;                        //���Ƕ�ʬ taxation classification

	//�إå������� restore header
	$update_goods_data["form_order_no"]                = $h_data_list[0][0];  //�����ֹ� order number

	//��������ǯ������ʬ���� separate the order date into year month and day 
	$ex_ord_day = explode('-',$h_data_list[0][1]);
	$update_goods_data["form_ord_day"]["y"]            = $ex_ord_day[0];   //������ order data
	$update_goods_data["form_ord_day"]["m"]            = $ex_ord_day[1];   
	$update_goods_data["form_ord_day"]["d"]            = $ex_ord_day[2];   

	//��˾Ǽ����ǯ������ʬ���� separate the desired delivery date into year month and day
	$ex_hope_day = explode('-',$h_data_list[0][2]);
	$update_goods_data["form_hope_day"]["y"]           = $ex_hope_day[0];  //��˾Ǽ�� desired delivery date
	$update_goods_data["form_hope_day"]["m"]           = $ex_hope_day[1];   
	$update_goods_data["form_hope_day"]["d"]           = $ex_hope_day[2];   

	//����ͽ������ǯ������ʬ���� separate the scheduled delivery date by year month and day
	$ex_arr_day = explode('-',$h_data_list[0][3]);
	$update_goods_data["form_arr_day"]["y"]            = $ex_arr_day[0];   //����ͽ���� scheduled delovery date
	$update_goods_data["form_arr_day"]["m"]            = $ex_arr_day[1];   
	$update_goods_data["form_arr_day"]["d"]            = $ex_arr_day[2];   

	//�����å����դ��뤫Ƚ�� decide if it will be checked or not
    if($h_data_list[0][4]=='t'){
        $update_goods_data["form_trans_check"]         = $h_data_list[0][4];  //���꡼����� green destination
    }

	$update_goods_data["form_trans_select"]            = $h_data_list[0][5];  //�����ȼ� carrier
	$update_goods_data["form_client"]["cd1"]           = $h_data_list[0][7];  //�����襳���ɣ� customer code 1 
	$update_goods_data["form_client"]["cd2"]           = $h_data_list[0][8];  //�����襳���ɣ� customer code 1
	$update_goods_data["form_client"]["name"]          = $h_data_list[0][9];  //������̾ customer name
	$update_goods_data["form_direct_select"]           = $h_data_list[0][10]; //ľ���� direct destination
	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
	$update_goods_data["form_direct_text"]["cd"]       = $h_data_list[0][16]; //ľ����CD direct destination CD
	$update_goods_data["form_direct_text"]["name"]     = $h_data_list[0][17]; //ľ����ά�� direct destination abbreviation
	$update_goods_data["form_direct_text"]["claim"]    = $h_data_list[0][18]; //ľ���������� direct destination billing destination

	$update_goods_data["form_ware_select"]             = $h_data_list[0][11]; //�Ҹ� warehouse
	$update_goods_data["trade_aord_select"]            = $h_data_list[0][12]; //�����ʬ trade classifcation
	$update_goods_data["form_staff_select"]            = $h_data_list[0][13]; //ô���� assigned staff 
	$update_goods_data["form_note_client"]             = $h_data_list[0][14]; //�̿����������� communication field (addressed to customer)
	$update_goods_data["form_note_head"]               = $h_data_list[0][15]; //�̿����������communication column (HQ)

	//�ǡ������� restore data
	for($i=0;$i<count($data_list);$i++){
	    $update_goods_data["hdn_goods_id"][$i]         = $data_list[$i][0];   //����ID product ID
		$hdn_goods_id[$i]                              = $data_list[$i][0];   //POST�������˾���ID����߸˿��ǻ��Ѥ���� For the reason that product ID will be used in the total inventory count before POST

		$update_goods_data["hdn_name_change"][$i]      = $data_list[$i][1];   //��̾�ѹ��ե饰 product name change flag
		$hdn_name_change[$i]                           = $data_list[$i][1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ��� For the reason that product name will be checked if it is non-editable before POST


		$update_goods_data["hdn_stock_manage"][$i]     = $data_list[$i][2];   //�߸˴��� inventory control
		$hdn_stock_manage[$i]                          = $data_list[$i][2];   //POST�������˼�ê���κ߸˴���Ƚ���Ԥʤ��� For the reason that actual shelf number will be decided in inventory control before POST

		$update_goods_data["form_goods_cd"][$i]        = $data_list[$i][3];   //����CD product CD
		$update_goods_data["form_goods_name"][$i]      = $data_list[$i][4];   //����̾ product Name

		$update_goods_data["form_stock_num"][$i]       = number_format($data_list[$i][5]);   //��ê�� actual shelf number
		$update_goods_data["hdn_stock_num"][$i]        = number_format($data_list[$i][5]);   //��ê����hidden��actual shelf number (hidden)
		$stock_num[$i]                                 = number_format($data_list[$i][5]);   //��ê��(��󥯤���) actual shelf number (link's value)

        if($hdn_stock_manage[$i] != 2){
		    $update_goods_data["form_rorder_num"][$i]      = $data_list[$i][6];   //ȯ��ѿ� purchase ordered number
		    $update_goods_data["form_rstock_num"][$i]      = $data_list[$i][7];   //������ number of product resereved for order
		    $update_goods_data["form_designated_num"][$i]  = $data_list[$i][8];   //�вٲ�ǽ�� deliverable number of inventory 
        }
		$update_goods_data["form_sale_num"][$i]        = $data_list[$i][9];   //����� number of sales order
		$update_goods_data["hdn_tax_div"][$i]          = $data_list[$i][10];  //���Ƕ�ʬ taxation classification

	    //����ñ�����������Ⱦ�������ʬ���� separate the decimal from integer for the product cost
        $cost_price = explode('.', $data_list[$i][11]);
		$update_goods_data["form_cost_price"][$i]["i"] = $cost_price[0];  //����ñ�� product cost per unit
		$update_goods_data["form_cost_price"][$i]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     
		$update_goods_data["form_cost_amount"][$i]     = number_format($data_list[$i][13]);  //������� cost price

		//���ñ�����������Ⱦ�������ʬ���� separate the decimal from integer for the sales price per unit
        $sale_price = explode('.', $data_list[$i][12]);
		$update_goods_data["form_sale_price"][$i]["i"] = $sale_price[0];  //���ñ�� sales price per unit
		$update_goods_data["form_sale_price"][$i]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';
		$update_goods_data["form_sale_amount"][$i]     = number_format($data_list[$i][14]);  //����� sales price

		$sale_money[]                                  = $data_list[$i][14];  //����۹�� total sales price
        $tax_div[]                                     = $data_list[$i][10];  //���Ƕ�ʬ taxation classification

        #2009-09-29 hashimoto-y
        $update_goods_data["hdn_discount_flg"][$i]     = $data_list[$i][15];  //�Ͱ����ե饰 discount flag
    }

	//������������� restore customer information
	$client_id      = $client_list[0][0];        //������ID customer ID
	$coax           = $client_list[0][1];        //�ݤ��ʬ�ʶ�ۡ� round up/down classification (amount)
    $tax_franct     = $client_list[0][2];        //ü����ʬ�ʾ����ǡ�  round up/down classification (consumption tax)
//    $attach_gid     = $client_list[0][3];        //��°���롼�� belonged group
	$warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
//    $update_goods_data["attach_gid"]          = $attach_gid;

	//���ߤξ�����Ψ current consumption tax rate
    #2009-12-21 aoyama-n
	#$sql  = "SELECT ";
	#$sql .= "    tax_rate_n ";
	#$sql .= "FROM ";
	#$sql .= "    t_client ";
	#$sql .= "WHERE ";
	#$sql .= "    client_id = $shop_id;";
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
	$update_goods_data["sum_button_flg"]       = "";
	$update_goods_data["form_designated_date"] = 7; //�вٲ�ǽ�� possible number of delivery

    $form->setConstants($update_goods_data);

	//ɽ���Կ� displayed number of row 
	if($_POST["max_row"] != NULL){
	    $max_row = $_POST["max_row"];
	}else{
		//����ǡ����ο� number of sales order data
	    $max_row = count($data_list);
	}

	//rev.1.2 �̾索�ե饤������ѹ�Ƚ��ե饰 decision flag for editing a normall offline order
	$edit_flg = "true";

}else{
	//��ư���֤μ����ֹ���� acquire sales order number that will be auto filled
	$sql  = "SELECT";
	$sql .= "   MAX(ord_no)";
	$sql .= " FROM";
	$sql .= "   t_aorder_h";
	$sql .= " WHERE";
	$sql .= "   shop_id = $shop_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql);
	$order_no = pg_fetch_result($result, 0 ,0);
	$order_no = $order_no +1;
	$order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

	$def_data["form_order_no"] = $order_no;

	//�вٲ�ǽ�� deliverable numer of units of stock
	$def_data["form_designated_date"] = 7;
	//ô���� assigned staff
	$def_data["form_staff_select"] = $o_staff_id;
	//�����ʬ trade classification
	$def_data["trade_aord_select"] = 11;

    $def_data["form_ord_day"]["y"] = date('Y');
    $def_data["form_ord_day"]["m"] = date('m');
    $def_data["form_ord_day"]["d"] = date('d');

    $def_data["form_hope_day"]["y"] = date('Y', mktime(0,0,0,date('m'), date('d')+2, date('Y')));
    $def_data["form_hope_day"]["m"] = date('m', mktime(0,0,0,date('m'), date('d')+2, date('Y')));
    $def_data["form_hope_day"]["d"] = date('d', mktime(0,0,0,date('m'), date('d')+2, date('Y')));

    $def_data["form_arr_day"]["y"] = date('Y', mktime(0,0,0,date('m'), date('d')+1, date('Y')));
    $def_data["form_arr_day"]["m"] = date('m', mktime(0,0,0,date('m'), date('d')+1, date('Y')));
    $def_data["form_arr_day"]["d"] = date('d', mktime(0,0,0,date('m'), date('d')+1, date('Y')));

    $sql  = "SELECT";
    $sql .= "   ware_id ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = 1";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $def_ware_id = pg_fetch_result($result, 0,0);

    $def_data["form_ware_select"] = $def_ware_id;

	$form->setDefaults($def_data);

	//ɽ���Կ� number of rows to display
	if($_POST["max_row"] != NULL){
	    $max_row = $_POST["max_row"];
	}else{
	    $max_row = 5;
	}

	//rev.1.2 �̾索�ե饤������ѹ�Ƚ��ե饰 decision flag for editing a normall offline order
	$edit_flg = $_POST["hdn_edit_flg"];

}

//rev.1.2 �̾索�ե饤������ѹ�Ƚ��ե饰��hidden�˥��å� set decision flag for editing a normall offline order to hidden
$form->setConstants(array("hdn_edit_flg" => $edit_flg));

//���ɽ�������ѹ� change the initial view position 
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//����Կ� deleted row number
$del_history[] = NULL; 
/****************************/
//�Կ��ɲý��� process for adding rows
/****************************/
if($_POST["add_row_flg"]==true){
/*
	if($_POST["max_row"] == NULL){
		//����ͤ�POST��̵���١�since initial value doesnt have POST
		$max_row = 5;
	}else{
*/
		//����Ԥˡ��ܣ����� +1 to max row number
    	$max_row = $_POST["max_row"]+5;
//	}

    //�Կ��ɲåե饰�򥯥ꥢ clear the row addition flag
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}
/****************************/
//�Ժ������ row deletion process
/****************************/
if($_POST["del_row"] != ""){

    //����ꥹ�Ȥ���� acquire the deleted list
    $del_row = $_POST["del_row"];

    //������������ˤ��롣turn the deletion history into array
    $del_history = explode(",", $del_row);
    //��������Կ� number of deleted rows
    $del_num     = count($del_history)-1;
}

//***************************/
//����Կ���hidden�˥��å� set the max row number to hidden
/****************************/
$max_row_data["max_row"] = $max_row;

$form->setConstants($max_row_data);

//***************************/
//���꡼���������å����� green designation check process
/****************************/
//�����å��ξ��ϡ������ȼԤΥץ��������ͤ��ѹ����� if there is a check, then change the value of the carrier's dropdown
if($_POST["trans_check_flg"] == true){
	$where  = " WHERE ";
	$where .= "    shop_id = $shop_id";
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

//�����ֹ� sales order number
$form->addElement(
    "text","form_order_no","",
    "style=\"color : #585858; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
 
//�вٲ�ǽ�� sales order number
$form->addElement(
    "text","form_designated_date","",
    "size=\"4\" maxLength=\"4\" 
    $g_form_option 
    style=\"text-align: right;$g_form_style\"
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
$form_hope_day[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hope_day[y]','form_hope_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form_hope_day[] =& $form->createElement("static","","","-");
$form_hope_day[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hope_day[m]','form_hope_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form_hope_day[] =& $form->createElement("static","","","-");
$form_hope_day[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_hope_day,"form_hope_day","form_hope_day");

//����ͽ���� desired delivery date
$form_arr_day[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_arr_day[y]','form_arr_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form_arr_day[] =& $form->createElement("static","","","-");
$form_arr_day[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_arr_day[m]','form_arr_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form_arr_day[] =& $form->createElement("static","","","-");
$form_arr_day[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_arr_day,"form_arr_day","form_arr_day");

//�����襳���� customer code
$freeze = $form_client[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
        );
if($_GET[aord_id] != null){
    $freeze->freeze();
}
$form_client[] =& $form->createElement(
        "static","","","-"
        );
$freeze = $form_client[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onChange=\"javascript:Button_Submit('client_search_flg','#','true', this)\"".$g_form_option."\""
        );
if($_GET[aord_id] != null){
    $freeze->freeze();
}
$form_client[] =& $form->createElement("text","name","�ƥ����ȥե�����","size=\"34\" $g_text_readonly");
$form->addGroup( $form_client, "form_client", "");

//����۹�� total sales amount
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"$g_form_style;color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//�����ǳ�(���) tax amount (total)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//����ۡ��ǹ����) sales amount (with consumption tax)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//�̿���������谸�� communication field  (addressed to customer)
$form->addElement("textarea","form_note_client","�ƥ����ȥե�����",' rows="2" cols="75" onFocus="onForm(this)" onBlur="blurForm(this)"');
//�̿������������communication field (HQ)
$form->addElement("textarea","form_note_head","�ƥ����ȥե�����",' rows="2" cols="75" onFocus="onForm(this)" onBlur="blurForm(this)"');

//���꡼����� Green designation
$form->addElement('checkbox', 'form_trans_check', '���꡼�����', '<b>���꡼�����</b>��',"onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");
//�����ȼ� carrier
$select_value = Select_Get($db_con,'trans',$where);
$form->addElement('select', 'form_trans_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ľ���� direct destination
//$select_value = Select_Get($db_con,'direct');
//$form->addElement('select', 'form_direct_select', '���쥯�ȥܥå���', $select_value,"class=\"Tohaba\"".$g_form_option_select);
//rev.1.3 �ƥ��������Ϥ��ѹ� change to text input
$form_direct[] = $form->createElement(
    "text","cd","","size=\"4\" maxLength=\"4\"
     style=\"$g_form_style\"
     onChange=\"javascript:Button_Submit('hdn_direct_search_flg','#','true', this)\"
     $g_form_option"
);
$form_direct[] = $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly");
$form_direct[] = $form->createElement(
    "text","claim","",
    "size=\"34\" $g_text_readonly");
$form->addGroup($form_direct, "form_direct_text", "");

//�Ҹ� warehouse
$select_value = Select_Get($db_con,'ware');
$form->addElement('select', 'form_ware_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//�����ʬ trade classification
$select_value = Select_Get($db_con,'trade_aord');
$form->addElement('select', 'trade_aord_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//ô���� assigned staff
$select_value = Select_Get($db_con,'staff',null,true);
$form->addElement('select', 'form_staff_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//���� sales order
//$form->addElement("submit","order","������","onClick=\"javascript:Dialogue('�����ޤ���','#')\"");
//1.0.4 (2006/03/29) kaji ��ǧ���������Υ���󥻥�ܥ��󲡲����Ǥ���Ͽ����Ƥ��ޤ��Х��к�

//�����å���λ done with checking
//$form->addElement("button","complete","�����å���λ","onClick=\"javascript:Dialogue_2('�����å���λ���ޤ���','".HEAD_DIR."sale/1-2-101.php?aord_id=".$aord_id."','true','complete_flg')\"");
//1.0.4 (2006/03/29) kaji ��ǧ���������Υ���󥻥�ܥ��󲡲����Ǥ���Ͽ����Ƥ��ޤ��Х��к�


// �إå�����󥯥ܥ��� header link button
$ary_h_btn_list = array("�Ȳ��ѹ�" => "./1-2-105.php", "������" => $_SERVER["PHP_SELF"], "����İ���" => "./1-2-106.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

//hidden
$form->addElement("hidden", "hdn_client_id");       //������ID customer ID
$form->addElement("hidden", "hdn_aord_id");         //����ID sales order ID
//$form->addElement("hidden", "attach_gid");          //��°���롼��ID belonged group ID
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
$form->addElement("hidden", "hdn_check_flg");         //����Ȳ�Ƚ��ե饰 sales order inquiry deicision flag
$form->addElement("hidden", "forward_num_flg");		//�вٲ������ե饰 rev.1.2 number of deliveries selection flag
$form->addElement("hidden", "hdn_edit_flg");		//�̾索�ե饤������ѹ�Ƚ��ե饰 rev.1.2 decision flag for editing a normall offline order
$form->addElement("hidden", "hdn_direct_search_flg");	//ľ���襳�������ϥե饰 rev.1.3 Direct destination code input flag
$form->addElement("hidden", "form_direct_select");	//ľ����ID rev.1.3 direct destination ID
#2009-09-26 hashimoto-y
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $form->addElement("hidden","hdn_discount_flg[$i]");
    }
}

/****************************/
//�����襳�������Ͻ��� customer code input process
/****************************/
if($_POST["client_search_flg"] == true){

    $client_cd1         = $_POST["form_client"]["cd1"];       //�����襳����1 customer code 1
	$client_cd2         = $_POST["form_client"]["cd2"];       //�����襳����2 customer code 2

    //������ξ������� extract the information of customer 
    $sql  = "SELECT";
    $sql .= "   client_id,";
//    $sql .= "   client_name,";
    $sql .= "   client_cname,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
    $sql .= "   trade_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
	$sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '3' ";
    $sql .= "   AND";
    $sql .= "   state = '1' ";
    $sql .= "   AND";
    $sql .= "   shop_id = '$shop_id'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);

	//�����ǡ��������� there is a corresponding data
	if($num == 1){
		$client_id      = pg_fetch_result($result, 0,0);        //������ID customer id 
//        $attach_gid     = pg_fetch_result($result, 0,0);        //��°���롼��ID group Id where the custoemr belongs
        $client_name    = pg_fetch_result($result, 0,1);        //������̾ cstomer name
        $coax           = pg_fetch_result($result, 0,2);        //�ݤ��ʬ�ʾ��ʡ� round up/down (producT)
        $tax_franct     = pg_fetch_result($result, 0,3);        //ü����ʬ�ʾ����ǡ�round/up/down (product)

        //���������ǡ�����ե�����˥��å� set the acquired data to form
		$warning = null;
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = $client_id;
//        $client_data["attach_gid"]          = $attach_gid;
        $client_data["form_client"]["name"] = $client_name;
        $client_data["hdn_coax"]            = $coax;
        $client_data["hdn_tax_franct"]      = $tax_franct;
        $client_data["trade_aord_select"]   = pg_fetch_result($result, 0, 4);
	}else{
		$warning = "����������򤷤Ʋ�������";
		$client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = "";
//        $client_data["attach_gid"]          = "";
        $client_data["form_client"]["name"] = "";
        $client_data["hdn_coax"]            = "";
        $client_data["hdn_tax_franct"]      = "";
	}

	//��󥿥뤫�����ܤ��Ƥ������Ͻ�������ʤ� do not initialize if it was transitioned from rental
	if($rental_flg == NULL){
		//�������Ϥ��줿�ͤ����� initialize the value that was inputted previously
		for($i = 0; $i < $max_row; $i++){

			$client_data["hdn_goods_id"][$i]           = "";
			
			$client_data["hdn_tax_div"][$i]            = "";
			$client_data["form_goods_cd"][$i]          = "";
			$client_data["form_goods_name"][$i]        = "";
			$client_data["form_stock_num"][$i]         = "";
			$client_data["hdn_stock_num"][$i]          = "";
			$client_data["form_rorder_num"][$i]        = "";
			$client_data["form_rstock_num"][$i]        = "";
			$client_data["form_designated_num"][$i]    = "";
			$client_data["form_sale_num"][$i]          = "";
			$client_data["form_cost_price"]["$i"]["i"] = "";
			$client_data["form_cost_price"]["$i"]["d"] = "";
			$client_data["form_cost_amount"][$i]       = "";
			$client_data["form_sale_price"]["$i"]["i"] = "";
			$client_data["form_sale_price"]["$i"]["d"] = "";
			$client_data["form_sale_amount"][$i]       = "";
			//rev.1.2 ʬǼ�б�ʬ���ɲ� add what will be for the by batch delivery
			$client_data["form_forward_times"][$i]     = "0";
			$_POST["form_forward_times"][$i]				= 0;
			$client_data["form_forward_day"][$i][0]["y"]	= "";
			$client_data["form_forward_day"][$i][0]["m"]	= "";
			$client_data["form_forward_day"][$i][0]["d"]	= "";
			$client_data["form_forward_num"][$i][0]			= "";

		}

		$stock_num                          = "";
		$hdn_goods_id                       = "";
		$client_data["del_row"]             = "";
		$client_data["max_row"]             = 5;
		$client_data["form_sale_total"]     = "";
		$client_data["form_sale_tax"]       = "";
		$client_data["form_sale_money"]     = "";
		$post_flg                           = true;
		$max_row = 5;

	//rev.1.2 ʬǼ�б��������ᡢ��󥿥�ο��̤�вٿ�������� since it was a by batch delivery, put the number of rented units of product to the deliverable number of units of product
	}else{
		for($i = 0; $i < $max_row; $i++){
			$client_data["form_forward_num"][$i][0] = $_POST["form_sale_num"][$i];

		}

	}

	$form->setConstants($client_data);

    //����Կ� number of deleted rows
    unset($del_history);
    $del_history[] = NULL;
//}

/****************************/
//��ץܥ��󲡲����� process when the total button is pressed
/****************************/
}elseif(($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["order"] == "�����ǧ���̤�" )&& $client_id != null){
	//����ꥹ�Ȥ���� acquire the deleted list
    $del_row = $_POST["del_row"];
    //������������ˤ��롣 turn the deletion history to array
    $del_history = explode(",", $del_row);

	$sale_data  = $_POST["form_sale_amount"];  //����� total sales 
	$sale_money = NULL;                        //���ʤ������ sales of a product
    $tax_div    = NULL;                        //���Ƕ�ʬ tax classification

	//����ۤι���ͷ׻� compute for the total amount of the sales
    for($i=0;$i<$max_row;$i++){
		if($sale_data[$i] != "" && !in_array("$i", $del_history)){
			$sale_money[] = $sale_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
		}
    }
	
	//���ߤξ�����Ψ current consumption tax
    #2009-12-21 aoyama-n
	#$sql  = "SELECT ";
	#$sql .= "    tax_rate_n ";
	#$sql .= "FROM ";
	#$sql .= "    t_client ";
	#$sql .= "WHERE ";
	#$sql .= "    client_id = $shop_id;";
	#$result = Db_Query($db_con, $sql); 
	#$tax_num = pg_fetch_result($result, 0,0);

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_ord_day"]["y"]."-".$_POST["form_ord_day"]["m"]."-".$_POST["form_ord_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);

	$sale_money = number_format($total_money[0]);
	$tax_money  = number_format($total_money[1]);
	$st_money   = number_format($total_money[2]);

	if($_POST["sum_button_flg"] == true){
		//���ɽ�������ѹ� change the initial display position
		$height = $max_row * 100;
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
//�вٲ�ǽ������ input the deliverable number of units of product
/****************************/
if($_POST["recomp_flg"] == true){
    //�вٲ�ǽ�� deliverable number of units of product
    $designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;
    //�����ʳ������Ϥ���Ƥ����� when other than numbers are inputted
    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 0;
    }

//    $attach_gid   = $_POST["attach_gid"];     //������ν�°���롼�� group which the customer belongs to
	$ary_goods_id = $_POST["hdn_goods_id"];   //���Ϥ�������ID product ID inputted

	//���Ϥ��줿���ʤθĿ���Ʒ׻����� recompute the number of inputted product
	for($i = 0; $i < count($ary_goods_id); $i++){
		//����¸��Ƚ�� decide whether the product exists
		if($ary_goods_id[$i] != NULL){
			//�Ʒ׻�SQL recomputation SQL
			$sql  = "SELECT";
		    $sql .= "   t_goods.goods_id,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
			//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//            $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) ";
			$sql .= " END AS allowance_total,";
			//$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN";
			$sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
		    $sql .= "   COALESCE(t_stock.stock_num,0)"; 
		    $sql .= "   + COALESCE(t_stock_io.order_num,0)";
//		    $sql .= "   - (COALESCE(t_stock.rstock_num,0)";
		    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0) END AS stock_total ";
		    $sql .= " FROM";
		    $sql .= "   t_goods ";

			$sql .= "   INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
			$sql .= "   INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

		    $sql .= "   LEFT JOIN";

            //�߸˿� inventory count
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

            //ȯ��ѿ� number of purchase orders ordered
		    $sql .= "   (SELECT";
		    $sql .= "       t_stock_hand.goods_id,";
		    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num";
		    $sql .= "   FROM";
		    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
		    $sql .= "   WHERE";
		    $sql .= "       t_stock_hand.work_div = 3";
		    $sql .= "   AND";
		    $sql .= "       t_stock_hand.shop_id = $shop_id";
		    $sql .= "   AND";
		    $sql .= "       t_ware.count_flg = 't'";
		    $sql .= "   AND";
//		    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day";
//		    $sql .= "   AND";
			$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)";
		    $sql .= "   GROUP BY t_stock_hand.goods_id";
		    $sql .= "   ) AS t_stock_io ON t_goods.goods_id=t_stock_io.goods_id";

		    $sql .= "   LEFT JOIN";

            //������ number of reserved products for orders
		    $sql .= "   (SELECT";
		    $sql .= "       t_stock_hand.goods_id,";
		    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num";
		    $sql .= "   FROM";
		    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
		    $sql .= "   WHERE";
		    $sql .= "       t_stock_hand.work_div = 1";
		    $sql .= "   AND";
		    $sql .= "       t_stock_hand.shop_id = $shop_id";
		    $sql .= "   AND";
		    $sql .= "       t_ware.count_flg = 't'";
		    $sql .= "   AND";
//			$sql .= "       t_stock_hand.work_day > (CURRENT_DATE + $designated_date)";
			$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)";
		    $sql .= "   GROUP BY t_stock_hand.goods_id";
		    $sql .= "   ) AS t_allowance_io ON t_goods.goods_id = t_allowance_io.goods_id";

			$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop

		    $sql .= " WHERE ";
		    $sql .= "       t_goods.goods_id = $ary_goods_id[$i]";
		    $sql .= " AND ";
		    $sql .= "       t_goods.public_flg = 't' ";
		    $sql .= " AND ";
		    $sql .= "       initial_cost.rank_cd = '1' ";

			//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
		    $sql .= " AND ";
		    $sql .= "       t_goods_info.shop_id = $shop_id ";

		    $sql .= ";";

		    $result = Db_Query($db_con, $sql);

		    $goods_data = pg_fetch_array($result);

			$set_designated_data["hdn_goods_id"][$i]         = $goods_data[0];   //����ID product ID 
			$hdn_goods_id[$search_row]                       = $goods_data[0];   //POST�������˾���ID����߸˿��ǻ��Ѥ���� for the reason that the product ID will be used for the total stock count before POST
			$set_designated_data["form_stock_num"][$i]       = $goods_data[1];   //��ê�� actual shelf number
			$set_designated_data["hdn_stock_num"][$i]        = $goods_data[1];   //��ê����hidden��actual shelf number (hidden)
			$stock_num[$i]                                   = $goods_data[1];   //��ê��(��󥯤���) actual shelf number (linl's value)
			$set_designated_data["form_rorder_num"][$i]      = $goods_data[2];   //ȯ��ѿ� number of purchase orders made
			$set_designated_data["form_rstock_num"][$i]      = $goods_data[3];   //������ number of products reserved for orders
			$set_designated_data["form_designated_num"][$i]  = $goods_data[4];   //�вٲ�ǽ�� deliverable number of units of products 
		}
	}

	//�вٲ�ǽ�����ϥե饰�˶���򥻥å� set blank in the input deliverable number of units of product flag
    $set_designated_data["recomp_flg"] = "";
    $form->setConstants($set_designated_data);
}

/****************************/
//���ʥ��������� input product code
/****************************/
if($_POST["goods_search_row"] != null){

	//���ʥǡ������������� row for acquiring
 the product data
    $search_row = $_POST["goods_search_row"];

	//�вٲ�ǽ������ acquire the deliverable number of units of product
	$designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;
    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 0;
    }

//   $attach_gid   = $_POST["attach_gid"];     //������ν�°���롼�� the group where the customer belongs
	$sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    //$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
    $sql .= "   t_goods.goods_cd,\n";
    //$sql .= "   t_goods.goods_name,\n";
    $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //����̾ official name
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//    $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) \n";
    $sql .= " END AS allowance_total,\n";
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN\n";
    $sql .= "   COALESCE(t_stock.stock_num,0)\n"; 
    $sql .= "   + COALESCE(t_stock_io.order_num,0)\n";
//    $sql .= "   - (COALESCE(t_stock.rstock_num,0)\n";
    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0) END AS stock_total,\n";
    $sql .= "   initial_cost.r_price AS initial_price,\n";
    $sql .= "   sale_price.r_price AS sale_price,\n";
    $sql .= "   t_goods.tax_div, \n";
	//rev.1.2 �Ͱ����ʥե饰 discounted product flag 
    $sql .= "   t_goods.discount_flg \n";
    $sql .= " FROM\n";
    $sql .= "   t_goods \n";
    $sql .= "     INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";

    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price AS initial_cost\n";
    $sql .= "   ON t_goods.goods_id = initial_cost.goods_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //�߸˿� stock number 
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock.goods_id,\n";
    $sql .= "       SUM(t_stock.stock_num)AS stock_num,\n";
    $sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
    $sql .= "       FROM\n";
    $sql .= "            t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id\n";
    $sql .= "       WHERE\n";
    $sql .= "            t_stock.shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "            t_ware.count_flg = 't'\n";
    $sql .= "       GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock ON t_goods.goods_id = t_stock.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //ȯ��ѿ� number of purchase orders ordered
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 3\n";
    $sql .= "   AND\n";
    $sql .= "       t_stock_hand.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   AND\n";
//    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n";
//    $sql .= "   AND\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io ON t_goods.goods_id=t_stock_io.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //������ number of reserved units of product for order
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 1\n";
    $sql .= "   AND\n";
    $sql .= "       t_stock_hand.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   AND\n";
//	$sql .= "       t_stock_hand.work_day > (CURRENT_DATE + $designated_date)\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io ON t_goods.goods_id = t_allowance_io.goods_id\n";

	$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";    //rev.1.3 ����åפ��Ȥ˺߸˴����ե饰

    $sql .= " WHERE \n";
    $sql .= "       t_goods.goods_cd = '".$_POST["form_goods_cd"][$search_row]."'\n";
    $sql .= " AND \n";
    $sql .= "       t_goods.public_flg = 't' \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.accept_flg = '1' \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.state IN (1,3) \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.compose_flg = 'f' \n";
    $sql .= " AND\n"; 
    $sql .= "       initial_cost.rank_cd = '1' \n";
    $sql .= " AND \n";
    $sql .= "       sale_price.rank_cd = \n";
    $sql .= "       (SELECT \n";
    $sql .= "           rank_cd \n";
    $sql .= "       FROM \n";
    $sql .= "           t_client \n";
    $sql .= "       WHERE \n";
    $sql .= "           client_id = $client_id)\n";

	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰 inventory control flag per shop
    $sql .= " AND \n";
    $sql .= "       t_goods_info.shop_id = $shop_id \n";

    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);
	//�ǡ�����¸�ߤ�����硢�ե�����˥ǡ�����ɽ��
	if($data_num == 1){
    	$goods_data = pg_fetch_array($result);

		$set_goods_data["hdn_goods_id"][$search_row]         = $goods_data[0];   //����ID product ID
		$hdn_goods_id[$search_row]                           = $goods_data[0];   //POST�������˾���ID����߸˿��ǻ��Ѥ���� For the reason that product ID will be used in the total inventory count before POST

		$set_goods_data["hdn_name_change"][$search_row]      = $goods_data[1];   //��̾�ѹ��ե饰 product name change flag
		$hdn_name_change[$search_row]                        = $goods_data[1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ��� For the reason that product name will be checked if it is non-editable or not before POST
		
		$set_goods_data["hdn_stock_manage"][$search_row]     = $goods_data[2];   //�߸˴��� inventory control
		$hdn_stock_manage[$search_row]                       = $goods_data[2];   //POST�������˼�ê���κ߸˴���Ƚ���Ԥʤ��� For the reason that actual shelf number will be decided in inventory control before POST

		$set_goods_data["form_goods_cd"][$search_row]        = $goods_data[3];   //����CD Product CD
		$set_goods_data["form_goods_name"][$search_row]      = $goods_data[4];   //����̾ Prodcut Name

		$set_goods_data["form_stock_num"][$search_row]       = number_format($goods_data[5]);   //��ê�� actual shelf number
		$set_goods_data["hdn_stock_num"][$search_row]        = number_format($goods_data[5]);   //��ê����hidden�� ��hidden��actual shelf number (hidden)
		$stock_num[$search_row]                              = number_format($goods_data[5]);   //��ê��(��󥯤���) actual shelf number (link's value)

		$set_goods_data["form_rorder_num"][$search_row]      = $goods_data[6];   //ȯ��ѿ� purchase orders ordered number
		$set_goods_data["form_rstock_num"][$search_row]      = $goods_data[7];   //������ reserved quantity of products for sales order

		$set_goods_data["form_designated_num"][$search_row]  = $goods_data[8];   //�вٲ�ǽ�� deliverable number of stocks

		//����ñ�����������Ⱦ�������ʬ���� separate the decimal from integer for the product cost
        $cost_price = explode('.', $goods_data[9]);
		$set_goods_data["form_cost_price"][$search_row]["i"] = $cost_price[0];  //����ñ�� product cost per unit
		$set_goods_data["form_cost_price"][$search_row]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     

		//���ñ�����������Ⱦ�������ʬ���� separate the decimal from integer for the sales price per unit
        $sale_price = explode('.', $goods_data[10]);
		$set_goods_data["form_sale_price"][$search_row]["i"] = $sale_price[0];  //���ñ�� sales price per unit
		$set_goods_data["form_sale_price"][$search_row]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';

		//rev.1.2 �вٿ��ȼ������Ƚ��ʶ�۷׻���decide the number of sales order and number of products to be shipped 
		$cost_amount = null;
		$sale_amount = null;
		//�ѹ��ϼ���������۷׻� for editing, compute the amount from the number of sales order
		if($edit_flg == "true"){
			if($_POST["form_sale_num"][$search_row] != null){
            	$cost_amount = bcmul($goods_data[9], $_POST["form_sale_num"][$search_row],2);
            	$sale_amount = bcmul($goods_data[10], $_POST["form_sale_num"][$search_row],2);
			}
		//������Ͽ����󥿥�Ͻвٿ��ι�פ����۷׻� for new registration��rental, compute the amount from the total number of shipped product
		}else{
			if(in_array(!"", $_POST["form_forward_num"][$search_row])){
	            $cost_amount = bcmul($goods_data[9], array_sum($_POST["form_forward_num"][$search_row]), 2);
            	$sale_amount = bcmul($goods_data[10], array_sum($_POST["form_forward_num"][$search_row]), 2);
			}
		}
		//����������Ϥ���Ƥ����ʾ�ν������̤ä��˾��ϡ��Ʒ׻� if the number of sales orders are being inputted (after going through the processes above), then recompute.
		if($cost_amount != null && $sale_amount != null){
			//������۷׻� compute the cost price
            $cost_amount = Coax_Col($coax, $cost_amount);
			//����۷׻� compute the sales 
            $sale_amount = Coax_Col($coax, $sale_amount);
			$set_goods_data["form_cost_amount"][$search_row] = number_format($cost_amount);
			$set_goods_data["form_sale_amount"][$search_row] = number_format($sale_amount);
		}

		$set_goods_data["hdn_tax_div"][$search_row]          = $goods_data[11]; //���Ƕ�ʬ tax classification
		//rev.1.2 �Ͱ����ʥե饰 discounted product flag
		$set_goods_data["hdn_discount_flg"][$search_row]     = $goods_data[12];
	}else{
		//�ǡ�����̵�����ϡ������ initialize when there is no data 
		$no_goods_flg                                        = true;     //�������뾦�ʤ�̵����Хǡ�����ɽ�����ʤ� do not display data if there is no corresponding product
		$set_goods_data["hdn_goods_id"][$search_row]         = "";
		$set_goods_data["hdn_name_change"][$search_row]      = "";
		$set_goods_data["hdn_stock_manage"][$search_row]     = "";
//		$set_goods_data["form_goods_cd"][$search_row]        = "";
		$set_goods_data["form_goods_name"][$search_row]      = "";
		$set_goods_data["form_stock_num"][$search_row]       = "";
		$set_goods_data["hdn_stock_num"][$search_row]        = "";
		$set_goods_data["form_rorder_num"][$search_row]      = "";
		$set_goods_data["form_rstock_num"][$search_row]      = "";
        $set_goods_data["form_sale_num"][$search_row]        = "";
		$set_goods_data["form_designated_num"][$search_row]  = "";
		$set_goods_data["form_cost_price"][$search_row]["i"] = "";
		$set_goods_data["form_cost_price"][$search_row]["d"] = "";
		$set_goods_data["form_cost_amount"][$search_row]     = "";
		$set_goods_data["form_sale_price"][$search_row]["i"] = "";
		$set_goods_data["form_sale_price"][$search_row]["d"] = "";
		$set_goods_data["form_sale_amount"][$search_row]     = "";
		$set_goods_data["hdn_tax_div"][$search_row]          = "";
		$set_goods_data["hdn_discount_flg"][$search_row]     = "";	//rev.1.2 �Ͱ����ʥե饰 discounted product flag
 	}
	$set_goods_data["goods_search_row"]                  = "";
	$form->setConstants($set_goods_data);

	//���ɽ�������ѹ� edit initial display position
	$height = $search_row * 100;
	$form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";

}


//--------------------------//
// rev.1.3 ľ�������Ͻ��� direct destination input process
//--------------------------//
//ľ���踡���ե饰��ture�ξ�� when the direct destination flag is true
if($_POST["hdn_direct_search_flg"] == "true"){
    $direct_cd = $_POST["form_direct_text"]["cd"];

    //���ꤵ�줿ľ����ξ������� extract the info for the assigned direct destination
    $sql  = "SELECT \n";
    $sql .= "    direct_id, \n";            //ľ����ID direct destination ID
    $sql .= "    direct_cd, \n";            //ľ���襳���� direct destination code
    $sql .= "    direct_name, \n";          //ľ����̾ direct destination name
    $sql .= "    direct_cname, \n";         //ά�� abbreviation
    $sql .= "    t_client.client_cname \n"; //������ billing address
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

    //��������ľ���褬���ä����Τ߽������� only start the process when there is a corrsesponding direct destination
    if($get_direct_data_count > 0){
        //��Ф���ľ����ξ���򥻥å� set the info of the extracted direct destination
        $set_data = NULL;
        $set_data["form_direct_select"]         = $get_direct_data["direct_id"];    //ľ����ID direct destination ID
        $set_data["form_direct_text"]["name"]   = $get_direct_data["direct_cname"]; //ľ����̾ά�� direct destination name abbreviation
        $set_data["form_direct_text"]["claim"]  = $get_direct_data["client_cname"]; //������ billing destination

    //��������ǡ������ʤ��ä����ϡ��������ϥǡ��������ƽ���� initialize all input data if there is no corresponding data
    }else{
        $set_data = NULL;
        $set_data["form_direct_select"]         = "";   //ľ����ID direct destination ID
        $set_data["form_direct_text"]["cd"]     = "";   //ľ���襳���� direct destination code
        $set_data["form_direct_text"]["name"]   = "";   //ľ����̾ά�� direct destination abbreviation
        $set_data["form_direct_text"]["claim"]  = "";   //������ billing address
    }

    //ľ���踡���ե饰������ initialize the direct destination search flag
    $set_data["hdn_direct_search_flg"]          = "";

	$form->setConstants($set_data);

}


/****************************/
//���顼�����å�(addRule) error check (addRule)
/****************************/
//������ customer
//ɬ�ܥ����å� required fields
$form->addGroupRule('form_client', array(
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

//�вٲ�ǽ�� deliverable number of units of product
$form->addRule("form_designated_date","ȯ��ѿ��Ȱ��������θ����������Ⱦ�ѿ��ͤΤߤǤ���","regex", '/^[0-9]+$/');

//������ sales order
//��ɬ�ܥ����å� required field 
//��Ⱦ�ѿ��������å� check for halfwidth number
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

//��˾Ǽ�� desired delivery date
//��Ⱦ�ѿ��������å� check if halfwidth number
$form->addGroupRule('form_hope_day', array(
        'y' => array(
                array('��˾Ǽ�� �����դ������ǤϤ���ޤ���', 'numeric')
        ),
        'm' => array(
                array('��˾Ǽ�� �����դ������ǤϤ���ޤ���','numeric')
        ),
        'd' => array(
                array('��˾Ǽ�� �����դ������ǤϤ���ޤ���','numeric')
        ),
));

//����ͽ���� scheduled delivery date
//��Ⱦ�ѿ��������å� check if halfwidth number
$form->addGroupRule('form_arr_day', array(
        'y' => array(
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���', 'numeric')
        ),
        'm' => array(
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���', 'numeric')
        ),
        'd' => array(
                array('�в�ͽ���� �����դ������ǤϤ���ޤ���', 'numeric')
        ),
));

//���꡼����ꤷ�����ϡ������ȼԤ�ɬ�� If green designation is checked then carrier is a required field
if($_POST["form_trans_check"] != NULL){
	//�����ȼ� carrier
	//��ɬ�ܥ����å� required field
	$form->addRule('form_trans_select','�����ȼԤ����򤷤Ƥ���������','required');
}

//�в��Ҹ� shipping/oubound warehouse
//��ɬ�ܥ����å� required field
$form->addRule("form_ware_select","�в��Ҹˤ����򤷤Ƥ���������","required");

//�����ʬ trade classification
//��ɬ�ܥ����å� required field
$form->addRule("trade_aord_select","�����ʬ�����򤷤Ƥ���������","required");

//ô���� assigned staff
//��ɬ�ܥ����å� required field
$form->addRule("form_staff_select","ô���Ԥ����򤷤Ƥ���������","required");


//�̿���������谸��communication field (Customer)
//��ʸ���������å� check the string number
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_client","�̿���������谸�ˤ�50ʸ������Ǥ���","mb_maxlength","50");


//�̿������������communication field (HQ)
//��ʸ���������å� check the string number
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_head","�̿�����������ˤ�50ʸ������Ǥ���","mb_maxlength","50");

/****************************/
//����ܥ��󲡲����� sales order pressed process
/****************************/
if($_POST["order"] == "�����ǧ���̤�" || $_POST["comp_button"] == "����OK"){
	//�إå�������
	$ord_no               = $_POST["form_order_no"];           //�����ֹ� sales order number
	$designated_date      = $_POST["form_designated_date"];    //�вٲ�ǽ�� deliverable number of units of products
	$ord_day_y            = $_POST["form_ord_day"]["y"];       //������ sles oreder received date
	$ord_day_m            = $_POST["form_ord_day"]["m"];            
	$ord_day_d            = $_POST["form_ord_day"]["d"];            
	$hope_day_y           = $_POST["form_hope_day"]["y"];      //��˾Ǽ�� desired delivery date
	$hope_day_m           = $_POST["form_hope_day"]["m"];           
	$hope_day_d           = $_POST["form_hope_day"]["d"];           
	$arr_day_y            = $_POST["form_arr_day"]["y"];       //����ͽ���� scheduled delivery date
	$arr_day_m            = $_POST["form_arr_day"]["m"];            
	$arr_day_d            = $_POST["form_arr_day"]["d"];            
	$client_cd1           = $_POST["form_client"]["cd1"];      //������CD1 customer CD1
	$client_cd2           = $_POST["form_client"]["cd2"];      //������CD2 customer CD2
	$client_name          = $_POST["form_client"]["name"];     //������̾ customer name
	$note_client          = $_POST["form_note_client"];        //�̿�����������communication field (customer)
	$note_head            = $_POST["form_note_head"];          //�̿����������communication (HQ)
	$trans_check          = $_POST["form_trans_check"];        //���꡼����� Green designation
	$trans_id             = $_POST["form_trans_select"];       //�����ȼ� carrier
	$direct_id            = $_POST["form_direct_select"];      //ľ���� direct destination
	$ware_id              = $_POST["form_ware_select"];        //�Ҹ� warehouse
	$trade_aord           = $_POST["trade_aord_select"];       //�����ʬ trade classification
	$c_staff_id           = $_POST["form_staff_select"];	   //ô���� assigned staff

	/****************************/
    //���顼�����å�(PHP) error check (PHP)
    /****************************/
	$error_flg = false;                                         //���顼Ƚ��ե饰 error flag

	//rev.1.2 ������Ͽ��ʬǼ���ˤ��ѹ�����ʬǼ�ˤ�Ƚ��ե饰��Row_Data_Check2�ؿ��ѡ�decision flag (for Row_Data_Check2 function) for new registration (for batch shipment) or edit (not by batch)
	$check_type = ($edit_flg == "true") ? "aord" : "aord_offline";

    #2009-09-26 hashimoto-y
    $check_ary = array(
                    $_POST[hdn_goods_id],                           //����ID Product ID
                    $_POST[form_goods_cd],                          //���ʥ����� Product code
                    $_POST[form_goods_name],                        //����̾ Product Name
                    $_POST[form_sale_num],                          //����� number of sales order
                    $_POST[form_cost_price],                        //����ñ�� cost price per unit of product
                    $_POST[form_sale_price],                        //���ñ�� sales price per unit of product
                    $_POST[form_cost_amount],                       //������� total cost price
                    $_POST[form_sale_amount],                       //����� sales price 
                    $_POST[hdn_tax_div],                            //���Ƕ�ʬ tax classification
                    $del_history,                                   //������� deletion history
                    $max_row,                                       //����Կ� max row number
                    $check_type,                                    //��������ʬ rev.1.2 sales classification 
                    $db_con,                                        //DB���ͥ������ DB connection
                    "",
                    "",
                    $_POST[hdn_discount_flg]                        //�Ͱ��ե饰 discounted flag
                );      

    $check_data = Row_Data_Check2($check_ary);

    //���顼�����ä���� if there is an error
    if($check_data[0] === true){

        //����̤���򥨥顼 product unselected error
        $goods_error0 = $check_data[1];

        //���ʥ��������� product invalid code
        $goods_error1 = $check_data[2];

        //�����������ñ�������ñ�����ϥ����å� input check for number of received order, cost price, sales price per unit  
        $goods_error2 = $check_data[3];

        //�����Ⱦ�ѥ��顼 sales order  
        $goods_error3 = $check_data[4];

        //����ñ��Ⱦ�ѥ��顼 cost price unit for error for not being halfwidth
        $goods_error4 = $check_data[5];

        //���ñ��Ⱦ�ѥ��顼 sales price per unit error for not being halfwidth
        $goods_error5 = $check_data[6];

        $error_flg = true;
    //���顼��̵���ä���� if there is no error 
    }else{  
        $goods_id         = $check_data[1][goods_id];       //����ID Product ID
        $goods_cd         = $check_data[1][goods_cd];       //����̾ Product Name
        $goods_name       = $check_data[1][goods_name];     //����̾ Product Name
        $sale_num         = $check_data[1][sale_num];       //����� number of units of product being ordered
        $c_price          = $check_data[1][cost_price];     //����ñ������������ cost price per unit of product (integer)
		$s_price          = $check_data[1][sale_price];     //���ñ������������sales price per unit (integer)
        $tax_div          = $check_data[1][tax_div];        //���Ƕ�ʬ tax classification
        $cost_amount      = $check_data[1][cost_amount];    //������� cost price
		$sale_amount      = $check_data[1][sale_amount];    //����� sales price
        $def_line         = $check_data[1][def_line];       //���ֹ� row number
    }

    //���ʥ����å� product check
    //���ʽ�ʣ�����å� product duplication check
    //���ʽ�ʣ�����å� product duplication check
    $goods_count = count($goods_id);
    for($i = 0; $i < $goods_count; $i++){

        //���˥����å��Ѥߤξ��ʤξ��ώ������̎� skip the products that are already checked
        if(@in_array($goods_id[$i], $checked_goods_id)){
            continue;
        }

        //�����å��оݤȤʤ뾦�� products that will be checked
        $err_goods_cd = $goods_cd[$i];
        $mst_line = $def_line[$i];

        for($j = $i+1; $j < $goods_count; $j++){
            //���ʤ�Ʊ����� if the products are the same
            if($goods_id[$i] == $goods_id[$j]) {
                $duplicate_line .= ", ".($def_line[$j]);
            }
        }
        $checked_goods_id[] = $goods_id[$i];    //�����å��Ѥ߾��� products already checked 

        if($duplicate_line != null){
            $duplicate_goods_err[] =  "���ʥ����ɡ�".$err_goods_cd."�ξ��ʤ�ʣ�����򤵤�Ƥ��ޤ���(".$mst_line.$duplicate_line."����)";
        }

        $err_goods_cd   = null;
        $mst_line       = null;
        $duplicate_line = null;
    }

	//�������� date for receiving the order
    //��ʸ��������å� check the string type
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

	//��˾Ǽ�� desired delivery date
    if($hope_day_y != null || $hope_day_m != null || $hope_day_d != null){
        $hope_day_y = (int)$hope_day_y;
        $hope_day_m = (int)$hope_day_m;
        $hope_day_d = (int)$hope_day_d;
        if(!checkdate($hope_day_m,$hope_day_d,$hope_day_y)){
            $form->setElementError("form_hope_day","��˾Ǽ�� �����դ������ǤϤ���ޤ���");
        }else{
            $err_msge = Sys_Start_Date_Chk($hope_day_y, $hope_day_m, $hope_day_d, "��˾Ǽ��");
            if($err_msge != null){
                $form->setElementError("form_hope_day","$err_msge"); 
            }
        }
    }

    //������ͽ���� planned delivery date
    //��ʸ��������å� check the string type
    if($arr_day_y != null || $arr_day_m != null || $arr_day_d != null){
        $arr_day_y = (int)$arr_day_y;
        $arr_day_m = (int)$arr_day_m;
        $arr_day_d = (int)$arr_day_d;
        if(!checkdate($arr_day_m,$arr_day_d,$arr_day_y)){
            $form->setElementError("form_arr_day","�в�ͽ���� �����դ������ǤϤ���ޤ���");
        }else{
            $err_msge = Sys_Start_Date_Chk($arr_day_y, $arr_day_m, $arr_day_d, "�в�ͽ����");
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


	//rev.1.2 ���顼�����å��ʽвٲ����ʬǼ���в�ͽ�������вٿ���error check (number of shipment, scheduled dates for batchdelivery, number of units to be shipped)
	if($edit_flg != "true"){
	    //������˽в�ͽ�����˶�����Ĥξ��ϥǥե���Ȥ����դ����Ϥ��� input the default date if the scheduled delivery date has 1 blank per product
    	for($i = 0; $i< $_POST["max_row"]; $i++){
			//����ID�Τʤ��Ԥϥ����å����ʤ� do not check the rows with no product ID
			if($_POST["hdn_goods_id"][$i] == ""){
				continue;
			}

	        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){
    	        $arv_yy = $_POST["form_forward_day"][$i][$j]["y"];
        	    $arv_mm = $_POST["form_forward_day"][$i][$j]["m"];
            	$arv_dd = $_POST["form_forward_day"][$i][$j]["d"];
	            $arv_ymd = $arv_yy.$arv_mm.$arv_dd;

    	        if($arv_ymd == null){
        	        $null_row[] = $j;
            	}
	        }

    	    //���򤬤ҤĤξ�� when there is only one blank
        	if(count($null_row) == 1){
    	    	//�إå����νв�ͽ������������ʤ���� if the header part of the scheduled delivery date is not blank 
        		if($arr_day_y != null && $arr_day_m != null && $arr_day_d != null){
	            	$row = $null_row[0];
		            $_POST["form_forward_day"][$i][$row]["y"] = $arr_day_y;
    		        $_POST["form_forward_day"][$i][$row]["m"] = $arr_day_m;
        		    $_POST["form_forward_day"][$i][$row]["d"] = $arr_day_d;

				//�إå����ǡ����Ȥ�в�ͽ�����������ȥ��顼 error if the scheduled delivery date both for header and data is blank
				}else{
	        	    $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
    	        	$error_flg = true;
	    	        break;
				}

	        //������İʾ�ξ�� if there are two or more blanks
    	    }elseif(count($null_row) > 1){
        	    $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
            	$error_flg = true;
	            break;
    	    }
        	$null_row = null;
	    }

	    //���в�ͽ���� scheduled delivery date
    	//���ʿ��ʼ���˥롼�� loop through the number of products (type)
	    for($i=0;$i<$_POST["max_row"];$i++){
			//����ID�Τʤ��Ԥϥ����å����ʤ� do not check the row with no product ID
			if($_POST["hdn_goods_id"][$i] == ""){
				continue;
			}

	        //�вٲ����������ݻ� store the number of shipment in array
    	    $array_count[$i] = $_POST["form_forward_times"][$i];
        	//�вٲ���롼�� loop through the number of shipment
	        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){

    	        //���դ�NULL�Ǥʤ����0��� If dates is not null then fill with 0s
        	    if($_POST["form_forward_day"][$i][$j]["y"] != NULL){
            	    $_POST["form_forward_day"][$i][$j]["y"] = str_pad($_POST["form_forward_day"][$i][$j]["y"], 4, 0, STR_PAD_LEFT);
	            }
    	        if($_POST["form_forward_day"][$i][$j]["m"] != NULL){
        	        $_POST["form_forward_day"][$i][$j]["m"] = str_pad($_POST["form_forward_day"][$i][$j]["m"], 2, 0, STR_PAD_LEFT);
            	}
	            if($_POST["form_forward_day"][$i][$j]["d"] != NULL){
    	            $_POST["form_forward_day"][$i][$j]["d"] = str_pad($_POST["form_forward_day"][$i][$j]["d"], 2, 0, STR_PAD_LEFT);
        	    }

	            //�в�ͽ���� ��$yy $mm $dd ��NULL�����å������դ����������ǧ���뤿��Ԥʤ�ʤ���scheduled delivery date (No NULL check for $yy $mm $dd since date will be validated)
    	        $yy  = $_POST["form_forward_day"][$i][$j]["y"];
        	    $mm  = $_POST["form_forward_day"][$i][$j]["m"];
            	$dd  = $_POST["form_forward_day"][$i][$j]["d"];
	            $ymd = $yy.$mm.$dd;

    	        //�в�ͽ������NULL�Ǥʤ���� if the scheduled date is not NULL
        	    if($ymd != NULL){

	                //���դ������ʾ�� if the date is valid
    	            if(checkdate((int)$mm, (int)$dd, (int)$yy)){  //���㥹�Ȥ�0��NULL���Ѵ� convert 0 to NULL using cast

	                    //�в�ͽ������Ⱦ�ѿ����ǤϤʤ���� if the scheduled delivery date is not half width number 
    	                if(!ereg("^[0-9]+$", $yy) || !ereg("^[0-9]+$", $mm) || !ereg("^[0-9]+$", $dd)){
        	                $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
            	            $error_flg = true;
                	    }

	                    //�в�ͽ��������ʣ������ when the scheduled delivery date duplicates
    	                if($all_ymd_goods[$i][$ymd] == "1"){
        	                $forward_day_err = "Ʊ��ξ��ʤ�ʬǼ�в�ͽ��������ʣ���Ƥ��ޤ���";
            	            $error_flg = true;
                	    }else{
	                        $all_ymd_goods[$i][$ymd] = 1; //����($i)�νв����˥ե饰��Ω�Ƥ� flag the scheduled delivery date of product ($i)
    	                }

        	            //�в�ͽ�����������������ξ�� if the scheduled delivery date is before the sales order received date
            	        if($error_flg == true && $ymd < $aord_ymd){
                	        $forward_day_err = "ʬǼ�в�ͽ�����ϼ������ʹߤ����դ����ꤷ�Ʋ�������";
                    	    $error_flg = true;
	                    }

    	                $err_msge = Sys_Start_Date_Chk($yy, $mm, $dd, "ʬǼ�в�ͽ����");
        	            if($err_msge != null){
            	        $forward_day_err = $err_msge;
                	        $error_flg = true;
                    	}

	                //���դ������Ǥʤ���� if the date is not valid
    	            }else{
        	            $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
            	        $error_flg = true;
                	}
	            }

    	        //���вٿ������å� check the number of products to be shipped
        	    //��ɬ�ܥ����å� required field
            	if($_POST["form_forward_num"][$i][$j] == null || !ereg("^[0-9]+$", $_POST["form_forward_num"][$i][$j]) || $_POST["form_forward_num"][$i][$j] == 0){
                	$forward_num_err = "�вٿ���Ⱦ�ѿ��ͤΤߤǤ���";
	                $error_flg = true;
    	        }
        	}

			//�вٲ�����ǧ�����Ѥ�+1�����ͤ�ƥ����ȥܥå���������� input the number of shipment +1 in the textbox for the confirmation screen
			$form->setConstants(array("form_forward_times_text[$i]" => $_POST["form_forward_times"][$i] + 1));

		}
    }


	//���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ� if error occurs then do not proceed furthermore
    if($form->validate() && $error_flg == false){

		//��ϿȽ�� decide registration 
		if($_POST["comp_button"] == "����OK"){
			//���ߤξ�����Ψ current consumption tax rate
            #2009-12-21 aoyama-n
			#$sql  = "SELECT ";
			#$sql .= "    tax_rate_n ";
			#$sql .= "FROM ";
			#$sql .= "    t_client ";
			#$sql .= "WHERE ";
			#$sql .= "    client_id = $shop_id;";
			#$result = Db_Query($db_con, $sql); 
			#$tax_num = pg_fetch_result($result, 0,0);

            #2009-12-21 aoyama-n
            $tax_rate_obj->setTaxRateDay($ord_day_y."-".$ord_day_m."-".$ord_day_d);
            $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

			//���դη����ѹ� change the date format
			$ord_day  = $ord_day_y."-".$ord_day_m."-".$ord_day_d;
			if($hope_day_y != null){
				$hope_day = $hope_day_y."-".$hope_day_m."-".$hope_day_d;
			}
			if($arr_day_y != null){
				$arr_day  = $arr_day_y."-".$arr_day_m."-".$arr_day_d;
			}

			//rev.1.2 ��Ͽ���ѹ��ǽ�����ʬ���� separated the process between registration and edit
			//�ѹ��� when editing
			if($edit_flg == "true"){

				$total_money = Total_Amount($cost_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
				$cost_money  = $total_money[0];
				$total_money = Total_Amount($sale_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
				$sale_money  = $total_money[0];
				$sale_tax    = $total_money[1];

			//������Ͽ�� when newly registering
			}else{

				//ʬǼ���Ͻв�ͽ�������Ȥ˼������Ͽ���� if it's a by batch delivery, register the sales order per scheduled delivery date 
				//���ʿ��ʼ���˥롼�� loop throught the number of types of product 
				for($i=0;$i<$_POST["max_row"];$i++){
					//����ID�Τʤ��Ԥϥ����å����ʤ� do not check the row that has no product ID
					if($_POST["hdn_goods_id"][$i] == ""){
						continue;
					}

					//�вٲ���롼�� loop through the number of shipment
					for($j=0; $j<=$_POST["form_forward_times"][$i]; $j++){
	                    //�в�ͽ���� scheduled shipment date
    	                $f_yy  = $_POST["form_forward_day"][$i][$j]["y"];
        	            $f_mm  = $_POST["form_forward_day"][$i][$j]["m"];
            	        $f_dd  = $_POST["form_forward_day"][$i][$j]["d"];
                	    $f_ymd = $f_yy.$f_mm.$f_dd;
                    	$all_ymd[] = $f_yy.$f_mm.$f_dd; //���в�ͽ���� all scheduled shipment date 

						//�ѿ�̾�ѹ� change the name of the variable
	                    $goods_id     = $_POST["hdn_goods_id"][$i];				//����ID Product ID
    	                $forward_num  = $_POST["form_forward_num"][$i][$j];		//�вٿ� number of shipment

	                    //������إå��� For received order header
						$post_cost_price = $_POST["form_cost_price"][$i]["i"].".".$_POST["form_cost_price"][$i]["d"];
    	                $data_h[$f_ymd]["�������"][] = Coax_Col($coax, bcmul($post_cost_price, $forward_num, 1));	//�������(��ɼ�׻��Ф�����) total cost price (used for computation in voucher)
						$post_sale_price = $_POST["form_sale_price"][$i]["i"].".".$_POST["form_sale_price"][$i]["d"];
        	            $data_h[$f_ymd]["�����"][] = Coax_Col($coax, bcmul($post_sale_price, $forward_num, 1));	//�����(��ɼ�׻��Ф�����) total sales price (used fir computation in voucher)
            	        $data_h[$f_ymd]["���Ƕ�ʬ"][] = $_POST["hdn_tax_div"][$i];

	                    //������ǡ����� For received order data
    	                $data_d[$f_ymd]["good_id"][]                   	 = $goods_id;                           		//����ID product ID
        	            $data_d[$f_ymd]["line"][]                      	 = $i;                                 			//�Կ� number of rows
            	        $data_d[$f_ymd][$goods_id."-".$i]["goods_name"]	 = addslashes($_POST["form_goods_name"][$i]);	//����̾ product name
                	    $data_d[$f_ymd][$goods_id."-".$i]["num"]       	 = $forward_num;                        		//�вٿ� number of shipment
                    	$data_d[$f_ymd][$goods_id."-".$i]["cost_price"]  = $post_cost_price;               				//����ñ�� cost per unit 
	                    $data_d[$f_ymd][$goods_id."-".$i]["sale_price"]  = $post_sale_price;							//���ñ�� sales per unit
    	                $data_d[$f_ymd][$goods_id."-".$i]["cost_amount"] = Coax_Col($coax, bcmul($post_cost_price, $forward_num, 1));	//������ۡʾ��ʹ�ס� total sales 
        	            $data_d[$f_ymd][$goods_id."-".$i]["sale_amount"] = Coax_Col($coax, bcmul($post_sale_price, $forward_num, 1));	//����ۡʾ��ʹ�ס�sales total (total products)
            	        $data_d[$f_ymd][$goods_id."-".$i]["tax_div"]     = $_POST["hdn_tax_div"][$i];               	//���Ƕ�ʬ tax classification

					}
				}
			}

			//����إå�������ǡ�������Ͽ������SQL sales order header, sales order data, registration, SQL update
			Db_Query($db_con, "BEGIN");

			//�ѹ�����Ƚ�� decision for edit process
			if($aord_id != NULL){
                //�����ѹ����ˡ�����ǡ�����¸�ߤ�̵ͭ���ǧ����check if a sales order data exist before editing
                $sql  = "SELECT";
                $sql .= "   COUNT(aord_id) ";
                $sql .= "FROM";
                $sql .= "   t_aorder_h ";
                $sql .= "WHERE";
                $sql .= "   aord_id = $aord_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                $del_count = pg_fetch_result($result, 0,0);

                if($del_count == 0){
                    Db_Query($db_con, "ROLLBACK;");
                    header("Location: ./1-2-108.php?add_del_flg='t'");
                    exit;    
                }

				//����إå����ѹ� edit the sales order data
				$sql  = "UPDATE t_aorder_h SET ";
				$sql .= "    ord_no = '$ord_no',";
				$sql .= "    ord_time = '$ord_day',";
				$sql .= "    client_id = $client_id,";
				//ľ���褬���ꤵ��Ƥ��뤫 is direct destination assigned
				if($direct_id != null){
					$sql .= "    direct_id = $direct_id,";
				}else{
					$sql .= "    direct_id = NULL,";
				}
				$sql .= "    trade_id = '$trade_aord',";
				//�����ȼԤ����ꤵ��Ƥ��뤫 is the carrier assigned
				if($trans_id != null){
					$sql .= "    trans_id = $trans_id,";
				}else{
					$sql .= "    trans_id = NULL,";
				}
				//�����å��ͤ�boolean���ѹ� change the checked value to booloean
	            if($trans_check==1){
	                $sql .= "green_flg = true,";    
	            }else{
	                $sql .= "green_flg = false,";    
	            }
				//��˾Ǽ�������ꤵ��Ƥ��뤫 is the desired delivery date assigned
				if($hope_day != null){
					$sql .= "    hope_day = '$hope_day',";
				}else{
					$sql .= "    hope_day = null,";
                } 
				if($arr_day != null){
					$sql .= "    arrival_day = '$arr_day',";
				}else{
					$sql .= "    arrival_day = null,";
                } 
				$sql .= "    note_my = '$note_head',";
				$sql .= "    note_your = '$note_client',";
				$sql .= "    cost_amount = $cost_money,";    
				$sql .= "    net_amount = $sale_money,";    
	            $sql .= "    tax_amount = $sale_tax,";    
				$sql .= "    c_staff_id = $c_staff_id,";
				$sql .= "    ware_id = $ware_id,";
				$sql .= "    ord_staff_id = $o_staff_id, ";
                $sql .= "    client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
                $sql .= ($direct_id != null) ? " direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), " : " direct_name = NULL, ";
                $sql .= ($direct_id != null) ? " direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), " : " direct_name2 = NULL, ";
                $sql .= ($direct_id != null) ? " direct_cname = (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), " : " direct_cname = NULL, ";
                $sql .= ($trans_id != NULL) ? " trans_name = (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), " : " trans_name = NULL, ";
                $sql .= ($trans_id != NULL) ? " trans_cname = (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), " : " trans_cname = NULL, ";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
                $sql .= "    c_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id), ";
                $sql .= "    ord_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $o_staff_id), ";
                $sql .= "    change_day = CURRENT_TIMESTAMP ";

/***********************************************
				$sql .= "    check_flg = false,";
				$sql .= "    check_staff_id = NULL, ";
			    $sql .= "    check_user_name = NULL ";
************************************************/

				$sql .= "WHERE ";
	            $sql .= "    aord_id = $aord_id;";

				$result = Db_Query($db_con,$sql);
	            if($result == false){
	                Db_Query($db_con,"ROLLBACK;");
	                exit;
	            }

				//����ǡ������� delete the sales order 
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

				//rev.1.2 ����ǡ�����Ͽ�Ѥ���ɼ�ֹ���ݻ� store the voucher number for sales order registration
				$array_ord_no[$ord_day] = $ord_no;	//��ʬǼ���Ͻв�ͽ������ɬ�ܤǤϤʤ��Τǡ���������������� create an array with sales order date if its not a batch delivery since scheduled delivery date is not required

			//������Ͽ new registration
			}else{

				//rev.1.2 
				//�в�ͽ���������ʣ�������� delete the duplication fo scheduled delivery date
	            $all_ymd_uniq = array_unique($all_ymd);
                asort($all_ymd_uniq);

	            //�в�ͽ����(��ʣ�����)�ο���������إå�����Ͽ���� register sales order header as many as scheduled delivery dates are
    	        //while($fw_day = array_shift($all_ymd_uniq)){
				foreach($all_ymd_uniq as $fw_day){
        	        //��ɼ�ֹ� voucher/slip number
            	    $order_no_pad = str_pad($ord_no, 8, 0, STR_PAD_LEFT);

	                //���������(�ǹ�)����� compute for the total cost (with tax)
    	            $cost_money = array_sum($data_h["$fw_day"]["�������"]); //DB�˥����ʤ� no column in DB

        	        //�������(�ǹ�)������ס���ȴ�ˤȡ������Ǥ�ʬ���� separate the total sales to total sales (without tax) and tax
            	    $total_amount = Total_Amount($data_h["$fw_day"]["�����"], $data_h["$fw_day"]["���Ƕ�ʬ"], $coax,$tax_franct,$tax_num, $client_id, $db_con);
	                $sale_money = $total_amount[0]; //����� total sales
    	            $sale_tax = $total_amount[1]; //������ tax


					//����إå�����Ͽ register the sales order header
					$sql  = "INSERT INTO t_aorder_h (";
					$sql .= "    aord_id,";
					$sql .= "    ord_no,";
					$sql .= "    ord_time,";
					$sql .= "    client_id,";
					//ľ���褬���ꤵ��Ƥ��뤫 is the direct destination assigned?
					if($direct_id != null){
						$sql .= "    direct_id,";
					}
					$sql .= "    trade_id,";
					//�����ȼԤ����ꤵ��Ƥ��뤫 is the carrier assigned?
					if($trans_id != null){
						$sql .= "    trans_id,";
					}
					//���꡼����꤬���ꤵ��Ƥ��뤫 is the green designation assigned?
					if($trans_check != null){
						$sql .= "    green_flg,";
					}
					//��˾Ǽ�������ꤵ��Ƥ��뤫 is the desired delivery date assigned?
					if($hope_day != null){
						$sql .= "    hope_day,";
					}
					//����ͽ���������ꤵ��Ƥ��뤫 is the scheduled delivery date assigned?
					//if($arr_day != null){
						$sql .= "    arrival_day,";
					//}
					$sql .= "    note_my,";
					$sql .= "    note_your,";
					$sql .= "    cost_amount,";   
					$sql .= "    net_amount,";                  
		            $sql .= "    tax_amount,";              
					$sql .= "    c_staff_id,";
					$sql .= "    ware_id,";
					$sql .= "    ord_staff_id,";
					$sql .= "    ps_stat,";
					$sql .= "    shop_id, ";
	                $sql .= "    client_cd1, ";
	                $sql .= "    client_cd2, ";
	                $sql .= "    client_name, ";
	                $sql .= "    client_name2, ";
	                $sql .= "    client_cname, ";
	                $sql .= ($direct_id != null) ? " direct_name, " : null;
	                $sql .= ($direct_id != null) ? " direct_name2, " : null;
	                $sql .= ($direct_id != null) ? " direct_cname, " : null;
	                $sql .= ($trans_id != null) ? " trans_name, " : null;
	                $sql .= ($trans_id != null) ? " trans_cname, " : null;
	                $sql .= "    ware_name, ";
	                $sql .= "    c_staff_name, ";
	                $sql .= "    ord_staff_name, ";
	                $sql .= "    check_flg, ";
	                $sql .= "    claim_id, ";
	                $sql .= "    claim_div ";
					$sql .= ")VALUES(";
					$sql .= "    (SELECT COALESCE(MAX(aord_id), 0)+1 FROM t_aorder_h),";         
					$sql .= "    '$order_no_pad',";          
		            $sql .= "    '$ord_day',";
					$sql .= "    $client_id,";
					//ľ���褬���ꤵ��Ƥ��뤫 is the direct destination filled
					if($direct_id != null){
						$sql .= "    $direct_id,";
					}
					$sql .= "    '$trade_aord',";
					//�����ȼԤ����ꤵ��Ƥ��뤫 Is the carrier filled
					if($trans_id != null){
						$sql .= "    $trans_id,";
					}
					//���꡼����꤬���ꤵ��Ƥ��뤫 is the green designation filled
					if($trans_check != null){
			            if($trans_check==1){
			                $sql .= "true,";    
			            }else{
			                $sql .= "false,";    
			            }
					}
					//��˾Ǽ�������ꤵ��Ƥ��뤫 is the  desired delivery date filled
					if($hope_day != null){
		            	$sql .= "    '$hope_day',";
					}
					//����ͽ���������ꤵ��Ƥ��뤫 Is scheduled delivery date filled?
					//if($arr_day != null){  
		            	//$sql .= "    '$arr_day',";
		            	$sql .= "    '$fw_day',";
					//}
					$sql .= "    '$note_head',"; 
		            $sql .= "    '$note_client',";
					$sql .= "    $cost_money,";   
					$sql .= "    $sale_money,";                  
		            $sql .= "    $sale_tax,";        
		            $sql .= "    $c_staff_id,";
		            $sql .= "    $ware_id,";           
		            $sql .= "    $o_staff_id,";
					//�������� Process status
					$sql .= "    '1',";
					$sql .= "    $shop_id, ";
	                $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
	                $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
	                $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
	                $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
	                $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
	                $sql .= ($direct_id != null) ? " (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), " : null;
	                $sql .= ($direct_id != null) ? " (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), " : null;
					$sql .= ($direct_id != null) ? " (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), " : null;
	                $sql .= ($trans_id != null) ? " (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), " : null;
	                $sql .= ($trans_id != null) ? " (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), " : null;
	                $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
	                $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id), ";
	                $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $o_staff_id), ";
	                $sql .= "    't',";
	                $sql .= "    (SELECT claim_id FROM t_claim WHERE client_id = $client_id AND claim_div = '1'), ";
	                $sql .= "    '1' ";
	                $sql .= ");";


					$result = Db_Query($db_con, $sql);
					//Ʊ���¹�������� restriction process for simultaenous execution
					if($result == false){
		                $err_message = pg_last_error();
		                $err_format = "t_aorder_h_ord_no_key";

		                Db_Query($db_con, "ROLLBACK");

		                //�����ֹ椬��ʣ�������            when the sales order number are duplicated
		                if(strstr($err_message,$err_format) != false){
		                    $error = "Ʊ���˼����Ԥä����ᡢ�����ֹ椬��ʣ���ޤ������⤦���ټ���򤷤Ʋ�������";
		
		                    //���ټ����ֹ��������� acquire again the sales order number
		                    $sql  = "SELECT ";
		                    $sql .= "   MAX(ord_no)";
		                    $sql .= " FROM";
		                    $sql .= "   t_aorder_h";
		                    $sql .= " WHERE";
		                    $sql .= "   shop_id = $shop_id";
		                    $sql .= ";";

		                    $result = Db_Query($db_con, $sql);
		                    $ord_no = pg_fetch_result($result, 0 ,0);
		                    $ord_no = $ord_no +1;
		                    $ord_no = str_pad($ord_no, 8, 0, STR_PAD_LEFT);

		                    $err_data["form_order_no"] = $ord_no;
		                    $form->setConstants($err_data);

		                    $duplicate_flg = true;

							break;	//rev.1.2 �в�ͽ�����Υ롼�פ�ȴ���� get out from the scheduled shipment date loop

		                }else{
		                    exit;
		                }
		            }else{

						//����ǡ�����Ͽ�Ѥ���ɼ�ֹ���ݻ� store the voucher number for sales order data registration
						$array_ord_no[$fw_day] = $order_no_pad;
						//rev.1.2 ��ɼ�ֹ� voucher number
						(int)$ord_no ++;

					}

				}//rev.1.2 �в�ͽ�����롼�׽���� finish with the scheduled delivery date loop
			}

	        if($duplicate_flg != true){
			    //����ǡ�����Ͽ register the sales order data

                //�в�ͽ��������ʬǼ���ϼ������ˤǥ롼�� loop with scheduled shipment date (if its not by batch shipment then use the sales order date here)
                foreach($array_ord_no as $fw_day => $ord_no){

                    //$line = 0;

                    //������Ͽ��ʬǼ���ˤϽв�ͽ�������Ȥ� new registration (for batch delivery) will be per scheduled delivery date
					if($edit_flg != "true"){

                        //��������� initialize the arrays
                        $goods_id       = array();
                        $tax_div        = array();
                        $sale_num       = array();
                        $c_price        = array();
                        $s_price        = array();
                        $cost_amount    = array();
                        $sale_amount    = array();
                        $goods_name     = array();

                        //$fw_day �˽вپ���ʬ�롼�׽��� shipping products loop process to $fw_day
                        while($fw_goods_id = array_shift($data_d[$fw_day]["good_id"])){

                            //�вپ��ʤ����Ϲ� input row for shipping products
                            $fw_goods_line = array_shift($data_d[$fw_day]["line"]);

                            $goods_id[]     = $fw_goods_id;                                                     //����ID Product ID
                            $tax_div[]      = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["tax_div"];     //���Ƕ�ʬ tax classification
                            $sale_num_tmp   = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["num"];
                            $sale_num[]     = $sale_num_tmp;                                                    //�вٿ� number of products to be shipped  
                            $c_price_tmp    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["cost_price"];
                            $c_price[]      = $c_price_tmp;                                                     //����ñ�� cost price per unit
                            $s_price_tmp    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["sale_price"];
                            $s_price[]      = $s_price_tmp;                                                     //���ñ�� sales per unit

                            $c_amount       = bcmul($sale_num_tmp, $c_price_tmp, 1);
                            $cost_amount[]  = Coax_Col($coax, $c_amount);                                       //������� cost price
                            $s_amount       = bcmul($sale_num_tmp, $s_price_tmp, 1);
                            $sale_amount[]  = Coax_Col($coax, $s_amount);                                       //����� total sales 
                            $goods_name[]   = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["goods_name"];	//����̾ product name

                        }
                    }


		            for($i = 0; $i < count($goods_id); $i++){
		                //�� row
		                $line = $i + 1;

		                $sql  = "INSERT INTO t_aorder_d (\n";
		                $sql .= "    aord_d_id,\n";
		                $sql .= "    aord_id,\n";
		                $sql .= "    line,\n";
		                $sql .= "    goods_id,\n";
//		                $sql .= "    goods_name,\n";
		                $sql .= "    official_goods_name,\n";
		                $sql .= "    num,\n";
		                $sql .= "    tax_div,\n";
		                $sql .= "    cost_price,\n";
		                $sql .= "    cost_amount,\n";
					    $sql .= "    sale_price,\n";
		                $sql .= "    sale_amount,\n";
	                    $sql .= "    goods_cd \n";
//					    $sql .= "    tax_amount";
		                $sql .= ")VALUES(\n";
		                $sql .= "    (SELECT COALESCE(MAX(aord_d_id), 0)+1 FROM t_aorder_d),\n";  
		                $sql .= "    (SELECT\n";
		                $sql .= "         aord_id\n";
		                $sql .= "     FROM\n";
		                $sql .= "        t_aorder_h\n";
		                $sql .= "     WHERE\n";
		                $sql .= "        ord_no = '$ord_no'\n";
		                $sql .= "        AND\n";
		                $sql .= "        shop_id = $shop_id\n";
		                $sql .= "    ),\n";
		                $sql .= "    '$line',\n";
		                $sql .= "    $goods_id[$i],\n";
		                $sql .= "    '$goods_name[$i]',\n"; 
		                $sql .= "    '$sale_num[$i]',\n";
		                $sql .= "    '$tax_div[$i]',\n";
		                $sql .= "    $c_price[$i],\n";
		                $sql .= "    $cost_amount[$i],\n";
					    $sql .= "    $s_price[$i],\n";
		                $sql .= "    $sale_amount[$i],\n";
	                    $sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_id[$i]) \n";
//					    $sql .= "    $t_price";
		                $sql .= ");\n";

		                $result = Db_Query($db_con, $sql);

		                if($result == false){
		                    Db_Query($db_con, "ROLLBACK");
		                    exit;
		                }
				    }

				    for($i = 0; $i < count($goods_id); $i++){
		                $line = $i + 1;
//�����ʤ����߸˼���ʧ���ơ��֥����Ͽ���� in any case register it to the inventory store balance
//		                if($stock_manage_flg[$i] == '1'){
		                    //����ʧ���ơ��֥����Ͽ register it to the inventory store balance
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
		                    $sql .= "                    ord_no = '$ord_no'";
		                    $sql .= "                    AND";
		                    $sql .= "                    shop_id = $shop_id";
		                    $sql .= "                )";
		                    $sql .= "    ),";
		                    $sql .= "    $o_staff_id,";
		                    $sql .= "    $shop_id,";
	                        $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
		                    $sql .= ");";

		                    $result = Db_Query($db_con, $sql);
		                    if($result == false){
		                        Db_Query($db_con, "ROLLBACK");
		                        exit;
		                    }
//		                }
		            }

				}//re.1.2 �в�ͽ�������ȥ롼�׽���� finish loop per scheduled delivery date

	    		//������Ͽ�ξ��ϡ�GET����̵���١�GET������� Create a GET information if it's a new registration
		    	if($aord_id == null){
					//rev.1.2 ʬǼ����ʣ�������Ǥ��뤿�� because multiple orders are possible with batch delivery
					$all_ord_no = "";
					foreach($array_ord_no as $ord_no){
						$all_ord_no .= "'".$ord_no."'";
						$all_ord_no .= ", ";
					}
					$all_ord_no = substr($all_ord_no, 0, strlen($all_ord_no) - 2);	//�Ǹ��", "��;�פʤΤǼ�� take out the "," in the last part

			    	//�����ǧ���Ϥ�����ID���� acquire the sales order ID that will be pass to order confirmation
		            $sql  = "SELECT ";
	    	        $sql .= "    aord_id ";
		            $sql .= "FROM ";
		            $sql .= "    t_aorder_h ";
		            $sql .= "WHERE ";
	    	        //$sql .= "    ord_no = '$ord_no'";
	    	        $sql .= "    ord_no IN ($all_ord_no)";	//rev.1.2
		            $sql .= "AND ";
		            $sql .= "    shop_id = $shop_id;";
		            $result = Db_Query($db_con, $sql);
	    	        //$aord_id = pg_fetch_result($result,0,0);
					//rev.1.2
					$count_ord_no = pg_num_rows($result);
					for($i=0, $aord_id = ""; $i<$count_ord_no; $i++){
		    	        $aord_id .= pg_fetch_result($result, $i, 0);
						$aord_id .= "&";
					}
					$aord_id = substr($aord_id, 0, strlen($aord_id) - 1);	//�Ǹ��"&"��;�פʤΤǼ�� take out the "&" in the last part
		    	}
	            Db_Query($db_con, "COMMIT");
	            header("Location: ./1-2-108.php?aord_id=$aord_id&input_flg=true");
	        }
		}else{
			//��Ͽ��ǧ���̤�ɽ���ե饰 flag for display of registration confirmation screen
			$comp_flg = true;
		}
	}
}

/****************************/
//�����å���λ�ܥ��󲡲����� process when check button is pressed
/****************************/
/*******************************************************************
if($_POST["complete_flg"] == true && $aord_id != NULL){
	Db_Query($db_con, "BEGIN");

    /*******************************/
    //����¸�ߤ��뤫��ǧ check if a sales order exist 
    /*******************************/
/*******************************************************************
    $sql  = "SELECT";
    $sql .= "   COUNT(aord_id) ";
    $sql .= "FROM";
    $sql .= "   t_aorder_h ";
    $sql .= "WHERE";
    $sql .= "   aord_id = $aord_id";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $update_check_flg = (pg_fetch_result($result, 0,0 ) > 0)? true : false;
    if($update_check_flg === false){ 
        header("Location: ./1-2-108.php?aord_del_flg=true");
        exit;   
    } 

	$sql  = "UPDATE t_aorder_h SET ";
	$sql .= "    check_flg = true,";
	$sql .= "    check_staff_id = $o_staff_id, ";
    $sql .= "    check_user_name = (SELECT staff_name FROM t_staff WHERE staff_id = $o_staff_id)";
	$sql .= "WHERE ";
	$sql .= "    aord_id = $aord_id;";
	$result = Db_Query($db_con, $sql);

    if($result == false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }
	Db_Query($db_con, "COMMIT");
	header("Location: ./1-2-105.php");
}
*************************************************************************/

/****************************/
//���ʺ����ʲ��ѡ�create component (variable)
/****************************/
//���ֹ楫���� row number counter
$row_num = 1;

//�вٲ�����쥯�ȥܥå����� rev.1.2 for number of shipment selection box
$select_page_arr = array(1,2,3,4,5,6,7,8,9,10);


//�����褬���򤵤�Ƥ��ʤ����ϥե�������ɽ�� do not display the form if the customer is not selected 
/************************************************************************
if($warning != null || $comp_flg == true || $check_flg == true){
*************************************************************************/
if($warning != null || $comp_flg == true){
    #2009-09-26 hashimoto-y
	#$style = "color: #000000; border: #ffffff 1px solid; background-color: #ffffff";
	$style = "border: #ffffff 1px solid; background-color: #ffffff";
    $type = "readonly";
}else{
    $type = $g_form_option;
}
for($i = 0; $i < $max_row; $i++){
    //ɽ����Ƚ�� determine the displayable row
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;

		//rev.1.2 �Ͱ����ʤ�Ƚ��ʰʲ����ƤΥե�������ɲá�determine if its a discounted product (include in all forms hereon)
		$hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

		if($hdn_discount_flg == "t"){
			$font_color = "color: red; ";	//�Ͱ����ʤξ��ϥե���Ȥ��֤ˤ��� turn the font color to red for discounted products
		}else{
			$font_color = "color: #000000; ";
		}

        //���ʥ����� product code
        $form->addElement(
            "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\" 
             style=\"$style $g_form_style $font_color\" $type tabindex=\"-1\" 
            onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'goods_search_row', $i ,$row_num)\""
        );

		//����̾ product name
		//�ѹ��Բ�Ƚ�� determine if its editable or not
		//if(($_POST["hdn_name_change"][$i] == '2' || $hdn_name_change[$i] == '2') && $comp_flg != true && $check_flg != true){
/**********************************************************************
		if(($hdn_name_change[$i] == '2') && $comp_flg != true && $check_flg != true){
**********************************************************************/
		if(($hdn_name_change[$i] == '2') && $comp_flg != true){
			//�Բ� not editable
            $form->addElement(
                "text","form_goods_name[$i]","",
                #2009-09-26 hashimoto-y
                #"size=\"60\" $g_text_readonly" 
                "size=\"60\" style=\"$font_color\" $g_text_readonly" 
            );
        }else{
			//�� editable
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"60\" maxLength=\"41\" 
                style=\"$font_color $style \" $type"
            );
        }

        //��ê�� actual shelf number
		//�߸˴���Ƚ�� determine inventory control 
		//if($no_goods_flg!=true && ($_POST["hdn_stock_manage"][$i] == '1' || $hdn_stock_manage[$i] == '1')){
		if($no_goods_flg!=true && ($hdn_stock_manage[$i] == '1')){
			//�����褬�Ѥ�ä��Τǽ���� initialize cos the customer changed
			if($post_flg == true){
				$form->addElement("static","form_stock_num[$i]","#","","");
			}else{

				//ͭ yes
				//POST�������ΤȤ��ʳ��ϡ�hidden���ͤ���Ѥ���(��ê��) *��󥿥����ܻ��ˤ�hidden���ͤ���� use the value of hidden for actual shelf number as well as for transition from rental excep before POST
				if($_POST["hdn_stock_num"][$i] != NULL && ($_POST["hdn_stock_num"][$i] == $stock_num[$i] || $rental_flg == true)){
					$hdn_num = $_POST["hdn_stock_num"][$i];
				}else{
					$hdn_num = $stock_num[$i];
				}

				//POST�������ΤȤ��ʳ��ϡ�hidden���ͤ���Ѥ���(����ID)
				if($_POST["hdn_goods_id"][$i] != NULL && $_POST["hdn_goods_id"][$i] == $hdn_goods_id[$i]){
					$hdn_id = $_POST["hdn_goods_id"][$i];

/*
                }elseif($_POST["hdn_goods_id"][$i] != NULL){
                    $hdn_id = $_POST["hdn_goods_id"][$i];
*/
				}else{
					$hdn_id = $hdn_goods_id[$i];
				}

				$form->addElement("link","form_stock_num[$i]","","#","$hdn_num","onClick=\"Open_mlessDialmg_g('1-2-107.php',$hdn_id,$client_id,300,160);\"");
			}
		//}else if($no_goods_flg!=true && ($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2')){
		}else if($no_goods_flg!=true && ($hdn_stock_manage[$i] == '2')){
			//̵ none
            #2009-09-26 hashimoto-y
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

        //ȯ��ѿ� number of fulfilled orders
		//�߸˴���Ƚ�� inventory control decision
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//̵ none
            #2009-09-26 hashimoto-y
			#$form->addElement("static","form_rorder_num[$i]","#","-","");
	        $form->addElement(
	            "text","form_rorder_num[$i]","",
	            "size=\"11\" maxLength=\"9\" 
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

        //������ number of reserved units of product
		//�߸˴���Ƚ�� inventory control decision
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//̵ none
            #2009-09-26 hashimoto-y
			#$form->addElement("static","form_rstock_num[$i]","#","-","");
	        $form->addElement("text","form_rstock_num[$i]","",
	            "size=\"11\" maxLength=\"9\" 
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

        //�вٲ�ǽ�� number of products that can be shipped
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//̵ none
            #2009-09-26 hashimoto-y
			#$form->addElement("static","form_designated_num[$i]","#","-","");
	        $form->addElement("text","form_designated_num[$i]","",
	            "size=\"11\" maxLength=\"9\" 
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

        //����� number of sales order
		// rev.1.2 �ѹ����̤Τ�ɽ�� only display edit screen
		if($edit_flg == "true"){
	        $form->addElement(
    	        "text","form_sale_num[$i]","",
        	    "class=\"money\" size=\"11\" maxLength=\"5\" 
            	onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"
	            style=\"text-align: right; $style $g_form_style $font_color\" $type "
    	    );
		}

		//rev.1.2 �ѹ����ζ�۷׻�JS computation of amount when edited
		if($edit_flg == "true"){
			$mult_js = "onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"";
		//ʬǼ���ζ�۷׻�JS computation when it's a batch shipment
		}else{
			$mult_js = "onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"";
		}

        //����ñ�� cost per unit
        $form_cost_price[$i][] =& $form->createElement(
            "text","i","",
            "size=\"11\" maxLength=\"9\"
            class=\"money\"
			$mult_js
            style=\"text-align: right; $style $g_form_style $font_color\"
            $type"
        );
        $form_cost_price[$i][] =& $form->createElement("static","","",".");
        $form_cost_price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\" 
			$mult_js
            style=\"text-align: left; $style $g_form_style $font_color\"
            $type"
        );
        $form->addGroup( $form_cost_price[$i], "form_cost_price[$i]", "");

        //������� total cost
        $form->addElement(
            "text","form_cost_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );
        
		//���ñ�� sales per unit
        $form_sale_price[$i][] =& $form->createElement(
            "text","i","",
            "size=\"11\" maxLength=\"9\"
            class=\"money\"
			$mult_js
            style=\"text-align: right; $style $g_form_style $font_color\"
            $type"
        );
        $form_sale_price[$i][] =& $form->createElement("static","","",".");
        $form_sale_price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\" 
			$mult_js
            style=\"text-align: left; $style $g_form_style $font_color\"
            $type"
        );
        $form->addGroup( $form_sale_price[$i], "form_sale_price[$i]", "");

        //����� total sales
        $form->addElement(
            "text","form_sale_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );


		//rev.1.2�ʽвٲ����ʬǼ���вٲ�����вٿ��� (number of shipment, number of shipment when it is a batch shipment, number of shipped products
		//JavaScript�����ϲ��̡���ǧ���̤��ڤ��ؤ��� change the input screen and confirmation screen with JS
		if($type != "readonly"){
        	$form_fd_focus = "onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','y','m','d','form_ord_day','y','m','d')\"";
			$form_fn_option = $g_form_option;
		}else{
			$form_fd_focus = $type;
			$form_fn_option = "";
		}

		//�вٲ�� number of shipment
		//��ǧ���̤Ǥ�hidden�ܥƥ����ȥե�����ˤ��� make it hidden+text form in confirmation screen
		if($type != "readonly"){
			$form->addElement(
					'select', 'form_forward_times['.$i.']', "�вٲ��", $select_page_arr,
					"onChange=\"javascript:Button_Submit('forward_num_flg','#','true', this)\" style=\"$font_color\""
					);
		}else{
			$form->addElement("hidden","form_forward_times[$i]");
	        $form->addElement('text', 'form_forward_times_text['.$i.']', "�вٲ��", "size=\"3\" style=\"text-align: right; $style $g_form_style; $font_color\" $type");
		}

		//ʬǼ���в�ͽ���� scheduled deliver date for batch shipment
        $form_forward_day = "";
        $form_forward_day[] =& $form->createElement(
                "text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$style $g_form_style; $font_color\"
                onkeyup=\"changeText(this.form,'form_forward_day[$i][0][y]','form_forward_day[$i][0][m]',4)\"
                $form_fd_focus
                onBlur=\"blurForm(this)\"
				"
                );
        $form_forward_day[] =& $form->createElement(
                "text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$style $g_form_style; $font_color\"
                onkeyup=\"changeText(this.form,'form_forward_day[$i][0][m]','form_forward_day[$i][0][d]',2)\"
                $form_fd_focus
                onBlur=\"blurForm(this)\"
				"
                );
        $form_forward_day[] =& $form->createElement(
                "text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$style $g_form_style; $font_color\"
                $form_fd_focus
                onBlur=\"blurForm(this)\"
				"
                );
        $form->addGroup( $form_forward_day,"form_forward_day[".$i."][0]","form_forward_day","-");

        //�вٿ� number of shipping products
        $form->addElement(
                "text","form_forward_num[".$i."][0]","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\"
            	onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"
                style=\"$font_color $g_form_style;text-align: right; $style \"
                \".$form_fn_option.\"
				$type"
                );

		//�вٲ�����ѹ�������� when the number of shipment has been edited
        if($_POST["forward_num_flg"] == true){
            $forward_number = $_POST["form_forward_times"][$i];
            for($j=1;$j<=$forward_number;$j++){
                //�в�ͽ���� scheduled shipment date
                $form_forward_day = "";
                $form_fd_focus = ($type != "readonly") ? "onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][$j]','y','m','d','form_ord_day','y','m','d')\"" : "";
                $form_forward_day[] =& $form->createElement(
                        "text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$font_color $style $g_form_style\"
                        onkeyup=\"changeText(this.form,'form_forward_day[$i][$j][y]','form_forward_day[$i][$j][m]',4)\"
						$form_fd_focus
                        onBlur=\"blurForm(this)\"
						"
                        );
                $form_forward_day[] =& $form->createElement(
                        "text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$font_color $style $g_form_style\"
                        onkeyup=\"changeText(this.form,'form_forward_day[$i][$j][m]','form_forward_day[$i][$j][d]',2)\"
						$form_fd_focus
                        onBlur=\"blurForm(this)\"
						"
                        );
                $form_forward_day[] =& $form->createElement(
                        "text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$font_color $style $g_form_style\"
						$form_fd_focus
                        onBlur=\"blurForm(this)\"
						"
                        );
                $form->addGroup( $form_forward_day,"form_forward_day[".$i."][".$j."]","form_forward_day","-");

                //�вٿ� number of shipping products
                $form->addElement(
                        "text","form_forward_num[".$i."][".$j."]","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\"
            			onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"
                        style=\"$g_form_style;text-align: right; $style $font_color\"
                        \".$form_fn_option.\"
						$type"
                );
            }
        }



		//��Ͽ��ǧ���̤ξ�����ɽ�� do not diplay if it is a registration confirmation screen.
/*************************************************************
		if($comp_flg != true && $check_flg != true){
**************************************************************/
		if($comp_flg != true){

	        //������� search link
	        $form->addElement(
	            "link","form_search[$i]","","#","����",
	            "TABINDEX=-1 onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,5,$client_id,$i,$row_num);\""
	        );

	        //������ deletion link
	        //�ǽ��Ԥ��������硢���������κǽ��Ԥ˹�碌�� if the last row will be deleted, then match it with the new last row
	        if($row_num == $max_row-$del_num){
	            $form->addElement(
	                "link","form_del_row[$i]","",
	                "#","<font color='#FEFEFE'>���</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1. this);return false;\""
	            );
	        //�ǽ��԰ʳ����������硢�������Ԥ�Ʊ��NO�ιԤ˹�碌�� if rows other than the last row will be deleted, match with the same row number being deleted
	        }else{
	            $form->addElement(
	                "link","form_del_row[$i]","",
	                "#","<font color='#FEFEFE'>���</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num, this);return false;\""
	            );
	        }
		}

		//����ID product ID
        $form->addElement("hidden","hdn_goods_id[$i]");
        //���Ƕ�ʬ tax class
        $form->addElement("hidden", "hdn_tax_div[$i]");
		//��̾�ѹ��ե饰 edit product name flag
        $form->addElement("hidden","hdn_name_change[$i]");
		//�߸˴��� inventory control
        $form->addElement("hidden","hdn_stock_manage[$i]");
		//��ê�� actual shelf number
		$form->addElement("hidden","hdn_stock_num[$i]");
		//rev.1.2 �Ͱ�Ƚ��ե饰 discounted decision flag
        #2009-09-26 hashimoto-y
		#$form->addElement("hidden","hdn_discount_flg[$i]");


        /****************************/
        //ɽ����HTML���� create an HTML for display
        /****************************/
        $html .= "<tr class=\"Result1\">";
        $html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
/***************************************************************
		if($warning == null && $comp_flg != true && $check_flg != true){
****************************************************************/
		if($warning == null && $comp_flg != true){
        	$html .=    "��";
        	$html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
        	$html .=    "��";
		}
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
		// rev.1.2 �ѹ����� edit screen
		if($edit_flg == "true"){
	        $html .=    "<td align=\"right\">";
    	    $html .=        $form->_elements[$form->_elementIndex["form_sale_num[$i]"]]->toHtml();
        	$html .=    "</td>";
		}
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

		//rev.1.2 ʬǼ���ʽвٲ����ʬǼ���вٲ�����вٿ���when batch shipment (number of shipment, number of shipment when it's a batch delivery, number of shipping prod)
		if($edit_flg != "true"){
	        $html .=    "<td align=\"center\">";
    	    $html .=        $form->_elements[$form->_elementIndex["form_forward_times[$i]"]]->toHtml();
			if($type == "readonly"){
    	    	$html .=        $form->_elements[$form->_elementIndex["form_forward_times_text[$i]"]]->toHtml();
			}
        	$html .=    "</td>\n";
	        $html .=    "<td align=\"center\">";
			for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){
        		$html .=        $form->_elements[$form->_elementIndex["form_forward_day[$i][$j]"]]->toHtml();
				$html .= "<br>\n";
			}
    	    $html .=    "</td>\n";
        	$html .=    "<td align=\"center\">";
			for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){
    	    	$html .=        $form->_elements[$form->_elementIndex["form_forward_num[$i][$j]"]]->toHtml();
				$html .= "<br>\n";
			}
		}
        $html .=    "</td>\n";

/*****************************************************************
		if($warning == null && $comp_flg != true && $check_flg != true){
******************************************************************/
		if($warning == null && $comp_flg != true){
        	$html .= "  <td class=\"Title_Add\" align=\"center\">";
        	$html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
        	$html .= "  </td>";
		}
        $html .= "</tr>";

        //���ֹ��ܣ� +1 to row number
        $row_num = $row_num+1;
    }
}

//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ� do not show the buttons below in the registration confirmation screen
/****************************************************************
if($comp_flg != true && $check_flg != true){
****************************************************************/
if($comp_flg != true){

    //button
    $form->addElement("submit","order","�����ǧ���̤�", $disabled);
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"javascript:history.back()\"");

    //��� total
	$form->addElement("button","form_sum_button","�硡��","onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true', this)\"");

	//���ɲåܥ��� add row button
	$form->addElement("button","add_row_link","���ɲ�","onClick=\"javascript:Button_Submit('add_row_flg', '#foot', 'true', this)\"");

}else{
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ�� show the buttons below in the registration confirmation screen
    //��� back
    $form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    
	//�����å���λ�ܥ��� check done button
	$form->addElement("button","complete","�����å���λ","onClick=\"return Dialogue_2('�����å���λ���ޤ���','".HEAD_DIR."sale/1-2-101.php?aord_id=".$aord_id."','true','complete_flg', this);\" $disabled");

    //OK
    $form->addElement("submit","comp_button","����OK", $disabled);
    
    $form->freeze();
}


//rev.1.2 �вٿ���� * ñ���� JavaScript JS for number of shipped product * price per unit
$java_sheet = <<< JS

function Mult_double_h_aord_off(goods_id,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,forward_times,forward_num,coax){

    var GI  = goods_id;

    var PI  = s_price_i;
    var PD  = s_price_d;
    var SA  = sale_amount;

    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var SA2 = cost_amount;

    var FT  = forward_times;
    var FN  = forward_num;

    //hidden�ξ���ID�����뤫 is there a product ID hidden
    if(document.dateForm.elements[GI].value != ""){

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ� if not number dont processs
        var str  = document.dateForm.elements[PI].value;
        var str2 = document.dateForm.elements[PD].value;
        if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){

            //�вٿ����� total the shipped no of product
            times = document.dateForm.elements[FT].value
            forward_sum = 0;
            for(var i=0; i<=times; i++){
                forward_sum += (document.dateForm.elements[FN+"["+i+"]"].value - 0);
            }

            //�׻��� computation 1
            document.dateForm.elements[SA].value = forward_sum * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));

            //�ڼΤƤξ�� when rounding down
            if(coax == '1'){
                document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
            //�ͼθ����ξ�� when rounding up/down
            }else if(coax == '2'){
                document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
            //�ھ夲�ξ�� when rounding up
            }else if(coax == '3'){
                document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
            }

            //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤� return blank if its not a number or if the number is a decimal
            var str = forward_sum + "";
            if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                document.dateForm.elements[SA].value = "";
            }
            document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
            document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
        }else{
            document.dateForm.elements[SA].value = "";
        }

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ� dont process if not number
        var str  = document.dateForm.elements[PI2].value;
        var str2 = document.dateForm.elements[PD2].value;
        if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){
            //�׻��� computation 2 
            document.dateForm.elements[SA2].value = forward_sum * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));

            //�ڼΤƤξ�� when rounding off
            if(coax == '1'){
                document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
            //�ͼθ����ξ�� when roundung up or down
            }else if(coax == '2'){
                document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
            //�ھ夲�ξ�� when rounding up
            }else if(coax == '3'){
                document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
            }

            //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤� return blank if its not a number or if the number is a decimal
            var str = forward_sum + "";
            if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1){
                document.dateForm.elements[SA2].value = "";
            }

            document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
            document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
        }else{
            document.dateForm.elements[SA2].value = "";
        }
        return true;
    }else{
        return false;
    }
}

JS;


//print_array($_POST);
/****************************/
//HTML�إå� header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� footer
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

//form��Ϣ���ѿ���assign assign form related variable
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assign other variables
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'warning'       => "$warning",
	'html'          => "$html",
	'aord_id'       => "$aord_id",
    'duplicate_err' => "$error",
	'form_potision' => "$form_potision",
	'comp_flg'      => "$comp_flg",
	'check_flg'     => "$check_flg",
    'auth_r_msg'    => "$auth_r_msg",

	'edit_flg'      => "$edit_flg",
    'forward_day_err'   => "$forward_day_err",
    'forward_num_err'   => "$forward_num_err",
	'html_js'       => "$java_sheet",

));

$smarty->assign('goods_error0',$goods_error0);
$smarty->assign('goods_error1',$goods_error1);
$smarty->assign('goods_error2',$goods_error2);
$smarty->assign('goods_error3',$goods_error3);
$smarty->assign('goods_error4',$goods_error4);
$smarty->assign('goods_error5',$goods_error5);
$smarty->assign('duplicate_goods_err', $duplicate_goods_err);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
