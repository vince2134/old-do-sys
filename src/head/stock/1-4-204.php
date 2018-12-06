<?php
/**
 *
 * ê������ input stocktaking result
 *
 *
 *
 *
 *
 *
 *
 *   !! ������FC���̤Ȥ��Ʊ�����������ƤǤ� !! same source hq and fc
 *   !! �ѹ�������������򤤤��ä�¾���˥��ԤäƤ������� !!
 *
 *
 *
 *
 *
 *
 *
 *
 * 1.0.0 (2006/04/27) ��������
 * 1.1.0 (2006/07/10) shop_gid��ʤ���
 * 1.1.1 (2006/07/11) ê������ľ����ê���إå����ä��줿���˽��������Ǥ���
 * 1.1.2 (2006/09/19) (kaji)
 *   ������ID����Ф��������ʤ��Ȥޤ����ä��Τ���
 * 1.2.0 (2006/10/19) (kaji)
 *   ��������ͳ��߸�Ĵ����Ĵ����ͳ��Ʊ����
 *   �������ɲû��˺߸�ñ���ǤϤʤ�������ñ����ɽ�����Ƥ����Τ���
 *   �������ɲû���ê�����κ߸˿��ǤϤʤ������ߤκ߸˿���������Ƥ����Τ���
 *   ������ʬ���ɽ������褦�ˤ���
 *   �����˥�������
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.x.x (2006/12/28)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/07      02-008      kajioka-h   �߸˴������ʤ����ʤϥ���������ɽ�����ʤ�
 *                  02-009      kajioka-h   �����Ѥ�ê������Ͽ�Ǥ��ʤ��褦��
 *                  02-010      kajioka-h   ê���»ܼ԰�����곫�ϹԤο��ͥ����å��ɲ�
 *                  02-011      kajioka-h   ê���»ܼ԰�����꽪λ�Ԥο��ͥ����å��ɲ�
 *                  02-012      kajioka-h   ê�������Ѥ�ê����TOP�����Ф�
 *                  02-021      kajioka-h   ̤��ǧ�ξ��ʤ�ɽ�����ʤ��褦��
 *                  02-022      kajioka-h   ¸�ߤ��ʤ����ʥ��������ϻ��ξ���ʬ������
 *                  ssl-0042    kajioka-h   ��Ͽ�������۸�������������ʤ��Τ���
 *                  ssl-0043    kajioka-h   �߸�ñ��������Ʊ����ۤ���Ͽ����Ƥ��ޤ��Х�����
 *                  ssl-0051    kajioka-h   ���ʥ����������Ϥ���������
 *  2006/12/08      02-024      kajioka-h   �������ê��Ĵ��ɽ�����ľ����Ƥ��ʤ��������å�����������ɲ�
 *  2006/12/21      xx-xxx      kajioka-h   ɽ������Ҹˡ�����ʬ�ࡢ����CD�ˤ���
 *                  0002,0003   kajioka-h   �����ɲû���ɽ�������߸˿���ê��Ĵ��ɽ�������ְ����פǤϤʤ��֤�����פˤʤäƤ����Τ�����SQL��=ȴ����
 *  2006/12/28      xx-xxx      kajioka-h   ɽ���Ϥ��ʤ���DB����Ͽ������ܤ�hidden����SESSION�˻�������褦���ѹ�
 *                  xx-xxx      kajioka-h   ���ʤι�������toHtml����Smarty�ǥ롼�פ���褦���ѹ�
 *                  xx-xxx      kajioka-h   ê���»ܼԤΥ��쥯�ȥܥå�����1�Ԥ���setConstants���Ƥ����Τ�ޤȤ�Ƥ���褦���ѹ�
 *                  xx-xxx      kajioka-h   �߸�ñ����addGroup���Ƥ����Τ����������������Ǥ��줾��addElement����褦���ѹ�
 *                  xx-xxx      kajioka-h   �ƥ�ץ�¦��HTML�Υ������򸺤餹�ʥ���ǥ�Ȥ��ʤ���align��ʤ����ʤɡ�
 *                  xx-xxx      kajioka-h   ������FC�ǥ⥸�塼���Ʊ���ˤ�����SESSION��group_kind���������̤�FC���̤�����̡�
 *  2007/01/22      xx-xxx      kajioka-h   �����Ͽ�ܥ����ɲáʺ߸�ñ������ê����ê���»ܼԡ����۸�����ɬ�ܥ����å��򤻤�����Ͽ�ġ�
 *                  xx-xxx      kajioka-h   ê���»ܼ԰������Ƕ����������Ǥ���褦���ѹ�
 *  2007/05/14      ����¾92    kajioka-h   50�Ԥ��Ȥ�ɽ������Ͽ��ǽ��
 *                  ����¾92    kajioka-h   50�Ԥ��Ȥ�ɽ������Ͽ��ǽ�ˤ������ᡢ�����Ͽ��ǽ���
 *                  xx-xxx      kajioka-h   ê���»��������Ϥ�ʤ��ˡ�ê��Ĵ��ɽ��������ɽ��
 *  2007/05/15      xx-xxx      kajioka-h   �ڡ������ܻ����ˡ�ê���»ܼ԰������Ԥ˹��ֹ�򥻥åȤ���褦���ѹ�
 *                  B0702-053   kajioka-h   �����ɲ����ϻ����Ժ��������Υ��顼��å������ι��ֹ椬�ְ�äƤ���Х�����
 *                  B0702-054   kajioka-h   �����ɲ����ϻ����Ժ���������ê���»ܼ԰������򤹤�ȡ�����Ȥϰۤʤ�Ԥ����ꤵ���Х�����
 *  2007/05/18      xx-xxx      kajioka-h   ���۸����ˡ�Ĵ���פ��ɲ�
 *  2007/06/18      B0702-061   kajioka-h   �����ɲû��˲����ɲä�������Ͽ����ȥ��顼�ˤʤ�Τ���
 *  2009/10/09                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 */


$page_title = "ê������";

//�Ķ�����ե����� env setting file
require_once("ENV_local.php");

//echo microtime()."<br>";

//HTML_QuickForm����� create
$form =& new HTML_QuickForm("$_SERVER[PHP_SELF]", "POST");

//DB��³ connect
$db_con = Db_Connect();

// ���¥����å� auth check
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;



/****************************/
//�����ѿ����� acqiurie external variable
/****************************/

$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

$error_flg  = false;


//Ĵ��ɽ�ֹ� survey chart number
($_GET["invent_no"] == null || $_GET["ware_id"] == null) ? header("Location: ../top.php") : null;


//-------------------------//
//���� setting
//-------------------------//

//ɽ���Կ� display item row
$limit = 50;

//�������� hq screen
if($group_kind == "1"){
    //ê��Ĵ��ɽ�������������̤�URL�����ܥ����ѡ�create stocktaking survey chart/url for the list screen (for the back button)
    $pre_url = "1-4-201.php";
    //���ʰ�������������URL url for the product list dialogue
    $dialog_goods_url = "../dialog/1-0-210.php";
    //��Ͽ��������URL URL for the page that will be transitioned to after registration
    $transition_url = "./1-4-201.php";
//FC���� FC screen
}else{
    //ê��Ĵ��ɽ�������������̤�URL�����ܥ����ѡ�create stocktaking survey chart/url for the list screen (for the back button)
    $pre_url = "2-4-201.php";
    //���ʰ�������������URL url for the product list dialogue
    $dialog_goods_url = "../dialog/2-0-210.php";
    //��Ͽ��������URL URL for the page that will be transitioned to after registration
    $transition_url = "./2-4-201.php";
}


/****************************/
//ê��Ĵ��ID���� acquire stocktaking survey ID
/****************************/

