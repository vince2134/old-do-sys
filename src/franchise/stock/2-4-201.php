<?php
/**
 *
 * ê��Ĵ��ɽ����������
 *
 *
 *
 *
 *
 *
 *
 *   !! ������FC���̤Ȥ��Ʊ�����������ƤǤ� !!
 *   !! �ѹ�������������򤤤��ä�¾���˥��ԤäƤ������� !!
 *
 *
 *
 *
 *
 *
 *
 * ��ê���ϳƥ���åפ��Ȥ˹Ԥ���ľ�ĤǤ�¾�Υ���åפ�ê���ϼ»ܤǤ��ʤ���
 * ��ê�����Ϻǽ������������ϻ���Ǥ��ʤ�
 * ��ê����������ê����������ϻ���Ǥ��ʤ�
 *
 * ���ΤΥХ�
 * ���Ҹ�̾��Windows�ǥե�����̾�˻Ȥ��ʤ�ʸ����\/*?:"<>|�ˤ�����ȡ�
 *   CSV�Υե�����̾�����������ʤ�����ƤϤ����
 *
 * 1.0.0 (2006/04/27) ��������
 * 1.0.1 (2006/05/09) ê��Ĵ��ɽ��������staff_id����Ͽ���ʤ��褦���ѹ�
 * 1.0.2 (2006/05/10) ê��Ĵ��ɽ������˼����̤����ܤ���褦���ѹ�
 * 1.0.3 (2006/05/10) ê�����Ϥ�»ܤ��Ƥ��ʤ����Ϻ��۰�����󥯤�ɽ�����ʤ��褦���ѹ�
 * 1.0.4 (2006/05/11) ê��Ĵ��ɽ��������̾�Τȥ����ɤ���Ͽ����褦���ѹ�
 * 1.0.5 (2006/07/10) shop_gid��ʤ���
 * 1.0.6 (2006/08/25) CSV�ե�����̾���ѹ�����ê�����
 *                      ê���������ϲ�
 * 1.0.7 (2006/10/13) ê���ǡ�������SQL��stock_cd��'-'��Ĥ���
 * 1.0.8 (2006/10/17) (kaji)
 *   ��ê�����Υե����फ��ե������������줿�Ȥ��˥ե�������򤯤���
 *   ��ê������0��ᤷ�������꡼���顼�Ȥʤ�Τ����
 *   ��ê�����������������å���QuickForm��numeric��������ɽ�����ѹ�
 *   ��ê�����Ϸ�����ȥ����ƥ೫�������夫�����å��ɲ�
 *   ��ľ�����¾�Υ���åפ�ê���ǡ������äǤ��Ƥ����Τ���
 *   ��ê���ǡ�����¸�ߤ��ʤ����ˡ����顼��å�������ɽ������ʤ��ä��Τ���
 *   �����˥�������
 *   ������ʬ��CD������ʬ��̾������̾��ά�Ρˤ��ɲ�
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.8 (2006/10/17)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/06      12-001      kajioka-h   ���ʤξ��֤���̵���ס�ͭ����ľ�ĤΤߡˡפ��θ
 *                  12-002      kajioka-h   ��������Ԥ���°���ҸˤΤ�ê���оݤˡ�ľ�Ĥδ����Ҹˤ��θ��
 *                  12-003      kajioka-h   �Ҹ˥ޥ�������ɽ�����ꤵ��Ƥ����Ҹˤ�ê���оݳ��ˤ���
 *  2006/12/07      12-005      kajioka-h   Ʊ����Ĵ��ɽ�������줿������¾�����ɲ�
 *                  12-006      kajioka-h   Ĵ��ɽ������˴��˺������Ƥ��ʤ��������å������ɲ�
 *                  12-007      kajioka-h   Ĵ��ɽ������˴��˹�������Ƥ��ʤ��������å������ɲ�
 *  2006/12/21      xx-xxx      kajioka-h   CSV��ɽ������Ҹˡ�����ʬ�ࡢ����CD�ˤ���
 *                  xx-xxx      kajioka-h   ��ê���ϥǥե����0����Ͽ
 *  2007/01/22      xx-xxx      kajioka-h   Ĵ��ɽ�����ǰ����Ͽ���Ƥ���Τ��狼��褦���ѹ�
 *  2007/02/13                  watanabe-k  ô���Ҹˤ�Ĵ��ɼ��������ʤ��褦�˽�����FC��
 *  2007/02/16      xx-xxx      watanabe-k  �����Ҹ˥��������ȼ��SQL������������
 *  2007/02/20      ������Ŧ    kajioka-h   ��ê���ϥǥե����Ģ���������ޤ���
 *  2007/03/06      ��ȹ���73  ��          ê�������Ⱥ������ٰ����򣱥⥸�塼��˽��󤷤����ᡢ�����̾�Τ��ѹ�
 *  2007/05/11      xx-xxx      kajioka-h   ê�����Ϥ��ɲ����Ϥ������ʤ�CSV�˽��Ϥ��ʤ��褦���ѹ�
 *  2007/05/14      ����¾92    kajioka-h   ê�����Ϥ�50�Ԥ��Ȥ�ɽ�������ϲ�ǽ�ˤʤä����ᡢê��������ɽ��Ƚ�ꡢ�����ϿȽ����ѹ�
 *  2009/10/09                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 */


