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
 */
$page_title = "��������(���ե饤��)";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//$form =& new HTML_QuickForm("dateForm", "POST", "#");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("aord");
}


/****************************/
//�����ѿ�����
/****************************/
$shop_id     = $_SESSION["client_id"];
$rank_cd     = $_SESSION["rank_cd"];
$o_staff_id  = $_SESSION["staff_id"];
$aord_id     = $_GET["aord_id"];
//$check_flg   = $_GET["check_flg"];      //����Ȳ�Ƚ��ե饰
$rental_flg  = $_POST["rental_flg"];    //��󥿥���������ե饰

//����ID��hidden�ˤ���ݻ�����
Get_Id_Check3($_GET["aord_id"]);
if($_GET["aord_id"] != NULL){
	$set_id_data["hdn_aord_id"] = $aord_id;
	$form->setConstants($set_id_data);
}else{
	$aord_id = $_POST["hdn_aord_id"];
}

//����Ȳ�Ƚ��ե饰��hidden�ˤ���ݻ�����

/**********************************************************

if($_GET["check_flg"] != NULL){
	$set_flg_data["hdn_check_flg"] = $check_flg;
	$form->setConstants($set_flg_data);
}else{
	$check_flg = $_POST["hdn_check_flg"];
}

***********************************************************/

//�����褬���ꤵ��Ƥ��뤫
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

//�����ޤ���ͤ����
$hdn_name_change = $_POST["hdn_name_change"];
$hdn_stock_manage = $_POST["hdn_stock_manage"];

/****************************/
//�������
/****************************/

#2009-12-21 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($shop_id);

//�ѹ�����Ƚ��
if($aord_id != NULL && $client_id == NULL && $_POST[complete_flg] != true){

	//����إå�����SQL
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

	//rev.1.3 ľ����ƥ����Ȳ�
	$sql .= ",";
	$sql .= "    t_direct.direct_cd, ";			//ľ����CD
	$sql .= "    t_aorder_h.direct_cname, ";	//ľ����ά��
	$sql .= "    t_direct_claim.client_cname AS direct_claim ";	//ľ����������


	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	//$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

	//rev.1.3 ľ����ƥ����Ȳ�
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
	//GET�ǡ���Ƚ��
	Get_Id_Check($result);
	$h_data_list = Get_Data($result,2);

	//����ǡ�������SQL
	$sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    //$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";		//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "   t_aorder_d.goods_cd,\n";
//    $sql .= "   t_aorder_d.goods_name,\n";
    $sql .= "   t_aorder_d.official_goods_name,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS rack_num,";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       WHEN 1 THEN COALESCE(t_stock_io.order_num,0)\n";
    $sql .= "   END AS on_order_num,";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
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
    //$sql .= "       t_stock.shop_id =  ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock.shop_id =  ".$shop_id."\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_aorder_d.goods_id = t_stock.goods_id";

    $sql .= "       LEFT JOIN\n";

    //ȯ��Ŀ�
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

    //������
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

	$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";    //rev.1.3 ����åפ��Ȥ˺߸˴����ե饰

    $sql .= " WHERE \n";
    $sql .= "       t_aorder_d.aord_id = $aord_id \n";
    $sql .= "       AND \n";
    $sql .= "       t_aorder_h.shop_id = $shop_id \n";

	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "       AND \n";
    $sql .= "       t_goods_info.shop_id = $shop_id \n";

	$sql .= " ORDER BY t_aorder_d.line;";

    $result = Db_Query($db_con, $sql);
	$data_list = Get_Data($result,2);

	//������ξ�������
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
	//�ե�������ͤ�����
	/****************************/
	$sale_money = NULL;                        //���ʤ������
    $tax_div    = NULL;                        //���Ƕ�ʬ

	//�إå�������
	$update_goods_data["form_order_no"]                = $h_data_list[0][0];  //�����ֹ�

	//��������ǯ������ʬ����
	$ex_ord_day = explode('-',$h_data_list[0][1]);
	$update_goods_data["form_ord_day"]["y"]            = $ex_ord_day[0];   //������
	$update_goods_data["form_ord_day"]["m"]            = $ex_ord_day[1];   
	$update_goods_data["form_ord_day"]["d"]            = $ex_ord_day[2];   

	//��˾Ǽ����ǯ������ʬ����
	$ex_hope_day = explode('-',$h_data_list[0][2]);
	$update_goods_data["form_hope_day"]["y"]           = $ex_hope_day[0];  //��˾Ǽ��
	$update_goods_data["form_hope_day"]["m"]           = $ex_hope_day[1];   
	$update_goods_data["form_hope_day"]["d"]           = $ex_hope_day[2];   

	//����ͽ������ǯ������ʬ����
	$ex_arr_day = explode('-',$h_data_list[0][3]);
	$update_goods_data["form_arr_day"]["y"]            = $ex_arr_day[0];   //����ͽ����
	$update_goods_data["form_arr_day"]["m"]            = $ex_arr_day[1];   
	$update_goods_data["form_arr_day"]["d"]            = $ex_arr_day[2];   

	//�����å����դ��뤫Ƚ��
    if($h_data_list[0][4]=='t'){
        $update_goods_data["form_trans_check"]         = $h_data_list[0][4];  //���꡼�����
    }

	$update_goods_data["form_trans_select"]            = $h_data_list[0][5];  //�����ȼ�
	$update_goods_data["form_client"]["cd1"]           = $h_data_list[0][7];  //�����襳���ɣ�
	$update_goods_data["form_client"]["cd2"]           = $h_data_list[0][8];  //�����襳���ɣ�
	$update_goods_data["form_client"]["name"]          = $h_data_list[0][9];  //������̾
	$update_goods_data["form_direct_select"]           = $h_data_list[0][10]; //ľ����
	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
	$update_goods_data["form_direct_text"]["cd"]       = $h_data_list[0][16]; //ľ����CD
	$update_goods_data["form_direct_text"]["name"]     = $h_data_list[0][17]; //ľ����ά��
	$update_goods_data["form_direct_text"]["claim"]    = $h_data_list[0][18]; //ľ����������

	$update_goods_data["form_ware_select"]             = $h_data_list[0][11]; //�Ҹ�
	$update_goods_data["trade_aord_select"]            = $h_data_list[0][12]; //�����ʬ
	$update_goods_data["form_staff_select"]            = $h_data_list[0][13]; //ô����
	$update_goods_data["form_note_client"]             = $h_data_list[0][14]; //�̿�����������
	$update_goods_data["form_note_head"]               = $h_data_list[0][15]; //�̿����������

	//�ǡ�������
	for($i=0;$i<count($data_list);$i++){
	    $update_goods_data["hdn_goods_id"][$i]         = $data_list[$i][0];   //����ID
		$hdn_goods_id[$i]                              = $data_list[$i][0];   //POST�������˾���ID����߸˿��ǻ��Ѥ����

		$update_goods_data["hdn_name_change"][$i]      = $data_list[$i][1];   //��̾�ѹ��ե饰
		$hdn_name_change[$i]                           = $data_list[$i][1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���

		$update_goods_data["hdn_stock_manage"][$i]     = $data_list[$i][2];   //�߸˴���
		$hdn_stock_manage[$i]                          = $data_list[$i][2];   //POST�������˼�ê���κ߸˴���Ƚ���Ԥʤ���

		$update_goods_data["form_goods_cd"][$i]        = $data_list[$i][3];   //����CD
		$update_goods_data["form_goods_name"][$i]      = $data_list[$i][4];   //����̾

		$update_goods_data["form_stock_num"][$i]       = number_format($data_list[$i][5]);   //��ê��
		$update_goods_data["hdn_stock_num"][$i]        = number_format($data_list[$i][5]);   //��ê����hidden��
		$stock_num[$i]                                 = number_format($data_list[$i][5]);   //��ê��(��󥯤���)

        if($hdn_stock_manage[$i] != 2){
		    $update_goods_data["form_rorder_num"][$i]      = $data_list[$i][6];   //ȯ��ѿ�
		    $update_goods_data["form_rstock_num"][$i]      = $data_list[$i][7];   //������
		    $update_goods_data["form_designated_num"][$i]  = $data_list[$i][8];   //�вٲ�ǽ��
        }
		$update_goods_data["form_sale_num"][$i]        = $data_list[$i][9];   //�����
		$update_goods_data["hdn_tax_div"][$i]          = $data_list[$i][10];  //���Ƕ�ʬ

	    //����ñ�����������Ⱦ�������ʬ����
        $cost_price = explode('.', $data_list[$i][11]);
		$update_goods_data["form_cost_price"][$i]["i"] = $cost_price[0];  //����ñ��
		$update_goods_data["form_cost_price"][$i]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     
		$update_goods_data["form_cost_amount"][$i]     = number_format($data_list[$i][13]);  //�������

		//���ñ�����������Ⱦ�������ʬ����
        $sale_price = explode('.', $data_list[$i][12]);
		$update_goods_data["form_sale_price"][$i]["i"] = $sale_price[0];  //���ñ��
		$update_goods_data["form_sale_price"][$i]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';
		$update_goods_data["form_sale_amount"][$i]     = number_format($data_list[$i][14]);  //�����

		$sale_money[]                                  = $data_list[$i][14];  //����۹��
        $tax_div[]                                     = $data_list[$i][10];  //���Ƕ�ʬ

        #2009-09-29 hashimoto-y
        $update_goods_data["hdn_discount_flg"][$i]     = $data_list[$i][15];  //�Ͱ����ե饰
    }

	//�������������
	$client_id      = $client_list[0][0];        //������ID
	$coax           = $client_list[0][1];        //�ݤ��ʬ�ʶ�ۡ�
    $tax_franct     = $client_list[0][2];        //ü����ʬ�ʾ����ǡ�
//    $attach_gid     = $client_list[0][3];        //��°���롼��
	$warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
//    $update_goods_data["attach_gid"]          = $attach_gid;

	//���ߤξ�����Ψ
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

	//�ե�������ͥ��å�
	$update_goods_data["form_sale_total"]      = $sale_money;
	$update_goods_data["form_sale_tax"]        = $tax_money;
	$update_goods_data["form_sale_money"]      = $st_money;
	$update_goods_data["sum_button_flg"]       = "";
	$update_goods_data["form_designated_date"] = 7; //�вٲ�ǽ��

    $form->setConstants($update_goods_data);

	//ɽ���Կ�
	if($_POST["max_row"] != NULL){
	    $max_row = $_POST["max_row"];
	}else{
		//����ǡ����ο�
	    $max_row = count($data_list);
	}

	//rev.1.2 �̾索�ե饤������ѹ�Ƚ��ե饰
	$edit_flg = "true";

}else{
	//��ư���֤μ����ֹ����
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

	//�вٲ�ǽ��
	$def_data["form_designated_date"] = 7;
	//ô����
	$def_data["form_staff_select"] = $o_staff_id;
	//�����ʬ
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

	//ɽ���Կ�
	if($_POST["max_row"] != NULL){
	    $max_row = $_POST["max_row"];
	}else{
	    $max_row = 5;
	}

	//rev.1.2 �̾索�ե饤������ѹ�Ƚ��ե饰
	$edit_flg = $_POST["hdn_edit_flg"];

}

//rev.1.2 �̾索�ե饤������ѹ�Ƚ��ե饰��hidden�˥��å�
$form->setConstants(array("hdn_edit_flg" => $edit_flg));

//���ɽ�������ѹ�
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//����Կ�
$del_history[] = NULL; 
/****************************/
//�Կ��ɲý���
/****************************/
if($_POST["add_row_flg"]==true){
/*
	if($_POST["max_row"] == NULL){
		//����ͤ�POST��̵���١�
		$max_row = 5;
	}else{
*/
		//����Ԥˡ��ܣ�����
    	$max_row = $_POST["max_row"]+5;
//	}

    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}
/****************************/
//�Ժ������
/****************************/
if($_POST["del_row"] != ""){

    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);
    //��������Կ�
    $del_num     = count($del_history)-1;
}