$sql  = "SELECT ";
$sql .= "    t_invent.invent_id, ";
$sql .= "    MAX(t_invent.expected_day), ";
$sql .= "    MAX(t_invent.enter_day), ";
$sql .= "    COUNT(t_contents.goods_id) ";
$sql .= "FROM ";
$sql .= "    t_invent ";
$sql .= "    INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
$sql .= "WHERE ";
$sql .= "    t_invent.invent_no = '".$_GET["invent_no"]."' ";
$sql .= "AND ";
$sql .= "    t_invent.ware_id = ".(int)$_GET["ware_id"]." ";
$sql .= "AND ";
$sql .= "    t_invent.shop_id = $shop_id ";
$sql .= "AND ";
$sql .= "    t_contents.add_flg = false ";
$sql .= "GROUP BY ";
$sql .= "    t_invent.invent_id ";
$sql .= ";";

$result = Db_Query($db_con, $sql);
if($result == false) {
    //Db_Query($db_con, "ROLLBACK;");
    exit();
}
Get_Id_Check($result);

$invent_id = pg_fetch_result($result, 0, 0);    //ê��Ĵ��ID stocktaking surver ID
$expected_day = pg_fetch_result($result, 0, 1); //ê���� stocktaking day 
//�ǽ�˲��̤򳫤����Ȥ��ˡ���Ͽ���������hidden���ݻ� acquire and store the registration date in hidden when the screen opened the first time
if($_POST["hdn_enter_day"] == null){
    $enter_day = pg_fetch_result($result, 0, 2);    //��Ͽ�� registration date
    $form->setDefaults(array("hdn_enter_day" => "$enter_day"));
}else{
    $enter_day = $_POST["hdn_enter_day"];
}
$contents_num = pg_fetch_result($result, 0, 3);     //Ĵ��ɽ�������ξ��ʿ� number of products when the survey chart was created

//1.1.1 2006-07-11 kaji
//Ĵ����åܥ��󤬲����줿��ê���إå����ä��줿�˾�硢���������� stop the process when the survey cancel button is pressed (the stocktaking header was erased
if($invent_id === false){
    exit();
}


/****************************/
//���۸������쥯�ȥܥå����� for the cause of difference select box
/****************************/

$select_reason = array(
    0 => "",
    //1 => "�����ƥ೫�Ϻ߸�", system start stock
    2 => "��»",
    3 => "ʶ��",
    4 => "ȯ��",
    7 => "Ĵ��",
    5 => "�߸˵����ߥ�",
);



/*****************************/
//���ʥ��������� input product code
/*****************************/

if($_POST["goods_search_row"] != null){

    $row = $_POST["goods_search_row"];

    $sql  = "SELECT \n";
    $sql .= "    t_goods.goods_cd, \n";     //0
    $sql .= "    t_goods.goods_name, \n";   //1
    $sql .= "    t_goods.unit, \n";         //2
    $sql .= "    t_price.r_price, \n";      //3
    $sql .= "    t_g_goods.g_goods_cd, \n"; //4
    $sql .= "    t_g_goods.g_goods_name, \n";   //5
    $sql .= "    t_goods.goods_id, \n";         //6
    $sql .= "    t_g_product.g_product_id, \n"; //7
    $sql .= "    t_g_product.g_product_cd, \n"; //8
    $sql .= "    t_g_product.g_product_name, \n";   //9
    $sql .= "    t_goods.goods_cname, \n";      //10
    $sql .= "    t_product.product_cd, \n";     //11
    $sql .= "    t_product.product_name \n";    //12
    $sql .= "FROM \n";
    $sql .= "    t_price \n";
    $sql .= "    INNER JOIN t_goods ON t_price.goods_id = t_goods.goods_id \n";
    $sql .= "    INNER JOIN t_g_goods ON t_g_goods.g_goods_id = t_goods.g_goods_id \n";
    $sql .= "    INNER JOIN t_g_product ON t_g_product.g_product_id = t_goods.g_product_id \n";
    $sql .= "    INNER JOIN t_product ON t_product.product_id = t_goods.product_id \n";
    #2009-10-09 hashimoto-y
    $sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

    $sql .= "WHERE \n";
    $sql .= "        t_goods.goods_cd = '".$_POST["form_goods_cd"][$row]."' \n";
    $sql .= "    AND \n";
    #2009-10-09 hashimoto-y
    #$sql .= "        t_goods.stock_manage = '1' \n";
    $sql .= "        t_goods_info.stock_manage = '1' \n";
    $sql .= "    AND \n";
    $sql .= "        t_goods_info.shop_id = $shop_id ";

    $sql .= "    AND \n";
    $sql .= ($group_kind == "1") ? "        t_price.rank_cd = '1' \n" : "        t_price.rank_cd = '3' \n"; //�������ղá�FC�Ϻ߸�ñ��
    $sql .= "    AND \n";
    $sql .= "        t_goods.accept_flg = '1' \n";
    $sql .= "    AND \n";
    //�����ξ�� if HQ
    if($group_kind == "1"){
        $sql .= "        t_goods.state IN ('1', '3') \n";
        $sql .= "    AND \n";
        $sql .= "        CASE t_goods.public_flg \n";
        $sql .= "            WHEN true THEN t_price.shop_id = $shop_id \n";
        $sql .= "            WHEN false THEN t_goods.shop_id = $shop_id \n";
        $sql .= "        END \n";
    //ľ�Ĥξ�� IF HQ (directly managed store)
    }elseif($group_kind == "2"){
        $sql .= "        t_goods.state IN ('1', '3') \n";
        $sql .= "    AND \n";
        $sql .= "        CASE t_goods.public_flg \n";
        $sql .= "            WHEN true THEN t_price.shop_id IN (".Rank_Sql().") \n";
        $sql .= "            WHEN false THEN t_goods.shop_id IN (".Rank_Sql().") \n";
        $sql .= "        END \n";
    //FC�ξ�� If FC
    }else{
        $sql .= "        t_goods.state = '1' \n";
        $sql .= "    AND \n";
        $sql .= "        CASE t_goods.public_flg \n";
        $sql .= "            WHEN true THEN t_price.shop_id = $shop_id \n";
        $sql .= "            WHEN false THEN t_goods.shop_id = $shop_id \n";
        $sql .= "        END \n";
    }
    $sql .= ";\n";
//print_array($sql, "�����ɲ�SQL");

    $result = Db_Query($db_con, $sql);

    if(pg_num_rows($result) == 1){
        $array_db = Get_Data($result, 2);
//print_array($array_db, "�����ɲ�array");

        $set_goods_data["form_goods_cd"][$row] = $array_db[0][0];
        $set_goods_data["form_goods_name"][$row] = $array_db[0][1];
        $set_goods_data["form_unit"][$row] = $array_db[0][2];

        $temp = explode(".", $array_db[0][3]);
        $set_goods_data["form_price"][$row]["i"] = $temp[0];
        $set_goods_data["form_price"][$row]["d"] = $temp[1];

        $set_goods_data["form_g_product_cd"][$row] = $array_db[0][8];
        $set_goods_data["form_g_product_name"][$row] = $array_db[0][9];
        $set_goods_data["form_goods_cname"][$row] = addslashes($array_db[0][10]);
        $set_goods_data["form_product_cd"][$row] = $array_db[0][11];
        $set_goods_data["form_product_name"][$row] = addslashes($array_db[0][12]);

        $set_goods_data["form_add_flg"][$row] = "true";             //�ɲåե饰 add flag


        //ê�����κ߸˿������ acquire the number of units in inventory at the date of stocktaking
        $sql  = "SELECT \n";
        $sql .= "    COALESCE( \n";
        $sql .= "        SUM(num * \n";
        $sql .= "            CASE io_div \n";
        $sql .= "                WHEN 1 THEN  1 \n";
        $sql .= "                WHEN 2 THEN -1 \n";
        $sql .= "            END \n";
        $sql .= "        ), 0 \n";
        $sql .= "    ) AS stock_num \n";
        $sql .= "FROM \n";
        $sql .= "    t_stock_hand \n";
        $sql .= "WHERE \n";
        $sql .= "    work_div NOT IN (1,3) \n";
        $sql .= "    AND \n";
        $sql .= "    work_day <= '$expected_day' \n";
        $sql .= "    AND \n";
        $sql .= "    goods_id = ".$array_db[0][6]." \n";
        $sql .= "    AND \n";
        $sql .= "    ware_id = ".(int)$_GET["ware_id"]." \n";
//        $sql .= "    AND \n";
//        $sql .= "    shop_id = $shop_id \n";
        $sql .= ";\n";
//print_array($sql);

        $result = Db_Query($db_con, $sql);
        if(pg_num_rows($result) == 1){
            $array_db2 = Get_Data($result, 2);

            $set_goods_data["form_stock_num"][$row] = $array_db2[0][0];
            $set_goods_data["form_tstock_num"][$row] = $array_db2[0][0];
            $set_goods_data["form_diff_num"][$row] = "0";
        }else{
            $set_goods_data["form_stock_num"][$row] = "0";
            $set_goods_data["form_tstock_num"][$row] = "0";
            $set_goods_data["form_diff_num"][$row] = "0";
        }

        $set_goods_data["form_g_goods_cd"][$row] = $array_db[0][4];
        $set_goods_data["form_g_goods_name"][$row] = $array_db[0][5];
    }else{
        //�������뾦�ʤ�¸�ߤ��ʤ���硢�ե���������� if there is no product applicable then initialize the form
        $set_goods_data["form_g_product_name"][$row] = "";

        $set_goods_data["form_goods_cd"][$row] = "";

        $set_goods_data["form_goods_name"][$row] = "";
        $set_goods_data["form_unit"][$row] = "";

        $set_goods_data["form_price"][$row]["i"] = "";
        $set_goods_data["form_price"][$row]["d"] = "";

        $set_goods_data["form_stock_num"][$row] = "";
        $set_goods_data["form_tstock_num"][$row] = "";
        $set_goods_data["form_diff_num"][$row] = "";

        $set_goods_data["form_g_goods_cd"][$row] = "";
        $set_goods_data["form_g_goods_name"][$row] = "";

        $set_goods_data["form_add_flg"][$row] = "";             //�ɲåե饰 add flag
    }

    $set_goods_data["goods_search_row"] = "";
    $form->setConstants($set_goods_data);

}	//���ʥ��������Ͻ���� done product code input