$page_title = "ê��Ĵ��ɽ����������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
//$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

//disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//select����������
//require_once(PATH."include/select_part.php");

/****************************/
//�����ѿ�����
/****************************/
/*
echo "<pre>";
print_r($_SESSION);
print_r($_POST);
echo "</pre>";
*/

$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$rank_cd    = ($group_kind == "1") ? "1" : "3";

if($_GET["err"] == "dup"){
	$err_mess = "����ê��Ĵ��ɽ����������Ƥ��ޤ���";
}elseif($_GET["err"] == "del"){
	$err_mess = "����ê��Ĵ��ɽ���������Ƥ��ޤ���";
}elseif($_GET["err"] == "rnw"){
	$err_mess = "����ê��Ĵ��ɽ����������Ƥ��ޤ���";
}


/****************************/
//�ǥե����������
/****************************/

$def_fdata = array(
    "form_target_goods" => "1"
);

$form->setDefaults($def_fdata);

/****************************/
//�������
/****************************/

//�оݾ��ʥ饸���ܥ���
$radio = "";
$radio[] =& $form->createElement("radio", NULL, NULL, "������", "1");
$radio[] =& $form->createElement("radio", NULL, NULL, "�߸˿�0�ʳ�", "2");
$radio[] =& $form->createElement("radio", NULL, NULL, "�߸˿�0", "3");
$form->addGroup($radio, "form_target_goods", "�оݾ���");

//ê����
$form_create_day[] =& $form->createElement(
    "text","y","�ƥ����ȥե�����",
    "style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\"
     onkeyup=\"changeText(this.form,'form_create_day[y]','form_create_day[m]',4)\"
     onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]');\"
     onBlur=\"blurForm(this)\" onKeyDown=\"chgKeycode();\"
    ");
