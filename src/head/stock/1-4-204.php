<?php
/**
 *
 * ê������
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

//�Ķ�����ե�����
require_once("ENV_local.php");

//echo microtime()."<br>";

//HTML_QuickForm�����
$form =& new HTML_QuickForm("$_SERVER[PHP_SELF]", "POST");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;



/****************************/
//�����ѿ�����
/****************************/

$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

$error_flg  = false;


//Ĵ��ɽ�ֹ�
($_GET["invent_no"] == null || $_GET["ware_id"] == null) ? header("Location: ../top.php") : null;


//-------------------------//
//����
//-------------------------//

//ɽ���Կ�
$limit = 50;

//��������
if($group_kind == "1"){
    //ê��Ĵ��ɽ�������������̤�URL�����ܥ����ѡ�
    $pre_url = "1-4-201.php";
    //���ʰ�������������URL
    $dialog_goods_url = "../dialog/1-0-210.php";
    //��Ͽ��������URL
    $transition_url = "./1-4-201.php";
//FC����
}else{
    //ê��Ĵ��ɽ�������������̤�URL�����ܥ����ѡ�
    $pre_url = "2-4-201.php";
    //���ʰ�������������URL
    $dialog_goods_url = "../dialog/2-0-210.php";
    //��Ͽ��������URL
    $transition_url = "./2-4-201.php";
}


/****************************/
//ê��Ĵ��ID����
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

$invent_id = pg_fetch_result($result, 0, 0);    //ê��Ĵ��ID
$expected_day = pg_fetch_result($result, 0, 1); //ê����
//�ǽ�˲��̤򳫤����Ȥ��ˡ���Ͽ���������hidden���ݻ�
if($_POST["hdn_enter_day"] == null){
    $enter_day = pg_fetch_result($result, 0, 2);    //��Ͽ��
    $form->setDefaults(array("hdn_enter_day" => "$enter_day"));
}else{
    $enter_day = $_POST["hdn_enter_day"];
}
$contents_num = pg_fetch_result($result, 0, 3);     //Ĵ��ɽ�������ξ��ʿ�

//1.1.1 2006-07-11 kaji
//Ĵ����åܥ��󤬲����줿��ê���إå����ä��줿�˾�硢����������
if($invent_id === false){
    exit();
}


/****************************/
//���۸������쥯�ȥܥå�����
/****************************/

$select_reason = array(
    0 => "",
    //1 => "�����ƥ೫�Ϻ߸�",
    2 => "��»",
    3 => "ʶ��",
    4 => "ȯ��",
    7 => "Ĵ��",
    5 => "�߸˵����ߥ�",
);



/*****************************/
//���ʥ���������
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
    //�����ξ��
    if($group_kind == "1"){
        $sql .= "        t_goods.state IN ('1', '3') \n";
        $sql .= "    AND \n";
        $sql .= "        CASE t_goods.public_flg \n";
        $sql .= "            WHEN true THEN t_price.shop_id = $shop_id \n";
        $sql .= "            WHEN false THEN t_goods.shop_id = $shop_id \n";
        $sql .= "        END \n";
    //ľ�Ĥξ��
    }elseif($group_kind == "2"){
        $sql .= "        t_goods.state IN ('1', '3') \n";
        $sql .= "    AND \n";
        $sql .= "        CASE t_goods.public_flg \n";
        $sql .= "            WHEN true THEN t_price.shop_id IN (".Rank_Sql().") \n";
        $sql .= "            WHEN false THEN t_goods.shop_id IN (".Rank_Sql().") \n";
        $sql .= "        END \n";
    //FC�ξ��
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

        $set_goods_data["form_add_flg"][$row] = "true";             //�ɲåե饰


        //ê�����κ߸˿������
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
        //�������뾦�ʤ�¸�ߤ��ʤ���硢�ե����������
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

        $set_goods_data["form_add_flg"][$row] = "";             //�ɲåե饰
    }

    $set_goods_data["goods_search_row"] = "";
    $form->setConstants($set_goods_data);

}	//���ʥ��������Ͻ����



/*****************************/
//ê���»ܼ԰���������������
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
//��Ͽ����
/*****************************/