/*****************************/
//ê���»ܼ԰���������������set the stocktaker all at once (preprocess)
/*****************************/

$staff_set   = null;
if($_POST["form_conf_button"] == "�������"){
    $line_start = $_POST["form_line"]["start"];
    $line_end   = $_POST["form_line"]["end"];
    if(mb_ereg("[^0-9]", $line_start) == 1 || mb_ereg("[^0-9]", $line_end) == 1 || $line_start == null || $line_end == null){
        $staff_line_err = "�������˻��ꤹ��Կ���Ⱦ�ѿ��ͤΤߤǤ���";
    //}elseif($_POST["form_staff_set"] == null){
    //    $staff_select_err = "������ꤹ��ê���»ܼԤ����ꤷ�Ƥ���������";
    }else{
        $staff_set = $_POST["form_staff_set"];
    }
}



/*****************************/
//��Ͽ���� registration process
/*****************************/

//if($_POST["form_entry_button"] == "�С�Ͽ"){
//if($_POST["form_entry_button"] == "�С�Ͽ" || $_POST["form_temp_button"] == "�����Ͽ"){
//��Ͽ�������ء���Ͽ���Ƽ��ء���Ͽ���ƾ����ɲá���Ͽ��λ�ܥ��󤬲�����Ƥ��ơ����ʥ����ɤ�����Ǥ����Ȥ�
//if(($_POST["form_entry_back"] != null || $_POST["form_entry_next"] != null || $_POST["form_entry_button"] != null || $_POST["form_entry_add_button"] != null) && $_POST["form_goods_cd"] != null){
//��Ͽ�������ء���Ͽ���Ƽ��ء���Ͽ���ƾ����ɲá���Ͽ��λ�ܥ��󤬲�����Ƥ� when the register then go back, register then go next, or done registration is pressed
if($_POST["form_entry_back"] != null || $_POST["form_entry_next"] != null || $_POST["form_entry_button"] != null || $_POST["form_entry_add_button"] != null){


    //���ʥ����ɤ�����Ǥ��� the product code returned 
    if($_POST["form_goods_cd"] != null){

        //POST������Ǥ������ֹ���� acquire the row number that was returned by POST
        $line_no = array_keys($_POST["form_goods_cd"]);

        //�Կ� row number
        $row_num = $_POST["offset_line"];


        //-- ���顼�����å�(PHP) error check--//
        //for($i=0,$error_flg=false;$i<$line_count;$i++){
        foreach($_POST["form_goods_cd"] as  $line => $goods_cd){

            //���ֹ� row number
            $row_num++;
            $array_row_num[$line] = $row_num;   //���ֹ�����ʥ��顼�����å��ǻȤ��� array of the row number (use in the error check)


            //Ĵ��ɽ�������ξ��ʡ��ޤ��Ͼ����ɲò��̤Ǿ��ʥ����ɤ����ǤϤʤ��Ԥ��������å� only check the rows where the product code in the add product screen or the product field at the time of creating stocktaking survery  is not blank
            if($_POST["add_flg"] == "false" || ($_POST["add_flg"] == "true" && $_POST["form_goods_cd"][$line] != "")){

                //�߸�ñ�������å� check the price per units of the stock
                if(!ereg("^[0-9]+$",$_POST["form_price"][$line]["i"]) || !ereg("^[0-9]+$",$_POST["form_price"][$line]["d"])){
                    $price_error_mess .= ($row_num)."���� �߸�ñ����Ⱦ�ѿ����ΤߤǤ���<br>";
                    $error_flg = true;
                }

                //��ê�������å� check the actual number of units 
                if(!ereg("^[\-]?[0-9]+$",$_POST["form_tstock_num"][$line])){
                    $tstock_error_mess .= ($row_num)."���� ��ê����Ⱦ�ѿ����ΤߤǤ���<br>";
                    $error_flg = true;
                }

                //ê���»ܼԥ����å� check the stocktaker
                if($_POST["form_staff"][$line] == ""){
                    $staff_error_mess .= ($row_num)."���� ê���»ܼԤ����򤷤Ƥ���������<br>";
                    $error_flg = true;
                }

                //���۸�����Ͽ�����å� check if the cause of difference was registered
                if($_POST["form_diff_num"][$line] != 0 && $_POST["form_cause"][$line] == 0){
                    $cause_error_mess .= ($row_num)."���� ���۸��������򤷤Ƥ���������<br>";
                    $error_flg = true;
                }


                //���ʥ����ɤ����ǤϤʤ���Τ������� acquire the ones which the product code is not a blank
                $array_goods_cd[$line] = $_POST["form_goods_cd"][$line];

                //���������������Ȥ����Ϥ���Ƥ������ñ������� acquire the price per unit of product when the integer and the decimal is inputted 
                if($_POST["form_price"][$line]["i"] != null && $_POST["form_price"][$line]["d"] != null){
                    $stock_price[$line]  = $_POST["form_price"][$line]["i"];
                    $stock_price[$line] .= ".";
                    $stock_price[$line] .= str_pad($_POST["form_price"][$line]["d"], 2, 0, STR_PAD_RIGHT);
                }else{
                    $stock_price[$line]  = null;
                }

            }

        }
//print_array($array_row_num, "���ֹ�");
//print_array($empty_line, "����");
//print_array($array_goods_cd);

    }


    $goods_count = count($array_goods_cd);      //���Ͼ��ʿ� number of products inputted


    //�����ɲò��̤Ǿ��ʤ����Ϥ�������Υ����å� check for when there is an input of product in the add product screen
    if($_POST["add_flg"] == "true" && $goods_count != 0){

        $injustice_error_mess = "";
        $goods_cd_str = "";
        foreach($array_goods_cd as $line => $goods_cd){

            //����̾������� acquire the product name
            $sql  = "SELECT \n";
            $sql .= "    t_goods.goods_id, \n";             //����ID product ID
            $sql .= "    t_goods.goods_name, \n";           //����̾ prodct name
            $sql .= "    t_goods.goods_cname, \n";          //����̾��ά�Ρ� prodct name (abbreviation)
            $sql .= "    t_g_goods.g_goods_cd, \n";         //�Ͷ�ʬCD M classification code
            $sql .= "    t_g_goods.g_goods_name, \n";       //�Ͷ�ʬ̾ M classification name
            $sql .= "    t_product.product_cd, \n";         //������ʬCD mgt classification Code
            $sql .= "    t_product.product_name, \n";       //������ʬ̾ mgt classification name
            $sql .= "    t_g_product.g_product_cd, \n";     //����ʬ��CD product type code
            $sql .= "    t_g_product.g_product_name \n";    //����ʬ��̾ product type name
            $sql .= "FROM \n";
            $sql .= "    t_goods \n";
            $sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";
            $sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
            $sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
            $sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            $sql .= "WHERE \n";
            $sql .= "    t_goods.goods_cd = '".$goods_cd."' \n";
            $sql .= "    AND \n";
            if($group_kind == "2"){
                $sql .= "            t_goods_info.shop_id IN (".Rank_Sql().") \n";
            }else{
                $sql .= "    t_goods_info.shop_id = $shop_id \n";
            }
            $sql .= ";";
//print_array($sql);

            $result = Db_Query($db_con, $sql);

            //�����ǡ�����¸�ߤ��ʤ���硢���顼 error if there is no data that match
            if(pg_num_rows($result) != 1){
                $injustice_error_mess .= $array_row_num[$line]."���� ";
                $error_flg = true;

            //�ǡ�����1�濫��Ȥ� if there is one data match
            }else{
                //��Ͽ���˻Ȥ��ǡ������� acquire the data that will be used for registration
                $array_goods_id[$line]          = pg_fetch_result($result, 0, "goods_id");
                $array_goods_name[$line]        = pg_fetch_result($result, 0, "goods_name");
                $array_goods_cname[$line]       = pg_fetch_result($result, 0, "goods_cname");
                $array_g_goods_cd[$line]        = pg_fetch_result($result, 0, "g_goods_cd");
                $array_g_goods_name[$line]      = pg_fetch_result($result, 0, "g_goods_name");
                $array_product_cd[$line]        = pg_fetch_result($result, 0, "product_cd");
                $array_product_name[$line]      = pg_fetch_result($result, 0, "product_name");
                $array_g_product_cd[$line]      = pg_fetch_result($result, 0, "g_product_cd");
                $array_g_product_name[$line]    = pg_fetch_result($result, 0, "g_product_name");

                //Ĵ��ɽ�������ξ��ʤȤν�ʣ�����å��˻Ȥ�  use for duplication check against the product when the stocktaking survey was created
                $goods_cd_str .= "'$goods_cd', ";
            }

        }

        $injustice_error_mess .= ($injustice_error_mess != "") ? "���ʾ��󤬼����Ǥ��ޤ���Ǥ�������������ԤäƲ�������" : "";

        $goods_cd_str = substr($goods_cd_str, 0, strlen($goods_cd_str) - 2);

        //���Ͼ��ʤ�Ʊ�����ʥ����ɤ���Ĵ��ɽ�������ˤʤ��� is there a same product code of the product inputted when the stocktaking survey was created
        $sql  = "SELECT \n";
        $sql .= "    t_contents.goods_cd \n";
        $sql .= "FROM \n";
        $sql .= "    t_invent \n";
        $sql .= "    INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
        $sql .= "WHERE \n";
        $sql .= "    t_invent.invent_id = $invent_id \n";
        $sql .= "    AND \n";
        $sql .= "    t_contents.goods_cd IN ($goods_cd_str) \n";
        $sql .= "    AND \n";
        $sql .= "    t_contents.add_flg = false \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        //��ʣ�������� if there is duplication
        $same_goods_count = pg_num_rows($result);
        for($i=0, $db_unique_error_mess=""; $i<$same_goods_count; $i++){
            //��ʣ�������ʤ� ����CD[���ֹ�] ����� acquire the product code (row number) of the product that was a duplicate
            $array_same_line = array_intersect($array_goods_cd, array(pg_fetch_result($result, $i, 0)));

            //���ֹ����󤫤顢No.����� extract the no. from the row number array
            foreach($array_same_line as $key => $value){
                $db_unique_error_mess .= $array_row_num[$key]."���� ";
            }

            $error_flg = true;
        }
        $db_unique_error_mess .= ($same_goods_count != 0) ? "�ξ��ʤ�ê��Ĵ��ɽ��¸�ߤ��뤿�ᡢ�ɲäǤ��ޤ���<br>" : "";
//print_array($db_unique_error_mess, "Ĵ��ɽ�Ƚ�ʣ�����å�");


        //�ɲþ��ʤ���ν�ʣ�����å� check if there is duplication in the added product
        $diff_array = array_diff_assoc($array_goods_cd, array_unique($array_goods_cd));
        $diff_array_unique = array_unique($diff_array);     //3�İʾ夫�֤äƤ뤫�⤷��ʤ��Τǡ���ʣ��Ϥ֤� take out the duplication because there might be 3 or more duplications
        foreach($diff_array_unique as $value){
            $diff_array_keys = array_keys($array_goods_cd, $value);
            foreach($diff_array_keys as $value2){
                $unique_error_mess .= $array_row_num[$value2]."���� ";
            }
            $unique_error_mess .= "�ξ��ʤ���ʣ���Ƥ��ޤ���<br>";
            $error_flg = true;
        }

    }
//print_array($unique_error_mess, "�ɲþ��ʤν�ʣ�����å�");


    //��������Ƥ��ʤ��������å� check if its not duplicated
    $sql  = "SELECT ";
    $sql .= "    renew_flg ";
    $sql .= "FROM ";
    $sql .= "    t_invent ";
    $sql .= "WHERE ";
    $sql .= "    invent_id = $invent_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if(pg_fetch_result($result, 0, 0) == "t"){
        $renew_err_mess = "����ê��Ĵ��ɽ�ϴ���ê����������Ƥ��ޤ���";
        $error_flg = true;
    }

    //ê���������Ĵ��ɽ�������ƺ�������Ƥʤ��������å� check if the survey charrt is not being deleted or recreated when the stocktaking input is happening
    if(Update_Check($db_con, "t_invent", "invent_id", $invent_id, $enter_day) == false && $error_flg == false){
        $remake_err_mess = "ê��Ĵ��ɽ���ѹ�����Ƥ��뤿�ᡢ��Ͽ�Ǥ��ޤ���";
        $error_flg = true;
    }
