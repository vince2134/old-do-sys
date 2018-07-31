<?php

/*************************
 * �ѹ�����
 *  ����2006-11-28�˥��˥������󥰽����ɲ�<suzuki>
 *  ��2007-05-31  rental �ξ�硢����ʬ��ID���֤��褦���ѹ�<morita-d>
 *  ��2007-06-06  ����ʬ��̾�Υ��˥������󥰽������ɲ�<morita-d>
 *
 *
**************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/04/03      B0702-030   kajioka-h   case '4'�ʺ߸˰�ư���ϡˤ�̵�����ʤ�������Х�����
 *                  B0702-031   kajioka-h   case '4'�ʺ߸˰�ư���ϡˤ�̤��ǧ���ʤ�������Х�����
 *  2009/10/08                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 */

session_start();

$page_title = "���ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB����³
$db_con = Db_Connect();

/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];

//SQL�����ֹ�
$display = $_GET['display'];
//�Ҹ�ID or ê��Ĵ��ID or ������ID
$select_id = $_GET['select_id'];
//����å׼���ID
$shop_aid = $_GET['shop_aid'];

//�ڡ�����
$f_page1   = $_POST[f_page1];

//�����ե饰
$renew_flg = $_POST[renew_flg];


//hidden�ˤ���ݻ�����
if($_GET['display'] != NULL){
    $set_id_data["hdn_display"] = $display;
    $form->setConstants($set_id_data);
}else{
    $display = $_POST["hdn_display"];
}

if($_GET['select_id'] != NULL){
    $set_id_data["hdn_select_id"] = $select_id;
    $form->setConstants($set_id_data);
}else{
    $select_id = $_POST["hdn_select_id"];
}

if($_GET['shop_aid'] != NULL){
    $set_id_data["hdn_shop_aid"] = $shop_aid;
    $form->setConstants($set_id_data);
}else{
    $shop_aid = $_POST["hdn_shop_aid"];
}

/****************************/
// �ե�����ѡ������
/****************************/
// ���ʥ�����
$form->addElement("text", "form_goods_cd", "���ʥ�����", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// ����̾
$form->addElement("text", "form_goods_name", "����̾", "size=\"34\" maxLength=\"30\" $g_form_option");

// ά��
$form->addElement("text", "form_goods_cname", "ά��", "size=\"22\" maxLength=\"10\" $g_form_option");

// ������ʬ
$select_value = Select_Get($db_con, "product");
$form->addElement("select", "form_product", "������ʬ", $select_value, $g_form_option_select);

// �Ͷ�ʬ
$select_value = Select_Get($db_con, "g_goods");
$form->addElement("select", "form_g_goods", "�Ͷ�ʬ", $select_value, $g_form_option_select);

//����ʬ��
$select_value = Select_Get($db_con, "g_product");
$form->addElement("select", "form_g_product", "����ʬ��", $select_value, $g_form_option_select);

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����");

// �Ĥ���ܥ���
$form->addElement("button", "form_close_button", "�Ĥ���", "onClick=\"window.close()\"");

//GET���ͤ��ݻ�����
$form->addElement("hidden","hdn_display","","");
$form->addElement("hidden","hdn_select_id","","");
$form->addElement("hidden","hdn_shop_aid","","");
$form->addElement("hidden","renew_flg","1"); //���̹����ե饰

/****************************/
//����������
/****************************/

//WHEREʸ�ɲ�
$goods_cd    = $_POST["form_goods_cd"];
$goods_name  = $_POST["form_goods_name"];
$goods_cname = $_POST["form_goods_cname"];
$product     = $_POST["form_product"];
$g_goods     = $_POST["form_g_goods"];
$g_product   = $_POST["form_g_product"];

//���ʥ����ɻ���
if($goods_cd != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.goods_cd LIKE '$goods_cd%'";
}
//����̾����
if($goods_name != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.goods_name LIKE '%$goods_name%'";
}
//ά�λ���
if($goods_cname != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.goods_cname LIKE '%$goods_cname%'";
}
//������ʬ����
if($product != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.product_id = $product";
}
//�Ͷ�ʬ����
if($g_goods != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.g_goods_id = $g_goods";
}
//����ʬ��
if($g_product != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.g_product_id = $g_product";
}

$sort_sql  = " ORDER BY goods_cd";
$sort_sql .= ";";


/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);