//if($_POST["form_entry_button"] == "�С�Ͽ"){
//if($_POST["form_entry_button"] == "�С�Ͽ" || $_POST["form_temp_button"] == "�����Ͽ"){
//��Ͽ�������ء���Ͽ���Ƽ��ء���Ͽ���ƾ����ɲá���Ͽ��λ�ܥ��󤬲�����Ƥ��ơ����ʥ����ɤ�����Ǥ����Ȥ�
//if(($_POST["form_entry_back"] != null || $_POST["form_entry_next"] != null || $_POST["form_entry_button"] != null || $_POST["form_entry_add_button"] != null) && $_POST["form_goods_cd"] != null){
//��Ͽ�������ء���Ͽ���Ƽ��ء���Ͽ���ƾ����ɲá���Ͽ��λ�ܥ��󤬲�����Ƥ�
if($_POST["form_entry_back"] != null || $_POST["form_entry_next"] != null || $_POST["form_entry_button"] != null || $_POST["form_entry_add_button"] != null){


    //���ʥ����ɤ�����Ǥ���
    if($_POST["form_goods_cd"] != null){

        //POST������Ǥ������ֹ����
        $line_no = array_keys($_POST["form_goods_cd"]);

        //�Կ�
        $row_num = $_POST["offset_line"];


        //-- ���顼�����å�(PHP) --//
        //for($i=0,$error_flg=false;$i<$line_count;$i++){
        foreach($_POST["form_goods_cd"] as  $line => $goods_cd){

            //���ֹ�
            $row_num++;
            $array_row_num[$line] = $row_num;   //���ֹ�����ʥ��顼�����å��ǻȤ���


            //Ĵ��ɽ�������ξ��ʡ��ޤ��Ͼ����ɲò��̤Ǿ��ʥ����ɤ����ǤϤʤ��Ԥ��������å�
            if($_POST["add_flg"] == "false" || ($_POST["add_flg"] == "true" && $_POST["form_goods_cd"][$line] != "")){

                //�߸�ñ�������å�
                if(!ereg("^[0-9]+$",$_POST["form_price"][$line]["i"]) || !ereg("^[0-9]+$",$_POST["form_price"][$line]["d"])){
                    $price_error_mess .= ($row_num)."���� �߸�ñ����Ⱦ�ѿ����ΤߤǤ���<br>";
                    $error_flg = true;
                }

                //��ê�������å�
                if(!ereg("^[\-]?[0-9]+$",$_POST["form_tstock_num"][$line])){
                    $tstock_error_mess .= ($row_num)."���� ��ê����Ⱦ�ѿ����ΤߤǤ���<br>";
                    $error_flg = true;
                }

                //ê���»ܼԥ����å�
                if($_POST["form_staff"][$line] == ""){
                    $staff_error_mess .= ($row_num)."���� ê���»ܼԤ����򤷤Ƥ���������<br>";
                    $error_flg = true;
                }

                //���۸�����Ͽ�����å�
                if($_POST["form_diff_num"][$line] != 0 && $_POST["form_cause"][$line] == 0){
                    $cause_error_mess .= ($row_num)."���� ���۸��������򤷤Ƥ���������<br>";
                    $error_flg = true;
                }


                //���ʥ����ɤ����ǤϤʤ���Τ�������
                $array_goods_cd[$line] = $_POST["form_goods_cd"][$line];

                //���������������Ȥ����Ϥ���Ƥ������ñ�������
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


    $goods_count = count($array_goods_cd);      //���Ͼ��ʿ�


    //�����ɲò��̤Ǿ��ʤ����Ϥ�������Υ����å�
    if($_POST["add_flg"] == "true" && $goods_count != 0){

        $injustice_error_mess = "";
        $goods_cd_str = "";
        foreach($array_goods_cd as $line => $goods_cd){

            //����̾�������
            $sql  = "SELECT \n";
            $sql .= "    t_goods.goods_id, \n";             //����ID
            $sql .= "    t_goods.goods_name, \n";           //����̾
            $sql .= "    t_goods.goods_cname, \n";          //����̾��ά�Ρ�
            $sql .= "    t_g_goods.g_goods_cd, \n";         //�Ͷ�ʬCD
            $sql .= "    t_g_goods.g_goods_name, \n";       //�Ͷ�ʬ̾
            $sql .= "    t_product.product_cd, \n";         //������ʬCD
            $sql .= "    t_product.product_name, \n";       //������ʬ̾
            $sql .= "    t_g_product.g_product_cd, \n";     //����ʬ��CD
            $sql .= "    t_g_product.g_product_name \n";    //����ʬ��̾
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

            //�����ǡ�����¸�ߤ��ʤ���硢���顼
            if(pg_num_rows($result) != 1){
                $injustice_error_mess .= $array_row_num[$line]."���� ";
                $error_flg = true;

            //�ǡ�����1�濫��Ȥ�
            }else{
                //��Ͽ���˻Ȥ��ǡ�������
                $array_goods_id[$line]          = pg_fetch_result($result, 0, "goods_id");
                $array_goods_name[$line]        = pg_fetch_result($result, 0, "goods_name");
                $array_goods_cname[$line]       = pg_fetch_result($result, 0, "goods_cname");
                $array_g_goods_cd[$line]        = pg_fetch_result($result, 0, "g_goods_cd");
                $array_g_goods_name[$line]      = pg_fetch_result($result, 0, "g_goods_name");
                $array_product_cd[$line]        = pg_fetch_result($result, 0, "product_cd");
                $array_product_name[$line]      = pg_fetch_result($result, 0, "product_name");
                $array_g_product_cd[$line]      = pg_fetch_result($result, 0, "g_product_cd");
                $array_g_product_name[$line]    = pg_fetch_result($result, 0, "g_product_name");

                //Ĵ��ɽ�������ξ��ʤȤν�ʣ�����å��˻Ȥ�
                $goods_cd_str .= "'$goods_cd', ";
            }

        }

        $injustice_error_mess .= ($injustice_error_mess != "") ? "���ʾ��󤬼����Ǥ��ޤ���Ǥ�������������ԤäƲ�������" : "";

        $goods_cd_str = substr($goods_cd_str, 0, strlen($goods_cd_str) - 2);

        //���Ͼ��ʤ�Ʊ�����ʥ����ɤ���Ĵ��ɽ�������ˤʤ���
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

        //��ʣ��������
        $same_goods_count = pg_num_rows($result);
        for($i=0, $db_unique_error_mess=""; $i<$same_goods_count; $i++){
            //��ʣ�������ʤ� ����CD[���ֹ�] �����
            $array_same_line = array_intersect($array_goods_cd, array(pg_fetch_result($result, $i, 0)));

            //���ֹ����󤫤顢No.�����
            foreach($array_same_line as $key => $value){
                $db_unique_error_mess .= $array_row_num[$key]."���� ";
            }

            $error_flg = true;
        }
        $db_unique_error_mess .= ($same_goods_count != 0) ? "�ξ��ʤ�ê��Ĵ��ɽ��¸�ߤ��뤿�ᡢ�ɲäǤ��ޤ���<br>" : "";
//print_array($db_unique_error_mess, "Ĵ��ɽ�Ƚ�ʣ�����å�");


        //�ɲþ��ʤ���ν�ʣ�����å�
        $diff_array = array_diff_assoc($array_goods_cd, array_unique($array_goods_cd));
        $diff_array_unique = array_unique($diff_array);     //3�İʾ夫�֤äƤ뤫�⤷��ʤ��Τǡ���ʣ��Ϥ֤�
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


    //��������Ƥ��ʤ��������å�
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

    //ê���������Ĵ��ɽ�������ƺ�������Ƥʤ��������å�
    if(Update_Check($db_con, "t_invent", "invent_id", $invent_id, $enter_day) == false && $error_flg == false){
        $remake_err_mess = "ê��Ĵ��ɽ���ѹ�����Ƥ��뤿�ᡢ��Ͽ�Ǥ��ޤ���";
        $error_flg = true;
    }
//echo "���顼�����å������";exit();


    $error_flg = ($form->validate()) ? $error_flg : false;


    //���顼�ξ��Ϥ���ʹߤν�����Ԥʤ�ʤ�
    if($error_flg == false){

        //-- ê�����ϥȥ�󥶥�����󳫻� --//
        Db_Query($db_con, "BEGIN;");

        //ê���إå��ơ��֥빹��
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


        //Ĵ��ɽ�ˤ��뾦�ʤ���Ͽ����
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

        //�ɲþ��ʤ���Ͽ����
        }else{

            //�ɲþ��ʥǡ��������
            $sql = "DELETE FROM t_contents WHERE invent_id = $invent_id AND add_flg = true;";
            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }


            //�ɲþ��ʤ�0����ʤ����Τ���Ͽ
            if(count($array_goods_cd) > 0){

                foreach($array_goods_cd as $line => $goods_cd){

                    $sql  = "INSERT INTO \n";
                    $sql .= "    t_contents \n";
                    $sql .= "( \n";
                    $sql .= "    invent_id, \n";    //ê��Ĵ��ID 1
                    $sql .= "    goods_id, \n";     //����ID 2
                    $sql .= "    stock_num, \n";    //Ģ��� 3
                    $sql .= "    tstock_num, \n";   //��ê�� 4
                    $sql .= "    price, \n";        //ñ�� 5
                    $sql .= "    staff_id, \n";     //��ê��ǧ��ID 6
                    $sql .= ($_POST["form_cause"][$line] != null) ? "    cause, \n" : "";   //���۸��� 7
                    $sql .= "    goods_cd, \n";     //����CD 8
                    $sql .= "    goods_name, \n";   //����̾ 9
                    $sql .= "    staff_name, \n";   //��ê��ǧ��̾ 10
                    $sql .= "    g_goods_cd, \n";   //�Ͷ�ʬCD 11
                    $sql .= "    g_goods_name, \n"; //�Ͷ�ʬ̾ 12
                    $sql .= "    add_flg, \n";      //�ɲåե饰 13
                    $sql .= "    g_product_cd, \n"; //����ʬ��CD 14
                    $sql .= "    g_product_name, \n";   //����ʬ��̾ 15
                    $sql .= "    goods_cname, \n";  //����̾��ά�Ρ�16
                    $sql .= "    product_cd, \n";   //������ʬCD 17
                    $sql .= "    product_name \n";  //������ʬ̾ 18

                    $sql .= ") VALUES ( \n";

                    $sql .= "    $invent_id, \n";                                       //ê��Ĵ��ID 1
                    $sql .= "    ".$array_goods_id[$line].", \n";                       //����ID 2
                    $sql .= "    ".$_POST["form_stock_num"][$line].", \n";              //Ģ��� 3
                    $sql .= "    ".$_POST["form_tstock_num"][$line].", \n";             //��ê�� 4
                    $sql .= "    ".$stock_price[$line].", \n";                          //ñ�� 5
                    $sql .= "    ".$_POST["form_staff"][$line].", \n";                  //��ê��ǧ��ID 6
                    $sql .= ($_POST["form_cause"][$line] != null) ? "    '".$select_reason[$_POST["form_cause"][$line]]."', \n" : "";   //���۸��� 7
                    $sql .= "    '".$goods_cd."', \n";                                  //����CD 8
                    $sql .= "    '".addslashes($array_goods_name[$line])."', \n";       //����̾ 9
                    $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = ".(int)$_POST["form_staff"][$line]."), \n";      //��ê��ǧ��̾ 10
                    $sql .= "    '".$array_g_goods_cd[$line]."', \n";                   //�Ͷ�ʬCD 11
                    $sql .= "    '".addslashes($array_g_goods_name[$line])."', \n";     //�Ͷ�ʬ̾ 12
                    $sql .= "    true, \n";                                             //�ɲåե饰 13
                    $sql .= "    '".$array_g_product_cd[$line]."', \n";                 //����ʬ��CD 14
                    $sql .= "    '".addslashes($array_g_product_name[$line])."', \n";   //����ʬ��̾ 15
                    $sql .= "    '".addslashes($array_goods_cname[$line])."', \n";      //����̾��ά�Ρ� 16
                    $sql .= "    '".$array_product_cd[$line]."', \n";                   //������ʬCD 17
                    $sql .= "    '".addslashes($array_product_name[$line])."' \n";      //������ʬ̾ 18
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

        }//�ɲþ��ʤ���Ͽ���������

        //-- ê�����ϥȥ�󥶥������λ --//
        Db_Query($db_con, "COMMIT;");
        //Db_Query($db_con, "ROLLBACK;");


    }//��Ͽ���������

}

//��Ͽ��λ�ܥ��󲡲����ʤ顢Ĵ��ɽ�������̤�����
if($_POST["form_entry_button"] != null && $error_flg == false){
    header("Location: $transition_url");
    exit();
}



//--------------------------//
//�ڡ�����������
//--------------------------//

//POST���ʤ��Ȥ��ʽ��ɽ������
if($_POST == null){
    $offset_line = 0;       //ɽ�����Ϲ�
    $page_num = 1;          //�ڡ����ֹ�
    $add_flg = "false";     //�ǽ�ϸ���ξ��ʤ�ɽ��

}else{

    //���顼�������ξ���
    if($error_flg == true){
        $offset_line = $_POST["offset_line"];
        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //���إܥ��󤬲�����Ƥ���
    }elseif($_POST["form_entry_next"] != null){
        //���γ��Ϲԡ�1�ڡ�����ɽ�����
        $offset_line = $_POST["offset_line"] + $limit;      //ɽ�����Ϲ�

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"] + 1;

    //���إܥ��󤬲�����Ƥ���
    }elseif($_POST["form_entry_back"] != null){
        //���γ��Ϲԡ�1�ڡ�����ɽ�����
        $offset_line = $_POST["offset_line"] - $limit;      //ɽ�����Ϲ�

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"] - 1;

    //��Ͽ���ƾ����ɲá������ɲåܥ��󤬲�����Ƥ���
    }elseif($_POST["form_entry_add_button"] != null || $_POST["form_add_button"] != null){
        //Ĵ��ɽ�ξ��ʿ�
        $offset_line = $contents_num;

    //���ɲá������󥯡����ʥ��������ϡ��������ܥ��󡢤ޤ�����Ͽ��λ�ܥ��󲡲���
    }elseif($_POST["del_row"] != null || $_POST["add_row_flg"] != null || $_POST["goods_search_row"] != null || $_POST["form_conf_button"] != null || $_POST["form_entry_button"] != null){
        //���ξ���
        $offset_line = $_POST["offset_line"];

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //�ڡ������إ��쥯��
    }elseif($_POST["f_page1"] != null){
        $offset_line = ($_POST["f_page1"] == null) ? 0 : ($_POST["f_page1"] - 1) * $limit;

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //����¾�ʾ��ʥ��������򳫤��ơ��Ĥ����Ȥ��Ȥ���
    }else{
        //���ξ���
        $offset_line = $_POST["offset_line"];

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];
    }


    //���顼�������ξ���
    if($error_flg == true){
        $add_flg = $_POST["add_flg"];

    }elseif($_POST["form_add_button"] != null || $_POST["form_entry_add_button"] != null){
        //�ɲá���Ͽ�����ɲåܥ��󤬲�����Ƥ������ɲþ��ʤ�ɽ��
        $add_flg = "true";

    }else{
        //�ɲåܥ��󤬲�����Ƥ��ʤ��ä������ξ��֤�ɽ��
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
//�ե��������
/****************************/

//ê���»ܼ�
$select_value_staff = Select_Get($db_con, "staff");
$form->addElement("select","form_staff_set","",$select_value_staff, $g_form_option_select);

//�ԡ�ê���»ܼԡ�
$form_line[] =& $form->createElement(
    "text","start","","size=\"11\" maxLength=\"9\" 
     style=\"text-align: right; $g_form_style\" $g_form_option"); 
$form_line[] =& $form->createElement("static","","","�ԡ�����");
$form_line[] =& $form->createElement(
    "text","end","","size=\"11\" maxLength=\"9\"
     style=\"text-align: right; $g_form_style\" $g_form_option");
$form_line[] =& $form->createElement("static","","","��");
$form->addGroup($form_line, "form_line", "");

//�������
$form->addElement("submit","form_conf_button","�������");


//�ڡ������إ��쥯��
$page_num_all = (int)($contents_num / $limit);
$page_num_all = (($contents_num % $limit) == 0) ? $page_num_all : $page_num_all + 1;
//1�ڡ�����������ʤ��ä��顢���쥯�ȥܥå�������
if($page_num_all != 1){
    for($i=1; $i<=$page_num_all; $i++){
        $select_page[$i] = "$i";
    }
    $form->addElement("select", "f_page1", "", $select_page, " onChange=\"page_check(1); window.focus();\" onKeyDown=\"chgKeycode();\"");
    $form->addElement("select", "f_page2", "", $select_page, " onChange=\"page_check(2); window.focus();\" onKeyDown=\"chgKeycode();\"");
}


//��Ͽ�ܥ���
//$form->addElement("submit","form_entry_button","�С�Ͽ", "$disabled");

//�����Ͽ�ܥ���
//$form->addElement("submit","form_temp_button","�����Ͽ", "$disabled");

//���
$form->addElement("button","form_back_button","�ᡡ��", "onClick=\"javascript:location.href=('$pre_url');");


//���إܥ���
$next_disabled = ($page_num == $page_num_all) ? "disabled" : $disabled;     //�ǽ��ڡ����ʤ�disabled
$form->addElement("submit", "form_entry_next", "��Ͽ���Ƽ���", "$next_disabled");

//���إܥ���
$back_disabled = ($page_num == 1) ? "disabled" : $disabled;     //1�ڡ����ܤʤ�disabled
$form->addElement("submit", "form_entry_back", "��Ͽ��������", "$back_disabled");

//Ĵ��ɽ�ˤ��뾦�ʤ����ϻ�
if($add_flg == "false"){
    //�ɲåܥ���
    $form->addElement("submit", "form_add_button", "�����ɲ�");
//�����ɲû�
}else{
    //Ĵ��ɽ���ϥܥ���
    $form->addElement("button", "form_input_button", "Ĵ��ɽ����", "onClick=\"javascript:location.href=('".$_SERVER["PHP_SELF"]."?invent_no=".$_GET["invent_no"]."&ware_id=".$_GET["ware_id"]."');");
}

//Ĵ��ɽ�������ϲ��̤Ǻǽ��ڡ����ʤ顢��Ͽ���ƾ����ɲåܥ���
if($add_flg == "false" && $page_num == $page_num_all){
    $form->addElement("submit", "form_entry_add_button", "��Ͽ���ƾ����ɲ�", "$disabled");
}

//��λ�ܥ���
$form->addElement("submit", "form_entry_button","��Ͽ��λ", "$disabled");


/****************************/
//�������
/****************************/
//ɽ���Կ�
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
//����Կ�
$del_history[] = null;


/****************************/
//�Կ��ɲ�
/****************************/
if($_POST["add_row_flg"]==true){
    //����Ԥˡ��ܣ�����
    //$max_row = $_POST["max_row"]+1;
    $max_row = $_POST["max_row"]+10;
    //�Կ��ɲåե饰�򥯥ꥢ
    $con_data["add_row_flg"] = "";
    //$form->setConstants($con_data);
}

/****************************/
//�Ժ������
/****************************/
if(isset($_POST["del_row"])){

    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);
}


/***************************/
//���������
/***************************/
$con_data["max_row"] = $max_row;


/*****************************/
//����ɽ��
/*****************************/

//�إå��������
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

//ê��Ĵ�����ֹ�
$invent_no = $_GET["invent_no"];

//�Ҹ�̾
$ware_name = htmlspecialchars($array_header[0][0]);

//�оݾ���
if($array_header[0][1] == "1"){
    $target_goods = "������";
} elseif($array_header[0][1] == "2"){
    $target_goods = "�߸˿�0�ʳ�";
} elseif($array_header[0][1] == "3"){
    $target_goods = "�߸˿�0";
}


/****************************/
//ɽ���ǡ�������
/****************************/

//hidden
$form->addElement("hidden", "del_row");             //�����
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰
$form->addElement("hidden", "max_row");             //����Կ�
$form->addElement("hidden", "goods_search_row");    //���ʥ��������Ϲ�
$form->addElement("hidden", "hdn_enter_day");       //��Ͽ��

$form->addElement("hidden", "offset_line");         //ɽ�����Ϲ�
$form->addElement("hidden", "add_flg");             //���꾦�ʤ��ɲþ��ʤ�Ƚ��ե饰


//ɽ���ǡ�������
$sql  = "SELECT \n";
$sql .= "    t_contents.goods_cd, \n";      //���ʥ����� 0
$sql .= "    t_contents.goods_name, \n";    //����̾ 1
$sql .= "    t_goods.unit, \n";             //ñ�� 2
$sql .= "    t_contents.price, \n";         //ñ�� 3
$sql .= "    t_contents.stock_num, \n";     //Ģ��� 4
$sql .= "    t_contents.tstock_num, \n";    //��ê�� 5
//$sql .= "    t_contents.stock_num - t_contents.tstock_num AS diff_num, ";   //���� 6
$sql .= "    t_contents.tstock_num - t_contents.stock_num AS diff_num, \n";     //���� 6
$sql .= "    t_staff.staff_id, \n";         //ê���»ܼԥ����å�ID 7
$sql .= "    t_contents.cause, \n";         //���۸��� 8
$sql .= "    t_contents.add_flg, \n";       //�ɲåե饰 9
$sql .= "    t_contents.staff_name, \n";    //���ϼ�̾��������hidden�� 10
$sql .= "    t_contents.g_goods_cd, \n";    //�Ͷ�ʬ�����ɡ�������hidden��11
$sql .= "    t_contents.g_goods_name, \n";  //�Ͷ�ʬ̾��������hidden��12
$sql .= "    t_contents.g_product_cd, \n";  //����ʬ�ॳ���ɡ�������hidden��13
$sql .= "    t_contents.g_product_name, \n";//����ʬ��̾ 14
$sql .= "    t_contents.goods_cname, \n";   //����̾��ά�Ρˡ�������hidden��15
$sql .= "    t_contents.product_cd, \n";    //������ʬ�����ɡ�������hidden��16
$sql .= "    t_contents.product_name \n";   //������ʬ̾��������hidden��17
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

$disp_num = pg_num_rows($result);   //ɽ���Կ�

//HTML����
$array_db = Get_Data($result, 2);
//print_array($array_db, "DB����");
$array_size = count($array_db);

//print_array($del_history, "�������");


/****************************/
//�ե��������
/****************************/

//ê��Ĵ��ɽ�����������������ǡ���
//if($add_flg == "false"){

for($i=0, $no=$offset_line+1, $row_num=$offset_line+1; $i<$array_size+$max_row; $i++, $no++){

    //�����Ƚ��
    if(!in_array($no, $del_history)){

        //�������
        $del_data = ($del_row == "") ? $no : $del_row.",".$no;

        //�ե���������
        Draw_Row($add_flg, $no, $form, $select_value_staff, $select_reason, $del_data, $target_goods, $invent_id, $dialog_goods_url);


        //�ե�����˥ǡ����򥻥å�
        $disp_data[$no]       = $row_num;        //���ֹ�

        $def_data["form_g_product_name"][$no]   = $array_db[$i][14];    //����ʬ��
        $def_data["form_goods_cd"][$no]         = $array_db[$i][0];     //����CD
        $def_data["form_goods_name"][$no]       = $array_db[$i][1];     //����̾
        $def_data["form_unit"][$no]             = $array_db[$i][2];     //ñ��

        $price = explode(".", $array_db[$i][3]);
        $def_data["form_price"][$no]["i"]       = $price[0];            //�߸�ñ����������
        $def_data["form_price"][$no]["d"]       = $price[1];            //�߸�ñ���ʾ�����
        $def_data["form_stock_num"][$no]        = $array_db[$i][4];     //Ģ���
        $def_data["form_tstock_num"][$no]       = $array_db[$i][5];     //��ê��
        $def_data["form_diff_num"][$no]         = $array_db[$i][6];     //����


        //ê���»ܼ԰������
        if($staff_set !== null){
            //�ϰ���ιԤʤ�����
            if($line_start <= $row_num && $line_end >= $row_num){
                $staff_con_data["form_staff"][$no] = $staff_set;
            }
        //DB������ͤ�����
        }else{
            $def_data["form_staff"][$no] = $array_db[$i][7];
        }
        $def_data["form_cause"][$no] = array_search($array_db[$i][8], $select_reason);

        if($array_db[$i][13] == "t"){
            $def_data["form_g_product_name"][$no] = $array_db[$i][15];
        }

        //���ֹ��ܣ�
        $row_num = $row_num+1;

    }

}
//print_array($i, "�롼��");
//print_array($no, "���ֹ�");
//print_array($disp_data);


//���ɽ�����ڡ������ء����ɲá������󥯡����ء����ء���Ͽ���ƾ����ɲá������ɲá�Ĵ��ɽ���Ϥγƥܥ��󤬲����줿��硢
//�ʥڡ������إ��쥯�Ȥ�Ƚ�꤬�Ǥ��ʤ����ᡢ�嵭�ʳ��ξ���
//�������ԥե����������
if(!($_POST["goods_search_row"] != null || $_POST["form_conf_button"] != null || $_POST["form_entry_button"] != null)){
    //ê���»ܼ԰������ι��ֹ�˥��åȤ�����
    $con_data["form_line"]["start"] = $offset_line + 1;
    $con_data["form_line"]["end"]   = $row_num - 1;
}


$form->setDefaults($def_data);
$form->setConstants($staff_con_data);


$form->setConstants($con_data);



/****************************/
//������JavaScript
/****************************/
$html_js = <<<JS

<script langage="javascript">
<!--

function InD(row)
{
    var SN = "form_stock_num["+row+"]";
    var TN = "form_tstock_num["+row+"]";
    var DN = "form_diff_num["+row+"]";

    //��ê�������ͤξ�硢Ģ����Ȥκ���ɽ��
    if(isNaN(document.dateForm.elements[TN].value) == false && document.dateForm.elements[TN].value != ""){
        document.dateForm.elements[DN].value = document.dateForm.elements[TN].value - document.dateForm.elements[SN].value;

    //���ͤ���ʤ���硢����ɽ�����ʤ�
    }else{
        document.dateForm.elements[DN].value = "";
    }

    return true;
}

//-->
</script>

JS;



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
$page_header = Create_Header($page_title);



// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
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


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
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

    //�����Х��ѿ�
    global $g_form_option, $g_form_option_select, $g_form_style;

    //ReadOnly�ե����ॹ������
    $form_ro_style = "color: #555555; border: #ffffff 1px solid; background-color: #ffffff;";


    //����ʬ��
    $freeze_data = $form->addElement(
        "text", "form_g_product_name[$i]", "�ƥ����ȥե�����",
        "size=\"25\" maxLength=\"10\", readonly 
         style=\"$form_ro_style\""
    );

    //����CD
    $form->addElement(
        "text", "form_goods_cd[$i]", "�ƥ����ȥե�����",
        "size=\"10\" maxLength=\"8\", style=\"$g_form_style\" $g_form_option 
         onChange=\"javascript: goods_search_1(this.form, 'form_goods_cd', 'goods_search_row', $i);\""
    );

    //�����ɲùԤξ��ϡ�������󥯤�
    if($add_flg == "true"){
        $form->addElement("link","form_search[$i]","","#","����",
            " onClick=\"return Open_SubWin('".$dialog_goods_url."',Array('form_goods_cd[$i]','goods_search_row'),500,450,'2','$invent_id','$i');\""
        );
    }

    //����̾
    $form->addElement(
        "text", "form_goods_name[$i]", "�ƥ����ȥե�����",
        "size=\"70\" maxLength=\"35\", readonly"
    );

    //ñ��
    $form->addElement(
        "text", "form_unit[$i]", "�ƥ����ȥե�����",
        "size=\"5\" maxLength=\"5\", readonly 
         style=\"$form_ro_style\""
    );


    //����ʬ�ࡢñ�̤�ե꡼��
    $freeze_data = array(
        "form_g_product_name[$i]",
        "form_unit[$i]",
    );
    //�����ɲäιԤ���ʤ���硢����CD������̾��ե꡼��
    if($add_flg != "true"){
        $freeze_data[] = "form_goods_cd[$i]";
        $freeze_data[] = "form_goods_name[$i]";
    }
    $form->freeze($freeze_data);


    //�߸�ñ��
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


    //Ģ���
    $form->addElement("text", "form_stock_num[$i]", "�ƥ����ȥե�����", 
        "size=\"11\" maxLength=\"9\", readonly 
         style=\"text-align: right; $form_ro_style $g_form_style\""
    );

    //��ê��
    $form->addElement("text", "form_tstock_num[$i]", "�ƥ����ȥե�����", 
        "class=\"money\" size=\"11\" maxLength=\"9\", 
         $g_form_option style=\"text-align: right; $g_form_style\" onKeyup=\"return InD($i);\""
    );

    //����
    $form->addElement("text", "form_diff_num[$i]", "�ƥ����ȥե�����", 
        "size=\"11\" maxLength=\"9\", readonly 
         style=\"text-align: right; $form_ro_style $g_form_style\""
    );

    //ê���»ܼ�
    $form->addElement("select", "form_staff[$i]", "", $select_value_staff, $g_form_option_select);

    //���۸���
    $form->addElement("select", "form_cause[$i]", "", $select_reason, $g_form_option_select);

    //������
    //�߸˿�0�ξ��ϹԤ��ɲá�����Ϥʤ�
    if($target_goods != "�߸˿�0" && $add_flg == "true"){
        $form->addElement("link","add_row_del[$i]","","#","���",
            " onClick=\"javascript:return Dialogue_1('������ޤ���', '$del_data', 'del_row')\""
        );
    }

/*
    $add_flg = ($add_flg == "t") ? "true" : "false";
    $form->addElement("hidden", "form_add_flg[$i]", $add_flg);      //�ɲåե饰
*/

    return "";

}


?>