//echo "���顼�����å������";exit();


    $error_flg = ($form->validate()) ? $error_flg : false;


    //���顼�ξ��Ϥ���ʹߤν�����Ԥʤ�ʤ� if its an error then do not proceed with the proces
    if($error_flg == false){

        //-- ê�����ϥȥ�󥶥�����󳫻� start the input of stocktaking result transaction --//
        Db_Query($db_con, "BEGIN;");

        //ê���إå��ơ��֥빹�� update the stocktaking header table
        $sql  = "UPDATE ";
        $sql .= "    t_invent ";
        $sql .= "SET ";
        $sql .= "    staff_id = ".$_SESSION["staff_id"].", ";
        $sql .= "    staff_name = '".addslashes($_SESSION["staff_name"])."' ";
        $sql .= "WHERE ";
        $sql .= "    invent_id = $invent_id ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result == false) {
            Db_Query($db_con, "ROLLBACK;");
            exit();
        }


        //Ĵ��ɽ�ˤ��뾦�ʤ���Ͽ���� registration process for the product that is in the survey chart
        if($_POST["add_flg"] == "false"){

            foreach($array_goods_cd as $line => $goods_cd){
                $sql  = "UPDATE \n";
                $sql .= "    t_contents \n";
                $sql .= "SET \n";
                $sql .= "    tstock_num = ".$_POST["form_tstock_num"][$line].", \n";
                $sql .= "    price = ".$stock_price[$line].", \n";
                $sql .= "    staff_id = ".$_POST["form_staff"][$line].", \n";
                $sql .= "    staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = ".$_POST["form_staff"][$line]."), \n";
                $sql .= "    cause = "; 
                $sql .= ($_POST["form_cause"][$line] != null) ? "'".$select_reason[$_POST["form_cause"][$line]]."' \n" : "null \n"; 
                $sql .= "WHERE \n";
                $sql .= "    invent_id = $invent_id \n";
                $sql .= "    AND \n";
                $sql .= "    goods_cd = '$goods_cd' \n";
                $sql .= ";";
//print_array($sql);

                $result = Db_Query($db_con, $sql);
                if($result == false) {
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

            }

        //�ɲþ��ʤ���Ͽ���� registration processs for the added product
        }else{

            //�ɲþ��ʥǡ�������� delete all the added product data
            $sql = "DELETE FROM t_contents WHERE invent_id = $invent_id AND add_flg = true;";
            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }


            //�ɲþ��ʤ�0����ʤ����Τ���Ͽ register whne the added product is not 0
            if(count($array_goods_cd) > 0){

                foreach($array_goods_cd as $line => $goods_cd){

                    $sql  = "INSERT INTO \n";
                    $sql .= "    t_contents \n";
                    $sql .= "( \n";
                    $sql .= "    invent_id, \n";    //ê��Ĵ��ID 1 stocktaking survery ID 1 
                    $sql .= "    goods_id, \n";     //����ID 2 product ID 2
                    $sql .= "    stock_num, \n";    //Ģ��� 3 number of units in the books of account 3
                    $sql .= "    tstock_num, \n";   //��ê�� 4 actual number of units in the inventory 
                    $sql .= "    price, \n";        //ñ�� 5 price per unit
                    $sql .= "    staff_id, \n";     //��ê��ǧ��ID 6 stocktaker ID
                    $sql .= ($_POST["form_cause"][$line] != null) ? "    cause, \n" : "";   //���۸��� 7 reasong for difference
                    $sql .= "    goods_cd, \n";     //����CD 8 product code 8
                    $sql .= "    goods_name, \n";   //����̾ 9 product name 9
                    $sql .= "    staff_name, \n";   //��ê��ǧ��̾ 10 stocktaker 10
                    $sql .= "    g_goods_cd, \n";   //�Ͷ�ʬCD 11 m classification
                    $sql .= "    g_goods_name, \n"; //�Ͷ�ʬ̾ 12 m classification name 12
                    $sql .= "    add_flg, \n";      //�ɲåե饰 13 add flag 13
                    $sql .= "    g_product_cd, \n"; //����ʬ��CD 14 product type code 14
                    $sql .= "    g_product_name, \n";   //����ʬ��̾ 15 product ype name 15
                    $sql .= "    goods_cname, \n";  //����̾��ά�Ρ�16 product name abbreviation 16
                    $sql .= "    product_cd, \n";   //������ʬCD 17 mgt classification code 17
                    $sql .= "    product_name \n";  //������ʬ̾ 18 mgt classification name 18

                    $sql .= ") VALUES ( \n";

                    $sql .= "    $invent_id, \n";                                       //ê��Ĵ��ID stocktaking suvey ID 1
                    $sql .= "    ".$array_goods_id[$line].", \n";                       //����ID 2 product ID 2
                    $sql .= "    ".$_POST["form_stock_num"][$line].", \n";              //Ģ��� 3 number of units in the books of account 3
                    $sql .= "    ".$_POST["form_tstock_num"][$line].", \n";             //��ê�� 4 actual number of units in the inventory
                    $sql .= "    ".$stock_price[$line].", \n";                          //ñ�� 5 price per unit
                    $sql .= "    ".$_POST["form_staff"][$line].", \n";                  //��ê��ǧ��ID 6 stocktaker ID
                    $sql .= ($_POST["form_cause"][$line] != null) ? "    '".$select_reason[$_POST["form_cause"][$line]]."', \n" : "";   //���۸��� 7 reasong for differen
                    $sql .= "    '".$goods_cd."', \n";                                  //����CD 8 product code 8
                    $sql .= "    '".addslashes($array_goods_name[$line])."', \n";       //����̾ 9 product name 9
                    $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = ".(int)$_POST["form_staff"][$line]."), \n";      //��ê��ǧ��̾ 10 stocktaker 10
                    $sql .= "    '".$array_g_goods_cd[$line]."', \n";                   //�Ͷ�ʬCD 11 m classification
                    $sql .= "    '".addslashes($array_g_goods_name[$line])."', \n";     //�Ͷ�ʬ̾ 12 m classification name 12
                    $sql .= "    true, \n";                                             //�ɲåե饰 13 add flag 13
                    $sql .= "    '".$array_g_product_cd[$line]."', \n";                 //����ʬ��CD 14 product type code 14
                    $sql .= "    '".addslashes($array_g_product_name[$line])."', \n";   //����ʬ��̾ 15 product ype name 15
                    $sql .= "    '".addslashes($array_goods_cname[$line])."', \n";      //����̾��ά�Ρ� 16 product name abbreviation 16
                    $sql .= "    '".$array_product_cd[$line]."', \n";                   //������ʬCD 17 mgt classification code 17
                    $sql .= "    '".addslashes($array_product_name[$line])."' \n";      //������ʬ̾ 18 mgt classification name 18
                    $sql .= ") \n";
                    $sql .= ";\n";
//print_array($sql);

                    $result = Db_Query($db_con, $sql);
                    if($result == false) {
                        Db_Query($db_con, "ROLLBACK;");
                        exit();
                    }
                }
            }

        }//�ɲþ��ʤ���Ͽ��������� and the registration process of the product added

        //-- ê�����ϥȥ�󥶥������λ end the stocktaking input transaction--//
        Db_Query($db_con, "COMMIT;");
        //Db_Query($db_con, "ROLLBACK;");


    }//��Ͽ��������� end the registration process

}