$form_create_day[] =& $form->createElement(
    "text","m","�ƥ����ȥե�����","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\"
     onkeyup=\"changeText(this.form,'form_create_day[m]','form_create_day[d]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]');\"
     onBlur=\"blurForm(this)\" onKeyDown=\"chgKeycode();\"
    ");
$form_create_day[] =& $form->createElement(
    "text","d","�ƥ����ȥե�����","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\"
     onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]');\"
     onBlur=\"blurForm(this)\" onKeyDown=\"chgKeycode();\"
    ");
$form->addGroup( $form_create_day,"form_create_day","form_create_day","-");

//Ĵ��ɽ�����ܥ���
$form->addElement("submit", "create_button", "Ĵ��ɽ����", $disabled);

//���ꥢ�ܥ���
$form->addElement("submit", "clear_button", "���ꥢ", "");

//Ĵ����åܥ���
//$form->addElement("submit", "delete_button", "Ĵ�����", $disabled);
$form->addElement("button", "form_delete_button", "Ĵ�����", "onClick=\"javascript:Dialogue_2('������ޤ���', '#', 'Ĵ�����', 'delete_button')\" $disabled");
$form->addElement("hidden", "delete_button");

// ê��Ĵ��ɽ��󥯥ܥ���
$form->addElement("button", "4_201_button", "ê��Ĵ��ɽ", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

// ê�����Ӱ�����󥯥ܥ���
if($group_kind == "1"){
    $form->addElement("button", "4_205_button", "ê�����Ӱ���", "onClick=\"location.href('./1-4-205.php');\"");
}else{
    $form->addElement("button", "4_205_button", "ê�����Ӱ���", "onClick=\"location.href('./2-4-205.php');\"");
}

//ê��Ĵ��ɽ�ֹ�hidden
$form->addElement("hidden", "invent_cd", "", "");

/****************************/
//
/****************************/

/***��Ĵ��ɽ�����ץܥ��󤬲����줿 ***/
if($_POST["create_button"] == "Ĵ��ɽ����") {

    $create_day_y           = $_POST["form_create_day"]["y"];     //ê����
    $create_day_m           = $_POST["form_create_day"]["m"];        
    $create_day_d           = $_POST["form_create_day"]["d"];

    if($create_day_y != null || $create_day_m != null || $create_day_d != null){
        $create_day = $create_day_y."-".$create_day_m."-".$create_day_d;
    }

    /****************************/
    //���顼�����å�(addRule)
    /****************************/
    //ê����
    //��ɬ�ܥ����å�
    //��Ⱦ�ѿ��������å�
    $form->addGroupRule('form_create_day', array(
            'y' => array(
                    array('ê���� �����դ������ǤϤ���ޤ���', 'required'),
                    //array('ê���� �����դ������ǤϤ���ޤ���', 'numeric')
                    array('ê���� �����դ������ǤϤ���ޤ���', "regex", '/^[0-9]+$/')
            ),      
            'm' => array(
                    array('ê���� �����դ������ǤϤ���ޤ���','required'),
                    //array('ê���� �����դ������ǤϤ���ޤ���', 'numeric')
                    array('ê���� �����դ������ǤϤ���ޤ���', "regex", '/^[0-9]+$/')
            ),      
            'd' => array(
                    array('ê���� �����դ������ǤϤ���ޤ���','required'),
                    //array('ê���� �����դ������ǤϤ���ޤ���', 'numeric')
                    array('ê���� �����դ������ǤϤ���ޤ���', "regex", '/^[0-9]+$/')
            ),      
    ));

    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    $error_flg = false;            //���顼Ƚ��ե饰

    //ê����
    //�������������å�
    if($create_day_y != null || $create_day_m != null || $create_day_d != null){
        $create_day_y = (int)$create_day_y;
        $create_day_m = (int)$create_day_m;
        $create_day_d = (int)$create_day_d;
        if(!checkdate($create_day_m,$create_day_d,$create_day_y)){
            $form->setElementError("form_create_day","ê���� �����դ������ǤϤ���ޤ���");
            $error_flg = true;
        }
    }
    //����������夫�����å�
    if($error_flg == false && !Check_Monthly_Renew($db_con, $shop_id, "0", $create_day_y, $create_day_m, $create_day_d)){
        $form->setElementError("form_create_day","ê���� ������η�������������դ����Ϥ���Ƥ��ޤ���");
        $error_flg = true;
    }
    //�������ƥ೫�Ϥ��夫�����å�
    if($error_flg == false){
        $sys_start_msg = Sys_Start_Date_Chk($create_day_y, $create_day_m, $create_day_d, "ê����");
        if($sys_start_msg != null){
            $form->setElementError("form_create_day", $sys_start_msg);
            $error_flg = true;
        }else{
            //$create_day = $create_day_y."-".$create_day_m."-".$create_day_d;
            $create_day  = str_pad($create_day_y, 4, 0, STR_PAD_LEFT);
            $create_day .= str_pad($create_day_m, 2, 0, STR_PAD_LEFT);
            $create_day .= str_pad($create_day_d, 2, 0, STR_PAD_LEFT);
        }
    }

    //ľ����¾�Υ桼����Ĵ��ɽ���������Ƥ��ʤ��������å���12-005��
    $sql = "SELECT COUNT(invent_id) FROM t_invent WHERE shop_id = $shop_id AND renew_flg = false;";
    $result = Db_Query($db_con, $sql);
    if(pg_fetch_result($result, 0, 0) != 0){
        header("Location: $_SERVER[PHP_SELF]?err=dup");
        exit();
    }

    //���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
    if($form->validate() && $error_flg == false){

        //Ĵ��ɽ��������뤿�ᡢ����å�����Ҹˡ������������
        $sql  = "SELECT \n";
        $sql .= "    t_stock.ware_id, \n";
        $sql .= "    t_stock.goods_id, \n";
        $sql .= "    t_stock.stock_num AS book_physical, \n";
        $sql .= "    t_price.r_price, \n";
        $sql .= "    t_ware.ware_cd, \n";
        $sql .= "    t_ware.ware_name, \n";
        $sql .= "    t_goods.goods_cd, \n";
        $sql .= "    t_goods.goods_name, \n";
        $sql .= "    t_g_goods.g_goods_cd, \n";
        $sql .= "    t_g_goods.g_goods_name, \n";
        $sql .= "    t_product.product_cd, \n";
        $sql .= "    t_product.product_name, \n";
        $sql .= "    t_g_product.g_product_cd, \n";
        $sql .= "    t_g_product.g_product_name, \n";
        $sql .= "    t_goods.goods_cname \n";

        $sql .= "FROM \n";

        //�߸˼�ʧ�ơ��֥���߸˿��������������
//        $sql .= "   (SELECT \n";
//        $sql .= "       CASE \n";
//        $sql .= "           WHEN t_stock.goods_id IS NOT NULL THEN t_stock.goods_id \n";
//        $sql .= "           WHEN t_stock.goods_id IS NULL     THEN t_allowance.goods_id \n";
//        $sql .= "       END AS goods_id, \n";
//        $sql .= "       t_stock.ware_id, \n";
//        $sql .= "       COALESCE(t_stock.stock_num,0)AS stock_num \n";
//        $sql .= "   FROM \n";
        //�߸˿���׻�
        $sql .= "       (SELECT \n";
        $sql .= "           goods_id, \n";
        $sql .= "           ware_id, \n";
        $sql .= "           SUM(t_stock_hand.num * \n";
        $sql .= "               CASE t_stock_hand.io_div \n";
        $sql .= "                       WHEN 1 THEN 1 \n";
        $sql .= "                       WHEN 2 THEN -1 \n";
        $sql .= "                   END \n"; 
        $sql .= "           ) AS stock_num, \n"; 
//        $sql .= "           shop_id, \n";
        //$sql .= "           goods_id || '-' || ware_id || shop_id AS stock_cd\n";
        //$sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd \n";
        $sql .= "           goods_id || '-' || ware_id AS stock_cd \n";
        $sql .= "       FROM \n";
        $sql .= "           t_stock_hand \n";
        $sql .= "       WHERE \n";
        $sql .= "           work_div NOT IN (1,3) \n";
        $sql .= "           AND \n";
        $sql .= "           work_day <= '$create_day' \n";
        $sql .= "           AND \n";
        if($_SESSION[group_kind] == '2'){
            $sql .= "           shop_id IN (".Rank_Sql().")\n";
        }else{  
            $sql .= "           shop_id = $shop_id \n";
        }       
        //$sql .= "       GROUP BY goods_id, ware_id, shop_id \n";
        $sql .= "       GROUP BY goods_id, ware_id \n";
        $sql .= "       ) AS t_stock \n";
//        $sql .= "   FULL OUTER JOIN \n";
//        //��������׻�
//        $sql .= "       (SELECT \n";
//        $sql .= "           goods_id, \n";
//        $sql .= "           ware_id, \n";
//        $sql .= "           SUM(t_stock_hand.num * \n";
//        $sql .= "                   CASE t_stock_hand.io_div \n";
//        $sql .= "                       WHEN 1 THEN -1 \n";
//        $sql .= "                       WHEN 2 THEN 1 \n";
//        $sql .= "                   END \n";
//        $sql .= "           ) AS allowance_num, \n";
//        $sql .= "           shop_id, \n";
//        //$sql .= "           goods_id || '-' || ware_id || shop_id AS stock_cd\n";
//        $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd \n";
//        $sql .= "       FROM \n";
//        $sql .= "           t_stock_hand \n";
//        $sql .= "       WHERE \n";
//        $sql .= "           work_div = '3' \n";
//        $sql .= "           AND \n";
//        $sql .= "           work_day <= '$create_day' \n";
//        $sql .= "           AND \n";
//        if($_SESSION[group_kind] == '2'){
//            $sql .= "           shop_id IN (".Rank_Sql().")\n";
//        }else{
//            $sql .= "           shop_id = $shop_id \n";
//        }
//        $sql .= "       GROUP BY goods_id, ware_id, shop_id \n";
//        $sql .= "       )AS t_allowance \n";
//        $sql .= "       ON t_stock.stock_cd = t_allowance.stock_cd \n";
//        $sql .= "    ) AS t_stock \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_goods \n";
        $sql .= "    ON t_goods.goods_id = t_stock.goods_id \n ";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_price \n";
        $sql .= "    ON t_price.goods_id = t_stock.goods_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_ware \n";
        $sql .= "    ON t_ware.ware_id = t_stock.ware_id \n";
//        $sql .= "       AND t_ware.own_shop_id = $shop_id \n";
        if($group_kind == 1){
            $sql .= "       AND t_ware.shop_id = $shop_id \n";
        }else{
            $sql .= "       AND t_ware.staff_ware_flg = false \n";
        }
        $sql .= "       AND t_ware.nondisp_flg = false \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_g_goods \n";
        $sql .= "    ON t_g_goods.g_goods_id = t_goods.g_goods_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_product \n";
        $sql .= "    ON t_product.product_id = t_goods.product_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_g_product \n";
        $sql .= "    ON t_g_product.g_product_id = t_goods.g_product_id \n";

        #2009-10-09 hashimoto-y
        $sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

        $sql .= "WHERE \n";
//    $sql .= "    t_stock.shop_id = $_SESSION[client_id] ";

        #2009-10-09 hashimoto-y
        #$sql .= "    t_goods.stock_manage = '1' \n";
        $sql .= "    t_goods_info.stock_manage = '1' \n";
        $sql .= "     AND";
        $sql .= "     t_goods_info.shop_id = $shop_id ";

        $sql .= "AND \n";
        $sql .= "    t_goods.accept_flg = '1' \n";
        $sql .= "AND \n";
        //FC�ʳ��������ޤ���ľ�ġˤ�ͭ�����ʤ�ľ�ĤΤ�ͭ������
        if($_SESSION["group_kind"] != '3'){
            $sql .= "    t_goods.state IN ('1', '3') \n";
        //FC��ͭ�����ʤΤ�
        }else{
            $sql .= "    t_goods.state = '1' \n";
        }
        $sql .= "AND \n";
    //$sql .= "    t_price.shop_gid = $_SESSION[shop_gid] ";
        $sql .= ($group_kind == "2") ? " t_price.shop_id IN (".Rank_Sql().") \n " : " t_price.shop_id = $shop_id \n";
        //$sql .= " t_price.shop_id = $shop_id \n";
        $sql .= "AND \n";
        $sql .= "    t_price.rank_cd = $rank_cd \n";

        //�оݾ��ʤΡֺ߸˿�0�ʳ��פ����򤵤줿���
        if($_POST["form_target_goods"] == "2") {
            $sql .= "    AND t_stock.stock_num <> 0 \n";
        //�оݾ��ʤΡֺ߸˿�0�פ����򤵤줿���
        } else if ($_POST["form_target_goods"] == "3") {
            $sql .= "    AND t_stock.stock_num = 0 \n";
        }

        $sql .= "ORDER BY \n";
        $sql .= "    t_stock.ware_id, \n";
        $sql .= "    t_stock.goods_id \n";
        $sql .= ";\n";
//print_array($sql, "ê���ǡ�������");

        $result = Db_Query($db_con, $sql);

        //ê��Ĵ��ɽ�Υǡ�����0����ä���硢�����̤����
        if(pg_num_rows($result) == 0) {
            header("Location: $_SERVER[PHP_SELF]?invent_data=0");
            exit();
        }

        //����ê��Ĵ��ɽ�ֹ����
        $sql2  = "SELECT ";
        $sql2 .= "    COALESCE(MAX(to_number(invent_no, '0000000000')), 0)+1 ";
        $sql2 .= "FROM ";
        $sql2 .= "    t_invent ";
        $sql2 .= "WHERE ";
        $sql2 .= "    shop_id = $_SESSION[client_id]";
//        $sql2 .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
        $sql2 .= ";";

        $result2 = Db_Query($db_con, $sql2);
        $invent_no = pg_fetch_result($result2, 0, 0);
        $invent_no = str_pad($invent_no, 10, "0", STR_PAD_LEFT);


        /*** ê���إå���ê���ǡ�����Ͽ�ȥ�󥶥�����󳫻� ***/
        Db_Query($db_con, "BEGIN;");

        $pre_ware_id = "";

        /*** ê���إå��ơ��֥���Ҹ�ʬ�Υǡ�������Ͽ ***/
        while($array = pg_fetch_array($result)) {

            if($pre_ware_id != $array['ware_id']) {

                //ê���إå��ơ��֥����Ͽ
                $sql2  = "INSERT INTO t_invent \n";

                // 1.0.1(06-05-09) kajioka-h��ê��Ĵ��ɽ��������staff_id����Ͽ���ʤ�
                //$sql2 .= "   (invent_id, invent_no, expected_day, ware_id, target_goods, staff_id, shop_id) ";
                $sql2 .= "   (invent_id, invent_no, expected_day, ware_id, ware_name, ware_cd, target_goods, shop_id) \n";

                $sql2 .= "VALUES ( \n";
                $sql2 .= "    (SELECT COALESCE(MAX(invent_id), 0)+1 FROM t_invent), \n";
                $sql2 .= "    '$invent_no',\n ";
                $sql2 .= "    '$create_day',\n ";
                $sql2 .= "    ".$array['ware_id'].",\n ";
                //$sql2 .= "    '$array[ware_name]', \n";
                $sql2 .= "    '".addslashes($array[ware_name])."', \n";
                $sql2 .= "    '$array[ware_cd]', \n";
                $sql2 .= "    ".$_POST['form_target_goods'].",\n ";

                // 1.0.1(06-05-09) kajioka-h��ê��Ĵ��ɽ��������staff_id����Ͽ���ʤ�
                //$sql2 .= "    ".$_SESSION['staff_id'].", ";
                $sql2 .= "    ".$shop_id." \n";
                $sql2 .= ") \n";
                $sql2 .= "; \n";

                $result2 = Db_Query($db_con, $sql2);
                if($result2 == false) {
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

                //ê���إå��ơ��֥����Ͽ����ê��Ĵ��ID�����
                $sql2  = "SELECT invent_id FROM t_invent ";
                $sql2 .= "WHERE ";
                $sql2 .= "    shop_id = ".$_SESSION['client_id']." ";
                //$sql2 .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
                $sql2 .= "AND ";
                $sql2 .= "    ware_id = ".$array['ware_id']." ";
                $sql2 .= "AND ";
                $sql2 .= "    invent_no = '$invent_no'";
                $sql2 .= ";";

                $result2 = Db_Query($db_con, $sql2);
                $invent_id = pg_fetch_result($result2, 0, 0);       //ê��Ĵ��ID
            }

            //ê���ǡ����ơ��֥���Ҹˤ��Ф��뾦��ʬ�Υǡ�������Ͽ
            $sql2  = "INSERT INTO t_contents ";
            //$sql2 .= "    (invent_id, goods_id, stock_num, tstock_num, goods_cd, goods_name, g_goods_cd, g_goods_name, price) ";
            $sql2 .= "    ( ";
            $sql2 .= "        invent_id, ";
            $sql2 .= "        goods_id, ";
            $sql2 .= "        stock_num, ";
            $sql2 .= "        tstock_num, ";
            $sql2 .= "        goods_cd, ";
            $sql2 .= "        goods_name, ";
            $sql2 .= "        g_goods_cd, ";
            $sql2 .= "        g_goods_name, ";
            $sql2 .= "        price, ";
            $sql2 .= "        product_cd, ";
            $sql2 .= "        product_name, ";
            $sql2 .= "        g_product_cd, ";
            $sql2 .= "        g_product_name, ";
            $sql2 .= "        goods_cname ";
            $sql2 .= "    ) ";
            $sql2 .= "VALUES ( ";
            $sql2 .= "    $invent_id, ";
            $sql2 .= "    ".$array['goods_id'].", ";
            $sql2 .= "    ".$array['book_physical'].", ";
            $sql2 .= "    ".$array['book_physical'].", ";   //��ê���ϥǥե����Ģ���������ޤ���
            //$sql2 .= "    0, ";         //��ê���ϥǥե����0��
            $sql2 .= "    '$array[goods_cd]', ";
            //$sql2 .= "    '$array[goods_name]', ";
            $sql2 .= "    '".addslashes($array[goods_name])."', ";
            $sql2 .= "    '$array[g_goods_cd]', ";
            //$sql2 .= "    '$array[g_goods_name]', ";
            $sql2 .= "    '".addslashes($array[g_goods_name])."', ";
            $sql2 .= "    ".$array['r_price'].", ";
            $sql2 .= "    '$array[product_cd]', ";
            $sql2 .= "    '".addslashes($array[product_name])."', ";
            $sql2 .= "    '$array[g_product_cd]', ";
            $sql2 .= "    '".addslashes($array[g_product_name])."', ";
            $sql2 .= "    '".addslashes($array[goods_cname])."' ";
            $sql2 .= ")";
            $sql2 .= ";";

            $result2 = Db_Query($db_con, $sql2);
            if($result2 == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }

            $pre_ware_id = $array['ware_id'];
/*
            //�ȥ�󥶥������λ
            Db_Query($db_con, "COMMIT;");

            //1.0.2(06-05-10) watanabe-k��ê��Ĵ��ɽ������ϼ����̤�����
            header("Location: ./2-4-201.php");
*/ 
       }

        //�ȥ�󥶥������λ
        Db_Query($db_con, "COMMIT;");

        //1.0.2(06-05-10) watanabe-k��ê��Ĵ��ɽ������ϼ����̤�����
        header("Location: $_SERVER[PHP_SELF]");
        exit();

        /*** ��������ê��Ĵ��ɽ�ξ��󡦰�����ɽ�� ***/
/*
        $array = Make_Utable($db_con, $_SESSION['client_id']);
        $row1 = $array[0];
        $row2 = $array[1];

        $disp_flg = "l";

        $form->setConstants(array("invent_cd" => "$row1[1]"));
*/
    }elseif($duplicate_err_mess != null){
        $disp_flg = 'l';
    }else{
        $disp_flg = 'u';

    }
//�֥��ꥢ�ץܥ��󤬲����줿
} else if($_POST["clear_button"] == "���ꥢ") {

    //�����̤�����
    header("Location: $_SERVER[PHP_SELF]");

//��Ĵ����áץܥ��󤬲����줿
} else if($_POST["delete_button"] == "Ĵ�����") {

    //���˺�����ޤ��Ϲ�������Ƥ��ʤ��������å���12-006��12-007��
    $sql  = "SELECT \n";
    $sql .= "    DISTINCT(renew_flg) \n";
    $sql .= "FROM \n";
    $sql .= "    t_invent \n";
    $sql .= "WHERE \n";
    $sql .= "    invent_no = '$_POST[invent_cd]' \n";
    $sql .= "    AND \n";
    $sql .= "    shop_id = $shop_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if(pg_num_rows($result) == 0){
        header("Location: $_SERVER[PHP_SELF]?err=del");
        exit();
    }elseif(pg_fetch_result($result, 0, 0) == "t"){
        header("Location: $_SERVER[PHP_SELF]?err=rnw");
        exit();
    }

    //ê���إå��ơ��֥뤫��ǡ�������
    $sql  = "DELETE FROM t_invent ";
    $sql .= "WHERE ";
    $sql .= "    invent_no = '$_POST[invent_cd]' ";
    $sql .= "AND ";
    $sql .= "    shop_id = $shop_id ";
    //$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

        //ê��Ĵ��ɽ�κ����ե������ɽ��
    $row1 = array($g_today);

    //
    $form->setConstants(array("form_target_goods" => "1"));

    $disp_flg = "u";

//���ɽ��
} else {

    //ê���������Ƥ��ʤ�Ĵ��ɽ�������硢ê��Ĵ��ɽ�ξ��󡦰�����ɽ��
    if(pg_num_rows(Get_Invent_Data($db_con, $_SESSION['client_id'])) != 0) {
        $array = Make_Utable($db_con, $_SESSION['client_id']);
        $row1 = $array[0];
        $row2 = $array[1];

        $disp_flg = "l";

        $form->setConstants(array("invent_cd" => "$row1[1]"));

    //ê���������Ƥ��ʤ�Ĵ��ɽ���ʤ���硢ê��Ĵ��ɽ�κ����ե������ɽ��
    } else {
        $row1 = array($g_today);

        if($_GET["invent_data"] == "0") {
            $row2 = array("ê�����ʥǡ���������ޤ���");
        } else {
            $row2 = null;
        }

        $disp_flg = "u";
    }
}

if($_GET["ware_id"]!=null){
	$ware_id = (int)$_GET["ware_id"];

    /** CSV����SQL **/
    $sql  = "SELECT ";
    $sql .= "t_contents.goods_cd,";      //���ʥ�����
    $sql .= "t_contents.goods_name,";    //����̾
    $sql .= "t_contents.stock_num,";     //Ģ����
    //$sql .= "t_contents.tstock_num,";    //��ê��
    $sql .= "t_invent.ware_name";        //�Ҹ�̾
    $sql .= " FROM ";
    $sql .= "t_invent, ";
    $sql .= "t_contents ";
    $sql .= "WHERE ";
    $sql .= "t_invent.invent_id = t_contents.invent_id ";
    $sql .= "AND ";
    $sql .= "t_invent.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "t_invent.invent_no = '$_GET[invent_no]' ";
    $sql .= "AND ";
    $sql .= "t_contents.add_flg = false ";

    /** ������ **/
    //ľ���襳���ɻ����̵ͭ
    if($ware_id != null && $ware_id != all){
        $sql .= "AND t_invent.ware_id = '$ware_id' ";
    }
    $sql .= "ORDER BY ";
    //$sql .= "t_invent.ware_id,t_contents.goods_cd;";
    $sql .= "t_invent.ware_cd, ";
    $sql .= "t_contents.g_product_cd, ";
    $sql .= "t_contents.goods_cd ";
    $sql .= ";";

    $result = Db_Query($db_con,$sql);

    //CSV�ǡ�������
    $i=0;
    while($data_list = pg_fetch_array($result)){
        //�Ҹ�̾
        $direct_data[$i][0] = $data_list[3];
        //���ʥ�����
        $direct_data[$i][1] = $data_list[0];
        //����̾
        $direct_data[$i][2] = $data_list[1];
        //Ģ����
        $direct_data[$i][3] = $data_list[2];
        $i++;
    }

	//CSV�ե�����̾
	//�Ҹ˥��Ƚ��
	if($ware_id == "all"){
		//���Ҹ�
		$csv_file_name = "ê��Ĵ��ɼ".date("Ymd")."���Ҹ�.csv";
	}else{
		//���Ҹ�
		$csv_file_name = "ê��Ĵ��ɼ".date("Ymd").$direct_data[0][0].".csv";
	}
    //CSV�إå�����
    $csv_header = array(
        "�Ҹ�̾", 
        "���ʥ�����", 
        "����̾",
        "Ģ����",
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($direct_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}


//�Ҹ˰����Υơ��֥��ɽ��
$sql2  = "SELECT ";
$sql2 .= "    t_invent.invent_no ";
$sql2 .= "FROM ";
$sql2 .= "    t_invent ";
$sql2 .= "WHERE ";
$sql2 .= "    t_invent.renew_flg = 'f' ";
$sql2 .= "AND ";
$sql2 .= "    t_invent.shop_id = $shop_id ";
$sql2 .= ";";

$result2 = Db_Query($db_con, $sql2);
$invent_no = @pg_fetch_result($result2, 0, 0);


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
//$page_menu = Create_Menu_f('stock','2');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["4_201_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_205_button"]]->toHtml();
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
    'err_mess'      => "$err_mess",
    'invent_no'     => "$invent_no",
    'group_kind'    => "$group_kind",
));

//�ѿ���assign
$smarty->assign("data1", $row1);
$smarty->assign("data2", $row2);
$smarty->assign("disp", $disp_flg);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


/**
 *
 * ê��Ĵ��ɽ�˽��Ϥ��뾦�ʼ���SQL
 *
 * @param       resource    $db_con     DB���ͥ������
 * @param       int         $client_id  �����ID
 *
 * @return      resource    ��̥꥽����
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/04/27)
 *
 */
function Get_Invent_Data($db_con, $client_id) {

    //ê��Ĵ��ɽ�ֹ桢ê�������оݾ��ʼ���
    $sql  = "SELECT ";
    $sql .= "    distinct ";
    $sql .= "    invent_no, ";
    $sql .= "    expected_day, ";
    $sql .= "    target_goods ";
    $sql .= "FROM ";
    $sql .= "    t_invent ";
    $sql .= "WHERE ";
    $sql .= "    shop_id = $client_id ";
    //$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $client_id ";
    $sql .= "AND ";
    $sql .= "    renew_flg = 'f' ";
    $sql .= ";";

    return Db_Query($db_con, $sql);

}


/**
 *
 * ê��Ĵ��ɽ�������ɽ������ơ��֥�Υǡ�������
 *
 * @param       resource    $db_con     DB���ͥ������
 * @param       int         $client_id  �����ID
 *
 * @return      array       �ơ��֥�Υǡ���
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/04/27)
 *
 */
function Make_Utable($db_con, $client_id) {

    $result = Get_Invent_Data($db_con, $client_id);

    //�оݾ��ʤ򥳡��ɤ���ʸ�����
    if(pg_fetch_result($result, 0, "target_goods") == 1) {
        $str = "������";
    } elseif (pg_fetch_result($result, 0, "target_goods") == 2) {
        $str = "�߸˿�0�ʳ�";
    } else if (pg_fetch_result($result, 0, "target_goods") == 3) {
        $str = "�߸˿�0";
    }

    $row1 = array(
        pg_fetch_result($result, 0, "expected_day"), 
        pg_fetch_result($result, 0, "invent_no"), 
        $str
    );


    //�Ҹ˰����Υơ��֥��ɽ��
    $sql2  = "SELECT ";
    $sql2 .= "    t_invent.invent_no, ";
    $sql2 .= "    t_invent.ware_id, ";
    $sql2 .= "    t_invent.ware_name, ";

    //1.0.3(06-05-10) watanabe-k��ê�����Ϥ򤷤Ƥ��ʤ����Ϻ��۰�����󥯤�ɽ�����ʤ���
/*
    $sql2 .= "    CASE";
    $sql2 .= "       WHEN exec_day IS NULL THEN 'f'";
    $sql2 .= "       ELSE 't'";
    $sql2 .= "    END AS input_flg, ";
*/
    $sql2 .= "    CASE contents1.all_num ";
    $sql2 .= "       WHEN contents2.input_num THEN true ";  //�������ê���»ܼԤ����Ϥ���Ƥ�쥳���ɿ���Ʊ���������ϴ�λ
    $sql2 .= "       ELSE false ";                          //����ʳ��Ϥޤ�
    $sql2 .= "    END AS input_flg, ";

    $sql2 .= "    CASE ";
    $sql2 .= "        WHEN contents2.input_num = contents1.all_num THEN false ";    //�������ê���»ܼ����ϥ쥳���ɿ���Ʊ�����������ϡˤϴ�λ
    $sql2 .= "        WHEN contents2.input_num IS NULL THEN false ";                //ê���»ܼ����ϥ쥳���ɿ���null������̤���ϡˤ�̤
    $sql2 .= "        ELSE true ";                                                  //����ʳ����������ê���»ܼ����ϥ쥳���ɿ����ۤʤ�ˤϰ������
    $sql2 .= "    END AS temp_flg ";    //������ϥե饰

    $sql2 .= "FROM ";
    $sql2 .= "    t_invent ";
    $sql2 .= "    INNER JOIN ";
    $sql2 .= "    ( ";
    $sql2 .= "        SELECT ";
    $sql2 .= "            invent_id, ";
    $sql2 .= "            COUNT(goods_id) AS all_num ";
    $sql2 .= "        FROM ";
    $sql2 .= "            t_contents ";
    $sql2 .= "        GROUP BY ";
    $sql2 .= "            invent_id ";
    $sql2 .= "    ) AS contents1 ON t_invent.invent_id = contents1.invent_id ";
    $sql2 .= "    LEFT JOIN ";
    $sql2 .= "    ( ";
    $sql2 .= "        SELECT ";
    $sql2 .= "            invent_id, ";
    $sql2 .= "            COUNT(goods_id) AS input_num ";
    $sql2 .= "        FROM ";
    $sql2 .= "            t_contents ";
    $sql2 .= "        WHERE ";
    $sql2 .= "            staff_id IS NOT NULL ";
    $sql2 .= "        GROUP BY ";
    $sql2 .= "            invent_id ";
    $sql2 .= "    ) AS contents2 ON t_invent.invent_id = contents2.invent_id ";

    $sql2 .= "WHERE ";
    $sql2 .= "    t_invent.renew_flg = 'f' ";
    $sql2 .= "AND ";
    $sql2 .= "    t_invent.shop_id = $client_id ";
//    $sql2 .= ($group_kind == "2") ? " t_invent.shop_id IN (".Rank_Sql().") " : " t_invent.shop_id = $client_id ";
    $sql2 .= "ORDER BY t_invent.ware_cd ";
    $sql2 .= ";";

    $result2 = Db_Query($db_con, $sql2);

/*
    while($array = pg_fetch_array($result2)) {
        $row2[] = array($array["invent_no"], $array["ware_id"], $array["ware_name"], $array["input_flg"]);
    }
*/
    $row2 = Get_Data($result2);

    return array($row1, $row2);

}


?>