//***************************/
//����Կ���hidden�˥��å�
/****************************/
$max_row_data["max_row"] = $max_row;

$form->setConstants($max_row_data);

//***************************/
//���꡼���������å�����
/****************************/
//�����å��ξ��ϡ������ȼԤΥץ��������ͤ��ѹ�����
if($_POST["trans_check_flg"] == true){
	$where  = " WHERE ";
	$where .= "    shop_id = $shop_id";
	$where .= " AND";
	$where .= "    green_trans = 't'";

	//�����
    $trans_data["trans_check_flg"]   = "";
	$form->setConstants($trans_data);
}else{
	$where = "";
}

/****************************/
//���ʺ���
/****************************/

//�����ֹ�
$form->addElement(
    "text","form_order_no","",
    "style=\"color : #585858; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//�вٲ�ǽ��
$form->addElement(
    "text","form_designated_date","",
    "size=\"4\" maxLength=\"4\" 
    $g_form_option 
    style=\"text-align: right;$g_form_style\"
    onChange=\"javascript:Button_Submit('recomp_flg','#','true')\"
    "
);

//������
$form_ord_day[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ord_day[y]','form_ord_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ord_day[m]','form_ord_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_ord_day,"form_ord_day","form_ord_day");

//��˾Ǽ��
$form_hope_day[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hope_day[y]','form_hope_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form_hope_day[] =& $form->createElement("static","","","-");
$form_hope_day[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hope_day[m]','form_hope_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form_hope_day[] =& $form->createElement("static","","","-");
$form_hope_day[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_hope_day,"form_hope_day","form_hope_day");

//����ͽ����
$form_arr_day[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_arr_day[y]','form_arr_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form_arr_day[] =& $form->createElement("static","","","-");
$form_arr_day[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_arr_day[m]','form_arr_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form_arr_day[] =& $form->createElement("static","","","-");
$form_arr_day[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_arr_day,"form_arr_day","form_arr_day");

//�����襳����
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
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onChange=\"javascript:Button_Submit('client_search_flg','#','true')\"".$g_form_option."\""
        );
if($_GET[aord_id] != null){
    $freeze->freeze();
}
$form_client[] =& $form->createElement("text","name","�ƥ����ȥե�����","size=\"34\" $g_text_readonly");
$form->addGroup( $form_client, "form_client", "");

//����۹��
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"$g_form_style;color : #585858; 
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
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//�̿���������谸��
$form->addElement("textarea","form_note_client","�ƥ����ȥե�����",' rows="2" cols="75" onFocus="onForm(this)" onBlur="blurForm(this)"');
//�̿������������
$form->addElement("textarea","form_note_head","�ƥ����ȥե�����",' rows="2" cols="75" onFocus="onForm(this)" onBlur="blurForm(this)"');

//���꡼�����
$form->addElement('checkbox', 'form_trans_check', '���꡼�����', '<b>���꡼�����</b>��',"onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");
//�����ȼ�
$select_value = Select_Get($db_con,'trans',$where);
$form->addElement('select', 'form_trans_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ľ����
//$select_value = Select_Get($db_con,'direct');
//$form->addElement('select', 'form_direct_select', '���쥯�ȥܥå���', $select_value,"class=\"Tohaba\"".$g_form_option_select);
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

//�Ҹ�
$select_value = Select_Get($db_con,'ware');
$form->addElement('select', 'form_ware_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//�����ʬ
$select_value = Select_Get($db_con,'trade_aord');
$form->addElement('select', 'trade_aord_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//ô����
$select_value = Select_Get($db_con,'staff',null,true);
$form->addElement('select', 'form_staff_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//����
//$form->addElement("submit","order","������","onClick=\"javascript:Dialogue('�����ޤ���','#')\"");
//1.0.4 (2006/03/29) kaji ��ǧ���������Υ���󥻥�ܥ��󲡲����Ǥ���Ͽ����Ƥ��ޤ��Х��к�

//�����å���λ
//$form->addElement("button","complete","�����å���λ","onClick=\"javascript:Dialogue_2('�����å���λ���ޤ���','".HEAD_DIR."sale/1-2-101.php?aord_id=".$aord_id."','true','complete_flg')\"");
//1.0.4 (2006/03/29) kaji ��ǧ���������Υ���󥻥�ܥ��󲡲����Ǥ���Ͽ����Ƥ��ޤ��Х��к�


// �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => "./1-2-105.php", "������" => $_SERVER["PHP_SELF"], "����İ���" => "./1-2-106.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

//hidden
$form->addElement("hidden", "hdn_client_id");       //������ID
$form->addElement("hidden", "hdn_aord_id");         //����ID
//$form->addElement("hidden", "attach_gid");          //��°���롼��ID
$form->addElement("hidden", "client_search_flg");   //�����襳�������ϥե饰
$form->addElement("hidden", "hdn_coax");            //�ݤ��ʬ
$form->addElement("hidden", "hdn_tax_franct");      //ü����ʬ
$form->addElement("hidden", "del_row");             //�����
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰
$form->addElement("hidden", "max_row");             //����Կ�
$form->addElement("hidden", "goods_search_row");    //���ʥ��������Ϲ�
$form->addElement("hidden", "sum_button_flg");      //��ץܥ��󲡲��ե饰
$form->addElement("hidden", "complete_flg");        //�����å���λ�ܥ��󲡲��ե饰
$form->addElement("hidden", "trans_check_flg");     //���꡼���������å��ե饰
$form->addElement("hidden", "recomp_flg");          //�вٲ�ǽ���ե饰
$form->addElement("hidden", "hdn_check_flg");         //����Ȳ�Ƚ��ե饰
$form->addElement("hidden", "forward_num_flg");		//�вٲ������ե饰 rev.1.2
$form->addElement("hidden", "hdn_edit_flg");		//�̾索�ե饤������ѹ�Ƚ��ե饰 rev.1.2
$form->addElement("hidden", "hdn_direct_search_flg");	//ľ���襳�������ϥե饰 rev.1.3
$form->addElement("hidden", "form_direct_select");	//ľ����ID rev.1.3

#2009-09-26 hashimoto-y
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $form->addElement("hidden","hdn_discount_flg[$i]");
    }
}

/****************************/
//�����襳�������Ͻ���
/****************************/
if($_POST["client_search_flg"] == true){

    $client_cd1         = $_POST["form_client"]["cd1"];       //�����襳����1
	$client_cd2         = $_POST["form_client"]["cd2"];       //�����襳����2

    //������ξ�������
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

	//�����ǡ���������
	if($num == 1){
		$client_id      = pg_fetch_result($result, 0,0);        //������ID
//        $attach_gid     = pg_fetch_result($result, 0,0);        //��°���롼��ID
        $client_name    = pg_fetch_result($result, 0,1);        //������̾
        $coax           = pg_fetch_result($result, 0,2);        //�ݤ��ʬ�ʾ��ʡ�
        $tax_franct     = pg_fetch_result($result, 0,3);        //ü����ʬ�ʾ����ǡ�

        //���������ǡ�����ե�����˥��å�
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

	//��󥿥뤫�����ܤ��Ƥ������Ͻ�������ʤ�
	if($rental_flg == NULL){
		//�������Ϥ��줿�ͤ�����
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
			//rev.1.2 ʬǼ�б�ʬ���ɲ�
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

	//rev.1.2 ʬǼ�б��������ᡢ��󥿥�ο��̤�вٿ��������
	}else{
		for($i = 0; $i < $max_row; $i++){
			$client_data["form_forward_num"][$i][0] = $_POST["form_sale_num"][$i];

		}

	}

	$form->setConstants($client_data);

    //����Կ�
    unset($del_history);
    $del_history[] = NULL;
//}

/****************************/
//��ץܥ��󲡲�����
/****************************/
}elseif(($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["order"] == "�����ǧ���̤�" )&& $client_id != null){
	//����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];
    //������������ˤ��롣
    $del_history = explode(",", $del_row);

	$sale_data  = $_POST["form_sale_amount"];  //�����
	$sale_money = NULL;                        //���ʤ������
    $tax_div    = NULL;                        //���Ƕ�ʬ

	//����ۤι���ͷ׻�
    for($i=0;$i<$max_row;$i++){
		if($sale_data[$i] != "" && !in_array("$i", $del_history)){
			$sale_money[] = $sale_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
		}
    }
	
	//���ߤξ�����Ψ
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
		//���ɽ�������ѹ�
		$height = $max_row * 100;
		$form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";
	}

	//�ե�������ͥ��å�
	$money_data["form_sale_total"]   = $sale_money;
	$money_data["form_sale_tax"]     = $tax_money;
	$money_data["form_sale_money"]   = $st_money;
	$money_data["sum_button_flg"]    = "";
    $form->setConstants($money_data);
}

/****************************/
//�вٲ�ǽ������
/****************************/
if($_POST["recomp_flg"] == true){
    //�вٲ�ǽ��
    $designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;
    //�����ʳ������Ϥ���Ƥ�����
    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 0;
    }

//    $attach_gid   = $_POST["attach_gid"];     //������ν�°���롼��
	$ary_goods_id = $_POST["hdn_goods_id"];   //���Ϥ�������ID

	//���Ϥ��줿���ʤθĿ���Ʒ׻�����
	for($i = 0; $i < count($ary_goods_id); $i++){
		//����¸��Ƚ��
		if($ary_goods_id[$i] != NULL){
			//�Ʒ׻�SQL
			$sql  = "SELECT";
		    $sql .= "   t_goods.goods_id,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
			//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//            $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) ";
			$sql .= " END AS allowance_total,";
			//$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN";
			$sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
		    $sql .= "   COALESCE(t_stock.stock_num,0)"; 
		    $sql .= "   + COALESCE(t_stock_io.order_num,0)";
//		    $sql .= "   - (COALESCE(t_stock.rstock_num,0)";
		    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0) END AS stock_total ";
		    $sql .= " FROM";
		    $sql .= "   t_goods ";

			$sql .= "   INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
			$sql .= "   INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

		    $sql .= "   LEFT JOIN";

            //�߸˿�
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

            //ȯ��ѿ�
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

            //������
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

			$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰

		    $sql .= " WHERE ";
		    $sql .= "       t_goods.goods_id = $ary_goods_id[$i]";
		    $sql .= " AND ";
		    $sql .= "       t_goods.public_flg = 't' ";
		    $sql .= " AND ";
		    $sql .= "       initial_cost.rank_cd = '1' ";

			//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
		    $sql .= " AND ";
		    $sql .= "       t_goods_info.shop_id = $shop_id ";

		    $sql .= ";";

		    $result = Db_Query($db_con, $sql);

		    $goods_data = pg_fetch_array($result);

			$set_designated_data["hdn_goods_id"][$i]         = $goods_data[0];   //����ID
			$hdn_goods_id[$search_row]                       = $goods_data[0];   //POST�������˾���ID����߸˿��ǻ��Ѥ����
			$set_designated_data["form_stock_num"][$i]       = $goods_data[1];   //��ê��
			$set_designated_data["hdn_stock_num"][$i]        = $goods_data[1];   //��ê����hidden��
			$stock_num[$i]                                   = $goods_data[1];   //��ê��(��󥯤���)
			$set_designated_data["form_rorder_num"][$i]      = $goods_data[2];   //ȯ��ѿ�
			$set_designated_data["form_rstock_num"][$i]      = $goods_data[3];   //������
			$set_designated_data["form_designated_num"][$i]  = $goods_data[4];   //�вٲ�ǽ��
		}
	}

	//�вٲ�ǽ�����ϥե饰�˶���򥻥å�
    $set_designated_data["recomp_flg"] = "";
    $form->setConstants($set_designated_data);
}

/****************************/
//���ʥ���������
/****************************/
if($_POST["goods_search_row"] != null){

	//���ʥǡ�������������
    $search_row = $_POST["goods_search_row"];

	//�вٲ�ǽ������
	$designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;
    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 0;
    }

//   $attach_gid   = $_POST["attach_gid"];     //������ν�°���롼��
	$sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    //$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= "   t_goods.goods_cd,\n";
    //$sql .= "   t_goods.goods_name,\n";
    $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //����̾
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
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
	//rev.1.2 �Ͱ����ʥե饰
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

    //�߸˿�
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

    //ȯ��ѿ�
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

    //������
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

	//rev.1.3 ����åפ��Ȥ˺߸˴����ե饰
    $sql .= " AND \n";
    $sql .= "       t_goods_info.shop_id = $shop_id \n";

    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);
	//�ǡ�����¸�ߤ�����硢�ե�����˥ǡ�����ɽ��
	if($data_num == 1){
    	$goods_data = pg_fetch_array($result);

		$set_goods_data["hdn_goods_id"][$search_row]         = $goods_data[0];   //����ID
		$hdn_goods_id[$search_row]                           = $goods_data[0];   //POST�������˾���ID����߸˿��ǻ��Ѥ����

		$set_goods_data["hdn_name_change"][$search_row]      = $goods_data[1];   //��̾�ѹ��ե饰
		$hdn_name_change[$search_row]                        = $goods_data[1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���
		
		$set_goods_data["hdn_stock_manage"][$search_row]     = $goods_data[2];   //�߸˴���
		$hdn_stock_manage[$search_row]                       = $goods_data[2];   //POST�������˼�ê���κ߸˴���Ƚ���Ԥʤ���

		$set_goods_data["form_goods_cd"][$search_row]        = $goods_data[3];   //����CD
		$set_goods_data["form_goods_name"][$search_row]      = $goods_data[4];   //����̾

		$set_goods_data["form_stock_num"][$search_row]       = number_format($goods_data[5]);   //��ê��
		$set_goods_data["hdn_stock_num"][$search_row]        = number_format($goods_data[5]);   //��ê����hidden��
		$stock_num[$search_row]                              = number_format($goods_data[5]);   //��ê��(��󥯤���)

		$set_goods_data["form_rorder_num"][$search_row]      = $goods_data[6];   //ȯ��ѿ�
		$set_goods_data["form_rstock_num"][$search_row]      = $goods_data[7];   //������

		$set_goods_data["form_designated_num"][$search_row]  = $goods_data[8];   //�вٲ�ǽ��

		//����ñ�����������Ⱦ�������ʬ����
        $cost_price = explode('.', $goods_data[9]);
		$set_goods_data["form_cost_price"][$search_row]["i"] = $cost_price[0];  //����ñ��
		$set_goods_data["form_cost_price"][$search_row]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     

		//���ñ�����������Ⱦ�������ʬ����
        $sale_price = explode('.', $goods_data[10]);
		$set_goods_data["form_sale_price"][$search_row]["i"] = $sale_price[0];  //���ñ��
		$set_goods_data["form_sale_price"][$search_row]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';

		//rev.1.2 �вٿ��ȼ������Ƚ��ʶ�۷׻���
		$cost_amount = null;
		$sale_amount = null;
		//�ѹ��ϼ���������۷׻�
		if($edit_flg == "true"){
			if($_POST["form_sale_num"][$search_row] != null){
            	$cost_amount = bcmul($goods_data[9], $_POST["form_sale_num"][$search_row],2);
            	$sale_amount = bcmul($goods_data[10], $_POST["form_sale_num"][$search_row],2);
			}
		//������Ͽ����󥿥�Ͻвٿ��ι�פ����۷׻�
		}else{
			if(in_array(!"", $_POST["form_forward_num"][$search_row])){
	            $cost_amount = bcmul($goods_data[9], array_sum($_POST["form_forward_num"][$search_row]), 2);
            	$sale_amount = bcmul($goods_data[10], array_sum($_POST["form_forward_num"][$search_row]), 2);
			}
		}
		//����������Ϥ���Ƥ����ʾ�ν������̤ä��˾��ϡ��Ʒ׻�
		if($cost_amount != null && $sale_amount != null){
			//������۷׻�
            $cost_amount = Coax_Col($coax, $cost_amount);
			//����۷׻�
            $sale_amount = Coax_Col($coax, $sale_amount);
			$set_goods_data["form_cost_amount"][$search_row] = number_format($cost_amount);
			$set_goods_data["form_sale_amount"][$search_row] = number_format($sale_amount);
		}

		$set_goods_data["hdn_tax_div"][$search_row]          = $goods_data[11]; //���Ƕ�ʬ
		//rev.1.2 �Ͱ����ʥե饰
		$set_goods_data["hdn_discount_flg"][$search_row]     = $goods_data[12];
	}else{
		//�ǡ�����̵�����ϡ������
		$no_goods_flg                                        = true;     //�������뾦�ʤ�̵����Хǡ�����ɽ�����ʤ�
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
		$set_goods_data["hdn_discount_flg"][$search_row]     = "";	//rev.1.2 �Ͱ����ʥե饰
	}
	$set_goods_data["goods_search_row"]                  = "";
	$form->setConstants($set_goods_data);

	//���ɽ�������ѹ�
	$height = $search_row * 100;
	$form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";

}


//--------------------------//
// rev.1.3 ľ�������Ͻ���
//--------------------------//
//ľ���踡���ե饰��ture�ξ��
if($_POST["hdn_direct_search_flg"] == "true"){
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
        $set_data["form_direct_select"]         = $get_direct_data["direct_id"];    //ľ����ID
        $set_data["form_direct_text"]["name"]   = $get_direct_data["direct_cname"]; //ľ����̾ά��
        $set_data["form_direct_text"]["claim"]  = $get_direct_data["client_cname"]; //������

    //��������ǡ������ʤ��ä����ϡ��������ϥǡ��������ƽ����
    }else{
        $set_data = NULL;
        $set_data["form_direct_select"]         = "";   //ľ����ID
        $set_data["form_direct_text"]["cd"]     = "";   //ľ���襳����
        $set_data["form_direct_text"]["name"]   = "";   //ľ����̾ά��
        $set_data["form_direct_text"]["claim"]  = "";   //������
    }

    //ľ���踡���ե饰������
    $set_data["hdn_direct_search_flg"]          = "";

	$form->setConstants($set_data);

}


/****************************/
//���顼�����å�(addRule)
/****************************/
//������
//ɬ�ܥ����å�
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

//�вٲ�ǽ��
$form->addRule("form_designated_date","ȯ��ѿ��Ȱ��������θ����������Ⱦ�ѿ��ͤΤߤǤ���","regex", '/^[0-9]+$/');

//������
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
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

//��˾Ǽ��
//��Ⱦ�ѿ��������å�
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

//����ͽ����
//��Ⱦ�ѿ��������å�
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

//���꡼����ꤷ�����ϡ������ȼԤ�ɬ��
if($_POST["form_trans_check"] != NULL){
	//�����ȼ�
	//��ɬ�ܥ����å�
	$form->addRule('form_trans_select','�����ȼԤ����򤷤Ƥ���������','required');
}

//�в��Ҹ�
//��ɬ�ܥ����å�
$form->addRule("form_ware_select","�в��Ҹˤ����򤷤Ƥ���������","required");

//�����ʬ
//��ɬ�ܥ����å�
$form->addRule("trade_aord_select","�����ʬ�����򤷤Ƥ���������","required");

//ô����
//��ɬ�ܥ����å�
$form->addRule("form_staff_select","ô���Ԥ����򤷤Ƥ���������","required");


//�̿���������谸��
//��ʸ���������å�
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_client","�̿���������谸�ˤ�50ʸ������Ǥ���","mb_maxlength","50");


//�̿������������
//��ʸ���������å�
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_head","�̿�����������ˤ�50ʸ������Ǥ���","mb_maxlength","50");

/****************************/
//����ܥ��󲡲�����
/****************************/
if($_POST["order"] == "�����ǧ���̤�" || $_POST["comp_button"] == "����OK"){
	//�إå�������
	$ord_no               = $_POST["form_order_no"];           //�����ֹ�
	$designated_date      = $_POST["form_designated_date"];    //�вٲ�ǽ��
	$ord_day_y            = $_POST["form_ord_day"]["y"];       //������
	$ord_day_m            = $_POST["form_ord_day"]["m"];            
	$ord_day_d            = $_POST["form_ord_day"]["d"];            
	$hope_day_y           = $_POST["form_hope_day"]["y"];      //��˾Ǽ��
	$hope_day_m           = $_POST["form_hope_day"]["m"];           
	$hope_day_d           = $_POST["form_hope_day"]["d"];           
	$arr_day_y            = $_POST["form_arr_day"]["y"];       //����ͽ����
	$arr_day_m            = $_POST["form_arr_day"]["m"];            
	$arr_day_d            = $_POST["form_arr_day"]["d"];            
	$client_cd1           = $_POST["form_client"]["cd1"];      //������CD1
	$client_cd2           = $_POST["form_client"]["cd2"];      //������CD2
	$client_name          = $_POST["form_client"]["name"];     //������̾
	$note_client          = $_POST["form_note_client"];        //�̿�����������
	$note_head            = $_POST["form_note_head"];          //�̿����������
	$trans_check          = $_POST["form_trans_check"];        //���꡼�����
	$trans_id             = $_POST["form_trans_select"];       //�����ȼ�
	$direct_id            = $_POST["form_direct_select"];      //ľ����
	$ware_id              = $_POST["form_ware_select"];        //�Ҹ�
	$trade_aord           = $_POST["trade_aord_select"];       //�����ʬ
	$c_staff_id           = $_POST["form_staff_select"];	   //ô����

	/****************************/
    //���顼�����å�(PHP)
    /****************************/
	$error_flg = false;                                         //���顼Ƚ��ե饰

	//rev.1.2 ������Ͽ��ʬǼ���ˤ��ѹ�����ʬǼ�ˤ�Ƚ��ե饰��Row_Data_Check2�ؿ��ѡ�
	$check_type = ($edit_flg == "true") ? "aord" : "aord_offline";

    #2009-09-26 hashimoto-y
    $check_ary = array(
                    $_POST[hdn_goods_id],                           //����ID
                    $_POST[form_goods_cd],                          //���ʥ�����
                    $_POST[form_goods_name],                        //����̾
                    $_POST[form_sale_num],                          //�����
                    $_POST[form_cost_price],                        //����ñ��
                    $_POST[form_sale_price],                        //���ñ��
                    $_POST[form_cost_amount],                       //�������
                    $_POST[form_sale_amount],                       //�����
                    $_POST[hdn_tax_div],                            //���Ƕ�ʬ
                    $del_history,                                   //�������
                    $max_row,                                       //����Կ�
                    $check_type,                                    //��������ʬ rev.1.2
                    $db_con,                                        //DB���ͥ������
                    "",
                    "",
                    $_POST[hdn_discount_flg]                        //�Ͱ��ե饰
                );      

    $check_data = Row_Data_Check2($check_ary);

    //���顼�����ä����
    if($check_data[0] === true){

        //����̤���򥨥顼
        $goods_error0 = $check_data[1];

        //���ʥ���������
        $goods_error1 = $check_data[2];

        //�����������ñ�������ñ�����ϥ����å�
        $goods_error2 = $check_data[3];

        //�����Ⱦ�ѥ��顼
        $goods_error3 = $check_data[4];

        //����ñ��Ⱦ�ѥ��顼
        $goods_error4 = $check_data[5];

        //���ñ��Ⱦ�ѥ��顼
        $goods_error5 = $check_data[6];

        $error_flg = true;
    //���顼��̵���ä����
    }else{  
        $goods_id         = $check_data[1][goods_id];       //����ID
        $goods_cd         = $check_data[1][goods_cd];       //����̾
        $goods_name       = $check_data[1][goods_name];     //����̾
        $sale_num         = $check_data[1][sale_num];       //�����
        $c_price          = $check_data[1][cost_price];     //����ñ������������
		$s_price          = $check_data[1][sale_price];     //���ñ������������
        $tax_div          = $check_data[1][tax_div];        //���Ƕ�ʬ
        $cost_amount      = $check_data[1][cost_amount];    //�������
		$sale_amount      = $check_data[1][sale_amount];    //�����
        $def_line         = $check_data[1][def_line];       //���ֹ�
    }

    //���ʥ����å�
    //���ʽ�ʣ�����å�
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

	//��������
    //��ʸ��������å�
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

	//��˾Ǽ��
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

    //������ͽ����
    //��ʸ��������å�
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


	//rev.1.2 ���顼�����å��ʽвٲ����ʬǼ���в�ͽ�������вٿ���
	if($edit_flg != "true"){
	    //������˽в�ͽ�����˶�����Ĥξ��ϥǥե���Ȥ����դ����Ϥ���
    	for($i = 0; $i< $_POST["max_row"]; $i++){
			//����ID�Τʤ��Ԥϥ����å����ʤ�
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

    	    //���򤬤ҤĤξ��
        	if(count($null_row) == 1){
    	    	//�إå����νв�ͽ������������ʤ����
        		if($arr_day_y != null && $arr_day_m != null && $arr_day_d != null){
	            	$row = $null_row[0];
		            $_POST["form_forward_day"][$i][$row]["y"] = $arr_day_y;
    		        $_POST["form_forward_day"][$i][$row]["m"] = $arr_day_m;
        		    $_POST["form_forward_day"][$i][$row]["d"] = $arr_day_d;

				//�إå����ǡ����Ȥ�в�ͽ�����������ȥ��顼
				}else{
	        	    $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
    	        	$error_flg = true;
	    	        break;
				}

	        //������İʾ�ξ��
    	    }elseif(count($null_row) > 1){
        	    $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
            	$error_flg = true;
	            break;
    	    }
        	$null_row = null;
	    }

	    //���в�ͽ����
    	//���ʿ��ʼ���˥롼��
	    for($i=0;$i<$_POST["max_row"];$i++){
			//����ID�Τʤ��Ԥϥ����å����ʤ�
			if($_POST["hdn_goods_id"][$i] == ""){
				continue;
			}

	        //�вٲ����������ݻ�
    	    $array_count[$i] = $_POST["form_forward_times"][$i];
        	//�вٲ���롼��
	        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){

    	        //���դ�NULL�Ǥʤ����0���
        	    if($_POST["form_forward_day"][$i][$j]["y"] != NULL){
            	    $_POST["form_forward_day"][$i][$j]["y"] = str_pad($_POST["form_forward_day"][$i][$j]["y"], 4, 0, STR_PAD_LEFT);
	            }
    	        if($_POST["form_forward_day"][$i][$j]["m"] != NULL){
        	        $_POST["form_forward_day"][$i][$j]["m"] = str_pad($_POST["form_forward_day"][$i][$j]["m"], 2, 0, STR_PAD_LEFT);
            	}
	            if($_POST["form_forward_day"][$i][$j]["d"] != NULL){
    	            $_POST["form_forward_day"][$i][$j]["d"] = str_pad($_POST["form_forward_day"][$i][$j]["d"], 2, 0, STR_PAD_LEFT);
        	    }

	            //�в�ͽ���� ��$yy $mm $dd ��NULL�����å������դ����������ǧ���뤿��Ԥʤ�ʤ���
    	        $yy  = $_POST["form_forward_day"][$i][$j]["y"];
        	    $mm  = $_POST["form_forward_day"][$i][$j]["m"];
            	$dd  = $_POST["form_forward_day"][$i][$j]["d"];
	            $ymd = $yy.$mm.$dd;

    	        //�в�ͽ������NULL�Ǥʤ����
        	    if($ymd != NULL){

	                //���դ������ʾ��
    	            if(checkdate((int)$mm, (int)$dd, (int)$yy)){  //���㥹�Ȥ�0��NULL���Ѵ�

	                    //�в�ͽ������Ⱦ�ѿ����ǤϤʤ����
    	                if(!ereg("^[0-9]+$", $yy) || !ereg("^[0-9]+$", $mm) || !ereg("^[0-9]+$", $dd)){
        	                $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
            	            $error_flg = true;
                	    }

	                    //�в�ͽ��������ʣ������
    	                if($all_ymd_goods[$i][$ymd] == "1"){
        	                $forward_day_err = "Ʊ��ξ��ʤ�ʬǼ�в�ͽ��������ʣ���Ƥ��ޤ���";
            	            $error_flg = true;
                	    }else{
	                        $all_ymd_goods[$i][$ymd] = 1; //����($i)�νв����˥ե饰��Ω�Ƥ�
    	                }

        	            //�в�ͽ�����������������ξ��
            	        if($error_flg == true && $ymd < $aord_ymd){
                	        $forward_day_err = "ʬǼ�в�ͽ�����ϼ������ʹߤ����դ����ꤷ�Ʋ�������";
                    	    $error_flg = true;
	                    }

    	                $err_msge = Sys_Start_Date_Chk($yy, $mm, $dd, "ʬǼ�в�ͽ����");
        	            if($err_msge != null){
            	        $forward_day_err = $err_msge;
                	        $error_flg = true;
                    	}

	                //���դ������Ǥʤ����
    	            }else{
        	            $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
            	        $error_flg = true;
                	}
	            }

    	        //���вٿ������å�
        	    //��ɬ�ܥ����å�
            	if($_POST["form_forward_num"][$i][$j] == null || !ereg("^[0-9]+$", $_POST["form_forward_num"][$i][$j]) || $_POST["form_forward_num"][$i][$j] == 0){
                	$forward_num_err = "�вٿ���Ⱦ�ѿ��ͤΤߤǤ���";
	                $error_flg = true;
    	        }
        	}

			//�вٲ�����ǧ�����Ѥ�+1�����ͤ�ƥ����ȥܥå����������
			$form->setConstants(array("form_forward_times_text[$i]" => $_POST["form_forward_times"][$i] + 1));

		}
    }


	//���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
    if($form->validate() && $error_flg == false){

		//��ϿȽ��
		if($_POST["comp_button"] == "����OK"){
			//���ߤξ�����Ψ
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

			//���դη����ѹ�
			$ord_day  = $ord_day_y."-".$ord_day_m."-".$ord_day_d;
			if($hope_day_y != null){
				$hope_day = $hope_day_y."-".$hope_day_m."-".$hope_day_d;
			}
			if($arr_day_y != null){
				$arr_day  = $arr_day_y."-".$arr_day_m."-".$arr_day_d;
			}

			//rev.1.2 ��Ͽ���ѹ��ǽ�����ʬ����
			//�ѹ���
			if($edit_flg == "true"){

				$total_money = Total_Amount($cost_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
				$cost_money  = $total_money[0];
				$total_money = Total_Amount($sale_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
				$sale_money  = $total_money[0];
				$sale_tax    = $total_money[1];

			//������Ͽ��
			}else{

				//ʬǼ���Ͻв�ͽ�������Ȥ˼������Ͽ����
				//���ʿ��ʼ���˥롼��
				for($i=0;$i<$_POST["max_row"];$i++){
					//����ID�Τʤ��Ԥϥ����å����ʤ�
					if($_POST["hdn_goods_id"][$i] == ""){
						continue;
					}

					//�вٲ���롼��
					for($j=0; $j<=$_POST["form_forward_times"][$i]; $j++){
	                    //�в�ͽ����
    	                $f_yy  = $_POST["form_forward_day"][$i][$j]["y"];
        	            $f_mm  = $_POST["form_forward_day"][$i][$j]["m"];
            	        $f_dd  = $_POST["form_forward_day"][$i][$j]["d"];
                	    $f_ymd = $f_yy.$f_mm.$f_dd;
                    	$all_ymd[] = $f_yy.$f_mm.$f_dd; //���в�ͽ����

						//�ѿ�̾�ѹ�
	                    $goods_id     = $_POST["hdn_goods_id"][$i];				//����ID
    	                $forward_num  = $_POST["form_forward_num"][$i][$j];		//�вٿ�

	                    //������إå���
						$post_cost_price = $_POST["form_cost_price"][$i]["i"].".".$_POST["form_cost_price"][$i]["d"];
    	                $data_h[$f_ymd]["�������"][] = Coax_Col($coax, bcmul($post_cost_price, $forward_num, 1));	//�������(��ɼ�׻��Ф�����)
						$post_sale_price = $_POST["form_sale_price"][$i]["i"].".".$_POST["form_sale_price"][$i]["d"];
        	            $data_h[$f_ymd]["�����"][] = Coax_Col($coax, bcmul($post_sale_price, $forward_num, 1));	//�����(��ɼ�׻��Ф�����)
            	        $data_h[$f_ymd]["���Ƕ�ʬ"][] = $_POST["hdn_tax_div"][$i];

	                    //������ǡ�����
    	                $data_d[$f_ymd]["good_id"][]                   	 = $goods_id;                           		//����ID
        	            $data_d[$f_ymd]["line"][]                      	 = $i;                                 			//�Կ�
            	        $data_d[$f_ymd][$goods_id."-".$i]["goods_name"]	 = addslashes($_POST["form_goods_name"][$i]);	//����̾
                	    $data_d[$f_ymd][$goods_id."-".$i]["num"]       	 = $forward_num;                        		//�вٿ�
                    	$data_d[$f_ymd][$goods_id."-".$i]["cost_price"]  = $post_cost_price;               				//����ñ��
	                    $data_d[$f_ymd][$goods_id."-".$i]["sale_price"]  = $post_sale_price;							//���ñ��
    	                $data_d[$f_ymd][$goods_id."-".$i]["cost_amount"] = Coax_Col($coax, bcmul($post_cost_price, $forward_num, 1));	//������ۡʾ��ʹ�ס�
        	            $data_d[$f_ymd][$goods_id."-".$i]["sale_amount"] = Coax_Col($coax, bcmul($post_sale_price, $forward_num, 1));	//����ۡʾ��ʹ�ס�
            	        $data_d[$f_ymd][$goods_id."-".$i]["tax_div"]     = $_POST["hdn_tax_div"][$i];               	//���Ƕ�ʬ

					}
				}
			}

			//����إå�������ǡ�������Ͽ������SQL
			Db_Query($db_con, "BEGIN");

			//�ѹ�����Ƚ��
			if($aord_id != NULL){
                //�����ѹ����ˡ�����ǡ�����¸�ߤ�̵ͭ���ǧ����
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

				//����إå����ѹ�
				$sql  = "UPDATE t_aorder_h SET ";
				$sql .= "    ord_no = '$ord_no',";
				$sql .= "    ord_time = '$ord_day',";
				$sql .= "    client_id = $client_id,";
				//ľ���褬���ꤵ��Ƥ��뤫
				if($direct_id != null){
					$sql .= "    direct_id = $direct_id,";
				}else{
					$sql .= "    direct_id = NULL,";
				}
				$sql .= "    trade_id = '$trade_aord',";
				//�����ȼԤ����ꤵ��Ƥ��뤫
				if($trans_id != null){
					$sql .= "    trans_id = $trans_id,";
				}else{
					$sql .= "    trans_id = NULL,";
				}
				//�����å��ͤ�boolean���ѹ�
	            if($trans_check==1){
	                $sql .= "green_flg = true,";    
	            }else{
	                $sql .= "green_flg = false,";    
	            }
				//��˾Ǽ�������ꤵ��Ƥ��뤫
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

				//����ǡ�������
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

				//rev.1.2 ����ǡ�����Ͽ�Ѥ���ɼ�ֹ���ݻ�
				$array_ord_no[$ord_day] = $ord_no;	//��ʬǼ���Ͻв�ͽ������ɬ�ܤǤϤʤ��Τǡ����������������

			//������Ͽ
			}else{

				//rev.1.2 
				//�в�ͽ���������ʣ��������
	            $all_ymd_uniq = array_unique($all_ymd);
                asort($all_ymd_uniq);

	            //�в�ͽ����(��ʣ�����)�ο���������إå�����Ͽ����
    	        //while($fw_day = array_shift($all_ymd_uniq)){
				foreach($all_ymd_uniq as $fw_day){
        	        //��ɼ�ֹ�
            	    $order_no_pad = str_pad($ord_no, 8, 0, STR_PAD_LEFT);

	                //���������(�ǹ�)�����
    	            $cost_money = array_sum($data_h["$fw_day"]["�������"]); //DB�˥����ʤ�

        	        //�������(�ǹ�)������ס���ȴ�ˤȡ������Ǥ�ʬ����
            	    $total_amount = Total_Amount($data_h["$fw_day"]["�����"], $data_h["$fw_day"]["���Ƕ�ʬ"], $coax,$tax_franct,$tax_num, $client_id, $db_con);
	                $sale_money = $total_amount[0]; //�����
    	            $sale_tax = $total_amount[1]; //������


					//����إå�����Ͽ
					$sql  = "INSERT INTO t_aorder_h (";
					$sql .= "    aord_id,";
					$sql .= "    ord_no,";
					$sql .= "    ord_time,";
					$sql .= "    client_id,";
					//ľ���褬���ꤵ��Ƥ��뤫
					if($direct_id != null){
						$sql .= "    direct_id,";
					}
					$sql .= "    trade_id,";
					//�����ȼԤ����ꤵ��Ƥ��뤫
					if($trans_id != null){
						$sql .= "    trans_id,";
					}
					//���꡼����꤬���ꤵ��Ƥ��뤫
					if($trans_check != null){
						$sql .= "    green_flg,";
					}
					//��˾Ǽ�������ꤵ��Ƥ��뤫
					if($hope_day != null){
						$sql .= "    hope_day,";
					}
					//����ͽ���������ꤵ��Ƥ��뤫
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
					//ľ���褬���ꤵ��Ƥ��뤫
					if($direct_id != null){
						$sql .= "    $direct_id,";
					}
					$sql .= "    '$trade_aord',";
					//�����ȼԤ����ꤵ��Ƥ��뤫
					if($trans_id != null){
						$sql .= "    $trans_id,";
					}
					//���꡼����꤬���ꤵ��Ƥ��뤫
					if($trans_check != null){
			            if($trans_check==1){
			                $sql .= "true,";    
			            }else{
			                $sql .= "false,";    
			            }
					}
					//��˾Ǽ�������ꤵ��Ƥ��뤫
					if($hope_day != null){
		            	$sql .= "    '$hope_day',";
					}
					//����ͽ���������ꤵ��Ƥ��뤫
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
					//��������
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
					//Ʊ���¹��������
					if($result == false){
		                $err_message = pg_last_error();
		                $err_format = "t_aorder_h_ord_no_key";

		                Db_Query($db_con, "ROLLBACK");

		                //�����ֹ椬��ʣ�������            
		                if(strstr($err_message,$err_format) != false){
		                    $error = "Ʊ���˼����Ԥä����ᡢ�����ֹ椬��ʣ���ޤ������⤦���ټ���򤷤Ʋ�������";
		
		                    //���ټ����ֹ���������
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

							break;	//rev.1.2 �в�ͽ�����Υ롼�פ�ȴ����

		                }else{
		                    exit;
		                }
		            }else{

						//����ǡ�����Ͽ�Ѥ���ɼ�ֹ���ݻ�
						$array_ord_no[$fw_day] = $order_no_pad;
						//rev.1.2 ��ɼ�ֹ�
						(int)$ord_no ++;

					}

				}//rev.1.2 �в�ͽ�����롼�׽����
			}

	        if($duplicate_flg != true){
			    //����ǡ�����Ͽ

                //�в�ͽ��������ʬǼ���ϼ������ˤǥ롼��
                foreach($array_ord_no as $fw_day => $ord_no){

                    //$line = 0;

                    //������Ͽ��ʬǼ���ˤϽв�ͽ�������Ȥ�
					if($edit_flg != "true"){

                        //���������
                        $goods_id       = array();
                        $tax_div        = array();
                        $sale_num       = array();
                        $c_price        = array();
                        $s_price        = array();
                        $cost_amount    = array();
                        $sale_amount    = array();
                        $goods_name     = array();

                        //$fw_day �˽вپ���ʬ�롼�׽���
                        while($fw_goods_id = array_shift($data_d[$fw_day]["good_id"])){

                            //�вپ��ʤ����Ϲ�
                            $fw_goods_line = array_shift($data_d[$fw_day]["line"]);

                            $goods_id[]     = $fw_goods_id;                                                     //����ID
                            $tax_div[]      = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["tax_div"];     //���Ƕ�ʬ
                            $sale_num_tmp   = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["num"];
                            $sale_num[]     = $sale_num_tmp;                                                    //�вٿ�
                            $c_price_tmp    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["cost_price"];
                            $c_price[]      = $c_price_tmp;                                                     //����ñ��
                            $s_price_tmp    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["sale_price"];
                            $s_price[]      = $s_price_tmp;                                                     //���ñ��

                            $c_amount       = bcmul($sale_num_tmp, $c_price_tmp, 1);
                            $cost_amount[]  = Coax_Col($coax, $c_amount);                                       //�������
                            $s_amount       = bcmul($sale_num_tmp, $s_price_tmp, 1);
                            $sale_amount[]  = Coax_Col($coax, $s_amount);                                       //�����
                            $goods_name[]   = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["goods_name"];	//����̾

                        }
                    }


		            for($i = 0; $i < count($goods_id); $i++){
		                //��
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
//�����ʤ����߸˼���ʧ���ơ��֥����Ͽ����
//		                if($stock_manage_flg[$i] == '1'){
		                    //����ʧ���ơ��֥����Ͽ
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

				}//re.1.2 �в�ͽ�������ȥ롼�׽����

	    		//������Ͽ�ξ��ϡ�GET����̵���١�GET�������
		    	if($aord_id == null){
					//rev.1.2 ʬǼ����ʣ�������Ǥ��뤿��
					$all_ord_no = "";
					foreach($array_ord_no as $ord_no){
						$all_ord_no .= "'".$ord_no."'";
						$all_ord_no .= ", ";
					}
					$all_ord_no = substr($all_ord_no, 0, strlen($all_ord_no) - 2);	//�Ǹ��", "��;�פʤΤǼ��

			    	//�����ǧ���Ϥ�����ID����
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
					$aord_id = substr($aord_id, 0, strlen($aord_id) - 1);	//�Ǹ��"&"��;�פʤΤǼ��
		    	}
	            Db_Query($db_con, "COMMIT");
	            header("Location: ./1-2-108.php?aord_id=$aord_id&input_flg=true");
	        }
		}else{
			//��Ͽ��ǧ���̤�ɽ���ե饰
			$comp_flg = true;
		}
	}
}

/****************************/
//�����å���λ�ܥ��󲡲�����
/****************************/
/*******************************************************************
if($_POST["complete_flg"] == true && $aord_id != NULL){
	Db_Query($db_con, "BEGIN");

    /*******************************/
    //����¸�ߤ��뤫��ǧ
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
//���ʺ����ʲ��ѡ�
/****************************/
//���ֹ楫����
$row_num = 1;

//�вٲ�����쥯�ȥܥå����� rev.1.2
$select_page_arr = array(1,2,3,4,5,6,7,8,9,10);


//�����褬���򤵤�Ƥ��ʤ����ϥե�������ɽ��
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
    //ɽ����Ƚ��
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;

		//rev.1.2 �Ͱ����ʤ�Ƚ��ʰʲ����ƤΥե�������ɲá�
		$hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

		if($hdn_discount_flg == "t"){
			$font_color = "color: red; ";	//�Ͱ����ʤξ��ϥե���Ȥ��֤ˤ���
		}else{
			$font_color = "color: #000000; ";
		}

        //���ʥ�����
        $form->addElement(
            "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\" 
             style=\"$style $g_form_style $font_color\" $type tabindex=\"-1\" 
            onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'goods_search_row', $i ,$row_num)\""
        );

		//����̾
		//�ѹ��Բ�Ƚ��
		//if(($_POST["hdn_name_change"][$i] == '2' || $hdn_name_change[$i] == '2') && $comp_flg != true && $check_flg != true){
/**********************************************************************
		if(($hdn_name_change[$i] == '2') && $comp_flg != true && $check_flg != true){
**********************************************************************/
		if(($hdn_name_change[$i] == '2') && $comp_flg != true){
			//�Բ�
            $form->addElement(
                "text","form_goods_name[$i]","",
                #2009-09-26 hashimoto-y
                #"size=\"60\" $g_text_readonly" 
                "size=\"60\" style=\"$font_color\" $g_text_readonly" 
            );
        }else{
			//��
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"60\" maxLength=\"41\" 
                style=\"$font_color $style \" $type"
            );
        }

        //��ê��
		//�߸˴���Ƚ��
		//if($no_goods_flg!=true && ($_POST["hdn_stock_manage"][$i] == '1' || $hdn_stock_manage[$i] == '1')){
		if($no_goods_flg!=true && ($hdn_stock_manage[$i] == '1')){
			//�����褬�Ѥ�ä��Τǽ����
			if($post_flg == true){
				$form->addElement("static","form_stock_num[$i]","#","","");
			}else{

				//ͭ
				//POST�������ΤȤ��ʳ��ϡ�hidden���ͤ���Ѥ���(��ê��) *��󥿥����ܻ��ˤ�hidden���ͤ����
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
			//̵
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

        //ȯ��ѿ�
		//�߸˴���Ƚ��
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//̵
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

        //������
		//�߸˴���Ƚ��
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//̵
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

        //�вٲ�ǽ��
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//̵
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

        //�����
		// rev.1.2 �ѹ����̤Τ�ɽ��
		if($edit_flg == "true"){
	        $form->addElement(
    	        "text","form_sale_num[$i]","",
        	    "class=\"money\" size=\"11\" maxLength=\"5\" 
            	onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"
	            style=\"text-align: right; $style $g_form_style $font_color\" $type "
    	    );
		}

		//rev.1.2 �ѹ����ζ�۷׻�JS
		if($edit_flg == "true"){
			$mult_js = "onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"";
		//ʬǼ���ζ�۷׻�JS
		}else{
			$mult_js = "onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"";
		}

        //����ñ��
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

        //�������
        $form->addElement(
            "text","form_cost_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );
        
		//���ñ��
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

        //�����
        $form->addElement(
            "text","form_sale_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );


		//rev.1.2�ʽвٲ����ʬǼ���вٲ�����вٿ���
		//JavaScript�����ϲ��̡���ǧ���̤��ڤ��ؤ���
		if($type != "readonly"){
        	$form_fd_focus = "onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','y','m','d','form_ord_day','y','m','d')\"";
			$form_fn_option = $g_form_option;
		}else{
			$form_fd_focus = $type;
			$form_fn_option = "";
		}

		//�вٲ��
		//��ǧ���̤Ǥ�hidden�ܥƥ����ȥե�����ˤ���
		if($type != "readonly"){
			$form->addElement(
					'select', 'form_forward_times['.$i.']', "�вٲ��", $select_page_arr,
					"onChange=\"javascript:Button_Submit('forward_num_flg','#','true')\" style=\"$font_color\""
					);
		}else{
			$form->addElement("hidden","form_forward_times[$i]");
	        $form->addElement('text', 'form_forward_times_text['.$i.']', "�вٲ��", "size=\"3\" style=\"text-align: right; $style $g_form_style; $font_color\" $type");
		}

		//ʬǼ���в�ͽ����
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

        //�вٿ�
        $form->addElement(
                "text","form_forward_num[".$i."][0]","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\"
            	onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"
                style=\"$font_color $g_form_style;text-align: right; $style \"
                \".$form_fn_option.\"
				$type"
                );

		//�вٲ�����ѹ��������
        if($_POST["forward_num_flg"] == true){
            $forward_number = $_POST["form_forward_times"][$i];
            for($j=1;$j<=$forward_number;$j++){
                //�в�ͽ����
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

                //�вٿ�
                $form->addElement(
                        "text","form_forward_num[".$i."][".$j."]","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\"
            			onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"
                        style=\"$g_form_style;text-align: right; $style $font_color\"
                        \".$form_fn_option.\"
						$type"
                );
            }
        }



		//��Ͽ��ǧ���̤ξ�����ɽ��
/*************************************************************
		if($comp_flg != true && $check_flg != true){
**************************************************************/
		if($comp_flg != true){

	        //�������
	        $form->addElement(
	            "link","form_search[$i]","","#","����",
	            "TABINDEX=-1 onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,5,$client_id,$i,$row_num);\""
	        );

	        //������
	        //�ǽ��Ԥ��������硢���������κǽ��Ԥ˹�碌��
	        if($row_num == $max_row-$del_num){
	            $form->addElement(
	                "link","form_del_row[$i]","",
	                "#","<font color='#FEFEFE'>���</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1);return false;\""
	            );
	        //�ǽ��԰ʳ����������硢�������Ԥ�Ʊ��NO�ιԤ˹�碌��
	        }else{
	            $form->addElement(
	                "link","form_del_row[$i]","",
	                "#","<font color='#FEFEFE'>���</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num);return false;\""
	            );
	        }
		}

		//����ID
        $form->addElement("hidden","hdn_goods_id[$i]");
        //���Ƕ�ʬ
        $form->addElement("hidden", "hdn_tax_div[$i]");
		//��̾�ѹ��ե饰
        $form->addElement("hidden","hdn_name_change[$i]");
		//�߸˴���
        $form->addElement("hidden","hdn_stock_manage[$i]");
		//��ê��
		$form->addElement("hidden","hdn_stock_num[$i]");
		//rev.1.2 �Ͱ�Ƚ��ե饰
        #2009-09-26 hashimoto-y
		#$form->addElement("hidden","hdn_discount_flg[$i]");


        /****************************/
        //ɽ����HTML����
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
		// rev.1.2 �ѹ�����
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

		//rev.1.2 ʬǼ���ʽвٲ����ʬǼ���вٲ�����вٿ���
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

        //���ֹ��ܣ�
        $row_num = $row_num+1;
    }
}

//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ�
/****************************************************************
if($comp_flg != true && $check_flg != true){
****************************************************************/
if($comp_flg != true){

    //button
    $form->addElement("submit","order","�����ǧ���̤�", $disabled);
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"javascript:history.back()\"");

    //���
	$form->addElement("button","form_sum_button","�硡��","onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true')\"");

	//���ɲåܥ���
	$form->addElement("button","add_row_link","���ɲ�","onClick=\"javascript:Button_Submit('add_row_flg', '#foot', 'true')\"");

}else{
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
    //���
    $form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    
	//�����å���λ�ܥ���
	$form->addElement("button","complete","�����å���λ","onClick=\"return Dialogue_2('�����å���λ���ޤ���','".HEAD_DIR."sale/1-2-101.php?aord_id=".$aord_id."','true','complete_flg');\" $disabled");

    //OK
    $form->addElement("submit","comp_button","����OK", $disabled);
    
    $form->freeze();
}


//rev.1.2 �вٿ���� * ñ���� JavaScript
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

    //hidden�ξ���ID�����뤫
    if(document.dateForm.elements[GI].value != ""){

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI].value;
        var str2 = document.dateForm.elements[PD].value;
        if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){

            //�вٿ�����
            times = document.dateForm.elements[FT].value
            forward_sum = 0;
            for(var i=0; i<=times; i++){
                forward_sum += (document.dateForm.elements[FN+"["+i+"]"].value - 0);
            }

            //�׻���
            document.dateForm.elements[SA].value = forward_sum * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));

            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
            }

            //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
            var str = forward_sum + "";
            if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                document.dateForm.elements[SA].value = "";
            }
            document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
            document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
        }else{
            document.dateForm.elements[SA].value = "";
        }

        //�����ǤϤʤ����Ͻ�����Ԥʤ�ʤ�
        var str  = document.dateForm.elements[PI2].value;
        var str2 = document.dateForm.elements[PD2].value;
        if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){
            //�׻���
            document.dateForm.elements[SA2].value = forward_sum * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));

            //�ڼΤƤξ��
            if(coax == '1'){
                document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
            //�ͼθ����ξ��
            }else if(coax == '2'){
                document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
            //�ھ夲�ξ��
            }else if(coax == '3'){
                document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
            }

            //�����ǤϤʤ���� or ���̤������ξ�� �϶����֤�
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
$page_menu = Create_Menu_h('sale','1');
/****************************/
//���̥إå�������
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
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


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