//��Ͽ��λ�ܥ��󲡲����ʤ顢Ĵ��ɽ�������̤����� transition to the suveychart table list screen when the registration complete button is pressed 
if($_POST["form_entry_button"] != null && $error_flg == false){
    header("Location: $transition_url");
    exit();
}



//--------------------------//
//�ڡ����������� set the page number
//--------------------------//

//POST���ʤ��Ȥ��ʽ��ɽ������when there is no POST (initial display)
if($_POST == null){
    $offset_line = 0;       //ɽ�����Ϲ� start display row
    $page_num = 1;          //�ڡ����ֹ� page number
    $add_flg = "false";     //�ǽ�ϸ���ξ��ʤ�ɽ�� display the fixed product first

}else{

    //���顼�������ξ��� if its and error then it should be the way it was before
    if($error_flg == true){
        $offset_line = $_POST["offset_line"];
        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //���إܥ��󤬲�����Ƥ��� the next button is pressed
    }elseif($_POST["form_entry_next"] != null){
        //���γ��Ϲԡ�1�ڡ�����ɽ����� display the +1 of the starting row of the last page 
        $offset_line = $_POST["offset_line"] + $limit;      //ɽ�����Ϲ� display start row

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"] + 1;

    //���إܥ��󤬲�����Ƥ��� if the back button is pressed
    }elseif($_POST["form_entry_back"] != null){
        //���γ��Ϲԡ�1�ڡ�����ɽ����� display itme is hte start row of the previous page -1 
        $offset_line = $_POST["offset_line"] - $limit;      //ɽ�����Ϲ�  display start row

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"] - 1;

    //��Ͽ���ƾ����ɲá������ɲåܥ��󤬲�����Ƥ���if the regsiter then add product or the add product button is pressed 
    }elseif($_POST["form_entry_add_button"] != null || $_POST["form_add_button"] != null){
        //Ĵ��ɽ�ξ��ʿ� number of product of the survey chart
        $offset_line = $contents_num;

    //���ɲá������󥯡����ʥ��������ϡ��������ܥ��󡢤ޤ�����Ͽ��λ�ܥ��󲡲��� when the add row, delete link, product code input, set all at once button, or the register complete button is pressed
    }elseif($_POST["del_row"] != null || $_POST["add_row_flg"] != null || $_POST["goods_search_row"] != null || $_POST["form_conf_button"] != null || $_POST["form_entry_button"] != null){
        //���ξ��� previous status
        $offset_line = $_POST["offset_line"];

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //�ڡ������إ��쥯�� page change select
    }elseif($_POST["f_page1"] != null){
        $offset_line = ($_POST["f_page1"] == null) ? 0 : ($_POST["f_page1"] - 1) * $limit;

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //����¾�ʾ��ʥ��������򳫤��ơ��Ĥ����Ȥ��Ȥ���other (like when the product dialogu was opened and closed
    }else{
        //���ξ��� previous status
        $offset_line = $_POST["offset_line"];

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];
    }


    //���顼�������ξ��� if its and error then status before
    if($error_flg == true){
        $add_flg = $_POST["add_flg"];

    }elseif($_POST["form_add_button"] != null || $_POST["form_entry_add_button"] != null){
        //�ɲá���Ͽ�����ɲåܥ��󤬲�����Ƥ������ɲþ��ʤ�ɽ�� display the additional product when the user add then register and press the add button 
        $add_flg = "true";

    }else{
        //�ɲåܥ��󤬲�����Ƥ��ʤ��ä������ξ��֤�ɽ�� if the add button is not pressed then display the previous status
        $add_flg = $_POST["add_flg"];
    }
}
//print_array($offset_line, '$offset_line');
//print_array($page_num, '$page_num');
//print_array($add_flg, '$add_flg');