/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

/******************************/
//ɽ���ܥ��󲡲�����
/*****************************/
//�ԥǡ�������
if ($renew_flg == "1"){
//if ($form->isSubmitted()){
	switch ($display){
	    case '1':    
	        //1-4-108.php �߸�Ĵ������
	        //����͡����ʥ����ɡ�����̾�����߸˿�����������ñ��
	
	        //���̵��SQL����
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //���ʥ�����
	        $goods_sql .= "     t_goods.goods_name,";                //����̾
	        $goods_sql .= "     t_goods.goods_cname,";               //ά��
	        $goods_sql .= "     t_product.product_name,";            //������ʬ
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //�Ͷ�ʬ
	        $goods_sql .= "     CASE t_goods.attri_div";             //°����ʬ
	        $goods_sql .= "         WHEN '1' THEN '����'";
	        $goods_sql .= "         WHEN '2' THEN '����'";
	        $goods_sql .= "         WHEN '3' THEN '����'";
	        $goods_sql .= "         WHEN '4' THEN '����¾'";
	        $goods_sql .= "     END,";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_goods.unit,";                      //ñ��
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_goods.goods_id,";                   //����ID
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM";
	        $goods_sql .= "    t_goods";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
	        $goods_sql .= " WHERE";
            #2009-10-08 hashimoto-y
	        #$goods_sql .= "     t_goods.stock_manage = '1'";
	        $goods_sql .= "     t_goods_info.stock_manage = '1'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.public_flg = 't' ";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.accept_flg = '1' ";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) ";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods_info.shop_id = $shop_id ";
	
	        //WHEREʸ�ɲ�
	        $goods_sql .= $where_sql;
	        //������ʸ�ɲ�
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //�������
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES); 
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES); 
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES); 
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	            $return_data[] = "'".$row[$i][0]."',".$shop_aid;         
	        }
	
	        break;
	    case '2':
	        //1-4-204.php ê������
	/*
	 * ����
	 *  ����            BɼNo.      ô����      ����
	 *  -----------------------------------------------------------
	 *  2006/12/07      12-008      kajioka-h   �߸˴������ʤ���̤��ǧ�����ʤ�ɽ�����ʤ��褦��
	 */
	        //����͡����ʥ����ɡ�����̾��ñ�̡��߸�ñ����Ģ���
	        
	        //���̵��SQL����
	        //06-05-08 SQL�ѹ���kajioka-h��
	        $goods_sql  = "SELECT ";
	        $goods_sql .= "    t_goods.goods_cd, ";
	        $goods_sql .= "    t_goods.goods_name, ";
	        $goods_sql .= "    t_goods.goods_cname, ";
	        $goods_sql .= "    t_product.product_name, ";
	        $goods_sql .= "    t_g_goods.g_goods_name, ";
	        $goods_sql .= "    CASE ";
	        $goods_sql .= "        t_goods.attri_div ";
	        $goods_sql .= "            WHEN '1' THEN '����' ";
	        $goods_sql .= "            WHEN '2' THEN '����' ";
	        $goods_sql .= "            WHEN '3' THEN '����' ";
	        $goods_sql .= "            WHEN '4' THEN '����¾' ";
	        $goods_sql .= "    END, ";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM ";
	        $goods_sql .= "     t_goods";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
	        $goods_sql .= " WHERE ";
            #2009-10-08 hashimoto-y
	        #$goods_sql .= "        t_goods.stock_manage = '1' ";
	        $goods_sql .= "        t_goods_info.stock_manage = '1'";
	        $goods_sql .= "    AND ";
	        $goods_sql .= "        t_goods.accept_flg = '1' ";
	        $goods_sql .= "    AND ";
	        $goods_sql .= "        t_goods.state IN ('1', '3') ";
	        $goods_sql .= "    AND ";
	        $goods_sql .= "        t_goods.shop_id = '1'";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "    AND";
	        $goods_sql .= "    t_goods_info.shop_id = $shop_id ";
	
	        //WHEREʸ�ɲ�
	        $goods_sql .= $where_sql;
	        //������ʸ�ɲ�
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //�������
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	            $return_data[] = "'".$row[$i][0]."','".$shop_aid."'";
	        }
	
	        break;
	    case '3':
	        //1-3-201.php ��������
	        //����͡����ʥ����ɡ�����̾�����߸˿���ȯ����������ѿ�������ñ��
	        //t_goods t_stock t_price 
	        break;
	    case 'true':
	        //1-4-107.php �߸˰�ư����
	        //����͡����ʥ����ɡ�����̾��ñ��
	
	        //���̵��SQL����
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //���ʥ�����
	        $goods_sql .= "     t_goods.goods_name,";                //����̾
	        $goods_sql .= "     t_goods.goods_cname,";               //ά��
	        $goods_sql .= "     t_product.product_name,";            //������ʬ
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //�Ͷ�ʬ
	        $goods_sql .= "     CASE t_goods.attri_div";             //°����ʬ
	        $goods_sql .= "         WHEN '1' THEN '����'";
	        $goods_sql .= "         WHEN '2' THEN '����'";
	        $goods_sql .= "         WHEN '3' THEN '����'";
	        $goods_sql .= "         WHEN '4' THEN '����¾'";
	        $goods_sql .= "     END,";
	        $goods_sql .= "     t_goods.unit, ";                       //ñ��
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM";
	        $goods_sql .= "     t_goods";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
	        $goods_sql .= " WHERE";
	        $goods_sql .= "     t_goods.public_flg = 't' ";
	        $goods_sql .= "     AND";
            #2009-10-08 hashimoto-y
	        #$goods_sql .= "     t_goods.stock_manage = '1' ";
	        $goods_sql .= "     t_goods_info.stock_manage = '1'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.accept_flg = '1' ";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.state IN ('1', '3') ";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods_info.shop_id = $shop_id ";
	
	        //WHEREʸ�ɲ�
	        $goods_sql .= $where_sql;
	        //������ʸ�ɲ�
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //�������
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $single = addslashes($row[$i][1]);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][6] = htmlspecialchars($row[$i][6],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	
	            //$return_data[$i] = "'".$row[$i][0]."','".htmlspecialchars($single)."','".$row[$i][6]."'";
	            $return_data[$i] = "'".$row[$i][0]."','".$shop_aid."'";
	        }
	        break;
	    case '5':
	        //1-3-102.php ȯ������
	        //����͡����ʥ�����
	
	        //���̵��SQL����
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //���ʥ�����
	        $goods_sql .= "     t_goods.goods_name,";                //����̾
	        $goods_sql .= "     t_goods.goods_cname,";               //ά��
	        $goods_sql .= "     t_product.product_name,";            //������ʬ
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //�Ͷ�ʬ
	        $goods_sql .= "     CASE t_goods.attri_div";             //°����ʬ
	        $goods_sql .= "         WHEN '1' THEN '����'";           
	        $goods_sql .= "         WHEN '2' THEN '����'";           
	        $goods_sql .= "         WHEN '3' THEN '����'";           
	        $goods_sql .= "         WHEN '4' THEN '����¾'";         
	        $goods_sql .= "     END, ";                               
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	
	        $goods_sql .= " FROM";
	        $goods_sql .= "     t_price";
	        $goods_sql .= "    INNER JOIN t_goods ON t_price.goods_id = t_goods.goods_id";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
	        $goods_sql .= " WHERE";
	        $goods_sql .= "     t_price.shop_id = $shop_id";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_price.rank_cd = '1'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.public_flg = 't' ";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.state <> '2'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.accept_flg = '1'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.compose_flg = 'f'";
	
	        //WHEREʸ�ɲ�
	        $goods_sql .= $where_sql;
	        //������ʸ�ɲ�
	        $goods_sql .= $sort_sql;
	
	
	        $result = Db_Query($db_con, $goods_sql);
	        //�������
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	            $return_data[] = "'".$row[$i][0]."',".$shop_aid;
	        }
	        break;
	    case "7":
	        //1-4-109.php ������Ω
	        //����͡����ʥ����ɡ�����̾
	
	        //���̵��SQL����
	        $goods_sql  = "SELECT\n";
	        $goods_sql .= " t_goods.goods_cd,\n";
	        $goods_sql .= " t_goods.goods_name,\n";
	        $goods_sql .= " t_goods.goods_cname,\n";
	        $goods_sql .= " t_product.product_name,\n";
	        $goods_sql .= " t_g_goods.g_goods_name,\n";
	        $goods_sql .= " CASE t_goods.attri_div\n";
	        $goods_sql .= "     WHEN '1' THEN '����'\n";
	        $goods_sql .= "     WHEN '2' THEN '����'\n";
	        $goods_sql .= "     WHEN '3' THEN '����'\n";
	        $goods_sql .= "     WHEN '4' THEN '����¾'\n";
	        $goods_sql .= " END,\n";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM\n";
	        $goods_sql .= "    t_goods \n";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
	        $goods_sql .= " WHERE\n";
	        $goods_sql .= "    t_goods.shop_id = 1\n";
	        $goods_sql .= " AND\n";
	        $goods_sql .= "    t_goods.make_goods_flg = 't'\n";
	        $goods_sql .= " AND\n";
	        $goods_sql .= "    t_goods.no_change_flg = 'f'\n";
	        
	        //WHEREʸ�ɲ�
	        $goods_sql .= $where_sql;
	        //������ʸ�ɲ�
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //�������
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $single = addslashes($row[$i][1]);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	
	            $return_data[$i] = "'".$row[$i][0]."','".htmlspecialchars($single)."'";
	        }
	        break;
	    case 'rental':    
	
	        //1-2-132.php ��󥿥�TO��󥿥�
	        //����͡����ʥ�����
	
	        //���̵��SQL����
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //���ʥ�����
	        $goods_sql .= "     t_goods.goods_name,";                //����̾
	        $goods_sql .= "     t_goods.goods_cname,";               //ά��
	        $goods_sql .= "     t_product.product_name,";            //������ʬ
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //�Ͷ�ʬ
	        $goods_sql .= "     CASE t_goods.attri_div";             //°����ʬ
	        $goods_sql .= "         WHEN '1' THEN '����'";           
	        $goods_sql .= "         WHEN '2' THEN '����'";           
	        $goods_sql .= "         WHEN '3' THEN '����'";           
	        $goods_sql .= "         WHEN '4' THEN '����¾'";         
	        $goods_sql .= "     END, ";
	        $goods_sql .= "   t_goods.goods_id,";                    //����ID
	        $goods_sql .= "   t_price.r_price, ";                    //��󥿥�ñ��
	        //$goods_sql .= "   t_g_product.g_product_name || '��' || t_goods.goods_name, "; //����ʬ��̾������̾
	        $goods_sql .= "   t_goods.goods_name, "; //����ʬ��̾������̾
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name, ";
	        $goods_sql .= "     t_g_product.g_product_id ";
	                               
	        $goods_sql .= " FROM";
	        $goods_sql .= "   t_goods ";
	
	        $goods_sql .= "   INNER JOIN  t_price ON t_goods.goods_id = t_price.goods_id";
	        $goods_sql .= "   INNER JOIN  t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id";
	        $goods_sql .= "   INNER JOIN  t_product ON t_goods.product_id = t_product.product_id";
	        $goods_sql .= "   INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
	
	        $goods_sql .= " WHERE";
	        $goods_sql .= "   t_price.shop_id = 1 ";
	        $goods_sql .= " AND ";
	        $goods_sql .= "   t_price.rank_cd = '5' ";
	        $goods_sql .= " AND ";
	        $goods_sql .= "   t_goods.accept_flg = '1' ";
	        $goods_sql .= " AND ";
	        $goods_sql .= "   t_goods.rental_flg = 't' ";
	        $goods_sql .= " AND ";
	        $goods_sql .= "   t_goods.state = 1 ";
	
	        //WHEREʸ�ɲ�
	        $goods_sql .= $where_sql;
	        //������ʸ�ɲ�
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //�������
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	
	            $row[$i][8] = addslashes($row[$i][8]);
	            $row[$i][8] = htmlspecialchars($row[$i][8],ENT_QUOTES);
	            $row[$i][12] = addslashes($row[$i][12]);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	
	            //�֤��͡ʾ���ID,����CD,����̾,��󥿥�ñ����
	            $price = explode('.',$row[$i][7]);
              $return_data[$i] = "'".$row[$i][6]."','".$row[$i][0]."','".$row[$i][8]."','"
             .$price[0]."','".$price[1]."','".$price[0]."','".$price[1]."','".$row[$i][12]."'";
	
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	
	       }
	        break;
	    default:
	        //����͡����ʥ����ɡ�����̾
	
	        //���̵��SQL����
	/*
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //���ʥ�����
	        $goods_sql .= "     t_goods.goods_name,";                //����̾
	        $goods_sql .= "     t_goods.goods_cname,";               //ά��
	        $goods_sql .= "     t_product.product_name,";            //������ʬ
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //�Ͷ�ʬ
	        $goods_sql .= "     CASE t_goods.attri_div";             //°����ʬ
	        $goods_sql .= "         WHEN '1' THEN '����'";
	        $goods_sql .= "         WHEN '2' THEN '����'";
	        $goods_sql .= "         WHEN '3' THEN '����'";
	        $goods_sql .= "         WHEN '4' THEN '����¾'";
	        $goods_sql .= "     END";
	        $goods_sql .= " FROM";
	        $goods_sql .= "     t_goods,";
	        $goods_sql .= "     t_g_goods,";
	        $goods_sql .= "     t_product";
	        $goods_sql .= " WHERE";
	        $goods_sql .= "     t_goods.product_id = t_product.product_id";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.g_goods_id = t_g_goods.g_goods_id";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.public_flg = 't' ";
	*/
	        $goods_sql  = "SELECT\n";
	        $goods_sql .= " t_goods.goods_cd,\n";
	        $goods_sql .= " t_goods.goods_name,\n";
	        $goods_sql .= " t_goods.goods_cname,\n";
	        $goods_sql .= " t_product.product_name,\n";
	        $goods_sql .= " t_g_goods.g_goods_name,\n";
	        $goods_sql .= " CASE t_goods.attri_div\n";
	        $goods_sql .= "     WHEN '1' THEN '����'\n";
	        $goods_sql .= "     WHEN '2' THEN '����'\n";
	        $goods_sql .= "     WHEN '3' THEN '����'\n";
	        $goods_sql .= "     WHEN '4' THEN '����¾'\n";
	        $goods_sql .= " END,\n";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM\n";
	        $goods_sql .= "    t_goods \n";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
	        $goods_sql .= " WHERE\n";
	        $goods_sql .= "    t_goods.public_flg = 't'\n";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    t_goods.accept_flg = '1'\n";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    t_goods.compose_flg = 'f'\n";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    t_goods.state IN (1,3)\n";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    t_goods.no_change_flg = 'f'";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) ";
	
	        //WHEREʸ�ɲ�
	        $goods_sql .= $where_sql;
	        //������ʸ�ɲ�
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //�������
	        $total_count = pg_num_rows($result);
	        //����ͺ���
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $single = addslashes($row[$i][1]);
	            $return_data[$i] = "'".$row[$i][0]."','".htmlspecialchars($single)."'";
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	        }	
	}
}