$con_data["offset_line"] = $offset_line;
$con_data["add_flg"] = $add_flg;
$con_data["f_page1"] = $page_num;
$con_data["f_page2"] = $page_num;



/****************************/
//�ե�������� crate form
/****************************/

//ê���»ܼ� stocktaker
$select_value_staff = Select_Get($db_con, "staff");
$form->addElement("select","form_staff_set","",$select_value_staff, $g_form_option_select);

//�ԡ�ê���»ܼԡ� row (stocktaker)
$form_line[] =& $form->createElement(
    "text","start","","size=\"11\" maxLength=\"9\" 
     style=\"text-align: right; $g_form_style\" $g_form_option"); 
$form_line[] =& $form->createElement("static","","","�ԡ�����");
$form_line[] =& $form->createElement(
    "text","end","","size=\"11\" maxLength=\"9\"
     style=\"text-align: right; $g_form_style\" $g_form_option");
$form_line[] =& $form->createElement("static","","","��");
$form->addGroup($form_line, "form_line", "");

//�������set all at once
$form->addElement("submit","form_conf_button","�������");


//�ڡ������إ��쥯��page change select
$page_num_all = (int)($contents_num / $limit);
$page_num_all = (($contents_num % $limit) == 0) ? $page_num_all : $page_num_all + 1;
//1�ڡ�����������ʤ��ä��顢���쥯�ȥܥå������� create a select box if its not just one page
if($page_num_all != 1){
    for($i=1; $i<=$page_num_all; $i++){
        $select_page[$i] = "$i";
    }
    $form->addElement("select", "f_page1", "", $select_page, " onChange=\"page_check(1); window.focus();\" onKeyDown=\"chgKeycode();\"");
    $form->addElement("select", "f_page2", "", $select_page, " onChange=\"page_check(2); window.focus();\" onKeyDown=\"chgKeycode();\"");
}


//��Ͽ�ܥ��� register button
//$form->addElement("submit","form_entry_button","�С�Ͽ", "$disabled");

//�����Ͽ�ܥ��� temporary register button
//$form->addElement("submit","form_temp_button","�����Ͽ", "$disabled");

//��� back
$form->addElement("button","form_back_button","�ᡡ��", "onClick=\"javascript:location.href=('$pre_url');");


//���إܥ��� next button
$next_disabled = ($page_num == $page_num_all) ? "disabled" : $disabled;     //�ǽ��ڡ����ʤ�disabled if its the last page then disabled
$form->addElement("submit", "form_entry_next", "��Ͽ���Ƽ���", "$next_disabled");

//���إܥ��� go back button
$back_disabled = ($page_num == 1) ? "disabled" : $disabled;     //1�ڡ����ܤʤ�disabled if its the first page then disable
$form->addElement("submit", "form_entry_back", "��Ͽ��������", "$back_disabled");

//Ĵ��ɽ�ˤ��뾦�ʤ����ϻ� when the product was inputted in the survey chart
if($add_flg == "false"){
    //�ɲåܥ��� add button
    $form->addElement("submit", "form_add_button", "�����ɲ�");
//�����ɲû� when the product is added
}else{
    //Ĵ��ɽ���ϥܥ��� surver chart input button
    $form->addElement("button", "form_input_button", "Ĵ��ɽ����", "onClick=\"javascript:location.href=('".$_SERVER["PHP_SELF"]."?invent_no=".$_GET["invent_no"]."&ware_id=".$_GET["ware_id"]."');");
}

//Ĵ��ɽ�������ϲ��̤Ǻǽ��ڡ����ʤ顢��Ͽ���ƾ����ɲåܥ��� if its the last page of the survey chart input product screen, then register and add product button
if($add_flg == "false" && $page_num == $page_num_all){
    $form->addElement("submit", "form_entry_add_button", "��Ͽ���ƾ����ɲ�", "$disabled");
}

//��λ�ܥ��� complete button
$form->addElement("submit", "form_entry_button","��Ͽ��λ", "$disabled");


/****************************/
//������� initial setting
/****************************/
//ɽ���Կ� number of row displayed 
if($error_flg == true){
    $max_row = $_POST["max_row"];
}elseif($_POST["form_add_button"] != null || $_POST["form_entry_add_button"] != null){
    $max_row = 1;
}elseif(isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
//}elseif($target_goods == "�߸˿�0"){
}else{
    $max_row = 0;
//}else{
//    $max_row = 1;
}
//����Կ� number of delete rows
$del_history[] = null;


/****************************/
//�Կ��ɲ� add rpw number
/****************************/
if($_POST["add_row_flg"]==true){
    //����Ԥˡ��ܣ����� +1 to the max row
    //$max_row = $_POST["max_row"]+1;
    $max_row = $_POST["max_row"]+10;
    //�Կ��ɲåե饰�򥯥ꥢ clear the add row flag
    $con_data["add_row_flg"] = "";
    //$form->setConstants($con_data);
}

/****************************/
//�Ժ������ delete row process
/****************************/
if(isset($_POST["del_row"])){

    //����ꥹ�Ȥ���� acquire delete rlist
    $del_row = $_POST["del_row"];

    //������������ˤ��롣 array the delete uhistory 
    $del_history = explode(",", $del_row);
}


/***************************/
//��������� intiial setting
/***************************/
$con_data["max_row"] = $max_row;


/*****************************/
//����ɽ�� display screen
/*****************************/

//�إå�������� acquire header info
$sql  = "SELECT ";
$sql .= "   ware_name, ";
$sql .= "   target_goods ";
$sql .= "FROM ";
$sql .= "   t_invent ";
$sql .= "WHERE ";
$sql .= "   invent_no = '".$_GET["invent_no"]."' ";
$sql .= "AND ";
$sql .= "   ware_id = ".(int)$_GET["ware_id"]." ";
$sql .= "AND ";
$sql .= "   shop_id = $shop_id ";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$array_header = Get_Data($result, 2);

//ê��Ĵ�����ֹ� stocktaking survey row number
$invent_no = $_GET["invent_no"]; 

//�Ҹ�̾ warehosue name
$ware_name = htmlspecialchars($array_header[0][0]);

//�оݾ��� corresponding product
if($array_header[0][1] == "1"){
    $target_goods = "������";
} elseif($array_header[0][1] == "2"){
    $target_goods = "�߸˿�0�ʳ�";
} elseif($array_header[0][1] == "3"){
    $target_goods = "�߸˿�0";
}


/****************************/
//ɽ���ǡ������� acquire display data
/****************************/

//hidden
$form->addElement("hidden", "del_row");             //����� delete row
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰 add row flag
$form->addElement("hidden", "max_row");             //����Կ� max row number
$form->addElement("hidden", "goods_search_row");    //���ʥ��������Ϲ� input row of product code
$form->addElement("hidden", "hdn_enter_day");       //��Ͽ�� registreation date

$form->addElement("hidden", "offset_line");         //ɽ�����Ϲ� display start row
$form->addElement("hidden", "add_flg");             //���꾦�ʤ��ɲþ��ʤ�Ƚ��ե饰 flag that determines if its a fixed prod or added product


//ɽ���ǡ������� acquire dipslay data
$sql  = "SELECT \n";
$sql .= "    t_contents.goods_cd, \n";      //���ʥ����� 0 prod code
$sql .= "    t_contents.goods_name, \n";    //����̾ 1 prod name
$sql .= "    t_goods.unit, \n";             //ñ�� 2 unit
$sql .= "    t_contents.price, \n";         //ñ�� 3 price per unit
$sql .= "    t_contents.stock_num, \n";     //Ģ��� 4 number of units in the books 
$sql .= "    t_contents.tstock_num, \n";    //��ê�� 5 actualy number of units 
//$sql .= "    t_contents.stock_num - t_contents.tstock_num AS diff_num, ";   //���� 6 differehce
$sql .= "    t_contents.tstock_num - t_contents.stock_num AS diff_num, \n";     //���� 6 difference
$sql .= "    t_staff.staff_id, \n";         //ê���»ܼԥ����å�ID 7 stocktaker staff ID
$sql .= "    t_contents.cause, \n";         //���۸��� 8 cause of difference
$sql .= "    t_contents.add_flg, \n";       //�ɲåե饰 9 add flag
$sql .= "    t_contents.staff_name, \n";    //���ϼ�̾��������hidden�� 10 name of the encoder (for history hidden)
$sql .= "    t_contents.g_goods_cd, \n";    //�Ͷ�ʬ�����ɡ�������hidden��11 m classificication code (for history hidden)
$sql .= "    t_contents.g_goods_name, \n";  //�Ͷ�ʬ̾��������hidden��12 m classificaition name (for history hidden)
$sql .= "    t_contents.g_product_cd, \n";  //����ʬ�ॳ���ɡ�������hidden��13 product type code (for history hidden)
$sql .= "    t_contents.g_product_name, \n";//����ʬ��̾ 14 prod type name 
$sql .= "    t_contents.goods_cname, \n";   //����̾��ά�Ρˡ�������hidden��15 prod name abbreviatiion (for history hidden)
$sql .= "    t_contents.product_cd, \n";    //������ʬ�����ɡ�������hidden��16 management classificatin code (for history hidden)
$sql .= "    t_contents.product_name \n";   //������ʬ̾��������hidden��17 mgt classification code (for history hidden)
$sql .= "FROM \n";
$sql .= "    ( \n";
$sql .= "        ( \n";
$sql .= "        t_invent \n";
$sql .= "        INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
$sql .= "        ) INNER JOIN t_goods ON t_goods.goods_id = t_contents.goods_id \n";
$sql .= "    ) LEFT JOIN t_staff ON t_staff.staff_id = t_contents.staff_id \n";
$sql .= "WHERE \n";
$sql .= "    t_invent.invent_no = '".$_GET["invent_no"]."' \n";
$sql .= "AND \n";
$sql .= "    t_invent.ware_id = ".(int)$_GET["ware_id"]." \n";
$sql .= "AND \n";
$sql .= "    t_invent.shop_id = $shop_id \n";
//$sql .= "AND ";
//$sql .= "    t_invent.renew_flg = false ";
$sql .= "AND \n";
$sql .= "    t_contents.add_flg = $add_flg \n";
$sql .= "ORDER BY \n";
$sql .= "    t_contents.add_flg ASC, \n";
$sql .= "    t_contents.g_product_cd ASC, \n";
$sql .= "    t_contents.goods_cd ASC \n";
if($add_flg == "false"){
    $sql .= "OFFSET $offset_line \n";
    $sql .= "LIMIT $limit \n";
}
$sql .= ";";
//print_array($sql, "��������SQL");

$result = Db_Query($db_con, $sql);
//Get_Id_Check($result);

$disp_num = pg_num_rows($result);   //ɽ���Կ� display row number

//HTML���� create
$array_db = Get_Data($result, 2);
//print_array($array_db, "DB����");
$array_size = count($array_db);

//print_array($del_history, "�������");


/****************************/
//�ե�������� create form
/****************************/

//ê��Ĵ��ɽ�����������������ǡ��� data that was created when the stocktaking survey chart was created
//if($add_flg == "false"){

for($i=0, $no=$offset_line+1, $row_num=$offset_line+1; $i<$array_size+$max_row; $i++, $no++){

    //�����Ƚ�� determine the deleted row
    if(!in_array($no, $del_history)){

        //������� deletion history
        $del_data = ($del_row == "") ? $no : $del_row.",".$no;

        //�ե��������� create form
        Draw_Row($add_flg, $no, $form, $select_value_staff, $select_reason, $del_data, $target_goods, $invent_id, $dialog_goods_url);


        //�ե�����˥ǡ����򥻥å� set the data to form
        $disp_data[$no]       = $row_num;        //���ֹ� row number

        $def_data["form_g_product_name"][$no]   = $array_db[$i][14];    //����ʬ�� prod type
        $def_data["form_goods_cd"][$no]         = $array_db[$i][0];     //����CD prod code
        $def_data["form_goods_name"][$no]       = $array_db[$i][1];     //����̾ prod name
        $def_data["form_unit"][$no]             = $array_db[$i][2];     //ñ�� units

        $price = explode(".", $array_db[$i][3]);
        $def_data["form_price"][$no]["i"]       = $price[0];            //�߸�ñ���������� price per unit of the stock (integer)
        $def_data["form_price"][$no]["d"]       = $price[1];            //�߸�ñ���ʾ����� price per unit of the stock (decimal)
        $def_data["form_stock_num"][$no]        = $array_db[$i][4];     //Ģ��� number of units in the books
        $def_data["form_tstock_num"][$no]       = $array_db[$i][5];     //��ê�� actual no of units 
        $def_data["form_diff_num"][$no]         = $array_db[$i][6];     //���� difference 


        //ê���»ܼ԰������ set the stocktaker all at once
        if($staff_set !== null){
            //�ϰ���ιԤʤ����� if the rows are withing the reach then set
            if($line_start <= $row_num && $line_end >= $row_num){
                $staff_con_data["form_staff"][$no] = $staff_set;
            }
        //DB������ͤ����� set the value from the db
        }else{
            $def_data["form_staff"][$no] = $array_db[$i][7];
        }
        $def_data["form_cause"][$no] = array_search($array_db[$i][8], $select_reason);

        if($array_db[$i][13] == "t"){
            $def_data["form_g_product_name"][$no] = $array_db[$i][15];
        }

        //���ֹ��ܣ� +1 to that row number
        $row_num = $row_num+1;

    }

}
//print_array($i, "�롼��");
//print_array($no, "���ֹ�");
//print_array($disp_data);


//���ɽ�����ڡ������ء����ɲá������󥯡����ء����ء���Ͽ���ƾ����ɲá������ɲá�Ĵ��ɽ���Ϥγƥܥ��󤬲����줿��硢when the initial display, page change, add row/delete link, next, go back, register and add product, add product, input survey chart button are pressed 
//�ʥڡ������إ��쥯�Ȥ�Ƚ�꤬�Ǥ��ʤ����ᡢ�嵭�ʳ��ξ��� (page change slect cant be determined so other than what was mentioned above)
//�������ԥե���������� set the form of set all at once row 
if(!($_POST["goods_search_row"] != null || $_POST["form_conf_button"] != null || $_POST["form_entry_button"] != null)){
    //ê���»ܼ԰������ι��ֹ�˥��åȤ����� the one that will be set in the row number for the *set the stocktaker all at once*
    $con_data["form_line"]["start"] = $offset_line + 1;
    $con_data["form_line"]["end"]   = $row_num - 1;
}