/****************************/
// �ڡ�����������
/****************************/

//����ɽ������
//if ($form->isSubmitted()){
if ($renew_flg == "1"){

	$range = 100; //1�ڡ����������ɽ�����

	//���ߤΥڡ�����������å�����
	$page_info = Check_Page($total_count, $range, $f_page1);
	$page      = $page_info[0]; //���ߤΥڡ�����
	$page_snum = $page_info[1]; //ɽ�����Ϸ��
	$page_enum = $page_info[2]; //ɽ����λ���

	//�ڡ����ץ������ɽ��Ƚ��
	if($page == 1){
		//�ڡ����������ʤ�ڡ����ץ���������ɽ��
		$page = NULL;
	}

	//�ڡ�������
	$html_page  = Html_Page($total_count,$page,1,$range);
	$html_page2 = Html_Page($total_count,$page,2,$range);

}

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'    => "$html_header",
    'page_menu'      => "$page_menu",
    'page_header'    => "$page_header",
    'html_footer'    => "$html_footer",
    'total_count'   => "$total_count",
    'html_page'      => "$html_page",
    'html_page2'     => "$html_page2",
    'page_snum'      => "$page_snum",
    'page_enum'      => "$page_enum",

));

$smarty->assign('page_data', $row);
$smarty->assign('return_data', $return_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