$form->setDefaults($def_data);
$form->setConstants($staff_con_data);


$form->setConstants($con_data);



/****************************/
//������JavaScript local js
/****************************/
$html_js = <<<JS

<script langage="javascript">
<!--

function InD(row)
{
    var SN = "form_stock_num["+row+"]";
    var TN = "form_tstock_num["+row+"]";
    var DN = "form_diff_num["+row+"]";

    //��ê�������ͤξ�硢Ģ����Ȥκ���ɽ�� if the actual stock number is a number, then display the difference between the number of units in the books
     if(isNaN(document.dateForm.elements[TN].value) == false && document.dateForm.elements[TN].value != ""){
        document.dateForm.elements[DN].value = document.dateForm.elements[TN].value - document.dateForm.elements[SN].value;

    //���ͤ���ʤ���硢����ɽ�����ʤ� do not display anything if its not a number
    }else{
        document.dateForm.elements[DN].value = "";
    }

    return true;
}

//-->
</script>

JS;



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
//$page_menu = Create_Menu_f('stock','2');

/****************************/
//���̥إå������� create screen header
/****************************/
$page_header = Create_Header($page_title);



// Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign form related variables
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assign other varibales
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    //'html'          => "$html",
    'html_js'       => "$html_js",
    'invent_no'     => "$invent_no", 
    'expected_day'  => "$expected_day", 
    'ware_name'     => "$ware_name", 
    'target_goods'  => "$target_goods", 
    'price_error_mess'  => "$price_error_mess", 
    'tstock_error_mess' => "$tstock_error_mess", 
    'staff_error_mess'  => "$staff_error_mess", 
    'db_unique_error_mess'  => "$db_unique_error_mess", 
    'unique_error_mess' => "$unique_error_mess", 
    'injustice_error_mess'  => "$injustice_error_mess", 
    'staff_line_err'    => "$staff_line_err", 
    'staff_select_err'  => "$staff_select_err", 
    'cause_error_mess'  => "$cause_error_mess", 
    'renew_err_mess'    => "$renew_err_mess", 
    'remake_err_mess'   => "$remake_err_mess", 
    'add_flg'       => "$add_flg", 
));

$smarty->assign('disp_data', $disp_data);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to the template
$smarty->display(basename($_SERVER["PHP_SELF"] .".tpl"));

//echo microtime()."<br>";

//print_array($_SESSION);
//print_array($_POST, '$_POST');
//print_array($_GET);


/**
 *
 * ê�����ϥե������1������
 *
 * @param       array       $array                  1��ʬ�Υǡ���
 * @param       int         $i                      �ե������ѹ��ֹ�
 * @param       object      $form                   HTML_QuickForm�Υ��֥�������
 * @param       array       $select_value_staff     �����å�̾������
 * @param       array       $select_reason          ������ͳ������
 * @param       string      $del_data               �������
 * @param       string      $target_goods           �оݾ���
 * @param       int         $invent_id              ê��Ĵ��ID
 * @param       string      $dialog_goods_url       ��������URL
 *
 * @return      array       ɽ���ǡ���
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/05/12)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/05/10      xx-xxx      kajioka-h   �ڡ������ؤǤ���褦���ѹ�
 *
 */
function Draw_Row($add_flg, $i, $form, $select_value_staff, $select_reason, $del_data, $target_goods, $invent_id, $dialog_goods_url)
{
//print_array($array);

    //�����Х��ѿ� global variable
    global $g_form_option, $g_form_option_select, $g_form_style;

    //ReadOnly�ե����ॹ������ readonly form style
    $form_ro_style = "color: #555555; border: #ffffff 1px solid; background-color: #ffffff;";


    //����ʬ�� product type
    $freeze_data = $form->addElement(
        "text", "form_g_product_name[$i]", "�ƥ����ȥե�����",
        "size=\"25\" maxLength=\"10\", readonly 
         style=\"$form_ro_style\""
    );

    //����CD product code
    $form->addElement(
        "text", "form_goods_cd[$i]", "�ƥ����ȥե�����",
        "size=\"10\" maxLength=\"8\", style=\"$g_form_style\" $g_form_option 
         onChange=\"javascript: goods_search_1(this.form, 'form_goods_cd', 'goods_search_row', $i);\""
    );

    //�����ɲùԤξ��ϡ�������󥯤� also the search link if its an added product row
    if($add_flg == "true"){
        $form->addElement("link","form_search[$i]","","#","����",
            " onClick=\"return Open_SubWin('".$dialog_goods_url."',Array('form_goods_cd[$i]','goods_search_row'),500,450,'2','$invent_id','$i');\""
        );
    }

    //����̾ prodcut name
    $form->addElement(
        "text", "form_goods_name[$i]", "�ƥ����ȥե�����",
        "size=\"70\" maxLength=\"35\", readonly"
    );

    //ñ�� unit
    $form->addElement(
        "text", "form_unit[$i]", "�ƥ����ȥե�����",
        "size=\"5\" maxLength=\"5\", readonly 
         style=\"$form_ro_style\""
    );


    //����ʬ�ࡢñ�̤�ե꡼�� freeze the product type, and the unit
    $freeze_data = array(
        "form_g_product_name[$i]",
        "form_unit[$i]",
    );
    //�����ɲäιԤ���ʤ���硢����CD������̾��ե꡼�� if its not the add product row then freez the product code and the name as well
    if($add_flg != "true"){
        $freeze_data[] = "form_goods_cd[$i]";
        $freeze_data[] = "form_goods_name[$i]";
    }
    $form->freeze($freeze_data);


    //�߸�ñ�� price per units of the stock
    $price = explode(".", $array[3]);
    $form->addElement(
        "text", "form_price[$i][i]", "�ƥ����ȥե�����", 
        "class=\"money\" size=\"11\" maxLength=\"9\" 
         onKeyup=\"changeText(this.form, 'form_price[$i][i]', 'form_price[$i][d]', 9, '00')\"
         $g_form_option style=\"text-align: right; $g_form_style\"" 
    );
    $form->addElement(
        "text", "form_price[$i][d]", "�ƥ����ȥե�����", 
        "size=\"1\" maxLength=\"2\" 
         $g_form_option style=\"text-align: left; $g_form_style\""
    );


    //Ģ��� number of units in the books
    $form->addElement("text", "form_stock_num[$i]", "�ƥ����ȥե�����", 
        "size=\"11\" maxLength=\"9\", readonly 
         style=\"text-align: right; $form_ro_style $g_form_style\""
    );

    //��ê�� actualy number of units
    $form->addElement("text", "form_tstock_num[$i]", "�ƥ����ȥե�����", 
        "class=\"money\" size=\"11\" maxLength=\"9\", 
         $g_form_option style=\"text-align: right; $g_form_style\" onKeyup=\"return InD($i);\""
    );

    //���� difference
    $form->addElement("text", "form_diff_num[$i]", "�ƥ����ȥե�����", 
        "size=\"11\" maxLength=\"9\", readonly 
         style=\"text-align: right; $form_ro_style $g_form_style\""
    );

    //ê���»ܼ� stocktaker
    $form->addElement("select", "form_staff[$i]", "", $select_value_staff, $g_form_option_select);

    //���۸��� reason of difference
    $form->addElement("select", "form_cause[$i]", "", $select_reason, $g_form_option_select);

    //������ delete link
    //�߸˿�0�ξ��ϹԤ��ɲá�����Ϥʤ� no add or delete of row if the number of units in the inventory is 0
    if($target_goods != "�߸˿�0" && $add_flg == "true"){
        $form->addElement("link","add_row_del[$i]","","#","���",
            " onClick=\"javascript:return Dialogue_1('������ޤ���', '$del_data', 'del_row')\""
        );
    }

/*
    $add_flg = ($add_flg == "t") ? "true" : "false";
    $form->addElement("hidden", "form_add_flg[$i]", $add_flg);      //�ɲåե饰 add falg
*/

    return "";

}


?>
